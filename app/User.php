<?php

namespace App;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Passport\HasApiTokens;
use Carbon\Carbon;
use App\Plan;
use Ansezz\Gamify\Traits\Gamify;
// use Ansezz\Gamify\Gamify;
use DB;
class User extends Authenticatable
{
    use HasApiTokens, Notifiable, Gamify;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'email', 
        'name', 
        'type',
        'nickname',
        'dob',
        'education_id',
        'blood_group',
        'gender',
        'mobile',
        'about',
        'address1',
        'address2',
        'city',
        'state',
        'postal_code',
        'country',
        'avatar',
        'created_by',
        'is_active',
        'login_status',
        'average_rating',
        'profile_completion_percentage',
        'email_verified_at',
        'password',
        'device_token',
        'address_lat',
        'address_long',
        'company',
        'customfield',
        'corporate_country',
        'corporate_address1',
        'corporate_city',
        'corporate_state',
        'corporate_postal_code',
        'email_notification',
        'sms_notification',
        'wallet_balance',
        'education_id',
        'tax_id',
        'fiftyzeroonec',

    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];
    
    public function domains()
    {
        return $this->hasOne('App\UserDomain','user_id','id');
    }
    public function auth_token()
    {
        return $this->hasOne('App\Token','user_id','id');
    }

    public function getAvatarUrl()
    {
       if (\Storage::exists($this->avatar) && !empty($this->avatar)) {
            return asset(\Storage::url('app/'.$this->avatar));
        } else {
            return asset('assets/img/user/user.jpg');
        }
    }
    public function getJobTitle()
    {
       $title= \App\UserQualification::where('user_id',$this->id)->first();
       return !empty($title->job_title) ? $title->job_title :'No Job Title';
    }
    public function getProfilefeebackCount()
    {
       $count= \App\UserProfileRating::where('profile_id',$this->id)->count();
       return $count??0;
    }
	
	   public function assignPlan($planID, $planType = '', $customerId = '')
    {
        //        $usr  = \Auth::user();
        $usr = $this;
        $plan = Plan::find($planID);

        if ($plan) {
            if (\Auth::check()) {
             

             

            $this->plan = $plan->id;

            $planExpireDate = Carbon::now()->addYears(1)->isoFormat('YYYY-MM-DD');
            if ($planType == 'week') {
                $planExpireDate = Carbon::now()->addWeek(1)->isoFormat('YYYY-MM-DD');
            } elseif ($planType == 'month') {
                $planExpireDate = Carbon::now()->addMonths(1)->isoFormat('YYYY-MM-DD');
            }
            $this->plan_expire_date = $planExpireDate;
            $this->plan_type = $planType;
            if ($customerId) {
                $this->customer_id = $customerId;
            }
            $this->save();

            return ['is_success' => true];
        } else {
            return [
                'is_success' => false,
                'error' => 'Plan is deleted.',
            ];
        }
    }
	}
	 public static function userInfo($user_id = '')
    {
        return $usr = User::find($user_id);
    }
    public static function question()
    {
        return $this->hasOne(ProgramApproval::class,'user_id','id');
    }
    public function getPhoneNumber(){
        return $this->mobile;
    }
    public function getEmail(){
        return $this->email;
    }
public static function userSettingsInfo($user_id, $field)
    {
        $response='';
        $setting = DB::table('user_settings')->select($field)->where('user_id', $user_id)->where($field,'<>', "")->first();
      

            if ($setting) {
                if (trim($setting->$field) !== "") {
                    $response = $setting->$field;
                } else {
                   // $setting = DB::select('select user_settings.* from user_settings inner join users on users.id=user_settings.user_id where users.type="admin" limit 1')[0];
                   // $response = $setting->$field;
                }
            } else {
              //  $setting = DB::select('select user_settings.* from user_settings inner join users on users.id=user_settings.user_id where users.type="admin" limit 1')[0];
               // $response = $setting->$field;
            }
      
        return $response;
    }
}
