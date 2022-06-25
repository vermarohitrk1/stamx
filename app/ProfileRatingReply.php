<?php

namespace App;
use Illuminate\Foundation\Auth\User as Authenticatable;

class ProfileRatingReply extends Authenticatable
{

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'user_id', 
        'rating_id', 
        'rating',
        'comment',
    ];
   protected $table = "profile_rating_reply";
   
    public function user()
    {
        return $this->belongsTo('App\User','profile_id','id');
    }
    public function comment()
    {
        return $this->belongsTo('App\UserProfileRating','rating_id','id');
    }
}
