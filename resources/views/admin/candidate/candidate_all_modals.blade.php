<!-- Candidate Details Modal -->
<div class="modal fade" aria-hidden="true" role="dialog" id="candidate-details-modal" style="padding-right: 0px !important; ">
    <div class="modal-dialog modal-dialog-top modal-xl modal-dialog-scrollable popup_mt" role="document">
        <div class="modal-content" style="margin-top: inherit !important;">
            <div class="modal-body"></div>
        </div>
    </div>
</div>
<!-- /Candidate Details Modal -->

<!-- Candidate Event Modal -->
<div class="modal fade" aria-hidden="true" role="dialog" id="candidate-event-modal" style="padding-right: 0px !important; display: none">
    <div class="modal-dialog modal-dialog-top modal-lg popup_mt_lg" role="document">
        <div class="modal-content" style="margin-top: inherit !important;">
            <div class="modal-header">
                <h5 class="modal-title"></h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="event-modal-body"></div>
        </div>
    </div>
</div>
<!-- /Candidate Event Modal -->

<!-- Candidate EventDetails Modal-->
<div data-backdrop="true" data-keyboard="true" id="event-view-modal" tabindex="-1" role="dialog" class="modal fade custom-scrollbar show" style=" display:none;" aria-modal="true">
    <div role="document" class="modal-dialog modal-dialog-top modal-default modal-dialog-scrollable popup_mt">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title text-capitalize"></h5>
                <button type="button" data-dismiss="modal" aria-label="Close" class="close outline-none">
                <span>
                   <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-x">
                      <line x1="18" y1="6" x2="6" y2="18"></line>
                      <line x1="6" y1="6" x2="18" y2="18"></line>
                   </svg>
                </span>
                </button>
            </div>
            <div class="modal-body custom-scrollbar event-detail">

            </div>
            <div class="modal-footer">
                <div class="">
                    <button type="button" data-dismiss="modal" class="btn btn-secondary mr-2">
                        Close
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Disqualify Modal -->
<div class="modal fade" id="disqualifyModal" tabindex="-1" role="dialog" aria-labelledby="disqualifyModal" aria-hidden="true" style="display: none">
    <div class="modal-dialog " role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Disqualify Candidate</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="disqualifyModal-body">

            </div>
        </div>
    </div>
</div>


<!-- Mail Modal -->
<div class="modal fade mt-5" id="mailModal" tabindex="-1" role="dialog" aria-labelledby="mailModal" aria-hidden="true" style="display: none">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="mailModalTitle"></h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="mail-modal-body">

            </div>
        </div>
    </div>
</div>
