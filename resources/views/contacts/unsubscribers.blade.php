<?php $page = "UnSubscribers"; ?>
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
         
                    
                     <a href="{{ url('contacts') }}" class="btn btn-sm btn-primary float-right btn-icon-only rounded-circle " >
        <span class="btn-inner--icon"><i class="fas fa-reply"></i></span>
    </a>
                     </div>
   
<!-- Breadcrumb -->
<div class="breadcrumb-bar mt-3">
    <div class="container-fluid">
        <div class="row align-items-center">
            <div class="col-md-12 col-12">
                <h2 class="breadcrumb-title">UnSubscribers</h2>
                <nav aria-label="breadcrumb" class="page-breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{route('dashboard')}}">Home</a></li>
                        <li class="breadcrumb-item active" aria-current="page">UnSubscribers</li>
                    </ol>
                </nav>
            </div>              
        </div>            
    </div>
</div>
<!-- /Breadcrumb -->





<div class="row mt-3" id="blog_view">
     <div class="col-12">
        <div class="card">
            <div class="card-body ">
                <div class="table-md-responsive">
                    
                    <table class="table table-hover table-center mb-0" id="myTable">
                        <thead class="thead-light">
                            <tr>
                                <th class=" mb-0 h6 text-sm"> {{__('Name')}}</th>
                                <th class=" mb-0 h6 text-sm"> {{__('Email')}}</th>
                                <th class=" mb-0 h6 text-sm"> {{__('Phone')}}</th>
                                <th class=" mb-0 h6 text-sm"> {{__('Folder')}}</th>
                                <th class=" mb-0 h6 text-sm"> {{__('Type')}}</th>
                                <th class=" mb-0 h6 text-sm"> {{__('SMS')}}</th>
                            </tr>
                        </thead>
                         
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
    var table = $('#myTable').DataTable({
         responsive: true,
        processing: true,
        serverSide: true,
        ajax: "{{ url('contacts/unsbuscribers') }}",
        columns: [
           
            {data: 'name', name: 'name',orderable: false},
            {data: 'email', name: 'email',orderable: false},
            {data: 'phone', name: 'phone',orderable: false},
            {data: 'folder', name: 'folder',orderable: false},
            {data: 'type', name: 'type',orderable: false},
            {data: 'sms', name: 'sms',orderable: false},
        ]
    });
    
  });

</script>


@endpush
