<?php $page = "Petitions"; ?>
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
             
       @if(in_array("manage_petitions",$permissions) || $user->type =="admin")    
        <a href="{{ route('petitioncustom.index') }}" class="btn btn-sm btn btn-primary float-right mr-2 m-0">
        <span class="btn-inner--text ">{{__('Manage Petitions')}}</span>
    </a>
       @endif
        <a href="{{ route('user.petition.invoices') }}" class="btn btn-sm btn btn-primary float-right mr-2 m-0">
        <span class="btn-inner--text ">{{__('Donation Payments')}}</span>
    </a>
                   
                     </div>
                
   <!-- Breadcrumb -->
                <div class="breadcrumb-bar mb-3">
                    <div class="container-fluid">
                        <div class="row align-items-center">
                            <div class="col-md-12 col-12">
                                <h2 class="breadcrumb-title">Petitions Dashboard</h2>
                                <nav aria-label="breadcrumb" class="page-breadcrumb">
                                    <ol class="breadcrumb">
                                        <li class="breadcrumb-item"><a href="{{route('dashboard')}}">Dashboard</a></li>
                                        <li class="breadcrumb-item active" aria-current="page">Petitions Dashboard</li>
                                    </ol>
                                </nav>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- /Breadcrumb -->
                
   
    
    @if(in_array("manage_petitions",$permissions) || $user->type =="admin")       
    
      <div class="row blockWithFilter">
          
                    <div class="col-md-12 col-lg-4 dash-board-list blue">
                        <div class="dash-widget">
                            <div class="circle-bar">
                                <div class="icon-col">
                                    <i class="fas fa-list"></i>
                                </div>
                            </div>
                            <div class="dash-widget-info">
                             
                                  <h3 data-id="petitions">@if(!empty($my_total_forms)){{ number_format($my_total_forms, 0) }} @else {{__('0')}} @endif</h3>
                                <h6>Petitions</h6>															
                            </div>
                        </div>
                    </div>
                    
                    
                    <div class="col-md-12 col-lg-4 dash-board-list green">
                        <div class="dash-widget">
                            <div class="circle-bar">
                                <div class="icon-col">
                                    <i class="fas fa-users"></i>
                                </div>
                            </div>
                            <div class="dash-widget-info">
                          
                                <h3 data-id="supporters">@if(!empty($total_responses)){{ number_format($total_responses, 0) }} @else {{__('0')}} @endif</h3>
                                <h6>Supporters</h6>	
                                
                                
                            </div>
                        </div>
                    </div>
                    <div class="col-md-12 col-lg-4 dash-board-list yellow">
                        <div class="dash-widget">
                            <div class="circle-bar">
                                <div class="icon-col">
                                    <i class="fa fa-folder"></i>
                                </div>
                            </div>
                            <div class="dash-widget-info">
                                <h3 data-id="folders">@if(!empty($total_folders)){{ count($total_folders) }} @else {{__('0')}} @endif</h3>
                                <h6>Folders</h6>	
                                
                                
                            </div>
                        </div>
                    </div>
                </div>
   

   @endif
<div class="row mt-3" id="blog_category_view"  >
       @if(in_array("manage_petitions",$permissions) || $user->type =="admin") 
          @php
                                 $googlemap_settings=\App\SiteSettings::getValByName('api_google_map_settings');
                               if((!empty($googlemap_settings['enable_google_map_key']) && $googlemap_settings['enable_google_map_key'] == 'on')){
                               $google_api_key=$googlemap_settings['google_map_key']??"";
                               }
                                 @endphp
                                 @if(!empty($google_api_key))
       <div class="col-12" id="data-holder" data-view="petition dashboard">
 
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
                                <option value="fill">Filled</option>
                                <option value="notfill">Not Filled</option>
                            </select>
                        </div>
                            @if(!empty($total_folders) && count($total_folders)>0)
                        <div class="form-group col-md-3  mb-2">
                          <label for="filter_status" class="sr-only">Folders</label>
                            <select id='filter_category' class="form-control" style="width: 200px">
                                 <option value="">All Folders</option>
                                 @foreach($total_folders as $key => $val)
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
                            <th > {{__('Petition')}}</th>
                            <th > {{__('Folder')}}</th>
                            <th > {{__('Tags')}}</th>
                            <th > {{__('Supporters')}}</th>
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
                        url: "{{route('petitioncustom.public')}}",
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
                {data: 'category', name: 'category', orderable: false, searchable: true},
                {data: 'question', name: 'category', orderable: false, searchable: true},
                {data: 'response', name: 'response', orderable: false, searchable: true},
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


