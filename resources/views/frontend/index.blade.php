@extends('layout.stemx.mainlayout')
@section('content')		

    @php
    $mainMenu = \App\Menu::get_menus();
     $logo =  \App\SiteSettings::logoSetting();
     $logoTxt=\App\SiteSettings::logotext();
        if(!empty($logo)){
           $logo_favicon = json_decode($logo->value,true);
        }else{
            $logo_favicon = array();
        }
        $domain_user=get_domain_user();
@endphp 
 @php
      $fronend_settings=\App\SiteSettings::getValByName('frontend_profiles');
                               
      @endphp
<div class="container-fluid">
    <div class="hero-section">

        <!-- row end -->
        <div class="row">
            <div class="col-12 col-md-12 main-hero p-0">
                <div class="heroo-sect ">
                    <div class="row d-flex align-items-center">
                        <div class="col-12 col-md-12 col-lg-7 mb3 heroleft">
                            <div class="hero-left-content">
                                <h2 class="hero-heading d-none d-md-block">
                                    The Leading Stem<br>Engagement and<br> Analytics Platform.
                                </h2>
                                <h2 class="hero-heading d-block d-md-none">The Leading Platform </h2>
                                <p class="hero-p">Discover pathways for impact, digital equity <br> and transformation, ready to scale at the speed of thought. </p>

                                <div class="search-box" >
                                    <form action="{{route('search.profile')}}" method="GET" id="search_form">
                                        <div class="row">
<!--                                            <div class="col-4 col-md-3 col-lg-4 location">
                                                <label  for="location">Location</label>
                                                <div class="input-group mb-2">
                                                    <div class="input-group-prepend">
                                                        <div class="input-group-text">
                                                         	<img src="{{ asset('assets/main/images/map-line.png')}}" class="img-fluid"> 
                                                            <i class="fas fa-map-marker-alt"></i>
                                                        </div>
                                                    </div>
                                                    <input type="text" class="form-control" id="location" placeholder="New York, USA">
                                                </div>
                                            </div>-->
                                            <!-- location end -->

                                            <div class="col-12 col-md-12 col-lg-10 location">
                                                <label  for="Education-plateform">Engage with Mentors. Meet Your Goals.</label>
                                                <div class="input-group mb-2">
                                                    <div class="input-group-prepend">
                                                        <div class="input-group-text">
                                                        <!-- 	<img src="{{ asset('assets/main/images/map-line.png')}}" class="img-fluid"> -->
                                                            <i class="fas fa-home"></i>
                                                        </div>
                                                    </div>
                                                    <input type="text" class="form-control" required="" id="search_input" name="search_input" minlength="3" maxlength="50" id="Education-plateform" placeholder="Search Mentor, State, Country, etc">
                                                </div>
                                                <h5 class="text-danger" id="search_input_error"></h5>
                                            </div>
                                            <!-- education plateform end -->

                                            <div class="col-12 col-md-2 text-center text-md-right mt-3 mt-md-none" onclick="event.preventDefault();
                                                var inputsearch=document.getElementById('search_input');                                               
                                                     if(inputsearch.checkValidity()){ document.getElementById('search_form').submit(); }else{ document.getElementById('search_input_error').innerHTML ='*Valid input between 3 to 50 characters required';}">
                                                <i class="fa fa-search searchicon"></i>
                                            </div>

                                        </div>
                                        <!-- row end -->
                                    </form>
                                </div>
                                <!-- search-box end -->
                            </div>
                        </div>
                       
                        @if( array_key_exists("homebackground",$logo_favicon))
                        <div class="col-12 col-md-12 col-lg-5 mb3 hero-right text-center" style="background-repeat: no-repeat; background-size: cover;background-position: center;  background-image:url({{ asset('storage').'/logo/'.$logo_favicon['homebackground'] }})">

                        @else
                        <div class="col-12 col-md-12 col-lg-5 mb3 hero-right text-center" style="background-repeat: no-repeat; background-size: cover;background-position: center;  background-image:url('{{ URL::to('/') }}assets/main/images/hero-image.png')">


                        @endif
                   
                        <img src="{{ asset('assets/main/images/hero-girl.png')}}" class="img-fluid d-block d-lg-none m-auto">
                        </div>
                    </div>
                    
                    <!-- inside row end -->
  @if(!empty($fronend_settings['enable_frontend_partners']) && $fronend_settings['enable_frontend_partners'] == 'on') 
                    @if(!empty($partners))
                    <div class="row mt-5 mt-md-auto">
                        <div class="col-12 logos-col">
                            <div class="container">
                                <div class="logos-slider">
                                @foreach($partners as $partner)
                                <img src="{{asset('storage')}}/partner/{{ $partner->logo }}" class="img-fluid" alt="slack">
                                @endforeach
                                </div>
                                <!-- logos slider end -->
                            </div>
                            <!-- container end -->
                        </div>
                    </div>
                    <!-- row end -->
                    @endif
                    @endif

                    <div class="row">
                        <div class="col-12 text-center pt50">
                            <div class="container">
                                <h3 class="sub-heading-three">Cradle to Careers</h3>
                                <h2 class="sub-heading-one">Workforce Readiness</h2>
                                <p class="gen-p d-none d-md-block">
                                    Connect with Students and Stemterns on a personalized level through high impact engagement boards and live video. Join a first-of-its-kind platform, where Students and Stemterns can socialize, collaborate, and #futureproof their goals, all in an atmosphere that is passionate about STEM.
                                </p>
                                <p class="gen-p d-block d-md-none">
                                    Are you looking to join online institutions? Now it's very  simple, Sign up with mentoring
                                </p>

                                <div class="row mt-4">
                                    <div class="col-12 col-md-12 circles-section ">
                                        <div class="row d-flex align-items-center">
                                            <div class="col-12 col-lg-4 text-center forcenter firstone">
                                                <div class="pl-n55">
                                                    <span class="gray-label">K-12</span>
                                                    <h5 class="gray-title">Let's Plan It Out</h5>
                                                    <p class="gen-p thisp">
                                                        It's not a one-size-fits-all process. Work with a Mentor to plan your goals with confidence! 
                                                    </p>
                                                </div>
                                            </div>
                                            <!-- signup end -->

                                            <div class="col-12 col-lg-4 text-center forcenter secondone">
                                                <div class="pl-n55">
                                                    <span class="gray-label">COLLEGE, VOCATIONAL, & ROTC </span>
                                                    <h5 class="gray-title">Future Proof It</h5>
                                                    <p class="gen-p thisp">
                                                        Explore over 5,300 colleges and universities. Discover  A pathway to School and Service.
                                                    </p>
                                                </div>
                                            </div>
                                            <!-- collaborate end -->
                                            <div class="col-12 col-lg-4 text-center forcenter thirdone">
                                                <div class="pl-0 pl-lg-5">
                                                    <span class="gray-label">CAREERS & ENTREPRENEURSHIP</span>
                                                    <h5 class="gray-title">Turn It Into Prosperity</h5>
                                                    <p class="gen-p thisp">
                                                        Land your dream career or start your own business.
                                                    </p>
                                                </div>
                                            </div>
                                            <!-- collaborate end -->


                                        </div>
                                    </div>
                                </div>
                                <!-- rown end -->

                            </div>
                            <!-- container end -->
                        </div>
                    </div>
                    <!-- row end -->
                </div>
            </div>
            <!-- col end -->
        </div>
        <!-- main-hero end -->
    </div>
    <!-- hero section end -->

    
     
    <div class="row">
        
        <div class="col-12 popular-mentors">
            @if(!empty($fronend_settings['enable_frontend_profiles']) && $fronend_settings['enable_frontend_profiles'] == 'on')                            
            <div class="container">
                <div class="text-center">
                    <h3 class="sub-heading-three">The Quest for Digital Equity</h3>
                    <h2 class="sub-heading-one">Competition makes us faster. Collaboration makes us smarter and stronger.</h2>
                    <p class="gen-p d-none d-md-block">
                        Creating Digital Equity for Students Requires a Villiage Mindset, Become a Mentor Today!
                    </p>
                    <p class="gen-p d-block d-md-none">
                        Do you want to move on next step? Choose your most popular leaning mentors, it will help you to achieve your professional goals. 
                    </p>
                </div>
                <!-- text center end -->

                <div class="forslider ">
                    @foreach($fronend_settings['frontend_profiles'] as $i=>$row)
                    @php
                    $frontuser=\App\User::find($row);
                    @endphp
                    @if($i%2 != 0)
                    <div>
                        <div class="cardd">
                            <a href="{{route('profile',["id"=>encrypted_key($frontuser->id,"encrypt")])}}">
                            <img src="{{$frontuser->getAvatarUrl()}}" class="img-fluid">
                             </a>
                            <div class="cadd-details">
                             <a href="{{route('profile',["id"=>encrypted_key($frontuser->id,"encrypt")])}}"> <span class="mentor-name">{{$frontuser->name}}</span></a>
                                <p class="gen-p">{{$frontuser->getJobTitle()}}</p>
                                <div class="row ">
                                    <div class="col-8 p-0 left-location">
                                        <i class="fas fa-map-marker-alt"></i>
                                        <span class="location-text">{{$frontuser->state}}, {{$frontuser->country}}</span>
                                    </div>
                                    <div class="col-4 text-right text-md-center">
                                        <i class="fa fa-star staricon" ></i>
                                        <span class="rating-text">{{$frontuser->average_rating}}</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- fist cadd end/ -->
                    </div>
                    @else
                    <!-- first end -->
                    <div class="even-slide ">
                        <div class="cardd">
                        <a href="{{route('profile',["id"=>encrypted_key($frontuser->id,"encrypt")])}}">
                            <img src="{{$frontuser->getAvatarUrl()}}" class="img-fluid">
                        </a>
                            <div class="cadd-details">
                                <a href="{{route('profile',["id"=>encrypted_key($frontuser->id,"encrypt")])}}">
                                <span class="mentor-name">{{$frontuser->name}}</span>
                                </a>
                                <p class="gen-p">{{$frontuser->getJobTitle()}}</p>
                                <div class="row ">
                                    <div class="col-8 p-0 left-location">
                                        <i class="fas fa-map-marker-alt"></i>
                                        <span class="location-text">{{$frontuser->state}}, {{$frontuser->country}}</span>
                                    </div>
                                    <div class="col-4 text-right text-md-center">
                                        <i class="fa fa-star staricon" ></i>
                                        <span class="rating-text">{{$frontuser->average_rating}}</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- second cadd end/ -->
                    </div>
                    @endif
                    @endforeach
                    
                    <!-- fourth end -->
                </div>
                <!-- forslider end -->
            </div>
            <!-- container end -->
             @endif
        </div>
        <!-- popular-mentors end -->
        
    </div>
    <!-- row end -->
   
  @if(!empty($fronend_settings['enable_frontend_course_categories']) && $fronend_settings['enable_frontend_course_categories'] == 'on') 
    <div class="row">
        <div class="col-12 col-md-12 learning-paths py-120">
            <div class="container">
                <div class="text-left">
                    <h3 class="sub-heading-three">#futureproof</h3>
                    <h2 class="sub-heading-one">The Remote Learning Experience </h2>
                    <p class="gen-p">
                        The priority strategic areas of our digital equity work are:
                        Skills training, Connectivity, Devices & Technical Support
                    </p>
                </div>
                <!-- text left end -->
                <div class="forgrid">
                    @php
                    
          $categories= \App\CertifyCategory::select('certify_categories.id','certify_categories.name','certify_categories.icon')
                  ->join('certifies as c','c.category','certify_categories.id')
                  ->groupBy('certify_categories.id','certify_categories.name','certify_categories.icon')
                  ->where('c.user_id',$domain_user->id)
                  ->get();
                    @endphp
                    @foreach($categories as $i=>$row)
                    @if($i<=9)
                      <a href="{{url('search/courses')}}?category={{$row->id}}">
                    <div class="card-type">
                        <div>
                            @if (file_exists(storage_path() . '/certify/icon/' . $row->icon))                             
                            <img src="{{ asset('storage/certify/icon/' . $row->icon)}}" class="icones img-fluid" alt="Icon">
                        @else
                            <img src="{{ asset('assets/main/images/icon-1.png')}}" class="icones img-fluid" alt="Icon">
                        @endif
                            <p class="icon-text">{{$row->name}}</p>
                        </div>
                    </div>
                      </a>
                @endif
                    @endforeach
                    

                    <div class="card-type thiscard">
                        <div>
                            <a href="{{url('search/courses')}}" class="plustenlink">
                                <span class="plusten">+{{!empty($categories)?count($categories):0}}</span>
                                <span class="view-all">view all</span>
                            </a>
                        </div>
                    </div>
                    <!-- 10 end -->

                </div>
                <!-- forgrid end -->
            </div>
            <!-- container end -->
        </div>
    </div>
  @endif
    <!-- col end -->
@if(!empty($fronend_settings['enable_frontend_blogs']) && $fronend_settings['enable_frontend_blogs'] == 'on') 
    <div class="row">
        <div class="col-12 col-md-12 blogandnews">
            <div class="container">
                <div class="text-center">
                    <h3 class="sub-heading-three">Digital Equity - Keeping You Connected</h3>
                    <h2 class="sub-heading-one">The Blogs & News</h2>
                    <p class="gen-p">
                        Digital Equity: Ensuring Equitable Access  <br>to Education, Technology and Internet Access.
                    </p>
                </div>
                <!-- text-center end -->
                <div class="row mt-60">
                    @php 
                    $date=date('Y-m-d');
                    $blogs=\App\Blog::inRandomOrder()->where('featured',1)->where('user_id',$domain_user->id)->whereRaw('(expiry_status IS Null OR expiry_date >="'.$date.'")')->whereRaw('(status="Published" OR prepublish_date <="'.$date.'")')->limit(3)->get();
                    @endphp
                    @foreach($blogs as $row)
                    <div class="col-12 col-md-6 col-lg-4 mb3">
                        <div class="blogcard">
                               <a href="{{route('blog.details',encrypted_key($row->id,"encrypt"))}}">
                             @if(file_exists( storage_path().'/blog/'.$row->image ) && !empty($row->image))
                                        <img src="{{asset('storage')}}/blog/{{ $row->image }}" class="img-fluid " alt="blog imge">
                                        @else
                                        <img class="img-fluid" src="{{ asset('assets/img/blog/blog-02.jpg') }}" alt="blog">
                                        @endif
                               </a>
                            <div class="row  mt-3">
                                <div class="col-6">
                                    <span class="bloger-name">{{ $row->user->name??'' }}</span>
                                </div>
                                <div class="col-6 text-right">
                                    <i class="far fa-calendar-alt blog-date pr-2"></i>
                                    <span class="blog-date">{{date('F d, Y', strtotime($row->created_at))}}</span>
                                </div>
                            </div>
                            <!-- row end -->
                            <div class="row">
                                <div class="col-12">
                                    <h4 class="blog-title">  <a href="{{route('blog.details',encrypted_key($row->id,"encrypt"))}}" class="blog-link">{{substr($row->title,0,24)}}</a></h4>
                                    <p class="blog-desc">
                                    <h3>  {!! html_entity_decode(ucfirst(substr($row->article,0,70)), ENT_QUOTES, 'UTF-8') !!}</h3>
                                    </p>
                                </div>
                            </div>
                        </div>
                        <!-- card end -->
                    </div>
                    <!-- first one end -->
                    @endforeach

                    
                </div>

                <div class="text-center pt-5">
                    <a href="{{url('search/blogs')}}" class="view-all-btn">View All</a>
                </div>
            </div>
            <!-- container end -->
        </div>
        <!-- blogandnews end -->
    </div>
@endif
    <!-- blog row end -->
@if(!empty($fronend_settings['enable_frontend_newsletter']) && $fronend_settings['enable_frontend_newsletter'] == 'on') 
    <div class="row">
        <div class="col-12 newsletter-section">
            <div class="container">
                <div class="row">
                    <div class="col-12 col-lg-5 mb3 text-center text-lg-left  p-0">
                        <h2 class="subscribe-text">Subscribe To <span class="orange-text">Stem X Weekly</span> <br>
                            To Receive the Latest News
                        </h2>
                    </div>
                    <!-- left side end -->
                    <div class="col-12 col-lg-7 forformm p-0">
                        <form method="POST" id="newsletter-subscribe" action="{{url('subscribe')}}" enctype="multipart/form-data">
                              @csrf
                            <label class="sr-only" for="inlineFormInputGroup">Username</label>
                            <div class="input-group mb-2">
                                <div class="input-group-prepend">
                                    <div class="input-group-text thisinpugrou">
                                        <i class="fa fa-envelope pr-2 pr-md-4"></i> |
                                    </div>
                                    
                                </div>
                                <input type="email" name="email" class="form-control" id="inlineFormInputGroup" required="" placeholder="Enter Your Email Address......">
                                
                                <div class="input-group-prepend text-center">
                                    <!-- <div  class="input-group-text subscribtnn text-center" onclick="event.preventDefault();
                                        var inputemailnewsletter=document.getElementById('inlineFormInputGroup');                                               
                                                     if(inputemailnewsletter.checkValidity()){ document.getElementById('newsletter-subscribe').submit(); }else{ document.getElementById('email_input_error').innerHTML ='*Valid email is required';}"
                                                  >
                                        <i class="fas fa-paper-plane pr-2"> </i>
                                        <span>Subscribe</span>
                                    </div> -->
                                    <div  class="input-group-text subscribtnn text-center" onclick="onClick(event);"
                                                  >
                                        <i class="fas fa-paper-plane pr-2"> </i>
                                        <span>Subscribe</span>
                                    </div>
                                </div>
                               
                              
                    </div>
                              <h5 class="text-danger text-center" id="email_input_error"></h5>
                        </form>
                </div>
            </div>
        </div>
    </div>
    <!-- newsletter end -->
</div>
@endif

</div>
@endsection
<!-- contianer fluid end -->
@push('script')
<script src="https://www.google.com/recaptcha/api.js?render=6LcGnBwcAAAAAHY2J4EwqpoYLAODaUnKioLdxmrz"></script>
<script>

 function onClick(e) {
        e.preventDefault();
        grecaptcha.ready(function() {
          grecaptcha.execute('6LcGnBwcAAAAAHY2J4EwqpoYLAODaUnKioLdxmrz', {action: 'submit'}).then(function(token) {
           var inputemailnewsletter=document.getElementById('inlineFormInputGroup');                                               
             if(inputemailnewsletter.checkValidity()){ 
                 document.getElementById('newsletter-subscribe').submit();
                  }else{ 
                 document.getElementById('email_input_error').innerHTML ='*Valid email is required';
                 }
          });
        });
      }
 
 </script>
@endpush