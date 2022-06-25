<?php $page = "Donation"; ?>
@extends('layout.dashboardlayout')
@push('css-cdn')
<link rel="stylesheet" type="text/css" href="{{ asset('assets/css/simcify.min.css') }}">
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
                <a href="{{ url('donation/dashboard') }}" class="btn btn-sm btn btn-primary float-right "  data-title="{{__('Add Plan')}}">
                        <span class="btn-inner--icon"><i class="fas fa-reply"></i></span>
                    </a>
                    @if(Request::url() === url('/') .'/donation/page' && $detail)
                        <a href="{{route('donation.public.page',@$id)}}" class="btn btn-sm btn btn-primary float-right mr-2" >
                            <span class="btn-inner--text">Public Page</span>
                        </a>
                        <!--<input type="hidden" style="visibility: hidden" id="donation" value="{{  url('/') }}/{{@$id}}/donation/">-->
                        
                        <a href="javascript::void(0);" class="btn btn-sm btn btn-primary float-right mr-2"  data-url="{{ url('donation/qrcode/'.@$id) }}" data-ajax-popup="true" data-size="lg" data-title="{{__('QR Code')}}">
                        <span class="btn-inner--text">QR Code</span>
                        </a>
                    @endif
                </div>
                <!-- Breadcrumb -->
                <div class="breadcrumb-bar mt-3">
                    <div class="container-fluid">
                        <div class="row align-items-center">
                            <div class="col-md-12 col-12">
                                <h2 class="breadcrumb-title">Donation Page</h2>
                                <nav aria-label="breadcrumb" class="page-breadcrumb">
                                    <ol class="breadcrumb">
                                        <li class="breadcrumb-item"><a href="index">Home</a></li>
                                        <li class="breadcrumb-item"><a href="{{ url('donation/dashboard') }}">Donation</a></li>
                                        <li class="breadcrumb-item active" aria-current="page">Donation Page</li>
                                    </ol>
                                </nav>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- /Breadcrumb -->

                <div class="row mt-3">
                    <br>
                    <div class="col-md-12">
                        <div class="card">
                            <div class="card-header">
                                <h5 class=" h6 mb-0">{{__('Manage Donation Page')}}</h5>
                            </div>
                            <div class="card-body">
                                {{ Form::open(['url' => 'donation/page/store','id' => 'vacancy_update','enctype' => 'multipart/form-data','method'=>'post']) }}
                                @method('PUT')

                                <div class="form-group">
                                    <div class="row">
                                        <div class="col-md-12">
                                            <label class="form-control-label">Title</label>
                                            <textarea class="form-control" id="summary-ckeditor" name="public_title"
                                                placeholder="Book Description" rows="10"
                                                required>{{@$detail->public_title}}</textarea>
                                            <input type="hidden" name="csrf-token" value="<?=csrf_token();?>" />
                                            <input type="hidden" name="id" value="{{@$detail->id}}" />
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <div class="row">
                                        <div class="col-md-12">
                                            <label class="form-control-label">Descripton</label>
                                            <textarea class="form-control" id="summary-ckeditor1" name="public_subtitle"
                                                placeholder="Book Description" rows="10"
                                                required>{{@$detail->public_subtitle}}</textarea>
                                        </div>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <div class="row">
                                        <div class="col-md-12">
                                            {{ Form::label('image', __('Logo Icon'),['class' => 'form-control-label']) }}
                                            @if(!empty($detail->image))
                                            <input type="file" name="image" class="custom-input-file croppie"
                                                default="{{asset('storage')}}/details/{{ $detail->image }}" crop-width="326"
                                                crop-height="78" accept="image/*">
                                            @else
                                            <input type="file" name="image" class="custom-input-file croppie"
                                                crop-width="326" crop-height="78" accept="image/*" required="">
                                            @endif
                                        </div>

                                    </div>
                                </div>
                                <div class="form-group">
                                    <div class="row">
                                        <div class="col-md-12">
                                            {{ Form::label('bgimage', __('Background Image'),['class' => 'form-control-label']) }}
                                            @if(!empty($detail->bgimage))
                                            <input type="file" name="bgimage" class="custom-input-file croppie"
                                                default="{{asset('storage')}}/details/{{ $detail->bgimage }}"
                                                crop-width="1300" crop-height="850" accept="image/*">
                                            @else
                                            <input type="file" name="bgimage" class="custom-input-file croppie"
                                                crop-width="1300" crop-height="850" accept="image/*" required="">
                                            @endif
                                        </div>

                                    </div>
                                </div>
                                <div class="form-group">
                                    <div class="row">
                                        <div class="col-md-12">
                                            <label class="form-control-label">Donation Form Title</label>
                                            <input type="text" class="form-control" name="section_1"
                                                value="{{@$donation_form_data->section_1}}"
                                                placeholder="Donation Form Title" required>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <div class="row">
                                        <div class="col-md-12">
                                            <label class="form-control-label">Monthly Section Title</label>
                                            <input type="text" class="form-control" name="heading_section_2"
                                                value="{{@$donation_form_data->heading_section_2}}"
                                                placeholder="Monthly Section Title" required>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <div class="row">
                                        <div class="col-md-12">
                                            <label class="form-control-label">Monthly Section Description</label>
                                            <input type="text" class="form-control" name="description_section_2"
                                                value="{{@$donation_form_data->description_section_2}}"
                                                placeholder="Monthly Section Description" required>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <div class="row">
                                        <div class="col-md-12">
                                            <label class="form-control-label">Monthly Section Checkbox Label</label>
                                            <input type="text" class="form-control" name="checkbox_section_2"
                                                value="{{@$donation_form_data->checkbox_section_2}}" placeholder=""
                                                required>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <div class="row">
                                        <div class="col-md-12">
                                            <label class="form-control-label">Promotional Section label</label>
                                            <input type="text" class="form-control" name="checkbox_section_3"
                                                value="{{@$donation_form_data->checkbox_section_3}}" placeholder=""
                                                required>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <div class="row">
                                        <div class="col-md-12">
                                            <label class="form-control-label">Promotional Section Description</label>
                                            <input type="text" class="form-control" name="checkbox_section_4"
                                                value="{{@$donation_form_data->checkbox_section_4}}" placeholder=""
                                                required>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <div class="row">
                                        <div class="col-md-12">
                                            <label class="form-control-label">Continue to full site url</label>
                                            <input type="text" class="form-control" name="continue_to_full_site"
                                                value="{{@$donation_form_data->continue_to_full_site}}" placeholder="Url"
                                                required>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <div class="row">
                                        <div class="col-md-12">
                                            <label class="form-control-label">Success Message</label>
                                            <input type="text" class="form-control" name="success_message"
                                                value="{{@$donation_form_data->success_message}}" placeholder="" required>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <div class="row">
                                        <div class="col-md-12">
                                            <label class="form-control-label">Error Message</label>
                                            <input type="text" class="form-control" name="error_message"
                                                value="{{@$donation_form_data->error_message}}" placeholder="" required>
                                        </div>
                                    </div>
                                </div>
                                <div class="text-right">
                                    {{ Form::button(__('Update'), ['type' => 'submit','class' => 'btn btn-sm btn-primary rounded-pill']) }}
                                    <a href="{{ url('books') }}">
                                    </a>
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
@endsection
@push('script')
<script src="{{ asset('assets/js/simcify.min.js') }}"></script>
<script src="{{ asset('public/ckeditor/ckeditor.js') }}"></script>
<script>
 CKEDITOR.replace('summary-ckeditor');
CKEDITOR.replace('summary-ckeditor1');
        $(document).ready(function() {
            $("#copy_data").filter(function(){
              return ( $(this).siblings('#copy').length > 0 );
              }).on("click", function(e) {
              e.preventDefault();
              $(this).siblings("#copy").toggle();
            });

            $("#copy_link").click(function(ev){
                ev.preventDefault();
                var value = $('#donation').val();
                console.log(value);
                copyToClipboard( value );
                alert( "Copied:"+ value);
            });
        });

        function copyToClipboard(text) {

           var textArea = document.createElement( "textarea" );
           textArea.value = text;
           document.body.appendChild( textArea );
           textArea.select();

           try {
              var successful = document.execCommand( 'copy' );
              var msg = successful ? 'successful' : 'unsuccessful';
              console.log('Copying text command was ' + msg);
           } catch (err) {
              console.log('Oops, unable to copy',err);
           }
           document.body.removeChild( textArea );
        }
</script>
@endpush