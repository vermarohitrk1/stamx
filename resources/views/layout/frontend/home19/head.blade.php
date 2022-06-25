@php
    $meta_data = \App\SiteSettings::WebsiteSetting('meta_data');
    if(!empty($meta_data->value)){
        $meta_data  = json_decode($meta_data->value,true);
    }else{
        $meta_data = array();
    }
    $logo =  \App\SiteSettings::logoSetting();

    if(!empty($logo)){
        $logo_favicon = json_decode($logo->value,true);
    }else{
        $logo_favicon = array();
    }
@endphp

<meta charset="utf-8">
<meta name="csrf-token" content="{{ csrf_token() }}">
<!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
<!-- SITE TITLE -->
@yield('title')
<title>@if(!empty($meta_data['meta_title'])) {{$meta_data['meta_title']}} @endif</title>
@if (!empty($logo_favicon['favicon']))
<link rel="shortcut icon" href="{{ asset('storage/logo/'.$logo_favicon['favicon'])}}" type="image/x-icon">
<link rel="icon" href="{{ asset('storage/logo/'.$logo_favicon['favicon'])}}" type="image/x-icon">
@endif
<meta name="author" content="">
<meta name="keywords" content="">
<meta name="description" content=" @if(!empty($meta_data['meta_description'])) {{$meta_data['meta_description']}}  @endif">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">

<!--Framework-->
<link rel="stylesheet" href="{{ asset('assets/home19/css/framework/bootstrap.min.css')}}">
<!--Fonts-->
<link rel="stylesheet" href="{{ asset('assets/home19/fonts/Inter/style.css')}}">
<!--Plugins-->
<link rel="stylesheet" href="{{ asset('assets/home19/css/vlt-plugins.min.css')}}">
<!--Style-->
<link rel="stylesheet" href="{{ asset('assets/home19/css/vlt-main.min.css')}}">
<!--Custom-->
<link rel="stylesheet" href="{{ asset('assets/home19/css/custom.css')}}">
<link rel="stylesheet" type="text/css" href="//cdn.jsdelivr.net/npm/slick-carousel@1.8.1/slick/slick.css"/>
