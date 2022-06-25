<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Pathway extends Model
{
   protected $fillable = [];
    protected $table = "pathways";
    public function user()
     {
        return $this->belongsTo('App\User','user_id','id');
     }
     public function task()
     {
        return $this->hasMany(Task::class,'id','pathway_id');
     }
     public function pathwayInvite()
     {
        return $this->BelongTo('App\PathwayInvitation','pathway_id','id');
     }
}
