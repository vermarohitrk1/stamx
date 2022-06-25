<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Filesystem\Filesystem;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use App\PlansModule;
use App\User;
use App\Addon;

class Plan extends Model
{

    protected $fillable = [
        'name',
        'price',
        'duration',
        'max_users',
        'max_projects',
        'max_minutes',
        'description',
        'weekly_price',
        'monthly_price',
        'annually_price',
        'setup_fee',
        'status'
    ];
    protected $table = 'plans';

    public function arrDuration()
    {
        return [
            'Unlimited' => 'Unlimited',
            'Week' => 'Per Week',
            'Month' => 'Per Month',
            'Year' => 'Per Year',
        ];
    }

    public function getUserPlan($table, $id = null)
    {
        $response = array(
            'status' => false,
            'message' => '',
            'data' => []
        );
        if (!$id) {
            $authuser = Auth::user();
            $id = $authuser->id;
        }
        $userData = User::find($id);
        if ($userData->type == 'admin') {
            $response = array(
                'status' => true,
                'message' => 'access this modules',
                'data' => ''
            );
            return $response;
        }
        $userPlan = $userData->plan;
        if (!empty($userPlan)) {
            $PlansModule = PlansModule::where(['plan_id' => $userPlan])->first();
            if ($PlansModule != '') {
                if (!empty($PlansModule->addon_id)) {
                    $planAddons = explode(",", $PlansModule->addon_id);
                    $addons = new Addon();
                    $addonsUniqueKey = $addons->getAddonsKeys($table);
                    $PlansModule = new Addon();
                    $PlansModuleAddonsKeys = $PlansModule->getPlanAddonsKeysByIds($planAddons);
                    $array = [];
                    foreach ($PlansModuleAddonsKeys as $key => $value) {
                        $array[$key] = $value->addon_key;
                    }
                    if (!empty($addonsUniqueKey)) {
                        if (in_array($addonsUniqueKey['addon_key'], $array)) {
                            $response = array(
                                'status' => true,
                                'message' => 'access this modules',
                                'data' => $planAddons
                            );
                        } else {
                            $response = array(
                                'status' => false,
                                'message' => 'Your plan does not have access for this module.',
                                'data' => $planAddons
                            );
                        }
                    } else {
                        $response = array(
                            'status' => false,
                            'message' => 'Your plan does not have access for this module.',
                            'data' => $planAddons
                        );
                    }
                } else {
                    $response = array(
                        'status' => false,
                        'message' => 'Plan Addons Not Found',
                        'data' => []
                    );
                }
            } else {
                $response = array(
                    'status' => false,
                    'message' => 'Plan Have No Module',
                    'data' => []
                );
            }
        } else {
            $response = array(
                'status' => false,
                'message' => 'User Not Have a Plan',
                'data' => []
            );
        }
//         echo "<pre>";print_r($response);die();
        return $response;
    }

    public function getplan($planId)
    {
        $plan = Self::where(['id' => $planId])->first();
        return $plan;
    }

    public function getPlanAddons()
    {

        $PlansModule = PlansModule::where(['plan_id' => $this->id])->first();
        if (!empty($PlansModule)) {
            $selected = explode(",", $PlansModule->addon_id);
        } else {
            $selected = [];
        }

        return $selected;
    }

    public function savePlanAddons($request)
    {
        $added = PlansModule::where(['plan_id' => $this->id])->first();
        if (!empty($request->addons)) {
            $addedOns = implode(",", $request->addons);
        } else {
            $addedOns = '';
        }

        if (!empty($added->id)) {
            $data = [
                'plan_id' => $this->id,
                'addon_id' => $addedOns
            ];

            $update = $added->update($data);
            return $added;
        } else {
            $data = [
                'plan_id' => $this->id,
                'addon_id' => $addedOns
            ];
            $PlansModule = PlansModule::create($data);
            $return = $PlansModule;
        }
    }

    public function getPlansModules()
    {
        $plansModule = PlansModule::where(['plan_id' => $this->id])->first();
        if (!empty($plansModule)) {
            $plansModuleIds = explode(",", $plansModule->addon_id);
        } else {
            $plansModuleIds = [];
        }
        $addOnData = [];
        if (!empty($plansModuleIds)) {
            $addOnData = Addon::whereIn('id', $plansModuleIds)->get('title')->toArray();
        }
        return $addOnData;
    }

    public function getPlanscount()
    {
        $plansModule = PlansModule::where(['plan_id' => $this->id])->first();
        if (!empty($plansModule)) {
            $plansModuleIds = explode(",", $plansModule->addon_id);
        } else {
            $plansModuleIds = [];
        }
        $addOnData = [];
        if (!empty($plansModuleIds)) {
            $addOnData = Addon::whereIn('id', $plansModuleIds)->count();
        }
        return $addOnData;
    }

    public function getPlansConciergeCount()
    {
        $count = \App\Concierge::where('plan', $this->id)->count();
        return $count;
    }

   

    /**
     * @param string $key
     * @param array $collection
     * @return string
     */
    public function addSelected(string $key, array $collection){
        if(in_array($key, $collection)){
            return "selected";
        }
        return "";
    }
}
