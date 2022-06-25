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
            <div class="col-md-12 col-lg-12 col-xl-12">
              <a href="{{ route('lead.index') }}" id="back" class="btn btn-sm btn-primary float-right ml-2">
                  <span class="btn-inner--icon"><i class="fas fa-reply"></i></span>
             </a>
          </div>
   
                <!-- Breadcrumb -->
                <div class="breadcrumb-bar mt-3">
                    <div class="container-fluid">
                        <div class="row align-items-center">
                            <div class="col-md-12 col-12">
                                <h2 class="breadcrumb-title">{{ $name }} List</h2>
                                <nav aria-label="breadcrumb" class="page-breadcrumb">
                                    <ol class="breadcrumb">
                                        <li class="breadcrumb-item"><a href="index">Home</a></li>
                                        <li class="breadcrumb-item active" aria-current="page">Lead</li>
                                        <li class="breadcrumb-item active" aria-current="page">{{ $name }}</li>
                                    </ol>
                                </nav>
                            </div>              
                        </div>            
                    </div>
                </div>
                <!-- /Breadcrumb -->



            <div class="col-md-12 col-lg-12 col-xl-12 no_padding">
                     <div class="card">
                            <div class="card-body">
                                <div class="table-md-responsive">
                                <!-- data -->
                                <table  style="width:100%;" class="table table-hover table-center mb-0" id="example">
                        <thead class="thead-light">
                        <tr>
                            <th class=" mb-0 h6 text-sm"> {{__('Name')}}</th>
                            <th class=" mb-0 h6 text-sm"> {{__('Address')}}</th>
                          
                            <th class="text-left name mb-0 h6 text-sm"> {{__('Action')}}</th>
                        </tr>
                        </thead> 
                        
                    </table>
                                <!-- data -->
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
    var table = $('#example').DataTable({
       responsive: true,
        processing: true,
        serverSide: true,
        "bLengthChange": false,
        ajax: "{{ url( 'leads/'.$name.'/list') }}",
        columns: [
          
          {data: 'institution', name: 'institution',orderable: true,searchable: true},
          {data: 'address', name: 'address',orderable: true,searchable: true},
          {data: 'action', name: 'action', orderable: false, searchable: false },
        
      ],
    });
    
  });

  $(document).on("click",".checklead",function() {
    
    var type = $(this).data('type');
    var corporateid = $(this).data('corporate');
    var sid = $(this).data('sid');
        if ($(this).is(":checked")) {
         var status = $(this).val();
          }
        else{
        var status = 0;
        
        }
       
        var data = {
                        status: status,
                        corporateid: corporateid,
                       type: type,
                       sid:sid
                        
                    }
                 $.ajax({
                url: '{{ route('lead.change.status') }}',
                data: data,
                success: function (data) {
                    location.reload();
                     
                }
            });
    
});
  </script>
  
@endpush