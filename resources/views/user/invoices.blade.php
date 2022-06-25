<?php $page = "Invoices"; ?>
@extends('layout.dashboardlayout')
@section('content')	


<!-- Page Content -->
<div class="content">
    <div class="container-fluid">

        <div class="row">
            <div class="col-md-5 col-lg-4 col-xl-3 theiaStickySidebar">

                <!-- Sidebar -->
                      @include('layout.partials.userSideMenu')
                <!-- /Sidebar -->

            </div>

            <div class="col-md-7 col-lg-8 col-xl-9">
                
   <!-- Breadcrumb -->
                <div class="breadcrumb-bar mb-3">
                    <div class="container-fluid">
                        <div class="row align-items-center">
                            <div class="col-md-12 col-12">
                                <h2 class="breadcrumb-title">Invoices</h2>
                                <nav aria-label="breadcrumb" class="page-breadcrumb">
                                    <ol class="breadcrumb">
                                        <li class="breadcrumb-item"><a href="{{route('dashboard')}}">Dashboard</a></li>
                                        <li class="breadcrumb-item active" aria-current="page">Invoice</li>
                                    </ol>
                                </nav>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- /Breadcrumb -->
                     @php
        $user=Auth::user();
        @endphp
                
<div class="row blockWithFilter">
                    <div class="col-md-12 col-lg-4 dash-board-list yellow">
                        <div class="dash-widget">
                            <div class="circle-bar">
                                <div class="icon-col">
                                    <i class="fas fa-list"></i>
                                </div>
                            </div>
                            <div class="dash-widget-info">
                             
                                 @php
                                $invoices = \App\UserPayment::where('paid_to_user_id',$user->id)->orwhere('user_id',$user->id)->count();
                                @endphp
                                
                                  <h3 data-id="invoices">{{!empty($invoices)?$invoices:0}}</h3>
                                <h6>Total Invoices</h6>															
                            </div>
                        </div>
                    </div>
                    
                    <div class="col-md-12 col-lg-4 dash-board-list pink">
                        <div class="dash-widget">
                            <div class="circle-bar">
                                <div class="icon-col">
                                    <i class="fas fa-wallet"></i>
                                </div>
                            </div>
                            <div class="dash-widget-info">
                                @php
                                $totalpaid = \App\UserPayment::where('user_id',$user->id)->sum('amount');
                                @endphp
                                <h3 data-id="paid">{{format_price(!empty($totalpaid)?$totalpaid:0)}}</h3>
                                <h6>Total Paid</h6>	
                                
                                
                            </div>
                        </div>
                    </div>
                    <div class="col-md-12 col-lg-4 dash-board-list green">
                        <div class="dash-widget">
                            <div class="circle-bar">
                                <div class="icon-col">
                                    <i class="fa fa-wallet"></i>
                                </div>
                            </div>
                            <div class="dash-widget-info">
                                @php
                                $earned = \App\UserPayment::where('paid_to_user_id',$user->id)->sum('amount');
                                @endphp
                                <h3 data-id="earned">{{format_price(!empty($earned)?$earned:0)}}</h3>
                                <h6>Total Earned</h6>	
                                
                                
                            </div>
                        </div>
                    </div>
                </div>
<div class="row mt-3" id="blog_category_view">
  
  <!-- list view -->
  <div class="col-12">
      <div class="card">
          <div class="card-body ">
              <form class="form-inline">
                        <div class="form-group mx-sm-3 mb-2">
                          <label for="filter_status" class="sr-only">Invoice Type</label>
                            <select id='filter_status' class="form-control" style="width: 200px">
                                <option value="">All Invoices</option>
                                <option value="1">Paid</option>
                                <option value="2">Received</option>
                            </select>
                        </div>
                                                   
                      </form>
              <div class="table_md-responsive">
                  <table class="table table-hover table-center mb-0" id="example">
                     <thead class="thead-light">
                      <tr>
                                        <th>INVOICE NO</th>
                                        <th>PAID TO</th>
                                        <th>PAID BY</th>
                                        <th>PAID ON</th>
                                        <th>AMOUNT</th>
                                        <th class="text-center"></th>

                                    </tr>
                      </thead>
                     
                  </table>
              </div>
          </div> 	
      </div>
  </div> 
    <!-- list view -->
</div>
    

            </div>
        </div>

    </div>

</div>		
<!-- /Page Content -->
@endsection
@push('script')

<script type="text/javascript">


    $(function () {
        var table = $('#example').DataTable({
             responsive: true,
            processing: true,
            serverSide: true,
             "bFilter": false,
             ajax: {
                        url: "{{ route('user.invoices') }}",
                        data: function (d) {
//                                d.filter_type = $('#filtertype').val()
                                d.filter_status = $('#filter_status').val()
                        }
                    },
            columns: [
//                {data: 'DT_RowIndex', name: 'DT_RowIndex', orderable: false, searchable: false},
                {data: 'order_id', name: 'order_id', orderable: true, searchable: true},
                {data: 'paidto', name: 'paidto', orderable: false, searchable: true},
                {data: 'paidby', name: 'paidby', orderable: false, searchable: true},
                {data: 'created_at', name: 'created_at', orderable: true, searchable: true},
                {data: 'amount', name: 'amount', orderable: false, searchable: true},
                {data: 'action', name: 'action', orderable: false},
            ]
        });
        $('#filter_status').change(function(){
                    table.draw();
                });
    
        });
</script> 

@endpush


