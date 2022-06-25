<?php

namespace App;
use Illuminate\Support\Facades\Auth;

use Illuminate\Foundation\Auth\User as Authenticatable;

class SiteSettings extends Authenticatable
{

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'user_id', 
        'user_domain_id', 
        'name',
        'value',
    ];
   protected $table = "website_setting";
   
    public function user()
    {
        return $this->belongsTo('App\User','user_id','id');
    }
    public function domain()
    {
        return $this->belongsTo('App\UserDomain','user_domain_id','id');
    }
    public static function getValByName($key)
    {
        $response='';
        $domain_id= get_domain_id();  
        $setting = self::where("name",$key)->where('user_domain_id',$domain_id)->first();

       if(!empty($setting->value) && !empty(json_decode($setting->value))){
           $response= json_decode($setting->value,true);
       }elseif(!empty($setting->value)){
           $response=$setting->value;
       }
        return $response;
    }
    public static function getUserSettings($key,$user_id=0)
    {
        $response='';
        if(empty($user_id)){
        $user_id= Auth::user()->id;  
        }
        $setting = self::where("name",$key)->where('user_id',$user_id)->first();

       if(!empty($setting->value) && !empty(json_decode($setting->value))){
           $response= json_decode($setting->value,true);
       }elseif(!empty($setting->value)){
           $response=$setting->value;
       }
        return $response;
    }
	
	public static function getWebsiteMenus($slug,$user_id=0)
    {
        $user_id =!empty($user_id) ? $user_id: get_domain_userid();
        $allMenus = self::where('name', $slug)->where('user_id', $user_id)->first();
        if (!$allMenus) {
            return [];
        }
        $menus = (array)json_decode($allMenus->value);
        $menusLabels = array_key_exists("label", $menus) ? (array)$menus['label'] : [];
        $menusLinks = array_key_exists("link", $menus) ? (array)$menus['link'] : [];
        $newMenus = [];
        foreach ($menusLinks as $key => $menu) {
            $newMenus[$menusLabels[$key]] = $menu;
        }
        return $newMenus;
    }
	    public static function logoSetting($user_id=0)
    {
     //   dd($user_id);
        $user_id =!empty($user_id) ? $user_id : get_domain_id();
		//dd($user_id);
	$get_domain_id=	get_domain_id();
  
	if($get_domain_id==1){
	$result = self::where(['user_id' => $user_id, 'name' => 'favicon'])->first();	
		
	}
	else{
		if($get_domain_id){
			$result = self::where(['user_domain_id' => $user_id, 'name' => 'favicon'])->first();
			
		}
		else{
			
			$result = self::where(['user_id' => $user_id, 'name' => 'favicon'])->first();
		}
			
	}
        if (!empty($result)) {
            return $result;
        }
    }
	
	
	
	    public static function logotext($user_id=0)
    {
        $user_id =!empty($user_id) ? $user_id : get_domain_id();
        $result = self::where(['user_id' => 1, 'name' => 'logo_text'])->first();
        if (!empty($result)) {
            return $result->value;
        }
    }
	
	
	  public static function WebsiteSetting($slug,$user_id=0)
    {
        if(empty($user_id)){
        $user_id = get_domain_id();
        }
        return self::where('name', $slug)->where('user_id', 1)->first();
    }
	 public static function footerSetting($user_id=0)
    {
        $user_id =!empty($user_id) ? $user_id : get_domain_id();
        $result = self::where(['user_id' => 1, 'name' => 'footer_text'])->first();
      
		   if (!empty($result)) {
            $data = $result->value;
            return $data;

        } else {
            return '';
        }
    }
}
