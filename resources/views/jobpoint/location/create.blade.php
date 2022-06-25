
{{ Form::open(['url' => route("admin.location.store"),'method' => 'POST']) }}
{{-- {{ Form::open(['controller' => 'LocationController@locationCreate', 'method' => 'POST']) }} --}}
<div class="form-group">
    <div class="row">
        <div class="col-md-12">
            <label class="form-control-label">Address</label>
            {{-- <input type="text" class="form-control" name="name" placeholder="Enter Address"  required> --}}
            <input type="text" class="form-control" name="address" placeholder="Enter Address" value="{{ $locationModel->address }}" required>
            <input type="hidden" name="csrf-token" value="<?=csrf_token();?>" />
        </div>
    </div>
</div>

<div class="text-right">
    {{ Form::button(__('Save'), ['type' => 'submit','class' => 'btn btn-sm btn-primary rounded-pill']) }}
    <button type="button" class="btn btn-sm btn-secondary rounded-pill" data-dismiss="modal">{{__('Cancel')}}
    </button>
    <input type = 'hidden' name="updateLocation" value="{{ $locationModel->id }}">
    {{-- <input type = 'hidden' name="updateLocation"> --}}
</div>

{{ Form::close() }}

<link rel="stylesheet" type="text/css" href="{{ asset('assets/css/simcify.min.css') }}">
<script src="{{ asset('assets/js/simcify.min.js') }}"></script>
