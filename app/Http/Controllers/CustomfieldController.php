<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use App\Http\Controllers\Controller;
use Illuminate\Filesystem\Filesystem;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Schema;
use Mail;
use DataTables;
class CustomfieldController extends Controller
{
    public function questions(Request $request) {
        if (Auth::user()->type != 'admin') {
            return redirect()->back()->with('error', __('Permission Denied.'));
        } 
        $user = Auth::user();
        if ($request->ajax()) {
            $data = \App\CustomField::orderBy('id', 'ASC');
           
             return Datatables::of($data)
                            ->addIndexColumn()
                            ->filterColumn('label', function ($query, $keyword) use ($request) {
                                $sql = "label like ?";
                                $query->whereRaw($sql, ["%{$keyword}%"]);
                            })
                            ->addColumn('label', function ($data) {
                               return  $data->label;
                            })
                            ->addColumn('type', function ($data) {
                                return  $data->type;
                             })
                             ->addColumn('value', function ($data) {
                                 $data = json_decode($data->value,'true');
                                return  $data;
                             })
                            ->addColumn('action', function($data) {
                                $user = Auth::user();
                                if ($data->role != "admin") {
                                    $actionBtn = '<div class="actions text-right">
                                                <a class="btn btn-sm bg-success-light" data-url="' . route('customfield.edit', encrypted_key($data->id, "encrypt")) . '" data-ajax-popup="true" data-size="md" data-title="Edit Question" href="#">
                                                    <i class="fas fa-pencil-alt"></i>
                                                    Edit
                                                </a>
                                                <a data-url="' . route('customfield.destroy', encrypted_key($data->id, "encrypt")) . '" href="#" class="btn btn-sm bg-danger-light delete_record_model">
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
            // return view('admin.roles');
        } else {
           // return view('customfield.questions');
        }

    }

     //update question
     public function role_update(Request $request) {
        // dd($request);
        $objUser = Auth::user();
        if ($objUser->type != "admin") {
            return redirect()->back()->with('error', __('Permission Denied.'));
        }
        $validate = [];
        $validate = [
            'label' => 'required|max:200',
        ];
        $validator = Validator::make(
                        $request->all(), $validate
        );
        if ($validator->fails()) {
            return redirect()->back()->with('error', $validator->errors());
        }
        $question_id = !empty($request->id) ? encrypted_key($request->id, "decrypt") : 0;
        //dd($question_id);
        if (empty($question_id)) {
            $question_data = new \App\CustomField();
            $question_data['label'] = $request->label;
            if($request->type != 'text'){
                $question_data['value'] = json_encode($request->value);
            }
            $question_data['type'] = $request->type;
            
            $question_data->save();
        }
        else {
            $role_data = \App\CustomField::find($question_id);
            $post['label'] = $request->label;
            $post['type'] = $request->type;
            if($request->type != 'text'){
                $question_data['value'] = json_encode($request->value);
            }
             
            $res = $role_data->update($post);
        }
      //  dd($question_data);

        return redirect()->back()->with('success', __('saved!'));
    }
    //edit question
    public function question_edit($id_enc = 0) {
        //dd($id_enc);
        $objUser = Auth::user();
        $role_id = !empty($id_enc) ? encrypted_key($id_enc, "decrypt") : 0;
        if ($objUser->type != "admin" || empty($role_id)) {
            return redirect()->back()->with('error', __('Permission Denied.'));
        }
        $question_id = !empty($id_enc) ? encrypted_key($id_enc, "decrypt") : 0;
      
        $data = \App\CustomField::find($question_id);
        return view('customfield.role_form', compact('data'));
    }
      //delete question
      public function question_destroy($id_enc = 0) {
        $objUser = Auth::user();
        $question_id = !empty($id_enc) ? encrypted_key($id_enc, "decrypt") : 0;
        if ($objUser->type != "admin" || empty($question_id)) {
            return redirect()->back()->with('error', __('Permission Denied.'));
        }

        $data = \App\CustomField::find($question_id);
        $data->delete();
        return redirect()->back()->with('success', __('Deleted.'));
    }

 

     

}
