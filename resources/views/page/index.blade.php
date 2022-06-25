<?php $page = "partner"; ?>
@extends('layout.dashboardlayout')
@section('content')	


<!-- Page Content -->
<div class="content">
    <div class="container-fluid">

        <div class="row">
            <div class="col-md-5 col-lg-4 col-xl-3 theiaStickySidebar">

                <!-- Sidebar -->
                      @include('layout.partials.userSideMenu')
                <!-- /Sidebar -->

            </div>

            <div class="col-md-7 col-lg-8 col-xl-9">
                <div class=" col-md-12 ">
                
                    <a href="#" class="btn btn-sm btn btn-primary float-right " data-url="{{ url('cms/create') }}" data-ajax-popup="true" data-size="lg" data-title="{{__('Add New Page
')}}">
            <span class="btn-inner--icon"><i class="fas fa-plus"></i></span>
        </a>
                </div>
   
<!-- Breadcrumb -->
<div class="breadcrumb-bar mt-3">
    <div class="container-fluid">
        <div class="row align-items-center">
            <div class="col-md-12 col-12">
                <h2 class="breadcrumb-title">CMS</h2>
                <nav aria-label="breadcrumb" class="page-breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="index">Home</a></li>
                        <li class="breadcrumb-item active" aria-current="page">CMS</li>
                    </ol>
                </nav>
            </div>              
        </div>            
    </div>
</div>
<!-- /Breadcrumb -->



<br>

<div class="row" id="blog_view">
     <div class="col-12">
        <div class="card">
            <div class="card-body">
                <div class="table-md-responsive">
                    <table class="table table-hover table-center mb-0" id="myTable">
                        <thead class="thead-light">
                        <tr>
							<th class=" mb-0 h6 text-sm"> {{__('Name')}}</th>
							<th class=" mb-0 h6 text-sm"> {{__('Slug')}}</th>
							<th class=" mb-0 h6 text-sm"> {{__('Status')}}</th>
							<th class="text-right name mb-0 h6 text-sm"> {{__('Action')}}</th>
                        </tr>
                        </thead> 
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modal -->
<div id="destroyblog" class="modal fade" role="dialog">
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
          {{ Form::open(['url' => 'cms/destroy','id' => 'destroy_blog','enctype' => 'multipart/form-data']) }}
          <input type="hidden" name="id" id="blog_id"  value="">

        <button type="submit" class="btn btn-sm btn-danger rounded-pill" id="">Yes</button>
        {{ Form::close() }}
        <button type="button" class="btn btn-sm btn-secondary rounded-pill" id="" data-dismiss="modal" aria-label="Close">Cancel</button>
      </div>
    </div>
  </div>
</div>
<!--end modal-->

</div>
</div>
</div>
</div>
@endsection

@push('script')



<script type="text/javascript">

$(document).on("click", ".destroyblog", function(){
    var id = $(this).attr('data-id');
    console.log(id);
    $("#blog_id").val(id);
    $('#destroyblog').modal('show');

});
</script>
<script type="text/javascript">
    

    $(function () {    
    var table = $('#myTable').DataTable({
         responsive: true,
        processing: true,
        serverSide: true,
        ajax: "{{ url('/cms') }}",
        columns: [
       
             {data: 'page_name', name: 'page_name'},
            {data: 'slug', name: 'slug'},
            {data: 'status', name: 'status'},
            {
                data: 'action', 
                name: 'action', 
                orderable: true, 
                searchable: true
            },
        ]
    });
    
  });
</script>

@endpush
