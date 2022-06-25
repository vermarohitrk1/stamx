<?php $page = "Help Desk"; ?>
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
                    @if(Auth::user()->type != 'admin')
           <a href="{{ route('support.create') }}" class="btn btn-sm btn btn-primary float-right "  data-title="{{__('Create Ticket')}}">
        <span class="btn-inner--icon"><i class="fas fa-plus"></i></span>
    </a>
                    @endif
             
       @if(in_array("manage_help_desk",$permissions) || $user->type =="admin")    
        <a href="{{ route('supportCategory.index')}}" class="btn btn-sm btn btn-primary float-right mr-2 m-0">
        <span class="btn-inner--text ">{{__('Categories')}}</span>
    </a>
                    <a href="{{ route('support.settings') }}" class="btn btn-sm btn btn-primary float-right mr-2 m-0">
        <span class="btn-inner--text ">{{__('Support Closed Settings')}}</span>
    </a>
<!--                    <a href="{{ route('faq.index') }}" class="btn btn-sm btn btn-primary float-right mr-2 m-0">
        <span class="btn-inner--text ">{{__('FAQs')}}</span>
    </a>-->
       @endif
                   
                     </div>
                
   <!-- Breadcrumb -->
                <div class="breadcrumb-bar mb-3">
                    <div class="container-fluid">
                        <div class="row align-items-center">
                            <div class="col-md-12 col-12">
                                <h2 class="breadcrumb-title">Help Desk</h2>
                                <nav aria-label="breadcrumb" class="page-breadcrumb">
                                    <ol class="breadcrumb">
                                        <li class="breadcrumb-item"><a href="{{route('dashboard')}}">Dashboard</a></li>
                                        <li class="breadcrumb-item active" aria-current="page">Help Desk</li>
                                    </ol>
                                </nav>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- /Breadcrumb -->
                
   
    @if(Auth::user()->type != 'admin' )
<div class="row blockWithFilter">
                    <div class="col-md-12 col-lg-3 dash-board-list yellow">
                        <div class="dash-widget">
                            <div class="circle-bar">
                                <div class="icon-col">
                                    <i class="fas fa-arrow-circle-up"></i>
                                </div>
                            </div>
                            <div class="dash-widget-info">
                             
                                  <h3 data-id="sentnew">@if(!empty($stats['sent_new'])){{ number_format($stats['sent_new'], 0) }} @else {{__('0')}} @endif</h3>
                                <h6>New</h6>															
                            </div>
                        </div>
                    </div>
                    <div class="col-md-12 col-lg-3 dash-board-list blue">
                        <div class="dash-widget">
                            <div class="circle-bar">
                                <div class="icon-col">
                                    <i class="fa fa-arrow-circle-up"></i>
                                </div>
                            </div>
                            <div class="dash-widget-info">
                             
                                  <h3 data-id="sentopen">@if(!empty($stats['sent_open'])){{$stats['sent_open']}} @else {{__('0')}} @endif</h3>
                                <h6>Open</h6>															
                            </div>
                        </div>
                    </div>
                    
                    <div class="col-md-12 col-lg-3 dash-board-list pink">
                        <div class="dash-widget">
                            <div class="circle-bar">
                                <div class="icon-col">
                                    <i class="fas fa-arrow-circle-up"></i>
                                </div>
                            </div>
                            <div class="dash-widget-info">
                            
                                <h3 data-id="sentclose">@if(!empty($stats['sent_closed'])){{ number_format($stats['sent_closed'], 0) }} @else {{__('0')}} @endif</h3>
                                <h6>Close</h6>	
                                
                                
                            </div>
                        </div>
                    </div>
                    <div class="col-md-12 col-lg-3 dash-board-list green">
                        <div class="dash-widget">
                            <div class="circle-bar">
                                <div class="icon-col">
                                    <i class="fa fa-arrow-circle-up"></i>
                                </div>
                            </div>
                            <div class="dash-widget-info">
                            
                                <h3 data-id="senttotal">@if(!empty($stats['sent_total'])){{ number_format($stats['sent_total'], 0) }} @else {{__('0')}} @endif</h3>
                                <h6>Total</h6>	
                                
                                
                            </div>
                        </div>
                    </div>
                </div>
    @endif
    @if(in_array("manage_help_desk",$permissions) || $user->type =="admin")       
   <div class="accordion" id="accordionExample">

<div class="card">
  <div class="card-header" id="headingTwo">
    <h2 class="mb-0">
      <button class="btn btn-link btn-block text-left" type="button" data-toggle="collapse" data-target="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">
        Received Tickets Statistics
      </button>
    </h2>
  </div>
  <div id="collapseTwo" class="collapse " aria-labelledby="headingTwo" data-parent="#accordionExample">
         <div class="row blockWithFilter">
                    <div class="col-md-12 col-lg-3 dash-board-list yellow">
                        <div class="dash-widget">
                            <div class="circle-bar">
                                <div class="icon-col">
                                    <i class="fas fa-arrow-circle-down"></i>
                                </div>
                            </div>
                            <div class="dash-widget-info">
                             
                                  <h3 data-id="new">@if(!empty($stats['new'])){{ number_format($stats['new'], 0) }} @else {{__('0')}} @endif</h3>
                                <h6>New</h6>															
                            </div>
                        </div>
                    </div>
                    <div class="col-md-12 col-lg-3 dash-board-list blue">
                        <div class="dash-widget">
                            <div class="circle-bar">
                                <div class="icon-col">
                                    <i class="fa fa-arrow-circle-down"></i>
                                </div>
                            </div>
                            <div class="dash-widget-info">
                             
                                  <h3 data-id="open">@if(!empty($stats['open'])){{$stats['open']}} @else {{__('0')}} @endif</h3>
                                <h6>Open</h6>															
                            </div>
                        </div>
                    </div>
                    
                    <div class="col-md-12 col-lg-3 dash-board-list pink">
                        <div class="dash-widget">
                            <div class="circle-bar">
                                <div class="icon-col">
                                    <i class="fas fa-arrow-circle-down"></i>
                                </div>
                            </div>
                            <div class="dash-widget-info">
                          
                                <h3 data-id="close">@if(!empty($stats['closed'])){{ number_format($stats['closed'], 0) }} @else {{__('0')}} @endif</h3>
                                <h6>Close</h6>	
                                
                                
                            </div>
                        </div>
                    </div>
                    <div class="col-md-12 col-lg-3 dash-board-list green">
                        <div class="dash-widget">
                            <div class="circle-bar">
                                <div class="icon-col">
                                    <i class="fa fa-arrow-circle-down"></i>
                                </div>
                            </div>
                            <div class="dash-widget-info">
                                <h3 data-id="totalreceived">@if(!empty($stats['total_recieved'])){{ number_format($stats['total_recieved'], 0) }} @else {{__('0')}} @endif</h3>
                                <h6>Total</h6>	
                                
                                
                            </div>
                        </div>
                    </div>
                </div>
    </div>
  </div>

 </div> 

   @endif
<div class="row mt-3" id="blog_category_view">
  
  <!-- list view -->
  <div class="col-12">
      <div class="card">
          <div class="card-body ">
              <form class="form-inline">
                        <div class="row">
                        <div class="form-group col-md-3  mb-2">
                           <div class="input-group input-group-sm input-group-merge input-group-flush">
            <div class="input-group-prepend">
                <span class="input-group-text bg-transparent"><i class="fas fa-search"></i></span>
            </div>
            <input type="text" id="support_keyword" class="form-control form-control-flush" placeholder="{{__('Search by ticket/subject..')}}">
        </div>
                        </div>
                        <div class="form-group col-md-3  mb-2">
                          <label for="filter_status" class="sr-only">Status</label>
                            <select id='filter_status' class="form-control" style="width: 200px">
                                <option value="">All Status</option>
                                <option value="New">New</option>
                                <option value="Open">Open</option>
                                <option value="Closed">Closed</option>
                            </select>
                        </div>
                        <div class="form-group col-md-3  mb-2">
                          <label for="filter_type" class="sr-only">Type</label>
                            <select id='filter_type' class="form-control" style="width: 200px">
                                <option value="">All Type</option>
                                <option value="sent">Sent</option>
                                <option value="recieved">Recieved</option>
                            </select>
                        </div>
                            @if(!empty($categories) && count($categories)>0)
                        <div class="form-group col-md-3  mb-2">
                          <label for="filter_status" class="sr-only">Category</label>
                            <select id='filter_category' class="form-control" style="width: 200px">
                                 <option value="">All Categories</option>
                                 @foreach($categories as $key => $val)
                                <option value="{{ $val->id }}">{{__($val->name)}}</option>
                                @endforeach
                            </select>
                        </div>
                            @endif
                        </div>
                                                   
                      </form>
              <div class="table_md-responsive">
                  <table class="table table-hover table-center mb-0" id="example">
                     <thead class="thead-light">
                      <tr>
                                        <th>Submitted By</th>
                                        <th>Ticket/Subject</th>
                                        <th>Category</th>
                                        <th>Status</th>
                                        <th>Type</th>
                                        <th>Time</th>

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
                        url: "{{ route('support.view') }}",
                        data: function (d) {
                                d.filter_type = $('#filter_type').val()
                                d.filter_status = $('#filter_status').val()
                                d.filter_category = $('#filter_category').val()
                                d.keyword = $('#support_keyword').val()
                        }
                    },
            columns: [
//                {data: 'DT_RowIndex', name: 'DT_RowIndex', orderable: false, searchable: false},
                {data: 'user', name: 'user', orderable: false, searchable: true},
                {data: 'subject', name: 'subject', orderable: false, searchable: true},
                {data: 'category', name: 'category', orderable: false, searchable: true},
                {data: 'status', name: 'status', orderable: false, searchable: true},
                {data: 'type', name: 'type', orderable: false, searchable: true},
                {data: 'time', name: 'time', orderable: false, searchable: true},
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


