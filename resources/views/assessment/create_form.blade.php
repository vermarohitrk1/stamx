<?php $page = "Create Assessment"; ?>
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
               
       
                     <a href="{{ route('assessment.dashboard') }}" class="btn btn-sm btn btn-primary float-right mr-2 m-0">
        <span class="btn-inner--text ">{{__('Dashboard')}}</span>
    </a>
                       @if(in_array("manage_surveys",$permissions) || $user->type =="admin")  
        <a href="{{ route('assessment.index') }}" class="btn btn-sm btn btn-primary float-right mr-2 m-0">
        <span class="btn-inner--text "><i class="fa fa-reply" ></i> </span>
    </a>
                       @endif 
     
                   
                     </div>
                
   <!-- Breadcrumb -->
                <div class="breadcrumb-bar mb-3">
                    <div class="container-fluid">
                        <div class="row align-items-center">
                            <div class="col-md-12 col-12">
                                <h2 class="breadcrumb-title">Create Assessment</h2>
                                <nav aria-label="breadcrumb" class="page-breadcrumb">
                                    <ol class="breadcrumb">
                                        <li class="breadcrumb-item"><a href="{{route('dashboard')}}">Dashboard</a></li>
                                        <li class="breadcrumb-item"><a href="{{route('crmcustom.dashboard')}}">Surveys Dashboard</a></li>
                                        <li class="breadcrumb-item"><a href="{{ route('crmcustom.index') }}">Manage Forms</a></li>
                                        <li class="breadcrumb-item active" aria-current="page">Create Assessment</li>
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
                <p class="text-muted mb-0">{{!empty($data->description) ? $data->description :''}}</p>
              </div>
                <div class="card-body">
                    {{ Form::open(['route' => 'assessment.store','id' => 'new_input_form', 'name' => 'new_input_form','enctype' => 'multipart/form-data']) }}
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
                                <label class="form-control-label">Form Title</label>
                                <input type="text" class="form-control" name="title" value="{{ !empty($data->title) ? $data->title : ""}}" placeholder="Form Title" required>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="row">
                            <div class="col-md-12">
                                <label class="form-control-label">Type</label>
                                <select class="form-control" name="type" id="formtype">
                                    <option {{!empty($data->type) && $data->type=="Free" ? 'selected' :''}}  value="Free">Free</option>
                                    <option {{!empty($data->type) && $data->type=="Paid" ? 'selected' :''}} value="Paid">Paid</option>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="form-group" id="amount" style="display:none;">
                        <div class="row">
                            <div class="col-md-12">
                                <label class="form-control-label">Specify Amount?</label>
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <div class="input-group-text">
                                            <i class="fa fa-dollar-sign"></i> 
                                        </div>
                                    </div>
                                    <input type="number" class="form-control" id="amount" name="amount" value="{{!empty($data->amount) ? $data->amount :0.00}}" min="1"  step=".01" placeholder="i.e $5.00" >
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="row">
                            <div class="col-md-12">
                                <label class="form-control-label">Choose a category:</label>
                                <select class="form-control" name="category">
                                    @if(!empty($categories))
                                    @foreach($categories as $category)
                                    <option {{!empty($data->category) && $data->category==$category->id  ? 'selected' :''}} value="{{ $category->id }}">{{ $category->name }}</option>
                                    @endforeach
                                    @endif
                                </select>
                            </div>            
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="row">
                            <div class="col-md-12">
                                <label class="form-control-label">Form Description</label>
                                <textarea id="summary-ckeditor"  class="form-control"  name="description" placeholder="Form Description.." rows="10" minlength="30" maxlength="500" required=""  >{{!empty($data->description) ? $data->description :''}}</textarea>
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
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.1/jquery.validate.min.js" ></script>
<script>
    $(document).ready(function(){
      $.ajax({
       url:"{{route('assessmentForm.sidebar',!empty($data->id) ? encrypted_key($data->id,'encrypt') :0)}}?sidebar=form_edit",
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
     if (value == 'Paid') {
        $("#amount").show()
    } else {
        $("#amount").val("")
        $("#amount").hide()
    }
}
$(function () {

    // Initialize form validation on the form.
    $("form[name='new_input_form']").validate({
        // Specify validation rules
        rules: {
            title: {
                required: true,
                minlength: 2,
                maxlength: 255

            },
            amount: {
                required: true,
                number: true,
                min: 1
            },
            description: {
                required: true,
                minlength: 2,
                maxlength: 500
            }
        },
        // Specify validation error messages
        messages: {
            title: {
                required: "*Required",
                maxlength: "It should be 2-255 character alphanumeric including spaces, numbers, as well as hyphens(-) and single quote character(')",
                minlength: "It should be 2-255 character alphanumeric including spaces, numbers, as well as hyphens(-) and single quote character(')"
            },
            amount: {
                required: "*Required",
                number: "Please enter currency amount i.e $5.00",
                min: "Minimum amount $1.00 required"
            },
            description: {
                required: "*Required",
                maxlength: "It should be 2-500 character alphanumeric including spaces, numbers, as well as hyphens(-) and single quote character(')",
                minlength: "It should be 2-500 character alphanumeric including spaces, numbers, as well as hyphens(-) and single quote character(')"
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


