<?php $page = "Shop"; ?>
@section('title')
    {{$page??''}}
@endsection
@extends('layout.dashboardlayout')
@section('content')	

     @php
        $user=Auth::user();
        $permissions=permissions();
        @endphp
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
                <div class=" col-md-12 ">      
                        @if(in_array("manage_shop",$permissions) || $user->type =="admin")    
        <a  class="btn btn-sm btn btn-primary float-right ml-2 " href="{{ route('shop.index')}}"  title="{{__('Products List
        ')}}">
        <span class="btn-inner--icon"><i class="fa fa-list"></i></span> {{__('Products List')}}
    </a>
                        @endif
                    
                   <a  class="btn btn-sm btn btn-primary float-right ml-2 " href="{{ route('shop')}}"  title="{{__('Shop
        ')}}">
        <span class="btn-inner--icon"><i class="fa fa-cart-plus"></i></span> {{__('Shop')}}
    </a>
                   
                     </div>
                
   <!-- Breadcrumb -->
                <div class="breadcrumb-bar mb-3">
                    <div class="container-fluid">
                        <div class="row align-items-center">
                            <div class="col-md-12 col-12">
                                <h2 class="breadcrumb-title">Shop Dashboard</h2>
                                <nav aria-label="breadcrumb" class="page-breadcrumb">
                                    <ol class="breadcrumb">
                                        <li class="breadcrumb-item"><a href="{{route('dashboard')}}">Dashboard</a></li>
                                        <li class="breadcrumb-item active" aria-current="page">Shop Dashboard</li>
                                    </ol>
                                </nav>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- /Breadcrumb -->
                
   
    
         @if(in_array("manage_shop",$permissions) || $user->type =="admin")   
    
      <div class="row blockWithFilter">
          <div class="col-md-12 col-lg-3 dash-board-list blue">
                        <div class="dash-widget">
                            <div class="circle-bar">
                                <div class="icon-col">
                                    <i class="fa fa-list"></i>
                                </div>
                            </div>
                            <div class="dash-widget-info">
                             
                                  <h3 data-id="myorders">@if(!empty($stats['my_orders'])){{ number_format($stats['my_orders'], 0) }} @else {{__('0')}} @endif </h3>
                                <h6>My Orders</h6>															
                            </div>
                        </div>
                    </div>
          <div class="col-md-12 col-lg-3 dash-board-list yellow">
                        <div class="dash-widget">
                            <div class="circle-bar">
                                <div class="icon-col">
                                    <i class="fa fa-cart-plus"></i>
                                </div>
                            </div>
                            <div class="dash-widget-info">
                             
                                  <h3 data-id="products">@if(!empty($stats['total_products'])){{ number_format($stats['total_products'], 0) }} @else {{__('0')}} @endif </h3>
                                <h6>Products</h6>															
                            </div>
                        </div>
                    </div>
          <div class="col-md-12 col-lg-3 dash-board-list pink">
                        <div class="dash-widget">
                            <div class="circle-bar">
                                <div class="icon-col">
                                    <i class="fa fa-forward"></i>
                                </div>
                            </div>
                            <div class="dash-widget-info">
                             
                                  <h3 data-id="sales">@if(!empty($stats['total_sales'])){{$stats['total_sales']}} @else {{__('0')}} @endif </h3>
                                <h6>Sales</h6>															
                            </div>
                        </div>
                    </div>
          <div class="col-md-12 col-lg-3 dash-board-list green">
                        <div class="dash-widget">
                            <div class="circle-bar">
                                <div class="icon-col">
                                    <i class="fa fa-dollar-sign"></i>
                                </div>
                            </div>
                            <div class="dash-widget-info">
                          
                                <h3 data-id="revenue">@if(!empty($stats['total_revenue']))
                                        ${{ number_format($stats['total_revenue'], 2) }} @else {{__('0')}} @endif</h3>
                                <h6>Revenue</h6>	
                                
                                
                            </div>
                        </div>
                    </div>

                    
                </div>
   
@endif
   
<div class="row mt-3" id="blog_category_view"  >
     
    
  <!-- list view -->
  <div class="col-12">
      <div class="card">
          <div class="card-body ">
              <form >
                        <div class="row">
                        <div class="form-group col-md-6  mb-2">
                           <div class="input-group input-group-sm input-group-merge input-group-flush">
            <div class="input-group-prepend">
                <span class="input-group-text bg-transparent"><i class="fas fa-search"></i></span>
            </div>
            <input type="text" id="support_keyword" class="form-control form-control-flush" placeholder="{{__('Search by title, order ID..')}}">
        </div>
                        </div>
                        <div class="form-group col-md-3  mb-2">
                          <label for="filter_type" class="sr-only">Filter</label>
                            <select id='filter_type' class="form-control" >
                                <option value="">All Orders</option>
                                <option value="Pending">Pending</option>
                                <option value="Shipped">Shipped</option>
                                <option value="Cancelled">Cancelled</option>
                                <option value="dropshipped">Drop Shipped</option>
                                <option value="dropshipping">Drop Shipping Received</option>
                            </select>
                        </div>
                            
                        </div>
                                                   
                      </form>
              <div class="table_md-responsive">
                  <table class="table table-hover table-center mb-0" id="example" style="width:100% !important">
                     <thead class="thead-light">
                  <tr>
                              <th class=" "> {{__('Buyer')}}</th>
                            <th class="name "> {{__('Order')}}</th>
                            <th class="name "> {{__('Product')}}</th>
                            <th class="name "> {{__('Price')}}</th>
                            <th class="name "> {{__('Delivery Status')}}</th>
                            <th class="name "> {{__('Order Date')}}</th>
                            <th class="name "> {{__('Payment Status')}}</th>
                            <th class="name "> {{__('Action')}}</th>
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
            processing: true,
            serverSide: true,
             "bFilter": false,
             ajax: {
                        url: "{{route('shop.public')}}",
                        data: function (d) {
                                d.filter_type = $('#filter_type').val()
                                d.filter_status = $('#filter_status').val()
                                d.filter_category = $('#filter_category').val()
                                d.keyword = $('#support_keyword').val()
                        }
                    },
            columns: [
//                {data: 'DT_RowIndex', name: 'DT_RowIndex', orderable: false, searchable: false},

                
                     {data: 'name', name: 'name', orderable: false, searchable: false},
            {data: 'order', name: 'order', orderable: false, searchable: false},
            {data: 'title', name: 'title', orderable: false, searchable: false},
            {data: 'amount', name: 'amount', orderable: false, searchable: false},
            {data: 'status', name: 'status', orderable: false, searchable: false},
            {data: 'created_at', name: 'created_at', orderable: false, searchable: false},
            {data: 'payment', name: 'payment', orderable: false, searchable: false},
            
            {
                data: 'action',
                name: 'action',
                orderable: false,
                searchable: false
            },
         
            ]
        });
        $('#filter_status').change(function(){
                    table.draw();
                });
        $('#filter_type').change(function(){
                    table.draw();
                });
        $('#filter_category').change(function(){
                    table.draw();
                });
                  $(document).on('keyup', '#support_keyword', function () {
            table.draw();
            });
    
        });
   
</script> 

@endpush


