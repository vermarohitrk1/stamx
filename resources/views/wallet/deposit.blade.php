<?php $page = "Deposit"; ?>
@section('title')
    {{$page??''}}
@endsection
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


                    <a href="{{ route('wallet') }}" class="btn btn-sm btn-primary float-right btn-icon-only rounded-circle " >
                        <span class="btn-inner--icon"><i class="fas fa-reply"></i></span>
                    </a>
                </div>

                <!-- Breadcrumb -->
                <div class="breadcrumb-bar mt-3">
                    <div class="container-fluid">
                        <div class="row align-items-center">
                            <div class="col-md-12 col-12">
                                <h2 class="breadcrumb-title">Deposit Via Stripe</h2>
                                <nav aria-label="breadcrumb" class="page-breadcrumb">
                                    <ol class="breadcrumb">
                                        <li class="breadcrumb-item"><a href="{{route('dashboard')}}">Dashboard</a></li>
                                        <li class="breadcrumb-item"><a href="{{ route('wallet') }}">Wallet</a></li>
                                        <li class="breadcrumb-item active" aria-current="page">Deposit Via Stripe</li>
                                    </ol>
                                </nav>
                            </div>              
                        </div>            
                    </div>
                </div>
                <!-- /Breadcrumb -->

                <div class="row mt-3" id="blog_category_view">

                    <!-- list view -->
                    <div class="col-12">
                        <div class="card">
                            <div class="card-body p-0">
                                <div class="col-md-12 ">
                                    <div class="card billing-info-card ">
                                        <br>
                                        <div class="element-box">
                                            <h5 class="form-header"></h5>
                                            <div class="form-desc"></div>
                                            
                                            <form role="form" action="{{ route('stripe.wallet.deposit') }}" method="post" class="require-validation" id="payment-form">
                                                @csrf
                                                <div class="border p-3 mb-3 rounded">
                                                    <div class="row">
                                                        <div class="col-sm-8">
                                                            <div class="custom-radio">
                                                                <label class="font-16 font-weight-bold">{{__('Credit / Debit Card')}}</label>
                                                            </div>
                                                            <p class="mb-0 pt-1">{{__('Safe money transfer using your bank account. We support Mastercard, Visa, Discover and American express.')}}</p>
                                                        </div>
                                                        <div class="col-sm-4 text-sm-right mt-3 mt-sm-0">
                                                            <img src="{{asset('assets/img/payments/master.png')}}" height="24" alt="master-card-img">
                                                            <img src="{{asset('assets/img/payments/paypal.png')}}" height="24" alt="paypal-card-img">
                                                            <img src="{{asset('assets/img/payments/visa.png')}}" height="24" alt="visa-card-img">
                                                            <img src="{{asset('assets/img/payments/american-express.png')}}" height="24" alt="american-express-card-img">
                                                        </div>
                                                    </div>
                                                    <div class="row">
                                                        <div class="col-12">
                                                            <hr>
                                                        </div>
                                                        <div class="col-md-12">
                                                            <div class="form-group">
                                                                <label for="card-name-on">{{__('Name on card')}}</label>
                                                                <input type="text" name="name" id="card-name-on" class="form-control required" placeholder="{{\Auth::user()->name}}" required="">
                                                            </div>
                                                        </div>
                                                        <div class="col-md-12">
                                                            <div class="form-group">
                                                                <label for="amount">{{__('Amount ($)')}}</label>
                                                                 <input required min="1" value="1.00" step="0.01" type="number"
                                                                   class="form-control" name="amount" id="amount">
                                                            </div>
                                                            <div class="row">
                                                    <div class="col-md-2 priceBox">
                                                        <button type="button" class="btn btn-light priceData" data-value="50.00">$50
                                                        </button>
                                                    </div>
                                                    <div class="col-md-2 priceBox">
                                                        <button type="button" class="btn btn-light priceData" data-value="100.00">$100
                                                        </button>
                                                    </div>
                                                    <div class="col-md-2 priceBox">
                                                        <button type="button" class="btn btn-light priceData" data-value="500.00">$500
                                                        </button>
                                                    </div>
                                                    <div class="col-md-2 priceBox">
                                                        <button type="button" class="btn btn-light priceData" data-value="1000.00">$1000
                                                        </button>
                                                    </div>
                                                    <div class="col-md-2 priceBox">
                                                        <button type="button" class="btn btn-light priceData" data-value="2000.00">$2000
                                                        </button>
                                                    </div>
                                                    <div class="col-md-2 priceBox">
                                                        <button type="button" class="btn btn-light priceData" data-value="2500.00">$2500
                                                        </button>
                                                    </div>
                                                </div>
                                                        </div>
                                                        <br>
                                                       
                                                        <div class="col-md-12 pt-2">
                                                             <hr>
                                                              <label for="card-name-on">{{__('Card Details')}}</label>
                                                            <div id="card-element">
                                                                <!-- A Stripe Element will be inserted here. -->
                                                            </div>
                                                              <div id="card-errors" class="text-danger mt-2"role="alert"></div>
                                                        </div>
                                                    </div>
                                                    <div class="row">
                                                        <div class="col-12">
                                                            <div class="error" style="display: none;">
                                                                <div class='alert-danger alert'>{{__('Please correct the errors and try again.')}}</div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <!-- end Credit/Debit Card box-->
                                                <div class="row mt-3">
                                                    <div class="col-sm-12">
                                                        <div class="text-sm-right">
                                                            <button class="btn btn-primary btn-sm rounded-pill" type="submit">
                                                                <i class="mdi mdi-cash-multiple mr-1"></i> {{__('Deposit Now')}} (<span class="final-price">$1.00</span>)
                                                            </button>
                                                        </div>
                                                    </div>
                                                </div>
                                            </form>			
                                            
                                        </div>
                                        <br>
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

<script src="https://js.stripe.com/v3/"></script>
<script type="text/javascript">

$(document).on("click", ".priceData", function () {
var dataValue = $(this).attr('data-value');
$("#amount").val(dataValue);
$(".final-price").html('$'+dataValue);
});
$("#amount").keyup(function () {
var amount = $(this).val();
$(".final-price").html('$'+amount);

});


var stripe = Stripe('{{ $stripe_key??'' }}');
var elements = stripe.elements();

// Custom styling can be passed to options when creating an Element.
var style = {
base: {
    // Add your base input styles here. For example:
    fontSize: '14px',
    color: '#32325d',
},
};

// Create an instance of the card Element.
var card = elements.create('card', {style: style});

// Add an instance of the card Element into the `card-element` <div>.
card.mount('#card-element');

// Create a token or display an error when the form is submitted.
var form = document.getElementById('payment-form');
form.addEventListener('submit', function (event) {
event.preventDefault();

stripe.createToken(card).then(function (result) {
    if (result.error) {
        $("#card-errors").html(result.error.message);
    } else {
        // Send the token to your server.
        stripeTokenHandler(result.token);
    }
});
});

function stripeTokenHandler(token) {
// Insert the token ID into the form so it gets submitted to the server
var form = document.getElementById('payment-form');
var hiddenInput = document.createElement('input');
hiddenInput.setAttribute('type', 'hidden');
hiddenInput.setAttribute('name', 'stripeToken');
hiddenInput.setAttribute('value', token.id);
form.appendChild(hiddenInput);

// Submit the form
form.submit();
}


</script>
@endpush
