<?php

namespace App;

use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\Model;

class ProductBrand extends Model {

    protected $table = 'product_brands';
    protected $fillable = [
        'user_id',
        'title',
    ];
   public static function get_brand(){
        $user = Auth::user();
        $user_id=!empty($user->id) ? $user->id :0;
        if(!empty($user_id)){
        $brands = self::where("user_id", $user_id)->get();
        }else{
            $brands = self::get();
        }
        // echo "<pre>";print_r($brands); echo "</pre>";die();
        return $brands;
    }
   public static function get_brand_name($brand_id=0){
        $brands = self::where("id", $brand_id)->first();
        // echo "<pre>";print_r($brands); echo "</pre>";die();
        return !empty($brands->title) ? $brands->title : "Unknown";
    }
    
    public static function get_product_brands($count=10) {   
       $category = self::join('shopproducts  as s','s.brand','=','product_brands.id')
               ->join('users  as u','u.id','=','s.user_id')
                        ->whereRaw('(u.type="admin" OR (u.connected_stripe_account_verification=1 AND u.connected_stripe_account_id IS NOT Null))')
                 ->selectRaw('product_brands.*, count(*) as count')
               ->where('s.status', "Published")
                                    ->GroupBy('product_brands.id')
                                    ->orderBy('product_brands.title', 'ASC')->limit($count)->get();
       
       return $category;
        
    }
    

}
