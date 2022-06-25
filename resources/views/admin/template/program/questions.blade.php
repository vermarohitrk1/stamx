@extends('layout.mainlayout_admin')
@section('content')		

<!-- Page Wrapper -->
<div class="page-wrapper">
    <div class="content container-fluid">

        <!-- Page Header -->
        <div class="page-header">
            <div class="row">
                <div class="col-sm-12">
                    <h3 class="page-title">Programable Questions</h3>
                    <ul class="breadcrumb">
                        <li class="breadcrumb-item"><a href="index">Dashboard</a></li>
                        <li class="breadcrumb-item active">Programable Questions</li>
                    </ul>
                </div>
            </div>
        </div>
        <!-- /Page Header -->

        <div class="row">
            <div class="col-sm-12">
                <div class="card">
                    <div class="card-body">

                        <a class="btn btn-sm btn-primary .btn-rounded float-right" href="#"  data-ajax-popup="true" data-url="{{route('programable_question.create')}}" data-size="md" data-title="{{__('Add Question')}}">
                            <i class="fas fa-plus"></i>
                            Add
                        </a>
                        <div class="table-responsive-md">
                            
                            <table class=" table table-hover table-center mb-0" id="myTableQuestion">
                            <thead class="thead-light ">
                                    <tr>
                                      
                                        <th>Question</th>
                                        <th>Type</th>
                                        <th>Value</th>
                                       
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
        var table = $('#myTableQuestion').DataTable({
              responsive: true,
            processing: true,
            serverSide: true,
             "bFilter": false,
            ajax: "{{ route('programable_questions') }}",
            columns: [
               
                {data: 'question', name: 'question', orderable: false},
                {data: 'type', name: 'type', orderable: false},
                {data: 'value', name: 'value', orderable: false,searchable: false},
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