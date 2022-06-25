<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ChoreCategory extends Model
{
       protected $table = 'chore_categories';
     protected $fillable = [
        'id',
        'user_id',
        'name',
    ];
      public function getDetails($id)
    {
    	return self::find($id);
    }
      public static function category_name($id)
    {
    	return self::find($id)->name??'';
    }
     public function chores()
    {
        return $this->hasMany('App\Chore');
    }
     public function chore()
    {
        return $this->belongTo('App\Chore', 'type', 'id');
    }
}
