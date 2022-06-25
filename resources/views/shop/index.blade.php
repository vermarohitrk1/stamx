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
                       @if($user->type !="admin")
<!--        <a  class="btn btn-sm btn btn-primary float-right ml-2 " href="{{ route('shop.stripe.integration')}}"  >
        <span class="btn-inner--icon"><i class="fa fa-plus"></i></span> {{__('Stripe Integration')}}
    </a>-->
                       @endif
        <a  class="btn btn-sm btn btn-primary float-right ml-2 " href="{{ route('shopCategory.index')}}"  >
        <span class="btn-inner--icon"><i class="fa fa-plus"></i></span> {{__('Categories')}}
    </a>
        <a  class="btn btn-sm btn btn-primary float-right ml-2 " href="{{ route('shopBrand.index')}}"  >
        <span class="btn-inner--icon"><i class="fa fa-plus"></i></span> {{__('Brands')}}
    </a>
        <a  class="btn btn-sm btn btn-primary float-right ml-2 " href="{{ route('shop.create') }}"  >
        <span class="btn-inner--icon"><i class="fa fa-plus"></i></span> {{__('New Product')}}
    </a>
        
       @endif    
       <a  class="btn btn-sm btn btn-primary float-right ml-2 " href="{{ route('shop.dashboard') }}"  >
        <span class="btn-inner--icon"><i class="fa fa-reply"></i></span> 
    </a>
                   
                     </div>
                
   <!-- Breadcrumb -->
                <div class="breadcrumb-bar mb-3">
                    <div class="container-fluid">
                        <div class="row align-items-center">
                            <div class="col-md-12 col-12">
                                <h2 class="breadcrumb-title">Products List</h2>
                                <nav aria-label="breadcrumb" class="page-breadcrumb">
                                    <ol class="breadcrumb">
                                        <li class="breadcrumb-item"><a href="{{route('dashboard')}}">Dashboard</a></li>
                                        <li class="breadcrumb-item"><a href="{{route('shop.dashboard')}}">Shop Dashboard</a></li>
                                        <li class="breadcrumb-item active" aria-current="page">Products List</li>
                                    </ol>
                                </nav>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- /Breadcrumb -->
                
   

   
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
            <input type="text" id="support_keyword" class="form-control form-control-flush" placeholder="{{__('Search by title, sku..')}}">
        </div>
                        </div>
                        <div class="form-group col-md-3  mb-2">
                          <label for="filter_type" class="sr-only">All Type</label>
                            <select id='filter_type' class="form-control" >
                                <option value="">All Products</option>
                                <option value="Published">Published</option>
                                <option value="Unpublished">Unpublished</option>
                                <option value="stockout">Stock Out</option>
                                <option value="instock">In Stock</option>
                                <option value="free">Free</option>
                            </select>
                        </div>
                            
                        </div>
                                                   
                      </form>
              <div class="table_md-responsive">
                  <table class="table table-hover table-center mb-0" id="example" style="width:100% !important">
                     <thead class="thead-light">
                  <tr>
                                           <th class=" "> {{__('SKU')}}</th>
                                <th class=" "> {{__('Product')}}</th>
                                <th class=" "> {{__('Stock')}}</th>
                                <th class=" "> {{__('Status')}}</th>
                                <th class=" "> {{__('Revenue')}}</th>
                                <!--<th class=" "> {{__('Deal Discount')}}</th>-->
                                <th > {{__('Action')}}</th>
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
                        url: "{{ url('shop/products') }}",
                        data: function (d) {
                                d.filter_type = $('#filter_type').val()
                                d.filter_status = $('#filter_status').val()
                                d.filter_category = $('#filter_category').val()
                                d.keyword = $('#support_keyword').val()
                        }
                    },
            columns: [
//                {data: 'DT_RowIndex', name: 'DT_RowIndex', orderable: false, searchable: false},
                 {data: 'sku', name: 'sku',orderable: false,searchable: true},
            {data: 'title', name: 'title',orderable: false},
            {data: 'tags', name: 'tags',orderable: false},
            {data: 'status', name: 'status',orderable: false},
            {data: 'revenue', name: 'revenue',orderable: false},
//            {data: 'current_deal_off', name: 'current_deal_off',orderable: false},
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


