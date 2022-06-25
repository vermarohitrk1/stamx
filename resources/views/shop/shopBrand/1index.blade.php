@extends('layouts.admin')

@section('title')
    {{ !empty(ucwords($title)) ? $title : "Title"}}
@endsection

@push('theme-script')
    <script src="{{ asset('assets/libs/bootstrap-tagsinput/dist/bootstrap-tagsinput.min.js') }}"></script>
@endpush

@section('action-button')
    <a href="{{ route('shop.index') }}" class="btn btn-sm btn-white btn-icon-only rounded-circle ml-2" >
        <span class="btn-inner--icon"><i class="fas fa-reply"></i></span>
    </a>
    <a href="{{ route('shopBrand.create') }}" class="btn btn-sm btn-white btn-icon-only rounded-circle " data-title="{{__('Add Brand
        ')}}">
        <span class="btn-inner--icon"><i class="fas fa-plus"></i></span>
    </a>
@endsection

@section('content')
    <div class="row min-750" id="brand_view"></div>
    
    <!-- Modal -->
<div id="destroy_brand" class="modal fade" role="dialog">
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
          {{ Form::open(['route' => 'shopBrand.destroy','id' => 'destroy_entry','enctype' => 'multipart/form-data']) }}
          <input type="hidden" name="brand_id" id="brand_id"  value="">
           
        <button type="submit" class="btn btn-sm btn-danger rounded-pill" id="">Yes</button>
        {{ Form::close() }}
        <button type="button" class="btn btn-sm btn-secondary rounded-pill" id="" data-dismiss="modal" aria-label="Close">Cancel</button>
      </div>
    </div>
  </div>
</div>
@endsection
 



@push('script')
   <script type="text/javascript">  
  $(document).on("click", ".destroy_brand", function(){
    var id = $(this).attr('data-id');
    $("#brand_id").val(id);
    $('#destroy_brand').modal('show');
    }); 
   
   
      $(document).ready(function(){
    //getting view
    getView();
    $(document).on('click', '.pagination a', function (e) {
    var paginationUrl = 'page=' + $(this).attr('href').split('page=')[1];
    getView(paginationUrl);
    e.preventDefault();
    });
});


function getView(page=''){

        var viewUrl = "{{route('shopBrand.show')}}?" + page;
        $.ajax({
           url:viewUrl,
           success:function(data)
            {
            $('#brand_view').html(data);
            }
      }); 
}
    </script>  
@endpush