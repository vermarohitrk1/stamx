<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class ChoreInvitation extends Model
{
    protected $fillable = [];
    protected $table = "chore_invitations";
    public function user()
     {
        return $this->belongsTo('App\User','user_id','id');
     }

     public function chore()
     {
        return $this->hasOne('App\Chore','id','chore_id');
     }
     static function members(){
      $usr = Auth::user();
            
             $employees = \App\User::join('chore_invitations as h','h.user_id','=','users.id')
                            //->where('users.type','employee')
                            ->OrderBy('users.id','DESC')
                            ->select('users.*','h.id as member_id')->whereRaw("(users.created_by={$usr->id} OR users.id={$usr->id})")->get();

           return $employees;
            
   }
public static $priority_color = [
        'High' => 'danger',
//        'High' => 'warning',
        'medium' => 'primary',
        'Low' => 'info',
    ];
}
