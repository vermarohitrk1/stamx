
@extends('layout.mainlayout')
@section('content')		
<!-- Page Content -->
@php
    $mainMenu = \App\Menu::get_menus();
     $logo =  \App\SiteSettings::logoSetting();
$logoTxt=\App\SiteSettings::logotext();
        if(!empty($logo)){
           $logo_favicon = json_decode($logo->value,true);
        }else{
            $logo_favicon = array();
        }
      
@endphp
<style>
.intl-tel-input {
    width: 100%;
}
.form-group.phone_blk label {
    display: block;
}
.bg-pattern-style.bg-pattern-style-register {
    height: auto !important;
}
</style>
@if( array_key_exists("registerationbackground",$logo_favicon))
<div class="bg-pattern-style bg-pattern-style-register" style="background-image:url({{ asset('storage').'/logo/'.$logo_favicon['registerationbackground'] }})">
     @else
     <div class="bg-pattern-style bg-pattern-style-register" style="background-image:url({{ URL::to('/') }}storage/logo/registerationbackground611e53ec81936.png)">

     @endif                     
    <div class="content">
        @php
        $domain_roles=get_domain_roles();
        @endphp

        <!-- Register Content -->
        <div class="account-content">
            <div class="account-box">
                <div class="login-right">
                    <div class="login-header">
                        <h3><span>{{(!empty($domain_roles) && sizeof($domain_roles)==1) ? $domain_roles[0]:(!empty($domain_roles) ? "Mentoring" :'Admin')}}</span> Register</h3>
                        <p class="text-muted">Access to our dashboard</p>
                    </div>

                    <!-- Register Form -->
                    <form id="register" method="POST" action="{{ route('register') }}">
                        @csrf
                        <div class="form-group">
                            <label class="form-control-label">Name</label>
                             <input id="name" type="text" class="form-control @error('name') is-invalid @enderror" name="name" value="{{ old('name') }}" required autocomplete="name" autofocus>

                                @error('name')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                        </div>
                        <div class="form-group">
                            <label class="form-control-label">Email Address</label>
                            <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email">

                                @error('email')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                        </div>
						  <div class="form-group phone_blk">
                            <label class="form-control-label">Mobile Number</label>
                                <input type="text" id="phone" class="form-control phone-input required" value="" name="temp-phone"  required>
							   </div>
                        <div class="row">
                            <div class="col-lg-6">
                                <div class="form-group">
                                    <label class="form-control-label">Password</label>
                                     <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="new-password">

                                @error('password')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="form-group">
                                    <label class="form-control-label">Confirm Password</label>
                                    <input id="password-confirm" type="password" class="form-control" name="password_confirmation">
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                           
                            <input  type="hidden" name="role" value="mentee">
                           
                        </div>
                        <div class="form-group">
                            <div class="custom-control custom-control-xs custom-checkbox">
                                <input type="checkbox" class="custom-control-input" name="agreeCheckboxUser" id="agree_checkbox_user" required="">
                                <label class="custom-control-label" for="agree_checkbox_user">I agree to Mentoring</label> <a tabindex="-1" href="javascript:void(0);">Privacy Policy</a> &amp; <a tabindex="-1" href="javascript:void(0);"> Terms.</a>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="custom-control custom-control-xs custom-checkbox">
                                <input type="checkbox" class="custom-control-input" name="volunteer" id="volunteer">
                                <label class="custom-control-label" for="volunteer">Would You Like to be Notified of  Volunteer Opportunities?</label>
                            </div>
                        </div>
                        <!-- <button class="btn btn-primary login-btn 'g-recaptcha" type="submit" data-sitekey="6LcGnBwcAAAAAHY2J4EwqpoYLAODaUnKioLdxmrz" data-callback='onSubmit' data-action='submit'>Create Account</button> -->
                        <button class="btn-primary login-btn " 
        data-sitekey="6LcGnBwcAAAAAHY2J4EwqpoYLAODaUnKioLdxmrz" 
        data-callback='onSubmit' 
        data-action='submit'>Create Account</button>
                        <div class="account-footer text-center mt-3">
                            Already have an account? <a class="forgot-link mb-0" href="login">Login</a>
                        </div>
                    </form>
                    <!-- /Register Form -->

                </div>
            </div>
        </div>
        <!-- /Register Content -->

    </div>

</div>		
<!-- /Page Content -->

@endsection
@push('script')
    <link rel="stylesheet" type="text/css" href="{{ asset('public/toastr/build/toastr.min.css')}}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/12.1.3/css/intlTelInput.css" /> 	
<script src="https://www.google.com/recaptcha/api.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/12.1.3/js/intlTelInput.min.js"></script>

<script src="{{ asset('public/toastr/build/toastr.min.js')}}"></script>

@if(Session::has('success'))
    <script>
        show_toastr('{{__('Success')}}', "{!! session('success') !!}", 'success');
    </script>
    {{ Session::forget('success') }}
@endif
@if(Session::has('error'))
    <script>
        show_toastr('{{__('Error')}}', "{!! session('error') !!}", 'error');
    </script>
    {{ Session::forget('error') }}
@endif
<script>
$(".phoneValid").keyup(function(){
var mobile = '';
var phoneNumber = $(this).val();
var numLength = phoneNumber.length;
numLength = numLength - 1;
for (var i = 0; i <= numLength; i++){
var charData = phoneNumber.charAt(i);
if (charData == '+' || charData == 1 || charData == 2 || charData == 3 || charData == 4 || charData == 5 || charData == 6 || charData == 7 || charData == 8 || charData == 9 || charData == 0){
mobile = mobile + charData;
}
}
$(".phoneValid").val(mobile);
});
$( document ).ready(function() {


 $(".phone-input").length && $(".phone-input").intlTelInput({
       
        autoHideDialCode: false,
      autoPlaceholder: "on",
      dropdownContainer: "body",
     
      formatOnDisplay: false,
      geoIpLookup: function(callback) {
        $.get("http://ipinfo.io", function() {}, "jsonp").always(function(resp) {
          var countryCode = (resp && resp.country) ? resp.country : "";
          callback(countryCode);
        });
      },
      hiddenInput: "phone",
      initialCountry: "us",
      nationalMode: false,
      //onlyCountries: ['us', 'gb', 'ch', 'ca', 'do'],
      placeholderNumberType: "MOBILE",
      preferredCountries: ['us'],
      separateDialCode: true,
        utilsScript: "https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/12.1.3/js/utils.js"
    });
    
    $(".phone-input").blur(function () {
        $.trim($(this).val()) && ($(this).intlTelInput("isValidNumber") ? toastr.clear() : ($(this).val(""), toastr.error("Invalid phone number.", "Oops!", {
            timeOut: null,
            closeButton: !0
        })))
    });
    $(".phone-input").change(function () {
	
		  $('input[name="phone"]').val($(this).intlTelInput("getNumber"));
        $(this).closest(".intl-tel-input").siblings("input[name='phone']").val($(this).intlTelInput("getNumber"));
        
    });
	});
function onSubmit(token) {
   
     document.getElementById("register").submit();
   }
   
   
   </script>
@endpush