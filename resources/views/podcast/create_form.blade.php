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
                        <div class="card-header">
                        

                            <h3>{{ !empty($data->title) ? $data->title : ""}}</h3>
                            <p class="text-muted mb-0">{{!empty($data->description) ? $data->description :''}}</p>
                            @if(!empty($data->episode))
                            <p class="text-muted mb-0">Create New Episode - {{$data->episode}}</p>
                            @endif
                        </div>
                        <div class="card-body">
                            {{ Form::open(['route' => 'podcast.store','id' => 'new_input_form', 'name' => 'new_input_form','enctype' => 'multipart/form-data']) }}
                            <input type="hidden" name="id" value="{{!empty($data->id) ? encrypted_key($data->id,'encrypt') :0}}" />
                            <input type="hidden" name="parent_episode_id" value="{{!empty($data->parent_episode_id) ? $data->parent_episode_id :0}}" />
                            <input type="hidden" name="episode" value="{{!empty($data->episode) ? $data->episode :0}}" />
                            <input type="hidden" name="csrf-token" value="<?= csrf_token(); ?>" />
                            @if ($errors->any())
                                <div class="alert alert-danger">
                                    <ul>
                                        @foreach ($errors->all() as $error)
                                            <li>{{ $error }}</li>
                                        @endforeach
                                    </ul>
                                </div>
                            @endif
                            <div class="form-group">
                                <div class="row">
                                    <div class="col-md-12">
                                        <label class="form-control-label">Title</label>
                                        <input type="text" class="form-control" name="title" value="{{ !empty($data->title) ? $data->title : ""}}" placeholder="Title" required>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="row">
                                    <div class="col-md-12">
                                        <label class="form-control-label">Description</label>
                                        <textarea id="summary-ckeditor"  class="form-control"  name="description" placeholder="Description.." rows="10" minlength="30" maxlength="500" required=""  >{{!empty($data->description) ? $data->description :''}}</textarea>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="col-12 col-md-12">
                                        
                                {{ Form::label('image', __('Attach a image related to podcast:'),['class' => 'form-control-label']) }}
                                                @if(!empty($data->image))
                                                <input
                                                    type="file" name="image" id="image" class="custom-input-file croppie" default="{{asset('storage/podcasts')}}/{{ $data->image }}" crop-width="600" crop-height="600"  accept="image/*" required=""/>
                                                @else
                                                <input type="file" name="image" id="image" class="custom-input-file croppie" crop-width="600" crop-height="600"  accept="image/*" required="" />
                                @endif   
                                <label for="image">
                                            @if(!empty($data->image))
                                            <span>{{$data->image}} </span>
                                            @else
                                            <i class="fa fa-upload"></i>
                                            <span>{{__('Choose a file…')}} </span>
                                            @endif
                                </label>
                            </div>

                            <div class="col-12 col-md-12">
                                @if(!empty($podcastfiles) && count($podcastfiles)>0)
                                <div class="form-group">
                                    <div class="row">
                                        <div class="col-md-12">
                                            <label class="form-control-label">Select Podcast File</label>
                                            <select class="form-control select2" name="podcast_file" reqiured>
                                                <option value="">Please Select</option>
                                                @foreach($podcastfiles as $key=> $value)
                                                <option {{!empty($data->file) && $data->file==$value->file ? 'selected' :''}}  value="{{$value->file}}">{{$value->file_name}}</option>
                                                @endforeach
                                            </select>
                                            <small>You can select a file from already uploaded podcast files or upload new files below.</small>
                                        </div>
                                    </div>
                                </div>
                                @endif
                                        
                                {{-- Form::label('file', __('Upload mp3 file:'),['class' => 'form-control-label']) --}}
                                            
                                <!-- <input type="file" class="dropify" placeholder="Upload mp3 podcast" name="file" data-allowed-file-extensions="mp3" >
                            
                                <label for="file">
                                                    <i class="fa fa-upload"></i>
                                                    <span>{{__('Choose a file…')}} </span>
                                                
                                                </label> -->
                            </div>
            
                                <div class="text-right mt-2">
                                    {{ Form::button(__('Save'), ['type' => 'submit','class' => 'btn btn-sm btn-primary rounded-pill']) }}
                                    
                                </div>
                                {{ Form::close() }}
                        </div>
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
<link rel="stylesheet" type="text/css" href="{{ asset('assets/css/simcify.min.css') }}">
<script src="{{ asset('assets/js/simcify.min.js') }}"></script>
<script>

$(function () {

    // Initialize form validation on the form.
    $("form[name='new_input_form']").validate({
        // Specify validation rules
        rules: {
            title: {
                required: true,
                minlength: 5,
                maxlength: 255

            },
            description: {
                required: true,
                minlength: 30,
                maxlength: 500
            }
        },
        // Specify validation error messages
        messages: {
            title: {
                required: "*Required",
                maxlength: "It should be 5-255 character alphanumeric including spaces, numbers, as well as hyphens(-) and single quote character(')",
                minlength: "It should be 5-255 character alphanumeric including spaces, numbers, as well as hyphens(-) and single quote character(')"
            },
            description: {
                required: "*Required",
                maxlength: "It should be 30-500 character alphanumeric including spaces, numbers, as well as hyphens(-) and single quote character(')",
                minlength: "It should be 30-500 character alphanumeric including spaces, numbers, as well as hyphens(-) and single quote character(')"
            }
        },
        // Make sure the form is submitted to the destination defined
        // in the "action" attribute of the form when valid
        submitHandler: function (form) {
            form.submit();
        }
    });
});
</script>

@endpush

