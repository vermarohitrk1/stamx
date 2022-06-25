<?php $page = "Details"; ?>
@extends('layout.dashboardlayout')
@section('content')	

@php
$user=Auth::user();
$permissions=permissions();
$row=$product;
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
<div class="btn-group float-right " >
  <button  type="button" class="ml-2 btn btn-primary dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
    <i class="fa fa-shopping-cart"></i> <sup class="text-warning cart_header_content_count" >0</sup>
  </button> 
                        <div class="dropdown-menu cart_header_content " style="height: 300px !important;  overflow-y: scroll !important;">
             
  </div>
</div>
                    <a  class="btn btn-sm btn btn-primary float-right ml-2 " href="{{ route('shop') }}"  >
                        <span class="btn-inner--icon"><i class="fa fa-shopping-cart"></i></span> {{__('Shop')}}
                    </a> 
                    <a  class="btn btn-sm btn btn-primary float-right ml-2 " href="{{ route('shop.dashboard') }}"  >
                        <span class="btn-inner--icon"><i class="fa fa-reply"></i></span> 
                    </a>          


                </div>

                <!-- Breadcrumb -->
                <div class="breadcrumb-bar mb-3">
                    <div class="container-fluid">
                        <div class="row align-items-center">
                            <div class="col-md-12 col-12">
                                <h2 class="breadcrumb-title">Product Details</h2>
                                <nav aria-label="breadcrumb" class="page-breadcrumb">
                                    <ol class="breadcrumb">
                                        <li class="breadcrumb-item"><a href="{{route('dashboard')}}">Dashboard</a></li>
                                        <li class="breadcrumb-item"><a href="{{route('shop.dashboard')}}">Shop Dashboard</a></li>
                                        <li class="breadcrumb-item active" aria-current="page">Product Details</li>
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


                                <div class="col-lg-12 col-md-12 col-sm-12 d-flex flex-wrap">
                                    <div class="popular-course">
                                        <div class="courses-head">
                                            <div class="courses-img-main">
                                                @php
                                                $image_url= \App\ProductImage::get_first_image($row->id)
                                                @endphp
                                                @if(file_exists(storage_path().'/shop/'.$image_url)  && !empty($image_url))
                                                <img src="{{asset('storage')}}/shop/{{ $image_url}}" alt="" class="img-fluid w-100">
                                                @else
                                                <img src="{{asset('assets/img/course/c8.jpg')}}" alt="" class="img-fluid w-100">
                                                @endif

                                            </div>

                                            <div class="courses-aut-img">
                                                <a  onclick="product_add_cart({{$row->id}})" href="javascript:void(0)" title="Add To Cart"><span  class="h6 w-80 mx-auto px-4 py-1 rounded-bottom bg-primary text-white"> <i class="fa fa-cart-plus"></i></span></a>
                                            </div>
                                        </div>
                                        <div class="courses-body">
                                            <div class="courses-ratings">
                                                <ul class="mb-1">
                                                    @for($i=1;$i<=5;$i++)
                                                    <li>	<i class="fas fa-star @if((!empty((int) $row->rating) && $i<= (int) $row->rating)) checked @else not-checked @endif "></i> 
                                                    </li>
                                                    @endfor

                                                </ul>
                                                <p class="mb-1"><a title="{{__('Category ')}}" href="#">({{ \App\ProductCategory::first_category($row->id) }}) </a></p>
                                                <h4 class="mb-0"><a  href="#">{{$row->title??'' }}</a></h4>
                                            </div>
                                        </div>
                                        <div class="courses-border"></div>
                                        <div class="courses-footer d-flex align-items-center">
                                            <div class="courses-count">

                                                <div class="tab-pane show active" id="mentee-list">
                                                    <!--<h4>Payment Methods</h4>-->
                                                    <div class="content container-fluid">

                                                        <!-- Tab Menu -->
                                                        <nav class="user-tabs mb-4 custom-tab-scroll">
                                                            <ul class="nav nav-tabs nav-tabs-bottom nav-justified">
                                                                <li>
                                                                    <a class="nav-link active" href="#tab-1" data-toggle="tab">Description</a>
                                                                </li>
                                                                <li>
                                                                    <a class="nav-link" href="#tab-2" data-toggle="tab">Specification</a>
                                                                </li>
                                                                <li>
                                                                    <a class="nav-link" href="#tab-3" data-toggle="tab">Vendor</a>
                                                                </li>
                                                                <li>
                                                                    <a class="nav-link" href="#tab-4" data-toggle="tab">Reviews</a>
                                                                </li>
                                                                <li>
                                                                    <a class="nav-link" href="#tab-5" data-toggle="tab">Refund Disclaimer</a>
                                                                </li>
                                                                <li>
                                                                    <a class="nav-link" href="#tab-6" data-toggle="tab">Shipping Options</a>
                                                                </li>
                                                                <li>
                                                                    <a class="nav-link" href="#tab-7" data-toggle="tab">FAQs</a>
                                                                </li>


                                                            </ul>
                                                        </nav>
                                                        <!-- /Tab Menu -->

                                                        <!-- Tab Content -->
                                                        <div class="tab-content">

                                                            <div role="tabpanel" id="tab-1" class="tab-pane fade show active">
                                                                <h6 class="ps-product__price"><b>Price </b>
     @if(!empty($product->special_price))   
                              
                                    
                                {{ format_price($product->special_price) }} 
                                <del>{{ format_price($product->price) }}</del>                                  
                                @else
                               {{ format_price($product->price) }}
                                @endif
                             
                                
                                @if(!empty($product->current_deal_off))
                                 <p class="ps-product__price text-danger">{{$product->current_deal_off}}% off on current deal</p>
                                 @endif
</h6>
                        
                        <div class="ps-product__specification ">
                            <p><strong>SKU:</strong> {{$product->sku??''}}</p>
                            
                            
                        </div>
                        @if(!empty($product->tags))
                            <p class="tags "><strong> Tags:  </strong>
@foreach(explode(",",$product->tags) as $tag)
<a href="#">{{$tag}}</a>,
 @endforeach
</p>
                            @endif
                        
                                                                
                                                                
                                                                
                                                                
                                                                <p class="mt-2">
                                                                {!! html_entity_decode($product->description, ENT_QUOTES, 'UTF-8') !!}
                                                                </p>
                                                                <div class="ps-product__desc float-right">
   @php
            $domain_info=\App\User::find($product->user_id);
            @endphp
                            <p>Sold By: <a href="{{$domain_info['url']??'#'}}"><strong> {{$domain_info->company??''}}</strong></a></p>
                            
                        </div>
                                                                
                                                                <div class="ps-product__sharing mt-5 "  id="share">
                       
                           
                      
                          </div>
                                                            </div>
                                                            <div role="tabpanel" id="tab-2" class="tab-pane fade show ">
                                                                <div class="table-responsive">
                                            <table class="table table-bordered ps-table ps-table--specification">
                                                <tbody>
                                                    @if(!empty($specification))
                            @foreach ($specification as $_specification)
                                         <tr>
                                                        <td>{{$_specification->title}}</td>
                                                        <td>{{$_specification->value}}</td>
                                                    </tr>
                                                    
                            @endforeach
                                              @endif
                                                   
                                                </tbody>
                                            </table>
                                        </div>
                                                            </div>
                                                            <div role="tabpanel" id="tab-3" class="tab-pane fade show ">
                                                                  {!! html_entity_decode($product->vendor, ENT_QUOTES, 'UTF-8') !!}
                                                            </div>
                                                            <div role="tabpanel" id="tab-4" class="tab-pane fade show ">
                                                                <div class="row">
                                            <div class="col-xl-5 col-lg-5 col-md-12 col-sm-12 col-12 ">
                                                <div class="ps-block--average-rating">
                                                    <div class="courses-ratings">
                                                        @php
                                                        $total_rev=\App\ShopProductRating::ratingCounts($product->id);
                                                        @endphp
                                                        <h3>{{$product->rating}}.00 <small class="text-xs">({{$total_rev }} {{$total_rev==1?"Review":"Reviews"}})</small></h3>
                                                           @if(!empty($product->rating))
                                                           
                                                           
                                                           
                                                           <ul class="mb-1">
                                                    @for($i=1;$i<=5;$i++)
                                                    <li>	<i class="fas fa-star @if((!empty((int) $row->rating) && $i<= (int) $row->rating)) checked @else not-checked @endif "></i> 
                                                    </li>
                                                    @endfor

                                                </ul>
                                                           
                                                           
                                                           
                                                           
                                                           @else
                                                           <ul class="mb-1">
                                                            @for($j=1;$j<=5;$j++)
                                        
                                                  
                                                    <li>	<i class="fas fa-star "></i> 
                                                    </li>
                                             

                                               
                                        @endfor
                                         </ul>
                                                           @endif
                                                           
                                                           
                                                           
                                                           
                                                
                                           </div>
                                                    
                                                    
                                                    
                                                    
                                                      @php
                            $ratingusers=\App\ShopProductRating::ratingusers($product->id);
                            @endphp
                            @foreach($ratingusers as $i=>$rating_percentage)
                           <div class=" col-12 form-group__rating">
                            <span class="mt-1 ">{{$i}} Star</span>
                            <div class="progress">
                                
                           <div class="progress-bar bg-success" role="progressbar" style="width: {{$rating_percentage}}%;" aria-valuenow="{{$rating_percentage}}" aria-valuemin="0" aria-valuemax="100">{{$rating_percentage}}%</div>
                          </div>
                           </div>
                         
                            
                            @endforeach
                                                    
                                                </div>
                                            </div>
                                            <div class="col-xl-7 col-lg-7 col-md-12 col-sm-12 col-12 ">
                                                @if (!count($reviews))
                                    <div class="mt-3">
                                        <p class="text-muted font-italic p-3 bg-light rounded">It's empty here, be first to submit review</p>
                                    </div>
                                @else
                                    <ul class="media-list list-unstyled mb-0">
                                        @foreach ($reviews as $review)
                                        @php
                                        $revuser=\App\User::find($review->user_id);
                                        @endphp
                                            <li class="mt-2">
                                                <div class="d-flex justify-content-between">
                                                    <div class="media align-items-center">
                                                        <a class="pr-3" href="#">
                                                            <img src="{{$revuser->getAvatarUrl()}}" height="40" width="40" class="img-fluid avatar avatar-md-sm rounded-circle shadow" alt="img">
                                                        </a>
                                                        <div class="commentor-detail">
                                                            <h6 class="mb-0"><a href="javascript:void(0)" class="media-heading text-dark">{{$revuser->name}}</a></h6>
                                                          
                                                            <small class="text-muted">
                                                                {{ date('jS F, Y', strtotime($review->created_at)) }} at
                                                                {{ date('h:i a', strtotime($review->created_at)) }}
                                                            </small>
                                                        </div>
                                                    </div>
                                                    {{-- <a href="#" class="text-muted"><i class="mdi mdi-reply"></i> Reply</a> --}}
                                                </div>
                                                <div class="mt-3">
                                                <p class="text-muted font-italic p-3 bg-light rounded">"{{$review->comment}}"</p>
                                                </div>
                                            </li>
                                        @endforeach
                                    </ul>
                                @endif
                                        @if(empty($user_rating))        
                                <form class="ps-form--review" id="review_form" action="#" method="post">
                                                    <h4>Submit Your Review</h4>
                                                    
                                                    <div class="form-group form-group__rating">
                                                        <label>Your rating of this product</label>
                                                        <select class="ps-rating" data-read-only="false" id="user_rating" name="user_rating" required>
                                                            <option selected value="1">1</option>
                                                            <option value="2">2</option>
                                                            <option value="3">3</option>
                                                            <option value="4">4</option>
                                                            <option value="5">5</option>
                                                        </select>
                                                    </div>
                                                    <div class="form-group">
                                                        <textarea class="form-control" required minlength="10" id="user_remarks" name="user_remarks" rows="6" placeholder="Write your review here"></textarea>
                                                    </div>
                                                    
                                                    <div class="form-group submit">
                                                        <button class="ps-btn">Submit Review</button>
                                                    </div>
                                                </form>
                                        @endif
                                                
                                            </div>
                                        </div>
                                                            </div>
                                                            <div role="tabpanel" id="tab-5" class="tab-pane fade show ">
                                                                 <div class="ps-block--questions-answers">
                                           
                                            <p>{{ !empty($product->refund_disclaimer) ? strip_tags($product->refund_disclaimer) :'' }}</p>
                                        </div>
                                                            </div>
                                                            <div role="tabpanel" id="tab-6" class="tab-pane fade show ">
                                                                <p class="font-size-4 text-black-2 mb-7">
                                            @if(!empty($shipping_options))
                                        @foreach($shipping_options as $option)
                                        <img src="{{ asset('assets/img/shipping/'.$option.'.png') }}" width="200px" height="200px" alt="{{ $option }}" title="{{ $option }}" style="margin-right:10px;">

                                        @endforeach
                                        @endif
                                    </p>
                                                            </div>
                                                            <div role="tabpanel" id="tab-7" class="tab-pane fade show ">
                                                                <p class="font-size-4 text-black-2 mb-7">
                      {!! html_entity_decode($product->faqs, ENT_QUOTES, 'UTF-8') !!}
                                    </p>
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
<style>
    .jssocials-share i.fa {
        font-family: "Font Awesome 5 Brands";
    }
    .jssocials-share-label {
        padding-left: .0em;
        vertical-align: middle;
    }
    .jssocials-shares {
        margin: 1em 0;
        font-size: 13px;
    }
</style>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jsSocials/1.5.0/jssocials-theme-flat.min.css" integrity="sha256-1Ru5Z8TdPbdIa14P4fikNRt9lpUHxhsaPgJqVFDS92U=" crossorigin="anonymous" />
<script src="https://cdnjs.cloudflare.com/ajax/libs/jsSocials/1.5.0/jssocials.min.js" integrity="sha256-QhF/xll4pV2gDRtAJ1lvi9YINqySpAP+0NIzIX5voZw=" crossorigin="anonymous"></script>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jsSocials/1.5.0/jssocials.min.css" integrity="sha256-1tuEbDCHX3d1WHIyyRhG9D9zsoaQpu1tpd5lPqdqC8s=" crossorigin="anonymous" />
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.10.2/css/all.min.css" integrity="sha256-zmfNZmXoNWBMemUOo1XUGFfc0ihGGLYdgtJS3KCr/l0=" crossorigin="anonymous" />
<script>
$(document).ready(function () {
    $("#share").jsSocials({
        shares: ["twitter", "facebook", "linkedin", "pinterest", "whatsapp"],
        showCount: false,
         showLabel: false,
    text: "{{$product->title}}"
    });


    $(".product_tabs_menu").click(function() {
    $('.product_tabs_menu').removeClass('active');
    $(this).addClass("active");
     $('html,body').animate({
        scrollTop: $("#product_tabs_body").offset().top},
        'slow');
});

   $('#review_form' ).on( 'submit', function(e) {
        e.preventDefault();

        var rating = $("#user_rating").val();
        var reviews = $("#user_remarks").val();
           var data = {
                rating: rating,
                review:reviews,
                product:{{$product->id}},
                _token: "{{ csrf_token() }}"
            }
             $.post(
                "{{route('shop.product.review.post')}}",
                data,
                function (res) {
                   if(res.success==true){
                       $("#review_form").hide();
                toastr.success(res.message, "Done!", {timeOut: null, closeButton: true});
            
                    }else{
                         toastr.error(res.message, "Oops!", {timeOut: null, closeButton: true});                   
                    }
                }
        );


    }); 

});
function update_cart_quantity(q=0){
    var max={{$product->quantity}};
    var quantity=$("#selected_quantity").val();
    if(q=="plus"){
        if(quantity < max){
           $("#selected_quantity").val(parseInt(quantity)+1) ;
        }
        
    }else{
        if(quantity >1){
           $("#selected_quantity").val(quantity-1) ;
        }
    }
    
}

$(function () {
         product_add_cart();
        
    });
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


