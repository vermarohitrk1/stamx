@extends('layout.frontend.home18.mainlayout')
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
 <!-- PRELOADER -->
 <div class="cssload-container">
    <div class="cssload-loader"></div>
</div>
<!-- end PRELOADER -->

<!-- ******************************************
START SITE HERE
********************************************** -->

<div id="wrapper">
<header class="header normal-header" data-spy="affix" data-offset-top="197">
    <div class="container">
        <nav class="navbar navbar-default yamm">
            <div class="container-full">
                <div class="navbar-header">
                    <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
                        <span class="sr-only">Toggle navigation</span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                    </button>
                    <a class="navbar-brand with-text" title="PSD to HTML" href="/">@if (!empty($logo_favicon['logo']))
                        <img src="{{ asset('storage/logo').'/'.$logo_favicon['logo'] }}"alt="LogoImage" >
                    @else
                  @if(!empty($logoTxt)) {{ $logoTxt }} @else Your Logo Here @endif
                    @endif
</a>
                </div>
                <!-- end navbar header -->

                <div id="navbar" class="navbar-collapse collapse">
                    <ul class="nav navbar-nav">
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
                    <ul class="nav navbar-nav navbar-right">
                        @guest

                            @if ($donation = \App\PublicPageDetail::where('user_id',get_domain_user()->id)->first())
                                @php $dId = base64_encode($donation->id);
                                $user_setting = DB::table('website_setting')->where('user_domain_id', get_domain_id())->where('name', 'payment_settings')->first();
                            @endphp
                                @if($user_setting != null)
                                <li class="btn btn-default">   <a href='{{ url("$dId/donation")}}'>Donate</a></li>
                                    @endif
                            @endif
                            <li class="btn btn-default">    <a href="{{ route('login') }}">log In</a></li>



                        @else
                        <li class="btn btn-default"> <a href="{{ route('home') }}">Dashboard</a></li>

                @endguest

                    </ul>
                    <!-- end dropdown -->
                </div>
                <!--/.nav-collapse -->
            </div>
            <!--/.container-fluid -->
        </nav>
        <!-- end nav -->
    </div>
    <!-- end container -->
</header>
<!-- end header -->

<div class="slider-section">
   <div id="superslides">
        <ul class="slides-container">
            <li>
                <img src="{{ asset('assets/home18/upload/slider_01.jpg')}}" alt="">
                <div class="general-content">
                    <div class="general-text">
                        <p class="lead">The EduPress template compatible with all mobile devices and modern browsers. This template coded with Bootstrap Framework</p>
                        <h2>EduPress fencer heads for Olympics</h2>
                    </div>
                </div>
            </li>
            <li>
                <img src="{{ asset('assets/home18/upload/slider_02.jpg')}}" alt="">
                <div class="general-content">
                    <div class="general-text">
                         <p class="lead">The EduPress template compatible with all mobile devices and modern browsers. This template coded with Bootstrap Framework</p>
                        <h2>Fast-tracking their dreams</h2>
                    </div>
                </div>
            </li>
        </ul>
        <nav class="slides-navigation hidden-xs">
            <a href="#" class="next"><i class="fa fa-angle-right fa-2x"></i></a>
            <a href="#" class="prev"><i class="fa fa-angle-left fa-2x"></i></a>
        </nav>
    </div>
</div><!-- end slider -->

<div class="section onecourse db">
    <div class="container">
        <div class="big-title text-center">
            <h2>Meet Our Courses</h2>
            <p class="lead">The EduPress template compatible with all mobile devices and modern browsers.<br>This template coded with Bootstrap Framework</p>
        </div><!-- end title -->

        <hr class="largeinvis">
        @php
                  $build_query =  DB::table('certifies')
                    ->select('certifies.*', 'show_syndicate.id as show_syndicateemail ,show_syndicate.certify_id ')
                    ->leftJoin('show_syndicate', 'show_syndicate.certify_id', '=', 'certifies.id')
                    ->where('status', '=', 'Published')
                    ->where('certifies.domain_id','=',get_domain_id())
                    ->Orwhere('show_syndicate.domain_id','=', get_domain_id())
                    ->groupBy('certifies.id')->take(5)->get();

        @endphp
        <div class="course-carousel owl-carousel owl-theme custom-list">
            @if(!empty($build_query))
                @foreach ($build_query as $row)
                @php
                    $instructor_id=explode(',',$row->instructor);
                    $instructor=\App\Instructor::getInstructordata($instructor_id[0]);
                @endphp
                    <div class="carousel-item">
                        <div class="video-wrapper clearfix">
                            <div class="post-media">
                                <div class="entry">
                                    @if(file_exists( storage_path().'/certify/'.$row->image)  && !empty($row->image))
                                        <img src="{{asset('storage')}}/certify/{{ $row->image }}" alt="" class="img-fluid w-100">
                                    @else
                                            <img src="{{asset('assets/img/course/c8.jpg')}}" alt="" class="img-fluid w-100">
                                    @endif
                                    <div class="magnifier">
                                        <div class="magni-desc">
                                            <a class="secondicon" href="{{route('course.details',['id'=>encrypted_key($row->id,'encrypt')])}}"> <span class="oi" data-glyph="link-intact" title="Read More" aria-hidden="false"></span></a>
                                        </div><!-- end team-desc -->
                                    </div><!-- end magnifier -->
                                </div>
                            </div><!-- end media -->

                            <div class="widget-title clearfix">
                                <div class="pull-left">
                                    <h3><a href="{{route('course.details',['id'=>encrypted_key($row->id,'encrypt')])}}">{!! html_entity_decode(ucfirst(substr($row->name,0,14)), ENT_QUOTES, 'UTF-8') !!}..</a></h3>
                                    <a href="{{route('profile',['id'=>encrypted_key($instructor->id,'encrypt')])}}" class="readmore">{{$instructor->name}}</a>
                                </div>
                                <div class="pull-right">
                                    <a href="{{route('course.details',['id'=>encrypted_key($row->id,'encrypt')])}}" class="btn btn-sm btn-inverse"> @if(!empty($row->sale_price))
                                        ${{$row->sale_price}} / <strike>${{$row->price}}</strike>
                                        @elseif(!empty($row->price))
                                        ${{$row->price}}
                                        @else
                                        Free
                                        @endif</a>
                                </div>
                            </div><!-- end title -->
                            <div class="course-meta clearfix">
                                <div class="pull-left">
                                    <p><i class="fa fa-user"></i> 21</p>
                                </div>
                                <div class="pull-right">
                                    <div class="rating">
                                        @for($i=1;$i<=5;$i++)
                                                <i class="fa fa-star @if($i<=$instructor->average_rating) checked @else not-checked @endif "></i>

                                        @endfor
                                    </div>
                                </div>
                            </div><!-- end meta -->
                        </div><!--widget -->
                    </div>
                @endforeach
            @endif


        </div>
    </div><!-- end container -->
</div><!-- end section -->

<div class="section onecourse greenbg">
    <div class="container">
        <div class="big-title text-center">
            <h2>Course Details</h2>
            <p class="lead">Listed below our awesome course details and features. We build an awesome course<br> modules for our dear clients.</p>
        </div><!-- end title -->

        <hr class="largeinvis">

         <div class="row service-list">
            <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12 wow fadeIn" data-wow-duration="1s" data-wow-delay="0.2s">
                <div class="widget clearfix">
                    <span class="oi alignleft" data-glyph="phone"></span>
                    <div class="widget-title">
                        <h3>Responsive Mobile Friendly</h3>
                        <hr>
                    </div>
                    <!-- end title -->
                    <p>Our templates are 100% responsive, your website will look great on mobile devices. </p>
                </div>
                <!--widget -->
            </div>
            <!-- end col -->

            <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12 wow fadeIn" data-wow-duration="1s" data-wow-delay="0.3s">
                <div class="widget clearfix">
                    <span class="oi alignleft" data-glyph="envelope-open"></span>
                    <div class="widget-title">
                        <h3>Fast & Friendly Support</h3>
                        <hr>
                    </div>
                    <!-- end title -->
                    <p>We offer personalized email support when you need help, daily available 24/7 and email support.</p>
                </div>
                <!--widget -->
            </div>
            <!-- end col -->
        </div>

        <hr class="largeinvis">

        <div class="row service-list">
            <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12 wow fadeIn" data-wow-duration="1s" data-wow-delay="0.4s">
                <div class="widget clearfix">
                    <span class="oi alignleft" data-glyph="cog"></span>
                    <div class="widget-title">
                        <h3>Easy Customization</h3>
                        <hr>
                    </div>
                    <!-- end title -->
                    <p>Our templates are fun to use and customizable without being bloated with options.</p>
                </div>
                <!--widget -->
            </div>
            <!-- end col -->

            <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12 wow fadeIn" data-wow-duration="1s" data-wow-delay="0.5s">
                <div class="widget clearfix">
                    <span class="oi alignleft" data-glyph="bullhorn"></span>
                    <div class="widget-title">
                        <h3>Update & Upgrade</h3>
                        <hr>
                    </div>
                    <!-- end title -->
                    <p>We offer lifetime update for all our templates! When the web technology need upgrade.</p>
                </div>
                <!--widget -->
            </div>
            <!-- end col -->
        </div>

        <hr class="largeinvis">

        <div class="row service-list">
            <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12 wow fadeIn" data-wow-duration="1s" data-wow-delay="0.6s">
                <div class="widget clearfix">
                    <span class="oi alignleft" data-glyph="code"></span>
                    <div class="widget-title">
                        <h3>Simple & Clean Code</h3>
                        <hr>
                    </div>
                    <!-- end title -->
                    <p>We work with most popular Bootstrap Framework with all our premium & free templates.</p>
                </div>
                <!--widget -->
            </div>
            <!-- end col -->

            <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12 wow fadeIn" data-wow-duration="1s" data-wow-delay="0.7s">
                <div class="widget clearfix">
                    <span class="oi alignleft" data-glyph="shield"></span>
                    <div class="widget-title">
                        <h3>SEO & Social Friendly</h3>
                        <hr>
                    </div>
                    <!-- end title -->
                    <p>We are all aware of the need for search engines. Our templates seo & social friendly.</p>
                </div>
                <!--widget -->
            </div>
            <!-- end col -->
        </div>
        <!-- end row -->
    </div><!-- end container -->
</div><!-- end section -->
@if(!empty($partners))
    <div class="section lb">
        <div class="container">
            <div class="row awards-list">

                    @foreach($partners as $partner)
                        <div class="col-lg-2 col-md-2 col-sm-6 col-xs-6 wow fadeIn" data-wow-duration="1s" data-wow-delay="0.2s">
                            <div class="widget clearfix">
                                <img src="{{asset('storage')}}/partner/{{ $partner->logo }}" alt="" class="img-responsive">
                            </div><!--widget -->
                        </div><!-- end col -->
                    @endforeach


            </div>
        </div><!-- end container -->
    </div><!-- end section -->
@endif

<div class="section onecourse redbg">
    <div class="container">
        <div class="big-title text-center">
            <h2>Meet Our Experts</h2>
            <p class="lead">Who really happy to work with us a long time like a professional!<br> The guys build an awesome community since 2014!</p>
        </div><!-- end title -->

        <hr class="largeinvis">

        <div class="row">
            <div class="col-md-12">
                <div class="our-team-content">
                    <div class="row">
                        <!-- Start single team member -->
                        <div class="col-md-3 col-sm-6 col-xs-12">
                            <div class="single-team-member">
                                <div class="team-member-img">
                                    <img src="{{ asset('assets/home18/upload/testi_01.png')}}" alt="team member img" class="img-responsive">
                                </div>
                                <div class="team-member-name">
                                    <p>John Doe</p>
                                    <span>CEO</span>
                                </div>
                                <p>EduPress is a powerful Education HTML template that comes with an easy template option interface. Suspendisse ante mi. </p>
                                <div class="team-member-link">
                                    <a href="#"><i class="fa fa-facebook"></i></a>
                                    <a href="#"><i class="fa fa-twitter"></i></a>
                                    <a href="#"><i class="fa fa-linkedin"></i></a>
                                </div>
                            </div>
                        </div>
                        <!-- Start single team member -->
                        <div class="col-md-3 col-sm-6 col-xs-12">
                            <div class="single-team-member">
                                <div class="team-member-img">
                                    <img src="{{ asset('assets/home18/upload/testi_02.png')}}" alt="team member img" class="img-responsive">
                                </div>
                                <div class="team-member-name">
                                    <p>Bernice Neumann</p>
                                    <span>Designer</span>
                                </div>
                                <p>EduPress is a powerful Education HTML template that comes with an easy template option interface. Suspendisse ante mi.</p>
                                <div class="team-member-link">
                                    <a href="#"><i class="fa fa-facebook"></i></a>
                                    <a href="#"><i class="fa fa-twitter"></i></a>
                                    <a href="#"><i class="fa fa-linkedin"></i></a>
                                </div>
                            </div>
                        </div>
                        <!-- Start single team member -->
                        <div class="col-md-3 col-sm-6 col-xs-12">
                            <div class="single-team-member">
                                <div class="team-member-img">
                                    <img src="{{ asset('assets/home18/upload/testi_03.png')}}" alt="team member img" class="img-responsive">
                                </div>
                                <div class="team-member-name">
                                    <p>Jenny Cameron</p>
                                    <span>English Teacher</span>
                                </div>
                                <p>EduPress is a powerful Education HTML template that comes with an easy template option interface. Suspendisse ante mi.</p>
                                <div class="team-member-link">
                                    <a href="#"><i class="fa fa-facebook"></i></a>
                                    <a href="#"><i class="fa fa-twitter"></i></a>
                                    <a href="#"><i class="fa fa-linkedin"></i></a>
                                </div>
                            </div>
                        </div>
                        <!-- Start single team member -->
                        <div class="col-md-3 col-sm-6 col-xs-12">
                            <div class="single-team-member">
                                <div class="team-member-img">
                                    <img src="{{ asset('assets/home18/upload/testi_04.png')}}" alt="team member img" class="img-responsive">
                                </div>
                                <div class="team-member-name">
                                    <p>Bob Neumann</p>
                                    <span>Designer</span>
                                </div>
                                <p>EduPress is a powerful Education HTML template that comes with an easy template option interface. Suspendisse ante mi.</p>
                                <div class="team-member-link">
                                    <a href="#"><i class="fa fa-facebook"></i></a>
                                    <a href="#"><i class="fa fa-twitter"></i></a>
                                    <a href="#"><i class="fa fa-linkedin"></i></a>
                                </div>
                            </div>
                        </div>
                        <!-- Start single team member -->
                    </div>
                </div>
            </div>
        </div>
    </div><!-- end container -->
</div><!-- end section -->

<div class="section lightbg onecourse">
    <div class="container">
        <div class="big-title text-center">
            <h2>Testimonials</h2>
            <p class="lead">Here we showcase all our awesome testimonials who has happy to work with us! We need<br> to say Thanks for choose us to these guys!</p>
        </div><!-- end title -->

        <hr class="largeinvis">

        <div class="row-fluid custom-list">
            <div class="col-md-6 col-sm-6">
                <div class="testibox">
                    <img src="{{ asset('assets/home18/upload/testi_01.png')}}" alt="" class="img-responsive alignleft img-circle wow fadeIn" data-wow-duration="1s" data-wow-delay="0.2s">
                    <p>Thanks for your awesome video tutorials! Its helped me a lot! Pellentesque at tellus vitae augue sodales lobortis eget in ipsum.</p>
                    <h4>Amanda Martin</h4>
                    <small>Web Designer at <a href="#">Wikipedia</a></small>
                </div>
            </div><!-- end col -->

            <div class="col-md-6 col-sm-6">
                <div class="testibox">
                    <img src="{{ asset('assets/home18/upload/testi_02.png')}}" alt="" class="img-responsive alignleft img-circle wow fadeIn" data-wow-duration="1s" data-wow-delay="0.3s">
                    <p>When I need a education template, the EduPress helped me much! Its helped me a lot! Pellentesque at tellus vitaes lobortis eget in ipsu augue sodale.</p>
                    <h4>Bob Davidson</h4>
                    <small>CEO at <a href="#">Pedicalica</a></small>
                </div>
            </div><!-- end col -->

            <div class="col-md-6 col-sm-6">
                <div class="testibox">
                    <img src="{{ asset('assets/home18/upload/testi_03.png')}}" alt="" class="img-responsive alignleft img-circle wow fadeIn" data-wow-duration="1s" data-wow-delay="0.4s">
                    <p>The EduPress is an awesome website template for my next web design project. We used this template on our university site. Thanks PSDConvertHTML team!</p>
                    <h4>Jenny Sunders</h4>
                    <small>English Teacher at <a href="#">Harward Uni.</a></small>
                </div>
            </div><!-- end col -->

            <div class="col-md-6 col-sm-6">
                <div class="testibox">
                    <img src="{{ asset('assets/home18/upload/testi_04.png')}}" alt="" class="img-responsive alignleft img-circle wow fadeIn" data-wow-duration="1s" data-wow-delay="0.5s">
                    <p>Finally I got amazing template for our new site.. Thanks for build beautiful item man you're awesome! Pellentesque at tellus vitaes lobortis eget in ipsu augue.</p>
                    <h4>Darwin Luksenburg</h4>
                    <small>Founder at <a href="#">Material INC.</a></small>
                </div>
            </div><!-- end col -->
        </div><!-- end row -->
    </div><!-- end container -->
</div><!-- end section -->


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
<footer class="copyrights">
    <div class="container">
        <div class="row">
            <div class="col-md-3 col-sm-12">
                <ul class="check">
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
                </ul><!-- end check -->
            </div><!-- end col -->
            <div class="col-md-3 col-sm-12">
                <ul class="check">
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
                </ul><!-- end check -->
            </div><!-- end col -->

            <div class="col-md-3 col-sm-12">
                <ul class="check">
                    <li><a href="http://twitter.com/psdconverthtml" target="_blank"><i class="fa fa-twitter"></i> Twitter</a></li>
                    <li><a href="#" target="_blank"><i class="fa fa-facebook"></i> Facebook</a></li>
                    <li><a href="#" target="_blank"><i class="fa fa-google-plus"></i> Google Plus</a></li>
                    <li><a href="#" target="_blank"><i class="fa fa-pinterest"></i> Pinterest</a></li>
                    <li><a href="#" target="_blank"><i class="fa fa-dribbble"></i> Dribbble</a></li>
                </ul><!-- end check -->
            </div><!-- end col -->

            <div class="col-md-3 col-sm-12">
                <div class="newsletter">
                    <p>Your email is safe with us and we hate spam as much as you do.</p>
                        <form  class="form-inline" method="POST"  action="{{url('subscribe')}}" enctype="multipart/form-data">
                        <div class="form-group">
                            <input type="email" name="email" required class="form-control" placeholder="Enter your email here..">
                        </div>
                        {!! csrf_field() !!}
                        <button type="submit" class="btn btn-primary">Subscribe</button>
                    </form>
                </div>
            </div>
        </div><!-- end row -->

        <hr>

        <div class="row">
            <div class="col-md-6 col-sm-12">
                <div class="copylinks">
                    <p> {{$footer_text}}</p>
                </div><!-- end links -->
            </div><!-- end col -->

            <div class="col-md-6 col-sm-12">
                <div class="footer-social text-right">
                    <a class="dmtop" href="#"><i class="fa fa-angle-up"></i></a>
                </div>
            </div><!-- end col -->
        </div><!-- end row -->
    </div><!-- end container -->
</footer><!-- end copyrights -->

</div><!-- end wrapper -->

@endsection
