<?php $page = "Payment"; ?>
@extends('layout.dashboardlayout')
@section('content')	

     @php
        $user=Auth::user();
        $permissions=permissions();
        @endphp
<!-- Page Content -->
<div class="content">
    <div class="container-fluid">

        <div class="row">
            <div class="col-md-5 col-lg-4 col-xl-3 theiaStickySidebar">

                <!-- Sidebar -->
                      @include('layout.partials.userSideMenu')
                <!-- /Sidebar -->

            </div>

            <div class="col-md-7 col-lg-8 col-xl-9">
                <div class=" col-md-12 ">   
         
       <a  class="btn btn-sm btn btn-primary float-right ml-2 " href="{{ route('shop.dashboard') }}"  >
        <span class="btn-inner--icon"><i class="fa fa-reply"></i></span> 
    </a>
       <a  class="btn btn-sm btn btn-primary float-right ml-2 " href="{{ route('shop') }}"  >
        <span class="btn-inner--icon"><i class="fa fa-shopping-cart"></i></span> {{__('Shop')}}
    </a>           
                    <a  class="btn btn-sm btn btn-primary float-right ml-2 " title="Refresh Cart" href="{{ route('shop.products.cart') }}"  >
        <span class="btn-inner--icon"><i class="fa fa-cart-plus"></i></span> {{__('Cart')}}
    </a>
                   
                     </div>
                
   <!-- Breadcrumb -->
                <div class="breadcrumb-bar mb-3">
                    <div class="container-fluid">
                        <div class="row align-items-center">
                            <div class="col-md-12 col-12">
                                <h2 class="breadcrumb-title">Shop Orders Payment</h2>
                                <nav aria-label="breadcrumb" class="page-breadcrumb">
                                    <ol class="breadcrumb">
                                        <li class="breadcrumb-item"><a href="{{route('dashboard')}}">Dashboard</a></li>
                                        <li class="breadcrumb-item"><a href="{{route('shop.dashboard')}}">Shop Dashboard</a></li>
                                        <li class="breadcrumb-item active" aria-current="page">Shop Orders Payment</li>
                                    </ol>
                                </nav>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- /Breadcrumb -->
                
   

   
<div class="row mt-3" id="blog_category_view"  >
     
    
  <!-- list view -->
  <div class="col-12">
      <div class="card">
          <div class="card-body ">
              
              <div class="row">
                    <div class="col-xl-8 col-lg-8 col-md-12 col-sm-12 col-12 ">
                   <div class="ps-block--shipping">
                                        <div class="ps-block__panel">
                                             <h4>Contact Info</h4>
                                            <figure>
                                                <p><i class="fa fa-envelope"></i> <a href="#">{{$purchaser->email??''}}</a>, <i class="fa fa-phone"></i> <a href="#">{{$purchaser->mobile??''}}</a></p>
                                                
                                            </figure>
                                            <figure><small>Ship to</small>
                                                <p>{{$purchaser->name??''}}, {{$purchaser->address1??''}}</p>
                                            </figure>
                                        </div>
                       <hr>
                                        <h4>Order Note</h4>
                                        <div class="ps-block__panel">
                                            <figure><p>{{$order_note}}<a class="text-primary float-right" href="{{route('shop.products.checkout')}}">Change</a></p></figure>
                                        </div>
                                        <hr>
                                        
                                        <div class="ps-block--payment-method">
                                            <div class="tab-pane show active" id="mentee-list">
                                                <!--<h4>Payment Methods</h4>-->
                    <div class="content container-fluid">

        <!-- Tab Menu -->
        <nav class="user-tabs mb-4 custom-tab-scroll">
            <ul class="nav nav-tabs nav-tabs-bottom nav-justified">
                <li>
                    <a class="nav-link active" href="#wallet" data-toggle="tab">Wallet Payment</a>
                </li>
                <li>
                    <a class="nav-link" href="#visa" data-toggle="tab">Visa / Master Card</a>
                </li>
              
                
            </ul>
        </nav>
        <!-- /Tab Menu -->

        <!-- Tab Content -->
        <div class="tab-content">

            <!-- General -->
            <div role="tabpanel" id="wallet" class="tab-pane fade show active">
                 <form  action="{{route('stripe.MarketplaceproductOrderPost')}}" method="post" >
                                                        {{ csrf_field() }}
                <h3>Wallet Payment</h3>
                                                    <p>Wallet payment method give you easiest way to make payments for your orders. <a class="text-primary" href="{{route("wallet")}}">Click</a> here to manage your wallet.</p>
                                                    <input type="hidden" name="method" value="wallet" required />
                                                        <input name="order_note" type="hidden" value="{{$order_note}}">
                                                        <input name="purchaser" type="hidden" value="{{$purchaser->id??''}}">
                                                    <button type="submit" class="btn btn-primary float-right" >Pay With Wallet ({{$total}})</button>
                                                     </form> 
            </div>
            <div role="tabpanel" id="visa" class="tab-pane fade show ">
                <h3>Visa / Master Card Payment</h3>
                 <form  action="{{route('stripe.MarketplaceproductOrderPost')}}" method="post" name="paymentForm" id="paymentForm" class="ps-form--visa require-validation"
                                                    data-cc-on-file="false"
                                                    data-stripe-publishable-key="{{$stripe_key??''}}"
                                                     >
                                                        {{ csrf_field() }}
                 
                                                            <input name="order_note" type="hidden" value="{{$order_note}}">
                                                             <input name="purchaser" type="hidden" value="{{$purchaser->id??''}}">
                                                    <div class="form-group error hide" style="display:none">
                                                             <div class='alert-danger alert'>Please correct the errors and try
                                                                again.
                                                            </div>
                                                        </div>
                                                        <div class="form-group">
                                                            <label>Card number</label>
                                                            <input autocomplete='off' class="form-control card-number" size='16'
                                                                       min="16" step="1" type='number' name="cardnumber" placeholder=""  required>
                                                        </div>
                                                        
                                                        <div class="form-group">
                                                            <label>Card Holder Name</label>
                                                            <input autocomplete='off' name="cardholder"  class="form-control" size='80' type='text' placeholder="{{Auth::user()->name}}" required>
                                                        </div>
                                                        <div class="row">
                                                            <div class="col-8">
                                                                <div class="form-group">
                                                                    <label>Expiration Date</label>
                                                                    <div class="row">
                                                                        <div class="col-6">
                                                                            <div class="form-group">
                                                                                <input name="expirymonth"  autocomplete='off' class="form-control card-expiry-month"  size='2' type="number" min="1" max="12" placeholder="Month" required>
                                                                            </div>
                                                                        </div>
                                                                        <div class="col-6">
                                                                            <div class="form-group">
                                                                                <input name="expiryyear"  autocomplete='off' class="form-control card-expiry-year" placeholder='YYYY' size='4'
                                 type="number" placeholder="Year" required>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="col-4">
                                                                <div class="form-group">
                                                                    <label>CVV</label>
                                                                    <input autocomplete='off'  name="cardcve" class="form-control card-cvc" placeholder='ex. 311' size='4' type="number" min="1" step="1" maxlength="4" max="9999" placeholder="" required>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="form-group submit">
                                                            
                                                            <button class="btn btn-primary float-right" id="stripbutton" type="submit" >Submit</button>
                                                        </div>
                                                             </form> 
                                                                                  
            </div>
            
        </div>
                    </div>
                                            </div>
                                            
                                            
                                            
                                        </div>
                                    </div>
                    </div>
                <div class="col-xl-4 col-lg-4 col-md-12 col-sm-12 col-12 ">
                            <div class="card ">
                                <div class="card-header bg-primary text-white">
                                    <!--<b>Subtotal <span> {{$subtotal_without_discount}}</span></b>-->
                                    <b>YOUR ORDER DETAILS</b>
                                </div>
                                <div class="ps-block__header">
                                    @if(!empty($discount_details))
                                    @foreach($discount_details as $i=>$row)
                                    <p>{{$i}} (Discount) <span> {{$row->amount}}</span></p>
                                    @endforeach
                                    @endif
                                </div>
                                <div class="card-body">
                                    <ul class="ps-block__product">
                                        @if(!empty($billdetails))
                                        @foreach($billdetails as $row)
                                        <li>
                                            <div class="row">
                                                <div class="col-md-8 ">
                                                    <span class="ps-block__shop "><a class="text-primary" href="{{ route('shop.products.cart',['id'=>encrypted_key($row['id'],'encrypt')]) }}">{{$row['name']." X ".$row['qty']}} </a></span>
                                                </div>
                                                <div class="col-md-4">
                                                    <p class="float-right">{{format_price($row['subtotal'])}}</p>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-md-8">
                                                    <span class="ps-block__shipping">Free Shipping </span>
                                                </div>
                                                <div class="col-md-4">
                                                     <span class="ps-block__shipping float-right">-$0.00</span>
                                                </div>
                                            </div>
                                            @if(!empty($row['deal']) && !empty($discount_details))
                                            <div class="row">
                                                <div class="col-md-8">
                                                    <span class="ps-block__shipping">Deal Discount  </span>
                                                </div>
                                                <div class="col-md-4">
                                                     <span class="ps-block__shipping float-right">-{{format_price($row['deal'])}}</span>
                                                </div>
                                            </div>
                                            @endif
                                            <div class="row">
                                                <div class="col-md-8">
                                                    <span class="ps-block__estimate">Estimated Price </span>
                                                </div>
                                                <div class="col-md-4">
                                                     <strong class="float-right">{{format_price($row['subtotal']-(!empty($discount_details) ? $row['deal']:0))}}</strong>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-md-10">
                                                    @php
            $domain_info=get_domain_user();
            @endphp
            <a target="_blank" href="#"> Sold By {{$domain_info->name??''}}</a>
                                                </div>
                                            </div>
                                                    
                                                      
                                            
                                        </li>
                                        @endforeach
                                        @endif
                                      
                                    </ul>
                                    <!--<b >Subtotal <span class="text-right float-right"> {{$subtotal_without_discount}}</span></b>    <br>-->
                                    <hr>
                                    <h4 >Total <span class="text-right float-right">{{$total}}</span></h4>
                                </div>
                            </div>
                        </div>
                        </div>
                
              
              
          </div> 	
      </div>
  </div> 
    <!-- list view -->
</div>
    

            </div>
        </div>

    </div>
</div>		
<!-- /Page Content -->
@endsection
@push('script')
<script type="text/javascript" src="https://js.stripe.com/v2/"></script>
<script type="text/javascript">
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
       
        var $form = $("#paymentForm");
        $('#paymentForm').bind('submit', function (e) {
           
            var $form = $("#paymentForm"),
                inputSelector = ['input[type=email]', 'input[type=password]', 'input[type=number]', 'input[type=text]', 'input[type=file]', 'textarea'].join(', '),
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
                Stripe.setPublishableKey('{{ $stripe_key??'' }}');
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

    
</script>

@endpush


