{{ Form::open(['url' => route("admin.jobpoint.store"),'method' => 'POST']) }}
<div class="form-group">
    <div class="row">
        <div class="col-md-12">
            <label class="form-control-label">Job Title</label>
            {{ Form::text('job_title', $job->job_title, ["class" => "form-control", "placeholder" => "Enter Title", "required" => true]) }}
            <input type="hidden" name="csrf-token" value="<?=csrf_token();?>" />
        </div>
    </div>
</div>
<div class="form-group">
    <div class="row">
        <div class="col-md-12">
            <label class="form-control-label">Job Type</label>
            {{ Form::select('job_type', $job->getJobType(), $job->job_type, ["class" => "form-control"]) }}
        </div>
    </div>
</div>
<div class="form-group">
    <div class="row">
        <div class="col-md-12">
            <label class="form-control-label">Department</label>
            {{ Form::select('department', $job->getDepartment(), $job->department, ["class" => "form-control"]) }}
        </div>
    </div>
</div>
<div class="form-group">
    <div class="row">
        <div class="col-md-12">
            <label class="form-control-label">Location</label>
            {{ Form::select('location', $job->getLocation(), $job->location, ["class" => "form-control"]) }}
        </div>
    </div>
</div>
<div class="form-group">
    <div class="row">
        <div class="col-md-12">
            <label class="form-control-label">Description</label>
            {{ Form::textarea('description',$job->description,['class'=>'form-control', 'rows' => 2, 'cols' => 40]) }}
        </div>
    </div>
</div>
<div class="form-group">
    <div class="row">
        <div class="col-md-12">
            <label class="form-control-label">Salary</label>
            {{ Form::text('salary', $job->salary, ["class" => "form-control", "placeholder" => "Enter Salary", "required" => true]) }}

        </div>
    </div>
</div>
<div class="form-group">
    <div class="row">
        <div class="col-md-12">
            <label class="form-control-label">Last Submission</label>
            <input type="date" value="{{ $job->last_submission }}" class="form-control" name="last_submission">

        </div>
    </div>
</div>
<div class="text-right">
    {{ Form::button(__('Save'), ['type' => 'submit','class' => 'btn btn-sm btn-primary rounded-pill']) }}
        <button type="button" class="btn btn-sm btn-secondary rounded-pill" data-dismiss="modal">{{__('Cancel')}}</button>
    {{ Form::hidden('updateJobApplication', $job->id) }}
</div>

{{ Form::close() }}

<link rel="stylesheet" type="text/css" href="{{ asset('assets/css/simcify.min.css') }}">
<script src="{{ asset('assets/js/simcify.min.js') }}"></script>
