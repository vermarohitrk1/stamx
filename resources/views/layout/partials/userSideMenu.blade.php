
<div class="profile-sidebar">
    <div class="user-widget">
        @php
        $user=Auth::user();
        $expr = '/(?<=\s|^)[a-z]/i';
        preg_match_all($expr, $user->name, $matches);
        $Acronym = implode('', $matches[0]);
        $permissions=permissions();
        $qualification= \App\UserQualification::where("user_id",$user->id)->first();
        @endphp
        @if($user->avatar)
        <div class="col-auto profile-image">
                                    <a href="#">
                                        <img height="100" width="100" class="rounded-circle" alt="User Image" src="{{$user->getAvatarUrl()}}">
                                    </a>
                                </div>
        @else
        <div class="pro-avatar">{{strtoupper($Acronym)}}</div>
        @endif

        <div class="rating">
            @for($i=1; $i<=5;$i++)
            <i class="fas fa-star @if(!empty((int) $user->average_rating) && $i<= (int) $user->average_rating) filled @endif"></i>
            @endfor
        </div>
        <div class="user-info-cont">
            <h4 class="usr-name">{{$user->name}}</h4>
            <p class="mentor-type">{{$qualification->degree??''}}</p>
        </div>
    </div>
    <div class="progress-bar-custom">
        @php
        $profile_completion=$user->profile_completion_percentage;
        @endphp
        <h6>@if($profile_completion==100) <span class="text-success">Profile Completed</span> @else Complete your profiles @endif </h6>
        <div class="pro-progress">
            <div class="tooltip-toggle" role="progressbar" style="width: {{$profile_completion}}%" aria-valuenow="{{$profile_completion}}" aria-valuemin="0" aria-valuemax="100" tabindex="0"></div>
            <div class="tooltip">{{$profile_completion}}%</div>
        </div>
    </div>
    <div class="custom-sidebar-nav">
        <ul>


             @if($user->type =="admin")
            <li ><a class="{{ (Request::is('home') || Request::is('dashboard')) ? 'active' : '' }}" href="{{route('dashboard')}}"><i class="fas fa-reply"></i>Back To Dashboard<span></span></a></li>
            @elseif($user->type == 'mentee' || $user->type == 'mentor')
            <li ><a class="{{ (Request::is('home') || Request::is('dashboard')) ? 'active' : '' }}" href="{{route('dashboard')}}"><i class="fas fa-home"></i>Dashboard <span><i class="fas fa-chevron-right"></i></span></a></li>
            @endif
            <li><a class="{{ (Request::is('chat') ) ? 'active' : '' }}"  href="{{route('chat')}}"><i class="fas fa-comments"></i>Ask Stem X <span><i class="fas fa-chevron-right"></i></span></a></li>
            @if($user->type =="mentor" || $user->type =="corporate")
            <li><a  class="{{ (Request::is('pathway*') ) ? 'active' : '' }}" href="{{route('pathway.get')}}"><i class="fa fa-list fa-1x"></i>Path Finder<span><i class="fas fa-chevron-right"></i></span></a></li>


            @endif

            <!-- start reward point menu-->
            @if($user->type =="admin")
                <li class="submenu lev1">
                   <a href="javascript:void(0)" class="{{ Request::is('admin/badges*') || Request::is('admin/gamify_group*') || Request::is('admin/points*') || Request::is('admin/create/badges*')|| Request::is('admin/badges/edit*')|| Request::is('admin/create/gamify-groups*')|| Request::is('admin/edit/gamify-groups*')|| Request::is('admin/create/points*')|| Request::is('admin/edit/points*') ? 'active' : '' }} sidebar-dropdown"><i class='fas fa-award'></i>Reward Point<span><i class="fas fa-chevron-right"></i></span></a>
                    <ul class="nav__dropdown" style="display: {{ Request::is('admin/badges*') || Request::is('admin/gamify_group*') || Request::is('admin/points*') || Request::is('admin/create/badges*') || Request::is('admin/badges/edit*') || Request::is('admin/create/gamify-groups*') || Request::is('admin/edit/gamify-groups*') || Request::is('admin/create/points*') || Request::is('admin/edit/points*') ? '' : 'none' }}" >

                        <li class=""><a class="{{ Request::is('admin/badges*') || Request::is('admin/create/badges*') || Request::is('admin/badges/edit*') ? 'active' : '' }}" href="{{route('badges')}}"><i class="fas fa-address-card"></i>Badges</a></li>

                        <li class=""><a class="{{ Request::is('admin/gamify_group*') || Request::is('admin/create/gamify-groups*')|| Request::is('admin/edit/gamify-groups*') ? 'active' : '' }}" href="{{route('gamify_group')}}"><i class="fas fa-address-card"></i>Gamify Groups</a></li>

                       <li class=""><a class="{{ Request::is('admin/points*') || Request::is('admin/create/points*')|| Request::is('admin/edit/points*') ? 'active' : '' }}" href="{{route('points')}}"><i class="fas fa-address-card"></i>Points</a></li>
                    </ul>
                </li>
            @endif
            <!-- end reward point -->
            @if($user->type =="mentor" || $user->type =="corporate")
            <li class="submenu lev1">
                   <a href="javascript:void(0)" class="{{ (Request::is('events*','users*') ) ? 'active' : '' }} sidebar-dropdown"><i class="fa fa-industry"></i>Virtualbooth<span><i class="fas fa-chevron-right"></i></span></a>
                <ul class="nav__dropdown" style="display: {{ (Request::is('contact*','users*') ) ? '' : 'none' }};">
                        <li class=""><a class="{{ Request::is('events*') ? 'active' : '' }}" href="{{route('virtualbooth.events')}}"><i class="fas fa-photo-video"></i>Events</a></li>
                </ul>
            </li>
            @endif
            @if($user->type =="mentor" || $user->type =="admin" || $user->type =="corporate")
            <li class="submenu lev1">
                   <a href="javascript:void(0)" class="{{ (Request::is('contact*','users*') ) ? 'active' : '' }} sidebar-dropdown"><i class="fas fa-bolt"></i>Brain Trust<span><i class="fas fa-chevron-right"></i></span></a>
                <ul class="nav__dropdown" style="display: {{ (Request::is('contact*','users*') ) ? '' : 'none' }};">
                    @if(in_array("manage_contacts",$permissions) || $user->type =="admin")
                        <li class=""><a class="{{ Request::is('contact*') ? 'active' : '' }}" href="{{route('contacts')}}"><i class="fas fa-address-card"></i>Contacts</a></li>
                    @endif
                    <li class=""><a class="{{ (Request::is('users/favourites')) ? 'active' : '' }}" href="{{route('users.favourites')}}"><i class="fas fa-star"></i>All Stars </a></li>
                    @if(in_array("manage_domain_users",$permissions) || $user->type =="admin")
                    <li class=""><a class="{{ Request::is('users') ? 'active' : '' }}" href="{{route('users')}}"><i class="fas fa-users"></i>@if($user->type =="admin") Users @else My Mentees @endif</a></li>
                    @endif
                </ul>
            </li>
            <li class="submenu lev1">
                   <a href="javascript:void(0)" class="{{ (Request::is('podcast*','blog*','book*') ) ? 'active' : '' }} sidebar-dropdown"><i class="fas fa-sitemap"></i>Syndicate<span><i class="fas fa-chevron-right"></i></span></a>
            <ul class="nav__dropdown" style="display: {{ (Request::is('podcast*','blog*','book*') ) ? '' : 'none' }};">
                    @if(in_array("manage_blogs",$permissions) || $user->type =="admin")
                    <li><a class="{{ (Request::is('blog*') ) ? 'active' : '' }}"  href="{{route('blog.index')}}"><i class="fab fa-blogger-b"></i>Blogs </a></li>
                    @endif
                    @if(in_array("manage_podcast",$permissions) || $user->type =="admin" || $user->type =="mentor" ||  $user->type =="corporate")
                    <li><a class="{{ (Request::is('podcast*') ) ? 'active' : '' }}"  href="{{route('podcast.dashboard')}}"><i class="fas fa-podcast"></i>Podcasts</span></a></li>
                    @endif
                    @if(in_array("manage_book",$permissions) || $user->type =="admin")
                    <li><a class="{{ (Request::is('book*') ) ? 'active' : '' }}"  href="{{route('book.get')}}"><i class="fas fa-book"></i>Books</span></a></li>
                    @endif
            </ul></li>
            @endif

            @if($user->type =="corporate")
              <li><a  class="{{ (Request::is('') ) ? 'active' : '' }}" href="#"><i class="fas fa-search-location"></i>Applicant Tracker<span><i class="fas fa-chevron-right"></i></span></a></li>
            <li class="submenu lev1">
                   <a href="javascript:void(0)" class="{{ (Request::is('corporate*','certify.index*','corporate.certify.index','certify.corpurate.mycourses','wallet*') ) ? 'active' : '' }} sidebar-dropdown"><i class="fas fa-user-shield"></i>Tuition Assistance<span><i class="fas fa-chevron-right"></i></span></a>
            <ul class="nav__dropdown" style="display: {{ (Request::is('corporate*','certify.index*','certify.corpurate.mycourses','wallet*','corporate.certify.index') ) ? '' : 'none' }};">
                    <li><a class="{{ (Request::is('corporate*') ) ? 'active' : '' }}"  href="{{ route('corporate.dashboard')}}"><i class="fas fa-tachometer-alt"></i>Dashboard  </a></li>
					<li><a class="{{ (Request::is('corporate.certify.index*') ) ? 'active' : '' }}"  href="{{ route('corporate.certify.index')}}"><i class="fas fa-tachometer-alt"></i>Certify List  </a></li>
                    <li><a class="{{ (Request::is('certify.corpurate.mycourses') ) ? 'active' : '' }}"  href="{{ route('certify.corpurate.mycourses')}}"><i class="fas fa-border-all"></i>Catalog</span></a></li>
                    <li><a class="{{ (Request::is('wallet*') ) ? 'active' : '' }}"  href="{{ route('wallet.tutionrequest')}}"><i class="fas fa-book"></i>Tuition Requests</span></a></li>
            </ul></li>
            <li class="submenu lev1">
                   <a href="javascript:void(0)" class="{{ (Request::is('leads*','mylist') ) ? 'active' : '' }} sidebar-dropdown"><i class="fas fa-tags"></i>Impact Leads<span><i class="fas fa-chevron-right"></i></span></a>
            <ul class="nav__dropdown" style="display: {{ (Request::is('leads*','mylist') ) ? '' : 'none' }};">
                    <li><a class="{{ (Request::is('lead*') ) ? 'active' : '' }}"  href="{{route('lead.index')}}"><i class="fas fa-tachometer-alt"></i>Lead Subscriptions  </a></li>
                    <li><a class="{{ (Request::is('mylist*') ) ? 'active' : '' }}"  href="{{route('lead.mylead')}}"><i class="fas fa-th-list"></i>My List</span></a></li>
            </ul></li>
            @endif
            <li class="submenu lev1">
                   <a href="javascript:void(0)" class="{{ (Request::is('photo-booth*','schedule*','meeting*','apps*','program*','admin/program/category','admin/program*','admin/question*','admin/approval_listing*','admin/programable_question*','survey/custom*','support*','chore*','autoresponder*','assessment*','petition*','shop*','wallet*','ivr','departments*','ivr-numbers*','ivrsetting*','ivr/voice-notification*','call-logs*','voice-mail-logs*')  ) ? 'active' : '' }} sidebar-dropdown"><i class="fab fa-microsoft"></i>Apps<span><i class="fas fa-chevron-right"></i></span></a>
            <ul class="nav__dropdown" style="display: {{ (Request::is('photo-booth*','schedule*','meeting*','apps*','program*','admin/program/category','admin/program*','admin/question*','admin/approval_listing*','admin/programable_question*','survey/custom*','support*','chore*','autoresponder*','assessment*','petition*','shop*','wallet*','ivr','departments*','ivr-numbers*','ivrsetting*','ivr/voice-notification*','call-logs*','voice-mail-logs*') ) ? '' : 'none' }};">
			  @if($user->type =="mentee" )
			  <li><a  class="{{ (Request::is('certify*') ) ? 'active' : '' }}" href="{{route('certify.index')}}"><i class="fab fa-wpbeginner"></i>Courses </a></li>
		  @endif
                     @if($user->type =="mentor" || $user->type =="admin" || $user->type =="corporate")
                     <li><a class="{{ (Request::is('donation*') ) ? 'active' : '' }}"  href="{{route('donation.dashboard')}}"><i class="fas fa-hand-holding-usd"></i>Donors <span></a></li>
                            @endif

                    <li class="submenu lev2">
                            <a href="javascript:void(0)" class="{{ (Request::is('schedule*','meeting*') ) ? 'active' : '' }} sidebar-dropdown"><i class="fas fa-calendar-alt"></i>Bookings<span><i class="fas fa-chevron-right"></i></span></a>
                        <ul class="nav__dropdown" style="display: {{ (Request::is('schedule*','meeting*') ) ? '' : 'none' }};">
                             <li><a  class="{{ (Request::is('schedule/bookings*') ) ? 'active' : '' }}" href="{{route('meeting.schedules.booked')}}"><i class="fa fa-clock"></i>Booking</a></li>
                               @if(in_array("book_appointment",$permissions) || $user->type =="admin")
                            <li><a  class="{{ (Request::is('meeting*') ) ? 'active' : '' }}" href="{{route('meeting.schedules.index')}}"><i class="fab fa-meetup"></i>Schedule</a></li>
                              @endif
                        </ul>
                    </li>


                    @if(checkPlanModule('ivr_settings'))
                        <li class="submenu lev2">
                            <a href="javascript:void(0)" class="{{  Request::is('ivr/*') || Request::is('departments*') || Request::is('ivr-numbers*') || Request::is('ivrsetting*') || Request::is('ivr/voice-notification*')   ||  Request::is('call-logs*') || Request::is('voice-mail-logs*')  ? 'active' : '' }} sidebar-dropdown"><i class="fas fa-phone"></i>Ivr<span><i class="fas fa-chevron-right"></i></span></a>
                            <ul class="nav__dropdown" style="display: {{ Request::is('ivr-numbers*') || Request::is('departments*') ||  Request::is('ivrsetting*') || Request::is('ivr/voice-notification*')   ||  Request::is('ivr*') ||  Request::is('call-logs*') || Request::is('voice-mail-logs*') ? '' : 'none' }};">
                                <li class=""><a class="{{ Request::is('ivr') ? 'active' : '' }}" href="{{route('ivr')}}"><i class="fas fa-home"></i>Dashbaord</a></li>
                                <li class=""><a class="{{ Request::is('ivr-numbers') ? 'active' : '' }}" href="{{route('ivrsetting.twilio_numbers')}}"><i class="fas fa-list-alt"></i>My Numbers</a></li>
                                @if($user->type == 'admin')
                                <li class=""><a class="{{ Request::is('ivr-numbers/all*') ? 'active' : '' }}" href="{{route('ivrsetting.twilio_numbers.all')}}"><i class="fas fa-phone-alt"></i>All Numbers</a></li>
                                @endif
                                <li class=""><a class="{{ Request::is('ivrsetting*') ? 'active' : '' }}" href="{{route('ivrsetting.index')}}"><i class="fas fa-cog"></i>Ivr Setting</a></li>
                                <li class=""><a class="{{ Request::is('ivr/black-list*') ? 'active' : '' }}" href="{{route('blackList')}}"><i class="fas fa-times"></i>Blocked Numbers</a></li>
                                <li class=""><a class="{{ Request::is('ivr/after-hours*') ? 'active' : '' }}" href="{{route('ivr.after.hours.post')}}"><i class="fas fa-clock"></i>After Hours</a></li>
                                <li class=""><a class="{{ Request::is('ivr/voice-notification*') ? 'active' : '' }}" href="{{route('voice-notification')}}"><i class="fas fa-bell"></i>VoiceMail Notification</a></li>
                                <li class=""><a class="{{ Request::is('call-logs*') ? 'active' : '' }}" href="{{route('ivr.call_logs')}}"><i class="fas fa-history"></i>Call History</a></li>
                                <li class=""><a class="{{ Request::is('voice-mail-logs*') ? 'active' : '' }}" href="{{route('ivr.voice_mail_logs')}}"><i class="fas fa-phone"></i>Voicemail History</a></li>
                                <li class=""><a class="{{ Request::is('departments*') ? 'active' : '' }}" href="{{route('ivr.department_list')}}"><i class="fas fa-building"></i>Departments</a></li>
                            </ul>
                        </li>
                    @endif


                    @if(in_array("manage_meeting_appointments",$permissions) || $user->type =="admin")
                    <li class="submenu lev2">
                            <a href="javascript:void(0)" class="{{ (Request::is('program*','admin/program/category','admin/program*','admin/question*','admin/approval_listing*','admin/programable_question*') ) ? 'active' : '' }} sidebar-dropdown"><i class="fas fa-project-diagram"></i>Social Index<span><i class="fas fa-chevron-right"></i></span></a>
                        <ul class="nav__dropdown" style="display: {{ (Request::is('program*','admin/program/category','admin/program*','admin/question*','admin/approval_listing*','admin/programable_question*') ) ? '' : 'none' }};">
                            @if(in_array("manage_meeting_appointments",$permissions) || $user->type =="mentor" || $user->type =="corporate")
                            <li><a  class="{{ (Request::is('apply/program*') ) ? 'active' : '' }}" href="{{route('program.apply')}}"><i class="far fa-edit"></i>Request Access</a></li>
                             <li><a  class="{{ (Request::is('program*') ) ? 'active' : '' }}" href="{{route('program.list')}}"><i class="fas fa-th-list"></i>Listing </a></li>

                            @endif
                            @if($user->type =="admin")
                            <li> <a href="{{route('questions')}}" class="{{ Request::is('admin/question*') ? 'active' : '' }}"><i class="fas fa-check-double"></i>Approval Question</a>
                            </li>
                            <li><a href="{{route('programable_questions')}}" class="{{ Request::is('admin/programable_question') ? 'active' : '' }}"><i  style="float:left;" class="fas fa-question"></i>Programmable Question</a>
                            </li>
                            <li><a href="{{route('approval_listing')}}" class="{{ Request::is('admin/approval_listing') ? 'active' : '' }}"><i  style="float:left;" class="fab fa-blogger-b"></i>Approval Status</a>
                            </li>
                            <li> <a href="{{route('adminProgramlisting')}}" class="{{ Request::is('admin/program') ? 'active' : '' }}"><i  style="float:left;" class="fas fa-file-invoice"></i>Program</a>
                            </li>
                            <li>  <a href="{{route('program_category')}}" class="{{ Request::is('admin/program/category') ? 'active' : '' }}"><i class="fas fa-layer-group"></i>Category</a></li>
                            @endif
                        </ul>
                    </li>
                    @endif
                    @if(in_array("manage_courses",$permissions) || $user->type =="admin" )
                    <li><a  class="{{ (Request::is('certify*') ) ? 'active' : '' }}" href="{{route('certify.index')}}"><i class="fab fa-wpbeginner"></i>Courses </a></li>
                    @endif
                     <li><a  class="{{ (Request::is('assessment*') ) ? 'active' : '' }}" href="{{route('assessment.dashboard')}}"><i class="fa fa-assistive-listening-systems"></i>Assessments </a></li>

                    @if(in_array("manage_auto_responders",$permissions) || $user->type =="admin")
                    <li><a  class="{{ (Request::is('autoresponder*') ) ? 'active' : '' }}" href="{{route('autoresponder.index')}}"><i class="fa fa-audio-description"></i>Auto Responders </a></li>
                    @endif

                    <li><a  class="{{ (Request::is('shop*') ) ? 'active' : '' }}" href="{{route('shop')}}"><i class="fa fa-cart-plus"></i>Shop </a></li>


<!--                    <li><a  class="{{ (Request::is('wallet*') ) ? 'active' : '' }}" href="{{route('wallet')}}"><i class="fa fa-money-bill-alt"></i>Wallet </a></li>-->
                    <li><a  class="{{ (Request::is('petition*') ) ? 'active' : '' }}" href="{{route('petitioncustom.dashboard')}}"><i class="fa fa-check-circle"></i>Petitions </a></li>
                    <li><a  class="{{ (Request::is('survey/custom*') ) ? 'active' : '' }}" href="{{route('crmcustom.dashboard')}}"><i class="fa fa-question"></i>Surveys </a></li>

                   <li><a  class="{{ (Request::is('support*') ) ? 'active' : '' }}" href="{{ route('support.index') }}"><i class="fas fa-question-circle"></i>Helpdesk</a></li>
                   <li><a  class="{{ (Request::is('chore*') ) ? 'active' : '' }}" href="{{ route('chore.mydashboard') }}"><i class="fas fa-tasks"></i>Chores</a></li>

                    @if($user->type =="corporate" || $user->type =="admin")
                    <li><a  class="{{ (Request::is('photo-booth*') ) ? 'active' : '' }}" href="{{url('photo-booth')}}"><i class="fas fa-photo-video"></i>Photo Booth </span></a></li>
                    <li><a  class="{{ (Request::is('photobooth/dashboard*') ) ? 'active' : '' }}" href="{{url('photobooth/dashboard')}}"><i class="fa fa-industry" aria-hidden="true"></i>Photobooth Dashboard </span></a></li>

                    @endif
            </ul></li>
            @if($user->type =="corporate")
          
            @else
<!--            <li><a  class="{{ (Request::is('invoices') ) ? 'active' : '' }}" href="{{route('user.invoices')}}"><i class="fas fa-file-invoice"></i>Billing & Invoices <span><i class="fas fa-chevron-right"></i></span></a></li>-->
            @endif
<!--            @if(in_array("manage_email_templates",$permissions) || $user->type =="admin")
            <li><a  class="{{ (Request::is('email/template*') ) ? 'active' : '' }}" href="{{route('email_template.index')}}"><i class="fa fa-envelope"></i>Email Templates <span><i class="fas fa-chevron-right"></i></span></a></li>

            @endif-->
            @if($user->type =="admin")
            <li><a  class="{{ (Request::is('quotes*') ) ? 'active' : '' }}" href="{{route('quotes')}}"><i class="fas fa-comment-dots"></i>Quote<span><i class="fas fa-chevron-right"></i></span></a></li>

            @endif
<!--            @if($user->type !="admin")
            <li><a  class="{{ (Request::is('review*') ) ? 'active' : '' }}" href="{{route('review.listing')}}"><i class="fas fa-eye"></i>Reviews<span><i class="fas fa-chevron-right"></i></span></a></li>

            @endif-->


            @if($user->type =="admin")
            <li class=""><a class="{{ (Request::is('admin/task/categories') ) ? 'active' : '' }}" href="{{route('task.categories')}}"><i class="fa fa-database"></i>Task Category <span><i class="fas fa-chevron-right"></i></span></a></li>
            @endif
            @if($user->type =="admin")
            <li class=""><a class="{{ (Request::is('admin/pathway*') ) ? 'active' : '' }}" href="{{route('pathway.entities')}}"><i class="fa fa-university" aria-hidden="true"></i>Pathway Entities <span><i class="fas fa-chevron-right"></i></span></a></li>
            <li class=""><a class="{{ (Request::is('bls/industry*') ) ? 'active' : '' }}" href="{{route('bls.category')}}"><i class="fa fa-business-time" aria-hidden="true"></i>BLS Industries <span><i class="fas fa-chevron-right"></i></span></a></li>
            @endif
            @if($user->type =="admin")
            <li class=""><a class="{{ (Request::is('admin/employer') ) ? 'active' : '' }}" href="{{route('employer')}}"><i class="fa fa-industry" aria-hidden="true"></i>Employer <span><i class="fas fa-chevron-right"></i></span></a></li>
            @endif


            @if( $user->type =="admin")
            <li><a class="{{ (Request::is('plans') ) ? 'active' : '' }}"  href="{{route('plans.index')}}"><i class="fas fa-clipboard-check"></i>Plans <span><i class="fas fa-chevron-right"></i></span></a></li>
            <li><a class="{{ (Request::is('newsletter') ) ? 'active' : '' }}"  href="{{route('newsletter.index')}}"><i class="fas fa-envelope-open-text"></i>Newsletter <span><i class="fas fa-chevron-right"></i></span></a></li>

            @endif

            @if(in_array("manage_partner",$permissions) || $user->type =="admin")
            <li><a class="{{ (Request::is('partner*') ) ? 'active' : '' }}"  href="{{route('partner.index')}}"><i class="far fa-handshake"></i>Partner <span><i class="fas fa-chevron-right"></i></span></a></li>
            @endif

<!--            @if(in_array("manage_pages",$permissions) || $user->type =="admin")
            <li class=""><a class="{{ Request::is('cms') ? 'active' : '' }}" href="{{route('cms.index')}}"><i class="far fa-file-alt"></i>CMS Pages <span><i class="fas fa-chevron-right"></i></span></a></li>
            @endif-->
            @if($user->type =="admin")
            <li class=""><a class="{{ (Request::is('faq*') ) ? 'active' : '' }}" href="{{route('faq.index')}}"><i class="far fa-question-circle"></i>FAQ's <span><i class="fas fa-chevron-right"></i></span></a></li>
            @endif

            @if(in_array("manage_sub_domain",$permissions) && $user->type !="admin")
            <!-- <li class=""><a class="{{ (Request::is('site/settings') ) ? 'active' : '' }}" href="{{route('site.settings')}}"><i class="fa fa-cogs"></i>Site Settings <span><i class="fas fa-chevron-right"></i></span></a></li> -->
            @endif
            <!--<li class=""><a class="{{ (Request::is('help*') ) ? 'active' : '' }}" href="#"><i class="fas fa-info-circle"></i>Help <span><i class="fas fa-chevron-right"></i></span></a></li>-->
{{--             @if($user->type =="admin")--}}
                 <li class="submenu lev1">
                     <a href="javascript:void(0)" class="{{ (Request::is('program*') ) ? 'active' : '' }} sidebar-dropdown">
                         <i class="fas fa-globe-asia"></i>Job Point<span><i class="fas fa-chevron-right"></i></span>
                     </a>
                     <ul class="nav__dropdown" style="display: none;">
                         <li class="{{ Request::is('jobpoint/dashboard') ? 'active' : '' }}">
                             <a href="{{route('jobpoint.dashboard')}}"><i style="float:left;" class="fas fa-circle"></i>Dashboard</a>
                         </li>
                         <li class="{{ Request::is('/candidates') ? 'active' : '' }}">
                             <a href="{{route('admin.candidates')}}"><i style="float:left;" class="fas fa-circle"></i>Candidates</a>
                         </li>
                         <li class="{{ Request::is('job/career-page') ? 'active' : '' }}">
                             <a href="{{route('job.careerpage')}}"><i style="float:left;" class="fas fa-circle"></i>Career Page</a>
                         </li>
                         <li class="{{ Request::is('appsetting') ? 'active' : '' }}">
                             <a href="{{route('app.setting')}}"><i style="float:left;" class="fas fa-circle"></i>App Settings</a>
                         </li>
                         <li class="{{ Request::is('admin/programable_question') ? 'active' : '' }}">
                             <a href="{{route('job.setting')}}"><i style="float:left;" class="fas fa-circle"></i>Job Settings</a>
                         </li>

                     </ul>
                 </li>
{{--             @endif--}}

<!--            <li>
                <a href="{{ route('logout') }}" onclick="event.preventDefault();
                        document.getElementById('logout-form').submit();" ><i class="fas fa-sign-out-alt"></i>Logout <span><i class="fas fa-chevron-right"></i></span></a>
            </li>-->
        </ul>
    </div>
</div>

