@extends('layouts.admin')
@section('title')
{{$title}}
@endsection
@push('css')
<style>
.btn-secondary {
    color: #FFF;
    background-color: #95a5a6;
    border-color: #95a5a6;
    box-shadow: inset 0 1px 0 rgba(255, 255, 255, 0.15);
}
.paginationCss{
        width: 100%;
    display: flex;
    justify-content: center;
    }
</style>
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
@endpush

@push('theme-script')
<script src="{{ asset('assets/libs/dragula/dist/dragula.min.js') }}"></script>

@endpush

@section('action-button')
<a href="{{ route('certify.index') }}" class="btn btn-sm btn-white btn-icon-only rounded-circle ml-2" >
    <span class="btn-inner--icon"><i class="fas fa-reply"></i></span>
</a>
@endsection
@section('content')
<div class="row" id="certifyView">
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
                    <span class="badge badge-xs badge-success" data-toggle="tooltip" data-original-title="{{getCertityCategoryDetails($Certify->category)->name}}">{{getCertityCategoryDetails($Certify->category)->name}}</span>
                </div>
            </div>
        </div>
        <div class="card-body text-center">
            <a href="{{ url('certify/show/'.encrypted_key($Certify->id,'encrypt')) }}" class="avatar  avatar-lg hover-translate-y-n3">
                <img src="{{asset('storage')}}/certify/{{ $Certify->image }}" class="avatar " >
            </a>
            <h5 class="h6 my-4">
                <a href="{{ url('certify/show/'.encrypted_key($Certify->id,'encrypt')) }}">{{ $Certify->name }}</a>
                <br>
            </h5>
            <span class="badge badge-pill badge-success"><i class="fa fa-calendar"></i> {{ $Certify->duration }} {{ $Certify->period }}</span>
            <span class="badge badge-pill badge-success">$ {{ $Certify->price }}</span><br>
             <!--<span class="badge badge-pill  @if($Certify->status == 'Published') badge-success @else badge-warning @endif" data-toggle="tooltip" data-original-title="{{__('Status ') .__(ucfirst($Certify->status))}}">{{$Certify->status}}</span>-->
        </div>
        <div class="progress w-100 height-2">
        </div>
        <div class="card-footer">
            <div class="actions d-flex justify-content-between px-4">
                @if($authuser->type == 'admin' || $authuser->type == 'owner')
                <a href="{{ route('certify.edit',encrypted_key($Certify->id,'encrypt')) }}" class="action-item" data-toggle="tooltip" data-original-title="{{__('Edit')}}">
                    <i class="fas fa-edit"></i>
                </a>
                <a href="{{ url('certify/show/'.encrypted_key($Certify->id,'encrypt')) }}" class="action-item" data-toggle="tooltip" data-original-title="{{__('View More')}}">
                    <i class="fas fa-eye"></i>
                </a>
				@endif
				@if($authuser->type == 'client' || $authuser->type == 'user')
                <a href="{{ url('certify/show/'.encrypted_key($Certify->id,'encrypt')) }}" class="action-item" data-toggle="tooltip" data-original-title="{{__('Curriculum')}}">
                    <i class="fas fa-eye"></i>
                </a>
                @endif
                
                @if(checkExamStatus($Certify->id) == true)
                <a href="{{ url('certify/certificate/'.$Certify->id) }}" class="action-item" data-toggle="tooltip" data-original-title="{{__('Certificate')}}"> 

                    <i class="fa fa-certificate" aria-hidden="true"></i>
                </a>
                @endif
				
				@if($authuser->type == 'admin' || $authuser->type == 'owner')
                <a href="javascript::void(0);" class="action-item text-danger @if(syndicateCertifyStatus($Certify->id) == true) notDestroy @else destroyCertify @endif" data-id="{{$Certify->id}}" data-toggle="tooltip" data-original-title="{{__('Delete')}}">
                    <i class="fas fa-trash-alt"></i>
                </a>
				@endif
                @if($authuser->type == 'corporate')
                    @if(getCorpurateCertityDetails($Certify->id) == true)
                    <a href="javascript:void(0);" data-id="{{$Certify->id}}"  class="action-item addedCertify" data-toggle="tooltip" data-original-title="{{__('Add in my courses')}}">
                            <i class="fa fa-plus"></i>
                    </a>
                    @else
                    <a href="javascript:void(0);" class="action-item addCertify" data-id="{{$Certify->id}}"  data-toggle="tooltip" data-original-title="{{__('Add in my courses')}}">
                            <i class="fa fa-plus"></i>
                    </a>
                    @endif
                @endif
            </div>
        </div>
    </div>
</div>
@endforeach
@else
<div class="col-xl-12 col-lg-12 col-sm-12">
    <div class="card">
        <div class="card-body">
            <h6 class="text-center mb-0">{{__('No Course Found.')}}</h6>
        </div>
    </div>
</div>
@endif
@if($Certifies)
  <br>
<div class="d-flex justify-content-center paginationCss">
    {{ $Certifies->appends(request()->except('page'))->links() }}
</div>  
@endif
</div>
<!-- Modal -->
<div id="notDestroy" class="modal fade" role="dialog">
  <div class="modal-dialog">
    <!-- Modal content-->
    <div class="modal-content">
       <div class="modal-header">
                <h5 class="modal-title">Alert <i class="fas fa-exclamation-circle"></i></h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button> 
        </div> 
    <div class="modal-body">  
        This certify cannot be deleted because it has been already purchased by somebody.
    </div>  
      <div class="modal-footer">
        <button type="button" class="btn btn-sm btn-secondary rounded-pill" id="" data-dismiss="modal" aria-label="Close">Cancel</button>
      </div>
    </div>
  </div>
</div>
<!-- Modal -->
<div id="destroyCertify" class="modal fade" role="dialog">
  <div class="modal-dialog">
    <!-- Modal content-->
    <div class="modal-content">
       <div class="modal-header">
                <h5 class="modal-title">Are You Sure?</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button> 
        </div> 
    <div class="modal-body">  
        This action can not be undone. Do you want to continue?
    </div>  
      <div class="modal-footer">
          {{ Form::open(['url' => 'certify/destroy','id' => 'destroy_certify','enctype' => 'multipart/form-data']) }}
          <input type="hidden" name="certify_Id" id="certify_Id"  value="">
           
        <button type="submit" class="btn btn-sm btn-danger rounded-pill" id="">Yes</button>
        {{ Form::close() }}
        <button type="button" class="btn btn-sm btn-secondary rounded-pill" id="" data-dismiss="modal" aria-label="Close">Cancel</button>
      </div>
    </div>
  </div>
</div>
<!-- Modal -->
<div id="addCertify" class="modal fade" role="dialog">
  <div class="modal-dialog">
    <!-- Modal content-->
    <div class="modal-content">
       <div class="modal-header">
                <h5 class="modal-title">Are You Sure?</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button> 
        </div> 
    <div class="modal-body">  
        Add This Course in MyCourses.<br>
        This action can not be undone. Do you want to continue?
    </div>  
      <div class="modal-footer">
          {{ Form::open(['url' => 'certify/corpurate/add/certify','id' => 'addCertifyCorpurate','enctype' => 'multipart/form-data']) }}
          <input type="hidden" name="corpurate_certify" id="corpurate_certify"  value="">
           
        <button type="submit" class="btn btn-sm btn-danger rounded-pill" id="">Yes</button>
        {{ Form::close() }}
        <button type="button" class="btn btn-sm btn-secondary rounded-pill" id="" data-dismiss="modal" aria-label="Close">Cancel</button>
      </div>
    </div>
  </div>
</div>
<!-- Modal -->
<div id="addedCertify" class="modal fade" role="dialog">
  <div class="modal-dialog">
    <!-- Modal content-->
    <div class="modal-content">
       <div class="modal-header">
            <h5 class="modal-title">Alert !</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">×</span>
            </button> 
        </div> 
    <div class="modal-body">  
        you already added this course.
    </div>  
      <div class="modal-footer">
        <button type="button" class="btn btn-sm btn-secondary rounded-pill" id="" data-dismiss="modal" aria-label="Close">Cancel</button>
      </div>
    </div>
  </div>
</div>
@endsection

@push('script')
<script src="{{ asset('assets/libs/dragula/dist/dragula.min.js') }}"></script>
<script src="{{ asset('public/ckeditor/ckeditor.js') }}"></script>
<script src="{{ asset('assets/js/custom.js') }}"></script>
<script type="text/javascript" src="{{ asset('assets/js/repeater.js') }}"></script>
<script>
CKEDITOR.replace( 'summary-ckeditor' );

$(document).on("click", ".addCertify", function(){
    var id = $(this).attr('data-id');
    $("#corpurate_certify").val(id);
    $('#addCertify').modal('show');
    
});
$(document).on("click", ".destroyCertify", function(){
    var id = $(this).attr('data-id');
    $("#certify_Id").val(id);
    $('#destroyCertify').modal('show');
    
});
$(document).on("click", ".notDestroy", function(){
    $('#notDestroy').modal('show');
});
$(document).on("click", ".addedCertify", function(){
    $('#addedCertify').modal('show');
}); 
</script>
<script>
function showModal() {
    $('body').loadingModal({text: 'loading...'});
    var delay = function(ms){ return new Promise(function(r) { setTimeout(r, ms) }) };
    var time = 1000000;
    delay(time)
            .then(function() { $('body').loadingModal('animation', 'circle').loadingModal('backgroundColor', 'black'); return delay(time);})
            .then(function() { $('body').loadingModal('destroy') ;} );
}
$( "#create_certify" ).submit(function( event ) {
    alert('hi');
  showModal();
});

</script>
@endpush
