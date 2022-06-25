<?php

namespace App;

use Stripe;
use Session;
use App\User;
use App\CompanyWallet;
use App\Vacancy;
use App\Blog;
use App\StripePayment;
use App\Certify;
use App\Officespace;
use App\Coworkingbooking;
use App\WalletExpenses;
use App\Solution;
use App\Syndicate;
use App\Syndicatepayment;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Model;
use \stdClass;

class StripePayment extends Model
{

    protected $fillable = [
        'completed_on',
        'enroll_key',
        'item_id',
        'user_id',
        'email',
        'item_type',
        'item_name',
        'qty',
        'price',
        'total_price',
        'payment_key',
		'exp_date'
    ];
    protected $table = 'stripe_payments';

    function freeCourse($request)
    {
        $authuser = Auth::user();
        $coupon = CorporateCoupon::where(['certify' => $request->certifyId, 'coupon' => $request->coupon, 'redeemer' => $authuser->id, 'status' => 'not_used'])->first();
		
		if($coupan){
			
		}else{
			 return redirect()->back()->with('error', __('Something went worng.Please try again.'));
		}
		
//        dd($coupon);
        $certify = Certify::find($request->certifyId);
        $coupon->status = 'used';
        $coupon->save();
        $data = self::create([
            'enroll_key' => '',
            'item_id' => $certify->id,
            'item_type' => 'certify',
            'user_id' => $authuser->id,
            'email' => $authuser->email,
            'item_name' => $certify->name,
            'qty' => 1,
            'price' => 0,
            'total_price' => 0,
            'payment_key' => 'free'
        ]);
        $lastInsertedId = $data->id;
        if ($lastInsertedId) {
            return $lastInsertedId;
        }
    }

    public function makePaymentBackend($request)
    {
        $authuser = Auth::user();
        if ($request->itemId != '') {
            $itemId = $request->itemId;
        } else {
            $itemId = '';
        }
        if ($request->itemType != '') {
            $itemType = $request->itemType;
        } else {
            $itemType = '';
        }
        if ($request->stripeToken != '') {
            $stripeToken = $request->stripeToken;
        } else {
            $stripeToken = '';
        }
        if ($request->itemId != '' && $request->itemType != '' && $request->stripeToken != '') {

            if ($itemType == 'agentApplicationForm') {
                if ($authuser->created_by) {
                    $itemData = User::where(['id' => $authuser->created_by])->first();
                } else {
                    $itemData = User::where(['type' => 'admin'])->first();
                }
                $admin_id = $itemData->id;
                $application_price = $itemData->application_price;
                $name = 'id';
                $qty = '1';
            } elseif ($itemType == 'wallet') {
                $admin_id = Auth::user()->id;
                $price = $request->price;
                $itemData = ['price' => $price];
                $qty = '1';
            } elseif ($itemType == 'adx') {
                $order_id = !empty($request->itemId) ? encrypted_key($request->itemId, 'decrypt') : 0;
                $itemData = \App\AdvertismentOrder::where(['id' => $order_id])->first();

                $admin_id = $itemData->id;
                $price = $itemData->price;
                $name = 'id';
                $qty = '1';
            } elseif ($itemType == 'newsroom') {
                $order_id = !empty($request->itemId) ? encrypted_key($request->itemId, 'decrypt') : 0;
                $itemData = \App\NewsroomOrder::where(['id' => $order_id])->first();

                $admin_id = $itemData->id;
                $price = $itemData->price;
                $name = 'id';
                $qty = '1';
            } elseif ($itemType == 'guestpert') {
                $order_id = !empty($request->itemId) ? encrypted_key($request->itemId, 'decrypt') : 0;
                $itemData = \App\GuestpertInterview::where(['id' => $order_id])->first();

                $admin_id = $itemData->id;
                $price = $itemData->price;
                $name = 'id';
                $qty = '1';
            } else {
                $itemData = '';
            }
            if ($itemData) {
                if ($itemType == 'agentApplicationForm') {
                    if ($itemData->application_price > 0) {
                        $price = $itemData->application_price;
                    } else {
                        $price = $itemData->application_price;
                    }
                } elseif ($itemType == 'wallet') {
                    $price = $request->price;
                }

                Stripe\Stripe::setApiKey(env('STRIPE_SECRET'));
                $stripe = Stripe\Charge::create([
                    "amount" => $price * 100,
                    "currency" => env('CURRENCY_CODE'),
                    "source" => $request->stripeToken,
                    "description" => "Payment From StemX.com Item Perchance"
                ]);
                if ($stripe->status == "succeeded" || $stripe->status == "paid") {
                    if ($itemType == 'agentApplicationForm') {
                        $data = self::create([
                            'item_id' => $admin_id,
                            'item_type' => 'agentApplicationForm',
                            'user_id' => $authuser->id,
                            'email' => $authuser->email,
                            'item_name' => 'agentApplicationForm',
                            'qty' => $qty,
                            'price' => $price,
                            'total_price' => $price * $qty,
                            'payment_key' => $stripe->id
                        ]);
                    } elseif ($itemType == 'wallet') {
                        $data = self::create([
                            'item_id' => $admin_id,
                            'item_type' => 'wallet',
                            'user_id' => $authuser->id,
                            'email' => $authuser->email,
                            'item_name' => 'wallet',
                            'qty' => $qty,
                            'price' => $price,
                            'total_price' => $price * $qty,
                            'payment_key' => $stripe->id
                        ]);
                    } elseif ($itemType == 'adx') {
                        $data = self::create([
                            'item_id' => $itemData->id,
                            'item_type' => $itemData->zone,
                            'user_id' => $authuser->id,
                            'email' => $authuser->email,
                            'item_name' => 'ADX Package-' . $itemData->package_id,
                            'qty' => $qty,
                            'price' => $price,
                            'total_price' => $price * $qty,
                            'payment_key' => $stripe->id
                        ]);

                    } elseif ($itemType == 'newsroom') {
                        $data = self::create([
                            'item_id' => $itemData->id,
                            'item_type' => \App\NewsroomCategory::category_name($itemData->category_id),
                            'user_id' => $authuser->id,
                            'email' => $authuser->email,
                            'item_name' => 'Newsroom Package-' . $itemData->package_id,
                            'qty' => $qty,
                            'price' => $price,
                            'total_price' => $price * $qty,
                            'payment_key' => $stripe->id
                        ]);
                    
                    } elseif ($itemType == 'guestpert') {
                        $data = self::create([
                            'item_id' => $itemData->id,
                            'item_type' => \App\GuestpertCategory::category_name($itemData->category_id),
                            'user_id' => $authuser->id,
                            'email' => $authuser->email,
                            'item_name' => 'Guestpert Interview-' . $itemData->id,
                            'qty' => $qty,
                            'price' => $price,
                            'total_price' => $price * $qty,
                            'payment_key' => $stripe->id
                        ]);
                    }

                    $lastInsertedId = $data->id;
                    if ($lastInsertedId) {
                        if ($itemType == 'wallet') {
                            $Wallet = CompanyWallet::where(['company_id' => $authuser->id])->first();
                            if ($Wallet) {
                                $price = $Wallet->balance + $price;
                                $Wallet = $Wallet->update([
                                    'balance' => $price,
                                ]);
                                if ($Wallet) {
                                    return $Wallet;
                                }
                            } else {
                                $CompanyWallet = CompanyWallet::create([
                                    'company_id' => $authuser->id,
                                    'balance' => $price,
                                    'status' => 'added'
                                ]);
                            }

                            if ($CompanyWallet) {
                                return $CompanyWallet;
                            }
                        } elseif ($itemType == 'adx') {
                            $data = \App\AdvertismentOrder::find($itemData->id);
                            $update['status'] = "Active";
                            $update['payment_status'] = '1';
                            $data->update($update);

                        } elseif ($itemType == 'newsroom') {
                            $data = \App\NewsroomOrder::find($itemData->id);
                            $update['payment_status'] = 'Paid';
                            $data->update($update);
                        } elseif ($itemType == 'guestpert') {
                            $data = \App\GuestpertInterview::find($itemData->id);
                            $update['payment_status'] = 'Paid';
                            $update['status'] = 'Confirmed';
                            $data->update($update);
                        }
                        return $lastInsertedId;
                    }
                }
            }
        }
    }
public function makePaymentUsingWallet($request){
	
 $authuser = Auth::user();
	if (!empty($request->itemId)) {
            $itemId = $request->itemId;
        } else {
            $itemId = '';
        }
        if (!empty($request->itemType)) {
            $itemType = $request->itemType;
        } else {
            $itemType = '';
        }
       
        if (!empty($itemId) && !empty($itemType) ) {
			
            if ($itemType == 'certify') {
                $itemData = Certify::find($itemId);
                $name = 'name';
                $qty = '1';
				$utc=date('Y-m-d H:i:s');
				$duration = ' +'.$itemData->duration.' ';
				$exp_date = date('Y-m-d H:i:s', strtotime($utc.$duration.$itemData->period));
				
            
            } else {
                $itemData = '';
            }
        }
        if (!empty($itemData)) {
            if ($itemData->sale_price > 0) {
                $price = $itemData->sale_price;
            } else {
                $price = $itemData->price;
            }
            if ($itemType == 'certify') {
                if ($request->coupon != '') {
                    $coupon = CorporateCoupon::where(['certify' => $request->itemId, 'coupon' => $request->coupon, 'redeemer' => $authuser->id, 'status' => 'not_used'])->first();
                    $price = $price - $coupon->price_limit;
                }
            }
        

			$domain_user= get_domain_user();
                $enroll_key = rand(100000, 999999);
				
				
				                if ($itemType == 'cowork') {
									$walletTile= $name;
								}
								else{
									$walletTile=$itemData->$name;
								}
			
					
					\App\UserWalletTransactions::create(
                                [
                          
                                    'from' => $authuser->id,
                                    'to' => $domain_user->id,
                                    'amount' =>$price,
                                    'description' =>"Certify Enrolled (". $walletTile.")",
                                ]
                        );
                if ($itemType == 'cowork') {
               
                } else {
                    if (!empty($coupon)) {
                        $coupon->status = 'used';
                        $coupon->save();
                    }
					
                    $data = self::create([
                        'enroll_key' => $enroll_key,
                        'item_id' => $itemData->id,
                        'item_type' => $itemType,
                        'user_id' => $authuser->id,
                        'email' => $authuser->email,
                        'item_name' => $itemData->$name,
                        'qty' => $qty,
                        'price' => $price,
                        'total_price' => $price * $qty,
                         'payment_key' => 'Wallet',
						 'exp_date'=> $exp_date
                    ]);
                    $lastInsertedId = $data->id;
                    if ($lastInsertedId) {
                        return $lastInsertedId;
                    }
                }
          
        }
}
    
    public function makePayment($request)
    {
        $authuser = Auth::user();
        if (!empty($request->itemId)) {
            $itemId = $request->itemId;
        } else {
            $itemId = '';
        }
        if (!empty($request->itemType)) {
            $itemType = $request->itemType;
        } else {
            $itemType = '';
        }
        if (!empty($request->stripeToken)) {
            $stripeToken = $request->stripeToken;
        } else {
            $stripeToken = '';
        }
        if (!empty($itemId) && !empty($itemType) && !empty($stripeToken)) {
            if ($itemType == 'certify') {
                $itemData = Certify::find($itemId);
                $name = 'name';
                $qty = '1';
                $utc=date('Y-m-d H:i:s');
				$duration = ' +'.$itemData->duration.' ';
				$exp_date = date('Y-m-d H:i:s', strtotime($utc.$duration.$itemData->period));
			}    
            else {
                $itemData = '';
            }
        }
        if (!empty($itemData)) {
            if ($itemData->sale_price > 0) {
                $price = $itemData->sale_price;
            } else {
                $price = $itemData->price;
            }
           
            if ($price != 0) {
                Stripe\Stripe::setApiKey(env('STRIPE_SECRET'));
                $stripe = Stripe\Charge::create([
                    "amount" => (int)$price * 100,
                    "currency" => env('CURRENCY_CODE'),
                    "source" => $request->stripeToken,
                    "description" => "Payment From Course enrolled."
                ]);
            } else {
                $stripe = new stdClass();
                $stripe->status = "succeeded";
                $stripe->id = "free";
            }

            if ($stripe->status == "succeeded" || $stripe->status == "paid") {
                $enroll_key = rand(100000, 999999);
              
             
                   

                    $data = self::create([
                        'enroll_key' => $enroll_key,
                        'item_id' => $itemData->id,
                        'item_type' => $itemType,
                        'user_id' => $authuser->id,
                        'email' => $authuser->email,
                        'item_name' => $itemData->$name,
                        'qty' => $qty,
                        'price' => $price,
                        'total_price' => $price * $qty,
                        'payment_key' => $stripe->id

                    ]);
                    $lastInsertedId = $data->id;
                    if ($lastInsertedId) {
                        return $lastInsertedId;
                    }
               
            }
        }
    }

    public function subsribePlan($request)
    {
        $response = [
            "success" => false,
            "message" => "",
        ];

        $authuser = Auth::user();
        $planId = $request->selected_plan_id;
        $qty = 1;
        $plans = Plan::find($planId);
        if (!empty($plans)) {
            $price = $plans->price;
            Stripe\Stripe::setApiKey(env('STRIPE_SECRET'));
            $stripe = Stripe\Charge::create([
                "amount" => $price * 100,
                "currency" => env('CURRENCY_CODE'),
                "source" => $request->stripeToken,
                "description" => "Payment From Myceo.com plan subscribe"
            ]);
            // echo "<pre>"; print_r($stripe); die;
            if ($stripe->status == "succeeded") {
                $data = self::create([
                    'item_id' => $planId,
                    'item_type' => "plan",
                    'user_id' => $authuser->id,
                    'email' => $authuser->email,
                    'item_name' => $plans->name,
                    'qty' => $qty,
                    'price' => $price,
                    'total_price' => $price * $qty,
                    'payment_key' => $stripe->id
                ]);

                // $user = User::where("id",$authuser->id)->where('is_active', '1')->()->get();

                $response['message'] = "Plans purchased successfully";
                $response['success'] = true;
                return $response;
            }
        } else {
            $response['message'] = "Plans not found";
        }
        return $response;
    }

    public function makeSyndicatePayment($request)
    {
        $authuser = Auth::user();
       // $ComissonSyndicate = getCommission();
	   
	   $adminComisson= env('ADMIN_COMMISSION');
	   if($adminComisson >='100'){
		   $adminComisson='100';
	   }
	   else{
		   $adminComisson= env('ADMIN_COMMISSION');
	   }
	   $PromotorComisson=env('PROMOTER_COMMISSION');
	    if($PromotorComisson >='100'){
		   $PromotorComisson='100';
	   }
	   else{
		   $PromotorComisson= env('PROMOTER_COMMISSION');
	   }
	   
	   
        if (!empty($request->itemId)) {
            $itemId = $request->itemId;
        } else {
            $itemId = '';
        }
        if (!empty($request->itemType)) {
            $itemType = $request->itemType;
        } else {
            $itemType = '';
        }
        if (!empty($request->stripeToken)) {
            $stripeToken = $request->stripeToken;
        } else {
            $stripeToken = '';
        }
        if (!empty($itemId) && !empty($itemType) && !empty($stripeToken)) {
            $itemData = Certify::find($itemId);
            $name = 'name';
            $qty = '1';
            if (!empty($itemData)) {
                if ($itemData->sale_price > 0) {
                    $price = $itemData->sale_price;
                } else {
                    $price = $itemData->price;
                }
                $admin = User::where(['type' => 'admin'])->first();
                $promoter = get_domain_id();
                $permoter_user = User::find($promoter);
                $owner = User::find($itemData->user_id);
                $transfer_group = "COURSE" . $itemData->id;
                Stripe\Stripe::setApiKey(env('STRIPE_SECRET'));
                $stripe = Stripe\Charge::create([
                    "amount" => (int)$price * 100,
                    "currency" => env('CURRENCY_CODE'),
                    "source" => $request->stripeToken,
                    "transfer_group" => $transfer_group,
                    "description" => "Payment From Item Perchance"
                ]);
		if(env('COMMISSION_STATUS')=='1'){
			if (!empty($owner->stripe_account_id) && $owner->id != 1) {
                    // Create a Transfer to a owner
                    $transfer = \Stripe\Transfer::create([
                        "amount" => (((int)$price * 100 * $adminComisson ) / 100),
                        "currency" => env('CURRENCY_CODE'),
                        "destination" => $owner->stripe_account_id,
                        "transfer_group" => $transfer_group,
                    ]);
                }
                if (!empty($permoter_user->stripe_account_id) && $permoter_user->id != 1) {
                    // Create a second Transfer to promoter
                    $transfer = \Stripe\Transfer::create([
                        "amount" => (((int)$price * 100 * $PromotorComisson) / 100),
                        "currency" => env('CURRENCY_CODE'),
                        "destination" => $permoter_user->stripe_account_id,
                        "transfer_group" => $transfer_group,
                    ]);
                }
	
	
			}
               
                if ($stripe->status == "succeeded") {
                    $data = array(
                        "buyer" => $authuser->id,
                        "amount" => $price,
                        "owner" => $itemData->user_id,
                      //  "owner_share" => (($price * $ComissonSyndicate->owner) / 100),
                        "promoter" => $promoter,
                        "promoter_share" => (($price * $PromotorComisson) / 100),
                        "admin_share" => (($price * $adminComisson) / 100),
                        "certify" => $itemData->id
                    );
                    $Syndicatepayment = Syndicatepayment::create($data);
                    $enroll_key = rand(100000, 999999);
                    $data = self::create([
                        'enroll_key' => $enroll_key,
                        'item_id' => $itemData->id,
                        'item_type' => $itemType,
                        'user_id' => $authuser->id,
                        'email' => $authuser->email,
                        'item_name' => $itemData->$name,
                        'qty' => $qty,
                        'price' => $price,
                        'total_price' => $price * $qty,
                        'payment_key' => $stripe->id
                    ]);
                    if ($Syndicatepayment) {
                        return $Syndicatepayment;
                    }
                } else {
                    return $responce = [
                        'status' => false,
                        'message' => 'stripe id missing of user'
                    ];
                }
            }
        }
    }

}
