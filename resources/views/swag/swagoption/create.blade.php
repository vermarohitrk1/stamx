<?php $page = "swag"; ?>
@extends('layout.dashboardlayout')
@push('css')
<style>

</style>
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
                    <a href="{{ route('swagOption.index') }}" class="btn btn-sm btn btn-primary float-right  mr-2">
                        <span class="btn-inner--text"><i class="fas fa-reply"></i></span>
                    </a>
                </div>

                <!-- Breadcrumb -->
                <div class="breadcrumb-bar mt-3">
                    <div class="container-fluid">
                        <div class="row align-items-center">
                            <div class="col-md-12 col-12">
                                <h2 class="breadcrumb-title">Swag Option</h2>
                                <nav aria-label="breadcrumb" class="page-breadcrumb">
                                    <ol class="breadcrumb">
                                        <li class="breadcrumb-item"><a href="index">Home</a></li>
                                        <li class="breadcrumb-item active" aria-current="page">Swag Option Create</li>
                                    </ol>
                                </nav>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- /Breadcrumb -->

                <!-- Page card -->
                <div class="row mt-3" id="blog_category_view">
                    <br>
                    <div class="col-12">
                        <div class="card">
                            <div class="card-body">
                            {{ Form::open(['route' => 'swagOption.store','id' => 'create_category','enctype' => 'multipart/form-data']) }}
                                <div class="row">
                                    <div class="col-12 col-md-12">
                                        <div class="form-group">
                                            {{ Form::label('name', __('Option name'),['class' => 'form-control-label']) }}
                                            {{ Form::text('name', null, ['class' => 'form-control','required'=>'required']) }}
                                        </div>
                                    </div>
                                    <div class="col-12 col-md-12">
                                        <div class="form-group">
                                            {{ Form::label('value', __('Option Value'),['class' => 'form-control-label']) }}
                                            {{ Form::text('value', null, ['class' => 'form-control','required'=>'required']) }}
                                        </div>
                                    </div>
                                </div>

                                <div class="text-right">
                                    {{ Form::button(__('Save'), ['type' => 'submit','class' => 'btn btn-sm btn-primary rounded-pill']) }}
                                </div>
                                {{ Form::close() }}
                            </div>
                            <div class=" col-md-12 d-flex justify-content-center paginationCss">
                            </div>
                        </div>

                    </div>
                    <!-- Page card end -->
                </div>
            </div>
        </div>
    </div>

    @endsection

    @push('script')
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/css/simcify.min.css') }}">
<script src="{{ asset('assets/js/simcify.min.js') }}"></script>
<script src="{{ asset('public/ckeditor/ckeditor.js') }}"></script>

    <script type="text/javascript">
CKEDITOR.replace('summary-ckeditor');


$(function () {

    </script>
    @endpush