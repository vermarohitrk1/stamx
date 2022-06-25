<?php $page = "Petition"; ?>
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
                        <li class="breadcrumb-item active" aria-current="page">Petition</li>
                    </ol>
                </nav>
            </div>
        </div>
    </div>
</div>
<!-- /Breadcrumb -->

<!-- Page Content -->
<div class="content">
    <div class="container-fluid">

        <div class=" row centered align-items-center text-center  align-self-center  put-center d-flex justify-content-center">
            <div class="col-lg-8 col-md-12  ">
                <div class="blog-view   ">
                    <div class="blog blog-single-post ">
                      
                        
                        <div class="blog-image">
                            <a href="#">
                                          @if(file_exists( storage_path().'/petition/'.$row->image ) && !empty($row->image))
                                        <img src="{{asset('storage')}}/petition/{{ $row->image }}" height="800px" width="1200px" class="img-fluid" alt="...">
                                        @else
                                        <img class="img-fluid" src="{{ asset('assets/img/blog/blog-02.jpg') }}" alt="">
                                        @endif
                                        
                                    </a>
                        </div>
                          <h3 class="blog-title">Almost done! Take the next step. Share today.</h3>
                        <div class="blog-content">
                           <p>Great, you’ve signed — the next step is to share far and wide to make sure everyone sees this petition.</p>
                          							
                        </div>
                        
                    </div>
  
                    <div class="card blog-share clearfix">
                        <div class="card-header">
                            <h3 class="card-title">Share Petition</h3>
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