<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Twilio\Rest\Client;
use Twilio\TwiML\VoiceResponse;
use App\TwilioNumber;
use App\Blacklist;
use App\IvrSetting;
use App\CallLog;
use App\Department;
use App\User;
use DateTime;
use App\SiteSettings;
use Aws\S3\S3Client;
use Aws\Exception\AwsException;
class TwilioController extends Controller
{
    public function index(Request $request){
        $url = url('/api');
        $response = new VoiceResponse();
        $twilio_numbers =  TwilioNumber::where('number',$request->To)->first();
        if(!empty($twilio_numbers)){
            $blacklist =  Blacklist::where('user_id',$twilio_numbers->user_id)->where('value',$request->From)->orwhere('value',$request->FromCountry)->where('status',1)->first();
            if(!empty($blacklist)){
                $response->reject();
                return $response;
            }else{
                $data = array();
                $data['user_id']   = $twilio_numbers->user_id;
                $data['phone']   = $request->Called;
                $data['pfrom']    = $request->From;
                $data['direction']    = $request->Direction;
                if(isset($request->CallSid)){
                    $data['parentcallsid'] = $request->CallSid;
                }
                $data['dialcallstatus']= $request->CallStatus;
                if($request->Direction == 'inbound'){
                    $type = 0;
                }else{
                    $type = 1;
                }
                $data['type'] = $type;
                $data['startat'] =date('Y-m-d H:i:s');
                $twilio_setting =  IvrSetting::where('user_id',$twilio_numbers->user_id)->first();
                $parent =  IvrSetting::where('user_id',1)->first();
                if(!empty($twilio_setting)){
                    if(!empty($twilio_setting->timezone)){
                        date_default_timezone_set($twilio_setting->timezone);
                    }
                    if(!empty($twilio_setting->twilio_voice)){
                        if($twilio_setting->twilio_voice == 1){
                            $voice = 'woman';
                        }else if($twilio_setting->twilio_voice == 2){
                            $voice = 'alice';
                        }else{
                            $voice = 'man';
                        }

                    }else{
                        $voice = 'alice';
                    }
                    if(!empty($twilio_setting->out_of_hour)){
                        $out_of_hour = $twilio_setting->out_of_hour;
                        $start = $end= $status = "";
                        if(date('l')=='Sunday'){
                            if(!empty($twilio_setting->sunday)){
                                $result = json_decode($twilio_setting->sunday,true);
                                $start = $result['sunday_start'];
                                $end = $result['sunday_end'];
                                $status = $result['sunday'];
                            }
                        }elseif(date('l')=='Monday'){
                            if(!empty($twilio_setting->monday)){
                                $result = json_decode($twilio_setting->monday,true);
                                $start = $result['monday_start'];
                                $end = $result['monday_end'];
                                $status = $result['monday'];
                            }
                        }elseif(date('l')=='Tuesday'){
                            if(!empty($twilio_setting->tuesday)){
                                $result = json_decode($twilio_setting->tuesday,true);
                                $start = $result['tuesday_start'];
                                $end = $result['tuesday_end'];
                                $status = $result['tuesday'];
                            }
                        }elseif(date('l')=='Wednesday'){
                            if(!empty($twilio_setting->wednesday)){
                                $result = json_decode($twilio_setting->wednesday,true);
                                $start = $result['wednesday_start'];
                                $end = $result['wednesday_end'];
                                $status = $result['wednesday'];
                            }
                        }elseif(date('l')=='Thursday'){
                            if(!empty($twilio_setting->thursday)){
                                $result = json_decode($twilio_setting->thursday,true);
                                $start = $result['thursday_start'];
                                $end = $result['thursday_end'];
                                $status = $result['thursday'];
                            }
                        }elseif(date('l')=='Friday'){
                            if(!empty($twilio_setting->friday)){
                                $result = json_decode($twilio_setting->friday,true);
                                $start = $result['friday_start'];
                                $end = $result['friday_end'];
                                $status = $result['friday'];
                            }
                        }elseif(date('l')=='Saturday'){
                            if(!empty($twilio_setting->saturday)){
                                $result = json_decode($twilio_setting->saturday,true);
                                $start = $result['saturday_start'];
                                $end = $result['saturday_end'];
                                $status = $result['saturday'];
                            }
                        }
                        $now = new Datetime("now");
                        $begintime = new DateTime(date("H:i", strtotime($start)));
                        $endtime = new DateTime(date("H:i", strtotime($end)));
                        if($now >= $begintime && $now <= $endtime && $status ==1 && $out_of_hour==1 ){

                            if($twilio_setting->out_of_hour_type == 0){
                                //tts
                                if($twilio_setting->out_of_hour_text != ''){
                                    $response->say($twilio_setting->out_of_hour_text, ['voice' => $voice]);
                                }else{
                                    if($parent->out_of_hour_text != ''){
                                        $response->say($parent->out_of_hour_text, ['voice' => $voice]);
                                    }
                                }
                            }else{
                                //mp3
                                if(!empty($twilio_setting->out_of_hour_mp3)){
                                    $music = $twilio_setting->out_of_hour_mp3;
                                    $response->play($music);
                                }else{
                                    if(!empty($parent->out_of_hour_mp3)){
                                        $music = $parent->out_of_hour_mp3;
                                        $response->play($music);
                                    }
                                }
                            }
                            $data['statusin'] = 'Out Of Hours';
                        }


                    }else{
                        $out_of_hour = 0;
                        if($twilio_setting->transfer_call == 1){
                            $response->redirect($url.'/support/gethercall/'.$twilio_setting->user_id);
                        }elseif($twilio_setting->transfer_call == 2){
                            if($twilio_setting->voicemail == 0){
                                //tts
                                if(!empty($twilio_setting->voicemail_text)){
                                    $response->say($twilio_setting->voicemail_text, ['voice' => $voice]);
                                }else{
                                    if(!empty($parent->voicemail_text)){
                                        $response->say($parent->voicemail_text, ['voice' => $voice]);
                                    }else{
                                        $response->say('Please leave a message at the beep. Press the star key when finished. ', ['voice' => $voice]);
                                    }
                                }
                            }else{
                                //mp3
                                if(!empty($twilio_setting->voicemail_mp3)){
                                    $music = $twilio_setting->voicemail_mp3;
                                    $response->play($music);
                                }else{
                                    if(!empty($parent->voicemail_mp3)){
                                        $music = $parent->voicemail_mp3;
                                        $response->play($music);
                                    }else{
                                        $response->say('Please leave a message at the beep. Press the star key when finished. ', ['voice' => $voice]);
                                    }
                                }
                            }
                         $response->record(['maxLength' => 30,'finishOnKey' => '*','action'=>$url.'/support/hangups/'.$twilio_setting->user_id]);
                        }

                    }
                    CallLog::insert($data);
                }
            }
            return $response;
        }


    }
    public function getherCall(Request $request){
        $url = asset('/api');
        $response = new VoiceResponse();
        $twilio_setting =  IvrSetting::where('user_id',$request->user_id)->first();
        $parent =  IvrSetting::where('user_id',1)->first();
        $users =  User::where('id',$request->user_id)->first();
        $gather = $response->gather(array('numDigits' => 1,'input'=>'dtmf','timeout'=>10,'action'=>$url.'/support/getherInput/'.$request->user_id));
        if(!empty($twilio_setting)){
            if(isset($twilio_setting->twilio_voice)){
                if($twilio_setting->twilio_voice == 1){
                    $voice = 'woman';
                }else if($twilio_setting->twilio_voice == 2){
                    $voice = 'alice';
                }else{
                    $voice = 'man';
                }
            }else {
                $voice = 'alice';
            }
            if($twilio_setting->ivr == 0){
                //tts
                if(isset($twilio_setting->ivr_text)){
                    $msg = $twilio_setting->ivr_text;
                }else{
                    if(isset($parent->ivr_text)){
                        $msg = $parent->ivr_text;
                    }
                }
                $gather->say($msg, array('voice' => $voice));
            }else{
                //mp3
                if(isset($twilio_setting->ivr_mp3)){
                    $music = $twilio_setting->ivr_mp3;
                    $gather->play($music);

                }else{
                    if(isset($parent->ivr_mp3)){
                        $music = $parent->ivr_mp3;
                        $gather->play($music);
                    }
                }
            }
        }
        $response->say('We did not receive any input from your side. Goodbye!', array('voice' => $voice));
        $response->hangup();
        return response( $response )->header( 'Content-Type', 'application/xml' );

    }

    public function hangups($user_id){

        $response = new VoiceResponse();
        $response->hangup();


        $call_logs_arr = Calllog::where('parentcallsid',$_REQUEST['CallSid'])->first();

        $s3Client = new S3Client([
            'region' => get_aws_s3_bucket_credentials_by_id('AWS_DEFAULT_REGION',false,$user_id),
            'bucket' => get_aws_s3_bucket_credentials_by_id('AWS_BUCKET',false,$user_id),
            'version' => '2006-03-01',
                    'credentials' => [
                'key'    => get_aws_s3_bucket_credentials_by_id('AWS_ACCESS_KEY_ID',false,$user_id),
                'secret' => get_aws_s3_bucket_credentials_by_id('AWS_SECRET_ACCESS_KEY',false,$user_id),
            ],
        ]);

        if(!empty($call_logs_arr)){
            $data = array();
            if(isset($_REQUEST['RecordingSid'])) {
                $data['recordingsid'] = $_REQUEST['RecordingSid'];
            }
            if(isset($_REQUEST['RecordingUrl'])) {
               $datas =  $this->file_get_contents_curl($_REQUEST['RecordingUrl'].'.mp3');
                    $fileNameToStore = $_REQUEST['RecordingSid'] . '.mp3';
                    $result = $s3Client->putObject([
                            'Bucket' => get_aws_s3_bucket_credentials_by_id('AWS_BUCKET',false,$user_id),
                            'Key'    => 'ivr/recording/'.$fileNameToStore,
                            'Body' => $datas,
                            'ACL'        => 'public-read',
                            'ContentType' => 'audio/mpeg',
                    ]);

                    $data['recordingurl'] =$result['ObjectURL'];

                   // $data['recordingurl'] =$_REQUEST['RecordingUrl'];
            }
            $data['statusin'] ='Completed';
            $data['dialcallstatus'] ='Completed';
            $data['voicemail'] = 1;

            if(!empty($_REQUEST['RecordingDuration'])){

                $data['dialcallduration'] = $_REQUEST['RecordingDuration'];
            }
            $data['endat']  = date('Y-m-d H:i:s');

            Calllog::where('id', $call_logs_arr->id)->update($data);
        }
        return  response( $response )->header( 'Content-Type', 'application/xml' );

    }
    public function file_get_contents_curl( $url ) {

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_HEADER, 0);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_URL, $url);
        $data = curl_exec($ch);
        curl_close($ch);

        return $data;
    }
    public function transcribeCallback(Request $request){
        if(isset($request->RecordingUrl)){
            $RecordingUrl = $request->RecordingUrl.'.mp3';
        }else{
            $RecordingUrl="";
        }
        $twilio_setting =  IvrSetting::where('user_id',$request->user_id)->first();
        if(!empty($twilio_setting->notification)){
            if($twilio_setting->notification == 2){
                if(!empty($twilio_setting->email) && !empty($twilio_setting->email_template)){

                    $string = str_replace('{RecordingUrl}', $RecordingUrl, $twilio_setting->email_template);
                    $string = str_replace('{From}', $request->From, $string);
                    if(!empty($request->TranscriptionText)){
                        $string = str_replace('{TranscriptionText}', $request->TranscriptionText, $string);
                    }else{
                        $string = str_replace('{TranscriptionText}','', $string);
                    }
                    Mail::send('email.voicemail',$string, function($message) use ($twilio_setting,$request){
                        $message->to($twilio_setting->email)->subject
                        ("Message from ".$request->From)->from(config('mail.from.address'),get_from_name_email());
                    });
                }
            }elseif($twilio_setting->notification == 3){
                if(!empty($twilio_setting->mobile) && !empty($twilio_setting->sms_template)){
                    $string = str_replace('{RecordingUrl}', $RecordingUrl, $twilio_setting->sms_template);
                    $string = str_replace('{From}', $request->From, $string);
                    if(!empty($request->TranscriptionText)){
                        $string = str_replace('{TranscriptionText}', $request->TranscriptionText, $string);
                    }else{
                        $string = str_replace('{TranscriptionText}','', $string);
                    }
                    $string = str_replace('{From}', $request->From, $string);
                    Sms::twilio($twilio_setting->mobile, $string);
                }

            }


        }
    }
    public function getherInput(Request $request){
        $url = url('/api');
        $response = new VoiceResponse();
        $twilio_setting =  IvrSetting::where('user_id',$request->user_id)->first();
        if(!empty($twilio_setting)){
            if(asset($twilio_setting->twilio_voice)){
                if($twilio_setting->twilio_voice == 1){
                    $voice = 'woman';
                }else if($twilio_setting->twilio_voice == 2){
                    $voice = 'alice';
                }else{
                    $voice = 'man';
                }
            }else {
                $voice = 'alice';
            }

            $timeout = '10';
            if (array_key_exists('Digits', $_REQUEST)) {
                $departments =  Department::where('user_id',$request->user_id)->where('status',0)->where('extension',$request->Digits)->first();

                if(!empty($departments)){
                    if(isset($departments->twilio_voice)){
                        if($departments->twilio_voice == 1){
                            $voice = 'woman';
                        }else if($departments->twilio_voice == 2){
                            $voice = 'alice';
                        }else{
                            $voice = 'man';
                        }
                    }else {
                        $voice = 'alice';
                    }
                    if($departments->calltype == 0){
                        if($departments->greetings == 0){
                            //tts
                            if(isset($departments->tts)){
                                $response->say($departments->tts, ['voice' => $voice]);
                            }else{
                                $response->say('Please leave a message at the beep. Press the star key when finished. ', ['voice' => $voice]);
                            }
                        }else{
                            //mp3
                            if(isset($departments->mp3)){
                                $music = $departments->mp3;
                                $response->play($music);
                            }else{
                                $response->say('Please leave a message at the beep. Press the star key when finished. ', ['voice' => $voice]);
                            }
                        }

                        $response->record(['maxLength' => 30, 'finishOnKey' => '*','action'=>$url.'/support/hangup/'.$request->user_id.'/'.$departments->name]);
                    }elseif($departments->calltype == 1){

                        // $queueName = substr($users->email, 0, strpos($users->email, '@'));

                        $response->dial($departments->forward,['timeout'=>$timeout,'action'=>$url.'/support/voiceRecord/'.$request->user_id.'/'.$departments->name]);

                        //$response->enqueue($queueName, ['waitUrl'=>'https://myceo.com/uploads/twilio/2cQV8RyENkp8AYXWs3qPEYBdvlBWMlTC.mp3']);



                    }else{
                        $response->say('Something went wrong . Please try again', array('voice' => $voice));
                    }
                }else{
                    $response->say('you have entered an invalid extension', array('voice' => $voice));
                    $response->redirect($url.'/support/gethercall/'.$twilio_setting->user_id);
                }

            }else{
                $response->say('Something went wrong . Please try again', array('voice' => $voice));
            }
        }
        return response( $response )->header( 'Content-Type', 'application/xml' );
    }
    public function voiceRecord(Request $request){
        //echo "<pre>"; print_r($_REQUEST);die;
        $response = new VoiceResponse();
        $url = asset('api/');
        $twilio_setting =  IvrSetting::where('user_id',$request->user_id)->first();
        $parent =  IvrSetting::where('user_id',1)->first();

        if(!empty($twilio_setting)){
            if(isset($twilio_setting->twilio_voice)){
                if($twilio_setting->twilio_voice == 1){
                    $voice = 'woman';
                }else if($twilio_setting->twilio_voice == 2){
                    $voice = 'alice';
                }else{
                    $voice = 'man';
                }
            }else {
                $voice = 'alice';
            }
            if($twilio_setting->voicemail == 0){
                //tts
                if(isset($twilio_setting->voicemail_text)){
                    $response->say($twilio_setting->voicemail_text, ['voice' => $voice]);
                }else{
                    if(isset($parent->voicemail_text)){
                        $response->say($parent->voicemail_text, ['voice' => $voice]);
                    }else{
                        $response->say('Please leave a message at the beep. Press the star key when finished. ', ['voice' => $voice]);
                    }
                }
            }else{
                //mp3
                if(isset($twilio_setting->voicemail_mp3)){
                    $music = $twilio_setting->voicemail_mp3;
                    $response->play($music);
                }else{
                    if(isset($parent->voicemail_mp3)){
                        $music = $parent->voicemail_mp3;
                        $response->play($music);
                    }else{
                        $response->say('Please leave a message at the beep. Press the star key when finished. ', ['voice' => $voice]);
                    }
                }
            }
        }
        $RecordingSid = '';
        $DialCallStatus = '';
        $RecordingUrl = '';
        $TranscriptionText = '';
        $CallSid = '';
        $DialCallDuration = 0;
        $RecordingDuration = 0;
        $DialCallSid = '';


        if(isset($request->DialCallSid)){
            $DialCallSid = $request->DialCallSid;
        }
        if(isset($request->CallSid)){
            $CallSid = $request->CallSid;
        }
        if(isset($request->RecordingSid)){
            $RecordingSid = $request->RecordingSid;
        }
        if(isset($request->RecordingUrl)){
            $RecordingUrl = $request->RecordingUrl.'.mp3';
        }
        if(isset($_REQUEST['RecordingUrl'])) {
            $s3Client = new S3Client([
                'region' => get_aws_s3_bucket_credentials_by_id('AWS_DEFAULT_REGION',false,$user_id),
                'bucket' => get_aws_s3_bucket_credentials_by_id('AWS_BUCKET',false,$user_id),
                'version' => '2006-03-01',
                        'credentials' => [
                    'key'    => get_aws_s3_bucket_credentials_by_id('AWS_ACCESS_KEY_ID',false,$user_id),
                    'secret' => get_aws_s3_bucket_credentials_by_id('AWS_SECRET_ACCESS_KEY',false,$user_id),
                ],
            ]);
            $datas =  $this->file_get_contents_curl($_REQUEST['RecordingUrl'].'.mp3');
                 $fileNameToStore = $_REQUEST['RecordingSid'] . '.mp3';
                 $result = $s3Client->putObject([
                         'Bucket' => get_aws_s3_bucket_credentials_by_id('AWS_BUCKET',false,$user_id),
                         'Key'    => 'ivr/recording/'.$fileNameToStore,
                         'Body' => $datas,
                         'ACL'        => 'public-read',
                         'ContentType' => 'audio/mpeg',
                 ]);

                 $RecordingUrl = $result['ObjectURL'];

                // $data['recordingurl'] =$_REQUEST['RecordingUrl'];
         }
        if(isset($request->RecordingDuration)){
            $RecordingDuration = $request->RecordingDuration;
        }else{
            $RecordingDuration = '';
        }
        if(isset($request->TranscriptionText)){
            $TranscriptionText = $request->TranscriptionText;
        }

        if(isset($request->DialCallStatus) && $request->DialCallStatus == 'no-answer'){
            $DialCallStatus = 'No Answer';
        }else{
            $DialCallStatus = 'Completed';
        }
        $twilio_key = SiteSettings::select('value')->where('name','twilio_key')->where('user_id',1)->first();
        if(!empty($twilio_key)){
            $twilio_keys = json_decode($twilio_key->value,true);
            $accountsid = $twilio_keys['twilio_account_sid'];
            $authtoken=$twilio_keys['twilio_auth_token'];
        }else{
            $accountsid = $authtoken = "";
        }
        $client = new Client($accountsid,$authtoken);

        $call = $client->calls($DialCallSid)
            ->fetch();
       // echo "<pre>"; print_r($call);die;
        if($call->direction == 'inbound'){
            $type = 0;
        }else{
            $type = 1;
        }
        $start = $call->dateCreated->format('Y-m-d H:i:s');
        $end = $call->endTime->format('Y-m-d H:i:s');



        $data['user_id']   = $request->user_id;
        if(!empty($request->dept_id)){
            $data['dept_id']   =  $request->dept_id;
        }
        $data['phone']   =  $call->to;
        $data['pfrom']    = $request->From;
        $data['direction']    = $call->direction;
        $data['recordingsid'] = $RecordingSid;
        $data['recordingurl'] = $RecordingUrl;
        $data['parentcallsid'] = $CallSid;
        $data['dialcallstatus'] = $DialCallStatus;
        $data['dialcallduration'] = $RecordingDuration;
        $data['transceriptiontext'] = $TranscriptionText;
        $data['type'] = $type;
        $data['statusin'] =$DialCallStatus;
        $data['startat'] =$start;
        $data['endat'] =$end;
        $data['survey'] = 0;
        $data['record_show'] = 1;
        $data['voicemail'] = 0;
        $data['seen'] = 0;
        Calllog::insert($data);
        //db inserted
        $response->record(['maxLength' => 30, 'finishOnKey' => '*','action'=>$url.'/support/hanguprecord/'.$request->user_id]);
        return response( $response )->header( 'Content-Type', 'application/xml' );
    }
    public function hangupRecord(Request $request){
        $response = new VoiceResponse();
        $response->hangup();
        $CallSid = '';
        $RecordingUrl = '';
        $RecordingSid = '';
        if(isset($_REQUEST['CallSid'])){
            $CallSid = $_REQUEST['CallSid'];
        }
        if(isset($_REQUEST['RecordingUrl'])) {
            $s3Client = new S3Client([
                'region' => get_aws_s3_bucket_credentials_by_id('AWS_DEFAULT_REGION',false,$user_id),
                'bucket' => get_aws_s3_bucket_credentials_by_id('AWS_BUCKET',false,$user_id),
                'version' => '2006-03-01',
                        'credentials' => [
                    'key'    => get_aws_s3_bucket_credentials_by_id('AWS_ACCESS_KEY_ID',false,$user_id),
                    'secret' => get_aws_s3_bucket_credentials_by_id('AWS_SECRET_ACCESS_KEY',false,$user_id),
                ],
            ]);
            $datas =  $this->file_get_contents_curl($_REQUEST['RecordingUrl'].'.mp3');
                    $fileNameToStore = $_REQUEST['RecordingSid'] . '.mp3';
                    $result = $s3Client->putObject([
                            'Bucket' => get_aws_s3_bucket_credentials_by_id('AWS_BUCKET',false,$user_id),
                            'Key'    => 'ivr/recording/'.$fileNameToStore,
                            'Body' => $datas,
                            'ACL'        => 'public-read',
                            'ContentType' => 'audio/mpeg',
                    ]);

                    $RecordingUrl = $result['ObjectURL'];

                // $data['recordingurl'] =$_REQUEST['RecordingUrl'];
        }
        if(isset($_REQUEST['RecordingSid'])){
            $RecordingSid = $_REQUEST['RecordingSid'];
        }
        $calllogs =  Calllog::where('parentcallsid',$CallSid)->first();

        $data4['recordingurl'] = $RecordingUrl;
        $data4['recordingsid'] = $RecordingSid;
        Calllog::where("id" , $calllogs->id)->update($data4);
        $response = new VoiceResponse();
        $response->hangup();
        return response( $response )->header( 'Content-Type', 'application/xml' );
    }
    public function hangup(Request $request){
        $call_logs_arr = Calllog::where('parentcallsid',$_REQUEST['CallSid'])->first();
        if(!empty($call_logs_arr)){
            $data = array();
            $timeFirst  = strtotime($call_logs_arr->startat);
            $timeSecond = strtotime(date('Y-m-d H:i:s'));
            $differenceInSeconds = $timeSecond - $timeFirst;
            if(isset($_REQUEST['RecordingSid'])) {
                $data['recordingsid'] = $_REQUEST['RecordingSid'];
            }
            $s3Client = new S3Client([
                'region' => get_aws_s3_bucket_credentials_by_id('AWS_DEFAULT_REGION',false,$request->user_id),
                'bucket' => get_aws_s3_bucket_credentials_by_id('AWS_BUCKET',false,$request->user_id),
                'version' => '2006-03-01',
                        'credentials' => [
                    'key'    => get_aws_s3_bucket_credentials_by_id('AWS_ACCESS_KEY_ID',false,$request->user_id),
                    'secret' => get_aws_s3_bucket_credentials_by_id('AWS_SECRET_ACCESS_KEY',false,$request->user_id),
                ],
            ]);
            if(isset($_REQUEST['RecordingUrl'])) {
                $datas =  $this->file_get_contents_curl($_REQUEST['RecordingUrl'].'.mp3');
                $fileNameToStore = $_REQUEST['RecordingSid'] . '.mp3';
                $result = $s3Client->putObject([
                        'Bucket' => get_aws_s3_bucket_credentials_by_id('AWS_BUCKET',false,$request->user_id),
                        'Key'    => 'ivr/recording/'.$fileNameToStore,
                        'Body' => $datas,
                        'ACL'        => 'public-read',
                        'ContentType' => 'audio/mpeg',
                ]);
                $data['recordingurl'] =$result['ObjectURL'];
            }
            if(!empty($request->dept_id)){
                $data['dept_id']   = $request->dept_id;
            }
            $data['statusin'] ='Completed';
            $data['dialcallstatus'] ='Completed';
            $data['voicemail'] = 1;
            $data['dialcallduration'] = $differenceInSeconds;
            if(isset($_REQUEST['TranscriptionText'])) {
                $data['transceriptiontext'] = $_REQUEST['TranscriptionText'];
            }
            $data['endat']  = date('Y-m-d H:i:s');
            Calllog::where('id', $call_logs_arr->id)->update($data);
        }
        $response = new VoiceResponse();
        $response->hangup();
        return response( $response )->header( 'Content-Type', 'application/xml' );

    }
}
