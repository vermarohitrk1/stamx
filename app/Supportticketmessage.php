<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Supportticketmessage extends Model
{
    protected $table = 'supportticketmessages';
   protected $fillable = [
        'id',
        'ticket_id',
        'user_id',
        'message',
        'sender',
        'file',
    ];
   public function ticket()
    {
        return $this->belongsTo('App\Supportticket','id','ticket_id');
    }
     public function user()
    {
        return $this->belongsTo('App\User');
    }
}
