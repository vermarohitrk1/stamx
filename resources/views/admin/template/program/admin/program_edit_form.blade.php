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
            <div class=" col-md-12 ">
                     <a href="{{ route('adminProgramlisting') }}" id="back" class="btn btn-sm btn-primary float-right ml-2">
        <span class="btn-inner--icon"><i class="fas fa-reply"></i></span>
    </a>
 
        
           
             
                     
                
                 
   
<!-- Breadcrumb -->
<div class="breadcrumb-bar mt-3">
    <div class="container-fluid">
        <div class="row align-items-center">
            <div class="col-md-12 col-12">
                <h2 class="breadcrumb-title">Edit Program</h2>
                <nav aria-label="breadcrumb" class="page-breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="index">Home</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Edit Program</li>
                    </ol>
                </nav>
            </div>              
        </div>            
    </div>
</div>
<!-- /Breadcrumb -->
<div class="candidate_profile">
             <div class="personal_info">
             <div class="row>">
              
               <!-- <h5><span>Status : </span> @if($data->status == 0) Pending @elseif($data->status == 1)Approved @else Rejected @endif</h5> -->
             </div>
               
                      
             </div>
            </div>

    {{ Form::open(['route' => ['adminProgramlisting.store'],'id' => 'program_form','enctype' => 'multipart/form-data']) }}
                <input type="hidden" name="csrf-token" value="<?=csrf_token();?>" />
                <input type="hidden" name="id" value="{{ $data->id }}" />
                <div class="col-md-12">
                                    <label class="form-control-label">Title</label>
                                    <input type="text" class="form-control" name="title" value="{{ $data->title }}">
                                    
                                </div></br>
                                <div class="form-group">
  
  <label class="form-control-label">Category</label>
  <select class="form-control"  name="category_id">
   <?php echo $selectedopt = App\ProgramCategory::find($data->category_id)->id;
   foreach($program_category as $key => $value){ ?>
       <option value="{{  $value->id }}" <?php if(  $selectedopt == $value->id ){ echo 'selected'; } ?> >{{ $value->name }}</option>
<?php } ?>
</select></div>
                <?php $i = 0;
               $queans = json_decode($data->data ,true);
   //print_r($queans); die;
                foreach($queans as $key => $question){ 
                   // print_r($question); 
                //  echo $key;
                if(isset($questions[$key])){
                if($questions[$key]['type']== 'text'){ $i++; ?>
                    <div class="form-group">
                            <div class="row">
                                <div class="col-md-12">
                                    <label class="form-control-label">Q:<?php echo $i; ?>  <?php echo "   "; echo $questions[$key]['question'] ?></label>
                                    <textarea name="question_<?php echo $i ?>"><?php print_r($question ); ?></textarea>
                                    
                                </div>
                            </div>
                        </div>
                <?php  } 

             else if($questions[$key]['type'] == 'checkbox'){ $i++; ?>
               <div class="form-group">
                  <label class="form-control-label">Q:<?php echo $i; ?>  <?php echo "   "; print_r( $questions[$key]['question'] ) ; ?></label>

                   <?php  $data = json_decode($questions[$key]['value'],'true');
                   foreach($data as $key => $value){ ?>
                       
                <div class="form-check">
                        <label class="form-check-label" for="check1">
                            <input type="checkbox" class="form-check-input" name="question_<?php echo $i; ?>[]" value="{{  $value }}"  @if(is_array($question))@foreach($question as $val) @if($val == $value ) checked @endif @endforeach @endif>{{  $value }}
                        </label>
                </div>
                <?php } ?>
                </div>
                <?php
                }
        
                 
                 else if($questions[$key]['type'] == 'radio'){ $i++; ?>
                   <div class="form-group">
                     <label class="form-control-label">Q:<?php echo $i; ?>  <?php echo "   "; echo $questions[$key]['question'] ; ?></label>

                   <?php  $data = json_decode($questions[$key]['value'] ,'true');
                   foreach($data as $key => $value){ ?>
                       
                       <div class="form-check">
                        <label class="form-check-label">
                          <input @if($question == $value ) checked @endif type="radio" class="form-check-input" name="question_<?php echo $i; ?>" value="{{  $value }}">{{  $value }}
                        </label>
                      </div>
                <?php } ?></div><?php }
               else if($questions[$key]['type'] == 'dropdown'){ $i++; ?>
                <div class="form-group">
                    <label class="form-control-label">Q:<?php echo $i; ?>  <?php echo "   "; echo $questions[$key]['question']; ?></label>
                    <select class="form-control"  name="question_<?php echo $i; ?>">
                     <?php  $data = json_decode($questions[$key]['value'],'true');
                     foreach($data as $key => $value){ ?>
                         <option value="{{  $value }}" @if($question == $value ) selected @endif>{{ $value }}</option>
                  <?php } ?>
                  </select>
     
    </div>
                  <?php }
                
                } } ?>
   
<div class="text-right">
    {{ Form::button(__('Submit'), ['type' => 'submit','class' => 'btn btn-sm btn-primary rounded-pill']) }}
</div>
{{ Form::close() }}

<br>

<div class="row" id="blog_view">
     <div class="col-12">
        <div class="card">
            <div class="card-body p-0">
             
<!-- html -->



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