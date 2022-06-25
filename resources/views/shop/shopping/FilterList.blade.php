@if($data->count() > 0)

@foreach($data as $row)

<!-- Mentor Widget -->
<div class="card">
    <div class="card-body">
        <div class="mentor-widget">
            <div class="user-info-left">
                <div class="mentor-img">
                    <a href="{{route('shop.product.details',["id"=>encrypted_key($row->id,"encrypt")])}}">
                            @php
                           $image_url= \App\ProductImage::get_first_image($row->id)
                            @endphp
                     @if(file_exists(storage_path().'/shop/'.$image_url)  && !empty($image_url))
                        <img src="{{asset('storage')}}/shop/{{ $image_url}}" alt="" class="img-fluid ">
                    @else
                    <img src="{{asset('assets/img/course/c8.jpg')}}" alt="" class="img-fluid">
                    @endif
                    
                               
                               
                        
                    </a>
                
                </div>
             
           
        
                <div class="user-info-cont">
                    <h4 class="usr-name"><a href="{{route('shop.product.details',["id"=>encrypted_key($row->id,"encrypt")])}}">{{$row->title}} </a></h4>
                    <p style="margin-bottom: 0px !important" class="mentor-type">{{ \App\ProductCategory::first_category($row->id) }}</p>
                    <div class="rating">
                    @for($i=1;$i<=5;$i++)
                        <i class="fas fa-star @if((!empty((int) $row->rating) && $i<= (int) $row->rating)) filled @else  @endif"></i>
                        @endfor
                    </div>
                    <div class="mentor-details"> 
                        <p class="user-location"> {!! html_entity_decode($row->description, ENT_QUOTES, 'UTF-8') !!}</p>
                    </div>
                </div>
            </div>
            <div class="user-info-right">
                <div class="user-infos">
                    <ul>
                        <li><i class="far fa-eye"></i> <a href="javascript:void(0)"  title="Quick View" data-url="{{ route('shop.product.quick.view') }}?id={{$row->id}}" data-ajax-popup="true" data-size="lg" data-title="{{__('Product Details')}}" >Quick View</a></li>
                        <li><i class="far fa-comment"></i> {{\App\ShopProductRating::ratingCounts($row->rating) }} Feedback</li>
                        <li><i class="fas fa-dollar-sign"></i>  @if(!empty($row->special_price))
                ${{$row->special_price}} / <strike>${{$row->price}}</strike>
                @elseif(!empty($row->price))
                ${{$row->price}}
                @else
                Free
                @endif</li>
                   
                        <!--<li><i class="far fa-money-bill-alt"></i> $300 - $1000 <i class="fas fa-info-circle" data-toggle="tooltip" title="Lorem Ipsum"></i> </li>-->
                    </ul>
                </div>
                <div class="mentor-booking">
                    
                  
                    <a class="apt-btn" onclick="product_add_cart({{$row->id}})" href="javascript:void(0)">Add To Cart</a>
              
                </div>
            </div>
        </div>
    </div>
</div>
<!-- /Mentor Widget -->


@endforeach

<div class=" col-md-12 d-flex justify-content-center paginationCss">
    {{ $data->appends(request()->except('page'))->links() }}

</div>

@else
<div class="text-center errorSection">
    <h3>No Product Found</h3>
</div>
@endif

