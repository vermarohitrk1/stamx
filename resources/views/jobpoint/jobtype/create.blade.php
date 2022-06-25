
{{ Form::open(['url' => route("admin.jobType.store"),'method' => 'POST']) }}
{{-- {{ Form::open(['controller' => 'JobTypeController@jobTypeCreate', 'method' => 'POST']) }} --}}
<div class="form-group">
    <div class="row">
        <div class="col-md-12">
            <label class="form-control-label">Name</label>
            {{-- <input type="text" class="form-control" name="name" placeholder="Enter Name"  required> --}}
            <input type="text" class="form-control" name="name" placeholder="Enter Name" value="{{ $jobTypeModel->name }}" required>
            <input type="hidden" name="csrf-token" value="<?=csrf_token();?>" />
        </div>
    </div>
</div>
<div class="form-group">
    <div class="row">
        <div class="col-md-12">
            <label class="form-control-label">Description</label>
            <textarea class="form-control" id="exampleFormControlTextarea1" rows="3" name="description">{{ $jobTypeModel->description }}</textarea>
        </div>
    </div>
</div>
<div class="text-right">
    {{ Form::button(__('Save'), ['type' => 'submit','class' => 'btn btn-sm btn-primary rounded-pill']) }}
    <button type="button" class="btn btn-sm btn-secondary rounded-pill" data-dismiss="modal">{{__('Cancel')}}
    </button>
    <input type = 'hidden' name="updateJobType" value="{{ $jobTypeModel->id }}">
    {{-- <input type = 'hidden' name="updateJobType"> --}}
</div>

{{ Form::close() }}

<link rel="stylesheet" type="text/css" href="{{ asset('assets/css/simcify.min.css') }}">
<script src="{{ asset('assets/js/simcify.min.js') }}"></script>
