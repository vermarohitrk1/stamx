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
                   <a href="{{ route('badges') }}" class="btn btn-sm btn-primary float-right btn-icon-only rounded-circle " >
                        <span class="btn-inner--icon"><i class="fas fa-reply"></i></span>
                    </a>
                     </div>

<!-- Breadcrumb -->
<div class="breadcrumb-bar mt-3">
    <div class="container-fluid">
        <div class="row align-items-center">
            <div class="col-md-12 col-12">
                <h2 class="breadcrumb-title">Badge Create</h2>
                <nav aria-label="breadcrumb" class="page-breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Home</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('badges') }}">Reward point</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Badge Create</li>
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
               {{ Form::open(['url' =>'admin/create/badges','method' => 'post', 'enctype' => 'multipart/form-data']) }}
                @csrf

                @if(isset($badgeData) && $badgeData != null )
                    <input type="hidden" name="id" value="{{$id}}">
                    <input type="hidden" name="submit_type" value="update">
                @endif
    <div class="form-group">
        <div class="row">

        <!-- name -->
            <div class="col-md-8 show">
               <div class="form-group">
                  <label class="form-control-label">Name</label>
                   <input type="text" class="form-control" name="name" value ="@if(isset($badgeData) && $badgeData != null) {{$badgeData->name}} @else @endif" required>
                </div>
            </div>
        <!-- name -->
        <!-- Description -->
        <div class="col-md-8 show">
               <div class="form-group">
                  <label class="form-control-label">Description</label>
                   <textarea  class="form-control" name="description"  required>@if(isset($badgeData) && $badgeData != null) {{$badgeData->description}} @else @endif </textarea>
                </div>
            </div>
        <!-- Description -->
        <!-- mentor type -->
        <div class="col-md-8 show" style="display:none;">
               <div class="form-group">
                    <label class="form-control-label">Class</label>
                    <input type="text" class="form-control" name="class" value="@if(isset($badgeData) && $badgeData != null) {{$badgeData->class}} @else @endif"  required>
                </div>
            </div>
 <!-- mentor type -->
 <!-- level -->
            <div class="col-md-8 show">
               <div class="form-group">
                  <label class="form-control-label">Level</label>
                   <select class="form-control level1" name="level" id="level" required >
                   <option value="">Select </option>
                            @foreach($levels as $key => $level)
                               <option value="{{$level}}" @if(isset($badgeData) && $badgeData->level == $level) selected @endif > {{ $key }} </option>
                            @endforeach
                    </select>
                </div>
            </div>
 <!-- level -->

            <!-- college -->
            <div class="col-md-8 show">
                <div class="form-group">
                  <label class="form-control-label">Gamify Group</label>
                   <select class="form-control gamify_group" name="gamify_group_id" id="gamify_group" required>
                   <option value="" selected disabled> Select Group </option>
                    @foreach($gamifyGroup as $key => $value)
                        <option value="{{ $key }}" @if(isset($badgeData) && $badgeData != null && $badgeData->gamify_group_id == $key) selected  @else @endif>{{ $value }}</option>
                    @endforeach
                    </select>
                </div>
            </div>

       

            <div class="col-md-8 show">
                 <div class="form-group">
                      <label class="form-control-label">Points</label>
                      <input type="number" class="form-control" id="points" name="points" value="{{($badgeData->points??'')}}" min="0" required> 
                 </div>
            </div>

            <!-- name -->
            <div class="col-md-8 show">
               <div class="form-group">
                  <label class="form-control-label">Image</label>
                   <input type="file" class="form-control" name="image">
                </div>

                @if(isset($badgeData) && $badgeData != null && $badgeData->image != null )
                @php
                    if(file_exists(storage_path().'/reward_points/'.$badgeData->image)){
                            $url = asset('storage/reward_points/'.$badgeData->image);
                        }else{
                         $url = asset('storage/reward_points/'.$badgeData->image);
                    }
                @endphp
                <div class="form-group">
                    <img src="{{$url}}" width="100px" height="100px">
                </div>
                @else @endif

            </div>
        <!-- name -->


<!-- college -->


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
