<div class="content mt-3" >
            <div class="container-fluid">

                <!-- Call Wrapper -->
                <div class="call-wrapper">
                    <div class="call-main-row">
                        <div class="call-main-wrapper">
                            <div class="call-view">
                                <div class="call-window">

                                    <!-- Call Header -->
                                    <div class="fixed-header">
                                        <div class="navbar">
                                            <div class="user-details">
                                                <div class="float-left user-img">
                                                    <a class="avatar avatar-sm mr-2" href="javascript:void(0);" title="{{$user->name}}">
                                                        <img src="{{$user->getAvatarUrl()}}" alt="User Image" class="rounded-circle">
                                                        <span class="status @if(getUserDetails($user->id)->login_status == 0) offline @else online @endif"></span>
                                                    </a>
                                                </div>
                                                <div class="user-info float-left">
                                                    <a href="javascript:void(0);"><span>{{$user->name}} ({{$user->type}})</span></a>
                                                    <span class="last-seen ">@if(getUserDetails($user->id)->login_status == 0) Offline @else Online @endif</span>
                                                </div>
                                            </div>
<!--                                            <ul class="nav float-right custom-menu">
                                                <li class="nav-item dropdown dropdown-action">
                                                    <a href="#" class="nav-link dropdown-toggle" data-toggle="dropdown" aria-expanded="false"><i class="fa fa-cog"></i></a>
                                                    <div class="dropdown-menu dropdown-menu-right">
                                                        <a href="javascript:void(0)" class="dropdown-item">Settings</a>
                                                    </div>
                                                </li>
                                            </ul>-->
                                        </div>
                                    </div>
                                    <!-- /Call Header -->

                                    <!-- Call Contents -->
                                    <div class="call-contents">
                                        <div class="call-content-wrap">
                                            <div class="user-video" id="remote_video_div">
                                                <img src="{{asset('public/assets/img/loader.gif')}}" alt="User Image">
                                            </div>
                                            <div class="my-video">
                                                <ul>
                                                    <li id="local_video_elem">
                                                        <img src="{{Auth::user()->getAvatarUrl()}}" class="img-fluid" alt="User Image">
                                                    </li>
                                                </ul>
                                            </div>
                                        </div>
                                    </div>
                                    <!-- Call Contents -->

                                    <!-- Call Footer -->
                                    <div class="call-footer">
                                        <div class="call-icons">
                                            <!--<span class="call-duration">00:59</span>-->
                                            <ul class="call-items">
<!--                                                <li class="call-item">
                                                    <a id="tglVidMute"  href="javascript:void(0);" title="" data-placement="top" data-toggle="tooltip">
                                                        <i class="fas fa-video camera"></i>
                                                    </a>
                                                    <a style="display: none" class="hide" id="tglVidUnmute" href="javascript:void(0);" title="" data-placement="top" data-toggle="tooltip">
                                                        <i class="fas fa-video-slash camera"></i>
                                                    </a>
                                                </li>
                                                <li class="call-item">
                                                    <a id="tglMute"  href="javascript:void(0);" title="" data-placement="top" data-toggle="tooltip">
                                                        <i class="fa fa-microphone microphone"></i>
                                                    </a>
                                                    <a style="display: none"   id="tglUnmute" class="hide" href="javascript:void(0);" title="" data-placement="top" data-toggle="tooltip">
                                                        <i class="fa fa-microphone-slash microphone"></i>
                                                    </a>
                                                </li>-->
<!--                                                <li class="call-item">
                                                    <a href="" title="Add User" data-placement="top" data-toggle="tooltip">
                                                        <i class="fa fa-user-plus"></i>
                                                    </a>
                                                </li>-->
<!--                                                <li class="call-item">
                                                    <a href="" title="Full Screen" data-placement="top" data-toggle="tooltip">
                                                        <i class="fas fa-arrows-alt-v full-screen"></i>
                                                    </a>
                                                </li>-->
                                            </ul>
                                            <div class="end-call">
                                                <a href="javascript:void(0);" id="disconnectbutton">
                                                    <i class="material-icons">call_end</i>
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                    <!-- /Call Footer -->

                                </div>
                            </div>

                        </div>
                    </div>
                </div>
                <!-- /Call Wrapper -->

            </div>

        </div>
<style>
    .user-video video {
    width: auto !important;
    max-width: 100% !important;
    height: auto !important;
    max-height: 100% !important;
    display: block !important;
    margin: 0 auto !important;
        vertical-align: middle !important;
    border-style: none !important;
}
</style>
<script>
  
    const room='';
    Twilio.Video.createLocalTracks({
       audio: true,
       video: { width: 640 },
    }).then(function(localTracks) {
       return Twilio.Video.connect('{{ $accessToken }}', {
           name: '{{ $roomName }}',
           tracks: localTracks,
           video: { width: 640 },
       });
    }).then(function(room) {
   
       //console.log('Successfully joined a Room: ', room.name);
       show_toastr('Success!', 'Call Initiated', 'success');
        $("#videocalllingoptions").hide();  
       room.participants.forEach(participantConnected);

       var previewContainer = document.getElementById(room.localParticipant.sid);
       if (!previewContainer || !previewContainer.querySelector('video')) {
           participantConnected(room.localParticipant,'local');
       }

       room.on('participantConnected', function(participant) {
           //console.log("Joining: '"   participant.identity   "'");
            show_toastr('Joining!', participant.identity, 'success');
           participantConnected(participant);
       });

       room.on('participantDisconnected', function(participant) {
           //console.log("Disconnected: '"   participant.identity   "'");
             show_toastr('Disconnected!', participant.identity, 'error');
           participantDisconnected(participant);
       });
       
       
       
       
       
       
       
       
       
    });
    // additional functions will be added after this point
    
    function participantConnected(participant,type='') {
  // console.log('Participant "%s" connected', participant.identity);
 
 
   const div = document.createElement('div');
   div.id = participant.sid;
   div.setAttribute("class", "col-md-12");
   //div.innerHTML = "<div style='clear:both'>" + participant.identity + "</div>";

   participant.tracks.forEach(function(track) {
       trackAdded(div, track)
   });

   participant.on('trackAdded', function(track) {
       trackAdded(div, track)
   });
   participant.on('trackRemoved', trackRemoved);


if(type=='local'){
    $("#local_video_elem").html('')
   document.getElementById('local_video_elem').append(div);
}else{
    show_toastr('Connected!', participant.identity, 'success');
    $("#remote_video_div").html('')
    document.getElementById('remote_video_div').append(div);
}
}

function participantDisconnected(participant) {
  // console.log('Participant "%s" disconnected', participant.identity);
show_toastr('Disconnected!', participant.identity, 'error');
   participant.tracks.forEach(trackRemoved);
   document.getElementById(participant.sid).remove();
}
function trackAdded(div, track) {
   div.append(track.attach());
   var video = div.getElementsByTagName("video")[0];
   if (video) {
       video.setAttribute("style", "width:100% !important; height:360px !important;");
   }
}

function trackRemoved(track) {
   track.detach().forEach( function(element) { element.remove() });
}

$('#tglMute').on('click', () => {
      room.localParticipant.audioTracks.forEach(function (audioTrack) {
       audioTrack.disable();
       });
       $('#tglMute').hide();
       $('#tglUnmute').show();
      });

$('#tglUnmute').on('click', () => {
   room.localParticipant.audioTracks.forEach(function (audioTrack) {
   audioTrack.enable();
   });
    $('#tglMute').show();
       $('#tglUnmute').hide();
  });

$('#tglVidMute').on('click', () => {
    $('#local_video_elem').html('<img src="{{Auth::user()->getAvatarUrl()}}" class="img-fluid" alt="User Image">');
  room.localParticipant.videoTracks.forEach(function (videoTrack) {
   videoTrack.disable();
   });
      $('#tglVidUnmute').show();
       $('#tglVidMute').hide();
  });

$('#tglVidUnmute').on('click', () => {
   room.localParticipant.videoTracks.forEach(function (videoTrack) {
   videoTrack.enable();
   });
   $('#tglVidUnmute').hide();
       $('#tglVidMute').show();
  });
  
$('#disconnectbutton').on('click', () => {
    show_toastr('Disconnected!', 'Call ended', 'error');
   $("#video_call_div").html('');
     location.reload();
   // room.disconnect();
  });
  
  
</script>