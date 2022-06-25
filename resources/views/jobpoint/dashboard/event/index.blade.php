<?php
    $page = 'partner';
    /**
     * @var App\CandidateEvent $event
     */
?>
@extends('layout.dashboardlayout')
@section('content')


    <!-- Page Content -->
    <div class="content">
        <div class="container-fluid">

            <div class="row">
                <div class="col-md-5 col-lg-4 col-xl-3 theiaStickySidebar">
                    @include('layout.partials.userSideMenu')
                </div>
                <div class="col-md-7 col-lg-8 col-xl-9">
                    <div class=" col-md-12 ">
                    </div>
                    <!-- Breadcrumb -->
                    <div class="breadcrumb-bar mt-3">
                        <div class="container-fluid">
                            <div class="row align-items-center">
                                <div class="col-md-12 col-12">
                                    <h2 class="breadcrumb-title">All Events</h2>

                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card">
                        <div class="card-body">
                            <div class="event mb-3 cursor-pointer mb-2">
                                <div class="event-date">
                                    @if(!empty($events))
                                        @foreach($events as $event)
                                            <div class="row shadow p-3 mt-3  bg-white">
                                                <div class="col-sm-2 text-center border-right candidate-event-detail btn" data-id="{{ $event->id }}">
                                                    <div class="month bg-primary text-white">
                                                        {{$event->getEventDateFormat("F", $event->event_start_datetime)}}
                                                    </div>
                                                    <div class="date-day bg-light">
                                                        <h4 class="text-size-16 mb-0">{{$event->getEventDateFormat("j", $event->event_start_datetime)}}</h4>
                                                        <small class="text-muted10">
                                                            {{$event->getEventDateFormat("l", $event->event_start_datetime)}}
                                                        </small>
                                                    </div>
                                                </div>
                                                <div class="col-sm-10">
                                                    <div class="event-details candidate-event-detail" data-id="{{ $event->id }}" style="cursor: pointer">
                                                        <p class="mb-0">{{ $event->getEventLabel($event->event_type) }}</p>
                                                        <div class="d-flex align-items-center">
                                                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-user size-13 text-muted mr-2">
                                                                <path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"></path>
                                                                <circle cx="12" cy="7" r="4"></circle>
                                                            </svg>
                                                            <p class="mb-0 text-size-12 text-muted ">{{$event->getCandidateName($event->candidate_id)}}</p>
                                                        </div>
                                                        <div class="d-flex align-items-center mb-2">
                                                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-clock size-13 text-muted mr-2">
                                                                <circle cx="12" cy="12" r="10"></circle>
                                                                <polyline points="12 6 12 12 16 14"></polyline>
                                                            </svg>
                                                            <span class="text-size-12 text-muted">
                                                            {{$event->getEventDateFormat('d-m-Y g:i A', $event->event_start_datetime)}} -
                                                            {{$event->getEventDateFormat('d-m-Y g:i A', $event->event_start_datetime)}}
                                                            </span>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        @endforeach
                                    @endif
                                    @if($events->count()==0)
                                        <tr>
                                            <td colspan="7">{{__("No Events found.")}}</td>
                                        </tr>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="d-flex justify-content-center">
                        {{ $events ->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
    {{-- <div class="d-flex justify-content-center">
        {{ $job ->links() }}
    </div> --}}
@endsection
<!-- Candidate EventDetails Modal-->
<div data-backdrop="true" data-keyboard="true" id="event-view-modal" tabindex="-1" role="dialog" class="modal fade custom-scrollbar show" style=" display:none;" aria-modal="true">
    <div role="document" class="modal-dialog modal-dialog-top modal-default modal-dialog-scrollable popup_mt">
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
    //show Candidate Event Details Modal
    $(document).on("click", '.candidate-event-detail', function () {
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
