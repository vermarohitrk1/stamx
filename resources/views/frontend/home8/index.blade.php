@extends('layout.frontend.home8.mainlayout')
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
        <!-- Preloader Area -->
        <div class="preloader">
            <div class="d-table">
                <div class="d-table-cell">
                    <div class="lds-default"><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div></div>
                </div>
            </div>
        </div>
        <!-- End Preloader Area -->

        <!-- Heder Area -->
        <header class="header-area fixed-top">
            <!-- Top Header -->
			<div class="top-header">
				<div class="container">
                    <div class="header-content">
                        <div class="row align-items-center">
                            <div class="col-md-4">
                                <div class="location">
                                    <i class="las la-map-marker-alt"></i>
                                    <span>6B, Helventica street, Jordan</span>
                                </div>
                            </div>

                            <div class="col-md-8">
                                <div class="right-alignment">
                                    <ul class="socials-link">
                                        <li>Follow Us :</li>
                                        <li><a href="#"><i class="lab la-facebook-f"></i></a></li>
                                        <li><a href="#"><i class="lab la-twitter"></i></a></li>
                                        <li><a href="#"><i class="lab la-youtube"></i></a></li>
                                        <li><a href="#"><i class="lab la-instagram"></i></a></li>
                                    </ul>

                                    <ul class="flag-area">
                                        <li class="flag-item-top">
                                            <a href="#" class="flag-bar">
                                                <span>Language</span>
                                                <i class="las la-angle-down"></i>
                                            </a>

                                            <ul class="flag-item-bottom">
                                                <li class="flag-item">
                                                    <a href="#" class="flag-link">
                                                        <img src="{{ asset('assets/home8/img/flag/arab.png')}}" alt="Image">
                                                        العربيّة
                                                    </a>
                                                </li>
                                                <li class="flag-item">
                                                    <a href="#" class="flag-link">
                                                        <img src="{{ asset('assets/home8/img/flag/germany.png')}}" alt="Image">
                                                        Deutsch
                                                    </a>
                                                </li>
                                                <li class="flag-item">
                                                    <a href="#" class="flag-link">
                                                        <img src="{{ asset('assets/home8/img/flag/portugal.png')}}" alt="Image">
                                                        󠁥󠁮󠁧󠁿Português
                                                    </a>
                                                </li>
                                                <li class="flag-item">
                                                    <a href="#" class="flag-link">
                                                        <img src="{{ asset('assets/home8/img/flag/china.png')}}" alt="Image">
                                                        简体中文
                                                    </a>
                                                </li>
                                            </ul>
                                        </li>
                                    </ul>

                                    <ul class="search-item">
                                        <li>
                                            <a href="javascript:void(0)" class="search-box">
                                                <i class="las la-search"></i>
                                            </a>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
				</div>
			</div>
			<!-- Start Top Header -->

            <!-- Start Navbar Area -->
            <div class="navbar-area">
                <div class="main-responsive-nav">
                    <div class="container">
                        <div class="main-responsive-menu">
                            <div class="logo">
                                <a href="/" class="text-white">
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
                            <a class="navbar-brand text-white" href="/">
                                @if (!empty($logo_favicon['logo']))
                                    <img src="{{ asset('storage/logo').'/'.$logo_favicon['logo'] }}" alt="LogoImage" >
                                @else

                                    @if(!empty($logoTxt)) {{ $logoTxt }} @else Your Logo Here @endif
                                @endif
                            </a>

                            <div class="collapse navbar-collapse mean-menu" id="navbarSupportedContent">
                                <ul class="navbar-nav ml-auto">
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

                                <div class="others-option d-flex align-items-center">
                                    <div class="option-item">
                                        <div class="support">
                                            <i class="las la-headset"></i>
                                            <p>Contact For Support</p>
                                            <a href="tel:098765434321">0987 6543 4321</a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </nav>
                    </div>
                </div>
            </div>
            <!-- End Navbar Area -->
        </header>
        <!-- End Heder Area -->

        <!-- Search Overlay -->
        <div class="search-overlay">
            <div class="d-table">
                <div class="d-table-cell">
                    <div class="search-overlay-layer"></div>
                    <div class="search-overlay-layer"></div>
                    <div class="search-overlay-layer"></div>

                    <div class="search-overlay-close">
                        <span class="search-overlay-close-line"></span>
                        <span class="search-overlay-close-line"></span>
                    </div>

                    <div class="search-overlay-form">
                        <form>
                            <input type="text" class="input-search" placeholder="Search here...">
                            <button type="submit"><i class='las la-search'></i></button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <!-- End Search Overlay -->


        <!-- Search Overlay -->
        <div class="search-overlay">
            <div class="d-table">
                <div class="d-table-cell">
                    <div class="search-overlay-layer"></div>
                    <div class="search-overlay-layer"></div>
                    <div class="search-overlay-layer"></div>

                    <div class="search-overlay-close">
                        <span class="search-overlay-close-line"></span>
                        <span class="search-overlay-close-line"></span>
                    </div>

                    <div class="search-overlay-form">
                        <form>
                            <input type="text" class="input-search" placeholder="Search here...">
                            <button type="submit"><i class='las la-search'></i></button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <!-- End Search Overlay -->

        <!-- Banner Area -->
        <div class="banner-area">
            <div class="container">
                <div class="banner-slider owl-carousel owl-theme pb-100">
                    <div class="slider-item">
                        <span>Creative Agency</span>
                        <h1>We Are Here To Give You Best Services</h1>
                        <div class="banner-btn">
                            <a href="contact.html" class="default-btn">Contact Us<span></span></a>
                        </div>
                    </div>

                    <div class="slider-item">
                        <span>Creative Agency</span>
                        <h1>We Are Here To Give You Best Solutions</h1>
                        <div class="banner-btn">
                            <a href="contact.html" class="default-btn">Contact Us<span></span></a>
                        </div>
                    </div>
                </div>

                <div class="banner-card-contant">
                    <div class="row">
                        <div class="col-lg-3 col-sm-6">
                            <div class="features-card">
                                <i class="flaticon-market-research marked"></i>
                                <h3>Market Research</h3>
                                <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit.</p>
                                <div class="card-btn">
                                    <a href="#">Read More <i class="las la-arrow-right"></i></a>
                                </div>
                            </div>
                        </div>

                        <div class="col-lg-3 col-sm-6">
                            <div class="features-card">
                                <i class="flaticon-effective marked"></i>
                                <h3>Product Analysis</h3>
                                <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit.</p>
                                <div class="card-btn">
                                    <a href="#">Read More <i class="las la-arrow-right"></i></a>
                                </div>
                            </div>
                        </div>

                        <div class="col-lg-3 col-sm-6">
                            <div class="features-card">
                                <i class="flaticon-testing marked"></i>
                                <h3>Perfect Testing</h3>
                                <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit.</p>
                                <div class="card-btn">
                                    <a href="#">Read More <i class="las la-arrow-right"></i></a>
                                </div>
                            </div>
                        </div>

                        <div class="col-lg-3 col-sm-6">
                            <div class="features-card">
                                <i class="flaticon-creative marked"></i>
                                <h3>Creative Design</h3>
                                <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit.</p>
                                <div class="card-btn">
                                    <a href="#">Read More <i class="las la-arrow-right"></i></a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- End Banner Area -->

        <!-- About Area -->
        <div class="about-area ptb-100">
            <div class="container">
                <div class="row align-items-center">
                    <div class="col-lg-6">
                        <div class="about-img">
                            <div class="video-box">
                                <img src="{{ asset('assets/home8/img/about-1.jpg')}}" alt="image">

                                <a href="hhttps://www.youtube.com/watch?v=bk7McNUjWgw" class="video-btn popup-youtube">
                                    <i class="flaticon-play-video"></i>
                                </a>
                            </div>
                        </div>
                    </div>

                    <div class="col-lg-6">
                        <div class="about-text pl-30">
                            <div class="section-title-two">
                                <span>About Us</span>
                                <h2>We Integrate Intelligent Ideas & Method To Deliver Solutions</h2>
                                <p>There are many variations of passages of Ipsum available, but the majority have suffered alteration in some form, by injected humor, or randomized then words which don't look even slightly believable.</p>
                            </div>

                            <ul>
                                <li>
                                    <i class="las la-check"></i>
                                    Quia voluptas sit aspernatur autodit aut fugit quia cons quntur
                                </li>
                                <li>
                                    <i class="las la-check"></i>
                                    Vitae dicta sunt explicabo nemo enim ipsay voluptatem
                                </li>
                                <li>
                                    <i class="las la-check"></i>
                                    Ipsa quae ab illo inventore veritatis quasi architecto beatae
                                </li>
                                <li>
                                    <i class="las la-check"></i>
                                    Magni dolores eosy qui ratione voluptatem ipsum
                                </li>
                            </ul>
                            <div class="about-btn">
                                <a href="#" class="default-btn">Read More <span></span></a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- End About Area -->

        <!-- Offer Area -->
        <div class="offer-area bg-color pt-100 pb-50">
            <div class="container">
                <div class="section-title">
                    <span>What We Offer</span>
                    <h2>We Integrate Intelligent Ideas  Method</h2>
                    <p>Economics and information technology. This is the main factor that sets us apart from our competition and allows us to grow to deliver a specialist business consultancy service.</p>
                </div>

                <div class="row mt-20">
                    <div class="col-lg-4 col-sm-6">
                        <div class="offer-card bg-1">
                            <i class="flaticon-new bg-white"></i>
                            <h3><a href="services-details.html">New Business Innovation</a></h3>
                            <p>There are many  of passages of Lorem Ipsum available but the majority.</p>
                            <div class="offer-btn">
                                <a href="services-details.html">Explore <i class="las la-arrow-right"></i></a>
                            </div>
                        </div>
                    </div>

                    <div class="col-lg-4 col-sm-6">
                        <div class="offer-card bg-2">
                            <i class="flaticon-seo bg-white"></i>
                            <h3><a href="services-details.html">Web Design and Development</a></h3>
                            <p>There are many  of passages of Lorem Ipsum available but the majority.</p>
                            <div class="offer-btn">
                                <a href="services-details.html">Explore <i class="las la-arrow-right"></i></a>
                            </div>
                        </div>
                    </div>

                    <div class="col-lg-4 col-sm-6">
                        <div class="offer-card bg-3">
                            <i class="flaticon-market-research bg-white"></i>
                            <h3><a href="services-details.html">User Experience and UI Design</a></h3>
                            <p>There are many  of passages of Lorem Ipsum available but the majority.</p>
                            <div class="offer-btn">
                                <a href="services-details.html">Explore <i class="las la-arrow-right"></i></a>
                            </div>
                        </div>
                    </div>

                    <div class="col-lg-4 col-sm-6">
                        <div class="offer-card bg-4">
                            <i class="flaticon-bullhorn bg-white"></i>
                            <h3><a href="services-details.html">Marketing and Branding</a></h3>
                            <p>There are many  of passages of Lorem Ipsum available but the majority.</p>
                            <div class="offer-btn">
                                <a href="services-details.html">Explore <i class="las la-arrow-right"></i></a>
                            </div>
                        </div>
                    </div>

                    <div class="col-lg-4 col-sm-6">
                        <div class="offer-card bg-5">
                            <i class="flaticon-secure bg-white"></i>
                            <h3><a href="services-details.html">Web Security and Support</a></h3>
                            <p>There are many  of passages of Lorem Ipsum available but the majority.</p>
                            <div class="offer-btn">
                                <a href="services-details.html">Explore <i class="las la-arrow-right"></i></a>
                            </div>
                        </div>
                    </div>

                    <div class="col-lg-4 col-sm-6">
                        <div class="offer-card bg-6">
                            <i class="flaticon-stats bg-white"></i>
                            <h3><a href="services-details.html">Search Engine Optimization</a></h3>
                            <p>There are many  of passages of Lorem Ipsum available but the majority.</p>
                            <div class="offer-btn">
                                <a href="services-details.html">Explore <i class="las la-arrow-right"></i></a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- End Offer Area -->

        <!-- Support & team Area -->
        <div class="support-and-team">
            <div class="container-fluid">
                <div class="row no-gutters">
                    <div class="col-lg-6">
                        <div class="best-support">
                            <div class="support-text">
                                <span>Best Support</span>
                                <h2>We Are Innovative and Creative</h2>
                                <div class="support-btn">
                                    <a href="#" class="default-btn">
                                        Get A Consulting
                                        <i class="las la-arrow-right"></i>
                                        <span></span>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-lg-6">
                        <div class="best-support team">
                            <div class="support-text">
                                <span>Experienced Team</span>
                                <h2>We Have Best Experienced Team</h2>
                                <div class="support-btn">
                                    <a href="#" class="default-btn two">
                                        Get A Consulting
                                        <i class="las la-arrow-right"></i>
                                        <span></span>
                                    </a>
                                </div>
                            </div>

                            <div class="shape">
                                <img src="{{ asset('assets/home8/img/shape/shape-15.png')}}" alt="Shape">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- End Support & team Area -->

        <!-- Choose Area -->
        <div class="choose-area pt-100 pb-70">
            <div class="container">
                <div class="choose-content pb-100">
                    <div class="row align-items-center">
                        <div class="col-lg-6">
                            <div class="choose-text">
                                <div class="section-title-two">
                                    <span>Why Choose Us</span>
                                    <h2>We are Hard Worker & Meet Client Needs Ensuring Quality</h2>
                                    <p>You want results. We have found that the best way to get them is with upfront research – of your company, competitors, target market, and customer Only after we fully understand you and your customers.</p>
                                </div>

                                <div class="choose-card">
                                    <i class="flaticon-key-to-success"></i>
                                    <h3>Attention to Details & A Plan for Success</h3>
                                    <p>You want results. We have found that the best way to get them is with upfront research – of your company, competitors, target</p>
                                </div>

                                <div class="choose-card">
                                    <i class="flaticon-data-scientist"></i>
                                    <h3>We are Creative, Experts & Our Flexible Pricing</h3>
                                    <p>There are many variations of passages of Lorem Ipsum available, but the majority have suffered alteration in some form.</p>
                                </div>
                            </div>
                        </div>

                        <div class="col-lg-6">
                            <div class="choose-img">
                                <img src="{{ asset('assets/home8/img/choose.jpg')}}" alt="Image">
                                <div class="caption">
                                    <h3><span class="odometer" data-count="200">00</span>+</h3>
                                    <p>Successful<br> Project</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="fun-fact-content">
                    <div class="row">
                        <div class="col-lg-3 col-sm-6">
                            <div class="fun-fact-card">
                                <div class="count">
                                    <i class="flaticon-project-management"></i>
                                    <h3><span class="odometer" data-count="15">00</span>+</h3>
                                </div>
                                <span class="span">Years of Experience</span>
                                <p>On the other hand, we denounce and  with righteous indignation.</p>
                            </div>
                        </div>

                        <div class="col-lg-3 col-sm-6">
                            <div class="fun-fact-card">
                                <div class="count">
                                    <i class="flaticon-diploma"></i>
                                    <h3><span class="odometer" data-count="40">00</span>+</h3>
                                </div>
                                <span class="span">Master Certification</span>
                                <p>On the other hand, we denounce and  with righteous indignation.</p>
                            </div>
                        </div>

                        <div class="col-lg-3 col-sm-6">
                            <div class="fun-fact-card">
                                <div class="count">
                                    <i class="flaticon-success"></i>
                                    <h3><span class="odometer" data-count="500">00</span>+</h3>
                                </div>
                                <span class="span">Trusted Clients</span>
                                <p>On the other hand, we denounce and  with righteous indignation.</p>
                            </div>
                        </div>

                        <div class="col-lg-3 col-sm-6">
                            <div class="fun-fact-card">
                                <div class="count">
                                    <i class="flaticon-medal"></i>
                                    <h3><span class="odometer" data-count="65">00</span>+</h3>
                                </div>
                                <span class="span">Award Winner</span>
                                <p>On the other hand, we denounce and  with righteous indignation.</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- End Choose Area -->

        <!-- Case Study Area -->
        <div class="case-study-area bg-color pt-100 pb-70">
            <div class="container">
                <div class="section-title">
                    <span>Case Study</span>
                    <h2>Some Recent Projects We Have Done</h2>
                    <p>Economics and information technology. This is the main factor that sets us apart from our competition and allows us to grow to deliver a specialist business consultancy service.</p>
                </div>

                <div class="row">
                    <div class="col-lg-4 col-md-6">
                        <div class="case-study-card">
                            <img src="{{ asset('assets/home8/img/case-study/case-study-1.jpg')}}" alt="Image">
                            <div class="caption">
                                <h3>Product Analysis & Research</h3>
                                <div class="case-study-btn">
                                    <a href="case-study-details.html">Explore <i class="las la-arrow-right"></i></a>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-lg-4 col-md-6">
                        <div class="case-study-card">
                            <img src="{{ asset('assets/home8/img/case-study/case-study-2.jpg')}}" alt="Image">
                            <div class="caption">
                                <h3>New Business<br> Innovation</h3>
                                <div class="case-study-btn">
                                    <a href="case-study-details.html">Explore <i class="las la-arrow-right"></i></a>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-lg-4 col-md-6">
                        <div class="case-study-card">
                            <img src="{{ asset('assets/home8/img/case-study/case-study-3.jpg')}}" alt="Image">
                            <div class="caption">
                                <h3>Digital Marketing & Advertising</h3>
                                <div class="case-study-btn">
                                    <a href="case-study-details.html">Explore <i class="las la-arrow-right"></i></a>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-lg-4 col-md-6">
                        <div class="case-study-card">
                            <img src="{{ asset('assets/home8/img/case-study/case-study-4.jpg')}}" alt="Image">
                            <div class="caption">
                                <h3>UI/UX Design for<br> Ultrajon</h3>
                                <div class="case-study-btn">
                                    <a href="case-study-details.html">Explore <i class="las la-arrow-right"></i></a>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-lg-4 col-md-6">
                        <div class="case-study-card">
                            <img src="{{ asset('assets/home8/img/case-study/case-study-5.jpg')}}" alt="Image">
                            <div class="caption">
                                <h3>Web Development & Design</h3>
                                <div class="case-study-btn">
                                    <a href="case-study-details.html">Explore <i class="las la-arrow-right"></i></a>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-lg-4 col-md-6">
                        <div class="case-study-card">
                            <img src="{{ asset('assets/home8/img/case-study/case-study-6.jpg')}}" alt="Image">
                            <div class="caption">
                                <h3>Data Security &<br> Storage</h3>
                                <div class="case-study-btn">
                                    <a href="case-study-details.html">Explore <i class="las la-arrow-right"></i></a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- End Case Study Area -->

        <!-- Team Area -->
        <div class="team-area pt-100 pb-70">
            <div class="container">
                <div class="section-title">
                    <span>Our Team</span>
                    <h2>Our Expert & Intelligent Team</h2>
                    <p>Economics and information technology. This is the main factor that sets us apart from our competition and allows us to grow to deliver a specialist business consultancy service.</p>
                </div>

                <div class="row">
                    <div class="col-lg-4 col-md-6">
                        <div class="case-study-card">
                            <img src="{{ asset('assets/home8/img/team/team-1.jpg')}}" alt="Image">
                            <div class="caption">
                                <ul class="social-link">
                                    <li><a href="#" target="_blank"><i class="lab la-facebook-f"></i></a></li>
                                    <li><a href="#" target="_blank"><i class="lab la-twitter"></i></a></li>
                                    <li><a href="#" target="_blank"><i class="lab la-youtube"></i></a></li>
                                    <li><a href="#" target="_blank"><i class="lab la-instagram"></i></a></li>
                                </ul>
                                <h3>Mendela Alina</h3>
                                <p>CEO & Founder</p>
                            </div>
                        </div>
                    </div>

                    <div class="col-lg-4 col-md-6">
                        <div class="case-study-card">
                            <img src="{{ asset('assets/home8/img/team/team-2.jpg')}}" alt="Image">
                            <div class="caption">
                                <ul class="social-link">
                                    <li><a href="#" target="_blank"><i class="lab la-facebook-f"></i></a></li>
                                    <li><a href="#" target="_blank"><i class="lab la-twitter"></i></a></li>
                                    <li><a href="#" target="_blank"><i class="lab la-youtube"></i></a></li>
                                    <li><a href="#" target="_blank"><i class="lab la-instagram"></i></a></li>
                                </ul>
                                <h3>Johan Smith</h3>
                                <p>Designer</p>
                            </div>
                        </div>
                    </div>

                    <div class="col-lg-4 col-md-6 offset-md-3 offset-lg-0">
                        <div class="case-study-card">
                            <img src="{{ asset('assets/home8/img/team/team-3.jpg')}}" alt="Image">
                            <div class="caption">
                                <ul class="social-link">
                                    <li><a href="#" target="_blank"><i class="lab la-facebook-f"></i></a></li>
                                    <li><a href="#" target="_blank"><i class="lab la-twitter"></i></a></li>
                                    <li><a href="#" target="_blank"><i class="lab la-youtube"></i></a></li>
                                    <li><a href="#" target="_blank"><i class="lab la-instagram"></i></a></li>
                                </ul>
                                <h3>Smithy Kerny</h3>
                                <p>Manager</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- End Team Area -->

        <!-- Testimonials & FAQ Area -->
        <div class="testimonials-and-faq bg-color">
            <div class="container-fluid">
                <div class="row no-gutters align-items-center">
                    <div class="col-lg-6">
                        <div class="testimonials-content ptb-50">
                            <div class="testimonials-text">
                                <div class="section-title-two">
                                    <span>Testimonials</span>
                                    <h2>The True Measure of Value of Any Business is Performance</h2>
                                </div>

                                <div class="testimonials-slider owl-carousel owl-theme">
                                    <div class="slider-item">
                                        <div class="title">
                                            <h4>Customer Support</h4>
                                        </div>
                                        <div class="rating">
                                            <i class="las la-star"></i>
                                            <i class="las la-star"></i>
                                            <i class="las la-star"></i>
                                            <i class="las la-star"></i>
                                            <i class="las la-star"></i>
                                        </div>
                                        <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud.</p>

                                        <div class="clients">
                                            <img src="{{ asset('assets/home8/img/testimonials/testimonials-1.jpg')}}" alt="Image">
                                            <h3>Johan Mendel</h3>
                                            <span>Manager Of LTd</span>
                                        </div>
                                    </div>

                                    <div class="slider-item">
                                        <div class="title">
                                            <h4>Team Support</h4>
                                        </div>
                                        <div class="rating">
                                            <i class="las la-star"></i>
                                            <i class="las la-star"></i>
                                            <i class="las la-star"></i>
                                            <i class="las la-star"></i>
                                            <i class="las la-star"></i>
                                        </div>
                                        <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud.</p>

                                        <div class="clients">
                                            <img src="{{ asset('assets/home8/img/testimonials/testimonials-2.jpg')}}" alt="Image">
                                            <h3>Mendela Alina</h3>
                                            <span>CEO & Founder</span>
                                        </div>
                                    </div>

                                    <div class="slider-item">
                                        <div class="title">
                                            <h4>Random Support</h4>
                                        </div>
                                        <div class="rating">
                                            <i class="las la-star"></i>
                                            <i class="las la-star"></i>
                                            <i class="las la-star"></i>
                                            <i class="las la-star"></i>
                                            <i class="las la-star"></i>
                                        </div>
                                        <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud.</p>

                                        <div class="clients">
                                            <img src="{{ asset('assets/home8/img/testimonials/testimonials-3.jpg')}}" alt="Image">
                                            <h3>Johan Smith</h3>
                                            <span>Manager</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-lg-6">
                        <div class="faq-content ptb-100">
                            <div class="faq-text">
                                <div class="section-title-two">
                                    <span>Frequently Ask Question</span>
                                    <h2>We are Hard Worker & Meet Client Needs Ensuring Quality</h2>
                                </div>

                                <div class="faq-accordion">
                                    <ul class="accordion">
                                        <li>
                                            <h3 class="title">Web Security  and Data Analysis</h3>
                                            <div class="accordion-content">
                                                <p>There are many variations of passages of Ipsum available, but the majority have suffered alteration in some form, by the injected humor, or randomized words which don't look even here slightly data analysis believable.</p>
                                            </div>
                                        </li>
                                        <li>
                                            <h3 class="title">Market Research and Analysis</h3>
                                            <div class="accordion-content">
                                                <p>There are many variations of passages of Ipsum available, but the majority have suffered alteration in some form, by the injected humor, or randomized words which don't look even here slightly data analysis believable.</p>
                                            </div>
                                        </li>
                                        <li>
                                            <h3 class="title">Web Development and UI Design</h3>
                                            <div class="accordion-content">
                                                <p>There are many variations of passages of Ipsum available, but the majority have suffered alteration in some form, by the injected humor, or randomized words which don't look even here slightly data analysis believable.</p>
                                            </div>
                                        </li>
                                        <li>
                                            <h3 class="title">User Experience</h3>
                                            <div class="accordion-content">
                                                <p>There are many variations of passages of Ipsum available, but the majority have suffered alteration in some form, by the injected humor, or randomized words which don't look even here slightly data analysis believable.</p>
                                            </div>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                            <div class="shape">
                                <img src="{{ asset('assets/home8/img/shape/shape-13.png')}}" alt="Shape">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- End Testimonials & FAQ Area -->

        <!-- Blog Area -->
        <div class="blog-area pt-100 pb-70">
            <div class="container">
                <div class="section-title">
                    <span>News & Blog</span>
                    <h2>Featured News & Blog</h2>
                    <p>Economics and information technology. This is the main factor that sets us apart from our competition and allows us to grow to deliver a specialist business consultancy service.</p>
                </div>

                <div class="row">
                    @if(!empty($recent_blogs))
                        @foreach ($recent_blogs as $recent_blog)
                            <div class="col-lg-4 col-md-6">
                                <div class="blog-card">
                                    <div class="blog-img">
                                        <a href="{{route('blog.details',encrypted_key($recent_blog->id,"encrypt"))}}">
                                            @if(file_exists( storage_path().'/blog/'.$recent_blog->image ) && !empty($recent_blog->image))
                                            <img src="{{asset('storage')}}/blog/{{ $recent_blog->image }}" class="img-responsive" alt="...">
                                            @else
                                            <img class="img-fluid" src="{{ asset('assets/img/blog/blog-thumb-01.jpg') }}" class="img-responsive" alt="">
                                            @endif
                                        </a>
                                        <div class="caption">
                                            {{date('F d, Y', strtotime($recent_blog->created_at))}}
                                        </div>
                                    </div>
                                    <div class="blog-text">
                                        <h3> <a href="{{route('blog.details',encrypted_key($recent_blog->id,"encrypt"))}}">{{$recent_blog->title}}</a></h3>

                                        <div class="blog-btn">
                                            <a href="{{route('blog.details',encrypted_key($recent_blog->id,"encrypt"))}}">Explore <i class="las la-arrow-right"></i></a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforeach
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
        <!-- Footer Area -->
        <div class="footer-area">
            <div class="container">
                <div class="footer-contant pt-100 pb-70">
                    <div class="row">
                        <div class="col-lg-4 col-sm-7">
                            <div class="footer-widget">
                                @if (!empty($logo_favicon['logo']))
                                    <img src="{{ asset('storage/logo').'/'.$logo_favicon['logo'] }}" >
                                @else
                                    <img src="{{ asset('assets/main/images/logo.png')}}">
                                @endif
                                <p>The dedication and the charity work of volunteers from organizations are doing worldwide cannot be underestimated. We cooperateed.</p>

                                <ul class="social-link">
                                    <li><a href="#" target="_blank"><i class="lab la-facebook-f"></i></a></li>
                                    <li><a href="#" target="_blank"><i class="lab la-twitter"></i></a></li>
                                    <li><a href="#" target="_blank"><i class="lab la-youtube"></i></a></li>
                                    <li><a href="#" target="_blank"><i class="lab la-instagram"></i></a></li>
                                </ul>
                            </div>
                        </div>

                        <div class="col-lg-5 col-sm-7">
                            <div class="footer-widget">
                                <h3>Quick Links</h3>
                                <div class="row">
                                    <div class="col-lg-6 col-md-6">
                                        <ul class="widget-list">
                                            @if (count($footerWidget2))
                                                @foreach ($footerWidget2 as $key => $menu)
                                                    @if ($menu)
                                                        <li><i class="las la-angle-right"></i><a href="{{url(str_replace('_','-',$menu))}}" > {{$key}}</a></li>
                                                    @endif
                                                @endforeach
                                            @else

                                            <li><i class="las la-angle-right"></i><a href="">Interative Podcasts</a></li>

                                            <li><i class="las la-angle-right"></i><a href="">Blogs & Whitepapers</a></li>
                                            <li><i class="las la-angle-right"></i><a href="">Conversation Games</a></li>
                                            <li><i class="las la-angle-right"></i><a href="">Labs, Kits & Merch</a></li>
                                            <li><i class="las la-angle-right"></i><a href="">Broadband Benefit </a></li>
                                        @endif
                                        </ul>
                                    </div>
                                    <div class="col-lg-6 col-md-6">
                                        <ul class="widget-list">
                                            @if (count($footerWidget1))
                                                @foreach ($footerWidget1 as $key => $menu)
                                                    @if ($menu)
                                                        <li><i class="las la-angle-right"></i><a href="{{url(str_replace('_','-',$menu))}}"> {{$key}}</a></li>
                                                    @endif
                                                @endforeach
                                            @else
                                                <li><i class="las la-angle-right"></i><a href="">Find Candidates</a></li>
                                                <li><i class="las la-angle-right"></i><a href="">Post a Job</a></li>
                                                <li><i class="las la-angle-right"></i><a href="">Resume Search</a></li>
                                                <li><i class="las la-angle-right"></i><a href="">Impact</a></li>
                                                <li><i class="las la-angle-right"></i><a href="">Staffing</a></li>

                                            @endif
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-lg-3 col-sm-5">
                            <div class="footer-widget">
                                <h3>Contact Info</h3>
                                <ul class="contact-info">
                                    <li>
                                        <i class="las la-map-marker-alt"></i>
                                        6B, Helventica street, Jordan
                                    </li>
                                    <li>
                                        <i class="las la-phone"></i>
                                        <a href="tel:098765434321">0987 6543 4321</a>
                                    </li>
                                    <li>
                                        <i class="las la-envelope"></i>
                                        <a href="ajol@info.com">ajol@info.com</a>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="footer-bottom">
                    <p>Copyright @2020 Ajol. All Rights Reserved <a href="https://hibootstrap.com/">HiBootstrap</a></p>
                </div>
            </div>
        </div>
        <!-- End Footer Area -->

        <!-- GO Top -->
        <div class="go-top">
            <i class="las la-hand-point-up"></i>
        </div>


@endsection
