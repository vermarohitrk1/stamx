<?php

namespace App\Http\Controllers;

use App\BookCategory;
use Illuminate\Http\Request;
use Illuminate\Filesystem\Filesystem;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use DataTables;

class BookCategoryController extends Controller
{

    public function index(Request $request,$view = 'grid')
    {
        $authuser = Auth::user();
        if ($request->ajax()) { 
            $data = BookCategory::select('id','name')->where('user_id',auth()->user()->id);          
            return Datatables::of($data)
                ->addIndexColumn()
                ->addColumn('action', function($data){
                    $actionBtn = '                                   
                    <a href="'.url('book-category/edit', encrypted_key($data->id, 'encrypt')).'" class="btn btn-sm bg-success-light" data-toggle="tooltip" data-original-title="'.__('Edit').'">
                                   <i class="fas fa-pencil-alt"></i>
                                                    Edit
                                </a>

                         <a data-url="' . route('book.category.destroy',encrypted_key($data->id,'encrypt')) . '" href="#" class="btn btn-sm bg-danger-light delete_record_model">
                                    <i class="fas fa-trash-alt"></i>Delete
                                </a>';   

                    return $actionBtn;
                })
                ->rawColumns(['action'])
                ->make(true);
                return view('books.bookCategory.index');
        }else{

        
        
//        $book_categories = new BookCategory();
//       $book_categories = $book_categories->getcategory($all = 'all');
         $book_categories = BookCategory::where('user_id',$authuser->id)->paginate(6);
        return view('books.bookCategory.index', compact('view','book_categories')); 
    }
    }


    public function create()
    {
      return view('books.bookCategory.create');
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
    
        $book_categories = new BookCategory();
        $book_categories['name']          = $request->name;
        $book_categories['user_id']        = $user->id;
	
        $book_categories->save();
    
         return redirect()->back()->with('success', __('Category added successfully.'));
    }



    public function view($view = 'list'){
        $authuser = Auth::user();
        $custom_url = explode('.', $_SERVER['HTTP_HOST'])[0];
               $blog_categories = BookCategory::where('custom_url',$custom_url)->where('user_id',$authuser->id)->get();
               return view('books.bookCategory.list', compact('view','blog_categories'));
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
        $bookCategory = BookCategory::find($id); 
        return view('books.bookCategory.edit', compact('bookCategory'));
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
        $post = $request->all();
        $bookCategory = BookCategory::find($request->id);
        $bookCategory->update($post);
        return redirect('/book-category')->with('success', __(' Category Updated successfully.'));
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
        $blogCategory = BookCategory::find($id);
        $blogCategory->delete();
         return redirect()->back()->with('success', __('Category deleted successfully.'));


    }
}
