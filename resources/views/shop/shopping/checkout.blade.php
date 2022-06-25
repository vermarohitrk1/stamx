<?php $page = "Checkout"; ?>
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
                                <h2 class="breadcrumb-title">Checkout</h2>
                                <nav aria-label="breadcrumb" class="page-breadcrumb">
                                    <ol class="breadcrumb">
                                        <li class="breadcrumb-item"><a href="{{route('dashboard')}}">Dashboard</a></li>
                                        <li class="breadcrumb-item"><a href="{{route('shop.dashboard')}}">Shop Dashboard</a></li>
                                        <li class="breadcrumb-item active" aria-current="page">Checkout</li>
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
              <form class="ps-form--checkout" action="{{route('shop.products.payment')}}" method="post" >
              <div class="row">
                    <div class="col-xl-8 col-lg-8 col-md-12 col-sm-12 col-12 ">
                   <div class="ps-form__billing-info">
                                    <h3 class="ps-form__heading">Billing Details</h3>
                                    
                                    
                                     {{ csrf_field() }}
                                     <div class="form-group">
                                        <label>Purchase For (Self/Dropship)<sup>*</sup>
                                        </label>
                                        <div class="form-group__content ">
                                              <select class="form-control " name="user" id="suser"  required="">
                                                  <option value="{{ Auth::user()->id }}">{{ ucwords(Auth::user()->name)." (".ucwords(Auth::user()->type).")" }} </option>
                                                  @php
                                                  $domain=get_domain_user();
                                                  $users=\App\User::where('created_by',Auth::user()->id)->get();
                                                  @endphp
                                                   @if(!empty($users) && count($users) > 0)
                                @foreach($users as $index => $row)
                                    <option value="{{ $row->id }}">{{ ucwords($row->name)." (".ucwords($row->type).")" }} </option>
                                    @endforeach
                                    @endif
                                </select>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label>Name<sup>*</sup>
                                        </label>
                                        <div class="form-group__content ">
                                            <input readonly class="form-control " id="sname" value="{{Auth::user()->name}}" type="text">
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label>Company Name<sup>*</sup>
                                        </label>
                                        <div class="form-group__content">
                                            <input readonly value="{{Auth::user()->company}}" id="scompany"  class="form-control" type="text">
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label>Email Address<sup>*</sup>
                                        </label>
                                        <div class="form-group__content">
                                            <input readonly value="{{Auth::user()->email}}" id="semail"  class="form-control" type="email">
                                        </div>
                                    </div>
                                    
                                    <div class="form-group">
                                        <label>Phone<sup>*</sup>
                                        </label>
                                        <div class="form-group__content">
                                            <input readonly value="{{Auth::user()->mobile}}" id="smobile"  class="form-control" type="text">
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label>Billing Address<sup>*</sup>
                                        </label>
                                        <div class="form-group__content">
                                            <input readonly value="{{Auth::user()->address1}}" id="saddress"  class="form-control" type="text">
                                        </div>
                                    </div>
                                        <div class="form-group" id="sprofileupdate" >
                                        <div class="">
                                            <label for="cb01">Click here to update your profile <a class="text-primary" href="{{route("profile-settings")}}">Update</a></label>
                                        </div>
                                    </div>
                                    <h3 class="mt-40"> Addition information</h3>
                                    <div class="form-group">
                                        <label>Order Notes</label>
                                        <div class="form-group__content">
                                            <textarea class="form-control" required name="order_note" rows="7" placeholder="Notes about your order, e.g. special notes for delivery or change of billing address"></textarea>
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
                            </div><button class="btn btn-primary float-right" type="submit" >Proceed To Payment</button>
                        </div>
                        </div>
                  </form>
              
              
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

<script>
     $(function () {
   $('.remove_cart_item').click(function(e){
    $("#row-"+$(this).data('id')).hide();
});
      
   $('#suser').change(function(e){
  
    $.post({
                url: '{{ route('getUserinfo') }}',
                data: {id:$(this).val(), _token: "{{ csrf_token() }}"},
           
                success: function (data) {
                    var data=$.parseJSON(data);
                  $("#sname").val(data.name);
                  $("#scompany").val(data.company);
                  $("#semail").val(data.email);
                  $("#smobile").val(data.mobile);
                  $("#saddress").val(data.address1);
                $("#sprofileupdate").hide();
                }
            });
});
      
    });
   
function update_cart_quantity(q=0,r=0,max=0){
    var quantity=$("#selected_quantity_"+r).val();
    if(q=="plus"){
        if(quantity < max){
            var newqty=parseInt(quantity)+1;
           $("#selected_quantity_"+r).val(newqty) ;
           product_add_cart($("#item-hash-"+r).val(),'quantityupdate',newqty);
           $("#item_price_total_"+r).html("$"+$("#item_price_total_"+r).data("id")*newqty);
        }
        
    }else{
        if(quantity >1){
            var newqty=quantity-1;
           $("#selected_quantity_"+r).val(newqty) ;
           product_add_cart($("#item-hash-"+r).val(),'quantityupdate',newqty);
           $("#item_price_total_"+r).html("$"+$("#item_price_total_"+r).data("id")*newqty);
        }
    }
    
}
function product_add_cart(id=0,type=null,param=null){
    
   $.ajax({
    url: '{{route('shop.product.cart.add')}}',
    type: 'post',
      datatype: 'html',
     data: {_token: "{{ csrf_token() }}",id:id,type:type,param:param},
    success: function(res){ 
        $(".cart_header_content").html(res.html);
        $(".cart_header_content_count").html(res.count);
        if(id !=0){
              show_toastr('Done!', "Cart updated", 'success');
     
  }
    }
  });
 }
</script>

@endpush


