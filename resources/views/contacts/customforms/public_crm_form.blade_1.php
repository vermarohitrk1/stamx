
<!DOCTYPE html>
<html>
<head><meta http-equiv="Content-Type" content="text/html; charset=utf-8">

@php
        $meta_data = \App\WebsiteSetting::WebsiteSetting('meta_data');

        if(!empty($meta_data->value)){
        $meta_data  = json_decode($meta_data->value,true);
        }else{
        $meta_data = array();
        }

        $logo =  \App\User::WebsiteSetting();

        if(!empty($logo)){
           $logo_favicon = json_decode($logo->value,true);
        }else{
            $logo_favicon = array();
        }

        $logo_text =  \App\User::WebsiteTextLogo();
    @endphp
    @if (!empty($logo_favicon['favicon']))
        <link rel="shortcut icon" href="{{ asset('storage/logo/'.$logo_favicon['favicon'])}}" type="image/x-icon">
        <link rel="icon" href="{{ asset('storage/logo/'.$logo_favicon['favicon'])}}" type="image/x-icon">
    @endif
    <title>@yield('title') &mdash;
        @if(!empty($meta_data['meta_title'])) {{$meta_data['meta_title']}}   &mdash; @endif  {{(Utility::getValByName('header_text')) ? Utility::getValByName('header_text') : config('app.name') }}</title>
    <link href="{{url('/public/public-page/style2.css')}}" rel="stylesheet">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css">
    <link href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet" integrity="sha384-wvfXpqpZZVQGK6TAh5PVlGOfQNHSoD2xbE+QkPxCAFlNEevoEH3Sl0sibVcOQVnN" crossorigin="anonymous">

<!-- Contact us -->

<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/12.1.3/css/intlTelInput.css" />
<link href="{{url('/public/public-page/simcify.min.css')}}" rel="stylesheet">
<link href="{{url('/public/public-page/style.css')}}" rel="stylesheet" type="text/css" />
<style>
.logos {
 
    margin-bottom: 0 !important;
   
}
p.p_radio {
 
    margin: auto;
}
.right-form {
   box-shadow: rgba(0, 0, 0, 0.08) 0px 2px 4px 0px, rgba(0, 0, 0, 0.1) 0px 11px 41px 8px;
    border-radius: 2px;
	    width: 100% !important;
		padding-left: 2rem;
    padding-right: 2rem;
    padding-top: 1rem;
    padding-bottom: 1rem;
}

.butn {
    padding: .5rem 1rem !important;
    font-size: 1.25rem !important;
    line-height: 1.5 !important;
    border-radius: .3rem !important;
}
.right-form ul {
   
    padding-left: 0 !important;
}
</style>
<style>
.main-class {
	background-image: url("#");
	background-size: cover;
	background-repeat: no-repeat;
	background-position: center center;
	background-attachment: fixed;
	position: relative;
	float: left;
	width: 100%;
	}
</style>
</head>
<body>
	<section class="main-class">
		<div class="#svg-fill">
			<div class="logos">
		<div class="top-logo">
		
		</div>
		
	</div>
     <div class="container">
		<div class="row">
			<div class="col-sm-2">			


			</div>
			<div class="col-sm-8">
				<div class="right-form">
                                    <h3 class="text-center centered">{{ucfirst($form->title)}}</h3>
                                    
					<form class="contact-us" action="{{url('/lead/insert/')}}" data-parsley-validate="" loader="true" method="POST" enctype="multipart/form-data" novalidate="">
						 <input type="hidden" name="_token" value="<?=csrf_token();?>" />
						<ul>
							<li>
								<div class="label">
						            <label>First Name</label>
					            </div>
					            <div class="form-input">
									<input type="text" name="fname" value="" class="form-control" placeholder="First Name" required="" >
								</div>
                            </li>
                            <li>
                            	<div class="label">
			                        <label>Last Name</label>
			                    </div>
			                    <div class="form-input">
			                        <input type="text" name="lname" value="" class="form-control" placeholder="Last Name" required="">
			                    </div>
                    </li>
                    <li>
                    	<div class="label">
	                    	<label>Email Address</label>
	                    </div>
	                    <div class="form-input">
	                    	<input type="email" name="email" value="" class="form-control" placeholder="Email Address"  required="">
	                    </div>
                    </li>
                    <li>
                    	<div class="label">
                    	<label>Phone</label>
                    </div>
                    <div class="form-input">
                    	<input type="number" name="phone" value="" class="form-control" placeholder="Phone" required="">
                    </div>
                    </li>
                    <div class="form-group">
                        <div class="label">
                    <label for="traffic_sources" class=" font-weight-bold">Types of traffic sources used to generate traffic - please select all applicable</label>                  </div>       
          <div class="row no-gutters">
                          <div class="col-sm-4">
                <ul class="list-unstyled mb-0">
                                      <li><label><input name="traffic_sources[]" type="checkbox" value="Display"> Display</label></li>
                                      <li><label><input name="traffic_sources[]" type="checkbox" value="Affiliate"> Affiliate</label></li>
                                      <li><label><input name="traffic_sources[]" type="checkbox" value="Social"> Social</label></li>
                                  </ul>
              </div>
                          <div class="col-sm-4">
                <ul class="list-unstyled mb-0">
                                      <li><label><input name="traffic_sources[]" type="checkbox" value="Paid Search"> Paid Search</label></li>
                                      <li><label><input name="traffic_sources[]" type="checkbox" value="Mobile"> Mobile</label></li>
                                      <li><label><input name="traffic_sources[]" type="checkbox" value="Call Center"> Call Center</label></li>
                                  </ul>
              </div>
                          <div class="col-sm-4">
                <ul class="list-unstyled mb-0">
                                      <li><label><input name="traffic_sources[]" type="checkbox" value="Organic Search"> Organic Search</label></li>
                                      <li><label><input name="traffic_sources[]" type="checkbox" value="Email"> Email</label></li>
                                  </ul>
              </div>
                      </div>
        </div>
                    <li>
                    	<div class="label">
	                    <label for="yes_no_radio">Would you like to receive updates via SMS ?</label>
	                </div>
	                    <p class="p_radio">
						<input type="radio" value="Yes" name="sms" required="" checked>Yes
					</p>
					<p>
						<input type="radio" value="No" name="sms" required="" >No
					</p>
					</li>
					<li>
						<p class="form-p">{{$form->description}}</p>
					</li>
					<li>
					<input type="checkbox" name="i_agree" value="1" required="" > I understand & agree
					</li>
					<li>
						<button class="butn">Submit Form 
						<a href=""><i class="fa fa-arrow-circle-right" aria-hidden="true"></i></a></button>
					</li>
				</ul>
					</form>
				</div>
			</div>
                    <div class="col-sm-2">			


			</div>
		</div>
	  </div>
	</section>
	<footer class="footer">
		<div class="footer-class">
		
		
            <p class="copyright"> © Copyright {{date('Y')}} | MyCEO® </p>
            
		
		</div>
	</footer>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js">
</script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js"></script>


<!-- contact us -->
<script src="{{url('/public/public-page/bootstrap.min.js')}}"></script>
<script src="{{url('/public/public-page/simcify.min.js')}}"></script>
<script src="{{url('/public/public-page/blackdollar.js')}}" type="text/javascript"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/12.1.3/js/intlTelInput.min.js"></script>
<script>
@if(Session::has('success'))
 toastr.success("{{ Session::get('success') }}", "Done!", {timeOut: null, closeButton: true});
@endif
@if(Session::has('error'))
 toastr.error("{{ Session::get('error') }}", "Oops!", {timeOut: null, closeButton: true});
@endif

  
</script>


</body>
</html>
