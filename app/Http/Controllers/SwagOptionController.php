<?php

namespace App\Http\Controllers;

use App\SwagOption;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class SwagOptionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
   public function index($view = 'grid') {
        $user = Auth::user();
        $title ="Swag Options";
        if ($user->type == 'admin' || $user->type == 'owner') {
            return view('swag.swagoption.index', compact('title'));
        } else {
            return redirect()->back()->with('error', __('Permission Denied.'));
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $user = Auth::user();
        $title ="Create Swag Option";
        if ($user->type == 'admin' || $user->type == 'owner') {
            return view('swag.swagoption.create' , compact('title'));
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
    public function store(Request $request)
    {
        $user = Auth::user();
        if ($user->type == 'admin' || $user->type == 'owner') {

            $validation = [
                'name' => 'required|max:50|min:3',
                'value' => 'required|max:30'
            ];

            $validator = Validator::make(
                            $request->all(), $validation
            );

            if ($validator->fails()) {
                return redirect()->back()->with('error', $validator->errors()->first());
            }

            $categories = new SwagOption();
            $categories['user_id'] = $user->id;
            $categories['name'] = $request->name;
            $categories['option_value'] = $request->value;
            $categories->save();

            return redirect()->route('swagOption.index')->with('success', __('Option added successfully.'));
        } else {
            return redirect()->back()->with('error', __('Permission Denied.'));
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\SupportOption  $swagOption
     * @return \Illuminate\Http\Response
     */
    public function show(SwagOption $swagOption)
    {
       $user = Auth::user();
        if ($user->type == 'admin' || $user->type == 'owner') {
            $categories = SwagOption::whereIn('user_id',[$user->id])
                          ->paginate(6);
            return view('swag.swagoption.list', compact('categories'));
        } else {
            return redirect()->back()->with('error', __('Permission Denied.'));
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\SupportOption  $swagOption
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $user = Auth::user();
        $title ="Edit Option";
        $category_id = !empty($id) ? encrypted_key($id, 'decrypt') : 0;       
        if (!empty($category_id) && ($user->type == 'admin' || $user->type == 'owner')) {
            $category = SwagOption::where('id',$category_id)->where('user_id',$user->id)->first();
           if(!empty($category->id)){
            return view('swag.swagoption.edit', compact('title','category'));
           }else{
                return redirect()->back()->with('error', __('Permission Denied.'));
           }
           
        }
            return redirect()->back()->with('error', __('Permission Denied.'));
        
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\SupportOption  $swagOption
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, swagOption $swagOption)
    {
        $user = Auth::user();
        $category_id = !empty($request->id) ? encrypted_key($request->id, 'decrypt') : 0;
        if (!empty($category_id) && ($user->type == 'admin' || $user->type == 'owner')) {
            $validator = Validator::make(
                            $request->all(), [
                        'name' => 'required|max:50|min:3',
                        'value' => 'required|max:30'
                                ]
            );
            if ($validator->fails()) {
                return redirect()->back()->with('error', $validator->errors()->first());
            }
            $post['id'] = $category_id;
            $post['name'] = $request->name;
            $post['option_value'] = $request->value;
            $category = SwagOption::where('id',$category_id)->where('user_id',$user->id);
    
            $process=$category->update($post);
            if($process){
                return redirect()->route('swagOption.index')->with('success', __('Option updated successfully.'));
               }
            
       }
        return redirect()->back()->with('error', __('Permission Denied.'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\SupportOption  $swagOption
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
       $user = Auth::user();
        $category_id = !empty($request->category_id) ? encrypted_key($request->category_id, 'decrypt') : 0;
     if (!empty($category_id) && ($user->type == 'admin' || $user->type == 'owner')) {
           $category = SwagOption::where('id',$category_id)->where('user_id',$user->id);
         
               $process=$category->delete();
               if($process){
                return redirect()->route('swagOption.index')->with('success', __('Option deleted successfully.'));
               }
          
           
        } 
          return redirect()->back()->with('error', __('Permission Denied.'));
    }
}
