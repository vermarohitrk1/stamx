<?php

namespace App\Http\Middleware;

use App\Providers\RouteServiceProvider;
use Closure;
use Illuminate\Support\Facades\Auth;

use App\User;

class CheckSubdomain {

    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next, $guard = null) {
         if (app()->environment('local')) {
               	return $next($request);
         	 	}
       
//        return $next($request); //temp 

        $subdomain=null;
        
        $user = \Auth::user();
      
        $user_type=$user->type??'';
       $mainurl = explode('.',$_SERVER['HTTP_HOST']);
		if(count($mainurl)==3){
			$main_url = $mainurl[1];
			$domain = $mainurl[1].'.'.$mainurl[2];
		}else{
			$main_url = $mainurl[0];
			$domain =!empty($mainurl[1]) ? $mainurl[0].'.'.$mainurl[1] :$mainurl[0];
		}
               
		if($domain == env('MAIN_URL')){
	
				$currentURL = \URL::current();
				$currentURL = preg_replace("(^https?://)", "", $currentURL);

				$urlparts = explode('.', $currentURL);
				 if ($user_type=="admin" || in_array('manage_sub_domain', permissions())) {
                    $subdomain = \App\UserDomain::where('user_id', $user->id)->first();
                    $subdomain = $subdomain->custom_url ?? '';
                } else {
                    $subdomain = \App\UserDomain::where('user_id', $user->created_by??'')->first();
                    $subdomain = $subdomain->custom_url ?? '';
                }
				
					
				if ($urlparts[0] != $main_url) {
					$current_subdomain = $urlparts[0];
					unset($urlparts[0]);
					//dd($subdomain);
                                          if (empty($user)) {
                                             
                                         
            $subdomain = \App\UserDomain::where('custom_url', $current_subdomain)->first();
                           $subdomain = $subdomain->custom_url ?? '';   
                           if(empty($subdomain)){
                              return redirect()->away('//' . $domain);
                           }else{
                               
                              	return $next($request); 
                           }
         	 	}
					if ($subdomain == null || $subdomain == '') {
						$newurl = implode(".", $urlparts);
						return redirect()->away('//' . $newurl);
					} elseif ($subdomain != $current_subdomain) {
						array_unshift($urlparts, $subdomain);
						$newurl = implode(".", $urlparts);
						$checkUrl = explode('/', $newurl)[0];
		
						if (strtolower($checkUrl) != $_SERVER['HTTP_HOST']) {
							return redirect()->away('//' . $newurl);
						}
					}
				} else if ($subdomain != null) {
					return redirect()->away('//' . $subdomain . '.' . $currentURL);
				}
		}else{

			if (!empty($user) && !in_array('manage_sub_domain', permissions())) {
				$userContact =\App\UserDomain::where('user_id', $user->created_by??'')->first();
                             
				if(!empty($userContact)){

					$userParent = $userContact;
                                       
					if(!empty($userParent)){
							if($userParent->domain == $domain){
								return $next($request);
							}else{
								\Auth::logout();
								return redirect('auth/login')->with('error', 'Account not found');
							}
					}else{
					\Auth::logout();
					  return redirect('auth/login')->with('error', 'Account not found');
					}
				}
					 \Auth::logout();
					  return redirect('auth/login')->with('error', 'Account not found');


			}else{
                                $query=\App\UserDomain::where('domain', $domain);
								if(!empty($user)){
									$query->where('user_id', $user->id);
								}
								$domin_data = $query->first();

				if(!empty($domin_data)){

					return $next($request);
				}else{
					$getdomain_id = \App\UserDomain::where('domain', request()->getHost());
					if(!empty($user->id)){
						$getdomain_id->where('user_id', $user->id);					
					}
					$domin_data = $getdomain_id->first();


					if(!empty($domin_data)){
						return $next($request);
						// $currentURL = \URL::current();
						// $currentURL = preg_replace("(^https?://)", "", $currentURL);

						// $urlparts = explode('.', $currentURL);
						// $subdomain = \Auth::user()->custom_url;
						// return redirect()->away('//' . $subdomain . '.' . $currentURL);
					}else{
											\Auth::logout();
						return redirect('auth/login')->with('error', 'Account not found');
					}
					
				}

			}


		}

        //dd($subdomain);
        return $next($request);
    }

}
