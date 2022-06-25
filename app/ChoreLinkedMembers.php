<?php

namespace App;
use Illuminate\Support\Facades\Auth;

use Illuminate\Database\Eloquent\Model;

class ChoreLinkedMembers extends Model
{
   protected $table = 'chore_linked_members';
   protected $fillable = [
        'id',
        'user_id',
        'chore_id',
    ];
   static function members($chore_id=0){
             $employees = \App\User::join('chore_linked_members as h','h.user_id','=','users.id')
                            //->where('users.type','employee')
                            ->OrderBy('users.id','DESC')
                            ->select('users.*','h.id as member_id')->whereRaw("(h.chore_id={$chore_id})")->get();

           return $employees;
            
   }
}
