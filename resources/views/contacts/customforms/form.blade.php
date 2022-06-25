<?php $page = "Form Preview"; ?>
@section('title')
    {{$page}}
@endsection
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
               
       
                     <a href="{{ route('crmcustom.dashboard') }}" class="btn btn-sm btn btn-primary float-right mr-2 m-0">
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
                                        <li class="breadcrumb-item"><a href="{{route('crmcustom.dashboard')}}">Surveys Dashboard</a></li>
                                        <li class="breadcrumb-item active" aria-current="page">Form Preview</li>
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
                    <a href="{{ route('crmcustom.index') }}" class="btn btn-sm float-right btn-primary btn-icon rounded-pill mr-1 ml-1">
        <span class="btn-inner--text"><i class="fas fa-reply"></i></span>
    </a>
             @endif             
                    <h3>{{$form->title}}</h3>
                <p class="text-muted mb-0">{{ ucfirst($form->description) }}</p>
                </div>
                <div class="card-body">
                    
                    @if(!empty($questions) && count($questions) > 0)
                    {{ Form::open(['route' => 'crmcustomForm.store','id' => 'new_input_form', 'name' => 'new_input_form','enctype' => 'multipart/form-data']) }}
                    <input type="hidden" name="id" value="{{!empty($form->id) ? encrypted_key($form->id,'encrypt') :0}}" />
                    <input type="hidden" name="csrf-token" value="<?= csrf_token(); ?>" />
                    @if ($errors->any())
                    <div class="alert alert-danger">
                        <ul>
                            @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                    @endif
                    @foreach($questions as $i => $question)

                    <div class="form-group">
                        <div class="row">
                            <div class="col-md-12">
                                <label class="form-control-label">{{ $question->question }} </label>
                                @if($question->type == "textarea")
                                <textarea class="form-control" placeholder="Please enter details" required="required" autocomplete="off" rows="4" name="{{ encrypted_key($question->id,'encrypt') }}" cols="50"></textarea>
                                @elseif($question->type == "checkbox")
                                  @foreach(explode(",", $question->options) as $option)
                                   <label class="checkbox-inline"><input  name="{{ encrypted_key($question->id,'encrypt') }}" type="checkbox" value="{{ $option }}">  {{ $option }}</label>
                                    @endforeach
                                
                                
                                @elseif($question->type == "radio")
                                  @foreach(explode(",", $question->options) as $option)
                                   <div class="radio">
                                       <label><input type="radio" value="{{ $option }}" name="{{ encrypted_key($question->id,'encrypt') }}"> {{ $option }}</label>
                                  </div>
                                    @endforeach
                                
                                
                                @elseif($question->type == "select")
                                <select class="form-control" name="{{ encrypted_key($question->id,'encrypt') }}">
                                    @foreach(explode(",", $question->options) as $option)
                                    <option @if(!empty($form_response->response) && !empty(json_decode($form_response->response, true)[$i]['question']) && json_decode($form_response->response, true)[$i]['question']==$question->question) selected @endif value="{{ $option }}">{{ $option }}</option>
                                    @endforeach
                                </select>
                                @elseif($question->type == "selectwith")
                                <select class="form-control" name="{{ encrypted_key($question->id,'encrypt') }}">
                                    @foreach(explode(",", $question->options) as $option)
                                    <option @if(!empty($form_response->response) && !empty(json_decode($form_response->response, true)[$i]['question']) && json_decode($form_response->response, true)[$i]['question']==$question->question) selected @endif value="{{ $option }}">{{ $option }}</option>
                                    @endforeach
                                </select>
                                @else
                                <input type="{{ $question->type }}" class="form-control" name="{{ encrypted_key($question->id,'encrypt') }}" placeholder="{{ $question->question }}" value="{{( !empty($form_response->response) && !empty(json_decode($form_response->response, true)[$i]['question']) && json_decode($form_response->response, true)[$i]['question']==$question->question) ? json_decode($form_response->response, true)[$i]['answer'] :''}}" required>
                                @endif
                            </div>
                        </div>
                    </div>
                    @endforeach
                    <div class="text-right">
                         @if($form->user_id !=Auth::user()->id)
                        {{ Form::button(__('Save Form'), ['type' => 'submit','class' => 'btn btn-sm btn-primary rounded-pill']) }}
                       @endif
                       @if(in_array("manage_surveys",$permissions) || $user->type =="admin")  
                        <a href="{{ route('crmcustom.index') }}">
                            <button type="button" class="btn btn-sm btn-secondary rounded-pill">{{__('Back')}}</button>
                        </a>
                        @endif 
                    </div>
                    {{ Form::close() }}
                    @else

                    <div class="empty-section">
                        <i class="fa fa-clipboard-text"></i>
                        <h6 class="text-danger">Nothing to fill on this form, no question exit! </h6>
                    </div>
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
       url:"{{route('crmcustomForm.sidebar',!empty($form->id) ? encrypted_key($form->id,'encrypt') :0)}}?sidebar=form_questions_preview",
       success:function(data)
       {
        $('#page_sidebar_tabs').html(data);
       }
      });
    });
</script>
<script>

$(function () {

// Initialize form validation on the form.
$("form[name='new_input_form']").validate({
// Specify validation rules
rules: {

},
        // Specify validation error messages
        messages: {
        
        },
        // Make sure the form is submitted to the destination defined
        // in the "action" attribute of the form when valid
        submitHandler: function (form) {
        form.submit();
        }
});
});
</script>

@endpush


