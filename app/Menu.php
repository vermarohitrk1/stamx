<?php

namespace App;
use App\SiteSettings;

use Illuminate\Database\Eloquent\Model;

class Menu extends Model
{
    protected $fillable = ['title','parent_id','user_id','url','orders'];
    public function childs() {
        return $this->hasMany('App\Menu','parent_id','id') ;
    }
    
	public static function get_menus(){
		$user_id =!empty($user_id) ? $user_id : get_domain_userid();
		$get_domain_id=	get_domain_userid();
		return self::where(['user_id'=>$user_id])->where('parent_id', '=', 0)->orderBy('orders', 'asc')->get();
		// return self::where('parent_id', '=', 0)->orderBy('orders', 'asc')->get();
        }
	
	public static function getWebsiteMenus($slug,$user_id=0)
    {
        $user_id =!empty($user_id) ? $user_id: get_domain_userid();
        $allMenus = SiteSettings::where('name', $slug)->where('created_by', $user_id)->first();
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
}
