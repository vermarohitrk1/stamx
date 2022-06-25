<?php $page = "Petition"; ?>
@extends('layout.commonlayout')
@section('content')		
<!-- Breadcrumb -->
<div class="breadcrumb-bar">
    <div class="container-fluid">
        <div class="row align-items-center">
            <div class="col-md-12 col-12">
                <nav aria-label="breadcrumb" class="page-breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{route('dashboard')}}">Home</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Petition</li>
                    </ol>
                </nav>
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
                        <h3 class="blog-title">{{$row->title}}</h3>
                        <div class="blog-info clearfix">
                            <div class="post-left">
                                <ul>
                                    <li><i class="far fa-calendar"></i>Deadline {{date('F d, Y', strtotime($row->end_date))}}</li>
                                    <li><i class="fa fa-briefcase"></i>{{$row->getfolder($row->folder_id)}}</li>
                                </ul>
                            </div>
                        </div>
                        <div class="blog-image">
                            <a href="#">
                                          @if(file_exists( storage_path().'/petition/'.$row->image ) && !empty($row->image))
                                        <img src="{{asset('storage')}}/petition/{{ $row->image }}" height="800px" width="1200px" class="img-fluid" alt="...">
                                        @else
                                        <img class="img-fluid" src="{{ asset('assets/img/blog/blog-02.jpg') }}" alt="">
                                        @endif
                                        
                                    </a>
                        </div>
                        
                        <div class="blog-content">
                            <p>{!! html_entity_decode($row->description, ENT_QUOTES, 'UTF-8') !!}</p>
                             
                        </div>
                        
                    </div>
  @if(!empty($row->tags))
                    <div class="card blog-share clearfix">
                        <div class="card-header">
                            <h3 class="card-title">Tags</h3>
                        </div>
                        <div class="card-body">
                          <div class="post-left">
                                <ul>
                                    @foreach(explode(',',$row->tags) as $i)
                                   <li><i class="fa fa-tags"></i>
                            {{ucfirst($i)}}
                           </li>
                              @endforeach
                                </ul>
                            </div>
                        </div>
                    </div>
  @endif
                    <div class="card blog-share clearfix">
                        <div class="card-header">
                            <h3 class="card-title">Share Petition</h3>
                        </div>
                        <div class="card-body">
                           <div class="icons">
                            <div id="share"></div>
                        </div>
                        </div>
                    </div>
                    <div class="card blog-share clearfix centered align-items-center">
                   
                        <div class="card-body centered align-items-center text-center">
                           
                            <h2 class="centered align-items-center text-center text-primary">Start a petition of your own</h2>
															<p>This petition starter stood and up and took action. Will you do the same?</p>
                                                                                                                        <a href="{{route('petitioncustom.dashboard')}}" class="btn btn-primary btn-lg centered align-items-center text-center">Start a Petition</a>
											
                        </div>
                    </div>
                    <div class="card author-widget clearfix">
                        <div class="card-header">
                            <nav class="user-tabs mb-4 custom-tab-scroll">
            <ul class="nav nav-tabs nav-tabs-bottom nav-justified">
                <li>
                    <a class="nav-link active" href="#comments" data-toggle="tab"><h3 class="card-title">Comments</h3></a>
                </li>
                <li>
                    <a class="nav-link" href="#Updates" data-toggle="tab"><h3 class="card-title">Updates</h3></a>
                </li>
                
            </ul>
        </nav>
                        </div>
                        <div class="card-body">
                             <div class="tab-content">
            <!-- General -->
            <div role="tabpanel" id="comments" class="tab-pane fade show active">
                            this is tab
            </div>
            <div role="tabpanel" id="Updates" class="tab-pane fade show active">
                            this is Updates
            </div>
                             </div>
                        </div>
                    </div>
                    

                </div>
            </div>

            <!-- Blog Sidebar -->
            <div class="col-lg-4 col-md-12 sidebar-right theiaStickySidebar">

               <!-- Search -->
                <div class="card search-widget">
                    <div class="card-body" id="signpetition">
                        @php
                        $response=$row->dummy+$response;
                        @endphp
                        @if($response < $row->target)
                        <h3 ><i class="fas fa-users"></i> <b>{{$response}} have signed.</b> Let's go to {{ $row->target }}!</h3>
                        @else
                        <h3 ><i class="fas fa-users"></i> <b>{{$response}} have signed.</b> Target Completed!</h3>
                        @endif
                        <div class="progress">
                            @php
                             $percent=(int) 100*$response/$row->target;
                            @endphp
                                                        <div class="progress-bar bg-success" role="progressbar" style="width: {{$percent}}%;" aria-valuenow="{{$percent}}" aria-valuemin="0" aria-valuemax="100">{{$percent}}%</div>
                                                        </div>
                        <br>
                        @if($response < $row->target)
                        {{ Form::open(['route' => 'petitionshared.formstore','id' => 'new_input_form', 'name' => 'new_input_form','enctype' => 'multipart/form-data']) }}
                    <input type="hidden" name="id" value="{{!empty($row->id) ? encrypted_key($row->id,'encrypt') :0}}" />
                    <input type="hidden" name="csrf-token" value="<?= csrf_token(); ?>" />
                    @if ($errors->any())
    <div class="alert alert-danger">
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

                    <div class="form-group">
                        <div class="row">
                            <div class="col-md-12">
                                <label class="form-control-label">First Name</label>
                                <input type="text" class="form-control" name="fname" value="" placeholder="First Name" required>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="row">
                            <div class="col-md-12">
                                <label class="form-control-label">Last Name</label>
                                <input type="text" class="form-control" name="lname" value="" placeholder="Last Name" required>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="row">
                            <div class="col-md-12">
                                <label class="form-control-label">Email</label>
                                <input type="email" class="form-control" name="email" value="" placeholder="email" required>
                            </div>
                        </div>
                    </div>
                    
                    
<div class="form-group">
                        <div class="row">
                            <div class="col-md-12">
                                <label class="form-control-label">Comment</label>
                                <textarea  class="form-control"  name="comment" placeholder="Your comment.." rows="3" minlength="10" maxlength="500" required=""  ></textarea>
                            </div>
                        </div>
                    </div>
<div class="form-group">
                        <div class="row">
                            <div class="col-md-12">
                               <label><input type="checkbox" name="display_name" checked=""  style="-webkit-appearance: checkbox;"> Display my name and comment on this petition</label>
														
                            </div>
                        </div>
                    </div>

						</div>
                
                    <div class="text-right">
                        {{ Form::button(__('Sign Petition'), ['type' => 'submit','class' => 'btn btn-lg btn-primary rounded-pill']) }}
                       <br><small>By signing, you accept Terms of Service and Privacy Policy, and agree to receive occasional emails about campaigns. You can unsubscribe at any time.</small>
                    </div>
                    {{ Form::close() }}
                    
                        @endif
                    </div>
                </div>
                <!-- /Search -->
                
            </div>
            <!-- /Blog Sidebar -->

        </div>
    </div>
 @if($response < $row->target)
@if($row->alert == "Popup")
<div class="modal fade" id="common_popup_model" role="dialog"  aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-body border-20 border-primary" style="    border-width: 10px !important;
                 border-color: #1e5e63 !important;
    border-style: solid;">
                <div class="form-content p-2 text-center">
                     
                    <h3 class="text-primary bold">Today: StemX is counting on you</h3>
				<br>
				@if(($response) > 0)
				<p>StemX needs your help with {{ $row->title }}. Join StemX and other {{ $response }} supporters today.</p>
				@else
				<p>StemX needs your help with {{ $row->title }}. Join  StemX and other supporters today.</p>
				@endif
				<a data-dismiss="modal" class="btn btn-lg btn-primary centered align-items-center text-center"  href="#signpetition">Sign this Petition</a>
                   
                    
                </div>
            </div>
        </div>
    </div>
</div>
		
		@endif

		@if($row->alert == "Footer")
		<div class="footer-popup">
			<div class="footer-popup-body centered align-items-center text-center" style="    border-width: 10px !important;
                 border-color: #1e5e63 !important;
    border-style: solid;">
				 <h3 class="text-primary bold mt-5">Today: StemX is counting on you</h3>
				<br>
				@if(($response) > 0)
				<p>StemX needs your help with {{ $row->title }}. Join StemX and other {{ $response }} supporters today.</p>
				@else
				<p>StemX needs your help with {{ $row->title }}. Join  StemX and other supporters today.</p>
				@endif
				<a data-dismiss="modal" class="btn btn-lg btn-primary mb-5 centered align-items-center text-center"  href="#signpetition">Sign this Petition</a>
                   
			</div>
		</div>
		@endif
		@endif
</div>		
<!-- /Page Content -->
@endsection

@push('script')
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
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jsSocials/1.5.0/jssocials-theme-flat.min.css" integrity="sha256-1Ru5Z8TdPbdIa14P4fikNRt9lpUHxhsaPgJqVFDS92U=" crossorigin="anonymous" />
<script src="https://cdnjs.cloudflare.com/ajax/libs/jsSocials/1.5.0/jssocials.min.js" integrity="sha256-QhF/xll4pV2gDRtAJ1lvi9YINqySpAP+0NIzIX5voZw=" crossorigin="anonymous"></script>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jsSocials/1.5.0/jssocials.min.css" integrity="sha256-1tuEbDCHX3d1WHIyyRhG9D9zsoaQpu1tpd5lPqdqC8s=" crossorigin="anonymous" />
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.10.2/css/all.min.css" integrity="sha256-zmfNZmXoNWBMemUOo1XUGFfc0ihGGLYdgtJS3KCr/l0=" crossorigin="anonymous" />
<script>
$(document).ready(function () {
    $("#share").jsSocials({
        shares: ["twitter", "facebook", "linkedin", "pinterest", "whatsapp"],
        showCount: false
    });

});
</script>
<script type="text/javascript">
    	$(document).mouseleave(function(){
			   $("#common_popup_model").modal('show');
			})

			

			$(".sign-petition").click(function(event){
                              event.preventDefault();
			 $("#common_popup_model").modal('hide');
			})
                        
			

        </script>
@endpush