
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
                    <h6 class="mb-0" data-toggle="tooltip" data-original-title="{{__('Create Date')}}">{{ \App\Utility::getDateFormated($row->created_at) }}</h6>
                </div>
                <div class="text-right">
                    <span class="badge badge-sm badge-dot mr-4">
                        <i class="@if($row->type == 'Free') badge-success @else badge-primary @endif"></i>
                        {{ $row->type }} {{ !empty($row->type) && $row->type=="Free" ? '' :'- $'.$row->amount }}
                    </span>
                </div>
            </div>
        </div>
 
        <div class="card-body text-center">
           <h6 class="text-primary">{{ ucfirst(substr($row->category_name ,0,30)) }}</h6>
            
            <h5 class="h6 my-4">
                 <a href="{{route('assessmentForm',encrypted_key($row->id,'encrypt'))}}" class=" hover-translate-y-n3" data-toggle="tooltip" data-original-title="{{__('View Form')}}">
                
                <small>{{ ucwords(substr($row->title ,0,30)) }}...  </small>
                </a>
            </h5>
             <div class="col-md-12 ">
                    <span class="ml-1 mr-1 badge badge-sm badge-pill badge-primary  ">
                        <a href="{{route('assessmentQuestion',encrypted_key($row->id,'encrypt'))}}" class="text-white" data-toggle="tooltip" data-original-title="{{__('Manage Questions')}}">
                                        {{ $row->questions }} Questions
                                    </a>
                    </span>
                    <span class="ml-1 mr-1 badge badge-sm badge-pill badge-success ">
                        <a href="{{route('assessmentForm.responseUsers',encrypted_key($row->id,'encrypt'))}}" class="text-white" data-toggle="tooltip" data-original-title="{{__('View Responses')}}">
                                        {{ $row->responses }} Responses
                                    </a>
                    </span>
                 <br>
                 <br>
                    <span class="badge badge-sm badge-pill badge-warning">
                        {{ $row->points }} Points
                    </span>
                </div>
             
        </div>

        <div class="progress w-100 height-2">
        </div>
        <div class="card-footer">
            <div class="actions d-flex justify-content-between px-4">
                <a href="{{route('assessment.edit',encrypted_key($row->id,'encrypt'))}}" class="action-item" data-toggle="tooltip" data-original-title="{{__('Edit')}}">
                    <i class="fas fa-edit"></i>
                </a>
                <a href="javascript::void(0);" class="action-item text-danger ml-auto px-2 destroyassessments" data-id="{{encrypted_key($row->id,'encrypt')}}" data-toggle="tooltip" data-original-title="{{__('Delete')}}">
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
            <h6 class="text-center mb-0">{{__('No Service Request Found.')}}</h6>
        </div>
    </div>
</div>
@endif
@push('script')
<script src="{{ asset('assets/js/custom.js') }}"></script>
@endpush
