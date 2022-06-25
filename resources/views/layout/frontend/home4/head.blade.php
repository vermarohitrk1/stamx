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
<meta name="keywords" content="myceo"/>
<meta name="author" content="myceo"/>
<meta name="email" content=""/>
<meta name="website" content=""/>
<meta name="Version" content="v2.5.1"/>
<meta name="facebook-domain-verification" content="9a07dnq4tl88bbb2tkrnt70r9tnqm3" />

	<meta charset="UTF-8">
  
         <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

	
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
	<!-- fontawesome fonts -->
	<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.6.3/css/all.css">
	<!-- Gayathri  google fonts -->
	<link href="https://fonts.googleapis.com/css2?family=Gayathri:wght@100;400;700&display=swap" rel="stylesheet">
	<!-- custom style -->


		<link rel="stylesheet" type="text/css" href="{{ asset('assets/home4/css/mystyle.css')}}">
		<link rel="stylesheet" type="text/css" href="{{ asset('assets/home4/css/responsive.css')}}">

	
		@if (!empty($logo_favicon['favicon']))
    <link rel="shortcut icon" href="{{ asset('storage/logo/'.$logo_favicon['favicon'])}}" type="image/x-icon">
    <link rel="icon" href="{{ asset('storage/logo/'.$logo_favicon['favicon'])}}" type="image/x-icon">
@endif
	  @stack('css')
	   <style>

.d-actual-menu ul.dropdown-menu li a {
    width: 100%;
    display: block;
    line-height: 28px;
    padding: 6px 20px 0px 20px;
}

.d-actual-menu ul li ul li {
    display: block;
    line-height: 0;
}

.d-actual-menu ul.dropdown-menu {
    background: #231b1b;
    box-shadow: 0px 0px 5px rgb(0 0 0 / 20%);
    box-shadow: inset 0px 2px 1px #fff;
    box-shadow: 0 0 0 9999px rgb(0 0 0 / 10%);
}

.d-actual-menu ul li ul li a:hover {
    color: #000;
}


</style>