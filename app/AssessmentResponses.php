<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class AssessmentResponses extends Model
{
    protected $table = 'assessmentresponses';
     protected $fillable = [
       'user_id',
        'form',
        'payment',
        'response',
        'points',
        'status',
    ];
  public function form()
    {
        return $this->belongsTo('App\AssessmentForms', 'id', 'form');
    }
    
      public function user()
    {
        return $this->belongsTo('App\User');
    }
}
