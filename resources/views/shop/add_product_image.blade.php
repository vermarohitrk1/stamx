{{ Form::open(['route' => 'shop.productimgstore','enctype' => 'multipart/form-data']) }}


    
    <div class="form-group">
        <div class="row">
            <input type="hidden" name="csrf-token" value="<?=csrf_token();?>" />
            <div class="col-12 col-md-12">
                {{ Form::label('image', __('Attach product image:'),['class' => 'form-control-label']) }}
                <input type="file" name="image" id="image" class="custom-input-file croppie" crop-width="600" crop-height="600"  accept="image/*" required=""/>
                <label for="image">
                    <i class="fa fa-upload"></i>
                    <span>{{__('Choose a file…')}}</span>
                </label>
            </div>
        </div>
    </div>
    
</div>
<div class="text-right">
    {{ Form::button(__('Save'), ['type' => 'submit','class' => 'btn btn-sm btn-primary rounded-pill']) }}
    <button type="button" class="btn btn-sm btn-secondary rounded-pill" data-dismiss="modal">{{__('Cancel')}}</button>
</div>
{{ Form::close() }}


<link rel="stylesheet" type="text/css" href="{{ asset('assets/css/simcify.min.css') }}">
<script src="{{ asset('assets/js/simcify.min.js') }}"></script>
<!--<script src="{{ asset('public/ckeditor/ckeditor.js') }}"></script>-->

<script>
//CKEDITOR.replace('summary-ckeditor');
</script>








