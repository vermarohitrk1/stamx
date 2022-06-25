{{ Form::open(['route' =>'meeting.schedules.booking.reschedule.post','id' => 'create_contact','enctype' => 'multipart/form-data']) }}
       <input type="hidden" class="form-control" value="{{$slot->id}}" name="id"  required>
                <input type="hidden" name="csrf-token" value="<?=csrf_token();?>" />


<div class="form-group" >
    <div class="row">

        <div class="col-md-12" >
            <label class="form-control-label">Schedule Options</label>
            <select name="schedule" id="schedule"  class="form-control select2" style="width: 100%"  >
                @foreach($slots as $row)
           <option @if($row->id == $slot->id) selected @endif value="{{$row->id}}">{{date('F d, Y', strtotime($row->date))}} => {{$row->start_time}} - {{$row->end_time}}</option>
           @endforeach
            </select>
        </div>
    </div>
</div>



<div class="text-right">
    {{ Form::button(__('Save'), ['type' => 'submit','class' => 'btn btn-sm btn-primary rounded-pill']) }}
    <button type="button" class="btn btn-sm btn-secondary rounded-pill" data-dismiss="modal">{{__('Cancel')}}</button>
</div>
{{ Form::close() }}

<script>

    $('#schedule').select2();
    </script>








