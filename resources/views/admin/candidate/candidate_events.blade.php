@php
/**
 * @var App\CandidateEvent[] $eventCollection
 * @var App\CandidateEvent $data
*/
@endphp
<div class="default-base-color candidate-events min-height-200 p-primary event-listing">
    <div class="events-wrapper min-height-400 position-relative">
        @if(!empty($eventCollection))
            @foreach($eventCollection as $data)
                <div class="event row border-bottom mb-2 pb-2">
                    <div class="col-sm-2 p-0 event-date cursor-pointer candidate-event-detail" data-id="{{ $data->id }}" style="cursor: pointer !important;">
                        <div class="text-center p-1">
                            <div class="month bg-primary text-white">{{$data->getEventDateFormat("F", $data->event_start_datetime)}}</div>
                            <div class="date-day bg-light">
                                <h4 class="text-size-16 mb-0 pt-2">{{$data->getEventDateFormat("j", $data->event_start_datetime)}}</h4>
                                <small class="text-muted10 pb-2">
                                    {{$data->getEventDateFormat("l", $data->event_start_datetime)}}
                                </small>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-10 event-details">
                        <div class="d-flex justify-content-between">
                            <div class="cursor-pointer candidate-event-detail" data-id="{{ $data->id }}" style="cursor: pointer !important;" title="Click to show all member">
                                <p class="mb-0">{{ $data->getEventLabel($data->event_type) }}</p>
                                <div class="d-flex align-items-center">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-user size-13 text-muted mr-2">
                                        <path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"></path>
                                        <circle cx="12" cy="7" r="4"></circle>
                                    </svg>
                                    <p class="mb-0 text-size-12 text-muted ">
                                        {{$data->getCandidateName($data->candidate_id)}}
                                    </p>
                                </div>
                                <div class="d-flex align-items-center mb-2">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-clock size-13 text-muted mr-2">
                                        <circle cx="12" cy="12" r="10"></circle>
                                        <polyline points="12 6 12 12 16 14"></polyline>
                                    </svg>
                                    <span class="text-size-12 text-muted">{{$data->getEventDateFormat('g:i A', $data->event_start_datetime)}} - {{$data->getEventDateFormat('g:i A', $data->event_end_datetime)}}</span>
                                </div>
                            </div>
                            <div class="d-flex align-items-center justify-content-start">
                                <a href="Javascript:void(0)" class="edit-event" data-id="{{ $data->id }}">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-edit size-18">
                                        <path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"></path>
                                        <path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"></path>
                                    </svg>
                                </a>
                                <a href="Javascript:void(0)" class="ml-2 delete-event"  data-id="{{ $data->id }}" >
                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-trash-2 size-18">
                                        <polyline points="3 6 5 6 21 6"></polyline>
                                        <path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"></path>
                                        <line x1="10" y1="11" x2="10" y2="17"></line>
                                        <line x1="14" y1="11" x2="14" y2="17"></line>
                                    </svg>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        @endif
    </div>
</div>
