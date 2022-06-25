

@if($data->count() > 0)
  <div class="row">
@foreach($data as $row)
@php
$feedback=$row->getProfilefeebackCount();
@endphp
<div class="col-sm-12 col-md-6 col-xl-6">
    <div class="profile-widget">
        <div class="user-avatar">
             <a href="{{route('profile',["id"=>encrypted_key($row->id,"encrypt")])}}">
                 <img src="{{ $row->getAvatarUrl() }}" class="img-fluid"  alt="User Image">
                    </a>
            @if(!empty(Auth::user()->id))
           @php
          $favourite= \App\FavouriteUser::IsFavMarked($row->id);
          $like= \App\LikeUser::IslikeMarked($row->id);
           @endphp
           @if(empty($favourite))
            <a href="javascript:void(0)" onclick="ManageFavourite({{$row->id}},'add')" class="fav-btn bg-success btn-success" title="Follow">
                <i class="far fa-bookmark"></i> 
            </a>
           @endif
           @if(empty($like))
            <a href="javascript:void(0)" onclick="Managelike({{$row->id}},'add')" class="fav-btn bg-success btn-primary mr-5" title="Like">
                <i class="far fa-thumbs-up"></i> 
            </a>
           @endif
           
           
           @endif
        </div>
        <div class="pro-content">
            <h3 class="title">
                <a href="{{route('profile',["id"=>encrypted_key($row->id,"encrypt")])}}">{{$row->name}}</a> 
                @if(!empty($favourite))
                <i class="fas fa-check-circle verified"></i>
                @endif
                @if(!empty($like))
                <i class="fas fa-thumbs-up verified"></i>
                @endif
            </h3>
            <p class="speciality">{{$row->getJobTitle()}}</p>
             <div class="rating">
                        @for($i=1;$i<=5;$i++)
                        <i class="fas fa-star @if($i<=$row->average_rating) filled @else @endif"></i>
                        @endfor
                        <span class="d-inline-block average-rating">({{$feedback}})</span>
                    </div>
            
            <ul class="available-info">
                <li>
                    <i class="fas fa-map-marker-alt"></i> {{$row->state}}, {{$row->country}}
                </li>
<!--                <li>
                    <i class="far fa-clock"></i> Available on Fri, 22 Mar
                </li>
                <li>
                    <i class="far fa-money-bill-alt"></i> $300 - $1000 <i class="fas fa-info-circle" data-toggle="tooltip" title="Lorem Ipsum"></i>
                </li>-->
            </ul>
            <div class="row row-sm">
                <div class="col-6">
                    <a href="{{route('profile',["id"=>encrypted_key($row->id,"encrypt")])}}" class="btn view-btn">Profile</a>
                </div>
                <div class="col-6">
                    @php
                      $slot_settings=\App\SiteSettings::getUserSettings('slot_booking_settings',$row->id);
                      if(!empty($slot_settings['enable_slot_booking']) && $slot_settings['enable_slot_booking'] == 'on'){
                    $available_appointment=\App\MeetingScheduleSlot::IsAvailableBookingSlots($row->id);
                    @endphp
                    @if(empty($available_appointment))
                    <a href="#" class="btn btn-warning book-btn   bg-warning" title="No Appointment Available">No Slot</a>
                    @else
                   <a href="{{route('profile.booking',["id"=>encrypted_key($row->id,"encrypt")])}}" class="btn book-btn">Book Now</a>
                    @endif
                     @php
                     }
                     @endphp
                </div>
            </div>
        </div>
    </div>
</div>














@endforeach

</div>
<div class=" col-md-12 d-flex justify-content-center paginationCss">
    {{ $data->appends(request()->except('page'))->links() }}

</div>




@else
<div class="text-center errorSection">
    <h3>No Data Found</h3>
</div>
@endif

