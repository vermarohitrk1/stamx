<?php

namespace App\Http\Controllers;

use App\Book;
use App\BookCategory;
use Illuminate\Support\Str;
use App\Utility;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use DataTables;



class BookController extends Controller
{

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request,$view = 'grid')
    {
        $user = Auth::user();
            if ($request->ajax()) {
          $data = Book::select('books.*','books_categories.name as category')->where('books.user_id',Auth::user()->id)->leftJoin('books_categories', 'books.category', '=', 'books_categories.id');
          //$data = $this->yajratable($request);
            return Datatables::of($data)
                ->addIndexColumn()
                ->addColumn('category', function ($data) {

                    return $data->category;
                })
                ->addColumn('types', function ($data) {
                    $type='';
                    $type .= $data->featured ? '<span class="badge badge-xs bg-primary-light mr-1">Featured</span>' : '';
                    $type .= $data->favourite_read ? '<span class="badge badge-xs bg-primary-light mr-1">Favourite</span>' : '';

                    return $type;
                })

                ->addColumn('image', function ($data) {
                if(!empty($data->image)){
                    if(file_exists(storage_path().'/books/'.$data->image)){

                     $url = asset('storage/books/'.$data->image);
                    }else{
                        $url = asset('public/demo.png');
                    }
                }else{
                    $url = asset('public/demo.png');
                }
                    return '<img onclick="profile_details('.$data->id.')" src="'.$url.'" class="avatar" width="50" height="50">';
                })->addColumn('action', function($data){
                    $actionBtn = ' <div class="text-right">
										  <a href="'.url('book/edit', encrypted_key($data->id, 'encrypt')).'" class="btn btn-sm bg-success-light" data-toggle="tooltip" data-original-title="'.__('Edit').'">
                                   <i class="fas fa-pencil-alt"></i>
                                                    Edit
                                </a>
                             <a data-url="' . route('book.destroy',encrypted_key($data->id,'encrypt')) . '" href="#" class="btn btn-sm bg-danger-light delete_record_model">
                                            <i class="fas fa-trash-alt"></i>Delete
                                        </a></div>';

                    return $actionBtn;
                })
                ->rawColumns(['action','image','types'])
                ->make(true);
                return view('books.index');
        }else{

            if(isset($_GET['view'])){
                $view = 'list';
            }
            $books = new Book;
            $books = $books->getalldata($all = 'all');
            return view('books.index', compact('view', "user","books"));

        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {

		    $authuser = Auth::user();
            $categories = $this->getcategory();
			return view('books.create',compact('categories','authuser'));
    }
    public function ajaxview(Request $request) {
        $user = Auth::user();
        $authuser = $user;
        $title = "Books";
        if ($request->ajax() && $request->has('view') && $request->has('sort')) {


             $books = Book::select('books.*','books_categories.name')
            ->leftJoin('books_categories', 'books.category', '=', 'books_categories.id')
            ->where('books.user_id', $authuser->id);


            //sort
            $sort = '';
            switch ($request->sort) {
                case "all":
                    break;
                default :
                    $sort = $request->sort;
                    break;
            }

            if (!empty($sort)) {
                $books->where('books.status', $sort);
            }

            //status
            if (!empty($request->status)) {
                $books->whereIn('books.status', $request->status);
            }

            //keyword
            if (!empty($request->keyword)) {
                $books->where('books.title', 'LIKE', '%' . $request->keyword . '%');
            }

            $book = $books->paginate(6);


            if (isset($request->view) && $request->view == 'list') {
                $view = 'list';
               $returnHTML = view('book.list', compact('view','book'))->render();
            } else {
                $view = 'grid';
                 $returnHTML = view('book.grid', compact('view','book'))->render();
            }

            return response()->json(
                            [
                                'success' => true,
                                'html' => $returnHTML,
                            ]
            );
        }
    }
    public function view($view = 'grid'){
            $authuser = Auth::user();
            $custom_url = explode('.', $_SERVER['HTTP_HOST'])[0];
            $book = Book::select('books.*','books_categories.name')
            ->leftJoin('books_categories', 'books.category', '=', 'books_categories.id')
            ->where('books.user_id', $authuser->id)
            ->get();


           if(isset($_GET['view'])){
                 $view = 'list';
                 $returnHTML = view('book.list', compact('view','book'))->render();
            }else{
                 $returnHTML = view('book.grid', compact('view','book'))->render();
            }

            return response()->json(
                [
                    'success' => true,
                    'html' => $returnHTML,
                ]
            );
    }
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // $books = new Books();
        // $book = $books->storebook($request);
        $user = Auth::user();
        $validation = [
            'title' => 'required|max:120',
             'description' => 'required',
        ];

        if($request->hasFile('image'))
        {
            $validation['image'] = 'mimes:jpeg,jpg,png';
        }

        $validator = Validator::make(
            $request->all(), $validation
        );

        if($validator->fails())
        {
            return redirect()->back()->with('error', $validator->errors()->first());
        }
        $custom_url = explode('.', $_SERVER['HTTP_HOST'])[0];
        $book  = new Book();
        $book['user_id']      = $user->id;
        $book['title']        = $request->title;
        $book['category']     = $request->category;
        $book['status']       = $request->status;
        $book['price']       = $request->price;
        $book['author']       = $request->author;
        $book['marketplace']       = $request->marketplace;
        $book['featured']       = $request->featured;
        $book['favourite_read']       = $request->favourite_read;
        $book['slider']       = $request->slider;
        if(!empty($request->buylink)) {
            $book['buylink'] = $request->buylink;
        }

        if(!empty($request->itunes_link)) {
            $book['itunes_link'] = $request->itunes_link;
        }
        if(!empty($request->youtube)) {
            $book['youtube'] = $request->youtube;
        }
        $book['description']      = $request->description;
        $book['show_video']      = $request->show_video;
        if (!empty($request->image)) {
            $base64_encode = $request->image;
            $folderPath = "storage/books/";
            $image_parts = explode(";base64,", $base64_encode);
            $image_type_aux = explode("image/", $image_parts[0]);
            $image_type = $image_type_aux[1];
            $image_base64 = base64_decode($image_parts[1]);
            $image = "book". uniqid() . '.'.$image_type;;
            $file = $folderPath.$image;
            file_put_contents($file, $image_base64);
            $book['image'] = $image;
        }


        $book->save();
        return redirect()->to('book')->with('success', __('Book added successfully.'));



    }

    public function getcategory(){
        $authuser = Auth::user();
        $categories = BookCategory::select('name','id')->where('user_id',$authuser->id)->get();

        return $categories;
    }
    /**
     * Display the specified resource.
     *
     * @param  \App\Blog  $blog
     * @return \Illuminate\Http\Response
     */
    public function show(Blog $blog)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Blog  $blog
     * @return \Illuminate\Http\Response
     */
    public function edit($id=0)
    {
		$id = encrypted_key($id, 'decrypt') ?? $id;
	   $authuser = Auth::user();
       $categories = $this->getcategory();
       $book = Book::find($id);
       return view('books.edit', compact('book','categories','authuser'));

    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Blog  $blog
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        $user = Auth::user();

       $book = Book::find($request->id);
        if(empty($request->image_delete)){
            if (!empty($request->image)) {
                $base64_encode = $request->image;
                $folderPath = "storage/books/";
                $image_parts = explode(";base64,", $base64_encode);
                $image_type_aux = explode("image/", $image_parts[0]);
                $image_type = $image_type_aux[1];
                $image_base64 = base64_decode($image_parts[1]);
                $image = "book". uniqid() . '.'.$image_type;;
                $file = $folderPath.$image;
                file_put_contents($file, $image_base64);
                $post['image']= $image;
            }
        }else{
            $post['image']= NULL;
        }
        $post['user_id']      = $user->id;
        $post['title']        = $request->title;
        $post['category']     = $request->category;
        $post['status']       = $request->status;
        $book['price']       = $request->price;
        $book['author']       = $request->author;
        $book['marketplace']       = $request->marketplace;
        $book['featured']       = $request->featured;
        $book['favourite_read']       = $request->favourite_read;
        $book['slider']       = $request->slider;

        if(!empty($request->buylink)) {
            $post['buylink'] = $request->buylink;
        }
        if(!empty($request->itunes_link)) {
            $book['itunes_link'] = $request->itunes_link;
        }
        if(!empty($request->youtube)) {
            $post['youtube'] = $request->youtube;
        }
        $post['description']      = $request->article;
        $post['show_video']      = $request->show_video;

        $book->update($post);
        return redirect()->to('book')->with('success', __(' Book Updated successfully.'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Blog  $blog
     * @return \Illuminate\Http\Response
     */
    public function destroy( $id=0)
    {
		$id = encrypted_key($id, 'decrypt') ?? $id;
        $book = Book::find($id);
        $book->delete();
         return redirect()->to('book')->with('success', __('Book deleted successfully.'));

    }

}
