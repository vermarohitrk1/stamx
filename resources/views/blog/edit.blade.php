<?php $page = "blog"; ?>
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
                   <a href="{{ route('blog.index') }}" class="btn btn-sm btn-primary float-right btn-icon-only rounded-circle " >
        <span class="btn-inner--icon"><i class="fas fa-reply"></i></span>
    </a>
                     </div>
   
<!-- Breadcrumb -->
<div class="breadcrumb-bar mt-3">
    <div class="container-fluid">
        <div class="row align-items-center">
            <div class="col-md-12 col-12">
                <h2 class="breadcrumb-title">Blog Create</h2>
                <nav aria-label="breadcrumb" class="page-breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Home</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('blog.index') }}">Blog</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Blog Create</li>
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
            <div class="card-body">
               {{ Form::open(['route' =>['blog.update'],'id' => 'blog update','enctype' => 'multipart/form-data']) }}

                        <div class="form-group">
                            <div class="row">
                                <div class="col-md-12">
                                    <label class="form-control-label">Title</label>
                                    <br>
                                    <input type="text" class="form-control" name="title" value="{{$blog->title}}">
                                    <input type="hidden" name="id" value="{{$blog->id}}" />
                                    <input type="hidden" name="csrf-token" value="<?= csrf_token(); ?>" />
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="row">
                                <div class="col-md-6">
                                    <label class="form-control-label">Category</label>
                                    <select class="form-control" name="category">
                                        @if(!empty($categories))
                                            @foreach($categories as  $category)
                                                @if($category->user_id == $authuser->id )
                                                <option value="{{ $category->id }}" @if($blog->category == $category->id ) selected @endif >{{ $category->name }}</option>
                                                @endif
                                            @endforeach
											@else
                                            <option value="0">Un-Categorized</option>
                                        @endif
                                    </select>
                                </div>
                                <div class="col-md-6">
                                    <label class="form-control-label">Status</label>
                                    <select class="form-control" id="status" name="status">
                                        <option value="Published" @if($blog->status == "Published") selected @endif >Published</option>
                                        <option value="Unpublished" @if($blog->status == "Unpublished") selected @endif >Unpublished</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="row">
                                <div class="col-md-6">
                                    <label class="form-control-label">Expire</label>
                                    <select class="form-control" name="expire" id="expire1">
                                        <option value="no"  @if($blog->expire == "no") selected @endif >No</option>
                                        <option value="yes" @if($blog->expire == "yes") selected @endif >Yes</option>
                                    </select>
                                </div>
                                <div class="col-md-6" id="dateDiv1">
                                    <label class="form-control-label">Expiry Date (Select Date)</label>
                                    <input type="date" id="expirydate1" name="expirydate" class="form-control" min="" onkeydown="return false" value="{{$blog->expirydate}}">
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="row">
                                <div class="col-md-6">
                                    <label class="form-control-label">Pre-Publish Date</label>
                                    <select class="form-control" name="prepublish" id="prepublish1">
                                        <option value="no"  @if($blog->prepublish_date == "") selected @endif >No</option>
                                        <option value="yes" @if($blog->prepublish_date) selected @endif >Yes</option>
                                    </select>
                                </div>
                                <div class="col-md-6" id="prepublishDiv1">
                                    <label class="form-control-label">Pre-Publish Date (Select Date)</label>
                                    <input type="date" id="prepublish_date1" name="prepublish_date" class="form-control" min="" onkeydown="return false" value="{{$blog->prepublish_date}}">
                                </div>
                            </div>
                        </div>
                    
                        <div class="form-group">
                            <div class="row">
                                <div class="col-md-12">
                                    <label class="form-control-label">Tags (Comma separated)</label>
                                    <input type="text" class="form-control" name="tags" placeholder="i.e Business,Money" value="{{$blog->tags}}">
                                </div>
                            </div>
                        </div>


                        		<div class="form-group">
						    <div class="row">
						        <div class="col-md-12">
						               {{ Form::label('image', __('Post Image'),['class' => 'form-control-label']) }}
						            @if(!empty($blog->image))
									<input type="file" name="image" class="custom-input-file croppie" default="{{asset('storage')}}/blog/{{ $blog->image }}" crop-width="1200" crop-height="800"   accept="image/*">
                                      <div class="form-group form-check">
                                        <input type="checkbox" name="delete_image" class="form-check-input" id="exampleCheck1">
                                        <label class="form-check-label" for="exampleCheck1">Delete Image?</label>
                                      </div>
						            @else

										<input type="file" name="image" class="custom-input-file croppie" crop-width="1200" crop-height="800"   accept="image/*" required="" >

						            @endif
						        </div>
						    </div>
						</div>
                        <div class="form-group uploadvideo" id="videolink" >
                    <div class="row">
                      <div class="col-md-12">
                <label class="form-control-label">Upload Video</label>

                <input type="file" class="form-control dropify" placeholder="Upload video File" name="video"  accept="video/mp4" >
                <br>
                @if(!empty($blog->video))
                    <video  controls style="width: 100%;height:50%">
                        <source src="{{url('storage/app/'.$blog->video)}}" type="video/mp4">
                        Your browser does not support the video tag.
                    </video>
                @endif
            </div>

        </div>
    </div>

    <div class="form-group">
        <div class="row">
            <div class="col-md-12">
                <label class="form-control-label">Youtube video ID</label>
                <input type="text" class="form-control" name="youtube" value="{{$blog->youtube}}" placeholder="Youtube video ID" >
            </div>
        </div>
    </div>


        <div class="form-group">
            <div class="row">
                <div class="col-md-12">
                    <label class="form-control-label">Write Blog Post</label>
                    <textarea class="form-control" id="summary-ckeditor" name="article" rows="10" >{{$blog->article}}</textarea>
                </div>
            </div>
        </div>
        <div class="form-check">
         <input type="checkbox" class="form-check-input" id="exampleCheck1" name="dont_miss" value="1" @if($blog->dont_miss== 1 ) checked @endif>
          <label class="form-check-label" for="exampleCheck1"> Don't Miss </label>
       </div>
       <div class="form-check">
         <input type="checkbox" class="form-check-input" id="exampleCheck1" name="featured" value="1" @if($blog->featured== 1 ) checked @endif>
          <label class="form-check-label" for="exampleCheck1"> Featured </label>
       </div>
       <div class="form-check">
         <input type="checkbox" class="form-check-input" id="exampleCheck1" name="editor_picked" value="1" @if($blog->editor_picked== 1 ) checked @endif>
          <label class="form-check-label" for="exampleCheck1"> Editor  picked </label>
       </div>
       <div class="form-check">
        <input type="checkbox" class="form-check-input" id="exampleCheck1"                 name="most_popular" value="1" @if($blog->most_popular == 1 ) checked @endif>
         <label class="form-check-label" for="exampleCheck1"> Most Popular </label>
          </div>
         </div>
                        <div class="text-right">
                            {{ Form::button(__('Update'), ['type' => 'submit','class' => 'btn btn-sm btn-primary rounded-pill']) }}
                             <a href="{{ url('blog') }}">
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
@endsection
@push('script')

<link rel="stylesheet" type="text/css" href="{{ asset('assets/css/simcify.min.css') }}">
<script src="{{ asset('assets/js/simcify.min.js') }}"></script>
<script src="{{ asset('assets/libs/dragula/dist/dragula.min.js') }}"></script>

<link rel="stylesheet" type="text/css" href="{{ asset('assets/libs/dropify/css/dropify.min.css') }}">
<script src="{{ asset('assets/libs/dropify/js/dropify.min.js') }}"></script>

<script src="{{ asset('public/ckeditor/ckeditor.js') }}"></script>
<script type="text/javascript" src="{{ asset('assets/js/jquery-ui.min.js') }}"></script>
<script type="text/javascript" src="{{ asset('assets/js/repeater.js') }}"></script>
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
        $('#expirydate1').attr("min",currentDate);
        $('#prepublish_date1').attr("min",currentDate);
        var check = false;
        $('#dateDiv1').hide();
        
        @if($blog->prepublish_date)
        $('#prepublishDiv1').show();
        @else
        $('#prepublishDiv1').hide();
        @endif
    });
     $(document).on("change","#expire1",function() {
         var value = this.value;
        if(value=='yes'){
            check = true;
            $('#expirydate1').attr("required", true);
            $('#dateDiv1').show();
        }else if(value=='no'){
            check = false;
            $('#expirydate1').val('');
            $('#expirydate1').attr("required", false);
            $('#dateDiv1').hide();
        }
    });
    $(document).on("change","#prepublish1",function() {
         var value = this.value;
        if(value=='yes'){
            check = true;
            $('#prepublish_date1').attr("required", true);
            $('#prepublishDiv1').show();
            $('#status').val('Unpublished');
        }else if(value=='no'){
            check = false;
            $('#prepublish_date1').val('');
            $('#prepublish_date1').attr("required", false);
            $('#prepublishDiv1').hide();
            $('#status').val('Published');
        }
    });
</script>
<script>
$('.list-group-item').on('click', function () {
    var href = $(this).attr('data-href');
    $('.tabs-card').addClass('d-none');
    $(href).removeClass('d-none');
    $('#tabs .list-group-item').removeClass('text-primary');
    $(this).addClass('text-primary');
});



// Task Stage move
var $taskDragAndDrop = $("body .task-stage-repeater tbody").sortable({
    handle: '.task-sort-handler'
});

var $taskRepeater = $('.task-stage-repeater').repeater({
    initEmpty: true,
    defaultValues: {},
    show: function () {
        $(this).slideDown();
    },
    hide: function (deleteElement) {
        $(this).slideUp(deleteElement);
    },
    ready: function (setIndexes) {
        $taskDragAndDrop.on('drop', setIndexes);
    },
    isFirstItemUndeletable: true
});

var value = JSON.parse($(".task-stage-repeater").attr('data-value'));

if (typeof value != 'undefined' && value.length > 0) {
    $taskRepeater.setList(value);
}

$(document).ready(function () {
    $('#progress_bar').change(function () {
        $('#p_percentage').html($(this).val());
    });

    $('input[type=radio][name=project_progress]').change(function () {
        if (this.value == 'true') {
            $('#progress_bar').removeAttr('disabled');
        } else {
            $('#progress_bar').attr('disabled', true);
        }
    });
})

// change email notification
@if (Auth::user()->type != 'admin')
$(document).on("click", ".email-template-checkbox", function () {
var chbox = $(this);
        $.ajax({
        url: chbox.attr('data-url'),
                data: {status: chbox.val()},
                type: 'PUT',
                success: function (response) {
                if (response.is_success) {
                show_toastr('Success', response.success, 'success');
                        if (chbox.val() == 1) {
                $('#' + chbox.attr('id')).val(0);
                } else {
                $('#' + chbox.attr('id')).val(1);
                }
                } else {
                show_toastr('Error', response.error, 'error');
                }
                },
                error: function (response) {
                response = response.responseJSON;
                        if (response.is_success) {
                show_toastr('Error', response.error, 'error');
                } else {
                show_toastr('Error', response, 'error');
                }
                }
        })
        });
        @endif
</script>
@endpush