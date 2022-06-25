<?php $page = "Wallet"; ?>
@section('title')
    {{$page??''}}
@endsection
@extends('layout.dashboardlayout')
@section('content')	
<style>
.modal-open .main-wrapper {
    -webkit-filter: blur(1px);
    -moz-filter: blur(1px);
    -o-filter: blur(1px);
    -ms-filter: blur(1px);
    filter: inherit;
}
 .hide {
        display: none !important;
    }

   #myModal_payment .panel-title.display-td {
            padding-top: 8px;
            padding-left: 7px;
            margin-right: 25px;
        }
        #myModal_payment #payment-form {
            padding: 0;
        }
  .element-box {
            padding: 0px 227px;
        }

        .col-md-4.priceBox {
            margin: 15px 0;
        }
</style>
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
        <a  class="btn btn-sm btn btn-primary float-right ml-2 " href="{{ route('wallet.deposit') }}"  title="{{__('Recharge With Stripe
        ')}}">
        <span class="btn-inner--icon"><i class="fa fa-plus"></i></span> Wallet Deposit
    </a>
                    
         <a href="#" class="btn btn-sm btn btn-primary float-right ml-2 " data-url="{{ route('wallet.transfer') }}" data-ajax-popup="true" data-size="md" data-title="{{__('Transfer Money
        ')}}">
        <span class="btn-inner--icon"><i class="fa fa-money-bill-alt"></i></span> Wallet Transfer
    </a>
                    
                   
                     </div>
                
   <!-- Breadcrumb -->
                <div class="breadcrumb-bar mb-3">
                    <div class="container-fluid">
                        <div class="row align-items-center">
                            <div class="col-md-12 col-12">
                                <h2 class="breadcrumb-title">Wallet Dashboard</h2>
                                <nav aria-label="breadcrumb" class="page-breadcrumb">
                                    <ol class="breadcrumb">
                                        <li class="breadcrumb-item"><a href="{{route('dashboard')}}">Dashboard</a></li>
                                        <li class="breadcrumb-item active" aria-current="page">Wallet Dashboard</li>
                                    </ol>
                                </nav>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- /Breadcrumb -->
                
   
    
        
    
      <div class="row blockWithFilter">
          <div class="col-md-12 col-lg-4 dash-board-list green">
                        <div class="dash-widget">
                            <div class="circle-bar">
                                <div class="icon-col">
                                    <i class="fa fa-dollar-sign"></i>
                                </div>
                            </div>
                            <div class="dash-widget-info">
                          
                                <h3 >{{ format_price($user->wallet_balance, 2) }} </h3>
                                <h6>Current Balance</h6>	
                                
                                
                            </div>
                        </div>
                    </div>
<!--          <div class="col-md-12 col-lg-3 dash-board-list yellow">
                        <div class="dash-widget">
                            <div class="circle-bar">
                                <div class="icon-col">
                                    <i class="fa fa-list"></i>
                                </div>
                            </div>
                            <div class="dash-widget-info">
                             
                                  <h3>{{number_format($total, 0)}}</h3>
                                <h6>Transactions</h6>															
                            </div>
                        </div>
                    </div>-->
                    <div class="col-md-12 col-lg-4 dash-board-list blue">
                        <div class="dash-widget">
                            <div class="circle-bar">
                                <div class="icon-col">
                                    <i class="fa fa-dollar-sign"></i>
                                </div>
                            </div>
                            <div class="dash-widget-info">
                             
                                  <h3 data-id="received">{{ format_price($received, 2) }} </h3>
                                <h6>Total Received</h6>															
                            </div>
                        </div>
                    </div>
                    
                    
                    <div class="col-md-12 col-lg-4 dash-board-list pink">
                        <div class="dash-widget">
                            <div class="circle-bar">
                                <div class="icon-col">
                                    <i class="fa fa-dollar-sign"></i>
                                </div>
                            </div>
                            <div class="dash-widget-info">
                          
                                <h3 data-id="paid">{{ format_price($paid, 2) }}</h3>
                                <h6>Total Paid</h6>	
                                
                                
                            </div>
                        </div>
                    </div>
     
                    
         
                    
                </div>
   

<div class="row mt-3" id="blog_category_view"  >
     
    
  <!-- list view -->
  <div class="col-12">
      <div class="card">
          <div class="card-body ">
              <form >
                        <div class="row">
                        <div class="form-group col-md-6  mb-2">
                           <div class="input-group input-group-sm input-group-merge input-group-flush">
            <div class="input-group-prepend">
                <span class="input-group-text bg-transparent"><i class="fas fa-search"></i></span>
            </div>
            <input type="text" id="support_keyword" class="form-control form-control-flush" placeholder="{{__('Search by name, description..')}}">
        </div>
                        </div>
                        <div class="form-group col-md-3  mb-2">
                          <label for="filter_type" class="sr-only">Transaction Filter</label>
                            <select id='filter_type' class="form-control" >
                                <option value="">All Transactions</option>
                                <option value="paid">Paid</option>
                                <option value="received">Received</option>
                                <option value="deposit">Self Deposit</option>
                                <option value="invoice">Invoice Paid</option>
                                <option value="invoicer">Invoice Received</option>
                                <option value="feer">Fee Received</option>
                                <option value="feep">Fee Paid</option>
                            </select>
                        </div>
                            
                        </div>
                                                   
                      </form>
              <div class="table_md-responsive">
                  <table class="table table-hover table-center mb-0" id="example" style="width:100% !important">
                     <thead class="thead-light">
                  <tr>
                                 <th > {{__('Transaction')}}</th>
                                 <th > {{__('Paid From')}}</th>
                            <th > {{__('Paid To')}}</th>
                            <th > {{__('Amount')}}</th>
                            <th > {{__('Type')}}</th>
                            <th > {{__('Date')}}</th>
                            <th > {{__('Description')}}</th>
                        </tr>
                      </thead>
                     
                  </table>
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
                <form role="form" action="{{route('strip_payment.backend')}}" method="post" class="require-validation"
                      data-cc-on-file="false"
                      data-stripe-publishable-key="{{env('STRIPE_KEY')}}"
                      id="payment-form">
                    {{ csrf_field() }}
                    <input type="hidden" name="itemId" id="itemId" value="">
                    <input type="hidden" name="itemType" id="itemType" value="">
                    <div style="display: none;" id="appendPrice"></div>
                    <div class='form-row row'>
                        <div class='col-xs-12 form-group required'>
                            <label class='control-label'>Name on Card</label> <input
                                class='form-control' size='80' type='text' required>
                        </div>
                    </div>
                    <div class='form-row row'>
                        <div class='col-xs-12 form-group card required'>
                            <label class='control-label'>Card Number</label> <input
                                autocomplete='off' class='form-control card-number' style="width: 455px;" size='16'
                                min="16"
                                type='number'>
                        </div>
                    </div>
                    <div class='form-row row'>
                        <div class='col-xs-12 col-md-4 form-group cvc required'>
                            <label class='control-label'>CVC</label>
                            <input autocomplete='off' class='form-control card-cvc' placeholder='ex. 311' size='4'
                                   type='number' required>
                        </div>
                        <div class='col-xs-12 col-md-4 form-group expiration required'>
                            <label class='control-label'>Expiration Month</label>
                            <input
                                class='form-control card-expiry-month' placeholder='MM' size='2'
                                type='number'>
                        </div>
                        <div class='col-xs-12 col-md-4 form-group expiration required'>
                            <label class='control-label'>Expiration Year</label>
                            <input
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
                    <div class="row d-flex justify-content-center">
                        <div class="col-xs-6 buttonCustom ">
                            <button class="btn btn-primary btn-sm btn-block " id="customer_payment" type="submit">Pay
                                Now ($180)
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
@push('script')
<script type="text/javascript" src="https://js.stripe.com/v2/"></script> 
<script type="text/javascript">



    $(function () {
        var table = $('#example').DataTable({
            processing: true,
            serverSide: true,
             "bFilter": false,
             ajax: {
                        url: "{{ route('wallet') }}",
                        data: function (d) {
                                d.filter_type = $('#filter_type').val()
                                d.filter_status = $('#filter_status').val()
                                d.filter_category = $('#filter_category').val()
                                d.keyword = $('#support_keyword').val()
                        }
                    },
            columns: [
//                {data: 'DT_RowIndex', name: 'DT_RowIndex', orderable: false, searchable: false},
                {data: 'transaction', name: 'transaction', orderable: false, searchable: true},
                {data: 'from', name: 'from', orderable: false, searchable: true},
                {data: 'to', name: 'to', orderable: false, searchable: true},
                {data: 'amount', name: 'amount', orderable: false, searchable: true},
                {data: 'type', name: 'type', orderable: false, searchable: true},
                {data: 'date', name: 'date', orderable: false, searchable: true},
                {data: 'description', name: 'description', orderable: false, searchable: true},
            ]
        });
        $('#filter_status').change(function(){
                    table.draw();
                });
        $('#filter_type').change(function(){
                    table.draw();
                });
        $('#filter_category').change(function(){
                    table.draw();
                });
                  $(document).on('keyup', '#support_keyword', function () {
            table.draw();
            });
    
        });
    jQuery(document).ready(function ($) {
            $('select[name=notify_attorney]').change(function () {
                // hide all optional elements
                $('#ifYes').css('display', 'none');
                $('#ifYess').css('display', 'none');
                var $name = $(this).val();
                if ($name === "Yes") {
                    $('#ifYes').css('display', 'block');
                    $('#ifYess').css('display', 'block');
                }
            });
        });
    </script>
	
   
   
@endpush


