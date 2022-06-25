<?php $page = "Cart"; ?>
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
        <span class="btn-inner--icon"><i class="fa fa-circle"></i></span> 
    </a>
                   
                     </div>
                
   <!-- Breadcrumb -->
                <div class="breadcrumb-bar mb-3">
                    <div class="container-fluid">
                        <div class="row align-items-center">
                            <div class="col-md-12 col-12">
                                <h2 class="breadcrumb-title">Shopping Cart</h2>
                                <nav aria-label="breadcrumb" class="page-breadcrumb">
                                    <ol class="breadcrumb">
                                        <li class="breadcrumb-item"><a href="{{route('dashboard')}}">Dashboard</a></li>
                                        <li class="breadcrumb-item"><a href="{{route('shop.dashboard')}}">Shop Dashboard</a></li>
                                        <li class="breadcrumb-item active" aria-current="page">Shopping Cart</li>
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
                   <div class="table_md-responsive">
                  <table class="table table-hover table-center mb-0" id="example" style="width:100% !important">
                           <thead class="thead-light">
                                <tr>
                                    <th>Product name</th>
                                    <th>PRICE</th>
                                    <th>QUANTITY</th>
                                    <th>TOTAL</th>
                                    <th></th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($data as $row)
                                <tr id="row-{{$row->id}}">
                                    <td data-label="Product">
                                        <div class="ps-product--cart">
                                            <div class="ps-product__thumbnail"><a href="{{ route('shop.products.cart',['id'=>encrypted_key($row->id,'encrypt')]) }}">
                                                   @php
                           $image_url= \App\ProductImage::get_first_image($row->id)
                            @endphp
                               @if(file_exists(storage_path().'/shop/'.$image_url)  && !empty($image_url))
                               <img src="{{asset('storage')}}/shop/{{ $image_url}}" height="80px" width="80px" alt="..."> 
                @else
                    <img src="{{asset('assets/img/course/c8.jpg')}}" height="80px" width="80px" alt="">
                @endif
                                                </a></div>
                                            <div class="ps-product__content"><a href="{{ route('shop.products.cart',['id'=>encrypted_key($row->id,'encrypt')]) }}">{{$row->name}}</a>
                                                   @php
$product=\App\ShopProduct::find($row->id);
            $domain_info=get_domain_user();
            @endphp
            <!--<br><small>Sold By:<strong> <a  href="#">{{$domain_info->name??''}}</a></strong></small>-->
                                            </div>
                                        </div>
                                    </td>
                                    <td class="" data-label="Price">{{$row->price()}} @if(!empty($product->special_price))<strike>{{format_price($product->price)}}</strike>@endif 
                                     @if(!empty($product->current_deal_off))
                                     <br> <p class="ps-product__price text-danger">{{$product->current_deal_off}}% off on current deal</p>
                                 @endif
                                    </td>
                                    <td data-label="Quantity">
                                        <div class="btn-group">
                                           <button class="down" onclick="update_cart_quantity('minus',{{$row->id}},{{$product->quantity}})">-</button>
                                            <input  class=" text-center" name="quantity" id="selected_quantity_{{$row->id}}" type="number" placeholder="1" min="1" value="{{$row->qty}}" step="1" max="{{$product->quantity}}">
                                           <input type="hidden" id="item-hash-{{$row->id}}" value="{{$row->getHash()}}" />
                                            <button class="up " onclick="update_cart_quantity('plus',{{$row->id}},{{$product->quantity}})">+</button>
                                            
                                        </div>
                                    </td>
                                    <td data-label="Total" id="item_price_total_{{$row->id}}" data-id="{{$row->price(false)}}">{{$row->subTotal()}}</td>
                                    <td data-label="Actions"><a data-id='{{$row->id}}' class="remove_cart_item text-danger"  onclick="product_add_cart({{$row->id}},'remove','{{$row->getHash()}}')"   href="#"><i class="fa fa-trash-alt"></i></a></td>
                                </tr>
                                @endforeach
                                
                            </tbody>
                        </table>
                    </div>
                    </div>
                <div class="col-xl-4 col-lg-4 col-md-12 col-sm-12 col-12 ">
                            <div class="card ">
                                <div class="card-header bg-primary text-white">
                                    <!--<b>Subtotal <span> {{$subtotal_without_discount}}</span></b>-->
                                    <b>BILLING SUMMARY</b>
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
                            </div><a class="btn btn-primary float-right" href="{{route('shop.products.checkout')}}">Proceed to checkout</a>
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

<script>
     $(function () {
   $('.remove_cart_item').click(function(e){
    $("#row-"+$(this).data('id')).hide();
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


