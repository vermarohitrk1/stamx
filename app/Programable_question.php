<?php

namespace App;
use Illuminate\Foundation\Auth\User as Authenticatable;

class Programable_question extends Authenticatable
{

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'question', 
        
    ];
   protected $table = "programable_questions";
   
    
}
