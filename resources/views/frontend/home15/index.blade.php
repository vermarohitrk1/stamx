@extends('layout.frontend.home15.mainlayout')
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
<header>
    <div class="header-top ">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-lg-6 col-md-8 text-center text-md-left ">
                    <p>Are you interested in Joining program? <a href="#">Contact me.</a></p>
                </div>
                <div class="col-lg-6 col-md-4">
                    <div class="header-right float-md-right text-center">
                        <div class="header-socials">
                            <a href="#"><i class="fab fa-facebook-f"></i></a>
                            <a href="#"><i class="fab fa-twitter"></i></a>
                            <a href="#"><i class="fab fa-linkedin"></i></a>
                            <a href="#"><i class="fab fa-pinterest"></i></a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Main Menu Start -->
    <div class="site-navigation main_menu menu-style-2" id="mainmenu-area">
        <nav class="navbar navbar-expand-lg">
            <div class="container">
                <a class="navbar-brand" href="/">
                    @if (!empty($logo_favicon['logo']))
                        <img src="{{ asset('storage/logo').'/'.$logo_favicon['logo'] }}"alt="LogoImage" class="img-fluid" >
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

                    <div class="header-login">
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
                </div> <!-- / .navbar-collapse -->
            </div> <!-- / .container -->
        </nav>
    </div>
</header>




<!-- Banner Section Start -->
<section class="banner-4 section-padding">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-12 col-xl-10">
                <div class="banner-content text-center">
                    <span class="subheading">Expert instruction</span>
                    <h1><span class="font-weight-normal">It's time to amplify</span> your online Career</h1>
                    <p class="mb-4">Eduhash is a HTML5 template based on Sass and Bootstrap 4 with modern and creative multipurpose design you can use it as a startups.</p>

                    <a href="{{route('search.courses')}}" class="btn btn-main mr-2">our Courses </a>

                </div>
            </div>
        </div> <!-- / .row -->
    </div> <!-- / .container -->
</section>
<!-- Banner Section End -->

<!-- Clients logo Section Start -->
<section class="clients-2">
    <div class="container">
        <div class="row mx-auto">
            @if(!empty($partners))
                @foreach($partners as $partner)
                    <div class="col-lg-3 col-sm-6 col-xl-2">
                        <div class="client-logo">
                            <a href="#"><img src="{{asset('storage')}}/partner/{{ $partner->logo }}" alt="" class="img-fluid"></a>
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
        <div class="row">
            @if(!empty($build_query))
                @foreach ($build_query as $row)
                @php
                    $instructor_id=explode(',',$row->instructor);
                    $instructor=\App\Instructor::getInstructordata($instructor_id[0]);
                @endphp
                    <div class="col-lg-6 col-md-12">
                        <div class="course-block course-list-item">
                            <div class="row align-items-center">
                                <div class="col-lg-4 col-sm-4 ">
                                    <div class="course-img mb-4 mb-md-0">
                                        @if(file_exists( storage_path().'/certify/'.$row->image)  && !empty($row->image))
                                        <img src="{{asset('storage')}}/certify/{{ $row->image }}" alt="" class="img-fluid w-100">
                                     @else
                                        <img src="{{asset('assets/img/course/c8.jpg')}}" alt="" class="img-fluid w-100">
                                    @endif
                                    </div>
                                </div>
                                <div class="col-lg-8  col-sm-8">
                                    <div class="course-content">
                                        <div class="course-price ">@if(!empty($row->sale_price))
                                            ${{$row->sale_price}} / <del>${{$row->price}}</del>
                                            @elseif(!empty($row->price))
                                            ${{$row->price}}
                                            @else
                                            Free
                                            @endif</div>
                                        <h4><a href="{{route('course.details',['id'=>encrypted_key($row->id,'encrypt')])}}">{!! html_entity_decode(ucfirst(substr($row->name,0,14)), ENT_QUOTES, 'UTF-8') !!}..</a></h4>
                                        <div class="course-meta">
                                            <span class="course-author">By <a href="{{route('course.details',['id'=>encrypted_key($row->id,'encrypt')])}}">{{$instructor->name}}</a></span>
                                            {{-- <span class="course-duration"><i class="far fa-file-alt"></i>82 Lessons</span> --}}
                                        </div>
                                    </div>
                                </div>
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
<!-- About Section Start -->
<section class="about-section">
    <div class="container">
        <div class="row align-items-center justify-content-center">
            <div class="col-xl-6 col-lg-6 col-md-12 col-sm-12">
                <div class="row ">
                    <div class="col-xl-6 col-lg-6  col-md-6 col-sm-6">
                        <div class="about-imgbox">
                            <img src="{{ asset('assets/home15/images/bg/feature1.png')}}" alt="" class="img-fluid">
                        </div>
                        <div class="about-imgbox">
                            <img src="{{ asset('assets/home15/images/bg/feature2.png')}}" alt="" class="img-fluid">
                        </div>
                    </div>

                     <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6">
                        <div class="about-imgbox mt-5">
                            <img src="{{ asset('assets/home15/images/bg/feature3.png')}}" alt="" class="img-fluid">
                        </div>
                        <div class="about-imgbox">
                            <img src="{{ asset('assets/home15/images/bg/about-img.jpg')}}" alt="" class="img-fluid">
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-xl-6 col-lg-6">
                <div class="section-heading pl-lg-5 ">
                    <span class="subheading">Self Development Course</span>
                    <h3>Get Instant Access To <span> Expert solution</span></h3>
                    <p class="mb-4">The ultimate planning solution for busy women who want to reach their personal goals.Effortless comfortable eye-catching unique detail.Take the control of their life back and start doing things </p>
                    <a href="#" class="btn btn-solid-border">Join Now</a>
                </div>
            </div>
        </div>
    </div>
</section>
<!-- About Section End -->
<!-- Feature section start -->
<section class="feature  section-padding ">
    <div class="container">
        <div class="row align-items-center justify-content-center">
            <div class="col-lg-7">
                <div class="section-heading center-heading">
                    <span class="subheading">Maximize your potentials</span>
                    <h3>Learn the secrets to Life Success</h3>
                    <p>The ultimate planning solution for
                        busy women who want to reach their personal goals</p>
                </div>
            </div>
        </div>

        <div class="row ">
            <div class="col-lg-4 col-md-6 col-xl-4">
                <div class="feature-item feature-style-2">
                    <div class="feature-icon">
                        <i class="flaticon-flag"></i>
                    </div>
                    <div class="feature-text">
                        <h4>Expert Teacher</h4>
                        <p>Develop skills for career of various majors including computer</p>
                    </div>
                </div>
            </div>
             <div class="col-lg-4 col-md-6 col-xl-4">
                <div class="feature-item feature-style-2">
                    <div class="feature-icon">
                        <i class="flaticon-layers"></i>
                    </div>
                    <div class="feature-text">
                        <h4>Self Development</h4>
                        <p>Develop skills for career of various majors including computer.</p>
                    </div>
                </div>
            </div>
             <div class="col-lg-4 col-md-6 col-xl-4">
                <div class="feature-item feature-style-2">
                    <div class="feature-icon">
                        <i class="flaticon-video-camera"></i>
                    </div>
                    <div class="feature-text">
                        <h4>Remote Learning</h4>
                        <p>Develop skills for career of various majors including language</p>
                    </div>
                </div>
            </div>
            <div class="col-lg-4 col-md-6 col-xl-4">
                <div class="feature-item feature-style-2">
                    <div class="feature-icon">
                        <i class="flaticon-help"></i>
                    </div>
                    <div class="feature-text">
                        <h4>Online Course</h4>
                        <p>Develop skills for career of various majors including language  </p>
                    </div>
                </div>
            </div>
            <div class="col-lg-4 col-md-6 col-xl-4">
                <div class="feature-item feature-style-2">
                    <div class="feature-icon">
                        <i class="flaticon-layers"></i>
                    </div>
                    <div class="feature-text">
                        <h4>High Quality Video</h4>
                        <p>Develop skills for career of various majors including computer.</p>
                    </div>
                </div>
            </div>
             <div class="col-lg-4 col-md-6 col-xl-4">
                <div class="feature-item feature-style-2">
                    <div class="feature-icon">
                        <i class="flaticon-video-camera"></i>
                    </div>
                    <div class="feature-text">
                        <h4>Distance Learning</h4>
                        <p>Develop skills for career of various majors including language</p>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-xl-12">
                <div class="text-center mt-3">
                    <a href="#" class="btn btn-solid-border">Explore Courses</a>
                    <a href="#" class="btn btn-main">Join now</a>
                </div>
            </div>
        </div>
    </div>
</section>
<!-- Feature section End -->


    <!--course section start-->
    <section class="section-padding course-grid bg-gray" >
        <div class="container">
            <div class="row align-items-center justify-content-center">
                <div class="col-lg-7">
                    <div class="section-heading center-heading">
                        <span class="subheading">Trending Courses</span>
                        <h3>Over 200+ New Online Courses</h3>
                        <p>The ultimate planning solution for
                            busy women who want to reach their personal goals</p>
                    </div>
                </div>
            </div>

           <div class="text-center">
                <ul class="course-filter">
                    <li class="active"><a href="#" data-filter="*"> All</a></li>
                    <li><a href="#" data-filter=".cat1">printing</a></li>
                    <li><a href="#" data-filter=".cat2">Web</a></li>
                    <li><a href="#" data-filter=".cat3">illustration</a></li>
                    <li><a href="#" data-filter=".cat4">media</a></li>
                    <li><a href="#" data-filter=".cat5">crafts</a></li>
                </ul>
           </div>

            <div class="row course-gallery ">
                <div class="course-item cat1 cat3 col-lg-4 col-md-6">
                    <div class="course-block">
                        <div class="course-img">
                            <img src="{{ asset('assets/home15/images/course/course-1.jpg')}}" alt="" class="img-fluid">
                            <div class="course-price ">$100 </div>
                        </div>

                        <div class="course-content">
                            <span class="course-cat">photography</span>
                            <h4><a href="#">Photography Crash Course for Photographer</a></h4>
                            <p class="mb-3">Lorem ipsum dolor sit, amet consectetur adipisicing elit. Quis, alias.</p>
                            <div class="course-meta">
                                <span class="course-student"><i class="fa fa-user-alt"></i>340 Students</span>
                                <span class="course-duration"><i class="far fa-file-alt"></i>82 Lessons</span>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="course-item cat2 cat4 col-lg-4 col-md-6">
                    <div class="course-block">
                        <div class="course-img">
                            <img src="{{ asset('assets/home15/images/course/course-2.jpg')}}" alt="" class="img-fluid">
                            <div class="course-price ">$120 </div>
                        </div>

                        <div class="course-content">
                            <span class="course-cat">Design</span>
                            <h4><a href="#">Information About UI/UX Design Degree</a></h4>
                            <p class="mb-3">Lorem ipsum dolor sit, amet consectetur adipisicing elit. Quis, alias.</p>
                            <div class="course-meta">
                                <span class="course-student"><i class="fa fa-user-alt"></i>340 Students</span>
                                <span class="course-duration"><i class="far fa-file-alt"></i>82 Lessons</span>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="course-item cat5 cat2 col-lg-4 col-md-6">
                    <div class="course-block">
                        <div class="course-img">
                            <img src="{{ asset('assets/home15/images/course/course-3.jpg')}}" alt="" class="img-fluid">
                            <div class="course-price ">$70 </div>
                        </div>

                        <div class="course-content">
                            <span class="course-cat">Programming</span>
                            <h4><a href="#">React – The Complete Guide (React Router)</a></h4>
                            <p class="mb-3">Lorem ipsum dolor sit, amet consectetur adipisicing elit. Quis, alias.</p>
                            <div class="course-meta">
                                <span class="course-student"><i class="fa fa-user-alt"></i>340 Students</span>
                                <span class="course-duration"><i class="far fa-file-alt"></i>82 Lessons</span>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="course-item cat2 cat4 col-lg-4 col-md-6">
                    <div class="course-block">
                        <div class="course-img">
                            <img src="{{ asset('assets/home15/images/course/course-2.jpg')}}" alt="" class="img-fluid">
                            <div class="course-price ">$100 </div>
                        </div>

                        <div class="course-content">
                            <span class="course-cat">WordPress</span>
                            <h4><a href="#">Master WordPress zero to hero easily</a></h4>
                            <p class="mb-3">Lorem ipsum dolor sit, amet consectetur adipisicing elit. Quis, alias.</p>
                            <div class="course-meta">
                                <span class="course-student"><i class="fa fa-user-alt"></i>340 Students</span>
                                <span class="course-duration"><i class="far fa-file-alt"></i>82 Lessons</span>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="course-item cat1 cat3 col-lg-4 col-md-6">
                    <div class="course-block">
                        <div class="course-img">
                            <img src="{{ asset('assets/home15/images/course/course-1.jpg')}}" alt="" class="img-fluid">
                            <div class="course-price ">$100 </div>
                        </div>

                        <div class="course-content">
                            <span class="course-cat">photography</span>
                            <h4><a href="#">Photography Crash Course for Photographer</a></h4>
                            <p class="mb-3">Lorem ipsum dolor sit, amet consectetur adipisicing elit. Quis, alias.</p>
                            <div class="course-meta">
                                <span class="course-student"><i class="fa fa-user-alt"></i>340 Students</span>
                                <span class="course-duration"><i class="far fa-file-alt"></i>82 Lessons</span>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="course-item cat5 cat2 col-lg-4 col-md-6">
                    <div class="course-block">
                        <div class="course-img">
                            <img src="{{ asset('assets/home15/images/course/course-3.jpg')}}" alt="" class="img-fluid">
                            <div class="course-price ">$200 </div>
                        </div>

                        <div class="course-content">
                            <span class="course-cat">Design</span>
                            <h4><a href="#">Mastering Adobe xd for beginners</a></h4>
                            <p class="mb-3">Lorem ipsum dolor sit, amet consectetur adipisicing elit. Quis, alias.</p>
                            <div class="course-meta">
                                <span class="course-student"><i class="fa fa-user-alt"></i>340 Students</span>
                                <span class="course-duration"><i class="far fa-file-alt"></i>82 Lessons</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!--course section end-->

<!-- Testimonial section start -->
<section class="testimonial-2 section-padding">
    <div class="container">
        <div class="row align-items-center justify-content-center">
            <div class="col-lg-6 col-xl-5 mr-auto">
                <div class="section-heading">
                    <span class="subheading">Testimonials</span>
                    <h3>Success Stories from Students</h3>
                    <p>The ultimate planning solution for busy women who want to reach their personal goals.Effortless comfortable eye-catching unique detail.Take the control of their life back</p>
                   <p>Help you to get the best course that fits you <a href="#" class="text-underline d-block">Free Consultation <i class="fa fa-angle-right ml-2"></i></a></p>
                </div>
            </div>

            <div class="col-lg-6 col-xl-6">
                <div class="testimonials-slides-2 owl-carousel owl-theme">
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
                                <img src="{{ asset('assets/home15/images/clients/test-1.jpg')}}" alt="" class="img-fluid">
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
                                <img src="{{ asset('assets/home15/images/clients/test-2.jpg')}}" alt="" class="img-fluid">
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
                                <img src="{{ asset('assets/home15/images/clients/test-3.jpg')}}" alt="" class="img-fluid">
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
                                <img src="{{ asset('assets/home15/images/clients/test-2.jpg')}}" alt="" class="img-fluid">
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
<!-- CTA Sidebar start -->
<section class="cta bg-gray section-padding">
    <div class="container">
        <div class="row align-items-center justify-content-center">
            <div class="col-lg-7">
                <div class="section-heading center-heading mb-0">
                    <span class="subheading">be a instructor</span>
                    <h3>Want to Become an Instructor ?</h3>
                    <p class="mb-4">Join millions of people from around the world
                        learning together. Online learning is as easy and
                        natural as chatting.</p>
                    <a href="#" class="btn btn-main">Become Instructor</a>
                </div>
            </div>
        </div>
    </div>
</section>
<!-- CTA Sidebar end -->
<!-- Blog Section Start -->
<section class="blog-section section-padding">
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
                    <div class="col-lg-4 col-xl-4 col-md-6 ">
                        <article class="blog-post-item">
                            <div class="post-thumb">
                                @if(file_exists( storage_path().'/blog/'.$recent_blog->image ) && !empty($recent_blog->image))
                                    <img src="{{asset('storage')}}/blog/{{ $recent_blog->image }}" alt="..." class="img-fluid">
                                @else
                                    <img class="img-fluid" src="{{ asset('assets/img/blog/blog-thumb-01.jpg') }}" alt="" class="img-fluid">
                                @endif
                            </div>
                            <div class="post-item mt-4">
                                <div class="post-meta">
                                    <span class="post-author">Written by <a href="{{route('blog.details',encrypted_key($recent_blog->id,"encrypt"))}}" >{{ $recent_blog->user->name??'' }}</a></span>
                                    <span class="post-date"><i class="fa fa-calendar-alt mr-2"></i>{{date('F d, Y', strtotime($recent_blog->created_at))}}</span>
                                </div>
                                <h4 class="post-title"><a href="{{route('blog.details',encrypted_key($recent_blog->id,"encrypt"))}}">{{$recent_blog->title}}</a></h4>
                            </div>
                        </article>
                    </div>
                @endforeach
            @endif


        </div>
    </div>
</section>
<!-- Blog Section End -->

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
<section class="footer pt-190">
	<div class="container">
		<div class="row">
			<div class="col-lg-4 mr-auto col-sm-6 col-md-6">
				<div class="widget footer-widget mb-5 mb-lg-0">
					<div class="footer-logo">
						 @if (!empty($logo_favicon['logo']))
                            <img src="{{ asset('storage/logo').'/'.$logo_favicon['logo'] }}" class="img-fluid" >
                        @else
                            <img src="{{ asset('assets/main/images/logo.png')}}" class="img-fluid">
                        @endif
					</div>
					<p class="mt-3">Veniam Sequi molestias aut necessitatibus optio magni at natus accusamus.Lorem ipsum dolor sit amet, consectetur adipisicin gelit, sed do eiusmod tempor incididunt .</p>
					<ul class="list-inline footer-socials">
						<li class="list-inline-item"><a href="#"><i class="fab fa-facebook-f"></i></a></li>
						<li class="list-inline-item"> <a href="#"><i class="fab fa-twitter"></i></a></li>
						<li class="list-inline-item"><a href="#"><i class="fab fa-linkedin"></i></a></li>
						<li class="list-inline-item"><a href="#"><i class="fab fa-pinterest"></i></a></li>
					</ul>
				</div>
			</div>

			<div class="col-lg-2 col-sm-6 col-md-6 col-xl-2">
				<div class="footer-widget mb-5 mb-lg-0">
					<h5 class="widget-title">Explore</h5>
					<ul class="list-unstyled footer-links">
						@if (count($footerWidget1))
                                @foreach ($footerWidget1 as $key => $menu)
                                    @if ($menu)
                                       <li><a href="{{url(str_replace('_','-',$menu))}}"> <span>{{$key}}</span></a></li>
                                    @endif
                                @endforeach
                        @else


                            <li><a href=""><span>Find Candidates</span></a></li>
                            <li><a href=""><span>Post a Job</span></a></li>
                            <li><a href=""><span>Resume Search</span></a></li>
                            <li><a href=""><span>Impact</span></a></li>
                            <li><a href=""><span>Staffing</span></a></li>

                        @endif
					</ul>
				</div>
			</div>
			<div class="col-lg-2 col-sm-6 col-md-6 col-xl-2">
				<div class="footer-widget mb-5 mb-lg-0">
					<h5 class="widget-title">Courses</h5>
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
			<div class="col-lg-2 col-sm-6 col-md-6 col-xl-2">
				<div class="footer-widget footer-links mb-5 mb-lg-0">
					<h5 class="widget-title">Address </h5>

					<ul class="list-unstyled">
						<li>+(68) 345 5902</li>
						<li>info@yourdomain.com</li>
						<li>123 Fifth Floor East 26th Street,
							New York, NY 10011</li>
					</ul>
				</div>
			</div>
		</div>
	</div>

	<div class="footer-btm">
		<div class="container">
			<div class="row justify-content-center align-items-center">
				<div class="col-lg-6">
					<div class="copyright">
						<p>{{$footer_text}} </p>
					</div>
				</div>
				<div class="col-xl-6">

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
