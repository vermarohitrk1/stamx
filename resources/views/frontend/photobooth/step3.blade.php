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
body {font-family: Arial, Helvetica, sans-serif;}

/* The Modal (background) */
.modal {
  display: none; /* Hidden by default */
  position: fixed; /* Stay in place */
  z-index: 1; /* Sit on top */
  padding-top: 100px; /* Location of the box */
  left: 0;
  top: 0;
  width: 100%; /* Full width */
  height: 100%; /* Full height */
  overflow: auto; /* Enable scroll if needed */
  background-color: rgb(0,0,0); /* Fallback color */
  background-color: rgba(0,0,0,0.4); /* Black w/ opacity */
}

/* Modal Content */
.modal-content {
  background-color: #fefefe;
  margin: auto;
  padding: 20px;
  border: 1px solid #888;
  width: 33%;
}

/* The Close Button */
.close {
  color: #aaaaaa;
  float: right;
  font-size: 28px;
  font-weight: bold;
}

.close:hover,
.close:focus {
  color: #000;
  text-decoration: none;
  cursor: pointer;
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

    a.btn.btn-primary.resp-sharing-button__link.fb {
    color: #fff!important;
    background-color: #1877f2;
    border-radius: 6px;
    font-size: 16px;
    height: auto;
    margin: 20px;
    padding: 14px;
    border-color: #1877f2;
    / min-width: 60px; /
}

a.resp-sharing-button__link.twittr {
color: #fff!important;
    background-color: #1da1f2;
    border-radius: 6px;
    font-size: 16px;
    height: auto;
    margin: 20px;
    padding: 14px;
    border-color: #1da1f2;

}

.result_share_buttons {
    margin-top: 20px;
}
    
a.resp-sharing-button__link.fb {
    color: #fff!important;
    background-color: #1b95e0!important;
    border-radius: 6px!important;
    height: auto!important;
    margin: 20px!important;
    padding: 3px 20px!important;
    border-color: #1da1f2!important;
    font-size: 11px!important;
    position: relative;
    top: -5px;
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
   margin-top: 30px;
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
    font-size: 16px;
}
   .dwnld_btn a {
    background: #fff;
    padding: 11px 13px;
    font-size: 17px;
    text-decoration: none;
    border-radius: 6px;
}

   .dwnld_btn {
   text-align: center;
   margin-top: 20px;
   }
   .dr_mma {
   margin: auto;
   text-align: center;
   }
</style>
</head>
<body>
   <!-- Swiper -->
   <div class="sec-start new">
      <div class="cont_sec">
         <div class="dr_mma">
            <div class="dr_logo">
            </div>
            <div class="dr_txt">
               <p>by <strong>StemX</strong></p>
            </div>
            <div class="steps">
            </div>
            @if($type == 'photo')
            <div class="lgs_img">
               <div class="top_img">
                  <img id="p_imgss" src="{{ url($craetedPath) }}" alt="preview"/>	
               </div>
            </div>
            <div class="dwnld_btn">
               <a class="btn" href="   {{ url($craetedPath) }}" download>Preview Full Screen</a>
            </div>
            @else
            <video width="500" autoplay="" loop>
               <source src="{{ url($craetedPath) }}" id="video_here">
               Your browser does not support HTML5 video.
            </video>
            @endif
            <div class="sc_icon">
         

@if($type == 'photo')
<div class="result_share_buttons">
             <input type="hidden" id="sharer_name" value="">
             <input type="hidden" id="sharer_email" value="">
             
            <a class="resp-sharing-button__link fb" onclick='fbs_click()' target="_blank" rel="noopener" aria-label="Share on Facebook">
            <i class="fab fa-facebook-square"></i>
Facebook </a>
           
            <a class="twitter-share-button" href="https://twitter.com/share" data-size="small" data-url="{{ url($craetedPath) }}" data-text="Hello" data-count="none" > Twitter</a>

         </div>

@else

<div class="result_share_buttons">
            <a class="resp-sharing-button__link fb btn btn-primary" onclick='fbs_clickvideo()' target="_blank" rel="noopener" aria-label="Share on Facebook">
            <i class="fab fa-facebook-square"></i>  Facebook </a>
         
<a class="twitter-share-button resp-sharing-button__link fb btn btn-primary " href="https://twitter.com/share" data-size="small" data-url="{{ url($craetedPath) }}" data-text="Hello" data-count="none" >   <i class="fab fa-twitter-square"></i>  Twitter</a>

                  </div>
@endif

        </div>
         </div>
      </div>
   </div>
   <div class="len_more">
      <div class="cont_sec">
         <div class="len_img">
         </div>
         <div class="len_txt">
         <!--    <p><strong></span></p>
            <a href="">Learn More</a> -->
         </div>
      </div>
   </div>
   <!-- The Modal -->
<div id="myModal" class="modal">

  <!-- Modal content -->
  <div class="modal-content">
    <span class="close">&times;</span>
   <div class="col-md-12 col-lg-12 col-xl-12 order-2 order-lg-1">

                  <p class="text-center h1 fw-bold mb-5 mt-4">Sign up</p>

                  <form>

                    <div class="d-flex flex-row align-items-center mb-4">
                      <i class="fas fa-user fa-lg me-3 fa-fw"></i>
                      <div class="form-outline flex-fill mb-0">
                        <input type="text" id="formname" class="form-control">
                      
                      <div class="form-notch"><div class="form-notch-leading" style="width: 9px;"></div><div class="form-notch-middle" style="width: 71.2px;"></div><div class="form-notch-trailing"></div></div></div>
                    </div>

                    <div class="d-flex flex-row align-items-center mb-4">
                      <i class="fas fa-envelope fa-lg me-3 fa-fw"></i>
                      <div class="form-outline flex-fill mb-0">
                        <input type="email" id="formemail" class="form-control">
                       
                      <div class="form-notch"><div class="form-notch-leading" style="width: 9px;"></div><div class="form-notch-middle" style="width: 68.8px;"></div><div class="form-notch-trailing"></div></div></div>
                    </div>

                    <div class="d-flex justify-content-center mx-4 mb-3 mb-lg-4">
                      <button id="savedata" type="button" class="btn btn-primary btn-lg">Save</button>
                    </div>

                  </form>

                </div>
  </div>

</div>
  @endsection
   @push('script')
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jsSocials/1.5.0/jssocials-theme-flat.min.css"
    integrity="sha256-1Ru5Z8TdPbdIa14P4fikNRt9lpUHxhsaPgJqVFDS92U=" crossorigin="anonymous" />
   <script src="https://cdnjs.cloudflare.com/ajax/libs/jsSocials/1.5.0/jssocials.min.js"
    integrity="sha256-QhF/xll4pV2gDRtAJ1lvi9YINqySpAP+0NIzIX5voZw=" crossorigin="anonymous"></script>
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jsSocials/1.5.0/jssocials.min.css"
    integrity="sha256-1tuEbDCHX3d1WHIyyRhG9D9zsoaQpu1tpd5lPqdqC8s=" crossorigin="anonymous" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.10.2/css/all.min.css"
    integrity="sha256-zmfNZmXoNWBMemUOo1XUGFfc0ihGGLYdgtJS3KCr/l0=" crossorigin="anonymous" />
    <script async defer crossorigin="anonymous" src="https://connect.facebook.net/en_US/all.js"></script> 
    <script async defer crossorigin="anonymous" src="https://cdn.rawgit.com/oauth-io/oauth-js/c5af4519/dist/oauth.js"></script> 
     <script>
          window.twttr=(function(d,s,id){var js,fjs=d.getElementsByTagName(s)[0],t=window.twttr||{};if(d.getElementById(id))return;js=d.createElement(s);js.id=id;js.src="https://platform.twitter.com/widgets.js";fjs.parentNode.insertBefore(js,fjs);t._e=[];t.ready=function(f){t._e.push(f);};return t;}(document,"script","twitter-wjs"));
     </script> 
     <script src="https://platform.twitter.com/widgets.js"></script>
<script>
//    $('#twitter-button').on('click', function() {
// 	// Initialize with your OAuth.io app public key

// })
twttr.events.bind('tweet' , function(event) {

console.log(event);
 OAuth.initialize('HwAr2OtSxRgEEnO2-JnYjsuA3tc');
 OAuth.popup('twitter').then(twitter => {
    console.log('twitter:', twitter);
    // Prompts 'welcome' message with User's email on successful login
    // #me() is a convenient method to retrieve user data without requiring you
    // to know which OAuth provider url to call
    twitter.me().then(data => {
      console.log('data:', data);
      sharer_name = data.name;;
      sharer_email = data.email;
      u=$('#p_imgss').attr('src');
      //alert('Twitter says your email is:' + data.email + ".\nView browser 'Console Log' for more details");
    //  alert("Tweet has been successfully posted");
     // show_toastr("Post", ' uploaded successfully.', "success");
      var type = 2;
      var frame_id = {{ $frameId }} ;
      addcount(u,sharer_name,sharer_email,frame_id,type);
   
   });

});

});
</script> 
<script>
   
   // FB.init({
   //    appId            : '530014071410514',
   //    autoLogAppEvents : true,
   //    xfbml            : true,
   //    version          : 'v12.0'
   //  });
     window.fbAsyncInit = function() {
    FB.init({
      appId            : '213190363304717',
      autoLogAppEvents : true,
      xfbml            : true,
      version          : 'v12.0'
    });
  };
  
 
   function fbs_click() {
      u=$('#p_imgss').attr('src');
 
   FB.getLoginStatus(function(response) {   // Called after the JS SDK has been initialized.
     
      if (response.status === 'connected') {   // Logged into your webpage and Facebook.
            console.log('Welcome!  Fetching your informations.... ');
           FB.api('/me', function(response) {
      console.log('Successful login for: ' + response.name);
   console.log(response);
        var sharer_name = response.name ;
        var sharer_email = response.id ;
        var frame_id = {{ $frameId }} ;

      FB.ui(
      {
         method: 'feed',
         link: u,
      },
      // callback
      function(response) {
         console.log(response);
    
         if (response && !response.error_message) {
        var type = 1;
            addcount(u,sharer_name,sharer_email,frame_id,type);
            //console.log(response);
         } else {
           // alert('Error while posting.');
            show_toastr("Error", ' while posting.', "error");
         // console.log(response.error_message);
         }
      }
      );
    });
    } else {   
      FB.init({
      appId            : '213190363304717',
      autoLogAppEvents : true,
      xfbml            : true,
      version          : 'v12.0'
    });                              // Not logged into your webpage or we are unable to tell.
   // show_toastr("Something", 'went wrong.', "error");
  FB.login(function(response) {
  if (response.status === 'connected') {
          console.log('Welcome!  Fetching your informations.... ');
           FB.api('/me', function(response) {
           console.log('Successful login for: ' + response.name);
           console.log(response);
           var sharer_name = response.name ;
           var sharer_email = response.id ;
           var frame_id = {{ $frameId }} ;
      FB.ui(
      {
         method: 'feed',
         link: u,
      },
      // callback
      function(response) {
         console.log(response);
    
         if (response && !response.error_message) {
        var type = 1;
            addcount(u,sharer_name,sharer_email,frame_id,type);
            //console.log(response);
         } else {
            show_toastr("Error", ' while posting.', "error");

         // console.log(response.error_message);
         }
      }
      );
    });
  } else {
    // The person is not logged into your webpage or we are unable to tell. 
  }
});
    }
           // Returns the login status.
    });


      //  u=$('#p_imgss').attr('src');
       // window.open('https://facebook.com/sharer/sharer.php?u='+u);
     }
   
     function addcount(url,sharer_name,sharer_email, frame_id, type){
//alert(type);
      if(url !=""){
      var data = {
                        url: url,
                        name: sharer_name,
                        email: sharer_email,
                        frame_id:frame_id,
                        type:type
                    }
                 $.ajax({
                    dataType: 'json',
               url: '{{ route('photobooth.sharecount') }}',
                data: data,
                success: function (data) {
                   if(data.status == 'success'){
                     show_toastr("Post", ' uploaded successfully.', "success");
                    // alert('Post uploaded successfully.');

                   }
                     
                }
            });
        }
     }


// });



  function checkLoginState() {               // Called when a person is finished with the Login Button.
    FB.getLoginStatus(function(response) {   // See the onlogin handler
      statusChangeCallback(response);
    });
  }

$('#savedata').click(function(){
  $('#sharer_name').val($('#formname').val());
  $('#sharer_email').val($('#formemail').val());
 
var modal = document.getElementById("myModal");
  modal.style.display = "none";
   })


     function twitter_click() {
        u=$('#p_imgss').attr('src');
        window.open('https://twitter.com/share?url='+u);
      
     }
     function fbs_clickvideo() {
        u=$('#video_here').attr('src');
        window.open('https://facebook.com/sharer/sharer.php?u='+u);

       
     }
     function twitter_clickvideo() {
        u=$('#video_here').attr('src');
        window.open('https://twitter.com/share?url='+u);
     }

     
     
</script>
@endpush