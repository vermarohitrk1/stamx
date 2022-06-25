<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Auth;

class MeetingScheduleSlotCanceled extends Model
{
    protected $table = 'meeting_schedules_slots_canceled';
    protected $fillable = [
        'user_id',
        'domain_id',
        'meeting_schedule_id',
        'date',
        'start_time',
        'price',
        'end_time',
        'is_accomplished'
    ];
    
     public function user()
    {
        return $this->belongsTo('App\User','user_id','id');
    }
     
   
}
