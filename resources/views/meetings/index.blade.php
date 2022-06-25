<?php $page = "Meeting Schedules"; ?>
@section('title')
    {{$page??''}}
@endsection
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
                <div class=" col-md-12 ">
           <a href="#" class="btn btn-sm btn btn-primary float-right " data-url="{{ route('meeting.schedule.create') }}" data-ajax-popup="true" data-size="lg" data-title="{{__('Add Meeting Schedule')}}">
        <span class="btn-inner--icon"><i class="fas fa-plus"></i></span>
    </a>
             
    
                    <a href="{{ route('meeting.schedules.timings') }}" class="btn btn-sm btn btn-primary float-right mr-2 m-0">
        <span class="btn-inner--text ">{{__('Schedule Timings')}}</span>
    </a>
                    <a href="{{ route('meeting.schedules.bookings') }}" class="btn btn-sm btn btn-primary float-right mr-2 m-0">
        <span class="btn-inner--text ">{{__('Bookings')}}</span>
    </a>
                    <a href="{{ route('meeting.schedules.bookings.canceled') }}" class="btn btn-sm btn btn-primary float-right mr-2 m-0">
        <span class="btn-inner--text ">{{__('Canceled Bookings')}}</span>
    </a>
                     </div>
   
<!-- Breadcrumb -->
<div class="breadcrumb-bar mt-3">
    <div class="container-fluid">
        <div class="row align-items-center">
            <div class="col-md-12 col-12">
                <h2 class="breadcrumb-title">Meeting Schedules</h2>
                <nav aria-label="breadcrumb" class="page-breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{route('dashboard')}}">Home</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Meeting Schedules</li>
                    </ol>
                </nav>
            </div>              
        </div>            
    </div>
</div>
<!-- /Breadcrumb -->


<div class="row mt-3 blockWithFilter">
                    <div class="col-md-12 col-lg-4 dash-board-list blue">
                        <div class="dash-widget">
                            <div class="circle-bar">
                                <div class="icon-col">
                                    <i class="fa fa-adjust"></i>
                                </div>
                            </div>
                            <div class="dash-widget-info">
                                <h3 data-id="schedules">{{$schedules}}</h3>
                                <h6>Schedules</h6>															
                            </div>
                        </div>
                    </div>

                    <div class="col-md-12 col-lg-4 dash-board-list yellow">
                        <div class="dash-widget">
                            <div class="circle-bar">
                                <div class="icon-col">
                                    <i class="fas fa-bookmark"></i>
                                </div>
                            </div>
                            <div class="dash-widget-info">
                                <h3 data-id="bookings">{{$bookings}}</h3>
                                <h6>{{__('Bookings')}}</h6>															
                            </div>
                        </div>
                    </div>

                    <div class="col-md-12 col-lg-4 dash-board-list pink">
                        <div class="dash-widget">
                            <div class="circle-bar">
                                <div class="icon-col">
                                    <i class="fa fa-money-bill-alt"></i>
                                </div>
                            </div>
                            <div class="dash-widget-info">
                                <h3 data-id="revenue">{{format_price($revenue)}}</h3>
                                <h6>{{__('Revenue')}}</h6>															
                            </div>
                        </div>
                    </div>
                </div>

<br>


<div class="row mt-3" id="blog_view">
     <div class="col-12">
        <div class="card">
            <div class="card-body ">
                <div class="table-md-responsive display responsive nowrap">
                    
                    <table class="table table-hover table-center mb-0" id="myTable">
                        <thead class="thead-light">
                            <tr>
                                <th class=" mb-0 h6 text-sm"> {{__('Title')}}</th>
                                <th class=" mb-0 h6 text-sm"> {{__('Service Type')}}</th>
                                <th class=" mb-0 h6 text-sm"> {{__('Status')}}</th>
                                <th class=" mb-0 h6 text-sm"> {{__('Price')}}</th>
                                <th class=" mb-0 h6 text-sm"> {{__('Time Slots')}}</th>
                                <th class="text-right name mb-0 h6 text-sm"> {{__('Action')}}</th>
                            </tr>
                        </thead>
                         
                    </table>
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


<script type="text/javascript">
    

    $(function () {    
    var table = $('#myTable').DataTable({
         responsive: true,
        processing: true,
        serverSide: true,
        ajax: "{{ route('meeting.schedules.index') }}",
        columns: [
           
            {data: 'title', name: 'title',orderable: true},
            {data: 'service_type', name: 'service_type',orderable: false},
            {data: 'status', name: 'status',orderable: false},
            {data: 'price', name: 'price',orderable: true},
            {data: 'slots', name: 'slots',orderable: false},
            {
                data: 'action', 
                name: 'action', 
                orderable: false, 
                searchable: false
            },
        ]
    });
    
  });

</script>


@endpush
