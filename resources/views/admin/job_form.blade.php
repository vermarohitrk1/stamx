@php
    /**
     * @var App\Candidate $data
    */
@endphp

<form action="{{ Route('assign.job') }}" method="post">
    @csrf
    <input class="form-control" type="hidden" value="{{!empty($data->id) ? encrypted_key($data->id, "encrypt"):''}}" name="id">
    <div class="form-group row">
        <label for="firstName" class="col-sm-2 col-form-label">Name</label>
        <div class="col-sm-10">
            <input type="text"  class="form-control" id="firstName"  required value="{{!empty($data->first_name) ? $data->first_name.' '.$data->last_name:''}}" disabled>
        </div>
    </div>
    <div class="form-group row">
        <label for="jobpost" class="col-sm-2 col-form-label">Job Post</label>
        <div class="col-sm-10">
            {{Form::select('jobpost', $data->getJobPost(!empty($data->id) ? encrypted_key($data->id, "encrypt"):''), $data->jobpost, ["class" => 'form-control', "required" => true])}}
        </div>
    </div>
    <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        <button type="submit" class="btn btn-primary">Save</button>
    </div>
</form>


