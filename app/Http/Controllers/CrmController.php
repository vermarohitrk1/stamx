<?php

namespace App\Http\Controllers;

use App\ContactFolder;
use App\CrmCustomForms;
use App\CrmCustomFormQuestions;
use App\CrmCustomFormResponses;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;
use DataTables;
use Carbon\Carbon;
//use App\Exports\CustomFormResponsesExport;
//use Maatwebsite\Excel\Facades\Excel;
class CrmController extends Controller {

    
    /*
     * Crm Dashboard 
     */

    public function dashboard(Request $request) {
        $user = Auth::user();
        $permissions = permissions();
      $domain_id = get_domain_id();
      $total_folders='';
      $my_total_forms='';
      $total_questions='';
      $total_responses='';      
     $maps=[];
      if ($request->ajax() && !empty($request->blockElementsData)) {
                if (!empty($request->duration)) {
                    $tilldate = Carbon::now()->addMonth($request->duration)->toDateTimeString();
                }
                
             
          $total_folders = ContactFolder::where('user_id', $user->id);
          if (!empty($tilldate)) {
                    $total_folders->where("created_at", ">", $tilldate);
                };
        $total_folders=$total_folders->count();
        $my_total_forms = CrmCustomForms::where('user_id', $user->id);
        if (!empty($tilldate)) {
                    $my_total_forms->where("created_at", ">", $tilldate);
                };
        $my_total_forms=$my_total_forms->count();
        $total_questions = CrmCustomFormQuestions::where('user_id', $user->id);
        if (!empty($tilldate)) {
                    $total_questions->where("created_at", ">", $tilldate);
                };
        $total_questions=$total_questions->count();
        
        $total_responses= CrmCustomFormResponses::join('crm_custom_forms as c','c.id','=','crm_custom_form_responses.form_id')
                    ->where('c.user_id', $user->id);
          if (!empty($tilldate)) {
                    $total_responses->where("crm_custom_form_responses.created_at", ">", $tilldate);
                };
                
                    $total_responses=$total_responses->count();
        
                        return json_encode([
                    'form' => ($my_total_forms),
                    'question' => ($total_questions),
                    'response' => ($total_responses),
                    'folder' => ($total_folders),
                ]);
                
                
                
         }else{
        if (!in_array("manage_surveys", $permissions) && $user->type !="admin" && !checkPlanModule('crm_custom_forms')) {
           
        }else{
            $total_folders = ContactFolder::where('user_id', $user->id)->get();
        $my_total_forms = CrmCustomForms::where('user_id', $user->id)->count();
        $total_questions = CrmCustomFormQuestions::where('user_id', $user->id)->count();
        
        $total_responses= CrmCustomFormResponses::join('crm_custom_forms as c','c.id','=','crm_custom_form_responses.form_id')
                    ->where('c.user_id', $user->id)
                    ->count();
  
        }
        $title = "Forms Dashboard";
     
        return view('contacts.customforms.dashboard', compact( 'title', 'total_folders', 'my_total_forms', 'total_questions','total_responses'));
         }
    }

  

    /*
     * Crm Form Listing
     */

    
    public function index(Request $request) {
        $user = Auth::user();     
//        if (!in_array("manage_surveys", permissions()) && $user->type !="admin") {
//            return redirect()->back()->with('error', __('Permission Denied.'));
//        }
         if ($request->ajax()) {
            $data = CrmCustomForms::where('user_id', $user->id)->orderByDesc('id');
             //status
            if (!empty($request->filter_category)) {
                $data->where('folder_id', $request->filter_category);
            }

            //keyword
            if (!empty($request->keyword)) {
                $data->WhereRaw('(title LIKE "%' . $request->keyword . '%" )');
            }
            return Datatables::of($data)
                ->addIndexColumn()
                ->filterColumn('title', function($query, $keyword) use ($request) {
                    $query->orWhere('title', 'LIKE', '%' . $keyword . '%')
                    ;
                })
                ->addColumn('title', function ($data) {
                    return $data->title;
                 }) 
                ->addColumn('description', function ($data) {
                    return substr($data->description,0,35)."..";
                 }) 
                ->addColumn('status', function ($data) {
                       
                    $class=($data->status=="Published")?'success':'warning';

                 $html= '<span class="badge  badge-xs bg-'.$class.'-light"> '.$data->status.'</span>';
                  
                 
                    return $html;
                 }) 

                 ->addColumn('folder', function ($data) {
                    return \App\ContactFolder::getfoldername($data->folder_id);              
                  })                  
                 ->addColumn('questions', function ($data) {
                     
                  return CrmCustomFormQuestions::where("form_id",$data->id)->count();
                  })
                  ->addColumn('responses', function ($data) {
                       return CrmCustomFormResponses::where("form_id",$data->id)->count();
                         })
                 
                                 
              ->addColumn('action', function($data){
                    $idquoted="'".encrypted_key($data->id,'encrypt')."'";
                    $actionBtn = '
                        
               
                   <a href="#" onclick="copypublicform('.$idquoted.')" class="btn btn-sm bg-success-light mt-1 px-2" data-toggle="tooltip" data-original-title="Copy Public Link">
                    <i class="fas fa-share"></i>
                            </a>
                   <a href="'. route('crmcustomQuestion',encrypted_key($data->id,'encrypt')) .'" class="btn btn-sm bg-primary-light mt-1 px-2" data-toggle="tooltip" data-original-title="View">
                    <i class="fas fa-eye"></i>
                            </a>
                   <a href="'. route('crmcustom.edit',encrypted_key($data->id,'encrypt')).'" class="btn btn-sm bg-primary-light mt-1 px-2" data-toggle="tooltip" data-original-title="Edit">
                    <i class="fas fa-edit"></i>
                            </a>
                            <a data-url="' . route('crmcustom.destroy',encrypted_key($data->id,'encrypt')) . '" href="#" class="btn btn-sm bg-danger-light mt-1 px-2 delete_record_model">
                                                    <i class="far fa-trash-alt"></i> 
                                                </a>
                ';

                return $actionBtn;
            })
                ->rawColumns(['status','title','folder','description','questions','responses','action'])
                ->make(true);
        }else{ 
            $folders=\App\ContactFolder::where('user_id',$user->id)->get();
            return view('contacts.customforms.index',compact('folders'));
        }
        
    }

    
    /*
     *  Create Crm Form
     */

    public function form_create() {
         $user = Auth::user();     
//        if (!in_array("manage_surveys", permissions()) && $user->type !="admin") {
//            return redirect()->back()->with('error', __('Permission Denied.'));
//        }
    
            $title = "Create Custom Form";
            $folders = ContactFolder::where('user_id',$user->id)->get();
          ;
            return view('contacts.customforms.create_form', compact('title', 'folders'));
        
    }

    
    
    /*
     *   Edit Crm Form
     */

    public function edit($id_encrypted = 0) {
        $user = Auth::user();
        $id = !empty($id_encrypted) ? encrypted_key($id_encrypted, 'decrypt') : 0;
        if (!empty($id)) {
            $title = "Edit Crm Form";
            $data = CrmCustomForms::where('id', $id)->where('user_id', $user->id)->first();
            if (!empty($data->id)) {
                 $folders = ContactFolder::where('user_id',$user->id)->get();
                return view('contacts.customforms.create_form', compact('title', 'data', 'folders'));
            }
        }
        return redirect()->route('crmcustom.index')->with('error', __('Permission Denied.'));
    }

    /*
     *   Store Crm Form
     */

    public function store(Request $request) {
        $user = Auth::user();
        $title = "Crm Form";
        $validation = [
            'title' => 'required|max:255|min:2',
            'folder_id' => 'required',
            'description' => 'required|max:500|min:2',
        ];
      
        $validator = Validator::make(
                        $request->all(), $validation
        );

        if ($validator->fails()) {
            return redirect()->back()->withInput()->withErrors($validator);
        }

        $id = !empty($request->id) ? encrypted_key($request->id, 'decrypt') : 0;
        if (!empty($id)) {
            $data = CrmCustomForms::where('id', $id)->where('user_id', $user->id)->first();
            $post['user_id'] = $user->id;
            $post['title'] = $request->title;
            $post['folder_id'] = $request->folder_id;
            $post['description'] = $request->description;
            $post['status'] = $request->status;
            $post['agreements_url'] = $request->agreements_url;
            $post['redirect_url'] = $request->redirect_url;
            $data->update($post);
            return redirect()->route('crmcustom.index')->with('success', __(' form updated successfully.'));
        } else {
            $data = new CrmCustomForms();
            $data['user_id'] = $user->id;
            $data['title'] = $request->title;
            $data['folder_id'] = $request->folder_id;
            $data['description'] = $request->description;
            $data['status'] = $request->status;
             $data['agreements_url'] = $request->agreements_url;
            $data['redirect_url'] = $request->redirect_url;
            $data->save();
            return redirect()->route('crmcustom.index')->with('success', __('form added successfully.'));
        }
    }

    /*
     *   Destroy Crm Form
     */

    public function destroy($id=0) {
        $user = Auth::user();
        $id = !empty($id) ? encrypted_key($id, 'decrypt') : 0;
        if (!empty($id)) {
            $data = CrmCustomForms::where('id', $id)->where('user_id', $user->id)->first();
            if (!empty($data->id))
                $data->delete();

            $questions = CrmCustomFormQuestions::where('form_id', $id)->get();
            if (!empty($questions->id))
                $questions->delete();

            $responses = CrmCustomFormResponses::where('form_id', $id)->get();
            if (!empty($responses->id))
                $responses->delete();

            return redirect()->back()->with('success', __('form and related data deleted successfully.'));
        } else {
            return redirect()->back()->with('error', __('Permission Denied.'));
        }
    }

    /*
     *   Crm Form Questions
     */

    public function questions($id_encrypted = 0) {
          $user = Auth::user();     
//        if (!in_array("manage_surveys", permissions()) && $user->type !="admin") {
//            return redirect()->back()->with('error', __('Permission Denied.'));
//        }
        $id = !empty($id_encrypted) ? encrypted_key($id_encrypted, 'decrypt') : 0;
        if (!empty($id)) {
            $title = "Custom Form Questions";
            $form = CrmCustomForms::where('id', $id)->where('user_id', $user->id)->first();
            $questions = CrmCustomFormQuestions::where('form_id', $id)->orderBy('indexing', "ASC")->orderBy('created_at', "ASC")->get();

            if (!empty($form->id)) {
                return view('contacts.customforms.questions_list', compact('title', 'form', 'questions', 'id'));
            } else {
                return redirect()->back()->with('error', __('Permission Denied.'));
            }
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
            $form = CrmCustomForms::where('id', $id)->first();
            
            $form_response = CrmCustomFormResponses::where('form_id', $id)->where('user_id', $user->id)->first();
//            $form_questions = CrmCustomFormQuestions::where('form', $id)->orderBy('indexing', 'DESC')->get();
          
        }
        return view('contacts.customforms.form_sidebar', compact('id', 'form', 'form_response', 'form_questions', 'sidebar'));
    }
    
    
    
    
    
    
    
    
    /*
     * All Crm Questions Types List 
     */

    public function questions_types() {
        $types = array(
            "text" => "Text",
            "number" => "Number",
            "email" => "Email",
            "date" => "Date",
            "url" => "Url",
            "select" => "Select",
            "checkbox" => "Checkbox",
            "radio" => "Radio",
            "textarea" => "Textarea",
            "selectwith" => "Select with Yes/No resource",
        );
        return $types;
    }

    /*
     *  Crm Form Add Question
     */

    public function question_create($form_id_encrypted = 0) {
        $user = Auth::user();
        $form_id = !empty($form_id_encrypted) ? encrypted_key($form_id_encrypted, 'decrypt') : 0;
        if (!empty($form_id) && !empty($user->type) && $user->type != 'user') {
            $title = "Add Form Question";
            $form = CrmCustomForms::where('id', $form_id)->first();
            $question_types = self::questions_types();
            return view('contacts.customforms.question_form', compact('title', 'form_id', 'question_types', 'form'));
        } else {
            return redirect()->back()->with('error', __('Permission Denied.'));
        }
    }

    /*
     *  Crm Form Update Question
     */

    public function question_edit($form_id_encrypted = 0, $id_encrypted = 0) {
        $user = Auth::user();
        $form_id = !empty($form_id_encrypted) ? encrypted_key($form_id_encrypted, 'decrypt') : 0;
        $id = !empty($id_encrypted) ? encrypted_key($id_encrypted, 'decrypt') : 0;
        if (!empty($id) && !empty($form_id) && !empty($user->type) && $user->type != 'user') {
            $title = "Update Form Question";
            $form = CrmCustomForms::where('id', $form_id)->where('user_id', $user->id)->first();
            $data = CrmCustomFormQuestions::where('id', $id)->where('user_id', $user->id)->first();
            $question_types = self::questions_types();
            return view('contacts.customforms.question_form', compact('title', 'data', 'form_id', 'question_types', 'form'));
        } else {
            return redirect()->back()->with('error', __('Permission Denied.'));
        }
    }

    /*
     *   Store Crm Form Question
     */

    public function question_store(Request $request) {
        $user = Auth::user();  
//        if (!in_array("manage_surveys", permissions()) && $user->type !="admin") {
//            return redirect()->back()->with('error', __('Permission Denied.'));
//        }
    
        $form_id = !empty($request->form_id) ? encrypted_key($request->form_id, 'decrypt') : 0;
        if (!empty($form_id)) {
            $title = " Form Question";
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
                $data = CrmCustomFormQuestions::where('id', $id)->where('user_id', $user->id)->first();
                $post['form_id'] = $form_id;
                $post['user_id'] = $user->id;
                $post['question'] = $request->question;
                $post['type'] = $request->type;
                $post['options'] = ($request->type=="selectwith") ? "Yes,No":$request->options;
                $post['resource_url'] = $request->resource_url;
                $data->update($post);
                return redirect()->route('crmcustomQuestion', $request->form_id)->with('success', __('Form question updated successfully.'));
            } else {
                $data = new CrmCustomFormQuestions();
                $data['form_id'] = $form_id;
                $data['user_id'] = $user->id;
                $data['question'] = $request->question;
                $data['type'] = $request->type;
                $data['options'] = ($request->type=="selectwith") ? "Yes,No":$request->options;
                $data['resource_url'] = $request->resource_url;
                $data->save();
                return redirect()->route('crmcustomQuestion', $request->form_id)->with('success', __('Form question added successfully.'));
            }
        } else {
            return redirect()->back()->with('error', __('Permission Denied.'));
        }
    }

    /*
     *   Destroy Crm Form Question
     */

    public function question_destroy($id=0) {
        $user = Auth::user();
        $id = !empty($id) ? encrypted_key($id, 'decrypt') : 0;
        if (!empty($id)) {
            $data = CrmCustomFormQuestions::where('id', $id)->where('user_id', $user->id)->first();
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
            $data = CrmCustomFormQuestions::where('id', $question_id[1])->first();
            $place['indexing'] = $i;
            $data->update($place);
            $i++;
        }
        return;
    }

    /*
     *   Crm Form
     */

    public function form($id_encrypted = 0) {
        $user = Auth::user();
        $title = "Crm Custom Form";
        $assigned = false;
        $id = !empty($id_encrypted) ? encrypted_key($id_encrypted, 'decrypt') : 0;
       
        if (!empty($id)) {

           
            $form = CrmCustomForms::where('id', $id)->first();
           
            $form_response = CrmCustomFormResponses::where('form_id', $id)->where('user_id', $user->id)->first();
         
            if (!empty($user->type) ) {
               // $form = CrmCustomForms::where('id', $id)->where('user_id', $user->id)->first();
              
                $questions = CrmCustomFormQuestions::where('form_id', $id)->orderBy('created_at', "ASC")->orderBy('indexing', 'ASC')->get();
                if (!empty($form->id)) {
                    return view('contacts.customforms.form', compact('title', 'form', 'questions', 'id', 'assigned', 'form_response'));
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
     *   Crm Form Response
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

    /*
     *   Store Crm Form Responses
     */

    public function form_response_store(Request $request) {

        $user = Auth::user();
        $user_id = get_domain_id();
        $domainData = \App\UserDomain::whereId($user_id)->first();
        $getUserData = \App\User::whereId($domainData->user_id)->first();
        $title = "Crm Form Store";
        $data_array = array();
        $id = !empty($request->id) ? encrypted_key($request->id, 'decrypt') : 0;
        if (!empty($id)) {
            /*
             *  Check Assignment Permission 
             *  Start 
             */
            $form = CrmCustomForms::where('id', $id)->first();
          $questions = CrmCustomFormQuestions::where('form_id', $id)->orderBy('indexing', 'DESC')->get();
     
            if (!empty($form->id)) { //if form is valid and form is assigned to user
               
                    $assigned = true;
                    $validation = array();
                    $validation_message = array();

                    foreach ($questions as $row) {
                       
                        $encrypted_question_id = encrypted_key($row->id, 'encrypt');
                        if(is_array($request->$encrypted_question_id)){
                            $response_ans= implode(",", $request->$encrypted_question_id);
                        }else{
                            $response_ans= $request->$encrypted_question_id;
                        }
                        
                        $data_array["response"][] = array("question_id"=>$row->id,"question" => trim($row->question),"answer" => trim($response_ans));
                        $validation[$encrypted_question_id] = 'required';
                        $validation_message[$encrypted_question_id . '.required'] = $row->question . ' field is required';
//                        $validation_message[$encrypted_question_id . '.max'] = $row->question . ' field allowed limit is 255 characters';
                    }

                    $validator = Validator::make(
                                    $request->all(), $validation, $validation_message
                    );
                    if ($validator->fails()) {
                        return redirect()->back()->withInput()->withErrors($validator);
                    }

                    
                    
                    $data = CrmCustomFormResponses::where('form_id',$id)->where('user_id',(!empty($user->id) ? $user->id : $user_id))->first();
                if(empty($data->id)){
                $data = new CrmCustomFormResponses();
                $data['form_id'] = $id;
                $data['user_id'] = !empty($user->id) ? $user->id : $user_id;
                $data['response'] = json_encode($data_array["response"]);
                $data->save();
                }else{
                     $data['response'] = json_encode($data_array["response"]);
                     $data->save();
                }
              
              // ADD POINTS ON SERVEY COMPLETE 
                $rolescheck = \App\Role::whereRole($getUserData->type)->first();
                if($rolescheck->role == 'mentor'  ){
                    if(checkPlanModule('points')){
                        $checkPoint = \Ansezz\Gamify\Point::find(9);
                        if(isset($checkPoint) && $checkPoint != null ){
                            if($checkPoint->allow_duplicate == 0){
                                $createPoint = $getUserData->achievePoint($checkPoint);
                            }else{
                                $addPoint = DB::table('pointables')->where('pointable_id', $getUserData->id)->where('point_id', $checkPoint->id)->get();
                                if($addPoint == null){
                                    $createPoint = $getUserData->achievePoint($checkPoint);
                                }
                            }
                        } 
                    }  
                } 
            
                if(!empty($form->redirect_url)) {
                   return redirect()->to($form->redirect_url);
                }

                    
                   
                return redirect()->back()->with('success', __('Details Added successfully.'));


               
            }
            /*
             *  Check Assignment Permission 
             *  End 
             */
        }
        return redirect()->back()->with('error', __('Permission Denied.'));
    }

    

    /*
     *   Crm Form Users Responses
     */

    public function form_users_responses(Request $request, $id_encrypted = 0) {
        $user = Auth::user();
        $permissions=permissions();
        $id = !empty($id_encrypted) ? encrypted_key($id_encrypted, 'decrypt') : 0;
        if (!empty($id) ) {
            $title = "Form Users Responses";
           
       
              $form = CrmCustomForms::where('id', $id)->first();
         
                
                $user = Auth::user();       
         if ($request->ajax()) {
             
             
            $data = CrmCustomFormResponses::leftjoin('crm_custom_forms as cf','cf.id','crm_custom_form_responses.form_id')
                    ->leftjoin('users as u','u.id','crm_custom_form_responses.user_id')
                    ->select('crm_custom_form_responses.*','u.name','cf.user_id as f_user_id')
                    ->where('crm_custom_form_responses.form_id', $id)
                    ->whereRaw('(crm_custom_form_responses.user_id='.$user->id.' or cf.user_id='.$user->id.')')
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
                    return ' <p class="text-dark">'.((!empty($data->response)) ? '<span class="badge badge-success badge-xs badge-pill">Filled</span>' :'<span class="badge badge-danger badge-xs badge-pill">Not Filled</span></p>');
                 }) 
                
                                 
              ->addColumn('action', function($data){
                  $user = Auth::user();  
                    $idquoted="'".encrypted_key($data->id,'encrypt')."'";
                    $actionBtn = '
                        <a href="#" class="text-primary px-2" data-url="'.route('crmcustomResponse.user',encrypted_key($data->id,'encrypt')).'" data-ajax-popup="true" data-size="lg" data-title="User Response">
        <span class="btn-inner--icon"><i class="fas fa-eye"></i></span>
    </a>';
    
                    if($data->f_user_id==$user->id){
     $actionBtn .= '<a data-url="' . route('crmcustomResponse.destroy',encrypted_key($data->id,'encrypt')) . '" href="#" class="btn btn-sm bg-danger-light mt-1 px-2 delete_record_model">
                                                    <i class="far fa-trash-alt"></i> 
                                                </a>
                 ';
                    }
                return $actionBtn;
            })
                ->rawColumns(['user','date','action','status'])
                ->make(true);
        }else{ 
                
                
//                $responses = CrmCustomFormResponses::where('form_id', $id)->orderBy('id', 'DESC')->get();
//                if (!empty($responses) && count($responses) > 0) {
//                    foreach ($responses as $row)
//                        $row->user_name = \App\User::find($row->user_id)->name;
//                }


                return view('contacts.customforms.users_responses_list', compact('title', 'form', 'id'));
                
        }
           
        }
        return redirect()->back()->with('error', __('Permission Denied.'));
    }

    /*
     *   Destroy Crm Form User Response
     */

    public function form_users_responses_destroy($id=0) {
        $user = Auth::user();
        $id = !empty($id) ? encrypted_key($id, 'decrypt') : 0;
        if (!empty($id)) {
            $data = CrmCustomFormResponses::where('id', $id)->first();
            $data->delete();
            return redirect()->back()->with('success', __('Response deleted successfully.'));
        } else {
            return redirect()->back()->with('error', __('Permission Denied.'));
        }
    }

    public function public_form_view($id_encrypted = 0) {
        $user = Auth::user();
        $id = !empty($id_encrypted) ? encrypted_key($id_encrypted, 'decrypt') : 0;
        if (!empty($id)) {

           
            $form = CrmCustomForms::where('id', $id)->first();
          
            if ($form) {
                $questions = CrmCustomFormQuestions::where('form_id', $id)->orderBy('created_at', "ASC")->orderBy('indexing', 'ASC')->get();
                if (!empty($form->id)) {
                    return view('contacts.customforms.public_crm_form', compact('form', 'questions', 'id'));
                }
            }
            /*
             *  Form Owner
             *  End 
             */
        }

        return redirect()->back()->with('error', __('Permission Denied.'));
    }
    public function form_users_responses_export_csv($id_encrypted = 0) {
        $user = Auth::user();
        $id = !empty($id_encrypted) ? encrypted_key($id_encrypted, 'decrypt') : 0;
        if (!empty($id)) {
            $form = CrmCustomForms::where('id', $id)->first();
        return Excel::download(new CustomFormResponsesExport($id), $form->title.'.csv', \Maatwebsite\Excel\Excel::CSV);
          
        }

        return redirect()->back()->with('error', __('Permission Denied.'));
    }
   
    public function published($views = null,Request $request) {
         $user = Auth::user();
        if ($request->ajax()) {
//DB::enableQueryLog();
             $data = CrmCustomFormResponses::select("cf.*","crm_custom_form_responses.user_id as r_user_id","crm_custom_form_responses.response","crm_custom_form_responses.id as r_id","crm_custom_form_responses.form_id")
                     ->join('crm_custom_forms as cf',"cf.id",'crm_custom_form_responses.form_id')
                     ->where('crm_custom_form_responses.user_id', $user->id)
                        ->orderBy('crm_custom_form_responses.id', 'DESC');

            
            switch ($request->filter_type) {
                case "fill":
                    $data->where('crm_custom_form_responses.response', '!=',null);
                    break;
                case "notfill":
                    $data->where('crm_custom_form_responses.response', null);
                    break;
                default:
                    break;
            }

            //status
            if (!empty($request->filter_category)) {
                $data->where('cf.folder_id', $request->filter_category);
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
                      return '<div class="actions text-right">
                                                <a class="btn btn-sm bg-primary-light mt-1" data-title="View Form"  href="'.route("crmcustomForm",encrypted_key($data->form_id,'encrypt')).'">
                                                   '.ucfirst(substr($data->title ,0,20)).'..
                                                </a>
                                                
                                            </div>';
                 }) 
                ->addColumn('question', function ($row) {
                     return CrmCustomForms::find($row->form_id)->questions->where('form_id', $row->form_id)->count();
                 }) 
                ->addColumn('category', function ($data) {
                     return \App\ContactFolder::getfoldername($data->folder_id);   
                 }) 
                ->addColumn('sender', function ($data) {
                       
                       return '<h2 class="table-avatar">
                                                <a href="' . route('profile', ['id' => encrypted_key($data->user_id, 'encrypt')]) . '" class="avatar avatar-sm mr-2"><img class="avatar-img rounded-circle" src="' . $data->user->getAvatarUrl() . '" alt="Image"></a>
                                                <a href="' . route('profile', ['id' => encrypted_key($data->user_id, 'encrypt')]) . '">' . $data->user->name . '</a>
                                            </h2>';
                 }) 
                ->addColumn('response', function ($row) {
                     $res= CrmCustomForms::find($row->form_id)->responses->where('response','!=', '')->where('form_id', $row->form_id)->count();
                     if(!empty($res)){
                         $user = Auth::user();
                      $res= '<div class="actions ">
                                                <a class="btn btn-sm bg-success-light" data-title="View Response"  data-ajax-popup="true" data-size="md" data-url="'.route("crmcustomForm.response",['id'=>encrypted_key($row->form_id,'encrypt'),'user_id'=>encrypted_key($user->id,'encrypt')]).'" href="#">
                                                    '.$res.'
                                                </a>
                                            </div>';
                     }
                      return $res;
                 }) 
              
                ->addColumn('type', function ($data) {
                      
                    $status=(!empty($data->response))?'Filled':'Not Filled';
                    $class=(!empty($data->response))?'success':'warning';

                 $slots= '<span class="badge  badge-xs bg-'.$class.'-light"> '.$status.'</span>';
                  
                 
                 return $slots;
                 }) 
                
              
                ->rawColumns(['form','question','category','sender','response','action','type'])
                ->make(true);
        }
        
        
//        }  
    }
    
    public function form_assign($form_id_encrypted = 0) {
          $user = Auth::user();  
          $domain_user= get_domain_user();
//        if (!in_array("manage_surveys", permissions()) && $user->type !="admin") {
//            return redirect()->back()->with('error', __('Permission Denied.'));
//        }
        $form_id = !empty($form_id_encrypted) ? encrypted_key($form_id_encrypted, 'decrypt') : 0;
        if (!empty($form_id)) {
            $title = "Assign CRM Form";
            $form = CrmCustomForms::where('id', $form_id)->where('user_id', $user->id)->first();
           
            $users = \App\User::where('users.created_by',$domain_user->id)
                            ->OrderBy('users.id','DESC')
                            ->select('users.*');
          
           $users=$users->get();
            
            if (!empty($form->id)) {
                return view('contacts.customforms.form_assign', compact('title', 'form_id', 'users', 'form'));
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
            $title = "CRM Form Assign";
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
            $post['form_id'] = $form_id;
            foreach ($request->users as $encrypted_user_id) {
                $user_id = !empty($encrypted_user_id) ? encrypted_key($encrypted_user_id, 'decrypt') : 0;
                $post['user_id'] = $user_id;
                if (!empty($user_id)) {
                    $data = CrmCustomFormResponses::where('user_id', $post['user_id'])->where('form_id', $post['form_id'])->first();
                    if (empty($data->id)) {
                        $save = new CrmCustomFormResponses();
                        $save['user_id'] = $post['user_id'];
                        $save['form_id'] = $post['form_id'];
                        $save->save();
                    }
                }
            }
            return redirect()->route('crmcustomForm.responseUsers', $request->form_id)->with('success', __('Form assigned successfully.'));
        }

        return redirect()->back()->with('error', __('Permission Denied.'));
    }
    
    public function form_response($id_encrypted = 0, $user_id_encrypted) {
        $user = Auth::user();
        $title = "Form Response";
        $assigned = false;
        $id = !empty($id_encrypted) ? encrypted_key($id_encrypted, 'decrypt') : 0;
        $user_id = !empty($user_id_encrypted) ? encrypted_key($user_id_encrypted, 'decrypt') : 0;
    
        if (!empty($id) && !empty($user_id)) {
            $form = CrmCustomForms::where('id', $id)->first();
            $response = CrmCustomForms::find($id)->responses->where('form_id', $id)->where('user_id', $user_id)->first();
            $response_by_user = \App\User::find($user_id)->name;
            return view('contacts.customforms.form_response', compact('title', 'response', 'form', 'id', 'response_by_user', 'user_id'));
        }
        return redirect()->back()->with('error', __('Permission Denied.'));
    }
}
