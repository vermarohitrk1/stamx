 
                <div class="container  d-flex justify-content-center">
                    <div class="d-flex align-items-center">
                        <div class="image mr-3"> 
                            <div class="avatar-parent-child">
                                <style>
                                    .custom-avatar {
                                        height: 8.2rem!important;
                                        width: 8.2rem!important;
                                    }
                                </style>
                                @if(!empty($data->image) && file_exists( storage_path().'/chat/'.$data->image ))
                                     <img src="{{ asset("storage/chat") }}/{{$data->image}}" alt="Image" class="custom-avatar rounded-circle ">
                            
                                @else
                                    <span class="avatar  rounded-circle">{{substr(ucfirst($data->name),0,1)}}</span>
                            
                                @endif
                           </div>
                            <!--<img src="https://images.unsplash.com/photo-1522075469751-3a6694fb2f61?ixlib=rb-1.2.1&ixid=eyJhcHBfaWQiOjEyMDd9&auto=format&fit=crop&w=500&q=80" class="rounded-circle" width="155">--> 
                        </div>
                        <div class="ml-3 w-100">
                            <h4 class="mb-0 mt-0">{{ $data->name}}</h4> 
                            <span>{{ $data->description }}</span><br>
                          
                        </div>
                    </div>

                </div>
                <hr>
               
                <div id="sms_div" >                    
                <div class="form-group" >
                    <div class="row">
                        <div class="col-md-12">
            <div id="chat-block">
              <div class="title">Group Members</div>
              <ul class="online-users list-inline">
                   <style>
                                    .avatar {
                                        height: 3.2rem!important;
                                        width: 3.2rem!important;
                                    }
                                </style>
                  @foreach($data->members as $user_id)
                  @php
                  $user_data=getUserDetails($user_id);
                  if($user_id==$data->user_id){
                  $role="Group Admin";
                  }else{
                  $role="Group Member";
                  }
                  @endphp
                  
                 
        
                <li>
                    <!--<a data-toggle="modal" data-target="#myChat" href="javascript:void(0);" class="SingleuserChatButton userDataMessage" data-id="{{$user_id}}" title="{{$user_data->name}} ({{$role}})">-->
                    <a  href="javascript:void(0);"  title="{{$user_data->name}} ({{$role}})">
                        
                          @if($user_data->avatar && file_exists( storage_path().'/'.$user_data->avatar ))
        <img alt="Image " @if($user_data->avatar) src="{{ asset("storage/") }}/{{$user_data->avatar}}" @endif class="avatar  rounded-circle img-responsive profile-photo">
        @else
        <span class="avatar  rounded-circle img-responsive profile-photo">{{substr(ucfirst($user_data->name),0,1)}}</span>
        @endif
        
                        <!--<img src="https://bootdey.com/img/Content/avatar/avatar7.png" alt="user" class="img-responsive profile-photo">-->
                        <span class=" @if($user_data->is_active == 0) offline-dot @else online-dot @endif"></span>
                    </a></li>
                
                @endforeach
              </ul>
            </div><!--chat block ends-->
        </div>
                    </div>                    
                    
                </div>
                </div>
                
                <link rel="stylesheet" type="text/css" href="{{ asset('assets/css/simcify.min.css') }}">
<script src="{{ asset('assets/js/simcify.min.js') }}"></script>
<style>
    #chat-block{
  margin: 0 0 40px 0;
  text-align: center;
  background:#fff;
  /*padding-top:20px;*/
}

#chat-block .title{
  /*background: #8dc63f;*/
  padding: 2px 20px;
  width: 70%;
  height: 30px;
  border-radius: 15px;
  position: relative;
  margin: 0 auto 20px;
  /*color: #fff;*/
  font-size: 14px;
  font-weight: 600;
}

ul.online-users{
  padding-left: 20px;
  padding-right: 20px;
  text-align: center;
  margin: 0;
}

ul.online-users li{
  list-style: none;
  position: relative;
  margin: 3px auto !important;
  padding-left: 2px;
  padding-right: 2px;
}

ul.online-users li span.online-dot{
  background: linear-gradient(to bottom, rgba(141,198,63, 1), rgba(0,148,68, 1));
  border: none;
  height: 12px;
  width: 12px;
  border-radius: 50%;
  position: absolute;
  bottom: -6px;
  border: 2px solid #fff;
  left: 0;
  right: 0;
  margin: auto;
}
ul.online-users li span.offline-dot{
  background: orange;
  border: none;
  height: 12px;
  width: 12px;
  border-radius: 50%;
  position: absolute;
  bottom: -6px;
  border: 2px solid #fff;
  left: 0;
  right: 0;
  margin: auto;
}

img.profile-photo {
    height: 58px;
    width: 58px;
    border-radius: 50%;
}

ul.online-users {
    padding-left: 20px;
    padding-right: 20px;
    text-align: center;
    margin: 0;
}

.list-inline {
    padding-left: 0;
    margin-left: -5px;
    list-style: none;
}

.list-inline>li {
    display: inline-block;
    padding-right: 5px;
    padding-left: 5px;
}

.text-white {
    color: #fff;
}
    </style>