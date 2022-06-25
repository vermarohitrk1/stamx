<?php $page = "Create Petition"; ?>
@extends('layout.dashboardlayout')
@section('content')	

     @php
        $user=Auth::user();
        $permissions=permissions();
        @endphp
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
               
       
                     <a href="{{ route('petitioncustom.dashboard') }}" class="btn btn-sm btn btn-primary float-right mr-2 m-0">
        <span class="btn-inner--text ">{{__('Dashboard')}}</span>
    </a>
                       @if(in_array("manage_petitions",$permissions) || $user->type =="admin")  
        <a href="{{ route('petitioncustom.index') }}" class="btn btn-sm btn btn-primary float-right mr-2 m-0">
        <span class="btn-inner--text "><i class="fa fa-reply" ></i> </span>
    </a>
                       @endif 
     
                   
                     </div>
                
   <!-- Breadcrumb -->
                <div class="breadcrumb-bar mb-3">
                    <div class="container-fluid">
                        <div class="row align-items-center">
                            <div class="col-md-12 col-12">
                                <h2 class="breadcrumb-title">Create Petition</h2>
                                <nav aria-label="breadcrumb" class="page-breadcrumb">
                                    <ol class="breadcrumb">
                                        <li class="breadcrumb-item"><a href="{{route('dashboard')}}">Dashboard</a></li>
                                        <li class="breadcrumb-item"><a href="{{route('petitioncustom.dashboard')}}">Petitions Dashboard</a></li>
                                        <li class="breadcrumb-item"><a href="{{ route('petitioncustom.index') }}">Manage Petitions</a></li>
                                        <li class="breadcrumb-item active" aria-current="page">Create Petition</li>
                                    </ol>
                                </nav>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- /Breadcrumb -->
                
   
    
    
<div class="row mt-3" id="blog_category_view">

    
<div class="col-lg-4 order-lg-2">
    <div id="page_sidebar_tabs"></div>
</div>
    {{--Main Part--}}
    <div class="col-lg-8 order-lg-1">
        <div id="tabs-1" class="tabs-card">
            <div class="card">
                <div class="card-header">
                  
                  <h3>{{ !empty($data->title) ? $data->title : ""}}</h3>
                <p class="text-muted mb-0">{!! html_entity_decode($data->description??'', ENT_QUOTES, 'UTF-8') !!}</p>
              </div>
                <div class="card-body">
                    {{ Form::open(['route' => 'petitioncustom.store','id' => 'new_input_form', 'name' => 'new_input_form','enctype' => 'multipart/form-data']) }}
                    <input type="hidden" name="id" value="{{!empty($data->id) ? encrypted_key($data->id,'encrypt') :0}}" />
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
                                <label class="form-control-label">Choose a folder:</label>
                                <select class="form-control" name="folder_id">
                                    @if(!empty($folders))
                                    @foreach($folders as $folder)
                                    <option {{!empty($data->folder_id) && $data->folder_id==$folder->id  ? 'selected' :''}} value="{{ $folder->id }}">{{ $folder->name }}</option>
                                    @endforeach
                                    @endif
                                </select>
                            </div>            
                        </div>
                    </div>
                    

                    <div class="form-group">
                        <div class="row">
                            <div class="col-md-12">
                                <label class="form-control-label">Status</label>
                                <select class="form-control" name="status" >
                                    <option {{!empty($data->status) && $data->status=="Published" ? 'selected' :''}}  value="Published">Published</option>
                                    <option {{!empty($data->status) && $data->status=="Unpublished" ? 'selected' :''}} value="Unpublished">Unpublished</option>
                                </select>
                            </div>
                        </div>
                    </div>
                       
                       <div class="form-group">
                        <div class="row">
                            <div class="col-md-12">
                                <label class="form-control-label">End Date</label>
                                <input type="date" class="form-control" name="end_date" value="{{ !empty($data->end_date) ? $data->end_date : ""}}"  required="">
                            </div>
                        </div>
                    </div>
                       <div class="form-group">
                        <div class="row">
                            <div class="col-md-12">
                                <label class="form-control-label">Target Supporters</label>
                                <input type="number" class="form-control" name="target" value="{{ !empty($data->target) ? $data->target : ""}}" min="1" step="1" required="">
                            </div>
                        </div>
                    </div>
@if($user->type =="admin")
                       <div class="form-group">
                        <div class="row">
                            <div class="col-md-12">
                                <label class="form-control-label">Dummy Supporters</label>
                                <input type="number" class="form-control" name="dummy" value="{{ !empty($data->dummy) ? $data->dummy : ""}}" min="0" step="1" >
                            </div>
                        </div>
                    </div>
@endif
<div class="form-group">
                        <div class="row">
                            <div class="col-md-12">
                                <label class="form-control-label">Description</label>
                                <textarea id="summary-ckeditor"  class="form-control"  name="description" placeholder="Form Description.." rows="10" minlength="30" maxlength="500" required=""  >{{!empty($data->description) ? $data->description :''}}</textarea>
                            </div>
                        </div>
                    </div>
<div class="form-group">
                        <div class="row">
                            <div class="col-md-12">
                                <label class="form-control-label">Tags</label>
                                <input type="text" class="form-control" name="tags" value="{{ !empty($data->tags) ? $data->tags : ""}}" placeholder="Tags" required><small>Comma separated</small>
                            </div>
                        </div>
                    </div>
<div class="form-group">
                        <div class="row">
                            <div class="col-md-12">
                                <label class="form-control-label">Promotion Alerts</label>
                                <select class="form-control" name="alerts" >
                                    <option {{!empty($data->alert) && $data->alert=="None" ? 'selected' :''}}  value="None">None</option>
                                    <option {{!empty($data->alert) && $data->alert=="Footer" ? 'selected' :''}} value="Footer">Footer</option>
                                    <option {{!empty($data->alert) && $data->alert=="Popup" ? 'selected' :''}} value="Popup">Popup</option>
                                </select>
                            </div>
                        </div>
                    </div>
<div class="form-group">
						    <div class="row">
						        <div class="col-md-12">
						               {{ Form::label('image', __('Image'),['class' => 'form-control-label']) }}
						            @if(!empty($data->image))
									<input type="file" name="image" class="custom-input-file croppie" default="{{asset('storage')}}/petition/{{ $data->image }}" crop-width="600" crop-height="400"   accept="image/*">
                                    
						            @else

										<input type="file" name="image" class="custom-input-file croppie" crop-width="600" crop-height="400"   accept="image/*" required="" >

						            @endif
						        </div>
						    </div>
						</div>
                
                    <div class="text-right">
                        {{ Form::button(__('Save Form'), ['type' => 'submit','class' => 'btn btn-sm btn-primary rounded-pill']) }}
                       
                    </div>
                    {{ Form::close() }}
                </div>
            </div>

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
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.1/jquery.validate.min.js" ></script>
<link rel="stylesheet" type="text/css" href="{{ asset('assets/libs/dropify/css/dropify.min.css') }}">
<script src="{{ asset('assets/libs/dropify/js/dropify.min.js') }}"></script>
<script src="{{ asset('public/ckeditor/ckeditor.js') }}"></script>



<script>
    CKEDITOR.replace('summary-ckeditor');
    $(document).ready(function(){
      $.ajax({
       url:"{{route('petitioncustomForm.sidebar',!empty($data->id) ? encrypted_key($data->id,'encrypt') :0)}}?sidebar=form_edit",
       success:function(data)
       {
        $('#page_sidebar_tabs').html(data);
       }
      });
    });
</script>
<script>
$(document).on("change", "#formtype", function () {
    var value = this.value;
   change_type(value);
});

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


