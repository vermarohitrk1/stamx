<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
class ShopProductRating extends Model
{
    protected $table = 'shop_products_rating';
     protected $fillable = [
       'user_id',
        'product_id',
        'rating',
        'comment',
    ];
      public function getUserName($id){
        $user = User::find($id);
        if ($user) {
            return $user->name;
        }
        return 'Anonymous';
    }

    public function getUserAvatar($id){
        $user = User::find($id);
        if ($user && $user->avatar) {
            return asset('storage').'/'.$user->avatar;
        }
        return asset('public').'/frontend/images/client/02.jpg';
    }
  public static function ratingCounts($id){
        return self::where('product_id', $id)->get()->count();
    }
  public static function ratingproducts(){
      $rating= \App\ShopProduct::join('users  as u','u.id','=','shopproducts.user_id')
                        ->whereRaw(' (u.type="admin" OR (u.connected_stripe_account_verification=1 AND u.connected_stripe_account_id IS NOT Null))')
              ->selectRaw("shopproducts.rating,count(shopproducts.id) as products")
                ->where("shopproducts.status","Published")
                ->GroupBy("shopproducts.rating")
                ->OrderBy("shopproducts.rating",'DESC')->get();

      $array=array();
      for($i=5;$i>=1;$i--){
          $products=0;
          if(!empty($rating)){
              foreach ($rating as $product){
                  if($product->rating==$i){
                      $products=$product->products;
                  }
              }
          }
          $array[$i]=$products;
      }
        return $array;
    }
  public static function ratingusers($id=0){
      $rating= \App\ShopProductRating::selectRaw("rating,count(id) as reviews")
                ->where("product_id",$id)
                ->GroupBy("rating")
                ->OrderBy("rating",'DESC')->get();

      $array=array();
      for($i=5;$i>=1;$i--){
          $products=0;
          if(!empty($rating)){
              foreach ($rating as $product){
                  if($product->rating==$i){
                      $products=(int) 100*$product->reviews/$rating->sum('reviews');
                  }
              }
          }
          $array[$i]=$products;
      }
        return $array;
    }
}
