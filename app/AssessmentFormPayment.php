<?php

namespace App;

use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\Model;

class AssessmentFormPayment extends Model {

    protected $table = 'assessmentformpayments';
    protected $fillable = [
        'order_id',
        'name',
        'email',
        'card_number',
        'card_exp_month',
        'card_exp_year',
        'form_title',
        'form_id',
        'amount',
        'price_currency',
        'txn_id',
        'payment_type',
        'payment_status',
        'receipt',
        'user_id',
    ];
    
     public function form()
    {
        return $this->belongsTo('App\AssessmentForms','form_id','id');
    }
     public function user()
    {
        return $this->hasOne('App\User','id','user_id');
    }

}
