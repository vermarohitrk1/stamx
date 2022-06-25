<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ChoreComment extends Model
{
    protected $fillable = [];
    protected $table = "chore_comments";
   

     public function task()
     {
         return $this->belongTo('App\Chore', 'chore_id', 'id')->orderBy('id', 'DESC');
     }
     public function user()
     {
         return $this->belongTo('App\User', 'created_by', 'id')->orderBy('id', 'DESC');
     }

}
