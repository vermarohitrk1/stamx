<?php $page = "profile"; ?>
@section('title')
    {{$page??''}}
@endsection
@extends('layout.commonlayout')
@section('content')

@php
$expr = '/(?<=\s|^)[a-z] /i'; preg_match_all($expr, $user->name, $matches);
    $Acronym = implode('', $matches[0]);

    $permissions=get_role_data($user->type,'permissions');
    @endphp
    <!-- Breadcrumb -->
    <div class="breadcrumb-bar">
        <div class="container-fluid">
            <div class="row align-items-center">
                <div class="col-md-12 col-12">
                    <nav aria-label="breadcrumb" class="page-breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{url('/')}}">Home</a></li>
                            <li class="breadcrumb-item active" aria-current="page">{{ucfirst($user->type)}} Profile</li>
                        </ol>
                    </nav>
                    <h2 class="breadcrumb-title">{{ucfirst($user->type)}} Profile</h2>
                </div>
            </div>
           
        </div>
        
    </div>
    <!-- /Breadcrumb -->

    <!-- Page Content -->
    <div class="content text-lg">
        <div class="container">
            <div class="row justify-content-center">
                
                <div class="col-xl-10">
  <div class=" col-md-12 ">
                   <a href="{{ url()->previous() }}" class="btn btn-lg btn-primary float-right btn-icon-only rounded-circle " >
        <span class="btn-inner--icon"><i class="fas fa-reply"></i></span>
    </a>
                     </div>
                   <!-- Mentor Widget -->
                    <div class="card">
                        <div class="card-body">
                            <div class="mentor-widget">
                                <div class="user-info-left align-items-center">
                                    <div class="mentor-img d-flex flex-wrap justify-content-center">
                                                        @if($user->avatar)
                            <div class="col-auto profile-image">
                                                        <a href="#">
                                                            <img height="100" width="100" class="rounded-circle" alt="User Image" src="{{$user->getAvatarUrl()}}">
                                                        </a>
                                                    </div>
                            @else
                            <div class="pro-avatar">{{strtoupper($Acronym)}}</div>
                            @endif
                                        <div class="rating text-center m-auto">
                                            @for($i=1; $i<=5;$i++)
                                <i class="fas fa-star @if(!empty((int) $user->average_rating) && $i<= (int) $user->average_rating) filled @endif"></i>
                                @endfor
                                        </div>
                                        <div class="mentor-details m-0">
                                            <p class="user-location m-0"><i class="fas fa-map-marker-alt"></i> {{$user->state}}, {{$user->country}}</p>
                                        </div>
                                    </div>
                                    <div class="user-info-cont">
                                        <h4 class="usr-name">{{$user->name}}</h4>
                                        <p class="mentor-type">{{$qualification->degree??""}}</p>
                                        @if(!empty($bookedslots))
                                        <div class="mentor-action">
                                            <p class="mentor-type social-title">Contact Me</p>
                                            <a href="chat" class="btn-blue">
                                                <i class="fas fa-comments"></i>
                                            </a>
                                            @if (Auth::check())
                                            <a href="#"  data-url="{{ route('send.email.form',$user->id) }}" data-ajax-popup="true" data-size="md" data-title="{{__('Send Email')}}" class="btn-blue">
                                                @else
                                            <a href="javascript:void(0)" class="btn-blue">
                                            @endif
                                                <i class="fas fa-envelope"></i>
                                            </a>
                                            @if(!empty($user->mobile) && !empty($token) && !empty($callnumber))

                                            @if (Auth::check())
                                            <a href="#"  data-url="{{ route('send.sms.form',$user->id) }}" data-ajax-popup="true" data-size="md" data-title="{{__('Send Email')}}" class="btn-blue">
                                                @else
                                            <a href="javascript:void(0)" class="btn-blue">
                                            @endif
                                <i class="fa fa-mobile"></i>
                            </a>

                            <a data-toggle="tooltip"  id="cont" href="{{route('twilio.call.initiate')}}?phone={{urlencode($user->mobile)}}" class="btn-blue" >
                                <i class="fas fa-phone-alt"></i>
                            </a>
                            <a onclick="hangup();" href="javascript:void(0)" class="btn-danger" style="display:none;" id="hang" >
                                <i class="fas fa-phone-alt"></i>
                            </a>

                            @endif
                                        </div>
                                        @endif
                                    </div>
                                </div>
                                @if(in_array('manage_meeting_appointments',$permissions) || $user->type=="admin")
                                <div class="user-info-right d-flex align-items-end flex-wrap">
                                    <div class="hireme-btn text-center">
                                        @php
                                              $slot_settings=\App\SiteSettings::getUserSettings('slot_booking_settings',$user->id);
                      if(!empty($slot_settings['enable_slot_booking']) && $slot_settings['enable_slot_booking'] == 'on'){
                        $available_appointment=\App\MeetingScheduleSlot::IsAvailableBookingSlots($user->id);
                        @endphp
                        @if(empty($available_appointment))
                        <a class="btn btn-lg btn-warning btn-rounded" href="#">No Appointment Available</a>
                        @else
                        <a class="blue-btn-radius" href="{{route('profile.booking',encrypted_key($user->id, 'encrypt'))}}">Hire Me</a>
                        @endif
                         @php
                     }
                     @endphp
                                        
                                    </div>
                                </div>
                                @endif
                            </div>
                        </div>
                    </div>
                    <!-- /Mentor Widget -->

                    <!-- Mentor Details Tab -->
                    <div class="card">
                        <div class="card-body custom-border-card pb-0">

                            <!-- About Details -->
                            <div class="widget about-widget custom-about mb-0">
                                <h4 class="widget-title">About Me</h4>
                                <hr />
                                <p>{{$user->about}}</p>
                            </div>
                            <!-- /About Details -->
                        </div>
                    </div>

                    <div class="card">
                        <div class="card-body custom-border-card pb-0">

                            <!-- Personal Details -->
                            <div class="widget education-widget mb-0">
                                <h4 class="widget-title">Personal Details</h4>
                                <hr />
                                <div class="experience-box">
                                    <ul class="experience-list profile-custom-list">
                                        <li>
                                            <div class="experience-content">
                                                <div class="timeline-content">
                                                    <span>Gender</span>
                                                    <div class="row-result">{{$user->gender}}</div>
                                                </div>
                                            </div>
                                        </li>
                                        <li>
                                            <div class="experience-content">
                                                <div class="timeline-content">
                                                    <span>Date of Birth</span>
                                                    <div class="row-result">{{$user->dob}}</div>
                                                </div>
                                            </div>
                                        </li>
                                        <li>
                                            <div class="experience-content">
                                                <div class="timeline-content">
                                                    <span>Nick Name</span>
                                                    <div class="row-result">{{$user->nickname}}</div>
                                                </div>
                                            </div>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                            <!-- /Personal Details -->

                        </div>
                    </div>

                    <div class="card">
                        <div class="card-body custom-border-card pb-0">

                            <!-- Qualification Details -->
                            <div class="widget experience-widget mb-0">
                                <h4 class="widget-title">Qualification</h4>
                                <hr />
                                <div class="experience-box">
                                    <ul class="experience-list profile-custom-list">
                                        <li>
                                            <div class="experience-content">
                                                <div class="timeline-content">
                                                    <span>Program</span>
                                                    <div class="row-result">{{$qualification->program??""}}</div>
                                                </div>
                                            </div>
                                        </li>
                                        <li>
                                            <div class="experience-content">
                                                <div class="timeline-content">
                                                    <span>Major</span>
                                                    <div class="row-result">{{$qualification->major??""}}</div>
                                                </div>
                                            </div>
                                        </li>
                                        <li>
                                            <div class="experience-content">
                                                <div class="timeline-content">
                                                    <span>College</span>
                                                    <div class="row-result">{{$qualification->college??""}}</div>
                                                </div>
                                            </div>
                                        </li>
                                        <li>
                                            <div class="experience-content">
                                                <div class="timeline-content">
                                                    <span>Type of Degree</span>
                                                    <div class="row-result">{{$qualification->degree??""}}</div>
                                                </div>
                                            </div>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                            <!-- /Qualification Details -->

                        </div>
                    </div>

                    <div class="card">
                        <div class="card-body pb-1 custom-border-card">

                            <!-- Location Details -->
                            <div class="widget awards-widget m-0">
                                <h4 class="widget-title">Location</h4>
                                <hr />
                                <div class="experience-box">
                                    <ul class="experience-list profile-custom-list">
                                        <li>
                                            <div class="experience-content">
                                                <div class="timeline-content">
                                                    <span>Address 1</span>
                                                    <div class="row-result">{{$user->address1}}</div>
                                                </div>
                                            </div>
                                        </li>
                                        <li>
                                            <div class="experience-content">
                                                <div class="timeline-content">
                                                    <span>Address 2</span>
                                                    <div class="row-result">{{$user->address2}}</div>
                                                </div>
                                            </div>
                                        </li>
                                        <li>
                                            <div class="experience-content">
                                                <div class="timeline-content">
                                                    <span>Country</span>
                                                    <div class="row-result">{{$user->country}}</div>
                                                </div>
                                            </div>
                                        </li>
                                        <li>
                                            <div class="experience-content">
                                                <div class="timeline-content">
                                                    <span>City</span>
                                                    <div class="row-result">{{$user->city}}</div>
                                                </div>
                                            </div>
                                        </li>
                                        <li>
                                            <div class="experience-content">
                                                <div class="timeline-content">
                                                    <span>State</span>
                                                    <div class="row-result">{{$user->state}}</div>
                                                </div>
                                            </div>
                                        </li>
                                        <li>
                                            <div class="experience-content">
                                                <div class="timeline-content">
                                                    <span>Postal Code</span>
                                                    <div class="row-result">{{$user->postal_code}}</div>
                                                </div>
                                            </div>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                            <!-- /Location Details -->

                        </div>
                    </div>
                    <!-- /Mentor Details Tab -->
                    <div id="feedback" class="card">
                        <div class="card-body pb-1 custom-border-card">

                            <!-- Location Details -->
                            <div class="widget awards-widget m-0">
                                <h4 class="widget-title">Feedback</h4>
                                <hr />
                                <div class="experience-box">
                                    <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12 ">
                                                @php
                                                $authid=\Auth::user()->id??'';
                                                @endphp
                                                @if(empty($authid))
                                                <span>Please book the slot first.</span>
                                                @endif
                                                <div id="reviews_div"></div>

                                               
                                        @if(!empty($authid))
                                        <div class="card-body">
                                            {{ Form::open(['route' => 'profiles.review.post','enctype' => 'multipart/form-data','method' => 'post','id'=>'review_form']) }}
                                            <div class="d-flex align-items-center">
                                                @if($user->id != $authid && !empty($slots))
                                                    <div class="col-md-8">
                                                        <div class="rating require-validation">
                                                            <input type="radio" id="star5" name="rating" value="5" />
                                                            <label class="full" for="star5"
                                                                title="Awesome - 5 stars"></label>
                                                            <input type="radio" id="star4half" name="rating" value="4.5" />
                                                            <label class="half" for="star4half"
                                                                title="Pretty good - 4.5 stars"></label>
                                                            <input type="radio" id="star4" name="rating" value="4" />
                                                            <label class="full" for="star4"
                                                                title="Pretty good - 4 stars"></label>
                                                            <input type="radio" id="star3half" name="rating" value="3.5" />
                                                            <label class="half" for="star3half"
                                                                title="Meh - 3.5 stars"></label>
                                                            <input type="radio" id="star3" name="rating" value="3" />
                                                            <label class="full" for="star3" title="Meh - 3 stars"></label>
                                                            <input type="radio" id="star2half" name="rating" value="2.5" />
                                                            <label class="half" for="star2half"
                                                                title="Kinda bad - 2.5 stars"></label>
                                                            <input type="radio" id="star2" name="rating" value="2" />
                                                            <label class="full" for="star2"
                                                                title="Kinda bad - 2 stars"></label>
                                                            <input type="radio" id="star1half" name="rating" value="1.5" />
                                                            <label class="half" for="star1half"
                                                                title="Meh - 1.5 stars"></label>
                                                            <input type="radio" id="star1" name="rating" value="1" />
                                                            <label class="full" for="star1"
                                                                title="Sucks big time - 1 star"></label>
                                                            <input type="radio" id="starhalf" name="rating" value="0.5"
                                                                required="" />
                                                            <label class="half" for="starhalf"
                                                                title="Sucks big time - 0.5 stars"></label>
                                                            <input type="radio" class="reset-option" name="rating"
                                                                value="reset" />
                                                        </div>
                                                    </div>
                                                @endif
                                            </div>

                                            @if($user->id != $authid && !empty($slots))
                                            <div class="col-md-12">
                                                <div class="form-group ">
                                                
                                                        <label>How would you like to rate?</label>

                                                        <i data-feather="message-circle" class="fea icon-sm icons"></i>
                                                        <textarea id="review" placeholder="Your Comment" rows="3"
                                                            name="review" class="form-control pl-5" required=""></textarea>
                                                        <input type="hidden" name="id" value="{{$user->id}}" />
                                                </div>
                                                
                                                <div class="send">
                                                    {{ Form::button(__('Submit Review'), ['type' => 'submit','class' => 'g-recaptcha btn btn-primary btn-block','data-sitekey'=>"6LcGnBwcAAAAAHY2J4EwqpoYLAODaUnKioLdxmrz",'data-callback'=>'onSubmit','data-action'=>'submit']) }}

                                                </div>
                                             
                                            </div>
                                            @else
                                          
                                            @endif
                                            <!--end col-->

                                            {{ Form::close() }}

                                        </div>
                                        @else
                                         <span>To write a review, you must login first.</span>
                                        @endif

                                       

                                    </div>
                                </div>
                            </div>
                            <!-- /Location Details -->

                        </div>
                    </div>
                    <!-- /Mentor Details Tab -->

                </div>
            </div>
        </div>
    </div>
    <!-- /Page Content -->

    @endsection
    @push('script')
    <style>
    @import url(https://netdna.bootstrapcdn.com/font-awesome/3.2.1/css/font-awesome.css);
    @import url(http://fonts.googleapis.com/css?family=Calibri:400,300,700);
    .comment-body {
    width: 100%;
}
    fieldset,


    .rating {
        border: none;
        margin-right: 49px
    }

    .myratings {
        font-size: 85px;
        color: green
    }

    .rating>[id^="star"] {
        display: none
    }

    .rating>label:before {
        margin: 5px;
        font-size: 2.25em;
        font-family: FontAwesome;
        display: inline-block;
        content: "\f005"
    }

    .rating>.half:before {
        content: "\f089";
        position: absolute
    }

    .rating>label {
        color: #ddd;
        float: right
    }

    .rating>[id^="star"]:checked~label,
    .rating:not(:checked)>label:hover,
    .rating:not(:checked)>label:hover~label {
        color: #febe42
    }

    .rating>[id^="star"]:checked+label:hover,
    .rating>[id^="star"]:checked~label:hover,
    .rating>label:hover~[id^="star"]:checked~label,
    .rating>[id^="star"]:checked~label:hover~label {
        color: #FFED85
    }

    .reset-option {
        display: none
    }

    .reset-button {
        margin: 6px 12px;
        background-color: rgb(255, 255, 255);
        text-transform: uppercase
    }
    </style>
    <script src="https://www.google.com/recaptcha/api.js"></script>
    <script>
        
    $(document).ready(function() {

        $(document).ready(function() {

            $("input[type='radio']").click(function() {
                var sim = $("input[type='radio']:checked").val();
                //alert(sim);
                if (sim < 3) {
                    $('.myratings').css('color', 'red');
                    $(".myratings").text(sim);
                } else {
                    $('.myratings').css('color', 'green');
                    $(".myratings").text(sim);
                }
            });
        });

    });
    function onSubmit(token) {
      //  alert(document.getElementById("getElementsByName"));
     document.getElementById("review_form").submit();
   }
    </script>

    <script>
    $(function() {

        filter();
    });


    //pagination
    $(document).on('click', '.pagination a', function(e) {
        var paginationUrl = 'page=' + $(this).attr('href').split('page=')[1];
        filter(paginationUrl);
        e.preventDefault();
    });


    function filter(page = '') {


        var data = {
            id: {{ $user->id }},
            _token: "{{ csrf_token() }}",
        }
        $.post(
            "{{route('profiles.reviews')}}?" + page,
            data,
            function(data) {
                $("#reviews_div").html(data.html);
                $(".pagify-pagination").remove();

            }
        );
    }
    </script>
    @endpush