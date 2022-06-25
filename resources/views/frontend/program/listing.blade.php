<?php $page = "search"; ?>
@extends('layout.commonlayout')
@section('content')
<style>
.pct-remove-column span {
    font-size: 24px;
}

.mentor-type {

    margin-bottom: 5px;
}

.mentor-widget .usr-name {

    margin-bottom: 10px;
}

.field.pct-form-field.compare-field {
    /* display: inline-block!important;
    width: 32%!important; */
    padding: 15px;
    /* margin-right: 5px; */
}
.mentor-widget {
    border: 0;
    width: 100%;
    border-radius: 12px;
    margin-bottom: 1.875rem;
    background: #fff;
    -webkit-box-shadow: 0 10px 30px 0 rgb(24 28 33 / 5%);
    box-shadow: 0 10px 30px 0 rgb(24 28 33 / 5%);
    padding: 20px;
}

span.pct-degree-type {
    font-weight: 400;
}

.pct-remove-column {
    position: absolute;
    top: 6px;
    right: 8px;
    color: rgba(60, 60, 68, 1);
    font-size: .875em;
    line-height: 1em;
    font-weight: 400;
}

.pct-remove-column {
    display: block;
    font-size: .5em;
    right: 5px;
}

.pct-compare .pct-degree-name {
    color: rgba(60, 60, 67, 1);
    font-size: 1em;
    font-weight: 700;
    line-height: 1.25em;
}

.compare-field div.pct-form-label-grey {
    font-weight: 500;
    font-size: 1.2em;
    color: rgba(173, 173, 173, 1);
    height: 100%;
    width: 100%;
    text-align: center;
    vertical-align: middle;
    line-height: 2.104em;
}

.pct-compare .field.pct-form-field.active:not(.submit), .pct-compare .field.pct-form-field:not(.submit) {
    /* display: table-cell; */
    /* width: 27%;
    margin-bottom: 0;
    min-height: 0; */
    height: 100px;
}
.pct-compare .field.pct-form-field.active:not(.submit) {
    border: 0;
    background-color: rgba(255,255,255,1);
    text-align: center;
    /* width: 33%; */
    position: relative;
    vertical-align: middle;
}
.pct-drawer-header .pct-form-submit {
    float: right;
}
.pct-bottom-drawer-top-wrapper {
    margin: 1.25em 0;
}


.pct-section-title {
    color: rgba(245, 245, 245, 1);
    font-size: 18px;
}


.pct-compare .pct-form-field.active #submit_button,
.pct-compare .pct-form-field.active .submit_button {
    background-color: rgba(253, 191, 56, 1);
    font-size: 16px;
}

.pct-compare {
    position: fixed;
    bottom: 0;
    width: 100%;
    background-color: rgba(60, 60, 68, .8);
    padding: 0 3.75em .667em;
    box-sizing: border-box;
    z-index: 20;
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
.field.submit.mobile-tablet-only.pct-form-field.dock-compare-button {
    display: none;
}
.field.pct-form-field.compare-field:not(.active) {
    background: #e7e7e7;
}
.field.submit.desktop-only.pct-form-field.dock-compare-button #submit_button{
float: right;
}
@media only screen and (max-width: 767px){

.card.blog-share iframe {
    width: 100%;
}
ul.list-unstyled.filter-check-list a {
   
    display: flex;
}

.pct-compare .field.pct-form-field.active:not(.submit), .pct-compare .field.pct-form-field:not(.submit) {
    height: 70px;
}
.field.submit.desktop-only.pct-form-field.dock-compare-button .pct-form-submit {
    display: none;
}
.field.submit.mobile-tablet-only.pct-form-field.dock-compare-button {
    display: block;
}
.field.submit.row {
    width: 100%;
}
.pct-compare .pct-form-field.active #submit_button {
    width: 100%;
    padding: 8px;
}
}

@media only screen and (max-width : 991px)  {
    .user-infos .field.pct-form-field {
    display: flex;
}
}
</style>
<!-- Breadcrumb -->
<div class="breadcrumb-bar">
    <div class="container-fluid">
        <div class="row align-items-center">
            <div class="col-md-8 col-12">
                <nav aria-label="breadcrumb" class="page-breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ url('')}}">Home</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Program</li>
                    </ol>
                </nav>
                <h2 class="breadcrumb-title">Program</h2>
            </div>
            <div class="col-md-4 col-12 d-md-block d-none">
                <!--<div class="sort-by">
						<span class="sort-title">Sort by</span>
                    <span class="sortby-fliter">
                        <select class="select">
                            <option>Select</option>
                            <option class="sorting">Rating</option>
                            <option class="sorting">Popular</option>
                            <option class="sorting">Latest</option>
                            <option class="sorting">Free</option>
                        </select>
                    </span>
                </div>-->
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
                        <h4 class="card-title mb-0">Search Filter</h4>
                    </div>
                    <div class="card-body">
                        <div class="card search-widget">
                            <form class="search-form">
                                <div class="input-group">
                                    <input type="text" id="s" placeholder="Search..." class="form-control">
                                    <div class="input-group-append">
                                        <button disabled="" type="submit" class="btn btn-primary"><i
                                                class="fa fa-search"></i></button>
                                    </div>
                                </div>
                            </form>
                        </div>
                        @if(!empty($category) && count($category)>0)
                        <div class="filter-widget">
                            <h4>Category</h4>


                            <ul class="list-unstyled filter-check-list filter-check-list-time">

                                @foreach($category as $key => $p_category)
                                <li class="mb-2"><a href="javascript:void(0)" data-val="{{ $p_category->id }}"
                                        class="toggle-item">{{ $p_category->name }}</a></li>

                                @endforeach
                            </ul>
                        </div>
                        @endif




                        <div class="btn-search">

                        </div>
                    </div>
                </div>
                <!-- /Search Filter -->

            </div>

            <div class="col-md-8 col-lg-8 col-xl-9">

                <!-- Programs Widget -->

                <div class="card">
                    <div class="card-body">



                        <div class="pagify-parent custom-pagify" id="data-holder">

                        </div>
                    </div>
                </div>


                <!-- /Books Widget -->


                <!--<div class="col-md-12 d-flex justify-content-center">
                 
									<ul class="pagination">
											<li class="page-item disabled">
												<a class="page-link" href="#" tabindex="-1">Previous</a>
											</li>
											<li class="page-item"><a class="page-link" href="#">1</a></li>
											<li class="page-item active">
												<a class="page-link" href="#">2 <span class="sr-only">(current)</span></a>
											</li>
											<li class="page-item"><a class="page-link" href="#">3</a></li>
											<li class="page-item">
												<a class="page-link" href="#">Next</a>
											</li>
										</ul>
									
                </div>	-->
            </div>
        </div>

    </div>

</div>

<!-- /Page Content -->

<section class="pct-compare" style="display: none;">
    <form id="pct-compare-form" name="pct-compare-form" method="get" action="program/comparison-tool/"
        class="pct-compare-form">
        <div class="pct-bottom-drawer-top-wrapper row">
            <div class="pct-drawer-header col-10">
                <h4 class="pct-section-title">Compare up to 3 Programs</h4>
            </div>
            <div class="field submit desktop-only pct-form-field dock-compare-button active col-2">
                <div class="pct-form-submit">

                    <input type="submit" onclick="return changeSubmit();" id="submit_button" name="submit_button"
                        value="COMPARE" class="btn">
                </div>
            </div>
        </div>
        <div class="pct-fieldset compare-dock row">
            <div class="col-md-4 my-3">
            <div class="field pct-form-field compare-field">
                <div class="pct-form-label-grey">Program 1</div>
            </div></div>
            <div class="col-md-4 my-3">
            <div class="field pct-form-field compare-field">
                <div class="pct-form-label-grey">Program 2</div>
            </div></div>
            <div class="col-md-4 my-3">
            <div class="field pct-form-field compare-field">
                <div class="pct-form-label-grey">Program 3</div>
            </div>
        </div>
            <div class="field submit mobile-tablet-only pct-form-field dock-compare-button active row">
                    <div class="pct-form-submit col-12">

                    <input type="submit" onclick="return changeSubmit();" id="submit_button" name="submit_button"
                        value="COMPARE" class="btn">

            </div>
            </div>
        </div>
    </form>
</section>
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
$(function() {

    var search = '';
    var category = 'All';
    var time = '';
    filter();
});
$("#s").keyup(function() {


    filter();
});
$("#job_category").change(function() {
    filter();
});
$(".custom-control-input").click(function() {
    filter();
});
// filter time
$(".filter-check-list-time").on('click', '.toggle-item', function(e) {

    filter();
});
// filter type
$(".filter-check-list-type").on('click', '.toggle-item', function(e) {
    filter();
});
// filter experience
$(".filter-check-list-experience").on('click', '.toggle-item', function(e) {
    filter();
});

//pagination
$(document).on('click', '.pagination a', function(e) {
    var paginationUrl = 'page=' + $(this).attr('href').split('page=')[1];
    filter(paginationUrl);
    e.preventDefault();
});
//    $(function() {
//    $(".pm-range-slider").slider({
//        range: true,
//        min: 0,
//        max: 0,
//        values: [0, 0],
//        slide: function(event, ui) {
//            $("#amount").val("$" + ui.values[0] + " - " + ui.values[1] + "");
//            $("#min_amount").val(ui.values[0]);
//            $("#max_amount").val(ui.values[1]);
//            filter();
//        }
//    });
//    $("#amount").val("$" + $(".pm-range-slider").slider("values", 0) +
//        " - " + $(".pm-range-slider").slider("values", 1) + "");
//});
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
    var min_amount = $("#min_amount").val();
    var max_amount = $("#max_amount").val();
    var search = $("#s").val();
    var category = $("#job_category").val();

    var filterTypeArray = [];
    $('ul.filter-check-list-time').find('.clicked').each(function() {
        filterTypeArray.push($(this).attr('data-val'));
    });

    var data = {
        view: $("#view_type").val(),
        search: search,
        category: filterTypeArray,
        _token: "{{ csrf_token() }}",
    }
    $.post(
        "{{route('program.filter')}}?" + page,
        data,
        function(data) {
            $("#data-holder").html(data);
            $(".pagify-pagination").remove();
            //                    $(".pagify-parent").pagify(4, ".pagify-child");
        }
    );
}
</script>

@endpush