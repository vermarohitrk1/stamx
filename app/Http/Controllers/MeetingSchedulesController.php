<?php

namespace App\Http\Controllers;

use SimpleSoftwareIO\QrCode\Facades\QrCode;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\File;
use DateTime;
use DateInterval;
use DatePeriod;
use App\User;
use DataTables;
use App\MeetingSchedule;
use App\MeetingScheduleSlot;
use App\MeetingScheduleSlotCanceled;
use Carbon\Carbon;


class MeetingSchedulesController extends Controller {

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    protected $user;
    public function index(Request $request) {
         
               $date=date('Y-m-d');
                $endtime=date('H:i:s');
                    $authuser = Auth::user();
        $domain_id = get_domain_id();
        if ($request->ajax() && !empty($request->blockElementsData)) {
                if (!empty($request->duration)) {
                    $tilldate = Carbon::now()->addMonth($request->duration)->toDateTimeString();
                }
                $schedules = MeetingSchedule::where('user_id', $authuser->id);
           if (!empty($tilldate)) {
                    $schedules->where("created_at", ">", $tilldate);
                }
                        $schedules=$schedules->count();
                $bookings =MeetingScheduleSlot::join('meeting_schedules as ms','ms.id','meeting_schedules_slots.meeting_schedule_id')->where('ms.user_id', $authuser->id)->where('meeting_schedules_slots.user_id','!=', null);
         if (!empty($tilldate)) {
                    $bookings->where("ms.created_at", ">", $tilldate);
                }
                        $bookings=$bookings->count();
                $revenue =MeetingScheduleSlot::join('meeting_schedules as ms','ms.id','meeting_schedules_slots.meeting_schedule_id')->where('ms.user_id', $authuser->id)->where('meeting_schedules_slots.user_id','!=', null);
         if (!empty($tilldate)) {
                    $revenue->where("ms.created_at", ">", $tilldate);
                }
                        $revenue=$revenue->sum('ms.price');
                
       
                    
                    
                        return json_encode([
                    'bookings' => $bookings,
                    'schedules' => $schedules,
                    'revenue' => format_price($revenue),
                ]);
                
                
                
         }elseif ($request->ajax()) {
            $data = MeetingSchedule::where('meeting_schedules.user_id', $authuser->id);
            return Datatables::of($data)
                ->addIndexColumn()
                ->filterColumn('title', function($query, $keyword) use ($request) {
                    $query->orWhere('meeting_schedules.title', 'LIKE', '%' . $keyword . '%')
                    ->orWhere('meeting_schedules.description', 'LIKE', '%' . $keyword . '%')
                    ;
                })
                ->orderColumn('title', function ($query, $order) {
                   
                     $query->orderBy('meeting_schedules.id', $order);
                 })
                ->orderColumn('price', function ($query, $order) {
                   
                     $query->orderBy('meeting_schedules.price', $order);
                 })
                ->addColumn('title', function ($data) {
                    
                     return ucfirst(substr($data->title,0,20))."..";
                 }) 
                ->addColumn('description', function ($data) {
                     return ucfirst(substr($data->description,0,15))."..";
                 }) 
                ->addColumn('price', function ($data) {
                     return format_price($data->price);
                 }) 
                ->addColumn('status', function ($data) {
                     return ($data->status);
                 }) 
                ->addColumn('slots', function ($data) {
                        $date=date('Y-m-d');
                        $endtime=date('H:i:s');
                    $authuser = Auth::user();
                    
                     $booked= MeetingScheduleSlot::where('meeting_schedule_id', $data->id)->where('user_id','!=', null)->count();
                    
 $available= MeetingScheduleSlot::where('meeting_schedule_id', $data->id)->where('user_id', null)->where('date','>=', $date)->count();

                     $skipped= MeetingScheduleSlot::where('meeting_schedule_id', $data->id)->where('user_id', null)->where('date','<', $date)->count();
                     

                 $slots= '<span class="badge  badge-xs bg-success-light">Open: '.$available.'</span>';
                 $slots .= '<br><span class="badge  badge-xs bg-primary-light">Booked: '.$booked.'</span>';
                 $slots .= '<br><span class="badge badge-xs bg-danger-light">Expired: '.$skipped.'</span>';
                 return $slots;
                 }) 
              
                 ->addColumn('service_type', function ($data) {
                     if($data->service_type_id==2){
                         $course= \App\Certify::find($data->service_id);
                         $course_name=$course->name??'Unknown';
                         $res= '<div class="actions ">
                                                <a class="btn btn-sm bg-warning-light" data-title="General Consultancy " href="'.route("course.details",encrypted_key($data->service_id,'encrypt')).'">
                                                    Course Consultancy - '.substr($course_name,0,10).'..
                                                </a>
                                            </div>';
                     }else{
                        $res= MeetingSchedule::getServiceType($data->service_type_id);
                     }
                  return $res;
                  })
                                 
              ->addColumn('action', function($data){
                    $actionBtn = '<div class="actions text-right ">
                         <a href="#" class="btn btn-sm bg-primary-light mt-1" data-url="'.route('meeting.schedule.slot.create',encrypted_key($data->id,'encrypt')).'" data-ajax-popup="true" data-size="lg" data-title="Add Schedule Time Slots">
         <i class="fas fa-plus"></i>
                                                    Add Slots
    </a><br>
                                                <a class="btn btn-sm bg-success-light mt-1" data-title="Edit " href="'.route("meeting.schedule.edit",encrypted_key($data->id,'encrypt')).'">
                                                    <i class="fas fa-pencil-alt"></i>
                                                    Edit
                                                </a>
                                                <a data-url="' . route('meeting.schedule.destroy',encrypted_key($data->id,'encrypt')) . '" href="#" class="btn btn-sm bg-danger-light delete_record_model mt-1">
                                                    <i class="far fa-trash-alt"></i> Delete
                                                </a>
                                            </div>';
                    
                   
                return $actionBtn;
            })
                ->rawColumns(['action','service_type','price','title','slots'])
                ->make(true);
        }else{ 
       
                $schedules = MeetingSchedule::where('user_id', $authuser->id)->count();
                $bookings =MeetingScheduleSlot::join('meeting_schedules as ms','ms.id','meeting_schedules_slots.meeting_schedule_id')->where('ms.user_id', $authuser->id)->where('meeting_schedules_slots.user_id','!=', null)->count();
                $revenue =MeetingScheduleSlot::join('meeting_schedules as ms','ms.id','meeting_schedules_slots.meeting_schedule_id')->where('ms.user_id', $authuser->id)->where('meeting_schedules_slots.user_id','!=', null)->sum('ms.price');
                return view('meetings.index', compact('schedules','bookings','revenue'));
    }

    }
    
    
    public function create() {
        $authuser = Auth::user();
        $domain_id= get_domain_id();
        $type = MeetingSchedule::getServiceType();
        $courses = \App\Certify::where('domain_id',$domain_id)->where("status",'Published')->get();
        return view('meetings.create', compact('type', 'courses'));
    }

    public function store(Request $request) {
       // dd($request);
        $user = Auth::user();
         $domain_id= get_domain_id();
        $validation = [
            'title' => 'required',
            'description' => 'required',
        ];

        $validator = Validator::make(
                        $request->all(), $validation
        );

        if ($validator->fails()) {
            return redirect()->back()->with('error', $validator->errors()->first());
        }
      
        $save = new MeetingSchedule();
        $save['user_id'] = $user->id;
        $save['domain_id'] = $domain_id;
        $save['title'] = $request->title;
        $save['description'] = $request->description;
        $save['service_type_id'] = $request->service_type_id;
        $save['service_id'] = $request->service_id;
        $save['price'] = $request->price;
        $save['price_description'] = $request->price_description;
        $save['status'] = $request->status;
        $save->save();
        
        ///add in donation
            $user = Auth::user();
         $data= array(
                    'email' => $user->email,
                    'fname' => $user->name,
                    'phone' => $user->phone,
                );
            $response= \App\Contacts::create_contact($data, 'Booking');

            // create points
            
            $rolescheck = \App\Role::whereRole($user->type)->first();
            if(in_array("points", json_decode($rolescheck->permissions)) == true){
                $checkPoint = \Ansezz\Gamify\Point::find(4);
                if($checkPoint->allow_duplicate == 0){
                    $createPoint = $user->achievePoint($checkPoint);
                }   
            }
            // create points ends
        return redirect()->back()->with('success', __('Meeting Schedule Created successfully.'));
    }

    public function edit($id=0) {
        $domain_id= get_domain_id();
          $id = encrypted_key($id, 'decrypt') ?? $id;
        if ($id == '') {
            return redirect()->back()->with('error', __('Id is mismatch.'));
        } 
            $authuser = Auth::user();
        $domain_id= get_domain_id();
        $data = MeetingSchedule::find($id);
        $type = MeetingSchedule::getServiceType();
        $courses = \App\Certify::where('domain_id',$domain_id)->where("status",'Published')->get();
        return view('meetings.edit', compact('type', 'courses','data'));
    }

    public function update(Request $request) {
 
          $user = Auth::user();
         $domain_id= get_domain_id();
        $validation = [
            'title' => 'required',
            'description' => 'required',
        ];

        $validator = Validator::make(
                        $request->all(), $validation
        );

        if ($validator->fails()) {
            return redirect()->back()->with('error', $validator->errors()->first());
        }
       
         $data = MeetingSchedule::find($request->id);
        $save['user_id'] = $user->id;
        $save['domain_id'] = $domain_id;
        $save['title'] = $request->title;
        $save['description'] = $request->description;
        $save['service_type_id'] = $request->service_type_id;
        $save['service_id'] = $request->service_id;
        $save['price'] = $request->price;
        $save['price_description'] = $request->price_description;
        $save['status'] = $request->status;
        $data->update($save);
        
        return redirect()->route('meeting.schedules.index')->with('success', __('Updated successfully.'));
    }

    public function destroy($id=0) {
          $id = encrypted_key($id, 'decrypt') ?? $id;
        if ($id == '') {
            return redirect()->back()->with('error', __('Id is mismatch.'));
        } 
        $folder = MeetingSchedule::find($id);
        $folder->delete();
        return redirect()->route('meeting.schedules.index')->with('success', __('deleted successfully.'));
    }
    
    
    public function slot_index(Request $request) {
         
        $authuser = Auth::user();
        $domain_id = get_domain_id();
        $date=date('Y-m-d');
        $endtime=date('H:i:s');
       
       
        if ($request->ajax()) {
            $data = MeetingScheduleSlot::select('meeting_schedules_slots.*','ms.title')
                    ->join('meeting_schedules as ms','ms.id','meeting_schedules_slots.meeting_schedule_id')
                    ->where('meeting_schedules_slots.user_id', null)
                    ->where('ms.user_id', $authuser->id)
                    ->where('meeting_schedules_slots.date','>=', $date)
                    ->orderBy('meeting_schedules_slots.date','asc')
                    ->orderBy('meeting_schedules_slots.start_time','asc');
            return Datatables::of($data)
                ->addIndexColumn()
                ->filterColumn('title', function($query, $keyword) use ($request) {
                    $query->orWhere('ms.title', 'LIKE', '%' . $keyword . '%')
                    ;
                })
                ->orderColumn('date', function ($query, $order) {
                     $query->orderBy('meeting_schedules_slots.date', $order);
                 })
                 ->orderColumn('time', function ($query, $order) {
                     $query->orderBy('meeting_schedules_slots.start_time', $order);
                 })
                ->addColumn('title', function ($data) {
                     return ucfirst(substr($data->title,0,40))."..";
                 }) 
                ->addColumn('date', function ($data) {
                     return date('M d, Y', strtotime($data->date));
                 }) 
                ->addColumn('time', function ($data) {
                     return '<div class="actions ">
                         <span disabled class="btn btn-sm bg-primary-light"  title="Schedule Time Slots">
        '.date('h:i a', strtotime($data->start_time)).' - '.date('h:i a', strtotime($data->end_time)).'
    </span></div>';
                 }) 
                 
                
                                 
              ->addColumn('action', function($data){
                    $actionBtn = '<div class="actions text-right">
                    <a class="btn btn-sm bg-success-light mt-1" href="javascript:void(0)" data-size="lg" data-ajax-popup="true" data-title="Edit Slot" data-url="'.route('meeting.schedule.slot.edit',encrypted_key($data->id,'encrypt')).'">
                                                    <i class="fas fa-pencil-alt"></i>
                                                    Edit
                                                </a>
                                                <a data-url="' . route('meeting.schedule.slot.destroy',encrypted_key($data->id,'encrypt')) . '" href="#" class="btn btn-sm bg-danger-light delete_record_model">
                                                    <i class="far fa-trash-alt"></i> Delete
                                                </a>
                                            </div>';
                    
                   
                return $actionBtn;
            })
                ->rawColumns(['action','title','date','time'])
                ->make(true);
        }else{ 
       
                return view('meetings.slots.index');
    }

    }
    
    
    public function slot_create($id=0) {
         $id = encrypted_key($id, 'decrypt') ?? $id;
        if ($id == '') {
            return redirect()->back()->with('error', __('Id is mismatch.'));
        }
        $authuser = Auth::user();
        $domain_id= get_domain_id();
        $type = MeetingSchedule::getServiceType();
        $courses = \App\Certify::where('domain_id',$domain_id)->where("status",'Published')->get();
        return view('meetings.slots.create', compact('type', 'courses','id'));
    }

    public function slot_store(Request $request) {
        $user = Auth::user();
         $domain_id= get_domain_id();
        $validation = [
            'id' => 'required',
            'date' => 'required',
        ];

        $validator = Validator::make(
                        $request->all(), $validation
        );

        if ($validator->fails()) {
            return redirect()->back()->with('error', $validator->errors()->first());
        }

           $stripe_settings=\App\SiteSettings::getValByName('payment_settings'); 
                if(empty($stripe_settings) || empty($stripe_settings['ENABLE_STRIPE']) || $stripe_settings['ENABLE_STRIPE'] == 'off' || empty($stripe_settings['STRIPE_KEY'])){
                    return redirect()->back()->with('error', __('Please configure the stripe!'));
                }
            
        $days=!empty($request->schedule_for_weeks) ? $request->schedule_for_weeks*7:1;
        $bookings_number=!empty($request->bookings_number) ? $request->bookings_number:1;
        $begin = new DateTime($request->date);
        $end = new DateTime(date('Y-m-d', strtotime($request->date. ' + '.$days.' days')));

$interval = DateInterval::createFromDateString('1 day');
$period = new DatePeriod($begin, $interval, $end);

foreach ($period as $dt) {
    $day=$dt->format("l");
    $date=$dt->format("Y-m-d");
    if(empty($request->days_selected) || (!empty($request->days_selected) && in_array($day, $request->days_selected))){
        for($j=1;$j<=$bookings_number;$j++){
        foreach ($request->starttime as $i=> $starttime)  {
             $save = new MeetingScheduleSlot();
            $save['domain_id'] = $domain_id;
             $save['meeting_schedule_id'] = $request->id;
            $save['date'] = $date;
            $save['start_time'] = $starttime;
            $save['end_time'] = $request->endtime[$i]??'';
            $save->save();
        } 
        }
        
    }    
        
}
        
        return redirect()->route('meeting.schedules.timings')->with('success', __('Meeting Schedule slots Created successfully.'));
    }

    public function slot_edit($id) {
      $id =(int) encrypted_key($id, 'decrypt') ?? $id;
      if ($id != '') {
        $slot = MeetingScheduleSlot::where('id',$id)->first();
        return view('meetings.slots.edit', compact('slot'));
      }
      
  }
  public function slot_update(Request $request)
  { 
      $data = array(
      'date' => $request->date,
      'start_time' => $request->starttime,
      'end_time' => $request->endtime
      );
    if(MeetingScheduleSlot::where('id',$request->id)->update($data)){
        return redirect()->back()->with('success', __('Slot updated successfully.'));
    }

  }

    public function slot_destroy($id=0) {
          $id = encrypted_key($id, 'decrypt') ?? $id;
        if ($id == '') {
            return redirect()->back()->with('error', __('Id is mismatch.'));
        } 
        $folder = MeetingScheduleSlot::find($id);
        $folder->delete();
        return redirect()->back()->with('success', __('deleted successfully.'));
    }
    public function slot_booking_destroy($id=0) {
          $id = encrypted_key($id, 'decrypt') ?? $id;
        if ($id == '') {
            return redirect()->back()->with('error', __('Id is mismatch.'));
        } 
        $oldPost = MeetingScheduleSlot::find($id);
        $schedule=MeetingSchedule::find($oldPost->meeting_schedule_id);
        $user_id=$oldPost->user_id;
         $newPost = $oldPost->replicate();
        $newPost->setTable('meeting_schedules_slots_canceled');
        $newPost->created_at = Carbon::now();
        $newPost->save();
        
        $oldPost->user_id=null;
        $oldPost->save();
        
          $user_data=\App\User::find($user_id);
          try{
            //send email template
            $body=[
                'Booking For'=>$schedule->title,
                'Canceled At'=>date('F d, Y H:i:s', strtotime(Carbon::now())),
            ];
            send_email($user_data->email, $user_data->name, null, $body,'meeting_schedule_booking_cancel_email',$user_data);
                             } catch (\Exception $e) {
                    //return redirect()->back()->with('error', __($e->getMessage()));
                }
        
        return redirect()->back()->with('success', __('canceled successfully.'));
    }
     public function booking_reschedule($id=0) {
         $id = encrypted_key($id, 'decrypt') ?? $id;
        if ($id == '') {
            return redirect()->back()->with('error', __('Id is mismatch.'));
        }
        $authuser = Auth::user();
         $date=date('Y-m-d');
        $time=date('H:i:s');
        $slot = MeetingScheduleSlot::find($id);
        $slots = MeetingScheduleSlot::where('meeting_schedule_id',$slot->meeting_schedule_id)
                ->where('is_accomplished',0)
                ->where('user_id',null)
                ->whereRaw('(date > "'.$date.'" OR (date="'.$date.'" and start_time > "'.$time.'"))')
                ->orwhere('id',$slot->id)
                ->orderBy('date','ASC')
                ->get();
       
        return view('meetings.slots.reschedule', compact('slot','slots'));
    }
    public function bookings_index(Request $request) {
         
        $authuser = Auth::user();
        $domain_id = get_domain_id();
        $date=date('Y-m-d');
        $endtime=date('H:i:s');
       
       
        if ($request->ajax()) {
            $data = MeetingScheduleSlot::select('meeting_schedules_slots.*','ms.title')->join('meeting_schedules as ms','ms.id','meeting_schedules_slots.meeting_schedule_id')->where('ms.user_id', '=',$authuser->id)->where('meeting_schedules_slots.user_id', '!=',null)->orderBy('meeting_schedules_slots.date','desc');
            return Datatables::of($data)
                ->addIndexColumn()
                ->filterColumn('title', function($query, $keyword) use ($request) {
                    $query->orWhere('ms.title', 'LIKE', '%' . $keyword . '%')
                    ;
                })
                ->orderColumn('date', function ($query, $order) {
                     $query->orderBy('meeting_schedules_slots.date', $order);
                 })
                 
                 ->orderColumn('time', function ($query, $order) {
                     
                     $query->orderBy('meeting_schedules_slots.start_time', $order);
                 })
                  ->addColumn('accomplished', function ($data) {
                                    
                                $class = !empty($data->is_accomplished) ? "checked" : "";
                                return '<div  class="status-toggle d-flex justify-content-center">
                                                <input onclick="changestatus(' . $data->id.','.$data->user_id. ')" type="checkbox" id="status_' . $data->id . '" class="check" ' . $class . '>
                                                <label for="status_' . $data->id . '" class="checktoggle">checkbox</label>
                                            </div>';
                            })
                ->addColumn('user', function ($data) {
                    
                       return '<h2 class="table-avatar">
                                                <a href="' . route('profile', ['id' => encrypted_key($data->user_id, 'encrypt')]) . '" class="avatar avatar-sm mr-2"><img class="avatar-img rounded-circle" src="' . $data->user->getAvatarUrl() . '" alt="Image"></a>
                                                <a href="' . route('profile', ['id' => encrypted_key($data->user_id, 'encrypt')]) . '">' . $data->user->name . '</a>
                                            </h2>';
                 }) 
                ->addColumn('title', function ($data) {
                     return ucfirst(substr($data->title,0,40))."..";
                 }) 
                ->addColumn('date', function ($data) {
                     return date('M d, Y', strtotime($data->date));
                 }) 
                ->addColumn('time', function ($data) {
                     return '<div class="actions ">
                         <span disabled class="btn btn-sm bg-primary-light"  title="Schedule Time Slots">
        '. date('h:i a', strtotime($data->start_time)).' - '. date('h:i a', strtotime($data->end_time)).'
    </span></div>';
                 }) 
                 
                 
                                 
              ->addColumn('action', function($data){
                    $actionBtn = '<div class="actions text-right">
                                             
                                                <a  href="'.route('profile', ['id' => encrypted_key($data->user_id, 'encrypt')]).'" class="btn btn-sm bg-primary-light ">
                                                    <i class="far fa-user"></i> Profile
                                                </a>
                                            </div>';
                    if(empty($data->is_accomplished)){
                    $actionBtn .= '<div class="actions text-right mt-1">
                                             
                                                <a data-url="' . route('meeting.schedule.slot.booking.destroy',encrypted_key($data->id,'encrypt')) . '" href="#" class="btn btn-sm bg-danger-light confirm_record_model">
                                                    <i class="far fa-trash-alt"></i> Cancel
                                                </a>
                                            </div>';
                    $actionBtn .= '<div class="actions text-right mt-1">
                                             
                                                <a href="#" class="btn btn-sm bg-success-light" data-url="' . route('meeting.schedules.booking.reschedule',encrypted_key($data->id,'encrypt')) . '" data-ajax-popup="true"  data-title="Reschedule">
                                                   <i class="far fa-edit"></i> Reschedule
                                                </a>
                                            </div>';
                    }
                    
                   
                return $actionBtn;
            })
                ->rawColumns(['action','title','date','time','user','accomplished'])
                ->make(true);
        }else{ 
            
       
                return view('meetings.booking.index');
    }

    }
    public function canceled_bookings_index(Request $request) {
         
        $authuser = Auth::user();
        $domain_id = get_domain_id();
        $date=date('Y-m-d');
        $endtime=date('H:i:s');
       
       
        if ($request->ajax()) {
            $data = \App\MeetingScheduleSlotCanceled::select('meeting_schedules_slots_canceled.*','ms.title')->join('meeting_schedules as ms','ms.id','meeting_schedules_slots_canceled.meeting_schedule_id')->where('ms.user_id', '=',$authuser->id)->where('meeting_schedules_slots_canceled.user_id', '!=',null)->orderBy('meeting_schedules_slots_canceled.date','desc');
            return Datatables::of($data)
                ->addIndexColumn()
                ->filterColumn('title', function($query, $keyword) use ($request) {
                    $query->orWhere('ms.title', 'LIKE', '%' . $keyword . '%')
                    ;
                })
                ->orderColumn('date', function ($query, $order) {
                     $query->orderBy('meeting_schedules_slots.date', $order);
                 })
                 
                 ->orderColumn('time', function ($query, $order) {
                     $query->orderBy('meeting_schedules_slots.start_time', $order);
                 })
            
                ->addColumn('user', function ($data) {
                    
                       return '<h2 class="table-avatar">
                                                <a href="' . route('profile', ['id' => encrypted_key($data->user_id, 'encrypt')]) . '" class="avatar avatar-sm mr-2"><img class="avatar-img rounded-circle" src="' . $data->user->getAvatarUrl() . '" alt="Image"></a>
                                                <a href="' . route('profile', ['id' => encrypted_key($data->user_id, 'encrypt')]) . '">' . $data->user->name . '</a>
                                            </h2>';
                 }) 
                ->addColumn('title', function ($data) {
                     return ucfirst(substr($data->title,0,40))."..";
                 }) 
                ->addColumn('date', function ($data) {
                     return date('M d, Y', strtotime($data->date));
                 }) 
                ->addColumn('canceled_at', function ($data) {
                     return date('M d, Y', strtotime($data->created_at))."<br><small>".date('H:i:s', strtotime($data->created_at))."</small>";
                 }) 
                ->addColumn('time', function ($data) {
                     return '<div class="actions ">
                         <span disabled class="btn btn-sm bg-primary-light"  title="Schedule Time Slots">
        '.date('h:i a', strtotime($data->start_time)).' - '.date('h:i a', strtotime($data->end_time)).'
    </span></div>';
                 }) 
                 
                
                                 
              ->addColumn('action', function($data){
                    $actionBtn = '<div class="actions text-right">
                                             
                                                <a  href="'.route('profile', ['id' => encrypted_key($data->user_id, 'encrypt')]).'" class="btn btn-sm bg-primary-light ">
                                                    <i class="far fa-user"></i> Profile
                                                </a>
                                            </div>';
                 
                    
                   
                return $actionBtn;
            })
                ->rawColumns(['action','title','date','time','user','canceled_at'])
                ->make(true);
        }else{ 
       
                return view('meetings.booking.canceled');
    }

    }
    public function bookings_schedule(Request $request) {
        
        $authuser = Auth::user();
        $domain_id = get_domain_id();
        $date=date('Y-m-d');
        $endtime=date('H:i:s');
       
       
        if ($request->ajax()) {
            $data = MeetingScheduleSlot::select('meeting_schedules_slots.*','ms.title','ms.user_id as bookedwith')->join('meeting_schedules as ms','ms.id','meeting_schedules_slots.meeting_schedule_id')->where('meeting_schedules_slots.user_id', '=',$authuser->id);
            return Datatables::of($data)
                ->addIndexColumn()
                ->filterColumn('title', function($query, $keyword) use ($request) {
                    $query->orWhere('ms.title', 'LIKE', '%' . $keyword . '%')
                    ;
                })
                ->orderColumn('date', function ($query, $order) {
                     $query->orderBy('meeting_schedules_slots.date', $order);
                     
                 })
                ->orderColumn('bookedwith', function ($query, $order) {
                     $query->orderBy('ms.title', $order);
                 })
                ->orderColumn('accomplished', function ($query, $order) {
                     $query->orderBy('meeting_schedules_slots.is_accomplished', $order);
                 })
                 
                 ->orderColumn('time', function ($query, $order) {
                     $query->orderBy('meeting_schedules_slots.start_time', $order);
                 })
                 
                ->addColumn('user', function ($data) {
                    $bookedwith=\App\User::find($data->bookedwith);
                       return '<h2 class="table-avatar">
                                                <a href="' . route('profile', ['id' => encrypted_key($bookedwith->id, 'encrypt')]) . '" class="avatar avatar-sm mr-2"><img class="avatar-img rounded-circle" src="' . $bookedwith->getAvatarUrl() . '" alt="Image"></a>
                                                <a href="' . route('profile', ['id' => encrypted_key($bookedwith->id, 'encrypt')]) . '">' . $bookedwith->name . '</a>
                                            </h2>';
                 }) 
                ->addColumn('title', function ($data) {
                     return ucfirst(substr($data->title,0,40))."..";
                 }) 
                ->addColumn('accomplished', function ($data) {
                     return empty($data->is_accomplished) ? "No":"Yes";
                 }) 
                ->addColumn('date', function ($data) {
                     return date('M d, Y', strtotime($data->date));
                 }) 
                ->addColumn('time', function ($data) {
                     return '<div class="actions ">
                         <span disabled class="btn btn-sm bg-primary-light"  title="Schedule Time Slots">
        '.date('h:i a', strtotime($data->start_time)).' - '.date('h:i a', strtotime($data->end_time)).'
    </span></div>';
                 }) 
                 
                
                                 
              ->addColumn('action', function($data){
                    $actionBtn = '<div class="actions text-right">
                                             
                                                <a  href="'.route('profile', ['id' => encrypted_key($data->bookedwith, 'encrypt')]).'" class="btn btn-sm bg-primary-light ">
                                                    <i class="far fa-user"></i> Profile
                                                </a>
                                            </div>';
                    if(empty($data->is_accomplished)){
                        $date=date('Y-m-d');
        $endtime=date('H:i:s');
       
        if($date < $data->date || ($date=$data->date && $endtime<$data->start_time)){
            
                    $actionBtn .= '<div class="actions text-right mt-1">
                                             
                                                <a data-url="' . route('meeting.schedule.slot.booking.destroy',encrypted_key($data->id,'encrypt')) . '" href="#" class="btn btn-sm bg-danger-light confirm_record_model">
                                                    <i class="far fa-trash-alt"></i> Cancel
                                                </a>
                                            </div>';
                     $actionBtn .= '<div class="actions text-right mt-1">
                                             
                                                <a href="#" class="btn btn-sm bg-success-light" data-url="' . route('meeting.schedules.booking.reschedule',encrypted_key($data->id,'encrypt')) . '" data-ajax-popup="true"  data-title="Reschedule">
                                                   <i class="far fa-edit"></i> Reschedule
                                                </a>
                                            </div>';
        }
                    }
                    
                   
                return $actionBtn;
            })
                ->rawColumns(['action','title','date','time','user','accomplished'])
                ->make(true);
        }else{ 
       
                return view('meetings.booking.schedule-boookings');
    }

    }
    public function bookings_schedule_canceled(Request $request) {
         
        $authuser = Auth::user();
        $domain_id = get_domain_id();
        $date=date('Y-m-d');
        $endtime=date('H:i:s');
       
       
        if ($request->ajax()) {
            $data = MeetingScheduleSlotCanceled::select('meeting_schedules_slots_canceled.*','ms.title','ms.user_id as bookedwith')->join('meeting_schedules as ms','ms.id','meeting_schedules_slots_canceled.meeting_schedule_id')->where('meeting_schedules_slots_canceled.user_id', '=',$authuser->id);
            return Datatables::of($data)
                ->addIndexColumn()
                ->filterColumn('title', function($query, $keyword) use ($request) {
                    $query->orWhere('ms.title', 'LIKE', '%' . $keyword . '%')
                    ;
                })
                ->orderColumn('date', function ($query, $order) {
                     $query->orderBy('meeting_schedules_slots.date', $order);
                 })
                ->orderColumn('bookedwith', function ($query, $order) {
                     $query->orderBy('ms.title', $order);
                 })
                 
                 ->orderColumn('time', function ($query, $order) {
                     $query->orderBy('meeting_schedules_slots.start_time', $order);
                 })
                 
                ->addColumn('user', function ($data) {
                    $bookedwith=\App\User::find($data->bookedwith);
                       return '<h2 class="table-avatar">
                                                <a href="' . route('profile', ['id' => encrypted_key($bookedwith->id, 'encrypt')]) . '" class="avatar avatar-sm mr-2"><img class="avatar-img rounded-circle" src="' . $bookedwith->getAvatarUrl() . '" alt="Image"></a>
                                                <a href="' . route('profile', ['id' => encrypted_key($bookedwith->id, 'encrypt')]) . '">' . $bookedwith->name . '</a>
                                            </h2>';
                 }) 
                ->addColumn('title', function ($data) {
                     return ucfirst(substr($data->title,0,40))."..";
                 }) 
                ->addColumn('date', function ($data) {
                     return date('M d, Y', strtotime($data->date));
                 }) 
                ->addColumn('canceled_at', function ($data) {
                     return date('M d, Y', strtotime($data->created_at))."<br><small>".date('H:i:s', strtotime($data->created_at))."</small>";
                 }) 
                ->addColumn('time', function ($data) {
                     return '<div class="actions ">
                         <span disabled class="btn btn-sm bg-primary-light"  title="Schedule Time Slots">
        '.date('h:i a', strtotime($data->start_time)).' - '.date('h:i a', strtotime($data->end_time)).'
    </span></div>';
                 }) 
                 
                
                                 
              ->addColumn('action', function($data){
                    $actionBtn = '<div class="actions text-right">
                                             
                                                <a  href="'.route('profile', ['id' => encrypted_key($data->bookedwith, 'encrypt')]).'" class="btn btn-sm bg-primary-light ">
                                                    <i class="far fa-user"></i> Profile
                                                </a>
                                            </div>';
                    
                   
                return $actionBtn;
            })
                ->rawColumns(['action','title','date','time','user','canceled_at'])
                ->make(true);
        }else{ 
       
                return view('meetings.booking.schedule-boookings_canceled');
    }

    }
    public function change_accomplished_status(Request $request) {
        $user = Auth::user();
        if ($request->ajax() && !empty($request->id)) {
            $data = MeetingScheduleSlot::find($request->id); 
            $data->is_accomplished = empty($data->is_accomplished) ? 1 : 0;
            $status = $data->update();

            if($data->is_accomplished == 1){
                $client = User::find($request->user_id);
            $body = '
            <b>Hi '.ucfirst($client->name).'!</b><br>
            <p>Thanks for your meeting with us! Here’s a link to leave a review. <a href='.url("/profile?id=".encrypted_key($user->id,"encrypt")).' target="_blank">Click Here</a></p>
            </br>
            <b>Regards:</b></br>
            <p>'.ucfirst($user->name).' StemX</p>
            ';
            $e = send_email($client->email, $client->name, 'Share your most helpful reviews.', $body);
            dd(get_from_name_email(), $e);
            }
            return response()->json(
                            [
                                'success' => true,
                                'html' => 'success',
                            ]
            );
        }
    }
    public function booking_reschedule_post(Request $request) {
             $user = Auth::user();
            $slot = MeetingScheduleSlot::find($request->id);
            $newslot = MeetingScheduleSlot::find($request->schedule);
            
            $user_id=$slot->user_id;
            $start_time=$newslot->start_time;
            $end_time=$newslot->end_time;
            $date=$newslot->date;
            $schedule=MeetingSchedule::find($newslot->meeting_schedule_id);
            $newslot->user_id = $slot->user_id;
            $newslot->update();
            $slot->user_id = null;
            $slot->update();
            
            $user_data=\App\User::find($user_id);
            //send email template
            $body=[
                'Booking For'=>$schedule->title,
                'New Schedule Date'=>date('F d, Y', strtotime($date)),
                'Start Time'=>date('H:i:s', strtotime($start_time)),
                'End Time'=>date('H:i:s', strtotime($end_time)),
            ];
            try{
            send_email($user_data->email, $user_data->name, null, $body,'meeting_schedule_booking_reschedule_email',$user_data);
            }catch(Exception $e){
                
            }
            return redirect()->back()->with('success', __('Slot ReScheduled.'));
        
    }
    
    // Calendar View
    public function calendarView()
    {
        $usr = Auth::user();
        $permissions=permissions();
        if($usr->type)
        {
            $tasks = $data = MeetingScheduleSlot::select('meeting_schedules_slots.*','ms.title')->join('meeting_schedules as ms','ms.id','meeting_schedules_slots.meeting_schedule_id')->where('ms.user_id', '=',$usr->id)->where('meeting_schedules_slots.user_id', '!=',null)->orderBy('meeting_schedules_slots.date','desc');
            
            $tasks    = $tasks->get();
            $arrTasks = [];

            foreach($tasks as $task)
            {
               
                $arTasks = [];
                if(!empty($task->date) && $task->date != '0000-00-00')
                {
                    $arTasks['id']    = $task->id;
                    $arTasks['title'] =date('h:i A', strtotime($task->start_time)). " - ".date('h:i A', strtotime($task->end_time));
                    $arTasks['start'] = $task->date;
                    $arTasks['end'] = $task->date;                  

                    $arTasks['allDay']      = !0;
                    $arTasks['className']   = 'bg-' .(!empty($task->is_accomplished) ? "success" : 'primary');
                    $arTasks['description'] = $task->title;
                    $arTasks['url']         =''; //route('chore.details', encrypted_key($task->chore_id, 'encrypt'));
                    $arTasks['resize_url']  ='';// route('task.calendar.drag', $task->id);

                    $arrTasks[] = $arTasks;
                }
            }
         
            return view('meetings.booking.bookingscalendar', compact('arrTasks'));
        }
        else
        {
            return redirect()->back()->with('error', __('Permission Denied.'));
        }
    }
    // Calendar View
    public function calendarViewbooked()
    {
        $usr = Auth::user();
        $permissions=permissions();
        if($usr->type)
        {
            $tasks =$data = MeetingScheduleSlot::select('meeting_schedules_slots.*','ms.title','ms.user_id as bookedwith')->join('meeting_schedules as ms','ms.id','meeting_schedules_slots.meeting_schedule_id')->where('meeting_schedules_slots.user_id', '=',$usr->id);
            
            $tasks    = $tasks->get();
            $arrTasks = [];

            foreach($tasks as $task)
            {
               
                $arTasks = [];
                if(!empty($task->date) && $task->date != '0000-00-00')
                {
                    $arTasks['id']    = $task->id;
                    $arTasks['title'] =date('h:i A', strtotime($task->start_time)). " - ".date('h:i A', strtotime($task->end_time));
                    $arTasks['start'] = $task->date;
                    $arTasks['end'] = $task->date;                  

                    $arTasks['allDay']      = !0;
                    $arTasks['className']   = 'bg-' .(!empty($task->is_accomplished) ? "success" : 'primary');
                    $arTasks['description'] = $task->title;
                    $arTasks['url']         =''; //route('chore.details', encrypted_key($task->chore_id, 'encrypt'));
                    $arTasks['resize_url']  ='';// route('task.calendar.drag', $task->id);

                    $arrTasks[] = $arTasks;
                }
            }
         
            return view('meetings.booking.bookedcalendar', compact('arrTasks'));
        }
        else
        {
            return redirect()->back()->with('error', __('Permission Denied.'));
        }
    }
}
