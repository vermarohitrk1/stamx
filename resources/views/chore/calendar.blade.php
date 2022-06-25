<?php $page = "Chore Calandar"; ?>
@section('title')
    {{$page}}
@endsection
@extends('layout.dashboardlayout')
@section('content')	
 @php
        $user=Auth::user();
        $permissions=permissions();
        @endphp
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
                <div class=" col-md-12 ">
                   <a href="{{ route('chore.dashboard') }}" class="btn btn-sm btn-primary float-right btn-icon-only rounded-circle " >
        <span class="btn-inner--icon"><i class="fas fa-reply"></i></span>
    </a>
                     </div>
   
<!-- Breadcrumb -->
<div class="breadcrumb-bar mt-3">
    <div class="container-fluid">
        <div class="row align-items-center">
            <div class="col-md-12 col-12">
                <h2 class="breadcrumb-title">Chore Calandar</h2>
                <nav aria-label="breadcrumb" class="page-breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Home</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('chore.dashboard') }}">Chore</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Chore Calandar</li>
                    </ol>
                </nav>
            </div>              
        </div>            
    </div>
</div>
<!-- /Breadcrumb -->





<div class="row mt-3" id="blog_view">
     <div class="col-12">
        <div class="card">
            <div class="card-body">
                <div class="page-title">
        <div class="row pb-3">
            <div class="col-6">
                <h5 class="h4 d-inline-block font-weight-400 mb-0 text-white">{{__('Calendar')}}</h5>
            </div>
             @if(in_array("manage_chores",$permissions) || $user->type =="admin") 
             @if(!empty($members) && count($members) >0)
            <div class="col-6 text-right">
               
                <select class="form-control form-control-sm w-auto d-inline" size="sm" name="project" id="project">
                    <option value="all">{{__('All Members')}}</option>
                    @foreach($members as $assigned_to)
                        <option value="{{$assigned_to->id}}" {{ ($assigned_to_id == $assigned_to->id) ? 'selected' : ''}}>{{ $assigned_to->name." (".$assigned_to->type.")" }}</option>
                    @endforeach
                </select>
                <button class="btn btn-white btn-sm ml-2" id="filter"><i class="mdi mdi-check"></i>{{__('Apply')}}</button>
            </div>
            @endif
            @endif
        </div>
        <div class="row justify-content-between align-items-center">
            <div class="col d-flex align-items-center">
                <h5 class="fullcalendar-title h4 d-inline-block font-weight-400 mb-0 text-white">{{__('Calendar')}}</h5>
            </div>
            <div class="col-lg-6 mt-3 mt-lg-0 text-lg-right">
                <div class="btn-group" role="group" aria-label="Basic example">
                    <a href="#" class="fullcalendar-btn-prev btn btn-sm btn-neutral">
                        <i class="fas fa-angle-left"></i>
                    </a>
                    <a href="#" class="fullcalendar-btn-next btn btn-sm btn-neutral">
                        <i class="fas fa-angle-right"></i>
                    </a>
                </div>
                <div class="btn-group" role="group" aria-label="Basic example">
                    <a href="#" class="btn btn-sm btn-neutral" data-calendar-view="month">{{__('Month')}}</a>
                    <a href="#" class="btn btn-sm btn-neutral" data-calendar-view="basicWeek">{{__('Week')}}</a>
                    <a href="#" class="btn btn-sm btn-neutral" data-calendar-view="basicDay">{{__('Day')}}</a>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col">
            <div class="card overflow-hidden">
                <div class="calendar" data-toggle="task-calendar"></div>
            </div>
        </div>
    </div>
<!-- /Mentor Details Tab -->
</div>



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

 <link rel="stylesheet" href="{{ asset('assets/libs/fullcalendar/dist/fullcalendar.min.css') }}">
<script src="{{ asset('assets/libs/fullcalendar/dist/fullcalendar.min.js') }}"></script>

<script>
        var e, t, a = $('[data-toggle="task-calendar"]');
        a.length && (t = {
            header: {right: "", center: "", left: ""},
            buttonIcons: {prev: "calendar--prev", next: "calendar--next"},
            theme: !1,
            selectable: !0,
            selectHelper: !0,
            editable: !0,
            events: {!! json_encode($arrTasks) !!} ,
            eventStartEditable: !1,
            locale: '{{basename(App::getLocale())}}',
            dayClick: function (e) {
                var t = moment(e).toISOString();
                location.href=t;
//                $("#new-event").modal("show"), $(".new-event--title").val(""), $(".new-event--start").val(t), $(".new-event--end").val(t)
            },
//            eventResize: function (event) {
//                var eventObj = {
//                    start: event.start.format(),
//                    end: event.end.format(),
//                };
//
//                $.ajax({
//                    url: event.resize_url,
//                    method: 'PUT',
//                    data: eventObj,
//                    success: function (response) {
//                    },
//                    error: function (data) {
//                        data = data.responseJSON;
//                    }
//                });
//            },
            viewRender: function (t) {
                e.fullCalendar("getDate").month(), $(".fullcalendar-title").html(t.title)
            },
            eventClick: function (e, t) {
                var title = e.title;
                var url = e.url;

                if (typeof url != 'undefined') {
                     location.href=url;
//                    $("#commonModal .modal-title").html(title);
//                    $("#commonModal .modal-dialog").addClass('modal-md');
//                    $("#commonModal").modal('show');
//                    $.get(url, {}, function (data) {
//                        $('#commonModal .modal-body').html(data);
//                    });
                    return false;
                }
            }
        }, (e = a).fullCalendar(t),
            $("body").on("click", "[data-calendar-view]", function (t) {
                t.preventDefault(), $("[data-calendar-view]").removeClass("active"), $(this).addClass("active");
                var a = $(this).attr("data-calendar-view");
                e.fullCalendar("changeView", a)
            }), $("body").on("click", ".fullcalendar-btn-next", function (t) {
            t.preventDefault(), e.fullCalendar("next")
        }), $("body").on("click", ".fullcalendar-btn-prev", function (t) {
            t.preventDefault(), e.fullCalendar("prev")
        }));

        $(document).on("click", "#filter", function () {
                var select_user=$("#project").val();
                window.location.href = "{{url('chore/calendar')}}/" +select_user;
           
        });
    </script>


@endpush