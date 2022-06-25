<?php $page = "Help Desk Settings"; ?>
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
              
             
                     <a href="{{ route('support.index') }}" class="btn btn-sm btn btn-primary float-right mr-1" >
        <span class="btn-inner--icon"><i class="fas fa-reply"></i></span>
    </a>
              
                     </div>
                
   <!-- Breadcrumb -->
                <div class="breadcrumb-bar mb-3">
                    <div class="container-fluid">
                        <div class="row align-items-center">
                            <div class="col-md-12 col-12">
                                <h2 class="breadcrumb-title">Help Desk Settings</h2>
                                <nav aria-label="breadcrumb" class="page-breadcrumb">
                                    <ol class="breadcrumb">
                                        <li class="breadcrumb-item"><a href="{{route('dashboard')}}">Dashboard</a></li>
                                        <li class="breadcrumb-item active" aria-current="page">Help Desk Settings</li>
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
                    
                    {{ Form::open(['route' => 'support.updatesettings','id' => 'new_input_form', 'name' => 'new_input_form','enctype' => 'multipart/form-data']) }}
                    <input type="hidden" name="id" value="{{!empty($data->id) ? encrypted_key($data->id,'encrypt') :0}}" />
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
                    
                     <div class="form-group">
                        <div class="row">
                            <div class="col-md-12">
                                <label class="form-control-label">Set Days</label>
                                  <small class="text-muted mb-0">{{__('(Set ticket closing when the customer does not reply)')}}</small>
                                <input type="number" class="form-control" name="close_days" value="{{ !empty($data->close_days) ? $data->close_days : ""}}" step="1" min="1" max="30" placeholder="Enter no of days" required>
                            </div>
                        </div>
                    </div>
                    
                    <div class="text-right">
                        {{ Form::button(__('Save'), ['type' => 'submit','class' => 'btn btn-sm btn-primary rounded-pill']) }}
                    
                    </div>
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

<script>

$(function () {

// Initialize form validation on the form.
$("form[name='new_input_form']").validate({
// Specify validation rules
rules: {

},
        // Specify validation error messages
        messages: {
        
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
