
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
<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
<meta name="theme-color" content="#feed01"/>
@yield('title')
<title>@if(!empty($meta_data['meta_title'])) {{$meta_data['meta_title']}} @endif</title>
<meta name="author" content="myceo">
<meta name="description" content=" @if(!empty($meta_data['meta_description'])) {{$meta_data['meta_description']}}  @endif">
<meta name="keywords" content="">

<!-- SOCIAL MEDIA META -->
<meta property="og:description" content="myceo">
<meta property="og:image" content="http://www.themezinho.net/wandau/preview.png">
<meta property="og:site_name" content="myceo">
<meta property="og:title" content="myceo">
<meta property="og:type" content="website">
<meta property="og:url" content="{{url('/')}}">

<!-- TWITTER META -->
<meta name="twitter:card" content="summary">
<meta name="twitter:site" content="@myceo">
<meta name="twitter:creator" content="@myceo">
<meta name="twitter:title" content="myceo">
<meta name="twitter:description" content="myceo">
<meta name="twitter:image" content="{{url('/')}}">

@if (!empty($logo_favicon['favicon']))
 <link rel="shortcut icon" href="{{ asset('storage/logo/'.$logo_favicon['favicon'])}}" type="image/x-icon">
 <link rel="icon" href="{{ asset('storage/logo/'.$logo_favicon['favicon'])}}" type="image/x-icon">
 @endif
 <link href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css" rel="stylesheet"/>

<!-- CSS FILES -->
<link rel="stylesheet" href="{{ asset('assets/home7/css/fontawesome.min.css')}}">
<link rel="stylesheet" href="{{ asset('assets/home7/css/odometer.min.css')}}">
<link rel="stylesheet" href="{{ asset('assets/home7/css/fancybox.min.css')}}">
<link rel="stylesheet" href="{{ asset('assets/home7/css/swiper.min.css')}}">
<link rel="stylesheet" href="{{ asset('assets/home7/css/bootstrap.min.css')}}">
<link rel="stylesheet" href="{{ asset('assets/home7/css/style.css')}}">
