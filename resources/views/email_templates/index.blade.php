<?php $page = "Email Templates"; ?>
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
           <a href="#" class="btn btn-sm btn btn-primary float-right " data-url="{{ route('email_template.create') }}" data-ajax-popup="true" data-size="lg" data-title="{{__('Add Email Template')}}">
                <span class="btn-inner--icon"><i class="fas fa-plus"></i></span>
            </a>
         
            
                     </div>
   
<!-- Breadcrumb -->
<div class="breadcrumb-bar mt-3">
    <div class="container-fluid">
        <div class="row align-items-center">
            <div class="col-md-12 col-12">
                <h2 class="breadcrumb-title">Email Templates</h2>
                <nav aria-label="breadcrumb" class="page-breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{route('dashboard')}}">Home</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Email Templates</li>
                    </ol>
                </nav>
            </div>              
        </div>            
    </div>
</div>
<!-- /Breadcrumb -->


<div class="row " id="blog_view">
     <div class="col-12">
        <div class="card">
            <div class="card-body ">
                <div class="table-md-responsive">                    
                    <table class="table  table-hover table-center mb-0" id="yajra-datatable">
                        <thead class="thead-light ">
                              <tr>
                                <th > {{__('Template Name')}}</th>
                                <th > {{__('Integration Place')}}</th>
                                <th > {{__('Status')}}</th>
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
<link rel="stylesheet" href="{{ asset('assets/libs/bootstrap-tagsinput/dist/bootstrap-tagsinput-typeahead.css') }}">
<script src="{{ asset('assets/libs/bootstrap-tagsinput/dist/bootstrap-tagsinput.min.js') }}"></script>

<script type="text/javascript">
    

    $(function () {    
    var table = $('#yajra-datatable').DataTable({
         responsive: true,
        processing: true,
        serverSide: true,
        ajax: "{{ route('email_template.index') }}",
        columns: [
           
            {data: 'name', name: 'name',orderable: false},
            {data: 'for', name: 'for',orderable: false},
            {data: 'status', name: 'status',orderable: false},
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
