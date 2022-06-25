<?php $page = "Stripe"; ?>
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
          
       <a  class="btn btn-sm btn btn-primary float-right ml-2 " href="{{ route('shop.index') }}"  >
        <span class="btn-inner--icon"><i class="fa fa-reply"></i></span> 
    </a>
                   
                     </div>
                
   <!-- Breadcrumb -->
                <div class="breadcrumb-bar mb-3">
                    <div class="container-fluid">
                        <div class="row align-items-center">
                            <div class="col-md-12 col-12">
                                <h2 class="breadcrumb-title">Stripe Integration</h2>
                                <nav aria-label="breadcrumb" class="page-breadcrumb">
                                    <ol class="breadcrumb">
                                        <li class="breadcrumb-item"><a href="{{route('dashboard')}}">Dashboard</a></li>
                                        <li class="breadcrumb-item"><a href="{{route('shop.dashboard')}}">Shop Dashboard</a></li>
                                        <li class="breadcrumb-item active" aria-current="page">Stripe Integration</li>
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
              
              <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                                <h5>{{__('Do you want to sale your products on ')}}<a class="text-danger" target="_blank" href="{{route('marketplace.home')}}">{{__('Market Place')}}</a>?</h5>
                                <small><b>{{__('Integrate your account with stripe: ')}}</b>{{__('Connected account represents the business setting up their Internet store. If you want to sale your products on ')}}<a target="_blank" href="{{route('marketplace.home')}}">{{__('Market Place')}}</a> {{__('then you need to connect your account with stripe and setup your business information. Your connected stripe account will be credited after successfull sales on market place.')}}</small>
                                <h6 class="mt-2">{{__('What you need to do?')}}</h6>
                                <small>{{__('Just click on connect button and provide your stripe account information along with business details to get payout of your sales. After successfully integration with stripe you need to click on confirmation by verifying integration. ')}}</small>
                                <div class="text-right btn-group mt-2 custom-control">
                                    @if(empty(Auth::user()->connected_stripe_account_id))
                                    <a href="{{route('stripe.connect.auth')}}"  class=" btn btn-xs btn-primary rounded-pill">{{__('Connect With Stripe')}}</a>
                                    @else
                                      <a href="{{route('stripe.connect.auth')}}"  class=" disabled btn btn-xs btn-success rounded-pill">{{__('Integrated With Stripe')}}</a>
                                    
                                    @if(empty(Auth::user()->connected_stripe_account_verification))
                                     <a href="{{route('stripe.connect.auth')}}"  class=" btn btn-xs btn-info rounded-pill">{{__('Verify Stripe Integration')}}</a>
                                     @else
                                   <a target="_blank" href="{{route('stripe.login.auth')}}"  class=" btn btn-xs btn-primary rounded-pill">{{__('Stripe Dashboard')}}</a>
                                   
                                    @endif
                                   @endif
                                   
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

@endpush


