
@if(!empty($data))
<div class="actions text-center ">
           
                                                <a class="btn btn-sm bg-primary-light ml-2 mt-1 ml-2 text-left" title="View Cart " href="{{route('shop.products.cart')}}">
                                                    <i class="fas fa-eye"></i> 
                                                  
                                                </a>

                                                <a class="btn btn-sm bg-success-light mt-1 mr-2 text-right" title="Checkout " href="{{route('shop.products.checkout')}}">
                                                    <i class="fas fa-check"></i> 
                                                 
                                                </a>
                                               
                                            </div>
<hr>
<div class="">
@foreach($data as $row)

                                <div class="m-3  mt-0 text-left">
                                    <div class=" align-content-center">
                                        <a href="{{ route('shop.product.details',['id'=>encrypted_key($row->id,'encrypt')]) }}">
                                            @php
                           $image_url= \App\ProductImage::get_first_image($row->id)
                            @endphp
                               @if(file_exists(storage_path().'/shop/'.$image_url)  && !empty($image_url))
                               <img src="{{asset('storage')}}/shop/{{ $image_url}}" width="50px" height="50px"  alt="..."> 
                @else
                    <img src="{{asset('assets/img/course/c8.jpg')}}" width="50px" height="50px"  alt="">
                @endif
                
                 @php
$product=\App\ShopProduct::find($row->id);
            $domain_info=get_domain_user();
            @endphp
            <small>{{$row->qty}} x {{$row->price()}}</small>
                                        <p><strong>{{(strlen($product->title)<15) ? $product->title :(substr($product->title,0,15)."..")}}</strong> </p>
                                        </a>
                                          
                                    </div>

                              
                                </div>
                                
@endforeach
</div>
 <div class="mr-3">
     <hr>
     
     <p class="text-center">Sub Total: <strong class="text-center">{{$subtotal}}</strong></p>
<!--     <div class="actions text-center ">
           
                                                <a class="btn btn-sm bg-primary-light mt-1 ml-2 " title="View Cart " href="{{route('shop.products.cart')}}">
                                                    <i class="fas fa-eye"></i> View Cart
                                                  
                                                </a>

                                                <a class="btn btn-sm bg-success-light mt-1 ml-2 text-center" title="Checkout " href="{{route('shop.products.checkout')}}">
                                                    <i class="fas fa-check"></i> Checkout
                                                 
                                                </a>
                                               
                                            </div>-->
                                
                            </div>
@else
 <div class="ps-cart__footer">
 
                                <p class="text-center">Empty Cart</p>
                                 <hr>
                            </div>

@endif
  