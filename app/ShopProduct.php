<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
class ShopProduct extends Model
{
    protected $table = 'shopproducts';
     protected $fillable = [
       'user_id',
        'title',
        'sku',
        'status',
        'image',
        'price',
        'special_price',
        'commision_points',
        'quantity',
        'stock_status',
        'type',
        'category_id',
        'tags',
        'free',
        'description',
        'vendor',
        'refund_disclaimer',
        'shipping_options',
        'brand',
        'rating',
        'current_deal_off',
        'faqs',
    ];
      public function orders()
    {
        return $this->hasMany('App\ProductOrder', 'product_id', 'id');
    }
      public function category()
    {
        return $this->hasMany('App\ProductCategory', 'product_id', 'id');
    }
      public function images()
    {
        return $this->hasMany('App\ProductImage', 'product_id', 'id');
    }
      public static function stock_status($status='')
    {
          if($status !=''){
              $status_type= self::first()->stock_status;
          }
          $status_type = $status==1 ? "In stock" : 'Out stock';
          return $status_type;
       
    }
    public static function get_addon_products($addon_type=null,$addon_id=null) {
        $user = Auth::user();
       
        $allProducts= self::where('user_id', $user->id)->orderBy("id", "desc")->get();
        $selectedProducts= \App\ShopAddonProduct::where('addon_type', $addon_type)->where('addon_id', $addon_id)->pluck('product_id')->toArray();
      
        foreach ($allProducts as $row) {
            $selected= !empty($selectedProducts) && in_array($row->id,$selectedProducts)? ' selected ':'';
            echo '<option value="' . $row->id . '" ' . $selected . '>' .$row->title . '</option>';
        }
    }
 
}
