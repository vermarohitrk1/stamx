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
                   <a href="{{ route('plans.addons.category') }}" class="btn btn-sm btn-primary float-right btn-icon-only rounded-circle " >
        <span class="btn-inner--icon"><i class="fas fa-reply"></i></span>
    </a>
                     </div>
   
<!-- Breadcrumb -->
<div class="breadcrumb-bar mt-3">
    <div class="container-fluid">
        <div class="row align-items-center">
            <div class="col-md-12 col-12">
                <h2 class="breadcrumb-title">Add-On Edit category</h2>
                <nav aria-label="breadcrumb" class="page-breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Home</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('plans.addons.category') }}">Add-On Category</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Add-On Edit Category</li>
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
  {{ Form::open(['route' => ['plans.addons.category.update'],'id' => 'create_addons','class'=>'pl-3 pr-3','enctype' => 'multipart/form-data']) }}

        <div class="row">
            <div class="col-12">
            <div class="form-group">
                    <label class="form-control-label">Name</label>
                    <input type="text" class="form-control" name="name" placeholder="Name" value="{{$category_arr->name}}" required>
                </div>
            </div>
        </div>
        <input type="hidden" name="id" value="{{$category_arr->id}}">
        
        <div class="row">
            <div class="col-12">
      
    
                <div class="text-right">
                    {{ Form::button(__('Save'), ['type' => 'submit','class' => 'btn btn-sm btn-primary rounded-pill']) }}
                    <button type="button" class="btn btn-sm btn-secondary rounded-pill" data-dismiss="modal">{{__('Cancel')}}</button>
                </div>
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

<link rel="stylesheet" type="text/css" href="{{ asset('assets/css/simcify.min.css') }}">
<script src="{{ asset('assets/js/simcify.min.js') }}"></script>

<link rel="stylesheet" type="text/css" href="{{ asset('assets/libs/dropify/css/dropify.min.css') }}">
<script src="{{ asset('assets/libs/dropify/js/dropify.min.js') }}"></script>


<script src="{{ asset('public/ckeditor/ckeditor.js') }}"></script>

<script type="text/javascript">
     CKEDITOR.replace('summary-ckeditor');
     $( ".add_field_button" ).click(function() {
        var html = $("#new_sec").html();
        $(".ad_field_sec").append(html);
    });
   
    $(document).on("click", ".destroyInput", function(){
    $(this).closest('div .added_field_sec').remove();
    }); 
    $( "#create_addons" ).submit(function( event ) {
        var errorLength = $(".notSubmit").length;
        if(errorLength){
             event.preventDefault();
             $("#addon_key").focus()
        }
    });
    $("#addon_key").change(function () {
        var selected = $("#addon_key").val();
        if(selected != ''){
            $.ajax({
                url: "{{route('plans.addons.keycheck')}}?addon_key="+selected,
                success: function (getData)
                {
                    if (getData.status == true) {
                        $("#forError").attr('class', '');
                        $("#forError").attr('class', 'text-success');
                        $("#forError").html(getData.message);
                        $("#uniqueId").val(getData.data);
                        $("#TableUniqueIdentity").val(getData.data);
                        $("#forError").show();
                    } else {
                        $("#forError").attr('class', '');
                        $("#forError").attr('class', 'text-danger notSubmit');
                        $("#forError").html(getData.message);
                        $("#forError").show();
                    }
                }
            });
        }
        
    });
 </script> 











@endpush