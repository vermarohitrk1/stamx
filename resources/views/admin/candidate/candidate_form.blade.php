@php
    /**
     * @var App\Candidate $data
    */
@endphp
<form action="{{ route('admin.candidates.create') }}" method="post">
    @csrf
    <input class="form-control" type="hidden" value="{{!empty($data->id) ? encrypted_key($data->id, "encrypt"):''}}" name="id">
    <div class="form-group row">
        <label for="firstName" class="col-sm-2 col-form-label">{{__("First name")}}</label>
        <div class="col-sm-10">
            <input type="text"  class="form-control" id="firstName" name="first_name" required value="{{!empty($data->first_name) ? $data->first_name:''}}">
        </div>
    </div>
    <div class="form-group row">
        <label for="lastName" class="col-sm-2 col-form-label">{{__("Last name")}}</label>
        <div class="col-sm-10">
            <input type="text"  class="form-control" id="lastName" name="last_name" required value="{{!empty($data->last_name) ? $data->last_name:''}}">
        </div>
    </div>
    <div class="form-group row">
        <label for="email" class="col-sm-2 col-form-label">{{__("Email")}}</label>
        <div class="col-sm-10">
            <input type="email"  class="form-control" id="email" name="email" required value="{{!empty($data->email) ? $data->email:''}}">
        </div>
    </div>
    <div class="form-group row">
        <label for="gender" class="col-sm-2 col-form-label">{{__("Gender")}}</label>
        <div class="col-sm-10">
            <div class="form-check form-check-inline ml-3">
                <input class="form-check-input" type="radio" required name="gender" id="male" value="male"  @if(!empty($data->gender) && $data->gender=="male") checked @endif>
                <label class="form-check-label" for="male">{{__("Male")}}</label>
            </div>
            <div class="form-check form-check-inline ml-3">
                <input class="form-check-input" type="radio" name="gender" id="female" value="female" @if(!empty($data->gender) && $data->gender=="female") checked @endif>
                <label class="form-check-label" for="female">{{__("Female")}}</label>
            </div>
            <div class="form-check form-check-inline ml-3">
                <input class="form-check-input" type="radio" name="gender" id="other" value="others" @if(!empty($data->gender) && $data->gender=="others") checked @endif>
                <label class="form-check-label" for="other">{{__("Others")}}</label>
            </div>
        </div>
    </div>
    <div class="form-group row">
        <label for="datetimepicker4" class="col-sm-2 col-form-label ">{{__("DOB")}}</label>
        <div class="input-group col-sm-10 input-append date"  data-target-input="nearest">
            <input type="date" name="dob" required class="form-control datetimepicker-input" id="datetimepicker4"  data-target="#datetimepicker4" data-toggle="datetimepicker" value="{{!empty($data->dob) ? date("Y-m-d", strtotime($data->dob)) : ''}}"/>
        </div>
    </div>
    @if(empty($data->id))
        <div class="form-group row">
            <label for="jobpost" class="col-sm-2 col-form-label">Job Post</label>
            <div class="col-sm-10">
                {{Form::select('jobpost', $data->getJobPost(), $data->jobpost, ["class" => 'form-control'])}}
            </div>
        </div>
    @endif

    <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        <button type="submit" class="btn btn-primary">Save changes</button>
    </div>
</form>
<script type="text/javascript">
    // $(document).ready(function () {
    //     $(function () {
    //         $('#datetimepicker4').datetimepicker({
    //             format: 'DD-MM-YYYY'
    //         });
    //     });
    // });
</script>
