<?php

namespace App;

use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\Model;

class ProductOrder extends Model {

    protected $table = 'product_orders';
    protected $fillable = [
        'order_id',
        'name',
        'email',
        'card_number',
        'card_exp_month',
        'card_exp_year',
        'product_name',
        'product_id',
        'amount',
        'price_currency',
        'txn_id',
        'payment_type',
        'payment_status',
        'receipt',
        'status',
        'user_id',
        'customer_id',
        'cart_id',
        'order_note',
        'order_description',
        'qty',
        'discount',
        'transfer_id',
        'drop_shipper',
    ];
    
     public function product()
    {
        return $this->belongsTo('App\ShopProduct','product_id','id');
    }
     public function user()
    {
        return $this->hasOne('App\User','id','user_id');
    }

}
