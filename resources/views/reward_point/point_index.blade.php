@php $page = "Badges"; @endphp
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
           
   
<!-- Breadcrumb -->
<div class="breadcrumb-bar mt-3">
    <div class="col-md-12">
        {{--<a href="{{  route('create.points') }}" class="btn btn-sm btn btn-primary float-right " data-title="Add Blog Post">
            <span class="btn-inner--icon"><i class="fas fa-plus"></i></span>
        </a>--}}
    </div>
    <div class="container-fluid">
        <div class="row align-items-center">
            <div class="col-md-12 col-12">
                <h2 class="breadcrumb-title">Points</h2>
                <nav aria-label="breadcrumb" class="page-breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{route('dashboard')}}">Home</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Points</li>
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
                            <th class=" mb-0 h6 text-sm"> {{__('Point')}}</th>
                            <th class=" mb-0 h6 text-sm"> {{__('Description')}}</th>
                            <th class=" mb-0 h6 text-sm"> {{__('Duplicate')}}</th>
                            <th class=" mb-0 h6 text-sm"> {{__('Gamify Group')}}</th>
                            <th class="text-right name mb-0 h6 text-sm"> {{__('Action')}}</th>
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


$(function () {    
    var table = $('#example').DataTable({
         responsive: true,
        processing: true,
        serverSide: true,
        ajax: "{{ route('points') }}",
        columns: [
            {data: 'name', name: 'name'},
            {data: 'point', name: 'point'},
            {data: 'description', name: 'description'},
            {data: 'allow_duplicate', name: 'allow_duplicate'},
            {data: 'gamify_group', name: 'gamify_group'},
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