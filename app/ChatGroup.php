<?php

namespace App;

use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\Model;


class ChatGroup extends Model {

    protected $fillable = [
        'name',
        'image',
        'description',
        'user_id'
    ];
    protected $table = 'chat_group';

    //get g details from ID
    public static function groupInfo($id = '')
    {
        return $g = ChatGroup::find($id);
    }

}
