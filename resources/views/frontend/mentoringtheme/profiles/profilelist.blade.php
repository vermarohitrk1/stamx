<?php $page="map-list";?>
@extends('layout.commonlayout')
@push('css')
<style>
    .content{ padding-top: 100px;}
    /* .col-xl-7.col-lg-12.order-md-last.order-sm-last.order-last.map-left {
    height: 450px;
    overflow: scroll;
} */
</style>
@endpush
@section('content')	
<!-- Page Content -->
<div class="content">
				<div class="container-fluid">

	            <div class="row">
					<div class="col-xl-7 col-lg-12 order-md-last order-sm-last order-last map-left">
				
						<div class="row align-items-center mb-4">
							<div class="col-md-6 col">
								<h4>2245 Mentees found</h4>
							</div>

							<div class="col-md-6 col-auto">
								<div class="view-icons">
									<a href="map-grid" class="grid-view"><i class="fas fa-th-large"></i></a>
									<a href="map-list" class="list-view active"><i class="fas fa-bars"></i></a>
								</div>
								<div class="sort-by d-sm-block d-none">
									<span class="sortby-fliter">
										<select class="select">
											<option>Sort by</option>
											<option class="sorting">Rating</option>
											<option class="sorting">Popular</option>
											<option class="sorting">Latest</option>
											<option class="sorting">Free</option>
										</select>
									</span>
								</div>
							</div>
						</div>
                        <div class="data-holder">
                            <!-- Mentor Widget -->
                            <div class="card">
                                <div class="card-body">
                                    <div class="mentor-widget">
                                        <div class="user-info-left">
                                            <div class="mentor-img">
                                                <a href="profile">
                                                    <img src="assets/img/user/user.jpg" class="img-fluid" alt="User Image">
                                                </a>
                                            </div>
                                            <div class="user-info-cont">
                                                <h4 class="usr-name"><a href="profile">Ruby Perrin</a></h4>
                                                <p class="mentor-type">Digital Marketer</p>
                                                <div class="rating">
                                                    <i class="fas fa-star filled"></i>
                                                    <i class="fas fa-star filled"></i>
                                                    <i class="fas fa-star filled"></i>
                                                    <i class="fas fa-star filled"></i>
                                                    <i class="fas fa-star"></i>
                                                    <span class="d-inline-block average-rating">(17)</span>
                                                </div>
                                                <div class="mentor-details">
                                                    <p class="user-location"><i class="fas fa-map-marker-alt"></i> Florida, USA</p>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="user-info-right">
                                            <div class="user-infos">
                                                <ul>
                                                    <li><i class="far fa-comment"></i> 17 Feedback</li>
                                                    <li><i class="fas fa-map-marker-alt"></i> Florida, USA</li>
                                                    <li><i class="far fa-money-bill-alt"></i> $300 - $1000 <i class="fas fa-info-circle" data-toggle="tooltip" title="Lorem Ipsum"></i> </li>
                                                </ul>
                                            </div>
                                            <div class="mentor-booking">
                                                <a class="apt-btn" href="booking">Book Appointment</a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!-- /Mentor Widget -->
                        </div>
							
					<div class="load-more text-center">
						<a class="btn btn-primary btn-sm" href="javascript:void(0);">Load More</a>	
					</div>
	            </div>
	            <!-- /content-left-->
	            <div class="col-xl-5 col-lg-12 map-right">
	                <div id="map" class="map-listing"></div>
	                <!-- map-->
	            </div>
	            <!-- /map-right-->
	        </div>
	        <!-- /row-->
</div>
</div>
            @php $google_api_key='';
                                 $googlemap_settings=\App\SiteSettings::getValByName('api_google_map_settings');
                               if((!empty($googlemap_settings['enable_google_map_key']) && $googlemap_settings['enable_google_map_key'] == 'on')){
                             
                                $google_api_key=$googlemap_settings['google_map_key']??"";
                               }
                                 @endphp	
@endsection
@push('script')

             
<script src="https://maps.googleapis.com/maps/api/js?key={{$google_api_key}}"></script>
<script>
    google.maps.visualRefresh = true;
var slider, infowindow = null;
var bounds = new google.maps.LatLngBounds();
var map, current = 0;
var locations =[];
    var icons = {
  'default':'{{ asset('assets/img/marker.png') }}'
};
var locations=[{
"id":01,
"doc_name":"Ruby Perrin",
"speciality":"Digital Marketer",
"address":"Florida, USA",
"next_available":"Available on Fri, 22 Mar",
"amount":"$300 - $1000",
"lat":53.470692,
"lng":-2.220328,
"icons":"default",
"profile_link":"profile.html",
"total_review":"17",
"image":'assets/img/user/user.jpg'
}];

</script>
<script src="{{ asset('js/map.js') }}" rel="javascript" type="text/javascript"></script>

@endpush