
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
<meta name="viewport" content="width=device-width, initial-scale=1">
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
<!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
<!-- SITE TITLE -->
@yield('title')
<title>@if(!empty($meta_data['meta_title'])) {{$meta_data['meta_title']}} @endif</title>
@if (!empty($logo_favicon['favicon']))
<link rel="shortcut icon" href="{{ asset('storage/logo/'.$logo_favicon['favicon'])}}" type="image/x-icon">
<link rel="icon" href="{{ asset('storage/logo/'.$logo_favicon['favicon'])}}" type="image/x-icon">
@endif

<link href="https://fonts.googleapis.com/css?family=Poppins:300,300i,400,400i,500,600,700,700i,800,900" rel="stylesheet">
<link href="https://fonts.googleapis.com/css?family=Montserrat:300,300i,400,400i,500,600,700,800,900" rel="stylesheet">
<link href="{{ asset('assets/home13/fonts/font-awesome.min.css')}}" rel="stylesheet"/>
<link href="{{ asset('assets/home13/fonts/etline.css')}}" rel="stylesheet"/>
<link href="{{ asset('assets/home13/fonts/themify-icons.css')}}" rel="stylesheet"/>
<link href="{{ asset('assets/home13/css/plugins.css')}}" rel="stylesheet"/>
<link href="{{ asset('assets/home13/css/lightbox.min.css')}}" rel="stylesheet"/>
<link href="{{ asset('assets/home13/css/responsive.css')}}" rel="stylesheet"/>
<link href="{{ asset('assets/home13/css/style.css')}}" rel="stylesheet"/>
<link href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css" rel="stylesheet"/>

