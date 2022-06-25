<link rel="icon" type="image/png" sizes="16x16" href="{{asset('public/public-page/KmiU0OY1hoopxKxTVmmEhhiNOPlmW7eh.png')}}">
    <!-- <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css"> -->
    <link href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet" integrity="sha384-wvfXpqpZZVQGK6TAh5PVlGOfQNHSoD2xbE+QkPxCAFlNEevoEH3Sl0sibVcOQVnN" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css" integrity="sha512-vKMx8UnXk60zUwyUnUPM3HbQo8QfmNx7+ltw8Pm5zLusl1XIfwcxo8DbWCqMGKaWeNxWA8yrx5v3SaVpMvR3CA==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <!-- Contact us -->

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/12.1.3/css/intlTelInput.css" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/limonte-sweetalert2/7.2.0/sweetalert2.min.css">
    <link href="{{asset('public/assets/css/donation_public.css')}}" rel="stylesheet" type="text/css" />
    <style>
      .logos{margin-bottom:0!important}p.p_radio{margin:auto}.right-form{box-shadow:rgba(0,0,0,.08) 0 2px 4px 0,rgba(0,0,0,.1) 0 11px 41px 8px;border-radius:2px;width:100%;padding-left:2rem;padding-right:2rem;padding-top:1rem;padding-bottom:1rem}.butn{padding:.5rem 1rem!important;font-size:1.25rem!important;line-height:1.5!important;border-radius:.3rem!important}.right-form ul{padding-left:0!important}.donationform li{display:inline-block;width:32%;text-align:center}.donationform li label{background:orange;display:block;color:#fff;font-size:20px;font-weight:500;border-radius:13px;padding:5px 0}.donationform input[type=radio]:checked+label{background:0 0;display:block;color:#000;font-size:20px;font-weight:500;padding:5px 0}.donationform input[type=radio]{display:none}.donation-level-user-entered input[type=text]{width:95%;padding:5px;margin-left:2%;border:2px solid;border-radius:3px}h4.monthly{margin-top:20px}form h4{margin-top:20px}form input[type=text]{width:100%;padding:5px;margin-left:0;border:2px solid;border-radius:3px;margin-top:10px}.cc_form select{width:32%;margin-top:10px;border:2px solid;border-radius:3px;padding:5px}#responsive_payment_typecc_cvvname{width:33%}#billing_addr_cityname,#billing_addr_country,#billing_first_namename{width:49%;float:left;clear:both}#billing_addr_state,#billing_addr_zipname,#billing_last_namename{width:49%;float:right}button.step-button{background:#ffb81c;color:#fff;border:0;font-size:20px;font-weight:700;padding:10px;border-radius:30px}.footer-navigation{display:flex}.footer-nav a{display:block}.footer-nav{width:50%}.copyright{font-size:16px;text-align:center}#error-message{margin:0 0 10px 0;padding:5px 25px;border-radius:4px;line-height:25px;font-size:.9em;color:#ca3e3e;border:#ca3e3e 1px solid;display:none;width:300px}
    </style>
       <style>
           .btn-primary {
    background-color: #009DA6!important;
    border: 1px solid #009DA6!important;
}
        .main-class {
            @if(!empty($detail->bgimage))
                    background-image: url("{{url('storage/details/'.$detail->bgimage)}}");
            @endif
            background-size: cover;
            background-repeat: no-repeat;
            background-position: center center;
            background-attachment: fixed;
            position: relative;
            float: left;
            width: 100%;
        }
    </style>
<div class="row mt-3" id="blog_view">
     <div class="col-12">
        <div class="card">
            <div class="card-body">
   
   
            <form id="frmStripePayment" action="" method="POST">
                            <input type="hidden" name="_token" value="<?=csrf_token();?>" />
                            <input type="hidden" name="program_id" value="{{ $id }}" />
                            <input type="hidden" name="address" value="{{ Auth::user()->address }}" />
                            <input type="hidden" name="city" value="{{ Auth::user()->city }}" />
                            <input type="hidden" name="state" value="{{ Auth::user()->state }}" />
                            <input type="hidden" name="country" value="{{ Auth::user()->country }}" />
                            <input type="hidden" name="zip" value="{{ Auth::user()->postal_code}}" />
                            <div class="donation-level-user-entered">

                                <input type="hidden" maxlength="20" class="numbers amount" placeholder="Enter Amount" id="amount" name="amount" value="{{ \App\Audit::find(1)->price }}">
                            </div>
                           
                          
                           

                            <div class="cc_form">
                                <h3>Credit Card Information</h3>
                                <table class="payment-type-cc">
                                    <tbody><tr>
                                        <td>
                                            <table class="payment-type-cc">
                                                <tbody><tr>
                                                    <td style="padding-right:5px;">
                                                        <img style="height: 25px;" src="{{asset('public/img/mastercard_small.png')}}" alt="MasterCard" border="0">
                                                    </td><td style="padding-right:5px;">
                                                        <img style="height: 25px;" src="{{asset('public/img/visa_small.png')}}" alt="Visa" border="0">
                                                    </td>
                                                    <td style="padding-right:5px;">
                                                        <img style="height: 25px;" src="{{asset('public/img/amex_smallsc.png')}}" alt="American Express" border="0">
                                                    </td>
                                                    <td>
                                                        <img style="height: 25px;" src="{{asset('public/img/discovercard_sm.png')}}" alt="Discover" border="0">
                                                    </td>
                                                </tr>
                                                </tbody></table>

                                        </td>
                                    </tr>
                                    </tbody></table>
                                <input type='text' class="numbers" name="card-number" maxlength="16" id="card-number" placeholder="Credit Card Number" />

                                <select name="responsive_payment_typecc_exp_date_MONTH" id="responsive_payment_typecc_exp_date_MONTH" placeholder="Expiration Date:Select month of credit card">
                                    <option value="1" @if(date('m') =="01") selected="selected" @endif>01</option>
                                    <option value="2"  @if(date('m') =="02") selected="selected" @endif>02</option>
                                    <option value="3"  @if(date('m') =="03") selected="selected" @endif>03</option>
                                    <option value="4"  @if(date('m') =="04") selected="selected" @endif>04</option>
                                    <option value="5"  @if(date('m') =="05") selected="selected" @endif>05</option>
                                    <option value="6"  @if(date('m') =="06") selected="selected" @endif >06</option>
                                    <option value="7"  @if(date('m') =="07") selected="selected" @endif>07</option>
                                    <option value="8"  @if(date('m') =="08") selected="selected" @endif>08</option>
                                    <option value="9"  @if(date('m') =="09") selected="selected" @endif>09</option>
                                    <option value="10"  @if(date('m') =="10") selected="selected" @endif>10</option>
                                    <option value="11"  @if(date('m') =="11") selected="selected" @endif>11</option>
                                    <option value="12"  @if(date('m') =="12") selected="selected" @endif>12</option>
                                </select>

                                <select name="responsive_payment_typecc_exp_date_YEAR" id="responsive_payment_typecc_exp_date_YEAR" placeholder="Select Expiration Year">
                                    @for ($i = date('Y'); $i <= date('Y')+20; $i++) {
                                    <option @if($i == date('Y')) selected="selected" @endif value="{{$i}}">{{$i}}</option>
                                    @endfor
                                </select>
                                <input type="text" name="responsive_payment_typecc_cvvname" id="responsive_payment_typecc_cvvname" value="" maxlength="4" autocomplete="off" placeholder="CVV Number">

                       <label style="margin-top:30px;" class="w-auto">
                           
                                <p style="text-align:center;">
                                    <button class="step-button action-button finish-step btnAction px-5" type="button" id="submit-btn" name="pay_now" value="Give Now" onClick="stripePay(event);">Pay with USD {{ number_format(\App\Audit::find(1)->price,2) }}</button>

                                </p>
                         
                                
                            </div>
                        </form>

            </div>
        </div>
    </div>
</div>

  	
<script src="https://cdnjs.cloudflare.com/ajax/libs/limonte-sweetalert2/7.2.0/sweetalert2.all.min.js"></script>

<script>

        Stripe.setPublishableKey('{{$payment['STRIPE_KEY']}}');

    function cardValidation () {

        var valid = true;
        var name = "{{ Auth::user()->name}}";
       
        var email ="{{ Auth::user()->email}}";
        var cardNumber = $('#card-number').val();
        var month = $('#responsive_payment_typecc_exp_date_MONTH').val();
        var year = $('#responsive_payment_typecc_exp_date_YEAR').val();
        var cvc = $('#responsive_payment_typecc_cvvname').val();
        var address = "{{ Auth::user()->address1}}";
        var city = "{{ Auth::user()->city}}";
        var state = "{{ Auth::user()->state}}";
        var country =  "{{ Auth::user()->country}}";
        var zip =  "{{ Auth::user()->postal_code}}";

        $("#error-message").html("").hide();

        if (cardNumber.trim() == "") {
            valid = false;
        }

        if (month.trim() == "") {
            valid = false;
        }
        if (year.trim() == "") {
            valid = false;
        }
        if (cvc.trim() == "") {
            valid = false;
        }

        if(valid == false) {
            toastr.clear();
            toastr.error("All Fields are required", "Oops!", {
                closeButton: true
            });
        }
        return valid;
    }


    //callback to handle the response from stripe
    function stripeResponseHandler(status, response) {

        if (response.error) {
            //enable the submit button
            $("#submit-btn").show();
            //display the errors on the form
            toastr.clear();
            toastr.error(response.error.message, "Oops!", {
                closeButton: true
            });
            return false;
        } else {
            //get token id
            var token = response['id'];
            //insert the token into the form
            $("#frmStripePayment").append("<input type='hidden' name='token' value='" + token + "' />");
            //submit form to the server

            var data=$('#frmStripePayment').serialize()+'';
            $(function() {
                $.ajax({
                    type: "POST",
                    url: "{{url('/pay/insert')}}",
                    data: data,
                    success: function(data){
                        //alert(data.success);
                        if(data.success == true){
                            swal({
                                title: "Alright!",
                                text: data.message,
                                showCancelButton: false,
                                type: "success"
                            }).then(function() {
                                window.location.reload();
                            });

                        }else{
                            console.log(data);
                            swal({
                                title: "Oops!",
                                text: data.message,
                                type: "error",
                                showCancelButton: false
                            });
                        }
                    }
                });
            });
            //$("#frmStripePayment").submit();

        }
    }
    function stripePay(e) {
        e.preventDefault();
        var valid = cardValidation();

        if(valid == true) {
            
            <!-- $("#submit-btn").hide(); -->
            Stripe.createToken({
                number: $('#card-number').val(),
                cvc: $('#responsive_payment_typecc_cvvname').val(),
                exp_month: $('#responsive_payment_typecc_exp_date_MONTH').val(),
                exp_year: $('#responsive_payment_typecc_exp_date_YEAR').val()
            }, stripeResponseHandler);

            //submit from callback
            return false;
        }
    }
    $(document).ready(function () {
        //called when key is pressed in textbox
        $(".numbers").keypress(function (e) {
            //if the letter is not digit then display error and don't type anything
            if (e.which != 8 && e.which != 0 && (e.which < 48 || e.which > 57)) {
                //display error message
                // $("#errmsg").html("Digits Only").show().fadeOut("slow");
                return false;
            }
        });

    });
</script>
<script>

    $(".phone-input").intlTelInput({

        autoPlaceholder: "polite",

        placeholderNumberType: "FIXED_LINE",

        utilsScript: "https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/12.1.3/js/utils.js"

    });
    $(".phone-input").blur(function() {
        if ($.trim($(this).val())) {
            if (!$(this).intlTelInput("isValidNumber")) {
                $(this).val('');
                toastr.error("Invalid phone number.", "Oops!", {timeOut: null, closeButton: true});
            }else{
                toastr.clear();
            }
        }
    })
    $(".phone-input").change(function(){
        $(this).closest(".intl-tel-input").siblings(".hidden-phone").val($(this).intlTelInput("getNumber"));
    });
    $("#amount").click(function(){
        $('.hidecheckbox').prop('checked', false);
    });
    function valueremove(val){
        if ($('.hidecheckbox').is(":checked")){
            $('#amount').val('');
        }
    }


    $( ".donation_sec" ).click(function() {
        var text = $( this ).val();

        $( ".amount" ).val( text );
    });
</script>
