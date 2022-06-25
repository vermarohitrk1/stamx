@php
    /**
     * @var App\Candidate[] $candidate
     * @var App\Candidate $_candidate
    */
@endphp

<style type="text/css">
    .rated.list .star.active, .rating.list .star.active {color: #fc6510;}
    .horizontal-tab .card .nav a.active {color: #4466f2; border-bottom: 3px solid #4466f2;}
    .horizontal-tab .card .nav a:hover {color: #4466f2;}
    .tab-content>.active {display: block;}
    .tab-content>.tab-pane {display: none;}
</style>
<?php $page = 'candidate'; ?>
@extends('layout.dashboardlayout')
@section('content')
    <div class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-5 col-lg-4 col-xl-3 theiaStickySidebar">
                    <!-- Sidebar -->
                @include('layout.partials.userSideMenu')
                <!-- /Sidebar -->
                </div>
                <div class="col-md-7 col-lg-8 col-xl-9">
                    <!-- Breadcrumb -->
                    <div class="breadcrumb-bar mt-3">
                        <div class="container-fluid">
                            <div class="row align-items-center">
                                <div class="col-md-12 col-12">
                                    <h2 class="breadcrumb-title">{{__("Candidates")}}</h2>
                                    <nav aria-label="breadcrumb" class="page-breadcrumb">
                                        <ol class="breadcrumb">
                                            <li class="breadcrumb-item"><a href="{{ route('page') }}">{{__("Home")}}</a></li>
                                            <li class="breadcrumb-item active" aria-current="page">{{__("Candidates")}}</li>
                                        </ol>
                                    </nav>
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
                                    <a class="btn btn-sm btn-primary .btn-rounded float-right mb-4" href="#" data-url="{{route('candidate.form')}}" data-ajax-popup="true" data-size="md" data-title="{{__('Add Candidate')}}">
                                        <i class="fas fa-plus"></i>
                                        {{__("Add Candidate")}}
                                    </a>
                                    <div class="">
                                        <div class="card-body">
                                            <button class="btn btn-primary" type="button" data-toggle="collapse" data-target="#filter" aria-expanded="false" aria-controls="filter">
                                            <p class="text-white"><i class="fa fa-filter" aria-hidden="true"></i> Filter</p>
                                            </button>
                                            <div class="p-3 mt-2 border collapse" id="filter">
                                                <form action="{{ route('admin.candidates') }}" method="GET" class="form-inline">
                                                    <div class="row mt-4">
                                                        <div class="col-sm-3">
                                                            <div class="form-group inline-form">
                                                                {{ Form::label('applied_date', 'Applied date', ['class'=>'text-center']) }}
                                                                {{ Form::Text('applied_date', '', ['class'=>'form-control', 'id'=>"applied_date"]) }}
                                                            </div>
                                                        </div>
                                                        <div class="col-sm-3">
                                                            <div class="form-group">
                                                                {{ Form::label('jobpost', 'Job') }}
                                                                {{ Form::Select('jobpost', $candidateModel->getAllJobs(), '', ['class'=>'form-control', 'id'=>'jobpost']) }}
                                                            </div>
                                                        </div>
                                                        <div class="col-sm-3">
                                                            <div class="form-group">
                                                                    <label for="current_stage">Current Stage</label>
                                                                    <select name="current_stage" class="form-control" id="current_stage" style="width: -webkit-fill-available;">
                                                                        <option value="">Select One</option>
                                                                        @foreach($candidateModel->getStageOptions() as $key => $currentStage)
                                                                            <option value="{{ $key }}">{{ $currentStage }}</option>
                                                                        @endforeach
                                                                    </select>
                                                            </div>
                                                        </div>
                                                        <div class="col-sm-3">
                                                            <div class="form-group">
                                                                {{ Form::label('gender', 'Gender') }}
                                                                {{ Form::Select('gender', [''=>'Select Gender', 'male'=>'Male', 'female'=>"Female", "other"=>"Other"], '', ['class'=>'form-control', 'id'=>'gender', 'style'=>'width: -webkit-fill-available;' ]) }}
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="row w-100">
                                                        <div class="col-sm-12 mt-3 text-right p-0">
                                                            @if($flag == true)
                                                                <a href="{{ route('admin.candidates') }}" class="btn btn-primary">Clear All</a>
                                                            @endif
                                                            <button class="btn btn-primary">Apply</button>
                                                        </div>
                                                    </div>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="table-responsive-md">
                                        <table class="table table-hover table-center mb-0" id="candidateTable">
                                            <thead>
                                            <tr>
                                                <th class=" mb-0 h6 text-sm">{{__('#')}}</th>
                                                <th class=" mb-0 h6 text-sm">{{__('Profile')}}</th>
                                                <th class=" mb-0 h6 text-sm">{{__('Applied Job')}}</th>
                                                <th class=" mb-0 h6 text-sm">{{__('Status')}}</th>
                                                <th class=" mb-0 h6 text-sm">{{__('Current Stage')}}</th>
                                                <th class=" mb-0 h6 text-sm">{{__('Job Application')}}</th>
                                                <th class="text-right name mb-0 h6 text-sm">{{__('Action')}}</th>
                                            </tr>
                                            </thead>
                                            <tbody>
                                                @foreach($candidate as $key => $_candidate)
                                                    <tr>
                                                        <td data-title="id">{{$key+1}}</td>
                                                        <td data-title="Profile">
                                                            @php
                                                                $candidateJobstatus = $_candidate->jobpostStatus();
                                                            @endphp
                                                            <a class="text-info show-modal" href="javascript:void(0)" data-job-post-id="{{ !empty($_candidate->jobpostStatus()->first())?( encrypted_key($_candidate->jobpostStatus()->first()->id, 'encrypt')) :'' }}" data-id="{{encrypted_key($_candidate->id, "encrypt")}}">
                                                                <span>{{$_candidate->first_name}} {{$_candidate->last_name}}</span>
                                                            </a><br>
                                                            <small class="text-muted">{{$_candidate->email}}</small>
                                                        </td>
                                                        <td data-title="Applied Job">{{$_candidate->job_name}}</td>
                                                        <td data-title="Status">
                                                            <span class="badge badge-pill badge-primary text-capitalize px-3 py-2">
                                                                {{$_candidate->status}}
                                                            </span>
                                                        </td>
                                                        <td data-title="Current Stage">
                                                            <span class="text-capitalize px-3 py-2">
                                                                {{$_candidate->getCurrentStage()}}
                                                            </span>
                                                        </td>
                                                        <td data-title="Job Application">
                                                            @php
                                                                $dataCollapse = $_candidate->getJobApplicationClass();
                                                            @endphp
                                                            <a href="javascript:void(0)">
                                                                <span class="badge rounded-pill px-3 py-2 {{$dataCollapse["class"]}}" {{$dataCollapse["attribute"]}} >{{$_candidate->job_application}}</span>
                                                            </a>
                                                        </td>
                                                        <td data-title="Action">
                                                            {!! $_candidate->getActionMenu() !!}
                                                        </td>
                                                    </tr>
                                                    <tr class="table-expandable-area {{$_candidate->id}}">
                                                        <td colspan="7">
                                                            @include("admin.candidate.candidates_jobs")
                                                        </td>
                                                    </tr>
                                                    @php $key++ @endphp
                                                @endforeach
                                                @if($candidate->count()==0)
                                                    <tr>
                                                        <td colspan="7">{{__("No record found.")}}</td>
                                                    </tr>
                                                @endif
                                            </tbody>
                                        </table>
                                    </div>
                                    <div class="d-flex justify-content-center">
                                        {{ $candidate ->links() }}
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
@include('admin.candidate.candidate_all_modals')
@include('admin.candidate.candidate_action')
<script type="text/javascript" src="https://cdn.jsdelivr.net/jquery/latest/jquery.min.js"></script>
<script type="text/javascript" src="https://cdn.jsdelivr.net/momentjs/latest/moment.min.js"></script>
<script type="text/javascript" src="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.min.js"></script>
<link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.css" />
<script type="text/javascript">
    $(document).on("click", "#applied_date", function () {

    });

    // $('input[name="applied_date"]').daterangepicker();
    $(function() {

        $('input[name="applied_date"]').daterangepicker({
            autoUpdateInput: false,
            locale: {
                cancelLabel: 'Clear'
            }
        });

        $('input[name="applied_date"]').on('apply.daterangepicker', function(ev, picker) {
            $(this).val(picker.startDate.format('MM/DD/YYYY') + ' - ' + picker.endDate.format('MM/DD/YYYY'));
        });

        $('input[name="applied_date"]').on('cancel.daterangepicker', function(ev, picker) {
            $(this).val('');
        });

    });

    $(function() {
        $('input[name="from-date"]').daterangepicker({
            singleDatePicker: true,
            showDropdowns: true,
            minYear: 1901,
            maxYear: parseInt(moment().format('YYYY'),10)
        }, function(start, end, label) {
            var years = moment().diff(start, 'years');
            // alert("You are " + years + " years old!");
        });
    });
    $(function() {
        $('input[name="to-date"]').daterangepicker({
            singleDatePicker: true,
            showDropdowns: true,
            minYear: 1901,
            maxYear: parseInt(moment().format('YYYY'),10)
        }, function(start, end, label) {
            var years = moment().diff(start, 'years');
            // alert("You are " + years + " years old!");
        });
    });

</script>
