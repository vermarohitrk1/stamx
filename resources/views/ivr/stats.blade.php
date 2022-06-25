@php $page = "IVR"; @endphp
@extends('layout.dashboardlayout')
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
                <!-- Breadcrumb -->
                <div class="breadcrumb-bar mt-3">
                    <div class="container-fluid">
                        <div class="row align-items-center">
                            <div class="col-md-12 col-12">
                                <h2 class="breadcrumb-title">IVR</h2>
                                <nav aria-label="breadcrumb" class="page-breadcrumb">
                                    <ol class="breadcrumb">
                                        <li class="breadcrumb-item"><a href="{{route('dashboard')}}">Home</a></li>
                                        <li class="breadcrumb-item active" aria-current="page">IVR</li>
                                    </ol>
                                </nav>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row mt-3 blockWithFilter">
                    <div class="col-md-12 col-lg-3 dash-board-list blue">
                        <div class="dash-widget">
                            <div class="circle-bar">
                                <div class="icon-col">
                                    <i class="fas fa-address-book"></i>
                                </div>
                            </div>
                            <div class="dash-widget-info">
                                <h3 data-id="incoming">{{( $home_data['totalincoming'] ??0)}}</h3>
                                <h6>Incoming</h6>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-12 col-lg-3 dash-board-list yellow">
                        <div class="dash-widget">
                            <div class="circle-bar">
                                <div class="icon-col">
                                    <i class="fas fa-users"></i>
                                </div>
                            </div>
                            <div class="dash-widget-info">
                                <h3 data-id="voicemails">{{( $home_data['totalvoicemails'] ??0)}}</h3>
                                <h6>{{__('Voicemails')}}</h6>
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
                                <h3 data-id="numbers">{{( $home_data['totalnumber'] ??0)}}</h3>
                                <h6>{{__('Numbers')}}</h6>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-12 col-lg-3 dash-board-list green">
                        <div class="dash-widget">
                            <div class="circle-bar">
                                <div class="icon-col">
                                    <i class="fas fa-users"></i>
                                </div>
                            </div>
                            <div class="dash-widget-info">
                                <h3 data-id="minutes">{{( $home_data['totalminutes'] ??0)}}</h3>
                                <h6>{{__('Minutes')}}</h6>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- /Breadcrumb -->
                <div class="row">
                     <div class="col-sm-12">
                        <div class="card">
                            <div class="card-header">
                                <h6 class="mb-0">Call Manager</h6>
                                <small class="text-muted">{{__('Incoming Calls in last 7 days')}}</small>
                            </div>
                            <div class="card-body">
                                <div id="task_overview" data-color="primary" data-height="280"></div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-sm-4">
                       <div class="card">
                            <div class="card-header">
                                <h6 class="mb-0">{{__('Latest Calls')}}</h6>
                            </div>
                            <div class="card-body">
                                @if(!empty($home_data['call_logs_list']))
                                    @foreach($home_data['call_logs_list'] as $call_logs_list)
                                        <div class="row align-items-center mb-4">
                                            <div>
                                                @if(!empty($call_logs_list->name))
                                                    @if(empty($call_logs_list->avatar))
                                                        <img class="avatar rounded-circle" avatar="{{$call_logs_list->name}}"/>
                                                    @else
                                                        @if(file_exists(url('/storage/app/'.$call_logs_list->avatar)))
                                                            <img src="{{url('/storage/app/'.$call_logs_list->avatar)}}" class="avatar rounded-circle">
                                                        @else
                                                            <img src="{{url('assets/img/user/user.jpg')}}" class="avatar rounded-circle" avatar="Unknown"/>
                                                        @endif
                                                    @endif
                                                @else
                                                <img src="{{url('assets/img/user/user.jpg')}}" class="avatar rounded-circle" avatar="Unknown"/>
                                                @endif
                                            </div>
                                            <div class="col">
                                                <span class="d-block h6 mb-0"> {{mobileNumberFormat($call_logs_list->pfrom) }}</span>
                                            </div>
                                        </div>
                                    @endforeach
                                @endif
                            </div>
                       </div>
                    </div>

                <div class="col-sm-8">
                    <div class="card">
                         <div class="card-header">
                             <h6 class="mb-0">{{__('Voicemails')}}</h6>
                         </div>
                         <div class="card-body">
                            <div class="scrollbar-inner">
                                <div class="min-h-430 mh-430">
                                    <div class="list-group list-group-flush">

                                                <div class="min-h-430 mh-430">
                                                    <div class="list-group list-group-flush">
                                                        @if(!empty($home_data['voicemail_list']))
                                                            @foreach($home_data['voicemail_list'] as $voicemail_list)
                                                                <a href="" class="list-group-item list-group-item-action">
                                                                    <div class="d-flex align-items-center justify-content-between">
                                                                        <div>
                                                                            @if(!empty($voicemail_list->name))
                                                                                 @if(empty($voicemail_list->avatar))
                                                                                     <img class="avatar rounded-circle" avatar="{{$voicemail_list->name}}"/>


                                                                                    @else
                                                                                        @if(file_exists(url('/storage/app/'.$voicemail_list->avatar)))
                                                                                         <img src="{{url('/storage/app/'.$voicemail_list->avatar)}}" class="avatar rounded-circle">
                                                                                        @else
                                                                                        <img src="{{url('assets/img/user/user.jpg')}}" class="avatar rounded-circle" avatar="Unknown"/>
                                                                                        @endif
                                                                                    @endif
                                                                                @else
                                                                                <img src="{{url('assets/img/user/user.jpg')}}" class="avatar rounded-circle" avatar="Unknown"/>
                                                                            @endif
                                                                                                        </div>
                                                        <div class="flex-fill pl-3 text-limit">
                                                            <div class="row">
                                                                <div class="col-9">
                                                                    <h6 class="progress-text mb-1 text-sm d-block text-limit">
                                                                        {{mobileNumberFormat($voicemail_list->pfrom) }}</h6>
                                                                </div>
                                                                <div class="col-3 text-right">
                                                                    <span class="badge badge-xs @if($voicemail_list->statusin =='in-progress') badge-primary @elseif($voicemail_list->statusin =='ringing')  badge-danger   @else badge-success @endif">{{$voicemail_list->statusin}}</span>
                                                                </div>
                                                            </div>
                                                            <div class="progress progress-xs mb-0">
                                                                <div class="progress-bar bg-danger" role="progressbar" style="width: 0%;" aria-valuenow="0%" aria-valuemin="0" aria-valuemax="100"></div>
                                                            </div>
                                                            @if(!empty($voicemail_list->recordingurl))
                                                                <div class="d-flex justify-content-between text-xs text-muted text-right mt-1">
                                                                    <div>
                                                                        <div class="wrapperaudio" id="" style="width: 211px; !important;">
                                                                            <audio preload="auto" controls class="audio"><source src="{{ $voicemail_list->recordingurl }}" type="audio/mpeg"></audio>
                                                                        </div>
                                                                    </div>
                                                                    <div>
                                                                        {{ $voicemail_list->dialcallduration }} sec
                                                                    </div>
                                                                </div>
                                                            @endif
                                                        </div>
                                                    </div>
                                                    </a>
                                                    @endforeach
                                                    @endif
                                                    </div>
                                                    </div>

                                                    </div>
                                                    </div>
                                                    </div>
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

<!--<script type="text/javascript" src="{{ asset('datatables/datatables.min.js') }}"></script>-->
<script src="{{url('/public/assets_admin/plugins/apexchart/apexcharts.min.js')}}"></script>
<script>


var options = {
  chart: {
    height: 350,
    type: "line",
    stacked: false
  },
  dataLabels: {
    enabled: false
  },
  colors: ["#247BA0"],
  series: [
    {
      name: "Calls",
      data:  {!! json_encode(array_values($home_data['calllogs_overview'])) !!}
    },
  ],
  stroke: {
    width: [4, 4]
  },
  plotOptions: {
    bar: {
      columnWidth: "10%"
    }
  },
  xaxis: {
    categories: {!! json_encode(array_keys($home_data['calllogs_overview'])) !!}
  },
  yaxis: [
    {
      axisTicks: {
        show: true
      },
      axisBorder: {
        show: true,
        color: "#247BA0"
      },
      labels: {
        style: {
          colors: "#247BA0"
        }
      },
      title: {
        text: "Calls",
        style: {
          color: "#247BA0"
        }
      }
    }
  ],
  tooltip: {
    shared: false,
    intersect: true,
    x: {
      show: false
    }
  },
};

var chart = new ApexCharts(document.querySelector("#task_overview"), options);

chart.render();

    // /*Chart*/
    // var e = $("#task_overview");
    // var t = {
    // chart: {width: "100%"},
    // stroke: {width: 7, curve: "smooth"},
    // series: [{name: "{{__('Calls')}} ", data: {!! json_encode(array_values($home_data['calllogs_overview'])) !!}}],
    //  type: "category", categories: {!! json_encode(array_keys($home_data['calllogs_overview'])) !!}},
    // yaxis: {labels: {style: {color: PurposeStyle.colors.gray[600], fontSize: "12px", fontFamily: PurposeStyle.fonts.base}}, axisBorder: {show: !1}, axisTicks: {show: !0, borderType: "solid", color: PurposeStyle.colors.gray[300], height: 6, offsetX: 0, offsetY: 0}},
    // fill: {type: "solid"},
    // markers: {size: 4, opacity: .7, strokeColor: "#fff", strokeWidth: 3, hover: {size: 7}},
    // grid: {borderColor: PurposeStyle.colors.gray[300], strokeDashArray: 5},
    // dataLabels: {enabled: !1}
    // }, a = (e.data().dataset, e.data().labels, e.data().color), n = e.data().height, o = e.data().type;
    // t.colors = [PurposeStyle.colors.theme[a]], t.markers.colors = [PurposeStyle.colors.theme[a]], t.chart.height = n || 350, t.chart.type = o || "line";
    // var i = new ApexCharts(e[0], t);
    // setTimeout(function () {
    // i.render()
    // }, 1000);
</script>



@endpush
