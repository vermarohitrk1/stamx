
{{ Form::open(['url' => 'cms','id' => 'create_page','enctype' => 'multipart/form-data','method'=>'post']) }}
<div class="row">
    <div class="col-12 col-md-12">
        <div class="form-group">
            {{ Form::label('page_name', __('Page name'),['class' => 'form-control-label']) }}
            {{ Form::text('page_name', null, ['class' => 'form-control','required'=>'required']) }}
        </div>
    </div>
</div>
<div class="form-group">
    <div class="row">
        <div class="col-md-12">
            <label class="form-control-label">Status</label>
            <select class="form-control" name="status">
                <option value="Published">Published</option>
                <option value="Unpublished">Unpublished</option>
            </select>
        </div>
    </div>
</div>
 <div class="form-group">
	<div class="row">
		<div class="col-md-12">
			<label class="form-control-label">Banner Image</label>
			<input type="file" name="image" class="custom-input-file croppie" crop-width="900" crop-height="400"  accept="image/*"  >
		</div>
	</div>
</div>
<div class="form-group">
	<div class="row">
		<div class="col-md-12">
			<label class="form-control-label">Header Text Color</label>
            <input id="color-picker" value='#276cb8' class="form-control" name="color"/>
		</div>
	</div>
</div>
<div class="form-group">
    <div class="row">
        <div class="col-md-12">
            <label class="form-control-label">Title</label>
            <input  type="text"  class="form-control" name="title"/>
        </div>
    </div>
</div>
<div class="form-group">
    <div class="row">
        <div class="col-md-12">
            <label class="form-control-label">Subtitle</label>
            <input  type="text"  class="form-control" name="subtitle"/>
        </div>
    </div>
</div>
<div class="form-group">
    <div class="row">
        <div class="col-md-12">
            <label class="form-control-label">Page Data</label>
            <textarea class="form-control" id="summary-ckeditor" name="page_data"  placeholder="Book Description" rows="10" required></textarea>
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
<script src="{{ asset('public/ckeditor/ckeditor.js') }}"></script>

<script type="text/javascript">
    CKEDITOR.replace('summary-ckeditor');
    $( document ).ready(function() {
        $('#color-picker').spectrum({
            type: "component"
        });
    });
</script>
