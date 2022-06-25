<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\User;
use Auth;

class Partner extends Model
{
    protected $fillable = [
        'user_id',
        'custom_url',
        'logo',
        'link',
        'status',
        'add_to_slider',
    ];

    public function getuserdata($userid){
    	$user =  User::where(['id'=>$userid])->first();
    	return $user;
    }

    public function getalldata($all){
        $user_id =  get_domain_id();
         if($all == 'all'){
            $Page = self::where(['user_id'=>$user_id])->paginate(5);
         }
         return $Page;
    }

    public static function getActivePartner(){
        $user_id =  get_domain_id();
        $partner = Partner::where(['user_id'=>$user_id])->get();
        return $partner;
    }
    public static function getaddToSliderPartner(){
        $user_id =  get_domain_id();
        $partner = Partner::where(['user_id'=>$user_id])->where('status','=','Active')->get();
        return $partner;
    }

}
