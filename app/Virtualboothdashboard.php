<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Virtualboothdashboard extends Model
{
    protected $fillable = [
        'photo_id', 
        'photo', 
      
    ];
   protected $table = "virtualbooth_dashboards";
}
