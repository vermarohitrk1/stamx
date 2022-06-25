<?php

namespace App\Http\Controllers;

use App\AssessmentCategory;
use App\AssessmentForms;
use App\AssessmentQuestions;
use App\AssessmentResponses;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use DataTables;
use Carbon\Carbon;
class AssessmentController extends Controller {

    
    /*
     * Assessment Dashboard 
     */

    public function dashboard(Request $request) {
        $user = Auth::user();
        $title = "Assessments Dashboard";
               if ($request->ajax() && !empty($request->blockElementsData)) {
                if (!empty($request->duration)) {
                    $tilldate = Carbon::now()->addMonth($request->duration)->toDateTimeString();
                }
                
       
                     $my_total_forms = AssessmentForms::where('user_id', $user->id)->count();
        $active_assessments = AssessmentResponses::where('user_id', $user->id)->where('status', '0');
        if (!empty($tilldate)) {
                    $active_assessments->where("created_at", ">", $tilldate);
                }
                        $active_assessments=$active_assessments->count();
        $sent_assessments = AssessmentResponses::where('user_id', $user->id)->where('status', '1');
        if (!empty($tilldate)) {
                    $sent_assessments->where("created_at", ">", $tilldate);
                }
                        $sent_assessments=$sent_assessments->count();
        $earned_points = AssessmentResponses::where('user_id', $user->id);
           if (!empty($tilldate)) {
                    $earned_points->where("created_at", ">", $tilldate);
                }
                        $earned_points=$earned_points->sum("points");
      

        // form payments
        $total_amount_paid = 0;
        $total_amount_received = 0;
        $my_paid_forms = AssessmentForms::where('user_id', $user->id)->where('type', 'Paid')->get();
        foreach ($my_paid_forms as $row) {
            $total_payee = AssessmentForms::find($row->id)->responses->where('payment', '1')->where('form', $row->id);
        if (!empty($tilldate)) {
                    $total_payee->where("created_at", ">", $tilldate);
                }
                        $total_payee=$total_payee->count();
            $total_amount_received = $total_amount_received + ($row->amount * $total_payee);
        }
        $paid_forms = AssessmentResponses::where('user_id', $user->id)->where('payment', '1');
         if (!empty($tilldate)) {
                    $paid_forms->where("created_at", ">", $tilldate);
                }
                        $paid_forms=$paid_forms->pluck('form')->toArray();
        $total_amount_paid = AssessmentForms::whereIn('id', $paid_forms)->sum("amount");
     
        
        
                        return json_encode([
                    'active' => ($active_assessments),
                    'sent' => ($sent_assessments),
                    'points' => ($earned_points),
                    'paid' => format_price($total_amount_paid),
                    'earned' => format_price($total_amount_received),
                ]);
                
                
                
         }elseif ($request->ajax()) {  
               
                
            $data = AssessmentResponses::select("cf.*","assessmentresponses.user_id as r_user_id","assessmentresponses.response","assessmentresponses.id as r_id","assessmentresponses.form",'assessmentresponses.status')
                     ->join('assessmentforms as cf',"cf.id",'assessmentresponses.form')
                     ->where('assessmentresponses.user_id', $user->id)
                        ->orderBy('assessmentresponses.id', 'DESC');

             
            switch ($request->filter_type) {
                case "active":
                    $data->where('assessmentresponses.status', "0");
                    break;
                case "sent":
                    $data->where('assessmentresponses.status', "1");
                    break;
                default:
                    break;
            }

            //status
            if (!empty($request->filter_category)) {
                $data->where('cf.category', $request->filter_category);
            }

            //keyword
            if (!empty($request->keyword)) {
                $data->WhereRaw('(cf.title LIKE "%' . $request->keyword . '%" )');
            }
            return Datatables::of($data)
                ->addIndexColumn()
                ->filterColumn('form', function($query, $keyword) use ($request) {
                   // $query->WhereRaw('(subject LIKE %' . $keyword . '% OR ticket LIKE %'. $keyword . '%');
                    ;
                })
                ->addColumn('form', function ($data) {
                    if((!empty($data->type) && $data->type=="Free") ){
                      return '<div class="actions text-right">
                          <span class="badge badge-xs bg-warning-light mt-1" title="Category"  >
                                                   '. \App\AssessmentCategory::getcatname($data->category).'
                                                </span> <span class="badge badge-xs bg-success-light mt-1" title="Free"  >
                                                   Free
                                                </span><br>
                                                <a class="badge badge-sm bg-primary-light mt-1" title="View Assessment"  href="'.route("assessmentForm",encrypted_key($data->form,'encrypt')).'">
                                                   '.ucfirst(substr($data->title ,0,30)).'..
                                                </a>
                                                
                                            </div>';
                    }else{
                       return '<div class="actions text-right">
                            <span class="badge badge-xs badge-warning-light mt-1" title="Category"  >
                                                   '.\App\AssessmentCategory::getcatname($data->category).'
                                                </span> <span class="badge badge-xs bg-danger-light mt-1" title="Paid"  >
                                                    '. format_price($data->amount).'
                                                </span><br>
                                                <a class="badge badge-sm bg-primary-light mt-1" data-title="View Assessment And Make Payment"  href="'.route("assessmentForm",encrypted_key($data->form,'encrypt')).'">
                                                   '.ucfirst(substr($data->title ,0,30)).'..
                                                </a>
                                                
                                            </div>'; 
                    }
                 }) 
                ->addColumn('question', function ($row) {
                     return AssessmentForms::find($row->form)->questions->where('form', $row->form)->count();
                 }) 
                ->addColumn('points', function ($row) {
                   return AssessmentForms::find($row->form)->questions->where('form', $row->form)->sum("points");
                      
                 })  
                ->addColumn('sender', function ($data) {
                       
                       return '<h2 class="table-avatar">
                                                <a href="' . route('profile', ['id' => encrypted_key($data->user_id, 'encrypt')]) . '" class="avatar avatar-sm mr-2"><img class="avatar-img rounded-circle" src="' . $data->user->getAvatarUrl() . '" alt="Image"></a>
                                                <a href="' . route('profile', ['id' => encrypted_key($data->user_id, 'encrypt')]) . '">' . $data->user->name . '</a>
                                            </h2>';
                 }) 
                ->addColumn('response', function ($row) {
                     $res= AssessmentForms::find($row->form)->responses->where('status', 1)->where('form', $row->form)->count();
                     if(!empty($res)){
                         $user = Auth::user();
                      $res= '<div class="actions ">
                                                <a class="btn btn-sm bg-success-light" title="View My Response"  data-title="View My Response"  data-ajax-popup="true" data-size="md" data-url="'.route('assessmentForm.response',['id'=>encrypted_key($row->form,'encrypt'),'user_id'=>encrypted_key($user->id,'encrypt')]).'" href="#">
                                                    '.$res.'
                                                </a>
                                            </div>';
                     }
                      return $res;
                 }) 
              
                ->addColumn('type', function ($data) {
                      
                    $status=(!empty($data->status))?'Send':'Active';
                    $class=(!empty($data->status))?'success':'warning';

                 $slots= '<span class="badge  badge-xs bg-'.$class.'-light"> '.$status.'</span>';
                  
                 
                 return $slots;
                 }) 
                
              
                ->rawColumns(['form','question','sender','response','action','type','points'])
                ->make(true);
        }else{
        $my_total_forms = AssessmentForms::where('user_id', $user->id)->count();
        $active_assessments = AssessmentResponses::where('user_id', $user->id)->where('status', '0')->count();
        $sent_assessments = AssessmentResponses::where('user_id', $user->id)->where('status', '1')->count();
        $earned_points = AssessmentResponses::where('user_id', $user->id)->sum("points");
      

        // form payments
        $total_amount_paid = 0;
        $total_amount_received = 0;
        $my_paid_forms = AssessmentForms::where('user_id', $user->id)->where('type', 'Paid')->get();
        foreach ($my_paid_forms as $row) {
            $total_payee = AssessmentForms::find($row->id)->responses->where('payment', '1')->where('form', $row->id)->count();
            $total_amount_received = $total_amount_received + ($row->amount * $total_payee);
        }
        $paid_forms = AssessmentResponses::where('user_id', $user->id)->where('payment', '1')->pluck('form')->toArray();
        $total_amount_paid = AssessmentForms::whereIn('id', $paid_forms)->sum("amount");
        $categories = AssessmentCategory::get();

        return view('assessment.dashboard', compact( 'categories','title', 'my_total_forms', 'active_assessments', 'sent_assessments', 'total_amount_received', 'total_amount_paid','earned_points'));
    }
    }

    /*
     * All Assessment Categories List 
     */

    public function getcategory() {
        $user = Auth::user();
        $categories = AssessmentCategory::get();
        return $categories;
    }

    /*
     * Assessment Form Listing
     */

    public function index($view = 'grid') {
        $user = Auth::user();
//          if (!in_array("manage_assessments", permissions()) && $user->type !="admin") {
//            return redirect()->back()->with('error', __('Permission Denied.'));
//        }
             $categories = AssessmentCategory::get();
            return view('assessment.index', compact('categories'));
      
    }

    public function published($views = null,Request $request) {
        $user = Auth::user();
        $authuser = $user;
        if (isset($_GET['views'])) {
            $typeview = $_GET['views'];
        } else {
            $typeview = null;
        }
//        if ($request->ajax()) {  
//            $data = AssessmentResponses::where('user_id', $user->id)->where('status', '0')
//            ->orderBy('id', 'DESC');
//            return Datatables::of($data)
//                ->addIndexColumn()
//                // ->filterColumn('title', function($query, $keyword) use ($request) {
//                //     $query->orWhere('assessmentforms.title', 'LIKE', '%' . $keyword . '%')
//                //    ;
//                // })
//              
//                ->addColumn('form_user_details', function ($data) {
//                      $data->form_details = AssessmentForms::where('id', $data->form)->first();
//                if (!empty($data->form_details->id)) {                 
//                    $data->form_user_details = \App\User::find($data->form_details->user_id)->name;
//                }else{
//                  $data->form_user_details='';  
//                }
//                    return
//                    date('M d, Y', strtotime($data->created_at));
//                   ' <br>'.
//                    '<span>'. $data->form_user_details .' </span>';
//
//                 }) 
//                ->addColumn('title', function ($data) {  
//                      $data->form_details = AssessmentForms::where('id', $data->form)->first();
//               
//                    return 
//                        '<small class="mt-5">'.ucfirst(substr($data->form_details->title ,0,35)) .'...</small>';
//                }) 
//
//                ->addColumn('form_questions', function ($data) {
//                      $data->form_details = AssessmentForms::where('id', $data->form)->first();
//                if (!empty($data->form_details->id)) {
//                    $data->form_questions = AssessmentForms::find($data->form)->questions->where('form', $data->form)->count();
//               }else{
//                   $data->form_questions='';
//               }
//                    return  $data->form_questions        
//                    ;       
//                })
//
//
//
//                ->addColumn('form_responses', function ($data) {
//
//  $data->form_details = AssessmentForms::where('id', $data->form)->first();
//                if (!empty($data->form_details->id)) {
//                   $data->form_responses = AssessmentForms::find($data->form)->responses->where('status', 1)->where('form', $data->form)->count();
//                }
//                  if(!empty($data->form_responses)){
//                    $a =' <a href="'.route('assessmentForm.response',['id' => encrypted_key($data->form_details->id,'encrypt'), 'user_id' => encrypted_key(Auth::user()->id,'encrypt')]).'" data-toggle="tooltip" data-original-title="'.__('View My Response').'">
//                    '. $data->form_responses .'
//                    </a>';
//                  }else{
//                    $a = '';
//                  }
//                  return $a;
//                      
//                })
//
//                ->addColumn('form_points', function ($data) {
//                      $data->form_details = AssessmentForms::where('id', $data->form)->first();
//                if (!empty($data->form_details->id)) {
//                    $data->form_points = AssessmentForms::find($data->form)->questions->where('form', $data->form)->sum("points");
//                 }else{
//                     $data->form_points ='';
//                 }
//                    return  $data->form_points;       
//                })
//
//
//
//                ->addColumn('action', function($data){
//                     $data->form_details = AssessmentForms::where('id', $data->form)->first();
//               
//                    if((!empty($data->form_details->type) && $data->form_details->type=="Free") || $typeview!="active"){
//                                     
//                           $action =   ' <a href="'.route('assessmentForm',encrypted_key($data->form_details->id,'encrypt')).'" class="btn btn-sm btn-success btn-icon rounded-pill mr-1 ml-1" data-toggle="tooltip" data-original-title="'.__('View Assessment').'">
//                                        <small class="btn-inner--text ">'.__('View Assessment').'</small>
//                                    </a> ';
//
//                               } else{
//                         $action =  ' <a href="'.route('assessmentForm',encrypted_key($data->form_details->id,'encrypt')).'" class="btn btn-sm btn-success btn-icon rounded-pill mr-1 ml-1" data-toggle="tooltip" data-original-title="'.__('View Assessment And Make Payment').'">
//                         <small class="btn-inner--text ">'.__('View Assessment').'</small>
//                         </a>
//
//                                    ';
//                                  }
//                     return $action;
//                   
//                })
//                ->rawColumns(['action'])
//                ->make(true);
//                return view('assessment.dashboardlist');
//        }else{
            if (empty($typeview) || $typeview == "active") {
                $data = AssessmentResponses::where('user_id', $user->id)->where('status', '0')
                        ->orderBy('id', 'DESC')
                        ->paginate(6);
               
                foreach ($data as $row) {
                    $row->form_details = AssessmentForms::where('id', $row->form)->first();
                    if (!empty($row->form_details->id)) {
                        $row->form_points = AssessmentForms::find($row->form)->questions->where('form', $row->form)->sum("points");
                        $row->form_questions = AssessmentForms::find($row->form)->questions->where('form', $row->form)->count();
                        $row->form_responses = AssessmentForms::find($row->form)->responses->where('status', 1)->where('form', $row->form)->count();
                        $row->form_category_name = AssessmentForms::find($row->form)->forms->name;                   
                        $row->form_user_details = \App\User::find($row->form_details->user_id)->name;
                    }
                }
    
                $typeview = "active";
            } else {
                $data = AssessmentResponses::where('user_id', $user->id)->where('status', '1')
                        ->orderBy('id', 'DESC')
                        ->paginate(6);
                foreach ($data as $row) {
                    $row->form_details = AssessmentForms::where('id', $row->form)->first();
                    if (!empty($row->form_details->id)) {
                        $row->form_points = AssessmentForms::find($row->form)->questions->where('form', $row->form)->sum("points");
                        $row->form_questions = AssessmentForms::find($row->form)->questions->where('form', $row->form)->count();
                        $row->form_responses = AssessmentForms::find($row->form)->responses->where('status', 1)->where('form', $row->form)->count();
                        $row->form_category_name = AssessmentForms::find($row->form)->forms->name;
                         $row->form_user_details = \App\User::find($row->form_details->user_id)->name;
                    }
                }
                $typeview = "sent";
            }
           
            return view('assessment.dashboardlist', compact('typeview', 'data'));
//        }  
    }

    public function view($view = 'grid', Request $request) {
       $user = Auth::user();
         $permissions=permissions();
        if ($request->ajax()) {  
            $data = AssessmentForms::orderBy('id', 'DESC');
            $data->where('user_id', $user->id);
            
//             if(in_array("manage_surveys",$permissions) || $user->type =="admin") {
//            $domain_user= get_domain_user ();
//            //$data->whereRaw("(user_id={$user->id} OR user_id={$domain_user->id})");
//            
//            }else{
//                $data->where('user_id', $user->id);
//            }
             if (!empty($request->filter_category)) {
                $data->where('assessmentforms.category', $request->filter_category);
            }

            //keyword
            if (!empty($request->keyword)) {
                $data->WhereRaw('(assessmentforms.title LIKE "%' . $request->keyword . '%" )');
            }
            return Datatables::of($data)
                ->addIndexColumn()
                ->filterColumn('title', function($query, $keyword) use ($request) {
                    $query->orWhere('assessmentforms.title', 'LIKE', '%' . $keyword . '%')
                   ;
                })
              
                ->addColumn('points', function ($row) {
                   
                    return  AssessmentForms::find($row->id)->questions->where('form', $row->id)->sum("points");

                 }) 
                ->addColumn('category_name', function ($data) {
                    return 
                    AssessmentForms::find($data->id)->forms->name;

                 }) 
                ->addColumn('title', function ($data) {     
                    return   '<span class="badge  badge-xs bg-primary-light"> '.$data->type.": ".format_price($data->amount).'</span><br> <small class="mt-5">'. ucfirst(substr($data->title ,0,35)) .'......<a href="'.route('assessmentForm',encrypted_key($data->id,'encrypt')).'"> '.__('See more').'</a> </small>';


                }) 

                ->addColumn('questions', function ($data) {
                    return  AssessmentForms::find($data->id)->questions->where('form', $data->id)->count()         
                    ;       
                })

                ->addColumn('responses', function ($data) {
                    return  AssessmentForms::find($data->id)->responses->where('status', 1)->where('form', $data->id)->count();       
                })


                ->addColumn('action', function($data){
                    $user = Auth::user();
                  if($user->id != $data->user_id){
                        $actionBtn = '
                    <a href="'.route('assessmentForm',encrypted_key($data->id,'encrypt')).'" class="action-item px-2" data-toggle="tooltip" data-original-title="'.__('View').'">
                    <i class="fas fa-eye"></i>
                </a>
                ';
                  }else{
                    
                    $actionBtn = '
                    <a href="'.route('assessmentForm',encrypted_key($data->id,'encrypt')).'" class="action-item px-2" data-toggle="tooltip" data-original-title="'.__('View').'">
                    <i class="fas fa-eye"></i>
                </a>
                <a href="'.route('assessment.edit',encrypted_key($data->id,'encrypt')).'" class="action-item px-2" data-toggle="tooltip" data-original-title="'.__('Edit').'">
                    <i class="fas fa-edit"></i>
                </a>
                
                ';
                    
                         $actionBtn .= '<a data-url="' . route('assessment.destroy',encrypted_key($data->id,'encrypt')) . '" href="#" class="btn btn-sm text-danger  px-2 delete_record_model">
                                                    <i class="far fa-trash-alt"></i> 
                                                </a>';
                  }

                    return $actionBtn;
                })
                ->rawColumns(['action','title'])
                ->make(true);
        }else{
            $title = "Assessments Forms";
            $data = AssessmentForms::where('user_id', $user->id)
                    ->orderBy('id', 'DESC')
                    ->paginate(6);
            foreach ($data as $row) {
                $row->points = AssessmentForms::find($row->id)->questions->where('form', $row->id)->sum("points");
                $row->questions = AssessmentForms::find($row->id)->questions->where('form', $row->id)->count();
                $row->responses = AssessmentForms::find($row->id)->responses->where('status', 1)->where('form', $row->id)->count();
                $row->category_name = AssessmentForms::find($row->id)->forms->name;
            }
    
    
            if (isset($_GET['view'])) {
                $view = 'list';
                $returnHTML = view('assessment.list', compact('view', 'data', 'title'))->render();
            } else {
    
                $returnHTML = view('assessment.grid', compact('view', 'data', 'title'))->render();
            }
    
            return response()->json(
                            [
                                'success' => true,
                                'html' => $returnHTML,
                            ]
            );
        } 
    }

    /*
     *  Create Assessment Form
     */

    public function form_create() {
        $user = Auth::user();
        if (!empty($user->type) && $user->type != 'user') {
            $title = "Create Assesment Form";
            $categories = self::getcategory();
            return view('assessment.create_form', compact('title', 'categories'));
        } else {
            return redirect()->route('assessment.index')->with('error', __('Permission Denied.'));
        }
    }

    /*
     *   Edit Assessment Form
     */

    public function edit($id_encrypted = 0) {
        $user = Auth::user();
        $id = !empty($id_encrypted) ? encrypted_key($id_encrypted, 'decrypt') : 0;
        if (!empty($id)) {
            $title = "Edit Assessment Form";
            $data = AssessmentForms::where('id', $id)->where('user_id', $user->id)->first();
            if (!empty($data->id)) {
                $categories = self::getcategory();
                return view('assessment.create_form', compact('title', 'data', 'categories'));
            }
        }
        return redirect()->route('assessment.index')->with('error', __('Permission Denied.'));
    }

    /*
     *   Store Assessment Form
     */

    public function store(Request $request) {
        $user = Auth::user();
        $title = "Assessment Form";
        $validation = [
            'title' => 'required|max:255|min:2',
            'type' => 'required',
            'category' => 'required',
            'description' => 'required|max:500|min:5',
        ];
        if (!empty($request->type) && $request->type == "Paid") {
            $validation['amount'] = 'required';
        } else {
            $request->amount = 0.00;
        }
        $validator = Validator::make(
                        $request->all(), $validation
        );

        if ($validator->fails()) {
            return redirect()->back()->withInput()->withErrors($validator);
        }

        $id = !empty($request->id) ? encrypted_key($request->id, 'decrypt') : 0;
        if (!empty($id)) {
            $data = AssessmentForms::where('id', $id)->where('user_id', $user->id)->first();
            $post['user_id'] = $user->id;
            $post['title'] = $request->title;
            $post['type'] = $request->type;
            $post['amount'] = $request->amount;
            $post['category'] = $request->category;
            $post['description'] = $request->description;
            $data->update($post);
            return redirect()->route('assessment.index')->with('success', __('Assessment form updated successfully.'));
        } else {
            $data = new AssessmentForms();
            $data['user_id'] = $user->id;
            $data['title'] = $request->title;
            $data['type'] = $request->type;
            $data['amount'] = $request->amount;
            $data['category'] = $request->category;
            $data['description'] = $request->description;
            $data->save();
            return redirect()->route('assessment.index')->with('success', __('Assessment form added successfully.'));
        }
    }

    /*
     *   Destroy Assessment Form
     */

    public function destroy($id=0) {
        $user = Auth::user();
        $id = !empty($id) ? encrypted_key($id, 'decrypt') : 0;
        if (!empty($id)) {
            $data = AssessmentForms::where('id', $id)->where('user_id', $user->id)->first();
            if (!empty($data->id))
                $data->delete();

            $questions = AssessmentQuestions::where('form', $id)->get();
            if (!empty($questions->id))
                $questions->delete();

            $responses = AssessmentResponses::where('form', $id)->get();
            if (!empty($responses->id))
                $responses->delete();

            return redirect()->back()->with('success', __('Assessment form and related data deleted successfully.'));
        } else {
            return redirect()->back()->with('error', __('Permission Denied.'));
        }
    }

    /*
     *   Assessment Form Questions
     */

    public function questions($id_encrypted = 0) {
        $user = Auth::user();
        $id = !empty($id_encrypted) ? encrypted_key($id_encrypted, 'decrypt') : 0;
        if (!empty($id) && !empty($user->type) && $user->type != 'user') {
            $title = "Assessment Form Questions";
            $form = AssessmentForms::where('id', $id)->where('user_id', $user->id)->first();
            $questions = AssessmentQuestions::where('form', $id)->where('user_id', $user->id)->orderBy('indexing', "ASC")->get();

            if (!empty($form->id)) {
                return view('assessment.questions_list', compact('title', 'form', 'questions', 'id'));
            } else {
                return redirect()->back()->with('error', __('Permission Denied.'));
            }
        }
        return redirect()->back()->with('error', __('Permission Denied.'));
    }

    /*
     * All Assessment Questions Types List 
     */

    public function questions_types() {
        $types = array(
            "text" => "Text",
            "number" => "Number",
            "email" => "Email",
            "date" => "Date",
            "url" => "Url",
            "select" => "Select"
        );
        return $types;
    }

    /*
     *  Assessment Form Add Question
     */

    public function question_create($form_id_encrypted = 0) {
        $user = Auth::user();
        $form_id = !empty($form_id_encrypted) ? encrypted_key($form_id_encrypted, 'decrypt') : 0;
        if (!empty($form_id) && !empty($user->type) && $user->type != 'user') {
            $title = "Add Form Question";
            $form = AssessmentForms::where('id', $form_id)->where('user_id', $user->id)->first();
            $question_types = self::questions_types();
            return view('assessment.question_form', compact('title', 'form_id', 'question_types', 'form'));
        } else {
            return redirect()->back()->with('error', __('Permission Denied.'));
        }
    }

    /*
     *  Assessment Form Update Question
     */

    public function question_edit($form_id_encrypted = 0, $id_encrypted = 0) {
        $user = Auth::user();
        $form_id = !empty($form_id_encrypted) ? encrypted_key($form_id_encrypted, 'decrypt') : 0;
        $id = !empty($id_encrypted) ? encrypted_key($id_encrypted, 'decrypt') : 0;
        if (!empty($id) && !empty($form_id) && !empty($user->type) && $user->type != 'user') {
            $title = "Update Assesment Form Question";
            $form = AssessmentForms::where('id', $form_id)->where('user_id', $user->id)->first();
            $data = AssessmentQuestions::where('id', $id)->where('user_id', $user->id)->first();
            $question_types = self::questions_types();
            return view('assessment.question_form', compact('title', 'data', 'form_id', 'question_types', 'form'));
        } else {
            return redirect()->back()->with('error', __('Permission Denied.'));
        }
    }

    /*
     *   Store Assessment Form Question
     */

    public function question_store(Request $request) {
        $user = Auth::user();
        $form_id = !empty($request->form_id) ? encrypted_key($request->form_id, 'decrypt') : 0;
        if (!empty($form_id) && !empty($user->type) && $user->type != 'user') {
            $title = "Assessment Form Question";
            $validation = [
                'question' => 'required|max:255|min:2',
                'type' => 'required',
            ];
            if (!empty($request->type) && $request->type == "select") {
                $validation['options'] = 'required|max:255|min:2';
            }
            $validator = Validator::make(
                            $request->all(), $validation
            );

            if ($validator->fails()) {
                return redirect()->back()->withInput()->withErrors($validator);
            }

            $id = !empty($request->id) ? encrypted_key($request->id, 'decrypt') : 0;
            if (!empty($id)) {
                $data = AssessmentQuestions::where('id', $id)->where('user_id', $user->id)->first();
                $post['form'] = $form_id;
                $post['user_id'] = $user->id;
                $post['question'] = $request->question;
                $post['type'] = $request->type;
                $post['points'] = !empty($request->points) ? $request->points : 0;
                $post['options'] = $request->options;
                $data->update($post);
                return redirect()->route('assessmentQuestion', $request->form_id)->with('success', __('Form question updated successfully.'));
            } else {
                $data = new AssessmentQuestions();
                $data['form'] = $form_id;
                $data['user_id'] = $user->id;
                $data['question'] = $request->question;
                $data['type'] = $request->type;
                $data['points'] = !empty($request->points) ? $request->points : 0;
                $data['options'] = $request->options;
                $data->save();
                return redirect()->route('assessmentQuestion', $request->form_id)->with('success', __('Form question added successfully.'));
            }
        } else {
            return redirect()->back()->with('error', __('Permission Denied.'));
        }
    }

    /*
     *   Destroy Assessment Form Question
     */

    public function question_destroy($id=0) {
        $user = Auth::user();
          $id = !empty($id) ? encrypted_key($id, 'decrypt') : 0;
        if (!empty($id)) {
            $data = AssessmentQuestions::where('id', $id)->first();
            $data->delete();
            return redirect()->back()->with('success', __('Question deleted successfully.'));
        } else {
            return redirect()->back()->with('error', __('Permission Denied.'));
        }
    }

    /**
     *  questions indexing
     * 
     * @return Json
     */
    public function indexing(Request $request) {
        $post = $request->post();
        $user = Auth::user();
        $i = 1;
             unset($post['_token']);
        foreach ($post as $q => $order) {
            $question_id = explode(":", $q);
            $data = AssessmentQuestions::where('id', $question_id[1])->first();
            $place['indexing'] = $i;
            $data->update($place);
            $i++;
        }
        return;
    }

    /*
     *   Assessment Form
     */

    public function form($id_encrypted = 0) {
        $user = Auth::user();
        $title = "Assessment";
        $assigned = false;
        $id = !empty($id_encrypted) ? encrypted_key($id_encrypted, 'decrypt') : 0;
               
        if (!empty($id)) {

            /*
             *  Check Assignment Permission 
             *  Start 
             */
            $form = AssessmentForms::where('id', $id)->first();
            $form_response = AssessmentForms::find($id)->responses->where('form', $id)->where('user_id', $user->id)->first();
            $questions = AssessmentQuestions::where('form', $id)->orderBy('indexing', 'DESC')->get();
            
            if (!empty($form->id) && !empty($form_response->id)) { //if form is valid and form is assigned to user
                if ($form->type == "Free" || !empty($form_response->payment)) { //free form is assigned or user has made payment
                    $assigned = true;
                    return view('assessment.form', compact('title', 'form', 'questions', 'id', 'assigned', 'form_response'));
                }else{                  
                     return view('assessment.payment', compact('title', 'form', 'questions', 'id', 'assigned', 'form_response'));
                }
            }
            /*
             *  Check Assignment Permission 
             *  End 
             */

            /*
             *  Form owner (user will not be owner)
             *  Start 
             */
            if (!empty($user->type) && $user->type != 'user') {
                $form = AssessmentForms::where('id', $id)->where('user_id', $user->id)->first();
                $questions = AssessmentQuestions::where('form', $id)->where('user_id', $user->id)->orderBy('indexing', 'DESC')->get();
               if (!empty($form->id)) {
               
                    return view('assessment.form', compact('title', 'form', 'questions', 'id', 'assigned', 'form_response'));
                }
                //for coach and caseworker role
                if(empty($form->id) && in_array($user->type, ["caseworker","coach"])){
                     $form = AssessmentForms::where('id', $id)->first();
                $questions = AssessmentQuestions::where('form', $id)->orderBy('indexing', 'DESC')->get();
               if (!empty($form->id)) {
               $only_response=1;
                    return view('assessment.form', compact('title', 'form', 'questions', 'id', 'assigned', 'form_response','only_response'));
                }
                }
            }
            /*
             *  Form Owner
             *  End 
             */
        }

        return redirect()->back()->with('error', __('Permission Denied.'));
    }

    /*
     *   Assessment Form Response
     */

    public function form_response($id_encrypted = 0, $user_id_encrypted) {
       
        $user = Auth::user();
        $title = "Assessment Response";
        $assigned = false;
        $id = !empty($id_encrypted) ? encrypted_key($id_encrypted, 'decrypt') : 0;
        $user_id = !empty($user_id_encrypted) ? encrypted_key($user_id_encrypted, 'decrypt') : 0;
           
        if (!empty($id) && !empty($user_id)) {
            $form = AssessmentForms::where('id', $id)->first();
          
            $response = AssessmentForms::find($id)->responses->where('form', $id)->where('user_id', $user_id)->first();
            $response_by_user = \App\User::find($user_id)->name;
          
            return view('assessment.form_single_response', compact('title', 'response', 'form', 'id', 'response_by_user', 'user_id'));
        }
        return redirect()->back()->with('error', __('Permission Denied.'));
    }
    public function form_show_response($id_encrypted = 0, $user_id_encrypted) {
       
        $user = Auth::user();
        $title = "Assessment Response";
        $assigned = false;
        $id = !empty($id_encrypted) ? encrypted_key($id_encrypted, 'decrypt') : 0;
        $user_id = !empty($user_id_encrypted) ? encrypted_key($user_id_encrypted, 'decrypt') : 0;
           
        if (!empty($id) && !empty($user_id)) {
            $form = AssessmentForms::where('id', $id)->first();
          
            $response = AssessmentForms::find($id)->responses->where('form', $id)->where('user_id', $user_id)->first();
            $response_by_user = \App\User::find($user_id)->name;
          
            return view('assessment.form_response', compact('title', 'response', 'form', 'id', 'response_by_user', 'user_id'));
        }
        return redirect()->back()->with('error', __('Permission Denied.'));
    }

    /*
     *   Store Assessment Form Responses
     */

    public function form_store(Request $request) {
       
        $user = Auth::user();
        $title = "Assessment Form Store";
        $data = array();
        $id = !empty($request->id) ? encrypted_key($request->id, 'decrypt') : 0;
        if (!empty($id)) {
            /*
             *  Check Assignment Permission 
             *  Start 
             */
            $form = AssessmentForms::where('id', $id)->first();
            $form_response = AssessmentForms::find($id)->responses->where('form', $id)->where('user_id', $user->id)->first();
            $questions = AssessmentQuestions::where('form', $id)->orderBy('indexing', 'DESC')->get();
            if (!empty($form->id) && !empty($form_response->id)) { //if form is valid and form is assigned to user
                if ($form->type == "Free" || !empty($form_response->payment)) { //free form is assigned or user has made payment
                    $assigned = true;
                    $validation = array();
                    $validation_message = array();

                    foreach ($questions as $row) {
                        $encrypted_question_id = encrypted_key($row->id, 'encrypt');
                        $data["response"][] = array("question" => trim($row->question), "points" => trim($row->points), "answer" => trim($request->$encrypted_question_id));
                        $validation[$encrypted_question_id] = 'required|max:255';
                        $validation_message[$encrypted_question_id . '.required'] = $row->question . ' field is required';
                        $validation_message[$encrypted_question_id . '.max'] = $row->question . ' field allowed limit is 255 characters';
                    }

                    $validator = Validator::make(
                                    $request->all(), $validation, $validation_message
                    );
                    if ($validator->fails()) {
                        return redirect()->back()->withInput()->withErrors($validator);
                    }

                    $data["status"] = "1";
                    $data["response"] = json_encode($data["response"]);
                    $data["points"] = AssessmentForms::find($id)->questions->where('form', $id)->sum("points");

                    $AssessmentResponses = AssessmentResponses::where('form', $id)->where('user_id', $user->id)->first();
                    $AssessmentResponses->update($data);
                 
                    return redirect()->route('assessmentFormshow.response', ['id' => $request->id, 'user_id' => encrypted_key($user->id,'encrypt')])->with('success', __('Form responses submitted successfully.'));
                }
            }
            /*
             *  Check Assignment Permission 
             *  End 
             */
        }
        return redirect()->back()->with('error', __('Permission Denied.'));
    }

    /*
     *   Form Sidebar
     */

    public function form_sidebar($id_encrypted = 0) {
        $user = Auth::user();
        $form = '';
        $form_response = '';
        $form_questions = '';
        $sidebar = '';
        if (isset($_GET['sidebar'])) {
            $sidebar = $_GET['sidebar'];
        }
        $id = !empty($id_encrypted) ? encrypted_key($id_encrypted, 'decrypt') : 0;
        if (!empty($id)) {
            $form = AssessmentForms::where('id', $id)->first();
            $form_response = AssessmentForms::find($id)->responses->where('form', $id)->where('user_id', $user->id)->first();
//            $form_questions = AssessmentQuestions::where('form', $id)->orderBy('indexing', 'DESC')->get();
        }
        return view('assessment.form_sidebar', compact('id', 'form', 'form_response', 'form_questions', 'sidebar'));
    }

    /*
     *   Assessment Form Users Responses
     */
public function form_user_response($id_encrypted = 0) {
        $user = Auth::user();
        $title = "Crm Response";
        $assigned = false;
        $id = !empty($id_encrypted) ? encrypted_key($id_encrypted, 'decrypt') : 0;
       
        if (!empty($id)) {
            $response = CrmCustomFormResponses::find($id);   
           
            $form = CrmCustomForms::where('id', $response->form_id)->first();
            $response_by_user = \App\User::find($response->user_id)->name;
            $user_id=$response->user_id;
            return view('contacts.customforms.form_response', compact('title', 'response', 'form', 'id', 'response_by_user', 'user_id'));
        }
        return redirect()->back()->with('error', __('Permission Denied.'));
    }
    public function form_users_responses(Request $request, $id_encrypted = 0) {
        $user = Auth::user();
        $permissions=permissions();
        $id = !empty($id_encrypted) ? encrypted_key($id_encrypted, 'decrypt') : 0;
        if (!empty($id) ) {
            $title = "Form Users Responses";
           
       
              $form = AssessmentForms::where('id', $id)->first();
         
                
                $user = Auth::user();       
         if ($request->ajax()) {
             
             
            $data = AssessmentResponses::leftjoin('assessmentforms as cf','cf.id','assessmentresponses.form')
                    ->leftjoin('users as u','u.id','assessmentresponses.user_id')
                    ->select('assessmentresponses.*','u.name','cf.user_id as f_user_id')
                    ->where('assessmentresponses.form', $id)
                    ->whereRaw('(assessmentresponses.user_id='.$user->id.' or cf.user_id='.$user->id.')')
                    ->orderByDesc('id');
         
            
            return Datatables::of($data)
                ->addIndexColumn()
                    ->filterColumn('user', function ($query, $keyword) use ($request) {
                    $sql = " u.name like ?";
                    $query->whereRaw($sql, ["%{$keyword}%"]);
                })
                ->addColumn('user', function ($data) {
                     return '<h2 class="table-avatar">
                                                <a href="' . route('profile', ['id' => encrypted_key($data->user_id, 'encrypt')]) . '" class="avatar avatar-sm mr-2"><img class="avatar-img rounded-circle" src="' . $data->user->getAvatarUrl() . '" alt="Image"></a>
                                                <a href="' . route('profile', ['id' => encrypted_key($data->user_id, 'encrypt')]) . '">' . $data->name . '</a>
                                            </h2>';
                
                 }) 
                ->addColumn('date', function ($data) {
                    return date('M d, Y', strtotime($data->created_at));
                 }) 
                ->addColumn('status', function ($data) {
                    return ' <p class="text-dark">'.((!empty($data->status)) ? '<span class="badge badge-success badge-xs badge-pill">Filled</span>' :'<span class="badge badge-danger badge-xs badge-pill">Not Filled</span></p>');
                 }) 
                ->addColumn('payment', function ($data) {
                    return ' '.((!empty($data->payment)) ? '<p class="text-dark"><span class="badge badge-success badge-xs badge-pill">Paid</span></p>' :'0');
                 }) 
                
                                 
              ->addColumn('action', function($data){
                  $user = Auth::user();  
                    $idquoted="'".encrypted_key($data->id,'encrypt')."'";
                    $actionBtn = '
                        <a href="#" class="text-primary px-2" data-url="'.route('assessmentForm.response',['id'=>encrypted_key($data->form,'encrypt'),'user_id'=>encrypted_key($data->user_id,'encrypt')]).'" data-ajax-popup="true" data-size="lg" data-title="User Response">
        <span class="btn-inner--icon"><i class="fas fa-eye"></i></span>
    </a>';
    
                    if($data->f_user_id==$user->id){
     $actionBtn .= '<a data-url="' . route('assessmentResponse.destroy',encrypted_key($data->id,'encrypt')) . '" href="#" class="btn btn-sm text-danger px-2 delete_record_model">
                                                    <i class="far fa-trash-alt"></i> 
                                                </a>
                 ';
                    }
                return $actionBtn;
            })
                ->rawColumns(['user','date','action','status'])
                ->make(true);
        }else{
             return view('assessment.users_responses_list', compact('title', 'form', 'id'));
        }
        return redirect()->back()->with('error', __('Permission Denied.'));
        }
        
    }

    /*
     *   Destroy Assessment Form User Response
     */

    public function form_users_responses_destroy($id=0) {
        $user = Auth::user();
         $id = !empty($id) ? encrypted_key($id, 'decrypt') : 0;
        if (!empty($id)) {
            $data = AssessmentResponses::where('id', $id)->first();
            $data->delete();
            return redirect()->back()->with('success', __('Response deleted successfully.'));
        } else {
            return redirect()->back()->with('error', __('Permission Denied.'));
        }
    }

    /*
     *  Assessment Form Assign
     */

    public function form_assign($form_id_encrypted = 0) {
        $user = Auth::user();
        $form_id = !empty($form_id_encrypted) ? encrypted_key($form_id_encrypted, 'decrypt') : 0;
        if (!empty($form_id)) {
            $title = "Assign Assessment Form";
            $form = AssessmentForms::where('id', $form_id)->where('user_id', $user->id)->first();
           
//            $usr_contact = $user->contacts();
//            $usr_contact = $usr_contact->pluck('user_id')->toArray();
//            $users = \App\User::whereIn('id', $usr_contact);
//            $users = $users->where('id', '!=', $user->id)->get();
//            
            $users = \App\User::OrderBy('id','DESC')
                            ->select('users.*');
            $domain_user= get_domain_user();
         $users->where("created_by", $domain_user->id);
           $users=$users->get();
            
            if (!empty($form->id)) {
                return view('assessment.form_assign', compact('title', 'form_id', 'users', 'form'));
            }
        }
        return redirect()->back()->with('error', __('Permission Denied.'));
    }

    /*
     *   Store Assessment Form Assigns
     */

    public function assign_store(Request $request) {
        $user = Auth::user();
        $form_id = !empty($request->form_id) ? encrypted_key($request->form_id, 'decrypt') : 0;
        if (!empty($form_id) && !empty($user->type) && $user->type != 'user') {
            $title = "Assessment Form Assign";
            $validation = [
                'users' => 'required|min:1',
            ];
            $validator = Validator::make(
                            $request->all(), $validation
            );

            if ($validator->fails()) {
                return redirect()->back()->withInput()->withErrors($validator);
            }
            $post = array();
            $post['form'] = $form_id;
            $form= \App\AssessmentForms::find($form_id);
            foreach ($request->users as $encrypted_user_id) {
                $user_id = !empty($encrypted_user_id) ? encrypted_key($encrypted_user_id, 'decrypt') : 0;
                $post['user_id'] = $user_id;
                if (!empty($user_id)) {
                    $data = AssessmentResponses::where('user_id', $post['user_id'])->where('form', $post['form'])->first();
                    if (empty($data->id)) {
                        $save = new AssessmentResponses();
                        $save['user_id'] = $post['user_id'];
                        $save['form'] = $post['form'];
                        $save->save();
                    }
                    
                    $user_details=\App\User::find($user_id);
                    
                    $emailbody=[
                'Assessment'=>$form->title,
                'Amount'=> format_price($form->amount),
                '=>'=>'<p><a href="'.route('assessmentForm',$request->form_id).'" target="_blank">View Assessment</a></p>',
            ];
            send_email($user_details->email, $user_details->name, null, $emailbody,'assessment_assign_email',$user_details);
                }
            }
            return redirect()->route('assessmentForm.responseUsers', $request->form_id)->with('success', __('Form assigned successfully.'));
        }

        return redirect()->back()->with('error', __('Permission Denied.'));
    }
public function payment_confirmation(Request $request) {
        $user = Auth::user();
         $title = "Payment Details";
        $id = !empty($request->id) ? encrypted_key($request->id, 'decrypt') : 0;
        if (!empty($id)) {

            $product = ShopProduct::where("id", $id)->first();
            $quantity=!empty($request->quantity) ? $request->quantity:1;
          
            return view('shop.payment', compact('title','product','quantity'));
        }
        return redirect()->route('shop.index')->with('error', __('Permission Denied.'));
    }
}
