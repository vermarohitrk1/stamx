@extends('layout.frontend.home19.mainlayout')
@section('content')
<style>
	.vlt-custom--4124{
		width: 53vw;
	}
    @media all and (min-width: 992px) {
        .navbar .nav-item .dropdown-menu{ display: none; }
        .navbar .nav-item:hover .nav-link{ color: #fff;  }
        .navbar .nav-item:hover .dropdown-menu{ display: block; }
        .navbar .nav-item .dropdown-menu{ margin-top:0; }
    }
    .vlt-navbar .vlt-navbar-logo img{
        max-height: 61px;
    }
	.nav-link{
		font-size: 1.25rem;
		font-weight: 600;
		position: relative;
		letter-spacing: -.01em;
		text-transform: capitalize;
	}

    .slick-slide {
      margin: 0px 20px;
    }

    .logo-carousel {
      overflow: inherit;
      border-top: 1px solid #353535;
      border-bottom: 1px solid #353535;
    }

    .slick-slide img {
      width: 100%;
    }

    .slick-track::before,
    .slick-track::after {
      display: table;
      content: '';
    }

    .slick-track::after {
      clear: both;
    }

    .slick-track {
      padding: 1rem 0;
    }

    .slick-loading .slick-track {
      visibility: hidden;
    }

    .slick-slide.slick-loading img {
      display: none;
    }

    .slick-slide.dragging img {
      pointer-events: none;
    }

    .slick-loading .slick-slide {
      visibility: hidden;
    }

    .slick-arrow {
      position: absolute;
      top: 50%;
      background: url(https://raw.githubusercontent.com/solodev/infinite-logo-carousel/master/images/arrow.svg?sanitize=true) center no-repeat;
      color: #fff;
      filter: invert(77%) sepia(32%) saturate(1%) hue-rotate(344deg) brightness(105%) contrast(103%);
      border: none;
      width: 2rem;
      height: 1.5rem;
      text-indent: -10000px;
      margin-top: -16px;
      z-index: 99;
    }

    .slick-arrow.slick-next {
      right: -40px;
      transform: rotate(180deg);
    }

    .slick-arrow.slick-prev {
      left: -40px;
    }

    /* Media Queries */

    @media (max-width: 768px) {
      .slick-arrow {
        width: 1rem;
        height: 1rem;
      }
    }

    body {
        background-color: #010101;
      }

    .row {
      overflow: hidden;
    }

    /* JsFiddle Example only/don't use */
    .logo-carousel {
      margin-top: 32px;
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
        $footer_text =  \App\SiteSettings::footerSetting();
    @endphp
    <!--Header-->
	<header class="vlt-header">
		<div class="vlt-navbar vlt-navbar--main vlt-navbar--fixed">
			<div class="vlt-navbar-background"></div>
			<div class="vlt-navbar-inner">
				<div class="vlt-navbar-inner--left">
					<!--Logo--><a class="vlt-navbar-logo" href="/">
                        @if (!empty($logo_favicon['logo']))
                            <img class="black"  src="{{ asset('storage/logo').'/'.$logo_favicon['logo'] }}"alt="LogoImage" >
                            <img class="white"  src="{{ asset('storage/logo').'/'.$logo_favicon['logo'] }}"alt="LogoImage" >
                        @else
                            <span class="logo-text black">@if(!empty($logoTxt)) {{ $logoTxt }} @else Your Logo Here @endif</span>
                        @endif
                       </a>
					<!--Contacts-->

                    <nav class="navbar navbar-expand-md vlt-navbar-contacts">

                        <div id="navbarCollapse" class="collapse navbar-collapse">
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

                        </div>
					</nav>

				</div>
                <nav class="vlt-navbar-contacts d-none d-md-block vlt-navbar-inner--right">
                    <ul>
                        @guest
                        @if ($donation = \App\PublicPageDetail::where('user_id',get_domain_user()->id)->first())
                            @php $dId = base64_encode($donation->id);
                            $user_setting = DB::table('website_setting')->where('user_domain_id', get_domain_id())->where('name', 'payment_settings')->first();
                        @endphp
                            @if($user_setting != null)
                            <li><a class="nav-link mr-2" href='{{ url("$dId/donation")}}'>Donate</a></li>
                                @endif
                        @endif
                            <li> <a class="nav-link mr-2" href="{{ route('login') }}">Login</a></li>



                    @else
                    <li><a class="nav-link mr-2" href="{{ route('home') }}">Dashboard</a></li>


                @endguest
                    </ul>
                  </nav>


                    <div class="vlt-navbar-inner--right">

					<div class="d-flex align-items-center">
						<!--Menu Burger--><a class="vlt-menu-burger js-offcanvas-menu-open" href="#"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="square" stroke-linejoin="round">
								<line x1="3" y1="12" x2="21" y2="12" />
								<line x1="3" y1="6" x2="21" y2="6" />
								<line x1="3" y1="18" x2="21" y2="18" /></svg></a>
					</div>
				</div>
			</div>
		</div>
	</header>
	<!--Offcanvas Menu-->
	<div class="vlt-offcanvas-menu">
		<div class="vlt-offcanvas-menu__header">
			<!--Locales-->
			<nav class="vlt-offcanvas-menu__locales"><a class="active" href="#"></a><a href="#"></a><a href="#">
			</a></nav>
			<!--Menu Burger--><a class="vlt-menu-burger vlt-menu-burger--opened js-offcanvas-menu-close" href="#"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="square" stroke-linejoin="round">
					<line x1="18" y1="6" x2="6" y2="18" />
					<line x1="6" y1="6" x2="18" y2="18" /></svg></a>
		</div>
		<nav class="vlt-offcanvas-menu__navigation">
			<!--Navigation-->
			<ul class="sf-menu">
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
                        @php
                            $dId = base64_encode($donation->id);
                            $user_setting = DB::table('website_setting')->where('user_domain_id', get_domain_id())->where('name', 'payment_settings')->first();
                        @endphp
                            @if($user_setting != null)
                                <li><a class="nav-link" href='{{ url("$dId/donation")}}'>Donate</a></li>
                            @endif
                    @endif
                            <li> <a class="nav-link" href="{{ route('login') }}">log In</a></li>
                @else
                    <li><a class="nav-link" href="{{ route('home') }}">Dashboard</a></li>
                @endguest
			</ul>
		</nav>
		<div class="vlt-offcanvas-menu__footer">
			<!--Socials-->
			<div class="vlt-offcanvas-menu__socials"><a href="#" target="_blank"></a><a href="#" target="_blank">B</a><a href="#" target="_blank"></a><a href="#" target="_blank"></a></div>
			<!--Copyright-->
			<div class="vlt-offcanvas-menu__copyright">
				<p></p>
			</div>
		</div>
	</div>
	<!--Site Overlay-->
	<div class="vlt-site-overlay"></div>
	<!--Fixed Socials-->
	<div class="vlt-fixed-socials"><a href="#" target="_blank"></a><a href="#" target="_blank"></a><a href="#" target="_blank"></a><a href="#" target="_blank"></a></div>
	<!--Main-->
	<main class="vlt-main">
		<!--Fullpage Slider-->
		<div class="vlt-fullpage-slider" data-loop-top="" data-loop-bottom="" data-speed="800">
			<!--Home-->
			<!--Section-->
			<div class="vlt-section pp-scrollable" data-anchor="Home" data-brightness="dark" style="background-image: url({{ asset('assets/home19/img/root/red-background.jpg')}});">
				<div class="vlt-section__vertical-align">
					<div class="vlt-section__content">
						<!--Particles-->
						<div class="vlt-section__particles">
							<div class="vlt-particle vlt-fade-in-left vlt-custom--1451" style="background-image: url({{ asset('assets/home19/img/root/plus-dark-pattern.png')}}); transition-duration: 1s;"></div>
							<div class="vlt-particle d-none d-xl-block vlt-fade-in-right vlt-custom--1512" style="background-image: url({{ asset('assets/home19/img/root/elipse-home-slide.png')}}); transition-duration: 1.5s; transition-delay: 300ms;"></div>
							<div class="vlt-particle vlt-custom--4124" style="background-image: url({{ asset('assets/home19/img/attachment-01.png')}});"></div>
						</div>
						<div class="container">
							<div class="row">
								<div class="col-lg-7 offset-lg-1">
									<!--Animated Block-->
									<div class="vlt-animated-block" style="animation-delay:0s; animation-duration:700ms;">
										<h5 class="vlt-display-1 has-white-color">The Holy Grail of</h5>
										<div class="vlt-gap-10"></div>

										<h1 class="vlt-large-heading has-white-color">AI, Data, & Social<br>Experiences</h1>
										<div class="vlt-gap-40"></div>
										<div class="vlt-gap-40"></div><a class="vlt-link has-white-color" href="#">A Leading Stem Engagement and Analytics Platform... More Access, More Equity,
More Analytics Than Ever Before!
</a>
									</div>

								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
			<!--Services-->
			<!--Section-->
			<div class="vlt-section pp-scrollable" data-anchor="Services" data-brightness="light">
				<div class="vlt-section__vertical-align">
					<div class="vlt-section__content">
						<!--Particles-->
						<div class="vlt-section__particles">
							<div class="vlt-particle vlt-custom--1259 vlt-fade-in-right" style="background-image: url({{ asset('assets/home19/img/root/plus-light-pattern.png')}}); animation-delay: 750ms;"></div>
							<div class="vlt-particle vlt-custom--2355 vlt-fade-in-left" style="background-image: url({{ asset('assets/home19/img/root/elipse-light.png')}}); animation-delay: 500ms;"></div>
						</div>
						<div class="container">
							<div class="row">
								<div class="col-lg-2 offset-lg-1 d-none d-lg-block">
									<!--Animated Block-->
									<div class="vlt-animated-block" style="animation-delay:0s; animation-duration:700ms;">
										<!--Counter Up-->
										<div class="vlt-counter-up" data-ending-number="10" data-animation-speed="1000" data-delimiter=""><span class="counter">0</span><sup>+</sup>
										</div>
										<div class="vlt-gap-40"></div>
										<h6>Years <br>Experience <br> & Innovation</h6>
									</div>
								</div>
								<div class="col-lg-8 col-md-12">
									<!--Animated Block-->
									<div class="vlt-animated-block" style="animation-delay:100ms; animation-duration:700ms;">
										<h4>Powerful solutions that allow organizations to actualize
<span class="has-first-color">and amplify collective impact.</span></h4>
									</div>
									<div class="vlt-gap-70"></div>
									<div class="row">
										<div class="col-md-6">
											<!--Animated Block-->
											<div class="vlt-animated-block" style="animation-delay:200ms; animation-duration:700ms;">
												<!--Services-->
												<div class="vlt-services">
													<h5 class="vlt-services__title"><a href="#">Blockchain</a>
													</h5>
													<p class="vlt-services__text">Monetize and unlock the hidden value of their physical and digital assets through Smart Contracts and Non-Fungible Tokens (NFTs).
													</p><a class="vlt-services__link vlt-link-with-arrow" href="#"><span class="vlt-link-with-arrow__text">Discover more</span><span class="vlt-link-with-arrow__icon">🡒</span></a>
												</div>
											</div>
											<div class="vlt-gap-40"></div>
										</div>
										<div class="col-md-6">
											<!--Animated Block-->
											<div class="vlt-animated-block" style="animation-delay:300ms; animation-duration:700ms;">
												<!--Services-->
												<div class="vlt-services">
													<h5 class="vlt-services__title"><a href="#">Gaming</a>
													</h5>
													<p class="vlt-services__text">Leverage our AR experience, gaming supplier network and integrated education partnerships to develop a comprehensive esports solution.
													</p><a class="vlt-services__link vlt-link-with-arrow" href="#"><span class="vlt-link-with-arrow__text">Discover more</span><span class="vlt-link-with-arrow__icon">🡒</span></a>
												</div>
											</div>
											<div class="vlt-gap-40"></div>
										</div>
										<div class="col-md-6">
											<!--Animated Block-->
											<div class="vlt-animated-block" style="animation-delay:400ms; animation-duration:700ms;">
												<!--Services-->
												<div class="vlt-services">
													<h5 class="vlt-services__title"><a href="#">Metaverse</a>
													</h5>
													<p class="vlt-services__text">Build your brand, increase sales by creating, sharing, and interacting with augmented-reality (AR) "experiences.
													</p><a class="vlt-services__link vlt-link-with-arrow" href="#"><span class="vlt-link-with-arrow__text">Discover more</span><span class="vlt-link-with-arrow__icon">🡒</span></a>
												</div>
											</div>
											<div class="vlt-gap-40--sm"></div>
										</div>
										<div class="col-md-6">
											<!--Animated Block-->
											<div class="vlt-animated-block" style="animation-delay:500ms; animation-duration:700ms;">
												<!--Services-->
												<div class="vlt-services">
													<h5 class="vlt-services__title"><a href="#">Data Literacy</a>
													</h5>
													<p class="vlt-services__text">Boost data literacy skills by enhancing employees ability to read, understand, create, and communicate data as information.
													</p><a class="vlt-services__link vlt-link-with-arrow" href="#"><span class="vlt-link-with-arrow__text">Discover more</span><span class="vlt-link-with-arrow__icon">🡒</span></a>
												</div>
											</div>
											<div class="vlt-gap-40"></div>
										</div>
										<div class="col-md-6">
											<!--Animated Block-->
											<div class="vlt-animated-block" style="animation-delay:400ms; animation-duration:700ms;">
												<!--Services-->
												<div class="vlt-services">
													<h5 class="vlt-services__title"><a href="#">Staffing</a>
													</h5>
													<p class="vlt-services__text">Recruit and train the candidates you need at scale. AI talent acquisition solutions that empower businesses to hire talent on-demand.
													</p><a class="vlt-services__link vlt-link-with-arrow" href="#"><span class="vlt-link-with-arrow__text">Discover more</span><span class="vlt-link-with-arrow__icon">🡒</span></a>
												</div>
											</div>
											<div class="vlt-gap-40--sm"></div>
										</div>
										<div class="col-md-6">
											<!--Animated Block-->
											<div class="vlt-animated-block" style="animation-delay:500ms; animation-duration:700ms;">
												<!--Services-->
												<div class="vlt-services">
													<h5 class="vlt-services__title"><a href="#">Certifications</a>
													</h5>
													<p class="vlt-services__text">Choose from professional certificates to workforce certifications and licenses. Earn a credential, showcase your skills to local and national employers.
													</p><a class="vlt-services__link vlt-link-with-arrow" href="#"><span class="vlt-link-with-arrow__text">Discover more</span><span class="vlt-link-with-arrow__icon">🡒</span></a>
												</div>
											</div>
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
			<!--Experience-->
			<!--Section-->
			<div class="vlt-section pp-scrollable" data-anchor="Experience" data-brightness="dark">
				<div class="vlt-section__vertical-align">
					<div class="vlt-section__content">
						<!--Ken Burn Effect-->
						<div class="vlt-section__ken-burn-background"><img src="{{ asset('assets/home19/img/attachment-02.jpg')}}" alt=""></div>
						<div class="container">
							<div class="row">
								<div class="col-lg-10 offset-lg-1">
									<!--Animated Block-->
									<div class="vlt-animated-block" style="animation-delay:0s; animation-duration:700ms;">
										<div class="d-block d-md-flex align-items-center justify-content-between">
											<h1 class="has-white-color">Marketplace</h1>
											<div class="vlt-gap-30--sm"></div>
											<div class="vlt-timeline-slider-controls"><span class="prev">🡐</span><span class="pagination"></span><span class="next">🡒</span></div>
										</div>
									</div>
									<div class="vlt-gap-50"></div>
									<!--Animated Block-->
									<div class="vlt-animated-block" style="animation-delay:100ms; animation-duration:700ms;">
										<!--Timeline Slider-->
										<div class="vlt-timeline-slider">
											<div class="swiper-container">
												<div class="swiper-wrapper">
                                                    @if(!empty($addons))
                                                    @foreach($addons->chunk(3) as $b)

                                                                  <div>
                                                                    @foreach($b as $addon)

                                                                            <!--Timeline Slider Item-->
                                                                            <div class="vlt-timeline-item">
                                                                                <div class="row">

                                                                                    <div class="col-sm-12 col-md-3"><span class="vlt-timeline-item__year">
                                                                                        @if(!empty($addon->category))
                                                                                            @php
                                                                                                $AddonCategory =\App\AddonCategory::where('id',$addon->category)->first();

                                                                                            @endphp
                                                                                            {{ ($AddonCategory->name ??'')  }}
                                                                                        @endif


                                                                                    </span>
                                                                                    </div>
                                                                                    <div class="col-sm-12 col-md-3">
                                                                                        <h5 class="vlt-timeline-item__title">{{$addon->title}}</h5>
                                                                                    </div>
                                                                                    <div class="col-sm-12 col-md-5 offset-md-1" style="color: #fff">
                                                                                      {!! \Illuminate\Support\Str::limit($addon->description, 150,'...')!!}
                                                                                    </div>
                                                                                </div>
                                                                            </div>


                                                                        @endforeach
                                                                        </div>


                                                    @endforeach

                                                    @endif



												</div>
											</div>
										</div>
									</div>
									<div class="vlt-gap-50"></div>
									<!--Animated Block-->
									<div class="vlt-animated-block" style="animation-delay:200ms; animation-duration:700ms;">
										<!--Button--><a class="vlt-btn vlt-btn--primary" href="#" target="_self"><span class="vlt-btn__text">Ready to Talk?</span><span class="vlt-btn__icon vlt-btn__icon--right"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="square" stroke-linejoin="round">
													<line x1="12" y1="5" x2="12" y2="19"></line>
													<polyline points="19 12 12 19 5 12"></polyline>
												</svg></span></a>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>


			<!--Testimonials-->
			<!--Section-->
			<div class="vlt-section pp-scrollable" data-anchor="Testimonials" data-brightness="dark">
				<div class="vlt-section__vertical-align">
					<div class="vlt-section__content">
						<!--Ken Burn Effect-->
						<div class="vlt-section__ken-burn-background"><img src="{{ asset('assets/home19/img/attachment-04.jpg')}}" alt=""></div>
						<div class="container">
							<div class="row">
								<div class="col-lg-10 offset-lg-1">
									<!--Animated Block-->
									<div class="vlt-animated-block" style="animation-delay:0s; animation-duration:700ms;">
										<div class="d-block d-md-flex align-items-center justify-content-between">
											<h1 class="has-white-color">Podcasts</h1>
											<div class="vlt-gap-30--sm"></div>
											<div class="vlt-testimonial-slider-controls"><span class="prev">🡐</span><span class="pagination"></span><span class="next">🡒</span></div>
										</div>
									</div>
									<div class="vlt-gap-50"></div>
									<!--Animated Block-->
									<div class="vlt-animated-block" style="animation-delay:100ms; animation-duration:700ms;">
										<!--Testimonial Slider-->
										<div class="vlt-testimonial-slider">
											<div class="swiper-container">
												<div class="swiper-wrapper">
													<!--Testimonial Item-->
                                                    @if(!empty($podcasts))
                                                        @foreach ($podcasts as $podcast)
                                                        <div class="vlt-testimonial-item" style="background: #eb000d url({{ asset('assets/home19/img/root/cartographer.png')}}) repeat;">
                                                            <div class="vlt-testimonial-item__avatar"><img src="{{ url('storage/podcasts/'.$podcast->image)}}" alt="Damien O'Ryan"></div>
                                                            <div class="vlt-testimonial-item__content">
                                                                <p>{{ \Illuminate\Support\Str::limit($podcast->description, 150,'...')}}</p>
                                                                <div class="vlt-testimonial-item__meta">
                                                                   <a href="{{route('podcast_detail',encrypted_key($podcast->id,"encrypt"))}}"> <h6>{{$podcast->title}}</h6></a>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        @endforeach
                                                    @endif
												</div>
											</div>
										</div>
									</div>
									<div class="vlt-gap-70"></div>
                                    @if(!empty($partners))
                                        <div class="row justify-content-md-between">
                                            <section class="logo-carousel slider" data-arrows="true">
                                                @foreach($partners as $partner)
                                                <a href="{{ @$partner->link }}">
                                                    <div class="slide"> <img src="{{asset('storage')}}/partner/{{ $partner->logo }}"></div></a>
                                                @endforeach
                                            </section>
                                        </div>
                                    @endif
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
			<!--Blog-->
			<!--Section-->
			<div class="vlt-section pp-scrollable" data-anchor="Blog" data-brightness="light">
				<div class="vlt-section__vertical-align">
					<div class="vlt-section__content">
						<!--Particles-->
						<div class="vlt-section__particles">
							<div class="vlt-particle vlt-custom--1259 vlt-fade-in-right" style="background-image: url({{ asset('assets/home19/img/root/plus-light-pattern.png')}}); animation-delay: 750ms;"></div>
							<div class="vlt-particle vlt-custom--2355 vlt-fade-in-left" style="background-image: url({{ asset('assets/home19/img/root/elipse-light.png')}}); animation-delay: 500ms;"></div>
						</div>
						<div class="container">
							<div class="row">
								<div class="col-lg-10 offset-lg-1">
									<!--Animated Block-->
									<div class="vlt-animated-block" style="animation-delay:0s; animation-duration:700ms;">
										<div class="d-block d-md-flex align-items-center justify-content-between">
											<h1>Insights</h1>
											<div class="vlt-gap-30--sm"></div><a class="vlt-btn vlt-btn--primary" href="{{route('search.blogs')}}"><span class="vlt-btn__text">View More Posts</span></a>
										</div>
									</div>
									<div class="vlt-gap-50"></div>
									<div class="row">
                                        @if(!empty($recent_blogs))
                                            @foreach ($recent_blogs as $recent_blog)
                                                <div class="col-md-4">
                                                    <!--Animated Block-->
                                                    <div class="vlt-animated-block" style="animation-delay:100ms; animation-duration:700ms;">
                                                        <!--Blog Post-->
                                                        <article class="vlt-post">
                                                            <div class="vlt-post-thumbnail">
                                                                @if(file_exists( storage_path().'/blog/'.$recent_blog->image ) && !empty($recent_blog->image))
                                                                <img src="{{asset('storage')}}/blog/{{ $recent_blog->image }}" class="img-responsive" alt="...">
                                                                @else
                                                                <img class="img-fluid" src="{{ asset('assets/img/blog/blog-thumb-01.jpg') }}" class="img-responsive" alt="">
                                                                @endif
                                                                <a class="vlt-post-thumbnail__link" href="{{route('blog.details',encrypted_key($recent_blog->id,"encrypt"))}}"></a>
                                                            </div>
                                                            <div class="vlt-post-content">
                                                                <header class="vlt-post-header">
                                                                    <div class="vlt-post-meta"><span>{{$recent_blog->tags}}</span><span>{{date('F d, Y', strtotime($recent_blog->created_at))}}</span>
                                                                    </div>
                                                                    <h3 class="vlt-post-title"><a href="{{route('blog.details',encrypted_key($recent_blog->id,"encrypt"))}}">{{$recent_blog->title}}</a></h3>
                                                                </header>
                                                                <footer class="vlt-post-footer"><a class="vlt-post__link vlt-link-with-arrow" href="{{route('blog.details',encrypted_key($recent_blog->id,"encrypt"))}}"><span class="vlt-link-with-arrow__text">Read more</span><span class="vlt-link-with-arrow__icon">🡒</span></a></footer>
                                                            </div>
                                                        </article>
                                                    </div>
                                                    <div class="vlt-gap-40--sm"></div>
                                                </div>
                                            @endforeach
                                        @endif
								</div>
                            </div>
							</div>
						</div>
					</div>
				</div>
			</div>
			<!--Contact-->

			<!--Section-->
			<div class="vlt-section pp-scrollable" data-anchor="Contact" data-brightness="dark">
				<div class="vlt-section__vertical-align">
					<div class="vlt-section__content">
						<!--Ken Burn Effect-->
						<div class="vlt-section__ken-burn-background"><img src="{{ asset('assets/home19/img/attachment-05.jpg')}}" alt=""></div>
						<div class="container">
							<div class="row">
								<div class="col-lg-4 offset-lg-1">
									<!--Animated Block-->
									<div class="vlt-animated-block" style="animation-delay:0s; animation-duration:700ms;">
										<h1 class="has-white-color">Contact</h1>
										<div class="vlt-gap-20"></div>
										<p class="has-gray-color">We're available 24 hours a day, 7 days a week, 365 days a year.</p>
										<div class="vlt-gap-50"></div>
										<div class="has-white-color">
											<h6 class="vlt-display-1 has-gray-color">Email:</h6>
											<div class="vlt-gap-5"></div><a href="mailto:consult@stemx.com">consult@stemx.com</a>
										</div>
										<div class="vlt-gap-30"></div>
										<div class="has-white-color">
											<h6 class="vlt-display-1 has-gray-color">Phone:</h6>
											<div class="vlt-gap-5"></div><a href="tel:+79281012345">888.USA.Stem</a>
										</div>
										<div class="vlt-gap-40"></div><a class="vlt-btn vlt-btn--secondary" href="#"><span class="vlt-btn__text">Get direction</span><span class="vlt-btn__icon vlt-btn__icon--right"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-map-pin">
													<path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0 1 18 0z" />
													<circle cx="12" cy="10" r="3" /></svg></span></a>
									</div>
									<div class="vlt-gap-70--sm"></div>
								</div>
								<div class="col-lg-6">
									<!--Animated Block-->
									<div class="vlt-animated-block" style="animation-delay:100ms; animation-duration:700ms;">
										<h5 class="has-white-color">The Metaverse Is Coming And It's A Very Big Deal... <span class="has-first-color"> Are You Ready?</span></h5>
										<div class="vlt-gap-40"></div>

                                        <form method="post" action="{{route('contact_us')}}"  enctype="multipart/form-data">
                                                {!! csrf_field() !!}
											<div class="vlt-form-row two-col">
												<div class="vlt-form-group">
													<label class="has-white-color" for="name">Your name</label>
													<input type="text" id="name" name="name" required="required" placeholder="Your Name">
												</div>
												<div class="vlt-form-group">
													<label class="has-white-color" for="email">Your email</label>
													<input type="email" id="email" name="email" required="required" placeholder="Your Email">
												</div>
											</div>
											<div class="vlt-form-row">
												<div class="vlt-form-group">
													<label class="has-white-color" for="category">Subject</label>
													<input type="text" id="subject" name="subject" placeholder="Subject" required>
												</div>
											</div>
											<div class="vlt-form-group">
												<label class="has-white-color" for="message">Your Message</label>
												<textarea name="message" id="message" rows="3" placeholder="Message" required></textarea>
                                            </div>
											<!--Button-->
											<button type="submit" class="vlt-btn vlt-btn--primary"><span class="vlt-btn__text">Contact Me</span><span class="vlt-btn__icon vlt-btn__icon--right"></span></button>
										</form>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
			<!--Progress Bar-->
			<ul class="vlt-fullpage-slider-progress-bar">
				<li data-menuanchor="Home"></li>
				<li data-menuanchor="Services"></li>
				<li data-menuanchor="Experience"></li>
				<li data-menuanchor="Skills"></li>
				<li data-menuanchor="Portfolio"></li>
				<li data-menuanchor="Awards"></li>
				<li data-menuanchor="Testimonials"></li>
				<li data-menuanchor="Blog"></li>
				<li data-menuanchor="Contact"></li>
			</ul>
			<!--Numbers-->
			<div class="vlt-fullpage-slider-numbers"></div>
		</div>
		<!--Footer-->
		<footer class="vlt-footer vlt-footer--fixed">
			<!--Copyright-->
			<div class="vlt-footer-copyright">
				<p>{{$footer_text}}</p>
			</div>
		</footer>
	</main>
@endsection
