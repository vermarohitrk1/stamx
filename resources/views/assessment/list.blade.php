<div class="col-12">
        <div class="card">
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table mb-0">
                        <thead class="thead-light">
                        <tr>
                            <th class=" mb-0 h6 text-sm"> {{__('Form')}}</th>
                            <th class=" mb-0 h6 text-sm"> {{__('Questions')}}</th>
                            <th class=" mb-0 h6 text-sm"> {{__('Responses')}}</th>
                            <th class=" mb-0 h6 text-sm"> {{__('Points')}}</th>
                            <th class="text-center name mb-0 h6 text-sm"> {{__('Action')}}</th>


                        </tr>
                        </thead>
                        {{-- <tbody class="list">
                        @if(count($data) > 0)
                        @foreach($data as $index => $row)
                        <tr>
                            <th scope="row">
                                <div class="media align-items-center">
                                    <div class="media-body">
                                        <a class="name mb-0 text-sm text-dark">{{ $row->category_name }} </a>     <small class=" ml-3 badge badge-pill badge-sm badge-{{ !empty($row->type) && $row->type=="Free" ? 'success' :'primary' }}">{{ $row->type }} {{ !empty($row->type) && $row->type=="Free" ? '' :'$'.$row->amount }}</small>

                                        <br>
                                        <br>
                                        <small class="mt-5">{{ ucfirst(substr($row->title ,0,35)) }}......<a href="{{route('assessmentForm',encrypted_key($row->id,'encrypt'))}}"> {{__('See more')}}</a> </small>
                                        <br>
                                   </div>
                                </div>
                            </th>
                            <td>
                                @if(!empty($row->questions))
                                 <a href="{{route('assessmentQuestion',encrypted_key($row->id,'encrypt'))}}" class="badge  mb-0 h6 text-sm" data-toggle="tooltip" data-original-title="{{__('View Responses')}}">
                                {{ $row->questions }}
                                    </a>
                                @else
                                {{$row->questions}}
                                @endif

                            </td>
                            <td>
                                @if(!empty($row->responses))
                                 <a href="{{route('assessmentForm.responseUsers',encrypted_key($row->id,'encrypt'))}}" class="badge  mb-0 h6 text-sm" data-toggle="tooltip" data-original-title="{{__('View Responses')}}">
                                {{ $row->responses }}
                                    </a>
                                @else
                                {{$row->responses}}
                                @endif
                            </td>
                            <td><label class="badge  mb-0 h6 text-sm">{{ $row->points }}</label></td>
                            {{-- <td class="text-right w-15">
                                <div class="actions">
                                    <a href="{{route('assessmentForm',encrypted_key($row->id,'encrypt'))}}" class="action-item px-2" data-toggle="tooltip" data-original-title="{{__('View')}}">
                                        <i class="fas fa-eye"></i>
                                    </a>
                                    <a href="{{route('assessment.edit',encrypted_key($row->id,'encrypt'))}}" class="action-item px-2" data-toggle="tooltip" data-original-title="{{__('Edit')}}">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    <a href="javascript::void(0);" class="action-item text-danger px-2 destroyassessments" data-id="{{encrypted_key($row->id,'encrypt')}}" data-toggle="tooltip" data-original-title="{{__('Delete')}}">
                                        <i class="fas fa-trash-alt"></i>
                                    </a>
                                </div>
                                 {!! Form::open(['method' => 'DELETE', 'route' => ['assessment.destroy',encrypted_key($row->id,'encrypt')],'id'=>'delete-assessments-'.encrypted_key($row->id,'encrypt')]) !!}
                                 {!! Form::close() !!}
                            </td> --}}
                        {{-- </tr>
                    @endforeach

                    @else
                    <tr>
                        <th scope="col" colspan="7"><h6 class="text-center">{{__('No data found')}}</h6></th>
                    </tr>
                    @endif
                        </tbody>  --}}
                    </table>

                </div>

            </div>

        </div>
    <div class=" col-md-12 d-flex justify-content-center paginationCss">
    {{ $data->appends(request()->except('page'))->links() }}

</div>
    </div>
