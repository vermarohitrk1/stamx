<?php $page = "Certify"; ?>
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
                   <a href="{{ route('certify.index') }}" class="btn btn-sm btn-primary float-right btn-icon-only rounded-circle " >
        <span class="btn-inner--icon"><i class="fas fa-reply"></i></span>
    </a>
                     </div>
   
<!-- Breadcrumb -->
<div class="breadcrumb-bar mt-3">
    <div class="container-fluid">
        <div class="row align-items-center">
            <div class="col-md-12 col-12">
                <h2 class="breadcrumb-title">Course Create</h2>
                <nav aria-label="breadcrumb" class="page-breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{route('dashboard')}}">Home</a></li>
                        <li class="breadcrumb-item"><a href="{{route('certify.index')}}">Course</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Course Create</li>
                    </ol>
                </nav>
            </div>              
        </div>            
    </div>
</div>
<!-- /Breadcrumb -->




<div class="row" id="certifyView">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    {{ Form::open(['url' => 'certify/store','id' => 'create_certify','enctype' => 'multipart/form-data']) }}
<div class="form-group">
    <div class="row">
        <div class="col-md-12">
            <label class="form-control-label">Course Name</label>
            <input type="text" name="name" class="form-control" placeholder="Course Name" required="">
            <input type="hidden" name="type" value="Regular">
        </div>
    </div>
</div>
<!--<div class="form-group">
    <div class="row">
        <div class="col-md-12">
            <label class="form-control-label">Industry</label>
            <select name="bls_industry" class="form-control" required="">
            @foreach($bls_industries as $k => $v)
            <option value="{{ $v->id }}">{{ $v->name }}</option>
            @endforeach 
        </div>
    </div>
</div>


<div class="form-group">
    <div class="row">
        <div class="col-md-12" style="display: inline-flex;">

            <input type="checkbox" name="pennfoster" value="1" class="" />
            &nbsp;&nbsp;&nbsp;&nbsp;<label  class="form-control-label">Penn Foster</label>
        </div>
    </div>
</div>-->


<div class="form-group">
    <div class="row">
        <div class="col-md-6" style="display: inline-flex;">
            <input type="checkbox" id="checkbox" name="boardcertified" value="1" class="" />
            &nbsp;&nbsp;&nbsp;&nbsp;<label  class="form-control-label">Board Certified</label>
        </div>

    </div>
</div>
<div class="form-group responsefield">
    <div class="row">
        <div class="col-md-12">
            <label class="form-control-label">Prerequisites</label>
            <input type="text" id="showthis" name="prerequisites" class="form-control" placeholder="Prerequisites ">
        </div>
    </div>
</div>

<div class="form-group">
    <div class="row">
        <div class="col-md-12">
            <label class="form-control-label">CE Credits</label>
            <input type="number" name="cecredit" class="form-control" placeholder="CE Credits">
        </div>
    </div>
</div>
<div class="form-group">
    <div class="row">
        <div class="col-md-12">
            <label class="form-control-label">Degree Name</label>
            <input type="text" name="degree" class="form-control" placeholder="Degree Name">
        </div>
    </div>
</div>
<div class="form-group">
    <div class="row">
        <div class="col-md-6">
            <label class="form-control-label">Specialization</label>
            <input type="text" name="specialization" class="form-control" placeholder="Specialization">
        </div>
        <div class="col-md-6">
            <label class="form-control-label">Certification</label>
            <input type="text" name="certification" class="form-control" placeholder="Certification">
        </div>
    </div>
</div>

<div class="form-group">
    <div class="row">
        <div class="col-md-6">
            <label class="form-control-label">Status</label>
            <select class="form-control" name="status">
                <option value="Published">Published</option>
                <option value="Unpublished">Unpublished</option>
            </select>
        </div>
        <div class="col-md-6">
            <label class="form-control-label">Syndicate</label>
            <select class="form-control" name="syndicate" @if (checkPlanModule("syndicatepayments"))  @else  disabled
			@endif >
                <option value="Enabled">Enabled</option>
                <option value="Disabled" @if (checkPlanModule("syndicatepayments"))  @else  selected
			@endif >Disabled</option>
            </select>
			@if (checkPlanModule("syndicatepayments"))  @else  
			<span class="text-danger">Please Upgrade the plan to enable syndicate course.</span>
			@endif 
		
        </div>
    </div>
</div>

<div class="form-group">
    <div class="row">
        <div class="col-md-6">
            <label class="form-control-label">Price ($)</label>
            <input type="number" class="form-control" name="price" placeholder="Price ($)" required>
        </div>
        <div class="col-md-6">
            <label class="form-control-label">Sale Price ($)</label>
            <input type="number" class="form-control" name="sale_price" placeholder="Sale Price ($)">
        </div>
    </div>
</div>

<!--<div class="form-group">
    <div class="row">
        <div class="col-md-12">
            <label class="form-control-label">Commision Points</label>
            <input type="number" class="form-control" name="commision" placeholder="Enter points" required>
        </div>
    </div>
</div>-->

<div class="form-group">
    <div class="row">
        <div class="col-md-4">
            <label class="form-control-label">Duration</label>
            <input type="number" name="duration" step="1" class="form-control just-number" placeholder="Duration"
                   required="">
        </div>
        <div class="col-md-4">
            <label class="form-control-label">Period</label>
            <select name="period" class="form-control" required="">
                <option value="Days">Days</option>
                <option value="Weeks">Weeks</option>
                <option value="Months">Months</option>
            </select>
        </div>
        <div class="col-md-4">
            <label class="form-control-label">Category</label>
            <select class="form-control" name="category">
                @if($countCertify_categories > 1)
                @foreach($Certify_categories as $Certify_category)
                @if($Certify_category->id == '0')
                <option value="{{$Certify_category->id}}" disabled="disabled" >{{$Certify_category->name}}</option>
                @else
                <option value="{{$Certify_category->id}}">{{$Certify_category->name}}</option>
                @endif
                @endforeach
                @else
                @foreach($Certify_categories as $Certify_category)
                <option value="{{$Certify_category->id}}">{{$Certify_category->name}}</option>
                @endforeach
                @endif
            </select>
        </div>
    </div>
</div>
<div class="form-group">
    <div class="row">
        <div class="col-md-12">
            <label>Instructor</label>
            <select id="" class="form-control select2" name="instructor[]" multiple="" required="">
                <option value="">Select Instructor</option>
                @foreach($instructor as $_instructor)
                <option value="{{ $_instructor->id??'' }}">{{ $_instructor->name??"" }}</option>
                @endforeach
            </select>
        </div>
    </div>
</div>  

<div class="form-group">
    <div class="row">
        <div class="col-md-12">
            <label class="form-control-label"> Type Image/Video</label>
            <select id="viewtype" class="form-control" name="viewtype" required="">
                <option value="image">Image</option>
                <option value="video">Video</option>
            </select>
        </div>
    </div>
</div>
<div class="form-group">
    <div class="row">
        <div class="col-md-12">
            <label class="form-control-label">Cover Image</label>

            <input type="file" name="image" class="custom-input-file croppie" crop-width="600" crop-height="600"  accept="image/*" required="" >       
        </div>
    </div>
</div>
<div class="form-group">
    <div class="row">
        <div class="col-md-12">
            <label class="form-control-label">Video Type</label>
            <select id="videotype" class="form-control" name="videotype" required="">
                <option value="video">Video</option>
                <option value="youtubelink">Youtube Link</option>
            </select>
        </div>
    </div>
</div>
<div class="form-group" id="youtubelink">
    <div class="row">
        <div class="col-md-12">
            <label class="form-control-label"> Youtube Link</label>
            <input type="text" name="youtubelink" class="form-control" value="">
        </div>
    </div>
</div>

<div class="form-group uploadvideo" id="videolink">
    <div class="row">
        <div class="col-md-12">
            <label class="form-control-label">Upload Video</label>

            <input type="file" class="form-control dropify" placeholder="Upload video File" name="video"  accept="video/mp4" >
        </div>
    </div>
</div>

<div class="form-group">
    <div class="row">
        <div class="col-md-12">
            <label class="form-control-label">Course Description</label>
            <textarea  required="" class="form-control" id="summary-ckeditor" name="description" placeholder="Certify Description" rows="5"></textarea>
        </div>
    </div>
</div>
@if(Auth::user()->type == 'admin' && !empty($free_products))
<div class="form-group">
  <div class="row">
    <div class="col-md-12">
      <label>Free Product</label>
      <select class="form-control" name="product">
        <option value="0"  selected>Select Free Product</option>
       
        @foreach($free_products as $free_product)
        <option value="{{$free_product->id}}" >{{$free_product->title}}</option>
        @endforeach
       
      </select>
    </div>
  </div>
</div>
@endif
<div class="form-group">
    <div class="row">
        <div class="col-md-12" style="display: inline-flex;">
            <input type="checkbox" name="authoritylabel" value="1" class="" />
            &nbsp;&nbsp;&nbsp;&nbsp;<label class="form-control-label">Issuing Authority</label>
        </div>
    </div>
</div>

<div class="form-group alllogofield">
    <div class="row">
        <div class="col-md-12">

            <label>Issuing Authority Logo</label>
<input type="file" name="addlogos" class="custom-input-file croppie" crop-width="400" crop-height="400"  accept="image/*" placeholder="Logo" >
        
        </div>
    </div>
</div>
<div class="form-group " >
    <div class="row">
        <div class="col-md-12">
            <label class="form-control-label">Upload Course File</label>

            <input type="file" class="form-control dropify" placeholder="Upload Course File" name="course_file"  accept="application/msword, application/vnd.ms-excel, application/vnd.ms-powerpoint,
text/plain, application/pdf, image/*" >
        </div>
    </div>
</div>
<div class="form-group">
    <div class="row">
        <div class="col-md-12" style="display: inline-flex;">
            <input type="checkbox" name="email_auto_reply" value="1" class="" />
            &nbsp;&nbsp;&nbsp;&nbsp;<label class="form-control-label">Email Auto Reply</label>
        </div>
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
<!-- Modal -->
    <div id="notDestroy" class="modal fade" role="dialog">
        <div class="modal-dialog">
            <!-- Modal content-->
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Alert <i class="fas fa-exclamation-circle"></i></h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <div class="modal-body">
                    This certify cannot be deleted because it has been already purchased by somebody.
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-sm btn-secondary rounded-pill" id="" data-dismiss="modal"
                            aria-label="Close">Cancel
                    </button>
                </div>
            </div>
        </div>
    </div>
    <!-- Modal -->
    <div id="destroyCertify" class="modal fade" role="dialog">
        <div class="modal-dialog">
            <!-- Modal content-->
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Are You Sure?</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <div class="modal-body">
                    This action can not be undone. Do you want to continue?
                </div>
                <div class="modal-footer">
                    {{ Form::open(['url' => 'certify/destroy','id' => 'destroy_certify','enctype' => 'multipart/form-data']) }}
                    <input type="hidden" name="certify_Id" id="certify_Id" value="">

                    <button type="submit" class="btn btn-sm btn-danger rounded-pill" id="">Yes</button>
                    {{ Form::close() }}
                    <button type="button" class="btn btn-sm btn-secondary rounded-pill" id="" data-dismiss="modal"
                            aria-label="Close">Cancel
                    </button>
                </div>
            </div>
        </div>
    </div>
    <!-- Modal -->
    <div id="addCertify" class="modal fade" role="dialog">
        <div class="modal-dialog">
            <!-- Modal content-->
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Are You Sure?</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <div class="modal-body">
                    Add This Courses in MyCourses.<br>
                    This action can not be undone. Do you want to continue?
                </div>
                <div class="modal-footer">
                    {{ Form::open(['url' => 'certify/corpurate/add/certify','id' => 'addCertifyCorpurate','enctype' => 'multipart/form-data']) }}
                    <input type="hidden" name="corpurate_certify" id="corpurate_certify" value="">

                    <button type="submit" class="btn btn-sm btn-danger rounded-pill" id="">Yes</button>
                    {{ Form::close() }}
                    <button type="button" class="btn btn-sm btn-secondary rounded-pill" id="" data-dismiss="modal"
                            aria-label="Close">Cancel
                    </button>
                </div>
            </div>
        </div>
    </div>
    <!-- Modal -->
    <div id="addedCertify" class="modal fade" role="dialog">
        <div class="modal-dialog">
            <!-- Modal content-->
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Alert !</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <div class="modal-body">
                    you already added this course.
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-sm btn-secondary rounded-pill" id="" data-dismiss="modal"
                            aria-label="Close">Cancel
                    </button>
                </div>
            </div>
        </div>
    </div>

<!-- Modal -->
<div id="destroyblog" class="modal fade" role="dialog">
  <div class="modal-dialog">
    <!-- Modal content-->
    <div class="modal-content">
       <div class="modal-header">
                <h5 class="modal-title">Are You Sure?</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
        </div>
    <div class="modal-body">
        This action can not be undone. Do you want to continue?
    </div>
      <div class="modal-footer">
          {{ Form::open(['url' => 'certify/destroy','id' => 'destroy_blog','enctype' => 'multipart/form-data']) }}
          <input type="hidden" name="certify_Id" id="blog_id"  value="">

        <button type="submit" class="btn btn-sm btn-danger rounded-pill" id="">Yes</button>
        {{ Form::close() }}
        <button type="button" class="btn btn-sm btn-secondary rounded-pill" id="" data-dismiss="modal" aria-label="Close">Cancel</button>
      </div>
    </div>
  </div>
</div>
@endsection

@push('script')
   <link rel="stylesheet" type="text/css" href="{{ asset('assets/css/simcify.min.css') }}">
<script src="{{ asset('assets/js/simcify.min.js') }}"></script>

<link rel="stylesheet" type="text/css" href="{{ asset('assets/libs/dropify/css/dropify.min.css') }}">
<script src="{{ asset('assets/libs/dropify/js/dropify.min.js') }}"></script>


<script src="{{ asset('public/ckeditor/ckeditor.js') }}"></script>

<script>
CKEDITOR.replace('summary-ckeditor');
</script>
<script>
    $(function () {
        $('input[name="prerequisites"]').hide();
        $('.responsefield').hide();
        //show it when the checkbox is clicked
        $('input[name="boardcertified"]').on('click', function () {
            if ($(this).prop('checked')) {
                $('input[name="prerequisites"]').fadeIn();
                $('.responsefield').fadeIn();
            } else {
                $('input[name="prerequisites"]').hide();
                $('.responsefield').hide();
            }
        });
    });
</script> 
<script>
    $(function () {
        $('input[name="addlogos"]').hide();
        $('.alllogofield').hide();
        //show it when the checkbox is clicked
        $('input[name="authoritylabel"]').on('click', function () {
            if ($(this).prop('checked')) {
                $('input[name="addlogos"]').fadeIn();
                $('.alllogofield').fadeIn();
            } else {
                $('input[name="addlogos"]').hide();
                $('.alllogofield').hide();
            }
        });
    });
</script> 

<script>
    $('#youtubelink').hide();
    $('#videotype').on('change', function () {

        if (this.value == "youtubelink") {
            $('#youtubelink').show();
            $('#videolink').hide();
        } else {
            $('#videolink').show();
            $('#youtubelink').hide();
        }
    });

</script>
<script>
function showModal() {
    $('body').loadingModal({text: 'loading...'});
    var delay = function(ms){ return new Promise(function(r) { setTimeout(r, ms) }) };
    var time = 1000000;
    delay(time)
            .then(function() { $('body').loadingModal('animation', 'circle').loadingModal('backgroundColor', 'black'); return delay(time);})
            .then(function() { $('body').loadingModal('destroy') ;} );
}
$( "#create_certify" ).submit(function( event ) {
  showModal();
});
</script>
@endpush
