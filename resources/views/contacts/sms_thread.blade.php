
        		<div class="card-header">{{$contact->phone}}</div>
        		<div class="card-body height3">
        			<ul class="chat-list">
                                    
                                      @if(!empty($messages) && count($messages)>0)
                       @foreach($messages as $message)
                       
                        
                      
                                        @if($message->status=="received")
        				<li class="in">
        					<div class="chat-img">
                                                    <!--<small class="text-primary text-xs">{{time_elapsed($message->created_at)}}</small>-->
        						<!--<img alt="Avtar" src="https://bootdey.com/img/Content/avatar/avatar1.png">-->
                                                        <img {{getContactAvatarUrl($contact->id)}} class=" ">
        					</div>
        					<div class="chat-body">
        						<div class="chat-message">
                                                            <h5 class="text-light "><u>{{ $contact->fname." ".$contact->lname }}</u></h5>
        							<p>{{$message->body}}</p>
                                    <small class="pull-right float-right text-xs ">{{time_elapsed($message->created_at)}}</small>
                               
        						</div>
        					</div>
        				</li>
                                        @else
        				<li class="out">
        					<div class="chat-img">
                                                     <img {{getUserAvatarUrl(Auth::user()->id)}} class=" ">
        						<!--<img alt="Avtar" src="https://bootdey.com/img/Content/avatar/avatar6.png">-->
        					</div>
        					<div class="chat-body">
        						<div class="chat-message">
                                                            <h5><b>{{Auth::user()->name}}</b></h5>
        							<p>{{$message->body}}</p>
                                                                <small class="pull-right float-right text-xs"> {{time_elapsed($message->created_at)}}</small>
                                                               
        						</div>
        					</div>
        				</li>
                                        @endif
        				 @endforeach
                                         @else
                                         
                                        <li >
        					
        					<div class="chat-body">
        						<div class="chat-message">
        							<h5>No Message Exist</h5>
        							
        						</div>
        					</div>
        				</li> 
                       @endif
        			</ul>
        		</div>
        

<style>
    body{
    background:#eee;    
}
.chat-list {
    padding: 0;
    font-size: .8rem;
}

.chat-list li {
    margin-bottom: 10px;
    overflow: auto;
    color: #ffffff;
}

.chat-list .chat-img {
    float: left;
    width: 48px;
}

.chat-list .chat-img img {
    -webkit-border-radius: 50px;
    -moz-border-radius: 50px;
    border-radius: 50px;
    width: 100%;
}

.chat-list .chat-message {
    -webkit-border-radius: 50px;
    -moz-border-radius: 50px;
    border-radius: 50px;
    background: #6a727d;
    display: inline-block;
    padding: 10px 20px;
    position: relative;
}

.chat-list .chat-message:before {
    content: "";
    position: absolute;
    top: 15px;
    width: 0;
    height: 0;
}

.chat-list .chat-message h5 {
    margin: 0 0 5px 0;
    font-weight: 600;
    line-height: 100%;
    font-size: .9rem;
}

.chat-list .chat-message p {
    line-height: 18px;
    margin: 0;
    padding: 0;
}

.chat-list .chat-body {
    margin-left: 20px;
    float: left;
    width: 70%;
}

.chat-list .in .chat-message:before {
    left: -12px;
    border-bottom: 20px solid transparent;
    border-right: 20px solid #6a727d;
}

.chat-list .out .chat-img {
    float: right;
}

.chat-list .out .chat-body {
    float: right;
    margin-right: 20px;
    text-align: right;
}

.chat-list .out .chat-message {
    background: #6a727d61;
}

.chat-list .out .chat-message:before {
    right: -12px;
    border-bottom: 20px solid transparent;
    border-left: 20px solid #6a727d61;
}

.card .card-header:first-child {
    -webkit-border-radius: 0.3rem 0.3rem 0 0;
    -moz-border-radius: 0.3rem 0.3rem 0 0;
    border-radius: 0.3rem 0.3rem 0 0;
}
.card .card-header {
    background: #17202b;
    border: 0;
    font-size: 1rem;
    padding: .65rem 1rem;
    position: relative;
    font-weight: 600;
    color: #ffffff;
}

.content{
    margin-top:40px;    
}
</style>
               
                
                
           