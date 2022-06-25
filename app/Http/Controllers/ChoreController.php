<?php

namespace App\Http\Controllers;

use App\Chore;
use App\ChoreLinkedMembers;
use App\ChoreCategory;
use App\ChoreToDo;

use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\DB;
use App\User;
use App\ChoreComment;

use DataTables;
use Carbon\Carbon;


class ChoreController extends Controller {

    public function members(Request $request) {
        $usr = Auth::user();
         $domain_owner = get_domain_user();
        if ($request->ajax()) {

            $employees = \App\User::join('chore_members as h', 'h.user_id', '=', 'users.id')
                    //->where('users.type','employee')
                    ->OrderBy('users.id', 'DESC')
                    ->select('users.*', 'h.id as member_id');


         
                $employees->where('h.created_by', $domain_owner->id);
        
             if (!empty($request->keyword)) {
                $employees->WhereRaw('(users.name LIKE "%' . $request->keyword . '%" )');
            }

            $data = $employees;

//            dd($data);
            return Datatables::of($data)
                            ->addIndexColumn()
                            ->filterColumn('name', function($query, $keyword) use ($request) {
                                $query->orWhere('users.name', 'LIKE', '%' . $keyword . '%')
                                ->orWhere('users.email', 'LIKE', '%' . $keyword . '%')
                                ->orWhere('users.domain', 'LIKE', '%' . $keyword . '%')
                                ->orWhere('users.custom_url', 'LIKE', '%' . $keyword . '%');
                            })
                            ->addColumn('name', function ($user) {
                                 
           return '<h2 class="table-avatar">
                                                <a href="' . route('profile', ['id' => encrypted_key($user->id, 'encrypt')]) . '" class="avatar avatar-sm mr-2"><img class="avatar-img rounded-circle" src="' . $user->getAvatarUrl() . '" alt="Image"></a>
                                                <a href="' . route('profile', ['id' => encrypted_key($user->id, 'encrypt')]) . '">' . $user->name . '</a>
                                            </h2>';
                            })
                            ->addColumn('email', function ($data) {
                                return $data->email;
                            })
                            ->addColumn('type', function ($data) {
                                $type = '<span class="badge badge-xs badge-primary">' . $data->type . '</span>';

                                if (!empty($data->board_member)) {
                                    $type .= '&nbsp<span class="badge badge-xs badge-success">Board Member</span>';
                                }
                                if (!empty($data->contributor)) {
                                    $type .= '&nbsp<span class="badge badge-xs badge-warning">Contributor</span>';
                                }

                                return $type;
                            })
                            ->addColumn('action', function ($data) {
                                $actionBtn_replicate = $actionBtn_edit = $actionBtn_delete = $actionBtn = "";


                                $actionBtn = '<a href="' . route('profile', ['id' => encrypted_key($data->id, 'encrypt')]) . '" class="action-item px-2" data-toggle="tooltip" data-original-title="' . __('View') . '">
                                            <i class="fas fa-eye"></i>
                                        </a>';




                                return $actionBtn . $actionBtn_edit . $actionBtn_delete;
                            })
                            ->rawColumns(['action', 'name', 'type'])
                            ->make(true);
        } else {
            return view('chore.members');
        }
    }

    public function manage_members() {
        $user = Auth::user();
          $domain_owner = get_domain_user();
       
            $title = "Manage Chore Members";
            $members = \App\ChoreMembers::where('created_by', $user->id)->pluck('user_id')->toArray();
            $users = \App\User::OrderBy('users.id', 'DESC')
                    ->where('users.created_by',$domain_owner->id)
                    ->select('users.*');
         
            $users = $users->get();

            return view('chore.manage_members', compact('title', 'users', 'members'));
        
    }

    /*
     *   Store Assessment Form Assigns
     */

    public function manage_members_store(Request $request) {
        $user = Auth::user();
        if (!empty($user->type) && ($user->type == 'admin' || $user->type == 'owner')) {
            $title = "Chore Members";
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
            $post['created_by'] = $user->id;
            \App\ChoreMembers::where('created_by',$user->id)->delete();
                  
            foreach ($request->users as $encrypted_user_id) {
                $user_id = !empty($encrypted_user_id) ? encrypted_key($encrypted_user_id, 'decrypt') : 0;
                $post['user_id'] = $user_id;

                $delete = \App\ChoreMembers::where('user_id', $post['user_id'])->where('created_by', $post['created_by'])->first();
                if ($delete) {
                    $delete->delete();
                }

                if (!empty($user_id)) {
                    $save = new \App\ChoreMembers;
                    $save['user_id'] = $post['user_id'];
                    $save['created_by'] = $post['created_by'];
                    $save->save();
                }
            }
            return redirect()->route('chore.members')->with('success', __('members added successfully.'));
        }

        return redirect()->back()->with('error', __('Permission Denied.'));
    }

    public function dashboard(Request $request) {
        $user = Auth::user();
        $title = "Guestpert";
     
        if ($request->ajax() && !empty($request->blockElementsData)) {
                if (!empty($request->duration)) {
                    $tilldate = Carbon::now()->addMonth($request->duration)->toDateTimeString();
                }
                
                 $opensch = Chore::where('user_id', $user->id)->where('status', 'Active');
          if (!empty($tilldate)) {
                    $opensch->where("created_at", ">", $tilldate);
                }
                        $opensch=$opensch->count();
            $closedsch = Chore::where('user_id', $user->id)->where('status', 'Inactive');
        if (!empty($tilldate)) {
                    $closedsch->where("created_at", ">", $tilldate);
                }
                        $closedsch=$closedsch->count();
            $totalsch = Chore::where('user_id', $user->id);
         if (!empty($tilldate)) {
                    $totalsch->where("created_at", ">", $tilldate);
                }
                        $totalsch=$totalsch->count();
            $members = \App\ChoreMembers::where('created_by', $user->id);
                     if (!empty($tilldate)) {
                    $members->where("created_at", ">", $tilldate);
                }
                        $members=$members->count();

                
        
                        return json_encode([
                    'open' => ($opensch),
                    'close' => ($closedsch),
                    'total' => ($totalsch),
                    'member' => ($members),
                ]);
                
                
                
         }elseif ($request->ajax()) {

//                DB::enableQueryLog();
            $data = Chore::where('user_id', $user->id)
                    ->orderBy('id', 'DESC');
//                  dd(DB::getQueryLog()); // Show results of log
switch ($request->filter_type) {
              
                case "Inactive":
                    $data->where('chores.status','Inactive');
                    break;
                case "Active":
                    $data->where('chores.status','Active');
                    break;
                default:
                 
            }

            //status
            if (!empty($request->filter_category)) {
                $data->where('chores.category_id', $request->filter_category);
            }

            //keyword
            if (!empty($request->keyword)) {
                $data->WhereRaw('(chores.title LIKE "%' . $request->keyword . '%" )');
            }

            return Datatables::of($data)
                            ->addIndexColumn()
                            ->filterColumn('chore', function ($query, $keyword) use ($request) {
                                $sql = " title like ?";
                                $query->whereRaw($sql, ["%{$keyword}%"]);
                            })
                            ->addColumn('chore', function ($data) {
                                
                                 return '<div class="actions text-right">
                          <span class="badge badge-xs bg-warning-light mt-1" title="Category"  >
                                                   '.\App\ChoreCategory::category_name($data->category_id) .'
                                                </span> <span class="badge badge-xs bg-' . (($data->status == 'Active' ) ? 'success' : 'warning') . '-light mt-1" title=" '.$data->status .'"  >
                                                  '.$data->status .'
                                                </span><br>
                                                <a class="badge badge-sm bg-primary-light mt-1" title="View Chore"  href="'.route('chore.details', encrypted_key($data->id, 'encrypt')).'">
                                                   '.ucfirst(substr($data->title ,0,30)).'..
                                                </a>
                                                
                                            </div>';

                             
                            })
                            ->addColumn('price', function ($row) {
                                return format_price($row->price, 2);
                            })
                            ->addColumn('type', function ($row) {
                                return $row->typeOnChoice;
                            })
                            ->addColumn('day', function ($row) {
                                return !empty($row->day) ? implode(',', json_decode($row->day)) : '';
                            })
                            ->addColumn('date', function ($row) {

                                return '<label class="badge  mb-0 h6 text-sm">' . \App\Utility::getDateFormated($row->start_date) .'</label>' . '<br>';
                                ;
                            })
                            ->addColumn('members', function ($data) {
                                $members = \App\ChoreLinkedMembers::members($data->id);
                                $html = '';
                                if (!empty($members) && count($members) > 0) {
                                    foreach ($members as $user) {
                                        if (Auth::user()->id != $user->id) {
                                            $html .= '<a data-toggle="modal" data-target="#myChat" href="javascript:void(0);" class="SingleuserChatButton userDataMessage"
               data-id="' . $user->id . '">';
                                        } else {
                                            $html .= '<a href="#">';
                                        }

                                        $html .= '<div class="col-md-2 text-center centered align-items-center">
                                <img ' . Auth::user()->getAvatarUrl($user->id) . '  class="img-circle mt-0 img-responsive avatar avatar-sm rounded-circle ">
                                 <div class="inbox-preview-name">
                                     <h6 class="name mb-2 mt-1 h6 text-sm"> ' . !empty($user->name) ? $user->name . ",&nbsp;" : "" . ' 
                                        
                                    </h6>
                                </div>
                            </div>
                                </a>&';
                                    }
                                }
                                return $html;
                            })
                            ->addColumn('action', function ($row) {
                                $authuser = Auth::user();
                                $actionBtn = '';
                                $actionBtn = '<div class="actions"> ';

                                $actionBtn .= '<a href="'.route('chore.details', encrypted_key($row->id, 'encrypt')).'" class="action-item mr-2" data-toggle="tooltip" data-original-title="Details">
                                    <i class="fas fa-eye"></i>
                                </a>';
                                $actionBtn .= '<a href="' . route('chore.edit', encrypted_key($row->id, 'encrypt')) . '" class="action-item" data-toggle="tooltip" data-original-title="Edit">
                                    <i class="fas fa-edit"></i>
                                </a>';

                                $actionBtn .= '<a data-title="Delete" href="#" class="action-item text-danger ml-auto px-2 delete_record_model "  data-url="' .route('chore.destroy', encrypted_key($row->id, 'encrypt'))  . '" data-toggle="tooltip" >
                    <i class="fas fa-trash-alt"></i>
                </a>';


                                $actionBtn .= ' </div>';

                                return $actionBtn;
                            })
                            ->rawColumns(['action', 'chore', 'price', 'members', 'day', 'date'])
                            ->make(true);
        } else {

            $opensch = Chore::where('user_id', $user->id)->where('status', 'Active')->count();
            $closedsch = Chore::where('user_id', $user->id)->where('status', 'Inactive')->count();
            $totalsch = Chore::where('user_id', $user->id)->count();
            $members = \App\ChoreMembers::where('created_by', $user->id)
                    ->count();

            $categories = ChoreCategory::where(['user_id' => $user->id])->get();
            return view('chore.index', compact('title', 'opensch', 'closedsch', 'totalsch', 'members', 'categories'));
        }
    }

    public function create() {
        $user = Auth::user();
        $title = "Create Chore";
        $members = \App\ChoreMembers::members();

        $categories = ChoreCategory::where('user_id', $user->id)->get();
        if (count($members) > 0) {
            return view('chore.chore_form', compact('title', 'categories', 'members'));
        }
       
        return redirect()->back()->with('error', __('Add members first.'));
    }

    public function store(Request $request) {
        $user = Auth::user();
        $validation = [
            'title' => 'required',
            'description' => 'required',
            'category_id' => 'required',
            'members' => 'required',
            'typeOnChoice' => 'required',
            'start_date' => 'required',
        ];

        $validator = Validator::make(
                        $request->all(), $validation
        );

        if ($validator->fails()) {
            return redirect()->back()->with('error', $validator->errors()->first());
        }
       
        $id = !empty($request->id) ? encrypted_key($request->id, 'decrypt') : 0;
        if (!empty($id)) {
            try {
                $update = array();
                $data = Chore::find($id);
                $update['user_id'] = $user->id;
                $update['title'] = $request->title;
                $update['description'] = $request->description;
                $update['category_id'] = $request->category_id;
                $update['status'] = $request->status;
                $update['priority'] = $request->priority;
                $update['price'] = $request->price;
                $update['typeOnChoice'] = $request->typeOnChoice;
                $update['day'] = $request->day ? json_encode($request->day) : NULL;
                $update['start_date'] = $request->start_date;
                $update['end_date'] = $request->end_date;
                $update['start_time'] = $request->start_time;
                $update['end_time'] = $request->end_time;
                $data->update($update);

                self::update_chore_members($id, $request->members);
                self::assign_chores($id, $request->members);
                
            } catch (Exception $ex) {
                return redirect()->back()->with('error', __('Error.'));
            }
            return redirect()->route('chore.dashboard')->with('success', __('Chore updated successfully.'));
//    
        } else {
            try {
                $data = new \App\Chore();
                $data['user_id'] = $user->id;
                $data['title'] = $request->title;
                $data['description'] = $request->description;
                $data['category_id'] = $request->category_id;
                $data['status'] = $request->status;
                $data['priority'] = $request->priority;
                $data['price'] = $request->price;
                $data['typeOnChoice'] = $request->typeOnChoice;
                $data['day'] = $request->day ? json_encode($request->day) : NULL;
                $data['start_date'] = $request->start_date;
                $data['end_date'] = $request->end_date;
                $data['start_time'] = $request->start_time;
                $data['end_time'] = $request->end_time;
                $data->save();

                if (!empty($data->id)) {
                    self::update_chore_members($data->id, $request->members);
                     self::assign_chores($data->id, $request->members);
                }
            } catch (Exception $ex) {
                return redirect()->back()->with('error', __('Error.'));
            }
            return redirect()->route('chore.dashboard')->with('success', __('Chore added successfully.'));
        }
    }

    public function update_chore_members($chore_id = 0, $members = array()) {
        if (!empty($members)) {
            $delete = ChoreLinkedMembers::where('chore_id', $chore_id)->delete();
            foreach ($members as $member_id) {
                $members = new \App\ChoreLinkedMembers();
                $members['chore_id'] = $chore_id;
                $members['user_id'] = $member_id;
                $members->save();
            }
        }
    }

    public function assign_chores($chore_id = 0, $members = array()) {
        if (!empty($chore_id) && !empty($members)) {
             $delete = \App\ChoreAssigned::where('chore_id', $chore_id)->whereNotIn('user_id', [implode(',',$members)])->delete();
            $data = Chore::find($chore_id);
           
            if($data->typeOnChoice=="Singleday"){
                self::assign_to_members($members,$chore_id,$data->start_date,$data);
            }elseif($data->typeOnChoice=="Weekly"){
                $startDate = new \DateTime($data->start_date);
                $endDate = new \DateTime($data->end_date);
                for($date = $startDate; $date <= $endDate; $date->modify('+1 day')){
                    if(in_array($date->format('l'),json_decode($data->day))){
                    self::assign_to_members($members,$chore_id,$date->format('Y-m-d'),$data);
                    }
                }
                
            }elseif($data->typeOnChoice=="Monthly"){
                 $startDate = new \DateTime($data->start_date);
                $endDate = new \DateTime($data->end_date);
                $monthday=$startDate->format('d');
                for($date = $startDate; $date <= $endDate; $date->modify('+1 day')){
                    if($monthday==$date->format('d')){
                    self::assign_to_members($members,$chore_id,$date->format('Y-m-d'),$data);
                    }
                }
            }
            
        }
        
        
    }
public function assign_to_members($members = array(),$chore_id=0,$date='',$data=false){
   
            if(!empty($members)){
                foreach ($members as $member){
                     $choreassigned = \App\ChoreAssigned::where('chore_id',$chore_id)->where('user_id',$member)->where('date',$date)->first();
                     if(empty($choreassigned)){
                           $choreassign = new \App\ChoreAssigned();
                            $choreassign['chore_id'] = $chore_id;
                            $choreassign['user_id'] = $member;
                            $choreassign['date'] = $date;
                            $choreassign->save();
                            
                                $user_data=\App\User::find($member);
            //send email template
            $body=[
                'Chore Title'=>$data->title??"",
                'Assigned At'=>date('F d, Y H:i:s', strtotime(Carbon::now())),
            ];
            send_email($user_data->email, $user_data->name, null, $body,'chore_assign_email',$user_data);
           

                     }
                }
            }
        }
    public function edit($id_encrypted = 0) {
        $user = Auth::user();
        $id = !empty($id_encrypted) ? encrypted_key($id_encrypted, 'decrypt') : 0;
        if (!empty($id)) {
            $title = "Edit Chores";

            $data = Chore::where('id', $id)->where('user_id', $user->id)->first();
            $data->members = \App\ChoreLinkedMembers::members($id)->pluck('id')->toArray();

            $members = \App\ChoreMembers::members();

            $categories = ChoreCategory::where('user_id', $user->id)->get();
            if (count($members) > 0) {
                return view('chore.chore_form', compact('title', 'categories', 'members', 'data'));
            }
            return redirect()->back()->with('warning', __('Add members first.'));
        }
        return redirect()->back()->with('error', __('Permission Denied.'));
    }

//
    public function destroy($id=0) {
        $user = Auth::user();
         $id = !empty($id) ? encrypted_key($id, 'decrypt') : 0;
   
        if ($id) {
            $data = Chore::find($id);
            $data->delete();
            $delete = \App\ChoreAssigned::where('chore_id', $id)->delete();
            $delete = \App\ChoreLinkedMembers::where('chore_id', $id)->delete();
            return redirect()->back()->with('success', __('Chore deleted successfully.'));
        } else {
            return redirect()->back()->with('error', __('Permission Denied.'));
        }
    }

    public function mydashboard(Request $request) {
        $user = Auth::user();
        $domain_owner = get_domain_user();
        if ($request->ajax() && !empty($request->blockElementsData)) {
                if (!empty($request->duration)) {
                    $tilldate = Carbon::now()->addMonth($request->duration)->toDateTimeString();
                }
                
                $opensch = Chore::join('chore_linked_members as c', 'c.chore_id', '=', 'chores.id')
                            ->where('c.user_id', $user->id)->where('chores.status', 'Active');
         if (!empty($tilldate)) {
                    $opensch->where("chores.created_at", ">", $tilldate);
                }
                      $opensch=$opensch->count();
            $closedsch = Chore::join('chore_linked_members as c', 'c.chore_id', '=', 'chores.id')
                            ->where('c.user_id', $user->id)->where('chores.status', 'Inactive');
        if (!empty($tilldate)) {
                    $closedsch->where("chores.created_at", ">", $tilldate);
                }
                        $closedsch=$closedsch->count();
            $totalsch = $opensch + $closedsch;
     
                
        
                        return json_encode([
                    'open' => ($opensch),
                    'close' => ($closedsch),
                    'total' => ($totalsch),
                ]);
                
                
                
         }elseif ($request->ajax()) {

//                DB::enableQueryLog();
            $data = Chore::join('chore_linked_members as c', 'c.chore_id', '=', 'chores.id')
                    ->select('chores.*')
                    ->where('c.user_id', $user->id)
                    ->orderBy('chores.id', 'DESC');
//                  dd(DB::getQueryLog()); // Show results of log
 switch ($request->filter_type) {
                case "sent":
                    $data->whereRaw('(chores.user_id=' . $user->id. ') ');
                    break;
                case "recieved":
                    $data->whereRaw('( ci.user_id=' . $user->id . ') ');
                    break;
                case "Inactive":
                    $data->where('chores.status','Inactive');
                    break;
                case "Active":
                    $data->where('chores.status','Active');
                    break;
                default:
               
            }

          

            //keyword
            if (!empty($request->keyword)) {
                $data->WhereRaw('(chores.title LIKE "%' . $request->keyword . '%" )');
            }

            return Datatables::of($data)
                            ->addIndexColumn()
                            ->filterColumn('chore', function ($query, $keyword) use ($request) {
                                $sql = " chores.title like ?";
                                $query->whereRaw($sql, ["%{$keyword}%"]);
                            })
                            ->addColumn('chore', function ($data) {

                                  return '<div class="actions text-right">
                          <span class="badge badge-xs bg-warning-light mt-1" title="Category"  >
                                                   '.\App\ChoreCategory::category_name($data->category_id) .'
                                                </span> <span class="badge badge-xs bg-' . (($data->status == 'Active' ) ? 'success' : 'warning') . '-light mt-1" title=" '.$data->status .'"  >
                                                  '.$data->status .'
                                                </span><br>
                                                <a class="badge badge-sm bg-primary-light mt-1" title="View Chore"  href="'.route('chore.details', encrypted_key($data->id, 'encrypt')).'">
                                                   '.ucfirst(substr($data->title ,0,30)).'..
                                                </a>
                                                
                                            </div>';
                            })
                            ->addColumn('price', function ($row) {
                                return format_price($row->price, 2);
                            })
                            ->addColumn('type', function ($row) {
                                return $row->typeOnChoice;
                            })
                            ->addColumn('time', function ($row) {
                                return ($row->start_time??"--") ." to ".($row->end_time??"--") ;
                            })
                            ->addColumn('day', function ($row) {
                                return !empty($row->day) ? implode(',', json_decode($row->day)) : '';
                            })
                            ->addColumn('date', function ($row) {
                              
                                    $date = \App\Utility::getDateFormated($row->start_date);
                               
                                return '<label class="badge  mb-0 h6 text-sm">' . $date . '</label>' . '<br>';
                                ;
                            })
                            ->rawColumns(['action', 'chore', 'price', 'members', 'day', 'date'])
                            ->make(true);
        } else {

            $opensch = Chore::join('chore_linked_members as c', 'c.chore_id', '=', 'chores.id')
                            ->where('c.user_id', $user->id)->where('chores.status', 'Active')->count();
            $closedsch = Chore::join('chore_linked_members as c', 'c.chore_id', '=', 'chores.id')
                            ->where('c.user_id', $user->id)->where('chores.status', 'Inactive')->count();
            $totalsch = $opensch + $closedsch;
           
            return view('chore.mydashboard', compact('opensch', 'closedsch', 'totalsch'));
        }
    }
public function getcategory($user_id = 0, $all = null) {
        if (!empty($all)) {
            $login_user_id = Auth::user()->id;
            $array = [0, $user_id, $login_user_id];
        } elseif (!empty($user_id)) {
            $array = [0, $user_id];
        } else {
            $user_id = Auth::user()->id;
            $array = [0, $user_id];
        }
        $categories = ChoreCategory::whereIn('user_id', $array)
                ->get();
        return $categories;
    }
      private function getToDoUpdatedHtml(){
        $user = Auth::user();
        $userId = (!empty($user)) ? $user->id : 0;
      
        $toDoPendings = ChoreToDo::where(["status" => ChoreToDo::STATUS_PENDING, "user_id" => $userId])->OrderBy('id','DESC')->get();
      
        $toDoComplete = ChoreToDo::where(["status" => ChoreToDo::STATUS_COMPLETED, "user_id" => $userId])->OrderBy('id','DESC')->get();
        return view('chore.todo.index',compact('toDoPendings', 'toDoComplete'))->render();
    }
    public function toDoUpdate(Request $request){
        $response = [
            "success" => false,
            "message" => ""
        ];
        try{
            $user = Auth::user();
            $userId = (!empty($user)) ? $user->id : 0;
            if($request->id!=""){
                $jobTodo = ChoreToDo::where(["user_id" => $userId, "id" => $request->id])->first();
                if(empty($jobTodo)){
                    $response["message"] = "To Do not found!";
                    return response()->json($response);
                }
            }
            switch ($request->type){
                case "save":
                    ChoreToDo::Create(["name" => $request->to_do_data["name"], "user_id" => $userId]);
                    $response["success"] = true;
                    $response["message"] = "To Do added successfully.";
                break;
                case "delete":
                    $jobTodo->delete();
                    $response["success"] = true;
                    $response["message"] = "To Do deleted successfully.";
                break;
                case "completed":
                    $jobTodo->update(["status" => ChoreToDo::STATUS_COMPLETED]);
                    $response["success"] = true;
                    $response["message"] = "To Do item completed successfully.";
                break;
                case "pending":
                    $jobTodo->update(["status" => ChoreToDo::STATUS_PENDING]);
                    $response["success"] = true;
                    $response["message"] = "To Do item added to pending.";
                break;
                case "clear":
                    $collection = ChoreToDo::where(["user_id" => $userId])->get(["id"]);
                    ChoreToDo::destroy($collection->toArray());
                    $response["success"] = true;
                    $response["message"] = "To Do clear successfully";
                break;
            }
            $toDoHtml = $this->getToDoUpdatedHtml();
            $response["to_do_html"] = $toDoHtml;
        }
        catch (\Exception $ex){
            $response["message"] = $ex->getMessage();
        } catch (\Throwable $ex) {
            $response["message"] = $ex->getMessage();
        }
        return response()->json($response);
    }
    public function details($id_encrypted = 0) {
        $user = Auth::user();
        $title = "Chore Details";
        $assigned = false;
        $id = !empty($id_encrypted) ? encrypted_key($id_encrypted, 'decrypt') : 0;
        if (!empty($id)) {
            $data = Chore::where('id',$id)->with(['comments'=>function($q) {
        $q->paginate(10);
},'category'])->first();
            $members = ChoreLinkedMembers::members($id);
            $comments = \App\ChoreComment::where('chore_id', $id)->orderBy('id', 'ASC')->count();
            $assigned = \App\ChoreAssigned::where('chore_id', $id)->where("user_id",$user->id)->where('date',date("Y-m-d") )->first();
             $toDoHtml = $this->getToDoUpdatedHtml();
            return view('chore.chore', compact('title', 'data', 'members', 'comments','assigned','toDoHtml'));
        }

        return redirect()->back()->with('error', __('Permission Denied.'));
    }

    public function chore_comments($id = 0) {
        $chore = Chore::find($id);
        $comments = \App\ChoreComment::where('chore_id', $id)->orderBy('id', 'ASC')->get();
        $files = \App\ChoreFile::where('chore_id', $id)->orderBy('id', 'ASC')->get();

        return view('chore.comments', compact('chore', 'comments', 'files'));
    }

    // Task files
    public function commentStoreFile(Request $request, $id) {
        $request->validate(
                ['file' => 'required|mimes:jpeg,jpg,png,gif,svg,pdf,txt,doc,docx,zip,rar|max:20480']
        );
        $fileName = $id . time() . "_" . $request->file->getClientOriginalName();
        $request->file->storeAs('chores', $fileName);
        $post['chore_id'] = $id;
        $post['file'] = $fileName;
        $post['name'] = $request->file->getClientOriginalName();
        $post['extension'] = $request->file->getClientOriginalExtension();
        $post['file_size'] = round(($request->file->getSize() / 1024) / 1024, 2) . ' MB';
        $post['created_by'] = \Auth::user()->id;
        $TaskFile = \App\ChoreFile::create($post);
        $user = $TaskFile->user;
        $TaskFile->deleteUrl = '';
        $TaskFile->deleteUrl = route(
                'chore.comment.destroy.file', [
            $id,
            $TaskFile->id,
                ]
        );

        return $TaskFile->toJson();
    }

    public function commentDestroyFile(Request $request, $id, $fileID) {
        $commentFile = \App\ChoreFile::find($fileID);
        $path = storage_path('chores/' . $commentFile->file);
        if (file_exists($path)) {
            \File::delete($path);
        }
        $commentFile->delete();

        return "true";
    }

    // Task Comments
    public function commentStore(Request $request, $id = 0) {
        $post = [];
        $post['chore_id'] = $id;
        $post['comment'] = $request->comment;
        $post['created_by'] = \Auth::user()->id;

        $comment = \App\ChoreComment::create($post);
        $user = $comment->user;

//        $comment->deleteUrl = route(
//            'comment.destroy', [
//                                 $projectID,
//                                 $taskID,
//                                 $comment->id,
//                             ]
//        );

        return $comment->toJson();
    }
    public function choreaction($action='',$id = 0) {
        $usr = Auth::user();
       if(!empty($id) && !empty($action)){
           $assginedto= \App\ChoreAssigned::find($id);
           if(!empty($assginedto) && ($usr->id==$assginedto->user_id || $usr->type=="admin" || $usr->type=="owner")){
               $update = array();
                $update['is_completed'] =$action=="complete" ? 1:0;
                $assginedto->update($update);

                $rolescheck = \App\Role::whereRole($usr->type)->first();               
                if($rolescheck->role == 'mentor'  ){
                    if(checkPlanModule('points')){
                        $checkPoint = \Ansezz\Gamify\Point::find(4);
                        if(isset($checkPoint) && $checkPoint != null ){
                            if($checkPoint->allow_duplicate == 0){
                                $createPoint = $usr->achievePoint($checkPoint);
                            }else{
                                $addPoint = DB::table('pointables')->where('pointable_id', $usr->id)->where('point_id', $checkPoint->id)->get();
                                if($addPoint == null){
                                    $createPoint = $usr->achievePoint($checkPoint);
                                }
                            }
                        }       
                    }
                }
                return redirect()->back()->with('success', __('Successfully updated.'));
           }
       }
        return redirect()->back()->with('error', __('Permission denied.'));
    }

    
    // Calendar View
    public function calendarView($assigned_to_id=0)
    {
        $usr = Auth::user();
        $permissions=permissions();
        if($usr->type)
        {
            $tasks = \App\ChoreAssigned::join('chores as c', 'chore_assigned.chore_id', '=', 'c.id')
                    ->select('chore_assigned.*','c.title','c.priority','c.description','c.status')
                    ->where('c.status', "Active");
            
            if(!empty($assigned_to_id) &&  $assigned_to_id !="all")
            {
                $tasks->where('chore_assigned.user_id', $assigned_to_id);
            }
            
           if(in_array("manage_chores",$permissions) || $usr->type =="admin" || checkPlanModule('chores')) {
               $tasks->where('c.user_id', $usr->id);                
            }else{
                $tasks->where('chore_assigned.user_id', $usr->id);
            }
            $tasks    = $tasks->get();
            $arrTasks = [];

            foreach($tasks as $task)
            {
                $arTasks = [];
                if(!empty($task->date) && $task->date != '0000-00-00')
                {
                    $arTasks['id']    = $task->chore_id;
                    $arTasks['title'] =\App\User::userInfo($task->user_id)->name. ": ".$task->title;
                    $arTasks['start'] = $task->date;
                    $arTasks['end'] = $task->date;                  

                    $arTasks['allDay']      = !0;
                    $arTasks['className']   = 'bg-' .(!empty($task->is_completed) ? "success" : \App\ChoreAssigned::$priority_color[$task->priority]);
                    $arTasks['description'] = $task->description;
                    $arTasks['url']         =route('chore.details', encrypted_key($task->chore_id, 'encrypt'));
                    $arTasks['resize_url']  ='';// route('task.calendar.drag', $task->id);

                    $arrTasks[] = $arTasks;
                }
            }
           
            $members = \App\ChoreMembers::members();
            return view('chore.calendar', compact('arrTasks', 'members','assigned_to_id'));
        }
        else
        {
            return redirect()->back()->with('error', __('Permission Denied.'));
        }
    }
    
    public function addcomment(Request $request)
    {
        $user = Auth::user();
        $comment = new ChoreComment;
        $comment->chore_id = $request->id;
        $comment->created_by = $user->id;
        $comment->comment = $request->comment;
        $comment->user_type = $user->type;
      
        $comment->save();
        $data =array();
        $data['name']=$user->name;
        $data['avatar']= asset('public/images/news-20.jpg');
        $data['time']='now';
        $data['comment']=$request->comment;
        $data['id']=$comment->id;
        $data['e_id']=  encrypted_key($comment->id, 'encrypt');
     return $data;
    }
    public function updatecomment(Request $request)
    {
        //dd($request->id);
        $user = Auth::user();
        $comment =  ChoreComment::find($request->id);
        $comment->comment = $request->comment;
       
        $comment->update();
        $data =array();
        $data['name']=$user->name;
        $data['avatar']= asset('public/images/news-20.jpg');
        $data['time']='now';
        $data['comment']=$request->comment;
        $data['id']=$comment->id;
        $data['e_id']=  encrypted_key($comment->id, 'encrypt');
     return $data;
    }
    public function destroycommment($id_enc) {
        
        $objUser = Auth::user();
       
        $id = !empty($id_enc) ? encrypted_key($id_enc, "decrypt") : 0;
       // dd($id);
        if (empty($id)) {
            return redirect()->back()->with('error', __('Permission Denied.'));
        }

            ChoreComment::where('id',$id)->delete();
        return redirect()->back()->with('success', __('Deleted.'));
        
    }
}
