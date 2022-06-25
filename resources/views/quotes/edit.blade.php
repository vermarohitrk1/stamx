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
                   <a href="{{ route('pathway.get') }}" class="btn btn-sm btn-primary float-right btn-icon-only rounded-circle " >
        <span class="btn-inner--icon"><i class="fas fa-reply"></i></span>
    </a>
                     </div>
   
<!-- Breadcrumb -->
<div class="breadcrumb-bar mt-3">
    <div class="container-fluid">
        <div class="row align-items-center">
            <div class="col-md-12 col-12">
                <h2 class="breadcrumb-title">Pathway Edit</h2>
                <nav aria-label="breadcrumb" class="page-breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Home</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('pathway.get') }}">Pathway</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Pathway Edit</li>
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
                {{ Form::open(['url' =>'pathway/update','id' => 'Pathway_update','enctype' => 'multipart/form-data']) }}
             
               <input type="hidden" name="id" value={{ $pathway->id }} />

<div class="form-group">
    <div class="row">
   
        <div class="col-md-8">
        <div class="form-group">
            <label class="form-control-label">Type</label>
            <select class="form-control" name="type">

                 <option value="">Select Type</option>
                 <option value="career" @if($pathway->type=='career') {{ 'selected'}} @else @endif >Career</option>
                <option value="business" @if($pathway->type=='business') {{ 'selected' }}  @else @endif >Business</option>
                <option value="life" @if($pathway->type=='life') {{ 'selected'}}  @else @endif >Life</option>
                <option value="family" @if($pathway->type=='family') {{ 'selected'}}  @else @endif >Family</option>
                <option value="health" @if($pathway->type=='health') {{ 'selected' }}  @else @endif >Health</option>
                <option value="relationship" @if($pathway->type=='relationship') {{ 'selected' }}  @else @endif >Relationship</option>
                <option value="community" @if($pathway->type=='community') {{ 'selected' }}  @else @endif >Community</option>
                <option value="finance" @if($pathway->type=='finance') {{ 'selected' }}  @else @endif >Finance</option>
            </select>
        </div>
   </div>

        <div class="col-md-8">
        <div class="form-group">
    
  
            <label class="form-control-label">Certify</label>
            <select class="form-control certify" name="certify[]" multiple>
            @foreach($certify as $key => $val)
            <option value="{{ $val->id }}" @foreach(json_decode($pathway->certify, true) as $key => $value)@if($value == $val->id) {{ 'selected '}} @endif @endforeach>{{ $val->name }}</option>
           @endforeach
      
            </select>
        </div>
</div>
        <div class="col-md-8">
        <div class="form-group">
            <label class="form-control-label">Timeline</label>
            <div class="form-group">
        <div class='input-group date' id='datetimepicker1'>
           <input type='date' class="form-control" min="{{ date('Y-m-d') }}" name="timeline" value="{{ $pathway->timeline }}"/>
           <span class="input-group-addon">
           <span class="glyphicon glyphicon-calendar"></span>
           </span>
        </div>
     </div>
</div>
        </div>
        <div class="col-md-8">
        <div class="form-group">
            <label class="form-control-label">Would you like to schedule a series of reminders to keep you on track</label>
            <select class="form-control" name="send_reminder" id="send_reminder">
               <option value="Yes" @if($pathway->send_reminder=='Yes') {{ 'selected'}} @else @endif>Yes</option>
               <option value="No" @if($pathway->send_reminder=='No') {{ 'selected'}} @else @endif>No</option>
            </select>
        </div>
</div>
        <div class="col-md-8" id="remindertype"  @if($pathway->send_reminder=='No') {{ 'style=display:none;'}} @else @endif>
        <div class="form-group">
            <label class="form-control-label">Reminder Type</label>
            <select class="form-control" name="reminder_type">
              <option value="Daily" @if($pathway->reminder_type=='Daily') {{ 'selected'}} @else @endif>Daily</option>
              <option value="Weekly" @if($pathway->reminder_type=='Weekly') {{ 'selected'}} @else @endif>Weekly</option>
              <option value="Monthly" @if($pathway->reminder_type=='Monthly') {{ 'selected'}} @else @endif>Monthly</option>
            </select>
</div>
        </div>
        
    </div>
</div>


</div>
<div class="col-md-8">
  <div class="text-right">
{{ Form::button(__('Save'), ['type' => 'submit','class' => 'btn btn-sm btn-primary rounded-pill']) }}
<!-- <button type="button" class="btn btn-sm btn-secondary rounded-pill" data-dismiss="modal">{{__('Cancel')}}</button> -->
</div>
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
$( document ).ready(function() {
    
    $('#send_reminder').on('change', function() {
    //$('input[name=send_reminder]').change(function(){

        var selected =$(this).val();
       if(selected == 'No'){
           $('#remindertype').hide();
       }
       else{
        $('#remindertype').show();
       }
    })
});
$(document).ready(function() {
    $('.certify').select2();
});
</script>
@endpush