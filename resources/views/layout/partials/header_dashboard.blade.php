<?php error_reporting(0); ?>
<!-- Loader -->
@if(Route::is(['map-grid','map-list']))
<div id="loader">
    <div class="loader">
        <span></span>
        <span></span>
    </div>
</div>
@endif
@php
   
	  $logo =  \App\SiteSettings::logoSetting();
		$logoTxt=\App\SiteSettings::logotext();
        if(!empty($logo)){
           $logo_favicon = json_decode($logo->value,true);
        }else{
            $logo_favicon = array();
        }
@endphp
@php
  $user=Auth::user();
 $permissions=permissions();
@endphp
<!-- /Loader  -->
<!-- Header -->
<header class="header">
    <nav class="navbar navbar-expand-lg header-nav">
        <div class="container-fluid">
            <div class="navbar-header">
                <a id="mobile_btn" href="javascript:void(0);">
                    <span class="bar-icon">
                        <span></span>
                        <span></span>
                        <span></span>
                    </span>
                </a>
                <a href="{{ url('')}}" class="navbar-brand logo">
				@if (!empty($logo_favicon['logo']))
                        <img src="{{ asset('storage/logo').'/'.$logo_favicon['logo'] }}"alt="Logo" class="img-fluid ">
                    @else
                    <h3 style="margin-top:15px !important;">@if(!empty($logoTxt)) {{ $logoTxt }} @else Your Logo Here @endif</h3>
                        <!--<img src="{{ asset('assets/main/images/logo.png')}}" alt="LogoImage" class="img-fluid mainlogo">-->
                    @endif
				
                   
                </a>
            </div>

            <ul class="nav header-navbar-rht">

                <!-- User Menu -->
                @if(!Route::is(['pagee','mentee-register','mentor-register']))
                <li class="nav-item dropdown has-arrow logged-item">
                    <a href="#" class="dropdown-toggle nav-link" data-toggle="dropdown">
                        <span class="user-img">
                            <img class="rounded-circle mr-2" src="{{Auth::user()->getAvatarUrl()}}" width="31" alt="Darren Elder">{{ ucwords(Auth::user()->name) }}
                        </span>
                    </a>
                    <div class="dropdown-menu dropdown-menu-right">
                        <div class="user-header">
                            <div class="avatar avatar-sm">
                                <img src="{{Auth::user()->getAvatarUrl()}}" alt="User Image" class="avatar-img rounded-circle">
                            </div>
                            <div class="user-text">
                                <h6>{{ ucwords(Auth::user()->name) }}</h6>
                                <p class="text-muted mb-0">{{ ucwords(Auth::user()->type) }}</p>
                            </div>
                        </div>
                        <a class="dropdown-item" href="{{route('dashboard')}}">Dashboard</a>
                        <a class="dropdown-item" href="{{route('profile-settings')}}">My Profile</a>
                        <a class="dropdown-item" href="{{route('user.invoices')}}">Billing & Invoices</a>
                        <a class="dropdown-item" href="{{route('site.settings')}}">Site Settings</a>
                        <a class="dropdown-item" href="{{route('wallet')}}">Wallet</a>
                        @if(in_array("manage_sub_domain",$permissions) || $user->type =="admin")  
                        <a class="dropdown-item" href="{{url('/')}}">Visit Site</a>
                        @endif
                        
                        <a class="dropdown-item" href="{{ route('logout') }}"
                                       onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">Logout</a>
                        
                        <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                        @csrf
                                    </form>
                    </div>
                </li>
                <!-- /User Menu -->
                @endif






            </ul>
        </div>
    </nav>
</header>
<!-- /Header -->
<div class="main-wrapper">
