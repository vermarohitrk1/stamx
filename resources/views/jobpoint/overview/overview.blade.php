@php
/**
 * @var \App\Job $job
 * @var string $tab
 */
@endphp
<?php $page = 'partner'; ?>
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
                    <div class=" col-md-12 "></div>
                    <!-- Breadcrumb -->
                    <div class="breadcrumb-bar mt-3">
                        <div class="container-fluid">
                            <div class="row align-items-center">
                                <div class="col-md-6 col-6">
                                    <h2 class="breadcrumb-title">Overview-{{ $job->job_title }}</h2>
                                </div>
                                <div class="col-md-6 col-6">
                                    <a class="btn btn-sm btn-primary .btn-rounded float-right mb-4" href="#" data-url="{{route('candidate.form')}}" data-ajax-popup="true" data-size="md" data-title="{{__('Add Candidate')}}">
                                        <i class="fas fa-plus"></i>
                                        {{__("Add Candidate")}}
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card">
                        <div class="card-body">
                            <div class="row shadow bg-white">
                                <div class=" col-md-12 col-12 mt-3">
                                    @php $tabClass = ($tab=="overview") ? "active text-primary" : "" @endphp
                                    <a href="{{ route('jobpost.overview', ['id' => encrypted_key($job->id, 'encrypt'),'tab' => 'overview']) }}"
                                       class="navigationBar {{ $tabClass }}">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-grid"><rect x="3" y="3" width="7" height="7"></rect><rect x="14" y="3" width="7" height="7"></rect><rect x="14" y="14" width="7" height="7"></rect><rect x="3" y="14" width="7" height="7"></rect></svg>
                                        <span style="font-size:18px" class="mr-5">{{__("Overview")}}</span>
                                    </a>
                                    @php $tabClass = ($tab=="candidataes") ? "active text-primary" : "" @endphp
                                    <a href="{{ route('jobpost.overview', ['id' => encrypted_key($job->id, 'encrypt'),'tab' => 'candidataes']) }}"
                                       class="navigationBar {{ $tabClass }}">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-users"><path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"></path><circle cx="9" cy="7" r="4"></circle><path d="M23 21v-2a4 4 0 0 0-3-3.87"></path><path d="M16 3.13a4 4 0 0 1 0 7.75"></path></svg>
                                        <span style="font-size:18px">{{__("Candidates")}}</span>
                                    </a>
                                    <hr width="100%" class="mt-5 mb-3">
                                    @if($tab=="overview")
                                        <div class="kanban-wrapper custom-scrollbar overflow-auto pb-3" id="overview">
                                            @foreach($job->getJobStageOverview() as $_overview)
                                                <div class="kanban-column">
                                                    <div class="d-flex align-items-center kanban-stage-header">
                                                        <div class="bg-primary rounded mr-2 ml-2 roundedBox">
                                                            <span class="bg-primary rounded mr-2"></span>
                                                        </div>
                                                        <h6 class="text-capitalize mb-0">
                                                            <span>{{$_overview["label"]}}</span>
                                                            <span class="default-base-color rounded text-secondary px-2 py-1 d-inline-flex align-items-center justify-content-center">{{$_overview["count"]}}</span>
                                                        </h6>
                                                    </div>
                                                    <div class="kanban-draggable-column mt-3">
                                                        @foreach($_overview["candidates"] as $candidates)
                                                            <a class="text-info show-modal" href="javascript:void(0)" data-job-post-id="{{ encrypted_key($candidates["candidate_job_status_id"], "encrypt") }}" data-id="{{encrypted_key($candidates["id"], "encrypt")}}">
                                                                <div class="card draggable-item bg-light-custom">
                                                                    <div class="card-body pt-3 pb-3">
                                                                        <div class="d-flex align-items-center">
                                                                            <div class="mr-2 avatars-w-50">
                                                                                <div class="no-img rounded-circle">{{$candidates["short_name"]}}</div>
                                                                            </div>
                                                                            <div>
                                                                                <p class="mb-0 text-primary">{{$candidates["name"]}}</p>
                                                                                <small class="text-muted">{{$candidates["email"]}}</small>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </a>
                                                        @endforeach
                                                    </div>
                                                </div>
                                            @endforeach
                                        </div>
                                    @elseif($tab == 'candidataes')
                                        <div class="tab-content p-primary">
                                            <div class="candidates_applied_list">
                                                <div class="datatable">
                                                    <div class="custom-scrollbar table-responsive-md py-primary">
                                                        <table class="table table-hover table-center mb-0">
                                                            <thead>
                                                                <tr>
                                                                    <th class="mb-0 h6 text-sm"><span>{{__("Profile")}}</span></th>
                                                                    <th class="mb-0 h6 text-sm"><span>{{__("Status")}}</span></th>
                                                                    <th class="mb-0 h6 text-sm"><span>{{__("Review")}}</span></th>
                                                                    <th class="mb-0 h6 text-sm"><span>{{__("Current Stage")}}</span></th>
                                                                    <th class="mb-0 h6 text-sm">{{__("Actions")}}</span></th>
                                                                </tr>
                                                            </thead>
                                                            <tbody>
                                                            @php /**@var \App\Candidate $eachCandidate */ @endphp
                                                            @php $jobCandidates = $job->getJobCandidates() @endphp
                                                            @foreach($jobCandidates["all_candidate"] as $eachCandidate)
                                                                <tr>
                                                                    <td data-title="Profile" class="datatable-td">
                                                                        <div class=" d-flex align-items-center">
                                                                            <div class="avatars-w-50">
                                                                                <div class="no-img rounded-circle avatar-shadow">
                                                                                    {{$eachCandidate->getCandidateShortName()}}
                                                                                </div>
                                                                            </div>
                                                                            <div class="ml-3">
                                                                                @php $jobStatusId = $jobCandidates["candidate_job_details"][$eachCandidate->id]["id"] ?? 0; @endphp
                                                                                <a class="text-info show-modal" href="javascript:void(0)" data-job-post-id="{{ encrypted_key($jobStatusId, "encrypt") }}" data-id="{{encrypted_key($eachCandidate->id, "encrypt")}}">
                                                                                    <span>{{$eachCandidate->first_name}} {{$eachCandidate->last_name}}</span>
                                                                                </a>
                                                                                <p class="mb-0 font-size-90 text-muted">{{$eachCandidate->email}}</p>
                                                                            </div>
                                                                        </div>
                                                                    </td>
                                                                    <td data-title="Status" class="datatable-td">
                                                                        <div class=" d-flex align-items-center">
                                                                            <span class="text-capitalize p-3">{{$eachCandidate->status}}</span>
                                                                        </div>
                                                                    </td>
                                                                    <td data-title="Reviews" class="datatable-td">
                                                                        <ul class="rated list list-unstyled p-0 m-0 min-width-120">
                                                                            @for($i=1; $i<=5; $i++)
                                                                                @php $reviews = $jobCandidates["candidate_job_details"][$eachCandidate->id]["reviews"] ?? 0 @endphp
                                                                                @php $active = ($i<=$reviews) ? $active = "active" : ""; @endphp
                                                                                <li class="d-inline-block star {{$active}}">
                                                                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-star">
                                                                                        <polygon points="12 2 15.09 8.26 22 9.27 17 14.14 18.18 21.02 12 17.77 5.82 21.02 7 14.14 2 9.27 8.91 8.26 12 2"></polygon>
                                                                                    </svg>
                                                                                </li>
                                                                            @endfor
                                                                        </ul>
                                                                    </td>
                                                                    <td data-title="Current Stage" class="datatable-td">
                                                                        @php $currentStageId = $jobCandidates["candidate_job_details"][$eachCandidate->id]["current_stage"] ?? 0; @endphp
                                                                        <span class="text-capitalize">{{$eachCandidate->getStageLabel($currentStageId)}}</span>
                                                                    </td>
                                                                    <td data-title="Actions" class="datatable-td text-md-right">
                                                                        <div class="dropdown options-dropdown d-inline-block show">
                                                                            <button type="button" data-toggle="dropdown" title="Actions" class="btn-option btn" aria-expanded="true">
                                                                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-more-vertical">
                                                                                    <circle cx="12" cy="12" r="1"></circle>
                                                                                    <circle cx="12" cy="5" r="1"></circle>
                                                                                    <circle cx="12" cy="19" r="1"></circle>
                                                                                </svg>
                                                                            </button>
                                                                            <div class="dropdown-menu dropdown-menu-right py-2 mt-1 " style="position: absolute; will-change: transform; top: 0px; left: 0px; transform: translate3d(-122px, 30px, 0px);" x-placement="bottom-end">
                                                                                <a href="#" class="dropdown-item px-4 py-2" data-url="{{route('candidate.edit', encrypted_key($eachCandidate->id, "encrypt"))}}" data-title="Edit Candidate" data-size="md" data-ajax-popup="true">{{__("Edit")}}</a>
                                                                                <a href="#" class="dropdown-item px-4 py-2 delete_record_model" data-url="{{route('unassign.job', ['id' => encrypted_key($jobStatusId, "encrypt"), 'candidate_id' => encrypted_key($eachCandidate->id, "encrypt")])}}">{{__("Unassigned job")}}</a>
                                                                            </div>
                                                                        </div>
                                                                    </td>
                                                                </tr>
                                                            @endforeach
                                                            </tbody>
                                                        </table>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    @endif
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
