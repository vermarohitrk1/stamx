<?php $page = "blog"; ?>
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
                   <a href="{{ route('dashboard') }}" class="btn btn-sm btn-primary float-right btn-icon-only rounded-circle " >
        <span class="btn-inner--icon"><i class="fas fa-reply"></i></span>
    </a>
                     </div>
   
<!-- Breadcrumb -->
<div class="breadcrumb-bar mt-3">
    <div class="container-fluid">
        <div class="row align-items-center">
            <div class="col-md-12 col-12">
                <h2 class="breadcrumb-title">Program Listing</h2>
                <nav aria-label="breadcrumb" class="page-breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Home</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Program form</li>
                    </ol>
                </nav>
            </div>              
        </div>            
    </div>
</div>
<!-- /Breadcrumb -->




<div class="row mt-3" id="blog_view">
     <div class="col-12">
        <div class="card">
            <div class="card-body p-0">
   
            <div class="row">
            <div class="col-sm-12">
                <div class="card">
                    <div class="card-body">
                    <?php if($apply_p == 1){ ?> 
                            <a class="btn btn-sm btn-primary .btn-rounded float-right" href="{{route('program.create')}}">
                            <i class="fas fa-plus"></i>
                            Add
                            </a>
                            <?php }else{ ?>
                            <a class="btn btn-sm btn-danger .btn-rounded float-right" >
                         
                            Not Available
                            </a>
                            <?php } ?>
                        <div class="table-responsive-md">
                            
                            <table class=" table table-hover table-center mb-0" id="myTableQuestion">
                                <thead class="thead-light">
                                    <tr>
                                     
                                        <th>Program</th>
                                        <th>Category</th>
                                        <!-- <th>Status</th> -->
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
    </div>





            </div>
        </div>

    </div>

</div>
                            </div>		
<!-- /Page Content -->
@endsection
@push('script')

<link rel="stylesheet" type="text/css" href="{{ asset('assets/css/simcify.min.css') }}">
<script src="{{ asset('assets/js/simcify.min.js') }}"></script>

<link rel="stylesheet" type="text/css" href="{{ asset('assets/libs/dropify/css/dropify.min.css') }}">
<script src="{{ asset('assets/libs/dropify/js/dropify.min.js') }}"></script>


<script src="{{ asset('public/ckeditor/ckeditor.js') }}"></script>

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
             "bFilter": true,
             "bLengthChange": false,
            ajax: "{{ route('program.list') }}",
            columns: [
               
                {data: 'title', name: 'title', orderable: true, orderable: true, searchable: true},
                {data: 'category_id', name: 'category_id', orderable: true},
                // {data: 'status', name: 'status', orderable: false,searchable: false},
                {
                    data: 'action',
                    name: 'action',
                    orderable: false,
                    searchable: false
                },
            ]
        });

    });
$( document ).ready(function() {
   if({{$apply_p}} == 0){
    $('#commonModal').find('.modal-header').html('<h3 class="notice">Notice</h3>');
       $('#commonModal').find('.modal-body').html('<a class="redirctpop_up" href="{{ URL::to('') }}/apply/program"><i class="far fa-edit"></i>Activate program here<span></span></a>');
     $('#commonModal').modal('show');
}
});

</script> 

@endpush