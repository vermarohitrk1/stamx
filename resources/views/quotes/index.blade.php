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
              
               <a class="btn btn-sm btn-primary .btn-rounded float-right" href="#" data-ajax-popup="true" data-url="{{ route('quotes.create') }}" data-size="md" data-title="Add Quote">
            <span class="btn-inner--icon"><i class="fas fa-plus"></i></span>
        </a>

        <button class="btn btn-sm btn-white btn-icon-only rounded-circle ml-1 import_quotes" data-toggle="tooltip" data-original-title="{{__('Import Quotes')}}">
    <span class="btn-inner--icon"><i class="fas fa-upload"></i></span>   
</button>

<a href="{{ asset('public') }}/csv/quotes.csv" class="btn btn-sm btn-white btn-icon-only rounded-circle ml-1"   target="_blank" data-toggle="tooltip" data-original-title="{{__('Download Sample')}}">
    <span class="btn-inner--icon"><i class="fas fa-download"></i></span>
</a>
                     </div>
   
<!-- Breadcrumb -->
<div class="breadcrumb-bar mt-3">
    <div class="container-fluid">
        <div class="row align-items-center">
            <div class="col-md-12 col-12">
                <h2 class="breadcrumb-title">Quotes</h2>
                <nav aria-label="breadcrumb" class="page-breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="index">Home</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Quotes</li>
                    </ol>
                </nav>
            </div>              
        </div>            
    </div>
</div>
<!-- /Breadcrumb -->



<br>


<div class="row" id="blog_view">
     <div class="col-12">
        <div class="card">
            <div class="card-body">
                <div class="table-md-responsive">
                    <table class="table table-hover table-center mb-0" id="example">
                        <thead class="thead-light">
                        <tr>
                           
                            <th class=" mb-0 h6 text-sm"> {{__('Quote')}}</th>
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

$(document).on("click", ".import_quotes", function(){
    $('#import_div1').modal('show');
});

$(function () {    
    var table = $('#example').DataTable({
         responsive: true,
        processing: true,
        serverSide: true,
        ajax: "{{ url('admin/quotes') }}",
        columns: [
          
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