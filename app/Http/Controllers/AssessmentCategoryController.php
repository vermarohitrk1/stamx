<?php

namespace App\Http\Controllers;

use App\AssessmentCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;
use DataTables;

class AssessmentCategoryController extends Controller {

    public function index($view = 'grid') {
        $authuser = Auth::user();
        if ($authuser->type == 'admin') {
            $allow = true;
            return view('assessment.assessmentCategory.index', compact('view', 'allow'));
        } else {
            return redirect()->back()->with('error', __('Permission Denied.'));
        }
    }

    public function create() {
        $user = Auth::user();
        if ($user->type == 'admin') {
            return view('assessment.assessmentCategory.create');
        } else {
            return redirect()->back()->with('error', __('Permission Denied.'));
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request) {
        $authuser = Auth::user();
        if ($authuser->type == 'admin') {

            $validation = [
                'name' => 'required|max:120'
            ];


            $validator = Validator::make(
                            $request->all(), $validation
            );

            if ($validator->fails()) {
                return redirect()->back()->with('error', $validator->errors()->first());
            }

            $assessment_categories = new AssessmentCategory();
            $assessment_categories['name'] = $request->name;
            $assessment_categories->save();

            return redirect()->back()->with('success', __('assessment Category added successfully.'));
        } else {
            return redirect()->back()->with('error', __('Permission Denied.'));
        }
    }

    public function view($view = 'list', Request $request) {

        $authuser = Auth::user();
        if ($authuser->type == 'admin') {
        if ($request->ajax()) {  
            $data = AssessmentCategory::all();
            return Datatables::of($data)
                ->addIndexColumn()
                ->addColumn('name', function ($data) {
                    return $data->name;
                 }) 

                ->addColumn('action', function($data){
                      $actionBtn = '<div class="actions  ">
                        
                                                <a class="btn btn-sm bg-success-light mt-1" data-title="Edit " href="'.route("assessmentCategory.edit",encrypted_key($data->id,'encrypt')).'">
                                                    <i class="fas fa-pencil-alt"></i>
                                                    Edit
                                                </a>
                                                <a data-url="' . route('assessmentCategory.destroy',encrypted_key($data->id,'encrypt')) . '" href="#" class="btn btn-sm bg-danger-light delete_record_model mt-1">
                                                    <i class="far fa-trash-alt"></i> Delete
                                                </a>
                                            </div>';
                    
                   
                return $actionBtn;
                
                })
                ->rawColumns(['action'])
                ->make(true);
                return view('assessment.assessmentCategory.list');
        }else{
            if ($authuser->type == 'admin') {
                $allow = true;
    
                $assessment_categories = AssessmentCategory::paginate(6);
                return view('assessment.assessmentCategory.list', compact('view', 'allow', 'assessment_categories'));
            } else {
                return redirect()->back()->with('error', __('Permission Denied.'));
            }
        }
    }    
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\AssessmentCategory  $assessmentCategory
     * @return \Illuminate\Http\Response
     */
    public function show(AssessmentCategory $assessmentCategory) {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\AssessmentCategory  $assessmentCategory
     * @return \Illuminate\Http\Response
     */
    public function edit($id) {
        $user = Auth::user();
        $category_id = !empty($id) ? encrypted_key($id, 'decrypt') : 0;
        if (!empty($category_id) && $user->type == 'admin') {
            $assessmentCategory = AssessmentCategory::where('id',$category_id)->first();
            return view('assessment.assessmentCategory.edit', compact('assessmentCategory'));
        } else {
            return redirect()->back()->with('error', __('Permission Denied.'));
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\AssessmentCategory  $assessmentCategory
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request) {
        $user = Auth::user();
        $category_id = !empty($request->id) ? encrypted_key($request->id, 'decrypt') : 0;
        if (!empty($category_id) && $user->type == 'admin') {
            $validator = Validator::make(
                            $request->all(), [
                        'name' => 'required',]
            );
            if ($validator->fails()) {
                return redirect()->back()->with('error', $validator->errors()->first());
            }
            $post = $request->all();
            $post['id'] = $category_id;
            $AssessmentCategory = AssessmentCategory::where('id',$category_id)->first();
            $AssessmentCategory->update($post);

            return redirect()->route('assessmentCategory.index')->with('success', __(' Category Updated successfully.'));
        } else {
            return redirect()->back()->with('error', __('Permission Denied.'));
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\AssessmentCategory  $assessmentCategory
     * @return \Illuminate\Http\Response
     */
    public function destroy($id=0) {
        $user = Auth::user();
        $category_id = !empty($id) ? encrypted_key($id, 'decrypt') : 0;  
        if (!empty($category_id) && $user->type == 'admin') {
           
                $assessmentCategory = AssessmentCategory::where('id',$category_id)->first();
                if($assessmentCategory){
                $assessmentCategory->delete();
                return redirect()->route('assessmentCategory.index')->with('success', __('Assessment Category deleted successfully.'));
               
            } 
        } 
            return redirect()->back()->with('error', __('Permission Denied.'));
        
    }

}
