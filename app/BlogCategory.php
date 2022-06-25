<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Filesystem\Filesystem;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use App\User;

class BlogCategory extends Model

{
    protected $fillable = [
        'user_id',
		'name',
		'featured',
		'icon',
		'domain_id',

    ];

	protected $table = "blog_categories";

	public function getcategory($all){
		 $user = Auth::user();
		 if($all == 'all'){
			$BlogCategory = self::where(['user_id'=>$user->id])->paginate(5); 
		 }
		 return $BlogCategory;
	}
	
	
	public function store($request){
		$user = Auth::user();
                $domain_id= get_domain_id();
		$data = [
			"user_id" => $user->id,
			"domain_id" => $domain_id,
			'name'	=> $request->name,
			'featured'	=> $request->featured??0
		];
		$category = self::create($data);
		return $category;
	}

	public function viewlist(){
		$user = Auth::user();
		return self::where(['user_id'=>$user->id])->paginate(10);
	}

	public function categoryedit($id){
		$user = Auth::user();
		$category = self::find($id);
		return 	$category;
	}

	public function categoryUpdate($request){
		$user = Auth::user();
                $domain_id= get_domain_id();
		$category = self::where(['user_id'=>$user->id,'id'=>$request->id])->first();
		$data = [
			"user_id" =>$user->id,
			"name"=> $request->name,
                    "domain_id" => $domain_id,
			'featured'	=> $request->featured??0
		];
		$response = $category->update($data);	
		return $response;	
	}	

	public function destroycategory($request){
		$category = self::find($request->category_Id);
		$category = $category->delete($request);
		return $category;
	}	


}
