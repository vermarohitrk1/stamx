@extends('layouts.admin')
@section('title')
{{$title}}
@endsection
@section('content')
<div class="row">


    {{--Main Part--}}
    <div class="col-lg-8 order-lg-1">
        <div id="tabs-1" class="tabs-card">
            <div class="card">
                <div class="card-header">
                    <h5 class=" h6 mb-0">{{__('Edit Product')}}</h5>
                </div>
                <div class="card-body">
                    {{ Form::open(['route' => 'servicerequest.update','id' => 'servicerequest update','enctype' => 'multipart/form-data']) }}

                    <div class="form-group">
                        <div class="row">
                            <div class="col-md-12">
                                <label class="form-control-label">Describe the service you're looking to purchase - please be as detailed as possible:</label>
                                <textarea class="form-control"  name="description" placeholder="I'm looking for..." rows="10" minlength="30" maxlength="500" required>{{$data->description}}</textarea>
                                <input type="hidden" name="id" value="{{$data->id}}" />
                                <input type="hidden" name="csrf-token" value="<?= csrf_token(); ?>" />
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="row">
                            <div class="col-md-6">
                                <label class="form-control-label">Choose a category:</label>
                                <select class="form-control" name="category">
                                    @if(!empty($categories))
                                    @foreach($categories as  $category)
                                    <option value="{{ $category->id }}" @if($data->category == $category->id ) selected @endif >{{ $category->name }}</option>
                                    @endforeach
                                    @else
                                    @endif
                                </select>
                            </div>
                            <div class="col-md-6">
                                <label class="form-control-label">Set service request status:</label>
                                <select class="form-control" name="status">
                                    <option value="Active" @if($data->status == "Active") selected @endif >Active</option>
                                    <option value="Closed" @if($data->status == "Closed") selected @endif >Closed</option>
                                    <option value="Unpublished" @if($data->status == "Unpublished") selected @endif >Unpublished</option>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="row">
                            <div class="col-md-6">
                                <label class="form-control-label">What is your budget for this service?</label>
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <div class="input-group-text">
                                            <i class="fa fa-dollar-sign"></i> 
                                        </div>
                                    </div>
                                    <input type="number" class="form-control" name="budget" min="0" maxlength="3"  step=".01" placeholder="i.e $5.00" value="{{$data->budget}}" required>
                                </div>
                            </div>
                            
                                
                            <div class="col-12 col-md-12">
                                
                {{ Form::label('image', __('Attach a image related to service:'),['class' => 'form-control-label']) }}
                                @if(!empty($data->image))
                                 <input
                                     type="file" name="image" id="image" class="custom-input-file croppie" default="{{asset('storage/servicerequests')}}/{{ $data->image }}" crop-width="600" crop-height="600"  accept="image/*" required=""/>
                                @else
                <input type="file" name="image" id="image" class="custom-input-file croppie" crop-width="600" crop-height="600"  accept="image/*" required=""/>
                 @endif   
                 <label for="image">
                                    @if(!empty($data->image))
                                    <span>{{$data->image}} </span>
                                    @else
                                    <i class="fa fa-upload"></i>
                                    <span>{{__('Choose a file…')}} </span>
                                    @endif
                                </label>
            </div>
                            
                            
                            
                        </div>
                    </div>


                    <div class="text-right">
                        {{ Form::button(__('Update'), ['type' => 'submit','class' => 'btn btn-sm btn-primary rounded-pill']) }}
                        <a href="{{ route('servicerequest.index') }}">
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



