<?php $page = "Course Categories"; ?>
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
          
                    
                     <a href="{{ route('certify.categories') }}" class="btn btn-sm btn-primary float-right btn-icon-only rounded-circle " >
        <span class="btn-inner--icon"><i class="fas fa-reply"></i></span>
    </a>
                     </div>
   
<!-- Breadcrumb -->
<div class="breadcrumb-bar mt-3">
    <div class="container-fluid">
        <div class="row align-items-center">
            <div class="col-md-12 col-12">
                <h2 class="breadcrumb-title">Blog Categories</h2>
                <nav aria-label="breadcrumb" class="page-breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{route('dashboard')}}">Home</a></li>
                        <li class="breadcrumb-item"><a href="{{route('certify.categories')}}">Course Categories</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Edit Category</li>
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
                   {{ Form::open(['route' => 'certify.categories.update','id' => 'update_certify_categories','enctype' => 'multipart/form-data']) }}
                
                    <div class="form-group">
                        <div class="row">
                            <div class="col-md-12">
                                <label class="form-control-label">Category Name</label>
                                <br>
                                <input type="text" class="form-control" name="name" style="color: black;" placeholder="Category Name" required value="{{$CertifyCategory->name??''}}">
                                <input type="hidden" name="id" value="{{$CertifyCategory->id??''}}" />
                                <input type="hidden" name="csrf-token" value="<?= csrf_token(); ?>" />
                            </div>
                        </div>
                    </div>
                   <div class="form-group">
    <div class="row">
        <div class="col-md-12">
            <label class="form-control-label">Icon</label>
  @if(!empty($CertifyCategory->icon))
                                <input type="file" name="image" class="custom-input-file croppie" default="{{asset('storage')}}/certify/icon/{{ $CertifyCategory->icon }}" crop-width="57" crop-height="42"  accept="image/*">
                                @else
                                <input type="file" name="image" class="custom-input-file croppie" crop-width="57" crop-height="42"  accept="image/*" required="" >       
                                @endif  
            
        </div>
    </div>
</div>
                    <div class="text-left">
                        {{ Form::button(__('Update'), ['type' => 'submit','class' => 'btn btn-sm btn-primary rounded-pill']) }}
                        <!--  <a href="{{ route('certify.categories') }}" id="back" class="btn btn-sm btn-white btn-icon-only rounded-circle ml-2" >
                            <span class="btn-inner--icon"><i class="fas fa-reply"></i></span>
                        </a>
 -->
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

@endpush
