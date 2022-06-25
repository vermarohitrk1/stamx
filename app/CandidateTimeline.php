<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CandidateTimeline extends Model
{
    protected $fillable = ['candidate_id', 'message'];
}
