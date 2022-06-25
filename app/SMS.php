<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Twilio\Rest\Client;
use App\User;
use App\Pathway;
use App\MotivationQuotes;
use App\UserMentor;
use App\SmsTemplate;
use App\Quote;

class SMS extends Model
{

    public $timestamps = false;
    protected $table = 'sms';

    public function sendSMS( $to, $sms_body, $user_id, $sms_id) {
       
        $accountsid = User::userSettingsInfo($user_id,'account_sid');     
        $authtoken = User::userSettingsInfo($user_id,'auth_token');
        $client = new Client($accountsid, $authtoken);
       
        try{
            if($to != ""){
                $client->messages->create(
                    $to,
                    [
                    'from' => User::userSettingsInfo($user_id,'twilio_number'),             
                    'body' => $sms_body
                    ]
               );
               $array = [
                "status" => 'Sent',
                ];
                SMS::where('id',$sms_id)->update($array);
            }
                     
        }catch(\Exception $e){  
            $array = [
                "status" => 'Not sent',
            ];
            SMS::where('id',$sms_id)->update($array);
        }       
    }

    public function sendReminders() {      
        $reminder = "This is your daily reminder form SMS send. Get it done!";
        $recipients = SMS::where('status','Pending')->where('schedule', date('Y-m-d'))->get();

        foreach($recipients as $recipient) {
            $this->sendSMS($recipient->number, trim($recipient->sms), $recipient->user_id, $recipient->id);
        }
    }

    public function sendRemindersPerMonth() {     
        
        $recipients = Pathway::select('user_id')->where('send_reminder','Yes')->where('reminder_type', 'Monthly')->get();
//dd( $recipients);
        if(!$recipients->isEmpty()){
            foreach($recipients as $recipient) {
                $user =  User::select('mobile','name')->where('id',$recipient->user_id)->first();
                $quote = Quote::select('name')->inRandomOrder()->first();
                $this->sendSMSforPathway($user->mobile, trim($quote->name), $recipient->user_id, $user->name);
            } 
        }        
    }

    public function sendRemindersPerDay() {     
        
        $recipients = Pathway::select('user_id')->where('send_reminder','Yes')->where('reminder_type', 'Daily')->get();
//dd();
        if(!$recipients->isEmpty()){
            foreach($recipients as $key => $recipient) {
                if($key == 0){
                $user =  User::select('mobile','name')->where('id',$recipient->user_id)->first();
                $quote = Quote::select('name')->inRandomOrder()->first();
               // dd( $quote);
                $this->sendSMSforPathway($user->mobile, trim($quote->name), $recipient->user_id, $user->name);
            }
        } 
        }        
    }

    public function sendRemindersPerWeek() {    

        $recipients = Pathway::select('user_id')->where('send_reminder','Yes')->where('reminder_type', 'Weekly')->get();

        if(!$recipients->isEmpty()){
            foreach($recipients as $recipient) {
                $user =  User::select('mobile','name')->where('email','mentor@stemx.com')->first();
                $quote = Quote::select('name')->inRandomOrder()->first();
                $this->sendSMSforPathway($user->mobile, trim($quote->name), $recipient->user_id, $user->name);
            } 
        }        
    }

    public function sendSMSforPathway($to, $sms_body, $user_id, $user_name){
         //stop email notificaiton
            $user_record= \App\User::where('mobile',$to)->first();
            if(!empty($user_record)){
                if(empty($user_record->sms_notification)){
                     $arReturn = [
                    'status' => 'Not sent'
                ];
                return $arReturn;
                }
            }
            
        $sms_body = str_replace("%name%",$user_name,$sms_body);
       // dd(  $sms_body );
     // $accountsid = env('TWILIO_ACCOUNT_SID');     
     // $authtoken = env('TWILIO_AUTH_TOKEN');
        $accountsid = 'AC572f66c416b67152fcb6bb9503b75def';     
        $authtoken = '6c1866641babcd176bed91ef734ed093';
       // dd($accountsid,$authtoken);
        $client = new Client($accountsid, $authtoken);
     
       $to = '+14697855951';
       $from = '+14104985616';
         
        if($to != ""){
           
            try{
                $client->messages->create(
                    $to,
                    [
                    'from' => $from,             
                    'body' => $sms_body
                    ]
                ); 
                 $array = [
                    "status" => 'Sent',
                ]; 
                //die;
              print_r($array);
            

            }catch(\Exception $e){  

                dd($e);
                $array = [
                    "status" => 'Not sent',
                ]; 
                return $e->getMessage();
                           
            }    

            
        }    
        
    }

    public function sendSMStoMentor($userId){
        $mentors = UserMentor::select('mentor_id')->where('user_id',$userId)->get();
        if(!$mentors->isEmpty()){
            foreach($mentors as $mentor) {

                if(User::select('phone','name')->where('id',$mentor->mentor_id)->count() > 0){
                    $user =  User::select('phone','name')->where('id',$mentor->mentor_id)->first();
                    $ui = User::select('name')->where('id',$userId)->first();
                    //sms body
                    $sb = SmsTemplate::where('name','Reminder to mentor')->count();
                    if($sb <= 0){
                        $array = [
                            'name'=>'Reminder to mentor',
                            'body'=>'<p class="mb-1" style="color: rgb(132, 146, 166);">Hello {name} !!</p><p class="mb-1" style="color: rgb(132, 146, 166);"><span style="color: rgb(0, 0, 0);">{mentor} is online now.</span><br></p>',
                            'created_by'=>1,
                            'created_at'=>date('y-m-d h:i:s'),
                            'updated_at'=>date('y-m-d h:i:s')
                        ];
                        SmsTemplate::insert($array);
                    }
                    $t = SmsTemplate::select('body')->where('name','Reminder to mentor')->first();
                    $body = $t->body;
                    $sms_body = str_replace("{name}",$user->name,$body);
                    $sms_body = str_replace("{mentor}",$ui->name,$sms_body);                
                    
                    if($user->phone != ""){
                        $m =$this->sendSMSforPathway($user->phone, $sms_body, $mentor->mentor_id, $user->name);
                    }
                }

                                
            }
        }
    } 
    public static function send_common_sms( $to, $sms_body, $user_id) {
         //stop email notificaiton
            $user_record= \App\User::where('mobile',$to)->first();
            if(!empty($user_record)){
                if(empty($user_record->sms_notification)){
                     $arReturn = [
                    'is_success' => false,
                    'error' => "Notification disabled",
                ];
                return $arReturn;
                }
            }
            
        $twilio_settings="";
        $domain = UserDomain::where(['user_id' => $user_id])->first();
            $setting = \App\SiteSettings::where("name", 'twilio_key')->where('user_domain_id', $domain->id)->first();
            if (!empty($setting->value) && !empty(json_decode($setting->value))) {
                $twilio_settings = json_decode($setting->value, true);
            } elseif (!empty($setting->value)) {
                $twilio_settings = $setting->value;
            }
             
        $accountsid = $twilio_settings['twilio_account_sid']??"";     
        $authtoken = $twilio_settings['twilio_auth_token']??"";
       $message_from=$twilio_settings['twilio_from']??$twilio_settings['twilio_number'];       
        try{
             $client = new Client($accountsid, $authtoken);
        
            if($to != ""){
                $client->messages->create(
                    $to,
                    [
                    'from' =>$message_from,             
                    'body' => $sms_body
                    ]
               );
             
                 //recording log
                  $message_log = new \App\SmsLog();
                    $message_log['status']='sent';
                    $message_log['from']=$message_from;
                    $message_log['to']=$to;
                    $message_log['body']=$sms_body;
                    $message_log['user_id']=$user_id;
                   $message_log->save();
            }
                     
        }catch(\Exception $e){  
           $error=$e->getMessage()??"Not sent";
        }      
    
          if (isset($error)) {
                $arReturn = [
                    'is_success' => false,
                    'error' => $error,
                ];
            } else {
                $arReturn = [
                    'is_success' => true,
                    'error' => false,
                ];
            }
            
            return $arReturn;
    }
    

}
