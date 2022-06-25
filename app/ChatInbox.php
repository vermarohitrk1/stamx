<?php

namespace App;

use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\Model;


class ChatInbox extends Model {

    protected $fillable = [
        'sender_id',
        'receiver_id',
        'message_text',
        'message_type',
        'sender_seen_status',
        'receiver_seen_status',
        'sender_trash_status',
        'msg_sent_at',
        'message_cat',
        'group_id'
    ];
    protected $table = 'chat_inbox';

    
    public function currentMentorChat($id) {
        $user = Auth::user();
		;
        if (Auth::user()->type != 'mentor') {
            $data = self::where(['receiver_id' => $user->id, 'sender_id' => $id , 'group_id' =>0])->orWhere(['sender_id' => $user->id])->where([ 'receiver_id' => $id])->orderBy('created_at','ASC')->get();
        } else {
            $data = self::where(['sender_id' => $user->id, 'receiver_id' => $id , 'group_id' =>0])->orWhere(['receiver_id' => $user->id])->where([ 'sender_id' => $id])->orderBy('created_at','ASC')->get();
        }
	
        if($data){
            foreach($data as $userData){
                if($userData->sender_id == $user->id){
                    $userData->sender_seen_status = 'Yes';
                    $userData->save();
                    $userData->through = 'sender';
                }else{
                    if($userData->receiver_id == $user->id){
                        $userData->receiver_seen_status = 'Yes';
                        $userData->save();
                    }
                    $userData->through = 'receiver';
                }
            }
        }
        return $data;
    }

    public function currentUserChat($id,$inbox=null) {
        $user = Auth::user();
        if($inbox=="group"){
            $data = self::where([ 'group_id' => $id])->get();
        }else{
        if (Auth::user()->type != 'owner') {
            $data = self::where(['receiver_id' => $user->id, 'sender_id' => $id])->orWhere(['sender_id' => $user->id])->where([ 'receiver_id' => $id])->get();
        } else {
            $data = self::where(['sender_id' => $user->id, 'receiver_id' => $id])->orWhere(['receiver_id' => $user->id])->where([ 'sender_id' => $id])->get();
        }
        }
        if($data){
            foreach($data as $userData){
                if((empty($userData->group_id) && $inbox !="group") || (!empty($userData->group_id) && $inbox =="group")){
                if($userData->sender_id == $user->id){
                    $userData->sender_seen_status = 'Yes';
                    $userData->save();
                    $userData->through = 'sender';
                }else{
                    if($userData->receiver_id == $user->id){
                        $userData->receiver_seen_status = 'Yes';
                        $userData->save();
                    }
                    $userData->through = 'receiver';
                }
                }
            }
        }
        return $data;
    }

    public function storeMessage($request) {
        $user = Auth::user();
	
        $data = array(
            "sender_id" => $user->id,
            "receiver_id" =>  $request->receiver ,
            "message_text" => $request->messagetext,
            "message_type" => 'text',
            "sender_seen_status" => 'Yes',
            "receiver_seen_status" => 'No',
            "sender_trash_status" => 'No',
            "message_cat" => 'text',
            "group_id" => (!empty($request->inbox) && $request->inbox =="group") ? $request->receiver :0,
        );
        $data = self::create($data);        
            if(!empty($request->inbox) && $request->inbox !="group"){
            $reciever = \App\User::find($request->receiver);
            if(empty($reciever->is_active)){
               
                $ojb = array(
                    'name' => $user->name,
                );
                $template_name = "Chat Message Notification";
                $mailTo = $reciever->email;
                $resp = \App\Utility::common_sendEmailTemplate($template_name, $mailTo, $ojb);
                if($resp['is_success']){
                    $returnHTML="Email successfully sent";
                    $returnsuccess = true;
                }else{
                $returnHTML = $resp['error'];
                $returnsuccess = false;
                }
            }
            }
       
        return $data;
    }

}
