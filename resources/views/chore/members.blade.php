<?php $page = "Household Members"; ?>
@section('title')
    {{$page}}
@endsection
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
                  
        <a href="{{ route('users') }}" class="btn btn-sm btn-primary float-right btn-icon-only ml-1 " >
        <span class="btn-inner--icon">Users List</span>
    </a>
        <a href="{{ route('chore.members.manage') }}" class="btn btn-sm btn-primary float-right btn-icon-only  ml-1" >
        <span class="btn-inner--icon">Manage Chore Members</span>
    </a>
        <a href="{{ route('chore.dashboard') }}" class="btn btn-sm btn-primary float-right btn-icon-only rounded-circle ml-1" >
        <span class="btn-inner--icon"><i class="fas fa-reply"></i></span>
    </a>
                   
                     </div>
                
   <!-- Breadcrumb -->
                <div class="breadcrumb-bar mb-3">
                    <div class="container-fluid">
                        <div class="row align-items-center">
                            <div class="col-md-12 col-12">
                                <h2 class="breadcrumb-title">Household Members</h2>
                                <nav aria-label="breadcrumb" class="page-breadcrumb">
                                    <ol class="breadcrumb">
                                        <li class="breadcrumb-item"><a href="{{route('dashboard')}}">Dashboard</a></li>
                                        <li class="breadcrumb-item active" aria-current="page">Household Members</li>
                                    </ol>
                                </nav>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- /Breadcrumb -->
              
<div class="row mt-3" id="blog_category_view">
  
  <!-- list view -->
  <div class="col-12">
      <div class="card">
          <div class="card-body ">
              <form class="form-inline">
                        <div class="row">
                        <div class="form-group col-md-12  mb-2">
                           <div class="input-group input-group-sm input-group-merge input-group-flush">
            <div class="input-group-prepend">
                <span class="input-group-text bg-transparent"><i class="fas fa-search"></i></span>
            </div>
            <input type="text" id="chore_keyword" class="form-control form-control-flush" placeholder="{{__('Search by name..')}}">
        </div>
                        </div>
                        
                        
                        </div>
                                                   
                      </form>
              <div class="table_md-responsive">
                  <table class="table table-hover table-center mb-0" id="example">
                     <thead class="thead-light">
                      <tr>
                                     <th> {{__('Name')}}</th>
                                <th> {{__('Email')}}</th>
                                <th> {{__('Role')}}</th>                              
                                <th> {{__('Action')}}</th>

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


    $(function () {
        var table = $('#example').DataTable({
            processing: true,
            serverSide: true,
             "bFilter": false,
             ajax: {
                        url: "{{ route('chore.members') }}",
                        data: function (d) {
                                d.filter_type = $('#filter_type').val()
//                                d.filter_status = $('#filter_status').val()
                                d.filter_category = $('#filter_category').val()
                                d.keyword = $('#chore_keyword').val()
                        }
                    },
           columns: [
              //{data: 'DT_RowIndex', name: 'DT_RowIndex'},
                        {data: 'name', name: 'name'},
                        {data: 'email', name: 'email'},
                        {data: 'type', name: 'type', orderable: false, searchable: false},
                      {
                            data: 'action',
                            name: 'action',
                            orderable: false,
                            searchable: false
                        },
        ],
        });
//        $('#filter_status').change(function(){
//                    table.draw();
//                });
        $('#filter_type').change(function(){
                    table.draw();
                });
        $('#filter_category').change(function(){
                    table.draw();
                });
                  $(document).on('keyup', '#chore_keyword', function () {
            table.draw();
            });
    
        });
</script> 

@endpush


