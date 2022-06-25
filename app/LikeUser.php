<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Auth;

class LikeUser extends Model
{
    protected $table = 'like_users';
    protected $fillable = [
        'user_id',
        'like_user_id'
    ];
public static function IslikeMarked($user_id=0)
    {
         $user = Auth::user();
        return  self::where('user_id', $user->id??0)->where('like_user_id', $user_id)->count();
    }
      
}
