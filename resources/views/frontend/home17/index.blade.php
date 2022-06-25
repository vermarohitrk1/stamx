@extends('layout.frontend.home17.mainlayout')
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
                        <a class="navbar-brand with-text" title="PSD to HTML" href="/">
                            @if (!empty($logo_favicon['logo']))
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

    <div class="demo-parallax parallax section looking-photo" data-stellar-background-ratio="0.7" style="background-image:url({{ asset('assets/home17/upload/demo_04.jpg')}});">
        <div class="container">
            <div class="row centermessage text-left">
                <div class="col-md-7">
                    <div class="tagline"><h4>We build beautiful course templates for the marketplace.</h4></div>
                    <p>We're among one of the best Education Bootstrap template on the Envato marketplace to build a powerful online university websites. The team family is a small collection of designers and who have one thing in common - we all love coding.</p>
                </div>

                <div class="col-md-5">
                    <form method="POST"  action="{{url('subscribe')}}" enctype="multipart/form-data">
                        <div class="row section-signup semitrans">
                            <div class="col-md-12">
                                <div class="form-group has-icon-left form-control-email">
                                    <label class="sr-only" for="inputEmail">Email address</label>
                                    <input type="email" name="email" class="form-control form-control-lg" id="inputEmail" placeholder="Email address" autocomplete="off" required>
                                </div>
                            </div>
                            {!! csrf_field() !!}
                            <div class="col-md-12">
                                <div class="form-group">
                                    <button type="submit" class="btn btn-primary btn-block">Subscribe</button>
                                </div>
                            </div>
                            <div class="col-md-12">
                                <p>Your email is safe with us and we hate spam as much as you do.</p>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div><!-- end section -->

    <div class="section lb">
        <div class="container">
            <div class="big-title text-center">
                <h2>One of the Best Education Template on the Market</h2>
                <hr class="customhr customhrcenter">
                <p class="lead">The EduPress template compatible with all mobile devices and modern browsers.<br>This template coded with Bootstrap Framework</p>
            </div><!-- end title -->
            <div class="row service-list service-style2 clearfix">
                <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12 wow fadeIn" data-wow-duration="1s" data-wow-delay="0.2s">
                    <div class="widget clearfix">
                        <img src="{{ asset('assets/home17/images/icons/darkicon_01.png')}}" alt="" class="img-responsive">
                        <div class="widget-title">
                            <h3>Best Multi-Tier Courses</h3>
                            <hr>
                            <p>Nam vehicula malesuad fringilla nibh. Duis aliquam vitae metus a pharetra. Lorem ipsum dpharetra lor sit amet.. </p>
                        </div><!-- end title -->
                    </div><!--widget -->
                </div><!-- end col -->

                <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12 wow fadeIn" data-wow-duration="1s" data-wow-delay="0.3s">
                    <div class="widget clearfix">
                        <img src="{{ asset('assets/home17/images/icons/darkicon_02.png')}}" alt="" class="img-responsive">
                        <div class="widget-title">
                            <h3>Buy / Sell Courses</h3>
                            <hr>
                            <p>Nam vehicula malesuad fringilla nibh. Duis aliquam vitae metus a pharetra. Lorem ipsum dpharetra lor sit amet.. </p>
                        </div><!-- end title -->
                    </div><!--widget -->
                </div><!-- end col -->

                <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12 wow fadeIn" data-wow-duration="1s" data-wow-delay="0.4s">
                    <div class="widget clearfix">
                        <img src="{{ asset('assets/home17/images/icons/darkicon_03.png')}}" alt="" class="img-responsive">
                        <div class="widget-title">
                            <h3>Multi Purpose Dashboard</h3>
                            <hr>
                            <p>Nam vehicula malesuad fringilla nibh. Duis aliquam vitae metus a pharetra. Lorem ipsum dpharetra lor sit amet.. </p>
                        </div><!-- end title -->
                    </div><!--widget -->
                </div><!-- end col -->

                <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12 wow fadeIn" data-wow-duration="1s" data-wow-delay="0.5s">
                    <div class="widget clearfix">
                        <img src="{{ asset('assets/home17/images/icons/darkicon_04.png')}}" alt="" class="img-responsive">
                        <div class="widget-title">
                            <h3>Easy to Use Video Panels</h3>
                            <hr>
                            <p>Nam vehicula malesuad fringilla nibh. Duis aliquam vitae metus a pharetra. Lorem ipsum dpharetra lor sit amet.. </p>
                        </div><!-- end title -->
                    </div><!--widget -->
                </div><!-- end col -->
            </div>

            <hr class="invis">

            <div class="row service-list service-style2 clearfix">
                <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12 wow fadeIn" data-wow-duration="1s" data-wow-delay="0.2s">
                    <div class="widget clearfix">
                        <img src="{{ asset('assets/home17/images/icons/darkicon_05.png')}}" alt="" class="img-responsive">
                        <div class="widget-title">
                            <h3>Useful User Dashboard</h3>
                            <hr>
                            <p>Nam vehicula malesuad fringilla nibh. Duis aliquam vitae metus a pharetra. Lorem ipsum dpharetra lor sit amet.. </p>
                        </div><!-- end title -->
                    </div><!--widget -->
                </div><!-- end col -->

                <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12 wow fadeIn" data-wow-duration="1s" data-wow-delay="0.3s">
                    <div class="widget clearfix">
                        <img src="{{ asset('assets/home17/images/icons/darkicon_06.png')}}" alt="" class="img-responsive">
                        <div class="widget-title">
                            <h3>Limitless Color Schemes</h3>
                            <hr>
                            <p>Nam vehicula malesuad fringilla nibh. Duis aliquam vitae metus a pharetra. Lorem ipsum dpharetra lor sit amet.. </p>
                        </div><!-- end title -->
                    </div><!--widget -->
                </div><!-- end col -->

                <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12 wow fadeIn" data-wow-duration="1s" data-wow-delay="0.4s">
                    <div class="widget clearfix">
                        <img src="{{ asset('assets/home17/images/icons/darkicon_07.png')}}" alt="" class="img-responsive">
                        <div class="widget-title">
                            <h3>Custom Blogging Sections</h3>
                            <hr>
                            <p>Nam vehicula malesuad fringilla nibh. Duis aliquam vitae metus a pharetra. Lorem ipsum dpharetra lor sit amet.. </p>
                        </div><!-- end title -->
                    </div><!--widget -->
                </div><!-- end col -->

                <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12 wow fadeIn" data-wow-duration="1s" data-wow-delay="0.5s">
                    <div class="widget clearfix">
                        <img src="{{ asset('assets/home17/images/icons/darkicon_08.png')}}" alt="" class="img-responsive">
                        <div class="widget-title">
                            <h3>SEO Friendly Code</h3>
                            <hr>
                            <p>Nam vehicula malesuad fringilla nibh. Duis aliquam vitae metus a pharetra. Lorem ipsum dpharetra lor sit amet.. </p>
                        </div><!-- end title -->
                    </div><!--widget -->
                </div><!-- end col -->
            </div>
        </div><!-- end container -->
    </div><!-- end section -->

    <div class="section">
        <div class="container">
            <div class="big-title text-center">
                <h2>Most Popular Courses</h2>
                <hr class="customhr customhrcenter">
                <p class="lead">The EduPress template compatible with all mobile devices and modern browsers.<br>This template coded with Bootstrap Framework</p>
            </div><!-- end title -->
            @php
                       $build_query =  DB::table('certifies')
                    ->select('certifies.*', 'show_syndicate.id as show_syndicateemail ,show_syndicate.certify_id ')
                    ->leftJoin('show_syndicate', 'show_syndicate.certify_id', '=', 'certifies.id')
                    ->where('status', '=', 'Published')
                    ->where('certifies.domain_id','=',get_domain_id())
                    ->Orwhere('show_syndicate.domain_id','=', get_domain_id())
                    ->groupBy('certifies.id')->take(6)->get();

            @endphp
            <div class="row">
                @if(!empty($build_query))
                    @foreach ($build_query as $row)
                        @php
                            $instructor_id=explode(',',$row->instructor);
                            $instructor=\App\Instructor::getInstructordata($instructor_id[0]);
                        @endphp
                            <div class="col-lg-4 col-md-4 col-sm-12 col-xs-12 wow fadeIn" data-wow-duration="1s" data-wow-delay="0.2s">
                                <div class="video-wrapper clearfix">
                                    <div class="post-media">
                                        <div class="entry">
                                            @if(file_exists( storage_path().'/certify/'.$row->image)  && !empty($row->image))
                                                <img src="{{asset('storage')}}/certify/{{ $row->image }}" alt="" class="img-responsive">
                                            @else
                                                    <img src="{{asset('assets/img/course/c8.jpg')}}" alt="" class="img-responsive">
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
                                            <div class="rating">
                                                <i class="fa fa-star"></i>
                                                <i class="fa fa-star"></i>
                                                <i class="fa fa-star"></i>
                                                <i class="fa fa-star"></i>
                                                <i class="fa fa-star"></i>
                                            </div>
                                        </div>
                                        <div class="pull-right">
                                            <a href="{{route('course.details',['id'=>encrypted_key($row->id,'encrypt')])}}" class="btn btn-sm btn-inverse">
                                                @if($row->sale_price)
                                                ${{$row->sale_price}} / <strike>${{$row->price}}</strike>
                                                @elseif(!empty($row->price))
                                                ${{$row->price}}
                                                @else
                                                Free
                                                @endif</a>
                                        </div>
                                    </div><!-- end title -->
                                </div><!--widget -->
                            </div><!-- end col -->
                    @endforeach
                @endif


            </div><!-- end row -->

            <div class="row">
                <div class="col-md-12">
                    <div class="text-center large-buttons nobot">
                        <a href="{{route('search.courses')}}" class="btn btn-primary btn-lg">Browse All Courses &nbsp;&nbsp;&nbsp; <i class="fa fa-long-arrow-right"></i></a>
                    </div><!-- end title -->
                </div>
            </div><!-- end row -->
        </div><!-- end container -->
    </div><!-- end section -->

    <div class="section lb overflow">
        <div class="container">
            <div class="row">
                <div class="col-md-6">
                    <div class="big-title m15 text-left">
                        <h2>Awards Winning Courses</h2>
                        <hr class="customhr">
                        <p class="lead">One template hundreds of beautiful section elements! Don't forget to check our awesome video documentation!</p>
                    </div><!-- end title -->

                    <div class="feature-list">
                        <p>Easily change/switch/swap every placeholder inside every image on Sedna with the included Sketch files. You’ll have this template customised to suit your business in no time! </p>
                        <p>Nam vehicula malesuada lectus, interdum fringilla nibh. Duis aliquam vitae metus a pharetra. Lorem ipsum dolor sit amet, consectetur adipiscing elit. Donec fermentum augue..Nam vehicula malesuada lectus, interdum fringilla nibh. Duis aliquam vitae metus a pharetra. Lorem ipsum dolor sit amet, consectetur adipiscing elit. Donec fermentum augue..
                        </p>
                        <div class="row">
                            @if(!empty($partners))
                                @foreach($partners as $partner)
                                    <div class="col-md-3 col-sm-3 col-xs-6">
                                        <img src="{{asset('storage')}}/partner/{{ $partner->logo }}" alt="" class="img-responsive">
                                    </div><!-- end col -->
                                @endforeach
                            @endif

                        </div><!-- end row -->
                        <div class="large-buttons nobot">
                            <a href="#" class="btn btn-primary btn-lg">View All Awards &nbsp;&nbsp;&nbsp; <i class="fa fa-long-arrow-right"></i></a>
                        </div><!-- end title -->
                    </div>
                </div>
            </div>
        </div>
        <div class="ipad_02-wrap hidden-sm hidden-xs wow slideInRight"></div>
    </div>

    <div class="section">
        <div class="container">
            <div class="big-title text-center">
                <h2>What Others Say About EduPress</h2>
                <hr class="customhrcenter customhr">
            </div><!-- end title -->

            <div class="row-fluid custom-list">
                <div class="col-md-6 col-sm-6">
                    <div class="testibox">
                        <img src="{{ asset('assets/home17/upload/testi_01.png')}}" alt="" class="img-responsive alignleft img-circle wow fadeIn" data-wow-duration="1s" data-wow-delay="0.2s">
                        <p>Thanks for your awesome video tutorials! Its helped me a lot! Pellentesque at tellus vitae augue sodales lobortis eget in ipsum.</p>
                        <h4>Amanda Martin</h4>
                        <small>Web Designer at <a href="#">Wikipedia</a></small>
                    </div>
                </div><!-- end col -->

                <div class="col-md-6 col-sm-6">
                    <div class="testibox">
                        <img src="{{ asset('assets/home17/upload/testi_02.png')}}" alt="" class="img-responsive alignleft img-circle wow fadeIn" data-wow-duration="1s" data-wow-delay="0.3s">
                        <p>When I need a education template, the EduPress helped me much! Its helped me a lot! Pellentesque at tellus vitaes lobortis eget in ipsu augue sodale.</p>
                        <h4>Bob Davidson</h4>
                        <small>CEO at <a href="#">Pedicalica</a></small>
                    </div>
                </div><!-- end col -->

                <div class="col-md-6 col-sm-6">
                    <div class="testibox">
                        <img src="{{ asset('assets/home17/upload/testi_03.png')}}" alt="" class="img-responsive alignleft img-circle wow fadeIn" data-wow-duration="1s" data-wow-delay="0.4s">
                        <p>The EduPress is an awesome website template for my next web design project. We used this template on our university site. Thanks PSDConvertHTML team!</p>
                        <h4>Jenny Sunders</h4>
                        <small>English Teacher at <a href="#">Harward Uni.</a></small>
                    </div>
                </div><!-- end col -->

                <div class="col-md-6 col-sm-6">
                    <div class="testibox">
                        <img src="{{ asset('assets/home17/upload/testi_04.png')}}" alt="" class="img-responsive alignleft img-circle wow fadeIn" data-wow-duration="1s" data-wow-delay="0.5s">
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
                        @if (!empty($logo_favicon['logo']))
                            <img src="{{ asset('storage/logo').'/'.$logo_favicon['logo'] }}" >
                        @else
                            <img src="{{ asset('assets/main/images/logo.png')}}">
                        @endif
                    </ul><!-- end check -->
                </div><!-- end col -->
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
