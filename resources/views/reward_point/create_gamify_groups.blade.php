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
                   <a href="{{ route('gamify_group') }}" class="btn btn-sm btn-primary float-right btn-icon-only rounded-circle " >
                        <span class="btn-inner--icon"><i class="fas fa-reply"></i></span>
                    </a>
                     </div>
   
<!-- Breadcrumb -->
<div class="breadcrumb-bar mt-3">
    <div class="container-fluid">
        <div class="row align-items-center">
            <div class="col-md-12 col-12">
                <h2 class="breadcrumb-title">Gamify Group</h2>
                <nav aria-label="breadcrumb" class="page-breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Home</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('gamify_group') }}">Gamify Group</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Gamify Group Create</li>
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
               {{ Form::open(['url' =>'admin/create/gamify-groups','method' => 'post', 'enctype' => 'multipart/form-data']) }}
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
        
 <!-- level -->
            <div class="col-md-8 show">
               <div class="form-group">
                  <label class="form-control-label">Type</label>
                   <select class="form-control level1" name="type" id="level" required >
                   <option value="">Select </option>
                        <option value="badge" @if(isset($badgeData) && $badgeData != null && $badgeData->type == 'badge') selected  @else @endif>Badge</option>
                        <option value="point" @if(isset($badgeData) && $badgeData != null && $badgeData->type == 'point') selected  @else @endif>Point</option>
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