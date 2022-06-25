<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class TaskComment extends Model
{
    protected $fillable = [];
    protected $table = "task_comments";
   

     public function task()
     {
         return $this->belongTo('App\Task', 'task_id', 'id')->orderBy('id', 'DESC');
     }

}
