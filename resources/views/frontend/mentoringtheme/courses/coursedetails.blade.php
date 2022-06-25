<?php $page = "blog-details"; ?>
@extends('layout.commonlayout')
@section('content')		
<style>
.col-md-12.mode_b {
    text-align: center;
    padding: 0px 0px 34px 0;
}
.col-md-12.wallet_b span {
    display: block;
    font-size: 13px !important;
}
.col-md-12.wallet_b {
    text-align: center;
    padding: 35px;
    font-size: 21px;
}
h4.text-primary {
    font-size: 17px;
}
h5#exampleModalLabel {
    font-size: 20px;
}
span.select2.select2-container.select2-container--default {
    width: 100% !important;
}
a#Tution {
    color: #fff;
}
.Chapters-list h6 {
    font-size: 14px;
}
h4.card-title {
    font-size: 19px;
}
    .hide {
        display: none !important;
    }

    #customer_payment {
        padding: 8px 20px;
    }
button#customer_payment {
    font-size: 14px;
}
h5.panel-title.display-td {
    font-size: 18px;
}
.right_buy {
    display: flex;
  
}
.modal_title_cl {
        font-size: 2rem;
    color: #000;
}
.modal-body {
   
    padding: 2rem;
}

.modal-footer button {
    font-size: 14px;
}
.modal_title_cl p {
    margin-bottom: 0;
}
.modal_title_cl span {
    color: #009DA6;
}
p.font-weight-semibold {
    font-size: 19px;
    color: #00777E;
    font-weight: 600;
    line-height: 40px;
}
.right_buy a {
    
    margin: auto;
}
.right_buy a {
   
    font-size: 16px;
}
.right_buy a button{
   
    font-size: 16px;
}
</style>
<!-- Breadcrumb -->
<div class="breadcrumb-bar">
    <div class="container-fluid">
        <div class="row align-items-center">
            <div class="col-md-12 col-12">
                <nav aria-label="breadcrumb" class="page-breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{url('')}}">Home</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Course</li>
                    </ol>
                </nav>
                <h2 class="breadcrumb-title">Course Details</h2>
            </div>
        </div>
    </div>
</div>
<!-- /Breadcrumb -->

<!-- Page Content -->
<div class="content">
    <div class="container-fluid">

        <div class="row">
            <div class="col-lg-8 col-md-12">
                <div class="blog-view">
                    <div class="blog blog-single-post">
<!--                        <div class="blog-image">
                            <a href="javascript:void(0);">
                                @if(file_exists( storage_path().'/certify/'.$row->image)  && !empty($row->image))
                        <img src="{{asset('storage')}}/certify/{{ $row->image }}" alt="" class="img-fluid">
                    @else
                    <img alt="" src="{{ asset('assets/img/blog/blog-01.jpg') }}" class="img-fluid">
                    @endif
                                
                            </a>
                        </div>-->
                        <h3 class="blog-title">{!! html_entity_decode(ucfirst($row->name), ENT_QUOTES, 'UTF-8') !!}</h3>
                        <div class="blog-info clearfix">
                            <div class="post-left">
                                <ul>
                                    <li>
                                        <div class="post-author">
                                                @php
                $author=\App\User::find($row->user_id);
                @endphp
                
                                            <a href="{{route('profile',['id'=>encrypted_key($author->id,"encrypt")])}}"><img src="{{ $author->getAvatarUrl() }}" alt="Post Author"> <span>{{$author->name}}</span></a>
                                        </div>
                                    </li>
                                    <li><i class="far fa-calendar"></i>{{date('F d, Y', strtotime($row->created_at))}}</li>
                                    <li><i class="fa fa-briefcase"></i>{{!empty($row->category) && !empty($row->getCategoryName($row->category)) ? $row->getCategoryName($row->category) :'No category'}}</li>
                                    @if(!empty($row->boardcertified))
                                    <li><i class="fas fa-certificate"></i>Board Certified</li>
                                    @endif
                                </ul>
                            </div>
                        </div>
                        <div class="blog-content">
                            
                            <p>{!! html_entity_decode($row->description, ENT_QUOTES, 'UTF-8') !!}</p>
                        </div>
                    </div>

                    @if(!empty($row->video))
                    <div class="card blog-share clearfix">
                        <div class="card-header">
                                    <video width="700" controls="">
                                        <source src="{{asset('storage')}}/app/{{ $row->video }}" type="video/mp4">

                                        Your browser does not support HTML5 video.

                                    </video>
                               
                        </div>
                    </div>
                                 @endif
                    <div class="card blog-share clearfix">
                        <div class="card-header">
                            <h4 class="card-title">Classes/Lessons</h4>
                            <small>@if(getChapterCountOfCertify($row->id))
                                            {{getChapterCountOfCertify($row->id)}} Session(s)
                                        @endif</small>
                        </div>
                        <div class="card-body">
                           <h4 class="text-primary">Curriculum For {{$row->name}}</h4>
                           <hr>
                            @if ($row->getCertifyChapter($row->id)->count() > 0)
                                @foreach ($row->getCertifyChapter($row->id) as $chapterindex => $chapter)
                                    <!-- single chapter -->
                                        <div class="Chapters-list">
                                            <h6>Chapter {{ $chapterindex + 1 }}: <strong
                                                    class="text-primary">{{ $chapter->title }}</strong></h6>
                                            <div class="chapter-class-type">
                                                @if ($chapter->getLectureOfChapter($chapter->id)->count() > 0)
                                                    @foreach ($chapter->getLectureOfChapter($chapter->id) as $key => $lecture)
                                                        <a data-toggle="collapse" class="collS1 text-dark"
                                                           data-parent="#lecture-accordion" href="javascript:void(0)">
                                                            <i class="mdi mdi-arrows-alt"></i>
                                                            @if ( $lecture->type == "link" )
                                                                <i class="mdi mdi-link"></i>
                                                            @elseif ( $lecture->type == "text" )
                                                                <i class="mdi mdi-clipboard-text"></i>
                                                            @elseif ( $lecture->type == "downloads" )
                                                                <i class="mdi mdi-cloud-upload-alt"></i>
                                                            @elseif ( $lecture->type == "pdf" )
                                                                <i class="mdi mdi-file-pdf"></i>
                                                            @elseif ( $lecture->type == "video" )
                                                                <i class="mdi mdi-play-circle"></i>
                                                            @endif
                                                            <span class="indexing">{{ $key + 1 }}.)</span>
                                                            <span
                                                                class="text-dark panel-label">{{ $lecture->title }}</span>
                                                        </a><br>
                                                    @endforeach
                                                @else
                                                <!--                            <div class="empty-section text-dark">
                                <h5 class="text-dark"><i class="mdi mdi-clipboard-text"></i>No lectures here</h5>
                            </div>-->
                                                @endif
                                            </div>
                                        </div>
                                        <hr>
                                    @endforeach
                                @else
                                    <div class="empty-section">

                                        <h5><i class="mdi mdi-alert-box"></i>No curriculum created for this learn!</h5>
                                    </div>
                                @endif
                        </div>
                    </div>
                    <div class="card blog-share clearfix">
                        <div class="card-header">
                            <h4 class="card-title">Share the course</h4>
                        </div>
                        <div class="card-body">
                            <div class="icons">
                            <div id="share"></div>
                        </div>
                        </div>
                    </div>
                    <div class="card author-widget clearfix">
                        <div class="card-header">
                            <h4 class="card-title">About Instructors <a href="{{route('register',['become'=>'instructor'])}}" class="btn btn-primary btn-xs float-right">Become An Instructor</a></h4>
                        </div>
                        <div class="card-body">
                            @php
                $instructor_ids=explode(',',$row->instructor);
                @endphp
                @foreach($instructor_ids as $instructor_id)
                @php
                $instructor=\App\Instructor::getInstructordata($instructor_id);
                @endphp
                            <div class="about-author mt-1">
                                <div class="about-author-img">
                                    <div class="author-img-wrap">
                                        <a href="{{route('profile',['id'=>encrypted_key($instructor->id,'encrypt')])}}"><img class="img-fluid rounded-circle" alt="" src="{{$instructor->avatar}}"></a>
                                    </div>
                                </div>
                                <div class="author-details">
                                    <a href="{{route('profile',['id'=>encrypted_key($instructor->id,'encrypt')])}}" class="blog-author-name">{{$instructor->name}}</a>
                                    <p class="mb-0">{{$instructor->about}}</p>
                                </div>
                            </div>
                @endforeach
                        </div>
                    </div>
                    

                </div>
            </div>

            <!-- Blog Sidebar -->
            <div class="col-lg-4 col-md-12 sidebar-right theiaStickySidebar">

                <!-- Search -->
                <div class="card search-widget">
                    <div class="card-body">
                        <div class="card-btn-group">
                            <div class="right_buy">
                         <p class="font-weight-semibold font-size-5 text-black-2 mb-0">
                                                    @if(!empty($row->sale_price))
                                                        ${{$row->sale_price}} / <strike class="text-muted">${{ $row->price }}</strike>
                                                    @else
                                                        ${{$row->price}}
                                                    @endif
                                                </p>
												
												
												
										  @if(Auth::user() && getLearnAssistenceUser($row->id)->count())
											  @if(Auth::user()->type !='admin' )
                                                    <a href="{{ route('certify.show',encrypted_key($row->id,'encrypt')) }}"
                                                       class="btn btn-primary  btn-lg rounded-3 w-180 mr-4 mb-5">
                                                        Manage Assistance
                                                    </a>
													@endif
                                                @else
                                                    @if( getLearnAssistenceCheck($row->id) == true)
                                                        @if(Auth::user())
                                                            @if(Auth::user()->type !='admin' )
                                                                @if(Auth::user()->type !='mentor' )
                                                                    <a href="javascript:void(0);" id="assistance"
                                                                       class="Tuition btn btn-primary  btn-lg rounded-3 w-180 mr-4 mb-5">
                                                                        Tuition Assistance
                                                                    </a>
                                                                @endif
                                                            @endif
                                                        @else
                                                            <a  href="{{route('signup.mentee')}}" id=""
                                                               class="btn btn-primary  btn-lg rounded-3 w-180 mr-4 mb-5 ">Tuition
                                                                Assistance</a>
                                                        @endif
                                                    @endif
                                                @endif		
												
									   @if(checkEnrollStatus($row->id) == true)		
										 <a class="btn btn-primary  btn-lg rounded-3 w-180 mr-4 mb-5"
                                                       href="{{ route('certify.show',encrypted_key($row->id,'encrypt')) }}">Start
                                                        Learn</a>
										
										@elseif(checkLearnApprove($row->id) == true)
											@if(Auth::user() && Auth::user()->type !='admin' )
													<a href="javascript:void(0);" id="PaymentMode" class="w-180 mr-4 mb-5">
													<button type="button" class="btn-lg btn btn-primary Tuition">  Enroll now ($@if($row->sale_price > 0){{number_format($row->sale_price, 2)}}@else{{number_format($row->price, 2)}}@endif)</button>
													</a>
													@else
														
													  
													   <a  href="{{route('signup.mentee')}}" id=""
                                                               class="btn btn-primary  btn-lg rounded-3 w-180 mr-4 mb-5 ">Enroll now</a>
															   
												
													
											@endif
										@else
											 <a class="btn btn-primary  btn-lg rounded-3 w-180 mr-4 mb-5" href="{{ route('certify.show',encrypted_key($row->id,'encrypt')) }}">
                                                        Manage Curriculum
                                                    </a>
										@endif
									
									
							
					
                                 </div>        
                                </div>
                        <h3 class="text-warning"><i class="fas fa-certificate"></i> Certification in just {{$row->duration}} {{$row->period}}</h3>
                    </div>
                </div>
                <!-- /Search -->

                <!-- Latest Posts -->
                <div class="card post-widget">
                    <div class="card-header">
                        <h3 class="card-title">Related Courses</h3>
                    </div>
                    <div class="card-body">
                        <ul class="latest-posts">
                            @foreach($learns as $learn)
                            <li>
                                <div class="post-thumb">
                                    <a href="{{route('course.details',['id'=>encrypted_key($learn->id,'encrypt')])}}">
                                         @if(file_exists( storage_path().'/certify/'.$learn->image)  && !empty($learn->image))
                        <img src="{{asset('storage')}}/certify/{{ $learn->image }}" alt="" class="img-fluid ">
                    @else
                    <img class="img-fluid" src="{{ asset('assets/img/blog/blog-thumb-01.jpg') }}" alt="">
                    @endif
                                        
                                    </a>
                                </div>
                                <div class="post-info">
                                    <h4>
                                        <a href="{{route('course.details',['id'=>encrypted_key($learn->id,'encrypt')])}}">{!! html_entity_decode(ucfirst($learn->name), ENT_QUOTES, 'UTF-8') !!} - {{!empty($learn->category) && !empty($learn->getCategoryName($learn->category)) ? $learn->getCategoryName($learn->category) :'No category'}}</a>
                                    </h4>
                                    <p class="text-warning">@if(!empty($learn->sale_price))
                {{ format_price($learn->sale_price) }} / <strike>{{ format_price($learn->price) }}</strike>
                @elseif(!empty($learn->price))
                {{ format_price($learn->price) }}
                @else
                Free
                @endif</p>
                                <p>Certification in just {{$learn->duration}} {{$learn->period}}</p>
                                </div>
                            </li>
                            @endforeach
                            
                            
                        </ul>
                    </div>
                </div>
                <!-- /Latest Posts -->

            </div>
            <!-- /Blog Sidebar -->

        </div>
    </div>

</div>		
<!-- /Page Content -->
@endsection

@push('script')

<div class="modal fade" id="modeModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
     aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Payment mode</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
              <div class="row">
			  <div class="col-md-12 wallet_b">@if(!empty(Auth::user()->wallet_balance)) ${{Auth::user()->wallet_balance}} @else $0 @endif <span>Wallet Balance</span></div>
			  </div>
			    <div class="row">
				<div class="col-md-12 mode_b">
                <button type="button" class="btn btn-primary btn-lg pay_Using_Wallet modeType"  data-type="certify"
                                            data-id="{{$row->id}}"
                                            price="@if($row->sale_price > 0) {{$row->sale_price}}@else {{$row->price}}@endif"
                                            data-price="$@if($row->sale_price > 0){{$row->sale_price}}@else{{$row->price}} @endif"
                                            id="makeenrollwallet"  data-dismiss="modal"
                                            checkSyndicate="@if(checkSyndicateOfCourse($row->id) == true) 1 @else 0 @endif">Pay using wallet </button>


                <button type="button" class="btn btn-primary btn-lg" data-type="certify"
                                            data-id="{{$row->id}}"
                                            price="@if($row->sale_price > 0){{$row->sale_price}}@else {{$row->price }}@endif"
                                            data-price="$@if($row->sale_price > 0){{$row->sale_price}}@else{{$row->price}} @endif"
                                            id="makeenroll"  data-dismiss="modal"
                                            checkSyndicate="@if(checkSyndicateOfCourse($row->id) == true) 1 @else 0 @endif">Pay using stripe</button>
            </div>
            </div>
            </div>
            <div class="modal-footer">

            </div>

        </div>
    </div>
</div>
<style>
    .jssocials-share i.fa {
        font-family: "Font Awesome 5 Brands";
    }
    .jssocials-share-label {
        padding-left: .0em;
        vertical-align: middle;
    }
    .jssocials-shares {
        margin: 1em 0;
        font-size: 13px;
    }
</style>


<div class="modal fade" id="myModal_payment" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
     aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <div class="row display-tr">
                    <h5 class="panel-title display-td"><b>Payment Details</b></h5>
                    <div class="display-td">

                    </div>
                </div>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form role="form" action="{{ route('strip_payment')}}" method="post" class="require-validation"
                      data-cc-on-file="false"
                      data-stripe-publishable-key="{{env('STRIPE_KEY')}}"
                      id="payment-form">
                    {{ csrf_field() }}
                    <input type="hidden" name="itemPrice" id="itemPrice" value="">
                    <input type="hidden" name="itemId" id="itemId" value="">
                    <input type="hidden" name="itemType" id="itemType" value="">
                    <input type="hidden" name="checkSyndicate" id="checkSyndicate" value="">
                    <div class='form-row row'>
                        <div class='col-xs-12 form-group required'>
                            <label class='control-label'>Name on Card</label> <input
                                class='form-control' size='80' type='text' required>
                        </div>
                    </div>
                    <div class='form-row row'>
                        <div class='col-xs-12 form-group card required'>
                            <label class='control-label'>Card Number</label>
                            <input autocomplete='off' class='form-control card-number' style="width: 467px;" size='16'
                                   min="16" type='number'>
                        </div>
                    </div>
                    <div class='form-row row'>
                        <div class='col-xs-12 col-md-4 form-group cvc required'>
                            <label class='control-label'>CVC</label>
                            <input autocomplete='off' class='form-control card-cvc' placeholder='ex. 311' size='4' type='number' required="">
                        </div>
                        <div class='col-xs-12 col-md-4 form-group expiration required'>
                            <label class='control-label'>Expiration Month</label> <input
                                class='form-control card-expiry-month' placeholder='MM' size='2'
                                type='number'>
                        </div>
                        <div class='col-xs-12 col-md-4 form-group expiration required'>
                            <label class='control-label'>Expiration Year</label> <input
                                class='form-control card-expiry-year' placeholder='YYYY' size='4'
                                type='number'>
                        </div>
                    </div>
                
				      <div class='form-row row'>
                        <div class='col-xs-8 form-group'>
                            <label class='control-label'>Apply Coupon</label>
                            <input autocomplete='off' class='form-control' style="width: 367px;"
                                   placeholder="Coupon code" type='text' name="coupon" id="coupon">
                        </div>
                        <div class='col-xs-2 form-group'>
                            <input type="button" class="btn btn-primary btn-lg" id="applyCoupon" value="Apply"
                                   style="margin-top: 38%; font-size: 15px; padding: 8px 11px;">
                        </div>
                    </div>
                    <div class='form-row row'>
                        <div class='col-md-12 error form-group hide'>
                            <div class='alert-danger alert'>Please correct the errors and try
                                again.
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-xs-12 buttonCustom w-100 ctm_payment">
                            <button class="btn btn-primary btn-lg btn-block" id="customer_payment" type="submit">Pay Now
                                ($100)
                            </button>
                        </div>
                    </div>
                </form>
            </div>

        </div>
    </div>
</div>

<div id="PayusingWalletConfirm" class="modal fade" role="dialog">
        <div class="modal-dialog">
            <!-- Modal content-->
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Are You Sure?</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <div class="modal-body">
                    This action can not be undone. Do you want to continue?
                </div>
                <div class="modal-footer">
                    {{ Form::open(['url' => 'wallet_payment','id' => 'destroy_certify_request','enctype' => 'multipart/form-data']) }}
                    <input type="hidden" name="itemId" id="Id" value="">
                    <input type="hidden" name="price" id="checkPrice" value="">
                    <input type="hidden" name="itemType" id="itemTypee" value="">

                    <button type="submit" class="btn btn-sm btn-danger rounded-pill" id="">Pay</button>
                    {{ Form::close() }}
                    <button type="button" class="btn btn-sm btn-secondary rounded-pill" id="" data-dismiss="modal"
                            aria-label="Close">Cancel
                    </button>
                </div>
            </div>
        </div>
    </div>
<div class="modal fade" id="assistanceModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
     aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Assistance List</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                {{ Form::open(['url' => 'assistence/request/create','id' => 'create_request_assistence','enctype' => 'multipart/form-data']) }}
                <input type="hidden" name="user" value="@if(Auth::user()){{Auth::user()->id}}@endif">
                <input type="hidden" name="certify" value="{{$row->id}}" id="companyLearnId">
                <div class="form-group">
                    <label class="text-left">Choose Company</label><br>
                    <select class="" name="assistance" required
                            id="companyDropDownName">
                        @foreach(getLearnAssistence($row->id) as $assist)
						@if($assist->user)
                            <option value="{{$assist->user}}">{{getUserDetails($assist->user)['name']}}</option>
                        @endif
						@endforeach
                    </select>
                </div>
                <br>
                <div class="radio">
                    <label><input type="radio" name="type" value="Veterans" class="optiontype">&nbsp;Veterans</label>
                </div>
                <div class="radio">
                    <label><input type="radio" name="type" value="Justice-Involved" class="optiontype">&nbsp;Justice-Involved</label>
                </div>
                <div class="radio">
                    <label><input type="radio" name="type" value="Juvenile" class="optiontype">&nbsp;Juvenile</label>
                </div>
                <div class="radio">
                    <label><input type="radio" name="type" value="Military" class="optiontype">&nbsp;Military</label>
                </div>
                <div class="radio">
                    <label><input type="radio" name="type" value="Other" class="optiontype">&nbsp;Other</label>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <button type="submit" class="btn btn-primary">Send Request</button>
            </div>
            {{ Form::close() }}
        </div>
    </div>
</div>


<!-- Modal -->
<div class="modal fade" id="freeApprove" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
     aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Redeem</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body text-center">
                {{ Form::open(['url' => 'apply/coupon','id' => 'apply_coupon','enctype' => 'multipart/form-data']) }}
                <input type="hidden" name="certifyId" value="" id="freeCertifyId">
                <input type="hidden" name="coupon" value="" id="freeCoupon">
                <input type="submit" class="btn btn-primary" value="Redeem Now">
                {{ Form::close() }}
            </div>
        </div>
    </div>
</div>


<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jsSocials/1.5.0/jssocials-theme-flat.min.css" integrity="sha256-1Ru5Z8TdPbdIa14P4fikNRt9lpUHxhsaPgJqVFDS92U=" crossorigin="anonymous" />
<script src="https://cdnjs.cloudflare.com/ajax/libs/jsSocials/1.5.0/jssocials.min.js" integrity="sha256-QhF/xll4pV2gDRtAJ1lvi9YINqySpAP+0NIzIX5voZw=" crossorigin="anonymous"></script>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jsSocials/1.5.0/jssocials.min.css" integrity="sha256-1tuEbDCHX3d1WHIyyRhG9D9zsoaQpu1tpd5lPqdqC8s=" crossorigin="anonymous" />
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.10.2/css/all.min.css" integrity="sha256-zmfNZmXoNWBMemUOo1XUGFfc0ihGGLYdgtJS3KCr/l0=" crossorigin="anonymous" />


<script type="text/javascript" src="https://js.stripe.com/v2/"></script>

<script type="text/javascript">

 $(document).on("click", ".modeType", function (event) {
            var modeType = $(this).val();


                var checkPrice = $("#makeenrollwallet").attr("data-price");
                var dataId = $("#makeenrollwallet").attr("data-id");
				 var itemType = $("#makeenrollwallet").attr("data-type");

                $("#hiddenofferPrice").val(checkPrice);
                // $("#hiddenid").val(dataId);
                var offerPrice = $("#makeenrollwallet").attr("data-id");

                $.post(
                    "{{route('check.wallet.price')}}",
                    {_token: "{{ csrf_token() }}", price: checkPrice, id: dataId},
                    function (data) {
                        if (data == true) {

							  var id = $(this).attr('data-id');
							$("#checkPrice").val(checkPrice);
							$("#Id").val(dataId);
							$("#itemTypee").val('certify');
							$('#PayusingWalletConfirm').modal('show');
							// alert('Success');
                            // show_toastr('Success', '{{__('free certify available.')}}', 'success');
                        } else if (data == false) {
							show_toastr('Error', '{{__('Insufficient balance in wallet.')}}', 'error');
                        }
                    }
                );

        });

$(document).ready(function(){

    $(".card-number").keyup(function () {
	
		
        var cardNumber = $(this).val();
        if (cardNumber.length > 16) {
            var res = cardNumber.substring(0, 16);
            $(".card-number").val(res);
        }
    });
    $(".card-cvc").keyup(function () {
        var cardcvv = $(this).val();
        if (cardcvv.length > 3) {
            var res = cardcvv.substring(0, 3);
            $(".card-cvc").val(res);
        }
    });
    $(".card-expiry-month").keyup(function () {
        var cardexpirymonth = $(this).val();
        if (cardexpirymonth.length > 2) {
            var res = cardexpirymonth.substring(0, 2);
            $(".card-expiry-month").val(res);
        }
    });
    $(".card-expiry-year").keyup(function () {
        var cardexpiryyear = $(this).val();
        if (cardexpiryyear.length > 4) {
            var res = cardexpiryyear.substring(0, 4);
            $(".card-expiry-year").val(res);
        }
    });
	    $(function () {
        var $form = $(".require-validation");
        $('form.require-validation').bind('submit', function (e) {
            var $form = $(".require-validation"),
                inputSelector = ['input[type=email]', 'input[type=password]', 'input[type=text]', 'input[type=file]', 'textarea'].join(', '),
                $inputs = $form.find('.required').find(inputSelector),
                $errorMessage = $form.find('div.error');
            valid = true;
            $errorMessage.addClass('hide');
            $('.has-error').removeClass('has-error');
            $inputs.each(function (i, el) {
                var $input = $(el);
                if ($input.val() === '') {
                    valid = false;
                    $input.parent().addClass('has-error');
                    $errorMessage.removeClass('hide');
                    e.preventDefault();
                }
            });

            if (!$form.data('cc-on-file')) {
                e.preventDefault();
                Stripe.setPublishableKey($form.data('stripe-publishable-key'));
                Stripe.createToken({
                    number: $('.card-number').val(),
                    cvc: $('.card-cvc').val(),
                    exp_month: $('.card-expiry-month').val(),
                    exp_year: $('.card-expiry-year').val()
                }, stripeResponseHandler);
            }

        });

        function stripeResponseHandler(status, response) {
            if (response.error) {
			
                $(".error").show();
                $('.error').removeClass('hide').find('.alert').text(response.error.message);
            } else {
                // token contains id, last4, and card type
                var token = response['id'];
                // insert the token into the form so it gets submitted to the server
                $form.find('input[type=text]').empty();
                $form.append("<input type='hidden' name='stripeToken' value='" + token + "'/>");
                $form.get(0).submit();
            }
        }
    });
	});



$(document).ready(function () {
    $("#share").jsSocials({
        shares: ["twitter", "facebook", "linkedin", "pinterest", "whatsapp"],
        showCount: false
    });
	$("#PaymentMode").click(function () {
        $("#modeModal").modal('show');
    });
	
	 $("#Tution").click(function () {
		 
        $('#registerClientModal').modal({backdrop: 'static', keyboard: false});
    });
	   $("#assistance").click(function () {
        $("#assistanceModal").modal('show');
    });
	   $("#create_request_assistence").submit(function (event) {
        if (!$(".optiontype").is(':checked')) {
            event.preventDefault();
            toastr.error("Required");
        }
    });
	
});


$("#makeenroll").click(function () {
	

        @if(Auth::user())
		
        $("#payment-form")[0].reset()
        $('#myModal_payment').modal({backdrop: 'static', keyboard: false});
        var price = $("#makeenroll").attr("data-price");
		
		
        $("#customer_payment").html("Pay Now (" + price + ")");
        $("#itemPrice").val($("#makeenroll").attr("price"));
        var id = $("#makeenroll").attr("data-id");
		var checkSyndicate = $("#makeenroll").attr("checkSyndicate");
        $("#itemId").val(id);

        var itemType = $("#makeenroll").attr("data-type");
        $("#itemType").val(itemType);
    
        @else
        $('#registerModal').modal({backdrop: 'static', keyboard: false});
        @endif
    });
	
    $(document).on("keyup", "#CompanyName", function () {
        var string = $(this).val();
        var certify = $("#companyLearnId").val();
        $.post(
            "{{route('learn.company.find')}}",
            {_token: "{{ csrf_token() }}", search: string, certify: certify},
            function (data) {
                $("#companyDropDownName").html(data);
            }
        );
    });
	
	 function applyCoupon(coupon, certifyId, price) {
        if (coupon == '') {
            toastr.error("coupon is empty");
        } else {
            $.post(
                "{{route('check.coupon')}}",
                {_token: "{{ csrf_token() }}", coupon: coupon, certifyId: certifyId},
                function (data) {
                    if (data) {
                        if (data.price_limit == price || data.price_limit > price) {
                            $("#myModal_payment").modal('hide');
                            $("#freeCertifyId").val(certifyId);
                            $("#freeCoupon").val(coupon);
                            $("#freeApprove").modal('show');
                            toastr.success("coupon applyed");
                        } else {
                            var newPrice = price - data.price_limit;
                            $("#customer_payment").html("Pay Now ($" + newPrice + ")");
                            toastr.success("coupon applyed");
                        }
                    } else {
                        $("#coupon").val('');
                        toastr.error("coupon not found");
                    }
                }
            );
        }
    }

    $("#applyCoupon").click(function () {
		
		
        var coupon = $("#coupon").val();
        var itemId = $("#itemId").val();
        var itemPrice = $("#itemPrice").val();
        applyCoupon(coupon, itemId, itemPrice);
    });
    $("#companyDropDownName").select2();
</script>
@endpush