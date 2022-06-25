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
	<div class="row stemx">
			<div class="col-12 col-md-12 ">
					<nav class="navbar navbar-expand-lg fixed-top ">
						<div class="container">
  						<a class="navbar-brand" href="{{ url('')}}">
						
						   @if (!empty($logo_favicon['logo']))
                        <img src="{{ asset('storage/logo').'/'.$logo_favicon['logo'] }}"alt="LogoImage" class="img-fluid mainlogo">
                    @else
                     <h3 style="margin-top:15px !important;">@if(!empty($logoTxt)) {{ $logoTxt }} @else Your Logo Here @endif</h3>
                        <!--<img src="{{ asset('assets/main/images/logo.png')}}" alt="LogoImage" class="img-fluid mainlogo">-->
                    @endif
  							
  						</a>
						  <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#fornav" aria-controls="fornav" aria-expanded="false" aria-label="Toggle navigation">
						   <i class="fa fa-bars"></i>
				 			 <i class="fa fa-times"></i>
						  </button>

						<div class="collapse navbar-collapse menu-links" id="fornav">
					    <ul class="navbar-nav mr-auto mt-2 mt-lg-0">
					        
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
                    <!--<li class="{{ (Request::is('index') || Request::is('/') || Request::is('home') )  ? 'active' : '' }}">-->
                    <!--    <a class="nav-link" href="{{url('/home')}}">Home</a>-->
                    <!--</li>-->
                    <!--<li class="{{ Request::is('search/profiles') ? 'active' : '' }}">-->
                    <!--    <a  class="nav-link" href="{{route('search.profile')}}">Search Profile</a>-->
                    <!--</li>-->
                    <!--<li class="{{ Request::is('search/courses') ? 'active' : '' }}">-->
                    <!--    <a class="nav-link" href="{{route('search.courses')}}">Courses</a>-->
                    <!--</li>-->
                    <!--<li class="{{ Request::is('search/blogs') ? 'active' : '' }}">-->
                    <!--    <a class="nav-link" href="{{route('search.blogs')}}">Blogs</a>-->
                    <!--</li>-->
                    <!--<li class="{{ Request::is('search/profiles') ? 'active' : '' }}">-->
                    <!--    <a class="nav-link" href="{{route('search.profile')}}">Booking</a>-->
                    <!--</li>-->
                  
					        
					      <!--<li class="nav-item dropdown">-->
					      <!--  <a class="nav-link dropdown-toggle" href="#" id="navbarDropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">-->
					      <!--    Home-->
					      <!--  </a>-->
					      <!--  <div class="dropdown-menu" aria-labelledby="navbarDropdownMenuLink">-->
					      <!--    <a class="dropdown-item" href="#">Home One</a>-->
					      <!--    <a class="dropdown-item" href="#">Home Two</a>-->
					      <!--  </div>-->
					      <!--</li>-->
					      <!-- home end -->
					      
					      <!--<li class="nav-item dropdown">-->
					      <!--  <a class="nav-link dropdown-toggle" href="#" id="navbarDropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">-->
					          
					      <!--    stemterns-->
					      <!--  </a>-->
					      <!--  <div class="dropdown-menu" aria-labelledby="navbarDropdownMenuLink">-->
					      <!--    <a class="dropdown-item" href="#">stemterns One</a>-->
					      <!--    <a class="dropdown-item" href="#">stemterns Two</a>-->
					      <!--  </div>-->
					      <!--</li>-->
					      <!-- STEMTERNS end -->

					      <!--<li class="nav-item dropdown">-->
					      <!--  <a class="nav-link dropdown-toggle" href="#" id="navbarDropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">-->
					          
					      <!--    Mentors-->
					      <!--  </a>-->
					      <!--  <div class="dropdown-menu" aria-labelledby="navbarDropdownMenuLink">-->
					      <!--    <a class="dropdown-item" href="#">Mentors One</a>-->
					      <!--    <a class="dropdown-item" href="#">Mentors Two</a>-->
					      <!--  </div>-->
					      <!--</li>-->
					      <!-- MENTORS end -->

					      <!--<li class="nav-item dropdown">-->
					      <!--  <a class="nav-link dropdown-toggle" href="#" id="navbarDropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">-->
					          
					      <!--    Labs-->
					      <!--  </a>-->
					      <!--  <div class="dropdown-menu" aria-labelledby="navbarDropdownMenuLink">-->
					      <!--    <a class="dropdown-item" href="#">Labs One</a>-->
					      <!--    <a class="dropdown-item" href="#">Labs Two</a>-->
					      <!--  </div>-->
					      <!--</li>-->
					      <!-- LABS end -->

					      <!--<li class="nav-item dropdown">-->
					      <!--  <a class="nav-link dropdown-toggle" href="#" id="navbarDropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">-->
					          
					      <!--    Certify-->
					      <!--  </a>-->
					      <!--  <div class="dropdown-menu p-3" aria-labelledby="navbarDropdownMenuLink">-->
					      <!--    <a class="dropdown-item" href="#">Certify One</a>-->
					      <!--    <a class="dropdown-item" href="#">Certify Two</a>-->
					      <!--  </div>-->
					      <!--</li>-->
					      <!-- CERTIFY  end -->

					      <!--<li class="nav-item dropdown">-->
					      <!--  <a class="nav-link" href="#" id="navbarDropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">-->
					      <!--    Enage-->
					      <!--    <i class="fa fa-angle-down downangle"></i>-->

					      <!--  </a>-->
					      <!--  <div class="dropdown-menu" aria-labelledby="navbarDropdownMenuLink">-->
					      <!--    <a class="dropdown-item" href="#">Enage One</a>-->
					      <!--    <a class="dropdown-item" href="#">Enage Two</a>-->
					      <!--  </div>-->
					      <!--</li>-->
					      <!-- ENAGE end -->



					    </ul>

					  
					         @guest
					           <div class="my-2 my-lg-0 right-side-buttons">
							   @if ($donation = \App\PublicPageDetail::where('user_id',get_domain_user()->id)->first())
							 	@php $dId = base64_encode($donation->id);
								 $user_setting = DB::table('website_setting')->where('user_domain_id', get_domain_id())->where('name', 'payment_settings')->first();
        						@endphp
									@if($user_setting != null)
									<a href='{{ url("$dId/donation")}}' class="top-btns blue-btn">Donate</a>
								  	@endif
					           @endif
					          
					           <a href="{{ route('login') }}" class="top-btns loginbtn">
					    		<i class="fas fa-sign-in-alt pr-2"></i>
					    	Log In</a>
					     </div>
					    	
					    	@else
					    	 <!-- <a class="top-btns blue-btn" href="{{ route('logout') }}"
                           onclick="event.preventDefault();
                                   document.getElementById('logout-form').submit();">Logout</a>

                        <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                            @csrf
                        </form> -->
						<a href="{{ route('home') }}" class="top-btns loginbtn">
					    		<i class="fas fa-sign-in-alt pr-2"></i>
					    	Dashboard</a>
					    @endguest
					    
					    
					   

              

					    
					    
					    
					    <!-- <form class="form-inline my-2 my-lg-0">
					      <input class="form-control mr-sm-2" type="search" placeholder="Search">
					      <button class="btn btn-outline-success my-2 my-sm-0" type="submit">Search</button>
					    </form> -->
					  </div>
				  	</div>
				</nav>
			
			</div>
		</div>