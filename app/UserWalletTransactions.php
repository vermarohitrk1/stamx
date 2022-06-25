<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class UserWalletTransactions extends Model
{
    protected $fillable = [
        'from',
        'to',
        'amount',
        'description',
        'entity_type',
        'entity_id',
        'invoice_id',
    ];
    protected $table = "wallet_transactions";
   

     public function from()
     {
         return $this->belongTo('App\User', 'from', 'id')->orderBy('id', 'DESC');
     }
     public function to()
     {
         return $this->belongTo('App\User', 'to', 'id')->orderBy('id', 'DESC');
     }

}
