<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class AutoresponderEmails extends Model
{
	public $timestamps = false;
    protected $table = 'autoresponder_emails';
    protected $fillable = [
        'autoresponder_id',
        'sender_id',
        'email',
        'status',
        'created_at',
        'email_template_id',
        'message'
    ];

   
}
