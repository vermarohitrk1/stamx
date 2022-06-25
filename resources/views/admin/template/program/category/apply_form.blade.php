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
                   <a href="{{ route('blog.index') }}" class="btn btn-sm btn-primary float-right btn-icon-only rounded-circle " >
        <span class="btn-inner--icon"><i class="fas fa-reply"></i></span>
    </a>
                     </div>
   
<!-- Breadcrumb -->
<div class="breadcrumb-bar mt-3">
    <div class="container-fluid">
        <div class="row align-items-center">
            <div class="col-md-12 col-12">
                <h2 class="breadcrumb-title">Approval Form</h2>
                <nav aria-label="breadcrumb" class="page-breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Home</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('blog.index') }}">Form</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Approval form</li>
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
            @if(isset($user_status->id))

            <div class="card-body">
                <h5 class="card-title d-flex justify-content-between">
                    <span>You already apply for the program.
                    </span> 
                    
                </h5>

                <h5 class="card-title d-flex justify-content-between">
                <div class="accordion" id="accordionExample">
                             
                             <div class="card">
                                 <div class="card-header" id="headingOne">
                                 <h2 class="mb-0">
                                     <button class="btn btn-link" type="button" data-toggle="collapse" data-target="#collapseOne0" aria-expanded="false" aria-controls="collapseOne0">
                                     Check Status               </button>
                                 </h2>
                                 </div>
 
                                 <div id="collapseOne0" class="collapse" aria-labelledby="headingOne" data-parent="#accordionExample">
                                 <div class="card-body">
                                 <p>@if($user_status->status == 0) <span class="badge  badge-xs bg-primary-light">Pending</span> @elseif($user_status->status == 1) <span class="badge  badge-xs bg-success-light">Accepted</span> @else <span class="badge badge-xs bg-danger-light">Rejected</span></p> @endif   </div>
                                 </div>
                             </div>
                            </div>
                    
                </h5>
                
                
            </div>
            @else
                {{ Form::open(['route' => ['approval_form.store'],'id' => 'apply_form','enctype' => 'multipart/form-data']) }}
                <input type="hidden" name="csrf-token" value="<?=csrf_token();?>" />
                <?php $i = 0;
                foreach($data as $key => $question){ 
                if($question->type == 'text'){ $i++; ?>
                    <div class="form-group">
                            <div class="row">
                                <div class="col-md-12">
                                    <label class="form-control-label">Q:<?php echo $i; ?>  <?php echo "   "; echo $question->question ; ?></label>
                                    <textarea name="question_<?php echo $i ?>"></textarea>
                                    
                                </div>
                            </div>
                        </div>
                <?php  } 

             if($question->type == 'checkbox'){ $i++; ?>
               <div class="form-group">
                  <label class="form-control-label">Q:<?php echo $i; ?>  <?php echo "   "; echo $question->question ; ?></label>

                   <?php  $data = json_decode($question->value,'true');
                   foreach($data as $key => $value){ ?>
                       
                <div class="form-check">
                        <label class="form-check-label" for="check1">
                            <input type="checkbox" class="form-check-input" name="question_<?php echo $i; ?>[]" value="{{  $value }}" >{{  $value }}
                        </label>
                </div>
                <?php } ?>
                </div>
                <?php
                }
                
                 if($question->type == 'radio'){ $i++; ?>
                   <div class="form-group">
                  <label class="form-control-label">Q:<?php echo $i; ?>  <?php echo "   "; echo $question->question ; ?></label>

                   <?php  $data = json_decode($question->value,'true');
                   foreach($data as $key => $value){ ?>
                       
                       <div class="form-check">
                        <label class="form-check-label">
                          <input type="radio" class="form-check-input" name="question_<?php echo $i; ?>" value="{{  $value }}">{{  $value }}
                        </label>
                      </div>
                <?php } ?></div><?php }
                if($question->type == 'dropdown'){ $i++; ?>
                <div class="form-group">
                    <label class="form-control-label">Q:<?php echo $i; ?>  <?php echo "   "; echo $question->question ; ?></label>
                    <select class="form-control"  name="question_<?php echo $i; ?>">
                     <?php  $data = json_decode($question->value,'true');
                     foreach($data as $key => $value){ ?>
                         <option value="{{  $value }}">{{ $value }}</option>
                  <?php } ?>
                  </select>
     
    </div>
                  <?php }
                
                } ?>
   
<div class="text-right">
    {{ Form::button(__('Submit'), ['type' => 'submit','class' => 'btn btn-sm btn-primary rounded-pill']) }}
    <button type="button" class="btn btn-sm btn-secondary rounded-pill" data-dismiss="modal">{{__('Cancel')}}</button>
</div>
{{ Form::close() }}
@endif
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

<script>
CKEDITOR.replaceAll();


    $(document).ready(function() {
        var today = new Date();
        var dd = today. getDate() + 1;
        var mm = today. getMonth() + 1;
        var yyyy = today. getFullYear();
        if (dd < 10) {
            dd = "0" + dd;
        }
        if (mm < 10) {
            mm = "0" + mm;
        }
        var currentDate = yyyy+'-'+mm+'-'+dd;
        $('#expirydate').attr("min",currentDate);
        var check = false;
        $('#dateDiv').hide();
        $('#prepublishDiv').hide();
    });
    $(document).on("change","#expire",function() {
         var value = this.value;
        if(value=='yes'){
            check = true;
            $('#expirydate').attr("required", true);
            $('#dateDiv').show();
        }else if(value=='no'){
            check = false;
            $('#expirydate').val('');
            $('#expirydate').attr("required", false);
            $('#dateDiv').hide();
        }
    });
    $(document).on("change","#prepublish",function() {
         var value = this.value;
        if(value=='yes'){
            check = true;
            $('#prepublish_date').attr("required", true);
            $('#prepublishDiv').show();
            $('#status').val('Unpublished');
        }else if(value=='no'){
            check = false;
            $('#prepublish_date').val('');
            $('#prepublish_date').attr("required", false);
            $('#prepublishDiv').hide();
            $('#status').val('Published');
        }
    });
</script>










@endpush