<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class AssessmentForms extends Model
{
    protected $table = 'assessmentforms';
     protected $fillable = [
       'user_id',
        'title',
        'type',
        'amount',
        'amount_status',
        'description',
        'category',
    ];
     public function forms()
    {
        return AssessmentForms::hasOne('App\AssessmentCategory', 'id', 'category');
    }
      public function user()
    {
        return AssessmentForms::hasOne('App\User', 'id', 'user_id');
    }
      public function questions()
    {
        return $this->hasMany('App\AssessmentQuestions', 'form', 'id');
    }
      public function responses()
    {
        return $this->hasMany('App\AssessmentResponses', 'form', 'id');
    }
    
      public function category()
    {
        return $this->belongsTo('App\AssessmentCategory', 'id', 'category');
    }
   
}
