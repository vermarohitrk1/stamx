<?php

namespace App;
use Illuminate\Support\Facades\Auth;

use Illuminate\Database\Eloquent\Model;

class Chore extends Model
{
   protected $table = 'chores';
   protected $fillable = [
        'id',
        'user_id',
        'title',
        'description',
        'price',
        'category_id',
        'day',
        'start_time',
        'end_time',
        'start_date',
        'end_date',
        'typeOnChoice',
        'priority',
        'status',
    ];
    public function comments()
     {
         return $this->hasMany('App\ChoreComment', 'chore_id', 'id')->orderBy('id', 'ASC');
     }
     public function category()
     {
         return $this->hasOne('App\ChoreCategory', 'id', 'type');
     }
}
