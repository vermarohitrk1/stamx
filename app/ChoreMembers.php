<?php

namespace App;
use Illuminate\Support\Facades\Auth;

use Illuminate\Database\Eloquent\Model;

class ChoreMembers extends Model
{
   protected $table = 'chore_members';
   protected $fillable = [
        'id',
        'user_id',
        'created_by',
    ];
   static function members(){
      $usr = Auth::user();
            
             $employees = \App\User::join('chore_members as h','h.user_id','=','users.id')
                            //->where('users.type','employee')
                            ->OrderBy('users.id','DESC')
                            ->select('users.*','h.id as member_id')->whereRaw("(h.created_by={$usr->id} OR users.id={$usr->id})")->get();

           return $employees;
            
   }
}
