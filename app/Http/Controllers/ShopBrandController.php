<?php

namespace App\Http\Controllers;

use App\ProductBrand;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class ShopBrandController extends Controller {

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($view = 'grid') {
        $user = Auth::user();
        $title = "Shop Brands";
 
        $permissions=permissions();
        $title = "Shop Categories";
         if(in_array("manage_shop",$permissions) || $user->type =="admin"){   
            return view('shop.shopBrand.index', compact('title'));
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
        $title = "Create Brand";
    
              
            $brand =array();
            return view('shop.shopBrand.edit', compact('title','brand'));
      
        
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

            $brands = new ProductBrand();
            $brands['user_id'] = $user->id;
            $brands['title'] = $request->name;
            $brand = $brands->save();

            if ($brand) {
                return redirect()->route('shopBrand.index')->with('success', __('Brand added successfully.'));
            }
     
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\ProductBrand  $shopBrand
     * @return \Illuminate\Http\Response
     */
    public function show(ProductBrand $shopBrand) {
        $user = Auth::user();
     
            $brands = ProductBrand::whereIn('user_id', [0, $user->id])
                    ->paginate(6);
           
            return view('shop.shopBrand.list', compact('brands'));
      
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\ProductBrand  $shopBrand
     * @return \Illuminate\Http\Response
     */
    public function edit($id) {
        $user = Auth::user();
        $title = "Edit Brand";
        $brand_id = !empty($id) ? encrypted_key($id, 'decrypt') : 0;
      
            $brand = ProductBrand::where('id', $brand_id)->where('user_id', $user->id)->first();
          
            return view('shop.shopBrand.edit', compact('title', 'brand'));
  
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\ProductBrand  $shopBrand
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, ProductBrand $shopBrand) {
        $user = Auth::user();
        $brand_id = !empty($request->id) ? encrypted_key($request->id, 'decrypt') : 0;

            $validator = Validator::make(
                            $request->all(), [
                        'name' => 'required|max:30|min:3',]
            );
            if ($validator->fails()) {
                return redirect()->back()->with('error', $validator->errors()->first());
            }
            if(!empty($brand_id)){
            $post['id'] = $brand_id;
            $post['title'] = $request->name;
            $brand = ProductBrand::where('id', $brand_id)->where('user_id', $user->id);

            $process = $brand->update($post);
            }else{
                    $brands = new ProductBrand();
            $brands['user_id'] = $user->id;
            $brands['title'] = $request->name;
            $brand = $brands->save();
            $brand_id=$brands->id;
            }
           
                
                return redirect()->route('shopBrand.index')->with('success', __('Changes saved successfully.'));
            
     
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\ProductBrand  $shopBrand
     * @return \Illuminate\Http\Response
     */
    public function destroy($id=0) {
        $user = Auth::user();
        $brand_id = !empty($id) ? encrypted_key($id, 'decrypt') : 0;
        if (!empty($brand_id)) {
            $brand = ProductBrand::where('id', $brand_id)->where('user_id', $user->id);

            $process = $brand->delete();
            if ($process) {
                return redirect()->route('shopBrand.index')->with('success', __('Brand deleted successfully.'));
            }
        }
        return redirect()->back()->with('error', __('Permission Denied.'));
    }

}
