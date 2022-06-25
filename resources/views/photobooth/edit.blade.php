@extends('layout.dashboardlayout')

@push('theme-script')
<script src="{{ asset('assets/libs/bootstrap-tagsinput/dist/bootstrap-tagsinput.min.js') }}"></script>
@endpush

@section('content')
<!-- Page Content -->
<div class="content">
    <div class="container-fluid">

        <div class="row">
            <div class="col-md-5 col-lg-4 col-xl-3 theiaStickySidebar">
                <!-- Sidebar -->
                      @include('layout.partials.userSideMenu')
                <!-- /Sidebar -->
            </div>
            <div class="col-md-7 col-lg-8 col-xl-9">
                <div class=" col-md-12 ">
                        <a href="{{ url('/partner') }}" class="btn btn-sm btn-primary float-right btn-icon-only rounded-circle ">
                            <span class="btn-inner--icon"><i class="fas fa-reply"></i></span>
                        </a>
                </div>
                <!-- Breadcrumb -->
                <div class="breadcrumb-bar mt-3">
                    <div class="container-fluid">
                        <div class="row align-items-center">
                            <div class="col-md-12 col-12">
                                <h2 class="breadcrumb-title">Partner Edit</h2>
                                <nav aria-label="breadcrumb" class="page-breadcrumb">
                                    <ol class="breadcrumb">
                                        <li class="breadcrumb-item"><a href="index">Home</a></li>
                                        <li class="breadcrumb-item active" aria-current="page">Partner</li>
                                        <li class="breadcrumb-item active" aria-current="page">Partner Edit</li>
                                    </ol>
                                </nav>
                            </div>              
                        </div>            
                    </div>
                </div>
                <!-- /Breadcrumb -->


<div class="row">


    {{--Main Part--}}
    <div class="col-lg-12 order-lg-1">
        <div id="tabs-1" class="tabs-card">
            <div class="card">
                <div class="card-header">
                    <h5 class=" h6 mb-0">{{__('Edit Partner')}}</h5>
                </div>
                <div class="card-body">
                    {{ Form::open(['url' =>'partner/update','id' => 'Book update','enctype' => 'multipart/form-data']) }}

                      <div class="form-group">
        <div class="row">
            <div class="col-md-12">
                    {{ Form::label('logo', __('Partner logo'),['class' => 'form-control-label']) }}

              @if(!empty($partner->logo))
                 <input type="file" name="image" class="custom-input-file croppie" default="{{asset('storage')}}/partner/{{ $partner->logo }}" crop-width="191" crop-height="60"    accept="image/*">
                  <div class="form-group form-check">
                    <input type="checkbox" name="delete_image" class="form-check-input" id="exampleCheck1">
                    <label class="form-check-label" for="exampleCheck1">Delete Image?</label>
                  </div>
           @else
                    <input type="file" name="image" class="custom-input-file croppie" crop-width="191" crop-height="60"   accept="image/*" required="" >
@endif

            </div>


        </div>
    </div>
                    <!--<div class="form-group">
                        <div class="row">
                            <div class="col-md-6">
                                <img src="{{asset('storage')}}/partner/{{ $partner->logo }}" class="img-thumbnail" alt="Responsive image">
                            </div>
                        </div>
                    </div>-->
<div class="form-group">
        <div class="row">
            <div class="col-md-12">
                <label class="form-control-label">Partner link</label>
                <input type="text" class="form-control" name="link" value="{{$partner->link}}" placeholder="Partner link" required>
                <input type="hidden" name="csrf-token" value="<?=csrf_token();?>" />
                <input type="hidden" name="id" value="{{$partner->id}}" />
            </div>
        </div>
    </div>

    <div class="form-group">
        <div class="row">
            <div class="col-md-12">
                <label class="form-control-label">Status</label>
                <select class="form-control" name="status">
                    <option value="">Select Status</option>
                    <option value="Active"  @if($partner->status == "Active") selected @endif>Active</option>
                    <option value="Inactive"  @if($partner->status == "Inactive") selected @endif>Inactive</option>
                </select>
            </div>
        </div>
    </div>
                    {!! Form::hidden('add_to_slider',1,array('id'=>'radio_user')) !!}


                    <div class="text-right">
    {{ Form::button(__('Save'), ['type' => 'submit','class' => 'btn btn-sm btn-primary rounded-pill']) }}
    <button type="button" class="btn btn-sm btn-secondary rounded-pill" data-dismiss="modal">{{__('Cancel')}}</button>
</div>
     {{ Form::close() }}

                </div>
                </div>
            </div>

        </div>
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

<script src="{{ asset('public/ckeditor/ckeditor.js') }}"></script>
<script type="text/javascript" src="{{ asset('assets/js/jquery-ui.min.js') }}"></script>
<script type="text/javascript" src="{{ asset('assets/js/repeater.js') }}"></script>
<script>
CKEDITOR.replace('summary-ckeditor');
</script>



@endpush

