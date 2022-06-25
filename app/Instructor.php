<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Instructor extends Model
{
     protected $fillable = [
       
        'user_id',
        'created_by',
        'domain_id',
        'is_approved',
        'is_verified',
    ];
protected $table = "instructors";
     //get user avatar attribute with userid
    public static function getInstructordata($id=0) {
        $avatarName = 'Anonymous';
        $avatarImg = '';

        $user_data = \App\User::where('id', $id)->first();
        if ($user_data) {
            $avatarImg = $user_data->avatar;
            $avatarName = $user_data->name;
             if (\Storage::exists($avatarImg) && !empty($avatarImg)) {
            $user_data->avatar= asset(\Storage::url('app/'.$avatarImg));
        } else {
            $user_data->avatar= asset('assets/img/user/user.jpg');
        }
            
        }
        return $user_data;
    }
}
