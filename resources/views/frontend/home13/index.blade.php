@extends('layout.frontend.home13.mainlayout')
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
<!-- START PRELOADER -->
<div class="preloader">
    <div class="spinner">
        <div class="double-bounce1"></div>
        <div class="double-bounce2"></div>
    </div>
</div>
<!-- END PRELOADER -->

<!-- START NAVBAR -->
<div class="navbar navbar-default navbar-fixed-top menu-top">
    <div class="container">
        <div class="navbar-header">
            <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#navbar">
                <span class="sr-only">Toggle navigation</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
            <a href="/" class="navbar-brand w-text">
                @if (!empty($logo_favicon['logo']))
                <img src="{{ asset('storage/logo').'/'.$logo_favicon['logo'] }}"alt="LogoImage" >
            @else

            @if(!empty($logoTxt)) {{ $logoTxt }} @else Your Logo Here @endif
            @endif</a>
        </div>
        <div id="navbar" class="navbar-collapse collapse">
            <ul class="nav navbar-nav navbar-right">
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
                @guest
                    @if ($donation = \App\PublicPageDetail::where('user_id',get_domain_user()->id)->first())
                                @php $dId = base64_encode($donation->id);
                                $user_setting = DB::table('website_setting')->where('user_domain_id', get_domain_id())->where('name', 'payment_settings')->first();
                            @endphp
                                @if($user_setting != null)
                                <li class="nav-item"> <a href='{{ url("$dId/donation")}}'  class="default-btn"><i class='bx bx-arrow-to-right'></i>Donate<span></span></a>
                                </li> @endif
                            @endif
                            <li class="nav-item">   <a    class="default-btn" href="{{ route('login') }}"><i class='bx bx-arrow-to-right'></i>log In<span></span></a></li>



                    @else
                    <li class="nav-item"> <a href="{{ route('home') }}" class="default-btn"><i class='bx bx-arrow-to-right'></i>Dashboard<span></span></a></li>

                @endguest
            </ul>
        </div>
    </div> <!--- END CONTAINER -->
</div>
<!-- END NAVBAR -->

<!-- START BANNER-SHOW -->
<section id="home" class="main_banner v3 banner_bg">
    <div class="res-text">Artficial</div>
    <div class="display_table">
        <div class="display_table_cell">
            <div class="container">
                <div class="row">
                    <div class="col-md-6">
                        <div class="banner_content text-left mt-30">
                            <span class="sm_title">Get Ready! AI Soluation to Improve Business Growth</span>
                            <h1 class="cd-headline clip">
                                <span class="fw_300">AI Solutions to more Business profit in</span>
                                <span class="cd-words-wrapper c-cyan">
                                    <b class="is-visible fw_800">Digital Marketing</b>
                                    <b class="fw_800">Chatbot Business</b>
                                    <b class="fw_800">Machine Learning</b>
                                </span>
                            </h1>
                            <p class="head-p">Lorem ipsum dolor sit amet, consectetur adipisicing elit. Ut culpa nulla ipsum amet a ab neque. Odio impedit inventore nemo aliquid eius ad? Veniam perferendis iste odio officiis.</p>
                            <div class="btn-wrap">
                                <a href="#0" class="btn btn-default main_btn"><span>Our Services</span></a>
                                <a href="#0" class="btn btn-default main_btn"><span>Contact us</span></a>

                            </div>
                        </div>
                    </div>
                </div> <!--- END ROW -->
            </div> <!--- END CONTAINER -->
        </div>
    </div>
    <div class="mouse_scroll">
        <a href="#about" class="smoothScroll">
            <div class="mouse">
                <i class="ti-angle-double-down"></i>
            </div>
        </a>
    </div>
</section>
<!-- END BANNER-SHOW -->

<section class="about2 section_padding relative">
<div class="container">
    <div class="row">
        <div class="col-md-2">
            <div class="about2-wrap relative"></div>
        </div>
        <div class="box-shadow purple-bg col-md-10">
                <div class="row">
                    <div class="col-md-6 no-pl col-sm-12 col-xs-12">
                        <div class="about_img">
                            <img src="{{ asset('assets/home13/images/about2.png')}}" alt="about-img" />
                        </div>
                    </div>
                    <div class="col-md-6 col-sm-12 col-xs-12 no-pr">
                        <div class="about_content_area custom">
                            <h5 class="c-cyan has-before">Dedicated Artificial Intelligence</h5>
                            <h3 class="w-text">Get Benefits of using latest Artificial Intelligence.</h3>
                            <p class="g-text">Lorem ipsum dolor sit amet, consectetur adipiscing elit. Integer tellus est, finibus ut congue sed, faucibus ut</p>

                            <div class="row mt-30">
                                <div class="col-md-6">
                                    <div class="side-feature-list-item">
                                        <img src="{{ asset('assets/home13/images/elements/feature-1.svg')}}" class="check-mark-icon" alt="">
                                        <div class="foot-c-info">Fully Responsive & obile friendly</div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="side-feature-list-item">
                                        <img src="{{ asset('assets/home13/images/elements/feature-2.svg')}}" class="check-mark-icon" alt="">
                                        <div class="foot-c-info">Clean &amp; Modern Design Layout</div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="side-feature-list-item">
                                        <img src="i{{ asset('assets/home13/mages/elements/feature-3.svg')}}" class="check-mark-icon" alt="">
                                        <div class="foot-c-info">Multi-Device Testing System </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="side-feature-list-item">
                                        <img src="{{ asset('assets/home13/images/elements/feature-4.svg')}}" class="check-mark-icon" alt="">
                                        <div class="foot-c-info">great User Experience</div>
                                    </div>
                                </div>

                            </div>
                            <div class="about_btn">
                                <a href="#0" class="btn cyan-btn">contact Us</a>
                            </div>
                        </div>
                    </div>

                </div>

            </div>
    </div>
</div>
</section>

<section class="section_padding no-pt pb_70">
<div class="container">
    <div class="section_heading text-center">
        <h2>Creative Business Solutions</h2>
        <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Phasellus molestie, justo nec convallis sollicitudin.</p>
    </div>

    <div class="row text-center">
        <div class="col-md-2 col-sm-4 col-xs-6">
            <div class="feat-box v2 border-b text-center">
                <img src="{{ asset('assets/home13/images/elements/feat1.png')}}" alt="">
                <p class="feat-desc">Fully Responsive.</p>
            </div>
        </div>
        <div class="col-md-2 col-sm-4 col-xs-6">
            <div class="feat-box v2 border-b text-center">
                <img src="{{ asset('assets/home13/images/elements/feat2.png')}}" alt="">
                <p class="feat-desc">Creative Team.</p>
            </div>
        </div>
        <div class="col-md-2 col-sm-4 col-xs-6">
            <div class="feat-box v2 border-b text-center">
                <img src="{{ asset('assets/home13/images/elements/feat3.png')}}" alt="">
                <p class="feat-desc">Awards Win.</p>
            </div>
        </div>
        <div class="col-md-2 col-sm-4 col-xs-6">
            <div class="feat-box v2 border-b text-center">
                <img src="{{ asset('assets/home13/images/elements/feat4.png')}}" alt="">
                <p class="feat-desc">24/7 Support.</p>
            </div>
        </div>
        <div class="col-md-2 col-sm-4 col-xs-6">
            <div class="feat-box v2 border-b text-center">
                <img src="{{ asset('assets/home13/images/elements/feat5.png')}}" alt="">
                <p class="feat-desc">Happy Clients.</p>
            </div>
        </div>
        <div class="col-md-2 col-sm-4 col-xs-6">
            <div class="feat-box v2 border-b text-center">
                <img src="{{ asset('assets/home13/images/elements/feat6.png')}}" alt="">
                <p class="feat-desc">Fully Responsive.</p>
            </div>
        </div>

    </div>
</div>
</section>

<section  class="how-it-work section_padding pb_70">
<div class="container">
    <div class="section_heading text-center">
        <h2 class="w-text">How It Works</h2>
        <p class="g-text">Lorem ipsum dolor sit amet, consectetur adipiscing elit. Phasellus molestie, justo nec convallis sollicitudin.</p>
    </div>
    <div class="row">
        <div class="col-md-4 col-sm-6">
            <div class="feat-box v2 text-center">
                <div class="overlay-f relative"></div>
                <img src="{{ asset('assets/home13/images/elements/step1.svg')}}" alt="">
                <h4 class="feat-head">Create Account</h4>
                <p class="feat-desc">Lorem ipsum dolor sit amet, adipiscing elit. Integer tellus estt congue sed  dolor sit amet, adipis  dolor sit amet.</p>
            </div>
        </div>
        <div class="col-md-4 col-sm-6">
            <div class="feat-box v2 text-center">
                <img src="{{ asset('assets/home13/images/elements/step2.svg')}}" alt="">
                <h4 class="feat-head">Describe your System</h4>
                <p class="feat-desc">Lorem ipsum dolor sit amet, adipiscing elit. Integer tellus estt congue sed  dolor sit amet, adipis  dolor sit amet.</p>
            </div>
        </div>
        <div class="col-md-4 col-sm-6">
            <div class="feat-box v2 text-center">
                <img src="{{ asset('assets/home13/images/elements/step3.svg')}}" alt="">
                <h4 class="feat-head">Automate Solution</h4>
                <p class="feat-desc">Lorem ipsum dolor sit amet, adipiscing elit. Integer tellus estt congue sed  dolor sit amet, adipis  dolor sit amet.</p>
            </div>
        </div>

    </div>
</div>
</section>

<!-- START ABOUT -->
<section id="about" class="section_padding no-pt">
<div class="container">
    <div class="row flex relative align-items-center">

        <div class="row">

            <div class="box-shadow col-md-10 " style="background: #fff;">
                <div class="row">
                    <div class="col-md-5 no-pl col-sm-12 col-xs-12">
                        <div class="about_img">
                            <img src="{{ asset('assets/home13/images/about1.png')}}" alt="about-img">
                            <a href="#" class="video-btn"><i class="fa fa-play"></i></a>
                        </div>
                    </div>
                    <div class="col-md-7 col-sm-12 col-xs-12">
                        <div class="about_content_area">
                            <h5 class="blue has-before">Dedicated Artificial Intelligence</h5>
                            <h3>Get Benefits of using latest Artificial Intelligence.</h3>
                            <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Integer tellus est, finibus ut congue sed, faucibus ut dui. Sed congue nisl dolor, id dapibus leo elementum posuere. Ut aliquam metus quis laoreet elementum. In hac habitasse platea dictumst. In hac habitasse platea dictumst.</p>
                            <div class="about_me">
                                <div class="name">
                                    <span>Company Name</span>
                                    Your Company Name
                                </div>

                                <div class="phone">
                                    <span>Phone Number</span>
                                    +00 253 265 4455
                                </div>
                                <div class="email">
                                    <span>Contact Email</span>
                                    <a href="mailto:info@yourdomain.com">info@yourdomain.com</a>
                                </div>
                            </div>

                            <div class="about_btn">
                                <a href="#0" class="btn btn-default contact_number hidden-md">contact Us</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-2"><div class="about-txt"> <span>ABOUT US</span></div></div>

        </div>
    </div>
</div> <!--- END CONTAINER -->
</section>
<!-- END ABOUT -->

<!-- START FEATURES -->
<section  class="features section_padding pb_70">
<div class="container">

    <div class="row">
        <div class="col-md-6 col-sm-12 col-xs-12">
            <div class="resume-container">
                <div class="row">

                    <div class="col-md-12">
                        <h5 class="c-cyan">Why Choose Us</h5>
                        <h3 class="w-text"><i class="icon-trophy"></i>Core Features:</h3>
                        <div class="single_resume wow fadeInLeft" data-wow-delay="0.2s">
                            <div class="icon-box">
                                <img src="{{ asset('assets/home13/images/elements/i1.png')}}" alt="">
                            </div>
                            <div class="resume-desc">
                                <h5 class="w-text">Smart Analyzer of the News</h5>
                                <p class="g-text">Lorem ipsum dolor sit amet, consectetur adipisicing
                                elit. Enim eveniet incidunt</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-12">
                        <div class="single_resume wow fadeInLeft" data-wow-delay="0.4s">
                            <div class="icon-box">
                                <img src="{{ asset('assets/home13/images/elements/i2.png')}}" alt="">
                            </div>
                            <div class="resume-desc">
                                <h5 class="w-text">Adaptive Chatbot Assistant</h5>
                                <p class="g-text">Lorem ipsum dolor sit amet, consectetur adipisicing
                                elit. Enim eveniet incidunt</p>
                            </div>

                        </div>
                    </div>
                    <div class="col-md-12">
                        <div class="single_resume wow fadeInLeft" data-wow-delay="0.6s">
                            <div class="icon-box">
                                <img src="{{ asset('assets/home13/images/elements/i3.png')}}" alt="">
                            </div>
                            <div class="resume-desc">
                                <h5 class="w-text">Creative AI Platform</h5>
                                <p class="g-text">Lorem ipsum dolor sit amet, consectetur adipisicing
                                elit. Enim eveniet incidunt</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-6 col-sm-12 col-xs-12">

        </div>
    </div> <!--- END ROW -->
</div> <!--- END CONTAINER -->
</section>
<!-- END FEATURES -->

<!-- START COUNTER -->
<section id="counter_area" class="counter-v2 gray_bg section_padding">
<div class="container">
    <div class="row text-left">
        <div class="col-md-7">
            <div class="content_area">
                <h5 class="blue has-before">Dedicated Artificial Intelligence</h5>
                <h3>Get Benefits of using latest Artificial Intelligence Technologies.</h3>
                <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Integer tellus est, finibus ut congue sed, faucibus ut dui. Sed congue nisl dolor, id dapibus leo elementum posuere. Ut aliquam metus In hac habitasse platea dictumst. In hac habitasse platea dictumst.</p>
                <div class="row">
                    <div class="col-sm-6 col-xs-12">
                        <div class="feat-box">
                            <img src="{{ asset('assets/home13/images/elements/f1.png')}}" alt="">
                            <h4 class="feat-head">Dedicated Support</h4>
                            <p class="feat-desc">Lorem ipsum dolor sit amet, adipiscing elit. Integer tellus estt congue sed.</p>
                        </div>

                    </div>
                    <div class="col-sm-6 col-xs-12">
                        <div class="feat-box">
                            <img src="{{ asset('assets/home13/images/elements/f2.png')}}" alt="">
                            <h4 class="feat-head">Latest Technologies</h4>
                            <p class="feat-desc">Lorem ipsum dolor sit amet, adipiscing elit. Integer tellus estt congue sed.</p>
                        </div>

                    </div>

                </div>
            </div>
        </div>
        <div class="col-md-5 col-sm-12 col-xs-12 wow fadeInRight" data-wow-delay="0.2s">
            <div class="facts-wrapper box-shadow">
                <h5 class="blue has-before">Our Fun Facts</h5>
                <h3>Number We Proud Of</h3>
                <p>Lorem ipsum dolor sit amet, it amet, consectetur adip consectetur adipiscing elit. Integer tellus est, finibus ut cit amet, consectetur adip</p>
                <div class="single_counter">
                    <span class="co-inner">01</span>
                    <div class="icon">
                        <i class="icon-happy"></i>
                    </div>
                    <div class="counter-desc">
                        <span class="counter">751</span>
                        <p>Happy Clients</p>
                    </div>
                </div>

                <div class="single_counter">
                    <span class="co-inner">02</span>
                    <div class="icon">
                        <i class="icon-trophy"></i>
                    </div>
                    <div class="counter-desc">
                        <span class="counter">56</span>
                        <p>Awards Received</p>
                    </div>
                </div>

                <div class="single_counter">
                    <span class="co-inner">03</span>
                    <div class="icon">
                        <i class="icon-briefcase"></i>
                    </div>
                    <div class="counter-desc">
                        <span class="counter">478</span>
                        <p>Successul Projects</p>
                    </div>
                </div>

                <div class="single_counter mb-0">
                    <span class="co-inner">04</span>
                    <div class="icon">
                        <i class="icon-profile-male"></i>
                    </div>
                    <div class="counter-desc">
                        <span class="counter">234</span>
                        <p>Team Members</p>
                    </div>
                </div>
            </div>


        </div>

    </div> <!--- END ROW -->
</div> <!--- END CONTAINER -->
</section>
<!-- END COUNTER -->


<!-- START SERVICE -->
<section id="service" class="serv-bg section_padding pb_70">
<div class="container">
    <div class="section_heading text-center">
        <h2 class="w-text">Our Main Services</h2>
        <p class="g-text">Lorem ipsum dolor sit amet, consectetur adipiscing elit. Phasellus molestie, justo nec convallis sollicitudin.</p>
    </div>

    <div class="row text-center">
        <div class="col-md-12 col-sm-12 col-xs-12">
            <div class="service_slider owl-carousel">
                <div class="single_service">
                    <div class="service_icon">
                        <img src="{{ asset('assets/home13/images/elements/serv1.png')}}" alt="">
                    </div>
                    <h4>System Automation</h4>
                    <P>Lorem ipsum dolor sit amet, consectetur adipiscing elit, Integer tellus est.</P>
                    <a href="#0" class="btn graen-btn">Learn More</a>
                </div>
                <div class="single_service">
                    <div class="service_icon">
                        <img src="{{ asset('assets/home13/images/elements/serv2.png')}}" alt="">
                    </div>
                    <h4> Targeted AI Merketing</h4>
                    <P>Lorem ipsum dolor sit amet, consectetur adipiscing elit, Integer tellus est.</P>
                    <a href="#0" class="btn graen-btn">Learn More</a>
                </div>
                <div class="single_service">
                    <div class="service_icon">
                        <img src="{{ asset('assets/home13/images/elements/serv3.png')}}" alt="">
                    </div>
                    <h4>Mobile Security</h4>
                    <P>Lorem ipsum dolor sit amet, consectetur adipiscing elit, Integer tellus est.</P>
                    <a href="#0" class="btn graen-btn">Learn More</a>
                </div>
                <div class="single_service">
                    <div class="service_icon">
                        <img src="{{ asset('assets/home13/images/elements/serv4.png')}}" alt="">
                    </div>
                    <h4>AI Business Training</h4>
                    <P>Lorem ipsum dolor sit amet, consectetur adipiscing elit, Integer tellus est.</P>
                    <a href="#0" class="btn graen-btn">Learn More</a>
                </div>
                <div class="single_service">
                    <div class="service_icon">
                        <img src="{{ asset('assets/home13/images/elements/serv5.png')}}" alt="">
                    </div>
                    <h4>Business Consulting</h4>
                    <P>Lorem ipsum dolor sit amet, consectetur adipiscing elit, Integer tellus est.</P>
                    <a href="#0" class="btn graen-btn">Learn More</a>
                </div>
                <div class="single_service">
                    <div class="service_icon">
                        <img src="{{ asset('assets/home13/images/elements/serv6.png')}}" alt="">
                    </div>
                    <h4>AI-Based Investments</h4>
                    <P>Lorem ipsum dolor sit amet, consectetur adipiscing elit, Integer tellus est.</P>
                    <a href="#0" class="btn graen-btn">Learn More</a>
                </div>
            </div>
        </div> <!-- End Col -->
    </div> <!--- END ROW -->
</div> <!--- END CONTAINER -->
</section>
<!-- END SERVICE -->

<!-- START TESTIMONIALS -->
<section id="testimonial_area" class="section_padding relative test-bg">
<div class="testimonial-bg"></div>
<div class="container">
    <div class="section_heading text-center">
        <h2 class="">What Clients are Saying</h2>
        <p class="">Lorem ipsum dolor sit amet, consectetur adipiscing elit. Phasellus molestie, justo nec convallis sollicitudin.</p>
    </div>
    <div class="row">
        <div class="col-md-10 col-md-offset-1 over-hiddern text-center">
            <div class="testimonial_area owl-carousel">
                <div class="single_testimonial">
                    <p class="description">
                        Lorem ipsum dolor sit amet, consectetur adipisicing elit. A accusantium ad asperiores at atque culpa dolores eaque fugiat hic illo ipsam ipsum minima modi necessitatibus nemo officia, omnis perferendis placeat quaerat quas quis ratione rerum sint sit vitae.
                    </p>
                    <div class="pic">
                        <img src="{{ asset('assets/home13/images/testimonial/1.jpg')}}" alt="" />
                    </div>
                    <h5 class="title">William Baker</h5>
                    <span class="post">Developer</span>
                </div><!-- end Single Testimonials -->

                <div class="single_testimonial">
                    <p class="description">
                        Lorem ipsum dolor sit amet, consectetur adipisicing elit. A accusantium ad asperiores at atque culpa dolores eaque fugiat hic illo ipsam ipsum minima modi necessitatibus nemo officia, omnis perferendis placeat quaerat quas quis ratione rerum sint sit vitae.
                    </p>
                    <div class="pic">
                        <img src="{{ asset('assets/home13/images/testimonial/2.jpg')}}" alt="" />
                    </div>
                    <h5 class="title">James Baker</h5>
                    <span class="post">Designer</span>
                </div><!-- end Single Testimonials -->

                <div class="single_testimonial">
                    <p class="description">
                        Lorem ipsum dolor sit amet, consectetur adipisicing elit. A accusantium ad asperiores at atque culpa dolores eaque fugiat hic illo ipsam ipsum minima modi necessitatibus nemo officia, omnis perferendis placeat quaerat quas quis ratione rerum sint sit vitae.
                    </p>
                    <div class="pic">
                        <img src="{{ asset('assets/home13/images/testimonial/3.jpg')}}" alt="" />
                    </div>
                    <h5 class="title">William Baker</h5>
                    <span class="post">Developer</span>
                </div><!-- end Single Testimonials -->

                <div class="single_testimonial">
                    <p class="description">
                        Lorem ipsum dolor sit amet, consectetur adipisicing elit. A accusantium ad asperiores at atque culpa dolores eaque fugiat hic illo ipsam ipsum minima modi necessitatibus nemo officia, omnis perferendis placeat quaerat quas quis ratione rerum sint sit vitae.
                    </p>
                    <div class="pic">
                        <img src="{{ asset('assets/home13/images/testimonial/4.jpg')}}" alt="" />
                    </div>
                    <h5 class="title">James Baker</h5>
                    <span class="post">Designer</span>
                </div><!-- end Single Testimonials -->
            </div>
        </div>
    </div> <!--- END ROW -->
</div> <!--- END CONTAINER -->
</section>
<!-- END TESTIMONIALS -->

<!-- START BLOG -->
<section id="blog" class="gray_bg section_padding pb_70">
<div class="container">
    <div class="section_heading text-center">
        <h2>Latest Blog Posts</h2>
        <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Phasellus molestie, justo nec convallis sollicitudin.</p>
    </div>

    <div class="row">
        <div class="blog_slide_area">
            @if(!empty($recent_blogs))
                @foreach ($recent_blogs as $recent_blog)
                    <div class="col-md-4 col-sm-6 col-xs-12">
                        <div class="single_blog">
                            <div class="blog-thumb">
                                <div class="blog-image">
                                    @if(file_exists( storage_path().'/blog/'.$recent_blog->image ) && !empty($recent_blog->image))
                                    <img src="{{asset('storage')}}/blog/{{ $recent_blog->image }}" class="img-responsive" alt="...">
                                    @else
                                    <img class="img-fluid" src="{{ asset('assets/img/blog/blog-thumb-01.jpg') }}" class="img-responsive" alt="">
                                    @endif

                                </div>
                                <div class="blog-info">
                                    <small><i class="fa fa-clock-o"></i>{{date('F d, Y', strtotime($recent_blog->created_at))}}</small>
                                    <span>| {{$recent_blog->tags}}</span>
                                    <a href="{{route('blog.details',encrypted_key($recent_blog->id,"encrypt"))}}"><h4>{{$recent_blog->title}}</h4></a>
                                    <p>{!!substr_replace($recent_blog->article, "...", 100)!!}</p>
                                    <a href="{{route('blog.details',encrypted_key($recent_blog->id,"encrypt"))}}" class="btn graen-btn">Read More</a>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            @endif


        </div>
    </div> <!--- END ROW -->
</div> <!--- END CONTAINER -->
</section>
<!-- END BLOG -->

<section class="Contact-us section_padding relative" id="contact">
<div class="container">
    <div class="row">
        <div class="col-md-2">
            <div class="about2-wrap relative"></div>
        </div>
        <div class="box-shadow col-md-10">
            <div class="row">
                <div class="col-md-6 no-pl col-sm-12 col-xs-12">
                    <div class="about_img">
                        <img src="{{ asset('assets/home13/images/about3.png')}}" alt="about-img" />
                    </div>
                </div>
                <div class="col-md-6 col-sm-12 col-xs-12">
                    <div class="about_content_area">
                        <h5 class="blue">You Are Welcome to become our Client</h5>
                        <h3>Contact Us Now!</h3>
                        <div class="contact">
                            <form method="post" action="{{route('contact_us')}}" enctype="multipart/form-data">
                                {!! csrf_field() !!}
                                <div class="row">
                                    <div class="input_padding text-center">
                                        <div class="form-group col-sm-12">
                                            <input type="text" name="name" class="form-control" id="first-name" placeholder="Name *" required="required">
                                        </div>
                                        <div class="form-group col-sm-12">
                                            <input type="email" name="email" class="form-control" id="email" placeholder="Email *" required="required">
                                        </div>
                                        <div class="form-group col-sm-12">
                                            <input type="text" name="subject" class="form-control" id="subject" placeholder="Subject *" required="required">
                                        </div>
                                        <div class="form-group col-sm-12 mab-none">
                                            <textarea rows="8" name="message" class="form-control" id="description" placeholder="Your Message Here ..." required="required"></textarea>
                                        </div>
                                        <div class="form-group mb0 col-sm-12">
                                            <div class="actions">
                                                <button type="submit" value="Send Your Message" name="submit" id="submitButton" class="btn graen-btn" title="Click here to submit your message!">Send Your Message</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
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
<!-- START FOOTER -->
<footer class="footer-sec">
<div class="container">
    <div class="row text-center">

        <div class="col-md-8 col-md-offset-2 col-xs-12">
            <div class="sub_title">
                @if (count($footerWidget1))
                        @foreach ($footerWidget1 as $key => $menu)
                            @if ($menu)
                                <a href="{{url(str_replace('_','-',$menu))}}"> <span>{{$key}}</span></a>
                            @endif
                        @endforeach
                @else


                    <a href=""><span>Find Candidates</span></a>
                    <a href=""><span>Post a Job</span></a>
                    <a href=""><span>Resume Search</span></a>
                    <a href=""><span>Impact</span></a>
                    <a href=""><span>Staffing</span></a>

                @endif
            </div>
            <ul class="banner_social_link">
                <li><a href="#00"><i class="fa fa-facebook"></i></a></li>
                <li><a href="#0"><i class="fa fa-twitter"></i></a></li>
                <li><a href="#0"><i class="fa fa-linkedin"></i></a></li>
                <li><a href="#0"><i class="fa fa-instagram"></i></a></li>
                <li><a href="#0"><i class="fa fa-behance"></i></a></li>
            </ul>

            <p class="w-text">{{$footer_text}}</p>
        </div> <!-- END COL -->
    </div> <!--- END ROW -->
</div> <!--- END CONTAINER -->
</footer>
<!-- END FOOTER -->
@endsection
