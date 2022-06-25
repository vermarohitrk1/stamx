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
                        <li class="breadcrumb-item"><a href="index">Home</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Books</li>
                    </ol>
                </nav>
                <h2 class="breadcrumb-title">Books Details</h2>
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
                                                 
                    <h3 class="blog-title mb-5">{!! html_entity_decode(ucfirst($book->title), ENT_QUOTES, 'UTF-8') !!}
                        </h3>
                        <!-- <div class="blog-image">
                            <a href="javascript:void(0);">
                                @if(file_exists( storage_path().'/books/'.$book->image ) && !empty($book->image))
                                <img src="{{asset('storage')}}/books/{{ $book->image }}" class="img-fluid" alt="...">
                                @else
                                <img src="{{ asset('public')}}/demo23/image/patterns/globe-pattern.png"
                                    class="img-fluid" alt="img">
                                @endif

                            </a>
                        </div> -->
                        <h2 class="blog-title">
                           <span class="hire-rate">Price: ${{$book->price}}</span>
                        </h2>
                                        <!-- card-btn-group start -->
                        <div class="card-btn-group">
                                @if(!empty($afflink))
                                <a class="text-uppercase btn btn-warning btn-lgmr-4 mb-5" href="{{$afflink}}" target='_blank'>Buy Now By Amazon</a>
                                @endif
                                @if(!empty($itunes))
                                <a class="btn btn-danger text-uppercase rounded-3 w-180 mr-4 mb-5" href="{{$itunes}}" target='_blank'>Buy Now From iTunes</a>
                                @endif
                              
                              <!-- card-btn-group end -->
                        </div>

                        <div class="blog-info clearfix">
                            <div class="post-left">
                                <ul>
                                  
                                  <li><i class="fas fa-user"></i>@if($book->author != null) {{ $book->author }} @else not available  @endif</li>
                                  <li><i class="fas fa-map-marker"></i>@if($book->marketplace != null) {{ $book->marketplace }} @else not available  @endif</li>

                                    <li><i
                                            class="fa fa-briefcase"></i>{{!empty($book->category) && !empty($book->getcategory($book->category)) ? $book->getcategory($book->category) :'General'}}
                                    </li>

                                </ul>
                            </div>
                        </div>
                        <div class="blog-content">

                            <p>{!! html_entity_decode($book->description, ENT_QUOTES, 'UTF-8') !!}</p>
                        </div>
                    </div>

                    @if($book->show_video == 'Yes')
                    @if(!empty($book->youtube))
                    <div class="card blog-share clearfix">
                        <div class="card-header">
                            <iframe width="682" height="315" src="https://www.youtube.com/embed/{{$book->youtube}}">
                            </iframe>


                        </div>
                    </div>
                    @endif
                    @endif

                    <div class="card blog-share clearfix">
                        <div class="card-header">
                            <h4 class="card-title">Share the book</h4>
                        </div>
                        <div class="card-body">
                            <div class="icons">
                                <div id="share"></div>
                            </div>
                        </div>
                    </div>
                    

                </div>
            </div>

            <!-- Blog Sidebar -->
            <div class="col-lg-4 col-md-12 sidebar-right theiaStickySidebar">
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


                <!-- Latest Posts -->
                <div class="card post-widget">
                    <div class="card-header">
                        <h3 class="card-title">Featured Books</h3>
                    </div>
                    <div class="card-body">
                        <ul class="latest-posts">
                        @if($book_featured->count() > 0)
                            @foreach($book_featured as $books)
                            <li>
                                <div class="post-thumb">
                                    <a href="{{ url('books/details/'.encrypted_key($books->id,'encrypt'))}}">
                                        @if(file_exists( storage_path().'/books/'.$books->image ) && !empty($books->image))
                                        <img src="{{asset('storage')}}/books/{{ $books->image }}" class="img-fluid" alt="...">
                                        @else
                                        <img src="{{ asset('public')}}/image/patterns/globe-pattern.png"
                                            class="img-fluid" alt="img">
                                        @endif
                                    </a>
                                </div>
                                <div class="post-info">
                                <h3><a href="{{ url('books/details/'.encrypted_key($books->id,'encrypt'))}}" class="font-weight-bold">{{$books->title}}</a></h3>
                                    <p>
                                        <a href="{{ url('books/details/'.encrypted_key($books->id,'encrypt'))}}">{{ strip_tags(Illuminate\Support\Str::limit($books->description, 150, $end='...')) }}</a>
                            </p>
                                    <p>{{date('M d, Y', strtotime($books->created_at))}}</p>
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
                <!-- /Latest Posts -->
                <!-- Latest Posts -->
                <div class="card post-widget">
                    <div class="card-header">
                        <h3 class="card-title">Trending Books</h3>
                    </div>
                    <div class="card-body">
                        <ul class="latest-posts">
                        @if($book_treading->count() > 0)
                            @foreach($book_treading as $books)
                            <li>
                                <div class="post-thumb">
                                    <a href="{{ url('books/details/'.encrypted_key($books->id,'encrypt'))}}">
                                        @if(file_exists( storage_path().'/books/'.$books->image ) && !empty($books->image))
                                        <img src="{{asset('storage')}}/books/{{ $books->image }}" class="img-fluid" alt="...">
                                        @else
                                        <img src="{{ asset('public')}}/image/patterns/globe-pattern.png"
                                            class="img-fluid" alt="img">
                                        @endif
                                    </a>
                                </div>

                                <div class="post-info">
                                <h3><a href="{{ url('books/details/'.encrypted_key($books->id,'encrypt'))}}" class="font-weight-bold">{{$books->title}}</a></h3>
                                    <p>
                                        <a href="{{ url('books/details/'.encrypted_key($books->id,'encrypt'))}}">{!! strip_tags(Illuminate\Support\Str::limit($books->description, 150, $end='...')) !!}</a>
                            </p>
                                    <p>{{date('M d, Y', strtotime($books->created_at))}}</p>
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
                <!-- /Latest Posts -->
                <!-- Latest Posts -->
                <div class="card post-widget">
                    <div class="card-header">
                        <h3 class="card-title">Favourite Books</h3>
                    </div>
                    <div class="card-body">
                        <ul class="latest-posts">
                            @if($book_favourite->count() > 0)
                            @foreach($book_favourite as $books)
                            <li>
                                <div class="post-thumb">
                                    <a href="{{ url('books/details/'.encrypted_key($books->id,'encrypt'))}}">
                                        @if(file_exists( storage_path().'/books/'.$books->image ) && !empty($books->image))
                                        <img src="{{asset('storage')}}/books/{{ $books->image }}" class="img-fluid" alt="...">
                                        @else
                                        <img src="{{ asset('public')}}/image/patterns/globe-pattern.png"
                                            class="img-fluid" alt="img">
                                        @endif
                                    </a>
                                </div>
                                <div class="post-info">
                                <h3><a href="{{ url('books/details/'.encrypted_key($books->id,'encrypt'))}}" class="font-weight-bold">{{$books->title}}</a></h3>
                                    <p>
                                        <a href="{{ url('books/details/'.encrypted_key($books->id,'encrypt'))}}">{!! strip_tags(Illuminate\Support\Str::limit($books->description, 150, $end='...')) !!}</a>
                            </p>
                                    <p>{{date('M d, Y', strtotime($books->created_at))}}</p>
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
                <!-- /Latest Posts -->
                <!-- Book Cat -->
                <div class="card category-widget">
                    <div class="card-header">
                        <h3 class="card-title">Book Categories</h3>
                    </div>
                    <div class="card-body">
                        <ul class="categories">
                        @foreach($BookCategory as $cat)
                        <li><a href="#">{{$cat->name}} <span>({{$cat->count}})</span></a></li>
                         @endforeach
                        </ul>
                    </div>
                </div>
                <!-- /Book Cat -->

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
        shares: ["twitter", "facebook", "linkedin", "pinterest",
            "whatsapp"],
        showCount: false
    });

});
</script>
<script>
$("#s").keyup(function() {
    window.location.href = "{{url('books')}}";
});
$("#job-catagories").change(function() {
    window.location.href = "{{url('books')}}";
});
$(".custom-control-input").click(function() {
    window.location.href = "{{url('books')}}";
});
</script>
<script language="javascript">
       
       function createCookie(name,value,days) {
         if (days) {
             var date = new Date();
             date.setTime(date.getTime()+(days*24*60*60*1000));
             var expires = "; expires="+date.toGMTString();
         }
         else var expires = "";
         
         document.cookie = name+"="+value+expires+"; path=/";
         }
         
         function readCookie(name) {
             var nameEQ = name + "=";
             var ca = document.cookie.split(';');
             for(var i=0;i < ca.length;i++) {
                 var c = ca[i];
                 while (c.charAt(0)==' ') c = c.substring(1,c.length);
                 if (c.indexOf(nameEQ) == 0) return c.substring(nameEQ.length,c.length);
             }
             return null;
         }

        

            jQuery(document).ready(function() {
              
                if(readCookie('book'+'{{$book->id}}') !='{{$book->id}}'){
                    trending('{{$book->id}}');
                }
            });

            function trending(id)
            {
                var data = {id:id, _token: "{{ csrf_token() }}"};
                $.post(
                "{{route('book.trending')}}",
                data,
                function (data) {
                    if(data.responce == 'success')
                    createCookie('book'+'{{$book->id}}','{{$book->id}}', '30');
                }
                );
            }
      </script>

@endpush