<?php

namespace App;
use Illuminate\Database\Eloquent\Model;

class ProductCategory extends Model {

    protected $table = 'product_categories';
    protected $fillable = [
        'category_id',
        'product_id',
    ];

    public function category()
    {
        return $this->hasOne('App\ShopCategory', 'id', 'category_id');
    }
    public static function first_category($id=0)
    {
        $category='';
        if(!empty($id)){
            $shop_category_data= self::where('product_id',$id)->first();
            $shop_category_id = !empty($shop_category_data->category_id) ? $shop_category_data->category_id :0;
        $category = !empty($shop_category_id) ? \App\ShopCategory::get_category_name($shop_category_id) : "Un-Categorized";
        }else{
            $category= 'Un-Categorized';
        }
        return $category;
    }

}
