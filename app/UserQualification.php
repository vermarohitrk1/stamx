<?php

namespace App;
use Illuminate\Foundation\Auth\User as Authenticatable;

class UserQualification extends Authenticatable
{

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'user_id', 
        'degree', 
        'college',
        'major',
        'program',
        'job_title',
    ];
   protected $table = "user_qualification";
   
    public function user()
    {
        return $this->belongsTo('App\User','user_id','id');
    }
}
