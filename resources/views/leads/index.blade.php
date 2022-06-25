<?php $page = "book"; ?>
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
                <div class="col-md-12 col-lg-12 col-xl-12 ">
                <a href="{{ route('dashboard') }}" id="back" class="btn btn-sm btn-primary float-right ml-2">
                    <span class="btn-inner--icon"><i class="fas fa-reply"></i></span>
                </a>
            </div>
   
                <!-- Breadcrumb -->
                <div class="breadcrumb-bar mt-3">
                    <div class="container-fluid">
                        <div class="row align-items-center">
                            <div class="col-md-12 col-12">
                                <h2 class="breadcrumb-title">List</h2>
                                <nav aria-label="breadcrumb" class="page-breadcrumb">
                                    <ol class="breadcrumb">
                                        <li class="breadcrumb-item"><a href="index">Home</a></li>
                                        <li class="breadcrumb-item active" aria-current="page">List</li>
                                    </ol>
                                </nav>
                            </div>              
                        </div>            
                    </div>
                </div>
                <!-- /Breadcrumb -->



            <div class="col-md-12 col-lg-12 col-xl-12 no_padding">
                     <div class="card">
                            <div class="card-body">
                                <div class="table-md-responsive">
                                <!-- data -->
                                <table  style="width:100%;" class="table table-hover table-center mb-0" id="invited">
                        <thead class="thead-light">
                        <tr>
                           
                            <th class=" mb-0 h6 text-sm"> {{__('Type')}}</th>
                            <th class="text-left name mb-0 h6 text-sm"> {{__('Action')}}</th>
                        </tr>
                        </thead> 
                        <tbody>
                            <tr>
                                <td>College</td>
                                <td>
                                    <a class="btn btn-sm bg-success-light" data-title="Show College list" href="college/list">
                                      <span>Show List</span><i class="fas fa-eye"></i>
                                   </a>
                                </td>
                            </tr>
                            <tr>
                                <td>Military</td>
                                <td>
                                    <a class="btn btn-sm bg-success-light" data-title="Show College list" href="military/list">
                                    <span>Show List</span><i class="fas fa-eye"></i>
                                   </a>
                                </td>
                            </tr>
                            <tr>
                                <td>High School</td>
                                <td>
                                    <a class="btn btn-sm bg-success-light" data-title="Show College list" href="school/list">
                                    <span>Show List</span> <i class="fas fa-eye"></i>
                                   </a>
                                </td>
                            </tr>
                            <tr>
                                <td>Veterans</td>
                                <td>
                                    <a class="btn btn-sm bg-success-light" data-title="Show College list" href="veteran/list">
                                    <span>Show List</span> <i class="fas fa-eye"></i>
                                   </a>
                                </td>
                            </tr>
                            <tr>
                                <td>Justice Involved</td>
                                <td>
                                    <a class="btn btn-sm bg-success-light" data-title="Show College list" href="justice/list">
                                    <span>Show List</span> <i class="fas fa-eye"></i>
                                   </a>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                                <!-- data -->
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

