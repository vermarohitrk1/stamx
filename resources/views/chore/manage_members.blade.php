<?php $page = "Manage Chore Members"; ?>
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
                  
       <a href="{{ route('chore.dashboard') }}" class="btn btn-sm btn-primary float-right btn-icon-only rounded-circle ml-1" >
        <span class="btn-inner--icon"><i class="fas fa-reply"></i></span>
    </a>
                   
                     </div>
                
   <!-- Breadcrumb -->
                <div class="breadcrumb-bar mb-3">
                    <div class="container-fluid">
                        <div class="row align-items-center">
                            <div class="col-md-12 col-12">
                                <h2 class="breadcrumb-title">Manage Chore Members</h2>
                                <nav aria-label="breadcrumb" class="page-breadcrumb">
                                    <ol class="breadcrumb">
                                        <li class="breadcrumb-item"><a href="{{route('dashboard')}}">Dashboard</a></li>
                                        <li class="breadcrumb-item active" aria-current="page">Manage Chore Members</li>
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
               
                <div class="card-body">
                    {{ Form::open(['route' => 'chore.members.store','id' => 'new_input_form', 'name' => 'new_input_form','enctype' => 'multipart/form-data']) }}
                 <input type="hidden" name="csrf-token" value="<?= csrf_token(); ?>" />
                    @if ($errors->any())
    <div class="alert alert-danger">
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif
                    
                                @if(!empty($users) && count($users) > 0)
                    <div class="form-group">
                        <div class="row">
                            <div class="col-md-12">                                    
                                <label class="form-control-label">Users</label>
                                <select class="form-control multiple-members " name="users[]" id="users" multiple="" required="">
                                @foreach($users as $index => $row)
                                    <option @if(in_array($row->id,$members)) selected @endif value="{{ encrypted_key($row->id,'encrypt') }}">{{ ucwords($row->name)." (".ucwords($row->type).")" }} </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>
                    
                    <div class="text-right">
                        {{ Form::button(__('Save'), ['type' => 'submit','class' => 'btn btn-sm btn-primary rounded-pill']) }}
                       
                    </div>
                    @else
                    <div class="empty-section">
                        <i class="fa fa-clipboard-text"></i>
                        <h6 class="text-danger">No member exist to add in chores, please add members! </h6>
                        <div class="text-right">
                        <a href="{{route('users')}}">
                            <button type="button" class="btn btn-sm btn-primary rounded-pill">{{__('Add Member')}}</button>
                        </a>
                    </div>
                    </div>
                    @endif

                    {{ Form::close() }}
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
<link rel="stylesheet" type="text/css" href="{{ asset('assets/css/simcify.min.css') }}">
<script src="{{ asset('assets/js/simcify.min.js') }}"></script>

<link rel="stylesheet" type="text/css" href="{{ asset('assets/css/dual-listbox.css') }}">
<script src="{{ asset('assets/js/dual-listbox.js') }}"></script>
<script>
    $(document).ready(function(){
//      $.ajax({
//       url:"{{route('assessmentForm.sidebar',!empty($form_id) ? encrypted_key($form_id,'encrypt') :0)}}?sidebar=form_assign",
//       success:function(data)
//       {
//        $('#page_sidebar_tabs').html(data);
//       }
//      });
      $(function() {
        demo = new DualListbox('.multiple-members');
    });
    });
</script>
<script>

$(function () {
    // Initialize form validation on the form.
    $("form[name='new_input_form']").validate({
        // Specify validation rules
        rules: {
            'users[]': {
                required: true
            }
        },
        // Specify validation error messages
        messages: {
            'users[]': {
                required: "*Required"
            }
        },
        // Make sure the form is submitted to the destination defined
        // in the "action" attribute of the form when valid
        submitHandler: function (form) {
            form.submit();
        }
    });
});
</script>

@endpush

