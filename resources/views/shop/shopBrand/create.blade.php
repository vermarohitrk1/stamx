{{ Form::open(['route' => 'shopBrand.store','id' => 'create_brand','enctype' => 'multipart/form-data']) }}
<div class="row">
    <div class="col-12 col-md-12">
        <div class="form-group">
            {{ Form::label('name', __('Brand name'),['class' => 'form-control-label']) }}
            {{ Form::text('name', null, ['class' => 'form-control','required'=>'required']) }}
        </div>
    </div>
</div>


<div class="text-right mt-5">
    {{ Form::button(__('Save'), ['type' => 'submit','class' => 'btn btn-sm btn-primary rounded-pill']) }}
    <button type="button" class="btn btn-sm btn-secondary rounded-pill" data-dismiss="modal">{{__('Cancel')}}</button>
</div>
{{ Form::close() }}
<style>
    .modal-content {
        margin: 75px;
        width: 76%;
    }
</style>

    
  