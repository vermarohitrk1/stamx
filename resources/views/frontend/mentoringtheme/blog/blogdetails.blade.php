<?php $page = "blog-details"; ?>
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
                        <li class="breadcrumb-item active" aria-current="page">Blog</li>
                    </ol>
                </nav>
                <h2 class="breadcrumb-title">Blog Details</h2>
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
                        {{-- <div class="blog-image">
                            <a href="{{route('blog.details',encrypted_key($row->id,"encrypt"))}}">
                                          @if(file_exists( storage_path().'/blog/'.$row->image ) && !empty($row->image))
                                        <img src="{{asset('storage')}}/blog/{{ $row->image }}" height="800px" width="1200px" class="img-fluid" alt="...">
                                        @else
                                        <img class="img-fluid" src="{{ asset('assets/img/blog/blog-02.jpg') }}" alt="">
                                        @endif

                                    </a>
                        </div> --}}
                        <h3 class="blog-title">{{$row->title}}</h3>
                        <div class="blog-info clearfix">
                            <div class="post-left">
                                <ul>
                                    <li>
                                        <div class="post-author">
                                            <a href="{{route('profile',["id"=>encrypted_key($row->user_id,"encrypt")])}}">
                                                 @if(file_exists( storage_path().'/app/'.$row->user->avatar ) && !empty($row->user->avatar))
                                                 <img src="{{asset('storage')}}/app/{{ $row->user->avatar }}" height="30px" width="30px"   class=" " alt="...">
                                        @else
                                        <img src="{{ asset('assets/img/user/user2.jpg') }}" alt="Author">
                                        @endif


                                                <span>{{ $row->user->name??'' }}</span></a>
                                        </div>
                                    </li>
                                    <li><i class="far fa-calendar"></i>{{date('M d, Y', strtotime($row->created_at))}}</li>
                                    <li><i class="fa fa-briefcase"></i>{{$row->getcategory($row->category)}}</li>
                                    <li><i class="fa fa-tags"></i>@foreach($tags as $i)
                            {{ucfirst($i)}}
                            @endforeach</li>
                                </ul>
                            </div>
                        </div>
                        <div class="blog-content">
                            <p>{!! html_entity_decode($row->article, ENT_QUOTES, 'UTF-8') !!}</p>

                        </div>
                        <div class="blog-content">
                            @if(!empty($row->video))
                    <video  controls style="width: 100%;height:50%">
                        <source src="{{url('storage/app/'.$row->video)}}" type="video/mp4">
                        Your browser does not support the video tag.
                    </video>
                @endif
                            {{-- @if(!empty($row->youtube))
                            <div class="embed-responsive embed-responsive-16by9">
            <iframe class="embed-responsive-item" src="{{$row->youtube}}" allowfullscreen></iframe>
          </div>
                @endif --}}

                        </div>
                    </div>

                    <div class="card blog-share clearfix">
                        <div class="card-header">
                            <h4 class="card-title">Share the post</h4>
                        </div>
                        <div class="card-body">
                           <div class="icons">
                            <div id="share"></div>
                        </div>
                        </div>
                    </div>
                    <div class="card author-widget clearfix">
                        <div class="card-header">
                             @php
                $author=\App\User::find($row->user_id);
                @endphp
                            <h4 class="card-title">About Author</h4>
                        </div>
                        <div class="card-body">
                            <div class="about-author">
                                <div class="about-author-img">
                                    <div class="author-img-wrap">
                                        <a href="{{route('profile',['id'=>encrypted_key($author->id,"encrypt")])}}"><img class="img-fluid rounded-circle" alt="" src="{{ $author->getAvatarUrl() }}"></a>
                                    </div>
                                </div>
                                <div class="author-details">
                                    <a href="{{route('profile',['id'=>encrypted_key($author->id,"encrypt")])}}" class="blog-author-name">{{$author->name}}</a>
                                    <p class="mb-0">{{$author->about}}</p>
                                </div>
                            </div>
                        </div>
                    </div>


                </div>
            </div>

            <!-- Blog Sidebar -->
            <div class="col-lg-4 col-md-12 sidebar-right theiaStickySidebar">




                            @if(!empty($recent_blogs) && count($recent_blogs) > 0)
                <!-- Latest Posts -->
                <div class="card post-widget">
                    <div class="card-header">
                        <h4 class="card-title">Latest Posts</h4>
                    </div>
                    <div class="card-body">
                        <ul class="latest-posts">
                            @foreach($recent_blogs as $row)
                            <li>
                                <div class="post-thumb">
                                    <a href="{{route('frontend.programdetails',encrypted_key($row->id,"encrypt"))}}">
                                          @if(file_exists( storage_path().'/blog/'.$row->image ) && !empty($row->image))
                                        <img src="{{asset('storage')}}/blog/{{ $row->image }}" height="60px" width="90px" class=" " alt="...">
                                        @else
                                        <img class="img-fluid" src="{{ asset('assets/img/blog/blog-thumb-01.jpg') }}" alt="">
                                        @endif


                                    </a>
                                </div>
                                <div class="post-info">
                                    <h4>
                                        <a href="{{route('blog.details',encrypted_key($row->id,"encrypt"))}}">{{$row->title}}</a>
                                    </h4>
                                    <p>{{date('F d, Y', strtotime($row->created_at))}}</p>
                                </div>
                            </li>
                            @endforeach

                        </ul>
                    </div>
                </div>
                <!-- /Latest Posts -->
                            @endif


            </div>
            <!-- /Blog Sidebar -->

        </div>
    </div>

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
@endpush
