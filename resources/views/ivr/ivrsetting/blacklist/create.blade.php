<?php $page = "blog"; ?>
@extends('layout.dashboardlayout')
@section('content')
<style>
    .intl-tel-input{
        width: 100%;
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
                    <a href="{{ route('blackList') }}" class="btn btn-sm btn-primary float-right btn-icon-only rounded-circle " >
                        <span class="btn-inner--icon"><i class="fas fa-reply"></i></span>
                    </a>
                </div>

                <!-- Breadcrumb -->
                <div class="breadcrumb-bar mt-3">
                    <div class="container-fluid">
                        <div class="row align-items-center">
                            <div class="col-md-12 col-12">
                                <h2 class="breadcrumb-title">Blacklist</h2>
                                <nav aria-label="breadcrumb" class="page-breadcrumb">
                                    <ol class="breadcrumb">
                                        <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Home</a></li>
                                        <!-- <li class="breadcrumb-item"><a href="{{ route('blog.index') }}">Blog</a></li> -->
                                        <li class="breadcrumb-item active" aria-current="page">Blacklist</li>
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
                                {{ Form::open(['route' => ['create.black.list'],'id' => 'create_blacklist','enctype' => 'multipart/form-data']) }}
                                    <input type="hidden" name="blacklist_id" value="{{($blacklistData->id ??'')}}">
                                    <div class="form-group">
                                        <label for="exampleFormControlInput1">Type</label>
                                        <div class="form-check">
                                            <input class="form-check-input radioCheck" type="radio" @if(!empty($blacklistData) && $blacklistData->type == '1') checked @else checked @endif  name="type" id="exampleRadios1" value="1" checked>
                                            <label class="form-check-label" for="exampleRadios1">
                                                Country
                                            </label>
                                        </div>
                                        <div class="form-check">
                                            <input class="form-check-input radioCheck" type="radio" @if(!empty($blacklistData) && $blacklistData->type == '2') checked  @endif  name="type" id="exampleRadios2" value="2">
                                            <label class="form-check-label" for="exampleRadios2">
                                                Mobile number
                                            </label>
                                        </div>
                                    </div>
                                    <div class="form-group numberDiv"     @if(!empty($blacklistData))  @if($blacklistData->type == '1') style="display: none" @endif @else style="display: none"  @endif>
                                        <div class="row">
                                            <div class="col-md-6">
                                                <label for="exampleFormControlInput1">Mobile number</label>
                                                <input type="text" class="form-control phone-input" name="value" placeholder="Please enter mobile number" value="{{ ($blacklistData->value ?? '')}}">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group countryDiv"  @if(!empty($blacklistData) && $blacklistData->type == '2') style="display:none" @endif>
                                        <div class="row">
                                            <div class="col-md-6">
                                                <label for="exampleFormControlInput1">Country</label>
                                                <select class="form-control" name="value">
                                                    <option selected disabled> -- Please select country --  </option>
                                                    @foreach($countries as $short_name =>  $country)
                                                        <option value=" {{ $short_name }} " @if(isset($blacklistData) && $blacklistData->type==1 && $blacklistData->value == $short_name) selected @endif> {{ $country }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <div class="row">
                                            <div class="col-md-6">
                                                <label class="form-control-label">Status</label>
                                                <select class="form-control" name="status" required>
                                                    <option value="1" @if(isset($blacklistData) && $blacklistData->status == 1) selected @endif>Active</option>
                                                    <option value="2" @if(isset($blacklistData) && $blacklistData->status == 2) selected @endif>Inactive</option>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="text-right">
                                        {{ Form::button(__('Save'), ['type' => 'submit','class' => 'btn btn-sm btn-primary rounded-pill']) }}
                                        <a href="{{route('blackList')}}" class="btn btn-sm btn-secondary rounded-pill">{{__('Cancel')}}</a>
                                    </div>
                                {{ Form::close() }}
                            </div>
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
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/12.1.3/css/intlTelInput.css" />
<script src="https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/12.1.3/js/intlTelInput.min.js"></script>
<link rel="stylesheet" type="text/css" href="{{ asset('assets/css/simcify.min.css') }}">
<script src="{{ asset('assets/js/simcify.min.js') }}"></script>

<link rel="stylesheet" type="text/css" href="{{ asset('assets/libs/dropify/css/dropify.min.css') }}">
<script src="{{ asset('assets/libs/dropify/js/dropify.min.js') }}"></script>


<script src="{{ asset('public/ckeditor/ckeditor.js') }}"></script>

<script>
    $(document).ready(function(){
            $(document).on('change','.radioCheck', function(){
                if($('.radioCheck:checked').val() == '2'){
                    $('.numberDiv').removeAttr('style').find('input').prop('disabled',false).prop('required',true);
                    $('.countryDiv').css('display','none').find('select').prop('disabled', true).prop('required',false);
                }else{
                    $('.countryDiv').removeAttr('style').find('select').prop('disabled',false).prop('required',true);
                    $('.numberDiv').css('display','none').find('input').prop('disabled',true).prop('required',false);
                }
            })
    });
    $( document ).ready(function() {
        $(".phone-input").length && $(".phone-input").intlTelInput({

       autoHideDialCode: false,
     autoPlaceholder: "on",
     dropdownContainer: "body",

     formatOnDisplay: false,
     geoIpLookup: function(callback) {
       $.get("http://ipinfo.io", function() {}, "jsonp").always(function(resp) {
         var countryCode = (resp && resp.country) ? resp.country : "";
         callback(countryCode);
       });
     },
     hiddenInput: "phone",
     initialCountry: "us",
     nationalMode: false,
     //onlyCountries: ['us', 'gb', 'ch', 'ca', 'do'],
     placeholderNumberType: "MOBILE",
     preferredCountries: ['us'],
     separateDialCode: true,
       utilsScript: "https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/12.1.3/js/utils.js"
   });

   $(".phone-input").blur(function () {
       $.trim($(this).val()) && ($(this).intlTelInput("isValidNumber") ? toastr.clear() : ($(this).val(""), toastr.error("Invalid phone number.", "Oops!", {
           timeOut: null,
           closeButton: !0
       })))
   });
   $(".phone-input").change(function () {

         $('input[name="phone"]').val($(this).intlTelInput("getNumber"));
       $(this).closest(".intl-tel-input").siblings("input[name='phone']").val($(this).intlTelInput("getNumber"));

   });
   });
</script>










@endpush
