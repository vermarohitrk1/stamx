<?php

namespace App\Http\Controllers;

use Illuminate\Filesystem\Filesystem;
use App\Blog;
use App\BlogCategory;
use Illuminate\Support\Str;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Cache;
use DataTables;

class BlogController extends Controller {



    public function index(Request $request, $view = 'grid') {

        $authuser = Auth::user();
        $domain_id= get_domain_id();
        
        
        if ($request->ajax() && !empty($request->blockElementsData)) {
                if (!empty($request->duration)) {
                    $tilldate = Carbon::now()->addMonth($request->duration)->toDateTimeString();
                }
                
            
        
                       $BlogCount = Blog::where(['domain_id' => $domain_id]);
         if (!empty($tilldate)) {
                    $BlogCount->where("created_at", ">", $tilldate);
                }
                        $BlogCount=$BlogCount->count();
            $inactive = Blog::where(['domain_id' => $domain_id, 'status' => 'Unpublished']);
         if (!empty($tilldate)) {
                    $inactive->where("created_at", ">", $tilldate);
                }
                       $inactive=$inactive->count();
             $categories = BlogCategory::where(['domain_id'=>$domain_id]);
         if (!empty($tilldate)) {
                    $categories->where("created_at", ">", $tilldate);
                }
                        $categories=$categories->count();
                        return json_encode([
                    'blogs' => $BlogCount,
                    'inactive' => $inactive,
                    'categories' => $categories,
                ]);
                
                
                
         }elseif ($request->ajax()) {
          $data = Blog::select('blogs.*','blog_categories.name as category')->where('blogs.domain_id',$domain_id)
          ->leftJoin('blog_categories', 'blogs.category', '=', 'blog_categories.id');
            return Datatables::of($data)
                ->addIndexColumn()
                ->addColumn('category', function ($data) {
                    return $data->category;
                })->addColumn('image', function ($data) {
                if(!empty($data->image)){
                    if(file_exists(storage_path().'/blog/'.$data->image)){
                     $url = asset('storage/blog/'.$data->image);
                    }else{
                        $url = asset('public/demo.png');
                    }
                }else{
                    $url = asset('public/demo.png');
                }
                    return '<img  src="'.$url.'" class="avatar" width="50" height="50">';
                })->addColumn('action', function($data){

                       $actionBtn = '<div class="actions text-right">
                                                <a class="btn btn-sm bg-success-light" data-title="Edit Category" href="'.url("blog/edit/".encrypted_key($data->id,'encrypt')).'">
                                                    <i class="fas fa-pencil-alt"></i>
                                                    Edit
                                                </a>
                                                <a data-url="' . route('blog.destroy',encrypted_key($data->id,'encrypt')) . '" href="#" class="btn btn-sm bg-danger-light delete_record_model">
                                                    <i class="far fa-trash-alt"></i> Delete
                                                </a>
                                            </div>';


                    return $actionBtn;
                })
                ->rawColumns(['action','image'])
                ->make(true);



        }else{
            $BlogCount = Blog::where(['domain_id' => $domain_id])->count();
            $inactive = Blog::where(['domain_id' => $domain_id, 'status' => 'Unpublished'])->count();
             $categories = BlogCategory::where(['domain_id'=>$domain_id])->count();
//            $blogs = Blog::where(['user_id' => $authuser->id])->get();

            // echo "<pre>";print_r($blog);die();
            return view('blog.index', compact('view', 'authuser', "BlogCount", "inactive","categories"));

        }

    }

    public function create() {
        $authuser = Auth::user();
        $categories = new Blog();
        $categories = $categories->createblog();
        return view('blog.create', compact('categories', 'authuser'));
    }

    public function view($view = 'grid') {
        $authuser = Auth::user();
        $allow = true;
        $blogs = Blog::where(['user_id' => $authuser->id])->get();
        if (isset($_GET['view'])) {
            $view = 'list';
            $returnHTML = view('blog.list', compact('view', 'allow', 'blogs', 'authuser'))->render();
        } else {

            $returnHTML = view('blog.grid', compact('view', 'allow', 'blogs', 'authuser'))->render();
        }

        return response()->json(
                        [
                            'success' => true,
                            'html' => $returnHTML,
                        ]
        );
    }

    public function store(Request $request) {
        $user = Auth::user();
        $blog = new Blog();
        $blog = $blog->storeblog($request);
         return redirect()->route('blog.index')->with('success', __('Blog added successfully.'));
    }

    public function edit($id) {
        $authuser = Auth::user();
        $id = encrypted_key($id, 'decrypt') ?? $id;
        if ($id == '') {
            return redirect()->back()->with('success', __('Id is mismatch.'));
        }
        $blog = Blog::find($id);
        $categories = new Blog();
        $categories = $categories->createblog();
//        if ($blog->user_id == $authuser->id) {
            return view('blog.edit', compact('blog', 'authuser', 'categories'));
//        } else {
//            return redirect()->back()->with('error', __('You are not authorised.'));
//        }
    }

    public function update(Request $request) {
        $blog = new Blog();
        $blog = $blog->updatedata($request,  explode('.', $_SERVER['HTTP_HOST'])[0]);

        if ($blog) {
            return redirect()->route('blog.index')->with('success', __('Blog updated successfully.'));
        } else {
            return redirect()->back()->with('error', __('Fail to update try agin.'));
        }
    }

    public function destroy($id_enc=0) {

        $objUser = Auth::user();
        $id = !empty($id_enc) ? encrypted_key($id_enc, "decrypt") : 0;
        if (empty($id)) {
            return redirect()->back()->with('error', __('Permission Denied.'));
        }

        $data = Blog::find($id);
        $data->delete();
        return redirect()->back()->with('success', __('Deleted.'));

    }

    // Blog category form here------------------------------------------------

        public function category(Request $request ,$view = 'grid') {

            $authuser = Auth::user();
            $domain_id= get_domain_id();
            if ($request->ajax()) {
                $data = BlogCategory::select('id','name')->where(['domain_id'=>$domain_id]);
                return Datatables::of($data)
                    ->addIndexColumn()
                    ->addColumn('action', function($data){

                        $actionBtn = '<div class="actions text-right">
                                                <a class="btn btn-sm bg-success-light" data-title="Edit Category" href="'.url('blog/category/edit/'.encrypted_key($data->id,'encrypt')).'">
                                                    <i class="fas fa-pencil-alt"></i>
                                                    Edit
                                                </a>
                                                <a data-url="' . route('blog.category.destroy',encrypted_key($data->id,'encrypt')) . '" href="#" class="btn btn-sm bg-danger-light delete_record_model">
                                                    <i class="far fa-trash-alt"></i> Delete
                                                </a>
                                            </div>';



                        return $actionBtn;
                    })
                    ->rawColumns(['action'])
                    ->make(true);

            }else{

                return view('blog.blogCategory.index');
            }

        }

    public function categorycreate() {
        return view('blog.blogCategory.create');
    }

    public function categorystore(Request $request) {
        $domain_id= get_domain_id();
        $category = new blogCategory();
        $category->featured = 1;
        $category->domain_id = $domain_id;
        $category = $category->store($request);
       return redirect()->back()->with('success', __('Category added successfully.'));
    }

    public function categoryview($view = 'list') {
        $blog_categories = new blogCategory();
        $blog_categories = $blog_categories->viewlist();
        return view('blog.blogCategory.list', compact('view', 'blog_categories'));
    }

    public function categoryedit($id) {
        $id = encrypted_key($id, 'decrypt') ?? $id;
        if ($id == '') {
            return redirect('blog/category')->with('error', __('Category Id mismatch.'));
        }

        $blogCategory = new blogCategory();
        $blogCategory = $blogCategory->categoryedit($id);
         $authuser = Auth::user();

            return view('blog.blogCategory.edit', compact('blogCategory'));

    }

    public function categoryupdate(Request $request) {
        $blogCategory = new blogCategory();
        $blogCategory = $blogCategory->categoryUpdate($request);
            return redirect()->route('blog.category')->with('success', __('Category update successfully.'));
    }

    public function categorydestroy($id_enc=0) {
         $objUser = Auth::user();
        $id = !empty($id_enc) ? encrypted_key($id_enc, "decrypt") : 0;
        if (empty($id)) {
            return redirect()->back()->with('error', __('Permission Denied.'));
        }

        $data = blogCategory::find($id);
        $data->delete();
        return redirect()->back()->with('success', __('Deleted.'));


    }

}
