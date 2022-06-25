@extends('layout.frontend.home1.mainlayout')
@section('content')		

<div class="container-fluid">
	<div class="hero-section">
	
		<div class="row">
			<div class="col-12 col-md-12 main-hero" >
				<div class="heroo-sect " >
					<div class="row d-flex align-items-center">
						<div class="col-12 col-md-12 col-lg-12 mb3 ">
							<div class="hero-left-content">
								<h2 class="hero-heading d-none d-md-block text-center">
									Spending controls, unique <br>cards for spending needs
								</h2>
								<h2 class="hero-heading d-block d-md-none">Spending controls, unique cards for spending needst</h2>
								<p class="hero-p">We buiilt Banking so you don’t have to. Get start with modern banking, instantly!</p>
								<div class="button-divs text-center">
									<div>
										<a href="" class="explore-btn">
											Get Started
										</a>
									</div>

									<div class="">
										<a href=""><img src="{{ asset('assets/home1/images/play.png')}} " class="img-fluid pr-2">  Demo Video</a>
									</div>

							
									
								</div>
								<div class="mt-5">
									<img src="{{ asset('assets/home1/images/main-image.png')}}" class="img-fluid d-block d-md-none" >
								</div>


							</div>
						</div>
						<!-- left end -->

					</div>
					<!-- inside row end -->
					<!-- row end -->

					
				</div>
			</div>
			<!-- col end -->
		</div>
		<!-- main-hero end -->
	</div>
	<!-- hero section end -->

	<div class="row d-none d-md-block">
		<div class="col-12 main-image-section">
			<div class="container">
				<img src="{{ asset('assets/home1/images/main-image.png')}}" class="img-fluid min-imge">
			</div>
			<!-- contaienr end -->
		</div>
		<!-- main-image-section  -->
	</div>
	<!-- row end -->


	<div class="row">
		<div class="col-12 col-md-12 paybeapp-section py110">
			<div class="container">
				<div class="row d-flex align-items-center">
					<div class="col-12 col-md-6 mb3 paybe-left ">
						<img src="{{ asset('assets/home1/images/small-line.png')}}" class="lin">
						<span class="payp">Already on PlayStore and AppStore</span>
						<h2 class="hero-heading mt-5 d-none d-lg-block">
							<span class="colorchange">Paybee</span> app is <br>
							simple and <br>
							created for you!
						</h2>
						<h2 class="hero-heading mt-5 d-block d-lg-none text-center text-md-left">
							<span class="colorchange">Paybee</span> app is 
							simple and 
							created for you!
						</h2>
						<p class="gen-p py-50 d-none d-lg-block">
							Are you looking to join online institutions? Now it's <br> very simple, Sign up with mentoring. Are you looking <br> to join online institutions?
						</p>
						<p class="gen-p py-50 d-block d-lg-none text-center text-md-left">
							Are you looking to join online institutions? Now it's  very simple, Sign up with mentoring. Are you looking  to join online institutions?
						</p>
						<img src="{{ asset('assets/home1/images/onlyimage.png')}}" class="img-fluid d-block d-md-none m-auto">
						<div class="button-divs text-left ml-0">
							<div class="pl-0 text-left">
								<a href="" class="explore-btn bluebg bradius">Get the app
								</a>
							</div>
							<div class="paybelink">
								<a href=""><img src="{{ asset('assets/home1/images/play.png')}} " class="img-fluid pr-2">  Demo Video</a>
							</div>
						</div>
						<!-- button divs end -->
						<div class="apps-icons text-center text-md-left">
							<div class="text-left">
								<a href="">
									<img src="{{ asset('assets/home1/images/app-store.png')}}" class="img-fluid">
								</a>
							</div>
							<div class="paybelink">
								<a href=""><img src="{{ asset('assets/home1/images/play-store.png')}} " class="img-fluid"></a>
							</div>
						</div>
						<!-- button divs end -->
					</div>
					<!-- paybe left end -->
					<div class="col-12 col-md-6 paybe-right order-1 order-md-2 d-none d-md-block ">
						<img src="{{ asset('assets/home1/images/paybe-right.png')}}" class="img-fluid">
					</div>
					<!-- paybe right end -->
				</div>
				<!-- row end -->
			</div>
			<!-- container end -->
		</div>
		<!-- paybeapp-section end -->
	</div>
	<!-- row end -->


	<div class="row">
		<div class="col-12 col-md-12 paybeapp-section py-5">
			<div class="container">
				<div class="row ">
					<div class="col-12 col-md-6 paybe-right">
						<img src="{{ asset('assets/home1/images/accept-payment.png')}}" class="img-fluid">
					</div>

					<div class="col-12 col-md-6 mb3 paybe-left pl-lg-5 ">
						<h2 class="hero-heading  d-none d-lg-block">
						Accept card
						payment  in your 
						<span class="colorchange">
						Online </span> Store
						</h2>
					
					<ul class="acceptcard mt-82">
						<li>
							<b class="li-b">Global Payment</b>
							<p class="gen-p">
								Accept major currencies and the main credit and debit from customers all around the world....
							</p>
						</li>
							<li>
							<b class="li-b">One-click Purchase</b>
							<p class="gen-p">
								Accept major currencies and the main credit and debit from customers all around the world....
							</p>
						</li>
						<li>
							<b class="li-b">Frienly Price</b>
							<p class="gen-p">
								Accept major currencies and the main credit and debit from customers all around the world....
							</p>
						</li>
					</ul>

					</div>
					<!-- paybe left end -->
					
					<!-- paybe right end -->
				</div>
				<!-- row end -->
			</div>
			<!-- container end -->
		</div>
		<!-- paybeapp-section end -->
	</div>
	<!-- row end -->

	<div class="row">
		<div class="col-12 col-md-12 py-50">
			<div class="container">
				<div class="logos-slider">
				               @foreach($partners as $partner)
                                <img src="{{asset('storage')}}/partner/{{ $partner->logo }}" class="img-fluid" alt="slack">
                                @endforeach
							</div>
								<!-- logos slider end -->
			</div>				
		</div>
	</div>
	<!-- logos row end -->

	<div class="row">
		<div class="col-12 col-md-12 testimonal-section py-50">
			<div class="container">
				<h2 class="hero-heading text-center">What they say</h2>
				<p class="gen-p text-center">Lorem ipsum dolor sit amet, consectetur adipiscing elit,  sed do eiusmod tempor <br> incididunt ut labore et dolore magna aliqua.</p>

				<div id="testimonial-slisder" class="owl-carousel">
          <div class="testimonial">
            <div class="pic">
              <img src="{{ asset('assets/home1/images/pic1.png')}}" alt="">
            </div>
            <p class="description">
              Lorem ipsum dolor sit amet, consectetur adipiscing elit. Curabitur tempor finibus risus. Vivamus quis aliquet nibh. Nunc vitae felis nunc. Nam scelerisque maximus tempor. Proin sed euismod tellus. Nunc sodales, quam et porttitor accumsan, lectus dolor laoreet dolor, a scelerisque.
             </p>
             <h3 class="testimonial-title">
             Will Smith</h3>
          </div>
 					<!-- 1 end -->
        	
        	<div class="testimonial">
            <div class="pic">
              <img src="{{ asset('assets/home1/images/pic1.png')}}" alt="">
            </div>
            <p class="description">
              Lorem ipsum dolor sit amet, consectetur adipiscing elit. Curabitur tempor finibus risus. Vivamus quis aliquet nibh. Nunc vitae felis nunc. Nam scelerisque maximus tempor. Proin sed euismod tellus. Nunc sodales, quam et porttitor accumsan, lectus dolor laoreet dolor, a scelerisque.
             </p>
             <h3 class="testimonial-title">
             Will Smith</h3>
          </div>
 					<!-- 2 end -->

 					<div class="testimonial">
            <div class="pic">
              <img src="{{ asset('assets/home1/images/pic1.png')}}" alt="">
            </div>
            <p class="description">
              Lorem ipsum dolor sit amet, consectetur adipiscing elit. Curabitur tempor finibus risus. Vivamus quis aliquet nibh. Nunc vitae felis nunc. Nam scelerisque maximus tempor. Proin sed euismod tellus. Nunc sodales, quam et porttitor accumsan, lectus dolor laoreet dolor, a scelerisque.
             </p>
             <h3 class="testimonial-title">
             Will Smith</h3>
          </div>
 					<!-- 3 end -->

        </div>

			</div>
		</div>
	</div>
	<!-- row end -->

	<div class="row">
		<div class="col-12 newsletter-section">
			<div class="container">
				<div class="row">
					<div class="col-12 col-lg-5 mb3 text-center text-lg-left  p-0">
						<h2 class="subscribe-text">Subscrive <span class="orange-text">Our Newsletter</span> To <br>
							Receive the Latest News
						</h2>
					</div>
					<!-- left side end -->
					<div class="col-12 col-lg-7 forformm p-0">
					<form method="POST" id="newsletter-subscribe" action="{{url('subscribe')}}" enctype="multipart/form-data">
                              @csrf
                            <label class="sr-only" for="inlineFormInputGroup">Username</label>
                            <div class="input-group mb-2">
                                <div class="input-group-prepend">
                                    <div class="input-group-text thisinpugrou">
                                        <i class="fa fa-envelope pr-2 pr-md-4"></i> |
                                    </div>
                                    
                                </div>
                                <input type="email" name="email" class="form-control" id="inlineFormInputGroup" required="" placeholder="Enter Your Email Address......">
                                
                                <div class="input-group-prepend text-center">
                                   
                                    <div  class="input-group-text subscribtnn text-center" onclick="onClick(event);"
                                                  >
                                        <i class="fas fa-paper-plane pr-2"> </i>
                                        <span>Subscribe</span>
                                    </div>
                                </div>
                               
                              
                    </div>
                              <h5 class="text-danger text-center" id="email_input_error"></h5>
                        </form>
					</div>
				</div>
			</div>
		</div>
	</div>

</div>
		<!-- newsletter end -->
</div>
<!-- contianer fluid end -->
@endsection
