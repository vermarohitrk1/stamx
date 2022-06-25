<?php $page = "search"; ?>
@extends('layout.commonlayout')
@section('content')		
<style>
.mt-50 {
    margin-top: 50px !important;
}
.single-faq p:last-child {
    margin-bottom: 0;
}
h4#plan_p {
    color: #13c4a1;
}
.custom-control-label::before {
   
    top: .40rem !important;
    width: 1.2rem !important;
    height: 1.2rem !important;
}
.faq-black p {
    color: #696871;
}

.faq-black .faq-title, .faq-black .title {
    color: #19191b;
}

.single-faq .title, .single-faq .faq-title {
    color: #FFF;
    font-size: 24px;
    font-weight: 900;
    letter-spacing: -0.75px;
    margin-bottom: 30px;
}
.pricing-page-faq-section .section-title p {
    padding-top: 15px;
}
.section-title p {
    color: #696871;
    font-family: "CircularStd", sans-serif;
    font-size: 21px;
    font-weight: 300;
    letter-spacing: -0.66px;
    line-height: 39px;
}  
div#planAllModulesShow h5.modal-title {
    font-size: 20px;
}
button.btn.btn-primary.btn-sm {
    padding: 9px 11px;
    font-size: 12px;
}
input.btn.btn-primary.Now {
    font-size: 12px;
}
 @media only screen and (max-width: 767px){

.pricing-btns {

    margin-top: 30px !important;
}

.pricing-btns a {

    width: 110px !important;

}
}

button.btn.btn-info.btn-sm {
    padding: 9px 11px;
    font-size: 12px;
}
div#dataholder p {
    font-size: 17px;
    font-weight: 800;
}
div#planAllModulesShow  button.btn.btn-sm.btn-secondary.rounded-pill {
    padding: 5px 15px;
    font-size: 12px;
}
.section-title h2 {
    font-size: 5.5rem;
    font-weight: 800;
}
i.fas.fa-info-circle {
            font-size: 140px;
            color: var(--blue);
        }
.modal-content.modal_text {
    padding: 34px 70px 34px 70px;
}  

        .modal-footer {
            display: unset;
            border-top: 0px;
        }

		button.btn.Now {
		background-color:var(--blue);
		color: white;
		font-size: 13px;
		}

		button.btn.cancel {
		color: white;
		background-color: #a8a8a8;
		font-size: 13px;
		}

.pricing-btns {
  border-radius: 10px;
  padding: 5px;
  background-color: #f7f7fb;
  display: -webkit-inline-box;
  display: inline-flex;
  max-height: 65px;
}

.pricing-btns a {
  border-radius: 10px 0 0 10px;
  width: 160px;
  height: 55px;
  display: -webkit-inline-box;
  display: inline-flex;
  -webkit-box-pack: center;
          justify-content: center;
  -webkit-box-align: center;
          align-items: center;
  color: #ffffff;
  font-size: 16px;
  font-weight: 700;
  letter-spacing: -0.5px;
  color: #19191b;
}
a#btn_week {
    border-radius: 0;
}
.pricing-btns a + a {
  border-radius: 0 10px 10px 0;
}

.pricing-btns a.active {
  background-color: var(--blue);
  color: #fff;
}

.yearly-active .yearly {
  display: block;
}

.yearly-active .monthly {
  display: none;
}
.yearly-active .weekly {
  display: none;
}

.monthly-active .monthly {
  display: block;
}

.monthly-active .yearly {
  display: none;
}
.monthly-active .weekly {
  display: none;
}
.weekly-active .weekly {
  display: block;
}

.weekly-active .monthly {
  display: none;
}
.weekly-active .yearly {
  display: none;
}

.yearly-active .pricing-btn .yearly_btn {
  display: block;
}
.yearly-active .pricing-btn.weekly_btn {
  display: none;
}
.yearly-active .pricing-btn.monthly_btn {
  display: none;
}

.monthly-active .pricing-btn.monthly_btn {
  display: block;
}

.monthly-active .pricing-btn.weekly_btn {
  display: none;
}
.monthly-active .pricing-btn.yearly_btn {
  display: none;
}

.weekly-active .pricing-btn.weekly_btn {
  display: block;
}

.weekly-active .pricing-btn.monthly_btn {
  display: none;
}
.weekly-active .pricing-btn.yearly_btn {
  display: none;
}
.pricing-card--2 {
    border-radius: 10px;
    border: 1px solid #eae9f2;
    background-color: #fff;
    text-align: center;
    padding-left: 25px;
    padding-right: 25px;
    padding-bottom: 25px;
    padding-top: 32px;
}
.pricing-card--2 .price {
    color: #1d293f;
    font-size: 60px;
    font-weight: 700;
    letter-spacing: -1.03px;
    line-height: 56px;
    color: #1d293f;
    margin-bottom: 30px;
}

.pricing-card--2 .pricing-list {
    color: #696871;
    font-size: 21px;
    font-weight: 300;
    letter-spacing: -0.66px;
    line-height: 1.6;
}
ul {
    list-style: none;
   
}
.pricing-card--2 .pricing-btn {
    padding-top: 30px;
}
div#pricing-card-deck {
    padding: 56px 0px;
}
.pricing-card--2 .small-title {
    color: #696871;
    font-size: 18px;
    font-weight: 300;
    letter-spacing: -0.56px;
    line-height: 28px;
    margin-bottom: 22px;
}

a, span {
    display: inline-block;
}
.pricing-card--2 .pricing-list li {
    margin-bottom: 14px;
}


.pricing-card--2 .price .time {
    font-size: 28px;
    font-weight: 300;
    letter-spacing: -1.03px;
    line-height: 1;
}
.pricing-card--2 .pricing-btn .btn {
    width: 100%;
    max-width: 305px;
    border-radius: 10px;
    border: 1px solid #eae9f2;
    background-color: #ffffff;
    color: var(--blue);
    font-size: 21px;
    font-weight: 500;
    letter-spacing: -0.66px;
    min-height: 60px;
    display: -webkit-box;
    display: flex;
    -webkit-box-align: center;
    align-items: center;
    -webkit-box-pack: center;
    justify-content: center;
    margin: 0 auto;
}
.btn-block {
    font-size: 15px;
    padding: 9px;
}
button.close {
    font-size: 1.9rem;
}
h4.modal-title.text-center {
    font-size: 2rem;
    color: #000;
}
</style>
<!-- Breadcrumb -->
<div class="breadcrumb-bar">
    <div class="container-fluid">
        <div class="row align-items-center">
            <div class="col-md-8 col-12">
                <nav aria-label="breadcrumb" class="page-breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ url('')}}">Home</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Pricing Plans</li>
                    </ol>
                </nav>
                <h2 class="breadcrumb-title">Plans</h2>
            </div>
            <div class="col-md-4 col-12 d-md-block d-none">
                <!--<div class="sort-by">
						<span class="sort-title">Sort by</span>
                    <span class="sortby-fliter">
                        <select class="select">
                            <option>Select</option>
                            <option class="sorting">Rating</option>
                            <option class="sorting">Popular</option>
                            <option class="sorting">Latest</option>
                            <option class="sorting">Free</option>
                        </select>
                    </span>
                </div>-->
            </div>
        </div>
    </div>
</div>
<!-- /Breadcrumb -->

<!-- Page Content -->
<div class="content">
    <div class="container-fluid">
	
	    <div class="pricing-area mb--115 pt--115">
        <div class="container">
            <div class="row text-md-center text-lg-left mb--40">
                <div class="col-lg-7 col-xl-6">
                    <div class="section-title">
                        <h2>Choose the right plan for your business.</h2>
                    </div>
                </div>
                <div class="col-lg-5 col-xl-6 d-flex justify-content-center justify-content-lg-end align-items-end">
                    <div class="pricing-btns mb--25 mt--20 mt-lg--0" id="pricing-deck-trigger">
                        <a href="javascript:" data-active="yearly-active">Yearly</a>
                        <a href="javascript:" data-active="weekly-active" id="btn_week">Weekly</a>
                        <a href="javascript:" class="active" data-active="monthly-active">Monthly</a>
                    </div>
                </div>
            </div>

          </div>
        </div>
	

	
    
        <div class="row justify-content-center monthly-active" id="pricing-card-deck">
		
		@foreach($allPlans as $key => $plans)
		@foreach($plans as $key => $_plan)
          <div class="col-lg-4 col-md-6 col-sm-8 mt--30">
            <div class="pricing-card--2 active">
              <span class="small-title">{{$_plan->name}}</span>
              <h1 class="price  weekly">${{$_plan->weekly_price}}<span class="time">/week</span></h1>
			   <h1 class="price  monthly">${{$_plan->monthly_price}}<span class="time">/month</span></h1>
              <h1 class="price yearly">${{$_plan->annually_price}}<span class="time">/year</span></h1>
           
              <ul class="pricing-list">
			  <li>+ {{$_plan->setup_fee}} Setup Fee</li>
                    <li><a href="javascript:void(0)" class="text-black-50 allModules " id="{{$_plan->id}}">Intergrated Apps @if(!empty($_plan->getPlanscount()))
                                                    ({{$_plan->getPlanscount()}})  
                                                        @endif</a></li>
                    <li>Business Concierge</li>
                    <li>Marketing Minutes</li>
                    <li>1 Free Bonus</li>
                    <li>Lifetime updates </li>
              </ul>
			  
			
								
								
							  <div class="pricing-btn weekly_btn">	
							 @if(!empty($authuser->id))
                            @if($user_id == $authuser->id)
                                <a href="{{url('plans')}}" class="btn btn-primary mt-4">Manage</a>
                            @else
								
							@if( $authuser->plan == $_plan->id && $authuser->plan_type=="week")
								
							<a href="javascript:void(0)" class="btn btn-primary mt-4" >Current Plan</a>
							
							@elseif(!empty($authuser->plan))
							<a href="javascript:void(0)" class="btn btn-primary mt-4 buy_btn " data-plan-id="{{$_plan->id}}" data-plan-price="{{$_plan->weekly_price}}" data-plan-fee="{{$_plan->setup_fee}}" data-plan-Type="week"
                                    data-plan-enc="{{route('payment.owner',[\Illuminate\Support\Facades\Crypt::encrypt($_plan->id),'week'])}}"
                                    data-plan-title="{{$_plan->name}}!"
                                    >Upgrade</a>
							@else
							   <a href="javascript:void(0)" class="btn btn-primary mt-4 buy_btn " data-plan-id="{{$_plan->id}}" data-plan-price="{{$_plan->weekly_price}}" data-plan-fee="{{$_plan->setup_fee}}" data-plan-Type="week"
                                    data-plan-enc="{{route('payment.owner',[\Illuminate\Support\Facades\Crypt::encrypt($_plan->id),'week'])}}"
                                    data-plan-title="{{$_plan->name}}!"
                                    >Get Started</a>
							@endif	
                             
                            @endif
                        @else
                            <a href="javascript:void(0)" class="btn btn-primary mt-4 buy_btn " data-plan-id="{{$_plan->id}}" data-plan-price="{{$_plan->weekly_price}}" data-plan-fee="{{$_plan->setup_fee}}" data-plan-Type="week"
                                    data-plan-enc="{{route('payment.owner',[\Illuminate\Support\Facades\Crypt::encrypt($_plan->id),'week'])}}"
                                    data-plan-title="{{$_plan->name}}!"
                                    >Get Started</a>
                        @endif		
						</div>
						
						  <div class="pricing-btn yearly_btn">
							 @if(!empty($authuser->id))
                            @if($user_id == $authuser->id)
                                <a href="{{url('plans')}}" class="btn btn-main-2">Manage</a>
                            @else
								
								@if( $authuser->plan == $_plan->id && $authuser->plan_type=="year")
								
							<a href="javascript:void(0)" class="btn btn-primary mt-4" >Current Plan</a>
							
							@elseif(!empty($authuser->plan))
							<a href="javascript:void(0)" class="btn btn-primary mt-4 buy_btn price  year" data-plan-id="{{$_plan->id}}" data-plan-price="{{$_plan->annually_price}}" data-plan-fee="{{$_plan->setup_fee}}" data-plan-Type="year"
                                    data-plan-enc="{{route('payment.owner',[\Illuminate\Support\Facades\Crypt::encrypt($_plan->id),'year'])}}"
                                    data-plan-title="{{$_plan->name}}!"
                                    >Upgrade</a>
							@else
							    <a href="javascript:void(0)" class="btn btn-primary mt-4 buy_btn price  year" data-plan-id="{{$_plan->id}}" data-plan-price="{{$_plan->annually_price}}" data-plan-fee="{{$_plan->setup_fee}}" data-plan-Type="year"
                                    data-plan-enc="{{route('payment.owner',[\Illuminate\Support\Facades\Crypt::encrypt($_plan->id),'year'])}}"
                                    data-plan-title="{{$_plan->name}}!"
                                    >Get Started</a>
							@endif	
							
                               
                            @endif
                        @else
                            <a href="javascript:void(0)" class="btn btn-primary mt-4 buy_btn price  year" data-plan-id="{{$_plan->id}}" data-plan-price="{{$_plan->annually_price}}" data-plan-fee="{{$_plan->setup_fee}}" data-plan-Type="year"
                                    data-plan-enc="{{route('payment.owner',[\Illuminate\Support\Facades\Crypt::encrypt($_plan->id),'year'])}}"
                                    data-plan-title="{{$_plan->name}}!"
                                    >Get Started</a>
                        @endif		
						</div>
						  <div class="pricing-btn monthly_btn">
							 @if(!empty($authuser->id))
                            @if($user_id == $authuser->id)
                                <a href="{{url('plans')}}" class="btn btn-main-2">Manage</a>
                            @else
								
							@if( $authuser->plan == $_plan->id && $authuser->plan_type=="month")
								
							<a href="javascript:void(0)" class="btn btn-primary mt-4" >Current Plan</a>
								@elseif(!empty($authuser->plan))
							<a href="javascript:void(0)" class="btn btn-primary mt-4 buy_btn  price  monthly" data-plan-id="{{$_plan->id}}" data-plan-price="{{$_plan->monthly_price}}" data-plan-fee="{{$_plan->setup_fee}}" data-plan-Type="month"
                                    data-plan-enc="{{route('payment.owner',[\Illuminate\Support\Facades\Crypt::encrypt($_plan->id),'month'])}}"
                                    data-plan-title="{{$_plan->name}}!"
                                    >Upgrade</a>
							
							@else
							   <a href="javascript:void(0)" class="btn btn-primary mt-4 buy_btn  price  monthly" data-plan-id="{{$_plan->id}}" data-plan-price="{{$_plan->monthly_price}}" data-plan-fee="{{$_plan->setup_fee}}" data-plan-Type="month"
                                    data-plan-enc="{{route('payment.owner',[\Illuminate\Support\Facades\Crypt::encrypt($_plan->id),'month'])}}"
                                    data-plan-title="{{$_plan->name}}!"
                                    >Get Started</a>
							@endif	
                               
                            @endif
                        @else
                            <a href="javascript:void(0)" class="btn btn-primary mt-4 buy_btn price  monthly" data-plan-id="{{$_plan->id}}" data-plan-price="{{$_plan->monthly_price}}" data-plan-fee="{{$_plan->setup_fee}}" data-plan-Type="month"
                                    data-plan-enc="{{route('payment.owner',[\Illuminate\Support\Facades\Crypt::encrypt($_plan->id),'month'])}}"
                                    data-plan-title="{{$_plan->name}}!"
                                    >Get Started</a>
                        @endif		
			 </div>
              
             

            </div>
        </div>
		 @endforeach
                @endforeach
    </div>

    <div class="pricing-page-faq-section section-padding bg-whisper">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-xl-7 col-lg-8 col-md-9">
                    <div class="section-title text-center">
                        <h2 class="title">Frequently<br class="d-none d-sm-block"> Asked Question</h2>
                        <p>Get your MyCEO questions answered. Find answers to common questions, like what are the system
                            requirements for MyCEO...</p>
                    </div>
                </div>
            </div>
            <div class="row mb-5">
            @foreach($faqs as $faq)
                <div class="col-lg-6 mt-50">
                    <div class="single-faq faq-black">
                        <h3 class="blog-title mb-5">{{$faq->question}}</h3>
                        <p>{{$faq->answer}}</p>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
    </div>

      </div>

</div>		

<div id="planAllModulesShow" class="modal fade" role="dialog">
    <div class="modal-dialog">
        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Details</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button> 
            </div> 
            <div class="modal-body" id="dataholder">  
            </div> 
        </div>
    </div>
</div>


<div class="modal fade" id="myModalupgrade">
        <div class="modal-dialog">
            <div class="modal-content modal_text">
                <!-- Modal Header -->
                <div class="top-content">
                    <div class="modal-icon text-center"><i class="fas fa-info-circle"></i></div>
                    <h4 class="modal-title text-center">Subscribe to
                        <span id="plan_name"></span>
						 
                    </h4>
					<h4  class="modal-title text-center" id="plan_p"></h4>
					<h3 class="text-center" id="plan_planfee"></h3>
                </div>
                <!-- Modal body -->
                <div class="modal-body text-center">
                    Click subscribe now to proceed
                </div>
                <!-- Modal footer -->
                <div class="modal-footer">
                    <div class="text-center">
                     
                            {{ Form::open(['route' => ['stripe.post.upgrade'],'id' => 'price_formm','enctype' => 'multipart/form-data']) }}
                            <button type="button" class="btn cancel" data-dismiss="modal">Cancel</button>
                            <input type="hidden" class=" plan_update_id" name="id" value="">
                            <input type="hidden" class=" plan_update_type" name="type" value="">
                            <input type="hidden" class="plan_update_price" name="price" value="">
                           
                         
							
							<input type="submit" value="Subscribe Now!" class='btn btn-primary Now'>
                            {{ Form::close() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
<div class="modal fade" id="myModal">
        <div class="modal-dialog">
            <div class="modal-content modal_text">
                <!-- Modal Header -->
                <div class="top-content">
                    <div class="modal-icon text-center"><i class="fas fa-info-circle"></i></div>
                    <h4 class="modal-title text-center">Subscribe to
                        <span id="plan_name"></span>
                    </h4>
					
                </div>
                <!-- Modal body -->
                <div class="modal-body text-center">
                    Click subscribe now to proceed
                </div>
                <!-- Modal footer -->
                <div class="modal-footer">
                    <div class="text-center">
                        @if(empty($authuser))
                            {{ Form::open(['route' => ['price.checkout'],'id' => 'price_form','enctype' => 'multipart/form-data']) }}
                            <button type="button" class="btn cancel" data-dismiss="modal">Cancel</button>
                            <input type="hidden" class="subscribe_btn" name="id" value="">
                            <a href="{{route('register')}}">
                                <button type="button" class="btn Now" data-id=""><span
                                        class="text-white">Subscribe Now!</span></button>
                            </a>
							          <a class=" btn Now" href="javacript:" data-toggle="modal" data-target="#registerModal"
                                                           >Subscribe Now!
                                                        </a>
                            {{ Form::close() }}
                        @else
                            <button type="button" class="btn cancel" data-dismiss="modal">Cancel</button>
                            <button type="submit" class="btn Now" data-id="">
                                <a href="javascript:void(0)" class="text-white " data-plan="" data-duration=""  data-name="" data-fee="" data-price="" id="buy_btn_withlogin">Subscribe Now!</a>
                            </button>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
	
	
	<!--
	payment modal
	
	-->
	
	    <div class="modal fade" id="client_stripe_payment">
        <div class="modal-dialog">
            <div class="modal-content">
                <!-- Modal Header -->
				
                <div class="top-content pt-4">
                    <h4 class="modal-title text-center">
                        Subscribe to
                        <span class="plan_name"></span>
                    </h4>
                    <h5 class="text-center">Duration: <span class="plan-duration"></span></h5>
                </div>
                <!-- Modal body -->
                <div class="modal-body text-center">
                  
                        <div class="tab-pane fade show active" id="stripe-payment" role="tabpanel" aria-labelledby="stripe-payment">
                          
   @if(!empty($authuser))
				 <form role="form" action="{{ route('stripe.post.plan') }}" method="post" class="client-require-validation" id="client-payment-form">
                           		 
@else
	 <form role="form" action="{{ route('stripe.post.owner') }}" method="post" class="client-require-validation" id="client-payment-form">
@endif	

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
                                                <input type="text" name="name" class="form-control card-name-on" required value="" placeholder="">
                                            </div>
                                        </div>
                                        <div class="col-md-12 pt-2">
                                            <div id="client-card-element">
                                                <!-- A Stripe Element will be inserted here. -->
                                            </div>
                                            <div class="client-card-errors" role="alert"></div>
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
                                            <input type="hidden" class="plan_id" name="code" value="">
                                            <input type="hidden" class="plan_duration" name="type" value="">
											<button type="button" class="btn btn-info  btn-sm" data-dismiss="modal">Cancel</button>
                                            <button class="btn btn-primary btn-sm " type="submit">
                                                <i class="mdi mdi-cash-multiple mr-1"></i> {{__('Pay Now')}} ($<span class="final-price plan-price"></span>)
                                            </button>
											  
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>
                    
                </div>
                <!-- Modal footer -->
                <div class="modal-footer">

                </div>
            </div>
        </div>
    </div>
	
<!-- register modal -->
<div id="registerModal" class="modal fade" role="dialog">
    <div class="modal-dialog">

        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title text-center">Create an account!
                    Enter your information below to Access our dashboard.</h4>
					     <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
            </div>
            <div class="modal-body">
                <form class="login-form mt-4" method="POST" action="{{ route('register') }}" id="registerClient">
                    @csrf
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group position-relative">
                                <label> Name <span class="text-danger">*</span></label>
                                <i data-feather="user" class="fea icon-sm icons"></i>

                                <input id="name" type="text"
                                       class="form-control pl-5 @error('name') is-invalid @enderror" 
                                       name="name" value="{{ old('name') }}" required autocomplete="name" autofocus>
                                @error('name')
                                <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                                @enderror
                            </div>
                        </div>

                        <div class="col-md-12">
                            <div class="form-group position-relative">
                                <label> Email <span class="text-danger">*</span></label>
                                <i data-feather="mail" class="fea icon-sm icons"></i>

                                <input id="email" type="email"
                                       class="form-control pl-5 @error('email') is-invalid @enderror" name="email"
                                       value="{{ old('email') }}"  required autocomplete="email">
                                @error('email')
                                <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="form-group position-relative">
                                <label>Password <span class="text-danger">*</span></label>
                                <i data-feather="key" class="fea icon-sm icons"></i>
                                <input id="password" type="password"
                                       class="form-control pl-5 @error('password') is-invalid @enderror"
                                        name="password" required autocomplete="new-password">
                                @error('password')
                                <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="form-group position-relative">
                                <label>Confirm password <span class="text-danger">*</span></label>
                                <i data-feather="key" class="fea icon-sm icons"></i>
                                <input id="password-confirm" type="password" class="form-control pl-5"
                                       name="password_confirmation" required autocomplete="new-password"
                                       >
                            </div>
                        </div>
						 <div class="col-md-12">
                            <div class="form-group position-relative">
                                <label>Get Registered For <span class="text-danger">*</span></label>
						<select class="form-control" name="userType">
                               
                                <option value="mentor">Mentor</option>
                                <option value="corporate">Corporate</option>
                              
                            </select>
							 </div>
                        </div>
						
						<div class="col-md-12">
						<div class="form-group">
                            <div class="custom-control custom-control-xs custom-checkbox">
                                <input type="checkbox" class="custom-control-input" name="agreeCheckboxUser" id="agree_checkbox_user" required="">
                                <label class="custom-control-label" for="agree_checkbox_user">I agree to Mentoring</label> <a tabindex="-1" href="javascript:void(0);">Privacy Policy</a> &amp; <a tabindex="-1" href="javascript:void(0);"> Terms.</a>
                            </div>
                            </div>
                        </div>
                        <input type="hidden" class="selected_plan_id" name="plan_id" value="">
                        <input type="hidden" class="selected_plan_type" name="plan_type" value="">
                        <div class="col-md-12">
                            <button type="submit" class="btn btn-primary btn-block">Register</button>
                            <button type="button" class="btn btn-info btn-block" data-dismiss="modal">Close</button>
                        </div>

                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <!-- <button type="button" class="btn btn-default" data-dismiss="modal">Close</button> -->
            </div>
        </div>

    </div>
</div>


<!-- /Page Content -->
<input type="hidden" id="view_type" value="list" />
@endsection
@push('script')
<script src="https://js.stripe.com/v3/"></script>
<script>
   $(document).ready(function () {
        $('.buy_btn').click(function () {
			
            @if(empty($authuser))
                var planName = $(this).attr('data-plan-title');
		
                var eachPlanId = $(this).attr('data-plan-id');
                var PlanType = $(this).attr('data-plan-Type');
                $('.subscribe_btn').val(eachPlanId);
                $('#plan_name').html(planName);
                var formAction = "{{route('register.client')}}";
                $('#registerClient .selected_plan_id').val(eachPlanId);
				   $('#registerClient .selected_plan_type').val(PlanType);
                $('#registerClient').attr('action', formAction);
                $('#registerModal').modal({ backdrop: 'static', keyboard: false });
                $('#registerModal').modal('show');
            @else
                var planName = $(this).attr('data-plan-title');
				var planID=$(this).attr('data-plan-id');
				var planDuration=$(this).attr('data-plan-type');
				 var planprice = $(this).attr('data-plan-price');
				  var planfee = $(this).attr('data-plan-fee');
                var planUrl = $(this).attr('data-plan-enc');
           
                $('#plan_name').html(planName);
				  $('#buy_btn_withlogin').attr("data-plan", planID);
				  $('#buy_btn_withlogin').attr("data-name", planName);
				  $('#buy_btn_withlogin').attr("data-duration", planDuration);
				  $('#buy_btn_withlogin').attr("data-price", planprice);
				  $('#buy_btn_withlogin').attr("data-fee", planfee);
				  @if(!empty($authuser->plan))
					  
				  
				   $('.plan_update_id').val(planID);
				    $('.plan_update_type').val(planDuration);
					 $('.plan_update_price').val(planprice);
					 $('#plan_p').html('$'+planprice+'/'+planDuration);
					 $('#plan_planfee').html('+'+planfee+' Setup Fee');
					 $('#plan_planDuration').html(planDuration);
					 
					
				   
					   $('#myModalupgrade').modal('show');
				  @else
                $('#myModal').modal('show');
			@endif
            @endif
        });

     $('#buy_btn_withlogin').click(function () {
		     @if(!empty($authuser))
				     var planName = $(this).attr('data-name');
				var planID=$(this).attr('data-plan');
			
				var planDuration=$(this).attr('data-duration');
				var fee=parseInt($(this).attr('data-fee'));
				var price=parseInt($(this).attr('data-price'));
			
				var total=  price + fee ;
					
                var encryptID = "{{encrypted_key(".$(this).attr('data-plan').", 'encrypt')}}";
				
			  var fname = "{{$authuser->name}}";
				  $('#myModal').modal('hide');
						$('.plan-price').html(total);
                        $('.card-name-on').val(fname);
                        $('.plan_id').val(planID);
                        $('.plan_duration').val(planDuration);
                        $('.plan-duration').html(planDuration);
                        $('.plan_name').html(planName);
                        $('#client_stripe_payment').modal({ backdrop: 'static', keyboard: false });
                        $('#client_stripe_payment').modal('show');
			  
			@endif	 
			 
	 });
        $(document).on('submit','#registerClient',function(event){
            event.preventDefault();
            $('.site-loading').addClass('active');
            $.ajax({
                url: "{{ route('register.client')}}",
                type: 'post',
                data: $('#registerClient').serialize(),
                success: function (response) {
                    $('.site-loading').removeClass('active');
                    if (response.success) {
					
                        $('#registerModal').modal('hide');
                        $('.plan-price').html(response.plan_data.price);
                        $('.card-name-on').val(response.name);
                        $('.plan_id').val(response.plan_data.plan_id);
                        $('.plan_duration').val(response.plan_data.duration);
                        $('.plan-duration').html(response.plan_data.duration);
                        $('.plan_name').html(response.plan_data.plan_name);
                        $('#client_stripe_payment').modal({ backdrop: 'static', keyboard: false });
                        $('#client_stripe_payment').modal('show');
                    }
                    else{
                        toastr.error(error, response.message);
                    }
                },
                error: function(err, i, n){
                        if (err.status == 422) { 
                        console.log(err.responseJSON);
                        console.warn(err.responseJSON); 
                        $.each(err.responseJSON, function (i, error) { 
                            var el = $(document).find('[name="'+i+'"]');
                            if(el.next('span.error-message').length > 0){
                                el.next('span.error-message').text(error[0]);
                            }else{
                                el.after($('<span class="error-message" style="color: #D65053;">'+error[0]+'</span>'));
                            }
                            el.addClass('is-invalid');
                        });

                        return false;
                    }

                    show_toastr('{{__('Error')}}', "Something went wrong!", 'error');
                }
            });
            return false;
        });
    });
    $(document).ready(function(){
     
            var stripe = Stripe('pk_test_51IHORWHxbChuDygCPG8smFfg1JyeOrP2ChNzbkg71nqB7J7WNMAYGCOGsVyPv90SiYKcE6aAZdvvDpQAcrY8LXUc00mHDMs37x');
            var elements = stripe.elements();
            var style = {
                base: {
                    fontSize: '14px',
                    color: '#32325d',
                },
            };
            var card = elements.create('card', {style: style});
            card.mount('#client-card-element');
            var form = document.getElementById('client-payment-form');
            form.addEventListener('submit', function (event) {
                event.preventDefault();
                stripe.createToken(card).then(function (result) {
                    console.log(result);
                    if (result.error) {
                        $(".client-card-errors").html(result.error.message);
                    } else {
                        stripeTokenHandler(result.token);
                    }
                });
            });
            function stripeTokenHandler(token) {
                var form = document.getElementById('client-payment-form');
                var hiddenInput = document.createElement('input');
                hiddenInput.setAttribute('type', 'hidden');
                hiddenInput.setAttribute('name', 'stripeToken');
                hiddenInput.setAttribute('value', token.id);
                form.appendChild(hiddenInput);
                form.submit();
            }
        
    });


  
         $(".allModules").click(function() {
    var id = $(this).attr('id');
    $.post(
            "{{route('show.package.modules')}}",
    {_token: "{{ csrf_token() }}", id: id},
            function (data) {
            $("#dataholder").html(data);
            $("#planAllModulesShow").modal('show');
            }
    );
    });

   $("#pricing-deck-trigger").on("click", function(e) {
        var getActive = $(e.target).attr("data-active");
        $(e.target).addClass("active");
        $(e.target).siblings().removeClass("active");
        if (getActive == "yearly-active" && !$("#pricing-card-deck").hasClass(getActive)) {
            $("#pricing-card-deck").addClass(getActive);
				$("#pricing-card-deck").removeClass("weekly-active");
            $("#pricing-card-deck").removeClass("monthly-active");
        }
		if (getActive == "weekly-active" && !$("#pricing-card-deck").hasClass(getActive)) {
			$("#pricing-card-deck").addClass(getActive);
			$("#pricing-card-deck").removeClass("monthly-active");
			$("#pricing-card-deck").removeClass("yearly-active");
			
		}
        if (getActive == "monthly-active" && !$("#pricing-card-deck").hasClass(getActive)) {
            $("#pricing-card-deck").addClass(getActive);
            $("#pricing-card-deck").removeClass("yearly-active");
			$("#pricing-card-deck").removeClass("weekly-active");
        }
    })
</script>
@endpush

