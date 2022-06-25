
    <div class="col-8">
        <div class="card">
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table mb-0">
                        <thead class="thead-light">
                        <tr>
                            <th class="name mb-0 h6 text-sm"> {{__('Name')}}</th>
                            <th class="text-center name mb-0 h6 text-sm"> {{__('Action')}}</th>
                        </tr>
                        </thead>
                        {{-- <tbody class="list">
                        @if(count($assessment_categories) > 0)
                        @foreach($assessment_categories as $index => $category)
                        <tr>
                            <td class="name mb-0 h6 text-sm">{{ ucfirst($category->name) }}</td>
                            <td class="text-right w-15">
                                <div class="actions">
                                    <a href="{{ route('assessmentCategory.edit',encrypted_key($category->id,'encrypt') )}}" class="action-item px-2" data-toggle="tooltip" data-original-title="{{__('Edit')}}">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    <a href="javascript::void(0);" class="action-item text-danger destroy_category" data-id="{{ encrypted_key($category->id,'encrypt')}}" data-toggle="tooltip" data-original-title="{{__('Delete')}}" data-confirm="{{__('Are You Sure?')}}|{{__('This action can not be undone. Do you want to continue?')}}" data-confirm-yes="document.getElementById('delete-category-{{encrypted_key($category->id,'encrypt')}}').submit();">
                                        <i class="fas fa-trash-alt"></i>
                                    </a>
                                </div>
                                 {!! Form::open(['method' => 'DELETE', 'route' => ['assessmentCategory.destroy',encrypted_key($category->id,'encrypt')],'id'=>'delete-assessmentCategory-'.encrypted_key($category->id,'encrypt')]) !!}
                                 {!! Form::close() !!}

                            </td>
                        </tr>
                    @endforeach
                    @else
                    <tr>
                        <th scope="col" colspan="7"><h6 class="text-center">{{__('No tasks found')}}</h6></th>
                    </tr>
                    @endif
                        </tbody> --}}
                    </table>
                </div>
            </div>

        </div>
          <div class=" col-md-12 d-flex justify-content-center paginationCss">
    {{ $assessment_categories->appends(request()->except('page'))->links() }}

    </div>

