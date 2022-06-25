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
                   <a href="{{ route('program.list') }}" class="btn btn-sm btn-primary float-right btn-icon-only rounded-circle " >
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
            <div class="card-body">
   
                {{ Form::open(['route' => ['program.store'],'id' => 'program_form','enctype' => 'multipart/form-data']) }}
                <input type="hidden" name="csrf-token" value="<?=csrf_token();?>" />
                <div class="form-group">
                            <div class="row">
                                <div class="col-md-12">
                                    <label class="form-control-label">Title</label>
                                    <input class="form-control" type="text"  name="title" required placeholder="Please enter the title"/>
                                    
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                    <label class="form-control-label">Price</label>
                    <input type="number" name="price" class="form-control" >
     
                 </div>


          
                
                 <div class="form-group">
                    <label class="form-control-label">State</label>
                    <select class="form-control states"  name="state[]" multiple>
                  
                        
                            <option value="Alabama">Alabama</option>
                            <option value="Alaska">Alaska</option>
                            <option value="Arizona">Arizona</option>
                            <option value="Arkansas">Arkansas</option>
                            <option value="California">California</option>
                            <option value="Colorado">Colorado</option>
                            <option value="Connecticut">Connecticut</option>
                            <option value="Delaware">Delaware</option>
                            <option value="District Of Columbia">District Of Columbia</option>
                            <option value="Florida">Florida</option>
                            <option value="Georgia">Georgia</option>
                            <option value="Hawaii">Hawaii</option>
                            <option value="Idaho">Idaho</option>
                            <option value="Illinois">Illinois</option>
                            <option value="Indiana">Indiana</option>
                            <option value="Iowa">Iowa</option>
                            <option value="Kansas">Kansas</option>
                            <option value="Kentucky">Kentucky</option>
                            <option value="Louisiana">Louisiana</option>
                            <option value="Maine">Maine</option>
                            <option value="Maryland">Maryland</option>
                            <option value="Massachusetts">Massachusetts</option>
                            <option value="Michigan">Michigan</option>
                            <option value="Minnesota">Minnesota</option>
                            <option value="Mississippi">Mississippi</option>
                            <option value="Missouri">Missouri</option>
                            <option value="Montana">Montana</option>
                            <option value="Nebraska">Nebraska</option>
                            <option value="Nevada">Nevada</option>
                            <option value="New Hampshire">New Hampshire</option>
                            <option value="New Jersey">New Jersey</option>
                            <option value="New Mexico">New Mexico</option>
                            <option value="New York">New York</option>
                            <option value="North Carolina">North Carolina</option>
                            <option value="North Dakota">North Dakota</option>
                            <option value="Ohio">Ohio</option>
                            <option value="Oklahoma">Oklahoma</option>
                            <option value="Oregon">Oregon</option>
                            <option value="Pennsylvania">Pennsylvania</option>
                            <option value="Rhode Island">Rhode Island</option>
                            <option value="South Carolina">South Carolina</option>
                            <option value="South Dakota">South Dakota</option>
                            <option value="Tennessee">Tennessee</option>
                            <option value="Texas">Texas</option>
                            <option value="Utah">Utah</option>
                            <option value="Vermont">Vermont</option>
                            <option value="Virginia">Virginia</option>
                            <option value="Washington">Washington</option>
                            <option value="West Virginia">West Virginia</option>
                            <option value="Wisconsin">Wisconsin</option>
                            <option value="Wyoming">Wyoming</option>
                   </select>
     
                 </div>
                        <div class="form-group">
                    <label class="form-control-label">Category</label>
                    <select class="form-control"  name="category_id">
                     <?php // $data = json_decode($program_category,'true');
                     foreach($program_category as $key => $value){ ?>
                         <option value="{{  $value->id }}">{{ $value->name }}</option>
                  <?php } ?>
                  </select>
     
                 </div>
                <?php $i = 0;
                foreach($data as $key => $question){ 
                if($question->type == 'text'){ $i++; ?>
                    <div class="form-group">
                            <div class="row">
                                <div class="col-md-12">
                                    <label class="form-control-label">Q:<?php echo $i; ?>  <?php echo "   "; echo $question->question ; ?></label>
                                    <textarea name="question_<?php echo $question->id ?>"></textarea>
                                    
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
                            <input type="checkbox" class="form-check-input" name="question_<?php echo $question->id ?>[]" value="{{  $value }}" >{{  $value }}
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
                          <input type="radio" class="form-check-input" name="question_<?php echo $question->id ?>" value="{{  $value }}">{{  $value }}
                        </label>
                      </div>
                <?php } ?></div><?php }
                if($question->type == 'dropdown'){ $i++; ?>
                <div class="form-group">
                    <label class="form-control-label">Q:<?php echo $i; ?>  <?php echo "   "; echo $question->question ; ?></label>
                    <select class="form-control"  name="question_<?php echo $question->id ?>">
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
    <button type="button" class="btn btn-sm btn-secondary rounded-pill" data-dismiss="modal"><a class="" href="{{ URL::to('/') }}/program/listing">Cancel</a></button>
</div>
{{ Form::close() }}

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
    $(document).ready(function() {
    $('.states').select2();
    $('.companylist').select2({
        placeholder: 'Select',
        maximumSelectionLength: 1 
        });
});
</script>










@endpush