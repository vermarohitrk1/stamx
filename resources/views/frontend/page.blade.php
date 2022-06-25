@extends('layout.commonlayout')
@push('css')
<style>
.shadow {
    box-shadow: none;
}
.h3, h3 {
    font-size: 3.5rem;
}
#jobkeywords a {
    color: #13c4a1;
}
</style>
@endpush
@section('content')		
<!-- <div class="breadcrumb-bar">
    <div class="container-fluid">
        <div class="row align-items-center">
            <div class="col-md-8 col-12">
                <nav aria-label="breadcrumb" class="page-breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ url('')}}">Home</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Page</li>
                    </ol>
                </nav>
                <h2 class="breadcrumb-title">{{$page->title}}</h2>
            </div>
 
        </div>
    </div> -->
</div>
<!-- /Breadcrumb -->	
<!-- Page Content -->
@if(!empty($page->title) && !empty($page->subtitle))
                        <section class="w-100 w-100"  @if(!empty($page->image)) style="padding: 100px 0;margin-top: 7rem;background-image:url({{url('/storage/pages/'.$page->image)}});background-size: cover;background-position: center;" @endif  >
                            <div class="container">
                                <div class="row justify-content-center">
                                    <div class="col-lg-12 text-center">
                                        <div class="page-next-level">
                                            <h3 class="title" style="color:{{($page->color??'#3c4858')}}">{{$page->title}}</h3>
                                            <h4 style="color:{{($page->color??'#3c4858')}}">{{$page->subtitle}}</h4>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </section>
                        @endif
<div class="content">
    
    <div class="container-fluid">

        <div class="row">
            <div class="col-12">

                
                @if(!empty($modules))
                            <!-- <section class="bg-half bg-light d-table w-100"  @if(!empty($modules->image)) style="opacity: 0.5;background-image:url({{url('/storage/module/'.$modules->image)}});background-size: cover;background-position: center;" @endif  >
                                <div class="container">
                                    <div class="row justify-content-center">
                                        <div class="col-lg-12 text-center">
                                            <div class="page-next-level">
                                                <h4 class="title" style="color:{{($modules->color??'#3c4858')}}">{{$modules->title}}</h4>
                                                <h6 style="color:{{($modules->color??'#3c4858')}}">{{$modules->subtitle}}</h6>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </section> -->
                @endif

                <section class="section">
                    <div class="container">
                        <div class="row">
                            <div class="col-lg-12 col-md-12 col-12">
                                <div class="sidebar sticky-bar p-4 rounded shadow">
                                    <!-- SEARCH -->
                                    <div class="widget mb-4 pb-4">
                                        <!-- <h4 class="widget-title">{{$page->page_name}}</h4> -->
                                        <div id="jobkeywords" class="widget-search mt-4 mb-0">
                                                <div>
                                                    {!! $page->page_data !!}
                                                </div>
                                        </div>
                                    </div>
                                    <!-- SEARCH -->

                                </div>
                            </div><!--end col-->

                            <div class="col-lg-9 col-md-6 col-12 mt-4 mt-sm-0 pt-2 pt-sm-0">
                                <div class="row pagify-parent custom-pagify" id="data-holder">

                                </div>
                                <!--end row-->
                            </div>
                            <!--end col-->
                        </div>
                        <!--end row-->
                    </div>
                    <!--end container-->
                </section>
                <!--end section-->
            </div>
        </div>
</div>
</div>
@endsection