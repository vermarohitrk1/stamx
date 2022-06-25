<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use App\User;
use App\Contacts;
use App\Plan;
use App\SiteSettings;
use Auth;
use Twilio\Rest\Client;
use Exception;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Auth\Events\Registered;
use App\Utility;
use Illuminate\Http\Request as PostRequest;
use indisposable;
class RegisterController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
    */

    use RegistersUsers;

    /**
     * Where to redirect users after registration.
     *
     * @var string
     */
    protected $redirectTo = RouteServiceProvider::HOME;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest');
    }


	public function register(postRequest $postRequest)
{
    $this->validator($postRequest->all())->validate();
    event(new Registered($user = $this->create($postRequest->all())));
    return $this->registered($postRequest,$user) ?: redirect('/signup/verify?phone='.$postRequest->phone);
}

public function registerpetition($data)
{
   return $this->create($data);
}

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        return Validator::make($data, [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email','indisposable', 'max:255', 'unique:users',
                  function ($attribute, $value, $fail) {

                if(empty(check_email_is_valid($value))){
                $fail('The '.$attribute.' is invalid.');
                }
            }
                ],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ]);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return \App\User
     */
    protected function create(array $data)
    {

         $user = get_domain_user();
            $user_id = !empty($user->id) ? $user->id:0;
            if(!empty($data['role'])){
				 $type = $data['role'];
				if($data['role'] =='corporate'){
                    $role_permissions= get_role_data($data['role'], "permissions");
					
					// if(in_array("manage_sub_domain", $role_permissions)){
						
                        // $sub_name= substr($data['name'],0,3);
                        // $sub_number=    rand(10,999);
                        // $custom_url= $sub_name.$sub_number;
                    // }else{
                        // if($type=="admin"){
                             // $custom_domain= env('MAIN_URL');
                        // }
                    // }	
				}
                   

            }else{
                 $type = 'admin';
    		 $custom_domain= env('MAIN_URL');
            }
            if(!empty($data['volunteer']) &&  $data['volunteer'] =='on'){
                $volunteer = 1;
                $volunteer_user= \App\Contacts::create_contact($data, 'Volunteer');

            }else{
                $volunteer = 0;
            }

        $created_user= User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'mobile' => $data['phone']??'',
            'type' => strtolower($type),
            'created_by' => $user_id,
            'password' => Hash::make($data['password']),
            'volunteer' => $volunteer,

        ]);
        
        //to create new instructor
         if(!empty($data['instructor']) &&  $data['instructor'] =='on'){
                $current_domain_id= get_domain_id();
                $existinstructor= \App\Instructor::where('user_id',$created_user->id)->first();
                if(empty($existinstructor)){
                        $instructor = new \App\Instructor();
                        $instructor['user_id'] = $created_user->id;
                        $instructor['created_by'] = $user_id;
                        $instructor['domain_id'] = $current_domain_id;
                        $instructor->save();
                }

            }
            
        //send email template
        $userdata= \App\User::find($created_user->id);
            $emalbody=[
                'Registered Email'=>$userdata->email,
                 'Password'=>$data['password'],
                'Login Url'=>url('login'),
            ];

            $resp = \App\Utility::send_emails($userdata->email, $userdata->name, null, $emalbody,'registration',$userdata);


        //creating sub domain
        $domain_data=array(
             'user_id' => $created_user->id
        );
        if(!empty($custom_url)){
            $domain_data['custom_url']=$custom_url;
        }
		
        if(!empty($custom_domain)){
            $domain_data['domain']=$custom_domain;
        }
        if(!empty($domain_data['domain']) || !empty($domain_data['custom_url']) ){
        \App\UserDomain::create($domain_data);
        }

        if(!empty($data['petition'])){
            return $created_user->id;
        }


	if( $created_user){
		$this->code = $this->generateCode();

		if($this->code){
		try {
		$twilio = SiteSettings::where('name', 'twilio_key')->where('user_id', 1)->first();
		$twilio = json_decode($twilio->value,true);

		$client = new Client($twilio['twilio_account_sid'], $twilio['twilio_auth_token']);

		$client->messages->create($data['phone'], [
			'from' => $twilio['twilio_number'],
			'body' => "Your verification code is {$this->code}"]);

		 $created_user->code=$this->code;
		  $created_user->save();
		} catch (\Exception $ex) {

		return $ex; //enable to send SMS
		}
		return true;
		}
	}



        // Auth::loginUsingId($created_user->id);
    //    return $created_user;
    }

	   public function showCodeForm()
    {

        return view("auth.verifysignup");
    }

	  public function storeCodeForm(postRequest $postRequest){


		   if($user=User::where('code',$postRequest->code)->first()){
            $user->is_active=1;
            $user->code=null;
            $user->save();
          Auth::loginUsingId($user->id);
		  return redirect('home');
       // return $user;
        }
        else{

			    return back()->with('error', __('Invalid verify code'));
        }


	  }
	    public function registerClient(PostRequest $postRequest){

		 $user = get_domain_user();
            $user_id = !empty($user->id) ? $user->id:0;

            $validator = self::validator($postRequest->toArray());
              if($validator->fails()){
                  return response()->json($validator->errors(),422);
              }


        try {
            $postData = $postRequest->all();


			 if(!empty($postData['userType'])){
                if($postData['userType'] =='mentor'){

				$userRole="mentor";
				}
				else{

					$userRole="mentee";
				}
                    $type = $userRole;
                    $role_permissions= get_role_data($postData['userType'], "permissions");
                    if(in_array("manage_sub_domain", $role_permissions)){
                        $sub_name= substr($postData['name'],0,3);
                        $sub_number=    rand(10,999);
                        $custom_url= $sub_name.$sub_number;
                    }else{
                        if($type=="admin"){
                             $custom_domain= env('MAIN_URL');
                        }
                    }

            }else{
                 $type = 'admin';
    		 $custom_domain= env('MAIN_URL');
            }
            $response = [];
            $response['success'] = false;
            $response['message'] = "";
            $response['email'] = "";
            $response['name'] = "";
			$user= User::create([
			'name' => $postData['name'],
			'email' => $postData['email'],
			'type' => strtolower($type),
			'created_by' => $user_id,
			'password' => Hash::make($postData['password']),
			]);

             $userdata= \App\User::find($user->id);
            $emalbody=[
                'Registered Email'=>$userdata->email,
                'Login Url'=>url('login'),
            ];

            $resp = \App\Utility::send_emails($userdata->email, $userdata->name, null, $emalbody,'registration',$userdata);

            if($user && $user->id){
                Auth::loginUsingId($user->id);
                $planData = Plan::find($postData['plan_id']);
				if(!empty($planData)){
					if($postData['plan_type']=='week'){
						$planprice=$planData->weekly_price + $planData->setup_fee;
					}
					elseif($postData['plan_type']=='year'){
							$planprice=$planData->annually_price + $planData->setup_fee;
					}
					else{

						$planprice=$planData->monthly_price + $planData->setup_fee;
					}

				}

                $response['success'] = true;
                $response['message'] = "User created successfully";
                $response['email'] = $user->email;
                $response['name'] = $user->name;
                $response['plan_data']['plan_id'] = \Illuminate\Support\Facades\Crypt::encrypt($planData->id);
                $response['plan_data']['plan_name'] = $planData->name;
                $response['plan_data']['price'] = env('CURRENCY').$planprice;
                $response['plan_data']['duration'] = $postData['plan_type'];
            }
        }
        catch (\Exception $ex){
            $response['message'] = $ex->getMessage();
        }


        return response()->json($response);
    }

	  public function generateCode($codeLength = 3)
    {
        $min = pow(10, $codeLength);
        $max = $min * 10 - 1;
        $code = mt_rand($min, $max);

        return $code;
    }
	
		public function regclient(){
		 return view('auth.mentee');
		
	}
//    public function showRegistrationForm()
//    {
//         return view('auth.mentor-register');
//    }
}
