<?php $page = "book"; ?>
@extends('layout.dashboardlayout')
@section('content')	

<style>
.hide{
        display:none;
    }
</style>
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
                <h2 class="breadcrumb-title">Pathway Create</h2>
                <nav aria-label="breadcrumb" class="page-breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Home</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('pathway.get') }}">Pathway</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Pathway Create</li>
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
               {{ Form::open(['url' =>'pathway/store','id' => 'create_pathway','enctype' => 'multipart/form-data']) }}


    <div class="form-group">
        <div class="row">
        <!-- mentor type -->
        <div class="col-md-8 show">
               <div class="form-group">
                  <label class="form-control-label">I am a</label>
                   <select class="form-control mentortype" name="mentor_type" id="mentor_type" >
                  
                        <option value="student">Student</option>
                        <option value="employee">Employee</option>
                        <option value="volunteer">Volunteer</option>
                        <option value="justice">Justice involved</option>
                        <option value="veteran">Veteran</option>
             
                    </select>
                </div>
            </div>
 <!-- mentor type -->
 <!-- level -->
            <div class="col-md-8 hide">
               <div class="form-group">
                  <label class="form-control-label">Level</label>
                   <select class="form-control level" name="level" id="mentor_type" >
                   <option value="">Select </option>
                        <option value="K-12">Grade Level K-12</option>
                        <option value="military">Military</option>
                        <option value="vocational">Vocational</option>
                        <option value="college">College</option>
             
                    </select>
                </div>
            </div>
 <!-- level -->
 <!-- honorably  -->
                        <div class="col-md-8 hide">
                        <div class="form-group">
                        <label class="display-block w-100">Were you honorably discharged?</label>
                        <div class="discharged">
                        <div class="custom-control custom-radio custom-control-inline">
                        <input class="custom-control-input" id="yes" name="discharged" value="yes" type="radio" checked="">
                        <label class="custom-control-label" for="yes">Yes</label>
                        </div>
                        <div class="custom-control custom-radio custom-control-inline">
                        <input class="custom-control-input" id="no" name="discharged" value="no" type="radio">
                        <label class="custom-control-label" for="no">No</label>
                        </div>
                        </div>
                        </div>
                        </div>
<!-- honorably  -->
<!-- veteranlist -->
<div class="col-md-8 hide">
               <div class="form-group">
                  <label class="form-control-label">Branch</label>
                   <select multiple class="form-control veteranlist" name="branch" id="branch2" >
                   <option value="">Select </option>
                
                        <option value="army">Army</option>
                        <option value="navy">Navy</option>
                        <option value="airforce">Air Force</option>
                        <option value="coastguard">Coast Guard</option>
                        <option value="marinecorps"> Marine Corps</option>
                        <option value="spaceforce">Space Force</option>
              
                    </select>
                </div>
            </div>
<!-- veteranlist -->
<!-- college -->
 <div class="col-md-8 hide">
               <div class="form-group">
                  <label class="form-control-label">College</label>
                   <select class="form-control college" name="college[]" id="college" multiple>
                   <option value="">Select </option>
                   @foreach($institution as $key => $value)
                     @if( $value->type == 'college' ||  $value->type == 'College' )
                        <option value="{{ $value->id }}">{{ $value->institution }}</option>
                      @endif
                      @endforeach
                    </select>
                </div>
                <div class="form-group">
                <span><a style="margin-bottom:20px;" class="btn btn-sm btn-primary .btn-rounded float-left" href="#" data-ajax-popup="true" data-url="{{route('college.create')}}" data-size="md" data-title="Add College">
            <span class="btn-inner--icon">Recommend College</span>
              </a></span>
            </div>
            </div>
           
<!-- college -->
<!-- grade level -->
<div class="col-md-8 hide">
               <div class="form-group">
                  <label class="form-control-label">Grade Level</label>
                   <select class="form-control gradelevel" name="gradeLevel" id="gradeLevel" multiple>
                   <option value="">Select </option>
                   @for($i=1; $i < 13; $i++)
                   <option value="{{ $i }}">Grade {{ $i }} </option>
                   @endfor
                    </select>
                </div>
              
            </div>
<!-- grade level -->
<!-- school -->
<div class="col-md-8 hide">
               <div class="form-group">
                  <label class="form-control-label">School</label>
                   <select class="form-control school" name="school[]" id="school" multiple>
                   <option value="">Select </option>
                   @foreach($institution as $key => $value)
                     @if( $value->type == 'school' ||  $value->type == 'School')
                        <option value="{{ $value->id }}">{{ $value->institution }}</option>
                      @endif
                      @endforeach
                    </select>
                </div>
                <div class="form-group">
                <span><a style="margin-bottom:20px;" class="btn btn-sm btn-primary .btn-rounded float-left" href="#" data-ajax-popup="true" data-url="{{route('school.create')}}" data-size="md" data-title="Add School">
            <span class="btn-inner--icon">Recommend School</span>
              </a></span>
            </div>
            </div>
<!-- school -->
<!-- trade category -->
<div class="col-md-8 hide">
               <div class="form-group">
                  <label class="form-control-label">Trade Category</label>
                   <select multiple class="form-control tradecategory" name="trade_category" id="trade_category" >
                      <option value="">Select </option>
                      @foreach($data as $key => $val)
                     <option value="{{ $val->id }}">{{ $val->name }}</option>
                   @endforeach
                    </select>
                </div>
            </div>
<!-- trade category -->
<!-- branch -->
<div class="col-md-8 hide">
               <div class="form-group">
                  <label class="form-control-label">Branch</label>
                   <select multiple  class="form-control branch" name="branch" id="branch" >
                        <option value="">Select </option>
                
                        <option value="army">Army</option>
                        <option value="navy">Navy</option>
                        <option value="airforce">Air Force</option>
                        <option value="coastguard">Coast Guard</option>
                        <option value="marinecorps"> Marine Corps</option>
                        <option value="spaceforce">Space Force</option>
              
                    </select>
                </div>
            </div>
<!-- branch -->
<!-- employee -->
<div class="col-md-8 hide">
               <div class="form-group">
                  <label class="form-control-label">Employer</label>
                   <select multiple class="form-control employeelist" name="employee" id="employee" >
                   <option value="">Select </option>
                   @foreach($employer as $key => $val)
                     <option value="{{ $val->id }}">{{ $val->company }}</option>
                   @endforeach
                    </select>
                </div>
                <div class="form-group">
                <span><a class="btn btn-sm btn-primary .btn-rounded float-left" href="#" data-ajax-popup="true" data-url="{{route('employer.create')}}" data-size="md" data-title="Recommend Employer">
            <span class="btn-inner--icon">Recommend Employer</span>
              </a></span>
            </div>
            </div>
<!-- employee -->
<!-- Apprenticeship  -->
<div class="col-md-8 hide">
               <div class="form-group">
                  <label class="form-control-label">Certification</label>
                   <select multiple class="form-control apprenticeship" name="catalog" id="apprenticeship" >
                   <option value="">Select </option>
                   @foreach($apprenticeship  as $key => $val)
                     <option value="{{ $val->id }}">{{ $val->name }}</option>
                   @endforeach
                    </select>
                </div>
            </div>
<!-- Apprenticeship  -->
<!-- cataloglist -->
<div class="col-md-8 hide">
               <div class="form-group">
                  <label class="form-control-label">Certification</label>
                   <select multiple class="form-control cataloglist" name="catalog" id="catalog" >
                   <option value="">Select </option>
                   @foreach($certify as $key => $val)
                     <option value="{{ $val->id }}">{{ $val->name }}</option>
                   @endforeach
                    </select>
                </div>
            </div>
<!-- cataloglist -->

            <div class="col-md-8">
            <div class="form-group">
                <label class="form-control-label">Type</label>
                <select class="form-control" name="type">
                     <option value="">Select Type</option>
                     <option value="career">Career</option>
                    <option value="business">Business</option>
                    <option value="life">Life</option>
                    <option value="family">Family</option>
                    <option value="health">Health</option>
                    <option value="relationship">Relationship</option>
                    <option value="community">Community</option>
                    <option value="finance">Finance</option>
                </select>
            </div>
       </div>

          
         
            <div class="col-md-8">
             <div class="form-group">
                <label class="form-control-label">Timeline</label>
                <div class="form-group">
                   <div class='input-group date' id='datetimepicker1'>
                    <input type='date' min="{{ date('Y-m-d') }}" class="form-control" name="timeline"/>
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
                     <option value="Yes">Yes</option>
                     <option value="No">No</option>
                    </select>
                </div>
            </div>
            <div class="col-md-8" id="remindertype">
            <div class="form-group">
                <label class="form-control-label">Reminder Type</label>
                <select class="form-control" name="reminder_type">
                  <option value="Daily">Daily</option>
                  <option value="Weekly">Weekly</option>
                  <option value="Monthly">Monthly</option>
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

<link rel="stylesheet" type="text/css" href="{{ asset('assets/libs/dropify/css/dropify.min.css') }}">
<script src="{{ asset('assets/libs/dropify/js/dropify.min.js') }}"></script>


<script src="{{ asset('public/ckeditor/ckeditor.js') }}"></script>



<script type="text/javascript">
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
         $(function () {
           
            var valueSelected = $('.show').find('.mentortype').children("option:selected").val();
             // alert(valueSelected);
                changetype(valueSelected)
            
            $('.mentortype').on('change', function (e) {
                $('.school').parent().parent().addClass('hide');
                $('.school').parent().parent().removeClass('show');
                $('.branch').parent().parent().addClass('hide');
                $('.branch').parent().parent().removeClass('show');
                $('.tradecategory').parent().parent().addClass('hide');
                $('.tradecategory').parent().parent().removeClass('show');
                $('.college').parent().parent().addClass('hide');
                $('.college').parent().parent().removeClass('show');
               
                var valueSelected = this.value;
                changetype(valueSelected)
              
              
                
              });
              $('.level').on('change', function (e) {
                var valueSelected = this.value;
                changestatus(valueSelected)
               
              });
            
              function changetype(valueSelected){
                     $('.level').parent().parent().addClass('hide');
                    $('.level').parent().parent().removeClass('show');
                    $('.employeelist').parent().parent().addClass('hide');
                    $('.employeelist').parent().parent().removeClass('show');
                    $('.cataloglist').parent().parent().addClass('hide');
                    $('.cataloglist').parent().parent().removeClass('show');
                    $('.veteranlist').parent().parent().addClass('hide');
                    $('.veteranlist').parent().parent().removeClass('show');
                    $('.discharged').parent().parent().addClass('hide');
                    $('.discharged').parent().parent().removeClass('show');
                    $('.apprenticeship').parent().parent().addClass('hide');
                    $('.apprenticeship').parent().parent().removeClass('show');
                if(valueSelected == 'student'){
                    $('.level').parent().parent().removeClass('hide');
                    $('.level').parent().parent().addClass('show');
                  }
                
                if(valueSelected == 'employee'){
                    $('.employeelist').parent().parent().removeClass('hide');
                    $('.employeelist').parent().parent().addClass('show');
                    $('.cataloglist').parent().parent().removeClass('hide');
                    $('.cataloglist').parent().parent().addClass('show');
                  }
                
                if(valueSelected == 'volunteer'){
                    $('.cataloglist').parent().parent().removeClass('hide');
                    $('.cataloglist').parent().parent().addClass('show');
                  }
                  if(valueSelected == 'justice'){
                    $('.apprenticeship').parent().parent().removeClass('hide');
                    $('.apprenticeship').parent().parent().addClass('show');
                  }
                
                if(valueSelected == 'veteran'){
                    $('.discharged').parent().parent().removeClass('hide');
                    $('.discharged').parent().parent().addClass('show');
                    $('.veteranlist').parent().parent().removeClass('hide');
                    $('.veteranlist').parent().parent().addClass('show');
                    $('.tradecategory').parent().parent().removeClass('hide');
                    $('.tradecategory').parent().parent().addClass('show');

                    
                  }
                
              }
              function changestatus(valueSelected){
                    $('.gradelevel').parent().parent().addClass('hide');
                    $('.gradelevel').parent().parent().removeClass('show');
                    $('.school').parent().parent().addClass('hide');
                    $('.school').parent().parent().removeClass('show');
                    $('.branch').parent().parent().addClass('hide');
                    $('.branch').parent().parent().removeClass('show');
                    $('.tradecategory').parent().parent().addClass('hide');
                    $('.tradecategory').parent().parent().removeClass('show');
                    $('.college').parent().parent().addClass('hide');
                    $('.college').parent().parent().removeClass('show');
                if(valueSelected == 'K-12'){
                    $('.gradelevel').parent().parent().removeClass('hide');
                    $('.gradelevel').parent().parent().addClass('show');
                    $('.school').parent().parent().removeClass('hide');
                    $('.school').parent().parent().addClass('show');
                    

                  }
              
                if(valueSelected == 'military'){
                    $('.branch').parent().parent().removeClass('hide');
                    $('.branch').parent().parent().addClass('show');

                  }
               
                if(valueSelected == 'vocational'){
                    $('.tradecategory').parent().parent().removeClass('hide');
                    $('.tradecategory').parent().parent().addClass('show');

                  }
                
                if(valueSelected == 'college'){
                    $('.college').parent().parent().removeClass('hide');
                    $('.college').parent().parent().addClass('show');

                  }
                
              }
         });
         $(document).ready(function() {
            $('.certify').select2({
        placeholder: 'Select',
        maximumSelectionLength: 1
        });
            $('.college').select2({
        placeholder: 'Select',
        maximumSelectionLength: 3 
        });
        $('.school').select2({
        placeholder: 'Select',
        maximumSelectionLength: 3 
        });
        $('.gradelevel').select2({
        placeholder: 'Select',
        maximumSelectionLength: 1 
        });
        $('.tradecategory').select2({
        placeholder: 'Select',
        maximumSelectionLength: 1 
        });
        $('.branch').select2({
        placeholder: 'Select',
        maximumSelectionLength: 1 
        });
        $('.employeelist').select2({
        placeholder: 'Select',
        maximumSelectionLength: 1 
        });
        $('.cataloglist').select2({
        placeholder: 'Select ',
        maximumSelectionLength: 1 
        });
        $('.veteranlist').select2({
        placeholder: 'Select ',
        maximumSelectionLength: 1 
        });
        $('.apprenticeship').select2({
        placeholder: 'Select ',
        maximumSelectionLength: 1 
        });
        
});


</script>



@endpush