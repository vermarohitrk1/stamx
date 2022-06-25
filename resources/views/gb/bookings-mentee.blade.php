<?php $page="bookings-mentee";?>
@extends('layout.mainlayout')
@section('content')		
<!-- Breadcrumb -->
<div class="breadcrumb-bar">
				<div class="container-fluid">
					<div class="row align-items-center">
						<div class="col-md-12 col-12">
							<nav aria-label="breadcrumb" class="page-breadcrumb">
								<ol class="breadcrumb">
									<li class="breadcrumb-item"><a href="index">Home</a></li>
									<li class="breadcrumb-item active" aria-current="page">My Bookings</li>
								</ol>
							</nav>
							<h2 class="breadcrumb-title">My Bookings</h2>
						</div>
					</div>
				</div>
			</div>
			<!-- /Breadcrumb -->

			
			<!-- Page Content -->
			<div class="content">
				<div class="container-fluid">

						<div class="row">

							<!-- Sidebar -->
							<div class="col-md-5 col-lg-4 col-xl-3 theiaStickySidebar">
								<div class="profile-sidebar">
									<div class="user-widget">
										<div class="pro-avatar">JD</div>
										<div class="rating">
											<i class="fas fa-star filled"></i>
											<i class="fas fa-star filled"></i>
											<i class="fas fa-star filled"></i>
											<i class="fas fa-star filled"></i>
											<i class="fas fa-star"></i>
										</div>
										<div class="user-info-cont">
											<h4 class="usr-name">Jonathan Doe</h4>
											<p class="mentor-type">English Literature (M.A)</p>
										</div>
									</div>
									<div class="progress-bar-custom">
										<h6>Complete your profiles ></h6>
										<div class="pro-progress">
											<div class="tooltip-toggle" tabindex="0"></div>
											<div class="tooltip">80%</div>
										</div>
									</div>
									<div class="custom-sidebar-nav">
										<ul>
											<li><a href="dashboard-mentee"><i class="fas fa-home"></i>Dashboard <span><i class="fas fa-chevron-right"></i></span></a></li>
											<li><a href="bookings-mentee" class="active"><i class="fas fa-clock"></i>Bookings <span><i class="fas fa-chevron-right"></i></span></a></li>
											<li><a href="chat-mentee"><i class="fas fa-comments"></i>Messages <span><i class="fas fa-chevron-right"></i></span></a></li>
											<li><a href="favourites"><i class="fas fa-star"></i>Favourites <span><i class="fas fa-chevron-right"></i></span></a></li>
											<li><a href="profile-mentee"><i class="fas fa-user-cog"></i>Profile <span><i class="fas fa-chevron-right"></i></span></a></li>
											<li><a href="login"><i class="fas fa-sign-out-alt"></i>Logout <span><i class="fas fa-chevron-right"></i></span></a></li>
										</ul>
									</div>
								</div>
							</div>
							<!-- /Sidebar -->

						<!-- Booking summary -->
						<div class="col-md-7 col-lg-8 col-xl-9">
							<h3 class="pb-3">Booking Summary</h3>
							<!-- Mentee List Tab -->
							<div class="tab-pane show active" id="mentee-list">
								<div class="card card-table">
									<div class="card-body">
										<div class="table-responsive">
											<table class="table table-hover table-center mb-0">
												<thead>
													<tr>
														<th>MENTEE LISTS</th>
														<th>SCHEDULED DATE</th>
														<th class="text-center">SCHEDULED TIMINGS</th>
														<th class="text-center">ACTION</th>
													</tr>
												</thead>
												<tbody>
													<tr>
														<td>
															<h2 class="table-avatar">
																<a href="profile" class="avatar avatar-sm mr-2"><img class="avatar-img rounded-circle" src="assets/img/user/user2.jpg" alt="User Image"></a>
																<a href="profile">Tyrone Roberts<span>tyroneroberts@adobe.com</span></a>				
															</h2>
														</td>
														<td>08 April 2020</td>
														<td class="text-center"><span class="pending">9:00 AM - 10:00 AM</span></td>
														<td class="text-center"><a href="profile-mentee" class="btn btn-sm bg-info-light"><i class="far fa-eye"></i> View</a></td>
													</tr>
													<tr>
														<td>
															<h2 class="table-avatar">
																<a href="profile" class="avatar avatar-sm mr-2"><img class="avatar-img rounded-circle" src="assets/img/user/user1.jpg" alt="User Image"></a>
																<a href="profile">Julie Pennington <span>julie@adobe.com</span></a>				
															</h2>
														</td>
														<td>08 April 2020</td>
														<td class="text-center"><span class="pending">9:00 AM - 10:00 AM</span></td>
														<td class="text-center"><a href="profile-mentee" class="btn btn-sm bg-info-light"><i class="far fa-eye"></i> View</a></td>
													</tr>
													<tr>
														<td>
															<h2 class="table-avatar">
																<a href="profile" class="avatar avatar-sm mr-2"><img class="avatar-img rounded-circle" src="assets/img/user/user3.jpg" alt="User Image"></a>
																<a href="profile">Allen Davis <span>allendavis@adobe.com</span></a>				
															</h2>
														</td>
														<td>07 April 2020</td>
														<td class="text-center"><span class="pending">9:00 AM - 10:00 AM</span></td>
														<td class="text-center"><a href="profile-mentee" class="btn btn-sm bg-info-light"><i class="far fa-eye"></i> View</a></td>
													</tr>
													<tr>
														<td>
															<h2 class="table-avatar">
																<a href="profile" class="avatar avatar-sm mr-2"><img class="avatar-img rounded-circle" src="assets/img/user/user4.jpg" alt="User Image"></a>
																<a href="profile">Patricia Manzi <span>patriciamanzi@adobe.com</span></a>				
															</h2>
														</td>
														<td>07 April 2020</td>
														<td class="text-center"><span class="pending">9:00 AM - 10:00 AM</span></td>
														<td class="text-center"><a href="profile-mentee" class="btn btn-sm bg-info-light"><i class="far fa-eye"></i> View</a></td>
													</tr>
													<tr>
														<td>
															<h2 class="table-avatar">
																<a href="profile" class="avatar avatar-sm mr-2"><img class="avatar-img rounded-circle" src="assets/img/user/user5.jpg" alt="User Image"></a>
																<a href="profile">Olive Lawrence <span>olivelawrence@adobe.com</span></a>				
															</h2>
														</td>
														<td>06 April 2020</td>
														<td class="text-center"><span class="pending">9:00 AM - 10:00 AM</span></td>
														<td class="text-center"><a href="profile-mentee" class="btn btn-sm bg-info-light"><i class="far fa-eye"></i> View</a></td>
													</tr>
													<tr>
														<td>
															<h2 class="table-avatar">
																<a href="profile" class="avatar avatar-sm mr-2"><img class="avatar-img rounded-circle" src="assets/img/user/user6.jpg" alt="User Image"></a>
																<a href="profile">Frances Foster <span>frances@adobe.com</span></a>				
															</h2>
														</td>
														<td>06 April 2020</td>
														<td class="text-center"><span class="pending">9:00 AM - 10:00 AM</span></td>
														<td class="text-center"><a href="profile-mentee" class="btn btn-sm bg-info-light"><i class="far fa-eye"></i> View</a></td>
													</tr>
													<tr>
														<td>
															<h2 class="table-avatar">
																<a href="profile" class="avatar avatar-sm mr-2"><img class="avatar-img rounded-circle" src="assets/img/user/user2.jpg" alt="User Image"></a>
																<a href="profile">Tyrone Roberts<span>tyroneroberts@adobe.com</span></a>				
															</h2>
														</td>
														<td>08 April 2020</td>
														<td class="text-center"><span class="pending">9:00 AM - 10:00 AM</span></td>
														<td class="text-center"><a href="profile-mentee" class="btn btn-sm bg-info-light"><i class="far fa-eye"></i> View</a></td>
													</tr>
													<tr>
														<td>
															<h2 class="table-avatar">
																<a href="profile" class="avatar avatar-sm mr-2"><img class="avatar-img rounded-circle" src="assets/img/user/user1.jpg" alt="User Image"></a>
																<a href="profile">Julie Pennington <span>julie@adobe.com</span></a>				
															</h2>
														</td>
														<td>08 April 2020</td>
														<td class="text-center"><span class="pending">9:00 AM - 10:00 AM</span></td>
														<td class="text-center"><a href="profile-mentee" class="btn btn-sm bg-info-light"><i class="far fa-eye"></i> View</a></td>
													</tr>
													<tr>
														<td>
															<h2 class="table-avatar">
																<a href="profile" class="avatar avatar-sm mr-2"><img class="avatar-img rounded-circle" src="assets/img/user/user3.jpg" alt="User Image"></a>
																<a href="profile">Allen Davis <span>allendavis@adobe.com</span></a>				
															</h2>
														</td>
														<td>07 April 2020</td>
														<td class="text-center"><span class="pending">9:00 AM - 10:00 AM</span></td>
														<td class="text-center"><a href="profile-mentee" class="btn btn-sm bg-info-light"><i class="far fa-eye"></i> View</a></td>
													</tr>
												</tbody>
											</table>		
										</div>
									</div>
								</div>
							</div>
							<!-- /Mentee List Tab -->
						</div>
						<!-- /Booking summary -->

						</div>
					
				</div>
			</div>		
			<!-- /Page Content -->
@endsection