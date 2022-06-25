@extends('layout.mainlayout_admin')
@section('content')	
	<!-- Page Wrapper -->
    <div class="page-wrapper">
                <div class="content container-fluid">

                	<!-- Tab Menu -->
					<nav class="user-tabs mb-4 custom-tab-scroll">
						<ul class="nav nav-tabs nav-tabs-bottom nav-justified">
							<li>
								<a class="nav-link active" href="#generalsettings" data-toggle="tab">General Settings</a>
							</li>
							<li>
								<a class="nav-link" href="#paymentgateway" data-toggle="tab">Payment gateway</a>
							</li>
							<li>
								<a class="nav-link" href="#sociallogin" data-toggle="tab">Social Login</a>
							</li>
						</ul>
					</nav>
					<!-- /Tab Menu -->

					<!-- Tab Content -->
					<div class="tab-content">

						<!-- General -->
						<div role="tabpanel" id="generalsettings" class="tab-pane fade show active">

							<!-- Page Header -->
							<div class="page-header">
								<div class="row">
									<div class="col-sm-12">
										<h3 class="page-title">General Settings</h3>
										<ul class="breadcrumb">
											<li class="breadcrumb-item"><a href="index_admin">Dashboard</a></li>
											<li class="breadcrumb-item"><a href="javascript:(0)">Settings</a></li>
											<li class="breadcrumb-item active">General Settings</li>
										</ul>
									</div>
								</div>
							</div>
							<!-- /Page Header -->
						
							<div class="row">		
								<div class="col-12">
									<div class="card">
										<div class="card-header">
											<h4 class="card-title">General</h4>
										</div>
										<div class="card-body">
											<form action="#">
										
												<div class="form-group">
													<label>Website Name</label>
													<input type="text" class="form-control">
												</div>
												<div class="form-group">
													<label>Website Logo</label>
													<input type="file" class="form-control">
													<small class="text-secondary">Recommended image size is <b>150px x 150px</b></small>
												</div>
												<div class="form-group mb-0">
													<label>Favicon</label>
													<input type="file" class="form-control">
													<small class="text-secondary">Recommended image size is <b>16px x 16px</b> or <b>32px x 32px</b></small><br>
													<small class="text-secondary">Accepted formats : only png and ico</small>
												</div>
												
											</form>
										</div>
									</div>
								</div>
							</div>
						</div>
						<!-- /General -->
						
						<!-- Payment gateway -->
						<div role="tabpanel" id="paymentgateway" class="tab-pane fade">
						
							<!-- Page Header -->
							<div class="page-header">
								<div class="row">
									<div class="col-sm-12">
										<h3 class="page-title">Payment gateway</h3>
										<ul class="breadcrumb">
											<li class="breadcrumb-item"><a href="index_admin">Dashboard</a></li>
											<li class="breadcrumb-item"><a href="javascript:(0)">Settings</a></li>
											<li class="breadcrumb-item active">Payment gateway</li>
										</ul>
									</div>
								</div>
							</div>
							<!-- /Page Header -->

							<div class="row">		
								<div class="col-12">
									<div class="card">
										<div class="card-header">
											<h4 class="card-title">General</h4>
										</div>
										<div class="card-body">
											<form action="settings" method="post">
												<h4 class="text-primary">Stripe</h4>
												<input type="hidden" name="csrf_token_name" value="104dbdaf79d7d8e21e4ae9991d166669">

												<div class="form-group">
													<label>Stripe Option</label>
													
													<div>
														<div class="custom-control custom-radio custom-control-inline">
															<input class="custom-control-input" id="sandbox" name="gateway_type" value="sandbox" type="radio" checked="" onchange="payment(this.value)">
															<label class="custom-control-label" for="sandbox">Sandbox</label>
														</div>
														<div class="custom-control custom-radio custom-control-inline">
															<input class="custom-control-input" id="livepaypal" name="gateway_type" value="live" type="radio" onchange="payment(this.value)">
															<label class="custom-control-label" for="livepaypal">Live</label>
														</div>
													</div>
												</div>
												<div class="form-group">
													<label>Gateway Name</label>
													<input type="text" id="gateway_name" name="gateway_name" value="Stripe" required="" class="form-control" placeholder="Gateway Name">
												</div>
												<div class="form-group">
													<label>API Key</label>
													<input type="text" id="api_key" name="api_key" value="pk_test_AealxxOygZz84AruCGadWvUV00mJQZdLvr" required="" class="form-control">
												</div>
												<div class="form-group">
													<label>Rest Key</label>
													<input type="text" id="value" name="value" value="sk_test_8HwqAWwBd4C4E77bgAO1jUgk00hDlERgn3" required="" class="form-control">
												</div>
												<div class="mt-4">
												    <button class="btn btn-primary" name="form_submit" value="submit" type="submit">Submit</button>
													<a href="settings" class="btn btn-link m-l-5">Cancel</a>
												</div>
											</form>
										</div>
									</div>
								</div>
							</div>
						</div>
						<!-- /Payment gateway -->

						<!-- Social Login -->
						<div role="tabpanel" id="sociallogin" class="tab-pane fade">
						
							<!-- Page Header -->
							<div class="page-header">
								<div class="row">
									<div class="col-sm-12">
										<h3 class="page-title">Social Login</h3>
										<ul class="breadcrumb">
											<li class="breadcrumb-item"><a href="index_admin">Dashboard</a></li>
											<li class="breadcrumb-item"><a href="javascript:(0)">Settings</a></li>
											<li class="breadcrumb-item active">Social Login</li>
										</ul>
									</div>
								</div>
							</div>
							<!-- /Page Header -->

							<div class="card mb-0 shadow-none">
								<div class="card-header">
									<h4 class="card-title">Social Login</h4>
								</div>
								<div class="card-body">
									<div class="form-group">
										<label>Facebook App ID</label>
										<input type="text" class="form-control mb-2" id="website_facebook_app_id" name="website_facebook_app_id" value="506928406484271">
										 <a href="https://www.codexworld.com/create-facebook-app-id-app-secret/" target="_blank">How to Create facebook app id?</a>
									</div>
									<div class="form-group">
										<label>Google Client ID</label>
										<input type="text" class="form-control mb-2" id="website_google_client_id" name="website_google_client_id" value="387823802376-7e1kr704s4o39a8cqtdmd6jeaob636tu.apps.googleusercontent.com">
										 <a href="https://www.codexworld.com/create-google-developers-console-project/" target="_blank">How to Create google client id?</a>
									</div>
								</div>
								<div class="card-body pt-0">
									<button name="form_submit" type="submit" class="btn btn-primary" value="true">Save Changes</button>
 								</div>
							</div>
						</div>
						<!-- /Social Login -->

					</div>
					<!-- /Tab Content -->
								
				</div>
			</div>
			<!-- /Page Wrapper -->	
@endsection