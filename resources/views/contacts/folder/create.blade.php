{{ Form::open(['url' =>'contacts/folder/store','id' => 'create_folder','enctype' => 'multipart/form-data']) }}

<div class="form-group">
        <div class="row">
            <div class="col-md-12">
                <label class="form-control-label">Name</label>
                <input type="text" class="form-control" name="name" placeholder="Name" required>
                <input type="hidden" name="csrf-token" value="<?=csrf_token();?>" />
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


<script src="{{ asset('public/ckeditor/ckeditor.js') }}"></script>

<script>
</script>









