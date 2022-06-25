<?php $page = "profile-settings"; ?>
@extends('layout.dashboardlayout')
@section('content')
<style>
   .card.billing-info-card {
   box-shadow: 0 10px 30px 0 rgb(24 28 33 / 13%);
   padding: 3rem;
   }
   table#example {
   width: 100% !important;
   }
</style>
<!-- Page Content -->
<div class="content">
   <div class="container-fluid">
      <div class="row">
         <!-- Profile Sidebar -->
         <div class="col-md-5 col-lg-4 col-xl-3 theiaStickySidebar">
            <!-- Sidebar -->
            @include('layout.partials.userSideMenu')
            <!-- /Sidebar -->
         </div>
         <!-- /Profile Sidebar -->
         <div class="col-md-7 col-lg-8 col-xl-9">
            <!-- Breadcrumb -->
            <div class="breadcrumb-bar mb-3">
               <div class="container-fluid">
                  <div class="row align-items-center">
                     <div class="col-md-12 col-12">
                        <h2 class="breadcrumb-title">My Profile</h2>
                        <nav aria-label="breadcrumb" class="page-breadcrumb">
                           <ol class="breadcrumb">
                              <li class="breadcrumb-item"><a href="{{route('dashboard')}}">Dashboard</a></li>
                              <li class="breadcrumb-item active" aria-current="page">My Profile</li>
                           </ol>
                        </nav>
                     </div>
                  </div>
               </div>
            </div>
            <!-- /Breadcrumb -->
            <div class="card">
               <div class="card-header">
                  <div class="profile-header">
                     <div class="row align-items-center">
                        <div class="col-auto profile-image">
                           <a href="#">
                           <img height="100" width="100" class="rounded-circle" alt="User Image" src="{{$user->getAvatarUrl()}}">
                           </a>
                        </div>
                        <div class="col ml-md-n2 profile-user-info">
                           <h4 class=" mb-0">{{$user->name}}</h4>
                           <h6 class="text-muted">{{$user->email}}</h6>
                           <div class="pb-3"><i class="fas fa-map-marker-alt"></i> {{$user->state?$user->state.",":''}} {{$user->country}}</div>
                           <div class="about-text">{{$user->about}}</div>

                        </div>


                        <div class="col-auto profile-btn">
                           <a href="{{route('profile',['id'=>encrypted_key($user->id,"encrypt")])}}" class="btn btn-primary">Public View</a>
                        </div>
                     </div>
                  </div>
               </div>
               <div class="card-header">
                  <div class="profile-menu">
                     <ul class="nav nav-tabs nav-tabs-solid">
                        <li class="nav-item">
                           <a class="nav-link active" data-toggle="tab" href="#per_details_tab">About</a>
                        </li>
                        <li class="nav-item">
                           <a class="nav-link" data-toggle="tab" href="#password_tab">Password</a>
                        </li>
                        <li class="nav-item">
                           <a class="nav-link" data-toggle="tab" href="#update_tab">Profile</a>
                        </li>
                        <li class="nav-item">
                           <a class="nav-link tab_with_ajax" data-id="qualification_tab" data-toggle="tab" href="#qualification_tab">Qualification</a>
                        </li>
                         <li class="nav-item">
                           <a class="nav-link" data-id="notification_tab" data-toggle="tab" href="#notification_tab">Notifications</a>
                        </li>
                        @if($user->type == 'admin')
                        <li class="nav-item">
                           <a class="nav-link" data-id="education_tab" data-toggle="tab" href="#education_tab">Education</a>
                        </li>
                        @endif
                        @if($user->type == 'admin')
                        <li class="nav-item">
                           <a class="nav-link" data-id="customfield_tab" data-toggle="tab" href="#customfield_tab">Custom Field</a>
                        </li>
                        @endif
                        @if($user->type != 'admin')
                        <li class="nav-item">
                           <a class="nav-link " data-id="Billing" data-toggle="tab" href="#Billing">Billing</a>
                        </li>
                        @endif
                        @if(!empty($planStripeData))
                            <li class="nav-item">
                            <a class="nav-link " data-id="plan_tab" data-toggle="tab" href="#plan_tab">Plan Overview</a>
                            </li>
                        @endif

                        <li class="nav-item">
                           <a class="nav-link "   href="{{route('review.listing')}}">Profile Reviews</a>
                        </li>
                        @if(($user->role == 'mentee' || checkPlanModule('points')))
                            <li class="nav-item">
                                <a class="nav-link "   href="{{route('points.show')}}">Reward Points</a>
                            </li>
                        @endif



                     </ul>
                  </div>
               </div>
               <div class="card-body">
                  <div class="tab-content profile-tab-cont">
                     <!-- Personal Details Tab -->
                     <div class="tab-pane fade show active" id="per_details_tab">
                        <!-- Personal Details -->
                        <div class="row">
                           <div class="col-lg-12">
                              <div class="card">
                                 <div class="card-body">
                                    <h5 class="card-title d-flex justify-content-between">
                                       <span>Personal Details</span>
                                       <!--<a class="edit-link" data-toggle="modal" href="#edit_personal_details"><i class="fa fa-edit mr-1"></i>Edit</a>-->
                                    </h5>
                                    <div class="row">
                                       <p class="col-sm-2 text-muted mb-0 mb-sm-3">Name</p>
                                       <p class="col-sm-10">{{$user->name}}</p>
                                    </div>
                                    <div class="row">
                                       <p class="col-sm-2 text-muted mb-0 mb-sm-3">Nick Name</p>
                                       <p class="col-sm-10">{{$user->nickname}}</p>
                                    </div>
                                    <div class="row">
                                       <p class="col-sm-2 text-muted mb-0 mb-sm-3">Gender</p>
                                       <p class="col-sm-10">{{$user->gender}}</p>
                                    </div>
                                    <div class="row">
                                       <p class="col-sm-2 text-muted mb-0 mb-sm-3">Education</p>
                                       <p class="col-sm-10">@php
                                          if(!empty($user->blood_group)){
                                          $data = json_decode($user->blood_group,true);
                                          $datas = !empty($data) ?   App\Education::whereIn('id' ,$data)->get():'';
                                          if(!empty($datas)){
                                          foreach($datas as $key => $edu){
                                          $k = $key+1;
                                          echo $k.") ".$edu->education."</br>";
                                          }
                                          }
                                          }
                                          @endphp
                                       </p>
                                    </div>
                                    <div class="row">
                                       <p class="col-sm-2 text-muted mb-0 mb-sm-3">Company</p>
                                       <p class="col-sm-10" >@php
                                          $users = $user->company;
                                          if($users == null){
                                          echo "not available";
                                          }
                                          else{
                                          echo $users;
                                          }
                                          @endphp
                                       </p>
                                    </div>
                                    <div class="row">
                                       <p class="col-sm-2 text-muted mb-0 mb-sm-3">Date of Birth</p>
                                       <p class="col-sm-10">{{$user->dob}}</p>
                                    </div>
                                    <div class="row">
                                       <p class="col-sm-2 text-muted mb-0 mb-sm-3">Email ID</p>
                                       <p class="col-sm-10">{{$user->email}}</p>
                                    </div>
                                    <div class="row">
                                       <p class="col-sm-2 text-muted mb-0 mb-sm-3">Mobile</p>
                                       <p class="col-sm-10">{{mobileNumberFormat($user->mobile)}}</p>
                                    </div>
                                    <div class="row">
                                       <p class="col-sm-2 text-muted mb-0 mb-sm-3">Tax ID</p>
                                       <p class="col-sm-10">{{$user->tax_id??''}}</p>
                                    </div>
                                    <div class="row">
                                       <p class="col-sm-2 text-muted mb-0 mb-sm-3">501c3</p>
                                       <p class="col-sm-10">{{$user->fiftyzeroonec??''}}</p>
                                    </div>
                                    <div class="row">
                                       <p class="col-sm-2 text-muted mb-0">Address</p>
                                       <p class="col-sm-10 mb-0">{{$user->address1?$user->address1.",":''}}
                                          {{$user->address2?$user->address2.",":''}}
                                          {{$user->city?$user->city.",":''}}<br>
                                          {{$user->state?$user->state." -":''}} {{$user->postal_code?$user->postal_code.",":''}}
                                          {{$user->country}}.
                                       </p>
                                    </div>
                                    <?php   $customfields = array();
                                       if($user->customfield != null){

                                           $customfields = json_decode($user->customfield,true);
                                       }
                                       $new_arr = array();

                                       foreach($customfields as $key => $extrafiled){
                                           list($dummy, $newkey) = explode('_', $key);

                                           $data = \App\CustomField::where('id',strval($newkey))->first();
                                           if($data != null){
                                       ?>
                                    <div class="row">
                                       <p class="col-sm-2 text-muted mb-0 mb-sm-3"><?php  print_r( $data->label); ?></p>
                                       <p class="col-sm-10"><?php  if(is_array($extrafiled)){
                                          echo implode(",",$extrafiled);


                                          }else{
                                           echo $extrafiled;
                                            }; ?>
                                       </p>
                                    </div>
                                    <?php  } }
                                       ?>
                                 </div>
                              </div>
                           </div>
                        </div>
                        <!-- /Personal Details -->
                     </div>

                     <!-- Change Password Tab -->
                     <div id="password_tab" class="tab-pane fade">
                        <div class="card">
                           <div class="card-body">
                              <h5 class="card-title">Change Password</h5>
                              <div class="row">
                                 <div class="col-md-10 col-lg-6">
                                    <form method="post" name="page_form" action="{{route('update.profile')}}" enctype="multipart/form-data">
                                       @csrf
                                       <input type="hidden" class="form-control"  name="from" value="password_change">
                                       <div class="form-group">
                                          <label>New Password</label>
                                          <input id="password" minlength="8" type="password" required class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="new-password">
                                       </div>
                                       <div class="form-group">
                                          <label>Confirm Password</label>
                                          <input id="password-confirm" minlength="8" required type="password" class="form-control" name="password_confirmation">
                                       </div>
                                       <button class="btn btn-primary" type="submit">Change Password</button>
                                    </form>
                                 </div>
                              </div>
                           </div>
                        </div>
                     </div>
                     <!-- /Change Password Tab -->
                     <!-- Change qualification Tab -->
                     <div id="qualification_tab" class="tab-pane fade">
                     </div>
                     <!-- /Change qualification Tab -->
                     <!-- Change education Tab -->
                     <div id="education_tab" class="tab-pane fade">
                        <a class="btn btn-sm btn-primary .btn-rounded float-right" href="#" data-ajax-popup="true" data-url="{{ route('educations.create') }}" data-size="md" data-title="Add Education">
                        <span class="btn-inner--icon"><i class="fas fa-plus"></i></span>
                        </a>
                        <div class="card">
                           <div class="card-body">
                              <div class="table-md-responsive">
                                 <table class="table" id="education" style="width:100%;">
                                    <thead class="thead-light">
                                       <tr>
                                          <th class=" mb-0 h6 text-sm"> {{__('Education')}}</th>
                                          <th class="text-right name mb-0 h6 text-sm"> {{__('Action')}}</th>
                                       </tr>
                                    </thead>
                                 </table>
                              </div>
                           </div>
                        </div>
                     </div>
                     <!-- /Change education Tab -->
                     <!-- Change custom field Tab -->
                     <div id="customfield_tab" class="tab-pane fade">
                        <div class=" col-md-12 ">
                           <a class="btn btn-sm btn-primary .btn-rounded float-right" href="#"  data-ajax-popup="true" data-url="{{route('customfield.create')}}" data-size="md" data-title="{{__('Add Customfield')}}">
                           <span class="btn-inner--icon"><i class="fas fa-plus"></i></span>
                           </a>
                        </div>
                        <div class="card-body">
                           <div class="table-responsive-md">
                              @if($user->type == 'admin')
                              <table style="width:100%;" class=" table table-hover table-center mb-0" id="myTableQuestion">
                                 <thead class="thead-light ">
                                    <tr>
                                       <th>Label</th>
                                       <th>Type</th>
                                       <th>Value</th>
                                       <th class="text-right">Action</th>
                                    </tr>
                                 </thead>
                                 <tbody>
                                 </tbody>
                              </table>
                              @endif
                           </div>
                        </div>
                     </div>
                     <!-- /Change custom field Tab -->
                     <!-- Change custom field Tab -->
                     <div id="notification_tab" class="tab-pane fade">


                        <div class="card-body">
                           <div class="table-responsive-md">

                              <table style="width:100%;" class=" table table-hover table-center mb-0" id="myTableNotification">
                                 <thead class="thead-light ">
                                    <tr>
                                       <th>Folder</th>
                                       <th>Email</th>
                                       <th>SMS</th>
                                    </tr>

                                 </thead>

                                 <tbody>

                                 </tbody>
                                 <tr>
                                         <td>All System Notifications</td>
                                         <td><div  class="status-toggle d-flex justify-content-center">
                                                <input onclick="changestatus(1,-1)" type="checkbox" id="-1status_email" class="check" @if(!empty($user->email_notification)) checked @endif>
                                                <label for="-1status_email" class="checktoggle">checkbox</label>
                                            </div></td>
                                         <td><div  class="status-toggle d-flex justify-content-center">
                                                <input onclick="changestatus(2,-1)" type="checkbox" id="-1status_sms" class="check" @if(!empty($user->sms_notification)) checked @endif>
                                                <label for="-1status_sms" class="checktoggle">checkbox</label>
                                            </div></td>


                                     </tr>
                              </table>

                           </div>
                        </div>
                     </div>
                     <!-- /Change custom field Tab -->
                     <!-- Change profile Tab -->
                     <div id="update_tab" class="tab-pane fade">
                        <div class="card">
                           <div class="card-body">
                              <h5 class="card-title">Update Profile</h5>
                              <div class="row">
                                 <div class="col-md-10 col-lg-10">
                                    <form method="post" name="page_form" action="{{route('update.profile')}}" enctype="multipart/form-data">
                                       @csrf
                                       <div class="row form-row">
                                          @if ($errors->any())
                                          <div class="alert alert-danger">
                                             <ul>
                                                @foreach ($errors->all() as $error)
                                                <li>{{ $error }}</li>
                                                @endforeach
                                             </ul>
                                          </div>
                                          @endif
                                          <div class="col-12 col-md-12">
                                             <!--                                                            <div class="form-group">
                                                <div class="change-avatar">

                                                    <div class="upload-img">
                                                        <div class="change-photo-btn">
                                                            <span><i class="fa fa-upload"></i> Change Avatar</span>
                                                            <input type="file" name="avatar" class="upload">
                                                        </div>
                                                        <small class="form-text text-muted">Allowed JPG, GIF or PNG. Max size of 2MB</small>
                                                    </div>
                                                </div>
                                                </div>-->
                                             <div class="form-group">
                                                <div class="row">
                                                   <div class="col-md-12">
                                                      {{ Form::label('avatar', __('Avatar'),['class' => 'form-control-label']) }}
                                                    
                                                       @if(!empty($user->avatar) && file_exists( storage_path().'/app/'.$user->avatar ))
                                                      <input type="file" name="avatar" class="custom-input-file croppie" default="{{asset('storage')}}/app/{{ $user->avatar }}" crop-width="250" crop-height="250"   accept="image/*">
                                                      <a href="{{route('delete.profile.pic')}}" class="btn btn-xs btn-danger" title="Delete Picture">X</a>
                                                      @else
                                                      <input type="file" name="avatar" class="custom-input-file croppie" crop-width="250" crop-height="250"   accept="image/*" required="" >
                                                      @endif
                                                   </div>
                                                </div>
                                             </div>
                                          </div>
                                          <div class="col-12 col-md-6">
                                             <div class="form-group">
                                                <label>Full Name</label>
                                                <input required="" type="text" name="name" maxlength="80" class="form-control" value="{{$user->name}}">
                                             </div>
                                          </div>
                                          <div class="col-12 col-md-6">
                                             <div class="form-group">
                                                <label>Nick Name</label>
                                                <input required="" type="text" name="nickname" maxlength="49" class="form-control" value="{{$user->nickname}}">
                                             </div>
                                          </div>
                                          <div class="col-12">
                                             <div class="form-group">
                                                <label>About Me</label>
                                                <textarea required="" type="text" name="about" rows="5" maxlength="2500" class="form-control" placeholder="I'm ..." >{{$user->about}}</textarea>
                                             </div>
                                          </div>
                                          <div class="col-12 col-md-6">
                                             <div class="form-group">
                                                <label>Date of Birth</label>
                                                <input type="date" name="dob"  class="form-control "   value="{{$user->dob}}">
                                             </div>
                                          </div>
                                          <div class="col-12 col-md-6">
                                             <div class="form-group">
                                                <label>Gender</label>
                                                <select name="gender" class="form-control ">
                                                <option @if($user->gender=="Male") selected @endif value="Male" >Male</option>
                                                <option @if($user->gender=="Female") selected @endif value="Female" >Female</option>
                                                <option @if($user->gender=="Other") selected @endif value="Other" >Other</option>
                                                </select>
                                             </div>
                                          </div>
                                          <div class="col-12 col-md-6">
                                             <div class="form-group">
                                                <label>Education</label>
                                                @php $educations = App\Education::get();
                                                @endphp
                                                <select name="education_id[]" class="form-control educationselect" multiple>
                                                   <option value="" >Please select one</option>
                                                   @php $data = json_decode($user->blood_group,true);
                                                   if($data == null){
                                                   $data = array();
                                                   }
                                                   @endphp
                                                   @foreach($educations as $key => $education)
                                                   <option  @php if (in_array($education->id, $data))
                                                   {
                                                   echo "selected";
                                                   } @endphp value="{{ $education->id }}" >{{ $education->education }}</option>
                                                   @endforeach
                                                </select>
                                             </div>
                                          </div>
                                          <!--
                                             company -->
                                          <div class="col-12 col-md-6">
                                             <div class="form-group">
                                                <label class="form-control-label">Company</label>
                                                <input required="" type="text" name="company" maxlength="49" class="form-control" value="{{$user->company}}">
                                             </div>
                                          </div>
                                          <!-- company -->
                                          <div class="col-12 col-md-6">
                                             <div class="form-group">
                                                <label>Email ID</label>
                                                <input type="email" disabled="" class="form-control" value="{{$user->email}}">
                                             </div>
                                          </div>
                                          <div class="col-12 col-md-6">
                                             <div class="form-group">
                                                <label>Mobile</label>
                                                <input required="" type="tel" id="phone" name="mobile" maxlength="20" value="{{$user->mobile}}" class="form-control phone-input phoneValid">
                                             </div>
                                          </div>

                                          <div class="col-12 col-md-12">
                                             <div class="form-group">
                                                <label>Address (Search to fill address fields)</label>
                                                <input type="text" id="address" name="address1" maxlength="250" class="form-control" value="{{$user->address1}}">
                                             </div>
                                          </div>
                                          <!-- <div class="col-12 col-md-6">
                                             <div class="form-group">
                                                 <label>Address Line 2</label>
                                                 <input type="text" name="address2" maxlength="250" class="form-control" value="{{$user->address2}}">
                                             </div>
                                             </div> -->
                                          <div class="col-12 col-md-6">
                                             <div class="form-group">
                                                <label>City</label>
                                                <input type="text" readonly="" id="address_city" name="city" maxlength="40"  class="form-control" value="{{$user->city}}">
                                             </div>
                                          </div>
                                          <div class="col-12 col-md-6">
                                             <div class="form-group">
                                                <label>State</label>
                                                <input type="text" readonly="" name="state" id="address_state" maxlength="40"  class="form-control" value="{{$user->state}}">
                                             </div>
                                          </div>
                                          <div class="col-12 col-md-6">
                                             <div class="form-group">
                                                <label>Zip Code</label>
                                                <input type="number" readonly="" id="address_zip_code" class="form-control" step="1" min="0" name="postal_code" value="{{$user->postal_code}}">
                                             </div>
                                          </div>
                                          <div class="col-12 col-md-6">
                                             <div class="form-group">
                                                <label>Country</label>
                                                <input type="text" class="form-control" id="country" maxlength="40"  name="country" value="{{$user->country}}" readonly="">
                                             </div>
                                          </div>
                                          <div class="col-12 col-md-6">
                                             <div class="form-group">
                                                <label>Address Lat</label>
                                                <input type="text" class="form-control" id="address_lat" maxlength="40"  name="address_lat" value="{{$user->address_lat}}" readonly="">
                                             </div>
                                          </div>
                                          <div class="col-12 col-md-6">
                                             <div class="form-group">
                                                <label>Address Long</label>
                                                <input type="text" class="form-control" id="address_long" maxlength="40"  name="address_long" value="{{$user->address_long}}" readonly="">
                                             </div>
                                          </div>
                                          <div class="col-12 col-md-6">
                                             <div class="form-group">
                                                <label>Tax ID</label>
                                                <input type="text" class="form-control" id="tax_id" maxlength="40"  name="tax_id" value="{{$user->tax_id}}" >
                                             </div>
                                          </div>
                                          <div class="col-12 col-md-6">
                                             <div class="form-group">
                                                <label>501c3</label>
                                                <input type="text" class="form-control" id="fiftyzeroonec" maxlength="40"  name="fiftyzeroonec" value="{{$user->fiftyzeroonec}}" >
                                             </div>
                                          </div>
                                          <div class="col-12 col-md-12">
                                          <div class="form-group">
                                        <input class="form-check-input" type="checkbox" name="defaultaddress" id="defaultCheck1" @if($user->corporate_address1 == $user->address1) checked @endif>
                                        <label class="form-check-label" for="defaultCheck1">
                                            Make corporate address same as Default address
                                        </label>
                                        </div>
                                                </div>
                                               <div class="corporate_address row">
                                                <div class="col-12 col-md-12">
                                             <div class="form-group">
                                                <label>Corporate Address (Search to fill address fields)</label>
                                                <input type="text" id="corporate_address" name="corporate_address1" maxlength="250" class="form-control" value="{{$user->corporate_address1}}">
                                             </div>
                                          </div>

                                          <div class="col-12 col-md-6">
                                             <div class="form-group">
                                                <label>City</label>
                                                <input type="text" readonly="" id="corporate_address_city" name="corporate_city" maxlength="40"  class="form-control" value="{{$user->corporate_city}}">
                                             </div>
                                          </div>
                                          <div class="col-12 col-md-6">
                                             <div class="form-group">
                                                <label>State</label>
                                                <input type="text" readonly="" name="corporate_state" id="corporate_address_state" maxlength="40"  class="form-control" value="{{$user->corporate_state}}">
                                             </div>
                                          </div>
                                          <div class="col-12 col-md-6">
                                             <div class="form-group">
                                                <label>Zip Code</label>
                                                <input type="number" readonly="" id="corporate_address_zip_code" class="form-control" step="1" min="0" name="corporate_postal_code" value="{{$user->corporate_postal_code}}">
                                             </div>
                                          </div>
                                          <div class="col-12 col-md-6">
                                             <div class="form-group">
                                                <label>Country</label>
                                                <input type="text" class="form-control" id="corporate_country" maxlength="40"  name="corporate_country" value="{{$user->corporate_country}}" readonly="">
                                             </div>
                                          </div>
                                                </div>
                                          <?php $i = 0;
                                             $customfields = array();
                                             if($user->customfield != null){

                                             $customfields = json_decode($user->customfield,true);
                                             }
                                             $data = \App\CustomField::orderBy('id', 'ASC')->get();
                                             foreach($data as $key => $question){
                                             if($question->type == 'text'){ $i++;    ?>
                                          <div class="col-12 col-md-6">
                                             <div class="form-group">
                                                <label class="form-control-label">  <?php echo "   "; echo $question->label ; ?></label>
                                                <input required="" type="text" name="customfield_<?php echo $question->id ?>" maxlength="80" class="form-control" value="<?php if (array_key_exists('customfield_'.$question->id, $customfields)) { echo $customfields['customfield_'.$question->id];  } ?>">
                                             </div>
                                          </div>
                                          <?php  }
                                             if($question->type == 'checkbox'){ $i++; ?>
                                          <div class="col-12 col-md-6">
                                             <div class="form-group">
                                                <label class="form-control-label"> <?php echo "   "; echo $question->label ; ?></label>
                                                <?php  $data = json_decode($question->value,'true');
                                                   foreach($data as $key => $value){ ?>
                                                <div class="form-check">
                                                   <label class="form-check-label" for="check1">
                                                   <input type="checkbox" class="form-check-input" name="customfield_<?php echo $question->id ?>[]" value="{{  $value }}"  <?php if (array_key_exists('customfield_'.$question->id, $customfields)) {
                                                      foreach($customfields['customfield_'.$question->id] as $key => $cus){
                                                          if($cus == $value){
                                                              echo 'checked';
                                                          }
                                                      }
                                                       } ?>>{{  $value }}
                                                   </label>
                                                </div>
                                                <?php } ?>
                                             </div>
                                          </div>
                                          <?php
                                             }

                                              if($question->type == 'radio'){ $i++; ?>
                                          <div class="col-12 col-md-6">
                                             <div class="form-group">
                                                <label class="form-control-label">  <?php echo "   "; echo $question->label ; ?></label>
                                                <?php  $data = json_decode($question->value,'true');
                                                   foreach($data as $key => $value){ ?>
                                                <div class="form-check">
                                                   <label class="form-check-label">
                                                   <input <?php if (array_key_exists('customfield_'.$question->id, $customfields)) { if($customfields['customfield_'.$question->id] == $value){ echo 'checked'; }  } ?> type="radio" class="form-check-input" name="customfield_<?php echo $question->id ?>" value="{{  $value }}">{{  $value }}
                                                   </label>
                                                </div>
                                                <?php } ?>
                                             </div>
                                          </div>
                                          <?php }
                                             if($question->type == 'dropdown'){ $i++; ?>
                                          <div class="col-12 col-md-6">
                                             <div class="form-group">
                                                <label class="form-control-label"> <?php echo "   "; echo $question->label ; ?></label>
                                                <select class="form-control"  name="customfield_<?php echo $question->id ?>">
                                                   <?php  $data = json_decode($question->value,'true');
                                                      foreach($data as $key => $value){ ?>
                                                   <option value="{{  $value }}" <?php if (array_key_exists('customfield_'.$question->id, $customfields)) { if($customfields['customfield_'.$question->id] == $value){ echo 'selected'; }  } ?>>{{ $value }}</option>
                                                   <?php } ?>
                                                </select>
                                             </div>
                                          </div>
                                          <?php }
                                             } ?>
                                       </div>
                                       <div class="submit-section">
                                          <button type="submit" class="btn btn-primary submit-btn">Save Changes</button>
                                       </div>
                                    </form>
                                 </div>
                              </div>
                           </div>
                        </div>
                     </div>
                     <!-- /Change Password Tab -->
                     @if($user->type != 'admin')
                     <!-- /plan orders -->
                     <div id="Billing" class="tab-pane fade">
                        <div class="card-body">
                           <h5 class="card-title">Plan orders</h5>
                           <div class="table-md-responsive">
                              <table class="table table-hover table-center mb-0" id="example">
                                 <thead class="thead-light">
                                    <tr>
                                       <th class=" mb-0 h6 text-sm"> {{__('Plan Name')}}</th>
                                       <th class=" mb-0 h6 text-sm"> {{__('Type')}}</th>
                                       <th class=" mb-0 h6 text-sm"> {{__('Amount')}}</th>
                                       <th class=" mb-0 h6 text-sm"> {{__('Status')}}</th>
                                       <th class=" mb-0 h6 text-sm"> {{__('Purchase Date')}}</th>
                                       <th class="text-right name mb-0 h6 text-sm"> {{__('Action')}}</th>
                                    </tr>
                                 </thead>
                              </table>
                           </div>
                        </div>
                     </div>
                     <!-- /plan orders -->
                     @endif
                     <!--Plan overview-->
                     @if(!empty($planStripeData))
                     <div id="plan_tab" class="tab-pane fade">
                        <div class="">
                           <div class="card-header">
                              <h5 class=" h6 mb-0">{{__('Your Plan Overview')}}</h5>
                           </div>
                           <div class="card-body">
                              <div class="col-md-12 text-center">
                                 <div class="card billing-info-card ">
                                    <h4>CURRENT PLAN</h4>
                                    <h1>
                                       @if(!empty($OwnerPlanDetails))
                                       {{$OwnerPlanDetails->name}} - @if($user->plan_type == 'year')${{($OwnerPlanDetails->annually_price??'')}}@elseif($user->plan_type == 'month')${{($OwnerPlanDetails->monthly_price??'')}}@elseif($user->plan_type == 'week')${{($OwnerPlanDetails->weekly_price??'')}}@endif <span class="text-muted text-xs"></span>
                                    </h1>
                                    @endif
                                    <p>Unlock the full potential of MyCEO</p>
                                 </div>
                              </div>
                              <div class="col-md-12 text-center">
                                 <div class="card billing-info-card ">
                                    <h4>SUBSCRIPTION INFO</h4>
                                    <p>
                                    <div class="dataStatus">
                                       <span class="bullet">•</span><span class="text-muted ">Status: </span>
                                       <span class="label label-success @if(!empty($planStripeData->payment_status) && ($planStripeData->payment_status == 'succeeded' || $planStripeData->payment_status == 'paid')) text-success @else text-danger @endif">@if(!empty($planStripeData->payment_status) && ($planStripeData->payment_status == 'succeeded' || $planStripeData->payment_status == 'paid')) Active @else Inactive @endif</span>
                                    </div>
                                    <div class="dataStatus1">
                                       <span class="bullet">•</span><span class="text-muted ">Payment:</span>
                                       <strong>@if(!empty($planStripeData)) {{$planStripeData->payment_type}} @endif</strong>
                                    </div>
                                    <div class="dataCard">
                                       <span class="bullet">•</span><span class="text-muted ">Card:</span>
                                       <strong>**** @if(!empty($planStripeData)) {{$planStripeData->card_number}} @endif</strong>
                                    </div>
                                    <div class="dataCard1">
                                       <span class="bullet">•</span><span class="text-muted ">Plan:</span>
                                       <strong class="label label-success">{{ucfirst($user->plan_type)}}</strong>
                                    </div>
                                    </p>
                                    <p>
                                       <span class="bullet">•</span><span class="text-muted ">Start Date: </span>
                                       <strong>@if(!empty($planStripeData)) {{date("F j, Y",strtotime($planStripeData->updated_at))}} @endif</strong><br>
                                       <span class="bullet">•</span><span class="text-muted ">Expiry Date: </span>
                                       <strong>{{date("F j, Y",strtotime($user->plan_expire_date))}}</strong> <br>
                                       <span class="bullet">•</span><span class="text-muted ">Due Date: </span>
                                       <strong>{{date("F j, Y",strtotime($user->plan_expire_date))}}</strong> <br>
                                    </p>
                                    <div class="row" style="margin-left: 96px;margin-right: -96px;">
                                       <div class="col-md-4">
                                          <a href="{{ url('pricing')}}" class="btn btn-sm btn-primary ">
                                          Change Plan
                                          </a>
                                       </div>
                                       <div class="col-md-4">
                                          <a data-url="{{ route('profile.plan.cancel',$user->plan)}}" href="#" class="btn btn-sm btn-danger cancelPlanOverview">
                                          Cancel Plan
                                          </a>
                                       </div>
                                    </div>
                                    <br>
                                 </div>
                              </div>
                           </div>
                        </div>
                     </div>
                     @endif
                     <!--end Plan overview-->
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
<script type="text/javascript">

   $(function () {
       var table = $('#example').DataTable({
            responsive: true,
           processing: true,
           serverSide: true,
           ajax: "{{ url('/profile/get/orders') }}",
           columns: [
               //{data: 'DT_RowIndex', name: 'DT_RowIndex'},
               {data: 'plan name', name: 'plan name',orderable: false,searchable: false},
               {data: 'type', name: 'type'},
               {data: 'amount', name: 'amount'},

               {data: 'status', name: 'status'},
   			   {data: 'date', name: 'date'},
               {
                   data: 'action',
                   name: 'action',
                   orderable: false,
                   searchable: false
               },
           ]
       });

     });

       $(function () {
           $(".phoneValid").keyup(function(){
   var mobile = '';
   var phoneNumber = $(this).val();
   var numLength = phoneNumber.length;
   numLength = numLength - 1;
   for (var i = 0; i <= numLength; i++){
   var charData = phoneNumber.charAt(i);
   if (charData == '+' || charData == 1 || charData == 2 || charData == 3 || charData == 4 || charData == 5 || charData == 6 || charData == 7 || charData == 8 || charData == 9 || charData == 0){
   mobile = mobile + charData;
   }
   }
   $(".phoneValid").val(mobile);
   });

           $('.tab_with_ajax').click(function () {
               var tab=$(this).data("id");
               var data = {
                   tab: tab,
                     "_token": "{{ csrf_token() }}",
               }
               $.ajax({
                   url: '{{ route('users.profile.tab') }}',
                   data: data,
                   type:"POST",
                    dataType: "html",
                   success: function (data) {
                       $('#'+tab).html(data);
                   }
               });
           });
       });

</script>
<script>
   let autocomplete;
   let address1Field;
   let address2Field;
   let address11Field;
   let address22Field;

   let corporateautocomplete;
   let corporateaddress1Field;
   let corporateaddress2Field;
   let corporateaddress11Field;
   let corporateaddress22Field;

   function initAutocomplete() {
     address1Field = document.querySelector("#address");
     address2Field = document.querySelector("#address_street");

     corporateaddress1Field = document.querySelector("#corporate_address");
     corporateaddress2Field = document.querySelector("#corporate_address_street");

     // Create the autocomplete object, restricting the search predictions to
     // addresses in the US and Canada.
     autocomplete = new google.maps.places.Autocomplete(address1Field, {
       componentRestrictions: { country: ["us"] },
       fields: ["address_components", "geometry"],
       types: ["address"],
     });
     address1Field.focus();

     corporateautocomplete = new google.maps.places.Autocomplete(corporateaddress1Field, {
       componentRestrictions: { country: ["us"] },
       fields: ["address_components", "geometry"],
       types: ["address"],
     });
     corporateaddress1Field.focus();

     // When the user selects an address from the drop-down, populate the
     // address fields in the form.
     autocomplete.addListener("place_changed", fillInAddress);
     corporateautocomplete.addListener("place_changed", corporatefillInAddress);
   }

   function fillInAddress() {
     // Get the place details from the autocomplete object.

     document.querySelector("#address_lat").value =autocomplete.getPlace().geometry.location.lat();
     document.querySelector("#address_long").value =autocomplete.getPlace().geometry.location.lng();
     const place = autocomplete.getPlace();
     let address1 = "";
     let address11 = "";

     for (const component of place.address_components) {
       const componentType = component.types[0];

       switch (componentType) {
         case "street_number": {
           address1 = `${component.long_name} ${address1}`;
           break;
         }
         case "route": {
           address1 += component.short_name;
           break;
         }
         case "locality":
           document.querySelector("#address_city").value = component.long_name;
           break;
         case "administrative_area_level_1": {
           document.querySelector("#address_state").value = component.long_name;
           break;

         }
         case "postal_code": {
           document.querySelector("#address_zip_code").value = component.short_name;
           break;
       }
         case "country": {
           document.querySelector("#country").value = component.short_name;
           break;
         }
       }
     }
    // address2Field.value = address1;
   }
   function corporatefillInAddress() {
     // Get the place details from the autocomplete object.

    // document.querySelector("#corporate_address_lat").value =autocomplete.getPlace().geometry.location.lat();
    // document.querySelector("#corporate_address_long").value =autocomplete.getPlace().geometry.location.lng();
     const place = corporateautocomplete.getPlace();
     let address1 = "";
     let address11 = "";

     for (const component of place.address_components) {
       const componentType = component.types[0];

       switch (componentType) {
         case "street_number": {
           address1 = `${component.long_name} ${address1}`;
           break;
         }
         case "route": {
           address1 += component.short_name;
           break;
         }
         case "locality":
           document.querySelector("#corporate_address_city").value = component.long_name;
           break;
         case "administrative_area_level_1": {
           document.querySelector("#corporate_address_state").value = component.short_name;
           break;

         }
         case "postal_code": {
           document.querySelector("#corporate_address_zip_code").value = component.short_name;
           break;
       }
         case "country": {
           document.querySelector("#corporate_country").value = component.short_name;
           break;
         }
       }
     }
    // address2Field.value = address1;
   }

</script>
<!-- <script
   src="https://maps.googleapis.com/maps/api/js?key={{config('services.google.google_place_api')}}&callback=initAutocomplete&libraries=places"
   async
   ></script> -->
<script
   src="https://maps.googleapis.com/maps/api/js?key=AIzaSyCRm6AkA1BWf6Scex-ZqIHMptuN3A4_loQ&callback=initAutocomplete&libraries=places"
   async
   ></script>
<script type="text/javascript">
   $(function () {
       var table = $('#education').DataTable({
            responsive: true,
           processing: true,
           serverSide: true,
           "lengthChange": false,
           ajax: "{{ url('admin/education') }}",
           columns: [

               {data: 'education', name: 'education'},

                {
                   data: 'action',
                   name: 'action',
                   orderable: false,
                   searchable: false
               },
           ]
       });

     });
     $(document).ready(function() {
     $('.educationselect').select2({
           placeholder: 'Select ',
           maximumSelectionLength: 5
           });
       });
       $(document).ready(function() {

       $('.companylist').select2({
           placeholder: 'Select',
           maximumSelectionLength: 1
           });
   });
</script>
<script type="text/javascript">
   $(document).on("click", ".delete_record_model", function(){
   $("#common_delete_form").attr('action',$(this).attr('data-url'));
   $('#common_delete_model').modal('show');
   });


       $(function () {

               var table = $('#myTableQuestion').DataTable({
               processing: true,
               serverSide: true,
                responsive: true,
               ajax: "{{ route('customfields') }}",
               columns: [

                   {data: 'label', name: 'label', searchable: true},
                   {data: 'type', name: 'type'},
                   {data: 'value', name: 'value', orderable: true},
                   {
                       data: 'action',
                       name: 'action',
                       orderable: false,
                       searchable: false
                   },
               ]
           });



       });
       $(function () {

               var table = $('#myTableNotification').DataTable({
               processing: true,
               serverSide: true,
                responsive: true,
                bFilter: false,
               ajax: "{{ route('users.notifications') }}",
               columns: [

                   {data: 'foldername', name: 'foldername', searchable: false},
                   {data: 'email', name: 'email'},
                   {data: 'sms', name: 'sms', orderable: false},

               ]
           });



       });
     function changestatus(type,id){
      if(id !=""){
      var data = {
                        id: id,
                        type: type
                    };
                 $.ajax({
                url: '{{ route('notification.change.status') }}',
                data: data,
                success: function (data) {

                      show_toastr('Success!', "Notification status changed!", 'success');
                }
            });
        }
  }
       $(document).ready(function() {

  $('#defaultCheck1').change(function() {
    if($(this).is(':checked') == true){
$('.corporate_address').hide();
    }
    else{
        $('.corporate_address').show();

    }
  });
  if ($('#defaultCheck1').is(':checked')) {
    $('.corporate_address').hide();
  }


});

</script>
@endpush
