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
    
        @yield('title')
        
        <title>
    @if(!empty($meta_data['meta_title'])) {{$meta_data['meta_title']}}  @endif </title>
<meta name="description"
      content=" @if(!empty($meta_data['meta_description'])) {{$meta_data['meta_description']}}  @endif">
 <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0">
<meta name="keywords" content="stemx"/>
<meta name="author" content="stemx"/>
<meta name="email" content=""/>
<meta name="website" content=""/>
<meta name="Version" content="v2.5.1"/>
<meta name="facebook-domain-verification" content="9a07dnq4tl88bbb2tkrnt70r9tnqm3" />

	<meta charset="UTF-8">
  
         <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

	
		<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
		<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.6.3/css/all.css">
		<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/owl-carousel/1.3.3/owl.carousel.min.css">
		<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/owl-carousel/1.3.3/owl.theme.min.css">
		<!-- slickslider -->

		<link rel="stylesheet" type="text/css" href="{{ asset('assets/home2/css/slick-slider/slick-theme.css')}}">
		<link rel="stylesheet" type="text/css" href="{{ asset('assets/home2/css/slick-slider/slick.css')}}">

		<link rel="stylesheet" type="text/css" href="{{ asset('assets/home2/css/mystyle.css')}}">
		<link rel="stylesheet" type="text/css" href="{{ asset('assets/home2/css/responsive.css')}}">

	
		@if (!empty($logo_favicon['favicon']))
    <link rel="shortcut icon" href="{{ asset('storage/logo/'.$logo_favicon['favicon'])}}" type="image/x-icon">
    <link rel="icon" href="{{ asset('storage/logo/'.$logo_favicon['favicon'])}}" type="image/x-icon">
@endif
	  @stack('css')