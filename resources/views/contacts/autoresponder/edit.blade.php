@extends('layouts.admin')
@section('title')
{{$broadcast->campaign_name}}
@endsection

@push('theme-script')
<script src="{{ asset('assets/libs/bootstrap-tagsinput/dist/bootstrap-tagsinput.min.js') }}"></script>
@endpush

@section('content')
<div class="row">


    {{--Main Part--}}
    <div class="col-lg-12 order-lg-1">
        <div id="tabs-1" class="tabs-card">
            <div class="card">
                <div class="card-header">
                    <h5 class=" h6 mb-0">{{__('Edit Campaign')}}</h5>
                </div>
                <div class="card-body">
                    {{ Form::open(['url' => 'broadcast/update/'.$broadcast->id,'id' => 'campaign_update','enctype' => 'multipart/form-data','method'=>'post']) }}
                        @method('PUT')
                        <div class="form-group">
                            <div class="row">
                                <div class="col-md-12">
                                    <label class="form-control-label">Campaign name</label>
                                    <input type="text" class="form-control" name="campaign_name" placeholder="Campaign name" value="{{$broadcast->campaign_name}}" required>
                                    <input type="hidden" name="csrf-token" value="<?=csrf_token();?>" />
                                    <input type="hidden" name="id" value="{{$broadcast->id}}">
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="row">
                                <div class="col-md-12">
                                    <label class="form-control-label">Type Your Custom message</label>
                                    <textarea  class="form-control" name="custom_message">{{$broadcast->custom_message}}</textarea>
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="row">
                                <div class="col-md-12">
                                    <label class="form-control-label">Select Folder</label>
                                    <select class="form-control" name="folder">
                                        @foreach($folders as $folder)
                                            <option value="{{$folder->name}}" @if($broadcast->folder == $folder->name) selected @endif >{{$folder->name}}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="form-control-label">From Number</label>
                            <select class="form-control" name="sms_number_id" required="">
                                @foreach($callnumber as $callnumbers)
                                    <option @if($callnumbers->id == $broadcast->sms_number_id) selected @endif value="{{$callnumbers->id}}"  >{{$callnumbers->number}}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            <div class="row">
                                <div class="col-md-12">
                                    <label class="form-control-label">Type</label>
                                    <select id="changeasaction" class="form-control" name="typeOnChoice" required="">
                                        <option value="">Please select type..</option>
                                        <option value="Weekly" @if($broadcast->typeOnChoice == 'Weekly') selected @endif >Weekly</option>
                                        <option value="Singleday" @if($broadcast->typeOnChoice == 'Singleday') selected @endif >Single day</option>
                                    </select>
                                </div>
                            </div>
                        </div>

                <div class="{{$broadcast->typeOnChoice == 'Weekly' ? 'col-md-12' :'col-md-12 d-none'}}" id="set_day">
                <label class="form-control-label">Set Your day</label>
                <select class="js-example-basic-multiple" name="day[]" multiple="multiple">
                    @if($days)
                    @foreach($days as $day)
                    <option value="Monday" @if($day == 'Monday') selected @endif>Monday</option>
                    <option value="Tuesday" @if($day == 'Tuesday') selected @endif>Tuesday</option>
                    <option value="Wednesday" @if($day == 'Wednesday') selected @endif>Wednesday</option>
                    <option value="Thursday" @if($day == 'Thursday') selected @endif>Thursday</option>
                    <option value="Friday" @if($day == 'Friday') selected @endif>Friday</option>
                    <option value="Saturday" @if($day == 'Saturday') selected @endif>Saturday</option>
                    <option value="Sunday" @if($day == 'Sunday') selected @endif>Sunday</option>
                    @endforeach
                    @endif
                </select>
                </div>
                <div class="{{$broadcast->typeOnChoice == 'Singleday' ? 'col-md-12' :'col-md-12 d-none'}}" id="set_time">
                    <div class="row">
                        <div class="col-md-6">
                        <label class="form-control-label">Date</label>
                            <input type="date" class="form-control" name="date" value="{{$broadcast->date}}">
                        </div>
                        <div class="col-md-6">
                        <label class="form-control-label">Set Your Time</label>
                         <input type="time" id="appt" class="form-control" name="time" value="{{$broadcast->time}}">

                        </div>
                    </div>
                </div>
                <div class="form-group">
                    <div class="row">
                        <div class="col-md-12">
                            <label class="form-control-label">Status</label>
                            <select class="form-control" name="status" required="">
                                <option value="Active" @if($broadcast->status == 'Active') selected @endif>Active</option>
                                <option value="Inactive" @if($broadcast->status == 'Inactive') selected @endif>Inactive</option>
                            </select>
                        </div>
                    </div>
                </div>

            <div class="text-right">
                {{ Form::button(__('Save'), ['type' => 'submit','class' => 'btn btn-sm btn-primary rounded-pill']) }}
                <a href="{{url('/broadcast')}}" class="btn btn-sm btn-secondary rounded-pill" data-dismiss="modal">{{__('Cancel')}}</a>
            </div>

                        {{ Form::close() }}
                </div>
            </div>

        </div>
    </div>
</div>
@endsection

@push('script')

<link rel="stylesheet" type="text/css" href="{{ asset('assets/css/simcify.min.css') }}">
<script src="{{ asset('assets/js/simcify.min.js') }}"></script>
<script src="{{ asset('assets/libs/dragula/dist/dragula.min.js') }}"></script>

<script type="text/javascript" src="{{ asset('assets/js/jquery-ui.min.js') }}"></script>
<script type="text/javascript" src="{{ asset('assets/js/repeater.js') }}"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.10/js/select2.min.js"></script>
<script src="{{ asset('public/ckeditor/ckeditor.js') }}"></script><script>
    CKEDITOR.replace('summary-ckeditor');
    $(document).ready(function() {
        $('.js-example-basic-multiple').select2({width:'100%'});

        $('#changeasaction').on('change', function() {
          // alert( this.value );
          if(this.value == 'Singleday'){
            $('#set_time').removeClass('d-none');
            $('#set_day').addClass('d-none');
          }else if (this.value == 'Weekly') {
                $('#set_day').removeClass('d-none');
                $('#set_time').addClass('d-none');
          }else{
            $('#set_time').addClass('d-none');
            $('#set_day').addClass('d-none');
          }
        });
    });

</script>




@endpush

