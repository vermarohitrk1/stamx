<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Auth;

class FavouriteUser extends Model
{
    protected $table = 'favourite_users';
    protected $fillable = [
        'user_id',
        'fav_user_id'
    ];
public static function IsFavMarked($user_id=0)
    {
         $user = Auth::user();
        return  self::where('user_id', $user->id??0)->where('fav_user_id', $user_id)->count();
    }
      
}
