<?php $page = "Auto Responder"; ?>
@section('title')
    {{$page}}
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
           <a href="#" class="btn btn-sm btn btn-primary float-right " data-url="{{ url('autoresponder/create') }}" data-ajax-popup="true" data-size="lg" data-title="{{__('Create Compaign')}}">
        <span class="btn-inner--icon"><i class="fas fa-plus"></i></span>
    </a>
                <a href="{{ url('contacts/folder') }}" class="btn btn-sm btn btn-primary float-right mr-2 m-0">
        <span class="btn-inner--text ">{{__('Manage Folder')}}</span>
    </a>
                <a href="{{ route('contacts') }}" class="btn btn-sm btn btn-primary float-right mr-2 m-0">
        <span class="btn-inner--text ">{{__('Manage Contacts')}}</span>
    </a>
                     </div>
   
<!-- Breadcrumb -->
<div class="breadcrumb-bar mt-3">
    <div class="container-fluid">
        <div class="row align-items-center">
            <div class="col-md-12 col-12">
                <h2 class="breadcrumb-title">Auto Responder</h2>
                <nav aria-label="breadcrumb" class="page-breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{route('dashboard')}}">Home</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Auto Responder</li>
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
                                    <i class="fas fa-address-book"></i>
                                </div>
                            </div>
                            <div class="dash-widget-info">
                                <h3 data-id="total">{{($total??0)}}</h3>
                                <h6>Compaigns</h6>															
                            </div>
                        </div>
                    </div>

                    <div class="col-md-12 col-lg-4 dash-board-list yellow">
                        <div class="dash-widget">
                            <div class="circle-bar">
                                <div class="icon-col">
                                    <i class="fa fa-unlink"></i>
                                </div>
                            </div>
                            <div class="dash-widget-info">
                                <h3 data-id="folders">{{($total_folder??0)}}</h3>
                                <h6>{{__('Compaign Folders')}}</h6>															
                            </div>
                        </div>
                    </div>

                    <div class="col-md-12 col-lg-4 dash-board-list pink">
                        <div class="dash-widget">
                            <div class="circle-bar">
                                <div class="icon-col">
                                    <i class="fas fa-users"></i>
                                </div>
                            </div>
                            <div class="dash-widget-info">
                                <h3 data-id="inactive">{{($total_inactive??0)}}</h3>
                                <h6>{{__('InActive')}}</h6>															
                            </div>
                        </div>
                    </div>
                </div>

<br>

<div class="row " id="blog_view">
     <div class="col-12">
        <div class="card">
            <div class="card-body ">
                <div class="table-md-responsive">                    
                    <table class="table  table-hover table-center mb-0" id="yajra-datatable">
                        <thead class="thead-light ">
                              <tr>
                                <th > {{__(' Campaign')}}</th>
                        <th > {{__(' Template')}}</th>
                        <th > {{__(' Message')}}</th>
                        <th > {{__(' SMS')}}</th>
                        <th > {{__(' Status')}}</th>
                        <th > {{__(' Schedule')}}</th>
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
    var table = $('#yajra-datatable').DataTable({
         responsive: true,
        processing: true,
        serverSide: true,
        "bFilter": true,
        ajax: "{{ route('autoresponder.index') }}",
        columns: [
           
            {data: 'campaign_name', name: 'campaign_name',orderable: false},
            {data: 'template_name', name: 'template_name',orderable: false},
            {data: 'custom_message', name: 'custom_message',orderable: false},
            {data: 'custom_sms', name: 'custom_sms',orderable: false},
            {data: 'status', name: 'status',orderable: false},
            {
                data: 'typeOnChoice', 
                name: 'typeOnChoice', 
                orderable: false, 
                searchable: false
            },
            {data: 'action', name: 'action',orderable: false},
        ]
    });
    
  });

</script>


@endpush
