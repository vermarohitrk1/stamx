@extends('layout.mainlayout_admin')
@section('content')		

<!-- Page Wrapper -->
<div class="page-wrapper">
    <div class="content container-fluid">

        <!-- Page Header -->
        <div class="page-header">
            <div class="row">
                <div class="col-sm-12">
                    <h3 class="page-title">Roles</h3>
                    <ul class="breadcrumb">
                        <li class="breadcrumb-item"><a href="index">Dashboard</a></li>
                        <li class="breadcrumb-item active">Roles</li>
                    </ul>
                </div>
            </div>
        </div>
        <!-- /Page Header -->

        <div class="row">
            <div class="col-sm-12">
                <div class="card">
                    <div class="card-body">

                        <a class="btn btn-sm btn-primary .btn-rounded float-right" href="#" data-url="{{route('role.create')}}" data-ajax-popup="true" data-size="md" data-title="{{__('Add Role')}}">
                            <i class="fas fa-plus"></i>
                            Add
                        </a>
                        <div class="table-responsive-md">
                            
                            <table class=" table table-hover table-center mb-0" id="myTable">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Role</th>
                                        <th>Status</th>
                                        <th class="text-right">Action</th>
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
<!-- /Page Wrapper -->

@endsection

@push('script')

<script type="text/javascript">
$(document).on("click", ".delete_record_model", function(){
$("#common_delete_form").attr('action',$(this).attr('data-url'));
$('#common_delete_model').modal('show');
});

    $(function () {
        var table = $('#myTable').DataTable({
             responsive: true,
            processing: true,
            serverSide: true,
             "bFilter": false,
            ajax: "{{ route('roles') }}",
            columns: [
                {data: 'DT_RowIndex', name: 'DT_RowIndex', orderable: false, searchable: false},
                {data: 'role', name: 'role', orderable: false, searchable: true},
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



</script> 

@endpush