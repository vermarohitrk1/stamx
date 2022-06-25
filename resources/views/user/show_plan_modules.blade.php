<style>
.form-check-label {
    font-weight: bolder;
}
</style>
<p>Current Plan Modules.</p>
<div class="form-group">

<div class="form-check row" style="display: flex;">
    
    @if(!empty($addons))
        @foreach($addons as $addon)
            @if(in_array($addon->id,$plan->getPlanAddons())) 
                <div class="col-md-6">
                    <label class="form-check-label" style="display: inline-block;"> {{ $addon->title }}</label>
                </div>
            @endif
        @endforeach
    @endif
    
</div>
</div>
<div class="text-right">
    <button type="button" class="btn btn-sm btn-secondary rounded-pill" data-dismiss="modal">{{__('Close')}}</button>
</div>