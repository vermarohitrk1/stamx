@extends('layout.frontend.home6.mainlayout')
@section('content')
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
        <!-- Start Preloader Area -->
        <div class="preloader">
            <div class="loader">
                <div class="shadow"></div>
                <div class="box"></div>
            </div>
        </div>
        <!-- End Preloader Area -->

        <!-- Start Navbar Area -->
        <div class="navbar-area">
            <div class="main-responsive-nav">
                <div class="container">
                    <div class="main-responsive-menu">
                        <div class="logo">
                            <a href="/">
                                @if (!empty($logo_favicon['logo']))
                                    <img src="{{ asset('storage/logo').'/'.$logo_favicon['logo'] }}"alt="LogoImage" >
                                @else
                                    <span class="logo-text">@if(!empty($logoTxt)) {{ $logoTxt }} @else Your Logo Here @endif</span>
                                @endif
                            </a>
                        </div>
                    </div>
                </div>
            </div>

            <div class="main-navbar">
                <div class="container">
                    <nav class="navbar navbar-expand-md navbar-light">
                        <a class="navbar-brand" href="/">
                            @if (!empty($logo_favicon['logo']))
                                <img src="{{ asset('storage/logo').'/'.$logo_favicon['logo'] }}"alt="LogoImage" >
                            @else
                                <span class="logo-text">@if(!empty($logoTxt)) {{ $logoTxt }} @else Your Logo Here @endif</span>
                            @endif
                        </a>

                        <div class="collapse navbar-collapse mean-menu" id="navbarSupportedContent">
                            <ul class="navbar-nav m-auto">
                                @if (count($mainMenu))
                                    @foreach($mainMenu as $menu)
                                        <li class="nav-item dropdown">
                                            <a class="nav-link {{ count($menu->childs) ? 'dropdown-toggle' :'' }}" href="{{$menu->url}}"  @if(!empty(count($menu->childs)))  id="navbarDropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" @endif>
                                            {{ $menu->title }}
                                            </a>
                                            @if(count($menu->childs))
                                                <ul class="dropdown-menu" aria-labelledby="navbarDropdownMenuLink">
                                                    @include('layout.stemx.submenu',['childs' => $menu->childs])

                                                </ul>
                                            @endif
                                        </li>
                                    @endforeach
                                @endif
                            </ul>

                            <div class="others-options d-flex align-items-center">


                                <div class="option-item">
                                    @guest

                                    @if ($donation = \App\PublicPageDetail::where('user_id',get_domain_user()->id)->first())
                                        @php $dId = base64_encode($donation->id);
                                        $user_setting = DB::table('website_setting')->where('user_domain_id', get_domain_id())->where('name', 'payment_settings')->first();
                                    @endphp
                                           @if($user_setting != null)
                                           <a href='{{ url("$dId/donation")}}'  class="default-btn"><i class='bx bx-arrow-to-right'></i>Donate<span></span></a>
                                             @endif
                                    @endif
                                       <a    class="default-btn" href="{{ route('login') }}"><i class='bx bx-arrow-to-right'></i>log In<span></span></a>



                                   @else
                                   <a href="{{ route('home') }}" class="default-btn"><i class='bx bx-arrow-to-right'></i>Dashboard<span></span></a>


                            @endguest
                                </div>
                            </div>
                        </div>
                    </nav>
                </div>
            </div>

            <div class="others-option-for-responsive">
                <div class="container">
                    <div class="dot-menu">
                        <div class="inner">
                            <div class="circle circle-one"></div>
                            <div class="circle circle-two"></div>
                            <div class="circle circle-three"></div>
                        </div>
                    </div>

                    <div class="container">
                        <div class="option-inner">
                            <div class="others-options d-flex align-items-center">


                                <div class="option-item">
                                    @guest

                                    @if ($donation = \App\PublicPageDetail::where('user_id',get_domain_user()->id)->first())
                                        @php $dId = base64_encode($donation->id);
                                        $user_setting = DB::table('website_setting')->where('user_domain_id', get_domain_id())->where('name', 'payment_settings')->first();
                                    @endphp
                                           @if($user_setting != null)
                                           <a href='{{ url("$dId/donation")}}'  class="default-btn"><i class='bx bx-arrow-to-right'></i>Donate<span></span></a>
                                             @endif
                                    @endif
                                       <a    class="default-btn" href="{{ route('login') }}"><i class='bx bx-arrow-to-right'></i>log In<span></span></a>



                                   @else
                                   <a href="{{ route('home') }}" class="default-btn"><i class='bx bx-arrow-to-right'></i>Dashboard<span></span></a>


                            @endguest
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- End Navbar Area -->

        <!-- Start Main Banner Area -->
        <div class="main-banner-area-box">
            <div class="container">
                <div class="row align-items-center">
                    <div class="col-lg-6 col-md-12">
                        <div class="main-banner-content-box">
                            <p class="sub-title wow fadeInUp" data-wow-delay="300ms" data-wow-duration="2000ms">Our Upcoming Events:</p>
                            <h1 class="wow fadeInUp" data-wow-delay="100ms" data-wow-duration="1000ms">World Biggest Conference 2021</h1>

                            <div class="banner-soon-content wow fadeInUp" data-wow-delay="300ms" data-wow-duration="2000ms">
                                <div id="timer">
                                    <div id="days"></div>
                                    <div id="hours"></div>
                                    <div id="minutes"></div>
                                    <div id="seconds"></div>
                                </div>
                            </div>

                            <ul class="banner-list wow fadeInUp" data-wow-delay="300ms" data-wow-duration="2000ms">
                                <li><i class='bx bx-calendar'></i> 08/02/2021</li>
                                <li><i class='bx bxs-map'></i> 248 Mercer St, New York, NY 10012</li>
                            </ul>

                            <ul class="banner-btn-list wow fadeInUp" data-wow-delay="300ms" data-wow-duration="2000ms">
                                <li><a href="register.html" class="default-btn"><i class='bx bx-arrow-to-right'></i> Register Now<span></span></a></li>

                                <li class="calender-btn"><i class='bx bxs-plus-circle'></i> <a href="contact.html">Add a Calender</a></li>
                            </ul>
                        </div>
                    </div>

                    <div class="col-lg-6 col-md-12">
                        <div class="main-banner-image-wrap wow fadeInUp" data-wow-delay="300ms" data-wow-duration="2000ms">
                            <img src="{{ asset('assets/home6/images/main-banner/banner-2.jpg')}}" alt="image">
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- End Main Banner Area -->

        <!-- Start About Us Area -->
        <div class="about-us-area ptb-100">
            <div class="container">
                <div class="row align-items-center">
                    <div class="col-lg-6 col-md-12">
                        <div class="about-us-image">
                            <div class="row">
                                <div class="col-lg-5 col-md-6">
                                    <div class="image-one">
                                        <img src="{{ asset('assets/home6/images/about/about-1.jpg')}}" alt="image">
                                    </div>

                                    <div class="about-text-wrap">
                                        <i class="flaticon-diversity"></i>
                                        <h4>Diversity and Inclusive</h4>
                                        <span>6 Upcoming Events</span>
                                    </div>
                                </div>

                                <div class="col-lg-7 col-md-6">
                                    <div class="image-two">
                                        <img src="{{ asset('assets/home6/images/about/about-2.jpg')}}" alt="image">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-lg-6 col-md-12">
                        <div class="about-us-content">
                            <span>Leadership Conference and Events</span>
                            <h3>Exceptional Web Solution For An Online Business Model</h3>
                            <p>Proin gravida nibh vel velit auctor aliquet aenean sollicitudin lorem quis bibendum auctor nisi elit consequat ipsum nec sagittis sem nibh id elit duis sed odio sit amet nibh proin gravida nibh vel velit auctor aliquet aenean sollicitudin.</p>

                            <ul class="list">
                                <li><i class='bx bx-check'></i> Best Conference Consumer Behavior</li>
                                <li><i class='bx bx-check'></i> Brand Marketing SEO Specilist</li>
                                <li><i class='bx bx-check'></i> Content Marketing and Video Marketing Events</li>
                                <li><i class='bx bx-check'></i> Get Started With Leadership Conference</li>
                            </ul>

                            <div class="about-btn">
                                <a href="about.html" class="default-btn"><i class='bx bx-chevron-right'></i> About Us <span></span></a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- End About Us Area -->

        <!-- Start Experience Area -->
        <div class="experience-area-with-image pt-100 pb-100">
            <div class="container">
                <div class="row align-items-center">
                    <div class="col-lg-6 col-md-12">
                        <div class="fun-fact-inner-box">
                            <div class="row">
                                <div class="col-lg-6 col-sm-6">
                                    <div class="fun-fact-box">
                                        <div class="icon">
                                            <i class="flaticon-drink"></i>
                                        </div>
                                        <h3>
                                            <span class="odometer" data-count="45">00</span>
                                        </h3>
                                        <p>Cup of Coffe</p>
                                    </div>
                                </div>

                                <div class="col-lg-6 col-sm-6">
                                    <div class="fun-fact-box">
                                        <div class="icon">
                                            <i class="flaticon-medal"></i>
                                        </div>
                                        <h3>
                                            <span class="odometer" data-count="530">00</span>
                                        </h3>
                                        <p>Awards Win</p>
                                    </div>
                                </div>

                                <div class="col-lg-6 col-sm-6">
                                    <div class="fun-fact-box bottom-0">
                                        <div class="icon">
                                            <i class="flaticon-layers"></i>
                                        </div>
                                        <h3>
                                            <span class="odometer" data-count="1230">00</span>
                                        </h3>
                                        <p>Total Participants</p>
                                    </div>
                                </div>

                                <div class="col-lg-6 col-sm-6">
                                    <div class="fun-fact-box bottom-0">
                                        <div class="icon">
                                            <i class="flaticon-customer"></i>
                                        </div>
                                        <h3>
                                            <span class="odometer" data-count="680">00</span>
                                        </h3>
                                        <p>Our Speakers</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-lg-6 col-md-12">
                        <div class="experience-content">
                            <span>Our Experience</span>
                            <h3>Start your Journey with Us! Know a Bit</h3>
                            <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip.</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- End Experience Area -->

        <!-- Start Events Schedules Area -->
        <div class="events-schedules-area ptb-100">
            <div class="container">
                <div class="section-title">
                    <span>Monthly Event Schedules</span>
                    <h2>Professional Business Conference 2021</h2>
                    <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua ut enim ad minim veniam quis nostrud exercitation ullamco.</p>
                </div>

                <div class="events-schedules-table">
                    <div class="row align-items-center">
                        <div class="col-lg-2">
                            <div class="number">01</div>
                        </div>

                        <div class="col-lg-2">
                            <div class="time-content">
                                <p><i class='bx bx-calendar'></i> 28/04/2021</p>
                                <span>09.30am–11.30am</span>
                            </div>
                        </div>

                        <div class="col-lg-4">
                            <div class="content-title">
                                <h3><a href="events-details.html">Social Return On Investment (SROI) Conference</a></h3>
                            </div>
                        </div>

                        <div class="col-lg-2">
                            <div class="content-info">
                                <img src="{{ asset('assets/home6/images/events-schedules/image-1.jpg')}}" alt="image">
                                <h4>Gabrielle Winn</h4>
                                <p>Art critic</p>
                            </div>
                        </div>

                        <div class="col-lg-2">
                            <div class="content-btn">
                                <a href="contact.html" class="default-btn"><i class='bx bx-arrow-to-right'></i> Book Now<span></span></a>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="events-schedules-table">
                    <div class="row align-items-center">
                        <div class="col-lg-2">
                            <div class="number">02</div>
                        </div>

                        <div class="col-lg-2">
                            <div class="time-content">
                                <p><i class='bx bx-calendar'></i> 28/04/2021</p>
                                <span>09.30am–11.30am</span>
                            </div>
                        </div>

                        <div class="col-lg-4">
                            <div class="content-title">
                                <h3><a href="events-details.html">Wellbeing Self-Isolation Daily Drop In Event 2021</a></h3>
                            </div>
                        </div>

                        <div class="col-lg-2">
                            <div class="content-info">
                                <img src="{{ asset('assets/home6/images/events-schedules/image-2.jpg')}}" alt="image">
                                <h4>Milana Myles</h4>
                                <p>Art critic</p>
                            </div>
                        </div>

                        <div class="col-lg-2">
                            <div class="content-btn">
                                <a href="contact.html" class="default-btn"><i class='bx bx-arrow-to-right'></i> Book Now<span></span></a>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="events-schedules-table">
                    <div class="row align-items-center">
                        <div class="col-lg-2">
                            <div class="number">03</div>
                        </div>

                        <div class="col-lg-2">
                            <div class="time-content">
                                <p><i class='bx bx-calendar'></i> 28/04/2021</p>
                                <span>09.30am–11.30am</span>
                            </div>
                        </div>

                        <div class="col-lg-4">
                            <div class="content-title">
                                <h3><a href="events-details.html">The Marine And Aquatic Civil Servants</a></h3>
                            </div>
                        </div>

                        <div class="col-lg-2">
                            <div class="content-info">
                                <img src="{{ asset('assets/home6/images/events-schedules/image-3.jpg')}}" alt="image">
                                <h4>Wells Jonson</h4>
                                <p>Art critic</p>
                            </div>
                        </div>

                        <div class="col-lg-2">
                            <div class="content-btn">
                                <a href="contact.html" class="default-btn"><i class='bx bx-arrow-to-right'></i> Book Now<span></span></a>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="events-schedules-table">
                    <div class="row align-items-center">
                        <div class="col-lg-2">
                            <div class="number">04</div>
                        </div>

                        <div class="col-lg-2">
                            <div class="time-content">
                                <p><i class='bx bx-calendar'></i> 28/04/2021</p>
                                <span>09.30am–11.30am</span>
                            </div>
                        </div>

                        <div class="col-lg-4">
                            <div class="content-title">
                                <h3><a href="events-details.html">The Digital Prespective To Ensure Communication</a></h3>
                            </div>
                        </div>

                        <div class="col-lg-2">
                            <div class="content-info">
                                <img src="{{ asset('assets/home6/images/events-schedules/image-4.jpg')}}" alt="image">
                                <h4>Milana Thomson</h4>
                                <p>Art critic</p>
                            </div>
                        </div>

                        <div class="col-lg-2">
                            <div class="content-btn">
                                <a href="contact.html" class="default-btn"><i class='bx bx-arrow-to-right'></i> Book Now<span></span></a>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="events-schedules-table">
                    <div class="row align-items-center">
                        <div class="col-lg-2">
                            <div class="number">05</div>
                        </div>

                        <div class="col-lg-2">
                            <div class="time-content">
                                <p><i class='bx bx-calendar'></i> 28/04/2021</p>
                                <span>09.30am–11.30am</span>
                            </div>
                        </div>

                        <div class="col-lg-4">
                            <div class="content-title">
                                <h3><a href="events-details.html">Residence Life Open Door Open Event of  2021</a></h3>
                            </div>
                        </div>

                        <div class="col-lg-2">
                            <div class="content-info">
                                <img src="{{ asset('assets/home6/images/events-schedules/image-5.jpg')}}" alt="image">
                                <h4>Yamilet Booker</h4>
                                <p>Art critic</p>
                            </div>
                        </div>

                        <div class="col-lg-2">
                            <div class="content-btn">
                                <a href="contact.html" class="default-btn"><i class='bx bx-arrow-to-right'></i> Book Now<span></span></a>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="view-all-btn">
                    <a href="events.html" class="default-btn"><i class='bx bx-chevron-right'></i> View All Events<span></span></a>
                </div>
            </div>
        </div>
        <!-- End Events Schedules Area -->

        <!-- Start Expect Area -->
        <div class="expect-area-with-color ptb-100">
            <div class="container">
                <div class="section-title">
                    <span>Pre Register for 2021 Events</span>
                    <h2>What To Expect</h2>
                    <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua ut enim ad minim veniam quis nostrud exercitation ullamco.</p>
                </div>

                <div class="expect-slides owl-carousel owl-theme">
                    <div class="expect-item">
                        <div class="icon">
                            <i class="flaticon-leadership"></i>
                        </div>
                        <h3>
                            <a href="speakers-details.html">Culture Leadership</a>
                        </h3>
                        <p>5 Upcoming Events</p>
                    </div>

                    <div class="expect-item">
                        <div class="icon">
                            <i class="flaticon-advertising"></i>
                        </div>
                        <h3>
                            <a href="speakers-details.html">Content & Brand Marketing</a>
                        </h3>
                        <p>14 Upcoming Events</p>
                    </div>

                    <div class="expect-item">
                        <div class="icon">
                            <i class="flaticon-branding"></i>
                        </div>
                        <h3>
                            <a href="speakers-details.html">Consumer Behavior</a>
                        </h3>
                        <p>14 Upcoming Events</p>
                    </div>

                    <div class="expect-item">
                        <div class="icon">
                            <i class="flaticon-diversity"></i>
                        </div>
                        <h3>
                            <a href="speakers-details.html">Diversity and Inclusive</a>
                        </h3>
                        <p>2 Upcoming Events</p>
                    </div>

                    <div class="expect-item">
                        <div class="icon">
                            <i class="flaticon-boost"></i>
                        </div>
                        <h3>
                            <a href="speakers-details.html">Digital Marketing</a>
                        </h3>
                        <p>10 Upcoming Events</p>
                    </div>

                    <div class="expect-item">
                        <div class="icon">
                            <i class="flaticon-leadership"></i>
                        </div>
                        <h3>
                            <a href="speakers-details.html">Culture Leadership</a>
                        </h3>
                        <p>5 Upcoming Events</p>
                    </div>

                    <div class="expect-item">
                        <div class="icon">
                            <i class="flaticon-advertising"></i>
                        </div>
                        <h3>
                            <a href="speakers-details.html">Content & Brand Marketing</a>
                        </h3>
                        <p>14 Upcoming Events</p>
                    </div>

                    <div class="expect-item">
                        <div class="icon">
                            <i class="flaticon-branding"></i>
                        </div>
                        <h3>
                            <a href="speakers-details.html">Consumer Behavior</a>
                        </h3>
                        <p>14 Upcoming Events</p>
                    </div>

                    <div class="expect-item">
                        <div class="icon">
                            <i class="flaticon-diversity"></i>
                        </div>
                        <h3>
                            <a href="speakers-details.html">Diversity and Inclusive</a>
                        </h3>
                        <p>2 Upcoming Events</p>
                    </div>

                    <div class="expect-item">
                        <div class="icon">
                            <i class="flaticon-boost"></i>
                        </div>
                        <h3>
                            <a href="speakers-details.html">Digital Marketing</a>
                        </h3>
                        <p>10 Upcoming Events</p>
                    </div>
                </div>
            </div>
        </div>
        <!-- End Expect Area -->

        <!-- Start Speakers Area -->
        <div class="speakers-area pb-100">
            <div class="container">
                <div class="section-title">
                    <span>Our Speakers</span>
                    <h2>Experience Speaker with Knowledge</h2>
                    <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua ut enim ad minim veniam quis nostrud exercitation ullamco.</p>
                </div>

                <div class="row justify-content-center">
                    <div class="col-lg-4 col-md-6">
                        <div class="single-speakers-box">
                            <div class="speakers-image">
                                <a href="speakers-details.html"><img src="{{ asset('assets/home6/images/speakers/speakers-1.jpg')}}" alt="image"></a>
                            </div>

                            <div class="speakers-content">
                                <div class="top-content">
                                    <h3>
                                        <a href="speakers-details.html">Fredric Martinsson</a>
                                    </h3>
                                    <b>Founder, Edilta</b>
                                    <p>Call: <a href="tel:0123456789">+0 123 456 789</a></p>

                                    <div class="message-icon">
                                        <a href="contact.html"><i class='bx bxs-envelope'></i></a>
                                    </div>
                                </div>

                                <ul class="list">
                                    <li><i class="flaticon-settings"></i> Skills <span>Leadership</span></li>
                                    <li><i class="flaticon-bar-chart"></i> Level</li>

                                    <li class="rating">
                                        <i class='bx bxs-star'></i>
                                        <i class='bx bxs-star'></i>
                                        <i class='bx bxs-star'></i>
                                        <i class='bx bxs-star'></i>
                                        <i class='bx bxs-star'></i>
                                    </li>
                                </ul>

                                <div class="bottom-content">
                                    <ul class="social">
                                        <li>
                                            <a href="https://www.facebook.com/" target="_blank">
                                                <i class='bx bxl-facebook'></i>
                                            </a>
                                        </li>
                                        <li>
                                            <a href="https://twitter.com/?lang=en" target="_blank">
                                                <i class='bx bxl-twitter'></i>
                                            </a>
                                        </li>
                                        <li>
                                            <a href="https://www.pinterest.com/" target="_blank">
                                                <i class='bx bxl-pinterest-alt'></i>
                                            </a>
                                        </li>
                                    </ul>

                                    <div class="view-btn">
                                        <a href="speakers-details.html" class="view-btn-one">View</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-lg-4 col-md-6">
                        <div class="single-speakers-box">
                            <div class="speakers-image">
                                <a href="speakers-details.html"><img src="{{ asset('assets/home6/images/speakers/speakers-2.jpg')}}" alt="image"></a>
                            </div>

                            <div class="speakers-content">
                                <div class="top-content">
                                    <h3>
                                        <a href="speakers-details.html">Agaton Johnsson</a>
                                    </h3>
                                    <b>Developer Expert</b>
                                    <p>Call: <a href="tel:0123456789">+0 123 456 789</a></p>

                                    <div class="message-icon">
                                        <a href="contact.html"><i class='bx bxs-envelope'></i></a>
                                    </div>
                                </div>

                                <ul class="list">
                                    <li><i class="flaticon-settings"></i> Skills <span>Leadership</span></li>
                                    <li><i class="flaticon-bar-chart"></i> Level</li>

                                    <li class="rating">
                                        <i class='bx bxs-star'></i>
                                        <i class='bx bxs-star'></i>
                                        <i class='bx bxs-star'></i>
                                        <i class='bx bxs-star'></i>
                                        <i class='bx bxs-star'></i>
                                    </li>
                                </ul>

                                <div class="bottom-content">
                                    <ul class="social">
                                        <li>
                                            <a href="https://www.facebook.com/" target="_blank">
                                                <i class='bx bxl-facebook'></i>
                                            </a>
                                        </li>
                                        <li>
                                            <a href="https://twitter.com/?lang=en" target="_blank">
                                                <i class='bx bxl-twitter'></i>
                                            </a>
                                        </li>
                                        <li>
                                            <a href="https://www.pinterest.com/" target="_blank">
                                                <i class='bx bxl-pinterest-alt'></i>
                                            </a>
                                        </li>
                                    </ul>

                                    <div class="view-btn">
                                        <a href="speakers-details.html" class="view-btn-one">View</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-lg-4 col-md-6">
                        <div class="single-speakers-box">
                            <div class="speakers-image">
                                <a href="speakers-details.html"><img src="{{ asset('assets/home6/images/speakers/speakers-3.jpg')}}" alt="image"></a>
                            </div>

                            <div class="speakers-content">
                                <div class="top-content">
                                    <h3>
                                        <a href="speakers-details.html">Melisa Lundryn</a>
                                    </h3>
                                    <b>Founder, Cards</b>
                                    <p>Call: <a href="tel:0123456789">+0 123 456 789</a></p>

                                    <div class="message-icon">
                                        <a href="contact.html"><i class='bx bxs-envelope'></i></a>
                                    </div>
                                </div>

                                <ul class="list">
                                    <li><i class="flaticon-settings"></i> Skills <span>Leadership</span></li>
                                    <li><i class="flaticon-bar-chart"></i> Level</li>

                                    <li class="rating">
                                        <i class='bx bxs-star'></i>
                                        <i class='bx bxs-star'></i>
                                        <i class='bx bxs-star'></i>
                                        <i class='bx bxs-star'></i>
                                        <i class='bx bxs-star'></i>
                                    </li>
                                </ul>

                                <div class="bottom-content">
                                    <ul class="social">
                                        <li>
                                            <a href="https://www.facebook.com/" target="_blank">
                                                <i class='bx bxl-facebook'></i>
                                            </a>
                                        </li>
                                        <li>
                                            <a href="https://twitter.com/?lang=en" target="_blank">
                                                <i class='bx bxl-twitter'></i>
                                            </a>
                                        </li>
                                        <li>
                                            <a href="https://www.pinterest.com/" target="_blank">
                                                <i class='bx bxl-pinterest-alt'></i>
                                            </a>
                                        </li>
                                    </ul>

                                    <div class="view-btn">
                                        <a href="speakers-details.html" class="view-btn-one">View</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="view-all-btn">
                    <a href="speakers.html" class="default-btn"><i class='bx bx-chevron-right'></i> View All Speakers<span></span></a>
                </div>
            </div>
        </div>
        <!-- End Speakers Area -->

        <!-- Start Testimonial Area -->
        <div class="testimonial-area-with-image ptb-100">
            <div class="container">
                <div class="section-title">
                    <span>Testimonials</span>
                    <h2>Why Our Customer Love Plonk</h2>
                    <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua ut enim ad minim veniam quis nostrud exercitation ullamco.</p>
                </div>

                <div class="testimonial-slides-two owl-carousel owl-theme">
                    <div class="testimonial-item-box">
                        <div class="info-box">
                            <img src="{{ asset('assets/home6/images/testimonial/image-1.jpg')}}" alt="image">
                            <h3>Thomas Albart</h3>
                            <span>CEO & Founder</span>
                        </div>

                        <p>“Proin gravida nibh vel velit aucrtor aliquet aenean sollicitudin lorem quis bib ndum auctor nisi elit consequat ipsum nec proin gravida nibh vel velit lrem auctor aliquet”</p>

                        <ul class="rating-list">
                            <li><i class='bx bxs-star'></i></li>
                            <li><i class='bx bxs-star'></i></li>
                            <li><i class='bx bxs-star'></i></li>
                            <li><i class='bx bxs-star'></i></li>
                            <li><i class='bx bxs-star'></i></li>
                        </ul>

                        <div class="icon">
                            <i class="flaticon-left-quote"></i>
                        </div>
                    </div>

                    <div class="testimonial-item-box">
                        <div class="info-box">
                            <img src="{{ asset('assets/home6/images/testimonial/image-2.jpg')}}" alt="image">
                            <h3>Agaton Johnsson</h3>
                            <span>Developer Expert</span>
                        </div>

                        <p>“Proin gravida nibh vel velit aucrtor aliquet aenean sollicitudin lorem quis bib ndum auctor nisi elit consequat ipsum nec proin gravida nibh vel velit lrem auctor aliquet”</p>

                        <ul class="rating-list">
                            <li><i class='bx bxs-star'></i></li>
                            <li><i class='bx bxs-star'></i></li>
                            <li><i class='bx bxs-star'></i></li>
                            <li><i class='bx bxs-star'></i></li>
                            <li><i class='bx bxs-star'></i></li>
                        </ul>

                        <div class="icon">
                            <i class="flaticon-left-quote"></i>
                        </div>
                    </div>

                    <div class="testimonial-item-box">
                        <div class="info-box">
                            <img src="{{ asset('assets/home6/images/testimonial/image-1.jpg')}}" alt="image">
                            <h3>Thomas Albart</h3>
                            <span>CEO & Founder</span>
                        </div>

                        <p>“Proin gravida nibh vel velit aucrtor aliquet aenean sollicitudin lorem quis bib ndum auctor nisi elit consequat ipsum nec proin gravida nibh vel velit lrem auctor aliquet”</p>

                        <ul class="rating-list">
                            <li><i class='bx bxs-star'></i></li>
                            <li><i class='bx bxs-star'></i></li>
                            <li><i class='bx bxs-star'></i></li>
                            <li><i class='bx bxs-star'></i></li>
                            <li><i class='bx bxs-star'></i></li>
                        </ul>

                        <div class="icon">
                            <i class="flaticon-left-quote"></i>
                        </div>
                    </div>

                    <div class="testimonial-item-box">
                        <div class="info-box">
                            <img src="{{ asset('assets/home6/images/testimonial/image-2.jpg')}}" alt="image">
                            <h3>Agaton Johnsson</h3>
                            <span>Developer Expert</span>
                        </div>

                        <p>“Proin gravida nibh vel velit aucrtor aliquet aenean sollicitudin lorem quis bib ndum auctor nisi elit consequat ipsum nec proin gravida nibh vel velit lrem auctor aliquet”</p>

                        <ul class="rating-list">
                            <li><i class='bx bxs-star'></i></li>
                            <li><i class='bx bxs-star'></i></li>
                            <li><i class='bx bxs-star'></i></li>
                            <li><i class='bx bxs-star'></i></li>
                            <li><i class='bx bxs-star'></i></li>
                        </ul>

                        <div class="icon">
                            <i class="flaticon-left-quote"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- End Testimonial Area -->

        <!-- Start Partner Area -->
        <div class="partner-area ptb-100">
            <div class="container">
                <div class="partner-box">
                    <div class="partner-slides owl-carousel owl-theme">

                        @foreach($partners as $partner)
                        <div class="single-partner">
                            <a href="{{ $partner->logo }}"> <img src="{{asset('storage')}}/partner/{{ $partner->logo }}"  alt="slack"></a>
                        </div>
                        @endforeach


                    </div>
                </div>
            </div>
        </div>
        <!-- End Partner Area -->

        <!-- Start Video Area -->
        <div class="video-area">
            <div class="container">
                <div class="video-box-image">
                    <img src="{{ asset('assets/home6/images/video.jpg')}}" alt="image">

                    <a href="https://www.youtube.com/watch?v=ODfy2YIKS1M" class="video-btn popup-youtube">
                        <i class='bx bx-play'></i>
                    </a>
                </div>
            </div>
        </div>
        <!-- End Video Area -->


       <!-- Start Blog Area -->
<div class="blog-area pt-100 pb-100">
    <div class="container">
        <div class="section-title">
            <span>Recent Articles</span>
            <h2>Read the Latest News and Blogs</h2>
            <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua ut enim ad minim veniam quis nostrud exercitation ullamco.</p>
        </div>

        <div class="row justify-content-center">
            @if(!empty($recent_blogs))
            @foreach ($recent_blogs as $recent_blog)


                    <div class="col-lg-4 col-md-6">
                        <div class="single-blog">
                            <div class="blog-image">
                                <a href="{{route('blog.details',encrypted_key($recent_blog->id,"encrypt"))}}">
                                    @if(file_exists( storage_path().'/blog/'.$recent_blog->image ) && !empty($recent_blog->image))
                                    <img src="{{asset('storage')}}/blog/{{ $recent_blog->image }}" alt="...">
                                    @else
                                    <img class="img-fluid" src="{{ asset('assets/img/blog/blog-thumb-01.jpg') }}" alt="">
                                    @endif
                                </a>
                                <div class="tag"> <a href="{{route('blog.details',encrypted_key($recent_blog->id,"encrypt"))}}">{{$recent_blog->tags}}</a></div>
                            </div>

                            <div class="blog-content">
                                <div class="blog-author align-items-center">
                                    @if(file_exists( storage_path().'/app/'.$recent_blog->user->avatar ) && !empty($recent_blog->user->avatar))
                                    <img src="{{asset('storage')}}/app/{{ $recent_blog->user->avatar }}" class="rounded-circle"    alt="...">
                                    @else
                                    <img src="{{ asset('assets/img/user/user2.jpg') }}"  class="rounded-circle"   >
                                    @endif

                                    <span><a href="{{route('blog.details',encrypted_key($recent_blog->id,"encrypt"))}}">{{ $recent_blog->user->name??'' }}</a></span>
                                </div>
                                <h3>
                                    <a href="{{route('blog.details',encrypted_key($recent_blog->id,"encrypt"))}}">{{$recent_blog->title}}</a>
                                </h3>
                                <p>{!!substr_replace($recent_blog->article, "...", 100)!!}</p>

                                <ul class="blog-box-footer d-flex justify-content-between align-items-center">
                                    <li>
                                        <i class='bx bx-calendar'></i> {{date('F d, Y', strtotime($recent_blog->created_at))}}
                                    </li>

                                </ul>
                            </div>
                        </div>
                    </div>
                @endforeach
            @endif




        </div>

        <div class="view-all-btn">
            <a href="{{route('search.blogs')}}" class="default-btn"><i class='bx bx-chevron-right'></i> View All Blog<span></span></a>
        </div>
    </div>
</div>

        <!-- Start Overview Area -->
        <div class="overview-area ptb-100">
            <div class="container">
                <div class="row align-items-center">
                    <div class="col-lg-8 col-md-12">
                        <div class="overview-content">
                            <span>Hurry Up!</span>
                            <h3>Book Your Seat</h3>
                            <p>Proin gravida nibh vel velit auctor aliquet. Aenean sollicitudin, lorem quis that bibendum auctor, nisi elit consequat  nec sagittis sem nibh id lorem elit.</p>
                        </div>
                    </div>

                    <div class="col-lg-4 col-md-12">
                        <div class="overview-btn">
                            <a href="pricing.html" class="default-btn"><i class='bx bx-arrow-to-right'></i> Buy Ticket Now<span></span></a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- End Overview Area -->
        @php
            $footerWidget1 = \App\SiteSettings::getWebsiteMenus('footer_widget_1');
            $footerWidget2 = \App\SiteSettings::getWebsiteMenus('footer_widget_2');

            $logo =  \App\SiteSettings::logoSetting();

                if(!empty($logo)){
                $logo_favicon = json_decode($logo->value,true);
                }else{
                    $logo_favicon = array();
                }


            $footer_text =  \App\SiteSettings::footerSetting();

        @endphp
        <!-- Start Footer Area -->
        <footer class="footer-area pt-100 pb-75">
            <div class="container">
                <div class="row justify-content-center">
                    <div class="col-lg-3 col-sm-6">
                        <div class="single-footer-widget">
                            <div class="widget-logo">
                                <a href="/">
                                    @if (!empty($logo_favicon['logo']))
                                        <img src="{{ asset('storage/logo').'/'.$logo_favicon['logo'] }}" >
                                    @else
                                    <img src="{{ asset('assets/main/images/logo.png')}}">
                                    @endif
                                </a>
                            </div>
                            <p>Proin gravida nibh vel velit auctor aliquet. Aenean sollicitudin lorem quis bibendum auctor nisi elit consequat ipsum thnec sagittis sem nibh id elit.</p>
                        </div>
                    </div>

                    <div class="col-lg-3 col-sm-6">
                        <div class="single-footer-widget">
                            <h3>Our Company</h3>

                            <ul class="footer-links-list">
                                @if (count($footerWidget1))
                                @foreach ($footerWidget1 as $key => $menu)
                                    @if ($menu)
                                        <li><a href="{{url(str_replace('_','-',$menu))}}"> {{$key}}</a></li>
                                    @endif
                                @endforeach
                        @else


							 <li><a href="">Find Candidates</a></li>
							 <li><a href="">Post a Job</a></li>
							 <li><a href="">Resume Search</a></li>
							 <li><a href="">Impact</a></li>
							 <li><a href="">Staffing</a></li>

                        @endif
                            </ul>
                        </div>
                    </div>

                    <div class="col-lg-3 col-sm-6">
                        <div class="single-footer-widget">
                            <h3>Follow Us</h3>

                            <ul class="footer-links-list">
                                <li><a href="https://www.facebook.com/" target="_blank">Facebook</a></li>
                                <li><a href="https://twitter.com/?lang=en" target="_blank">Twitter</a></li>
                                <li><a href="https://www.instagram.com/" target="_blank">Instagram</a></li>
                                <li><a href="https://www.linkedin.com/" target="_blank">Linkedin</a></li>
                                <li><a href="https://www.youtube.com/" target="_blank">Youtube</a></li>
                            </ul>
                        </div>
                    </div>

                    <div class="col-lg-3 col-sm-6">
                        <div class="single-footer-widget">
                            <h3>Quick Contact</h3>

                            <ul class="widget-info">
                                @if (count($footerWidget2))
                                @foreach ($footerWidget2 as $key => $menu)
                                    @if ($menu)
                                        <li><a href="{{url(str_replace('_','-',$menu))}}" > {{$key}}</a></li>
                                    @endif
                                @endforeach
                            @else

							 <li><a href="">Interative Podcasts</a></li>

							 <li><a href="">Blogs & Whitepapers</a></li>
							 <li><a href="">Conversation Games</a></li>
							 <li><a href="">Labs, Kits & Merch</a></li>
							 <li><a href="">Broadband Benefit </a></li>
							 @endif
                            </ul>


                        </div>
                    </div>
                </div>
            </div>
        </footer>
        <!-- End Footer Area -->

        <!-- Start Copyright Area -->
        <div class="copyright-area">
            <div class="container">
                <div class="copyright-area-content">
                    <div class="row align-items-center">
                        <div class="col-lg-6 col-md-6">
                            <p>
                                {{$footer_text}}
                            </p>
                        </div>

                        <div class="col-lg-6 col-md-6">
                            <ul>
                                <li>
                                    <a href="terms-of-service.html">Terms of Service</a>
                                </li>
                                <li>
                                    <a href="privacy-policy.html">Privacy Policy</a>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- End Copyright Area -->

        <!-- Start Go Top Area -->
        <div class="go-top">
            <i class='bx bx-chevron-up'></i>
        </div>
        <!-- End Go Top Area -->
@endsection
