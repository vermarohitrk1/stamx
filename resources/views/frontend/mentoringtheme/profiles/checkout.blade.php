<?php $page = "checkout"; ?>
@extends('layout.commonlayout')
@section('content')		
<!-- Breadcrumb -->
<div class="breadcrumb-bar">
    <div class="container-fluid">
        <div class="row align-items-center">
            <div class="col-md-12 col-12">
                <h2 class="breadcrumb-title">Checkout</h2>
                <nav aria-label="breadcrumb" class="page-breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{url('/')}}">Home</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Checkout</li>
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

        <div class="row">
            <div class="col-md-7 col-lg-8">
                <div class="card">
                    <div class="card-body">

                        <!-- Checkout Form -->
                        <!--<form action="{{route('booking.success')}}">-->

                            <!-- Personal Information -->
                            <div class="info-widget">
                                <h3 class="card-title">Slots Description</h3>
                                @php 
                                $slots_list=[];
                                 $slots_price=0;
                                @endphp
                              @foreach($slots as $i=>$slot)
                              @php
                              $slots_price +=$slot->slot_price;
                              array_push($slots_list,$slot->id);
                              @endphp
                               <hr>
                                            <h2>{{$i+1}}- {!! html_entity_decode(($slot->title), ENT_QUOTES, 'UTF-8') !!}</h2>
                                            <p>{!! html_entity_decode(($slot->description), ENT_QUOTES, 'UTF-8') !!}</p>
                                           
                                            @endforeach
                                      
                          
                            </div>
                            <!-- /Personal Information -->

                            <div class="payment-widget">
@php
                                 $stripe_settings=\App\SiteSettings::getValByName('payment_settings');
                                 
                                 @endphp
                                 
                                 @if(!empty($stripe_settings['ENABLE_STRIPE']) && $stripe_settings['ENABLE_STRIPE'] == 'on' && !empty($stripe_settings['STRIPE_KEY']))
                                <form  action="{{route('stripe.ProfileSlotBooking')}}" method="post" name="paymentForm" id="paymentForm" class="ps-form--visa require-validation"
                                                    data-cc-on-file="false"
                                                    data-stripe-publishable-key="{{$stripe_settings['STRIPE_KEY']??''}}"
                                                     >
                                    <input type="hidden" name="slot" value="{{implode(',',$slots_list)}}">
                                    <input type="hidden" name="uid" value="{{encrypted_key($user->id,"encrypt")}}">
                                                        {{ csrf_field() }}
                                                        @if(!empty($slots_price))
                                                        
                                <h4 class="card-title">Payment Method (Stripe)</h4>
                                                    <div class="form-group error hide" style="display:none">
                                                             <div class='alert-danger alert'>Please correct the errors and try
                                                                again.
                                                            </div>
                                                        </div>
                                                        <div class="form-group">
                                                            <label>Card number</label>
                                                            <input autocomplete='off' class="form-control card-number" size='16'
                                                                   min="16" step="1" type='number' value="" name="cardnumber" placeholder=""  required>
                                                        </div>
                                                        
                                                        <div class="form-group">
                                                            <label>Card Holder</label>
                                                            <input autocomplete='off' name="cardholder" value="" class="form-control" size='80' type='text' placeholder="card holder's name" required>
                                                        </div>
                                                        <div class="row">
                                                            <div class="col-8 p-0">
                                                                <div class="form-group">
                                                                    <label>Expiration Date</label>
                                                                    <div class="row">
                                                                        <div class="col-6 p-0">
                                                                            <div class="form-group">
                                                                                <input name="expirymonth" value="" autocomplete='off' class="form-control card-expiry-month"  size='2' type="number" min="1" max="12" placeholder="Month" required>
                                                                            </div>
                                                                        </div>
                                                                        <div class="col-6">
                                                                            <div class="form-group">
                                                                                <input name="expiryyear" value="" autocomplete='off' class="form-control card-expiry-year" placeholder='YYYY' size='4'
                                 type="number" placeholder="Year" required>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="col-4 p-0">
                                                                <div class="form-group">
                                                                    <label>CVV</label>
                                                                    <input autocomplete='off' value="" name="cardcve" class="form-control card-cvc" placeholder='ex. 311' size='4' type="number" min="1" step="1" maxlength="4" max="9999" placeholder="" required>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        @endif
                                                        <div class="form-group submit">
                                                            <button class="btn btn-primary btn-lg submit-btn" id="stripbutton" type="submit" >Confirm and Pay</button>
                                                        </div>
                                                    </form>
                                 @else
                                  <div class="form-group error hide" >
                                                             <div class='alert-danger alert'>Please configure stripe first.
                                                            </div>
                                                        </div>
                                 @endif

                               

                                <!-- Submit Section -->
<!--                                <div class="submit-section mt-4">
                                    <a href="{{route('booking.success')}}" class="btn btn-primary submit-btn">Confirm and Pay</a>
                                </div>-->
                                <!-- /Submit Section -->

                            </div>
                       
                        <!-- /Checkout Form -->

                    </div>
                </div>

            </div>

            <div class="col-md-5 col-lg-4 theiaStickySidebar">

                <!-- Booking Summary -->
                <div class="card booking-card">
                    <div class="card-header">
                        <h4 class="card-title">Booking Summary</h4>
                    </div>
                    <div class="card-body">

                        <!-- Booking Mentee Info -->
                        <div class="booking-user-info">
                            <a href="{{route('profile',['id'=>encrypted_key($user->id,"encrypt")])}}" class="booking-user-img">
                                <img src="{{ $user->getAvatarUrl()}}" alt="User Image">
                            </a>
                            <div class="booking-info">
                                <h4><a href="{{route('profile',['id'=>encrypted_key($user->id,"encrypt")])}}">{{$user->name}}</a></h4>
                                <div class="rating">
                                    @for($i=1; $i<=5;$i++)
                                    <i class="fas fa-star @if(!empty((int) $user->average_rating) && $i<= (int) $user->average_rating) filled @endif"></i>
                                    @endfor
                                    <span class="d-inline-block average-rating"> ({{ $user->getProfilefeebackCount()}})</span>
                                </div>
                                <p class="text-muted mb-0"><i class="fas fa-map-marker-alt"></i> {{$user->state}}, {{$user->country}}</p>
                            </div>
                        </div>
                        <!-- Booking Mentee Info -->

                        <div class="booking-summary mt-5">
                            @foreach($slots as $slot)
                            
                            <hr>
                            <div class="booking-item-wrap">
                                <ul class="booking-date">
                                    <li>Date <span>{{date('F d, Y', strtotime($slot->date))}}</span></li>
                                    <li>Price <span>{{format_price($slot->slot_price)}}</span></li>
                                    <li>Time Slot<span>{{date('h:i A', strtotime($slot->start_time))}} - {{date('h:i A', strtotime($slot->end_time))}}</span></li>
                                </ul>
                                <ul class="booking-fee">
                                    <li><b>Price Description: </b>{!! html_entity_decode(($slot->price_description), ENT_QUOTES, 'UTF-8') !!}</li>
                                </ul>
                                
                            </div>
                            @endforeach
                            <div class="booking-total">
                                    <ul class="booking-total-list">
                                        <li>
                                            <span>Total</span>
                                            <span class="total-cost">{{format_price($slots_price)}}</span>
                                        </li>
                                    </ul>
                                </div>
                        </div>
                    </div>
                </div>
                <!-- /Booking Summary -->

            </div>
        </div>

    </div>

</div>		
<!-- /Page Content -->
@endsection
@push('script')

 @if(!empty($slots_price))
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
                Stripe.setPublishableKey('{{$stripe_settings['STRIPE_KEY']??''}}');
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
@endif
@endpush