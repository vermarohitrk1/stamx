<?php $page = "mycourses"; ?>
@extends('layout.dashboardlayout')
@section('content')	

<style>
.custom-control-input:checked~.custom-control-label::before {
    color: #fff;
    border-color: #009da6;
    background-color: #009da6;
}
.modal-open .main-wrapper {
    -webkit-filter: blur(1px);
    -moz-filter: blur(1px);
    -o-filter: blur(1px);
    -ms-filter: blur(1px);
    filter: inherit;
}

i.fa.fa-calendar {
    margin-right: 6px !important;
}
.modal {
    z-index: 9999;
	margin-top: 1rem;
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
                
                     <a href="{{ route('certify.index') }}" id="back" class="btn btn-sm btn-primary float-right ml-2">
        <span class="btn-inner--icon"><i class="fas fa-reply"></i></span>
    </a>
                
       
		
	

                     </div>
   
<!-- Breadcrumb -->
<div class="breadcrumb-bar mt-3">
    <div class="container-fluid">
        <div class="row align-items-center">
            <div class="col-md-12 col-12">
                <h2 class="breadcrumb-title">Catalog</h2>
                <nav aria-label="breadcrumb" class="page-breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{route('dashboard')}}">Home</a></li>
                        <li class="breadcrumb-item active" aria-current="page">My Courses</li>
                    </ol>
                </nav>
            </div>              
        </div>            
    </div>
</div>
<!-- /Breadcrumb -->



<div class="row" id="certifyView">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                     <div class="table-md-responsive">                    
                    <table class="table  table-hover table-center mb-0" id="yajra-datatable">
                        <thead class="thead-light ">
                            
                   
                            <tr>
                               <th class="name mb-0 h6 text-sm"> {{__('Name')}}</th>
                                <th class="name mb-0 h6 text-sm"> {{__('Price')}}</th>
                                <th class="name mb-0 h6 text-sm"> {{__('Duration')}}</th>
                                <th class="name mb-0 h6 text-sm"> {{__('Status')}}</th>
                                <th class="text-center name mb-0 h6 text-sm"> {{__('Action')}}</th>
                              
                            </tr>
                            </thead>
                            <tbody>

                            </tbody>
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

    <!-- Modal -->
    <div id="addCertify" class="modal fade" role="dialog">
        <div class="modal-dialog">
            <!-- Modal content-->
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Are You Sure?</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">??</span>
                    </button>
                </div>
                <div class="modal-body">
                    Remove This Certify in MyCourses.<br>
                    This action can not be undone. Do you want to continue?
                </div>
                <div class="modal-footer">
                    {{ Form::open(['url' => 'certify/corporate/remove/certify','id' => 'addCertifyCorpurate','enctype' => 'multipart/form-data']) }}
                    <input type="hidden" name="corpurate_certify" id="corpurate_certify" value="">

                    <button type="submit" class="btn btn-sm btn-danger rounded-pill" id="">Yes</button>
                    {{ Form::close() }}
                    <button type="button" class="btn btn-sm btn-secondary rounded-pill" id="" data-dismiss="modal"
                            aria-label="Close">Cancel
                    </button>
                </div>
            </div>
        </div>
    </div>

@endsection

@push('script')
    <script type="text/javascript">
  
        $(function () {
    var table = $('#yajra-datatable').DataTable({
        responsive: true,
        processing: true,
        serverSide: true,
        ajax: "{{ route('certify.corpurate.mycourses') }}",
        columns: [
		
        
                {data: 'name', name: 'name',orderable: true,searchable: true},
            {data: 'price', name: 'price',orderable: true},
                    {data: 'duration', name: 'duration', orderable: false},
                    {data: 'status', name: 'status', orderable: false},
                    {
                        data: 'action',
                        name: 'action',
                        orderable: false,
                        searchable: false
                    },
                ]
    });

  });
      
		 $(document).on("click", ".addCertify", function () {
            var id = $(this).attr('data-id');
            $("#corpurate_certify").val(id);
            $('#addCertify').modal('show');
        });
    </script>

@endpush
