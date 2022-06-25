<div class="chat-header">
   @if($inbox=="group")
        @php
        $groupInfo=getChatGroupDetails($user);
        @endphp
                            <a id="back_user_list" href="javascript:void(0)" class="back-user-list">
                                <i class="material-icons">chevron_left</i>
                            </a>
                            <div class="media">
                                <div class="media-img-wrap">
                                    <div class="avatar ">
										 @if(!empty($groupInfo->image) && file_exists( storage_path().'/chat/'.$groupInfo->image ))
										 <img alt="User Image"src="{{ asset("storage/chat") }}/{{$groupInfo->image}}"  class="avatar-img rounded-circle">	
										
								@else
									<span class="avatar avatar_c  rounded-circle ">{{substr(ucfirst($groupInfo->name),0,1)}}</span>
								@endif
                                        
                                    </div>
                                </div>
                                <div class="media-body">
                                    <div class="user-name">{{$groupInfo->name}}</div>
                                </div>
                            </div>
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
		   @if(getUserDetails($message->sender_id)->avatar)
                                        <div class="avatar">
										  @if( file_exists( getUserAvatarUrl($message->sender_id) )) 
											     <img alt="Image " {{getUserAvatarUrl($message->sender_id)}} class="avatar-img rounded-circle">
										  @else
											     <img {{getUserAvatarUrl($message->sender_id)}} alt="User Image  " class="avatar-img rounded-circle">
										@endif
                                        
                                        </div>
										@else
											 <span class="avatar-img  rounded-circle">{{substr(ucfirst(getUserDetails($message->sender_id)->name),0,1)}}</span>
										@endif	
                                    <div class="media-body">
                                            <div class="msg-box ffff">
                                                <div>
                                                    <p>{{$message->message_text}}</p>
                                                    <ul class="chat-msg-info">
                                                        <li>
                                                            <div class="chat-time">
                                                                <span>{{time_elapsed_string($message->created_at)}}</span>
                                                            </div>
                                                        </li>
													 <span class="">{{substr(ucfirst(getUserDetails($message->sender_id)->name),0,10)}}</span>
                                                    </ul>
                                                    
                                                </div>
                                            </div>
                                        </div>
                                  </li>
			@endif
			@endforeach
			@endif </ul>
</div> </div>
                        </div>	

@endif
