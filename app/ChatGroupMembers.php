<?php

namespace App;

use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\Model;


class ChatGroupMembers extends Model {

    protected $fillable = [
        'group_id',
        'user_id'
    ];
    protected $table = 'chat_group_members';

   

}
