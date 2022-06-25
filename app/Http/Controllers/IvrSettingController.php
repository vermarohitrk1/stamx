<?php

namespace App\Http\Controllers;

use App\IvrSetting;
use Illuminate\Http\Request;
use DataTables;
use App\TwilioNumber;
use App\SiteSettings;
use App\User;
use Illuminate\Support\Facades\Validator;
use Auth;
use App\Blacklist;
use App\Country;
use Carbon\Carbon;
use App\CallLog;
use Twilio\TwiML\VoiceResponse;
use Twilio\Jwt\ClientToken;
use Twilio\Rest\Client;
use App\Department;
use App\Utility;
use Illuminate\Support\Facades\Storage;
use File;
use Aws\S3\S3Client;
use Aws\Exception\AwsException;

class IvrSettingController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    // public function __construct(Country $country)
    // {
    //     parent::__construct();
    //     $this->country = $country;
    // }

    public function index(Request $request)
    {

        $ivr = IvrSetting::where('user_id',Auth::id())->first();
        $timezones = array (
        '(GMT-11:00) Midway Island' => 'Pacific/Midway',
        '(GMT-11:00) Samoa' => 'Pacific/Samoa',
        '(GMT-10:00) Hawaii' => 'Pacific/Honolulu',
        '(GMT-09:00) Alaska' => 'US/Alaska',
        '(GMT-08:00) Pacific Time (US &amp; Canada)' => 'America/Los_Angeles',
        '(GMT-08:00) Tijuana' => 'America/Tijuana',
        '(GMT-07:00) Arizona' => 'US/Arizona',
        '(GMT-07:00) Chihuahua' => 'America/Chihuahua',
        '(GMT-07:00) La Paz' => 'America/Chihuahua',
        '(GMT-07:00) Mazatlan' => 'America/Mazatlan',
        '(GMT-07:00) Mountain Time (US &amp; Canada)' => 'US/Mountain',
        '(GMT-06:00) Central America' => 'America/Managua',
        '(GMT-06:00) Central Time (US &amp; Canada)' => 'US/Central',
        '(GMT-06:00) Guadalajara' => 'America/Mexico_City',
        '(GMT-06:00) Mexico City' => 'America/Mexico_City',
        '(GMT-06:00) Monterrey' => 'America/Monterrey',
        '(GMT-06:00) Saskatchewan' => 'Canada/Saskatchewan',
        '(GMT-05:00) Bogota' => 'America/Bogota',
        '(GMT-05:00) Eastern Time (US &amp; Canada)' => 'US/Eastern',
        '(GMT-05:00) Indiana (East)' => 'US/East-Indiana',
        '(GMT-05:00) Lima' => 'America/Lima',
        '(GMT-05:00) Quito' => 'America/Bogota',
        '(GMT-04:00) Atlantic Time (Canada)' => 'Canada/Atlantic',
        '(GMT-04:30) Caracas' => 'America/Caracas',
        '(GMT-04:00) La Paz' => 'America/La_Paz',
        '(GMT-04:00) Santiago' => 'America/Santiago',
        '(GMT-03:30) Newfoundland' => 'Canada/Newfoundland',
        '(GMT-03:00) Brasilia' => 'America/Sao_Paulo',
        '(GMT-03:00) Buenos Aires' => 'America/Argentina/Buenos_Aires',
        '(GMT-03:00) Georgetown' => 'America/Argentina/Buenos_Aires',
        '(GMT-03:00) Greenland' => 'America/Godthab',
        '(GMT-02:00) Mid-Atlantic' => 'America/Noronha',
        '(GMT-01:00) Azores' => 'Atlantic/Azores',
        '(GMT-01:00) Cape Verde Is.' => 'Atlantic/Cape_Verde',
        '(GMT+00:00) Casablanca' => 'Africa/Casablanca',
        '(GMT+00:00) Edinburgh' => 'Europe/London',
        '(GMT+00:00) Greenwich Mean Time : Dublin' => 'Etc/Greenwich',
        '(GMT+00:00) Lisbon' => 'Europe/Lisbon',
        '(GMT+00:00) London' => 'Europe/London',
        '(GMT+00:00) Monrovia' => 'Africa/Monrovia',
        '(GMT+00:00) UTC' => 'UTC',
        '(GMT+01:00) Amsterdam' => 'Europe/Amsterdam',
        '(GMT+01:00) Belgrade' => 'Europe/Belgrade',
        '(GMT+01:00) Berlin' => 'Europe/Berlin',
        '(GMT+01:00) Bern' => 'Europe/Berlin',
        '(GMT+01:00) Bratislava' => 'Europe/Bratislava',
        '(GMT+01:00) Brussels' => 'Europe/Brussels',
        '(GMT+01:00) Budapest' => 'Europe/Budapest',
        '(GMT+01:00) Copenhagen' => 'Europe/Copenhagen',
        '(GMT+01:00) Ljubljana' => 'Europe/Ljubljana',
        '(GMT+01:00) Madrid' => 'Europe/Madrid',
        '(GMT+01:00) Paris' => 'Europe/Paris',
        '(GMT+01:00) Prague' => 'Europe/Prague',
        '(GMT+01:00) Rome' => 'Europe/Rome',
        '(GMT+01:00) Sarajevo' => 'Europe/Sarajevo',
        '(GMT+01:00) Skopje' => 'Europe/Skopje',
        '(GMT+01:00) Stockholm' => 'Europe/Stockholm',
        '(GMT+01:00) Vienna' => 'Europe/Vienna',
        '(GMT+01:00) Warsaw' => 'Europe/Warsaw',
        '(GMT+01:00) West Central Africa' => 'Africa/Lagos',
        '(GMT+01:00) Zagreb' => 'Europe/Zagreb',
        '(GMT+02:00) Athens' => 'Europe/Athens',
        '(GMT+02:00) Bucharest' => 'Europe/Bucharest',
        '(GMT+02:00) Cairo' => 'Africa/Cairo',
        '(GMT+02:00) Harare' => 'Africa/Harare',
        '(GMT+02:00) Helsinki' => 'Europe/Helsinki',
        '(GMT+02:00) Istanbul' => 'Europe/Istanbul',
        '(GMT+02:00) Jerusalem' => 'Asia/Jerusalem',
        '(GMT+02:00) Kyiv' => 'Europe/Helsinki',
        '(GMT+02:00) Pretoria' => 'Africa/Johannesburg',
        '(GMT+02:00) Riga' => 'Europe/Riga',
        '(GMT+02:00) Sofia' => 'Europe/Sofia',
        '(GMT+02:00) Tallinn' => 'Europe/Tallinn',
        '(GMT+02:00) Vilnius' => 'Europe/Vilnius',
        '(GMT+03:00) Baghdad' => 'Asia/Baghdad',
        '(GMT+03:00) Kuwait' => 'Asia/Kuwait',
        '(GMT+03:00) Minsk' => 'Europe/Minsk',
        '(GMT+03:00) Nairobi' => 'Africa/Nairobi',
        '(GMT+03:00) Riyadh' => 'Asia/Riyadh',
        '(GMT+03:00) Volgograd' => 'Europe/Volgograd',
        '(GMT+03:30) Tehran' => 'Asia/Tehran',
        '(GMT+04:00) Abu Dhabi' => 'Asia/Muscat',
        '(GMT+04:00) Baku' => 'Asia/Baku',
        '(GMT+04:00) Moscow' => 'Europe/Moscow',
        '(GMT+04:00) Muscat' => 'Asia/Muscat',
        '(GMT+04:00) St. Petersburg' => 'Europe/Moscow',
        '(GMT+04:00) Tbilisi' => 'Asia/Tbilisi',
        '(GMT+04:00) Yerevan' => 'Asia/Yerevan',
        '(GMT+04:30) Kabul' => 'Asia/Kabul',
        '(GMT+05:00) Islamabad' => 'Asia/Karachi',
        '(GMT+05:00) Karachi' => 'Asia/Karachi',
        '(GMT+05:00) Tashkent' => 'Asia/Tashkent',
        '(GMT+05:30) Chennai' => 'Asia/Calcutta',
        '(GMT+05:30) Kolkata' => 'Asia/Kolkata',
        '(GMT+05:30) Mumbai' => 'Asia/Calcutta',
        '(GMT+05:30) New Delhi' => 'Asia/Calcutta',
        '(GMT+05:30) Sri Jayawardenepura' => 'Asia/Calcutta',
        '(GMT+05:45) Kathmandu' => 'Asia/Katmandu',
        '(GMT+06:00) Almaty' => 'Asia/Almaty',
        '(GMT+06:00) Astana' => 'Asia/Dhaka',
        '(GMT+06:00) Dhaka' => 'Asia/Dhaka',
        '(GMT+06:00) Ekaterinburg' => 'Asia/Yekaterinburg',
        '(GMT+06:30) Rangoon' => 'Asia/Rangoon',
        '(GMT+07:00) Bangkok' => 'Asia/Bangkok',
        '(GMT+07:00) Hanoi' => 'Asia/Bangkok',
        '(GMT+07:00) Jakarta' => 'Asia/Jakarta',
        '(GMT+07:00) Novosibirsk' => 'Asia/Novosibirsk',
        '(GMT+08:00) Beijing' => 'Asia/Hong_Kong',
        '(GMT+08:00) Chongqing' => 'Asia/Chongqing',
        '(GMT+08:00) Hong Kong' => 'Asia/Hong_Kong',
        '(GMT+08:00) Krasnoyarsk' => 'Asia/Krasnoyarsk',
        '(GMT+08:00) Kuala Lumpur' => 'Asia/Kuala_Lumpur',
        '(GMT+08:00) Perth' => 'Australia/Perth',
        '(GMT+08:00) Singapore' => 'Asia/Singapore',
        '(GMT+08:00) Taipei' => 'Asia/Taipei',
        '(GMT+08:00) Ulaan Bataar' => 'Asia/Ulan_Bator',
        '(GMT+08:00) Urumqi' => 'Asia/Urumqi',
        '(GMT+09:00) Irkutsk' => 'Asia/Irkutsk',
        '(GMT+09:00) Osaka' => 'Asia/Tokyo',
        '(GMT+09:00) Sapporo' => 'Asia/Tokyo',
        '(GMT+09:00) Seoul' => 'Asia/Seoul',
        '(GMT+09:00) Tokyo' => 'Asia/Tokyo',
        '(GMT+09:30) Adelaide' => 'Australia/Adelaide',
        '(GMT+09:30) Darwin' => 'Australia/Darwin',
        '(GMT+10:00) Brisbane' => 'Australia/Brisbane',
        '(GMT+10:00) Canberra' => 'Australia/Canberra',
        '(GMT+10:00) Guam' => 'Pacific/Guam',
        '(GMT+10:00) Hobart' => 'Australia/Hobart',
        '(GMT+10:00) Melbourne' => 'Australia/Melbourne',
        '(GMT+10:00) Port Moresby' => 'Pacific/Port_Moresby',
        '(GMT+10:00) Sydney' => 'Australia/Sydney',
        '(GMT+10:00) Yakutsk' => 'Asia/Yakutsk',
        '(GMT+11:00) Vladivostok' => 'Asia/Vladivostok',
        '(GMT+12:00) Auckland' => 'Pacific/Auckland',
        '(GMT+12:00) Fiji' => 'Pacific/Fiji',
        '(GMT+12:00) International Date Line West' => 'Pacific/Kwajalein',
        '(GMT+12:00) Kamchatka' => 'Asia/Kamchatka',
        '(GMT+12:00) Magadan' => 'Asia/Magadan',
        '(GMT+12:00) Marshall Is.' => 'Pacific/Fiji',
        '(GMT+12:00) New Caledonia' => 'Asia/Magadan',
        '(GMT+12:00) Solomon Is.' => 'Asia/Magadan',
        '(GMT+12:00) Wellington' => 'Pacific/Auckland',
        '(GMT+13:00) Nuku\'alofa' => 'Pacific/Tongatapu'
        );
        return view('ivr.ivrsetting.index',compact('ivr','timezones'));

    }


    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
           $request->validate([
            'timezone' => 'required',
            'twilio_voice' => 'required',
        ]);

        IvrSetting::create($request->all());

        return redirect()->route('ivrsetting.index')
                        ->with('success',' Ivr Setting created successfully.');

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validation = [
            'twilio_voice' => 'required'

        ];

        if($request->transfer_call == 1 && $request->ivr == 0){

                $validation = array_merge($validation, ['ivr_text' => 'required']);


        }
        if($request->transfer_call == 1 && $request->ivr == 1){
            if (empty($request->audio_data_file)) {
                $validation = array_merge($validation, ['ivr_mp3' => 'required']);
            }

        }
        if($request->transfer_call == 2 && $request->voicemail == 0){
                $validation = array_merge($validation, ['voicemail_text' => 'required']);

        }
        if($request->transfer_call == 2 && $request->voicemail == 1){
            if (empty($request->audio_data_file)) {
                $validation = array_merge($validation, ['voicemail_mp3' => 'required']);
            }

        }
        $validator = Validator::make(
            $request->all(), $validation
        );

        if($validator->fails())
        {
            return redirect()->back()->with('error', $validator->errors()->first());
        }

        $s3Client = new S3Client([
            'region' => get_aws_s3_bucket_credentials('AWS_DEFAULT_REGION'),
            'bucket' => get_aws_s3_bucket_credentials('AWS_BUCKET'),
            'version' => '2006-03-01',
                    'credentials' => [
                'key'    => get_aws_s3_bucket_credentials('AWS_ACCESS_KEY_ID'),
                'secret' => get_aws_s3_bucket_credentials('AWS_SECRET_ACCESS_KEY'),
            ],
        ]);
        $recorded_file = $ivr_audio_file =$recorded_file='';
        if (!empty($request->hasFile('ivr_mp3'))) {
            $fileNameToStore = 'ivr/'.time() . '.' . $request->ivr_mp3->getClientOriginalExtension();
            $file=$request->file('ivr_mp3');
            $result = $s3Client->putObject([
                                 'Bucket' => get_aws_s3_bucket_credentials('AWS_BUCKET'),
                                 'Key'    => $fileNameToStore,
                                 'SourceFile' => $file,
                                 'ACL'        => 'public-read',
                                 'ContentType' => 'audio/mpeg',
                         ]);
            $ivr_audio_file=!empty($result['ObjectURL']) ? $result['ObjectURL'] :'';
        }
        if (!empty($request->hasFile('voicemail_mp3'))) {
            $fileNameToStore = 'ivr/'.time() . '.' . $request->voicemail_mp3->getClientOriginalExtension();
            $file=$request->file('voicemail_mp3');
            $result = $s3Client->putObject([
                                 'Bucket' => get_aws_s3_bucket_credentials('AWS_BUCKET'),
                                 'Key'    => $fileNameToStore,
                                 'SourceFile' => $file,
                                 'ACL'        => 'public-read',
                                 'ContentType' => 'audio/mpeg',
                         ]);

            $voicemail_audio_file=!empty($result['ObjectURL']) ? $result['ObjectURL'] :'';

        }
        if (!empty($request->audio_data_file)) {
            $base64_encode = $request->audio_data_file;
               $attachment_parts = explode(";base64,", $base64_encode);
               $attachment_type_aux = explode("audio/", $attachment_parts[0]);
               $attachment_type = $attachment_type_aux[1];
               $attachment_base64 = base64_decode($attachment_parts[1]);
               $attachment_name = 'ivr/'."ivr". uniqid() . '.'.$attachment_type;
               $result = $s3Client->putObject([
                                'Bucket' => get_aws_s3_bucket_credentials('AWS_BUCKET'),
                                'Key'    => $attachment_name,
                                'Body' => $attachment_base64,
                                'ACL'        => 'public-read',
                                'ContentType' => 'audio/mpeg',
                        ]);

               $recorded_file=!empty($result['ObjectURL']) ? $result['ObjectURL'] :'';

       }

        $request['user_id'] = Auth::id();

        $data = array();
        $data['timezone'] = $request->timezone;
        $data['twilio_voice'] = $request->twilio_voice;
        $data['transfer_call'] = $request->transfer_call;
        $data['voicemail'] = $request->voicemail;
        $data['voicemail_text'] = $request->voicemail_text;
        $data['ivr'] = $request->ivr;
        $data['ivr_text'] = $request->ivr_text;
        if(!empty($voicemail_audio_file)){
            $data['voicemail_mp3'] = $voicemail_audio_file;
        }else{
            $data['voicemail_mp3'] = $recorded_file;
        }
        if(!empty($ivr_audio_file)){
            $data['ivr_mp3'] = $ivr_audio_file;
        }else{
            $data['ivr_mp3'] = $recorded_file;
        }
        if(!empty($request->id)){
            $ivr = IvrSetting::find($request->id);
            if(!empty($ivr)){
                $ivr->update($data);
                return redirect()->back()->with('success', __('Ivr Setting Saved successfully.'));
            }
        }else{
                IvrSetting::create($data);
                return redirect()->back()->with('success', __('Ivr Setting Saved successfully.'));

        }

    }

    /**
     * Display the specified resource.
     *
     * @param  \App\IvrSetting  $ivrSetting
     * @return \Illuminate\Http\Response
     */
    public function show(IvrSetting $ivrSetting)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\IvrSetting  $ivrSetting
     * @return \Illuminate\Http\Response
     */
    public function edit(IvrSetting $ivrSetting)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\IvrSetting  $ivrSetting
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, IvrSetting $ivrSetting)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\IvrSetting  $ivrSetting
     * @return \Illuminate\Http\Response
     */
    public function destroy(IvrSetting $ivrSetting)
    {
        //
    }

    public function twilio_numbers(Request $request){

        if ($request->ajax()){
                $data = TwilioNumber::where('user_id',auth()->user()->id);
                return Datatables::of($data)
                    ->addIndexColumn()
                    ->addColumn('action', function($data){

                           $btn = '<a data-url="' . route('ivrsetting.cancelNumber',$data->id) . '" href="javascript:void(0)" class="btn btn-sm bg-danger-light delete_record_model">Delete</a>';
                            return $btn;
                    })
                    ->rawColumns(['action'])
                    ->make(true);
        }else{
            return view('ivr.twilio_numbers');
        }
    }
    public function all_twilio_numbers(Request $request){

        if ($request->ajax()){
                $data = TwilioNumber::select('twilio_numbers.*','users.name')->Join('users', 'users.id', '=', 'twilio_numbers.user_id')->where('user_id','!=',0);
                return Datatables::of($data)
                    ->addIndexColumn()
                      ->filterColumn('user', function ($query, $keyword) use ($request) {
                    $sql = 'users.name like  ? OR twilio_numbers.number like ? ';
                    $query->whereRaw($sql,["%{$keyword}%","%{$keyword}%"]);
                })
                    ->addColumn('user', function($row){
                        $data=\App\User::find($row->user_id);
                                return '<h2 class="table-avatar">
                                                <a href="' . route('profile', ['id' => encrypted_key($data->id, 'encrypt')]) . '" class="avatar avatar-sm mr-2"><img class="avatar-img rounded-circle" src="' . $data->getAvatarUrl() . '" alt="Image"></a>
                                                <a href="' . route('profile', ['id' => encrypted_key($data->id, 'encrypt')]) . '">' . $data->name . '</a>
                                            </h2>';
                    })
                    ->addColumn('created_at', function ($data) {
                                return !empty($data->created_at) ? (date('jS F, Y', strtotime($data->created_at)) . '<br><small>' . date('h:i a', strtotime($data->created_at)) . '</small>') :'--';
                            })
                    ->addColumn('action', function($data){

                           $btn = '<a data-url="' . route('ivrsetting.cancelNumber',$data->id) . '" href="javascript:void(0)" class="btn btn-sm bg-danger-light delete_record_model">Delete</a>';
                            return $btn;
                    })
                    ->rawColumns(['user','created_at'])
                    ->make(true);
        }else{
            return view('ivr.twilio_numbers_all');
        }
    }
    public function cancelNumber(Request $request){
        $result = TwilioNumber::where("id" ,$request->number_id)->first();
        if(!empty($result)){
            $twilio_key = SiteSettings::select('value')->where('name','twilio_key')->where('user_id',1)->first();
            if(!empty($twilio_key)){
                $twilio_keys = json_decode($twilio_key->value,true);
                $accountsid = $twilio_keys['twilio_account_sid'];
                $authtoken=$twilio_keys['twilio_auth_token'];
            }else{

                $accountsid = '';
                $authtoken='';
            }
            $client = new Client($accountsid, $authtoken);
            $incomingPhoneNumbers = $client->incomingPhoneNumbers->read(array("phoneNumber" => $result->number),20);
            foreach ($incomingPhoneNumbers as $record) {
                $numbersid = $record->sid;
            }
            $client->incomingPhoneNumbers($numbersid)->delete();
            TwilioNumber::where('id',$result->id)->delete();
            return redirect()->back()->with('success', __('You have successfully deactivated your number.'));
        }

    }
    public function buy_ivr_number(Request $request){
        $html ="";

        if(!empty($request->area_code)){

            $area_code = $request->area_code;
            $twilio_key = SiteSettings::select('value')->where('name','twilio_key')->where('user_id',1)->first();
            if(!empty($twilio_key)){
                $twilio_keys = json_decode($twilio_key->value,true);
                $accountsid = $twilio_keys['twilio_account_sid'];
                $authtoken=$twilio_keys['twilio_auth_token'];
            }else{

                $accountsid = '';
                $authtoken='';
            }
           $twilio_key = SiteSettings::select('value')->where('name','twilio_key')->where('user_id',1)->first();
            if(!empty($twilio_key)){
                $twilio_keys = json_decode($twilio_key->value,true);
                $accountsid = $twilio_keys['twilio_account_sid'];
                $authtoken=$twilio_keys['twilio_auth_token'];
            }else{

                $accountsid = '';
                $authtoken='';
            }


            $client = new Client($accountsid, $authtoken);
            if( $request->type == 'local'){
                $numbers = $client->availablePhoneNumbers('US')->local->read(
                    array("areaCode" =>  $area_code)
                );
            }else{
                $numbers = $client->availablePhoneNumbers('US')->tollFree->read(
                    array("areaCode" => $area_code)
                );
            }
            if(!empty($numbers)) {

                foreach ($numbers as $key => $value) {
                    if ($value->capabilities['voice']) {
                        $voice = 1;
                    } else {
                        $voice = 0;
                    }
                    if ($value->capabilities['SMS']) {
                        $sms = 1;
                    } else {
                        $sms = 0;
                    }
                    if ($value->capabilities['MMS']) {
                        $mms = 1;
                    } else {
                        $mms = 0;
                    }
                    if ($value->capabilities['fax']) {
                        $fax = 1;
                    } else {
                        $fax = 0;
                    }
                    if ($value->postalCode != '') {
                        $postalCode = ',' . $value->postalCode;
                    } else {
                        $postalCode = '';
                    }
                    if(isset($request->for_bot) && $request->for_bot == 1){
                        $for_bot =1;
                    }else{
                        $for_bot = 0;
                    }

                    $html .= '<tr><td>' . $value->friendlyName . '</td><td>' . $value->region . ', ' . $value->isoCountry . ' ' . $postalCode . '</td><td class="float-left"><button onclick="buyNumber(' . $value->phoneNumber . ',' . $voice . ',' . $sms . ',' . $mms . ',' . $fax . ','.$for_bot.')" class="btn btn-success" type="button"  data-toggle="tooltip" title="Buy Now">Buy</button></td></tr>';
                }
            }
        }else{
            $html .='<tr><td colspan="3" class="text-center">No Record Found</td></tr>';
        }
        return view('ivr.buy_number',compact('html'));
    }
    public function post_buy_number(Request $request){
        $user = Auth::user();
        $twilio_key = SiteSettings::select('value')->where('name','twilio_key')->where('user_id',1)->first();
        if(!empty($twilio_key)){
            $twilio_keys = json_decode($twilio_key->value,true);
            $accountsid = $twilio_keys['twilio_account_sid'];
            $authtoken=$twilio_keys['twilio_auth_token'];
        }else{

            $accountsid = '';
            $authtoken='';
        }
        $client = new Client($accountsid, $authtoken);

        $phone = '+'.$request->num;
        $just_domain = preg_replace("/^(.*\.)?([^.]*\..*)$/", "$2", $_SERVER['HTTP_HOST']);
        $name = $user->name. ' IVR Number';
        $url = 'https://'.$just_domain.'/api/call/support';
        $voiceMethod = 'GET';


        $number = $client->incomingPhoneNumbers
            ->create(
                array(
                    "phoneNumber" => $request->num
                )
            );
        $array = array(
            "friendlyName" => $name,
            "phoneNumber" => $phone,
            "voiceMethod" => $voiceMethod,
            "voiceUrl" => $url
        );
        $incoming_phone_number = $client->incomingPhoneNumbers
            ->create($array);

        $client->incomingPhoneNumbers($incoming_phone_number->sid)
            ->update(array(
                    "voiceUrl" => $url,
                    "friendlyName" =>$name,
                    "voiceMethod" => $voiceMethod,
                )
            );
        $data = array();
        $data["number"] = '+'.$request->num;
        $data["sid"] =  $incoming_phone_number->sid;
        $data['user_id'] = $user->id;
        TwilioNumber::insert($data);
        return redirect()->route('ivrsetting.twilio_numbers')->with('success', __('You have successfully activated number.'));

    }

    public function migrate(Request $request){
        if(!empty($request->sid)){
            $data = array();
            $user = Auth::user();
            $twilio_key = SiteSettings::select('value')->where('name','twilio_key')->where('user_id',1)->first();
            if(!empty($twilio_key)){
                $twilio_keys = json_decode($twilio_key->value,true);
                $accountsid = $twilio_keys['twilio_account_sid'];
                $authtoken=$twilio_keys['twilio_auth_token'];
            }else{

                $accountsid = '';
                $authtoken='';
            }
            $client = new Client($accountsid, $authtoken);
			$just_domain = preg_replace("/^(.*\.)?([^.]*\..*)$/", "$2", $_SERVER['HTTP_HOST']);
            $url = 'https://'.$just_domain.'/api/call/support';
            $name = $user->name. ' IVR Number';
            try{
                $phone_data = $client->incomingPhoneNumbers($request->sid)
                    ->update(array(
                            "voiceUrl" => $url,
                            "friendlyName" =>$name,
                            "voiceMethod" => "GET",
                        )
                    );
                $data['number'] = $phone_data->phoneNumber;
                $data['user_id'] = $user->id;
                $data['sid'] = $request->sid;
                $check_number = TwilioNumber::where('sid',$request->sid)->where('user_id',auth()->user()->id)->first();
                if(!empty($check_number)){
                    TwilioNumber::where('id',$check_number->id)->update($data);
                }else{
                    TwilioNumber::insert($data);
                }
                return redirect()->route('ivrsetting.twilio_numbers')->with('success', __('You have successfully activated number.'));
            }catch(\Exception $e){
                return redirect()->back()->with('danger', __('SID is not vaild.Please try agian.'));
            }
        }
    }

    public function voiceNotificationIndex(Request $request){
        $twilio_setting = IvrSetting::where('user_id',Auth::id())->first();
        return view('ivr.ivrsetting.voice-notification',compact('twilio_setting'));
    }

    public function voiceNotificationPost(Request $request){
         $validation = [];

        if($request->notification == 2){
                $validation = array_merge($validation, ['email' => ['required', 'string', 'email', 'max:255','regex:/(.+)@(.+)\.(.+)/i'],'email_template' => 'required']);

        }
        if($request->notification == 3){
                $validation = array_merge($validation, ['mobile' => 'required|regex:/[0-9]{9}/','sms_template' => 'required']);

        }
        $validator = Validator::make(
            $request->all(), $validation
        );

        if($validator->fails())
        {
            return redirect()->back()->with('error', $validator->errors()->first());
        }
        if(empty($request->id)) {
            if(IvrSetting::create($request->all())){
                return redirect()->back()->with('success', __('Ivr Setting Saved successfully.'));
            }
        }else{
            $ivr = IvrSetting::find($request->id);
            if(!empty($ivr)){
                $ivr->update($request->all());
                return redirect()->back()->with('success', __('Ivr Setting Saved successfully.'));
            }
        }
    }

    public function blackList(Request $request){
        if ($request->ajax()) {
            $data = Blacklist::select('id','type','value','status','created_at')->where('user_id',Auth::user()->id);
            return Datatables::of($data)
                ->addIndexColumn()
                ->filterColumn('type', function($query, $keyword) use ($request) {
                    $query->orWhere('blacklist.type', 'LIKE', '%' . $keyword . '%')
                    ->orWhere('blacklist.value', 'LIKE', '%' . $keyword . '%')
                    ->orWhere('blacklist.status', 'LIKE', '%' . $keyword . '%')
                    ->orWhere('blacklist.created_at', 'LIKE', '%' . $keyword . '%')
                   ;
                })
                ->addColumn('type', function ($data) {
                    return $data->type==1 ?  'Country' : 'Mobile';

                 })
                 ->addColumn('value', function ($data) {
                     if($data->type == 1){
                        foreach(Country::getAllCountries() as $country_fips => $country_name){
                            if($data->value == $country_fips){
                                return $country_name ?? "NA";
                            }
                        }
                     }else{
                         return $data->value ?? "NA";
                     }
                 })
                 ->addColumn('status', function ($data) {
                    return $data->status==1 ? '<span class="badge badge-dot badge-success mr-4">
                    <i class=" bg-success "></i>
                    <span class="status"> Active</span>
                    </span>' : ' <span class="badge badge-dot badge-danger mr-4">
                    <i class=" bg-danger "></i>
                    <span class="status"> Inactive</span>
                    </span>';
                 })
                 ->addColumn('created_at', function ($data) {
                    return  Date('d-m-Y',strtotime($data->created_at)) ?? "NA";
                 })

                ->addColumn('action', function($data){
                    $actionBtn = '
                            <a href="'.url("ivr/black-list/create".encrypted_key($data->id,'encrypt')).'" class="action-item px-2" data-toggle="tooltip" data-original-title="'.__('Edit').'">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                 <a href="javascript::void(0);" class="action-item text-danger px-2 destroyblog" data-id="'.$data->id.'" data-toggle="tooltip" data-original-title="'.__('Delete').'">
                                            <i class="fas fa-trash-alt"></i>
                                        </a>';
                    return $actionBtn;
                })
                ->rawColumns(['action','status'])
                ->make(true);
                return view('ivr.black_list');
        }
        return view('ivr.ivrsetting.blacklist.blackList');
    }


    /* Create form, Edit form and Add and Update records from this function */
    public function createBlackList(Request $request, $blacklistId = null){

        if($request->isMethod('POST') ){ // check the post requests here
            if($request->type == 1){
                $validator = Validator::make($request->all(),[
                    'type' =>  'required',
                    'value' => "required",
                    'status' => 'required'
                ],[
                    'value.required' => 'Please select country',
                ]);
            }else{
                $validator = Validator::make($request->all(),[
                    'type' =>  'required',
                    'value' => "required",
                    'status' => 'required'
                ],[
                    'value.required' => 'Please select mobile number',
                ]);

            }

            if($validator->fails()){
                return redirect()->back()->with('error', $validator->errors()->first());
            }
            $data = $request->except('_token');
            // check the request is for update or add blacklist records
            if(!empty($request->blacklist_id)){
                $updateData = array();
                $updateData['user_id'] = Auth::user()->id;
                $updateData['type'] = $request->type;
                if($request->type ==2){
                    $updateData['value'] = ($request->phone??$request->value);
                }else{
                    $updateData['value'] = $request->value;
                }
                $updateData['status'] = $request->status;
                Blacklist::whereId($request->blacklist_id)->update($updateData);
                return redirect()->route('blackList')->with('success', _('Blacklist Updated Successfully'));
            }else{
                $data = array();
                $data['user_id'] = Auth::user()->id;
                $data['type'] = $request->type;
                if($request->type ==2){
                    $updateData['value'] = ($request->phone??$request->value);
                }else{
                    $updateData['value'] = $request->value;
                }
                $data['status'] = $request->status;
                Blacklist::create($data);
                return redirect()->route('blackList')->with('success', _('Blacklist Created Successfully'));
            }
        }
        $countries = Country::getAllCountries();
        if(isset($blacklistId) && $blacklistId != null ){ // for edit form request from this condition true
            $blacklistData = BlackList::whereId(encrypted_key($blacklistId,'decrypt'))->first();
            return view('ivr.ivrsetting.blacklist.create', compact('countries','blacklistId','blacklistData'));
        }
        return view('ivr.ivrsetting.blacklist.create', compact('countries')); // for add form from here request true
    }
    /*  Delete Black List Records  */
    public function ivrDestroyBlackList(Request $request){
        $destroy = BlackList::find($request->blacklist_id);
        $destroy->delete();
        return redirect()->route('blackList')->with('success', _('Blacklist Deleted Successfully'));
    }


    // public function afterHoursList(Request $request){
    //     $afterHours = IvrSetting::first();
    //     return view('ivr.ivrsetting.afterhour.afterhour', compact('afterHours'));
    // }
    public function afterHoursPost(Request $request){

        if($request->isMethod('POST')){

            if($request->out_of_hour ==1){
                if(empty($request->saturday) && empty($request->friday) && empty($request->thursday) && empty($request->wednesday) && empty($request->tuesday) && empty($request->monday)&& empty($request->sunday)) {
                    return redirect()->back()->with('error', 'Please select day');
                }else if($request->sunday==1){

                    $validator = Validator::make($request->all(),[
                        'sunday_start' =>  'required',
                        'sunday_end' => "required",
                    ],[
                        'sunday_start.required' => 'Please select Sunday start time',
                        'sunday_end.required' => 'Please select Sunday end time'
                    ]);

                    if($validator->fails()){
                        return redirect()->back()->with('error', $validator->errors()->first());
                    }
                }else if($request->monday==1){
                    $validator = Validator::make($request->all(),[
                        'monday_start' =>  'required',
                        'monday_end' => "required",
                    ],[
                        'monday_start.required' => 'Please select Monday start time',
                        'monday_end.required' => 'Please select Monday end time'
                    ]);
                    if($validator->fails()){
                        return redirect()->back()->with('error', $validator->errors()->first());
                    }
                }else if($request->tuesday==1){
                    $validator = Validator::make($request->all(),[
                        'tuesday_start' =>  'required',
                        'tuesday_end' => "required",
                    ],[
                        'tuesday_start.required' => 'Please select Tuesday start time',
                        'tuesday_end.required' => 'Please select Tuesday end time'
                    ]);
                    if($validator->fails()){
                        return redirect()->back()->with('error', $validator->errors()->first());
                    }
                }else if($request->wednesday==1){
                    $validator = Validator::make($request->all(),[
                        'wednesday_start' =>  'required',
                        'wednesday_end' => "required",
                    ],[
                        'wednesday_start.required' => 'Please select wednesday start time',
                        'wednesday_end.required' => 'Please select wednesday end time'
                    ]);
                    if($validator->fails()){
                        return redirect()->back()->with('error', $validator->errors()->first());
                    }
                }else if($request->thursday==1){
                    $validator = Validator::make($request->all(),[
                        'thursday_start' =>  'required',
                        'thursday_end' => "required",
                    ],[
                        'thursday_start.required' => 'Please select thursday start time',
                        'thursday_end.required' => 'Please select thursday end time'
                    ]);
                    if($validator->fails()){
                        return redirect()->back()->with('error', $validator->errors()->first());
                    }
                }else if($request->friday==1){
                    $validator = Validator::make($request->all(),[
                        'friday_start' =>  'required',
                        'friday_end' => "required",
                    ],[
                        'friday_start.required' => 'Please select friday start time',
                        'friday_end.required' => 'Please select friday end time'
                    ]);
                    if($validator->fails()){
                        return redirect()->back()->with('error', $validator->errors()->first());
                    }
                }else if($request->saturday==1){
                    $validator = Validator::make($request->all(),[
                        'saturday_start' =>  'required',
                        'saturday_end' => "required",
                    ],[
                        'saturday_start.required' => 'Please select saturday start time',
                        'saturday_end.required' => 'Please select saturday end time'
                    ]);
                    if($validator->fails()){
                        return redirect()->back()->with('error', $validator->errors()->first());
                    }
                }

                if(empty($request->out_of_hour_type)){

                    $validator = Validator::make($request->all(),[
                        'out_of_hour_text' =>  'required'
                    ],[
                        'out_of_hour_text.required' => 'Please enter tts'
                    ]);
                    if($validator->fails()){
                        return redirect()->back()->with('error', $validator->errors()->first());
                    }
                }else if($request->out_of_hour_type == 1){

                    if($request->file('out_of_hour_mp3')==null && empty($request->audio_data_file)){
                        $validator = Validator::make($request->all(),[
                            'out_of_hour_mp3' =>  'required',
                        ],[
                            'out_of_hour_mp3.required' => 'Please select MP3'
                        ]);
                    }
                    if($validator->fails()){
                        return redirect()->back()->with('error', $validator->errors()->first());
                    }
                }
            }




            $out_of_hour_mp3 = $recorded_file = "";
            $s3Client = new S3Client([
                'region' => get_aws_s3_bucket_credentials('AWS_DEFAULT_REGION'),
                'bucket' => get_aws_s3_bucket_credentials('AWS_BUCKET'),
                'version' => '2006-03-01',
                        'credentials' => [
                    'key'    => get_aws_s3_bucket_credentials('AWS_ACCESS_KEY_ID'),
                    'secret' => get_aws_s3_bucket_credentials('AWS_SECRET_ACCESS_KEY'),
                ],
            ]);
            if($request->hasFile('imageFile')){
                if (!empty($request->hasFile('imageFile'))) {
                    $fileNameToStore = 'ivr/'.time() . '.' . $request->imageFile->getClientOriginalExtension();
                    $file=$request->file('mp3');
                    $result = $s3Client->putObject([
                                            'Bucket' => get_aws_s3_bucket_credentials('AWS_BUCKET'),
                                            'Key'    => $fileNameToStore,
                                            'SourceFile' => $file,
                                            'ACL'        => 'public-read',
                                            'ContentType' => 'audio/mpeg',
                                    ]);
                    $out_of_hour_mp3 =!empty($result['ObjectURL']) ? $result['ObjectURL'] :'';
                }
            }
            if (!empty($request->audio_data_file)) {
                $base64_encode = $request->audio_data_file;
                   $attachment_parts = explode(";base64,", $base64_encode);
                   $attachment_type_aux = explode("audio/", $attachment_parts[0]);
                   $attachment_type = $attachment_type_aux[1];
                   $attachment_base64 = base64_decode($attachment_parts[1]);
                   $attachment_name = 'ivr/'."ivr". uniqid() . '.'.$attachment_type;
                   $result = $s3Client->putObject([
                                    'Bucket' => get_aws_s3_bucket_credentials('AWS_BUCKET'),
                                    'Key'    => $attachment_name,
                                    'Body' => $attachment_base64,
                                    'ACL'        => 'public-read',
                                    'ContentType' => 'audio/mpeg',
                            ]);

                   $recorded_file=!empty($result['ObjectURL']) ? $result['ObjectURL'] :'';

           }

            if(isset($request->id) && $request->id != null ){
                $data = array();
                $data['sunday'] = json_encode(array('sunday' => ($request->sunday ??''),'sunday_start' => (date("H:i", strtotime($request->sunday_start)) ??''), 'sunday_end' => (date("H:i", strtotime($request->sunday_end)) ??'')));
                $data['monday'] = json_encode(array('monday' => ($request->monday??''),'monday_start' => (date("H:i", strtotime($request->monday_start)) ??''), 'monday_end' => (date("H:i", strtotime($request->monday_end)) ??'')));
                $data['tuesday'] = json_encode(array('tuesday' => ($request->tuesday??''),'tuesday_start' => (date("H:i", strtotime($request->tuesday_start))??''), 'tuesday_end' => (date("H:i", strtotime($request->tuesday_end)) ??'')));
                $data['wednesday'] = json_encode(array('wednesday' => ($request->wednesday??''),'wednesday_start' => (date("H:i", strtotime($request->wednesday_start)) ??''), 'wednesday_end' => (date("H:i", strtotime($request->wednesday_end))??'')));
                $data['thursday'] = json_encode(array('thursday' => ($request->thursday ??''),'thursday_start' => (date("H:i", strtotime($request->thursday_start ))??''), 'thursday_end' => (date("H:i", strtotime($request->thursday_end)) ??'')));
                $data['friday'] = json_encode(array('friday' => ($request->friday??''),'friday_start' => (date("H:i", strtotime($request->friday_start)) ??''), 'friday_end' => (date("H:i", strtotime($request->friday_end ))?? '')));
                $data['saturday'] = json_encode(array('saturday' => ($request->saturday??''),'saturday_start' =>(date("H:i", strtotime($request->saturday_start))  ??''), 'saturday_end' => (date("H:i", strtotime($request->saturday_end)) ??'')));
                $afterHours = IvrSetting::find($request->id);
                $data['out_of_hour'] = $request->out_of_hour ? $request->out_of_hour : 0;
                $data['out_of_hour_mp3'] = ($out_of_hour_mp3 ?? $recorded_file);
                $data['out_of_hour_type'] = $request->out_of_hour_type;
                $data['out_of_hour_text'] = $request->out_of_hour_text;
                $data['user_id'] = Auth::user()->id;
                if(!empty($afterHours)){
                    $afterHours->update($data);
                }
            }else{

                $data = array();
                $data['user_id'] = Auth::user()->id;
                $data['created_at'] = $request->created_at;
                $data['out_of_hour'] = $request->out_of_hour;
                $data['out_of_hour_type'] = $request->out_of_hour_type;
                $data['out_of_hour_text'] = $request->out_of_hour_text;
                $data['out_of_hour_mp3'] = ($out_of_hour_mp3 ?? $recorded_file);
                $data['sunday'] = json_encode(array('sunday' => ($request->sunday??''),'sunday_start' => (date("H:i", strtotime($request->sunday_start)) ??''), 'sunday_end' => (date("H:i", strtotime($request->sunday_end))??'')));
                $data['monday'] = json_encode(array('monday' => ($request->monday ??''),'monday_start' => (date("H:i", strtotime($request->monday_start)) ??''), 'monday_end' => (date("H:i", strtotime($request->monday_end)) ?? '')));
                $data['tuesday'] = json_encode(array('tuesday' => ($request->tuesday ?? ''),'tuesday_start' =>(date("H:i", strtotime($request->tuesday_start))??''), 'tuesday_end' => (date("H:i", strtotime($request->tuesday_end)) ??'')));
                $data['wednesday']= json_encode(array('wednesday' => ($request->wednesday  ?? ''),'wednesday_start' => (date("H:i", strtotime($request->wednesday_start)) ??''), 'wednesday_end' => (date("H:i", strtotime($request->wednesday_end)) ??'')));
                $data['thursday'] = json_encode(array('thursday' => ($request->thursday ??''),'thursday_start' => (date("H:i", strtotime($request->thursday_start)) ??''), 'thursday_end' => (date("H:i", strtotime($request->thursday_end)) ??'')));
                $data['friday'] = json_encode(array('friday' => ($request->friday ?? '' ),'friday_start' => (date("H:i", strtotime($request->friday_start)) ??''), 'friday_end' => (date("H:i", strtotime($request->friday_end)) ??'')));
                $data['saturday'] = json_encode(array('saturday' => ($request->saturday ??''),'saturday_start' => (date("H:i", strtotime($request->saturday_start)) ??''), 'saturday_end' => (date("H:i", strtotime($request->saturday_end)) ??'')));
                IvrSetting::create($data);
            }
         }
        $afterHours = IvrSetting::where('user_id',Auth::id())->first();
        return view('ivr.ivrsetting.afterhour.afterhour', compact('afterHours'));

    }

    public function call_logs(Request $request){
        if ($request->ajax()) {
            $data = CallLog::select('id','pfrom','phone','dialcallduration','direction','statusin','dialcallduration','recordingurl','startat','endat','dept_id')->where('user_id',Auth::user()->id);
             if (!empty($request->start_at)) {
                    $data->where('startat', '>=',$request->start_at);
            }
             if (!empty($request->end_at)) {
                    $data->where('endat', '<=',$request->end_at);
            }
            return Datatables::of($data)
                ->addIndexColumn()
                ->filterColumn('pfrom', function($query, $keyword) use ($request) {
                    $query->orWhere('call_logs.pfrom', 'LIKE', '%' . $keyword . '%')
                    ->orWhere('call_logs.phone', 'LIKE', '%' . $keyword . '%')
                    ->orWhere('call_logs.dialcallduration', 'LIKE', '%' . $keyword . '%')
                    ->orWhere('call_logs.recordingurl', 'LIKE', '%' . $keyword . '%')
                    ->orWhere('call_logs.startat', 'LIKE', '%' . $keyword . '%')
                    ->orWhere('call_logs.endat', 'LIKE', '%' . $keyword . '%');
                })
                ->addColumn('pfrom', function ($data) {
                    return MobileNumberFormat($data->pfrom);
                })
                ->addColumn('phone', function ($data) {
                    return MobileNumberFormat($data->phone);
                })->addColumn('dialcallduration', function ($data) {
                    return $data->dialcallduration;
                })->addColumn('statusin', function ($data) {
                    return $data->statusin;
                })->addColumn('recordingurl', function ($data) {
                    if(!empty($data->recordingurl)){
                        return '<div class="wrapperaudio" id="">
                            <audio preload="auto" controls class="audio"><source src="'. $data->recordingurl.'" type="audio/mpeg"></audio>
                        </div> .';
                    }
                })->addColumn('startat', function ($data) {
                    return Date('M d, Y h:i:s a',strtotime($data->startat));
                })->addColumn('endat', function ($data) {
                    return !empty($data->endat) ? Date('M d, Y h:i:s a',strtotime($data->endat)) :'--';
                })
                ->rawColumns(['recordingurl'])
                ->make(true);
        }else{
            return view('ivr.call_logs');
        }

    }
    public function voice_mail_logs(Request $request){
        if ($request->ajax()) {
            $data = CallLog::select('id','pfrom','phone','dialcallduration','direction','statusin','dialcallduration','recordingurl','startat','endat','dept_id')->where('user_id',Auth::user()->id)->where("voicemail",1);
            return Datatables::of($data)
                ->addIndexColumn()
                ->filterColumn('pfrom', function($query, $keyword) use ($request) {
                    $query->orWhere('call_logs.pfrom', 'LIKE', '%' . $keyword . '%')
                    ->orWhere('call_logs.phone', 'LIKE', '%' . $keyword . '%')
                    ->orWhere('call_logs.dialcallduration', 'LIKE', '%' . $keyword . '%')
                    ->orWhere('call_logs.recordingurl', 'LIKE', '%' . $keyword . '%')
                    ->orWhere('call_logs.startat', 'LIKE', '%' . $keyword . '%')
                    ->orWhere('call_logs.endat', 'LIKE', '%' . $keyword . '%');
                })
                ->addColumn('pfrom', function ($data) {
                    return MobileNumberFormat($data->pfrom);
                })
                ->addColumn('phone', function ($data) {
                    return MobileNumberFormat($data->phone);
                })->addColumn('dialcallduration', function ($data) {
                    return $data->dialcallduration;
                })->addColumn('statusin', function ($data) {
                    return $data->statusin;
                })->addColumn('recordingurl', function ($data) {
                    if(!empty($data->recordingurl)){
                        return '<div class="wrapperaudio" id="">
                            <audio preload="auto" controls class="audio"><source src="'. $data->recordingurl.'" type="audio/mpeg"></audio>
                        </div> .';
                    }
                })->addColumn('startat', function ($data) {
                    return Date('M d, Y h:i:s a',strtotime($data->startat));
                })->addColumn('endat', function ($data) {
                    return Date('M d, Y h:i:s a',strtotime($data->startat));
                })
                ->rawColumns(['recordingurl'])
                ->make(true);
        }else{
            return view('ivr.voice_mail_logs');
        }


    }

    public function department_list(Request $request){
        if ($request->ajax()) {
            $data = Department::latest();
            return DataTables::of($data)
            ->addIndexColumn()
            ->addColumn('forward', function($data){
                return !empty($data->forward) ? $data->forward : "NA";
            })
            ->addColumn('greeting', function($data){
                 if($data->greeting == 1){ return "MP3"; }elseif($data->calltype == 0 && $data->greeting == 0 ){ return "TTS"; }else{ return "NA"; }
            })
            ->addColumn('type', function($data){
                return ($data->calltype == 1) ? "Forward Number" : "Voicemail";
            })
            ->addColumn('status', function($data){
                return $data->status==1 ? '<span class="badge badge-dot badge-danger mr-4">
                <i class=" bg-danger "></i>
                <span class="status"> Inactive</span>
                </span>' : ' <span class="badge badge-dot badge-success mr-4">
                <i class=" bg-success "></i>
                <span class="status"> Active</span>
                </span>';
            })
            ->addColumn('extension', function($data){
                return $data->extension ?? "NA";
            })
            ->addColumn('action', function($data){
                $actionBtn = '
                        <a href="'.url("departments/edit/".encrypted_key($data->id,'encrypt')).'" class="btn btn-sm bg-success-light mt-1" data-toggle="tooltip" data-original-title="'.__('Edit').'">
                                        <i class="fas fa-edit"></i>
                                    </a>
                             <a data-url="' . url('departments/destroy',$data->id) . '" href="#" class="btn btn-sm bg-danger-light delete_record_model">
                                                    <i class="far fa-trash-alt"></i></a>';
                return $actionBtn;
            })

            ->rawColumns(['action','status'])
            ->make(true);
        }else{
            return view('ivr.department.index');
        }
    }

    public function add_department(Request $request){


        $mp3 = $recordmp3 ="";
        if($request->isMethod('post')){
            if($request->type==1){
                $validate = [
                    'name' =>  'required',
                    'forward_number' => "required"
                ];
               $validator = Validator::make($request->all(),$validate);
                if($validator->fails()){
                    return redirect()->back()->with('error', $validator->errors()->first());
                }
            }else{
                if($request->greetings==1){
                    if($request->file('mp3')==null && empty($request->audio_data_file)){
                        $validate = [
                            'name' =>  'required',
                            'mp3' => "required"
                        ];
                         $validator = Validator::make($request->all(),$validate);
                            if($validator->fails()){
                                    return redirect()->back()->with('error', $validator->errors()->first());
                            }
                    }

                }else{
                    $validate = [
                        'name' =>  'required',
                        'tts' => "required"
                    ];
                      $validator = Validator::make($request->all(),$validate);
                        if($validator->fails()){
                            return redirect()->back()->with('error', $validator->errors()->first());
                        }
                }
            }

            $s3Client = new S3Client([
                'region' => get_aws_s3_bucket_credentials('AWS_DEFAULT_REGION'),
                'bucket' => get_aws_s3_bucket_credentials('AWS_BUCKET'),
                'version' => '2006-03-01',
                        'credentials' => [
                    'key'    => get_aws_s3_bucket_credentials('AWS_ACCESS_KEY_ID'),
                    'secret' => get_aws_s3_bucket_credentials('AWS_SECRET_ACCESS_KEY'),
                ],
            ]);

            if($request->hasFile('mp3')){
                if (!empty($request->hasFile('mp3'))) {
                    $fileNameToStore = 'ivr/'.time() . '.' . $request->mp3->getClientOriginalExtension();
                    $file=$request->file('mp3');
                    $result = $s3Client->putObject([
                                            'Bucket' => get_aws_s3_bucket_credentials('AWS_BUCKET'),
                                            'Key'    => $fileNameToStore,
                                            'SourceFile' => $file,
                                            'ACL'        => 'public-read',
                                            'ContentType' => 'audio/mpeg',
                                    ]);
                    $mp3 =!empty($result['ObjectURL']) ? $result['ObjectURL'] :'';
                }
            }

            if (!empty($request->audio_data_file)) {
                $base64_encode = $request->audio_data_file;
                   $attachment_parts = explode(";base64,", $base64_encode);
                   $attachment_type_aux = explode("audio/", $attachment_parts[0]);
                   $attachment_type = $attachment_type_aux[1];
                   $attachment_base64 = base64_decode($attachment_parts[1]);
                   $attachment_name = 'ivr/'."ivr". uniqid() . '.'.$attachment_type;
                   $result = $s3Client->putObject([
                                    'Bucket' => get_aws_s3_bucket_credentials('AWS_BUCKET'),
                                    'Key'    => $attachment_name,
                                    'Body' => $attachment_base64,
                                    'ACL'        => 'public-read',
                                    'ContentType' => 'audio/mpeg',
                            ]);

                    $recordmp3=!empty($result['ObjectURL']) ? $result['ObjectURL'] :'';

            }
            if(isset($request->id) && isset($request->submit_type) && $request->submit_type == 'update'){

                $department = Department::whereId(encrypted_key($request->id,'decrypt'))
                ->update([
                    'name' => $request->name,
                    'twilio_voice' => $request->twilio_voice,
                    'calltype' => $request->type,
                    'greeting' => $request->greetings,
                    'tts' => $request->tts,
                    'mp3' => ($mp3 ?? $recordmp3),
                    'forward' =>  ($request->input('phone') ?? $request->forward_number),
                    'status' => $request->status,
                    'user_id' => auth()->user()->id,
                    'updated_at' => date('Y-m-d h:i:s', strtotime(now()))
                ]);
                return redirect()->route('ivr.department_list')->with('success', _('Department Updated Successfully'));

            }else{
                $checkExtension = Department::where('user_id',auth()->user()->id)->latest()->first();
                if(empty($checkExtension)){
                    $extension = 1;
                }else{
                    $extension = $checkExtension->extension+1;
                }

                $data = new Department;
                $data['name'] = ($request->input('name') ?? '');
                $data['twilio_voice'] = $request->twilio_voice;
                $data['mp3'] = ($mp3 ?? $recordmp3);
                $data['greeting'] = ($request->input('greetings') ?? '');
                $data['calltype'] = ($request->input('type') ?? '');
                $data['tts'] = ($request->input('tts') ?? '');
                $data['forward'] = ($request->input('phone') ?? $request->input('forward_number'));
                $data['status'] = ($request->input('status') ?? '');
                $data['created_at'] = date('Y-m-d h:i:s', strtotime(now())) ?? '';
                $data['user_id'] = auth()->user()->id ?? '';
                $data['extension'] = ($extension ?? '');



                $data->save();
                return redirect()->route('ivr.department_list')->with('success', _('Department Created Successfully'));
            }

        }else{
            return view('ivr.department.add');
        }
    }

    public function edit_department(Request $request, $department_id){
        $departmentData = Department::whereId(encrypted_key($department_id,'decrypt'))->whereUserId(auth()->user()->id)->first();
        return view('ivr.department.add', compact('department_id','departmentData'));
    }

    public function deleteDepartment(Request $request){
        $departmentData = Department::whereId($request->id)->whereUserId(auth()->user()->id)->delete();
        return redirect()->route('ivr.department_list')->with('success', _('Department Deleted Successfully'));
    }

    public function store_department(Request $request){

    }

    public function ivr(Request $request){
        
        if ($request->ajax() && !empty($request->blockElementsData)) {
                if (!empty($request->duration)) {
                    $tilldate = Carbon::now()->addMonth($request->duration)->toDateTimeString();
                }
                 $totalnumber =  TwilioNumber::where('user_id',Auth::user()->id);
                 if (!empty($tilldate)) {
                    $totalnumber->where("created_at", ">", $tilldate);
                }
        $totalnumber=$totalnumber->count();
                
        $totalvoicemails =  CallLog::where('user_id',Auth::user()->id)->where("recordingurl","!=", " ");
         if (!empty($tilldate)) {
                    $totalvoicemails->where("startat", ">", $tilldate);
                }
                        $totalvoicemails=$totalvoicemails->count();
        $totalincoming =  CallLog::where('user_id',Auth::user()->id)->where("direction", "inbound");
          if (!empty($tilldate)) {
                    $totalincoming->where("startat", ">", $tilldate);
                }
                        $totalincoming=$totalincoming->count();
        $totalminutes =  CallLog::where('user_id',Auth::user()->id);
         if (!empty($tilldate)) {
                    $totalminutes->where("startat", ">", $tilldate);
                }
                        $totalminutes=$totalminutes->get()->sum('dialcallduration');
        
                   return json_encode([
                    'incoming' => $totalincoming,
                    'voicemails' => $totalvoicemails,
                    'numbers' => $totalnumber,
                    'minutes' => $totalminutes,
                ]);
                
        }else{
        $seven_days      = Utility::getLastSevenDays();
        $home_data['totalnumber'] =  TwilioNumber::where('user_id',Auth::user()->id)->count();
        $home_data['voicemail_list'] =  CallLog::select('users.*','call_logs.*')->where('call_logs.user_id',Auth::user()->id)->where("call_logs.voicemail",1)->leftJoin('users', 'users.mobile', '=', 'call_logs.pfrom')->whereYear('call_logs.startat', Carbon::now()->year)->whereMonth('call_logs.startat', Carbon::now()->month)->orderBy('call_logs.id', 'desc')->take(5)->get();

        $home_data['totalvoicemails'] =  CallLog::where('user_id',Auth::user()->id)->whereYear('startat', Carbon::now()->year)->whereMonth('startat', Carbon::now()->month)->where("recordingurl","!=", " ")->count();
        $home_data['totalincoming'] =  CallLog::where('user_id',Auth::user()->id)->whereYear('startat', Carbon::now()->year)->whereMonth('startat', Carbon::now()->month)->where("direction", "inbound")->count();
        $home_data['totalminutes'] =  CallLog::where('user_id',Auth::user()->id)->whereYear('startat', Carbon::now()->year)->whereMonth('startat', Carbon::now()->month)->get()->sum('dialcallduration');
        $home_data['call_logs_list'] =  CallLog::select('users.*','call_logs.*')->where('call_logs.user_id',Auth::user()->id)->leftJoin('users', 'users.mobile', '=', 'call_logs.pfrom')->orderBy('call_logs.id', 'desc')->whereYear('call_logs.startat', Carbon::now()->year)->whereMonth('call_logs.startat', Carbon::now()->month)->take(5)->get();
        $calllogs_overview    = [];
        foreach($seven_days as $date => $day) {
            $calllogs_overview[__($day)] =  CallLog::where('user_id',Auth::user()->id)->where('direction','inbound')->whereDate('created_at',$date)->count();
        }
        $home_data['calllogs_overview']    = $calllogs_overview;
        return view('ivr.stats',compact('home_data'));
        }
    }

}
