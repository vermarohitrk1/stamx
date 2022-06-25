

@if(isset($Certifies) && !empty($Certifies) && count($Certifies) > 0)
@foreach ($Certifies as $key => $Certify)
<div class="col-xl-4 col-lg-4 col-sm-6">
    <div class="card hover-shadow-lg">
        <div class="card-header border-0 pb-0">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <h6 class="mb-0" data-toggle="tooltip" data-original-title="{{__('End Date')}}">{{ \App\Utility::getDateFormated($Certify->created_at) }}</h6>
                </div>
                <div class="text-right">
                    <span class="badge badge-xs badge-{{ (\Auth::user()->type !== 'admin') ? 'success' : 'warning'  }}"   data-toggle="tooltip" data-original-title="{{__('You are ') .__(ucfirst('owner'))}}">Owner</span>
                </div>
            </div>
        </div>
        <div class="card-body text-center">
            <a href="" class="avatar  avatar-lg hover-translate-y-n3">
                <img src="{{asset('storage')}}/instructor/{{ $Certify->image }}" class="avatar " >
            </a>
            <h5 class="h6 my-4">
                <a href="">{{ $Certify->name }}</a>
                <br>
            </h5>
            
        </div>
        <div class="progress w-100 height-2">
        </div>
        <div class="card-footer">
            <div class="actions d-flex justify-content-between px-4">
                <a href="{{ route('instructor.edit',$Certify) }}" class="action-item" data-toggle="tooltip" data-original-title="{{__('Edit')}}">
                    <i class="fas fa-edit"></i>
                </a>
                </a>
                <a href="javascript::void(0);" class="action-item text-danger destroyCertify" data-id="{{$Certify->id}}" data-toggle="tooltip" data-original-title="{{__('Delete')}}">
                    <i class="fas fa-trash-alt"></i>
                </a>
            </div>
        </div>
    </div>
</div>
@endforeach
@else
<div class="col-xl-12 col-lg-12 col-sm-12">
    <div class="card">
        <div class="card-body">
            <h6 class="text-center mb-0">{{__('No Instructor Found.')}}</h6>
        </div>
    </div>
</div>
@endif
@push('script')
<script src="{{ asset('assets/js/custom.js') }}"></script>
<script>
//  $(document).on("click", ".destroyCertify", function(){
//     alert("The button is clicked in Ajax content!!");
// });    
</script>

@endpush
<style>
    .avatar-lg {
        width: auto;
        height: auto;
        font-size: 1.25rem;
    }
    .avatar img {
        width: 100%;
        height: auto;
        border-radius: 0.25rem;
        max-width: 190px;
    }
</style>