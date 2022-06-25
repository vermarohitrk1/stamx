<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class IvrSetting extends Model
{
    protected $fillable = [
        'user_id',
        'twilio_mp3',
        'twilio_text',
        'greetings',
        'greetings_mp3',
        'ivr',
        'ivr_text',
        'ivr_mp3',
        'voicemail',
        'voicemail_text',
        'voicemail_mp3',
        'twilio_number',
        'sid',
        'twilio_voice',
        'transfer_call',
        'incomingcall_mp3',
        'caller_wait_time',
        'support',
        'sales',
        'notification',
        'email',
        'mobile',
        'email_template',
        'sms_template',
        'out_of_hour',
        'out_of_hour_type',
        'out_of_hour_text',
        'out_of_hour_mp3',
        'sunday',
        'monday',
        'tuesday',
        'wednesday',
        'thursday',
        'friday',
        'saturday',
        'timezone',
    ];
     protected $table = 'ivr_settings';
}
