<?php $page = "blog"; ?>
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
                   <a href="{{ route('dashboard') }}" class="btn btn-sm btn-primary float-right btn-icon-only rounded-circle " >
        <span class="btn-inner--icon"><i class="fas fa-reply"></i></span>
    </a>
                     </div>
   
<!-- Breadcrumb -->
<div class="breadcrumb-bar mt-3">
    <div class="container-fluid">
        <div class="row align-items-center">
            <div class="col-md-12 col-12">
                <h2 class="breadcrumb-title">Program Form</h2>
                <nav aria-label="breadcrumb" class="page-breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Home</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Program form</li>
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
            <div class="card-body p-0">
   
            <div class="card-body">

                      
<div class="accordion" id="accordionExample">
<?php
// print_r(json_decode($data->data,true));
$i = 0;
 foreach(json_decode($data->data,true) as $key => $result){ ?>

    <div class="card">
        <div class="card-header" id="headingOne">
        <h2 class="mb-0">
            <button class="btn btn-link" type="button" data-toggle="collapse" data-target="#collapseOne<?php echo $i; ?>" aria-expanded="false" aria-controls="collapseOne<?php echo $i; ?>">
            <?php $num = $i+1; echo "Q".$num.") ".$questions[$key]; ?>
            </button>
        </h2>
        </div>

        <div id="collapseOne<?php echo $i; ?>" class="collapse @if($i == 0) show @endif" aria-labelledby="headingOne" data-parent="#accordionExample">
        <div class="card-body">
        <?php if(is_array($result)){ ?>
        <?php  foreach($result as $key => $res){ ?>
        <?php echo $key+1 .") ".$res."</br>"; ?>
        <?php } }
        else{
            echo $result;
        } ?>    </div>
        </div>
    </div>
    <?php $i++; } ?>
    
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

<link rel="stylesheet" type="text/css" href="{{ asset('assets/css/simcify.min.css') }}">
<script src="{{ asset('assets/js/simcify.min.js') }}"></script>

<link rel="stylesheet" type="text/css" href="{{ asset('assets/libs/dropify/css/dropify.min.css') }}">
<script src="{{ asset('assets/libs/dropify/js/dropify.min.js') }}"></script>


<script src="{{ asset('public/ckeditor/ckeditor.js') }}"></script>












@endpush