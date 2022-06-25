<?php

namespace App\Http\Controllers;

use App\ShopCategory;
use App\ShopProduct;
use App\ProductCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use DataTables;


class ShopCategoryController extends Controller {

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($view = 'grid') {
        $user = Auth::user();
        $user=Auth::user();
//        $permissions=permissions();
        $title = "Shop Categories";
//         if(in_array("manage_shop",$permissions) || $user->type =="admin"){   
            return view('shop.shopCategory.index', compact('title'));
//        } else {
//            return redirect()->back()->with('error', __('Permission Denied.'));
//        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create() {
        $user = Auth::user();
        $title = "Create Category";
      
              $category = New ShopCategory();
          
            $allProducts = ShopProduct::where("user_id", $user->id)->orderBy("id", 'DESC')->get();
            $selected_products = array();
            
            return view('shop.shopCategory.edit', compact('title', 'category', 'allProducts','selected_products'));

        
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request) {
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

            $categories = new ShopCategory();
            $categories['user_id'] = $user->id;
            $categories['name'] = $request->name;
            $categories['parent_id'] = $request->parent_id;
            $categories['status'] = $request->status;
            $category = $categories->save();

            if (!empty($category->id) && $request->products) {
                foreach ($request->products as $key => $val) {
                    $product_category = new ProductCategory();
                    $product_category['category_id']=$category->id;
                    $product_category['product_id']=$val;                   
                    $product_category->save();
                }
            }
            if ($category) {
                return redirect()->route('shopCategory.index')->with('success', __('Category added successfully.'));
            }
      
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\ShopCategory  $shopCategory
     * @return \Illuminate\Http\Response
     */
    public function show(ShopCategory $shopCategory , Request $request) {
        $user = Auth::user();
      
        if ($request->ajax()) {  
            $data = ShopCategory::whereIn('user_id', [0, $user->id]);
            return Datatables::of($data)
                ->addIndexColumn()
                ->filterColumn('name', function($query, $keyword) use ($request) {
                    $query->orWhere('product_category_types.name', 'LIKE', '%' . $keyword . '%')
                    ->orWhere('product_category_types.status', 'LIKE', '%' . $keyword . '%')
                   ;
                })
                ->addColumn('name', function ($data) {
                    return $data->name;

                 }) 
                 ->addColumn('status', function ($data) {
                    return
                    ' <span class="badge badge-sm badge-dot mr-4">
                    <i class="'.($data->status == 'Published').' ? "badge-success" : "badge-warning" "></i>
                    '. $data->status .'
                   </span>  ';  
                 }) 
                ->addColumn('action', function($data){
                       $actionBtn = '<div class="actions text-right ">
           
                                                <a class="btn btn-sm bg-success-light mt-1" data-title="Edit " href="'. route('shopCategory.edit',encrypted_key($data->id,'encrypt') ).'">
                                                    <i class="fas fa-pencil-alt"></i>
                                                    Edit
                                                </a>
                                                <a data-url="' . route('shopCategory.destroy',encrypted_key($data->id,'encrypt')) . '" href="#" class="btn btn-sm bg-danger-light delete_record_model mt-1">
                                                    <i class="far fa-trash-alt"></i> Delete
                                                </a>
                                            </div>';
                    
                   
                return $actionBtn;
                })
                ->rawColumns(['action','status'])
                ->make(true);
                return view('shop.shopCategory.list');
           }else{
          
                $categories = ShopCategory::whereIn('user_id', [0, $user->id])
                        ->paginate(6);
                return view('shop.shopCategory.list', compact('categories'));
           
       
    } 
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\ShopCategory  $shopCategory
     * @return \Illuminate\Http\Response
     */
    public function edit($id) {
        $user = Auth::user();
        $title = "Edit Category";
        $category_id = !empty($id) ? encrypted_key($id, 'decrypt') : 0;
       
            $category = ShopCategory::where('id', $category_id)->where('user_id', $user->id)->first();
          
            $allProducts = ShopProduct::where("user_id", $user->id)->orderBy("id", 'DESC')->get();
            $selected_products = \App\ProductCategory::where("category_id", $category_id)->pluck('product_id')->toArray();
            
            return view('shop.shopCategory.edit', compact('title', 'category', 'allProducts','selected_products'));
       
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\ShopCategory  $shopCategory
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, ShopCategory $shopCategory) {
        $user = Auth::user();
        $category_id = !empty($request->id) ? encrypted_key($request->id, 'decrypt') : 0;
     
            $validator = Validator::make(
                            $request->all(), [
                        'name' => 'required|max:30|min:3',]
            );
            if ($validator->fails()) {
                return redirect()->back()->with('error', $validator->errors()->first());
            }
            if(!empty($category_id)){
            $post['id'] = $category_id;
            $post['name'] = $request->name;
            $post['parent_id'] = $request->parent_id;
            $post['status'] = $request->status;
            $category = ShopCategory::where('id', $category_id)->where('user_id', $user->id);

            $process = $category->update($post);
            }else{
                    $categories = new ShopCategory();
            $categories['user_id'] = $user->id;
            $categories['name'] = $request->name;
            $categories['parent_id'] = $request->parent_id;
            $categories['status'] = $request->status;
            $category = $categories->save();
            $category_id=$categories->id;
            }
           
                if (!empty($category_id) && !empty($request->products)) {
                     $deleteProducts = ProductCategory::whereIn('product_id', $request->products);
                     $deleteProducts->delete();
                    
                foreach ($request->products as $key => $val) {
                    $product_category = new ProductCategory();
                    $product_category['category_id']=$category_id;
                    $product_category['product_id']=$val;                  
                    $product_category->save();
                }
            }
                
                return redirect()->route('shopCategory.index')->with('success', __('Changes saved successfully.'));
      
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\ShopCategory  $shopCategory
     * @return \Illuminate\Http\Response
     */
    public function destroy($id=0) {
        $user = Auth::user();
        $category_id = !empty($id) ? encrypted_key($id, 'decrypt') : 0;
      
            $category = ShopCategory::where('id', $category_id)->where('user_id', $user->id);

            $process = $category->delete();
            if ($process) {
                return redirect()->route('shopCategory.index')->with('success', __('Category deleted successfully.'));
            }
      
        return redirect()->back()->with('error', __('Permission Denied.'));
    }

}
