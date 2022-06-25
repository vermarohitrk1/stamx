<?php $page = "user"; ?>
@extends('layout.dashboardlayout')
@section('content')	
<!-- Page Content -->
<style>
.view-icons {
    margin: 20px 0;
}

.view-icons a {
    align-items: center;
    background-color: #fff;
    border: 1px solid #ddd;
    border-radius: 4px;
    color: #212529;
    display: flex;
    font-size: 17px;
    justify-content: center;
    padding: 4px 8px;
    text-align: center;
    margin-left: 10px;
    width: 37px;
    height: 37px;
}
</style>
<div class="content">
<div class="container-fluid">
   <div class="row">
      <div class="col-md-5 col-lg-4 col-xl-3 theiaStickySidebar">
         <!-- Sidebar -->
         @include('layout.partials.userSideMenu')
         <!-- /Sidebar -->
      </div>
      <div class="col-md-7 col-lg-8 col-xl-9">
         <div class="col-md-12 col-lg-12 col-xl-12">
            <a href="{{ url()->previous() }}" id="back" class="btn btn-sm btn-primary float-right ml-2">
            <span class="btn-inner--icon"><i class="fas fa-reply"></i></span>
            </a>
         </div>
         <!-- Breadcrumb -->
         <div class="breadcrumb-bar mt-3">
            <div class="container-fluid">
               <div class="row align-items-center">
                  <div class="col-md-12 col-12">
                     <h2 class="breadcrumb-title">Leads profile</h2>
                     <nav aria-label="breadcrumb" class="page-breadcrumb">
                        <ol class="breadcrumb">
                           <li class="breadcrumb-item"><a href="index">Home</a></li>
                           <li class="breadcrumb-item active" aria-current="page">Lead</li>
                        </ol>
                     </nav>
                  </div>
               </div>
            </div>
         </div>
         <!-- /Breadcrumb -->
         <div class="view-icons">
            <a href="@php echo url( 'my-lead').'/'.$name.'/'.$id.'/user'; @endphp" class="grid-view "><i class="fas fa-bars"></i></a>
            <a href="@php echo url( 'my-lead').'/'.$name.'/'.$id.'/user'; @endphp/grid-view" class="grid-view active"><i class="fas fa-th-large"></i></a>
            <a href="@php echo url( 'my-lead').'/'.$name.'/'.$id.'/user'; @endphp/map-view" class="list-view "><i class="fas fa-map"></i></a>
         </div>
         <div class="card">
            <div class="card-body">
               <div class="table-md-responsive">
                  <!-- data -->
                  <div class="row">
                           @if($data->isEmpty())
                           No data available 
                           @endif
                           @foreach($data as $key => $user)
                           <div class="col-sm-4 col-md-4 col-xl-4">
                              <div class="profile-widget">
                                 <div class="user-avatar">
                                    <a href="profile">
                                    <img class="img-fluid" alt="User Image" src="{{$user->user->getAvatarUrl()}}">
                                    </a>
                                    <a href="javascript:void(0)" class="fav-btn">
                                    <i class="far fa-bookmark"></i>
                                    </a>
                                 </div>
                                 <div class="pro-content">
                                    <h3 class="title">
                                       <a href="profile">{{ $user->user->name }}</a>
                                       <i class="fas fa-check-circle verified"></i>
                                    </h3>
                                    <p class="speciality">{{ $user->user->email }}</p>
                                    <ul class="available-info">
                                       <li>
                                          <i class="fa fa-university" aria-hidden="true"></i>
                                          @php 
                                          if($user->college != null){
                                          $institute = \App\Pathway::where('level','college')->where('user_id',$user->user->id)->where('mentor_type','student')->first();
                                          $college = \App\Institution::whereIn('id',json_decode($institute->college,true))->get();
                                          foreach($college as $key => $colleges){
                                          $k = $key+1;
                                          echo '<span class="colge">'.$k.') '.$colleges->institution.'</span></br>';
                                          }
                                          }
                                          if($user->branch != null){
                                          echo $user->branch;
                                          }
                                          if($user->catalog != null){
                                          $certy = \App\Certify::find($user->catalog);
                                          echo $certy->name;
                                          }
                                          @endphp
                                       </li>
                                       <li>
                                          <i class="fas fa-map-marker-alt"></i> {{ $user->user->address1 }}
                                       </li>
                                       <li>
                                          <i class="fas fa-city"></i>{{ $user->user->city }}
                                       </li>
                                       <li>
                                          <i class="far fa-money-bill-alt"></i>{{ $user->user->state }}
                                       </li>
                                    </ul>
                                    <div class="row row-sm">
                                       <div class="col-6">
                                          <a data-url="{{ route('lead.myleaduserprofile', encrypted_key($user->id, "encrypt")) }}" data-ajax-popup="true" data-size="md" data-title="User Profile" class="btn view-btn">View Profile</a>
                                       </div>
                                       <div class="col-6">
                                          <a  class="btn book-btn" href="{{ route('pathwaytimeline.show', encrypted_key($user->id, "encrypt")) }}">Timeline</a>
                                       </div>
                                    </div>
                                 </div>
                              </div>
                           </div>
                           @endforeach
                        </div>
                  <!-- data -->
               </div>
            </div>
         </div>
         <!-- card -->
      </div>
   </div>
</div>
</div>
<!-- /Page Content -->
@endsection
