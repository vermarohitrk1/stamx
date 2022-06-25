<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CandidateEvent extends Model
{
    /**
     * @var string[]
     */
    protected $fillable = [
        'candidate_id ',
        'candidate_job_status_id  ',
        'created_by',
        'event_type',
        'event_start_datetime',
        'event_end_datetime',
        'location',
        'attendees',
        'description',
    ];

    /**
     * @return mixed
     */
    public function getEventType(){
        $eventType = AddEvent::where("status", "Enable")->get();
        $eventOptions[""] = "Choose One";
        foreach ($eventType as $type) {
            $eventOptions[$type->id] = $type->name;
        }
        return $eventOptions;
    }

    /**
     * @return array
     */
    public function getAttendees(){
        $attendees = User::get();
        $attendeesList = [];
        foreach ($attendees as $attendee){
            $attendeesList[$attendee->id] = $attendee->name;
        }
        return $attendeesList;
    }

    /**
     * @return array|mixed
     */
    public function getSelectedAttendees(){
        $attendees = json_decode($this->attendees, true);
        if(!empty($attendees)){
            return $attendees;
        }
        return [];
    }

    /**
     * @return false|int
     */
    public function getCurrentDate(){
        $currentDate = date('Y-m-d h:i:s');
        $date = strtotime($currentDate);
        return $date;

    }

    /**
     * @param $eventId
     * @return string
     */
    public function getEventLabel($eventId){
        $event = AddEvent::find($eventId);
        if(!empty($event)){
            return $event->name;
        }else{
            return '';
        }

    }

    /**
     * @param $format
     * @param $datetime
     * @return false|string
     */
    public function getEventDateFormat($format, $datetime){
        $date = strtotime($datetime);
        return date($format, $date);
    }

    /**
     * @param $id
     * @return string
     */
    public function getCandidateName($id){
        $candidate = Candidate::find($id);
        if(!empty($candidate)){
            $name = $candidate->first_name ." ". $candidate->last_name;
            return $name;
        }
        return "";
    }

    /**
     * @param $id
     * @return false|string
     */
    public function getAttendeesNameLabel($id){
        $attendeesData = User::find($id);
        if(!empty($attendeesData)){
            return strtoupper(substr($attendeesData->name, 0, 2));
        }
        return "";
    }

    /**
     * @param $id
     * @return string
     */
    public function getAttendeesName($id){
        $attendeesData = User::find($id);
        if(!empty($attendeesData)){
            return ucfirst($attendeesData->name);

        }
        return "";
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function candidateJobStatus(){
        return $this->belongsTo(CandidateJobStatus::class);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function candidate(){
        return $this->belongsTo(Candidate::class);
    }
}
