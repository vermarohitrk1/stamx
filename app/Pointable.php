<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Pointable extends Model
{
    protected $table = 'pointables';
    protected $guarded = [];
    
    
    public function getPoints(){
        return $this->belongsTo(\Ansezz\Gamify\Point::class, 'point_id', 'id');
    }
}
