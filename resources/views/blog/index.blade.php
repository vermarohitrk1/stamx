<?php $page = "blog"; ?>
@section('title')
    {{$page}}
@endsection
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
               <a href="{{ route('blog.create') }}" class="btn btn-sm btn btn-primary float-right "  data-title="{{__('Add Blog Post')}}">
        <span class="btn-inner--icon"><i class="fas fa-plus"></i></span>
    </a>
                <a href="{{ route('blog.category') }}" class="btn btn-sm btn btn-primary float-right mr-2 m-0">
        <span class="btn-inner--text ">{{__('Manage Category')}}</span>
    </a>
                     </div>
   
<!-- Breadcrumb -->
<div class="breadcrumb-bar mt-3">
    <div class="container-fluid">
        <div class="row align-items-center">
            <div class="col-md-12 col-12">
                <h2 class="breadcrumb-title">Blog</h2>
                <nav aria-label="breadcrumb" class="page-breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{route('dashboard')}}">Home</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Blog</li>
                    </ol>
                </nav>
            </div>              
        </div>            
    </div>
</div>
<!-- /Breadcrumb -->


<div class="row mt-3 blockWithFilter">
                    <div class="col-md-12 col-lg-4 dash-board-list blue">
                        <div class="dash-widget">
                            <div class="circle-bar">
                                <div class="icon-col">
                                    <i class="fas fa-calendar-check"></i>
                                </div>
                            </div>
                            <div class="dash-widget-info">
                                <h3 data-id="blogs">{{$BlogCount}}</h3>
                                <h6>Blogs</h6>															
                            </div>
                        </div>
                    </div>

                    <div class="col-md-12 col-lg-4 dash-board-list yellow">
                        <div class="dash-widget">
                            <div class="circle-bar">
                                <div class="icon-col">
                                    <i class="fas fa-calendar-alt"></i>
                                </div>
                            </div>
                            <div class="dash-widget-info">
                                <h3 data-id="inactive">{{$inactive}}</h3>
                                <h6>{{__('Inactive')}}</h6>															
                            </div>
                        </div>
                    </div>

                    <div class="col-md-12 col-lg-4 dash-board-list pink">
                        <div class="dash-widget">
                            <div class="circle-bar">
                                <div class="icon-col">
                                    <i class="fas fa-folder"></i>
                                </div>
                            </div>
                            <div class="dash-widget-info">
                                <h3 data-id="categories">{{$categories??0}}</h3>
                                <h6>{{__('Categories')}}</h6>															
                            </div>
                        </div>
                    </div>
                </div>

<br>


<div class="row" id="blog_view">
     <div class="col-12">
        <div class="card">
            <div class="card-body ">
                <div class="table-md-responsive">
                    <table class="table table-hover table-center mb-0" id="example">
                        <thead class="thead-light">
                        <tr>
                            <th class=" mb-0 h6 text-sm"> {{__('Images')}}</th>
                            <th class=" mb-0 h6 text-sm"> {{__('Title')}}</th>
                            <th class=" mb-0 h6 text-sm"> {{__('Category/Tags')}}</th>
                            <th class=" mb-0 h6 text-sm"> {{__('Status')}}</th>
                            <th class="text-right name mb-0 h6 text-sm"> {{__('Action')}}</th>
                        </tr>
                        </thead> 
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

<!--<script type="text/javascript" src="{{ asset('datatables/datatables.min.js') }}"></script>-->



<script type="text/javascript">


$(function () {    
    var table = $('#example').DataTable({
         responsive: true,
        processing: true,
        serverSide: true,
        ajax: "{{ url('/blog') }}",
        columns: [
            //{data: 'DT_RowIndex', name: 'DT_RowIndex'},
            {data: 'image', name: 'image',orderable: false,searchable: false},
            {data: 'title', name: 'title',orderable: false},
            {data: 'category', name: 'category',orderable: false},
            {data: 'status', name: 'status',orderable: false},
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