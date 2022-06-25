@extends('layouts.admin')
@section('title')
{{$title}}
@endsection

@push('theme-script')

@endpush

@section('content')
<div class="row">


    {{--Main Part--}}
    <div class="col-lg-12 order-lg-1">
        <div id="tabs-1" class="tabs-card">
            <div class="card">

                <div class="card-body">

                    <div class="container-fliud">
                        <div class="wrapper row">
                            <div class="preview col-md-6">
                                @if(!empty($img_collection))

                                <div class="preview-pic tab-content">
                                    @foreach($img_collection as $index => $images)
                                    <div class="tab-pane {{ $index==0 ? "active":'' }}" id="pic-{{ $images->id }}"><img src="{{asset('storage/shop')}}/{{ $images->img_url }}"  /></div>
                                    @endforeach
                                </div>
                                <ul class="preview-thumbnail nav nav-tabs">
                                    @foreach($img_collection as $index => $images)
                                    <li class="{{ $index==0 ? "active":'' }}"><a data-target="#pic-{{ $images->id }}" data-toggle="tab"><img src="{{asset('storage/shop')}}/{{ $images->img_url }}" /></a></li>
                                    @endforeach

                                </ul>
                                @endif
                            </div>
                            <div class="details col-md-6">
                                <h3 class="product-title">{{ !empty($product->title) ? $product->title : ""}}
                                    <span class="badge badge-sm badge-dot mr-4">
                                        <i class="@if($product->stock_status == 1) badge-success @else badge-warning @endif"></i>
                                        {{ \App\ShopProduct::stock_status($product->stock_status) }}
                                    </span>
                                </h3>
                                <div class="rating">
                                    <label>
                                        @if(!empty($categories))
                                        @foreach($categories as $category)
                                        <span class="badge badge-pill badge-sm badge-warning">{{ $category->name }}</span> &nbsp;
                                        @endforeach
                                        @endif
                                    </label>
                                </div>
                                <p class="product-description">{!! html_entity_decode($product->description, ENT_QUOTES, 'UTF-8') !!} </p>
                                <p class="product-description">{{!empty($product->tags) ? $product->tags :''}}</p>

                                <p ><strong>SKU:</strong> {{!empty($product->sku) ? $product->sku :''}}
                                    , <strong>Type:</strong> {{!empty($product->type) ? $product->type :''}}<strong></strong></p>
                                <h6 class="price">current price: <span>${{!empty($product->special_price) ? number_format($product->special_price, 2) :'0.00'}} <strike>{{number_format($product->price, 2)}}</strike></span></h6>
                                
                                @if(!empty($product->brand)) 
                                  <h6 class="sizes">Brand:
                                </h6>
                                
                             <p>
                                @foreach(\App\ProductBrand::get_brand(!empty($product->id) ? $product->id :'') as $brand)
                    @if(!empty($product->brand) && $brand->id==$product->brand)
                    <span class="badge" data-toggle="tooltip" title="{{ $brand->title }}">{{ $brand->title }}</span>
                                                         
                             
                    @endif
                    @endforeach
                            </p>     
                                
                       @endif
                                @if(!empty($specification))   

                                <h6 class="sizes">Specifications:
                                </h6>
                                <p>
                                    @foreach($specification as $_specification)
                                    <span class="badge" data-toggle="tooltip" title="{{$_specification->title}}">{{$_specification->title}} : {{$_specification->value}}</span>
                                    @endforeach
                                </p>
                                @endif
                                
                                       {{ Form::open(['route' => 'shop.placeorder','name' => 'new_input_form','id' => 'new_input_form','enctype' => 'multipart/form-data']) }}
                    <input type="hidden" name="id" value="{{!empty($product->id) ? encrypted_key($product->id,'encrypt') :0}}" />
                    <input type="hidden" name="csrf-token" value="<?= csrf_token(); ?>" />
                    @if($product->user_id !=Auth::user()->id) 
                                <div class="action">
                                    <input type="number" class="add-to-cart btn  border-dark btn-sm "  name="quantity" value="1" min="1" max="{{!empty($product->quantity) ? $product->quantity :1}}"  placeholder="Quantity" required>
                                    <button type="submit" class="add-to-cart btn btn-primary btn-sm  " type="button">Buy Now</button>
                                    

                                </div>
                    @endif
                        {{ Form::close() }}
                            </div>
                            <div class="wrapper row mt-5">
                                <div class="details col-md-12">
                                    <p class="vote"><strong>Vendor Details: </strong>{!! html_entity_decode($product->vendor, ENT_QUOTES, 'UTF-8') !!}  </p>
                                    
                                    <p class="vote"><strong>Refund Disclaimer: </strong> {{ !empty($product->refund_disclaimer) ? strip_tags($product->refund_disclaimer) :'' }}</p>
                                
                                    @if(!empty($shipping_options))   

                                    <strong>Shipping Options:
                                    </strong>
                                    <p class="mt-2">
                                        @foreach($shipping_options as $option)
                                        <img src="{{ asset('assets/img/shipping/'.$option.'.png') }}" width="50" height="50" alt="{{ $option }}" title="{{ $option }}" style="margin-right:10px;">

                                        @endforeach
                                    </p>
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
@endsection

@push('script')
<link rel="stylesheet" type="text/css" href="{{ asset('assets/css/simcify.min.css') }}">
<script src="{{ asset('assets/js/simcify.min.js') }}"></script>
@endpush

<style>
    /*****************globals*************/
    body {
        font-family: 'open sans';
        overflow-x: hidden; }

    img {
        max-width: 100%; }

    .preview {
        display: -webkit-box;
        display: -webkit-flex;
        display: -ms-flexbox;
        display: flex;
        -webkit-box-orient: vertical;
        -webkit-box-direction: normal;
        -webkit-flex-direction: column;
        -ms-flex-direction: column;
        flex-direction: column; }
    @media screen and (max-width: 996px) {
        .preview {
            margin-bottom: 20px; } }

    .preview-pic {
        -webkit-box-flex: 1;
        -webkit-flex-grow: 1;
        -ms-flex-positive: 1;
        flex-grow: 1; }

    .preview-thumbnail.nav-tabs {
        border: none;
        margin-top: 15px; }
    .preview-thumbnail.nav-tabs li {
        width: 18%;
        margin-right: 2.5%; }
    .preview-thumbnail.nav-tabs li img {
        max-width: 100%;
        display: block; }
    .preview-thumbnail.nav-tabs li a {
        padding: 0;
        margin: 0; }
    .preview-thumbnail.nav-tabs li:last-of-type {
        margin-right: 0; }

    .tab-content {
        overflow: hidden; }
    .tab-content img {
        width: 100%;
        -webkit-animation-name: opacity;
        animation-name: opacity;
        -webkit-animation-duration: .3s;
        animation-duration: .3s; }

    .card {
        margin-top: 50px;
        background: #eee;
        padding: 3em;
        line-height: 1.5em; }

    @media screen and (min-width: 997px) {
        .wrapper {
            display: -webkit-box;
            display: -webkit-flex;
            display: -ms-flexbox;
            display: flex; } }

    .details {
        display: -webkit-box;
        display: -webkit-flex;
        display: -ms-flexbox;
        display: flex;
        -webkit-box-orient: vertical;
        -webkit-box-direction: normal;
        -webkit-flex-direction: column;
        -ms-flex-direction: column;
        flex-direction: column; }

    .colors {
        -webkit-box-flex: 1;
        -webkit-flex-grow: 1;
        -ms-flex-positive: 1;
        flex-grow: 1; }

    .product-title, .price, .sizes, .colors {
        text-transform: UPPERCASE;
        font-weight: bold; }

    .checked, .price span {
        color: #ff9f1a; }

    .product-title, .rating, .product-description, .price, .vote, .sizes {
        margin-bottom: 15px; }

    .product-title {
        margin-top: 0; }

    .size {
        margin-right: 10px; }
    .size:first-of-type {
        margin-left: 40px; }

    .color {
        display: inline-block;
        vertical-align: middle;
        margin-right: 10px;
        height: 2em;
        width: 2em;
        border-radius: 2px; }
    .color:first-of-type {
        margin-left: 20px; }

    
    .not-available {
        text-align: center;
        line-height: 2em; }
    .not-available:before {
        font-family: fontawesome;
        content: "\f00d";
        color: #fff; }

    .orange {
        background: #ff9f1a; }

    .green {
        background: #85ad00; }

    .blue {
        background: #0076ad; }

    .tooltip-inner {
        padding: 1.3em; }

    @-webkit-keyframes opacity {
        0% {
            opacity: 0;
            -webkit-transform: scale(3);
            transform: scale(3); }
        100% {
            opacity: 1;
            -webkit-transform: scale(1);
            transform: scale(1); } }

    @keyframes opacity {
        0% {
            opacity: 0;
            -webkit-transform: scale(3);
            transform: scale(3); }
        100% {
            opacity: 1;
            -webkit-transform: scale(1);
            transform: scale(1); } }

    /*# sourceMappingURL=style.css.map */
</style>