<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    
    <link rel="stylesheet" href="{{ asset('public/demo23/css/bootstrap.css')}}">
    <link rel="stylesheet" href="{{ asset('public/demo23/fonts/icon-font/css/style.css')}}">
    <link rel="stylesheet" href="{{ asset('public/demo23/fonts/typography-font/typo.css')}}">
    <link rel="stylesheet" href="{{ asset('public/demo23/fonts/fontawesome-5/css/all.css')}}">
    <!-- Plugin'stylesheets  -->
    <link rel="stylesheet" href="{{ asset('public/demo23/plugins/aos/aos.min.css')}}">
    <link rel="stylesheet" href="{{ asset('public/demo23/plugins/fancybox/jquery.fancybox.min.css')}}">
    <link rel="stylesheet" href="{{ asset('public/demo23/plugins/nice-select/nice-select.min.css')}}">
    <link rel="stylesheet" href="{{ asset('public/demo23/plugins/slick/slick.min.css')}}">
    <link rel="stylesheet" href="{{ asset('public/demo23/plugins/ui-range-slider/jquery-ui.css')}}">
    <!-- Vendor stylesheets  -->
    <link rel="stylesheet" href="{{ asset('public/demo23/css/main.css')}}">
    <!-- Custom stylesheet -->
  
</head>



{{-- Star Rating --}}
<style>
    .star-rating {
        direction: rtl;
    }

    .star-rating input[type=radio] {
        /* display: none; */
        opacity: 0;
        width: 1px;
    }

    .star-rating label {
        color: #bbb;
        font-size: 30px;
        padding: 0;
        cursor: pointer;
        -webkit-transition: all .3s ease-in-out;
        transition: all .3s ease-in-out;
        line-height: 0px;
        margin: 0;
        margin-right: 3px;
    }

    .star-rating label:hover,
    .star-rating label:hover ~ label,
    .star-rating input[type=radio]:checked ~ label {
        color: #f2b600
    }

    .ctm_payment {
        padding: 16px;
    }

    a.page.current {
        background-color: #2f55d4;
    }

    @media (max-width: 991px) {
        #topnav .navigation-menu > li > a {
            color: #3c4858 !important;
        }
    }
</style>



<body>
<div class="site-wrapper overflow-hidden ">
    @if($template->content)
  <div class="job-details-content pt-8 pl-sm-9 pl-6 pr-sm-9 pr-6 pb-10 light-mode-texts">
                                    <div class="row">
                                        <div class="col-xl-11 col-md-12 pr-xxl-9 pr-xl-10 pr-lg-20">
                                            <div class="">
                                                
                                                <p class="font-size-4 text-black-2 mb-7">{!! html_entity_decode($template->content, ENT_QUOTES, 'UTF-8') !!}</p>


                                            <a class="btn btn-success text-uppercase btn-medium rounded-3 w-180 mr-4 mb-5" href="{{url('/learn')}}"     >Learn Now</a>

                                            </div>

                                        </div>
                                    </div>
                                </div>
    @endif
    

@if($template->data->count() > 0)
@foreach($template->data as $row)
<div class="mb-8 pagify-child">
                <!-- Single Featured  -->
                <div class="pt-9 px-xl-9 px-lg-7 px-7 pb-7 light-mode-texts bg-white rounded hover-shadow-3 ">
                  <div class="row">
                    <div class="col-md-6">
                      <div class="media align-items-center">
                        <div class="square-72 d-block mr-8">
                            @if(file_exists( storage_path().'/certify/'.$row->image)  && !empty($row->image))
                            <a  href="{{ route('learn.detail',['id'=>encrypted_key($row->id,'encrypt')]) }}">  
                                <img src="{{asset('storage')}}/certify/{{ $row->image }}" class="card-img-top "  alt="..."> </a>
                @else
                    <img src="{{ asset('public')}}/demo23/image/patterns/globe-pattern.png" class="card-img-top "   alt="img">
                @endif
                          <!--<img src="{{ asset('public/demo23/image/l2/png/featured-job-logo-1.png')}}" alt="">-->
                        </div>
                        <div>
                          <h3 class="mb-0"><a class="font-size-6 heading-default-color" href="{{ route('learn.detail',['id'=>encrypted_key($row->id,'encrypt')]) }}">{!! html_entity_decode(ucfirst($row->name), ENT_QUOTES, 'UTF-8') !!}</a></h3>
                          <a href="#" class="font-size-3 text-default-color line-height-2">
                              Certification in just {{$row->duration}} {{$row->period}}
                
                          </a>
                        </div>
                      </div>
                    </div>
                    <div class="col-md-6 text-right pt-7 pt-md-5">
                      <div class="media justify-content-md-end">
                        <div class="image mr-5 mt-2">
                          <img src="{{ asset('public/demo23/image/svg/icon-fire-rounded.svg')}}" alt="">
                           
                        </div>
                        <p class="font-weight-bold font-size-7 text-hit-gray mb-0">
                           @if(!empty($row->sale_price))
                            <span
                        class="text-black-2">${{ $row->sale_price }} /
                            </span> <strike> {{ $row->price }}</strike>
                            @else
                            <span
                        class="text-black-2">${{ $row->price }} 
                            </span>
                            @endif 
                        </p>
                      </div>
                    </div>
                  </div>
                  <div class="row pt-8">
                    <div class="col-md-7">
                      <ul class="d-flex list-unstyled mr-n3 flex-wrap">
                       <li>
                          <a class="bg-regent-opacity-15 min-width-px-96 mr-3 text-center rounded-3 px-6 py-1 font-size-3 text-black-2 mt-2" href="#">  
                              @if(getChapterCountOfCertify($row->id))
                    <b>Classes: </b> {{getChapterCountOfCertify($row->id)}} Session(s)
                    @endif
                    </a>
                        </li>
                       <li>
                          <a class="bg-regent-opacity-15 min-width-px-96 mr-3 text-center rounded-3 px-6 py-1 font-size-3 text-black-2 mt-2" href="#">                              
                    @if($row->pennfoster  == '1')
                        Exams By PENN FOSTER
                        @else
                      
                    @endif</a>
                        </li>

                      </ul>
                    </div>
                    <div class="col-md-5">
                      <ul class="d-flex list-unstyled mr-n3 flex-wrap mr-n8 justify-content-md-end">

                        <li class="mt-2 mr-8 font-size-small text-black-2 d-flex">
                          <span class="mr-4" style="margin-top: -2px"><img src="{{ asset('public/demo23/image/svg/icon-suitecase.svg')}}" alt=""></span>
                          <span class="font-weight-semibold"> {{!empty($row->category) && !empty($row->getCategoryName($row->category)) ? $row->getCategoryName($row->category) :'No category'}}</span>
                        </li>
                        <li class="mt-2 mr-8 font-size-small text-black-2 d-flex">
                          <span class="mr-4" style="margin-top: -2px"><img src="{{ asset('public/demo23/image/svg/icon-clock.svg')}}" alt=""></span>
                          <span class="font-weight-semibold">{{time_elapsed($row->created_at)}}</span>
                        </li>
                      </ul>
                    </div>
                  </div>
                </div>
                <!-- End Single Featured  -->
              </div>
@endforeach


@else
<div class="text-center errorSection">
    <span>No Data Found</span>
</div>
@endif








 <footer class="footer bg-ebony-clay dark-mode-texts">
      <div class="container">
        <!-- Cta section -->
        <div class="pt-11 pt-lg-20 pb-13 pb-lg-20 border-bottom border-width-1 border-default-color-2">
          <div class="row justify-content-center ">
            <div class="col-xl-7 col-lg-12" data-aos="fade-right" data-aos-duration="800" data-aos-once="true">
              <!-- cta-content start -->
              <div class="pb-xl-0 pb-9 text-xl-left text-center">
                <h2 class="text-white font-size-8 mb-4">Most comprehensive learning portal</h2>
                <p class="text-hit-gray font-size-5 mb-0">We must explain to you how all this mistaken idea of denouncing</p>
              </div>
              <!-- cta-content end -->
            </div>
            <div class="col-xl-5 col-lg-12" data-aos="fade-left" data-aos-duration="800" data-aos-once="true">
              <!-- cta-btns start -->
              <div class="btns d-flex justify-content-xl-end justify-content-center align-items-xl-center flex-wrap h-100  mx-n4">
  				
	        	 	<a class="btn btn-primary text-uppercase font-size-3" href="{{url('learn')}}">
		              Start Learning
		            </a>
	        	
              </div>
              <div class="btns d-flex justify-content-xl-end justify-content-center align-items-xl-center flex-wrap h-100  mx-n4">
  				
	        	 	 @php   
    $logo =  \App\User::WebsiteSetting($template->user_id);
 
        if(!empty($logo)){
           $logo_favicon = json_decode($logo->value,true);
        }else{
            $logo_favicon = array();
        }
    $footerWidget1 = \App\WebsiteSetting::getWebsiteMenus('footer_widget_1',$template->user_id);
    $footerWidget2 = \App\WebsiteSetting::getWebsiteMenus('footer_widget_2',$template->user_id)
@endphp
            <!-- footer logo start -->
         		@if (!empty($logo_favicon['logo']))
                	<img src="{{ asset('storage/logo').'/'.$logo_favicon['logo'] }}" class="footer-logo mb-14"   height="50" alt="...">
	            @else
	                <img src="{{ asset(Storage::url('/logo/logo.png')) }}" class="footer-logo mb-14"   height="50" alt="...">
	            @endif 
	        	
              </div>
              <!-- cta-btns end -->
            </div>
          </div>
        </div>
      </div>
      <div class="container  pt-12 pt-lg-19 pb-10 pb-lg-19 align-self-center align-items-center">
           
            <!-- footer logo End -->
            
            
      </div>
    </footer>
    <!-- footer area function end -->
  </div>
  <!-- Vendor Scripts -->
  <script src="{{ asset('public/demo23/js/vendor.min.js')}}"></script>
  <!-- Plugin's Scripts -->
  <script src="{{ asset('public/demo23/plugins/fancybox/jquery.fancybox.min.js')}}"></script>
  <script src="{{ asset('public/demo23/plugins/nice-select/jquery.nice-select.min.js')}}"></script>
  <script src="{{ asset('public/demo23/plugins/aos/aos.min.js')}}"></script>
  <script src="{{ asset('public/demo23/plugins/slick/slick.min.js')}}"></script>
  <script src="{{ asset('public/demo23/plugins/counter-up/jquery.counterup.min.js')}}"></script>
  <script src="{{ asset('public/demo23/plugins/counter-up/jquery.waypoints.min.js')}}"></script>
  <script src="{{ asset('public/demo23/plugins/ui-range-slider/jquery-ui.js')}}"></script>
  <!-- Activation Script -->
  <!-- <script src="js/drag-n-drop.js"></script> -->
  <script src="{{ asset('public/demo23/js/custom.js')}}"></script>
      

</body>

</html>