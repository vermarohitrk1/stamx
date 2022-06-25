
{{ Form::open(['url' => route("admin.department.store"),'method' => 'POST']) }}
{{-- {{ Form::open(['controller' => 'DepartmentController@departmentCreate', 'method' => 'POST']) }} --}}
<div class="form-group">
    <div class="row">
        <div class="col-md-12">
            <label class="form-control-label">Name</label>
            {{-- <input type="text" class="form-control" name="name" placeholder="Enter Name"  required> --}}
            <input type="text" class="form-control" name="name" placeholder="Enter Name" value="{{ $departmentModel->name }}" required>
            <input type="hidden" name="csrf-token" value="<?=csrf_token();?>" />
        </div>
    </div>
</div>
<div class="form-group">
    <div class="row">
        <div class="col-md-12">
            <label class="form-control-label">Status</label>
            <select class="form-control" name="status">
            <option>Select Status</option>
                @foreach($getDepartmentStatus as $key => $value)
                <option value="{{$key}}" @if($key == $departmentModel->status)selected @endif>
                    {{$value}}</option>
                    {{-- <option value="{{$key}}"> {{$value}} </option> --}}
                @endforeach
            </select>
        </div>
    </div>
</div>
<div class="text-right">
    {{ Form::button(__('Save'), ['type' => 'submit','class' => 'btn btn-sm btn-primary rounded-pill']) }}
    <button type="button" class="btn btn-sm btn-secondary rounded-pill" data-dismiss="modal">{{__('Cancel')}}
    </button>
    <input type = 'hidden' name="updateDepartment" value="{{ $departmentModel->id }}">
    {{-- <input type = 'hidden' name="updateDepartment"> --}}
</div>

{{ Form::close() }}

<link rel="stylesheet" type="text/css" href="{{ asset('assets/css/simcify.min.css') }}">
<script src="{{ asset('assets/js/simcify.min.js') }}"></script>
