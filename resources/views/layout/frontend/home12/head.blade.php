
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
<meta name="description" content=" @if(!empty($meta_data['meta_description'])) {{$meta_data['meta_description']}}  @endif">
<meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0">
<meta name="keywords" content="myceo"/>
<meta name="author" content="myceo"/>
<meta name="email" content=""/>
<meta name="website" content=""/>
<meta name="Version" content="v2.5.1"/>
<meta name="facebook-domain-verification" content="9a07dnq4tl88bbb2tkrnt70r9tnqm3" />
    <!-- CSRF Token -->
<meta name="csrf-token" content="{{ csrf_token() }}">
 <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
 <!-- Bootstrap CSS -->
 <link rel="stylesheet" href="{{ asset('assets/home12/css/bootstrap.min.css')}}">
 <!-- Animate CSS -->
 <link rel="stylesheet" href="{{ asset('assets/home12/css/animate.min.css')}}">
 <!-- Meanmenu CSS -->
 <link rel="stylesheet" href="{{ asset('assets/home12/css/meanmenu.css')}}">
 <!-- Boxicons CSS -->
 <link rel="stylesheet" href="{{ asset('assets/home12/css/boxicons.min.css')}}">
 <!-- Flaticon CSS -->
 <link rel="stylesheet" href="{{ asset('assets/home12/css/flaticon.css')}}">
 <!-- Odometer CSS -->
 <link rel="stylesheet" href="{{ asset('assets/home12/css/odometer.min.css')}}">
 <!-- Nice Select CSS -->
 <link rel="stylesheet" href="{{ asset('assets/home12/css/nice-select.min.css')}}">
 <!-- Carousel CSS -->
 <link rel="stylesheet" href="{{ asset('assets/home12/css/owl.carousel.min.css')}}">
 <!-- Carousel Default CSS -->
 <link rel="stylesheet" href="{{ asset('assets/home12/css/owl.theme.default.min.css')}}">
 <!-- Magnific Popup CSS -->
 <link rel="stylesheet" href="{{ asset('assets/home12/css/magnific-popup.min.css')}}">
 <!-- Style CSS -->
 <link rel="stylesheet" href="{{ asset('assets/home12/css/style.css')}}">
 <!-- Responsive CSS -->
 <link rel="stylesheet" href="{{ asset('assets/home12/css/responsive.css')}}">

 @yield('title')
 <title>@if(!empty($meta_data['meta_title'])) {{$meta_data['meta_title']}} @endif</title>
 @if (!empty($logo_favicon['favicon']))
 <link rel="shortcut icon" href="{{ asset('storage/logo/'.$logo_favicon['favicon'])}}" type="image/x-icon">
 <link rel="icon" href="{{ asset('storage/logo/'.$logo_favicon['favicon'])}}" type="image/x-icon">
 @endif
 <link href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css" rel="stylesheet"/>
