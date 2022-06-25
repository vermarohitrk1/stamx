<form method="post" action="{{route('task.post')}}" autocomplete="off" enctype="multipart/form-data" class="bv-form">
     @csrf
     <input class="form-control" type="hidden" value="{{ $id }}" name="pathway_id">
    <div class="form-group">
        <label>Name</label>
        <input class="form-control" type="text" value="" name="name" id="name" required>
   </div>
   <div class="form-group">
        <label>Description</label>
        <textarea id="summary-ckeditor" class="form-control" name="description" required></textarea>
   </div>
   <div class="form-group">
                    <label class="form-control-label">Task Category</label>
                    <select class="form-control"  name="category_id" required>
                        @foreach($taskcategory as $key => $category)
                           <option value="{{ $category->id }}">{{ $category->name }}</option>
                        @endforeach
                  </select>
     
    </div>
    <div class="form-group">
        <label>Due Date</label>
        <div class='input-group date' id='datetimepicker1'>
               <input type='date' min="{{ date('Y-m-d') }}" class="form-control" name="due_date" required/>
               <span class="input-group-addon">
               <span class="glyphicon glyphicon-calendar"></span>
               </span>
            </div>

   </div>
  
<div class="form-group">
    <div class="row">
        <div class="col-md-12" style="display: inline-flex;">
            <input type="checkbox" name="authoritylabel" value="1" class=""  />
            &nbsp;&nbsp;&nbsp;&nbsp;<label class="form-control-label">Add Image</label>
        </div>
    </div>
</div>

<div class="form-group alllogofield">
    <div class="row">
        <div class="col-md-12">

            <label> Image</label>
<input type="file" name="image" class="custom-input-file croppie" crop-width="400" crop-height="400"  accept="image/*" placeholder="Logo" >
        
        </div>
    </div>
</div>
<div class="form-group allfilefield" >
    <div class="row">
        <div class="col-md-12">
            <label class="form-control-label">Upload  File</label>

            <input type="file"  name="attachment"  class="form-control dropify" placeholder="Upload  File" accept="application/msword, application/vnd.ms-excel, application/vnd.ms-powerpoint,
text/plain, application/pdf, image/*" required>
        </div>
    </div>
</div>

    <div class="mt-4 ">
        <button class="btn btn-primary" name="form_submit" value="submit" type="submit">Add Task</button>
        <button type="button" class="btn btn-danger" data-dismiss="modal">Cancel</button>
    </div>
</form>


<link rel="stylesheet" type="text/css" href="{{ asset('assets/css/simcify.min.css') }}">
<script src="{{ asset('assets/js/simcify.min.js') }}"></script>

<script src="{{ asset('public/ckeditor/ckeditor.js') }}"></script>
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
        $('.alllogofield').hide();
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