@extends('layout.frontend.home4.mainlayout')
@section('content')	
<style>
.d-actual-menu ul li {
    line-height: 60px;
    list-style: none;
    display: inline-block;
    margin: 0px 0px 0px 0px;
}
.col-12.col-md-4.text-right.desktiop-right-side ul li a {
    text-decoration: none;
    color: #a4a3af;
}
</style>
<div class="container">



	<div class="row">
		<div class="col-12 col-md-12  hero-section">
			<div class="row d-flex align-items-center">
				<div class="col-12 col-md-6 col-lg-6 hero-left mb3 text-center text-md-left">
					<span class="hero-small-text">Lorem Ipsum is simply dummy text <br> and typesetting</span>
					<h2 class="hero-main-heading">Manage currency & money</h2>

					<a href="" class="scan-card">
						<img src="{{ asset('assets/home4/images/scane.png')}}" class="img-fluid scanimg">
						Scan Card
					</a>
				</div>
				<!-- hero-left end -->
				<div class="col-12 col-md-6 hero-right mb-3">
					<img src="{{ asset('assets/home4/images/hero-card.png')}}" class="img-fluid" alt="Card">
				</div>
			</div>
		</div>
	</div>
	<!-- row end -->


	<div class="row"> 
		<div class="col-12 third-section">
			<div class="row">
				<div class="col-12 col-md-4 col-lg-5 mb3 third-left border-rightt">
					<h2 class="main-heading ">100% totally <br>	 secured credit <br>card</h2>
				</div>
				<!-- third-left end -->
				<div class="col-12 col-md-8 col-lg-7 mb3 third-right">
					<div class="row">
						<div class="col-12 col-md-6">
							<div class="row">
								<div class="col-3 col-md-4 ">
									<span class="gray-shades">
										<img src="{{ asset('assets/home4/images/Wallet.png')}}" class="img-fluid small-icon">
									</span>
								</div>
								<!-- icon  -->
								<div class="col-9 col-md-8 pt-lg-3">
									<span class="shad-text">Lorem Imsum</span>
								</div>
								<!-- text end -->
							</div>
							<!-- inside inside row  -->
							<div class="row">
								<div class="col-12">
									<p class="gen-p mt-18">
									We are creating social media 3.0 with influencers, celebrities and.
								</p>
								</div>
							</div>
							<!-- row end -->
						</div>
						<!-- wallet end -->

						<div class="col-12 col-md-6">
							<div class="row">
								<div class="col-3 col-md-4 ">
									<span class="gray-shades">
										<img src="{{ asset('assets/home4/images/Graph.png')}}" class="img-fluid small-icon">
									</span>
								</div>
								<!-- icon  -->
								<div class="col-9 col-md-8 pt-lg-3">
									<span class="shad-text">Lorem Imsum</span>
								</div>
								<!-- text end -->
							</div>
							<!-- inside inside row  -->
							<div class="row">
								<div class="col-12">
									<p class="gen-p mt-18">
									We are creating social media 3.0 with influencers, celebrities and.
								</p>
								</div>
							</div>
							<!-- row end -->
						</div>
						<!-- wallet end -->
					</div>
					<!-- inside end -->
					<div>
						<p class="gen-p mt-18">
							We are creating social media <span class="speen-text">3 milion</span> with influencers, celebrities being able to launch
 						their own digital currency by simply <span class="speen-text">creating 100%</span>
						</p>
					</div>
				</div>
				<!-- third-left end -->
			</div>
			<!-- inside row end -->
		</div>
		<!-- 3rd section end -->
	</div>
	<!-- 3rd section row end -->

	<div class="row">
		<div class="col-12 subscription-section">
		<form method="POST" id="newsletter-subscribe" action="{{url('subscribe')}}" enctype="multipart/form-data">
				<div class="row">
					    @csrf
					<div class="col-12 col-md-8 col-lg-9 ">
						<input type="text" placeholder="Enter Email" required="" name="email">
					</div>
					<div class="col-12 col-md-4 col-lg-3 ">
						<input class="subscribtnn" type="submit" value="subscribe Now" onclick="onClick(event);" >
					</div>
				</div>
				 <h5 class="text-danger text-center" id="email_input_error"></h5>
			</form>
		</div>
		<!-- subscription-section end -->
	</div>
	<!-- subscription-section row end -->

	<div class="row">
		<div class="col-12 col-md-12 flexible-section">
			<div class="row d-flex align-items-center">
				<div class="col-12 col-md-6 mb3">
					<img src="{{ asset('assets/home4/images/flexible-card.png')}}" class="img-fluid">
				</div>
				<div class="col-12 col-md-6 mb3">
					<h2 class="main-heading">
						We are fexible <br>your pricing lebel
					</h2>
					<p class="gen-p">
						We are creating social media 3.0 with influencers, celebrities and creators being able to launch
 						their own digital currency by simply creating a profile with media content posted as.
					</p>

					<div class="mt-5">
						
						<div class="row">
						<div class="col-12 col-md-12">
							<div class="row ">
								<div class="col-2 col-md-2 ">
									<span class="gray-shades nbring">
										01
									</span>
								</div>
								<!-- icon  -->
								<div class="col-10 col-md-10 pt-1">
									<p class="gen-p">We are creating social media 3.0 with influencers, celebrities and creators being able to launch.</p>
								</div>
								<!-- text end -->
							</div>
							<!-- row 1 end -->

							<div class="row mt-3">
								<div class="col-2 col-md-2 ">
									<span class="gray-shades nbring">
										02
									</span>
								</div>
								<!-- icon  -->
								<div class="col-10 col-md-10 pt-1">
									<p class="gen-p">We are creating social media 3.0 with influencers, celebrities and creators being able to launch.</p>
								</div>
								<!-- text end -->
							</div>
							<!-- row 2 end -->


						</div>
						<!-- wallet end -->

					</div>


				</div>
				<!-- right side end -->
			</div>
		</div>
		<!-- flexible section end -->
	</div>
	<!-- col end -->
</div>
<!-- row end -->

	<div class="row p-0 m-0">
		<div class="col-12 crafted-section">
			<div class="row d-flex align-items-center">
				<div class="col-12 col-md-4 col-lg-4 crafted-left mb3">
					<h2 class="main-heading">Crafted for <br> the users and easy to use</h2>
					<p class="gen-p">We are creating social media 3.0 with influencers, celebrities and creators being able to launch
 					their own .</p>

 					<a href="" class="scan-card">
						
						Scan Card
					</a>
				</div>
				<!-- crafted left end -->

				<div class="col-12 col-md-4 col-lg-5 mb3">
					<img src="{{ asset('assets/home4/images/crafted-card.png')}}" class="img-fluid">
				</div>
				<!-- center end -->
				<div class="col-12 col-md-4 col-lg-3 crafted-right">
					<div class="easy mb33">
						<img src="{{ asset('assets/home4/images/easy.png')}}" class="img-fluid crafted-icon">
						<span class="shad-text">Easy</span>
						<p class="gen-p mt-18">We are creating social <br> media 3.0 with end.</p>
					</div>
					<!-- easy end -->

					<div class="easy mb33">
						<img src="{{ asset('assets/home4/images/secure.png')}}" class="img-fluid crafted-icon">
						<span class="shad-text">Secure</span>
						<p class="gen-p mt-18">We are creating social  <br>media 3.0 with end.</p>
					</div>
					<!-- easy end -->

					<div class="easy mb33">
						<img src="{{ asset('assets/home4/images/elastic.png')}}" class="img-fluid crafted-icon">
						<span class="shad-text">Best way</span>
						<p class="gen-p mt-18">We are creating social  <br>media 3.0 with end.</p>
					</div>
					<!-- easy end -->


				</div>
				<!-- crafted right end -->
			</div>
			<!-- inside row end -->
		</div>
		<!-- crafted-section end -->
	</div>
	<!-- row end -->


	<div class="row m-0 p-0">
		<div class="col-12 col-md-12 table-section ">
			<!-- <table class="table table-responsive">
				<tr>
					<th>#</th>
					<th>Card name</th>
					<th>Annual Fee</th>
					<th>Regular APR</th>
					<th>Intro A{R</th>
					<th>E-money rating</th>
				</tr>
			</table> -->

			<table class="table table-responsive-md table-borderless text-center">
  <thead>
    <tr class="firstrow">
      <th scope="col" class="align-middle">#</th>
      <th scope="col" colspan="2" >Card name</th>
      <th scope="col">Annual Fee</th>
      <th scope="col">Regular APR</th>
      <th scope="col">Intro</th>
      <th scope="col">E-money rating</th>
    </tr>
  </thead>
  <tbody>
    <tr>
      <th scope="row " class="align-middle">1</th>
      <td class="align-middle">
      <img src="{{ asset('assets/home4/images/table-card1.png')}}" class="img-fluid cdrotte">
      </td>
      <td class="align-middle">BanAsia Shopping Card</td>
      <td class="align-middle">$0</td>
      <td class="align-middle">14.74-24.74 <br>variable ARP</td>
      <td class="align-middle">We are creating social <br> media <span class="speen-text">3 milion</span> with <br>influencers, celebrities</td>
    	<td class="align-middle">
    		4.8/5
    		<img src="{{ asset('assets/home4/images/stars.png')}}" class="img-fluid fortableimg">
    		<a href="" class="read-review-link">Read review</a>
    	</td>
    </tr>

    <tr>
      <th scope="row " class="align-middle">2</th>
      <td class="align-middle">
      	<img src="{{ asset('assets/home4/images/table-card2.png')}}" class="img-fluid cdrotte">
      </td>
      <td class="align-middle">BanAsia Shopping Card</td>
      <td class="align-middle">$0</td>
      <td class="align-middle">14.74-24.74 <br>variable ARP</td>
      <td class="align-middle">We are creating social <br> media <span class="speen-text">3 milion</span> with <br>influencers, celebrities</td>
    	
    	<td class="align-middle">
    		4.8/5
    		<img src="{{ asset('assets/home4/images/stars.png')}}" class="img-fluid fortableimg">
    		<a href="" class="read-review-link">Read review</a>
    	</td>

    </tr>

      <tr>
      <th scope="row " class="align-middle">3</th>
      <td class="align-middle">
      <img src="{{ asset('assets/home4/images/table-card2.png')}}" class="img-fluid cdrotte">
      </td>
      <td class="align-middle">BanAsia Shopping Card</td>
      <td class="align-middle">$0</td>
      <td class="align-middle">14.74-24.74 <br>variable ARP</td>
      <td class="align-middle">We are creating social <br> media <span class="speen-text">3 milion</span> with <br>influencers, celebrities</td>
    	
    	<td class="align-middle">
    		4.8/5
    		<img src="{{ asset('assets/home4/images/stars.png')}}" class="img-fluid fortableimg">
    		<a href="" class="read-review-link">Read review</a>
    	</td>

    </tr>
      <tr class="mt-18">
      <th scope="row " class="align-middle">4</th>
      <td class="align-middle">
      	<img src="{{ asset('assets/home4/images/table-card1.png')}}" class="img-fluid cdrotte">
      </td>
      <td class="align-middle">BanAsia Shopping Card</td>
      <td class="align-middle">$0</td>
      <td class="align-middle">14.74-24.74 <br>variable ARP</td>
      <td class="align-middle">We are creating social <br> media <span class="speen-text">3 milion</span> with <br>influencers, celebrities</td>
    	
    	<td class="align-middle">
    		4.8/5
    		<img src="{{ asset('assets/home4/images/stars.png')}}" class="img-fluid fortableimg">
    		<a href="" class="read-review-link">Read review</a>
    	</td>

    </tr>
   
  </tbody>
</table>
		</div>
		<!-- table-section end -->
	</div>
	<!-- row end -->


	<div class="row">
		<div class="col-12 col-md-12 mobileapp-section">
			<div class="row d-flex align-items-center">
				<div class="col-12 col-md-6 mb3 mobile-app-left">
					<h2 class="main-heading">Mobile App</h2>
					<p class="gen-p mt-18">
						“I have more than 10 yrs experience had a great overall experience.
						i love to teach my best”W
					</p>
					<ul class="pl-0 mt-21 store-icon">
						<li><a href=""><img src="{{ asset('assets/home4/images/google-play.png')}}" class="img-fluid" alt="Google Play Store icon"></a></li>
						<li class="ml-2"><a href=""><img src="{{ asset('assets/home4/images/app-store.png')}}" class="img-fluid" alt="Google Play Store icon"></a></li>
					</ul>
				</div>
				<!-- mobile ap  left end -->
				<div class="col-12 col-md-6 mb3 mobile-app-right">
					<img src="{{ asset('assets/home4/images/mobile-app.png')}}" class="img-fluid mobile-app-image">
				</div>
				<!-- mobile ap  left end -->

			</div>
			<!-- row end -->
		</div>
	</div>
	<!-- row end -->

	
	<!-- last row end -->


<!-- main-container end -->



@endsection


