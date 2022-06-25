<?php

namespace App;

use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\Model;

class ProductImage extends Model {

    protected $table = 'product_images';
    protected $fillable = [
        'product_id',
        'img_url'
    ];
public static function get_first_image($id=0) {
        $img_url= self::where("product_id", $id)->first();
       return  !empty($img_url->img_url) ? $img_url->img_url :'';
        
    }
}
