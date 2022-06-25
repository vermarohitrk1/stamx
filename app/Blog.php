<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Validator;
use App\BlogCategory;

class Blog extends Model
{
       protected $fillable = [
        'user_id',
        'domain_id',
        'title',
        'category',
        'status',
        'tags',
        'image',
        'expiry_status',
        'expiry_date',
        'article',
        'video',
        'dont_miss',
        'featured',
        'prepublish_date',
        'editor_picked',
        'youtube',
        'most_popular',
        'view_count'
    ];

    protected $table = "blogs"; 

   public function user()
    {
        return $this->belongsTo(\App\User::class);
    }
    public function getalldata($all){
         $user = Auth::user();
         if($all == 'all'){
            $Blog = self::where(['user_id'=>$user->id])->paginate(5); 
         }
         return $Blog;
    }
    
    public function createblog(){
        $user = Auth::user();
        $domain_id = get_domain_id();
        $categories = BlogCategory::where(['domain_id'=>$domain_id])->get();
        return $categories;
    }

   public function getcategory($categoryId){
        $categories = BlogCategory::where(['id'=>$categoryId])->first();
        if(!empty($categories)){
            return $categories->name; 
        }
         return "";
    }

    public function storeblog($request){
         $user = Auth::user();
         $image='';
         $video='';
          $domain_id = get_domain_id();
              if (!empty($request->image)) {
                $base64_encode = $request->image;
                $folderPath = "storage/blog/";
                if (!file_exists($folderPath)) {
File::isDirectory($folderPath) or File::makeDirectory($folderPath, 0777, true, true);
                }
                $image_parts = explode(";base64,", $base64_encode);
                $image_type_aux = explode("image/", $image_parts[0]);
                $image_type = $image_type_aux[1];
                $image_base64 = base64_decode($image_parts[1]);
                $image = "blog". uniqid() . '.'.$image_type;;
                $file = $folderPath.$image;
                file_put_contents($file, $image_base64);
              }

                if (!empty($request->hasFile('video'))) {
                    $fileNameToStore = time() . '.' . $request->video->getClientOriginalExtension();
                    $video = $request->file('video')->storeAs('blog', Str::random(20) . $fileNameToStore);   
                }
            
         $data = [
            'user_id' =>$user->id,
            'title'   =>$request->title,
            'category'=>$request->category,
            'domain_id'=>$domain_id,
            'status'=>$request->status,
            'tags'=>$request->tags,
            'expiry_status'=> $request->expiry_status,
            'expiry_date'=>$request->expiry_date,
            'article'=>$request->article,
            'dont_miss'=>$request->dont_miss??0,
            'featured'=>$request->featured??0,
            'editor_picked'=>$request->editor_picked??0,
            'youtube'=>$request->youtube,
            'most_popular'=>$request->most_popular??0,
            'view_count'=>$request->view_count,
            'image'=>$image,
            'video'=>$video,
            'prepublish_date'=>$request->prepublish_date,
            'image'=>$image
         ]; 

        $blog = self::create($data);
        return $blog;
    }

    public function edit($id){
        return self::find($id);
    }

    public function updatedata($request,$custom_url){
        $user = Auth::user();
        $image='';
        $video='';
        $Blog = self::find($request->id);
         $domain_id = get_domain_id();
        if (empty($request->delete_image)) {
           if (!empty($request->image)) {
                $base64_encode = $request->image;
                $folderPath = "storage/blog/";
                $image_parts = explode(";base64,", $base64_encode);
                $image_type_aux = explode("image/", $image_parts[0]);
                $image_type = $image_type_aux[1];
                $image_base64 = base64_decode($image_parts[1]);
                $image = "blog". uniqid() . '.'.$image_type;;
                $file = $folderPath.$image;
                file_put_contents($file, $image_base64);
            } else
            {
                $image = $Blog->image;
            }
        }else{
                $image  = null;
            }
         
            if (!empty($request->hasFile('video'))) {
                $fileNameToStore = time() . '.' . $request->video->getClientOriginalExtension();
                $video = $request->file('video')->storeAs('blog', Str::random(20) . $fileNameToStore);
               
            }
            else
            {
                $video = $Blog->video;
            }
        $data = [
            'user_id' =>$user->id,
            'title'   =>$request->title,
            'category'=>$request->category,
            'domain_id'=>$domain_id,
            'status'=>$request->status,
            'tags'=>$request->tags,
            'expiry_status'=> $request->expiry_status,
            'expiry_date'=>$request->expiry_date,
            'article'=>$request->article,
            'dont_miss'=>$request->dont_miss??0,
            'featured'=>$request->featured??0,
            'editor_picked'=>$request->editor_picked??0,
            'youtube'=>$request->youtube,
            'most_popular'=>$request->most_popular??0,
            'view_count'=>$request->view_count,
            'image'=>$image,
            'video'=>$video
        ];

        $blog = $Blog->update($data);
        return $blog;
    }

    public function destroyblog($request){
        $blog = self::find($request->blog_id);
        $response = $blog->delete($blog);
        return $response;
    }
    public static function get_blog(){
           $user_id = get_domain_id();
         return self::where('domain_id',$user_id)->orderBy('created_at', 'desc')->take(2)->get(); 
         
    }
}
