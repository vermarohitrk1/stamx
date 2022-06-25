<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PetitionUpdates extends Model
{
    protected $table = 'petition_updates';
     protected $fillable = [
          'user_id',
        'petition_id',
        'date',
        'updates',
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
