@extends('layout.frontend.home16.mainlayout')
@section('content')
<style>
       .not-checked{
        color: #C4C4C4;
    }
</style>
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
    <!-- preloader area start -->
    <div class="preloader" id="preloader">
        <div class="preloader-inner">
            <div class="spinner">
                <div class="dot1"></div>
                <div class="dot2"></div>
            </div>
        </div>
    </div>
    <!-- preloader area end -->

    <!-- search popup start-->
    <div class="td-search-popup" id="td-search-popup">
        <form action="index.html" class="search-form">
            <div class="form-group">
                <input type="text" class="form-control" placeholder="Search.....">
            </div>
            <button type="submit" class="submit-btn"><i class="fa fa-search"></i></button>
        </form>
    </div>
    <!-- search popup end-->
    <div class="body-overlay" id="body-overlay"></div>

    <!-- navbar start -->
    <div class="navbar-area">
        <!-- navbar top start -->
        <div class="navbar-top">
            <div class="container">
                <div class="row">
                    <div class="col-6 align-self-center text-md-left text-center">
                        <ul>
                            <li><a href="about.html">About</a></li>
                            <li><a href="contact.html">Support</a></li>
                            <li class="d-none d-md-inline-block"><p><i class="fa fa-envelope-o"></i>  info@website.com</p></li>
                        </ul>
                    </div>
                    <div class="col-6">
                        <ul class="text-right">
                            <li class="d-lg-inline-block d-none"><p><i class="fa fa-info-circle"></i> Become An Instructor</p></li>
                            <li class="d-lg-inline-block d-none"><p><i class="fa fa-briefcase"></i> For Business</p></li>
                            {{-- <li><p class="add-to-cart-icon">My Cart <i class="fa fa-cart-arrow-down ml-2"></i> <span class="count">0</span></p></li> --}}
                        </ul>
                    </div>
                </div>
            </div>
        </div>
        <nav class="navbar navbar-area-1 navbar-area navbar-expand-lg">
            <div class="container nav-container">
                <div class="responsive-mobile-menu">
                    <button class="menu toggle-btn d-block d-lg-none" data-target="#edumint_main_menu"
                    aria-expanded="false" aria-label="Toggle navigation">
                        <span class="icon-left"></span>
                        <span class="icon-right"></span>
                    </button>
                </div>
                <div class="logo">
                    <a href="/">
                        @if (!empty($logo_favicon['logo']))
                        <img src="{{ asset('storage/logo').'/'.$logo_favicon['logo'] }}"alt="LogoImage" >
                    @else
                  @if(!empty($logoTxt)) {{ $logoTxt }} @else Your Logo Here @endif
                    @endif
                    </a>
                </div>
                <div class="nav-left-part nav-right-part-desktop">

                </div>
                <div class="nav-right-part nav-right-part-mobile">

                </div>
                <div class="collapse navbar-collapse" id="edumint_main_menu">
                    <ul class="navbar-nav menu-open">
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
                </div>
                <div class="nav-right-part nav-right-part-desktop style-white">
                    <ul class="mb-0">
                        @guest

                                    @if ($donation = \App\PublicPageDetail::where('user_id',get_domain_user()->id)->first())
                                        @php $dId = base64_encode($donation->id);
                                        $user_setting = DB::table('website_setting')->where('user_domain_id', get_domain_id())->where('name', 'payment_settings')->first();
                                    @endphp
                                        @if($user_setting != null)
                                        <li class="ml-2">   <a  class="btn btn-red" href='{{ url("$dId/donation")}}'>Donate</a></li>
                                            @endif
                                    @endif
                                    <li class="ml-2">    <a  class="btn btn-red" href="{{ route('login') }}">log In</a></li>



                                @else
                                <li class="ml-2"> <a  class="btn btn-red" href="{{ route('home') }}">Dashboard</a></li>

                        @endguest


                    </ul>
                </div>
            </div>
        </nav>
    </div>
    <!-- navbar end -->

    <!-- banner start -->
    <div class="banner-area banner-area-1 banner-bg-overlay" style="background-image: url({{ asset('assets/home16/img/banner/1.png')}})">
        <div class="container">
            <div class="row">
                <div class="col-xl-6 col-lg-7">
                    <div class="banner-inner style-white text-center text-lg-left">
                        <h6 class="al-animate-1 sub-title">Save over <span>30%</span> in paid courses</h6>
                        <h1 class="al-animate-2 title">Empower yourself from 20k+ courses</h1>
                        <p class="al-animate-3">Macstudy is by far the most anticipated and most requested online course among our learners.</p>
                        <a class="btn btn-base al-animate-4" href="{{route('search.courses')}}">All Courses</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- banner end -->

    <!-- counter area start -->
    <div class="counter-area">
        <div class="container">
            <div class="row">
                <div class="col-lg-4">
                    <div class="single-quote-inner">
                        <div class="thumb text-right">
                            <img src="{{ asset('assets/home16/img/about/1.png')}}" alt="img">
                        </div>
                        <div class="details">
                            <h4>Access 2500+ Online Courses from 140 Institutions</h4>
                        </div>
                    </div>
                </div>
                <div class="col-lg-8 pd-top-90">
                    <div class="row">
                        <div class="col-md-4">
                            <div class="single-counter-inner after-bg">
                                <div class="media">
                                    <div class="media-left">
                                        <div class="thumb">
                                            <img src="{{ asset('assets/home16/img/icon/1.png')}}" alt="img">
                                        </div>
                                    </div>
                                    <div class="media-body">
                                        <div class="details">
                                            <h2><span class="counter">89</span>K+</h2>
                                            <p>Online Learners</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="single-counter-inner after-bg">
                                <div class="media">
                                    <div class="media-left">
                                        <div class="thumb">
                                            <img src="{{ asset('assets/home16/img/icon/2.png')}}" alt="img">
                                        </div>
                                    </div>
                                    <div class="media-body">
                                        <div class="details">
                                            <h2><span class="counter">43</span>K+</h2>
                                            <p>Earned Certificate</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="single-counter-inner after-bg">
                                <div class="media">
                                    <div class="media-left">
                                        <div class="thumb">
                                            <img src="{{ asset('assets/home16/img/icon/3.png')}}" alt="img">
                                        </div>
                                    </div>
                                    <div class="media-body">
                                        <div class="details">
                                            <h2><span class="counter">35</span>K+</h2>
                                            <p>Career Benifitited</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="block-area">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="single-block-inner" style="background-image: url({{ asset('assets/home16/img/other/1.png')}});">
                                    <div class="cat">Most Recent</div>
                                    <span>SCHOOL OF</span>
                                    <h4>Programming</h4>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="single-block-inner" style="background-image: url({{ asset('assets/home16/img/other/2.png')}});">
                                    <div class="cat">Most Recent</div>
                                    <span>SCHOOL OF</span>
                                    <h4>Data Science</h4>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- counter end -->

    <!-- intro area start -->
    <div class="intro-area pd-top-90">
        <div class="container">
            <div class="section-title text-center">
                <h5 class="sub-title">Course Categories</h5>
                <h2 class="title">Explore our top categories</h2>
            </div>
            <div class="row">
                <div class="col-lg-3 col-md-3 col-sm-6">
                    <div class="single-intro-inner bg-red style-two text-center">
                        <div class="thumb cat-thumb">
                            <img src="{{ asset('assets/home16/img/intro/1.png')}}" alt="img">
                        </div>
                        <div class="details">
                            <h5><a href="course.html">Business</a></h5>
                            <span>11 Courses</span>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 col-md-3 col-sm-6">
                    <div class="single-intro-inner bg-blue style-two text-center">
                        <div class="thumb cat-thumb">
                            <img src="{{ asset('assets/home16/img/intro/2.png')}}" alt="img">
                        </div>
                        <div class="details">
                            <h5><a href="course.html">Labratory</a></h5>
                            <span>17 Courses</span>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 col-md-3 col-sm-6">
                    <div class="single-intro-inner bg-base style-two text-center">
                        <div class="thumb cat-thumb">
                            <img src="{{ asset('assets/home16/img/intro/3.png')}}" alt="img">
                        </div>
                        <div class="details">
                            <h5><a href="course.html">Medical</a></h5>
                            <span>22 Courses</span>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 col-md-3 col-sm-6">
                    <div class="single-intro-inner bg-purple style-two text-center">
                        <div class="thumb cat-thumb">
                            <img src="{{ asset('assets/home16/img/intro/4.png')}}" alt="img">
                        </div>
                        <div class="details">
                            <h5><a href="course.html">Teaching</a></h5>
                            <span>31 Courses</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- intro area end -->

    <!-- about area start -->
    <div class="about-area pd-top-90 pd-bottom-90">
        <div class="container">
            <div class="row">
                <div class="col-lg-6">
                    <div class="row">
                        <div class="col-sm-6 mt-lg-5">
                            <div class="thumb about-thumb  wow animated zoomIn" data-wow-duration="0.8s" data-wow-delay="0.1s">
                                <img src="{{ asset('assets/home16/img/about/4.png')}}" alt="img">
                            </div>
                            <div class="thumb about-thumb  wow animated zoomIn" data-wow-duration="0.8s" data-wow-delay="0.2s">
                                <img src="{{ asset('assets/home16/img/about/6.png')}}" alt="img">
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="thumb about-thumb  wow animated zoomIn" data-wow-duration="0.8s" data-wow-delay="0.3s">
                                <img src="{{ asset('assets/home16/img/about/5.png')}}" alt="img">
                            </div>
                            <div class="thumb about-thumb  wow animated zoomIn" data-wow-duration="0.8s" data-wow-delay="0.4s">
                                <img src="{{ asset('assets/home16/img/about/7.png')}}" alt="img">
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-6 align-self-center mt-4 mt-lg-0">
                    <div class="section-title style-bg mb-0">
                        <h5 class="sub-title">Who we are</h5>
                        <h2 class="title">The leading platform for learning courses</h2>
                        <p class="content">You can start and finish one of these popular courses in under a day - for free! Check out the list below.. </p>
                        <div class="single-list-inner mt-4">
                            <ul>
                                <li><i class="fa fa-check"></i> Access to 4,000+ of our top courses</li>
                                <li><i class="fa fa-check"></i> Explore a variety of fresh topics</li>
                                <li><i class="fa fa-check"></i> Find the right instructor for you </li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- about area end -->

    <!-- call to action area start -->
    <div class="call-to-action-area bg-cover pd-top-110 pd-bottom-120" style="background-image: url({{ asset('assets/home16/img/other/3.png')}})">
        <div class="container">
            <div class="row">
                <div class="col-xl-7 col-lg-10">
                    <div class="section-title mb-0 style-white">
                        <h2 class="title">Practical Project Management from University of Glasgow </h2>
                        <a class="btn btn-black" href="course.html">Find Out More</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- call to action area start -->

    <!--course-area start-->
    <div class="course-area pd-top-115 pd-bottom-90">
        <div class="container">
            <div class="section-title text-center">
                <h5 class="sub-title">Featured Courses</h5>
                <h2 class="title">Explore featured courses</h2>
            </div>

            @php
                  $build_query =  DB::table('certifies')
                    ->select('certifies.*', 'show_syndicate.id as show_syndicateemail ,show_syndicate.certify_id ')
                    ->leftJoin('show_syndicate', 'show_syndicate.certify_id', '=', 'certifies.id')
                    ->where('status', '=', 'Published')
                    //->where('certifies.domain_id','=',get_domain_id())
                    ->where('certifies.domain_id','=',1)
                   // ->Orwhere('show_syndicate.domain_id','=', get_domain_id())
                    ->Orwhere('show_syndicate.domain_id','=', 1)
                    ->groupBy('certifies.id')->take(6)->get();

            @endphp
            <div class="row justify-content-center">
                @if(!empty($build_query))
                    @foreach ($build_query as $row)
                        @php
                            $instructor_id=explode(',',$row->instructor);
                            $instructor=\App\Instructor::getInstructordata($instructor_id[0]);
                        @endphp
                            <div class="col-lg-4 col-md-6">
                                <div class="single-course-inner">
                                    <div class="thumb">
                                        @if(file_exists( storage_path().'/certify/'.$row->image)  && !empty($row->image))
                                            <img src="{{asset('storage')}}/certify/{{ $row->image }}" alt="" class="img-fluid w-100">
                                         @else
                                            <img src="{{asset('assets/img/course/c8.jpg')}}" alt="" class="img-fluid w-100">
                                        @endif

                                        <div class="cat-area">
                                            <a class="cat bg-base" href="{{route('course.details',['id'=>encrypted_key($row->id,'encrypt')])}}"> {{substr((!empty($row->category) && !empty(getCategoryName($row->category)) ? getCategoryName($row->category) :'No category'),0,4)}}..</a>

                                        </div>
                                    </div>
                                    <div class="details">
                                        <span >@if(!empty($row->sale_price))
                                            ${{$row->sale_price}} / <strike>${{$row->price}}</strike>
                                            @elseif(!empty($row->price))
                                            ${{$row->price}}
                                            @else
                                            Free
                                            @endif</span>

                                        <div class="details-inner">
                                            <h5><a href="{{route('course.details',['id'=>encrypted_key($row->id,'encrypt')])}}">{!! html_entity_decode(ucfirst(substr($row->name,0,14)), ENT_QUOTES, 'UTF-8') !!}..</a></h5>
                                            <div class="author media">
                                                <div class="media-left">
                                                    <img src="{{$instructor->avatar}}" alt="img">
                                                </div>
                                                <div class="media-body align-self-center">
                                                    <a href="{{route('profile',['id'=>encrypted_key($instructor->id,'encrypt')])}}"><p>{{$instructor->name}}</p></a>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="bottom-area">
                                            <div class="row">
                                                <div class="col-6 align-self-center">
                                                    <div class="">
                                                        @for($i=1;$i<=5;$i++)
                                                <i class="fa fa-star @if($i<=$instructor->average_rating) checked @else not-checked @endif "></i>

                                        @endfor
                                                    </div>
                                                </div>
                                                <div class="col-6 align-self-center text-right">
                                                    <a class="readmore-text" href="{{route('course.details',['id'=>encrypted_key($row->id,'encrypt')])}}">Read More</a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    @endif

            </div>
        </div>
    </div>
    <!--course-area end-->

    <!-- counter start -->
    <div class="counter-area jarallax pd-top-120 pd-bottom-120" style="background-image: url({{ asset('assets/home16/img/bg/1.png')}});">
        <div class="container">
            <div class="row">
                <div class="col-xl-6 col-lg-7 align-self-center">
                    <div class="section-title style-white text-center">
                        <h2 class="title mb-3">Register Now</h2>
                        <h6 class="small-title-color">Get premium online courses for free!</h6>
                        <p class="content">You can start and finish one of these popular courses in under a day - for free! Check out the list below.. </p>
                    </div>
                    <div class="countdown-inner text-center">
                        <div class="countdown"></div>
                    </div>
                </div>
                <div class="col-lg-5 offset-xl-1">
                    <div class="fill-up-form-inner mt-3 mt-lg-0">
                        <div class="header text-center">Fill The From Now</div>
                        <form method="post" action="{{route('contact_us')}}" enctype="multipart/form-data">
                            {!! csrf_field() !!}
                            <div class="details">
                                <label class="single-input-inner style-bg">
                                    <input type="text" name="name" required placeholder="Full Name">
                                </label>
                                <label class="single-input-inner style-bg">
                                    <input  type="email" name="email" class="form-control" id="email" placeholder="Email *" required="required">
                                </label>
                                <label class="single-input-inner style-bg">
                                    <input type="text" name="subject" class="form-control" id="subject" placeholder="Subject *" required="required">
                                </label>
                                <label class="single-input-inner style-bg">
                                    <textarea rows="8" name="message" class="form-control" id="description" placeholder="Your Message Here ..." required="required"></textarea>
                                </label>
                                <button  type="submit" class="btn btn-red w-100">Send Message</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- counter end -->

    <!--team-area start-->
    <div class="team-area pd-top-115 pd-bottom-60">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <div class="section-title text-center">
                        <h5 class="sub-title">Featured Teacher</h5>
                        <h2 class="title">Weekly featured Teacher</h2>
                    </div>
                </div>
            </div>
            <div class="row justify-content-center">
                <div class="col-lg-4 col-md-6">
                    <div class="single-team-inner">
                        <div class="thumb">
                            <img src="{{ asset('assets/home16/img/team/1.png')}}" alt="img">
                        </div>
                        <div class="details pt-5">
                            <ul class="team-social-media">
                                <li>
                                    <a href="#"><i class="fa fa-facebook" aria-hidden="true"></i></a>
                                </li>
                                <li>
                                    <a href="#"><i class="fa fa-twitter" aria-hidden="true"></i></a>
                                </li>
                                <li>
                                    <a href="#"><i class="fa fa-instagram" aria-hidden="true"></i></a>
                                </li>
                                <li>
                                    <a href="#"><i class="fa fa-pinterest" aria-hidden="true"></i></a>
                                </li>
                            </ul>
                            <h5><a href="single-team.html">Maria Helen</a> <span>  -  Mathmetics</span></h5>
                            <p><i class="fa fa-user"></i>  100+ Courses  </p>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4 col-md-6">
                    <div class="single-team-inner">
                        <div class="thumb">
                            <img src="{{ asset('assets/home16/img/team/2.png')}}" alt="img">
                        </div>
                        <div class="details pt-5">
                            <ul class="team-social-media">
                                <li>
                                    <a href="#"><i class="fa fa-facebook" aria-hidden="true"></i></a>
                                </li>
                                <li>
                                    <a href="#"><i class="fa fa-twitter" aria-hidden="true"></i></a>
                                </li>
                                <li>
                                    <a href="#"><i class="fa fa-instagram" aria-hidden="true"></i></a>
                                </li>
                                <li>
                                    <a href="#"><i class="fa fa-pinterest" aria-hidden="true"></i></a>
                                </li>
                            </ul>
                            <h5><a href="single-team.html">Andrew Helper</a> <span>  -  Marketor</span></h5>
                            <p><i class="fa fa-user"></i>  210+ Courses  </p>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4 col-md-6">
                    <div class="single-team-inner">
                        <div class="thumb">
                            <img src="{{ asset('assets/home16/img/team/3.png')}}" alt="img">
                        </div>
                        <div class="details pt-5">
                            <ul class="team-social-media">
                                <li>
                                    <a href="#"><i class="fa fa-facebook" aria-hidden="true"></i></a>
                                </li>
                                <li>
                                    <a href="#"><i class="fa fa-twitter" aria-hidden="true"></i></a>
                                </li>
                                <li>
                                    <a href="#"><i class="fa fa-instagram" aria-hidden="true"></i></a>
                                </li>
                                <li>
                                    <a href="#"><i class="fa fa-pinterest" aria-hidden="true"></i></a>
                                </li>
                            </ul>
                            <h5><a href="single-team.html">Dipa Helen</a> <span>  -  Development</span></h5>
                            <p><i class="fa fa-user"></i>  180+ Courses  </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!--team-area end-->

    <!--event-area start-->
    <div class="event-area mg-bottom-120">
        <div class="container">
            <div class="row no-gutters">
                <div class="col-xl-7 col-lg-6 bg-overlay bg-cover" style="background-image: url({{ asset('assets/home16/img/other/4.png')}});">
                    <div class="event-section-title">
                        <div class="section-title mb-0 pt-xl-5 style-white">
                            <h5 class="sub-title">Latest Events</h5>
                            <h2 class="title">Book your sit on going latest events</h2>
                            <a class="btn btn-border-white" href="event.html">All Events</a>
                        </div>
                    </div>
                </div>
                <div class="col-xl-5 col-lg-6">
                    <div class="event-area-inner bg-base">
                        <div class="single-event-inner style-white">
                            <div class="media">
                                <div class="media-left">
                                    <i class="fa fa-users"></i>
                                    <div class="thumb">
                                        <img src="{{ asset('assets/home16/img/event/1.png')}}" alt="img">
                                    </div>
                                </div>
                                <div class="details media-body align-self-center">
                                    <div class="date"><i class="fa fa-calendar"></i> 09 Dec, 2021</div>
                                    <p class="location"><i class="fa fa-map-marker"></i>New york grand city 1247</p>
                                    <h5><a href="single-event.html">Conference for reducing global warming</a></h5>
                                </div>
                            </div>
                        </div>
                        <div class="single-event-inner style-white mb-0">
                            <div class="media">
                                <div class="media-left">
                                    <i class="fa fa-users"></i>
                                    <div class="thumb">
                                        <img src="{{ asset('assets/home16/img/event/2.png')}}" alt="img">
                                    </div>
                                </div>
                                <div class="details media-body align-self-center">
                                    <div class="date"><i class="fa fa-calendar"></i> 2 Dec, 2021</div>
                                    <p class="location"><i class="fa fa-map-marker"></i>New york grand city 1247</p>
                                    <h5><a href="single-event.html">Global Conference for reducing warming</a></h5>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!--event-area end-->

    <!-- testimonial section start -->
    <div class="testimonial-area bg-gray pd-top-115 pd-bottom-120">
        <div class="container-fluid">
            <div class="row justify-content-center">
                <div class="col-xl-8 col-lg-10 col-md-11">
                    <div class="section-title text-center">
                        <h5 class="sub-title">Peoples Testimonial</h5>
                        <h2 class="title">What peoples say about us</h2>
                    </div>
                </div>
            </div>
            <div class="row justify-content-center">
                <div class="col-12">
                    <div class="testimonial-slider slider-control-dots owl-carousel">
                        <div class="item">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="testimonial-thumb" style="background-image: url({{ asset('assets/home16/img/testimonial/1.png')}});"></div>
                                </div>
                                <div class="col-md-6">
                                    <div class="testimonial-details">
                                        <img src="{{ asset('assets/home16/img/icon/4.png')}}" alt="img">
                                        <p>I found myself working in a true partnership that results in an incredible experience, and an end product that is the best.</p>
                                        <h5>Alexandra</h5>
                                        <span class="author-meta">Student Language</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="item">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="testimonial-thumb" style="background-image: url({{ asset('assets/home16/img/testimonial/2.png')}});"></div>
                                </div>
                                <div class="col-md-6">
                                    <div class="testimonial-details">
                                        <img src="{{ asset('assets/home16/img/icon/4.png')}}" alt="img">
                                        <p>I found myself working in a true partnership that results in an incredible experience, and an end product that is the best.</p>
                                        <h5>Dies Xandra</h5>
                                        <span class="author-meta">Student Language</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="item">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="testimonial-thumb" style="background-image: url({{ asset('assets/home16/img/testimonial/3.png')}});"></div>
                                </div>
                                <div class="col-md-6">
                                    <div class="testimonial-details">
                                        <img src="{{ asset('assets/home16/img/icon/4.png')}}" alt="img">
                                        <p>I found myself working in a true partnership that results in an incredible experience, and an end product that is the best.</p>
                                        <h5>Aleson</h5>
                                        <span class="author-meta">Student Language</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="item">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="testimonial-thumb" style="background-image: url({{ asset('assets/home16/img/testimonial/1.png')}});"></div>
                                </div>
                                <div class="col-md-6">
                                    <div class="testimonial-details">
                                        <img src="{{ asset('assets/home16/img/icon/4.png')}}" alt="img">
                                        <p>I found myself working in a true partnership that results in an incredible experience, and an end product that is the best.</p>
                                        <h5>Alexandra</h5>
                                        <span class="author-meta">Student Language</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="item">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="testimonial-thumb" style="background-image: url({{ asset('assets/home16/img/testimonial/2.png')}});"></div>
                                </div>
                                <div class="col-md-6">
                                    <div class="testimonial-details">
                                        <img src="{{ asset('assets/home16/img/icon/4.png')}}" alt="img">
                                        <p>I found myself working in a true partnership that results in an incredible experience, and an end product that is the best.</p>
                                        <h5>Dies Xandra</h5>
                                        <span class="author-meta">Student Language</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="item">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="testimonial-thumb" style="background-image: url({{ asset('assets/home16/img/testimonial/3.png')}});"></div>
                                </div>
                                <div class="col-md-6">
                                    <div class="testimonial-details">
                                        <img src="{{ asset('assets/home16/img/icon/4.png')}}" alt="img">
                                        <p>I found myself working in a true partnership that results in an incredible experience, and an end product that is the best.</p>
                                        <h5>Aleson</h5>
                                        <span class="author-meta">Student Language</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="item">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="testimonial-thumb" style="background-image: url({{ asset('assets/home16/img/testimonial/1.png')}});"></div>
                                </div>
                                <div class="col-md-6">
                                    <div class="testimonial-details">
                                        <img src="{{ asset('assets/home16/img/icon/4.png')}}" alt="img">
                                        <p>I found myself working in a true partnership that results in an incredible experience, and an end product that is the best.</p>
                                        <h5>Alexandra</h5>
                                        <span class="author-meta">Student Language</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- testimonial section End -->

    <!--blog-area start-->
    <div class="blog-area pd-top-115 mb-5 pb-3">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-xl-6 col-lg-7 col-md-11">
                    <div class="section-title text-center">
                        <h5 class="sub-title">Latest News</h5>
                        <h2 class="title">Whats going on around you</h2>
                    </div>
                </div>
            </div>
            <div class="row justify-content-center">
                @if(!empty($recent_blogs))
                    @foreach ($recent_blogs as $recent_blog)
                        <div class="col-lg-4 col-md-6">
                            <div class="single-blog-inner">
                                <div class="thumb">
                                    <a href="{{route('blog.details',encrypted_key($recent_blog->id,"encrypt"))}}">
                                        @if(file_exists( storage_path().'/blog/'.$recent_blog->image ) && !empty($recent_blog->image))
                                        <img src="{{asset('storage')}}/blog/{{ $recent_blog->image }}" alt="...">
                                        @else
                                        <img class="img-fluid" src="{{ asset('assets/img/blog/blog-thumb-01.jpg') }}" alt="">
                                        @endif
                                    </a>
                                </div>
                                <div class="details">
                                    <div class="blog-meta">
                                        <ul>
                                            <li class="comnt bg-base">{{$recent_blog->tags}}</li>
                                            <li class="author">By <span>{{ $recent_blog->user->name??'' }}</span></li>
                                            <li class="date"> {{date('F d, Y', strtotime($recent_blog->created_at))}}</li>
                                        </ul>
                                    </div>
                                    <h4><a href="{{route('blog.details',encrypted_key($recent_blog->id,"encrypt"))}}">{{$recent_blog->title}}</a></h4>
                                    <a class="readmore-text" href="{{route('blog.details',encrypted_key($recent_blog->id,"encrypt"))}}">Read More</a>
                                </div>
                            </div>
                        </div>
                    @endforeach
                @endif


            </div>
        </div>
    </div>
    <!--blog-area end-->
    @if(!empty($partners))
        <!--client-area start-->
        <div class="client-area pd-bottom-90">
            <div class="container">
                <div class="row justify-content-center">

                        @foreach($partners as $partner)
                            <div class="col-md-3 col-sm-6 align-self-center">
                                <div class="client-thumb text-center">
                                    <img src="{{asset('storage')}}/partner/{{ $partner->logo }}" alt="">
                                </div>
                            </div>
                        @endforeach


                </div>
            </div>
        </div>
    @endif
    <!--client-area end-->

    <!-- footer area start -->
    <div class="footer-call-to-action">
        <div class="container">
            <div class="call-to-action bg-red">
                <div class="row">
                    <div class="col-xl-7 col-lg-8">
                        <div class="section-title mb-0 style-white">
                            <h2 class="title">Our students come from every country in the world!</h2>
                            <a class="btn btn-black" href="course-single.html">Enroll Today</a>
                        </div>
                    </div>
                    <div class="col-xl-5 col-lg-4 d-none d-lg-block">
                        <div class="thumb" style="background-image: url({{ asset('assets/home16/img/other/5.png')}});"> </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

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
    <footer class="footer-area">
        <div class="footer-top pd-top-115">
            <div class="container">
                <div class="row">
                    <div class="col-lg-4 col-md-6">
                        <div class="widget widget_contact pr-lg-3">
                            <div class="widget-title">
                                <a href="/">

                                    @if (!empty($logo_favicon['logo']))
                                        <img src="{{ asset('storage/logo').'/'.$logo_favicon['logo'] }}" >
                                    @else
                                            <img src="{{ asset('assets/main/images/logo.png')}}">
                                    @endif

                                </a>
                            </div>
                            <ul class="details">
                                <li>You can start and finish one of these popular courses in under a day - for free! Check out the list below.. </li>
                            </ul>
                            <ul class="social-media-2">
                                <li><strong>Follow Us :</strong> </li>
                                <li>
                                    <a href="#"><i class="fa fa-facebook" aria-hidden="true"></i></a>
                                </li>
                                <li>
                                    <a href="#"><i class="fa fa-twitter" aria-hidden="true"></i></a>
                                </li>
                                <li>
                                    <a href="#"><i class="fa fa-instagram" aria-hidden="true"></i></a>
                                </li>
                                <li>
                                    <a href="#"><i class="fa fa-pinterest" aria-hidden="true"></i></a>
                                </li>
                            </ul>
                        </div>
                    </div>
                    <div class="col-lg-2 col-md-6">
                        <div class="widget widget_nav_menu">
                            <h4 class="widget-title">Company</h4>
                            <ul>
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
                    <div class="col-lg-3 col-md-6">
                        <div class="widget widget_nav_menu">
                            <h4 class="widget-title">Categorys</h4>
                            <ul>
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
                    <div class="col-lg-3 col-md-4 col-sm-6 pl-lg-5 pr-5 pr-lg-0">
                        <div class="widget widget_contact pr-lg-3">
                            <h4 class="widget-title">Contact Us</h4>
                            <ul class="details style-icon">
                                <li><i class="fa fa-phone"></i> +91 458 654 528</li>
                            <li><i class="fa fa-envelope"></i> MediiCare@gmail.com</li>
                            <li><i class="fa fa-map-marker"></i> 9WX2+JM Thornton Heath, United Kingdom</li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="footer-bottom">
            <div class="container">
                <div class="row">
                    <div class="col-md-5 align-self-center">
                        <p>{{$footer_text}}</p>
                    </div>

                </div>
            </div>
        </div>
    </footer>
    <!-- footer area end -->

    <!-- back to top area start -->
    <div class="back-to-top">
        <span class="back-top"><i class="fa fa-angle-up"></i></span>
    </div>
    <!-- back to top area end -->

@endsection
