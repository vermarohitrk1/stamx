{{ Form::open(['url' => 'certify/curriculumSave','id' => 'create_curriculum','enctype' => 'multipart/form-data']) }}

<div class="form-group">
    <div class="row">
        <div class="col-md-12">
            <label class="form-control-label">Chapter Name</label>
            <input type="text" class="form-control" name="title" placeholder="Chapter Name" required>
            <input type="hidden" name="certify_id" value="{{$id}}">
        </div>
    </div>
</div>
<div class="form-group">
    <div class="row">
        <div class="col-md-12">
            <label class="form-control-label">Course Description</label>
            <textarea class="form-control" id="summary-ckeditor" name="description" placeholder="Course Description" rows="5"
              required></textarea>
        </div>
    </div>
</div>
<div class="form-group">
    <div class="row">
        <div class="col-md-12">
            <label class="form-control-label">Type</label>
            <select class="form-control" name="type" id="chapter_type">
                @foreach($model->getChapterType() as $key => $type)
                    <option value="{{$key}}">{{$type}}</option>
                @endforeach
            </select>
        </div>
    </div>
</div>
<div class="text-right">
    {{ Form::button(__('Save'), ['type' => 'submit','class' => 'btn btn-sm btn-primary rounded-pill']) }}
    <button type="button" class="btn btn-sm btn-secondary rounded-pill" data-dismiss="modal">{{__('Cancel')}}</button>
</div>
{{ Form::close() }}

<script src="{{ asset('public/ckeditor/ckeditor.js') }}"></script>
<script>
CKEDITOR.replace( 'summary-ckeditor' );
</script>
