<?php

use App\JobNotification;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Str;
use App\User;
use App\Examsreport;
use App\Plan;
use App\MyCourse;
use App\Lecture;
use App\CertifyChapter;
use App\StudentLectureStatus;
use App\UserDomain;
use App\ChatInbox;
use App\JobSetting;
use Carbon\Carbon;
use Twilio\Jwt\ClientToken;
use Twilio\Rest\Client;
use Twilio\Jwt\TaskRouter\WorkerCapability;
//use Mail;

if (!function_exists('get_domain_id')) {

    function get_domain_id() {
        if(!empty($_SERVER['HTTP_HOST'])){
            $url = explode('.', $_SERVER['HTTP_HOST'])[0];
            $domain = UserDomain::where(['custom_url' => $url])->first();
            if (empty($domain)) {
                $full_domain = $_SERVER['SERVER_NAME'];
            $just_domain = preg_replace("/^(.*\.)?([^.]*\..*)$/", "$2", $_SERVER['HTTP_HOST']);
            $domain = UserDomain::where(['domain' => $just_domain])->first();
            }
            return !empty($domain->id) ? $domain->id : 1;
        }
        return 1;

    }

}
if (!function_exists('time_elapsed')) {

    function time_elapsed($datetime, $full = false) {
        $now = new DateTime;
        $ago = new DateTime($datetime);
        $diff = $now->diff($ago);

        $diff->w = floor($diff->d / 7);
        $diff->d -= $diff->w * 7;

        $string = array(
            'y' => 'year',
            'm' => 'month',
            'w' => 'week',
            'd' => 'day',
            'h' => 'hour',
            'i' => 'minute',
            's' => 'second',
        );
        foreach ($string as $k => &$v) {
            if ($diff->$k) {
                $v = $diff->$k . ' ' . $v . ($diff->$k > 1 ? 's' : '');
            } else {
                unset($string[$k]);
            }
        }

        if (!$full)
            $string = array_slice($string, 0, 1);
        return $string ? implode(', ', $string) . ' ago' : 'just now';
    }

}
if (!function_exists('get_domain_user')) {

    function get_domain_user() {

            $url = explode('.', $_SERVER['HTTP_HOST'])[0];
            $domain = UserDomain::where(['custom_url' => $url])->first();

        if (empty($domain)) {
             $full_domain = $_SERVER['SERVER_NAME'];
        $just_domain = preg_replace("/^(.*\.)?([^.]*\..*)$/", "$2", $_SERVER['HTTP_HOST']);
        if($just_domain == 'localhost'){ $just_domain='stemx.com';}
        $domain = UserDomain::where(['domain' => $just_domain])->first();

        }
        if (!empty($domain)) {
            $user = User::where('id', $domain->user_id)->where('is_active','!=','0')->first();
        } else {
            $user = User::where('id', 1)->where('type','admin')->first();
        }
        return $user;
    }

}

if (!function_exists('get_domain_userid')) {

    function get_domain_userid() {
        if(!empty($_SERVER['HTTP_HOST'])){
            $url = explode('.', $_SERVER['HTTP_HOST'])[0];
            $domain = UserDomain::where(['custom_url' => $url])->first();
            if (empty($domain)) {
                $full_domain = $_SERVER['SERVER_NAME'];
            $just_domain = preg_replace("/^(.*\.)?([^.]*\..*)$/", "$2", $_SERVER['HTTP_HOST']);
            $domain = UserDomain::where(['domain' => $just_domain])->first();
            }
            return !empty($domain->user_id) ? $domain->user_id : 1;
        }
        return 1;

    }

}
if (!function_exists('get_domain_info')) {

    function get_domain_info() {
        $full_domain = $_SERVER['SERVER_NAME'];
        $just_domain = preg_replace("/^(.*\.)?([^.]*\..*)$/", "$2", $_SERVER['HTTP_HOST']);
        $domain = UserDomain::where(['domain' => $just_domain])->first();
        if (empty($domain)) {
            $url = explode('.', $_SERVER['HTTP_HOST'])[0];
            $domain = UserDomain::where(['custom_url' => $url])->first();
        }
        return $domain;
    }

}

if (!function_exists('encrypted_key')) {
    function encrypted_key($uID, $action) {
        $output = false;
        $encrypt_method = "AES-256-CBC";
        $secret_key = 'SoftSolex is Best';
        $secret_iv = 'ThinkTank';
        // hash
        $key = hash('sha256', $secret_key);

        // iv - encrypt method AES-256-CBC expects 16 bytes - else you will get a warning
        $iv = substr(hash('sha256', $secret_iv), 0, 16);
        if ($action == 'encrypt') {
            $output = openssl_encrypt($uID, $encrypt_method, $key, 0, $iv);
            $output = base64_encode($output);
        } else if ($action == 'decrypt') {
            $output = openssl_decrypt(base64_decode($uID), $encrypt_method, $key, 0, $iv);
        }
        return $output;
    }
}
if (!function_exists('system_permissions')) {

    function system_permissions() {
        return [
            "allow_signup_from_admin_domain",
            "allow_signup_from_sub_domain",
            "allow_to_user_admin_mailer_settings",
            "add_in_search_profiles",
            "add_for_petition_support",
            "book_appointment",
            "manage_meeting_appointments",
            "manage_sub_domain",
            "manage_domain_users",
            "manage_contacts",
            "manage_petitions",
            "manage_assessments",
            "manage_auto_responders",
            "manage_surveys",
            "manage_courses",
            "manage_help_desk",
            "manage_chores",
            "manage_blogs",
            "manage_shop",
            "manage_email_templates",
            "course_manage_certificates",
//            "course_syndicate",
            "course_manage_instructors",
//            "course_corporate_payments",
            "course_create_regular",
//            "course_create_master_class",
//            "course_marketplace",
            "points",
        ];
    }

}
if (!function_exists('email_integration_places')) {

    function email_integration_places() {
        $jobNotifications = JobNotification::all();
        $notification = [];
        foreach ($jobNotifications as $jobNotification){
            $notification[$jobNotification->event_slug] = $jobNotification->event_name;
        }

        $email_integration_places = [
            "registration" => 'Registration',
            'certify_enrolled' => 'Certify Enrolled',
            "corporate_request_approval" => 'Corporate Request Approval',
            "corporate_request_declined" => 'Corporate Request Declined',
            "corporate_request_information" => 'Corporate Request Information',
            "cancel_plan" => 'Cancel Plan',
            "plan_expired" => 'Plan expired',
            "account_suspension" => 'Account suspension',
            "task_assign_pathway" => 'Task Assign(pathway)',
            "thanks_you" => 'Thank You',
            "invitation_received" => 'Invitation received(pathway)',
            "donation" => 'Donation',
            "booking_create" => 'Booking create',
            "booking_resheduled" => 'Booking re-schedule',
            "booking_cancelled" => 'Booking cancelled',
            "booking_completed" => 'Booking Completed',
            "accept_request" => 'Accept Request',
            "approves" => 'approves',
            "photobooth" => 'Photobooth',
            "billing_invoices" => 'Billing & invoices',
            "plan_subscription" => 'Plan Subscription',
            "signup_newsletter"=>'Signup Newsletter',
            "newsletter_subscription"=>'Newsletter Subscription',
            "meeting_schedule_booking_confirmation_email"=>'Meeting Schedule Booking Confirmation Email',
            "shop_order_confirmation_email"=>'Shop Order Confirmation Email',
            "meeting_schedule_booking_cancel_email"=>'Meeting Schedule Booking Cancel Email',
            "meeting_schedule_booking_reschedule_email"=>'Meeting Schedule Booking ReSchedule Email',
            "chore_assign_email"=>'Chore Assign Email',
            "contact_us"=>'Contact Us',
            "assessment_assign_email"=>'Assessment Assign Email'
        ];
        return array_merge($email_integration_places, $notification);
    }

}
if (!function_exists('get_role_data')) {
    function get_role_data($role = 0, $param = null) {
        if(!empty($role)){
        $role = \App\Role::where('role', $role)->first();
        }else{
        $role = \App\Role::all();
        }
        switch ($param) {
            case "permissions":
                $role = !empty($role->permissions) ? json_decode($role->permissions) : array();
                break;
            case "status":
                $role = !empty($role->status) ? $role->status : '';
                break;
        }
        return $role;
    }

}
if (!function_exists('get_domain_roles')) {
    function get_domain_roles() {
        $roles = \App\Role::where('role' ,'!=', 'admin')->get();
        $domain_roles = array();
        $domain_user = get_domain_user();
        foreach ($roles as $role) {
            $permission = !empty($role->permissions) ? json_decode($role->permissions) : array();
            if($role->status=="Active"){
            if (!empty($domain_user->type) && $domain_user->type == "admin") {
                if (in_array("allow_signup_from_admin_domain", $permission)) {
                    array_push($domain_roles, $role->role);
                }
            } else {
                if (in_array("allow_signup_from_sub_domain", $permission)) {
                    array_push($domain_roles, $role->role);
                }
            }
            }
        }

        return $domain_roles;
    }

}

if (!function_exists('getLearnAssistence')) {

    function getLearnAssistence($certifyId) {
        $assistence = new MyCourse();
        $assistence = $assistence->getAllAssistenceOfCourse($certifyId);
        return $assistence;
    }

}
if (!function_exists('getLearnAssistenceCheck')) {

    function getLearnAssistenceCheck($certifyId) {
        $assistence = new MyCourse();
        $assistence = $assistence->getAllAssistenceOfCourse($certifyId);
        if (count($assistence)) {
            return true;
        } else {
            return false;
        }
    }

}
if (!function_exists('getLearnAssistenceUser')) {

    function getLearnAssistenceUser($certifyId) {
        $assistence = new MyCourse();
        $assistence = $assistence->getAllAssistenceOfCourseUser($certifyId);
        return $assistence;
    }

}

if (!function_exists('get_permission_roles')) {
    function get_permission_roles($permission_name=false) {
        $roles = \App\Role::where('permissions','LIKE',"%".$permission_name."%")->get()->pluck('role');;
        return $roles;
    }

}
if (!function_exists('permissions')) {
    function permissions() {
        $user = Auth::user();
        $role = \App\Role::where('role', $user->type??'')->first();
        $role = !empty($role->permissions) ? json_decode($role->permissions) : array();
        return $role;
    }

}
if (!function_exists('role_permissions')) {
    function role_permissions($role=null) {
        $role = \App\Role::where('role', $role)->first();
        $role = !empty($role->permissions) ? json_decode($role->permissions) : array();
        return $role;
    }

}
if (!function_exists('update_profile_completion')) {
    function update_profile_completion() {
        $User = Auth::user();
        $columns =["name","nickname","dob","blood_group","gender","mobile","about","state","avatar","tax_id","fiftyzeroonec"]; //Schema::getColumnListing('users');
        $qcolumns = Schema::getColumnListing('user_qualification');
        $qualification =  \App\UserQualification::where("user_id",$User->id)->first();
        $totalfillable = 0;
        $totalfilled = 0;
        foreach ($columns as $column) {
            if (!in_array($column, ["id", "type", "created_by", "is_active", "login_status", "average_rating", "profile_completion_percentage", "email_verified_at", "password", "remember_token", "created_at", "updated_at","plan","plan_expire_date","plan_type","customer_id"])) {
                $totalfillable++;
                if (!empty($User->$column)) {
                    $totalfilled++;
                }
            }
        }
        foreach ($qcolumns as $column) {
            if (!in_array($column, ["id", "created_at", "updated_at"])) {
                $totalfillable++;
                if (!empty($qualification->$column)) {
                    $totalfilled++;
                }
            }
        }
        $User->update(["profile_completion_percentage" => 100 * $totalfilled / $totalfillable]);
        if($User->profile_completion_percentage >= 80){
            $rolescheck = \App\Role::whereRole($User->type)->first();
                if($rolescheck->role == 'mentee' ){
                    // if(checkPlanModule('points')){
                        $checkPoint = \Ansezz\Gamify\Point::find(10);
                        if(isset($checkPoint) && $checkPoint != null ){
                            if($checkPoint->allow_duplicate == 0){
                                $createPoint = $User->achievePoint($checkPoint);
                            }else{
                                $addPoint = DB::table('pointables')->where('pointable_id', $User->id)->where('point_id', $checkPoint->id)->get();
                                if($addPoint == null){
                                    $createPoint = $User->achievePoint($checkPoint);
                                }
                            }
                        }
                    // }
                }
        }
    }

}

if (!function_exists('get_from_name_email')) {
    function get_from_name_email(){
        $users = get_domain_user();
        if(!empty($users->name)){
            return $users->name;
        }
    }

}
if (!function_exists('send_email')) {

    function send_email($email = null, $name = null, $subject = 'New Email', $body = null,$template=null,$user_data=null) {
       if (!empty($email) && !empty($body)) {

            try {
                 //stop email notificaiton
            $user_record= \App\User::where('email',$email)->first();
            if(!empty($user_record)){
                if(empty($user_record->email_notification)){
                    return false;
                }
            }
                $domain_id= get_domain_id();
                $domain_user= get_domain_user();
                $permissions= role_permissions($domain_user->type);


                if(in_array('allow_to_user_admin_mailer_settings', $permissions)){
                     $mailer_setting=\App\SiteSettings::getValByName('mailer_settings');
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
                }

                    if(!empty($template)){

                        $template_response= \App\EmailTemplate::prepare_email_body($body,$domain_id,$template,$user_data);
                        $subject=$template_response['subject'];
                        $body=$template_response['body'];
                        $from=$template_response['from'];
                    }else{
                        if(is_array($body)){
                            $array_body='';
                            foreach ($body as $i=>$row){
                                $array_body .="<b>".$i.":</b> ".$row."<br>";
                            }
                            $body=$array_body;
                        }
                    }

                 $from=!empty($from) ? $from : get_from_name_email();
               $res= \Mail::send([], ['name',$name], function($message) use ($email,$name,$subject,$body,$from) {
                    $message->to($email, $name)
                            ->from(config('mail.from.address'),$from)
                            ->subject($subject)
                            ->setBody($body, 'text/html');
                });

               return $res;
           } catch (Exception $e) {
               if(env('APP_ENV')=='local'){
				   dd($e);

				   } //for development mode


                return false;
           }
            return true;
        } else {
            return false;
        }
    }

}
if (!function_exists('send_sms')) {

    function send_sms($phone_number = null, $from_user_id = null, $message = null) {
        if (!empty($phone_number) && !empty($from_user_id) && !empty($message)) {
             //stop email notificaiton
            $user_record= \App\User::where('email',$phone_number)->first();
            if(!empty($user_record)){
                if(empty($user_record->sms_notification)){
                    return false;
                }
            }
            try {
                 $twilio_settings="";
        $domain = \App\UserDomain::where(['user_id' => $from_user_id])->first();
            $setting = \App\SiteSettings::where("name", 'twilio_key')->where('user_domain_id', $domain->id)->first();
            if (!empty($setting->value) && !empty(json_decode($setting->value))) {
                $twilio_settings = json_decode($setting->value, true);
            } elseif (!empty($setting->value)) {
                $twilio_settings = $setting->value;
            }

        $accountsid = $twilio_settings['twilio_account_sid']??"";
        $authtoken = $twilio_settings['twilio_auth_token']??"";
       $message_from=$twilio_settings['twilio_from']??$twilio_settings['twilio_number'];

                //sending sms
                $client = new Client($accountsid, $authtoken);
                $response = $client->account->messages->create(
                        $phone_number, array(
                    'from' => $message_from,
                    'body' => $message
                        )
                );

                //recording log
                  $message_log = new \App\SmsLog();
                    $message_log['status']='sent';
                    $message_log['from']=$message_from;
                    $message_log['to']=$phone_number;
                    $message_log['body']=$message;
                    $message_log['user_id']=$from_user_id;
                   $message_log->save();

            } catch (Exception $e) {
                return false;
            }
            return true;
        } else {
            return false;
        }
    }

}
if (!function_exists('checkExamStatus')) {

    function checkExamStatus($learnId) {

        $status = new \App\Examsreport();
        $status = $status->checkExamStatusOfLearn($learnId);
        return $status;
    }

}

if (!function_exists('getCertifyDetails')) {

        function getCertifyDetails($id) {
            $learn = new \App\Certify();
            $learn = $learn->getCertify($id);
            return $learn;
        }

    }

	if (!function_exists('getCategoryName')) {

        function getCategoryName($id) {
            $Category = new \App\CertifyCategory();
            $Category = $Category->getDetails($id);
            return $Category;
        }

    }

    if (!function_exists('syndicateCertifyStatus')) {

        function syndicateCertifyStatus($id) {
            $learn = new \App\Certify();
            $learn = $learn->getSyndicateStatus($id);
            return $learn;
        }

    }
    if (!function_exists('getSyndicateStatus')) {

    function getSyndicateStatus($certifyId) {
        $syndicate = new \App\Certify();
        $syndicate = $syndicate->getSyndicateStatus($certifyId);
        if ($syndicate) {
            return true;
        } else {
            return false;
        }
    }

}

    if (!function_exists('getChapterCountOfCertify')) {

    function getChapterCountOfCertify($id) {
        $learn = new  \App\Certify();
        $learn = $learn->getCertifyChapter($id);
        return $learn->count();
    }

}
if (!function_exists('getInstructorName')) {

    function getInstructorName($id) {
        $learn = new  \App\Certify();
        $learn = $learn->getCertifyInstructorName($id);
        return $learn;
    }

}
if (!function_exists('getCertityCategoryDetails')) {

    function getCertityCategoryDetails($id) {
        $category = new  \App\CertifyCategory();
        $category = $category->getDetails($id);
        return $category;
    }

}

if (!function_exists('getCertityName')) {

    function getCertityName($id) {
        $CertifyName = new  \App\Certify();
        $CertifyName = $CertifyName->getcDetails($id);
        return $CertifyName;
    }

}

if (!function_exists('getStudentScore')) {

    function getStudentScore($userId, $certifyId, $examId) {
        $Examsreport = new Examsreport();
        $Examsreport = $Examsreport->getStudentScoreData($userId, $certifyId, $examId);
        return $Examsreport;
    }

}

if (!function_exists('getCertityPrice')) {

    function getCertityPrice($id) {
        $CertifyPrice = new  \App\Certify();
        $CertifyPrice = $CertifyPrice->getcertPrice($id);
        return $CertifyPrice;
    }

}
if (!function_exists('getCorpurateCertityDetails')) {

    function getCorpurateCertityDetails($id) {
        $MyCourse = new  \App\MyCourse();
        $MyCourse = $MyCourse->getData($id);
        if ($MyCourse) {
            return true;
        } else {
            return false;
        }
    }

}
if (!function_exists('checkSyndicateOfCourse')) {

    function checkSyndicateOfCourse($certifyId) {
//        $Marketplace = new \AppMarketplace();
//        $Marketplace = $Marketplace->syndicateData($certifyId);
        if (!empty($Marketplace)) {
            return true;
        } else {
            $cettify = new \App\Certify();
            $cettify = $cettify->getSyndicateInfo($certifyId);
            if ($cettify) {
                return true;
            } else {
                return false;
            }
        }
    }

}
if (!function_exists('checkLearnApprove')) {

    function checkLearnApprove($learnId) {

        $status = new \App\Certify();
        $status = $status->checkLearnApproveStatus($learnId);
        return $status;
    }

}
if (!function_exists('checkEnrollStatus')) {

    function checkEnrollStatus($certifyId) {
        $enroll = new \App\Certify();
        $enroll = $enroll->checkEnrollStatusOfLoginUser($certifyId);
        return $enroll;
    }

}

if (!function_exists('certCode')) {

    function certCode($certifyId) {
        $Code = new \App\Certify();
        $Code = $enroll->CertCode($certifyId);
        return $Code;
    }

}
if (!function_exists('getLearnAssistenceCheck')) {

    function getLearnAssistenceCheck($certifyId) {
        $assistence = new \App\MyCourse();
        $assistence = $assistence->getAllAssistenceOfCourse($certifyId);
        if (count($assistence)) {
            return true;
        } else {
            return false;
        }
    }

}
if (!function_exists('getLearnAssistenceUser')) {

    function getLearnAssistenceUser($certifyId) {
        $assistence = new \App\MyCourse();
        $assistence = $assistence->getAllAssistenceOfCourseUser($certifyId);
        return $assistence;
    }

}
if (!function_exists('format_price')) {

    function format_price($amount) {
        $amount = (float) $amount;
        if ($amount < 0) {
            $amount *= -1;
            return '-$' . number_format($amount, 2);
        } else {
            return '$' . number_format($amount, 2);
        }
    }

}
if (!function_exists('time_elapsed_string')) {

    function time_elapsed_string($datetime, $full = false) {
        $now = new DateTime;
        $ago = new DateTime($datetime);
        $diff = $now->diff($ago);

        $diff->w = floor($diff->d / 7);
        $diff->d -= $diff->w * 7;

        $string = array(
            'y' => 'year',
            'm' => 'month',
            'w' => 'week',
            'd' => 'day',
            'h' => 'hour',
            'i' => 'minute',
            's' => 'second',
        );
        foreach ($string as $k => &$v) {
            if ($diff->$k) {
                $v = $diff->$k . ' ' . $v . ($diff->$k > 1 ? 's' : '');
            } else {
                unset($string[$k]);
            }
        }

        if (!$full)
            $string = array_slice($string, 0, 1);
        return $string ? implode(', ', $string) . ' ago' : 'just now';
    }

}

if (!function_exists('check_email_is_valid')) {

    function check_email_is_valid($email=null) {
        $valid=true;

         $blaze_settings=\App\SiteSettings::getValByName('api_blaze_settings');

        if((!empty($blaze_settings['enable_blaze_key']) && $blaze_settings['enable_blaze_key'] == 'on')){

              $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, 'https://api.blazeverify.com/v1/verify?email='.$email.'&api_key='.$blaze_settings['blaze_key']);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        $response = json_decode(curl_exec($ch));
        curl_close($ch);

         if((!empty($response->message) && $response->message=='Your account is out of credits. Please visit https://blazeverify.com/checkout/credits to purchase more.' )){
             $user_data = get_domain_user();
            send_email($user_data->email, $user_data->name, "Blaze Api Expired", $response->message);
         }

        if(!empty($response->state) && ($response->state=="deliverable" || $response->state=="risky" || (!empty($response->reason) && $response->reason=="low_quality")) || (!empty($response->message) && $response->message=='Your account is out of credits. Please visit https://blazeverify.com/checkout/credits to purchase more.' )){

        }else{
                $valid=false;
            }

            }

        return $valid;
    }
}
if (!function_exists('check_blaze_account_details')) {

    function check_blaze_account_details() {
        $valid=true;

         $blaze_settings=\App\SiteSettings::getValByName('api_blaze_settings');

        if((!empty($blaze_settings['enable_blaze_key']) && $blaze_settings['enable_blaze_key'] == 'on')){

              $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, 'https://api.emailable.com/v1/account?api_key='.$blaze_settings['blaze_key']);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        $response = json_decode(curl_exec($ch));

        return $response;
    }
}
}

if (!function_exists('mobileNumberFormat')) {

    function mobileNumberFormat($phone) {
        if($phone == ''){
            return '';
        }
        return $phone_number = "(" . substr($phone, -10, -7) . ")" . substr($phone, -7, -4) . "-" . substr($phone, -4);
        // note: making sure we have something
          if(!isset($phone[3])) { return ''; }
//         note: strip out everything but numbers
          $phone = preg_replace("/[^0-9]/", "", $phone);
          $length = strlen($phone);
          switch($length) {
          case 7:
            return preg_replace("/([0-9]{3})([0-9]{4})/", "$1-$2", $phone);
          break;
          case 10:
           return preg_replace("/([0-9]{3})([0-9]{3})([0-9]{4})/", "($1) $2-$3", $phone);
          break;
          case 11:
          return preg_replace("/([0-9]{1})([0-9]{3})([0-9]{3})([0-9]{4})/", "$1($2) $3-$4", $phone);
          break;
          default:
            return $phone;
          break;
          }
    }

}

if (!function_exists('get_aws_s3_bucket_credentials')) {

    function get_aws_s3_bucket_credentials($param=null,$private=false) {
        $res='';
        $aws_s3_settings = \App\SiteSettings::where('name', 'aws_settings')->where('user_id', Auth::user()->id)->first();
                  if(!empty($aws_s3_settings->value)){
                       $aws_s3_settings  = json_decode($aws_s3_settings->value,true);
                  }else{
                      $aws_s3_settings = '';
                  }

        switch ($param){
            case 'AWS_BUCKET':
                if($private){
                $res =$aws_s3_settings['AWS_BUCKET'] ?? '';
                }else{
                $res =$aws_s3_settings['AWS_BUCKET'] ?? env('AWS_BUCKET');
                }
                break;
            case 'AWS_DEFAULT_REGION':
                if($private){
                $res =$aws_s3_settings['AWS_DEFAULT_REGION'] ?? "";
                }else{
                $res =$aws_s3_settings['AWS_DEFAULT_REGION'] ?? env('AWS_DEFAULT_REGION');
                }
                break;
            case 'AWS_ACCESS_KEY_ID':
                if($private){
                $res =$aws_s3_settings['AWS_ACCESS_KEY_ID'] ?? "";
                }else{
                $res =$aws_s3_settings['AWS_ACCESS_KEY_ID'] ?? env('AWS_ACCESS_KEY_ID');
                }
                break;
            case 'AWS_SECRET_ACCESS_KEY':
                if($private){
                $res =$aws_s3_settings['AWS_SECRET_ACCESS_KEY'] ?? "";
                }else{
                $res =$aws_s3_settings['AWS_SECRET_ACCESS_KEY'] ?? env('AWS_SECRET_ACCESS_KEY');
                }
                break;
        }
        return $res;
    }
}


if (!function_exists('get_aws_s3_bucket_credentials_by_id')) {

    function get_aws_s3_bucket_credentials_by_id($param=null,$private=false,$user_id=false) {
        $res='';
        $aws_s3_settings = \App\SiteSettings::where('name', 'aws_settings')->where('user_id', $user_id)->first();

        if(!empty($aws_s3_settings->value)){
            $aws_s3_settings  = json_decode($aws_s3_settings->value,true);
        }else{
             $aws_s3_settings = \App\SiteSettings::where('name', 'aws_settings')->where('user_id',1)->first();
             if(!empty($aws_s3_settings->value)){
                $aws_s3_settings  = json_decode($aws_s3_settings->value,true);
             }else{
                $aws_s3_settings = array();
             }
        }

        switch ($param){
            case 'AWS_BUCKET':
                if($private){
                $res =$aws_s3_settings['AWS_BUCKET'] ?? '';
                }else{
                $res =$aws_s3_settings['AWS_BUCKET'] ?? env('AWS_BUCKET');
                }
                break;
            case 'AWS_DEFAULT_REGION':
                if($private){
                $res =$aws_s3_settings['AWS_DEFAULT_REGION'] ?? "";
                }else{
                $res =$aws_s3_settings['AWS_DEFAULT_REGION'] ?? env('AWS_DEFAULT_REGION');
                }
                break;
            case 'AWS_ACCESS_KEY_ID':
                if($private){
                $res =$aws_s3_settings['AWS_ACCESS_KEY_ID'] ?? "";
                }else{
                $res =$aws_s3_settings['AWS_ACCESS_KEY_ID'] ?? env('AWS_ACCESS_KEY_ID');
                }
                break;
            case 'AWS_SECRET_ACCESS_KEY':
                if($private){
                $res =$aws_s3_settings['AWS_SECRET_ACCESS_KEY'] ?? "";
                }else{
                $res =$aws_s3_settings['AWS_SECRET_ACCESS_KEY'] ?? env('AWS_SECRET_ACCESS_KEY');
                }
                break;
        }
        return $res;
    }
}


	if (!function_exists('getUserDetails')) {

    function getUserDetails($userid) {
        $user = new User();
        $user = $user->userInfo($userid);
        return $user;
    }

	}


	if (!function_exists('getUserLastMessage')) {

		function getUserLastMessage($userId) {
			$user_id = get_domain_id();
			$data = ChatInbox::where(['sender_id' => Auth::user()->id, 'receiver_id' => $userId ,  'group_id' => '0'])->orWhere(['sender_id' => $userId])->where([ 'receiver_id' => Auth::user()->id])->orderBy('created_at', 'DESC')->first();
			return $data;
		}

	}
	if (!function_exists('getUserUnreadMessageCount')) {

		function getUserUnreadMessageCount($userId) {
			$user_id = get_domain_id();
			$data = ChatInbox::where(['sender_id' => $userId, 'receiver_id' => Auth::user()->id, 'receiver_seen_status' => 'No'])->get();
			return count($data);
		}

	}

	if (!function_exists('getChatGroupDetails')) {

    function getChatGroupDetails($id) {
        $d = new App\ChatGroup();
        $d = $d->groupInfo($id);
        return $d;
    }

	}

	if (!function_exists('getAllOwner')) {

    function getAllOwner() {
        $data = user::where('type' , 'mentor')->get();
        return $data;
    }

	}

	if (!function_exists('getGroupMessageCount')) {

    function getGroupMessageCount($Id) {
        $user_id = get_domain_id();

		$data = ChatInbox::where(['group_id' => $Id, 'receiver_id' => Auth::user()->id, 'receiver_seen_status' => 'No'])->get();
        return count($data);
    }

}

if (!function_exists('getUserAvatarUrl')) {

    function getUserAvatarUrl($userid = 0) {
        $avatarName = 'Anonymous';
        $avatarImg = '';

        $user_data = DB::table('users')->where('id', $userid)->first();
        if ($user_data) {
            $avatarImg = $user_data->avatar;
            $avatarName = $user_data->name;
        }

        if (\Storage::exists($avatarImg) && !empty($avatarImg)) {
            return 'src=' . asset('storage/app/'.$avatarImg);
        } else {
            return 'src=' . asset('public/images/news-20.jpg');
            return 'avatar=' . $avatarName;
        }
    }


	}

	if (!function_exists('getLearnStudentStatus')) {

    function getLearnStudentStatus($lectureId) {
        $user = Auth::user();
        $lecture = Lecture::find($lectureId);
        $CertifyChapter = CertifyChapter::find($lecture->chapter);
        $checkIfExist = StudentLectureStatus::where(['student' => $user->id, 'lecture_id' => $lectureId, 'chapter_id' => $CertifyChapter->id])->first();
        if ($checkIfExist) {
            return true;
        } else {
            return false;
        }
    }
    function get_us_states() {
          $jsonString = file_get_contents(asset('public/assets/js/usa.json'));
    $data = json_decode($jsonString, true);
    $states=[];
    foreach ($data['features'] as $i=>$row){
        $states[$row['id']]=$row['properties']['name'];
    }
    return $states;
    }

}

	if (!function_exists('checkPlanModule')) {

		function checkPlanModule($module = null) {
			$authuser = Auth::user();
			$status = true;
			if ($authuser) {
				$plan = new Plan();
				$userPlan = $plan->getUserPlan($module, $authuser->id);
				if (!$userPlan['status']) {
					$status = false;
				}
			}
			return $status;
		}

	}




    // if(!function_exists('user_reward_points')){
    //     function user_reward_points($role){
    //         dd($role);
    //         $rolescheck = App\Role::whereRole($user->type)->first();
    //         $thisUser = auth()->user();
    //         if(in_array("points", json_decode($rolescheck->permissions)) == true){
    //             $points = \Ansezz\Gamify\Point::find(3);

    //             $createPoint = $thisUser->achievePoint($points);
    //             dd($thisUser->achieved_points);
    //         }

    //     }
    // }


if (!function_exists('getshopimage')) {

    function getshopimage($img = null) {
        $url = asset('storage/shop') . "/" . $img;
        $file_headers = get_headers($url);

        if (!empty($file_headers) && $file_headers[0] == "HTTP/1.1 200 OK" && !empty($img)) {
            return $url;
        } else {
            return asset('public/frontend/images/travel/2.jpg');
        }
    }

}

    if (!function_exists('jobDateFormat')) {
        function jobDateFormat($date="", $time=false){
            $jobSetting = new JobSetting;
            $dataFormat = $jobSetting->loadByKey("date_format");
            if($time){
                $timeFormat = $jobSetting->loadByKey("time_format");
                $dataFormat = $dataFormat." ".$timeFormat.":i A";
            }
            return Carbon::parse($date)->format($dataFormat);
        }
    }

    if (!function_exists('jobPriceFormat')) {
        function jobPriceFormat($price){
            $jobSetting = new JobSetting;
            $currencySymbol = $jobSetting->loadByKey("currency_symbol");
            $decimalSeparator = $jobSetting->loadByKey("decimal_separator");
            $thousandSeparator = $jobSetting->loadByKey("thousand_separator");
            $thousandSeparator = ($thousandSeparator=="space") ? " " : $thousandSeparator;
            $numberOfDecimal = (int) $jobSetting->loadByKey("number_of_decimal");
            $currencyPosition = $jobSetting->loadByKey("currency_position");
            $formattedPrice = number_format($price, $numberOfDecimal, $decimalSeparator, $thousandSeparator);
            $finalPrice = $currencySymbol.$formattedPrice;
            switch ($currencyPosition){
                case "prefix_only":
                    $finalPrice = $currencySymbol.$formattedPrice;
                    break;
                case "prefix_with_space":
                    $finalPrice = $currencySymbol." ".$formattedPrice;
                    break;
                case "suffix_only":
                    $finalPrice = $formattedPrice.$currencySymbol;
                    break;
                case "suffix_with_space":
                    $finalPrice = $formattedPrice." ".$currencySymbol;
                    break;
            }
            return $finalPrice;
        }
    }

    if (!function_exists('makeSlug')){
        function makeSlug($value)
        {
            return $slug = strtolower(trim(preg_replace('/[^A-Za-z0-9-]+/', '-', $value)));
        }
    }

    if (!function_exists('formlabel')){
        function formlabel($value)
        {
            return $slug = ucwords(strtolower($value));
        }
    }
