<?php $page="map-list";?>
@extends('layout.mainlayout')
@section('content')	
<!-- Page Content -->
<div class="content">
				<div class="container-fluid">

	            <div class="row">
					<div class="col-xl-7 col-lg-12 order-md-last order-sm-last order-last map-left">
				
						<div class="row align-items-center mb-4">
							<div class="col-md-6 col">
								<h4>2245 Mentees found</h4>
							</div>

							<div class="col-md-6 col-auto">
								<div class="view-icons">
									<a href="map-grid" class="grid-view"><i class="fas fa-th-large"></i></a>
									<a href="map-list" class="list-view active"><i class="fas fa-bars"></i></a>
								</div>
								<div class="sort-by d-sm-block d-none">
									<span class="sortby-fliter">
										<select class="select">
											<option>Sort by</option>
											<option class="sorting">Rating</option>
											<option class="sorting">Popular</option>
											<option class="sorting">Latest</option>
											<option class="sorting">Free</option>
										</select>
									</span>
								</div>
							</div>
						</div>

						<!-- Mentor Widget -->
						<div class="card">
							<div class="card-body">
								<div class="mentor-widget">
									<div class="user-info-left">
										<div class="mentor-img">
											<a href="profile">
												<img src="assets/img/user/user.jpg" class="img-fluid" alt="User Image">
											</a>
										</div>
										<div class="user-info-cont">
											<h4 class="usr-name"><a href="profile">Ruby Perrin</a></h4>
											<p class="mentor-type">Digital Marketer</p>
											<div class="rating">
												<i class="fas fa-star filled"></i>
												<i class="fas fa-star filled"></i>
												<i class="fas fa-star filled"></i>
												<i class="fas fa-star filled"></i>
												<i class="fas fa-star"></i>
												<span class="d-inline-block average-rating">(17)</span>
											</div>
											<div class="mentor-details">
												<p class="user-location"><i class="fas fa-map-marker-alt"></i> Florida, USA</p>
											</div>
										</div>
									</div>
									<div class="user-info-right">
										<div class="user-infos">
											<ul>
												<li><i class="far fa-comment"></i> 17 Feedback</li>
												<li><i class="fas fa-map-marker-alt"></i> Florida, USA</li>
												<li><i class="far fa-money-bill-alt"></i> $300 - $1000 <i class="fas fa-info-circle" data-toggle="tooltip" title="Lorem Ipsum"></i> </li>
											</ul>
										</div>
										<div class="mentor-booking">
											<a class="apt-btn" href="booking">Book Appointment</a>
										</div>
									</div>
								</div>
							</div>
						</div>
						<!-- /Mentor Widget -->

						<!-- Mentor Widget -->
						<div class="card">
							<div class="card-body">
								<div class="mentor-widget">
									<div class="user-info-left">
										<div class="mentor-img">
											<a href="profile">
												<img src="assets/img/user/user1.jpg" class="img-fluid" alt="User Image">
											</a>
										</div>
										<div class="user-info-cont">
											<h4 class="usr-name"><a href="profile">Darren Elder</a></h4>
											<p class="mentor-type">UNIX, Calculus, Trigonometry</p>
											<div class="rating">
												<i class="fas fa-star filled"></i>
												<i class="fas fa-star filled"></i>
												<i class="fas fa-star filled"></i>
												<i class="fas fa-star filled"></i>
												<i class="fas fa-star"></i>
												<span class="d-inline-block average-rating">(35)</span>
											</div>
											<div class="mentor-details">
												<p class="user-location"><i class="fas fa-map-marker-alt"></i> Newyork, USA</p>
											</div>
										</div>
									</div>
									<div class="user-info-right">
										<div class="user-infos">
											<ul>
												<li><i class="far fa-comment"></i> 35 Feedback</li>
												<li><i class="fas fa-map-marker-alt"></i> Newyork, USA</li>
												<li><i class="far fa-money-bill-alt"></i> $50 - $300 <i class="fas fa-info-circle" data-toggle="tooltip" title="Lorem Ipsum"></i></li>
											</ul>
										</div>
										<div class="mentor-booking">
											<a class="apt-btn" href="booking">Book Appointment</a>
										</div>
									</div>
								</div>
							</div>
						</div>
						<!-- /Mentor Widget -->

						<!-- Mentor Widget -->
						<div class="card">
							<div class="card-body">
								<div class="mentor-widget">
									<div class="user-info-left">
										<div class="mentor-img">
											<a href="profile">
												<img src="assets/img/user/user2.jpg" class="img-fluid" alt="User Image">
											</a>
										</div>
										<div class="user-info-cont">
											<h4 class="usr-name"><a href="profile">Deborah Angel</a></h4>
											<p class="mentor-type">Computer Programming</p>
											<div class="rating">
												<i class="fas fa-star filled"></i>
												<i class="fas fa-star filled"></i>
												<i class="fas fa-star filled"></i>
												<i class="fas fa-star filled"></i>
												<i class="fas fa-star"></i>
												<span class="d-inline-block average-rating">(27)</span>
											</div>
											<div class="mentor-details">
												<p class="user-location"><i class="fas fa-map-marker-alt"></i> Georgia, USA</p>
											</div>
										</div>
									</div>
									<div class="user-info-right">
										<div class="user-infos">
											<ul>
												<li><i class="far fa-comment"></i> 35 Feedback</li>
												<li><i class="fas fa-map-marker-alt"></i> Newyork, USA</li>
												<li><i class="far fa-money-bill-alt"></i> $100 - $400 <i class="fas fa-info-circle" data-toggle="tooltip" title="Lorem Ipsum"></i></li>
											</ul>
										</div>
										<div class="mentor-booking">
											<a class="apt-btn" href="booking">Book Appointment</a>
										</div>
									</div>
								</div>
							</div>
						</div>
						<!-- /Mentor Widget -->

						<!-- Mentor Widget -->
						<div class="card">
							<div class="card-body">
								<div class="mentor-widget">
									<div class="user-info-left">
										<div class="mentor-img">
											<a href="profile">
												<img src="assets/img/user/user4.jpg" class="img-fluid" alt="User Image">
											</a>
										</div>
										<div class="user-info-cont">
											<h4 class="usr-name"><a href="profile">Sofia Brient</a></h4>
											<p class="mentor-type">ASP.NET, Computer Gaming</p>
											<div class="rating">
												<i class="fas fa-star filled"></i>
												<i class="fas fa-star filled"></i>
												<i class="fas fa-star filled"></i>
												<i class="fas fa-star filled"></i>
												<i class="fas fa-star"></i>
												<span class="d-inline-block average-rating">(4)</span>
											</div>
											<div class="mentor-details">
												<p class="user-location"><i class="fas fa-map-marker-alt"></i> Louisiana, USA</p>
											</div>
										</div>
									</div>
									<div class="user-info-right">
										<div class="user-infos">
											<ul>
												<li><i class="far fa-comment"></i> 4 Feedback</li>
												<li><i class="fas fa-map-marker-alt"></i> Newyork, USA</li>
												<li><i class="far fa-money-bill-alt"></i> $150 - $250 <i class="fas fa-info-circle" data-toggle="tooltip" title="Lorem Ipsum"></i></li>
											</ul>
										</div>
										<div class="mentor-booking">
											<a class="apt-btn" href="booking">Book Appointment</a>
										</div>
									</div>
								</div>
							</div>
						</div>
						<!-- /Mentor Widget -->

						<!-- Mentor Widget -->
						<div class="card">
							<div class="card-body">
								<div class="mentor-widget">
									<div class="user-info-left">
										<div class="mentor-img">
											<a href="profile">
												<img src="assets/img/user/user5.jpg" class="img-fluid" alt="User Image">
											</a>
										</div>
										<div class="user-info-cont">
											<h4 class="usr-name"><a href="profile">Katharine Berthold</a></h4>
											<p class="mentor-type">UNIX, Calculus, Trigonometry</p>
											<div class="rating">
												<i class="fas fa-star filled"></i>
												<i class="fas fa-star filled"></i>
												<i class="fas fa-star filled"></i>
												<i class="fas fa-star filled"></i>
												<i class="fas fa-star"></i>
												<span class="d-inline-block average-rating">(52)</span>
											</div>
											<div class="mentor-details">
												<p class="user-location"><i class="fas fa-map-marker-alt"></i> Texas, USA</p>
											</div>
										</div>
									</div>
									<div class="user-info-right">
										<div class="user-infos">
											<ul>
												<li><i class="far fa-comment"></i> 52 Feedback</li>
												<li><i class="fas fa-map-marker-alt"></i> Texas, USA</li>
												<li><i class="far fa-money-bill-alt"></i> $100 - $500 <i class="fas fa-info-circle" data-toggle="tooltip" title="Lorem Ipsum"></i></li>
											</ul>
										</div>
										<div class="mentor-booking">
											<a class="apt-btn" href="booking">Book Appointment</a>
										</div>
									</div>
								</div>
							</div>
						</div>
						<!-- /Mentor Widget -->
							
					<div class="load-more text-center">
						<a class="btn btn-primary btn-sm" href="javascript:void(0);">Load More</a>	
					</div>
	            </div>
	            <!-- /content-left-->
	            <div class="col-xl-5 col-lg-12 map-right">
	                <div id="map" class="map-listing"></div>
	                <!-- map-->
	            </div>
	            <!-- /map-right-->
	        </div>
	        <!-- /row-->	
@endsection