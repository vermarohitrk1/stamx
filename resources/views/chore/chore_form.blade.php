<?php $page = "Chore Form"; ?>
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
         <a href="{{ route('chore.dashboard') }}" class="btn btn-sm btn-primary float-right btn-icon-only rounded-circle " >
        <span class="btn-inner--icon"><i class="fas fa-reply"></i></span>
    </a>
                   
                     </div>
                
   <!-- Breadcrumb -->
                <div class="breadcrumb-bar mb-3">
                    <div class="container-fluid">
                        <div class="row align-items-center">
                            <div class="col-md-12 col-12">
                                <h2 class="breadcrumb-title">Chore Form</h2>
                                <nav aria-label="breadcrumb" class="page-breadcrumb">
                                    <ol class="breadcrumb">
                                        <li class="breadcrumb-item"><a href="{{route('dashboard')}}">Dashboard</a></li>
                                        <li class="breadcrumb-item active" aria-current="page">Chore Form</li>
                                    </ol>
                                </nav>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- /Breadcrumb -->
                
   
  
<div class="row mt-3" id="blog_category_view">
  
  <!-- list view -->
  <div class="col-12">
      <div class="card">
          <div class="card-body">
                    {{ Form::open(['route' => 'chore.store','id' => 'new_input_form', 'name' => 'new_input_form','enctype' => 'multipart/form-data']) }}
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
                <input type="text" class="form-control" value="{{$data->title??''}}" name="title" placeholder="Chore title" required>
               
            </div>
        </div>    
        </div>  
<div class="form-group">
        <div class="row">
            <div class="col-md-12">
                <label class="form-control-label">Please Specify Chore Details</label>
                <textarea  class="form-control" id="description" name="description">{{$data->description??''}}</textarea>
            </div>
        </div>
    </div>
<div class="form-group">
                    <div class="row">
                            <div class="col-md-12">
                                <label class="form-control-label">Category</label>
                                <select class="form-control" name="category_id" reqiured>
                                    <option value="">Please Select</option>
                                    @foreach($categories as $key=> $value)
                                    <option {{!empty($data->category_id) && $data->category_id==$value->id ? 'selected' :''}}  value="{{$value->id}}">{{$value->name}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        </div>
<div class="form-group">
                        <div class="row">
                            <div class="col-md-12">
                                <label class="form-control-label">Please Select Chore Members</label>
                                <select class="form-control select2" name="members[]" reqiured multiple>
                                   @foreach($members as $key=> $value)
                                    <option {{!empty($data->members) && in_array($value->id,$data->members) ? 'selected' :''}}  value="{{$value->id}}">{{$value->name.' ('.$value->type.')'}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        </div>
                    <div class="form-group">
                        <div class="row">
                            <div class="col-md-12">
                                <label class="form-control-label">Status</label>
                                <select class="form-control" name="status" >
                                    <option {{!empty($data->status) && $data->status=="Active" ? 'selected' :''}}  value="Active">Active</option>
                                    <option {{!empty($data->status) && $data->status=="Inactive" ? 'selected' :''}} value="Inactive">Inactive</option>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="row">
                            <div class="col-md-12">
                                <label class="form-control-label">Priority</label>
                                <select class="form-control" name="priority" >
                                    <option {{!empty($data->priority) && $data->priority=="Low" ? 'selected' :''}}  value="Low">Low</option>
                                    <option {{!empty($data->priority) && $data->priority=="High" ? 'selected' :''}} value="High">High</option>
                                </select>
                            </div>
                        </div>
                    </div>
<!--                    <div class="form-group" >
                        <div class="row">
                            <div class="col-md-12">
                                <label class="form-control-label">Specify Allowance/Price (Optional)</label>
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <div class="input-group-text">
                                            <i class="fa fa-dollar-sign"></i> 
                                        </div>
                                    </div>
                                    <input type="number" class="form-control" id="price" name="price" value="{{!empty($data->price) ? $data->price :0.00}}" min="0"  step=".01" placeholder="i.e $5.00" >
                                </div>
                            </div>
                        </div>
                    </div>-->
                    <div class="form-group">
    <label class="form-control-label">Type</label>
    <select id="changeasaction" class="form-control" name="typeOnChoice" required="">
        <option value="">Please select type..</option>
        <option {{!empty($data->typeOnChoice) && $data->typeOnChoice=="Singleday" ? 'selected':''}} value="Singleday">Single day</option>
        <option {{!empty($data->typeOnChoice) && $data->typeOnChoice=="Weekly" ? 'selected':''}} value="Weekly">Weekly</option>
        <option {{!empty($data->typeOnChoice) && $data->typeOnChoice=="Monthly" ? 'selected':''}} value="Monthly">Monthly</option>
    </select>
</div>

<div class="form-group d-none mt-2" id="set_day">
<label class="form-control-label">Set Your day</label>
<select id="select2_basic" class="js-example-basic-multiple form-control select2" name="day[]" multiple="multiple">
    <option {{!empty($data->day) && in_array("Monday",json_decode($data->day)) ? 'selected':''}} value="Monday">Monday</option>
    <option {{!empty($data->day) && in_array("Tuesday",json_decode($data->day)) ? 'selected':''}} value="Tuesday">Tuesday</option>
    <option {{!empty($data->day) && in_array("Wednesday",json_decode($data->day)) ? 'selected':''}} value="Wednesday">Wednesday</option>
    <option {{!empty($data->day) && in_array("Thursday",json_decode($data->day)) ? 'selected':''}} value="Thursday">Thursday</option>
    <option {{!empty($data->day) && in_array("Friday",json_decode($data->day)) ? 'selected':''}} value="Friday">Friday</option>
    <option {{!empty($data->day) && in_array("Saturday",json_decode($data->day)) ? 'selected':''}} value="Saturday">Saturday</option>
    <option {{!empty($data->day) && in_array("Sunday",json_decode($data->day)) ? 'selected':''}} value="Sunday">Sunday</option>
</select>
</div>
<div class="form-group d-none mt-2" id="set_time">
    <div class="row">
        
        <div class="col-md-6 mt-2">
        <label class="form-control-label">Due Date</label>
            <input type="date" value="{{$data->start_date??''}}" class="form-control" name="start_date">
        </div>
        <div class="col-md-6 mt-2" id="end_date">
        <label class="form-control-label">End Date</label>
            <input type="date" value="{{$data->end_date??''}}" class="form-control" name="end_date">
        </div>
        <div class="col-md-6 mt-2">
        <label class="form-control-label">Chore Start Time</label>
         <input type="time" id="start_time" class="form-control" value="{{$data->start_time??''}}" name="start_time">

        </div>
        <div class="col-md-6 mt-2">
        <label class="form-control-label">Chore End Time</label>
         <input type="time" id="end_time" class="form-control" value="{{$data->end_time??''}}" name="end_time">

        </div>
    </div>
</div>
                    
                 
  
                    <div class="text-right mt-2">
                        {{ Form::button(__('Save'), ['type' => 'submit','class' => 'btn btn-sm btn-primary rounded-pill']) }}
                        
                    </div>
                    {{ Form::close() }}
                </div>	
      </div>
  </div> 
    <!-- list view -->
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
<!--<script src="{{ asset('public/ckeditor/ckeditor.js') }}"></script>-->

<script>
//CKEDITOR.replace('summary-ckeditor');


$(function () {

    // Initialize form validation on the form.
    $("form[name='new_input_form']").validate({
        // Specify validation rules
        rules: {
            title: {
                required: true,
                minlength: 1,
                maxlength: 255

            },
            category_id: {
                required: true,

            },
            start_date: {
                required: true,

            },
            end_date: {
                required: true,

            },
            'members[]': {
                required: true,

            },
            'day[]': {
                required: true,

            },
            description: {
                required: true,
                minlength: 5,
                maxlength: 1000
            }
        },
        // Specify validation error messages
        messages: {
            title: {
                required: "*Required",
                maxlength: "It should be 1-255 character alphanumeric including spaces, numbers, as well as hyphens(-) and single quote character(')",
                minlength: "It should be 1-255 character alphanumeric including spaces, numbers, as well as hyphens(-) and single quote character(')"
            },
            description: {
                required: "*Required",
                maxlength: "It should be 5-500 character alphanumeric including spaces, numbers, as well as hyphens(-) and single quote character(')",
                minlength: "It should be 5-500 character alphanumeric including spaces, numbers, as well as hyphens(-) and single quote character(')"
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
<script>
      
   // CKEDITOR.replace('summary-ckeditor');
  
   
    $(document).ready(function() {
       
   
   
         @php
   if(!empty($data->typeOnChoice)){
   @endphp
        changeasaction();
           @php
   }
   @endphp
   

$(document).on("change", "#changeasaction", function(){
       changeasaction();
        });
        
        
         $('#select2_basic').select2({width:'100%'});
    });
function changeasaction(){
     //$('#changeasaction').on('change', function() {
//           alert( this.value );
var change_val= $("#changeasaction").val();
          if(change_val == 'Singleday'){
            $('#set_time').removeClass('d-none');
            $('#set_day').addClass('d-none');
            $('#end_date').addClass('d-none');
        }else if(change_val == 'Monthly'){
            $('#set_time').removeClass('d-none');
            $('#end_date').removeClass('d-none');
            $('#set_day').addClass('d-none');
          }else if (change_val == 'Weekly') {
                $('#set_day').removeClass('d-none');
                $('#set_time').removeClass('d-none');
                $('#end_date').removeClass('d-none');
//                $('#set_time').addClass('d-none');
          }else{
            $('#set_time').addClass('d-none');
            $('#set_day').addClass('d-none');
          }
}

</script>
@endpush


