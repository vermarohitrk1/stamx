<?php $page = "Shop Category"; ?>
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
          
        <a  class="btn btn-sm btn btn-primary float-right ml-2 " href="{{ route('shop.dashboard') }}"  >
        <span class="btn-inner--icon"><i class="fa fa-list"></i></span> {{__('Dashboard')}}
    </a>
        
   
       <a  class="btn btn-sm btn btn-primary float-right ml-2 " href="{{ route('shop.index') }}"  >
        <span class="btn-inner--icon"><i class="fa fa-reply"></i></span> 
    </a>
                   
                     </div>
                
   <!-- Breadcrumb -->
                <div class="breadcrumb-bar mb-3">
                    <div class="container-fluid">
                        <div class="row align-items-center">
                            <div class="col-md-12 col-12">
                                <h2 class="breadcrumb-title">Shop Category</h2>
                                <nav aria-label="breadcrumb" class="page-breadcrumb">
                                    <ol class="breadcrumb">
                                        <li class="breadcrumb-item"><a href="{{route('dashboard')}}">Dashboard</a></li>
                                        <li class="breadcrumb-item"><a href="{{route('shop.dashboard')}}">Shop Dashboard</a></li>
                                        <li class="breadcrumb-item active" aria-current="page">Shop Category</li>
                                    </ol>
                                </nav>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- /Breadcrumb -->
                
   

   
<div class="row mt-3" id="blog_category_view"  >
     
    
  <!-- list view -->
  <div class="col-12">
      <div class="card">
                <div class="card-header">
                    <h5 class=" h6 mb-0">{{ $category->name}}</h5>
                </div>
                <div class="card-body">
                    {{ Form::open(['route' => 'shopCategory.update','id' => 'category update','enctype' => 'multipart/form-data']) }}

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
                    <!--                    <div class="row">
                        <div class="col-12 col-md-12">
                            <label class="form-control-label">Select Parent ID</label>
                            <select  class="form-control" name="parent_id">
                                <option value="">Select option</option>
                                {{ \App\ShopCategory::get_category_tree(0,'',$category->id) }}
                            </select>
                        </div>
                    </div>-->
                    <div class="row">
                        <div class="col-12 col-md-12">
                            <label class="form-control-label">Status</label>
                            <select class="form-control" name="status">
                                <option value="Published" @if($category->status == "Published") selected @endif >Published</option>
                                <option value="Unpublished" @if($category->status == "Unpublished") selected @endif >Unpublished</option>
                            </select>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-12 col-md-12">
                            <label  class="form-control-label" >Products List</label>
                            <select class="form-control select2" name="products[]" multiple>
                                @foreach($allProducts as $productList)
                                <option @if(in_array($productList->id,$selected_products)) selected @endif  value="{{ $productList->id }}">{{ $productList->title }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="text-right mt-3">
                        {{ Form::button(__('Save'), ['type' => 'submit','class' => 'btn btn-sm btn-primary rounded-pill']) }}
                        <a href="{{ route('shopCategory.index') }}">
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

@push('script')
<link rel="stylesheet" type="text/css" href="{{ asset('assets/css/simcify.min.css') }}">
<script src="{{ asset('assets/js/simcify.min.js') }}"></script>

@endpush