@extends('layout.mainlayout_admin')
@section('content')		

<!-- Page Wrapper -->
<div class="page-wrapper">
    <div class="content container-fluid">

        <!-- Page Header -->
        <div class="page-header">
            <div class="row">
                <div class="col-sm-12">
                    <h3 class="page-title">User Approval Status</h3>
                    <ul class="breadcrumb">
                        <li class="breadcrumb-item"><a href="index">Dashboard</a></li>
                        <li class="breadcrumb-item active">User Approval Status</li>
                    </ul>
                </div>
            </div>
        </div>
        <!-- /Page Header -->

        <div class="row">
            <div class="col-sm-12">
            <div class="candidate_profile">
             <div class="personal_info">
             <div class="row>">
               <h3><span>Email : </span> {{ $data->user->email }}</h3>
               <h5><span>Status : </span> @if($data->status == 0) Pending @elseif($data->status == 1)Approved @else Rejected @endif</h5>
             </div>
               
                      
             </div>
            </div>
                <div class="card">
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
<!-- /Page Wrapper -->

@endsection

@push('script')

<script type="text/javascript">
$(document).on("click", ".delete_record_model", function(){
$("#common_delete_form").attr('action',$(this).attr('data-url'));
$('#common_delete_model').modal('show');
});




</script> 

@endpush