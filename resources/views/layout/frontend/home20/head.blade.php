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

<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">


<!-- =========================
   STYLESHEETS
============================== -->

<!-- BOOTSTRAP CSS -->
<link rel="stylesheet" href="{{ asset('assets/home20/css/plugins/bootstrap.min.css')}}">

<!-- FONT ICONS -->
<link rel="stylesheet" href="{{ asset('assets/home20/css/icons/icons.min.css')}}">

<!-- GOOGLE FONTS -->
<link href="http://fonts.googleapis.com/css?family=Raleway:300,400,600,700%7COpen+Sans:300,400,600,700%7CHandlee" rel="stylesheet">

<!-- PLUGINS STYLESHEET -->
<link rel="stylesheet" href="{{ asset('assets/home20/css/plugins/plugins.min.css')}}">

<!-- CUSTOM STYLESHEET -->
<link rel="stylesheet" href="{{ asset('assets/home20/css/style.css')}}">

<!-- RESPONSIVE FIXES -->
<link rel="stylesheet" href="{{ asset('assets/home20/css/responsive.css')}}">

<!-- COLORE STYLESHEET -->
<!-- Change here the Main Color of the Site: Choose your favorite predefined color from assets/css/colors.css -->
<link rel="stylesheet" href="{{ asset('assets/home20/css/colors/red.css')}}" title="red">
<link href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css" rel="stylesheet"/>
