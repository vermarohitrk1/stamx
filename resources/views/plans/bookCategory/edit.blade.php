<?php $page = "blog"; ?>
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
          
                    
                     <a href="{{ route('book.get') }}" class="btn btn-sm btn-primary float-right btn-icon-only rounded-circle " >
        <span class="btn-inner--icon"><i class="fas fa-reply"></i></span>
    </a>
                     </div>
   
<!-- Breadcrumb -->
<div class="breadcrumb-bar mt-3">
    <div class="container-fluid">
        <div class="row align-items-center">
            <div class="col-md-12 col-12">
                <h2 class="breadcrumb-title"> Categories</h2>
                <nav aria-label="breadcrumb" class="page-breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{url('home')}}">Home</a></li>
                        <li class="breadcrumb-item"><a href="{{route('book.get')}}">Book</a></li>
                        <li class="breadcrumb-item active" aria-current="page"> Category Edit</li>
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
                    {{ Form::open(['route' => ['book.category.update'],'id' => 'category_update','enctype' => 'multipart/form-data']) }}
                
                    <div class="form-group">
                        <div class="row">
                            <div class="col-md-12">
                                <label class="form-control-label">Category Name</label>
                                <br>
                                <input type="text" class="form-control" name="name"  value="{{$bookCategory->name}}">
                                <input type="hidden" name="id" value="{{$bookCategory->id}}" />

<!--                                <div class="form-check">
                                <input type="checkbox" class="form-check-input" id="exampleCheck1" name="featured" value="1">
                                <label class="form-check-label" for="exampleCheck1"> Featured </label>
                                     </div>-->
                                <input type="hidden" name="csrf-token" value="<?= csrf_token(); ?>" />
                            </div>
                        </div>
                    </div>
                    <div class="text-right">
                        {{ Form::button(__('Update'), ['type' => 'submit','class' => 'btn btn-sm btn-primary rounded-pill']) }}
                         <a href="{{ route('book.category') }}">
                        <button type="button" class="btn btn-sm btn-secondary rounded-pill">{{__('Back')}}</button>
                        </a>
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
