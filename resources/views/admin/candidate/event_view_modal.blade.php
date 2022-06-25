@php
    /**
     * @var App\CandidateEvent $event
     */
@endphp
<div>
    @if(!empty($event))
        <div class="d-flex align-items-center mb-2">
            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none"
                 stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                 class="feather feather-user mr-2">
                <path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"></path>
                <circle cx="12" cy="7" r="4"></circle>
            </svg>
            <p class="mb-0">{{ $event->getCandidateName($event->candidate_id) }}</p>
        </div>
        <div class="d-flex align-items-center mb-3">
            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none"
                 stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                 class="feather feather-clock mr-2">
                <circle cx="12" cy="12" r="10"></circle>
                <polyline points="12 6 12 12 16 14"></polyline>
            </svg>
            <span>
               {{jobDateFormat($event->event_start_datetime, true)}} - {{jobDateFormat($event->event_end_datetime, true)}}
            </span>
        </div>
        <hr>
        <p class="mb-0">{{__("Attendees:")}}</p>
        <div>
            <div class="avatar-group avatar-group-small avatars-group-w-50 ">
                @foreach($event->getSelectedAttendees(true) as $attendees)
                    <div class="no-img rounded-circle avatar-bordered avatar-label" data-original-title="Click to show all" title="Click to show all" data-toggle="tooltip" data-placement="top">
                        {{ $event->getAttendeesNameLabel($attendees) }}
                    </div>
                @endforeach
            </div>
            <div class="row animate__animated animate__fadeIn" style="display: none">
                <div class="col-12 justify-content-between event-expended">
                    @foreach($event->getSelectedAttendees() as $key => $attendees)
                        <div class="avatar-group-extended">
                            <div class="d-flex align-items-center pt-2">
                                <div class="avatars-group-w-50">
                                    <div class="no-img rounded-circle avatar-bordered">
                                        {{ $event->getAttendeesNameLabel($attendees) }}
                                    </div>
                                </div>
                                <div class="media-body ml-3">
                                    {{ $event->getAttendeesName($attendees) }}
                                    <p class="text-muted font-size-90 mb-0"></p>
                                </div>
                            </div>
                        </div>
                        @if($key == 0)
                            <a href="javascript:void(0)" class="mt-4 attendess-collapse attendess-expand">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                                     fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                     stroke-linejoin="round" class="feather feather-maximize-2">
                                    <polyline points="15 3 21 3 21 9"></polyline>
                                    <polyline points="9 21 3 21 3 15"></polyline>
                                    <line x1="21" y1="3" x2="14" y2="10"></line>
                                    <line x1="3" y1="21" x2="10" y2="14"></line>
                                </svg>
                            </a>
                        @endif
                    @endforeach
                </div>
            </div>
        </div>
    @endif
</div>
<script type="text/javascript">
    $(document).on("click", ".no-img.rounded-circle.avatar-bordered", function () {
        $('.avatar-group-small').hide();
        $('.animate__animated.animate__fadeIn').show();
    });

    $(document).on("click", ".attendess-expand", function () {
        $('.avatar-group-small').show();
        $('.animate__animated.animate__fadeIn').hide();
    });
</script>
