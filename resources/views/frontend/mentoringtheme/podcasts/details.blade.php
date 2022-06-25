<?php $page = "blog-details"; ?>
@extends('layout.commonlayout')
@push('css')
<style>
.podcast-image img.img-fluid {
    width: 300px;
}

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
@endpush
@section('content')
<!-- Breadcrumb -->
<div class="breadcrumb-bar">
    <div class="container-fluid">
        <div class="row align-items-center">
            <div class="col-md-12 col-12">
                <nav aria-label="breadcrumb" class="page-breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="index">Home</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Podcast</li>
                    </ol>
                </nav>
                <h2 class="breadcrumb-title">Podcast Details</h2>
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
                        <div class="podcast-image mb-3">
                            <a href="javascript:void(0);">
                                @if(file_exists( storage_path().'/podcasts/'.$data->image ) && !empty($data->image))
                                <img src="{{asset('storage')}}/podcasts/{{ $data->image }}" class="img-fluid" alt="...">
                                @else
                                <img src="{{ asset('public')}}/demo23/image/patterns/globe-pattern.png"
                                    class="img-fluid" width="100px" alt="img">
                                @endif

                            </a>
                        </div>
                        <h3 class="blog-title">{{ ucfirst($data->title)}}</h3>
                        <span class="font-size-3 text-gray line-height-2">

                            @if(!empty($data->episode)) Episode-{{ $data->episode }}: @endif
                        </span>
                        <div class="blog-info clearfix">
                            <div class="post-left">
                                <ul>
                                    <li><i class="far fa-calendar"></i>{{date('F d, Y', strtotime($data->created_at))}}
                                    </li>
                                    <li><i class="fa fa-briefcase"></i>{{$data->user->name}} (Author)</li>

                                </ul>
                            </div>
                        </div>
                        <div class="blog-content">

                            <p>{{$data->description}}</p>
                        </div>
                    </div>

                    <div class="card clearfix">
                        <div class="card-header">
                            <div class="card-btn-group">
                                @if(!empty($data->file))
                                <audio preload="auto" controls style="width: 300px !important">
                                    <source src="{{$data->file}}" />
                                </audio>
                                @endif
                            </div>
                        </div>

                        <div class="card blog-share clearfix">
                            <div class="card-header">
                                <h4 class="card-title">Share the podcast</h4>
                            </div>
                            <div class="card-body">
                                <div class="icons">
                                    <div id="share"></div>
                                </div>
                            </div>
                        </div>


                    </div>
                   
                </div>
            </div>
            <div class="col-lg-4 col-md-12 sidebar-right theiaStickySidebar"
                style="position: relative; overflow: visible; box-sizing: border-box; min-height: 1px;">

                <div class="theiaStickySidebar"
                    style="padding-top: 0px; padding-bottom: 1px; position: static; transform: none;">
                    <div class="card search-widget">
                        <div class="card-body">
                            <form class="search-form">
                                <div class="input-group">
                                    <input type="text" placeholder="Search..." class="form-control">
                                    <div class="input-group-append">
                                        <button type="submit" class="btn btn-primary"><i
                                                class="fa fa-search"></i></button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                    <div class="card post-widget">
                        <div class="card-header">
                            <h3 class="card-title font-weight-bold">Episodes</h3>
                        </div>
                        <div class="card-body">
                            <ul class="latest-posts">
                                @foreach($episods as $episod)
                                <li>
                                    <div class="post-thumb">
                                        <a href="{{ url('podcast/details/'.encrypted_key($episod->id,'encrypt'))}}">
                                        @if(file_exists( storage_path().'/podcasts/'.$episod->image ) && !empty($episod->image))
                                        <img src="{{asset('storage')}}/podcasts/{{ $episod->image }}" class="img-fluid" alt="...">
                                        @else
                                        <img src="{{ asset('public')}}/image/patterns/globe-pattern.png"
                                            class="img-fluid" alt="img">
                                        @endif                                        </a>
                                    </div>
                                    <div class="post-info">
                                        <h3>
                                            <a href="{{ url('podcast/details/'.encrypted_key($episod->id,'encrypt'))}}">{{$episod->title}}</a>
                                        </h3>
                                        <p class="mentor-type"><a href="{{ url('podcast/details/'.encrypted_key($episod->id,'encrypt'))}}" class="font-size-3 text-default-color line-height-2">
                                        @if($episod->episode) Episode-{{$episod->episode}} @endif

                                    </a></p>
                                        
                                        <p>{{date('M d, Y', strtotime($episod->created_at))}}</p>
                                    </div>
                                </li>
                               @endforeach
                            </ul>
                        </div>
                    </div>
                    <div class="card post-widget">
                        <div class="card-header">
                            <h3 class="card-title font-weight-bold">Related Podcasts</h3>
                        </div>
                        <div class="card-body">
                            <ul class="latest-posts">
                                @if($related->count() >=1)
                                @foreach($related as $episod)
                                <li>
                                    <div class="post-thumb">
                                        <a href="{{ url('podcast/details/'.encrypted_key($episod->id,'encrypt'))}}">
                                        @if(file_exists( storage_path().'/podcasts/'.$episod->image ) && !empty($episod->image))
                                        <img src="{{asset('storage')}}/podcasts/{{ $episod->image }}" class="img-fluid" alt="...">
                                        @else
                                        <img src="{{ asset('public')}}/image/patterns/globe-pattern.png"
                                            class="img-fluid" alt="img">
                                        @endif                                        </a>
                                    </div>
                                    <div class="post-info">
                                        <h3>
                                            <a href="{{ url('podcast/details/'.encrypted_key($episod->id,'encrypt'))}}">{{$episod->title}}</a>
                                        </h3>
                                        <p>
                                        <a href="{{ url('podcast/details/'.encrypted_key($episod->id,'encrypt'))}}">{{ strip_tags(Illuminate\Support\Str::limit($episod->description, 100, $end='...')) }}</a>
                                        </p>
                                        
                                        <p>{{date('M d, Y', strtotime($episod->created_at))}}</p>
                                    </div>
                                </li>
                               @endforeach
                               @else
                                <div class="text-center errorSection">
                                    <span>No Data Found</span>
                                </div>
                                @endif
                            </ul>
                        </div>
                    </div>

                    <div class="resize-sensor"
                        style="position: absolute; inset: 0px; overflow: hidden; z-index: -1; visibility: hidden;">
                        <div class="resize-sensor-expand"
                            style="position: absolute; left: 0; top: 0; right: 0; bottom: 0; overflow: hidden; z-index: -1; visibility: hidden;">
                            <div
                                style="position: absolute; left: 0px; top: 0px; transition: all 0s ease 0s; width: 450px; height: 2905px;">
                            </div>
                        </div>
                        <div class="resize-sensor-shrink"
                            style="position: absolute; left: 0; top: 0; right: 0; bottom: 0; overflow: hidden; z-index: -1; visibility: hidden;">
                            <div style="position: absolute; left: 0; top: 0; transition: 0s; width: 200%; height: 200%">
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>

    </div>
    <!-- /Page Content -->
    @endsection

    @push('script')
    <!--Shape End-->
    <link href="{{ asset('public') }}/frontend/css/custom-audio-player.css" rel="stylesheet" type="text/css" />
    <script src="{{ asset('public/frontend/js/audioplayer.js') }}"></script>
    <script src="{{ asset('public/frontend/js/custom-audio-player.js') }}"></script>

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jsSocials/1.5.0/jssocials-theme-flat.min.css"
        integrity="sha256-1Ru5Z8TdPbdIa14P4fikNRt9lpUHxhsaPgJqVFDS92U=" crossorigin="anonymous" />
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jsSocials/1.5.0/jssocials.min.js"
        integrity="sha256-QhF/xll4pV2gDRtAJ1lvi9YINqySpAP+0NIzIX5voZw=" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jsSocials/1.5.0/jssocials.min.css"
        integrity="sha256-1tuEbDCHX3d1WHIyyRhG9D9zsoaQpu1tpd5lPqdqC8s=" crossorigin="anonymous" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.10.2/css/all.min.css"
        integrity="sha256-zmfNZmXoNWBMemUOo1XUGFfc0ihGGLYdgtJS3KCr/l0=" crossorigin="anonymous" />
    <script>
    $(document).ready(function() {
        $("#share").jsSocials({
            shares: ["twitter", "facebook", "googleplus", "linkedin", "pinterest", "stumbleupon",
                "whatsapp"
            ],
            showCount: false
        });

    });
    $(function() {
        $('audio').audioPlayer();
    });
    </script>


    @endpush