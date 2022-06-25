
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
<meta name="description" content=" @if(!empty($meta_data['meta_description'])) {{$meta_data['meta_description']}}  @endif">
<meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0">
<meta name="keywords" content="myceo"/>
<meta name="author" content="myceo"/>
<meta name="email" content=""/>
<meta name="website" content=""/>
<meta name="Version" content="v2.5.1"/>
<meta name="facebook-domain-verification" content="9a07dnq4tl88bbb2tkrnt70r9tnqm3" />

<meta charset="UTF-8">
<!-- CSRF Token -->
<meta name="csrf-token" content="{{ csrf_token() }}">
<link rel="stylesheet" href="{{ asset('assets/home6/css/bootstrap.min.css')}}">
<!-- Animate CSS -->
<link rel="stylesheet" href="{{ asset('assets/home6/css/animate.min.css')}}">
<!-- Meanmenu CSS -->
<link rel="stylesheet" href="{{ asset('assets/home6/css/meanmenu.css')}}">
<!-- Boxicons CSS -->
<link rel="stylesheet" href="{{ asset('assets/home6/css/boxicons.min.css')}}">
<!-- Flaticon CSS -->
<link rel="stylesheet" href="{{ asset('assets/home6/css/flaticon.css')}}">
<!-- Odometer CSS -->
<link rel="stylesheet" href="{{ asset('assets/home6/css/odometer.min.css')}}">
<!-- Slick CSS -->
<link rel="stylesheet" href="{{ asset('assets/home6/css/slick.min.css')}}">
<!-- Carousel CSS -->
<link rel="stylesheet" href="{{ asset('assets/home6/css/owl.carousel.min.css')}}">
<!-- Carousel Default CSS -->
<link rel="stylesheet" href="{{ asset('assets/home6/css/owl.theme.default.min.css')}}">
<!-- Magnific Popup CSS -->
<link rel="stylesheet" href="{{ asset('assets/home6/css/magnific-popup.min.css')}}">
<!-- Style CSS -->
<link rel="stylesheet" href="{{ asset('assets/home6/css/style.css')}}">
<!-- Responsive CSS -->
<link rel="stylesheet" href="{{ asset('assets/home6/css/responsive.css')}}">
@yield('title')
<title>@if(!empty($meta_data['meta_title'])) {{$meta_data['meta_title']}} @endif</title>

@if (!empty($logo_favicon['favicon']))
<link rel="shortcut icon" href="{{ asset('storage/logo/'.$logo_favicon['favicon'])}}" type="image/x-icon">
<link rel="icon" href="{{ asset('storage/logo/'.$logo_favicon['favicon'])}}" type="image/x-icon">
@endif
