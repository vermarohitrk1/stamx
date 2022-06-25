<?php $page = "Assessment Responses"; ?>
@extends('layout.dashboardlayout')
@section('content')	

     @php
        $user=Auth::user();
        $permissions=permissions();
        @endphp
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
               
       
                     <a href="{{ route('assessment.dashboard') }}" class="btn btn-sm btn btn-primary float-right mr-2 m-0">
        <span class="btn-inner--text ">{{__('Dashboard')}}</span>
    </a>
                     
                   
                     </div>
                
   <!-- Breadcrumb -->
                <div class="breadcrumb-bar mb-3">
                    <div class="container-fluid">
                        <div class="row align-items-center">
                            <div class="col-md-12 col-12">
                                <h2 class="breadcrumb-title">Assessment Responses</h2>
                                <nav aria-label="breadcrumb" class="page-breadcrumb">
                                    <ol class="breadcrumb">
                                        <li class="breadcrumb-item"><a href="{{route('dashboard')}}">Dashboard</a></li>
                                        <li class="breadcrumb-item"><a href="{{route('crmcustom.dashboard')}}">Surveys Dashboard</a></li>
                                        <li class="breadcrumb-item active" aria-current="page">Assessment Responses</li>
                                    </ol>
                                </nav>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- /Breadcrumb -->
                
   
     
<div class="row mt-3" id="blog_category_view">
    
        
<div class="col-lg-4 order-lg-2">
    <div id="page_sidebar_tabs"></div>
</div>
    {{--Main Part--}}
    <div class="col-lg-8 order-lg-1">
        <div id="tabs-1" class="tabs-card">
            <div class="card">
              <div class="card-header">
                   @if(in_array("manage_surveys",$permissions) || $user->type =="admin") 
                    <a href="{{ route('assessment.index') }}" class="btn btn-sm float-right btn-primary btn-icon rounded-pill mr-1 ml-1">
        <span class="btn-inner--text"><i class="fas fa-reply"></i></span>
    </a>
                  @endif 
                    <h3>{{$form->title}}</h3>
                <p class="text-muted mb-0">{{ ucfirst($form->description) }}</p>
                </div>
               
               
       
              <div class="card-body">
                  <br>
<div class="table_md-responsive">
                  <table class="table table_md-responsive table-hover table-center mb-0" id="myTableres" style="width:100% !important">
                     <thead class="thead-light">
                  <tr>
                             <th> {{__('Name')}}</th>
                                <th> {{__('Assigned At')}}</th>
                                <th> {{__('Payment')}}</th>
                                <th> {{__('Status')}}</th>
                                <th> {{__('Action')}}</th>
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

</div>		
<style>
    .dataTables_filter{
        margin-left: -108px !important;
    }
</style>
<!-- /Page Content -->
@endsection
@push('script')
<link rel="stylesheet" type="text/css" href="{{ asset('assets/libs/dragula/dist/dragula.min.css') }}">
<script src="{{ asset('assets/js/simcify.min.js') }}"></script>
    <script src="{{asset('assets/libs/dragula/dist/dragula.min.js')}}"></script>
    <script>
    $(document).ready(function(){
      $.ajax({
       url:"{{route('assessmentForm.sidebar',!empty($form->id) ? encrypted_key($form->id,'encrypt') :0)}}?sidebar=form_users_responses",
       success:function(data)
       {
        $('#page_sidebar_tabs').html(data);
       }
      });
    });
</script>
   <script type="text/javascript">  
   
   $(document).on("click", ".destroycrmcustomuser", function(){
    var id = $(this).attr('data-id');
    $("#response_Id").val(id);
    $('#destroy_response').modal('show');
    }); 
   
            
    </script>  

<script type="text/javascript">
        $(function () {
            var table = $('#myTableres').DataTable({
                processing: true,
                serverSide: true,
                ajax: "{{ route('assessmentForm.responseUsers',encrypted_key($id,'encrypt')) }}",
                columns: [
                    
                    {data: 'user', name: 'user',orderable: false, searchable: true},
            {data: 'date', name: 'date'},
            {data: 'payment', name: 'payment'},
            {data: 'status', name: 'status'},
                    {
                        data: 'action',
                        name: 'action',
                        orderable: false,
                        searchable: false
                    },
                ]
            });
            $("#myTableres_length").hide();
        });
    </script>
@endpush


