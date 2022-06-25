<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class VirtualboothEventsFrames extends Model
{
    protected $fillable = [
        'event_id', 
        'image', 
        'status',
        'type',
    
      
    ];
   protected $table = "virtualbooth_events_frames";
}
