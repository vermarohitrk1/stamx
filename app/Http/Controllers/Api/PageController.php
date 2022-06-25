<?php
namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\User;
use Mail;
use DataTables;
use Response;
use DB;
use App\Plan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use App\Page;

use Illuminate\Filesystem\Filesystem;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Schema;

class PageController extends Controller {

    public function get(Request $request)
    {
        $user =  Auth::user();
        // $data = Page::where(['user_id'=>$user->id])->get()->map(function($data){
        //     return $data['page_url']=url('page/'.$data['slug']);
        // })->toArray();
        //$data['page_url']=url('page/'.$data['slug']);
        $pages = Page::where(['user_id'=>$user->id])->get()->map(function ($page) {
            $page->page_url=url('page/'.$page->slug);
            return $page;
        })->toArray();
        return response()->json($pages,200);
    }

    // public function create()
    // {
    //     $user = User::find(request()->id);
    //     if(!$user){
    //         return response()->json(["error" => "Unauthenticated!"],400);
    //     }
    //     if(isset(request()->page_id)){
    //         $id =request()->page_id;
    //         $page = Page::where('id',$id)->first();
    //         return view('api.pagecreate',compact('page'));
    //     }else{
    //     return view('api.pagecreate');
    //     }
    // }
    // public function edit($id)
    // {
    //     $page = Page::where('id',$id)->get();
    //     return view('api.pagecreate',compact('page'));
    // }
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
            return Response::json($validator->errors()); 
        }
        // if($request->page_id){
        //     $page = Page::find($request->page_id);
        // }else{
            $pages = new Page();
        // }
        
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
                $image = "pages". uniqid() . '.'.$image_type;
                $file = $folderPath.$image;
                file_put_contents($file, $image_base64);
                $pages['image'] = $image;
            }

        // if($request->page_id){
        //     $page->update($pages);
        //     return response()->json(["msg" => "Page edit successfully."],200);
        // }else{
            $pages->save();
            return response()->json(["msg" => "New Page Created Successfully"],200);
        // }
        // return response()->json(["error" => "Something went wrong!"],400);
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
        $page = Page::find($request->page_id);
        $validation = [
            'page_name' => 'required|max:120'
        ];
        $validator = Validator::make(
            $request->all(), $validation
        );
        if($validator->fails())
        {
            return Response::json($validator->errors()); 
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
        $page->update($post);
        return response()->json(["msg" => "Page edit successfully."],200);
    }
    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    { 
        $page = Page::find($request->page_id);
        $page->delete();
        return response()->json(["msg" => "Page deleted successfully."],200);
    }

}