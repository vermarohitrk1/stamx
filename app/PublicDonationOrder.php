<?php

namespace App;
use Auth;
use Illuminate\Database\Eloquent\Model;

class PublicDonationOrder extends Model
{
    protected $fillable = [
        'user_id',
        'stripe_customer',
        'pdonation_users_id',
        'tranaction_id',
        'amount',
        'status',
        'monthlygift',
        'donation_date',
    ];

    public function getalldata($all){
        $user = Auth::user();
        if($all == 'all'){
           $PublicDonationOrder = self::where(['user_id'=>$user->id])->get(); 
        }
        return $PublicDonationOrder;
   }
}
