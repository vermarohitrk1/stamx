<form method="post" action="{{route('task.update')}}" autocomplete="off" enctype="multipart/form-data" class="bv-form">
     @csrf
     <input class="form-control" type="hidden" value="{{ $task->id }}" name="task_id">
    <div class="form-group">
        <label>Name</label>
        <input class="form-control" type="text" value="{{ $task->name }}" name="name" id="name" >
   </div>

   <div class="form-group">
        <label>Description</label>
        <textarea id="summary-ckeditor" class="form-control" name="description">{{ $task->description }}</textarea>
   </div>
   <div class="form-group">
                    <label class="form-control-label">Task Category</label>
                    <select class="form-control"  name="category_id">
                     
                        @foreach($taskcategory as $key => $category)
                           <option   @if( $task->category_id == $category->id) selected @endif value="{{ $category->id }}">{{ $category->name }}</option>
                        @endforeach
                    </select>
     
    </div>
    <div class="form-group">
        <label>Due Date</label>
        <div class='input-group date' id='datetimepicker1'>
               <input type='date' min="{{ date('Y-m-d') }}" value="{{  $task->due_date }}" class="form-control" name="due_date"/>
               <span class="input-group-addon">
               <span class="glyphicon glyphicon-calendar"></span>
               </span>
            </div>

   </div>



<div class="form-group">
    <div class="row">
        <div class="col-md-12" style="display: inline-flex;">
            <input type="checkbox" name="authoritylabel" value="1" class="" @if( $task->image != null) checked @endif />
            &nbsp;&nbsp;&nbsp;&nbsp;<label class="form-control-label">Add Image</label>
        </div>
    </div>
</div>

<div class="form-group alllogofield" @if( $task->image == null) style="display:none;" @endif>
    <div class="row">
        <div class="col-md-12">

            <label> Image</label>
            @if(!empty($task->image))
                            
              <input type="file" name="image" class="custom-input-file croppie" default="{{asset('storage')}}/task/{{ $task->image }}" crop-width="1000" crop-height="400"  accept="image/*">
              @else
             <input type="file" name="image" class="custom-input-file croppie" crop-width="1000" crop-height="400"  accept="image/*" required="" >
             @endif         
        </div>
    </div>
</div>
<div class="form-group allfilefield"  @if( $task->attachment == null) style="display:none;" @endif >
    <div class="row">
        <div class="col-md-12">
            <label class="form-control-label">Upload  File</label>

            <input type="file" data-default-file="{{asset('storage')}}/{{ $task->attachment }}"  name="attachment"  class="form-control dropify" placeholder="Upload  File" accept="application/msword, application/vnd.ms-excel, application/vnd.ms-powerpoint,
text/plain, application/pdf, image/*" >
        </div>
    </div>
</div>
    <div class="mt-4 ">
        <button class="btn btn-primary" name="form_submit" value="submit" type="submit">Update Task</button>
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