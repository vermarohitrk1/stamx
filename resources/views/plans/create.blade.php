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
                   <a href="{{ route('plans.index') }}" class="btn btn-sm btn-primary float-right btn-icon-only rounded-circle " >
        <span class="btn-inner--icon"><i class="fas fa-reply"></i></span>
    </a>
                     </div>
   
<!-- Breadcrumb -->
<div class="breadcrumb-bar mt-3">
    <div class="container-fluid">
        <div class="row align-items-center">
            <div class="col-md-12 col-12">
                <h2 class="breadcrumb-title">Plan Create</h2>
                <nav aria-label="breadcrumb" class="page-breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Home</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('plans.index') }}">Book</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Plan Create</li>
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
               <form class="pl-3 pr-3" method="post" action="{{ route('plans.store') }}">
    @csrf
    <!--<div class="row">
        <div class="col-12">
            <div class="form-group">
                <label class="form-control-label" for="name">{{ __('View On Home Page') }}</label>
                <label class="switch" style="float: right;">
                    <input type="checkbox" name="status" id="frontendToggle" value="true">
                    <span class="slider round"></span>
                </label>
            </div>
        </div>
    </div>-->
    <div class="row">
        <div class="col-12">
            <div class="form-group">
                <label class="form-control-label" for="name">{{ __('Name') }}</label>
                <input type="text" class="form-control" id="name" name="name" required/>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-4">
            <div class="form-group">
                <label class="form-control-label" for="weekly_price">{{ __('Weekly Price') }}</label>
                <div class="input-group">
                    <div class="input-group-prepend">
                        <span class="input-group-text">{{(env('CURRENCY') ? env('CURRENCY') : '$')}}</span>
                    </div>
                    <input type="number" min="0" class="form-control" id="weekly_price" name="weekly_price" value=""
                           required/>
                </div>
            </div>
        </div>
        <div class="col-4">
            <div class="form-group">
                <label class="form-control-label" for="monthly_price">{{ __('Monthly Price') }}</label>
                <div class="input-group">
                    <div class="input-group-prepend">
                        <span class="input-group-text">{{(env('CURRENCY') ? env('CURRENCY') : '$')}}</span>
                    </div>
                    <input type="number" min="0" class="form-control" id="monthly_price" name="monthly_price" value=""
                           required/>
                </div>
            </div>
        </div>
        <div class="col-4">
            <div class="form-group">
                <label class="form-control-label" for="annually_price">{{ __('Annually Price') }}</label>
                <div class="input-group">
                    <div class="input-group-prepend">
                        <span class="input-group-text">{{(env('CURRENCY') ? env('CURRENCY') : '$')}}</span>
                    </div>
                    <input type="number" min="0" class="form-control" id="annually_price" name="annually_price" value=""
                           required/>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-12">
            <div class="form-group">
                <label class="form-control-label" for="setup_fee">{{ __('Setup Fee') }}</label>
                <div class="input-group">
                    <div class="input-group-prepend">
                        <span class="input-group-text">{{(env('CURRENCY') ? env('CURRENCY') : '$')}}</span>
                    </div>
                    <input type="number" min="0" class="form-control" id="setup_fee" name="setup_fee" value=""
                           required/>
                </div>
            </div>
        </div>
    </div>
   
   
 
    <div class="row">
        <div class="col-12">
            <div class="form-group">
                <label class="form-control-label" for="description">{{ __('Description') }}</label>
                <textarea class="form-control" data-toggle="autosize" rows="1" id="description"
                          name="description"></textarea>
            </div>
        </div>
    </div>
    <div class="text-right">
        <button class="btn btn-sm btn-primary " type="submit">{{ __('Create Plan') }}</button>
    </div>
</form>





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

<script>
CKEDITOR.replace('summary-ckeditor');

    $(document).ready(function() {
        var today = new Date();
        var dd = today. getDate() + 1;
        var mm = today. getMonth() + 1;
        var yyyy = today. getFullYear();
        if (dd < 10) {
            dd = "0" + dd;
        }
        if (mm < 10) {
            mm = "0" + mm;
        }
        var currentDate = yyyy+'-'+mm+'-'+dd;
        $('#expirydate').attr("min",currentDate);
        var check = false;
        $('#dateDiv').hide();
        $('#prepublishDiv').hide();
    });
    $(document).on("change","#expire",function() {
         var value = this.value;
        if(value=='yes'){
            check = true;
            $('#expirydate').attr("required", true);
            $('#dateDiv').show();
        }else if(value=='no'){
            check = false;
            $('#expirydate').val('');
            $('#expirydate').attr("required", false);
            $('#dateDiv').hide();
        }
    });
    $(document).on("change","#prepublish",function() {
         var value = this.value;
        if(value=='yes'){
            check = true;
            $('#prepublish_date').attr("required", true);
            $('#prepublishDiv').show();
            $('#status').val('Unpublished');
        }else if(value=='no'){
            check = false;
            $('#prepublish_date').val('');
            $('#prepublish_date').attr("required", false);
            $('#prepublishDiv').hide();
            $('#status').val('Published');
        }
    });
</script>










@endpush