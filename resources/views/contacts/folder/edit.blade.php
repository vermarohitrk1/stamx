<?php $page = "Contact Folder Edit"; ?>
@section('title')
    {{$page}}
@endsection
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
         
                    
                     <a href="{{ url('contacts/folder') }}" class="btn btn-sm btn-primary float-right btn-icon-only rounded-circle " >
        <span class="btn-inner--icon"><i class="fas fa-reply"></i></span>
    </a>
                     </div>
   
<!-- Breadcrumb -->
<div class="breadcrumb-bar mt-3">
    <div class="container-fluid">
        <div class="row align-items-center">
            <div class="col-md-12 col-12">
                <h2 class="breadcrumb-title">Contact Folder Edit</h2>
                <nav aria-label="breadcrumb" class="page-breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{route('dashboard')}}">Home</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('contacts') }}">Contacts</a></li>
                        <li class="breadcrumb-item"><a href="{{ url('contacts/folder') }}">Folders</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Contact Folder Edit</li>
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
          <div class="card-body p-0">
              {{ Form::open(['url' => 'contacts/folder/update/'.$folder->id,'id' => 'folder_update','enctype' => 'multipart/form-data','method'=>'post']) }}
                        @method('PUT')

                   <div class="form-group">
                    <div class="row">
                        <div class="col-md-12">
                            <label class="form-control-label">Name</label>
                            <input type="text" class="form-control" name="name" value="{{$folder->name}}" placeholder="Name" required>
                            <input type="hidden" name="csrf-token" value="<?=csrf_token();?>" />
                            <input type="hidden" name="id" value="{{$folder->id}}">
                        </div>
                    </div>
                </div>

            <div class="text-right">
                {{ Form::button(__('Save'), ['type' => 'submit','class' => 'btn btn-sm btn-primary rounded-pill']) }}
                <a href="{{url('contacts/folder')}}" class="btn btn-sm btn-secondary rounded-pill" data-dismiss="modal">{{__('Cancel')}}</a>
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

