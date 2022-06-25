<?php $page = "Contact Folders"; ?>
@section('title')
    {{$page}}
@endsection
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
           
    <a href="#" class="btn btn-sm btn btn-primary float-right ml-2 " data-url="{{ url('contacts/folder/create') }}" data-ajax-popup="true" data-size="lg" data-title="{{__('Add Folder
        ')}}">
        <span class="btn-inner--icon"><i class="fas fa-plus"></i></span>
    </a>
                    
                     <a href="{{ route('contacts') }}" class="btn btn-sm btn-primary float-right btn-icon-only rounded-circle " >
        <span class="btn-inner--icon"><i class="fas fa-reply"></i></span>
    </a>
                     </div>
   
<!-- Breadcrumb -->
<div class="breadcrumb-bar mt-3">
    <div class="container-fluid">
        <div class="row align-items-center">
            <div class="col-md-12 col-12">
                <h2 class="breadcrumb-title">Contact Folders</h2>
                <nav aria-label="breadcrumb" class="page-breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{route('dashboard')}}">Home</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('contacts') }}">Contacts</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Contact Folders</li>
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
          <div class="card-body ">
              <div class="table_md-responsive">
                  <table class="table table-hover table-center mb-0" id="myTable">
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
    var table = $('#myTable').DataTable({
       responsive: true,
        processing: true,
        serverSide: true,
        ajax: "{{ url('/contacts/folder') }}",
        columns: [
            {data: 'name', name: 'name',orderable: false},
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
