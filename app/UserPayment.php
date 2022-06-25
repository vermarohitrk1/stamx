<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Auth;

class UserPayment extends Model
{
    protected $table = 'user_payments';
    protected $fillable = [
        'order_id',
        'name',
        'email',
        'card_number',
        'card_exp_month',
        'card_exp_year',
        'entity_type',
        'entity_id',
        'user_id',
        'title',
        'amount',
        'status',
        'price_currency',
        'txn_id',
        'payment_type',
        'payment_status',
        'receipt',
        'paid_to_user_id',
        'other_description',
        'qty',
        'discount',
    ];
    
     public function user()
    {
        return $this->belongsTo('App\User','user_id','id');
    }
}
