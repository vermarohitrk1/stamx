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

<div class="row ">
		<div class="col-12 col-md-12 fixed-top thisnav">
			<div class="desktop-menu fornomargin d-none d-lg-block container ">
				<div class="row formargintop" id="formargintop">
				<div class="col-12 col-md-1 col-lg-1 logo-side pl-0">
					
						<a  href="{{ url('')}}">
					  @if (!empty($logo_favicon['logo']))
                        <img src="{{ asset('storage/logo').'/'.$logo_favicon['logo'] }}"alt="LogoImage" class="img-fluid mainlogo">
                    @else
               	<span class="logo-text">@if(!empty($logoTxt)) {{ $logoTxt }} @else Your Logo Here @endif</span>
			@endif
			</a>
				</div>
				<!-- left menu  -->
				<div class="col-12 col-md-7 col-lg-7 d-actual-menu">
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
				<div class="col-12 col-md-4 col-lg-4 text-right desktiop-right-side">
					<ul>
					
					
					 @guest
					    
					 @if ($donation = \App\PublicPageDetail::where('user_id',get_domain_user()->id)->first())
							 	@php $dId = base64_encode($donation->id);
								 $user_setting = DB::table('website_setting')->where('user_domain_id', get_domain_id())->where('name', 'payment_settings')->first();
        						@endphp
									@if($user_setting != null)
									<a href='{{ url("$dId/donation")}}' class="top-btns blue-btn">Donate</a>
								  	@endif
					           @endif
					             <li><a   class="registr-btn" href="{{ route('login') }}">log In</a></li>
					        
					   
					    	
					    	@else
					    <li><a href="{{ route('home') }}" class="registr-btn">Dashboard</a></li>
					
					    	
					    @endguest
					
					</ul>
				</div>
			</div>
			<!-- inside row end -->
			</div>
		</div>
		<!-- desktop menu end -->

		<div class="col-12 mt-0 col-md-12 mobile-menu d-block d-lg-none">
			<!-- Navigation -->
				<nav class="navbar fornavbar navbar-expand-lg fixed-top thisnav mt-0" style="">
				  <div class="container">
				  <a  class="navbar-brand" href="{{ url('')}}">
					  @if (!empty($logo_favicon['logo']))
                        <img src="{{ asset('storage/logo').'/'.$logo_favicon['logo'] }}"alt="LogoImage" class="img-fluid mainlogo">
                    @else
               	<span class="logo-text">@if(!empty($logoTxt)) {{ $logoTxt }} @else Your Logo Here @endif</span>
			@endif
			</a>
				   
				    <button class="navbar-toggler p-0 m-0 mt-1" type="button" data-toggle="collapse" data-target="#navbarResponsive" aria-controls="navbarResponsive" aria-expanded="false" aria-label="Toggle navigation">
				        <i class="fa fa-bars"></i>
				  			<i class="fa fa-times"></i>
				    </button>
				    <div class="collapse navbar-collapse linksstyle text-left text-lg-right pb-5" id="navbarResponsive">
				      <ul class="navbar-nav ml-auto text-left text-lg-right mt-3">
					  
					  
					  
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
					         
					          @if ($donation = \App\PublicPageDetail::where('user_id',get_domain_id())->first())
							 @php $dId = base64_encode($donation->id); @endphp
						 	  <li class="nav-item"><a   class="nav-link"href="{{ url("$dId/donation")}}" class="notonlg">Donate </a></li>
					           @endif
					            <li><a   class="registr-btn" href="{{ route('login') }}">log In</a></li>
					        
					   
					    	
					    	@else
					    <li><a href="{{ route('home') }}" class="registr-btn">Dashboard</a></li>
					
					    	
					    @endguest
				       
				      </ul>
				    </div>
				  </div>
				</nav>
		</div>
		<!-- mobile menu end -->
	</div>	
	<!-- row end -->






	