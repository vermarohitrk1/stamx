<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class AssessmentQuestions extends Model
{
    protected $table = 'assessmentquestions';
     protected $fillable = [
       'user_id',
        'form',
        'points',
        'question',
        'type',
        'options',
        'indexing',
    ];

 
}
