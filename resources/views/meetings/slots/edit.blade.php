{{ Form::open(['route' =>'meeting.schedule.slot.update','id' => 'create_contact','enctype' => 'multipart/form-data']) }}
      @csrf
<input type="hidden" class="form-control" value="{{$slot->id}}" name="id"  required>
   
<div class="form-group">
    <div class="row">
        <div class="col-md-12">
            <label class="form-control-label">Slot Date Start</label>
            <input type="date" class="form-control" name="date" placeholder="Date" value='{{$slot->date}}' required>
        </div>
    </div>
</div>
<div class="hours-info">
    <div class="row form-row hours-cont">
        <div class="col-12 col-md-10">
            <div class="row form-row">
                <div class="col-12 col-md-6">
                    <div class="form-group">
                        <label>Start Time</label>
                        <input type="time" class="form-control" name="starttime" value='{{$slot->start_time}}' placeholder="Date" required>
                    </div> 
                </div>
                <div class="col-12 col-md-6">
                    <div class="form-group">
                        <label>End Time</label>
                        <input type="time" class="form-control" name="endtime" value='{{$slot->end_time}}' placeholder="Date" required>
                    </div> 
                </div>
            </div>
        </div>
    </div>
</div>
<div class="text-right">
    {{ Form::button(__('Update'), ['type' => 'submit','class' => 'btn btn-sm btn-primary rounded-pill']) }}
    <button type="button" class="btn btn-sm btn-secondary rounded-pill" data-dismiss="modal">{{__('Cancel')}}</button>
</div>
{{ Form::close() }}






