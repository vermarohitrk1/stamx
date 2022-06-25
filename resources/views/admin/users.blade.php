@extends('layout.mainlayout_admin')
@section('content')	
<!-- Page Wrapper -->
<div class="page-wrapper">
    <div class="content container-fluid">

        <!-- Page Header -->
        <div class="page-header">
            <div class="row">
                <div class="col-sm-12">
                    <h3 class="page-title">List of Users</h3>
                    <ul class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{route('dashboard')}}">Dashboard</a></li>
                        <li class="breadcrumb-item active">Users</li>
                    </ul>
                </div>
            </div>
        </div>
        <!-- /Page Header -->

        <div class="row">
            <div class="col-sm-12">
                <div class="card">
                    <div class="card-body">
                        <form class="form-inline">
                        <div class="form-group mx-sm-3 mb-2 ">
                          <label for="filtertype" class="sr-only">Filter Roles</label>
                            <select id='filtertype' class="form-control" style="width: 200px">
                                <option value="">All Roles</option>
                                @foreach(get_role_data() as $role)
                                <option value="{{$role->role}}">{{$role->role}}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group mx-sm-3 mb-2">
                          <label for="filter_status" class="sr-only">All Status</label>
                            <select id='filter_status' class="form-control" style="width: 200px">
                                <option value="">All Status</option>
                                <option value="1">Active</option>
                                <option value="2">InActive</option>
                            </select>
                        </div>
                                                   
                      </form>
                        <div class="table-responsive-md">
                            <table class=" table table-hover table-center mb-0" id="myTable">
                                <thead>
                                    <tr>
                                        <th>Sr#</th>
                                        <th>User Name</th>
                                        <th>Role</th>
                                        <th>Member Since</th>
                                        <th>Created By</th>
                                        <th class="text-center">Account Status</th>

                                    </tr>
                                </thead>
                                <tbody>
                                    
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>			
        </div>

    </div>			
</div>
<!-- /Page Wrapper -->	
@endsection

@push('script')

<script type="text/javascript">


    $(function () {
        var table = $('#myTable').DataTable({
             responsive: true,
            processing: true,
            serverSide: true,
             "bFilter": false,
             ajax: {
                        url: "{{ route('admin.users') }}",
                        data: function (d) {
                                d.filter_type = $('#filtertype').val()
                                d.filter_status = $('#filter_status').val()
                        }
                    },
            columns: [
                {data: 'DT_RowIndex', name: 'DT_RowIndex', orderable: false, searchable: false},
                {data: 'user_name', name: 'user_name', orderable: false, searchable: true},
                {data: 'type', name: 'type', orderable: false, searchable: true},
                {data: 'created_at', name: 'created_at', orderable: false, searchable: true},
                {data: 'created_by', name: 'created_by', orderable: false, searchable: true},
                {data: 'status', name: 'status', orderable: false},
            ]
        });
$('#filtertype').change(function(){
                    table.draw();
                });
$('#filter_status').change(function(){
                    table.draw();
                });
    });

  function changestatus(id){
      if(id !=""){
      var data = {
                        id: id
                    }
                 $.ajax({
                url: '{{ route('users.change.status') }}',
                data: data,
                success: function (data) {
                     
                }
            });
        }
  }

</script> 

@endpush