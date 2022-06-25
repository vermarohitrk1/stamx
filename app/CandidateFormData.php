<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CandidateFormData extends Model
{
    const UPLOAD_DIR = "storage/job/files/";

    protected $fillable = [
        'candidate_id',
        'job_id',
        'field_id',
        'field_type',
        'label',
        'value',
    ];

    /**
     * @param $fileName
     * @return string
     */
    public function getJobResume($fileName){
        return self::UPLOAD_DIR.$fileName;
    }
}
