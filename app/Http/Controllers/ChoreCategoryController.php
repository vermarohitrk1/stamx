<?php

namespace App\Http\Controllers;

use App\ChoreCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use DataTables;

class ChoreCategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
   public function index($view = 'grid') {
        $user = Auth::user();
        $title ="Chore Categories";
//          $permissions=permissions();
//        if (in_array("manage_chores",$permissions) || $user->type =="admin")   {
            return view('chore.choreCategory.index', compact('title'));
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
            return view('chore.choreCategory.create' , compact('title'));
      
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

            $categories = new ChoreCategory();
            $categories['user_id'] = $user->id;
            $categories['name'] = $request->name;
            $categories->save();

            return redirect()->route('choreCategory.index')->with('success', __('Category added successfully.'));
      
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\ChoreCategory  $choreCategory
     * @return \Illuminate\Http\Response
     */
    public function show(ChoreCategory $choreCategory , Request $request)
    {
       $user = Auth::user();
        if ($request->ajax()) {  
            $data = ChoreCategory::whereIn('user_id',[0,$user->id]);
            return Datatables::of($data)
                ->addIndexColumn()
                ->filterColumn('name', function($query, $keyword) use ($request) {
                    $query->orWhere('chorecategories.name', 'LIKE', '%' . $keyword . '%')
                   ;
                })
                ->addColumn('name', function ($data) {
                    return $data->name;
                 }) 

                ->addColumn('action', function($data){
                     $actionBtn = '<div class="actions  ">
                        
                                                <a class="btn btn-sm bg-success-light mt-1" data-title="Edit " href="'.route("choreCategory.edit",encrypted_key($data->id,'encrypt')).'">
                                                    <i class="fas fa-pencil-alt"></i>
                                                    Edit
                                                </a>
                                                <a data-url="' . route('choreCategory.destroy',encrypted_key($data->id,'encrypt')) . '" href="#" class="btn btn-sm bg-danger-light delete_record_model mt-1">
                                                    <i class="far fa-trash-alt"></i> Delete
                                                </a>
                                            </div>';
                    
                   
                return $actionBtn;
                    
                   
                })
                ->rawColumns(['action'])
                ->make(true);
        }else{
            if ($user->type == 'admin' || $user->type == 'owner') {
                $categories = ChoreCategory::whereIn('user_id',[0,$user->id])
                              ->paginate(6);
                return view('chore.choreCategory.list', compact('categories'));
            } else {
                return redirect()->back()->with('error', __('Permission Denied.'));
            }
        }
 
    }
    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\ChoreCategory  $choreCategory
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $user = Auth::user();
        $title ="Edit Category";
        $category_id = !empty($id) ? encrypted_key($id, 'decrypt') : 0;       
     
            $category = ChoreCategory::where('id',$category_id)->where('user_id',$user->id)->first();
           if(!empty($category->id)){
            return view('chore.choreCategory.edit', compact('title','category'));
           }else{
                return redirect()->back()->with('error', __('Permission Denied.'));
           }
           
      
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\ChoreCategory  $choreCategory
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, ChoreCategory $choreCategory)
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
            $category = ChoreCategory::where('id',$category_id)->where('user_id',$user->id);
    
            $process=$category->update($post);
            if($process){
                return redirect()->route('choreCategory.index')->with('success', __('Category updated successfully.'));
               }
            
     
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\ChoreCategory  $choreCategory
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
       $user = Auth::user();
 $category_id = !empty($id) ? encrypted_key($id, 'decrypt') : 0;   
           $category = ChoreCategory::where('id',$category_id)->where('user_id',$user->id);
         
               $process=$category->delete();
               if($process){
                return redirect()->route('choreCategory.index')->with('success', __('Category deleted successfully.'));
               }
          
    
    }
}
