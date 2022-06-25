<?php $page = "Site Settings"; ?>
@section('title')
    {{$page??''}}
@endsection
@extends('layout.dashboardlayout')
@section('content')
@php
  $user=Auth::user();
 $permissions=permissions();
@endphp
<style>

.modal-open .main-wrapper {
    -webkit-filter: blur(1px);
    -moz-filter: blur(1px);
    -o-filter: blur(1px);
    -ms-filter: blur(1px);
    filter: inherit;
}
</style>
<!-- Page Content -->
<div class="content">
    <div class="container-fluid">

        <div class="row">

            <!-- Sidebar -->
            <div class="col-md-5 col-lg-4 col-xl-3 theiaStickySidebar">
                @include('layout.partials.userSideMenu')
            </div>
            <!-- /Sidebar -->

            <!-- Booking summary -->
            <div class="col-md-7 col-lg-8 col-xl-9">

                <!-- Mentee List Tab -->
                <div class="tab-pane show active" id="mentee-list">
                    <div class="content container-fluid">

        <!-- Tab Menu -->
        <nav class="user-tabs mb-4 custom-tab-scroll">
            <ul class="nav nav-tabs nav-tabs-bottom nav-justified">
                <li>
                    <a class="nav-link active" href="#mailersettings" data-toggle="tab">Mailer Settings</a>
                </li>
                <li>
                    <a class="nav-link" href="#paymentgateway" data-toggle="tab">Payment gateway</a>
                </li>
                 <li>
                    <a class="nav-link" href="#commonsettings" data-toggle="tab">Common Settings</a>
                </li>
                 <li>
                    <a class="nav-link" href="#apikeys" data-toggle="tab">API Keys</a>
                </li>
				 <li>
                    <a class="nav-link" href="#menu" data-toggle="tab">Menu</a>
                </li>

				  @if (checkPlanModule("subdomain"))
                <li>
                    <a class="nav-link" href="#domainsettings" data-toggle="tab">Domain Settings</a>
                </li>
				 @endif
                <li>
                    <a class="nav-link" href="#basic" data-toggle="tab">Basic settings</a>
                </li>
                @if(in_array("manage_pages",$permissions) || $user->type =="admin")

				   <li>
                    <a class="nav-link" href="{{route('cms.index')}}" >CMS Pages</a>
                </li>
                 @endif
                 @if(in_array("manage_email_templates",$permissions) || $user->type =="admin")
		<li>
                    <a class="nav-link" href="{{route('email_template.index')}}" >Email Templates</a>
                </li>
                <li>
                    <a class="nav-link" href="#awss3" data-toggle="tab">AWS settings</a>
                </li>
                 @endif

            </ul>
        </nav>
        <!-- /Tab Menu -->

        <!-- Tab Content -->
        <div class="tab-content">

             {{-- aws setting --}}
            <div role="tabpanel" id="awss3" class="tab-pane fade">

                <!-- Page Header -->
                <div class="page-header">
                    <div class="row">
                        <div class="col-sm-12">
                            <h3 class="page-title">AWS Settings</h3>
                            <ul class="breadcrumb">
                                <li class="breadcrumb-item"><a href="index_admin">Dashboard</a></li>
                                <li class="breadcrumb-item"><a href="javascript:(0)">Settings</a></li>
                                <li class="breadcrumb-item active">AWS Settings</li>
                            </ul>
                        </div>
                    </div>
                </div>
                <!-- /Page Header -->

                <div class="row">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-header">
                                <h4 class="card-title">AWS Settings</h4>
                                <small>To get AWS S3 API Key <a style="color: #007bff !important;" href="https://console.aws.amazon.com/console/home">Click here</a>.</small>
                            </div>
                            <div class="card-body">
                                {{ Form::open(['route' => ['site.settings.store'],'id' => 'update_setting']) }}
                                 @csrf
                                 @php
                                 $mailer_settings=\App\SiteSettings::getValByName('mailer_settings');
                                    if(!empty($aws_settings)){
                                        $awss3 = json_decode($aws_settings->value,true);
                                    }else{
                                        $awss3 = array();
                                    }

                                 @endphp
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    {{ Form::label('aws_bucket', __('AWS Bucket'),['class' => 'form-control-label']) }}
                                    {{ Form::text('aws_bucket', ($awss3['AWS_BUCKET']??''), ['class' => 'form-control','required'=>'required','placeholder' => __('AWS Bucket')]) }}
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    {{ Form::label('aws_region', __('AWS Default Region'),['class' => 'form-control-label']) }}
                                    {{ Form::text('aws_region', ($awss3['AWS_DEFAULT_REGION'] ??''), ['class' => 'form-control','required'=>'required','placeholder' => __('AWS Default Region')]) }}
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    {{ Form::label('aws_key_id', __('AWS Access Key ID'),['class' => 'form-control-label']) }}
                                    {{ Form::text('aws_key_id', ($awss3['AWS_ACCESS_KEY_ID'] ??'') , ['class' => 'form-control','required'=>'required','placeholder' => __('AWS Access Key ID')]) }}
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    {{ Form::label('aws_secret_key', __('AWS Secret Access Key'),['class' => 'form-control-label']) }}
                                    <!--{{ Form::text('aws_secret_key', ($awss3['AWS_SECRET_ACCESS_KEY'] ??''), ['class' => 'form-control','required'=>'required','placeholder' => __('AWS Secret Access Key')]) }}-->
                                    <input name="aws_secret_key" value="{{$awss3['AWS_SECRET_ACCESS_KEY']??''}}" placeholder="AWS Secret Access Key"  id="password-field5" type="password" class="form-control" >
              <span toggle="#password-field5" class="fa fa-fw fa-eye field-icon toggle-password"></span>
                                </div>
                            </div>

                            <div class="col-6">
                                <div class="text-left">

                                </div>
                            </div>
                            <div class="col-6">
                                <div class="text-right">
                                    {{ Form::hidden('from','awss3') }}
                                    <button type="submit" class="btn btn-sm btn-primary rounded-pill">{{__('Save changes')}}</button>
                                </div>
                            </div>
                        </div>
                        {{ Form::close() }}
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- General -->
            <div role="tabpanel" id="mailersettings" class="tab-pane fade show active">

                <!-- Page Header -->
                <div class="page-header">
                    <div class="row">
                        <div class="col-sm-12">
                            <h3 class="page-title">Mailer Settings</h3>
                            <ul class="breadcrumb">
                                <li class="breadcrumb-item"><a href="index_admin">Dashboard</a></li>
                                <li class="breadcrumb-item"><a href="javascript:(0)">Settings</a></li>
                                <li class="breadcrumb-item active">Mailer Settings</li>
                            </ul>
                        </div>
                    </div>
                </div>
                <!-- /Page Header -->

                <div class="row">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-header">
                                <h4 class="card-title">Mailer Settings</h4>
                                <a href="#" class="btn btn-sm btn btn-primary float-right " data-url="{{ route('mailer.settings.create') }}" data-ajax-popup="true" data-size="lg" data-title="{{__('Add Mailer Setttings')}}">
        <span class="btn-inner--icon"><i class="fas fa-plus"></i></span>
    </a>
                            </div>
                            <div class="card-body">

                                  @php
                                   $usr = Auth::user();
                                   $mailer_setting='';
                                   $setting = \App\SiteSettings::where("name", 'mailer_settings')->where('user_id', $usr->id)->first();
            if (!empty($setting->value) && !empty(json_decode($setting->value))) {
                $mailer_setting = json_decode($setting->value, true);
            } elseif (!empty($setting->value)) {
                $mailer_setting = $setting->value;
            }

                                 @endphp
                               <div class="table-md-responsive">
                  <table class="table table-hover table-center mb-0" id="mailertable">
                     <thead class="thead-light">
                      <tr>
                           <th class="name mb-0 h6 text-sm"> {{__('Default')}}</th>
                           <th class="name mb-0 h6 text-sm"> {{__('MDriver')}}</th>
                           <th class="name mb-0 h6 text-sm"> {{__('MHost')}}</th>
                           <th class="name mb-0 h6 text-sm"> {{__('MUsername')}}</th>
                           <th class="name mb-0 h6 text-sm"> {{__('MFromAddress')}}</th>
                           <th class="name mb-0 h6 text-sm"> {{__('MFromName')}}</th>
                          <th class="text-left name mb-0 h6 text-sm"> {{__('Action')}}</th>
                      </tr>
                      </thead>
                      <tbody>
                          @if(!empty($mailer_setting))
                          @foreach($mailer_setting as $i=>$mailer_settings)
                          <tr>
                      <td>{{ $mailer_settings['MAIL_DEFAULT']??''}}</td>
                      <td>{{ $mailer_settings['MAIL_DRIVER']??''}}</td>
                      <td>{{ $mailer_settings['MAIL_HOST']??''}}</td>
                      <td>{{ $mailer_settings['MAIL_USERNAME']??''}}</td>
                      <td>{{ $mailer_settings['MAIL_FROM_ADDRESS']??''}}</td>
                      <td>{{ $mailer_settings['MAIL_FROM_NAME']??''}}</td>
                      <td><div class="actions text-right">
                                                <a class="btn btn-sm bg-success-light mt-1" data-title="Edit " data-url="{{ route('mailer.settings.create',['id'=>$i]) }}" href="#" data-ajax-popup="true" data-size="lg" data-title="{{__('Edit Mailer Setttings')}}">
                                                    <i class="fas fa-pencil-alt"></i>

                                                </a>
                                                <a data-url="{{route('mailer.settings.destroy',$i)}}" href="#" class=" mt-1 btn btn-sm bg-danger-light delete_record_model">
                                                    <i class="far fa-trash-alt"></i>
                                                </a>
                                            </div></td>
                                            </tr>

                          @endforeach
                          @endif
                      </tbody>

                  </table>
              </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- /General -->
<!-- frontend profiles -->
            <div role="tabpanel" id="commonsettings" class="tab-pane fade">

                <!-- Page Header -->
                <div class="page-header">
                    <div class="row">
                        <div class="col-sm-12">
                            <h3 class="page-title">Common Settings</h3>
                            <ul class="breadcrumb">
                                <li class="breadcrumb-item"><a href="{{route('dashboard')}}">Dashboard</a></li>
                                <li class="breadcrumb-item"><a href="javascript:(0)">Settings</a></li>
                                <li class="breadcrumb-item active">Common Settings</li>
                            </ul>
                        </div>
                    </div>
                </div>
                <!-- /Page Header -->
 {{ Form::open(['route' => ['site.settings.store'],'id' => 'update_setting']) }}
                                 @csrf

                <div class="row">
                     @php
                                 $fronend_settings=\App\SiteSettings::getValByName('frontend_profiles');
                                   $domain_user=get_domain_user();
                                  $users=\App\User::where('created_by',$domain_user->id)->Orwhere('id',Auth::user()->id)->get();

                                 @endphp
                    <div class="col-12">
                        <div class="card">
                            <div class="card-header">
                                <h4 class="card-title">Frontend Profiles<div class="custom-control custom-switch float-right">
                                    <input type="checkbox" class="custom-control-input" name="enable_frontend_profiles" id="enable_frontend_profiles" {{(!empty($fronend_settings['enable_frontend_profiles']) && $fronend_settings['enable_frontend_profiles'] == 'on') ? 'checked' : ''}}>
                                    <label class="custom-control-label form-control-label" for="enable_frontend_profiles">{{__('Enable to show')}}</label>
                                </div></h4>



                            </div>
                            <div class="card-body">

                        <div class="form-group">
        <div class="row">
            <div class="col-md-12">
                <label class="form-control-label">Please select profiles that you want to show on front page</label>
                <select id="frontend_profiles" name="frontend_profiles[]" style="width: 100% !important" class="form-control select2" multiple="" required>

                    @foreach($users as $user)
                    <option @if(!empty($fronend_settings['frontend_profiles']) && in_array($user->id,$fronend_settings['frontend_profiles'])) selected @endif value="{{$user->id}}">{{$user->name." (".$user->type.")"}}</option>
                    @endforeach

                </select>
            </div>

        </div>
    </div>


                        <div class="card">
                            <div class="card-header">
                                <h4 class="card-title">Frontend Partners<div class="custom-control custom-switch float-right">
                                    <input type="checkbox" class="custom-control-input" name="enable_frontend_partners" id="enable_frontend_partners" {{(!empty($fronend_settings['enable_frontend_partners']) && $fronend_settings['enable_frontend_partners'] == 'on') ? 'checked' : ''}}>
                                    <label class="custom-control-label form-control-label" for="enable_frontend_partners">{{__('Enable to show')}}</label>
                                </div></h4>



                            </div>
                        </div>
                        <div class="card">
                            <div class="card-header">
                                <h4 class="card-title">Frontend Course Categories<div class="custom-control custom-switch float-right">
                                    <input type="checkbox" class="custom-control-input" name="enable_frontend_course_categories" id="enable_frontend_course_categories" {{(!empty($fronend_settings['enable_frontend_course_categories']) && $fronend_settings['enable_frontend_course_categories'] == 'on') ? 'checked' : ''}}>
                                    <label class="custom-control-label form-control-label" for="enable_frontend_course_categories">{{__('Enable to show')}}</label>
                                </div></h4>



                            </div>
                        </div>
                        <div class="card">
                            <div class="card-header">
                                <h4 class="card-title">Frontend Blogs<div class="custom-control custom-switch float-right">
                                    <input type="checkbox" class="custom-control-input" name="enable_frontend_blogs" id="enable_frontend_blogs" {{(!empty($fronend_settings['enable_frontend_blogs']) && $fronend_settings['enable_frontend_blogs'] == 'on') ? 'checked' : ''}}>
                                    <label class="custom-control-label form-control-label" for="enable_frontend_blogs">{{__('Enable to show')}}</label>
                                </div></h4>



                            </div>
                        </div>
                        <div class="card">
                            <div class="card-header">
                                <h4 class="card-title">Frontend Newsletter<div class="custom-control custom-switch float-right">
                                    <input type="checkbox" class="custom-control-input" name="enable_frontend_newsletter" id="enable_frontend_newsletter" {{(!empty($fronend_settings['enable_frontend_newsletter']) && $fronend_settings['enable_frontend_newsletter'] == 'on') ? 'checked' : ''}}>
                                    <label class="custom-control-label form-control-label" for="enable_frontend_newsletter">{{__('Enable to show')}}</label>
                                </div></h4>



                            </div>
                        </div>



                        <div class="row">
                            <div class="col-12">
                                <div class="text-right">
                                    {{ Form::hidden('from','frontend_profiles') }}
                                    <button type="submit" class="btn btn-sm btn-primary rounded-pill">{{__('Save changes')}}</button>
                                </div>
                            </div>
                        </div>

                            </div>
                        </div>
                    </div>
                </div>
                                  {{ Form::close() }}
            </div>
            <!-- /common settings-->
            <!-- Payment gateway -->
            <div role="tabpanel" id="paymentgateway" class="tab-pane fade">

                <!-- Page Header -->
                <div class="page-header">
                    <div class="row">
                        <div class="col-sm-12">
                            <h3 class="page-title">Payment gateway</h3>
                            <ul class="breadcrumb">
                                <li class="breadcrumb-item"><a href="index_admin">Dashboard</a></li>
                                <li class="breadcrumb-item"><a href="javascript:(0)">Settings</a></li>
                                <li class="breadcrumb-item active">Payment gateway</li>
                            </ul>
                        </div>
                    </div>
                </div>
                <!-- /Page Header -->

                <div class="row">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-header">
                                <h4 class="card-title">General</h4>
                            </div>
                            <div class="card-body">
                                {{ Form::open(['route' => ['site.settings.store'],'id' => 'update_setting']) }}
                                 @csrf
                                 @php
                                 $stripe_settings=\App\SiteSettings::getValByName('payment_settings');

                                 @endphp
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    {{ Form::label('currency', __('Currency'),['class' => 'form-control-label']) }}
                                    {{ Form::text('currency', $stripe_settings['CURRENCY']??'', ['class' => 'form-control','required'=>'required','placeholder' => __('Currency')]) }}
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    {{ Form::label('currency_code', __('Currency Code'),['class' => 'form-control-label']) }}
                                    {{ Form::text('currency_code', $stripe_settings['CURRENCY_CODE']??'', ['class' => 'form-control','required'=>'required','placeholder' => __('Currency Code')]) }}
                                    <small>{{__('Note : Add currency code as per three-letter ISO code.')}} <a href="https://stripe.com/docs/currencies" target="_blank">{{__('you can find out here..')}}</a></small>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-12">
                                <hr>
                            </div>
                            <div class="col-6 py-2">
                                <h5 class="h5">{{__('Stripe')}}</h5>
                            </div>
                            <div class="col-6 py-2 text-right">
                                <div class="custom-control custom-switch">
                                    <input type="checkbox" class="custom-control-input" name="enable_stripe" id="enable_stripe" {{(!empty($stripe_settings['ENABLE_STRIPE']) && $stripe_settings['ENABLE_STRIPE'] == 'on') ? 'checked' : ''}}>
                                    <label class="custom-control-label form-control-label" for="enable_stripe">{{__('Enable Stripe')}}</label>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    {{ Form::label('stripe_key', __('Stripe Key'),['class' => 'form-control-label']) }}
                                    {{ Form::text('stripe_key', $stripe_settings['STRIPE_KEY']??"", ['class' => 'form-control','placeholder' => __('Stripe Key')]) }}
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    {{ Form::label('stripe_secret', __('Stripe Secret'),['class' => 'form-control-label']) }}
                                    <input name="stripe_secret" value="{{$stripe_settings['STRIPE_SECRET']??''}}" placeholder="Stripe Secret"  id="password-field" type="password" class="form-control" >
              <span toggle="#password-field" class="fa fa-fw fa-eye field-icon toggle-password"></span>
                                </div>
                            </div>
                        </div>

<!--                        <div class="row">
                            <div class="col-12">
                                <hr>
                            </div>
                            <div class="col-6 py-2">
                                <h5 class="h5">{{__('PayPal')}}</h5>
                            </div>
                            <div class="col-6 py-2 text-right">
                                <div class="custom-control custom-switch">
                                    <input type="checkbox" class="custom-control-input" name="enable_paypal" id="enable_paypal" {{(env('ENABLE_PAYPAL') == 'on') ? 'checked' : ''}}>
                                    <label class="custom-control-label form-control-label" for="enable_paypal">{{__('Enable Paypal')}}</label>
                                </div>
                            </div>
                            <div class="col-md-12 pb-4">
                                <label class="paypal-label form-control-label" for="paypal_mode">{{__('Paypal Mode')}}</label> <br>
                                <div class="btn-group btn-group-toggle" data-toggle="buttons">
                                    <label class="btn btn-primary btn-sm {{ env('PAYPAL_MODE') == '' || env('PAYPAL_MODE') == 'sandbox' ? 'active' : '' }}">
                                        <input type="radio" name="paypal_mode" value="sandbox" {{ env('PAYPAL_MODE') == '' || env('PAYPAL_MODE') == 'sandbox' ? 'checked' : '' }}>{{ __('Sandbox') }}
                                    </label>
                                    <label class="btn btn-primary btn-sm {{ env('PAYPAL_MODE') == 'live' ? 'active' : '' }}">
                                        <input type="radio" name="paypal_mode" value="live" {{ env('PAYPAL_MODE') == 'live' ? 'checked' : '' }}>{{ __('Live') }}
                                    </label>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    {{ Form::label('paypal_client_id', __('Client ID'),['class' => 'form-control-label']) }}
                                    {{ Form::text('paypal_client_id', env('PAYPAL_CLIENT_ID'), ['class' => 'form-control','placeholder' => __('Client ID')]) }}
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    {{ Form::label('paypal_secret_key', __('Secret Key'),['class' => 'form-control-label']) }}
                                    {{ Form::text('paypal_secret_key', env('PAYPAL_SECRET_KEY'), ['class' => 'form-control','placeholder' => __('Secret Key')]) }}
                                </div>
                            </div>
                        </div>-->
                        <div class="row">
                            <div class="col-12">
                                <div class="text-right">
                                    {{ Form::hidden('from','payment') }}
                                    <button type="submit" class="btn btn-sm btn-primary rounded-pill">{{__('Save changes')}}</button>
                                </div>
                            </div>
                        </div>
                        {{ Form::close() }}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
          <!-- /Payment gateway -->
<!-- Basic settings -->
<div role="tabpanel" id="basic" class="tab-pane fade">
   <!-- Page Header -->
   <div class="page-header">
      <div class="row">
         <div class="col-sm-12">
            <h3 class="page-title">Basic</h3>
            <ul class="breadcrumb">
               <li class="breadcrumb-item"><a href="dashboard">Dashboard</a></li>
               <li class="breadcrumb-item"><a href="javascript:(0)">Settings</a></li>
               <li class="breadcrumb-item active">Basic settings</li>
            </ul>
         </div>
      </div>
   </div>
   <!-- /Page Header -->
   <div class="row">
      <div class="col-12">
         <div class="card">
            <div class="card-header">
               <h4 class="card-title">Basic Settings</h4>
            </div>

     @php
if($basic_settings == null){
    $logodata = array();
}
else{
    $logodata = json_decode($basic_settings->value,true);

}



  @endphp
            <div class="card-body">
               {{ Form::open(['route' => ['site.settings.store'],'id' => 'update_setting','enctype' => 'multipart/form-data']) }}
               <div class="row">
                  <div class="col-6">
                     <div class="form-group">
                        {{ Form::label('full_logo', __('Logo'),['class' => 'form-control-label']) }}
                        @if( array_key_exists('logo',$logodata))

                        <input type="file" name="full_logo"id="full_logo" class="custom-input-file croppie" default="{{asset('storage')}}/logo/{{ $logodata['logo']}}" crop-width="326" crop-height="78"  accept="image/*">
                        @else
                        <input type="file" name="full_logo" id="full_logo" class="custom-input-file croppie" crop-width="116" crop-height="26"  accept="image/*" >
                        @endif
                        @error('full_logo')
                        <span class="full_logo" role="alert">
                        <small class="text-danger">{{ $message }}</small>
                        </span>
                        @enderror
                     </div>
                  </div>
                  <div class="col-md-6">
                     <div class="form-group">
                        {{ Form::label('favicon', __('Favicon'),['class' => 'form-control-label']) }}
                        @if( array_key_exists('favicon',$logodata))

                        <input type="file" name="favicon"id="favicon" class="custom-input-file croppie" default="{{asset('storage')}}/logo/{{ $logodata['favicon']}}" crop-width="60" crop-height="60"  accept="image/*">
                        @else
                        <input type="file" name="favicon" id="favicon" class="custom-input-file croppie" crop-width="60" crop-height="60"  accept="image/*" >
                        @endif
                        @error('favicon')
                        <span class="favicon" role="alert">
                        <small class="text-danger">{{ $message }}</small>
                        </span>
                        @enderror
                     </div>
                  </div>
                  <div class="col-md-12">
                                <div class="form-group custom-control custom-switch">
                                    <input type="checkbox" class="custom-control-input" name="twoFa" id="twoFa" @if($twoFa == 1) checked @endif>
                                    <label class="custom-control-label form-control-label float-left" for="twoFa">Enable Two Factor Auth</label>
                                </div>

                </div>
               </div>

               <!-- background Image home -->
               <div class="row">
                  <div class="col-md-12">
                     <div class="form-group">
                        {{ Form::label('homebackground', __('Home Background'),['class' => 'form-control-label']) }}
                        @if( array_key_exists('homebackground',$logodata))
                        <input type="file" name="homebackground"id="homebackground" class="custom-input-file croppie" default="{{asset('storage')}}/logo/{{ $logodata['homebackground']}}"  crop-width="685" crop-height="830"    accept="image/*">
                        @else
                        <input type="file" name="homebackground" id="homebackground" class="custom-input-file croppie"  crop-width="685" crop-height="830"   accept="image/*" >
                        @endif
                        @error('homebackground')
                        <span class="homebackground" role="alert">
                        <small class="text-danger">{{ $message }}</small>
                        </span>
                        @enderror
                     </div>
                  </div>
               </div>
               <!-- background Image home -->
               <!-- background Image -->
               <div class="row">
                  <div class="col-md-12">
                     <div class="form-group">
                        {{ Form::label('registerbackground', __('Register Background'),['class' => 'form-control-label']) }}

                        @if( array_key_exists('registerationbackground',$logodata))
                        <input type="file" name="registerbackground"id="registerbackground" class="custom-input-file croppie" default="{{asset('storage')}}/logo/{{ $logodata['registerationbackground']}}"  crop-width="685" crop-height="830"    accept="image/*">
                        @else
                        <input type="file" name="registerbackground" id="registerbackground" class="custom-input-file croppie" crop-width="685" crop-height="830"   accept="image/*" >
                        @endif
                        @error('registerbackground')
                        <span class="registerbackground" role="alert">
                        <small class="text-danger">{{ $message }}</small>
                        </span>
                        @enderror
                     </div>
                  </div>
               </div>
            </div>
            <div class="text-right">
               {{ Form::hidden('from','site_setting') }}
               <button type="submit" class="btn btn-sm btn-primary">{{__('Save changes')}}</button>
            </div>
            {{ Form::close() }}
         </div>
      </div>
   </div>
</div>

<!-- / Basic settings -->


 <!-- Menu -->
            <div role="tabpanel" id="menu" class="tab-pane fade">

                <!-- Page Header -->
                <div class="page-header">
                    <div class="row">
                        <div class="col-sm-12">
                            <h3 class="page-title">Menu settings</h3>
                            <ul class="breadcrumb">
                                <li class="breadcrumb-item"><a href="dashboard">Dashboard</a></li>
                                <li class="breadcrumb-item"><a href="javascript:(0)">Settings</a></li>
                                <li class="breadcrumb-item active">Menu</li>
                            </ul>
                        </div>
                    </div>
                </div>
                <!-- /Page Header -->



							   <div class="mid_tab">
							   <div class="tab-content">
					<nav class="user-tabs mb-4 custom-tab-scroll">
						<ul class="nav nav-tabs nav-tabs-bottom nav-justified">
							<li>
								<a class="nav-link active" href="#main_1" data-toggle="tab">Main menu</a>
							</li>
							<li>
								<a class="nav-link" href="#main_2" data-toggle="tab">Footer widgets 1</a>
							</li>

							 <li>
								<a class="nav-link" href="#main_3" data-toggle="tab">Footer widgets 2</a>
							</li>

						</ul>
					</nav>


					<div role="tabpanel" id="main_1" class="tab-pane fade show active">




					                <div class="row">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-header">
                                <h4 class="card-title">Main Menu</h4>
                            </div>
                            <div class="card-body">
                                 <div class="row">
								<div class="col-md-6">
									 <h5 class="mb-4 text-center bg-success text-white ">Add New Menu</h5>
									 <form action="{{url('admin/add-site-settings')}}" method="post">
										@csrf
										<input type="hidden" name="id" id="menuid" class="form-control" >
										<div class="row">
										   <div class="col-md-12">
											  <div class="form-group">
												 <label>Title</label>
												 <input type="text" name="title" id="title"  class="form-control" required>
											  </div>
										   </div>
										</div>
										<div class="row">
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <label>CMS PAGE</label>
                                                <select class="form-control" id="urlGiver">
                                                    <option value="">Select CMS PAGE</option>
                                                        @foreach($pages as $page)
                                                    <option value="/page/{{ $page->slug }}">{{ $page->page_name }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                        </div>
										<div class="row" id="urlHidden">
										   <div class="col-md-12">
											  <div class="form-group">
												 <label>URL</label>
												 <input type="text" name="url" id="url" class="form-control" required>
											  </div>
										   </div>
										</div>
										<div class="row">
										   <div class="col-md-12">
											  <div class="form-group">
												 <label>Parent</label>
												 <select class="form-control" name="parent_id" id="parent_id">
													<option selected disabled>Select Parent Menu</option>
													@if(!empty($allMenus))
													@foreach($allMenus as $key => $value)
													   <option value="{{ $value->id }}">{{ $value->title}}</option>
													@endforeach
													@endif
												 </select>
											  </div>
										   </div>
										</div>
										<div class="row">
										   <div class="col-md-12">
											  <div class="form-group">
												 <label>Order</label>
												 <input type="number" name="orders" id="orders" class="form-control" required>
											  </div>
										   </div>
										</div>
										<div class="row">
										   <div class="col-md-12">
											  <button class="btn btn-success">Save</button>
										   </div>
										</div>
									 </form>
								  </div>

								   <div class="col-md-6">
									 <h5 class="text-center mb-4 bg-info text-white">Menu List</h5>
									  <ul id="tree1">

								 @foreach($menus as $menu)
											<li>
												<span class="spantag"><i class="fas fa-minus"></i> {{ $menu->title }}  </span>
												<a onclick="edituserFunction({{$menu->id}})"><span><i class="fas fa-edit"></i><span></a>
												<a onclick="deleteuserFunction({{$menu->id}})"><span><i class="fas fa-trash"></i></span></a>
												@if(count($menu->childs))
													@include('admin.menus.mainMenu',['childs' => $menu->childs])
												@endif
											</li>
										 @endforeach
										</ul>
								  </div>

                        </div>
                            </div>
                        </div>
                    </div>
                </div>







					</div>

			<div role="tabpanel" id="main_2" class="tab-pane fade">

					    <div class="row">
                            <div class="col-12">
                                <div class="card">
                                    <div class="card-header">
                                        <h4 class="card-title">Workforce</h4>
                                    </div>
                                    <div class="card-body">

                                        @include('admin.menus.companyMenu',[$footerWidget1])
                                    </div>
                                </div>
                            </div>
					    </div>
			</div>


			<div role="tabpanel" id="main_3" class="tab-pane fade">
					<div class="row">
                        <div class="col-12">
                            <div class="card">
                                <div class="card-header">
                                    <h4 class="card-title">Engage</h4>
                                </div>
                                <div class="card-body">

                                @include('admin.menus.usefulLinks',[$footerWidget2])
                                </div>
                            </div>
                        </div>
					</div>
			</div>
	</div>
	</div>

    </div>
            <!-- domain settings -->
            <div role="domainsettings" id="domainsettings" class="tab-pane fade">

                <!-- Page Header -->
                <div class="page-header">
                    <div class="row">
                        <div class="col-sm-12">
                            <h3 class="page-title">Domain Settings</h3>
                            <ul class="breadcrumb">
                                <li class="breadcrumb-item"><a href="{{route('dashboard')}}">Dashboard</a></li>
                                <li class="breadcrumb-item"><a href="javascript:(0)">Settings</a></li>
                                <li class="breadcrumb-item active">Domain Settings</li>
                            </ul>
                        </div>
                    </div>
                </div>
                <!-- /Page Header -->

                <div class="row">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-header">
                                <h4 class="card-title">Sub Domain</h4>
                            </div>
                            <div class="card-body">
                                {{ Form::open(['route' => ['site.settings.store'],'id' => 'update_setting']) }}
                                 @csrf
                                 @php
                                 $domain_settings=\App\UserDomain::where("user_id", "=", Auth::user()->id)->first();

                                 @endphp
                        <div class="row">

                            <div class="col-md-12">
                                <div class="form-group">
                                    {{ Form::label('website', __('Website Subdomain'),['class' => 'form-control-label']) }}
                                    {{ Form::text('custom_url', $domain_settings->custom_url??'', ['class' => 'form-control send-to-server-changes','id'=>'subdomain','required'=>'required','placeholder' => __('Website Subdomain')]) }}
                              <p class="text-muted">https://<span class="subdomain"></span>{{env('MAIN_URL')}}</p>
                                </div>
                            </div>
                             <div class="col-md-12">
                                <div class="form-group">
                                    {{ Form::label('domain', __('Website Domain'),['class' => 'form-control-label']) }}

                                    <input type="text" name="domain" id="domain" class="form-control" value="{{($domain_settings->domain ?? '')}}" @if(!empty($domain_settings->domain ))  readonly @endif placeholder="Website Domain">

                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-12">
                                <div class="text-right">
                                    {{ Form::hidden('from','domain') }}
                                    <button  id="subdomain-button"  type="submit" class="btn btn-sm btn-primary rounded-pill hide">{{__('Save Changes')}}</button>
                                    @if(!empty($domain_settings->domain))
                                      <a class="btn btn-sm btn-success rounded-pill" href="{{route('lookup_domain')}}?domain={{$domain_settings->domain}}">DNS LOOKUP</a>
                                       <a class="btn btn-sm btn-warning rounded-pill" onclick="return confirm('Are you sure you want to delete this item')" href="{{url('/delete-domain?id='.$domain_settings->id)}}">Delete</a>
                                   @endif
                                </div>
                            </div>
                        </div>
                        {{ Form::close() }}
                        <br>
                        <div class="row">
                            <div class="col-12">
                                <table class="table">
                                  <thead>
                                    <tr>
                                      <th scope="col">Type</th>
                                      <th scope="col">Name</th>
                                      <th scope="col">Content</th>
                                      <th scope="col">TTL</th>
                                    </tr>
                                  </thead>
                                  <tbody>
                                    <tr>
                                      <th scope="row">A</th>
                                      <td>@</td>
                                      <td>{{env('WHM_SERVER_IP')}}</td>
                                      <td>auto</td>
                                    </tr>

                                </tbody>
                            </table>
                            </div>
                        </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- /domain settings -->

            <!--blaze settings -->
            <div role="tabpanel" id="apikeys" class="tab-pane fade">

                <!-- Page Header -->
                <div class="page-header">
                    <div class="row">
                        <div class="col-sm-12">
                            <h3 class="page-title">API Keys</h3>
                            <ul class="breadcrumb">
                                <li class="breadcrumb-item"><a href="{{route('dashboard')}}">Dashboard</a></li>
                                <li class="breadcrumb-item"><a href="javascript:(0)">Settings</a></li>
                                <li class="breadcrumb-item active">API Keys</li>
                            </ul>
                        </div>
                    </div>
                </div>
                <!-- /Page Header -->
 {{ Form::open(['route' => ['site.settings.store'],'id' => 'update_setting']) }}
                                 @csrf

                <div class="row">
                     @php
                                 $blaze_settings=\App\SiteSettings::getValByName('api_blaze_settings');
                               $blaze_credits=check_blaze_account_details();
                                 @endphp
                    <div class="col-12">
                        <div class="card">
                            <div class="card-header">
                                <h4 class="card-title">Blaze Email Verification<div class="custom-control custom-switch float-right">
                                    <input type="checkbox" class="custom-control-input" name="enable_blaze_key" id="enable_blaze_key" {{(!empty($blaze_settings['enable_blaze_key']) && $blaze_settings['enable_blaze_key'] == 'on') ? 'checked' : ''}}>
                                    <label class="custom-control-label form-control-label" for="enable_blaze_key">{{__('Enable')}}</label>
                                </div></h4>



                            </div>
                            <div class="card-body">

                        <div class="form-group">
        <div class="row">
            <div class="col-md-12">

                                <div class="form-group">
                                    {{ Form::label('blaze_key', __('Blaze Key'),['class' => 'form-control-label']) }}
                                     <input name="blaze_key" value="{{$blaze_settings['blaze_key']??''}}" placeholder="Blaze Key"  id="password-field1" type="password" class="form-control" >
              <span toggle="#password-field1" class="fa fa-fw fa-eye field-icon toggle-password"></span>
                                    @if(!empty($blaze_credits->owner_email))
                                    <small class="text-info">Emailable account <b>{{$blaze_credits->owner_email}}</b> has <b>{{$blaze_credits->available_credits}}</b> available credits left in account.</small><br>
                                    @endif
                                    <small>To manage Blaze/Emailable Account<a class="text-primary" target="_blank" href="https://app.emailable.com/"> Click here</a>. </small>
                                </div>

            </div>

        </div>
    </div>


                        <div class="row">
                            <div class="col-12">
                                <div class="text-right">
                                    {{ Form::hidden('from','blaze') }}
                                    <button type="submit" class="btn btn-sm btn-primary rounded-pill">{{__('Save changes')}}</button>
                                </div>
                            </div>
                        </div>

                            </div>
                        </div>
                    </div>
                </div>
                                  {{ Form::close() }}

                                 {{ Form::open(['route' => ['site.settings.store'],'id' => 'update_setting']) }}
                                 @csrf
                <div class="row">
                     @php
                                 $googlemap_settings=\App\SiteSettings::getValByName('api_google_map_settings');

                                 @endphp
                    <div class="col-12">
                        <div class="card">
                            <div class="card-header">
                                <h4 class="card-title">Google Map API<div class="custom-control custom-switch float-right">
                                    <input type="checkbox" class="custom-control-input" name="enable_google_map_key" id="enable_google_map_key" {{(!empty($googlemap_settings['enable_google_map_key']) && $googlemap_settings['enable_google_map_key'] == 'on') ? 'checked' : ''}}>
                                    <label class="custom-control-label form-control-label" for="enable_google_map_key">{{__('Enable')}}</label>
                                </div></h4>



                            </div>
                            <div class="card-body">

                        <div class="form-group">
        <div class="row">
            <div class="col-md-12">

                                <div class="form-group">
                                    {{ Form::label('google_map_key', __('Google Map API Key'),['class' => 'form-control-label']) }}
                                   <input name="google_map_key" value="{{$googlemap_settings['google_map_key']??''}}" placeholder="Google Map API Key"  id="password-field2" type="password" class="form-control" >
              <span toggle="#password-field2" class="fa fa-fw fa-eye field-icon toggle-password"></span>
                                    <small>To get Google Map API Key <a class="text-primary" target="_blank" href="https://developers.google.com/maps/gmp-get-started">Click here</a>. </small>
                                </div>

            </div>

        </div>
    </div>

                        <div class="row">
                            <div class="col-12">
                                <div class="text-right">
                                    {{ Form::hidden('from','googlemap') }}
                                    <button type="submit" class="btn btn-sm btn-primary rounded-pill">{{__('Save changes')}}</button>
                                </div>
                            </div>
                        </div>

                            </div>
                        </div>
                    </div>
                </div>
                                  {{ Form::close() }}


                                  <!-- /Page Header -->
		{{ Form::open(['route' => ['site.settings.store'],'id' => 'update_setting']) }}
		 @csrf

		<div class="row">
		@php
		 $twilio_settings=\App\SiteSettings::getValByName('twilio_key');

		 @endphp
		<div class="col-12">
		<div class="card">
  <div class="card-header">
                                <h4 class="card-title">Twilio Keys</h4>



                            </div>
		<div class="card-body">

		<div class="form-group">
		<div class="row">
		<div class="col-md-12">
		<div class="form-group">
			{{ Form::label('twilio_account_sid', __('Twilio Account Sid'),['class' => 'form-control-label']) }}
			{{ Form::text('twilio_account_sid', $twilio_settings['twilio_account_sid']??"", ['class' => 'form-control','placeholder' => __('Twilio Account Sid')]) }}
                          @if(!empty($twilio_balance))
                                    <small class="text-info" >Twilio account balance <b>{{$twilio_balance}}</b>.</small><br>
                                    @endif
			</div>
		</div>
		<div class="col-md-12">
		<div class="form-group">
			{{ Form::label('twilio_auth_token', __('Twilio Auth Token'),['class' => 'form-control-label']) }}
			<input name="twilio_auth_token" value="{{$twilio_settings['twilio_auth_token']??''}}" required  id="password-field8" type="password" class="form-control" >
              <span toggle="#password-field8" class="fa fa-fw fa-eye field-icon toggle-password"></span>
			</div>
		</div>
			<div class="col-md-12">
		<div class="form-group">
			{{ Form::label('twilio_number', __('Twilio Number'),['class' => 'form-control-label']) }}
			{{ Form::text('twilio_number', $twilio_settings['twilio_number']??"", ['class' => 'form-control','placeholder' => __('Twilio Number')]) }}


		</div>

		</div>
                    <div class="col-md-12">
		<div class="form-group">
			{{ Form::label('twilio_from', __('Twilio From'),['class' => 'form-control-label']) }}
			{{ Form::text('twilio_from', $twilio_settings['twilio_from']??"", ['class' => 'form-control','placeholder' => __('Twilio From')]) }}
                        <small>To know more about from settings <a target="blank" href="https://support.twilio.com/hc/en-us/articles/223133967-Change-the-From-number-or-Sender-ID-for-Sending-SMS-Messages ">visit here</a></small>


		</div>

		</div>

		</div>
		</div>

		<div class="row">
		<div class="col-12">
		<div class="text-right">
			{{ Form::hidden('from','twilioKey') }}
			<button type="submit" class="btn btn-sm btn-primary rounded-pill">{{__('Save changes')}}</button>
		</div>
		</div>
		</div>

		</div>
		</div>
		</div>
		</div>
		  {{ Form::close() }}
            </div>
            <!-- /common settings-->

        </div>
        <!-- /Tab Content -->

    </div>
                </div>
                <!-- /Mentee List Tab -->
            </div>
            <!-- /Booking summary -->

        </div>

    </div>
</div>

<div id="destroymenu" class="modal fade" role="dialog">
  <div class="modal-dialog">
    <!-- Modal content-->
    <div class="modal-content">
       <div class="modal-header">
                <h5 class="modal-title">Are You Sure?</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
        </div>
    <div class="modal-body">
        This action can not be undone. Do you want to continue?
    </div>
      <div class="modal-footer">
          {{ Form::open(['url' => 'admin/menu/destroy','id' => 'destroy_menu','enctype' => 'multipart/form-data']) }}
          <input type="hidden" name="menu_id" id="menu_id"  value="">

        <button type="submit" class="btn btn-sm btn-danger rounded-pill" id="">Yes</button>
        {{ Form::close() }}
        <button type="button" class="btn btn-sm btn-secondary rounded-pill" id="" data-dismiss="modal" aria-label="Close">Cancel</button>
      </div>
    </div>
  </div>
</div>

<!-- /Page Content -->
@endsection

@push('script')
   <link rel="stylesheet" type="text/css" href="{{ asset('assets/css/simcify.min.css') }}">
<script src="{{ asset('assets/js/simcify.min.js') }}"></script>
<script type="text/javascript">
$(document).ready(function() {
    var selectedUrl = $("#urlGiver").val();
    if (selectedUrl == ''){
        $("#url").removeAttr( "disabled" );
        $("#url").val('');
    } else{
        // $("#url").attr('disabled', 'disabled');
    }
    });
    $("#urlGiver").change(function() {
        var urlGiver =  $(this).val();

        if(urlGiver == ''){
            $("#url").removeAttr( "disabled" );
            $("#urlHidden").show();
            $("#url").val('');
        }else{
            // $("#url").attr('disabled', 'disabled');
            $("#url").val(urlGiver);
             $("#urlHidden").hide();
        }


    });
    $(document).ready(function() {
           var startTimer;
           $('#subdomain').on('keyup', function () {
               clearTimeout(startTimer);
               let subdomain = $(this).val();
               startTimer = setTimeout(checksubdomain, 500, subdomain);
           });

           $('#subdomain').on('keydown', function () {
               clearTimeout(startTimer);
           });
           function checksubdomain(subdomain) {
               if (subdomain.length > 1) {
                   $.ajax({
                       type: 'post',
                       url: "{{ route('update.check_subdomain') }}",
                       data: {
                           subdomain: subdomain,
                           _token: "{{ csrf_token() }}"
                       },
                       success: function(data) {
                           if (data == 'true') {
                               show_toastr('Error!', "Subdomain already exist.", 'error');
                           }

                       }
                   });
               }
           }
            $('#domain').on('keyup', function () {
               clearTimeout(startTimer);
               let domain = $(this).val();
               startTimer = setTimeout(checkdomain, 500, domain);
           });

           $('#domain').on('keydown', function () {
               clearTimeout(startTimer);
           });
           function checkdomain(subdomain) {
               if (domain.length > 1) {
                   $.ajax({
                       type: 'post',
                       url: "{{ route('update.check_domain') }}",
                       data: {
                           domain: domain,
                           _token: "{{ csrf_token() }}"
                       },
                       success: function(data) {
                           if (data == 'true') {
                               show_toastr('Error!', "Domain already exist.", 'error');
                           }

                       }
                   });
               }
           }
      });



	function edituserFunction(id){
		$.ajax({
			type: "GET",
			url: "{{url('/admin/get-menu-id/')}}/"+id,
			success:function(result){
				//console.log(result);
				$('#title').val(result.title);
				$('#url').val(result.url);
                $('#urlGiver').val(result.url);
                if($('#urlGiver').val()){
                    $("#urlHidden").hide();
                }else{
                    $("#urlHidden").show();
                }
				$('#menuid').val(result.id);
				$('#orders').val(result.orders);
				if(result.parent_id != 0){
					$('#parent_id option[value="'+result.parent_id+'"]').prop('selected', true);
				}
			}
		});
	}
	function deleteuserFunction(id){
		$("#menu_id").val(id);
		$('#destroymenu').modal('show');
	}
        $(".toggle-password").click(function() {

  $(this).toggleClass("fa-eye fa-eye-slash");
  var input = $($(this).attr("toggle"));
  if (input.attr("type") == "password") {
    input.attr("type", "text");
  } else {
    input.attr("type", "password");
  }
});
</script>

 <style>
                              .field-icon {
  float: right;
  margin-left: -25px;
  margin-top: -21px;
  position: relative;
  z-index: 2;
}
      </style>
@endpush
