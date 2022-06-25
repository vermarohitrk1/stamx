<?php $page = "url Identifier"; ?>
@extends('layout.dashboardlayout')
@section('content')
<style>
.main-wrapper {
    height: auto;
}
</style>

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


                     <a href="{{ route('url.identifiers.index') }}" class="btn btn-sm btn-primary float-right btn-icon-only rounded-circle " >
        <span class="btn-inner--icon"><i class="fas fa-reply"></i></span>
    </a>
                     </div>

<!-- Breadcrumb -->
<div class="breadcrumb-bar mt-3">
    <div class="container-fluid">
        <div class="row align-items-center">
            <div class="col-md-12 col-12">
                <h2 class="breadcrumb-title">Add-on Edit</h2>
                <nav aria-label="breadcrumb" class="page-breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{url('home')}}">Home</a></li>
                        <li class="breadcrumb-item"><a href="{{route('url.identifiers.index')}}">Add-on</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Edit</li>
                    </ol>
                </nav>
            </div>
        </div>
    </div>
</div>
<!-- /Breadcrumb -->

<div class="row mt-3" id="blog_category_view">

  <!-- list view -->
  <div class="col-12">
      <div class="card">
                <div class="card-body">
                     {{ Form::open(['route' => ['plans.addons.update'],'class'=>'pl-3 pr-3','id' => 'update_addons','enctype' => 'multipart/form-data']) }}

        <div class="form-group">
            <div class="row">
                <div class="col-md-12">
                    <label class="form-control-label">Add-on title</label>
                    <input type="text" class="form-control" name="title" value="{{$addon->title}}" required>
                    <input type="hidden" name="id" id="addonId" value="{{$addon->id}}">
                </div>
            </div>
        </div>
        <div class="form-group">
            <div class="row">
                <div class="col-md-6">
                    <label class="form-control-label">Status</label>
                    <select class="form-control" name="status" required>
                        <option value="Published" @if($addon->status == "Published") selected  @endif >Published</option>
                        <option value="Unpublished" @if($addon->status == "Unpublished") selected @endif >Unpublished</option>
                    </select>
                </div>
                <div class="col-md-6">
                    <label class="form-control-label">Usage</label>
                    <select class="form-control" name="usage_status" required>
                        <option value="Enabled" @if($addon->usage_status == "Enabled") selected @endif >Enabled</option>
                        <option value="Disabled"  @if($addon->usage_status == "Disabled") selected @endif >Disabled</option>
                    </select>
                </div>
            </div>
        </div>
        <div class="form-group">
            <div class="row">
                <div class="col-md-12">
                    <label class="form-control-label">Category</label>
                    <select class="form-control" name="category" id="addon_key" required="">
                        <option value="">Select Category</option>
                        @foreach($category_arr as $category)
                        <option  @if($category->id == $addon->category) selected @endif value="{{$category->id}}">{{$category->name}}</option>
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
                        <option value="{{$_UrlIdentifier->table_unique_identity}}" @if($addon->addon_key == $_UrlIdentifier->table_unique_identity) selected @endif >{{$_UrlIdentifier->table_name}}</option>
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
                    {{ Form::label('image', __('Add-on Icon'),['class' => 'form-control-label']) }}
                    @if(!empty($addon->icon))
                    <input type="file" name="icon" class="custom-input-file croppie"
                    default="{{asset('storage')}}/addon/{{ $addon->icon }}" crop-width="60" crop-height="59"  accept="image/*">
                     <div class="form-group form-check">
                        <input type="checkbox" class="form-check-input" value="1" name="icon_delete" id="exampleCheck1">
                        <label class="form-check-label" for="exampleCheck1">Delete image?</label>
                     </div>
                    @else
                    <input type="file" name="icon" class="custom-input-file croppie" crop-width="60" crop-height="59"  accept="image/*" required>
                    @endif

                </div>

            </div>
        </div>
        <div class="form-group">
            <div class="row">
                <div class="col-md-12">
                    {{ Form::label('image', __('Add-on Image/Screenshot'),['class' => 'form-control-label']) }}
                    @if(!empty($addon->image))
                    <input type="file" name="image" class="custom-input-file croppie" default="{{asset('storage')}}/addon/{{ $addon->image }}" crop-width="385" crop-height="217" accept="image/*">
                     <div class="form-group form-check">
                        <input type="checkbox" class="form-check-input" value="1" name="image_delete" id="exampleCheck2">
                        <label class="form-check-label" for="exampleCheck2">Delete image?</label>
                    </div>
                    @else
                    <input type="file" name="image" class="custom-input-file croppie" crop-width="385" crop-height="217"  accept="image/*" required >
                    @endif

                </div>
            </div>
        </div>
        <div class="form-group">
            <div class="row">
                <div class="col-md-12">
                    <label class="form-control-label">Add-on Description</label>
                    <textarea class="form-control" id="summary-ckeditor" name="description" rows="7" required >{{$addon->description}}</textarea>
                </div>
            </div>
        </div>
        <div class="form-group">
            <div class="row">
                <div class="col-md-12">
                    <label class="form-control-label">Add-on Sub Title</label>
                    <input type="text" class="form-control" name="subtitle" value="{{$addon->subtitle}}" required>
                </div>
            </div>
        </div>
        <div class="form-group">
            <div class="row">
                <div class="col-md-12">
                    <label class="form-control-label">Add-on Demo Link</label>
                    <input type="text" class="form-control" name="demolink" value="{{$addon->demolink}}" required>
                </div>
            </div>
        </div>

        <div class="form-group">
            <div class="row">
                <div class="col-md-12 input_fields_wrap ad_field_sec">
                    <label class="form-control-label">Add-on Features</label>
                    <button type="button" class="btn btn-sm btn-primary rounded-pill mb-3 add_field_button">Add More Fields</button>

                    @foreach($addon->features as $key=>$features)
                    @if($key == 0)
                    <input class="ad_inpt form-control " type="text" class="form-control" name="features[]" value="{{$features}}" required>
                    @else
                     <div class="added_field_sec">
                     <input class="ad_inpt form-control" style="width: 90%;" type="text" class="form-control"
                     value="{{$features}}" name="features[]" placeholder="Add-on features" required>
                     <a style="float: right;margin-top: -38px;margin-right: 21px;" href="javascript:void(0)" class="destroyInput text-danger" data-toggle="tooltip" data-original-title="{{__('Delete')}}">
                     <i class="fas fa-trash-alt"></i>
                     </a>
                     </div>
                    @endif
                    @endforeach
                 </div>
            </div>
        </div>

    </div>
<div class="text-right mr-4 pb-3">
    {{ Form::button(__('Save'), ['type' => 'submit','class' => 'btn btn-sm btn-primary rounded-pill']) }}
</div>
{{ Form::close() }}
                </div>
            </div>
  </div>
    <!-- list view -->
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
<script>
$("#url_identifiers_store").submit(function (event) {
    var TableUniqueIdentity = $('#TableUniqueIdentity').val();
    if (TableUniqueIdentity == '') {
        event.preventDefault();
    }
});
$("#tableName").change(function () {
    var selected = $("#tableName").val();
    var selectedid = $("#urlidentifierId").val();
    $.ajax({
        url: "{{route('url.identifiers.checkTableName')}}?tablename=" + selected ,
        success: function (getData)
        {
            if (getData.status == true) {
                $("#forError").attr('class', 'text-success');
                $("#forError").html(getData.message);
                $("#uniqueId").val(getData.data);
                $("#TableUniqueIdentity").val(getData.data);
                $("#forError").show();
            } else {
                if(getData.data.id == selectedid){
                    $("#uniqueId").val(getData.data.table_unique_identity);
                    $("#TableUniqueIdentity").val(getData.data.table_unique_identity);
                    $("#forError").hide();
                }else{
                    $("#forError").attr('class', 'text-danger');
                    $("#forError").html(getData.message);
                    $("#forError").show();
                }

            }
        }
    });
});
</script>

@endpush
