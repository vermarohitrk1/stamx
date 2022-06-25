<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Virtualbooth extends Model
{
 

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'photo_id', 
        'photo', 
      
    ];
   protected $table = "virtualbooth";
   
    
}
