@extends('layout.frontend.home20.mainlayout')
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
<div class="main-wrapper">

    <!-- =========================
         PRELOADER
    ============================== -->
    <div class="preloader">
        <div class="loader-container">
            <div class="text-logo">@if (!empty($logo_favicon['logo']))
                <img src="{{ asset('storage/logo').'/'.$logo_favicon['logo'] }}"alt="LogoImage" >
            @else
                <span class="logo-text">@if(!empty($logoTxt)) {{ $logoTxt }} @else Your Logo Here @endif</span>
            @endif</div>
            <div class="signal"></div>
        </div>
    </div>


    <!-- =========================
         HEADER
    ============================== -->
    <header class="header" id="top" data-stellar-background-ratio="0.5">
        <!-- Background Overlay -->
        <div class="overlay">

            <!-- =========================================
                 Navigation
            ========================================== -->
            <nav class="navbar navbar-fixed-top" role="navigation">
                <div class="container">
                    <div class="row">
                        <div class="col-md-12">
                            <!-- Navbar-Header -->
                            <div class="navbar-header">

                                <!-- Mobile Menu -->
                                <button data-target=".navbar-collapse" data-toggle="collapse" class="navbar-toggle" type="button">
                                    <i class="icon icon_menu"></i>
                                </button>

                                <!-- Text-Logo -->
                                <a href="#top" class="navbar-brand scrollto" title="SmartMvp">
                                    <span class="text-logo">@if (!empty($logo_favicon['logo']))
                                        <img src="{{ asset('storage/logo').'/'.$logo_favicon['logo'] }}"alt="LogoImage" >
                                    @else
                                        <span class="logo-text">@if(!empty($logoTxt)) {{ $logoTxt }} @else Your Logo Here @endif</span>
                                    @endif</span>
                                </a>

                                <!-- Image-Logo: Remove this comments and the section above Text-Logo if you want to add an Image-Logo (recommended sizes -> max-height:50, max-width:200)

                                <a href="#top" class="navbar-brand img-logo scrollto" title="SmartMvp">
                                    <img src="{{ asset('assets/home20/images/logo.png')}}" alt="Logo">
                                </a>
                                -->

                            </div><!-- /End Navbar-Header -->

                            <!-- Navbar-Collapse -->
                            <div class="navbar-collapse collapse">
                                <ul class="nav navbar-nav navbar-right">
                                    <!-- Menu Items -->
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
                                            <li><a href='{{ url("$dId/donation")}}'  class="btn btn-nav">Donate</a></li>
                                                @endif
                                        @endif
                                            <li> <a class="btn btn-nav" href="{{ route('login') }}">log In</a></li>



                                    @else
                                    <li><a href="{{ route('home') }}" class="btn btn-nav btn-color">Dashboard</a></li>


                                @endguest

                                </ul>
                            </div><!-- /End Navbar-Collapse -->
                        </div><!-- /End Col -->
                    </div><!-- /End Row -->
                </div><!-- /End Container -->
            </nav><!-- /End Sticky Navigation -->


            <!-- =========================================
                 Login/Signup Bootstrap Modal
            ==========================================  -->
            <div class="modal fade login" id="loginModal">
                <div class="modal-dialog">
                    <div class="modal-content">

                        <!-- Modal-Header -->
                        <div class="modal-header">
                            <!-- Close Button -->
                            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">
                                <i class="icon icon_close_alt2"></i>
                            </button>
                            <!-- Modal-Header Title-->
                            <h4 class="modal-title">Sign in to <span>Smartmvp</span></h4>
                            <p class="modal-subtitle">Enter your email and password</p>
                        </div><!-- /End Modal-Header -->

                        <!-- Modal-Body Content -->
                        <div class="modal-body">
                            <div class="box">
                                 <div class="content">
                                    <!-- Login Form -->
                                    <div class="loginBox">
                                        <form id="login-modal" role="form">
                                            <!-- Success/Alert Notification -->
                                            <p class="lm-success"><i class="icon icon_check_alt2"></i> <strong>Congratulation! Login modal validation is working. Implement your code.</strong></p>
                                            <p class="lm-failed"><i class="icon icon_close_alt2"></i><strong> Something went wrong! Insert correct value.</strong></p>
                                            <!-- Input Fields -->
                                            <input id="lm-email" class="form-control input-lg" type="text" placeholder="Email" name="lm-email" required>
                                            <input id="lm-password" class="form-control input-lg" type="password" placeholder="Password" name="lm-password" required>
                                            <!-- Login Button -->
                                            <button class="btn btn-color">Login</button>
                                        </form>
                                    </div><!-- /End Login Form -->
                                 </div>
                            </div><!-- /End Login Form Box -->
                            <div class="box">
                                <!-- Signup Form -->
                                <div class="content registerBox" style="display:none;">
                                    <form id="signup-modal" role="form">
                                        <!-- Success/Alert Notification -->
                                        <p class="sm-success"><i class="icon icon_check_alt2"></i> <strong>Congratulation! Signup modal validation is working. Implement your code.</strong></p>
                                        <p class="sm-failed"><i class="icon icon_close_alt2"></i><strong> Something went wrong! Insert correct value.</strong></p>
                                        <!-- Input Fields -->
                                        <input id="sm-email" class="form-control input-lg" type="text" placeholder="Email" name="sm-email" required>
                                        <input id="sm-password" class="form-control input-lg" type="password" placeholder="Password" name="sm-password">
                                        <input id="sm-confirm" class="form-control input-lg" type="password" placeholder="Repeat Password" name="sm-confirm">
                                        <!-- Signup Button -->
                                        <button class="btn btn-color">Create Account</button>
                                    </form>

                                </div><!-- /End Signup Form -->
                            </div><!-- /End Signup Form Box -->
                        </div><!-- /End Modal-Body -->

                        <!-- Modal-Footer -->
                        <div class="modal-footer">
                            <!-- Login-Footer. Redirect to Signup-Modal-->
                            <div class="forgot login-footer">
                                <span>Don't have an account?
                                     <a href="javascript: showRegisterForm();">Sign up.</a>
                                </span>
                            </div>
                            <!-- Signup-Footer. Redirect to Login-Modal -->
                            <div class="forgot register-footer" style="display:none">
                                 <span>Already have an account?</span>
                                 <a href="javascript: showLoginForm();">Login</a>
                            </div>
                        </div><!-- /End Modal-Footer -->

                    </div><!-- /End Modal Content -->
                </div><!-- /End Modal Dialog -->
            </div><!-- /End Modal -->


            <!-- =========================================
                 Hero-Section
            ========================================== -->
            <div class="container vmiddle">
                <div class="row">
                    <div class="col-md-8">
                        <div class="hero-section">

                            <!-- Welcome - Hero Message -->
                            <h1 class="text-white">Achieve Better Marketing Results with Clean &amp; Beautiful Design</h1>
                            <p class="text-white">Your starting point for building successful software products.</p>

                            <!-- Learn More & Video Buttons -->
                            <div class="btn-box">
                                <a href="#about" class="btn btn-ghost scrollto">Learn More</a>
                                <!-- Video Lightbox on Click -->
                                <a href="http://youtu.be/SZEflIVnhH8" data-type="youtube" class="btn btn-color venobox"><i class="icon arrow_triangle-right_alt"></i>Play video</a>
                            </div>

                        </div><!-- /End Intro-Section -->
                    </div><!-- /End Col -->
                </div><!-- /End Row -->
            </div><!-- /End Container Hero-Section -->


        </div><!-- /End Background Overlay -->
    </header>
    <!-- =========================
         /END HEADER
    ============================== -->


    <!-- =================================
         SECTION ABOUT - INTRO FEATURES
    ====================================== -->
    <section class="intro-features" id="about">
        <div class="container">
            <!-- Padding -->
            <div class="wrapper-lg">
                <div class="row">
                    <!-- Section Header Title -->
                    <div class="col-xs-12">
                        <h2>It's about making ideas happen</h2>
                        <p class="large">Spend less time worrying about front-end and more focusing on your product.</p>
                    </div>
                </div>
                <!-- Three Main Features with Icons -->
                <div class="row">
                    <div class="col-sm-4 intro-content">
                        <div class="icon-lg">
                            <i class="icon icon-mobile"></i>
                        </div>
                        <h4>Responsive Layout</h4>
                        <p>Optio dolores expedita unde vel laudantium enim nisi eos distinctio, rem. Repellat repudiandae quos laborum magni.</p>
                    </div>
                    <div class="col-sm-4 intro-content">
                        <div class="icon-lg">
                            <i class="icon icon-browser"></i>
                        </div>
                        <h4>Easy to Customize</h4>
                        <p>Praesentium reprehenderit quae, sequi deserunt laboriosam velit necessitatibus nulla ea optio, quis nam pariatur.</p>
                    </div>
                    <div class="col-sm-4 intro-content">
                        <div class="icon-lg">
                            <i class="icon icon-documents"></i>
                        </div>
                        <h4>Fully Documented</h4>
                        <p>Aperiam recusandae ipsa culpa, cupiditate magnam dolor molestiae, omnis, architecto possimus aperiam corrupti corporis.</p>
                    </div>
                </div><!-- /End Row -->
            </div><!-- /End Wrapper -->
        </div><!-- /End Container -->
    </section>
    <!-- =============================
         /END INTRO FEATURES
    ============================== -->


    <!-- ==================================================
         SECTION 2 COLS - IMAGE RIGHT AND TEXT WITH CALL TO ACTION
    ======================================================= -->
    <section class="img-with-action light-bg">
        <div class="container wrapper-lg">
            <div class="row">
                <div class="col-lg-5 col-md-5">
                    <!-- Text Col -->
                    <h3>Validate your Business Idea and Reach Product Market Fit</h3>
                    <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Facere veritatis inventore eum, cupiditate esse debitis consectetur nisi harum. Tempore, assumenda ducimus vero totam labore. Ipsam, eos odit eaque, voluptatum minima, odio eveniet soluta saepe, culpa quo enim omnis iusto. Possimus, at numquam beatae non atque?</p>
                    <!-- Call To Action Buttons -->
                    <div class="btn-box">
                        <a href="#features" class="btn btn-grey scrollto">Learn More</a>
                        <a href="#canvas-bg" class="btn btn-color scrollto"><i class="icon arrow_carrot-2dwnn_alt"></i>Try it for Free</a>
                    </div>
                    <!-- Div Required for Correct Charts Animation -->
                    <div class="start-charts"></div>
                </div>
            </div><!-- /End Row-->
        </div><!-- /End Container-->
        <!-- Image Col -->
        <div class="hidden-sm hidden-xs col-md-6 img-col-bg img-right"></div>
    </section>
    <!-- =============================
         /END SECTION
    ============================== -->


    <!-- ==================================================
        CHARTS & SHOWCASE SECTION
    ======================================================= -->
    <section class="charts" id="charts">
        <div class="container">
            <div class="wrapper-lg">
                <div class="row">
                    <div class="col-md-12">
                        <h2>Get out of the Building</h2>
                        <p class="large">Ideal for SaaS, Web Apps, Mobile Apps and all kind of Marketing websites.</p>
                    </div>
                </div>

                <div class="row doughnut-box">
                    <div class="col-md-5">
                        <!-- Div Required for Correct Line Chart Animation -->
                        <div class="start-line"></div>
                        <!-- Chart Text Description -->
                        <h4>Everything you need to get your Startup Business online and ready to go.</h4>
                        <p>Perferendis aliquid accusamus nostrum recusandae maxime dolor dolorum numquam pariatur quasi sit, in, culpa hic, fugiat dignissimos fuga necessitatibus tempore molestias ipsum corporis distinctio. Minima mollitia.</p>
                        <p><a href="#canvas-bg" class="scrollto"><strong>Join with us. It will only take a minute ›</strong></a></p>
                    </div>
                    <div class="col-md-7">
                        <!-- Doughnut Charts  -->
                        <div id="canvas-holder">
                            <div class="chart-text">
                                100&#37;<span>Crafted with<br> Passion</span>
                            </div>
                            <canvas id="chart-area" width="400" height="400"></canvas>
                        </div>
                        <div id="canvas2-holder">
                            <div class="chart2-text">
                                827<span>Cups of<br>Coffee</span>
                            </div>
                            <canvas id="chart2-area" width="300" height="300"></canvas>
                        </div>
                    </div>
                </div><!-- /End Chart-Box -->

                <div class="row chart-box">
                    <div class="col-md-6 col-md-push-6 col-sm-12">
                        <!-- Chart Text Description -->
                        <h4>SmartMvp <strong>breathes new life</strong> into your App, Product or Saas landing page.</h4>
                        <p>Exercitationem, hic commodi libero reprehenderit id iusto, consequatur unde pariatur recusandae dicta sequi voluptatum quae corrupti culpa quibusdam nihil error harum itaque praesentium quidem corporis cupiditate voluptatem. Error tempore aperiam nulla saepe corrupti!</p>
                        <p><a href="#features" class="scrollto"><strong>Learn how customize SmartMvp ›</strong></a></p>
                    </div>
                    <div class="col-md-6 col-md-pull-6 col-sm-12">
                        <!-- Line Chart -->
                        <div class="line-canvas">
                            <div>
                                <canvas id="line-canvas" height="450" width="600"></canvas>
                            </div>
                        </div>
                    </div>
                </div><!-- /End Chart-Box -->

                <div class="row showcase">
                    <div class="col-md-4">
                        <h4>Fully Responsive Layout that will adapt itself to any mobile device.</h4>
                        <p>Praesentium voluptatem excepturi corporis labore architecto eos ea molestiae saepe facere at voluptate similique iusto porro pariatur, dolorum dolor magni sint eveniet iste. Eaque, aliquam, dignissimos.</p>
                        <p><a href="#mobile-download" class="scrollto"><strong>Download the App for your smartphone ›</strong></a></p>
                    </div>
                    <div class="col-md-8">
                        <!-- Devices Image -->
                        <div class="img-box">
                            <img src="{{ asset('assets/home20/images/showcase.png')}}" alt="" class="img-responsive">
                            <a href="http://youtu.be/SZEflIVnhH8" data-type="youtube" class="venobox video-player"><i class="icon arrow_triangle-right_alt2 wow fadeIn" data-wow-duration="2s"></i></a>
                        </div>
                    </div>
                </div><!-- /End Chart-Box -->

            </div><!-- /End Wrapper -->
        </div><!-- /End Container -->
    </section>
    <!-- =============================
         /END CHARTS SECTION
    ============================== -->


    <!-- ==================================================
        FEATURES SECTION
    ======================================================= -->
    <section class="tab-features color-bg" id="features">
        <div class="container">
            <div class="features-title">
                <div class="row">
                    <div class="col-md-12">
                        <h2 class="text-white">Explore Features</h2>
                        <p class="large text-white">The MVP is more than just a product, it's a way of thinking.</p>
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-xs-12">
                <!-- Features Tab -->
                <div class="tabs features tab-container">
                    <ul class="etabs">
                        <!-- Feature Icon -->
                        <li class="tab">
                                <a href="#tab-feature-1">
                                    <div class="icon-sm">
                                        <i class="icon icon-layers"></i>
                                    </div>
                                    <h5 class="text-white">Flexible User<br> Interface</h5>
                                </a>
                        </li>
                        <!-- Feature Icon -->
                        <li class="tab">
                                <a href="#tab-feature-2">
                                    <div class="icon-sm">
                                        <i class="icon icon-pictures"></i>
                                    </div>
                                    <h5 class="text-white">Multiple Layout<br> Options</h5>
                                </a>
                        </li>
                        <!-- Feature Icon -->
                        <li class="tab">
                                <a href="#tab-feature-3">
                                    <div class="icon-sm">
                                        <i class="icon icon-grid"></i>
                                    </div>
                                    <h5 class="text-white">Built on <br>Bootstrap 3.2</h5>
                                </a>
                        </li>
                        <!-- Feature Icon -->
                        <li class="tab">
                                <a href="#tab-feature-4">
                                    <div class="icon-sm">
                                        <i class="icon icon-chat"></i>
                                    </div>
                                    <h5 class="text-white">Support Forum <br>Access</h5>
                                </a>
                        </li>
                        <!-- Feature Icon -->
                        <li class="tab">
                                <a href="#tab-feature-5">
                                    <div class="icon-sm">
                                        <i class="icon icon-lightbulb"></i>
                                    </div>
                                    <h5 class="text-white">Designed for <br>Startups</h5>
                                </a>
                        </li>
                    </ul><!-- /End Etabs -->

                    <div class="panel-container">

                        <div class="tab-content" id="tab-feature-1">
                            <div class="container">
                                <div class="row">
                                    <!-- Feature Description 2cols Text-Left with Buttons -->
                                    <div class="col-md-5 col-sm-6">
                                        <h4>SmartMvp is a startup landing page with usable, versatile and modular features.</h4>
                                        <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Eius non velit optio veniam reprehenderit quod! Maiores asperiores dolorem doloremque tempore reiciendis voluptatem expedita, tempora, deserunt ducimus impedit animi quis eum, itaque laudantium ea perferendis nisi. Similique eaque esse praesentium laudantium deserunt quos incidunt sed porro maiores dolore voluptate quod quisquam, architecto eos dicta quae magni.</p>
                                        <div class="btn-box">
                                            <a href="#testimonials" class="btn btn-grey scrollto">Our Clients</a>
                                            <a href="#team" class="btn btn-grey scrollto">Meet the Team</a>
                                        </div>
                                    </div>
                                    <!-- Image-right -->
                                    <div class="col-md-7 col-sm-6 hidden-xs wow fadeInRight" data-wow-duration="2s">
                                        <img src="{{ asset('assets/home20/images/features/feature1.png')}}" alt="">
                                    </div>
                                </div>
                            </div>
                        </div><!-- /End Tab-content -->

                        <div class="tab-content" id="tab-feature-2">
                            <div class="container">
                                <div class="row">
                                    <!-- Feature Description 2cols Text-Right with Icons -->
                                    <div class="col-xs-12 col-sm-6 col-sm-push-6 col-lg-7 col-lg-push-5">
                                        <h4>SmartMvp is a high-quality solution for those who want a beautiful website in no time</h4>
                                        <p>Similique eaque esse praesentium laudantium deserunt quos incidunt sed porro maiores dolore voluptate quod quisquam.</p>
                                        <div class="tab-icon">
                                            <div class="icon-sm">
                                                <i class="icon icon-adjustments"></i>
                                            </div>
                                            <p class="large">Numerous Colour Schemes</p>
                                            <p> Ipsum, ratione. Dolor illo numquam dolorem consequuntur, ex vitae, ipsum tenetur nihil soluta. Eaque at laboriosam similique?</p>
                                        </div>
                                        <div class="tab-icon">
                                            <div class="icon-sm">
                                                <i class="icon icon-target"></i>
                                            </div>
                                            <p class="large">Tons of Elements</p>
                                            <p> Repudiandae expedita, non aperiam, ea quia dolorem quidem pariatur culpa explicabo voluptatem alias voluptas itaque similique officia.</p>
                                        </div>
                                    </div>
                                    <!-- Image-Left -->
                                    <div class="col-xs-12 col-sm-6 col-sm-pull-6 col-lg-5 col-lg-pull-7 hidden-xs wow fadeInLeft" data-wow-duration="2s">
                                        <img src="{{ asset('assets/home20/images/features/feature2.png')}}" class="img-device" alt="">
                                    </div>
                                </div>
                            </div>
                        </div><!-- / End Tab-content -->

                        <div class="tab-content" id="tab-feature-3">
                            <div class="container">
                                <div class="row">
                                    <!-- Feature Description 2cols Text-Left -->
                                    <div class="col-md-5 col-sm-6">
                                        <h4>SmartMvp is a fully responsive landing page template with awesome features and interactive elements.</h4>
                                        <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Eius non velit optio veniam reprehenderit quod! Maiores asperiores dolorem doloremque tempore reiciendis voluptatem expedita, tempora, deserunt ducimus impedit animi quis eum, itaque laudantium ea perferendis nisi.</p>
                                    </div>
                                    <!-- Image-Right -->
                                    <div class="col-md-7 col-sm-6 hidden-xs wow fadeInRight" data-wow-duration="2s">
                                        <img src="{{ asset('assets/home20/images/features/feature3.png')}}" alt="">
                                    </div>
                                </div>
                            </div>
                        </div><!-- /End Tab-content -->

                        <div class="tab-content" id="tab-feature-4">
                            <div class="container">
                                <div class="row">
                                    <!-- Feature Description 2col Text-Left with Icons-->
                                    <div class="col-md-7 col-sm-6">
                                        <h4>There are a lot of different blocks that will help you to make a perfect project.</h4>
                                        <p>Deserunt ducimus impedit animi quis eum, itaque laudantium ea perferendis nisi. Similique eaque esse.</p>
                                        <div class="tab-icon">
                                            <div class="icon-sm">
                                                <i class="icon icon-profile-male"></i>
                                            </div>
                                            <p class="large">Amazingly Simple Use</p>
                                            <p>Tempora, veniam. Tempore nihil praesentium obcaecati velit, harum nam dicta sequi quam sunt incidunt facilis itaque..</p>
                                        </div>
                                        <div class="tab-icon">
                                            <div class="icon-sm">
                                                <i class="icon icon-compass"></i>
                                            </div>
                                            <p class="large">Clear Documentation</p>
                                            <p>Officia illum, perferendis dolorum dolor sit eveniet, tempore incidunt animi totam qui voluptas, inventore velit illo!</p>
                                        </div>
                                    </div>
                                    <!-- Image Right -->
                                    <div class="col-md-5 col-sm-6 hidden-xs wow fadeInRight" data-wow-duration="2s">
                                        <img src="{{ asset('assets/home20/images/features/feature4.png')}}" class="img-device" alt="">
                                    </div>
                                </div>
                            </div>
                        </div><!-- /End Tab-content -->

                        <div class="tab-content" id="tab-feature-5">
                            <div class="container">
                                <div class="row">
                                    <!-- Feature Description 2col Text both -->
                                    <div class="col-xs-12">
                                        <div class="col-sm-6">
                                            <h4>Publish your Startup in Beautiful Way.</h4>
                                            <p>Similique eaque esse praesentium laudantium deserunt quos incidunt sed porro maiores dolore voluptate quod quisquam, architecto eos dicta quae magni vero unde necessitatibus. Lorem ipsum dolor sit amet, consectetur adipisicing.</p>
                                        </div>
                                        <div class="col-sm-6">
                                            <h4>Take a Second and Explore it!</h4>
                                            <p>Inventore distinctio placeat fugiat reiciendis repudiandae et iste, aut sunt ad. Ab temporibus animi harum quo enim magnam rerum odit quos molestias ipsam! Perferendis eum nobis aliquid, facere modi quos, possimus deleniti labore sit cupiditate, culpa consequatur.</p>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <!-- Image below -->
                                    <div class="col-xs-12 hidden-xs wow fadeInUp" data-wow-duration="2s">
                                        <img src="{{ asset('assets/home20/images/features/feature5.png')}}" class="img-device" alt="">
                                    </div>
                                </div>
                            </div>
                        </div><!-- / End Tab-content -->

                    </div><!-- / End Panel-Container -->
                </div><!-- / End Tabs -->
            </div><!-- /End Col -->
        </div><!-- /End Row -->
    </section>
    <!-- =============================
         /END FEATURES TAB
    ============================== -->


    <!-- ==================================================
        SIGNUP DIVIDER
    ======================================================= -->
    <section id="canvas-bg" class="dark-bg signup-divider">
        <div class="container">
            <div class="wrapper-lg">
                <div class="row">
                    <div class="col-md-12">
                        <h2 class="text-white">Start your free, no-risk, 30 day trial!</h2>
                        <p class="large text-white">No credit card required. Upgrade, downgrade, or cancel anytime.</p>
                        <!-- Handwritten text with arrow -->
                        <p class="signup-handwritten text-white">Why wait? Start now! <br>No credit card needed</p>
                    </div>
                </div>

                <div class="row">
                    <!-- Signup Form -->
                    <form id="signup-divider" role="form">
                        <!-- Notification -->
                        <p class="signup-success"><i class="icon icon_check_alt2"></i> <strong>Congratulation! Welcome to 30 day Free Trial. Check your email address.</strong></p>
                        <p class="signup-failed"><i class="icon icon_close_alt2"></i><strong> Something went wrong! Insert correct value.</strong></p>

                        <!-- Input fields -->
                        <div class="form-group">
                            <input type="email" name="signup-email" id="signup-email" class="form-control input-lg" placeholder="Enter your Email-Address" required>
                        </div>
                        <div class="form-group">
                            <input type="password" size="25" name="signup-password" id="signup-password" class="form-control input-lg" placeholder="Enter your Password" required>
                        </div>
                        <!-- Signup Button -->
                        <button class="btn btn-color">Join Today <i class="icon arrow_right"></i></button>
                    </form>
                </div><!-- /End Row -->
            </div><!-- /End Wrapper -->
        </div><!-- /End Container -->
    </section>
    <!-- =============================
         /END SIGNUP SECTION
    ============================== -->


    <!-- =============================
         PRICING SECTION
    ============================== -->
    <section class="pricing" id="pricing">
        <div class="container">
            <div class="wrapper-lg">
                <div class="row">
                    <div class="col-xs-12">
                        <h2>Get Started Today</h2>
                        <p class="large">Choose the plan that suits you best. 30 Days Free Trial with all plans.</p>
                    </div>
                </div>

                <!-- Pricing Tabs-->
                <div class="row grid-md">
                    <div class="col-sm-4">
                        <div class="pricing-tab">
                            <p class="price">$19<span>/mo</span></p>
                            <h4>Small</h4>
                            <ul class="pricing-features">
                                <li>30 GB storage</li>
                                <li>200 GB bandwidth<span>(approx lorem ipsum)</span></li>
                                <li>10 email accounts</li>
                                <li>10 MySql databases</li>
                                <li>3 support tickets per month</li>
                            </ul>
                            <a href="#canvas-bg" class="btn btn-color scrollto">Subscribe</a>
                        </div>
                    </div>

                    <div class="col-sm-4">
                        <div class="pricing-tab">
                            <div class="ribbon">
                                <h5 class="popular">Popular</h5>
                            </div>
                            <p class="price">$79<span>/mo</span></p>
                            <h4>Medium</h4>
                            <ul class="pricing-features">
                                <li>100 GB storage</li>
                                <li>500 GB bandwidth<span>(approx lorem ipsum)</span></li>
                                <li>50 email accounts</li>
                                <li>50 MySql databases</li>
                                <li>5 support tickets per month</li>
                            </ul>
                            <a href="#canvas-bg" class="btn btn-color scrollto">Subscribe</a>
                        </div>
                    </div>

                    <div class="col-sm-4">
                        <div class="pricing-tab">
                            <p class="price">$199<span>/mo</span></p>
                            <h4>Large</h4>
                            <ul class="pricing-features">
                                <li>Unlimited storage</li>
                                <li>Unlimited bandwidth<span>(lorem ipsum)</span></li>
                                <li>Unlimited email account</li>
                                <li>Unlimited databases</li>
                                <li>Unlimited support</li>
                            </ul>
                            <a href="#canvas-bg" class="btn btn-color scrollto">Subscribe</a>
                        </div>
                    </div>


                    <!-- Pricing Footer -->
                    <div class="row">
                        <div class="col-xs-12">
                            <div class="pricing-more">
                                <p><strong>Looking for more?</strong> &mdash; Tell us what you need. Lorem ipsum dolor sit amet, consectetur adipisicing elit. Deserunt nesciunt sed molestiae quos, dolor eaque quis facilis tempora consequuntur doloribus omnis cumque fugiat. Qui rerum quis mollitia incidunt reprehenderit expedita, non cumque tenetur deleniti! <strong> <a href="mailto:support@themedept.com">Contact us <i class="icon arrow_carrot-right_alt2"></i></a></strong> </p>
                            </div>
                        </div>
                    </div><!-- /End Row Pricing Footer -->

                </div><!-- /End Row Pricing Tab -->
            </div><!-- /End Wrapper -->
        </div><!-- /End Container -->
    </section>
    <!-- =============================
         /END PRICING SECTION
    ============================== -->


    <!-- =======================================================
         TESTIMONIALS WITH PRESS/CLIENTS LOGOS
    ============================================================ -->
    <section class="testimonial-press light-bg" id="testimonials">
        <div class="container vmiddle">
            <div class="row">
                <div class="col-md-12">
                    <h2>What our users are saying</h2>
                    <p class="large">Find out why our users keep using SmartMvp</p>
                </div>
            </div>
            <div class="row">
                <div class="tabs testimonials tab-container">
                    <div class="col-md-8">
                        <div class="panel-container">
                            <div class="tab-block" id="tab-testimonials-1">
                                <blockquote>
                                    <!-- Testimonial quote -->
                                    <p>Placeat ut recusandae maiores, aliquam error. Sequi accusamus nostrum porro reprehenderit commodi delectus omnis similique possimus non aut, dicta rem iste nemo perferendis, incidunt mollitia asperiores at tenetur dolores ut libero necessitatibus veritatis fuga. Ut sequi assumenda odit.</p>
                                    <!-- Testimonial image -->
                                    <img src="{{ asset('assets/home20/images/testimonials/testimonial-1.jpg')}}" alt=" ">
                                    <!-- Testimonial info -->
                                    <p class="testimonial-name"><span>James Knight</span>Manager @ LoremIpsum</p>
                                </blockquote>
                            </div><!-- /End Tab-block -->
                            <div class="tab-block" id="tab-testimonials-2">
                                <blockquote>
                                    <!-- Testimonial quote -->
                                    <p>Iusto quam fugit consequatur explicabo at deserunt eius vel, debitis non itaque blanditiis error iure modi, asperiores molestiae dolorum! Earum expedita sit, nesciunt neque magnam at dolorem praesentium saepe! Rerum recusandae qui quidem, a neque consequatur laboriosam.</p>
                                    <!-- Testimonial image -->
                                    <img src="{{ asset('assets/home20/images/testimonials/testimonial-2.jpg')}}" alt=" ">
                                    <!-- Testimonial info -->
                                    <p class="testimonial-name"><span>Nathan Wood</span>Chief Technology Officer @ StartupIpsum</p>
                                </blockquote>
                            </div><!-- /End Tab-block -->
                            <div class="tab-block" id="tab-testimonials-3">
                                <blockquote>
                                    <!-- Testimonial quote -->
                                    <p>Commodi quod eligendi molestiae quaerat temporibus odio alias, nobis repudiandae eum molestias libero modi non ipsum architecto facere cumque esse veritatis voluptatibus. Quia eius nulla deleniti impedit officia quidem temporibus, enim! Ab ex, ipsa ullam asperiores itaque.</p>
                                    <!-- Testimonial image -->
                                    <img src="{{ asset('assets/home20/images/testimonials/testimonial-3.jpg')}}" alt=" ">
                                    <!-- Testimonial info -->
                                    <p class="testimonial-name"><span>Amber Evans</span>Chief Marketing Officer @ AgencyLorem</p>
                                </blockquote>
                            </div><!-- /End Tab-block -->
                            <div class="tab-block" id="tab-testimonials-4">
                                <blockquote>
                                    <!-- Testimonial quote -->
                                    <p>Aliquid doloremque ipsum ipsam molestias aliquam ab quod mollitia sed. Vero sapiente voluptatem, voluptatum excepturi a doloribus. Dicta sit quo sed, eaque! Voluptates in illo maiores corporis? Placeat ut recusandae maiores, aliquam error. Sequi accusamus nostrum porro.</p>
                                    <!-- Testimonial image -->
                                    <img src="{{ asset('assets/home20/images/testimonials/testimonial-4.jpg')}}" alt=" ">
                                    <!-- Testimonial info -->
                                    <p class="testimonial-name"><span>Harry Palmer</span>CEO and Founder @ IpsumSite</p>
                                </blockquote>
                            </div><!-- /End Tab-block -->
                        </div><!-- /End Panel-container -->
                    </div><!-- /End Col -->

                    <ul class="etabs col-md-4 list-unstyled">
                        @if(!empty($partners))
                        @foreach($partners as $partner)
                            <li class="tab col-md-6">
                                <a href="{{ @$partner->link }}">
                                    <!-- Testimonial logo -->
                                    <img src="{{asset('storage')}}/partner/{{ $partner->logo }}" alt="">
                                </a>
                            </li>
                        @endforeach
                    @endif
                    </ul><!-- /End Etabs -->

                </div><!-- /End Tabs -->
            </div><!-- /End Row -->
        </div><!-- /End Container -->
    </section>
    <!-- =============================
         /END TESTIMONIALS
    ============================== -->


    <!-- ==================================================
        TEAM
    ======================================================= -->
    <section class="team" id="team">
        <div class="container">
            <div class="wrapper-lg">
                <div class="row">
                    <div class="col-md-12">
                        <h2>Meet the Team</h2>
                        <p class="large">We are a passionate team of designers, developers and marketing experts with headquarters in Melbourne.</p>
                    </div>
                </div>
                <div class="row">
                    <!-- Team Box -->
                    <div class="col-sm-4 team-box">
                        <div class="team-img">
                            <img src="{{ asset('assets/home20/images/team-3.jpg')}}" class="img-responsive" alt="">
                            <div class="img-overlay">
                                <div class="img-icons">
                                    <span class="icon-white">
                                        <a href="#">
                                            <i class="icon icon-facebook"></i>
                                        </a>
                                    </span>
                                    <span class="icon-white">
                                        <a href="#">
                                            <i class="icon icon-twitter"></i>
                                        </a>
                                    </span>
                                    <span class="icon-white">
                                        <a href="#">
                                            <i class="icon icon-linkedin"></i>
                                        </a>
                                    </span>
                                </div>
                            </div>
                        </div>
                        <h4>Lukas Mayr</h4>
                        <p class="team-bio"><span class="text-color">Lead designer</span> with experience in most things visual. He loves trying out new techniques and finding the perfect solution for any kind of requirements.</p>
                    </div>
                    <!-- Team Box -->
                    <div class="col-sm-4 team-box">
                        <div class="team-img">
                            <img src="{{ asset('assets/home20/images/team-1.jpg')}}" class="img-responsive" alt="">
                            <div class="img-overlay">
                                <div class="img-icons">
                                    <span class="icon-white">
                                        <a href="#">
                                            <i class="icon icon-facebook"></i>
                                        </a>
                                    </span>
                                    <span class="icon-white">
                                        <a href="#">
                                            <i class="icon icon-twitter"></i>
                                        </a>
                                    </span>
                                    <span class="icon-white">
                                        <a href="#">
                                            <i class="icon icon-linkedin"></i>
                                        </a>
                                    </span>
                                </div>
                            </div>
                        </div>
                        <h4>Isabella Knudsen</h4>
                        <p class="team-bio"><span class="text-color">Director of Growth and Customer Acquisition</span>. She enjoys the finer details of a project, considering every stage of its journey from planning to completion.</p>
                    </div>
                    <!-- Team Box -->
                    <div class="col-sm-4 team-box">
                        <div class="team-img">
                            <img src="{{ asset('assets/home20/images/team-2.jpg')}}" class="img-responsive" alt="">
                            <div class="img-overlay">
                                <div class="img-icons">
                                    <span class="icon-white">
                                        <a href="#">
                                            <i class="icon icon-facebook"></i>
                                        </a>
                                    </span>
                                    <span class="icon-white">
                                        <a href="#">
                                            <i class="icon icon-twitter"></i>
                                        </a>
                                    </span>
                                    <span class="icon-white">
                                        <a href="#">
                                            <i class="icon icon-linkedin"></i>
                                        </a>
                                    </span>
                                </div>
                            </div>
                        </div>
                        <h4>Adrien Simon</h4>
                        <p class="team-bio"><span class="text-color">Full stack hacker, product design, backend development, user interface and everything in between.</span> He likes to keep things simple and focus on the little details.</p>
                    </div>
                </div><!-- /End Row -->
            </div><!-- End Wrapper -->
        </div><!--/End Container -->
    </section>
    <!-- =============================
         /END TEAM SECTION
    ============================== -->


    <!-- ==================================================
        MOBILE DOWNLOAD SECTION
    ======================================================= -->
    <section class="mobile-download light-bg" id="mobile-download">
        <div class="container">
            <div class="wrapper-lg">
                <div class="row">
                    <div class="col-md-12">
                        <h2>Download the App</h2>
                        <p class="large">Don't miss the chance to get our amazing Mobile Application. Get connected anytime.</p>
                    </div>
                </div>
                <div class="row">
                    <!-- Text and Mobile Download Buttons -->
                    <div class="col-sm-6 col-md-4">
                        <h3>Supercharge your Productivity</h3>
                        <p class="mobile-text">With an online dashboard and a mobile app, you'll have full control of your account and see your usage in real-time. <span class="text-color">Even more convenient!</span></p>
                        <a href="#" class="btn btn-color"><i class="icon icon_cloud-download_alt"></i>Download Now!!</a>
                    </div>

                    <div class="col-sm-6 col-md-4">
                        <!-- Screenshot Carousel -->
                        <div class="shot-container">
                            <div id="owl-carousel-shots-phone" class="owl-carousel">
                                <div class="owl-container text-center shots-modal">
                                    <img src="{{ asset('assets/home20/images/app-screenshots/app-screenshot1alt.jpg')}}" alt="" title="this is the title" />
                                </div>
                                <div class="owl-container text-center shots-modal">
                                    <img src="{{ asset('assets/home20/images/app-screenshots/app-screenshot2alt.jpg')}}" alt="" title="this is the title" />
                                </div>
                                <div class="owl-container text-center shots-modal">
                                    <img src="{{ asset('assets/home20/images/app-screenshots/app-screenshot3alt.jpg')}}" alt="" title="this is the title" />
                                </div>
                            </div><!-- /End owl carousel-->
                        </div><!-- /End Container -->
                    </div>

                    <div class="col-sm-12 col-md-4 right-features">
                        <!-- More Features -->
                        <div class="col-sm-4 col-md-12">
                            <h4>Get Notified</h4>
                            <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Magnam inventore.</p>
                        </div>
                        <div class="col-sm-4 col-md-12">
                            <h4>Add Data in Seconds</h4>
                            <p>Magnam beatae similique molestias incidunt, assumenda dolorem ea deserunt.</p>
                        </div>
                        <div class="col-sm-4 col-md-12">
                            <h4>Real Time Alerts</h4>
                            <p>Accusantium at sapiente mollitia asperiores quisquam rerum hic et animi.</p>
                        </div>
                    </div>
                </div><!-- /End Row -->
            </div><!-- /End Wrapper -->
        </div><!-- /End Container -->
    </section>
    <!-- =============================
         /END MOBILE DOWNLOAD SECTION
    ============================== -->


    <!-- ==================================================
        NEWSLETTER AND SOCIAL DIVIDER
    ======================================================= -->
    <section class="newsletter color-bg" id="newsletter">
        <div class="container">
            <div class="wrapper-sm">
                <div class="row">
                    <div class="col-md-6">
                        <!-- =========================
                            Social Icons
                        ============================== -->
                        <div class="table">
                            <div class="table-row">
                                <div class="table-cell follow">
                                    <h5 class="table-title">Follow Us</h5>
                                </div>
                                <div class="table-cell">
                                    <ul class="social-list">
                                        <li>
                                            <a href="#">
                                                <i class="icon icon-facebook"></i>
                                            </a>
                                        </li>
                                        <li>
                                            <a href="#">
                                                <i class="icon icon-twitter"></i>
                                            </a>
                                        </li>
                                        <li>
                                            <a href="#">
                                                <i class="icon icon-googleplus"></i>
                                            </a>
                                        </li>
                                        <li>
                                            <a href="#">
                                                <i class="icon icon-linkedin"></i>
                                            </a>
                                        </li>
                                    </ul>
                                </div><!-- /End Table-Cell -->
                            </div><!-- /End Table-Row -->
                        </div><!-- /End Table -->
                    </div><!-- /End Col -->

                    <div class="col-md-6">
                        <!-- =========================
                            MAILCHIMP SUBSCRIPTION FORM
                        ============================== -->
                        <form class="mailchimp-subscribe" role="form"  action="{{url('subscribe')}}" enctype="multipart/form-data">
                            <div class="table">
                                <div class="table-row">
                                    <div class="table-cell getnewsletter">
                                        <h5 class="table-title">Get the Newsletter</h5>
                                    </div>

                                        <div class="table-cell">
                                            <div class="input-group text-white">
                                                {!! csrf_field() !!}
                                                <!-- Input Form -->
                                                <input type="email" name="email" required id="subscriber-email" name="email" placeholder="Your email address" class="form-control">
                                                <!-- Submit Button -->
                                                <span class="input-group-btn">
                                                    <button type="submit" class="btn btn-white">Subscribe</button>
                                                </span>
                                            </div><!-- /End Input Group -->
                                        </div><!-- /End Table-Cell -->

                                </div><!-- /End Table-Row -->
                            </div><!-- /End Table -->
                            <div class="col-md-10 col-md-offset-1 col-sm-8 col-sm-offset-2">
                                <!-- Notifications -->
                                <p class="mc-success"></p>
                                <p class="mc-failed"></p>
                            </div>
                        </form><!-- /End Mailchimp Subscribe Form -->

                        <!-- =========================
                            LOCAL SUBSCRIPTION FORM
                        ============================== -->
                        <!-- ALTERNATE USE: SAVE YOUR SUBSCRIBE LIST IN .TXT

                        <form id="subscribe" role="form">
                            <div class="table">
                                <div class="table-row">
                                    <div class="table-cell getnewsletter">
                                        <h5 class="table-title">Get the Newsletter</h5>
                                    </div>
                                </div>
                                <div class="table-cell">
                                    <div class="input-group">
                                        <input type="email" id="s-email" name="email" placeholder="Your email address" class="form-control">
                                        <span class="input-group-btn">
                                            <button class="btn btn-color">Submit</button>
                                        </span>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-10 col-md-offset-1 col-sm-8 col-sm-offset-2">
                                <p class="subscription-success"><i class="icon icon_check_alt2"></i> You are successfully subscribed for our newsletter.</p>
                                <p class="subscription-failed"><i class="icon icon_close_alt2"></i> Something went wrong!</p>
                            </div>
                        </form>
                        -->

                    </div><!-- /End Col -->
                </div><!-- /End Row -->
            </div><!-- End Wrapper -->
        </div><!-- /End Container -->
    </section>
    <!-- =============================
         /END NEWSLETTER SECTION
    ============================== -->

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
    <!-- ==================================================
        FOOTER
    ======================================================= -->
    <footer class="footer dark-bg" id="footer">
        <div class="container">
            <div class="wrapper-lg">
                <div class="row">
                    <!-- Footer Left Col -->
                    <div class="col-md-5">
                            <!-- Logo -->
                            <a href="/" class="scrollto" title="SmartMvp">
                                <span class="text-logo"> @if (!empty($logo_favicon['logo']))
                                    <img src="{{ asset('storage/logo').'/'.$logo_favicon['logo'] }}" >
                                @else
                                        <img src="{{ asset('assets/main/images/logo.png')}}">
                                @endif</span>
                            </a>
                            <p class="footer-hero"><strong>600.000</strong> users registered since January.<br>
                            We've created the product that will help your startup get better marketing results.</p>

                    </div>
                    <!-- Footer Contact Col -->
                    <div class="col-md-3">
                        <h5 class="text-white">Our Contact</h5>
                        <div class="contact-item">
                            <div class="contact-icon">
                                <i class="icon icon_mail"></i>
                            </div>
                            <div class="contact-content">
                                <a href="mailto:mail@themedept.com">mail@themedept.com</a>
                            </div>
                        </div>
                        <div class="contact-item">
                            <div class="contact-icon">
                                <i class="icon icon_pin"></i>
                            </div>
                            <div class="contact-content">
                                121 King Street, Melbourne<br>
                                Victoria 3000 Australia
                            </div>
                        </div>
                        <div class="contact-item">
                            <div class="contact-icon">
                                <i class="icon icon_phone"></i>
                            </div>
                            <div class="contact-content">
                                1-234-567-89
                            </div>
                        </div>
                    </div>
                    <!-- Footer Right Col: Twitter Feed -->
                    <div class="col-md-4">
                            <h5 class="text-white">Recent Tweets</h5>
                            <div class="tweet">
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

                    <!-- Footer Menu and Copy -->
                    <div class="row">
                        <div class="col-md-12">
                            <ul class="footer-nav">
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
                            <p class="footer-copy">{{$footer_text}}</a></p>
                        </div>
                    </div>

                </div><!-- End Row -->
            </div><!-- /End Wrapper -->
        </div><!-- /End Container -->
    </footer>

</div><!-- /End Main Wrapper -->
@endsection
