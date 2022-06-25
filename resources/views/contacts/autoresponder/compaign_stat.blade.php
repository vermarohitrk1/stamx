<?php $page = "Auto Responder Statistics"; ?>
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
                    <a href="{{ route('autoresponder.index') }}" class="btn btn-sm btn btn-primary float-right mr-1" >
        <span class="btn-inner--icon"><i class="fas fa-reply"></i></span>
    </a>
                     </div>
   
<!-- Breadcrumb -->
<div class="breadcrumb-bar mt-3">
    <div class="container-fluid">
        <div class="row align-items-center">
            <div class="col-md-12 col-12">
                <h2 class="breadcrumb-title">Auto Responder Statistics</h2>
                <nav aria-label="breadcrumb" class="page-breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{route('dashboard')}}">Home</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Auto Responder Statistics</li>
                    </ol>
                </nav>
            </div>              
        </div>            
    </div>
</div>
<!-- /Breadcrumb -->


<div class="row mt-3">
                    

                    <div class="col-md-12 col-lg-3 dash-board-list green">
                        <div class="dash-widget">
                            <div class="circle-bar">
                                <div class="icon-col">
                                    <i class="fa fa-envelope-open"></i>
                                </div>
                            </div>
                            <div class="dash-widget-info">
                                <h3>{{($success??0)}}</h3>
                                <h6>{{__('Successful Emails')}}</h6>															
                            </div>
                        </div>
                    </div>

                    <div class="col-md-12 col-lg-3 dash-board-list pink">
                        <div class="dash-widget">
                            <div class="circle-bar">
                                <div class="icon-col">
                                    <i class="fa fa-envelope"></i>
                                </div>
                            </div>
                            <div class="dash-widget-info">
                                <h3>{{($unsuccess??0)}}</h3>
                                <h6>{{__('Unsuccessful Emails')}}</h6>															
                            </div>
                        </div>
                    </div>
                    <div class="col-md-12 col-lg-3 dash-board-list green">
                        <div class="dash-widget">
                            <div class="circle-bar">
                                <div class="icon-col">
                                    <i class="fa fa-envelope-open-text"></i>
                                </div>
                            </div>
                            <div class="dash-widget-info">
                                <h3>{{($successsms??0)}}</h3>
                                <h6>{{__('Successful SMS')}}</h6>															
                            </div>
                        </div>
                    </div>

                    <div class="col-md-12 col-lg-3 dash-board-list pink">
                        <div class="dash-widget">
                            <div class="circle-bar">
                                <div class="icon-col">
                                    <i class="fa fa-envelope-open"></i>
                                </div>
                            </div>
                            <div class="dash-widget-info">
                                <h3>{{($unsuccesssms??0)}}</h3>
                                <h6>{{__('Unsuccessful SMS')}}</h6>															
                            </div>
                        </div>
                    </div>
                </div>

<br>

<div class="row " id="blog_view">
     <div class="col-12">
        <div class="card">
            <div class="card-body ">
                <form class="form-inline">
                        <div class="form-group mx-sm-3 mb-2">
                          <label for="inputPassword2" class="sr-only">Status</label>
                            <select id='status' class="form-control" style="width: 200px">
                                <option value="">--Select Status--</option>
                                <option value="0">Successful</option>
                                <option value="1">Unsuccessful</option>
                            </select>
                        </div>
                                               
                      </form>
                <div class="table-md-responsive">                    
                    <table class="table  table-hover table-center mb-0" id="yajra-datatable">
                        <thead class="thead-light ">
                              <tr>
                                <th > {{__(' Email/Phone')}}</th>
                        <th > {{__(' Status')}}</th>
                        <th > {{__('Status Message')}}</th>
                        <th > {{__(' Time')}}</th>
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


<script type="text/javascript">
    

    $(function () {    
    var table = $('#yajra-datatable').DataTable({
         responsive: true,
        processing: true,
        serverSide: true,
        "bFilter": true,
       ajax: {
                        url: "{{ url('/autoresponder/statistics').'/'.$id_encrypted }}",
                        data: function (d) {
                                d.status = $('#status').val()
                        }
                    },
        columns: [
           {data: 'email', name: 'email'},
            {data: 'status', name: 'status'},
            {
                data: 'message', 
                name: 'message', 
                orderable: false, 
                searchable: false
            },
            {
                data: 'time', 
                name: 'time', 
                orderable: false, 
                searchable: false
            },
        ]
    });
      $('#status').change(function(){
                    table.draw();
                });
  });

</script>


@endpush
