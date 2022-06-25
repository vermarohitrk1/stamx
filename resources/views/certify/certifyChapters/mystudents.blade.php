<?php $page = "show"; ?>
@extends('layout.dashboardlayout')
@section('content')	
@php
$permissions=permissions();
@endphp

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
                <h2 class="breadcrumb-title">   @if(!empty($Certify))
    {{$Certify->name}}
    @endif</h2>
                <nav aria-label="breadcrumb" class="page-breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{route('dashboard')}}">Home</a></li>
                        <li class="breadcrumb-item"><a href="{{route('certify.index')}}">Courses</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Chapters</li>
                    </ol>
                </nav>
            </div>              
        </div>            
    </div>
</div>
<!-- /Breadcrumb -->


 <!--student enroll-->
        @if(in_array("course_create_regular",$permissions) || $authuser->type=='admin')
		
		
		
		
		
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header">
                            <h3>Students Enrolled</h3>
                        </div>
                        <div class="card-body ">
                            <div class="table-md-responsive">
                                <table class="table table-hover table-center mb-0" width="100%" id="yajra-datatable">
                                    <thead class="thead-light">
                                    <tr>
                                        <th class="name mb-0 h6 text-sm textdarkClass"> {{__('Student')}}</th>
                                        <th class="name mb-0 h6 text-sm textdarkClass"> {{__('Course')}}</th>
                                        <th class="name mb-0 h6 text-sm textdarkClass"> {{__('Enrolled')}}</th>
                                        <th class="name mb-0 h6 text-sm textdarkClass"> {{__('Lecture Progress')}}</th>
                                        <th class="name mb-0 h6 text-sm textdarkClass"> {{__('Completed')}}</th>
                                     
                                        <th class="name mb-0 h6 text-sm textdarkClass"> {{__('Status')}}</th>
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
        @endif
    

            </div>
        </div>

    </div>

</div>		
<!-- /Page Content -->
@endsection

@push('script')
     <script>
        $(function () {
            var table = $('#yajra-datatable').DataTable({
                 responsive: true,
                processing: true,
                serverSide: true,
                "searching":true,
               ajax: "{{ route('certify.student_enroll') }}",
                columns: [
                    {data: 'name', name: 'name', orderable: false},
                    {data: 'course', name: 'course', orderable: false,searchable: true},
                    {data: 'enroll', name: 'enroll', orderable: false},
                    {data: 'completed_on', name: 'completed_on', orderable: false},
                    {data: 'ongoing', name: 'ongoing', orderable: false},
					
                    {
                        data: 'status',
                        name: 'status',
                        orderable: false,
                        searchable: false
                    },
                ]
            });
        });
        $(document).on("click", ".destroyExam", function () {
            var id = $(this).attr('data-id');
            var certifyid = $(this).attr('certifyid');
            $("#examId").val(id);
            $("#certifyid").val(certifyid);
            $('#destroyExam').modal('show');

        });
    </script>
@endpush