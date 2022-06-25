@php
/**
 * @var \App\JobFormField $jobFieldData
 */
@endphp
<div class="container mt-3">
    <form data-url="" class="" id="field-data">
        {{Form::hidden('form_id', $parent_id, ['id'=>'form_id']) }}
        @if(!empty($jobFieldData->id))
            {{Form::hidden('field_id', !empty($jobFieldData->id)?$jobFieldData->id:'', ['id'=>'field_id']) }}
        @endif
        <div class="form-group">
            {{ Form::label('name', 'Name') }}
            <div>
                {{ Form::text('label', !empty($jobFieldData->label)?$jobFieldData->label:'' , ['id' => 'label', "required"=>true, 'placeholder'=>"Enter custom field name", 'class'=>'form-control']) }}
                <sapn id="label-error" style="color: red; font-size: smaller"></sapn>
            </div>
        </div>
        <div class="form-group">
            {{ Form::label('type', 'Type') }}
            <div>
            {{ Form::select('type', $jobFieldData->getTypeOption($parent_id), !empty($jobFieldData->type)?$jobFieldData->type:'' , ['id'=>'type', 'class' => 'custom-select form-control']) }}
                <sapn id="type-error" style="color: red; font-size: small"></sapn>
            </div>
        </div>
        {{Form::hidden('job_id', $job_id, ['id'=>'job_id']) }}
        <div class="form-group" id="custom-option" style="display:none;">
            {{ Form::label('option', 'Options') }}
            <div class="custom-input-group mb-2">
                {{ Form::text('', '' , ['id'=>'option', 'class' => 'form-control', 'placeholder' => 'Type option name']) }}
                <sapn id="option-error" style="color: red; font-size: small"></sapn>
                <div class="input-group-append">
                    <button type="button" class="add-option">
                        <i class="fa fa-plus" aria-hidden="true"></i>
                    </button>
                </div>
            </div>
        </div>
        <div class="option-list">
            @if(!empty($jobFieldData->jobFormOption))
                @foreach($jobFieldData->jobFormOption as $option)
                    <div class="default-base-color rounded d-flex align-items-center justify-content-between px-3 py-2 mb-1">
                        <input name="option_values[]" type="hidden" value="{{ $option->label }}"><span>{{ $option->label }}</span>
                        <button type="button" class="btn padding-5 delete-option-list"><i class="far fa-trash-alt"></i></button>
                    </div>
                @endforeach
            @endif

        </div>
    </form>
</div>
<script type="text/javascript">
    $(document).ready(function () {
        var selectedVal = $('#type').val()
        if(selectedVal == 'radio' || selectedVal == 'checkbox' || selectedVal == 'select'){
            $('#custom-option').show();
        }else{
            $('#custom-option').hide();
        }
    });
</script>



