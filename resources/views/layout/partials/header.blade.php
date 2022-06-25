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
<!-- /Loader  -->
@if(!Route::is(['map-grid','map-list']))
<!-- Header Top-->
<div class="header-top">
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-8">
                <div class="left-top">
                    <ul>
                        <li><i class="fas fa-map-marker-alt top-icon"></i> 123, washington street, uk</li>
                        <li><i class="fas fa-phone-volume top-icon"></i> +19 123-456-7890</li>
                        <li><i class="fas fa-envelope top-icon"></i> mail@yourdomain.com</li>
                    </ul>
                </div>
            </div>
            <div class="col-md-4">
                <div class="right-top">
                    <ul>
                        <li>
                            <a href="#"><i class="fab fa-facebook-f top-icons"></i></a>
                        </li>
                        <li>
                            <a href="#"><i class="fab fa-instagram top-icons"></i></a>
                        </li>
                        <li>
                            <a href="#"><i class="fab fa-linkedin-in top-icons"></i></a>
                        </li>
                        <li>
                            <a href="#"><i class="fab fa-twitter top-icons"></i></a>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- /Header Top-->
@endif
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
                <a href="index" class="navbar-brand logo">
                    <img src="{{asset('assets/img/logo.png')}}" class="img-fluid" alt="Logo">
                </a>
            </div>
            <div class="main-menu-wrapper">
                <div class="menu-header">
                    <a href="index" class="menu-logo">
                        <img src="{{asset('assets/img/logo.png')}}" class="img-fluid" alt="Logo">
                    </a>
                    <a id="menu_close" class="menu-close" href="javascript:void(0);">
                        <i class="fas fa-times"></i>
                    </a>
                </div>
                <ul class="main-nav">
                    <li class="{{ (Request::is('index') || Request::is('/') || Request::is('home') )  ? 'active' : '' }}">
                        <a href="{{url('/home')}}">Home</a>
                    </li>
                    <li class="{{ Request::is('search/profiles') ? 'active' : '' }}">
                        <a href="{{route('search.profile')}}">Search Profile</a>
                    </li>
                    <li class="{{ Request::is('search/courses') ? 'active' : '' }}">
                        <a href="{{route('search.courses')}}">Courses</a>
                    </li>
                    <li class="{{ Request::is('search/blogs') ? 'active' : '' }}">
                        <a href="{{route('search.blogs')}}">Blogs</a>
                    </li>
                    <li class="{{ Request::is('search/profiles') ? 'active' : '' }}">
                        <a href="{{route('search.profile')}}">Booking</a>
                    </li>
                </ul>
            </div>
            <ul class="nav header-navbar-rht">
                @guest
                <li class="nav-item">
                    <a class="nav-link header-register" href="{{ route('login') }}">Login</a>
                </li>
                @if (Route::has('register'))
                <li class="nav-item">
                    <a class="nav-link header-login" href="{{ route('register') }}">Register</a>
                </li>
                @endif

                <!-- User Menu -->
                @else
                <li class="nav-item dropdown has-arrow logged-item">
                    <a href="#" class="dropdown-toggle nav-link" data-toggle="dropdown">
                        <span class="user-img">
                            <img class="rounded-circle mr-2" src="{{Auth::user()->getAvatarUrl()}}" width="31" alt="Name">{{ ucwords(Auth::user()->name) }}
                        </span>
                    </a>
                    <div class="dropdown-menu dropdown-menu-right">
                        <div class="user-header">
                            <div class="avatar avatar-sm">
                                <img src="{{Auth::user()->getAvatarUrl()}}" alt="User Image" class="avatar-img rounded-circle">
                            </div>
                            <div class="user-text">
                                <h6>{{ ucwords(Auth::user()->name) }}</h6>
                                <p class="text-muted mb-0">{{ ucwords(Auth::user()->tyle) }}</p>
                            </div>
                        </div>
                        <a class="dropdown-item" href="{{route('dashboard')}}">Dashboard</a>
                        <a class="dropdown-item" href="{{route('profile-settings')}}">Profile Settings</a>
                        <a class="dropdown-item" href="{{route('site.settings')}}">Site Settings</a>

                        <a class="dropdown-item" href="{{ route('logout') }}"
                           onclick="event.preventDefault();
                                   document.getElementById('logout-form').submit();">Logout</a>

                        <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                            @csrf
                        </form>
                    </div>
                </li>
                <!-- /User Menu -->
                @endguest






            </ul>
        </div>
    </nav>
</header>
<!-- /Header -->
<div class="main-wrapper">
