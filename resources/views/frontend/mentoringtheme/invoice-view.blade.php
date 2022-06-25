<?php $page="invoices";?>
@extends('layout.commonlayout')
@section('content')	
<style>
	button#btnExport {
    float: right;
}
</style>	
<!-- Breadcrumb -->
<div class="breadcrumb-bar">
				<div class="container-fluid">
					<div class="row align-items-center">
						<div class="col-md-12 col-12">
							<h2 class="breadcrumb-title">Invoice</h2>
							<nav aria-label="breadcrumb" class="page-breadcrumb">
								<ol class="breadcrumb">
									<li class="breadcrumb-item"><a href="{{route('dashboard')}}">Home</a></li>
									<li class="breadcrumb-item active" aria-current="page">Invoice</li>
								</ol>
							</nav>
						</div>
					</div>
				</div>
			</div>
			<!-- /Breadcrumb -->
			<!-- Page Content -->
			<div class="content">
				<div class="container-fluid">
@php
   
	  $logo =  \App\SiteSettings::logoSetting();

        if(!empty($logo)){
           $logo_favicon = json_decode($logo->value,true);
        }else{
            $logo_favicon = array();
        }
@endphp

<button  id="btnExport" type="button" class="btn btn-primary ">
<i class="fa fa-download" aria-hidden="true"></i>

                Download
              </button>
					<div class="row">
				
						<div class="col-lg-8 offset-lg-2" id="tblCustomers">
							<div class="invoice-content">
								<div class="invoice-item">
									<div class="row">
										<div class="col-md-6">
											<div class="invoice-logo">
                                                                                        @if (!empty($logo_favicon['logo']))
                        <img src="{{ asset('storage/logo').'/'.$logo_favicon['logo'] }}"alt="Logo" >
                    @else
                    <h3 style="margin-top:15px !important;">Your Logo Here</h3>
                    @endif
											</div>
										</div>
										<div class="col-md-6">
											<p class="invoice-details">
												<strong>Order:</strong> #{{$data->order_id}} <br>
												<strong>Issued:</strong> {{date('d/m/Y',strtotime($data->created_at))}}
											</p>
										</div>
									</div>
								</div>
								
								<!-- Invoice Item -->
								<div class="invoice-item">
									<div class="row">
										<div class="col-md-6">
											<div class="invoice-info">
												<strong class="customer-text">Invoice From</strong>
												<p class="invoice-details invoice-details-two">
												{{$paymentto->name}} <br>
													{{$paymentto->address1}} , {{$paymentto->address2}} ,<br>
													{{$paymentto->state}},{{$paymentto->postal_code}}  , {{$paymentto->country}} <br>

												
												</p>
											</div>
										</div>
										<div class="col-md-6">
											<div class="invoice-info invoice-info2">
												<strong class="customer-text">Invoice To</strong>
												<p class="invoice-details">
												    {{$paymentfrom->name}} <br>
													{{$paymentfrom->address1}} , {{$paymentfrom->address2}} ,<br>
													{{$paymentfrom->state}},{{$paymentfrom->postal_code}}  , {{$paymentfrom->country}} <br></p>
											</div>
										</div>
									</div>
								</div>
								<!-- /Invoice Item -->
								
								<!-- Invoice Item -->
								<div class="invoice-item">
									<div class="row">
										<div class="col-md-12">
											<div class="invoice-info">
												<strong class="customer-text">Payment Method</strong>
												<p class="invoice-details invoice-details-two">
													{{ucfirst($data->payment_type)}} <br>
													XXXXXXXXXXXX-{{ucfirst($data->card_number)}} <br>
													
												</p>
											</div>
										</div>
									</div>
								</div>
								<!-- /Invoice Item -->
								
								<!-- Invoice Item -->
								<div class="invoice-item invoice-table-wrap">
									<div class="row">
										<div class="col-md-12">
											<div class="table-responsive">
												<table class="invoice-table table table-bordered">
													<thead>
														<tr>
															<th>Description</th>
															<th class="text-center">Quantity</th>
															<th class="text-center">VAT</th>
															<th class="text-right">Total</th>
														</tr>
													</thead>
													<tbody>
														<tr>
															<td>{{ucfirst($data->title)}}</td>
															<td class="text-center">{{$data->qty??1}}</td>
															<td class="text-center">$0</td>
															<td class="text-right">{{format_price($data->amount+$data->discount)}}</td>
														</tr>
														
													</tbody>
												</table>
											</div>
										</div>
										<div class="col-md-6 col-xl-4 ml-auto">
											<div class="table-responsive">
												<table class="invoice-table-two table">
													<tbody>
													<tr>
														<th>Subtotal:</th>
														<td><span>{{format_price($data->amount+$data->discount)}}</span></td>
													</tr>
													<tr>
														<th>Discount:</th>
														<td><span>-{{format_price($data->discount)}}%</span></td>
													</tr>
													<tr>
														<th>Net Total:</th>
														<td><span>{{format_price($data->amount)}}</span></td>
													</tr>
													</tbody>
												</table>
											</div>
										</div>
									</div>
								</div>
								<!-- /Invoice Item -->
								
								<!-- Invoice Information -->
								<div class="other-info">
									<h4>Other information</h4>
									
                                                                          <b>{!! html_entity_decode(($data->price_description), ENT_QUOTES, 'UTF-8') !!}</b>
                                            <p class="text-muted mb-0">{!! html_entity_decode(($data->other_description), ENT_QUOTES, 'UTF-8') !!}</p>
								</div>
								<!-- /Invoice Information -->
								
							</div>
						</div>
					</div>

				</div>
				

			</div>		
			<!-- /Page Content -->
@endsection
@push('script')
<script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/1.8.3/jquery.min.js"></script>
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.22/pdfmake.min.js"></script>
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/html2canvas/0.4.1/html2canvas.min.js"></script>
    <script type="text/javascript">
        $("body").on("click", "#btnExport", function () {
            html2canvas($('#tblCustomers')[0], {
                onrendered: function (canvas) {
                    var data = canvas.toDataURL();
                    var docDefinition = {
                        content: [{
                            image: data,
                            width: 500
                        }]
                    };
                    pdfMake.createPdf(docDefinition).download("Table.pdf");
                }
            });
        });
    </script>
	
@endpush