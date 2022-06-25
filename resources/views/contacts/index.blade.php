<?php $page = "Contacts"; ?>
@section('title')
    {{$page}}
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
ul.pagination {
   justify-content: center;
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
                <div class=" col-md-12 ">
           <a href="#" class="btn btn-sm btn btn-primary float-right " data-url="{{ route('contact.create') }}" data-ajax-popup="true" data-size="lg" data-title="{{__('Add Contact')}}">
        <span class="btn-inner--icon"><i class="fas fa-plus"></i></span>
    </a>
                <a href="{{ url('contacts/folder') }}" class="btn btn-sm btn btn-primary float-right mr-2 m-0">
        <span class="btn-inner--text ">{{__('Manage Folder')}}</span>
    </a>
                <a href="{{ url('contacts/unsbuscribers') }}" class="btn btn-sm btn btn-primary float-right mr-2 m-0">
        <span class="btn-inner--text ">{{__('UnSubscribers')}}</span>
    </a>
                     </div>
   
<!-- Breadcrumb -->
<div class="breadcrumb-bar mt-3">
    <div class="container-fluid">
        <div class="row align-items-center">
            <div class="col-md-12 col-12">
                <h2 class="breadcrumb-title">Contacts</h2>
                <nav aria-label="breadcrumb" class="page-breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{route('dashboard')}}">Home</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Contacts</li>
                    </ol>
                </nav>
            </div>              
        </div>            
    </div>
</div>
<!-- /Breadcrumb -->


<div class="row mt-3 blockWithFilter">
                    <div class="col-md-12 col-lg-4 dash-board-list blue">
                        <div class="dash-widget">
                            <div class="circle-bar">
                                <div class="icon-col">
                                    <i class="fas fa-address-book"></i>
                                </div>
                            </div>
                            <div class="dash-widget-info">
                                <h3 data-id="contacts">{{$contacts}}</h3>
                                <h6>Contacts</h6>															
                            </div>
                        </div>
                    </div>

                    <div class="col-md-12 col-lg-4 dash-board-list yellow">
                        <div class="dash-widget">
                            <div class="circle-bar">
                                <div class="icon-col">
                                    <i class="fas fa-users"></i>
                                </div>
                            </div>
                            <div class="dash-widget-info">
                                <h3 data-id="subscribers">{{$subscribers}}</h3>
                                <h6>{{__('Subscribers')}}</h6>															
                            </div>
                        </div>
                    </div>

                    <div class="col-md-12 col-lg-4 dash-board-list pink">
                        <div class="dash-widget">
                            <div class="circle-bar">
                                <div class="icon-col">
                                    <i class="fas fa-users"></i>
                                </div>
                            </div>
                            <div class="dash-widget-info">
                                <h3 data-id="unsubscribers">{{$unsubscribers}}</h3>
                                <h6>{{__('UnSubscribers')}}</h6>															
                            </div>
                        </div>
                    </div>
                </div>

<br>

<div class="row " id="blog_view">
     <div class="col-12 ">
     <div class="row ">  
     <div class="form-group mx-sm-3 mb-2">
                            <button id="bulkdelete" type="button" class="btn btn-danger btn-sm">Bulk delete</button>
                       
                        </div>
                        <div class="form-group mx-sm-3 mb-2" id="deleteall" style="display:none;">    
                           <button id="deletedbulkuser" class="btn btn-danger btn-sm">Delete all</button>
                        </div>
</div>
        <div class="card">
            <div class="card-body ">
                <div class="table-md-responsive" id="extable">                    
                    <table class="table  table-hover table-center mb-0" id="yajra-datatable">
                        <thead class="thead-light ">
                              <tr>
                                <th > {{__('Name')}}</th>
                                <th > {{__('Email')}}</th>
                                <th > {{__('Phone')}}</th>
                                <th > {{__('Folder')}}</th>
                                <th > {{__('Type')}}</th>
                                <th class="text-right name mb-0 h6 text-sm"> {{__('Action')}}</th>
                            </tr>
                        </thead>
                         
                    </table>
                </div>
            </div>
        </div>
        <div class="exampledelete" style="display:none;"> 

                  <div >

                  <table class="table table-hover table-center mb-0" id="dletedone">
                     <thead >
                      <tr> 
                                        <th>  <input type="checkbox" id="selectAll" /> Select all</th>
                                        <th>Name</th>
                                        <th>Email</th>
                                        <th>Phone</th>
                                        <th>Folder</th>
                                        <th>Type</th>
                                     
                                      
                      </tr>
                      </thead>
                      <tbody>
                          @foreach($userdata as $key => $users)
                          <tr>
                              <td> <input name="useerdata" type="checkbox" id="select" value="{{  $users->id }}"> </td>
                              <td><h2 class="table-avatar">
                                                <a href="#" class="avatar avatar-sm mr-2"><img class="avatar-img rounded-circle" src="{{ $users->getAvatarUrl() }}" alt="Image"></a>
                                                <a href="#">{{ $users->fname }} {{ $users->lname }}</a>
                                            </h2></td>
                              <td>{{  $users->email }}</td>
                              <td>{{  $users->phone }}</td>
                              <td>{{ is_numeric($users->folder)?\App\ContactFolder::getfoldername($users->folder):$users->folder }}</td>
                              <td>{{  $users->type }}</td>

                          </tr>
                       
                          @endforeach
                         
                      </tbody>
                     
                  </table>
                  <?php echo $userdata->links(); ?>
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
        ajax: "{{ route('contacts') }}",
        columns: [
           
            {data: 'name', name: 'name',orderable: true},
            {data: 'email', name: 'email',orderable: true},
            {data: 'phone', name: 'phone',orderable: false},
            {data: 'folder', name: 'folder',orderable: true},
            {data: 'type', name: 'type',orderable: true},
            {
                data: 'action', 
                name: 'action', 
                orderable: false, 
                searchable: false
            },
        ]
    });
    
  });

</script>

<script type="text/javascript">
//     $(document).on("click", "#connection_details", function () {
//        $('#connection_details_model').modal('show');
//    });
    $(document).ready(function () {
       $(document).on("click", "#email_button", function () {             
             var email_body = CKEDITOR.instances['email_body'].getData();
//             var email_body =$("#email_body").val();
             var email_subject =$("#email_subject").val();
             var connection_id =$("#connection_id").val();
          
              if (email_subject != '' && email_body != '') {
                  
                  var data = {
                        email_subject: email_subject,
                        email_body: email_body,
                        id: connection_id,
                    }
                    processing_actions('yes');
                 $.ajax({
                url: '{{ route('connection_view_send_contact_email') }}',
                data: data,
                success: function (data) {
                    processing_actions();
                     if(data.success==true){
                           show_toastr("Success!", data.html, "success");
                    
                     }else{
                         show_toastr("Oops!", data.html, "error");
                        
                    }
                }
            });
                
            } else {
                alert('{{ __("Please fill required inputs.") }}');
            }
        
    });
         $(document).on("click", "#sms_button", function () {             
             var sms_body =$("#sms_body").val();
             var connection_id =$("#connection_id").val();
              if (sms_body != '') {
                  
                  var data = {
                        sms_body: sms_body,
                        id: connection_id,
                    }
                    processing_actions('yes');
                 $.ajax({
                url: '{{ route('connection_view_send_sms') }}',
                data: data,
                success: function (data) {
                     processing_actions();
                    if(data.success==true){
                           show_toastr("Success!", data.html, "success");
                    
                     }else{
                         show_toastr("Oops!", data.html, "error");
                        
                    }
                }
            });
                
            } else {
                alert('{{ __("Please type your message first") }}');
            }
        
    });
         
         
        
        
    });
    
    function profile_actions(action=""){
        if(action=="email"){
            $("#email_div").show();
            $("#sms_div").hide();
            $("#processing_div").hide();
        }else if(action=="sms"){
            $("#email_div").hide();
            $("#processing_div").hide();
            $("#sms_div").show();
        }else{
            $("#email_div").hide();
            $("#sms_div").hide();
            $("#processing_div").hide();
        }
    }
    function processing_actions(action=""){
        if(action=="yes"){
             $("#email_div").hide();
            $("#sms_div").hide();
            $("#processing_div").show();
        }else{
           profile_actions();
        }
    }
    function prepare_connection_call(){
       profile_actions();
       var telphone =$("#telNumber").val();
       if(telphone==""){
           toastr.error("Phone not exist", "Oops!", {
                            closeButton: true
                        });
       }else{
           toastr.clear();
           toastr.info("Connecting", "Wait!", {
                            closeButton: true
                        });
                        
                       $.ajax({
        url: "/twilioToken",
        type: "GET",
        success: function (data) {
            console.log('test');
            Twilio.Device.setup(data, {
                debug: true,
            });
        },
    });
       call();
       $('#dialer_callbutton').trigger('click');
        }
       
    }
    $('#deletedbulkuser').click(function(event){
    event.preventDefault()

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
                url: '{{ route('users.delete.contacts') }}',
                data: data,
                success: function (data) {
                     
                      show_toastr('Success!', "Selected contact is sucessfully deleted", 'success');
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
</script>

@endpush
