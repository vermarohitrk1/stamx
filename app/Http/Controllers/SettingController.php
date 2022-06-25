<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Filesystem\Filesystem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Schema;
use App\SiteSettings;
use App\Menu;
use App\Cpanel\Cpanel;
use App\Page;
use App\Utility;
use Illuminate\Support\Facades\Mail;
use App\Mail\EmailTest;
use GuzzleHttp\Client;
class SettingController extends Controller {

    //user site settings
    public function site_settings() {


        $user = Auth::user();
        $twilio_balance='';
         try {
          $twilio_settings=\App\SiteSettings::getValByName('twilio_key');
        $accountSid = $twilio_settings['twilio_account_sid']??"";
        $authToken = $twilio_settings['twilio_auth_token']??"";
        $client = new Client();
        $endpoint = "https://api.twilio.com/2010-04-01/Accounts/$accountSid/Balance.json";
        $response = $client->get($endpoint, [
   'auth' => [
       $accountSid,
       $authToken
   ]
]);
        $response= $response->getBody();
        $response=!empty($response) ? json_decode($response) :'';
        $twilio_balance= !empty($response->balance) ?  $response->balance.' ('.$response->currency.')' :'';

        } catch (\Exception $e) {

                    }




        if ($user->type == "admin") {
            	$menus = Menu::where('parent_id', '=', 0)->where('user_id', auth()->user()->id)->orderBy('orders', 'asc')->get();
            	$allMenus = Menu::where('user_id', auth()->user()->id)->orderBy('orders', 'asc')->get();
				$footerWidget1 = SiteSettings::where('name', 'footer_widget_1')->where('user_id', auth()->user()->id)->first();
				 $routes = [
            // write - as _
            // privacy-policy as privacy_policy
            // 'route' => "Route Name"
            '/' => "Home",
            'books' => "Book",

        ];
					$pages = Page::where('user_id','=',auth()->user()->id)->get();
        if (!$footerWidget1) {
            $footerWidget1 = SiteSettings::where('name', 'footer_widget_1')->where('user_id', auth()->user()->id)->first();
        }
        $footerWidget1 = $footerWidget1 ? (array) json_decode($footerWidget1->value) : null;
        $footerWidget2 = SiteSettings::where('name', 'footer_widget_2')->where('user_id', auth()->user()->id)->first();
        if (!$footerWidget2) {
            $footerWidget2 = SiteSettings::where('name', 'footer_widget_2')->where('user_id', auth()->user()->id)->first();
        }
        $footerWidget2 = $footerWidget2 ? (array) json_decode($footerWidget2->value) : null;

		$UserSettings = SiteSettings::where(['user_id' => $user->id, 'name' => 'favicon'])->first();
            if (isset($UserSettings->id)) {
                $detail = json_decode($UserSettings->value, true);
            } else {
                $detail = array('logo' => '', 'favicon' => '', 'logo_dark' => '' ,'');
            }
            $logo = $detail;
			$footer_text = SiteSettings::where(['user_id' => $user->id, 'name' => 'footer_text'])->first();
			if (isset($footer_text->id)) {
             $footerdata=$footer_text->value;
            } else {
             $footerdata = '';
            }

			$logo_text = SiteSettings::where(['user_id' => $user->id, 'name' => 'logo_text'])->first();
			if (isset($logo_text->id)) {
             $logo_textdata=$logo_text->value;
            } else {
             $logo_textdata = '';
            }
            $twoFa = SiteSettings::select('value')->where('user_id', $user->id)->where('name','twoFa')->first();
            if ($twoFa) {
                $twoFa=(INT) $twoFa->value;
               } else {
                $twoFa = 0;
               }

		$speech_key = SiteSettings::select('value','updated_at')->where('name','speech_key')->first();
		$speech_region = SiteSettings::select('value')->where('name','speech_region')->first();
		$speech_voice = SiteSettings::select('value')->where('name','speech_voice')->where('user_id',Auth::user()->id)->first();
		$bot_twilio_voice = SiteSettings::select('value')->where('name','bot_twilio_voice')->where('user_id',Auth::user()->id)->first();
		$default_answer = SiteSettings::select('value')->where('name','default_answer')->where('user_id',Auth::user()->id)->first();
		$greetings = SiteSettings::select('value')->where('name','greetings')->where('user_id',Auth::user()->id)->first();
		$robot_img = SiteSettings::select('value')->where('name','robot_img')->where('user_id',Auth::user()->id)->first();
		$bot_name = SiteSettings::select('value')->where('name','bot_name')->where('user_id',Auth::user()->id)->first();
		$speech_key_expiration_date =!empty($speech_key->updated_at) ? date('Y-m-d',strtotime('+30 days',strtotime($speech_key->updated_at))):'';
		$wiki_search = SiteSettings::select('value')->where('name','wiki_search')->where('user_id',Auth::user()->id)->first();
		$wake_word = SiteSettings::select('value')->where('name','wake_word')->where('user_id',Auth::user()->id)->first();
		$wiki_key = SiteSettings::select('value','updated_at')->where('name','wiki_key')->first();
		 $twilio_key = SiteSettings::select('value')->where('name','twilio_key')->where('user_id',Auth::user()->id)->first();


         if(!empty($wiki_key)){
                    $wiki_key_expiration_date = date('Y-m-d',strtotime('+30 days',strtotime($wiki_key->updated_at)));

                    $today_date = date('Y-m-d');
                    if(strtotime($speech_key_expiration_date) > strtotime($today_date)){
                        $disabled = 1;
                    }else{
                        $disabled = 0;
                    }

                    if(strtotime($wiki_key_expiration_date) > strtotime($today_date)){
                        $disabled1 = 1;
                    }else{
                        $disabled1 = 0;
                    }
                }else{
                    $wiki_key = array();
                    $disabled1 = 0;
                    $disabled = 0;
                    $wiki_key_expiration_date = "";
                }

            return view('admin.site_settings',compact('twilio_balance','speech_voice','bot_twilio_voice','default_answer','greetings','robot_img','bot_name','wiki_search','wake_word','pages','user','menus','allMenus','footerWidget1','footerWidget2','routes','logo','footerdata','wiki_key_expiration_date','wiki_key','speech_key','speech_region','twilio_key','logo_textdata','twoFa'));

        } else {

				$menus = Menu::where('parent_id', '=', 0)->where('user_id', auth()->user()->id)->orderBy('orders', 'asc')->get();
            	$allMenus = Menu::where('user_id', auth()->user()->id)->orderBy('orders', 'asc')->get();
				$footerWidget1 = SiteSettings::where('name', 'footer_widget_1')->where('user_id', auth()->user()->id)->first();
				 $routes = [
            // write - as _
            // privacy-policy as privacy_policy
            // 'route' => "Route Name"
            '/' => "Home",
            'books' => "Book",

				];
			$pages = Page::where('user_id','=',auth()->user()->id)->get();
			 if (!$footerWidget1) {
            $footerWidget1 = SiteSettings::where('name', 'footer_widget_1')->where('user_id', auth()->user()->id)->first();
        }
        $footerWidget1 = $footerWidget1 ? (array) json_decode($footerWidget1->value) : null;
        $footerWidget2 = SiteSettings::where('name', 'footer_widget_2')->where('user_id', auth()->user()->id)->first();
        if (!$footerWidget2) {
            $footerWidget2 = SiteSettings::where('name', 'footer_widget_2')->where('user_id', auth()->user()->id)->first();
        }
        $footerWidget2 = $footerWidget2 ? (array) json_decode($footerWidget2->value) : null;

			 $basic_settings =\App\SiteSettings::where('name','favicon')->where('user_id',Auth::user()->id)->first();
            if (isset($basic_settings->id)) {
                $detail = json_decode($basic_settings->value, true);
            } else {
                $detail = array('logo' => '', 'favicon' => '', 'logo_dark' => '' ,'');
            }
            $logo = $detail;
			$footer_text = SiteSettings::where(['user_id' => $user->id, 'name' => 'footer_text'])->first();
			if (isset($footer_text->id)) {
             $footerdata=$footer_text->value;
            } else {
             $footerdata = '';
            }


            $twoFa = SiteSettings::select('value')->where('user_id', Auth::user()->id)->where('name','twoFa')->first();
            if ($twoFa) {
                $twoFa=(INT) $twoFa->value;
               } else {
                $twoFa = 0;
               }
               $aws_settings = SiteSettings::select('value')->where('name','aws_settings')->where('user_id',Auth::user()->id)->first();

            return view('user.site-settings', compact(['twilio_balance','user','basic_settings','twoFa','aws_settings','pages','menus','allMenus','footerWidget1','footerWidget2','routes','logo','footerdata',]));
        }
    }

    //user site settings store
    public function site_settings_store(Request $request) {
       // dd($request);

        $usr = Auth::user();
        $domain_id= get_domain_id();

        $validate = [];
				 if ($request->from == 'Cloudinary') {


			  if (isset($request->CLOUDINARY_URL) && $request->CLOUDINARY_URL != '') {
				$arrEnv = [
				'CLOUDINARY_URL' => $request->CLOUDINARY_URL
				];
			  }
			  else{
				  $arrEnv = [
				'CLOUDINARY_URL' => ''
				];
			  }
                           $arrEnv = [
				'CLOUDINARY_STATUS' => $request->CLOUDINARY_STATUS??''
				];
                           $arrEnv = [
				'MTOWNSEND_STATUS' => $request->MTOWNSEND_STATUS??''
				];
                           $arrEnv = [
				'MTOWNSEND_KEY' => $request->MTOWNSEND_KEY??''
				];

                $env = Utility::setEnvironmentValue($arrEnv);

                if ($env) {
                    return redirect()->back()->with('success', __('Cloudinary/MTOWNSEND setting updated successfully.'));
                } else {
                    return redirect()->back()->with('error', __('Something is wrong'));
                }

  } elseif($request->from == 'WHM_Settings') {
      $arrEnv = array();

            if (isset($request->CPANEL_HOST) && $request->CPANEL_HOST != '') {
                $arrEnv['CPANEL_HOST'] = $request->CPANEL_HOST;
            }else{

                  $arrEnv['CPANEL_HOST']= '';

            }

            if (isset($request->WHM_USER_NAME) && $request->WHM_USER_NAME != '') {
                $arrEnv['WHM_USER_NAME'] = $request->WHM_USER_NAME;
            }else{

                $arrEnv['WHM_USER_NAME'] = '';

            }

            if (isset($request->CPANEL_USER_NAME) && $request->CPANEL_USER_NAME != '') {
                $arrEnv['CPANEL_USER_NAME'] = $request->CPANEL_USER_NAME;
            }else{
                $arrEnv['CPANEL_USER_NAME'] ='';
            }

            if (isset($request->CPANEL_AUTH_TYPE) && $request->CPANEL_AUTH_TYPE != '') {
               $arrEnv['CPANEL_AUTH_TYPE'] = $request->CPANEL_AUTH_TYPE;
            }else{
               $arrEnv['CPANEL_AUTH_TYPE'] ='';
            }

            if (isset($request->WHM_SERVER_IP) && $request->WHM_SERVER_IP != '') {
                $arrEnv['WHM_SERVER_IP'] = $request->WHM_SERVER_IP;
            }else{
                 $arrEnv['WHM_SERVER_IP'] = '';
            }

            if (isset($request->WHM_PASSWORD) && $request->WHM_PASSWORD != '') {
                $arrEnv['WHM_PASSWORD'] = $request->WHM_PASSWORD;
            }else{
                 $arrEnv['WHM_PASSWORD'] = '';
            }

                $env = Utility::setEnvironmentValue($arrEnv);

                if ($env) {
                    return redirect()->back()->with('success', __('WHM setting updated successfully.'));
                } else {
                    return redirect()->back()->with('error', __('Something is wrong'));
                }

    } elseif($request->from == 'awss3') {
        $arrEnv  = array();
        $arrEnv = [
            'AWS_BUCKET' => $request->aws_bucket,
            'AWS_DEFAULT_REGION' => $request->aws_region,
            'AWS_ACCESS_KEY_ID' => $request->aws_key_id,
            'AWS_SECRET_ACCESS_KEY' => $request->aws_secret_key
        ];
        $checkaws = SiteSettings::where('name', 'aws_settings')->where('user_id', $usr->id)->first();

        if(!empty($checkaws)){
            $query=SiteSettings::where('name', 'aws_settings')->where('user_id', $usr->id)->update(array('value' => json_encode($arrEnv)));
        }else{
            $query= SiteSettings::insert(array('value' => json_encode($arrEnv), 'name' => 'aws_settings',"user_domain_id"=>$domain_id, 'user_id' => $usr->id));
        }

        return redirect()->back()->with('success', __('AWS Setting updated.'));

    } elseif($request->from == 'commission') {
        $arrEnv  = array();
        if (isset($request->ADMIN_COMMISSION) && $request->ADMIN_COMMISSION != '') {
            $arrEnv['ADMIN_COMMISSION'] = $request->ADMIN_COMMISSION;
        }else{
            $arrEnv['ADMIN_COMMISSION'] ='';
        }
		if (isset($request->COMMISSION_STATUS) && $request->COMMISSION_STATUS != '') {
            $arrEnv['COMMISSION_STATUS'] = $request->COMMISSION_STATUS;
        }else{
            $arrEnv['COMMISSION_STATUS'] ='';
        }


        if (isset($request->PROMOTER_COMMISSION) && $request->PROMOTER_COMMISSION != '') {
            $arrEnv['PROMOTER_COMMISSION'] = $request->PROMOTER_COMMISSION;
        }else{
            $arrEnv['PROMOTER_COMMISSION'] = '';
        }
        if (isset($request->RESELLER_COMMISSION) && $request->RESELLER_COMMISSION != '') {
            $arrEnv['RESELLER_COMMISSION'] = $request->RESELLER_COMMISSION;
        }else{
            $arrEnv['RESELLER_COMMISSION'] = '';
        }
        $env = Utility::setEnvironmentValue($arrEnv);
        if($env) {
            return redirect()->back()->with('success', __('commission updated successfully.'));
        }else{
            return redirect()->back()->with('error', __('Something is wrong'));
        }


    } elseif($request->from == 'WHMCS_settings') {
        $arrEnv = array();
          if (isset($request->WHMCS_API_URL) && $request->WHMCS_API_URL != '') {
                $arrEnv['WHMCS_API_URL'] = $request->WHMCS_API_URL;
            }else{

                  $arrEnv['WHMCS_API_URL']= '';

            }

            if (isset($request->WHMCS_IDENTIFIER) && $request->WHMCS_IDENTIFIER != '') {
                $arrEnv['WHMCS_IDENTIFIER'] = $request->WHMCS_IDENTIFIER;
            }else{

                $arrEnv['WHMCS_IDENTIFIER'] = '';

            }

            if (isset($request->WHMCS_SECRET) && $request->WHMCS_SECRET != '') {
                $arrEnv['WHMCS_SECRET'] = $request->WHMCS_SECRET;
            }else{
                $arrEnv['WHMCS_SECRET'] ='';
            }

            if (isset($request->WHMCS_AUTO_LOGIN_URL) && $request->WHMCS_AUTO_LOGIN_URL != '') {
               $arrEnv['WHMCS_AUTO_LOGIN_URL'] = $request->WHMCS_AUTO_LOGIN_URL;
            }else{
               $arrEnv['WHMCS_AUTO_LOGIN_URL'] ='';
            }

            if (isset($request->AUTO_AUTH_KEY) && $request->AUTO_AUTH_KEY != '') {
                $arrEnv['AUTO_AUTH_KEY'] = $request->AUTO_AUTH_KEY;
            }else{
                 $arrEnv['AUTO_AUTH_KEY'] = '';
            }

            if (isset($request->GO_TO_URL) && $request->GO_TO_URL != '') {
                $arrEnv['GO_TO_URL'] = $request->GO_TO_URL;
            }else{
                 $arrEnv['GO_TO_URL'] = '';
            }

            if (isset($request->API_ACCESS_KEY) && $request->API_ACCESS_KEY != '') {
                $arrEnv['API_ACCESS_KEY'] = $request->API_ACCESS_KEY;
            }else{
                 $arrEnv['API_ACCESS_KEY'] = '';
            }


                $env = Utility::setEnvironmentValue($arrEnv);

                if ($env) {
                    return redirect()->back()->with('success', __('WHMCS setting updated successfully.'));
                } else {
                    return redirect()->back()->with('error', __('Something is wrong'));
                }


 }


	elseif ($request->from == 'verifycert') {


                if (!empty($request->hasFile('CERTIFICATE_MP3'))) {
                    $fileNameToStore = time() . '.' . $request->CERTIFICATE_MP3->getClientOriginalExtension();
                    $video = $request->file('CERTIFICATE_MP3')->storeAs('twillio', Str::random(20) . $fileNameToStore);
                } else {
                    $video = env('CERTIFICATE_MP3');
                }

                $arrEnv = [
                    'CERTI_TWILIO_SID' => $request->CERTI_TWILIO_SID,
                    'CERTIFICATE_TWILIO_NUMBER' => $request->CERTIFICATE_TWILIO_NUMBER,
                    'CERTIFICATE_MESSAGE_TYPE' => $request->CERTIFICATE_MESSAGE_TYPE,
                    'CERTIFICATE_TTS' => $request->CERTIFICATE_TTS,
                    'CERTIFICATE_MP3' => $video,
                ];

                $env = Utility::setEnvironmentValue($arrEnv);

                if ($env) {
                    return redirect()->back()->with('success', __('Certificate Setting Changes updated successfully'));
                } else {
                    return redirect()->back()->with('error', __('Something is wrong'));
                }
            }
        elseif ($request->from == 'mailer') {

            $validate = [
                'mail_driver' => 'required|string|max:50',
                'mail_host' => 'required|string|max:50',
                'mail_port' => 'required|string|max:50',
                'mail_username' => 'required|string|max:50',
                'mail_password' => 'required|string|max:50',
                'mail_from_address' => 'required|string|max:50',
                'mail_from_name' => 'required|string|max:50',
                'mail_encryption' => 'required|string|max:50',
            ];

            $arrEnv = [
                'MAIL_DEFAULT' => $request->mail_default,
                'MAIL_DRIVER' => $request->mail_driver,
                'MAIL_HOST' => $request->mail_host,
                'MAIL_PORT' => $request->mail_port,
                'MAIL_USERNAME' => $request->mail_username,
                'MAIL_PASSWORD' => $request->mail_password,
                'MAIL_ENCRYPTION' => $request->mail_encryption,
                'MAIL_FROM_ADDRESS' => $request->mail_from_address,
                'MAIL_FROM_NAME' => $request->mail_from_name,
            ];
             $setting = \App\SiteSettings::where("name", 'mailer_settings')->where('user_id', $usr->id)->first();
            if (!empty($setting->value) && !empty(json_decode($setting->value))) {
                $mailer_setting = json_decode($setting->value, true);
            } elseif (!empty($setting->value)) {
                $mailer_setting = $setting->value;
            }

            if (!empty($mailer_setting)) {
                if(!empty($mailer_setting['MAIL_DRIVER'])){
                   $temarray=array();
                   $temarray=$mailer_setting;
                   $mailer_setting=array();
                     $mailer_setting[1]=$temarray;
                     if(!empty($arrEnv)){
                     $mailer_setting[sizeof($temarray)+1]=$arrEnv;
                     }

                }else{
                if(!empty($request->mailer_id)){
                    $mailer_setting[$request->mailer_id]=$arrEnv;
                }else{
                    $mailer_setting[sizeof($mailer_setting)+1]=$arrEnv;
                }
                }

                $query=SiteSettings::where('name', 'mailer_settings')->where('user_id', $usr->id)->update(array('value' => json_encode($mailer_setting),"user_domain_id"=>$domain_id));

            } else {
                $array_store=array();
                $array_store[1]=$arrEnv;
                $query= SiteSettings::insert(array('value' => json_encode($array_store), 'name' => 'mailer_settings',"user_domain_id"=>$domain_id, 'user_id' => $usr->id));
            }


            if ($query) {
                return redirect()->back()->with('success', __('Mailer Setting updated successfully'));
            } else {
                return redirect()->back()->with('error', __('Something is wrong'));
            }

        } elseif ($request->from == 'domain') {
            $validate = [
                'custom_url' => 'required|string|max:20',
            ];

             $account = \App\UserDomain::where("custom_url", $request->custom_url)->where("user_id", "!=", $usr->id)->first();
            if (!empty($account)) {
                return redirect()->back()->with('error', __("The subdomain https://" . $request->custom_url . ".".env('MAIN_URL')."is taken.."));
            }
            $domain_account = \App\UserDomain::where("custom_url", $request->custom_url)->where("user_id", "!=", $usr->id)->first();
            if (!empty($domain_account)) {
                return redirect()->back()->with('error', __("The Domain https://" . $request->domain ."is taken.."));
            }

            $subdomain=\App\UserDomain::where("user_id", "=", $usr->id)->first();
            if (!empty($subdomain)) {
                $subdomain->custom_url=$request->custom_url;
                  if(!empty($request->domain)){
                        $subdomain->domain = $request->domain;
                        $data = array();
                        $data['host'] = env('CPANEL_HOST');
                        $data['auth_type'] = env('CPANEL_AUTH_TYPE');
                        $data['password'] = env('WHM_PASSWORD');
                        $data['username'] = env('WHM_USER_NAME');
                        $cpanel = new Cpanel($data);
                        $options = array(
                           'dir'            => '/home/'.env("CPANEL_USER_NAME").'/public_html',
                           'newdomain'      => $request->domain,
                           'subdomain'      => $request->custom_url,
                        );
                        $result = $cpanel->api2('AddonDomain','addaddondomain',env('CPANEL_USER_NAME'),$options);
                        $error_check = json_decode($result,true);
                        if(!empty($error_check['cpanelresult']['error'])){
                            return redirect()->back()->with('error', $error_check['cpanelresult']['error']);
                        }
                }else{
                    $subdomain->domain ='';
                }

                $subdomain->update();
                   $mainurl = explode('.',$_SERVER['HTTP_HOST']);
                    if(count($mainurl)==3){
                        $main_url = $mainurl[1];
                        $domain = $mainurl[1].'.'.$mainurl[2];
                    }else{
                        $main_url = $mainurl[0];
                        $domain =!empty($mainurl[1]) ? $mainurl[0].'.'.$mainurl[1] :$mainurl[0];
                    }
                    if(env('MAIN_URL') == $domain){
                        if($request->custom_url.'.'.$domain   == request()->getHost()){
                            return redirect()->back()->with('success', __('Domain Updated Successfully!'));
                        }else{
                            return redirect()->away('//' . $request->custom_url . '.' . $domain.'/home');
                        }
                    }else{
                        return redirect()->away('//' . $request->domain.'/home');
                    }
           } else {

                $data_domain = array();
                $data_domain['custom_url'] = $request->custom_url;
                if(!empty($request->domain)){
                     $data_domain['domain'] = $request->domain;
                       $data = array();
                        $data['host'] = env('CPANEL_HOST');
                        $data['auth_type'] = env('CPANEL_AUTH_TYPE');
                        $data['password'] = env('WHM_PASSWORD');
                        $data['username'] = env('WHM_USER_NAME');
                        $cpanel = new Cpanel($data);
                        $options = array(
                           'dir'            => '/home/'.env("CPANEL_USER_NAME").'/public_html',
                           'newdomain'      => $request->domain,
                           'subdomain'      => $request->custom_url,
                        );
                        $result = $cpanel->api2('AddonDomain','addaddondomain',env('CPANEL_USER_NAME'),$options);
                        $error_check = json_decode($result,true);
                        if(!empty($error_check['cpanelresult']['error'])){
                            return redirect()->back()->with('error', $error_check['cpanelresult']['error']);
                        }
                }else{
                    $data_domain['domain'] = '';
                }

                $data_domain['user_id'] = $usr->id;

                $query= \App\UserDomain::insert($data_domain);

                $mainurl = explode('.',$_SERVER['HTTP_HOST']);
                if(count($mainurl)==3){
                    $main_url = $mainurl[1];
                    $domain = $mainurl[1].'.'.$mainurl[2];
                }else{
                    $main_url = $mainurl[0];
                    $domain =!empty($mainurl[1]) ? $mainurl[0].'.'.$mainurl[1] :$mainurl[0];
                }
                if(env('MAIN_URL') == $domain){
                    if($request->custom_url.'.'.$domain   == request()->getHost()){
                        return redirect()->back()->with('success', __('Domain Updated Successfully!'));
                    }else{
                        return redirect()->away('//' . $request->custom_url . '.' . $domain.'/home');
                    }
                }else{
                    return redirect()->away('//' . $request->domain.'/home');
                }
            }


        } elseif ($request->from == 'pathwaybot') {



            $arrEnv = $request->data;
            $arrEnv['ENABLE_BOT']=$request->enable_pathway_bot;

             if (SiteSettings::where('name', 'pathways_bot')->where('user_id', $usr->id)->count() > 0) {
                $query=SiteSettings::where('name', 'pathways_bot')->where('user_id', $usr->id)->update(array('value' => json_encode($arrEnv),"user_domain_id"=>$domain_id));
            } else {
                $query= SiteSettings::insert(array('value' => json_encode($arrEnv), 'name' => 'pathways_bot',"user_domain_id"=>$domain_id, 'user_id' => $usr->id));
            }

            if ($query) {
                return redirect()->back()->with('success', __('Pathways Bot Setting updated'));
            } else {
                return redirect()->back()->with('error', __('Something is wrong'));
            }
        } elseif ($request->from == 'pathwaysettings') {



            $arrEnv = $request->data;
            $arrEnv['ENABLE_DOLLAR_VALUE']=$request->enable_pathway_dollar_value;

             if (SiteSettings::where('name', 'pathways_dollar_value')->where('user_id', $usr->id)->count() > 0) {
                $query=SiteSettings::where('name', 'pathways_dollar_value')->where('user_id', $usr->id)->update(array('value' => json_encode($arrEnv),"user_domain_id"=>$domain_id));
            } else {
                $query= SiteSettings::insert(array('value' => json_encode($arrEnv), 'name' => 'pathways_dollar_value',"user_domain_id"=>$domain_id, 'user_id' => $usr->id));
            }

            if ($query) {
                return redirect()->back()->with('success', __('Pathways Settings updated'));
            } else {
                return redirect()->back()->with('error', __('Something is wrong'));
            }
        } elseif ($request->from == 'payment') {

            $validate = [
                'currency' => 'required|max:3',
                'currency_code' => 'required|string|max:5',
            ];

            if (isset($request->enable_stripe) && $request->enable_stripe = 'on') {
                $validate['stripe_key'] = 'required|string';
                $validate['stripe_secret'] = 'required|string';
            }

            if (isset($request->enable_paypal) && $request->enable_paypal = 'on') {
                $validate['paypal_client_id'] = 'required|string';
                $validate['paypal_secret_key'] = 'required|string';
            }



            $arrEnv = [
                'CURRENCY' => 132,
                'CURRENCY_CODE' => $request->currency_code,
            ];

            if (isset($request->enable_stripe) && $request->enable_stripe = 'on') {
                $arrEnv['ENABLE_STRIPE'] = $request->enable_stripe;
                $arrEnv['STRIPE_KEY'] = $request->stripe_key;
                $arrEnv['STRIPE_SECRET'] = $request->stripe_secret;
            } else {
                $arrEnv['ENABLE_STRIPE'] = 'off';
            }

            if (isset($request->enable_paypal) && $request->enable_paypal = 'on') {
                $arrEnv['ENABLE_PAYPAL'] = $request->enable_paypal;
                $arrEnv['PAYPAL_MODE'] = $request->paypal_mode;
                $arrEnv['PAYPAL_CLIENT_ID'] = $request->paypal_client_id;
                $arrEnv['PAYPAL_SECRET_KEY'] = $request->paypal_secret_key;
            } else {
                $arrEnv['ENABLE_PAYPAL'] = 'off';
            }
             if (SiteSettings::where('name', 'payment_settings')->where('user_id', $usr->id)->count() > 0) {
                $query=SiteSettings::where('name', 'payment_settings')->where('user_id', $usr->id)->update(array('value' => json_encode($arrEnv),"user_domain_id"=>$domain_id));
            } else {
                $query= SiteSettings::insert(array('value' => json_encode($arrEnv), 'name' => 'payment_settings',"user_domain_id"=>$domain_id, 'user_id' => $usr->id));
            }

            if ($query) {
                return redirect()->back()->with('success', __('Payment Setting updated'));
            } else {
                return redirect()->back()->with('error', __('Something is wrong'));
            }
        } elseif ($request->from == 'frontend_profiles') {

              $validator = \Validator::make(
                            $request->all(), [
                        'frontend_profiles' => 'required',
                            ]
            );
            if ($validator->fails()) {
                $messages = $validator->getMessageBag();

                return redirect()->back()->with('error', $messages->first());
            }
            $arrEnv=[];
           $arrEnv = $request->all();
           unset($arrEnv['_token']);
           unset($arrEnv['from']);
             if (SiteSettings::where('name', 'frontend_profiles')->where('user_id', $usr->id)->count() > 0) {
                $query=SiteSettings::where('name', 'frontend_profiles')->where('user_id', $usr->id)->update(array('value' => json_encode($arrEnv)));
            } else {
                $query= SiteSettings::insert(array('value' => json_encode($arrEnv), 'name' => 'frontend_profiles',"user_domain_id"=>$domain_id, 'user_id' => $usr->id));
            }

            if ($query) {
                return redirect()->back()->with('success', __('Frontend Settings updated'));
            } else {
                return redirect()->back()->with('error', __('Something is wrong'));
            }
        } elseif ($request->from == 'blaze') {

              $validator = \Validator::make(
                            $request->all(), [
                        'blaze_key' => 'required',
                            ]
            );
            if ($validator->fails()) {
                $messages = $validator->getMessageBag();

                return redirect()->back()->with('error', $messages->first());
            }

           $arrEnv['blaze_key'] = $request->blaze_key;
            if (isset($request->enable_blaze_key) && $request->enable_blaze_key == 'on') {
                $arrEnv['enable_blaze_key'] = $request->enable_blaze_key;
            } else {
                $arrEnv['enable_blaze_key'] = 'off';
            }

             if (SiteSettings::where('name', 'api_blaze_settings')->where('user_id', $usr->id)->count() > 0) {
                $query=SiteSettings::where('name', 'api_blaze_settings')->where('user_id', $usr->id)->update(array('value' => json_encode($arrEnv)));
            } else {
                $query= SiteSettings::insert(array('value' => json_encode($arrEnv), 'name' => 'api_blaze_settings',"user_domain_id"=>$domain_id, 'user_id' => $usr->id));
            }

            if ($query) {
                return redirect()->back()->with('success', __('Blaze Settings updated'));
            } else {
                return redirect()->back()->with('error', __('Something is wrong'));
            }
        } elseif ($request->from == 'googlemap') {

              $validator = \Validator::make(
                            $request->all(), [
                        'google_map_key' => 'required',
                            ]
            );
            if ($validator->fails()) {
                $messages = $validator->getMessageBag();

                return redirect()->back()->with('error', $messages->first());
            }

           $arrEnv['google_map_key'] = $request->google_map_key;
            if (isset($request->enable_google_map_key) && $request->enable_google_map_key == 'on') {
                $arrEnv['enable_google_map_key'] = $request->enable_google_map_key;
            } else {
                $arrEnv['enable_google_map_key'] = 'off';
            }

             if (SiteSettings::where('name', 'api_google_map_settings')->where('user_id', $usr->id)->count() > 0) {
                $query=SiteSettings::where('name', 'api_google_map_settings')->where('user_id', $usr->id)->update(array('value' => json_encode($arrEnv)));
            } else {
                $query= SiteSettings::insert(array('value' => json_encode($arrEnv), 'name' => 'api_google_map_settings',"user_domain_id"=>$domain_id, 'user_id' => $usr->id));
            }

            if ($query) {
                return redirect()->back()->with('success', __('Google Map Settings updated'));
            } else {
                return redirect()->back()->with('error', __('Something is wrong'));
            }
        } elseif ($request->from == 'booking_slots') {


              $user = Auth::user();
               $slot_settings=\App\SiteSettings::getUserSettings('slot_booking_settings');


           $arrEnv=[];
              if(!empty($slot_settings['enable_slot_booking']) && $slot_settings['enable_slot_booking'] == 'on'){
                $arrEnv['enable_slot_booking'] ='off';
            } else {
                $arrEnv['enable_slot_booking'] = 'on';
            }

             if (SiteSettings::where('name', 'slot_booking_settings')->where('user_id', $usr->id)->count() > 0) {
                $query=SiteSettings::where('name', 'slot_booking_settings')->where('user_id', $usr->id)->update(array('value' => json_encode($arrEnv)));
            } else {
                $query= SiteSettings::insert(array('value' => json_encode($arrEnv), 'name' => 'slot_booking_settings',"user_domain_id"=>$domain_id, 'user_id' => $usr->id));
            }

            if ($query) {
                return redirect()->back()->with('success', __('Slot Settings Updated'));
            } else {
                return redirect()->back()->with('error', __('Something is wrong'));
            }
        }
        elseif ($request->from == 'pusheragora') {
            	 if (isset($request->FRONTEND_THEME) && $request->FRONTEND_THEME != '') {
				$arrEnvF = [
				'FRONTEND_THEME' => $request->FRONTEND_THEME
				];
			  }
			  else{
				  $arrEnvF = [
				'FRONTEND_THEME' => ''
				];
			  }
                          $arrEnvF=$request->all();
                          unset($arrEnvF['_token']);
                          unset($arrEnvF['from']);
                          if(!empty($arrEnvF['TWILIO_VIDEO_ENABLE']) && $arrEnvF['TWILIO_VIDEO_ENABLE']=='on'){
                              $arrEnvF['TWILIO_VIDEO_ENABLE']='on';
                          }else{
                              $arrEnvF['TWILIO_VIDEO_ENABLE']='off';
                          }

                $env = Utility::setEnvironmentValue($arrEnvF);

                  return redirect()->back()->with('success', __('Video Api Settings updated'));
        }
        elseif ($request->from == 'twilioKey') {

            $validator = \Validator::make(
                          $request->all(), [
                      'twilio_account_sid' => 'required',
                      'twilio_auth_token' => 'required',
                      'twilio_number' => 'required',
                          ]
          );
          if ($validator->fails()) {
              $messages = $validator->getMessageBag();

              return redirect()->back()->with('error', $messages->first());
          }

         $arrEnv['twilio_account_sid'] = $request->twilio_account_sid;
         $arrEnv['twilio_auth_token'] = $request->twilio_auth_token;
         $arrEnv['twilio_number'] = $request->twilio_number;
         $arrEnv['twilio_from'] = $request->twilio_from;


           if (SiteSettings::where('name', 'twilio_key')->where('user_id', $usr->id)->count() > 0) {
              $query=SiteSettings::where('name', 'twilio_key')->where('user_id', $usr->id)->update(array('value' => json_encode($arrEnv)));
          } else {
              $query= SiteSettings::insert(array('value' => json_encode($arrEnv), 'name' => 'twilio_key',"user_domain_id"=>$domain_id, 'user_id' => $usr->id));
          }

          if ($query) {
              return redirect()->back()->with('success', __('Twilio key Settings updated'));
          } else {
              return redirect()->back()->with('error', __('Something is wrong'));
          }
      }
		elseif ($request->from == 'meta_data') {

                $user = auth()->user();
                $input = [];
                $input['title'] = 'Meta Data';
                $input['name'] = 'meta_data';
                $meta = [];
                $meta['meta_title'] = $request->meta_title;
                $meta['meta_description'] = $request->meta_description;
                $input['value'] = json_encode($meta, true);
                $input['user_id'] = $user->id;


                $checkExist = SiteSettings::where('name', 'meta_data')->where('user_id', $user->id)->first();
                if ($checkExist) {
                    $checkExist->update($input);
                    return redirect()->back()->with('success', __('Meta update.'));
                }
                SiteSettings::create($input);
                return redirect()->back()->with('success', __('Meta added.'));
            }
			elseif ($request->from == 'site_setting') {
                $twoFa = SiteSettings::where(['user_id' => $usr->id, 'name' => 'twoFa'])->first();
                $twoFaData= array();
				$twoFaData['name'] = 'twoFa';
				$twoFaData['value'] =$request->twoFa == 'on' ? 1 : 0;
				$twoFaData['user_id'] = $usr->id;
                if (!empty($twoFa)) {
                    $twoFa->update($twoFaData);
                }else{
                    SiteSettings::create($twoFaData);
                }

				 $UserSettings = SiteSettings::where(['user_id' => $usr->id, 'name' => 'favicon'])->first();

				 if (isset($request->FRONTEND_THEME) && $request->FRONTEND_THEME != '') {
				$arrEnvF = [
				'FRONTEND_THEME' => $request->FRONTEND_THEME
				];
			  }
			  else{
				  $arrEnvF = [
				'FRONTEND_THEME' => ''
				];
			  }
                           if (!empty($request->video)) {

                    $fileNameToStore = time() . '.' . $request->video->getClientOriginalExtension();
                    $arrEnvF['FRONTEND_THEME_BACKGROUND_VIDEO']  = $request->file('video')->storeAs('logo', $fileNameToStore);
                }


                $env = Utility::setEnvironmentValue($arrEnvF);
               ;
               $fevbackgroundr = "";
               $homebackground = "";
				  if ($UserSettings) {
                    $unserialized_array = json_decode($UserSettings->value, true);
                    if (!empty($unserialized_array['logo'])) {
                        $iconLogo = $unserialized_array['logo'];
                    } else {
                        $iconLogo = "";
                    }
                    if (!empty($unserialized_array['favicon'])) {
                        $fevLogo = $unserialized_array['favicon'];
                    } else {
                        $fevLogo = "";
                    }
                    if (!empty($unserialized_array['registerationbackground'])) {
                        $fevbackgroundr = $unserialized_array['registerationbackground'];
                    } else {
                        $fevbackgroundr = "";
                    }
                    if (!empty($unserialized_array['homebackground'])) {
                        $homebackground = $unserialized_array['homebackground'];
                    } else {
                        $homebackground = "";
                    }

                } else {
                    $iconLogo = $fevLogo = $logo_dark = "";
                }
             //  dd( $fevbackgroundr);
			$logoArray = array();
            if ($request->favicon != null) {
                $base64_encode = $request->favicon;
                $folderPath = "storage/logo/";
                $image_parts = explode(";base64,", $base64_encode);
                $image_type_aux = explode("image/", $image_parts[0]);
                $image_type = $image_type_aux[1];
                $image_base64 = base64_decode($image_parts[1]);
                $favicon = "favicon" . uniqid() . '.' . $image_type;
                $fevLogo = $favicon;
                $file = $folderPath . $favicon;
                file_put_contents($file, $image_base64);
                $logoArray['favicon'] = $fevLogo;
            } else {
                $logoArray['favicon'] = $fevLogo;
            }

            // background registeration

          //  dd($request);
            if ($request->registerbackground != null) {
                $base64_encode = $request->registerbackground;
                $folderPath = "storage/logo/";
                $image_parts = explode(";base64,", $base64_encode);
                $image_type_aux = explode("image/", $image_parts[0]);
                $image_type = $image_type_aux[1];
                $image_base64 = base64_decode($image_parts[1]);
                $registerationbackground = "registerationbackground" . uniqid() . '.' . $image_type;
                $fevbackgroundr = $registerationbackground;
                $file = $folderPath . $registerationbackground;
                file_put_contents($file, $image_base64);
                $logoArray['registerationbackground'] = $fevbackgroundr;
            } else {
                $logoArray['registerationbackground'] = $fevbackgroundr;
            }

            // background registeration

                 // background home

                 if ($request->homebackground != null) {
                    $base64_encode = $request->homebackground;
                    $folderPath = "storage/logo/";
                    $image_parts = explode(";base64,", $base64_encode);
                    $image_type_aux = explode("image/", $image_parts[0]);
                    $image_type = $image_type_aux[1];
                    $image_base64 = base64_decode($image_parts[1]);
                    $homesbackground = "homebackground" . uniqid() . '.' . $image_type;
                    $homebackground = $homesbackground;
                    $file = $folderPath . $homesbackground;
                    file_put_contents($file, $image_base64);
                    $logoArray['homebackground'] = $homebackground;
                } else {
                    $logoArray['homebackground'] = $homebackground;
                }
                // background home
            if ($request->full_logo != null) {
				$iconLogo='';
                $base64_encode = $request->full_logo;
                $folderPath = "storage/logo/";
                $image_parts = explode(";base64,", $base64_encode);
                $image_type_aux = explode("image/", $image_parts[0]);
                $image_type = $image_type_aux[1];
                $image_base64 = base64_decode($image_parts[1]);
                $logoName = "logo" . uniqid() . '.' . $image_type;
                $iconLogo = $logoName;
                $file = $folderPath . $logoName;
                file_put_contents($file, $image_base64);
                $logoArray['logo'] = $iconLogo;
            } else {
                $logoArray['logo'] = $iconLogo;
            }


         //  dd($logoArray);
            if ($request->full_logo || $request->favicon || $request->homebackground || $request->registerbackground ) {


                if (!empty($UserSettings)) {
                    $UserSettings->name = 'favicon';
                    $UserSettings->user_id = $usr->id;
                    $UserSettings->value = json_encode($logoArray, true);
                    $UserSettings->save();
                } else {
                    SiteSettings::create([
                        'name' => 'favicon',
                        'user_id' => $usr->id,
                        'value' => json_encode($logoArray, true),
                        'domain' => explode('.', $_SERVER['HTTP_HOST'])[0],
                        'user_domain_id' => $domain_id
                    ]);
                }
			}


			 $post = $request->all();
                unset($post['_token'], $post['full_logo'], $post['favicon'], $post['from']);


                $created_at = date('Y-m-d H:i:s');
                $updated_at = date('Y-m-d H:i:s');
				$checkExistfooter = SiteSettings::where(['user_id' => $usr->id, 'name' => 'footer_text'])->first();
				$checkExistlogoTxt = SiteSettings::where(['user_id' => $usr->id, 'name' => 'logo_text'])->first();

				if($checkExistlogoTxt){
					if(!empty($checkExistlogoTxt->value)){
						$logo_text=$checkExistlogoTxt->value;
					}else{
						$logo_text='';
					}
				}
				else{
					$logo_text='';
				}


			if ($request->logo_text != null) {
				$logotext=$request->logo_text;

			}
			else{
				$logotext= $logo_text;
			}

				$logodata = array();
				$logodata['name'] = 'logo_text';
				$logodata['value'] =$logotext;
				$logodata['user_id'] = $usr->id;
				$logodata['created_at'] = $created_at;
				$logodata['updated_at'] = $updated_at;


                if (!empty($checkExistlogoTxt)) {
                    $checkExistlogoTxt->update($logodata);
                }else{
                    SiteSettings::create($logodata);
                }



				if($checkExistfooter){
					if(!empty($checkExistfooter->value)){
						$header_text=$checkExistfooter->value;
					}else{
						$header_text='';
					}
				}
				else{
					$header_text='';
				}


		    if ($request->footer_text != null) {
				$headertext=$request->footer_text;

			}
			else{
				$headertext= $header_text;
			}

				$data = array();
				$data['name'] = 'footer_text';
				$data['value'] =$headertext;
				$data['user_id'] = $usr->id;
				$data['created_at'] = $created_at;
				$data['updated_at'] = $updated_at;


                if (!empty($checkExistfooter)) {
                    $checkExistfooter->update($data);
                }else{
                    SiteSettings::create($data);
                }





                return redirect()->back()->with('success', __('Basic Setting updated.'));
			}
			elseif($request->from == 'aws'){
                $arrEnv = [
                    'AWS_BUCKET' => $request->aws_bucket,
                    'AWS_DEFAULT_REGION' => $request->aws_default_region,
                    'AWS_ACCESS_KEY_ID' => $request->aws_access_key_id,
                    'AWS_SECRET_ACCESS_KEY' => $request->aws_secret_access_key
                ];
                if (SiteSettings::where('name', 'aws_settings')->where('user_id', $usr->id)->count() > 0) {
                    $query=SiteSettings::where('name', 'aws_settings')->where('user_id', $usr->id)->update(array('value' => json_encode($arrEnv)));
                } else {
                    $query= SiteSettings::insert(array('value' => json_encode($arrEnv), 'name' => 'aws_settings',"user_domain_id"=>$domain_id, 'user_id' => $usr->id));
                }


                if ($query) {
                    return redirect()->back()->with('success', __('AWS Setting updated.'));
                } else {
                    return redirect()->back()->with('error', __('Something is wrong'));
                }
                return redirect()->back()->with('success', __('AWS Setting updated.'));
            }

		elseif($request->from == "bot"){

            if(isset($request->default_answer)){
                if(SiteSettings::where('name', 'default_answer')->where('user_id',Auth::user()->id)->count() > 0){
                    SiteSettings::where('name', 'default_answer')->where('user_id',Auth::user()->id)->update(array('value'=>$request->default_answer));
                }else{
                    SiteSettings::insert(array('value'=>$request->default_answer,'name'=>'default_answer','title'=>'default_answer','user_id'=>Auth::user()->id));
                }
            }

            if(isset($request->greetings)){

                if(SiteSettings::where('name', 'greetings')->where('user_id',Auth::user()->id)->count() > 0){
                    SiteSettings::where('name', 'greetings')->where('user_id',Auth::user()->id)->update(array('value'=>$request->greetings));
                }else{
                    SiteSettings::insert(array('value'=>$request->greetings,'name'=>'greetings','title'=>'greetings','user_id'=>Auth::user()->id));
                }
            }

            if(SiteSettings::where('name', 'wiki_search')->where('user_id',Auth::user()->id)->count() > 0){
                SiteSettings::where('name', 'wiki_search')->where('user_id',Auth::user()->id)->update(array('value'=>$request->wiki_search));
            }else{
                SiteSettings::insert(array('value'=>$request->wiki_search,'name'=>'wiki_search','title'=>'wiki_search','user_id'=>Auth::user()->id));
            }

            if(SiteSettings::where('name', 'speech_voice')->where('user_id',Auth::user()->id)->count() > 0){
                SiteSettings::where('name', 'speech_voice')->where('user_id',Auth::user()->id)->update(array('value'=>$request->speech_voice));
            }else{
                SiteSettings::insert(array('value'=>$request->speech_voice,'name'=>'speech_voice','title'=>'speech_voice','user_id'=>Auth::user()->id));
            }
            setcookie('speech_voice', $request->speech_voice, time() + (6*30*24*3600), "/");

            if(SiteSettings::where('name', 'bot_twilio_voice')->where('user_id',Auth::user()->id)->count() > 0){
                SiteSettings::where('name', 'bot_twilio_voice')->where('user_id',Auth::user()->id)->update(array('value'=>$request->bot_twilio_voice));
            }else{
                SiteSettings::insert(array('value'=>$request->bot_twilio_voice,'name'=>'bot_twilio_voice','title'=>'bot_twilio_voice','user_id'=>Auth::user()->id));
            }

            if(SiteSettings::where('name', 'bot_name')->where('user_id',Auth::user()->id)->count() > 0){
                SiteSettings::where('name', 'bot_name')->where('user_id',Auth::user()->id)->update(array('value'=>$request->bot_name));
            }else{
                SiteSettings::insert(array('value'=>$request->bot_name,'name'=>'bot_name','title'=>'bot_name','user_id'=>Auth::user()->id));
            }

            if(SiteSettings::where('name', 'wake_word')->where('user_id',Auth::user()->id)->count() > 0){

                SiteSettings::where('name', 'wake_word')->where('user_id',Auth::user()->id)->update(array('value'=>$request->wake_word));
            }else{

                SiteSettings::insert(array('value'=>$request->wake_word,'name'=>'wake_word','title'=>'wake_word','user_id'=>Auth::user()->id));
            }

            if(SiteSettings::where('name', 'admin_faqs')->where('user_id',Auth::user()->id)->count() > 0){
                SiteSettings::where('name', 'admin_faqs')->where('user_id',Auth::user()->id)->update(array('value'=>$request->admin_faqs));
            }else{
                SiteSettings::insert(array('value'=>$request->admin_faqs,'name'=>'admin_faqs','title'=>'admin_faqs','user_id'=>Auth::user()->id));
            }

            if ($request->robot_img != null) {
                $base64_encode = $request->robot_img;

                $folderPath = "public/img/";
                $image_parts = explode(";base64,", $base64_encode);
                $image_type_aux = explode("image/", $image_parts[0]);
                $image_type = $image_type_aux[1];

                if($image_type == 'png' || $image_type == 'jpg' || $image_type == 'jpeg'){

                    $image_base64 = base64_decode($image_parts[1]);
                    $logoName = "img" . uniqid() . '.' . $image_type;
                    $iconLogo = $logoName;
                    $file = $folderPath . $logoName;
                    file_put_contents($file, $image_base64);

                    if(SiteSettings::where('name', 'robot_img')->where('user_id',Auth::user()->id)->count() > 0){
                        SiteSettings::where('name', 'robot_img')->where('user_id',Auth::user()->id)->update(array('value'=>$iconLogo));
                    }else{
                        SiteSettings::insert(array('value'=>$iconLogo,'name'=>'robot_img','title'=>'robot_img','user_id'=>Auth::user()->id));
                    }
                }else{

                    return redirect()->back()->with('error', __('The img must be a file of type: jpeg, png, jpg.'));
                }
            }
            return redirect()->back()->with('success', __('Bot Setting Updated.'));
        }

		elseif($request->from == "bingwiki"){
			 if(SiteSettings::where('name', 'wiki_key')->where('user_id',Auth::user()->id)->count() > 0){
            SiteSettings::where('name', 'wiki_key')->update(array('value'=>$request->wiki_key,'updated_at'=>date('Y-m-d h:i:s')));
			 }
			 else{
				  SiteSettings::insert(array('value'=>$request->wiki_key,'name'=>'wiki_key','title'=>'wiki_key','user_id'=>Auth::user()->id));

			 }
			return redirect()->back()->with('success', __('Bing Wiki Setting Updated.'));
        }

        if($request->from == "bingspeech"){
			 if(SiteSettings::where('name', 'speech_key')->where('user_id',Auth::user()->id)->count() > 0){
            SiteSettings::where('name', 'speech_key')->update(array('value'=>$request->speech_key,'updated_at'=>date('Y-m-d h:i:s')));
            SiteSettings::where('name', 'speech_region')->update(array('value'=>$request->speech_region,'updated_at'=>date('Y-m-d h:i:s')));
			 }
			 else{
				  SiteSettings::insert(array('value'=>$request->speech_key,'name'=>'speech_key','title'=>'speech_key','user_id'=>Auth::user()->id));
				  SiteSettings::insert(array('value'=>$request->speech_region,'name'=>'speech_region','title'=>'speech_region','user_id'=>Auth::user()->id));
			 }
            return redirect()->back()->with('success', __('Bing Speech Setting Updated.'));
        }

        return redirect()->back()->with('error', __('Permission Denied.'));
    }

    public function testEmail(Request $request) {
        $user = \Auth::user();
        if ($user->type == 'admin') {
            $data = [];
            $data['mail_driver'] = $request->mail_driver;
            $data['mail_host'] = $request->mail_host;
            $data['mail_port'] = $request->mail_port;
            $data['mail_username'] = $request->mail_username;
            $data['mail_password'] = $request->mail_password;
            $data['mail_encryption'] = $request->mail_encryption;
            $data['mail_from_address'] = $request->mail_from_address;
            $data['mail_from_name'] = $request->mail_from_name;


            return view('user.test_email', compact('data'));
        } else {
            return response()->json(['error' => __('Permission Denied.')], 401);
        }
    }

    public function testEmailSend(Request $request) {
        if (Auth::user()->type == 'admin') {
            $validator = \Validator::make(
                            $request->all(), [
                        'email' => 'required|email',
                        'mail_driver' => 'required',
                        'mail_host' => 'required',
                        'mail_port' => 'required',
                        'mail_username' => 'required',
                        'mail_password' => 'required',
                            ]
            );
            if ($validator->fails()) {
                $messages = $validator->getMessageBag();

                return redirect()->back()->with('error', $messages->first());
            }

            try {
                config(
                        [
                            'mail.driver' => $request->mail_driver,
                            'mail.host' => $request->mail_host,
                            'mail.port' => $request->mail_port,
                            'mail.encryption' => $request->mail_encryption,
                            'mail.username' => $request->mail_username,
                            'mail.password' => $request->mail_password,
                            'mail.from.address' => $request->mail_from_address,
                            'mail.from.name' => $request->mail_from_name,
                        ]
                );
                Mail::to($request->email)->send(new EmailTest());
            } catch (\Exception $e) {
                return response()->json(
                                [
                                    'is_success' => false,
                                    'message' => $e->getMessage(),
                                ]
                );
                //            return redirect()->back()->with('error', 'Something is Wrong.');
            }

            return response()->json(
                            [
                                'is_success' => true,
                                'message' => __('Email send'),
                            ]
            );
        } else {
            return response()->json(
                            [
                                'is_success' => false,
                                'message' => __('Permission Denied.'),
                            ]
            );
        }
    }

    	public function add_site_menu(Request $request){
		$request->validate([
           'title' => 'required',
           'url' => 'required',
		]);
		if(!empty($request->id)){
            $task = Menu::findOrFail($request->id);
            $input = $request->all();
            $task->fill($input)->save();
            return back()->with('success', 'Menu edit.');
		}else{
			$user = auth()->user();
			$input = $request->all();
			$input['parent_id'] = empty($input['parent_id']) ? 0 : $input['parent_id'];
			$input['user_id'] = $user->id;

			Menu::create($input);
			return back()->with('success', 'Menu added.');
		}


	}

	   public function storeMenu(Request $request) {
        $user = auth()->user();
		$url = explode('.', $_SERVER['HTTP_HOST'])[0];
        $input = [];
        $input['title'] = $request->title;
        $input['name'] = $request->slug;
        $input['value'] = json_encode($request->menus, true);
        $input['user_id'] = $user->id;
        $checkExist = SiteSettings::where('name', $request->slug)->where('user_id', $user->id)->first();;
        if ($checkExist) {
            $checkExist->update($input);
            return redirect()->back()->with('success', __('Menu update.'));
        }
        SiteSettings::create($input);
        return redirect()->back()->with('success', __('Menu added .'));
    }
	public function get_menu_by_id(Request $request){
		return Menu::where('id', $request->id)->first();

	}
	public function menu_destroy(Request $request){

		$menu = Menu::find($request->menu_id);
		$menu->delete();

        return redirect()->back()->with('success', __('Menu deleted.'));
	}
 public function subdomainCheck() {
        if (isset($_GET['subdomain']) && !empty($_GET['subdomain'])) {
            $subdomain = $_GET['subdomain'];
        }
        $user = Auth::user();
        $account = \App\UserDomain::where("custom_url", $subdomain)->where("user_id", "!=", $user->id)->first();
        if (!empty($account)) {
            echo 'false';
        } else {
            echo 'true';
        }
    }
    public function mailer_create(Request $request) {
        $usr = Auth::user();
        $id=$request->id??'';
        if(!empty($request->id)){
              $setting = \App\SiteSettings::where("name", 'mailer_settings')->where('user_id', $usr->id)->first();
            if (!empty($setting->value) && !empty(json_decode($setting->value))) {
                $mailer_setting = json_decode($setting->value, true);
            } elseif (!empty($setting->value)) {
                $mailer_setting = $setting->value;
            }
          $mailer_settings=$mailer_setting[$request->id]??'';
        }else{
            $mailer_settings='';
        }

        return view('email.settings.create', compact('id','mailer_settings'));
    }
    public function mailer_destroy($id=0) {
        $usr = Auth::user();
              $domain_id= get_domain_id();
           $setting = \App\SiteSettings::where("name", 'mailer_settings')->where('user_id', $usr->id)->first();
            if (!empty($setting->value) && !empty(json_decode($setting->value))) {
                $mailer_setting = json_decode($setting->value, true);
            } elseif (!empty($setting->value)) {
                $mailer_setting = $setting->value;
            }
            if (!empty($mailer_setting) && !empty($id)) {
                unset($mailer_setting[$id]);
                $mailer_setting=!empty($mailer_setting) ? json_encode($mailer_setting):'';
                if(!empty($mailer_setting)){
              $query=SiteSettings::where('name', 'mailer_settings')->where('user_id', $usr->id)->update(array('value' =>$mailer_setting ,"user_domain_id"=>$domain_id));
                }else{
                   SiteSettings::where('name', 'mailer_settings')->where('user_id', $usr->id)->delete();
                }
               return redirect()->back()->with('success', __('Successfully deleted.'));
            }

         return redirect()->back()->with('error', __('Something Wrong'));
    }
}
