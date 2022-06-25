<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Twilio\Rest\Client;
use App\User;
use App\Pathway;
use App\MotivationQuotes;
use App\UserMentor;
use Illuminate\Support\Facades\Mail;
use App\Mail\CommonEmailTemplate;
use App\Quote;

class EMAIL extends Model {

    public $timestamps = false;
    protected $table = 'email';

    public function sendRemindersPerMonth() {

        $recipients = Pathway::select('user_id')->where('send_reminder', 'Yes')->where('reminder_type', 'Monthly')->get();
//dd( $recipients);
        if (!$recipients->isEmpty()) {
            foreach ($recipients as $recipient) {
                $user = User::select('email', 'name')->where('id', $recipient->user_id)->first();
                $quote = Quote::select('name')->inRandomOrder()->first();
                $this->sendSMSforPathway($user->email, trim($quote->name), $recipient->user_id, $user->name);
            }
        }
    }

    public function sendRemindersPerDay() {

        $recipients = Pathway::select('user_id')->where('send_reminder', 'Yes')->where('reminder_type', 'Daily')->get();
//dd();
        if (!$recipients->isEmpty()) {
            foreach ($recipients as $recipient) {
                $user = User::select('email', 'name')->where('id', $recipient->user_id)->first();
                $quote = Quote::select('name')->inRandomOrder()->first();
                // dd( $quote);
                $this->sendSMSforPathway($user->email, trim($quote->name), $recipient->user_id, $user->name);
            }
        }
    }

    public function sendRemindersPerWeek() {

        $recipients = Pathway::select('user_id')->where('send_reminder', 'Yes')->where('reminder_type', 'Weekly')->get();

        if (!$recipients->isEmpty()) {
            foreach ($recipients as $recipient) {
                $user = User::select('email', 'name')->where('id', $recipient->user_id)->first();
                $quote = Quote::select('name')->inRandomOrder()->first();
                $this->sendSMSforPathway($user->email, trim($quote->name), $recipient->user_id, $user->name);
            }
        }
    }

    public function sendSMSforPathway($to, $sms_body, $user_id, $user_name) {
         //stop email notificaiton
            $user_record= \App\User::where('email',$to)->first();
            if(!empty($user_record)){
                if(empty($user_record->email_notification)){
                     $arReturn = ['error' => "Notification disabled",
                ];
                return $arReturn;
                }
            }
        $sms_body = str_replace("%name%", $user_name, $sms_body);

        $response = array();

        $to = 'pulkittyagi229@gmail.com';
        if (!empty($to)) {
            $mailTo = $to;
            // send email
            try {
                $resp = Mail::to($mailTo)->send(new \App\Mail\Quotes($sms_body));
                // dd(  $resp);
                $response['success'] = empty($resp) ? "Email sent successfully" : $resp;
                return $response;
            } catch (\Exception $e) {
                dd($e);
                $error = __('E-Mail has been not sent due to SMTP configuration');
                $response['error'] = $error;
                return $response;
            }
        } else {

            $mailTo = $subscriber->email; // $subscriber->email;

            $content->mailto = $mailTo;
            // send email
            try {
                $resp = Mail::to($mailTo)->send(new \App\Mail\Quotes($sms_body));
            } catch (\Exception $e) {
                $error = __('E-Mail has been not sent due to SMTP configuration');
            }
        }
    }

    public static function common_send_Email($email = null, $name = null, $subject = 'New Email', $body = null, $from_user = null,$user_data=null,$emailteample=0) {
        if (!empty($from_user) && !empty($body)) {
            
            //stop email notificaiton
            $user_record= \App\User::where('email',$email)->first();
            if(!empty($user_record)){
                if(empty($user_record->email_notification)){
                     $arReturn = [
                    'is_success' => false,
                    'error' => "Notification disabled",
                ];
                return $arReturn;
                }
            }
            $mailer_setting = '';
            $domain = UserDomain::where(['user_id' => $from_user])->first();
            $setting = \App\SiteSettings::where("name", 'mailer_settings')->where('user_domain_id', $domain->id)->first();
            if (!empty($setting->value) && !empty(json_decode($setting->value))) {
                $mailer_setting = json_decode($setting->value, true);
            } elseif (!empty($setting->value)) {
                $mailer_setting = $setting->value;
            }

              if(!empty($mailer_setting)){
                         foreach ($mailer_setting as $mailer_settings){
                             if(!empty($mailer_settings['MAIL_DEFAULT']) && $mailer_settings['MAIL_DEFAULT']=="Yes"){
                config(
                        [
                            'mail.driver' => $mailer_settings['MAIL_DRIVER']??'',
                            'mail.host' => $mailer_settings['MAIL_HOST']??'',
                            'mail.port' => $mailer_settings['MAIL_PORT']??'',
                            'mail.encryption' => $mailer_settings['MAIL_ENCRYPTION']??'',
                            'mail.username' => $mailer_settings['MAIL_USERNAME']??'',
                            'mail.password' => $mailer_settings['MAIL_PASSWORD']??'',
                            'mail.from.address' => $mailer_settings['MAIL_FROM_ADDRESS']??'',
                            'mail.from.name' => $mailer_settings['MAIL_FROM_NAME']??'',
                        ]
                );
                         }
                         }
                }
            if(!empty($emailteample)){
                $template= \App\EmailTemplate::find($emailteample);
                 $template_response= \App\EmailTemplate::prepare_email_body($body,$domain->id,$template->integration_place,$user_data);
                        $subject=$template_response['subject'];
                        $body=$template_response['body'];
                        $from=$template_response['from'];
            }
            $content = (object) [
                        "to" => $name,
                        "subject" => $subject,
                        "content" => $body,
                        "email" => $email,
                        "from" => !empty($from)?$from:env('APP_NAME'),
            ];
            // send email
         
            try {
                $resp = Mail::to($email)->send(new CommonEmailTemplate($content));
            } catch (\Exception $e) {
                $error = __('E-Mail has been not sent due to SMTP configuration');
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
        } else {
            $arReturn = [
                'is_success' => false,
                'error' => __('Mail not send, email is empty'),
            ];
        }
        return $arReturn;
    }

}
