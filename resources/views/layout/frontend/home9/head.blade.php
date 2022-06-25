
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
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>@if(!empty($meta_data['meta_title'])) {{$meta_data['meta_title']}} @endif</title>
  @if (!empty($logo_favicon['favicon']))
  <link rel="shortcut icon" href="{{ asset('storage/logo/'.$logo_favicon['favicon'])}}" type="image/x-icon">
  <link rel="icon" href="{{ asset('storage/logo/'.$logo_favicon['favicon'])}}" type="image/x-icon">
  @endif



  @yield('title')
  <title>@if(!empty($meta_data['meta_title'])) {{$meta_data['meta_title']}} @endif</title>
  <link rel="stylesheet" href="{{ asset('assets/home9/css/plugins.css')}}">
  <link rel="stylesheet" href="{{ asset('assets/home9/css/style.css')}}">
  <link rel="stylesheet" href="{{ asset('assets/home9/css/colors/purple.css')}}">
  <meta name="description" content=" @if(!empty($meta_data['meta_description'])) {{$meta_data['meta_description']}}  @endif">
  <link href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css" rel="stylesheet"/>
