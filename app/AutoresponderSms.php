<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class AutoresponderSms extends Model
{
	public $timestamps = false;
    protected $table = 'autoresponder_sms';
    protected $fillable = [
        'autoresponder_id',
        'sender_id',
        'mobile',
        'status',        
        'created_at',
        'message'
    ];

   
}
