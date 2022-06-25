<?php $page = "blog"; ?>
@extends('layout.dashboardlayout')
@section('content')	
<style>
   .table > thead > tr > th {
   text-transform: capitalize!important;
   }
   .blue-btn-radius {
   padding: 8px 8px!important;
   }
   .blue-btn-radius {
   font-size: 12px!important;
   }
</style>
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
               <a href="{{ route('dashboard') }}" class="btn btn-sm btn-primary float-right btn-icon-only rounded-circle " >
               <span class="btn-inner--icon"><i class="fas fa-reply"></i></span>
               </a>
            </div>
            <!-- Breadcrumb -->
            <div class="breadcrumb-bar mt-3">
               <div class="container-fluid">
                  <div class="row align-items-center">
                     <div class="col-md-12 col-12">
                        <h2 class="breadcrumb-title">Program Form</h2>
                        <nav aria-label="breadcrumb" class="page-breadcrumb">
                           <ol class="breadcrumb">
                              <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Home</a></li>
                              <li class="breadcrumb-item active" aria-current="page">Program form</li>
                           </ol>
                        </nav>
                     </div>
                  </div>
               </div>
            </div>
            <!-- /Breadcrumb -->
            <div class="card">
               <div class="card-body">
                  <div class="mentor-widget">
                     <ul class="experience-list profile-custom-list" style="width:50%;">
                        <li>
                           <div class="experience-content">
                              <div class="timeline-content">
                                 <span>Title</span>
                                 <div class="row-result">{{ $data->title }}</div>
                              </div>
                           </div>
                        </li>
                        <li>
                           <div class="experience-content">
                              <div class="timeline-content">
                                 <span>Price</span>
                                 <div class="row-result"> ${{ $data->price }}</div>
                              </div>
                           </div>
                        </li>
                        <li>
                           <div class="experience-content">
                              <div class="timeline-content">
                                 <span>Company</span>
                                 <div class="row-result">     @php


                                         $users = $data->user->company;
                                        if($users == null){
                                            echo "not available";
                                        }
                                        else{
                                            echo $users;
                                        }
                                       @endphp
                                  </div>
                              </div>
                           </div>
                        </li>
                     </ul>
                     @if($data->status == 0)
                     <div class="user-info-right align-items-end flex-wrap">
                        <div class="hireme-btn text-center">
                           <a class="blue-btn-radius" data-url="@php echo route('audit.report', encrypted_key($data->id, "encrypt")) @endphp" data-ajax-popup="true" data-size="md" data-title="Request Audit Report" href="#">
                           Request Audit Report</a>
                        </div>
                     </div>
                     @endif
                  </div>
               </div>
            </div>
            @if($data->status == 1)
            <!-- upload form -->
            <div class="row">
               <div class=" col-md-4 ">
                  <label>
                     <div class="experience-content">
                        <div class="timeline-content">
                           <span>Import Audit Report</span>
                        </div>
                     </div>
                  </label>
                  <button class="btn btn-sm btn-white btn-icon-only rounded-circle ml-1 import_audit" data-toggle="tooltip" data-original-title="{{__('Import Audit Report')}}">
                  <span class="btn-inner--icon"><i class="fas fa-upload"></i></span>   
                  </button>
               </div>
               <div class=" col-md-4 ">
               <a class="btn btn-sm bg-success-light" data-url="@php echo route('audit.update', encrypted_key($data->id, "encrypt")) @endphp" data-ajax-popup="true" data-size="md" data-title="Edit Question" href="#">
                  <label>
                     <div class="experience-content">
                        <div class="timeline-content">
                           <span>Add Audit Report</span>
                        </div>
                     </div>
                  </label>
                
                                                
                                                    
                                                </a>
               </div>
               <div class=" col-md-4 ">
                  <label for="downloadcsv">
                     <div class="experience-content">
                        <div class="timeline-content">
                           <span>Download Sample</span>
                        </div>
                     </div>
                  </label>
                  <a id="downloadcsv" href="{{ asset('public') }}/csv/reports.csv" class="btn btn-sm btn-white btn-icon-only rounded-circle ml-1"   target="_blank" data-toggle="tooltip" data-original-title="{{__('Download Sample')}}">
                  <span class="btn-inner--icon"><i class="fas fa-download"></i></span>
                  </a>
               </div>
            </div>
            <!--upload form--->
            @endif
            @if($data->audit_report != null)
            <!-- chart -->
            <!--chart--->
            <div class="row">
               <div class="col-md-9 col-lg-9">
                 
                  <div class="card-body" style>
                          @if($erordate)
                        <span>csv format is incorrect. Please check it</span>
                        @else
                      <div class="table-responsive">
                        <table class="table table-hover table-center mb-0">
                           <thead>
                              <tr>
                                 <!--<th scope="col">City</th>-->
                                 <th scope="col">State</th>
                                 <th scope="col">Participants</th>
                                 <th scope="col">Per Participant Cost ($)</th>
                                 <th scope="col">Date</th>
                                 <th scope="col">Method</th>
                                 <!--<th scope="col">Framework</th>-->
                              </tr>
                           </thead>
                           <tbody>
                              @foreach($graphictable as $key => $table)
                              <tr>
                                 <!--<td >{{ $table['city']??'' }}</td>-->
                                 <td>{{ $table['state'] }}</td>
                                 <td>(M:{{$table['male_participants']??0}},F:{{$table['female_participants']??0}},O:{{$table['other_participants']??0}})/T:{{ $table['participants'] }}</td>
                                 <td>{{ !empty($table['participant_cost']) ? format_price($table['participant_cost']):0.00 }}</td>
                                 <td>{{ $table['date'] }}</td>
                                 <td>{{ $table['method'] }}</td>
                                 <!--<td>{{ $table['framework']??""  }}</td>-->
                              </tr>
                              @endforeach
                           </tbody>
                        </table>
                     </div>
                        @endif
                     
                  </div>
               </div>
               <div class="col-md-3 col-lg-3">
                  <div class="card flex-fill">
                     <div class="card-header">
                        <h5 class="card-title mb-0"><strong>12 Month Historical</strong></h5>
                     </div>
                  </div>
                  <div class="card flex-fill">
                     <div class="card-header">
                        <h5 class="card-title mb-0"># OF PARTICIPANTS</h5>
                     </div>
                     <div class="card-body">
                        <p class="card-text">   @php $num = 0;  foreach($graphictable as $key => $table){  $num += intval($table['participants']); }  echo $num;  @endphp</p>
                     </div>
                  </div>
                  <div class="card flex-fill">
                     <div class="card-header">
                        <h5 class="card-title mb-0">NUMBER OF STATE</h5>
                     </div>
                     <div class="card-body">
                        <p class="card-text">{{ $statecount }}</p>
                     </div>
                  </div>
                   <div class="card flex-fill">
                     <div class="card-header">
                        <h5 class="card-title mb-0">AVERAGE PRICE</h5>
                     </div>
                     <div class="card-body">
                        <p class="card-text">$181</p>
                     </div>
                  </div> 
               </div>
            </div>
            @endif
            <div class="row mt-3" id="blog_view">
               <div class="col-12">
                  <div class="card">
                     <div class="card-body p-0">
                        <div class="card-body">
                           <div class="accordion" id="accordionExample">
                              <?php
                                 // print_r(json_decode($data->data,true));
                                 $i = 0;
                                  foreach(json_decode($data->data,true) as $key => $result){ 
                                  if( $key == 'title'){
                                                               echo '<h3>Title : '.$result.'</h3>';
                                                             }
                                                             else{ 
                                                                 if(isset($questions[$key])){
                                                                 
                                                                 ?>
                              <div class="card">
                                 <div class="card-header" id="headingOne">
                                    <h2 class="mb-0">
                                       <button class="btn btn-link" type="button" data-toggle="collapse" data-target="#collapseOne<?php echo $i; ?>" aria-expanded="false" aria-controls="collapseOne<?php echo $i; ?>">
                                       <?php $num = $i+1; echo "Q".$num.") ".$questions[$key]; ?>
                                       </button>
                                    </h2>
                                 </div>
                                 <div id="collapseOne<?php echo $i; ?>" class="collapse @if($i == 0) show @endif" aria-labelledby="headingOne" data-parent="#accordionExample">
                                    <div class="card-body">
                                       <?php if(is_array($result)){ ?>
                                       <?php  foreach($result as $key => $res){ ?>
                                       <?php echo $key+1 .") ".$res."</br>"; ?>
                                       <?php } }
                                          else{
                                              echo $result;
                                          } ?>    
                                    </div>
                                 </div>
                              </div>
                              <?php $i++; } } } ?>
                           </div>
                        </div>
                     </div>
                  </div>
                  <div class="card card-chart">
                     <div class="card-header">
                        <h4 class="card-title">Report</h4>
                     </div>
                     <div class="card-body">
                        @if($erordate)
                        <span>csv format is incorrect. Please check it.</span>
                        @else
                        <div class="btn-group btn-group-justified btn-group-sm btn-group-lg float-right pull-right">
                            <div class="btn-group" role="group">
    <button id="btnGroupDrop1" type="button" class="btn btn-primary  btn-group-lg dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
      Graph Type
    </button>
    <div class="dropdown-menu" aria-labelledby="btnGroupDrop1">
         <a href="javascript:void(0)" data-id="Line"  class="dropdown-item gfilterbtn active" >Line Chart</a>
         <a href="javascript:void(0)" data-id="Area"  class="dropdown-item gfilterbtn" >Area Chart</a>     
         <a href="javascript:void(0)" data-id="Bar"  class="dropdown-item gfilterbtn" >Bar Chart</a>     
         <a href="javascript:void(0)" data-id="Donut"  class="dropdown-item gfilterbtn" >Donut Chart</a>     
    </div>
  </div>
                            @if(!empty($graphictable))
                            <div class="btn-group" role="group">
    <button id="btnGroupDrop1" type="button" class="btn btn-primary btn-xs btn-group-lg dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
      Filter
    </button>
    <div class="dropdown-menu" aria-labelledby="btnGroupDrop1">
         <a href="javascript:void(0)" data-id=""  class="dropdown-item pfilterbtn" >All</a>
         <a href="javascript:void(0)" data-id="males"  class="dropdown-item pfilterbtn" >Males Vs Total</a>
         <a href="javascript:void(0)" data-id="females"  class="dropdown-item pfilterbtn" >Females Vs Total</a>
         <a href="javascript:void(0)" data-id="others"  class="dropdown-item pfilterbtn" >Others Vs Total</a>
         <a href="javascript:void(0)" data-id="roi"  class="dropdown-item pfilterbtn" >Calculate ROI</a>
         <a href="javascript:void(0)" data-id="program"  class="dropdown-item pfilterbtn" >Program Cost</a>
<!--        @foreach((array_column($graphictable,'participants')) as  $table)
      <a href="javascript:void(0)" data-id="{{ $table }}"  class="dropdown-item pfilterbtn" >{{ $table }} or less</a>
      @endforeach-->
    </div>
  </div>
                            @endif
<!--                            @if(!empty($graphictable))
                            <div class="btn-group" role="group">
    <button id="btnGroupDrop1" type="button" class="btn btn-primary btn-xs btn-group-lg dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
      Cities
    </button>
    <div class="dropdown-menu" aria-labelledby="btnGroupDrop1">
         <a href="javascript:void(0)" data-id=""  class="dropdown-item cityfilterbtn" >All</a>
        @foreach($graphictable as $key => $table)
      <a href="javascript:void(0)" data-id="{{ $table['city']??'' }}"  class="dropdown-item cityfilterbtn" >{{ $table['city']??'' }}</a>
      @endforeach
    </div>
  </div>
                            @endif-->
                            @if(!empty($graphictable))
                            <div class="btn-group" role="group">
    <button id="btnGroupDrop1" type="button" class="btn btn-primary btn-xs btn-group-lg dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
      Method
    </button>
    <div class="dropdown-menu" aria-labelledby="btnGroupDrop1">
         <a href="javascript:void(0)" data-id=""  class="dropdown-item methodfilterbtn" >All</a>
       
      <a href="javascript:void(0)" data-id="online"  class="dropdown-item methodfilterbtn" >Online</a>
      <a href="javascript:void(0)" data-id="onsite"  class="dropdown-item methodfilterbtn" >Onsite</a>
     
    </div>
  </div>
                            @endif
                            @if(!empty($graphictable))
                            <div class="btn-group" role="group">
    <button id="btnGroupDrop1" type="button" class="btn btn-primary btn-xs btn-group-lg dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
      States
    </button>
    <div class="dropdown-menu" aria-labelledby="btnGroupDrop1">
         <a href="javascript:void(0)" data-id=""  class="dropdown-item statefilterbtn" >All</a>
        @foreach($graphictable as $key => $table)
      <a href="javascript:void(0)" data-id="{{ $table['state'] }}"  class="dropdown-item statefilterbtn" >{{ $table['state'] }}</a>
      @endforeach
    </div>
  </div>
                            @endif
                            
                            <a href="javascript:void(0)" data-id="-1"  class="btn btn-primary btn-xs datafilterbtn">1M</a>
                        <a href="javascript:void(0)" data-id="-3" class="btn btn-primary btn-xs datafilterbtn">3M</a>
                        <a href="javascript:void(0)" data-id="-6" class="btn btn-primary btn-xs datafilterbtn">6M</a>
                        <a href="javascript:void(0)" data-id="-12" class="btn btn-primary btn-xs datafilterbtn">1Y</a>
                        <a href="javascript:void(0)" data-id="" class="btn btn-primary btn-xs datafilterbtn">All Duration</a>
                      </div>
                 
                        <hr>
                         <div id="graph"></div>
                        @endif
                       
                     </div>
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
<link rel="stylesheet" type="text/css" href="{{ asset('assets/css/simcify.min.css') }}">
<link rel="stylesheet" type="text/css" href="{{ asset('public/assets_admin/plugins/morris/morris.css') }}">
<script src="{{ asset('assets/js/simcify.min.js') }}"></script>
<link rel="stylesheet" type="text/css" href="{{ asset('assets/libs/dropify/css/dropify.min.css') }}">
<script src="{{ asset('assets/libs/dropify/js/dropify.min.js') }}"></script>
<script src="{{ asset('public/ckeditor/ckeditor.js') }}"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/raphael/2.1.2/raphael-min.js"></script>
<script src="{{ asset('public/assets_admin/plugins/morris/morris.min.js') }}"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/12.1.3/js/intlTelInput.min.js"></script>
<script type="text/javascript" src="https://js.stripe.com/v2/"></script>
<script type="text/javascript">
   $(document).on("click", ".import_audit", function(){
       $('#import_divaudit').modal('show');
       $('#programIds').val("{{ $data->id }}");
   
   });
   
//   console.log("hi");
//   
//   Morris.Area({
//     element: 'graph',
//     data: {!!json_encode($graph_data)!!},
//     xkey: 'x',
//     ykeys: 'y',
//     labels: ['Number of Participants'],
//     ymin: 10,
//     fillOpacity: 0.6,
//         hideHover: 'auto',
//         behaveLikeLine: true,
//         resize: true,
//         xLabels:  'day',
//     
//   }).on('click', function(i, row){
//     console.log(i, row);
//   });
</script>
<script type="text/javascript">

   
   $(function () {
    filter();
    });
    
     $(document).on("click", ".datafilterbtn", function(){
         $(".datafilterbtn").removeClass('active');
         $(this).addClass('active');
    filter();
   
        });
     $(document).on("click", ".statefilterbtn", function(){
         $(".statefilterbtn").removeClass('active');
         $(this).addClass('active');
    filter();
   
        });
     $(document).on("click", ".cityfilterbtn", function(){
         $(".cityfilterbtn").removeClass('active');
         $(this).addClass('active');
    filter();
   
        });
     $(document).on("click", ".methodfilterbtn", function(){
         $(".methodfilterbtn").removeClass('active');
         $(this).addClass('active');
    filter();
   
        });
     $(document).on("click", ".pfilterbtn", function(){
         $(".pfilterbtn").removeClass('active');
         $(this).addClass('active');
    filter();
   
        });
     $(document).on("click", ".gfilterbtn", function(){
         $(".gfilterbtn").removeClass('active');
         $(this).addClass('active');
    filter();
   
        });
   
   function filter() {
    var data = {
            id: {{$data->id??0}},
            participant: $('.pfilterbtn.active').data('id'),
//            city: $('.cityfilterbtn.active').data('id'),
            method: $('.methodfilterbtn.active').data('id'),
            state: $('.statefilterbtn.active').data('id'),
            duration: $('.datafilterbtn.active').data('id'),
            graph: $('.gfilterbtn.active').data('id'),
            _token: "{{ csrf_token() }}",
    }
    $.post(
            "{{route('frontend.programdetails.graph')}}",
            data,
            function (data) {
                $("#graph").html('');
                var graphtype=$('.gfilterbtn.active').data('id');
                if(graphtype=="Line"){
             Morris.Line({
     element: 'graph',
     data: data.graph,
     xkey: 'x',
     ykeys: ['male','female','other','y','roi','cost','raised','singlecost'],
     labels: ['Males','Females','Others','Total Participants','ROI ($)','Program Cost ($)','Amount Raised ($)','Per Participant Cost ($)'],
     lineColors: ['#31bfa6', '#e664ca','#bf8731','#257cca','#ca4848','#726f80','#79c713','#d29696'],
     fillOpacity: 0.6,
         hideHover: 'auto',
         behaveLikeLine: true,
         resize: true,
         xLabels:  'day',
     
   });
                }else if(graphtype=="Bar"){
             Morris.Bar({
     element: 'graph',
     data: data.graph,
     xkey: 'x',
     ykeys: ['male','female','other','y','roi','cost','raised','singlecost'],
     labels: ['Males','Females','Others','Total Participants','ROI ($)','Program Cost ($)','Amount Raised ($)','Per Participant Cost ($)'],
     barColors: ['#31bfa6', '#e664ca','#bf8731','#257cca','#ca4848','#726f80','#79c713','#d29696'],
     fillOpacity: 0.6,
         hideHover: 'auto',
         behaveLikeLine: true,
         resize: true,
         xLabels:  'day',
     
   });
                }else if(graphtype=="Donut"){
             Morris.Donut({
     element: 'graph',
     data: data.graph,
    // xkey: 'x',
     //ykeys: ['male','female','other','y','roi'],
    labels: ['Males','Females','Others','Total Participants','ROI ($)','Program Cost ($)','Amount Raised ($)','Per Participant Cost ($)'],
     colors: ['#31bfa6', '#e664ca','#bf8731','#257cca','#ca4848'],
     fillOpacity: 0.6,
         hideHover: 'auto',
         behaveLikeLine: true,
         resize: true,
         xLabels:  'day',
     
   });
          }else{
                    Morris.Area({
     element: 'graph',
     data: data.graph,
     xkey: 'x',
    ykeys: ['male','female','other','y','roi','cost','raised','singlecost'],
     labels: ['Males','Females','Others','Total Participants','ROI ($)','Program Cost ($)','Amount Raised ($)','Per Participant Cost ($)'],
     lineColors: ['#31bfa6', '#e664ca','#bf8731','#257cca','#ca4848','#726f80','#79c713','#d29696'],
     fillOpacity: 0.6,
         hideHover: 'auto',
         behaveLikeLine: true,
         resize: true,
         xLabels:  'day',
     
   });
          }
       
            
            }
    );
    }
</script>
@endpush