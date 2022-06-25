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
   

        <title>@yield('title') &mdash;
    @if(!empty($meta_data['meta_title'])) {{$meta_data['meta_title']}}  @endif </title>

		<meta name="description"  content=" @if(!empty($meta_data['meta_description'])) {{$meta_data['meta_description']}}  @endif">
		<meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0">
		<meta name="keywords" content="stemx"/>
		<meta name="author" content="stemx"/>
		<meta name="email" content=""/>
		<meta name="website" content=""/>
		<meta name="Version" content="v2.5.1"/>

		
	@if (!empty($logo_favicon['favicon']))
		<link rel="shortcut icon" href="{{ asset('storage/logo/'.$logo_favicon['favicon'])}}" type="image/x-icon">
		<link rel="icon" href="{{ asset('storage/logo/'.$logo_favicon['favicon'])}}" type="image/x-icon">
		@endif
		
		<!-- Bootstrap CSS -->
		<link rel="stylesheet" href="{{ asset('assets/css/bootstrap.min.css') }}">
		
		<!-- Fontawesome CSS -->
		<link rel="stylesheet" href="{{ asset('assets/plugins/fontawesome/css/fontawesome.min.css') }}">
		<link rel="stylesheet" href="{{ asset('assets/plugins/fontawesome/css/all.min.css') }}">
		<!-- Daterangepikcer CSS -->
		<link rel="stylesheet" href="{{ asset('assets/plugins/daterangepicker/daterangepicker.css') }}">
		<!-- Datetimepicker CSS -->
		<link rel="stylesheet" href="{{ asset('assets/css/bootstrap-datetimepicker.min.css') }}">
        <!-- Select2 CSS -->
        <link rel="stylesheet" href="{{ asset('assets/plugins/select2/css/select2.min.css') }}">
		<!-- Owl Carousel CSS -->
		<link rel="stylesheet" href="{{ asset('assets/css/owl.carousel.min.css') }}">
		<link rel="stylesheet" href="{{ asset('assets/css/owl.theme.default.min.css') }}">

		<!-- Main CSS -->
		<link rel="stylesheet" href="{{ asset('assets/css/style.css') }}">
		<link rel="stylesheet" href="{{ asset('css/custom-style.css') }}">
                @stack('css')
  