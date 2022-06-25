<?php $page = "Group chat"; ?>
@extends('layout.dashboardlayout')
@section('content')	
<style>
table#example {
    width: 100% !important;
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
               <a href="{{ route('chat.group.create') }}" class="btn btn-sm btn btn-primary float-right "  data-title="{{__('Add Group')}}">
        <span class="btn-inner--icon"><i class="fas fa-plus"></i></span>
    </a>
                
                     </div>
   
<!-- Breadcrumb -->
<div class="breadcrumb-bar mt-3">
    <div class="container-fluid">
        <div class="row align-items-center">
            <div class="col-md-12 col-12">
                <h2 class="breadcrumb-title">Chat Groups</h2>
                <nav aria-label="breadcrumb" class="page-breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{route('dashboard')}}">Home</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Chat Groups</li>
                    </ol>
                </nav>
            </div>              
        </div>            
    </div>
</div>
<!-- /Breadcrumb -->


<div class="row mt-3">
                

                    <div class="col-md-12 col-lg-6 dash-board-list yellow">
                        <div class="dash-widget">
                            <div class="circle-bar">
                                <div class="icon-col">
                                    <i class="fas fa-users"></i>
                                </div>
                            </div>
                            <div class="dash-widget-info">
                                <h3>{{($own??0)}}</h3>
                                <h6>Own Groups</h6>															
                            </div>
                        </div>
                    </div>

                    <div class="col-md-12 col-lg-6 dash-board-list pink">
                        <div class="dash-widget">
                            <div class="circle-bar">
                                <div class="icon-col">
                                    <i class="fas fa-users"></i>
                                </div>
                            </div>
                            <div class="dash-widget-info">
                                <h3>{{($others?? 0)}}</h3>
                                <h6>Other Groups</h6>															
                            </div>
                        </div>
                    </div>
                </div>

<br>


<div class="row" id="blog_view">
     <div class="col-12">
        <div class="card">
            <div class="card-body ">
                <div class="table-md-responsive">
                    <table class="table table-hover table-center mb-0" id="example">
                        <thead class="thead-light">
                        <tr>
                             <th class=" mb-0 h6 text-sm"> {{__(' Image')}}</th>
                        <th class=" mb-0 h6 text-sm"> {{__(' Name')}}</th>
                        <th class=" mb-0 h6 text-sm"> {{__(' Description')}}</th>
                        <th class=" mb-0 h6 text-sm"> {{__(' Members')}}</th>
                       
                        <th class=" mb-0 h6 text-sm"> {{__(' Action')}}</th>
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

<!--<script type="text/javascript" src="{{ asset('datatables/datatables.min.js') }}"></script>-->



<script type="text/javascript">


$(function () {    
    var table = $('#example').DataTable({
         responsive: true,
        processing: true,
        serverSide: true,
         ajax: "{{ route('chat.groups.list') }}",
        columns: [
        
                {data: 'image', name: 'image'},
            {data: 'name', name: 'name'},
            {data: 'description', name: 'description'},
            {data: 'members', name: 'members'},
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