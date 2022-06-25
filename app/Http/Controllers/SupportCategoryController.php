<?php

namespace App\Http\Controllers;

use App\SupportCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use DataTables;

class SupportCategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
   public function index($view = 'grid') {
        $user = Auth::user();
        $title ="Support Categories";
//          $permissions=permissions();
//        if (in_array("manage_help_desk",$permissions) || $user->type =="admin")   {
            return view('support.supportCategory.index', compact('title'));
//        } else {
//            return redirect()->back()->with('error', __('Permission Denied.'));
//        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $user = Auth::user();
        $title ="Create Category";
            return view('support.supportCategory.create' , compact('title'));
      
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $user = Auth::user();
      

            $validation = [
                'name' => 'required|max:30|min:3'
            ];

            $validator = Validator::make(
                            $request->all(), $validation
            );

            if ($validator->fails()) {
                return redirect()->back()->with('error', $validator->errors()->first());
            }

            $categories = new SupportCategory();
            $categories['user_id'] = $user->id;
            $categories['name'] = $request->name;
            $categories->save();

            return redirect()->route('supportCategory.index')->with('success', __('Category added successfully.'));
      
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\SupportCategory  $supportCategory
     * @return \Illuminate\Http\Response
     */
    public function show(SupportCategory $supportCategory , Request $request)
    {
       $user = Auth::user();
        if ($request->ajax()) {  
            $data = SupportCategory::whereIn('user_id',[0,$user->id]);
            return Datatables::of($data)
                ->addIndexColumn()
                ->filterColumn('name', function($query, $keyword) use ($request) {
                    $query->orWhere('supportcategories.name', 'LIKE', '%' . $keyword . '%')
                   ;
                })
                ->addColumn('name', function ($data) {
                    return $data->name;
                 }) 

                ->addColumn('action', function($data){
                     $actionBtn = '<div class="actions  ">
                        
                                                <a class="btn btn-sm bg-success-light mt-1" data-title="Edit " href="'.route("supportCategory.edit",encrypted_key($data->id,'encrypt')).'">
                                                    <i class="fas fa-pencil-alt"></i>
                                                    Edit
                                                </a>
                                                <a data-url="' . route('supportCategory.destroy',encrypted_key($data->id,'encrypt')) . '" href="#" class="btn btn-sm bg-danger-light delete_record_model mt-1">
                                                    <i class="far fa-trash-alt"></i> Delete
                                                </a>
                                            </div>';
                    
                   
                return $actionBtn;
                    
                   
                })
                ->rawColumns(['action'])
                ->make(true);
        }else{
            if ($user->type == 'admin' || $user->type == 'owner') {
                $categories = SupportCategory::whereIn('user_id',[0,$user->id])
                              ->paginate(6);
                return view('support.supportCategory.list', compact('categories'));
            } else {
                return redirect()->back()->with('error', __('Permission Denied.'));
            }
        }
 
    }
    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\SupportCategory  $supportCategory
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $user = Auth::user();
        $title ="Edit Category";
        $category_id = !empty($id) ? encrypted_key($id, 'decrypt') : 0;       
     
            $category = SupportCategory::where('id',$category_id)->where('user_id',$user->id)->first();
           if(!empty($category->id)){
            return view('support.supportCategory.edit', compact('title','category'));
           }else{
                return redirect()->back()->with('error', __('Permission Denied.'));
           }
           
      
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\SupportCategory  $supportCategory
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, SupportCategory $supportCategory)
    {
        $user = Auth::user();
        $category_id = !empty($request->id) ? encrypted_key($request->id, 'decrypt') : 0;
      
            $validator = Validator::make(
                            $request->all(), [
                        'name' => 'required|max:30|min:3',]
            );
            if ($validator->fails()) {
                return redirect()->back()->with('error', $validator->errors()->first());
            }
            $post['id'] = $category_id;
            $post['name'] = $request->name;
            $category = SupportCategory::where('id',$category_id)->where('user_id',$user->id);
    
            $process=$category->update($post);
            if($process){
                return redirect()->route('supportCategory.index')->with('success', __('Category updated successfully.'));
               }
            
     
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\SupportCategory  $supportCategory
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
       $user = Auth::user();
 $category_id = !empty($id) ? encrypted_key($id, 'decrypt') : 0;   
           $category = SupportCategory::where('id',$category_id)->where('user_id',$user->id);
         
               $process=$category->delete();
               if($process){
                return redirect()->route('supportCategory.index')->with('success', __('Category deleted successfully.'));
               }
          
    
    }
}
