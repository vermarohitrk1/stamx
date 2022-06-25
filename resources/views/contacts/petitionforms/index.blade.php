<?php $page = "Petition"; ?>
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
               
       
        <a href="{{ route('petitioncustom.create') }}" class="btn btn-sm btn btn-primary float-right mr-2 m-0">
        <span class="btn-inner--text "><i class="fa fa-plus" ></i> {{__('New Petition')}}</span>
    </a>
                     <a href="{{ url('contacts/folder')}}" class="btn btn-sm btn btn-primary float-right mr-2 m-0">
        <span class="btn-inner--text ">{{__('Folders')}}</span>
    </a>
                     <a href="{{ route('petitioncustom.updates')}}" class="btn btn-sm btn btn-primary float-right mr-2 m-0">
        <span class="btn-inner--text ">{{__('Updates')}}</span>
    </a>
        <a href="{{ route('petitioncustom.dashboard') }}" class="btn btn-sm btn btn-primary float-right mr-2 m-0">
        <span class="btn-inner--text "><i class="fa fa-reply" ></i> </span>
    </a>
     
                   
                     </div>
                
   <!-- Breadcrumb -->
                <div class="breadcrumb-bar mb-3">
                    <div class="container-fluid">
                        <div class="row align-items-center">
                            <div class="col-md-12 col-12">
                                <h2 class="breadcrumb-title">Manage Petitions</h2>
                                <nav aria-label="breadcrumb" class="page-breadcrumb">
                                    <ol class="breadcrumb">
                                        <li class="breadcrumb-item"><a href="{{route('dashboard')}}">Dashboard</a></li>
                                        <li class="breadcrumb-item"><a href="{{route('petitioncustom.dashboard')}}">Petitions Dashboard</a></li>
                                        <li class="breadcrumb-item active" aria-current="page">Manage Petitions</li>
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
              <form >
                        <div class="row">
                        <div class="form-group col-md-3  mb-2">
                           <div class="input-group input-group-sm input-group-merge input-group-flush">
            <div class="input-group-prepend">
                <span class="input-group-text bg-transparent"><i class="fas fa-search"></i></span>
            </div>
            <input type="text" id="support_keyword" class="form-control form-control-flush" placeholder="{{__('Search by title.')}}">
        </div>
                        </div>
                        
                            @if(!empty($folders) && count($folders)>0)
                        <div class="form-group col-md-3  mb-2">
                          <label for="filter_status" class="sr-only">Folders</label>
                            <select id='filter_category' class="form-control" style="width: 200px">
                                 <option value="">All Folders</option>
                                 @foreach($folders as $key => $val)
                                <option value="{{ $val->id }}">{{__($val->name)}}</option>
                                @endforeach
                            </select>
                        </div>
                            @endif
                        </div>
                                                   
                      </form>
              <div class="table_md-responsive">
                  <table class="table table-hover table-center mb-0" id="example" style="width:100% !important">
                     <thead class="thead-light">
                  <tr>
                            <th > {{__('Title')}}</th>
                                <th > {{__('Description')}}</th>
                                <th> {{__('Folder')}}</th>
                                <th> {{__('Status')}}</th>
                                <th> {{__('Tags')}}</th>
                                <th> {{__('Supporters')}}</th>
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
                        url: "{{ route('petitioncustom.index') }}",
                        data: function (d) {
                                d.filter_type = $('#filter_type').val()
                                d.filter_status = $('#filter_status').val()
                                d.filter_category = $('#filter_category').val()
                                d.keyword = $('#support_keyword').val()
                        }
                    },
            columns: [
                 {data: 'title', name: 'title',searchable: true},
            {data: 'description', name: 'description'},
            {data: 'folder', name: 'folder'},
            {data: 'status', name: 'status'},
            {data: 'questions', name: 'questions'},
            {data: 'responses', name: 'responses'},
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
        
        function copypublicform(value){
         value="{{  url('/') }}/petition/shared/form/"+value;
         copyToClipboard( value );
        show_toastr("Copied", value, "success");
     }
     function copyToClipboard(text) {

    var textArea = document.createElement( "textarea" );
    textArea.value = text;
    document.body.appendChild( textArea );
    textArea.select();

    try {
       var successful = document.execCommand( 'copy' );
       var msg = successful ? 'successful' : 'unsuccessful';
//       console.log('Copying text command was ' + msg);
    } catch (err) {
//       console.log('Oops, unable to copy',err);
    }
    document.body.removeChild( textArea );
 }
 
 
 
 
</script> 

@endpush


