<?php

namespace App\Http\Middleware;

use Closure;
use App\Plan;
use Illuminate\Support\Facades\Auth;

class PlanCheck
{
    public function handle($request, Closure $next,$permission)
    {
        
        $user = \Auth::user();
        if(in_array($user->type, ["admin","mentee"])){
            return $next($request);
        }else{ 
          if($user->type == 'corporate'){
                if(request()->is('corporate*')){
                    return $next($request);
                }
                //return redirect()->route('home')->with('error', __('Permission Denied.'));
            }
            if($user->plan != ''){
            $plan = new Plan();
            $userPlan = $plan->getUserPlan($permission);
			
                if($userPlan['status'] == true){
                    return $next($request);   
                }else{
                    return redirect()->route('home')->with('error', __('Permission Denied. Please upgrade the plan to access'));  
                }
            }else{
                return redirect()->route('home')->with('error', __('Permission Denied. You Do not Have Plan'));
            }
        }
        
    }
}
