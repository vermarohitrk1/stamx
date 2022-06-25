<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * Class CandidateJobStatus
 * @package App
 */
class CandidateJobStatus extends Model
{
    /**
     * @var string[]
     */
    protected $fillable = [
        'candidate_id',
        'jobpost',
        'status',
        'reviews',
        'current_stage',
    ];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function candidate(){
        return $this->belongsTo(Candidate::class);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function notes(){
        return $this->hasMany(CandidateNotes::class);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function event(){
        return $this->hasMany(CandidateEvent::class);
    }

//    public static function create(array $data)
//    {
//        $candidate = Candidate::find($data['candidate_id']);
//        $emalbody = "You have successfully assigned for this Job";
//        Utility::send_emails($candidate->email, $candidate->first_name, null, $emalbody,JobNotification::JOB_APPLIED);
//        return (new static)->newQuery()->create($data);
//    }

}
