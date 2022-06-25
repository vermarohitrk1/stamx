<?php $page = "swag"; ?>
@extends('layout.dashboardlayout')
@push('css')
<style>

</style>
@endpush
@push('cdn-js')
    <script src="{{ asset('assets/libs/bootstrap-tagsinput/dist/bootstrap-tagsinput.min.js') }}"></script>
@endpush

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
                <a href="{{ route('swag.dashboard') }}" class="btn btn-sm btn btn-primary float-right">
                        <span class="btn-inner--text"><i class="fas fa-reply"></i></span>
                    </a>
                    <a href="{{ route('swagOption.create') }}" class="btn btn-sm btn btn-primary float-right mr-2">
                        <span class="btn-inner--icon"><i class="fas fa-plus"></i></span>
                    </a>
                    
                </div>

                <!-- Breadcrumb -->
                <div class="breadcrumb-bar mt-3">
                    <div class="container-fluid">
                        <div class="row align-items-center">
                            <div class="col-md-12 col-12">
                                <h2 class="breadcrumb-title">Swag Options</h2>
                                <nav aria-label="breadcrumb" class="page-breadcrumb">
                                    <ol class="breadcrumb">
                                        <li class="breadcrumb-item"><a href="index">Home</a></li>
                                        <li class="breadcrumb-item active" aria-current="page">Swag Options</li>
                                    </ol>
                                </nav>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- /Breadcrumb -->

                <!-- Page card -->
                <div class="row mt-3" id="blog_category_view">
                    <br>
                    <div class="col-12">
                        <div class="card">
                                <div id="category_view"></div>
                        </div>

                    </div>
                    <!-- Page card end -->
                </div>
            </div>
        </div>
    </div>

    @endsection

    @push('script')
    <script type="text/javascript">
    $(document).ready(function(){
    //getting view
    getView();
    $(document).on('click', '.pagination a', function (e) {
    var paginationUrl = 'page=' + $(this).attr('href').split('page=')[1];
    getView(paginationUrl);
    e.preventDefault();
    });
});


function getView(page=''){

        var viewUrl = "{{route('swagOption.show')}}?" + page;
        $.ajax({
           url:viewUrl,
           success:function(data)
            {
            $('#category_view').html(data);
            }
      }); 
}

    </script>
    @endpush