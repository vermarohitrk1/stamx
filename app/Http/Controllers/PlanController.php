<?php

namespace App\Http\Controllers;

use App\Order;
use App\Plan;
use App\User;
use App\UsersPlan;
use App\Addon;
use App\Utility;
use App\UrlIdentifier;
use App\ModulesManager;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Filesystem\Filesystem;
use Illuminate\Support\Str;
use DateTime;
use DataTables;
use App\AddonCategory;

class PlanController extends Controller
{

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if (\Auth::user()->type == 'admin') {
            $plans = Plan::all();
            return view('plans.index', compact('plans'));
        } else {
            return redirect()->back()->with('error', __('Permission Denied.'));
        }
    }

    public function planFrontendStatus(Request $request)
    {
        return $plan = Plan::where(['id' => $request->id])->update(['status' => $request->status]);
    }

    public function TestPlans()
    {
        $plans = Plan::all();

        $allow = false;

        if ((env('ENABLE_STRIPE') == 'on' && !empty(env('STRIPE_KEY')) && !empty(env('STRIPE_SECRET'))) || (env('ENABLE_PAYPAL') == 'on' && !empty(env('PAYPAL_CLIENT_ID')) && !empty(env('PAYPAL_SECRET_KEY')))) {
            $allow = true;
        }
        $planid = Auth::user()->plan;

        return view('affiliate.plans.test_plans', compact('plans', 'allow', 'planid'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        if (\Auth::user()->type == 'admin') {

                $plan = new Plan();
                return view('plans.create', compact('plan'));

        } else {
            return redirect()->back()->with('error', __('Permission Denied.'));
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     *
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        if (\Auth::user()->type == 'admin') {

                $validation = [];
                $validation['name'] = 'required|unique:plans';


                $validator = \Validator::make($request->all(), $validation);
                if ($validator->fails()) {
                    $messages = $validator->getMessageBag();
                    return redirect()->back()->with('error', $messages->first());
                }
                $post = $request->all();
                if ($plan = Plan::create($post)) {

                    return redirect()->back()->with('success', __('Plan created Successfully!'));
                } else {
                    return redirect()->back()->with('error', __('Something is wrong'));
                }

        } else {
            return redirect()->back()->with('error', __('Permission Denied.'));
        }
    }

    /**
     * Display the specified resource.
     *
     * @param \App\Plan $plan
     *
     * @return \Illuminate\Http\Response
     */
    public function show(Plan $plan)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param \App\Plan $plan
     *
     * @return \Illuminate\Http\Response
     */
    public function edit($id=0)
    {
        if (\Auth::user()->type == 'admin') {
		$plan = Plan::find($id);


            return view('plans.edit', compact('plan'));
        } else {
            return redirect()->back()->with('error', __('Permission Denied.'));
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param \App\Plan $plan
     *
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        if (\Auth::user()->type == 'admin') {
			   $plan = plan::find($request->id);

            if ($plan) {

                $validation = [];
             //   $validation['name'] = 'required|unique:plans,name,' . $plan->id;
                // $validation['price']        = 'required|numeric|min:0';


                $validator = \Validator::make($request->all(), $validation);
                if ($validator->fails()) {
                    $messages = $validator->getMessageBag();
                    return redirect()->back()->with('error', $messages->first());
                }

                $post = $request->all();
                if (!isset($request->status)) {
                    $post['status'] = 'false';
                }
                if ($plan->update($post)) {

                    return redirect()->back()->with('success', __('Plan updated Successfully!'));
                } else {
                    return redirect()->back()->with('error', __('Something is wrong'));
                }
            } else {
                return redirect()->back()->with('error', __('Plan not found'));
            }
        } else {
            return redirect()->back()->with('error', __('Permission Denied.'));
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param \App\Plan $plan
     *
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $planID = (int) $id;
        $plan = Plan::find($planID);
        $plan->delete();
        return redirect()->back()->with('success', __('Plans deleted successfully.'));
    }

    public function userPlan(Request $request)
    {
        $objUser = \Auth::user();
        $planID = \Illuminate\Support\Facades\Crypt::decrypt($request->code);
        $plan = Plan::find($planID);
        if ($plan) {
            if ($plan->price <= 0) {
                $userData = array(
                    'minutes' => (int)$plan->max_minutes
                );
                DB::table("user_settings")->where("user_id", Auth::user()->id)
                    ->update($userData);

                $objUser->assignPlan($plan->id);
                app('App\Http\Controllers\AffiliateController')->enroll_affiliate_points($plan->id);
                return redirect()->route('profile')->with('success', __('Plan activated Successfully!'));
            } else {
                $userData = array(
                    'minutes' => (int)$plan->max_minutes
                );
                DB::table("user_settings")->where("user_id", Auth::user()->id)
                    ->update($userData);

                $objUser->assignPlan($plan->id);
                return redirect()->route('profile')->with('success', __('Plan activated Successfully!'));
            }
        } else {
            return redirect()->back()->with('error', __('Plan not found'));
        }
    }

    /**
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\View\View
     * @throws \Exception
     */
    public function orderList()
    {
        $objUser = \Auth::user();
        if (\Auth::user()->type == User::TYPE_ADMIN) {
            $subscribers = DB::select('select user_id from orders group by user_id');
            $date = date("Y-m-d H:i:s");
            $date = new DateTime($date);
            $date->modify("-1 day");
            $date = $date->format("Y-m-d H:i:s");
            $today = DB::select("SELECT sum(price) as total FROM orders where created_at >= '$date'");
            $date = date("Y-m-d H:i:s");
            $date = new DateTime($date);
            $date->modify("-1 month");
            $date = $date->format("Y-m-d H:i:s");
            $monthly = DB::select("SELECT sum(price) as total FROM orders where created_at >= '$date'");
            $date = date("Y-m-d H:i:s");
            $date = new DateTime($date);
            $date->modify("-1 year");
            $date = $date->format("Y-m-d H:i:s");
            $anual = DB::select("SELECT sum(price) as total FROM orders where created_at >= '$date'");

            $activeTotal = Order::where('status', Order::STATUS_ACTIVE)->count();
            $suspendedTotal = Order::where('status', Order::STATUS_SUSPENDED)->count();
            $canceledTotal = Order::where('status', Order::STATUS_CANCELED)->count();

            $orders = Order::select([
                'orders.*',
                'users.name as user_name',
            ])->join('users', 'orders.user_id', '=', 'users.id')->orderBy('id', 'DESC')->get();

            return view('plans.orderlist', compact('orders', 'subscribers', 'today', 'monthly', 'anual', 'activeTotal', 'suspendedTotal', 'canceledTotal'));
        }
		elseif(\Auth::user()->type == User::TYPE_OWNER){
            $subscribers = DB::select("select user_id from orders where parent_id ='$objUser->id' group by user_id");
            $date = date("Y-m-d H:i:s");
            $date = new DateTime($date);
            $date->modify("-1 day");
            $date = $date->format("Y-m-d H:i:s");
            $today = DB::select("SELECT sum(price) as total FROM orders where parent_id ='$objUser->id' AND created_at >= '$date'");
            $date = date("Y-m-d H:i:s");
            $date = new DateTime($date);
            $date->modify("-1 month");
            $date = $date->format("Y-m-d H:i:s");
            $monthly = DB::select("SELECT sum(price) as total FROM orders where parent_id ='$objUser->id' AND created_at >= '$date'");
            $date = date("Y-m-d H:i:s");
            $date = new DateTime($date);
            $date->modify("-1 year");
            $date = $date->format("Y-m-d H:i:s");
            $anual = DB::select("SELECT sum(price) as total FROM orders where parent_id ='$objUser->id' AND created_at >= '$date'");
            $activeTotal = Order::where(['status' => Order::STATUS_ACTIVE, 'parent_id' => $objUser->id])->count();
            $suspendedTotal = Order::where(['status' => Order::STATUS_SUSPENDED, 'parent_id' => $objUser->id])->count();
            $canceledTotal = Order::where(['status' => Order::STATUS_CANCELED, 'parent_id' => $objUser->id])->count();
            $orders = Order::select([
                'orders.*',
                'users.name as user_name',
            ])->join('users', 'orders.user_id', '=', 'users.id')->where('orders.parent_id',$objUser->id )->orderBy('id', 'DESC')->get();

		  return view('plans.orderlist', compact('orders', 'subscribers', 'today', 'monthly', 'anual', 'activeTotal', 'suspendedTotal', 'canceledTotal'));
        }
		else {
            return redirect()->route('home')->with('error', __('Permission Denied.'));
        }
    }

    public function plansaddmodules($planId)
    {
        $authuser = Auth::user();
        $plan = new Plan();
        $plan = $plan->getplan($planId);

        $addons = DB::table('addons')->where('status', '=', 'Published')->orderByDesc('id')->get();

	   return view('plans.plansaddmodules', compact('addons', 'plan'));
    }

    public function plansModulesManager($planId)
    {
        $authuser = Auth::user();
        $ModulesManager = new ModulesManager();
        $ModulesManager = $ModulesManager->getplaModulesManager($planId);
        return view('plans.plansModulesManage', compact('ModulesManager', 'planId'));
    }

    public function plansAddons(Request $request)
    {
        $authuser = Auth::user();
        if ($request->ajax()) {
            $data = $addons = Addon::select('id','icon','title','addon_key','status','usage_status','features')->orderByDesc('id');
            return Datatables::of($data)
                ->addIndexColumn()
                ->filterColumn('title', function ($query, $keyword) use ($request) {
                    $sql = "addons.title like ?";
                    $query->whereRaw($sql, ["%{$keyword}%"]);
                })
                ->addColumn('title', function ($data) {
                    return '<div class="media align-items-center">
                            <div>
                                <img src="' . asset('storage') . '/addon/' . $data->icon . '"
                                     class="avatar">
                            </div>
                            <div class="media-body ml-4">
                                ' . ucfirst($data->title) . '
                            </div>';
                })->addColumn('key', function ($data) {
                    return '<span class="badge badge-dot mr-4">
                                <i class="' . ((!empty($data->addon_key)) ? 'bg-success' : 'bg-danger') . '"></i>
                                <span class="status">
                                    ' . ((!empty($data->addon_key)) ? 'Connected' : 'Not Connected') . '
                                </span>
                            </span>';
                })->addColumn('status', function ($data) {
                    return '<span class="badge badge-dot mr-4">
                                <i class="' . (($data->status == 'Published') ? 'bg-success' : 'bg-danger') . '"></i>
                                <span class="status">' . $data->status . '</span>
                            </span>';
                })
                ->addColumn('usage', function ($data) {
                    return '<span class="badge badge-dot mr-4">
                                <i class="' . (($data->usage_status == 'Enabled') ? 'bg-success' : 'bg-danger') . '"></i>
                                <span class="status">
                                    ' . (($data->usage_status == 'Enabled') ? 'Enabled' : 'Disabled') . '
                                </span>
                            </span>';
                })
                ->addColumn('features', function ($data) {
                    $badges= explode(",", $data->features);
                    $html ='';
                    if(!empty($badges)){
                        foreach ($badges as $badge){
                    $html .= '<span class="badge badge-pill badge-primary mr-1">
                                    ' . $badge .'

                            </span>';
                    }
                    }
                    return $html;
                })
                ->addColumn('action', function ($data) {
                    $authuser = Auth::user();
                    $actionBtn = '<div class="actions text-center">
                                    <a href="' . route('plans.addons.edit', ['id' => $data->id]) . '"
                                       class="action-item px-2"
                                       data-toggle="tooltip" data-original-title="Edit">
                                        <i class="fas fa-edit"></i>
                                    </a>

                                    <a href="javascript:void(0)"
                                       class="action-item text-danger px-2 destroyaddon delete_record_model"
                                       data-url="'.route('plans.addons.destroy',$data->id).'" data-toggle="tooltip"
                                       data-original-title="Delete">
                                        <i class="fas fa-trash-alt"></i>
                                    </a>
                                </div>';
                    return $actionBtn;
                })
                ->rawColumns(['action', 'title', 'key', 'status', 'usage','features'])
                ->make(true);
        } else {
            if ($authuser->type == 'admin') {
                return view('plans.addons.index', compact('authuser'));
            } else {
                return redirect()->back()->with('error', __('Addon Only for Admin Use.'));
            }
        }
    }

    public function plansAddonsAdd(Request $request)
    {
        $authuser = Auth::user();
        if ($authuser->type == 'admin') {
            $plan = new Plan();
            $plan = $plan->getplan($request->planId);
            if (empty($plan->id)) {
                return redirect()->back()->with('error', __('Plan Not Found.'));
            } else {
                $PlanAddedOnsSave = $plan->savePlanAddons($request);
                if (!empty($PlanAddedOnsSave)) {
                    return redirect()->back()->with('success', __('Plan Modules Updated successfully.'));
                } else {
                    return redirect()->back()->with('error', __('Plan Modules Not Updated.'));
                }
            }
        } else {
            return redirect()->back()->with('error', __('Addon Only for Admin Use.'));
        }
    }

    public function plansAddonsCreate()
    {
        $UrlIdentifier = UrlIdentifier::where(['status' => 'Published'])->get();
        $category_arr = AddonCategory::get();

        return view('plans.addons.create', compact('UrlIdentifier','category_arr'));
    }

    public function plansAddonsKeycheck()
    {
        if (isset($_GET['addon_key'])) {
            $addon_key = $_GET['addon_key'];
        }
        $addons = new Addon();
        $addons = $addons->AddonsKeycheck($addon_key);
        return $addons;
    }

    public function plansAddonsList()
    {
        $authuser = Auth::user();
        $addons = DB::table('addons')->select('id','icon','title','addon_key','status','')->where('user_id', '=', $authuser->id)->orderByDesc('id')->get();
        return view('plans.addons.list', compact('addons', 'authuser'));
    }

    public function plansAddonsStore(Request $request)
    {
        $authuser = Auth::user();
        $image = '';
        $icon = '';
        if (!empty($request->image)) {
            $base64_encode = $request->image;
            $folderPath = "storage/addon/";
            $image_parts = explode(";base64,", $base64_encode);
            $image_type_aux = explode("image/", $image_parts[0]);
            $image_type = $image_type_aux[1];
            $image_base64 = base64_decode($image_parts[1]);
            $image = "addon" . uniqid() . '.' . $image_type;;
            $file = $folderPath . $image;
            file_put_contents($file, $image_base64);
        }


        if (!empty($request->icon)) {
            $base64_encode = $request->icon;
            $folderPath = "storage/addon/";
            $image_parts = explode(";base64,", $base64_encode);
            $image_type_aux = explode("image/", $image_parts[0]);
            $image_type = $image_type_aux[1];
            $image_base64 = base64_decode($image_parts[1]);
            $icon = "addon" . uniqid() . '.' . $image_type;
            $file = $folderPath . $icon;
            file_put_contents($file, $image_base64);
        }
        $table_identifier = UrlIdentifier::where(['table_unique_identity' => $request->addon_key])->first('table_name');
        $features = '';
        $features = implode(',', $request->features);
        $addon = new Addon();
        $addon['user_id'] = $authuser->id;
        $addon['title'] = strtolower($request->title);
        $addon['status'] = $request->status;
        $addon['usage_status'] = $request->usage_status;
        $addon['addon_key'] = $request->addon_key;
        $addon['table_identifier'] = $table_identifier->table_name;
        $addon['description'] = $request->description;
        $addon['subtitle'] = $request->subtitle;
        $addon['demolink'] = $request->demolink;
        $addon['features'] = $features;
        $addon['category'] = $request->category;
        $addon['icon'] = $icon;
        $addon['image'] = $image;
        $addon->save();
        return redirect()->route('plans.addons')->with('success', __('Addon Created successfully.'));
    }

    public function plansAddonsEdit($id)
    {
        $UrlIdentifier = UrlIdentifier::where(['status' => 'Published'])->get();
        $addon = Addon::find($id);
        $category_arr = AddonCategory::get();
        $addon->features = explode(',', $addon->features);
        return view('plans.addons.edit', compact('addon', 'UrlIdentifier','category_arr'));
    }

    public function plansAddonsUpdate(Request $request)
    {
        $post = $request->all();
        $addons = Addon::find($request->id);
        $image = '';
        $icon = '';
        $features = '';
        $features = implode(',', $request->features);
        if (empty($request->image_delete)) {
            if (!empty($request->image)) {
                $base64_encode = $request->image;
                $folderPath = "storage/addon/";
                $image_parts = explode(";base64,", $base64_encode);
                $image_type_aux = explode("image/", $image_parts[0]);
                $image_type = $image_type_aux[1];
                $image_base64 = base64_decode($image_parts[1]);
                $image = "Addon" . uniqid() . '.' . $image_type;

                $file = $folderPath . $image;
                file_put_contents($file, $image_base64);
            } else {
                $image = $addons->image;
            }
        } else {
            $image = NULL;
        }
        if (empty($request->icon_delete)) {
            if (!empty($request->icon)) {
                $base64_encode = $request->icon;
                $folderPath = "storage/addon/";
                $image_parts = explode(";base64,", $base64_encode);
                $image_type_aux = explode("image/", $image_parts[0]);
                $image_type = $image_type_aux[1];
                $image_base64 = base64_decode($image_parts[1]);
                $icon = "Addon" . uniqid() . '.' . $image_type;
                $file = $folderPath . $icon;
                file_put_contents($file, $image_base64);
            } else {
                $icon = $addons->icon;
            }
        } else {
            $icon = NULL;
        }
        $post['features'] = $features;
        $post['category'] = $request->category;
        $post['image'] = $image;
        $post['icon'] = $icon;
        $post['title'] = strtolower($post['title']);
        $addons->update($post);
        return redirect()->route('plans.addons')->with('success', __('Addon Updated successfully.'));
    }

    public function plansAddonsDestroy($id)
    {
        $addon = Addon::find((int) $id);
        $addon->delete();
        return redirect()->route('plans.addons')->with('success', __('Addon deleted successfully.'));
    }

    public function plansDestroye(Request $request)
    {
        $plan_id = $request->plan_id;
        $plan = Plan::find($plan_id);
        $plan->delete();
        return redirect()->back()->with('success', __('Plans deleted successfully.'));
    }


	   public function ownerindex()
    {
        $user = Auth::user();
        if (\Auth::user()->type == 'owner') {
			 $authuser = Auth::user();
            $plans = UsersPlan::where('user_id' ,  $authuser->id)->get();

            $allow = false;

           if (!empty($authuser->stripe_secret_key) || !empty($authuser->stripe_publishable_key)) {
                $allow = true;
            }

            return view('plans.owner.index', compact('plans', 'allow','user'));
        } else {
            return redirect()->back()->with('error', __('Permission Denied.'));
        }
    }
    /**
     * Show the form for creating a new plan.
     *
     * @return \Illuminate\Http\Response
     */
    public function ownercreate()
    {
        if (\Auth::user()->type == 'owner') {
            // if (!empty($authuser->stripe_secret_key) || !empty($authuser->stripe_publishable_key)) {

                $plan = new UsersPlan();
				$authuser = Auth::user();
                return view('plans.owner.create', compact('plan','authuser'));
            // } else {
                // return redirect()->back()->with('error', __('Please set stripe api key & secret key for add new plan.'));
            // }
        } else {
            return redirect()->back()->with('error', __('Permission Denied.'));
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     *
     * @return \Illuminate\Http\Response
     */
    public function ownerstore(Request $request)
    {
        if (\Auth::user()->type == 'owner') {
			  $authuser = Auth::user();
            $plans = UsersPlan::where('user_id' ,  $authuser->id)->count();


			if($plans <= '2'){

			}else{
			 return redirect()->back()->with('error', __('You have exceeded maximum plan Limit'));
			}
             if (empty($authuser->stripe_secret_key) || empty($authuser->stripe_publishable_key)) {
                return redirect()->back()->with('error', __('Please set stripe api key & secret key for add new plan'));
            } else {
                $validation = [];
                $validation['name'] = 'required|unique:users_plans';
                // $validation['price']        =	 'required|numeric|min:0';
                $validation['duration'] = 'required';


                $validator = \Validator::make($request->all(), $validation);
                if ($validator->fails()) {
                    $messages = $validator->getMessageBag();

                    return redirect()->back()->with('error', $messages->first());
                }
                $post = $request->all();
                if (UsersPlan::create($post)) {
                    return redirect()->back()->with('success', __('Plan created Successfully!'));
                } else {
                    return redirect()->back()->with('error', __('Something is wrong'));
                }
            }


        } else {
            return redirect()->back()->with('error', __('Permission Denied.'));
        }
    }

	 public function owneredit(UsersPlan $plan)
    {

        if (\Auth::user()->type == 'owner') {
            return view('plans.owner.edit', compact('plan'));
        } else {
            return redirect()->back()->with('error', __('Permission Denied.'));
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param \App\Plan $plan
     *
     * @return \Illuminate\Http\Response
     */
    public function ownerupdate(Request $request, UsersPlan $plan)
    {
        if (\Auth::user()->type == 'owner') {
            if ($plan) {
                $validation = [];
                $validation['name'] = 'required|unique:users_plans,name,' . $plan->id;
                // $validation['price']        = 'required|numeric|min:0';
                $validation['duration'] = 'required';


                $validator = \Validator::make($request->all(), $validation);
                if ($validator->fails()) {
                    $messages = $validator->getMessageBag();

                    return redirect()->back()->with('error', $messages->first());
                }

                $post = $request->all();
                if (!isset($request->status)) {
                    $post['status'] = 'false';
                }
                if ($plan->update($post)) {
                    return redirect()->back()->with('success', __('Plan updated Successfully!'));
                } else {
                    return redirect()->back()->with('error', __('Something is wrong'));
                }
            } else {
                return redirect()->back()->with('error', __('Plan not found'));
            }
        } else {
            return redirect()->back()->with('error', __('Permission Denied.'));
        }
    }

	  public function ownerplansDestroye(Request $request)
    {
        $plan_id = $request->plan_id;
        $plan = UsersPlan::find($plan_id);
        $plan->delete();
        return redirect()->back()->with('success', __('Plans deleted successfully.'));
    }
    public function plansAddons_category(Request $request){
        $authuser = Auth::user();
        if ($request->ajax()) {
            $data = AddonCategory::query();
            return Datatables::of($data)
                ->addIndexColumn()
                ->addColumn('action', function ($data) {
                    $authuser = Auth::user();
                    $actionBtn = '<div class="actions text-center">
                                    <a href="' . route('plans.addons.category.edit', ['id' => $data->id]) . '"
                                       class="action-item px-2"
                                       data-toggle="tooltip" data-original-title="Edit">
                                        <i class="fas fa-edit"></i>
                                    </a>

                                    <a href="javascript:void(0)"
                                       class="action-item text-danger px-2 destroyaddon delete_record_model"
                                       data-url="'.route('plans.addons.category.destroy',$data->id).'" data-toggle="tooltip"
                                       data-original-title="Delete">
                                        <i class="fas fa-trash-alt"></i>
                                    </a>
                                </div>';
                    return $actionBtn;
                })
                ->rawColumns(['action', 'title', 'key', 'status', 'usage','features'])
                ->make(true);
        } else {
            if ($authuser->type == 'admin') {
                return view('plans.addons.category.index', compact('authuser'));
            } else {
                return redirect()->back()->with('error', __('Addon Only for Admin Use.'));
            }
        }
    }
    public function plansAddonsCreate_category(){
        return view('plans.addons.category.create');
    }
    public function plansAddonsStore_category(Request $request){
        $data = array();
        $data['name'] = $request->name;
        if (AddonCategory::create($data)) {
            return redirect()->route('plans.addons.category')->with('success', __('Addon Category created Successfully!'));
        } else {
            return redirect()->back()->with('error', __('Something is wrong'));
        }
    }
    public function plansAddonsEdit_category(Request $request){
      $category_arr =   AddonCategory::where('id',$request->id)->first();
      return view('plans.addons.category.edit',compact('category_arr'));
    }
    public function plansAddonsUpdate_category(Request $request){
        $plan = AddonCategory::where(['id' => $request->id])->update(['name' => $request->name]);
        if ($plan) {
            return redirect()->route('plans.addons.category')->with('success', __('Addon Category updated Successfully!'));
        } else {
            return redirect()->back()->with('error', __('Something is wrong'));
        }
    }
    public function plansAddonsdelete_category($id)
    {
        $plan = AddonCategory::find($id);
        $plan->delete();
        return redirect()->back()->with('success', __('Addon Category deleted successfully.'));
    }
}
