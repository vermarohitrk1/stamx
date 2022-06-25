@extends('layout.mainlayout_admin')
@section('content')	
<!-- Page Wrapper -->
<div class="page-wrapper">
                <div class="content container-fluid">
				
					<!-- Page Header -->
					<div class="page-header">
						<div class="row">
							<div class="col-sm-12">
								<h3 class="page-title">Transactions</h3>
								<ul class="breadcrumb">
									<li class="breadcrumb-item"><a href="index">Dashboard</a></li>
									<li class="breadcrumb-item active">Transactions</li>
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
													<th>Invoice Number</th>
													<th>Mentee ID</th>
													<th>Mentee Name</th>
													<th>Total Amount</th>
													<th class="text-center">Status</th>
													<th class="text-center">Actions</th>
												</tr>
											</thead>
											<tbody>
												<tr>
													<td><a href="invoice">#IN0001</a></td>
													<td>#01</td>
													<td>
														<h2 class="table-avatar">
															<a href="profile" class="avatar avatar-sm mr-2"><img class="avatar-img rounded-circle" src="../assets_admin/img/user/user.jpg" alt="User Image"></a>
															<a href="profile">Jonathan Doe </a>
														</h2>
													</td>
													<td>$100.00</td>
													<td class="text-center">
														<span class="badge badge-pill bg-success inv-badge">Paid</span>
													</td>
													<td class="text-right">
														<div class="actions">
															<a data-toggle="modal" href="#edit_invoice_report" class="btn btn-sm bg-success-light mr-2">
																<i class="fas fa-pencil-alt"></i> Edit
															</a>
															<a class="btn btn-sm bg-danger-light" data-toggle="modal" href="#delete_modal">
																<i class="far fa-trash-alt"></i> Delete
															</a>
														</div>
													</td>
												</tr>
												<tr>
													<td><a href="invoice">#IN0002</a></td>
													<td>#02</td>
													<td>
														<h2 class="table-avatar">
															<a href="profile" class="avatar avatar-sm mr-2"><img class="avatar-img rounded-circle" src="../assets_admin/img/user/user1.jpg" alt="User Image"></a>
															<a href="profile">Julie Pennington </a>
														</h2>
													</td>
													<td>$200.00</td>
													<td class="text-center">
														<span class="badge badge-pill bg-success inv-badge">Paid</span>
													</td>
													<td class="text-right">
														<div class="actions">
															<a data-toggle="modal" href="#edit_invoice_report" class="btn btn-sm bg-success-light mr-2">
																<i class="fas fa-pencil-alt"></i> Edit
															</a>
															<a class="btn btn-sm bg-danger-light" data-toggle="modal" href="#delete_modal">
																<i class="far fa-trash-alt"></i> Delete
															</a>
														</div>
													</td>
												</tr>
												<tr>
													<td><a href="invoice">#IN0003</a></td>
													<td>#03</td>
													<td>
														<h2 class="table-avatar">
															<a href="profile" class="avatar avatar-sm mr-2"><img class="avatar-img rounded-circle" src="../assets_admin/img/user/user2.jpg" alt="User Image"></a>
															<a href="profile">Tyrone Roberts</a>
														</h2>
													</td>
													<td>$250.00</td>
													<td class="text-center">
														<span class="badge badge-pill bg-success inv-badge">Paid</span>
													</td>
													<td class="text-right">
														<div class="actions">
															<a data-toggle="modal" href="#edit_invoice_report" class="btn btn-sm bg-success-light mr-2">
																<i class="fas fa-pencil-alt"></i> Edit
															</a>
															<a class="btn btn-sm bg-danger-light" data-toggle="modal" href="#delete_modal">
																<i class="far fa-trash-alt"></i> Delete
															</a>
														</div>
													</td>
												</tr>
												<tr>
													<td><a href="invoice">#IN0004</a></td>
													<td>#04</td>
													<td>
														<h2 class="table-avatar">
															<a href="profile" class="avatar avatar-sm mr-2"><img class="avatar-img rounded-circle" src="../assets_admin/img/user/user3.jpg" alt="User Image"></a>
															<a href="profile">Allen Davis </a>
														</h2>
													</td>
													<td>$150.00</td>
													<td class="text-center">
														<span class="badge badge-pill bg-success inv-badge">Paid</span>
													</td>
													<td class="text-right">
														<div class="actions">
															<a data-toggle="modal" href="#edit_invoice_report" class="btn btn-sm bg-success-light mr-2">
																<i class="fas fa-pencil-alt"></i> Edit
															</a>
															<a class="btn btn-sm bg-danger-light" data-toggle="modal" href="#delete_modal">
																<i class="far fa-trash-alt"></i> Delete
															</a>
														</div>
													</td>
												</tr>
												<tr>
													<td><a href="invoice">#IN0005</a></td>
													<td>#05</td>
													<td>
														<h2 class="table-avatar">
															<a href="profile" class="avatar avatar-sm mr-2"><img class="avatar-img rounded-circle" src="../assets_admin/img/user/user4.jpg" alt="User Image"></a>
															<a href="profile">Patricia Manzi </a>
														</h2>
													</td>
													<td>$350.00</td>
													<td class="text-center">
														<span class="badge badge-pill bg-success inv-badge">Paid</span>
													</td>
													<td class="text-right">
														<div class="actions">
															<a data-toggle="modal" href="#edit_invoice_report" class="btn btn-sm bg-success-light mr-2">
																<i class="fas fa-pencil-alt"></i> Edit
															</a>
															<a class="btn btn-sm bg-danger-light" data-toggle="modal" href="#delete_modal">
																<i class="far fa-trash-alt"></i> Delete
															</a>
														</div>
													</td>
												</tr>
												<tr>
													<td><a href="invoice">#IN0006</a></td>
													<td>#06</td>
													<td>
														<h2 class="table-avatar">
															<a href="profile" class="avatar avatar-sm mr-2"><img class="avatar-img rounded-circle" src="../assets_admin/img/user/user5.jpg" alt="User Image"></a>
															<a href="profile">Elsie Gilley</a>
														</h2>
													</td>
													<td>$300.00</td>
													<td class="text-center">
														<span class="badge badge-pill bg-success inv-badge">Paid</span>
													</td>
													<td class="text-right">
														<div class="actions">
															<a data-toggle="modal" href="#edit_invoice_report" class="btn btn-sm bg-success-light mr-2">
																<i class="fas fa-pencil-alt"></i> Edit
															</a>
															<a class="btn btn-sm bg-danger-light" data-toggle="modal" href="#delete_modal">
																<i class="far fa-trash-alt"></i> Delete
															</a>
														</div>
													</td>
												</tr>
												<tr>
													<td><a href="invoice">#IN0007</a></td>
													<td>#07</td>
													<td>
														<h2 class="table-avatar">
															<a href="profile" class="avatar avatar-sm mr-2"><img class="avatar-img rounded-circle" src="../assets_admin/img/user/user11.jpg" alt="User Image"></a>
															<a href="profile"> Joan Gardner</a>
														</h2>
													</td>
													<td>$250.00</td>
													<td class="text-center">
														<span class="badge badge-pill bg-success inv-badge">Paid</span>
													</td>
													<td class="text-right">
														<div class="actions">
															<a data-toggle="modal" href="#edit_invoice_report" class="btn btn-sm bg-success-light mr-2">
																<i class="fas fa-pencil-alt"></i> Edit
															</a>
															<a class="btn btn-sm bg-danger-light" data-toggle="modal" href="#delete_modal">
																<i class="far fa-trash-alt"></i> Delete
															</a>
														</div>
													</td>
												</tr>
												<tr>
													<td><a href="invoice">#IN0008</a></td>
													<td>#08</td>
													<td>
														<h2 class="table-avatar">
															<a href="profile" class="avatar avatar-sm mr-2"><img class="avatar-img rounded-circle" src="../assets_admin/img/user/user12.jpg" alt="User Image"></a>
															<a href="profile"> Daniel Griffing</a>
														</h2>
													</td>
													<td>$150.00</td>
													<td class="text-center">
														<span class="badge badge-pill bg-success inv-badge">Paid</span>
													</td>
													<td class="text-right">
														<div class="actions">
															<a data-toggle="modal" href="#edit_invoice_report" class="btn btn-sm bg-success-light mr-2">
																<i class="fas fa-pencil-alt"></i> Edit
															</a>
															<a class="btn btn-sm bg-danger-light" data-toggle="modal" href="#delete_modal">
																<i class="far fa-trash-alt"></i> Delete
															</a>
														</div>
													</td>
												</tr>
												<tr>
													<td><a href="invoice">#IN0009</a></td>
													<td>#09</td>
													<td>
														<h2 class="table-avatar">
															<a href="profile" class="avatar avatar-sm mr-2"><img class="avatar-img rounded-circle" src="../assets_admin/img/user/user8.jpg" alt="User Image"></a>
															<a href="profile">Walter Roberson</a>
														</h2>
													</td>
													<td>$100.00</td>
													<td class="text-center">
														<span class="badge badge-pill bg-success inv-badge">Paid</span>
													</td>
													<td class="text-right">
														<div class="actions">
															<a data-toggle="modal" href="#edit_invoice_report" class="btn btn-sm bg-success-light mr-2">
																<i class="fas fa-pencil-alt"></i> Edit
															</a>
															<a class="btn btn-sm bg-danger-light" data-toggle="modal" href="#delete_modal">
																<i class="far fa-trash-alt"></i> Delete
															</a>
														</div>
													</td>
												</tr>
												<tr>
													<td><a href="invoice">#IN0010</a></td>
													<td>#10</td>
													<td>
														<h2 class="table-avatar">
															<a href="profile" class="avatar avatar-sm mr-2"><img class="avatar-img rounded-circle" src="../assets_admin/img/user/user9.jpg" alt="User Image"></a>
															<a href="profile">Robert Rhodes </a>
														</h2>
													</td>
													<td>$120.00</td>
													<td class="text-center">
														<span class="badge badge-pill bg-success inv-badge">Paid</span>
													</td>
													<td class="text-right">
														<div class="actions">
															<a data-toggle="modal" href="#edit_invoice_report" class="btn btn-sm bg-success-light mr-2">
																<i class="fas fa-pencil-alt"></i> Edit
															</a>
															<a class="btn btn-sm bg-danger-light" data-toggle="modal" href="#delete_modal">
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
            <!-- Edit Details Modal -->
		<div class="modal fade" id="edit_invoice_report" aria-hidden="true" role="dialog">
			<div class="modal-dialog modal-dialog-centered" role="document" >
				<div class="modal-content">
					<div class="modal-header">
						<h5 class="modal-title">Edit Transactions</h5>
						<button type="button" class="close" data-dismiss="modal" aria-label="Close">
							<span aria-hidden="true">&times;</span>
						</button>
					</div>
					<div class="modal-body">
						<form>
							<div class="row form-row">
								<div class="col-12 col-sm-6">
									<div class="form-group">
										<label>Invoice Number</label>
										<input type="text" class="form-control" value="#INV-0001">
									</div>
								</div>
								<div class="col-12 col-sm-6">
									<div class="form-group">
										<label>Mentee ID</label>
										<input type="text" class="form-control" value="	#01">
									</div>
								</div>
								<div class="col-12 col-sm-6">
									<div class="form-group">
										<label>Mentee Name</label>
										<input type="text" class="form-control" value="Jonathan Doe">
									</div>
								</div>
								<div class="col-12 col-sm-6">
									<div class="form-group">
										<label>Mentee Image</label>
										<input type="file"  class="form-control">
									</div>
								</div>
								<div class="col-12 col-sm-6">
									<div class="form-group">
										<label>Total Amount</label>
										<input type="text"  class="form-control" value="$200.00">
									</div>
								</div>
								<div class="col-12 col-sm-6">
									<div class="form-group">
										<label>Created Date</label>
										<input type="text"  class="form-control" value="29th Oct 2019">
									</div>
								</div>
								
							</div>
							<button type="submit" class="btn btn-primary btn-block">Save Changes</button>
						</form>
					</div>
				</div>
			</div>
		</div>
		<!-- /Edit Details Modal -->

		<!-- Delete Modal -->
		<div class="modal fade" id="delete_modal" aria-hidden="true" role="dialog">
			<div class="modal-dialog modal-dialog-centered" role="document" >
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
		<!-- /Delete Modal -->	
@endsection