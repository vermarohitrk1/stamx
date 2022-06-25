
@php
$expr = '/(?<=\s|^)[a-z]/i';
preg_match_all($expr, $contact->email, $matches);
$Acronym = implode('', $matches[0]);

@endphp           

<!-- Mentor Widget -->
<div class="card">
    <div class="card-body">
        <div class="row">
            <div class="col-md-6 justify-content-center">
                   @if($contact->avatar)
                    <div class="col-auto profile-image justify-content-center text-center centered ">
                        <a href="#">
                            <img height="100" style="margin: 0px !important" width="100" class="rounded-circle" alt="User Image" src="{{$contact->getAvatarUrl()}}">
                        </a>
                    </div>
                    @else
                    <div class="pro-avatar">{{strtoupper($Acronym)}}</div>
                    @endif
                    <div class="rating text-center">
                       <p class="mentor-type">{{ $contact->type }}</p>
                        @if(!empty($contact->phone))
                        {{ mobileNumberFormat($contact->phone) }}
                        @endif
                    </div>
                    <!--                                    <div class="mentor-details m-0">
                                                            <p class="user-location m-0"><i class="fas fa-map-marker-alt"></i> {{$contact->state}}, {{$contact->country}}</p>
                                                        </div>-->
            </div>
            <div class="col-md-6 justify-content-center">
                 <h4 class="usr-name">{{!empty($contact->fullname)?$contact->fullname:$contact->fname.' '.$contact->lname}}<a title="Configure twilio for sms/call" class=" pull-right float-right" href="{{route('site.settings')}}"><i class="fa fa-cog"></i></a></h4>
                    <p class="mentor-type"> @if(!empty($contact->email))
                        {{ $contact->email }}
                        @endif</p>
                    
                    <div class="mentor-action">
                        <p class="mentor-type social-title">{{ is_numeric($contact->folder)?(\App\ContactFolder::getfoldername($contact->folder)):$contact->folder }}</p>
                        <input type="hidden" id="connection_id" value="{{ $contact->id }}" />
                        <input type="hidden" id="telNumber" value="{{ $contact->phone }}" />
                        <input type="hidden" id="{{ !empty($contact->phone) ? "number" :'' }}" value="{{ $contact->phone }}" />
                        @if(!empty($contact->email))
                        <a href="javascript:void(0)" title="Send Email"  onclick="profile_actions('email')" class="btn-blue">
                            <i class="fas fa-envelope"></i>
                        </a>
                        @endif
                        @if(!empty($contact->phone) && !empty($token) && !empty($callnumber))


                        <a href="javascript:void(0)" onclick="profile_actions('sms')" title="Send SMS" class="btn-blue">
                            <i class="fa fa-mobile"></i>
                        </a>

                        <a data-toggle="tooltip"  id="cont" href="{{route('twilio.call.initiate')}}?phone={{urlencode($contact->phone)}}" class="btn-blue" >
                            <i class="fas fa-phone-alt"></i>
                        </a>
                        <a onclick="hangup();" href="javascript:void(0)" class="btn-danger" style="display:none;" id="hang" >
                            <i class="fas fa-phone-alt"></i>
                        </a>

                        @else
                        
                        @endif


                    </div>
            </div>
        </div>
        
        
        <hr>
                <div style="display: none" id="processing_div" class="form-group text-primary">Please wait processing your request...</div>
                <div id="email_div" style="display:none">
                    
                <div class="form-group" >
                    <div class="row">
                        <div class="col-md-12">
                            <label class="form-control-label">Email Subject:</label>
                            <input class="form-control " type="text" id="email_subject" name="email_subject"   placeholder="Subject here."  required />
                        </div>
                        <div class="col-md-12">
                            <label class="form-control-label">Email Body:</label>
                            <textarea class="form-control " id="email_body" name="email_body"   placeholder="Type your message here.." rows="5" required></textarea>
                        </div>
                    </div>                    
                    <div class="text-right  mt-2 float-right">
                        <button type="button" id="email_button" class="btn btn-sm btn-primary rounded-pill pull-right float-right" >{{__('Send Email')}}</button>
                    </div>
                </div>
                </div>
                <div id="sms_div" style="display:none">                    
                <div class="form-group" >
                    <div class="row">
                        <div class="col-md-12">
                            <label class="form-control-label">SMS 
                               @if(!empty($contact->phone))<a href="#" class="m-0 text-sm text-danger" data-url="{{ route('sms.thread.view',$contact->phone) }}" data-ajax-popup="true" data-size="lg" data-title="{{__('SMS Thread')}}">
    <span class="btn-inner--text text-dark">(Thread View)</span>
</a> @endif
                            
                            </label>
                            <textarea class="form-control" id="sms_body"  name="sms_body" maxlength="250" placeholder="Type your text here.." rows="5" required></textarea>
                        </div>
                    </div>                    
                    <div class="text-right  mt-2 float-right">
                        <button type="button" id="sms_button" class="btn btn-sm btn-primary rounded-pill pull-right float-right" >{{__('Send SMS')}}</button>
                    </div>
                </div>
                </div>
                
    </div>
</div>
<!-- /Mentor Widget -->     

                <link rel="stylesheet" type="text/css" href="{{ asset('assets/css/simcify.min.css') }}">
<script src="{{ asset('assets/js/simcify.min.js') }}"></script>


<script src="{{ asset('public/ckeditor/ckeditor.js') }}"></script>

<script>
CKEDITOR.replace('email_body');

</script>
