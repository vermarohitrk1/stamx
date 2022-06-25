<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\ChoreCategory;
use App\Chore;
use App\ChoreInvitation;
use App\ChoreComment;
use File;
use DataTables;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Validator;
use Illuminate\Filesystem\Filesystem;
use Carbon\Carbon;
class ChoreController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
     
        $user = Auth::user();
        $domain_owner = get_domain_user();
        if ($request->ajax()) { 
            
       $data = Chore::select('chores.*')
               ->leftjoin("chore_invitations as ci","ci.chore_id","=","chores.id")
               ->groupBy('chores.id')
               ->orderBy('chores.id', 'DESC');
       
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
                    $data->whereRaw('(chores.user_id=' . $user->id . ' OR ci.user_id=' . $user->id . ') ');
                    break;
            }

            //status
            if (!empty($request->filter_category)) {
                $data->where('chores.type', $request->filter_category);
            }

            //keyword
            if (!empty($request->keyword)) {
                $data->WhereRaw('(chores.name LIKE "%' . $request->keyword . '%" )');
            }

       return Datatables::of($data)
       ->addIndexColumn()
       ->filterColumn('name', function ($query, $keyword) use ($data) {
           $sql = "chores.name like ?";
           $query->whereRaw($sql, ["%{$keyword}%"]);
       })
       
       ->addColumn('name', function ($data) {
          
              return ucfirst(substr($data->name,0,20))."..";
       })
      
       ->addColumn('type', function ($data) {
           if($data->category != null){
            return $data->category->name??'Unknown';
           }
           else{
               return  'not available';
           }
           
       })
       ->addColumn('due_date', function ($data) {
        return  date('M d, Y', strtotime($data->start_date));;
    })
       ->addColumn('ctype', function ($data) {
             $authId = Auth::user()->id;
        return (($data->user_id==$authId)?'<span class="btn btn-sm bg-danger-light" >Own</span>':'<span class="btn btn-sm bg-success-light" >Received</span><br>').'<span class="mt-1 btn btn-xs bg-'.($data->status=="Active"?"success":'danger').'-light" >'.$data->status.'</span>';
    })

                            ->addColumn('day', function ($row) {
                                  $res= $row->typeOnChoice;
                                  if(!empty($row->day)){
                                 $res .='<br>'. implode(',', json_decode($row->day));
                                  }
                                 return $res;
                            })
    ->addColumn('created_by', function ($data) {
        $user=\App\User::find($data->user_id);
           return '<h2 class="table-avatar">
                                                <a href="' . route('profile', ['id' => encrypted_key($data->user_id, 'encrypt')]) . '" class="avatar avatar-sm mr-2"><img class="avatar-img rounded-circle" src="' . $user->getAvatarUrl() . '" alt="Image"></a>
                                                <a href="' . route('profile', ['id' => encrypted_key($data->user_id, 'encrypt')]) . '">' . $user->name . '</a>
                                            </h2>';
     
    })
      
       ->addColumn('action', function($data){
        $actionBtn ='';
        $authId = Auth::user()->id;
           $actionBtn .= '<a class="btn btn-sm bg-warning-light mt-1" href="'. route('chore.showchore', encrypted_key($data->id, 'encrypt')) .'"  >
           <i class="fa fa-comment" aria-hidden="true"></i>
           </a>';
           if( $authId == $data->user_id ){
                 $actionBtn .= '<a class="btn btn-sm bg-primary-light ml-1 mt-1" data-url="' . route('chore.invite', encrypted_key($data->id, "encrypt")) . '" data-ajax-popup="true" data-size="md" data-title="Assign To Users" href="#">
                                             <i class="fa fa-user-plus"></i>                                             
                                         </a>';
                        
            $actionBtn .= '  <a class="btn btn-sm bg-success-light mt-1" data-url="' . route('chore.edit', encrypted_key($data->id, "encrypt")) . '" data-ajax-popup="true" data-size="md" data-title="Edit Chore" href="#">
            <i class="fas fa-pencil-alt"></i>
            
        </a>
        <a data-url="' . route('chore.destroy', encrypted_key($data->id, 'encrypt')) . '" href="#" class="btn btn-sm bg-danger-light mt-1 delete_record_model">
            <i class="far fa-trash-alt"></i> 
        </a>';
           }
        
        
  
        return $actionBtn;
    })
    
       ->rawColumns(['action','created_by','due_date','type','name','ctype','day'])
       ->make(true);   


        }else{
        $categories = self::getcategory($domain_owner->id??1, 1);
        $title = "Chore Dashboard";

        $stats['total'] =Chore::whereRaw('(chores.user_id=' . $user->id . ') ')->count();
        $stats['invited'] = ChoreInvitation::join("chores as c","chore_invitations.chore_id","=","c.id")
               ->whereRaw('(c.user_id=' . $user->id  . ') ')->count();;
        $stats['received'] =ChoreInvitation::join("chores as c","chore_invitations.chore_id","=","c.id")
               ->whereRaw('(chore_invitations.user_id=' . $user->id  . ') ')->count();;
     
        return view('chore.index', compact('title', 'categories', 'stats'));
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
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
      
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
   $validation = [
            'name' => 'required',
            'description' => 'required',
            'typeOnChoice' => 'required',
            'start_date' => 'required',
        ];

        $validator = Validator::make(
                        $request->all(), $validation
        );

        if ($validator->fails()) {
            return redirect()->back()->with('error', $validator->errors()->first());
        }


    $chore = new Chore;
    if (!empty($request->hasFile('attachment'))) {
        $fileNameToStore = time() . '.' . $request->attachment->getClientOriginalExtension();
        $course_details_file = $request->file('attachment')->storeAs('chore', Str::random(20) . $fileNameToStore);
        $chore->attachment = $course_details_file;
    }
      $image = '';
      if (!empty($request->image) && $request->image!= null ) {

        $base64_encode = $request->image;
        $folderPath = "storage/chore/";
         if (!file_exists($folderPath)) {
File::isDirectory($folderPath) or File::makeDirectory($folderPath, 0777, true, true);
            }
        $image_parts = explode(";base64,", $base64_encode);
     //   dd( $image_parts);
        $image_type_aux = explode("image/", $image_parts[0]);
        $image_type = $image_type_aux[1];
        $image_base64 = base64_decode($image_parts[1]);
        $image = "chore" . uniqid() . '.' . $image_type;
        $file = $folderPath . $image;
       // dd( $file);
        file_put_contents($file, $image_base64);
    }
   // dd($image);

        $user = Auth::user();
     
        $chore->user_id = $user->id;
        $chore->name = $request->name;
        $chore->description = $request->description;
        $chore->type = $request->category_id;
        $chore->image = $image;
            $chore->status = $request->status;
                 $chore->priority = $request->priority;
                 $chore->typeOnChoice = $request->typeOnChoice;
                 $chore->day = $request->day ? json_encode($request->day) : NULL;
                 $chore->start_date = $request->start_date;
                 $chore->end_date = $request->end_date;
                 $chore->start_time = $request->start_time;
                 $chore->end_time = $request->end_time;
        $chore->save();
      
         return redirect()->back()->with('success', __('Chore added successfully.'));
   
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show()
    {
        $user=Auth::user();
        $permissions=permissions();
  if (!in_array("manage_chores",$permissions) && $user->type !="admin")  {
            return redirect()->back()->with('error', __('Permission Denied.'));
        } 
       // dd($id);
         $chorecategory = self::getcategory($user->id??1, 1);
        //dd($chorecategory);
        return view('chore.create')->with(['chorecategory'=>$chorecategory]);
    }

    public function showchore($id)
    {
        $t_id = !empty($id) ? encrypted_key($id, "decrypt") : 0;

       $chore = Chore::where('id',$t_id)->with(['comments'=>function($q) {
        $q->paginate(10);
},'category'])->first();

$members= ChoreInvitation::where('chore_id',$t_id)->get();
   
         return view('chore.showchore', compact('chore','members'));
    }

    public function showchorecomment(Request $request)
    {
       
if ($request->ajax()) {
    $t_id = !empty($id) ? encrypted_key($id, "decrypt") : 0;
     $comment = ChoreComment::where('chore_id',$t_id)->paginate(10);
     dd($comment);

}
        return view('chore.showchore')->with('chore',$chore);
    }
    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $user=Auth::user();
        $permissions=permissions();
  if (!in_array("manage_chores",$permissions) && $user->type !="admin")  {
            return redirect()->back()->with('error', __('Permission Denied.'));
        } 
        $t_id = !empty($id) ? encrypted_key($id, "decrypt") : 0;
        $chore = Chore::find($t_id);
         $chorecategory = self::getcategory($user->id??1, 1);
        return view('chore.update')->with(['chore'=>$chore,'chorecategory'=>$chorecategory]);
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
    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
     
    
        $user = Auth::user();
        $chore =  Chore::find($request->chore_id);
        $chore->name = $request->name;
        $chore->description = $request->description;
        $chore->type = $request->category_id;
             $chore->status = $request->status;
                 $chore->priority = $request->priority;
                 $chore->typeOnChoice = $request->typeOnChoice;
                 $chore->day = $request->day ? json_encode($request->day) : NULL;
                 $chore->start_date = $request->start_date;
                 $chore->end_date = $request->end_date;
                 $chore->start_time = $request->start_time;
                 $chore->end_time = $request->end_time;
        if (!empty($request->attachment)) {
  
            $base64_encode = $request->attachment;
            $folderPath = "storage/chore/";
             if (!file_exists($folderPath)) {
    File::isDirectory($folderPath) or File::makeDirectory($folderPath, 0777, true, true);
                }
            $image_parts = explode(";base64,", $base64_encode);
         //   dd( $image_parts);
            $image_type_aux = explode("image/", $image_parts[0]);
            $image_type = $image_type_aux[1];
            $image_base64 = base64_decode($image_parts[1]);
            $image = "chore" . uniqid() . '.' . $image_type;
            $file = $folderPath . $image;
           // dd( $file);
            file_put_contents($file, $image_base64);
            $chore->attachment = $image;
        }
        $chore->save();
      
         return redirect()->route('chore.index')->with('success', __('Chore updated successfully.'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroychore($id_enc) {
        
        $objUser = Auth::user();
       
        $id = !empty($id_enc) ? encrypted_key($id_enc, "decrypt") : 0;
       // dd($id);
        if (empty($id)) {
            return redirect()->back()->with('error', __('Permission Denied.'));
        }

        $chore = Chore::find($id);
        $chore->delete();
        return redirect()->back()->with('success', __('Deleted.'));
        
    }
    public function destroy($id_enc) {
        
        $objUser = Auth::user();
       
        $id = !empty($id_enc) ? encrypted_key($id_enc, "decrypt") : 0;
       // dd($id);
        if (empty($id)) {
            return redirect()->back()->with('error', __('Permission Denied.'));
        }

        $chore = ChoreComment::find($id);
        $chore->delete();
            ChoreInvitation::where('chore_id',$id)->delete();
            ChoreComment::where('chore_id',$id)->delete();
        return redirect()->back()->with('success', __('Deleted.'));
        
    }


 public function invite($id) {
       
        $id = encrypted_key($id, 'decrypt') ?? $id;
        
        $chore = Chore::find($id);
        $users = ChoreInvitation::where('chore_id',$id)->pluck('user_id')->toArray();
        //dd($pathway);
        $authuser = Auth::user();
       // $categories = $this->getcategory();
		//return view('pathways.create',compact('categories','authuser'));
        $mentor = \App\User::where('created_by',$authuser->id)->orderBy('id', 'DESC')->get();
       // dd( $mentor);
        return view('chore.invite')->with(['chore'=>$chore,'mentor'=>$mentor,'users'=>$users]);
    }
    
    public function updateinvitation(Request $request) {
        if( $request->mentor_id != null){
            $id = !empty($request->id) ? encrypted_key($request->id, "decrypt") : 0;
           
            $chore = Chore::find($id);
             ChoreInvitation::where('chore_id',$id)->delete();
          
           foreach($request->mentor_id as $key => $invitation){
            $choreinvitation = new ChoreInvitation;
            $choreinvitation->chore_id = $id;
            $choreinvitation->user_id = $invitation;
            $choreinvitation->status = 0;
            $choreinvitation->seen = 1;
            $choreinvitation->save();
         
             $user_data=\App\User::find($invitation);
            //send email template
            $body=[
                'Chore Title'=>$chore->Name,
                'Assigned At'=>date('F d, Y H:i:s', strtotime(Carbon::now())),
            ];
            send_email($user_data->email, $user_data->name, null, $body,'chore_assign_email',$user_data);
           

           }
     
            // $chore->update();
             return redirect()->route('chore.index')->with('success', __('Invitation saved successfully.'));
        
            
        }
    }
    // Calendar View
    public function calendarView($assigned_to_id=0)
    {
        $usr = Auth::user();
        if($usr->type)
        {
            $tasks = \App\ChoreInvitation::join('chores as c', 'chore_invitations.chore_id', '=', 'c.id')
                    ->select('chore_invitations.*','c.name','c.priority','c.description','c.status')
                    ->where('c.status', "Active");
            
            if(!empty($assigned_to_id) &&  $assigned_to_id !="all")
            {
                $tasks->where('chore_invitations.user_id', $assigned_to_id);
            }
            
             $user=Auth::user();
        $permissions=permissions();
  if (!in_array("manage_chores",$permissions) && $user->type !="admin")  {
      
              $tasks->where('chore_invitations.user_id', $user->id);
        } else{
             $tasks->where('c.user_id', $user->id); 
        }
           
            $tasks    = $tasks->get();
            $arrTasks = [];
         
            foreach($tasks as $task)
            {
                $arTasks = [];
                if(!empty($task->date) && $task->date != '0000-00-00')
                {
                    $arTasks['id']    = $task->chore_id;
                    $arTasks['title'] =\App\User::find($task->user_id)->name. ": ".$task->name;
                    $arTasks['start'] = $task->date;
                    $arTasks['end'] = $task->date;                  

                    $arTasks['allDay']      = !0;
                    $arTasks['className']   = 'bg-' .(!empty($task->status) ? "success" : \App\ChoreInvitation::$priority_color[$task->priority]);
                    $arTasks['description'] = $task->description;
                    $arTasks['url']         =route('chore.details', encrypted_key($task->chore_id, 'encrypt'));
                    $arTasks['resize_url']  ='';// route('task.calendar.drag', $task->id);

                    $arrTasks[] = $arTasks;
                }
            }
               echo "<pre>";
            print_r($arrTasks);
            exit;
            $members = \App\ChoreInvitation::members();
            return view('chore.calendar', compact('arrTasks', 'members','assigned_to_id'));
        }
        else
        {
            return redirect()->back()->with('error', __('Permission Denied.'));
        }
    }
    
}
