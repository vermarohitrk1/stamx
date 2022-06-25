@php $page = "Departments"; @endphp
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
                    <a href="{{ route('ivr.add_department') }}" class="btn btn-sm btn btn-primary float-right "  data-title="{{__('Add Department')}}">
             <span class="btn-inner--icon"><i class="fas fa-plus"></i></span>
         </a>
                   
                          </div>
   
<!-- Breadcrumb -->
<div class="breadcrumb-bar mt-3">
    <div class="container-fluid">
        <div class="row align-items-center">
            <div class="col-md-12 col-12">
                <h2 class="breadcrumb-title">Departments</h2>
                <nav aria-label="breadcrumb" class="page-breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{route('dashboard')}}">Home</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Departments</li>
                    </ol>
                </nav>
            </div>              
        </div>            
    </div>
</div>
<!-- /Breadcrumb -->





<div class="row" id="blog_view">
     <div class="col-12">
        <div class="card">
            <div class="card-body ">
                <div class="table-md-responsive">
                    <table class="table table-hover table-center mb-0" id="example">
                        <thead class="thead-light">
                        <tr>
                            <th class=" mb-0 h6 text-sm"> {{__('Name')}}</th>
                            <th class=" mb-0 h6 text-sm"> {{__('Forward Number')}}</th>
                            <th class=" mb-0 h6 text-sm"> {{__('Extension')}}</th>
                            <th class=" mb-0 h6 text-sm"> {{__('Greetings')}}</th>
                            <th class=" mb-0 h6 text-sm"> {{__('Type')}}</th>
                            <th class=" mb-0 h6 text-sm"> {{__('Status')}}</th>
                            <th class="text-center"> {{__('Action')}}</th>
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

<!--<script type="text/javascript" src="{{ asset('datatables/datatables.min.js') }}"></script>-->



<script type="text/javascript">

$(document).on("click", ".destroyblog", function(){
        var id = $(this).attr('data-id');
        $("#department_id").val(id);
        $('#destroyblog').modal('show');
    });

$(function () {    
    var table = $('#example').DataTable({
         responsive: true,
        processing: true,
        serverSide: true,
        ajax: "{{ route('ivr.department_list') }}",
        columns: [
            {data: 'name', name: 'name'},
            {data: 'forward', name: 'forward'},
            {data: 'extension', name: 'extension'},
            {data: 'greeting', name: 'greeting'},
            {data: 'type', name: 'type'},
            {data: 'status', name: 'status'},
            {data: 'action', name: 'action', orderable:false}
        ]
    });
    
  });
</script>

@endpush