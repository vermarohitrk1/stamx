
<?php $page = "photobooth"; ?>
<?php $page = "partner"; ?>
@extends('layout.dashboardlayout')
@section('content')	
<style>
div#commonModal {
    z-index: 99999;
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
               
   
<!-- Breadcrumb -->
<div class="breadcrumb-bar mt-3">
    <div class="container-fluid">
        <div class="row align-items-center">
            <div class="col-md-12 col-12">
                <h2 class="breadcrumb-title">Photobooth Count</h2>
                <nav aria-label="breadcrumb" class="page-breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="index">Home</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Photobooth Count</li>
                    </ol>
                </nav>
            </div>              
        </div>            
    </div>
</div>
<!-- /Breadcrumb -->

<div class="row mt-3">
                    <div class="col-md-12 col-lg-3 dash-board-list blue">
                        <div class="dash-widget">
                            <div class="circle-bar">
                                <div class="icon-col">
                                <i class="fab fa-facebook"></i>
                                </div>
                            </div>
                            <div class="dash-widget-info">
                                <h3>{{ \App\Photoboothsharecount::where('count',1)->count() }}</h3>
                                <h6>Facebook</h6>
                            </div>
                        </div>
                    </div>



                    <div class="col-md-12 col-lg-3 dash-board-list pink">
                        <div class="dash-widget">
                            <div class="circle-bar">
                                <div class="icon-col">
                                <i class="fab fa-twitter"></i>
                                </div>
                            </div>
                            <div class="dash-widget-info">
                                <h3>{{ \App\Photoboothsharecount::where('count',2)->count() }}</h3>
                                <h6>Twitter</h6>
                            </div>
                        </div>
                    </div>
                  
                    
                </div>

<br>

<div class="row" id="blog_view">
     <div class="col-12">
        <div class="card">
            <div class="card-body">
                <div class="table-md-responsive">
                <table class=" table table-hover table-center mb-0" id="myTable">
                                <thead class="thead-light">
                                    <tr>
                                      
                                        <th>Frame</th>
                                        <th>No. of user ( facebook)</th>
                                        <th>No. of user (twitter)</th>
                                        <th>Action</th>
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
@endsection

@push('script')



<script type="text/javascript">
    

  
    $(function () {
        var table = $('#myTable').DataTable({
         responsive: true,
        processing: true,
        serverSide: true,
        ajax: "{{ route('admin.boothdata') }}",
        columns: [
            //{data: 'DT_RowIndex', name: 'DT_RowIndex'},
            {data: 'title', name: 'title',orderable: false,searchable: false},
            {data: 'status', name: 'status'},
            {data: 'twitter', name: 'twitter'},
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

