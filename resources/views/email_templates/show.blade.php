<?php $page = "Email Templates"; ?>
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
               <a href="{{ route('email_template.index') }}" class="btn btn-sm btn-primary float-right btn-icon-only rounded-circle " >
            <span class="btn-inner--icon"><i class="fas fa-reply"></i></span></a>
         
            
                     </div>
   
<!-- Breadcrumb -->
<div class="breadcrumb-bar mt-3">
    <div class="container-fluid">
        <div class="row align-items-center">
            <div class="col-md-12 col-12">
                <h2 class="breadcrumb-title">Email Template Details</h2>
                <nav aria-label="breadcrumb" class="page-breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{route('dashboard')}}">Home</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Email Template Details</li>
                    </ol>
                </nav>
            </div>              
        </div>            
    </div>
</div>
<!-- /Breadcrumb -->


<div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    {{Form::model($emailTemplate, array('route' => array('email_template.update', $emailTemplate->id), 'method' => 'PUT')) }}
                    <div class="row">
                        <div class="form-group col-md-6">
        {{Form::label('integration_place',__('Create Template For'))}}
        {{Form::select('integration_place', $integration_place, null, ['id'=>'integration_place','class' => 'form-control select2','style'=>'width:100%','required'=>'required']) }}
    </div>
                         <div class="form-group col-md-6">
        {{Form::label('show_for',__('Show For'))}}
        {{ Form::select('show_for', ['None' => 'None', 'AR' => 'Auto Responders'], null, ['class' => 'form-control']) }}
    </div>
                                <div class="form-group col-md-6">
        {{Form::label('status',__('Status'))}}
        {{ Form::select('status', ['Active' => 'Active', 'InActive' => 'InActive'], null, ['class' => 'form-control']) }}
    </div>
                        <div class="form-group col-md-6">
                            {{Form::label('name',__('Template Name'))}}
                            {{Form::text('name',null,array('class'=>'form-control font-style'))}}
                        </div>
                        <div class="form-group col-md-6">
                            {{Form::label('from',__('Email From'))}}
                            {{Form::text('from',null,array('class'=>'form-control font-style','required'=>'required'))}}
                        </div>
                        <div class="form-group col-12">
        {{ Form::label('keyword', __('Keyword'),['class' => 'form-control-label']) }}
        <small class="form-text text-muted  mt-0">{{ __('Seprated By Comma') }}</small>
        <small class="form-text text-muted mb-2 mt-0">{{ __('i.e Innovative Learning Place Name:{learning_place}') }}</small>
        {{ Form::text('keyword', null, ['class' => 'form-control','data-toggle' => 'tags','placeholder' => __('Type here...'),]) }}
        <small class="form-text text-muted mb-2 mt-2">{{ __('Note: Your defined keywords will be used to replace bracket closed keywords in template content. e.g if you will use {learning_place} in template content then it will be replaced with Innovative Learning Place Name') }}</small>
    </div>
                
                        {{Form::hidden('lang',$currEmailTempLang->lang,array('class'=>''))}}
                        <div class="form-group col-md-12 text-right">
                            {{Form::submit(__('Save'),array('class'=>'btn btn-primary rounded-pill'))}}
                           
                        </div>
                    </div>
                    {{ Form::close() }}
                </div>
            </div>
        </div>
        <div class="col-12">
            <div class="card">
             
                <div class="card-body">
                    
              
                    <div class="language-wrap">
                        <div class="row">
                            <div class="col-lg-12 col-md-12 col-sm-12 language-form-wrap">
                                {{Form::model($currEmailTempLang, array('route' => array('store.email.language',$currEmailTempLang->parent_id), 'method' => 'PUT')) }}
                                <div class="row">
                                    <div class="col-12">
                                        <div class="form-group">
                                            {{Form::label('subject',__('Email Subject'))}}
                                            {{Form::text('subject',null,array('class'=>'form-control font-style','required'=>'required'))}}
                                        </div>
                                    </div>
                                    <div class="col-12">
                                        <div class="form-group">
                                            {{Form::label('content',__('Email Message Body'))}}
                                            {{Form::textarea('content',$currEmailTempLang->content,array('class'=>'form-control','id'=>'summary-ckeditor','required'=>'required'))}}
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-12 text-right">
                                    {{Form::hidden('lang',null)}}
                                    {{Form::submit(__('Save'),array('class'=>'btn  btn-primary rounded-pill'))}}
                           
                                </div>
                                {{ Form::close() }}
                            </div>
                            
                        </div>
                    </div>
                    
                    <div class="row">
                         <div class="form-group col-md-12">
                             <b><u>Custom Keywords</u></b>
                             
                            @foreach(explode(',',$emailTemplate->keyword) as $keyword)
                                @php($word = explode(':',$keyword))
                                <p class="mb-1">{{__(!empty($word[0]) ? $word[0] :'') }} : <span class="pull-right text-primary">{{ (!empty($word[1]) ? $word[1]:'') }}</span></p>
                            @endforeach
                            <small>Note: Your defined keywords will be used to replace bracket closed keywords in template content. i.e You have created custom keyword <b>Innovative Learning Place Name:{learning_place}</b> if you will use <b>{learning_place}</b> in template content then it will be replaced with <b>Innovative Learning Place Name</b></small>
                        </div>
                         <div class="form-group col-md-12">
                             <b><u>System Keywords</u></b>
                            <p class="mb-1">{{__('Content of integration place')}} : <span class="pull-right text-primary">{content}</span></p>
                            <p class="mb-1">{{__('App name managed by admin')}} : <span class="pull-right text-primary">{app_name}</span></p>
                            <p class="mb-1">{{__('App url from where email is generated')}} : <span class="pull-right text-primary">{app_url}</span></p>
                            <p class="mb-1">{{__('Unsubscribe url option')}} : <span class="pull-right text-primary">{unsubscribe_url}</span></p>
                            <p class="mb-1">{{__('User name of who is receiving email')}} : <span class="pull-right text-primary">{name}</span></p>
                            <p class="mb-1">{{__('User email address of who is receiving email')}} : <span class="pull-right text-primary">{email}</span></p>
                            <small>Note: If you will use system keywords in email template body then these will be replaced with related description.</small>
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
<link rel="stylesheet" href="{{ asset('assets/libs/bootstrap-tagsinput/dist/bootstrap-tagsinput-typeahead.css') }}">
<script src="{{ asset('assets/libs/bootstrap-tagsinput/dist/bootstrap-tagsinput.min.js') }}"></script>

<script src="{{ asset('public/ckeditor/ckeditor.js') }}"></script>
<script type="text/javascript">
    
CKEDITOR.replace('summary-ckeditor');
    $(function () {    
    
    
  });

</script>


@endpush
