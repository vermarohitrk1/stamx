<div class="row">
    <div class="col-md-12"><label for="scorm_provider">Select scorm provider</label></div>
    <div class="col-md-4  m-0">
        <div class="course-provider-logo cursor-pointer course-provider-logo-checked" onclick="checked_scorm_provider(this, 'ispring')">
            <img class="ispring" src="{{asset('assets/scorm/logo/ispring.png')}}">
        </div>
    </div>
    <div class="col-md-4  m-0">
        <div class="course-provider-logo cursor-pointer " onclick="checked_scorm_provider(this, 'articulate')">
            <img class="articulate" src="{{asset('assets/scorm/logo/articulate.png')}}">
        </div>
    </div>
    <div class="col-md-4  m-0">
        <div class="course-provider-logo cursor-pointer " onclick="checked_scorm_provider(this, 'adobe_captivate')">
            <img class="adobe_captivate" src="{{asset('assets/scorm/logo/adobe_captivate.png')}}">
        </div>
    </div>

    <div class="d-none">
        <div class="custom-control custom-radio">
            <input type="radio" id="ispring" value="ispring" name="scorm_provider" class="custom-control-input scorm-provider-radio" checked="">
            <label class="custom-control-label" for="ispring">Ispring</label>
        </div>
        <div class="custom-control custom-radio ml-2">
            <input type="radio" id="articulate" value="articulate" name="scorm_provider" class="custom-control-input scorm-provider-radio">
            <label class="custom-control-label" for="articulate">Articulate</label>
        </div>
        <div class="custom-control custom-radio ml-2">
            <input type="radio" id="adobe_captivate" value="adobe_captivate" name="scorm_provider" class="custom-control-input scorm-provider-radio">
            <label class="custom-control-label" for="adobe_captivate">Adobe captivate</label>
        </div>
    </div>
</div>
<div class="form-group">
    <div class="row">
        <label for="scorm_zip">Scorm zip</label>
        <div class="custom-file">
            <div class="custom-file">
                <input type="file" class="custom-file-input" name="content" id="scorm_zip" onchange="changeTitleOfImageUploader(this)" accept="application/zip">
                <label class="custom-file-label ellipsis" for="scorm_zip">Choose file</label>
            </div>
        </div>
    </div>
</div>
