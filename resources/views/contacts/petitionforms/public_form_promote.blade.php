<?php $page = "Petition"; ?>
@extends('layout.commonlayout')
@section('content')	
   @php
                                 $stripe_settings=\App\SiteSettings::getValByName('payment_settings');
                        
                                 @endphp
<!-- Breadcrumb -->
<div class="breadcrumb-bar">
    <div class="container-fluid">
        <div class="row align-items-center">
            <div class="col-md-12 col-12">
                <nav aria-label="breadcrumb" class="page-breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{route('dashboard')}}">Home</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Petition</li>
                    </ol>
                </nav>
            </div>
        </div>
    </div>
</div>
<!-- /Breadcrumb -->

<!-- Page Content -->
<div class="content">
    <div class="container-fluid">

        <div class=" row centered align-items-center text-center  align-self-center  put-center d-flex justify-content-center">
            <div class="col-lg-8 col-md-12  ">
                <div class="blog-view   ">
                    <div class="blog blog-single-post ">
                      
                        
                        <div class="blog-image">
                            <a href="#">
                                          @if(file_exists( storage_path().'/petition/'.$row->image ) && !empty($row->image))
                                        <img src="{{asset('storage')}}/petition/{{ $row->image }}" height="800px" width="1200px" class="img-fluid" alt="...">
                                        @else
                                        <img class="img-fluid" src="{{ asset('assets/img/blog/blog-02.jpg') }}" alt="">
                                        @endif
                                        
                                    </a>
                        </div>
                        @if(!empty(Auth::user()->name))
                          <h3 class="blog-title">You are a hero, {{Auth::user()->name}}! Chip in what you can:</h3>
                          @else
<h3 class="blog-title">You are a hero! Chip in what you can:</h3>
@endif
                        <div class="blog-content">
                        
                        <form >
                        <div class="row text-center mt-5 mb-5">
<div class="form-group col-md-4  mb-3">
                   <input type="button"  onclick="setvalue(10)" class="form-control form-control-flush text-center " value="$10" placeholder="$10">
                        </div>
<div class="form-group col-md-4  mb-3">
                          <input type="button"  onclick="setvalue(20)" class="form-control form-control-flush text-center" value="$20" placeholder="$20">
                        </div>
<div class="form-group col-md-4  mb-3">
                          <input type="button"  onclick="setvalue(50)" class="form-control form-control-flush text-center" value="$50" placeholder="$50">
                        </div>
<div class="form-group col-md-4  mb-3">
                          <input type="button" onclick="setvalue(100)" class="form-control form-control-flush text-center" value="$100" placeholder="$100">
                        </div>
                        <div class="form-group col-md-8  mb-3">
                           <div class="input-group input-group-sm input-group-merge input-group-flush">
            <div class="input-group-prepend">
                <span class="input-group-text bg-transparent"><i class="fas fa-dollar-sign"></i></span>
            </div>
                               <input required="" type="number" id="amountnumber" min="1" step="1" class="form-control form-control-flush text-center text-lg" placeholder="{{__('Enter Amount $')}}">
        </div>
                        </div>
                        
                            
                        </div>
                                                   
                      
                           <p><strong>Help this petition reach its signature goal! </strong> Every $1 will advertise this petition to more viewers on social media.</p>
                             <hr>
                             @if((!empty($stripe_settings['ENABLE_STRIPE']) && $stripe_settings['ENABLE_STRIPE'] == 'on') && !empty($stripe_settings['STRIPE_KEY']) && !empty($stripe_settings['STRIPE_SECRET']))
                									
                									<a href="javascript:void(0);" id="PaymentMode" style="width: -webkit-fill-available;font-size: x-large !important;" class="btn  btn-primary btn-rounded " >CHIP IN</a>
                                                                                       @else
                                                                                        <a href="javascript:void(0);" class="btn btn-lg btn-warning btn-rounded " >Stripe Disabled</a>
                                                                                        @endif
                									
                		</form>							
                        </div>
                        
                    </div>
  
<!--                    <div class="card blog-share clearfix">
                        <div class="card-header">
                            <h3 class="card-title">Share Petition</h3>
                        </div>
                        <div class="card-body">
                           <div class="icons">
                            <div id="share"></div>
                        </div>
                        </div>
                    </div>-->
                    
                    
                    

                </div>
            </div>

                
            </div>
            <!-- /Blog Sidebar -->

        </div>
    </div>

</div>		
<!-- /Page Content -->
@endsection

@push('script')
<div class="modal fade" id="modeModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
     aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Payment mode</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
              <div class="row">
			  <div class="col-md-12 wallet_b">@if(!empty($CompanyWallet)) ${{$CompanyWallet->balance}} @else $0 @endif <span>Wallet Blance</span></div>
			  </div>
			    <div class="row">
				<div class="col-md-12 mode_b">
                <button type="button" class="btn btn-primary btn-sm pay_Using_Wallet modeType"  data-type="petition"
                                            data-id="{{$row->id}}"
                                            price=""
                                            data-price=""
                                            id="makeenrollwallet"  data-dismiss="modal">Pay using wallet </button>


                <button type="button" class="btn btn-primary btn-sm"  data-type="petition"
                                            data-id="{{$row->id}}"
                                            price=""
                                            data-price=""
                                            id="makeenroll"  data-dismiss="modal">Pay using stripe</button>
            </div>
            </div>
            </div>
            <div class="modal-footer">

            </div>

        </div>
    </div>
</div>
<div class="modal fade" id="myModal_payment" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
     aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <div class="row display-tr">
                    <h5 class="panel-title display-td"><b>Payment Details</b></h5>
                    <div class="display-td">

                    </div>
                </div>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form role="form" action="{{ route('stripe.petition.donation')}}" method="post" class="require-validation"
                      data-cc-on-file="false"
                      data-stripe-publishable-key="{{$stripe_settings['STRIPE_KEY']??''}}"
                      id="payment-form">
                    {{ csrf_field() }}
                    <input type="hidden" name="itemPrice" id="itemPrice" value="">
                    <input type="hidden" name="itemId" id="itemId" value="">
                    <input type="hidden" name="itemType" id="itemType" value="">
                    <div class='form-row row'>
                        <div class='col-xs-12 form-group required'>
                            <label class='control-label'>Name on Card</label> <input
                                class='form-control' size='80' type='text' required>
                        </div>
                    </div>
                    <div class='form-row row'>
                        <div class='col-xs-12 form-group card required'>
                            <label class='control-label'>Card Number</label>
                            <input autocomplete='off' class='form-control card-number' style="width: 467px;" size='16'
                                   min="16" type='number'>
                        </div>
                    </div>
                    <div class='form-row row'>
                        <div class='col-xs-12 col-md-4 form-group cvc required'>
                            <label class='control-label'>CVC</label>
                            <input autocomplete='off' class='form-control card-cvc' placeholder='ex. 311' size='4' type='number' required="">
                        </div>
                        <div class='col-xs-12 col-md-4 form-group expiration required'>
                            <label class='control-label'>Expiration Month</label> <input
                                class='form-control card-expiry-month' placeholder='MM' size='2'
                                type='number'>
                        </div>
                        <div class='col-xs-12 col-md-4 form-group expiration required'>
                            <label class='control-label'>Expiration Year</label> <input
                                class='form-control card-expiry-year' placeholder='YYYY' size='4'
                                type='number'>
                        </div>
                    </div>
                
                    <div class='form-row row'>
                        <div class='col-md-12 error form-group hide'>
                            <div class='alert-danger alert'>Please correct the errors and try
                                again.
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-xs-12 buttonCustom w-100 ctm_payment">
                            <button class="btn btn-primary btn-lg btn-block" id="customer_payment" type="submit">Pay Now
                                ($100)
                            </button>
                        </div>
                    </div>
                </form>
            </div>

        </div>
    </div>
</div>
<script>
function setvalue(val){
    $("#amountnumber").val(val);
}
$("#PaymentMode1").click(function () {
    var valu=$("#amountnumber").val();
    if(valu=="" || valu==0){
        show_toastr("Warning","Enter Chip Amount","error");
    }else{
        $("#modeModal").modal('show');
        $("#makeenroll").attr({
    "price" : $("#amountnumber").val(),
    "data-price" : "$"+$("#amountnumber").val()
  });
        $("#makeenrollwallet").attr({
    "price" : $("#amountnumber").val(),
    "data-price" : "$"+$("#amountnumber").val()
  });
    }
    });
</script>

<script type="text/javascript" src="https://js.stripe.com/v2/"></script>
<script type="text/javascript">
$(document).ready(function(){
    $(".card-number").keyup(function () {
	
		
        var cardNumber = $(this).val();
        if (cardNumber.length > 16) {
            var res = cardNumber.substring(0, 16);
            $(".card-number").val(res);
        }
    });
    $(".card-cvc").keyup(function () {
        var cardcvv = $(this).val();
        if (cardcvv.length > 3) {
            var res = cardcvv.substring(0, 3);
            $(".card-cvc").val(res);
        }
    });
    $(".card-expiry-month").keyup(function () {
        var cardexpirymonth = $(this).val();
        if (cardexpirymonth.length > 2) {
            var res = cardexpirymonth.substring(0, 2);
            $(".card-expiry-month").val(res);
        }
    });
    $(".card-expiry-year").keyup(function () {
        var cardexpiryyear = $(this).val();
        if (cardexpiryyear.length > 4) {
            var res = cardexpiryyear.substring(0, 4);
            $(".card-expiry-year").val(res);
        }
    });
	    $(function () {
        var $form = $(".require-validation");
        $('form.require-validation').bind('submit', function (e) {
            var $form = $(".require-validation"),
                inputSelector = ['input[type=email]', 'input[type=password]', 'input[type=text]', 'input[type=file]', 'textarea'].join(', '),
                $inputs = $form.find('.required').find(inputSelector),
                $errorMessage = $form.find('div.error');
            valid = true;
            $errorMessage.addClass('hide');
            $('.has-error').removeClass('has-error');
            $inputs.each(function (i, el) {
                var $input = $(el);
                if ($input.val() === '') {
                    valid = false;
                    $input.parent().addClass('has-error');
                    $errorMessage.removeClass('hide');
                    e.preventDefault();
                }
            });

            if (!$form.data('cc-on-file')) {
                e.preventDefault();
                Stripe.setPublishableKey($form.data('stripe-publishable-key'));
                Stripe.createToken({
                    number: $('.card-number').val(),
                    cvc: $('.card-cvc').val(),
                    exp_month: $('.card-expiry-month').val(),
                    exp_year: $('.card-expiry-year').val()
                }, stripeResponseHandler);
            }

        });

        function stripeResponseHandler(status, response) {
            if (response.error) {
			
                $(".error").show();
                $('.error').removeClass('hide').find('.alert').text(response.error.message);
            } else {
                // token contains id, last4, and card type
                var token = response['id'];
                // insert the token into the form so it gets submitted to the server
                $form.find('input[type=text]').empty();
                $form.append("<input type='hidden' name='stripeToken' value='" + token + "'/>");
                $form.get(0).submit();
            }
        }
    });
	});




$("#PaymentMode").click(function () {
	 var valu=$("#amountnumber").val();
    if(valu=="" || valu==0){
        show_toastr("Warning","Enter Chip Amount","error");
    }else{
        $("#makeenroll").attr({
    "price" : $("#amountnumber").val(),
    "data-price" : "$"+$("#amountnumber").val()
  });
    
   

        @if(Auth::user())
		
        $("#payment-form")[0].reset()
        $('#myModal_payment').modal({backdrop: 'static', keyboard: false});
        var price = $("#makeenroll").attr("data-price");
        $("#customer_payment").html("Pay Now (" + price + ")");
        $("#itemPrice").val($("#makeenroll").attr("price"));
        var id = $("#makeenroll").attr("data-id");
        var checkSyndicate = $("#makeenroll").attr("checkSyndicate");

        $("#itemId").val(id);

        var itemType = $("#makeenroll").attr("data-type");
        $("#itemType").val(itemType);
        @else
        window.location.replace("{{route('login')}}");
        @endif
         }
    });
</script>
@endpush