<?php $page = "dashboard"; ?>
@section('title')
    {{$page??''}}
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
                <!-- Breadcrumb -->
<!--                <div class="breadcrumb-bar mb-3">
                    <div class="container-fluid">
                        <div class="row align-items-center">
                            <div class="col-md-12 col-12">
                                <h2 class="breadcrumb-title">Dashboard</h2>
                                <nav aria-label="breadcrumb" class="page-breadcrumb">
                                    <ol class="breadcrumb">
                                        <li class="breadcrumb-item"><a href="{{url('/')}}">Home</a></li>
                                        <li class="breadcrumb-item active" aria-current="page">Dashboard</li>
                                    </ol>
                                </nav>
                            </div>
                        </div>
                    </div>
                </div>-->
                <!-- /Breadcrumb -->
               
                     @php
        $user=Auth::user();
        $permissions=permissions();
        @endphp
         @if(in_array("manage_domain_users",$permissions) || $user->type =="admin")
                     @php
                     $domain_user=get_domain_user();
					 if(!empty($domain_user)){
                     $usertypes=\App\User::selectRaw('type,count(type) as count')->where('created_by',$domain_user->id)->groupBy('type')->get();
                }
				 $profile_totals=0;
                     @endphp
                     @endif
                     <script type="text/javascript">
    var profiledata=[];
    var profilelabels=[];
    @if(!empty($usertypes) && count($usertypes)>0)
      @foreach($usertypes as $row)
           profilelabels.push('{{ucfirst($row->type)}}');
           profiledata.push({{$row->count}});
           @php
           $profile_totals +=$row->count;
           @endphp
              @endforeach
              @endif
              </script>
                <div class="row ">
                    <div class="col-lg-12 col-sm-12">
                <div class="card">
                    <div class="bg-info-light">
                        <div class="row">
                            <div class="col-7">
                                <div class="text-primary p-3">
                                    <h5 class="text-primary">Welcome Back <b>{{$user->name}}</b> !</h5>
                                    <!--<p class="mb-3">Mentoring Panel</p>-->
                                </div>
                            </div>
                            
                        </div>
                    </div>
                    
                </div>
            </div>
            </div>
               <div class="row blockWithFilter">
              @if(in_array("manage_domain_users",$permissions) || $user->type =="admin")
                    <div class="col-md-12 col-lg-4 dash-board-list blue">
                        <div class="dash-widget">
                            <div class="circle-bar">
                                <div class="icon-col">
                                    <i class="fas fa-users"></i>
                                </div>
                            </div>
                            <div class="dash-widget-info">
                                <h3 data-id="profiles">{{!empty($profile_totals)?$profile_totals:0}}</h3>
                                <h6>Profiles</h6>															
                            </div>
                        </div>
                    </div>
              @else
               <div class="col-md-12 col-lg-4 dash-board-list blue">
                  <div class="dash-widget">
                            <div class="circle-bar">
                                <div class="icon-col">
                                    <i class="fas fa-paper-plane"></i>
                                </div>
                            </div>
                            <div class="dash-widget-info">
                                @php
                                $invoices = \App\UserPayment::where('user_id',$user->id)->count();
                                @endphp
                                <h3 data-id="invoices">{{!empty($invoices)?$invoices:0}}</h3>
                                <h6>Invoices</h6>															
                            </div>
                        </div>
                    </div>
              @endif

                    <div class="col-md-12 col-lg-4 dash-board-list yellow">
                        <div class="dash-widget">
                            <div class="circle-bar">
                                <div class="icon-col">
                                    <i class="fas fa-calendar-check"></i>
                                </div>
                            </div>
                            <div class="dash-widget-info">
                                @php
                                $appointments = \App\MeetingScheduleSlot::where('user_id', '=',$user->id)->count();
                                @endphp
                                  <h3 data-id="appointments">{{!empty($appointments)?$appointments:0}}</h3>
                                <h6>Appointments</h6>															
                            </div>
                        </div>
                    </div>

                    <div class="col-md-12 col-lg-4 dash-board-list pink">
                        <div class="dash-widget">
                            <div class="circle-bar">
                                <div class="icon-col">
                                    <i class="fas fa-wallet"></i>
                                </div>
                            </div>
                            <div class="dash-widget-info">
                                @if(in_array("manage_sub_domain",$permissions) || $user->type =="admin")
                                @php
                                $earned = \App\UserPayment::where('paid_to_user_id',$user->id)->sum('amount');
                                @endphp
                                <h3 data-id="totalearned">{{format_price(!empty($earned)?$earned:0)}}</h3>
                                <h6>Total Earned</h6>	
                                
                                @else
                                
                                @php
                                $totalpaid = \App\UserPayment::where('user_id',$user->id)->sum('amount');
                                @endphp
                                <h3 data-id="totalpaid">{{format_price(!empty($totalpaid)?$totalpaid:0)}}</h3>
                                <h6>Total Paid</h6>	
                                
                                
                                @endif
                            </div>
                        </div>
                    </div>

                </div>
 @if(in_array("manage_domain_users",$permissions) || $user->type =="admin")
                    
                     @if(!empty($usertypes) && count($usertypes)>0)
                   <div class="row mt-4">
                    <div class="col-md-12">
                         <h4 class="mb-0">Profile Types</h4>
                         <div id="usertypebar"></div>
                    </div>
                    
                </div>
                     @endif
                     @endif
                
                     
               
                     
                     <div class="row" id="invoices_div">
                    <div class="col-md-12">
                        <h4 class="mb-4">Recent Invoices List</h4>
                        <div class="card card-table">
                            <div class="card-body">
                                <form class="form-inline">
                        <div class="form-group mx-sm-3 mb-2">
                          <label for="filter_status" class="sr-only">Invoice Type</label>
                            <select id='filter_status' class="form-control" style="width: 200px">
                                <option value="">All Invoices</option>
                                <option value="1">Paid</option>
                                <option value="2">Received</option>
                            </select>
                        </div>
                                                   
                      </form>
                                <div class="table-center">
                                    <table class="table table-hover table-center mb-0" id="invoices_table">
                                        <thead class="thead-light">
                                            <tr>
                                                <th>INVOICE NO</th>
                                                <th>PAID TO</th>
                                                <th>PAID BY</th>
                                                <th>PAID ON</th>
                                                <th class="text-center">AMOUNT</th>
                                                <th class="text-center">ACTION</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr>
                                                <td colspan="5" class="text-center">No Invoice Paid Yet</td>
                                                
                                            </tr>
                                        </tbody>
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

@if(!empty($usertypes) && count($usertypes) > 0)
<!-- Chart JS -->
<script src="{{ asset('public/assets_admin/plugins/apexchart/apexcharts.min.js') }}"></script>

<script type="text/javascript">
    var profiledata=[];
    var profilelabels=[];
      @foreach($usertypes as $row)
           profilelabels.push('{{ucfirst($row->type)}}');
           profiledata.push({{$row->count}});
              @endforeach
    var options = {
          series: [{
          data: profiledata
        }],
          chart: {
          type: 'bar',
          height: 300
        },
        plotOptions: {
          bar: {
            barHeight: '75%',
            distributed: true,
            horizontal: true,
            dataLabels: {
              position: 'bottom'
            },
          }
        },
        colors: ['#33b2df', '#546E7A', '#d4526e', '#13d8aa', '#A5978B', '#2b908f', '#f9a3a4', '#90ee7e',
          '#f48024', '#69d2e7'
        ],
        dataLabels: {
          enabled: true,
          textAnchor: 'start',
          style: {
            colors: ['#fff']
          },
          formatter: function (val, opt) {
            return opt.w.globals.labels[opt.dataPointIndex] + ":  " + val
          },
          offsetX: 0,
          dropShadow: {
            enabled: true
          }
        },
        stroke: {
          width: 1,
          colors: ['#fff']
        },
        xaxis: {
          categories:profilelabels,
        },
        yaxis: {
          labels: {
            show: false
          }
        },
//        title: {
//            text: 'User Profile Types',
//            align: 'left',
//            floating: true
//        },
        subtitle: {
            text: 'User Roles as Labels inside bars',
            align: 'center',
        },
        tooltip: {
          theme: 'dark',
          x: {
            show: false
          },
          y: {
            title: {
              formatter: function () {
                return ''
              }
            }
          }
        }
        };

        var chart = new ApexCharts(document.querySelector("#usertypebar"), options);
        chart.render();
      
     
</script>

@endif


<script type="text/javascript">    
      $(function () {
        var table = $('#invoices_table').DataTable({
           responsive: true,
            processing: true,
              "bPaginate": true,
                "bInfo": false, // hide showing entries
            serverSide: true,
             "bFilter": false,
    
             ajax: {
                        url: "{{ route('user.invoices') }}",
                        data: function (d) {
//                                d.filter_type = $('#filtertype').val()
                                d.filter_status = $('#filter_status').val()
                        }
                    },
            columns: [
//                {data: 'DT_RowIndex', name: 'DT_RowIndex', orderable: false, searchable: false},
                {data: 'order_id', name: 'order_id', orderable: true, searchable: true},
                {data: 'paidto', name: 'paidto', orderable: false, searchable: true},
                {data: 'paidby', name: 'paidby', orderable: false, searchable: true},
                {data: 'created_at', name: 'created_at', orderable: false, searchable: true},
                {data: 'amount', name: 'amount', orderable: false, searchable: true},
                {data: 'action', name: 'action', orderable: false},
            ]
        });
         $('#filter_status').change(function(){
                    table.draw();
                });
        });


        jQuery(function($) {
  var token = '530014071410514|f3e76210771be89088e974d8c3615737';
  $('#get_shares').submit(function(){
    $.ajax({
      url: 'https://graph.facebook.com/v3.0/',
	    dataType: 'jsonp',
	    type: 'GET',
	    data: {fields:'engagement', access_token: token, id: 'https://www.facebook.com/photo/?fbid=363147348549875&set=a.363147375216539' },
	    success: function(data){
        console.log(data);
 		    $('#results').html('<strong>Number of shares:</strong> ' + data.engagement.share_count);
	    }
    });
    return false;
  });
});
</script>
@endpush
