<?php $page = "podcast"; ?>
@extends('layout.dashboardlayout')
@push('theme-cdn')
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.1/jquery.validate.min.js" ></script>
@endpush

@push('css')
<style>
    form .error {
  color: #ff0000;
}

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

    <div class="col-md-7 col-lg-8 col-xl-9">

                <div class=" col-md-12 ">
                            <a href="{{ route('podcast.dashboard') }}" class="btn btn-sm btn btn-primary float-right "  data-title="{{__('Add Plan')}}">
                        <span class="btn-inner--icon"><i class="fas fa-reply"></i></span>
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
        <div class="row mt-3" id="blog_category_view">
            <br>

                <div class="col-12">
                    <div class="card">
                        <div class="card-body">
                                {{ Form::open(['route' => 'podcast.storefile','id' => 'new_input_form', 'name' => 'new_input_form','enctype' => 'multipart/form-data']) }}
                            <input type="hidden" name="csrf-token" value="<?= csrf_token(); ?>"/>


                                <div class="col-12 col-md-12">

                                    {{ Form::label('file', __('Upload mp3 file:'),['class' => 'form-control-label']) }}

                                    <input type="file" accept="audio/*" class="dropify" placeholder="Upload mp3 podcast" name="file" data-allowed-file-extensions="mp3" required="" >

                                    <label for="file">
                                        <i class="fa fa-upload"></i>
                                        <span>{{__('Choose a file…')}} </span>

                                    </label>
                                    @error('file')
                                        <span class="invalid-feedback" role="alert" style='display: block;'>
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>

                                <div class="text-right mt-2">
                                    {{ Form::button(__('Upload'), ['type' => 'submit','class' => 'btn btn-sm btn-primary rounded-pill']) }}

                                </div>
                                {{ Form::close() }}
                        </div>



                    </div>
                </div>

                <div class="col-12">
                        <div class="card">
                            <div class="card-body">
                                <div class="table-responsive">
                                <table class="display responsive nowrap" width="100%" id="yajra-datatable">
                                        <thead class="thead-light">
                                        <tr>
                                            <!--<th class=" mb-0 h6 text-sm"> {{__('#')}}</th>-->
                                            <th class=" mb-0 h6 text-sm"> {{__('Play')}}</th>
                                            <th class=" mb-0 h6 text-sm"> {{__('File')}}</th>
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
<link rel="stylesheet" type="text/css" href="{{ asset('assets/css/simcify.min.css') }}">
<script src="{{ asset('assets/js/simcify.min.js') }}"></script>
<script>

$(function () {

    // Initialize form validation on the form.
    $("form[name='new_input_form']").validate({
        // Specify validation rules
        rules: {
            title: {
                file: true,

            }
        },
        // Specify validation error messages
        messages: {
            title: {
                required: "*Required"

            }
        },
        // Make sure the form is submitted to the destination defined
        // in the "action" attribute of the form when valid
        submitHandler: function (form) {
            form.submit();
        }
    });
});

$(function () {
    var table = $('#yajra-datatable').DataTable({
         responsive: true,
        processing: true,
        serverSide: true,
        ajax: "{{ route('podcast.files_upload') }}",
        columns: [
//            {data: 'DT_RowIndex'},
            {data: 'player', name: 'player',orderable: false,searchable: false},
            {data: 'file', name: 'file',orderable: true,searchable: true},
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
</script>

@endpush

