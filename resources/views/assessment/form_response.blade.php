<?php $page = "Form Response"; ?>
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
               
       
                     <a href="{{ route('assessment.dashboard') }}" class="btn btn-sm btn btn-primary float-right mr-2 m-0">
        <span class="btn-inner--text ">{{__('Dashboard')}}</span>
    </a>
                     
                   
                     </div>
                
   <!-- Breadcrumb -->
                <div class="breadcrumb-bar mb-3">
                    <div class="container-fluid">
                        <div class="row align-items-center">
                            <div class="col-md-12 col-12">
                                <h2 class="breadcrumb-title">Form Response</h2>
                                <nav aria-label="breadcrumb" class="page-breadcrumb">
                                    <ol class="breadcrumb">
                                        <li class="breadcrumb-item"><a href="{{route('dashboard')}}">Dashboard</a></li>
                                        <li class="breadcrumb-item"><a href="{{ route('assessment.dashboard') }}">Form Dashboard</a></li>
                                        <li class="breadcrumb-item active" aria-current="page">Form Response</li>
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
                        @if(in_array("manage_surveys",$permissions) || $user->type =="admin")  
                    <a href="{{ route('assessment.index') }}" class="btn btn-sm float-right btn-primary btn-icon rounded-pill mr-1 ml-1">
        <span class="btn-inner--text"><i class="fas fa-reply"></i></span>
    </a>
             @endif             
                    <h3>{{$form->title}}</h3>
                <p class="text-muted mb-0">{{ ucfirst($form->description) }}</p>
                </div>
                
                    
                <div class="card-body">
                    
                    @if(!empty(json_decode($response->response, true)))
                    @foreach(json_decode($response->response, true) as $i => $row)
                    <div class="form-group">
                        <div class="row">
                            <div class="col-md-12">
                                <label class="form-control-label text-muted">{{ $row['question'] }} <span class="text-primary">({{ $row['points'] }} points)</span></label>
                                <p class="form-control-label"><b>{{__('Answer:')}}</b> {{ $row['answer'] }}</p>
                            </div>
                        </div>
                    </div>
                    @endforeach
                    
                    <h5 class="text-center text-primary">Form Filled By: <b>{{ucwords($response_by_user)}}</b></h5>
                    @else
                    <div class="empty-section">
                        <i class="fa fa-clipboard-text"></i>
                        <h6 class="text-danger">User has not filled this assessment form! </h6>
                    </div> 
                    <br>
                    <h5 class="text-center text-primary">Form Assigned To: <b>{{ucwords($response_by_user)}}</b></h5>
                    
                    @endif
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
<script>
    $(document).ready(function(){
      $.ajax({
       url:"{{route('assessmentForm.sidebar',!empty($form->id) ? encrypted_key($form->id,'encrypt') :0)}}?sidebar=form_questions_preview",
       success:function(data)
       {
        $('#page_sidebar_tabs').html(data);
       }
      });
    });
</script>

@endpush


