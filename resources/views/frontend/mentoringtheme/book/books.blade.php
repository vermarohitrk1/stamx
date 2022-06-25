<?php $page = "search"; ?>
@extends('layout.commonlayout')
@section('content')		
<style>
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
<!-- Breadcrumb -->
<div class="breadcrumb-bar">
    <div class="container-fluid">
        <div class="row align-items-center">
            <div class="col-md-8 col-12">
                <nav aria-label="breadcrumb" class="page-breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ url('')}}">Home</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Books</li>
                    </ol>
                </nav>
                <h2 class="breadcrumb-title">Books</h2>
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
                         @if($BookCategory->count() > 0)
                         <div class="filter-widget">
                            <h4>Categories</h4>
                            @foreach($BookCategory as $category)
                             <div>
                                <label class="custom_check">
                                    <input type="checkbox" name="category_check" id="checkbox_category_{{$category->id}}" class="checkbox_category" value="{{$category->id}}" >
                                    <span class="checkmark"></span> {{$category->name}}
                                </label>
                            </div>
                                @endforeach
                            
                        </div>
                                
                                @endif
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
                        <div class="filter-widget">
                        <h4 class="font-weight-bold">Filters</h4>
                                <ul class="list-unstyled filter-check-list filter-check-list-type">
                                <li class="mb-2"><a href="javascript:void(0)" data-val="latest" class="toggle-item">Latest</a></li>
                                <li class="mb-2"><a href="javascript:void(0)" data-val="featured" class="toggle-item">Featured</a></li>
                                <li class="mb-2"><a href="javascript:void(0)" data-val="tranding" class="toggle-item">Trending</a></li>
                            </ul>
                        </div>
						
						
                 
                   
                        <div class="btn-search">
                          
                        </div>	
                    </div>
                </div>
                <!-- /Search Filter -->

            </div>

            <div class="col-md-8 col-lg-8 col-xl-9">

                <!-- Books Widget -->
	
		<!-- <div class="card">
                    <div class="card-body"> -->
                       
						
						
						  <div class="pagify-parent custom-pagify" id="data-holder">

                </div>
                    <!-- </div>
                </div> -->
		
                
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
      $(".checkbox_category").click(function () {        
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
        if(view=='list'){
            $("#view_type_list").removeClass('active');
            $("#view_type_grid").addClass('active');
        }else{
            $("#view_type_list").addClass('active');
            $("#view_type_grid").removeClass('active');
        }
        $("#view_type").val(view);
        filter();
       
    }
    function filter(page='') {
        list_gif_loader('open');
        var min_amount = $("#min_amount").val();
        var max_amount = $("#max_amount").val();
        var search = $("#s").val();
         var categoryFilter = [];
     $.each($("input[name='category_check']:checked"), function(){
                  categoryFilter.push($(this).val());
            });
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
                category: categoryFilter,
                time: filterTimeArray,
                type: filterTypeArray,
                experience: filterExpArray,
                max_amount: max_amount,
                min_amount: min_amount,
                _token: "{{ csrf_token() }}",
            }
        $.post(
                "{{route('book.filter')}}?"+ page,
                data,
                function (data) {
                    list_gif_loader('close');
                    $("#data-holder").html(data);
                    $(".pagify-pagination").remove();
//                    $(".pagify-parent").pagify(4, ".pagify-child");
                }
        );
    }

</script>
@endpush

