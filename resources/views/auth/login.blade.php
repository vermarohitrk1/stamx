@extends('layout.mainlayout')
@section('content')	
<!-- Page Content -->
@php
    $mainMenu = \App\Menu::get_menus();
     $logo =  \App\SiteSettings::logoSetting();
$logoTxt=\App\SiteSettings::logotext();
        if(!empty($logo)){
           $logo_favicon = json_decode($logo->value,true);
        }else{
            $logo_favicon = array();
        }
      
@endphp

     @if( array_key_exists("registerationbackground",$logo_favicon))
<div class="bg-pattern-style" style="background-image:url({{ asset('storage').'/logo/'.$logo_favicon['registerationbackground'] }})">
     @else
     <div class="bg-pattern-style" style="background-image:url({{ URL::to('/') }}storage/logo/registerationbackground611e53ec81936.png)">

     @endif                     
    <div class="content">

        <!-- Login Tab Content -->
        <div class="account-content">
            <div class="account-box">
                <div class="login-right">
                    <div class="login-header">
                        <h3>Login <span>StemX</span></h3>
                        <p class="text-muted">Access to our dashboard</p>
                    </div>
                    <form method="POST" action="{{ route('login') }}">
                          @csrf
                        <div class="form-group">
                            <label class="form-control-label">Email Address</label>
                             <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email" autofocus>

                                @error('email')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                        </div>
                        <div class="form-group">
                            <label class="form-control-label">Password</label>
                            <div class="pass-group">
                                <input id="password" type="password" class="form-control pass-input @error('password') is-invalid @enderror" name="password" required autocomplete="current-password">
<span class="fas fa-eye toggle-password"></span>
                                @error('password')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
                          @if (Route::has('password.request'))
                        <div class="text-right">
                            <a class="forgot-link" href="{{ route('password.request') }}">Forgot Password ?</a>
                        </div>
                           @endif
                        <button class="btn btn-primary login-btn" type="submit">Login</button>
                        @if (Route::has('register'))
                        <div class="text-center dont-have">Don’t have an account? <a href="{{ route('register') }}">Register</a></div>
                         @endif
                    </form>
                </div>
            </div>
        </div>
        <!-- /Login Tab Content -->

    </div>

</div>		
<!-- /Page Content -->	
@endsection