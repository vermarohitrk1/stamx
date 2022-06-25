<?php $page = "blog"; ?>
@extends('layout.dashboardlayout')
@section('content')
<style>
    li{
        list-style: none;
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

<!-- Breadcrumb -->
<div class="breadcrumb-bar mt-3">
    <div class="container-fluid">
        <div class="row align-items-center">
            <div class="col-md-12 col-12">
                <h2 class="breadcrumb-title">After Hours</h2>
                <nav aria-label="breadcrumb" class="page-breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Home</a></li>
                        <!-- <li class="breadcrumb-item"><a href="{{ route('blog.index') }}">Blog</a></li> -->
                        <li class="breadcrumb-item active" aria-current="page">After Hours</li>
                    </ol>
                </nav>
            </div>
        </div>
    </div>
</div>
<!-- /Breadcrumb -->
<div class="row">
        <div class="col-lg-12 order-lg-1">
            <div id="tabs-1" class="tabs-card">
                <div class="card">
                    <div class="card-header">
                        <h5 class=" h6 mb-0">After Hours</h5>
                    </div>
                    <div class="card-body">
                        <form method="POST" action="{{ route('ivr.after.hours.post') }}" accept-charset="UTF-8" id="blog update" enctype="multipart/form-data">
                        <input name="_token" type="hidden" value="{{ csrf_token() }}">
                        @if(isset($afterHours) && $afterHours != null)
                        <input type="hidden" name="id" value="{{$afterHours->id}}">
                            @php
                                $arraySunday = json_decode($afterHours->sunday, true);
                                $arrayMonday = json_decode($afterHours->monday, true);
                                $arrayTuesday = json_decode($afterHours->tuesday, true);
                                $arrayWednesday = json_decode($afterHours->wednesday, true);
                                $arrayThursday = json_decode($afterHours->thursday, true);
                                $arrayFriday = json_decode($afterHours->friday, true);
                                $arraySaturday = json_decode($afterHours->saturday, true);
                            @endphp


                        @endif

                        <div class="form-group">
                            <div class="row">
                                <div class="col-md-12">
                                    <label class="form-control-label">After Hours</label>
                                    <div class="form-check">
                                        <input  type="checkbox" name="out_of_hour" value="1"class="form-check-input out_of_hour" @if(!empty($afterHours) && $afterHours->out_of_hour == 1) checked @endif>
                                        <label class="form-check-label" for="exampleRadios1"> Enabled/Disabled</label>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="outofhours_enable" style="display: none ">
                            <h5>Active Hours</h5><hr>
                            <div class="form-group">
                                <div class="row">
                                    <div class="col-md-12">
                                        <label class="form-control-label"> Sunday </label>
                                        <div class="form-check">

                                                <input  type="checkbox"name="sunday"  value="1" class="form-check-input"  @if(!empty($afterHours) && !empty($arraySunday) && !empty($arraySunday['sunday'])) checked @endif ><label class="form-check-label" for="exampleRadios2"> Enabled/Disabled </label>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="form-group  sunday"  style="display: @if(!empty($afterHours) && !empty($arraySunday)) @if(!empty($arraySunday['sunday'] ))    block  @else none @endif @else none @endif" >
                                <div class="row">
                                    <div class="col-md-6">
                                         <label>Sunday start time</label>
                                            <input class="form-control timepicker" id="sunday_start" placeholder="10:00" name="sunday_start" type="text" @if(!empty($arraySunday))) value="{{ (date("g:i a", strtotime($arraySunday['sunday_start'])) ??'')}}" @endif>
                                            <span class="text-danger">  </span>
                                    </div>
                                    <div class="col-md-6">
                                        <label>Sunday end time</label>
                                        <input class="form-control timepicker" id="sunday_end"  placeholder="18:00" name="sunday_end" type="text" @if(!empty($arraySunday)))  value="{{ (date("g:i a", strtotime($arraySunday['sunday_end']))??'') }}" @endif>
                                    </div>
                                </div>
                            </div>

                            <div class="form-group">
                                <div class="row">
                                    <div class="col-md-12">
                                    <label class="form-control-label">Monday </label>
                                        <div class="form-check">
                                            <input  type="checkbox"name="monday"  value="1"   class="form-check-input"  @if(isset($afterHours) && isset($arrayMonday) &&  $arrayMonday['monday'] == 1) checked @endif > <label class="form-check-label" for="exampleRadios2"  >Enabled/Disabled</label>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="form-group monday"  style="display:    @if(isset($afterHours) && isset($arrayMonday))  @if(!empty($arrayMonday['monday']))    block @else none @endif  @else none @endif">
                                <div class="row">
                                    <div class="col-md-6">
                                        <label>Monday start time</label>
                                        <input class="form-control timepicker"  id="monday_start" placeholder="10:00" name="monday_start" type="text"  @if(isset($afterHours) && isset($arrayMonday)) value="{{ (date("g:i a", strtotime($arrayMonday['monday_start'])) ?? '') }}" @endif>
                                    </div>
                                    <div class="col-md-6">
                                        <label>Monday end time</label>
                                            <input class="form-control timepicker" id="monday_end" placeholder="18:00" name="monday_end" type="text"  @if(isset($afterHours) && isset($arrayMonday)) value="{{ (date("g:i a", strtotime($arrayMonday['monday_end']))??'') }}" @endif>
                                    </div>
                                </div>
                            </div>

                            <div class="form-group">
                                <div class="row">
                                    <div class="col-md-12">
                                        <label class="form-control-label">Tuesday </label>
                                        <div class="form-check">

                                            <input  type="checkbox"name="tuesday" value="1"  class="form-check-input" @if(isset($afterHours) && isset($arrayTuesday) && $arrayTuesday['tuesday'] == 1) checked @endif ><label class="form-check-label" for="exampleRadios3" > Enabled/Disabled</label>

                                        </div>
                                    </div>
                                </div>
                            </div>

                                <div class="form-group tuesday" style="display:  @if(isset($afterHours)&& isset($arrayTuesday)) @if(!empty($arrayTuesday['tuesday'])) block @else none @endif  @else none @endif">
                                    <div class="row">
                                        <div class="col-md-6">
                                             <label>Tuesday start time</label>
                                            <input class="form-control timepicker"  id="tuesday_start" placeholder="10:00" name="tuesday_start" type="text" :  @if(isset($afterHours)&& isset($arrayTuesday)) value="{{ (date("g:i a", strtotime($arrayTuesday['tuesday_start'])) ?? '') }}" @endif>
                                        </div>
                                        <div class="col-md-6">
                                            <label>Tuesday end time</label>
                                            <input class="form-control  timepicker"  id="tuesday_end" placeholder="18:00" name="tuesday_end" type="text" :  @if(isset($afterHours)&& isset($arrayTuesday)) value="{{ (date("g:i a", strtotime($arrayTuesday['tuesday_end']))??'') }}" @endif>
                                        </div>
                                    </div>
                                </div>


                            <div class="form-group">
                                <div class="row">
                                    <div class="col-md-12">
                                        <label class="form-control-label">Wednesday </label>
                                        <div class="form-check">

                                                <input  type="checkbox" name="wednesday" value="1"  class="form-check-input"  @if(isset($afterHours) && isset($arrayWednesday) && $arrayWednesday['wednesday'] == 1) checked @endif >
                                                <label class="form-check-label" for="exampleRadios3" checked>Enabled/Disabled
                                                </label>

                                        </div>
                                    </div>
                                </div>
                            </div>


                            <div class="form-group wednesday" style="display: @if(isset($afterHours) && isset($arrayWednesday)) @if(!empty($arrayWednesday['wednesday'])) block @else none @endif @else none @endif ">
                                <div class="row">
                                    <div class="col-md-6">
                                        <label>Wednesday start time</label>
                                                <input class="form-control timepicker" @if(isset($afterHours) && isset($arrayWednesday)) value="{{ (date("g:i a", strtotime($arrayWednesday['wednesday_start']))??'') }}" @endif id="wednesday_start" placeholder="10:00" name="wednesday_start" type="text">
                                    </div>
                                    <div class="col-md-6">
                                        <label>Wednesday end time</label>
                                            <input class="form-control timepicker" @if(isset($afterHours) && isset($arrayWednesday)) value="{{ (date("g:i a", strtotime($arrayWednesday['wednesday_end']))??"") }}" @endif id="wednesday_end" placeholder="18:00" name="wednesday_end" type="text">
                                    </div>
                                </div>
                            </div>

                            <div class="form-group">
                                <div class="row">
                                    <div class="col-md-12">
                                        <label class="form-control-label">Thursday </label>
                                        <div class="form-check">

                                               <input  type="checkbox"name="thursday"  value="1"  class="form-check-input"  @if(isset($afterHours) && isset($arrayThursday) && $arrayThursday['thursday'] == 1) checked @endif  ><label class="form-check-label" for="exampleRadios3" checked>  Enabled/Disabled</label>

                                        </div>
                                    </div>
                                </div>
                            </div>

                                <div class="form-group thursday"  style="display:  @if(isset($afterHours) && isset($arrayThursday)) @if(!empty($arrayThursday['thursday']))  block @else  none @endif  @else  none @endif"  >
                                    <div class="row">
                                        <div class="col-md-6">
                                           <label>Thursday start time</label>
                                                <input class="form-control timepicker" @if(isset($afterHours) && isset($arrayThursday)) value="{{ (date("g:i a", strtotime($arrayThursday['thursday_start'])) ??'') }}" @endif id="thursday_start"  placeholder="10:00" name="thursday_start" type="text">
                                        </div>
                                        <div class="col-md-6">
                                            <label>Thursday end time</label>
                                                <input class="form-control timepicker" @if(isset($afterHours) && isset($arrayThursday)) value="{{ (date("g:i a", strtotime($arrayThursday['thursday_end'])) ??'') }}" @endif id="thursday_end"  placeholder="18:00" name="thursday_end" type="text">
                                        </div>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <div class="row">
                                        <div class="col-md-12">
                                            <label class="form-control-label">Friday </label>
                                            <div class="form-check">
                                                <input  type="checkbox"name="friday" value="1"  class="form-check-input" @if(isset($afterHours) && isset($arrayFriday) && $arrayFriday['friday'] == 1)  checked @endif > <label class="form-check-label" for="exampleRadios3"> Enabled/Disabled</label>
                                            </div>
                                         </div>
                                    </div>
                                </div>


                                    <div class="form-group friday"  style="display:  @if(isset($afterHours) && isset($arrayFriday['friday'])) @if(!empty($arrayFriday['friday'])) block @else none @endif @else none @endif">
                                        <div class="row">
                                            <div class="col-md-6">
                                                <label>Friday start time</label>
                                                <input class="form-control timepicker"  @if(isset($afterHours) && isset($arrayFriday['friday'])) value="{{ (date("g:i a", strtotime($arrayFriday['friday_start'])) ??'') }}" @endif id="friday_start" placeholder="10:00" name="friday_start" type="text">
                                            </div>
                                            <div class="col-md-6">
                                                <label>Friday end time</label>
                                                    <input class="form-control timepicker"  @if(isset($afterHours) && isset($arrayFriday['friday'])) value="{{ (date("g:i a", strtotime($arrayFriday['friday_end'])) ??'') }}" @endif id="friday_end" placeholder="18:00" name="friday_end" type="text">
                                            </div>
                                        </div>
                                    </div>



                                <div class="form-group">
                                    <div class="row">
                                        <div class="col-md-12">
                                            <label class="form-control-label">Saturday </label>
                                            <div class="form-check">

                                                <input  type="checkbox"name="saturday" value="1"    class="form-check-input"    @if(isset($afterHours) && isset($arraySaturday['saturday']) && $arraySaturday['saturday'] == 1) checked @endif > <label class="form-check-label" for="exampleRadios3">Enabled/Disabled</label>

                                            </div>
                                        </div>
                                    </div>
                                </div>



                                <div class="form-group saturday" style="display: @if(isset($afterHours) && isset($arraySaturday['saturday'])) @if(!empty($arraySaturday['saturday'])) block @else  none @endif  @else  none @endif " >
                                    <div class="row">
                                        <div class="col-md-6">
                                            <label>Saturday start time</label>
                                            <input class="form-control timepicker"  @if(isset($afterHours) && isset($arraySaturday['friday'])) value="{{ (date("g:i a", strtotime($arraySaturday['saturday_start']))??'') }}" @endif id="saturday_start" placeholder="10:00" name="saturday_start" type="text">
                                        </div>
                                        <div class="col-md-6">
                                            <label>Saturday end time</label>
                                            <input class="form-control timepicker"  @if(isset($afterHours) && isset($arraySaturday['friday'])) value="{{ (date("g:i a", strtotime($arraySaturday['saturday_end'])) ?? '') }}" @endif id="saturday_end" placeholder="18:00" name="saturday_end" type="text">
                                        </div>
                                    </div>
                                </div>

                            <div class="form-group">
                                <div class="row">
                                    <div class="col-md-12">
                                        <label class="control-label">After Hours Greeting</label>
                                        <div class="form-check">


                                            <input  type="radio"  name="out_of_hour_type" value="0" class="form-check-input"     @if(isset($afterHours) && $afterHours != null)   @if($afterHours->out_of_hour_type == 0) checked @endif @else checked @endif  > <label class="form-check-label" for="exampleRadios3">TTS</label>


                                        </div>
                                        <div class="form-check">


                                            <input type="radio"   name="out_of_hour_type" value="1" class="form-check-input"   @if(isset($afterHours) && $afterHours != null)  @if($afterHours->out_of_hour_type == 1) checked  @endif  @endif><label class="form-check-label" for="exampleRadios3"> MP3</label>

                                        </div>
                                    </div>
                                </div>

                                        <div class="form-group out_of_hour-text"  style="display:  @if(isset($afterHours) && $afterHours != null)  @if($afterHours->out_of_hour_type == '0') block @else   none  @endif @else   block  @endif "  >
                                            <div class="row">
                                                <div class="col-sm-12">
                                                    <label class="form-control-label">Text</label>

                                                    <textarea rows="3" class="form-control" name="out_of_hour_text"  id="out_of_hour_text" >{{ ($afterHours->out_of_hour_text ?? '') }}</textarea>
                                                </div>
                                            </div>
                                        </div>





                                        <div class="form-group out_of_hour-mp3"   style="display: @if(isset($afterHours) && $afterHours != null)  @if($afterHours->out_of_hour_type == '1') block @else none @endif @else none  @endif" >
                                            <div class="row">
                                                <div class="col-sm-6">
                                                    <label class="form-control-label">MP3</label>
                                                    <input type="file" id="out_of_hour_mp3" name="imageFile" accept=".mp3,audio/*" class="form-control" >
                                                    <br>
                                                </div>
                                                <div class="col-md-6" >
                                                </div>
                                                <div class="col-md-12" >

                                                    @if(!empty($afterHours->out_of_hour_mp3))
                                                    <label class="form-control-label">Recorded IVR MP3</label>
                                                        <div class="wrapperaudio" id="" style="width: 266px; !important;">
                                                            <audio preload="auto" controls class="audio">
                                                                <source src="{{@$afterHours->out_of_hour_mp3}}" type="audio/mpeg"></audio>
                                                        </div>
                                                    @endif
                                                </div>
                                            </div>
                                        </div>

                                <div class="col-md-12" id="audio_recording_div"  style="display: @if(isset($afterHours) && $afterHours != null)  @if($afterHours->out_of_hour_type == '1') block @else none @endif @else none  @endif" ">
                                    <div id="controls">
                                        <button class="btn btn-primary rounded-pill btn-xs"  id="recordButton"><i class="fas fa-microphone"></i> Record</button>
                                        <!--<button class="btn btn-danger rounded-pill btn-xs" id="pauseButton" disabled>Pause</button>-->
                                        <button class="btn btn-danger rounded-pill btn-xs" id="stopButton" disabled><i class="fas fa-dot-circle"></i> Stop</button>
                                    </div>

                                    <div id="formats">Format: start recording to see sample rate</div>
                                    <p><strong>Recording:</strong><small> Your recorded files will be saved on AWS Bucket, If you will not configure your bucket then files will be deleted after 45 days.</small></p>
                                        <ol id="recordingsList"></ol>
                                        <div id="recorded_file" style="display:none"></div>
                                </div>
                            </div>
                    </div>

                    <div class="text-right">
                        <button type="submit" class="btn btn-sm btn-primary rounded-pill">Save</button>
                        <button type="button" class="btn btn-sm btn-secondary rounded-pill" data-dismiss="modal">Cancel</button>
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
<!-- /Page Content -->
@endsection
@push('script')

<link rel="stylesheet" type="text/css" href="{{ asset('assets/css/simcify.min.css') }}">
<script src="{{ asset('assets/js/simcify.min.js') }}"></script>

<link rel="stylesheet" type="text/css" href="{{ asset('assets/libs/dropify/css/dropify.min.css') }}">
<script src="{{ asset('assets/libs/dropify/js/dropify.min.js') }}"></script>


<script src="{{ asset('public/ckeditor/ckeditor.js') }}"></script>

<script>

        (function($) {
            $(function() {
                $('.timepicker').timepicker();
            });
        })(jQuery);
        CKEDITOR.replace('summary-ckeditor');
        $(document).on('click','.out_of_hour_mp3',function(){
            $('#out_of_hour_mp3').trigger('click');
        });

        $(document).ready(function(){
                if($('.out_of_hour').is(':checked') ){
                    $('.outofhours_enable').css('display','block');
                }else{
                    $('.outofhours_enable').css('display','none');
                }

            var cecl = $('input[type=radio]:checked').val();
            if(cecl == 0){
                $("#out_of_hour_text").attr("required", true);
                $('.out_of_hour-text').css('display','block');
                $('.out_of_hour-mp3').css('display','none');
            }else{
                $("#out_of_hour_text").attr("required", false);
                $('.out_of_hour-text').css('display','none');
                $('.out_of_hour-mp3').css('display','block');
            }

            $('input[type=radio][name=out_of_hour_type]').change(function() {
                if (this.value == '0') {
                    $("#out_of_hour_text").attr("required", true);
                    $('.out_of_hour-text').css('display','block');
                    $('.out_of_hour-mp3').css('display','none');
                    $('#audio_recording_div').css('display','none');
                }
                else if (this.value == '1') {
                    $("#out_of_hour_text").attr("required", false);
                    $('.out_of_hour-text').css('display','none');
                    $('.out_of_hour-mp3').css('display','block');
                    $('#audio_recording_div').css('display','block');

                }
            });
            $('input[type=checkbox][name=out_of_hour]').change(function() {
                var ischecked= $(this).is(':checked');
                if(ischecked){
                    $('.outofhours_enable').css('display','block');
                }else{
                    $('.outofhours_enable').css('display','none');
                }
            });

            $('input[type=checkbox][name=sunday]').change(function() {
                var ischecked= $(this).is(':checked');
                if(ischecked){
                    $('.sunday').css('display','block');
                }else{
                    $('.sunday').css('display','none');
                }
            });
            $('input[type=checkbox][name=monday]').change(function() {
                var ischecked= $(this).is(':checked');
                if(ischecked){
                    $('.monday').css('display','block');
                }else{
                    $('.monday').css('display','none');
                }
            });
            $('input[type=checkbox][name=tuesday]').change(function() {
                var ischecked= $(this).is(':checked');
                if(ischecked){
                    $('.tuesday').css('display','block');
                }else{
                    $('.tuesday').css('display','none');
                }
            });
            $('input[type=checkbox][name=wednesday]').change(function() {
                var ischecked= $(this).is(':checked');
                if(ischecked){
                    $('.wednesday').css('display','block');
                }else{
                    $('.wednesday').css('display','none');
                }
            });
            $('input[type=checkbox][name=thursday]').change(function() {
                var ischecked= $(this).is(':checked');
                if(ischecked){
                    $('.thursday').css('display','block');
                }else{
                    $('.thursday').css('display','none');
                }
            });
            $('input[type=checkbox][name=friday]').change(function() {
                var ischecked= $(this).is(':checked');
                if(ischecked){
                    $('.friday').css('display','block');
                }else{
                    $('.friday').css('display','none');
                }
            });
            $('input[type=checkbox][name=saturday]').change(function() {
                var ischecked= $(this).is(':checked');
                if(ischecked){
                    $('.saturday').css('display','block');
                }else{
                    $('.saturday').css('display','none');
                }
            });
        });
    </script>
        <script>
            $( function(){
                $( '.audio' ).audioPlayer();
            });
        </script>
<script src="https://cdn.rawgit.com/mattdiamond/Recorderjs/08e7abd9/dist/recorder.js"></script>
<script>
	//webkitURL is deprecated but nevertheless
	URL = window.URL || window.webkitURL;

	var gumStream; 						//stream from getUserMedia()
	var rec; 							//Recorder.js object
	var input; 							//MediaStreamAudioSourceNode we'll be recording

	// shim for AudioContext when it's not avb.
	var AudioContext = window.AudioContext || window.webkitAudioContext;
	var audioContext //audio context to help us record

	var recordButton = document.getElementById("recordButton");
	var stopButton = document.getElementById("stopButton");
	//var pauseButton = document.getElementById("pauseButton");

	//add events to those 2 buttons
	recordButton.addEventListener("click", startRecording);
	stopButton.addEventListener("click", stopRecording);
	//pauseButton.addEventListener("click", pauseRecording);

	function startRecording() {
		console.log("recordButton clicked");

		/*
			Simple constraints object, for more advanced audio features see
			https://addpipe.com/blog/audio-constraints-getusermedia/
		*/

	    var constraints = { audio: true, video:false }

	 	/*
	    	Disable the record button until we get a success or fail from getUserMedia()
		*/

		recordButton.disabled = true;
		stopButton.disabled = false;
	//	pauseButton.disabled = false
	$("#recordingsList").html('');
	$("#recorded_file").html('');

		/*
	    	We're using the standard promise based getUserMedia()
	    	https://developer.mozilla.org/en-US/docs/Web/API/MediaDevices/getUserMedia
		*/

		navigator.mediaDevices.getUserMedia(constraints).then(function(stream) {
			console.log("getUserMedia() success, stream created, initializing Recorder.js ...");

			/*
				create an audio context after getUserMedia is called
				sampleRate might change after getUserMedia is called, like it does on macOS when recording through AirPods
				the sampleRate defaults to the one set in your OS for your playback device

			*/
			audioContext = new AudioContext();

			//update the format
			document.getElementById("formats").innerHTML="Format: 1 channel pcm @ "+audioContext.sampleRate/1000+"kHz"

			/*  assign to gumStream for later use  */
			gumStream = stream;

			/* use the stream */
			input = audioContext.createMediaStreamSource(stream);

			/*
				Create the Recorder object and configure to record mono sound (1 channel)
				Recording 2 channels  will double the file size
			*/
			rec = new Recorder(input,{numChannels:1})

			//start the recording process
			rec.record()

			console.log("Recording started");

		}).catch(function(err) {
		  	//enable the record button if getUserMedia() fails
	    	recordButton.disabled = false;
	    	stopButton.disabled = true;
	//    	pauseButton.disabled = true
		});
	}

	function pauseRecording(){

		console.log("pauseButton clicked rec.recording=",rec.recording );
		if (rec.recording){

			//pause
			rec.stop();
			pauseButton.innerHTML="Resume";

		}else{
			//resume
			rec.record()
			pauseButton.innerHTML="Pause";

		}
	}

	function stopRecording() {
		console.log("stopButton clicked");

		//disable the stop button, enable the record too allow for new recordings
		stopButton.disabled = true;
		recordButton.disabled = false;
	//	pauseButton.disabled = true;

		//reset button just in case the recording is stopped while paused
	//	pauseButton.innerHTML="Pause";

		//tell the recorder to stop the recording
		rec.stop();

		//stop microphone access
		gumStream.getAudioTracks()[0].stop();

		//create the wav blob and pass it on to createDownloadLink
		rec.exportWAV(createDownloadLink);
	}

	function createDownloadLink(blob) {

		var url = URL.createObjectURL(blob);
		var au = document.createElement('audio');
		var li = document.createElement('li');
		var link = document.createElement('a');

		//name of .wav file to use during upload and download (without extendion)
		var filename = new Date().toISOString();

		//add controls to the <audio> element
		au.controls = true;
		au.src = url;

		//save to disk link
		link.href = url;
		link.download = filename+".wav"; //download forces the browser to donwload the file using the  filename
		link.innerHTML = "Download";

	     var reader = new FileReader();
	 reader.readAsDataURL(blob);
	 reader.onloadend = function() {
	     var base64data = reader.result;
	     $('<input>').attr({
	                    type: 'hidden',
	                    id: 'audio_data',
	                    name: 'audio_data_file',
	                    value:base64data
	                }).appendTo('#recorded_file');
	 }

	//$("#recorded_file").append("audio_data_file",blob, filename);

		//add the new audio element to li
		li.appendChild(au);

		//add the filename to the li
		li.appendChild(document.createTextNode(filename+".wav "))

		//add the save to disk link to li
		li.appendChild(link);

	//	//upload link
	//	var upload = document.createElement('a');
	//	upload.href="#";
	//	upload.innerHTML = "Upload";
	//	upload.addEventListener("click", function(event){
	//		  var xhr=new XMLHttpRequest();
	//		  xhr.onload=function(e) {
	//		      if(this.readyState === 4) {
	//		          console.log("Server returned: ",e.target.responseText);
	//		      }
	//		  };
	//		  var fd=new FormData();
	//		  fd.append("audio_data",blob, filename);
	//		  xhr.open("POST","upload.php",true);
	//		  xhr.send(fd);
	//
	//	})
	//	li.appendChild(document.createTextNode (" "))//add a space in between
	//	li.appendChild(upload)//add the upload link to li

		//add the li element to the ol
		recordingsList.appendChild(li);
	}
</script>









@endpush
