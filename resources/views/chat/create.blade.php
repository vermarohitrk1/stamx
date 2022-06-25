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
                   <a href="{{ route('chat.groups.list') }}" class="btn btn-sm btn-primary float-right btn-icon-only rounded-circle " >
        <span class="btn-inner--icon"><i class="fas fa-reply"></i></span>
    </a>
                     </div>
   
<!-- Breadcrumb -->
<div class="breadcrumb-bar mt-3">
    <div class="container-fluid">
        <div class="row align-items-center">
            <div class="col-md-12 col-12">
                <h2 class="breadcrumb-title">Create Group</h2>
                <nav aria-label="breadcrumb" class="page-breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Home</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('chat.groups.list') }}">Group chat</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Create</li>
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
                {{ Form::open(['route' => 'chat.group.store','id' => 'new_input_form', 'name' => 'new_input_form','enctype' => 'multipart/form-data']) }}
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
                                <label class="form-control-label">Group Name</label>
                                <input type="text" class="form-control" name="name" value="{{ !empty($data->name) ? $data->name : ""}}" placeholder="Group Name" required>
                            </div>
                        </div>
                    </div>
<div class="form-group">
                        <div class="row">
                            <div class="col-md-12">
                                <label class="form-control-label">Group Description</label>
                                <textarea id="summary-ckeditor"  class="form-control"  name="description" placeholder="Group Description.." rows="10" minlength="1" maxlength="500" required=""  >{{!empty($data->description) ? $data->description :''}}</textarea>
                            </div>
                        </div>
                    </div>
<div class="col-12 col-md-12">
                                
                {{ Form::label('image', __('Attach Group image:'),['class' => 'form-control-label']) }}
                                @if(!empty($data->image))
                                 <input
                                     type="file" name="image" id="image" class="custom-input-file croppie" default="{{asset('storage/chat')}}/{{ $data->image }}" crop-width="600" crop-height="600"  accept="image/*" />
                                @else
                <input type="file" name="image" id="image" class="custom-input-file croppie" crop-width="600" crop-height="600"  accept="image/*" />
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
                                @if(!empty($users) && count($users) > 0)
                    <div class="form-group">
                        <div class="row">
                            <div class="col-md-12">                                    
                                <label class="form-control-label">Users</label>
                                <select class="form-control multiple-members " name="users[]" id="users" multiple="" required="">
                                @foreach($users as $index => $row)
                                    <option @if(!empty($data->members) && in_array($row->id,$data->members)) selected @endif value="{{ encrypted_key($row->id,'encrypt') }}">{{ ucwords($row->name)." (".ucwords($row->type).")" }} </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>
                    
                    <div class="text-right">
                        {{ Form::button(__('Save'), ['type' => 'submit','class' => 'btn btn-sm btn-primary rounded-pill']) }}
                       
                    </div>
                    @else
                    <div class="empty-section">
                        <i class="fa fa-clipboard-text"></i>
                        <h6 class="text-danger">No member exist please add members! </h6>
                        <div class="text-right">
                        <a href="{{route('users')}}">
                            <button type="button" class="btn btn-sm btn-primary rounded-pill">{{__('Manage Members')}}</button>
                        </a>
                        
                    </div>
                    </div>
                    @endif

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
<link rel="stylesheet" type="text/css" href="{{ asset('assets/css/dual-listbox.css') }}">
<script src="{{ asset('assets/js/dual-listbox.js') }}"></script>
<script>
CKEDITOR.replace('summary-ckeditor');

    $(document).ready(function(){

      $(function() {
        demo = new DualListbox('.multiple-members');
    });
    });

$(function () {
    // Initialize form validation on the form.
    $("form[name='new_input_form']").validate({
        // Specify validation rules
        rules: {
            'users[]': {
                required: true
            }
        },
        // Specify validation error messages
        messages: {
            'users[]': {
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
</script>










@endpush