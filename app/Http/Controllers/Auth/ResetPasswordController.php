<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Auth\ResetsPasswords;
use Illuminate\Support\Facades\Password;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use DB;
use App\User;

class ResetPasswordController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Password Reset Controller
    |--------------------------------------------------------------------------
    |
    | This controller is responsible for handling password reset requests
    | and uses a simple trait to include this behavior. You're free to
    | explore this trait and override any methods you wish to tweak.
    |
    */

    //use ResetsPasswords;
    use AuthenticatesUsers;
    /**
     * Where to redirect users after resetting their password.
     *
     * @var string
     */
    protected $redirectTo = RouteServiceProvider::HOME;

    public function reset(Request $request) {

        Session::flush();
     $password = $request->password;
     $token = $request->token;
     $tokenData = DB::table('password_resets')
     ->where('token', $token)->first();

     $user = User::where('email', $tokenData->email)->first();
     if ( !$user ) return redirect()->to('home'); //or wherever you want

     $user->password = Hash::make($password);
     $user->update(); //or $user->save();

     //do we log the user directly or let them login and try their password for the first time ? if yes
     Auth::login($user);

    // If the user shouldn't reuse the token later, delete the token
    DB::table('password_resets')->where('email', $user->email)->delete();
        return redirect($this->redirectTo);

    }



}
