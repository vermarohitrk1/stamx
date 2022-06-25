<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Syndicatepayment extends Model
{
    protected $fillable = [
    	'owner',
    	'certify',
    	'amount',
    	'buyer',
    	'owner_share',
    	'promoter',
    	'promoter_share',
    	'admin_share',
    ];

    protected $table = "syndicatepayments";
}
