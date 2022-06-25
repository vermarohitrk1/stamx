@extends('layout.mainlayout_admin')
@section('content')		

			<!-- Page Wrapper -->
            <div class="page-wrapper">
                <div class="content container-fluid">
				
					<!-- Page Header -->
					<div class="page-header">
						<div class="row">
							<div class="col-sm-12">
								<h3 class="page-title">Categories</h3>
								<ul class="breadcrumb">
									<li class="breadcrumb-item"><a href="index">Dashboard</a></li>
									<li class="breadcrumb-item active">Categories</li>
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
													<th>#</th>
													<th>Category</th>
													<th>Date</th>
													<th class="text-center">Reviews</th>
													<th class="text-right">Action</th>
												</tr>
											</thead>
											<tbody>
												<tr>
													<td>
														1
													</td>
													<td>
														<h2 class="table-avatar">
															<a href="profile" class="avatar avatar-sm mr-2"><img class="avatar-img rounded-circle" src="../assets_admin/img/user/user.jpg" alt="User Image"></a>
															<a href="profile">Painting</a>
														</h2>
													</td>
													
													<td>3 Apr 2020</td>

													<td class="text-center">
														<i class="fas fa-star text-warning"></i>
														<i class="fas fa-star text-warning"></i>
														<i class="fas fa-star text-warning"></i>
														<i class="fas fa-star text-warning"></i>
														<i class="far fa-star text-secondary"></i>
													</td>

													<td class="text-right">
														<div class="actions">
															<a class="btn btn-sm bg-success-light" data-toggle="modal" href="#edit_modal">
																<i class="fas fa-pencil-alt"></i>
																Edit
															</a>
															<a data-toggle="modal" href="#delete_modal" class="btn btn-sm bg-danger-light">
																<i class="far fa-trash-alt"></i> Delete
															</a>
														</div>
													</td>
												</tr>
												<tr>
													<td>
														2
													</td>
													<td>
														<h2 class="table-avatar">
															<a href="profile" class="avatar avatar-sm mr-2"><img class="avatar-img rounded-circle" src="../assets_admin/img/user/user1.jpg" alt="User Image"></a>
															<a href="profile">Interior</a>
														</h2>
													</td>
													
													<td>3 Apr 2020 </td>

													<td class="text-center">
														<i class="fas fa-star text-warning"></i>
														<i class="fas fa-star text-warning"></i>
														<i class="fas fa-star text-warning"></i>
														<i class="fas fa-star text-warning"></i>
														<i class="far fa-star text-secondary"></i>
													</td>

													<td class="text-right">
														<div class="actions">
															<a class="btn btn-sm bg-success-light" data-toggle="modal" href="#edit_modal">
																<i class="fas fa-pencil-alt"></i>
																Edit
															</a>
															<a data-toggle="modal" href="#delete_modal" class="btn btn-sm bg-danger-light">
																<i class="far fa-trash-alt"></i> Delete
															</a>
														</div>
													</td>
												</tr>
												<tr>
													<td>
														3
													</td>
													<td>
														<h2 class="table-avatar">
															<a href="profile" class="avatar avatar-sm mr-2"><img class="avatar-img rounded-circle" src="../assets_admin/img/user/user2.jpg" alt="User Image"></a>
															<a href="profile">Electrical</a>
														</h2>
													</td>
													
													<td>3 Apr 2020 </td>

													<td class="text-center">
														<i class="fas fa-star text-warning"></i>
														<i class="fas fa-star text-warning"></i>
														<i class="fas fa-star text-warning"></i>
														<i class="fas fa-star text-warning"></i>
														<i class="far fa-star text-secondary"></i>
													</td>

													<td class="text-right">
														<div class="actions">
															<a class="btn btn-sm bg-success-light" data-toggle="modal" href="#edit_modal">
																<i class="fas fa-pencil-alt"></i>
																Edit
															</a>
															<a data-toggle="modal" href="#delete_modal" class="btn btn-sm bg-danger-light">
																<i class="far fa-trash-alt"></i> Delete
															</a>
														</div>
													</td>
												</tr>
												<tr>
													<td>
														4
													</td>
													<td>
														<h2 class="table-avatar">
															<a href="profile" class="avatar avatar-sm mr-2"><img class="avatar-img rounded-circle" src="../assets_admin/img/user/user3.jpg" alt="User Image"></a>
															<a href="profile">Construction</a>
														</h2>
													</td>
													
													<td>3 Apr 2020 </td>

													<td class="text-center">
														<i class="fas fa-star text-warning"></i>
														<i class="fas fa-star text-warning"></i>
														<i class="fas fa-star text-warning"></i>
														<i class="fas fa-star text-warning"></i>
														<i class="far fa-star text-secondary"></i>
													</td>

													<td class="text-right">
														<div class="actions">
															<a class="btn btn-sm bg-success-light" data-toggle="modal" href="#edit_modal">
																<i class="fas fa-pencil-alt"></i>
																Edit
															</a>
															<a data-toggle="modal" href="#delete_modal" class="btn btn-sm bg-danger-light">
																<i class="far fa-trash-alt"></i> Delete
															</a>
														</div>
													</td>
												</tr>
												<tr>
													<td>
														5
													</td>
													<td>
														<h2 class="table-avatar">
															<a href="profile" class="avatar avatar-sm mr-2"><img class="avatar-img rounded-circle" src="../assets_admin/img/user/user4.jpg" alt="User Image"></a>
															<a href="profile">Computer</a>
														</h2>
													</td>
													
													<td>3 Apr 2020 </td>

													<td class="text-center">
														<i class="fas fa-star text-warning"></i>
														<i class="fas fa-star text-warning"></i>
														<i class="fas fa-star text-warning"></i>
														<i class="fas fa-star text-warning"></i>
														<i class="far fa-star text-secondary"></i>
													</td>

													<td class="text-right">
														<div class="actions">
															<a class="btn btn-sm bg-success-light" data-toggle="modal" href="#edit_modal">
																<i class="fas fa-pencil-alt"></i>
																Edit
															</a>
															<a data-toggle="modal" href="#delete_modal" class="btn btn-sm bg-danger-light">
																<i class="far fa-trash-alt"></i> Delete
															</a>
														</div>
													</td>
												</tr>
												<tr>
													<td>
														6
													</td>
													<td>
														<h2 class="table-avatar">
															<a href="profile" class="avatar avatar-sm mr-2"><img class="avatar-img rounded-circle" src="../assets_admin/img/user/user5.jpg" alt="User Image"></a>
															<a href="profile">Cleaning</a>
														</h2>
													</td>
													
													<td>3 Apr 2020 </td>

													<td class="text-center">
														<i class="fas fa-star text-warning"></i>
														<i class="fas fa-star text-warning"></i>
														<i class="fas fa-star text-warning"></i>
														<i class="fas fa-star text-warning"></i>
														<i class="far fa-star text-secondary"></i>
													</td>

													<td class="text-right">
														<div class="actions">
															<a class="btn btn-sm bg-success-light" data-toggle="modal" href="#edit_modal">
																<i class="fas fa-pencil-alt"></i>
																Edit
															</a>
															<a data-toggle="modal" href="#delete_modal" class="btn btn-sm bg-danger-light">
																<i class="far fa-trash-alt"></i> Delete
															</a>
														</div>
													</td>
												</tr>
												<tr>
													<td>
														7
													</td>
													<td>
														<h2 class="table-avatar">
															<a href="profile" class="avatar avatar-sm mr-2"><img class="avatar-img rounded-circle" src="../assets_admin/img/user/user6.jpg" alt="User Image"></a>
															<a href="profile">Carpentry</a>
														</h2>
													</td>
													
													<td>3 Apr 2020 </td>

													<td class="text-center">
														<i class="fas fa-star text-warning"></i>
														<i class="fas fa-star text-warning"></i>
														<i class="fas fa-star text-warning"></i>
														<i class="fas fa-star text-warning"></i>
														<i class="far fa-star text-secondary"></i>
													</td>

													<td class="text-right">
														<div class="actions">
															<a class="btn btn-sm bg-success-light" data-toggle="modal" href="#edit_modal">
																<i class="fas fa-pencil-alt"></i>
																Edit
															</a>
															<a data-toggle="modal" href="#delete_modal" class="btn btn-sm bg-danger-light">
																<i class="far fa-trash-alt"></i> Delete
															</a>
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
            	
		<!-- Edit Modal -->
		<div class="modal fade" id="edit_modal" aria-hidden="true" role="dialog">
			<div class="modal-dialog modal-dialog-centered" role="document" >
				<div class="modal-content">
					<div class="modal-body">
						<div class="form-content p-2">
							<div class="modal-header border-0">
								<h4 class="modal-title">Edit</h4>
								<button type="button" class="close" data-dismiss="modal" aria-label="Close">
									<span aria-hidden="true">×</span>
								</button>
							</div>
							<div class="card">
								<div class="card-body">
					                <form id="update_category" method="post" autocomplete="off" enctype="multipart/form-data" novalidate="novalidate" class="bv-form"><button type="submit" class="bv-hidden-submit" style="display: none; width: 0px; height: 0px;"></button>
					                	<input type="hidden" name="csrf_token_name" value="104dbdaf79d7d8e21e4ae9991d166669">
					                    <div class="form-group">
					                        <label>Category Name</label>
					                        <input class="form-control" type="text" value="Painting" name="category_name" id="category_name" data-bv-field="category_name">
											<input class="form-control" type="hidden" value="8" name="category_id" id="category_id">
					                    <small class="help-block" data-bv-validator="remote" data-bv-for="category_name" data-bv-result="NOT_VALIDATED" style="display: none;">This category name is already exist</small><small class="help-block" data-bv-validator="notEmpty" data-bv-for="category_name" data-bv-result="NOT_VALIDATED" style="display: none;">Please enter category name</small></div>
					                    <div class="form-group">
					                        <label>Category Image</label>
					                        <input class="form-control" type="file" name="category_image" id="category_image">
					                    </div>
					                    <div class="form-group">
											<div class="avatar">
												<img class="avatar-img rounded" src="../assets_admin/img/user/user.jpg" alt="">
											</div>
					                    </div>
					                    <div class="mt-4">
					                        <button class="btn btn-primary" name="form_submit" value="submit" type="submit">Save Changes</button>
											<button type="button" class="btn btn-danger" data-dismiss="modal">Cancel</button>
					                    </div>
					                </form>
					            </div>
					        </div>	
						</div>
					</div>
				</div>
			</div>
		</div>
		<!-- /Edit Modal -->

		<!-- Delete Model -->
		<div class="modal fade" id="delete_modal" role="dialog" style="display: none;" aria-hidden="true">
			<div class="modal-dialog modal-dialog-centered" role="document">
				<div class="modal-content">
				<!--	<div class="modal-header">
						<h5 class="modal-title">Delete</h5>
						<button type="button" class="close" data-dismiss="modal" aria-label="Close">
							<span aria-hidden="true">&times;</span>
						</button>
					</div>-->
					<div class="modal-body">
						<div class="form-content p-2">
							<h4 class="modal-title">Delete</h4>
							<p class="mb-4">Are you sure want to delete?</p>
							<button type="button" class="btn btn-primary">Delete </button>
							<button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
						</div>
					</div>
				</div>
			</div>
		</div>
		<!-- Delete Model -->
@endsection