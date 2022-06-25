@extends('layout.frontend.home7.mainlayout')
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
<div class="preloader" id="preloader">
    <svg viewBox="0 0 1920 1080" preserveAspectRatio="none" version="1.1">
      <path d="M0,0 C305.333333,0 625.333333,0 960,0 C1294.66667,0 1614.66667,0 1920,0 L1920,1080 C1614.66667,1080 1294.66667,1080 960,1080 C625.333333,1080 305.333333,1080 0,1080 L0,0 Z"></path>
    </svg>
    <div class="inner">
      <canvas class="progress-bar" id="progress-bar" width="200" height="200"></canvas>
      <figure><img src="{{ asset('assets/home7/images/preloader.png')}}" alt="Image"></figure>
      <small>Loading</small> </div>
    <!-- end inner -->
  </div>
  <!-- end preloder -->
  <div class="page-transition">
    <svg viewBox="0 0 1920 1080" preserveAspectRatio="none" version="1.1">
      <path d="M0,0 C305.333333,0 625.333333,0 960,0 C1294.66667,0 1614.66667,0 1920,0 L1920,1080 C1614.66667,980 1294.66667,930 960,930 C625.333333,930 305.333333,980 0,1080 L0,0 Z"></path>
    </svg>
  </div>
  <!-- end page-transition -->
  <div class="smooth-scroll">
    <div class="section-wrapper" data-scroll-section>
      <div class="search-box">
        <div class="container">
          <div class="form">
            <h3>SEARCH EVENT</h3>
            <input type="search" placeholder="What are you looking for ?">
            <input type="submit" value="SEARCH">
          </div>
          <!-- end form -->
          <div class="search-events">
            <ul>
              <li>
                <h5><a href="#">Artemisia Gentileschi talk with Maria</a></h5>
                <small>15 August – 31 October 2020</small> </li>
              <li>
                <h5><a href="#">Artemisia Gentileschi talk with Maria</a></h5>
                <small>15 August – 31 October 2020</small> </li>
              <li>
                <h5><a href="#">Artemisia Gentileschi talk with Maria</a></h5>
                <small>15 August – 31 October 2020</small> </li>
            </ul>
          </div>
          <!-- end search-events -->
        </div>
      </div>
      <!-- end search-box -->
      <aside class="side-widget">
        <svg viewBox="0 0 600 1080" preserveAspectRatio="none" version="1.1">
          <path d="M540,1080H0V0h540c0,179.85,0,359.7,0,539.54C540,719.7,540,899.85,540,1080z"></path>
        </svg>
        <figure class="logo"> @if (!empty($logo_favicon['logo']))
            <img src="{{ asset('storage/logo').'/'.$logo_favicon['logo'] }}" alt="LogoImage" >
        @else

            @if(!empty($logoTxt)) {{ $logoTxt }} @else Your Logo Here @endif
        @endif </figure>
        <!-- end logo -->
        <div class="inner">
          <div class="widget">
            <figure><img src="{{ asset('assets/home7/images/image07.jpg')}}" alt="Image"></figure>
            <p>It speedily me addition <strong>weddings vicinity</strong> in pleasure. Happiness commanded an conveying breakfast in. Regard her say warmly elinor. Him these are visit front end for <u>seven walls</u>. Money eat scale now ask law learn.</p>
          </div>
          <!-- end widget -->
          <div class="widget">
            <h6 class="widget-title">Opening Hours</h6>
            <p>Tuesday ‒ Friday: 09:00 ‒ 17:00<br>
              Friday ‒ Monday: 10:00 ‒ 20:00</p>
          </div>
          <!-- end widget -->
        </div>
        <!-- end inner -->
          {{-- <div class="display-mobile">
              <div class="custom-menu">
          <ul>
            <li><a href="#">Eng</a></li>
            <li><a href="#">Rus</a></li>
          </ul>
        </div> --}}
        <!-- end custom-menu -->
        <div class="site-menu">
          <ul>
            <li><a href="visit.html">Visit</a></li>
            <li><a href="exhibitions.html">Exhibitions</a></li>
            <li><a href="collections.html">Collections</a></li>
            <li><a href="about.html">About</a></li>
            <li><a href="contact.html">Contact</a></li>
          </ul>
        </div>
        <!-- end site-menu -->
          </div>
          <!-- end display-mobile -->
      </aside>
      <nav class="navbar">
        <div class="logo"> <a href="/"> @if (!empty($logo_favicon['logo']))
            <img src="{{ asset('storage/logo').'/'.$logo_favicon['logo'] }}" alt="LogoImage" >
        @else

            @if(!empty($logoTxt)) {{ $logoTxt }} @else Your Logo Here @endif
        @endif </a> </div>
        <!-- end logo -->
        <div class="custom-menu">
          <ul>
            <li><a href="#">Eng</a></li>
            <li><a href="#">Rus</a></li>
          </ul>
        </div>
        <!-- end custom-menu -->
        <div class="site-menu">
          <ul>
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
        <!-- end site-menu -->
        <div class="search-button"> <i class="far fa-search"></i> </div>
        <!-- end search-button -->
        <div class="hamburger-menu">
          <svg class="hamburger" width="30" height="30" viewBox="0 0 30 30">
            <path class="line line-top" d="M0,9h30"/>
            <path class="line line-center" d="M0,15h30"/>
            <path class="line line-bottom" d="M0,21h30"/>
          </svg>
        </div>
        @guest

            @if ($donation = \App\PublicPageDetail::where('user_id',get_domain_user()->id)->first())
                @php $dId = base64_encode($donation->id);
                $user_setting = DB::table('website_setting')->where('user_domain_id', get_domain_id())->where('name', 'payment_settings')->first();
            @endphp
                @if($user_setting != null)
                <div class="navbar-button"><a href='{{ url("$dId/donation")}}'  >Donate</a></div>
                    @endif
            @endif
            <div class="navbar-button"> <a    href="{{ route('login') }}">log In</a></div>



        @else
        <div class="navbar-button"> <a href="{{ route('home') }}" >Dashboard</a></div>

    @endguest



      </nav>
      <!-- end navbar -->
      <header class="slider">
        <div class="swiper-container slider-images">
          <div class="swiper-wrapper">
            <div class="swiper-slide" data-background="{{ asset('assets/home7/images/slide01.jpg')}}">
              <div class="mobile-slide" data-background="{{ asset('assets/home7/images/slide-mobile01.jpg')}}"></div>
              </div>
            <div class="swiper-slide" data-background="{{ asset('assets/home7/images/slide02.jpg')}}">
              <div class="mobile-slide" data-background="{{ asset('assets/home7/images/slide-mobile02.jpg')}}"></div>
              </div>
            <div class="swiper-slide" data-background="{{ asset('assets/home7/images/slide03.jpg')}}">
              <div class="mobile-slide" data-background="{{ asset('assets/home7/images/slide-mobile03.jpg')}}"></div>
              </div>
          </div>
          <!-- end swiper-wrapper -->
          <div class="container-fluid slider-nav">
            <div class="swiper-pagination"></div>
            <!-- end swiper-pagination -->
            <div class="swiper-fraction"></div>
            <!-- end swiper-fraction -->
            <div class="button-prev"><i class="far fa-chevron-down"></i></div>
            <!-- end swiper-button-prev -->
            <div class="button-next"><i class="far fa-chevron-up"></i></div>
            <!-- end swiper-button-next -->
          </div>
          <!-- end slider-nav -->
        </div>
        <!-- end slider-images -->
        <div class="swiper-container slider-texts">
          <svg width="580" height="400" class="svg-morph">
            <path id="svg_morph" d="m261,30.4375c0,0 114,6 151,75c37,69 37,174 6,206.5625c-31,32.5625 -138,11.4375 -196,-19.5625c-58,-31 -86,-62 -90,-134.4375c12,-136.5625 92,-126.5625 129,-127.5625z" />
          </svg>
          <div class="swiper-wrapper">
            <div class="swiper-slide">
              <div class="container-fluid">
                <h1>Museums and <br>
                  Galleries </h1>
                <p>Explore hundreds of museums, galleries and
                  historic <br>
                  places across the UK.</p>
              </div>
              <!-- end container -->
            </div>
            <!-- end swiper-slide -->
            <div class="swiper-slide">
              <div class="container-fluid">
                <h1>Discover Our <br>
                  History </h1>
                <p>Your support is vital and helps the Museum to share <br>
                  the collection with the world.</p>
              </div>
              <!-- end container -->
            </div>
            <!-- end swiper-slide -->
            <div class="swiper-slide">
              <div class="container-fluid">
                <h1>The Art of <br>
                  North Africa </h1>
                <p>Curator Peter Loovers explores the special relationship between<br>
                  Arctic Peoples and 'man's best friend'.</p>
              </div>
              <!-- end container -->
            </div>
            <!-- end swiper-slide -->
          </div>
          <!-- end swiper-wrapper -->
        </div>
        <!-- end slider-texts -->
        <div class="play-now"> <a href="{{ asset('assets/home7/videos/video.mp4')}}" data-fancybox data-width="640" data-height="360"  class="play-btn"></a>
          <svg version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px" width="300px" height="300px" viewBox="0 0 300 300" enable-background="new 0 0 300 300" xml:space="preserve">
            <defs>
              <path id="circlePath" d="M 150, 150 m -60, 0 a 60,60 0 0,1 120,0 a 60,60 0 0,1 -120,0 "/>
            </defs>
            <circle cx="150" cy="100" r="75" fill="none"/>
            <g>
              <use xlink:href="#circlePath" fill="none"/>
              <text>
                <textPath xlink:href="#circlePath">PLAY NOW  - PLAY NOW - PLAY NOW -</textPath>
              </text>
            </g>
          </svg>
        </div>
        <!-- end play-now -->
      </header>
      <!-- end slider -->
      <section class="content-section" data-background="#fffbf7">
        <div class="container">
          <div class="row align-items-center">
            <div class="col-12">
              <div class="section-title text-center">
                <figure><img src="{{ asset('assets/home7/images/title-shape.png')}}" alt="Image"></figure>
                <h2>The world's leading <br>
                  museum of art</h2>
              </div>
              <!-- end section-title -->
            </div>
            <!-- end col-12 -->
            <div class="col-lg-7">
              <figure class="image-box" data-scroll data-scroll-speed="-1" > <img src="{{ asset('assets/home7/images/side-imag01.jpg')}}" alt="Image"> </figure>
            </div>
            <!-- end col-7 -->
            <div class="col-lg-5">
              <div class="side-icon-list right-side">
                <ul>
                  <li>
                    <figure> <img src="{{ asset('assets/home7/images/icon01.png')}}" alt="Image"> </figure>
                    <div class="content">
                      <h5>Opening times</h5>
                      <p>From 27 August<br>
                        Thursday – Sunday: 11.00-19.00</p>
                    </div>
                    <!-- end content -->
                  </li>
                  <li>
                    <figure> <img src="{{ asset('assets/home7/images/icon02.png')}}" alt="Image"> </figure>
                    <div class="content">
                      <h5>Book Online</h5>
                      <p>Some exhibitions and events carry <br>
                        a separate charge</p>
                      <a href="#">Join Now and Book Online</a> </div>
                    <!-- end content -->
                  </li>
                  <li>
                    <figure> <img src="{{ asset('assets/home7/images/icon03.png')}}" alt="Image"> </figure>
                    <div class="content">
                      <h5>Where You Visit</h5>
                      <p>Cromwell New Street Road<br>
                        London, SW7 2RL</p>
                    </div>
                    <!-- end content -->
                  </li>
                </ul>
              </div>
              <!-- end side-icon-list -->
            </div>
            <!-- end col-5 -->
          </div>
          <!-- end row -->
        </div>
        <!-- end container -->
      </section>
      <!-- end content-section -->
      <section class="content-section">
        <div class="container">
          <div class="row justify-content-center">
            <div class="col-lg-9">
              <div class="section-title">
                <figure><img src="{{ asset('assets/home7/images/title-shape.png')}}" alt="Image"></figure>
                <h6>DON’T MISS THE OPPORTUNITY</h6>
                <h2>Upcoming Events</h2>
              </div>
              <!-- end section-title -->
            </div>
            <!-- end col-9 -->
            <div class="col-lg-3"> <a href="#" class="circle-button">BOOK AN <br>
              EVENT</a> </div>
            <!-- end col-3 -->
          </div>
          <!-- end row -->
          <div class="row justify-content-center">
            <div class="col-lg-4 col-md-6">
              <div class="exhibition-box" data-scroll data-scroll-speed="-1" >
                <figure> <a href="#"><img src="{{ asset('assets/home7/images/event01.jpg')}}" alt="Image" class="img"></a>
                  <div class="info">
                    <figure class="i"><img src="{{ asset('assets/home7/images/icon-info.png')}}" alt="Image"></figure>
                    <span>50% off exhibitions</span> </div>
                  <!-- end info -->
                </figure>
                <div class="content-box">
                  <h4><a href="#">Artemisia Gentileschi
                    talk with Maria</a></h4>
                  <p> 15 August – 31 October 2020 </p>
                </div>
                <!-- end content-box -->
              </div>
              <!-- end exhibition-box -->
            </div>
            <!-- end col-4 -->
            <div class="col-lg-4 col-md-6">
              <div class="exhibition-box" data-scroll data-scroll-speed="1">
                <figure> <a href="#"><img src="{{ asset('assets/home7/images/event02.jpg')}}" alt="Image" class="img"></a>
                  <div class="info">
                    <figure class="i"><img src="{{ asset('assets/home7/images/icon-info.png')}}" alt="Image"></figure>
                    <span>50% off exhibitions</span> </div>
                  <!-- end info -->
                </figure>
                <div class="content-box">
                  <h4><a href="#">Arctic culture and
                    climate Exhibition</a></h4>
                  <p> 22 Oct 2020 - 21 Feb 2021</p>
                </div>
                <!-- end content-box -->
              </div>
              <!-- end exhibition-box --> </div>
            <!-- end col-4 -->
            <div class="col-lg-4 col-md-6">
              <div class="exhibition-box" data-scroll data-scroll-speed="-0.5" >
                <figure> <a href="#"><img src="{{ asset('assets/home7/images/event03.jpg')}}" alt="Image" class="img"></a>
                  <div class="info">
                    <figure class="i"><img src="{{ asset('assets/home7/images/icon-info.png')}}" alt="Image"></figure>
                    <span>50% off exhibitions</span> </div>
                  <!-- end info -->
                </figure>
                <div class="content-box">
                  <h4><a href="#">Thomas Becket murder and
                    the making of a saint</a></h4>
                  <p> 22 Apr 2021 - 22 Aug 2021</p>
                </div>
                <!-- end content-box -->
              </div>
              <!-- end exhibition-box --></div>
            <!-- end col-4 -->
            <div class="col-12 text-center"> <a href="#" class="custom-button">VIEW ALL UPCOMING EVENTS</a> </div>
            <!-- end col-12 -->
          </div>
          <!-- end row -->
        </div>
        <!-- end container -->
      </section>
      <!-- end content-section -->
      <section class="content-section no-bottom-spacing bottom-white" data-background="#fffbf7">
        <div class="container">
          <div class="row justify-content-center">
            <div class="col-12">
              <div class="section-title text-center">
                <figure><img src="{{ asset('assets/home7/images/title-shape.png')}}" alt="Image"></figure>
                <h2>Art Inspiration of <br>
                  19th Century</h2>
              </div>
              <!-- end section-title -->
            </div>
            <!-- end col-12 -->
            <div class="col-lg-4 col-md-6">
              <div class="text-content" data-scroll data-scroll-speed="-1">
                <h6>The challenge</h6>
                <p>In the 1980s, “the UK’s national
                  museums faced political pressure
                  from the <strong>Conservative</strong> government
                  to charge for admission, to make
                  them less dependent on
                  government funding".</p>
              </div>
              <!-- end text-content -->
            </div>
            <!-- end col-4 -->
            <div class="col-lg-4 col-md-6">
              <div class="text-content" data-scroll data-scroll-speed="0.5">
                <h6>The initiative</h6>
                <p>In 1997, the new Labour government
                  made a commitment to reinstate
                  free entry for <strong>national</strong> museums in
                  order to have a more diverse range
                  of visitors. “Following a campaign
                  led by the museums themselves, </p>
              </div>
              <!-- end text-content -->
            </div>
            <!-- end col-4 -->
            <div class="col-lg-4 col-md-6">
              <div class="text-content" data-scroll data-scroll-speed="1">
                <h6>The impact</h6>
                <p>The national museums which
                  dropped charges all saw <strong>substantial</strong> increases to their
                  visitor numbers, an average of
                  70 percent. In the first year after
                  free admission was introduced
                  visitor figures.</p>
              </div>
              <!-- end text-content -->
            </div>
            <!-- end col-4 -->
          </div>
          <!-- end row -->
        </div>
        <!-- end container -->
          <div class="clearfix spacing-100"></div>
        <div class="horizontal-scroll">
          <div class="scroll-inner" data-scroll data-scroll-direction="horizontal" data-scroll-speed="5">
            <div class="scroll-wrapper">
              <div class="container-fluid">
                <div class="row">
                  <div class="col-md-3">
                    <figure class="image-box" data-scroll data-scroll-speed="0"> <img src="{{ asset('assets/home7/images/image01.jpg')}}" alt="Image"> </figure>
                  </div>
                  <!-- end col-3 -->
                  <div class="col-md-4 offset-md-1">
                    <figure class="image-box" data-scroll data-scroll-speed="0"> <img src="{{ asset('assets/home7/images/image02.jpg')}}" alt="Image"> </figure>
                  </div>
                  <!-- end col-3 -->
                  <div class="col-md-2 offset-md-1">
                    <figure class="image-box" data-scroll data-scroll-speed="0"> <img src="{{ asset('assets/home7/images/image03.jpg')}}" alt="Image"> </figure>
                  </div>
                  <!-- end col-3 -->
                </div>
                <!-- end row -->
              </div>
              <!-- end container-fluid -->
            </div>
            <!-- end scroll-wrapper -->
            <div class="scroll-wrapper">
              <div class="container-fluid">
                <div class="row">
                  <div class="col-md-3">
                    <figure class="image-box" data-scroll data-scroll-speed="0"> <img src="{{ asset('assets/home7/images/image01.jpg')}}" alt="Image"> </figure>
                  </div>
                  <!-- end col-3 -->
                  <div class="col-md-4 offset-md-1">
                    <figure class="image-box" data-scroll data-scroll-speed="0"> <img src="{{ asset('assets/home7/images/image02.jpg')}}" alt="Image"> </figure>
                  </div>
                  <!-- end col-3 -->
                  <div class="col-md-2 offset-md-1">
                    <figure class="image-box" data-scroll data-scroll-speed="0"> <img src="{{ asset('assets/home7/images/image03.jpg')}}" alt="Image"> </figure>
                  </div>
                  <!-- end col-3 -->
                </div>
                <!-- end row -->
              </div>
              <!-- container-fluid -->
            </div>
            <!-- end scroll-wrapper -->
          </div>
          <!-- end scroll-inner -->
        </div>
        <!-- end horizontal-scroll -->
      </section>
      <!-- end content-section -->
      <section class="content-section no-bottom-spacing">
        <div class="container">
          <div class="row justify-content-center">
            <div class="col-12">
              <div class="section-title text-center">
                <figure><img src="{{ asset('assets/home7/images/title-shape.png')}}" alt="Image"></figure>
                <h6>Visit the National Wandau Museum</h6>
                <h2>3 steps to be safe</h2>
              </div>
              <!-- end section-title -->
            </div>
            <!-- end col-12 -->
          </div>
          <!-- end row -->
        </div>
        <!-- end container -->
        <div class="container-fluid px-0">
          <div class="row g-0">
            <div class="col-lg-4">
              <div class="image-icon-box" data-scroll data-scroll-speed="-1">
                <figure class="icon"> <img src="{{ asset('assets/home7/images/icon04.png')}}" alt="Image"> </figure>
                <figure class="content-image"> <img src="{{ asset('assets/home7/images/image04.jpg')}}" alt="Image"> </figure>
                <div class="content-box"> <b>01.</b>
                  <h4>Check What's Open</h4>
                  <div class="expand">
                    <p>Your safety is our first priority. Entry to the
                      National Maritime Museum is still free, but to
                      help us ensure social distancing.</p>
                    <a href="#" class="custom-link">Learn More</a> </div>
                  <!-- end expand -->
                </div>
                <!-- end content-box -->
              </div>
              <!-- end image-icon-box -->
            </div>
            <!-- end col-4 -->
            <div class="col-lg-4">
              <div class="image-icon-box" data-scroll data-scroll-speed="0.5">
                <figure class="icon"> <img src="{{ asset('assets/home7/images/icon05.png')}}" alt="Image"> </figure>
                <figure class="content-image"> <img src="{{ asset('assets/home7/images/image05.jpg')}}" alt="Image"> </figure>
                <div class="content-box"> <b>02.</b>
                  <h4>Booking Online</h4>
                  <div class="expand">
                    <p>Exhibition curator Venetia Porter presents this new exhibition of works by artists from Iran to Morocco drawn from the Museum collection.</p>
                    <a href="#" class="custom-link">Learn More</a> </div>
                  <!-- end expand -->
                </div>
                <!-- end content-box -->
              </div>
              <!-- end image-icon-box --> </div>
            <!-- end col-4 -->
            <div class="col-lg-4">
              <div class="image-icon-box" data-scroll data-scroll-speed="1">
                <figure class="icon"> <img src="{{ asset('assets/home7/images/icon06.png')}}" alt="Image"> </figure>
                <figure class="content-image"> <img src="{{ asset('assets/home7/images/image06.jpg')}}" alt="Image"> </figure>
                <div class="content-box"> <b>03.</b>
                  <h4>Keep Your Distance</h4>
                  <div class="expand">
                    <p>Take a look at our past exhibitions and enjoy the articles, videos and photo galleries still available to view online.</p>
                    <a href="#" class="custom-link">Learn More</a> </div>
                  <!-- end expand -->
                </div>
                <!-- end content-box -->
              </div>
              <!-- end image-icon-box --> </div>
            <!-- end col-4 -->
          </div>
          <!-- end row -->
        </div>
        <!-- end container -->
      </section>
      <!-- end content-section -->
      <section class="content-section">
        <div class="container">
          <div class="row g-0 align-items-center">
            <div class="col-lg-6">
              <div class="art-slider">
                <div class="titles">
                  <h6>Art Collection</h6>
                  <h2>History of <br>
                    Barnes</h2>
                </div>
                <!-- end titles -->
                <div class="swiper-container art-slider-content">
                  <div class="swiper-wrapper">
                    <div class="swiper-slide"> <span>01</span>
                      <h3>Venus <br>
                        de Milo</h3>
                    </div>
                    <!-- end swiper-slide -->
                    <div class="swiper-slide"><span>02</span>
                      <h3>Les Demoiselles <br>
                        d'Avignon</h3>
                    </div>
                    <!-- end swiper-slide -->
                    <div class="swiper-slide"><span>03</span>
                      <h3>Mona <br>
                        Lisa</h3>
                    </div>
                    <!-- end swiper-slide -->
                    <div class="swiper-slide"><span>04</span>
                      <h3>L'Arlesienne: <br>
                        Madame Ginoux</h3>
                    </div>
                    <!-- end swiper-slide -->
                    <div class="swiper-slide"><span>05</span>
                      <h3>Cuckoo <br>
                        Clocks</h3>
                    </div>
                    <!-- end swiper-slide -->
                  </div>
                  <!-- end swiper-wrapper -->
                </div>
                <!-- end art-slider-content -->
              </div>
              <!-- end art-slider -->
            </div>
            <!-- end col-6 -->
            <div class="col-lg-6">
              <div class="art-slider" data-scroll data-scroll-speed="1">
                <div class="swiper-container art-slider-images">
                  <div class="swiper-wrapper">
                    <div class="swiper-slide"> <img src="{{ asset('assets/home7/images/art-slide01.jpg')}}" alt="Image"> </div>
                    <!-- end swiper-slide -->
                    <div class="swiper-slide"> <img src="{{ asset('assets/home7/images/art-slide02.jpg')}}" alt="Image"> </div>
                    <!-- end swiper-slide -->
                    <div class="swiper-slide"> <img src="{{ asset('assets/home7/images/art-slide03.jpg')}}" alt="Image"> </div>
                    <!-- end swiper-slide -->
                    <div class="swiper-slide"> <img src="{{ asset('assets/home7/images/art-slide04.jpg')}}" alt="Image"> </div>
                    <!-- end swiper-slide -->
                    <div class="swiper-slide"> <img src="{{ asset('assets/home7/images/art-slide05.jpg')}}" alt="Image"> </div>
                    <!-- end swiper-slide -->
                  </div>
                  <!-- end swiper-wrapper -->
                </div>
                <!-- end art-slider-images -->
              </div>
              <!-- end art-slider -->
            </div>
            <!-- end col-6 -->
          </div>
          <!-- end row -->
        </div>
        <!-- end container -->
      </section>
      <!-- end content-section -->
      <section class="content-section">
        <div class="video-bg">
          <video src="{{ asset('assets/home7/videos/video.mp4')}}" loop autoplay playsinline muted></video>
        </div>
        <!-- end video-bg -->
        <div class="container">
          <div class="cta-box" data-scroll data-scroll-speed="-1">
            <h6>JOIN TODAY AND ENJOY UNLIMITED</h6>
            <h2>exhibitions, Members <br>
              only and more</h2>
            <a href="#" class="custom-button">BECOME A MEMBER</a> </div>
          <!-- end cta-box -->
        </div>
        <!-- end container -->
      </section>
      <!-- end content-section -->
      <section class="content-section">
        <div class="container">
          <div class="row justify-content-center">
            <div class="col-12">
              <div class="section-title text-center">
                <figure><img src="{{ asset('assets/home7/images/title-shape.png')}}" alt="Image"></figure>
                <h6>Get Latest Updates and News</h6>
                <h2>Recent News</h2>
              </div>
              <!-- end section-title -->
            </div>
            <!-- end col-12 -->
          </div>
          <!-- end row -->
        </div>
        <!-- end container -->
        <div class="container">
          <div class="row">

            @if(!empty($recent_blogs))
                @foreach ($recent_blogs as $recent_blog)
                    <div class="col-12">
                    <div class="recent-news">
                        <div class="content-box"> <small> {{date('F d, Y', strtotime($recent_blog->created_at))}}</small>
                        <h3>{{$recent_blog->title}}</h3>

                        <a href="{{route('blog.details',encrypted_key($recent_blog->id,"encrypt"))}}" class="custom-link">Continue reading</a> </div>
                        <!-- end content-box -->
                        <figure data-scroll data-scroll-speed="-1">  @if(file_exists( storage_path().'/blog/'.$recent_blog->image ) && !empty($recent_blog->image))
                            <img src="{{asset('storage')}}/blog/{{ $recent_blog->image }}" class="img-responsive" alt="...">
                            @else
                            <img class="img-fluid" src="{{ asset('assets/img/blog/blog-thumb-01.jpg') }}" class="img-responsive" alt="">
                            @endif</figure>
                    </div>
                    <!-- end recent-news -->
                    </div>
                    <!-- end col-8 -->
                @endforeach
            @endif

            <!-- end col-9 -->
            <div class="col-12 text-center"> <a href="{{route('search.blogs')}}" class="circle-button">SEE ALL<br>
              NEWS</a> </div>
            <!-- end col-12 -->
          </div>
          <!-- end row -->
        </div>
        <!-- end container -->
      </section>
      <!-- end content-section -->
      <section class="content-section no-spacing" data-background="#94ffc4">
        <div class="container">
          <div class="row">
            <div class="col-12">
              <div class="newsletter-box">

                <div class="form">
                    <form  method="POST"  action="{{url('subscribe')}}" enctype="multipart/form-data">
                  <div class="titles">
                    <h6>Subscribe Newsletter</h6>
                    <h2>Sign up to get the
                      latest news</h2>
                  </div>

                  <!-- end titles -->
                  <div class="inner">

                        {!! csrf_field() !!}
                    <input type="email" name="eamil" required placeholder="Enter your e-mail address">
                    <button type="submit" value="SIGN UP">SIGN UP </button>

                  </div>

                  <!-- end inner -->
                  <small>Will be used in accordance with our <a href="#">Privacy Policy</a></small></form> </div>
                <!-- end form -->
                <figure class="newsletter-image" data-scroll data-scroll-speed="0.7"><img src="{{ asset('assets/home7/images/newsletter-image.png')}}" alt="Image"></figure>
              </div>
              <!-- end newsletter-box -->
            </div>
            <!-- end col-12 -->
          </div>
          <!-- end row -->
        </div>
        <!-- end container -->
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
      <!-- end content-section -->
      <footer class="footer">
        <div class="container">
          <div class="row">
            <div class="col-lg-4 col-md-6">
              <h6 class="widget-title">About Museum</h6>
              <ul class="footer-menu">
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
            <!-- end col-4 -->
            <div class="col-lg-4 col-md-6">
              <h6 class="widget-title">Connect Us</h6>
              <ul class="social-media">
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
            <!-- end col-4 -->
            <div class="col-lg-4">
              <h6 class="widget-title">Visit Us Now</h6>
              <address class="address">
              Cromwell Road New Town SW7 <strong>London - England</strong> <i class="fas fa-info-circle"></i> +44 (0)20 7942 2000
              </address>
            </div>
            <!-- end col-4 -->
          </div>
          <!-- end row -->
        </div>
        <!-- end container -->
        <div class="footer-bottom">
          <div class="container"> <span class="copyright">© 2021 Wandau | Art & History Museum</span> <span class="creation">Site created by <a href="#">themezinho</a></span> </div>
          <!-- end container -->
        </div>
        <!-- end footer-bottom -->
      </footer>
      <!-- end footer -->
    </div>
  </div>

@endsection
