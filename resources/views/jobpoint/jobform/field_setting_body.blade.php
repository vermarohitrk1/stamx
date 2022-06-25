@php
/**
 * @var \App\JobFormEntity $jobFormEntity
 */
@endphp
@if(!empty($jobFields))
        <div class="container mt-3">
            <form data-url="" class="mb-0">
                <p>{{__('Select what should be included or required in the apply form')}}</p>
                <div class="table-responsive mb-2">
                    <table class="table table-fixed">
                        <thead>
                        <tr>
                            <th class="w-50">{{__('Fields')}}</th>
                            <th>{{__('Type')}}</th>
                            <th>{{__('Require an answer')}}</th>
                            <th>{{__('Actions')}}</th>
                        </tr>
                        </thead>
                        @foreach($jobFields as $jobField)
                            <tbody>
                                <tr>
                                    <td class="w-50">
                                        <div class="d-inline-flex align-items-center">
                                            <div>
                                                <label class="custom-control d-inline border-switch mb-0 mr-3">
                                                    <input type="checkbox" name="field_show" id="field-name-{{$jobField->id}}" class="border-switch-control-input update-field" value="{{($jobField->status == 1) ? 1 : 0 }}" {{($jobField->status == 1) ? 'checked' : '' }} data-field-id="{{$jobField->id}}" data-type="status">
                                                    <span class="border-switch-control-indicator"></span>
                                                </label>
                                            </div>
                                            <label for="field-name-0" class="mb-0">
                                                {{__($jobField->label)}}
                                            </label>
                                        </div>
                                    </td>
                                    <td>
                                        <p class="mb-0 text-capitalize">
                                            {{__($jobField->type)}}
                                        </p>
                                    </td>
                                    <td>
                                        <div>
                                            <div class="customized-checkbox checkbox-default">
                                                <input type="checkbox" name="field_require" id="field-require-{{$jobField->id}}" class="border-switch-control-input update-field" value="{{($jobField->is_required == 1) ? 1 : 0 }}" {{$jobField->is_required==1?'checked':''}} data-field-id="{{$jobField->id}}" data-type="is_required" {{($jobField->is_required == 1) ? 'checked' : '' }}>
                                                <label for="field-require-{{$jobField->id}}" class="">
                                                    {{__(($jobField->is_required==1)?"True":"False")}}
                                                </label>
                                            </div>
                                        </div>
                                    </td>
                                    <td>
                                        @if($jobField->is_deletable == true)
                                            <div class="d-inline-flex align-items-center">
                                                <a href="javascript:void(0)" class="text-muted default-base-color width-30 height-30 rounded d-inline-flex align-items-center justify-content-center mr-2 edit-form-field" data-field-id="{{$jobField->id}}" data-parent-id="{{$jobFormEntity->id}}" data-job-id="{{$job_id}}">
                                                    <i class="fas fa-edit"></i>
                                                </a>
                                                <a href="javascript:void(0)" class="text-muted default-base-color width-30 height-30 rounded d-inline-flex align-items-center justify-content-center delete_record_model" data-url="{{ route('delete.form.field', $jobField->id) }} " data-field-id="{{$jobField->id}}" data-parent-id="{{$jobFormEntity->id}}">
                                                    <i class="far fa-trash-alt"></i>
                                                </a>
                                            </div>
                                        @endif
                                    </td>
                                </tr>
                            </tbody>
                        @endforeach
                    </table>
                </div>
                @if($jobFormEntity->is_addable == 1)
                <button type="button" class="btn primary-text-color d-inline-flex align-items-center px-0 add-more-fields" data-parent-id="{{$jobFormEntity->id}}" data-job-id="{{$job_id}}">
                    <i class="fa fa-plus" aria-hidden="true"></i>&nbsp;
                    Add more fields
                </button>
                @endif
            </form>
        </div>
@endif


