<?php $page = "book"; ?>
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
                   <a href="{{ route('plans.addons') }}" class="btn btn-sm btn-primary float-right btn-icon-only rounded-circle " >
        <span class="btn-inner--icon"><i class="fas fa-reply"></i></span>
    </a>
                     </div>

<!-- Breadcrumb -->
<div class="breadcrumb-bar mt-3">
    <div class="container-fluid">
        <div class="row align-items-center">
            <div class="col-md-12 col-12">
                <h2 class="breadcrumb-title">Add-On Create</h2>
                <nav aria-label="breadcrumb" class="page-breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Home</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('plans.addons') }}">Add-On</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Add-On Create</li>
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
  {{ Form::open(['route' => ['plans.addons.store'],'id' => 'create_addons','class'=>'pl-3 pr-3','enctype' => 'multipart/form-data']) }}


            <div class="row">
                <div class="col-md-12">
                    <div class="form-group">
                    <label class="form-control-label">Add-on title(Use small Letters)</label>
                    <input type="text" class="form-control" name="title" placeholder="Add-on title" required>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-6">


                    <label class="form-control-label">Status</label>
                    <select class="form-control" name="status">
                        <option value="Published">Published</option>
                        <option value="Unpublished">Unpublished</option>
                    </select>
            </div>
                <div class="col-md-6">
                    <label class="form-control-label">Usage</label>
                    <select class="form-control" name="usage_status">
                        <option value="Enabled">Enabled</option>
                        <option value="Disabled">Disabled</option>
                    </select>
                </div>

            </div>
            <div class="form-group">
                <div class="row">
                    <div class="col-md-12">
                        <label class="form-control-label">Category</label>
                        <select class="form-control" name="category" id="addon_key" required="">
                            <option value="">Select Category</option>
                            @foreach($category_arr as $category)
                            <option value="{{$category->id}}">{{$category->name}}</option>
                            @endforeach
                        </select>

                    </div>
                </div>
            </div>
        <div class="form-group">
            <div class="row">
                <div class="col-md-12">
                    <label class="form-control-label">Add-on System  key</label>
                    <select class="form-control" name="addon_key" id="addon_key" required="">
                        <option value="">Select Addon Key</option>
                        @foreach($UrlIdentifier as $_UrlIdentifier)
                        <option value="{{$_UrlIdentifier->table_unique_identity}}">{{$_UrlIdentifier->table_name}}</option>
                        @endforeach
                    </select>
                    <p class="text-muted text-xs">For developer use only</p>
                </div>
            </div>
        </div>
        <div id="forError" class="" style="display: none;"></div>
        <div class="form-group">
            <div class="row">
                <div class="col-md-12">
                    <label class="form-control-label">Add-on Icon</label>
                    <input type="file" name="icon" class="croppie" crop-width="60" crop-height="59"  accept="image/*" required>
                </div>
            </div>
        </div>
        <div class="form-group">
            <div class="row">
                <div class="col-md-12">
                     {{ Form::label('image', __('Add-on Image/Screenshot'),['class' => 'form-control-label']) }}
                    <input type="file" name="image" class="custom-input-file croppie" crop-width="385" crop-height="217"  accept="image/*" required="">
                </div>
            </div>
        </div>
        <div class="form-group">
            <div class="row">
                <div class="col-md-12">
                    <label class="form-control-label">Add-on Description</label>
                    <textarea class="form-control" id="summary-ckeditor" name="description" placeholder="Add-on Description" rows="7" required></textarea>
                </div>
            </div>
        </div>
        <div class="form-group">
            <div class="row">
                <div class="col-md-12">
                    <label class="form-control-label">Add-on Sub Title</label>
                    <input type="text" class="form-control" name="subtitle" placeholder="Add-on Subtitle" required>
                </div>
            </div>
        </div>
        <div class="form-group">
            <div class="row">
                <div class="col-md-12">
                    <label class="form-control-label">Add-on Demo Link</label>
                    <input type="text" class="form-control" name="demolink" placeholder="Add-on DemoLink" required>
                </div>
            </div>
        </div>


        <div class="form-group">
            <div class="row">
                <div class="col-md-12 input_fields_wrap ad_field_sec">
                    <label class="form-control-label">Add-on Features</label>
                    <button type="button" class="btn btn-sm btn-primary rounded-pill mb-3 add_field_button">Add More Fields</button>
                    <input class="ad_inpt form-control " type="text" class="form-control" name="features[]" placeholder="Add-on features" required>
                </div>
            </div>
        </div>

<div class="text-right">
    {{ Form::button(__('Save'), ['type' => 'submit','class' => 'btn btn-sm btn-primary rounded-pill']) }}
    <button type="button" class="btn btn-sm btn-secondary rounded-pill" data-dismiss="modal">{{__('Cancel')}}</button>
</div>
{{ Form::close() }}





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
     CKEDITOR.replace('summary-ckeditor');
     $( ".add_field_button" ).click(function() {
        var html = $("#new_sec").html();
        $(".ad_field_sec").append(html);
    });

    $(document).on("click", ".destroyInput", function(){
    $(this).closest('div .added_field_sec').remove();
    });
    $( "#create_addons" ).submit(function( event ) {
        var errorLength = $(".notSubmit").length;
        if(errorLength){
             event.preventDefault();
             $("#addon_key").focus()
        }
    });
    $("#addon_key").change(function () {
        var selected = $("#addon_key").val();
        if(selected != ''){
            $.ajax({
                url: "{{route('plans.addons.keycheck')}}?addon_key="+selected,
                success: function (getData)
                {
                    if (getData.status == true) {
                        $("#forError").attr('class', '');
                        $("#forError").attr('class', 'text-success');
                        $("#forError").html(getData.message);
                        $("#uniqueId").val(getData.data);
                        $("#TableUniqueIdentity").val(getData.data);
                        $("#forError").show();
                    } else {
                        $("#forError").attr('class', '');
                        $("#forError").attr('class', 'text-danger notSubmit');
                        $("#forError").html(getData.message);
                        $("#forError").show();
                    }
                }
            });
        }

    });
 </script>











@endpush
