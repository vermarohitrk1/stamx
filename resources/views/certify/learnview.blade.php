<?php $page = "Learn"; ?>
@extends('layout.dashboardlayout')
@section('content')	
<style>

.modal-open .main-wrapper {
    -webkit-filter: blur(1px);
    -moz-filter: blur(1px);
    -o-filter: blur(1px);
    -ms-filter: blur(1px);
    filter: inherit;
}
.lecture-box.mt-15 {
    margin-top: 1rem;
    margin-bottom: 1rem;
}
.card-body.p-0.player-canvas {
    margin-left: 15px;
    margin-top: 1rem;
    margin-bottom: 1rem;
}
.chapters-list ul {
    padding-left: 2rem;
}
</style>

<!-- Page Content -->
<div class="content">
    <div class="container-fluid">

        <div class="row">

            <div class="col-md-12 col-lg-12 col-xl-12">
                <div class=" col-md-12 ">
                   <a href="{{ route('certify.index') }}" class="btn btn-sm btn-primary float-right btn-icon-only rounded-circle " >
        <span class="btn-inner--icon"><i class="fas fa-reply"></i></span>
    </a>
                     </div>
   
<!-- Breadcrumb -->
<div class="breadcrumb-bar mt-3">
    <div class="container-fluid">
        <div class="row align-items-center">
            <div class="col-md-12 col-12">
                <h2 class="breadcrumb-title">Learn</h2>
                <nav aria-label="breadcrumb" class="page-breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{route('dashboard')}}">Home</a></li>
                        <li class="breadcrumb-item"><a href="{{route('certify.index')}}">Courses</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Learn</li>
                    </ol>
                </nav>
            </div>              
        </div>            
    </div>
</div>
<!-- /Breadcrumb -->




  <div class="row min-750" id="learn_view"></div>
    </div>


            </div>
        </div>

    </div>

@endsection

@push('script')
    <script src="{{ asset('assets/libs/autosize/dist/autosize.min.js') }}"></script>
    <script src="{{ asset('assets/js/colorPick.js') }}"></script>
    <!--<script src="{{ asset('assets/js/custom.js') }}"></script>-->
    <!--<script src="{{ asset('js/jquery-ui/jquery-ui.min.js') }}"></script>-->

    <script>
        $.ajax({
            url: "featchDatalearnview?certify={{$id}}",
            success: function (data) {
                $('#learn_view').html(data.html);
            }
        });
    </script>
@endpush
