<?php $page = "Form Questions"; ?>
@extends('layout.dashboardlayout')
@section('content')	

     @php
        $user=Auth::user();
        $permissions=permissions();
        @endphp
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
               
       
                     <a href="{{ route('petitioncustom.dashboard') }}" class="btn btn-sm btn btn-primary float-right mr-2 m-0">
        <span class="btn-inner--text ">{{__('Dashboard')}}</span>
    </a>
                     
                   
                     </div>
                
   <!-- Breadcrumb -->
                <div class="breadcrumb-bar mb-3">
                    <div class="container-fluid">
                        <div class="row align-items-center">
                            <div class="col-md-12 col-12">
                                <h2 class="breadcrumb-title">Form Questions</h2>
                                <nav aria-label="breadcrumb" class="page-breadcrumb">
                                    <ol class="breadcrumb">
                                        <li class="breadcrumb-item"><a href="{{route('dashboard')}}">Dashboard</a></li>
                                        <li class="breadcrumb-item"><a href="{{route('petitioncustom.dashboard')}}">Petitions Dashboard</a></li>
                                        <li class="breadcrumb-item active" aria-current="page">Form Questions</li>
                                    </ol>
                                </nav>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- /Breadcrumb -->
                
   
    
    
<div class="row mt-3" id="blog_category_view">
    
        
<div class="col-lg-4 order-lg-2">
    <div id="page_sidebar_tabs"></div>
</div>
    {{--Main Part--}}
    <div class="col-lg-8 order-lg-1">
        <div id="tabs-1" class="tabs-card">
            <div class="card">
              <div class="card-header">
                 @if(in_array("manage_petitions",$permissions) || $user->type =="admin")  
                    <a href="{{ route('petitioncustom.index') }}" class="btn btn-sm float-right btn-primary btn-icon rounded-pill mr-1 ml-1">
        <span class="btn-inner--text"><i class="fas fa-reply"></i></span>
    </a>
                   @endif 
                    <h3>{{$form->title}}</h3>
                <p class="text-muted mb-0">{{ ucfirst($form->description) }}</p>
                </div>
              <div class="card-body">
                  <form class="simcy-form indexing-form fields-holder" action="{{ route('petitioncustomQuestion@indexing') }}" data-parsley-validate="" loader="false" method="POST" enctype="multipart/form-data">
                   @CSRF
                        @if(!empty($questions) && count($questions) > 0)
                        @foreach($questions as $i => $question)
                        <div class="input-field-item border border-light mb-2 cursor-default" style="cursor: pointer;">
                           <input type="hidden" class="field-indexing" name="question:{{ $question->id }}" value="{{ $i+1 }}">
                           <div class="row mt-3">
                               <div class="col-md-1">
                                  <div class="chapter-drag text-primary"><i class="fa fa-list"></i></div>
                               </div>
                               <div class="col-md-4">
                                   <h6 class="text-muted">Field Label </h6>
                               
                                   <p class="text-dark">{{ ucfirst(substr($question->question ,0,50)) }}...</p>
                               </div>                               
                               <div class="col-md-2">
                                   <h6 class="text-muted">Type</h6>
                                   <p class="text-dark">{{ $question->type }}</p>
                               </div>
                               <div class="col-md-3">
                                   <h6 class="text-muted">Option</h6>
                                   <p class="text-dark">{{ $question->options }}</p>
                               </div>
                               <div class="col-md-2">
                                   <h6 class="text-muted">Action</h6>
                                        <a href="{{route('petitioncustomQuestion.edit',['form_id' => encrypted_key($form->id,'encrypt'), 'id' => encrypted_key($question->id,'encrypt')])}}" data-toggle="tooltip" data-original-title="{{__('Edit')}}">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    <a href="javascript::void(0);" class="text-danger px-2 delete_record_model" data-url="{{route('petitioncustomQuestion.destroy',encrypted_key($question->id,'encrypt'))}}" data-toggle="tooltip" data-original-title="{{__('Delete')}}">
                                        <i class="fas fa-trash-alt"></i>
                                    </a> 
                               </div>
                           </div>
                       </div>
                        @endforeach
                        @else
                         <div class="empty-section">
                        <h6 class="text-danger">It's empty here, please add questions! </h6>
                    </div>
                        @endif
                  </form>
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
<!--<link rel="stylesheet" type="text/css" href="{{ asset('assets/libs/dragula/dist/dragula.min.css') }}">-->
<script src="{{ asset('assets/js/jquery-ui.min.js') }}"></script>
<script src="{{ asset('assets/js/simcify.min.js') }}"></script>
<script src="{{ asset('assets/js/tabsmanager.js') }}"></script>
    <!--<script src="{{asset('assets/libs/dragula/dist/dragula.min.js')}}"></script>-->
    <script>
    $(document).ready(function(){
      $.ajax({
       url:"{{route('petitioncustomForm.sidebar',!empty($form->id) ? encrypted_key($form->id,'encrypt') :0)}}?sidebar=form_questions",
       success:function(data)
       {
        $('#page_sidebar_tabs').html(data);
       }
      });
    });
</script>
   <script type="text/javascript">  
   
   $(document).on("click", ".destroypetitioncustomquestion", function(){
    var id = $(this).attr('data-id');
    $("#question_Id").val(id);
    $('#destroy_question').modal('show');
    }); 
   
          
    </script>  

@endpush


