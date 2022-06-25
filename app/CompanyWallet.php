<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CompanyWallet extends Model
{
    protected $fillable = [
        'company_id',
        'balance',
        'status'
    ];
    
    protected $table = 'company_wallets';
}
