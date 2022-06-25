<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Task;
use App\TaskComment;
use App\PathwayInvitation;
use App\TaskCategory;
use File;
use DataTables;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Validator;
use Illuminate\Filesystem\Filesystem;
class TaskController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
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
    // dd( $request);


    $task = new Task;
    if (!empty($request->hasFile('attachment'))) {
        $fileNameToStore = time() . '.' . $request->attachment->getClientOriginalExtension();
        $course_details_file = $request->file('attachment')->storeAs('task', Str::random(20) . $fileNameToStore);
        $task->attachment = $course_details_file;
    }
      $image = '';
      if (!empty($request->image) && $request->image!= null ) {

        $base64_encode = $request->image;
        $folderPath = "storage/task/";
         if (!file_exists($folderPath)) {
File::isDirectory($folderPath) or File::makeDirectory($folderPath, 0777, true, true);
            }
        $image_parts = explode(";base64,", $base64_encode);
     //   dd( $image_parts);
        $image_type_aux = explode("image/", $image_parts[0]);
        $image_type = $image_type_aux[1];
        $image_base64 = base64_decode($image_parts[1]);
        $image = "task" . uniqid() . '.' . $image_type;
        $file = $folderPath . $image;
       // dd( $file);
        file_put_contents($file, $image_base64);
    }
   // dd($image);
        $p_id = encrypted_key($request->pathway_id, 'decrypt') ?? $request->pathway_id;
        $user = Auth::user();
     
        $task->user_id = $user->id;
        $task->pathway_id = $p_id;
        $task->name = $request->name;
        $task->description = $request->description;
        $task->type = $request->category_id;
        $task->image = $image;
        $task->due_date = $request->due_date;
        $task->save();
       $alluser = PathwayInvitation::where('pathway_id',$p_id)->with('user')->get();
       foreach($alluser as $key => $users){
        $userdata= $users->user;   
        $emalbody=[
           'note'=>'Task asssign successfully!',
        ];
   // dd($userdata->email);
if (isset($userdata->email)){
     $resp = \App\Utility::send_emails($userdata->email, $userdata->name, null, $emalbody,'task_assign_pathway',$userdata);
  }
       
       
       

       }


         return redirect()->back()->with('success', __('Task added successfully.'));
   
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
       // dd($id);
        $taskcategory = TaskCategory::get();
        //dd($taskcategory);
        return view('task.create')->with(['id'=>$id,'taskcategory'=>$taskcategory]);
    }

    public function showtask($id)
    {
        $t_id = !empty($id) ? encrypted_key($id, "decrypt") : 0;

       $task = Task::where('id',$t_id)->with(['comments'=>function($q) {$q->paginate(10);},'category'])->first();
       $task_comment = TaskComment::where('task_id',$t_id)->paginate(10);

      // dd(  $task_comment);
        return view('task.showtask')->with(['task'=> $task, 'task_comment' => $task_comment]);
    }

    public function showtaskcomment(Request $request)
    {
       
if ($request->ajax()) {
    $t_id = !empty($id) ? encrypted_key($id, "decrypt") : 0;
     $comment = TaskComment::where('task_id',$t_id)->paginate(10);
    // dd($comment);

}
        return view('task.showtask')->with('task',$task);
    }
    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $t_id = !empty($id) ? encrypted_key($id, "decrypt") : 0;
        $task = Task::find($t_id);
        $taskcategory = TaskCategory::get();
        return view('task.update')->with(['task'=>$task,'taskcategory'=>$taskcategory]);
    }
    public function addcomment(Request $request)
    {
        $user = Auth::user();
        $comment = new TaskComment;
        $comment->task_id = $request->id;
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
        $comment =  TaskComment::find($request->id);
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
        $task =  Task::find($request->task_id);
        $task->name = $request->name;
        $task->description = $request->description;
        $task->type = $request->category_id;
        $task->due_date = $request->due_date;
        if (!empty($request->attachment)) {
  
            $base64_encode = $request->attachment;
            $folderPath = "storage/task/";
             if (!file_exists($folderPath)) {
    File::isDirectory($folderPath) or File::makeDirectory($folderPath, 0777, true, true);
                }
            $image_parts = explode(";base64,", $base64_encode);
         //   dd( $image_parts);
            $image_type_aux = explode("image/", $image_parts[0]);
            $image_type = $image_type_aux[1];
            $image_base64 = base64_decode($image_parts[1]);
            $image = "task" . uniqid() . '.' . $image_type;
            $file = $folderPath . $image;
           // dd( $file);
            file_put_contents($file, $image_base64);
            $task->attachment = $image;
        }
        $task->save();
      
         return redirect()->back()->with('success', __('Task updated successfully.'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroytask($id_enc) {
        
        $objUser = Auth::user();
       
        $id = !empty($id_enc) ? encrypted_key($id_enc, "decrypt") : 0;
       // dd($id);
        if (empty($id)) {
            return redirect()->back()->with('error', __('Permission Denied.'));
        }

        $task = Task::find($id);
        $task->delete();
        return redirect()->back()->with('success', __('Deleted.'));
        
    }
    public function destroy($id_enc) {
        
        $objUser = Auth::user();
       
        $id = !empty($id_enc) ? encrypted_key($id_enc, "decrypt") : 0;
       // dd($id);
        if (empty($id)) {
            return redirect()->back()->with('error', __('Permission Denied.'));
        }

        $task = TaskComment::find($id);
        $task->delete();
        return redirect()->back()->with('success', __('Deleted.'));
        
    }


    //task category

    public function TaskCategoriesIndex(Request $request)
    {

        $authuser = Auth::user();
        if ($request->ajax()) {
            $authuser = Auth::user();
            $data = TaskCategory::select('id','name','icon')->orderByDesc('id');
            return Datatables::of($data)
                ->addIndexColumn()
                ->filterColumn('name', function ($query, $keyword) use ($request) {
                    $sql = "task_categories.name like ?";
                    $query->whereRaw($sql, ["%{$keyword}%"]);
                })->addColumn('name', function ($data) {
                    if (!empty($data->icon)) {
                        if (file_exists(storage_path() . '/task/icon/' . $data->icon)) {
                            $url = asset('storage/task/icon/' . $data->icon);
                        } else {
                            $url = asset('public/assets_admin/img/user/user.jpg');
                        }
                    } else {
                        $url = asset('public/assets_admin/img/user/user.jpg');
                    }
                    $html='<h2 class="table-avatar"><a href="#" class="avatar avatar-sm mr-2"><img class="avatar-img rounded-circle" src="'.$url.'" alt="'.$data->name.'"></a><a href="#">'.$data->name.'</a></h2>';
                    return $html;
                })->addColumn('action', function ($data) {
                    if ($data->id == 0) {
                        $actionBtn = '<i class="fas fa-exclamation-triangle text-center"></i>';
                    } else {
                        $actionBtn = '';
                    
                        
                          $actionBtn = '<div class="actions text-right">
                                                <a class="btn btn-sm bg-success-light" data-title="Edit Category" href="'.route('task.category.edit', encrypted_key($data->id, 'encrypt')).'">
                                                    <i class="fas fa-pencil-alt"></i>
                                                    Edit
                                                </a>
                                                <a data-url="' . route('task.category.destroy',encrypted_key($data->id,'encrypt')) . '" href="#" class="btn btn-sm bg-danger-light delete_record_model">
                                                    <i class="far fa-trash-alt"></i> Delete
                                                </a>
                                            </div>';
                    }
                    return $actionBtn;
                })
                ->rawColumns(['name', 'action'])
                ->make(true);
        }
        return view('task.taskCategories.index');
    }

    public function TaskCategoriesCreate()
    {
        return view('task.taskCategories.create');
    }

    public function TaskCategoriesFeatchdata($view = 'list')
    {
        $authuser = Auth::user();
        $TaskCategories = TaskCategory::select('id','name')->where('user_id', '=', $authuser->id)->orwhere('user_id', '=', '0')->orderByDesc('id')->get();
        return view('task.taskCategories.list', compact('view', 'TaskCategories'));
    }

    public function TaskCategoriesEdit($id=0)
    {
        $id = encrypted_key($id, 'decrypt') ?? $id;
         if (empty($id)) {
            return redirect()->back()->with('success', __('Id is mismatch.'));
        } 
        $TaskCategory = TaskCategory::find($id);
        return view('task.taskCategories.edit', compact('TaskCategory'));
    }

    public function TaskCategoriesDestroy($id=0)
    {
        $id = encrypted_key($id, 'decrypt') ?? $id;
        if (empty($id)) {
            return redirect()->back()->with('success', __('Id is mismatch.'));
        } 
    
            $TaskCategory = TaskCategory::find($id);
            $TaskCategory->delete();
            return redirect()->back()->with('success', __('Task Category deleted successfully.'));
       
    }

    public function TaskCategoriesUpdate(Request $request)
    {
        $validator = Validator::make(
            $request->all(), [
                'name' => 'required',
            ]
        );

        if ($validator->fails()) {
            return redirect()->back()->with('error', $validator->errors()->first());
        }
         $image='';
        if (!empty($request->image)) {

            $base64_encode = $request->image;
            $folderPath = "storage/task/icon/";
             if (!file_exists($folderPath)) {
             File::isDirectory($folderPath) or File::makeDirectory($folderPath, 0777, true, true);
                }
            $image_parts = explode(";base64,", $base64_encode);
            $image_type_aux = explode("image/", $image_parts[0]);
            $image_type = $image_type_aux[1];
            $image_base64 = base64_decode($image_parts[1]);
            $image = "task" . uniqid() . '.' . $image_type;
            $file = $folderPath . $image;
            file_put_contents($file, $image_base64);
        }
       
         
        $post = $request->all();
        $TaskCategory = TaskCategory::find($request->id);
         $TaskCategory->name = $request->name;
         if(!empty($image)){
         $TaskCategory->icon = $image;
         }
        $TaskCategory->update($post);

        return redirect()->route('task.categories')->with('success', __('Task Category Updated successfully.'));
    }

    public function TaskCategoriesStore(Request $request)
    {
        $user = Auth::user();
        $TaskCategory = new TaskCategory();
        $image='';
        if (!empty($request->image)) {

            $base64_encode = $request->image;
            $folderPath = "storage/task/icon/";
             if (!file_exists($folderPath)) {
File::isDirectory($folderPath) or File::makeDirectory($folderPath, 0777, true, true);
                }
            $image_parts = explode(";base64,", $base64_encode);
            $image_type_aux = explode("image/", $image_parts[0]);
            $image_type = $image_type_aux[1];
            $image_base64 = base64_decode($image_parts[1]);
            $image = "task" . uniqid() . '.' . $image_type;
            $file = $folderPath . $image;
            file_put_contents($file, $image_base64);
        }
        $TaskCategory['name'] = $request->name;
         $TaskCategory['icon'] = $image;
        $TaskCategory['user_id'] = $user->id;
        $TaskCategory->save();
        if ($TaskCategory) {
            return redirect()->back()->with('success', __('Task Category Added successfully.'));
        }
    }

}
