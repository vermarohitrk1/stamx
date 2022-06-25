@extends('layouts.admin')
@section('title')
{{$Instructor->title}}
@endsection

@push('theme-script')
<script src="{{ asset('assets/libs/bootstrap-tagsinput/dist/bootstrap-tagsinput.min.js') }}"></script>
<link rel="stylesheet" type="text/css" href="{{ asset('assets/css/simcify.min.css') }}">
@endpush

@section('content')
<div class="row">

    {{--Main Part--}}
    <div class="col-lg-12 order-lg-1">
        <div id="tabs-1" class="tabs-card">
            <div class="card">
                <div class="card-header">
                    <h5 class=" h6 mb-0">{{__('Edit Instructor')}}</h5>
                </div>
                <div class="card-body">

                    {{ Form::open(['route' => ['instructor.update'],'id' => 'Instructor_update','enctype' => 'multipart/form-data']) }}

						<div class="form-group">
						    <div class="row">
						        <div class="col-md-6">
						            <label class="form-control-label">Instructor Title</label>
						            <input type="text" class="form-control" name="title"  value="{{$Instructor->title}}" required="">
						            <input type="hidden" name="id" value="{{$Instructor->id}}" />
						            <input type="hidden" name="csrf-token" value="<?= csrf_token(); ?>" />
						        </div>
						        <div class="col-md-6">
						            <label class="form-control-label">Instructor Name</label>
						            <input type="text" class="form-control" name="name" value="{{$Instructor->name}}" required="">
						        </div>
						    </div>
						</div>

						<div class="form-group">
						    <div class="row">
						        <div class="col-md-6">
						            <label class="form-control-label">State</label>
						            <input type="text" class="form-control" name="state" value="{{$Instructor->state}}">
						        </div>
						        <div class="col-md-6">
						            <label class="form-control-label">City</label>
						            <input type="text" class="form-control" name="city" value="{{$Instructor->city}}">
						        </div>
						    </div>
						</div>
                        <div class="form-group">
						    <div class="row">
						        <div class="col-md-12">
						            <label class="form-control-label">Email Address</label>
						            <input type="email" class="form-control" name="email" value="{{$Instructor->email}}">
						        </div>
						    </div>
						</div>

						  <div class="form-group">
						    <div class="row">
						        <div class="col-md-12">
						               {{ Form::label('image', __('Instructor Image'),['class' => 'form-control-label']) }}
						            @if(!empty($Instructor->image))
									<input type="file" name="image" class="croppie" default="{{asset('storage')}}/instructor/{{ $Instructor->image }}" crop-width="508" crop-height="331"  accept="image/*">
						            @else
										<input type="file" name="image" class="custom-input-file croppie" crop-width="508" crop-height="331"  accept="image/*" required="" >
						            @endif
						        </div>
						    </div>
						</div>

                    <div class="text-right">
                        {{ Form::button(__('Update'), ['type' => 'submit','class' => 'btn btn-sm btn-primary rounded-pill']) }}
                         <a href="{{ route('instructor.index') }}">
                        <button type="button" class="btn btn-sm btn-secondary rounded-pill">{{__('Back')}}</button>
                        </a>
                    </div>
                    {{ Form::close() }}
                </div>
            </div>

        </div>
    </div>
</div>
@endsection

@push('script')
<script src="{{ asset('assets/js/simcify.min.js') }}"></script>
<script src="{{ asset('assets/libs/dragula/dist/dragula.min.js') }}"></script>
<script type="text/javascript" src="{{ asset('assets/js/jquery-ui.min.js') }}"></script>
<script type="text/javascript" src="{{ asset('assets/js/repeater.js') }}"></script>

@endpush

