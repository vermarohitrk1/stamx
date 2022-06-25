{{ Form::open(['route' => 'plans.addons.add','id' => 'plans_addons_add','enctype' => 'multipart/form-data']) }}
<p>Plan Modules manager.</p>
<input type="hidden" name="planId" value="{{$plan->id}}" />
<div class="form-group">
<label>Modules</label>
<div class="form-check row" style="display: flex;">
    @if(!empty($addons))
    @foreach($addons as $addon)
    <div class="col-md-3">
    <input type="checkbox" name="addons[]" value="{{ $addon->id }}" @if(in_array($addon->id,$plan->getPlanAddons())) checked @endif class="form-check-input">
    <label class="form-check-label" style="display: inline-block;">{{ ucfirst($addon->title) }}</label>
    </div>
    @endforeach
    @endif
</div>
</div>
<div class="text-right">
    {{ Form::button(__('Save'), ['type' => 'submit','class' => 'btn btn-sm btn-primary rounded-pill']) }}
    <button type="button" class="btn btn-sm btn-secondary rounded-pill" data-dismiss="modal">{{__('Cancel')}}</button>
</div>
{{ Form::close() }}