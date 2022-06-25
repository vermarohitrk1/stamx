<?php

namespace App;

use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\Model;


class SmsLog extends Model {

    protected $fillable = [
        'from',
        'to',
        'body',
        'status',
        'attachment',
        'message_sid',
        'user_id'
    ];
    protected $table = 'sms_log';

}
