<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\SendsPasswordResetEmails;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Lang;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Session;
use Carbon\Carbon;
use App\User;
use App\SiteSettings;
use App\Token;
use Hash;
use DB;

class ForgotPasswordController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Password Reset Controller
    |--------------------------------------------------------------------------
    |
    | This controller is responsible for handling password reset emails and
    | includes a trait which assists in sending these notifications from
    | your application to your users. Feel free to explore this trait.
    |
    */

    use SendsPasswordResetEmails;

    /**
       * Write code on Method
       *
       * @return response()
       */
      public function showLinkRequestForm()
      {
         return view('auth.passwords.email');
      }

      /**
       * Write code on Method
       *
       * @return response()
       */
      public function sendResetLinkEmail(Request $request)
      {
          $request->validate([
              'email' => 'required|email|exists:users',
          ]);

          $token = Str::random(64);

          DB::table('password_resets')->insert([
              'email' => $request->email,
              'token' => $token,
              'created_at' => Carbon::now()
            ]);

        //   Mail::send('email.forgetPassword', ['token' => $token], function($message) use($request){
        //       $message->to($request->email);
        //       $message->subject('Reset Password');
        //   });
        $user = User::where('email',$request->email)->first();
        return view('auth.passwords.sendotp',compact('token','user'));
          //return back()->with('message', 'We have e-mailed your password reset link!');
      }

    /**
       * Write code on Method
       *
       * @return response()
       */
      public function otp(Request $request) {
        Session::flush();
          if($request->type == 'email'){
            $user = User::where('email', $request->email)->first();

            $token = Token::create([
                'user_id' => $user->id
            ]);
            //dd('dsad');
            if ($token->sendCode('email')) {
                session()->put("token_id", $token->id);
                session()->put("user_id", $user->id);
                session()->put("remember", 'no');

                return redirect("enterotp");
            }
            dd('error');
            $token->delete();
            return redirect('/login')->with('error', __('Unable to send verification code"'));
          }else{
            $user = User::where('email', $request->email)->first();

            $token = Token::create([
                'user_id' => $user->id
            ]);
            //dd('dsad');
            if ($token->sendCode()) {
                session()->put("token_id", $token->id);
                session()->put("user_id", $user->id);
                session()->put("remember", 'no');

                return redirect("enterotp");
            }
            $token->delete();
            return redirect('/login')->with('error', __('Unable to send verification code"'));
          }
     }
     public function enterotp()
     {
        if (! session()->has("token_id", "user_id")) {
            return redirect("login");
        }
         return view('auth.passwords.enterotp');
     }

      /**
       * Write code on Method
       *
       * @return response()
       */
      public function reset(Request $request) {

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
            return redirect()->back()->withInput($request->all())->withErrors([
                'otp' => 'Invalid OTP',
            ]);
        }

        $token->used = true;
        $token->save();
        $user = User::find(session()->get("user_id"));
        $Token = DB::table('password_resets')->where('email',$user->email)->latest()->first();
       return redirect()->route('resetPasswordForm',['email'=>$user->email,'token'=>$Token->token]);
        //return redirect("reset_password/".$token.'/'.$email);
    }
    public function resetPasswordForm($email,$token)
    {
        if (! session()->has("token_id", "user_id")) {
            return redirect("login");
        }

        return view('auth.passwords.reset',compact('email','token'));
    }
      /**
       * Write code on Method
       *
       * @return response()
       */
      public function submitResetPasswordForm(Request $request)
      {
          $request->validate([
              'email' => 'required|email|exists:users',
              'password' => 'required|string|min:6|confirmed',
              'password_confirmation' => 'required'
          ]);

          $user = User::where('email', $request->email)
                      ->update(['password' => Hash::make($request->password)]);

          DB::table('password_resets')->where(['email'=> $request->email])->delete();

          return redirect('/login')->with('message', 'Your password has been changed!');
      }
}
