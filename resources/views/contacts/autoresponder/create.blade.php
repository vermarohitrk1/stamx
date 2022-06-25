
{{ Form::open(['url' =>'autoresponder/store','id' => 'broadcast_folder','enctype' => 'multipart/form-data']) }}

<div class="form-group">
        <div class="row">
            <div class="col-md-12">
                <label class="form-control-label">Campaign name</label>
                <input type="hidden" class="form-control" value="{{$autoresponder->id??''}}" name="id"  >
                <input type="text" class="form-control" value="{{$autoresponder->campaign_name??''}}" name="campaign_name" placeholder="Campaign name" required>
                <input type="hidden" name="csrf-token" value="<?=csrf_token();?>" />
            </div>
        </div>
</div>
<div class="form-group">
    <label class="form-control-label">Template Type</label>
    <select class="form-control" id="typeTemplate" name="typeTemplate" required>
                                <option  value="">Select Type</option>
                                <option {{(!empty($autoresponder->typeTemplate) && $autoresponder->typeTemplate=="Email") ? 'selected':''}} value="Email">Email Only</option>
                                <option {{(!empty($autoresponder->typeTemplate) && $autoresponder->typeTemplate=="SMS") ? 'selected':''}} value="SMS">SMS Only</option>
                                <option {{(!empty($autoresponder->typeTemplate) && $autoresponder->typeTemplate=="Email/SMS") ? 'selected':''}} value="Email/SMS">Both</option>
                               
                            </select>
</div>
@if(!empty($emailtemplates))
<div class="form-group">
    <label class="form-control-label">Email Template </label>
    <select class="form-control"  name="email_template_id" >
                                <option  value="">Select Type</option>
                                @foreach($emailtemplates as $template)
                                <option {{(!empty($template->id) && !empty($autoresponder->email_template_id) && $template->id==$autoresponder->id) ? 'selected':''}} value="{{$template->id}}">{{$template->name}}</option>
                                @endforeach
                       
                            </select>
</div>
@endif

<div class="form-group" id="custom_message_div">
        <div class="row">
            <div class="col-md-12">
                <label class="form-control-label">Type Your Custom Email message</label>
                <textarea  class="form-control" id="custom_message" name="custom_message">{{$autoresponder->custom_message??''}}</textarea>
            </div>
        </div>
    </div>
<div class="form-group " id="custom_sms_div">
        <div class="row">
            <div class="col-md-12">
                <label class="form-control-label">Type Your Custom SMS message</label>
                <textarea  class="form-control" rows="4" maxlength="255" id="custom_sms" name="custom_sms">{{$autoresponder->custom_sms??''}}</textarea>
            </div>
        </div>
    </div>
</div>
<div class="form-group">
    <label class="form-control-label">Select Folder</label>
    <select class="form-control" name="folder">
        @foreach($folders as $folder)
            <option {{!empty($autoresponder->folder) && $autoresponder->folder==$folder->id ? 'selected':''}} value="{{$folder->id}}"  >{{$folder->name}}</option>
        @endforeach
    </select>
</div>


<div class="form-group">
    <label class="form-control-label">Type</label>
    <select id="changeasaction" class="form-control" name="typeOnChoice" required="">
        <option value="">Please select type..</option>
        <option {{!empty($autoresponder->typeOnChoice) && $autoresponder->typeOnChoice=="Weekly" ? 'selected':''}} value="Weekly">Weekly</option>
        <option {{!empty($autoresponder->typeOnChoice) && $autoresponder->typeOnChoice=="Singleday" ? 'selected':''}} value="Singleday">Single day</option>
    </select>
</div>

<div class="form-group d-none" id="set_day">
<label class="form-control-label">Set Your day</label>
<select id="select2_basic" class="js-example-basic-multiple form-control select2" name="day[]" multiple="multiple">
    <option {{!empty($autoresponder->day) && in_array("Monday",json_decode($autoresponder->day)) ? 'selected':''}} value="Monday">Monday</option>
    <option {{!empty($autoresponder->day) && in_array("Tuesday",json_decode($autoresponder->day)) ? 'selected':''}} value="Tuesday">Tuesday</option>
    <option {{!empty($autoresponder->day) && in_array("Wednesday",json_decode($autoresponder->day)) ? 'selected':''}} value="Wednesday">Wednesday</option>
    <option {{!empty($autoresponder->day) && in_array("Thursday",json_decode($autoresponder->day)) ? 'selected':''}} value="Thursday">Thursday</option>
    <option {{!empty($autoresponder->day) && in_array("Friday",json_decode($autoresponder->day)) ? 'selected':''}} value="Friday">Friday</option>
    <option {{!empty($autoresponder->day) && in_array("Saturday",json_decode($autoresponder->day)) ? 'selected':''}} value="Saturday">Saturday</option>
    <option {{!empty($autoresponder->day) && in_array("Sunday",json_decode($autoresponder->day)) ? 'selected':''}} value="Sunday">Sunday</option>
</select>
</div>
<div class="form-group d-none" id="set_time">
    <div class="row">
        <div class="col-md-6">
        <label class="form-control-label">Date</label>
            <input type="date" value="{{$autoresponder->date??''}}" class="form-control" name="date">
        </div>
        <div class="col-md-6">
        <label class="form-control-label">Set Your Time</label>
         <input type="time" id="appt" class="form-control" value="{{$autoresponder->time??''}}" name="time">

        </div>
    </div>
</div>
<div class="form-group">
    <label class="form-control-label">Status</label>
    <select class="form-control" name="status" required="">
        <option {{!empty($autoresponder->status) && $autoresponder->status=="Active" ? 'selected':''}} value="Active">Active</option>
        <option {{!empty($autoresponder->status) && $autoresponder->status=="Inactive" ? 'selected':''}} value="Inactive">Inactive</option>
    </select>
</div>
<div class="text-right">
    {{ Form::button(__('Save'), ['type' => 'submit','class' => 'btn btn-sm btn-primary rounded-pill']) }}
    <button type="button" class="btn btn-sm btn-secondary rounded-pill" data-dismiss="modal">{{__('Cancel')}}</button>
</div>
{{ Form::close() }}
<script src="{{ asset('public/ckeditor/ckeditor.js') }}"></script>

<script>
CKEDITOR.replace('custom_message');

</script>
<script>
      
   // CKEDITOR.replace('summary-ckeditor');
  
   
    $(document).ready(function() {
      
   
   
         @php
   if(!empty($autoresponder->typeOnChoice)){
   @endphp
        changeasaction();
        changetype();
           @php
   }
   @endphp
   
$(document).on("change", "#changeasaction", function(){
       changeasaction();
        });
$(document).on("change", "#typeTemplate", function(){
       changetype();
        });
        
        
         $('#select2_basic').select2({width:'100%'});
    });
function changetype(){
     //$('#changeasaction').on('change', function() {
//           alert( this.value );
var change_val= $("#typeTemplate").val();
          if(change_val == 'Email/SMS'){
            $('#custom_message_div').removeClass('d-none');
            $('#custom_sms_div').removeClass('d-none');
          }else if (change_val == 'SMS') {
                $('#custom_sms_div').removeClass('d-none');
                $('#custom_message_div').addClass('d-none');
          }else{
            $('#custom_sms_div').addClass('d-none');
                $('#custom_message_div').removeClass('d-none');
          }
}
function changeasaction(){
     //$('#changeasaction').on('change', function() {
//           alert( this.value );
var change_val= $("#changeasaction").val();
          if(change_val == 'Singleday'){
            $('#set_time').removeClass('d-none');
            $('#set_day').addClass('d-none');
          }else if (change_val == 'Weekly') {
                $('#set_day').removeClass('d-none');
                $('#set_time').addClass('d-none');
          }else{
            $('#set_time').addClass('d-none');
            $('#set_day').addClass('d-none');
          }
}

</script>









