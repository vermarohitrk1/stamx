<?php $page = "Contact Edit"; ?>
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
         
                    
                     <a href="{{ url('contacts') }}" class="btn btn-sm btn-primary float-right btn-icon-only rounded-circle " >
        <span class="btn-inner--icon"><i class="fas fa-reply"></i></span>
    </a>
                     </div>
   
<!-- Breadcrumb -->
<div class="breadcrumb-bar mt-3">
    <div class="container-fluid">
        <div class="row align-items-center">
            <div class="col-md-12 col-12">
                <h2 class="breadcrumb-title">Contact Edit</h2>
                <nav aria-label="breadcrumb" class="page-breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{route('dashboard')}}">Home</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('contacts') }}">Contacts</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Contact Edit</li>
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
          <div class="card-body p-0">
              {{ Form::open(['url' => 'contacts/update','id' => 'contact_update','enctype' => 'multipart/form-data','method'=>'post']) }}
                       
                   <div class="form-group">
                    <div class="row">
                        <div class="col-md-6">
                            <label class="form-control-label">First Name</label>
                            <input type="text" class="form-control" name="fname" placeholder="First Name" value="{{!empty($contact->fname)?$contact->fname:(!empty($contact->fullname))?explode(" ",$contact->fullname)[0]:''}}" required>
                            <input type="hidden" name="csrf-token" value="<?=csrf_token();?>" />
                            <input type="hidden" name="id" value="{{$contact->id}}">
                        </div>
                        <div class="col-md-6">
                            <label class="form-control-label">Last Name</label>
                            <input type="text" class="form-control" name="lname" placeholder="Last Name" value="{{!empty($contact->lname)?$contact->lname:(!empty($contact->fullname))?(explode(" ",$contact->fullname)[1]??''):''}}" required>
                        </div>
                    </div>
                </div>
                <div class="form-group">
                    <div class="row">
                        <div class="col-md-12">
                            <label class="form-control-label">Phone Number</label>
                            <input type="text" class="form-control" name="phone" value="{{$contact->phone}}" placeholder="Phone Number" >
                        </div>
                    </div>
                </div>
                <div class="form-group">
                    <div class="row">
                        <div class="col-md-12">
                            <label class="form-control-label">Email Address</label>
                            <input type="text" class="form-control" name="email" value="{{$contact->email}}" placeholder="Email Address" required>
                        </div>
                    </div>
                </div>
                    
                    <div class="form-group">
                        <div class="row">
                            <div class="col-md-12">
                                <label class="form-control-label">Type</label>
                                <select class="form-control" name="type">
                                    <option value="Office" @if($contact->type == 'Office') selected @endif>Office</option>
                                    <option value="Home" @if($contact->type == 'Home') selected @endif>Home</option>
                                    <option value="Mobile" @if($contact->type == 'Mobile') selected @endif>Mobile</option>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="row">
                            <div class="col-md-12">
                                <label class="form-control-label">Select Folder</label>
                                <select class="form-control" name="folder">
                                    @foreach($folders as $folder)
                                        <option value="{{$folder->name}}"  @if($contact->folder == $folder->name) selected @endif>{{$folder->name}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>
              <div class="form-group">
        <div class="row">
            <div class="col-md-12">
                <label class="form-control-label">Email Subscription</label>
                <select class="select2 form-control" style="width: 100%" id="email_subscription" name="email_subscription[]" multiple="">
                    @foreach($folders as $folder)
                        <option @if(!empty($contact->email_subscription) && !empty($folder->id) ) selected @endif value="{{$folder->id}}"  >{{$folder->name}}</option>
                    @endforeach
                </select>
            </div>
        </div>
    </div>
    <div class="form-group">
        <div class="row">
            <div class="col-md-12">
                <label class="form-control-label">SMS Subscription</label>
                <select class="select2 form-control" style="width: 100%" id="sms_subscription" name="sms_subscription[]" multiple="">
                    @foreach($folders as $folder)
                        <option @if(!empty($contact->sms_subscription) ) selected @endif value="{{$folder->id}}"  >{{$folder->name}}</option>
                    @endforeach
                </select>
            </div>
        </div>
    </div>
                        <div class="form-group">
						    <div class="row">
						        <div class="col-md-12">
						               {{ Form::label('image', __('Post Image'),['class' => 'form-control-label']) }}
						            @if(!empty($contact->avatar))
									<input type="file" name="image" class="custom-input-file croppie" default="{{asset('storage')}}/contact/{{ $contact->avatar }}" crop-width="100" crop-height="100"   accept="image/*">
                                    
						            @else

										<input type="file" name="image" class="custom-input-file croppie" crop-width="100" crop-height="100"   accept="image/*"  >

						            @endif
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

<link rel="stylesheet" type="text/css" href="{{ asset('assets/css/simcify.min.css') }}">
<script src="{{ asset('assets/js/simcify.min.js') }}"></script>

<script>
    $("#email_subscription").select2();
    $("#sms_subscription").select2();
    </script>

@endpush
