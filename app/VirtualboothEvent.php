<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class VirtualboothEvent extends Model
{
    protected $fillable = [
        'user_id', 
        'event_name', 
        'status',
        'event_image',
      
    ];
   protected $table = "virtualbooth_events";
}
