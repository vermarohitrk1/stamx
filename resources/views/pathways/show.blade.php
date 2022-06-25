<?php $page = "pathway"; ?>
@extends('layout.dashboardlayout')
@section('content')	


<!-- Page Content -->
<input type="hidden" value="{{  $id }}" id="pathwayId" >
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
                   <a href="{{ route('pathway.get') }}" class="btn btn-sm btn-primary float-right btn-icon-only rounded-circle " >
        <span class="btn-inner--icon"><i class="fas fa-reply"></i></span>
    </a>
                     </div>
   
<!-- Breadcrumb -->
<div class="breadcrumb-bar mt-3">
    <div class="container-fluid">
        <div class="row align-items-center">
            <div class="col-md-12 col-12">
                <h2 class="breadcrumb-title">Pathway Preview</h2>
                <nav aria-label="breadcrumb" class="page-breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Home</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('pathway.get') }}">Pathway</a></li>
                        <li class="breadcrumb-item active" aria-current="page"> Preview</li>
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
<div class="card-body custom-border-card pb-0">

<div class="widget education-widget mb-0">
<h4 class="widget-title">Details</h4>
<hr>
<div class="experience-box">
<div class="experience-list profile-custom-list row">
<div class="col-md-3 mt-3">
<div class="experience-content">
<div class="timeline-content">
<span>Mentor Type</span>
<div class="row-result">{{ str_replace('_',' ',$pathway->mentor_type) }}</div>
</div>
</div>
</div>

<div class="col-md-3 mt-3">
<div class="experience-content">
<div class="timeline-content">
@if($pathway->type != null)
<span>Type</span>
<div class="row-result">{{ $pathway->type }}</div>
@endif

</div>
</div>
</div>
@if($pathway->level != null)
<div class="col-md-3 mt-3">
<div class="experience-content">
<div class="timeline-content">


<span>Level</span>
<div class="row-result">{{ $pathway->level }}</div> 

</div>
</div>
</div>
@endif
<div class="col-md-3 mt-3">
<div class="experience-content">
<div class="timeline-content">
@if(!empty(json_decode($pathway->school, true)))
<span>School</span>
<div class="row-result"> 
    @foreach(json_decode($pathway->school, true) as $key => $values)  
    @if(!empty($values))
{{ \App\Institution::find($values )->institution??'' }} <span>,</span>
@endif
@endforeach 
</div> 
@endif
</div>
</div>
</div>
@if(!empty(json_decode($pathway->college, true)))
<div class="col-md-3 mt-3">
<div class="experience-content">
<div class="timeline-content">

<span>College</span>
<div class="row-result"> 
    @foreach(json_decode($pathway->college, true) as $key => $values)    
    @if(!empty($values))
    {{ \App\Institution::find($values )->institution??'' }}  <span>,</span>
@endif

@endforeach 
</div>

</div>
</div>
</div>
    @endif
    @if($pathway->employee != null)
   <div class="col-md-3 mt-3">
<div class="experience-content">
<div class="timeline-content"> 

<span>Company</span>
<div class="row-result">{{ \App\Employer::find($pathway->employee )->company }}</div> 


</div>
</div>
</div>
   @endif
   @if($pathway->catalog != null)
  <div class="col-md-3 mt-3">
<div class="experience-content">
<div class="timeline-content">  

<span>Certification</span>
<div class="row-result">{{ \App\CertifyCategory::find($pathway->catalog )->name??''}}</div> 

</div>
</div>
</div>
@endif
@if($pathway->branch != null)
<div class="col-md-3 mt-3">
<div class="experience-content">
<div class="timeline-content">

<span>Branch</span>
<div class="row-result">@if($pathway->branch == 'space_force') Space Force @elseif($pathway->branch == 'marine_corps') Marine Corps  @elseif($pathway->branch == 'coast_guard') Coast Guard @else{{ $pathway->branch }} @endif </div> 

</div>
</div>
</div>
@endif
@if(!empty($pathway->wifi))
<div class="col-md-3 mt-3">
<div class="experience-content">
<div class="timeline-content">

<span>Home Wifi Facility</span>
<div class="row-result">{{$pathway->wifi??''}} </div> 

</div>
</div>
</div>
@endif
@if(!empty($pathway->home_pc))
<div class="col-md-3 mt-3">
<div class="experience-content">
<div class="timeline-content">

<span>Tablet/PC Facility</span>
<div class="row-result">{{$pathway->home_pc??''}} </div> 

</div>
</div>
</div>
@endif

@if(!empty($pathway->library))
<div class="col-md-3 mt-3">
<div class="experience-content">
<div class="timeline-content">

<span>Closest Library</span>
<div class="row-result">{{ \App\Institution::find($pathway->library )->institution??'' }}  </div> 

</div>
</div>
</div>
@endif

@if(!empty($pathway->pha_community_id))
<div class="col-md-3 mt-3">
<div class="experience-content">
<div class="timeline-content">

<span>PHA Community Belongs</span>
<div class="row-result">{{ \App\Institution::find($pathway->pha_community_id )->institution??'' }}  </div> 

</div>
</div>
</div>
@endif

@if(!empty($pathway->mayor))
<div class="col-md-3 mt-3">
<div class="experience-content">
<div class="timeline-content">

<span>Town Mayor</span>
<div class="row-result">{{ \App\Institution::find($pathway->mayor )->institution??'' }}  </div> 

</div>
</div>
</div>
@endif

@if(!empty($pathway->military_base))
<div class="col-md-3 mt-3">
<div class="experience-content">
<div class="timeline-content">

<span>Military Base Belonging</span>
<div class="row-result">{{ \App\Institution::find($pathway->military_base )->institution??'' }}  </div> 

</div>
</div>
</div>
@endif

@if(!empty($pathway->justice_officer))
<div class="col-md-3 mt-3">
<div class="experience-content">
<div class="timeline-content">

<span>Justice Officer</span>
<div class="row-result">{{ \App\Institution::find($pathway->justice_officer )->institution??'' }}  </div> 

</div>
</div>
</div>
@endif

@if(!empty($pathway->reading_club))
<div class="col-md-3 mt-3">
<div class="experience-content">
<div class="timeline-content">

<span>Reading Club</span>
<div class="row-result">{{$pathway->reading_club??''}} </div> 

</div>
</div>
</div>
@endif

@if(!empty($pathway->sex_offender))
<div class="col-md-3 mt-3">
<div class="experience-content">
<div class="timeline-content">

<span>Registered Sex Offender</span>
<div class="row-result">{{$pathway->sex_offender??''}} </div> 

</div>
</div>
</div>
@endif

@if(!empty($pathway->expungement))
<div class="col-md-3 mt-3">
<div class="experience-content">
<div class="timeline-content">

<span>Expungement</span>
<div class="row-result">{{$pathway->expungement??''}} </div> 

</div>
</div>
</div>
@endif

@if(!empty($pathway->graduation_year))
<div class="col-md-3 mt-3">
<div class="experience-content">
<div class="timeline-content">

<span>Graduation Completion Year</span>
<div class="row-result">{{$pathway->graduation_year??''}} </div> 

</div>
</div>
</div>
@endif

@if(!empty($pathway->business_year))
<div class="col-md-3 mt-3">
<div class="experience-content">
<div class="timeline-content">

<span>Been in business from 2 year or more</span>
<div class="row-result">{{$pathway->business_year??''}} </div> 

</div>
</div>
</div>
@endif

@if(!empty($pathway->grant_opportunity))
<div class="col-md-3 mt-3">
<div class="experience-content">
<div class="timeline-content">

<span>RFI, RFP,  Grant opportunities</span>
<div class="row-result">{{$pathway->grant_opportunity??''}} </div> 

</div>
</div>
</div>
@endif

@if(!empty($pathway->probation_parole))
<div class="col-md-3 mt-3">
<div class="experience-content">
<div class="timeline-content">

<span>Probation, Parole</span>
<div class="row-result">{{$pathway->probation_parole??''}} </div> 

</div>
</div>
</div>
@endif

@if(!empty($pathway->tax_certificate))
<div class="col-md-3 mt-3">
<div class="experience-content">
<div class="timeline-content">

<span>Tax Exemption Certificate</span><a href="{{asset(Storage::url('pathways'))}}/{{$pathway->tax_certificate}}" download class="action-item" role="button">
                                                                    <i class="fas fa-download"></i>
                                                                </a>
<div class="row-result"></div> 

</div>
</div>
</div>
@endif

</div>
</div>
</div>

</div>
</div>
        <div class="card">
            <div class="card-body ">
             <input type="hidden" name="id" value={{ $pathway->id }} />

<div class="form-group">
    
   
     
         <div class="table-md-responsive">
         <div class="accordion" id="accordionExample">

<div class="card">
  <div class="card-header" id="headingTwo">
    <h2 class="mb-0">
      <button class="btn btn-link btn-block text-left" type="button" data-toggle="collapse" data-target="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">
        Invited Member
      </button>
    </h2>
  </div>
  <div id="collapseTwo" class="collapse show" aria-labelledby="headingTwo" data-parent="#accordionExample">
         <div class="card-body">
             
             @if(empty($mentor))
                          {{__('Nothing to found')}}
                    @else
            <table class="table table-hover table-center mb-0" id="example">
                      <thead class="thead-light">
                      <tr>
                          <th class=" mb-0 h6 text-sm"> {{__('Name')}}</th>
                          <th class=" mb-0 h6 text-sm"> {{__('Email')}}</th>
                      </tr>
                      </thead> 
                      <tbody>
                          @foreach($mentor as $key => $user)
                            @if( $user->name !='' )
                             <tr>
                              <td>{{ $user->name }}</td>
                               <td>{{ $user->email }}</td>
                            </tr>
                            @endif
                          @endforeach
                      </tbody>
             </table>
             @endif
         </div>
    </div>
  </div>

 </div>    

 </div>
       <a style="margin-left:20px;" class="btn btn-sm btn-primary .btn-rounded float-right" href="{{route('pathwaytimeline.show', encrypted_key($pathway->id, "encrypt")) }}" >Timeline </a>
        <a class="btn btn-sm btn-primary .btn-rounded float-right" href="#" data-ajax-popup="true" data-url="{{route('task.show', encrypted_key($pathway->id, "encrypt")) }}" data-size="md" data-title="Add Task">
            <span class="btn-inner--icon"><i class="fas fa-plus"></i></span>
        </a>
                </div>

  <h3>Task Manager</h3>
 <table class="table table-hover table-center mb-0" id="tasktable">
                      <thead class="thead-light">
                      <tr>
                         
                          <th class=" mb-0 h6 text-sm"> {{__('Title')}}</th>
                          <th class=" mb-0 h6 text-sm"> {{__('Category')}}</th>
                          <th class=" mb-0 h6 text-sm"> {{__('Due date')}}</th>
                          <th class=" mb-0 h6 text-sm"> {{__('created by')}}</th>
                          <th class=" mb-0 h6 text-sm"> {{__('Action')}}</th>

                      </tr>
                      </thead> 
                      
             </table>
</div>
        
    </div>

<div class="col-md-8">
  <div class="text-right">

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
<script src="{{ asset('assets/libs/dragula/dist/dragula.min.js') }}"></script>

<link rel="stylesheet" type="text/css" href="{{ asset('assets/libs/dropify/css/dropify.min.css') }}">
<script src="{{ asset('assets/libs/dropify/js/dropify.min.js') }}"></script>

<script src="{{ asset('public/ckeditor/ckeditor.js') }}"></script>
<script type="text/javascript" src="{{ asset('assets/js/jquery-ui.min.js') }}"></script>
<script type="text/javascript" src="{{ asset('assets/js/repeater.js') }}"></script>

<script>
$( document ).ready(function() {
    CKEDITOR.replace('summary-ckeditor');


  
    $('#send_reminder').on('change', function() {
    //$('input[name=send_reminder]').change(function(){

        var selected =$(this).val();
       if(selected == 'No'){
           $('#remindertype').hide();
       }
       else{
        $('#remindertype').show();
       }
    })
});
$(document).ready(function() {
    $('.certify').select2();
});


$(function () {    
    var pathwayId = $('#pathwayId').val();
  //  alert(pathwayId);
    var table = $('#tasktable').DataTable({
       responsive: true,
        processing: true,
        serverSide: true,
        ajax: "{{ url('/pathway/task') }}/"+pathwayId,
        columns: [
        
            {data: 'name', name: 'name',orderable: true,searchable: true},
            {data: 'type', name: 'type',orderable: true,searchable: true},
            {data: 'due_date', name: 'due_date'},
            {
                data: 'created_by', 
                name: 'created_by', 
                orderable: false, 
                searchable: false
            },
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