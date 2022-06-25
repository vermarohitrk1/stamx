@extends('layouts.admin')
@section('title')
{{!empty($title) ? $title : "Page"}}
@endsection

@push('theme-script')
<script src="{{ asset('assets/libs/bootstrap-tagsinput/dist/bootstrap-tagsinput.min.js') }}"></script>
@endpush

@section('content')
<div class="row">
    {{--Main Part--}}
    <div class="col-lg-8 col-sm-12 col-md-12 order-lg-1">
        <div id="tabs-1" class="tabs-card">
            <div class="card">
                <div class="card-header">
                    <h5 class=" h6 mb-0">{{ !empty($brand->title) ? $brand->title :'' }}</h5>
                </div>
                <div class="card-body">
                    {{ Form::open(['route' => 'shopBrand.update','id' => 'brand update','enctype' => 'multipart/form-data']) }}

                    <div class="form-group">
                        <div class="row">
                            <div class="col-md-12">
                                <label class="form-control-label">Brand Name</label>
                                <br>
                                <input type="text" class="form-control" name="name" style="color: black;" placeholder="Brand Name" required value="{{ !empty($brand->title) ? $brand->title :'' }}">
                                <input type="hidden" name="id" value="{{ !empty($brand->id) ? encrypted_key($brand->id,'encrypt') :0}}" />
                                <input type="hidden" name="csrf-token" value="<?= csrf_token(); ?>" />
                            </div>
                        </div>
                    </div>
                   
                    <div class="text-right mt-3">
                        {{ Form::button(__('Save'), ['type' => 'submit','class' => 'btn btn-sm btn-primary rounded-pill']) }}
                        <a href="{{ route('shopBrand.index') }}">
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
<link rel="stylesheet" type="text/css" href="{{ asset('assets/css/simcify.min.css') }}">
<script src="{{ asset('assets/js/simcify.min.js') }}"></script>

@endpush
