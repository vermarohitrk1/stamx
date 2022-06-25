{{ Form::open(['url' =>'contacts/store','id' => 'create_contact','enctype' => 'multipart/form-data']) }}

<div class="form-group">
        <div class="row">
            <div class="col-md-6">
                <label class="form-control-label">First Name</label>
                <input type="text" class="form-control" name="fname" placeholder="First Name" required>
                <input type="hidden" name="csrf-token" value="<?=csrf_token();?>" />
            </div>
            <div class="col-md-6">
                <label class="form-control-label">Last Name</label>
                <input type="text" class="form-control" name="lname" placeholder="Last Name" required>
            </div>
        </div>
    </div>
    <div class="form-group">
        <div class="row">
            <div class="col-md-12">
                <label class="form-control-label">Phone Number</label>
                <input type="text" class="form-control" name="phone" placeholder="Phone Number" required>
            </div>
        </div>
    </div>
    <div class="form-group">
        <div class="row">
            <div class="col-md-12">
                <label class="form-control-label">Email Address</label>
                <input type="text" class="form-control" name="email" placeholder="Email Address" required>
            </div>
        </div>
    </div>
    
    <div class="form-group">
        <div class="row">
            <div class="col-md-12">
                <label class="form-control-label">Type</label>
                <select class="form-control" name="type">
                    <option value="Office">Office</option>
                    <option value="Home">Home</option>
                    <option value="Mobile">Mobile</option>
                </select>
            </div>
        </div>
    </div>
    <div class="form-group">
        <div class="row">
            <div class="col-md-12">
                <label class="form-control-label">Select Folder</label>
                <select class="form-control" name="folder">
                    @foreach($folders as $folder)
                        <option value="{{$folder->name}}"  >{{$folder->name}}</option>
                    @endforeach
                </select>
            </div>
        </div>
    </div>
    <div class="form-group">
        <div class="row">
            <div class="col-md-12">
                <label class="form-control-label">Email Subscription</label>
                <select class="select2 form-control" style="width: 100%" id="email_subscription" name="email_subscription[]" multiple="">
                    @foreach($folders as $folder)
                        <option value="{{$folder->id}}"  >{{$folder->name}}</option>
                    @endforeach
                </select>
            </div>
        </div>
    </div>
    <div class="form-group">
        <div class="row">
            <div class="col-md-12">
                <label class="form-control-label">SMS Subscription</label>
                <select class="select2 form-control" style="width: 100%" id="sms_subscription" name="sms_subscription[]" multiple="">
                    @foreach($folders as $folder)
                        <option value="{{$folder->id}}"  >{{$folder->name}}</option>
                    @endforeach
                </select>
            </div>
        </div>
    </div>
<div class="form-group">
        <div class="row">
            <div class="col-md-12">
                    {{ Form::label('image', __('Avatar'),['class' => 'form-control-label']) }}
                <input type="file" name="image" class="custom-input-file croppie" crop-width="100" crop-height="100"  accept="image/*" >
            </div>
        </div>
    </div> 

</div>
<div class="text-right">
    {{ Form::button(__('Save'), ['type' => 'submit','class' => 'btn btn-sm btn-primary rounded-pill']) }}
    <button type="button" class="btn btn-sm btn-secondary rounded-pill" data-dismiss="modal">{{__('Cancel')}}</button>
</div>
{{ Form::close() }}


<link rel="stylesheet" type="text/css" href="{{ asset('assets/css/simcify.min.css') }}">
<script src="{{ asset('assets/js/simcify.min.js') }}"></script>


<script>
    $("#email_subscription").select2();
    $("#sms_subscription").select2();
    </script>






