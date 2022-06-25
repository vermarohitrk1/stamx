<?php

namespace App;

use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\Model;

class ProductAttribute extends Model {

    protected $table = 'product_attribute';
    protected $fillable = [
        'user_id',
        'title',
        'status',
    ];

    public static function get_product_attribute() {
        $user = Auth::user();
        $product_attribute_collection = self::where("status", "Active")->where("user_id", $user->id)->get();
        // echo "<pre>";print_r($product_attribute_collection);die();
        return $product_attribute_collection;
    }

}
