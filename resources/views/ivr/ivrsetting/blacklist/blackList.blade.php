@php $page = "ivrsetting"; @endphp
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
				<!-- Breadcrumb -->
				<div class="breadcrumb-bar mt-3">
                        <div class="col-md-12">
                            <a href="{{  route('create.black.list') }}" class="btn btn-sm btn btn-primary float-right " data-title="Add Blog Post">
                                <span class="btn-inner--icon"><i class="fas fa-plus"></i></span>
                            </a>
                        </div>
				    <div class="container-fluid">
				        <div class="row align-items-center">
				            <div class="col-md-12 col-12">
				                <h2 class="breadcrumb-title">Blocked Numbers</h2>
				                <nav aria-label="breadcrumb" class="page-breadcrumb">
				                    <ol class="breadcrumb">
				                        <li class="breadcrumb-item"><a href="{{route('dashboard')}}">Home</a></li>
				                        <li class="breadcrumb-item active" aria-current="page">Blocked Numbers</li>
				                    </ol>
				                </nav>
				            </div>
				        </div>


				    </div>
				</div>

					<div class="card-body">
                        <div class="table-responsive">
                            <table class="table mb-0" id="example">
                                <thead class="thead-light">
                                <tr>
                                    <th class=" mb-0 h6 text-sm"> {{__('Type')}}</th>
                                    <th class=" mb-0 h6 text-sm"> {{__('Value')}}</th>
                                    <th class=" mb-0 h6 text-sm"> {{__('Status')}}</th>
                                    <th class=" mb-0 h6 text-sm"> {{__('Created')}}</th>
                                    <th class="text-center class="name mb-0 h6 text-sm"> {{__('Action')}}</th>
                                </tr>
                                </thead>
                            </table>
                        </div>
		            </div>  <!-- /card-body -->
            </div>        <!-- /col-md-7 col-lg-8 col-xl-9 -->
        </div>
    </div> <!-- /container-fluid -->
</div>

<!-- Modal -->
<div id="destroyblog" class="modal fade" role="dialog" >
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
                {{ Form::open(['url' => 'ivr/black-list/destroy','id' => 'destroy_blog','enctype' => 'multipart/form-data']) }}
                <input type="hidden" name="blacklist_id" id="blacklist_id"  value="">

                <button type="submit" class="btn btn-sm btn-danger rounded-pill" id="">Yes</button>
                {{ Form::close() }}
                <button type="button" class="btn btn-sm btn-secondary rounded-pill" id="" data-dismiss="modal" aria-label="Close">Cancel</button>
            </div>
        </div>
    </div>
</div>
<!-- /Page Content -->
@endsection


@push('script')
<script>
    $(document).on("click", ".destroyblog", function(){
        var id = $(this).attr('data-id');
        $("#blacklist_id").val(id);
        $('#destroyblog').modal('show');
    });

    $(function () {
        var table = $('#example').DataTable({
            processing: true,
            serverSide: true,

            ajax: {
                url : "{{ url('/ivr/black-list') }}",
                data: function (d) {
                    d.search = $('input[type="search"]').val()
                }
            },
            columns: [

                {data: 'type', name: 'type'},
                {data: 'value', name: 'value'},
                {data: 'status', name: 'status'},
                {data: 'created_at', name: 'created_at'},
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
