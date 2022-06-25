
    <div class="col-12">
        <div class="card">
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table mb-0">
                        <thead class="thead-light">
                        <tr>
                            <th class="name mb-0 h6 text-sm"> {{__('Name')}}</th>
                            <th class="text-right name mb-0 h6 text-sm"> {{__('Action')}}</th>
                        </tr>
                        </thead>
                        <tbody class="list">
                        @if(count($brands) > 0)
                        @foreach($brands as $index => $brand)
                        <tr>
                            <td class="name mb-0 h6 text-sm">{{ ucfirst($brand->title) }}</td>
                           <td class="text-right w-15">
                               <div class="actions text-right ">
           
                                                <a class="btn btn-sm bg-success-light mt-1" data-title="Edit " href="{{ route('shopBrand.edit',encrypted_key($brand->id,'encrypt') )}}">
                                                    <i class="fas fa-pencil-alt"></i>
                                                    Edit
                                                </a>
                                                <a data-url="{{route('shopBrand.destroy',encrypted_key($brand->id,'encrypt')) }}" href="#" class="btn btn-sm bg-danger-light delete_record_model mt-1">
                                                    <i class="far fa-trash-alt"></i> Delete
                                                </a>
                                            </div>
                               
                                                              
                            </td>
                        </tr>
                    @endforeach
                    @else
                    <tr>
                        <th scope="col" colspan="7"><h6 class="text-center">{{__('No data found')}}</h6></th>
                    </tr>
                    @endif
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
         <div class=" col-md-12 d-flex justify-content-center paginationCss">
    {{ $brands->appends(request()->except('page'))->links() }}
    
    </div>
    </div>
