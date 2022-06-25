<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Auth;

class ContactsUnsubscriber extends Model
{
    protected $table = 'unsubscribers';
    protected $fillable = [
        'type',
        'fullname',
        'contact_us',
        'message',
        'fname',
        'lname',
        'email',
        'phone',
        'folder',
        'user_id',
        'url',
        'created_at',
        'domain_id',
         'email_subscription',
        'sms_subscription',
        'avatar'
    ];

    public function getconnections($all){
         $user = Auth::user();
         if($all == 'all'){
            $Newconnect = self::where(['user_id'=>$user->id])->paginate(5); 
         }
         return $Newconnect;
    }
     public function getAvatarUrl()
    {
             if(file_exists(storage_path().'/contact/'.$this->avatar) && !empty($this->avatar)){
            return asset(\Storage::url('contact/'.$this->avatar));
        } else {
            return asset('assets/img/user/user.jpg');
        }
    }
   
}
