<?php $page = "book"; ?>
@extends('layout.dashboardlayout')
@section('content')	
@php
    /**
     * @var \App\Plan $plan
    */
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
                   <a href="{{ route('plans.index') }}" class="btn btn-sm btn-primary float-right btn-icon-only rounded-circle " >
        <span class="btn-inner--icon"><i class="fas fa-reply"></i></span>
    </a>
                     </div>
   
<!-- Breadcrumb -->
<div class="breadcrumb-bar mt-3">
    <div class="container-fluid">
        <div class="row align-items-center">
            <div class="col-md-12 col-12">
                <h2 class="breadcrumb-title">Plan Edit</h2>
                <nav aria-label="breadcrumb" class="page-breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Home</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('plans.index') }}">Plan</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Edit</li>
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
            <form class="pl-3 pr-3" method="post" action="{{ route('plans.update') }}">
    @csrf
   
   <!-- <div class="row">
        <div class="col-12">
            <div class="form-group">
                <label class="form-control-label" for="name">{{ __('View On Home Page') }}</label>
                <label class="switch" style="float: right;">
                    <input type="checkbox" name="status" id="frontendToggle" value="true" @if(!empty($plan->status) && $plan->status != 'false') checked @endif>
                    <span class="slider round"></span>
                </label>
            </div>
        </div>
    </div>-->
    <div class="row">
        <div class="col-12">
            <div class="form-group">
                <label class="form-control-label" for="name">{{ __('Name') }}</label>
                <input type="text" class="form-control" id="name" name="name" value="{{$plan->name}}" required/>
				<input type="hidden" name="id" value="{{$plan->id}}">
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
                    <input type="number" min="0" class="form-control" id="weekly_price" name="weekly_price"
                           value="{{$plan->weekly_price}}" required/>
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
                    <input type="number" min="0" class="form-control" id="monthly_price" name="monthly_price"
                           value="{{$plan->monthly_price}}" required/>
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
                    <input type="number" min="0" class="form-control" id="annually_price" name="annually_price"
                           value="{{$plan->annually_price}}" required/>
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
                    <input type="number" min="0" class="form-control" id="setup_fee" name="setup_fee"
                           value="{{$plan->setup_fee}}" required/>
                </div>
            </div>
        </div>
    </div>
   
    <div class="row">
      
        
        <div class="col-12">
            <div class="form-group">
                <label class="form-control-label" for="description">{{ __('Description') }}</label>
                <textarea class="form-control" data-toggle="autosize" rows="1" id="description"
                          name="description">{{$plan->description}}</textarea>
            </div>
        </div>
    </div>
    <div class="text-right">
        <button class="btn btn-sm btn-primary rounded-pill" type="submit">{{ __('Update Plan') }}</button>
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
<script src="{{ asset('assets/libs/dragula/dist/dragula.min.js') }}"></script>

<link rel="stylesheet" type="text/css" href="{{ asset('assets/libs/dropify/css/dropify.min.css') }}">
<script src="{{ asset('assets/libs/dropify/js/dropify.min.js') }}"></script>

<script src="{{ asset('public/ckeditor/ckeditor.js') }}"></script>
<script type="text/javascript" src="{{ asset('assets/js/jquery-ui.min.js') }}"></script>
<script type="text/javascript" src="{{ asset('assets/js/repeater.js') }}"></script>
<script>
CKEDITOR.replace('summary-ckeditor');

     $(document).on("change","#expire1",function() {
         var value = this.value;
        if(value=='yes'){
            check = true;
            $('#expirydate1').attr("required", true);
            $('#dateDiv1').show();
        }else if(value=='no'){
            check = false;
            $('#expirydate1').val('');
            $('#expirydate1').attr("required", false);
            $('#dateDiv1').hide();
        }
    });
    $(document).on("change","#prepublish1",function() {
         var value = this.value;
        if(value=='yes'){
            check = true;
            $('#prepublish_date1').attr("required", true);
            $('#prepublishDiv1').show();
            $('#status').val('Unpublished');
        }else if(value=='no'){
            check = false;
            $('#prepublish_date1').val('');
            $('#prepublish_date1').attr("required", false);
            $('#prepublishDiv1').hide();
            $('#status').val('Published');
        }
    });
</script>
<script>
$('.list-group-item').on('click', function () {
    var href = $(this).attr('data-href');
    $('.tabs-card').addClass('d-none');
    $(href).removeClass('d-none');
    $('#tabs .list-group-item').removeClass('text-primary');
    $(this).addClass('text-primary');
});



// Task Stage move
var $taskDragAndDrop = $("body .task-stage-repeater tbody").sortable({
    handle: '.task-sort-handler'
});

var $taskRepeater = $('.task-stage-repeater').repeater({
    initEmpty: true,
    defaultValues: {},
    show: function () {
        $(this).slideDown();
    },
    hide: function (deleteElement) {
        $(this).slideUp(deleteElement);
    },
    ready: function (setIndexes) {
        $taskDragAndDrop.on('drop', setIndexes);
    },
    isFirstItemUndeletable: true
});

var value = JSON.parse($(".task-stage-repeater").attr('data-value'));

if (typeof value != 'undefined' && value.length > 0) {
    $taskRepeater.setList(value);
}

$(document).ready(function () {
    $('#progress_bar').change(function () {
        $('#p_percentage').html($(this).val());
    });

    $('input[type=radio][name=project_progress]').change(function () {
        if (this.value == 'true') {
            $('#progress_bar').removeAttr('disabled');
        } else {
            $('#progress_bar').attr('disabled', true);
        }
    });
})

// change email notification
@if (Auth::user()->type != 'admin')
$(document).on("click", ".email-template-checkbox", function () {
var chbox = $(this);
        $.ajax({
        url: chbox.attr('data-url'),
                data: {status: chbox.val()},
                type: 'PUT',
                success: function (response) {
                if (response.is_success) {
                show_toastr('Success', response.success, 'success');
                        if (chbox.val() == 1) {
                $('#' + chbox.attr('id')).val(0);
                } else {
                $('#' + chbox.attr('id')).val(1);
                }
                } else {
                show_toastr('Error', response.error, 'error');
                }
                },
                error: function (response) {
                response = response.responseJSON;
                        if (response.is_success) {
                show_toastr('Error', response.error, 'error');
                } else {
                show_toastr('Error', response, 'error');
                }
                }
        })
        });
        @endif
</script>
@endpush