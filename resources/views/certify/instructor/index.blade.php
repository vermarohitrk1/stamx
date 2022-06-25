<?php $page = "Course Instructors"; ?>
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
                     <a href="{{ route('certify.index') }}" id="back" class="btn btn-sm btn-primary float-right ml-2">
        <span class="btn-inner--icon"><i class="fas fa-reply"></i></span>
    </a>
    <a href="#" class="btn btn-sm btn-primary float-right ml-1"
       data-url="{{ route('instructor.create') }}" data-ajax-popup="true" data-size="lg"
       data-title="{{__('Add Instructor')}}">
        <span class="btn-inner--icon"><i class="fas fa-plus"></i></span>
    </a>
                    
           
                     </div>
   
<!-- Breadcrumb -->
<div class="breadcrumb-bar mt-3">
    <div class="container-fluid">
        <div class="row align-items-center">
            <div class="col-md-12 col-12">
                <h2 class="breadcrumb-title">Instructors</h2>
                <nav aria-label="breadcrumb" class="page-breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{route('dashboard')}}">Home</a></li>
                        <li class="breadcrumb-item"><a href="{{route('certify.index')}}">Courses</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Instructors</li>
                    </ol>
                </nav>
            </div>              
        </div>            
    </div>
</div>
<!-- /Breadcrumb -->

<div class="row mt-3" id="certifyView">
        <div class="col-12">
            <div class="card">
                <div class="card-body ">
                    <div class="table-md-responsive">
                        <table class="table table-hover table-center mb-0" width="100%" id="yajra-datatable">
                            <thead class="thead-light">
                            <tr>
                                <th class="name mb-0 h6 text-sm"> {{__('Name')}}</th>
                                <th class="name mb-0 h6 text-sm"> {{__('City')}}</th>
                                <th class="name mb-0 h6 text-sm"> {{__('State')}}</th>
                                <th class="text-right name mb-0 h6 text-sm"> {{__('Action')}}</th>
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
        $(function () {
            var table = $('#yajra-datatable').DataTable({
                 responsive: true,
                processing: true,
                serverSide: true,
                ajax: "{{ route('instructor.index') }}",
                columns: [
                    {data: 'name', name: 'name', orderable: false, searchable: true},
                    {data: 'city', name: 'city', orderable: false, searchable: false},
                    {data: 'state', name: 'state', orderable: false, searchable: false},
                    {data: 'action', name: 'action', orderable: false, searchable: false},
                ]
            });

        });
    </script>
@endpush
