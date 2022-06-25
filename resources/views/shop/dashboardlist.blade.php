<style>.nav-tabs > li > a {margin-right: 2px;line-height: 1.42857143;border: 1px solid transparent;border-radius: 4px 4px 0 0;}.nav-tabs > li.active > a, .nav-tabs > li.active > a:hover, .nav-tabs > li.active > a:focus {color: #555;cursor: default;background-color: #fff;border: 1px solid #ddd;border-bottom-color: rgb(221, 221, 221);border-bottom-color: transparent;}.nav > li > a {position: relative;display: block;padding: 10px 15px; color: #595959;text-decoration: none;}</style>
    
<style>
    .card-body.affiliate-card {
    text-align: -webkit-center;
}
</style>
    <div class="col-12">
        <div class="card">
            <div class="card-body">
                
                <ul class="nav nav-tabs">
                    @if($typeview=="active")                    
                    <li class="active" ><a style="cursor:pointer" href="{{ route('shop.dashboard') }}">Orders List</a></li>
                    @else                    
                        <li  ><a href="{{ route('shop.dashboard','views=active') }}">{{__('Active')}}</a></li>
                        <li class="active" ><a href="{{ route('shop.dashboard') }}">Sent Offers</a></li>
                    @endif
                </ul>
            @if($typeview=="active")                   
                
                <div class="table-responsive">
                    <table class="table mb-0" id="myTable">
                        <thead class="thead-light">
                        <tr>
                            <th class=" mb-0 h6 text-sm"> {{__('Buyer')}}</th>
                            <th class="name mb-0 h6 text-sm"> {{__('Product')}}</th>
                            <th class="name mb-0 h6 text-sm"> {{__('Price')}}</th>
                            <th class="name mb-0 h6 text-sm"> {{__('Status')}}</th>
                            <th class="name mb-0 h6 text-sm"> {{__('Date')}}</th>
                            <th class="name mb-0 h6 text-sm"> {{__('Action')}}</th>
                            
                        </tr>
                        </thead>
                        {{-- <tbody>
                        @if(!empty($data))
                            @foreach($data as $index => $row)
                            @if(!empty($row->id))
                        <tr>
                            <td class="name mb-0 h6 text-sm">
                                <a data-toggle="modal" data-target="#myChat" href="javascript:void(0);" class="SingleuserChatButton userDataMessage"
                       data-id="{{$row->user_id}}">
                                <div class="col-md-2 text-center centered align-items-center">
                                <img {{ Auth::user()->getUserAvatar($row->user_id) }}  class="img-circle mt-0 img-responsive avatar avatar-sm rounded-circle ">
                                 <div class="inbox-preview-name">
                                     <h6 class="name mb-2 mt-1 h6 text-sm"> {{ !empty($row->user->name) ? $row->user->name :''}} 
                                        
                                    </h6>
                                </div>
                            </div>
                                </a>
                                
                            
                            
                            </td>
                            <td class="name mb-0 h6 text-sm">
                                <div class="media align-items-center">
                                    <div>
                                         @if(!empty($row->image))
                                         <a href="{{route('shop.preview',encrypted_key($row->product_id,'encrypt'))}}"> <img src="{{asset('storage/shops')}}/{{ $row->image }}" class="avatar "></a>
                                         @else
                                         <img src="" class="">
                                         @endif
                                    </div>
                                    <div class="media-body ml-4">
                                        <a class="name mb-0 text-sm text-dark"><strong>{{ \App\ProductCategory::first_category($row->product_id) }}</strong></a>
                                        <br>
                                        <small>{{ !empty($row->product->title) ? ucfirst(substr(strip_tags($row->product->title) ,0,35)) :'' }}...<a href="{{route('shop.preview',encrypted_key($row->product_id,'encrypt'))}}"> {{__('View details')}}</a> </small><br>
                                           
                                        <br>
                                    </div>
                                </div>
                            </td>
                            <td class="name mb-0 h6 text-sm">${{number_format($row->amount, 2)}}<br><span> </td>
                             
                           <td class="name mb-0 h6 text-sm"> 
                                <span class="badge badge-sm badge-dot mr-4">
                                    <i class="@if($row->status == 'Shipped') badge-success @else badge-warning @endif"></i>
                                    {{ $row->status }}
                                </span>
                            </td>
                              <td><label class="badge  mb-0 h6 text-sm">{{ \App\Utility::getDateFormated($row->created_at) }}</label></td>
                             <td class="text-right w-15">
                                <div class="actions"> 
                                   @if($row->status != 'Shipped' && $row->product->user_id ==Auth::User()->id) 
                                    @if($row->status != 'Cancelled') 
                                    <a href="{{route('shop.markshipped',encrypted_key($row->id,'encrypt'))}}" class="btn btn-sm btn-icon-only rounded-pill mr-1 ml-1" data-toggle="tooltip" data-original-title="{{__('Mark Shiped')}}">
                                        <i class="fas fa-shopping-cart text-success"></i>
                                    </a>
                                    <a href="{{route('shop.markcancel',encrypted_key($row->id,'encrypt'))}}" class="btn btn-sm  btn-icon-only rounded-pill mr-1 ml-1" data-toggle="tooltip" data-original-title="{{__('Mark Cancel')}}">
                                        <i class="fas fa-trash-alt text-danger"></i>
                                    </a>                                    
                                  
                                   @endif
                                   @endif
                                </div>
                            </td>
                        </tr>
                         @endif
                            @endforeach
                        @else
                        <tr>
                            
                            <th scope="col" colspan="7"><h6 class="text-center">{{__('No order exist')}}</h6></th>
                            
                        </tr>
                        @endif
                        </tbody> --}}
                    </table>
                </div>
                
            @else
            
            
            @endif
                                 <br>
<div class="d-flex justify-content-center paginationCss">
    {{ $data->appends(request()->except('page'))->links() }}
</div>
        </div>
    </div>