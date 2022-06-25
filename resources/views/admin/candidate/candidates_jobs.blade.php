@php
/**
 *@var array $jobStatus
 *@var \App\Candidate $_candidate
*/
@endphp
@php
    $jobCollection = $_candidate->jobpostStatus;
@endphp
<div id="collapse-{{$_candidate->id}}" class="collapse">
    <div class="row mx-0 justify-content-center">
        <div class="col-11 col-md-10 col-lg-9 col-xl-8 px-primary margin-top-30 margin-bottom-30">
            <div class="d-flex align-items-center justify-content-start mb-primary">
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-layers text-secondary size-36">
                    <polygon points="12 2 2 7 12 12 22 7 12 2"></polygon>
                    <polyline points="2 17 12 22 22 17"></polyline>
                    <polyline points="2 12 12 17 22 12"></polyline>
                </svg>
                <div class="ml-3">
                    <p class="mb-0 font-size-90">This candidate has applied {{$jobCollection->count()}} jobs</p>
                    <p class="mb-0 font-size-90 text-muted">Current job: {{ $_candidate->getJobPostLabel(!empty($jobCollection->first()->jobpost)) }}</p>
                </div>
            </div>
        </div>
    </div>
    <table class="table table-borderless row mx-0 justify-content-center">
        <tbody>
        @foreach($jobCollection as $key => $jobStatus)
            <tr>
                <td>
                    <div class="width-150 d-flex align-items-center">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-corner-down-right text-info">
                            <polyline points="15 10 20 15 15 20"></polyline>
                            <path d="M4 4v7a4 4 0 0 0 4 4h12"></path>
                        </svg>
                        <p class="mb-0 text-info">
                            {{ $_candidate->ordinal($key+1) }}
                        </p>
                    </div>
                </td>
                <td>
                    <div class="ml-3 width-350">
                        <p class="mb-0"><span class="text-muted">{{__("Job:")}} </span> <span class="font-size-90">{{ $_candidate->getJobPostLabel($jobStatus->jobpost) }}</span></p>
                        <p class="mb-0"><span class="text-muted">{{__("Current Stage:")}} </span>
                            <span class="font-size-90 text-capitalize">{{ $_candidate->getStageLabel($jobStatus->current_stage) }}</span>
                        </p>
                    </div>
                </td>
                <td>
                    <div class="ml-3 width-350">
                        <p class="mb-0">
                            <span class="text-muted">{{__("Status:")}} </span>
                            <span class="badge badge-pill px-3 py-2 badge-purple text-white"> In progress</span>
                        </p>
                        <div class="d-flex align-items-center">
                            <span class="text-muted">{{__("Reviews:")}} </span>
                            <ul class="rated list list-unstyled p-0 m-0 min-width-120">
                                @for($i=1; $i<=5; $i++)
                                    @php $active = ($i<=$jobStatus->reviews) ? $active = "active" : ""; @endphp
                                    <li class="d-inline-block star {{$active}}">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-star">
                                            <polygon points="12 2 15.09 8.26 22 9.27 17 14.14 18.18 21.02 12 17.77 5.82 21.02 7 14.14 2 9.27 8.91 8.26 12 2"></polygon>
                                        </svg>
                                    </li>
                                @endfor
                            </ul>
                        </div>
                    </div>
                </td>
                <td>
                    <div class="ml-3">
                        <div role="group" aria-label="Default action" class="btn-group btn-group-action">
                            <button type="button" data-toggle="tooltip" data-placement="top" title="" class="btn show-modal" data-original-title="View" data-job-post-id="{{ encrypted_key($jobStatus->id, 'encrypt') }}" data-id="{{ encrypted_key($_candidate->id, 'encrypt') }}">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-eye">
                                    <path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"></path>
                                    <circle cx="12" cy="12" r="3"></circle>
                                </svg>
                            </button>
                            <button type="button" data-toggle="tooltip" data-placement="top" title="" class="btn delete_record_model" data-original-title="Unassigned job" data-job-post-id="{{ $jobStatus->id}}" data-id="{{ encrypted_key($_candidate->id, 'encrypt') }}"
                                    data-url="{{ route('unassign.job', ['id' => encrypted_key($jobStatus->id, "encrypt"), 'candidate_id' => encrypted_key($_candidate->id, "encrypt")]) }}">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-x-circle">
                                    <circle cx="12" cy="12" r="10"></circle>
                                    <line x1="15" y1="9" x2="9" y2="15"></line>
                                    <line x1="9" y1="9" x2="15" y2="15"></line>
                                </svg>
                            </button>
                        </div>
                    </div>
                </td>
            </tr>
            @php $key++ @endphp
        @endforeach
        </tbody>
    </table>
</div>





