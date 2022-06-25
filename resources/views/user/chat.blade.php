<?php $page = "chat"; ?>
@extends('layout.dashboardlayout')
@section('content')
<style>
.bottoggle .form-group {
    display: flex;
    align-items: center;
    justify-content: flex-end;
    margin-bottom: 0;
}
span.avatar-img.rounded-circle {
    height: 1.9rem !important;
    width: 1.9rem !important;
    background: rgba(114, 105, 239, .25) !important;
    color: #7269ef !important;
    position: relative;
    display: inline-flex;
    align-items: center;
    justify-content: center;
    vertical-align: middle;
    font-size: 1rem;
    font-weight: 600;
}
ul#chattype .btn-secondary {
    color: #273444;
    background-color: #eff2f7;
    border-color: #eff2f7;
    box-shadow: inset 0 1px 0 rgb(255 255 255 / 15%);
}
.chatDivMessage p {
    text-align: center;
    /* font-size: 0px; */
}
.chatDivMessage p.text-sm.mb-0.mt-3 {
    font-size: 15px !important;
    font-weight: 700;
}



ul#chattype .btn-xs {
    padding: 0.375rem 1rem;
    font-size: 0.75rem;
    line-height: 1.5;
    border-radius: 0.25rem;
	font-weight:800;
}

ul#chattype a.btn.btn-secondary.btn-xs.active {
    color: #273444;
    background-color: #cdd6e6;
    border-color: #c5cfe2;
}
.avatar.rounded-circle + .avatar-child {
    border-radius: 50%;
}
.avatar + .avatar-badge {
    width: 10px;
    height: 10px;
    left: 51px;
    bottom: 13px;
}
.avatar-child {
    position: absolute;	 
  
    border: 2px solid #fff;
   
}
.chat-time span {
    font-size: 10px;
}
h6.text-sm.mb-0.contact-name {
    color: #495057 !important;
    font-weight: 700;
    font-size: 15px !important;
}
p.text-sm {
    font-size: 0.850rem !important;
    color: #8492a6;
    text-align: inherit;
}
.list-group-item-action:focus, .list-group-item-action:hover {
   
    background-color: #e6ebf5 !important;
}
.avatar_c {
    height: 2.9rem !important;
    width: 2.9rem !important;
    background: rgba(114, 105, 239, .25) !important;
    color: #7269ef !important;
    position: relative;
    display: inline-flex;
    align-items: center;
    justify-content: center;
    vertical-align: middle;
    font-size: 1rem;
    font-weight: 600;
}
p.allMessageTiming {
    /* margin: 0; */
    font-size: 12px;
    margin: 0 0 4px 0;
    color: #8492a6;
}
span.meaasgechat {
    width: 18px;
    height: 18px;
    display: flex;
    align-items: center;
    justify-content: center;
    border-radius: 50%;
    color: #ef476f;
    background-color: rgba(239, 71, 111, .18);
    font-size: 10px;
}
.media {
    margin-top: 1px;
}
.bottoggle span.form-control-label {
    font-size: .875rem;
}
.alert.alert-danger.alert-icon.alert-group.alert-notify.animated.fadeInDown {
    z-index: 9999 !important;
}
 .contact-profile {
            position: fixed;
            width: 100%;
            z-index: 999;
            background: #f5f7fb;
        }
		 .contact-profile {
            display: flex;
            height: 70px;
            border-bottom: 1px solid #e7ebee;
            position: relative;
            cursor: pointer;
            position: fixed;
            width: 100%;
            z-index: 99999999;
            background: #f5f7fb;
        }
    
	 .contact-profile .avatar-parent-child {
            padding: 0 20px;
        }
		form#sendMessageForm1 button {
    margin: 0 4px;
}

form#sendMessageForm1 {
    display: flex;
}

.sandMessage {
    width: 100%;
}
</style>
<!-- Page Content -->
<div class="content">
    <div class="container-fluid">
        <div class="settings-back mb-3">
            <a href="dashboard">
                <i class="fas fa-long-arrow-alt-left"></i> <span>Back</span>
            </a>
        </div>
        <div class="row">
            <div class="col-sm-12 mb-4">
                <div class="chat-window">

                    <!-- Chat Left -->
                    <div class="chat-cont-left">
                        <form class="chat-search d-flex align-items-center">
                            <div class="avatar avatar-online mr-3">
							@if(!empty(Auth::user()->getAvatarUrl()))
								<img src="{{Auth::user()->getAvatarUrl()}}" alt="User Image" class="avatar-img rounded-circle">
							
							@else
								  <img src="assets/img/user/user.jpg" alt="User Image" class="avatar-img rounded-circle">
							@endif
							
                              
                            </div>
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <i class="fas fa-search"></i>
                                </div>
                                <input type="text" class="form-control" placeholder="Search" id='mentor_search'>
                            </div>
                        </form>
                        <div class="chat-header">
                            <span>Chats</span>
							
							  <div class="bottoggle" style="width:60%;">
                    <div class="form-group">  
                      <input id="serviceRegion" type="hidden" value="">
                            <span class="form-control-label">Chat</span>
                            <div class="custom-control custom-switch" style="margin-left: 12px;">
                                <input type="checkbox" class="custom-control-input" value="1" name="bot_toggle" id="bot_toggle">
                                <label class="custom-control-label form-control-label" for="bot_toggle">{{__('Bot')}}</label>
                            </div>
                        
                    </div>
                </div>
               
                        </div>
						<div class="">
						  <ul id="chattype" class="nav nav-tabs">
                    <li class="active"><a class="btn btn-rounded btn-secondary btn-xs  active" data-toggle="tab" href="#users_chats">Users</a></li>
                    <li><a data-toggle="tab"  class="btn btn-rounded btn-secondary btn-xs" id="groups_chat_btn"  href="#groups_chat">Groups</a> <a   class=" btn-xs"  href="{{route('chat.groups.list') }}"><span class="btn-inner--icon text-right " title="Manage Groups"><i class="fas fa-users"></i></span></a>
                    </li>
                </ul>
						</div>
                        <div class="chat-users-list">
                            <div class="chat-scroll">
							   
							     <div class="tab-content">
                        <div id="users_chats" class="tab-pane fade active in show">
                            <!-- Chat contacts -->
                            <img class="loaderGif" src="{{ asset('storage') }}/loader/RippleLoder.gif" id="loaderGif" style="display: none;">
                          <div class="list-group list-group-flush userlist" id="mentorData">                    
                </div>
                         
                        </div>
                        <div id="groups_chat" class="tab-pane fade">
                            <!-- Chat contacts -->
                          
                            <div class="list-group list-group-flush groupchatlist" id="GroupChatData">

                            </div>
                           
                        </div>
                    </div>
					
					
					
							   
							   
							
              
							
                            </div>
                        </div>
                    </div>
                    <!-- /Chat Left -->

                    <!-- Chat Right -->
                    <div class="chat-cont-right">
					
						<div id="messageDiv1">
                        
                        </div>
						
						 <div id="GroupmessageDiv">
                        
                        </div>
                        <div class="chat-footer">
                            <div class="input-group">
                             
								
								
							  <input type="hidden" id="authorizationToken" value=""/>
                <div class="sandMessage" style="display: none;">
                    {{ Form::open(['url' => 'send.message','id' => 'sendMessageForm1','enctype' => 'multipart/form-data']) }}
                    <input type="hidden" name="user" value="" id="messageMentor">
                    <input type="textarea" name="message" spellcheck="true" id="mentorMessage" value=""  class="input-msg-send form-control" placeholder="Type Message Here...">
                    
                    <button type="button" id="micBtn"  class="btn btn-success" data-placement="right" title="Speak" data-toggle="tooltip"><i class="fa fa-microphone-alt" aria-hidden="true"></i></button>

                    <button type="submit" name="send" id="sendMessage1" class="btn btn-primary" data-placement="right" title="Send" data-toggle="tooltip"><i
                            class="fa fa-paper-plane" aria-hidden="true"></i></button>
                    
                    <button type="button" id="startSpeakTextAsyncButton" style="display:none;"></button>
                    <div style="display:none;">Did You Mean:<a id='suggestionLink' href='#' onclick='fixSuggestions(this); return false;'></a></div>
                    {{ Form::close() }}
                </div>
							
                            </div>
                        </div>
                  

				  </div>
				  
				  

                    <!-- /Chat Right -->

                </div>
            </div>
        </div>
        <!-- /Row -->

    </div>

</div>		
<!-- /Page Content -->		
@endsection

@push('script')
<script src="https://bank.trymyceo.com/public/js/microsoft-cognitiveservices-speech-sdk-1.16.0/package/distrib/browser/microsoft.cognitiveservices.speech.sdk.bundle.js"></script>
<script src="{{ asset('assets/js/letter.avatar.js') }}"></script>


<script>

var el = document.getElementById('overlayBtn');
if(el){
  el.addEventListener('click', swapper, false);
}
 var authorizationEndpoint = "{{ url('mentors/SST/token') }}";
    var getChatmentorlist = "{{ url('get/chat/mentor/list') }}";
    var chatMessageDelete = "{{ url('chat/message/delete') }}";
    var videoChatDownload = "{{ url('video/chat/download') }}";
    var chatFileDelete = "{{ url('chat/file/delete') }}";
    var sendMessage = "{{ url('send/message') }}";
    var getBotReply = "{{ url('get/bot/reply') }}";
    var geMentorMessage = "{{ url('get/mentor/message') }}";
</script>

<script>

"use strict";

$.ajaxSetup({
    headers: {
       "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
    },
    cache: false,
    complete: function () {
        LetterAvatar.transform();
        $('[data-toggle="tooltip"]').tooltip();
    },
});

$(document).on('change',"input[name='bot_toggle']",function(){

    if ($(this).is(':checked')) {
		var mentor = 'no';
	   $('#chattype').hide();
	   $('#groups_chat').hide();
        $('#mentor_search').parent('div').parent('div').css('display','none');
    }else{
		
		
       var mentor = 'yes';
	     $('#groups_chat').show();
	      $('#chattype').show();
       $('#mentor_search').parent('div').parent('div').css('display','block');
    }
    $('#mentorMessage').val('');

    $.ajax({            
        url :  getChatmentorlist,
        method: 'POST',
        dataType: 'json',
        cache:false,
        data : {getData:1, mentor: mentor},
        beforeSend:function(){
            //$('#mentorData').append("<div id='mentor_loader' style='height:50px'>Loading...</div>");
        },
        success:function(response){
            $("#mentorData").html('');
            $('#mentor_loader').remove();
            $("#mentorData").html(response.output); 
            
            if(mentor == 'no'){
				
	
              //  $('.mentorDataMessage').click();
		
				var userId = 0;
				$("#messageMentor").val(userId);
				$(".sandMessage").show();
				disData2(userId);
				$(".SingleuserChatButton").show();
				setCookie("chatUser", userId, 7);

            }                    
        }
    });
})


$(document).on('click','.delete_msg',function(){
    var msgid = $(this).attr('data-msgid');
    var userid = $(this).attr('data-userid');

    $.post(chatMessageDelete,
        {msgid: msgid},
        function (result) {
            disData3(userid) 
    });
})


function download(url, filename) {
    fetch(url).then(function(t) {
        return t.blob().then((b)=>{
            var a = document.createElement("a");
            a.href = URL.createObjectURL(b);
            a.setAttribute("download", filename);
            a.click();
        }
        );
    });
}

$(document).on("click", "#download_chat", function () {
    var userid = $(this).attr('data-userid');
    var authid = $(this).attr('data-authid');
    $.post(videoChatDownload,
        {userid: userid, authid: authid},
        function (data) {
            var response = JSON.parse(data)
            if(response.data === 1){
                download(response.filename,response.filename2)

                setTimeout(function(){ 
                    $.post(chatFileDelete,
                    {filename: response.filename2},
                    function (result) {
                    });
                 }, 3000);              

            }else{
                show_toastr("Error", 'No record Found.', "error");  
            }
        }
    );
});

/** video chat */
var authuserid = $('#adminid').val();



$(document).on("click", ".myMentorChat", function () {
    $('#myMentorChat').modal('show');
    var cu = getCookie("chatUser");
   
    if(parseInt(authuserid) !== 1){
        var mentor = 'yes';
    }else{
        var mentor = 'no';
    }
    
    $.ajax({            
        url :  getChatmentorlist,
        method: 'POST',
        dataType: 'json',
        cache:false,
        data : {getData:1, mentor: mentor},
        beforeSend:function(){
            //$('#mentorData').append("<div id='mentor_loader' style='height:50px'>Loading...</div>");
        },
        success:function(response){
            $("#mentorData").html('');
            $('#mentor_loader').remove();
            $("#mentorData").html(response.output);                      
        }
    });   
    $("#messageDiv1").html('');
    $(".sandMessage").hide();
    $('#mentor_loader').remove();	
    $('#mentorData a').show();		
    $("#mentor_search").val('');      
    $('.bottoggle').css('display','block');
    $('#mentorMessage').val('');
    $("#mentorData").html('');
    if(mentor == 'no'){
        $('#mentor_search').parent('div').parent('div').css('display','none');
        $( "#bot_toggle" ).prop( "disabled", true );
        $( "#bot_toggle" ).prop( "checked", true );
     
        setTimeout(() => {
            $('.mentorDataMessage').click();
        }, 1000);         
       
    }else{
        $(".mentorDataMessage").show();  
        $("#mentorData").show();      
        $('.mentor_search_box').css('display','block');
        $('.mentor_search_box').children('.chat-search-box').css('display','block');
        $( "#bot_toggle" ).prop( "checked", false );
    }    
});


	
	
	// setInterval(function() {

	// console.log('set time ');
	// var getValue = $('#messageMentor').val();
	// if(getValue){
	 // disData2(getValue);
	
	// }
		// }, 2000);
  
  // setTimeout(function() { 

	// alert(getValue);
    //$("#signInButton").trigger('click');
  // }, 5000); // for 5 second delay 


/** video chat */

/** mentor chat **/

 var handle =  setInterval(
    function(){
    },10000
);

var handle2 =  setInterval(
    function(){
    },10000
);
$(document).on("click", ".mentorDataMessage", function () {
  
    //ajaxReq.abort(); 
    $("#loaderGif").show();
    var userId = $(this).attr('data-id');
  //  $(".mentorDataMessage").hide();
  //  $("#mentorData").hide();
    $("#messageMentor").val(userId);
    $(".sandMessage").show();
	 
     disData2(userId);
  
  
  //  $('#mentor_loader').hide();
  //  $('.mentor_search_box').css('display','none');
   // $("#mentor_search").val('');
    $(".SingleuserChatButton").show();
    $("#loaderGif").hide();
    //setCookie("chatUser", userId, 7);

 
    var authid = $(this).attr('data-authid');
    if(userId != 0){ 
        if(handle2){
            clearInterval(handle2)
        }       
      //  disData3(userId)           
       // handle =  setInterval(
       //     function(){              
        //  //      disData3(userId)
         //   },5000
     //   );      
    }        
});




 $(document).on("click", "#backMessage2", function () {
   
    var cu = getCookie("chatUser");
    if(cu != 0){
        clearInterval(handle);
        eraseCookie("chatUser");
        // handle2 =  setInterval(
        //     function(){              
        //         getMentorData()
        //     },5000
        // );
    }
    $(".mentorDataMessage").show();  
    $("#mentorData").show();      
    $('.mentor_search_box').css('display','block');
    $("#messageDiv1").html('');
    $(".sandMessage").hide();
    $('#mentor_loader').remove();	
    $('#mentorData a').show();		
    $("#mentor_search").val('');      
    $('.bottoggle').css('display','block');
    $('#mentorMessage').val('');
});

$("#sendMessageForm1").submit(function (event) {    
    event.preventDefault();
    var userId = $("#messageMentor").val();
    var message = $("#mentorMessage").val();
	var inbox="user";
 if($("#groups_chat_btn").hasClass('active')){
             inbox="group";
         }
		
    if (message != '') {
        if(userId != 0){
			
			if(inbox =='group'){
					 $.post("{{route('send.message')}}",
					{_token: "{{ csrf_token() }}", receiver: userId, messagetext: message,inbox:inbox},
					function (data) {
						disData(userId);
						$("#mentorMessage").val('');
					}
				);
				}
				
			else{	
				
				$.post(sendMessage,
					{receiver: userId, messagetext: message},
					function (data) {
						scrollDown();
						$("#mentorMessage").val('');
						disData2(userId);
					   
					}
				);
			}
        }else{
            $( "#mentorMessage" ).prop( "disabled", true );
            //message append to bot
            BotMessageSend(message,'right','');
        }
    } else {
        show_toastr("Error", "Please enter message first", 'error');
    }
});

$(document).on("keyup", "#mentor_search", function () {
    var txt = $(this).val();
    if (txt == '') {
        $('.mentorDataMessage').show();
    } else {
        $('.mentorDataMessage').hide();
        jQuery.expr[':'].contains = function (a, i, m) {
            return jQuery(a).text().toUpperCase().indexOf(m[3].toUpperCase()) >= 0;
        };
        $('.contact-name:contains("' + txt + '")').closest('.mentorDataMessage').show();
    }
});

$(document).on("click", ".mentor_name", function(){
    var user_id = $(this).attr('data-id');
    $(".mentorBio").html('');
    $.post(
        "mentor/bio",
        {user_id: user_id},
        function (response) {
            var data = JSON.parse(response);
            if (data.result == true) {
                var html = data.html;
            } else {
                var html = "<h5>No record found.</h5>";
            }
            $(".mentorBio").html(html);
            $('#mentorBio').modal('show'); 
    });       
})

$(document).on("click", ".destroyCertify", function(){
    var id = $(this).attr('data-id');
    $("#mentor_Id").val(id);
    $('#destroyCertify').modal('show');    
});


$(document).ready(function() { 
 
    /** SST **/
   
    var phraseDiv;
    var startRecognizeOnceAsyncButton;
    var subscriptionKey, serviceRegion, languageTargetOptions, languageSourceOptions;
    var authorizationToken;
    var SpeechSDK;
    var recognizer; 
    var startSpeakTextAsyncButton;   
    var voiceName;   
    var player; 
    var first = 0;

    startRecognizeOnceAsyncButton = document.getElementById("micBtn");
    languageTargetOptions = 'en';
    languageSourceOptions = 'en-US';
    phraseDiv =document.getElementById("mentorMessage");
    serviceRegion = document.getElementById("serviceRegion");
    startSpeakTextAsyncButton = document.getElementById("startSpeakTextAsyncButton");
    voiceName = 'en-US-ZiraRUS';
   
    getMentorData();

    function RequestAuthorizationToken() {
   
        if (authorizationEndpoint) {
			
            var a = new XMLHttpRequest();
            a.open("GET", authorizationEndpoint);
            a.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
            a.send("");
            a.onload = function() {
                var token = JSON.parse(atob(this.responseText.split(".")[1]));    
                serviceRegion.value = token.region;
                authorizationToken = this.responseText;
				
                $('#authorizationToken').val(authorizationToken);
               //console.log("Got an authorization token: " + token);            
                wakeword();  
                
            }
        }
    }

    function applyCommonConfigurationTo(recognizer) {
        recognizer.recognizing = onRecognizing;
        recognizer.canceled = onCanceled;
    }

    function onRecognizing(sender, recognitionEventArgs) {
        var result = recognitionEventArgs.result;
        let wake_word  = $('#bot_wake_word').val()
        let res = result.text.toLowerCase().trim();
        if(res == wake_word.toLowerCase().trim()){
            if($('#myMentorChat').is(":hidden")){           
                $('#myMentorChat').modal('show');
                $( "#bot_toggle" ).prop( "checked", true );
                var mentor = 'no';
                $('#mentor_search').parent('div').parent('div').css('display','none');
                $('#mentorMessage').val('');
                first = 1;
                $.ajax({            
                    url : getChatmentorlist,
                    method: 'POST',
                    dataType: 'json',
                    cache:false,
                    data : {getData:1, mentor: mentor},
                    beforeSend:function(){
                    },
                    success:function(response){
                        $("#mentorData").html('');
                        $('#mentor_loader').remove();
                        $("#mentorData").html(response.output);   
                        $('.mentorDataMessage').click();                   
                    }
                });                          
            }
        }else{
            if(!$('#myMentorChat').is(":hidden")){
                if($("#mentorMessage").prop('disabled') === false)
                {  
                    if(parseInt(first) === 1){
                        setTimeout(() => {
                            phraseDiv.value = res.trim();
                            first = 2;
                        }, 1000);
                    }else{
                        if(res.includes(wake_word.toLowerCase().trim())){
                            var myNewString = res.replace(wake_word.toLowerCase().trim(), "");
                            phraseDiv.value = myNewString.trim();
                           
                        }  
                    }                                    
                }                
            }
        }
    }

    function onCanceled (sender, cancellationEventArgs) {
        window.console.log(e.errorDetails);
    }

    function wakeword(){
        if (authorizationToken) {
          // console.log('authorizationToken',authorizationToken)
            var serviceRegion = document.getElementById("serviceRegion");
            var languageTargetOptions = 'en';
            var languageSourceOptions = 'en-US';
            var voiceName = 'en-US-ZiraRUS';
            var recognizer; 
            var speechConfig1;

            speechConfig1 = SpeechSDK.SpeechTranslationConfig.fromAuthorizationToken(authorizationToken, serviceRegion.value);
            speechConfig1.speechRecognitionLanguage = languageSourceOptions;
            let language = languageTargetOptions
            speechConfig1.addTargetLanguage(language)
    
            var audioConfig  = SpeechSDK.AudioConfig.fromDefaultMicrophoneInput();
            recognizer = new SpeechSDK.SpeechRecognizer(speechConfig1, audioConfig);
            applyCommonConfigurationTo(recognizer);
            recognizer.startContinuousRecognitionAsync();
          
        } else {        
            show_toastr("Error", "Please update speech api key from setting page.", 'error');
        }
    }   

    if (!!window.SpeechSDK) {
        SpeechSDK = window.SpeechSDK;
        startRecognizeOnceAsyncButton.disabled = false;
        if (typeof RequestAuthorizationToken === "function") {
            RequestAuthorizationToken();
        }
    }
    
    /** TTS **/
    startSpeakTextAsyncButton.addEventListener("click", function () {       
        $.get( "processing-speechvoice", ( data1 ) => {
            let inputText = $('#mentorMessage').val();
            if(data1 == ""){
                data1 = $("#speech_bot_voice").val();
            }
            TextToSpeech(inputText,data1)
            $("#mentorMessage").val('');
        });
    });
    /** TTS **/


    /** SST **/
    startRecognizeOnceAsyncButton.addEventListener("click", function () {
        startRecognizeOnceAsyncButton.disabled = true;
        phraseDiv.value = "";     

        var serviceRegion = document.getElementById("serviceRegion");
        var languageTargetOptions = 'en';
        var languageSourceOptions = 'en-US';
        var recognizer2; 
        var speechConfig2;

        if (authorizationToken) {
			
		
            speechConfig2 = SpeechSDK.SpeechTranslationConfig.fromAuthorizationToken(authorizationToken, serviceRegion.value);
        } else {        
		
		
            show_toastr("Error", "Please update speech api key from setting page.", 'error');
            startRecognizeOnceAsyncButton.disabled = false;
            return;            
        }

        speechConfig2.speechRecognitionLanguage = languageSourceOptions;
        let language = languageTargetOptions
        speechConfig2.addTargetLanguage(language)

        var audioConfig  = SpeechSDK.AudioConfig.fromDefaultMicrophoneInput();
        recognizer2 = new SpeechSDK.TranslationRecognizer(speechConfig2, audioConfig);
        
        recognizer2.recognizeOnceAsync(
        function (result) {
            startRecognizeOnceAsyncButton.disabled = false;
            let translation = result.translations.get(language);
            window.console.log(translation);
            phraseDiv.value += translation;

            recognizer2.close();
            recognizer2 = undefined;
        },
        function (err) {
            startRecognizeOnceAsyncButton.disabled = false;
            window.console.log(err);
            show_toastr("Error", err, 'error');
            recognizer2.close();
            recognizer2 = undefined;
        });
    });       
    /** SST **/
    
 });

 $(document).on("click", ".mentor-modal-close", function () {
    $('#myMentorChat').modal('hide');
    
    if(handle2){
        clearInterval(handle2)
    }    
});

function TextToSpeech(message,voiceName){   
    var speechConfig;
    var  authorizationToken = $('#authorizationToken').val();
	
    if (authorizationToken) {
        speechConfig = SpeechSDK.SpeechConfig.fromAuthorizationToken(authorizationToken, serviceRegion.value);
    } else {
        if (subscriptionKey.value === "" || subscriptionKey.value === "subscription") {
            show_toastr("Error", "Please update speech api key from setting page.", 'error');
            startSpeakTextAsyncButton.disabled = false;
            return;
        }
        speechConfig = SpeechSDK.SpeechConfig.fromSubscription(subscriptionKey.value, serviceRegion.value);
    }
    speechConfig.speechSynthesisVoiceName = voiceName;
    speechConfig.SpeechSynthesisLanguage = "enUS";

    var player = new SpeechSDK.SpeakerAudioDestination();
    player.onAudioEnd = function (_) {
      window.console.log("playback finished");
      $( "#mentorMessage" ).prop( "disabled", false );
    };
    var audioConfig  = SpeechSDK.AudioConfig.fromSpeakerOutput(player);
    var synthesizer = new SpeechSDK.SpeechSynthesizer(speechConfig, audioConfig);
   
    let inputText = message;
    synthesizer.speakTextAsync(
    inputText,
    function (result) {
        startSpeakTextAsyncButton.disabled = false;        
        if (result.reason === SpeechSDK.ResultReason.SynthesizingAudioStarted) {           
        }
        else if (result.reason === SpeechSDK.ResultReason.SynthesizingAudioCompleted) {          
          
        } else if (result.reason === SpeechSDK.ResultReason.Canceled) {
            show_toastr("Error","synthesis failed. Error detail: " + result.errorDetails + "\n", 'error');
        } 
        
        if(player){
            $( "#mentorMessage" ).prop( "disabled", true );
        }else{
            $( "#mentorMessage" ).prop( "disabled", false );
        }
        
       // window.console.log(result);
        synthesizer.close();
        synthesizer = undefined;
    },
    function (err) {
      //  console.log(err)
        startSpeakTextAsyncButton.disabled = false;                
        show_toastr("Error",err, 'error');
        synthesizer.close();
        synthesizer = undefined;
        $( "#mentorMessage" ).prop( "disabled", false );
    }); 
}

function BotMessageSend(message,direction,voice){  

    if(direction == 'right'){
        var html = ' <li class="media sent"> <div class="media-body"><div class="msg-box"><div><p>'+message+'</p></div></div></div></li>';
    } else{
		
	
        var html = '  <li class="media received"> <div class="avatar"><img src="assets/img/user/user.jpg" alt="User Image" class="avatar-img rounded-circle">  </div><div class="media-body">   <div class="msg-box"> <div>  <p>'+message+'</p>   </div> </div>  </div></li>';
        TextToSpeech(message,voice)
    }        
	
	
    $("#messageDiv1 .messages ul").append(html);
    $("#mentorMessage").val('');
    scrollDown();
    if(direction == 'right'){
		

        BotGetReply(message);
    }
}

function BotGetReply(message){
   // $("#loaderGif").show(); 
   
    $.post(getBotReply,
        { message: message},
        function (data) {     
            var result = JSON.parse(data); 
			
		
            setTimeout(function() {
			
                BotMessageSend(result.answer,'left',result.voice)
            }, 2000);
        }
    );
    $("#loaderGif").hide(); 
}

function scrollDown(){
    $('.chat-cont-right .chat-body').animate({
        scrollTop: $('.chat-cont-right .chat-body').offset().top  }, 500);
}


function disData2(userId) {
	
	
    $.post(geMentorMessage,
        {userId: userId,message:0},
        function (data) {        
	//  $("#messageDiv1").show();
				//  $("#GroupmessageDiv").hide();
            $("#messageDiv1").html(data);
            var sent = $("#messageDiv1").find('.sent').length;
            sent = sent - 1;
            $("#messageDiv1").find('.sent').eq(sent).attr('id', 'lastSentMessage');
         //   $("#loaderGif").hide();  
           scrollDown(); 
                               
        }
    );
}

function disData3(userId){
    $.post(geMentorMessage,
    {userId: userId,message:1},
    function (data) {                
        $("#messageDiv1 .messages").html(data);
        var sent = $("#messageDiv1").find('.sent').length;
        sent = sent - 1;
        $("#messageDiv1").find('.sent').eq(sent).attr('id', 'lastSentMessage');
        $("#loaderGif").hide();                      
    }
);
}

function getMentorData(){
    
     $.ajax({            
        url :  getChatmentorlist,
        method: 'POST',
        dataType: 'json',
        cache:false,
        data : {getData:1,mentor:'yes'},
        beforeSend:function(){
            //$('#mentorData').append("<div id='mentor_loader' style='height:50px'>Loading...</div>");
        },
        success:function(response){
            if(response.mentors != 1) {              
                $('#mentor_loader').remove();
                $("#mentorData").html(response.output);                
            }else{               
                $('#mentor_loader').remove();
                $("#mentorData").html(response.output);                      
            }
        }
    });
}    
/** mentor chat **/


$(document).ready(function() {
 
});
    $(document).on("click", ".groupDataMessage", function () {
		//ajaxReq.abort(); 
       // $(".loaderGif").show();
        var userId = $(this).attr('data-id');

       /// $(".groupDataMessage").hide();
        $("#messageMentor").val(userId);
        $(".sandMessage").show();
        disData(userId);
		//	$('#user_loader').hide();
        $("#mentor_search").val('');
        $(".SingleuserChatButton").show();
    });
   
    $("#sendMessageForm").submit(function (event) {      
        event.preventDefault();
        var userId = $("#messageUser").val();
        var message = $("#userMessage").val();
        var inbox="user";
         if($("#groups_chat_btn").hasClass('active')){
             inbox="group";
         }
		 
		 alert(inbox);
        if (message != '') {
            $.post("{{route('send.message')}}",
                {_token: "{{ csrf_token() }}", receiver: userId, messagetext: message,inbox:inbox},
                function (data) {
                    disData(userId);
                    $("#userMessage").val('');
                }
            );
        } else {
            show_toastr('{{__('Error')}}', "Please enter message first", 'error');
        }
    });
     function disData(userId) {
         var inbox="user";
         if($("#groups_chat_btn").hasClass('active')){
             inbox="group";
         }
	//	 alert(inbox);
        $.post("{{route('get.group.message')}}",
            {_token: "{{ csrf_token() }}", userId: userId,inbox:inbox},
            function (data) {
                if(inbox=="group"){
				//	alert(data);
			//	  $("#messageDiv1").hide();
				//  $("#GroupmessageDiv").show();
                $("#messageDiv1").html(data);
                var groupsent = $("#messageDiv1").find('.sent').length;
                groupsent = groupsent - 1;
                $("#messageDiv1").find('.sent').eq(sent).attr('id', 'lastSentMessage');
                }
             $(".loaderGif").hide();
            }
        );
    }
	

    function disUserListData() {
        $.post("{{route('get.message.user.list')}}",
            {_token: "{{ csrf_token() }}"},
            function (data) {
                $(".userlist").html(data);
                $(".loaderGif").hide();
            }
        );
    }
    $(document).on("keyup", "#user_search", function () {
        var txt = $(this).val();
        var inbox="user";
         if($("#groups_chat_btn").hasClass('active')){
             inbox="group";
         }
         
         
         if(inbox=="group"){
             if (txt == '') {
            $('.groupDataMessage').show();
        } else {
            $('.groupDataMessage').hide();
            jQuery.expr[':'].contains = function (a, i, m) {
                return jQuery(a).text().toUpperCase().indexOf(m[3].toUpperCase()) >= 0;
            };
            $('.contact-name:contains("' + txt + '")').closest('.groupDataMessage').show();
        }
         }else{
         
        if (txt == '') {
            $('.userDataMessage').show();
        } else {
            $('.userDataMessage').hide();
            jQuery.expr[':'].contains = function (a, i, m) {
                return jQuery(a).text().toUpperCase().indexOf(m[3].toUpperCase()) >= 0;
            };
            $('.contact-name:contains("' + txt + '")').closest('.userDataMessage').show();
        }
        
         }
    });
    $(document).on("click", "#bankInvite", function () {
        $("#bankModal").modal('show');
    });

$(document).ready(function(event){
               $(document).on("click", "#groups_chat_btn", function () {
				 

         if(groupchat == 1){
		 getPostData();
		 }
        });
        
       
 
    var start = 0;
    var limit = 5;
	var page=0;
    var reachedMax = false;
	var users =1;
	var groupchat =1;     
	
    getPostData();
    
    
    
    
   function getPostData(){
	  
	   var inbox="user";
         if($("#groups_chat_btn").hasClass('active')){
             inbox="group";
         }
      $.ajax({
		  
        url :  "{{ url('/get/chat/user/list') }}",
        method: 'POST',
        dataType: 'text',
        cache:false,
        data : {getData:1,start:start,limit:limit ,page:page,inbox:inbox},
		beforeSend:function(){
                    if(inbox=="user"){
			$('#userData').append("<div id='user_loader' style='height:50px'>Loading...</div>");
                    }else{
			$('#GroupChatData').append("<div id='group_loader' style='height:50px'>Loading...</div>");
                    }
		},
        success:function(response){

            if(inbox=="user"){
             $('#user_loader').remove();
         }else{
             $('#group_loader').remove();
         }
          if(response=="") {
              if(inbox=="user"){
            users = 0; 
              }else{
            groupchat = 0;  
              }	 
			
			
                        
          }else{
              if(inbox=="user"){
          
              }else{
             $("#GroupChatData").append(response); 
             groupchat = 0;  
              }	 
          }
        }
      });
    }
        });
</script>
@endpush