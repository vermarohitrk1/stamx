<?php $page = "Shop Brands"; ?>
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
                   
        <a  class="btn btn-sm btn btn-primary float-right ml-2 " href="{{ route('shopBrand.create') }}"  >
        <span class="btn-inner--icon"><i class="fa fa-plus"></i></span> {{__('Create Brand')}}
    </a>
        <a  class="btn btn-sm btn btn-primary float-right ml-2 " href="{{ route('shop.dashboard') }}"  >
        <span class="btn-inner--icon"><i class="fa fa-list"></i></span> {{__('Dashboard')}}
    </a>
        
   
       <a  class="btn btn-sm btn btn-primary float-right ml-2 " href="{{ route('shop.index') }}"  >
        <span class="btn-inner--icon"><i class="fa fa-reply"></i></span> 
    </a>
                   
                     </div>
                
   <!-- Breadcrumb -->
                <div class="breadcrumb-bar mb-3">
                    <div class="container-fluid">
                        <div class="row align-items-center">
                            <div class="col-md-12 col-12">
                                <h2 class="breadcrumb-title">Shop Brands</h2>
                                <nav aria-label="breadcrumb" class="page-breadcrumb">
                                    <ol class="breadcrumb">
                                        <li class="breadcrumb-item"><a href="{{route('dashboard')}}">Dashboard</a></li>
                                        <li class="breadcrumb-item"><a href="{{route('shop.dashboard')}}">Shop Dashboard</a></li>
                                        <li class="breadcrumb-item active" aria-current="page">Shop Brands</li>
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
            
              <div id="brand_view"></div>
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
  $(document).on("click", ".destroy_brand", function(){
    var id = $(this).attr('data-id');
    $("#brand_id").val(id);
    $('#destroy_brand').modal('show');
    }); 
   
   
      $(document).ready(function(){
    //getting view
    getView();
    $(document).on('click', '.pagination a', function (e) {
    var paginationUrl = 'page=' + $(this).attr('href').split('page=')[1];
    getView(paginationUrl);
    e.preventDefault();
    });
});


function getView(page=''){

        var viewUrl = "{{route('shopBrand.show')}}?" + page;
        $.ajax({
           url:viewUrl,
           success:function(data)
            {
            $('#brand_view').html(data);
            }
      }); 
}
    </script>  
@endpush


