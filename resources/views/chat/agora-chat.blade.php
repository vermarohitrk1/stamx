<?php $page = "Video Chat"; ?>
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


                <!-- Breadcrumb -->
                <div class="breadcrumb-bar mt-3">
                    <div class="container-fluid">
                        <div class="row align-items-center">
                            <div class="col-md-12 col-12">
                                <h2 class="breadcrumb-title">Video Chat</h2>
                                <nav aria-label="breadcrumb" class="page-breadcrumb">
                                    <ol class="breadcrumb">
                                        <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Home</a></li>
                                        <li class="breadcrumb-item active" aria-current="page">Video Chat</li>
                                    </ol>
                                </nav>
                            </div>              
                        </div>            
                    </div>
                </div>
                <!-- /Breadcrumb -->





                <div class="row mt-3" id="blog_view">
                    <div class="col-12">
                        <div class="card">
                            <div id="videochatstatus">
<agora-chat :cuser="{{ $users }}" authuserid="{{ auth()->id() }}" authuser="{{ auth()->user()->name }}" baseUrl="{{url('/')}}" authuseravatar="{{ auth()->user()->avatar }}" 
        agora_id="{{ env('AGORA_APP_ID') }}" />
                            </div>
                        </div>
                    </div>

                </div>
            </div>

        </div>

    </div>		
    <!-- /Page Content -->
    @endsection

