<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Auth;

class MeetingSchedule extends Model
{
    protected $table = 'meeting_schedules';
    protected $fillable = [
        'user_id',
        'domain_id',
        'title',
        'service_type_id',
        'service_id',
        'price',
        'price_description',
        'description',
        'status'
    ];
     public static function getServiceType($id=0) {
          $type[1] = "General Consultancy";
        $type[2] = "Course Consultancy";

        if (!empty($id) && $id <= sizeof($type)) {
            return $type[$id];
        } else {
            return $type;
        }
        
    }
     public function user()
    {
        return $this->belongsTo('App\User','user_id','id');
    }
}
