<?php
    /**
     * @var App\JobFormEntity $jobFormSection[];
     */
?>
<?php $page = "Recommend Form"; ?>
@section('title')
    {{$page??''}}
@endsection

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
  <body class="call-page">
                <form id="candidate-job-from" enctype="multipart/form-data">
                    
                    @csrf
                    <div class="row mt-3 p-2 " style="margin-right: 10% !important;margin-left: 10% !important" id="blog_view">
                        

     <div class="col-12">
        <div class="card">
        <div class="card-header">
            <h4>Recommend Entity Form</h4>
        </div>
            
                  
            <div class="card-body p-3">
 <input class="form-control" type="hidden" value="{{!empty($institution->id) ? encrypted_key($institution->id, "encrypt"):''}}" name="id">
    <div class="form-group">
        <label>Entity Title</label>
        <input class="form-control" type="text" value="{{ $institution->institution??'' }}" name="institution" id="Institution" required="">
        <input class="form-control" type="hidden" value="1" name="recommended" required="">
   </div>   
   
    <div class="form-group">
                <label class="form-control-label">Entity Type</label>
                <select id="type" class="form-control" name="type" @if(!empty($institution->type) && empty($institution->id)) readonly @endif>
                  
                    <option @if(!empty($institution->type) && $institution->type ==  "School") selected @endif value="School" > School</option>
                    <option  @if(!empty($institution->type) && $institution->type ==  "College") selected @endif value="College"> College</option>
                    <option @if(!empty($institution->type) && $institution->type ==  "Library") selected @endif value="Library"> Library</option>
                    <option @if(!empty($institution->type) && $institution->type ==  "Company") selected @endif value="Company"> Company</option>
                    <option @if(!empty($institution->type) && $institution->type ==  "PHA Community") selected @endif value="PHA Community"> PHA Community</option>
                    <option @if(!empty($institution->type) && $institution->type ==  "Mayor") selected @endif value="Mayor"> Mayor</option>
                    <option @if(!empty($institution->type) && $institution->type ==  "Justice Involved Officer") selected @endif value="Justice Involved Officer"> Justice Involved Officer</option>
                    <option @if(!empty($institution->type) && $institution->type ==  "Military Base") selected @endif value="Military Base"> Military Base</option>
             </select>
            </div>
    
                                             <div class="form-group">
                                                <label>Address (Search to fill address fields)</label>
                                                <input type="text" id="address" name="address" maxlength="250" class="form-control" value="{{ $institution->address??'' }}" required="" >
                                             </div>
                                       
                                          <!-- <div class="col-12 col-md-6">
                                             <div class="form-group">
                                                 <label>Address Line 2</label>
                                                 <input type="text" name="address2" maxlength="250" class="form-control" value="">
                                             </div>
                                             </div> -->
                                          <div class="row">
                                          <div class="col-12 col-md-6">
                                             <div class="form-group">
                                                <label>City</label>
                                                <input type="text" readonly="" id="address_city" name="city" maxlength="40"  class="form-control" value="{{ $institution->city??'' }}">
                                             </div>
                                          </div>
                                          <div class="col-12 col-md-6">
                                             <div class="form-group">
                                                <label>State</label>
                                                <input type="text" readonly="" name="state" id="address_state" maxlength="40"  class="form-control" value="{{ $institution->state??'' }}">
                                             </div>
                                          </div>
                                          <div class="col-12 col-md-6">
                                             <div class="form-group">
                                                <label>Zip Code</label>
                                                <input type="number" readonly="" id="address_zip_code" class="form-control" step="1" min="0" name="postal_code" value="{{ $institution->zip??'' }}">
                                             </div>
                                          </div>
                                          <div class="col-12 col-md-6">
                                             <div class="form-group">
                                                <label>Country</label>
                                                <input type="text" class="form-control" id="country" maxlength="40"  name="country" value="{{ $institution->country??'' }}" readonly="">
                                             </div>
                                          </div>
                                          <div class="col-12 col-md-6">
                                             <div class="form-group">
                                                <label>Address Lat</label>
                                                <input type="text" class="form-control" id="address_lat" maxlength="40"  name="address_lat" value="{{ $institution->lat??'' }}" readonly="">
                                             </div>
                                          </div>
                                          <div class="col-12 col-md-6">
                                             <div class="form-group">
                                                <label>Address Long</label>
                                                <input type="text" class="form-control" id="address_long" maxlength="40"  name="address_long" value="{{ $institution->long??'' }}" readonly="">
                                             </div>
                                          </div>
                                          </div>
                                          @if(Auth::user()->type=="admin")
           <div class="form-group">
                <label class="form-control-label">Status</label>
                <select id="status" class="form-control" name="status">
                    <option  value="0" @if(!empty($institution->id) && $institution->status == null ) selected @endif> Pending</option>
                    <option value="1" @if(!empty($institution->id) &&  $institution->status == 1 ) selected @endif> Accepted</option>
                    <option value="2" @if(!empty($institution->id) &&  $institution->status == 2 ) selected @endif> Rejected</option>
             </select>
            </div>
                                          @endif

    <div class="mt-4 float-right">
         <button type="button" class="btn btn-primary   shadow-none form-submit">
                                            <span>
                                                Recommend
                                            </span>
                                        </button>
        <!--<button class="btn btn-primary" name="form_submit" value="submit" type="submit">Recommend</button>-->
    </div>

            </div>
        </div>
    </div>





            </div>
                </form>
  </body>
         


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
       // console.log(candidateFormData);
       if($("#Institution").val() !=null && $("#Institution").val() !=''){
        $.ajax({
            type:"POST",
            url:'{{route('institution.post')}}',
            data: candidateFormData,
            cache: false,
            contentType: false,
            processData: false,
            success:function(response){
                if(response.success == true){
                    {{--top.location.href = "{{ url('/') }}";--}}
                    show_toastr('Success : ', response.message, 'success');
                    setTimeout(function() {
                         window.top.close();
                    }, 1000);
                }else{
                    show_toastr('Error: ', response.message, 'error');
                }
            },
            error:function(error){
                show_toastr('Error: ', error, 'error');
            }
        });
        }else{
        show_toastr('Error: ', 'empty form', 'error');
                    }
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
                placement: {from: "top", align: "right"},
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

<script
   src="https://maps.googleapis.com/maps/api/js?key=AIzaSyCRm6AkA1BWf6Scex-ZqIHMptuN3A4_loQ&callback=initAutocomplete&libraries=places"
   async
   ></script>

<script type="text/javascript">
   let autocomplete;
   let address1Field;
   let address2Field;
   let address11Field;
   let address22Field;

   let corporateautocomplete;
   let corporateaddress1Field;
   let corporateaddress2Field;
   let corporateaddress11Field;
   let corporateaddress22Field;

   function initAutocomplete() {
     address1Field = document.querySelector("#address");
     address2Field = document.querySelector("#address_street");



     // Create the autocomplete object, restricting the search predictions to
     // addresses in the US and Canada.
     autocomplete = new google.maps.places.Autocomplete(address1Field, {
       componentRestrictions: { country: ["us"] },
       fields: ["address_components", "geometry"],
       types: ["address"],
     });
    address1Field.focus();

  

     // When the user selects an address from the drop-down, populate the
     // address fields in the form.
     autocomplete.addListener("place_changed", fillInAddress);
   }

   function fillInAddress() {
     // Get the place details from the autocomplete object.

     document.querySelector("#address_lat").value =autocomplete.getPlace().geometry.location.lat();
     document.querySelector("#address_long").value =autocomplete.getPlace().geometry.location.lng();
     const place = autocomplete.getPlace();
     let address1 = "";
     let address11 = "";

     for (const component of place.address_components) {
       const componentType = component.types[0];

       switch (componentType) {
         case "street_number": {
           address1 = `${component.long_name} ${address1}`;
           break;
         }
         case "route": {
           address1 += component.short_name;
           break;
         }
         case "locality":
           document.querySelector("#address_city").value = component.long_name;
           break;
         case "administrative_area_level_1": {
           document.querySelector("#address_state").value = component.long_name;
           break;

         }
         case "postal_code": {
           document.querySelector("#address_zip_code").value = component.short_name;
           break;
       }
         case "country": {
           document.querySelector("#country").value = component.short_name;
           break;
         }
       }
     }
    // address2Field.value = address1;
   }
   

</script>