{{ Form::open(['route' =>'meeting.schedule.slot.store','id' => 'create_contact','enctype' => 'multipart/form-data']) }}
       <input type="hidden" class="form-control" value="{{$id}}" name="id"  required>
                <input type="hidden" name="csrf-token" value="<?=csrf_token();?>" />
<div class="form-group">
    <div class="row">            
        <div class="col-md-12">
            <label class="form-control-label">Create Bulk Slots</label>
            <div  class="status-toggle d-flex ">
                <input  type="checkbox"  id="bulkoption" class="check" >
                <label for="bulkoption" class="checktoggle">checkbox</label>
            </div>
        </div>
    </div>
</div>
<div class="form-group"  id="days_selected_div">
    <div class="row">

        <div class="col-md-12">
            <label class="form-control-label">Please select slot days</label>
            <select class="form-control select2" multiple name="days_selected[]" style="width: 100%" id="days_selected">
                <option value="Monday">Monday</option>
                <option value="Tuesday">Tuesday</option>
                <option value="Wednesday">Wednesday</option>
                <option value="Thursday">Thursday</option>
                <option value="Friday">Friday</option>
                <option value="Saturday">Saturday</option>
                <option value="Sunday">Sunday</option>
            </select>
        </div>
    </div>
</div>
<div class="form-group" id="schedule_for_weeks_div">
    <div class="row">

        <div class="col-md-12" >
            <label class="form-control-label">Schedule Options</label>
            <select name="schedule_for_weeks" id="schedule_for_weeks" class="form-control" id="schedule_for_weeks"  >
            <option value="">Please Select</option>   
            <option value="1">1 Week</option>
            <option value="2">2 Week</option>
            <option value="3">3 Week</option>
            <option value="4">4 Week</option>
            <option value="5">5 Week</option>
            <option value="6">6 Week</option>
            <option value="7">7 Week</option>
            <option value="8">8 Week</option>
            <option value="9">9 Week</option>
            <option value="10">10 Week</option>
            </select>
        </div>
    </div>
</div>
<div class="form-group">
    <div class="row">
        <div class="col-md-12">
            <label class="form-control-label">Slot Date Start</label>
            <input type="date" class="form-control" name="date" placeholder="Date" required>
        </div>
    </div>
</div>
<div class="form-group">
    <div class="row">
        <div class="col-md-12">
            <label class="form-control-label">No of bookings</label>
            <input type="number" min="1" step="1" max="100" value="1" class="form-control" name="bookings_number" placeholder="Enter number of bookings" required>
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
                        <input type="time" class="form-control" name="starttime[]" placeholder="Date" required>
                    </div> 
                </div>
                <div class="col-12 col-md-6">
                    <div class="form-group">
                        <label>End Time</label>
                        <input type="time" class="form-control" name="endtime[]" placeholder="Date" required>
                    </div> 
                </div>
            </div>
        </div>
    </div>
</div>

<div class="add-more mb-3">
    <a href="javascript:void(0);" class="add-hours"><i class="fa fa-plus-circle"></i> Add More Slots</a>
</div>




<div class="text-right">
    {{ Form::button(__('Save'), ['type' => 'submit','class' => 'btn btn-sm btn-primary rounded-pill']) }}
    <button type="button" class="btn btn-sm btn-secondary rounded-pill" data-dismiss="modal">{{__('Cancel')}}</button>
</div>
{{ Form::close() }}



<script>

    $('#days_selected').select2();
    $('#days_selected_div').hide();
    $('#schedule_for_weeks_div').hide();

    $(document).on("click", "#bulkoption", function () {
        if ($('#days_selected_div').css('display') == 'none') {
            $('#days_selected_div').show();
            $('#schedule_for_weeks_div').show();
            $('#days_selected').attr("required", true);
            $('#schedule_for_weeks').attr("required", true);
        } else {
            $('#days_selected_div').hide();
            $('#schedule_for_weeks_div').hide();
            $('#days_selected').attr("required", false);
            $('#schedule_for_weeks').attr("required", false);
        }

    });

// Add More Hours
	
    $(".hours-info").on('click','.trash', function () {
		$(this).closest('.hours-cont').remove();
		return false;
    });

    $(".add-hours").on('click', function () {
		
		var hourscontent = '<div class="row form-row hours-cont">' +
			'<div class="col-12 col-md-10">' +
				'<div class="row form-row">' +
					'<div class="col-12 col-md-6">' +
						'<div class="form-group">' +
							'<label>Start Time</label>' +
							'<input type="time" class="form-control" name="starttime[]" placeholder="Date" required>' +
						'</div>' +
					'</div>' +
					'<div class="col-12 col-md-6">' +
						'<div class="form-group">' +
							'<label>End Time</label>' +
							'<input type="time" class="form-control" name="endtime[]" placeholder="Date" required>' +
						'</div>' +
					'</div>' +
				'</div>' +
			'</div>' +
			'<div class="col-12 col-md-2"><label class="d-md-block d-sm-none d-none">&nbsp;</label><a href="#" class="btn btn-danger trash"><i class="far fa-trash-alt"></i></a></div>' +
		'</div>';
		
        $(".hours-info").append(hourscontent);
        return false;
    });
</script>






