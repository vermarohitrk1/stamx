@if($data->count() > 0)
 <div class="row ">
@foreach($data as $row)
@php
$feedback=$row->getProfilefeebackCount();
@endphp
 <div class="col-md-3 col-lg-3 col-xl-3">
    <div class="profile-widget">
        <div class="user-avatar">
             <a href="{{route('profile',["id"=>encrypted_key($row->id,"encrypt")])}}">
                 <img src="{{ $row->getAvatarUrl() }}" class="img-fluid"  alt="User Image">
                    </a>
            <a href="javascript:void(0)" onclick="ManageFavourite({{$row->fav_id}},'remove')" class="fav-btn" title="Unfollow">
                <i class="far fa-trash-alt"></i> 
            </a>
        </div>
        <div class="pro-content">
            <h3 class="title">
                <a href="{{route('profile',["id"=>encrypted_key($row->id,"encrypt")])}}">{{$row->name}}</a> 
                <i class="fas fa-check-circle verified"></i>
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
                    $available_appointment=\App\MeetingScheduleSlot::IsAvailableBookingSlots($row->id);
                    @endphp
                    @if(empty($available_appointment))
                    <a href="#" class="btn btn-warning book-btn   bg-warning" title="No Appointment Available">No Slot</a>
                    @else
                   <a href="{{route('profile.booking',["id"=>encrypted_key($row->id,"encrypt")])}}" class="btn book-btn">Book Now</a>
                    @endif
                    
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
    <h4 class="text-center"> No followed profile found however “Following” allow you to add a list of your followed profiles from public search profiles page. <a class="text-primary" href="{{route('search.profile')}}">Click here</a> to add profiles in your followed list.
</h4>
</div>
@endif

