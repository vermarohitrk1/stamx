@extends('layout.commonlayout')
@section('content')

@push('css')
     
      <link href="https://use.fontawesome.com/releases/v5.4.1/css/all.css" rel="stylesheet" type="text/css">
      <link href="https://cdn.jsdelivr.net/npm/sweetalert2@9.15.2/dist/sweetalert2.min.css" rel="stylesheet" type="text/css">
  
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@9.15.2/dist/sweetalert2.min.css">
    
      <link href="{{ asset('css/owl.theme.default.css') }}" rel="stylesheet" type="text/css">

      <link href="https://pagecdn.io/lib/easyfonts/fonts.css" rel="stylesheet" type="text/css" />

      <style>
         @import url('https://fonts.googleapis.com/css2?family=Oswald&display=swap');
      </style>
      <style>
        .col-12.sub-footer.py120 {
    display: none!important;
}
footer {
    display: none!important;
}
         button span i{display:none!important;}
      </style>

 <script>
         dW=1600;
         dH=1600;
            eventURL="july4th";
         accountUID="L9nrpV9Z";
         site={!! json_encode(url('/')) !!};   
         vsite={!! json_encode(url('/')) !!};  
         
               
         var optBoom=1;
         var optGif=1;
         var optLib=1;
         var optF=0;
         var optB=0;
         var optS=1;
         var optM=1;
         var optT="https://media0.giphy.com/media/d62XTWi7yORkEr6h9c/giphy.gif?cid=0552ceb7dwnbsi6290abfk0cyj7b5kwnp1ndmjh1hullc04m&rid=giphy.gif&ct=s";
         var optG=1;
         var optGT="photo to our gallery?";
         var optD=0;
         var optDT="";
         var optUI=0;
         var optUIT="Enter your full name";;
         var numBGs=0;
         var autoBG=0;  
         
         
          
                     var gifSpeed = 500;
         var boomerangSpeed = 200;
         
         
         
      </script>
      <!-- Global site tag (gtag.js) - Google Analytics -->
      <script async src="https://www.googletagmanager.com/gtag/js?id=G-S63G7WH4Y8"></script>
      <script>
         window.dataLayer = window.dataLayer || [];
         function gtag(){dataLayer.push(arguments);}
         gtag('js', new Date());
         
         gtag('config', 'G-S63G7WH4Y8');
      </script>                                        
  
      @endpush
      <link rel="stylesheet" href="{{ asset('css/booth.css') }}">
       <div class="photoboothwebcam" >
      <div class="container pt-1 mt-0 mx-auto" >
         <!--Capture-->
         <div id="capture">
            <div class="flex justify-center">
               <div class="main text-center" style="position:relative;overflow:hidden;">
                  <div id="camera-wrapper" style="height:600px;">
              
                     <div class="d-flex justify-content-center" id="countdown">
                        <div id="countdownText"></div>
                     </div>
                     <canvas id="camera-canvas" data="" width="600" height="600" style="height:600px;"></canvas>
                     <video id="camera-video" autoplay="" playsinline="" style="height:600px;"></video>
                     <div class="shutter"></div>
                     @if(!empty($Photobooth))
                           @foreach($Photobooth as $key => $_Photobooth)
                           @if( $key == 0)
                           <img id="image-overlay" class="image-overlay" crossorigin="anonymous" src="{{ asset('storage/photobooth/'.$_Photobooth->template) }}" style="height:600px;pointer-events:none;">
                                @endif
                           @endforeach
                           @endif
                    
                  </div>
                  <!--Frames-->
                  <div id="frames" >
                     <script>var numFrames=5; </script>
                     <div class="message col-sm-6">
                        Select a Frame                   <!--  <div id="min-frames" style="position:absolute;top:0px;right:5px;">-</div>-->
                     </div>
                     <div class="selectt col-sm-3">
                        <div class="owl-carousel">
                         
                           @if(!empty($Photobooth))
                           @foreach($Photobooth as $_Photobooth)
                           <div class="item" style="width:65px;">
                              <img class="frame" src="{{ asset('storage/photobooth/'.$_Photobooth->template) }}" crossorigin="anonymous" data-frame="{{ $_Photobooth->id }}" data-public="{{ $_Photobooth->public_id }}" data-img="{{ asset('storage/photobooth/'.$_Photobooth->template) }}" >
                           </div>
                           @endforeach
                           @endif
                        </div>
                     </div>
                  </div>
                  <!--End Frames-->
               </div>
               <input id="image-picker" type="file" accept="image/*"  style="display:none;">
               <div class="progress" style="display:none;" id="captureProgress">
                  <div class="progress-bar" role="progressbar" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100" style="width:0%"></div>
               </div>
               <div class="buttons mt-0 pt-2 btn-toolbar justify-content-center pt-2 mb-3 pt-2 pb-3" > 
            
               
               <button id="takePhoto-pre" class="btn btn-secondary btn-lg  d-md-table btn-action mr-2 pl-2 pr-2" data-content="Photo">
                  <span><i class="fas fa-camera mr-2" aria-hidden="true"></i>Photo</span>
                  </button>
                  <button id="takePhoto" class="btn btn-secondary btn-lg  d-md-table btn-action mr-2 pl-2 pr-2 hideMe" data-content="Camera">
                  <span><i class="fas fa-camera mr-2" aria-hidden="true"></i>Camera</span>
                  </button>
               <!--    <button  id="openLibrary" class="btn btn-secondary btn-lg  d-md-table  btn-action mr-2 pl-2 pr-2 hideMe" data-content="Select">
                  <span><i class="fa fa-th mr-2" aria-hidden="true"></i>Select</span>
                  </button> -->
               </div>
               <span class="flip" ><img src="" crossorigin="anonymous" width=64 height=64></span>
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
                     <img src="" alt="" id="loading" crossorigin="anonymous" style="display:none;z-index:20002;position:absolute; top:50%; left:50%;margin: -100px 0 0 -100px;">
                     <img crossorigin="anonymous" src="" alt="" id="camera-image" height="600" width="600" style="height:600px;position: absolute;" >
                     <div id="stickerDiv" style="position:absolute;top:0;left:0;z-index:10000;pointer-events:none;">
                        <canvas id="image-stickers" height="600" width="600" style="height:600px;width: 100%;top: 0;left: 0;z-index:10000;"></canvas>
                     </div>
                  </div>
                  <div id="backgrounds" style="display:none;position:relative;top:5px;bottom:0;z-index:20000; width:600px;">
                  </div>
                  <div id="filters" style="display:none;position:relative;top:5px;bottom:0;z-index:20000; width:600px;">
                     <div class="message col-sm-5">
                        Select a Filter                  
                     </div>
                     <div class="select col-sm-3">
                        <div class="owl-carousel">
                           <div class="item">
                              <img class="filter" crossorigin="anonymous" src=""  data-img="blank" data-filter="blank" >
                           </div>
                        </div>
                     </div>
                  </div>
                  <div id="stickers" style="display:none;position:relative;top:5px;bottom:0;z-index:20000; width:600px;">
                     <div class="message col-sm-5">
                        Add Stickers                  
                     </div>
                     <div class="select col-sm-3">
                        <div class="owl-carousel">
                           @if(!empty($Photobooth))
                           @foreach($Photobooth as $_Photobooth)
                           <div class="item">
                              <img class="sticker" src="{{ asset('storage/photobooth/'.$_Photobooth->template) }}" crossorigin="anonymous" data-img="{{ asset('storage/photobooth/'.$_Photobooth->template) }}">
                           </div>
                           @endforeach
                           @endif
                        </div>
                     </div>
                  </div>
               </div>
               <div class="buttons mt-0 pt-2 btn-toolbar justify-content-center pt-2 mb-3 pt-2 pb-3" style=";pointer-events:none;">
                  <div id="buttons-approve"  class="mt-1" style="z-index:999999!important;pointer-events:all;">
                     <button id="retakePhoto" class="btn btn-secondary btn-lg  btn-action" data-content="Retake">
                     <span>
                     <i class="fa fa-arrow-left mr-2" aria-hidden="true"></i> Retake                     </span>
                     </button>
                  {{ Form::open(['url' =>'photobooth/guest/upload','id' => 'Photobooth_Template','enctype' => 'multipart/form-data']) }}
                          <input type="hidden" id="public_id" name="public_id"  value="yzsh1lm6p0skfdnktytm"> 
                          @if(!empty($Photobooth))
                           @foreach($Photobooth as $key => $_Photobooth)
                           
                           @if($key == 0)
                           <input type="hidden" id="frame_id" name="frame_id"  value="{{ $_Photobooth->id }}"> 
                           @endif
                           @endforeach
                           @endif
                        

                          <input type="hidden" id="imagebase64" name="photo">
                     <button id="sendEmaildata" class="btn btn-secondary">Send</button>
                           {{ Form::close() }}
                  </div>
                  <div id="buttons-saveBg" style="display:none;z-index:999999!important;pointer-events:all;">
                     <button id="saveBg" class="btn btn-secondary btn-lg  btn-action" data-content="Next">
                     <span>
                     <i class="fas fa-arrow-right mr-2" aria-hidden="true"></i> 
                     Next                    </span>
                     </button>
                  </div>
                  <div id="buttons-saveFilter" style="display:none;z-index:999999!important;pointer-events:all;">
                     <button id="saveFilter" class="btn btn-secondary btn-lg  btn-action" data-content="Next">
                     <span>
                     <i class="fas fa-arrow-right mr-2" aria-hidden="true"></i> 
                     Next                    </span>
                     </button>
                  </div>
                  <div id="buttons-saveSticker" style="display:none;z-index:999999!important;pointer-events:all;">
                     <button id="saveSticker"  class="btn btn-secondary btn-lg  btn-action" data-content="Done">
                     <span>
                     <i class="fas fa-flag-checkered mr-2" aria-hidden="true"></i> 
                     Done                    </span>
                     </button>
                  </div>
                  <div id="buttons-done" style="display:none;z-index:999999!important;pointer-events:all;" class="mt-1">
                     <button id="done"  class="btn btn-secondary btn-lg  btn-action" data-content="Done">
                     <span>
                     <i class="fas fa-flag-checkered mr-2" aria-hidden="true"></i> 
                     Done                    </span>
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
               <img crossorigin="anonymous" src="" alt="" id="loading2" style="z-index:20002;position:absolute; top:40%; left:50%;margin: -100px 0 0 -100px;">
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
                   
                  </div>
               
                  <div class="modal-footer d-flex justify-content-center">
                  <input type="checkbox" id="termcondition" name="termcondition" value="1">
               <label for="termcondition">I agree to share this photo with public event gallery</label><br>
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
    </div>

 @endsection
      @push('script')
  
     
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






      <script>
         $( document ).ready(function() {
            startBooth();


         });
          $(document).on("click", "#sendEmaildata", function(event) {
              event.preventDefault()

         
    var imgcomp =  imageCanvas.toDataURL("image/jpeg")
   // console.log(imgcomp);
            $('#imagebase64').val(imgcomp);
               $('#Photobooth_Template').submit();
               })
              $(document).on("click", ".frame", function(event) {
                     // alert($(this).data('public'));
                      $('#public_id').val($(this).data('public'));
                      $('#frame_id').val($(this).data('frame'));
               })
              
     
          function compressImage(base64Image) {
    var image = base64ToImage(base64Image);
   
    var canvas=document.createElement("canvas");
    var context=canvas.getContext("2d");
    canvas.width=image.width/4;
    canvas.height=image.height/4;
    context.drawImage(image,
        0,
        0,
        image.width,
        image.height,
        0,
        0,
        canvas.width,

        canvas.height
    );
     console.log(canvas.toDataURL("image/jpeg"));
    return canvas.toDataURL("image/jpeg");
}// end func

function base64ToImage(base64Image) {
   
    var image = new Image();
    image.src =  base64Image;
    return image;
}
               
      </script>
 


      @endpush