@extends('layout.frontend.home9.mainlayout')
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
<div class="content-wrapper">
    <header class="wrapper bg-soft-primary">
      <nav class="navbar navbar-expand-lg center-logo transparent position-absolute navbar-dark">
        <div class="container justify-content-between align-items-center">
          <div class="d-flex flex-row w-100 justify-content-between align-items-center d-lg-none">
            <div class="navbar-brand"><a href="/">

                @if (!empty($logo_favicon['logo']))
                <img class="logo-dark" src="{{ asset('storage/logo').'/'.$logo_favicon['logo'] }}" alt="LogoImage" >
                <img class="logo-light" src="{{ asset('storage/logo').'/'.$logo_favicon['logo'] }}" alt="LogoImage" >
            @else

                @if(!empty($logoTxt)) {{ $logoTxt }} @else Your Logo Here @endif
            @endif

              </a></div>
            <div class="navbar-other ms-auto">
              <ul class="navbar-nav flex-row align-items-center" data-sm-skip="true">
                <li class="nav-item d-lg-none">
                  <div class="navbar-hamburger"><button class="hamburger animate plain" data-toggle="offcanvas-nav"><span></span></button></div>
                </li>
              </ul>
              <!-- /.navbar-nav -->
            </div>
            <!-- /.navbar-other -->
          </div>
          <!-- /.d-flex -->
          <div class="navbar-collapse-wrapper d-flex flex-row align-items-center w-100">
            <div class="navbar-collapse offcanvas-nav">
              <div class="offcanvas-header mx-lg-auto order-0 order-lg-1 d-lg-flex px-lg-15">
                @if (!empty($logo_favicon['logo']))
                    <img class="logo-dark" src="{{ asset('storage/logo').'/'.$logo_favicon['logo'] }}" alt="LogoImage" >
                    <img class="logo-light" src="{{ asset('storage/logo').'/'.$logo_favicon['logo'] }}" alt="LogoImage" >
                @else

                    @if(!empty($logoTxt)) {{ $logoTxt }} @else Your Logo Here @endif
                @endif

                <button type="button" class="btn-close btn-close-white offcanvas-close offcanvas-nav-close d-md-none" aria-label="Close"></button>
              </div>
              <div class="w-100 order-1 order-lg-0 d-lg-flex">
                <ul class="navbar-nav ms-lg-auto">
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
                <!-- /.navbar-nav -->
              </div>
              <div class="w-100 order-3 order-lg-2 d-lg-flex">
                <ul class="navbar-nav me-lg-auto">


                    @guest

                    @if ($donation = \App\PublicPageDetail::where('user_id',get_domain_user()->id)->first())
                        @php $dId = base64_encode($donation->id);
                        $user_setting = DB::table('website_setting')->where('user_domain_id', get_domain_id())->where('name', 'payment_settings')->first();
                    @endphp
                        @if($user_setting != null)
                        <li class="nav-item dropdown"> <a class="nav-link" href='{{ url("$dId/donation")}}' >Donate</a></li>
                            @endif
                    @endif
                    <li class="nav-item dropdown">  <a class="nav-link"   href="{{ route('login') }}">log In</a></li>



                @else
                <li class="nav-item dropdown">   <a class="nav-link" href="{{ route('home') }}" >Dashboard</a></li>

            @endguest


                      <!--/.mega-menu-content-->
                    </ul>
                    <!--/.dropdown-menu -->
                  </li>

                </ul>
                <!-- /.navbar-nav -->
              </div>
            </div>
            <!-- /.navbar-collapse -->
          </div>
          <!-- /.navbar-collapse-wrapper -->
        </div>
        <!-- /.container -->
      </nav>
      <!-- /.navbar -->
    </header>
    <!-- /header -->
    <section class="wrapper image-wrapper bg-image bg-overlay bg-overlay-300 text-white" data-image-src="{{ asset('assets/home9/img/photos/bg2.jpg')}}">
      <div class="container pt-17 pb-19 pt-md-19 pb-md-20 light-gallery-wrapper text-center">
        <div class="row mb-11">
          <div class="col-md-9 col-lg-7 col-xxl-6 mx-auto" data-cues="zoomIn" data-group="page-title" data-interval="-200">
            <h2 class="h6 text-uppercase ls-xl text-white mb-5">Hello! This is Sandbox</h2>
            <h3 class="display-1 text-white mb-7">We bring rapid solutions for your business</h3>
            <a href="https://vimeo.com/374265101" class="btn btn-circle btn-white btn-play ripple mx-auto mb-5 lightbox"><i class="icn-caret-right"></i></a>
          </div>
          <!-- /column -->
        </div>
        <!-- /.row -->
      </div>
      <!-- /.container -->
    </section>
    <!-- /section -->
    <section class="wrapper bg-light angled upper-end lower-end">
      <div class="container pb-14 pb-md-16">
        <div class="row">
          <div class="col-12 mt-n20">
            <figure class="rounded"><img src="{{ asset('assets/home9/img/photos/about5.jpg')}}" srcset="{{ asset('assets/home9/img/photos/about5@2x.jpg')}} 2x" alt="" /></figure>
            <div class="row" data-cue="slideInUp">
              <div class="col-xl-10 mx-auto">
                <div class="card image-wrapper bg-full bg-image bg-overlay bg-overlay-300 text-white mt-n5 mt-lg-0 mt-lg-n50p mb-lg-n50p border-radius-lg-top" data-image-src="{{ asset('assets/home9/img/photos/bg2.jpg')}}">
                  <div class="card-body p-9 p-xl-10">
                    <div class="row align-items-center counter-wrapper gy-4 text-center">
                      <div class="col-6 col-lg-3">
                        <h3 class="counter counter-lg text-white">7518</h3>
                        <p>Completed Projects</p>
                      </div>
                      <!--/column -->
                      <div class="col-6 col-lg-3">
                        <h3 class="counter counter-lg text-white">3472</h3>
                        <p>Satisfied Customers</p>
                      </div>
                      <!--/column -->
                      <div class="col-6 col-lg-3">
                        <h3 class="counter counter-lg text-white">2184</h3>
                        <p>Expert Employees</p>
                      </div>
                      <!--/column -->
                      <div class="col-6 col-lg-3">
                        <h3 class="counter counter-lg text-white">4523</h3>
                        <p>Awards Won</p>
                      </div>
                      <!--/column -->
                    </div>
                    <!--/.row -->
                  </div>
                  <!--/.card-body -->
                </div>
                <!--/.card -->
              </div>
              <!-- /column -->
            </div>
            <!-- /.row -->
          </div>
          <!-- /column -->
        </div>
        <!-- /.row -->
        <div class="row gx-lg-8 gy-8 mt-5 mt-md-12 mt-lg-0 mb-15 align-items-center">
          <div class="col-lg-6 order-lg-2">
            <div class="row gx-md-5 gy-5" data-cues="fadeIn" data-group="images">
              <div class="col-md-4 offset-md-2 align-self-end">
                <figure class="rounded"><img src="{{ asset('assets/home9/img/photos/g1.jpg')}}" srcset="{{ asset('assets/home9/img/photos/g1@2x.jpg')}} 2x" alt=""></figure>
              </div>
              <!--/column -->
              <div class="col-md-6 align-self-end">
                <figure class="rounded"><img src="{{ asset('assets/home9/img/photos/g2.jpg')}}" srcset="{{ asset('assets/home9/img/photos/g2@2x.jpg')}} 2x" alt=""></figure>
              </div>
              <!--/column -->
              <div class="col-md-6 offset-md-1">
                <figure class="rounded"><img src="{{ asset('assets/home9/img/photos/g3.jpg')}}" srcset="{{ asset('assets/home9/img/photos/g3@2x.jpg')}} 2x" alt=""></figure>
              </div>
              <!--/column -->
              <div class="col-md-4 align-self-start">
                <figure class="rounded"><img src="{{ asset('assets/home9/img/photos/g4.jpg')}}" srcset="{{ asset('assets/home9/img/photos/g4@2x.jpg')}} 2x" alt=""></figure>
              </div>
              <!--/column -->
            </div>
            <!--/.row -->
          </div>
          <!--/column -->
          <div class="col-lg-6">
            <h2 class="display-4 mb-3">What We Do?</h2>
            <p class="lead fs-lg mb-8 pe-xxl-2">The full service we are offering is <span class="underline">specifically</span> designed to meet your business needs and projects.</p>
            <div class="row gx-xl-10 gy-6" data-cues="slideInUp" data-group="services">
              <div class="col-md-6 col-lg-12 col-xl-6">
                <div class="d-flex flex-row">
                  <div>
                    <div class="icon btn btn-circle btn-lg btn-soft-primary disabled me-5"> <i class="uil uil-phone-volume"></i> </div>
                  </div>
                  <div>
                    <h4 class="mb-1">24/7 Support</h4>
                    <p class="mb-0">Nulla vitae elit libero pharetra augue dapibus.</p>
                  </div>
                </div>
              </div>
              <!--/column -->
              <div class="col-md-6 col-lg-12 col-xl-6">
                <div class="d-flex flex-row">
                  <div>
                    <div class="icon btn btn-circle btn-lg btn-soft-primary disabled me-5"> <i class="uil uil-shield-exclamation"></i> </div>
                  </div>
                  <div>
                    <h4 class="mb-1">Secure Payments</h4>
                    <p class="mb-0">Vivamus sagittis lacus augue laoreet vel.</p>
                  </div>
                </div>
              </div>
              <!--/column -->
              <div class="col-md-6 col-lg-12 col-xl-6">
                <div class="d-flex flex-row">
                  <div>
                    <div class="icon btn btn-circle btn-lg btn-soft-primary disabled me-5"> <i class="uil uil-laptop-cloud"></i> </div>
                  </div>
                  <div>
                    <h4 class="mb-1">Daily Updates</h4>
                    <p class="mb-0">Cras mattis consectetur purus sit amet.</p>
                  </div>
                </div>
              </div>
              <!--/column -->
              <div class="col-md-6 col-lg-12 col-xl-6">
                <div class="d-flex flex-row">
                  <div>
                    <div class="icon btn btn-circle btn-lg btn-soft-primary disabled me-5"> <i class="uil uil-chart-line"></i> </div>
                  </div>
                  <div>
                    <h4 class="mb-1">Market Research</h4>
                    <p class="mb-0">Aenean lacinia bibendum nulla sed consectetur.</p>
                  </div>
                </div>
              </div>
              <!--/column -->
            </div>
            <!--/.row -->
          </div>
          <!--/column -->
        </div>
        <!--/.row -->
        <h2 class="display-4 mb-3">How We Do It?</h2>
        <p class="lead fs-lg mb-8">We make your spending <span class="underline">stress-free</span> for you to have the perfect control.</p>
        <div class="row gx-lg-8 gx-xl-12 gy-6 process-wrapper line" data-cues="slideInUp" data-group="process">
          <div class="col-md-6 col-lg-3"> <span class="icon btn btn-circle btn-lg btn-soft-primary disabled mb-4"><span class="number">01</span></span>
            <h4 class="mb-1">Concept</h4>
            <p>Nulla vitae elit libero elit non porta gravida eget metus cras. Aenean eu leo quam. Pellentesque ornare.</p>
          </div>
          <!--/column -->
          <div class="col-md-6 col-lg-3"> <span class="icon btn btn-circle btn-lg btn-primary disabled mb-4"><span class="number">02</span></span>
            <h4 class="mb-1">Prepare</h4>
            <p>Vestibulum id ligula porta felis euismod semper. Sed posuere consectetur est at lobortis.</p>
          </div>
          <!--/column -->
          <div class="col-md-6 col-lg-3"> <span class="icon btn btn-circle btn-lg btn-soft-primary disabled mb-4"><span class="number">03</span></span>
            <h4 class="mb-1">Retouch</h4>
            <p>Integer posuere erat a ante venenatis dapibus posuere velit aliquet. Nulla vitae elit libero.</p>
          </div>
          <!--/column -->
          <div class="col-md-6 col-lg-3"> <span class="icon btn btn-circle btn-lg btn-soft-primary disabled mb-4"><span class="number">04</span></span>
            <h4 class="mb-1">Finalize</h4>
            <p>Integer posuere erat, consectetur adipiscing elit. Fusce dapibus, tellus ac cursus commodo.</p>
          </div>
          <!--/column -->
        </div>
        <!--/.row -->
      </div>
      <!-- /.container -->
    </section>
    <!-- /section -->
    <section class="wrapper image-wrapper bg-image bg-overlay bg-overlay-300 text-white" data-image-src="{{ asset('assets/home9/img/photos/bg2.jpg')}}">
      <div class="container py-14 py-md-17">
        <h2 class="display-4 mb-5 text-white text-center">Happy Customers</h2>
        <div class="row">
          <div class="col-md-10 col-lg-8 mx-auto" data-cue="fadeIn">
            <div class="basic-slider owl-carousel gap-small dots-over text-center mb-n2" data-margin="30">
              <div class="item">
                <blockquote class="border-0 fs-lg">
                  <p>“Vivamus sagittis lacus vel augue laoreet rutrum faucibus dolor auctor. Vestibulum ligula porta felis euismod semper. Cras justo odio consectetur adipiscing dapibus.”</p>
                  <div class="blockquote-details justify-content-center">
                    <img class="rounded-circle w-12" src="{{ asset('assets/home9/img/avatars/te1.jpg')}}" srcset="{{ asset('assets/home9/img/avatars/te1@2x.jpg')}} 2x" alt="" />
                    <div class="info">
                      <h6 class="mb-1 text-white">Coriss Ambady</h6>
                      <p class="mb-0">Financial Analyst</p>
                    </div>
                  </div>
                </blockquote>
              </div>
              <!-- /.item -->
              <div class="item">
                <blockquote class="border-0 fs-lg">
                  <p>“Vivamus sagittis lacus vel augue laoreet rutrum faucibus dolor auctor. Vestibulum ligula porta felis euismod semper. Cras justo odio consectetur adipiscing dapibus.”</p>
                  <div class="blockquote-details justify-content-center">
                    <img class="rounded-circle w-12" src="{{ asset('assets/home9/img/avatars/te2.jpg')}}" srcset="{{ asset('assets/home9/img/avatars/te2@2x.jpg')}} 2x" alt="" />
                    <div class="info">
                      <h6 class="mb-1 text-white">Cory Zamora</h6>
                      <p class="mb-0">Marketing Specialist</p>
                    </div>
                  </div>
                </blockquote>
              </div>
              <!-- /.item -->
              <div class="item">
                <blockquote class="border-0 fs-lg">
                  <p>“Vivamus sagittis lacus vel augue laoreet rutrum faucibus dolor auctor. Vestibulum ligula porta felis euismod semper. Cras justo odio consectetur adipiscing dapibus.”</p>
                  <div class="blockquote-details justify-content-center">
                    <img class="rounded-circle w-12" src="{{ asset('assets/home9/img/avatars/te3.jpg')}}" srcset="{{ asset('assets/home9/img/avatars/te3@2x.jpg')}} 2x" alt="" />
                    <div class="info">
                      <h6 class="mb-1 text-white">Nikolas Brooten</h6>
                      <p class="mb-0">Sales Manager</p>
                    </div>
                  </div>
                </blockquote>
              </div>
              <!-- /.item -->
            </div>
            <!-- /.owl-carousel -->
          </div>
          <!-- /column -->
        </div>
        <!-- /.row -->
      </div>
      <!-- /.container -->
    </section>
    <!-- /section -->
    <section class="wrapper bg-light">
      <div class="container py-14 py-md-16">
        <div class="row align-items-center mb-7">
          <div class="col-md-8 col-lg-8 col-xl-7 col-xxl-6 pe-lg-17">
            <h2 class="display-4 mb-3">Recent Projects</h2>
            <p class="lead fs-lg">We love to turn ideas into <span class="underline">beautiful things</span>.</p>
          </div>
          <!--/column -->
        </div>
        <!--/.row -->
        <div class="grid grid-view projects-tiles">
          <div class="project">
            <div class="row gx-md-8 gx-xl-12 gy-10 gy-md-12 isotope" data-cue="slideInUp">
              <div class="item col-md-5">
                <figure class="lift rounded mb-6"><a href="./single-project3.html"> <img src="{{ asset('assets/home9/img/photos/rp1.jpg')}}" srcset="{{ asset('assets/home9/img/photos/rp1@2x.jpg')}} 2x" alt="" /></a></figure>
                <div class="post-category mb-3 text-purple">Stationary</div>
                <h3 class="post-title">Ipsum Ultricies Cursus</h3>
              </div>
              <!-- /.item -->
              <div class="item col-md-7 mt-md-17">
                <figure class="lift rounded mb-6"><a href="./single-project2.html"> <img src="{{ asset('assets/home9/img/photos/rp2.jpg')}}" srcset="{{ asset('assets/home9/img/photos/rp2@2x.jpg')}} 2x" alt="" /></a></figure>
                <div class="post-category mb-3 text-orange">Invitation</div>
                <h3 class="post-title">Mollis Ipsum Mattis</h3>
              </div>
              <!-- /.item -->
              <div class="item col-md-5">
                <figure class="lift rounded mb-6"><a href="./single-project.html"> <img src="{{ asset('assets/home9/img/photos/rp3.jpg')}}" srcset="{{ asset('assets/home9/img/photos/rp3@2x.jpg')}} 2x" alt="" /></a></figure>
                <div class="post-category mb-3 text-red">Notebook</div>
                <h3 class="post-title">Magna Tristique Inceptos</h3>
              </div>
              <!-- /.item -->
            </div>
            <!-- /.row -->
          </div>
          <!-- /.project -->
        </div>
        <!-- /.projects-tiles -->
      </div>
      <!-- /.container -->
    </section>
    <!-- /section -->
    <section class="wrapper bg-gray">
      <div class="container py-14 py-md-16">
        <div class="row gx-lg-8 gx-xl-12 gy-10 gy-lg-0 mb-10">
          <div class="col-lg-4 mt-lg-2">
            <h3 class="display-4 mb-3 pe-xxl-5">Trusted by over 300+ clients</h3>
            <p class="lead fs-lg mb-0 pe-xxl-5">We <span class="underline">bring solutions</span> to make life easier for our customers.</p>
          </div>
          <!-- /column -->
          <div class="col-lg-8">
            <div class="row row-cols-2 row-cols-md-4 gx-0 gx-md-8 gx-xl-12 gy-12" data-cues="fadeIn" data-group="clients">
              <div class="col">
                <figure class="px-3 px-md-0 px-xxl-2" data-cue="fadeIn"><img src="{{ asset('assets/home9/img/brands/z1.png')}}" alt="" /></figure>
              </div>
              <!--/column -->
              <div class="col">
                <figure class="px-3 px-md-0 px-xxl-2" data-cue="fadeIn"><img src="{{ asset('assets/home9/img/brands/z2.png')}}" alt="" /></figure>
              </div>
              <!--/column -->
              <div class="col">
                <figure class="px-3 px-md-0 px-xxl-2" data-cue="fadeIn"><img src="{{ asset('assets/home9/img/brands/z3.png')}}" alt="" /></figure>
              </div>
              <!--/column -->
              <div class="col">
                <figure class="px-3 px-md-0 px-xxl-2" data-cue="fadeIn"><img src="{{ asset('assets/home9/img/brands/z4.png')}}" alt="" /></figure>
              </div>
              <!--/column -->
              <div class="col">
                <figure class="px-3 px-md-0 px-xxl-2" data-cue="fadeIn"><img src="{{ asset('assets/home9/img/brands/z5.png')}}" alt="" /></figure>
              </div>
              <!--/column -->
              <div class="col">
                <figure class="px-3 px-md-0 px-xxl-2" data-cue="fadeIn"><img src="{{ asset('assets/home9/img/brands/z6.png')}}" alt="" /></figure>
              </div>
              <!--/column -->
              <div class="col">
                <figure class="px-3 px-md-0 px-xxl-2" data-cue="fadeIn"><img src="{{ asset('assets/home9/img/brands/z7.png')}}" alt="" /></figure>
              </div>
              <!--/column -->
              <div class="col">
                <figure class="px-3 px-md-0 px-xxl-2" data-cue="fadeIn"><img src="{{ asset('assets/home9/img/brands/z8.png')}}" alt="" /></figure>
              </div>
              <!--/column -->
            </div>
            <!--/.row -->
          </div>
          <!-- /column -->
        </div>
        <!-- /.row -->
      </div>
      <!-- /.container -->
    </section>
    <!-- /section -->
    <section class="wrapper bg-light angled upper-end lower-end">
      <div class="container py-14 py-md-16">
        <div class="row gy-6 gy-lg-0 mb-10 mb-md-18">
          <div class="col-lg-4">
            <h2 class="display-4 mt-lg-18 mb-3">Our Pricing</h2>
            <p class="lead fs-lg">We offer <span class="underline">great prices</span>, premium and quality products for your business.</p>
            <p>Enjoy a <a href="#" class="hover">free 30-day trial</a> and experience the full service. No credit card required!</p>
            <a href="#" class="btn btn-primary rounded-pill mt-2">See All Prices</a>
          </div>
          <!--/column -->
          <div class="col-lg-7 offset-lg-1 pricing-wrapper">
            <div class="pricing-switcher-wrapper switcher justify-content-start justify-content-lg-end">
              <p class="mb-0 pe-3">Monthly</p>
              <div class="pricing-switchers">
                <div class="pricing-switcher pricing-switcher-active"></div>
                <div class="pricing-switcher"></div>
                <div class="switcher-button bg-primary"></div>
              </div>
              <p class="mb-0 ps-3">Yearly <span class="text-red">(Save 30%)</span></p>
            </div>
            <div class="row gy-6 mt-5">
              <div class="col-md-6">
                <div class="pricing card">
                  <div class="card-body pb-12">
                    <div class="prices text-dark">
                      <div class="price price-show"><span class="price-currency">$</span><span class="price-value">19</span> <span class="price-duration">month</span></div>
                      <div class="price price-hide price-hidden"><span class="price-currency">$</span><span class="price-value">199</span> <span class="price-duration">year</span></div>
                    </div>
                    <!--/.prices -->
                    <h4 class="card-title mt-2">Premium Plan</h4>
                    <ul class="icon-list bullet-bg bullet-soft-primary mt-8 mb-9">
                      <li><i class="uil uil-check"></i><span><strong>5</strong> Projects </span></li>
                      <li><i class="uil uil-check"></i><span><strong>100K</strong> API Access </span></li>
                      <li><i class="uil uil-check"></i><span><strong>200MB</strong> Storage </span></li>
                      <li><i class="uil uil-check"></i><span> Weekly <strong>Reports</strong></span></li>
                      <li><i class="uil uil-times bullet-soft-red"></i><span> 7/24 <strong>Support</strong></span></li>
                    </ul>
                    <a href="#" class="btn btn-primary rounded-pill">Choose Plan</a>
                  </div>
                  <!--/.card-body -->
                </div>
                <!--/.pricing -->
              </div>
              <!--/column -->
              <div class="col-md-6 popular">
                <div class="pricing card">
                  <div class="card-body pb-12">
                    <div class="prices text-dark">
                      <div class="price price-show"><span class="price-currency">$</span><span class="price-value">49</span> <span class="price-duration">month</span></div>
                      <div class="price price-hide price-hidden"><span class="price-currency">$</span><span class="price-value">499</span> <span class="price-duration">year</span></div>
                    </div>
                    <!--/.prices -->
                    <h4 class="card-title mt-2">Corporate Plan</h4>
                    <ul class="icon-list bullet-bg bullet-soft-primary mt-8 mb-9">
                      <li><i class="uil uil-check"></i><span><strong>20</strong> Projects </span></li>
                      <li><i class="uil uil-check"></i><span><strong>300K</strong> API Access </span></li>
                      <li><i class="uil uil-check"></i><span><strong>500MB</strong> Storage </span></li>
                      <li><i class="uil uil-check"></i><span> Weekly <strong>Reports</strong></span></li>
                      <li><i class="uil uil-check"></i><span> 7/24 <strong>Support</strong></span></li>
                    </ul>
                    <a href="#" class="btn btn-primary rounded-pill">Choose Plan</a>
                  </div>
                  <!--/.card-body -->
                </div>
                <!--/.pricing -->
              </div>
              <!--/column -->
            </div>
            <!--/.row -->
          </div>
          <!--/column -->
        </div>
        <!--/.row -->
        <div class="row gy-10 gx-lg-8 gx-xl-12 align-items-center">
          <div class="col-lg-7 position-relative">
            <div class="row gx-md-5 gy-5">
              <div class="col-md-6">
                <figure class="rounded mt-md-10 position-relative" data-cue="fadeIn" data-delay="300"><img src="{{ asset('assets/home9/img/photos/g5.jpg')}}" srcset="{{ asset('assets/home9/img/photos/g5@2x.jpg')}} 2x" alt=""></figure>
              </div>
              <!--/column -->
              <div class="col-md-6">
                <div class="row gx-md-5 gy-5">
                  <div class="col-md-12 order-md-2">
                    <figure class="rounded" data-cue="fadeIn" data-delay="1100"><img src="{{ asset('assets/home9/img/photos/g6.jpg')}}" srcset="{{ asset('assets/home9/img/photos/g6@2x.jpg')}} 2x" alt=""></figure>
                  </div>
                  <!--/column -->
                  <div class="col-md-10">
                    <div class="card bg-pale-primary text-center" data-cue="fadeIn" data-delay="800">
                      <div class="card-body py-11 counter-wrapper">
                        <h3 class="counter text-nowrap">5000+</h3>
                        <p class="mb-0">Satisfied Customers</p>
                      </div>
                      <!--/.card-body -->
                    </div>
                    <!--/.card -->
                  </div>
                  <!--/column -->
                </div>
                <!--/.row -->
              </div>
              <!--/column -->
            </div>
            <!--/.row -->
          </div>
          <!--/column -->
          <div class="col-lg-5">
            <h2 class="display-4 mb-3">Let’s Talk</h2>
            <p class="lead fs-lg">Let’s make something great together. We are <span class="underline">trusted by</span> over 5000+ clients. Join them by using our services and grow your business.</p>
            <p>Aenean eu leo quam. Pellentesque ornare sem lacinia quam venenatis vestibulum. Maecenas faucibus mollis interdum. Fusce dapibus, tellus ac cursus commodo, tortor mauris condimentum nibh, ut fermentum massa justo sit amet risus.</p>
            <a href="#" class="btn btn-primary rounded-pill mt-2">Join Us</a>
          </div>
          <!--/column -->
        </div>
        <!--/.row -->
      </div>
      <!-- /.container -->
    </section>
    <!-- /section -->
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
  <!-- /.content-wrapper -->
  <footer class="bg-dark text-inverse">
    <div class="container py-13 py-md-15">
      <div class="mt-10"></div>
      <div class="row gy-6 gy-lg-0">
        <div class="col-md-4 col-lg-3">
          <div class="widget">
            @if (!empty($logo_favicon['logo']))
                <img  class="mb-4" src="{{ asset('storage/logo').'/'.$logo_favicon['logo'] }}" >
            @else
                <img  class="mb-4" src="{{ asset('assets/main/images/logo.png')}}">
            @endif

            <p class="mb-4">{{$footer_text}}</p>
            <nav class="nav social social-white">
              <a href="#"><i class="uil uil-twitter"></i></a>
              <a href="#"><i class="uil uil-facebook-f"></i></a>
              <a href="#"><i class="uil uil-dribbble"></i></a>
              <a href="#"><i class="uil uil-instagram"></i></a>
              <a href="#"><i class="uil uil-youtube"></i></a>
            </nav>
            <!-- /.social -->
          </div>
          <!-- /.widget -->
        </div>
        <!-- /column -->
        <div class="col-md-4 col-lg-3">
          <div class="widget">
            <h4 class="widget-title text-white mb-3">Get in Touch</h4>
            <address class="pe-xl-15 pe-xxl-17">Moonshine St. 14/05 Light City, London, United Kingdom</address>
            <a href="mailto:#">info@email.com</a><br /> +00 (123) 456 78 90
          </div>
          <!-- /.widget -->
        </div>
        <!-- /column -->
        <div class="col-md-4 col-lg-3">
          <div class="widget">
            <h4 class="widget-title text-white mb-3">Learn More</h4>
            <ul class="list-unstyled  mb-0">
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
          <!-- /.widget -->
        </div>
        <!-- /column -->
        <div class="col-md-12 col-lg-3">
          <div class="widget">
            <h4 class="widget-title text-white mb-3">Our Newsletter</h4>
            <p class="mb-5">Subscribe to our newsletter to get our news & deals delivered to you.</p>
            <div class="newsletter-wrapper">
              <!-- Begin Mailchimp Signup Form -->
              <div id="mc_embed_signup2">
                <form method="POST"  action="{{url('subscribe')}}" enctype="multipart/form-data" >
                  <div id="mc_embed_signup_scroll2">
                    <div class="mc-field-group input-group form-floating">
                        {!! csrf_field() !!}
                      <input type="email" value="" name="email" class="required email form-control" placeholder="Email Address" id="mce-EMAIL2">
                      <label for="mce-EMAIL2">Email Address</label>
                      <input type="submit" value="Join" name="subscribe" id="mc-embedded-subscribe2" class="btn btn-primary">
                    </div>
                   <!-- real people should not fill this in and expect good things - do not remove this or risk form bot signups-->
                    <div style="position: absolute; left: -5000px;" aria-hidden="true"><input type="text" name="b_ddc180777a163e0f9f66ee014_4b1bcfa0bc" tabindex="-1" value=""></div>
                    <div class="clear"></div>
                  </div>
                </form>
              </div>
              <!--End mc_embed_signup-->
            </div>
            <!-- /.newsletter-wrapper -->
          </div>
          <!-- /.widget -->
        </div>
        <!-- /column -->
      </div>
      <!--/.row -->
    </div>
    <!-- /.container -->
  </footer>
  <div class="progress-wrap">
    <svg class="progress-circle svg-content" width="100%" height="100%" viewBox="-1 -1 102 102">
      <path d="M50,1 a49,49 0 0,1 0,98 a49,49 0 0,1 0,-98" />
    </svg>
  </div>
@endsection
