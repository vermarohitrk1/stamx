<?php $page = "Corporate Dashboard"; ?>
@extends('layout.dashboardlayout')
@section('content')	

<style>
path#apexcharts-bar-area-0 {
    fill: #009da6 !important;
}
</style>
<!-- Page Content -->
 @include('sweet::alert')
 <script>
 @if (session('alert'))
 swal("{{ session('alert') }}");
@endif
</script>
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
                    @php
                    $permissions=permissions();
                    @endphp
                   
                  
        
    
    
    
                     </div>
   
<!-- Breadcrumb -->
<div class="breadcrumb-bar mt-3">
    <div class="container-fluid">
        <div class="row align-items-center">
            <div class="col-md-12 col-12">
                <h2 class="breadcrumb-title">Corporate Dashboard</h2>
                <nav aria-label="breadcrumb" class="page-breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{route('dashboard')}}">Home</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Corporate Dashboard</li>
                    </ol>
                </nav>
            </div>              
        </div>            
    </div>
</div>
<!-- /Breadcrumb -->

    @if($user->type == 'corporate' )
<div class="row mt-3">
                    <div class="col-md-12 col-lg-3 dash-board-list blue">
                        <div class="dash-widget">
                            <div class="circle-bar">
                                <div class="icon-col">
                                    <i class="fas fa-calendar-check"></i>
                                </div>
                            </div>
                            <div class="dash-widget-info">
                                <h3>@if(!empty($requests)){{$requests}} @else 0 @endif</h3>
                                <h6>{{__('Requests')}}</h6>															
                            </div>
                        </div>
                    </div>

                    

                    <div class="col-md-12 col-lg-3 dash-board-list pink">
                        <div class="dash-widget">
                            <div class="circle-bar">
                                <div class="icon-col">
                                    <i class="fas fa-users"></i>
                                </div>
                            </div>
                            <div class="dash-widget-info">
                                <h3>@if(!empty($pending)){{$pending}} @else 0 @endif</h3>
                                <h6>{{__('Pending')}}</h6>															
                            </div>
                        </div>
                    </div>
                    <div class="col-md-12 col-lg-3 dash-board-list yellow">
                        <div class="dash-widget">
                            <div class="circle-bar">
                                <div class="icon-col">
                                    <i class="fas fa-money-bill-alt "></i>
                                </div>
                            </div>
                            <div class="dash-widget-info">
                                <h3>@if(!empty($delined)){{$delined}} @else 0 @endif</h3>
                                <h6>{{__('Declined')}}</h6>															
                            </div>
                        </div>
                    </div>
					
					  <div class="col-md-12 col-lg-3 dash-board-list green">
                        <div class="dash-widget">
                            <div class="circle-bar">
                                <div class="icon-col">
                                    <i class="fas fa-money-bill-alt "></i>
                                </div>
                            </div>
                            <div class="dash-widget-info">
                                <h3>@if(!empty($totalpaid)){{ format_price($totalpaid, 2) }} @else 0 @endif</h3>
                                <h6>{{__('Total Paid')}}</h6>															
                            </div>
                        </div>
                    </div>
                </div>
				
				@endif

<br>


<div class="row" id="certifyView">
        <div class="col-12">
            <div class="card">
			  <div class="card-header">
                <h6 class="mb-0">{{__('Weekly Requests ')}}</h6>
                <small class="text-muted">{{__('Last 7 Days')}}</small>
                <div class="dropdown">
                    <button class="btn btn-sm btn-white btn-icon-only rounded-circle" type="button" id="dropdownMenu2" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        <span class="btn-inner--icon"><i class="fas fa-filter"></i></span>
                    </button>
                    <div class="dropdown-menu" aria-labelledby="dropdownMenu2">
                        <button class="dropdown-item" type="button">
                            <a class="dropdown-item pertionGraph" href="{{route('corporate.dashboard')}}?chart_filter=Male" data-option="Male" data-val="created_at-asc">
                             {{__('Male')}}
                            </a>
                        </button>    
                        <button class="dropdown-item pertionGraph" type="button">
                            <a class="dropdown-item" href="{{route('corporate.dashboard')}}?chart_filter=Female" data-option="Female" data-val="created_at-asc">
                               {{__('Female')}}
                            </a>
                        </button>
                        <button class="dropdown-item pertionGraph" type="button">
                            <a class="dropdown-item" href="{{route('corporate.dashboard')}}?chart_filter=Others" data-option="Others" data-val="created_at-asc">
                              {{__('Others')}}
                            </a>
                        </button>
                    </div>
                </div>
            </div>
                <div class="card-body">
                         <div id="timesheet_logged" data-color="primary" data-height="410"></div>
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
<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>

<script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/1.1.3/sweetalert.min.js"></script>
<script src="{{ asset('assets/libs/apexcharts/dist/site.js') }}"></script>
<script src="{{ asset('assets/libs/apexcharts/dist/apexcharts.min.js') }}"></script>

    <script type="text/javascript">
 
    /*Chart*/
    var e1 = $("#timesheet_logged");
    var t1 = {
    chart: {width: "100%", type: "bar", zoom: {enabled: !1}, toolbar: {show: !1}, shadow: {enabled: !1}},
            plotOptions: {bar: {horizontal: !1, columnWidth: "30%", endingShape: "rounded"}},
            stroke: {show: !0, width: 2, colors: ["transparent"]},
            series: [{name: "{{$type}}", data: {!! json_encode(array_values($home_data['timesheet_logged'])) !!}}],
            xaxis: {labels: {style: {colors: PurposeStyle.colors.gray[600], fontSize: "14px", fontFamily: PurposeStyle.fonts.base, cssClass: "apexcharts-xaxis-label"}}, axisBorder: {show: !1}, axisTicks: {show: !0, borderType: "solid", color: PurposeStyle.colors.gray[300], height: 6, offsetX: 0, offsetY: 0}, type: "category", categories: {!! json_encode(array_keys($home_data['timesheet_logged'])) !!}},
            yaxis: {labels: {style: {color: PurposeStyle.colors.gray[600], fontSize: "12px", fontFamily: PurposeStyle.fonts.base}}, axisBorder: {show: !1}, axisTicks: {show: !0, borderType: "solid", color: PurposeStyle.colors.gray[300], height: 6, offsetX: 0, offsetY: 0}},
            fill: {type: "solid"},
            markers: {size: 4, opacity: .7, strokeColor: "#fff", strokeWidth: 3, hover: {size: 7}},
            grid: {borderColor: PurposeStyle.colors.gray[300], strokeDashArray: 5},
            dataLabels: {enabled: !1}
    }, a1 = (e1.data().dataset, e1.data().labels, e1.data().color), n1 = e1.data().height;
    e1.data().type, t1.colors = [PurposeStyle.colors.theme[a1]], t1.markers.colors = [PurposeStyle.colors.theme[a1]], t1.chart.height = n1 || 350;
    var o1 = new ApexCharts(e1[0], t1);
    setTimeout(function () {
    o1.render()
    }, 300);
    </script>
@endpush
