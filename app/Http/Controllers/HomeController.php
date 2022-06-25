<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\User;
use App\StripePayment;
use App\Certify;
use App\MeetingSchedule;
use App\MeetingScheduleSlot;
use App\Role;
use Carbon\Carbon;
class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */

    public function index(Request $request)
    {
        
        $user = Auth::user();
              
        
        $role_status= get_role_data($user->type,'status');
        if($user->type !="admin" && $role_status != "Active"){
              Auth::logout();
            return redirect()->route('login')->with('error', __('Oppes! Login role is InActive'));
        }
    

        if($user->type=="admin"){
            $members = User::where('is_active',1)->where('id','!=',Auth::user()->id)->count();
            $bookings = MeetingScheduleSlot::join('meeting_schedules as ms','ms.id','meeting_schedules_slots.meeting_schedule_id')->where('ms.user_id', Auth::user()->id)->where('meeting_schedules_slots.user_id','!=', null)->count();
            $mentors= User::where('is_active',1)->where('type','mentor')->orderBy('id','DESC')->paginate(10);
            $mentees= User::where('is_active',1)->where('type','mentee')->orderBy('id','DESC')->paginate(10);
            $meeting_schedules = MeetingSchedule::where('meeting_schedules.user_id', $user->id)->paginate(10);
//dd($meeting_schedules);
          // dd($bookings);
            $CertifiesCount = Certify::where('domain_id', 1)->count();
            $student = StripePayment::join('certifies', 'certifies.id', '=', 'stripe_payments.item_id')
                ->groupBy('stripe_payments.user_id')
                ->count();
            $income = StripePayment::join('certifies', 'certifies.id', '=', 'stripe_payments.item_id')
                ->where('stripe_payments.item_type', "certify")
                ->sum('total_price');
            $incomplete = StripePayment::join('certifies', 'certifies.id', '=', 'stripe_payments.item_id')
                ->where('stripe_payments.completed_on', "ongoing")
                ->where('stripe_payments.item_type', "certify")
                ->count();
             return view('admin.index_admin',compact('meeting_schedules','members','bookings','mentors','mentees','student','income','incomplete','CertifiesCount'));
        }else{

            if ($request->ajax() && !empty($request->blockElementsData)) {
                if (!empty($request->duration)) {
                    $tilldate = Carbon::now()->addMonth($request->duration)->toDateTimeString();
                }
                		 $profile_totals=0;
                  $domain_user=get_domain_user();
					
                     $usertypes=\App\User::where('created_by',$domain_user->id);
         
		
         if (!empty($tilldate)) {
                    $usertypes->where("created_at", ">", $tilldate);
                }
                 $usertypes= $usertypes->count();    
                        
                      $invoices = \App\UserPayment::where('user_id',$user->id);
         if (!empty($tilldate)) {
                    $invoices->where("created_at", ">", $tilldate);
                }
                        $invoices=$invoices->count();
                       $appointments = \App\MeetingScheduleSlot::where('user_id', '=',$user->id);
                          if (!empty($tilldate)) {
                    $appointments->where("created_at", ">", $tilldate);
                }
        $appointments=$appointments->count();
        
          $earned = \App\UserPayment::where('paid_to_user_id',$user->id);
                 if (!empty($tilldate)) {
                    $earned->where("created_at", ">", $tilldate);
                }
        $earned=$earned->sum('amount');
            $totalpaid = \App\UserPayment::where('user_id',$user->id);
              if (!empty($tilldate)) {
                    $totalpaid->where("created_at", ">", $tilldate);
                }
        $totalpaid=$totalpaid->sum('amount');
            
                        return json_encode([
                    'profiles' => $usertypes,
                    'invoices' => $invoices,
                    'appointments' => $appointments,
                    'totalearned' => format_price($earned),
                    'totalpaid' => format_price($totalpaid),
                ]);
                
                
                
         }
         return view('user.dashboard');
        }
    }
}
