<?php

namespace App\Http\Controllers;

use App\FaqCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use DataTables;

class FaqCategoryController extends Controller {

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request) {
        $user = Auth::user();
        $title = "Faq Categories";
        if ($user->type == 'admin' ) {
			if ($request->ajax()) { 
            $data = FaqCategory::select('*')->where('user_id',auth()->user()->id);          
            return Datatables::of($data)
                ->addIndexColumn()
                ->addColumn('action', function($data){
                    $actionBtn = '                                   
                    <a href="'.url('faq/category/edit', encrypted_key($data->id, 'encrypt')).'" class="btn btn-sm bg-success-light" data-toggle="tooltip" data-original-title="'.__('Edit').'">
                                   <i class="fas fa-pencil-alt"></i>
                                                    Edit
                                </a>

                         <a data-url="' . route('faqCategory.destroy',encrypted_key($data->id,'encrypt')) . '" href="#" class="btn btn-sm bg-danger-light delete_record_model">
                                    <i class="fas fa-trash-alt"></i>Delete
                                </a>';   

                    return $actionBtn;
                })
                ->rawColumns(['action'])
                ->make(true);
                return view('faq.faqCategory.index');
        }else{

         $FaqCategory = FaqCategory::where('user_id',$user->id)->paginate(6);
        return view('faq.faqCategory.index', compact('FaqCategory')); 
    }
			
        } else {
            return redirect()->back()->with('error', __('Permission Denied.'));
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create() {
        $user = Auth::user();
        $title = "Create Category";
        if ($user->type == 'admin' || $user->type == 'owner') {
            return view('faq.faqCategory.create', compact('title'));
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
        $user = Auth::user();
        if ($user->type == 'admin' ) {

            $validation = [
                'name' => 'required|max:30|min:3'
            ];

            $validator = Validator::make(
                            $request->all(), $validation
            );

            if ($validator->fails()) {
                return redirect()->back()->with('error', $validator->errors()->first());
            }

            $categories = new FaqCategory();
            $categories['user_id'] = $user->id;
            $categories['name'] = $request->name;
            $categories->save();

            return redirect()->route('faqCategory.index')->with('success', __('Category added successfully.'));
        } else {
            return redirect()->back()->with('error', __('Permission Denied.'));
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\FaqCategory  $faqCategory
     * @return \Illuminate\Http\Response
     */
    public function show(FaqCategory $faqCategory,Request $request) {
        $user = Auth::user();
        if ($user->type == 'admin' || $user->type == 'owner') {
        if ($request->ajax()) {  
            $data = FaqCategory::whereIn('user_id', [0, $user->id]);
            return Datatables::of($data)
                ->addIndexColumn()
                ->filterColumn('name', function($query, $keyword) use ($request) {
                    $query->orWhere('faqcategories.name', 'LIKE', '%' . $keyword . '%')
                   ;
                })

                ->addColumn('name', function ($data) {
                    return $data->name;
                 }) 

                ->addColumn('action', function($data){
                    $actionBtn = '
                    <a href="'. route('faqCategory.edit',encrypted_key($data->id,'encrypt') ).'" class="action-item px-2" data-toggle="tooltip" data-original-title="'.__('Edit').'">
                    <i class="fas fa-edit"></i>
                </a>
                <a href="javascript::void(0);" class="action-item text-danger px-2 destroy_category" data-id="'.encrypted_key($data->id,'encrypt').'" data-toggle="tooltip" data-original-title="'.__('Delete').'">
                    <i class="fas fa-trash-alt"></i>
                </a>';

                    return $actionBtn;
                })
                ->rawColumns(['action'])
                ->make(true);
                return view('faq.faqCategory.list');
        }else{
            if ($user->type == 'admin' || $user->type == 'owner') {
                $categories = FaqCategory::whereIn('user_id', [0, $user->id])
                        ->paginate(6);
                return view('faq.faqCategory.list', compact('categories'));
            } else {
                return redirect()->back()->with('error', __('Permission Denied.'));
            }
        }      
    }
}

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\FaqCategory  $faqCategory
     * @return \Illuminate\Http\Response
     */
    public function edit($id) {
        $user = Auth::user();
        $title = "Edit Category";
        $category_id = !empty($id) ? encrypted_key($id, 'decrypt') : 0;
        if (!empty($category_id) && ($user->type == 'admin' )) {
            $category = FaqCategory::where('id', $category_id)->where('user_id', $user->id)->first();
            return view('faq.faqCategory.edit', compact('title', 'category'));
        } else {
            return redirect()->back()->with('error', __('Permission Denied.'));
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\FaqCategory  $faqCategory
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, FaqCategory $faqCategory) {
        $user = Auth::user();
				
        $category_id = $request->id;

        if (!empty($category_id) && ($user->type == 'admin')) {
            $validator = Validator::make(
                            $request->all(), [
                        'name' => 'required|max:30|min:3',]
            );
            if ($validator->fails()) {
                return redirect()->back()->with('error', $validator->errors()->first());
            }
            $post['id'] = $category_id;
            $post['name'] = $request->name;
            $category = FaqCategory::where('id', $category_id)->where('user_id', $user->id)->first();
            $process = $category->update($post);
            if ($process) {
                return redirect()->route('faqCategory.index')->with('success', __('Category updated successfully.'));
            }
        }
        return redirect()->back()->with('error', __('Permission Denied.'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\FaqCategory  $faqCategory
     * @return \Illuminate\Http\Response
     */
    public function destroy($id_enc=0) {
        $user = Auth::user();
		
        $category_id = !empty($id_enc) ? encrypted_key($id_enc, 'decrypt') : 0;
        if (!empty($category_id) && ($user->type == 'admin' || $user->type == 'owner')) {
           
                $category = FaqCategory::where('id', $category_id)->where('user_id', $user->id)->first();
                if ($category) {
                    $process = $category->delete();
                    if ($process) {
                        return redirect()->route('faqCategory.index')->with('success', __('Category deleted successfully.'));
                    }
                }
           
        }
        return redirect()->back()->with('error', __('Permission Denied.'));
    }

}
