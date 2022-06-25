@extends('layout.frontend.home14.mainlayout')
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
<style>
    .subscribe-form button {
        position: absolute;
        content: "";
        right: 5px;
        top: 5px;
    }
        </style>
<header>
    <!-- Main Menu Start -->

    <div class="site-navigation main_menu menu-style-2" id="mainmenu-area">
        <nav class="navbar navbar-expand-lg">
            <div class="container-fluid px-4">
                <a class="navbar-brand" href="/">
                    @if (!empty($logo_favicon['logo']))
                        <img src="{{ asset('storage/logo').'/'.$logo_favicon['logo'] }}"alt="LogoImage" class="img-fluid">
                    @else
                        @if(!empty($logoTxt)) {{ $logoTxt }} @else Your Logo Here @endif
                    @endif
                </a>

                <!-- Toggler -->

                <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarMenu" aria-controls="navbarMenu" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="fa fa-bars"></span>
                </button>

                <!-- Collapse -->
                <div class="collapse navbar-collapse" id="navbarMenu">


                    <ul class="navbar-nav mx-auto">
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

                    <div class="d-flex align-items-center">
                        <div class="header-socials social-links d-none d-lg-none d-xl-block">
                            <a href="#"><i class="fab fa-facebook-f"></i></a>
                            <a href="#"><i class="fab fa-twitter"></i></a>
                            <a href="#"><i class="fab fa-linkedin"></i></a>
                            <a href="#"><i class="fab fa-pinterest"></i></a>
                        </div>

                        <div class="header-login ml-3">
                            @guest

                                    @if ($donation = \App\PublicPageDetail::where('user_id',get_domain_user()->id)->first())
                                        @php $dId = base64_encode($donation->id);
                                        $user_setting = DB::table('website_setting')->where('user_domain_id', get_domain_id())->where('name', 'payment_settings')->first();
                                    @endphp
                                        @if($user_setting != null)
                                           <a class="btn btn-solid-border btn-sm " href='{{ url("$dId/donation")}}'>Donate</a>
                                            @endif
                                    @endif
                                        <a class="btn btn-solid-border btn-sm " href="{{ route('login') }}">log In</a>



                                @else
                                <a class="btn btn-solid-border btn-sm " href="{{ route('home') }}">Dashboard</a>

                        @endguest

                        </div>
                    </div>
                </div> <!-- / .navbar-collapse -->
            </div> <!-- / .container -->
        </nav>
    </div>
</header>




<!-- Banner Section Start -->
<section class="banner-3">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-12 col-xl-8">
                <div class="banner-content text-center">
                    <span class="subheading">Expert instruction</span>
                    <h1><span class="font-weight-normal">It's time to amplify</span> your online Career</h1>

                    <div class="form-banner">
                        <form action="{{route('search.profile')}}" class="form-search-banner">
                            <input type="text" class="form-control" name="search_input" minlength="3" maxlength="50" placeholder="Search Mentor, State, Country, etc">
                            <button type="submit" class="btn btn-main">Search<i class="fa fa-search ml-2"></i> </button>
                        </form>
                    </div>
                </div>
            </div>
        </div> <!-- / .row -->
    </div> <!-- / .container -->
</section>
<!-- Banner Section End -->


<!-- Feature section start -->
<section class="features pt-100">
    <div class="container">
        <div class="row ">
            <div class="col-lg-3 col-md-6 col-xl-3 col-sm-6">
                <div class="feature-item">
                    <div class="feature-icon">
                        <i class="flaticon-flag"></i>
                    </div>
                    <div class="feature-text">
                        <h4>Expert Teacher</h4>
                        <p>Develop skills for career of various majors including computer</p>
                    </div>
                </div>
            </div>
             <div class="col-lg-3 col-md-6 col-xl-3 col-sm-6">
                <div class="feature-item">
                    <div class="feature-icon">
                        <i class="flaticon-layers"></i>
                    </div>
                    <div class="feature-text">
                        <h4>Self Development</h4>
                        <p>Develop skills for career of various majors including computer.</p>
                    </div>
                </div>
            </div>
             <div class="col-lg-3 col-md-6 col-xl-3 col-sm-6">
                <div class="feature-item">
                    <div class="feature-icon">
                        <i class="flaticon-video-camera"></i>
                    </div>
                    <div class="feature-text">
                        <h4>Remote Learning</h4>
                        <p>Develop skills for career of various majors including language</p>
                    </div>
                </div>
            </div>
            <div class="col-lg-3 col-md-6 col-xl-3 col-sm-6">
                <div class="feature-item">
                    <div class="feature-icon">
                        <i class="flaticon-help"></i>
                    </div>
                    <div class="feature-text">
                        <h4>Life Time Support</h4>
                        <p>Develop skills for career of various majors including language  </p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<!-- Feature section End -->
<!-- Course category section start -->
<section class="course-category2 section-padding">
    <div class="container">
        <div class="row align-items-center justify-content-center">
            <div class="col-xl-6 col-lg-6">
                <div class="section-heading pl-5">
                    <span class="subheading">Explore category</span>
                    <h3>Get Instant Access To <span> Expert solution</span></h3>
                    <p class="mb-4">The ultimate planning solution for busy women who want to reach their personal goals.Effortless comfortable eye-catching unique detail.Take the control of their life back and start doing things </p>
                    <a href="#" class="btn btn-main">Explore Category</a>
                </div>
            </div>

            <div class="col-xl-6 col-lg-6 col-sm-12">
                <div class="row ">
                    <div class="col-xl-6 col-lg-6 col-sm-6">
                        <div class="category-imgbox">
                            <div class="thumbnail-img">
                                <img src="{{ asset('assets/home14/images/bg/feature1.png')}}" alt="" class="img-fluid">
                            </div>
                            <div class="category-content">
                                <h5>Web Design</h5>
                                <p>2 Courses</p>
                            </div>
                        </div>
                        <div class="category-imgbox">
                            <div class="thumbnail-img">
                                <img src="{{ asset('assets/home14/images/bg/feature2.png')}}" alt="" class="img-fluid">
                            </div>
                            <div class="category-content">
                                <h5>Business</h5>
                                <p>21 Courses</p>
                            </div>
                        </div>
                    </div>

                     <div class="col-xl-6 col-lg-6 col-sm-6">
                        <div class="category-imgbox mt-5">
                            <div class="thumbnail-img">
                                <img src="{{ asset('assets/home14/images/bg/feature3.png')}}" alt="" class="img-fluid">
                            </div>
                            <div class="category-content">
                                <h5>Marketing</h5>
                                <p>3 Courses</p>
                            </div>
                        </div>
                        <div class="category-imgbox">
                            <div class="thumbnail-img">
                                <img src="{{ asset('assets/home14/images/bg/about-img.jpg')}}" alt="" class="img-fluid">
                            </div>
                            <div class="category-content">
                                <h5>Web Development</h5>
                                <p>2 Courses</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<!-- Course category section End -->
<!-- COunter Section start -->
<section class="counter-block-2 mb--90 position-relative">
    <div class="container">
        <div class="row" >
            <div class="col-xl-12 bg-black counter-inner">
                <div class="row">
                    <div class="col-lg-3 col-md-6 col-sm-6">
                        <div class="counter-item text-center">
                            <i class="flaticon-video-camera"></i>
                            <div class="count">
                                <span class="counter">90</span>
                            </div>
                            <h6>Instructors</h6>
                        </div>
                    </div>
                    <div class="col-lg-3 col-md-6 col-sm-6">
                        <div class="counter-item text-center">
                            <i class="flaticon-layers"></i>
                            <div class="count">
                                <span class="counter">1450</span>
                            </div>
                            <h6>Total Courses</h6>
                        </div>
                    </div>

                    <div class="col-lg-3 col-md-6 col-sm-6">
                        <div class="counter-item text-center">
                            <i class="flaticon-flag"></i>
                            <div class="count">
                                <span class="counter">5697</span>
                            </div>
                            <h6>Registered Enrolls</h6>
                        </div>
                    </div>

                    <div class="col-lg-3 col-md-6 col-sm-6">
                        <div class="counter-item text-center border-0">
                            <i class="flaticon-help"></i>
                            <div class="count">
                                <span class="counter">100</span>%
                            </div>
                            <h6>Satisfaction rate</h6>
                        </div>
                    </div>
                </div>
            </div>
       </div>
    </div>
</section>
<!-- COunter Section End -->


<section class="section-padding popular-course bg-grey pt-190">
    <div class="container">
        <div class="row align-items-center justify-content-center">
            <div class="col-lg-7">
                <div class="section-heading center-heading">
                    <span class="subheading">Trending Courses</span>
                    <h3>Over 200+ Online Courses </h3>
                    <p>The ultimate planning solution for
                        busy women who want to reach their personal goals</p>
                </div>
            </div>
        </div>

        <div class="row">
            @php
                        $build_query =  DB::table('certifies')
                        ->select('certifies.*', 'show_syndicate.id as show_syndicateemail ,show_syndicate.certify_id ')
                        ->leftJoin('show_syndicate', 'show_syndicate.certify_id', '=', 'certifies.id')
                        ->where('status', '=', 'Published')
                        ->where('certifies.domain_id','=',1)
                        ->Orwhere('show_syndicate.domain_id','=', get_domain_id())
                        ->groupBy('certifies.id')->take(3)->get();

            @endphp
            @if(!empty($build_query))
                @foreach ($build_query as $row)
                    <div class="col-lg-4 col-md-6">
                        <div class="course-block">
                            <div class="course-img">
                               @if(file_exists( storage_path().'/certify/'.$row->image)  && !empty($row->image))
                                        <img src="{{asset('storage')}}/certify/{{ $row->image }}" alt="" class="img-fluid w-100">
                                    @else
                                            <img src="{{asset('assets/img/course/c8.jpg')}}" alt="" class="img-fluid w-100">
                                    @endif
                                <div class="course-price "> @if(!empty($row->sale_price))
                                    ${{$row->sale_price}} / <strike>${{$row->price}}</strike>
                                    @elseif(!empty($row->price))
                                    ${{$row->price}}
                                    @else
                                    Free
                                    @endif </div>
                            </div>

                            <div class="course-content">
                                <span class="course-cat">{{substr((!empty($row->category) && !empty(getCategoryName($row->category)) ? getCategoryName($row->category) :'No category'),0,4)}}..</span>
                                <h4><a href="{{route('course.details',['id'=>encrypted_key($row->id,'encrypt')])}}">{!! html_entity_decode(ucfirst(substr($row->name,0,14)), ENT_QUOTES, 'UTF-8') !!}..</a></h4>

                            </div>
                        </div>
                    </div>
                @endforeach
            @endif

        </div>

        <div class="row justify-content-center">
            <div class="col-xl-6">
                <div class="text-center mt-5">
                    Take the control of their life back and start doing things to make their dream come true. <a href="{{route('search.courses')}}" class="font-weight-bold text-underline">View all courses </a>
                </div>
            </div>
        </div>
    </div>
</section>
<!-- Testimonial section start -->
<section class="testimonial-2 section-padding">
    <div class="container">
        <div class="row align-items-center justify-content-center">
            <div class="col-lg-7 col-xl-7">
                <div class="section-heading center-heading">
                    <span class="subheading">Testimonials</span>
                    <h3>Success Stories from Students</h3>
                    <p>The ultimate planning solution for busy women who want to reach their personal goals.</p>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-lg-12 col-xl-12">
                <div class="testimonials-slides-3 owl-carousel owl-theme">
                    <div class="testimonial-item testimonial-style-2">
                        <i class="fa fa-quote-right"></i>

                        <div class="testimonial-info-title">
                            <h4>One of the easiest online accounting systems we've tried.</h4>
                        </div>

                        <div class="testimonial-info-desc">
                            People who build their own home tend to be very courageous. These people are curious about life.
                        </div>

                        <div class="client-info">
                            <div class="client-img">
                                <img src="{{ asset('assets/home14/images/clients/test-1.jpg')}}" alt="" class="img-fluid">
                            </div>
                            <div class="testionial-author">Jessica Smith - Amazon co.</div>
                        </div>
                    </div>


                    <div class="testimonial-item testimonial-style-2">
                        <i class="fa fa-quote-right"></i>

                        <div class="testimonial-info-title">
                            <h4>One of the easiest online accounting systems we've tried.</h4>
                        </div>

                        <div class="testimonial-info-desc">
                            People who build their own home tend to be very courageous. These people are curious about life.
                        </div>
                        <div class="client-info">
                            <div class="client-img">
                                <img src="{{ asset('assets/home14/images/clients/test-2.jpg')}}" alt="" class="img-fluid">
                            </div>
                            <div class="testionial-author">Jessica Smith - Amazon co.</div>
                        </div>
                    </div>


                    <div class="testimonial-item testimonial-style-2">
                        <i class="fa fa-quote-right"></i>

                        <div class="testimonial-info-title">
                            <h4>One of the easiest online accounting systems we've tried.</h4>
                        </div>

                        <div class="testimonial-info-desc">
                            They're thinking about what it means to live in a house, rather than just buying a commodity and making it work.
                        </div>
                        <div class="client-info">
                            <div class="client-img">
                                <img src="{{ asset('assets/home14/images/clients/test-3.jpg')}}" alt="" class="img-fluid">
                            </div>
                            <div class="testionial-author">Jessica Smith - Amazon co.</div>
                        </div>
                    </div>

                    <div class="testimonial-item testimonial-style-2">
                        <i class="fa fa-quote-right"></i>
                        <div class="testimonial-info-title">
                            <h4>One of the easiest online accounting systems we've tried.</h4>
                        </div>

                        <div class="testimonial-info-desc">
                            People who build their own home tend to be very courageous. These people are curious about life.
                        </div>
                        <div class="client-info">
                            <div class="client-img">
                                <img src="{{ asset('assets/home14/images/clients/test-1.jpg')}}" alt="" class="img-fluid">
                            </div>
                            <div class="testionial-author">Jessica Smith - Amazon co.</div>
                        </div>
                    </div>
                 </div>
            </div>
        </div>
    </div>
</section>
<!-- Testimonial section End -->
<!-- Clients logo Section Start -->
<section class="cta-2 clients">
    <div class="container">
        <div class="row ">
            <div class="col-xl-10">
                <div class="section-heading ">
                    <span class="subheading">Maximize your potentials</span>
                    <h3>Over 50k+ people Love to work with us</h3>
                </div>
            </div>
        </div>

        <div class="row mx-auto">

            @if(!empty($partners))
                @foreach($partners as $partner)
                    <div class="col-lg-3 col-sm-6 col-xl-2">
                        <div class="client-logo">
                            <a href="#">  <img src="{{asset('storage')}}/partner/{{ $partner->logo }}" alt="" class="img-fluid"></a>
                        </div>
                    </div>
                @endforeach
            @endif

        </div>
    </div>
</section>
<!-- Clients logo Section End -->
<section class="section-padding popular-course-list">
    <div class="container">
        <div class="row align-items-center justify-content-center">
            <div class="col-lg-7 col-xl-7">
                <div class="section-heading center-heading">
                    <span class="subheading">Trending Courses</span>
                    <h3>Popular Online Courses Around You</h3>
                    <p>The ultimate planning solution for
                        busy women who want to reach their personal goals</p>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-lg-6 col-md-12">
                <div class="course-block course-list-item">
                    <div class="row align-items-center">
                        <div class="col-lg-4 col-sm-4 ">
                            <div class="course-img mb-4 mb-md-0">
                                <img src="{{ asset('assets/home14/images/course/course-sm1.jpg')}}" alt="" class="img-fluid">
                            </div>
                        </div>
                        <div class="col-lg-8  col-sm-8">
                            <div class="course-content">
                                <div class="course-price ">$50 <del>$90</del></div>
                                <h4><a href="#">Information About UI/UX Design Degree</a></h4>
                                <div class="course-meta">
                                    <span class="course-author">By <a href="#">William</a></span>
                                    <span class="course-duration"><i class="far fa-file-alt"></i>82 Lessons</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

             <div class="col-lg-6 col-md-12">
                <div class="course-block course-list-item">
                    <div class="row align-items-center">
                        <div class="col-lg-4 col-sm-4">
                            <div class="course-img mb-4 mb-md-0">
                                <img src="{{ asset('assets/home14/images/course/course-sm2.jpg')}}" alt="" class="img-fluid">
                            </div>
                        </div>
                        <div class="col-lg-8  col-sm-8">
                            <div class="course-content">
                                <div class="course-price ">$80 <del>$100</del></div>

                                <h4><a href="#">Photography Crash Course for Photographer</a></h4>
                                <div class="course-meta">
                                    <span class="course-author">By <a href="#">William</a></span>
                                    <span class="course-duration"><i class="far fa-file-alt"></i>82 Lessons</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

           <div class="col-lg-6 col-md-12">
                <div class="course-block course-list-item">
                    <div class="row align-items-center">
                        <div class="col-lg-4  col-sm-4">
                            <div class="course-img mb-4 mb-md-0">
                                <img src="{{ asset('assets/home14/images/course/course-sm3.jpg')}}" alt="" class="img-fluid">
                            </div>
                        </div>
                        <div class="col-lg-8  col-sm-8">
                            <div class="course-content">
                                <div class="course-price ">$100 <del>$120</del></div>

                                <h4><a href="#">React – The Complete Guide (React Router)</a></h4>
                                <div class="course-meta">
                                    <span class="course-author">By <a href="#">William</a></span>
                                    <span class="course-duration"><i class="far fa-file-alt"></i>82 Lessons</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>


           <div class="col-lg-6 col-md-12">
                <div class="course-block course-list-item">
                    <div class="row align-items-center">
                        <div class="col-lg-4  col-sm-4">
                            <div class="course-img mb-4 mb-md-0">
                                <img src="{{ asset('assets/home14/images/course/course-sm4.jpg')}}" alt="" class="img-fluid">
                            </div>
                        </div>
                        <div class="col-lg-8  col-sm-8">
                            <div class="course-content">
                                <div class="course-price ">$180 <del>$190</del></div>

                                <h4><a href="#">WebCrash Course for Photographer</a></h4>
                                <div class="course-meta">
                                    <span class="course-author">By <a href="#">William</a></span>
                                    <span class="course-duration"><i class="far fa-file-alt"></i>82 Lessons</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="row justify-content-center">
            <div class="col-xl-6">
                <div class="text-center mt-5">
                    Take the control of their life back and start doing things to make their dream come true. <a href="course.html" class="font-weight-bold text-underline">View all courses </a>
                </div>
            </div>
        </div>
    </div>
</section>
<!-- About Section Start -->
<section class="about section-padding">
    <div class="container">
        <div class="row align-items-center justify-content-center">
            <div class="col-xl-6 col-lg-6">
                <div class="section-heading ">
                    <span class="subheading">Self Development Course</span>
                    <h3>Get Instant Access To <span> Expert solution</span></h3>
                    <p>The ultimate planning solution for busy women who want to reach their personal goals.Effortless comfortable eye-catching unique detail </p>
                </div>

                <div class="about-text-block">
                    <div class="icon-box">
                        <i class="flaticon-video-camera"></i>
                    </div>
                    <div class="about-desc">
                        <h4>Sign up in website</h4>
                        <p>The right mentoring relationship can be a powerful tool for professional growth. Bark up the right tree.</p>
                    </div>
                </div>

                <div class="about-text-block">
                    <div class="icon-box">
                        <i class="flaticon-flag"></i>
                    </div>
                    <div class="about-desc">
                        <h4>Enroll your course</h4>
                        <p>The right mentoring relationship can be a powerful tool for professional growth. Bark up the right tree.</p>
                    </div>
                </div>
                <div class="about-text-block">
                    <div class="icon-box border-none">
                        <i class="flaticon-video-camera"></i>
                    </div>
                    <div class="about-desc">
                        <h4>Start from now</h4>
                        <p>The right mentoring relationship can be a powerful tool for professional growth. Bark up the right tree.</p>
                    </div>
                </div>
            </div>

            <div class="col-xl-6 col-lg-6">
                <div class="about-img">
                    <img src="{{ asset('assets/home14/images/bg/about-image.jpg')}}" alt="" class="img-fluid">
                </div>
            </div>
        </div>
    </div>
</section>
<!-- About Section End -->
<!-- Blog Section Start -->
<section class="blog section-padding">
    <div class="container">
        <div class="row align-items-center justify-content-center">
            <div class="col-lg-7">
                <div class="section-heading center-heading">
                    <span class="subheading">Blog News</span>
                    <h3>Latest From The Blog</h3>
                    <p>The ultimate planning solution for
                        busy women who want to reach their personal goals</p>
                </div>
            </div>
        </div>

        <div class="row">
            @if(!empty($recent_blogs))
                @foreach ($recent_blogs as $recent_blog)
                    <div class="col-lg-4 col-md-6 col-sm-6">
                        <div class="blog-item">
                            <div class="post-thumb">
                                @if(file_exists( storage_path().'/blog/'.$recent_blog->image ) && !empty($recent_blog->image))
                                <img src="{{asset('storage')}}/blog/{{ $recent_blog->image }}" class="img-fluid" alt="...">
                                @else
                                <img class="img-fluid" src="{{ asset('assets/img/blog/blog-thumb-01.jpg') }}" alt="">
                                @endif
                            </div>

                            <div class="blog-content">
                                <div class="post-meta">
                                    <span class="post-author">Written by <a href="{{route('blog.details',encrypted_key($recent_blog->id,"encrypt"))}}" >{{ $recent_blog->user->name??'' }}</a></span>
                                    <span class="post-date"><i class="fa fa-calendar-alt mr-2"></i>{{date('F d, Y', strtotime($recent_blog->created_at))}}</span>
                                </div>

                                <h3><a href="{{route('blog.details',encrypted_key($recent_blog->id,"encrypt"))}}">{!!$recent_blog->title!!}</a></h3>
                                <p>{!!substr_replace($recent_blog->article, "...", 100)!!}</p>
                            </div>
                        </div>
                    </div>
                @endforeach
            @endif

        </div>
    </div>
</section>

<!-- Blog Section End -->
<section class="subscribe section-padding pt-0">
    <div class="container">
        <div class="row align-items-center form-inner">
            <div class="col-lg-6 col-xl-6">
                <div class="section-heading mb-0">
                    <span class="subheading">Newsletter</span>
                    <h3>Subscribe to get latest news</h3>
                </div>
            </div>
            <div class="col-lg-6 col-xl-6">
                <form  class="subscribe-form"  method="POST"  action="{{url('subscribe')}}" enctype="multipart/form-data">
                    <input type="email" name="email" required placeholder="Enter Your Email" class="form-control">
                    {!! csrf_field() !!}
                    <button type="submit"  class="btn btn-main">Subscribe</button>
                </form>
            </div>
        </div>
    </div>
</section>

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
<!-- Footer section start -->
<section class="footer-2">
	<div class="container">
		<div class="row">
			<div class="col-lg-3 col-sm-6 col-md-8 col-xl-3 col-sm-6">
				<div class="widget footer-about mb-5 mb-lg-0">
					<h5 class="widget-title text-gray">About us</h5>
					<ul class="list-unstyled footer-info">
						<li><span>Ph:</span>+(68) 345 5902</li>
						<li><span>Email:</span>info@yourdomain.com</li>
						<li><span>Location:</span> 123 Fifth Floor East 26th Street,
							New York, NY 10011</li>
					</ul>
					<ul class="list-inline footer-socials">
						<li class="list-inline-item">Follow us :</li>
						<li class="list-inline-item"><a href="#"><i class="fab fa-facebook-f"></i></a></li>
						<li class="list-inline-item"> <a href="#"><i class="fab fa-twitter"></i></a></li>
						<li class="list-inline-item"><a href="#"><i class="fab fa-linkedin"></i></a></li>
						<li class="list-inline-item"><a href="#"><i class="fab fa-pinterest"></i></a></li>
					</ul>
				</div>
			</div>


			<div class="col-xl-7 ml-auto col-lg-7 col-md-12 col-sm-12">
				<div class="row">
					<div class="col-lg-4 col-xl-4 col-sm-4 col-md-4 ">
						<div class="footer-widget mb-5 mb-lg-0">
							<h5 class="widget-title text-gray">Explore</h5>
							<ul class="list-unstyled footer-links">
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

					<div class="col-lg-4 col-xl-4 col-sm-4 col-md-4">
						<div class="footer-widget mb-5 mb-lg-0">
							<h5 class="widget-title text-gray">Courses</h5>
							<ul class="list-unstyled footer-links">
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

					<div class="col-lg-4 col-xl-4 col-sm-4 col-md-4">
						<div class="footer-widget mb-5 mb-lg-0">
							<h5 class="widget-title text-gray">Legal</h5>
							<ul class="list-unstyled footer-links">
								<li><a href="#">Terms & Condition</a></li>
								<li><a href="#">Privacy policy</a></li>
								<li><a href="#">Return policy</a></li>
							</ul>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>

	<div class="footer-btm">
		<div class="container">
			<div class="row justify-content-center align-items-center">
				<div class="col-xl-6 col-lg-4 col-md-12">
					<div class="footer-logo text-lg-left text-center mb-4 mb-lg-0">
                        @if (!empty($logo_favicon['logo']))
                        <img src="{{ asset('storage/logo').'/'.$logo_favicon['logo'] }}" class="img-fluid">
                    @else
                        <img src="{{ asset('assets/main/images/logo.png')}}" class="img-fluid">
                    @endif
					</div>
				</div>
				<div class="col-xl-6 col-lg-8 col-md-12">
					<div class="copyright text-lg-right text-center">
						<p>{{$footer_text}}</p>
					</div>
				</div>
			</div>
		</div>
	</div>
</section>
<!-- Footer section End -->

<div class="fixed-btm-top">
	<a href="#top-header" class="js-scroll-trigger scroll-to-top"><i class="fa fa-angle-up"></i></a>
</div>

@endsection
