<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class SwagOption extends Model
{
     protected $table = 'swag_options';
     protected $fillable = [
        'id',
        'name',
        'option_value',
        'user_id',
    ];
     
      public static function getSwagOptions() {
        $user_id = get_domain_id();
        
        return self::where('user_id',$user_id)->get();
    }
}
