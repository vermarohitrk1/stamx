<?php $page = "Manage Certificate"; ?>
@extends('layout.dashboardlayout')
@section('content')	

<style>
.cert_sec_ img {
    width: 100%;
}
span.footer_ {
    font-size: 9px !important;
}
.form-control-label {
  
    margin-top: 1.5rem;
}
.badgeimg_logo img {
    width: 100%;
    max-width: 49px;
}

.badgeimg_logo {
    position: absolute;
    bottom: 43px;
    right: 34px;
}
.img_logo {
    position: absolute;
    text-align: center;
    margin: auto;
    left: 0;
    right: 0;
    top: 29px; 
}


.img_logo img {
    width: 100%;
    max-width: 98px;
}
span.main_ {
    padding: 3px 60px;
}
.footer_.text {
    position: absolute;
    top: 82%;
    margin: auto;
    
    padding: 0px 17px;
    font-size: 11px;
    font-weight: 600;
    
}

span.footer_d {
    font-size: 9px;
    margin-left: 30px;
}
span.code_d {
    position: relative;
    /* right: 0; */
    left: 7rem;
    font-size: 9px;
}
span.template_s {
    padding-top: 15px;
    float: left;
    width: 100%;
    font-size: 15px;
}
.cert.text span {
    display: block;
    margin-bottom: 8px;
}


.cert_sec_ {
    position: relative;
}


.cert.text {
    text-align: center;
}

.cert.text {
    position: absolute;
    top: 22%;
    margin: auto;
    text-align: center;
    padding: 0px 17px;
    font-size: 11px;
    font-weight: 600;
    left: 0;
    right: 0;
}

@media only screen and (max-width: 767px){
.cert.text {

    top: 44px!important;
    padding: 0 15px!important;
    font-size: 11px!important;

}
span.template_s {
  
    font-size: 13px;
}
.cert.text span {
    font-size: 11px!important;
}
}
</style>

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
                     <a href="{{ route('certify.index') }}" id="back" class="btn btn-sm btn-primary float-right ml-2">
        <span class="btn-inner--icon"><i class="fas fa-reply"></i></span>
    </a>
 
                    
           
                     </div>
   
<!-- Breadcrumb -->
<div class="breadcrumb-bar mt-3">
    <div class="container-fluid">
        <div class="row align-items-center">
            <div class="col-md-12 col-12">
                <h2 class="breadcrumb-title">Manage Certificate</h2>
                <nav aria-label="breadcrumb" class="page-breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{route('dashboard')}}">Home</a></li>
                        <li class="breadcrumb-item"><a href="{{route('certify.index')}}">Course</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Manage Certificate</li>
                    </ol>
                </nav>
            </div>              
        </div>            
    </div>
</div>
<!-- /Breadcrumb -->

<div class="row">
        <div class=" col-md-12">
            <div class="card card-stats">
                <div class="card-body">
                    <div class="row">
                        <div class="col">
                            <div class="form-group">
                                <form action="{{route('certify.createcertificate')}}" method="POST"
                                      id="uploadCertificatreText">
                                    @csrf
                                    <div class="row">
                                        <div class="col-md-12">
                                            <label class="form-control-label">Certificate Template Top Text</label>
                                                <textarea name="top" class="form-control" id="topText" placeholder="" 
                                                          required>@if(!empty($CertificateData->top)){{$CertificateData->top }}@endif</textarea>
                                        </div>
                                    </div>
									  <div class="row">
                                        <div class="col-md-12">
                                            <label class="form-control-label">Certificate Template Header Text</label>
                                                <textarea name="header" class="form-control" id="HeaderText" placeholder=""
                                                          required>@if(!empty($CertificateData->header)){{$CertificateData->header}} @endif</textarea>
                                        </div>
                                    </div>
									
									   <div class="row">
                                        <div class="col-md-12">
                                            <label class="form-control-label">Certificate Template Text</label>
											<p>Note: <span class="note_color">{StudentName}</span> and <span class="note_color">{CourseName}</span> represents student name and course title on the certificate.</p>
                                                <textarea name="name" class="form-control" id="MainText" placeholder=""
                                                          required>@if(!empty($CertificateData->text)){{$CertificateData->text }}@endif </textarea>
                                           
                                        </div>
                                    </div>
									  <div class="row">
                                        <div class="col-md-12">
                                            <label class="form-control-label">Certificate Template Footer Text</label>
										      <textarea name="footer" class="form-control" id="FooterText" placeholder=""
                                                          required>@if(!empty($CertificateData->footer)){{$CertificateData->footer}}@endif </textarea>
                                          
                                        </div>
                                    </div>
	  <div class="row">				
       <div class="col-md-12">
            <div class="card card-stats">
                <div class="card-body sidetemp">
                    
                            <h6 class="text-muted mb-1">{{__('Certificate Logo')}}</h6>
							<p class="template_des">Note: Make sure that logo size is less than  <span class="template_error">1MB</span>.</p>
                            <span class="h3 font-weight-bold mb-0 "
                                  style="font-size: x-large;"></span>
                           
                                <div class="form-group"> 
                                            @if(!empty($CertificateData->logo))
                                                <input type="file" name="logo" class="custom-input-file croppie"
                                                       default="{{asset('storage')}}/certify/{{ $CertificateData->logo }}"
                                                      crop-width="326" crop-height="78" id="certimg" accept="image/*"
                                                       max-size="1000000">
                                            @else
                                                <input type="file" name="logo" class="custom-input-file croppie"
                                                       crop-width="326" crop-height="78" accept="image/*" id="certimg"
                                                       max-size="1000000" required>
                                            @endif

                                 
                                </div>
                           
                       
                </div>
            </div>
        </div>
		
		
        </div>
	
	
		  <div class="row">				
       <div class="col-md-12">
            <div class="card card-stats">
                <div class="card-body sidetemp">
                    
                            <h6 class="text-muted mb-1">{{__('Certificate Badge')}}</h6>
							<p class="template_des">Note: Make sure that badge size is less than  <span class="template_error">1MB</span>.</p>
                            <span class="h3 font-weight-bold mb-0 "
                                  style="font-size: x-large;"></span>
                           
                                <div class="form-group">
                                    
                                            @if(!empty($CertificateData->badge))
                                                <input type="file" name="badge" class="custom-input-file croppie"
                                                       default="{{asset('storage')}}/certify/{{ $CertificateData->badge }}"
                                                       crop-width="160" crop-height="180" id="certimg" accept="image/*"
                                                       max-size="1000000">
                                            @else
                                                <input type="file" name="badge" class="custom-input-file croppie"
                                                       crop-width="160" crop-height="180" accept="image/*" id="certimg"
                                                       max-size="1000000" required>
                                            @endif

                                 
                                </div>
                           
                        </div>

                  
            </div>
        </div>
		
		
        </div>
									
									<span class="template_s">Select Template</span>
									    <div class="row">
										
        <!--<div class=" col-md-3 ">
            <div class="card card-stats">
                <div class="card-body sidetemp">
                    <div class="row">
                        <div class="">
                            <h6 class="text-muted mb-1">{{__('Certificate Template')}}</h6>
							<p class="template_des">Note: Make sure that template size is less than  <span class="template_error">1MB</span>.</p>
                            <span class="h3 font-weight-bold mb-0 "
                                  style="font-size: x-large;"></span>
                            <form action="{{route('certify.createcertificate')}}" method="POST"
                                  enctype="multipart/form-data" id="certificateFile">
                                @csrf
                                <div class="form-group">
                                    <div class="row">
                                        <div class="col-md-12">
                                            @if(!empty($CertificateData->template))
                                                <input type="file" name="image" class="custom-input-file croppie"
                                                       default="{{asset('storage')}}/certify/{{ $CertificateData->template }}"
                                                       crop-width="600" crop-height="400" id="certimg" accept="image/*"
                                                       max-size="1000000">
                                            @else
                                                <input type="file" name="image" class="custom-input-file croppie"
                                                       crop-width="600" crop-height="400" accept="image/*" id="certimg"
                                                       max-size="1000000" required>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="text-right">
                                        {{ Form::button(__('Save'), ['type' => 'submit','class' => 'btn btn-sm btn-primary rounded-pill']) }}
                                    </div>
                                </div>
                            </form>
                        </div>
                        <div class="col-auto">
                        </div>
                    </div>
                </div>
            </div>
        </div>
		
		<div class=" col-md-9 ">
            <div class="card card-stats">
                <div class="card-body sidetemp">
                    <div class="cert_sec_">
                        <h6 class="text-muted mb-1"></h6>
                        @if(!empty($CertificateData->template))
                            <img src="{{asset('storage')}}/certify/{{ $CertificateData->template }}" class="">
                        @else
                            <span class="h3 font-weight-bold mb-0 "
                                  style="font-size: x-large;">It's empty here!!</span>
                        @endif
						
                    </div>
                </div>
            </div>
        </div>
		-->
		 <div class=" col-md-6 col-12 ">
            <div class="card card-stats">
                <div class="card-body sidetemp">
				<input type="radio" value="certify615eae6f3004e.png" name="template" @if(!empty($CertificateData->template) && $CertificateData->template=='certify615eae6f3004e.png')checked @endif>
                    <div class="cert_sec_">
                        <h6 class="text-muted mb-1"></h6>
                      
					  <div class="img_logo">
					  @if(!empty($CertificateData->logo))
                              <img src="{{asset('storage')}}/certify/{{ $CertificateData->logo }}"class="">
								@endif
					  </div>
					  
                            <img src="{{asset('storage')}}/certificate/certify615eae6f3004e.png" class="">
                       
						<div class="cert text">
						   <span id="dohere_top" class="h3"></span>
						   <span id="dohere_header" class="header_"></span>
						   <span id="dohere_main" class="main_"></span>
						   <span id="Date" class="footer_"></span>
						</div>
						<div class="footer_ text">
						   <span id="dohere_footer" class="footer_d"></span>
						   <span id="code_d" class="code_d"></span>
						 
						</div>
						
						<div class="badgeimg_logo">
					  @if(!empty($CertificateData->badge))
                              <img src="{{asset('storage')}}/certify/{{ $CertificateData->badge }}"class="">
								@endif
					  </div>
                    </div>
                </div>
            </div>
        </div>
		
        <div class=" col-md-6 col-12 ">
            <div class="card card-stats">
                <div class="card-body sidetemp">
				<input type="radio" value="certify615eae8a5ebde.png" name="template" @if(!empty($CertificateData->template) && $CertificateData->template=='certify615eae8a5ebde.png')checked @endif>
                    <div class="cert_sec_">
                        <h6 class="text-muted mb-1"></h6>
                       <div class="img_logo">
					  @if(!empty($CertificateData->logo))
                              <img src="{{asset('storage')}}/certify/{{ $CertificateData->logo }}"class="">
								@endif
					  </div>
                            <img src="{{asset('storage')}}/certificate/certify615eae8a5ebde.png" class="">
                        
						<div class="cert text">
						   <span id="dohere_top1" class="h3"></span>
						   <span id="dohere_header1" class="header_"></span>
						   <span id="dohere_main1" class="main_"></span>
						   <span id="Date1" class="footer_"></span>
						</div>
						<div class="footer_ text">
						   <span id="dohere_footer1" class="footer_d"></span>
						   <span id="code_d1" class="code_d"></span>
						 
						</div>
						<div class="badgeimg_logo">
					  @if(!empty($CertificateData->badge))
                              <img src="{{asset('storage')}}/certify/{{ $CertificateData->badge }}"class="">
								@endif
					  </div>
                    </div>
                </div>
            </div>
        </div>
		
			 <div class=" col-md-6 col-12 ">
            <div class="card card-stats">
                <div class="card-body sidetemp">
				<input type="radio" value="certify615eaecff2071.png" name="template" @if(!empty($CertificateData->template) && $CertificateData->template=='certify615eaecff2071.png')checked @endif>
                    <div class="cert_sec_">
                        <h6 class="text-muted mb-1"></h6>
                      <div class="img_logo">
					  @if(!empty($CertificateData->logo))
                              <img src="{{asset('storage')}}/certify/{{ $CertificateData->logo }}"class="">
								@endif
					  </div>
                            <img src="{{asset('storage')}}/certificate/certify615eaecff2071.png" class="">
                    
						<div class="cert text">
						   <span id="dohere_top2" class="h3"></span>
						   <span id="dohere_header2" class="header_"></span>
						   <span id="dohere_main2" class="main_"></span>
						   <span id="Date2" class="footer_"></span>
						</div>
						<div class="footer_ text">
						   <span id="dohere_footer2" class="footer_d"></span>
						   <span id="code_d2" class="code_d"></span>
						 
						</div>
						<div class="badgeimg_logo">
					  @if(!empty($CertificateData->badge))
                              <img src="{{asset('storage')}}/certify/{{ $CertificateData->badge }}"class="">
								@endif
					  </div>
                    </div>
                </div>
            </div>
        </div>
		
        <div class=" col-md-6 col-12 ">
            <div class="card card-stats">
                <div class="card-body sidetemp">
				<input type="radio" value="certify615eaedfdd1f1.png" name="template" @if(!empty($CertificateData->template) && $CertificateData->template=='certify615eaedfdd1f1.png') checked @endif>
                    <div class="cert_sec_">
                        <h6 class="text-muted mb-1"></h6>
                       <div class="img_logo">
					  @if(!empty($CertificateData->logo))
                              <img src="{{asset('storage')}}/certify/{{ $CertificateData->logo }}"class="">
								@endif
					  </div>
                            <img src="{{asset('storage')}}/certificate/certify615eaedfdd1f1.png" class="">
                       
						<div class="cert text">
						   <span id="dohere_top3" class="h3"></span>
						   <span id="dohere_header3" class="header_"></span>
						   <span id="dohere_main3" class="main_"></span>
						   <span id="Date3" class="footer_"></span>
						</div>
						<div class="footer_ text">
						   <span id="dohere_footer3" class="footer_d"></span>
						   <span id="code_d3" class="code_d"></span>
						 
						</div>
						<div class="badgeimg_logo">
					  @if(!empty($CertificateData->badge))
                              <img src="{{asset('storage')}}/certify/{{ $CertificateData->badge }}"class="">
								@endif
					  </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
									 
                                    <div class="text-right">
                                        {{ Form::button(__('Save'), ['type' => 'submit','class' => 'btn btn-sm btn-primary rounded-pill text_sev']) }}
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
	
	

    

            </div>
        </div>

    </div>

</div>		
<!-- /Page Content -->
@endsection

@push('script')
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/css/simcify.min.css') }}">
    <script src="{{ asset('assets/js/simcify.min.js') }}"></script>
    <script src="{{ asset('assets/libs/dragula/dist/dragula.min.js') }}"></script>
    <script src="{{ asset('public/ckeditor/ckeditor.js') }}"></script>
    <script type="text/javascript" src="{{ asset('assets/js/repeater.js') }}"></script>
    <script>

	$(function() {
		var topText = $('textarea#topText').val();
		var HeaderText = $('textarea#HeaderText').val();
		var MainText = $('textarea#MainText').val();
		var FooterText = $('textarea#FooterText').val();
		var Date = "On Jan XX, 20XX";
		var code_d = "Cert Code: xxxxxx";
	  if(topText !=''){
		   $('#dohere_top').text(topText);
    $('#dohere_top1').text(topText);
    $('#dohere_top2').text(topText);
    $('#dohere_top3').text(topText);
	$('#Date').text(Date);
    $('#Date1').text(Date);
    $('#Date2').text(Date);
    $('#Date3').text(Date);
	$('#code_d').text(code_d);
    $('#code_d1').text(code_d);
    $('#code_d2').text(code_d);
    $('#code_d3').text(code_d);
	  } 
	  if(HeaderText !=''){
		   $('#dohere_header').text(HeaderText);
    $('#dohere_header1').text(HeaderText);
    $('#dohere_header2').text(HeaderText);
    $('#dohere_header3').text(HeaderText);
	  } 
	  if(MainText !=''){
		   $('#dohere_main').text(MainText);
    $('#dohere_main1').text(MainText);
    $('#dohere_main2').text(MainText);
    $('#dohere_main3').text(MainText);
	  }
	  if(FooterText !=''){
		   $('#dohere_footer').text(FooterText);
    $('#dohere_footer1').text(FooterText);
    $('#dohere_footer2').text(FooterText);
    $('#dohere_footer3').text(FooterText);
	  }
	  
		   $('#topText').on("input", function() {
	
    $('#dohere_top').text($(this).val());
    $('#dohere_top1').text($(this).val());
    $('#dohere_top2').text($(this).val());
    $('#dohere_top3').text($(this).val());
  }); 
	 

  
   $('#HeaderText').on("input", function() {
    $('#dohere_header').text($(this).val());
    $('#dohere_header1').text($(this).val());
    $('#dohere_header2').text($(this).val());
    $('#dohere_header3').text($(this).val());
  });
  
   $('#FooterText').on("input", function() {
    $('#dohere_footer').text(Date);
    $('#dohere_footer1').text(Date);
    $('#dohere_footer2').text(Date);
    $('#dohere_footer3').text(Date);
  });
  
   $('#MainText').on("input", function() {
    $('#dohere_main').text($(this).val());
    $('#dohere_main1').text($(this).val());
    $('#dohere_main2').text($(this).val());
    $('#dohere_main3').text($(this).val());
  });
});


        $(function () {
            $('#certificateFile').submit(function (e) {

                $('input[type=file][max-size]').each(function () {
                    if (typeof this.files[0] !== 'undefined') {
                        var maxSize = $(this).attr('max-size');
                        var size = this.files[0].size;
                        if (maxSize < size) {
                            e.preventDefault();
                            show_toastr('Error', '{{__('Please choose template size less than 1mb.')}}', 'error');
                        }
                    }
                });
            });
        });
        $(document).ready(function () {
            $('#certimg').bind('change', function () {
                var a = (this.files[0].size);
            });
        });

    </script>
    <script>

        // $("#create_certify").submit(function (event) {
        //     alert('hi');
        //     showModal();
        // });
        {{--$("#uploadCertificatreText").submit(function (event) {--}}
        {{--    event.preventDefault();--}}
        {{--    $.ajax({--}}
        {{--        url: "{{ route('certify.createcertificate')}}",--}}
        {{--        method: 'post',--}}
        {{--        data: $('#uploadCertificatreText').serialize(),--}}
        {{--        success: function (response) {--}}
        {{--            if (response) {--}}
        {{--                show_toastr('Success', '{{__('Certificate title.')}}', 'success');--}}
        {{--            }--}}
        {{--        }--}}
        {{--    });--}}
        {{--});--}}

        {{--$("#certificateFile").submit(function (event) {--}}
        {{--    event.preventDefault();--}}
        {{--    $.ajax({--}}
        {{--        url: "{{ route('certify.createcertificate')}}",--}}
        {{--        method: 'post',--}}
        {{--        data: $('#certificateFile').serialize(),--}}
        {{--        success: function (response) {--}}
        {{--            if (response) {--}}
        {{--                show_toastr('Success', '{{__('Certificate update successfully.')}}', 'success');--}}
        {{--            }--}}
        {{--        }--}}
        {{--    });--}}
        {{--});--}}
    </script>
@endpush
