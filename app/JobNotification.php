<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class JobNotification extends Model
{
    const CANDIDATE_DISQUALIFIED = 'candidate_disqualified';
    const DISQUALIFICATION_MAIL_FOR_CANDIDATE = 'disqualification_mail_for_candidate';
    const EVENT_CREATED = 'event_created';
    const CREATE_EVENT_MAIL_FOR_CANDIDATE = 'create_event_mail_for_candidate';
    const NOTE_CREATED = 'note_created';
    const JOB_APPLIED = 'job_applied';
    const JOB_APPLY_RESPONSE_FOR_CANDIDATE = 'job_apply_response_for_candidate';

    protected $fillable = [
        'event_name',
        'status',
        'event_slug',
    ];
}
