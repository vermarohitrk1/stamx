
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
<meta name="description" content=" @if(!empty($meta_data['meta_description'])) {{$meta_data['meta_description']}}  @endif">
<!-- Bootstrap CSS -->
<link rel="stylesheet" href="{{ asset('assets/home8/css/bootstrap.min.css')}}">
<!-- Animate CSS -->
<link rel="stylesheet" href="{{ asset('assets/home8/css/animate.min.css')}}">
<!-- Line Awesome CSS -->
<link rel="stylesheet" href="{{ asset('assets/home8/css/line-awesome.min.css')}}">
<!-- Owl Carousel CSS -->
<link rel="stylesheet" href="{{ asset('assets/home8/css/owl.carousel.min.css')}}">
<!-- Owl Theme CSS -->
<link rel="stylesheet" href="{{ asset('assets/home8/css/owl.theme.default.min.css')}}">
<!-- Meanmenu CSS -->
<link rel="stylesheet" href="{{ asset('assets/home8/css/meanmenu.min.css')}}">
<!-- Magnific Popup CSS -->
<link rel="stylesheet" href="{{ asset('assets/home8/css/magnific-popup.min.css')}}">
<!---->
<link rel="stylesheet" href="{{ asset('assets/home8/css/flaticon.css')}}">
<!-- Odometer CSS -->
<link rel="stylesheet" href="{{ asset('assets/home8/css/odometer.min.css')}}">
<!-- Stylesheet CSS -->
<link rel="stylesheet" href="{{ asset('assets/home8/css/style.css')}}">
<!-- Responsive CSS -->
<link rel="stylesheet" href="{{ asset('assets/home8/css/responsive.css')}}">

@yield('title')
<title>@if(!empty($meta_data['meta_title'])) {{$meta_data['meta_title']}} @endif</title>
@if (!empty($logo_favicon['favicon']))
<link rel="shortcut icon" href="{{ asset('storage/logo/'.$logo_favicon['favicon'])}}" type="image/x-icon">
<link rel="icon" href="{{ asset('storage/logo/'.$logo_favicon['favicon'])}}" type="image/x-icon">
@endif
<link href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css" rel="stylesheet"/>

