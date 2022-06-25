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
                   <a href="{{ route('book.get') }}" class="btn btn-sm btn-primary float-right btn-icon-only rounded-circle " >
        <span class="btn-inner--icon"><i class="fas fa-reply"></i></span>
    </a>
                     </div>
   
<!-- Breadcrumb -->
<div class="breadcrumb-bar mt-3">
    <div class="container-fluid">
        <div class="row align-items-center">
            <div class="col-md-12 col-12">
                <h2 class="breadcrumb-title">Book Create</h2>
                <nav aria-label="breadcrumb" class="page-breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Home</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('book.get') }}">Book</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Book Create</li>
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
               {{ Form::open(['url' =>'book/store','id' => 'create_blog','enctype' => 'multipart/form-data']) }}

<div class="form-group">
        <div class="row">
            <div class="col-md-12">
                <label class="form-control-label">Book title</label>
                <input type="text" class="form-control" name="title" placeholder="Post title" required>
                <input type="hidden" name="csrf-token" value="<?=csrf_token();?>" />
            </div>
        </div>
    </div>
    <div class="form-group">
        <div class="row">
            <div class="col-md-12">
                <label class="form-control-label">Amazon Product Link Or Product ID</label>
                <input type="text" class="form-control" name="buylink" placeholder="Amazon Product Link" required>
            </div>
        </div>
    </div>


    <div class="form-group">
        <div class="row">
            <div class="col-md-12">
                <label class="form-control-label">Itunes Link </label>
                <input type="text" class="form-control" name="itunes_link" placeholder="Itunes Link" required>
            </div>
        </div>
    </div>


    <div class="form-group">
        <div class="row">
            <div class="col-md-12">
                <label class="form-control-label">Price </label>
                <input type="text" class="form-control" name="price" placeholder="Price" required>
            </div>
        </div>
    </div>
    <div class="form-group">
        <div class="row">
            <div class="col-md-12">
                <label class="form-control-label">Author </label>
                <input type="text" class="form-control" name="author" placeholder="Author" required>
            </div>
        </div>
    </div>
    <div class="form-group">
        <div class="row">
            <div class="col-md-12">
                <label class="form-control-label">Marketplace </label>
                <input type="text" class="form-control" name="marketplace" placeholder="Marketplace" required>
            </div>
        </div>
    </div>

    <div class="form-group">
        <div class="row">
            <div class="col-md-6">
                <label class="form-control-label">Category</label>
                <select class="form-control" name="category">
                     <option value="0">Select Category</option>
						@if(!empty($categories))
							@foreach($categories as $category)
								<option value="{{ $category->id }}">{{ $category->name }}</option>
							@endforeach
						@endif
                </select>
            </div>
            <div class="col-md-6">
                <label class="form-control-label">Status</label>
                <select class="form-control" name="status">
                    <option value="Published">Published</option>
                    <option value="Unpublished">Unpublished</option>
                </select>
            </div>
        </div>
    </div>
    <div class="form-group">
        <div class="row">
            <div class="col-md-6">
                <label class="form-control-label">Youtube video ID</label>
                <input type="text" class="form-control" name="youtube" placeholder="Youtube video ID" >
            </div>
            <div class="col-md-6">
                <label class="form-control-label">Show Video</label>
                <select class="form-control" name="show_video">
                    <option value="Yes">Yes</option>
                    <option value="No">No</option>
                </select>
            </div>
        </div>
    </div>
    <div class="form-group">
        <div class="row">
            <div class="col-md-12">
                    {{ Form::label('image', __('Tab Image'),['class' => 'form-control-label']) }}
                <input type="file" name="image" class="custom-input-file croppie" crop-width="600" crop-height="600"  accept="image/*" required="">
            </div>

        </div>
    </div>

    <div class="form-group">
        <div class="row">
            <div class="col-md-12">
                <label class="form-control-label">Book Description</label>
                <textarea class="form-control" id="summary-ckeditor" name="description"  placeholder="Book Description" rows="10" required></textarea>
            </div>
        </div>
    </div>
</div>
<div class="form-check">
    <input type="checkbox" class="form-check-input" id="Featured" name="featured" value="1">
     <label class="form-check-label" for="Featured"> Featured </label>
  </div>
  <div class="form-check">
    <input type="checkbox" class="form-check-input" id="Favourite" name="favourite_read" value="1">
     <label class="form-check-label" for="Favourite"> Favourite Read </label>
  </div>
   <div class="form-check">
    <input type="checkbox" class="form-check-input" id="Trending" name="treading_books" value="1">
     <label class="form-check-label" for="Trending"> Trending Books </label>
      </div>
      <!-- <div class="form-check">
        <input type="checkbox" class="form-check-input" id="exampleCheck1" name="slider" value="1">
         <label class="form-check-label" for="exampleCheck1"> Slider </label>
          </div> -->
      <div class="text-right">
    {{ Form::button(__('Save'), ['type' => 'submit','class' => 'btn btn-sm btn-primary rounded-pill']) }}
    <!-- <button type="button" class="btn btn-sm btn-secondary rounded-pill" data-dismiss="modal">{{__('Cancel')}}</button> -->
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

<script>
CKEDITOR.replace('summary-ckeditor');

    $(document).ready(function() {
        var today = new Date();
        var dd = today. getDate() + 1;
        var mm = today. getMonth() + 1;
        var yyyy = today. getFullYear();
        if (dd < 10) {
            dd = "0" + dd;
        }
        if (mm < 10) {
            mm = "0" + mm;
        }
        var currentDate = yyyy+'-'+mm+'-'+dd;
        $('#expirydate').attr("min",currentDate);
        var check = false;
        $('#dateDiv').hide();
        $('#prepublishDiv').hide();
    });
    $(document).on("change","#expire",function() {
         var value = this.value;
        if(value=='yes'){
            check = true;
            $('#expirydate').attr("required", true);
            $('#dateDiv').show();
        }else if(value=='no'){
            check = false;
            $('#expirydate').val('');
            $('#expirydate').attr("required", false);
            $('#dateDiv').hide();
        }
    });
    $(document).on("change","#prepublish",function() {
         var value = this.value;
        if(value=='yes'){
            check = true;
            $('#prepublish_date').attr("required", true);
            $('#prepublishDiv').show();
            $('#status').val('Unpublished');
        }else if(value=='no'){
            check = false;
            $('#prepublish_date').val('');
            $('#prepublish_date').attr("required", false);
            $('#prepublishDiv').hide();
            $('#status').val('Published');
        }
    });
</script>










@endpush