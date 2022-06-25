
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
@if(isset($data) && !empty($data) && count($data) > 0)
@foreach ($data as $key => $row)
<div class="col-xl-4 col-lg-4 col-sm-6">
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
                <img height="100px" width="200" src="{{asset('storage/shop')}}/{{ $row->image }}" >
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
                <a href="{{route('shop.preview',encrypted_key($row->id,'encrypt'))}}"><span class="badge badge-pill  badge-primary" data-toggle="tooltip" data-original-title="{{__('Category ')}}">{{ $row->category_name }}</span> </a>
            </h5>
             <div class="col-md-12">
                    <span class="text-left badge badge-sm text-success ">
                        {{ $row->name }}
                    </span>
                 <span class="text-right badge badge-sm ">
                       {{__('Price')}}- ${{number_format($row->special_price, 2)}}
                    </span>
                </div>
             
        </div>

        <div class="progress w-100 height-2">
        </div>
        <div class="card-footer">
            <div class="actions d-flex justify-content-between px-4">
                <a href="{{route('shop.edit',encrypted_key($row->id,'encrypt'))}}" class="action-item" data-toggle="tooltip" data-original-title="{{__('Edit')}}">
                    <i class="fas fa-edit"></i>
                </a>
                <a href="javascript::void(0);" class="action-item text-danger ml-auto px-2 destroyshop" data-id="{{encrypted_key($row->id,'encrypt')}}" data-toggle="tooltip" >
                    <i class="fas fa-trash-alt"></i>
                </a>
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
@push('script')
<script src="{{ asset('assets/js/custom.js') }}"></script>
@endpush
