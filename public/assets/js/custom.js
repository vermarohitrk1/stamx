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
        $('#mentor_search').parent('div').parent('div').css('display','none');
    }else{
       var mentor = 'yes';
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
                $('.mentorDataMessage').click();
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




/** video chat */

/** mentor chat **/

$(document).on("click", ".mentorDataMessage", function () {
   
    ajaxReq.abort(); 
    $("#loaderGif").show();
    var userId = $(this).attr('data-id');
    $(".mentorDataMessage").hide();
    $("#mentorData").hide();
    $("#messageMentor").val(userId);
    $(".sandMessage").show();
    disData2(userId);
    $('#mentor_loader').hide();
    $('.mentor_search_box').css('display','none');
    $("#mentor_search").val('');
    $(".SingleuserChatButton").show();
    $("#loaderGif").hide();
    setCookie("chatUser", userId, 7);

    $('.bottoggle').css('display','none')

    var authid = $(this).attr('data-authid');
    if(userId != 0){ 
        if(handle2){
            clearInterval(handle2)
        }       
        disData3(userId)           
        handle =  setInterval(
            function(){              
                disData3(userId)
            },5000
        );      
    }        
});


 var handle =  setInterval(
    function(){
    },10000
);

var handle2 =  setInterval(
    function(){
    },10000
);

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
   
    if (message != '') {
        if(userId != 0){
            $.post(sendMessage,
                {receiver: userId, messagetext: message},
                function (data) {
                    scrollDown();
                    $("#mentorMessage").val('');
                    disData3(userId);
                   
                }
            );
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
        var html = '<li class="sent sender text-right"><p>'+message+'</p></li>';
    } else{
        var html = '<li class="sent receiver text-left"><p>'+message+'</p></li>';
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
    $("#loaderGif").show(); 
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
    $('.mentor-modal-dialog .modal-body').animate({
        scrollTop: $('.mentor-modal-dialog .modal-body')[0].scrollHeight}, "slow");
}


function disData2(userId) {
    $.post(geMentorMessage,
        {userId: userId,message:0},
        function (data) {                
            $("#messageDiv1").html(data);
            var sent = $("#messageDiv1").find('.sent').length;
            sent = sent - 1;
            $("#messageDiv1").find('.sent').eq(sent).attr('id', 'lastSentMessage');
            $("#loaderGif").hide();  
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


function dialerWindowclose() {
    if (dialerWindow) {
        dialerWindow.close();
        Twilio.Device.disconnectAll();
    }
}

function ProcessChild1() {
    if (WindowSite) {
        WindowSite.close();
        Update();
        callcount = 0;
        eraseCookie("WindowOpen");
        WindowOpen = 0;
    }
}

function show_toastr(title, message, type) {
    var o, i;
    var icon = "";
    var cls = "";

    if (type == "success") {
        icon = "fas fa-check-circle";
        cls = "success";
    } else {
        icon = "fas fa-times-circle";
        cls = "danger";
    }

    $.notify(
        { icon: icon, title: " " + title, message: message, url: "" },
        {
            element: "body",
            type: cls,
            allow_dismiss: !0,
            placement: { from: "top", align: "right" },
            offset: { x: 15, y: 15 },
            spacing: 10,
            z_index: 1080,
            delay: 2500,
            timer: 2000,
            url_target: "_blank",
            mouse_over: !1,
            animate: { enter: o, exit: i },
            template:
                '<div class="alert alert-{0} alert-icon alert-group alert-notify" data-notify="container" role="alert"><div class="alert-group-prepend alert-content"><span class="alert-group-icon"><i data-notify="icon"></i></span></div><div class="alert-content"><strong data-notify="title">{1}</strong><div data-notify="message">{2}</div></div><button type="button" class="close" data-notify="dismiss" aria-label="Close"><span aria-hidden="true">&times;</span></button></div>',
        }
    );
}

//twilio code
var myAudio = document.getElementById("myAudio");
var WindowSite;
var WindowOpen = 0;
var incomingNumber = "";
var clientId = $("#clientid").val();
var t;
var callcount = 0;
var timer;
var dialerWindow;

function logger(message) {
//    console.log(message);
    var log = document.getElementById("logId");
    log.value += "\n> " + message;
    log.scrollTop = log.scrollHeight;
}

function setClientId() {
    var clientId = $("#clientid").val();
    if (clientId === "") {
        clientId = tokenClientId;
    }
}

function getEmail(id) {
    $.ajax({
        url: "/getEmail",
        type: "GET",
        success: function (resposne) {
            var queueName = "queue:" + resposne;
            $("#number").val(queueName);
        },
    });
}

function refresh() {
    $.ajax({
        url: "/twilioToken",
        type: "GET",
        success: function (data) {
//            console.log('test');
            Twilio.Device.setup(data, {
                debug: false,
            });
        },
    });
}

function playAudio() {
    myAudio.play();
}

function pauseAudio() {
    myAudio.pause();
}

function call() {
    logger("++ Make an outgoing call.");
    setClientId();
    logger("+ From: " + clientId);
    logger("+ To:   " + $("#number").val());
    clearTimeout(t);
    window.opener.ProcessChild();
    var params = {
        user_id: $("#adminid").val(),
        To: $("#number").val(),
        From: "client:" + clientId,
    };
    Twilio.Device.connect(params);
}

function callTransfer(childid) {
    $.ajax({
        url: "/callTransfer",
        type: "POST",
        data: { id: childid },
        success: function (data) {},
    });
}

function hangup() {
    logger("Hangup.");
    logger("Call ended.");
    pauseAudio();
    Twilio.Device.disconnectAll();
    $(".dn-btn").css("display", "none");
    $(".ac-btn").css("display", "inline-block");
    $(".ct-btn").css("display", "inline-block");
    if (WindowSite) WindowSite.close();
    eraseCookie("WindowOpen");
    WindowOpen = 0;
}

function openNewWidow(width, height) {
    var top = parseInt(screen.availHeight / 4);
    var left = parseInt(screen.availWidth / 3);

    var features =
        "location=1, status=1, scrollbars=1, resizable=0,toolbar=0,status=0, width=" +
        width +
        ", height=" +
        height +
        ", top=" +
        top +
        ", left=" +
        left;

    WindowSite = window.open("/incomingCall", "popupWindow", features);
    timer = setInterval(OnChildWindowClose, 500);
}

function OnChildWindowClose() {
    if (WindowSite.closed) {
        clearInterval(timer);
        eraseCookie("WindowOpen");
    }
}

function ProcessParent() {
    setClientId();
    getEmail();
    refresh();
    Update();
}

function sendResponse(response) {
    $(".twilio_from").html(response);
}

function Update() {
    $.ajax({
        url: "/queuenumber",
        type: "GET",
        success: (data) => {
            if (parseInt(data) > 0) {
                var y = getCookie("WindowOpen");
                logger(y);
                if (!y) {
                    setCookie("WindowOpen", "1", 7);
                    playAudio();
                    callcount = 1;
                    openNewWidow(350, 250);
                }
            } else {
                if (WindowSite) WindowSite.close();
                pauseAudio();
                eraseCookie("WindowOpen");
            }
        },
    });
    t = setTimeout("Update()", 7000);
}

function queueSize() {
    $.ajax({
        url: "/queue/queueSize",
        type: "GET",
        success: (data) => {
            if (data) {
                $(".qsize").html(parseInt(data));
            } else {
                $(".qsize").html("0");
            }
        },
    });
}

function queueAvgTime() {
    $.ajax({
        url: "/queue/queueAvgTime",
        type: "GET",
        success: (data) => {
            if (data) {
                $(".qavg_time").html(parseInt(data));
            } else {
                $(".qavg_time").html("0");
            }
        },
    });
}

function setCookie(name, value, days) {
    var expires = "";
    if (days) {
        var date = new Date();
        date.setTime(date.getTime() + days * 24 * 60 * 60 * 1000);
        expires = "; expires=" + date.toUTCString();
    }
    document.cookie = name + "=" + (value || "") + expires + "; path=/";
}

function eraseCookie(name) {
    document.cookie =
        name + "=; Path=/; Expires=Thu, 01 Jan 1970 00:00:01 GMT;";
}

function getCookie(name) {
    var nameEQ = name + "=";
    var ca = document.cookie.split(";");
    for (var i = 0; i < ca.length; i++) {
        var c = ca[i];
        while (c.charAt(0) == " ") c = c.substring(1, c.length);
        if (c.indexOf(nameEQ) == 0) return c.substring(nameEQ.length, c.length);
    }
    return null;
}

function ProcessChild() {
    if (WindowSite) {
        clearTimeout(t);
    }
    if (dialerWindow) {
        dialerWindow.statusChange();
    }
}

function statusChange() {
    $(".calling_sec").html(" <h1>connected...</h1>");
}

function buyNumber(num, price, voice, sms, mms, fax) {
    var num_for = $("#num_for").children("option:selected").val();

    $(".cap").html("");
    if (voice == 1) {
        $(".cap").append(
            '<div class="col-md-1"><i class="mdi mdi-phone"></i></div><div class="col-md-11"><b>Voice</b><p>This number can receive incoming calls and make outgoing calls.</p></div>'
        );
    }
    if (sms == 1) {
        $(".cap").append(
            '<div class="col-md-1"><i class="mdi mdi-comment"></i></div><div class="col-md-11"><b>SMS</b><p>This number can send and receive text messages to and from mobile numbers.</p></div>'
        );
    }
    if (mms == 1) {
        $(".cap").append(
            '<div class="col-md-1"><i class="mdi mdi-file-image"></i></div><div class="col-md-11"><b>MMS</b><p>This number can send and receive multi media messages to and from mobile numbers.</p></div>'
        );
    }
    if (fax == 1) {
        $(".cap").append(
            '<div class="col-md-1"><i class="mdi mdi-file-outline"></i></div><div class="col-md-11"><b>Fax</b><p>This number can send and receive facsimiles.</p></div>'
        );
    }

    $(".buynum").html("<h5><b>+" + num + "</h5>");
    $(".buyprice").html("<h3><b>$" + price + "</b></h3> per month");
    $("#buynymbertwilio").val(num);
    $("#buynymberfor").val(num_for);
    $("#buyModal").modal({ backdrop: "static", keyboard: false });
}

function hangupall() {
    $("#call_dialer").hide();
    $("#dialer").hide();
    window.opener.dialerWindowclose();
}

function outgoingCalls(pnumber) {
    if (pnumber.charAt(0) !== "+") {
        var phonenumber = "+" + pnumber;
        var params123 = {
            PhoneNumber: phonenumber,
            caller_id: $("#twilioPhone").val(),
            typecall: "phonecall",
            user_id: $("#adminid").val(),
        };
        Twilio.Device.connect(params123);
    } else {
        var params123 = {
            PhoneNumber: pnumber,
            caller_id: $("#twilioPhone").val(),
            typecall: "phonecall",
            user_id: $("#adminid").val(),
        };
        Twilio.Device.connect(params123);
    }
//    console.log("params123", params123);
    $("#call_dialer").show();
    $("#dialer").hide();
}

$(document).on("click", ".num", function () {
    var sdata = $(this).data("value");
    var num = $(this);
    var text = $.trim(
        num.find(".txt").clone().children().remove().end().text()
    );
    var telNumber = $("#telNumber");
    $(telNumber).val(telNumber.val() + text);
});

$(document).on("click", ".cancel-button", function () {
    var id = $(this).attr("data-id");
    var number = $(this).attr("data-number");
    $("#cancel_id").val(id);
    $("#cancel_number").val(number);
    $("#cancelModal").modal("show");
});

$(document).on("click", ".queue_size", function () {
    queueSize();
});

$(document).on("click", ".queue_avg_time", function () {
    queueAvgTime();
});

$(document).on("click", ".dialer", function () {
    var top = parseInt(screen.availHeight / 4);
    var left = parseInt(screen.availWidth / 3);

    var features =
        "location=1, status=1, scrollbars=1, resizable=no,toolbar=0,status=0, width=" +
        350 +
        ", height=" +
        570 +
        ", top=" +
        top +
        ", left=" +
        left;

    dialerWindow = window.open("/dialer", "dialer", features);
});

$(document).on("click", "#dialer_callbutton", function () {
    var phonenumber = $("#telNumber").val();
    var textph;
    if (phonenumber != "") {
        if ($.isNumeric(phonenumber)) {
            textph = "+" + phonenumber;
        } else {
            textph = phonenumber;
        }
    }
    outgoingCalls(phonenumber);
});

$(document).on("click", "#twilio_search", function () {
    var area_code = $("#area_code").val();
    if (area_code != "") {
        var data = $("#search_twilio").serialize();
        $.ajax({
            url: "/queue/search/number",
            data: data,
            method: "POST",
            headers: {
                "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
            },
            success: function (response) {
                $(".display").css("display", "block");
                var response = JSON.parse(response);
                if (response.success == true) {
                    $("#example").html(response.data);
                } else {
                    var msg =
                        "<h3 style='text-align:center;'>No record found.</h3>";
                    $("#example").html(msg);
                }
            },
        });
    } else {
        return false;
    }
});

// $(document).ready(function () {
//     logger("+++start");

//     setClientId();
//     getEmail();
//     refresh();
//     var callcount = 0;
//     Update();
//     var theConnection;
//     var currentcallSid = "";

//     var tokenClientId = $("#clientid").val();
//     var clientId = tokenClientId;

//     /* Callback to let us know Twilio Client is ready */
//     Twilio.Device.ready(function (device) {
//         logger("Ready.");
//     });

//     Twilio.Device.error(function (error) {
//         logger("Error: " + error.message);
//     });

//     Twilio.Device.connect(function (conn) {
//         logger("Call connected.");
//         logger("+ CallSid: " + conn.parameters.CallSid);
//         theConnection = conn;
//         currentcallSid = conn.parameters.CallSid;
//         $(".ac-btn").css("display", "none");
//         $(".ct-btn").css("display", "none");
//         $(".dn-btn").css("display", "inline-block");
//         callcount = 1;
//         clearTimeout(t);
//         window.opener.ProcessChild();

//         setCookie("CallSid", conn.parameters.CallSid, 7);
//     });

//     Twilio.Device.disconnect((conn, WindowSite, dialerWindow) => {
//         logger("Call ended.");
//         $(".dn-btn").css("display", "none");
//         $(".ac-btn").css("display", "inline-block");
//         $(".ct-btn").css("display", "inline-block");

//         window.opener.ProcessChild1();
//         window.opener.dialerWindowclose();
//         Update();
//         callcount = 0;
//         eraseCookie("WindowOpen");
//         WindowOpen = 0;
//     });

//     Twilio.Device.incoming(function (conn) {
//         logger("RINGING...");

//         logger("+ Incoming call, CallSid: " + conn.parameters.CallSid);
//         logger("+ To:     " + conn.parameters.To);
//         logger("+ From:   " + conn.parameters.From);
//         logger("+ Region: " + Twilio.Device.region());
//         conn.accept();
//     });

//     //twilio code

//     $("select#transfer_call").change(function () {
//         $(this).children("option:selected").val();
//         if (this.value == "0") {
//             //webphone
//             $(".webphonedisplay").css("display", "block");
//             $(".forwarddisplay").css("display", "none");
//             $(".voicemaildisplay").css("display", "none");
//             $("#forward_number").attr("required", false);
//         } else if (this.value == "1") {
//             //forward
//             $(".forwarddisplay").css("display", "block");
//             $(".webphonedisplay").css("display", "none");
//             $(".voicemaildisplay").css("display", "none");
//             $("#forward_number").attr("required", true);
//         } else {
//             // voicemail
//             $(".forwarddisplay").css("display", "none");
//             $(".webphonedisplay").css("display", "none");
//             $(".voicemaildisplay").css("display", "block");
//             $("#forward_number").attr("required", false);
//         }
//     });

//     $("select.greetings").change(function () {
//         $(this).children("option:selected").val();
//         if (this.value == "0") {
//             $("#greeting_text").attr("required", true);
//             $(".greetings-text").css("display", "block");
//             $(".greetings-mp3").css("display", "none");
//         } else if (this.value == "1") {
//             $("#greeting_text").attr("required", false);
//             $(".greetings-text").css("display", "none");
//             $(".greetings-mp3").css("display", "block");
//         }
//     });

//     $("select.voicemail").change(function () {
//         $(this).children("option:selected").val();
//         if (this.value == "0") {
//             $("#voicemail_text").attr("required", true);
//             $(".voicemail-text").css("display", "block");
//             $(".voicemail-mp3").css("display", "none");
//         } else if (this.value == "1") {
//             $("#voicemail_text").attr("required", false);
//             $(".voicemail-text").css("display", "none");
//             $(".voicemail-mp3").css("display", "block");
//         }
//     });

//     $(document).on("click", ".incomingcall_btn", function () {
//         $("#incomingcall_audio").trigger("click");
//     });

//     $(document).on("click", ".mp3_btn", function () {
//         $("#mp3_audio").trigger("click");
//     });

//     $(document).on("click", ".greetings_mp3", function () {
//         $("#greetings_mp3").trigger("click");
//     });

//     $(document).on("click", ".voicemail_mp3", function () {
//         $("#voicemail_mp3").trigger("click");
//     });

//     // $(window).resize();
//     LetterAvatar.transform();
//     $('[data-toggle="tooltip"]').tooltip();

//     $("#commonModal-right").on("shown.bs.modal", function () {
//         $(document).off("focusin.modal");
//     });

//     if ($(".summernote-simple").length) {
//         $(".summernote-simple").summernote({
//             dialogsInBody: !0,
//             minHeight: 200,
//             toolbar: [
//                 ["style", ["bold", "italic", "underline", "clear"]],
//                 ["font", ["strikethrough"]],
//                 ["para", ["paragraph"]],
//             ],
//         });
//     }

//     $(".dropdown-steady").click(function (e) {
//         e.stopPropagation();
//     });
// });

// Common Modal
$(document).on(
    "click",
    'a[data-ajax-popup="true"], button[data-ajax-popup="true"], div[data-ajax-popup="true"], span[data-ajax-popup="true"]',
    function (e) {
        var title = $(this).data("title");
        var size = $(this).data("size") == "" ? "md" : $(this).data("size");
        var url = $(this).data("url");

        $("#commonModal .modal-title").html(title);
        $("#commonModal .modal-dialog").addClass("modal-" + size);

        $.ajax({
            url: url,
            cache: false,
            success: function (data) {
                $("#commonModal .modal-body").html(data);
                $("#commonModal").modal("show");
                commonLoader();
            },
            error: function (data) {
                data = data.responseJSON;
                show_toastr("Error", data.error, "error");
            },
        });
        e.stopImmediatePropagation();
        return false;
    }
);

// Common Modal from right side
$(document).on(
    "click",
    'a[data-ajax-popup-right="true"], button[data-ajax-popup-right="true"], div[data-ajax-popup-right="true"], span[data-ajax-popup-right="true"]',
    function (e) {
        var url = $(this).data("url");

        $.ajax({
            url: url,
            cache: false,
            success: function (data) {
                $("#commonModal-right").html(data);
                $("#commonModal-right").modal("show");
                commonLoader();
            },
            error: function (data) {
                data = data.responseJSON;
                show_toastr("Error", data.error, "error");
            },
        });
    }
);

function commonLoader() {
    LetterAvatar.transform();
    $('[data-toggle="tooltip"]').tooltip();
    if ($('[data-toggle="tags"]').length > 0) {
        $('[data-toggle="tags"]').tagsinput({
            tagClass: "badge badge-primary",
        });
    }

    if ($(".summernote-simple").length) {
        $(".summernote-simple").summernote({
            dialogsInBody: !0,
            minHeight: 200,
            toolbar: [
                ["style", ["bold", "italic", "underline", "clear"]],
                ["font", ["strikethrough"]],
                ["para", ["paragraph"]],
            ],
        });
    }

    var e = $(".scrollbar-inner");
    e.length && e.scrollbar().scrollLock();

    var e1 = $(".custom-input-file");
    e1.length &&
        e1.each(function () {
            var e1 = $(this);
            e1.on("change", function (t) {
                !(function (e, t, a) {
                    var n,
                        o = e.next("label"),
                        i = o.html();
                    t && t.files.length > 1
                        ? (n = (
                              t.getAttribute("data-multiple-caption") || ""
                          ).replace("{count}", t.files.length))
                        : a.target.value &&
                          (n = a.target.value.split("\\").pop()),
                        n ? o.find("span").html(n) : o.html(i);
                })(e1, this, t);
            }),
                e1
                    .on("focus", function () {
                        !(function (e) {
                            e.addClass("has-focus");
                        })(e1);
                    })
                    .on("blur", function () {
                        !(function (e) {
                            e.removeClass("has-focus");
                        })(e1);
                    });
        });

    var e2 = $('[data-toggle="autosize"]');
    e2.length && autosize(e2);
}

// Delete to open modal
(function ($, window, i) {
    // Bootstrap 4 Modal
    $.fn.fireModal = function (options) {
        var options = $.extend(
            {
                size: "modal-md",
                center: false,
                animation: true,
                title: "Modal Title",
                closeButton: true,
                header: true,
                bodyClass: "",
                footerClass: "",
                body: "",
                buttons: [],
                autoFocus: true,
                created: function () {},
                appended: function () {},
                onFormSubmit: function () {},
                modal: {},
            },
            options
        );

        this.each(function () {
            i++;
            var id = "fire-modal-" + i,
                trigger_class = "trigger--" + id,
                trigger_button = $("." + trigger_class);

            $(this).addClass(trigger_class);

            // Get modal body
            let body = options.body;

            if (typeof body == "object") {
                if (body.length) {
                    let part = body;
                    body = body
                        .removeAttr("id")
                        .clone()
                        .removeClass("modal-part");
                    part.remove();
                } else {
                    body =
                        '<div class="text-danger">Modal part element not found!</div>';
                }
            }

            // Modal base template
            var modal_template =
                '   <div class="modal' +
                (options.animation == true ? " fade" : "") +
                '" tabindex="-1" role="dialog" id="' +
                id +
                '">  ' +
                '     <div class="modal-dialog ' +
                options.size +
                (options.center ? " modal-dialog-centered" : "") +
                '" role="document">  ' +
                '       <div class="modal-content">  ' +
                (options.header == true
                    ? '         <div class="modal-header">  ' +
                      '           <h5 class="modal-title">' +
                      options.title +
                      "</h5>  " +
                      (options.closeButton == true
                          ? '           <button type="button" class="close" data-dismiss="modal" aria-label="Close">  ' +
                            '             <span aria-hidden="true">&times;</span>  ' +
                            "           </button>  "
                          : "") +
                      "         </div>  "
                    : "") +
                '         <div class="modal-body">  ' +
                "         </div>  " +
                (options.buttons.length > 0
                    ? '         <div class="modal-footer">  ' +
                      "         </div>  "
                    : "") +
                "       </div>  " +
                "     </div>  " +
                "  </div>  ";

            // Convert modal to object
            var modal_template = $(modal_template);

            // Start creating buttons from 'buttons' option
            var this_button;
            options.buttons.forEach(function (item) {
                // get option 'id'
                let id = "id" in item ? item.id : "";

                // Button template
                this_button =
                    '<button type="' +
                    ("submit" in item && item.submit == true
                        ? "submit"
                        : "button") +
                    '" class="' +
                    item.class +
                    '" id="' +
                    id +
                    '">' +
                    item.text +
                    "</button>";

                // add click event to the button
                this_button = $(this_button)
                    .off("click")
                    .on("click", function () {
                        // execute function from 'handler' option
                        item.handler.call(this, modal_template);
                    });
                // append generated buttons to the modal footer
                $(modal_template).find(".modal-footer").append(this_button);
            });

            // append a given body to the modal
            $(modal_template).find(".modal-body").append(body);

            // add additional body class
            if (options.bodyClass)
                $(modal_template)
                    .find(".modal-body")
                    .addClass(options.bodyClass);

            // add footer body class
            if (options.footerClass)
                $(modal_template)
                    .find(".modal-footer")
                    .addClass(options.footerClass);

            // execute 'created' callback
            options.created.call(this, modal_template, options);

            // modal form and submit form button
            let modal_form = $(modal_template).find(".modal-body form"),
                form_submit_btn = modal_template.find("button[type=submit]");

            // append generated modal to the body
            $("body").append(modal_template);

            // execute 'appended' callback
            options.appended.call(this, $("#" + id), modal_form, options);

            // if modal contains form elements
            if (modal_form.length) {
                // if `autoFocus` option is true
                if (options.autoFocus) {
                    // when modal is shown
                    $(modal_template).on("shown.bs.modal", function () {
                        // if type of `autoFocus` option is `boolean`
                        if (typeof options.autoFocus == "boolean")
                            modal_form.find("input:eq(0)").focus();
                        // the first input element will be focused
                        // if type of `autoFocus` option is `string` and `autoFocus` option is an HTML element
                        else if (
                            typeof options.autoFocus == "string" &&
                            modal_form.find(options.autoFocus).length
                        )
                            modal_form.find(options.autoFocus).focus(); // find elements and focus on that
                    });
                }

                // form object
                let form_object = {
                    startProgress: function () {
                        modal_template.addClass("modal-progress");
                    },
                    stopProgress: function () {
                        modal_template.removeClass("modal-progress");
                    },
                };

                // if form is not contains button element
                if (!modal_form.find("button").length)
                    $(modal_form).append(
                        '<button class="d-none" id="' +
                            id +
                            '-submit"></button>'
                    );

                // add click event
                form_submit_btn.click(function () {
                    modal_form.submit();
                });

                // add submit event
                modal_form.submit(function (e) {
                    // start form progress
                    form_object.startProgress();

                    // execute `onFormSubmit` callback
                    options.onFormSubmit.call(
                        this,
                        modal_template,
                        e,
                        form_object
                    );
                });
            }

            $(document).on("click", "." + trigger_class, function () {
                $("#" + id).modal(options.modal);

                return false;
            });
        });
    };

    // Bootstrap Modal Destroyer
    $.destroyModal = function (modal) {
        modal.modal("hide");
        modal.on("hidden.bs.modal", function () {});
    };
})(jQuery, this, 0);

// Basic confirm box
loadConfirm();

function loadConfirm() {
    $("[data-confirm]").each(function () {
        var me = $(this),
            me_data = me.data("confirm");

        me_data = me_data.split("|");
        me.fireModal({
            title: me_data[0],
            body: me_data[1],
            buttons: [
                {
                    text: me.data("confirm-text-yes") || "Yes",
                    class: "btn btn-sm btn-danger rounded-pill",
                    handler: function () {
                        eval(me.data("confirm-yes"));
                    },
                },
                {
                    text: me.data("confirm-text-cancel") || "Cancel",
                    class: "btn btn-sm btn-secondary rounded-pill",
                    handler: function (modal) {
                        $.destroyModal(modal);
                        eval(me.data("confirm-no"));
                    },
                },
            ],
        });
    });
}
