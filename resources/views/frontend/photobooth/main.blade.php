@extends('layout.commonlayout')
@section('content')
    <link  rel="stylesheet" href="https://unpkg.com/swiper/swiper-bundle.min.css"   />
<link rel="stylesheet" href="https://pro.fontawesome.com/releases/v5.10.0/css/all.css" integrity="sha384-AYmEC3Yw5cVb3ZcuHtOA93w35dYTsvhLPVnYs9eStHfGJvOvKxVfELGroGkvsg+p" crossorigin="anonymous"/>
    <!-- Demo styles -->
    <style>
        .col-12.sub-footer.py120 {
    display: none!important;
}
footer {
    display: none!important;
}
      html,
      body {
        position: relative;
        height: auto;
		    background-image: linear-gradient(
180deg
,#667eea 0%,#764ba2 100%)!important;
		
      }
	  .sec-start {
    margin: 10rem 0;
}

      body {
        background: #eee;
        font-family: Helvetica Neue, Helvetica, Arial, sans-serif;
        font-size: 14px;
        color: #000;
        margin: 0;
        padding: 0;
      }

      .swiper-container {
        width: 100%;
        padding-top: 50px;
        padding-bottom: 50px;
      }

      .swiper-slide {
    background-position: center;
    background-size: cover;
    width: 290px;
    margin: 0 20px;
}
      .swiper-slide img {
        display: block;
        width: 100%;
      }
	  .swiper-button-next, .swiper-button-prev {
    position: relative!important;

}

.swiper-button-next:after, .swiper-button-prev:after {
    font-size: 17px;

}

.swiper-button-next, .swiper-button-prev {
    margin-top: 0;
    background-color: rgba(0,0,0,0)!important;
    border: 2px solid;
    border-radius: 50%;
    font-size: 35px;
    width: 30px;
    height: 30px;
    padding: 2px;
}

.arro_s {
    margin-top: 15px;
}
.swiper-button-next {
    margin-left: 10px;
}

.swiper-button-prev, .swiper-container-rtl .swiper-button-next {
    left: auto;
    right: auto;
}

.swiper-button-next, .swiper-container-rtl .swiper-button-prev {
    right: auto;
    left: auto;
}

.arro_s {
    display: flex;
    justify-content: center;
    flex-direction: row-reverse;
    align-items: center;
}




.swiper-button-next, .swiper-button-prev{margin-top:0;}




.swiper-button-next, .swiper-button-prev {
    color: #fff;
}

._button_content {
    margin-top: 10px;
    text-align: center;
}


._button_content a.button {
    color: #ffffff!important;
    border-radius: 8px;
    font-size: 14px;
    font-weight: 600!important;
    text-transform: uppercase!important;
    display: inline-block;
    padding: 0.3em 1em;
    line-height: 1.7em !important;
    background-color: transparent;
    background-size: cover;
    background-position: center;
    background-repeat: no-repeat;
    position: relative;
    border: 2px solid;
    border-radius: 7px;
    -webkit-transition: all 0.2s;
    transition: all 0.2s;
    text-decoration: none!important;
}

._button_content a.button:after {
    font-size: 32px;
    line-height: 1em;
    content: "\f054";
    opacity: 0;
    position: absolute;
    margin-left: -1em;
    -webkit-transition: all 0.2s;
    transition: all 0.2s;
    text-transform: none;
    font: normal normal normal 14px/1 FontAwesome;
    font-variant: none;
    font-style: normal;
    font-weight: 400;
    text-shadow: none;
}
._button_content a:hover:after{
  
    margin-left: 0;
}

._button_content a.button:hover {
    background-color: rgba(255, 255, 255, 0.2);
}
._button_content a.button:hover, ._button_content a.button:hover {
    border: 2px solid transparent;
    padding: 0.3em 2em 0.3em 0.7em;
}

.text_full {
    text-align: center;
    color: #fff;
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

.swiper-slide-shadow-left, .swiper-slide-shadow-right {
    display: none;
}

.overlay {
    position:absolute;
    top:0;
    left:0;
    right:0;
    bottom:0;
    background-color:rgba(0, 0, 0, 0.25);
    z-index:9999;

}

.swiper_img {
    position: relative;
}

.swiper-slide.swiper-slide-active .overlay{display:none;}
@media only screen and (max-width: 767px){
 body {
height:auto!important;
      }
}

    </style>

    <!-- Swiper -->

    <div class="container">
	
		
		
    <div class="sec-start">

    <div class="swiper-container mySwiper">
      <div class="swiper-wrapper">
	  @if(!empty($Photobooth))
	  @foreach($Photobooth as $_Photobooth)
        <div class="swiper-slide">
        <div class="swiper_img">
		<div class="overlay"></div>
          <img src="{{ asset('storage/photobooth/'.$_Photobooth->event_image) }}" />
		  
        </div>
		
		<div class="_button_content">  
        <h4 class="card-title">{{ $_Photobooth->event_name }}</h4>      
		<div class="button_sec">
	
		<a class="button" href="{{url('photobooth/webcamera/'. encrypted_key($_Photobooth->id, 'encrypt'))}}">Demo</a>

    </div>
		</div>
        </div>
	@endforeach	
    @endif    
		
		
     
		
		
      </div>
	  <div class="arro_s">
	   <div class="swiper-button-next"></div>
      <div class="swiper-button-prev"></div>
     </div>
    </div>
	
	<div class="text_full">
	<div class="text_btm">
				
				
						<div class="txt">  <p></p>
		<p>Simply <strong>SNAP,</strong> &amp; <strong>SHARE.</strong></p></div>
			</div>
			
			
			<div class="lg_img">
				
				
			
			</div>
			
			<div class="sc_icon">
			<ul class="">
				
				
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
    <!-- Swiper JS -->
    <script src="https://unpkg.com/swiper/swiper-bundle.min.js"></script>

    <!-- Initialize Swiper -->
    <script>
      var swiper = new Swiper(".mySwiper", {
        effect: "coverflow",
        grabCursor: true,
        centeredSlides: true,
        slidesPerView: "auto",
        coverflowEffect: {
          rotate: 40,
          stretch: 0,
          depth: 100,
          modifier: 1,
          slideShadows: true,
        },
        pagination: {
          el: ".swiper-pagination",
        },
		   navigation: {
          nextEl: ".swiper-button-next",
          prevEl: ".swiper-button-prev",
        },
      });
    </script>
	
@endpush

	

