<?php $page = "partner"; ?>
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
                <h2 class="breadcrumb-title">Approval Detail</h2>
                <nav aria-label="breadcrumb" class="page-breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="index">Home</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Approval Detail</li>
                    </ol>
                </nav>
            </div>              
        </div>            
    </div>
</div>
<!-- /Breadcrumb -->



<br>

<div class="row" id="blog_view">
     <div class="col-12">
        <div class="card">
            <div class="card-body p-0">
             
<!-- html -->

<div class="accordion" id="accordionExample">
                        <?php
                     // print_r(json_decode($data->data,true));
                     $i = 0;
                         foreach(json_decode($data->data,true) as $key => $result){ 
                             if(isset($questions[$key])){


                             ?>
     
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
                                    $file = storage_path().'/app/program/'.$result;
                                    if(file_exists( $file)){
                                     ?>
                                    
                                    <div class="row align-items-center">
                                                            <div class="col-auto actions">
                                                                <a href="{{asset(Storage::url('app/program'))}}/{{$result}}" download class="action-item" role="button">
                                                                  {{$result}}  <i class="fas fa-download"></i>  
                                                                </a>
                                
                                                            </div>
                                                        </div>
                                    
                                    <?php }else{ echo $result; }  } ?>    </div>
                                </div>
                            </div>
                            <?php $i++; 
                             } } ?>
                            
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
$(document).on("click", ".delete_record_model", function(){
$("#common_delete_form").attr('action',$(this).attr('data-url'));
$('#common_delete_model').modal('show');
});
</script> 

@endpush