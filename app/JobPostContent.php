<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class JobPostContent extends Model
{
    /**
     * @var string[]
     */
    protected $fillable = [
        "job_id",
        "content",
    ];
}
