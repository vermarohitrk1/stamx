<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\User;
use Auth;

class Page extends Model
{
    protected $fillable = [
        'custom_url',
        'slug',
        'page_name',
        'page_data',
        'status',
		'image',
        'title',
        'subtitle',
        'color',
    ];

    public function getuserdata($userid){
    	$user =  User::where(['id'=>$userid])->first();
    	return $user;
    }

    public function getpages($all){
         $user_id =  get_domain_id();
         if($all == 'all'){
            $Page = self::where(['user_id'=>$user_id])->get();
         }
         return $Page;
    }

}
