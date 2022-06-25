@if(!empty($jobFormEntity->jobFormField))
    <form data-url="" class="mb-0">
        <div class="mb-4">
            <div class="note note-warning p-4">
                <p class="m-1">View only: You can not modify basic information setting.</p>
            </div>
        </div>
        <div class="table-responsive mb-2">
            <table class="table table-fixed">
                <thead>
                    <tr>
                        <th class="w-50">{{__('Fields')}}</th>
                        <th>{{__('Type')}}</th>
                        <th>{{__('Require an answer')}}</th>
                    </tr>
                </thead>
                @foreach($jobFormEntity->jobFormField as $jobField)
                    <tbody>
                    <tr>
                        <td class="w-50">
                            <div class="d-inline-flex align-items-center">
                                <div>
                                    <label class="custom-control d-inline border-switch mb-0 mr-3 disabled">
                                        <input type="checkbox" name="field_show" id="field-name-0" disabled="disabled" class="border-switch-control-input" value="true" {{($jobField->status==1?'checked':'')}}>
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
                                    <input type="checkbox" name="field_require" id="field-require-0" disabled="disabled" value="true" {{($jobField->is_required==1?'checked':'')}}>
                                    <label for="field-require-0" class="">
                                        {{__($jobField->is_required==1 ? 'True' : 'False')}}
                                    </label>
                                </div>
                            </div>
                        </td>
                    </tr>
                    </tbody>
                @endforeach
            </table>
        </div>
    </form>
@endif
