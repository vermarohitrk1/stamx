<?php $page = "Meeting Schedules Booked"; ?>
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
          
             
    
         <a href="{{ route('meeting.schedules.booked') }}" class="btn btn-sm btn-primary float-right btn-icon-only rounded-circle " >
            <span class="btn-inner--icon"><i class="fas fa-reply"></i></span></a>
                    
                     </div>
   
<!-- Breadcrumb -->
<div class="breadcrumb-bar mt-3">
    <div class="container-fluid">
        <div class="row align-items-center">
            <div class="col-md-12 col-12">
                <h2 class="breadcrumb-title">Meeting Schedules Canceled Bookings</h2>
                <nav aria-label="breadcrumb" class="page-breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{route('dashboard')}}">Home</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('meeting.schedules.index') }}">Meeting Schedules</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Meeting Schedules Canceled Bookings</li>
                    </ol>
                </nav>
            </div>              
        </div>            
    </div>
</div>
<!-- /Breadcrumb -->




<div class="row mt-3" id="blog_view">
     <div class="col-12">
        <div class="card">
            <div class="card-body ">
                <div class="table-md-responsive">
                    
                    <table class="table table-hover table-center mb-0" id="myTable">
                        <thead class="thead-light">
                            <tr>
                                <th class=" mb-0 h6 text-sm"> {{__('Booked With')}}</th>
                                <th class=" mb-0 h6 text-sm"> {{__('Service')}}</th>
                                <th class=" mb-0 h6 text-sm"> {{__('Date')}}</th>
                                <th class=" mb-0 h6 text-sm"> {{__('Scheduled Timing')}}</th>
                                <th class=" mb-0 h6 text-sm"> {{__('Canceled At')}}</th>
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
        ajax: "{{ route('meeting.schedules.canceled') }}",
        columns: [           
            {data: 'user', name: 'user',orderable: true},
            {data: 'title', name: 'title',orderable: false},
            {data: 'date', name: 'date',orderable: true},
            {data: 'time', name: 'time',orderable: true},
            {data: 'canceled_at', name: 'canceled_at',orderable: false},
            {
                data: 'action', 
                name: 'action', 
                orderable: false, 
                searchable: false
            },
        ]
    });
    
  });
function changestatus(id){
      if(id !=""){
      var data = {
                        id: id
                    }
                 $.ajax({
                url: '{{ route('meeting.schedules.bookings.accomplished') }}',
                data: data,
                success: function (data) {
                     
                }
            });
        }
  }
</script>


@endpush
