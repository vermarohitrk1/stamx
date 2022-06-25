 <div class="col-12">
        <div class="card">
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table mb-0">
                        <thead class="thead-light">
                        <tr>
                            <th class=" mb-0 h6 text-sm"> {{__('Sr.No')}}</th>
                            <th class="name mb-0 h6 text-sm"> {{__('Image')}}</th>
                            <th class="name mb-0 h6 text-sm"> {{__('Name')}}</th>
                            <th class="name mb-0 h6 text-sm"> {{__('Title')}}</th>
                            <th class="name mb-0 h6 text-sm"> {{__('City')}}</th>
                            <th class="name mb-0 h6 text-sm"> {{__('State')}}</th>
                            <th class="text-right class="name mb-0 h6 text-sm""> {{__('Action')}}</th>
                        </tr>
                        </thead>
                        <tbody>
                        @if(count($Certifies) > 0)
                @foreach($Certifies as $index => $Certify)
                    <tr>
                        <td><label class="badge  mb-0 h6 text-sm">{{ $index + 1 }}</label></td>
                        <th scope="row" class="text-sm">
                                <div class="media align-items-center">
                                    <div>
                                        <img src="{{asset('storage')}}/instructor/{{ $Certify->image }}" class="avatar rounded-circle" >
                                    </div>
                                </div>
                            </th>
                        <td class="name mb-0 h6 text-sm">{{ $Certify->name }}</td>
                        <td class="name mb-0 h6 text-sm">  {{ $Certify->title }}</td>
                        <td class="name mb-0 h6 text-sm">{{ $Certify->city }}</td>
                        <td class="name mb-0 h6 text-sm">  {{ $Certify->state }}</td>
                    
                        <td class="text-right w-15">
                            <div class="actions">
                                <a href="{{ url('instructor/edit/'.$Certify->id) }}" class="action-item px-2" data-toggle="tooltip" data-original-title="{{__('Edit')}}">
                                    <i class="fas fa-edit"></i>
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
                    <th scope="col" colspan="7"><h6 class="text-center">{{__('No Instructor found')}}</h6></th>
                </tr>
            @endif
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
