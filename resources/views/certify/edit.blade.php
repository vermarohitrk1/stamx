<?php $page = "Course Edit"; ?>
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
                <h2 class="breadcrumb-title">Course Edit</h2>
                <nav aria-label="breadcrumb" class="page-breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{route('dashboard')}}">Home</a></li>
                        <li class="breadcrumb-item"><a href="{{route('certify.index')}}">Courses</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Course Edit</li>
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
                    {{ Form::open(['url' => 'certify/update','id' => 'updateCertify','enctype' => 'multipart/form-data']) }}

                <div class="form-group">
                    <div class="row">
                        <div class="col-md-12">
                            <label class="form-control-label">Course Name</label>
                            <input type="text" name="name" class="form-control" placeholder="Course Name" value="{{$Certify->name}}" required="">
                            <input type="hidden" name="type" value="Regular">
                            <input type="hidden" name="certifyId" class="form-control" placeholder="Course Name" value="{{$Certify->id}}" required="">
                        </div>
                    </div>
                </div>

                

                <div class="form-group">
                    <div class="row">
                        <div class="col-md-6" style="display: inline-flex;">
                            <input type="checkbox" id="checkbox" name="boardcertified" value="1" class=""  @if($Certify->boardcertified == 1) checked @endif />
                            &nbsp;&nbsp;&nbsp;&nbsp;<label  class="form-control-label">Board Certified</label>
                        </div>
                    </div>
                </div>

                <div class="form-group responsefield">
                    <div class="row">
                        <div class="col-md-12">
                            <label class="form-control-label">Prerequisites</label>
                            <input type="text" id="showthis" name="prerequisites" class="form-control" value="{{$Certify->prerequisites}}" placeholder="Prerequisites ">
                        </div>
                    </div>
                </div>

                <div class="form-group">
                    <div class="row">
                        <div class="col-md-12">
                            <label class="form-control-label">CE Credits</label>
                            <input type="number" name="cecredit" class="form-control" placeholder="CE Credits" value="{{$Certify->cecredit}}">
                        </div>
                    </div>
                </div>
                <div class="form-group">
                    <div class="row">
                        <div class="col-md-12">
                            <label class="form-control-label">Degree Name</label>
                            <input type="text" name="degree" class="form-control" placeholder="Degree Name" value="{{$Certify->degree}}">
                        </div>
                    </div>
                </div>
                <div class="form-group">
                    <div class="row">
                        <div class="col-md-6">
                            <label class="form-control-label">Specialization</label>
                            <input type="text" name="specialization" class="form-control" placeholder="Specialization" value="{{$Certify->specialization}}">
                        </div>
                        <div class="col-md-6">
                            <label class="form-control-label">Certification</label>
                            <input type="text" name="certification" class="form-control" placeholder="Certification" value="{{$Certify->certification}}">
                        </div>
                    </div>
                </div>

                <div class="form-group">
                    <div class="row">
                        <div class="col-md-6">
                            <label class="form-control-label">Status</label>
                            <select class="form-control" name="status">
                                <option value="Published" @if($Certify->status == 'Published') selected  @endif>Published</option>
                                <option value="Unpublished" @if($Certify->status == 'Unpublished') selected @endif>Unpublished</option>
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label class="form-control-label">Syndicate</label>
                            <select class="form-control" name="syndicate">
                                <option value="Enabled" @if($Certify->syndicate == 'Enabled') selected  @endif >Enabled</option>
                                <option value="Disabled" @if($Certify->syndicate == 'Disabled') selected  @endif >Disabled</option>
                            </select>
                        </div>
                    </div>
                </div>

                <div class="form-group">
                    <div class="row">
                        <div class="col-md-6">
                            <label class="form-control-label">Price ($)</label>
                            <input type="number" class="form-control" name="price" placeholder="Price ($)" required value="{{$Certify->price}}">
                        </div>
                        <div class="col-md-6">
                            <label class="form-control-label">Sale Price ($)</label>
                            <input type="number" class="form-control" name="sale_price" placeholder="Sale Price ($)" value="{{$Certify->sale_price}}">
                        </div>
                    </div>
                </div>


                


                <div class="form-group">
                    <div class="row">
                        <div class="col-md-4">
                            <label class="form-control-label">Duration</label>
                            <input type="number" name="duration" step="1" class="form-control just-number" placeholder="Duration"
                                   required="" value="{{$Certify->duration}}">
                        </div>
                        <div class="col-md-4">
                            <label class="form-control-label">Period</label>
                            <select name="period" class="form-control" required="">
                                <option value="Days"  @if($Certify->period == 'Days') selected  @endif>Days</option>
                                <option value="Weeks"  @if($Certify->period == 'Weeks') selected  @endif>Weeks</option>
                                <option value="Months"  @if($Certify->period == 'Months') selected  @endif>Months</option>
                            </select>
                        </div>
                        <div class="col-md-4">
                            <label class="form-control-label">Category</label>
                            <select class="form-control" name="category">
                                <!--<option value="0">Select Catrgory</option>-->
                                @foreach($CertifyCategories as $CertifyCategory)
                                <option value="{{$CertifyCategory->id}}" @if($CertifyCategory->id == $Certify->category) selected  @endif>{{$CertifyCategory->name}}</option>
                                @endforeach

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
                                <option value="{{ $_instructor->id }}"  @if(in_array($_instructor->id,explode(',',$Certify->instructor))) selected  @endif>{{ $_instructor->name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                </div>  
                <div class="form-group">
                    <div class="row">
                        <div class="col-md-12">
                            <label class="form-control-label"> Type Image/Video</label>
                            <select id="viewtype" class="form-control" name="viewtype" >
                                <option value="image"  @if($Certify->viewtype == 'image') selected  @endif>Image</option>
                                <option value="video" @if($Certify->viewtype == 'video') selected  @endif>Video</option>
                            </select>
                        </div>
                    </div>
                </div>
                <div class="form-group">
                    <div class="row">
                        <div class="col-md-12">
                            <label class="form-control-label">Cover Image</label>

                            @if(!empty($Certify->image))
                            
                            <input type="file" name="image" class="custom-input-file croppie" default="{{asset('storage')}}/certify/{{ $Certify->image }}" crop-width="1000" crop-height="400"  accept="image/*">
                            @else
                            <input type="file" name="image" class="custom-input-file croppie" crop-width="1000" crop-height="400"  accept="image/*" required="" >
                            @endif    
                        </div>
                    </div>
                </div>
                <div class="form-group">
                    <div class="row">
                        <div class="col-md-12">
                            <label class="form-control-label">Video Type</label>
                            <select id="videotype" class="form-control" name="videotype" required="">
                                <option value="video"  @if($Certify->videotype == 'video') selected  @endif>Video</option>
                                <option value="youtubelink"  @if($Certify->videotype == 'youtubelink') selected  @endif>Youtube Link</option>
                            </select>
                        </div>
                    </div>
                </div>
                <div class="form-group" id="youtubelink">
                    <div class="row">
                        <div class="col-md-12">
                            <label class="form-control-label"> Youtube Link</label>
                            <input type="text" name="youtubelink" class="form-control" value="{{$Certify->youtubelink}}">
                        </div>
                    </div>
                </div>

                <div class="form-group uploadvideo" id="videolink">
                    <div class="row">
                        <div class="col-md-12">
                            <label class="form-control-label">Upload Video</label>

                            <input type="file" class="form-control dropify" placeholder="Upload video File" name="video"  accept="video/mp4" data-default-file="{{asset('storage')}}/app/{{ $Certify->video }}" value="">
                        </div>
                    </div>
                </div>

                <div class="form-group">
                    <div class="row">
                        <div class="col-md-12">
                            <label class="form-control-label">Course Description</label>
                            <textarea class="form-control" id="summary-ckeditor" name="description" placeholder="Course Description" rows="5"
                                      required>{{$Certify->description}}</textarea>
                        </div>
                    </div>
                </div>
                @if(Auth::user()->type == 'admin'  && !empty($free_products))
                <div class="form-group">
                  <div class="row">
                    <div class="col-md-12">
                      <label>Free Product</label>
                      <select class="form-control" name="product">
                        <option value="0" @if($Certify->product == '0') selected @endif>Select Free Product</option>
                    
                        @foreach($free_products as $free_product)
                        <option value="{{$free_product->id}}" @if($Certify->product == $free_product->id) selected @endif>{{$free_product->title}}</option>
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
                                @if(!empty($Certify->logos))
                                <input type="file" name="addlogos" class="custom-input-file croppie" default="{{asset('storage')}}/certify/{{ $Certify->logos }}" crop-width="400" crop-height="400"  accept="image/*">
                                @else
                                <input type="file" name="addlogos" class="custom-input-file croppie" crop-width="400" crop-height="400"  accept="image/*" >
                                @endif
                        </div>
                    </div>
                </div>
<div class="form-group " >
    <div class="row">
        <div class="col-md-12">
            <label class="form-control-label">Upload Course File</label>

            <input type="file" data-default-file="{{asset('storage')}}/{{ $Certify->course_file }}" class="form-control dropify" placeholder="Upload Course File" name="course_file"  accept="application/msword, application/vnd.ms-excel, application/vnd.ms-powerpoint,
text/plain, application/pdf, image/*" >
        </div>
    </div>
</div>
<div class="form-group">
    <div class="row">
        <div class="col-md-12" style="display: inline-flex;">
            <input type="checkbox" name="email_auto_reply" value="1" class=""  @if($Certify->email_auto_reply == 1) checked @endif />
            &nbsp;&nbsp;&nbsp;&nbsp;<label class="form-control-label">Email Auto Reply</label>
        </div>
    </div>
</div>
            </div>
            <div class="text-right mr-4 pb-3">
                {{ Form::button(__('Update'), ['type' => 'submit','class' => 'btn btn-sm btn-primary rounded-pill']) }}
                <a href="{{ url('certify') }}">
                    <button type="button" class="btn btn-sm btn-secondary rounded-pill">{{__('Back')}}</button>
                </a>
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
                    Add This Course in MyCourses.<br>
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
