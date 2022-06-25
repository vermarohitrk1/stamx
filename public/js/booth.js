const cameraVideo = document.querySelector("#camera-video");
const cameraCanvas = document.querySelector("#camera-canvas");
const cameraImage = document.querySelector("#camera-image");
const imagePicker = document.querySelector("#image-picker");
const overlay = document.querySelector("#image-overlay");
const trial = document.querySelector("#image-trial");
const imageCanvas = document.querySelector("#camera-image-canvas");
var shouldFaceUser = true;
if (optM==0){
	var optFlip=0;
	var optFlipOrig=0;
}
else{
	var optFlip=1;
	var optFlipOrig=1;
}	
var hasMedia = false;
var img = new Image();
var imgL = new Image();
var isFB=false;
var isSam=false;
var ua="";
var isMobile=false;
var dragElmnt=""
var draggable=1;


function dragElement(elmnt) {
	dragElmnt=elmnt
  var pos1 = 0, pos2 = 0, pos3 = 0, pos4 = 0;
  if (document.getElementById(dragElmnt.id + "header")) {
    // if present, the header is where you move the DIV from:
    document.getElementById(dragElmnt.id + "header").onmousedown = dragMouseDown;
  } else {
    // otherwise, move the DIV from anywhere inside the DIV:
    dragElmnt.onmousedown = dragMouseDown;
	dragElmnt.addEventListener("touchstart", dragMouseDown, { passive: false });
  
  }

}

function dragMouseDown(e) {
	if (draggable==1){
		e = e || window.event;
		e.preventDefault();
		// get the mouse cursor position at startup:
		pos3 = e.clientX;
		pos4 = e.clientY;
		document.onmouseup = closeDragElement;
		document.addEventListener("touchend", closeDragElement);

		// call a function whenever the cursor moves:
		document.onmousemove = elementDrag;
		document.addEventListener("touchmove", elementDrag, { passive: false });
	}
    
  }

function elementDrag(e) {
  if (draggable==1){
    e = e || window.event;
    e.preventDefault();
    // calculate the new cursor position:
	if(isMobile){
		pos1 = pos3 - e.targetTouches[0].pageX;
		pos2 = pos4 - e.targetTouches[0].pageY;
		pos3 = e.targetTouches[0].pageX;
		pos4 = e.targetTouches[0].pageY;
	}
	else{
		pos1 = pos3 - e.clientX;
		pos2 = pos4 - e.clientY;
		pos3 = e.clientX;
		pos4 = e.clientY;
	}
    // set the element's new position:
    dragElmnt.style.top = (dragElmnt.offsetTop - pos2) + "px";
    dragElmnt.style.left = (dragElmnt.offsetLeft - pos1) + "px";
  }
}

  function closeDragElement() {
    // stop moving when mouse button is released:
    document.onmouseup = null;
    document.touchend = null;
	
    document.onmousemove = null;
    document.touchmove = null;
  }
function dragElementStop(elmnt) {
	draggable=0;
	  
}
$(document).ready(function(){
	
	isMobile = window.matchMedia("only screen and (max-width: 760px)").matches;
	if(isMobile){
		$('#countdown').css('top','35%');
		$('.btn-secondary').removeClass('btn-lg');
		$('.btn-secondary').addClass('btn-md');
		cameraVideo.style.transform='scale(-1, 1)';
		if (optM==0){
			optFlip=1;
		}
		else{
			optFlip=0;
		}
	}
	else{
	//var zoomB = `${1 / window.devicePixelRatio * 100}%`;
		//document.querySelector('body').style.zoom = zoomB;
	}
	
   
		
	if ($( window ).height()<700 && !isMobile){
		newheight=$( window ).height()-100;
		ratio=dH/dW;
		newwidth=parseInt(newheight/ratio);
		/*$('#splashImg').css('height',newheight+'px');
		$('#camera-image').attr('height',newheight);
		$('#camera-image').css('height',newheight+'px');
		$('#camera-image').css('width',newwidth);
		$('#frames').css('width',newwidth);
		$('#camera-canvas').css('height',newheight+'px');
		$('#camera-canvas').css('width',newwidth);
		$('#review-wrapper').css('height',newheight+'px');
		$('#review-wrapper').css('width',newwidth);
		$('#camera-image-canvas').css('width',newwidth);
		$('#camera-image-canvas').css('height',newheight+'px');
		$('#camera-wrapper').css('width',newwidth);
		$('#camera-wrapper').css('height',newheight+'px');
		$('#image-overlay').css('height',newheight+'px');
		$('#image-overlay').css('width',newwidth);
		$('#image-overlay2').css('height',newheight+'px');
		$('#image-overlay2').css('width',newwidth);
		$('#image-trial').css('height',newheight+'px');
		$('#image-trial').css('width',newwidth);
		$('#camera-video').css('height',newheight+'px');
		$('#camera-video').css('width',newwidth);
		$('#capture').css('width',newwidth);
		//$('body').css('max-width',newwidth+30);
		$('#stickers').css('width',newwidth+30);
		*/
	}
	$('#file').fileupload();
	
	$('input[type=text], input[type=password], input[type=email], input[type=url], input[type=tel], input[type=number], input[type=search], input[type=date], input[type=time], textarea').focus(function (element, i) {
		if (($(this).value !== undefined && $(this).value.length > 0) || $(this).attr('placeholder') !== null) {
			$(this).siblings('label').addClass('active');
		}
		else {
			$(this).siblings('label').removeClass('active');
		}
	})
	.blur(function (element, i) {
		
		if (($(this).value !== undefined && $(this).value.length > 0) || $(this).val()!= "" || $(this).attr('placeholder') !== null) {
			//$(this).siblings('label').removeClass('active');
		}
		else {
			$(this).siblings('label').removeClass('active');
		}
	});
 
   imgL.onload = function() {
       createFinalPhoto(imgL, imgL.height, imgL.width);
       $("#review").show();
       $("#capture").hide();
	   $("#buttons-approve").show();
	   
	   var imgClone=$("#image-overlay").clone();
		imgClone.addClass('overlap');
	
		imgClone.appendTo(appendTarget);
   };

    $("#image-picker").change(function(evt) {
		optFlip=0;
        var files = evt.target.files;
        var file = files[0];
        if (file.type.match('image.*')) {
            var reader = new FileReader();

            reader.readAsDataURL(file);
            reader.onload = function(evt) {
                if (evt.target.readyState == FileReader.DONE) {
                    imgL.src = evt.target.result;
					
					if(optB==1){
						 creditsOk=0;
						 $.ajax({
							type: "POST",
							url: "https://"+site+"/console/app2.php",
							data: { eventAction: "checkCredits",accountUID: accountUID },
							success: function(response)
							{ 
								var jsonData = JSON.parse(response);
								if (jsonData.success == "1"){
									 if (jsonData.creditsOk==1){
										 creditsOk=1;
									 }
									 else{
										 creditsOk=0;
									 }
								}
								else{
									 creditsOk=0;
								}
							},
							error: function() {
								 creditsOk=0;
							}
						});
					 }
                }
            }
        } else {
            alert("not an image");
        }
    });
	
	 var owl = $('.owl-carousel');
	
	  owl.owlCarousel({
		
		autoWidth : true,
			  margin : 15,
			  nav : true,
			  navText : ["<i class='fas fa-arrow-circle-left'></i>", "<i class='fas fa-arrow-circle-right'></i>"],
			  dots : false,
			  
		responsive: {
		  0: {
			items: 2
		  },
		  
		  600: {
			items: 3
		  },
		  1000: {
			items: 3
		  }
		}
	  })
	owl.on('refreshed.owl.carousel', function(event) {
    $('.owl-stage').css('margin','auto');
 
	
	})
});

var selectedVideoSource = 0;
let videoSources;
var videoSource=0;
var isSafari = !!navigator.userAgent.match(/Version\/[\d\.]+.*Safari/);
var iOS = /iPad|iPhone|iPod/.test(navigator.userAgent) && !window.MSStream;
var isFBSam=false;
$('.flip').click(function(){
	if(iOS){
		  if(shouldFaceUser==true){
			  cameraVideo.style.transform='scale(1, 1)';
			  optFlip=0;
		  }
		  else{
			  cameraVideo.style.transform='scale(-1, 1)';
			  if (optM==0){
					optFlip=1;
				}
				else{
					optFlip=0;
				} 
		  }
		cameraVideo.pause()
		cameraVideo.srcObject = null 
		shouldFaceUser = !shouldFaceUser;
		startBooth();
	}
	else{
	//alert(videoSources.length)
		if(selectedVideoSource<videoSources.length-1){
			selectedVideoSource++;
		}
		else{
			selectedVideoSource=0;
		}
		//alert(videoSources[selectedVideoSource].label)
		videoSource=videoSources[selectedVideoSource].deviceId;
		 
		//cameraVideo.pause()
		//cameraVideo.srcObject = null
		startBooth()
	}
	

})

function gotDevices(deviceInfos) {
  for (let i = 0; i !== deviceInfos.length; ++i) {
    const deviceInfo = deviceInfos[i];
    if (deviceInfo.kind === 'videoinput') {
	  videoSources.push(deviceInfo.deviceId);
    }
  }
}
var userInput="";
//Splash
$(".startBooth").on ("click", function() {
	if (optD==1 && optUI!=1){
		Swal.fire({
			  title:'',
			  html:optDT
		}).then((result) =>{
			$("#splash").hide();
			 $("#capture").show();
			 startBooth();
		})
	}
	else if (optD==1 && optUI==1){
		$('#image-overlay').hide()
		Swal.fire({
			  title:'',
			  html:optDT
		}).then((result) => {
			Swal.fire({
			  title: optUIT,
			  html: '<input type="text" id="userText" class="swal2-input">',
			  confirmButtonText: 'Ok',
			  focusConfirm: false,
			  preConfirm: () => {
				userText = Swal.getPopup().querySelector('#userText').value
			  }
			}).then((result) =>{
			if(numFrames>1){
				$(".frame").eq(0).click();
			}
			else{
				//var iFrame = document.getElementById('textFrame');
				//iFrame.contentWindow.postMessage({img : $("#image-overlay").attr("src"), userText: userText});
				addText($("#image-overlay").attr("src"), userText);
			}
			})
		})
	}
	else if (optUI==1 && optD!=1){
		$('#image-overlay').hide()
		Swal.fire({
		  title: optUIT,
		  html: '<input type="text" id="userText" class="swal2-input">',
		  confirmButtonText: 'Ok',
		  focusConfirm: false,
		  preConfirm: () => {
			userText = Swal.getPopup().querySelector('#userText').value
		  }
		}).then((result) =>{
			if(numFrames>1){
				$(".frame").eq(0).click();
			}
			else{
				//var iFrame = document.getElementById('textFrame');
				//iFrame.contentWindow.postMessage({img : $("#image-overlay").attr("src"), userText: userText});
				addText($("#image-overlay").attr("src"), userText);
			}
				
		})
	}
	else{
	 $("#splash").hide();
     $("#capture").show();
	 startBooth();
	}
})
function startBooth(){
	if(optBoom==0 && optGif==0 && optLib==1){
		  //$("#takePhoto-pre").click()
			$("#takePhoto-pre").addClass('hideMe');
			$("#takeGIF").addClass('hideMe');
			$("#takeBoomerang").addClass('hideMe');
			$("#takePhoto").removeClass('hideMe');
			$("#openLibrary").removeClass('hideMe');
	  }
	function hasGetUserMedia() {
        return !!(navigator.mediaDevices && navigator.mediaDevices.getUserMedia);
    }
	var ua = navigator.userAgent || navigator.vendor || window.opera;
    isFB = (ua.indexOf("FBAN") > -1) || (ua.indexOf("FBAV") > -1);
    isSam = (ua.indexOf("SM-G") > -1) || (ua.indexOf("SM-N") > -1);
	
	isFBSam=false;
	if(isFB==true && isMobile==true && iOS==false){
		isFBSam=true;
	}
	
    hasMedia = hasGetUserMedia();

	if (window.stream) {
		window.stream.getTracks().forEach(track => {
		  track.stop();
		});
	}
	
    //if (hasMedia==true && isFB==false ) {
	
	if (hasMedia==true && isFBSam==false) {
        navigator.mediaDevices
            .getUserMedia({
				video: {
					facingMode:  shouldFaceUser ? 'user' : 'environment',
					width: {
						ideal: 1920
					},
					height: {
						ideal: 1080
					},
					deviceId: videoSource ? {exact: videoSource} : undefined
				},
				audio: false
			})
            .then(function(stream) {
                 window.stream = stream; 
                track = stream.getTracks()[0];
                cameraVideo.srcObject = stream;
            })
			.then(() => navigator.mediaDevices.enumerateDevices())
              .then(deviceInfos => {
				videoSources = Array.from(deviceInfos).filter(item => item.kind == "videoinput")
				
				if(( isMobile && hasMedia) || videoSources.length>1) {
				  $('.flip').show();
				  
				}
			  })
            .catch(function(error) {
				console.log(error)
            });
    } else {
        //imagePicker.click();
	    // tAgent = navigator.userAgent;
         tUrl = window.location.href;
		 Swal.fire({
			  title:'Warning!',
			  html:'For camera access, please use Chrome or Safari.',
			  icon: 'warning'
		}).then((result)=>{
			$("#splash").hide();
			$("#capture").show();
			
			$("#takeGIF").addClass('hideMe');
			$("#takeBoomerang").addClass('hideMe');
		})
    }
};
$("#openLibrary").click(function() {
	action="photo";
	imagePicker.click();
})
$("#takePhoto-pre").click(function() {
	action="photo";
	$("#takePhoto-pre").addClass('hideMe');
	$("#takeGIF").addClass('hideMe');
	$("#takeBoomerang").addClass('hideMe');
	$("#takePhoto").removeClass('hideMe');
	$("#openLibrary").removeClass('hideMe');
})
var timer = null;
var action=""
var creditsOk=0;
//Photo
$("#takePhoto").click(function() {
	action="photo";
	$("#takePhoto").addClass('hideMe');
	$("#takeGIF").addClass('hideMe');
	$("#takeBoomerang").addClass('hideMe');
	$("#takePhoto").addClass('hideMe');								
	$("#openLibrary").addClass('hideMe');
	if(optB==1){
		 creditsOk=0;
		 $.ajax({
			type: "POST",
			url: "https://"+site+"/console/app3.php",
			data: { eventAction: "checkCredits",accountUID: accountUID },
			success: function(response)
			{
				var jsonData = JSON.parse(response);
				if (jsonData.success == "1"){
					 if (jsonData.creditsOk==1){
						 creditsOk=1;
					 }
					 else{
						 creditsOk=0;
					 }
				}
				else{
					 creditsOk=0;
				}
			},
			error: function() {
				 creditsOk=0;
			}
		});
	 }
	$('#frames').hide();
	
//	if (hasMedia==true && isFB==false) {
	if (hasMedia==true && isFBSam==false) {
	
		 if (timer !== null) {
		} else {
			var timeto = 3; 

			var countdown = $("#countdownText").html(timeto);
			$('#countdown').addClass('on')
			$('#countdown').css('z-index','10001')
			setTimeout(function(){
				   $('#countdown').removeClass('on');
				}, 800);
			timer = window.setInterval(function() {
				timeto--;
				$('#countdown').addClass('on')
				countdown.html(timeto);
				
				setTimeout(function(){
				   $('#countdown').removeClass('on');
				}, 800);
				if (timeto == 0) {
					window.clearInterval(timer);
					timer = null;

					$('.shutter').css('opacity',1);
					  $('audio')[0].play();
					  countdown.html("");
					  $('#countdown').css('z-index','101')
					  setTimeout(function() {
						$('.shutter').css('opacity',0);
						setTimeout(function() {
							$("#capture").hide();
							$("#review").show();
						  }, 500);
					  }, 250);


						var imgClone=$("#image-overlay").clone();
						imgClone.addClass('overlap');
					
						imgClone.appendTo(appendTarget);

					   createFinalPhoto(cameraVideo, cameraVideo.videoHeight, cameraVideo.videoWidth);
					   $("#buttons-approve").show();
					   
						
					 
				};
			}, 1000);
		};
	}
	else{
	
		imagePicker.click();
	}
});


//GIF Button
$("#takeGIF").click(function() {
	//gif.freeWorkers.forEach(w => w.terminate());
	gif.abort();
	$("#takeGIF").addClass('hideMe');
	$("#takeBoomerang").addClass('hideMe');
	$("#takePhoto").addClass('hideMe');
	$("#takePhoto-pre").addClass('hideMe');
	$("#openLibrary").addClass('hideMe');

	action="gif";
	$('#captureProgress').show();
	gifCounter=1;
	takeGIF();
})

var gifCounter=0;
var buffer = document.createElement('canvas');
	buffer.width = dW;
	buffer.height = dH;
var filterBuffer = document.createElement('canvas');
	filterBuffer.width = dW;
	filterBuffer.height = dH;
	
//GIF Action
function takeGIF() {
	$('#frames').hide();
	 if (timer !== null) {
    } else {
        var timeto = 3; 
        var countdown = $("#countdownText").html(timeto);
		$('#countdown').addClass('on')
        timer = window.setInterval(function() {
            timeto--;
            countdown.html(timeto);
            if (timeto == 0) {
                window.clearInterval(timer);
                timer = null;
				
				  $('audio')[0].play();
				  setTimeout(function() {
					  setTimeout(function(){$('#shutter').removeClass('on');},100);
				  }, 45*2+45);
                 addFrame(cameraVideo, cameraVideo.videoHeight, cameraVideo.videoWidth);
				 newValue=(gifCounter/4 * 100);
						var bar = $(".progress-bar");
						
						bar.attr("aria-valuenow", newValue);
						bar.css("width", newValue + "%"); 
				  if (gifCounter<4){
						gifCounter++;
						setTimeout(takeGIF(),500);
				  }
				  else{
						gif.render();
						$('#loading').show();
						$('#captureProgress').hide();
						$("#review").show();
						$("#capture").hide();
						$("#camera-image").hide();
						$("#image-background").attr('src',$("#image-overlay").attr('src'))
				  }
            };
        }, 1000);
    };
};


var bFrames = new Array();
//Boomerang
$("#takeBoomerang").click(function() {
	//gif.freeWorkers.forEach(w => w.terminate());
	gif.abort();
$("#takePhoto").addClass('hideMe');
$("#takePhoto-pre").addClass('hideMe');
	$("#takeGIF").addClass('hideMe');
	$("#takeBoomerang").addClass('hideMe');

	$("#openLibrary").addClass('hideMe');
	
	action="boomerang";
	$('#captureProgress').show();
	gifCounter=1;
	takeBoomerang();
	bFrames = [];
})

//Boomerang Action
function takeBoomerang() {
	$('#frames').hide();
	 if (timer !== null) {
    } else {
        var timeto = 3; 
        var countdown = $("#countdownText").html(timeto);
		$('#countdown').addClass('on')
        timer = window.setInterval(function() {
            timeto--;
            countdown.html(timeto);
            if (timeto == 0) {
				countdown.html("");
                window.clearInterval(timer);
                timer = null;
				timer = window.setInterval(function() {
					addFrame(cameraVideo, cameraVideo.videoHeight, cameraVideo.videoWidth);	
					newValue=(gifCounter/10 * 100);
					var bar = $(".progress-bar");
					
					bar.attr("aria-valuenow", newValue);
					bar.css("width", newValue + "%"); 
						if (gifCounter<10){

							gifCounter++;
						}
						else{
							
							window.clearInterval(timer);
							timer = null;
							
							for (i = 0; i < bFrames.length; i++) {
								console.log(i)
							  var cv = document.createElement("canvas");
							  cv.height=dH/3
							  cv.width=dW/3
								var ctx = cv.getContext("2d");
								ctx.putImageData(bFrames[i], 0, 0)
								gif.addFrame(cv, {delay: boomerangSpeed});	
								
							}
	
							for (i = bFrames.length-1; i >=0; i--) {
								console.log(i)
							  var cv = document.createElement("canvas");
							  cv.height=dH/3
							  cv.width=dW/3
								var ctx = cv.getContext("2d");
								ctx.putImageData(bFrames[i], 0, 0)
								gif.addFrame(cv, {delay: boomerangSpeed});	
								
							}
							gif.render();
							$('#loading').show();
							$('#captureProgress').hide();
							$("#camera-image").hide();
							$("#review").show();
							$("#capture").hide();
							$("#image-background").attr('src',$("#image-overlay").attr('src'))
						}	
				},250);
			};
        }, 1000);
    };
};

//Gif Processing
var gif = new GIF({
  workers: 4,
  quality: 2,
  width:parseInt(dW/3),
  height:parseInt(dH/3),
  debug:0,
  workerScript: '/js/gif.worker.js',
  dither : "FloydSteinberg-serpentine"
});
var base64Gif
gif.on('finished', function(blob) {
	$('#camera-image').show();
	//gif.freeWorkers.forEach(w => w.terminate());
	gif.abort();
	gif.frames=[];
	$("#loading").hide();	

	var bar = $(".progress-bar");
	newValue=0;
	bar.attr("aria-valuenow", newValue);
	bar.css("width", newValue + "%");   
	
	var reader = new FileReader();
	reader.onload = function(event){
		base64Gif= event.target.result;  
	};  
	reader.readAsDataURL(blob);
	cameraImage.src=URL.createObjectURL(blob);

	$("#camera-image").attr('height',dH/4);

});

gif.on ("progress", function(i) {
	newValue=(i * 100);
	var bar = $(".progress-bar");
	if(newValue<15){
		newValue=15;
	}
	bar.attr("aria-valuenow", newValue);
	bar.css("width", newValue + "%");   

	
});

//Add Frame
function addFrame(im, h, w) {
	buffer.width = dW/3;
	buffer.height = dH/3;

	var ctx = buffer.getContext("2d");

	var rh = buffer.height / h;
	var rw = buffer.width / w;

	if (rh > rw) {
		var nw = Math.round(w * rh);
		var nh = buffer.height;
		var x = (nw - buffer.width) / 2;
		var y = 0;

		ctx.drawImage(im, -x, y, nw, nh);
	} else {
		var nw = buffer.width;
		var nh = Math.round(h * rw);
		var x = 0;
		var y = (nh - buffer.height) / 2;

	   ctx.drawImage(im, x, -y, nw, nh);
	}

	 ctx.drawImage(overlay, 0, 0, dW/3, dH/3)
	if($('#status').val()!="1"){
		ctx.drawImage(trial, 0, 0, dW/3, dH/3)
	}
	
	 

	if(action=="gif"){
		gif.addFrame(ctx, {copy: true,delay:gifSpeed});
	}
	else{
		imageData = ctx.getImageData(0, 0, dW/3, dH/3);
		bFrames.push(imageData);
	}
}

//Options Click
$(".frame").on("click",function(){
	var iFrame = document.getElementById('textFrame');
	if (optUI==1 && userText!=""){
		//iFrame.contentWindow.postMessage({img : $(this).attr("data-img"), userText: userText});
		addText($(this).attr("data-img"), userText);
	}
	else{
		$("#image-overlay").attr("src",$(this).attr("data-img"));
	}
})

var bgSelected=0;
$(".background").on("click",function(){
	
	if(!$("#image-key").length && $(this).attr("data-img")!="blank"){
		$("#image-background").attr("src",$(this).attr("data-img"));
		removeBg($(this).attr("data-img"));
		bgSelected=1;
	}
	else{
		if($(this).attr("data-img")!="blank"){
			$("#image-background").attr("src",$(this).attr("data-img"));
			$("#image-key").show();
			$("#image-background").show();
			bgSelected=1;
			 
		}
		else{
			$("#image-key").hide();
			$("#image-background").hide();
			$('#camera-image-canvas').show();
			 bgSelected=0;
		}
	}
	
})
var stickerSelected=0;
$(".sticker").on("click",function(){
	Add($(this).attr("data-img"));
	stickerSelected=1;
	//canvas.isDrawingMode= 0; 
})

//Actions Click
$("#likePhoto").click(function() {
	 if (hasMedia==true && isFB==false) {
		 track.stop();
	 }
	 $('#review-wrapper').css('position','relative');
		$('#review-wrapper').css('overflow','hidden');
	if(optB==1 && action=="photo" && creditsOk==1){ 
		if(autoBG==0){
			$("#backgrounds").show();
		}
		else{
			$(".background").eq(1).click();
			if (numBGs>1){
				$("#backgrounds").show();
			}
		}
		$("#buttons-saveBg").show();
	}
	else if(optF==1 && action=="photo"){
		$('.canvas-container').css('pointer-events','all');
		$("#filters").show();
		$("#buttons-saveFilter").show();
		
	}
	else if(optS==1 && action=="photo"){
	$("#stickerDiv").css("pointer-events","all")
	$("#camera-image-canvas").css("pointer-events","none")
		dragElementStop(document.getElementById("camera-image-canvas"));
		
		$('.canvas-container').css('pointer-events','all');
		$("#stickers").show();
		$("#buttons-saveSticker").show();
		
		
	}	
	else if(action=="photo"){		
			
		createEditPhoto(1,"like")
			$("#buttons-done").show()	
	}
	else{
		$("#buttons-done").show();
	}
	$("#buttons-approve").hide();
});  

$("#saveBg").click(function() {
	
	$("#backgrounds").hide();
	$('.canvas-container').css('pointer-events','all');
	if(optF==1){
		$("#filters").show();
		$("#buttons-saveFilter").show();
	}
	else if(optS==1){
	$("#stickerDiv").css("pointer-events","all")
	$("#camera-image-canvas").css("pointer-events","none")
		dragElementStop(document.getElementById("camera-image-canvas"));
		if (optB==1){
			dragElementStop(document.getElementById("image-key"))
		}
		$("#stickers").show();
		$("#buttons-saveSticker").show();
	}
	else{
		if( bgSelected==1,"bg"){
			//finalPhotoOnlyBG();
			createEditPhoto(1,"bg")
		}else{
			createEditPhoto(1,"bg")
		}
		//if(optT!=""){
		//	$("#review").hide();
		//	$("#thanks").show()
		//}	
			$("#buttons-done").show()
		
	} 
	$("#buttons-saveBg").hide();
});

$("#saveFilter").click(function() {
	
	$("#filters").hide();
	if(optS==1){
		dragElementStop(document.getElementById("camera-image-canvas"));
		$("#camera-image-canvas").css("pointer-events","none")
		if (optB==1){
			dragElementStop(document.getElementById("image-key"))
		}
		$("#stickerDiv").css("pointer-events","all")
		$("#stickers").show();
		$("#buttons-saveSticker").show();
		if(filterSelected==0 && bgSelected==0){		
				createEditPhoto(1,"filter")
		}else if (filterSelected==1 && bgSelected==0){
			createEditPhoto(0,"filter")
		}
	}
	else {		
		if(optT!=""){
		//	$("#review").hide();
		//	$("#thanks").show()
		}	
		if(filterSelected==0){		
				createEditPhoto(1,"filter")
		}else{
			createEditPhoto(0,"filter")
		}
		$("#buttons-done").show()	
	}
	$("#buttons-saveFilter").hide();
});
	

$("#closeEmail").click(function() {
	$('#email').val("none");
	$('#sendEmail').click(); 
})
	
$("#retakePhoto").click(function() {
	optFlip=optFlipOrig;
	$("#appendTarget").html('');
	$('#camera-image').hide();
	$("#takePhoto-pre").removeClass('hideMe');
	if(optLib==1){
		$("#takePhoto").addClass('hideMe');
	}
	else{
		$("#takePhoto").removeClass('hideMe');
	}
	if(optLib != 1){
		$("#takeGIF").removeClass('hideMe');
		$("#takeBoomerang").removeClass('hideMe');
	}
	$('#frames').show();
    if (hasMedia) {
		$("#countdownText").html("");
        $("#review").hide();
        $("#capture").show();
    } else {
        imagePicker.click();
    }
});

 
$("#saveSticker").click(function() {
	debugger;
	$("#buttons-saveBg").hide();
	$("#buttons-saveFilter").hide();
	$("#buttons-saveSticker").hide();
	//$("#review").hide();
	if(optT!=""){
		$("#review").hide();
		$("#thanks").show()
	}else{
		$('#loading').show();
	}
	if(stickerSelected==0){	
		if(filterSelected==1){		
			createEditPhoto(0,"sticker")
		}
		else{
			if(bgSelected==0 && optB==1){
				createEditPhoto(0,"sticker")
			}
			else if(bgSelected==1){
				createEditPhoto(1,"sticker")
			}
			else if(optF==1) {
				createEditPhoto(0,"sticker")
			}
			else {
				createEditPhoto(1,"sticker")
			}
		}
			
	}else{
	
		if(filterSelected==1){		
			createEditPhoto(1,"sticker")
		}
		else{
			if(bgSelected==0 && optB==1){
				createEditPhoto(0,"sticker")
			}
			else if(bgSelected==1){
				createEditPhoto(1,"sticker")
			}
			else if(optF==1) {
				createEditPhoto(0,"sticker")
			}
			else {
				createEditPhoto(1,"sticker")
			}
		}
		
	}
   if(! $(this).attr("data-toggle")){
	$('#email').val("none")
		$('#sendEmail').click(); 
		 
	}
});

$("#done").click(function() {
	
	$("#buttons-saveBg").hide();
	$("#buttons-saveFilter").hide();
	$("#buttons-saveSticker").hide();
	$("#buttons-done").hide();
	$('#camera-image').hide();
	if(optT!=""){
		$("#review").hide();
		$("#thanks").show()
	}
	else{
		$('#loading').show();
	}
	if(! $(this).attr("data-toggle")){
		$('#email').val("none")
		$('#sendEmail').click(); 
		 
	}
});
var shifted=0;
function createEditPhoto(flip,editType) {
	
	//console.log(editType)
	if(optS==1 && stickerSelected==1){
		canvas.discardActiveObject();
		canvas.renderAll();
		
		var ctx = imageCanvas.getContext("2d");
	//	var im = cameraImage
		var im = ctx.getImageData(0, 0, imageCanvas.width, imageCanvas.height);
		var sourceImageData = canvas.toDataURL("image/png");
		if(filterSelected==1){
			//var im = cameraImage
			//ctx.drawImage(im, 0, 0, dW, dH);
			
			flip=0;
		}
		ctx.save();
		if(flip==1 && optFlip==1){
			
		//	ctx.translate(imageCanvas.width, 0);
		//   ctx.scale(-1, 1);
		}
		if(window["image-key"]&& filterSelected==0 && bgSelected==1){
		
			var o = document.querySelector('#image-overlay');
			var k = document.querySelector('#image-key');
			var b = document.querySelector('#image-background');
			
			ctx.drawImage(b, 0, 0, dW, dH);
			var scale = dH/parseInt($('#splashDiv').css('height'))
			if (dH==1800){
				ctx.drawImage(k,parseInt(k.style.left)*scale, parseInt(k.style.top)*scale, dW, dH); 
			}
			else{
				ctx.drawImage(k,parseInt(k.style.left)*scale, parseInt(k.style.top)*scale, dW, dH); 
			}
			flip=0;
		}
		
		else if(shifted!=1){
			shifted=1;
			var scale = dH/parseInt($('#splashDiv').css('height'))
			if (dH==1800){
				ctx.drawImage(imageCanvas,parseInt(imageCanvas.style.left)*scale, parseInt(imageCanvas.style.top)*scale, dW, dH); 
			}
			else{
				ctx.drawImage(imageCanvas,parseInt(imageCanvas.style.left)*scale, parseInt(imageCanvas.style.top)*scale, dW, dH); 
			}
		}
		ctx.drawImage(overlay, 0, 0, dW, dH);
		ctx.drawImage(canvas.lowerCanvasEl, 0, 0, dW, dH);
		// if($('#status').val()!="1"){
				// ctx.drawImage(trial, 0, 0, dW, dH)
			// }
		canvas.clear();
		cameraImage.src = imageCanvas.toDataURL("image/jpeg");
	}
	else{

		var ctx = imageCanvas.getContext("2d");
		
		ctx.save();
		if(flip==1 && editType!='done'  && optFlip==1){
			
		//	ctx.translate(imageCanvas.width, 0);
		//   ctx.scale(-1, 1);
		} 
		if(window["image-key"]&& filterSelected==0 && bgSelected==1){
		
			var o = document.querySelector('#image-overlay');
			var k = document.querySelector('#image-key');
			var b = document.querySelector('#image-background');
			
			ctx.drawImage(b, 0, 0, dW, dH);
			var scale = dH/parseInt($('#splashDiv').css('height'))
			if (dH==1800){
				ctx.drawImage(k,parseInt(k.style.left)*scale, parseInt(k.style.top)*scale, dW, dH); 
			}
			else{
				ctx.drawImage(k,parseInt(k.style.left)*scale, parseInt(k.style.top)*scale, dW, dH); 
			}

		}
		else if(shifted!=1){
			shifted=1;
			var scale = dH/parseInt($('#splashDiv').css('height'))
			if (dH==1800){
				ctx.drawImage(imageCanvas,parseInt(imageCanvas.style.left)*scale, parseInt(imageCanvas.style.top)*scale, dW, dH); 
			}
			else{
				ctx.drawImage(imageCanvas,parseInt(imageCanvas.style.left)*scale, parseInt(imageCanvas.style.top)*scale, dW, dH); 
			}
		}
		ctx.drawImage(overlay, 0, 0, dW, dH)
		/*var ocanvas = document.createElement('canvas');
		ocanvas.width = dW;
		ocanvas.height = dH;
		octx = ocanvas.getContext("2d");
		octx.drawImage(overlay,0, 0, dW, dH);
		octx.beginPath();
        octx.fillStyle = "rgba(0, 0, 0, 1)";
        octx.globalCompositeOperation = 'destination-out';
        octx.arc(0, 0, 600, 0, Math.PI*2);
        octx.fill();
        octx.globalCompositeOperation = 'source-over';
		
		ctx.drawImage(ocanvas,0, 0, dW, dH)
		*/ 
		// if($('#status').val()!="1"){
				// ctx.drawImage(trial, 0, 0, dW, dH)
			// }
		cameraImage.src = imageCanvas.toDataURL("image/jpeg");
	}
	$(".overlap").hide();
	$('#camera-image').show();
}
var filterSelected=0;
$(".filter").on("click",function(){
	
	var whichFilter=$(this).attr("data-filter");
	if (whichFilter != "blank"){
		var filters=["aeon","blues","bluescale","cool_twilight","coral","cosmic","darkify","eclectic","eon","evening","extreme_offset_red","frontward","greyscale","haze","lix","mellow","neue","purplescale","radio","retroviolet","rosetint","ryo","serenity","solange_dark","solange_grey","twenties","vintage","warmth","wood","zapt"]
		if(window["image-key"] && bgSelected==1){
			var ctx = imageCanvas.getContext("2d");
			var o = document.querySelector('#image-overlay');
			var k = document.querySelector('#image-key');
			var b = document.querySelector('#image-background');
			if(filterSelected==0 && optFlip==1){
			//	ctx.translate(imageCanvas.width, 0);
			//	ctx.scale(-1, 1);
			}
			ctx.drawImage(b, 0, 0, dW, dH);
			var scale = dH/parseInt($('#splashDiv').css('height'))
			if (dH==1800){
				ctx.drawImage(k,parseInt(k.style.left)*scale, parseInt(k.style.top)*scale, dW, dH); 
			}
			else{
				ctx.drawImage(k,parseInt(k.style.left)*scale, parseInt(k.style.top)*scale, dW, dH); 
			}
			
			var imgData = ctx.getImageData(0, 0, imageCanvas.width, imageCanvas.height);
			var newImgData = pixelsJS.filterImgData(imgData, filters[whichFilter]);
			ctx.putImageData(newImgData, 0, 0);
			
		//	
			
			
		}
		else{
			var ctx = imageCanvas.getContext("2d");
			var ctx2 = filterBuffer.getContext("2d");
			var imgData = ctx2.getImageData(0, 0, imageCanvas.width, imageCanvas.height);
			var newImgData = pixelsJS.filterImgData(imgData, filters[whichFilter]);
			ctx.putImageData(newImgData, 0, 0);
			//if (dH==1800){
			//	ctx.putImageData(newImgData,parseInt(imageCanvas.style.left)*3, parseInt(imageCanvas.style.top)*3); 
		//}
			//else{
			//	ctx.putImageData(newImgData,parseInt(imageCanvas.style.left)*2.667, parseInt(imageCanvas.style.top)*2.667); 
	//}
			ctx.save();
			
			if(filterSelected==0  && optFlip==1){
			//	ctx.translate(imageCanvas.width, 0);
			//	ctx.scale(-1, 1);
			}
		}
			
	}
	
	else{
		if(window["image-key"]){
			var ctx = imageCanvas.getContext("2d");
			var o = document.querySelector('#image-overlay');
			var k = document.querySelector('#image-key');
			var b = document.querySelector('#image-background');
			if(filterSelected==0  && optFlip==1){
			//	ctx.translate(imageCanvas.width, 0);
			//	ctx.scale(-1, 1);
			}
			ctx.drawImage(b, 0, 0, dW, dH);
			var scale = dH/parseInt($('#splashDiv').css('height'))
			if (dH==1800){
				ctx.drawImage(k,parseInt(k.style.left)*scale, parseInt(k.style.top)*scale, dW, dH); 
			}
			else{
				ctx.drawImage(k,parseInt(k.style.left)*scale, parseInt(k.style.top)*scale, dW, dH); 
			}
			
			// var imgData = ctx.getImageData(0, 0, imageCanvas.width, imageCanvas.height);
			// var newImgData = pixelsJS.filterImgData(imgData, filters[whichFilter]);
			// ctx.putImageData(newImgData, 0, 0);
			
		//	
			
			
		}else{
			var ctx = imageCanvas.getContext("2d");
			var ctx2 = filterBuffer.getContext("2d");
			var imgData = ctx2.getImageData(0, 0, imageCanvas.width, imageCanvas.height);
			var newImgData = imgData;
			ctx.putImageData(newImgData, 0, 0);
			//if (dH==1800){
			//	ctx.putImageData(newImgData,parseInt(imageCanvas.style.left)*3, parseInt(imageCanvas.style.top)*3); 
		//	}
			//else{
			//	ctx.putImageData(newImgData,parseInt(imageCanvas.style.left)*2.667, parseInt(imageCanvas.style.top)*2.667); 
		//}
			ctx.save();
			
			if(filterSelected==0 && optFlip==1){
			//	ctx.translate(imageCanvas.width, 0);
			//	ctx.scale(-1, 1);
			}
			// if($('#status').val()!="1"){
				// ctx.drawImage(trial, 0, 0, dW, dH)
			// }
			$('#camera-image-canvas').show();
			$('#camera-image').hide();
			$('#image-key').hide();
			$('#image-background').hide();
		}
	}
	
	// if($('#status').val()!="1"){
		// ctx.drawImage(trial, 0, 0, dW, dH)
	// }
	$('#camera-image-canvas').show();
	$('#camera-image').hide();
	$('#image-key').hide();
	$('#image-background').hide();
	filterSelected=1;
})

function finalPhotoOnlyBG(){
	var ctx = imageCanvas.getContext("2d");
	var o = document.querySelector('#image-overlay');
	var k = document.querySelector('#image-key');
	var b = document.querySelector('#image-background');
	if(filterSelected==0 && optFlip==1){
	//	ctx.translate(imageCanvas.width, 0);
	//	ctx.scale(-1, 1);
	}
	ctx.drawImage(b, 0, 0, dW, dH);
	ctx.drawImage(k, 0, 0, dW, dH);
	
	var imgData = ctx.getImageData(0, 0, imageCanvas.width, imageCanvas.height);
	
	ctx.putImageData(imgData, 0, 0);
		ctx.drawImage(overlay, 0, 0, dW, dH)	
	$('#camera-image-canvas').show();
	$('#camera-image').hide();
	$('#image-key').hide();
	$('#image-background').hide();

	
	// if($('#status').val()!="1"){
		// ctx.drawImage(trial, 0, 0, dW, dH)
	// }
}
function removeBg(bg){

	$('#image-background').hide();
	
	$('#loading').show();
	var imageData=imageCanvas.toDataURL("image/jpeg");
	
	var formData  = new FormData();
	formData.append('eventURL', eventURL);
	formData.append('accountUID', accountUID);
	formData.append('file', imageData);
	formData.append('eventAction', "removeBg");
	formData.append('status', $('#status').val());
	
	var xhr = new XMLHttpRequest();
	xhr.onload = removeBgSuccess;
	xhr.open("post", "https://"+site+"/console/appp.php");
	xhr.send(formData); 

	
}

function removeBgSuccess(){
	
	$('#image-background').show();
	$('#camera-image-canvas').hide();
	$('#loading').hide();
	jsonData = JSON.parse(this.responseText);
	if(jsonData["success"]==1){
		 var img = document.createElement('img'); 
         img.src =  'data:image/png;base64,'+ jsonData.img; 
         img.id =  'image-key'; 
		 img.setAttribute('style', 'position:absolute;top:0;left:0;height:'+$('#camera-image').attr('height')+'px;');
         document.getElementById('appendTarget').appendChild(img); 
		 dragElement(document.getElementById("image-key")); 
		 $("#image-key").css('cursor','move')

		if(autoBG==1){
			if (numBGs=1){
				$("#saveBg").click();
			}
		}
		}

	else{
		alert("Sorry, an error has occured")
	}
	
}
//Send Email
$('#sendEmail').on('click', function(e) {
	if ($('#email').val() == "") {
	  e.preventDefault();
	  e.stopPropagation();
	}
	else{
		if(optG==1){
			Swal.fire({
			  title: "",
			  text: optGT,
			  icon: 'question',
			  showCancelButton: true,
			  confirmButtonText: '<i class="fa fa-thumbs-up mr-2" aria-hidden="true"></i>',
			  cancelButtonText: '<i class="fa fa-thumbs-down mr-2" aria-hidden="true"></i>',
			}).then((result) =>{
				if (result.isConfirmed) {
			  
				$('#includeInGallery').val("1");
			  } else {
			    
				$('#includeInGallery').val("0");
			  }
			  
			  doSend()
			});
		}
		else{
			
			doSend();
		}
	}	   
	
});

function doSend(){
	var ctx = imageCanvas.getContext("2d");
		if($('#status').val()!="1"){
			ctx.drawImage(trial, 0, 0, dW, dH)
		}
	$('#modalEmailForm').modal('hide');

	if(action=="photo"){
		var imageData=imageCanvas.toDataURL("image/jpeg");			
	}
	else{
		var imageData=base64Gif;	
	}


	var formData  = new FormData(); 
	formData.append('eventURL', eventURL);
	formData.append('accountUID', accountUID);
	formData.append('file',imageData );
	formData.append('eventAction', "media");
	formData.append('email', $('#email').val());
	formData.append('mediaType', action);
    formData.append('status', $('#status').val());
	formData.append('eventId', $('#eventId').val());

	formData.append('includeInGallery', $('#includeInGallery').val());
	// if($('#includeInGallery').is(':checkbox')){
		// if($("#includeInGallery" ).prop( "checked")==true) {
			// formData.append('includeInGallery', "1");
		// }
		// else{
			// formData.append('includeInGallery', "0");
		// }
	// }
	// else{
		// formData.append('includeInGallery', "1");
	// }
	
var token = $('input[name=_token]');
$.ajax({
	url: window.location.origin+"/photobooth/insert",
	method: 'post',
	dataType: 'json',
	contentType: false,
	processData: false,
	
	headers: {
		'X-CSRF-TOKEN': token.val()
	},
	
	data: formData,
	success: function(data){
		var path = data.data;
			
				window.location.replace(window.location.origin+"/photo/"+path);
	},
	error: function (data) {
	
		if (data.status === 422) {
	
			 name_error.html(data.responseJSON.name);
			 link_error.html(data.responseJSON.link);
			 image_error.html(data.responseJSON.image);
	
		} else {
	
		
		
				//$("#loading2").hide();
			
		}
	}
});
	

	// var xhr = new XMLHttpRequest();
	// xhr.onload = uploadSuccess;
	// xhr.open("post", "https://localhost/stemx/photobooth/insert");
	// xhr.send(formData); 
}
function uploadSuccess(){
	jsonData = JSON.parse(this.responseText);
	if(jsonData["success"]==1){
			window.location.replace("https://"+vsite+"/photo/"+jsonData["uid"]);
			//$("#loading2").hide();
		} 

	else{
		alert("Sorry, an error has occured")
	}
	
}
function createFinalPhoto(im, h, w) {
    imageCanvas.width = dW;
    imageCanvas.height = dH;

    var ctx = imageCanvas.getContext("2d");
    var ctx2 = filterBuffer.getContext("2d");

    var rh = imageCanvas.height / h;
    var rw = imageCanvas.width / w;

    if (rh > rw) {
        var nw = Math.round(w * rh);
        var nh = imageCanvas.height;
        var x = -(nw - imageCanvas.width) / 2;
        var y = 0;

       // ctx.drawImage(im, -x, y, nw, nh);
       // ctx2.drawImage(im, -x, y, nw, nh);
    } else {
        var nw = imageCanvas.width;
        var nh = Math.round(h * rw);
        var x = 0;
        var y = -(nh - imageCanvas.height) / 2;

      // ctx.drawImage(im, x, -y, nw, nh);
       //ctx2.drawImage(im, x, -y, nw, nh);
    }
	
    if(optFlip==1){

        
		ctx.save();
		ctx.translate(imageCanvas.width, 0);
		ctx.scale(-1, 1);
		ctx2.save();
		ctx2.translate(imageCanvas.width, 0);
		ctx2.scale(-1, 1);
		
		ctx.drawImage(im, x, y, nw, nh);
        ctx2.drawImage(im, x, y, nw, nh);
		
		
		ctx.restore();
		ctx2.restore();
	}
	else{
		ctx.drawImage(im, x, y, nw, nh);
        ctx2.drawImage(im, x, y, nw, nh);
	   
	  
		
	}
	// if($('#status').val()!="1"){
			// ctx.drawImage(trial, 0, 0, dW, dH)
		// }
  $('#camera-image').hide();
	
	
	if (optB!=1){
		$("#appendTarget").css('pointer-events','none')
		dragElement(document.getElementById("camera-image-canvas")); 
		$("#camera-image-canvas").css('cursor','move')
	}
}


 


function styleButtons(val,color) { 
	$(".btn-action").removeClass (function (index, className) {
		return (className.match (/(^|\s)button-cust\S+/g) || []).join(' ');
	});
	
	
	
	$(".btn-action").addClass(val);
	$(".btn-action").removeClass('btn-secondary');
	$(".btn-action").removeClass('btn-lg');
	
	
	if (val=='button-cust-nice') {
		
		var tColor=color;
		tColor="1px solid "+tColor;
		$(".btn-action").css('--border',tColor)	
	}
	
	if (val=='button-cust-3d') {
		
		if ($('#button-cust-3d').contents().find('#buttons-bottom').find('button').css('border-bottom') != '') {
			var tColor=rgb2hex(color);
			tColor=LightenDarkenColor(tColor,-10)
			$(".btn-action").css('border-color',tColor)
		} 
	}
	
	if (val=='button-cust-flat') {
		
		var tColor=rgb2hex(color);
		tColor=LightenDarkenColor(tColor,10)
		tColor="0px 4px 0px "+tColor+"!important";
		$(".btn-action").css('box-shadow',tColor)
	}
	if (val=='button-cust-press') {		
		var tColor=rgb2hex(color);
		tBorder=LightenDarkenColor(tColor,-90)
		$(".btn-action").css('border-color',tBorder)
		
		tBG=LightenDarkenColor(tColor,-50)
		$(".btn-action").css('--background',tBG);
						
		tShadow=LightenDarkenColor(tColor,-90)
		tShadow="0 0 0 1px "+tBorder;
		$(".btn-action").css('--shadow',tShadow)
	}
	
	if (val=='button-cust-outline') {
		
		var tColor=color
		tBorder=tColor;
		$(".btn-action").css('border-color',tBorder)
		
		tShadow="4px 4px 0px 0px "+tColor;
		$(".btn-action").css('--shadow',tShadow)
	}
	if (val=='button-cust-outline2') {
		
		var tColor=color
		tBorder=tColor;
		$(".btn-action").css('border-color',tBorder)
		
		
	}
	if (val=='button-cust-3d2') {
		
		var tColor=color;
		tBorder=LightenDarkenColor(tColor,-90)
		tShadow=LightenDarkenColor(tColor,-50)
		
		tShadow="0 0 0 1px "+tBorder+" inset, 0 0 0 2px rgba(255,255,255,0.15) inset, 0 8px 0 0 "+tShadow+", 0 8px 0 1px rgba(0,0,0,0.4), 0 8px 8px 1px rgba(0,0,0,0.5)";
		$(":root").css("--shadow", tShadow);
		$(".btn-action").css('--shadow',tShadow)
	}
	if (val=='button-cust-tear') {
		
		var tColor=color;
		if (tColor.length>7){	
			 tColor=rgb2hex(tColor);
		}
		tColor2=LightenDarkenColor(tColor,-90)

		tBackground="linear-gradient(45deg, "+tColor2+" 40%, "+tColor+" 100%)";
		$(".btn-action").css('--background',tBackground)
	}
	if (val=='button-cust-real') {
		
		var tColor=rgb2hex(color);
		tColor2=LightenDarkenColor(tColor,-90)

		tBackground="linear-gradient(45deg, "+tColor2+" 40%, "+tColor+" 100%)";
		$(".btn-action").attr('data-content',$(".btn-action").attr("data-content"))
	}
	if (val=='button-cust-hand-thick') {
		
		var tColor=color;
		tBorder=tColor
		$(".btn-action").css('border-color',tBorder)
	}
	if (val=='button-cust-hand-thin') {
		
		var tColor=color;
		tBorder=tColor
		$(".btn-action").css('border-color',tBorder)
	}
	if (val=='button-cust-hand-dotted') {
		
		var tColor=color;
		tBorder=tColor
		$(".btn-action").css('border-color',tBorder)
	}
	if (val=='button-cust-hand-dashed') {
		
		var tColor=color;
		tBorder=tColor
		$(".btn-action").css('border-color',tBorder)
	}
	
	
};

function LightenDarkenColor(col, amt) {
  
    var usePound = false;
  
    if (col[0] == "#") {
        col = col.slice(1);
        usePound = true;
    }
 
    var num = parseInt(col,16);
 
    var r = (num >> 16) + amt;
 
    if (r > 255) r = 255;
    else if  (r < 0) r = 0;
 
    var b = ((num >> 8) & 0x00FF) + amt;
 
    if (b > 255) b = 255;
    else if  (b < 0) b = 0;
 
    var g = (num & 0x0000FF) + amt;
 
    if (g > 255) g = 255;
    else if (g < 0) g = 0;
 
    return (usePound?"#":"") + (g | (b << 8) | (r << 16)).toString(16);
  
}

function rgb2hex(rgb) {
    if (/^#[0-9A-F]{6}$/i.test(rgb)) return rgb;

    rgb = rgb.match(/^rgb\((\d+),\s*(\d+),\s*(\d+)\)$/);
    function hex(x) {
        return ("0" + parseInt(x).toString(16)).slice(-2);
    }
    return "#" + hex(rgb[1]) + hex(rgb[2]) + hex(rgb[3]);
}



var myParent="";
var state="";
function addText(img,txt){
	var iFrame = document.getElementById('textFrame');
	iFrame.contentWindow.postMessage({userText,img}); 
	/*filename = img.replace(/^.*[\\\/]/, '')
	$.ajax({
		type: "POST",
		url: '/console/app.php',
		data: {  eventAction: 'getUserText',filename: filename},
		success: function(response){
			var jsonData = JSON.parse(response);	
			state=JSON.stringify(jsonData.state);
			state= state.replace("<%Placeholder%>", userText);
			pixie.openEditorWithImage(img,true); 
			pixie.loadState(state); 
		} 
	})*/
}
		

	
	
	
var pixie
if(optUI==1){
	/*
	pixie = new Pixie({
		crossOrigin: true,
		baseUrl: 'https://'+site+'/console/includes/Editor',
		ui: {
			visible: false, 
			mode: 'inline',
			compact: true,
			height: '0px',
			defaultTheme: 'light',
			 toolbar: {
				  replaceDefaultLeftItems: true,
				  replaceDefaultCenterItems: true,
				  replaceDefaultRightItems: true,
				  leftItems: [
					{
					  type: 'button',
					  icon: 'file-download',
					  text: 'Save',
					  action: 'exportImage',
					  showInCompactMode: true
					}
				  ],
				  centerItems: [],
				  rightItems: [
					  
					{
						type: 'button',
						icon: 'close',
						action: 'closeEditor',
						marginLeft: '25px',
						showInCompactMode: true
					}
				  ]
				},

			nav: {
				position: 'bottom',
				replaceDefault: true,
				
				items: [ 	
					
				]	
					
			}
		},
		tools: {
			stickers: {
			replaceDefault: true,
			items: [ 
				{
					name: 'placeholders',
					items: 1, 
					type: 'png',
					thumbnailUrl: 'images/ui/arrows.svg'
				}
			]
		}
		}, 
		onMainImageLoaded: function(file){
			
			setTimeout(function(){$(".mat-button").click();},500);
			
		},
		onSave: function(data, name) {
			$("#image-overlay").attr("src",data);
			$("#image-overlay").show();
			$("#splash").hide();
			 $("#capture").show();
			 startBooth();
			 pixie.resetEditor()
			 pixie.close();
			 //reload_js("https://cdnjs.cloudflare.com/ajax/libs/fabric.js/4.4.0/fabric.min.js");
		}
		
	});
	*/
}



var canvas = this.__canvas = new fabric.Canvas('image-stickers');
// create a rect object
  var deleteIcon = "data:image/svg+xml,%3C%3Fxml version='1.0' encoding='utf-8'%3F%3E%3C!DOCTYPE svg PUBLIC '-//W3C//DTD SVG 1.1//EN' 'http://www.w3.org/Graphics/SVG/1.1/DTD/svg11.dtd'%3E%3Csvg version='1.1' id='Ebene_1' xmlns='http://www.w3.org/2000/svg' xmlns:xlink='http://www.w3.org/1999/xlink' x='0px' y='0px' width='595.275px' height='595.275px' viewBox='200 215 230 470' xml:space='preserve'%3E%3Ccircle style='fill:%23F44336;' cx='299.76' cy='439.067' r='218.516'/%3E%3Cg%3E%3Crect x='267.162' y='307.978' transform='matrix(0.7071 -0.7071 0.7071 0.7071 -222.6202 340.6915)' style='fill:white;' width='65.545' height='262.18'/%3E%3Crect x='266.988' y='308.153' transform='matrix(0.7071 0.7071 -0.7071 0.7071 398.3889 -83.3116)' style='fill:white;' width='65.544' height='262.179'/%3E%3C/g%3E%3C/svg%3E";

  var img = document.createElement('img');
  img.src = deleteIcon;

  fabric.Object.prototype.transparentCorners = false;
  fabric.Object.prototype.cornerColor = 'blue';
  fabric.Object.prototype.cornerStyle = 'circle';

 //canvas.isDrawingMode= 1;
 //   canvas.freeDrawingBrush.color = "purple";
  //  canvas.freeDrawingBrush.width = 10;
   // canvas.renderAll();
function Add(file) {
	fabric.Image.fromURL(file, function(rect) {
		tScale=(canvas.width/5)/rect.width  
		// console.log(tScale)
		rect.set({
			left: canvas.width/2-(rect.width*tScale)/2,
			top: canvas.height/2-(rect.height*tScale)/2,
			scaleX: tScale,
			scaleY: tScale,

			objectCaching: false
		});

		rect.perPixelTargetFind = true;
		rect.hasControls = rect.hasBorders = true;

		canvas.add(rect) ;
		canvas.setActiveObject(rect);
	},{crossOrigin: 'anonymous'});
   
 } 

fabric.Object.prototype.controls.deleteControl = new fabric.Control({
    x: 0.5,
    y: -0.5,
    offsetY: -15,
    offsetX: 15,
    cursorStyle: 'pointer',
    mouseUpHandler: deleteObject,
    render: renderIcon,
    cornerSize: 24
});

  //Add();

function deleteObject(eventData, target) {
	var target=target.target
	var canvas = target.canvas;
	canvas.remove(target);
	canvas.requestRenderAll();
}

function renderIcon(ctx, left, top, styleOverride, fabricObject) {
    var size = this.cornerSize;
    ctx.save();
    ctx.translate(left, top);
    ctx.rotate(fabric.util.degreesToRadians(fabricObject.angle));
    ctx.drawImage(img, -size/2, -size/2, size, size);
    ctx.restore();
}
