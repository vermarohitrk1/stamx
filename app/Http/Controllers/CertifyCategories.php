<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\CertifyCategory;
use Illuminate\Support\Facades\DB;
use Illuminate\Filesystem\Filesystem;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
class CertifyCategories extends Controller
{
   
     /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
   
    public function index($view = 'list')
    {
        $authuser = Auth::user();
        
        
        if($authuser->type = 'admin')
        {
           $CertifyCategories = CertifyCategory::orderByDesc('id')->get();
            // $Certify_categories = DB::table('certify_categories')->where('user_id',$authuser->id)->paginate(5);
            // echo "<pre>";print_r($Certify_categories);die();
            return view('certify.certifyCategories.index', compact('view', 'allow','CertifyCategories'));
        }
        else
        {
            return redirect()->back()->with('error', __('Permission Denied.'));
        }
    }
    
     public function featchData($view = 'list')
    {
        $authuser = Auth::user();
        if($authuser->type = 'admin')
        {
           
               $CertifyCategories = CertifyCategory::orderByDesc('id')->get();
               return view('certify.certifyCategories.list', compact('view', 'allow','CertifyCategories'));
         
        }
        else
        {
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
        return view('certify.certifyCategories.create');
    }
    
     
    public function store(Request $request)
    {
        $user = Auth::user();
    // echo "<pre>";print_r($request->all());die();
        if($user->type=='admin')
        {
            $validation = [
                    'name' => 'required|max:120'
                   
                ];


                $validator = Validator::make(
                    $request->all(), $validation
                );

                if($validator->fails())
                {
                    return redirect()->back()->with('error', $validator->errors()->first());
                }

                $CertifyCategory = new CertifyCategory();
                $CertifyCategory['name']          = $request->name;
                $CertifyCategory['user_id']        = $user->id;
                $CertifyCategory->save();

                return redirect()->back()->with('success', __('Certify Category added successfully.'));
        }
            else
            {
                return redirect()->back()->with('error', __('Your Certify limit is over, Please upgrade plan.'));
            }
       
    }
    
    public function destroy(Request $request)
    {
        if($request)
        {
            $CertifyCategory = CertifyCategory::find($request->category_id);
            $CertifyCategory->delete();
            return redirect()->back()->with('success', __('Certify Category deleted successfully.'));
        }
        else
        {
            return redirect()->back()->with('error', __('Permission Denied.'));
        }
    }
    
    
    public function edit($id)
    {
        
        $CertifyCategory = CertifyCategory::find($id);
        return view('certify.certifyCategories.edit', compact('CertifyCategory'));
    }
    
    public function update(Request $request)
    {
        $validator = Validator::make(
            $request->all(), [
            'name' => 'required',
                           ]
        );

        if($validator->fails())
        {
            return redirect()->back()->with('error', $validator->errors()->first());
        }
        // echo "<pre>";print_r($request->all());die();
        $post = $request->all();
        $CertifyCategory = CertifyCategory::find($request->id);
        $CertifyCategory->update($post);

        return redirect()->back()->with('success', __('Certify Category Updated successfully.'));
    }

    
}
