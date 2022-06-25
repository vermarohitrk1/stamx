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
 
        
     @if(in_array("course_create_regular",$permissions) || $authuser->type=='admin')
         <a href="{{ url('certify/curriculum',['certify'=>encrypted_key($Certify->id,'encrypt')]) }}" id="back" class="btn btn-sm btn-primary float-right ml-2">
        <span class="btn-inner--icon"><i class="fa fa-book-open"></i> {{__('Manage Curriculum')}}</span>
    </a>
                 
			
             
    @else
          
       <a href="{{ url('certify/learnview/'.encrypted_key($Certify->id,'encrypt')) }}" id="back" class="btn btn-sm btn-primary float-right ml-2">
        <span class="btn-inner--icon"><i class="fa fa-book-open"></i>{{__('Learn Now')}}</span>
    </a>
    @endif
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

<div class="row">
        <div class="col-lg-12 order-lg-1">
            <div id="tabs-1" class="tabs-card">
                <div class="card">
                    <div class="card-header">
                        <h5 class=" h6 mb-0">{{__('Classes/Lessons')}}</h5>
                    </div>
                    <div class="card-body">
                        @if (count($Chapters) > 0)
                            @foreach ($Chapters as $chapterindex => $chapter)
                                <div class="Chapters-list">
                                    <h6>Chapter {{ $chapterindex + 1 }}: <strong
                                            class="text-primary">{{ $chapter->title }}</strong>
                                    </h6>
                                    <div class="chapter-class-type">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                        <i class="fa fa-play-circle">
                                        </i> Module {{ $chapterindex + 1 }}
                                    </div>
                                </div>
                            @endforeach
                        @else
                            <div class="empty-section">
                                <i class="fa fa-clipboard-text"></i>
                                <h5>No curriculum created for this course!</h5>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
 <!--student enroll-->
       
		   <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header">
                            <h3>Course Exams</h3>
							      @if($authuser->type=='mentor' || $authuser->type=='admin')
                            <a style="float: right;" href="#" data-url="{{ url('certify/examCreate/'.$Certify->id) }}"
                               data-ajax-popup="true" data-size="lg" data-title="{{__('Create Course Exam')}}"
                               class="btn btn-primary btn-sm  add-chapter">
                                <span class="btn-inner--icon"><i class="fas fa-plus"></i></span>
                            </a>
                        @endif
                        <p class="text-muted mb-0">Exams for {{$Certify->name}}</p>
                        </div>
                        <div class="card-body ">
                            <div class="table-md-responsive">
                                <table class="table table-hover table-center mb-0" width="100%" id="yajra-datatable-exam">
                                    <thead class="thead-light">
                                    <tr>
                                        <th class="name mb-0 h6 text-sm textdarkClass"> {{__('Name')}}</th>
                                        <th class="name mb-0 h6 text-sm textdarkClass"> {{__('Questions')}}</th>
                                        <th class="name mb-0 h6 text-sm textdarkClass"> {{__('Status')}}</th>
                                        <th class="name mb-0 h6 text-sm textdarkClass"> {{__('Completed By')}}</th>
                                        <th class="name mb-0 h6 text-sm textdarkClass"> {{__('Action')}}</th>
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
@endsection

@push('script')
    <script>
        var data = '';
        var dataExam = '';
        @if($Certify)
       var data = '{{url('certify/show/'. encrypted_key($Certify->id, 'encrypt' ))}}';
      // var dataExam = '{{url('certify/show/exam'. encrypted_key($Certify->id, 'encrypt' ))}}';
        @endif
        // $(function () {
            // var table = $('#yajra-datatable').DataTable({
                // processing: true,
                // serverSide: true,
                // "searching":false,
                // ajax: dataExam,
                // columns: [
                    // {data: 'name', name: 'name', orderable: false},
                    // {data: 'enroll', name: 'enroll', orderable: false},
                    // {data: 'completed_on', name: 'completed_on', orderable: false},
                    // {data: 'ongoing', name: 'ongoing', orderable: false},
                    // {
                        // data: 'status',
                        // name: 'status',
                        // orderable: false,
                        // searchable: false
                    // },
                // ]
            // });
        // });
		
		
		
		    $(function () {
            var table = $('#yajra-datatable-exam').DataTable({
                 responsive: true,
                processing: true,
                serverSide: true,
                "searching":false,
                ajax: data,
                columns: [
                    {data: 'name', name: 'name', orderable: false},
                    {data: 'questions', name: 'questions', orderable: false},
                    {data: 'status', name: 'status', orderable: false},
                    {data: 'students', name: 'students', orderable: false},
                    {
                        data: 'action',
                        name: 'action',
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