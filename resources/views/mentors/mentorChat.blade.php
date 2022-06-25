@if($user != 0)  
<div class="chat-header">

                            <a id="back_user_list" href="javascript:void(0)" class="back-user-list">
                                <i class="material-icons">chevron_left</i>
                            </a>
                            <div class="media">
                                <div class="media-img-wrap">
								
                                    <div class="avatar @if(getUserDetails($userprofile->id)->login_status == 0) avatar-offline @else avatar-online @endif ">
										 @if(!empty($userprofile->avatar) && file_exists( storage_path().'/app/'.$userprofile->avatar ))
										 <img alt="User Image"src="{{ asset("storage/app") }}/{{$userprofile->avatar}}"  class="avatar-img rounded-circle">	
										
								@else
									<span class="avatar avatar_c  rounded-circle ">{{substr(ucfirst($userprofile->name),0,1)}}</span>
								@endif
                                        
                                    </div>
                                </div>
                                <div class="media-body">
                                    <div class="user-name">{{$userprofile->name}}</div>
                                </div>
                            </div> @if((!empty(env('TWILIO_VIDEO_ENABLE')) && env('TWILIO_VIDEO_ENABLE') == 'on')) @if(getUserDetails($userprofile->id)->login_status != 0) <div class="media float-right pull-right">
                                    <div class="media-img-wrap float-right pull-right"><button 
              onclick="placeVideoCall({{$userprofile->id}},{{Auth::user()->id}})"  class="btn btn-primary btn-md float-right pull-right"  type="button"><span class=" btn-inner--icon text-right " title="Video Call"><i class="fas fa-video"></i></span></button> </div>
                                </div> @endif @endif
                        </div>

                        <div class="chat-body">
                            <div class="chat-scroll">
				<div class="messages">

	
	<ul class="list-unstyled">
                                
			
									
			@if($data->count())
			@foreach($data as $message)
			@if($message->through == 'sender')
				  <li class="media sent">
                                       
                                    <div class="media-body">
                                            <div class="msg-box">
                                                <div>
                                                    <p>{{$message->message_text}}</p>
													  <ul class="chat-msg-info">
                                                        <li>
                                                            <div class="chat-time">
                                                                <span>{{time_elapsed_string($message->created_at)}}</span>
                                                            </div>
                                                        </li>
														{{--  <li><a href="#">Edit</a></li>--}}
                                                    </ul>
													{{--  <a href="javascript:void(0)"  data-userid="{{ $user }}" data-msgid="{{ $message->id }}" class="delete_msg"><i class="fas fa-trash"></i> </a>--}}
                                                  
                                                </div>
                                            </div>
                                        
                                          
                                        </div>
                                  </li>
			@else
			  <li class="media received">
                                        <div class="avatar">
											  @if( !empty( getUserAvatarUrl($message->sender_id) )) 
											     <img alt="Image " {{getUserAvatarUrl($message->sender_id)}} class="avatar-img rounded-circle">
										  @else
											  <img src="assets/img/user/user.jpg" alt="User Image" class="avatar-img rounded-circle">
										@endif
										
                                           
                                        </div>
                                    <div class="media-body">
                                            <div class="msg-box">
                                                <div>
                                                    <p>{{$message->message_text}}</p>
                                                   
                                                  
                                                </div>
                                            </div>
                                          
                                          
                                        </div>
                                  </li>
			@endif
			@endforeach
			@endif
					
                                  
								  
								  
								      
								  
								  </ul>
</div>
							
							
							
                 
						   </div>
                        </div>	

@else
<div class="chat-header">
                            <a id="back_user_list" href="javascript:void(0)" class="back-user-list">
                                <i class="material-icons">chevron_left</i>
                            </a>
                            <div class="media">
                                <div class="media-img-wrap">
								       @php $img =  asset('public/').'/img/'.App\Http\Controllers\UserController::getBotImage(); @endphp
                                    <div class="avatar avatar-online">
                                        <img src="{{ $img }}" alt="User Image" class="avatar-img rounded-circle">
                                    </div>
                                </div>
                                <div class="media-body">
                                    <div class="user-name">{{ App\Http\Controllers\UserController::getBotName() }}</div>
                                </div>
                            </div>
                          
                        </div>
                        <div class="chat-body">
                            <div class="chat-scroll">
							<div class="messages">

	
	<ul class="list-unstyled">
                                
									
									
									
                                    <li class="media received">
                                        <div class="avatar">
                                            <img src="assets/img/user/user.jpg" alt="User Image" class="avatar-img rounded-circle">
                                        </div>
                                    <div class="media-body">
                                            <div class="msg-box">
                                                <div>
                                                    <p>{{ App\Http\Controllers\UserController::getBotCompanyName() }}</p>
                                                   
                                                  
                                                </div>
                                            </div>
                                            <div class="msg-box">
                                                <div>
                                                    <p>{{ App\Http\Controllers\UserController::getBotGreetings() }}</p>
                                                  
                                                </div>
                                            </div>
                                          
                                        </div>
                                  </li>
								  
								  </ul>
</div>
							
							
							
                 
						   </div>
                        </div>	




@endif


