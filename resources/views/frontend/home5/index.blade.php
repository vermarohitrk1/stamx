@extends('layout.frontend.home5.mainlayout')
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

<!-- Start Main Slides Area -->
<div class="main-slides-area">
    <div class="home-slides owl-carousel owl-theme">
        <div class="main-slides-item">
            <div class="container">
                <div class="main-slides-content">
                    <p class="sub-title">Leadership Conference and Events</p>
                    <h1>Biggest Marketing Executives Conference</h1>
                    <p>Aenean sollicitudin lorem quis bibendum auctor, nisi elit consequat ipsum nec sagittis sem nibh id elit. duis sed odio sit amet nibh vulputate cursus.</p>

                    <div class="slides-btn">
                        <a href="pricing.html" class="default-btn"><i class='bx bx-calendar'></i> Buy Ticket Now<span></span></a>

                        <a href="https://www.youtube.com/watch?v=ODfy2YIKS1M" class="optional-btn popup-youtube"><i class="flaticon-play-button-arrowhead"></i> Watch Presentation</a>
                    </div>
                </div>
            </div>
        </div>

        <div class="main-slides-item item-two">
            <div class="container">
                <div class="main-slides-content">
                    <p class="sub-title">Leadership Conference and Events</p>
                    <h1>World Advanced Biggest Conference 2021</h1>
                    <p>Aenean sollicitudin lorem quis bibendum auctor, nisi elit consequat ipsum nec sagittis sem nibh id elit. duis sed odio sit amet nibh vulputate cursus.</p>

                    <div class="slides-btn">
                        <a href="pricing.html" class="default-btn"><i class='bx bx-calendar'></i> Buy Ticket Now<span></span></a>

                        <a href="https://www.youtube.com/watch?v=ODfy2YIKS1M" class="optional-btn popup-youtube"><i class="flaticon-play-button-arrowhead"></i> Watch Presentation</a>
                    </div>
                </div>
            </div>
        </div>

        <div class="main-slides-item item-three">
            <div class="container">
                <div class="main-slides-content">
                    <p class="sub-title">Leadership Conference and Events</p>
                    <h1>Programmer Meetup Conference</h1>
                    <p>Aenean sollicitudin lorem quis bibendum auctor, nisi elit consequat ipsum nec sagittis sem nibh id elit. duis sed odio sit amet nibh vulputate cursus.</p>

                    <div class="slides-btn">
                        <a href="pricing.html" class="default-btn"><i class='bx bx-calendar'></i> Buy Ticket Now<span></span></a>

                        <a href="https://www.youtube.com/watch?v=ODfy2YIKS1M" class="optional-btn popup-youtube"><i class="flaticon-play-button-arrowhead"></i> Watch Presentation</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- End Main Slides Area -->

<!-- Start Intro Area -->
<div class="intro-area pb-75">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-3 col-sm-6">
                <div class="single-intro-box">
                    <span><i class='bx bx-calendar'></i> 10th February 2021</span>
                    <h3>
                        <a href="events-details.html">Asia Pacific Design Conference</a>
                    </h3>
                </div>
            </div>

            <div class="col-lg-3 col-sm-6">
                <div class="single-intro-box">
                    <span><i class='bx bx-calendar'></i> 06th March 2021</span>
                    <h3>
                        <a href="events-details.html">Digital Marketing and SEO Marketing</a>
                    </h3>
                </div>
            </div>

            <div class="col-lg-3 col-sm-6">
                <div class="single-intro-box">
                    <span><i class='bx bx-calendar'></i> 28th June 2021</span>
                    <h3>
                        <a href="events-details.html">Design Conference of European</a>
                    </h3>
                </div>
            </div>

            <div class="col-lg-3 col-sm-6">
                <div class="single-intro-box">
                    <span><i class='bx bx-calendar'></i> 10th February 2021</span>
                    <h3>
                        <a href="events-details.html">International World Wide Events</a>
                    </h3>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- End Intro Area -->

<!-- Start Events Schedules Area -->
<div class="events-schedules-area pb-100">
    <div class="container">
        <div class="section-title">
            <span>Event Schedules</span>
            <h2>Upcoming Event Schedules</h2>
            <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua ut enim ad minim veniam quis nostrud exercitation ullamco.</p>
        </div>

        <div class="row justify-content-center">
            <div class="col-lg-4 col-md-6">
                <div class="single-events-schedules">
                    <div class="events-image">
                        <a href="events-details.html"><img src="{{ asset('assets/home5/images/events-schedules/events-1.jpg')}}" alt="image"></a>

                        <div class="tag"><a href="events.html">Conference</a></div>
                    </div>

                    <div class="events-content">
                        <span><i class='bx bx-calendar'></i> 08/03/2021</span>
                        <h3>
                            <a href="events-details.html">Social Return On Investment (SROI) Conference</a>
                        </h3>
                        <p>Proin gravida nibh vel velit auctor aliquet. Aenean llicin lorem quis bibendum auctor.</p>

                        <div class="bottom-content">
                            <div class="info">
                                <img src="{{ asset('assets/home5/images/events-schedules/image-1.jpg')}}" alt="image">
                                <h4>Tripp Mckay</h4>
                                <p>Historian</p>
                            </div>

                            <div class="book-btn">
                                <a href="contact.html" class="book-btn-one"><i class='bx bx-arrow-to-right'></i> Book Now</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-lg-4 col-md-6">
                <div class="single-events-schedules">
                    <div class="events-image">
                        <a href="events-details.html"><img src="{{ asset('assets/home5/images/events-schedules/events-2.jpg')}}" alt="image"></a>

                        <div class="tag"><a href="events.html">Conference</a></div>
                    </div>

                    <div class="events-content">
                        <span><i class='bx bx-calendar'></i> 28/04/2021</span>
                        <h3>
                            <a href="events-details.html">Wellbeing Self-Isolation Daily Drop In Event 2021</a>
                        </h3>
                        <p>Proin gravida nibh vel velit auctor aliquet. Aenean llicin lorem quis bibendum auctor.</p>

                        <div class="bottom-content">
                            <div class="info">
                                <img src="{{ asset('assets/home5/images/events-schedules/image-2.jpg')}}" alt="image">
                                <h4>Gabrielle Winn</h4>
                                <p>Art Critic</p>
                            </div>

                            <div class="book-btn">
                                <a href="contact.html" class="book-btn-one"><i class='bx bx-arrow-to-right'></i> Book Now</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-lg-4 col-md-6">
                <div class="single-events-schedules">
                    <div class="events-image">
                        <a href="events-details.html"><img src="{{ asset('assets/home5/images/events-schedules/events-3.jpg')}}" alt="image"></a>

                        <div class="tag"><a href="events.html">Conference</a></div>
                    </div>

                    <div class="events-content">
                        <span><i class='bx bx-calendar'></i> 14/07/2021</span>
                        <h3>
                            <a href="events-details.html">The Marine And Aquatic Civil Servants</a>
                        </h3>
                        <p>Proin gravida nibh vel velit auctor aliquet. Aenean llicin lorem quis bibendum auctor.</p>

                        <div class="bottom-content">
                            <div class="info">
                                <img src="{{ asset('assets/home5/images/events-schedules/image-3.jpg')}}" alt="image">
                                <h4>Milana Myles</h4>
                                <p>Insurance consultant</p>
                            </div>

                            <div class="book-btn">
                                <a href="contact.html" class="book-btn-one"><i class='bx bx-arrow-to-right'></i> Book Now</a>
                            </div>
                        </div>
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
<div class="expect-area ptb-100">
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

        <div class="view-all-btn">
            <a href="schedules.html" class="default-btn"><i class='bx bx-chevron-right'></i> View All Expect<span></span></a>
        </div>
    </div>
</div>
<!-- End Expect Area -->

<!-- Start Experience Area -->
<div class="experience-area pt-100 pb-100">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-lg-6 col-md-12">
                <div class="experience-content">
                    <span>Our Experience</span>
                    <h3>Start your Journey with Us! Know a Bit</h3>
                    <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip.</p>
                </div>
            </div>

            <div class="col-lg-6 col-md-12">
                <div class="fun-fact-inner-box">
                    <div class="row">
                        <div class="col-lg-6 col-md-6">
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

                        <div class="col-lg-6 col-md-6">
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

                        <div class="col-lg-6 col-md-6">
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

                        <div class="col-lg-6 col-md-6">
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
        </div>
    </div>
</div>
<!-- End Experience Area -->

<!-- Start Speakers Area -->
<div class="speakers-area ptb-100">
    <div class="container">
        <div class="section-title">
            <span>Our Speakers</span>
            <h2>Experience Speaker with Knowledge</h2>
            <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua ut enim ad minim veniam quis nostrud exercitation ullamco.</p>
        </div>

        <div class="row justify-content-center">
            <div class="col-lg-3 col-md-6">
                <div class="single-speakers">
                    <div class="speakers-image">
                        <a href="speakers-details.html"><img src="{{ asset('assets/home5/images/speakers/speakers-1.jpg')}}" alt="image"></a>
                    </div>

                    <div class="speakers-content">
                        <h3>
                            <a href="speakers-details.html">Dr. Thomas Debin</a>
                        </h3>
                        <span>Journalist</span>

                        <ul class="social">
                            <li>
                                <a href="https://www.facebook.com/" target="_blank"><i class='bx bxl-facebook'></i></a>
                            </li>
                            <li>
                                <a href="https://twitter.com/" target="_blank"><i class='bx bxl-twitter'></i></a>
                            </li>
                            <li>
                                <a href="https://www.pinterest.com/" target="_blank"><i class='bx bxl-pinterest-alt'></i></a>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>

            <div class="col-lg-3 col-md-6">
                <div class="single-speakers">
                    <div class="speakers-image">
                        <a href="speakers-details.html"><img src="{{ asset('assets/home5/images/speakers/speakers-2.jpg')}}" alt="image"></a>
                    </div>

                    <div class="speakers-content">
                        <h3>
                            <a href="speakers-details.html">Dr. Yamilet Bo</a>
                        </h3>
                        <span>Historian</span>

                        <ul class="social">
                            <li>
                                <a href="https://www.facebook.com/" target="_blank"><i class='bx bxl-facebook'></i></a>
                            </li>
                            <li>
                                <a href="https://twitter.com/" target="_blank"><i class='bx bxl-twitter'></i></a>
                            </li>
                            <li>
                                <a href="https://www.pinterest.com/" target="_blank"><i class='bx bxl-pinterest-alt'></i></a>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>

            <div class="col-lg-3 col-md-6">
                <div class="single-speakers">
                    <div class="speakers-image">
                        <a href="speakers-details.html"><img src="{{ asset('assets/home5/images/speakers/speakers-3.jpg')}}" alt="image"></a>
                    </div>

                    <div class="speakers-content">
                        <h3>
                            <a href="speakers-details.html">Rene Wells</a>
                        </h3>
                        <span>Art Critic</span>

                        <ul class="social">
                            <li>
                                <a href="https://www.facebook.com/" target="_blank"><i class='bx bxl-facebook'></i></a>
                            </li>
                            <li>
                                <a href="https://twitter.com/" target="_blank"><i class='bx bxl-twitter'></i></a>
                            </li>
                            <li>
                                <a href="https://www.pinterest.com/" target="_blank"><i class='bx bxl-pinterest-alt'></i></a>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>

            <div class="col-lg-3 col-md-6">
                <div class="single-speakers">
                    <div class="speakers-image">
                        <a href="speakers-details.html"><img src="{{ asset('assets/home5/images/speakers/speakers-4.jpg')}}" alt="image"></a>
                    </div>

                    <div class="speakers-content">
                        <h3>
                            <a href="speakers-details.html">Tripp Mckay</a>
                        </h3>
                        <span>Insurance Consultant</span>

                        <ul class="social">
                            <li>
                                <a href="https://www.facebook.com/" target="_blank"><i class='bx bxl-facebook'></i></a>
                            </li>
                            <li>
                                <a href="https://twitter.com/" target="_blank"><i class='bx bxl-twitter'></i></a>
                            </li>
                            <li>
                                <a href="https://www.pinterest.com/" target="_blank"><i class='bx bxl-pinterest-alt'></i></a>
                            </li>
                        </ul>
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

<!-- Start Announcement Area -->
<div class="announcement-area ptb-100">
    <div class="container">
        <div class="section-title">
            <span>Leadership Conference and Events</span>
            <h2>Never Miss Another Speaker Announcement</h2>
        </div>

        <div class="announcement-soon-content">
            <div id="timer">
                <div id="days"></div>
                <div id="hours"></div>
                <div id="minutes"></div>
                <div id="seconds"></div>
            </div>

            <div class="announcement-btn">
                <a href="register.html" class="default-btn"><i class='bx bx-arrow-to-right'></i> Register Now<span></span></a>
            </div>
        </div>
    </div>
</div>
<!-- End Announcement Area -->

<!-- Start Benefits Area -->
<div class="benefits-area pt-100 pb-75">
    <div class="container">
        <div class="section-title">
            <h2>Who Benefits From Such Seminars</h2>
        </div>

        <div class="row justify-content-center">
            <div class="col-lg-3 col-sm-6">
                <div class="single-benefits">
                    <img src="{{ asset('assets/home5/images/benefits/benefits-1.png')}}" alt="image">
                    <h3>Business Owners</h3>
                    <p>Proin avida nibh vel velit auctor and aliquet. Aenean sollicitudin, lorem here lorem  aquis bibendum auctor.</p>
                </div>
            </div>

            <div class="col-lg-3 col-sm-6">
                <div class="single-benefits">
                    <img src="{{ asset('assets/home5/images/benefits/benefits-2.png')}}" alt="image">
                    <h3>Top Managers</h3>
                    <p>Proin avida nibh vel velit auctor and aliquet. Aenean sollicitudin, lorem here lorem  aquis bibendum auctor.</p>
                </div>
            </div>

            <div class="col-lg-3 col-sm-6">
                <div class="single-benefits">
                    <img src="{{ asset('assets/home5/images/benefits/benefits-3.png')}}" alt="image">
                    <h3>Anyone</h3>
                    <p>Proin avida nibh vel velit auctor and aliquet. Aenean sollicitudin, lorem here lorem  aquis bibendum auctor.</p>
                </div>
            </div>

            <div class="col-lg-3 col-sm-6">
                <div class="single-benefits">
                    <img src="{{ asset('assets/home5/images/benefits/benefits-4.png')}}" alt="image">
                    <h3>Regional Authorities</h3>
                    <p>Proin avida nibh vel velit auctor and aliquet. Aenean sollicitudin, lorem here lorem  aquis bibendum auctor.</p>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- End Benefits Area -->

<!-- Start Pricing Area -->
<div class="pricing-area pt-100 pb-75">
    <div class="container">
        <div class="section-title">
            <span>Our Pricing</span>
            <h2>Pricing Plan and Options</h2>
            <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua ut enim ad minim veniam quis nostrud exercitation ullamco.</p>
        </div>

        <div class="row justify-content-center">
            <div class="col-lg-4 col-md-6">
                <div class="single-pricing-table">
                    <div class="pricing-header">
                        <h3>Personal</h3>
                    </div>

                    <div class="icon">
                        <i class="flaticon-leadership"></i>
                    </div>

                    <div class="price">$50</div>

                    <ul class="pricing-features-list">
                        <li>Personalized Schedule</li>
                        <li>Access to Exhibition Floor</li>
                        <li>Featured Speakers</li>
                        <li>Opening and Closing Parties</li>
                        <li>Consectetur Adipisicing</li>
                        <li>Event Organization</li>
                        <li>24/7 Customer Support</li>
                        <li>Travel Booking</li>
                    </ul>

                    <div class="pricing-btn">
                        <a href="register.html" class="default-btn"><i class='bx bx-arrow-to-right'></i> Register Now <span></span></a>
                    </div>
                </div>
            </div>

            <div class="col-lg-4 col-md-6">
                <div class="single-pricing-table">
                    <div class="pricing-header">
                        <h3>Standard</h3>
                    </div>

                    <div class="icon">
                        <i class="flaticon-leadership"></i>
                    </div>

                    <div class="price">$150</div>

                    <ul class="pricing-features-list">
                        <li>Personalized Schedule</li>
                        <li>Access to Exhibition Floor</li>
                        <li>Featured Speakers</li>
                        <li>Opening and Closing Parties</li>
                        <li>Consectetur Adipisicing</li>
                        <li>Event Organization</li>
                        <li>24/7 Customer Support</li>
                        <li>Travel Booking</li>
                    </ul>

                    <div class="pricing-btn">
                        <a href="register.html" class="default-btn"><i class='bx bx-arrow-to-right'></i> Register Now <span></span></a>
                    </div>
                </div>
            </div>

            <div class="col-lg-4 col-md-6">
                <div class="single-pricing-table">
                    <div class="pricing-header">
                        <h3>Business</h3>
                    </div>

                    <div class="icon">
                        <i class="flaticon-leadership"></i>
                    </div>

                    <div class="price">$250</div>

                    <ul class="pricing-features-list">
                        <li>Personalized Schedule</li>
                        <li>Access to Exhibition Floor</li>
                        <li>Featured Speakers</li>
                        <li>Opening and Closing Parties</li>
                        <li>Consectetur Adipisicing</li>
                        <li>Event Organization</li>
                        <li>24/7 Customer Support</li>
                        <li>Travel Booking</li>
                    </ul>

                    <div class="pricing-btn">
                        <a href="register.html" class="default-btn"><i class='bx bx-arrow-to-right'></i> Register Now <span></span></a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- End Pricing Area -->

<!-- Start Testimonial Area -->
<div class="testimonial-area ptb-100">
    <div class="container">
        <div class="section-title">
            <span>Testimonials</span>
            <h2>Why Our Customer Love Plonk</h2>
            <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua ut enim ad minim veniam quis nostrud exercitation ullamco.</p>
        </div>

        <div class="testimonial-slides owl-carousel owl-theme">
            <div class="testimonial-item">
                <img src="{{ asset('assets/home5/images/testimonial/image-1.jpg')}}" alt="image">
                <h3>Thomas Albart</h3>

                <ul class="rating-list">
                    <li><i class='bx bxs-star'></i></li>
                    <li><i class='bx bxs-star'></i></li>
                    <li><i class='bx bxs-star'></i></li>
                    <li><i class='bx bxs-star'></i></li>
                    <li><i class='bx bxs-star'></i></li>
                </ul>

                <p>“Proin gravida nibh vel velit auctor aliquet. Aenean sollicitudin, lorem quis bibendum auctor, nisi elit consequat ipsum, nec.”</p>

                <div class="info">
                    <i class='bx bxs-parking'></i>
                    <span>CEO & Founder</span>
                </div>

                <div class="icon">
                    <i class="flaticon-left-quote"></i>
                </div>
            </div>

            <div class="testimonial-item">
                <img src="{{ asset('assets/home5/images/testimonial/image-2.jpg')}}" alt="image">
                <h3>Tripp Mckay</h3>

                <ul class="rating-list">
                    <li><i class='bx bxs-star'></i></li>
                    <li><i class='bx bxs-star'></i></li>
                    <li><i class='bx bxs-star'></i></li>
                    <li><i class='bx bxs-star'></i></li>
                    <li><i class='bx bxs-star'></i></li>
                </ul>

                <p>“Proin gravida nibh vel velit auctor aliquet. Aenean sollicitudin, lorem quis bibendum auctor, nisi elit consequat ipsum, nec.”</p>

                <div class="info">
                    <i class='bx bxs-parking'></i>
                    <span>CEO & Founder</span>
                </div>

                <div class="icon">
                    <i class="flaticon-left-quote"></i>
                </div>
            </div>

            <div class="testimonial-item">
                <img src="{{ asset('assets/home5/images/testimonial/image-3.jpg')}}" alt="image">
                <h3>Milana Myles</h3>

                <ul class="rating-list">
                    <li><i class='bx bxs-star'></i></li>
                    <li><i class='bx bxs-star'></i></li>
                    <li><i class='bx bxs-star'></i></li>
                    <li><i class='bx bxs-star'></i></li>
                    <li><i class='bx bxs-star'></i></li>
                </ul>

                <p>“Proin gravida nibh vel velit auctor aliquet. Aenean sollicitudin, lorem quis bibendum auctor, nisi elit consequat ipsum, nec.”</p>

                <div class="info">
                    <i class='bx bxs-parking'></i>
                    <span>CEO & Founder</span>
                </div>

                <div class="icon">
                    <i class="flaticon-left-quote"></i>
                </div>
            </div>

            <div class="testimonial-item">
                <img src="{{ asset('assets/home5/images/testimonial/image-4.jpg')}}" alt="image">
                <h3>Yamilet Booker</h3>

                <ul class="rating-list">
                    <li><i class='bx bxs-star'></i></li>
                    <li><i class='bx bxs-star'></i></li>
                    <li><i class='bx bxs-star'></i></li>
                    <li><i class='bx bxs-star'></i></li>
                    <li><i class='bx bxs-star'></i></li>
                </ul>

                <p>“Proin gravida nibh vel velit auctor aliquet. Aenean sollicitudin, lorem quis bibendum auctor, nisi elit consequat ipsum, nec.”</p>

                <div class="info">
                    <i class='bx bxs-parking'></i>
                    <span>CEO & Founder</span>
                </div>

                <div class="icon">
                    <i class="flaticon-left-quote"></i>
                </div>
            </div>

            <div class="testimonial-item">
                <img src="{{ asset('assets/home5/images/testimonial/image-1.jpg')}}" alt="image">
                <h3>Thomas Albart</h3>

                <ul class="rating-list">
                    <li><i class='bx bxs-star'></i></li>
                    <li><i class='bx bxs-star'></i></li>
                    <li><i class='bx bxs-star'></i></li>
                    <li><i class='bx bxs-star'></i></li>
                    <li><i class='bx bxs-star'></i></li>
                </ul>

                <p>“Proin gravida nibh vel velit auctor aliquet. Aenean sollicitudin, lorem quis bibendum auctor, nisi elit consequat ipsum, nec.”</p>

                <div class="info">
                    <i class='bx bxs-parking'></i>
                    <span>CEO & Founder</span>
                </div>

                <div class="icon">
                    <i class="flaticon-left-quote"></i>
                </div>
            </div>

            <div class="testimonial-item">
                <img src="{{ asset('assets/home5/images/testimonial/image-2.jpg')}}" alt="image">
                <h3>Tripp Mckay</h3>

                <ul class="rating-list">
                    <li><i class='bx bxs-star'></i></li>
                    <li><i class='bx bxs-star'></i></li>
                    <li><i class='bx bxs-star'></i></li>
                    <li><i class='bx bxs-star'></i></li>
                    <li><i class='bx bxs-star'></i></li>
                </ul>

                <p>“Proin gravida nibh vel velit auctor aliquet. Aenean sollicitudin, lorem quis bibendum auctor, nisi elit consequat ipsum, nec.”</p>

                <div class="info">
                    <i class='bx bxs-parking'></i>
                    <span>CEO & Founder</span>
                </div>

                <div class="icon">
                    <i class="flaticon-left-quote"></i>
                </div>
            </div>

            <div class="testimonial-item">
                <img src="{{ asset('assets/home5/images/testimonial/image-3.jpg')}}" alt="image">
                <h3>Milana Myles</h3>

                <ul class="rating-list">
                    <li><i class='bx bxs-star'></i></li>
                    <li><i class='bx bxs-star'></i></li>
                    <li><i class='bx bxs-star'></i></li>
                    <li><i class='bx bxs-star'></i></li>
                    <li><i class='bx bxs-star'></i></li>
                </ul>

                <p>“Proin gravida nibh vel velit auctor aliquet. Aenean sollicitudin, lorem quis bibendum auctor, nisi elit consequat ipsum, nec.”</p>

                <div class="info">
                    <i class='bx bxs-parking'></i>
                    <span>CEO & Founder</span>
                </div>

                <div class="icon">
                    <i class="flaticon-left-quote"></i>
                </div>
            </div>

            <div class="testimonial-item">
                <img src="{{ asset('assets/home5/images/testimonial/image-4.jpg')}}" alt="image">
                <h3>Yamilet Booker</h3>

                <ul class="rating-list">
                    <li><i class='bx bxs-star'></i></li>
                    <li><i class='bx bxs-star'></i></li>
                    <li><i class='bx bxs-star'></i></li>
                    <li><i class='bx bxs-star'></i></li>
                    <li><i class='bx bxs-star'></i></li>
                </ul>

                <p>“Proin gravida nibh vel velit auctor aliquet. Aenean sollicitudin, lorem quis bibendum auctor, nisi elit consequat ipsum, nec.”</p>

                <div class="info">
                    <i class='bx bxs-parking'></i>
                    <span>CEO & Founder</span>
                </div>

                <div class="icon">
                    <i class="flaticon-left-quote"></i>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- End Testimonial Area -->

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
<!-- End Blog Area -->

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
                    <h3>Workforce</h3>

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
                    <h3>Engage</h3>

                    <ul class="footer-links-list">
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
                   <p class="copyrightp">	{{$footer_text}}</p>
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


