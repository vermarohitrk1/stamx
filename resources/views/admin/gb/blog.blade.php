@extends('layout.mainlayout_admin')
@section('content')		
<!-- Page Wrapper -->
<div class="page-wrapper">
                <div class="content container-fluid">
				
					<!-- Page Header -->
					<div class="page-header">
						<div class="row">
							<div class="col-sm-12">
								<h3 class="page-title">Blog</h3>
								<ul class="breadcrumb">
									<li class="breadcrumb-item"><a href="index_admin">Dashboard</a></li>
									<li class="breadcrumb-item active">Blog</li>
								</ul>
							</div>
						</div>
					</div>
					<!-- /Page Header -->
					
					<div class="row">
						<div class="col-sm-12">
							<div class="card">
								<div class="card-body">

									<!-- Blog list -->
									<div class="row">
										<div class="col-12 col-md-6 col-xl-4">
											<div class="course-box blog grid-blog">
												<div class="blog-image mb-0">
													<a href="blog-details"><img class="img-fluid" src="../assets_admin/img/blog/blog-01.jpg" alt="Post Image"></a>
												</div>
												<div class="course-content">
													<span class="date">April 09 2020</span>
													<span class="course-title">Abacus Study for beginner - Part I</span>
													<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit</p>
													<div class="row">
														<div class="col">
															<a href="edit-blog" class="text-success">
																<i class="far fa-edit"></i> Edit
															</a>
														</div>
														<div class="col text-right">
															<a href="javascript:void(0);" class="text-danger">
																<i class="far fa-trash-alt"></i> Inactive
															</a>
														</div>
													</div>
												</div>
											</div>
										</div>
										<div class="col-12 col-md-6 col-xl-4">
											<div class="course-box blog grid-blog">
												<div class="blog-image mb-0">
													<a href="blog-details"><img class="img-fluid" src="../assets_admin/img/blog/blog-02.jpg" alt="Post Image"></a>
												</div>
												<div class="course-content">
													<span class="date">April 09 2020</span>
													<span class="course-title">Abacus Study for beginner - Part II</span>
													<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit</p>
													<div class="row">
														<div class="col">
															<a href="edit-blog" class="text-success">
																<i class="far fa-edit"></i> Edit
															</a>
														</div>
														<div class="col text-right">
															<a href="javascript:void(0);" class="text-danger">
																<i class="far fa-trash-alt"></i> Inactive
															</a>
														</div>
													</div>
												</div>
											</div>
										</div>
										<div class="col-12 col-md-6 col-xl-4">
											<div class="course-box blog grid-blog">
												<div class="blog-image mb-0">
													<a href="blog-details"><img class="img-fluid" src="../assets_admin/img/blog/blog-03.jpg" alt="Post Image"></a>
												</div>
												<div class="course-content">
													<span class="date">April 09 2020</span>
													<span class="course-title">Abacus Study for beginner - Part III</span>
													<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit</p>
													<div class="row">
														<div class="col">
															<a href="edit-blog" class="text-success">
																<i class="far fa-edit"></i> Edit
															</a>
														</div>
														<div class="col text-right">
															<a href="javascript:void(0);" class="text-danger">
																<i class="far fa-trash-alt"></i> Inactive
															</a>
														</div>
													</div>
												</div>
											</div>
										</div>
									</div>
									<!-- /Blog list -->

								</div>
							</div>
						</div>			
					</div>
					
				</div>			
			</div>
			<!-- /Page Wrapper -->
@endsection