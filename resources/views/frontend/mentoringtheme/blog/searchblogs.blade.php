<?php $page = "blog-grid"; ?>
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
                <h2 class="breadcrumb-title">Blogs</h2>
            </div>
        </div>
    </div>
</div>
<!-- /Breadcrumb -->

<!-- Page Content -->
<div class="content">
    <div class="container-fluid">

        <div class="row">
            <div class="col-lg-8 col-md-12" >
                <div class="row blog-grid-row" id="data-holder"></div>
            </div>

            <!-- Blog Sidebar -->
            <div class="col-lg-4 col-md-12 sidebar-right theiaStickySidebar">

                <!-- Search -->
                <div class="card search-widget">
                    <div class="card-body">
                        <form class="search-form">
                            <div class="input-group">
<input type="text" id="s" placeholder="Search..." class="form-control">
                                <div class="input-group-append">
                                    <button disabled="" type="submit" class="btn btn-primary"><i class="fa fa-search"></i></button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
                <!-- /Search -->
                
                
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
                                    <a href="{{route('blog.details',encrypted_key($row->id,"encrypt"))}}">
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
                                    <p>{{date('f d, Y', strtotime($row->created_at))}}</p>
                                </div>
                            </li>
                            @endforeach
                            
                        </ul>
                    </div>
                </div>
                <!-- /Latest Posts -->
                            @endif
                
                            @if(!empty($recent_blogs_group) && count($recent_blogs_group) > 0)
                <!-- Categories -->
                <div class="card category-widget">
                    <div class="card-header">
                        <h4 class="card-title">Blog Categories</h4>
                    </div>
                    <div class="card-body">
                        <ul class="categories" >
                            <li><a class="categoryFilter text-primary" data-id="" href="javascript:void(0)">All</a></li>
                            @foreach($recent_blogs_group as $row)
                           <li><a class="categoryFilter" data-id="{{$row->category}}" href="javascript:void(0)">{{$row->getcategory($row->category)}} <span>({{$row->count??0}})</span></a></li>
                            @endforeach
                        </ul>
                    </div>
                </div>
                <!-- /Categories -->
                            @endif
                              @if(!empty($tags_array) && count($tags_array) > 0)
                <!-- Tags -->
                <div class="card tags-widget">
                    <div class="card-header">
                        <h4 class="card-title">Tags</h4>
                    </div>
                    <div class="card-body">
                        <ul class="tags">
                            <li><a href="javascript:void(0)" data-id="" class="tag tagFilter text-primary">All</a></li>
                             @foreach($tags_array as $row)
                             @foreach(array_unique(explode(',',$row)) as $i)
                            <li><a href="javascript:void(0)" data-id="{{$i}}" class="tag tagFilter">{{ucfirst($i)}}</a></li>
                            @endforeach
                            @endforeach
                            
                        </ul>
                    </div>
                </div>
                <!-- /Tags -->
                 @endif

            </div>
            <!-- /Blog Sidebar -->

        </div>
    </div>
</div>	
<!-- /Page Content -->

@endsection
@push('script')
<script>
    $(function () {

        var search = '';
        var category = '';
        var time = '';
        filter();
    });
    $("#s").keyup(function () {
        filter();
    });
    $(".categoryFilter").click(function () {
        $(".categoryFilter").removeClass("text-primary");
        $(this).addClass("text-primary");
        filter();
    });
    $(".tagFilter").click(function () {
        $(".tagFilter").removeClass("text-primary");
        $(this).addClass("text-primary");
        filter();
    });
   

    //pagination
    $(document).on('click', '.pagination a', function (e) {
        var paginationUrl = 'page=' + $(this).attr('href').split('page=')[1];
        filter(paginationUrl);
        e.preventDefault();
    });

    function filter(page = '') {
     
        var search = $("#s").val();
        var category = $(".categoryFilter.text-primary").data("id");
        var tag = $(".tagFilter.text-primary").data("id");
      
        var data = {
            search: search,
            category: category,
            tag: tag,
            _token: "{{ csrf_token() }}",
        }
        $.post(
                "{{route('blogs.filter')}}?" + page,
                data,
                function (data) {
                    $("#data-holder").html(data);
                    $(".pagify-pagination").remove();
//                    $(".pagify-parent").pagify(4, ".pagify-child");
                }
        );
    }
</script>
@endpush