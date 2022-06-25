<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PathwayInvitation extends Model
{
    protected $fillable = [];
    protected $table = "pathway_invitation";
    public function user()
     {
        return $this->belongsTo('App\User','user_id','id');
     }

     public function pathway()
     {
        return $this->hasOne('App\Pathway','id','pathway_id');
     }

}
