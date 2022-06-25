

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
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<meta name="csrf-token" content="{{ csrf_token() }}">
<!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
<!-- SITE TITLE -->
@yield('title')
<title>@if(!empty($meta_data['meta_title'])) {{$meta_data['meta_title']}} @endif</title>
@if (!empty($logo_favicon['favicon']))
<link rel="shortcut icon" href="{{ asset('storage/logo/'.$logo_favicon['favicon'])}}" type="image/x-icon">
<link rel="icon" href="{{ asset('storage/logo/'.$logo_favicon['favicon'])}}" type="image/x-icon">
@endif
<meta name="description" content=" @if(!empty($meta_data['meta_description'])) {{$meta_data['meta_description']}}  @endif">

<!-- Mobile Specific Meta-->
<meta name="viewport" content="width=device-width, initial-scale=1">
<!-- bootstrap.min css -->
<link rel="stylesheet" href="{{ asset('assets/home14/vendors/bootstrap/bootstrap.css')}}">
<!-- Iconfont Css -->
<link rel="stylesheet" href="{{ asset('assets/home14/vendors/fontawesome/css/all.css')}}">
<link rel="stylesheet" href="{{ asset('assets/home14/vendors/flaticon/flaticon.css')}}">
<!-- animate.css -->
<link rel="stylesheet" href="{{ asset('assets/home14/vendors/animate-css/animate.css')}}">
<link rel="stylesheet" href="{{ asset('assets/home14/vendors/owl/assets/owl.carousel.min.css')}}">
<link rel="stylesheet" href="{{ asset('assets/home14/vendors/owl/assets/owl.theme.default.min.css')}}">

<!-- Main Stylesheet -->
<link rel="stylesheet" href="{{ asset('assets/home14/css/style.css')}}">
<link rel="stylesheet" href="{{ asset('assets/home14/css/responsive.css')}}">
<link href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css" rel="stylesheet"/>
