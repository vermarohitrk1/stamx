@if($data->count() > 0)

@foreach($data as $row)
@php
$feedback=$row->getProfilefeebackCount();
@endphp
<!-- Mentor Widget -->
<div class="card">
    <div class="card-body">
        <div class="mentor-widget">
            <div class="user-info-left">
                <div class="mentor-img">
                    <a href="{{route('profile',["id"=>encrypted_key($row->id,"encrypt")])}}">
                        <img src="{{ $row->getAvatarUrl() }}" class="img-fluid" alt="User Image">
                    </a>
                
                </div>
                 @if(!empty(Auth::user()->id))
           @php
          $favourite= \App\FavouriteUser::IsFavMarked($row->id);
              $like= \App\LikeUser::IslikeMarked($row->id);
           @endphp
           
           @endif
                <div class="user-info-cont">
                    <h4 class="usr-name"><a href="{{route('profile',["id"=>encrypted_key($row->id,"encrypt")])}}">{{$row->name}} 
                       
                        </a>
                    </h4>
                    <p class="mentor-type">{{$row->getJobTitle()}}</p>
                    <div class="rating">
                    @for($i=1;$i<=5;$i++)
                        <i class="fas fa-star @if($i<=$row->average_rating) filled @else @endif"></i>
                        @endfor
                        <span class="d-inline-block average-rating">({{$feedback}})</span>
                    </div>
                    <div class="mentor-details"> 
                        <p class="user-location"><i class="fas fa-map-marker-alt"></i> {{$row->state}}, {{$row->country}}</p>
                    </div>
                </div>
            </div>
            <div class="user-info-right">
                <div class="user-infos">
                    <ul>
                        <li><i class="far fa-comment"></i> {{$feedback}} Feedback</li>
                        <li ><i class="fas fa-map-marker-alt"></i> {{$row->state}}, {{$row->country}}</li>
                           @if(!empty($favourite))
                           <li class="text-success"><i class="fas fa-bookmark"></i> Followed</li>
                           @endif
                            @if(!empty($like))
                            <li class="text-success"><i class="fas fa-thumbs-up"></i> Liked</li>
                            @endif
                            
                        @if(!empty(Auth::user()->id))
                        @if(empty($favourite))
                        <li>
                    <i class="fas fa-bookmark"></i> <a class="text-primary" href="javascript:void(0)" onclick="ManageFavourite({{$row->id}},'add')"  title="Follow">
                Follow
            </a>
                </li>
                @endif
                @if(empty($like))
                         <li>
                    <i class="fas fa-thumbs-up"></i> <a class="text-primary" href="javascript:void(0)" onclick="Managelike({{$row->id}},'add')"  title="Like">
                Like
            </a>
                </li>
                @endif
                @endif
                        <!--<li><i class="far fa-money-bill-alt"></i> $300 - $1000 <i class="fas fa-info-circle" data-toggle="tooltip" title="Lorem Ipsum"></i> </li>-->
                    </ul>
                </div>
                <div class="mentor-booking" >
                    @php
                     $slot_settings=\App\SiteSettings::getUserSettings('slot_booking_settings',$row->id);
                      if(!empty($slot_settings['enable_slot_booking']) && $slot_settings['enable_slot_booking'] == 'on'){
                    $available_appointment=\App\MeetingScheduleSlot::IsAvailableBookingSlots($row->id);
                    @endphp
                    @if(empty($available_appointment))
                    <a class=" btn-warning" title="No Appointment Available" href="#">No Appointment</a>
                    @else
                    <a class="apt-btn" href="{{route('profile.booking',["id"=>encrypted_key($row->id,"encrypt")])}}">Book Appointment</a>
                    @endif
                     @php
                     }
                     @endphp
                </div>
            </div>
        </div>
    </div>
</div>
<!-- /Mentor Widget -->


@endforeach

<div class=" col-md-12 d-flex justify-content-center paginationCss">
    {{ $data->appends(request()->except('page'))->links() }}

</div>

@else
<div class="text-center errorSection">
    <h3>No Data Found</h3>
</div>
@endif

