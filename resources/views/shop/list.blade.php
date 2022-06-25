
    <div class="col-12">
        <div class="card">
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table mb-0">
                        <thead class="thead-light">
                        <tr>
                            <th class=" mb-0 h6 text-sm"> {{__('SKU')}}</th>
                            <th class=" mb-0 h6 text-sm"> {{__('Product')}}</th>
                            <th class=" mb-0 h6 text-sm"> {{__('Stock')}}</th>
                            <th class=" mb-0 h6 text-sm"> {{__('Revenue')}}</th>
                            <th class=" mb-0 h6 text-sm"> {{__('Status')}}</th>
                            <th class="text-right class="name mb-0 h6 text-sm""> {{__('Action')}}</th>
                            
                          
                        </tr>
                        </thead>
                        <tbody class="list">
                        @if(count($data) > 0)
                        @foreach($data as $index => $row)
                        <tr>
                            <td>
                                <label class="name mb-0 text-primary ">
                                    <b> {{ $row->category_name }}</b>
                                </label>
                                
                                    <br>
                                <label class="badge text-dark  mb-0 text-xs ml-1">  SKU: {{ $row->sku }}</label>
                            </td>
                            <th scope="row">
                                <div class="media align-items-center">
                                    <div>
                                         @if(!empty($row->image))
                                         <img src="{{asset('storage/shop')}}/{{ $row->image }}" class="avatar ">
                                         @else
                                         <img src="" class="">
                                         @endif
                                    </div>
                                    <div class="media-body ml-4">
                                            <a class="name mb-0 text-sm text-dark">{{ $row->title }} (${{number_format($row->special_price, 2)}})</a><br><small>{{ ucfirst(substr($row->tags ,0,35)) }}......<a href="{{route('shop.edit',encrypted_key($row->id,'encrypt'))}}"> {{__('Update')}}</a> </small>
                                        <br>
                                    </div>
                                </div>
                            </th>
                            
                            <td class="name mb-0 h6 text-sm"> 
                                <span class="badge badge-sm badge-dot mr-4">
                                    <i class="@if($row->stock_status == 'In stock') badge-success @else badge-warning @endif"></i>
                                    {{ $row->stock_status }} 
                                    <br>
                                    <label class="badge text-primary  mb-0 text-sm ml-2">  Qty: {{ $row->quantity }}</label>
                                </span>
                            </td>
                            <td class="name mb-0 h6 text-sm">   ${{number_format($row->revenue, 2)}} 
                                <br>  
                            <label class="badge  mb-0 text-primary text-sm">Sales: {{ $row->sales }}</label>
                            </td>
                            <td class="name mb-0 h6 text-sm"> 
                                <span class="badge badge-sm badge-dot mr-4">
                                    <i class="@if($row->status == 'Published') badge-success @else badge-warning @endif"></i>
                                    {{ $row->status }}
                                </span>
                            </td>
                            <td class="text-right w-15">
                                <div class="actions">
                                    <a href="{{route('shop.edit',encrypted_key($row->id,'encrypt'))}}" class="action-item px-2" data-toggle="tooltip" data-original-title="{{__('Edit')}}">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    <a href="javascript::void(0);" class="action-item text-danger px-2 destroyshop" data-id="{{encrypted_key($row->id,'encrypt')}}" data-toggle="tooltip" >
                                        <i class="fas fa-trash-alt"></i>
                                    </a>
                                </div>
                                 {!! Form::open(['method' => 'DELETE', 'route' => ['shop.destroy',encrypted_key($row->id,'encrypt')],'id'=>'delete-shop-'.encrypted_key($row->id,'encrypt')]) !!}
                                 {!! Form::close() !!}
                            </td>
                        </tr>
                    @endforeach
                    @else
                    <tr>
                        <th scope="col" colspan="7"><h6 class="text-center">{{__('No Shop Product Exist')}}</h6></th>
                    </tr>
                    @endif
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    



