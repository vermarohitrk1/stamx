<?php $page = "My Chores"; ?>
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
                  
       @if(in_array("manage_chores",$permissions) || $user->type =="admin") 
       
        <a href="{{ route('chore.dashboard')}}" class="btn btn-sm btn btn-primary float-right mr-2 m-0">
        <span class="btn-inner--text ">{{__('Manage Chores')}}</span>
    </a>
      
      
       @endif
                   
                     </div>
                
   <!-- Breadcrumb -->
                <div class="breadcrumb-bar mb-3">
                    <div class="container-fluid">
                        <div class="row align-items-center">
                            <div class="col-md-12 col-12">
                                <h2 class="breadcrumb-title">My Chores</h2>
                                <nav aria-label="breadcrumb" class="page-breadcrumb">
                                    <ol class="breadcrumb">
                                        <li class="breadcrumb-item"><a href="{{route('dashboard')}}">Dashboard</a></li>
                                        <li class="breadcrumb-item active" aria-current="page">My Chores</li>
                                    </ol>
                                </nav>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- /Breadcrumb -->
                

<div class="row blockWithFilter">
                    
                    <div class="col-md-12 col-lg-4 dash-board-list blue">
                        <div class="dash-widget">
                            <div class="circle-bar">
                                <div class="icon-col">
                                    <i class="fa fa-tasks"></i>
                                </div>
                            </div>
                            <div class="dash-widget-info">
                             
                                  <h3 data-id="total">@if(!empty($totalsch)){{$totalsch}} @else {{__('0')}} @endif</h3>
                                <h6>Total</h6>															
                            </div>
                        </div>
                    </div>
                    
                    <div class="col-md-12 col-lg-4 dash-board-list pink">
                        <div class="dash-widget">
                            <div class="circle-bar">
                                <div class="icon-col">
                                    <i class="fas fa-arrow-circle-up"></i>
                                </div>
                            </div>
                            <div class="dash-widget-info">
                            
                                <h3 data-id="open">@if(!empty($opensch)){{ number_format($opensch, 0) }} @else {{__('0')}} @endif</h3>
                                <h6>Open</h6>	
                                
                                
                            </div>
                        </div>
                    </div>
                    <div class="col-md-12 col-lg-4 dash-board-list green">
                        <div class="dash-widget">
                            <div class="circle-bar">
                                <div class="icon-col">
                                    <i class="fa fa-arrow-circle-down"></i>
                                </div>
                            </div>
                            <div class="dash-widget-info">
                            
                                <h3 data-id="close">@if(!empty($closedsch)){{ number_format($closedsch, 0) }} @else {{__('0')}} @endif</h3>
                                <h6> Closed</h6>	
                                
                                
                            </div>
                        </div>
                    </div>
                </div>

  
<div class="row mt-3" id="blog_category_view">
  
  <!-- list view -->
  <div class="col-12">
      <div class="card">
          <div class="card-body ">
              <form class="form-inline">
                        <div class="row">
                        <div class="form-group col-md-6  mb-2">
                           <div class="input-group input-group-sm input-group-merge input-group-flush">
            <div class="input-group-prepend">
                <span class="input-group-text bg-transparent"><i class="fas fa-search"></i></span>
            </div>
            <input type="text" id="chore_keyword" class="form-control form-control-flush" placeholder="{{__('Search by name..')}}">
        </div>
                        </div>
                        
                        <div class="form-group col-md-4  mb-2">
                          <label for="filter_type" class="sr-only">Type</label>
                            <select id='filter_type' class="form-control" style="width: 200px">
                                <option value="">All Type</option>
                                <option value="Active">Active</option>
                                <option value="Inactive">InActive</option>
                            </select>
                        </div>
                            
                        </div>
                                                   
                      </form>
              <div class="table_md-responsive">
                  <table class="table table-hover table-center mb-0" id="example">
                     <thead class="thead-light">
                      <tr>
                                   <th class=" mb-0 h6 text-sm"> {{__('Chore')}}</th>
                            <!--<th class=" mb-0 h6 text-sm"> {{__('Price')}}</th>-->
                            <th class=" mb-0 h6 text-sm"> {{__('Type')}}</th>
                            <th class=" mb-0 h6 text-sm"> {{__('Due Day')}}</th>
                            <th class=" mb-0 h6 text-sm"> {{__('Date')}}</th>
                            <th class="text-right class="name mb-0 h6 text-sm> {{__('Time')}}</th>

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
                        url: "{{ route('chore.mydashboard') }}",
                        data: function (d) {
                                d.filter_type = $('#filter_type').val()
//                                d.filter_status = $('#filter_status').val()
                                d.filter_category = $('#filter_category').val()
                                d.keyword = $('#chore_keyword').val()
                        }
                    },
           columns: [
        
             //{data: 'DT_RowIndex', name: 'DT_RowIndex'},
                {data: 'chore', name: 'chore',orderable: false,searchable: true},
//                {data: 'price', name: 'price',orderable: false},
                {data: 'type', name: 'type',orderable: false},
                {data: 'day', name: 'day',orderable: false},
                {data: 'date', name: 'date',orderable: false},
                {
                    data: 'time', 
                    name: 'time', 
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


