<?php

namespace App\Http\Controllers;

use App\Plan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use App\Page;
use Auth;
use DataTables;

class PageController extends Controller
{
    protected $user;
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request,$view = 'grid')
    {
        $user_id =  Auth::user();

		
        if ($request->ajax()) {
            $data = Page::where(['user_id'=>$user_id->id]);
            return Datatables::of($data)
                ->addIndexColumn()
                ->filterColumn('page_name', function($query, $keyword) use ($request) {
                    $query->orWhere('pages.page_name', 'LIKE', '%' . $keyword . '%')
                    ->orWhere('pages.slug', 'LIKE', '%' . $keyword . '%')
                    ->orWhere('pages.status', 'LIKE', '%' . $keyword . '%')
                    ;
                })
                ->addColumn('page_name', function ($data) {
                    return $data->page_name;
                 }) 

                 ->addColumn('slug', function ($data) {
                    return  $data->slug;              
            })                  
            ->addColumn('status', function ($data) {
             return $data->status;
            })            
              ->addColumn('action', function($data){
                    
                    $actionBtn = '<div class="text-right">
                    <a href="'. url('cms/'.$data->id.'/edit') .'" class="btn btn-sm bg-success-light mx-1" data-toggle="tooltip" data-original-title="'.__('Edit').'">
                                 <i class="fas fa-edit"></i> Edit
                                        </a>
                   <a href="'. url('page/'.$data->slug) .'" class="btn btn-sm bg-warning-light mx-1" target="_blank" data-toggle="tooltip" data-original-title="'.__('Preview').'">
                             <i class="fas fa-eye"></i> View
                                        </a>
                                        <a data-url="' . route('page.destroy',encrypted_key($data->id,'encrypt')) . '" href="javascript::void(0);" class="btn btn-sm bg-danger-light mx-1 delete_record_model">
                    <i class="far fa-trash-alt"></i> Delete
                </a></div>';

                return $actionBtn;
            })
                ->rawColumns(['action'])
                ->make(true);
                return view('page.index');
        }else{ 
        if (isset($_GET['view'])) {
            $view = 'list';
        }
        $pages = new Page();
        $pages = $pages->getpages($all = 'all');

        return view('page.index', compact('view','pages'));
    }
}

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('page.create');
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
            'page_name' => 'required|max:120'
        ];


        $validator = Validator::make(
            $request->all(), $validation
        );

        if($validator->fails())
        {
            return redirect()->back()->with('error', $validator->errors()->first());
        }
        $pages = new Page();
        $pages['page_name']          = $request->page_name;
        $pages['page_data']          = $request->page_data;
        $pages['user_id']        = $user->id;
        $pages['status']          = $request->status;
        if(!empty($request->title)){
            $pages['title']          = $request->title;
        }
        if(!empty($request->color)){
            $pages['color']          = $request->color;
        }
        if(!empty($request->subtitle)){
            $pages['subtitle']          = $request->subtitle;
        }
        $pages['slug'] = Str::slug($request->page_name);
		if (!empty($request->image)) {
            $base64_encode = $request->image;
            $folderPath = "storage/pages/";
            $image_parts = explode(";base64,", $base64_encode);
            $image_type_aux = explode("image/", $image_parts[0]);
            $image_type = $image_type_aux[1];
            $image_base64 = base64_decode($image_parts[1]);
            $image = "pages". uniqid() . '.'.$image_type;;
            $file = $folderPath.$image;
            file_put_contents($file, $image_base64);
            $pages['image'] = $image;
        }
        $pages->save();

        return redirect()->back()->with('success', __('Page added successfully.'));
    }


    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    public function view($view = 'list'){
        $authuser = Auth::user();
        $pages = Page::where('user_id',$authuser->custom_url)->get();
        return view('page.list', compact('view','pages'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request, $id)
    {
        $page = Page::find($id);
        return view('page.edit',compact('page'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        $user = Auth::user();
        $book = Page::find($request->id);
        $validation = [
            'page_name' => 'required|max:120'
        ];
        $validator = Validator::make(
            $request->all(), $validation
        );
        if($validator->fails())
        {
            return redirect()->back()->with('error', $validator->errors()->first());
        }
        $post['page_name']          = $request->page_name;
        $post['page_data']          = $request->page_data;
        $post['user_id']        = $user->id;
        $post['status']          = $request->status;
        $post['slug'] = Str::slug($request->page_name);
        if(!empty($request->title)){
            $post['title']          = $request->title;
        }
        if(!empty($request->color)){
            $post['color']          = $request->color;
        }
        if(!empty($request->subtitle)){
            $post['subtitle']          = $request->subtitle;
        }
		if (empty($request->image_delete)) {
            if (!empty($request->image)) {
                $base64_encode = $request->image;
                $folderPath = "storage/pages/";
                $image_parts = explode(";base64,", $base64_encode);
                $image_type_aux = explode("image/", $image_parts[0]);
                $image_type = $image_type_aux[1];
                $image_base64 = base64_decode($image_parts[1]);
                $image = "pages". uniqid() . '.'.$image_type;;
                $file = $folderPath.$image;
                file_put_contents($file, $image_base64);
                $post['image'] = $image;
            }
        }else{
             $post['image'] = NULL;
        }
        $book->update($post);
        return redirect()->back()->with('success', __('Page edit successfully.'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    { 
        $id =(int) encrypted_key($id, 'decrypt') ?? $id;
        $page = Page::find($id);
        $page->delete();
        return redirect()->back()->with('success', __('Page deleted successfully.'));
    }
}
