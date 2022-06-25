@php
    $footerWidget1 = \App\SiteSettings::getWebsiteMenus('footer_widget_1');
    $footerWidget2 = \App\SiteSettings::getWebsiteMenus('footer_widget_2');

    $logo =  \App\SiteSettings::logoSetting();

        if(!empty($logo)){
           $logo_favicon = json_decode($logo->value,true);
        }else{
            $logo_favicon = array();
        }
 
   
     $footer_text =  \App\SiteSettings::footerSetting();

@endphp	
	
	<div class="row ">
		<div class="col-12 sub-footer py120">
			<div class="container">
				<div class="row ">
					<div class="col-12 col-md-6 col-lg-3 left-subfooter-1 p-0 mb3">
					
					@if (!empty($logo_favicon['logo']))
                                    <img src="{{ asset('storage/logo').'/'.$logo_favicon['logo'] }}" >
                                @else
                                   <img src="{{ asset('assets/main/images/logo.png')}}">
                                @endif
						
						<p class="gen-p fotmargin2">
							A secure platform for impact, <br>digital equity and transformation, <br>ready to scale at the speed of thought. 
						</p>

						<div class="social-icons mt-5">
						<ul>
							<li><a href="https://facebook.com/iamstemx"><img src="{{ asset('assets/main/images/fb.png')}}" class="img-fluid"></a></li>
							<li><a href="https://instagram.com/iamstemx"><img src="{{ asset('assets/main/images/insta.png')}}" class="img-fluid"></a></li>
							<li><a href="https://linkedin.com/iamstemx"><img src="{{ asset('assets/main/images/linkedin.png')}}" class="img-fluid"></a></li>
							<li><a href="https://twitter.com/iamstemx"><img src="{{ asset('assets/main/images/twitter.png')}}" class="img-fluid"></a></li>
						</ul>
					</div>
					<!-- social icons end/ -->

					</div>
					<!-- first one -->
					<div class="col-12 col-md-6 col-lg-3 left-subfooter-1 p-0 mb3">
						<h4 class="sub-footer-main-heading">Workforce</h4>
						<ul class="pl-0 fotmargin fotlinks">
						@if (count($footerWidget1))
                                @foreach ($footerWidget1 as $key => $menu)
                                    @if ($menu)
                                        <li><a href="{{url(str_replace('_','-',$menu))}}"> {{$key}}</a></li>
                                    @endif
                                @endforeach
                            @else
						
						
							 <li><a href="">Find Candidates</a></li>
							 <li><a href="">Post a Job</a></li>
							 <li><a href="">Resume Search</a></li>
							 <li><a href="">Impact</a></li>
							 <li><a href="">Staffing</a></li>
							 
							  @endif
						</ul>
						</p>
					</div>
					<!-- second one end -->

					<div class="col-12 col-md-6 col-lg-3 left-subfooter-1 p-0 mb3">
						<h4 class="sub-footer-main-heading">Engage </h4>
						<ul class="pl-0 fotmargin fotlinks">
						
						  @if (count($footerWidget2))
                                @foreach ($footerWidget2 as $key => $menu)
                                    @if ($menu)
                                        <li><a href="{{url(str_replace('_','-',$menu))}}" > {{$key}}</a></li>
                                    @endif
                                @endforeach
                            @else
						
							 <li><a href="">Interative Podcasts</a></li>

							 <li><a href="">Blogs & Whitepapers</a></li>
							 <li><a href="">Conversation Games</a></li>
							 <li><a href="">Labs, Kits & Merch</a></li>
							 <li><a href="">Broadband Benefit </a></li>
							 @endif
						</ul>
						</p>
					</div>
					<!-- thid one end -->

					<div class="col-12 col-md-6 col-lg-3 left-subfooter-1 p-0 mb3">
						<h4 class="sub-footer-main-heading">Ready to Talk?</h4>
						<ul class="pl-0 fotmargin fotlinks">
							 <li><a href="tel:+1 315 369 5943">+1 888.USA.STEM</a></li>

							 <li><a href="mailto:mentoring@example">equity@stemx.com</a></li>
							 <li class="mt-2">
							 	<p class="gen-p">6735 Salt Cedar Way, <br>Frisco, TX 75034</p>
							 </li>
						</ul>
						</p>
					</div>
					<!-- fourth one end -->

				</div>
				<!-- row end -->
			</div>
		</div>
		<!-- sub footer end -->
	</div>
	<!-- sub footer col end -->

	<footer>
	{{$footer_text}}
	</footer>
	
		
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
		@endif