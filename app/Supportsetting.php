<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Supportsetting extends Model
{
     protected $table = 'supportsettings';
   protected $fillable = [
        'id',
        'user_id',
        'close_days',
    ];
}
