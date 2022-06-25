<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Photoboothsharecount extends Model
{
    protected $table = 'photoboothsharecount';
   protected $fillable = [
        'id',
        'count',
        'url',
        'name',
        'email',
        'frame_id'
     
    ];
   
}
