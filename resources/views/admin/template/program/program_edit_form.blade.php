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
                <h2 class="breadcrumb-title">Edit Program</h2>
                <nav aria-label="breadcrumb" class="page-breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Home</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Edit Program</li>
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
   
            <div class="row">
            <div class="col-sm-12">
                <div class="card">
                    <div class="card-body">
                   

   {{ Form::open(['route' => ['program.store'],'id' => 'program_form','enctype' => 'multipart/form-data']) }}
                <input type="hidden" name="csrf-token" value="<?=csrf_token();?>" />
                <input type="hidden" name="id" value="{{ $data->id }}" />
                <div class="col-md-12">
                                    <label class="form-control-label">Title</label>
                                    <input type="text" class="form-control" name="title" value="{{ $data->title }}">
                                    
                                </div></br>

                <div class="col-md-12">
                      <label class="form-control-label">Price</label>
                          <input type="number" class="form-control" name="price" value="{{ $data->price }}">
                                    
                 </div></br>
             
                 <div class="col-md-12">
                      <label class="form-control-label">State</label>
                 <select class="form-control states"  name="state[]" multiple>
           
                
                  <option value="Alabama" @if($data->state != null) @php  $state = json_decode($data->state,'true'); @endphp @foreach( $state as $key => $value) @if($value == 'Alabama') selected @endif  @endforeach @endif>Alabama</option>
                  <option value="Alaska" @if($data->state != null) @php  $state = json_decode($data->state,'true'); @endphp @foreach( $state as $key => $value) @if($value == 'Alaska') selected @endif  @endforeach @endif>Alaska</option>
                  <option value="Arizona" @if($data->state != null) @php  $state = json_decode($data->state,'true'); @endphp @foreach( $state as $key => $value) @if($value == 'Arizona') selected @endif  @endforeach @endif>Arizona</option>
                  <option value="Arkansas" @if($data->state != null) @php  $state = json_decode($data->state,'true'); @endphp @foreach( $state as $key => $value) @if($value == 'Arkansas') selected @endif  @endforeach @endif>Arkansas</option>
                  <option value="California" @if($data->state != null) @php  $state = json_decode($data->state,'true'); @endphp @foreach( $state as $key => $value) @if($value == 'California') selected @endif  @endforeach @endif>California</option>
                  <option value="Colorado" @if($data->state != null) @php  $state = json_decode($data->state,'true'); @endphp @foreach( $state as $key => $value) @if($value == 'Colorado') selected @endif  @endforeach @endif>Colorado</option>
                  <option value="Connecticut" @if($data->state != null) @php  $state = json_decode($data->state,'true'); @endphp @foreach( $state as $key => $value) @if($value == 'Connecticut') selected @endif  @endforeach @endif>Connecticut</option>
                  <option value="Delaware" @if($data->state != null) @php  $state = json_decode($data->state,'true'); @endphp @foreach( $state as $key => $value) @if($value == 'Delaware') selected @endif  @endforeach @endif>Delaware</option>
                  <option value="District Of Columbia" @if($data->state != null) @php  $state = json_decode($data->state,'true'); @endphp @foreach( $state as $key => $value) @if($value == 'District Of Columbia') selected @endif  @endforeach @endif>District Of Columbia</option>
                  <option value="Florida" @if($data->state != null) @php  $state = json_decode($data->state,'true'); @endphp @foreach( $state as $key => $value) @if($value == 'Florida') selected @endif  @endforeach @endif>Florida</option>
                  <option value="Georgia" @if($data->state != null) @php  $state = json_decode($data->state,'true'); @endphp @foreach( $state as $key => $value) @if($value == 'Georgia') selected @endif  @endforeach @endif>Georgia</option>
                  <option value="Hawaii" @if($data->state != null) @php  $state = json_decode($data->state,'true'); @endphp @foreach( $state as $key => $value) @if($value == 'Hawaii') selected @endif  @endforeach @endif>Hawaii</option>
                  <option value="Idaho" @if($data->state != null) @php  $state = json_decode($data->state,'true'); @endphp @foreach( $state as $key => $value) @if($value == 'Idaho') selected @endif  @endforeach @endif>Idaho</option>
                  <option value="Illinois" @if($data->state != null) @php  $state = json_decode($data->state,'true'); @endphp @foreach( $state as $key => $value) @if($value == 'Illinois') selected @endif  @endforeach @endif>Illinois</option>
                  <option value="Indiana" @if($data->state != null) @php  $state = json_decode($data->state,'true'); @endphp @foreach( $state as $key => $value) @if($value == 'Indiana') selected @endif  @endforeach @endif>Indiana</option>
                  <option value="Iowa" @if($data->state != null) @php  $state = json_decode($data->state,'true'); @endphp @foreach( $state as $key => $value) @if($value == 'Iowa') selected @endif  @endforeach @endif>Iowa</option>
                  <option value="Kansas" @if($data->state != null) @php  $state = json_decode($data->state,'true'); @endphp @foreach( $state as $key => $value) @if($value == 'Kansas') selected @endif  @endforeach @endif>Kansas</option>
                  <option value="Kentucky" @if($data->state != null) @php  $state = json_decode($data->state,'true'); @endphp @foreach( $state as $key => $value) @if($value == 'Kentucky') selected @endif  @endforeach @endif>Kentucky</option>
                  <option value="Louisiana" @if($data->state != null) @php  $state = json_decode($data->state,'true'); @endphp @foreach( $state as $key => $value) @if($value == 'Louisiana') selected @endif  @endforeach @endif>Louisiana</option>
                  <option value="Maine" @if($data->state != null) @php  $state = json_decode($data->state,'true'); @endphp @foreach( $state as $key => $value) @if($value == 'Maine') selected @endif  @endforeach @endif>Maine</option>
                  <option value="Maryland" @if($data->state != null) @php  $state = json_decode($data->state,'true'); @endphp @foreach( $state as $key => $value) @if($value == 'Maryland') selected @endif  @endforeach @endif>Maryland</option>
                  <option value="Massachusetts" @if($data->state != null) @php  $state = json_decode($data->state,'true'); @endphp @foreach( $state as $key => $value) @if($value == 'Massachusetts') selected @endif  @endforeach @endif>Massachusetts</option>
                  <option value="Michigan" @if($data->state != null) @php  $state = json_decode($data->state,'true'); @endphp @foreach( $state as $key => $value) @if($value == 'Michigan') selected @endif  @endforeach @endif>Michigan</option>
                  <option value="Minnesota" @if($data->state != null) @php  $state = json_decode($data->state,'true'); @endphp @foreach( $state as $key => $value) @if($value == 'Minnesota') selected @endif  @endforeach @endif>Minnesota</option>
                  <option value="Mississippi" @if($data->state != null) @php  $state = json_decode($data->state,'true'); @endphp @foreach( $state as $key => $value) @if($value == 'Mississippi') selected @endif  @endforeach @endif>Mississippi</option>
                  <option value="Missouri" @if($data->state != null) @php  $state = json_decode($data->state,'true'); @endphp @foreach( $state as $key => $value) @if($value == 'Missouri') selected @endif  @endforeach @endif>Missouri</option>
                  <option value="Montana" @if($data->state != null) @php  $state = json_decode($data->state,'true'); @endphp @foreach( $state as $key => $value) @if($value == 'Montana') selected @endif  @endforeach @endif>Montana</option>
                  <option value="Nebraska" @if($data->state != null) @php  $state = json_decode($data->state,'true'); @endphp @foreach( $state as $key => $value) @if($value == 'Nebraska') selected @endif  @endforeach @endif>Nebraska</option>
                  <option value="Nevada" @if($data->state != null) @php  $state = json_decode($data->state,'true'); @endphp @foreach( $state as $key => $value) @if($value == 'Nevada') selected @endif  @endforeach @endif>Nevada</option>
                  <option value="New Hampshire" @if($data->state != null) @php  $state = json_decode($data->state,'true'); @endphp @foreach( $state as $key => $value) @if($value == 'New Hampshire') selected @endif  @endforeach @endif>New Hampshire</option>
                  <option value="New Jersey" @if($data->state != null) @php  $state = json_decode($data->state,'true'); @endphp @foreach( $state as $key => $value) @if($value == 'New Jersey') selected @endif  @endforeach @endif>New Jersey</option>
                  <option value="New Mexico" @if($data->state != null) @php  $state = json_decode($data->state,'true'); @endphp @foreach( $state as $key => $value) @if($value == 'New Mexico') selected @endif  @endforeach @endif>New Mexico</option>
                  <option value="New York" @if($data->state != null) @php  $state = json_decode($data->state,'true'); @endphp @foreach( $state as $key => $value) @if($value == 'New York') selected @endif  @endforeach @endif>New York</option>
                  <option value="North Carolina" @if($data->state != null) @php  $state = json_decode($data->state,'true'); @endphp @foreach( $state as $key => $value) @if($value == 'North Carolina') selected @endif  @endforeach @endif>North Carolina</option>
                  <option value="North Dakota" @if($data->state != null) @php  $state = json_decode($data->state,'true'); @endphp @foreach( $state as $key => $value) @if($value == 'North Dakota') selected @endif  @endforeach @endif>North Dakota</option>
                  <option value="Ohio" @if($data->state != null) @php  $state = json_decode($data->state,'true'); @endphp @foreach( $state as $key => $value) @if($value == 'Ohio') selected @endif  @endforeach @endif>Ohio</option>
                  <option value="Oklahoma" @if($data->state != null) @php  $state = json_decode($data->state,'true'); @endphp @foreach( $state as $key => $value) @if($value == 'Oklahoma') selected @endif  @endforeach @endif>Oklahoma</option>
                  <option value="Oregon" @if($data->state != null) @php  $state = json_decode($data->state,'true'); @endphp @foreach( $state as $key => $value) @if($value == 'Oregon') selected @endif  @endforeach @endif>Oregon</option>
                  <option value="Pennsylvania" @if($data->state != null) @php  $state = json_decode($data->state,'true'); @endphp @foreach( $state as $key => $value) @if($value == 'Pennsylvania') selected @endif  @endforeach @endif>Pennsylvania</option>
                  <option value="Rhode Island" @if($data->state != null) @php  $state = json_decode($data->state,'true'); @endphp @foreach( $state as $key => $value) @if($value == 'Rhode Island') selected @endif  @endforeach @endif>Rhode Island</option>
                  <option value="South Carolina" @if($data->state != null) @php  $state = json_decode($data->state,'true'); @endphp @foreach( $state as $key => $value) @if($value == 'South Carolina') selected @endif  @endforeach @endif>South Carolina</option>
                  <option value="South Dakota" @if($data->state != null) @php  $state = json_decode($data->state,'true'); @endphp @foreach( $state as $key => $value) @if($value == 'South Dakota') selected @endif  @endforeach @endif>South Dakota</option>
                  <option value="Tennessee" @if($data->state != null) @php  $state = json_decode($data->state,'true'); @endphp @foreach( $state as $key => $value) @if($value == 'Tennessee') selected @endif  @endforeach @endif>Tennessee</option>
                  <option value="Texas" @if($data->state != null) @php  $state = json_decode($data->state,'true'); @endphp @foreach( $state as $key => $value) @if($value == 'Texas') selected @endif  @endforeach @endif>Texas</option>
                  <option value="Utah" @if($data->state != null) @php  $state = json_decode($data->state,'true'); @endphp @foreach( $state as $key => $value) @if($value == 'Utah') selected @endif  @endforeach @endif>Utah</option>
                  <option value="Vermont" @if($data->state != null) @php  $state = json_decode($data->state,'true'); @endphp @foreach( $state as $key => $value) @if($value == 'Vermont') selected @endif  @endforeach @endif>Vermont</option>
                  <option value="Virginia" @if($data->state != null) @php  $state = json_decode($data->state,'true'); @endphp @foreach( $state as $key => $value) @if($value == 'Virginia') selected @endif  @endforeach @endif>Virginia</option>
                  <option value="Washington" @if($data->state != null) @php  $state = json_decode($data->state,'true'); @endphp @foreach( $state as $key => $value) @if($value == 'Washington') selected @endif  @endforeach @endif>Washington</option>
                  <option value="West Virginia" @if($data->state != null) @php  $state = json_decode($data->state,'true'); @endphp @foreach( $state as $key => $value) @if($value == 'West Virginia') selected @endif  @endforeach @endif>West Virginia</option>
                  <option value="Wisconsin" @if($data->state != null) @php  $state = json_decode($data->state,'true'); @endphp @foreach( $state as $key => $value) @if($value == 'Wisconsin') selected @endif  @endforeach @endif>Wisconsin</option>
                  <option value="Wyoming" @if($data->state != null) @php  $state = json_decode($data->state,'true'); @endphp @foreach( $state as $key => $value) @if($value == 'Wyoming') selected @endif  @endforeach @endif>Wyoming</option>
         </select>
</div></br>
<div class="form-group">
  
                    <label class="form-control-label">Category</label>
                    <select class="form-control"  name="category_id">
                     <?php echo $selectedopt = App\ProgramCategory::find($data->category_id)->id;
                     foreach($program_category as $key => $value){ ?>
                         <option value="{{  $value->id }}" <?php if(  $selectedopt == $value->id ){ echo 'selected'; } ?> >{{ $value->name }}</option>
                  <?php } ?>
                  </select></br>
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
                                    <textarea name="question_<?php echo $i ?>"><?php if(is_array($question)){
                                    foreach($question as $val){ 
                                        echo $val; echo "</br>";
                }
            }else{ 
                echo $question;
            } ?></textarea>
                                    
                                </div>
                            </div>
                        </div>
                <?php  } 
             else if($questions[$key]['type'] == 'checkbox'){ $i++; ?>
               <div class="form-group">
                  <label class="form-control-label">Q:<?php echo $i; ?>  <?php echo "   "; echo $questions[$key]['question']  ; ?></label>

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