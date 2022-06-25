<?php $page = "Help Desk Categories"; ?>
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
                  
             
                     <a href="{{ route('supportCategory.index') }}" class="btn btn-sm btn btn-primary float-right mr-1" >
        <span class="btn-inner--icon"><i class="fas fa-reply"></i></span>
    </a>
              
                     </div>
                
   <!-- Breadcrumb -->
                <div class="breadcrumb-bar mb-3">
                    <div class="container-fluid">
                        <div class="row align-items-center">
                            <div class="col-md-12 col-12">
                                <h2 class="breadcrumb-title">Help Desk Category Edit</h2>
                                <nav aria-label="breadcrumb" class="page-breadcrumb">
                                    <ol class="breadcrumb">
                                        <li class="breadcrumb-item"><a href="{{route('dashboard')}}">Dashboard</a></li>
                                        <li class="breadcrumb-item active" aria-current="page">Help Desk Category Edit</li>
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
                    {{ Form::open(['route' => 'supportCategory.update','id' => 'category update','enctype' => 'multipart/form-data']) }}
                
                    <div class="form-group">
                        <div class="row">
                            <div class="col-md-12">
                                <label class="form-control-label">Category Name</label>
                                <br>
                                <input type="text" class="form-control" name="name" style="color: black;" placeholder="Category Name" required value="{{$category->name}}">
                                <input type="hidden" name="id" value="{{encrypted_key($category->id,'encrypt')}}" />
                                <input type="hidden" name="csrf-token" value="<?= csrf_token(); ?>" />
                            </div>
                        </div>
                    </div>
                    <div class="text-right">
                        {{ Form::button(__('Update'), ['type' => 'submit','class' => 'btn btn-sm btn-primary rounded-pill']) }}
                      
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

