<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Lang;
use App\User;
use App\SiteSettings;
use App\Token;
use Hash;
use DB;
use Carbon\Carbon;
class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = RouteServiceProvider::HOME;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }

    public function login(Request $request)
    {

        $this->validateLogin($request);
        if ($user =  Auth::guard()->getProvider()->retrieveByCredentials($request->only('email', 'password'))) {
       if($user->is_active == '1'){

                $twoFa = SiteSettings::select('value')->where('user_id', $user->id)->where('name','twoFa')->first();


                if(!isset($twoFa->value) || $twoFa == null || (int) $twoFa->value != 1){

                        $request->validate([
                            'email' => 'required|string|email',
                            'password' => 'required|string',
                        ]);

                        $credentials = $request->only('email', 'password');

                        if (Auth::attempt($credentials)) {
                            $user = Auth::user();
							if($user->login_status=='0'){
							$user->login_status='1';
							$user->save();
							}
                            $rolescheck = \App\Role::whereRole($user->type)->first();
                            if(!empty($rolescheck)){
                                if((checkPlanModule('points') && $rolescheck->role == 'mentor') || $rolescheck->role == 'mentee' ){
                                    $checkPoint = \Ansezz\Gamify\Point::find(1);
                                    if(isset($checkPoint) && $checkPoint != null ){

                                        $checkWithCurrentDate = DB::table('pointables')->where('pointable_id', $user->id)->where('point_id', $checkPoint->id)->whereRaw('Date(created_at) = CURDATE()')->get();
                                        if($checkWithCurrentDate->isEmpty() == true){
                                            if($checkPoint->allow_duplicate == 0){
                                                $createPoint = $user->achievePoint($checkPoint);
                                            }else{
                                                $addPoint = DB::table('pointables')->where('pointable_id', $user->id)->where('point_id', $checkPoint->id)->get();
                                                if($addPoint == null){
                                                    $createPoint = $user->achievePoint($checkPoint);
                                                }
                                            }
                                        }

                                    }
                                }
                            }



                            return redirect()->intended('home');
                        }
                }else{
                    $u = User::where('email', $request->email)->first();
                    if (!\Hash::check($request->password, $u->password))
                    {
                        return redirect()->back()->withInput($request->all())->withErrors([
                            'email' => 'These credentials do not match our records.',
                        ]);
                    }
                    $token = Token::create([
                        'user_id' => $user->id
                    ]);
                    if ($token->sendCode()) {
                        session()->put("token_id", $token->id);
                        session()->put("user_id", $user->id);
                        session()->put("remember", $request->get('remember'));

                        return redirect("auth_code");
                    }

                    $token->delete();// delete token because it can't be sent
                    // dd('Unable to send verification code');
                    return redirect('/login')->with('error', __('Unable to send verification code"'));

               }
	   }
        }
        return redirect()->back()
        ->withErrors([
            $this->username() => Lang::get('auth.failed')
        ]);
    }
    public function showCodeForm()
    {
        if (! session()->has("token_id")) {
            return redirect("login");
        }

        return view("auth.two_fac_auth");
    }

    /**
     * Store and verify user second factor.
     */
    public function storeCodeForm(Request $request)
    {
        // throttle for too many attempts
        if (! session()->has("token_id", "user_id")) {
            return redirect("login");
        }

        $token = Token::find(session()->get("token_id"));

        if (! $token ||
            ! $token->isValid() ||
            (int)$request->code !== (int)$token->code ||
            (int)session()->get("user_id") !== $token->user->id
        ) {
            return redirect("auth_code")->with('error', __('Invalid token'));
        }

        $token->used = true;
        $token->save();
        $this->guard()->login($token->user, session()->get('remember', false));
        $user = User::find($token->user->id);

        $rolescheck = \App\Role::whereRole($user->type)->first();
        if((checkPlanModule('points') && $rolescheck->role == 'mentor') || $rolescheck->role == 'mentee' ){
            $checkPoint = \Ansezz\Gamify\Point::find(1);
            if(isset($checkPoint) && $checkPoint != null ){

                $checkWithCurrentDate = DB::table('pointables')->where('pointable_id', $user->id)->where('point_id', $checkPoint->id)->whereRaw('Date(created_at) = CURDATE()')->get();
                if($checkWithCurrentDate->isEmpty() == true){
                    if($checkPoint->allow_duplicate == 0){
                        $createPoint = $user->achievePoint($checkPoint);
                    }else{
                        $addPoint = DB::table('pointables')->where('pointable_id', $user->id)->where('point_id', $checkPoint->id)->get();
                        if($addPoint == null){
                            $createPoint = $user->achievePoint($checkPoint);
                        }
                    }
                }

            }
        }
        session()->forget('token_id', 'user_id', 'remember');
        return redirect('home');
    }
	
	public function logout(){
		$user = Auth::user();
		if(!empty($user->login_status)){
			if($user->login_status=='1'){
			$user->login_status='0';
			$user->save();
			}
			
		}
			
		\Auth::logout();
	return redirect('/');
		
	}
}
