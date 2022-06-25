<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PetitionFormResponses extends Model
{
    protected $table = 'petition_form_responses';
     protected $fillable = [
       'user_id',
        'form_id',
        'response',
    ];
  public function form()
    {
        return $this->belongsTo('App\PetitionForms', 'id', 'form_id');
    }
      public function user()
    {
        return $this->belongsTo('App\User');
    }
      
}
