<?php

namespace App\Http\Controllers;


use App\User;
use App\Utility;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Stripe;
use Mail;
use Carbon\Carbon;
use LaraCart;

class StripePaymentController extends Controller {

  

    //stripe profile booking order post
    public function stripeProfileBookingOrderPost(Request $request) {
        
        $objUser = \Auth::user();
        
        if (!empty($objUser->id)) {
            $slots = !empty($request->slot)? explode(',',$request->slot):'';
          
            $uid = encrypted_key($request->uid,'decrypt');

            if (empty($slots) || empty($uid)) {
                return redirect()->back()->with('error', __('Permission Denied.'));
            }
            $slots_info = \App\MeetingScheduleSlot::whereIn('id',$slots)->get();
           
//            if (empty($request->stripeEmail)) {
//                $validator = \Validator::make(
//                                $request->all(), [
//                            'name' => 'required|max:120',
//                                ]
//                );
//               
//                if ($validator->fails()) {
//                    return redirect()->back()->withInput()->withErrors($validator);
//                }
//            }
            
            if ($slots_info) {
                 
                 
                 $stripe_settings=\App\SiteSettings::getValByName('payment_settings');
                 $stripe_key=$stripe_settings['STRIPE_SECRET']??'';
               
             
            if (empty($stripe_key)) {
                return redirect()->back()->with('error', __('Your Payment has failed!'));
            }
                  
                
             //  
          $price=0;
          $reciept='';
                        Stripe\Stripe::setApiKey($stripe_key);
                    foreach ($slots_info as $slot_info){
                  $schedule_info = \App\MeetingSchedule::find($slot_info->meeting_schedule_id);
                  $price += $schedule_info->price??0;
                $reciept .=$schedule_info->title." slot ".$slot_info->date.' '.$slot_info->start_time.' - '.$slot_info->end_time.' having price '. format_price($schedule_info->price??0).' | ';
                    }
                    
                    if ($price > 0.0) {
                        $data = Stripe\Charge::create(
                                        [
                                            "amount" => 100 * $price,
                                            "currency" => strtolower('usd'),
                                            "source" => $request->stripeToken,
                                            "description" => " Order Description - " . $reciept,
                                        ]
                        );
                    } else {
                        $data['amount_refunded'] = 0;
                        $data['failure_code'] = '';
                        $data['paid'] = 1;
                        $data['captured'] = 1;
                        $data['status'] = 'succeeded';
                    }
                    
                     foreach ($slots_info as $slot_info){
                          try {
                            $schedule_info = \App\MeetingSchedule::find($slot_info->meeting_schedule_id);
                   $user_info = User::where('id', $schedule_info->user_id)->first();
                 
                    $orderID = strtoupper(str_replace('.', '', uniqid('', true)));
                   
                    if ($data['amount_refunded'] == 0 && empty($data['failure_code']) && $data['paid'] == 1 && $data['captured'] == 1) {
                      $invoicedata =  \App\UserPayment::create(
                                [
                                    'order_id' => $orderID,
                                    'name' => $objUser->name,
                                    'email' => $objUser->email,
                                    'card_number' => $data['payment_method_details']['card']['last4']??'',
                                    'card_exp_month' => $data['payment_method_details']['card']['exp_month']??'',
                                    'card_exp_year' => $data['payment_method_details']['card']['exp_year']??'',
                                    'entity_type' => 'Schedule Slot Booking',
                                    'entity_id' => $slot_info->id,
                                    'title' => $schedule_info->title,
                                    'amount' => $schedule_info->price??0,
                                    'status' => "Pending",
                                    'price_currency' => $data['currency']??'',
                                    'txn_id' => $data['balance_transaction']??'',
                                    'payment_type' => 'STRIPE',
                                    'payment_status' => $data['status']??'free',
                                    'receipt' => $data['receipt_url']??'',
                                    'user_id' => $objUser->id,
                                    'paid_to_user_id' => $schedule_info->user_id,
                                    'other_description' => $schedule_info->title." slot ".$slot_info->date.' '.$slot_info->start_time.' - '.$slot_info->end_time.' having price '. format_price($schedule_info->price??0).' | Price Description:'.$schedule_info->price_description,
                                ]
                        );

                       

                        if ($data['status'] == 'succeeded') {
                            // Points created for booking appointment
                            $rolescheck = \App\Role::whereRole($user_info->type)->first();               
                            if($rolescheck->role == 'mentor' ){
                                if(checkPlanModule('points')){
                                    $checkPoint = \Ansezz\Gamify\Point::find(4);
                                    if(isset($checkPoint) && $checkPoint != null ){
                                        if($checkPoint->allow_duplicate == 0){
                                            $createPoint = $user_info->achievePoint($checkPoint);
                                        }else{
                                            $addPoint = DB::table('pointables')->where('pointable_id', $user_info->id)->where('point_id', $checkPoint->id)->get();
                                            if($addPoint == null){
                                                $createPoint = $user_info->achievePoint($checkPoint);
                                            }
                                        }
                                    }       
                                }
                            }

                             $data1 = \App\MeetingScheduleSlot::find($slot_info->id);
                            $save['user_id'] = $objUser->id;
                            $data1->update($save);
                            
                          $emailbody=[
                               'Booking For'=>$schedule_info->title,
                                'Schedule Date'=>date('M d, Y', strtotime($schedule_info->date)),
                                'Start Time'=>date('H:i:s', strtotime($schedule_info->start_time)),
                                'End Time'=>date('H:i:s', strtotime($schedule_info->end_time)),
                                'Price'=> format_price($schedule_info->price),
                                'Invoice'=> url('/').'/invoice/'. encrypted_key($invoicedata->id,'encrypt'),
                                ];
                       
                                $resp = \App\Utility::send_emails($objUser->email, $objUser->name, null, $emailbody,'meeting_schedule_booking_confirmation_email',$objUser);

            
        
                            //return redirect()->route('booking.success')->with('success', __('Appointment booked Successfully!'));
//                      if(!empty($request->stripeEmail)){
//                          return redirect()->back()->with('success', __('Order placed successfully!'));
//                      }else{
//                        return redirect()->route('profile')->with('success', __('Order placed successfully!'));
//                      }
                        } else {
                            //return redirect()->back()->with('error', __('Your Payment has failed!'));
                        }
                    } else {
                        //return redirect()->back()->with('error', __('Transaction has been failed!'));
                    }
                                    } catch (\Exception $e) {
                    //return redirect()->back()->with('error', __($e->getMessage()));
                }
                    }
                    return redirect()->route('booking.success')->with('success', __('Appointment booked Successfully!'));

            } else {
                return redirect()->back()->with('error', __('Slot is deleted.'));
            }
        } else {
            return redirect()->back()->with('error', __('Permission Denied.'));
        }
    }

//stripe assessments form post
    public function assessmentFormPaymentPost(Request $request) {

        $objUser = \Auth::user();
        if ($objUser->type != 'admin') {
            $formID = \Illuminate\Support\Facades\Crypt::decrypt($request->code);

            if (empty($formID)) {
                return redirect()->back()->with('error', __('Permission Denied.'));
            }
            $form = \App\AssessmentForms::find($formID);

            $validator = \Validator::make(
                            $request->all(), [
                        'name' => 'required|max:120',
                            ]
            );
            if ($validator->fails()) {
                return redirect()->back()->withInput()->withErrors($validator);
            }

            if ($form) {
                
                try {
                     $user_info = User::where('id', $form->user_id)->first();
                 $stripe_settings=\App\SiteSettings::getValByName('payment_settings');
                 $stripe_key=$stripe_settings['STRIPE_SECRET']??'';
               
             
            if (empty($stripe_key)) {
                return redirect()->back()->with('error', __('Your Payment has failed!'));
            }
            
                    $price = $form->amount;

                    if (!empty($request->coupon)) {
                        $coupons = Coupon::where('code', strtoupper($request->coupon))->where('is_active', '1')->first();
                        if (!empty($coupons)) {
                            $usedCoupun = $coupons->used_coupon();
                            $discount_value = (($form->amount) / 100) * $coupons->discount;
                            $price = ($form->amount) - $discount_value;

                            if ($usedCoupun >= $coupons->limit) {
                                return redirect()->back()->with('error', __('This coupon code has expired.'));
                            }
                        } else {
                            return redirect()->back()->with('error', __('This coupon code is invalid or has expired.'));
                        }
                    }

                    $orderID = strtoupper(str_replace('.', '', uniqid('', true)));

                    if ($price > 0.0) {

                        Stripe\Stripe::setApiKey($stripe_key);
                        $data = Stripe\Charge::create(
                                        [
                                            "amount" => 100 * $price,
                                            "currency" => 'usd',
                                            "source" => $request->stripeToken,
                                            "description" => " Product - " . $form->title,
                                            "metadata" => ["order_id" => $orderID],
                                        ]
                        );
                    } else {
                        $data['amount_refunded'] = 0;
                        $data['failure_code'] = '';
                        $data['paid'] = 1;
                        $data['captured'] = 1;
                        $data['status'] = 'succeeded';
                    }
                    if ($data['amount_refunded'] == 0 && empty($data['failure_code']) && $data['paid'] == 1 && $data['captured'] == 1) {

                        \App\AssessmentFormPayment::create(
                                [
                                    'order_id' => $orderID,
                                    'name' => $request->name,
                                    'email' => $objUser->email,
                                    'card_number' => $data['payment_method_details']['card']['last4'],
                                    'card_exp_month' => $data['payment_method_details']['card']['exp_month'],
                                    'card_exp_year' => $data['payment_method_details']['card']['exp_year'],
                                    'form_title' => $form->title,
                                    'form_id' => $form->id,
                                    'amount' => $price,
                                    'price_currency' => $data['currency'],
                                    'txn_id' => $data['balance_transaction'],
                                    'payment_type' => 'STRIPE',
                                    'payment_status' => $data['status'],
                                    'receipt' => $data['receipt_url'],
                                    'user_id' => $objUser->id,
                                ]
                        );
                        
                         \App\UserPayment::create(
                                [
                                    'order_id' => $orderID,
                                    'name' => $objUser->name,
                                    'email' => $objUser->email,
                                    'card_number' => $data['payment_method_details']['card']['last4']??'',
                                    'card_exp_month' => $data['payment_method_details']['card']['exp_month']??'',
                                    'card_exp_year' => $data['payment_method_details']['card']['exp_year']??'',
                                    'entity_type' => 'Assessment Payment',
                                    'entity_id' => $form->id,
                                    'title' => $form->title,
                                    'amount' => $price,
                                    'status' => "Paid",
                                    'price_currency' => $data['currency']??'',
                                    'txn_id' => $data['balance_transaction']??'',
                                    'payment_type' => 'STRIPE',
                                    'payment_status' => $data['status']??'free',
                                    'receipt' => $data['receipt_url']??'',
                                    'user_id' => $objUser->id,
                                    'paid_to_user_id' => get_domain_user()->id,
                                    'other_description' => "Assessment payment $".$price." made for ".$form->title,
                                ]
                        );

                        $AssessmentResponses = \App\AssessmentResponses::where('form', $form->id)->where('user_id', $objUser->id)->first();
                        $AssessmentResponses->update(array('payment' => "1"));

                        if (!empty($request->coupon)) {
                            $userCoupon = new UserCoupon();
                            $userCoupon->user = $objUser->id;
                            $userCoupon->coupon = $coupons->id;
                            $userCoupon->order = $orderID;
                            $userCoupon->save();
                            $usedCoupun = $coupons->used_coupon();
                            if ($coupons->limit <= $usedCoupun) {
                                $coupons->is_active = 0;
                                $coupons->save();
                            }
                        }

                        if ($data['status'] == 'succeeded') {


                              try{
                                   $emailbody='<h1>Hi, ' . $objUser->name . '!</h1><br><p> You have just made payment against an order# ' . $orderID . ' for the assessment ' . $form->title . '

                                    <br>Now you are allowed to complete assigned assessment. Thanks You!</p>';
                                  send_email($objUser->email, $objUser->name, 'New Assessment Payment Order#: ' . $orderID, $emailbody);
                         
                        }catch (Exception $ex){
                          //  print_r($ex);
                        }

                            return redirect()->route('assessmentForm', encrypted_key($form->id, 'encrypt'))->with('success', __('Payment made successfully!'));
                        } else {
                            return redirect()->back()->with('error', __('Your Payment has failed!'));
                        }
                    } else {
                        return redirect()->back()->with('error', __('Transaction has been failed!'));
                    }
                } catch (\Exception $e) {
                    return redirect()->back()->with('error', __($e->getMessage()));
                }
            } else {
                return redirect()->back()->with('error', __('Product is deleted.'));
            }
        } else {
            return redirect()->back()->with('error', __('Permission Denied.'));
        }
    }

//stripe petition form post
    public function PetitionPaymentPost(Request $request) {
       
        $objUser = \Auth::user();
        if ($objUser->type != 'admin') {
            $formID = !empty($request->itemId) ? $request->itemId:0;

            if (empty($formID)) {
                return redirect()->back()->with('error', __('Permission Denied.'));
            }
            $form = \App\PetitionForms::find($formID);

            $validator = \Validator::make(
                            $request->all(), [
                        'itemType' => 'required|max:120',
                            ]
            );
            if ($validator->fails()) {
                return redirect()->back()->withInput()->withErrors($validator);
            }

            if ($form) {
                
                try {
                     $user_info = User::where('id', $form->user_id)->first();
                 $stripe_settings=\App\SiteSettings::getValByName('payment_settings');
                 $stripe_key=$stripe_settings['STRIPE_SECRET']??'';
               
             
            if (empty($stripe_key)) {
                return redirect()->back()->with('error', __('Your Payment has failed!'));
            }
            
                    $price = $request->itemPrice??0;

                    if (!empty($request->coupon)) {
                        $coupons = Coupon::where('code', strtoupper($request->coupon))->where('is_active', '1')->first();
                        if (!empty($coupons)) {
                            $usedCoupun = $coupons->used_coupon();
                            $discount_value = (($form->amount) / 100) * $coupons->discount;
                            $price = ($form->amount) - $discount_value;

                            if ($usedCoupun >= $coupons->limit) {
                                return redirect()->back()->with('error', __('This coupon code has expired.'));
                            }
                        } else {
                            return redirect()->back()->with('error', __('This coupon code is invalid or has expired.'));
                        }
                    }

                    $orderID = strtoupper(str_replace('.', '', uniqid('', true)));

                    if ($price > 0.0) {

                        Stripe\Stripe::setApiKey($stripe_key);
                        $data = Stripe\Charge::create(
                                        [
                                            "amount" => 100 * $price,
                                            "currency" => 'usd',
                                            "source" => $request->stripeToken,
                                            "description" => " Product - " . $form->title,
                                            "metadata" => ["order_id" => $orderID],
                                        ]
                        );
                    } else {
                        $data['amount_refunded'] = 0;
                        $data['failure_code'] = '';
                        $data['paid'] = 1;
                        $data['captured'] = 1;
                        $data['status'] = 'succeeded';
                    }
                    if ($data['amount_refunded'] == 0 && empty($data['failure_code']) && $data['paid'] == 1 && $data['captured'] == 1) {
                     
                    
                        
                         \App\UserPayment::create(
                                [
                                    'order_id' => $orderID,
                                    'name' => $objUser->name,
                                    'email' => $objUser->email,
                                    'card_number' => $data['payment_method_details']['card']['last4']??'',
                                    'card_exp_month' => $data['payment_method_details']['card']['exp_month']??'',
                                    'card_exp_year' => $data['payment_method_details']['card']['exp_year']??'',
                                    'entity_type' => 'Petition Payment',
                                    'entity_id' => $form->id,
                                    'title' => $form->title,
                                    'amount' => $price,
                                    'status' => "Paid",
                                    'price_currency' => $data['currency']??'',
                                    'txn_id' => $data['balance_transaction']??'',
                                    'payment_type' => 'STRIPE',
                                    'payment_status' => $data['status']??'free',
                                    'receipt' => $data['receipt_url']??'',
                                    'user_id' => $objUser->id,
                                    'paid_to_user_id' => get_domain_user()->id,
                                    'other_description' => "Petition Donation $".$price." made for ".$form->title,
                                ]
                        );

                        

                        if ($data['status'] == 'succeeded') {


                              try{
                                   $emailbody='<h1>Hi, ' . $objUser->name . '!</h1><br><p> You have just made payment against an order# ' . $orderID . ' for the petition ' . $form->title . '

                                    <br>Thanks You!</p>';
                                  send_email($objUser->email, $objUser->name, 'New Petition Donation Payment Order#: ' . $orderID, $emailbody);
                         
                        }catch (Exception $ex){
                          //  print_r($ex);
                        }

                            return redirect()->route('user.petition.invoices')->with('success', __('Payment made successfully!'));
                        } else {
                            return redirect()->back()->with('error', __('Your Payment has failed!'));
                        }
                    } else {
                        return redirect()->back()->with('error', __('Transaction has been failed!'));
                    }
                } catch (\Exception $e) {
                    return redirect()->back()->with('error', __($e->getMessage()));
                }
            } else {
                return redirect()->back()->with('error', __('Product is deleted.'));
            }
        } else {
            return redirect()->back()->with('error', __('Permission Denied.'));
        }
    }

//stripe wallet form post
    public function wallet_deposit(Request $request) {
       
        $objUser = \Auth::user();
 

       
                
                try {
                   
                 $stripe_settings=\App\SiteSettings::getValByName('payment_settings');
                 $stripe_key=$stripe_settings['STRIPE_SECRET']??'';
               
             
            if (empty($stripe_key)) {
                return redirect()->back()->with('error', __('Your Payment has failed!'));
            }
            
                    $price = $request->amount??0;

                  
                    $orderID = strtoupper(str_replace('.', '', uniqid('', true)));

                    if ($price > 0.0) {

                        Stripe\Stripe::setApiKey($stripe_key);
                        $data = Stripe\Charge::create(
                                        [
                                            "amount" => 100 * $price,
                                            "currency" => 'usd',
                                            "source" => $request->stripeToken,
                                            "description" => "Wallet Deposit",
                                            "metadata" => ["order_id" => $orderID],
                                        ]
                        );
                    } else {
                        $data['amount_refunded'] = 0;
                        $data['failure_code'] = '';
                        $data['paid'] = 1;
                        $data['captured'] = 1;
                        $data['status'] = 'succeeded';
                    }
                    if ($data['amount_refunded'] == 0 && empty($data['failure_code']) && $data['paid'] == 1 && $data['captured'] == 1) {
                     
                    
                        
                         \App\UserPayment::create(
                                [
                                    'order_id' => $orderID,
                                    'name' => $objUser->name,
                                    'email' => $objUser->email,
                                    'card_number' => $data['payment_method_details']['card']['last4']??'',
                                    'card_exp_month' => $data['payment_method_details']['card']['exp_month']??'',
                                    'card_exp_year' => $data['payment_method_details']['card']['exp_year']??'',
                                    'entity_type' => 'Petition Payment',
                                    'entity_id' => 0,
                                    'title' => 'Wallet Deposit',
                                    'amount' => $price,
                                    'status' => "Paid",
                                    'price_currency' => $data['currency']??'',
                                    'txn_id' => $data['balance_transaction']??'',
                                    'payment_type' => 'STRIPE',
                                    'payment_status' => $data['status']??'free',
                                    'receipt' => $data['receipt_url']??'',
                                    'user_id' => $objUser->id,
                                    'paid_to_user_id' => get_domain_user()->id,
                                    'other_description' => "Amount deposit in wallet",
                                ]
                        );
                         
                        \App\UserWalletTransactions::create(
                                [
                          
                                    'from' => 0,
                                    'to' => $objUser->id,
                                    'amount' => $price,
                                    'description' => "Deposit through stripe",
                                ]
                        );

                        $objUser->wallet_balance=$objUser->wallet_balance + $price;
                        $objUser->save();

                        if ($data['status'] == 'succeeded') {


                              try{
                                   $emailbody='<h1>Hi, ' . $objUser->name . '!</h1><br><p> You have just made payment against an order# ' . $orderID . ' for wallet deposit 

                                    <br>Thanks You!</p>';
                                  send_email($objUser->email, $objUser->name, 'New Wallet Deposit Order#: ' . $orderID, $emailbody);
                         
                        }catch (Exception $ex){
                          //  print_r($ex);
                        }

                            return redirect()->route('wallet')->with('success', __('Deposit made successfully!'));
                        } else {
                            return redirect()->back()->with('error', __('Your Payment has failed!'));
                        }
                    } else {
                        return redirect()->back()->with('error', __('Transaction has been failed!'));
                    }
                } catch (\Exception $e) {
                    return redirect()->back()->with('error', __($e->getMessage()));
                }
            
        
    }
    //stripe marketplace product order post
    public function stripeMarketplaceProdcutOrderPost(Request $request) {
      
        $user = Auth::user();
           $objUser=$user;
        $data = LaraCart::getItems();
        $deal_name='';
        $method=$request->method??'';
        $purchaser=\App\User::find($request->purchaser??'');
   
        if (!empty($user->id) && !empty($data) && !empty($purchaser)) {
            if($method !="wallet"){
                 $stripe_settings=\App\SiteSettings::getValByName('payment_settings');                  
                 $stripe_key=$stripe_settings['STRIPE_SECRET']??'';
                 $stripe_currency=$stripe_settings['CURRENCY_CODE']??'usd';
                 if($stripe_currency=="$"){
                     $stripe_currency='usd';
                 }
             
             
            if (empty($stripe_key)) {
                return redirect()->back()->with('error', __('Your Payment has failed!'));
            }
            }
//            $marketplace = \App\WebsiteSetting::WebsiteSetting('marketplace', 1);
//                if (!empty($marketplace->value)) {
//                    $marketplace = json_decode($marketplace->value, true);
//                } else {
//                    $marketplace = array();
//                }
//                $deal_datetime = !empty($marketplace['marketplace_home_deal_datetime']) ? date('Y-m-d H:i:s', strtotime($marketplace['marketplace_home_deal_datetime'])) : '';
//                if (Carbon::now()->toDateTimeString() < $deal_datetime) {
//                    $deal_name=$marketplace['marketplace_home_deal_name'] ?? 'Deal of the day';                   
//                }
                
            $billdetails = array();
            $recieptdetails = '';
            if($purchaser->id != $user->id){
                $recieptdetails .='Drop shipping for '.$purchaser->name.', '.$purchaser->address1.' | ';
            }
            $deal_discount = 0;
            $total_qty = 0;
            foreach ($data as $i => $row) {
                $deal = 0;
                $billdetails[$i]['id'] = $row->id;
                $billdetails[$i]['name'] = $row->name;
                $billdetails[$i]['qty'] = $row->qty;
                $billdetails[$i]['price'] = $row->price;
                $billdetails[$i]['subtotal'] = $row->subTotal(false);
                $billdetails[$i]['user_id'] = $row->user_id;
//                if (!empty($row->current_deal_off) && !empty($deal_name)) {
//                    $deal = $row->current_deal_off * .01 * $row->price * $row->qty;
//                    $deal_discount = $deal_discount + $deal;
//                }
                $billdetails[$i]['deal'] = $deal;
                $recieptdetails .= $row->name . " X " . $row->qty . " Price " . format_price($row->subTotal(false)) . " | ";
                
                $productdata= \App\ShopProduct::find($row->id);
                $deal_discount =$deal_discount + ($productdata->price-$productdata->special_price);
                
                $total_qty =$total_qty+$row->qty;
            }
//            if (!empty($deal_discount) && !empty($deal_name)) {
//                    LaraCart::addFee($deal_name, -$deal_discount, $taxable = false, $options = []);
//                    $recieptdetails .= $deal_name . " (Discount) " . format_price($deal_discount) . " applied";              
//            }
            $discount_details = LaraCart::getFees();
            $subtotal_without_discount = LaraCart::subTotal($format = false);
            $subtotal_with_discount = LaraCart::subTotal($format = false, $withDiscount = true);
            $total_price = LaraCart::total($formatted = false, $withDiscount = true);
            
         
           
              if($method =="wallet"){
                  if($total_price > $user->wallet_balance){
                      return redirect()->route('wallet')->with('error', __('Please recharge your wallet!'));
                  }
              }
            try {
                $cart_id = strtoupper(str_replace('.', '', uniqid('', true)));
 
                if ($total_price > 0.0 && $method !="wallet") {
                    \Stripe\Stripe::setApiKey($stripe_key);

                    $customer = \Stripe\Customer::create([
                                'name' => $user->name,
                                'email' => $user->email,
                                'phone' => $user->mobile,
                                "metadata" => ["order_id" => $cart_id],
                                'shipping' => [
                                    'address' => ["line1" => !empty($user->address1)?$user->address1:''],
                                    'name' => $user->name,
                                    'phone' => $user->mobile,
                                ]
                    ]);
  
                              
                    $charge = Stripe\Charge::create(
                                    [
                                        "amount" => 100 * $total_price,
                                        "currency" => strtolower($stripe_currency),
                                        "source" => $request->stripeToken??'',
                                        "description" => $recieptdetails,
//                                        'transfer_group' => $cart_id,
                                        'receipt_email' => $user->email, 
                                        'metadata' => [
                                            'order_note' => $request->order_note??'',
                                            "order_id" => $cart_id,
                                        ],
                                    ]
                    );
                    
                   
                   
                }else{
                    
                }
                
                
                    if((!empty($charge->captured) && !empty($charge->paid)) || $method =="wallet"){
             
                         $marketplace_order= \App\UserPayment::create(
                                [
                                    'order_id' => $cart_id,
                                    'name' => $objUser->name,
                                    'email' => $objUser->email,
                                    'card_number' => $charge['payment_method_details']['card']['last4']??'',
                                    'card_exp_month' => $charge['payment_method_details']['card']['exp_month']??'',
                                    'card_exp_year' => $charge['payment_method_details']['card']['exp_year']??'',
                                    'entity_type' => 'Shop Payment',
                                    'entity_id' => 0,
                                    'title' => 'Shop Payment',
                                    'amount' => $total_price,
                                    'status' => "Paid",
                                    'price_currency' => $charge['currency']??'',
                                    'txn_id' => $charge['balance_transaction']??'',
                                    'payment_type' => !empty($method) ? ucwords($method) :'STRIPE',
                                    'payment_status' => $charge['status']??'free',
                                    'receipt' => $charge['receipt_url']??'',
                                    'user_id' => $objUser->id,
                                    'paid_to_user_id' => get_domain_user()->id,
                                    'other_description' => $recieptdetails."<br>Order Note: ".$request->order_note,
                                    'discount' => $deal_discount,
                                    'qty' => $total_qty,
                                ]
                        );
                        
                       if($method =='wallet' && $total_price > 0.00){
                          
                        \App\UserWalletTransactions::create(
                                [
                          
                                    'from' => $objUser->id,
                                    'to' => get_domain_user()->id,
                                    'amount' => $total_price,
                                    'invoice_id' => $marketplace_order->id,
                                    'description' => "Shop order#".$cart_id." payment",
                                ]
                        );

                        $objUser->wallet_balance=$objUser->wallet_balance - $total_price;
                        $objUser->save();
                    }
                        
                    
                                 foreach ($billdetails as $row){
                                     
                                     $shop_owner_details= \App\User::find($row['user_id']);
                                     $sub_recieptdetails = $row['name'] . " X " . $row['qty'] . " Price " . format_price($row['subtotal']-$row['deal']);
                                     if(!empty($row['deal'])){
                                     $sub_recieptdetails .= $deal_name . " (Discount) " . format_price($row['deal']) . " applied";  
                                     }
                                     
                                          $order_id = strtoupper(str_replace('.', '', uniqid('', true)));

                                     //transfer details
                                     if($shop_owner_details->type !="admin"){
//                                      $transfer = \Stripe\Transfer::create([
//                                    'amount' => 100 * ($row['subtotal']-$row['deal']),
//                                    'currency' => strtolower($charge['currency']??''),
//                                    "source_transaction" => $charge->id,
//                                    'destination' => $shop_owner_details->connected_stripe_account_id,
//                                    "description" => $sub_recieptdetails,
//                                    'transfer_group' => $cart_id,
//                                    'metadata' => [
//                                        'order_note' => $request->order_note,
//                                        "order_id" => $order_id
//                                    ],
//                                    ]);
                                     }
                         
                                      
                                           \App\ProductOrder::create(
                                            [
                                                'order_id' => $order_id,
                                                'name' => $user->name,
                                                'email' => $user->email,
                                                'card_number' => $charge['payment_method_details']['card']['last4']??'',
                                                'card_exp_month' => $charge['payment_method_details']['card']['exp_month']??'',
                                                'card_exp_year' => $charge['payment_method_details']['card']['exp_year']??'',
                                                'product_id' => $row['id'],
                                                'product_name' => $row['name'],
                                                'amount' => ($row['subtotal']-$row['deal']),
                                                'status' => "Pending",
                                                'price_currency' => $charge['currency']??'usd',
                                                'txn_id' => !empty($transfer['balance_transaction']) ? $transfer['balance_transaction'] : ($charge['balance_transaction']??''),
                                                'payment_type' => !empty($method) ? ucwords($method) :'STRIPE',
                                                'payment_status' => !empty($transfer->id) ? "Transferred To Connected Account" :"succeeded",
                                                'receipt' => $charge['receipt_url']??'',
                                                'user_id' => $purchaser->id,
                                                 'transfer_id' => !empty($transfer->id) ? $transfer->id:0,
                                                 'customer_id' => $customer->id??0,
                                    'order_note' => $request->order_note,
                                    'order_description' => $sub_recieptdetails,
                                    'discount' => $row['deal'],
                                    'qty' => $row['qty'],
                                    'cart_id' => $cart_id,
                                    'drop_shipper' => ($purchaser->id==$user->id) ? 0:$user->id,
                                            ]
                                             );
                                           
                                           
                                           $productitem= \App\ShopProduct::find($row['id']);
                                           $productitem->quantity=$productitem->quantity-$row['qty'];
                                           $productitem->save();
                                   
                                      
                                 }
                                 //empty cart
                                 LaraCart::destroyCart();
              
                                 //send email
                                 try {
                                           
                                  $emailbody=[
                'Order#'=>$cart_id,
           
                'Order Details'=>$sub_recieptdetails,
                'Amount'=> format_price($total_price),
                'Invoice'=> url('/').'/invoice/'. encrypted_key($marketplace_order->id,'encrypt'),
            ];
                                  if($purchaser->id !=$user->id){
                                      $emailbody['DropShipped For']=$purchaser->name;
                                  }
           // dd(   $emailbody);
            $resp = \App\Utility::send_emails($objUser->email, $objUser->name, null, $emailbody,'shop_order_confirmation_email',$objUser);
            
            if($purchaser->id !=$user->id){
                             $emailbody=[
                'Order#'=>$cart_id,
                'DropShipped By'=>$user->name,
           
                'Order Details'=>$sub_recieptdetails,
                'Amount'=> format_price($total_price),
                'Invoice'=> url('/').'/invoice/'. encrypted_key($marketplace_order->id,'encrypt'),
            ];
           // dd(   $emailbody);
            $resp = \App\Utility::send_emails($purchaser->email, $purchaser->name, null, $emailbody,'shop_order_confirmation_email',$purchaser);
            
            }
                            } catch (Exception $ex) {
//                          //  print_r($ex);
                            }
                                 return redirect()->route('shop.dashboard',encrypted_key($user->id, 'encrypt'))->with('success', __('Order placed successfully!'));
                        
                    }else{
                       return redirect()->back()->with('error', __('Your Payment has failed!')); 
                    }
                     
               

                
            } catch (\Exception $e) {
                return redirect()->back()->with('error', __($e->getMessage()));
            }
        } else {
            return redirect()->back()->with('error', __('Permission Denied.'));
        }
    }
}
