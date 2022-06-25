

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    
	<title>Stemx -  Virtual PhotoBooth</title>
	<meta property="og:title"         content="Stemx - Online Virtual Photo Booth" />
	
    <meta property="og:description" content="Check out my photo." />
	<meta property="og:image" content="https://res.cloudinary.com/virtualbooth/image/upload/f_auto,fl_lossy,q_auto,h_600/v1633083806/L9nrpV9Z/july4th/booth/szcc3fuytaoc8hicdnem.jpg" />
	<meta property="og:image:width" content="600" />
	<meta property="og:image:height" content="600" />
	<meta property="og:type" content="website" />
	


	
    <!-- Styles -->
	<link rel="stylesheet" href="{{ asset('assets/css/bootstrap.min.css') }}">	<link href="https://use.fontawesome.com/releases/v5.4.1/css/all.css" rel="stylesheet" type="text/css">
	<link rel="stylesheet" href="{{ asset('css/booth.css') }}">
	<link href="https://netdna.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.css" rel="stylesheet">
	<link href='https://fonts.googleapis.com/css?family=Inconsolata:400,700' rel='stylesheet' type='text/css'>

	<style>
	
		
	body{
		max-width: 630px;
		max-height: 100vh;
		margin: auto;
		
					background: #212529;
				
					background-image: url("{{ asset('storage/photobooth/father_day_background.jpg') }}");
			background-repeat: no-repeat;
			background-size: cover;
			 -webkit-background-size: cover;
			-moz-background-size: cover;
			-o-background-size: cover;
			background-position: 50% 50%;
								background: url("{{ asset('storage/photobooth/father_day_background.jpg') }}")  rgba(0, 0, 0, 0);
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
		</style>
		<script>
	dW=600;
	dH=600;
	site="stemx.com";
	</script>
	
	<!-- Global site tag (gtag.js) - Google Analytics -->
<script async src="https://www.googletagmanager.com/gtag/js?id=G-S63G7WH4Y8"></script>
<script>
  window.dataLayer = window.dataLayer || [];
  function gtag(){dataLayer.push(arguments);}
  gtag('js', new Date());

  gtag('config', 'G-S63G7WH4Y8');
</script>												 
</head>
<body>
    <div class="container pt-1 mx-auto" >
	
		<!--Photo-->
         <div class="flex justify-center">
				<div id="main" class="text-center">
				<input type="hidden" if="eventId" value="{{ $photo_info->event_id }}"/>
									<img id="p_imgss" style="max-width: 100%;" src="{{ URL::to('/') }}/{{ $photo_info->photo }}" data-highres="{{ URL::to('/') }}/{{ $photo_info->photo }}"style="height:600px;">
					
								</div>	
                <div class="buttons mt-1 mb-1" style="--tw-ring-shadow: 0 0 transparent;
			--tw-bg-opacity: 0.4;
			--tw-shadow: 0 1px 3px 0 rgba(0,0,0,0.1),0 1px 2px 0 rgba(0,0,0,0.06);
			width: 100%;
			user-select: none;
			border-radius: .75rem;
			background-color: rgba(0,0,0,var(--tw-bg-opacity));
			box-shadow: var(--tw-ring-offset-shadow,0 0 transparent),var(--tw-ring-shadow,0 0 transparent),var(--tw-shadow);"> 
						
					
					<a href="{{ URL::to('/') }}/booth/july4th"   id="back-button" class="button email pull-left" style="padding:0px;margin-right:40px;margin-bottom:0!important;">
						<span>
							<i class="fa fa-chevron-circle-left"></i>
						</span>
						
					</a>
										<a href="" class="button email" style="padding:0px;margin-right:40px;margin-bottom:0!important;" data-toggle="modal" data-target="#modalEmailForm" data-action="track" data-type="email">
						<span>
							<i class="fa fa-envelope"></i>
						</span>
						
					</a>
					<div class="result_share_buttons">
             <input type="hidden" id="sharer_name" value="">
             <input type="hidden" id="sharer_email" value="">
             
            <a class="resp-sharing-button__link fb" onclick='fbs_click()' target="_blank" rel="noopener" aria-label="Share on Facebook">
            <i class="fab fa-facebook-square"></i>
Facebook </a>
           
            <a class="twitter-share-button" href="https://twitter.com/share" data-size="small" data-url="{{ URL::to('/') }}/{{ $photo_info->photo }}" data-text="Hello" data-count="none" > Twitter</a>

         </div>	
															<a href="{{ URL::to('/') }}/gallery/july4th?fs=0" class="button gallery" style="padding:0px;margin-right:40px;margin-bottom:0!important;" target="blank" >
						<span>
							<i class="fa fa-th"></i>
						</span>					
					</a>	
															<a href="#" class="button download" style="padding:0px;margin-right:40px;margin-bottom:0!important;" >
						<span>
							<i class="fa fa-download"></i>
						</span>
						
					</a>
					                </div>
				
				 
					<div style="text-align:center;margin-top:0px;font-size:12px;width: 100vw;position: relative;left: calc(-50vw + 50%)!important;">
																		<a href="#" id="buy"><button class="button-cust-press btn-action buylink pl-2 pr-2"  data-content="Buy Prints" ><i class="fa fa-cart-plus"></i> Buy Prints</button></a>	
									</div>
												 
					<div style="text-align:center;margin-top:20px;font-size:12px;">
						<span style="color:#fff;">Powered by <a href="#" target="_new" style="color:#fff;text-decoration:underline;">Stemx</a>
					</div>
								
        </div>
		<!--End Photo-->

		<!--Email-->
		<div class="modal fade" id="modalEmailForm" tabindex="-1" role="dialog" aria-labelledby="myModalLabel"
		aria-hidden="true">
			<div class="modal-dialog" role="document">
				<div class="modal-content">
				  <div class="modal-header text-center">
					<h4 class="modal-title w-100 font-weight-bold">Email</h4>
					<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					  <span aria-hidden="true">&times;</span>
					</button>
				  </div> 
				  <form id="emailForm" action="/" method="post" onsubmit="return false;">
					  <div class="modal-body mx-3">
					<div class="md-form mb-5">
					  <i class="fa fa-envelope prefix grey-text"></i>
					  <input type="email" id="email" name="email" class="form-control">
					  <label data-error="wrong" data-success="right" for="email">Email</label>
					</div>
					
				  </div>
				  <input type="hidden" name="eventAction" value="boothEmail">
				  <input type="hidden" name="image" value="http://localhost/stemx/{{ $photo_info->photo }}">
				  <input type="hidden" name="mediaID" value="1LOP5bv6">
				  <input type="hidden" name="event-url" id="event-url" value="july4th">
				  <input type="hidden" name="status" id="status" value="0">
				  </form>
				  <div class="modal-footer d-flex justify-content-center">
					<button id="sendEmail" class="btn btn-primary">Send</button>
				  </div>
				</div>
			</div>
		</div>

		
    </div>


    <script src="{{ asset('assets/js/jquery.min.js') }}"></script>
	
    <script src="{{ asset('assets/js/popper.min.js') }}"></script>
    <script src="{{ asset('assets/js/bootstrap.min.js') }}"></script>
   
    <script src="{{ asset('js/jquery.ui.widget.js') }}"  type='text/javascript'> </script>
    <script src="{{ asset('js/jquery.iframe-transport.js') }}"  type='text/javascript'> </script>
    <script src="{{ asset('js/jquery.fileupload.js') }}"  type='text/javascript'> </script>
    <script src="{{ asset('js/jquery.cloudinary.js') }}"  type='text/javascript'> </script>
    <script src="{{ asset('js/photo.js') }}"  type='text/javascript'> </script>

    
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
	 var frame_id =$('#eventId').val();
      //alert('Twitter says your email is:' + data.email + ".\nView browser 'Console Log' for more details");
    //  alert("Tweet has been successfully posted");
     // show_toastr("Post", ' uploaded successfully.', "success");
      var type = 2;
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
		var frame_id =$('#eventId').val();


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
		   var frame_id =$('#eventId').val();

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
		<script>
		styleButtons("button-cust-press","#ffffff");
	</script>
<script>
$(document).ready(function(){	
	if(window !== window.parent){
		$("#back-button").hide();
	}						  
	$(".download").click(function(){
	  var link = document.createElement("a"); 
	  // Construct the URI 
	  link.href = "http://localhost/stemx/{{ $photo_info->photo }}"; 
	  document.body.appendChild(link);  
	  setTimeout(function() { 
		   link.click();  
		   // Cleanup the DOM 
		   document.body.removeChild(link); 
		 //  DOWNLOAD_COMPLETED = true; 
	   }, 500); 
	})
})
</script>
 	  
	   		<script src="https://cdnjs.cloudflare.com/ajax/libs/three.js/r77/three.min.js"></script>
			   <script src="{{ asset('js/fireworks2.js') }}"  type='text/javascript'> </script>
               <script type="text/javascript" src="//widget.fotomoto.com/stores/script/e64011c4171d6d0ddda6979d5c772984ea1233b7.js"></script>
<noscript>If Javascript is disabled in your browser, to place orders please visit the page where I <a href="https://my.fotomoto.com/store/e64011c4171d6d0ddda6979d5c772984ea1233b7">sell my photos</a>, powered by <a href="https://my.fotomoto.com/">Fotomoto</a>.</noscript>
  
<script>

  // Once the Fotomoto Script is loaded, we get the images on the page
    function fotomoto_loaded() {
      // Store ID - get this on the Settings page of the Fotomoto Dashboard for this site.
      let storeID = "e64011c4171d6d0ddda6979d5c772984ea1233b7";
      
      //let buyLinks = document.querySelectorAll('.buylink');
      let url = "https://widget.fotomoto.com/stores/photo_checkin";

    //  buyLinks.forEach(function(buylink) {
        // Set an empty array for images to go in to
        let images = [];

        // Get the URL of the image associated with this Buy link
        let webImage = $('#p_imgss').attr('src');
        let webHighRes = $('#p_imgss').attr('data-highres');
		
        // Add the image for this buy link to images array
        images.push({
          img: webImage,
          original_image_url: webHighRes,
          collection: ''
        });
 
        // Call the checkinImage function to check the image in to the Fotomoto Dashboard if it hasn't already been checked in. Note this function can also be used to pass in the URL of an associated high res image (and more). See the function reference page.
        FOTOMOTO.API.checkinImages(images, function(images) {

          // The collectionProductsOffered function returns a boolean indicating whether or not Fotomoto products are enabled on the Collection that the image is in.
          var productsOffered = FOTOMOTO.API.collectionProductsOffered(images[0].collection);
         // console.log(images);

          // If the image is available for sale, display the Buy Button
          if(productsOffered) {
            // console.log(webImage+" is available");
            // $('.buylink').css('display', "block");
          }
          else {
            console.log(webImage+" is not available for sale because it is either in the Not for Sale Collection or it is in Removed");
          }
        });

        // When the Buy Button is clicked, open the desired screen of the Fotomoto Widget. In this case FOTOMOTO.API.BUY will open the Print window if prints are available, otherwise it will open the next available product window
        $('.buylink').on('click', function() {
          FOTOMOTO.API.showWindow(FOTOMOTO.API.BUY, webImage);
        })
   //   });
    }
  </script>
	</body>
</html>