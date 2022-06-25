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
                
                    <a class="btn btn-sm btn-primary .btn-rounded float-right" href="#"  data-ajax-popup="true" data-url="{{route('program_category.create')}}" data-size="md" data-title="{{__('Add Question')}}">
            <span class="btn-inner--icon"><i class="fas fa-plus"></i></span>
        </a>
                </div>
   
<!-- Breadcrumb -->
<div class="breadcrumb-bar mt-3">
    <div class="container-fluid">
        <div class="row align-items-center">
            <div class="col-md-12 col-12">
                <h2 class="breadcrumb-title">Category</h2>
                <nav aria-label="breadcrumb" class="page-breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="index">Home</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Category</li>
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
             
<!-- html -->


                        <div class="table-responsive-md">
                            
                            <table class=" table table-hover table-center mb-0" id="myTableQuestion">
                            <thead class="thead-light ">
                                    <tr>
                                       
                                        <th>Category</th>
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
             "bFilter": true,
            ajax: "{{ route('program_category') }}",
            columns: [
               
                {data: 'name', name: 'name', orderable: true,searchable: true},
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