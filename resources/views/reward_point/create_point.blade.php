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
                   <a href="{{ route('points') }}" class="btn btn-sm btn-primary float-right btn-icon-only rounded-circle " >
                        <span class="btn-inner--icon"><i class="fas fa-reply"></i></span>
                    </a>
                     </div>
   
<!-- Breadcrumb -->
<div class="breadcrumb-bar mt-3">
    <div class="container-fluid">
        <div class="row align-items-center">
            <div class="col-md-12 col-12">
                <h2 class="breadcrumb-title">Point Create</h2>
                <nav aria-label="breadcrumb" class="page-breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Home</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('badges') }}">Reward point</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Point Create</li>
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
               {{ Form::open(['url' =>'admin/create/points','method' => 'post', 'enctype' => 'multipart/form-data']) }}
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
        <!-- Point -->
        <div class="col-md-8 show">
               <div class="form-group">
                  <label class="form-control-label">Point</label>
                   <input type="text"  class="form-control" name="point"  required value="@if(isset($badgeData) && $badgeData != null) {{$badgeData->point}} @else @endif" >
                </div>
            </div>
        <!-- Point -->
        <!-- Description -->
        <div class="col-md-8 show">
               <div class="form-group">
                  <label class="form-control-label">Description</label>
                   <textarea  class="form-control" name="description"  required>@if(isset($badgeData) && $badgeData != null) {{$badgeData->description}} @else @endif </textarea>
                </div>
            </div>
        <!-- Description -->
        <!-- mentor type -->
            <div class="col-md-8 show" @if(isset($badgeData) && $badgeData->class != null) style="display:none;" @endif>
               <div class="form-group">
                    <label class="form-control-label">Class</label>
                    <input type="text" class="form-control" name="class" value="@if(isset($badgeData) && $badgeData != null) {{$badgeData->class}} @else @endif"  required>
                </div>
            </div>
 <!-- mentor type -->
 <!-- level -->
            <div class="col-md-8 show">
               <div class="form-group">
                  <label class="form-control-label">Allow Duplicate</label>
                   <select class="form-control level1" name="allow_duplicate" id="allow_duplicate" required >
                   <option value="">Select </option>
                        <option value="1" @if(isset($badgeData) && $badgeData != null && $badgeData->allow_duplicate == 1) selected  @else @endif>No</option>
                        <option value="0" @if(isset($badgeData) && $badgeData != null && $badgeData->allow_duplicate == 0) selected  @else @endif>Yes</option>
                    </select>
                </div>
            </div>
 <!-- level -->
 
            <!-- college -->
            <div class="col-md-8 show">
                <div class="form-group">
                  <label class="form-control-label">Gamify Group</label>
                   <select class="form-control gamify_group" name="gamify_group_id" id="gamify_group" required >
                   <option value="" selected disabled> Select Group </option>
                    @foreach($gamifyGroup as $key => $value)
                        <option value="{{ $key }}" @if(isset($badgeData) && $badgeData != null && $badgeData->gamify_group_id == $key) selected  @else @endif>{{ $value }}</option>
                    @endforeach
                    </select>
                </div>
                
            </div>

           
        
           
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

@endpush