<div class="col-12">
    <div class="card">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table mb-0" id="datatable" cellspacing="0" width="100%">
                    <thead class="thead-light">
                        <tr>
                            <th class="name mb-0 h6 text-sm"> {{__('Name')}}</th>
                            <th class="text-right name mb-0 h6 text-sm"> {{__('Action')}}</th>
                        </tr>
                    </thead>
                    <tbody>
                        @if(count($TaskCategories) > 0)
                        @foreach($TaskCategories as $index => $TaskCategory)
                        <tr>
                            <td class="name mb-0 h6 text-sm">{{ $TaskCategory->name }}</td>
                            <td class="text-right w-15">
                                @if($TaskCategory->id == '0')
                                <i class="fas fa-exclamation-triangle"></i>
                                @else
                                <div class="actions">
                                    <a href="{{ route('task.category.edit',['id'=> $TaskCategory->id ])}}" class="action-item px-2" data-toggle="tooltip" data-original-title="{{__('Edit')}}">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    <a href="javascript::void(0);" class="action-item text-danger destroyCategory" data-id="{{$TaskCategory->id}}" data-toggle="tooltip" data-original-title="{{__('Delete')}}">
                                        <i class="fas fa-trash-alt"></i>
                                    </a>
                                </div>
                                @endif
                            </td>
                        </tr>
                        @endforeach

                        @else
                        <tr>
                            <th scope="col" colspan="7"><h6 class="text-center">{{__('Data Not found')}}</h6></th>
                        </tr>
                        @endif
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>