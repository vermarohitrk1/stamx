<?php $page = "user"; ?>
@extends('layout.dashboardlayout')
@section('content')	
<style>
.view-icons {
    margin: 20px 0;
}

.view-icons a {
    align-items: center;
    background-color: #fff;
    border: 1px solid #ddd;
    border-radius: 4px;
    color: #212529;
    display: flex;
    font-size: 17px;
    justify-content: center;
    padding: 4px 8px;
    text-align: center;
    margin-left: 10px;
    width: 37px;
    height: 37px;
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
         <div class="col-md-12 col-lg-12 col-xl-12">
            <a href="{{ url()->previous() }}" id="back" class="btn btn-sm btn-primary float-right ml-2">
            <span class="btn-inner--icon"><i class="fas fa-reply"></i></span>
            </a>
         </div>
         <!-- Breadcrumb -->
         <div class="breadcrumb-bar mt-3">
            <div class="container-fluid">
               <div class="row align-items-center">
                  <div class="col-md-12 col-12">
                     <h2 class="breadcrumb-title">Leads profile</h2>
                     <nav aria-label="breadcrumb" class="page-breadcrumb">
                        <ol class="breadcrumb">
                           <li class="breadcrumb-item"><a href="index">Home</a></li>
                           <li class="breadcrumb-item active" aria-current="page">Lead</li>
                        </ol>
                     </nav>
                  </div>
               </div>
            </div>
         </div>
         <!-- /Breadcrumb -->
         <div class="view-icons">
            <a href="@php echo url( 'my-lead').'/'.$name.'/'.$id.'/user'; @endphp" class="grid-view active"><i class="fas fa-bars"></i></a>
            <a href="@php echo url( 'my-lead').'/'.$name.'/'.$id.'/user'; @endphp/grid-view" class="grid-view"><i class="fas fa-th-large"></i></a>
            <a href="@php echo url( 'my-lead').'/'.$name.'/'.$id.'/user'; @endphp/map-view" class="list-view "><i class="fas fa-map"></i></a>
         </div>
         <div class="card">
            <div class="card-body">
               <div class="table-md-responsive">
                  <!-- data -->
                  <table   class="table table-hover table-center mb-0" id="example">
                     <thead class="thead-light">
                        <tr>
                           <th class=" mb-0 h6 text-sm"> {{__('Name')}}</th>
                           <th class=" mb-0 h6 text-sm"> {{__('Email')}}</th>
                           <!-- <th class=" mb-0 h6 text-sm"> {{__('College')}}</th> -->
                           <th class=" mb-0 h6 text-sm"> {{__('Address')}}</th>
                           <th class=" mb-0 h6 text-sm"> {{__('City')}}</th>
                           <th class=" mb-0 h6 text-sm"> {{__('State')}}</th>
                           <th class=" mb-0 h6 text-sm"> {{__('Created')}}</th>
                           <th class="text-left name mb-0 h6 text-sm"> {{__('Action')}}</th>
                        </tr>
                     </thead>
                  </table>
                  <!-- data -->
               </div>
            </div>
         </div>
         <!-- card -->
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
           "bLengthChange": false,
           ajax: "@php echo url( 'my-lead').'/'.$name.'/'.$id.'/user'; @endphp",
           columns: [
              {data: 'name', name: 'name',orderable: true,searchable: true},
             {data: 'email', name: 'email'},
           //   {data: 'college', name: 'college'},
             {data: 'address', name: 'address'},
             {data: 'city', name: 'city'},
             {data: 'state', name: 'state'},
             {data: 'createddate', name: 'createddate'},
             {data: 'action', name: 'action', orderable: false, searchable: false },
           
         ],
       });
       
     });
   
     
</script>
@endpush