@extends('layout.mainlayout_admin')
@section('content')	

			<!-- Page Wrapper -->
            <div class="page-wrapper">
                <div class="content container-fluid">
				
					<!-- Page Header -->
					<div class="page-header">
						<div class="row">
							<div class="col-sm-12">
								<h3 class="page-title">List of Mentee</h3>
								<ul class="breadcrumb">
									<li class="breadcrumb-item"><a href="index_admin">Dashboard</a></li>
									<li class="breadcrumb-item"><a href="javascript:(0);">Users</a></li>
									<li class="breadcrumb-item active">Mentee</li>
								</ul>
							</div>
						</div>
					</div>
					<!-- /Page Header -->
					
					<div class="row">
						<div class="col-sm-12">
							<div class="card">
								<div class="card-body">
									<div class="table-responsive">
										<table class="datatable table table-hover table-center mb-0">
											<thead>
												<tr>
													<th>Mentee Name</th>
													<th>Course</th>
													<th>Member Since</th>
													<th>Earned</th>
													<th class="text-center">Account Status</th>
													
												</tr>
											</thead>
											<tbody>
												<tr>
													<td>
														<h2 class="table-avatar">
															<a href="profile" class="avatar avatar-sm mr-2"><img class="avatar-img rounded-circle" src="../assets_admin/img/user/user.jpg" alt="User Image"></a>
															<a href="profile">Jonathan Doe </a>
														</h2>
													</td>
													<td>Maths</td>
													
													<td>14 Jan 2019 <br><small>02.59 AM</small></td>
													
													<td>$3100.00</td>
													
													<td>
														<div class="status-toggle d-flex justify-content-center">
															<input type="checkbox" id="status_1" class="check" checked>
															<label for="status_1" class="checktoggle">checkbox</label>
														</div>
													</td>
												</tr>
												<tr>
													<td>
														<h2 class="table-avatar">
															<a href="profile" class="avatar avatar-sm mr-2"><img class="avatar-img rounded-circle" src="../assets_admin/img/user/user1.jpg" alt="User Image"></a>
															<a href="profile">Julie Pennington </a>
														</h2>
													</td>
													<td>Business Maths</td>
													
													<td>11 Jun 2019 <br><small>4.50 AM</small></td>
													
													<td>$5000.00</td>
													
													<td>
														<div class="status-toggle d-flex justify-content-center">
															<input type="checkbox" id="status_2" class="check" checked>
															<label for="status_2" class="checktoggle">checkbox</label>
														</div>
													</td>
												</tr>
												<tr>
													<td>
														<h2 class="table-avatar">
															<a href="profile" class="avatar avatar-sm mr-2"><img class="avatar-img rounded-circle" src="../assets_admin/img/user/user2.jpg" alt="User Image"></a>
															<a href="profile">Tyrone Roberts</a>
														</h2>
													</td>
													<td>Algebra</td>
													
													<td>4 Jan 2018 <br><small>9.40 AM</small></td>
													
													<td>$3300.00</td>
													
													<td>
														<div class="status-toggle d-flex justify-content-center">
															<input type="checkbox" id="status_3" class="check" checked>
															<label for="status_3" class="checktoggle">checkbox</label>
														</div>
													</td>
												</tr>
												<tr>
													<td>
														<h2 class="table-avatar">
															<a href="profile" class="avatar avatar-sm mr-2"><img class="avatar-img rounded-circle" src="../assets_admin/img/user/user3.jpg" alt="User Image"></a>
															<a href="profile">Allen Davis </a>
														</h2>
													</td>
													<td>Integrated Sum</td>
													
													<td>5 Jul 2019 <br><small>12.59 AM</small></td>
													
													<td>$3500.00</td>
													
													<td>
														<div class="status-toggle d-flex justify-content-center">
															<input type="checkbox" id="status_4" class="check" checked>
															<label for="status_4" class="checktoggle">checkbox</label>
														</div>
													</td>
												</tr>
												<tr>
													<td>
														<h2 class="table-avatar">
															<a href="profile" class="avatar avatar-sm mr-2"><img class="avatar-img rounded-circle" src="../assets_admin/img/user/user4.jpg" alt="User Image"></a>
															<a href="profile">Patricia Manzi </a>
														</h2>
													</td>
													<td>Flow chart</td>
													
													<td>24 Jan 2019 <br><small>02.59 AM</small></td>
													
													<td>$3700.00</td>
													
													<td>
														<div class="status-toggle d-flex justify-content-center">
															<input type="checkbox" id="status_5" class="check" checked>
															<label for="status_5" class="checktoggle">checkbox</label>
														</div>
													</td>
												</tr>
												<tr>
													<td>
														<h2 class="table-avatar">
															<a href="profile" class="avatar avatar-sm mr-2"><img class="avatar-img rounded-circle" src="../assets_admin/img/user/user5.jpg" alt="User Image"></a>
															<a href="profile">Katharine Berthold</a>
														</h2>
													</td>
													<td>Basic Calculation</td>
													
													<td>23 Mar 2019 <br><small>02.50 PM</small></td>
													
													<td>$4000.00</td>
													
													<td>
														<div class="status-toggle d-flex justify-content-center">
															<input type="checkbox" id="status_6" class="check" checked>
															<label for="status_6" class="checktoggle">checkbox</label>
														</div>
													</td>
												</tr>
												<tr>
													<td>
														<h2 class="table-avatar">
															<a href="profile" class="avatar avatar-sm mr-2"><img class="avatar-img rounded-circle" src="../assets_admin/img/user/user6.jpg" alt="User Image"></a>
															<a href="profile">Linda Tobin</a>
														</h2>
													</td>
													<td>Math Grade II</td>
													
													<td>14 Dec 2018 <br><small>01.59 AM</small></td>
													
													<td>$2000.00</td>
													
													<td>
														<div class="status-toggle d-flex justify-content-center">
															<input type="checkbox" id="status_7" class="check" checked>
															<label for="status_7" class="checktoggle">checkbox</label>
														</div>
													</td>
												</tr>
												<tr>
													<td>
														<h2 class="table-avatar">
															<a href="profile" class="avatar avatar-sm mr-2"><img class="avatar-img rounded-circle" src="../assets_admin/img/user/user7.jpg" alt="User Image"></a>
															<a href="profile">Paul Richard</a>
														</h2>
													</td>
													<td>Math Grade II</td>
													
													<td>11 Jan 2019 <br><small>02.59 AM</small></td>
													
													<td>$3000.00</td>
													
													<td>
														<div class="status-toggle d-flex justify-content-center">
															<input type="checkbox" id="status_8" class="check" checked>
															<label for="status_8" class="checktoggle">checkbox</label>
														</div>
													</td>
												</tr>
												<tr>
													<td>
														<h2 class="table-avatar">
															<a href="profile" class="avatar avatar-sm mr-2"><img class="avatar-img rounded-circle" src="../assets_admin/img/user/user8.jpg" alt="User Image"></a>
															<a href="profile">John Gibbs</a>
														</h2>
													</td>
													<td>Flow chart</td>
													
													<td>21 Apr 2018 <br><small>02.59 PM</small></td>
													
													<td>$4100.00</td>
													
													<td>
														<div class="status-toggle d-flex justify-content-center">
															<input type="checkbox" id="status_9" class="check" checked>
															<label for="status_9" class="checktoggle">checkbox</label>
														</div>
													</td>
												</tr>
												<tr>
													<td>
														<h2 class="table-avatar">
															<a href="profile" class="avatar avatar-sm mr-2"><img class="avatar-img rounded-circle" src="../assets_admin/img/user/user9.jpg" alt="User Image"></a>
															<a href="profile">Olga Barlow</a>
														</h2>
													</td>
													<td>Maths</td>
													
													<td>15 Feb 2018 <br><small>03.59 AM</small></td>
													
													<td>$3500.00</td>
													
													<td>
														<div class="status-toggle d-flex justify-content-center">
															<input type="checkbox" id="status_10" class="check" checked>
															<label for="status_10" class="checktoggle">checkbox</label>
														</div>
													</td>
												</tr>
											</tbody>
										</table>
									</div>
								</div>
							</div>
						</div>			
					</div>
					
				</div>			
			</div>
			<!-- /Page Wrapper -->	
@endsection