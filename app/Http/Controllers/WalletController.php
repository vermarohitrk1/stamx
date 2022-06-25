<?php

namespace App\Http\Controllers;


use App\UserWalletTransactions;
use App\StripePayment;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use DataTables;
use Carbon\Carbon;
class WalletController extends Controller {


    public function index(Request $request) {
        $user = Auth::user();
               if ($request->ajax() && !empty($request->blockElementsData)) {
                if (!empty($request->duration)) {
                    $tilldate = Carbon::now()->addMonth($request->duration)->toDateTimeString();
                }
                
               $total = UserWalletTransactions::where('from', $user->id)->Orwhere('to', $user->id);
         if (!empty($tilldate)) {
                    $total->where("created_at", ">", $tilldate);
                }
                        $total=$total->count();
        $paid = UserWalletTransactions::where('from', $user->id);
        if (!empty($tilldate)) {
                    $paid->where("created_at", ">", $tilldate);
                }
                        $paid=$paid->sum("amount");
        $received = UserWalletTransactions::where('to', $user->id);
         if (!empty($tilldate)) {
                    $received->where("created_at", ">", $tilldate);
                }
                        $received=$received->sum("amount");
        
                        return json_encode([
                    'received' => format_price($received),
                    'paid' => format_price($paid),
                ]);
                
                
                
         }elseif ($request->ajax()) {                 
                
            $data = UserWalletTransactions::select("wallet_transactions.*","from.name as from_name","to.name as to_name")
                     ->leftjoin('users as from',"from.id",'wallet_transactions.from')
                     ->leftjoin('users as to',"to.id",'wallet_transactions.to')
                    ->orderBy('wallet_transactions.id', 'DESC');

           
            switch ($request->filter_type) {
                case "paid":
                    $data->where('wallet_transactions.from', $user->id);
                    break;
                case "received":
                   $data->where('wallet_transactions.to', $user->id);
                    break;
                case "invoice":
                    $data->where('wallet_transactions.from', $user->id);
                   $data->where('wallet_transactions.invoice_id','!=',0);
                    break;
                case "invoicer":
                    $data->where('wallet_transactions.to', $user->id);
                   $data->where('wallet_transactions.invoice_id','!=',0);
                    break;
                case "deposit":
                    $data->where('wallet_transactions.from', 0);
                   $data->where('wallet_transactions.to', $user->id);
                    break;
                case "feer":
                    $data->where('wallet_transactions.description', 'Wallet transfer network fee');
                   $data->where('wallet_transactions.to', $user->id);
                    break;
                case "feep":
                    $data->where('wallet_transactions.description', 'Wallet transfer network fee');
                   $data->where('wallet_transactions.from', $user->id);
                    break;
                default:
                    $data->whereRaw('(wallet_transactions.to='. $user->id.' OR wallet_transactions.from='.$user->id.")");
                    break;
            }

            //status
            if (!empty($request->filter_category)) {
                $data->where('cf.category', $request->filter_category);
            }

            //keyword
            if (!empty($request->keyword)) {
                $data->WhereRaw('(from.name LIKE "%' . $request->keyword . '%" OR to.name LIKE "%' . $request->keyword . '%" OR wallet_transactions.description LIKE "%' . $request->keyword . '%")');
            }
            return Datatables::of($data)
                ->addIndexColumn()
                ->filterColumn('form', function($query, $keyword) use ($request) {
                   // $query->WhereRaw('(subject LIKE %' . $keyword . '% OR ticket LIKE %'. $keyword . '%');
                    ;
                })
                
              
                ->addColumn('transaction', function ($data) {
                 $number = $data->id;
                $length = 10;
                $string = substr(str_repeat(0, $length).$number, - $length);
                return $string;
                 }) 
                ->addColumn('from', function ($data) {
                    $res='---';
                    if(!empty($data->from)){
                        $userdata=\App\User::find($data->from);
                    $res= '<h2 class="table-avatar">
                                                <a href="' . route('profile', ['id' => encrypted_key($data->from??0, 'encrypt')]) . '" class="avatar avatar-sm mr-2"><img class="avatar-img rounded-circle" src="' . $userdata->getAvatarUrl() . '" alt="Image"></a>
                                                <a href="' . route('profile', ['id' => encrypted_key($data->from??0, 'encrypt')]) . '">' . $userdata->name??'' . '</a>
                                            </h2>';
                }
                return $res;
                 }) 
                ->addColumn('to', function ($data) {
                    $res='';
                    if(!empty($data->to)){
                        $userdata=\App\User::find($data->to);
                    $res= '<h2 class="table-avatar">
                                                <a href="' . route('profile', ['id' => encrypted_key($data->to??0, 'encrypt')]) . '" class="avatar avatar-sm mr-2"><img class="avatar-img rounded-circle" src="' . $userdata->getAvatarUrl() . '" alt="Image"></a>
                                                <a href="' . route('profile', ['id' => encrypted_key($data->to??0, 'encrypt')]) . '">' . $userdata->name??'' . '</a>
                                            </h2>';
                }
                return $res;
                 }) 
                ->addColumn('amount', function ($data) {
                    
                 return format_price($data->amount);
                 }) 
                ->addColumn('description', function ($data) {
                    
                 $res= '<small>'.$data->description."</small>";
                 if(!empty($data->invoice_id)){
                  $res .= '<div class="actions text-right">
                         
                                                <a class="badge badge-xs bg-warning-light" data-title="View " href="' . route("payment.invoice", encrypted_key($data->invoice_id, 'encrypt')) . '">
                                                    Invoice
                                                </a>
                                            </div>';
                 }
                 return $res;
                 }) 
                ->addColumn('date', function ($data) {
                    
                 return  date('M d, Y', strtotime($data->created_at)).'<br><small>'.date('h:i:s', strtotime($data->created_at))."</small>";
                 }) 
                ->addColumn('type', function ($data) {
                       $user = Auth::user();
                    $status=(!empty($data->from) && $user->id==$data->from)?'Paid':'Received';
                    $class=(!empty($data->from) && $user->id==$data->from)?'danger':'success';

                 $slots= '<span class="badge  badge-xs bg-'.$class.'-light"> '.$status.'</span>';
                  
                 
                 return $slots;
                 }) 
                
              
                ->rawColumns(['from','to','type','amount','description','date'])
                ->make(true);
        }else{
        $total = UserWalletTransactions::where('from', $user->id)->Orwhere('to', $user->id)->count();
        $paid = UserWalletTransactions::where('from', $user->id)->sum("amount");
        $received = UserWalletTransactions::where('to', $user->id)->sum("amount");
   
        return view('wallet.index', compact( 'total','paid', 'received'));
    }

    }
     public function deposit() {
        $user = Auth::user();
          $stripe_settings=\App\SiteSettings::getValByName('payment_settings');
               
        if (!empty($stripe_settings['STRIPE_KEY']) && !empty($stripe_settings['STRIPE_SECRET']) && $stripe_settings['ENABLE_STRIPE']=="on") {
            $stripe_key=$stripe_settings['STRIPE_KEY'];
            return view('wallet.deposit', compact( 'stripe_key'));
        } else {
            return redirect()->back()->with('error', __('Stripe not enabled.'));
        }
    }
     public function transfer() {
        $user = Auth::user();
     
            $domain_user= get_domain_user();
            $walletuser = \App\User::whereRaw('(created_by='. $domain_user->id.' OR type="admin")')->where('id', '!=',$user->id)->get();
            return view('wallet.transfer', compact( 'walletuser'));
        
    }
     public function transferpost(Request $request) {
         $user = Auth::user();
        $validation = [
            'amount' => 'required|min:1',
            'destination' => 'required'
        ];
      
        $validator = Validator::make(
                        $request->all(), $validation
        );

        if ($validator->fails()) {
            return redirect()->back()->withInput()->withErrors($validator);
        }
     
        if ($user->wallet_balance > ($request->amount+1)) {
           $receiver=\App\User::find($request->destination);
           $receiver->wallet_balance=$receiver->wallet_balance+$request->amount;
           $status=$receiver->save();
           
          
             $user->wallet_balance=$user->wallet_balance - $request->amount - 1; 
             $user->save();
             
           if(!empty($status)){
               $domain_user= get_domain_user();
           $domain=\App\User::find($domain_user->id);
           $domain->wallet_balance=$domain->wallet_balance+1;
           $domain->save();
           
             
            \App\UserWalletTransactions::create(
                                [
                          
                                    'from' => $user->id,
                                    'to' => $request->destination,
                                    'amount' => $request->amount,
                                    'description' => "Wallet amount transfer",
                                ]
                        );
            \App\UserWalletTransactions::create(
                                [
                          
                                    'from' => $user->id,
                                    'to' => $domain_user->id,
                                    'amount' => 1,
                                    'description' => "Wallet transfer network fee",
                                ]
                        );
             
           }else{
               return redirect()->back()->with('error', __('Some thing wrong'));
           }
          
           
           
            
           
           
           
       
           return redirect()->back()->with('success', __('Amount transfered'));
        } else {
            return redirect()->back()->with('error', __('Low wallet balance'));
        }
    }
	
	    public function stripe_payment(Request $request)
    {
        $StripePayment = new StripePayment();
        $StripePayment = $StripePayment->makePaymentBackend($request);
        if ($StripePayment) {
            if ($request->itemType == 'wallet') {
                return redirect()->back()->with('success', __('Payment successful  money added to your wallet.'));
            } elseif ($request->itemType == 'adx') {
                return redirect()->back()->with('success', __('Payment successful for your adx.'));
            } elseif ($request->itemType == 'newsroom') {
                return redirect()->back()->with('success', __('Payment successful for newsroom order.'));
            } elseif ($request->itemType == 'guestpert') {
                return redirect()->back()->with('success', __('Payment successful for guestpert order.'));
            } else {
                return redirect()->back()->with('success', __('Payment successful  Continue For Next Step.'));
            }
        }
    }
}
