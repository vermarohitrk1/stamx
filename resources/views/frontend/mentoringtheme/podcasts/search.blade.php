<?php $page = "podcast"; ?>
@extends('layout.commonlayout')
@push('css')
<style>
.result-view-type a.active {
    color: #adb4b7;
}
.text-center.errorSection {
    font-size: 20px;
}
.filter-check-list a:before {
    content: "\f0c8";
    font-weight: 400;
    font-family: "Font Awesome 5 Free";
    display: inline-block;
    color: #7e8989;
    margin-right: 11px;
    margin-top: 2px;
}
.filter-check-list a.clicked:before {
    content: "\f14a";
    font-weight: 900;
    color: #282733;
}
ul.list-unstyled.filter-check-list a {
    font-size: 15px;
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
                <h2 class="breadcrumb-title">Podcast</h2>
            </div>
        </div>
    </div>
</div>
<!-- /Breadcrumb -->
<!-- Page Content -->
<div class="content">
    <div class="container-fluid">

        <div class="row">
            <div class="col-md-4 col-lg-4 col-xl-3 theiaStickySidebar">


                 <!-- Search Filter -->
                 <div class="card search-filter">
                    <div class="card-header">
                        <h4 class="card-title mb-0 font-weight-bold">Search Filter</h4>
                    </div>
                    <div class="card-body">
                        <div class="card search-widget">
                            <form class="search-form">
                                <div class="input-group">
                                        <input type="text" id="s" placeholder="Search..." class="form-control">
                                    <div class="input-group-append">
                                        <button disabled="" type="submit" class="btn btn-primary"><i class="fa fa-search"></i></button>
                                    </div>
                                </div>
                            </form>
                        </div>
                        <div class="filter-widget">
                            <h4 class="font-weight-bold">Posted Time</h4>
                        
							
                                            <ul class="list-unstyled filter-check-list filter-check-list-time">
                                <li class="mb-2"><a href="javascript:void(0)" data-val="anytime" class="toggle-item">Anytime</a></li>
                                <li class="mb-2"><a href="javascript:void(0)" data-val="lasthour" class="toggle-item">Last Hour</a></li>
                                <li class="mb-2"><a href="javascript:void(0)" data-val="oneday" class="toggle-item">Last day</a></li>
                                <li class="mb-2"><a href="javascript:void(0)" data-val="sevenday" class="toggle-item">Last week</a></li>
                                <li class="mb-2"><a href="javascript:void(0)" data-val="onemonth" class="toggle-item">Last Month</a></li>
                            </ul>
                        </div>
						
						
                 
                   
                        <div class="btn-search">
                          
                        </div>	
                    </div>
                </div>
                <!-- /Search Filter -->
            </div>
            <!-- Main Body -->
            <div class="col-md-8 col-lg-8 col-xl-9">
                	
		        <div class="card">
                    <div class="card-body">
                        <!-- form -->
                                <form action="/" class="search-form">
                                    <div class="filter-search-form-2 search-1-adjustment bg-white rounded-sm shadow-7 pr-6 py-6 pl-6">
                                        <div class="filter-inputs row">
                                            <div class="col-md-6 form-group position-relative w-lg-45 w-xl-40 w-xxl-45">
                                                <select class="form-control select2 focus-reset pl-13"  id="job_category" placeholder="Job Category">
                                                    <option value="All">All</option>
                                                    @if($podcasts->count() > 0)
                                                    @foreach($podcasts as $category)
                                                    <option value="{{$category->id}}">{{ ucfirst(substr($category->title ,0,30)) }}..</option>
                                                    @endforeach
                                                    @endif

                                                </select>
                                            </div>
                                            <!-- .select-city starts -->
                                            <div class="col-md-6 form-group position-relative w-lg-55 w-xl-60 w-xxl-55">

                                                <input class="form-control focus-reset pl-13" type="text" id="s" placeholder="Search Title">
                                                <!-- <span class="h-100 w-px-50 pos-abs-tl d-flex align-items-center justify-content-center font-size-6">
                                                    <i class="icon icon-zoom-2 text-primary font-weight-bold"></i>
                                                </span> -->
                                            </div>
                                            <!-- ./select-city ends -->
                                        </div>

                                    </div>
                                </form>
                                <div class="pt-12">
                                    <div class="d-flex align-items-center justify-content-between mb-6">

                                        <div class="d-flex align-items-center result-view-type ">
                                            <a class="heading-default-color pl-5 font-size-6 hover-text-hitgray " onclick="return changeViewType('list')" title="List View" id="view_type_list" href="#">
                                                <i class="fa fa-list-ul"></i>
                                            </a>
                                            <a class="heading-default-color pl-5 font-size-6 hover-text-hitgray active" onClick="changeViewType('grid')" title="Grid View" id="view_type_grid" href="#">
                                                <i class="fa fa-th-large"></i>
                                            </a>
                                        </div>
                                    </div>
                                        
                                            
                                </div>
                        <!-- form end -->
                    </div>
                </div>
                <div class="pagify-parent custom-pagify" id="data-holder">
              </div>
            </div>
        </div>
 </div>

</div>

<input type="hidden" id="view_type" value="list" />
@endsection
@push('script')
<script>
    function toggleItem(params) {
    let getItem = document.querySelectorAll(".toggle-item");
    for (let i = 0; i < getItem.length; i++) {
        getItem[i].addEventListener('click', function(e) {
            if (e.target.classList.contains("clicked")) {
                e.target.classList.remove("clicked");
            } else {
                e.target.classList.add("clicked");
            }
        })
    }
}
toggleItem();
    $(function () {

        var search = '';
        var category = 'All';
        var time = '';
        filter();
    });
    $("#s").keyup(function () {
        filter();
    });
    $("#job_category").change(function () {
        filter();
    });
    $(".custom-control-input").click(function () {
        filter();
    });
    // filter time
    $(".filter-check-list-time").on('click', '.toggle-item', function (e) {
        filter();
    });
    // filter type
    $(".filter-check-list-type").on('click', '.toggle-item', function (e) {
        filter();
    });
    // filter experience
    $(".filter-check-list-experience").on('click', '.toggle-item', function (e) {
        filter();
    });

    //pagination
    $(document).on('click', '.pagination a', function (e) {
        var paginationUrl = 'page=' + $(this).attr('href').split('page=')[1];
        filter(paginationUrl);
        e.preventDefault();
    });

//    function for filter
    function changeViewType(view) {
        
        if (view == 'list') {
            $("#view_type_list").removeClass('active');
            $("#view_type_grid").addClass('active');
        } else {
            $("#view_type_list").addClass('active');
            $("#view_type_grid").removeClass('active');
        }
        $("#view_type").val(view);
        filter();

    }
    function filter(page = '') {
        list_gif_loader('open');
        var min_amount = $("#min_amount").val();
        var max_amount = $("#max_amount").val();
        var search = $("#s").val();
        var category = $("#job_category").val();
        var filterTimeArray = [];
        $('ul.filter-check-list-time').find('.clicked').each(function () {
            filterTimeArray.push($(this).attr('data-val'));
        });
        var filterTypeArray = [];
        $('ul.filter-check-list-type').find('.clicked').each(function () {
            filterTypeArray.push($(this).attr('data-val'));
        });
        var filterExpArray = [];
        $('ul.filter-check-list-experience').find('.clicked').each(function () {
            filterExpArray.push($(this).attr('data-val'));
        });
        var data = {
            view: $("#view_type").val(),
            search: search,
            category: category,
            time: filterTimeArray,
            type: filterTypeArray,
            experience: filterExpArray,
            max_amount: max_amount,
            min_amount: min_amount,
            id_encrypted: "{{$id_encrypted}}",
            _token: "{{ csrf_token() }}",
        }
        $.post(
                "{{route('podcasts.filter')}}?" + page,
                data,
                function (data) {
                    list_gif_loader('close');
                    $("#data-holder").html(data);
                    $(".pagify-pagination").remove();
                }
        );
    }
</script>
<!--Shape End-->
<link href="{{ asset('public') }}/frontend/css/custom-audio-player.css" rel="stylesheet" type="text/css" />
<script src="{{ asset('public/frontend/js/audioplayer.js') }}"></script>
<script src="{{ asset('public/frontend/js/custom-audio-player.js') }}"></script>
@endpush