<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PetitionFormQuestions extends Model
{
    protected $table = 'petition_form_questions';
     protected $fillable = [
       'user_id',
        'form_id',
        'question',
        'type',
        'options',
        'indexing',
        'resource_url',
    ];

 
}
