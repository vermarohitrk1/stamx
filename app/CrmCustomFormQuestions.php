<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CrmCustomFormQuestions extends Model
{
    protected $table = 'crm_custom_form_questions';
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
