 <div class="col-12">
        <div class="card">
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table mb-0">
                        <thead class="thead-light">
                        <tr>
                            <th class="name mb-0 h6 text-sm"> {{__('Name')}}</th>
                            <th class="name mb-0 h6 text-sm"> {{__('Price')}}</th>
                            <th class="name mb-0 h6 text-sm"> {{__('Duration')}}</th>
                            <th class="name mb-0 h6 text-sm"> {{__('Status')}}</th>
                            <th class="text-center name mb-0 h6 text-sm"> {{__('Action')}}</th>
                        </tr>
                        </thead>
                        <tbody>
                        @if(count($Certifies) > 0)
                        @foreach($Certifies as $index => $Certify)
                        <tr>
                        <th scope="row" class="text-sm">
                                <div class="media align-items-center">
                                    <div>
                                        <img src="{{asset('storage')}}/certify/{{ $Certify->image }}" class="avatar rounded-circle" >
                                    </div>
                                    <div class="media-body ml-4" style="color:black;">
                                        {{ $Certify->name }}
                                    </div>
                                </div>
                        </th>
                        <td class="name mb-0 h6 text-sm">${{ $Certify->price }}</td>
                        <td class="name mb-0 h6 text-sm"><i class="fa fa-calendar"></i>  {{ $Certify->duration }} {{ $Certify->period }}</td>

                        <td class="name mb-0 h6 text-sm">
                            <span class="badge badge-dot mr-4">
                            <i class="@if($Certify->status == 'Published') bg-success @else bg-warning @endif"></i>
                            <span class="status">{{ $Certify->status }}</span>
                            </span>
                        </td>
                        <td class="text-right w-15">
                            <div class="actions">
                                <a href="{{ url('certify/edit/'.$Certify->id) }}" class="action-item px-2" data-toggle="tooltip" data-original-title="{{__('Edit')}}">
                                    <i class="fas fa-edit"></i>
                                </a>
                                <a href="{{ url('certify/show/'.$Certify->id)}}" class="action-item" data-toggle="tooltip" data-original-title="{{__('View More')}}">
                                    <i class="fas fa-eye"></i>
                                </a>
                               <a href="javascript::void(0);" class="action-item text-danger px-2 destroyCertify" data-id="{{$Certify->id}}" data-toggle="tooltip" data-original-title="{{__('Delete')}}" >
                                    <i class="fas fa-trash-alt"></i>
                                </a>
                                </div>
                            {!! Form::open(['method' => 'DELETE', 'route' => ['certify.destroy',$Certify->id],'id'=>'delete-certify-'.$Certify->id]) !!}
                            {!! Form::close() !!}
                        </td>
                    </tr>
                @endforeach

            @else
                <tr>
                    <th scope="col" colspan="7"><h6 class="text-center">{{__('No Course found')}}</h6></th>
                </tr>
            @endif
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
