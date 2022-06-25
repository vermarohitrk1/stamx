@php
$page = 'partner';

/**
 * @var \App\JobFormEntity[] $jobFormEntity
 * @var \App\JobFormEntity $_jobFormEntity
 */
@endphp
@extends('layout.dashboardlayout')
@section('content')
    <style type="text/css">
        .bg-off-light.d-flex.align-items-center.p-4 {background: #fbfcff;}
        .form-icon {background-color: #009DA6; padding: 5px;}
        .border-switch { min-height: 0; color: #4466f2; padding-left: 0; }
        .border-switch .border-switch-control-input { display: none; }
        .border-switch .border-switch-control-input:checked~.border-switch-control-indicator { border-color: #4466f2; }
        .border-switch .border-switch-control-indicator { display: inline-block; position: relative; width: 32px; height: 20px; border-radius: 16px; transition: .3s; border: 2px solid #ccc; }
        .border-switch .border-switch-control-input:checked~.border-switch-control-indicator:after { left: 14px; background-color: #4466f2; }
        .border-switch .border-switch-control-indicator:after { content: ""; display: block; position: absolute; width: 12px; height: 12px; border-radius: 50%; transition: .3s; top: 2px; left: 2px; background: #ccc; }
        .note.note-warning.p-4 { background-color: #c1c0ff40; }
        .table-fixed thead tr th { border: 0; background-color: #f9f9f9; }
        .field-modal-body.custom-scrollbar { height: 50vh; overflow-y: auto; }
        .custom-field-modal-body.custom-scrollbar { height: 30vh; overflow-y: auto; }
        label.custom-control.d-inline.border-switch.mb-0.mr-3.disabled { opacity: .6!important; pointer-events: none!important; }
        .default-base-color { background-color: #f9f9f9; }
        .custom-input-group { position: relative; }
        .custom-input-group .input-group-append button { position: absolute; top: 50%; right: 0; border: 0; padding: 10px 14px; color: #afb1b6; transform: translateY(-50%); background-color: initial; transition: .25s; }
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
                    <div class=" col-md-12 "></div>
                    <!-- Breadcrumb -->
                    <div class="breadcrumb-bar mt-3">
                        <div class="container-fluid">
                            <div class="row align-items-center">
                                <div class="col-md-12 col-12">
                                    <h2 class="breadcrumb-title">Job Point</h2>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- /Breadcrumb -->
                    <br>
                    <div class="row" id="blog_view">
                        <div class="col-12">
                            <div class="card">
                                <div class="card-body">
                                    <div class="tab-content profile-tab-cont">
                                        <div class="card-header">
                                            <div class="jobpoint-menu">
                                                <ul class="nav nav-tabs nav-tabs-solid">
                                                    <li class="nav-item">
                                                        <a class="nav-link active" data-toggle="tab"
                                                           href="#application_form">Application Form</a>
                                                    </li>
                                                    <li class="nav-item">
                                                        <a class="nav-link" data-toggle="tab" href="#hiring_stage">Hiring
                                                            Stage</a>
                                                    </li>
                                                    <li class="nav-item">
                                                        <a class="nav-link" data-toggle="tab"
                                                           href="#event_type">Event Type</a>
                                                    </li>
                                                    <li class="nav-item">
                                                        <a class="nav-link " data-id="Billing" data-toggle="tab"
                                                           href="#job_type">Job Type</a>
                                                    </li>
                                                    <li class="nav-item">
                                                        <a class="nav-link " data-id="Billing" data-toggle="tab"
                                                           href="#department">Department</a>
                                                    </li>
                                                    <li class="nav-item">
                                                        <a class="nav-link " data-id="Billing" data-toggle="tab"
                                                           href="#location">Location</a>
                                                    </li>
                                                </ul>
                                            </div>
                                        </div>
                                        <br><br>
                                        <div class="tab-pane fade show active" id="application_form">
                                            <div class="table-responsive-md">
                                                <h3>Application Form</h3>
                                                <hr width="100%">
                                            </div>

                                            <div class="container">
                                                @if(!empty($jobFormEntity))
                                                    @foreach($jobFormEntity as $_jobFormEntity)
                                                        {{--@if($_jobFormEntity->slug == \App\JobFormEntity::QUESTION_SLUG)
                                                            <div class="rounded border mb-5">
                                                                <div class="bg-off-light d-flex align-items-center justify-content-between p-4">
                                                                    <div class="d-flex align-items-center">
                                                                        <div>
                                                                            <label class="custom-control d-inline border-switch mb-0 mr-3">
                                                                                <input type="checkbox" name="section_isVisible" id="section_isVisible" class="border-switch-control-input" value="true">
                                                                                <span class="border-switch-control-indicator"> </span>
                                                                            </label>
                                                                        </div>
                                                                        <h6 class="mb-0">
                                                                            <label class="mb-0">
                                                                                {{__($_jobFormEntity->label)}}
                                                                            </label>
                                                                        </h6>
                                                                    </div>
                                                                </div>
                                                                <div class="p-4">
                                                                    @if(!empty($_jobFormEntity->jobFormField))
                                                                        @foreach($_jobFormEntity->jobFormField as $jobField)

                                                                            <div class="d-flex align-items-center justify-content-between mb-2">
                                                                                <div class="d-inline-flex align-items-center">
                                                                                    <div class="width-30 height-30 text-white bg-brand-color rounded d-inline-flex align-items-center justify-content-center mr-2">
                                                                                        <p class="form-icon">{!! $_jobFormEntity->icon !!}</p>
                                                                                    </div>
                                                                                    <p class="text-muted mb-0"> {{ $jobField->label}}</p>
                                                                                </div>
                                                                                <div class="d-inline-flex align-items-center">
                                                                                    <a href="#" class="text-muted default-base-color width-30 height-30 rounded d-inline-flex align-items-center justify-content-center mr-2">
                                                                                        <i class="fas fa-edit"></i>
                                                                                    </a>
                                                                                    <a href="#" class="text-muted default-base-color width-30 height-30 rounded d-inline-flex align-items-center justify-content-center">
                                                                                        <i class="far fa-trash-alt"></i>
                                                                                    </a>
                                                                                </div>
                                                                            </div>
                                                                        @endforeach
                                                                    @endif
                                                                        <div class="dropdown">
                                                                        <button type="button" id="addQuestion"
                                                                                data-toggle="dropdown" aria-haspopup="true"
                                                                                aria-expanded="false"
                                                                                class="btn dropdown-toggle primary-text-color d-inline-flex align-items-center px-0">
                                                                            <svg xmlns="http://www.w3.org/2000/svg" width="24"
                                                                                 height="24" viewBox="0 0 24 24" fill="none"
                                                                                 stroke="currentColor" stroke-width="2"
                                                                                 stroke-linecap="round" stroke-linejoin="round"
                                                                                 class="feather feather-plus size-14 mr-2">
                                                                                <line x1="12" y1="5" x2="12" y2="19"></line>
                                                                                <line x1="5" y1="12" x2="19" y2="12"></line>
                                                                            </svg>
                                                                            Add new question
                                                                        </button>
                                                                        <div aria-labelledby="addQuestion" class="dropdown-menu"
                                                                             style=""><a href="#" disabled="disabled"
                                                                                         class="dropdown-item text-muted disabled">
                                                                                Choose question type
                                                                            </a> <a href="#" class="dropdown-item">
                                                                                Text
                                                                            </a><a href="#" class="dropdown-item">
                                                                                Textarea
                                                                            </a><a href="#" class="dropdown-item">
                                                                                Yes/No
                                                                            </a><a href="#" class="dropdown-item">
                                                                                Choose option
                                                                            </a><a href="#" class="dropdown-item">
                                                                                Multiple choice
                                                                            </a></div>
                                                                    </div>
                                                                    <!---->
                                                                </div>
                                                            </div>
                                                        @else--}}
                                                            <div class="rounded border mb-5">
                                                                <div class="bg-off-light d-flex align-items-center justify-content-between p-4">
                                                                    <div class="d-flex align-items-center">
                                                                        <div>
                                                                            <label class="custom-control d-inline border-switch mb-0 mr-3 @if($_jobFormEntity->slug == \App\JobFormEntity::BASIC_INFO_SLUG) disabled @endif" >
                                                                                <input type="checkbox" name="basicInformation_isVisible"
                                                                                       id="basicInformation_isVisible"
                                                                                       @if($_jobFormEntity->slug == \App\JobFormEntity::BASIC_INFO_SLUG) disabled @endif
                                                                                       @if($_jobFormEntity->status== 1) checked @endif
                                                                                       data-form-id="{{$_jobFormEntity->id}}"
                                                                                       class="border-switch-control-input update-form-status" value="{{($_jobFormEntity->status== 1)?true:false}}">
                                                                                <span class="border-switch-control-indicator"></span>
                                                                            </label>
                                                                        </div>
                                                                        <h6 class="mb-0">
                                                                            <label class="mb-0">
                                                                                {{__(ucwords(strtolower($_jobFormEntity->label)))}}
                                                                            </label>
                                                                        </h6>
                                                                    </div>
                                                                    @if($_jobFormEntity->is_deletable == true )
                                                                        <a href="javascript:void(0)" class="text-muted text-left default-base-color width-30 height-30 rounded d-inline-flex align-items-center justify-content-center float-right delete_record_model" data-url="{{ route('delete.form.section', encrypted_key($_jobFormEntity->id, 'encrypt')) }}" >
                                                                            <i class="far fa-trash-alt"></i>
                                                                        </a>
                                                                    @endif
                                                                </div>

                                                                <div class="p-4" style="{{($_jobFormEntity->status == 1)?'display:block' :'display:none'}}">
                                                                    <div
                                                                        class="d-flex align-items-center justify-content-between mb-2">
                                                                        <div class="d-inline-flex align-items-center">
                                                                            <div class="width-30 height-30 text-white rounded d-inline-flex align-items-center justify-content-center bg-primary mr-2">
                                                                               <p class="form-icon">{!! $_jobFormEntity->icon !!}</p>
                                                                            </div>
                                                                            <p class="text-muted mb-0 mr-3">
                                                                                {!! $_jobFormEntity->getAllFieldsLabel($jobpost_id) !!}
                                                                            </p>
                                                                        </div>
                                                                        {!! $_jobFormEntity->getAction($jobpost_id) !!}
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        {{--@endif--}}
                                                    @endforeach
                                                @endif
                                                    <button type="button" class="btn text-primary px-0 add-more-section">
                                                        <i class="fa fa-plus" aria-hidden="true"></i>&nbsp;
                                                        Add more section
                                                    </button>
                                                <div class="rounded border mb-5 add-section-form" style="display: none">
                                                    <div class="bg-off-light d-flex align-items-center p-4">
                                                        <div>
                                                            <input type="text" name="newFormSection" id="newFormSection" placeholder="Enter section name" class="form-control">
                                                        </div>
                                                        <button type="button" class="btn btn-primary ml-2 add-form-section" data-jobpost-id="{{ ($jobpost_id!="") ? $jobpost_id:'' }}">
                                                            add
                                                        </button>
                                                        <button type="button" class="btn btn-secondary ml-2 cancel-addmore">
                                                            Cancel
                                                        </button>
                                                    </div>
                                                </div>

                                            </div>
                                        </div>
                                        <!-- Change email_setup Tab -->
                                        <div id="hiring_stage" class="tab-pane fade">
                                            <div class="card">
                                                <div class="card-body">
                                                    <div>
                                                        <h3 class="float-left">Hiring Stage</h3>
                                                        <a href="#" class="btn btn-sm btn btn-primary float-right "
                                                           data-url="{{ route('addhiringstage') }}"
                                                           data-ajax-popup="true" data-size="lg"
                                                           data-title="{{__('Add addhiringstage')}}">
                                                            <span class="btn-inner--icon">Add Hiring Stage</span>
                                                        </a>
                                                    </div>
                                                </div>
                                                <hr width="100%">
                                                <table class="table table-hover table-center mb-0 table-100"
                                                       id="yajra-datatable">
                                                    <thead class="thead-light ">
                                                    <tr>
                                                        <th>Name</th>
                                                        <th>Status</th>
                                                        <th>Action</th>
                                                    </tr>
                                                    </thead>
                                                </table>
                                            </div>
                                        </div>
                                        {{-- change addEvent notification Tab --}}
                                        <div id="event_type" class="tab-pane fade">
                                            <div class="card">
                                                <div class="card-body">
                                                    <div>
                                                        <h3 class="float-left">Add Event</h3>
                                                        <a href="#" class="btn btn-sm btn btn-primary float-right "
                                                           data-url="{{ route('addevent.create') }}"
                                                           data-ajax-popup="true" data-size="lg"
                                                           data-title="{{__('Add addEvent')}}">
                                                            <span class="btn-inner--icon">Add Event</span>
                                                        </a>
                                                    </div>
                                                </div>
                                                <hr width="100%">
                                                <table class="table table-hover table-center mb-0 table-100"
                                                       id="yajra-datatables">
                                                    <thead class="thead-light ">
                                                    <tr>
                                                        <th>Name</th>
                                                        <th>Status</th>
                                                        <th>Action</th>
                                                    </tr>
                                                    </thead>
                                                </table>
                                            </div>
                                        </div>
                                        {{-- change Job Type Tab --}}
                                        <div id="job_type" class="tab-pane fade">
                                            <div class="card">
                                                <div class="card-body">
                                                    <div>
                                                        <h3 class="float-left">Job Type</h3>
                                                        <a href="#" class="btn btn-sm btn btn-primary float-right "
                                                           data-url="{{ route('jobtype.create') }}"
                                                           data-ajax-popup="true" data-size="lg"
                                                           data-title="{{__('Add jobType')}}">
                                                            <span class="btn-inner--icon"> Add Job Type </span>
                                                        </a>
                                                    </div>
                                                </div>
                                                <hr width="100%">
                                                <table class="table table-hover table-center mb-0 table-100"
                                                       id="JobTypeList">
                                                    <thead class="thead-light ">
                                                    <tr>
                                                        <th>Name</th>
                                                        <th>Description</th>
                                                        <th>Action</th>
                                                    </tr>
                                                    </thead>
                                                </table>
                                            </div>
                                        </div>
                                        {{-- change Department notification Tab --}}
                                        <div id="department" class="tab-pane fade">
                                            <div class="card">
                                                <div class="card-body">
                                                    <div>
                                                        <h3 class="float-left">Department</h3>
                                                        <a href="#" class="btn btn-sm btn btn-primary float-right "
                                                           data-url="{{ route('department.create') }}"
                                                           data-ajax-popup="true" data-size="lg"
                                                           data-title="{{__('Add Department')}}">
                                                            <span class="btn-inner--icon"> Add department</span>
                                                        </a>
                                                    </div>
                                                </div>
                                                <hr width="100%">
                                                <table class="table table-hover table-center mb-0 table-100"
                                                       id="departmentList">
                                                    <thead class="thead-light ">
                                                    <tr>
                                                        <th>Name</th>
                                                        <th>Status</th>
                                                        <th>Action</th>
                                                    </tr>
                                                    </thead>
                                                </table>
                                            </div>
                                        </div>
                                        {{-- change Location notification Tab --}}
                                        <div id="location" class="tab-pane fade">
                                            <div class="card">
                                                <div class="card-body">
                                                    <div>
                                                        <h3 class="float-left">Location</h3>
                                                        <a href="#" class="btn btn-sm btn btn-primary float-right "
                                                           data-url="{{ route('location.create') }}"
                                                           data-ajax-popup="true" data-size="lg"
                                                           data-title="{{__('Add Location')}}">
                                                            <span class="btn-inner--icon"> Add location</span>
                                                        </a>
                                                    </div>
                                                </div>
                                                <hr width="100%">
                                                <table class="table table-hover table-center mb-0 table-100"
                                                       id="locationList">
                                                    <thead class="thead-light ">
                                                    <tr>
                                                        <th>Address</th>
                                                        <th>Action</th>
                                                    </tr>
                                                    </thead>
                                                </table>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
{{--form field setting model--}}
@include('jobpoint.jobform.field_setting_modal')
{{--/form field setting model--}}

{{--basic info modal--}}
@include('jobpoint.jobform.edit_custom_field_modal')
{{--/basic info modal--}}
@push('script')
    <script type="text/javascript">
        $(function () {
            var table = $('#yajra-datatable').DataTable({
                processing: true,
                serverSide: true,
                ajax: "{{ route('job.setting') }}",
                columns: [
                    //{data: 'DT_RowIndex', name: 'DT_RowIndex'},
                    {data: 'name', name: 'name', orderable: true, searchable: true},
                    {data: 'status', name: 'status', orderable: true},
                    {
                        data: 'action',
                        name: 'action',
                        orderable: false,
                        searchable: false
                    },
                ]
            });
        });
        $(function () {
            var table = $('#yajra-datatables').DataTable({
                processing: true,
                serverSide: true,
                ajax: "{{ route('event.list') }}",
                columns: [
                    //{data: 'DT_RowIndex', name: 'DT_RowIndex'},
                    {data: 'name', name: 'name', orderable: true, searchable: true},
                    {data: 'status', name: 'status', orderable: true},
                    {
                        data: 'action',
                        name: 'action',
                        orderable: false,
                        searchable: false
                    },
                ]
            });
        });
        $(function () {
            var table = $('#JobTypeList').DataTable({
                processing: true,
                serverSide: true,
                ajax: "{{ route('jobtype.list') }}",
                columns: [
                    //{data: 'DT_RowIndex', name: 'DT_RowIndex'},
                    {data: 'name', name: 'name', orderable: true, searchable: true},
                    {data: 'description', name: 'description', orderable: true},
                    {
                        data: 'action',
                        name: 'action',
                        orderable: false,
                        searchable: false
                    },
                ]
            });
        });
        $(function () {
            var table = $('#departmentList').DataTable({
                processing: true,
                serverSide: true,
                ajax: "{{ route('department.list') }}",
                columns: [
                    //{data: 'DT_RowIndex', name: 'DT_RowIndex'},
                    {data: 'name', name: 'name', orderable: true, searchable: true},
                    {data: 'status', name: 'status', orderable: true},
                    {
                        data: 'action',
                        name: 'action',
                        orderable: false,
                        searchable: false
                    },
                ]
            });
        });
        $(function () {
            var table = $('#locationList').DataTable({
                processing: true,
                serverSide: true,
                ajax: "{{ route('location.list') }}",
                columns: [
                    //{data: 'DT_RowIndex', name: 'DT_RowIndex'},
                    {data: 'address', name: 'address', orderable: true, searchable: true},

                    {
                        data: 'action',
                        name: 'action',
                        orderable: false,
                        searchable: false
                    },
                ]
            });
        });
    </script>
    <script type="text/javascript">
        /*Open Basic info modal open*/
        $(document).on("click", ".action-edit-button", function () {
            var job_form_id = $(this).attr('data-id');
            var jobpost_id = $(this).attr('data-job-id');
            $.ajax({
                type: "GET",
                url: '{{route("job.jobformsetting")}}',
                data:{
                    "_token" : '{{ csrf_token() }}',
                    "id" : job_form_id,
                    "job_id" : jobpost_id,
                },
                success:function (response) {
                    if(response.success==true){
                        $('#form-field-setting-modal').find('.field-modal-body').html(response.html);
                        $('#form-field-setting-modal').find('.modal-title').html(response.title);
                        $('#form-field-setting-modal').modal('show');
                    }
                },
                error:function (error) {
                    show_toastr('Error', error, 'error');
                }
            });
        });

        /* Open Form Modal to Edit Existing Field */
        $(document).on("click", ".edit-form-field", function () {
            var form_field_id = $(this).attr('data-field-id');
            var parent_id = $(this).attr('data-parent-id');
            var job_id = $(this).attr('data-job-id');
            $.ajax({
                type: "GET",
                url: '{{route("field.edit.form")}}',
                data:{
                    "_token" : '{{ csrf_token() }}',
                    "parent_id" : parent_id,
                    "id" : form_field_id,
                    "job_id" : job_id
                },
                success:function (response) {
                    if(response.success==true){
                        $('#custom-field-modal').find('.custom-field-modal-body').html(response.html);
                        $('#custom-field-modal .modal-title').html(response.title);
                        $('#custom-field-modal .save-btn').html(response.button);
                        $('#custom-field-modal').modal('show');
                    }
                },
                error:function (error) {
                    show_toastr('Error', error, 'error');
                }
            });
        });

        /* Open Form Modal to Add More Custom Field */
        $(document).on("click", ".add-more-fields", function () {
            var parent_id = $(this).attr('data-parent-id');
            var job_id = $(this).attr('data-job-id');
            if(job_id != ""){
                var data  = {
                    _token : '{{ csrf_token() }}',
                    parent_id : parent_id,
                    job_id : job_id,
                    id : "",
                }
            }else{
                var data  = {
                    _token : '{{ csrf_token() }}',
                    parent_id : parent_id,
                    id : "",
                }
            }
            $.ajax({
                type: "GET",
                url: '{{route("field.edit.form")}}',
                data : data,
                success:function (response) {
                    if(response.success==true){
                        $('#custom-field-modal').find('.custom-field-modal-body').html(response.html);
                        $('#custom-field-modal .modal-title').html(response.title);
                        $('#custom-field-modal .save-custom-field').html(response.button);
                        $('#custom-field-modal').modal('show');
                    }
                },
                error:function (error) {
                    show_toastr('Error', error, 'error');
                }
            });
        });

        /* Save Custom Field */
        $(document).on("click", ".save-custom-field", function () {
            var data = $('form#field-data').serialize();
            var label = $('#label').val();
            var type = $('#type').val();
            var form_id = $('#form_id').val();
            var field_id = $('#field_id').val();
            if(label==""){
                $("#label-error").html("This is required field");
                return false;
            }else{
                $("#label-error").html("");
            }
            if(type==""){
                $("#type-error").html("This is required field");
                return false;
            }else{
                $("#type-error").html("");
            }
            if(type == 'radio' || type == 'checkbox' || type == "select"){
                var option = $("input[name='option_values[]']")
                    // .map(function(){return $(this).val();}).get();
                if(option.length == 0){
                    show_toastr('Error :', 'Option should not be empty!', 'error');
                    return false;
                }
            }
            $.ajax({
                type: "GET",
                url: '{{route("save.custom.field")}}',
                data: data,
                success:function (response) {
                    if(response.success==true){
                        $('#custom-field-modal').modal('hide');
                        $('#form-field-setting-modal').modal('hide');
                        show_toastr('Success :', response.message, 'success');
                        location.reload();
                    }
                },
                error:function (error) {
                    show_toastr('Error', error, 'error');
                }
            });
        });

        /* Update Custom Field status and Required */
        $(document).on("click", ".update-field", function () {
            var id = $(this).attr('data-field-id');
            var event = $(this).attr('data-type');
            if(event == 'status'){
                if($(this).prop("checked") == true){
                    $(this).val(1);
                    var status = $(this).val();
                }else{
                    $(this).val(0);
                    var status = $(this).val();
                }
            }else{
                if($(this).prop("checked") == true){
                    $(this).val(1);
                    $(this).next().html("True");
                    var required = $(this).val();
                }else{
                    $(this).val(0);
                    $(this).next().html("False");
                    var required = $(this).val();
                }
            }
            $.ajax({
                type: "GET",
                url: '{{route("update.form.field")}}',
                data: {
                    "_token" : '{{ csrf_token() }}',
                    "field_id" :id,
                    "status" : status,
                    "is_required" : required,
                },
                success:function (response) {
                    if(response.success==true){
                        show_toastr('Success :', response.message, 'success');
                    }
                },
                error:function (error) {
                    show_toastr('Error', error, 'error');
                }
            });

        } );

        /* Delete Custom Field */
        {{--$(document).on("click", ".delete-form-field", function () {--}}
        {{--    var id = $(this).attr('data-field-id');--}}

        {{--    $.ajax({--}}
        {{--        type : 'GET',--}}
        {{--        url : '{{route('delete.form.field')}}',--}}
        {{--        data : {--}}
        {{--            '_token' : '{{ @csrf_token() }}',--}}
        {{--            'id' : id,--}}
        {{--        },--}}
        {{--        success:function (response) {--}}
        {{--            if(response.success==true){--}}
        {{--                $('#form-field-setting-modal').modal('hide');--}}
        {{--                setTimeout(function () {--}}
        {{--                    location.reload();--}}
        {{--                }, 2000)--}}

        {{--                show_toastr('Success :', response.message, 'success');--}}
        {{--            }--}}
        {{--        },--}}
        {{--        error:function (error) {--}}
        {{--            show_toastr('Error', error, 'error');--}}
        {{--        }--}}
        {{--    });--}}
        {{--});--}}

        /* Change Form Entity Status */
        $(document).on("click", ".update-form-status", function () {
            var id = $(this).attr('data-form-id');
            if($(this).prop("checked") == true) {
                $(this).val(1);
                $(this).parent().parent().parent().parent().next().toggle();
                var formStatus = $(this).val();

            }
            else if($(this).prop("checked") == false) {
                $(this).val(0);
                $(this).parent().parent().parent().parent().next().toggle();
                var formStatus = $(this).val();

            }
            $.ajax({
                type : 'GET',
                url : '{{route('update.form.status')}}',
                data : {
                    '_token' : '{{ @csrf_token() }}',
                    'id' : id,
                    'status' : formStatus
                },
                success:function (response) {
                    if(response.success==true){
                        show_toastr('Success :', response.message, 'success');
                    }
                },
                error:function (error) {
                    show_toastr('Error', error, 'error');
                }
            });
        });

        $(document).on("click", ".add-more-section", function () {
            $('.add-more-section').attr("style", "display: none !important");
            $('.add-section-form').show();
        });
        $(document).on("click", ".cancel-addmore", function () {
            $('.add-more-section').show();
            $('.add-section-form').hide();
        });

        /* Add Custom Form Section */
        $(document).on("click", ".add-form-section", function () {
            var jobpost_id = $(this).attr('data-jobpost-id');
            var label = $('#newFormSection').val();
            var string = label.toLowerCase();
            var slug = string.replace(/ /g,"_");
            var icon = '<i class="fas fa-pencil-alt"></i>';
            if(jobpost_id != ""){
                var data = {
                    _token : '{{ @csrf_token() }}',
                    label : label,
                    slug : slug,
                    icon : icon,
                    job_id : jobpost_id,
                }
            }else{
                var data = {
                    _token : '{{ @csrf_token() }}',
                    label : label,
                    slug : slug,
                    icon : icon
                }
            }
            $.ajax({
                type : 'GET',
                url : '{{route('add.form.section')}}',
                data : data,
                {{--data : {--}}
                {{--    '_token' : '{{ @csrf_token() }}',--}}
                {{--    'label' : label,--}}
                {{--    'slug' : slug,--}}
                {{--    'icon' : icon,--}}
                {{--    'job_id' : jobpost_id,--}}
                {{--},--}}
                success:function (response) {
                    if(response.success==true){
                        location.reload();
                        show_toastr('Success :', response.message, 'success');
                    }
                },
                error:function (error) {
                    show_toastr('Error', error, 'error');
                }
            });
        });

        /* Delete Custom Form Section */

        $(document).on("click", ".delete_record_model", function(){
            $("#common_delete_form").attr('action',$(this).attr('data-url'));
            $('#common_delete_model').modal('show');
        });
        {{--$(document).on("click", ".delete-form-section", function () {--}}
        {{--    var id = $(this).attr('data-form-id');--}}
        {{--    $.ajax({--}}
        {{--        type : 'GET',--}}
        {{--        url : '{{route('delete.form.section')}}',--}}
        {{--        data : {--}}
        {{--            '_token' : '{{ @csrf_token() }}',--}}
        {{--            'id' : id--}}
        {{--        },--}}
        {{--        success:function (response) {--}}
        {{--            if(response.success==true){--}}
        {{--                location.reload();--}}
        {{--                show_toastr('Success :', response.message, 'success');--}}
        {{--            }--}}
        {{--        },--}}
        {{--        error:function (error) {--}}
        {{--            show_toastr('Error', error, 'error');--}}
        {{--        }--}}
        {{--    });--}}
        {{--});--}}




        /* Save Cutom Field Options Values*/
        $(document).on("change", "#type", function () {
            var selectedVal = $(this).val()
            if(selectedVal == 'radio' || selectedVal == 'checkbox' || selectedVal == 'select'){
                $('#custom-option').show();
                $(".option-list").show();
            }else{
                $('#custom-option').hide();
                $(".option-list").hide();
            }
        });

        /* Add custom Options Input */
        $(document).on("click", ".add-option", function(){
            var inputVal = $('#option').val();
            if(inputVal==""){
                show_toastr('Error :', 'Option should not be empty!', 'error');
                return false;
            }
            var html = '<div class="default-base-color rounded d-flex align-items-center justify-content-between px-3 py-2 mb-1">' +
                        '<input name="option_values[]" type="hidden" value="'+inputVal+'">' +
                        '<span>'+inputVal+'</span> ' +
                        '<button type="button" class="btn padding-5 delete-option-list"><i class="far fa-trash-alt"></i></button></div>';
            $('.option-list').append(html);
            $('#option').val('');
        });

        /* Delete custom options input */
        $(document).on("click", ".delete-option-list", function () {
            $(this).parent().remove();
        });

    </script>
@endpush
