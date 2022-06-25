<?php $page = "Certify"; ?>
@extends('layout.dashboardlayout')
@section('content')	
<style>
.modal-open .main-wrapper {
    -webkit-filter: blur(1px);
    -moz-filter: blur(1px);
    -o-filter: blur(1px);
    -ms-filter: blur(1px);
    filter: inherit;
}
p#CourName {
    display: contents;
}
.modal {
    z-index: 9999;
	margin-top: 1rem;
}
.modal {
    padding-top: 5rem !important;
}
.modal-bodyc.text-center {
    padding: 20px;
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
                    @php
                    $permissions=permissions();
                    @endphp
				<a href="{{ route('wallet.tutionrequest') }}" id="back" class="btn btn-sm btn-primary float-right ml-2">
				<span class="btn-inner--icon"><i class="fas fa-reply"></i></span>
				</a>
    
                     </div>
   
<!-- Breadcrumb -->
<div class="breadcrumb-bar mt-3">
    <div class="container-fluid">
        <div class="row align-items-center">
            <div class="col-md-12 col-12">
                <h2 class="breadcrumb-title">Coupon History</h2>
                <nav aria-label="breadcrumb" class="page-breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{route('dashboard')}}">Home</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Coupon History</li>
                    </ol>
                </nav>
            </div>              
        </div>            
    </div>
</div>
<!-- /Breadcrumb -->


<br>


<div class="row" id="certifyView">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                     <div class="table-md-responsive">                    
                    <table class="table  table-hover table-center mb-0" id="yajra-datatable">
                        <thead class="thead-light ">
                            
                   
                            <tr>
                             <th class="name mb-0 h6 text-sm"> {{__('Name')}}</th>
                                <th class="name mb-0 h6 text-sm"> {{__('Course Name')}}</th>
                                <th class="name mb-0 h6 text-sm"> {{__('Price')}}</th>
                                <th class="name mb-0 h6 text-sm"> {{__('Status')}}</th>
                                <th class="name mb-0 h6 text-sm"> {{__('Action')}}</th>
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
  <!-- Modal -->
    <div id="destroyCertify" class="modal fade" role="dialog">
        <div class="modal-dialog">
            <!-- Modal content-->
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Are You Sure?</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <div class="modal-body">
                    This action can not be undone. Do you want to continue?
                </div>
                <div class="modal-footer">
                    {{ Form::open(['url' => 'tution/coupon/history/delete','id' => 'destroy_certify_request','enctype' => 'multipart/form-data']) }}
                    <input type="hidden" name="id" id="delete_id" value="">
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
        $(document).on("click", ".destroyblog", function(){
    var id = $(this).attr('data-id');
    console.log(id);
    $("#blog_id").val(id);
    $('#destroyblog').modal('show');

});
        $(function () {
    var table = $('#yajra-datatable').DataTable({
        responsive: true,
        processing: true,
        serverSide: true,
                      ajax: "{{ route('tution.coupon.history') }}",
                columns: [
                    {data: 'name', name: 'name', orderable: false, searchable: false},
                    {data: 'certify', name: 'certify', orderable: false},
                    {data: 'price_limit', name: 'price_limit', orderable: false},
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
       var hiddenPrice = '';
        $(document).ready(function () {
            $('#myTable').DataTable();
        });
        $(document).on("click", ".destroyCertify", function () {
            var id = $(this).attr('data-id');
            $("#delete_id").val(id);
            $('#destroyCertify').modal('show');
        });
    </script>
 
@endpush
