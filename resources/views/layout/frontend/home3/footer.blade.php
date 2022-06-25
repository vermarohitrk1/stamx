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
			<div class="container">
				<div class="row m-0"> 
					
				<div class="col-12 col-md-6 col-lg-3 mb3 footer-logo-side">
				@if (!empty($logo_favicon['logo']))
                                    <img src="{{ asset('storage/logo').'/'.$logo_favicon['logo'] }}" >
                                @else
                                   <img src="{{ asset('assets/main/images/logo.png')}}">
                                @endif

					<!-- <div class="social-icons">
						<p class="gen-p mb-0">Follow Us</p>
						<ul>
							<li><a href=""><img src="{{ asset('assets/home3/images/fb.png')}}" class="img-fluid"></a></li>
							<li><a href=""><img src="{{ asset('assets/home3/images/instagram.png')}}" class="img-fluid"></a></li>
							<li><a href=""><img src="{{ asset('assets/home3/images/linkedin.png')}}" class="img-fluid"></a></li>
							<li><a href=""><img src="{{ asset('assets/home3/images/twitter.png')}}" class="img-fluid"></a></li>
						</ul>
					</div> -->


					<div class="row">
						<div class="col-12 col-md-6 d-none d-md-block d-lg-none footer-links">
									<span class="footer-main-heading"> Resources</span>
										<ul>
											<li><a href="">plans</a></li>
											<li><a href="">Press</a></li>
											<li><a href="">About us</a></li>
											<li><a href="">Contact us</a></li>
										</ul>
								</div>
					</div>
				</div>
				<!-- logo side  -->
				<div class="col-12 col-md-6 col-lg-9 mb-3">
					<div class="row">
						<div class="col-12 col-md-12 col-lg-7">
							<div class="row">
								<div class="col-12 col-md-6 footer-links">
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
							</div>
								<!-- row end -->

							</div>
							<!-- lg 4 end one end -->
						<!-- left end -->
						<div class="col-12 col-md-12 col-lg-5 footer-links">
						
						<h4 class="sub-footer-main-heading">Ready to Talk?</h4>
						<ul class="pl-0 fotmargin fotlinks">
							 <li><a href="tel:+1 315 369 5943">+1 888.USA.STEM</a></li>

							 <li><a href="mailto:mentoring@example">equity@stemx.com</a></li>
							 <li class="mt-2">
							 	<p class="gen-p">6735 Salt Cedar Way, <br>Frisco, TX 75034</p>
							 </li>
						</ul>
						</p>
						
							<!-- inside row end -->
						</div>
						<!-- right side end -->

					</div>
					<!-- row end -->
				</div>
				<!-- rest of side  -->


			
			</div>
			</div>
			<!-- inside row end -->

			<hr class="thishr">
			<div class="container">
				<div class="row last-footer"> 
					<div class="col-12 col-md-3 social-icons text-center text-md-left">
						<ul>
							<li><a href=""><img src="{{ asset('assets/home3/images/fb.png')}}" class="img-fluid"></a></li>
							<li><a href=""><img src="{{ asset('assets/home3/images/instagram.png')}}" class="img-fluid"></a></li>
							<li><a href=""><img src="{{ asset('assets/home3/images/linkedin.png')}}" class="img-fluid"></a></li>
							<li><a href=""><img src="{{ asset('assets/home3/images/twitter.png')}}" class="img-fluid"></a></li>
						</ul>
					
					</div>
					<!-- social icons end -->
					<div class="col-12 col-md-4 text-center text-md-left">
						<ul>             
							
						</ul>
					</div>

					<div class="col-12 col-md-5 right-footer text-center text-md-right">
			<p class="copyrightp">	{{$footer_text}}</p>
		</div>


				</div>
				<!-- row end -->
			</div>
			<!-- container end -->
		</div>
		<!-- footer col end -->

	</div>



