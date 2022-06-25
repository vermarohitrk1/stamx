<?php $page = "Users"; ?>
@section('title')
    {{$page??''}}
@endsection
@extends('layout.dashboardlayout')
@section('content')	

<style>
.showcolor{
    background-color:#009efb!important;
    border: 1px solid #009efb!important;

}
table#example {
    width: 100%!important;
}

</style>
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
                                <h2 class="breadcrumb-title">List of Users</h2>
                                <nav aria-label="breadcrumb" class="page-breadcrumb">
                                    <ol class="breadcrumb">
                                        <li class="breadcrumb-item"><a href="{{route('dashboard')}}">Dashboard</a></li>
                                        <li class="breadcrumb-item active" aria-current="page">Users</li>
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
                        <div class="form-group mx-sm-3 mb-2">
                            <button id="bulkdelete" type="button" class="btn btn-danger btn-sm">Bulk delete</button>
                       
                        </div>
                        <div class="form-group mx-sm-3 mb-2" id="deleteall" style="display:none;">    
                           <button id="deletedbulkuser" class="btn btn-danger btn-sm">Delete all</button>
                        </div>
                      </form>
              <div class="table_md-responsive" id="extable">


                  <table class="table table-hover table-center mb-0" id="example">
                     <thead class="thead-light">
                      <tr> 
                                        <th>User Name</th>
                                        <th>Role</th>
                                        <th>Member Since</th>
                                        <th>Created By</th>
                                        <th class="text-center">Board member</th>
                                        <th class="text-center">Account Status</th>
                      </tr>
                      </thead>
                     
                  </table>
</div>
<div class="exampledelete" style="display:none;"> 

                  <div >

                  <table class="table table-hover table-center mb-0" id="dletedone">
                  @if($userdata->isEmpty())
                          No data available in table
                          @else
                     <thead >
                      <tr> 
                                        <th>  <input type="checkbox" id="selectAll" /> Select all</th>
                                        <th>User Name</th>
                                        <th>Role</th>
                                        <th>Member Since</th>
                                        <th>Created By</th>
                                      
                      </tr>
                      </thead>
                      <tbody>
                        
                          @foreach($userdata as $key => $users)
                          <tr>
                              <td> <input name="useerdata" type="checkbox" id="select" value="{{  $users->id }}"> </td>
                              <td>{{  $users->name }}</td>
                              <td>{{  $users->type }}</td>
                              <td>{{  $users->created_at }}</td>
                              <td>@php   if (!empty($users->created_by)) {
                                    $user = \App\User::find($users->created_by);
                                    if( $user != null){
                                    echo '<h2 class="table-avatar">'
                                               . $user->name . '
                                            </h2>';
                                    }
                                    else{
                                        echo "--";
                                    }
                                } else {
                                    echo "--";
                                } @endphp</td>
                              
                          </tr>
                       
                          @endforeach

                         
                      </tbody>
                     
                      @endif
                  </table>
                  <?php echo $userdata->links(); ?>
                            </div>
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
<script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script type="text/javascript">


    $(function () {
        var table = $('#example').DataTable({
           responsive: true,
            processing: true,
            serverSide: true,
             "bFilter": false,
             ajax: {
                        url: "{{ route('users') }}",
                        data: function (d) {
                                d.filter_type = $('#filtertype').val()
                                d.filter_status = $('#filter_status').val()
                        }
                    },
            columns: [
                {data: 'user_name', name: 'user_name', orderable: false, searchable: true},
                {data: 'type', name: 'type', orderable: false, searchable: true},
                {data: 'created_at', name: 'created_at', orderable: false, searchable: true},
                {data: 'created_by', name: 'created_by', orderable: false, searchable: true},
                {data: 'board_member', name: 'board_member', orderable: false},
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

  function changemember(id){
      if(id !=""){
      var data = {
                        id: id
                    }
                 $.ajax({
                url: '{{ route('users.change.member') }}',
                data: data,
                success: function (data) {
                     
                      show_toastr('Success!', "Member status changed!", 'success');
                }
            });
        }
  }
  function changestatus(id){
      if(id !=""){
      var data = {
                        id: id
                    }
                 $.ajax({
                url: '{{ route('users.change.status') }}',
                data: data,
                success: function (data) {
                     
                      show_toastr('Success!', "Account status changed!", 'success');
                }
            });
        }
  }
  function changetheme(id){
      if(id !=""){
      var data = {
                        id: id,
                        theme:$("#user_theme_"+id).val()
                    }
                 $.ajax({
                url: '{{ route('users.change.theme') }}',
                data: data,
                success: function (data) {
                     
                      show_toastr('Success!', "Theme changed!", 'success');
                }
            });
        }
  }
  $('#deletedbulkuser').click(function(event){
      
       
    event.preventDefault()
      
      Swal.fire({
  title: 'This action will delete all selected accounts?',
  showDenyButton: true,
  showCancelButton: false,
  confirmButtonText: 'Confirm',
  denyButtonText: `Cancel`,
}).then((result) => {
  /* Read more about isConfirmed, isDenied below */
  if (result.isConfirmed) {
    
     

    var id_list=[];
  /* Cache the table. */
  var table = document.getElementById("dletedone"); 
  $('input[name="useerdata"]:checked').each(function() {
  
   id_list.push(this.value);
});


//console.log(id_list);
if (id_list.length === 0) {
    show_toastr('Error!', "please select the user", 'error');
    return false;

}
      var data = {
                        id: id_list
                    }
                 $.ajax({
                url: '{{ route('users.delete.users') }}',
                data: data,
                success: function (data) {
                     
                      show_toastr('Success!', "Selected user is sucessfully deleted", 'success');
               /* Create the index used in the loop. */
  var index = 1;
  
  /* Repeat as long as the index is less than the number of rows. */
  while (index < table.rows.length) {
    /* Get the input of the cell. */
    var input = table.rows[index].cells[0].children[0];
    
    /* Check whether the input exists and is checked. */
    if (input && input.checked) {
      /* Delete the row at the current index. */
      table.deleteRow(index);
    }
    else {
      /* Increment the index. */
      index++;
    }
  }
                }
            });
        

  } else if (result.isDenied) {
    Swal.fire('Accounts not deleted', '', 'info')
  }
})
      
      
  
})

$(function () {
    $('#bulkdelete').click(function(){
        $(this).text(function(i, text){
          return text === "Bulk delete" ? "Back" : "Bulk delete";
      })
      $(this).toggleClass('showcolor')
      
      $('.exampledelete').toggle('show');
      $('#deleteall').toggle('show');
$('#extable').toggle('hide');

    });
$('#selectAll').click(function (e) {
    $(this).closest('table').find('td input:checkbox').prop('checked', this.checked);
});
});
</script> 
@if( request()->get('page') )
    <script> 
        $('#bulkdelete').text(function(i, text){
          return text === "Bulk delete" ? "back" : "Bulk delete";
      })
      $('#bulkdelete').toggleClass('showcolor')
      
      $('.exampledelete').toggle('show');
      $('#deleteall').toggle('show');
$('#extable').toggle('hide');

    </script>
@endif
@endpush


