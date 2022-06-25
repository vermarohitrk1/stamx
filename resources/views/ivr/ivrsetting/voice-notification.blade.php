@php $page = "ivrsetting"; @endphp
@extends('layout.dashboardlayout')
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
				<!-- Breadcrumb -->
				<div class="breadcrumb-bar mt-3">
				    <div class="container-fluid">
				        <div class="row align-items-center">
				            <div class="col-md-12 col-12">
				                <h2 class="breadcrumb-title">Voicemail Notification</h2>
				                <nav aria-label="breadcrumb" class="page-breadcrumb">
				                    <ol class="breadcrumb">
				                        <li class="breadcrumb-item"><a href="{{route('dashboard')}}">Home</a></li>
				                        <li class="breadcrumb-item active" aria-current="page">Voicemail Notification</li>
				                    </ol>
				                </nav>
				            </div>              
				        </div>            
				    </div>
				</div>
				<!-- /Breadcrumb --> 
				<div class="row mt-3" id="blog_view">
					<div class="col-12">
						<div class="card">
					<div class="card-body">
                        {{ Form::open(['url' => 'ivr/voicemail/notification/post','id' => 'blog update','enctype' => 'multipart/form-data']) }}
                        <div class="form-group">
                            <div class="row">
                                <input type="hidden" name="id" value="{{ ($twilio_setting->id ?? '') }}">

                            </div>
                            <div class="form-group">
                                <div class="row">
                                    <div class="col-md-12">
                                        <label class="form-control-label">Voicemail Notification
                                        </label>
                                        <div class="form-check">
                                            <input class="form-check-input" @if(!empty(@$twilio_setting->notification) && (@$twilio_setting->notification==1)) checked @endif type="radio" name="notification" id="exampleRadios1" value="1" onchange="show(1)" checked>
                                            <label class="form-check-label" for="exampleRadios1"> Off</label>
                                        </div>
                                        <div class="form-check">
                                            <input class="form-check-input" @if(!empty(@$twilio_setting->notification) && (@$twilio_setting->notification==2)) checked @endif  type="radio" name="notification" id="exampleRadios2" value="2" onchange="show(2)">
                                            <label class="form-check-label" for="exampleRadios2">Email</label>
                                        </div>
                                        <div class="form-check">
                                            <input class="form-check-input" @if(!empty(@$twilio_setting->notification) && (@$twilio_setting->notification==3)) checked @endif  type="radio" name="notification" id="exampleRadios3" value="3" onchange="show(3)">
                                            <label class="form-check-label" for="exampleRadios3">SMS</label>
                                        </div>
                                    </div>

                                </div>
                            </div>
                            <div class="form-group" id="mobile"   @if(!empty(@$twilio_setting->notification) && (@$twilio_setting->notification==3)) style="display: block"     @else style="display: none"  @endif>
                                <div class="row">
                                    <div class="col-md-12">
                                        <label class="form-control-label">Mobile</label>
                                        <input type="text" class="form-control" name="mobile" value="{{(@$twilio_setting->mobile ?? '')}}">
                                    </div>
                                    <div class="col-md-12">
                                        <label class="form-control-label">Voicemail SMS Template</label>
                                        <textarea  class="form-control" name="sms_template" >{{(@$twilio_setting->sms_template ?? '')}}</textarea>
                                        <p>{From},{TranscriptionText}</p>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group" id="email" @if(!empty(@$twilio_setting->notification) && (@$twilio_setting->notification==2)) style="display: block"     @else style="display: none"  @endif>
                                <div class="row">
                                    <div class="col-md-12">
                                        <label class="form-control-label">Email</label>
                                        <input type="text" class="form-control" name="email" value="{{($twilio_setting->email ?? '')}}">
                                    </div>
                                    <div class="col-md-12">
                                        <label class="form-control-label">Voicemail Email Template</label>
                                        <textarea  class="form-control" name="email_template" id="summary-ckeditor" >{{(@$twilio_setting->email_template ?? '')}}</textarea>
                                        <p>{RecordingUrl},{From},{TranscriptionText}</p>
                                    </div>
                                </div>
                            </div>

                        </div>

                        <div class="text-right">
                            {{ Form::button(__('Save'), ['type' => 'submit','class' => 'btn btn-sm btn-primary rounded-pill']) }}
                            <button type="button" class="btn btn-sm btn-secondary rounded-pill" data-dismiss="modal">{{__('Cancel')}}</button>
                        </div>
                        {{ Form::close() }}

		            </div>  <!-- /card-body -->
	            </div>     <!-- /card-header -->
            </div>        <!-- /col-md-7 col-lg-8 col-xl-9 -->  
        </div>
    </div> <!-- /container-fluid -->
</div>
</div>
</div>

<!-- /Page Content -->
@endsection
@push('script')
<script src="{{ asset('public/ckeditor/ckeditor.js') }}"></script>

<script>
    CKEDITOR.replace('summary-ckeditor');
    function show(id)
    {
        if(id==3){
            $('#email').hide();
            $('#mobile').show();

        }else if(id == 2){
            $('#email').show();
            $('#mobile').hide();
        }else{
            $('#mobile').hide();
            $('#email').hide();
        }
    }

</script>
@endpush