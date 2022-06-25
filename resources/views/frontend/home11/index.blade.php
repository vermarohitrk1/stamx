@extends('layout.frontend.home11.mainlayout')
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

        <!-- Start Top Header Area -->
        <div class="header-information">Header Information</div>

        <div class="top-header-area">
            <div class="container">
                <div class="row align-items-center">
                    <div class="col-lg-7 col-md-9">
                        <ul class="top-header-content">
                            <li>
                                <i class='bx bx-envelope'></i>
                                <a href="mailto:spurf@gmail.com">spurf@gmail.com</a>
                            </li>

                            <li>
                                <i class='bx bx-support'></i>
                                <a href="tel:012345678">+012 345 678</a>
                            </li>

                            <li>
                                <i class='bx bx-map'></i>
                                15 Brooklyn Street, New York, USA
                            </li>
                        </ul>
                    </div>

                    <div class="col-lg-5 col-md-3">
                        <ul class="top-header-optional">
                            <li>
                                <a href="https://www.facebook.com/" target="_blank">
                                    <i class='bx bxl-facebook'></i>
                                </a>
                                <a href="https://twitter.com/?lang=en" target="_blank">
                                    <i class='bx bxl-twitter'></i>
                                </a>
                                <a href="https://www.instagram.com/" target="_blank">
                                    <i class='bx bxl-instagram-alt'></i>
                                </a>
                                <a href="https://www.google.com/" target="_blank">
                                    <i class='bx bxl-google'></i>
                                </a>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
        <!-- End Top Header Area -->

        <!-- Start Navbar Area -->
        <div class="navbar-area">
            <div class="main-responsive-nav">
                <div class="container">
                    <div class="main-responsive-menu">
                        <div class="logo">
                            <a href="/" class="text-dark">
                                @if (!empty($logo_favicon['logo']))
                                    <img src="{{ asset('storage/logo').'/'.$logo_favicon['logo'] }}" alt="LogoImage" >
                                @else

                                    @if(!empty($logoTxt)) {{ $logoTxt }} @else Your Logo Here @endif
                                @endif
                            </a>
                        </div>
                    </div>
                </div>
            </div>

            <div class="main-navbar">
                <div class="container">
                    <nav class="navbar navbar-expand-md navbar-light">
                        <a class="navbar-brand text-dark" href="/">
                            @if (!empty($logo_favicon['logo']))
                                <img src="{{ asset('storage/logo').'/'.$logo_favicon['logo'] }}" alt="LogoImage" >
                            @else

                                @if(!empty($logoTxt)) {{ $logoTxt }} @else Your Logo Here @endif
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
                                    <a href="workspaces.html" class="default-btn">Add Your Space <i class='bx bx-plus'></i><span></span></a>
                                </div>

                                <div class="option-item">
                                    <a href="login.html" class="optional-btn">Login <i class='bx bxs-user'></i><span></span></a>
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
                            <p class="sub-title">Give a Boost On Your Work</p>
                            <h1>Creative Environment for Coworking and Office Space</h1>

                            <div class="slides-btn">
                                <a href="events-booking.html" class="default-btn">Book A Tour <i class='bx bxs-chevron-right'></i><span></span></a>

                                <a href="https://www.youtube.com/watch?v=ODfy2YIKS1M" class="optional-btn  popup-youtube">Watch Our Video <i class='bx bx-play-circle'></i><span></span></a>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="main-slides-item item-two">
                    <div class="container">
                        <div class="main-slides-content">
                            <p class="sub-title">Give a Boost On Your Work</p>
                            <h1>Professional, Creative, Flexible, Scalable Workspace</h1>

                            <div class="slides-btn">
                                <a href="events-booking.html" class="default-btn">Book A Tour <i class='bx bxs-chevron-right'></i><span></span></a>

                                <a href="https://www.youtube.com/watch?v=ODfy2YIKS1M" class="optional-btn  popup-youtube">Watch Our Video <i class='bx bx-play-circle'></i><span></span></a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- End Main Slides Area -->

        <!-- Start Features Area -->
        <div class="features-area pb-70">
            <div class="container">
                <div class="row justify-content-center">
                    <div class="col-lg-3 col-sm-6">
                        <div class="single-box">
                            <a href="services-details.html"><img src="{{ asset('assets/home11/images/features/features-1.png')}}" alt="image"></a>
                            <h3>
                                <a href="services-details.html">Event Space</a>
                            </h3>
                        </div>
                    </div>

                    <div class="col-lg-3 col-sm-6">
                        <div class="single-box">
                            <a href="services-details.html"><img src="{{ asset('assets/home11/images/features/features-2.png')}}" alt="image"></a>
                            <h3>
                                <a href="services-details.html">High Speed Wifi</a>
                            </h3>
                        </div>
                    </div>

                    <div class="col-lg-3 col-sm-6">
                        <div class="single-box">
                            <a href="services-details.html"><img src="{{ asset('assets/home11/images/features/features-3.png')}}" alt="image"></a>
                            <h3>
                                <a href="services-details.html">Customize Space</a>
                            </h3>
                        </div>
                    </div>

                    <div class="col-lg-3 col-sm-6">
                        <div class="single-box">
                            <a href="services-details.html"><img src="{{ asset('assets/home11/images/features/features-4.png')}}" alt="image"></a>
                            <h3>
                                <a href="services-details.html">Snacks & Coffee</a>
                            </h3>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- End Features Area -->

        <!-- Start Coworking Space Area -->
        <div class="coworking-space-area pb-70">
            <div class="container">
                <div class="section-title">
                    <span>Coworking Space</span>
                    <h2>Our Modern Office Spaces Are Simply Stunning & Comfortable</h2>
                </div>

                <div class="row justify-content-center">
                    <div class="col-lg-4 col-md-6">
                        <div class="single-coworking-space">
                            <div class="image">
                                <a href="workspaces.html"><img src="{{ asset('assets/home11/images/coworking-space/coworking-1.jpg')}}" alt="image"></a>

                                <div class="number">01</div>
                                <div class="hover-number">01</div>
                            </div>

                            <div class="content">
                                <h3>
                                    <a href="workspaces.html">Small Team</a>
                                </h3>
                                <span>Single Desk & Hot Desk</span>
                            </div>

                            <div class="hover-content">
                                <h3>
                                    <a href="workspaces.html">Small Team</a>
                                </h3>
                                <span>Single Desk & Hot Desk</span>
                            </div>
                        </div>
                    </div>

                    <div class="col-lg-4 col-md-6">
                        <div class="single-coworking-space">
                            <div class="image">
                                <a href="workspaces.html"><img src="{{ asset('assets/home11/images/coworking-space/coworking-2.jpg')}}" alt="image"></a>

                                <div class="number">02</div>
                                <div class="hover-number">02</div>
                            </div>

                            <div class="content">
                                <h3>
                                    <a href="workspaces.html">Office Space</a>
                                </h3>
                                <span>Single Desk & Hot Desk</span>
                            </div>

                            <div class="hover-content">
                                <h3>
                                    <a href="workspaces.html">Office Space</a>
                                </h3>
                                <span>Single Desk & Hot Desk</span>
                            </div>
                        </div>
                    </div>

                    <div class="col-lg-4 col-md-6">
                        <div class="single-coworking-space">
                            <div class="image">
                                <a href="workspaces.html"><img src="{{ asset('assets/home11/images/coworking-space/coworking-3.jpg')}}" alt="image"></a>

                                <div class="number">03</div>
                                <div class="hover-number">03</div>
                            </div>

                            <div class="content">
                                <h3>
                                    <a href="workspaces.html">Conference Room</a>
                                </h3>
                                <span>Single Desk & Hot Desk</span>
                            </div>

                            <div class="hover-content">
                                <h3>
                                    <a href="workspaces.html">Conference Room</a>
                                </h3>
                                <span>Single Desk & Hot Desk</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- End Coworking Space Area -->

        <!-- Start Overview Area -->
        <div class="overview-area ptb-100">
            <div class="container">
                <div class="overview-content-box">
                    <span>Give a Boost On Your Work.</span>
                    <h3>Sustainable Coworking in Your Town</h3>
                    <p>Proin gravida nibh vel velit auctor aliquet. Aenean sollicitudin lorem quis bibendum auctor nisi elit consequat ipsum nec sagittis sem nibh id elit. Duis sed odio sit amet nibh vulputate cursus amet mauris.</p>

                    <div class="overview-btn">
                        <a href="events-booking.html" class="default-btn">Book A Tour <i class='bx bxs-chevron-right'></i><span></span></a>
                    </div>
                </div>
            </div>
        </div>
        <!-- End Overview Area -->

        <!-- Start Choose Area -->
        <div class="choose-area pt-100 pb-70">
            <div class="container">
                <div class="section-title">
                    <span>Why Choose Us</span>
                    <h2>We Offer Creative Working Environments That Suit Your Business</h2>
                </div>

                <div class="row justify-content-center">
                    <div class="col-lg-3 col-sm-6">
                        <div class="single-choose">
                            <div class="image">
                                <img src="{{ asset('assets/home11/images/choose/choose-1.png')}}" alt="image">
                            </div>

                            <h3>
                                <a href="services-details.html">Easy to Customize</a>
                            </h3>
                            <p>Proin gravida nibh vel velit auctor aliquet lorem ipsum demi enean sollicitudin.</p>
                        </div>
                    </div>

                    <div class="col-lg-3 col-sm-6">
                        <div class="single-choose">
                            <div class="image">
                                <img src="{{ asset('assets/home11/images/choose/choose-2.png')}}" alt="image">
                            </div>

                            <h3>
                                <a href="services-details.html">Creative Coworking Space</a>
                            </h3>
                            <p>Proin gravida nibh vel velit auctor aliquet lorem ipsum demi enean sollicitudin.</p>
                        </div>
                    </div>

                    <div class="col-lg-3 col-sm-6">
                        <div class="single-choose">
                            <div class="image">
                                <img src="{{ asset('assets/home11/images/choose/choose-3.png')}}" alt="image">
                            </div>

                            <h3>
                                <a href="services-details.html">Customize Space</a>
                            </h3>
                            <p>Proin gravida nibh vel velit auctor aliquet lorem ipsum demi enean sollicitudin.</p>
                        </div>
                    </div>

                    <div class="col-lg-3 col-sm-6">
                        <div class="single-choose">
                            <div class="image">
                                <img src="{{ asset('assets/home11/images/choose/choose-4.png')}}" alt="image">
                            </div>

                            <h3>
                                <a href="services-details.html">24/7 Access</a>
                            </h3>
                            <p>Proin gravida nibh vel velit auctor aliquet lorem ipsum demi enean sollicitudin.</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- End Choose Area -->

        <!-- Start Solution Area -->
        <div class="solution-area pt-100 pb-70">
            <div class="container">
                <div class="section-title">
                    <span>Coworking Space Solution</span>
                    <h2>Top Coworking Spaces in United States and Nearby</h2>
                </div>

                <div class="row justify-content-center">
                    <div class="col-lg-4 col-md-6">
                        <div class="single-solution">
                            <div class="solution-image">
                                <a href="services-details.html"><img src="{{ asset('assets/home11/images/solution/solution-1.jpg')}}" alt="image"></a>
                            </div>

                            <div class="solution-content">
                                <h3>
                                    <a href="services-details.html">Private Office</a>
                                </h3>
                                <p>Proin gravida nibh vel velit auctor aliquet. Aenean sollicitudin lorem quis bibendum auctor.</p>
                            </div>
                        </div>
                    </div>

                    <div class="col-lg-4 col-md-6">
                        <div class="single-solution">
                            <div class="solution-image">
                                <a href="services-details.html"><img src="{{ asset('assets/home11/images/solution/solution-2.jpg')}}" alt="image"></a>
                            </div>

                            <div class="solution-content">
                                <h3>
                                    <a href="services-details.html">Meeting Space</a>
                                </h3>
                                <p>Proin gravida nibh vel velit auctor aliquet. Aenean sollicitudin lorem quis bibendum auctor.</p>
                            </div>
                        </div>
                    </div>

                    <div class="col-lg-4 col-md-6">
                        <div class="single-solution">
                            <div class="solution-image">
                                <a href="services-details.html"><img src="{{ asset('assets/home11/images/solution/solution-3.jpg')}}" alt="image"></a>
                            </div>

                            <div class="solution-content">
                                <h3>
                                    <a href="services-details.html">Custom Space</a>
                                </h3>
                                <p>Proin gravida nibh vel velit auctor aliquet. Aenean sollicitudin lorem quis bibendum auctor.</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- End Solution Area -->

        <!-- Start Video Area -->
        <div class="video-area pt-100">
            <div class="container">
                <div class="section-title">
                    <h2>Check this Video Presentation to Know More a About Our Coworking</h2>
                    <p>Proin gravida nibh vel velit auctor aliquet. Aenean sollicitudin lorem quis bibendum auctor nisi elit consequat ipsum nec sagittis sem nibh id elit.</p>
                </div>

                <div class="video-box-image">
                    <img src="{{ asset('assets/home11/images/video.jpg')}}" alt="image">

                    <a href="https://www.youtube.com/watch?v=ODfy2YIKS1M" class="video-btn popup-youtube">
                        <i class='bx bx-play'></i>
                    </a>
                </div>
            </div>
        </div>
        <!-- End Video Area -->

        <!-- Start Benefits Area -->
        <div class="benefits-area ptb-100">
            <div class="container">
                <div class="row align-items-center">
                    <div class="col-lg-7">
                        <div class="benefits-content">
                            <span>Your Benefits</span>
                            <h3>Benefits to Setting Up Your Sustainable Startup in Our Coworking Creative Space</h3>
                            <p>Proin gravida nibh vel velit auctor aliquet. Aenean sollicitudin lorem quis bibendum auctor nisi elit consequat ipsum nec sagittis sem nibh id elit. Duis sed odio sit amet nibh vulputate cursus a sit amet mauris. Morbi accumsan ipsum velit. Nam nec tellus a odio tincidunt auctor a ornare odio. Sed non  mauris vitae erat consequat auctor eu in elit.</p>

                            <ul class="benefits-list">
                                <li>
                                    <i class='bx bx-check'></i>
                                    Actual Office Space That Promoting Productivity
                                </li>
                                <li>
                                    <i class='bx bx-check'></i>
                                    Meaningful Connections With Your Team
                                </li>
                                <li>
                                    <i class='bx bx-check'></i>
                                    Increased Productivity To Get Some Work Done
                                </li>
                                <li>
                                    <i class='bx bx-check'></i>
                                    Actual Office Space That Promoting
                                </li>
                            </ul>
                        </div>
                    </div>

                    <div class="col-lg-5">
                        <div class="benefits-image">
                            <img src="{{ asset('assets/home11/images/benefits.jpg')}}" alt="image">
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- End Benefits Area -->

        <!-- Start Membership Area -->
        <div class="membership-area pt-100 pb-70">
            <div class="container">
                <div class="section-title">
                    <span>Membership Options</span>
                    <h2>Spurf Is A Community Where Everyone Is Welcome</h2>
                </div>

                <div class="row justify-content-center">
                    <div class="col-lg-4 col-md-6">
                        <div class="single-membership-table">
                            <div class="membership-header">
                                <h3>Desk</h3>
                            </div>

                            <div class="price">$50 <span>/Month</span></div>

                            <p>Proin gravida nibh vel velit auctor aliquet here. Aenean sollicitudin lorem quis bibendum auctor nisi elit consequat ipsum.</p>

                            <ul class="membership-features-list">
                                <li><i class="bx bx-check"></i> Mix of Sitting and Standing Workspaces</li>
                                <li><i class="bx bx-check"></i> 24/7 Access</li>
                                <li><i class="bx bx-check"></i> Coffee, Tea, Snake and Sparkling</li>
                                <li class="color-gray"><i class="bx bx-check"></i> Fast Wi-Fi and Prints</li>
                                <li class="color-gray"><i class="bx bx-check"></i> Access to Community's Online Member Network</li>
                            </ul>

                            <div class="membership-btn">
                                <a href="events-booking.html" class="default-btn">Book A Tour <i class="bx bxs-chevron-right"></i><span></span></a>
                            </div>
                        </div>
                    </div>

                    <div class="col-lg-4 col-md-6">
                        <div class="single-membership-table">
                            <div class="membership-header">
                                <h3>Virtual</h3>
                            </div>

                            <div class="price">$150 <span>/Month</span></div>

                            <p>Proin gravida nibh vel velit auctor aliquet here. Aenean sollicitudin lorem quis bibendum auctor nisi elit consequat ipsum.</p>

                            <ul class="membership-features-list">
                                <li><i class="bx bx-check"></i> Mix of Sitting and Standing Workspaces</li>
                                <li><i class="bx bx-check"></i> 24/7 Access</li>
                                <li><i class="bx bx-check"></i> Coffee, Tea, Snake and Sparkling</li>
                                <li><i class="bx bx-check"></i> Fast Wi-Fi and Prints</li>
                                <li class="color-gray"><i class="bx bx-check"></i> Access to Community's Online Member Network</li>
                            </ul>

                            <div class="membership-btn">
                                <a href="events-booking.html" class="default-btn">Book A Tour <i class="bx bxs-chevron-right"></i><span></span></a>
                            </div>
                        </div>
                    </div>

                    <div class="col-lg-4 col-md-6">
                        <div class="single-membership-table">
                            <div class="membership-header">
                                <h3>Office</h3>
                            </div>

                            <div class="price">$300 <span>/Month</span></div>

                            <p>Proin gravida nibh vel velit auctor aliquet here. Aenean sollicitudin lorem quis bibendum auctor nisi elit consequat ipsum.</p>

                            <ul class="membership-features-list">
                                <li><i class="bx bx-check"></i> Mix of Sitting and Standing Workspaces</li>
                                <li><i class="bx bx-check"></i> 24/7 Access</li>
                                <li><i class="bx bx-check"></i> Coffee, Tea, Snake and Sparkling</li>
                                <li><i class="bx bx-check"></i> Fast Wi-Fi and Prints</li>
                                <li><i class="bx bx-check"></i> Access to Community's Online Member Network</li>
                            </ul>

                            <div class="membership-btn">
                                <a href="events-booking.html" class="default-btn">Book A Tour <i class="bx bxs-chevron-right"></i><span></span></a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- End Membership Area -->

        <!-- Start Testimonial Area -->
        <div class="testimonials-area ptb-100">
            <div class="container">
                <div class="testimonial-slides owl-carousel owl-theme">
                    <div class="testimonial-item">
                        <div class="icon">
                            <i class='bx bxs-quote-right'></i>
                        </div>

                        <p>“Proin gravida nibh vel velit auctor aliquet. Aenean sollicitudin lorem quis bibendum auctor nisi elit consequat ipsum nec Sagittis sem nibh id elit. Duis sed odio sit amet nibh Vulputate cursus a sit amet Mauris.”</p>

                        <div class="info">
                            <h3>Thomas Medison</h3>
                            <span>UI/UX Designer</span>
                        </div>
                    </div>

                    <div class="testimonial-item">
                        <div class="icon">
                            <i class='bx bxs-quote-right'></i>
                        </div>

                        <p>“Proin gravida nibh vel velit auctor aliquet. Aenean sollicitudin lorem quis bibendum auctor nisi elit consequat ipsum nec Sagittis sem nibh id elit. Duis sed odio sit amet nibh Vulputate cursus a sit amet Mauris.”</p>

                        <div class="info">
                            <h3>Sarah Taylor</h3>
                            <span>Web Developer</span>
                        </div>
                    </div>

                    <div class="testimonial-item">
                        <div class="icon">
                            <i class='bx bxs-quote-right'></i>
                        </div>

                        <p>“Proin gravida nibh vel velit auctor aliquet. Aenean sollicitudin lorem quis bibendum auctor nisi elit consequat ipsum nec Sagittis sem nibh id elit. Duis sed odio sit amet nibh Vulputate cursus a sit amet Mauris.”</p>

                        <div class="info">
                            <h3>Richard Turner</h3>
                            <span>Web Designer</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- End Testimonial Area -->

        <!-- Start Subscribe Area -->
        <div class="subscribe-area ptb-100">
            <div class="container">
                <div class="subscribe-content-box">
                    <div class="title">
                        <h2>Never Miss a Coworking Update</h2>
                        <p>Lorem ipsum dolor sit amet consetetur sadipscing elitr sed diam nonumy eirmod tempor invidunt ut labore et dolore magna aliquyam erat sed diam voluptua.</p>
                    </div>

                    <form class="newsletter-form" method="POST"  action="{{url('subscribe')}}" enctype="multipart/form-data">
                        {!! csrf_field() !!}
                        <div class="row">
                            <div class="col-lg-9 col-md-6">
                                <input type="email" class="input-newsletter" placeholder="Enter Your Email" name="email" required autocomplete="off">
                            </div>

                            <div class="col-lg-3 col-md-6">
                                <button type="submit">Sign Me Up!</button>

                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <!-- End Subscribe Area -->

        <!-- Start Blog Area -->
        <div class="blog-area pt-100 pb-70">
            <div class="container">
                <div class="section-title">
                    <span>Latest Blog</span>
                    <h2>Read up on Latest Office Updates with Spurf Coworking</h2>
                </div>

                <div class="row justify-content-center">
                    @if(!empty($recent_blogs))

                        <div class="row justify-content-center">
                            @foreach ($recent_blogs as $recent_blog)
                            <div class="col-lg-4 col-md-6">
                                <div class="single-blog">
                                    <div class="blog-image">
                                        <a href="{{route('blog.details',encrypted_key($recent_blog->id,"encrypt"))}}">

                                            @if(file_exists( storage_path().'/blog/'.$recent_blog->image ) && !empty($recent_blog->image))
                                            <img src="{{asset('storage')}}/blog/{{ $recent_blog->image }}" class="img-responsive" alt="...">
                                            @else
                                            <img class="img-fluid" src="{{ asset('assets/img/blog/blog-thumb-01.jpg') }}" class="img-responsive" alt="">
                                            @endif

                                        </a>

                                        <div class="tag"><a href="{{route('blog.details',encrypted_key($recent_blog->id,"encrypt"))}}">{{$recent_blog->tags}}</a></div>
                                    </div>

                                    <div class="blog-content">
                                        <ul class="entry-meta">
                                            <li>
                                                <i class='bx bx-time'></i>
                                                {{date('F d, Y', strtotime($recent_blog->created_at))}}
                                            </li>
                                            {{-- <li>
                                                <i class='bx bxs-user'></i>
                                                <a href="#">By Admin</a>
                                            </li> --}}
                                        </ul>

                                        <h3>
                                            <a href="{{route('blog.details',encrypted_key($recent_blog->id,"encrypt"))}}">{{$recent_blog->title}}</a>
                                        </h3>
                                        <div class="blog-btn">
                                            <a href="{{route('blog.details',encrypted_key($recent_blog->id,"encrypt"))}}" class="default-btn">Read More <i class='bx bxs-chevron-right'></i><span></span></a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            @endforeach
                        </div>

                @endif




                </div>
            </div>
        </div>
        <!-- End Blog Area -->
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
        <footer class="footer-area pt-100">
            <div class="container">
                <div class="row">
                    <div class="col-lg-3 col-sm-6">
                        <div class="single-footer-widget">
                            <div class="widget-logo">
                                <a href="index.html">
                                    @if (!empty($logo_favicon['logo']))
                                        <img src="{{ asset('storage/logo').'/'.$logo_favicon['logo'] }}" >
                                    @else
                                        <img src="{{ asset('assets/main/images/logo.png')}}">
                                    @endif
                                </a>
                            </div>
                            <p>Proin gravida nibh vel velit auctor aliquet. Aenean sollicitudin lorem quis bibendum auctor nisi elit consequat ipsum thnec sagittis sem nibh id elit.</p>

                            <ul class="widget-info">
                                <li>
                                    <i class='bx bxs-phone'></i>
                                    <a href="tel:0023567890">+00 234 567 890</a>
                                </li>

                                <li>
                                    <i class='bx bx-envelope-open'></i>
                                    <a href="mailto:spurf@gmail.com">spurf@gmail.com</a>
                                </li>
                            </ul>
                        </div>
                    </div>

                    <div class="col-lg-3 col-sm-6">
                        <div class="single-footer-widget">
                            <h3>Our Company</h3>

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

                    <div class="col-lg-3 col-sm-6">
                        <div class="single-footer-widget">
                            <h3>Our Services</h3>

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
                            <h3>All Support</h3>

                            <ul class="footer-links-list">
                                <li><a href="services-details.html">Help Desk</a></li>
                                <li><a href="events-booking.html">Book A Tour</a></li>
                                <li><a href="contact.html">Know Us</a></li>
                                <li><a href="services-details.html">Virtual Office</a></li>
                            </ul>

                            <ul class="widget-social">
                                <li>
                                    <a href="https://twitter.com/?lang=en" target="_blank">
                                        <i class='bx bxl-twitter'></i>
                                    </a>
                                </li>
                                <li>
                                    <a href="https://www.facebook.com/" target="_blank">
                                        <i class='bx bxl-facebook'></i>
                                    </a>
                                </li>
                                <li>
                                    <a href="https://www.instagram.com/" target="_blank">
                                        <i class='bx bxl-instagram-alt'></i>
                                    </a>
                                </li>
                                <li>
                                    <a href="https://www.linkedin.com/" target="_blank">
                                        <i class='bx bxl-linkedin'></i>
                                    </a>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>

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
        </footer>
        <!-- End Footer Area -->

        <!-- Start Go Top Area -->
        <div class="go-top">
            <i class='bx bx-chevron-up'></i>
        </div>
        <!-- End Go Top Area -->
@endsection
