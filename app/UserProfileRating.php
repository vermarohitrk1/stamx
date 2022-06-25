<?php

namespace App;
use Illuminate\Foundation\Auth\User as Authenticatable;

class UserProfileRating extends Authenticatable
{

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'user_id', 
        'profile_id', 
        'rating',
        'comment',
    ];
   protected $table = "user_profile_rating";
   
    public function user()
    {
        return $this->belongsTo('App\User','profile_id','id');
    }
    public function reply()
    {
        return $this->hasMany('App\ProfileRatingReply','rating_id','id');
    }
}
