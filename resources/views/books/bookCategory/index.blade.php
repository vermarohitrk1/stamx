<?php $page = "book"; ?>
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
           
    <a href="#" class="btn btn-sm btn btn-primary float-right ml-2 " data-url="{{ route('book.category.create') }}" data-ajax-popup="true" data-size="lg" data-title="{{__('Add Category
        ')}}">
        <span class="btn-inner--icon"><i class="fas fa-plus"></i></span>
    </a>
                    
                     <a href="{{ route('book.get') }}" class="btn btn-sm btn-primary float-right btn-icon-only rounded-circle " >
        <span class="btn-inner--icon"><i class="fas fa-reply"></i></span>
    </a>
                     </div>
   
<!-- Breadcrumb -->
<div class="breadcrumb-bar mt-3">
    <div class="container-fluid">
        <div class="row align-items-center">
            <div class="col-md-12 col-12">
                <h2 class="breadcrumb-title">Book Categories</h2>
                <nav aria-label="breadcrumb" class="page-breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ route('book.get') }}">Home</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Book Categories</li>
                    </ol>
                </nav>
            </div>              
        </div>            
    </div>
</div>
<!-- /Breadcrumb -->

<div class="row mt-3" id="blog_category_view">
  
  <!-- list view -->
  <div class="col-12">
      <div class="card">
          <div class="card-body p-0">
              <div class="table_md-responsive">
                  <table class="table table-hover table-center mb-0" id="example">
                     <thead class="thead-light">
                      <tr> 
                          <!-- <th class=" mb-0 h6 text-sm"> {{__('#')}}</th> -->
                           <th class="name mb-0 h6 text-sm"> {{__('Name')}}</th>
                          <th class="text-left name mb-0 h6 text-sm"> {{__('Action')}}</th>
                      </tr>
                      </thead>
                     
                  </table>
              </div>
          </div> 	
      </div>
  </div> 
    <!-- list view -->
</div>
    

            </div>
        </div>

    </div>

</div>		
<!-- /Page Content -->
@endsection

@push('script')

   <script type="text/javascript">  

  $(function () {    
    var table = $('#example').DataTable({
       responsive: true,
        processing: true,
        serverSide: true,
        ajax: "{{ url('book-category') }}",
        columns: [
            //{data: 'DT_RowIndex', name: 'DT_RowIndex'},
            {data: 'name', name: 'name'},
            {
                data: 'action', 
                name: 'action', 
                orderable: false, 
                searchable: false
            },
        ]
    });
    
  });     
</script>  



@endpush
