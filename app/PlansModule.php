<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PlansModule extends Model
{
    protected $fillable = [
        'plan_id',
        'addon_id'
    ];
    
    protected $table = "plansmodules";
    
   
    
}
