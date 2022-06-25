<?php $page = "Assessment Payment"; ?>
@extends('layout.dashboardlayout')
@section('content')	

     @php
        $user=Auth::user();
        $permissions=permissions();
        @endphp
           @php
                                 $stripe_settings=\App\SiteSettings::getValByName('payment_settings');
                        
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
               
       
                     <a href="{{ route('assessment.dashboard') }}" class="btn btn-sm btn btn-primary float-right mr-2 m-0">
        <span class="btn-inner--text ">{{__('Dashboard')}}</span>
    </a>
                     
                   
                     </div>
                
   <!-- Breadcrumb -->
                <div class="breadcrumb-bar mb-3">
                    <div class="container-fluid">
                        <div class="row align-items-center">
                            <div class="col-md-12 col-12">
                                <h2 class="breadcrumb-title">Assessment Payment</h2>
                                <nav aria-label="breadcrumb" class="page-breadcrumb">
                                    <ol class="breadcrumb">
                                        <li class="breadcrumb-item"><a href="{{route('dashboard')}}">Dashboard</a></li>
                                        <li class="breadcrumb-item"><a href="{{ route('assessment.dashboard') }}">Assessment Dashboard</a></li>
                                        <li class="breadcrumb-item active" aria-current="page">Assessment Payment</li>
                                    </ol>
                                </nav>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- /Breadcrumb -->
                
   
    
    
<div class="row mt-3" id="blog_category_view">
    
        
<div class="col-lg-4 order-lg-2">
    <div id="page_sidebar_tabs"></div>
</div>
    {{--Main Part--}}
    <div class="col-lg-8 order-lg-1">
        <div id="tabs-1" class="tabs-card">
            <div class="card">
                    
                
                    
                <div class="card-body">
                         <div class="card alert alert-warning">
            <div class="card-body p-0">
                <div class="table-responsive">
                        <div class="">
                            <h6 class="header-title text-danger ">{{__('Please make payment to complete this assessment')}}</h6>
                        </div>
                </div>
            </div>
        </div>
                        
                        <div class="border p-3 mt-4 mb-3 mt-lg-0 rounded">
                            <div class="card-header">
                    
                    <h3>{{$form->title}}</h3>
                <p class="text-muted mb-0">{{ ucfirst($form->description) }}</p> 
                            
                </div>
                           <div class="table-responsive">
                                @if ($errors->any())
                    <div class="alert alert-danger">
                        <ul>
                            @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                    @endif
                                <table class="table table-centered mb-0">
                                    <tbody>
                                    <tr>
                                        <td>
                                            <h5 class="h6">{{ $form->title }}</h5>
                                        </td>
                                        <td class="text-right">
                                            <p class="mt-0 d-inline-block align-middle">
                                            {{'$'.number_format($form->amount, 2)}}
                                            </p>
                                        </td>
                                    </tr>
                                    <tr class="coupon-tr" style="display: none;">
                                        <td class="coupon-applied"> {{ __('Coupon Code Applied') }}</td>
                                        <td class="coupon-price text-right"></td>
                                    </tr>
                                    <tr class="text-right">
                                        <td>
                                            <h5 class="m-0 text-left">{{__('Total')}}:</h5>
                                        </td>
                                        <td class="text-right font-weight-semibold final-price">
                                            {{'$'.number_format($form->amount, 2)}}
                                        </td>
                                    </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>

                      
                            @if(!empty($stripe_settings['ENABLE_STRIPE']) && $stripe_settings['ENABLE_STRIPE'] == 'on')
                                <ul class="nav nav-pills pb-3" role="tablist">
                                    <li class="nav-item">
                                        <a class="nav-link active" data-toggle="tab" href="#stripe-payment" role="tab" aria-controls="stripe" aria-selected="true">{{ __('Stripe') }}</a>
                                    </li>
                                  
                                </ul>
                            @endif
                            <div class="tab-content">
                                @if((!empty($stripe_settings['ENABLE_STRIPE']) && $stripe_settings['ENABLE_STRIPE'] == 'on') && !empty($stripe_settings['STRIPE_KEY']) && !empty($stripe_settings['STRIPE_SECRET']))
                                    <div class="tab-pane fade {{ (!empty($stripe_settings['ENABLE_STRIPE']) && $stripe_settings['ENABLE_STRIPE'] == 'on') ? "show active" : "" }}" id="stripe-payment" role="tabpanel" aria-labelledby="stripe-payment">
                                        <form role="form" action="{{ route('stripe.assessmentFormPaymentPost') }}" method="post" class="require-validation" id="payment-form">
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
                                                    <div class="col-md-12 pt-2">
                                                        <div id="card-element">
                                                            <!-- A Stripe Element will be inserted here. -->
                                                        </div>
                                                        <div id="card-errors" role="alert"></div>
                                                    </div>
<!--                                                    <div class="col-12 pt-4">
                                                        <div class="row">
                                                            <div class="col-md-10">
                                                                <div class="form-group">
                                                                    {{--<label for="stripe_coupon">{{__('Coupon')}}</label>--}}
                                                                    <input type="text" id="stripe_coupon" name="coupon" class="form-control coupon" placeholder="{{__('Coupon Code')}}">
                                                                </div>
                                                            </div>
                                                            <div class="col-md-2 pt-1">
                                                                <div class="form-group apply-stripe-btn-coupon">
                                                                    <a href="#" class="btn btn-primary btn-sm apply-coupon">{{ __('Apply') }}</a>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>-->
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
                                                        <input type="hidden" name="code" value="{{\Illuminate\Support\Facades\Crypt::encrypt($form->id)}}">
                                                        <button class="btn btn-primary btn-sm rounded-pill" type="submit">
                                                            <i class="mdi mdi-cash-multiple mr-1"></i> {{__('Pay Now')}} (<span class="final-price">${{number_format($form->amount, 2)}}</span>)
                                                        </button>
                                                    </div>
                                                </div>
                                            </div>
                                        </form>
                                    </div>
                                @endif
                                
                            </div>
                       
                    </div>
            </div>

        </div>
    </div>
</div>

    

            </div>
        </div>

    </div>

</div>		
<!-- /Page Content -->
@endsection
@push('script')
<script>
    $(document).ready(function(){
      $.ajax({
       url:"{{route('assessmentForm.sidebar',!empty($form->id) ? encrypted_key($form->id,'encrypt') :0)}}?sidebar=form_questions_preview",
       success:function(data)
       {
        $('#page_sidebar_tabs').html(data);
       }
      });
    });
</script>
    <script src="https://js.stripe.com/v3/"></script>
    <script type="text/javascript">

        

        // Stripe Payment
            @if((!empty($stripe_settings['ENABLE_STRIPE']) && $stripe_settings['ENABLE_STRIPE'] == 'on') && !empty($stripe_settings['STRIPE_SECRET']) && !empty($stripe_settings['STRIPE_KEY']))

        var stripe = Stripe('{{ $stripe_settings['STRIPE_KEY']??'' }}');
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
        @endif


    </script>
@endpush


