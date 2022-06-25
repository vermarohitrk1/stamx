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
                        <a href="{{ url('/cms') }}" class="btn btn-sm btn-primary float-right btn-icon-only rounded-circle ">
                            <span class="btn-inner--icon"><i class="fas fa-reply"></i></span>
                        </a>
                </div>
                <!-- Breadcrumb -->
                <div class="breadcrumb-bar mt-3">
                    <div class="container-fluid">
                        <div class="row align-items-center">
                            <div class="col-md-12 col-12">
                                <h2 class="breadcrumb-title">CMS Edit</h2>
                                <nav aria-label="breadcrumb" class="page-breadcrumb">
                                    <ol class="breadcrumb">
                                        <li class="breadcrumb-item"><a href="index">Home</a></li>
                                        <li class="breadcrumb-item active" aria-current="page">CMS</li>
                                        <li class="breadcrumb-item active" aria-current="page">CMS Edit</li>
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
                    <h5 class=" h6 mb-0">{{__('Edit CMS')}}</h5>
                </div>
                <div class="card-body">
                    {{ Form::open(['url' => 'cms/'.$page->id,'id' => 'page_update','enctype' => 'multipart/form-data','method'=>'post']) }}
                        @method('PUT')
                        <div class="form-group">
                            <div class="row">
                                <div class="col-md-12">
                                    <label class="form-control-label">Page Name</label>
                                    <br>
                                    <input type="text" class="form-control" name="page_name"  value="{{$page->page_name}}">
                                    <input type="hidden" name="csrf-token" value="<?= csrf_token(); ?>" />
                                    <input type="hidden" name="id" value="{{$page->id}}" />
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="row">
                                <div class="col-md-12">
                                    <label class="form-control-label">Status</label>
                                    <select class="form-control" name="status">
                                        <option value="Published" @if($page->status == "Published") selected @endif>Published</option>
                                        <option value="Unpublished" @if($page->status == "Unpublished") selected @endif>Unpublished</option>
                                    </select>
                                </div>
                            </div>
                        </div>
						 <div class="form-group">
                            <div class="row">
                                <div class="col-md-12">
                                    <label class="form-control-label">Banner Image</label>
									 @if(!empty($page->image))
										<input type="file" name="image" class="custom-input-file croppie" default="{{asset('storage')}}/pages/{{ $page->image }}" crop-width="600" crop-height="600"  accept="image/*">
                                        <div class="form-check">
                                            <input type="checkbox" class="form-check-input" name="image_delete"  id="exampleCheck1">
                                            <label class="form-check-label" for="exampleCheck1">Delete Image ?</label>
                                        </div>
						            @else

										<input type="file" name="image" class="custom-input-file croppie" crop-width="900" crop-height="400"  accept="image/*"  >

						            @endif
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="row">
                                <div class="col-md-12">
                                    <label class="form-control-label">Header Text Color</label>
                                    <input id="color-picker"  class="form-control" name="color" value="{{ $page->color }}"/>
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="row">
                                <div class="col-md-12">
                                    <label class="form-control-label">Title</label>
                                    <input  type="text"  class="form-control" name="title" value="{{ $page->title }}"/>
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="row">
                                <div class="col-md-12">
                                    <label class="form-control-label">Subtitle</label>
                                    <input  type="text"  class="form-control" name="subtitle" value="{{ $page->subtitle }}"/>
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="row">
                                <div class="col-md-12">
                                    <label class="form-control-label">Page Data</label>
                                    <textarea class="form-control" id="summary-ckeditor" name="page_data"  placeholder="Book Description" rows="10" required>{{$page->page_data}}</textarea>
                                </div>
                            </div>
                        </div>
                        <div class="text-right">
                            {{ Form::button(__('Update'), ['type' => 'submit','class' => 'btn btn-sm btn-primary rounded-pill']) }}
                            <!-- <a href="{{ url('pages') }}">
                                <button type="button" class="btn btn-sm btn-secondary rounded-pill">{{__('Back')}}</button>
                            </a> -->
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
<link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/spectrum-colorpicker2/dist/spectrum.min.css">
<script src="{{ asset('assets/js/simcify.min.js') }}"></script>
<script src="{{ asset('assets/libs/dragula/dist/dragula.min.js') }}"></script>

<script src="{{ asset('public/ckeditor/ckeditor.js') }}"></script>
<script type="text/javascript" src="{{ asset('assets/js/jquery-ui.min.js') }}"></script>
<script type="text/javascript" src="{{ asset('assets/js/repeater.js') }}"></script>
<script src="//cdn.jsdelivr.net/npm/spectrum-colorpicker2/dist/spectrum.min.js"></script>
<script>
CKEDITOR.replace('summary-ckeditor');
$( document ).ready(function() {
    $('#color-picker').spectrum({
        type: "component"
    });
});

</script>



@endpush

