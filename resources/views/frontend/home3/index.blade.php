@extends('layout.frontend.home3.mainlayout')
@section('content')		
<style>
.d-actual-menu ul li {
    margin: 0px 0px 0px 0px !important;
}
</style>
<div class="container">
	

	<div class="row">
		<div class="col-12 col-md-12 hero-section">
			<h1 class="hero-heading">Meet smarter.</h1>
			<p class="hero-p">Free video meetings with built-in team messaging.
			</p>

			<div class="row mt-4">
				<div class="col-6 col-md-6">
					<a href="" class="getstated-btn">Get started, it’s free</a>
				</div>
				<div class="col-6 col-md-6 d-flex align-items-center">
					<a href="" class="watch-video-link">
						<img src="{{ asset('assets/home3/images/play-icon.png')}}" class="img-fluid">
						<span>Watch Video</span>
					</a>
				</div>
				<!-- right btn -->
			</div>
			<!-- hero btn row end -->
		</div>
		<!-- hero-col end -->
	</div>
	<!-- hero row end -->

	<div class="hero-big-image"> 
		<img src="{{ asset('assets/home3/images/hero-pic.png')}}" class="img-fluid">
	</div>
	<!-- hero big image end -->

	<div class="row">
		<div class="col-12 third-section">
			<div class="row">
				<div class="col-12 col-md-5 col-lg-4 img-side ">
					<div class="d-block d-md-none text-center">
						<h2 class="main-heading">
						Lorem Ipsum is simply dummy text of the all printing indo.
					</h2>
					<p class="gen-p">
						Lorem Ipsum is simply dummy text of the printing  and typesetting industry. Lorem Ipsum has been.
					</p>
					</div>
					<img src="{{ asset('assets/home3/images/mobile-one.png')}}" class="img-fluid">
				</div>
				<!-- img side end -->

				<div class="col-md-7 col-lg-8 text-side-right">
					<div class="d-none d-md-block">
						<h2 class="main-heading">
						Lorem Ipsum is simply dummy text of the all printing indo.
					</h2>
					<p class="gen-p">
						Lorem Ipsum is simply dummy text of the printing  and typesetting industry. Lorem Ipsum has been.
					</p>
					</div>

					<div class="row mt-60">
						<div class="col-12 col-md-6">
							<div class="card-type mb34">
								<img src="{{ asset('assets/home3/images/infinite-1.png')}}" class="img-fluid">
								<span class="cd-heading">Lorem Ipsum is simply</span>
								<p class="gen-p mt-14">
									Lorem Ipsum is simply dummy text of the printing and best is typesetting industr.
								</p>
							</div>
							<!-- card type 1 end -->
							<div class="card-type mb3">
								<img src="{{ asset('assets/home3/images/follower.png')}}" class="img-fluid">
								<span class="cd-heading">Join with a click</span>
								<p class="gen-p mt-14">
									Lorem Ipsum is simply dummy text of the printing and best is typesetting industr.
								</p>
							</div>
							<!-- card type 2 end -->

						</div>
						<div class="col-12 col-md-6">
							<div class="card-type mb34">
								<img src="{{ asset('assets/home3/images/click.png')}}" class="img-fluid">
								<span class="cd-heading">Lorem Ipsum is simply</span>
								<p class="gen-p mt-14">
									Lorem Ipsum is simply dummy text of the printing and best is typesetting industr.
								</p>
							</div>
							<!-- card type 1 end -->
							<div class="card-type mb3">
								<img src="{{ asset('assets/home3/images/responsive.png')}}" class="img-fluid">
								<span class="cd-heading">Join with a click</span>
								<p class="gen-p mt-14">
									Lorem Ipsum is simply dummy text of the printing and best is typesetting industr.
								</p>
							</div>
							<!-- card type 2 end -->
						</div>
					</div>
					<!-- inside row end -->
				</div>
				<!-- img side end -->
			</div>
			<!-- inside row end -->
		</div>
		<!-- third-section end -->
	</div>
	<!-- row end -->

</div>
<!-- container end -->

<div class="container-fluid">
	<div class="row">
		<div class="col-12 prc-section">
			<div class="container">
				<img src="{{ asset('assets/home3/images/prc-desktop.png')}}" class="img-fluid prc-desktop-img">

				<div class="row mt-5">
					<div class="col-12 col-md-7">
						<h2 class="main-heading d-none d-md-block">Private. Reliable. Secure.</h2>
						<!-- <img src="{{ asset('assets/home3/images/prc-mobile.png')}}" class="img-fluid d-block d-md-none"> -->
						<div class="row d-block d-md-none">
							<div class="col-12 text-left"> 
								<h2 class="main-heading forbold">Private.</h2>
							</div>
							<div class="col-12 text-center"> 
								<h2 class="main-heading forbold">Reliable.</h2>
							</div>
							<div class="col-12 text-right"> 
								<h2 class="main-heading forbold">Secure.</h2>
							</div>
						</div>
					</div>

					<div class="col-12 col-md-5 ">
						<p class="gen-p pt-3">Enterprise-grade security encrypts all your meetings and conversations. Plus, password-protect any meeting and control who can join.</p>
					</div>
				</div>
				<!-- row end -->

				<div class="row mt-4">
				@foreach($partners as $partner)
					<div class="col-6 col-md-4 col-lg-2 pl-0 mb3">
							<img src="{{asset('storage')}}/partner/{{ $partner->logo }}" class="img-fluid">
						</div>
				@endforeach	
					
					
				</div>
				<!-- row end -->
			</div>
			<!-- containe end -->
		</div>
	</div>
	<!-- row end -->
</div>
<!-- container fluid end -->

<div class="container">
	<div class="row">
		<div class="col-12 meeting-section mb-5">
			<h2 class="main-heading text-center">And you thought it was just a meeting</h2>

			<div class="row mt-5">
				<div class="col-12 col-md-6 col-lg-3 forcard">
					<div class="card">
						<span class="circle clr1">
							<img src="{{ asset('assets/home3/images/user.png')}}" class="img-fluid">
						</span>
						<p class="cd-p">Invite up to 10 people</p>
						<p class="cd-desc">
							Enjoy XL meetings for free and keep your growing teams engaged.
						</p>
					</div>
				</div>
				<!-- 1end -->
				<div class="col-12 col-md-6 col-lg-3 forcard">
					<div class="card">
						<span class="circle clr2">
							<img src="{{ asset('assets/home3/images/download.png')}}" class="img-fluid">
						</span>
						<p class="cd-p">Skip  desktop download</p>
						<p class="cd-desc">
							Enjoy XL meetings for free and keep your growing teams engaged.
						</p>
					</div>
				</div>
				<!-- 2end -->
				<div class="col-12 col-md-6 col-lg-3 forcard">
					<div class="card">
						<span class="circle clr3">
							<img src="{{ asset('assets/home3/images/camera.png')}}" class="img-fluid">
						</span>
						<p class="cd-p">Meet in HD</p>
						<p class="cd-desc">
							Enjoy XL meetings for free and keep your growing teams engaged.
						</p>
					</div>
				</div>
				<!-- 3end -->
				<div class="col-12 col-md-6 col-lg-3 forcard">
					<div class="card">
						<span class="circle clr4">
							<img src="{{ asset('assets/home3/images/location=sharig.png')}}" class="img-fluid">
						</span>
						<p class="cd-p">Share your screen</p>
						<p class="cd-desc">
							Enjoy XL meetings for free and keep your growing teams engaged.
						</p>
					</div>
				</div>
				<!-- 4end -->

				<div class="col-12 col-md-6 col-lg-3 forcard">
					<div class="card">
						<span class="circle clr5">
							<img src="{{ asset('assets/home3/images/chat.png')}}" class="img-fluid">
						</span>
						<p class="cd-p">Chat and share</p>
						<p class="cd-desc">
							Enjoy XL meetings for free and keep your growing teams engaged.
						</p>
					</div>
				</div>
				<!-- 1end -->
				<div class="col-12 col-md-6 col-lg-3 forcard">
					<div class="card">
						<span class="circle clr6">
							<img src="{{ asset('assets/home3/images/setting.png')}}" class="img-fluid">
						</span>
						<p class="cd-p">Take control</p>
						<p class="cd-desc">
							Enjoy XL meetings for free and keep your growing teams engaged.
						</p>
					</div>
				</div>
				<!-- 2end -->
				<div class="col-12 col-md-6 col-lg-3 forcard">
					<div class="card">
						<span class="circle clr7">
							<img src="{{ asset('assets/home3/images/mic.png')}}" class="img-fluid">
						</span>
						<p class="cd-p">Hit record</p>
						<p class="cd-desc">
							Enjoy XL meetings for free and keep your growing teams engaged.
						</p>
					</div>
				</div>
				<!-- 3end -->
				<div class="col-12 col-md-6 col-lg-3 forcard">
					<div class="card">
						<span class="circle clr8">
							<img src="{{ asset('assets/home3/images/calander.png')}}" class="img-fluid">
						</span>
						<p class="cd-p">Connect your calendar</p>
						<p class="cd-desc">
							Enjoy XL meetings for free and keep your growing teams engaged.
						</p>
					</div>
				</div>
				<!-- 8end -->
			</div>
			<!-- main row end -->
		</div>
		<!-- meeting-section end -->
	</div>
	<!-- row end -->

	<div class="row">
		<div class="col-12 good-company-section text-center text-md-left">
			<h2 class="main-heading d-block d-md-none">You’re in good <br>company</h2>
			<h2 class="main-heading d-none d-md-block">You’re in good company</h2>
			<p class="gen-p mt-4">400,000+ companies around the <br> 	world work smarter with Glip.</p>

			<div class="row">
				<div class="col-12 col-md-10 offset-md-1 col-lg-10 offset-lg-1 text-center">
				<img src="{{ asset('assets/home3/images/logos.png')}}" class="img-fluid mt-md-n5 mt-0">
					
				</div>
			</div>
		</div>
	</div>

</div>
<!-- container end -->

<div class="container-fluid">
	<div class="row">
		<div class="col-12 wave-type-section p-0">
			<div class="container">
				<div class="banner-type ">
					<div class="row">
						<div class="col-12 col-md-7 col-lg-8 banner-left">
							<div class="m-0 p-0">
								<h2 class="main-heading text-white">Unlock unlimited meetings  & team messaging</h2>
							<p class="gen-p text-white">And have the freedom to work from anywhere.
							</p>
							<a href="" class="getstated-btn2 text-center m-0  color-pink">Get started, it’s free</a>

							</div>
						</div>
						<div class="col-12 col-md-5 col-lg-4 ">
							<img src="{{ asset('assets/home3/images/girl.png')}}" class="img-fluid gril-n-banner d-none d-md-block">
							<img src="{{ asset('assets/home3/images/girl-2.png')}}" class="img-fluid gril-n-banner d-block d-md-none">
						</div>




					</div>
					<!-- row end -->
				</div>
			</div>
		</div>
	</div>
	<!-- wav end -->



</div>
<!-- contianer fluid end -->
@endsection
