<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class SupportCategory extends Model
{
       protected $table = 'supportcategories';
     protected $fillable = [
        'id',
        'user_id',
        'name',
    ];
     public function supports()
    {
        return $this->hasMany('App\Support');
    }
}
