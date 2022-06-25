<?php $page = "Courses"; ?>
@extends('layout.dashboardlayout')
@section('content')	
<style>
.modal-open .main-wrapper {
    -webkit-filter: blur(1px);
    -moz-filter: blur(1px);
    -o-filter: blur(1px);
    -ms-filter: blur(1px);
    filter: inherit;
}
.modal {
    z-index: 9999;
	margin-top: 1rem;
}
</style>

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
                    @php
                    $permissions=permissions();
                    @endphp
                   
                 
                 
                     <a href="{{ route('certify.index') }}" class="btn btn-sm btn-primary float-right btn-icon-only rounded-circle " >
        <span class="btn-inner--icon"><i class="fas fa-reply"></i></span>
    </a>
                    
   
	
	
   
    
    
                     </div>
   
<!-- Breadcrumb -->
<div class="breadcrumb-bar mt-3">
    <div class="container-fluid">
        <div class="row align-items-center">
            <div class="col-md-12 col-12">
                <h2 class="breadcrumb-title">Payments</h2>
                <nav aria-label="breadcrumb" class="page-breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{route('dashboard')}}">Home</a></li>
                        <li class="breadcrumb-item " aria-current="page">Courses</li>
                        <li class="breadcrumb-item active" aria-current="page">Payments</li>
                    </ol>
                </nav>
            </div>              
        </div>            
    </div>
</div>
<!-- /Breadcrumb -->



<br>


<div class="row" id="certifyView">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                     <div class="table-md-responsive">                    
                    <table class="table  table-hover table-center mb-0" id="yajra-datatable">
                        <thead class="thead-light ">
                            
                   
                            <tr>
                              <th > {{__('Course Name')}}</th>
                                <th > {{__('Amount')}}</th>
                                <th > {{__('Mode')}}</th>
                                <th > {{__('Paid On	')}}</th>
                                <th > {{__('Status')}}</th>
                            </tr>
                            </thead>
                            <tbody>

                            </tbody>
                        </table>
                    </div> 
                </div>
            </div>
        </div>
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
    var table = $('#yajra-datatable').DataTable({
        responsive: true,
        processing: true,
        serverSide: true,
         ajax: "{{ route('certify.payments') }}",
        columns: [
            //{data: 'DT_RowIndex', name: 'DT_RowIndex'},
          {data: 'item_name', name: 'item_name', orderable: false},
                    {data: 'total_price', name: 'total_price', orderable: false},
                    {data: 'mode', name: 'mode', orderable: false},
                    {data: 'created_at', name: 'created_at', orderable: false},
                    {data: 'status', name: 'status', orderable: false},
            
           
        ]
    });

  });
     
    </script>

@endpush
