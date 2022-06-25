<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
use App\AssistanceRequest;

class CorporateCoupon extends Model
{
    protected $fillable = [
    	'user',
    	'certify',
    	'redeemer',
    	'coupon',
    	'status',
    	'price_limit'
    ];

    protected $table = 'corporate_coupons';

    public function genrateCoupon($request)
    {
    	$user = Auth::user();
    	function random_strings($length_of_string) 
		{ 
		    $str_result = '0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz'; 
		    return substr(str_shuffle($str_result),  
           	0, $length_of_string); 
		} 
    	$genrate = substr($user->name, 0, 4).'#'.random_strings(4).''.$request->price;
    	$tutionrequest = AssistanceRequest::find($request->id);
        $price_limit = '';
        if(isset($request->price)){
            $price_limit = $request->price;
        }else{
            $price_limit = $request->hiddenPrice;
        }
    	$data = self::create([
    		'user'=>$user->id,
    		'certify'=>$tutionrequest->certify,
    		'redeemer'=>$tutionrequest->user,
    		'coupon'=>strtoupper($genrate),
    		'status'=>'not_used',
    		'price_limit'=>$price_limit
    	]);
    	return $data->id;
    }
}
