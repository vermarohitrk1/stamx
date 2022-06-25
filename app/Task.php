<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Task extends Model
{
    protected $fillable = [];
    protected $table = "tasks";
    public function user()
     {
        return $this->belongsTo('App\User','user_id','id');
     }
     public static function pathway()
     {
         return $this->belongsTo(Pathway::class,'pathway_id','id');
     }

     public function comments()
     {
         return $this->hasMany('App\TaskComment', 'task_id', 'id')->orderBy('id', 'ASC');
     }
     public function category()
     {
         return $this->hasOne('App\TaskCategory', 'id', 'type');
     }

}
