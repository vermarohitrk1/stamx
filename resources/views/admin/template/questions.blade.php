<?php $page = "partner"; ?>
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
                
                    <a class="btn btn-sm btn-primary .btn-rounded float-right" href="#"  data-ajax-popup="true" data-url="{{route('question.create')}}" data-size="md" data-title="{{__('Add Question')}}">
            <span class="btn-inner--icon"><i class="fas fa-plus"></i></span>
        </a>
                </div>
   
<!-- Breadcrumb -->
<div class="breadcrumb-bar mt-3">
    <div class="container-fluid">
        <div class="row align-items-center">
            <div class="col-md-12 col-12">
                <h2 class="breadcrumb-title">Question</h2>
                <nav aria-label="breadcrumb" class="page-breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="index">Home</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Question</li>
                    </ol>
                </nav>
            </div>              
        </div>            
    </div>
</div>
<!-- /Breadcrumb -->



<br>

<div class="row" id="blog_view">
     <div class="col-12">
        <div class="card">
            <div class="card-body">
             

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

<!-- Modal -->
<div id="destroyblog" class="modal fade" role="dialog">
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
          {{ Form::open(['url' => 'cms/destroy','id' => 'destroy_blog','enctype' => 'multipart/form-data']) }}
          <input type="hidden" name="id" id="blog_id"  value="">

        <button type="submit" class="btn btn-sm btn-danger rounded-pill" id="">Yes</button>
        {{ Form::close() }}
        <button type="button" class="btn btn-sm btn-secondary rounded-pill" id="" data-dismiss="modal" aria-label="Close">Cancel</button>
      </div>
    </div>
  </div>
</div>
<!--end modal-->

</div>
</div>
</div>
</div>
@endsection

@push('script')

<script type="text/javascript">
$(document).on("click", ".delete_record_model", function(){
$("#common_delete_form").attr('action',$(this).attr('data-url'));
$('#common_delete_model').modal('show');
});


    $(function () {
        var table = $('#myTableQuestion').DataTable({
            processing: true,
            serverSide: true,
             responsive: true,
            ajax: "{{ route('questions') }}",
            columns: [
               
                {data: 'question', name: 'question', searchable: true},
                {data: 'type', name: 'type'},
                {data: 'value', name: 'value', orderable: true},
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