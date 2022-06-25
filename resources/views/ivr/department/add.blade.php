@php $page = "Get a new number"; @endphp
@extends('layout.dashboardlayout')
@section('content')
<style>
    .intl-tel-input{
        width: 100%;
    }

.hide{
        display:none;
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
                            <h2 class="breadcrumb-title">Department</h2>
                            <nav aria-label="breadcrumb" class="page-breadcrumb">
                                <ol class="breadcrumb">
                                    <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Home</a></li>
                                    <li class="breadcrumb-item"><a href="{{ route('ivr') }}">IVR</a></li>
                                    <li class="breadcrumb-item active" aria-current="page">Department</li>
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

                    {{ Form::open(['route' =>'ivr.add_department','method'=>'post','enctype' => 'multipart/form-data']) }}
                            <div class="form-group">
                                <div class="row">
                                    <div class="col-md-6">
                                        <label>Name</label>
                                        <input type="text" class="form-control" id="name"  name="name" required value="@if(isset($departmentData) && $departmentData->name != null ) {{$departmentData->name}} @else @endif" />
                                    </div>
                                </div>
                            </div>

                            @if(isset($departmentData) && !empty($department_id))
                                <input type="hidden" name="id" value="{{$department_id}}">
                                <input type="hidden" name="submit_type" value="update">
                            @endif
                            <div class="form-group">
                                <div class="row">
                                    <div class="col-md-6">
                                        <label>Auto Attendant</label>
                                        <select class="form-control" name="twilio_voice" required>
                                            <option value="1" @if(isset($departmentData) && $departmentData->twilio_voice == 1) selected @endif>Man</option>
                                            <option value="2" @if(isset($departmentData) && $departmentData->twilio_voice == 2) selected @endif>Woman</option>
                                            <option value="3" @if(isset($departmentData) && $departmentData->twilio_voice == 3) selected @endif>Alice</option>
                                        </select>
                                    </div>
                                <!-- </div>
                            </div> -->
                            <!-- <div class="form-group">
                                <div class="row"> -->

                                    <div class="col-md-6">
                                        <label class="form-control-label">Type</label>
                                        <div class="form-check">
                                            <input class="form-check-input radioType" type="radio" name="type" id="exampleRadios1" value="0" onchange="show(0)"
                                            @if(isset($departmentData) && $departmentData->calltype == 1)  @else checked @endif>
                                            <label class="form-check-label" for="exampleRadios1"> Voicemail</label>
                                        </div>
                                        <div class="form-check">
                                        <input class="form-check-input radioType" type="radio" name="type" id="exampleRadios2" value="1" onchange="show(1)"
                                        @if(isset($departmentData) && $departmentData->calltype == 1)  checked @else  @endif>
                                        <label class="form-check-label" for="exampleRadios2">Forward Number</label>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="form-group" id="voice_mail"  @if(isset($departmentData) && $departmentData->calltype == 1) style="display:none"  @endif>
                                <div class="row">
                                    <div class="col-md-6" >
                                        <label class="form-control-label">Greetings</label>
                                        <div class="form-check">
                                            <input class="form-check-input" type="radio" name="greetings" id="exampleRadios3" value="0" onchange="show2(0)" @if(isset($departmentData) && $departmentData->greeting != null && $departmentData->greeting == 1) @else checked @endif>
                                            <label class="form-check-label" for="exampleRadios3"> TTS</label>
                                        </div>
                                        <div class="form-check">
                                        <input class="form-check-input" type="radio" name="greetings" id="exampleRadios4" value="1" onchange="show2(1)" @if(isset($departmentData) && $departmentData->greeting != null && $departmentData->greeting == 1) checked @else  @endif>
                                        <label class="form-check-label" for="exampleRadios4">MP3</label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="row">
                                    <div class="col-md-6" id="tts" style="display: @if(isset($departmentData)) @if($departmentData->greeting == 0 && $departmentData->tts != '') block @else none @endif @endif;">
                                        <label class="form-control-label">TTS</label>
                                        <input type="text" class="form-control" name="tts" value="@if(isset($departmentData) && $departmentData->tts != '' ) {{$departmentData->tts}} @else @endif " placeholder="TTS">
                                    </div>
                                    <div class="col-md-6" id="mp3" style="@if(isset($departmentData) && $departmentData->greeting == 1 ) display: block @else display: none @endif ;" >
                                        <label class="form-control-label">MP3</label>
                                        <input type="file" class="form-control" name="mp3" >
                                    </div>
                                    <div class="col-md-6 forward_number" style="display: @if(isset($departmentData) && $departmentData->calltype == 1 && $departmentData->forward != null) block @else none @endif ;">
                                        <label for="forward_number" class="form-control-label">Forward Number</label>
                                        <input type="text" class="form-control phone-input" name="forward_number" id="forward_number" placeholder="Forward Number" value="@if(isset($departmentData) && $departmentData->calltype == 1 && $departmentData->forward != null) {{ $departmentData->forward }}   @endif">
                                    </div>
                                    <div class="col-md-6">
                                        <label class="form-control-label">Status</label>
                                        <select class="form-control" name="status" required>
                                            <option value="0" @if(isset($departmentData) && $departmentData->status == 0) selected @else  @endif>Active</option>
                                            <option value="1" @if(isset($departmentData) && $departmentData->status == 1) selected @else  @endif>Inactive</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-12" id="audio_recording_div" style="display: @if(isset($departmentData) && $departmentData->greeting == 1) block @else none @endif">
                                @if(!empty($departmentData->mp3))
                                    <label class="form-control-label">Recorded IVR MP3</label>
                                    <div class="wrapperaudio" id="" style="width: 266px; !important;">
                                        <audio preload="auto" controls class="audio">
                                            <source src="{{@$departmentData->mp3}}" type="audio/mpeg"></audio>
                                    </div>
                                @endif
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


                                        <div class="text-right">
                                            {{ Form::button(__('Submit'), ['type' => 'submit','class' => 'btn btn-sm btn-primary rounded-pill']) }}
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



<!-- /Page Content -->
@endsection
@push('script')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/12.1.3/css/intlTelInput.css" />
<script src="https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/12.1.3/js/intlTelInput.min.js"></script>
<script>
$( document ).ready(function() {
        $(".phone-input").length && $(".phone-input").intlTelInput({

       autoHideDialCode: false,
     autoPlaceholder: "on",
     dropdownContainer: "body",

     formatOnDisplay: false,
     geoIpLookup: function(callback) {
       $.get("http://ipinfo.io", function() {}, "jsonp").always(function(resp) {
         var countryCode = (resp && resp.country) ? resp.country : "";
         callback(countryCode);
       });
     },
     hiddenInput: "phone",
     initialCountry: "us",
     nationalMode: false,
     //onlyCountries: ['us', 'gb', 'ch', 'ca', 'do'],
     placeholderNumberType: "MOBILE",
     preferredCountries: ['us'],
     separateDialCode: true,
       utilsScript: "https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/12.1.3/js/utils.js"
   });

   $(".phone-input").blur(function () {
       $.trim($(this).val()) && ($(this).intlTelInput("isValidNumber") ? toastr.clear() : ($(this).val(""), toastr.error("Invalid phone number.", "Oops!", {
           timeOut: null,
           closeButton: !0
       })))
   });
   $(".phone-input").change(function () {

         $('input[name="phone"]').val($(this).intlTelInput("getNumber"));
       $(this).closest(".intl-tel-input").siblings("input[name='phone']").val($(this).intlTelInput("getNumber"));

   });
});
    function show(id)
     {
        //  alert(id)
         if(id==1){
             $('.forward_number').css('display','block');
             $('input[name=forward_number]').attr("required", true);
             $('#mp3, #tts,#audio_recording_div').css('display','none').attr("required", false);
             $('#voice_mail').hide();
         }else{
             $('#voice_mail').show();
             $("#tts").css('display', 'block');
             $('input[name=forward_number]').attr("required", false);
             $('.forward_number,#audio_recording_div').css('display','none');
         }
     }
      function show2(id){
         if(id==1){
             $('#mp3').show();
             $('#mp3').attr("required", true);
             $('#tts').attr("required", false);
             $('#tts').hide();
             $('#audio_recording_div').css('display','block');
         }else{
             $('#tts').show();
              $('#tts').attr("required", true);
              $('#mp3').attr("required", false);
             $('#mp3').hide();
             $('#audio_recording_div').css('display','none');
         }
     }

     $(window).load(function(){
        var checkGreeting = $('input[name=greetings]').val();
        console.log(checkGreeting)
        if(checkGreeting === 1){
            $('#mp3').show();
             $('#mp3').attr("required", true);
             $('#tts').attr("required", false);
             $('#tts').hide();
             $('#audio_recording_div').css('display','block');
         }else{
             $('#tts').show();
              $('#tts').attr("required", true);
              $('#mp3').attr("required", false);
             $('#mp3').hide();
             $('#audio_recording_div').css('display','none');
         }


        var radioType = $('.radioType:checked').val();
        if(radioType==1){
             $('.forward_number').css('display','block');
             $('input[name=forward_number]').attr("required", true);
             $('#mp3, #tts,#audio_recording_div').css('display','none').attr("required", false);
             $('#voice_mail').hide();
         }else{
             $('#voice_mail').show();
             $("#tts").css('display', 'block');
             $('input[name=forward_number]').attr("required", false);
             $('.forward_number,#audio_recording_div').css('display','none');
         }


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
