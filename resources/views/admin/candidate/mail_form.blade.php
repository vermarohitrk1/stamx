<form action="" id="candidate-mail">
    <div class="modal-body">
        @csrf
        <input type="hidden" name="candidate_id" class="form-control" id="candidate_id" placeholder="" value="{{ $candidateId }}" >
        <input type="hidden" name="jobpost_id" class="form-control" id="jobpost_id" placeholder="" value="{{ $jobpost_id }}">
        <div class="form-group">
            <input type="text" name="subject" class="form-control" id="subject" placeholder="Subject">
        </div>
        <span id="subject-error" style="font-size: smaller; color: red"></span>
        <div class="summary-ckeditor" style=" display: block">
            <div class="form-group">
                <div class="row">
                    <div class="col-md-12">
                        <label class="form-control-label"></label>
                        <textarea id="mail-content"  class="form-control editor1"  name="mail-content" placeholder="Notes....." rows="10" minlength="30" maxlength="500" required="" ></textarea>
                    </div>
                </div>
            </div>
            <span id="content-error" style="font-size: smaller; color: red"></span>
        </div>
    </div>
    <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
        <button type="button" class="btn btn-primary" id="mail-send">Send</button>
    </div>
</form>
