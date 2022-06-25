<?php $page = "blog-details"; ?>
@extends('layout.commonlayout')
<style>
 .issuelogo img{
 width: 100% !important;
 max-width: 186px !important;
 }
.blink_me {
  animation: blinker 1s linear infinite;
}

@keyframes blinker {
  50% {
    opacity: 0;
  }
}
</style>
@section('content')		
<!-- Breadcrumb -->
<div class="breadcrumb-bar">
    <div class="container-fluid">
        <div class="row align-items-center">
            <div class="col-md-12 col-12">
                <nav aria-label="breadcrumb" class="page-breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="index">Home</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Course</li>
                    </ol>
                </nav>
                <h2 class="breadcrumb-title">Course Details</h2>
            </div>
        </div>
    </div>
</div>
<!-- /Breadcrumb -->


<!-- Page Content -->
<div class="content">
    <div class="container-fluid">

        <div class="row">
            <div class="col-lg-8 col-md-12">
        <div class="row justify-content-center">
            <!-- back Button -->
            <div class="col-xl-10 col-lg-11 mt-4 ml-xxl-32 ml-xl-15 dark-mode-texts">
                <div class="mb-9">
                    <a class="d-flex align-items-center ml-4" href="{{route('swags')}}"> <i
                            class="icon icon-small-left bg-white circle-40 mr-5 font-size-7 text-black font-weight-bold shadow-8">
                        </i><span class="text-uppercase font-size-3 font-weight-bold text-gray"></span></a>
                </div>
            </div>
            <!-- back Button End -->
            <div class="col-xl-9 col-lg-11 mb-8 px-xxl-15 px-xl-0">
                <div class="bg-white rounded-4 border border-mercury shadow-9">
                    <!-- Single Featured Job -->
                    <div class="pt-9 pl-sm-9 pl-5 pr-sm-9 pr-5 pb-8 border-bottom border-width-1 border-default-color light-mode-texts">
                        <div class="row">
                            <div class="col-md-9">
                                <!-- media start -->
                                <div class="media align-items-center">
                                    <!-- media logo start -->
                                    <div class="square-72 d-block mr-10 mb-3">
                                        @if(file_exists( storage_path().'/swags/'.$data->image ) && !empty($data->image))
                                        <img src="{{asset('storage')}}/swags/{{ $data->image }}" height="100px" width="100px" class=" " alt="...">
                                        @else
                                        <img src="{{ asset('public')}}/demo23/image/patterns/globe-pattern.png" class="" height="100px" width="100px" alt="img">
                                        @endif
                                    </div>
                                    <!-- media logo end -->
                                    <!-- media texts start -->
                                    <div>
                                        <h3 class="font-size-6 mb-0">{{ ucfirst($data->title)}}</h3>
                                        <span class="font-size-3 text-gray line-height-2">
                                            <b class="blink_me">Get customized design! </b>
                                        </span>



                                    </div>
                                    <!-- media texts end -->
                                </div>
                                <!-- media end -->
                            </div>
                            <div class="col-md-3 text-right pt-7 pt-md-0 mt-md-n1">
                                <!-- media date start -->
                                <div class="media justify-content-md-end">
                                    <p class="font-size-4 text-gray mb-0">{{date('F d, Y', strtotime($data->created_at))}}</p>
                                </div>
                                <!-- media date end -->
                            </div>
                        </div>
                        <div class="row pt-9">
                            <div class="col-12">
                                <!-- card-btn-group start -->
                                <div class="card-btn-group">
                               
                                             <a id="assistance" href="#" class="btn btn-primary mt-0 "  data-title="{{__('Get Now
                                            ')}}">
                                                        {{__('Get Now')}}
                                                    </a>
                                     
                                  

                                    <!--                      <a class="btn btn-outline-mercury text-black-2 text-uppercase h-px-48 rounded-3 mb-5 px-5" href="#">
                                                            <i class="icon icon-bookmark-2 font-weight-bold mr-4 font-size-4"></i> Save job</a>-->
                                </div>
                                <!-- card-btn-group end -->
                            </div>
                        </div>
                    </div>
                   
                    <div class="job-details-content pt-8 pl-sm-9 pl-6 pr-sm-9 pr-6 pb-10 light-mode-texts">
                        <div class="row">
                            <div class="col-xl-11 col-md-12 pr-xxl-9 pr-xl-10 pr-lg-20">
                                <div class="">
                                    <p class="mb-4 font-size-5 text-black-2 font-weight-semibold">Description:</p>
                                    <p class="font-size-4 text-black-2 mb-7">
                                        {!! html_entity_decode($data->description, ENT_QUOTES, 'UTF-8') !!}
                                    </p>
                                   
                                    
                                    <!--<a class="btn btn-success text-uppercase btn-medium rounded-3 w-180 mr-4 mb-5" href="{{url('/price')}}"     >Subscribe Now</a>-->
                                    
                                </div>

                            </div>
                        </div>
                    </div>
                    <div class="job-details-content pt-8 pl-sm-9 pl-6 pr-sm-9 pr-6 pb-10 light-mode-texts">
                        
                        <div class="icons">
                            <div id="share"></div>
                        </div>
                        
                        <div class="text-center" data-adx="scholarship" id="display_advertisment"></div>

                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
</div>
</div>


<!-- BLog End -->
            <div class="col-lg-4 col-md-6 col-12 mt-4 mt-sm-0 pt-2 pt-sm-0">
                <div class="card border-0 sidebar sticky-bar rounded shadow">
                    <div class="card-body">
                        <!-- SEARCH -->
                            <div class="nowData" style="height: 100px;">
                                
                                    <a href="javascript:void(0);" id="assistance">
                                        <button style="float: right;margin-top: -5px;margin-right: -12px;" type="button" class="btn btn-primary">Get Now</button>
                                    </a>
                                    
                                <br>
                                <br>
                                <b class="blink_me text-primary">Get customized design! </b>
                                    
                            </div>
                            <hr>
                        <div class="widget pb-4">
                            <h4 class="widget-title">Search </h4>
                            <div id="jobkeywords" class="widget-search mb-0">
                                <form role="search" method="get" id="searchform" class="searchform">
                                    <div>
                                        <input type="text" class="border rounded" name="s" id="s" placeholder="Search Keywords...">
                                    </div>
                                </form>
                            </div>
                        </div>
                        
                    </div>
                </div>
            </div>


<!-- end register modal -->
<!-- Modal -->
<div class="modal fade" id="assistanceModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Choose Options</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        {{ Form::open(['url' => '#','id' => 'teemill-form','enctype' => 'multipart/form-data']) }}
        <input type="hidden" id="image_url" name="image_url" value="{{asset('storage/swags')}}/{{ $data->image }}">
        <div class="form-group">
            <label for="swag_name">Swag Name</label>
            <input type="text" class="form-control" name="swag_name" id="swag_name" value="{{$data->title}}" readonly>
        </div>
        <div class="form-group">
            <label for="swag_type">Select Swag Type</label><br>
            <select class="form-control" name="swag_type" id="swag_type" required>
            @foreach(\App\SwagOption::getSwagOptions() as $option)
                <option value="{{$option->option_value}}">{{$option->name}}</option>
            @endforeach
            </select>
        </div>
        
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        <button type="submit" class="btn btn-primary">View Swag</button>
      </div>
      {{ Form::close() }}
    </div>
  </div>
</div>
@endsection

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
<script>
$(document).ready(function () {
    $("#share").jsSocials({
        shares: ["twitter", "facebook", "googleplus", "linkedin", "pinterest", "stumbleupon", "whatsapp"],
        showCount: false
    });

});
</script>


<script>
    $("#assistance").click(function () {
        $("#assistanceModal").modal('show');
    });
    $("#s").keyup(function () {
        window.location.href = "{{url('swags')}}";
    });
    
    /*
 * view teemill product
 */
$("#teemill-form").submit(function(event){
   
    event.preventDefault();
    @php
   // $teemilapikey=\App\Utility::getValByName("teemill_api_key");
    $teemilapikey ='';
    @endphp
    var teemilApiKey='{{$teemilapikey}}';    
        var item_code = $("#swag_type").val();
        var image_url = $("#image_url").val();
        var product_name = $("#swag_name").val();
    if(item_code !='' && image_url !='' && product_name !='') {
        
        $("#assistanceModal").modal('hide');
        $.get("https://teemill.co.uk/api-access-point/?api_key="+teemilApiKey+"&item_code="+item_code+"&product_name="+product_name+"&colour=White&image_url="+image_url, function(data, status){
//            console.log(status);
        //   hideLoader();
//          redirect(data);
 window.location.href = data;
//console.log(data);
        });
    }else{
        alert('Empty parameters');
    }
});
</script>