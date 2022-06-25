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
                <h2 class="breadcrumb-title">Book Edit</h2>
                <nav aria-label="breadcrumb" class="page-breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Home</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('blog.index') }}">Book</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Book Edit</li>
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
                {{ Form::open(['url' =>'book/update','id' => 'Book update','enctype' => 'multipart/form-data']) }}

                    <div class="form-group">
                        <div class="row">
                            <div class="col-md-12">
                                <label class="form-control-label">Book title</label>
                                <input type="text" class="form-control" name="title" placeholder="Post title" value="{{$book->title}}" required>
                                <input type="hidden" name="csrf-token" value="<?=csrf_token();?>" />
                                <input type="hidden" name="id" value="{{$book->id}}" />
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="row">
                            <div class="col-md-12">
                                <label class="form-control-label">Amazon Product Link Or Product ID</label>
                                <input type="text" class="form-control" name="buylink" value="{{$book->buylink}}" placeholder="Amazon Product Link" required>
                            </div>
                        </div>
                    </div>

                    <div class="form-group">
                   <div class="row">
                  <div class="col-md-12">
                <label class="form-control-label"> Itunes Link </label>
                <input type="text" class="form-control" name="itunes_link" value="{{$book->itunes_link}}" placeholder="Itunes Link" required>
                 </div>
                </div>
                    </div>  

                    <div class="form-group">
                        <div class="row">
                       <div class="col-md-12">
                     <label class="form-control-label"> Price</label>
                     <input type="text" class="form-control" name="price" value="{{$book->price}}" placeholder="Price" required>
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
                                        <option value="{{ $category->id }}" @if($book->category == $category->id ) selected @endif >{{ $category->name }}</option>
                                        @endforeach
                                        @else
                                        <option value="0">Un-Categorized</option>
                                        @endif
                                    </select>
                                </div>
                                <div class="col-md-6">
                                    <label class="form-control-label">Status</label>
                                    <select class="form-control" name="status">
                                        <option value="Published" @if($book->status == "Published") selected @endif >Published</option>
                                        <option value="Unpublished" @if($book->status == "Unpublished") selected @endif >Unpublished</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="row">
                                <div class="col-md-6">
                                    <label class="form-control-label">Youtube video ID</label>
                                    <input type="text" class="form-control" name="youtube" value="{{$book->youtube}}" placeholder="Youtube video ID" >
                                </div>
                                <div class="col-md-6">
                                    <label class="form-control-label">Show Video</label>
                                    <select class="form-control" name="show_video" >
                                        <option @if($book->show_video == "Yes") selected @endif  value="Yes">Yes</option>
                                        <option @if($book->show_video == "No") selected @endif value="No">No</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
						    <div class="row">
						        <div class="col-md-12">
						               {{ Form::label('image', __('Post Image'),['class' => 'form-control-label']) }}
						            @if(!empty($book->image))
									<input type="file" name="image" class="custom-input-file croppie" default="{{asset('storage')}}/books/{{ $book->image }}" crop-width="550" crop-height="780"  accept="image/*">
                                    <div class="form-check">
                                        <input type="checkbox" class="form-check-input" name="image_delete" id="exampleCheck1">
                                        <label class="form-check-label" for="exampleCheck1">Delete image?</label>
                                    </div>
						            @else

										<input type="file" name="image" class="custom-input-file croppie" crop-width="550" crop-height="780"  accept="image/*" required="" >

						            @endif
						        </div>
						    </div>
						</div>

                        <div class="form-group">
                            <div class="row">
                                <div class="col-md-12">
                                    <label class="form-control-label">Book Description</label>
                                    <textarea class="form-control" id="summary-ckeditor" name="article" rows="10" >{!! $book->description !!}</textarea>
                                </div>
                            </div>
                        </div>
                        <div class="form-check">
                            <input type="checkbox" class="form-check-input" id="Featured" name="featured" value="1" @if($book->featured== 1 ) checked @endif>
                             <label class="form-check-label" for="Featured"> Featured </label>
                          </div>
                          <div class="form-check">
                            <input type="checkbox" class="form-check-input" id="Favourite" name="favourite_read" value="1" @if($book->favourite_read == 1 ) checked @endif>
                             <label class="form-check-label" for="Favourite"> Favourite Read </label>
                          </div>

                   <div class="form-check">
                   <input type="checkbox" class="form-check-input" id="Treading" name="treading_books" value="1" @if($book->treading_books == 1 ) checked @endif>
                  <label class="form-check-label" for="Treading"> Treading Books </label>
                     </div>
                     <!-- <div class="form-check">
                     <input type="checkbox" class="form-check-input" id="exampleCheck1" name="slider" value="1" @if($book->slider == 1 ) checked @endif>
                    <label class="form-check-label" for="exampleCheck1"> Slider </label>
                         </div> -->

                        <div class="text-right">
                            {{ Form::button(__('Update'), ['type' => 'submit','class' => 'btn btn-sm btn-primary rounded-pill']) }}
                             <a href="{{ url('book') }}">
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