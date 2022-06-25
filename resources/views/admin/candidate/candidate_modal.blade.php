@php
 /**
 * @var App\CandidateJobStatus $candidateJobpost
 */
@endphp
<div class="candidate-details-wrapper min-height-400">
    <div class="candidate-details-header">
        <div class="row">
            <div class="col-lg-6 col-xl-7 mb-4 mb-lg-0">
                <div class="d-flex align-items-center">
                    <div class="candidate-profile-avatar mr-3">
                        <div class="no-profile-image">
                            {{ $data->getCandidateNameLabel($data->id) }}
                        </div>
                    </div>
                    <div>

                        <h4>{{ $data->getCandidateName($data->id) }}</h4>
                        <p class="text-muted mb-0">
                            {{ $data->getJobPostLabel($candidateJobpost->jobpost) }}
                        </p>
                        <small class="text-muted">
                            {{ 'Applied on '. jobDateFormat($data->created_at)  }}
                        </small>
                    </div>
                </div>
            </div>
            <div class="col-lg-6 col-xl-5">
                <div class="default-base-color rounded p-3 mb-3">
                    <div class="text-size-25 d-flex align-items-center justify-content-between">
                        @if($candidateJobpost->reviews==0)
                            <span class="rating-count">{{__("Not reviewed yet")}}</span>
                        @else
                            <span class="rating-count">{{ __($candidateJobpost->reviews.' of 5')  }}</span>
                        @endif
                        <ul class="candidate-rating list list-unstyled p-0 m-0">
                            @for($i=1; $i<=5; $i++)
                                @php $active = ($i<=$candidateJobpost->reviews) ? $active = "active" : ""; @endphp
                                 <li class="d-inline-block save-star star {{$active}}" data-star-value="{{$i}}" data-candidate-id="{{$data->id}}" data-Jobpost-id="{{$candidateJobpost->id}}">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-star">
                                        <polygon points="12 2 15.09 8.26 22 9.27 17 14.14 18.18 21.02 12 17.77 5.82 21.02 7 14.14 2 9.27 8.91 8.26 12 2"></polygon>
                                    </svg>
                                 </li>
                            @endfor
                        </ul>
                    </div>
                </div>
                <div class="d-flex align-items-center justify-content-between">
                    <div class="d-flex align-items-center default-actions">
                        <a href="javascript:void(0)" data-toggle="tooltip" data-placement="top" title="" class="action-button" data-original-title="Disqualify" data-id="{{encrypted_key($data->id, 'encrypt')}}" data-stage-id="" data-candidate-id="{{ $data->id }}" data-Jobpost-id="{{$candidateJobpost->id}}">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-minus-circle size-26">
                                <circle cx="12" cy="12" r="10"></circle>
                                <line x1="8" y1="12" x2="16" y2="12"></line>
                            </svg>
                        </a>
                        <a href="javascript:void(0)" data-toggle="tooltip" data-placement="top" title="" class="action-button" data-original-title="Compose mail" data-toggle="modal" data-target="#mailModal" data-candidate-id="{{ $data->id }}" data-Jobpost-id="{{$candidateJobpost->id}}">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-mail size-26">
                                <path d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2z"></path>
                                <polyline points="22,6 12,13 2,6"></polyline>
                            </svg>
                        </a>
                        <a href="javascript:void(0)" data-toggle="tooltip" data-placement="top" title="Create Event" class="action-button" data-original-title="Create event" data-id="{{encrypted_key($data->id, 'encrypt')}}" data-jobpost-id="{{ encrypted_key($candidateJobpost->id, 'encrypt') }}">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-calendar size-26">
                                <rect x="3" y="4" width="18" height="18" rx="2" ry="2"></rect>
                                <line x1="16" y1="2" x2="16" y2="6"></line>
                                <line x1="8" y1="2" x2="8" y2="6"></line>
                                <line x1="3" y1="10" x2="21" y2="10"></line>
                            </svg>
                        </a>
                    </div>
                    <div class="d-flex align-items-center justify-content-end">
                        Stage
                        <div class="dropdown dropdown-with-animation stage-dropdown ml-2">
                            <button type="button" data-toggle="dropdown" aria-expanded="false" id="selected-stage" class="btn btn-primary dropdown-toggle text-capitalize">
                                {{ $data->getStageLabel($candidateJobpost->current_stage) }}
                            </button>
                            <ul class="dropdown-menu dropdown-menu-right">
                                @if(!empty($data))
                                    @foreach($data->getStageOptions() as $key => $stage)
                                        <li>
                                            <a href="javascript:void(0)" class="dropdown-item text-capitalize d-flex align-items-center justify-content-between stages @if($key == $candidateJobpost->current_stage) text-primary @endif" data-stage-id="{{ $key }}" data-candidate-id="{{ $data->id }}" data-Jobpost-id="{{$candidateJobpost->id}}">
                                                {{$stage}}
                                                @if($key == $candidateJobpost->current_stage)
                                                    <span><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-check"><polyline points="20 6 9 17 4 12"></polyline></svg></span>
                                                @endif
                                            </a>
                                        </li>
                                    @endforeach
                                @endif
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="candidate-details-content">
        <div class="horizontal-tab">
            <div class="card border-0">
                <nav class="candidate-tab-nav">
                    <div class="nav nav-tabs">
                        <a data-toggle="tab" href="javascript:void(0)" class="nav-item p-primary text-capitalize active " id="view-timeline" data-id="timeline" data-candidate-id="{{ $data->id }}">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-clock mr-2">
                                <circle cx="12" cy="12" r="10"></circle>
                                <polyline points="12 6 12 12 16 14"></polyline>
                            </svg>
                            {{__("Timeline")}}
                        </a>
                        <a data-toggle="tab" href="javascript:void(0)" class="nav-item p-primary text-capitalize" data-id="notes" id="candidate-notes" data-candidate-id="{{ encrypted_key($data->id, 'encrypt')}}" data-job-post-id="{{ encrypted_key($candidateJobpost->id, 'encrypt') }}">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-book-open mr-2">
                                <path d="M2 3h6a4 4 0 0 1 4 4v14a3 3 0 0 0-3-3H2z"></path>
                                <path d="M22 3h-6a4 4 0 0 0-4 4v14a3 3 0 0 1 3-3h7z"></path>
                            </svg>
                            {{__("Notes")}}
                        </a>
                        <a data-toggle="tab" href="javascript:void(0)" class="nav-item p-primary text-capitalize" id="candidate-event" data-id="events" data-candidate-id="{{ encrypted_key($data->id, 'encrypt')}}" data-candidatejob-id="{{ encrypted_key($candidateJobpost->id, 'encrypt')}}">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-calendar mr-2">
                                <rect x="3" y="4" width="18" height="18" rx="2" ry="2"></rect>
                                <line x1="16" y1="2" x2="16" y2="6"></line>
                                <line x1="8" y1="2" x2="8" y2="6"></line>
                                <line x1="3" y1="10" x2="21" y2="10"></line>
                            </svg>
                            {{__("Events")}}
                        </a>
                        <a data-toggle="tab" href="javascript:void(0)" class="nav-item p-primary text-capitalize" data-id="applicantDetails">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-user mr-2">
                                <path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"></path>
                                <circle cx="12" cy="7" r="4"></circle>
                            </svg>
                            {{__("Applicant Details")}}
                        </a>
                        <a data-toggle="tab" href="javascript:void(0)" class="nav-item p-primary text-capitalize" data-id="questions" id="candidate-questions"data-candidate-id="{{ encrypted_key($data->id, 'encrypt')}}" data-candidatejob-id="{{ encrypted_key($candidateJobpost->jobpost, 'encrypt')}}">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-help-circle mr-2">
                                <circle cx="12" cy="12" r="10"></circle>
                                <path d="M9.09 9a3 3 0 0 1 5.83 1c0 2-3 3-3 3"></path>
                                <line x1="12" y1="17" x2="12.01" y2="17"></line>
                            </svg>
                            {{__("Questions & Answers")}}
                        </a>
                        <a data-toggle="tab" href="javascript:void(0)" class="nav-item p-primary text-capitalize" data-id="attachments" id="candidate-attachment" data-candidate-id="{{ encrypted_key($data->id, 'encrypt')}}" data-candidatejob-id="{{ encrypted_key($candidateJobpost->jobpost, 'encrypt')}}">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-file-text mr-2">
                                <path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"></path>
                                <polyline points="14 2 14 8 20 8"></polyline>
                                <line x1="16" y1="13" x2="8" y2="13"></line>
                                <line x1="16" y1="17" x2="8" y2="17"></line>
                                <polyline points="10 9 9 9 8 9"></polyline>
                            </svg>
                            {{__("Attachments")}}
                        </a>
                    </div>
                </nav>
                <div class="tab-content">
                    <div id="timeline" class="tab-pane fade show active"></div>
                    <div id="notes" class="tab-pane fade show ">
                        <div class="default-base-color candidate-notes min-height-200 p-primary">
                            <div class="card shadow border-0">
                                <div class="card-body">
                                    <div class="d-flex align-items-center mb-4">
                                        <div class="avatars-w-40">
                                            <img src="{{ asset('public/images/avatar-demo.jpg') }}" alt="Not found" class="rounded-circle avatar-bordered"> <!---->
                                        </div>
                                        <div class="ml-3">
                                            <h6 class="mb-1">{{ $data->getCandidateName($data->id) }}</h6>
                                        </div>
                                    </div>
                                    <div>
                                        <div class="form-group">
                                            <div class="row">
                                                <div class="col-md-12">
                                                    <label class="form-control-label"></label>
                                                    <textarea id="summary-ckeditor"  class="form-control editor1" aria-required="true" name="notes-editor" placeholder="Notes....." rows="10" minlength="30" maxlength="500" required=""  >{{!empty($data->description) ? $data->description :''}}</textarea>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="d-flex justify-content-end mt-2">
                                        <a href="javascript:void(0)"  id="save-notes"  data-jobpost-id="{{$candidateJobpost->id}}" data-id="{{ $data->id }}" class="btn btn-primary">
                                            Submit
                                        </a>
                                    </div>
                                </div>
                            </div>
                            <!-- Card View of Notes -->
                            <div id="show-notes">
                            </div>
                            <!-- /Card View of Notes -->
                        </div>
                    </div>
                    <div id="events" class="tab-pane fade show ">
                    </div>
                    <div id="applicantDetails" class="tab-pane fade show ">
                        <table class="table table-card">
                            <tbody>
                            <tr>
                                <td class="text-muted width-150">Name</td>
                                <td>{{ $data->getCandidateName($data->id) }}</td>
                            </tr>
                            <tr>
                                <td class="text-muted width-150">Email</td>
                                <td>{{ $data->email }}</td>
                            </tr>
                            <tr>
                                <td class="text-muted width-150">Gender</td>
                                <td class="text-capitalize">{{ $data->gender }}</td>
                            </tr>
                            <tr>
                                <td class="text-muted width-150">Date of birth</td>
                                <td>{{ $data->dob }}</td>
                            </tr>
                            </tbody>
                        </table>
                    </div>
                    <div id="questions" class="tab-pane fade show">
                    </div>
                    <div id="attachments" class="tab-pane fade show ">
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>



