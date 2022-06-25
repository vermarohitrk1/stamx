@extends('layout.commonlayout')
@section('content')
<!-- Link Swiper's CSS -->
<link
   rel="stylesheet"
   href="https://unpkg.com/swiper/swiper-bundle.min.css"
   />
<link rel="stylesheet" href="https://pro.fontawesome.com/releases/v5.10.0/css/all.css" integrity="sha384-AYmEC3Yw5cVb3ZcuHtOA93w35dYTsvhLPVnYs9eStHfGJvOvKxVfELGroGkvsg+p" crossorigin="anonymous"/>
<!-- Demo styles -->
<style>
.col-12.sub-footer.py120 {
    display: none!important;
}
footer {
    display: none!important;
}
@media (min-width: 576px){
.container {
    max-width: 540px!important;
}
}


@media (min-width: 768px){
.container {
    max-width: 720px!important;
}
}


@media (min-width: 992px) {
.container {
    max-width: 960px!important;
}
}

@media (min-width: 1200px) {

	.container {
		max-width: 1140px!important;
	}
}


.lgs_img video {
    overflow: hidden;
    width: 100%;
    height: 650px;
    object-fit: cover;
}


.videoframe {
    background-repeat: no-repeat;
    width: 500px;
    height: 650px;
    z-index: 99;
    position: absolute;
}


.lgs_img {
    width: 560px;
    position: relative;
    margin: auto;
}

.photo_gal {
    margin-top: 30px;
}
   body {
   margin: 0;
   padding:0;
   }
   .sec-start.new {
   padding: 10rem 0;
   }
   .sec-start{
   background-image: linear-gradient(
   180deg
   ,#667eea 0%,#764ba2 100%)!important;
   }
   .dr_logo {
   text-align: center;
   }

   .dr_logo img {
   width: 100%;
   max-width: 288px;
   }
   .dr_txt {
   text-align: center;
   }
   .dr_txt p {
   color: #fff;
   font-size: 25px;
   }
   .cont_sec{
   width: 80%;
   max-width: 1080px;
   margin: auto;
   position: relative;
   }
   .steps_1_st h1 {
   color: #fff;
   }
   .steps_1_st span {
   color: #fff;
   font-size: 20px;
   }
   .steps_1, .steps_2, .steps_3 {
   display: flex;
   align-items: center;
   }
   .steps_1 .steps_1_st span {
   margin-left: 0px;
   }
   .steps {
    margin-bottom: 30px;
    width: 32%;
    margin: auto;
}
   .steps_1_st h1 {
    color: #fff;
    font-weight: 800;
    text-transform: uppercase;
    color: rgba(255,255,255,0.25)!important;
    line-height: 1.4em;
    text-align: left;
    margin: 5px 0;
    margin-right: 42px;
    font-size: 25px;
    padding: 0px;
}
   .photo_gal {
   text-align: center;
   }
   .photo_gal form label {
   font-size: 20px;
   color: #fff;
   }
   .create_btn button i {
   margin-right: 9px;
   }
   .create_btn button {
   background: #fff;
   padding: 15px 20px;
   font-size: 24px;
   color: rgba(0,0,0, 0.8);
   border-radius: 2px;
   cursor: pointer;
   display: inline-block;
   margin: 23px 9px 8px 0;
   text-decoration: none;
   }
   .dr_mma {
   padding: 40px 0;
   }
   .steps {
   margin-bottom: 30px;
   }
   .sc_icon ul li {
   padding: 0;
   margin: 0;
   list-style-type: none;
   display: inline-block;
   }
   .sc_icon ul {
   margin: 0;
   text-align: center;
   }
   .lgs_img {
   text-align: center;
  
   }
   .len_more {
   background: #000;
   padding-bottom: 40px;
   }
   .len_txt {
   width: 49%;
   display: inline-block;
   text-align: center;
   }
   .len_img {
   width: 50%;
   display: inline-block;
   }
   .sec-start.new {
   background-image: linear-gradient( 
   180deg
   ,#667eea 0%,#764ba2 100%)!important;
   padding-bottom: 50px;
   }
   .len_img img {
   margin-top: -84px!important;
   max-width: 60%;
   text-align: center;
   }
   .len_txt p {
   color: #e8533b!important;
   text-align: center;
   font-size: 29px;
   }
   .len_txt a {
   color: #fff;
   border: 2px solid;
   padding: 10px 20px;
   font-weight: 700;
   text-decoration: none;
   }
   .lgs_img_cam {
   position: absolute;
   top: 39%;
   text-align: center;
   margin: auto;
   left: 0;
   right: 0;
   }
   .lgs_img {
   padding: 30px;
   position: relative;
   }
   .lgs_img_cam img {
   width: 100%;
   max-width: 150px;
   opacity: 0.8;
   cursor: pointer;
   }
   .top_img {
   background-image: url({{ asset('storage/photobooth/yourphoto.png') }});
   background-position: center;
   background-size: cover;
   width: 500px;
   margin: auto;
   }
   @media only screen and (max-width: 767px){
   .steps_1_st span {
   font-size: 15px!important;
   }
   .steps_1_st h1 {
   font-size: 24px!important;
   }
   .photo_gal form label {
   font-size: 13px!important;
   }
   .dr_mma {
   padding: 20px 0!important;
   }
   .create_btn button {
   padding: 12px 14px!important;
   font-size: 16px!important;
   }
   .sec-start.new {
   padding-bottom: 0!important;
   }
   .len_more {
   text-align: center;
   }
   }
   .lgs_img_cam>input {
   display: none;
   }
   .photo_gal label {
   color: #fff;
   }
   .demo.croppie-container {
   width: 450px!important;
   height: 500px!important;
   margin:auto;
   }



@media only screen and (max-width: 767px){


   div#upload-demo .cr-viewport.cr-vp-square {
   background-size: contain;
    background-repeat: no-repeat;
    height: auto!important;
}

}
img.cr-image {
    height: 100%!important;
}
</style>
<!-- Swiper -->
<div class="sec-start new">
<div class="cont_sec">
   <div class="dr_mma">
      <div class="dr_logo">
      </div>
      <div class="dr_txt">
      </div>
      <div class="steps">
         <div class="steps_1">
            <div class="steps_1_st">
               <h1>Step 1</h1>
            </div>
            <div class="steps_1_st">
               <span>Upload Photo</span>
            </div>
         </div>
         <div class="steps_2">
            <div class="steps_1_st">
               <h1>Step 2</h1>
            </div>
            <div class="steps_1_st">
               <span>Click <strong>CREATE PHOTO</strong></span>
            </div>
         </div>
         <div class="steps_3">
            <div class="steps_1_st">
               <h1>Step 3</h1>
            </div>
            <div class="steps_1_st">
               <span>Snap & Share</span>
            </div>
         </div>
      </div>
      {{ Form::open(['url' =>'photobooth/guest/upload','id' => 'Photobooth_Template','enctype' => 'multipart/form-data']) }}
      <div class="lgs_img">

@if($Photobooth->type == 'photo')
         <div id="upload-demo"></div>
         <input type="file" id="upload" value="Choose a file">
         <input type="hidden" id="imagebase64" name="photo">
         @else

         
         <div class="videoframe" >
     
</div>
<video width="500" autoplay loop>
  <source src="mov_bbb.mp4" id="video_here">
    Your browser does not support HTML5 video.
</video> 

         @endif
         <div class="photo_gal {{ $Photobooth->type }}">
         @if($Photobooth->type == 'video')
         <div class="form-group fileinput">
         <input type="file" name="video" class="w-auto m-auto file_multi_video form-control-file" accept="video/*">
</div>
@endif
            <input type="checkbox" id="termcondition" name="termcondition" value="1">
            <input type="hidden" name="frame_id"  value="{{$Photobooth->id}}"> 

            <input type="hidden" name="public_id"  value="{{$Photobooth->public_id}}"> 
            <label for="termcondition">I agree to share this photo with public event gallery</label><br>
            <div class="create_btn">
               <button  id="uploadbutton" class="@if($Photobooth->type == 'photo') upload-result" @else upload-video @endif" type="submit"><i class="fa fa-cloud-download" aria-hidden="true"></i>Create Photo</button>
            </div>
            {{ Form::close() }}
         </div>
         <div class="sc_icon">
            <ul >
               <li><a href=""><i class="fa fa-twitter" aria-hidden="true"></i></a></li>
               <li><a href=""><i class="fa fa-facebook" aria-hidden="true"></i></a></li>
               <li><a href=""><i class="fa fa-twitter" aria-hidden="true"></i></a></li>
            </ul>
         </div>
      </div>
   </div>
</div>
@endsection
@push('script')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/croppie/2.6.5/croppie.css" integrity="sha512-2eMmukTZtvwlfQoG8ztapwAH5fXaQBzaMqdljLopRSA0i6YKM8kBAOrSSykxu9NN9HrtD45lIqfONLII2AFL/Q==" crossorigin="anonymous" referrerpolicy="no-referrer" />
<script src="https://cdnjs.cloudflare.com/ajax/libs/croppie/2.6.5/croppie.min.js" integrity="sha512-Gs+PsXsGkmr+15rqObPJbenQ2wB3qYvTHuJO6YJzPe/dTLvhy0fmae2BcnaozxDo5iaF8emzmCZWbQ1XXiX2Ig==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
<link rel="Stylesheet" type="text/css" href="https://foliotek.github.io/Croppie/demo/demo.css" />
<script src="https://cdnjs.cloudflare.com/ajax/libs/croppie/2.6.5/croppie.js" integrity="sha512-vUJTqeDCu0MKkOhuI83/MEX5HSNPW+Lw46BA775bAWIp1Zwgz3qggia/t2EnSGB9GoS2Ln6npDmbJTdNhHy1Yw==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
<script src="https://foliotek.github.io/Croppie/demo/demo.js"></script>
<script src="https://foliotek.github.io/Croppie/bower_components/exif-js/exif.js"></script>
<script>
   Demo.init();
</script>
<script>
   $( document ).ready(function() {
   
      setTimeout(function() {
         $(".cr-image").attr("src", "{{ URL::to('/') }}/storage/photobooth/blank.png");
        
       }, 2000);
       setTimeout(function() {
       
         $(".cr-image").css("height", "100%");
         $(".cr-image").css("width", "100%");
       }, 3000);

    $(".videoframe").css("background-image", "url('{{ asset('storage/photobooth/'.$Photobooth->template) }}')");

    $(document).on("change", ".file_multi_video", function(evt) {
  var $source = $('#video_here');
  $source[0].src = URL.createObjectURL(this.files[0]);
  $source.parent()[0].load();
});


       var $uploadCrop;
   
       function readFile(input) {
           if (input.files && input.files[0]) {
               var reader = new FileReader();          
               reader.onload = function (e) {
                   $uploadCrop.croppie('bind', {
                       url: e.target.result
                   });
                   $('.upload-demo').addClass('ready');
               }           
               reader.readAsDataURL(input.files[0]);
           }
       }
   
       $uploadCrop = $('#upload-demo').croppie({
           viewport: {
               width: 500,
               height: 650,
               type: 'square'
           },
           boundary: {
               width: 500,
               height: 650
           },
       });
       $(".cr-vp-square").css("background-image", "url('{{ asset('storage/photobooth/'.$Photobooth->template) }}')");
   
       $('#upload').on('change', function () { readFile(this); });
       $('.upload-result').on('click', function (ev) {
           ev.preventDefault();
           $uploadCrop.croppie('result', {
               type: 'canvas',
               size: 'viewport'
           }).then(function (resp) {
               $('#imagebase64').val(resp);
               $('#Photobooth_Template').submit();
           });
       });
   
   });

   
</script>
@endpush