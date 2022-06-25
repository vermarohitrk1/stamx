@extends('layout.frontend.home10.mainlayout')
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
    <header class="wrapper bg-gray">
      <nav class="navbar navbar-expand-lg fancy navbar-light navbar-bg-light caret-none">
        <div class="container">
          <div class="navbar-collapse-wrapper bg-white d-flex flex-row flex-nowrap w-100 justify-content-between align-items-center">
            <div class="navbar-brand w-100">
              <a href="/">
                @if (!empty($logo_favicon['logo']))
                    <img src="{{ asset('storage/logo').'/'.$logo_favicon['logo'] }}" alt="LogoImage" >
                @else

                    @if(!empty($logoTxt)) {{ $logoTxt }} @else Your Logo Here @endif
                @endif
              </a>
            </div>
            <div class="navbar-collapse offcanvas-nav">
              <div class="offcanvas-header d-lg-none d-xl-none">
                <a href="/">
                    @if (!empty($logo_favicon['logo']))
                        <img src="{{ asset('storage/logo').'/'.$logo_favicon['logo'] }}" alt="LogoImage" >
                    @else

                        @if(!empty($logoTxt)) {{ $logoTxt }} @else Your Logo Here @endif
                    @endif
                </a>
                <button type="button" class="btn-close btn-close-white offcanvas-close offcanvas-nav-close" aria-label="Close"></button>
              </div>
              <ul class="navbar-nav">
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
                                            <li class="nav-item dropdown"><a class="nav-link" href='{{ url("$dId/donation")}}'>Donate</a> </li>
                                                @endif
                                        @endif
                                        <li class="nav-item dropdown"> <a class="nav-link"   href="{{ route('login') }}">log In</a></li>



                                    @else
                                    <li class="nav-item dropdown"><a class="nav-link" href="{{ route('home') }}">Dashboard</a></li>

                                @endguest


              </ul>
              <!-- /.navbar-nav -->
            </div>
            <!-- /.navbar-collapse -->
            <div class="navbar-other w-100 d-flex ms-auto">
              <ul class="navbar-nav flex-row align-items-center ms-auto" data-sm-skip="true">
                <li class="nav-item">
                  <nav class="nav social social-muted justify-content-end text-end">
                    <a href="#"><i class="uil uil-twitter"></i></a>
                    <a href="#"><i class="uil uil-facebook-f"></i></a>
                    <a href="#"><i class="uil uil-dribbble"></i></a>
                    <a href="#"><i class="uil uil-instagram"></i></a>
                  </nav>
                  <!-- /.social -->
                </li>
                <li class="nav-item d-lg-none">
                  <div class="navbar-hamburger"><button class="hamburger animate plain" data-toggle="offcanvas-nav"><span></span></button></div>
                </li>
              </ul>
              <!-- /.navbar-nav -->
            </div>
            <!-- /.navbar-other -->
          </div>
          <!-- /.navbar-collapse-wrapper -->
        </div>
        <!-- /.container -->
      </nav>
      <!-- /.navbar -->
    </header>
    <!-- /header -->
    <section class="wrapper bg-gray">
      <div class="container pt-12 pt-md-16 text-center">
        <div class="row">
          <div class="col-lg-8 col-xxl-7 mx-auto text-center" data-cues="slideInDown" data-group="page-title" data-delay="600">
            <h2 class="fs-16 text-uppercase ls-xl text-dark mb-4">Hello! This is Sandbox</h2>
            <h1 class="display-1 fs-58 mb-7">We bring rapid solutions for your business.</h1>
            <div class="d-flex justify-content-center" data-cues="slideInDown" data-group="page-title-buttons" data-delay="900">
              <span><a href="#" class="btn btn-lg btn-primary rounded-pill me-2">Explore Now</a></span>
              <span><a href="#" class="btn btn-lg btn-outline-primary rounded-pill">Contact Us</a></span>
            </div>
          </div>
          <!--/column -->
        </div>
        <!-- /.row -->
      </div>
      <!-- /.container -->
      <figure class="position-absoute" style="bottom: 0; left: 0; z-index: 2;"><img src="{{ asset('assets/home10/img/photos/bg11.jpg')}}" alt="" /></figure>
    </section>
    <!-- /section -->
    <section class="wrapper bg-gray">
      <div class="container">
        <div class="card shadow-none my-n15 my-lg-n17">
          <div class="card-body py-12 py-lg-14 px-lg-11 py-xl-16 px-xl-13">
            <div class="row text-center">
              <div class="col-lg-9 col-xl-8 col-xxl-7 mx-auto">
                <h2 class="fs-15 text-uppercase text-muted mb-3">What We Do?</h2>
                <h3 class="display-4 mb-9">The service we offer is specifically designed to meet your needs.</h3>
              </div>
              <!-- /column -->
            </div>
            <!-- /.row -->
            <div class="row gx-md-8 gx-xl-12 gy-8 mb-14 mb-md-16 text-center">
              <div class="col-md-4">
                <div class="icon btn btn-block btn-lg btn-soft-purple disabled mb-5"> <i class="uil uil-phone-volume"></i> </div>
                <h4>24/7 Support</h4>
                <p class="mb-3">Fusce dapibus tellus cursus porta tortor condimentum euismod massa justo vehicula sit amet et risus cras.</p>
                <a href="#" class="more hover link-purple">Learn More</a>
              </div>
              <!--/column -->
              <div class="col-md-4">
                <div class="icon btn btn-block btn-lg btn-soft-green disabled mb-5"> <i class="uil uil-shield-exclamation"></i> </div>
                <h4>Secure Payments</h4>
                <p class="mb-3">Fusce dapibus tellus cursus porta tortor condimentum euismod massa justo vehicula sit amet et risus cras.</p>
                <a href="#" class="more hover link-green">Learn More</a>
              </div>
              <!--/column -->
              <div class="col-md-4">
                <div class="icon btn btn-block btn-lg btn-soft-orange disabled mb-5"> <i class="uil uil-laptop-cloud"></i> </div>
                <h4>Daily Updates</h4>
                <p class="mb-3">Fusce dapibus tellus cursus porta tortor condimentum euismod massa justo vehicula sit amet et risus cras.</p>
                <a href="#" class="more hover link-orange">Learn More</a>
              </div>
              <!--/column -->
            </div>
            <!--/.row -->
            <div class="row gx-md-8 gx-xl-12 gy-10 align-items-center">
              <div class="col-lg-6">
                <h2 class="fs-15 text-uppercase text-muted mb-3">Our Strategy</h2>
                <h3 class="display-4 mb-5">3 working steps to organize our business projects.</h3>
                <p>Aenean eu leo quam. Pellentesque ornare sem lacinia quam venenatis vestibulum. Etiam porta sem malesuada magna mollis euismod eget. Nullam id dolor id nibh ultricies vehicula ut id elit. Nullam quis risus.</p>
                <p class="mb-6">Nullam id dolor id nibh ultricies vehicula ut id elit. Vestibulum id ligula porta felis euismod semper. Aenean lacinia bibendum consectetur.</p>
                <a href="#" class="btn btn-primary rounded-pill mb-0">Learn More</a>
              </div>
              <!--/column -->
              <div class="col-lg-6">
                <div class="d-flex flex-row">
                  <div>
                    <span class="icon btn btn-block btn-lg btn-soft-purple disabled mt-1 me-5"><span class="number fs-22">01</span></span>
                  </div>
                  <div>
                    <h4 class="mb-1">Collect Ideas</h4>
                    <p class="mb-0">Nulla vitae elit libero pharetra augue dapibus. Fusce dapibus, tellus ac cursus commodo.</p>
                  </div>
                </div>
                <div class="d-flex flex-row mt-8 ms-lg-10">
                  <div>
                    <span class="icon btn btn-block btn-lg btn-soft-green disabled mt-1 me-5"><span class="number fs-22">02</span></span>
                  </div>
                  <div>
                    <h4 class="mb-1">Data Analysis</h4>
                    <p class="mb-0">Vivamus sagittis lacus vel augue laoreet tortor mauris condimentum fermentum.</p>
                  </div>
                </div>
                <div class="d-flex flex-row mt-8">
                  <div>
                    <span class="icon btn btn-block btn-lg btn-soft-orange disabled mt-1 me-5"><span class="number fs-22">03</span></span>
                  </div>
                  <div>
                    <h4 class="mb-1">Finalize Product</h4>
                    <p class="mb-0">Cras mattis consectetur purus sit amet massa justo sit amet risus consectetur magna elit.</p>
                  </div>
                </div>
              </div>
              <!--/column -->
            </div>
            <!--/.row -->
            <hr class="my-14 my-md-16" />
            <div class="row gx-lg-8 gx-xl-12 gy-10 gy-lg-0 mb-11 align-items-end">
              <div class="col-lg-4">
                <h2 class="fs-15 text-uppercase text-muted mb-3">Company Facts</h2>
                <h3 class="display-4 mb-0">We are proud of our works</h3>
              </div>
              <!-- /column -->
              <div class="col-lg-8 mt-lg-2">
                <div class="row align-items-center counter-wrapper gy-6 text-center">
                  <div class="col-md-4">
                    <h3 class="counter counter-lg">1000+</h3>
                    <p>Completed Projects</p>
                  </div>
                  <!--/column -->
                  <div class="col-md-4">
                    <h3 class="counter counter-lg">500+</h3>
                    <p>Happy Clients</p>
                  </div>
                  <!--/column -->
                  <div class="col-md-4">
                    <h3 class="counter counter-lg">150+</h3>
                    <p>Awards Won</p>
                  </div>
                  <!--/column -->
                </div>
                <!--/.row -->
              </div>
              <!-- /column -->
            </div>
            <!-- /.row -->
            <div class="card bg-gray shadow-lg mb-14 mb-md-17">
              <div class="row gx-0">
                <div class="col-lg-6 image-wrapper bg-image bg-cover rounded-top rounded-lg-start" data-image-src="{{ asset('assets/home10/img/photos/tm1.jpg')}}">
                </div>
                <!--/column -->
                <div class="col-lg-6">
                  <div class="p-10 p-xl-13">
                    <div class="basic-slider owl-carousel gap-small" data-margin="30">
                      <div class="item">
                        <blockquote class="icon icon-top fs-lg text-center">
                          <p>“Vivamus sagittis lacus vel augue laoreet rutrum faucibus dolor auctor. Vestibulum ligula porta felis euismod semper.”</p>
                          <div class="blockquote-details justify-content-center text-center">
                            <div class="info ps-0">
                              <h5 class="mb-1">Coriss Ambady</h5>
                              <p class="mb-0">Financial Analyst</p>
                            </div>
                          </div>
                        </blockquote>
                      </div>
                      <!-- /.item -->
                      <div class="item">
                        <blockquote class="icon icon-top fs-lg text-center">
                          <p>“Vivamus sagittis lacus vel augue laoreet rutrum faucibus dolor auctor. Vestibulum ligula porta felis euismod semper.”</p>
                          <div class="blockquote-details justify-content-center text-center">
                            <div class="info ps-0">
                              <h5 class="mb-1">Cory Zamora</h5>
                              <p class="mb-0">Marketing Specialist</p>
                            </div>
                          </div>
                        </blockquote>
                      </div>
                      <!-- /.item -->
                      <div class="item">
                        <blockquote class="icon icon-top fs-lg text-center">
                          <p>“Vivamus sagittis lacus vel augue laoreet rutrum faucibus dolor auctor. Vestibulum ligula porta felis euismod semper.”</p>
                          <div class="blockquote-details justify-content-center text-center">
                            <div class="info ps-0">
                              <h5 class="mb-1">Nikolas Brooten</h5>
                              <p class="mb-0">Sales Manager</p>
                            </div>
                          </div>
                        </blockquote>
                      </div>
                      <!-- /.item -->
                    </div>
                    <!-- /.owl-carousel -->
                  </div>
                  <!--/div -->
                </div>
                <!--/column -->
              </div>
              <!--/.row -->
            </div>
            <!-- /.card -->
            <div class="row text-center">
              <div class="col-lg-10 col-xl-10 col-xxl-8 mx-auto">
                <h2 class="fs-15 text-uppercase text-muted mb-3">Case Studies</h2>
                <h3 class="display-4 mb-9">Check out some of our awesome projects with creative ideas and great design.</h3>
              </div>
              <!-- /column -->
            </div>
            <!-- /.row -->
            <div class="carousel owl-carousel blog grid-view mb-18" data-margin="30" data-dots="true" data-autoplay="false" data-autoplay-timeout="5000" data-responsive='{"0":{"items": "1"}, "768":{"items": "2"}, "992":{"items": "2"}, "1200":{"items": "3"}}'>
                @if(!empty($recent_blogs))
                    @foreach ($recent_blogs as $recent_blog)
                        <div class="item">
                                <article>
                                <figure class="overlay overlay1 hover-scale rounded mb-6"><a href="{{route('blog.details',encrypted_key($recent_blog->id,"encrypt"))}}">
                                    @if(file_exists( storage_path().'/blog/'.$recent_blog->image ) && !empty($recent_blog->image))
                                    <img src="{{asset('storage')}}/blog/{{ $recent_blog->image }}" class="img-responsive" alt="...">
                                    @else
                                    <img class="img-fluid" src="{{ asset('assets/img/blog/blog-thumb-01.jpg') }}" class="img-responsive" alt="">
                                    @endif

                                </a>
                                    <figcaption>
                                    <h5 class="from-top mb-0">Read More</h5>
                                    </figcaption>
                                </figure>
                                <div class="post-header">
                                    <h2 class="post-title h3 mb-3"><a class="link-dark" href="{{route('blog.details',encrypted_key($recent_blog->id,"encrypt"))}}">{{$recent_blog->title}}</a></h2>
                                </div>
                                <!-- /.post-header -->
                                <div class="post-footer">
                                    <ul class="post-meta">
                                    <li class="post-date"><i class="uil uil-calendar-alt"></i><span>  {{date('F d, Y', strtotime($recent_blog->created_at))}}</span></li>
                                    <li class="post-comments"><a href="{{route('blog.details',encrypted_key($recent_blog->id,"encrypt"))}}"><i class="uil uil-file-alt fs-15"></i>{{$recent_blog->tags}}</a></li>
                                    </ul>
                                    <!-- /.post-meta -->
                                </div>
                                <!-- /.post-footer -->
                                </article>
                                <!-- /article -->
                            </div>
                        @endforeach
                @endif
              <!-- /.item -->

              <!-- /.item -->


              <!-- /.item -->
            </div>
            <!-- /.owl-carousel -->
            <hr class="my-14 my-md-16" />
            <div class="row gx-lg-8 gx-xl-12 gy-10 mb-14 mb-md-17 align-items-center">
              <div class="col-md-8 col-lg-6 order-lg-2">
                <figure class="rounded"><img src="{{ asset('assets/home10/img/photos/about24.jpg')}}" srcset="{{ asset('assets/home10/img/photos/about24@2x.jpg')}} 2x" alt=""></figure>
              </div>
              <!--/column -->
              <div class="col-lg-6">
                <h2 class="fs-15 text-uppercase text-muted mb-3">Our Team</h2>
                <h3 class="display-4 mb-5">Save your time by choosing our professional team.</h3>
                <p class="mb-6">Cum sociis natoque penatibus et magnis dis parturient montes, nascetur ridiculus mus. Cras justo odio, dapibus ac facilisis in, egestas eget quam. Praesent commodo cursus magna, vel scelerisque nisl consectetur et.</p>
                <div class="row gy-3 gx-xl-8">
                  <div class="col-xl-6">
                    <ul class="icon-list bullet-bg bullet-soft-primary mb-0">
                      <li><span><i class="uil uil-check"></i></span><span>Aenean eu leo quam ornare curabitur blandit tempus.</span></li>
                      <li class="mt-3"><span><i class="uil uil-check"></i></span><span>Nullam quis risus eget urna mollis ornare donec elit.</span></li>
                    </ul>
                  </div>
                  <!--/column -->
                  <div class="col-xl-6">
                    <ul class="icon-list bullet-bg bullet-soft-primary mb-0">
                      <li><span><i class="uil uil-check"></i></span><span>Etiam porta sem malesuada magna mollis euismod.</span></li>
                      <li class="mt-3"><span><i class="uil uil-check"></i></span><span>Fermentum massa vivamus faucibus amet euismod.</span></li>
                    </ul>
                  </div>
                  <!--/column -->
                </div>
                <!--/.row -->
              </div>
              <!--/column -->
            </div>
            <!--/.row -->
            <div class="row gy-10 gx-8 gx-lg-12 mb-14 mb-md-16 align-items-center">
              <div class="col-md-8 col-lg-6">
                <figure class="rounded"><img src="{{ asset('assets/home10/img/photos/about25.jpg')}}" srcset="{{ asset('assets/home10/img/photos/about25@2x.jpg')}} 2x" alt=""></figure>
              </div>
              <!--/column -->
              <div class="col-lg-6">
                <h2 class="fs-15 text-uppercase text-muted mb-3">Why Choose Us?</h2>
                <h3 class="display-4 mb-7">A few reasons why our valued customers choose us.</h3>
                <div class="accordion accordion-wrapper" id="accordionExample">
                  <div class="card plain accordion-item">
                    <div class="card-header" id="headingOne">
                      <button class="accordion-button" data-bs-toggle="collapse" data-bs-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne"> Professional Design </button>
                    </div>
                    <!--/.card-header -->
                    <div id="collapseOne" class="accordion-collapse collapse show" aria-labelledby="headingOne" data-bs-parent="#accordionExample">
                      <div class="card-body">
                        <p>Fusce dapibus, tellus ac cursus commodo, tortor mauris condimentum nibh, ut fermentum massa justo sit amet risus. Cras mattis consectetur purus sit amet fermentum. Praesent commodo cursus magna, vel.</p>
                      </div>
                      <!--/.card-body -->
                    </div>
                    <!--/.accordion-collapse -->
                  </div>
                  <!--/.accordion-item -->
                  <div class="card plain accordion-item">
                    <div class="card-header" id="headingTwo">
                      <button class="collapsed" data-bs-toggle="collapse" data-bs-target="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo"> Top-Notch Support </button>
                    </div>
                    <!--/.card-header -->
                    <div id="collapseTwo" class="accordion-collapse collapse" aria-labelledby="headingTwo" data-bs-parent="#accordionExample">
                      <div class="card-body">
                        <p>Fusce dapibus, tellus ac cursus commodo, tortor mauris condimentum nibh, ut fermentum massa justo sit amet risus. Cras mattis consectetur purus sit amet fermentum. Praesent commodo cursus magna, vel.</p>
                      </div>
                      <!--/.card-body -->
                    </div>
                    <!--/.accordion-collapse -->
                  </div>
                  <!--/.accordion-item -->
                  <div class="card plain accordion-item">
                    <div class="card-header" id="headingThree">
                      <button class="collapsed" data-bs-toggle="collapse" data-bs-target="#collapseThree" aria-expanded="false" aria-controls="collapseThree"> Header and Slider Options </button>
                    </div>
                    <!--/.card-header -->
                    <div id="collapseThree" class="accordion-collapse collapse" aria-labelledby="headingThree" data-bs-parent="#accordionExample">
                      <div class="card-body">
                        <p>Fusce dapibus, tellus ac cursus commodo, tortor mauris condimentum nibh, ut fermentum massa justo sit amet risus. Cras mattis consectetur purus sit amet fermentum. Praesent commodo cursus magna, vel.</p>
                      </div>
                      <!--/.card-body -->
                    </div>
                    <!--/.accordion-collapse -->
                  </div>
                  <!--/.accordion-item -->
                </div>
                <!--/.accordion -->
              </div>
              <!--/column -->
            </div>
            <!--/.row -->
            <div class="wrapper image-wrapper bg-auto no-overlay bg-image text-center bg-map" data-image-src="{{ asset('assets/home10/img/map.png')}}">
              <div class="container py-md-16 py-lg-18">
                <div class="row">
                  <div class="col-xl-11 col-xxl-9 mx-auto">
                    <h3 class="display-4 mb-8 px-lg-8">We are trusted by over 5000+ clients. Join them now and grow your business.</h3>
                  </div>
                  <!-- /column -->
                </div>
                <!-- /.row -->
                <div class="d-flex justify-content-center">
                  <span><a class="btn btn-primary rounded-pill">Get Started</a></span>
                </div>
              </div>
              <!-- /.container -->
            </div>
            <!-- /.wrapper -->
          </div>
          <!--/.card-body -->
        </div>
        <!--/.card -->
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
    <div class="container pt-20 pt-lg-21 pb-7">
      <div class="row gy-6 gy-lg-0">
        <div class="col-lg-4">
          <div class="widget">
            <h3 class="h2 mb-3 text-white">Join the Community</h3>
            @if (!empty($logo_favicon['logo']))
                <img src="{{ asset('storage/logo').'/'.$logo_favicon['logo'] }}" >
            @else
                <img src="{{ asset('assets/main/images/logo.png')}}">
            @endif
            <p class="lead mb-5">Let's make something great together. We are trusted by over 5000+ clients. Join them by using our services and grow your business.</p>
            <a href="#" class="btn btn-white  rounded-pill">Join Us</a>
          </div>
          <!-- /.widget -->
        </div>
        <!-- /column -->
        <div class="col-md-4 col-lg-2 offset-lg-2">
          <div class="widget">
            <h4 class="widget-title text-white mb-3">Need Help?</h4>
            <ul class="list-unstyled text-reset mb-0">
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
        <div class="col-md-4 col-lg-2">
          <div class="widget">
            <h4 class="widget-title text-white mb-3">Learn More</h4>
            <ul class="list-unstyled  mb-0">
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
          <!-- /.widget -->
        </div>
        <!-- /column -->
        <div class="col-md-4 col-lg-2">
          <div class="widget">
            <h4 class="widget-title text-white mb-3">Get in Touch</h4>
            <address>Moonshine St. 14/05 Light City, London, United Kingdom</address>
            <a href="mailto:first.last@email.com">info@email.com</a><br /> +00 (123) 456 78 90
          </div>
          <!-- /.widget -->
        </div>
        <!-- /column -->
      </div>
      <!--/.row -->
      <hr class="mt-13 mt-md-15 mb-7" />
      <div class="d-md-flex align-items-center justify-content-between">
        <p class="mb-2 mb-lg-0">{{$footer_text}}</p>
        <nav class="nav social social-white text-md-end">
          <a href="#"><i class="uil uil-twitter"></i></a>
          <a href="#"><i class="uil uil-facebook-f"></i></a>
          <a href="#"><i class="uil uil-dribbble"></i></a>
          <a href="#"><i class="uil uil-instagram"></i></a>
          <a href="#"><i class="uil uil-youtube"></i></a>
        </nav>
        <!-- /.social -->
      </div>
      <!-- /div -->
    </div>
    <!-- /.container -->
  </footer>
  <div class="progress-wrap">
    <svg class="progress-circle svg-content" width="100%" height="100%" viewBox="-1 -1 102 102">
      <path d="M50,1 a49,49 0 0,1 0,98 a49,49 0 0,1 0,-98" />
    </svg>
  </div>
@endsection
