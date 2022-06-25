@if($data->count() > 0)

<div class="row">
    <!--<div class="row justify-content-center">-->
    @foreach($data as $row)
    <div class="col-lg-3 col-md-6 col-sm-12 d-flex flex-wrap">
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
                    <a  onclick="product_add_cart({{$row->id}})" href="javascript:void(0)" title="Add To Cart"><span  class="h6 w-60 mx-auto px-4 py-1 rounded-bottom bg-primary text-white"> <i class="fa fa-cart-plus"></i></span></a>
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
                    <p class="mb-1"><a title="{{__('Category ')}}" href="{{ route('shop.product.details',['id'=>encrypted_key($row->id,'encrypt')]) }}">({{ \App\ProductCategory::first_category($row->id) }}) </a></p>
                    <h4 class="mb-0"><a title="{{__('View Details')}}" href="{{ route('shop.product.details',['id'=>encrypted_key($row->id,'encrypt')]) }}">{{(strlen($row->title)<15) ? $row->title :(substr($row->title,0,15)."..")}}</a></h4>
                </div>
            </div>
            <div class="courses-border"></div>
            <div class="courses-footer d-flex align-items-center">
                <div class="courses-count">
                    <ul class="mb-0">
                      
                                                        <li><a href="javascript:void(0)"  title="Quick View" data-url="{{ route('shop.product.quick.view') }}?id={{$row->id}}" data-ajax-popup="true" data-size="lg" data-title="{{__('Product Details')}}" ><i class="fa fa-eye"></i></a></li>
                    </ul>
                </div>
                <div class="courses-amt ml-auto">
                    <h3 class="mb-0 text-sm">
                        @if(!empty($row->special_price))
                ${{$row->special_price}} / <strike>${{$row->price}}</strike>
                @elseif(!empty($row->price))
                ${{$row->price}}
                @else
                Free
                @endif
                    </h3>
                </div>
            </div>
        </div>
    </div>




    @endforeach
</div>
<div class=" col-md-12 d-flex justify-content-center paginationCss">
    {{ $data->appends(request()->except('page'))->links() }}

</div>

@else
<div class="text-center errorSection">
    <h3>No Product Found</h3>
</div>
@endif

