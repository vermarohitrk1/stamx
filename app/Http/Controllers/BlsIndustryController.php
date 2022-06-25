<?php

namespace App\Http\Controllers;

use App\BlsIndustry;
use Illuminate\Http\Request;
use Illuminate\Filesystem\Filesystem;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use DataTables;

class BlsIndustryController extends Controller
{

    public function index(Request $request,$view = 'grid')
    {
        $authuser = Auth::user();
        if ($request->ajax()) { 
            $data = BlsIndustry::all();          
            return Datatables::of($data)
                ->addIndexColumn()
                ->addColumn('action', function($data){
                    $actionBtn = '                                   
                    <a href="'.route('bls.category.edit', encrypted_key($data->id, 'encrypt')).'" class="btn btn-sm bg-success-light" data-toggle="tooltip" data-original-title="'.__('Edit').'">
                                   <i class="fas fa-pencil-alt"></i>
                                                    Edit
                                </a>

                         <a data-url="' . route('bls.category.destroy',encrypted_key($data->id,'encrypt')) . '" href="#" class="btn btn-sm bg-danger-light delete_record_model">
                                    <i class="fas fa-trash-alt"></i>Delete
                                </a>';   

                    return $actionBtn;
                })
                ->rawColumns(['action'])
                ->make(true);
                return view('pathways.blsindustry.index');
        }else{

        return view('pathways.blsindustry.index', compact('view')); 
    }
    }


    public function create()
    {
      return view('pathways.blsindustry.create');
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
            'name' => 'required|max:120'
        ];
    
    
        $validator = Validator::make(
            $request->all(), $validation
        );
    
        if($validator->fails())
        {
            return redirect()->back()->with('error', $validator->errors()->first());
        }
    
        $book_categories = new BlsIndustry();
        $book_categories['name']          = $request->name;
        $book_categories['code']        = $request->code;
	
        $book_categories->save();
    
         return redirect()->back()->with('success', __('Added successfully.'));
    }



    public function view($view = 'list'){
        $authuser = Auth::user();
        $custom_url = explode('.', $_SERVER['HTTP_HOST'])[0];
               $blog_categories = BlsIndustry::where('custom_url',$custom_url)->where('user_id',$authuser->id)->get();
               return view('pathways.blsindustry.list', compact('view','blog_categories'));
    }
    /**
     * Display the specified resource.
     *
     * @param  \App\BlogCategory  $blogCategory
     * @return \Illuminate\Http\Response
     */
    public function show(BlogCategory $blogCategory)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\BlogCategory  $blogCategory
     * @return \Illuminate\Http\Response
     */
    public function edit($id=0)
    { 
		$id = encrypted_key($id, 'decrypt') ?? $id;
        $bookCategory = BlsIndustry::find($id); 
        return view('pathways.blsindustry.edit', compact('bookCategory'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\BlogCategory  $blogCategory
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {

        $validator = Validator::make(
            $request->all(), [
            'name' => 'required',]
        );
        if($validator->fails())
        {
            return redirect()->back()->with('error', $validator->errors()->first());
        }
      
        $bookCategory = BlsIndustry::find($request->id);
        $bookCategory->name=$request->name;
        $bookCategory->code=$request->code;
        $bookCategory->save();
        return redirect()->route('bls.category')->with('success', __(' Updated successfully.'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\BlogCategory  $blogCategory
     * @return \Illuminate\Http\Response
     */
    public function destroy($id=0)
    {
		$id = encrypted_key($id, 'decrypt') ?? $id;
        $blogCategory = BlsIndustry::find($id);
        $blogCategory->delete();
         return redirect()->back()->with('success', __('Deleted successfully.'));


    }
}
