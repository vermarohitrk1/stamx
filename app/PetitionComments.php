<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PetitionComments extends Model
{
    protected $table = 'petition_comments';
     protected $fillable = [
          'user_id',
        'petition_id',
        'comment',
        'status',
        'display',
    ];
      public function form()
    {
        return $this->belongsTo('App\PetitionForms', 'id', 'petition_id');
    }
      public function user()
    {
        return $this->belongsTo('App\User');
    }
   
}
