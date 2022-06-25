<?php $page = "book"; ?>
@extends('layout.dashboardlayout')
@section('content')	

@push('theme-script')
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.1/jquery.validate.min.js" ></script>
<script src="{{ asset('assets/libs/bootstrap-tagsinput/dist/bootstrap-tagsinput.min.js') }}"></script>
@endpush
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
                   <a href="{{ route('faq.index') }}" class="btn btn-sm btn-primary float-right btn-icon-only rounded-circle " >
        <span class="btn-inner--icon"><i class="fas fa-reply"></i></span>
    </a>
                     </div>
   
<!-- Breadcrumb -->
<div class="breadcrumb-bar mt-3">
    <div class="container-fluid">
        <div class="row align-items-center">
            <div class="col-md-12 col-12">
                <h2 class="breadcrumb-title">Add FAQ</h2>
                <nav aria-label="breadcrumb" class="page-breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Home</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('faq.index') }}">FAQ</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Add FAQ</li>
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
               {{ Form::open(['route' => 'faq.store','id' => 'new_input_form', 'name' => 'new_input_form','enctype' => 'multipart/form-data']) }}
                    <input type="hidden" name="id" value="{{!empty($data->id) ? encrypted_key($data->id,'encrypt') :0}}" />
                    <input type="hidden" name="csrf-token" value="<?= csrf_token(); ?>" />
                    @if ($errors->any())
                    <div class="alert alert-danger">
                        <ul>
                            @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                    @endif
                    
					
                    <div class="form-group">
                        <div class="row">
                            <div class="col-md-12">
                                <label class="form-control-label">Choose a category:</label>
                                <select class="form-control category" name="category">
                                    @if(!empty($categories))
                                    @foreach($categories as $category)
                                    <option {{!empty($data->category_id) && $data->category_id==$category->id  ? 'selected' :''}} value="{{ $category->id }}">{{ $category->name }}</option>
                                    @endforeach
                                    @endif
                                </select>
                            </div>            
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="row">
                            <div class="col-md-12">
                                <label class="form-control-label">Question</label>
                                <input type="text" class="form-control" name="question" value="{{ !empty($data->question) ? $data->question : ""}}" maxlength="500" placeholder="Enter question.." required>
                            </div>
                        </div>
                    </div>
                    @if(!empty($data->keywords))
                    @php $style = 'display:block';  @endphp
                    @else
                        @if(!empty($data->category_id) && $data->category_id == 6)
                            @php $style = 'display:block';  @endphp
                        @else
                        @php $style = 'display:none'; @endphp
                        @endif
                    @endif 
                    <div class="form-group keywords" style="{{ $style }}">
                        <div class="row">
                            <div class="col-md-12">
                                <label class="form-control-label">Keywords</label>
                                {{ Form::text('keywords', !empty($data->keywords) ? $data->keywords :'', ['class' => 'form-control','id'=>'inputTag', 'data-role'=>'tagsinput', 'data-toggle' => 'tags','placeholder' => __('Type here...'),]) }}
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="row">
                            <div class="col-md-12">
                                <label class="form-control-label">Answer</label>
                                <textarea id="summary-"  class="form-control"  name="answer" placeholder="Your answer.." rows="10" maxlength="500" required=""  >{{!empty($data->answer) ? $data->answer :''}}</textarea>
                            </div>
                        </div>
                    </div>
                    <div class="text-right">
                        {{ Form::button(__('Save '), ['type' => 'submit','class' => 'btn btn-sm btn-primary rounded-pill']) }}
                       <a href="{{ route('faq.index') }}">
                            <button type="button" class="btn btn-sm btn-secondary rounded-pill">{{__('Back')}}</button>
                        </a>
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
<!-- <link rel="stylesheet" type="text/css" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
<link rel="stylesheet" type="text/css" href="https://bootstrap-tagsinput.github.io/bootstrap-tagsinput/dist/bootstrap-tagsinput.css"> -->
<script src="{{ asset('assets/js/simcify.min.js') }}"></script>

<link rel="stylesheet" type="text/css" href="{{ asset('assets/libs/dropify/css/dropify.min.css') }}">
<script src="{{ asset('assets/libs/dropify/js/dropify.min.js') }}"></script>
<!-- <script src="https://cdnjs.cloudflare.com/ajax/libs/typeahead.js/0.11.1/typeahead.bundle.min.js"></script>
<script src="https://bootstrap-tagsinput.github.io/bootstrap-tagsinput/dist/bootstrap-tagsinput.min.js"></script> -->
<script src="{{ asset('public/ckeditor/ckeditor.js') }}"></script>

<script>
//CKEDITOR.replace('summary-ckeditor');
//$("#inputTag").tagsinput('items');
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






$(function () {
    $(document).ready(function(){
        if($('.category :selected').text() == 'BOT'){
            $('.keywords').css('display','block')
        }else{
            $('.keywords').css('display','none')
        }
    });
    $(document).on('change','.category',function(){
        if($('.category :selected').text() == 'BOT'){
            $('.keywords').css('display','block')
        }else{
            $('.keywords').css('display','none')
        }
    });

});


</script>





@endpush