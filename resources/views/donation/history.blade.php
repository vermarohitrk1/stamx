<?php $page = "Donation"; ?>
@extends('layout.dashboardlayout')
@push('css-cdn')
<link rel="stylesheet" type="text/css" href="{{ asset('assets/css/simcify.min.css') }}">
@endpush
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
                <a href="{{ url('donation/dashboard') }}" class="btn btn-sm btn btn-primary float-right "  data-title="{{__('Add Plan')}}">
                        <span class="btn-inner--icon"><i class="fas fa-reply"></i></span>
                    </a>
                </div>
                <!-- Breadcrumb -->
                <div class="breadcrumb-bar mt-3">
                    <div class="container-fluid">
                        <div class="row align-items-center">
                            <div class="col-md-12 col-12">
                                <h2 class="breadcrumb-title">Donation History</h2>
                                <nav aria-label="breadcrumb" class="page-breadcrumb">
                                    <ol class="breadcrumb">
                                        <li class="breadcrumb-item"><a href="index">Home</a></li>
                                        <li class="breadcrumb-item"><a href="{{url('donation/dashboard')}}">Donation</a></li>
                                        <li class="breadcrumb-item active" aria-current="page">Donation History</li>
                                    </ol>
                                </nav>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- /Breadcrumb -->

                <div class="row mt-3">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table class="table mb-0" id="example">
                                        <thead class="thead-light">
                                        <tr>
                                            <th class=" mb-0 h6 text-sm"> {{__('Full name')}}</th>
                                            <th class=" mb-0 h6 text-sm"> {{__('Email')}}</th>
                                            <th class=" mb-0 h6 text-sm"> {{__('Amount')}}</th>
                                            <th class=" mb-0 h6 text-sm"> {{__('Created')}}</th>
                                            <th class=" mb-0 h6 text-sm"> {{__('Monthly')}}</th>
                                            <th class="text-right name mb-0 h6 text-sm"> {{__('Action')}}</th>


                                        </tr>
                                        </thead>
                                        </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
@push('script')
    <script type="text/javascript">

            $(function () {    
        var table = $('#example').DataTable({
             responsive: true,
        processing: true,
        serverSide: true,
        sScrollX: false,
        sScrollY: false,
        ajax: "{{ url('/donation/history') }}",
        columns: [
            {data: 'name', name: 'name'},
            {data: 'email', name: 'email'},
            {data: 'amount', name: 'amount'},
            {data: 'donation_date', name: 'donation_date'},
            {data: 'monthlygift', name: 'monthlygift'},
            {
                data: 'action', 
                name: 'action', 
                orderable: false, 
                searchable: false
            },
        ],
        
    });
    
  });

    </script>
@endpush