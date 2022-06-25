@if($user != 0)
    <ul>
        @if($data->count())
        @foreach($data as $message)
        @if($message->through == 'sender')
			
		
		

		  <li class="media sent">
                                    
                                    <div class="media-body">
                                            <div class="msg-box">
                                                <div>
                                                    <p>{{$message->message_text}}<span class="chatTiming">{{time_elapsed_string($message->created_at)}}</span></p>
														{{--     <a href="javascript:void(0)"  data-userid="{{ $user }}" data-msgid="{{ $message->id }}" class="delete_msg"><i class="fas fa-trash"></i> </a>--}}
                                                   <a href="javascript:void(0)"  data-userid="{{ $user }}" data-msgid="{{ $message->id }}" class="delete_msg"><i class="fas fa-trash"></i> </a>
                                                </div>
                                            </div>
                                        
                                          
                                        </div>
                                  </li>
		
        @else
			
		
		

		
			  <li class="media received">
                                        <div class="avatar">
                                            <img src="assets/img/user/user.jpg" alt="User Image" class="avatar-img rounded-circle">
                                        </div>
                                    <div class="media-body">
                                            <div class="msg-box">
                                                <div>
                                                    <p>{{$message->message_text}}<span class="chatTiming">{{time_elapsed_string($message->created_at)}}</span></p>
                                                   
                                                  
                                                </div>
                                            </div>
                                          
                                          
                                        </div>
                                  </li>
		
        @endif
        @endforeach
        @endif
    </ul>
@endif


