<?php

namespace App;
use Illuminate\Foundation\Auth\User as Authenticatable;

class Role extends Authenticatable
{

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'created_by', 
        'role', 
        'status',
        'permissions',
    ];
   protected $table = "roles";
   
    public function user()
    {
        return $this->belongsTo('App\User','created_by','id');
    }
}
