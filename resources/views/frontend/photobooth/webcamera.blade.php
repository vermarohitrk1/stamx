
<!DOCTYPE html>
<html>
<head>
	
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
<title>Photobooth</title>
    
    <!-- Styles -->
	<link rel="stylesheet" href="{{ asset('assets/css/bootstrap.min.css') }}">	<link href="https://use.fontawesome.com/releases/v5.4.1/css/all.css" rel="stylesheet" type="text/css">
	<link href="https://cdn.jsdelivr.net/npm/sweetalert2@9.15.2/dist/sweetalert2.min.css" rel="stylesheet" type="text/css">
	<link rel="stylesheet" href="{{ asset('css/booth.css') }}">
	<link rel="stylesheet" href="{{ asset('assets/css/owl.carousel.min.css') }}">
	<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@9.15.2/dist/sweetalert2.min.css">
	<link rel="stylesheet" href="{{ asset('assets/css/owl.theme.default.min.css') }}">
	<link href="https://pagecdn.io/lib/easyfonts/fonts.css" rel="stylesheet" type="text/css" />
	<!-- Favicon  -->
	@php 
	$b_img = "storage/photobooth/".$Photoboothimg->event_image;
	$startImage = "storage/photobooth/".$Photoboothimg->startImage;

	@endphp
	<style>
	  @import url('https://fonts.googleapis.com/css2?family=Oswald&display=swap');
	</style>
	<style>
	
	@media only screen and (max-width: 767px){

#splashDiv img {
    width: 100% !important;
}
.main.title.d-flex {
    width: 100% !important;
    margin-top: 60px;
}
#frames {
    width: 100% !important;
}
}
body{
		max-width: 630px;
		max-height: 100vh;
		margin: auto;
		min-height:600px;
		/* //overflow-x: hidden; */
		/* //background: #212529; */
	 background: url("{{ asset($b_img) }}")  rgba(0, 0, 0, 0); 
		background-blend-mode: multiply;
		background-repeat: no-repeat;
			background-size: cover;
			 -webkit-background-size: cover;
			-moz-background-size: cover;
			-o-background-size: cover;
							 																		}
	
	.btn-action {
		color: #000000;
		background-color: #ffffff;
			}
	.btn-action:hover {
			color: #000000;
		    background-color: #ffffff;
			}
		button span i{display:none!important;}
		
				</style>
		<script>
	
		dW=1600;
	dH=1600;
			eventURL="july4th";
	accountUID="L9nrpV9Z";
	site="stemx.com";	
	vsite="stemx.com";	
	
				
		var optBoom=1;
		var optGif=1;
		var optLib=1;
		var optF=0;
		var optB=0;
		var optS=1;
		var optM=1;
		var optT="https://media0.giphy.com/media/d62XTWi7yORkEr6h9c/giphy.gif?cid=0552ceb7dwnbsi6290abfk0cyj7b5kwnp1ndmjh1hullc04m&rid=giphy.gif&ct=s";
		var optG=1;
		var optGT="Can we add your photo to our online gallery?";
		var optD=0;
		var optDT="";
		var optUI=0;
		var optUIT="Enter your name";;
		var numBGs=0;
		var autoBG=0;  
 
	
		 
								var gifSpeed = 500;
var boomerangSpeed = 200;
		
	
		
	</script>
	
											 
</head>
<body>



    <div class="container pt-1 mt-0 mx-auto" >
			<!--Splash-->
		 
					
					<div id="splash">
			<div class="flex justify-center">
				
								 
				<div id="splashDiv" class="main text-center" style="display: flex;align-items: center;justify-content: center;height:600px;">
					<!--<img src="https://media0.giphy.com/media/Zdy9eepi357snkrAfJ/giphy.gif?cid=0552ceb7v216g3t8d88b1l612q8hpeczaosiaqmqhuefagto&rid=giphy.gif&ct=s" height="600" style="height:600px;" id="splashImg" class="img-fluid startBooth">-->
											<img src="{{ asset($startImage) }}"  id="splashImg" class="startBooth" style="max-height:600px;max-width:600px;">
									</div>
				 
									
					<div class="main title d-flex " style="width:600px;z-index:1001;pointer-events:none;">
						<span id="splashMessage" class="align-bottom splashMessage startBooth" style="width:100%;user-select: none;"><h5 class="cartoon2" style="text-align: center;"><span style="color: rgb(255, 255, 255);">Touch to Start</span></h5></span>
					</div>
																	 
				 
				<div style="text-align:center;font-size:12px;margin-top:20px;">
		
				</div>
			
		
			</div>
        </div>
		<!--End Splash-->
		
		<!--Capture-->
        <div id="capture" style="display:none;">
            <div class="flex justify-center">
				<div class="main text-center" style="position:relative;overflow:hidden;">
					<div id="camera-wrapper" style="height:600px;">
						<audio src="{{ asset('storage/photobooth/shutter.mp3') }}"></audio>
						
						<div class="d-flex justify-content-center" id="countdown"><div id="countdownText"></div></div>
						<canvas id="camera-canvas" data="" width="600" height="600" style="height:600px;"></canvas>
						<video id="camera-video" autoplay="" playsinline="" style="height:600px;"></video>
						<div class="shutter"></div>
						@foreach($Photobooth as $key => $photo)
						@if($key == 0)
									 @php $img = "storage/photobooth/".$photo->image; @endphp

																								<img id="image-overlay" class="image-overlay" crossorigin="anonymous" src="{{ asset($img) }}" style="height:600px;pointer-events:none;">
                                          
																						
																							@endif
											@endforeach
												<img id="image-overlay" class="image-overlay" crossorigin="anonymous" src="{{ asset('storage/photobooth/frames_1.png') }}" style="height:600px;pointer-events:none;">
																		<img id="image-trial" crossorigin="anonymous" src="" style="height:600px;">
																		
						
						
							
					</div>

					<!--Frames-->
										<div id="frames" style="position:relative;top:5px;z-index:2000; width:600px;">
						
													<script>var numFrames=5; </script>
							<div class="message col-sm-6">
								Select a Frame							<!--	<div id="min-frames" style="position:absolute;top:0px;right:5px;">-</div>-->
							</div>
							<div class="select col-sm-3">
								<div class="owl-carousel">
									<!-- <div class="item">
										// <img class="frame" src="/console/images/blank-options-square.png"  data-img="blank" >
									 </div>-->
									 @foreach($Photobooth as $key => $photo)
									 @php $img = "storage/photobooth/".$photo->image; @endphp

																				<div class="item" style="width:65px;">
																								<img class="frame" src="{{ asset($img) }}" crossorigin="anonymous" data-img="{{ asset($img)  }}" >
											</div>
											@endforeach
												
													
																	</div>
									
							</div>
						
												</div>
					<!--End Frames-->
				</div>
				
					
				<input id="image-picker" type="file" accept="image/*"  style="display:none;">

				<div class="progress" style="display:none;" id="captureProgress">
					<div class="progress-bar" role="progressbar" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100" style="width:0%"></div>
				</div>
				
				<div class="buttons mt-0 pt-2 btn-toolbar justify-content-center pt-2 mb-3 pt-2 pb-3" style=";z-index:999999!important;width: 99vw;position: absolute;left: calc(-49.5vw + 49.5%)!important;"> 
											 
						<button id="takePhoto-pre" class="btn btn-secondary btn-lg  d-md-table btn-action mr-2 pl-2 pr-2" data-content="Photo">
							<span><i class="fas fa-camera mr-2" aria-hidden="true"></i>Photo</span>
						</button>
													<button id="takePhoto" class="btn btn-secondary btn-lg  d-md-table btn-action mr-2 pl-2 pr-2 hideMe" data-content="Camera">
									<span><i class="fas fa-camera mr-2" aria-hidden="true"></i>Camera</span>
								</button>
							<button  id="openLibrary" class="btn btn-secondary btn-lg  d-md-table  btn-action mr-2 pl-2 pr-2 hideMe" data-content="Select">
								<span><i class="fa fa-th mr-2" aria-hidden="true"></i>Select</span>
							</button>
																						<button  id="takeBoomerang" class="btn btn-secondary btn-lg  d-md-table  btn-action mr-2 pl-2 pr-2" data-content="Boomerang">
							<span><i class="fas fa-infinity mr-2" aria-hidden="true"></i>Boomerang</span>
							</button>
										
											<button  id="takeGIF" class="btn btn-secondary  btn-lg   d-md-table btn-action pl-2 pr-2" data-content="GIF">
							<span><i class="fas fa-images mr-2" aria-hidden="true"></i>GIF</span>
						</button>
										
						
					
				</div>
				
				<span class="flip" ><img src="{{ asset('storage/photobooth/flip.png') }}" crossorigin="anonymous" width=64 height=64></span>
				
			</div>   
        </div>
		<!--End Capture-->

		<!--Review-->
        <div id="review" style="display:none;">
			<div class="flex justify-center">
				<div class="text-center" style="position:relative;overflow:hidden;">
					<div id="review-wrapper" style="height:600px;">
						<canvas id="camera-image-canvas" data="" width="600" height="600" style="height:600px;width:600px;"></canvas>
						
						<img id="image-background" class="image-background" crossorigin="anonymous" src="" style="height:600px;position:absolute;top:0;left:0;pointer-events:none;">
						<div id="appendTarget" style="position:relative;overflow:hidden;height:600px;"></div>
						<img src="{{ asset('storage/photobooth/loading.svg') }}" alt="" id="loading" crossorigin="anonymous" style="display:none;z-index:20002;position:absolute; top:50%; left:50%;margin: -100px 0 0 -100px;">
						<img crossorigin="anonymous" src="" alt="" id="camera-image" height="600" width="600" style="height:600px;position: absolute;" >
						<div id="stickerDiv" style="position:absolute;top:0;left:0;z-index:10000;pointer-events:none;">
							<canvas id="image-stickers" height="600" width="600" style="height:600px;width: 100%;top: 0;left: 0;z-index:10000;"></canvas>
						</div>
						
					</div>
										<div id="backgrounds" style="display:none;position:relative;top:5px;bottom:0;z-index:20000; width:600px;">
												
					</div>
					<div id="filters" style="display:none;position:relative;top:5px;bottom:0;z-index:20000; width:600px;">
						<div class="message col-sm-5">
							Select a Filter						</div>
						<div class="select col-sm-3">
							<div class="owl-carousel">
							<div class="item">
								<img class="filter" crossorigin="anonymous" src="{{ asset('storage/photobooth/blank-options-square.png') }}"  data-img="blank" data-filter="blank" >
							</div>
															
							</div>
						</div>
						
					</div>
					<div id="stickers" style="display:none;position:relative;top:5px;bottom:0;z-index:20000; width:600px;">
												<div class="message col-sm-5">
							Add Stickers						</div>
						<div class="select col-sm-3">
							<div class="owl-carousel">


							@foreach($Photoboothsticker as $key => $photo)
									 @php $img = "storage/photobooth/".$photo->image; @endphp

									 <div class="item">
											<img class="sticker" src="{{ asset($img) }}" crossorigin="anonymous" data-img="{{ asset($img) }}">
										</div>
											@endforeach
												
																					
																
							</div>
						</div>
							
					</div>
				</div>
								<div class="buttons mt-0 pt-2 btn-toolbar justify-content-center pt-2 mb-3 pt-2 pb-3" style=";pointer-events:none;">
					<div id="buttons-approve"  class="mt-1" style="z-index:999999!important;pointer-events:all;width: 99vw;position: absolute;left: calc(-49.5vw + 49.5%)!important;">
						<button id="retakePhoto" class="btn btn-secondary btn-lg  btn-action" data-content="Retake">
						  <span>
								<i class="fa fa-arrow-left mr-2" aria-hidden="true"></i> Retake							</span>
						</button>
						<button href="#" id="likePhoto" class="btn btn-secondary btn-lg  btn-action" data-content="I Like it">
						  <span>
								<i class="fa fa-thumbs-up mr-2" aria-hidden="true"></i> I Like it							</span>
						</button>
					</div>
					<div id="buttons-saveBg" style="display:none;z-index:999999!important;pointer-events:all;width: 99vw;position: absolute;left: calc(-49.5vw + 49.5%)!important;">
						<button id="saveBg" class="btn btn-secondary btn-lg  btn-action" data-content="Next">
						  <span>
								<i class="fas fa-arrow-right mr-2" aria-hidden="true"></i> 
							Next							</span>
						</button>
					</div>
					<div id="buttons-saveFilter" style="display:none;z-index:999999!important;pointer-events:all;width: 99vw;position: absolute;left: calc(-49.5vw + 49.5%)!important;">
						<button id="saveFilter" class="btn btn-secondary btn-lg  btn-action" data-content="Next">
						  <span>
								<i class="fas fa-arrow-right mr-2" aria-hidden="true"></i> 
								Next							</span>
						</button>
					</div>
					<div id="buttons-saveSticker" style="display:none;z-index:999999!important;pointer-events:all;width: 99vw;position: absolute;left: calc(-49.5vw + 49.5%)!important;">
						<button id="saveSticker"  class="btn btn-secondary btn-lg  btn-action" data-content="Done">
						  <span>
								<i class="fas fa-flag-checkered mr-2" aria-hidden="true"></i> 
								Done							</span>
						</button>
					</div>
					<div id="buttons-done" style="display:none;z-index:999999!important;pointer-events:all;width: 99vw;position: absolute;left: calc(-49.5vw + 49.5%)!important;" class="mt-1">
						<button id="done"  class="btn btn-secondary btn-lg  btn-action" data-content="Done">
						  <span>
								<i class="fas fa-flag-checkered mr-2" aria-hidden="true"></i> 
								Done							</span>
						</button>
					</div>
				</div>
				
			</div>
        </div>
		
		<!--End Review-->
		<!--Thanks-->
		<div id="thanks" style="display:none;">
			<div class="flex justify-center">
					
												<div class="main text-center" style="display: flex;align-items: center;justify-content: center;">
											<img crossorigin="anonymous" src="https://media0.giphy.com/media/d62XTWi7yORkEr6h9c/giphy.gif?cid=0552ceb7dwnbsi6290abfk0cyj7b5kwnp1ndmjh1hullc04m&rid=giphy.gif&ct=s"  id="thanksImg" class="startBooth" style="max-height:600px;max-width:600px;">
								
				</div>
				
									<div class="main title d-flex " style="position:absolute;top:0;height:600px;width:600px;z-index:1001;">
						<span id="thanksMessage" class="align-bottom thanksMessage" style="width:100%;"></span>
					</div>
														<div class="main text-center logo d-flex justify-content-center   pt-2 pb-3" style="position:absolute;top:0;height:600px;width:600px;z-index:1001;">
						<img crossorigin="anonymous" src="" id="logo" style="max-height:50px">
					</div>
												
				
				<img crossorigin="anonymous" src="{{ asset('storage/photobooth/loading.svg') }}" alt="" id="loading2" style="z-index:20002;position:absolute; top:40%; left:50%;margin: -100px 0 0 -100px;">
				
					
			
				<div class="buttons mt-1">
					
				</div>
			</div>
        </div>
		<!--End Thanks-->
		
		
		<!--Email-->
		<div class="modal fade" id="modalEmailForm" tabindex="-1" data-backdrop="static" role="dialog" aria-labelledby="myModalLabel"
		aria-hidden="true" style="z-index:30001;top:100px;">
			<div class="modal-dialog" role="document">
				<div class="modal-content">
				  <div class="modal-header text-center">
					<h4 class="modal-title w-100 font-weight-bold">Email</h4>
					<!--<button type="button" class="close" data-dismiss="modal" aria-label="Close" id="closeEmail">
					  <span aria-hidden="true">&times;</span>
					</button>
					-->
				  </div> 
				  <form id="emailForm" action="/" method="post" class="needs-validation" novalidate onsubmit="return false;">
				  @csrf
				  <div class="modal-body mx-3">
					<div class="md-form mb-5">
					  <i class="fa fa-envelope prefix grey-text"></i>
					  <input type="email" id="email" name="email" class="form-control validate" required>
					  <label data-error="wrong" data-success="right" for="email">Email</label>
					</div>
				   </div>
				  <input type="hidden" name="includeInGallery" id="includeInGallery" value="1">
				  <input type="hidden" name="eventId" id="eventId" value="{{ $eventId }}">

				  <input type="hidden" name="eventAction" value="boothEmail">
				  <input type="hidden" name="image" value="">
				  <input type="hidden" name="status" id="status" value="0">
				  <input type="hidden" name="mediaID" value="">
				  <input type="hidden" name="event-url" id="event-url" value="july4th">
				  </form>
				  <div class="modal-footer d-flex justify-content-center">
					<button id="sendEmail" class="btn btn-secondary">Send</button>
				  </div>
				</div>
			</div>
		</div>
		<!--End Email-->
		
		<!--Message-->
		<div class="modal fade" id="modalMessage" tabindex="-1" role="dialog" aria-labelledby="myModalLabel"
		aria-hidden="true">
			<div class="modal-dialog" role="document">
				<div class="modal-content">
				  <div class="modal-header text-center">
					<h4 class="modal-title w-100 font-weight-bold">Error</h4>
					<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					  <span aria-hidden="true">&times;</span>
					</button>
				  </div> 
				  
				  <div class="modal-body mx-3" id="messageBody">

					</div>
				</div>
			</div>
		</div>
		<!--End Message-->
    </div>

		
		<pixie-editor></pixie-editor>
		<script src="{{ asset('assets/js/jquery.min.js') }}"></script>
		<script src="{{ asset('assets/js/popper.min.js') }}"></script>
		<script src="{{ asset('assets/js/bootstrap.min.js') }}"></script>
   
        <script src="{{ asset('js/jquery.ui.widget.js') }}"  type='text/javascript'> </script>
        <script src="{{ asset('js/jquery.iframe-transport.js') }}"  type='text/javascript'> </script>
        <script src="{{ asset('js/jquery.fileupload.js') }}"  type='text/javascript'> </script>
        <script src="{{ asset('js/jquery.cloudinary.js') }}"  type='text/javascript'> </script>
		<script src="https://cdn.jsdelivr.net/npm/sweetalert2@9.15.2/dist/sweetalert2.all.js"></script>
        <script src="{{ asset('js/owl.carousel.js') }}"  type='text/javascript'> </script>
        <script src="{{ asset('js/gif.js') }}"  type='text/javascript'> </script>
	    <script src="https://cdnjs.cloudflare.com/ajax/libs/fabric.js/4.4.0/fabric.min.js" /></script>
	    <script src="https://cdn.jsdelivr.net/gh/silvia-odwyer/pixels.js/dist/Pixels.js" /></script>

    <script src="{{ asset('js/booth.js') }}"> </script>
	  


	   		<script src="https://cdnjs.cloudflare.com/ajax/libs/three.js/r77/three.min.js"></script>
			   <script src="{{ asset('js/fireworks2.js') }}"  type='text/javascript'> </script>
	  	 		  
	<script>
		styleButtons("button-cust-press","#ffffff");
	</script>

	<!--<iframe src="/console/text.php" style="display:none;" id="textFrame"></iframe>-->
	<script>
	//window.addEventListener("message", (event) => {
	//	if (event.data.pAction=="text"){
		//	$("#image-overlay").attr("src",event.data.img);
			//$("#image-overlay").show();
			//$("#splash").hide();
			 //$("#capture").show();
			 //startBooth();
		//}
	
	//})
		</script>
</body>
</html>