<?php

namespace App;
use Illuminate\Foundation\Auth\User as Authenticatable;

class Institution extends Authenticatable
{

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['institution','address','city','state','type','user_id' ,'status','zip','lat','long','country'];
   protected $table = "institutions";
  
    
}
