<form method="post" action="{{route('chore.update')}}" autocomplete="off" enctype="multipart/form-data" class="bv-form">
     @csrf
     <input class="form-control" type="hidden" value="{{ $chore->id }}" name="chore_id">
    <div class="form-group">
        <label>Name</label>
        <input class="form-control" type="text" value="{{ $chore->name }}" name="name" id="name" >
   </div>

   <div class="form-group">
        <label>Description</label>
        <textarea id="summary-ckeditor" class="form-control" name="description">{{ $chore->description }}</textarea>
   </div>
   <div class="form-group">
                    <label class="form-control-label">Task Category</label>
                    <select class="form-control"  name="category_id">
                     
                        @foreach($chorecategory as $key => $category)
                           <option   @if( $chore->type == $category->id) selected @endif value="{{ $category->id }}">{{ $category->name }}</option>
                        @endforeach
                    </select>
     
    </div>
    <div class="form-group">
    <label class="form-control-label">Type</label>
    <select id="changeasaction" class="form-control" name="typeOnChoice" required="">
        <option value="">Please select type..</option>
        <option {{!empty($chore->typeOnChoice) && $chore->typeOnChoice=="Singleday" ? 'selected':''}} value="Singleday">Single day</option>
        <option {{!empty($chore->typeOnChoice) && $chore->typeOnChoice=="Weekly" ? 'selected':''}} value="Weekly">Weekly</option>
        <option {{!empty($chore->typeOnChoice) && $chore->typeOnChoice=="Monthly" ? 'selected':''}} value="Monthly">Monthly</option>
    </select>
</div>

<div class="form-group d-none" id="set_day">
<label class="form-control-label">Set Your day</label>
<select id="select2_basic" class="js-example-basic-multiple form-control select2" name="day[]" multiple="multiple">
    <option {{!empty($chore->day) && in_array("Monday",json_decode($chore->day)) ? 'selected':''}} value="Monday">Monday</option>
    <option {{!empty($chore->day) && in_array("Tuesday",json_decode($chore->day)) ? 'selected':''}} value="Tuesday">Tuesday</option>
    <option {{!empty($chore->day) && in_array("Wednesday",json_decode($chore->day)) ? 'selected':''}} value="Wednesday">Wednesday</option>
    <option {{!empty($chore->day) && in_array("Thursday",json_decode($chore->day)) ? 'selected':''}} value="Thursday">Thursday</option>
    <option {{!empty($chore->day) && in_array("Friday",json_decode($chore->day)) ? 'selected':''}} value="Friday">Friday</option>
    <option {{!empty($chore->day) && in_array("Saturday",json_decode($chore->day)) ? 'selected':''}} value="Saturday">Saturday</option>
    <option {{!empty($chore->day) && in_array("Sunday",json_decode($chore->day)) ? 'selected':''}} value="Sunday">Sunday</option>
</select>
</div>
<div class="form-group d-none" id="set_time">
    <div class="row">
        
        <div class="col-md-6">
        <label class="form-control-label">Due Date</label>
            <input type="date" value="{{$chore->start_date??''}}" class="form-control" name="start_date">
        </div>
        <div class="col-md-6" id="end_date">
        <label class="form-control-label">End Date</label>
            <input type="date" value="{{$chore->end_date??''}}" class="form-control" name="end_date">
        </div>
        <div class="col-md-6">
        <label class="form-control-label">Chore Start Time</label>
         <input type="time" id="start_time" class="form-control" value="{{$chore->start_time??''}}" name="start_time">

        </div>
        <div class="col-md-6">
        <label class="form-control-label">Chore End Time</label>
         <input type="time" id="end_time" class="form-control" value="{{$chore->end_time??''}}" name="end_time">

        </div>
    </div>
</div>
  <div class="form-group">
                        <div class="row">
                            <div class="col-md-12">
                                <label class="form-control-label">Status</label>
                                <select class="form-control" name="status" >
                                    <option {{!empty($chore->status) && $chore->status=="Active" ? 'selected' :''}}  value="Active">Active</option>
                                    <option {{!empty($chore->status) && $chore->status=="Inactive" ? 'selected' :''}} value="Inactive">Inactive</option>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="row">
                            <div class="col-md-12">
                                <label class="form-control-label">Priority</label>
                                <select class="form-control" name="priority" >
                                    <option {{!empty($chore->priority) && $chore->priority=="Low" ? 'selected' :''}}  value="Low">Low</option>
                                    <option {{!empty($chore->priority) && $chore->priority=="High" ? 'selected' :''}} value="High">High</option>
                                </select>
                            </div>
                        </div>
                    </div>



<div class="form-group">
    <div class="row">
        <div class="col-md-12" style="display: inline-flex;">
            <input type="checkbox" name="authoritylabel" value="1" class="" @if( $chore->image != null) checked @endif />
            &nbsp;&nbsp;&nbsp;&nbsp;<label class="form-control-label">Add Image</label>
        </div>
    </div>
</div>

<div class="form-group alllogofield" @if( $chore->image == null) style="display:none;" @endif>
    <div class="row">
        <div class="col-md-12">

            <label> Image</label>
            @if(!empty($chore->image))
                            
              <input type="file" name="image" class="custom-input-file croppie" default="{{asset('storage')}}/chore/{{ $chore->image }}" crop-width="1000" crop-height="400"  accept="image/*">
              @else
             <input type="file" name="image" class="custom-input-file croppie" crop-width="1000" crop-height="400"  accept="image/*" required="" >
             @endif         
        </div>
    </div>
</div>
<div class="form-group allfilefield"  @if( $chore->attachment == null) style="display:none;" @endif >
    <div class="row">
        <div class="col-md-12">
            <label class="form-control-label">Upload  File</label>

            <input type="file" data-default-file="{{asset('storage')}}/{{ $chore->attachment }}"  name="attachment"  class="form-control dropify" placeholder="Upload  File" accept="application/msword, application/vnd.ms-excel, application/vnd.ms-powerpoint,
text/plain, application/pdf, image/*" >
        </div>
    </div>
</div>
    <div class="mt-4 ">
        <button class="btn btn-primary" name="form_submit" value="submit" type="submit">Update Chore</button>
        <button type="button" class="btn btn-danger" data-dismiss="modal">Cancel</button>
    </div>
</form>
<link rel="stylesheet" type="text/css" href="{{ asset('assets/css/simcify.min.css') }}">
<script src="{{ asset('assets/js/simcify.min.js') }}"></script>
<script src="{{ asset('assets/libs/dragula/dist/dragula.min.js') }}"></script>

<link rel="stylesheet" type="text/css" href="{{ asset('assets/libs/dropify/css/dropify.min.css') }}">
<script src="{{ asset('assets/libs/dropify/js/dropify.min.js') }}"></script>

<script src="{{ asset('public/ckeditor/ckeditor.js') }}"></script>
<script type="text/javascript" src="{{ asset('assets/js/jquery-ui.min.js') }}"></script>
<script type="text/javascript" src="{{ asset('assets/js/repeater.js') }}"></script>
<script>
$( document ).ready(function() {
    CKEDITOR.replace('summary-ckeditor');


  
    $('#send_reminder').on('change', function() {
    //$('input[name=send_reminder]').change(function(){

        var selected =$(this).val();
       if(selected == 'No'){
           $('#remindertype').hide();
       }
       else{
        $('#remindertype').show();
       }
    })
});


</script>
<script>
    $(function () {
        $('input[name="image"]').hide();
      //  $('.alllogofield').hide();
        //show it when the checkbox is clicked
        $('input[name="authoritylabel"]').on('click', function () {
            if ($(this).prop('checked')) {
                $('input[name="image"]').fadeIn();
                $('.alllogofield').fadeIn();
                $('.allfilefield').hide();
            } else {
                $('input[name="image"]').hide();
                $('.alllogofield').hide();
                $('.allfilefield').fadeIn();

                
            }
        });
    });
</script> 
<script>
      
   // CKEDITOR.replace('summary-ckeditor');
  
   
    $(document).ready(function() {
       
   
   
         @php
   if(!empty($chore->typeOnChoice)){
   @endphp
        changeasaction();
           @php
   }
   @endphp
   

$(document).on("change", "#changeasaction", function(){
       changeasaction();
        });
        
        
         $('#select2_basic').select2({width:'100%'});
    });
function changeasaction(){
     //$('#changeasaction').on('change', function() {
//           alert( this.value );
var change_val= $("#changeasaction").val();
          if(change_val == 'Singleday'){
            $('#set_time').removeClass('d-none');
            $('#set_day').addClass('d-none');
            $('#end_date').addClass('d-none');
        }else if(change_val == 'Monthly'){
            $('#set_time').removeClass('d-none');
            $('#end_date').removeClass('d-none');
            $('#set_day').addClass('d-none');
          }else if (change_val == 'Weekly') {
                $('#set_day').removeClass('d-none');
                $('#set_time').removeClass('d-none');
                $('#end_date').removeClass('d-none');
//                $('#set_time').addClass('d-none');
          }else{
            $('#set_time').addClass('d-none');
            $('#set_day').addClass('d-none');
          }
}

</script>