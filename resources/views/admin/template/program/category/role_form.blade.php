<form method="post" action="{{route('program_category.post')}}" autocomplete="off" enctype="multipart/form-data" class="bv-form">
     @csrf
     <input class="form-control" type="hidden" value="{{!empty($data->id) ? encrypted_key($data->id, "encrypt"):''}}" name="id">
    <div class="form-group">
        <label>Program Category</label>
        <input class="form-control" type="text" value="{{!empty($data->name) ? $data->name:''}}" name="name" id="question_cat" >
   </div>
  
</div>
    

    <div class="mt-4 ">
        <button class="btn btn-primary" name="form_submit" value="submit" type="submit">Save Changes</button>
        <button type="button" class="btn btn-danger" data-dismiss="modal">Cancel</button>
    </div>
</form>
<script>
$(function(){
    $('#question_type_field').hide();
    $("#question_type").change(function () {
        var end = this.value;
      // alert( end );
       if(end == 'text'){
         $('#question_type_field').hide();
       }
       else{
        $('#question_type_field').show();
       }
    });

});
    $("#permissions").select2();
    </script>
    <script type="text/javascript">
$(document).ready(function(){
    var maxField = 10; //Input fields increment limitation
    var addButton = $('.add_button'); //Add button selector
    var wrapper = $('.field_wrapper'); //Input field wrapper
    var fieldHTML = '<div><input type="text" name="value[]" value=""/><a href="javascript:void(0);" class="remove_button"><img src="http://demos.codexworld.com/add-remove-input-fields-dynamically-using-jquery/images/remove-icon.png"/></a></div>'; //New input field html 
    var x = 1; //Initial field counter is 1
    
    //Once add button is clicked
    $(addButton).click(function(){
        //Check maximum number of input fields
        if(x < maxField){ 
            x++; //Increment field counter
            $(wrapper).append(fieldHTML); //Add field html
        }
    });
    
    //Once remove button is clicked
    $(wrapper).on('click', '.remove_button', function(e){
        e.preventDefault();
        $(this).parent('div').remove(); //Remove field html
        x--; //Decrement field counter
    });
});
</script>