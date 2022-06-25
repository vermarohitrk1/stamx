<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Supportticket extends Model
{
    protected $table = 'supporttickets';
   protected $fillable = [
        'id',
        'submitted_to_id',
        'user_id',
        'category_id',
        'subject',
        'status',
        'entity_id',
        'entity_type',
    ];
     public function category()
    {
        return $this->belongsTo('App\SupportCategory');
    }
     public function user()
    {
        return $this->belongsTo('App\User');
    }
     public function messages()
    {
        return $this->hasMany('App\Supportticketmessage','ticket_id','id');
    }
     public static function lastmessages($ticket_id=0)
    {
         $last_message=\App\Supportticketmessage::where('ticket_id',$ticket_id)->orderBy('id', 'desc')->first();
        return $last_message;
    }
     public static $status_color = [
        'Support Reply' => 'primary',
        'New' => 'danger',
        'Customer Reply' => 'danger',
        'Closed' => 'success'
    ];
}
