@extends('layout.frontend.home12.mainlayout')
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

        <!-- Start Main Banner Area -->
        <div class="main-banner-area">
            <div class="main-banner-item">
                <div class="container">
                    <div class="row align-items-center">
                        <div class="col-lg-6">
                            <div class="main-banner-content">
                                <h1>Coworking Space and Office Creative Office Space</h1>
                                <p>Equat ipsum, nec sagittis sem nibh id elit. Duis sed odio sit amet nibh vulputate cursus a sit amet mauris. Morbi accumsan ipsum velit. Nam nec tellus a odio tincidunt auctor.</p>
                            </div>

                            <div class="main-banner-search-form">
                                <form>
                                    <div class="row align-items-center">
                                        <div class="col-lg-5 col-md-5">
                                            <div class="form-group">
                                                <label><i class='bx bx-search'></i></label>
                                                <input type="text" class="form-control" placeholder="Search">
                                            </div>
                                        </div>

                                        <div class="col-lg-4 col-md-4">
                                            <div class="form-group">
                                                <div class="select-box">
                                                    <select>
                                                        <option>Place</option>
                                                        <option>Australia</option>
                                                        <option>Canada</option>
                                                        <option>China</option>
                                                        <option>United Kingdom</option>
                                                        <option>Germany</option>
                                                        <option>France</option>
                                                        <option>Japan</option>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-lg-3 col-md-3">
                                            <div class="submit-btn">
                                                <button type="submit">Search</button>
                                            </div>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>

                        <div class="col-lg-6">
                            <div class="main-banner-image">
                                <img src="{{ asset('assets/home12/images/main-banner/main-banner-1.jpg')}}" alt="image">

                                <a href="https://www.youtube.com/watch?v=ODfy2YIKS1M" class="video-btn popup-youtube">
                                    <i class='bx bx-play-circle'></i>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="main-banner-shape">
                <img src="{{ asset('assets/home12/images/main-banner/banner-shape-1.png')}}" alt="image">
            </div>
        </div>
        <!-- End Main Banner Area -->

        <!-- Start Choose Area -->
        <div class="choose-area-with-image pt-100 pb-70">
            <div class="container">
                <div class="section-title">
                    <span>Why Choose Us</span>
                    <h2>We Offer Creative Working Environments That Suit Your Business</h2>
                </div>

                <div class="row justify-content-center">
                    <div class="col-lg-4 col-sm-6">
                        <div class="single-choose-box">
                            <div class="image">
                                <img src="{{ asset('assets/home12/images/choose/choose-1.png')}}" alt="image">
                            </div>

                            <h3>
                                <a href="services-details.html">Easy to Customize</a>
                            </h3>
                            <p>Proin gravida nibh vel velit auctor aliquet lorem ipsum demi enean sollicitudin.</p>
                        </div>
                    </div>

                    <div class="col-lg-4 col-sm-6">
                        <div class="single-choose-box">
                            <div class="image">
                                <img src="{{ asset('assets/home12/images/choose/choose-2.png')}}" alt="image">
                            </div>

                            <h3>
                                <a href="services-details.html">Creative Coworking Space</a>
                            </h3>
                            <p>Proin gravida nibh vel velit auctor aliquet lorem ipsum demi enean sollicitudin.</p>
                        </div>
                    </div>

                    <div class="col-lg-4 col-sm-6">
                        <div class="single-choose-box">
                            <div class="image">
                                <img src="{{ asset('assets/home12/images/choose/choose-3.png')}}" alt="image">
                            </div>

                            <h3>
                                <a href="services-details.html">Customize Space</a>
                            </h3>
                            <p>Proin gravida nibh vel velit auctor aliquet lorem ipsum demi enean sollicitudin.</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- End Choose Area -->

        <!-- Start Coworking Space Area -->
        <div class="coworking-space-area pt-100 pb-70">
            <div class="container">
                <div class="section-title">
                    <span>Coworking Space</span>
                    <h2>Our Modern Office Spaces Are Simply Stunning & Comfortable</h2>
                </div>

                <div class="row justify-content-center">
                    <div class="col-lg-4 col-md-6">
                        <div class="single-coworking-space with-black-color">
                            <div class="image">
                                <a href="workspaces.html"><img src="{{ asset('assets/home12/images/coworking-space/coworking-1.jpg')}}" alt="image"></a>

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
                        <div class="single-coworking-space with-black-color">
                            <div class="image">
                                <a href="workspaces.html"><img src="{{ asset('assets/home12/images/coworking-space/coworking-2.jpg')}}" alt="image"></a>

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
                        <div class="single-coworking-space with-black-color">
                            <div class="image">
                                <a href="workspaces.html"><img src="{{ asset('assets/home12/images/coworking-space/coworking-3.jpg')}}" alt="image"></a>

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

        <!-- Start Work Area -->
        <div class="work-area">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-lg-6">
                        <div class="work-image"></div>
                    </div>

                    <div class="col-lg-6">
                        <div class="work-content-item">
                            <div class="content-box">
                                <b>Give a Boost On Your Work</b>
                                <h3>Team or Individuals Sustainable Coworking in Your Town</h3>
                                <p>Proin gravida nibh vel velit auctor aliquet. Aenean sollicitudin, lorem quis bibendum auctor, nisi elit consequat ipsum, nec sagittis sem nibh id elit. Duis sed odio sit amet nibh vulputate cursus a sit amet mauris.</p>

                                <div class="row justify-content-center">
                                    <div class="col-lg-4 col-md-4">
                                        <div class="work-fun-fact">
                                            <h4>
                                                <span class="odometer" data-count="3500">00</span>
                                                <span class="sign-icon">m2</span>
                                            </h4>
                                            <p>Coworking Space</p>
                                        </div>
                                    </div>

                                    <div class="col-lg-4 col-md-4">
                                        <div class="work-fun-fact">
                                            <h4>
                                                <span class="odometer" data-count="1890">00</span>
                                                <span class="sign-icon">People</span>
                                            </h4>
                                            <p>Office Amount</p>
                                        </div>
                                    </div>

                                    <div class="col-lg-4 col-md-4">
                                        <div class="work-fun-fact">
                                            <h4>
                                                <span class="odometer" data-count="426">00</span>
                                                <span class="sign-icon">+</span>
                                            </h4>
                                            <p>Available Space Now</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- End Work Area -->

        <!-- Start Features Area -->
        <div class="features-area-two pt-100 pb-70">
            <div class="container">
                <div class="row justify-content-center">
                    <div class="col-lg-3 col-sm-6">
                        <div class="single-box">
                            <a href="services-details.html"><img src="{{ asset('assets/home12/images/features/features-1.png')}}" alt="image"></a>
                            <h3>
                                <a href="services-details.html">Event Space</a>
                            </h3>
                        </div>
                    </div>

                    <div class="col-lg-3 col-sm-6">
                        <div class="single-box">
                            <a href="services-details.html"><img src="{{ asset('assets/home12/images/features/features-2.png')}}" alt="image"></a>
                            <h3>
                                <a href="services-details.html">High Speed Wifi</a>
                            </h3>
                        </div>
                    </div>

                    <div class="col-lg-3 col-sm-6">
                        <div class="single-box">
                            <a href="services-details.html"><img src="{{ asset('assets/home12/images/features/features-3.png')}}" alt="image"></a>
                            <h3>
                                <a href="services-details.html">Customize Space</a>
                            </h3>
                        </div>
                    </div>

                    <div class="col-lg-3 col-sm-6">
                        <div class="single-box">
                            <a href="services-details.html"><img src="{{ asset('assets/home12/images/features/features-4.png')}}" alt="image"></a>
                            <h3>
                                <a href="services-details.html">Snacks & Coffee</a>
                            </h3>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- End Features Area -->

        <!-- Start Membership Area -->
        <div class="membership-area-without-image pb-70">
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

        <!-- Start Team Area -->
        <div class="team-area pt-100 pb-70">
            <div class="container">
                <div class="section-title">
                    <span>Multi-Office Team</span>
                    <h2>Our Modern Office Spaces Are Simply Stunning & Comfortable</h2>
                </div>

                <div class="row justify-content-center">
                    <div class="col-lg-4 col-md-6">
                        <div class="single-team-box">
                            <div class="image">
                                <img src="{{ asset('assets/home12/images/team/team-1.jpg')}}" alt="image">

                                <ul class="social">
                                    <li>
                                        <a href="#" target="_blank">
                                            <i class='bx bxl-facebook'></i>
                                        </a>
                                    </li>
                                    <li>
                                        <a href="#" target="_blank">
                                            <i class='bx bxl-twitter'></i>
                                        </a>
                                    </li>
                                    <li>
                                        <a href="#" target="_blank">
                                            <i class='bx bxl-linkedin'></i>
                                        </a>
                                    </li>
                                    <li>
                                        <a href="#" target="_blank">
                                            <i class='bx bxl-instagram-alt'></i>
                                        </a>
                                    </li>
                                </ul>
                            </div>

                            <div class="content">
                                <h3>Thomas Anthony</h3>
                                <span>Founder & CEO</span>
                            </div>
                        </div>
                    </div>

                    <div class="col-lg-4 col-md-6">
                        <div class="single-team-box">
                            <div class="image">
                                <img src="{{ asset('assets/home12/images/team/team-2.jpg')}}" alt="image">

                                <ul class="social">
                                    <li>
                                        <a href="#" target="_blank">
                                            <i class='bx bxl-facebook'></i>
                                        </a>
                                    </li>
                                    <li>
                                        <a href="#" target="_blank">
                                            <i class='bx bxl-twitter'></i>
                                        </a>
                                    </li>
                                    <li>
                                        <a href="#" target="_blank">
                                            <i class='bx bxl-linkedin'></i>
                                        </a>
                                    </li>
                                    <li>
                                        <a href="#" target="_blank">
                                            <i class='bx bxl-instagram-alt'></i>
                                        </a>
                                    </li>
                                </ul>
                            </div>

                            <div class="content">
                                <h3>Maria Anthony</h3>
                                <span>Marketing Manager</span>
                            </div>
                        </div>
                    </div>

                    <div class="col-lg-4 col-md-6">
                        <div class="single-team-box">
                            <div class="image">
                                <img src="{{ asset('assets/home12/images/team/team-3.jpg')}}" alt="image">

                                <ul class="social">
                                    <li>
                                        <a href="#" target="_blank">
                                            <i class='bx bxl-facebook'></i>
                                        </a>
                                    </li>
                                    <li>
                                        <a href="#" target="_blank">
                                            <i class='bx bxl-twitter'></i>
                                        </a>
                                    </li>
                                    <li>
                                        <a href="#" target="_blank">
                                            <i class='bx bxl-linkedin'></i>
                                        </a>
                                    </li>
                                    <li>
                                        <a href="#" target="_blank">
                                            <i class='bx bxl-instagram-alt'></i>
                                        </a>
                                    </li>
                                </ul>
                            </div>

                            <div class="content">
                                <h3>Jniva Marlay</h3>
                                <span>Lead Developer</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- End Team Area -->

        <!-- Start Review Area -->
        <div class="review-area ptb-100">
            <div class="container">
                <div class="review-slides owl-carousel owl-theme">
                    <div class="row align-items-center">
                        <div class="col-lg-7">
                            <div class="review-item">
                                <div class="review-text">
                                    <p>“Proin gravida nibh vel velit auctor aliquet. Aenean sollicitudin, lorem quis bibendum auctor, nisi elit consequat ipsum, nec sagittis nisi elit consequat ipsum, nec sem nibh id elit. Duis sed odio sit amet nibh vulputate cursus a sit amet mauris.”</p>
                                </div>

                                <div class="review-info">
                                    <h3>Thomas Medison</h3>
                                    <span>UI/UX Designer</span>
                                </div>
                            </div>

                            <div class="review-saying">
                                <h4>See What Other People are Saying</h4>

                                <div class="rating">
                                    <i class='bx bxs-star'></i>
                                    <i class='bx bxs-star'></i>
                                    <i class='bx bxs-star'></i>
                                    <i class='bx bxs-star'></i>
                                    <i class='bx bxs-star'></i>
                                    <a href="#" class="rating-count">4.56 / 5.0</a>
                                </div>

                                <div class="saying-btn">
                                    <a href="about.html" class="default-btn">Read Reviews <i class='bx bxs-chevron-right'></i><span></span></a>
                                </div>
                            </div>
                        </div>

                        <div class="col-lg-5">
                            <div class="review-image">
                                <img src="{{ asset('assets/home12/images/review/review-1.jpg')}}" alt="image">

                                <div class="icon">
                                    <i class='bx bxs-quote-right'></i>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row align-items-center">
                        <div class="col-lg-7">
                            <div class="review-item">
                                <div class="review-text">
                                    <p>“Proin gravida nibh vel velit auctor aliquet. Aenean sollicitudin, lorem quis bibendum auctor, nisi elit consequat ipsum, nec sagittis nisi elit consequat ipsum, nec sem nibh id elit. Duis sed odio sit amet nibh vulputate cursus a sit amet mauris.”</p>
                                </div>

                                <div class="review-info">
                                    <h3>Sarah Taylor</h3>
                                    <span>Web Developer</span>
                                </div>
                            </div>

                            <div class="review-saying">
                                <h4>See What Other People are Saying</h4>

                                <div class="rating">
                                    <i class='bx bxs-star'></i>
                                    <i class='bx bxs-star'></i>
                                    <i class='bx bxs-star'></i>
                                    <i class='bx bxs-star'></i>
                                    <i class='bx bxs-star'></i>
                                    <a href="#" class="rating-count">4.56 / 5.0</a>
                                </div>

                                <div class="saying-btn">
                                    <a href="about.html" class="default-btn">Read Reviews <i class='bx bxs-chevron-right'></i><span></span></a>
                                </div>
                            </div>
                        </div>

                        <div class="col-lg-5">
                            <div class="review-image">
                                <img src="{{ asset('assets/home12/images/review/review-2.jpg')}}" alt="image">

                                <div class="icon">
                                    <i class='bx bxs-quote-right'></i>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row align-items-center">
                        <div class="col-lg-7">
                            <div class="review-item">
                                <div class="review-text">
                                    <p>“Proin gravida nibh vel velit auctor aliquet. Aenean sollicitudin, lorem quis bibendum auctor, nisi elit consequat ipsum, nec sagittis nisi elit consequat ipsum, nec sem nibh id elit. Duis sed odio sit amet nibh vulputate cursus a sit amet mauris.”</p>
                                </div>

                                <div class="review-info">
                                    <h3>Richard Turner</h3>
                                    <span>Web Designer</span>
                                </div>
                            </div>

                            <div class="review-saying">
                                <h4>See What Other People are Saying</h4>

                                <div class="rating">
                                    <i class='bx bxs-star'></i>
                                    <i class='bx bxs-star'></i>
                                    <i class='bx bxs-star'></i>
                                    <i class='bx bxs-star'></i>
                                    <i class='bx bxs-star'></i>
                                    <a href="#" class="rating-count">4.56 / 5.0</a>
                                </div>

                                <div class="saying-btn">
                                    <a href="about.html" class="default-btn">Read Reviews <i class='bx bxs-chevron-right'></i><span></span></a>
                                </div>
                            </div>
                        </div>

                        <div class="col-lg-5">
                            <div class="review-image">
                                <img src="{{ asset('assets/home12/images/review/review-3.jpg')}}" alt="image">

                                <div class="icon">
                                    <i class='bx bxs-quote-right'></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- End Review Area -->

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
@endsection
