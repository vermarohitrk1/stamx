<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Auth;

class Contacts extends Model
{
    protected $table = 'contacts';
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
     public function getAvatarUrl()
    {
             if(file_exists(storage_path().'/contact/'.$this->avatar) && !empty($this->avatar)){
            return asset(\Storage::url('contact/'.$this->avatar));
        } else {
            return asset('assets/img/user/user.jpg');
        }
    }

    public function getconnections($all){
         $user = Auth::user();
         if($all == 'all'){
            $Newconnect = self::where(['user_id'=>$user->id])->paginate(5); 
         }
         return $Newconnect;
    }
    public static function get_google_sync_url(){
//         require_once __DIR__ . '/../vendor/google-api-php-client/src/Google/autoload.php'; // or wherever autoload.php is located
        //Declare your Google Client ID, Google Client secret and Google redirect uri in  php variables
         
         
        $sync_settings =  \App\User::ContactsSyncSettings(); 
        $google_client_id = !empty($sync_settings['google_client_id']) ? $sync_settings['google_client_id'] :''; // paste your client id here
        $google_client_secret = !empty($sync_settings['google_client_secret']) ? $sync_settings['google_client_secret'] :''; // paste your client secret here
        $google_redirect_uri = !empty($sync_settings['google_redirect_url']) ? $sync_settings['google_redirect_url'] :''; // paste your redirect url here
      
        if(empty($google_client_id) || empty($google_client_secret)){
            return 'https://'.$_SERVER['SERVER_NAME'].'/contacts/sync/google';
        }else{
        //setup new google client
//        $client = new \Google_Client();
//        $client->setApplicationName('softsolex');
//        $client->setClientid($google_client_id);
//        $client->setClientSecret($google_client_secret);
//        $client->setRedirectUri($google_redirect_uri);
//        $client->setAccessType('online');
//        $client->setScopes('https://www.google.com/m8/feeds');
//        $googleImportUrl = $client->createAuthUrl();
            $googleImportUrl='https://accounts.google.com/o/oauth2/auth?response_type=code&redirect_uri='.$google_redirect_uri.'&client_id='.$google_client_id.'&scope=https%3A%2F%2Fwww.google.com%2Fm8%2Ffeeds&access_type=online&approval_prompt=auto';
         return $googleImportUrl;
        }
    }
    public static function get_outlook_sync_url(){
        
        $sync_settings =  \App\User::ContactsSyncSettings(); 
        $outlook_client_id = !empty($sync_settings['outlook_client_id']) ? $sync_settings['outlook_client_id'] :''; // paste your client id here
        $outlook_client_secret = !empty($sync_settings['outlook_client_secret']) ? $sync_settings['outlook_client_secret'] :''; // paste your client secret here
        $outlook_redirect_uri = !empty($sync_settings['outlook_redirect_url']) ? $sync_settings['outlook_redirect_url'] :''; // paste your redirect url here
      
        if(empty($outlook_client_id) || empty($outlook_client_secret)){
            return 'https://'.$_SERVER['SERVER_NAME'].'/contacts/sync/outlook';
        }else{
        //setup new outlook client
            $outlookImportUrl='https://login.microsoftonline.com/common/oauth2/v2.0/authorize?state=fsdfserwrsdgs&scope=Contacts.Read&response_type=code&approval_prompt=auto&client_id='.$outlook_client_id.'&redirect_uri='.$outlook_redirect_uri;
                    
         return $outlookImportUrl;
        }
    }
    public static function get_yahoo_sync_url(){
        
        $sync_settings =  \App\User::ContactsSyncSettings(); 
        $yahoo_client_id = !empty($sync_settings['yahoo_client_id']) ? $sync_settings['yahoo_client_id'] :''; // paste your client id here
        $yahoo_client_secret = !empty($sync_settings['yahoo_client_secret']) ? $sync_settings['yahoo_client_secret'] :''; // paste your client secret here
        $yahoo_redirect_uri = !empty($sync_settings['yahoo_redirect_url']) ? $sync_settings['yahoo_redirect_url'] :''; // paste your redirect url here
      
        if(empty($yahoo_client_id) || empty($yahoo_client_secret)){
            return 'https://'.$_SERVER['SERVER_NAME'].'/contacts/sync/yahoo';
        }else{
        //setup new yahoo client
            $yahooImportUrl='https://api.login.yahoo.com/oauth2/request_auth?client_id='.$yahoo_client_id.'&redirect_uri='.$yahoo_redirect_uri.'&response_type=code&language=en-us';
                    
         return $yahooImportUrl;
        }
    }
    
     public static function create_contact($data=array(),$foldername=null){
         $response=[
           'status'=>false,  
           'message'=>'',  
         ];
         if(!empty($data) && !empty($foldername)){
         $domain_id = get_domain_id();
            $domain_user = get_domain_user();
            $user_id = $domain_user->id ?? 0;
            //Folder
            $folder = \App\ContactFolder::where("user_id", $user_id)->where("name", $foldername)->first();
            if (empty($folder)) {
                $values = array('name' => $foldername, 'user_id' => $user_id, 'domain_id' => $domain_id);
                $folder=\App\ContactFolder::create($values);
            }
            $newconnect = \App\Contacts::where("user_id", $user_id)->where("email", $data['email'])->first();
            if (empty($newconnect)) {
                $values_data = array(
                    'folder' => $folder->id,
                    'user_id' => $user_id,
                    'domain_id' => $domain_id,
                    'email' => $data['email']??'',
                    'phone' => $data['phone']??'',
                    'fullname' => $data['name']??'',
                    'fname' => $data['fname']??'',
                    'lname' => $data['lname']??'',
                    'email_subscription' => json_encode($folder->id),
                    'sms_subscription' => json_encode($folder->id),
                );
                $folder_id = \App\Contacts::create($values_data)->id;
                $newconnect = \App\Contacts::where("user_id", $user_id)->where("email", $data['email'])->first();
                $response=[
           'status'=>true,  
           'message'=>'successfully added',  
           'data'=>$newconnect,  
         ];
            }else{               
                
                  $response=[
           'status'=>true,  
           'message'=>'contact already exist',  
         ];
            }
         }else{
             $response=[
           'status'=>false,  
           'message'=>'missing parameters',  
         ];
         }
         return $response;
     }
}
