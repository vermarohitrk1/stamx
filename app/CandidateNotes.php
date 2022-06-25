<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * Class CandidateNotes
 * @package App
 */
class CandidateNotes extends Model
{
    /**
     * @var string[]
     */
    protected $fillable = [
        'candidate_id',
        'candidate_job_status_id',
        'noted_by',
        'notes'
    ];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function candidate(){
        return $this->belongsTo(Candidate::class);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function candidateJobStatus(){
        return $this->belongsTo(CandidateJobStatus::class);
    }

    public static function create(array $data)
    {
        $candidate = Candidate::find($data['candidate_id']);
        $emailbody = $data['notes'];
        Utility::send_emails($candidate->email, $candidate->first_name, null, $emailbody,JobNotification::NOTE_CREATED);
        return (new static)->newQuery()->create($data);
    }
}
