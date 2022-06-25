<?php

namespace App;
use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\Model;

class ShopCategory extends Model {

    protected $table = 'product_category_types';
    protected $fillable = [
        'id',
        'user_id',
        'name',
        'status',
        'parent_id',
    ];

   public static function get_category_tree($parent_id = 0, $sub_mark = '', $selectedId = '') {
        $user = Auth::user();
       
        $allCategory = self::where("parent_id", $parent_id)->where('user_id', $user->id)->get();
        //echo "<pre>"; print_r($allCategory); die('fsdfsdf');
        foreach ($allCategory as $category) {
            $selected = '';
            if ($selectedId == $category->id) {
                $selected = 'selected';
            }
            echo '<option value="' . $category->id . '" ' . $selected . '>' . $sub_mark . $category->name . '</option>';
            get_category_tree($category->id, $sub_mark . '---', $selectedId);
        }
    }
    public static function get_category_name($id=0) {       
       $category= self::where("id", $id)->first();
       return !empty($category->name) ? $category->name:'Un-Categorized';
        
    }
   public static function get_random_categories($count=10,$id=0) {       
       $category= self::join('users  as u','u.id','=','product_category_types.user_id')
                        ->selectRaw('product_category_types.*')
                        ->whereRaw('(u.type="admin" OR (u.connected_stripe_account_verification=1 AND u.connected_stripe_account_id IS NOT Null))')
                       ->inRandomOrder()->limit($count);
       if(!empty($id)){
         $category->WHere('product_category_types.id',$id)  ;
         $category->orWHere('product_category_types.id','!=',$id)  ;
       }
       $category=$category->get();
 
       return $category;
        
    }
   public static function get_last_month_best_sale_categories($count=10) {   
       $category = self::join('product_categories  as c','c.category_id','=','product_category_types.id')
                 ->join('product_orders  as o','o.product_id','=','c.product_id')
               ->join('users  as u','u.id','=','product_category_types.user_id')
                 ->selectRaw('product_category_types.*, count(*) as count')
               ->whereRaw('(u.type="admin" OR (u.connected_stripe_account_verification=1 AND u.connected_stripe_account_id IS NOT Null))')
                                    ->whereRaw(' YEAR(o.created_at)=YEAR(CURRENT_DATE - INTERVAL 1 MONTH) and MONTH(o.created_at)=MONTH(CURRENT_DATE - INTERVAL 1 MONTH)')
                                    ->GroupBy('product_category_types.id')
                                    ->orderBy('count', 'DESC')->limit($count)->get();
       
       return $category;
        
    }

}
