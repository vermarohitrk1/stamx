<?php $page = "search"; ?>
@extends('layout.commonlayout')
@section('content')		
	
<style>
.courses-img-main .img-fluid {
    max-width: 100%;
    height: 93px !important;
    object-fit: cover;
}
.text-sm {
    font-size: 15px !important;
}
 @media only screen and (max-width: 767px){
.courses-img-main img {
    height: 166px !important;
    object-fit: cover;
}
 }
</style>


<!-- Breadcrumb -->
<div class="breadcrumb-bar">
    <div class="container-fluid">
        <div class="row align-items-center">
            <div class="col-md-8 col-12">
                <nav aria-label="breadcrumb" class="page-breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{url('/')}}">Home</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Search Courses</li>
                    </ol>
                </nav>
            </div>
            <div class="col-md-4 col-12 d-md-block d-none">
                <div class="sort-by">
                    <span class="sort-title">Sort by</span>
                    <span class="sortby-fliter">
                        <select class="select" id="sortby-fliter">
                            <option value="">Select</option>
                            <option class="sorting" value="low">Price low to high</option>
                            <option class="sorting" value="high">Price high to low</option>
                            <option class="sorting" value="latest">Latest</option>
                            <option class="sorting" value="oldest">Oldest</option>
                        </select>
                    </span>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- /Breadcrumb -->

<!-- Page Content -->
<div class="content">
    <div class="container-fluid">

        <div class="row">
            <div class="col-md-12 col-lg-4 col-xl-3 theiaStickySidebar">

                <!-- Search Filter -->
                <div class="card search-filter">
                    <div class="card-header">
                        <h4 class="card-title mb-0">Search Filters</h4>
                    </div>
                    <div class="card-body">
                        <!-- Search -->
                <div class="card search-widget">
                    <div class="card-body">
                        <form class="search-form">
                            <div class="input-group">
<input type="text" id="s" placeholder="Search..." class="form-control">
                                <div class="input-group-append">
                                    <button disabled="" type="submit" class="btn btn-primary"><i class="fa fa-search"></i></button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
                <!-- /Search -->
                         @if($CertifyCategory->count() > 0)
                         <div class="filter-widget">
                            <h4>Categories</h4>
                            @foreach($CertifyCategory as $category)
                             <div>
                                <label class="custom_check">
                                    <input type="checkbox" name="category_check" id="checkbox_category_{{$category->id}}" class="checkbox_category" value="{{$category->id}}" >
                                    <span class="checkmark"></span> {{$category->name}}
                                </label>
                            </div>
                                @endforeach
                            
                        </div>
                                
                                @endif
                        
                        <div class="filter-widget">
                           <h4 class="card-title ">Type</h4>
                           <div>
                                <label class="custom_check">
                                    <input type="checkbox" name="checkbox_type" class="checkbox_type" value="free" >
                                    <span class="checkmark"></span> Free
                                </label>
                            </div>
                           <div>
                                <label class="custom_check">
                                    <input type="checkbox" name="checkbox_type" class="checkbox_type" value="board" >
                                    <span class="checkmark"></span> Board Certified
                                </label>
                            </div>
                           
                           
                        </div>

                    </div>
                </div>
                <!-- /Search Filter -->

            </div>

            <div class="col-md-12 col-lg-8 col-xl-9" id="data-holder">

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
    $(".checkbox_category").click(function () {        
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
     @if(!empty($search_category))
        var cat={{$search_category}};
    $( "#checkbox_category_"+cat ).trigger( "click" );
        @endif
    //pagination
    $(document).on('click', '.pagination a', function (e) {
    var paginationUrl = 'page=' + $(this).attr('href').split('page=')[1];
    filter(paginationUrl);
    e.preventDefault();
    });
    
    function filter(page = '') {
    var search = $("#s").val();
    var sortby = $("#sortby-fliter").val();
    var categoryFilter = [];
     $.each($("input[name='category_check']:checked"), function(){
                  categoryFilter.push($(this).val());
            });
  
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
            _token: "{{ csrf_token() }}",
    }
    $.post(
            "{{route('search.courses.filter')}}?" + page,
            data,
            function (data) {
            $("#data-holder").html(data);
            $(".pagify-pagination").remove();
            }
    );
    }
</script>
@endpush