<?php

namespace App\Http\Controllers;

use App\User;
use App\Contacts;
use App\Plan;
use App\Order;
use App\Faq;
use App\SiteSettings;
use Session;
use App\ChatInbox;
use App\UserDomain;
use Response;
use App\Unansweredfaq;
use App\Cpanel\Cpanel;
use Illuminate\Filesystem\Filesystem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\File;
use Mail;
use DataTables;
use Twilio\TwiML\VoiceResponse;
use Twilio\Jwt\ClientToken;
use Twilio\Rest\Client;
use Twilio\Jwt\TaskRouter\WorkerCapability;
use GuzzleHttp\ClientInterface;
use Carbon\Carbon;
class UserController extends Controller {

    //user public profile
    public function profile(Request $request) {
        $id = !empty($request->id) ? encrypted_key($request->id, "decrypt") : 0;
     //   dd($id);
        if (!empty($id)) {
            $user = User::find($id);
            $qualification = \App\UserQualification::where("user_id", $user->id)->first();
            $reviews = \App\UserProfileRating::where('profile_id', $id)->get();
            $date = date('Y-m-d');
            $endtime = date('H:i:s');
            $slots = \App\MeetingScheduleSlot::join('meeting_schedules as ms', 'ms.id', '=', 'meeting_schedules_slots.meeting_schedule_id')
               //->where('ms.user_id', $user->id)
                            ->where('meeting_schedules_slots.user_id', Auth::user()->id ?? 0)
                            // ->where('meeting_schedules_slots.end_time', $endtime)
                            ->where('meeting_schedules_slots.is_accomplished', 1)
                            ->where('meeting_schedules_slots.date', '<=', "$date")->count();

            $bookedslots = \App\MeetingScheduleSlot::join('meeting_schedules as ms', 'ms.id', '=', 'meeting_schedules_slots.meeting_schedule_id')
//                ->where('ms.user_id', $user->id)
                            ->where('meeting_schedules_slots.user_id', Auth::user()->id ?? 0)
                            ->where('meeting_schedules_slots.end_time', ">=", $endtime)
                            ->where('meeting_schedules_slots.start_time', "<=", $endtime)
                            ->where('meeting_schedules_slots.is_accomplished', 0)
                            ->whereRaw('meeting_schedules_slots.date = DATE("' . $date . '")')->count();

            $user_rating = \App\UserProfileRating::where("user_id", Auth::user()->id ?? 0)->where("profile_id", $id)->count();
            //  if($user_rating<$slots){
            $user_rating = 0;
            //  }else{
            //  $user_rating=1;
            //  }
              //dd($slots);
            $twilio_settings = \App\SiteSettings::getValByName('twilio_key');
            $accountSid = $twilio_settings['twilio_account_sid'] ?? "";
            $authToken = $twilio_settings['twilio_auth_token'] ?? "";
            $callnumber = $twilio_settings['twilio_number'] ?? "";
            $appSid = ""; /// User::userSettingsInfo($domain_usesr->id, 'twiml_app_sid');
            $capability = new ClientToken($accountSid, $authToken);
            $capability->allowClientOutgoing($appSid);
            $token = $capability->generateToken();
            $g_recapthca_sitekey = '6LcGnBwcAAAAAHY2J4EwqpoYLAODaUnKioLdxmrz';

            return view('user.profile', compact('user', 'qualification', 'reviews', 'user_rating', 'slots', 'callnumber', 'token', 'g_recapthca_sitekey', "bookedslots"));
        }
        return redirect()->back()->with('error', __('Permission Denied.'));
    }

    //user profile edit
    public function profile_edit() {
        $user = Auth::user();
//        if ($user->type == "admin") {
//            return view('admin.profile', compact('user'));
//        } else {

        if ($user->type == 'mentor' || $user->type == 'corporate') {
            $OwnerPlanDetails = Plan::find($user->plan);
            $planStripeData = Order::where(['plan_id' => $user->plan, 'user_id' => $user->id])->orderBy('created_at', 'DESC')->first();
            $orders = Order::select(
                            [
                                'orders.*',
                                'users.name as user_name',
                            ]
                    )->join('users', 'orders.user_id', '=', 'users.id')->orderBy('orders.created_at', 'DESC')->where('users.id', '=', $user->id)->paginate(6);
        } else {
            $OwnerPlanDetails = '';
            $planStripeData = '';
            $orders = '';
        }
        $domain_arr = UserDomain::where('user_id',$user->id)->first();

        return view('user.profile-settings', compact('user', 'OwnerPlanDetails', 'orders', 'planStripeData', 'user','domain_arr'));
//        }
    }

    public function lookup_domain(Request $request){
        if(!empty(env('WHMCS_API_URL')) && !empty(env('WHMCS_IDENTIFIER')) && !empty(env('WHMCS_SECRET')) && !empty(env('API_ACCESS_KEY')) && !empty($request->domain)){
            $ch = curl_init();
            $url_params=env('WHMCS_API_URL').'?action=DomainWhois&username='.env('WHMCS_IDENTIFIER').'&password='.env('WHMCS_SECRET').'&accesskey='.env('API_ACCESS_KEY');

            curl_setopt($ch, CURLOPT_URL, $url_params);
            curl_setopt($ch, CURLOPT_POST, 1);
            curl_setopt($ch, CURLOPT_POSTFIELDS,
                http_build_query(
                    array(
                         'domain' =>$request->domain,
                         'responsetype' => 'json',
                    )
                )
            );
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
            $response = curl_exec($ch);
            curl_close($ch);
            $response_data= json_decode($response,true);
        }else{
            $response_data = array();
        }
        return view('user.lookup_domain', compact('response_data'));
    }
    public function delete_domain(Request $request){
        $user = UserDomain::where('user_id',auth()->user()->id)->where('id',$request->id)->first();
        if(!empty($user->custom_url) && !empty($user->domain)){
            if(!empty(env('CPANEL_HOST')) && !empty(env('WHM_USER_NAME')) && !empty(env('CPANEL_AUTH_TYPE')) && !empty(env('WHM_PASSWORD'))){
                $data = array();
                $data['host'] = env('CPANEL_HOST');
                $data['auth_type'] = env('CPANEL_AUTH_TYPE');
                $data['password'] = env('WHM_PASSWORD');
                $data['username'] = env('WHM_USER_NAME');
                $cpanel = new Cpanel($data);
                $options = array(
                   'domain'      => $user->domain,
                   'subdomain'      => $user->custom_url.'.'.env('MAIN_URL'),
                );
                $result = $cpanel->api2('AddonDomain','deladdondomain',env('CPANEL_USER_NAME'),$options);
                $error_check = json_decode($result,true);
                if(!empty($error_check['cpanelresult']['error'])){
                    return redirect()->back()->with('error', $error_check['cpanelresult']['error']);
                }
            }
            $domain_data = array();
            $domain_data['domain'] = NULL;
            UserDomain::where('id',$request->id)->update($domain_data);

            return redirect()->to('profile')->with('success', __('Domain Deleted successfully.'));
        }
    }
    public function check_subdomain(Request $request){
        $domain_arr = UserDomain::where('custom_url',$request->subdomain)->where('user_id','<>',auth()->user()->id)->first();
        if(!empty($domain_arr)){
            return 'true';
        }else{
            return 'false';
        }
    }
    public function check_domain(Request $request){
        $domain_arr = UserDomain::where('domain',$request->domain)->where('user_id','<>',auth()->user()->id)->first();
        if(!empty($domain_arr)){
            return 'true';
        }else{
            return 'false';
        }
    }

    public function get_orders(Request $request) {
        $user = Auth::user();
        if ($request->ajax()) {

            $data = Order::select(
                            [
                                'orders.*',
                                'users.name as user_name',
                            ]
                    )->join('users', 'orders.user_id', '=', 'users.id')->orderBy('orders.created_at', 'DESC')->where('users.id', '=', $user->id)->get();


            return Datatables::of($data)
                            ->addIndexColumn()
                            ->addColumn('plan name', function ($data) {
                                return $data->plan_name;
                            })->addColumn('type', function ($data) {
                                if ($data->type == 'week') {
                                    $type = "Weekly";
                                } elseif ($data->type == 'month') {
                                    $type = "Monthly";
                                } else {
                                    $type = "Yearly";
                                }
                                return $type;
                            })->addColumn('amount', function ($data) {
                                return "$" . $data->price;
                            })->addColumn('status', function ($data) {
                                return $data->status;
                            })->addColumn('date', function($data) {

                                return date("F j, Y", strtotime($data->created_at));
                            })->addColumn('action', function($data) {

                                $actionBtn = '<div class="actions text-right">
                                                <a class="btn btn-sm bg-success-light" target="_blank"  href="' . $data->receipt . '">
                                                Payment Receipt
                                                </a>

                                            </div>';


                                return $actionBtn;
                            })
                            ->rawColumns(['action', 'image'])
                            ->make(true);
        }
    }

    //admin profile
    public function admin_profile() {

        $user = Auth::user();
        return view('user.profile-settings', compact('user'));
//        if ($user->type == "admin") {
//            return view('admin.profile', compact('user'));
//        }
//        return redirect()->back()->with('error', __('Permission Denied.'));
    }

    //update profile
    public function deleteprofilepic(Request $request) {
        // dd($request);
        $objUser = Auth::user();
        $objUser->update(["avatar" => '']);
         return redirect()->back()->with('success', __('Profile Avatar Deleted Successfully!'));
    }
    public function updateProfile(Request $request) {
        // dd($request);
        $objUser = Auth::user();
        $validate = [];
        if ($request->from == 'password_change') {
            $validate = [
                'password' => 'required|min:8|same:password',
                'password_confirmation' => 'required|min:8|same:password',
            ];
            $validator = Validator::make(
                            $request->all(), $validate
            );
            if ($validator->fails()) {
                return redirect()->back()->with('error', $validator->errors()->first());
            }
            $objUser->update(["password" => Hash::make($request->password)]);
            return redirect()->back()->with('success', __('Password Changed Successfully!'));
        }
        $validate = [
            'name' => 'required|max:120',
            'mobile' => 'required|numeric',
        ];

//        if (isset($request->avatar) && !empty($request->avatar)) {
//            $validate = [
//                'avatar' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
//            ];
//        }

        $validator = Validator::make(
                        $request->all(), $validate
        );
        if ($validator->fails()) {
            return redirect()->back()->with('error', $validator->errors());
        }


        $post = $request->all();
        $bg = $request->education_id;
        if ($bg == null) {
            $education = NULL;
        } else {
            $education = json_encode($request->education_id);
        }
        $company = $request->company;
        if ($company == null) {
            $company = NULL;
        } else {
            $company = $request->company;
        }
        if (isset($request->defaultaddress)) {
            $post['corporate_address1'] = $post['address1'];
            $post['corporate_city'] = $post['city'];
            $post['corporate_state'] = $post['state'];
            $post['corporate_postal_code'] = $post['postal_code'];
            $post['corporate_country'] = $post['country'];
        }

        //   dd( $education);
        // remove email from array wee don't need to update that email
        unset($post['_token']);
        unset($post['company']);
        unset($post['education_id']);
        foreach ($post as $key => $value) {
            $exp_key = explode('_', $key);
            if ($exp_key[0] == 'customfield') {
                unset($post[$key]);
                $arr_result[$key] = $value;
            }
        }

        if (isset($arr_result)) {
            $customfield = json_encode($arr_result);
        }
        // dd($customfield);
        // Image Uploading
//        if (!empty($request->avatar)) {
//            \App\Utility::checkFileExistsnDelete([$objUser->avatar]);
//            $avatarName = $objUser->id . '_avatar' . time() . '.' . $request->avatar->getClientOriginalExtension();
//            $request->avatar->storeAs('avatars', $avatarName);
//            $post['avatar'] = 'avatars/' . $avatarName;
//        }

        if (!empty($request->avatar)) {
            \App\Utility::checkFileExistsnDelete([$objUser->avatar]);
            $base64_encode = $request->avatar;
            $folderPath = "storage/app/";
            $image_parts = explode(";base64,", $base64_encode);
            $image_type_aux = explode("image/", $image_parts[0]);
            $image_type = $image_type_aux[1];
            $image_base64 = base64_decode($image_parts[1]);
            $image = 'avatars/' . "avatar" . uniqid() . '.' . $image_type;
            ;
            $file = $folderPath . $image;
            file_put_contents($file, $image_base64);
        } else {
            $image = $objUser->avatar;
        }

        $post['avatar'] = $image;
        $post['blood_group'] = $education;
        $post['company'] = $company;
        $post['customfield'] = $customfield;

        //dd( $post);
        $datatt = $objUser->update($post);
//dd($datatt);
        //update percentage
        update_profile_completion();

        //update contact

    $user = Auth::user();
    $contacts= \App\Contacts::where('email',$user->email);
    if(!empty($user->mobile)){
        $contacts->orWhere('phone',$user->mobile);
    }
    $data=$contacts->get();
    if(!empty($data)){
        foreach ($data as $row){
            $updatearray=array();
            $contact= \App\Contacts::find($row->id);
                $updatearray['fullname'] = $user->name;
                $updatearray['fname'] = !empty($user->name)?(explode(' ', $user->name)[0]??''):'';
                $updatearray['lname'] = !empty($user->name)?(explode(' ', $user->name)[1]??''):'';
        $updatearray['phone'] = $user->mobile;
        $updatearray['email'] = $user->email;
        if (!empty($request->avatar)) {
         $base64_encode =$request->avatar;
                $folderPath = "storage/contact/";
                if (!file_exists($folderPath)) {
File::isDirectory($folderPath) or File::makeDirectory($folderPath, 0777, true, true);
                }
                $image_parts = explode(";base64,", $base64_encode);
                $image_type_aux = explode("image/", $image_parts[0]);
                $image_type = $image_type_aux[1];
                $image_base64 = base64_decode($image_parts[1]);
                $image = "contact". uniqid() . '.'.$image_type;;
                $file = $folderPath.$image;
                file_put_contents($file, $image_base64);
                 }
         if(!empty($image)){
        $updatearray['avatar'] = $image;
        }

        $contact->update($updatearray);

    }
}

        return redirect()->back()->with('success', __('Profile Updated Successfully!'));
    }

    //update role
    public function role_update(Request $request) {
        $objUser = Auth::user();
        if ($objUser->type != "admin") {
            return redirect()->back()->with('error', __('Permission Denied.'));
        }
        $validate = [];
        $validate = [
            'role' => 'required|max:20',
        ];
        $validator = Validator::make(
                        $request->all(), $validate
        );
        if ($validator->fails()) {
            return redirect()->back()->with('error', $validator->errors());
        }

        $check_role = \App\Role::where('role', strtolower($request->role))->first();
        if (empty($request->id)) {
            if (!empty($check_role)) {
                return redirect()->back()->with('error', __('Duplicate role exist'));
            }
        }
        $role_id = !empty($request->id) ? encrypted_key($request->id, "decrypt") : 0;
        if (empty($role_id)) {
            $role_data = new \App\Role();
            $role_data['created_by'] = $objUser->id;
            $role_data['status'] = $request->status;
            $role_data['permissions'] = !empty($request->permissions) ? json_encode($request->permissions) : '';
            $role_data['role'] = strtolower($request->role);
            $role_data->save();
        } else {
            $role_data = \App\Role::find($role_id);
            $post['created_by'] = $objUser->id;
            $post['status'] = $request->status;
            $post['permissions'] = !empty($request->permissions) ? json_encode($request->permissions) : '';
            if (empty($check_role->role) || (!empty($check_role->role) && $check_role->role != $request->role)) {
                $post['role'] = strtolower($request->role);
            }
            $res = $role_data->update($post);
        }

        return redirect()->back()->with('success', __('saved!'));
    }

    //edit role
    public function role_edit($id_enc = 0) {
        $objUser = Auth::user();
        $role_id = !empty($id_enc) ? encrypted_key($id_enc, "decrypt") : 0;
        if ($objUser->type != "admin" || empty($role_id)) {
            return redirect()->back()->with('error', __('Permission Denied.'));
        }
        $data = \App\Role::find($role_id);
       return view('admin.role_form', compact('data','objUser'));
    }

    //edit role
    public function role_destroy($id_enc = 0) {
        $objUser = Auth::user();
        $role_id = !empty($id_enc) ? encrypted_key($id_enc, "decrypt") : 0;
        if ($objUser->type != "admin" || empty($role_id)) {
            return redirect()->back()->with('error', __('Permission Denied.'));
        }

        $data = \App\Role::find($role_id);
        $data->delete();
        return redirect()->back()->with('success', __('Deleted.'));
    }

    //edit role
    public function invoicedetails($id_enc = 0) {
        $objUser = Auth::user();
        $id = !empty($id_enc) ? encrypted_key($id_enc, "decrypt") : 0;
        if (empty($id)) {
            return redirect()->back()->with('error', __('Permission Denied.'));
        }
        $data = \App\UserPayment::find($id);
        $paymentfrom = \App\User::find($data->user_id);
        $paymentto = \App\User::find($data->paid_to_user_id);
        return view('frontend.mentoringtheme.invoice-view', compact('data', 'paymentfrom', 'paymentto'));
    }

    //admin user roles
    public function roles(Request $request) {
        $user = Auth::user();
        if ($request->ajax()) {
            $data = \App\Role::orderBy('id', 'ASC');
            $data->where('created_by', $user->id);


            return Datatables::of($data)
                            ->addIndexColumn()
                            ->addColumn('status', function ($data) {
                                $class = $data->status == "Active" ? "success" : "warning";
                                return '<span class="badge badge-' . $class . '">' . $data->status . '</span>';
                            })
                            ->addColumn('action', function($data) {
                                $user = Auth::user();
                                if ($data->role != "admin") {
                                    $actionBtn = '<div class="actions text-right">
                                                <a class="btn btn-sm bg-success-light" data-url="' . route('role.edit', encrypted_key($data->id, "encrypt")) . '" data-ajax-popup="true" data-size="md" data-title="Edit Role" href="#">
                                                    <i class="fas fa-pencil-alt"></i>
                                                    Edit
                                                </a>
                                                <a data-url="' . route('role.destroy', encrypted_key($data->id, "encrypt")) . '" href="#" class="btn btn-sm bg-danger-light delete_record_model">
                                                    <i class="far fa-trash-alt"></i> Delete
                                                </a>
                                            </div>';
                                } else {
                                    $actionBtn = '';
                                }

                                return $actionBtn;
                            })
                            ->rawColumns(['action', 'status'])
                            ->make(true);
            // return view('admin.roles');
        } else {
            return view('admin.roles');
        }
    }

    //admin users
    public function admin_users(Request $request) {
        $user = Auth::user();
        if (!in_array("manage_domain_users", permissions()) && $user->type != "admin" && !checkPlanModule('users')) {
            return redirect()->back()->with('error', __('Permission Denied.'));
        }
        // $datauser = \App\User::select('id', 'name', 'avatar', 'created_by', 'type', 'is_active', 'created_at')->orderBy('id', 'ASC')->paginate(100)->get();
//dd($datauser);
        if ($request->ajax()) {
            $data = \App\User::select('id', 'name', 'avatar', 'created_by', 'type', 'is_active', 'created_at')->orderBy('id', 'ASC');
            if (!empty($request->filter_type)) {

                $data->where('type', $request->filter_type);
            }
            if (!empty($request->filter_status)) {
                if ($request->filter_status == 1) {
                    $data->where('is_active', 1);
                } else {
                    $data->where('is_active', '!=', 1);
                }
            }


            return Datatables::of($data)
                            ->addIndexColumn()
                            ->addColumn('user_name', function ($data) {
                                return '<h2 class="table-avatar">
                                                <a href="' . route('profile', ['id' => encrypted_key($data->id, 'encrypt')]) . '" class="avatar avatar-sm mr-2"><img class="avatar-img rounded-circle" src="' . $data->getAvatarUrl() . '" alt="Image"></a>
                                                <a href="' . route('profile', ['id' => encrypted_key($data->id, 'encrypt')]) . '">' . $data->name . '</a>
                                            </h2>';
                            })
                            ->addColumn('created_by', function ($data) {
                                if (!empty($data->created_by)) {
                                    $user = \App\User::find($data->created_by);
                                    return '<h2 class="table-avatar">
                                                <a href="' . route('profile', ['id' => encrypted_key($data->id, 'encrypt')]) . '" class="avatar avatar-sm mr-2"><img class="avatar-img rounded-circle" src="' . $user->getAvatarUrl() . '" alt="Image"></a>
                                                <a href="' . route('profile', ['id' => encrypted_key($data->id, 'encrypt')]) . '">' . $user->name . '</a>
                                            </h2>';
                                } else {
                                    return "--";
                                }
                            })
                            ->addColumn('status', function ($data) {
                                $classdis = $data->type == "admin" ? "disabled" : '';
                                $class = $data->is_active == 1 ? "checked" : "";
                                return '<div ' . $classdis . ' class="status-toggle d-flex justify-content-center">
                                                <input onclick="changestatus(' . $data->id . ')" type="checkbox" id="status_' . $data->id . '" class="check" ' . $class . '>
                                                <label for="status_' . $data->id . '" class="checktoggle">checkbox</label>
                                            </div>';
                            })
                            ->addColumn('created_at', function ($data) {
                                return date('jS F, Y', strtotime($data->created_at)) . '<br><small>' . date('h:i a', strtotime($data->created_at)) . '</small>';
                            })
                            ->rawColumns(['user_name', 'created_by', 'created_at', 'status'])
                            ->make(true);
        } else {
            return view('admin.users');
        }
    }

    //
    public function invoices(Request $request) {
        $user = Auth::user();

        if ($request->ajax() && !empty($request->blockElementsData)) {
                if (!empty($request->duration)) {
                    $tilldate = Carbon::now()->addMonth($request->duration)->toDateTimeString();
                }
                
               $invoices = \App\UserPayment::where('paid_to_user_id',$user->id)->orwhere('user_id',$user->id);
         if (!empty($tilldate)) {
                    $invoices->where("created_at", ">", $tilldate);
                }
                        $invoices=$invoices->count();  
                    
                         $totalpaid = \App\UserPayment::where('user_id',$user->id);
                         if (!empty($tilldate)) {
                    $totalpaid->where("created_at", ">", $tilldate);
                }
        $totalpaid=$totalpaid->sum('amount');
         $earned = \App\UserPayment::where('paid_to_user_id',$user->id);
                 if (!empty($tilldate)) {
                    $earned->where("created_at", ">", $tilldate);
                }
        $earned=$earned->sum('amount');
         
                        return json_encode([
                    'invoices' => $invoices,
                    'paid' => format_price($totalpaid),
                    'earned' => format_price($earned),
                ]);
                
                
                
         }elseif ($request->ajax()) {
            $data = \App\UserPayment::query();

            if (!empty($request->filter_status)) {
                if ($request->filter_status == 1) {
                    $data->where('user_id', $user->id);
                } elseif ($request->filter_status == 2) {
                    $data->where('paid_to_user_id', $user->id);
                }
            } else {
                $data->where('user_id', $user->id)->orwhere('paid_to_user_id', $user->id);
            }
          //  $data->orderBy('order_id','DESC');

            return Datatables::of($data)
                            ->addIndexColumn()
                            ->orderColumn('order_id', function ($query, $order) {
                                $query->orderBy('order_id', $order);

                            })
                            ->orderColumn('created_at', function ($query, $order) {
                                     $query->orderBy('created_at', $order);

                            })
                            ->addColumn('order_id', function ($data) {
                                return '<a href="' . route("payment.invoice", encrypted_key($data->id, 'encrypt')) . '">#' . $data->order_id . '</a>';
                            })
                            ->addColumn('paidto', function ($data) {
                                $paidto = \App\User::find($data->paid_to_user_id);
                                return '<h2 class="table-avatar">
                                                <a href="' . route('profile', ['id' => encrypted_key($paidto->id, 'encrypt')]) . '" class="avatar avatar-sm mr-2"><img class="avatar-img rounded-circle" src="' . $paidto->getAvatarUrl() . '" alt="Image"></a>
                                                <a href="' . route('profile', ['id' => encrypted_key($paidto->id, 'encrypt')]) . '">' . $paidto->name . '</a>
                                            </h2>';
                            })
                            ->addColumn('paidby', function ($data) {
                                $paidto = \App\User::find($data->user_id);
                                return '<h2 class="table-avatar">
                                                <a href="' . route('profile', ['id' => encrypted_key($paidto->id, 'encrypt')]) . '" class="avatar avatar-sm mr-2"><img class="avatar-img rounded-circle" src="' . $paidto->getAvatarUrl() . '" alt="Image"></a>
                                                <a href="' . route('profile', ['id' => encrypted_key($paidto->id, 'encrypt')]) . '">' . $paidto->name . '</a>
                                            </h2>';
                            })
                            ->addColumn('amount', function ($data) {
                                return format_price($data->amount);
                            })
                            ->addColumn('created_at', function ($data) {
                                return date('M d, Y', strtotime($data->created_at)) . '<br><small>' . date('h:i a', strtotime($data->created_at)) . '</small>';
                            })
                            ->addColumn('action', function($data) {
                                $actionBtn = '<div class="actions text-right">

                                                <a class="btn btn-sm bg-success-light" data-title="View " href="' . route("payment.invoice", encrypted_key($data->id, 'encrypt')) . '">
                                                    <i class="fas fa-eye"></i>
                                                    View
                                                </a>
                                            </div>';


                                return $actionBtn;
                            })
                            ->rawColumns(['order_id', 'paidto', 'created_at', 'amount', 'action', 'paidby'])
                            ->make(true);
        } else {


            return view('user.invoices');
        }
    }

    //domain users
    public function users_favurites(Request $request) {
        $user = Auth::user();

        if ($request->ajax()) {
            $build_query = \App\User::select('users.*', 'fu.id as fav_id')
                    ->join('favourite_users as fu', 'fu.fav_user_id', '=', 'users.id')
                    ->where('fu.user_id', $user->id)
                    ->orderBy('fu.created_at', 'DESC');



            if (!empty($request->search)) {
                $build_query->where('users.name', 'LIKE', '%' . $request->search . '%');
                $build_query->orwhere('users.state', 'LIKE', '%' . $request->search . '%');
                $build_query->orwhere('users.country', 'LIKE', '%' . $request->search . '%');
            }


            $data = $build_query->paginate(9);

            $responseHtml = view('user.usersFavGrid', compact('data'))->render();
            return response()->json([
                        'html' => $responseHtml,
            ]);
        } else {
            return view('user.usersfavourites');
        }
    }
    //domain users
    public function users_liked(Request $request) {
        $user = Auth::user();

        if ($request->ajax()) {
            $build_query = \App\User::select('users.*', 'fu.id as fav_id')
                    ->join('like_users as fu', 'fu.like_user_id', '=', 'users.id')
                    ->where('fu.user_id', $user->id)
                    ->orderBy('fu.created_at', 'DESC');



            if (!empty($request->search)) {
                $build_query->where('users.name', 'LIKE', '%' . $request->search . '%');
                $build_query->orwhere('users.state', 'LIKE', '%' . $request->search . '%');
                $build_query->orwhere('users.country', 'LIKE', '%' . $request->search . '%');
            }


            $data = $build_query->paginate(9);

            $responseHtml = view('user.userslikedGrid', compact('data'))->render();
            return response()->json([
                        'html' => $responseHtml,
            ]);
        } else {
            return view('user.usersliked');
        }
    }

    //domain users
    public function domain_users(Request $request) {

        $user = Auth::user();
//        if (!in_array("manage_domain_users", permissions()) && $user->type != "admin" && !checkPlanModule('users')) {
//            return redirect()->back()->with('error', __('Permission Denied.'));
//        }

        $datauser = \App\User::select('id', 'name', 'avatar', 'created_by', 'type', 'is_active', 'created_at','board_member')->orderBy('id', 'ASC')->where('type','!=','admin')->where('is_active','!=','0')->paginate(10);
        if($user->type !="admin"){
            $domain_user= get_domain_user();
            if (!empty($domain_user)) {
                $datauser = \App\User::select('id', 'name', 'avatar', 'created_by', 'type', 'is_active', 'created_at','board_member')->orderBy('id', 'ASC')->where('created_by', $domain_user->id)->where('type','!=','admin')->where('is_active','!=','0')->paginate(10);


                }

            }
            else{
                $datauser = \App\User::select('id', 'name', 'avatar', 'created_by', 'type', 'is_active', 'created_at','board_member')->orderBy('id', 'ASC')->where('type','!=','admin')->where('is_active','!=','0')->paginate(10);

            }

      //   dd($datauser);
        if ($request->ajax()) {

            $data = \App\User::select('id', 'name', 'avatar', 'created_by', 'type', 'is_active', 'created_at','board_member')->where('is_active','!=','0')->orderBy('id', 'ASC');
           if($user->type !="admin"){
            $domain_user= get_domain_user();
            if (!empty($domain_user)) {
                $data->where('created_by', $domain_user->id);

                }

            }
            if (!empty($request->filter_type)) {
                $data->where('type', $request->filter_type);
            }
            if (!empty($request->filter_status)) {
                if ($request->filter_status == 1) {
                    $data->where('is_active', 1);
                } else {
                    $data->where('is_active', '!=', 1);
                }
            }


            return Datatables::of($data)
                            ->addIndexColumn()
                            ->addColumn('user_name', function ($data) {
                                $theme= '<h2 class="table-avatar">
                                                <a href="' . route('profile', ['id' => encrypted_key($data->id, 'encrypt')]) . '" class="avatar avatar-sm mr-2"><img class="avatar-img rounded-circle" src="' . $data->getAvatarUrl() . '" alt="Image"></a>
                                                <a href="' . route('profile', ['id' => encrypted_key($data->id, 'encrypt')]) . '">' . $data->name . '</a>
                                            </h2>';

                                 if (in_array("manage_sub_domain", role_permissions($data->type)) || $data->type == "admin") {
                                    $themedata= SiteSettings::where('name', 'domain_theme')->where('user_id', $data->id)->first();
                                     $themedata= !empty($themedata->value) ? json_decode($themedata->value,true) :'';
                                     $themedata=$themedata['domain_theme']??'';
                                    $theme .='<br><select class="bg-primary" onclick="changetheme(' . $data->id . ')" style="margin-left:50px !important;" name="user_theme" id="user_theme_'.$data->id .'" >
                                  <option   value="">Default Theme</option>
                                  <option '.($themedata=="home1"?"selected":'').'  value="home1">Home-1 Theme</option>
                                  <option '.($themedata=="home2"?"selected":'').'    value="home2">Home-2 Theme</option>
                                  <option  '.($themedata=="home3"?"selected":'').'   value="home3">Home-3 Theme</option>
                                  <option '.($themedata=="home4"?"selected":'').'   value="home4">Home-4 Theme</option>
                                  <option '.($themedata=="home5"?"selected":'').'   value="home5">Home-5 Theme</option>
                                  <option '.($themedata=="home6"?"selected":'').'   value="home6">Home-6 Theme</option>
                                  <option '.($themedata=="home7"?"selected":'').'   value="home7">Home-7 Theme</option>
                                  <option '.($themedata=="home8"?"selected":'').'   value="home8">Home-8 Theme</option>
                                  <option '.($themedata=="home9"?"selected":'').'   value="home9">Home-9 Theme</option>
                                  <option '.($themedata=="home10"?"selected":'').'   value="home10">Home-10 Theme</option>
                                  <option '.($themedata=="home11"?"selected":'').'   value="home11">Home-11 Theme</option>
                                  <option '.($themedata=="home12"?"selected":'').'   value="home12">Home-12 Theme</option>
                                  <option '.($themedata=="home13"?"selected":'').'   value="home13">Home-13 Theme</option>
                                  <option '.($themedata=="home14"?"selected":'').'   value="home14">Home-14 Theme</option>
                                  <option '.($themedata=="home15"?"selected":'').'   value="home15">Home-15 Theme</option>
                                  <option '.($themedata=="home16"?"selected":'').'   value="home16">Home-16 Theme</option>
                                  <option '.($themedata=="home17"?"selected":'').'   value="home17">Home-17 Theme</option>
                                  <option '.($themedata=="home18"?"selected":'').'   value="home18">Home-18 Theme</option>
                                  <option '.($themedata=="home19"?"selected":'').'   value="home19">Home-19 Theme</option>
                                  <option '.($themedata=="home20"?"selected":'').'   value="home20">Home-20 Theme</option>
                                  </select>';
                                 }




                                return $theme;
                            })
                            ->addColumn('created_by', function ($data) {
                                if (!empty($data->created_by)) {
                                    $user = \App\User::find($data->created_by);
                                    return '<h2 class="table-avatar">
                                                <a href="' . route('profile', ['id' => encrypted_key($data->id, 'encrypt')]) . '" class="avatar avatar-sm mr-2"><img class="avatar-img rounded-circle" src="' . $user->getAvatarUrl() . '" alt="Image"></a>
                                                <a href="' . route('profile', ['id' => encrypted_key($data->id, 'encrypt')]) . '">' . $user->name . '</a>
                                            </h2>';
                                } else {
                                    return "--";
                                }
                            })
                            ->addColumn('board_member', function ($data) {
                                if($data->type=="admin"){
                                    return '';
                                }
                                  $classdis=$data->type=="admin"?"disabled":'';
                                $class = $data->board_member == 1 ? "checked" : "";
                                return '<div class="status-toggle d-flex justify-content-center">
                                                <input '.$classdis.' onclick="changemember(' . $data->id . ')" type="checkbox" id="member_' . $data->id . '" class="check" ' . $class . '>
                                                <label for="member_' . $data->id . '" class="checktoggle">checkbox</label>
                                            </div>';
                            })
                            ->addColumn('status', function ($data) {
                                if ($data->type == "admin") {
                                    return '';
                                }
                                $classdis = $data->type == "admin" ? "disabled" : '';
                                $class = $data->is_active == 1 ? "checked" : "";
                                return '<div class="status-toggle d-flex justify-content-center">
                                                <input ' . $classdis . ' onclick="changestatus(' . $data->id . ')" type="checkbox" id="status_' . $data->id . '" class="check" ' . $class . '>
                                                <label for="status_' . $data->id . '" class="checktoggle">checkbox</label>
                                            </div>';
                            })
                            ->addColumn('created_at', function ($data) {
                                return date('M d, Y', strtotime($data->created_at)) . '<br><small>' . date('h:i a', strtotime($data->created_at)) . '</small>';
                            })
                            ->rawColumns(['user_name', 'created_by', 'created_at', 'status','board_member'])
                            ->make(true);
        } else {
            return view('user.users')->with(['userdata' => $datauser]);
        }
    }

    public function change_theme(Request $request) {
        $user = Auth::user();
        if ($request->ajax() && !empty($request->id)) {
            $subdomain=\App\UserDomain::where("user_id", "=", $request->id)->first();

            $arrEnv['domain_theme']=$request->theme;

             if (SiteSettings::where('name', 'domain_theme')->where('user_id', $request->id)->count() > 0) {
                $query=SiteSettings::where('name', 'domain_theme')->where('user_id', $request->id)->update(array('value' => json_encode($arrEnv),"user_domain_id"=>$subdomain->id));
            } else {
                $query= SiteSettings::insert(array('value' => json_encode($arrEnv), 'name' => 'domain_theme',"user_domain_id"=>$subdomain->id, 'user_id' =>$request->id));
            }

            return response()->json(
                            [
                                'success' => true,
                                'html' => 'success',
                            ]
            );
        }
    }
    public function change_status(Request $request) {
        $user = Auth::user();
        if ($request->ajax() && !empty($request->id)) {
            $user_profile = User::find($request->id);
            $user_profile->is_active = empty($user_profile->is_active) ? 1 : 0;
            $status = $user_profile->update();

            return response()->json(
                            [
                                'success' => true,
                                'html' => 'success',
                            ]
            );
        }
    }

    //change member
    public function change_member(Request $request) {
        $user = Auth::user();
        if ($request->ajax() && !empty($request->id)) {
            $user_profile = User::find($request->id);
            $user_profile->board_member = empty($user_profile->board_member) ? 1 : 0;
            $status = $user_profile->update();

            return response()->json(
                            [
                                'success' => true,
                                'html' => 'success',
                            ]
            );
        }
    }

// bulk delete user
    public function delete_users(Request $request) {
        $user = Auth::user();
        //dd($request->id);
        if ($request->ajax() && !empty($request->id)) {
            $user_profile = User::whereIn('id', $request->id)->where('type', '!=', 'admin')->delete();
            //dd($user_profile);

            return response()->json(
                            [
                                'success' => true,
                                'html' => 'success',
                            ]
            );
        }
    }

    // bulk delete contact
    public function delete_contacts(Request $request) {
        $user = Auth::user();
        //dd($request->id);
        if ($request->ajax() && !empty($request->id)) {
            $user_profile = Contacts::whereIn('id',$request->id)->delete();
           //dd($user_profile);

            return response()->json(
                            [
                                'success' => true,
                                'html' => 'success',
                            ]
            );
        }
    }

    public function change_favourite_user(Request $request) {
        $user = Auth::user();
        if ($request->ajax() && !empty($request->id)) {
            if ($request->type == "remove") {
                $user_profile = \App\FavouriteUser::find($request->id);
                $status = $user_profile->delete();
            } elseif ($request->type == "add") {
                $profile = new \App\FavouriteUser();
                $profile['user_id'] = $user->id;
                $profile['fav_user_id'] = $request->id;
                $profile->save();
            }

            return response()->json(
                            [
                                'success' => true,
                                'html' => 'success',
                            ]
            );
        }
    }
    public function change_like_user(Request $request) {
        $user = Auth::user();
        if ($request->ajax() && !empty($request->id)) {
            if ($request->type == "remove") {
                $user_profile = \App\LikeUser::find($request->id);
                $status = $user_profile->delete();
            } elseif ($request->type == "add") {
                $profile = new \App\LikeUser();
                $profile['user_id'] = $user->id;
                $profile['like_user_id'] = $request->id;
                $profile->save();
            }

            return response()->json(
                            [
                                'success' => true,
                                'html' => 'success',
                            ]
            );
        }
    }

    public function profile_tab(Request $request) {
        $user = Auth::user();

        $html = '';
        switch ($request->tab) {
            case "qualification_tab":
                $data = \App\UserQualification::where('user_id', $user->id)->first();
                $html = view('user.profileTabs.qualification_tab', compact('data'));
                break;
        }
        return $html;
    }

    //update profile qualification
    public function updateProfileQualification(Request $request) {
        $objUser = Auth::user();

        $validate = [];

        $validate = [
            'degree' => 'required|max:100',
            'major' => 'required|max:100',
            'college' => 'required|max:100',
            'program' => 'required|max:100',
        ];

        $validator = Validator::make(
                        $request->all(), $validate
        );
        if ($validator->fails()) {
            return redirect()->back()->with('error', $validator->errors());
        }

        $post = $request->all();
        // remove token
        unset($post['_token']);

        $qualification = \App\UserQualification::where("user_id", $objUser->id)->first();
        if (!empty($qualification)) {
            $qualification->update($post);
        } else {
            $qualification = new \App\UserQualification();
            $qualification['user_id'] = $objUser->id;
            $qualification['degree'] = $post['degree'];
            $qualification['college'] = $post['college'];
            $qualification['major'] = $post['major'];
            $qualification['program'] = $post['program'];
            $qualification['job_title'] = $post['job_title'];
            $qualification->save();
        }
        //update percentage
        update_profile_completion();

        return redirect()->back()->with('success', __('Qualification Updated Successfully!'));
    }

    /**
      plan cancel
     */
    public function profilePlanCancel(Request $request) {
        $user = Auth::user();
        $data = User::where('id', $user->id)->update(['plan' => NULL, 'plan_type' => NULL, 'customer_id' => NULL, 'plan_expire_date' => NULL]);
        if ($data) {
            $this->setPlanCanceledStatus($user->id);
            \App\UserDomain::where('user_id', $user->id)->delete();
            $userdata= $user;
            $emalbody=[
               'note'=>'Your Plan Canceled successfully!',
            ];

            $resp = \App\Utility::send_emails($userdata->email, $userdata->name, null, $emalbody,'cancel_plan',$userdata);


            return redirect()->back()->with('success', __("Your Plan Canceled successfully ."));
        } else {
            $userdata= $user;
            $emalbody=[
               'note'=>'Plan not Canceled!',
            ];

            $resp = \App\Utility::send_emails($userdata->email, $userdata->name, null, $emalbody,'plan_subscription',$userdata);
            return redirect()->back()->with('error', __("Plan not Canceled."));
        }
    }

    private function setPlanCanceledStatus($userId) {
        try {
            Order::where(['user_id' => $userId, 'status' => Order::STATUS_ACTIVE])
                    ->update([
                        'status' => Order::STATUS_CANCELED
            ]);
        } catch (\Exception $exception) {
            $exception->getMessage();
        }
        return true;
    }

    public function showPackageModules(Request $request) {
        $planId = $request->id;
        $plan = new Plan();
        $plan = $plan->getplan($planId);
        $addons = DB::table('addons')->where('status', '=', 'Published')->orderByDesc('id')->get();
        return view('user.show_plan_modules', compact('plan', 'addons'));
    }

    public function chat(Request $request) {

        $user = Auth::user();
$users = User::where('id', '=', 1)->first();
        return view('user.chat', compact('user','users'));
    }

    public function sendMessage(Request $request) {
        $authuser = Auth::user();
        $data = new ChatInbox();
        $data = $data->storeMessage($request);
        return $data;
    }

    public function getchatMentorsList(Request $request) {


        $user = Auth::user();
$userss=array();
         $output='';
        if($request->mentor == 'yes'){


			if($user->type=='admin'){
					$userss = \App\User::select('*')->where('type','!=','admin')->where('is_active','!=','0')->get();
					 $users = null;
                    $usersnochat = array();
					 foreach ($userss as $key => $_user) {

                        $lastmessage = getUserLastMessage($_user->id);
                        if ($lastmessage) {
                            $users[$lastmessage->created_at->toDateTimeString()] = $_user;
                        } else {
                            $usersnochat[$key] = $_user;
                        }
                    }
					  if ($users == null) {
                        $users = $usersnochat;
                    } else {
                        krsort($users);
                        $users = array_merge($users, $usersnochat);
                    }


			}

			elseif($user->type=='mentor'){
			 $domain_user= get_domain_user();
				 if (!empty($domain_user)) {
				 	 $usersss = \App\User::where('created_by', $domain_user->id)->orWhere('type','admin')->where('is_active','!=','0')->get();

					 	 $users = null;
                    $usersnochat = array();
					 foreach ($usersss as $key => $_user) {

                        $lastmessage = getUserLastMessage($_user->id);
                        if ($lastmessage) {
                            $users[$lastmessage->created_at->toDateTimeString()] = $_user;
                        } else {
                            $usersnochat[$key] = $_user;
                        }
                    }
					  if ($users == null) {
                        $users = $usersnochat;
                    } else {
                        krsort($users);
                        $users = array_merge($users, $usersnochat);
                    }
            }

			}
			elseif($user->type=='mentee'){

				$domain_user= get_domain_user();
				 $users = \App\User::select('*')->orderBy('id', 'ASC')->orWhere('type','admin')->orWhere('id',$domain_user->id)->where('is_active','!=','0')->get();


			}
			else{
				 $domain_user= get_domain_user();
				  $users = \App\User::select('*')->orderBy('id', 'ASC')->orWhere('type','admin')->where('is_active','!=','0')->get();
					  if (!empty($domain_user)) {
					$users->where('created_by', $domain_user->id);
				 }


			}


            if(!empty($users)){
                foreach($users as $uk => $uv){
                    $output.="<a href='javascript:void(0);'  class='list-group-item list-group-item-action mentorDataMessage' data-id='".$uv->id."' data-authid='".Auth::user()->id."'>

                    <div class='d-flex align-items-center' data-toggle='tooltip' data-placement='right' data-title='' data-original-title='' title=''>
                    <div>
                    <div class='avatar-parent-child'>";
                    if (getUserDetails($uv->id)->avatar && file_exists( storage_path().'/app/'.$uv->avatar ) ){
                        $output .= "<img alt='Image placeholder' src='" . asset('storage/app') . "/" . getUserDetails($uv->id)->avatar . "' class='avatar rounded-circle'>";
                    } else {
                        $output .= "<span class='avatar avatar_c rounded-circle'>" . substr(ucfirst(getUserDetails($uv->id)->name), 0, 1) . "</span>";
                    }

                    if (getUserDetails($uv->id)->login_status == 0) {
                        $output .= "<span class='avatar-child avatar-badge bg-warning'></span></div></div>";
                    } else {
                        $output .= "<span class='avatar-child avatar-badge bg-success'></span> </div></div>";
                    }
                    $output .= " <div class='flex-fill ml-3'><h6 class='text-sm mb-0 contact-name'>" . ucfirst(getUserDetails($uv->id)->name) . "</h6>";

                    if (getUserLastMessage($uv->id)) {
                        $output .= "<p class='text-sm mb-0'> " . substr(getUserLastMessage($uv->id)->message_text, 0, 5) . "";
                        if (strlen(getUserLastMessage($uv->id)->message_text) > 5) {
                            $output .= "...";
                        }
                        $output .= " </p>";
                    }
                    $output .= "</div>";

                    $output .= "<div class='chatDivMessage'>";
                    if (getUserLastMessage($uv->id)) {
                        $output .= "<p class='allMessageTiming'>" . time_elapsed_string(getUserLastMessage($uv->id)->created_at) . "</p>";
                        if (getUserUnreadMessageCount($uv->id)) {

                            $output .= "<span class='meaasgechat'>" . getUserUnreadMessageCount($uv->id) . "</span>";
                        }
                    }
                    $output .= "</div>";
                    $output .= "</div></a>";
                }
                $array = ['output' => $output, 'mentors' => 1];
            } else {

                $output .= "<h4>No user found.</h4>";
                $array = ['output' => $output, 'mentors' => 0];
            }
        } else {
            $output .= "<a href='javascript:void(0);'  class='list-group-item list-group-item-action mentorDataMessage' data-id='0'><div class='d-flex align-items-center' data-toggle='tooltip' data-placement='right' data-title='' data-original-title='' title=''> <div> <div class='avatar-parent-child'>";
            $robot_img = SiteSettings::select('value')->where('name', 'robot_img')->first();
            $img = asset('public/') . '/img/' . $this->getBotImage();

            $output .= "<img alt='Image placeholder' src='" . $img . "' class='avatar rounded-circle'>";
            $output .= "<span class='avatar-child avatar-badge bg-success'></span> </div></div>";
            $output .= " <div class='flex-fill ml-3'><h6 class='text-sm mb-0 contact-name'>";
            $output .= $this->getBotName();
            $output .= "</h6>";
            $output .= "<p class='text-sm mb-0'> How may i help you?</p>";
            $output .= "</div>";
            $output .= "<div class='chatDivMessage'>";
            $output .= "</div>";
            $output .= "</div></a>";

            $array = ['output' => $output, 'mentors' => 0];
        }

        return json_encode($array);
    }

    public static function getBotImage() {
        if (SiteSettings::select('value')->where('name', 'robot_img')->where('user_id', Auth::user()->id)->count() > 0) {
            $data= SiteSettings::select('value')->where('name', 'robot_img')->where('user_id', Auth::user()->id)->first();
             return !empty($data->value)?$data->value:'';
        } else {
            $data= SiteSettings::select('value')->where('name', 'robot_img')->where('user_id', 1)->first();
             return !empty($data->value)?$data->value:'';
        }
    }

    public static function getBotName() {
        if (SiteSettings::select('value')->where('name', 'bot_name')->where('user_id', Auth::user()->id)->count() > 0) {
            $data= SiteSettings::select('value')->where('name', 'bot_name')->where('user_id', Auth::user()->id)->first();
              return !empty($data->value)?$data->value:'';
        } else {
            $data=SiteSettings::select('value')->where('name', 'bot_name')->where('user_id', 1)->first();
             return !empty($data->value)?$data->value:'';
        }
    }

    public function getMessage(Request $request) {

        $authuser = Auth::user();
        $data = new ChatInbox();
        Session::put('mentor_chat_id', $request->userId);
        if ($request->userId != 0) {
            $data = $data->currentMentorChat($request->userId);
            //dd($data);

            $user = $request->userId;
            $userprofile=\App\User::find($user);
            $chatroulette_flag = (!empty($_COOKIE['chatroulette'])) ? 1 : 0;
            if ($request->message == 1) {

                return view('mentors.onlyChat', compact('data', 'user', 'chatroulette_flag','userprofile'));
            } else {
                $users = User::where('type', 'mentor')->get();
                return view('mentors.mentorChat', compact('data', 'user', 'chatroulette_flag', 'users','userprofile'));
            }
        } else {
            $user = $request->userId;
             $userprofile=\App\User::find($user);
            $robot_img = SiteSettings::select('value')->where('name', 'robot_img')->first();
            return view('mentors.mentorChat', compact('user', 'robot_img','userprofile'));
        }
    }

    public function getMentorMessage(Request $request) {

        $authuser = Auth::user();
        $data = new ChatInbox();
        $data = $data->currentUserChat($request->userId, $request->inbox);
        $user = $request->userId;
        $inbox = $request->inbox;
        return view('mentors.mentorChat', compact('data', 'user'));
    }

    public static function getBotGreetings() {
        if (SiteSettings::select('value')->where('name', 'greetings')->where('user_id', 1)->count() > 0) {
            $sb = SiteSettings::select('value')->where('name', 'greetings')->where('user_id', 1)->first()->value;
            $dv = explode(',', $sb);

            if (!empty($dv)) {
                foreach ($dv as $k => $v) {
                    $dv[$k] = str_replace("{name}", Auth::user()->name, $v);
                }
            }
            $random_keys = array_rand($dv);
            return $dv[$random_keys];
        } else if (SiteSettings::select('value')->where('name', 'greetings')->where('user_id', 1)->count() > 0) {
            $sb = SiteSettings::select('value')->where('name', 'greetings')->where('user_id', 1)->first()->value;
            $dv = explode(',', $sb);

            if (!empty($dv)) {
                foreach ($dv as $k => $v) {
                    $dv[$k] = str_replace("{name}", Auth::user()->name, $v);
                }
            }
            $random_keys = array_rand($dv);
            return $dv[$random_keys];
        } else {
            return 'How may i help you ?';
        }
    }

    public static function getBotCompanyName() {
        $UserSettings = SiteSettings::where(['user_id' => Auth::user()->id, 'name' => 'favicon'])->first();
        if (isset($UserSettings->id)) {
            $detail = json_decode($UserSettings->value, true);
            if (isset($detail['logo_text']) && $detail['logo_text'] !== "") {
                $name = $detail['logo_text'];
            } else {
                $name = 'StemX';
            }
        } else {
            $name = 'StemX';
        }


        return 'Welcome to ' .$name;
    }

    public function SSTtoken() {
        $speech_key = SiteSettings::select('value')->where('name', 'speech_key')->first();
        $speech_region = SiteSettings::select('value')->where('name', 'speech_region')->first();

        $subscriptionKey = $speech_key->value ?? '';
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, 'https://' . ($speech_region->value ?? '') . '.api.cognitive.microsoft.com/sts/v1.0/issuetoken');
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, '{}');
        curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json', 'Ocp-Apim-Subscription-Key: ' . $subscriptionKey));
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        echo curl_exec($ch);
    }

    public function getBotReply(Request $request) {
        $authuser = Auth::user();

        $admin_faqs = SiteSettings::select('value')->where('name', 'admin_faqs')->where('user_id', 1)->first();

        $message = trim(addslashes($request->message));

        if (isset($admin_faqs->value) && $admin_faqs->value == 1) {
            $result = Faq::select('faqs.answer')->where('faqcategories.name', 'BOT')
                    ->whereIn('faqs.user_id', [1, $authuser->id])->where('faqs.question', $message)
                    ->leftJoin('faqcategories', 'faqcategories.id', '=', 'faqs.category_id')->first();
        } else {
            $result = Faq::select('faqs.answer')->where('faqcategories.name', 'BOT')
                    ->where('faqs.user_id', $authuser->id)->where('faqs.question', $message)
                    ->leftJoin('faqcategories', 'faqcategories.id', '=', 'faqs.category_id')->first();
        }

        if (!$result) {

            if (isset($admin_faqs->value) && $admin_faqs->value == 1) {
                $result = Faq::select('faqs.answer')->where('faqcategories.name', 'BOT')->whereIn('faqs.user_id', [1, $authuser->id])->where('faqs.question', 'LIKE', trim($request->message) . '%')->leftJoin('faqcategories', 'faqcategories.id', '=', 'faqs.category_id')->first();
            } else {
                $result = Faq::select('faqs.answer')->where('faqcategories.name', 'BOT')->where('faqs.user_id', 1)->where('faqs.question', 'LIKE', trim($request->message) . '%')->leftJoin('faqcategories', 'faqcategories.id', '=', 'faqs.category_id')->first();
            }

            if (!$result) {
                $keywordRaw = $message;
                $keywords = explode(' ', $keywordRaw);
                $toEnd = count($keywords);

                if (isset($admin_faqs->value) && $admin_faqs->value == 1) {
                    $query = "select answer from faqs LEFT JOIN faqcategories ON faqcategories.id=faqs.category_id where FIND_IN_SET ('" . $message . "', faqs.keywords) AND faqcategories.name='BOT' AND faqs.user_id IN ('" . $authuser->id . "','1') ORDER BY RAND() LIMIT 1";
                } else {
                    $query = "select answer from faqs LEFT JOIN faqcategories ON faqcategories.id=faqs.category_id where FIND_IN_SET ('" . $message . "', faqs.keywords) AND faqcategories.name='BOT' AND faqs.user_id='1' ORDER BY RAND() LIMIT 1";
                }
                if ($result = DB::select($query)) {
                    if (!empty($result)) {
                        $answer = $result[0]->answer;
                    } else {

                        if (SiteSettings::where('name', 'wiki_search')->where('user_id', 1)->count() > 0) { //if wiki is enabled
                            $wiki_flag = SiteSettings::select('value')->where('name', 'wiki_search')->where('user_id', 1)->first();
                            if ($wiki_flag->value == 1) {
                                $wiki_key = SiteSettings::select('value')->where('name', 'wiki_key')->first();
                                $accessKey = $wiki_key->value;
                                $endpoint = 'https://api.bing.microsoft.com/v7.0/search';
                                $term = $message;

                                list($headers, $json) = $this->bingWebSearch($endpoint, $accessKey, $term);
                                $result = json_decode($json);
                                if ($result->webPages) {
                                    $answer = $result->webPages->value[0]->snippet;
                                } else {
                                    Unansweredfaq::insert(['question' => $message, 'user_id' => $authuser->id]);
                                    $answer = $this->getBotDefaultAnswer();
                                }
                            } else {
                                Unansweredfaq::insert(['question' => $message, 'user_id' => $authuser->id]);
                                $answer = $this->getBotDefaultAnswer();
                            }
                        } else {
                            Unansweredfaq::insert(['question' => $message, 'user_id' => $authuser->id]);
                            $answer = $this->getBotDefaultAnswer();
                        }
                    }
                } else {
                    if (SiteSettings::where('name', 'wiki_search')->where('user_id', 1)->count() > 0) { //if wiki is enabled
                        $wiki_flag = SiteSettings::select('value')->where('name', 'wiki_search')->where('user_id', 1)->first();
                        if ($wiki_flag->value == 1) {
                            $wiki_key = SiteSettings::select('value')->where('name', 'wiki_key')->first();
                            $accessKey = $wiki_key->value;
                            $endpoint = 'https://api.bing.microsoft.com/v7.0/search';
                            $term = $message;

                            list($headers, $json) = $this->bingWebSearch($endpoint, $accessKey, $term);
                            $result = json_decode($json);
                            if ($result->webPages) {
                                $answer = $result->webPages->value[0]->snippet;
                            } else {
                                Unansweredfaq::insert(['question' => $message, 'created_by' => $authuser->id]);
                                $answer = $this->getBotDefaultAnswer();
                            }
                        } else {
                            Unansweredfaq::insert(['question' => $message, 'created_by' => $authuser->id]);
                            $answer = $this->getBotDefaultAnswer();
                        }
                    } else {
                        Unansweredfaq::insert(['question' => $message, 'created_by' => $authuser->id]);
                        $answer = $this->getBotDefaultAnswer();
                    }
                }
            } else {
                $answer = $result->answer;
            }
        } else {
            $answer = $result->answer;
        }


            $voice = $this->getBotVoiceName();

        if($answer == '{bot_name}'){
            $answer = $this->getBotName();
        }
        $array = ['answer'=> $answer,'voice'=>$voice];
        return json_encode($array);
    }
    public function getPathwayBotReply(Request $request) {
        $authuser = Auth::user();
         $arrVariable=[];
           $arrValue=[];
        $message = trim($request->message);
        $result = SiteSettings::select('value')->where('name', 'pathways_bot')->where('user_id', 1)->first();
            $response= !empty($result->value) ? json_decode($result->value,true):array();

        if(!empty($response['ENABLE_BOT']) && $response['ENABLE_BOT']=='on'){
            $answer=!empty($response[$message]) ? $response[$message]:'';
            if(!empty($answer)){
                $answer= explode(',', $answer);
                $random_key=array_rand($answer,1);
                $answer=$answer[$random_key];

            }
        }else{
           $answer='';
        }

              if(!empty($authuser->name)){
            array_push($arrVariable, '{name}');
               array_push($arrValue, $authuser->name);
       }
           if(!empty($authuser->email)){
                array_push($arrVariable, '{email}');
                   array_push($arrValue, $authuser->email);
           }
           if(!empty($authuser->address)){
                array_push($arrVariable, '{address}');
                   array_push($arrValue, $authuser->address);
           }
           if(!empty($authuser->mobile)){
                array_push($arrVariable, '{mobile}');
                   array_push($arrValue, $authuser->mobile);
           }

           $answer= str_replace($arrVariable, array_values($arrValue), $answer);

            $voice = $this->getBotVoiceName();

        if($answer == '{bot_name}'){
            $answer = $this->getBotName();
        }
        $array = ['answer'=> $answer,'voice'=>$voice];
        return json_encode($array);
    }


	   public static function bingWebSearch($url, $key, $query){
        $headers = "Ocp-Apim-Subscription-Key: $key\r\n";
        $options = array ('http' => array (
                              'header' => $headers,
                               'method' => 'GET'));
        $context = stream_context_create($options);
        $result = file_get_contents($url . "?q=" . urlencode($query), false, $context);
        $headers = array();
        foreach ($http_response_header as $k => $v) {
            $h = explode(":", $v, 2);
            if (isset($h[1]))
                if (preg_match("/^BingAPIs-/", $h[0]) || preg_match("/^X-MSEdge-/", $h[0]))
                    $headers[trim($h[0])] = trim($h[1]);
        }
        return array($headers, $result);
    }

    public static function getBotDefaultAnswer() {
        if (SiteSettings::select('value')->where('name', 'default_answer')->where('user_id', Auth::user()->id)->count() > 0) {
            $sb = SiteSettings::select('value')->where('name', 'default_answer')->where('user_id', Auth::user()->id)->first()->value;
            $dv = explode(',', $sb);
            $random_keys = array_rand($dv);
            return $dv[$random_keys];
        } else if (SiteSettings::select('value')->where('name', 'default_answer')->where('user_id', 1)->count() > 0) {
            $sb = SiteSettings::select('value')->where('name', 'default_answer')->where('user_id', 1)->first()->value;
            $dv = explode(',', $sb);
            $random_keys = array_rand($dv);
            return $dv[$random_keys];
        } else {
            return 'I do not know answer at that moment';
        }
    }

    public static function getBotVoiceName() {
        if (SiteSettings::select('value')->where('name', 'speech_voice')->where('user_id', Auth::user()->id)->count() > 0) {
            $result = SiteSettings::select('value')->where('name', 'speech_voice')->where('user_id', Auth::user()->id)->first();
            return $result->value ?? 0;
        } else {
            $result = SiteSettings::select('value')->where('name', 'speech_voice')->where('user_id', 1)->first();
            return $result->value ?? 0;
        }
    }


	   public static function getWakeWord(){
        if(SiteSettings::select('value')->where('name','wake_word')->where('user_id',Auth::user()->id)->count() > 0){
            $result= SiteSettings::select('value')->where('name','wake_word')->where('user_id',Auth::user()->id)->first();
            return $result->value ?? '';
        }else{
             $result= SiteSettings::select('value')->where('name','wake_word')->where('user_id',1)->first();
             return $result->value ?? '';
        }
    }
    public function getgroupMessage(Request $request) {


        $authuser = Auth::user();
        $data = new ChatInbox();
        $data = $data->currentUserChat($request->userId, $request->inbox);
        $user = $request->userId;
        $inbox = $request->inbox;
        return view('mentors.userChat', compact('data', 'user', 'inbox'));
    }

    public function statemap(Request $request) {
        $maps = [];
        $max = 0;
        $title = '';
        $subtitle = '';
        $states = get_us_states();

                $user = Auth::user();
        switch ($request->view) {
            case "petition dashboard":
                foreach ($states as $state) {
                    $total = \App\PetitionFormResponses::join('users as u', 'u.id', '=', 'petition_form_responses.user_id')
                            ->leftjoin('petition_forms as cf', 'cf.id', '=', 'petition_form_responses.form_id')
                            ->where('u.state', $state)
                            ->where('cf.user_id', $user->id)
                            ->count();
                    if ($total > $max) {
                        $max = $total;
                    }

                    array_push($maps, ['name' => $state, 'value' => $total]);
                }

                $title = "Petition supporters accross USA";
                $subtitle = "Data from supporter responses";
                break;
            case "survey dashboard":
                foreach ($states as $state) {
                    $total = \App\CrmCustomFormResponses::join('users as u', 'u.id', '=', 'crm_custom_form_responses.user_id')
                            ->leftjoin('crm_custom_forms as cf', 'cf.id', '=', 'crm_custom_form_responses.form_id')
                            ->where('u.state', $state)
                            ->where('cf.user_id', $user->id)
                            ->count();
                    if ($total > $max) {
                        $max = $total;
                    }

                    array_push($maps, ['name' => $state, 'value' => $total]);
                }

                $title = "Survey participants accross USA";
                $subtitle = "Data from survey responses";
                break;
            case "assessment dashboard":
                foreach ($states as $state) {
                    $total = \App\AssessmentResponses::join('users as u', 'u.id', '=', 'assessmentresponses.user_id')
                            ->leftjoin('assessmentforms as cf', 'cf.id', '=', 'assessmentresponses.form')
                            ->where('u.state', $state)
                            ->where('cf.user_id', $user->id)
                            ->count();
                    if ($total > $max) {
                        $max = $total;
                    }

                    array_push($maps, ['name' => $state, 'value' => $total]);
                }

                $title = "Assessment participants accross USA";
                $subtitle = "Data from assessment responses";
                break;
        }


        $maps = array(
            "data" => $maps,
            "max" => $max,
            "title" => $title,
            "subtitle" => $subtitle,
        );
        echo json_encode($maps);
        exit;
    }
    public function statemapdots(Request $request) {
       $alladdress = array();
                $content = array();
                $user = Auth::user();
        switch ($request->view) {
            case "petition dashboard":

                    $data = \App\User::leftjoin('petition_form_responses as r', 'users.id', '=', 'r.user_id')
                            ->leftjoin('petition_forms as cf', 'cf.id', '=', 'r.form_id')
                            ->where('cf.user_id', $user->id)
                     ->where('users.address_lat','!=',0.0000)
                            ->select('users.*')
                            ->get();

                if(!empty($data)){
                  foreach($data as $user){
                     $address[$user->city] = array();
                     $content['content']= "Name: ". $user->name . " Address: ". $user->address1;
                     $address[$user->city]['latitude'] = $user->address_lat;
                     $address[$user->city]['longitude'] = $user->address_long;
                    $address[$user->city]['tooltip'] =  $content;

                    $alladdress[$user->city] =  $address[$user->city];
                 }
                }
                break;
            case "survey dashboard":

                   $data = \App\User::leftjoin('crm_custom_form_responses as r', 'users.id', '=', 'r.user_id')
                            ->leftjoin('crm_custom_forms as cf', 'cf.id', '=', 'r.form_id')
                            ->where('cf.user_id', $user->id)
                     ->where('users.address_lat','!=',0.0000)
                            ->select('users.*')
                            ->get();

                if(!empty($data)){
                  foreach($data as $user){
                     $address[$user->city] = array();
                     $content['content']= "Name: ". $user->name . " Address: ". $user->address1;
                     $address[$user->city]['latitude'] = $user->address_lat;
                     $address[$user->city]['longitude'] = $user->address_long;
                    $address[$user->city]['tooltip'] =  $content;

                    $alladdress[$user->city] =  $address[$user->city];
                 }
                }


                break;
            case "assessment dashboard":

                   $data = \App\User::leftjoin('assessmentresponses as r', 'users.id', '=', 'r.user_id')
                            ->leftjoin('assessmentforms as cf', 'cf.id', '=', 'r.form')
                            ->where('cf.user_id', $user->id)
                     ->where('users.address_lat','!=',0.0000)
                            ->select('users.*')
                            ->get();

                if(!empty($data)){
                  foreach($data as $user){
                     $address[$user->city] = array();
                     $content['content']= "Name: ". $user->name . " Address: ". $user->address1;
                     $address[$user->city]['latitude'] = $user->address_lat;
                     $address[$user->city]['longitude'] = $user->address_long;
                    $address[$user->city]['tooltip'] =  $content;

                    $alladdress[$user->city] =  $address[$user->city];
                 }
                }


                break;
        }


      $data = json_encode($alladdress);
      $responseHtml = view('frontend.mentoringtheme.profiles.map', compact('data'))->render();

      return response()->json([
                //'map' => $responseMapHtml,
                'html' => $responseHtml,
            ]);
    }




}
