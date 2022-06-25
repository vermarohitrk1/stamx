@extends('layout.mainlayout_admin')
@section('content')	
<!-- Page Wrapper -->
<div class="page-wrapper">
    <div class="content container-fluid">

        <!-- Page Header -->
        <div class="page-header">
            <div class="row">
                <div class="col">
                    <h3 class="page-title">My Profile</h3>
                    <ul class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{route('dashboard')}}">Dashboard</a></li>
                        <li class="breadcrumb-item active">My Profile</li>
                    </ul>
                </div>
            </div>
        </div>
        <!-- /Page Header -->

        <div class="row">
            <div class="col-md-12">
                <div class="profile-header">
                    <div class="row align-items-center">
                        <div class="col-auto profile-image">
                            <a href="#">
                                <img class="rounded-circle" alt="User Image" src="{{$user->getAvatarUrl()}}">
                            </a>
                        </div>
                        <div class="col ml-md-n2 profile-user-info">
                            <h4 class="user-name mb-0">{{$user->name}}</h4>
                            <h6 class="text-muted">{{$user->email}}</h6>
                            <div class="pb-3"><i class="fas fa-map-marker-alt"></i> {{$user->state?$user->state.",":''}} {{$user->country}}</div>
                            <div class="about-text">{{$user->about}}</div>
                        </div>
                        <div class="col-auto profile-btn">
                            <a href="{{route('profile',['id'=>encrypted_key($user->id,"encrypt")])}}" class="btn btn-primary">Public View</a>
                        </div>
                    </div>
                </div>
                <div class="profile-menu">
                    <ul class="nav nav-tabs nav-tabs-solid">
                        <li class="nav-item">
                            <a class="nav-link active" data-toggle="tab" href="#per_details_tab">About</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" data-toggle="tab" href="#password_tab">Password</a>
                        </li>
                    </ul>
                </div>	
                <div class="tab-content profile-tab-cont">

                    <!-- Personal Details Tab -->
                    <div class="tab-pane fade show active" id="per_details_tab">

                        <!-- Personal Details -->
                        <div class="row">
                            <div class="col-lg-12">
                                <div class="card">
                                    <div class="card-body">
                                        <h5 class="card-title d-flex justify-content-between">
                                            <span>Update Personal Details</span> 
                                            <a class="edit-link" data-toggle="modal" href="#edit_personal_details"><i class="fa fa-edit mr-1"></i>Edit</a>
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
                                            <p class="col-sm-2 text-muted mb-0 mb-sm-3">Blood Group</p>
                                            <p class="col-sm-10">{{$user->blood_group}}</p>
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
                                            <p class="col-sm-10">{{$user->mobile}}</p>
                                        </div>
                                        <div class="row">
                                            <p class="col-sm-2 text-muted mb-0">Address</p>
                                            <p class="col-sm-10 mb-0">{{$user->address1?$user->address1.",":''}}
                                                {{$user->address2?$user->address2.",":''}}
                                                {{$user->city?$user->city.",":''}}<br>
                                                {{$user->state?$user->state." -":''}} {{$user->postal_code?$user->postal_code.",":''}}
                                                {{$user->country}}.</p>
                                        </div>
                                    </div>
                                </div>


                            </div>


                        </div>
                        <!-- /Personal Details -->

                    </div>
                    <!-- /Personal Details Tab -->

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

                </div>
            </div>
        </div>

    </div>			
</div>
<!-- /Page Wrapper -->
<!-- Edit Details Modal -->
<div class="modal fade" id="edit_personal_details" aria-hidden="true" role="dialog">
    <div class="modal-dialog modal-dialog-centered" role="document" >
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Personal Details</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
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
                                    <div class="form-group">
                                        <div class="change-avatar">
                                            
                                            <div class="upload-img">
                                                <div class="change-photo-btn">
                                                    <span><i class="fa fa-upload"></i> Change Avatar</span>
                                                    <input type="file" name="avatar" class="upload">
                                                </div>
                                                <small class="form-text text-muted">Allowed JPG, GIF or PNG. Max size of 2MB</small>
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
                                        <div class="cal-icon">
                                            <input type="text" name="dob"  class="form-control "   value="{{$user->dob}}">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-12 col-md-6">
                                    <div class="form-group">
                                        <label>Gender</label>
                                        <select name="gender" class="form-control select">
                                            <option @if($user->gender=="Male") selected @endif value="Male" >Male</option>
                                            <option @if($user->gender=="Female") selected @endif value="Female" >Female</option>
                                            <option @if($user->gender=="Other") selected @endif value="Other" >Other</option>

                                        </select>
                                    </div>
                                </div>
                                <div class="col-12 col-md-6">
                                    <div class="form-group">
                                        <label>Blood Group</label>
                                        <select name="blood_group" class="form-control select">
                                            <option value="" >Please select one</option>
                                            <option @if($user->blood_group=="A-") selected @endif value="A-" >A-</option>
                                            <option @if($user->blood_group=="A+") selected @endif value="A+" >A+</option>
                                            <option @if($user->blood_group=="B-") selected @endif value="B-" >B-</option>
                                            <option @if($user->blood_group=="B+") selected @endif value="B+" >B+</option>
                                            <option @if($user->blood_group=="AB-") selected @endif value="AB-" >AB-</option>
                                            <option @if($user->blood_group=="AB+") selected @endif value="AB+" >AB+</option>
                                            <option @if($user->blood_group=="O-") selected @endif value="O-" >O-</option>
                                            <option @if($user->blood_group=="O+") selected @endif value="O+" >O+</option>

                                        </select>
                                    </div>
                                </div>
                                <div class="col-12 col-md-6">
                                    <div class="form-group">
                                        <label>Email ID</label>
                                        <input type="email" disabled="" class="form-control" value="{{$user->email}}">
                                    </div>
                                </div>
                                <div class="col-12 col-md-6">
                                    <div class="form-group">
                                        <label>Mobile</label>
                                        <input required="" type="tel" name="mobile" maxlength="20" value="{{$user->mobile}}" class="form-control">
                                    </div>
                                </div>
                                <div class="col-12 col-md-6">
                                    <div class="form-group">
                                        <label>Address Line 1</label>
                                        <input type="text" name="address1" maxlength="250" class="form-control" value="{{$user->address1}}">
                                    </div>
                                </div>
                                <div class="col-12 col-md-6">
                                    <div class="form-group">
                                        <label>Address Line 2</label>
                                        <input type="text" name="address2" maxlength="250" class="form-control" value="{{$user->address2}}">
                                    </div>
                                </div>
                                <div class="col-12 col-md-6">
                                    <div class="form-group">
                                        <label>City</label>
                                        <input type="text" name="city" maxlength="40"  class="form-control" value="{{$user->city}}">
                                    </div>
                                </div>
                                <div class="col-12 col-md-6">
                                    <div class="form-group">
                                        <label>State</label>
                                        <input type="text" name="state" maxlength="40"  class="form-control" value="{{$user->state}}">
                                    </div>
                                </div>
                                <div class="col-12 col-md-6">
                                    <div class="form-group">
                                        <label>Zip Code</label>
                                        <input type="number" class="form-control" step="1" min="0" name="postal_code" value="{{$user->postal_code}}">
                                    </div>
                                </div>
                                <div class="col-12 col-md-6">
                                    <div class="form-group">
                                        <label>Country</label>
                                        <input type="text" class="form-control" maxlength="40"  name="country" value="{{$user->country}}">
                                    </div>
                                </div>
                            </div>
                            <div class="submit-section">
                                <button type="submit" class="btn btn-primary submit-btn">Save Changes</button>
                            </div>
                        </form>
            </div>
        </div>
    </div>
</div>
<!-- /Edit Details Modal -->	
@endsection