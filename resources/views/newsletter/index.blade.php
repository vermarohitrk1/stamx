<?php $page = "Users"; ?>
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
                <div class="breadcrumb-bar mb-3">
                    <div class="container-fluid">
                        <div class="row align-items-center">
                            <div class="col-md-12 col-12">
                                <h2 class="breadcrumb-title">List of Volunteer</h2>
                                <nav aria-label="breadcrumb" class="page-breadcrumb">
                                    <ol class="breadcrumb">
                                        <li class="breadcrumb-item"><a href="{{route('dashboard')}}">Dashboard</a></li>
                                        <li class="breadcrumb-item active" aria-current="page">Volunteer</li>
</li>
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
              <div class="table_md-responsive">
                  <table class="table table-hover table-center mb-0" id="example">
                     <thead class="thead-light">
                      <tr> 
                                        <th>User Name</th>
                                        <th>Role</th>
                                        <th>Member Since</th>
                                        <th class="text-center">Action</th>
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
                        url: "{{ route('newsletter.index') }}",
                        data: function (d) {
                                d.filter_type = $('#filtertype').val()
                                d.filter_status = $('#filter_status').val()
                        }
                    },
            columns: [
                {data: 'user_name', name: 'user_name', orderable: false, searchable: true},
                {data: 'type', name: 'type', orderable: false, searchable: true},
                {data: 'created_at', name: 'created_at', orderable: false, searchable: true},
                {data: 'action', name: 'action', orderable: false},
            ]
        });
$('#filtertype').change(function(){
                    table.draw();
                });
$('#filter_status').change(function(){
                    table.draw();
                });
    });

  

</script> 
   
@endpush


