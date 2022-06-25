{{ Form::open(['route' => 'certify.categories.store','id' => 'create_certify_categories','enctype' => 'multipart/form-data']) }}
<div class="form-group">
    <div class="row">
        <div class="col-md-12">
            <label class="form-control-label">Category Name</label>
            <input type="text" class="form-control" name="name" placeholder="Category Name" required>
            <input type="hidden" name="csrf-token" value="<?=csrf_token();?>" />
        </div>
    </div>
</div>
<div class="form-group">
    <div class="row">
        <div class="col-md-12">
            <label class="form-control-label">Icon</label>

            <input type="file" name="image" class="custom-input-file croppie" crop-width="57" crop-height="42"  accept="image/*" required="" >       
        </div>
    </div>
</div>
<div class="text-right">
    {{ Form::button(__('Save'), ['type' => 'submit','class' => 'btn btn-sm btn-primary rounded-pill']) }}
    <button type="button" class="btn btn-sm btn-secondary rounded-pill" data-dismiss="modal">{{__('Cancel')}}</button>
</div>
{{ Form::close() }}
<style>
    .modal-content {
    margin: 75px;
    width: 76%;
    }
</style>

 <link rel="stylesheet" type="text/css" href="{{ asset('assets/css/simcify.min.css') }}">
<script src="{{ asset('assets/js/simcify.min.js') }}"></script>