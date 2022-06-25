@php $page = "ivrsetting"; @endphp
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
				                <h2 class="breadcrumb-title">Ivr Setting</h2>
				                <nav aria-label="breadcrumb" class="page-breadcrumb">
				                    <ol class="breadcrumb">
				                        <li class="breadcrumb-item"><a href="{{route('dashboard')}}">Home</a></li>
				                        <li class="breadcrumb-item active" aria-current="page">Ivr Setting</li>
				                    </ol>
				                </nav>
				            </div>
				        </div>
				    </div>
				</div>

				<div class="row mt-3" id="blog_view">
					<div class="col-12">
						<div class="card">
					<div class="card-body">
						<form action="{{route('ivrsetting.store') }}" method="POST" enctype="multipart/form-data">
							@csrf
                            <input type="hidden" name="id" value="{{@$ivr->id}}">
							<div class="form-group">
					            <div class="row">
					            	<div class="col-md-6">
                                        <label class="form-control-label">Set Timezone</label>
                                        <select class="form-control" name="timezone">
                                            @foreach($timezones as $key => $val)
                                                <option value="{{$val}}" {{$val == @$ivr->timezone ? 'selected' : ''}}>{{$key}}</option>
                                            @endforeach
                                        </select>
						            </div>
						            <div class="col-md-6">
						                  <label class="form-control-label">Auto Attendent</label>
						                   <select class="form-control" name="twilio_voice">
						                        <option value="0" {{@$ivr->twilio_voice == '0' ? 'selected' : ''}} >Man</option>
						                        <option value="1" {{@$ivr->twilio_voice == '1' ? 'selected' : ''}} >Women</option>
                                                <option value="2" {{@$ivr->twilio_voice == '2' ? 'selected' : ''}}  >Alice</option>
                                           </select>
						            </div>
					            </div>
                            </div>
                            <div class="form-group">
                                <div class="row">
                                    <div class="col-md-12">
                                        <label class="form-control-label">Transfer Call
                                        </label>
                                        <div class="form-check">
                                            <input class="form-check-input"  type="radio" name="transfer_call" id="exampleRadios1" value="1" onchange="show(1)" @if(!empty($ivr->transfer_call)){{@$ivr->transfer_call == 1 ?  'checked' : ''}} @else checked @endif>
                                            <label class="form-check-label" for="exampleRadios1"> IVR</label>
                                        </div>
                                        <div class="form-check">
                                            <input class="form-check-input"   type="radio" name="transfer_call" id="exampleRadios2" value="2" onchange="show(2)" {{@$ivr->transfer_call == 2 ?  'checked' : ''}}>
                                            <label class="form-check-label" for="exampleRadios2">Voicemail</label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div id="voice_input"   style="display: none">
	                            <div class="form-group">
	                                <div class="row">
	                                    <div class="col-md-12">
	                                        <label class="form-control-label">Voicemail Input
	                                        </label>
	                                        <div class="form-check">
	                                            <input class="form-check-input"  type="radio" name="voicemail" id="exampleRadios3" value="0" onchange="show2(0)" {{@$ivr->voicemail == 0 ? 'checked' : ''}}>
	                                            <label class="form-check-label" for="exampleRadios3"> TTS</label>
	                                        </div>
	                                        <div class="form-check">
	                                            <input class="form-check-input"  type="radio" name="voicemail" id="exampleRadios4" value="1" onchange="show2(1)" {{@$ivr->voicemail == 1 ? 'checked' : ''}}>
	                                            <label class="form-check-label" for="exampleRadios4">MP3</label>
	                                        </div>
	                                    </div>
                                    </div>
                                </div>
                                <div class="form-group">
	                                <div class="row">
                                        <div class="col-md-6" id="voicemail_text_input" >
	                                        <label class="form-control-label">Voicemail Text</label>
	                                        <textarea type="text" class="form-control" name="voicemail_text" id="voicemail_text">{!! @$ivr->voicemail_text !!}</textarea>
	                                    </div>
                                    </div>
	                                    <div  id="voicemail_mp3_input"  style="display: none" >
	                                        <div class="row">
		                                         <div class="col-md-6" >
			                                         <label class="form-control-label">Voicemail MP3</label>
			                                        <input type="file" name="voicemail_mp3" class="form-control" id="voicemail_mp3">
		                                          </div>
	                                    	</div>
                                            <div class="col-md-6" >
                                            </div>
                                            <div class="col-md-12" >

                                                @if(!empty($ivr->voicemail_mp3))
                                                <label class="form-control-label">Recorded IVR MP3</label>
                                                    <div class="wrapperaudio" id="" style="width: 266px; !important;">
                                                        <audio preload="auto" controls class="audio">
                                                            <source src="{{@$ivr->voicemail_mp3}}" type="audio/mpeg"></audio>
                                                    </div>
                                                @endif
                                            </div>
	                                    </div>

                            	</div>
                            </div>
                            <div id="ivr_input"  @if(empty($ivr->transfer_call))  style="display: block"  @endif>
	                            <div class="form-group">
	                                <div class="row">
	                                    <div class="col-md-12">
	                                        <label class="form-control-label">IVR input
	                                        </label>
	                                        <div class="form-check">
	                                            <input class="form-check-input" type="radio" name="ivr" id="exampleRadios5" value="0" onchange="show3(0)" {{@$ivr->ivr == 0 ? 'checked' : ''}}>
	                                            <label class="form-check-label" for="exampleRadios5"> TTS</label>
	                                        </div>
	                                        <div class="form-check">
	                                            <input   class="form-check-input" type="radio" name="ivr" id="exampleRadios6" value="1" onchange="show3(1)" {{@$ivr->ivr == 1 ? 'checked' : ''}}>
	                                            <label class="form-check-label" for="exampleRadios6">MP3</label>
	                                        </div>
	                                    </div>
                                    </div>
                                </div>
                                <div class="form-group" id="ivr_text_input" >
                                    <div class="row">
	                                    <div class="col-md-6"   >
	                                        <label class="form-control-label">IVR Text</label>
	                                        <textarea type="text" name="ivr_text" class="form-control" id="ivr_text" placeholder="press 1 for support">{!! @$ivr->ivr_text !!}</textarea>
	                                    </div>
                                    </div>
                                </div>

                                <div class="form-group" id="ivr_mp3_input"  style="display: none">
                                    <div  class="row"  >
                                        <div class="col-md-6" >
                                            <label class="form-control-label">IVR MP3 </label>
                                            <input type="file" name="ivr_mp3" class="form-control" id="ivr_mp3" >
                                        </div>
                                        <div class="col-md-6" >
                                        </div>
                                        <div class="col-md-12" >

                                            @if(!empty($ivr->ivr_mp3))
                                            <label class="form-control-label">Recorded IVR MP3</label>
                                                <div class="wrapperaudio" id="" style="width: 266px; !important;">
                                                    <audio preload="auto" controls class="audio">
                                                        <source src="{{@$ivr->ivr_mp3}}" type="audio/mpeg"></audio>
                                                </div>
                                            @endif
                                        </div>

                                    </div>
                                </div>
                            </div>
                            <div class="col-md-12" id="audio_recording_div" style="display:none">
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
                                <button type="submit" class="btn btn-sm btn-primary rounded-pill">Save</button>

                            </div>
			            </form>
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
<script>
		var transfer_call =  "{{$ivr->transfer_call ?? '' }}";
		var voicemail = "{{$ivr->voicemail  ?? '' }}";
		var ivr = "{{$ivr->ivr ?? '' }}";
		if(transfer_call == 2){
			show(2);
		}else{
			show(1);
		}
		if(voicemail == 1){
			show2(1);
		}else{
			show2(0);
		}
		if(ivr == 1){
			show3(1);
		}else{
			show3(0);
		}
        function show3(id)
        {
            if(id==1){
                $('#ivr_text_input').hide();
                $('#ivr_mp3_input').show();

            }else {
                $('#ivr_text_input').show();
                $('#ivr_mp3_input').hide();
            }
             //audio recording
            audio_recording_function();
        }
        function show2(id)
        {
            if(id==1){
                $('#voicemail_text_input').hide();
                $('#voicemail_mp3_input').show();
            }else {
                $('#voicemail_text_input').show();
                $('#voicemail_mp3_input').hide();
            }
             //audio recording
            audio_recording_function();
        }
        function show(id)
        {
            if(id==1){
                $('#voice_input').hide();
                $('#ivr_input').show();

            }else{
                $('#voice_input').show();
                $('#ivr_input').hide();
            }

            //audio recording
            audio_recording_function();
        }
        function audio_recording_function()
        {

            if($('#voicemail_mp3_input').is(':visible') || $('#ivr_mp3_input').is(':visible')){
                $('#audio_recording_div').show();
            }else{
                $("#recorded_file").html('');
                $('#audio_recording_div').hide();
            }
        }

          function downloadJSAtOnload() {
            //audio recording
            audio_recording_function();
            }

    if (window.addEventListener)
        window.addEventListener("load", downloadJSAtOnload, false);
    else if (window.attachEvent)
        window.attachEvent("onload", downloadJSAtOnload);
    else
        window.onload = downloadJSAtOnload;

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
