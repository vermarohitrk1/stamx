<?php
    /**
     * @var App\JobFormEntity $jobFormSection[];
     */
?>
<head>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/js/bootstrap.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/js/bootstrap.bundle.min.js"></script>
    <style type="text/css">
        .h-100 { height: 100%!important; }
        .w-100 { width: 100%!important; }
        .candidate-application-form { align-items: stretch; display: flex; height: 100%; width: 100%; }
        .candidate-application-form .candidate-step-menu { background-image: linear-gradient(to left top,#fcfdff,#f9fbff,#f6f9ff,#f3f8ff,#eff6ff); height: 100%; overflow-y: auto; padding: 2rem; position: fixed; transition: all .3s ease-in-out; width: 30rem; z-index: 1; }
        .candidate-application-form .candidate-step-menu .toggle-sidebar { background-color: rgba(246,249,255,.8); border-radius: 0 10px 10px 0; cursor: pointer; display: none; padding: 10px; position: absolute; right: -40px; top: 8px; }
        .candidate-application-form .candidate-step-menu .toggle-sidebar .bar1, .candidate-application-form .candidate-step-menu .toggle-sidebar .bar2, .candidate-application-form .candidate-step-menu .toggle-sidebar .bar3 { background-color: #99c5ff; border-radius: 1px; height: 2px; margin: 3px 0; transition: .4s; width: 20px; }
        .flex-column { flex-direction: column!important; }
        .nav { display: flex; flex-wrap: wrap; list-style: none; margin-bottom: 0; padding-left: 0; }
        .candidate-application-form .candidate-step-menu .nav .nav-link.active { background-color: transparent; }
        .candidate-application-form .candidate-step-menu .nav .nav-link { align-items: center; display: inline-flex; padding: 1rem; transition: all .35s ease-in-out; }
        .nav-pills .nav-link.active, .nav-pills .show>.nav-link { background-color: #4466f2; color: #fff; }
        .candidate-application-form .candidate-step-menu .nav .nav-link { align-items: center; display: inline-flex; padding: 1rem; transition: all .35s ease-in-out; }
        a:not([href]):not([tabindex]), a:not([href]):not([tabindex]):focus, a:not([href]):not([tabindex]):hover { color: inherit; text-decoration: none; }
        .candidate-application-form .candidate-step-menu .nav .nav-link.complete .step-number { border-color: #46c35f; color: #46c35f; }
        .candidate-application-form .candidate-step-menu .nav .nav-link:hover .step-number { border-color: #313131; color: #313131; }
        .candidate-application-form .candidate-step-menu .nav .nav-link .step-name { color: #afb1b6; transition: all .35s ease-in-out; }
        .candidate-application-form .candidate-step-menu .nav .nav-link.active .step-name { color: #313131; }
        .candidate-application-form .candidate-step-menu .nav .nav-link:hover .step-name { color: #313131; }
        .candidate-application-form .candidate-step-menu .nav .nav-link.active .step-number { border-color: #313131; color: #313131; }
        .candidate-application-form .candidate-step-menu .nav .nav-link .step-number { align-items: center; border: 2px solid #afb1b6; border-radius: 50%; color: #afb1b6; display: inline-flex; flex-shrink: 0; font-size: 15px; height: 40px; justify-content: center; margin-right: 10px; position: relative; transition: all .35s ease-in-out; width: 40px; }
        .candidate-application-form .candidate-step-menu .nav .nav-link .step-number .step-divider .divider { border-bottom: 2px dotted #afb1b6; -webkit-transform: rotate( 90deg); transform: rotate( 90deg); width: 29px; }
        .candidate-application-form .candidate-step-menu .nav .nav-link .step-number .complete-icon { align-items: center; background-color: #46c35f; border-radius: 50%; color: #fff; display: inline-flex; height: 16px; justify-content: center; position: absolute; right: -5px; top: -4px; width: 16px; }
        .candidate-application-form .candidate-step-menu .nav .nav-link .step-number .complete-icon svg { stroke-width: 2; height: 12px; width: 12px; }
        .candidate-application-form .candidate-step-menu .nav .nav-link .step-number .step-divider { display: flex; left: 50%; position: absolute; top: 52px; -webkit-transform: translateX(-50%); transform: translateX(-50%); }
        .candidate-application-form .candidate-step-menu .nav .nav-link .step-number .step-divider .divider { border-bottom: 2px dotted #afb1b6; -webkit-transform: rotate( 90deg); transform: rotate( 90deg); width: 29px; }
        .candidate-application-form .candidate-step-menu .nav .nav-link:last-child .step-number .step-divider { display: none; }

        .candidate-application-form .candidate-step-content { flex-grow: 1; margin-left: 30rem; min-height: 100%; transition: all .3s ease-in-out; width: 100%; }
        .candidate-application-form .candidate-step-content .tab-content { padding: 3.5rem; }
        .tab-content>.active { display: block; }
        /*.tab-content>.tab-pane { display: none; }*/
        .fade { transition: opacity .15s linear; }
        .fade:not(.show) { opacity: 0; }
        .row { display: flex; flex-wrap: wrap; margin-left: -15px; margin-right: -15px; }
        .candidate-application-form .candidate-step-content .tab-content .tab-pane .tab-pane-action { align-items: center; display: flex; justify-content: space-between; }
        .candidate-application-form .candidate-step-content .tab-content .tab-pane .tab-pane-action button { align-items: center; background-color: #fbfcff; border: 1px solid #e2e9ff; border-radius: 20px; color: #9397a0; display: inline-flex; justify-content: space-between; padding: .45rem 1rem; transition: .25s; }
        .candidate-application-form .candidate-step-content .tab-content .tab-pane .tab-pane-action button svg { height: 13px; width: 13px; }

        .vue-tel-input{border-radius:3px;display:flex;border:1px solid #bbb;text-align:left}.vue-tel-input.disabled .dropdown,.vue-tel-input.disabled .selection,.vue-tel-input.disabled input{cursor:no-drop}.vue-tel-input:focus-within{box-shadow:inset 0 1px 1px rgba(0,0,0,.075),0 0 8px rgba(102,175,233,.6);border-color:#66afe9}.vti__dropdown{display:flex;flex-direction:column;align-content:center;justify-content:center;position:relative;padding:7px;cursor:pointer}.vti__dropdown.show{max-height:300px;overflow:scroll}.vti__dropdown.open{background-color:#f3f3f3}.vti__dropdown:hover{background-color:#f3f3f3}.vti__selection{font-size:.8em;display:flex;align-items:center}.vti__selection .vti__country-code{color:#666}.vti__flag{margin-right:5px;margin-left:5px}.vti__dropdown-list{z-index:1;padding:0;margin:0;text-align:left;list-style:none;max-height:200px;overflow-y:scroll;position:absolute;left:-1px;background-color:#fff;border:1px solid #ccc;width:390px}.vti__dropdown-list.below{top:33px}.vti__dropdown-list.above{top:auto;bottom:100%}.vti__dropdown-arrow{transform:scaleY(.5);display:inline-block;color:#666}.vti__dropdown-item{cursor:pointer;padding:4px 15px}.vti__dropdown-item.highlighted{background-color:#f3f3f3}.vti__dropdown-item.last-preferred{border-bottom:1px solid #cacaca}.vti__dropdown-item .vti__flag{display:inline-block;margin-right:5px}.vti__input{border:none;border-radius:0 2px 2px 0;width:100%;outline:0;padding-left:7px}
        .dropzone.dz-clickable { cursor: pointer; }
        .dropzone { background: #fff; border: 1px dashed #4466f2!important; border-radius: .25rem!important; min-height: 150px!important; padding: 20px!important; }
        .dropzone.dz-clickable .dz-message, .dropzone.dz-clickable .dz-message * { cursor: pointer; }
        .dropzone .dz-message { margin: 2em 0; text-align: center; }
        .dropzone svg { height: 80px; width: 80px; }
        .customized-radio { cursor: pointer; display: inline-block; margin: 0 1rem 0 0; padding-left: 30px; position: relative; }
        .customized-radio { padding: 0px !important; }

    </style>
</head>

<div id="app" class="w-100 h-100">
    <div>
        <div class="candidate-application-form">
            <div class="candidate-step-menu custom-scrollbar">
                <div class="toggle-sidebar">
                    <div class="bar1"></div>
                    <div class="bar2"></div>
                    <div class="bar3"></div>
                </div>
                <div id="v-pills-tab" role="tablist" aria-orientation="vertical" class="nav flex-column nav-pills">
                    @if(!empty($jobFormSection))
                        <?php $count = 1 ?>
                        @foreach($jobFormSection as $key => $_jobFormSection)
                            <a id="{{ makeSlug($_jobFormSection->label) }}-tab" class="nav-link @if($key == 0) active @endif {{ $_jobFormSection->slug }}"><span class="step-number">
                        {{ $count }}
                                    <span class="complete-icon" style="display: none"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-check"><polyline points="20 6 9 17 4 12"></polyline></svg></span>
                            <span class="step-divider"><span class="divider"></span></span></span> <span class="step-name">{{ $_jobFormSection->label }}</span>
                            </a>
                        <?php $count++ ?>
                        @endforeach
                    @endif
                    <a id="v-pills-submit-tab" class="nav-link"><span class="step-number">
                        {{ $count }}
                           <span class="step-divider"><span class="divider"></span></span></span> <span class="step-name">Submit Application</span></a>
                </div>
            </div>
            <div class="candidate-step-content">
                <form id="candidate-job-from" enctype="multipart/form-data">
                    @csrf
                    <input type="hidden" name="job_id" value="{{ $job_id }}">
                    <div id="v-pills-tabContent" class="tab-content">
                            @if(!empty($jobFormSection))
                                @foreach($jobFormSection as $key => $_jobFormSection)
                                        <div id="{{ makeSlug($_jobFormSection->label) }}" class="tab-pane fade @if($key == 0) show active @endif" data-class="{{ $_jobFormSection->slug }}">
                                            <div class="row">
                                                <div class="col-lg-9 col-xl-7">
                                                    <div>
                                                        <h4 class="mb-2">
                                                            {{ $_jobFormSection->label }}
                                                        </h4>
                                                        @if(!empty(count($_jobFormSection->jobFormField) == 0))
                                                            <div class="row mb-4">
                                                                <div class="col-12">
                                                                    <span>{{__("No Fields available")}}</span>
                                                                </div>
                                                            </div>
                                                        @else
                                                            @foreach($_jobFormSection->jobFormField as $jobFields)
                                                                @if($jobFields->type == "textarea")
                                                                    <div class="row mb-4">
                                                                        <div class="col-12">
                                                                            <label for="address">{{ $jobFields->label }} @if($jobFields->is_required == 1) <sup style="color:red;">*</sup> @endif</label>
                                                                            <div class="form-group">
                                                                                <textarea type="{{ $jobFields->type }}" id="{{ makeSlug($jobFields->label) }}" name="candidate[{{ $_jobFormSection->id }}][{{ $jobFields->id }}]" placeholder="" spellcheck="false" class="form-control" data-error-class="error_{{$jobFields->id}}" @if($jobFields->is_required == 1) required @endif></textarea>
                                                                            </div>
                                                                            <span class="error_{{$jobFields->id}}" style="font-size: smaller; color: red"></span>
                                                                        </div>
                                                                    </div>
                                                                @elseif($jobFields->type == "radio")
                                                                    <div class="row mb-4">
                                                                        <div class="col-12">
                                                                            <label for="gender">{{ $jobFields->label }} @if($jobFields->is_required == 1) <sup style="color:red;">*</sup> @endif</label>
                                                                            <div>
                                                                                <div class="app-radio-group">
                                                                                    @if($jobFields->jobFormOption()->exists())
                                                                                        @foreach($jobFields->jobFormOption as $options)
                                                                                            <label class="customized-radio radio-default custom-radio-default">
                                                                                                <input type="{{ $jobFields->type }}" name="candidate[{{ $_jobFormSection->id }}][{{ $jobFields->id }}]" id="{{ makeSlug($jobFields->label) }}" @if($jobFields->is_required == 1) required @endif class="radio-inline" value="{{ $options->label }}" data-error-class="error_{{$jobFields->id}}"> <span class="outside"><span class="inside"></span></span>
                                                                                                {{ formlabel($options->label) }}
                                                                                            </label>
                                                                                        @endforeach
                                                                                    @endif
                                                                                </div>
                                                                            </div>
                                                                            <span class="error_{{$jobFields->id}}" style="font-size: smaller; color: red"></span>
                                                                        </div>
                                                                    </div>
                                                                @elseif($jobFields->type == "select")
                                                                    <div class="row mb-4">
                                                                        <div class="col-12">
                                                                            <label for="{{ makeSlug($jobFields->label) }}">{{ formlabel($jobFields->label) }} @if($jobFields->is_required == 1) <sup style="color:red;">*</sup> @endif</label>
                                                                            <div>
                                                                                <select id="{{ makeSlug($jobFields->label) }}" class="custom-select" name="candidate[{{ $_jobFormSection->id }}][{{ $jobFields->id }}]" data-error-class="error_{{$jobFields->id}}" @if($jobFields->is_required == 1) required @endif>
                                                                                    @if($jobFields->jobFormOption()->exists())
                                                                                        <option value="">Select One</option>
                                                                                        @foreach($jobFields->jobFormOption as $options)
                                                                                            <option value="{{ strtolower($options->label) }}">
                                                                                                {{ formlabel($options->label) }}
                                                                                            </option>
                                                                                        @endforeach
                                                                                    @endif
                                                                                </select>
                                                                            </div>
                                                                            <span class="error_{{$jobFields->id}}" style="font-size: smaller; color: red"></span>
                                                                        </div>
                                                                    </div>
                                                                @elseif($jobFields->type == "checkbox")
                                                                    <div class="row mb-4">
                                                                        <div class="col-12">
                                                                            <label for="{{ makeSlug($jobFields->label) }}">{{ formlabel($jobFields->label) }} @if($jobFields->is_required == 1) <sup style="color:red;">*</sup> @endif</label>
                                                                            <div>
                                                                                <div class="app-checkbox-group">
                                                                                    @if($jobFields->jobFormOption()->exists())
                                                                                        @foreach($jobFields->jobFormOption as $options)
                                                                                            <div class="customized-checkbox checkbox-default">
                                                                                                <input type="{{ $jobFields->type }}" name="candidate[{{ $_jobFormSection->id }}][{{ $jobFields->id }}]" id="{{ makeSlug($options->label) }}" @if($jobFields->is_required == 1) required @endif placeholder="" value="{{ $options->label }}" data-error-class="error_{{$jobFields->id}}" class="checkbox_{{$jobFields->id}}">
                                                                                                <label for="{{ makeSlug($options->label) }}" class="">
                                                                                                    {{ formlabel($options->label) }}
                                                                                                </label>
                                                                                            </div>
                                                                                        @endforeach
                                                                                    @endif
                                                                                </div>
                                                                            </div>
                                                                            <span class="error_{{$jobFields->id}}" style="font-size: smaller; color: red"></span>
                                                                        </div>
                                                                    </div>
                                                                @else
                                                                    <div class="row mb-4">
                                                                        <div class="col-12">
                                                                            <label for="{{ makeSlug($jobFields->label) }}">{{ $jobFields->label }} @if($jobFields->is_required == 1) <sup style="color:red;">*</sup> @endif</label>
                                                                            <div>
                                                                                <input  type="{{ $jobFields->type }}" @if($jobFields->type=="file") accept=".pdf, .docx, .doc" @endif name="candidate[{{ $_jobFormSection->id }}][{{ $jobFields->id }}]" id="{{ makeSlug($jobFields->label) }}" @if($jobFields->is_required == 1) required @endif placeholder="" autocomplete="off" class="form-control" data-error-class="error_{{$jobFields->id}}">
                                                                            </div>
                                                                            <span class="error_{{$jobFields->id}}" style="font-size: smaller; color: red"></span>
                                                                        </div>
                                                                    </div>
                                                                @endif
                                                            @endforeach
                                                        @endif
                                                    </div>
                                                    <div class="tab-pane-action @if($key == 0) d-flex justify-content-end @endif">
                                                        @if($key != 0)
                                                            <button type="button" class="prev">
                                                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-chevron-left mr-2">
                                                                    <polyline points="15 18 9 12 15 6"></polyline>
                                                                </svg>
                                                                Previous
                                                            </button>
                                                        @endif
                                                        <button type="button" class="next">
                                                            Next
                                                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-chevron-right ml-2">
                                                                <polyline points="9 18 15 12 9 6"></polyline>
                                                            </svg>
                                                        </button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                @endforeach
                            @endif
                            <div id="v-pills-submit" class="tab-pane fade ">
                            <div class="row">
                                <div class="col-lg-9 col-xl-7">
                                    <div class="form-preview">
{{--                                        <h4 class="mb-2">--}}
{{--                                            Submit Application - In progress...--}}
{{--                                        </h4>--}}
{{--                                        <div class="row mb-4">--}}
{{--                                            <div class="col-12 min-height-300 py-primary">--}}
{{--                                                <h5 class="mb-3">Basic Information</h5>--}}
{{--                                                <table class="table table-borderless shadow font-size-90">--}}
{{--                                                    <tbody>--}}
{{--                                                    <tr>--}}
{{--                                                        <td class="text-muted width-150">First name</td>--}}
{{--                                                        <td>John</td>--}}
{{--                                                    </tr>--}}
{{--                                                    <tr>--}}
{{--                                                        <td class="text-muted width-150">Last name</td>--}}
{{--                                                        <td>Doe</td>--}}
{{--                                                    </tr>--}}
{{--                                                    <tr>--}}
{{--                                                        <td class="text-muted width-150">Email</td>--}}
{{--                                                        <td>johndoe@nomail.com</td>--}}
{{--                                                    </tr>--}}
{{--                                                    <tr>--}}
{{--                                                        <td class="text-muted width-150">Gender</td>--}}
{{--                                                        <td class="text-capitalize">Male</td>--}}
{{--                                                    </tr>--}}
{{--                                                    <!---->--}}
{{--                                                    </tbody>--}}
{{--                                                </table>--}}
{{--                                                <h5 class="mt-3">Others information</h5>--}}
{{--                                                <div class="card border-0 shadow mt-3 p-2">--}}
{{--                                                    <p class="mb-0">Phone</p>--}}
{{--                                                    <p class="mb-0 text-muted">+1234567890</p>--}}
{{--                                                </div>--}}
{{--                                                <div class="card border-0 shadow mt-3 p-2">--}}
{{--                                                    <p class="mb-0">Write something about you...</p>--}}
{{--                                                    <p class="mb-0 text-muted">I believe in myself.</p>--}}
{{--                                                </div>--}}
{{--                                                <div class="card border-0 shadow mt-3 p-2">--}}
{{--                                                    <p class="mb-0">Write your assignment question</p>--}}
{{--                                                    <p class="mb-0 text-muted">How do you write about yourself?</p>--}}
{{--                                                </div>--}}
{{--                                            </div>--}}
{{--                                        </div>--}}
                                    </div>
                                    <div class="tab-pane-action">
                                        <button type="button" class="prev">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-chevron-left mr-2">
                                                <polyline points="15 18 9 12 15 6"></polyline>
                                            </svg>
                                            Previous
                                        </button>
                                        <button type="button" class="btn  shadow-none form-submit">
                                            <span>
                                                Submit
                                            </span>
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
<script src="https://www.jquery-az.com/jquery/js/intlTelInput/intlTelInput.js"></script>

{{--<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>--}}
{{--<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"></script>--}}
{{--<script type="text/javascript" src="{{ asset('assets/main/js/slick.min.js')}}"></script>--}}
{{--<script type="text/javascript" src="{{ asset('assets/main/js/custom_script.js')}}"></script>--}}
{{--<!--toastr for notification-->--}}
<script src="{{ asset('assets/libs/bootstrap-notify/bootstrap-notify.min.js') }}"></script>

<script type="text/javascript">
    $(".next").click(function(){
        var error = false;
        var validate = true;
        $('.show.active input').each(function (index, value) {
            var inputType = value.type;
            var inputValue = value.value;
            if(inputType == 'text') {
                var required = $(this).attr('required');
                var errorClass = $(this).attr('data-error-class');
                if(required == 'required' && inputValue == "" ){
                    $('.'+errorClass).text("This field is required.");
                    error = true;
                }else{
                    $('.'+errorClass).text("");
                }
            }
            if(inputType == 'email'){
                var required = $(this).attr('required');
                var errorClass = $(this).attr('data-error-class');
                var email = $(this).val();
                if(required == 'required' && inputValue == "" ){
                    $('.'+errorClass).text("This field is required.");
                    error = true;
                }else if(email != ""){
                    var emailReg = /^([\w-\.]+@([\w-]+\.)+[\w-]{2,4})?$/;
                    if(!emailReg.test(email)) {
                        $('.'+errorClass).text("Please enter valid email id");
                        error = true;
                    }
                    else{
                        $('.'+errorClass).text("");
                    }
                }
                else{
                    $('.'+errorClass).text("");
                }
            }
            if(inputType == 'radio' ){
                var required = $(this).attr('required');
                var errorClass = $(this).attr('data-error-class');
                if(required == 'required' && $('input[type='+ inputType + ']:checked').length == 0){
                    $('.'+errorClass).text("This field is required.");
                    error = true;
                }else{
                    $('.'+errorClass).text("");
                }
            }
            if(inputType == 'checkbox' ){
                var required = $(this).attr('required');
                var errorClass = $(this).attr('data-error-class');
                if(required == 'required' && $('input:checkbox:checked').length == 0 ){
                    $('.'+errorClass).text("This field is required.");
                    error = true;
                }else{
                    $('.'+errorClass).text("");
                }
            }
            if(inputType == 'date'){
                var required = $(this).attr('required');
                var errorClass = $(this).attr('data-error-class');
                if(required == 'required' && inputValue == ""){
                    $('.'+errorClass).text("This field is required.");
                    error = true;
                }else{
                    $('.'+errorClass).text("");
                }
            }
            if(inputType == 'number'){
                var required = $(this).attr('required');
                var errorClass = $(this).attr('data-error-class');
                if(required == 'required' && inputValue == ""){
                    $('.'+errorClass).text("This field is required.");
                    error = true;
                }else{
                    $('.'+errorClass).text("");
                }
            }

            if(inputType == 'file'){
                var required = $(this).attr('required');
                var errorClass = $(this).attr('data-error-class');
                if(required == 'required' && inputValue == ""){
                    $('.'+errorClass).text("This field is required.");
                    error = true;
                }else{
                    $('.'+errorClass).text("");

                }
            }

        });
        $('.show.active select').each(function (index, value) {
            var required = $(this).attr('required');
            var errorClass = $(this).attr('data-error-class');
            if(required == 'required' && value.value == ""){
                $('.'+errorClass).text("This field is required.");
                error = true;
            }else{
                $('.'+errorClass).text("");

            }
        });
        $('.show.active textarea').each(function (index, value) {
            var required = $(this).attr('required');
            var errorClass = $(this).attr('data-error-class');
            if(required == 'required' && value.value == ""){
                $('.'+errorClass).text("This field is required.");
                error = true;
            }else{
                $('.'+errorClass).text("");

            }
        });
        if(error == false){
            $(this).parent().parent().parent().parent().removeClass('show active');
            $(this).parent().parent().parent().parent().next().addClass('show active');
            var activeTab = $(this).parent().parent().parent().parent().attr('data-class');
            $('.'+activeTab).addClass('complete');
            $('.'+activeTab).find('.complete-icon').show();
            $('.'+activeTab).removeClass('active');
            var nextTab =  $(this).parent().parent().parent().parent().next().attr('data-class');
            $('.'+nextTab).addClass('active');
        }
    });

    function getFileInputs(){
        var allFiles = [];
        $('form#candidate-job-from input').each(function (index, value){
            if(value.type == 'file'){
                var file_id = $(this).attr('id');
                var file_name = $(this).attr('name');
                var file_data = $(this).prop('files')[0];
                if(file_data!=undefined){
                    var eachFiles = {
                        "name": file_name,
                        "file": file_data,
                    };
                    allFiles.push(eachFiles);
                }
            }
        });
        return allFiles;
    }


    $(".prev").click(function(){
        $(this).parent().parent().parent().parent().removeClass('show active');
        $(this).parent().parent().parent().parent().prev().addClass('show active');
        var activeTab = $(this).parent().parent().parent().parent().attr('data-class');
        $('.'+activeTab).removeClass('active');
        var nextTab =  $(this).parent().parent().parent().parent().prev().attr('data-class');
        $('.'+nextTab).addClass('active');
        if($('#v-pills-submit-tab').hasClass('active')){
            $('#v-pills-submit-tab').removeClass('active');
        }
    });

    $(".next:last").click(function () {
        $('#v-pills-submit-tab').addClass('active');
        var candidateFormData = $('form#candidate-job-from').serialize();
        $.ajax({
            type:"GET",
            url:'{{route("jobpost.appform.preview")}}',
            data: candidateFormData,
            success:function(response){
                if(response.success == true){
                    $('.form-preview').html(response.html);

                }else{
                    show_toastr('Error: ', response.message, 'error');
                }
            },
            error:function(error){
                show_toastr('Error: ', error, 'error');
            }
        });
    });

    // $(".vti__dropdown-list below").intlTelInput({
    // });

    $(document).on("click", ".form-submit", function () {
        var candidateFormData = new FormData($('form#candidate-job-from')[0]);
        //var candidateFormData = $('form#candidate-job-from').serialize();
        //var allFiles = getFileInputs();
        //candidateFormData.push({ name: "all_files", value: allFiles });
        console.log(candidateFormData);
        $.ajax({
            type:"POST",
            url:'{{route("jobpost.appform.save")}}',
            data: candidateFormData,
            cache: false,
            contentType: false,
            processData: false,
            success:function(response){
                if(response.success == true){
                    {{--top.location.href = "{{ url('/') }}";--}}
                    show_toastr('Success : ', response.message, 'success');
                    setTimeout(function() {
                        window.location.reload();
                    }, 4000);
                }else{
                    show_toastr('Error: ', response.message, 'error');
                }
            },
            error:function(error){
                show_toastr('Error: ', error, 'error');
            }
        });
    });

    function show_toastr(title, message, type) {
        var o, i;
        var icon = "";
        var cls = "";

        if (type == "success") {
            icon = "fas fa-check-circle";
            cls = "success";
        } else {
            icon = "fas fa-times-circle";
            cls = "danger";
        }

        $.notify(
            {icon: icon, title: " " + title, message: message, url: ""},
            {
                element: "body",
                type: cls,
                allow_dismiss: !0,
                showProgressbar: false,
                animate: {
                    enter: 'animated fadeInDown',
                    exit: 'animated fadeOutUp'
                },
                placement: {from: "bottom", align: "right"},
                offset: {x: 15, y: 15},
                spacing: 10,
                z_index: 1080,
                delay: 2500,
                timer: 2000,
                url_target: "_blank",
                mouse_over: !1,
                animate: {enter: o, exit: i},
                template:
                    '<div data-notify="container" class="col-xs-11 col-sm-3 alert alert-{0}" role="alert">' +
                    '<button type="button" aria-hidden="true" class="close" data-notify="dismiss">×</button>' +
                    '<span data-notify="icon"></span> ' +
                    '<span data-notify="title">{1}</span> ' +
                    '<span data-notify="message">{2}</span>' +
                    '<div class="progress progress progress-xs" data-notify="progressbar">' +
                    '<div class="progress-bar progress-bar w-75 progress-bar-{0}" role="progressbar" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100" style="width: 0%;"></div>' +
                    '</div>' +
                    '<a href="{3}" target="{4}" data-notify="url"></a>' +
                    '</div>',
            }
        );
    }

</script>
