<?php $page = "Send Petition Invites"; ?>
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
               
       
                     <a href="{{ route('petitioncustom.dashboard') }}" class="btn btn-sm btn btn-primary float-right mr-2 m-0">
        <span class="btn-inner--text ">{{__('Dashboard')}}</span>
    </a>
                     
                   
                     </div>
                
   <!-- Breadcrumb -->
                <div class="breadcrumb-bar mb-3">
                    <div class="container-fluid">
                        <div class="row align-items-center">
                            <div class="col-md-12 col-12">
                                <h2 class="breadcrumb-title">Send Petition Invites</h2>
                                <nav aria-label="breadcrumb" class="page-breadcrumb">
                                    <ol class="breadcrumb">
                                        <li class="breadcrumb-item"><a href="{{route('dashboard')}}">Dashboard</a></li>
                                        <li class="breadcrumb-item"><a href="{{route('petitioncustom.dashboard')}}">Petitions Dashboard</a></li>
                                        <li class="breadcrumb-item active" aria-current="page">Send Petition Invites</li>
                                    </ol>
                                </nav>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- /Breadcrumb -->
                
   
    
    
<div class="row mt-3" id="blog_category_view">
    
    {{--Main Part--}}
       
    <div class="col-lg-12 order-lg-1">
        <div id="tabs-1" class="tabs-card">
            <div class="card">
                <div class="card-header">
                    @if(in_array("manage_petitions",$permissions) || $user->type =="admin") 
                    <a href="{{ route('petitioncustom.index') }}" class="btn btn-sm float-right btn-primary btn-icon rounded-pill mr-1 ml-1">
        <span class="btn-inner--text"><i class="fas fa-reply"></i></span>
    </a>
             @endif        
                    <h3>{{$form->title}}</h3>
                <p class=" mb-0">Target:{{ $form->target }}</p>
                <p class=" mb-0">Supporters: {{ $responses }}</p><br>
                <p class="text-muted mb-0">{!! html_entity_decode($form->description, ENT_QUOTES, 'UTF-8') !!}</p>
                </div>
                <div class="card-body">
                    {{ Form::open(['route' => 'petitionAssign.store','id' => 'new_input_form', 'name' => 'new_input_form','enctype' => 'multipart/form-data']) }}
                    <input type="hidden" name="form_id" value="{{!empty($form_id) ? encrypted_key($form_id,'encrypt') :0}}" />
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
                                <label class="form-control-label">Contacts ({{\App\ContactFolder::getfoldername($form->folder_id)}})</label>
                                <select class="form-control multiple-members " name="users[]" id="users" multiple="" required="">
                                @foreach($users as $index => $row)
                                    <option value="{{ $row->id }}">{{ !empty($row->fullname) ? ucwords($row->fullname)." (".$row->email.")":$row->email }} </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>
                                <div class="form-group col-md-12">
        {{Form::label('name',__('Email Subject'))}}
        {{Form::text('subject',$subject??'',array('class'=>'form-control font-style','required'=>'required'))}}
    </div>

   
    <div class="col-12">
                                        <div class="form-group">
                                            {{Form::label('content',__('Email Message Body'))}}                                            
        
                                            {{Form::textarea('content',$email??'',array('class'=>'form-control','id'=>'summary-ckeditor','required'=>'required'))}}
                                            <br><small><b>Keywords For Contacts:</b> {fname},{lname},{fullname},{email},{phone}</small>
                                        </div>
                                    </div>
                    
                    <div class="text-right">
                        {{ Form::button(__('Invite'), ['type' => 'submit','class' => 'btn btn-md btn-primary rounded-pill']) }}
                       
                    </div>
                    @else
                    <div class="empty-section">
                        <i class="fa fa-clipboard-text"></i>
                        <h6 class="text-danger">No contact exist to send invites form, please add contacts! </h6>
                        <div class="text-right">
                        <a href="{{route('contacts')}}">
                            <button type="button" class="btn btn-sm btn-primary rounded-pill">{{__('Manage Contacts')}}</button>
                        </a>
                        <a href="{{route('petitioncustomForm.responseUsers',encrypted_key($form_id,'encrypt'))}}">
                            <button type="button" class="btn btn-sm btn-secondary rounded-pill">{{__('Responses')}}</button>
                        </a>
                    </div>
                    </div>
                    @endif

                    {{ Form::close() }}
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
<link rel="stylesheet" type="text/css" href="{{ asset('assets/css/simcify.min.css') }}">
<script src="{{ asset('assets/js/simcify.min.js') }}"></script>

<link rel="stylesheet" type="text/css" href="{{ asset('assets/css/dual-listbox.css') }}">
<script src="{{ asset('assets/js/dual-listbox.js') }}"></script>
<script>
    $(document).ready(function(){

      $(function() {
        demo = new DualListbox('.multiple-members');
        var demo2 = $('.multiple-members').bootstrapDualListbox({
  nonSelectedListLabel: 'Non-selected',
  selectedListLabel: 'Selected'
});
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
<script src="{{ asset('public/ckeditor/ckeditor.js') }}"></script>
<script type="text/javascript">
    
CKEDITOR.replace('summary-ckeditor');
    $(function () {    
    
    
  });

</script>
@endpush


