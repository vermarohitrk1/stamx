
<style>
    .avatar-lg {
        width: auto;
        height: auto;
        font-size: 1.25rem;
    }
    .avatar img {
        width: 100%;
        border-radius: 0.25rem;
        max-width: 190px;
    }
</style>
<div class="card">
    <div class="card-header">
        <div class="card-body">
            <div class="row">

                @if(isset($data) && !empty($data) && count($data) > 0)
                @foreach ($data as $key => $row)
                <div class="col-xl-6 col-lg-4 col-sm-6">
                    <div class="card hover-shadow-lg">
                        <div class="card-header border-0 pb-0">
                            <div class="d-flex justify-content-between align-items-center">
                                <div>
                                    <h6 class="mb-0 text-xs" data-toggle="tooltip" data-original-title="{{__('SKU')}}">SKU: {{ $row->sku }}</h6>
                                </div>
                                <div class="text-right">
                                    <span class="badge badge-sm badge-dot mr-4">
                                        <i class="@if($row->stock_status == 'In stock') badge-success @else badge-warning @endif"></i>
                                        {{ $row->stock_status }}
                                    </span>
                                </div>
                            </div>
                        </div>
						

                        <div class="card-body text-center">
                            @if(!empty($row->image))
                            <a href="{{route('shop.preview',encrypted_key($row->id,'encrypt'))}}" class="avatar avatar-lg hover-translate-y-n3">
                                <img height="100px" width="100px" src="{{asset('storage/shop')}}/{{ $row->image }}" >
                            </a>
                            @else
                            <a href="javascript::void(0);" class="avatar  avatar-lg hover-translate-y-n3">
                                <img src="">
                            </a>
                            @endif
                            <h5 class="h6 my-4">
						
                                <small>{{ ucfirst(substr($row->title ,0,30)) }}...  </small>
                                <br>
                                <br>
                                @if($row->user_id !=Auth::user()->id) 
                                @if(env('ENABLE_STRIPE') == 'on' && !empty(env('STRIPE_KEY')) && !empty(env('STRIPE_SECRET')))
  
<form action="{{ route('stripe.productOrderPost') }}" method="post">
    {{ csrf_field() }}
        
<script src="https://checkout.stripe.com/checkout.js" class="stripe-button"
	data-key="{{env('STRIPE_KEY')}}"
	data-name="{{ ucfirst(substr($row->title ,0,30)) }}"
	data-description="{{ $row->category_name }}"        
	data-image="{{asset('storage/shop')}}/{{ $row->image }}"

		data-amount="$row->special_price*100"

        data-zip-code="true"
        data-email="{{ Auth::user()->email}}"
        data-label="{{__('Buy Now')}}"
	data-panel-label="{{__('Pay')}}"
        data-allow-remember-me="false"
        data-currency="{{strtolower(env('CURRENCY_CODE'))}}"
	data-locale="auto">
</script>

                                             

  <input type="hidden" name="code" value="{{\Illuminate\Support\Facades\Crypt::encrypt($row->id)}}">
  <input type="hidden" name="quantity" value="{{\Illuminate\Support\Facades\Crypt::encrypt(1)}}">
</form>
                                @else
                      
                                <a href="{{route('shop.preview',encrypted_key($row->id,'encrypt'))}}"><span class="badge badge-pill  badge-primary" data-toggle="tooltip" data-original-title="{{__('Buy Now')}}">{{__('Buy Now')}}</span> </a>
                                 
                                
                                @endif                          
                 
                                
                                @else
                                <a href="{{route('shop.preview',encrypted_key($row->id,'encrypt'))}}"><span class="badge badge-pill  badge-primary" data-toggle="tooltip" data-original-title="{{__('View Details')}}">{{__('View Details')}}</span> </a>
                                @endif
                            </h5>
                            <div class="col-md-12">
                                <span class="text-center badge badge-sm ">
                                    {{__('Price')}}- ${{number_format($row->special_price, 2)}}   / <strike>{{number_format($row->price, 2)}}</strike>
                                </span>
                            </div>

                        </div>
                       
                    </div>
                </div>
                @endforeach
                
                <div class=" col-md-12 d-flex justify-content-center paginationCss">
    {{ $data->appends(request()->except('page'))->links() }}
    
</div>
                @else
                <div class="col-xl-12 col-lg-12 col-sm-12">
                    <div class="card">
                        <div class="card-body">
                            <h6 class="text-center mb-0">{{__('No Shop Product Exist.')}}</h6>
                        </div>
                    </div>
                </div>
                @endif
            </div>
        </div>
    </div>
</div>

@push('script')
<script src="{{ asset('assets/js/custom.js') }}"></script>
@endpush

