<?php $page = "Meeting Schedule Slots"; ?>
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
          
               
    
        <a href="{{ route('meeting.schedules.index') }}" class="btn btn-sm btn-primary float-right btn-icon-only rounded-circle " >
            <span class="btn-inner--icon"><i class="fas fa-reply"></i></span></a>
                 
                     </div>
   
<!-- Breadcrumb -->
<div class="breadcrumb-bar mt-3">
    <div class="container-fluid">
         
        <div class="row align-items-center">
            <div class="col-md-12 col-12">
                <h2 class="breadcrumb-title">Available Meeting Schedule Slots</h2>
                <nav aria-label="breadcrumb" class="page-breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{route('dashboard')}}">Home</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('meeting.schedules.index') }}">Meeting Schedules</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Meeting Schedule Slots</li>
                    </ol>
                </nav>
                 @php
                                 $slot_settings=\App\SiteSettings::getUserSettings('slot_booking_settings');
                                 
                                 @endphp
             <div class="custom-control custom-switch float-right">
                                    <input onclick="changestatus()" type="checkbox" class="custom-control-input" name="enable_slot_booking" id="enable_slot_booking" {{(!empty($slot_settings['enable_slot_booking']) && $slot_settings['enable_slot_booking'] == 'on') ? 'checked' : ''}}>
                                    <label class="custom-control-label form-control-label" for="enable_slot_booking">{{__('Enable Slots Booking')}}</label>
                                </div>
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
                                <th class=" mb-0 h6 text-sm"> {{__('Title')}}</th>
                                <th class=" mb-0 h6 text-sm"> {{__('Date')}}</th>
                                <th class=" mb-0 h6 text-sm"> {{__('Time Slot')}}</th>
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
        ajax: "{{ route('meeting.schedules.timings') }}",
        columns: [           
            {data: 'title', name: 'title',orderable: false},
            {data: 'date', name: 'date',orderable: true},
            {data: 'time', name: 'time',orderable: true},
            {
                data: 'action', 
                name: 'action', 
                orderable: false, 
                searchable: false
            },
        ]
    });
    
  });


function changestatus(){    
    
                 $.ajax({
                url: '{{ route('site.settings.store') }}',
                data: {from:'booking_slots'},
                success: function (data) {
                     
                      show_toastr('Success!', "Slot Settings Updated!", 'success');
                }
            });
     
  }
</script>


@endpush
