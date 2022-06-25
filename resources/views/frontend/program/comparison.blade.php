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
                        <li class="breadcrumb-item"><a href="{{route('dashboard')}}">Home</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Comparison</li>
                    </ol>
                </nav>
                <h2 class="breadcrumb-title">Program Comparison</h2>
            </div>
        </div>
    </div>
</div>
<!-- /Breadcrumb -->

<!-- Page Content -->
<div class="content">
    <div class="container-fluid">

        <div class="row">
        <?php $programs = json_decode($data ,true); 
        if(empty($programs)){
        echo "<h5>We're sorry, no selections have been made. Please go back and try again.</h5>";
        }
   ?>
        @foreach($programs as $key => $data)
        
            <div class="col-lg-4 col-md-4">
         <a href="javascript:void(0)" data-id="{{$data['id']}}" class="closer pct-remove-column"><span aria-hidden="true">×</span></a> 
                <div class="blog-view">
                    <div class="blog blog-single-post">
                       <h3 class="blog-title">{{$data['title']}}</h3>
                        <div class="blog-info clearfix">
                            <div class="post-left">
                                <ul>
                                    <li>
                                    <i class="far fa-building"></i> {{ $data['user']['company'] != '' ? $data['user']['company'] : ' - '}}
                                    </li>
                                    <li><i class="far fa-calendar"></i>{{date('M d, Y', strtotime($data['created_at']))}}</li>
                                   
                                </ul>
                            </div>
                        </div>
                        <div class="blog-content">
                        <?php $p_content = json_decode($data['data'],true);
                   
                       if(is_array($p_content)){  ?>
                            <p><?php foreach($p_content as $key => $content){ 
                                if(isset($questions[$key])){
                                ?>
                            
                            <h4 class="widget-title <?php echo $key; ?>"><?php echo $questions[$key]; ?></h4> 
                         <?php
                                if(is_array($content)){

                                    foreach($content as $k => $inrcont){
                                      echo  $inrcont;
                                    }
                                 }
                                else{
                                    if($content ==''){
                                       echo '<span class="blank">-</span>';
                                    }
                                    else{
                                    echo $content;
                                    }
                                }
                            }
                           } ?></p>
                            <?php }
                            else{ ?>
                             {{ $p_content  }}
                          <?php  } ?>
                        </div>
                        
                    </div>

                 </div>
            </div>
            @endforeach

         

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


var getUrlParameter = function getUrlParameter(sParam) {
    var sPageURL = window.location.search.substring(1),
        sURLVariables = sPageURL.split('&'),
        sParameterName,
        i;

    for (i = 0; i < sURLVariables.length; i++) {
        sParameterName = sURLVariables[i].split('=');

        if (sParameterName[0] === sParam) {
            return typeof sParameterName[1] === undefined ? true : decodeURIComponent(sParameterName[1]);
        }
    }
    return false;
};

$( document ).ready(function() {
    $('.pct-remove-column').click(function(){
        var removeid = $(this).data('id');
        
        var id = getUrlParameter('id1');
        var id2 = getUrlParameter('id2');
        var id3 = getUrlParameter('id3');
        //alert(id2);
            if(id == removeid){
            var rparamter = 'id1';

            }
            if(id2 == removeid){

                var rparamter = 'id2';
            }
            if(id3 == removeid){

                var rparamter = 'id3';
            }
        
           var pageURL = $(location).attr("href");
           var url = removeURLParameter(pageURL, rparamter);
            window.location.replace(url);

        
    });
});
function removeURLParameter(url, parameter) {
    //prefer to use l.search if you have a location/link object
    var urlparts= url.split('?');   
    if (urlparts.length>=2) {

        var prefix= encodeURIComponent(parameter)+'=';
        var pars= urlparts[1].split(/[&;]/g);

        //reverse iteration as may be destructive
        for (var i= pars.length; i-- > 0;) {    
            //idiom for string.startsWith
            if (pars[i].lastIndexOf(prefix, 0) !== -1) {  
                pars.splice(i, 1);
            }
        }

        url= urlparts[0]+'?'+pars.join('&');
        return url;
    } else {
        return url;
    }
}
</script>
@endpush