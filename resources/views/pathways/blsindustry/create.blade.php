
{{ Form::open(['route' => ['bls.category.store'],'id' => 'create_category','enctype' => 'multipart/form-data']) }}
<div class="row">
    <div class="col-12 col-md-12">
        <div class="form-group">
            {{ Form::label('name', __('Industry name'),['class' => 'form-control-label']) }}
            {{ Form::text('name', null, ['class' => 'form-control','required'=>'required']) }}
        </div>
        <div class="form-group">
            {{ Form::label('name', __('NAICS Code'),['class' => 'form-control-label']) }}
            {{ Form::text('code', null, ['class' => 'form-control','required'=>'required']) }}
        </div>

 

       
<!--        <div class="form-check">
         <input type="checkbox" class="form-check-input" id="exampleCheck1" name="featured" value="1">
          <label class="form-check-label" for="exampleCheck1"> Featured </label>
       </div>-->
    </div> 
</div>

<div class="text-right">
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


