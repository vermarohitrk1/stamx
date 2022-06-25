{{ Form::open(['url' =>'partner/store','id' => 'create_partner','enctype' => 'multipart/form-data']) }}
    <div class="form-group">
        <div class="row">
            <div class="col-md-12">
                    {{ Form::label('logo', __('Partner logo'),['class' => 'form-control-label']) }}

                <input type="file" name="logo" class="custom-input-file croppie" crop-width="191" crop-height="60"  accept="image/*" required="">

            </div>

        </div>
    </div>
<div class="form-group">
        <div class="row">
            <div class="col-md-12">
                <label class="form-control-label">Partner link</label>
                <input type="text" class="form-control" name="link" placeholder="Partner link" required>
                <input type="hidden" name="csrf-token" value="<?=csrf_token();?>" />
            </div>
        </div>
    </div>

    <div class="form-group">
        <div class="row">
            <div class="col-md-12">
                <label class="form-control-label">Status</label>
                <select class="form-control" name="status" required>
                    <option value="">Select Status</option>
                    <option value="Active">Active</option>
                    <option value="Inactive">Inactive</option>
                </select>
            </div>
        </div>
    </div>
{{--    <div class="form-group">--}}
{{--        <div class="row">--}}
{{--            <div class="col-md-12">--}}
{{--                <label class="form-control-label">Add to slider</label><br>--}}
{{--                {!! Form::hidden('add_to_slider',1,1, array('id'=>'radio_user')) !!} {{__('Activate')}}--}}
{{--            </div>--}}
{{--        </div>--}}
{{--    </div>--}}


</div>
<div class="text-right">
    {{ Form::button(__('Save'), ['type' => 'submit','class' => 'btn btn-sm btn-primary rounded-pill']) }}
    <button type="button" class="btn btn-sm btn-secondary rounded-pill" data-dismiss="modal">{{__('Cancel')}}</button>
</div>
{{ Form::close() }}


<link rel="stylesheet" type="text/css" href="{{ asset('assets/css/simcify.min.css') }}">
<script src="{{ asset('assets/js/simcify.min.js') }}"></script>


<script src="{{ asset('public/ckeditor/ckeditor.js') }}"></script>

<script>
CKEDITOR.replace('summary-ckeditor');

    $(document).ready(function() {
        var today = new Date();
        var dd = today. getDate() + 1;
        var mm = today. getMonth() + 1;
        var yyyy = today. getFullYear();
        if (dd < 10) {
            dd = "0" + dd;
        }
        if (mm < 10) {
            mm = "0" + mm;
        }
        var currentDate = yyyy+'-'+mm+'-'+dd;
        $('#expirydate').attr("min",currentDate);
        var check = false;
        $('#dateDiv').hide();
    });
    $(document).on("change","#expire",function() {
         var value = this.value;
        if(value=='yes'){
            check = true;
            $('#expirydate').attr("required", true);
            $('#dateDiv').show();
        }else if(value=='no'){
            check = false;
            $('#expirydate').val('');
            $('#expirydate').attr("required", false);
            $('#dateDiv').hide();
        }
    });
</script>









