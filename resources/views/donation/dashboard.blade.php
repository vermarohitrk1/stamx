<?php $page = "Donation"; ?>
@extends('layout.dashboardlayout')
@push('css-cdn')
<link rel="stylesheet" href="{{ asset('public/assets_admin/plugins/morris/morris.css') }}">
@endpush
@section('content')
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
                @if(!empty($payment['STRIPE_KEY']) && !empty($payment['STRIPE_SECRET']))
                    <a href="{{ url('donation/history') }}" class="btn btn-sm btn btn-primary float-right mr-2">
                        <span class="btn-inner--text">{{__('Donation Histroy')}}</span>
                    </a>
                    <a href="{{ url('donation/page') }}" class="btn btn-sm btn btn-primary float-right mr-2">
                        <span class="btn-inner--text">{{__('Manage Donation Form')}}</span>
                    </a>
                 
                    @endif

                </div>
                <!-- Breadcrumb -->
                <div class="breadcrumb-bar mt-3">
                    <div class="container-fluid">
                        <div class="row align-items-center">
                            <div class="col-md-12 col-12">
                                <h2 class="breadcrumb-title">Donation</h2>
                                <nav aria-label="breadcrumb" class="page-breadcrumb">
                                    <ol class="breadcrumb">
                                        <li class="breadcrumb-item"><a href="index">Home</a></li>
                                        <li class="breadcrumb-item active" aria-current="page">Donation</li>
                                    </ol>
                                </nav>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- /Breadcrumb -->
                @if(empty($payment['STRIPE_KEY']) && empty($payment['STRIPE_SECRET']))
                    @if(Auth::user()->type == 'admin')
                        <div class="alert alert-danger mt-2" role="alert">
                            <a href="{{url('admin/site/settings')}}"><strong>Click Here</strong></a> to configure stripe with your account
                        </div>
                    @else
                        <div class="alert alert-danger mt-2" role="alert">
                            <a href="{{url('site/settings')}}"><strong>Click Here</strong></a> to configure stripe with your account
                        </div>
                    @endif
                @endif
                <div class="row mt-3 blockWithFilter">
                    <div class="col-md-12 col-lg-4 dash-board-list blue">
                        
                        <div class="dash-widget">
                            
                            <div class="circle-bar">
                                <div class="icon-col">
                                    <i class="fas fa-users"></i>
                                </div>
                            </div>
                            <div class="dash-widget-info">
                                <h3 data-id="donors">{{$home_data['total_donar']}}</h3>
                                <span><h6>Donors</h6> </span>
                            </div>
                            
                        </div>
                    </div>



                    <div class="col-md-12 col-lg-4 dash-board-list pink">
                        <div class="dash-widget">
                            <div class="circle-bar">
                                <div class="icon-col">
                                <i class="fas fa-map-marked-alt"></i>
                                </div>
                            </div>
                            <div class="dash-widget-info">
                                <h3 data-id="states">{{ $home_data['total_states']}}</h3>
                                <h6>States</h6>
                            </div>
                        </div>
                    </div>
<!--                    <div class="col-md-12 col-lg-3 dash-board-list yellow">
                        <div class="dash-widget">
                            <div class="circle-bar">
                                <div class="icon-col">
                                    <i class="fas fa-money-bill-alt "></i>
                                </div>
                            </div>
                            <div class="dash-widget-info">
                                <h3 data-id="revenue">${{$home_data['total_monthly']}}.00</h3>
                                <h6>Monthly Revenue</h6>
                            </div>
                        </div>
                    </div>-->
                    <div class="col-md-12 col-lg-4 dash-board-list green">
                        <div class="dash-widget">
                            <div class="circle-bar">
                                <div class="icon-col">
                                    <i class="fas fa-money-bill-alt "></i>
                                </div>
                            </div>
                            <div class="dash-widget-info">
                                <h3 data-id="revenue">${{$home_data['total_yearly']}}.00</h3>
                                <h6>Revenue</h6>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row mt-3">
                    <br>
                    <div class="col-md-12">

                        <div class="card card-chart">
                            <div class="card-header">
                                <h4 class="card-title mb-0">Donation Manager</h4>
                        <small class="text-muted">Donation in last 7 days</small>
                            </div>
                            <div class="card-body">
                                <div id="morrisArea">
                                    
                                </div>
                            </div>
                        </div>

                    </div>
                </div>


            </div>
        </div>
    </div>
</div>
@endsection
@push('js-cdn')
<script src="{{ asset('public/assets_admin/plugins/raphael/raphael.min.js') }}"></script>
<script src="{{ asset('public/assets_admin/plugins/morris/morris.min.js') }}"></script>
<!-- <script src="{{ asset('public/assets_admin/js/chart.morris.js') }}"></script> -->
@endpush
@push('script')
<script>
      const dayNames =  ["SUN", "MON", "TUE", "WED", "THU", "FRI", "SAT"];
 window.mL =   Morris.Line({
      element: 'morrisArea',
    data:{!! json_encode($home_data['donations_overview']) !!},
  lineColors: ['#1a538a', '#fc8710', '#FF6541', '#A4ADD3', '#766B56'],
  xkey: 'period',
  ykeys: ['total'],
  labels: ['Total'],
  xLabels: 'day',
  xLabelFormat: function(d) {
    return dayNames[d.getDay()];
  },
  lineWidth: 1,
	    gridTextSize: 10,
	    hideHover: 'auto',
	    resize: true,
		redraw: true
    });


	$(window).on("resize", function(){
		
		mL.redraw();
	});
</script>
@endpush