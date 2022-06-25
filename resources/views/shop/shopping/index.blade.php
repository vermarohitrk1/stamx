<?php $page = "Shop"; ?>
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
                
                
   <!-- Breadcrumb -->
                <div class="breadcrumb-bar mb-3">
                    <div class="container-fluid">
                         <h2 class="breadcrumb-title">Products List</h2>
                                   
                        <div class="row align-items-center">
                            <div class="col-md-6 col-12">
                               
                             
                                <form class="search-form">
                            <div class="input-group">
                                <input type="text" id="s" placeholder="Search by title..." class="form-control" value="">
                                <div class="input-group-append">
                                    
                   
                        <select class="form-control  btn btn-primary" id="productcategory">
                            <option value="">All Categories</option>
                            @if(!empty($categories) && count($categories))
                             @foreach($categories as $cat)
                            <option  value="{{$cat->id}}">{{$cat->name}}</option>
                              @endforeach
                              @endif
                        </select>
                   
           
                                </div>
                            </div>
                        </form>
                                   
                            </div>
                <div class="col-md-6  col-12 ">
                    <div class="btn-group float-right " style="margin-top: -60px !important">
  <button  type="button" class="ml-2 btn btn-primary dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
    <i class="fa fa-shopping-cart"></i> <sup class="text-warning cart_header_content_count" >0</sup>
  </button> 
                        <div class="dropdown-menu cart_header_content " style="height: 300px !important;  overflow-y: scroll !important;">
             
  </div>
</div>
                <div class="view-icons ">
                    <a  href="#" title="List View" class="vieTypeBtn" data-id="list"><i class="fas fa-bars"></i></a>
                    <a  href="#" title="Grid View" class="vieTypeBtn active" data-id="grid"><i class="fas fa-th-large"></i></a>
                    <!--<a   class="" title="View Cart" href="{{ route('shop.dashboard') }}"  ><i class="fa fa-shopping-cart"></i> <sup class="text-warning cart_header_content_count" >0</sup></a>-->     
                    
                </div>
                    
                <div class="sort-by">
                    <span class="sort-title">Sort by</span>
                    <span class="sortby-fliter">
                        <select class="select" id="sortby-fliter">
                            <option value="">Select</option>
                            <option class="sorting" value="average_rating">Rating</option>
                             <option class="sorting" value="low">Price low to high</option>
                            <option class="sorting" value="high">Price high to low</option>
                        </select>
                    </span>
                </div>
                    
            </div>
                        </div>
                         <nav aria-label="breadcrumb" class="page-breadcrumb">
                                    <ol class="breadcrumb">
                                        <li class="breadcrumb-item"><a href="{{route('dashboard')}}">Dashboard</a></li>
                                        <li class="breadcrumb-item"><a href="{{route('shop.dashboard')}}">Shop Dashboard</a></li>
                                        <li class="breadcrumb-item active" aria-current="page">Products List</li>
                                    </ol>
                                </nav>
                    </div>
          
                </div>
                <!-- /Breadcrumb -->
                
   

   
<div class="row mt-3" id="blog_category_view"  >
     
    
  <!-- list view -->
  <div class="col-12">
       <div  id="data-holder">
                  </div>
  </div> 
    <!-- list view -->
</div>
    
 <div class="modal fade" id="product-quickview" tabindex="-1" role="dialog" aria-labelledby="product-quickview" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content"><span class="modal-close" data-dismiss="modal"><i class="icon-cross2"></i></span>
                <article class="ps-product--detail ps-product--fullwidth ps-product--quickview" id="product_quick_view_model_body">
                    
                </article>
            </div>
        </div>
    </div>
            </div>
        </div>

    </div>
</div>		
<!-- /Page Content -->
@endsection
@push('script')
<script>
    $(function () {

    var search = '';
    var category = 'All';
    var time = '';
    filter();
    });
    $("#s").keyup(function () {
    filter();
    });   
    $("#productcategory").change(function () {        
    filter();
    });
//    $(".checkbox_time").click(function () {        
//    filter();
//    });
    $(".checkbox_rating").click(function () {        
    filter();
    });
    $(".checkbox_type").click(function () {        
    filter();
    });
    $("#sortby-fliter").change(function () {        
    filter();
    });
   $(".vieTypeBtn").click(function () {    
        $(".vieTypeBtn").removeClass('active');
        $(this).addClass('active');
        $(".fa-bars").show();
    filter();
    });
    //pagination
    $(document).on('click', '.pagination a', function (e) {
    var paginationUrl = 'page=' + $(this).attr('href').split('page=')[1];
    filter(paginationUrl);
    e.preventDefault();
    });
    

    function filter(page = '') {
    var search = $("#s").val();
    var sortby = $("#sortby-fliter").val();
    var categoryFilter = $("#productcategory").val();
  
//    var timeFilter = [];
//     $.each($("input[name='checkbox_time']:checked"), function(){
//                  timeFilter.push($(this).val());
//            });
            
    var typeFilter = [];
     $.each($("input[name='checkbox_type']:checked"), function(){
                  typeFilter.push($(this).val());
            });
            
    var data = {
    search: search,
            category: categoryFilter,
//            time: timeFilter,
            type: typeFilter,
            sortby: sortby,
            view: $('a.vieTypeBtn.active').data('id'),
            _token: "{{ csrf_token() }}",
    }
    $.post(
            "{{route('shop')}}?" + page,
            data,
            function (data) {
            $("#data-holder").html(data);
            $(".pagify-pagination").remove();
            }
    );
    }
    
    
    function quick_view_product(id=0){
    // AJAX request
   $.ajax({
    url: '{{route('shop.product.quick.view')}}',
    type: 'post',
    data: {_token: "{{ csrf_token() }}",id: id},
    success: function(response){ 
      // Add response in Modal body
      $('#product_quick_view_model_body').html(response);

      // Display Modal
      $('#product-quickview').modal('show'); 
    }
  });
 }
 
  $(function () {
         product_add_cart();
        
    });
 function product_add_cart(id=0,type=null,param=null){
    
   $.ajax({
    url: '{{route('shop.product.cart.add')}}',
    type: 'post',
      datatype: 'html',
     data: {_token: "{{ csrf_token() }}",id:id,type:type,param:param},
    success: function(res){ 
        $(".cart_header_content").html(res.html);
        $(".cart_header_content_count").html(res.count);
        if(id !=0){
              show_toastr('Done!', "Cart updated", 'success');
     
  }
    }
  });
 }
</script>
@endpush


