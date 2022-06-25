@php $page = "All Twilio Numbers"; @endphp
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
               <a href="{{ route('ivrsetting.buy_ivr_number') }}" class="btn btn-sm btn btn-primary float-right "  data-title="{{__('Buy Number')}}">
        <span class="btn-inner--icon"><i class="fas fa-plus"></i></span>
    </a>
              
                     </div>
   
<!-- Breadcrumb -->
<div class="breadcrumb-bar mt-3">
    <div class="container-fluid">
        <div class="row align-items-center">
            <div class="col-md-12 col-12">
                <h2 class="breadcrumb-title">All IVR Numbers</h2>
                <nav aria-label="breadcrumb" class="page-breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{route('dashboard')}}">Home</a></li>
                        <li class="breadcrumb-item active" aria-current="page">All IVR Numbers</li>
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
                            <th class="mb-0 h6 text-sm"> {{__('User')}}</th>
                            <th class="mb-0 h6 text-sm"> {{__('Number')}}</th>
                            <th class="mb-0 h6 text-sm"> {{__('SID')}}</th>
                            <th class="mb-0 h6 text-sm"> {{__('Added On')}}</th>
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
        ajax: "{{ route('ivrsetting.twilio_numbers.all') }}",
        columns: [
            {data: 'user', name: 'user'},
            {data: 'number', name: 'number'},
            {data: 'sid', name: 'sid'},
            {data: 'created_at', name: 'created_at'},
            
        ]
    });
    
  });
</script>

@endpush