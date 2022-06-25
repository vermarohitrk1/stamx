<style>

span.photobooth._note {
    color: red;
}
</style>

{{ Form::open(['url' =>'photobooth/upload','id' => 'Photobooth_Template','enctype' => 'multipart/form-data']) }}

<div class="form-group">
        <div class="row">
            <div class="col-md-12">
                <label class="form-control-label">Title</label>
                <input type="text" class="form-control" name="title" placeholder="Title" required>
            </div>
        </div>
    </div>
    <div class="form-group">
        <div class="row">
            <div class="col-md-12">
                <label class="form-control-label">Type</label>
                <select id="type" class="form-control" name="type" required>
                    <!-- <option value="">Select type</option> -->
                    <option value="frame"> Frame</option>
                    <option value="photo">Photo</option>
                    <option value="sticker">Sticker</option>
                    <option value="gif">Gif</option>
                </select>
            </div>
        </div>
    </div>
    <div class="form-group" id="category">
        <div class="row">
            <div class="col-md-12">
                <label class="form-control-label">Category</label>
                <select  class="form-control" name="category" required>
                    <!-- <option value="">Select type</option> -->
                    <option value="1">Baby</option>
                    <option value="2">Back 2 School</option>
                    <option value="3">Birthday</option>
                    <option value="4">Christmas</option>
                    <option value="5">Father Day</option>
                    <option value="6">Valentine Day</option>
                    <option value="7">Sports</option>
                </select>
            </div>
        </div>
    </div>
    <div class="form-group">
        <div class="row">
            <div class="col-md-12">
                <label class="form-control-label">Status</label>
                <select class="form-control" name="status" required>
                    <option value="">Select status</option>
                    <option value="Active">Active</option>
                    <option value="Inactive">Inactive</option>
                </select>
            </div>
        </div>
    </div>
  

  <div  class="form-group">
        <div class="row">
            <div class="col-md-12">
                    {{ Form::label('logo', __('Photobooth Template'),['class' => 'form-control-label']) }}

                <input type="file" name="file" class="custom-input-file croppie" crop-width="600" crop-height="600"  accept="image/*" required="">

            </div>

        </div>
    </div>
     <span class="photobooth _note"><strong>Note: </strong>Please upload the image of resolution 650X500.</span>



</div>
<div class="text-right">
    {{ Form::button(__('Save'), ['type' => 'submit','class' => 'btn btn-sm btn-primary rounded-pill']) }}
    <button type="button" class="btn btn-sm btn-secondary rounded-pill" data-dismiss="modal">{{__('Cancel')}}</button>
</div>
{{ Form::close() }}


<link rel="stylesheet" type="text/css" href="{{ asset('assets/css/simcify.min.css') }}">
<script src="{{ asset('assets/js/simcify.min.js') }}"></script>
<script>
   $( document ).ready(function() {
    $("#type").change(function () {
    
     if( this.value == 'photo'){
         $('#category').hide();

     }
     else{
        $('#category').show();
 
     }
    });
});

</script>











