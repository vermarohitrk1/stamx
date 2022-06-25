<?php $page = "podcast"; ?>
@extends('layout.dashboardlayout')
@push('css')
<style>

</style>
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
@php 
$url = explode('.', $_SERVER['HTTP_HOST'])[0];
if(Auth::user()->domain != ''){
    $url = Auth::user()->domain;
}elseif($url == 'localhost' || $url == 'stemx'){
    $url = 'stemx.com';
}else{
    $url = $url.'.stemx.com';
}
@endphp
    <div class="col-md-7 col-lg-8 col-xl-9">
                <div class=" col-md-12 ">
                <input type="hidden" style='visibility: hidden' id="booking_copy" value="https://{{$url.'/podcasts/'.encrypted_key(Auth::user()->id,'encrypt')}}">

                            <a href="{{ route('podcast.create') }}" class="btn btn-sm btn btn-primary float-right "  data-title="{{__('Add Plan')}}">
                        <span class="btn-inner--icon"><i class="fas fa-plus"></i></span>
                    </a>
                            
                        
                            <a href="{{ route('podcast.files_upload') }}" class="btn btn-sm btn btn-primary float-right mr-2 m-0">
                        <span class="btn-inner--text ">{{__('Upload Files')}}</span>
                    </a>
                    
                        <a href="javascript:void(0)" onclick="copyClipboard(booking_copy)" 
                        class="btn btn-sm btn btn-primary float-right mr-2 m-0">
                            <span class="btn-inner--text">{{__('Copy Link')}}</span>
                        </a>
                </div>
   
        <!-- Breadcrumb -->
        <div class="breadcrumb-bar mt-3">
            <div class="container-fluid">
                <div class="row align-items-center">
                    <div class="col-md-12 col-12">
                        <h2 class="breadcrumb-title">Podcast</h2>
                        <nav aria-label="breadcrumb" class="page-breadcrumb">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item"><a href="index">Home</a></li>
                                <li class="breadcrumb-item active" aria-current="page">Podcast</li>
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
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table class="display responsive nowrap table table-hover table-center" width="100%" id="yajra-datatable">
                                            <thead class="thead-light">
                                                <tr>
                                                    <!-- <th>#</th> -->
                                                    <th class=" mb-0 h6 text-sm"> {{__('Title')}}</th>
                                                    <th style="white-space:pre-wrap; word-wrap:break-word" class=" mb-0 h6 text-sm"> {{__('Description')}}</th>
                                                    <th class="text-right class="name mb-0 h6 text-sm> {{__('Action')}}</th>
                                                
                                                </tr>
                                            </thead>
                                            <tbody class="list">
                                        
                                            </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                        <div class=" col-md-12 d-flex justify-content-center paginationCss">   
                        </div>
                    </div>
                    
        </div>
        <!-- Page card end -->
    </div>
</div>
</div>
</div>

@endsection

@push('script')
<link href="{{ asset('public') }}/frontend/css/custom-audio-player.css" rel="stylesheet" type="text/css" />
<script src="{{ asset('public/frontend/js/audioplayer.js') }}"></script>
<script src="{{ asset('public/frontend/js/custom-audio-player.js') }}"></script>
<script type="text/javascript">  


 $(function () {
    var table = $('#yajra-datatable').DataTable({
         responsive: true,
        processing: true,
        serverSide: true,
        ajax: "{{ route('podcast.dashboard') }}",
        columns: [
           // {data: 'DT_RowIndex', name: 'DT_RowIndex', orderable: false, searchable: false},
            {data: 'title', name: 'title',orderable: true,searchable: true},
            {data: 'description', name: 'description'},
            {
                data: 'action',
                name: 'action',
                orderable: true,
                searchable: true
            },
        ],
        "initComplete": function(settings, json) {
            $( 'audio' ).audioPlayer();
      }
    });
   

  });
</script>
<script>
	    function copyClipboard(element) {
        var $temp = $("<input>");
        $("body").append($temp);
        $temp.val($(element).val()).select();
        document.execCommand("copy");
        $temp.remove();
        alert("Copied: " + $(element).val());
    }
	</script>
        <script>

    </script>
@endpush