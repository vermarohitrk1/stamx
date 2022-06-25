<?php
/**
 * @var App\CandidateEvent $event
 */
?>
<div class="container">
    <div class="container mt-3">
        <form id="event-form" >
            @csrf
            @if(!empty($event->id))
                <input class="form-control" type="hidden" value="{{!empty($event->id) ? $event->id:''}}" name="id">
            @endif
            <input class="form-control" type="hidden" value="{{!empty($data) ? $data->id:''}}" name="candidate_id">
            <input class="form-control" type="hidden" value="{{ !empty($event->candidate_job_status_id) ? $event->candidate_job_status_id : $jobpost_id }}" name="candidate_job_status_id">
            <div class="form-group row">
                <label for="event_type" class="col-sm-2 col-form-label">Event type</label>
                <div class="col-sm-10">
                    {{Form::select('event_type', $event->getEventType(), $event->event_type, ["class" => 'form-control', 'required' => true, 'id' => 'event_type'])}}
                    <div><span id="event_type_error" style="color:red; font-size: smaller;"></span></div>
                </div>
            </div>
            <div class="form-group row">
                <label for="eventshedule" class="col-sm-2 col-form-label">Event schedule</label>
                <div class="col-sm-10">
                    <div class="d-flex align-items-center justify-content-between">
                        <div>
                      <span>
                         <div class="date-picker-input">
                            <div class="input-group">
                               <input placeholder="Start date"  type="datetime-local" class="form-control" name="event_start_datetime"  required value="{{ isset($event->event_start_datetime)?date('Y-m-d\TH:i', strtotime($event->event_end_datetime)) :'' }}">
                            </div>
                         </div>
                         <div data-v-05016e86="" class="vc-popover-content-wrapper">
                         </div>
                      </span>
                        </div>
                        -
                        <div>
                      <span>
                         <div class="date-picker-input">
                            <div class="input-group">
                               <input placeholder="End date" type="datetime-local" class="form-control" name="event_end_datetime"  required value="{{ isset($event->event_end_datetime)?date('Y-m-d\TH:i', strtotime($event->event_end_datetime)) :'' }}">
                            </div>
                         </div>
                         <div data-v-05016e86="" class="vc-popover-content-wrapper">
                         </div>
                      </span>
                        </div>
                    </div>
                    <div><span id="event_date_error" style="color:red; font-size: smaller;"></span></div>
                </div>
            </div>
            <div class="form-group row">
                <label for="location" class="col-sm-2 col-form-label">Location</label>
                <div class="col-sm-10">
                    <input type="text"  class="form-control" id="location" name="location" required value="{{ !empty($event)?$event->location : '' }}" placeholder="Enter Location">
                    <div><span id="location_error" style="color:red; font-size: smaller;"></span></div>
                </div>
            </div>
            <div class="form-group row">
                <label for="candidate" class="col-sm-2 col-form-label">Candidate</label>
                <div class="col-sm-10">
                    <p class="text-primary mt-2">{{ !empty($data)? $data->getCandidateName($data->id) : ''}}</p>
                </div>

            </div>
            <div class="form-group row">
                <label for="attendees" class="col-sm-2 col-form-label">Attendees</label>
                <div class="col-sm-10">
                    {{Form::select('attendees[]', $event->getAttendees(), $event->getSelectedAttendees(), ["class" => 'form-control', 'required' => true, 'multiple' => 'multiple', 'id' => 'attendees'])}}
                    <div><span id="attendees_error" style="color:red; font-size: smaller;"></span></div>
                </div>
            </div>
            <div class="form-group row">
                <label for="description" class="col-sm-2 col-form-label">Description</label>
                <div class="col-sm-10">
                    <textarea name="description" id="description" placeholder="Enter description" rows="4" class="custom-scrollbar form-control" required>{{ !empty($event)? $event->description :''}}</textarea>
                    <div><span id="description_error" style="color:red; font-size: smaller;"></span></div>
                </div>

            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary" id="save-event">Save</button>
            </div>
        </form>
    </div>
</div>

<script type="text/javascript">
    $(document).ready(function () {
        // $(function () {
        //     $('.datetimepicker-input').datetimepicker();
        // });
        $('input[type="date"]').change(function () {
            closeDate(this);
        });
    });
</script>
