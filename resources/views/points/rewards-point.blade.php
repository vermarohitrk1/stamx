<?php $page = "book"; ?>
@extends('layout.dashboardlayout')
@section('content')

<style>
.hide{
        display:none;
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
                   <a href="{{ route('profile-settings') }}" class="btn btn-sm btn-primary float-right btn-icon-only rounded-circle " >
        <span class="btn-inner--icon"><i class="fas fa-reply"></i></span>
    </a>
                     </div>

<!-- Breadcrumb -->
<div class="breadcrumb-bar mt-3">
    <div class="container-fluid">
        <div class="row align-items-center">
            <div class="col-md-12 col-12">
                <h2 class="breadcrumb-title">Reward Points : <strong>{{Auth::user()->achieved_points}} </strong></h2>
                <nav aria-label="breadcrumb" class="page-breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Home</a></li>
                        <!-- <li class="breadcrumb-item"><a href="{{ route('pathway.get') }}">Pathway</a></li> -->
                        <li class="breadcrumb-item active" aria-current="page">Reward Pionts</li>
                    </ol>
                </nav>
            </div>
        </div>
    </div>
</div>
<!-- /Breadcrumb -->

<div class="row mt-3" id="blog_view">
    <div class="col-12 text-center">


            @php
                $user = auth()->user();
                $rolescheck = \App\Role::whereRole($user->type)->first();
                if(!empty($rolescheck) && ($rolescheck->role == 'mentee' || checkPlanModule('points'))){
                    foreach($user->badges as $key => $badge){
                        $url = asset('storage/reward_points/'.$badge->image);
                @endphp
                <img src="{{$url}}" class="avatar" width="50" height="50">
                @php
                }
                @endphp
                <br><b>Total Reputation Points - </b>{{$user->achieved_points}} RP
                <br><b>Join Us - </b>{{date_diff(new \DateTime($user->created_at), new \DateTime())->format("%d DAYS")}} AGO </br>
                @php

                }
            @endphp

    </div>
</div>


<div class="row mt-3" id="blog_view">
     <div class="col-12">
        <div class="card">
            <div class="card-body">
            <div class="row mt-3" id="blog_category_view">
            <br>
                    <div class="col-12">
                    <div class="card">
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table class="display responsive nowrap table table-hover table-center" width="100%" id="yajra-datatable">
                                            <thead class="thead-light">
                                                <tr>
                                                    <!-- <th>#</th> -->
                                                    <th class=" mb-0 h6 text-sm"> {{__('Name')}}</th>
                                                    <th style="white-space:pre-wrap; word-wrap:break-word" class=" mb-0 h6 text-sm"> {{__('Points')}}</th>
                                                    <th class="text-right class="name mb-0 h6 text-sm> {{__('Date')}}</th>

                                                </tr>
                                            </thead>
                                            <tbody class="list">

                                            </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                        <div class=" col-md-12 d-flex justify-content-center paginationCss">
                        </div>
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
<link href="{{ asset('public') }}/frontend/css/custom-audio-player.css" rel="stylesheet" type="text/css" />
<script src="{{ asset('public/frontend/js/audioplayer.js') }}"></script>
<script src="{{ asset('public/frontend/js/custom-audio-player.js') }}"></script>
<script type="text/javascript">


 $(function () {
    var table = $('#yajra-datatable').DataTable({
        responsive: true,
        processing: true,
        serverSide: true,
        ajax: "{{ route('points.show') }}",
        columns: [
           // {data: 'DT_RowIndex', name: 'DT_RowIndex', orderable: false, searchable: false},
            {data: 'name', name: 'name',orderable: true,searchable: true},
            {data: 'points', name: 'points'},
            {data: 'created_at', name: 'created_at'},
        ],
    });


  });
</script>

@endpush
