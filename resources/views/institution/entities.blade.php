<?php $page = "Entities"; ?>
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
               <a class="btn btn-sm btn-primary .btn-rounded float-right" href="{{route('pathway.entity.create')}}"  title="Add Entity">
               <span class="btn-inner--icon"><i class="fas fa-plus"></i></span>
               </a>
               <button class="btn btn-sm btn-white btn-icon-only rounded-circle ml-1 import_quotes" data-toggle="tooltip" data-original-title="{{__('Import Institution')}}">
    <span class="btn-inner--icon"><i class="fas fa-upload"></i></span>   
</button>

<a href="{{ asset('public') }}/csv/institution.csv" class="btn btn-sm btn-white btn-icon-only rounded-circle ml-1"   target="_blank" data-toggle="tooltip" data-original-title="{{__('Download Sample')}}">
    <span class="btn-inner--icon"><i class="fas fa-download"></i></span>
</a>
           </div>
                
   <!-- Breadcrumb -->
                <div class="breadcrumb-bar mt-3">
               <div class="container-fluid">
                  <div class="row align-items-center">
                     <div class="col-md-12 col-12">
                        <h2 class="breadcrumb-title">Pathway Entities</h2>
                        <nav aria-label="breadcrumb" class="page-breadcrumb">
                           <ol class="breadcrumb">
                              <li class="breadcrumb-item"><a href="{{route('home')}}">Home</a></li>
                              <li class="breadcrumb-item active" aria-current="page">Pathway Entities</li>
                           </ol>
                        </nav>
                     </div>
                  </div>
               </div>
            </div>
                <!-- /Breadcrumb -->
                
   
    
        
    
      
   

<div class="row mt-3" id="blog_category_view"  >
     
    
  <!-- list view -->
  <div class="col-12">
      <div class="card">
          <div class="card-body ">
              <form >
                        <div class="row">
                        <div class="form-group col-md-6  mb-2">
                           <div class="input-group input-group-sm input-group-merge input-group-flush">
            <div class="input-group-prepend">
                <span class="input-group-text bg-transparent"><i class="fas fa-search"></i></span>
            </div>
            <input type="text" id="support_keyword" class="form-control form-control-flush" placeholder="{{__('Search by title, address, state')}}">
        </div>
                        </div>
                        <div class="form-group col-md-3  mb-2">
                          <label for="filter_type" class="sr-only">Entity Type Filter</label>
                            <select id='filter_type' class="form-control" >
                                <option value="">All Types</option>
                                <option value="School" > School</option>
                    <option value="College"> College</option>
                    <option value="Library"> Library</option>
                    <option value="Company"> Company</option>
                    <option value="PHA Community"> PHA Community</option>
                    <option value="Mayor"> Mayor</option>
                    <option value="Justice Involved Officer"> Justice Involved Officer</option>
                    <option value="Military Base"> Military Base</option>
                            </select>
                        </div>
                        <div class="form-group col-md-3  mb-2">
                          <label for="filter_status" class="sr-only">Status Filter</label>
                            <select id='filter_status' class="form-control" >
                                <option value="">All Status</option>
                                <option value="Pending" > Pending</option>
                    <option value="Accepted"> Accepted</option>
                    <option value="Rejected"> Rejected</option>
                            </select>
                        </div>
                            
                        </div>
                                                   
                      </form>
              <div class="table_md-responsive">
                  <table class="table table-hover table-center mb-0" id="example" style="width:100% !important">
                     <thead class="thead-light">
                  <tr>
                                  <th class=" mb-0 h6 text-sm"> {{__('Type')}}</th>
                                  <th class=" mb-0 h6 text-sm"> {{__('Title')}}</th>
                                             <th class=" mb-0 h6 text-sm"> {{__('Address')}}</th>
                                             <th class=" mb-0 h6 text-sm"> {{__('City')}}</th>
                                             <th class=" mb-0 h6 text-sm"> {{__('State')}}</th>
                                             <th class=" mb-0 h6 text-sm"> {{__('Zip')}}</th>
                                             <th class=" mb-0 h6 text-sm"> {{__('Status')}}</th>
                                             <th class=" mb-0 h6 text-sm"> {{__('User')}}</th>
                                             <th class="text-right name mb-0 h6 text-sm"> {{__('Action')}}</th>
                        </tr>
                      </thead>
                     
                  </table>
              </div>
          </div> 	
      </div>
  </div> 
    <!-- list view -->
</div>
    

            </div>
        </div>

    </div>
</div>		
<!-- /Page Content -->


@endsection
@push('script')

<script type="text/javascript">

 $(document).on("click", ".import_quotes", function(){
       $('#import_divInstitute').modal('show');
   });

    $(function () {
        var table = $('#example').DataTable({
            processing: true,
            serverSide: true,
             "bFilter": false,
             ajax: {
                        url: "{{ route('pathway.entities') }}",
                        data: function (d) {
                                d.filter_type = $('#filter_type').val()
                                d.filter_status = $('#filter_status').val()
                                d.filter_category = $('#filter_category').val()
                                d.keyword = $('#support_keyword').val()
                        }
                    },
            columns: [
    {data: 'type', name: 'type', orderable: true,searchable: true},
    {data: 'institution', name: 'institution', orderable: true,searchable: true},
               {data: 'address', name: 'address', orderable: true,searchable: true},
               {data: 'city', name: 'city', orderable: true,searchable: true},
               {data: 'state', name: 'state', orderable: true,searchable: true},
               {data: 'zip', name: 'zip', orderable: true,searchable: true},
               {data: 'status', name: 'status'},
               {data: 'user', name: 'user'},
                {
                   data: 'action', 
                   name: 'action', 
                   orderable: false, 
                   searchable: false
               },
            ]
        });
        $('#filter_status').change(function(){
                    table.draw();
                });
        $('#filter_type').change(function(){
                    table.draw();
                });
        $('#filter_category').change(function(){
                    table.draw();
                });
                  $(document).on('keyup', '#support_keyword', function () {
            table.draw();
            });
    
        });
 
    </script>
	
   
   
@endpush


