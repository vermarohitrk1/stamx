<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Auth;

class MeetingScheduleSlot extends Model
{
    protected $table = 'meeting_schedules_slots';
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
     public static function IsAvailableBookingSlots($user_id=0)
    {
         $date=date('Y-m-d');
         $endtime=date('H:i:s');
        return  self::join('meeting_schedules as ms','ms.id','=','meeting_schedules_slots.meeting_schedule_id')
                ->where('ms.user_id', $user_id)
                ->where('ms.status', 'Active')
               // ->where('meeting_schedules_slots.end_time', $endtime)
                ->where('meeting_schedules_slots.user_id', null)
                
                ->where('meeting_schedules_slots.date','>=', $date)->count();
    }
   
}
