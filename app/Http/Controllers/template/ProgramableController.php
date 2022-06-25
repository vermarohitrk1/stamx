<?php

namespace App\Http\Controllers\template;

use App\User;
use App\Http\Controllers\Controller;
use Illuminate\Filesystem\Filesystem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\File;
use Mail;
use DataTables;

class ProgramableController extends Controller {

     //apply for program
     public function apply(Request $request) {
        $user = Auth::user();
        if (Auth::user()->type != 'mentor') {
            return redirect()->back()->with('error', __('Permission Denied.'));
        }
        $user_status = \App\ProgramApproval::where('user_id',$user->id)->first();
        $data = \App\Question::orderBy('id', 'ASC')->get();
       // dd($data);
            return view('admin.template.programable.apply_form')->with(['data'=> $data,'user_status'=>$user_status]);
       
    }


    public function approval_change_status(Request $request) {
        if (Auth::user()->type != 'admin') {
            return redirect()->back()->with('error', __('Permission Denied.'));
        }
        $id = $request->id;
        $user_id = !empty($id) ? encrypted_key($id, "decrypt") : 0;
        $approval = \App\ProgramApproval::where('user_id',$user_id);
       // dd($role_id);
        $data['status'] = $request->status;
        $approval->update($data);
$mentors = $approval->with('user')->first();
$userdata = $mentors->user ;

 
        if($request->status == 1){
          $status = 'accepted';
        }
        if($request->status == null){
            $status = 'pending';
        }
        if($request->status == 2){
            $status = 'rejected';
        }
        $emalbody= 'Your recommendation request for program has been '.$status.' by the admin.';

        $resp = \App\Utility::send_emails( $userdata->email, $userdata->name, null, $emalbody,'approves',$userdata);
       
         return redirect()->route('approval_listing')->with('success', __('Status Update successfully.'));
    }
  //edit approval
  public function approval_listing_edit($id_enc = 0) {
    $objUser = Auth::user();
    $role_id = !empty($id_enc) ? encrypted_key($id_enc, "decrypt") : 0;
    if ($objUser->type != "admin" || empty($role_id)) {
        return redirect()->back()->with('error', __('Permission Denied.'));
    }
    $data = \App\ProgramApproval::find($role_id);
    return view('admin.template.programable.approval_listing_form', compact('data'));
}
 //delete approval
 public function approval_destroy($id_enc = 0) {
    $objUser = Auth::user();
    $apply_id = !empty($id_enc) ? encrypted_key($id_enc, "decrypt") : 0;
    if ($objUser->type != "admin" || empty($apply_id)) {
        return redirect()->back()->with('error', __('Permission Denied.'));
    }

    $data = \App\ProgramApproval::where('user_id',$apply_id);
    $data->delete();
    return redirect()->back()->with('success', __('Deleted.'));
}
    public function store(Request $request) {
        
        $cleanup = $request->except('_token','csrf-token');
        //dd($cleanup);

       if(!empty($cleanup)){
        foreach ($cleanup as $i=>$row){
           if($request->hasFile($i)){
                $folderPath = "storage/program/";
              File::isDirectory($folderPath) or File::makeDirectory($folderPath, 0777, true, true);
                $fileName = 'q-' . time() . "_" . $request->$i->getClientOriginalName();
                $request->$i->storeAs('program', $fileName);
                $cleanup[$i]= $fileName;
                
           }
        }
       }
    
                   $data =  json_encode($cleanup);
        $user = Auth::user();
        $approval = new \App\ProgramApproval();
        $approval['user_id'] = $user->id;
        $approval['data'] = $data;
        $approval['status'] = 0;
        $approval->save();

         return redirect()->route('program.apply')->with('success', __('Form submit successfully.'));
    }
    public function approval_listing(Request $request) {
        
//$data = \App\ProgramApproval::orderBy('id', 'ASC')->with('user')->get();
       // dd($data);
       if (Auth::user()->type != 'admin') {
        return redirect()->back()->with('error', __('Permission Denied.'));
    }
       if ($request->ajax()) {
          $data = \App\ProgramApproval::select('*')->orderBy('id', 'ASC')->with('user');
         
           return Datatables::of($data)
                          ->addIndexColumn()
                          ->filterColumn('user_id', function ($query, $keyword) use ($request) {
                            $sql = "user_id like ?";
                            $query->whereRaw($sql, ["%{$keyword}%"]);
                        })
                          ->addColumn('email', function ($data) {
                            return  $data->user->email;
                            //  $user = User::find($data->user_id);
                             //return  $user->email;
                          })
                          ->addColumn('status', function ($data) {
                               if($data->status == 0){
                                $status = '<span class="badge  badge-xs bg-primary-light">Pending</span>';
                               }
                               else if($data->status == 1){
                                   $status = '<span class="badge  badge-xs bg-success-light">Accepted</span>';
                               }
                               else{
                                   $status = '<span class="badge badge-xs bg-danger-light">Rejected</span>';
                               }
                              return  $status;
                           })
                          ->addColumn('action', function($data) {
                              $user = Auth::user();
                              if ($data->role != "admin") {
                                  $actionBtn = '<div class="actions text-right">
                                              <a class="btn btn-sm bg-success-light"  href="' . route('approval_listing.show', encrypted_key($data->id, "encrypt")) . '">
                                              <i class="far fa-eye"></i>
                                                  
                                              </a>
                                              <a class="btn btn-sm bg-success-light" data-url="' . route('approval_listing.edit', encrypted_key($data->id, "encrypt")) . '" data-ajax-popup="true" data-size="md" data-title="Edit Status" href="#">
                                                  <i class="fas fa-pencil-alt"></i>
                                                  
                                              </a>
                                              <a data-url="' . route('approval_listing.destroy', encrypted_key($data->user_id, "encrypt")) . '" href="#" class="btn btn-sm bg-danger-light delete_record_model">
                                                  <i class="far fa-trash-alt"></i> Delete
                                              </a>
                                          </div>';
                              } else {
                                  $actionBtn = '';
                              }

                              return $actionBtn;
                          })
                          ->rawColumns(['action', 'status'])
                          ->make(true);
          
      } else {
   
         return view('admin.template.programable.approval_listing');
      }
          
       }
     
       public function approval_listing_show ($id) {
        
          $id = !empty($id) ? encrypted_key($id, "decrypt") : 0;
          $data = \App\ProgramApproval::where('id',$id)->with('user')->first();
          $quedata = \App\Question::get();
          $questions = array();
          foreach($quedata as $key => $question){
              $inc = $key+1;
            $questions['question_'.$inc] = $question->question; 
          }
          //dd($questions);
          return view('admin.template.programable.approval_listing_show')->with(['data'=> $data, 'questions'=>$questions]);

              
             }
}
