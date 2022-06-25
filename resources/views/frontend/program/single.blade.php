<?php $page = "blog-details"; ?>
<style>
    ul.experience-list.profile-custom-list li {
    width: 100%;
}
</style>
@extends('layout.commonlayout')
@section('content')		
<!-- Breadcrumb -->
<div class="breadcrumb-bar">
    <div class="container-fluid">
        <div class="row align-items-center">
            <div class="col-md-12 col-12">
                <nav aria-label="breadcrumb" class="page-breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{route('dashboard')}}">Home</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Program</li>
                    </ol>
                </nav>
                <h2 class="breadcrumb-title">Program Details</h2>
            </div>
        </div>
    </div>
</div>
<!-- /Breadcrumb -->

<!-- Page Content -->
<div class="content">
    <div class="container-fluid">
     <div class="card">
               <div class="card-body">
                  <div class="mentor-widget">
                     <ul class="experience-list profile-custom-list" style="width:100%;">
                        <li>
                           <div class="experience-content">
                           <h3 class="blog-title">{{$data->title}}</h3>
                        <div class="blog-info clearfix">
                            <div class="post-left">
                                <ul>
                                    <li>
                                      
                                    </li>
                                    <li><i class="fas fa-building"></i> 
                                    
                                    @php
                                         $users = $data->user->company;
                                        if($users == null){
                                            echo "not available";
                                        }
                                        else{
                                            echo $users;
                                        }
                                       @endphp
                                
                                </li>
                                   
                                </ul>
                            </div>
                        </div>
                           </div>
                        </li>
                        <!-- <li>
                           <div class="experience-content">
                              <div class="timeline-content">
                                 <span>Price</span>
                                 <div class="row-result"> ${{ $data->price }}</div>
                              </div>
                           </div>
                        </li> -->
                     </ul>
                     <div class="newfhjdf" style="width:50%;">
                     <a style="float:right;" href="{{ route('frontend.program') }}" class="bachkbtn btn btn-sm btn-primary float-right btn-icon-only rounded-circle ">
        <span class="btn-inner--icon"><i class="fas fa-reply"></i></span>
    </a>
                  </div>
                  </div>
               </div>
            </div>

  
        <div class="row">
            <div class="col-lg-9 col-md-9">
                <div class="blog-view program-q">
                    <div class="blog blog-single-post">
                      
                     
                        <div class="blog-content">
                        <?php $p_content = json_decode($data->data,true);
                        if(is_array($p_content)){ $count=1; ?>
                            <p><?php foreach($p_content as $key => $content){ ?>
                               <?php  if(isset($questions[$key])){ ?>
                                <div class="widget">
                            <h4 class="widget-title <?php echo $key; ?>"><span>{{$count}}</span> <?php echo $questions[$key]; ?></h4> 
                            <div class="widget-body">
                                <?php
                                if(is_array($content)){
                                    foreach($content as $k => $inrcont){
                                      echo  $inrcont;
                                    }
                                 }
                                else{
                                    echo $content;
                                } $count++; ?>
                                </div>
                                </div>
                          <?php } } ?></p>
                            <?php }
                            else{ ?>
                             {{ $p_content  }}
                            
                          <?php  } ?>
                        </div>
                        
                    </div>

                  
                   
                    

                </div>
                      @if($data->audit_report != null )
                <div class="card card-chart">
                     <div class="card-header">
                        <h4 class="card-title">Report</h4>
                     </div>
                     <div class="card-body">
                         @if($erordate)
                        <span>Nothing to show</span>
                        @else
                     
                        <div class="btn-group btn-group-justified btn-group-lg float-right pull-right">
                            <div class="btn-group" role="group">
    <button id="btnGroupDrop1" type="button" class="btn btn-primary btn-group-lg dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
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
    <button id="btnGroupDrop1" type="button" class="btn btn-primary btn-group-lg dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
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
    <button id="btnGroupDrop1" type="button" class="btn btn-primary btn-group-lg dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
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
    <button id="btnGroupDrop1" type="button" class="btn btn-primary btn-group-lg dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
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
    <button id="btnGroupDrop1" type="button" class="btn btn-primary btn-group-lg dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
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
                            
                            <a href="javascript:void(0)" data-id="-1"  class="btn btn-primary datafilterbtn">1M</a>
                        <a href="javascript:void(0)" data-id="-3" class="btn btn-primary datafilterbtn">3M</a>
                        <a href="javascript:void(0)" data-id="-6" class="btn btn-primary datafilterbtn">6M</a>
                        <a href="javascript:void(0)" data-id="-12" class="btn btn-primary datafilterbtn">1Y</a>
                        <a href="javascript:void(0)" data-id="" class="btn btn-primary datafilterbtn">All Duration</a>
                      </div>
                 
                        <hr>
                         <div id="graph"></div>
                        @endif
                     </div>
                  </div>
                  @endif

            </div>

            <!-- Blog Sidebar -->
            <div class="col-lg-3 col-md-3 sidebar-right theiaStickySidebar">

               
                
                
                            @if(!empty($recent_blogs) && count($recent_blogs) > 0)
                <!-- Latest Posts -->
                <div class="card post-widget">
                    <div class="card-header">
                        <h4 class="card-title">Latest Programs</h4>
                    </div>
                    <div class="card-body">
                        <ul class="latest-posts">
                            @foreach($recent_blogs as $row)
                            <li>
                                <div class="post-thumbd">
                                    <a href="{{route('frontend.programdetails',encrypted_key($row->id,"encrypt"))}}">
                                         
                                        <h3>{{  $row->title }}</h3>
                                      
                                        
                                        
                                    </a>
                                </div>
                                <!-- <div class="post-info">
                                    <h4>
                                        <a href="{{route('blog.details',encrypted_key($row->id,"encrypt"))}}">{{$row->title}}</a>
                                    </h4>
                                    <p>{{date('F d, Y', strtotime($row->created_at))}}</p>
                                </div> -->
                            </li>
                            @endforeach
                            
                        </ul>
                    </div>
                </div>
                <!-- /Latest Posts -->
                            @endif
                

            </div>
            <!-- /Blog Sidebar -->

        </div>
                          
<!---  table   --->
        
<!--@if($data->audit_report != null )
             chart 
            chart-
            <div class="row">
               <div class="col-md-9 col-lg-9">
                         <div class="card-body" style>
                          @if($erordate)
                        <span>Nothing to show</span>
                        @else
                      <div class="table-responsive">
                        <table class="table table-hover table-center mb-0">
                           <thead>
                              <tr>
                                 <th scope="col">City</th>
                                 <th scope="col">State</th>
                                 <th scope="col">Participants</th>
                                  <th scope="col">Per Participant Cost ($)</th>
                                 <th scope="col">Date</th>
                                 <th scope="col">Method</th>
                                 <th scope="col">Framework</th>
                              </tr>
                           </thead>
                           <tbody>
                              @foreach($graphictable as $key => $table)
                              <tr>
                                 <td >{{ $table['city']??'' }}</td>
                                 <td>{{ $table['state'] }}</td>
                                   <td>(M:{{$table['male_participants']??0}},F:{{$table['female_participants']??0}},O:{{$table['other_participants']??0}})/T:{{ $table['participants'] }}</td>
                                 <td>{{ !empty($table['participant_cost']) ? format_price($table['participant_cost']):0.00 }}</td>
                                 <td>{{ date('M d, Y', strtotime($table['date'])) }}</td>
                                 <td>{{ $table['method'] }}</td>
                                 <td>{{ $table['framework']??''  }}</td>
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
                
               </div>
            </div>
            @endif-->
<!----- table end ------>

<div class="card blog-share clearfix">
                            <div class="card-header">
                                <h4 class="card-title">Share the program</h4>
                            </div>
                            <div class="card-body">
                                <div class="icons">
                                    <div id="share"></div>
                                </div>
                            </div>
                        </div>
    </div>

</div>		
<!-- /Page Content -->
@endsection

@push('script')
<style>
    .jssocials-share i.fa {
        font-family: "Font Awesome 5 Brands";
    }
    .jssocials-share-label {
        padding-left: .0em;
        vertical-align: middle;
    }
    .jssocials-shares {
        margin: 1em 0;
        font-size: 13px;
    }
</style>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jsSocials/1.5.0/jssocials-theme-flat.min.css" integrity="sha256-1Ru5Z8TdPbdIa14P4fikNRt9lpUHxhsaPgJqVFDS92U=" crossorigin="anonymous" />
<script src="https://cdnjs.cloudflare.com/ajax/libs/jsSocials/1.5.0/jssocials.min.js" integrity="sha256-QhF/xll4pV2gDRtAJ1lvi9YINqySpAP+0NIzIX5voZw=" crossorigin="anonymous"></script>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jsSocials/1.5.0/jssocials.min.css" integrity="sha256-1tuEbDCHX3d1WHIyyRhG9D9zsoaQpu1tpd5lPqdqC8s=" crossorigin="anonymous" />
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.10.2/css/all.min.css" integrity="sha256-zmfNZmXoNWBMemUOo1XUGFfc0ihGGLYdgtJS3KCr/l0=" crossorigin="anonymous" />


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

<script>
$(document).ready(function () {
    $("#share").jsSocials({
        shares: ["twitter", "facebook", "linkedin", "pinterest", "whatsapp"],
        showCount: false
    });

});
</script>
<script type="text/javascript">
   $(document).on("click", ".import_audit", function(){
       $('#import_divaudit').modal('show');
       $('#programIds').val("{{ $data->id }}");
   
   });
   
   console.log("hi");
   

   
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
            id: {{$program_id}},
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

