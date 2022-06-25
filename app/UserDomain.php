<?php

namespace App;
use Illuminate\Foundation\Auth\User as Authenticatable;

class UserDomain extends Authenticatable
{

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'user_id', 
        'custom_url', 
        'domain'
    ];
   protected $table = "user_domains";
   
    public function user()
    {
        return $this->belongsTo('App\User','user_id','id');
    }
}
