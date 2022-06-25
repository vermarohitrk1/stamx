<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Education extends Model
{
    protected $fillable = [
        'education', 
        
    ];
   protected $table = "user_educations";
}
