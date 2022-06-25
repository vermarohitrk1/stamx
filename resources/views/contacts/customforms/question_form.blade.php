<?php $page = "Form Questions"; ?>
@section('title')
    {{$page}}
@endsection
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
               
       
                     <a href="{{ route('crmcustom.dashboard') }}" class="btn btn-sm btn btn-primary float-right mr-2 m-0">
        <span class="btn-inner--text ">{{__('Dashboard')}}</span>
    </a>
                     
                   
                     </div>
                
   <!-- Breadcrumb -->
                <div class="breadcrumb-bar mb-3">
                    <div class="container-fluid">
                        <div class="row align-items-center">
                            <div class="col-md-12 col-12">
                                <h2 class="breadcrumb-title">Form Questions</h2>
                                <nav aria-label="breadcrumb" class="page-breadcrumb">
                                    <ol class="breadcrumb">
                                        <li class="breadcrumb-item"><a href="{{route('dashboard')}}">Dashboard</a></li>
                                        <li class="breadcrumb-item"><a href="{{route('crmcustom.dashboard')}}">Surveys Dashboard</a></li>
                                        <li class="breadcrumb-item active" aria-current="page">Form Questions</li>
                                    </ol>
                                </nav>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- /Breadcrumb -->
                
   
    
    
<div class="row mt-3" id="blog_category_view">
    
    {{--Main Part--}}
       
<div class="col-lg-4 order-lg-2">
    <div id="page_sidebar_tabs"></div>
</div>
    <div class="col-lg-8 order-lg-1">
        <div id="tabs-1" class="tabs-card">
            <div class="card">
                <div class="card-header">
                     @if(in_array("manage_surveys",$permissions) || $user->type =="admin")  
                    <a href="{{ route('crmcustom.index') }}" class="btn btn-sm float-right btn-primary btn-icon rounded-pill mr-1 ml-1">
        <span class="btn-inner--text"><i class="fas fa-reply"></i></span>
    </a>
                   @endif   
                    <h3>{{$form->title}}</h3>
                <p class="text-muted mb-0">{{ ucfirst($form->description) }}</p>
                </div>
                <div class="card-body">
                    {{ Form::open(['route' => 'crmcustomQuestion.store','id' => 'new_input_form', 'name' => 'new_input_form','enctype' => 'multipart/form-data']) }}
                    <input type="hidden" name="form_id" value="{{!empty($form_id) ? encrypted_key($form_id,'encrypt') :0}}" />
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
                                <label class="form-control-label">Question</label>
                                <input type="text" class="form-control" name="question" value="{{ !empty($data->question) ? $data->question : ""}}" placeholder="What is your name?" required>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="row">
                         
                            <div class="col-md-12">
                                <label class="form-control-label">Type</label>
                                <select class="form-control" name="type" id="formtype">
                                @if(!empty($question_types))
                                    @foreach($question_types as $index => $row)
                                    <option {{!empty($data->type) && $data->type==$index  ? 'selected' :''}} value="{{ $index }}">{{ $row }}</option>
                                    @endforeach
                                    @endif
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="col-12 col-md-12" id="options_div" style="display:none">
                        <div class="row">
                            <div class="col-md-12">
                               <label class="form-control-label">Options to choose from</label>
                               <input type="text" class="form-control" id="options"  name="options" value="{{ !empty($data->options) ? $data->options : ""}}" placeholder="i.e Male,Female,Other" >
                                 <small>Comma separated values. Example: Male,Female,Other</small>
                            </div>
                        </div>
                    </div>
                    <div class="col-12 col-md-12" id="options_div_resource" style="display:none">
                        <div class="row">
                            <div class="col-md-12">
                               <label class="form-control-label">Resource URL for yes option</label>
                               <input type="url" class="form-control" id="resource_url"  name="resource_url" value="{{ !empty($data->resource_url) ? $data->resource_url : ""}}" placeholder="http://example.com" >
                                 <small>There are only two options yes and no, attached resource will be linked with yes option only.</small>
                            </div>
                        </div>
                    </div>
                    <div class="text-right">
                        {{ Form::button(__('Save'), ['type' => 'submit','class' => 'btn btn-sm btn-primary rounded-pill']) }}
                        @if(in_array("manage_surveys",$permissions) || $user->type =="admin")  
                     
                         @endif 
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
<script>
    $(document).ready(function(){
      $.ajax({
       url:"{{route('crmcustomForm.sidebar',!empty($form_id) ? encrypted_key($form_id,'encrypt') :0)}}?sidebar=form_question_add",
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
@if(!empty($data->type)){
    var value = $("#formtype").val();
   change_type(value);
}
@endif
function change_type(value){
     if (value == 'select' || value == 'radio' || value == 'checkbox') {
        $("#options_div").show();        
        $("#options_div_resource").hide();
    } else if(value == 'selectwith') {
        $("#options_div_resource").show();
        $("#options").val("")
    } else {
        $("#options").val("")
        $("#options_div").hide();
    }
}
$(function () {
    // Initialize form validation on the form.
    $("form[name='new_input_form']").validate({
        // Specify validation rules
        rules: {
            question: {
                required: true,
                minlength: 2,
                maxlength: 255

            },
            options: {
                required: true,
                minlength: 2,
                maxlength: 255
            }
        },
        // Specify validation error messages
        messages: {
            question: {
                required: "*Required",
                maxlength: "It should be 2-255 character alphanumeric including spaces, numbers, as well as hyphens(-) and single quote character(')",
                minlength: "It should be 2-255 character alphanumeric including spaces, numbers, as well as hyphens(-) and single quote character(')"
            },
            options: {
                required: "*Required",
                maxlength: "It should be 2-255 character alphanumeric including spaces, numbers, as well as hyphens(-) and single quote character(')",
                minlength: "It should be 2-255 character alphanumeric including numbers, as well as hyphens(-)"
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


