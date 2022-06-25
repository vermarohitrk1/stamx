<?php $page = "book"; ?>
@extends('layout.dashboardlayout')
@section('content')	

<style>
  .bg-success, .badge-success {
    background-color: #d62757 !important;
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
               <a href="{{ route('pathway.create') }}" class="btn btn-sm btn btn-primary float-right "  data-title="{{__('Create pathway')}}">
                 <span class="btn-inner--icon"><i class="fas fa-plus"></i></span>
               </a>
          
                     </div>
   
<!-- Breadcrumb -->
<div class="breadcrumb-bar mt-3">
    <div class="container-fluid">
        <div class="row align-items-center">
            <div class="col-md-12 col-12">
                <h2 class="breadcrumb-title">Pathways</h2>
                <nav aria-label="breadcrumb" class="page-breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="index">Home</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Pathways</li>
                    </ol>
                </nav>
            </div>              
        </div>            
    </div>
</div>
<!-- /Breadcrumb -->

<div class="row blockWithFilter">
          <div class="col-md-12 col-lg-3 dash-board-list green">
                        <div class="dash-widget">
                            <div class="circle-bar">
                                <div class="icon-col">
                                    <i class="fa fa-list"></i>
                                </div>
                            </div>
                            <div class="dash-widget-info">
                          
                                <h3 data-id="pathway">0 </h3>
                                <h6>Own</h6>	
                                
                                
                            </div>
                        </div>
                    </div>
    <div class="col-md-12 col-lg-3 dash-board-list pink">
                        <div class="dash-widget">
                            <div class="circle-bar">
                                <div class="icon-col">
                                    <i class="fa fa-list"></i>
                                </div>
                            </div>
                            <div class="dash-widget-info">
                          
                                <h3 data-id="invitation">0</h3>
                                <h6>Received</h6>	
                                
                                
                            </div>
                        </div>
                    </div>
          <div class="col-md-12 col-lg-3 dash-board-list yellow">
                        <div class="dash-widget">
                            <div class="circle-bar">
                                <div class="icon-col">
                                    <i class="fa fa-list"></i>
                                </div>
                            </div>
                            <div class="dash-widget-info">
                             
                                  <h3 data-id="task">0</h3>
                                <h6>Tasks</h6>															
                            </div>
                        </div>
                    </div>
                    <div class="col-md-12 col-lg-3 dash-board-list blue">
                        <div class="dash-widget">
                            <div class="circle-bar">
                                <div class="icon-col">
                                    <i class="fa fa-users"></i>
                                </div>
                            </div>
                            <div class="dash-widget-info">
                             
                                  <h3 data-id="member">0 </h3>
                                <h6>Members</h6>															
                            </div>
                        </div>
                    </div>
                    
                    
                    
     
                    
         
                    
                </div>

<div class="col-md-12 col-lg-12 col-xl-12">
             
                <!-- Mentee List Tab -->
                <div class="tab-pane show active" id="mentee-list">
                    <div class="content container-fluid" style="min-height: 79.6588px;">

        <!-- Tab Menu -->
        <nav class="user-tabs mb-4 custom-tab-scroll">
            <ul class="nav nav-tabs nav-tabs-bottom nav-justified">
                <li>
                    <a class="nav-link active" href="#mailersettings" data-toggle="tab">Owned</a>
                </li>
                <li>
                    <a class="nav-link updateseen" href="#paymentgateway" data-toggle="tab">Invitations Received 
                        @php
                         $countdata = \App\PathwayInvitation::where('seen',1)->where('user_id',Auth::user()->id)->count();
                       if($countdata >0 ){ @endphp
                        <div class="badge badge-success badge-pill fill-red">
                        @php   echo $countdata;  @endphp
                           </div>
                     @php   }
                         @endphp
                    </a>
                </li>
                
            </ul>
        </nav>
        <!-- /Tab Menu -->

        <!-- Tab Content -->
        <div class="tab-content">

            <!-- General -->
            <div role="tabpanel" id="mailersettings" class="tab-pane fade active show">

                <!-- Page Header -->

  <div class="card">
            <div class="card-body">
                <div class="table-md-responsive">
                    <table style="width:100%;" class="table table-hover table-center mb-0" id="example">
                        <thead class="thead-light">
                        <tr>
                          
                            <th class=" mb-0 h6 text-sm"> {{__('Type')}}</th>
                            <th class=" mb-0 h6 text-sm"> {{__('Mentor type')}}</th>
                            <th class=" mb-0 h6 text-sm"> {{__('Timeline')}}</th>
                            <th class=" mb-0 h6 text-sm"> {{__('Reminder')}}</th>
                            <th class=" mb-0 h6 text-sm"> {{__('Value($)')}}</th>
                            <th class=" mb-0 h6 text-sm"> {{__('Invite')}}</th>
                            <th class="text-right name mb-0 h6 text-sm"> {{__('Action')}}</th>
                        </tr>
                        </thead> 
                    </table>
                </div>
            </div>
        </div>

               
            </div>
            <!-- /General -->

            <!-- Payment gateway -->
            <div role="tabpanel" id="paymentgateway" class="tab-pane fade">

                <!-- Page Header -->
                

  <div class="card">
            <div class="card-body">
                <div class="table-md-responsive">
                    <table  style="width:100%;" class="table table-hover table-center mb-0" id="invited">
                        <thead class="thead-light">
                        <tr>
                           
                            <th class=" mb-0 h6 text-sm"> {{__('Type')}}</th>
                            <th class=" mb-0 h6 text-sm"> {{__('Mentor type')}}</th>
                            <th class=" mb-0 h6 text-sm"> {{__('Timeline')}}</th>
                            <th class=" mb-0 h6 text-sm"> {{__('Reminder')}}</th>
                            <th class=" mb-0 h6 text-sm"> {{__('Status')}}</th>
                            <th class="text-right name mb-0 h6 text-sm"> {{__('Action')}}</th>
                        </tr>
                        </thead> 
                    </table>
                </div>
            </div>
        </div>

            </div>
            <!-- /Payment gateway -->
            
         

        

        </div>
        <!-- /Tab Content -->

    </div>
                </div>
                <!-- /Mentee List Tab -->
            </div>


            </div>
        </div>

    </div>

</div>		
<!-- /Page Content -->
@endsection
@push('script')

<!--<script type="text/javascript" src="{{ asset('datatables/datatables.min.js') }}"></script>-->



<script type="text/javascript">


$(function () {    
    var table = $('#example').DataTable({
        responsive: true,
        processing: true,
        serverSide: true,
        "bLengthChange": false,
        ajax: "{{ url('/pathway') }}",
        columns: [
          
          {data: 'type', name: 'type',orderable: true,searchable: true},
          {data: 'mentor_type', name: 'mentor_type',orderable: true,searchable: true},
          {data: 'timeline', name: 'timeline'},
          {data: 'reminder_type', name: 'reminder_type'},
          {data: 'dollar', name: 'dollar'},
          {
              data: 'invite', 
              name: 'invite', 
              orderable: false, 
              searchable: false
          },
           {
              data: 'action', 
              name: 'action', 
              orderable: false, 
              searchable: false
          },
        
      ],
    });
    
  });

  $(function () {    
    var table = $('#invited').DataTable({
        responsive: true,
        processing: true,
        serverSide: true,
        "bLengthChange": false,
        ajax: "{{ url('/pathwayInvited') }}",
        columns: [
          
            {data: 'type', name:'type',orderable: true,searchable: true},
            {data: 'mentor_type', name: 'mentor_type',orderable: true,searchable: true},
            {data: 'timeline', name: 'timeline'},
            {data: 'reminder_type', name: 'reminder_type'},
            {
                data: 'status', 
                name: 'status', 
                orderable: false, 
                searchable: false
            },
             {
                data: 'action', 
                name: 'action', 
                orderable: false, 
                searchable: false
            },
          
        ],
    });
    
  });
  
  $(document).on("click",".updateseen",function() {
    
    var type = $(this).data('type');
     var data = {
                 status: status,
                }
                 $.ajax({
                url: '{{ route('pathwayinvitation.change.seen') }}',
                data: data,
                success: function (data) {
                  $('.updateseen').children().hide();
                     
                }
            });
            
            });
</script>

@endpush
