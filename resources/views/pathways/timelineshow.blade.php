<?php $page = "pathway"; ?>
@extends('layout.dashboardlayout')
@push('css-cdn')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/aos/2.3.4/aos.css" />
<link rel="stylesheet" href="{{asset('public/css/timeline.css')}}">
@endpush
@section('content')

<style>
/* 
.toolimg{
  width:150px;
}

.col-3.uniquecol.un0 .corner.top-right.border_none {
    display: none;
}
.fullviewmap .blue-bg.newclass {
    width: 68%;
    margin: auto;
}
.col-3.uniquecol.un0 {
    overflow: visible;
}
.col-3.uniquecol.un0 {
    overflow: visible;
    display: block;
    text-align: right;
}

.col-3.uniquecol.un0 i {
    font-size: 50px;
    color: #fda01b;
    position: relative;
    left: -22px;
}


.col-3.uniquecol.text-center.full .img {
    display: flex;
}

.col-3.uniquecol.text-center.full img {
    margin-right: 6px;
}
.img.leftimg {
    display: flex;
    flex-direction: column;
    flex-flow: row-reverse;
}
.img.leftimg time.icon {
    margin-left: 0;
}
time.icon span {
    font-size: 8px;
    letter-spacing: -0.05em;
    padding-top: 13px;
    color: #2f2f2f;
}
  time.icon em
{
  position: absolute;
  bottom: 0.3em;
  color: #fd9f1b;
}
time.icon strong {
    position: absolute;
    top: 0;
    color: #fff;
    background-color: #fd9f1b;
    border-bottom: 1px dashed #f37302;
    box-shadow: 0 2px 0 #fd9f1b;
}
time.icon * {
    display: block;
    width: 100%;
    font-size: 7px;
    font-weight: bold;
    font-style: normal;
    text-align: center;
}
time.icon {
    display: block;
    position: relative;
    width: 25px;
    height: 25px;
    background-color: #fff;
    border-radius: 0.6em;
    box-shadow: 0 1px 0 #bdbdbd, 0 2px 0 #fff, 0 3px 0 #bdbdbd, 0 4px 0 #fff, 0 5px 0 #bdbdbd, 0 0 0 1px #bdbdbd;
    overflow: hidden;
    float: right;
    margin-left: 21px;
}
.img.leftimg {
    position: absolute;
    top: 7px;
}
.circle {
  font-weight: bold;
  padding: 15px 20px;
  border-radius: 50%;
  background-color: #6aa84f;
  color: #4D4545;
  max-height: 50px;
  z-index: 2;
}

.how-it-works.row {
  display: flex;
}
.how-it-works.row .col-3 {
    display: inline-flex;
    align-self: stretch;
    align-items: center;
    justify-content: flex-start;
}

.col-3.text-center.full {
    justify-content: flex-end;
}
.how-it-works.row .col-3::after {
  content: "";
  position: absolute;
  border-left: 8px solid #6aa84f;
  z-index: 1;
}
.how-it-works.row .col-3.bottom::after {
  height: 50%;
  left: 50%;
  top: 50%;
}
.how-it-works.row .col-3.full::after {
    height: 100%;
    left: calc(50% - 8px);
}
.how-it-works.row .col-3.top::after {
    height:63px;
    left: calc(50% - 0px);
    top: 0;
}

.col-3.uniquecol.text-center.full img {
    margin-right: -17px;
}
.timeline div {
  padding: 0;
  height: 40px;
}
.timeline hr {
  border-top: 8px solid #6aa84f;
  margin: 0;
  top: 17px;
  position: relative;
}
.timeline .col-3 {
  display: flex;
  overflow: hidden;
}
.timeline .corner {
  border: 8px solid #6aa84f;
  width: 100%;
  position: relative;
  border-radius: 15px;
}
.timeline .top-right {
    left: 50%;
    top: -38%;
}
.timeline .left-bottom {
  left: -50%;
  top: calc(50% - 3px);
}
.timeline .top-left {
    left: -50%;
    top: -38%;
}
.timeline .right-bottom {
  left: 50%;
  top: calc(50% - 3px);
}
.img img {
    width: 100%;
    max-width: 50px;
    z-index: 999999999;
    position: relative;
}
.img.leftimg img {
    margin-left: 6px;
}
.row.align-items-center.how-it-works {
    padding: 0!important;
}

.img_sec img {
    width: 55px;
    height: 55px;
}
.text_img span {
    display: block;
}

.img_sec {
    text-align: center;
    padding: 50px 0 0 0;
}
.text_img {
    display: inline-block;
    width: 48%;
    text-align: right;
}
.text_img.imgtag {
    text-align: right;
   
}
.text_img.imgtag2 {
    text-align: left;
   
}
.uniquecol {
    padding: 0;
} */
</style>
<!-- Page Content -->

<div class="content">
    <div class="container-fluid">

        <div class="row">
            <div class="col-md-5 col-lg-4 col-xl-3 theiaStickySidebar">

                <!-- Sidebar -->
                @include('layout.partials.userSideMenu')
                <!-- /Sidebar -->

            </div>

            <div class="col-md-7 col-lg-8 col-xl-9">
                <button type="button" class="btn btn-primary viewfull" data-toggle="button" aria-pressed="false"
                    autocomplete="off">
                    View full
                </button>
                <div class=" col-md-12 ">
                    <a href="{{  url()->previous() }}"
                        class="btn btn-sm btn-primary float-right btn-icon-only rounded-circle ">
                        <span class="btn-inner--icon"><i class="fas fa-reply"></i></span>
                    </a>
                </div>

                <!-- Breadcrumb -->
                <div class="breadcrumb-bar mt-3">
                    <div class="container-fluid">
                        <div class="row align-items-center">
                            <div class="col-md-12 col-12">
                                <h2 class="breadcrumb-title">Task Timeline</h2>
                                <nav aria-label="breadcrumb" class="page-breadcrumb">
                                    <ol class="breadcrumb">
                                        <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Home</a></li>
                                        <li class="breadcrumb-item"><a href="{{ route('pathway.get') }}">Pathway</a>
                                        </li>
                                        <li class="breadcrumb-item active" aria-current="page"> Timeline</li>
                                    </ol>
                                </nav>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- /Breadcrumb -->





                <div class="row mt-3" id="blog_view">
                    <div class="col-12 uniquecol">
                    @if(empty($timelineData))
                      nothing to show
                      @endif
                      <ul class="timeline">
                      @foreach($timelineData as $key => $timelines)
                      @if($loop->iteration % 2 != 0)
                        <!-- Item 1 -->
                        <li data-aos="fade-up">
                          <div class="direction-r">
                            <div class="flag-wrapper"> 
                            @if($timelines['type'] == 'mentor')
                            <span class="flag"><img src=" {{ $timelines['icon'] }}" alt='avatar'> {{ $timelines['name'] }}. <small>New Mentor Joined.</small></span>
                            @elseif($timelines['type'] == 'task')
                            <span class="flag"><img class="avatar-img rounded-circle" src=" {{ $timelines['userurl'] }}" alt='task Image'> {{ $timelines['name'] }} <i class="fas fa-clipboard-list"></i></span>
                            <span class="time-wrapper"><span class="time">{{date('M d, Y', strtotime($timelines['created_at'])) }}</span></span>
                            @elseif($timelines['type'] == 'comment')
                            <span class="flag"><img class="avatar-img rounded-circle" src=" {{ $timelines['userurl'] }}" alt='comment Image'> {{ $timelines['name'] }} <i class="fas fa-comment-dots"></i></span>
                            <span class="time-wrapper"> <span class="time">{{date('M d, Y', strtotime($timelines['created_at'])) }}</span></span>
                            @endif
                            </div>
                            @if($timelines['type'] == 'comment' || $timelines['type'] == 'task')
                            <div class="desc">{!! $timelines['desc'] !!}</div>
                            @endif
                          </div>
                        </li>
                        @else
                        <!-- Item 2 -->
                        <li data-aos="fade-up">
                          <div class="direction-l">
                            <div class="flag-wrapper"> 
                            @if($timelines['type'] == 'mentor')
                            <span class="flag"><img src=" {{ $timelines['icon'] }}" alt='avatar'> {{ $timelines['name'] }}. <small>New Mentor Joined.</small></span>
                            @elseif($timelines['type'] == 'task')
                            <span class="flag"><img class="avatar-img rounded-circle" src=" {{ $timelines['userurl'] }}" alt='avatar'> {{ $timelines['name'] }} <i class="fas fa-clipboard-list"></i></span>
                            <span class="time-wrapper"><span class="time">{{date('M d, Y', strtotime($timelines['created_at'])) }}</span></span>
                            @elseif($timelines['type'] == 'comment')
                            <span class="flag"><img class="avatar-img rounded-circle" src=" {{ $timelines['userurl'] }}" alt='comment'> {{ $timelines['name'] }} <i class="fas fa-comment-dots"></i></span>
                            <span class="time-wrapper"> <span class="time">{{date('M d, Y', strtotime($timelines['created_at'])) }}</span></span>
                            @endif
                            </div>
                            @if($timelines['type'] == 'comment' || $timelines['type'] == 'task')
                            <div class="desc">{!! $timelines['desc'] !!}</div>
                            @endif
                          </div>
                        </li>
                        @endif
                      @endforeach
                      </ul>
                    </div>
                </div>
            </div>





        </div>
    </div>

</div>


<!-- /Page Content -->

@endsection
@push('script')

<link rel="stylesheet" type="text/css" href="{{ asset('assets/css/simcify.min.css') }}">
<script src="{{ asset('assets/js/simcify.min.js') }}"></script>
<script src="{{ asset('assets/libs/dragula/dist/dragula.min.js') }}"></script>

<link rel="stylesheet" type="text/css" href="{{ asset('assets/libs/dropify/css/dropify.min.css') }}">
<script src="{{ asset('assets/libs/dropify/js/dropify.min.js') }}"></script>

<script src="{{ asset('public/ckeditor/ckeditor.js') }}"></script>
<script type="text/javascript" src="{{ asset('assets/js/jquery-ui.min.js') }}"></script>
<script type="text/javascript" src="{{ asset('assets/js/repeater.js') }}"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/aos/2.3.4/aos.js"></script>
<script>
$(document).ready(function() {
  AOS.init({
  duration: 1200,
})

    $('a[data-toggle="tooltip"]').tooltip({
        animated: 'fade',
        placement: 'bottom',
        html: true
    });
});
$('.viewfull').click(function() {
    $(this).text(function(i, v) {
        return v === 'View less' ? 'View full' : 'View less'
    })
    $(this).parent().siblings('.theiaStickySidebar').toggle('hide');
    $(this).parent().toggleClass("col-md-12");
    $(this).parent().toggleClass("col-lg-12");
    $(this).parent().toggleClass("col-xl-12");
    $(this).parent().toggleClass("fullviewmap");
});
</script>

@endpush