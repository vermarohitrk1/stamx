<!-- Footer -->
<footer class="footer">



    <!-- Footer Bottom -->
    <div class="footer-bottom">
        <div class="container">

            <!-- Copyright -->
            <div class="copyright">
                <div class="row">
                    <div class="col-md-6 col-12">
                        <div class="copyright-text text-left">
                            <p>Terms - Privacy Policy & Safety - Send feedback</p>
                        </div>
                    </div>
					
				
                           
							
						
                    <div class="col-md-6 col-12">
                        <div class="copyright-text text-md-right">
                            <p>&copy; 2021 StemX. All rights reserved.</p>
                        </div>
                    </div>
                </div>
            </div>
            <!-- /Copyright -->

        </div>
    </div>
    <!-- /Footer Bottom -->

</footer>
<!-- /Footer -->
</div>



<div class="modal fade fixed-right show" id="myMentorChat" tabindex="-1" role="dialog" style="padding-right: 17px;"
     aria-modal="true">
    <div class="modal-dialog modal-vertical mentor-modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header align-items-center">
                <div class="modal-title">
                    <h6 class="mb-0">Mentor Chats</h6>
                </div>
             
				
				  <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>            
            <div class="search_box_new mentor_search_box">
                <div class="search-box chat-search-box">
                    <div class="mb-3 bg-light rounded-lg input-group input-group-lg">
                        <div class="input-group-prepend">
                            <button type="button" class="text-muted pr-1 text-decoration-none btn btn-link">
                                <i class="fas fa-search"></i>
                            </button>
                        </div>
                        <input placeholder="Search mentors" type="text"
                               class="form-control bg-light form-control" value="" id="mentor_search">
                    </div>
                </div>
            </div>

            <div class="modal-body">                
                <img class="loaderGif" src="{{ asset('storage') }}/loader/RippleLoder.gif" id="loaderGif" style="display: none;">
                <div class="list-group list-group-flush userlist" id="mentorData">                    
                </div>
                <div id="messageDiv1">
                </div>                
            </div>           
            

            <div class="modal-footer py-3 mt-auto back-footer">
                <div class="bottoggle" style="width:60%;">
                    <div class="form-group">  
                        <div class="row" >
                            <span class="form-control-label">Chat</span>
                            <div class="custom-control custom-switch" style="margin-left: 12px;">
                                <input type="checkbox" class="custom-control-input" value="1" name="bot_toggle" id="bot_toggle">
                                <label class="custom-control-label form-control-label" for="bot_toggle">{{__('Bot')}}</label>
                            </div>
                        </div>
                    </div>
                </div>
                <input type="hidden" id="authorizationToken" value=""/>
                <div class="sandMessage" style="display: none;">
                    {{ Form::open(['url' => 'send.message','id' => 'sendMessageForm1','enctype' => 'multipart/form-data']) }}
                    <input type="hidden" name="user" value="" id="messageMentor">
                    <input type="textarea" name="message" spellcheck="true" id="mentorMessage" value="" placeholder="Type Message Here...">
                    
                    <button type="button" id="micBtn"  class="btn btn-success" data-placement="right" title="Speak" data-toggle="tooltip"><i class="fa fa-microphone-alt" aria-hidden="true"></i></button>

                    <button type="submit" name="send" id="sendMessage1" class="btn btn-primary" data-placement="right" title="Send" data-toggle="tooltip"><i
                            class="fa fa-paper-plane" aria-hidden="true"></i></button>
                    
                    <button type="button" id="startSpeakTextAsyncButton" style="display:none;"></button>
                    <div style="display:none;">Did You Mean:<a id='suggestionLink' href='#' onclick='fixSuggestions(this); return false;'></a></div>
                    {{ Form::close() }}
                </div>
            </div>
            
        </div>
    </div>
</div>


@if(Route::is(['schedule-timings']))
<!-- Add Time Slot Modal -->
<div class="modal fade custom-modal" id="add_time_slot">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Add Time Slots</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form>
                    <div class="hours-info">
                        <div class="row form-row hours-cont">
                            <div class="col-12 col-md-10">
                                <div class="row form-row">
                                    <div class="col-12 col-md-6">
                                        <div class="form-group">
                                            <label>Start Time</label>
                                            <select class="form-control">
                                                <option>Select</option>
                                                <option>12.00 am</option>
                                                <option>1.00 am</option>  
                                                <option>2.00 am</option>
                                                <option>3.00 am</option>
                                                <option>4.00 am</option>
                                                <option>5.00 am</option>
                                                <option>6.00 am</option>
                                                <option>7.00 am</option>
                                                <option>8.00 am</option>
                                                <option>9.00 am</option>
                                                <option>10.00 am</option>
                                                <option>11.00 am</option>
                                                <option>12.00 pm</option>
                                                <option>1.00 pm</option> 
                                                <option>2.00 pm</option> 
                                                <option>3.00 pm</option> 
                                                <option>4.00 pm</option> 
                                                <option>5.00 pm</option> 
                                                <option>6.00 pm</option> 
                                                <option>7.00 pm</option> 
                                                <option>8.00 pm</option> 
                                                <option>9.00 pm</option> 
                                                <option>10.00 pm</option> 
                                                <option>11.00 pm</option> 
                                            </select>
                                        </div> 
                                    </div>
                                    <div class="col-12 col-md-6">
                                        <div class="form-group">
                                            <label>End Time</label>
                                            <select class="form-control">
                                                <option>Select</option>
                                                <option>12.00 am</option>
                                                <option>1.00 am</option>  
                                                <option>2.00 am</option>
                                                <option>3.00 am</option>
                                                <option>4.00 am</option>
                                                <option>5.00 am</option>
                                                <option>6.00 am</option>
                                                <option>7.00 am</option>
                                                <option>8.00 am</option>
                                                <option>9.00 am</option>
                                                <option>10.00 am</option>
                                                <option>11.00 am</option>
                                                <option>12.00 pm</option>
                                                <option>1.00 pm</option> 
                                                <option>2.00 pm</option> 
                                                <option>3.00 pm</option> 
                                                <option>4.00 pm</option> 
                                                <option>5.00 pm</option> 
                                                <option>6.00 pm</option> 
                                                <option>7.00 pm</option> 
                                                <option>8.00 pm</option> 
                                                <option>9.00 pm</option> 
                                                <option>10.00 pm</option> 
                                                <option>11.00 pm</option> 
                                            </select>
                                        </div> 
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="add-more mb-3">
                        <a href="javascript:void(0);" class="add-hours"><i class="fa fa-plus-circle"></i> Add More</a>
                    </div>
                    <div class="submit-section text-center">
                        <button type="submit" class="btn btn-primary submit-btn">Save Changes</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<!-- /Add Time Slot Modal -->

<!-- Edit Time Slot Modal -->
<div class="modal fade custom-modal" id="edit_time_slot">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Edit Time Slots</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form>
                    <div class="hours-info">
                        <div class="row form-row hours-cont">
                            <div class="col-12 col-md-10">
                                <div class="row form-row">
                                    <div class="col-12 col-md-6">
                                        <div class="form-group">
                                            <label>Start Time</label>
                                            <select class="form-control">
                                                <option>Select</option>
                                                <option>12.00 am</option>
                                                <option>1.00 am</option>  
                                                <option>2.00 am</option>
                                                <option>3.00 am</option>
                                                <option>4.00 am</option>
                                                <option>5.00 am</option>
                                                <option>6.00 am</option>
                                                <option>7.00 am</option>
                                                <option>8.00 am</option>
                                                <option>9.00 am</option>
                                                <option>10.00 am</option>
                                                <option>11.00 am</option>
                                                <option>12.00 pm</option>
                                                <option>1.00 pm</option> 
                                                <option>2.00 pm</option> 
                                                <option>3.00 pm</option> 
                                                <option>4.00 pm</option> 
                                                <option>5.00 pm</option> 
                                                <option>6.00 pm</option> 
                                                <option>7.00 pm</option> 
                                                <option>8.00 pm</option> 
                                                <option>9.00 pm</option> 
                                                <option>10.00 pm</option> 
                                                <option>11.00 pm</option> 
                                            </select>
                                        </div> 
                                    </div>
                                    <div class="col-12 col-md-6">
                                        <div class="form-group">
                                            <label>End Time</label>
                                            <select class="form-control">
                                                <option>Select</option>
                                                <option>12.00 am</option>
                                                <option>1.00 am</option>  
                                                <option>2.00 am</option>
                                                <option>3.00 am</option>
                                                <option>4.00 am</option>
                                                <option>5.00 am</option>
                                                <option>6.00 am</option>
                                                <option>7.00 am</option>
                                                <option>8.00 am</option>
                                                <option>9.00 am</option>
                                                <option>10.00 am</option>
                                                <option>11.00 am</option>
                                                <option>12.00 pm</option>
                                                <option>1.00 pm</option> 
                                                <option>2.00 pm</option> 
                                                <option>3.00 pm</option> 
                                                <option>4.00 pm</option> 
                                                <option>5.00 pm</option> 
                                                <option>6.00 pm</option> 
                                                <option>7.00 pm</option> 
                                                <option>8.00 pm</option> 
                                                <option>9.00 pm</option> 
                                                <option>10.00 pm</option> 
                                                <option>11.00 pm</option> 
                                            </select>
                                        </div> 
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="row form-row hours-cont">
                            <div class="col-12 col-md-10">
                                <div class="row form-row">
                                    <div class="col-12 col-md-6">
                                        <div class="form-group">
                                            <label>Start Time</label>
                                            <select class="form-control">
                                                <option>Select</option>
                                                <option>12.00 am</option>
                                                <option>1.00 am</option>  
                                                <option>2.00 am</option>
                                                <option>3.00 am</option>
                                                <option>4.00 am</option>
                                                <option>5.00 am</option>
                                                <option>6.00 am</option>
                                                <option>7.00 am</option>
                                                <option>8.00 am</option>
                                                <option>9.00 am</option>
                                                <option>10.00 am</option>
                                                <option>11.00 am</option>
                                                <option>12.00 pm</option>
                                                <option>1.00 pm</option> 
                                                <option>2.00 pm</option> 
                                                <option>3.00 pm</option> 
                                                <option>4.00 pm</option> 
                                                <option>5.00 pm</option> 
                                                <option>6.00 pm</option> 
                                                <option>7.00 pm</option> 
                                                <option>8.00 pm</option> 
                                                <option>9.00 pm</option> 
                                                <option>10.00 pm</option> 
                                                <option>11.00 pm</option> 
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-12 col-md-6">
                                        <div class="form-group">
                                            <label>End Time</label>
                                            <select class="form-control">
                                                <option>Select</option>
                                                <option>12.00 am</option>
                                                <option>1.00 am</option>  
                                                <option>2.00 am</option>
                                                <option>3.00 am</option>
                                                <option>4.00 am</option>
                                                <option>5.00 am</option>
                                                <option>6.00 am</option>
                                                <option>7.00 am</option>
                                                <option>8.00 am</option>
                                                <option>9.00 am</option>
                                                <option>10.00 am</option>
                                                <option>11.00 am</option>
                                                <option>12.00 pm</option>
                                                <option>1.00 pm</option> 
                                                <option>2.00 pm</option> 
                                                <option>3.00 pm</option> 
                                                <option>4.00 pm</option> 
                                                <option>5.00 pm</option> 
                                                <option>6.00 pm</option> 
                                                <option>7.00 pm</option> 
                                                <option>8.00 pm</option> 
                                                <option>9.00 pm</option> 
                                                <option>10.00 pm</option> 
                                                <option>11.00 pm</option> 
                                            </select>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-12 col-md-2"><label class="d-md-block d-sm-none d-none">&nbsp;</label><a href="#" class="btn btn-danger trash"><i class="far fa-trash-alt"></i></a></div>
                        </div>

                        <div class="row form-row hours-cont">
                            <div class="col-12 col-md-10">
                                <div class="row form-row">
                                    <div class="col-12 col-md-6">
                                        <div class="form-group">
                                            <label>Start Time</label>
                                            <select class="form-control">
                                                <option>Select</option>
                                                <option>12.00 am</option>
                                                <option>1.00 am</option>  
                                                <option>2.00 am</option>
                                                <option>3.00 am</option>
                                                <option>4.00 am</option>
                                                <option>5.00 am</option>
                                                <option>6.00 am</option>
                                                <option>7.00 am</option>
                                                <option>8.00 am</option>
                                                <option>9.00 am</option>
                                                <option>10.00 am</option>
                                                <option>11.00 am</option>
                                                <option>12.00 pm</option>
                                                <option>1.00 pm</option> 
                                                <option>2.00 pm</option> 
                                                <option>3.00 pm</option> 
                                                <option>4.00 pm</option> 
                                                <option>5.00 pm</option> 
                                                <option>6.00 pm</option> 
                                                <option>7.00 pm</option> 
                                                <option>8.00 pm</option> 
                                                <option>9.00 pm</option> 
                                                <option>10.00 pm</option> 
                                                <option>11.00 pm</option> 
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-12 col-md-6">
                                        <div class="form-group">
                                            <label>End Time</label>
                                            <select class="form-control">
                                                <option>Select</option>
                                                <option>12.00 am</option>
                                                <option>1.00 am</option>  
                                                <option>2.00 am</option>
                                                <option>3.00 am</option>
                                                <option>4.00 am</option>
                                                <option>5.00 am</option>
                                                <option>6.00 am</option>
                                                <option>7.00 am</option>
                                                <option>8.00 am</option>
                                                <option>9.00 am</option>
                                                <option>10.00 am</option>
                                                <option>11.00 am</option>
                                                <option>12.00 pm</option>
                                                <option>1.00 pm</option> 
                                                <option>2.00 pm</option> 
                                                <option>3.00 pm</option> 
                                                <option>4.00 pm</option> 
                                                <option>5.00 pm</option> 
                                                <option>6.00 pm</option> 
                                                <option>7.00 pm</option> 
                                                <option>8.00 pm</option> 
                                                <option>9.00 pm</option> 
                                                <option>10.00 pm</option> 
                                                <option>11.00 pm</option> 
                                            </select>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-12 col-md-2"><label class="d-md-block d-sm-none d-none">&nbsp;</label><a href="#" class="btn btn-danger trash"><i class="far fa-trash-alt"></i></a></div>
                        </div>

                    </div>

                    <div class="add-more mb-3">
                        <a href="javascript:void(0);" class="add-hours"><i class="fa fa-plus-circle"></i> Add More</a>
                    </div>
                    <div class="submit-section text-center">
                        <button type="submit" class="btn btn-primary submit-btn">Save Changes</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<!-- /Edit Time Slot Modal -->
@endif
@if(Route::is(['profile-mentee','profile']))
<!-- Voice Call Modal -->
<div class="modal fade call-modal" id="voice_call">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-body">
                <!-- Outgoing Call -->
                <div class="call-box incoming-box">
                    <div class="call-wrapper">
                        <div class="call-inner">
                            <div class="call-user">
                                <img alt="User Image" src="assets/img/user/user.jpg" class="call-avatar">
                                <h4>Jonathan Doe</h4>
                                <span>Connecting...</span>
                            </div>							
                            <div class="call-items">
                                <a href="javascript:void(0);" class="btn call-item call-end" data-dismiss="modal" aria-label="Close"><i class="material-icons">call_end</i></a>
                                <a href="voice-call" class="btn call-item call-start"><i class="material-icons">call</i></a>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- Outgoing Call -->

            </div>
        </div>
    </div>
</div>
<!-- /Voice Call Modal -->

<!-- Video Call Modal -->
<div class="modal fade call-modal" id="video_call">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-body">

                <!-- Incoming Call -->
                <div class="call-box incoming-box">
                    <div class="call-wrapper">
                        <div class="call-inner">
                            <div class="call-user">
                                <img class="call-avatar" src="assets/img/user/user.jpg" alt="User Image">
                                <h4>Dr. Darren Elder</h4>
                                <span>Calling ...</span>
                            </div>							
                            <div class="call-items">
                                <a href="javascript:void(0);" class="btn call-item call-end" data-dismiss="modal" aria-label="Close"><i class="material-icons">call_end</i></a>
                                <a href="video-call" class="btn call-item call-start"><i class="material-icons">videocam</i></a>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- /Incoming Call -->

            </div>
        </div>
    </div>
</div>
<!-- Video Call Modal -->
@endif
@if(Route::is(['blog']))
<div class="modal fade" id="deleteConfirmModal" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <p></p>
            </div>
            <div class="modal-footer">
                <a href="javascript:;" class="btn btn-success si_accept_confirm">Yes</a>
                <button type="button" class="btn btn-danger si_accept_cancel" data-dismiss="modal">Cancel</button>
            </div>
        </div>
    </div>
</div>
@endif
@if(Route::is(['chat']))
<!-- Voice Call Modal -->
<div class="modal fade call-modal" id="voice_call">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-body">

                <!-- Outgoing Call -->
                <div class="call-box incoming-box">
                    <div class="call-wrapper">
                        <div class="call-inner">
                            <div class="call-user">
                                <img alt="User Image" src="assets/img/user/user.jpg" class="call-avatar">
                                <h4>Marvin Downey</h4>
                                <span>Connecting...</span>
                            </div>							
                            <div class="call-items">
                                <a href="javascript:void(0);" class="btn call-item call-end" data-dismiss="modal" aria-label="Close"><i class="material-icons">call_end</i></a>
                                <a href="voice-call" class="btn call-item call-start"><i class="material-icons">call</i></a>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- Outgoing Call -->

            </div>
        </div>
    </div>
</div>
<!-- /Voice Call Modal -->

<!-- Video Call Modal -->
<div class="modal fade call-modal" id="video_call">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-body">

                <!-- Incoming Call -->
                <div class="call-box incoming-box">
                    <div class="call-wrapper">
                        <div class="call-inner">
                            <div class="call-user">
                                <img class="call-avatar" src="assets/img/user/user.jpg" alt="User Image">
                                <h4>Richard Wilson</h4>
                                <span>Calling ...</span>
                            </div>							
                            <div class="call-items">
                                <a href="javascript:void(0);" class="btn call-item call-end" data-dismiss="modal" aria-label="Close"><i class="material-icons">call_end</i></a>
                                <a href="video-call" class="btn call-item call-start"><i class="material-icons">videocam</i></a>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- /Incoming Call -->

            </div>
        </div>
    </div>
</div>
<!-- Video Call Modal -->
@endif
@if(Route::is(['chat-mentee']))
<!-- Voice Call Modal -->
<div class="modal fade call-modal" id="voice_call">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-body">

                <!-- Outgoing Call -->
                <div class="call-box incoming-box">
                    <div class="call-wrapper">
                        <div class="call-inner">
                            <div class="call-user">
                                <img alt="User Image" src="assets/img/user/user.jpg" class="call-avatar">
                                <h4>Richard Wilson</h4>
                                <span>Connecting...</span>
                            </div>							
                            <div class="call-items">
                                <a href="javascript:void(0);" class="btn call-item call-end" data-dismiss="modal" aria-label="Close"><i class="material-icons">call_end</i></a>
                                <a href="voice-call" class="btn call-item call-start"><i class="material-icons">call</i></a>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- Outgoing Call -->

            </div>
        </div>
    </div>
</div>
<!-- /Voice Call Modal -->

<!-- Video Call Modal -->
<div class="modal fade call-modal" id="video_call">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-body">

                <!-- Incoming Call -->
                <div class="call-box incoming-box">
                    <div class="call-wrapper">
                        <div class="call-inner">
                            <div class="call-user">
                                <img class="call-avatar" src="assets/img/user/user.jpg" alt="User Image">
                                <h4>Richard Wilson</h4>
                                <span>Calling ...</span>
                            </div>							
                            <div class="call-items">
                                <a href="javascript:void(0);" class="btn call-item call-end" data-dismiss="modal" aria-label="Close"><i class="material-icons">call_end</i></a>
                                <a href="video-call" class="btn call-item call-start"><i class="material-icons">videocam</i></a>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- /Incoming Call -->

            </div>
        </div>
    </div>
</div>
<!-- Video Call Modal -->
@endif
@if(Route::is(['appointments']))
<!-- Appointment Details Modal -->
<div class="modal fade custom-modal" id="appt_details">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Appointment Details</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <ul class="info-details">
                    <li>
                        <div class="details-header">
                            <div class="row">
                                <div class="col-md-6">
                                    <span class="title">#APT0001</span>
                                    <span class="text">21 Oct 2019 10:00 AM</span>
                                </div>
                                <div class="col-md-6">
                                    <div class="text-right">
                                        <button type="button" class="btn bg-success-light btn-sm" id="topup_status">Completed</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </li>
                    <li>
                        <span class="title">Status:</span>
                        <span class="text">Completed</span>
                    </li>
                    <li>
                        <span class="title">Confirm Date:</span>
                        <span class="text">29 Jun 2019</span>
                    </li>
                    <li>
                        <span class="title">Paid Amount</span>
                        <span class="text">$450</span>
                    </li>
                </ul>
            </div>
        </div>
    </div>
</div>
<!-- /Appointment Details Modal -->


<script>

</script>
@endif