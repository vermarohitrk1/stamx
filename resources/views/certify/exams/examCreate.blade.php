{{ Form::open(['url' => 'certify/exam/store','id' => 'create_exam','enctype' => 'multipart/form-data']) }}
<div class="form-group">
    <div class="row">
        <div class="col-md-12">
            <label class="form-control-label">Exam Name</label>
            <input type="text" class="form-control" name="title" placeholder="Exam Name" required>
            <input type="hidden" name="certify_id" value="{{$certify}}">
        </div>
    </div>
</div>
<div class="form-group">
    <div class="row">
        <div class="col-md-12">
            <label class="form-control-label">Exam maximum retakes</label>
            <input type="number" name="retakes" class="form-control just-number" placeholder="maximum retakes" value="0" min="0" required="">
        </div>
    </div>
</div>
<div class="form-group">
    <div class="row">
        <div class="col-md-12">
            <label class="form-control-label">Course Description</label>
            <textarea class="form-control"  name="description" placeholder="Exam Description" rows="5"
              required></textarea>
        </div>
    </div>
</div>
<div class="text-right">
    {{ Form::button(__('Save'), ['type' => 'submit','class' => 'btn btn-sm btn-primary rounded-pill']) }}
    <button type="button" class="btn btn-sm btn-secondary rounded-pill" data-dismiss="modal">{{__('Cancel')}}</button>
</div>
{{ Form::close() }}
