{{ Form::open(array('route' => 'email_template.store','method' =>'post')) }}
<div class="row">
    <div class="form-group col-md-12">
        {{Form::label('integration_place',__('Create Template For'))}}
        {{Form::select('integration_place', $integration_place, null, ['id'=>'integration_place','class' => 'form-control select2','style'=>'width:100%','required'=>'required']) }}
    </div>
   
    <div class="form-group col-md-12">
        {{Form::label('name',__('Name'))}}
        {{Form::text('name',null,array('class'=>'form-control font-style','required'=>'required'))}}
    </div>

    <div class="form-group col-md-12">
        {{Form::label('name',__('Subject'))}}
        {{Form::text('subject',null,array('class'=>'form-control font-style','required'=>'required'))}}
    </div>

    <div class="form-group col-12">
        {{ Form::label('keyword', __('Keyword'),['class' => 'form-control-label']) }}
        <small class="form-text text-muted  mt-0">{{ __('Seprated By Comma') }}</small>
        <small class="form-text text-muted mb-2 mt-0">{{ __('i.e Innovative Learning Place Name:{learning_place}') }}</small>
        {{ Form::text('keyword', null, ['class' => 'form-control','data-toggle' => 'tags','placeholder' => __('Type here...'),]) }}
        <small class="form-text text-muted mb-2 mt-2">{{ __('Note: Your defined keywords will be used to replace bracket closed keywords in template content. e.g if you will use {learning_place} in template content then it will be replaced with Innovative Learning Place Name') }}</small>
    </div>  
    <div class="form-group col-md-12">
        {{Form::label('show_for',__('Show For'))}}
        {{ Form::select('show_for', ['None' => 'None', 'AR' => 'Auto Responders'], null, ['class' => 'form-control']) }}
    </div>
     <div class="form-group col-md-12">
        {{Form::label('status',__('Status'))}}
        {{ Form::select('status', ['Active' => 'Active', 'InActive' => 'InActive'], null, ['class' => 'form-control']) }}
    </div>
   
    <div class="form-group col-md-12 text-right">
        {{Form::submit(__('Create'),array('class'=>'btn btn-sm btn-primary rounded-pill'))}}
    </div>
</div>
{{ Form::close() }}
 <script>

    $('#integration_place').select2();
    </script>
