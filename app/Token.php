<?php

namespace App;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Twilio\Rest\Client;
use Exception;
use Illuminate\Support\Facades\Mail;
use App\SiteSettings;

class Token extends Model
{
    const EXPIRATION_TIME = 15; // minutes

    protected $fillable = [
        'code',
        'user_id',
        'used'
    ];

    public function __construct(array $attributes = [])
    {
        if (! isset($attributes['code'])) {
            $attributes['code'] = $this->generateCode();
        }

        parent::__construct($attributes);
    }

    /**
     * Generate a six digits code
     *
     * @param int $codeLength
     * @return string
     */
    public function generateCode($codeLength = 3)
    {
        $min = pow(10, $codeLength);
        $max = $min * 10 - 1;
        $code = mt_rand($min, $max);

        return $code;
    }

    /**
     * User tokens relation
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Send code to user
     *
     * @return bool
     * @throws \Exception
     */
    public function sendCode($type = 'mobile')
    {  
        if (! $this->user) {
            throw new \Exception("No user attached to this token.");
        }

        if (! $this->code) {
            $this->code = $this->generateCode();
        }
                if($type == 'mobile'){
                    try {
                        $twilio = SiteSettings::where('name', 'twilio_key')->where('user_id', 1)->first();
                        $twilio = json_decode($twilio->value,true);
                        
                           $client = new Client($twilio['twilio_account_sid'], $twilio['twilio_auth_token']);

                            $client->messages->create($this->user->getPhoneNumber(), [
                                'from' => $twilio['twilio_number'], 
                                'body' => "Your verification code is {$this->code}"]);
                                        
                    } catch (\Exception $ex) {
                        
                        return $ex; //enable to send SMS
                    }
                    return true;
                }else{
                      //email
                      try {

                          $resp = \App\Utility::send_emails($this->user->getEmail(), $this->user->getEmail(), 'StemX One Time Password', "Your verification code is {$this->code}");
                        } catch (\Exception $ex) {
                          return $ex;
                        }
                        
                      return true;

                }
    }

    /**
     * True if the token is not used nor expired
     *
     * @return bool
     */
    public function isValid()
    {
        return ! $this->isUsed() && ! $this->isExpired();
    }

    /**
     * Is the current token used
     *
     * @return bool
     */
    public function isUsed()
    {
        return $this->used;
    }

    /**
     * Is the current token expired
     *
     * @return bool
     */
    public function isExpired()
    { 
        return $this->created_at->diffInMinutes(Carbon::now()) > static::EXPIRATION_TIME;
    }
}