<?php

namespace App\Http\Controllers;

use App\Plan;
use App\PublicPageDetail;
use App\PublicDonationUser;
use App\PublicDonationOrder;
use Illuminate\Support\Str;
use App\Utility;
use Mail;
use App\State;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use App\User;
use Illuminate\Support\Facades\Hash;
use SimpleSoftwareIO\QrCode\Facades\QrCode;
use DataTables;
use DB;
use App\UserDomain;
use Carbon\Carbon;
class DonationController extends Controller
{
    protected $user;
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function donation_dashboard(Request $request,$view = 'grid')
    {
        if ($request->ajax() && !empty($request->blockElementsData)) {
                if (!empty($request->duration)) {
                    $tilldate = Carbon::now()->addMonth($request->duration)->toDateTimeString();
                }
                  $total_donar=PublicDonationUser::where('user_id',Auth::user()->id);
        if (!empty($tilldate)) {
                    $total_donar->where("created_at", ">", $tilldate);
                }
                       $total_donar=$total_donar->count();
        $total_states=PublicDonationUser::where('user_id',Auth::user()->id)->groupBy('state');
        if (!empty($tilldate)) {
                    $total_states->where("created_at", ">", $tilldate);
                }
                        $total_states=$total_states->count();
       $total_yearly=PublicDonationOrder::where('user_id',Auth::user()->id);
         if (!empty($tilldate)) {
                    $total_yearly->where("created_at", ">", $tilldate);
                }
                        $total_yearly=$total_yearly->sum('amount');

        
                      
                        return json_encode([
                    'donors' => $total_donar,
                    'states' => $total_states,
                    'revenue' => format_price($total_yearly),
                ]);
                
                
                
         }else{
        if(isset($_GET['view'])){
            $view = 'list';
        }
        $home_data = array();
        $home_data['total_donar']=PublicDonationUser::where('user_id',Auth::user()->id)->whereMonth('donation_date', date('m'))->count();
        $home_data['total_states']=PublicDonationUser::where('user_id',Auth::user()->id)->whereMonth('donation_date', date('m'))->groupBy('state')->count();
        $home_data['total_monthly']=PublicDonationOrder::where('user_id',Auth::user()->id)->whereMonth('donation_date', date('m'))->sum('amount');
        $home_data['total_yearly']=PublicDonationOrder::where('user_id',Auth::user()->id)->whereYear('donation_date', date('Y'))->sum('amount');

        $user = Auth::user();
        $seven_days      = Utility::getLastSevenDays();

        $donation_overview    = [];
        foreach($seven_days as $date => $day) {
            $donation_overview[] = array('period'=>$date,'total'=> PublicDonationOrder::where('user_id',Auth::user()->id)->whereDate('donation_date',$date)->count());
        }
        $home_data['donations_overview']    = $donation_overview;
        $user_domain_id = get_domain_id();
        $user_setting = DB::table('website_setting')->where('user_domain_id', $user_domain_id)->where('name', 'payment_settings')->first();
        $payment ='';
        if(!empty($user_setting)){
        $payment = json_decode($user_setting->value,true);
        }
        return view('donation.dashboard',compact('user_setting', 'home_data','payment'));
         }
    }

    public function index()
    {
        $user = Auth::user();
        $detail = PublicPageDetail::where('user_id',$user->id)->first();
        $donation_form_data = '';
        $id = '';
        if($detail){
            $donation_form_data = json_decode($detail->donation_form_data);
            $id = base64_encode($detail->id);
        }
        return view('donation.index',compact('detail', 'donation_form_data', 'id'));
    }
	public function qrcode(Request $request)
    { 
		$url=url('/'.$request->id.'/donation');
		$ch = curl_init();  
		$timeout = 5;  
		curl_setopt($ch,CURLOPT_URL,'http://tinyurl.com/api-create.php?url='.$url);  
		curl_setopt($ch,CURLOPT_RETURNTRANSFER,1);  
		curl_setopt($ch,CURLOPT_CONNECTTIMEOUT,$timeout);  
		$tinyurl = curl_exec($ch);  
		curl_close($ch); 

		return view('donation.qrcode',compact('tinyurl','url'));
	}
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        
        $user = Auth::user();
        $validation = [
            'public_title' => 'required',
             'public_subtitle' => 'required',
             'continue_to_full_site' => 'required',
        ];

        if($request->hasFile('image'))
        {
            $validation['image'] = 'mimes:jpeg,jpg,png';
        }
        if($request->hasFile('bgimage'))
        {
            $validation['bgimage'] = 'mimes:jpeg,jpg,png';
        }
        $validator = Validator::make(
            $request->all(), $validation
        );

        if($validator->fails())
        {
            return redirect()->back()->with('error', $validator->errors()->first());
        }
        if($request->id){
            $public_detail = PublicPageDetail::find($request->id);
        }else{
            $detail  = new PublicPageDetail();
        }
        $detail['user_id']      = $user->id;
        $detail['public_title']        =strip_tags($request->public_title);
        $detail['public_subtitle']     = strip_tags($request->public_subtitle);
        $detail['url']       = $request->continue_to_full_site;
        $detail['type']      = "Donation";
        if (!empty($request->image)) {
            $base64_encode = $request->image;
            $folderPath = "storage/details/";
            $image_parts = explode(";base64,", $base64_encode);
            $image_type_aux = explode("image/", $image_parts[0]);
            $image_type = $image_type_aux[1];
            $image_base64 = base64_decode($image_parts[1]);
            $image = "details". uniqid() . '.'.$image_type;;
            $file = $folderPath.$image;
            file_put_contents($file, $image_base64);
            $detail['image'] = $image;
        }
        if (!empty($request->bgimage)) {
            $base64_encode = $request->bgimage;
            $folderPath = "storage/details/";
            $image_parts = explode(";base64,", $base64_encode);
            $image_type_aux = explode("image/", $image_parts[0]);
            $image_type = $image_type_aux[1];
            $image_base64 = base64_decode($image_parts[1]);
            $image = "details". uniqid() . '.'.$image_type;;
            $file = $folderPath.$image;
            file_put_contents($file, $image_base64);
            $detail['bgimage'] = $image;
        }

        $donation_form_data = [
            'section_1' => $request->section_1,
            'heading_section_2' => $request->heading_section_2,
            'description_section_2' => $request->description_section_2,
            'checkbox_section_2' => $request->checkbox_section_2,
            'checkbox_section_3' => $request->checkbox_section_3,
            'checkbox_section_4' => $request->checkbox_section_4,
            'continue_to_full_site' => $request->continue_to_full_site,
            'success_message' => $request->success_message,
            'error_message'=> $request->error_message,
        ];
        $detail['donation_form_data'] = json_encode($donation_form_data);
        if($request->id){
            $public_detail->update($detail);
        }else{
            $detail->save();
             ///add in donation
            $user = Auth::user();
         $data= array(
                    'email' => $user->email,
                    'fname' => $user->name,
                    'phone' => $user->phone,
                );
            $response= \App\Contacts::create_contact($data, 'Donors');
        }
        $url = url()->previous();
        if($url == url('/'). "/donation/page"){
            return redirect()->to('donation/page')->with('success', __('Details Updated successfully.'));
        }else{
             return redirect()->to($url)->with('success', __('Details Updated successfully.'));
        }

    }

    public function public_index(Request $request){
        $id = base64_decode($request->id);
        $user = Auth::user();
        $detail = PublicPageDetail::where('id',$id)->first();
        $donation_form_data = '';
        $id = '';
        if($detail){
            $donation_form_data = json_decode($detail->donation_form_data);
            $id = base64_encode($detail->id);
        }
        $state = State::get();
        $user_id = get_domain_id();
        $user_setting = DB::table('website_setting')->where('user_domain_id', $user_id)->where('name', 'payment_settings')->first();
        if($user_setting == null){
            return redirect('/')->with('error', __('Payment method not configured.'));
        }
        $payment = json_decode($user_setting->value,true);

        return view('donation.public', compact('detail', 'donation_form_data','id','state', 'user_id', 'payment'));
    }
    public function create_donation(Request $request){
        $user_id = get_domain_id();
        // if($request->monthlygift){
            $emailexist = User::where('email',$request->donor_email_addressname)->first();
            if(!empty($emailexist)){
                $user = User::where('id',$emailexist->id)->first();
            }else{
                $password = Str::random(10);
                $user_data = array(
                "name" => $request->billing_first_namename .' '. $request->billing_last_namename,
                "email" => $request->donor_email_addressname,
                "type" => 'client',
                "password" => Hash::make($password),
                );
                $user_insert = User::create($user_data);
                if($user_insert){
                $uArr = [
                    'email' => $request->donor_email_addressname,
                    'password' => $password,
                ];
                $last_id = $user_insert->id;
                $user = User::where('id',$last_id)->first();
                // send email
                //$resp = \App\Utility::send_emails($request->donor_email_addressname, $request->billing_first_namename, null, $uArr,'invite',$user);
                    
                }
            }
        // }else{
        //     $user = Auth::user();
        // }
        $today = date("Y-m-d");
        if(!empty($request->donation)){
            $amount = $request->donation;
        }else{
            $amount =$request->amount;
        }
        if(!empty($request->success_message)){
            $success_message = $request->success_message;
        }else{
            $success_message ="You have successfully Donate to this Payment.";
        }
        if(!empty($request->error_message)){
            $error_message = $request->error_message;
        }else{
            $error_message ="There was an error charging your card, please try again.";
        }
        if($amount > 0) {
            $user_name = $request->billing_first_namename;
            $user_email = $request->donor_email_addressname;
            if ($user_id) {
                $user_setting = DB::table('website_setting')->where('user_domain_id', $user_id)->where('name','payment_settings')->first();
                $payment = json_decode($user_setting->value,true);
                $stripe_secret_key = $payment['STRIPE_SECRET'];
            }
            $stripe = new \Stripe\StripeClient($stripe_secret_key);

            try {
                $customer = $stripe->customers->create([
                    "description" => "Donar User ",
                    "name" => $user_name,
                    "email" => $user_email
                ]);
            } catch (\Exception $e) {

                return response()->json(array(
                    'success' => true,
                    'message' => $e->getMessage()
                ), 200);
            }

            $card = $this->stripecard($customer->id, $request->token);
            $charge = $this->stripecharges($customer, $amount, "Donation from " . $request->billing_first_namename . " " . $request->billing_last_namename );

            if (!empty($request->monthlygift)) {
                $monthlygift = $request->monthlygift;
            } else {
                $monthlygift = " ";
            }

            if ($charge->status == "succeeded") {

                $user_arr = array();
                $user_arr['fname'] = $request->billing_first_namename;
                $user_arr['user_id'] = $user->id;
                $user_arr['stripe_customer'] = $customer->id;
                $user_arr['lname'] = $request->billing_last_namename;
                $user_arr['address'] = $request->billing_addr_street1name;
                $user_arr['city'] = $request->billing_addr_cityname;
                $user_arr['state'] = $request->billing_addr_state;
                $user_arr['country'] = $request->billing_addr_country;
                $user_arr['zip'] = $request->billing_addr_zipname;
                $user_arr['email'] = $request->donor_email_addressname;
                $user_arr['monthlygift'] = $monthlygift;
                $user_arr['donation_date'] = $today;
                $user_arr['details'] = '';


                $result = PublicDonationUser::create($user_arr);
                $domain_user= get_domain_user();
                $userdata= $result;   
                 $emailbody=[
                               'Amount'=> format_price($amount),
                                'Received By'=>$domain_user->name,
                                'Receiver Tax ID'=>$domain_user->tax_id,
                                'Receiver 501c3'=>$domain_user->fiftyzeroonec,
                     ];
                
         // dd($userdata->email);
                 try{
                $resp = \App\Utility::send_emails($userdata->email, $userdata->fname, null, $emailbody,'donation',$userdata);
                 } catch (Exception $e){
                     
                 }
                   //  dd($resp);

                if ($result->id) {
                    $data = array(
                        "status" => "Paid"
                    );
                    $data['amount'] = $amount;
                    $data['stripe_customer'] = $customer->id;
                    $data['user_id'] = $user->id;
                    $data['pdonation_users_id'] = $result->id;
                    $data['monthlygift'] = $monthlygift;
                    $data['donation_date'] = $today;
                    $data['tranaction_id'] = $charge->id;
                    PublicDonationOrder::create($data);

                    return response()->json(array(
                        'success' => true,
                        'message'=>$success_message
                    ), 200);
                }else{
                    return response()->json(array(
                        'error' => false,
                        'message'=>$error_message
                    ), 400);
                }
            }
        }else{
            return response()->json(array(
                'error' => false,
                'message'=>"Please enter Valid details"
            ), 400);
        }



    }
    public function stripecard($customerId, $token) {
        $user_id = get_domain_id();
        $custom_url = User::where('id', $user_id)->first();
        if ($user_id) {
            $user_setting = DB::table('website_setting')->where('user_domain_id', $user_id)->where('name','payment_settings')->first();
            $payment = json_decode($user_setting->value,true);
            $stripe_secret_key = $payment['STRIPE_SECRET'];
        }
        \Stripe\Stripe::setApiKey($stripe_secret_key);
        $card ="";
        try{
            $card = \Stripe\Customer::createSource(
                $customerId,
                [
                    'source' => $token,
                ]
            );
        }catch(\Exception $e){
            return response()->json(array(
                'success' => false,
                'message'=>$e->getMessage()
            ), 400);
        }
        return $card;
    }
    public function stripecharges($customer, $amount, $description, $seller = NULL) {
        $user_id = get_domain_id();
        $domainData = UserDomain::whereId($user_id)->first();
        $custom_url = User::where('id', $domainData->user_id)->first();
        
        if ($user_id) {
            $user_setting = DB::table('website_setting')->where('user_domain_id', $user_id)->where('name','payment_settings')->first();
            $payment = json_decode($user_setting->value,true);
            $stripe_secret_key = $payment['STRIPE_SECRET'];
        }
        $charge = "";
        \Stripe\Stripe::setApiKey($stripe_secret_key);
        try{
            $charge = \Stripe\Charge::create([
                "amount" => $amount * 100,
                "currency" => "usd",
                "customer" => $customer,
                "description" => $description
            ]);

            $rolescheck = \App\Role::whereRole($custom_url->type)->first();
            if($rolescheck->role == 'mentor' || $rolescheck->role == 'mentee' ){
                if(checkPlanModule('points')){
                    $checkPoint = \Ansezz\Gamify\Point::find(5);
                    if(isset($checkPoint) && $checkPoint != null ){
                        if($checkPoint->allow_duplicate == 0){
                            $createPoint = $custom_url->achievePoint($checkPoint);
                        }else{
                            $addPoint = DB::table('pointables')->where('pointable_id', $custom_url->id)->where('point_id', $checkPoint->id)->get();
                            if($addPoint == null){
                                $createPoint = $custom_url->achievePoint($checkPoint);
                            }
                        }
                    }       
                }
            }
           

        }catch(\Exception $e){
            return response()->json(array(
                'success' => false,
                'message'=>$e->getMessage()
            ), 400);
        }

        return $charge;
    }
    public function basic_email() {
        $data = array('name'=>"Nitiz Sharma");
        Mail::send('mail', $data, function($message) {
            $message->to('nitiz143@gmail.com', 'Nitiz Sharma')->subject
            ('Laravel Basic Testing Mail');
            $message->from(config('mail.from.address'),'Publicitystunt');
        });
        echo "Basic Email Sent. Check your inbox.";
    }
    public function view($view = 'grid'){
        if(isset($_GET['view'])){
            $view = 'list';
        }
        $publicdonationorder_arr =  PublicDonationOrder::select('public_donation_orders.*','public_donation_users.fname','public_donation_users.lname','public_donation_users.email')
            ->join('public_donation_users', 'public_donation_users.id', '=', 'public_donation_orders.pdonation_users_id')
            ->get();
        if(isset($_GET['view'])){
            $view = 'list';
            $returnHTML = view('donation.list', compact('view','publicdonationorder_arr'))->render();
        }else{
            $returnHTML = view('donation.grid', compact('view','publicdonationorder_arr'))->render();
        }
        return response()->json(
            [
                'success' => true,
                'html' => $returnHTML,
            ]
        );

    }
    public function destroy($id)
    { 
        $id = encrypted_key($id, 'decrypt') ?? $id;

        $PublicDonationOrder = PublicDonationOrder::find($id);
        $PublicDonationOrder->delete();
        return redirect()->to('donation/dashboard')->with('success', __('Deleted successfully.'));
    }
    public function resendletter($id)
    { 
        $id = encrypted_key($id, 'decrypt') ?? $id;
        if(empty($id)){
            return redirect()->back()->with('error', __('Incorrect record id')); 
        }
  try{
        $PublicDonationOrder = PublicDonationOrder::find($id);
        $userdata = \App\User::find($PublicDonationOrder->user_id);
      
        if(empty($userdata)){
            return redirect()->back()->with('error', __('Donor information not exist')); 
        }
       $domain_user= get_domain_user();
                 $emailbody=[
                               'Amount'=> format_price($PublicDonationOrder->amount),
                                'Received By'=>$domain_user->name,
                                'Receiver Tax ID'=>$domain_user->tax_id,
                                'Receiver 501c3'=>$domain_user->fiftyzeroonec,
                     ];
                $resp = \App\Utility::send_emails($userdata->email, $userdata->fname, null, $emailbody,'donation',$userdata);
                 } catch (Exception $e){
                    return redirect()->back()->with('error', __('Email sending error')); 
                 }
        return redirect()->back()->with('success', __('Successfully send.'));
    }
    public function cancel_payment() {
        $data = array(
            "monthlygift" => "canceled",
        );

       // $doner_user = Database::table("public_donation_users")->where("id", input("recurring"))->update($data);
      //  $recurring_payments = Database::table("public_donation_orders")->where("pdonation_users_id", input("recurring"))->update($data);

        return response()->json(responder("success", "Canceled!", "Your monthly recurring Donation is canceled.","redirect('".url("frontend@get")."')"));
    }
    public function donation_history(Request $request,$view = "grid"){
        
        $user = Auth::user();
        if ($request->ajax()) {
            $data = PublicDonationOrder::join('users', 'users.id', '=', 'public_donation_orders.user_id') 
            ->select('public_donation_orders.*', 'users.name','users.email')->orderBy('id','DESC');
            return Datatables::of($data)
                ->addIndexColumn()
                ->filterColumn('amount', function($query, $keyword) use ($request) {
                    $query->orWhere('public_donation_orders.amount', 'LIKE', '%' . $keyword . '%')
                    ->orWhere('public_donation_orders.donation_date', 'LIKE', '%' . $keyword . '%')
                    ->orWhere('public_donation_orders.monthlygift', 'LIKE', '%' . $keyword . '%')
                    ->orWhere('users.name', 'LIKE', '%' . $keyword . '%')
                    ->orWhere('users.email', 'LIKE', '%' . $keyword . '%')
                    ;
                })
                ->addColumn('name', function ($data) {
                    return $data->name;
                 }) 

                 ->addColumn('email', function ($data) {
                    return  $data->email;
                 }) 

                ->addColumn('amount', function ($data) {
                    return  number_format($data->amount);
                 })          
               ->addColumn('donation_date', function ($data) {
                return  Date('M d, Y',strtotime($data->donation_date));
            })          
         
            ->addColumn('monthlygift', function ($data) {
             return $data->monthlygift == 'monthlygift' ? '<span class="badge badge-dot mr-4">
             <i class=" bg-success "></i>
             <span class="badge badge-xs bg-success-light mr-1"> Yes</span>
             </span>' : ' <span class="badge badge-xs bg-warning-light mr-1">
             <i class=" bg-warning "></i>
             <span class="status"> No</span>
             </span>';

            })            
              ->addColumn('action', function($data){
                     $actionBtn ='<a href="'.route('donation.resend.letter',encrypted_key($data->id,'encrypt')).'" class="btn btn-sm bg-primary-light " title="'.__('Resend Letter').'">
                         <i class="fas fa-send-alt"></i> Resend Letter
                             </a>';
                    $actionBtn .= '
                    <a href="javascript::void(0);" class="btn btn-sm bg-danger-light delete_record_model" data-url="'.route('donation.destroy',encrypted_key($data->id,'encrypt')).'" data-toggle="tooltip" data-original-title="'.__('Delete').'">
                         <i class="fas fa-trash-alt"></i> Delete
                             </a>';
                   
                return $actionBtn;
            })
                ->rawColumns(['action','monthlygift'])
                ->make(true);
                return view('donation.history');
        }else{ 
        if(isset($_GET['view'])){
            $view = 'list';
        }
        $publicdonationorder_arr = new PublicDonationOrder;
        $publicdonationorder_arr = $publicdonationorder_arr->getalldata($all = 'all');
        return view('donation.history', compact('view', "publicdonationorder_arr"));

    }
}


}
