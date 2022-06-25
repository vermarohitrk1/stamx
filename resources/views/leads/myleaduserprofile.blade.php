<style>
    .avatar-xl {
    width: 6rem!important;
    height: 6rem!important;
}
.pro-avatar {
    margin-top: 80px;
}
</style>
<div class="card">
                   
                            <div class="user-info-left row">
                                <div class="col-md-4">
                                            <div class="pro-avatar">
                                            <div class="avatar avatar-xl">
<img class="avatar-img rounded-circle" alt="User Image" src="{{ $data->user->getAvatarUrl()}}">
</div>
                                            </div>
                                    
<!--                                    <div class="mentor-details m-0">
                                        <p class="user-location m-0"><i class="fas fa-map-marker-alt"></i> , </p>
                                    </div>-->
                                </div>
                                <div class="col-md-8">
                                    <h4 class="usr-name"> </h4>
                                    <p class="mentor-type"></p>
                                    <div class="mentor-action">
                                    <div class="card-body">
                                    <div class="pro-content">
                                    <h3 class="title">
                                       <a href="profile">{{ $data->user->name }}</a>
                                       <i class="fas fa-check-circle verified"></i>
                                    </h3>
                                  
                                    <p class="speciality">{{ $data->user->email }}</p>
                                    <ul class="available-info">
                                    <li>
                                    <i class="fa fa-university" aria-hidden="true"></i>

                                          @php 
                                          if($data->college != null){
                           $institute = \App\Pathway::where('level','college')->where('user_id',$data->user->id)->where('mentor_type','student')->first();
              
              $college = \App\Institution::whereIn('id',json_decode($institute->college,true))->get();
            foreach($college as $key => $colleges){
                $k = $key+1;
               echo '<span class="colge">'.$k.') '.$colleges->institution.'</span></br>';
            }
         }
         if($data->branch != null){
            echo $data->branch;
         }

         if($data->catalog != null){
            $certy = \App\Certify::find($data->catalog);

            echo $certy->name;
         }
                                          
                                          
               
      
            @endphp
                                       </li>
                                       <li>
                                          <i class="fas fa-map-marker-alt"></i> {{ $data->user->address1 }}
                                       </li>
                                       
                                       <li>
                                       <i class="fas fa-city"></i>{{ $data->user->city }}
                                       </li>
                                       <li>
                                          <i class="far fa-money-bill-alt"></i>{{ $data->user->state }}
                                       </li>
                                       
                                    </ul>
        </div>
</div>
                                    </div>
                                </div>
                            </div>
                            
                 
                </div>