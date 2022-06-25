<?php $page = "Assessments"; ?>
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
             
       @if(in_array("manage_assessments",$permissions) || $user->type =="admin")    
        <a href="{{ route('assessment.index') }}" class="btn btn-sm btn btn-primary float-right mr-2 m-0">
        <span class="btn-inner--text ">{{__('Manage Forms')}}</span>
    </a>
       @endif
                   
                     </div>
                
   <!-- Breadcrumb -->
                <div class="breadcrumb-bar mb-3">
                    <div class="container-fluid">
                        <div class="row align-items-center">
                            <div class="col-md-12 col-12">
                                <h2 class="breadcrumb-title">Assessments Dashboard</h2>
                                <nav aria-label="breadcrumb" class="page-breadcrumb">
                                    <ol class="breadcrumb">
                                        <li class="breadcrumb-item"><a href="{{route('dashboard')}}">Dashboard</a></li>
                                        <li class="breadcrumb-item active" aria-current="page">Assessments Dashboard</li>
                                    </ol>
                                </nav>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- /Breadcrumb -->
                
   
    
        
    
      <div class="row blockWithFilter">
                    <div class="col-md-12 col-lg-3 dash-board-list blue">
                        <div class="dash-widget">
                            <div class="circle-bar">
                                <div class="icon-col">
                                    <i class="fas fa-list"></i>
                                </div>
                            </div>
                            <div class="dash-widget-info">
                             
                                  <h3 data-id="active">@if(!empty($active_assessments)){{ number_format($active_assessments, 0) }} @else {{__('0')}} @endif</h3>
                                <h6>Active</h6>															
                            </div>
                        </div>
                    </div>
                    <div class="col-md-12 col-lg-3 dash-board-list yellow">
                        <div class="dash-widget">
                            <div class="circle-bar">
                                <div class="icon-col">
                                    <i class="fa fa-forward"></i>
                                </div>
                            </div>
                            <div class="dash-widget-info">
                             
                                  <h3 data-id="sent">@if(!empty($sent_assessments)){{number_format($sent_assessments, 0)}} @else {{__('0')}} @endif</h3>
                                <h6>Sent</h6>															
                            </div>
                        </div>
                    </div>
                    
                    <div class="col-md-12 col-lg-3 dash-board-list pink">
                        <div class="dash-widget">
                            <div class="circle-bar">
                                <div class="icon-col">
                                    <i class="fa fa-dollar-sign"></i>
                                </div>
                            </div>
                            <div class="dash-widget-info">
                          
                                <h3 data-id="paid">@if(!empty($total_amount_paid))${{ number_format($total_amount_paid, 2) }} @else ${{__('0.00')}} @endif</h3>
                                <h6>Total Paid</h6>	
                                
                                
                            </div>
                        </div>
                    </div>
          @if(in_array("manage_assessments",$permissions) || $user->type =="admin")   
                    <div class="col-md-12 col-lg-3 dash-board-list green">
                        <div class="dash-widget">
                            <div class="circle-bar">
                                <div class="icon-col">
                                    <i class="fa fa-dollar-sign"></i>
                                </div>
                            </div>
                            <div class="dash-widget-info">
                          
                                <h3 data-id="earned">@if(!empty($total_amount_received))${{ number_format($total_amount_received, 2) }} @else ${{__('0.00')}} @endif</h3>
                                <h6>Total Earned</h6>	
                                
                                
                            </div>
                        </div>
                    </div>
          @else
          <div class="col-md-12 col-lg-3 dash-board-list green">
                        <div class="dash-widget">
                            <div class="circle-bar">
                                <div class="icon-col">
                                    <i class="fa fa-folder"></i>
                                </div>
                            </div>
                            <div class="dash-widget-info">
                                <h3 data-id="points">@if(!empty($earned_points)){{ ($earned_points) }} @else {{__('0')}} @endif</h3>
                                <h6>Points</h6>	
                                
                                
                            </div>
                        </div>
                    </div>
          @endif
                    
                </div>
   

   
<div class="row mt-3" id="blog_category_view"  >
     @if(in_array("manage_assessments",$permissions) || $user->type =="admin") 
          @php
                                 $googlemap_settings=\App\SiteSettings::getValByName('api_google_map_settings');
                               if((!empty($googlemap_settings['enable_google_map_key']) && $googlemap_settings['enable_google_map_key'] == 'on')){
                               $google_api_key=$googlemap_settings['google_map_key']??"";
                               }
                                 @endphp
                                 @if(!empty($google_api_key))
       <div class="col-12" id="data-holder" data-view="assessment dashboard">
 
                                </div>
                                 @endif
                              
       @endif
    
  <!-- list view -->
  <div class="col-12">
      <div class="card">
          <div class="card-body ">
              <form >
                        <div class="row">
                        <div class="form-group col-md-3  mb-2">
                           <div class="input-group input-group-sm input-group-merge input-group-flush">
            <div class="input-group-prepend">
                <span class="input-group-text bg-transparent"><i class="fas fa-search"></i></span>
            </div>
            <input type="text" id="support_keyword" class="form-control form-control-flush" placeholder="{{__('Search by form title.')}}">
        </div>
                        </div>
                        <div class="form-group col-md-3  mb-2">
                          <label for="filter_type" class="sr-only">Type</label>
                            <select id='filter_type' class="form-control" >
                                <option value="">All Type</option>
                                <option value="active">Active</option>
                                <option value="sent">Sent</option>
                            </select>
                        </div>
                            @if(!empty($categories) && count($categories)>0)
                        <div class="form-group col-md-3  mb-2">
                          <label for="filter_status" class="sr-only">Categories</label>
                            <select id='filter_category' class="form-control" style="width: 200px">
                                 <option value="">All Categories</option>
                                 @foreach($categories as $key => $val)
                                <option value="{{ $val->id }}">{{__($val->name)}}</option>
                                @endforeach
                            </select>
                        </div>
                            @endif
                        </div>
                                                   
                      </form>
              <div class="table_md-responsive">
                  <table class="table table-hover table-center mb-0" id="example" style="width:100% !important">
                     <thead class="thead-light">
                  <tr>
                                 <th > {{__('Sender')}}</th>
                            <th > {{__('Form')}}</th>
                            <th > {{__('Questions')}}</th>
                            <th > {{__('Responses')}}</th>
                            <th > {{__('Points')}}</th>
                            <th > {{__('Type')}}</th> 
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
@if(!empty($google_api_key))  
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-mousewheel/3.1.13/jquery.mousewheel.min.js"
            charset="utf-8"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/raphael/2.2.7/raphael.min.js" charset="utf-8"></script>
    <script src="{{ asset('public/assets/js/jquery.mapael.js') }}" charset="utf-8"></script>
    <script src="{{ asset('public/assets/js/maps/france_departments.js') }}" charset="utf-8"></script>
    <script src="{{ asset('public/assets/js/maps/world_countries.js') }}" charset="utf-8"></script>
    <script src="{{ asset('public/assets/js/maps/usa_states.js') }}" charset="utf-8"></script>
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

$(function () {
     var base_url = window.location.origin;
 

        $.get(
                base_url+"/state/map/dot/data",
        {view:$('#data-holder').data("view")},
                function (data) {
                    $("#data-holder").html(data.html);  
                  // locations=data.map;
                   // initialize();
                }
        );
   });
</script>
@endif
<script type="text/javascript">


    $(function () {
        var table = $('#example').DataTable({
            processing: true,
            serverSide: true,
             "bFilter": false,
             ajax: {
                        url: "{{ route('assessment.dashboard') }}",
                        data: function (d) {
                                d.filter_type = $('#filter_type').val()
                                d.filter_status = $('#filter_status').val()
                                d.filter_category = $('#filter_category').val()
                                d.keyword = $('#support_keyword').val()
                        }
                    },
            columns: [
//                {data: 'DT_RowIndex', name: 'DT_RowIndex', orderable: false, searchable: false},
                {data: 'sender', name: 'user', orderable: false, searchable: true},
                {data: 'form', name: 'subject', orderable: false, searchable: true},
                {data: 'question', name: 'category', orderable: false, searchable: true},
                {data: 'response', name: 'response', orderable: false, searchable: true},
                {data: 'points', name: 'points', orderable: false, searchable: true},
                {data: 'type', name: 'type', orderable: false, searchable: true},
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


