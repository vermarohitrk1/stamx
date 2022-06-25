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
use Mail;
use DataTables;

class TemplateController extends Controller {

     //admin question
     public function questions(Request $request) {
        if (Auth::user()->type != 'admin') {
            return redirect()->back()->with('error', __('Permission Denied.'));
        } 
        $user = Auth::user();
        if ($request->ajax()) {
            $data = \App\Question::orderBy('id', 'ASC');
           
             return Datatables::of($data)
                            ->addIndexColumn()
                            ->filterColumn('question', function ($query, $keyword) use ($request) {
                                $sql = "question like ?";
                                $query->whereRaw($sql, ["%{$keyword}%"]);
                            })
                            ->addColumn('question', function ($data) {
                               return  $data->question;
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
                                                <a class="btn btn-sm bg-success-light" data-url="' . route('question.edit', encrypted_key($data->id, "encrypt")) . '" data-ajax-popup="true" data-size="md" data-title="Edit Question" href="#">
                                                    <i class="fas fa-pencil-alt"></i>
                                                    Edit
                                                </a>
                                                <a data-url="' . route('question.destroy', encrypted_key($data->id, "encrypt")) . '" href="#" class="btn btn-sm bg-danger-light delete_record_model">
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
            return view('admin.template.questions');
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
            'question' => 'required|max:200',
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
            $question_data = new \App\Question();
            $question_data['question'] = $request->question;
            if($request->type != 'text' && $request->type != 'file'){
                $question_data['value'] = json_encode($request->value);
            }
            $question_data['type'] = $request->type;
            
            $question_data->save();
        }
        else {
            $role_data = \App\Question::find($question_id);
            $post['question'] = $request->question;
            $post['type'] = $request->type;
            if($request->type != 'text'&& $request->type != 'file'){
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
      
        $data = \App\Question::find($question_id);
        return view('admin.template.role_form', compact('data'));
    }
      //delete question
      public function question_destroy($id_enc = 0) {
        $objUser = Auth::user();
        $question_id = !empty($id_enc) ? encrypted_key($id_enc, "decrypt") : 0;
        if ($objUser->type != "admin" || empty($question_id)) {
            return redirect()->back()->with('error', __('Permission Denied.'));
        }

        $data = \App\Question::find($question_id);
        $data->delete();
        return redirect()->back()->with('success', __('Deleted.'));
    }

    public function audit_price_show( $id) {
       $data = \App\Audit::find($id);
      // dd( $price);
       return view('admin.template.programable.audit_price', compact('data'));

    }
    public function request_audit_price( Request $request) {
        $data = \App\Audit::find(1);
        $data->price = $request->price;
        $data->update();
        return redirect()->back()->with('success', __('saved!'));
    }

     //admin programable question
     public function programable_questions(Request $request) {
        if (Auth::user()->type != 'admin') {
            return redirect()->back()->with('error', __('Permission Denied.'));
        } 
        $user = Auth::user();
        if ($request->ajax()) {
            $data = \App\Programable_question::orderBy('id', 'ASC');
           
             return Datatables::of($data)
                            ->addIndexColumn()
                            ->filterColumn('question', function ($query, $keyword) use ($request) {
                                $sql = "question like ?";
                                $query->whereRaw($sql, ["%{$keyword}%"]);
                            })
                            ->addColumn('question', function ($data) {
                               return  $data->question;
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
                                                <a class="btn btn-sm bg-success-light" data-url="' . route('programable_question.edit', encrypted_key($data->id, "encrypt")) . '" data-ajax-popup="true" data-size="md" data-title="Edit Question" href="#">
                                                    <i class="fas fa-pencil-alt"></i>
                                                    Edit
                                                </a>
                                                <a data-url="' . route('programable_question.destroy', encrypted_key($data->id, "encrypt")) . '" href="#" class="btn btn-sm bg-danger-light delete_record_model">
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
            return view('admin.template.programable.questions');
        }
    }

     //update programable question
     public function programable_update(Request $request) {
        $objUser = Auth::user();
        if ($objUser->type != "admin") {
            return redirect()->back()->with('error', __('Permission Denied.'));
        }
        $validate = [];
        $validate = [
            'question' => 'required|max:200',
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
            $question_data = new \App\Programable_question();
            $question_data['question'] = $request->question;
            if($request->type != 'text'){
                $question_data['value'] = json_encode($request->value);
            }
            $question_data['type'] = $request->type;
            $question_data->save();
        }
        else {
            $role_data = \App\Programable_question::find($question_id);
            $post['question'] = $request->question;
            $post['type'] = $request->type;
            if($request->type != 'text'){
                $question_data['value'] = json_encode($request->value);
            }
             
            $res = $role_data->update($post);
        }
        

        return redirect()->back()->with('success', __('saved!'));
    }
    //edit programable question
    public function programable_question_edit($id_enc = 0) {
        //dd($id_enc);
        $objUser = Auth::user();
        $role_id = !empty($id_enc) ? encrypted_key($id_enc, "decrypt") : 0;
        if ($objUser->type != "admin" || empty($role_id)) {
            return redirect()->back()->with('error', __('Permission Denied.'));
        }
        $question_id = !empty($id_enc) ? encrypted_key($id_enc, "decrypt") : 0;
      
        $data = \App\Programable_question::find($question_id);
        return view('admin.template.programable.role_form', compact('data'));
    }
      //delete programable question
      public function programable_question_destroy($id_enc = 0) {
        $objUser = Auth::user();
        $question_id = !empty($id_enc) ? encrypted_key($id_enc, "decrypt") : 0;
        if ($objUser->type != "admin" || empty($question_id)) {
            return redirect()->back()->with('error', __('Permission Denied.'));
        }

        $data = \App\Programable_question::find($question_id);
        $data->delete();
        return redirect()->back()->with('success', __('Deleted.'));
    }



     //admin programable category
     public function program_category(Request $request) {
        $objUser = Auth::user();
        if ($objUser->type != "admin") {
            return redirect()->back()->with('error', __('Permission Denied.'));
        }
        $user = Auth::user();
        if ($request->ajax()) {
            $data = \App\ProgramCategory::orderBy('id', 'ASC');
           
             return Datatables::of($data)
                            ->addIndexColumn()
                            ->addColumn('name', function ($data) {
                               return  $data->name;
                            })
                            ->filterColumn('name', function ($query, $keyword) use ($request) {
                                $sql = "name like ?";
                                $query->whereRaw($sql, ["%{$keyword}%"]);
                            })
                             
                            ->addColumn('action', function($data) {
                                $user = Auth::user();
                                if ($data->role != "admin") {
                                    $actionBtn = '<div class="actions text-right">
                                              <a class="btn btn-sm bg-success-light" data-url="' . route('program_category.edit', encrypted_key($data->id, "encrypt")) . '" data-ajax-popup="true" data-size="md" data-title="Edit Category" href="#">
                                                  <i class="fas fa-pencil-alt"></i>
                                              </a>
                                                <a data-url="' . route('program_category.destroy', encrypted_key($data->id, "encrypt")) . '" href="#" class="btn btn-sm bg-danger-light delete_record_model">
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
            return view('admin.template.program.category.questions');
        }
    }

     //update programable category
     public function program_category_update(Request $request) {
        $objUser = Auth::user();
        if ($objUser->type != "admin") {
            return redirect()->back()->with('error', __('Permission Denied.'));
        }
       
        if ($objUser->type != "admin") {
            return redirect()->back()->with('error', __('Permission Denied.'));
        }
        $validate = [];
        $validate = [
            'name' => 'required|max:200',
        ];
        $validator = Validator::make(
                        $request->all(), $validate
        );
        if ($validator->fails()) {
            return redirect()->back()->with('error', $validator->errors());
        }
        $question_id = !empty($request->id) ? encrypted_key($request->id, "decrypt") : 0;
       // dd($question_id);
        if (empty($question_id)) {
            $question_data = new \App\ProgramCategory();
            $question_data['name'] = $request->name;
            
            $question_data->save();
        }
        else {
            $role_data = \App\ProgramCategory::find($question_id);
            $post['name'] = $request->name;
          
             
            $res = $role_data->update($post);
        }
        

        return redirect()->back()->with('success', __('saved!'));
    }
    //edit programable category
    public function program_category_edit($id_enc = 0) {
        //dd($id_enc);
        $objUser = Auth::user();
        $role_id = !empty($id_enc) ? encrypted_key($id_enc, "decrypt") : 0;
        if ($objUser->type != "admin" || empty($role_id)) {
            return redirect()->back()->with('error', __('Permission Denied.'));
        }
        $question_id = !empty($id_enc) ? encrypted_key($id_enc, "decrypt") : 0;
      
        $data = \App\ProgramCategory::find($question_id);
        return view('admin.template.program.category.role_form', compact('data'));
    }
      //delete programable category
      public function program_category_destroy($id_enc = 0) {
        $objUser = Auth::user();
        $question_id = !empty($id_enc) ? encrypted_key($id_enc, "decrypt") : 0;
        if ($objUser->type != "admin" || empty($question_id)) {
            return redirect()->back()->with('error', __('Permission Denied.'));
        }

        $data = \App\ProgramCategory::find($question_id);
        $data->delete();
        return redirect()->back()->with('success', __('Deleted.'));
    }
}
