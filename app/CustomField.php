<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CustomField extends Model
{
    protected $fillable = [
        'label', 'type','value'
        
    ];
   protected $table = "custom_fields";
}


