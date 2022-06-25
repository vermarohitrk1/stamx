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

<div class="row">
		<div class="col-12 footer">
			<div class="row">

				<div class="col-12 col-md-6 col-lg-3 mb3 footer-logo-side">
				
	@if (!empty($logo_favicon['logo']))
                                    <img src="{{ asset('storage/logo').'/'.$logo_favicon['logo'] }}" class="img-fluid">
                                @else
                                   <img src="{{ asset('assets/main/images/logo.png')}}" class="img-fluid">
                                @endif
					<div class="social-icons">
						<p class="gen-p mb-0">Follow Us</p>
						<ul>
							<li><a href=""><img src="{{ asset('assets/home4/images/fb.png')}}" class="img-fluid"></a></li>
							<li><a href=""><img src="{{ asset('assets/home4/images/instagram.png')}}" class="img-fluid"></a></li>
							<li><a href=""><img src="{{ asset('assets/home4/images/linkedin.png')}}" class="img-fluid"></a></li>
							<li><a href=""><img src="{{ asset('assets/home4/images/twitter.png')}}" class="img-fluid"></a></li>
						</ul>
					</div>


					<div class="row">
						<div class="col-12 col-md-6 d-none d-md-block d-lg-none footer-links">
									<span class="footer-main-heading"> Workforce</span>
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
				</div>
				<!-- logo side  -->
				<div class="col-12 col-md-6 col-lg-9 mb-3">
					<div class="row">
						<div class="col-12 col-md-12 col-lg-5">
							<div class="row">
								<div class="col-12 col-md-6 footer-links">
									<span class="footer-main-heading"> Engage</span>
										<ul>
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
								<div class="col-12 col-md-6 footer-links">
									<span class="footer-main-heading"> Company</span>
										<ul>
											<li><a href="">plans</a></li>
											<li><a href="">Press</a></li>
											<li><a href="">About us</a></li>
											<li><a href="">Contact us</a></li>
										</ul>
								</div>
							</div>
								<!-- row end -->

							</div>
							<!-- lg 4 end one end -->
						<!-- left end -->
						<div class="col-12 col-md-12 col-lg-7 footer-links">
							<div class="row">
								<div class="col-12 col-md-6 col-lg-4 footer-links d-block d-md-none d-lg-block">
									<span class="footer-main-heading"> Resources</span>
										<ul>
											<li><a href="">plans</a></li>
											<li><a href="">Press</a></li>
											<li><a href="">About us</a></li>
											<li><a href="">Contact us</a></li>
										</ul>
								</div>
								<!-- 1en -->
								<div class="col-12 col-md-6 col-lg-4 footer-links">
									<span class="footer-main-heading"> Use Cases</span>
										<ul>
											<li><a href="">plans</a></li>
											<li><a href="">Press</a></li>
											<li><a href="">About us</a></li>
											<li><a href="">Contact us</a></li>
										</ul>
								</div>
								<!-- 1en -->
								<div class="col-12 col-md-6 col-lg-4 footer-links">
									<span class="footer-main-heading"> Compare</span>
										<ul>
											<li><a href="">plans</a></li>
											<li><a href="">Press</a></li>
											<li><a href="">About us</a></li>
											<li><a href="">Contact us</a></li>
										</ul>
								</div>
								<!-- 1en -->
							</div>
							<!-- inside row end -->
						</div>
						<!-- right side end -->

					</div>
					<!-- row end -->
				</div>
				<!-- rest of side  -->


			

			</div>
			<!-- inside row end -->
		</div>
	</div>
	<!-- row end -->

	<hr class="lastline">

	<div class="row m-0">
		<div class="col-12 last-footer">
			<div class="row">
				<div class="col-12 col-md-6  text-center text-md-left">
			<ul>             
			
			</ul>
		</div>
		<div class="col-12 col-md-6 right-footer text-center text-md-right">
			<p class="copyrightp">	{{$footer_text}}</p>
		</div>
			</div>
		</div>
	</div>
	
	
	

	
	

	