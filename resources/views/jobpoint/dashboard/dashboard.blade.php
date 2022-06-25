@php
/**
 *@var \App\Job[] $job
 *@var \App\Job $jobModel
 * @var string $jobStatus
 * @var string $search
 * @var string $toDoHtml
 * @var \App\CandidateEvent[] $candidateEvent
 * @var \App\CandidateEvent $_event
 */
@endphp
<?php $page = 'partner'; ?>
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
                    </div>
                    <!-- Breadcrumb -->
                    <div class="breadcrumb-bar mt-3">
                        <div class="container-fluid">
                            <div class="row align-items-center">
                                <div class="col-md-12 col-12">
                                    <h2 class="breadcrumb-title">Dashboard</h2>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-sm-8 pr-4">
                                    <div class="row">
                                        <div class="col-sm-6">
                                            <h4 class="float-left">Dashboard</h4>
                                        </div>
                                        <div class="col-sm-6">
                                            <a href="#" class="btn btn-sm btn btn-primary float-right "
                                               data-url="{{ route('jobpoint.create') }}" data-ajax-popup="true"
                                               data-size="lg" data-title="{{__('Create New Job')}}">
                                                <span class="btn-inner--icon">Create New Job</span>
                                            </a>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <div class="row mt-3">
                                            <div class="col-md-6">
                                                {{ Form::select('jobStatusType', $jobModel->getJobStauts(), $jobStatus, ["class" => "form-control rounded-pill statusType"]) }}
                                            </div>
                                            <div class="col-md-6">
                                                <form method="GET" action="{{ url()->current() }}">
                                                    <div class="input-group">
                                                        <input class="form-control rounded-pill searchInput" type="text" value="{{$search}}" placeholder="search" name="search" required>
                                                        <input type="hidden" name="type" value="{{ $jobStatus }}">
                                                        <i class="fas fa-times cancelSearch mt-3 mr-1 ml-1" type="button"></i>
                                                        <button class="btn p-0" type="submit"><i class="fa fa-search"></i></button>
                                                    </div>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                    @foreach($job as $_job)
                                        <div class="row ml-2">
                                            <div class="col-12 shadow p-3 mt-3  bg-white rounded">
                                                <h4>{{ $_job->job_title }}</h4>
                                                <div class='row'>
                                                    <div class="col-sm-6">
                                                        <p class="text-secondary"><i class="far fa-calendar-alt"></i>
                                                            Last Submission Date: {{ jobDateFormat($_job->last_submission)  }}</p>
                                                    </div>
                                                    <div class="col-sm-6 ActionMenu">
                                                        <div class="dropdown options-dropdown">
                                                            <button type="button" data-toggle="dropdown"
                                                                    class="btn-option btn d-flex align-items-center justify-content-center">
                                                                <svg xmlns="http://www.w3.org/2000/svg" width="20"
                                                                     height="20" viewBox="0 0 24 24" fill="none"
                                                                     stroke="currentColor" stroke-width="2"
                                                                     stroke-linecap="round" stroke-linejoin="round"
                                                                     class="feather feather-more-vertical">
                                                                    <circle cx="12" cy="12" r="1"></circle>
                                                                    <circle cx="12" cy="5" r="1"></circle>
                                                                    <circle cx="12" cy="19" r="1"></circle>
                                                                </svg>
                                                            </button>
                                                            <div class="dropdown-menu dropdown-menu-right py-2 mt-1">
                                                                @foreach ($_job->getOptionByJobStatus($jobStatus) as $option)
                                                                    <a href="{{ $option["href"] }}"
                                                                       class="{{ $option["class"] }}" {{ $_job->getCustomAttribute($option["attribute"]) }} >
                                                                        <span>{{ $option["label"] }}</span>
                                                                    </a>
                                                                @endforeach
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <p class="text-secondary">
                                                    <i class="fas fa-clock"></i> {{ $_job->job_name }}
                                                    <i class="fas fa-map-marker-alt ml-2"></i> {{ $_job->location_address }}
                                                    <i class="fas fa-building ml-2"></i> {{ $_job->department_name }}
                                                    <i class="fas fa-dollar-sign ml-2"> {{jobPriceFormat($_job->salary)}}</i>
                                                </p>
                                                <hr width="100%">
                                                <div class="d-flex overflow-auto custom-scrollbar">
                                                    @foreach($_job->getJobStageStatus() as $stage)
                                                        <div class="bg-light mb-3 mr-3 p-2 col-sm-2 text-center">
                                                            <p class="text-size-15 default-font-color mb-0">{{$stage["label"]}}</p>
                                                            <p class="text-size-13 text-muted mb-0 text-capitalize font-size-12">{{$stage["count"]}}</p>
                                                        </div>
                                                    @endforeach
                                                </div>
                                                <a class="label overview_btn mt-3" href="{{ route('jobpost.overview', ['id' => encrypted_key($_job->id, 'encrypt'),'tab' => 'overview']) }}">
                                                    <button type="button" class="btn btn-sm btn-outline-primary">{{__("Overview")}}</button>
                                                </a>
                                            </div>
                                        </div>
                                    @endforeach
                                    @if($job->count()==0)
                                        <div class="shadow p-3 mt-3  bg-white text-danger">
                                            <span>{{__("No Record Found")}}</span>
                                        </div>
                                    @endif
                                </div>
                                <div class="col-sm-4 pl-4">
                                    <div class="row">
                                        <div class="col-sm-6">
                                            <span>{{__("Your Events")}}</span>
                                        </div>
                                        <div class="col-sm-6">
                                            <a href="{{ route('admin.jobpoint.allevent') }}" class="float-right">
                                                <button type="button" class="btn btn-primary btn-sm">{{__("View All")}}</button>
                                            </a>
                                        </div>
                                    </div>
                                    @foreach($candidateEvent as $_event)
                                        <div class="row shadow p-1 mt-1  bg-white show_candidate_details" data-id="{{$_event->id}}">
                                            <div class="col-sm-4 text-center border-right p-1">
                                                <div class="month bg-primary text-white">{{$_event->getEventDateFormat("M", $_event->event_start_datetime)}}</div>
                                                <div class="date-day bg-light">
                                                    <h4 class="text-size-16 mb-0 pt-2">{{$_event->getEventDateFormat("d", $_event->event_start_datetime)}}</h4>
                                                    <small class="text-muted10 pb-2">
                                                        {{$_event->getEventDateFormat("l", $_event->event_start_datetime)}}
                                                    </small>
                                                </div>
                                            </div>
                                            <div class="col-sm-8">
                                                <div class="event-details">
                                                    <p class="mb-0">{{$_event->getEventLabel($_event->event_type)}}</p>
                                                    <div class="d-flex align-items-center">
                                                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                                             viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                                             stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                                                             class="feather feather-user size-13 text-muted mr-2">
                                                            <path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"></path>
                                                            <circle cx="12" cy="7" r="4"></circle>
                                                        </svg>
                                                        <p class="mb-0 text-size-12 text-muted ">{{$_event->getCandidateName($_event->candidate_id)}}</p>
                                                    </div>
                                                    <div class="d-flex align-items-center mb-2">
                                                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                                             viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                                             stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                                                             class="feather feather-clock size-13 text-muted mr-2">
                                                            <circle cx="12" cy="12" r="10"></circle>
                                                            <polyline points="12 6 12 12 16 14"></polyline>
                                                        </svg>
                                                        <span class="text-size-12 text-muted">{{jobDateFormat($_event->event_start_datetime, true)}} - {{jobDateFormat($_event->event_end_datetime, true)}}</span>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach
                                    @if($candidateEvent->count()==0)
                                        <h4 class="text-center border border-info mt-4">{{__("No Events found")}}</h4>
                                    @endif
                                    <h5 class="mt-3">{{__("Your To-Dos")}}</h5>
                                    <div class="row todo-wrapper shadow p-3 mt-3 bg-white">
                                        <div class="col-12 todo p-0">
                                            <div class="todo-add">
                                                <div class="input-group mb-2">
                                                    <input class="form-control py-2 mr-1 pr-5 todo_content" type="text" placeholder="Add a to-do">
                                                    <span class="input-group-append">
                                                        <button class="btn rounded-pill border-0 ml-n5 addToDo" type="button">
                                                            <i class="fa fa-plus" aria-hidden="true"></i>
                                                        </button>
                                                    </span>
                                                </div>
                                                <hr width="100%">
                                            </div>
                                            <div class="todo-items">
                                                {!! $toDoHtml !!}
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
        <div class="d-flex justify-content-center">
            {{ $job->links() }}
        </div>
    </div>
@endsection
<!-- Candidate EventDetails Modal-->
<div data-backdrop="true" data-keyboard="true" id="event-view-modal" tabindex="-1" role="dialog" class="modal fade custom-scrollbar show" style=" display:none;" aria-modal="true">
    <div role="document" class="modal-dialog modal-dialog-top modal-default modal-dialog-scrollable popup_mt_lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title text-capitalize"></h5>
                <button type="button" data-dismiss="modal" aria-label="Close" class="close outline-none">
                <span>
                   <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-x">
                      <line x1="18" y1="6" x2="6" y2="18"></line>
                      <line x1="6" y1="6" x2="18" y2="18"></line>
                   </svg>
                </span>
                </button>
            </div>
            <div class="modal-body custom-scrollbar event-detail">

            </div>
            <div class="modal-footer">
                <div class="">
                    <button type="button" data-dismiss="modal" class="btn btn-secondary mr-2">
                        Close
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>
<!--  /Candidate EventDetails Modal -->
@push('script')
    <script type="text/javascript">
        $(document).ready(function () {
            $('.cancelSearch').click(function(){
                var inputValue = $('.searchInput').val();
                if(inputValue!=""){
                    var url ="{{ route('jobpoint.dashboard') }}";
                    window.location.href = url;
                }
            });
            $('.statusType').on('change', function () {
                var getValue = this.value;
                var url = "{{ route('jobpoint.dashboard') }}";
                window.location.href = url + '?type=' + getValue;
            });
            $(document).on("click", '.JobStatusAction', function () {
                var id = $(this).data('id');
                $.ajax({
                    url: "{{ route('admin.jobpoint.update') }}",
                    type: "POST",
                    data: {
                        "id": id,
                        "_token": "{{ csrf_token() }}",
                        "data": {
                            'job_status': '{{ $jobModel::JOB_STATUS_ACTIVE }}',
                        },
                    },
                    showLoader: true,
                    success: function (response) {
                        if(response.success==true){
                            show_toastr("Success", response.message, "success")
                        }
                        else{
                            show_toastr("Error", response.message, "error")
                        }
                        window.location.reload();
                    }
                });
            });
            $(document).on("click", '.Deactivate', function () {
                var id = $(this).data('id');
                $.ajax({
                    url: "{{ route('admin.jobpoint.update') }}",
                    type: "POST",
                    data: {
                        "id": id,
                        "_token": "{{ csrf_token() }}",
                        "data": {
                            'job_status': '{{ $jobModel::JOB_STATUS_INACTIVE }}',
                        },
                    },
                    showLoader: true,
                    success: function (response) {
                        if(response.success==true){
                            show_toastr("Success", response.message, "success")
                        }
                        else{
                            show_toastr("Error", response.message, "error")
                        }
                        window.location.reload();
                    }
                });
            });
            $(document).on("click", '.addToDo', function () {
                let todoContent = $(".todo_content").val();
                if(todoContent!=""){
                    $.ajax({
                        url: "{{ route('admin.todo.type') }}",
                        type: "POST",
                        data: {
                            "_token": "{{ csrf_token() }}",
                            "type": "save",
                            "to_do_data": {
                                'name': todoContent,
                            },
                        },
                        showLoader: true,
                        success: function (response) {
                            if(response.success==true){
                                $(".todo_content").val("");
                                show_toastr("Success", response.message, "success");
                                if(response.to_do_html!=""){
                                    $(".todo-items").html(response.to_do_html);
                                }
                            }
                            else{
                                show_toastr("Error", response.message, "error");
                            }
                        }
                    });
                }
            });
            $(document).on("click", '.todo_delete', function () {
                var toDoId = $(this).data("id");
                if(toDoId!=""){
                    $.ajax({
                        url: "{{ route('admin.todo.type') }}",
                        type: "POST",
                        data: {
                            "_token": "{{ csrf_token() }}",
                            "type": "delete",
                            "id": toDoId,
                        },
                        showLoader: true,
                        success: function (response) {
                            if(response.success==true){
                                $(".todo_content").val("");
                                show_toastr("Success", response.message, "success");
                                if(response.to_do_html!=""){
                                    $(".todo-items").html(response.to_do_html);
                                }
                            }
                            else{
                                show_toastr("Error", response.message, "error");
                            }
                        }
                    });
                }
            });
            $(document).on("click", '.clear_todo', function () {
                $.ajax({
                    url: "{{ route('admin.todo.type') }}",
                    type: "POST",
                    data: {
                        "_token": "{{ csrf_token() }}",
                        "type": "clear",
                    },
                    showLoader: true,
                    success: function (response) {
                        if(response.success==true){
                            $(".todo_content").val("");
                            show_toastr("Success", response.message, "success");
                            if(response.to_do_html!=""){
                                $(".todo-items").html(response.to_do_html);
                            }
                        }
                        else{
                            show_toastr("Error", response.message, "error");
                        }
                    }
                });
            });
            $(document).on("click", '.show_completed', function () {
                $(".complete_todo_wraper").toggle();
            });

            $(document).on("change", '.pending_todo_wraper input:checkbox', function () {
                if(this.checked){
                    $.ajax({
                        url: "{{ route('admin.todo.type') }}",
                        type: "POST",
                        data: {
                            "_token": "{{ csrf_token() }}",
                            "type": "completed",
                            "id": this.value
                        },
                        showLoader: true,
                        success: function (response) {
                            if(response.success==true){
                                show_toastr("Success", response.message, "success");
                                if(response.to_do_html!=""){
                                    $(".todo-items").html(response.to_do_html);
                                }
                            }
                            else{
                                show_toastr("Error", response.message, "error");
                            }
                        }
                    });
                }
            });
            $(document).on("change", '.complete_todo_wraper input:checkbox', function () {
                if(!this.checked){
                    $.ajax({
                        url: "{{ route('admin.todo.type') }}",
                        type: "POST",
                        data: {
                            "_token": "{{ csrf_token() }}",
                            "type": "pending",
                            "id": this.value
                        },
                        showLoader: true,
                        success: function (response) {
                            if(response.success==true){
                                show_toastr("Success", response.message, "success");
                                if(response.to_do_html!=""){
                                    $(".todo-items").html(response.to_do_html);
                                }
                            }
                            else{
                                show_toastr("Error", response.message, "error");
                            }
                        }
                    });
                }
            });
        });
        $(document).on("click", '.show_candidate_details', function () {
            var event_id = $(this).attr('data-id');
            $.ajax({
                type:"GET",
                url:'{{route("candidate.view.events")}}',
                data:{
                    "_token": "{{ csrf_token() }}",
                    "id": event_id
                },
                success:function(response){
                    if(response.success==true){
                        $("#event-view-modal .modal-title").html(response.title);
                        $('#event-view-modal').find('.modal-body').html(response.html);
                        $('#event-view-modal').modal('show');
                    }
                    else{
                        show_toastr('Error: ', response.message, 'error');
                    }
                },
                error:function(error){
                    show_toastr('Error: ', error, 'error');
                }
            });
        });
    </script>
@endpush
