<?php $page = "search"; ?>
@extends('layout.commonlayout')
@section('content')		
<style>

.role_sec {
    text-transform: capitalize;
}
.mentor-img {

  
    height: 145px;
}

.user-avatar img {

    width: 200px;
}
.user-avatar {
    text-align: center;
}
</style>
<!-- Breadcrumb -->
<div class="breadcrumb-bar">
    <div class="container-fluid">
        <div class="row align-items-center">
            <div class="col-md-8 col-12">
                <h2 class="breadcrumb-title">Profiles</h2>
                <nav aria-label="breadcrumb" class="page-breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{url('/')}}">Home</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Search</li>
                    </ol>
                </nav>
            </div>
            <div class="col-md-4 col-12 d-md-block d-none">
                <div class="view-icons ">
                    <a  href="#" class="vieTypeBtn active" data-id="list"><i class="fas fa-bars"></i></a>
                    <a  href="#" class="vieTypeBtn " data-id="grid"><i class="fas fa-th-large"></i></a>
                    <!--<a href="#" class="vieTypeBtn " data-id="map"><i class="fas fa-map-marked-alt"></i></a>-->
                </div>
                <div class="sort-by">
                    <span class="sort-title">Sort by</span>
                    <span class="sortby-fliter">
                        <select class="select" id="sortby-fliter">
                            <option value="">Select</option>
                            <option class="sorting" value="average_rating">Rating</option>
                            <option class="sorting" value="state">State</option>
                            <option class="sorting" value="type">Profile Type</option>
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
                        <div class="filter-widget">
                            <div class="card-body">
                        <form class="search-form">
                            <div class="input-group">
                                <input type="text" id="s" placeholder="Search..." class="form-control" value="{{$search}}">
                                <div class="input-group-append">
                                    <button disabled="" type="submit" class="btn btn-primary"><i class="fa fa-search"></i></button>
                                </div>
                            </div>
                        </form>
                    </div>			
                        </div>
                        <div class="filter-widget">
                            <h4>Profile Type</h4>
                            @foreach($roles as $role)
                             <div>
                                <label class="custom_check role_sec">
                                    <input type="checkbox" name="checkbox_role" class="checkbox_role" value="{{$role}}" >
                                    <span class="checkmark"></span> {{$role}}
                                </label>
                            </div>
                            @endforeach
                            <div>
                                <label class="custom_check">
                                    <input type="checkbox" name="checkbox_role" class="checkbox_role" value="member" >
                                    <span class="checkmark"></span> Board Member
                                </label>
                            </div>
                            
                        </div>
                        <div class="filter-widget">
                            <h4>Gender</h4>
                            <div>
                                <label class="custom_check">
                                    <input type="checkbox" name="gender_type" class="gender_type" value="Male" >
                                    <span class="checkmark"></span> Male
                                </label>
                            </div>
                            <div>
                                <label class="custom_check">
                                    <input type="checkbox" name="gender_type"  class="gender_type"  value="Female" >
                                    <span class="checkmark"></span> Female
                                </label>
                            </div>
                        </div>
                        <div class="filter-widget">
                            <h4>Filter</h4>
                            <div>
                                <label class="custom_check">
                                    <input type="checkbox" name="filter_type" class="filter_type" value="instructor" >
                                    <span class="checkmark"></span> Instructors
                                </label>
                            </div>
                            
                        </div>
                        <div class="filter-widget">
                            <h4>Rating</h4>
                            <div>
                                <label class="custom_check">
                                    <input type="checkbox" name="checkbox_rating" class="checkbox_rating" value="5" >
                                    <span class="checkmark"></span> 
                                    <i class="fas fa-star text-warning "></i>
                                    <i class="fas fa-star text-warning "></i>
                                    <i class="fas fa-star text-warning "></i>
                                    <i class="fas fa-star text-warning "></i>
                                    <i class="fas fa-star text-warning "></i> 
                                </label>
                            </div>
                            <div>
                                <label class="custom_check">
                                    <input type="checkbox" name="checkbox_rating" class="checkbox_rating" value="4" >
                                    <span class="checkmark"></span> 
                                    <i class="fas fa-star text-warning "></i>
                                    <i class="fas fa-star text-warning "></i>
                                    <i class="fas fa-star text-warning "></i>
                                    <i class="fas fa-star text-warning "></i> 
                                </label>
                            </div>
                            <div>
                                <label class="custom_check">
                                    <input type="checkbox" name="checkbox_rating" class="checkbox_rating" value="3" >
                                    <span class="checkmark"></span> 
                                    <i class="fas fa-star text-warning "></i>
                                    <i class="fas fa-star text-warning "></i>
                                    <i class="fas fa-star text-warning "></i> 
                                </label>
                            </div>
                            <div>
                                <label class="custom_check">
                                    <input type="checkbox" name="checkbox_rating" class="checkbox_rating" value="2" >
                                    <span class="checkmark"></span> 
                                    <i class="fas fa-star text-warning "></i>
                                    <i class="fas fa-star text-warning "></i> 
                                </label>
                            </div>
                            <div>
                                <label class="custom_check">
                                    <input type="checkbox" name="checkbox_rating" class="checkbox_rating" value="1" >
                                    <span class="checkmark"></span> 
                                    <i class="fas fa-star text-warning "></i> 
                                </label>
                            </div>
                    
                           
                        </div>
                        
                       	
                    </div>
                </div>
                <!-- /Search Filter -->

            </div>
              @php
                                 $googlemap_settings=\App\SiteSettings::getValByName('api_google_map_settings');
                               if((!empty($googlemap_settings['enable_google_map_key']) && $googlemap_settings['enable_google_map_key'] == 'on')){
                               $google_api_key=$googlemap_settings['google_map_key']??"";
                               }
                                 @endphp
             @if(!empty($google_api_key))                    
             <div class="col-md-12 col-lg-8 col-xl-9" >
            <div class="row">
	            <div class="col-md-7 " id="data-holder">
                        </div>
                    <div class="col-md-4 map-right " style="top: 150px !important">
	                <div id="map" class="map-listing" ></div>
	                
	            </div>
            </div>
            </div> 
            <div class="col-md-12 col-lg-8 col-xl-9" id="data-holder">
                  </div>
             @else
             <div class="col-md-12 col-lg-8 col-xl-9" id="data-holder">
                  </div>
             @endif
            
             
        </div>

    </div>

</div>		
<!-- /Page Content -->
@endsection

@push('script')
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-mousewheel/3.1.13/jquery.mousewheel.min.js"
            charset="utf-8"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/raphael/2.2.7/raphael.min.js" charset="utf-8"></script>
    <script src="{{ asset('public/assets/js/jquery.mapael.js') }}" charset="utf-8"></script>
    <script src="{{ asset('public/assets/js/maps/france_departments.js') }}" charset="utf-8"></script>
    <script src="{{ asset('public/assets/js/maps/world_countries.js') }}" charset="utf-8"></script>
    <script src="{{ asset('public/assets/js/maps/usa_states.js') }}" charset="utf-8"></script>
    
@if(!empty($google_api_key))  

<script src="https://maps.googleapis.com/maps/api/js?key={{$google_api_key}}"></script>
<script src="{{ asset('js/map.js') }}"></script>
<script>
    google.maps.visualRefresh = true;
var slider, infowindow = null;
var bounds = new google.maps.LatLngBounds();
var map, current = 0;
var locations =[];
    var icons = {
  'default':'{{ asset('assets/img/marker.png') }}'
};
</script>
@endif
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
    $(".vieTypeBtn").click(function () {    
        $(".vieTypeBtn").removeClass('active');
        $(this).addClass('active');
        $(".fa-bars").show();
    filter();
    });
    $(".checkbox_role").click(function () {        
    filter();
    });
    $(".gender_type").click(function () {        
    filter();
    });
    $(".filter_type").click(function () {        
    filter();
    });
    $(".checkbox_rating").click(function () {        
    filter();
    });
   
    $("#sortby-fliter").change(function () {        
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
    var roleFilter = [];
     $.each($("input[name='checkbox_role']:checked"), function(){
                  roleFilter.push($(this).val());
            });
    var genderFilter = [];
     $.each($("input[name='gender_type']:checked"), function(){
                  genderFilter.push($(this).val());
            });
    var instructorFilter = [];
     $.each($("input[name='filter_type']:checked"), function(){
                  instructorFilter.push($(this).val());
            });
    var ratingFilter = [];
     $.each($("input[name='checkbox_rating']:checked"), function(){
                  ratingFilter.push($(this).val());
            });
  
   
            
    var data = {
    search: search,
            role: roleFilter,
            gender: genderFilter,
            rating: ratingFilter,
            type: instructorFilter,
            sortby: sortby,
            viewtype: $('a.vieTypeBtn.active').data('id'),
            _token: "{{ csrf_token() }}",
    }
    $.post(
            "{{route('profiles.filter')}}?" + page,
            data,
            function (data) {
            $("#data-holder").html(data.html);
            $(".pagify-pagination").remove();


@if(!empty($google_api_key))  
locations=data.map;
initialize();
@endif
            }
    );
    }
</script>


<script type="text/javascript">



    function ManageFavourite(id,type) {
        if (id != "") {
            var data = {
                id: id,
                type: type
            }
            $.ajax({
                url: '{{ route('users.change.favourite') }}',
                data: data,
                success: function (data) {
                filter();
                    show_toastr('Success!', "Favourite Marked!", 'success');
                }
            });
        }
    }
    function Managelike(id,type) {
        if (id != "") {
            var data = {
                id: id,
                type: type
            }
            $.ajax({
                url: '{{ route('users.change.like') }}',
                data: data,
                success: function (data) {
                filter();
                    show_toastr('Success!', "Liked!", 'success');
                }
            });
        }
    }

</script> 
@endpush