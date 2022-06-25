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
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">

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


<!-- BOOTSTRAP STYLES -->
<link rel="stylesheet" type="text/css" href="{{ asset('assets/home18/css/bootstrap.min.css')}}">
<!-- TEMPLATE STYLES -->
<link rel="stylesheet" type="text/css" href="{{ asset('assets/home18/style.css')}}">
<!-- RESPONSIVE STYLES -->
<link rel="stylesheet" type="text/css" href="{{ asset('assets/home18/css/responsive.css')}}">
<!-- COLORS STYLES -->
<link rel="stylesheet" type="text/css" href="{{ asset('assets/home18/css/colors.css')}}">
<!-- CUSTOM STYLES -->
<link rel="stylesheet" type="text/css" href="{{ asset('assets/home18/css/custom.css')}}">
<link href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css" rel="stylesheet"/>
<!--[if lt IE 9]>
  <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
  <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
<![endif]-->
