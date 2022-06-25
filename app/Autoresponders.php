<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Twilio\Rest\Client;

class Autoresponders extends Model
{
	public $timestamps = false;
    protected $table = 'autoresponder';
    protected $fillable = [
        'user',
        'typeTemplate',
        'custom_sms',
        'custom_message',
        'custom_sms',
        'campaign_name',
        'folder',
        'day',
        'time',
        'typeOnChoice',
        'date',
        'status'
    ];

   
    public static function sendCompaignEmailsMessage($compaign=null) {
        if(!empty($compaign->id)){
                $custom_message=$compaign->custom_message;
                $custom_sms=$compaign->custom_sms;
                $typeTemplate = $compaign->typeTemplate;
                $compaignFolder='"'.$compaign->folder.'"';
        $recipients = \App\Contacts::whereRaw("(email_subscription like '%".$compaignFolder."%' OR sms_subscription like '%".$compaignFolder."%')")->where('user_id',$compaign->user)->get();
       
        
        foreach($recipients as $contact) {
           
            if(!empty($contact->email) && ($typeTemplate=="Email" || $typeTemplate=="Email/SMS") && !empty($contact->email_subscription) && in_array($compaign->folder,json_decode($contact->email_subscription)) ){
                 $subject = \App\ContactFolder::getfoldername($compaign->folder)." Email";
                $email = $contact->email;
                $name = ($contact->fname." ".$contact->lname)??"Subscriber";
               $resp= \App\EMAIL::common_send_Email($email, $name, $subject, $custom_message , $compaign->user,$contact,$compaign->email_template_id);
          
                if((!empty($resp['is_success']))  ){
                    $returnHTML="Email successfully sent";
                    $returnsuccess = true;
                }else{
                    
                $returnHTML = $resp['error'];
                   
                $returnsuccess = false;
                }
                
                $store_response = new \App\AutoresponderEmails();
                $store_response['autoresponder_id'] = $compaign->id;
                $store_response['sender_id'] = $compaign->user;
                $store_response['email'] = $email;
                $store_response['status'] = !empty($returnsuccess) ? "success":'error';
                $store_response['message'] = $returnHTML;
                $store_response['created_at'] = date('Y-m-d h:m:s');
                $store_response->save();                
            }
            
            if(!empty($contact->phone) && !empty($custom_sms) && ($typeTemplate=="SMS" || $typeTemplate=="Email/SMS") && !empty($contact->sms_subscription) && in_array($compaign->folder,json_decode($contact->sms_subscription)) ){
                $resp=\App\SMS::send_common_sms($contact->phone,$custom_sms,$compaign->user);
                if((!empty($resp['is_success']))  ){
                    $returnHTML="SMS successfully sent";
                    $returnsuccess = true;
                }else{
                    
                $returnHTML = $resp['error'];
                   
                $returnsuccess = false;
                }
                
                $store_response = new \App\AutoresponderSms();
                $store_response['autoresponder_id'] = $compaign->id;
                $store_response['sender_id'] = $compaign->user;
                $store_response['mobile'] = $contact->phone;
                $store_response['status'] = !empty($returnsuccess) ? "success":'error';
                $store_response['message'] = $returnHTML;
                $store_response['created_at'] = date('Y-m-d h:m:s');
                $store_response->save();                
            }
        }
        }   
    }
}
