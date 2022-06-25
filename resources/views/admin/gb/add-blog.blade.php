@extends('layout.mainlayout_admin')
@section('content')		
<!-- Page Wrapper -->
<div class="page-wrapper">
                <div class="content container-fluid">
				
					<!-- Page Header -->
					<div class="page-header">
						<div class="row">
							<div class="col-sm-12">
								<h3 class="page-title">Add Blog</h3>
								<ul class="breadcrumb">
									<li class="breadcrumb-item"><a href="index_admin">Dashboard</a></li>
									<li class="breadcrumb-item active">Add Blog</li>
								</ul>
							</div>
						</div>
					</div>
					<!-- /Page Header -->
					
					<div class="row">
						<div class="col-sm-12">
							<div class="card">
								<div class="card-body">

									<!-- Add details -->
									<div class="row">
										<div class="col-12 blog-details">
											<form>
					                            <div class="form-group">
					                                <label>Blog Name</label>
					                                <input class="form-control" type="text">
					                            </div>
					                            <div class="form-group">
					                                <label>Blog Images</label>
					                                <div>
					                                    <input class="form-control" type="file">
					                                    <small class="form-text text-muted">Max. file size: 50 MB. Allowed images: jpg, gif, png. Maximum 10 images only.</small>
					                                </div>
					                            </div>
					                            <div class="row">
					                                <div class="col-md-6">
					                                    <div class="form-group">
					                                        <label>Blog Category</label>
					                                        <select class="select select2-hidden-accessible form-control" tabindex="-1" aria-hidden="true">
					                                            <option>Web Design</option>
					                                            <option>Web Development</option>
					                                            <option>App Development</option>
					                                        </select>
					                                    </div>
					                                </div>
					                                <div class="col-md-6">
					                                    <div class="form-group">
					                                        <label>Blog Sub Category</label>
					                                        <select class="select select2-hidden-accessible form-control" tabindex="-1" aria-hidden="true">
					                                            <option>Html</option>
					                                            <option>Css</option>
					                                            <option>Javascript</option>
					                                            <option>PHP</option>
					                                            <option>Codeignitor</option>
					                                            <option>iOS</option>
					                                            <option>Android</option>
					                                        </select>
					                                    </div>
					                                </div>
					                            </div>
					                            <div class="form-group">
					                                <label>Blog Description</label>
					                                <textarea cols="30" rows="6" class="form-control"></textarea>
					                            </div>
					                            <div class="form-group">
					                                <label class="display-block w-100">Blog Status</label>
													<div>
														<div class="custom-control custom-radio custom-control-inline">
															<input class="custom-control-input" id="active" name="active-blog" value="active" type="radio" checked="">
															<label class="custom-control-label" for="active">Active</label>
														</div>
														<div class="custom-control custom-radio custom-control-inline">
															<input class="custom-control-input" id="inactive" name="active-blog" value="inactive" type="radio">
															<label class="custom-control-label" for="inactive">Inactive</label>
														</div>
													</div>
					                            </div>
					                            <div class="m-t-20 text-center">
					                                <button class="btn btn-primary btn-lg">Publish Blog</button>
					                            </div>
					                        </form>
										</div>
									</div>
									<!-- /Add details -->

								</div>
							</div>
						</div>			
					</div>
					
				</div>			
			</div>
			<!-- /Page Wrapper -->
@endsection