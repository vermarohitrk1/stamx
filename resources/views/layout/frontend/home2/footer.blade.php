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



<div class="row ">
		<div class="col-12 sub-footer py120">
			<div class="container">
				<div class="row ">
					<div class="col-12 col-md-6 col-lg-3 left-subfooter-1 p-0 mb3">
					@if (!empty($logo_favicon['logo']))
                                    <img src="{{ asset('storage/logo').'/'.$logo_favicon['logo'] }}" >
                                @else
                                   <img src="{{ asset('assets/main/images/logo.png')}}">
                                @endif
						<p class="gen-p fotmargin2">
							A secure platform for impact, <br>digital equity and transformation, <br>ready to scale at the speed of thought. 
						</p>

						<div class="social-icons mt-5">
						<ul>
							<li><a href=""><img src="{{ asset('assets/home1/images/fb.png')}}" class="img-fluid"></a></li>
							<li><a href=""><img src="{{ asset('assets/home1/images/insta.png')}}" class="img-fluid"></a></li>
							<li><a href=""><img src="{{ asset('assets/home1/images/linkedin.png')}}" class="img-fluid"></a></li>
							<li><a href=""><img src="{{ asset('assets/home1/images/twitter.png')}}" class="img-fluid"></a></li>
						</ul>
					</div>
					<!-- social icons end/ -->

					</div>
					<!-- first one -->
					<div class="col-12 col-md-6 col-lg-3 left-subfooter-1 p-0 mb3">
						<h4 class="sub-footer-main-heading">Workforce</h4>
						<ul class="pl-0 fotmargin fotlinks">
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
						</p>
					</div>
					<!-- second one end -->

					<div class="col-12 col-md-6 col-lg-3 left-subfooter-1 p-0 mb3">
						<h4 class="sub-footer-main-heading">Engage</h4>
						<ul class="pl-0 fotmargin fotlinks">
						
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
						</p>
					</div>
					<!-- thid one end -->

					
					
					
					<div class="col-12 col-md-6 col-lg-3 left-subfooter-1 p-0 mb3">
						<h4 class="sub-footer-main-heading">Ready to Talk?</h4>
						<ul class="pl-0 fotmargin fotlinks">
							 <li><a href="tel:+1 315 369 5943">+1 888.USA.STEM</a></li>

							 <li><a href="mailto:mentoring@example">equity@stemx.com</a></li>
							 <li class="mt-2">
							 	<p class="gen-p">6735 Salt Cedar Way, <br>Frisco, TX 75034</p>
							 </li>
						</ul>
						</p>
					</div>
					<!-- fourth one end -->

				</div>
				<!-- row end -->
			</div>
		</div>
		<!-- sub footer end -->
	</div>
	<!-- sub footer col end -->

	<footer>
	{{$footer_text}}
	</footer>
	
	

	