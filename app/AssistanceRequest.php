<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class AssistanceRequest extends Model {

    protected $fillable = [
        'assistance',
        'user',
        'type',
        'certify',
        'gender',
        'status',
        'date',
        'time'
    ];
    protected $table = 'assistance_requests';

    public function addData($request) {
        $gender = '';
        if (Auth::user()->gender) {
            $gender = Auth::user()->gender;
        } else {
            $gender = 'Other';
        }
        $data = self::create([
                    'assistance' => $request->assistance,
                    'user' => $request->user,
                    'type' => $request->type,
                    'certify' => $request->certify,
                    'status' => "Pending",
                    'gender' => ucfirst($gender),
                    'date' => trim(date("Y-m-d")),
                    'time' => trim(date("H:i:s"))
        ]);
        return $data;
    }
	
	// Return Last 7 Days with date & day name
    public static function getLastSevenDays()
    {
        $arrDuration   = [];
        $previous_week = strtotime("-1 week +1 day");

        for($i = 0; $i < 7; $i++)
        {
            $arrDuration[date('Y-m-d', $previous_week)] = date('D', $previous_week);
            $previous_week                              = strtotime(date('Y-m-d', $previous_week) . " +1 day");
        }

        return $arrDuration;
    }
	
	
	 public static function affiliate_calculateTimesheetHours($time,$points)
    {
        $minutes = 0;
        return sprintf('%02d:%02d', $points, $minutes);
    }

}
