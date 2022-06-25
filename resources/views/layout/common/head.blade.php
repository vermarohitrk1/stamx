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
<meta property="og:url" content="https://stemx.com" />
<meta property="og:type" content="website" />
<meta property="fb:app_id" content="530014071410514" />
<meta name="facebook-domain-verification" content="9a07dnq4tl88bbb2tkrnt70r9tnqm3" />
	<meta charset="UTF-8">

         <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
	<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.6.3/css/all.css">
	<!-- slickslider -->
	<link rel="stylesheet" type="text/css" href="{{ asset('assets/main/css/slick-slider/slick-theme.css')}}">
	<link rel="stylesheet" type="text/css" href="{{ asset('assets/main/css/slick-slider/slick.css')}}">

	<link rel="stylesheet" type="text/css" href="{{ asset('assets/main/css/mystyle.css')}}">
	<link rel="stylesheet" type="text/css" href="{{ asset('assets/main/css/responsive.css')}}">

		<!-- Favicons -->
		@if (!empty($logo_favicon['favicon']))
    <link rel="shortcut icon" href="{{ asset('storage/logo/'.$logo_favicon['favicon'])}}" type="image/x-icon">
    <link rel="icon" href="{{ asset('storage/logo/'.$logo_favicon['favicon'])}}" type="image/x-icon">
    @endif


		<!-- Bootstrap CSS -->
		<!--<link rel="stylesheet" href="{{ asset('assets/css/bootstrap.min.css') }}">-->

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
	<style>

	.mainlogo {
    margin-right: 0;
}
    .col-12.sub-footer.py120 {
    background: var(--darkblack);
    }
    .breadcrumb-bar {
    background-color: #f6f6f6;
    border-bottom: 1px solid #e3e8eb;
    padding: 15px 0;
    margin-top: 7rem;
    }

    .navbar {
    height: 7.5rem;
    background: var(--peacock);
    margin-top: 0;
    }
    .custom_check {
    font-size: 14px;
    }
    h4.card-title.mb-0 {
    font-size: 1.70rem;
}
.page-link{
    font-size: 1.60rem;

}
body {

	font-size: 1.5rem;

}
p {
    font-size: 14px;
}
    .filter-widget h4 {
    font-size: 1.60rem;

}
@media only screen and (max-width: 768px){
i.fa.fa-times {
    display: none;
}
}
@media screen and (max-width: 767px){

   a.navbar-brand {
     padding-left: 1rem!important;
}

  button.navbar-toggler {
    margin-right: 1rem!important;
}


  nav.navbar.navbar-expand-lg.fixed-top {
    padding-left: 0!important;
    padding-right: 0!important;
}

  .navbar {
    height: auto!important;
}
}
	</style>
	  @stack('css')
