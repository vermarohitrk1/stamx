@extends('layout.mainlayout_admin')
@section('content')
<style>
.bootstrap-tagsinput {

    display: block!important;

}
p.text-center.stripe-text {
            font-size: 19px;
            margin-bottom: 0px;
        }

        .pop-up {
            font-size: 100px;
            text-align: center;
        }

.bootstrap-tagsinput {

    max-width: 100%;
    color: #c0ccda;
    vertical-align: middle;
    background-color: transparent;
    border: 0 solid transparent;
    border-radius: 0.25rem;
    cursor: default;
}
.bootstrap-tagsinput .badge {
    display: inline-block;
    position: relative;
    padding: 0.625rem 0.625rem 0.5rem;
    margin: 0.125rem;
    border-radius: 0.25rem;
    background: #282733;
    color: #fff;
    line-height: 1.5;
    overflow: hidden;
    box-shadow: 0 1px 2px rgb(31 45 61 / 25%);
    transition: all 0.2s ease;
}
.bootstrap-tagsinput input {
    display: block;
    border: 0;
    color: #8492a6;
    box-shadow: none;
    outline: 0;
    background-color: transparent;
    padding: 0;
    margin: 0;
    width: auto;
    max-width: inherit;
}
</style>
@php
  $user=Auth::user();
 $permissions=permissions();
@endphp
<!-- Page Wrapper -->
<div class="page-wrapper">
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
               <li>
                    <a class="nav-link" href="#meta" data-toggle="tab">Meta</a>
                </li>

				    <li>
                    <a class="nav-link" href="#basic" data-toggle="tab">Basic settings</a>
                </li>
                <li>
                    <a class="nav-link" href="#aws" data-toggle="tab">AWS settings</a>
                </li>
				 <li>
                    <a class="nav-link" href="#bot" data-toggle="tab">Bot settings</a>
                </li>
				 <li>
                    <a class="nav-link" href="#pathwaybot" data-toggle="tab">Pathway bot settings</a>
                </li>
				 <li>
                    <a class="nav-link" href="#pathwaysettings" data-toggle="tab">Pathway settings</a>
                </li>
				 <li>
                    <a class="nav-link" href="#speech" data-toggle="tab">Speech Setting</a>
                </li>
				<li>
                    <a class="nav-link" href="#wikipedia" data-toggle="tab">Wikipedia Setting</a>
                </li>
                <li>
                    <a class="nav-link" href="#twiliokeys" data-toggle="tab">Twilio Keys</a>
                </li>
               <li>
                    <a class="nav-link" href="#cloudkeys" data-toggle="tab">Cloudinary/Mtownsend Setting</a>
                </li>
                <li>
                    <a class="nav-link" href="#WHMsetting" data-toggle="tab">WHM Settings</a>
                </li>
                 <li>
                    <a class="nav-link" href="#WHMCSsetting" data-toggle="tab">WHMCS Settings</a>
                </li>

				<li>
                    <a class="nav-link" href="#VerifyCert" data-toggle="tab">Verify Cert</a>
                </li>
				   <li>
                    <a class="nav-link" href="#CommissionSetting" data-toggle="tab">Commission Setting</a>
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
                 @endif
            </ul>
        </nav>
        <!-- /Tab Menu -->

        <!-- Tab Content -->
<div class="tab-content">

            <!-- General -->
            <div role="tabpanel" id="mailersettings" class="tab-pane fade show active">

                <!-- Page Header -->
                <div class="page-header">
                    <div class="row">
                        <div class="col-sm-12">
                            <h3 class="page-title">Mailer Settings</h3>
                            <ul class="breadcrumb">
                                <li class="breadcrumb-item"><a href="{{route('dashboard')}}">Dashboard</a></li>
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
                               <div class="table_md-responsive">
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

            <!-- Payment gateway -->
            <div role="tabpanel" id="paymentgateway" class="tab-pane fade">

                <!-- Page Header -->
                <div class="page-header">
                    <div class="row">
                        <div class="col-sm-12">
                            <h3 class="page-title">Payment gateway</h3>
                            <ul class="breadcrumb">
                                <li class="breadcrumb-item"><a href="{{route('dashboard')}}">Dashboard</a></li>
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
                                    {{ Form::text('currency', $stripe_settings['CURRENCY']??'', ['class' => 'form-control','placeholder' => __('Currency')]) }}
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
            <!--common settings -->
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
                                  $users=\App\User::where('created_by',$domain_user)->Orwhere('id',Auth::user()->id)->get();

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
                <select name="frontend_profiles[]" style="width: 100% !important" class="form-control select2" multiple="" required>

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
		<!--twilio settings -->
		<div role="tabpanel" id="twiliokeys" class="tab-pane fade">

		<!-- Page Header -->
		<div class="page-header">
		<div class="row">
		<div class="col-sm-12">
		<h3 class="page-title">Twilio Keys</h3>
		<ul class="breadcrumb">
		<li class="breadcrumb-item"><a href="{{route('dashboard')}}">Dashboard</a></li>
		<li class="breadcrumb-item"><a href="javascript:(0)">Settings</a></li>
		<li class="breadcrumb-item active">Twilio Keys</li>
		</ul>
		</div>
		</div>
		</div>
		<!-- /Page Header -->
		{{ Form::open(['route' => ['site.settings.store'],'id' => 'update_setting']) }}
		 @csrf

		<div class="row">
		@php
		 $twilio_settings=\App\SiteSettings::getValByName('twilio_key');

		 @endphp
		<div class="col-12">
		<div class="card">

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
		<!-- /twilio settings-->

		<div role="tabpanel" id="cloudkeys" class="tab-pane fade">


		<!-- /Page Header -->
		{{ Form::open(['route' => ['site.settings.store'],'id' => 'update_setting']) }}
		 @csrf
<div class="row">
		<div class="col-sm-12">
		<h3 class="page-title">Cloudinary/Mtownsend </h3>
		<ul class="breadcrumb">
		<li class="breadcrumb-item"><a href="{{route('dashboard')}}">Dashboard</a></li>
		<li class="breadcrumb-item"><a href="javascript:(0)">Settings</a></li>
		<li class="breadcrumb-item active">Cloudinary</li>
		</ul>
		</div>
		</div>
		<div class="row">
		@php
		 $twilio_settings=\App\SiteSettings::getValByName('twilio_key');

		 @endphp
		<div class="col-12">
		<div class="card">

		<div class="card-body">

		<div class="form-group">
		<div class="row">
		<div class="col-md-12">
                    <div class="custom-control custom-switch float-right">
                                    <input type="checkbox" class="custom-control-input" name="CLOUDINARY_STATUS" id="CLOUDINARY_STATUS" {{(!empty(env('CLOUDINARY_STATUS')) && env('CLOUDINARY_STATUS') == 'on') ? 'checked' : ''}}>
                                    <label class="custom-control-label form-control-label" for="CLOUDINARY_STATUS">{{__('Enable')}}</label>
                                </div>
		<div class="form-group">
			{{ Form::label('CLOUDINARY_URL', __('Cloudinary URL'),['class' => 'form-control-label']) }}
			{{ Form::text('CLOUDINARY_URL', (env('CLOUDINARY_URL') ?? ''), ['class' => 'form-control','placeholder' => __('Cloudinary URL')]) }}
			</div>
		</div>
		<div class="col-md-12">
                    <div class="custom-control custom-switch float-right">
                                    <input type="checkbox" class="custom-control-input" name="MTOWNSEND_STATUS" id="MTOWNSEND_STATUS" {{(!empty(env('MTOWNSEND_STATUS')) && env('MTOWNSEND_STATUS') == 'on') ? 'checked' : ''}}>
                                    <label class="custom-control-label form-control-label" for="MTOWNSEND_STATUS">{{__('Enable')}}</label>
                                </div>
		<div class="form-group">
			{{ Form::label('MTOWNSEND_KEY', __('Mtownsend KEY'),['class' => 'form-control-label']) }}
                        <input name="MTOWNSEND_KEY" value="{{env('MTOWNSEND_KEY')??''}}" required  id="password-field9" type="password" class="form-control" >
              <span toggle="#password-field9" class="fa fa-fw fa-eye field-icon toggle-password"></span>
                        <small>For more details and API Key <a target="blank" href="https://packagist.org/packages/mtownsend/remove-bg">visit here</a></small>
			</div>
		</div>


		</div>
		</div>

		<div class="row">
		<div class="col-12">
		<div class="text-right">
			{{ Form::hidden('from','Cloudinary') }}
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
		<!-- /twilio settings-->

        <!-- /WHM settings START-->

        <div role="tabpanel" id="WHMsetting" class="tab-pane fade">

        <!-- Page Header -->
        <div class="page-header">
        <div class="row">
        <div class="col-sm-12">
        <h3 class="page-title">WHM Settings</h3>
        <ul class="breadcrumb">
        <li class="breadcrumb-item"><a href="{{route('dashboard')}}">Dashboard</a></li>
        <li class="breadcrumb-item"><a href="javascript:(0)">Settings</a></li>
        <li class="breadcrumb-item active">WHM Settings</li>
        </ul>
        </div>
        </div>
        </div>
        <!-- /Page Header -->
        {{ Form::open(['route' => ['site.settings.store'],'id' => 'update_setting']) }}
         @csrf

        <div class="row">

        <div class="col-12">
        <div class="card">

        <div class="card-body">


        <div class="row">
            <div class="col-md-12">
                <div class="form-group">
                    {{ Form::label('CPANEL_HOST', __('Cpanel Host'),['class' => 'form-control-label']) }}

                    {{ Form::text('CPANEL_HOST', (env('CPANEL_HOST') ?? ''), ['class' => 'form-control','placeholder' => __('CPANEL HOST')]) }}
                </div>
            </div>
        </div>

        <div class="row">
        <div class="col-md-12">
            <div class="form-group">
                {{ Form::label('WHM_USER_NAME', __('WHM User Name'),['class' => 'form-control-label']) }}
                {{ Form::text('WHM_USER_NAME', (env('WHM_USER_NAME') ?? ''), ['class' => 'form-control','required' => 'required']) }}
            </div>
        </div>
        </div>

        <div class="row">
        <div class="col-md-12">
            <div class="form-group">
                {{ Form::label('CPANEL_USER_NAME', __('Cpanel User Name'),['class' => 'form-control-label']) }}
                {{ Form::text('CPANEL_USER_NAME', (env('CPANEL_USER_NAME') ?? ''), ['class' => 'form-control','required' => 'required']) }}
            </div>
        </div>
        </div>

        <div class="row">
            <div class="col-md-12">
                <div class="form-group">
                    {{ Form::label('CPANEL_AUTH_TYPE', __('Cpanel Auth Type'),['class' => 'form-control-label']) }}
                   <select class="form-control" name="CPANEL_AUTH_TYPE" required>
                  <!--   <option value="">Cpanel Auth Type</option> -->
                    <option @if (env('CPANEL_AUTH_TYPE')=='hash') selected @endif value="hash">Hash</option>
                    <option @if (env('CPANEL_AUTH_TYPE')=='password') selected @endif value="password">Password</option>

                   </select>
                </div>
            </div>
        </div>

       <div class="row">
        <div class="col-md-12">
            <div class="form-group">
                {{ Form::label('WHM_SERVER_IP', __('WHM SERVER IP'),['class' => 'form-control-label']) }}
                {{ Form::text('WHM_SERVER_IP', (env('WHM_SERVER_IP') ?? ''), ['class' => 'form-control','required' => 'required']) }}
            </div>
        </div>
        </div>

        <div class="row">
        <div class="col-md-12">
            <div class="form-group">
                {{ Form::label('WHM_PASSWORD', __('WHM Password'),['class' => 'form-control-label']) }}
                <!--{{ Form::text('WHM_PASSWORD', (env('WHM_PASSWORD') ?? ''), ['class' => 'form-control','required' => 'required']) }}-->
                <input name="WHM_PASSWORD" value="{{env('WHM_PASSWORD')??''}}" required  id="password-field10" type="password" class="form-control" >
              <span toggle="#password-field10" class="fa fa-fw fa-eye field-icon toggle-password"></span>
            </div>
        </div>
        </div>

        <div class="row">
        <div class="col-12">
        <div class="text-right">
            {{ Form::hidden('from','WHM_Settings') }}
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
        <!-- /WHM settings ENDS-->

        <!-- /WHMCS Setting Ends -->


        <div role="tabpanel" id="WHMCSsetting" class="tab-pane fade">

        <!-- Page Header -->
        <div class="page-header">
        <div class="row">
        <div class="col-sm-12">
        <h3 class="page-title">WHMCS Settings</h3>
        <ul class="breadcrumb">
        <li class="breadcrumb-item"><a href="{{route('dashboard')}}">Dashboard</a></li>
        <li class="breadcrumb-item"><a href="javascript:(0)">Settings</a></li>
        <li class="breadcrumb-item active">WHMCS Settings</li>
        </ul>
        </div>
        </div>
        </div>
             <div class="row">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-header">
                                <h4 class="card-title">WHMCS Settings</h4>
                            </div>
                            <div class="card-body">
                                {{ Form::open(['route' => ['site.settings.store'],'id' => 'update_setting']) }}
                                 @csrf
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">

                                 {{ Form::label('WHMCS_API_URL', __('WHMCS API URL'),['class' => 'form-control-label']) }}

                                 {{ Form::text('WHMCS_API_URL', (env('WHMCS_API_URL') ?? ''), ['class' => 'form-control','required' => 'required','placeholder' => __('WHMCS API URL')]) }}

                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                     {{ Form::label('WHMCS_IDENTIFIER', __('WHMCS API Identifier'),['class' => 'form-control-label']) }}

                                 {{ Form::text('WHMCS_IDENTIFIER', (env('WHMCS_IDENTIFIER') ?? ''), ['class' => 'form-control','required' => 'required','placeholder' => __('WHMCS API Identifier')]) }}
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    {{ Form::label('WHMCS_SECRET', __('WHMCS API Secret'),['class' => 'form-control-label']) }}

                                 {{ Form::text('WHMCS_SECRET', (env('WHMCS_SECRET') ?? ''), ['class' => 'form-control','required' => 'required','placeholder' => __('WHMCS API Secret')]) }}
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                     {{ Form::label('WHMCS_AUTO_LOGIN_URL', __('WHMCS AUTO LOGIN Url'),['class' => 'form-control-label']) }}

                                 {{ Form::text('WHMCS_AUTO_LOGIN_URL', (env('WHMCS_AUTO_LOGIN_URL') ?? ''), ['class' => 'form-control','required' => 'required','placeholder' => __('WHMCS AUTO LOGIN Url')]) }}
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    {{ Form::label('AUTO_AUTH_KEY', __('Auto Auth Key'),['class' => 'form-control-label']) }}

                                 {{ Form::text('AUTO_AUTH_KEY', (env('AUTO_AUTH_KEY') ?? ''), ['class' => 'form-control','required' => 'required','placeholder' => __('Auto Auth Key')]) }}
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                     {{ Form::label('GO_TO_URL', __('Go To URL'),['class' => 'form-control-label']) }}

                                 {{ Form::text('GO_TO_URL', (env('GO_TO_URL') ?? ''), ['class' => 'form-control','required' => 'required','placeholder' => __('Go To URL')]) }}
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    {{ Form::label('API_ACCESS_KEY', __('API Access Key'),['class' => 'form-control-label']) }}
                                    <!--{{ Form::text('API_ACCESS_KEY', (env('API_ACCESS_KEY') ?? ''), ['class' => 'form-control','required'=>'required','placeholder' => __('MAPI Access Key')]) }}-->
                                    <input name="API_ACCESS_KEY" value="{{env('API_ACCESS_KEY')??''}}" required  id="password-field11" type="password" class="form-control" >
              <span toggle="#password-field11" class="fa fa-fw fa-eye field-icon toggle-password"></span>
                                </div>
                            </div>

                            <div class="col-6">
                                <div class="text-right">
                                    {{ Form::hidden('from','WHMCS_settings') }}
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
            <!-- /WHMCS Setting Ends -->


			     <!-- /VerifyCert   -->
  <div role="tabpanel" id="VerifyCert" class="tab-pane fade">

        <!-- Page Header -->
        <div class="page-header">
        <div class="row">
        <div class="col-sm-12">
        <h3 class="page-title">Verify Cert</h3>
        <ul class="breadcrumb">
        <li class="breadcrumb-item"><a href="{{route('dashboard')}}">Dashboard</a></li>
        <li class="breadcrumb-item"><a href="javascript:(0)">Settings</a></li>
        <li class="breadcrumb-item active">Verify Cert</li>
        </ul>
        </div>
        </div>
        </div>
             <div class="row">
                    <div class="col-12">
                        <div class="card">

                            <div class="card-body">
                                {{ Form::open(['route' => ['site.settings.store'],'id' => 'update_setting']) }}
                                 @csrf
                         <div class="row">
                             <div class="col-md-12">
                                <div class="form-group">
                                    {{ Form::label('CERTI_TWILIO_SID', __('Enter Number SID'),['class' => 'form-control-label']) }}
                                    <!--{{ Form::text('CERTI_TWILIO_SID',env('CERTI_TWILIO_SID'), ['class' => 'form-control']) }}-->
                                    <input name="CERTI_TWILIO_SID" value="{{env('CERTI_TWILIO_SID')??''}}" required  id="password-field12" type="password" class="form-control" >
              <span toggle="#password-field12" class="fa fa-fw fa-eye field-icon toggle-password"></span>
                                </div>
                            </div>


                            <div class="col-md-12">
                                <div class="form-group">
                                    {{ Form::label('CERTIFICATE_TWILIO_NUMBER', __('Enter Number'),['class' => 'form-control-label']) }}<br>
                                    <!-- {{ Form::text('CERTIFICATE_TWILIO_NUMBER',env('CERTIFICATE_TWILIO_NUMBER'), ['class' => 'form-control']) }} -->
                                    <input type="text" class="form-control phone-input required" value="{{ env('CERTIFICATE_TWILIO_NUMBER') ?? '' }}" placeholder="Phone Number" required>
                                    <input class="hidden-phone" type="hidden" name="contact_page_phone" value="{{ env('CERTIFICATE_TWILIO_NUMBER') ?? '' }}">
                                </div>
                            </div>


                            <div class="col-md-12">
                                <div class="form-group">
                                    {{ Form::label('CERTIFICATE_MESSAGE_TYPE', __('Certificate welcome Message Type'),['class' => 'form-control-label']) }}
                                <select class="form-control" name="CERTIFICATE_MESSAGE_TYPE">
                                @if(env('CERTIFICATE_MESSAGE_TYPE')=="tts")
                                    <option value="tts"  selected >Text To Speech</option>
                                    <option value="mp3" >Use MP3</option>
                                @else
                                    <option value="tts" >Text To Speech</option>
                                    <option value="mp3" selected >Use MP3</option>
                                @endif

                                </select>

                                </div>
                            </div>



                            <div class="col-md-12">
                                <div class="form-group">
                                    {{ Form::label('CERTIFICATE_TTS', __('Certificate welcome TTS Message'),['class' => 'form-control-label']) }}
                                    {{ Form::text('CERTIFICATE_TTS', env('CERTIFICATE_TTS'), ['class' => 'form-control']) }}
                                </div>
                            </div>
				<div class="col-md-12">
                        <div class="form-group uploadvideo" id="videolink">
                            <div class="row">
                                <div class="col-md-12">
                                    <label class="form-control-label">Certificate welcome MP3 Message</label>

                                    <input type="file" class="form-control dropify" value="{{env('CERTIFICATE_MP3')}}" name="CERTIFICATE_MP3"  accept="mp3" >
                                </div>
                            </div>
                        </div>
                        </div>


                            <div class="text-right">
                                {{ Form::hidden('from','verifycert') }}
                                <button type="submit" class="btn btn-sm btn-primary rounded-pill">{{__('Save changes')}}</button>
                            </div>

                        </div>
                        {{ Form::close() }}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
		 <!-- /VerifyCert -->

	     <!-- /CommissionSetting   -->
  <div role="tabpanel" id="CommissionSetting" class="tab-pane fade">

        <!-- Page Header -->
        <div class="page-header">
        <div class="row">
        <div class="col-sm-12">
        <h3 class="page-title">Commission Setting</h3>
        <ul class="breadcrumb">
        <li class="breadcrumb-item"><a href="{{route('dashboard')}}">Dashboard</a></li>
        <li class="breadcrumb-item"><a href="javascript:(0)">Settings</a></li>
        <li class="breadcrumb-item active">Commission Setting</li>
        </ul>
        </div>
        </div>
        </div>
             <div class="row">
                    <div class="col-12">
                        <div class="card">

                            <div class="card-body">
                                {{ Form::open(['route' => ['site.settings.store'],'id' => 'update_setting']) }}
                                 @csrf

								   <div class="row">
                            <div class="col-md-12" style="display: inline-flex;">




                                            <div class="form-group">
                                                <div class="" style="display: inline-flex; ">
                                                    <span class="form-control-label">Commission</span>
                                                    <div class="custom-control custom-switch" style="margin-left: 12px;">
													@if(!empty($user->stripe_account_id))


											    <input type="checkbox" class="custom-control-input" value="1" name="COMMISSION_STATUS" id="COMMISSION_STATUS" {{(env('COMMISSION_STATUS') && env('COMMISSION_STATUS') == 1) ? 'checked' : ''}}>
                                                        <label class="custom-control-label form-control-label" for="COMMISSION_STATUS"></label>
													@else

													     <div class=" customSwitchesSyndicate">
											    <input type="checkbox" class="custom-control-input Oncommission" value="1" name="COMMISSION_STATUS" id="COMMISSION_STATUS" {{(env('COMMISSION_STATUS') && env('COMMISSION_STATUS') == 1) ? 'checked' : ''}}>
                                                        <label class="custom-control-label form-control-label" for="COMMISSION_STATUS"></label>

													</div>

													@endif


                                                    </div>
                                                </div>
                                            </div>



                            </div>
                        </div>
                         <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="owner">Admin (%)</label>


                                    <input type="number" id="admin_com" class="form-control" name="ADMIN_COMMISSION" required value="{{env('ADMIN_COMMISSION')}}" min="0">
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="promoter">Promoter (%)</label>
                                    <input type="number" id="admin_pro" class="form-control" name="PROMOTER_COMMISSION" required value="{{env('PROMOTER_COMMISSION')}}" min="0">
                                </div>
                            </div>

							    <!--<div class="col-md-12">
                                <div class="form-group">
                                    <label for="promoter">Reseller</label>
                                    <input type="number" class="form-control" name="RESELLER_COMMISSION" required value="{{env('RESELLER_COMMISSION')}}" min="0">
                                </div>
                            </div>-->
                            <div class="text-right">
                                {{ Form::hidden('from','commission') }}
                                <button type="submit" class="btn btn-sm btn-primary rounded-pill">{{__('Save changes')}}</button>
                            </div>

                        </div>
                        {{ Form::close() }}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
		 <!-- /CommissionSetting -->


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
                                    <!--{{ Form::text('blaze_key', $blaze_settings['blaze_key']??"", ['class' => 'form-control','placeholder' => __('Blaze Key')]) }}-->
                                    <input name="blaze_key" value="{{$blaze_settings['blaze_key']??''}}" placeholder="Blaze Key"  id="password-field1" type="password" class="form-control" >
              <span toggle="#password-field1" class="fa fa-fw fa-eye field-icon toggle-password"></span>
                                         @if(!empty($blaze_credits->owner_email))
                                    <small class="text-info" >Emailable account <b>{{$blaze_credits->owner_email}}</b> has <b>{{$blaze_credits->available_credits}}</b> available credits left in account.</small><br>
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
                                    <!--{{ Form::text('google_map_key', $googlemap_settings['google_map_key']??"", ['class' => 'form-control','placeholder' => __('Google Map API Key')]) }}-->
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
                                  {{ Form::open(['route' => ['site.settings.store'],'id' => 'update_setting']) }}
                                 @csrf
                                 <div class="row">

                    <div class="col-12">
                        <div class="card">
                            <div class="card-header">
                                <h4 class="card-title">PUSHER API</h4>



                            </div>
                            <div class="card-body">

                        <div class="form-group">
        <div class="row">
            <div class="col-md-12">

                                <div class="form-group">
                                    {{ Form::label('PUSHER_APP_ID', __('PUSHER APP ID'),['class' => 'form-control-label']) }}
                                    {{ Form::text('PUSHER_APP_ID', env('PUSHER_APP_ID')??"", ['class' => 'form-control','placeholder' => __('PUSHER APP ID')]) }}
                                    <small>To get Pusher App API Key <a class="text-primary" target="_blank" href="https://dashboard.pusher.com/">Click here</a>. </small>
                                </div>

            </div>
            <div class="col-md-12">

                                <div class="form-group">
                                    {{ Form::label('PUSHER_APP_KEY', __('PUSHER APP KEY'),['class' => 'form-control-label']) }}
                                    {{ Form::text('PUSHER_APP_KEY', env('PUSHER_APP_KEY')??"", ['class' => 'form-control','placeholder' => __('PUSHER APP KEY')]) }}
                                </div>

            </div>
            <div class="col-md-12">

                                <div class="form-group">
                                    {{ Form::label('PUSHER_APP_SECRET', __('PUSHER APP SECRET'),['class' => 'form-control-label']) }}
                                    <!--{{ Form::text('PUSHER_APP_SECRET', env('PUSHER_APP_SECRET')??"", ['class' => 'form-control','placeholder' => __('PUSHER APP SECRET')]) }}-->
                                    <input name="PUSHER_APP_SECRET" value="{{env('PUSHER_APP_SECRET')??''}}" placeholder="PUSHER APP SECRET"  id="password-field3" type="password" class="form-control" >
              <span toggle="#password-field3" class="fa fa-fw fa-eye field-icon toggle-password"></span>
                                </div>

            </div>
            <div class="col-md-12">

                                <div class="form-group">
                                    {{ Form::label('PUSHER_APP_CLUSTER', __('PUSHER APP CLUSTER'),['class' => 'form-control-label']) }}
                                    {{ Form::text('PUSHER_APP_CLUSTER', env('PUSHER_APP_CLUSTER')??"", ['class' => 'form-control','placeholder' => __('PUSHER APP CLUSTER')]) }}
                                </div>

            </div>

        </div>
    </div>





                               <h4 class="card-title">Video Calling Twilio API<div class="custom-control custom-switch float-right">
                                    <input type="checkbox" class="custom-control-input" name="TWILIO_VIDEO_ENABLE" id="TWILIO_VIDEO_ENABLE" {{(!empty(env('TWILIO_VIDEO_ENABLE')) && env('TWILIO_VIDEO_ENABLE') == 'on') ? 'checked' : ''}}>
                                    <label class="custom-control-label form-control-label" for="TWILIO_VIDEO_ENABLE">{{__('Enable')}}</label>
                                </div></h4>


                            </div>
                            <div class="card-body">

                        <div class="form-group">
        <div class="row">
            <div class="col-md-12">

                                <div class="form-group">
                                    {{ Form::label('TWILIO_ACCOUNT_SID', __('TWILIO_ACCOUNT_SID'),['class' => 'form-control-label']) }}
                                    {{ Form::text('TWILIO_ACCOUNT_SID', env('TWILIO_ACCOUNT_SID')??"", ['class' => 'form-control','placeholder' => __('TWILIO_ACCOUNT_SID')]) }}
                                    <small>To get Twilio Video App API Key <a class="text-primary" target="_blank" href="https://www.twilio.com/docs/video">Click here</a>. </small>
                                </div>

            </div>
            <div class="col-md-12">

                                <div class="form-group">
                                    {{ Form::label('TWILIO_ACCOUNT_TOKEN', __('TWILIO_ACCOUNT_TOKEN'),['class' => 'form-control-label']) }}
                                    {{ Form::text('TWILIO_ACCOUNT_TOKEN', env('TWILIO_ACCOUNT_TOKEN')??"", ['class' => 'form-control','placeholder' => __('TWILIO_ACCOUNT_TOKEN')]) }}
                                </div>

            </div>
            <div class="col-md-12">

                                <div class="form-group">
                                    {{ Form::label('TWILIO_API_KEY', __('TWILIO_API_KEY'),['class' => 'form-control-label']) }}
                                    {{ Form::text('TWILIO_API_KEY', env('TWILIO_API_KEY')??"", ['class' => 'form-control','placeholder' => __('TWILIO_API_KEY')]) }}
                                </div>

            </div>
            <div class="col-md-12">

                                <div class="form-group">
                                    {{ Form::label('TWILIO_API_SECRET', __('TWILIO_API_SECRET'),['class' => 'form-control-label']) }}
                                    <!--{{ Form::text('TWILIO_API_SECRET', env('TWILIO_API_SECRET')??"", ['class' => 'form-control','placeholder' => __('TWILIO_API_SECRET')]) }}-->
                                       <input name="TWILIO_API_SECRET" value="{{env('TWILIO_API_SECRET')??''}}" placeholder="TWILIO_API_SECRET"  id="password-field4" type="password" class="form-control" >
              <span toggle="#password-field4" class="fa fa-fw fa-eye field-icon toggle-password"></span>
                                </div>

            </div>


        </div>
    </div>

                        <div class="row">
                            <div class="col-12">
                                <div class="text-right">
                                    {{ Form::hidden('from','pusheragora') }}
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
            <!-- /blaze settings-->

              <!-- Meta -->
            <div role="tabpanel" id="meta" class="tab-pane fade">

                <!-- Page Header -->
                <div class="page-header">
                    <div class="row">
                        <div class="col-sm-12">
                            <h3 class="page-title">Meta Data</h3>
                            <ul class="breadcrumb">
                                <li class="breadcrumb-item"><a href="dashboard">Dashboard</a></li>
                                <li class="breadcrumb-item"><a href="javascript:(0)">Settings</a></li>
                                <li class="breadcrumb-item active">Meta Data</li>
                            </ul>
                        </div>
                    </div>
                </div>
                <!-- /Page Header -->

                <div class="row">
                    <div class="col-12">
                        <div class="card">
                              @php
                $meta_data = \App\SiteSettings::WebsiteSetting('meta_data');

                  if(!empty($meta_data->value)){
                       $meta_data  = json_decode($meta_data->value,true);
                  }else{
                      $meta_data = array();
                  }



            @endphp

                            <div class="card-header">
                                <h4 class="card-title">Meta Data</h4>
                            </div>
                            <div class="card-body">
                                  {{ Form::open(['route' => ['site.settings.store'],'id' => 'update_setting']) }}
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    {{ Form::label('meta_title', __('Meta Title'),['class' => 'form-control-label']) }}
                                    {{ Form::text('meta_title', ($meta_data['meta_title'] ?? ''), ['class' => 'form-control','required' => 'required']) }}
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="form-group">
                                    {{ Form::label('meta_description', __('Meta Description'),['class' => 'form-control-label']) }}
                                    {{ Form::textarea('meta_description',  ($meta_data['meta_description'] ?? ''), ['class' => 'form-control','required' => 'required']) }}
                                </div>
                            </div>

                            <div class="text-right">
                                {{ Form::hidden('from','meta_data') }}
                                <button type="submit" class="btn btn-sm btn-primary rounded-pill">{{__('Save changes')}}</button>
                            </div>

                        </div>
                        {{ Form::close() }}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- /Meta -->

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
                            <div class="card-body">
                                 {{ Form::open(['route' => ['site.settings.store'],'id' => 'update_setting','enctype' => 'multipart/form-data']) }}
                        <div class="row">
							<div class="col-4">
                                  <div class="form-group">

                                      {{ Form::label('full_logo', __('Logo'),['class' => 'form-control-label']) }}
                                      @if(!empty($logo['logo']))
                                          <input type="file" name="full_logo"id="full_logo" class="custom-input-file croppie" default="{{asset('storage')}}/logo/{{ $logo['logo']}}" crop-width="326" crop-height="78"  accept="image/*">
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


							  <div class="col-md-4">
                                  <div class="form-group">
                                      {{ Form::label('favicon', __('Favicon'),['class' => 'form-control-label']) }}

                                      @if(!empty($logo['favicon']))
                                          <input type="file" name="favicon"id="favicon" class="custom-input-file croppie" default="{{asset('storage')}}/logo/{{ $logo['favicon']}}" crop-width="60" crop-height="60"  accept="image/*">
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
                        </div>

						<div class="row">

                            <div class="col-md-12">
                                <div class="form-group">
                                    {{ Form::label('logo_text', __('Logo Text'),['class' => 'form-control-label']) }}
									<input type="text" class="form-control" name="logo_text" value="{{ $logo_textdata}}" placeholder="Enter Logo Text">

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

                                      @if(!empty($logo['homebackground']))
                                          <input type="file" name="homebackground"id="homebackground" class="custom-input-file croppie" default="{{asset('storage')}}/logo/{{ $logo['homebackground']}}" crop-width="600" crop-height="400"   accept="image/*">
                                      @else
                                          <input type="file" name="homebackground" id="homebackground" class="custom-input-file croppie"   accept="image/*" >
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

                                      @if(!empty($logo['registerationbackground']))
                                          <input type="file" name="registerbackground"id="registerbackground" class="custom-input-file croppie" crop-width="600" crop-height="400" default="{{asset('storage')}}/logo/{{ $logo['registerationbackground']}}"  accept="image/*">
                                      @else
                                          <input type="file" name="registerbackground" id="registerbackground" class="custom-input-file croppie"  accept="image/*" >
                                      @endif

                                      @error('registerbackground')
                                      <span class="registerbackground" role="alert">
                                        <small class="text-danger">{{ $message }}</small>
                                    </span>
                                      @enderror
                                  </div>

                          </div>
                     </div>

                     <!-- background Image -->
					                         <div class="row">

                            <div class="col-md-12">
                                <div class="form-group">
                                 <label>Frontend Theme</label>
                                                <select class="form-control"  name="FRONTEND_THEME">
                                                    <option value="">Select Frontend Theme</option>

                                                    <option value="default" @if (env('FRONTEND_THEME') =='default') selected @endif>Default</option>
                                                    <option value="home1" @if (env('FRONTEND_THEME') =='home1') selected @endif>Home one</option>
                                                    <option value="home2" @if (env('FRONTEND_THEME') =='home2') selected @endif>Home two</option>
                                                    <option value="home3" @if (env('FRONTEND_THEME') =='home3') selected @endif>Home three</option>
                                                    <option value="home4" @if (env('FRONTEND_THEME') =='home4') selected @endif>Home four</option>

                                                </select>

                                </div>
                            </div>


                        </div>

				            <div class="row">

                        <div class="col-md-12">
                        <div class="form-group">
                                      {{ Form::label('registerbackgroundvideo', __('Background Hero Video'),['class' => 'form-control-label']) }}

                                                     <input type="file" class="form-control dropify" placeholder="Upload video File" name="video"  accept="video/*" data-default-file="{{asset('storage')}}/logo/{{ env('FRONTEND_THEME_BACKGROUND_VIDEO')??'' }}" value="">
                                      @error('registerbackgroundvideo')
                                      <span class="registerbackground" role="alert">
                                        <small class="text-danger">{{ $message }}</small>
                                    </span>
                                      @enderror
                                  </div>

                          </div>
                     </div>
                        <div class="row">

                            <div class="col-md-12">
                                <div class="form-group">
                                    {{ Form::label('footer_text', __('Footer Text'),['class' => 'form-control-label']) }}
									<input type="text" class="form-control" name="footer_text" value="{{ $footerdata}}" placeholder="Enter Footer Text">

                                </div>
                            </div>

                        </div>
                        <hr/>



                        <div class="text-right">
                            {{ Form::hidden('from','site_setting') }}
                            <button type="submit" class="btn btn-sm btn-primary">{{__('Save changes')}}</button>
                        </div>
                        {{ Form::close() }}
                            </div>
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

            <!-- AWS -->
            <div role="tabpanel" id="aws" class="tab-pane fade show">

                <!-- Page Header -->
                <div class="page-header">
                    <div class="row">
                        <div class="col-sm-12">
                            <h3 class="page-title">AWS Settings</h3>
                            <ul class="breadcrumb">
                                <li class="breadcrumb-item"><a href="{{route('dashboard')}}">Dashboard</a></li>
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

                            <div class="card-body">
                                {{ Form::open(['route' => ['site.settings.store'],'id' => 'update_setting']) }}
                                 @csrf
                                 @php
                                 $aws_settings=\App\SiteSettings::getValByName('aws_settings');

                                 @endphp
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    {{ Form::label('aws_bucket', __('AWS Bucket'),['class' => 'form-control-label']) }}
                                    {{ Form::text('aws_bucket', $aws_settings['AWS_BUCKET']??'', ['class' => 'form-control','required'=>'required','placeholder' => __('AWS Bucket')]) }}
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    {{ Form::label('aws_default_region', __('AWS Default Region'),['class' => 'form-control-label']) }}
                                    {{ Form::text('aws_default_region',  $aws_settings['AWS_DEFAULT_REGION']??'' , ['class' => 'form-control','required'=>'required','placeholder' => __('AWS Default Region')]) }}
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    {{ Form::label('aws_access_key_id', __('AWS Access Key ID'),['class' => 'form-control-label']) }}
                                    {{ Form::text('aws_access_key_id', $aws_settings['AWS_ACCESS_KEY_ID']??'', ['class' => 'form-control','required'=>'required','placeholder' => __('AWS Access Key ID')]) }}
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    {{ Form::label('aws_secret_access_key', __('AWS Secret Access Key'),['class' => 'form-control-label']) }}

                                        <input name="aws_secret_access_key" value="{{$aws_settings['AWS_SECRET_ACCESS_KEY']??''}}" placeholder="AWS Secret Access Key"  id="password-field5" type="password" class="form-control" >
              <span toggle="#password-field5" class="fa fa-fw fa-eye field-icon toggle-password"></span>
                                </div>
                            </div>

                        </div>
                        <div class="row">

                            <div class="col-12">
                                <div class="text-right">
                                    {{ Form::hidden('from','aws') }}
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
            <!-- /AWS -->


			  <!-- Bot -->
            <div role="tabpanel" id="pathwaybot" class="tab-pane fade show">


                <div class="row">
                    <div class="col-12">
                         {{ Form::open(['route' => ['site.settings.store'],'id' => 'update_setting']) }}
                                            @php
                                 $path_settings=\App\SiteSettings::getValByName('pathways_bot');

                                 @endphp
                        <div class="card">
                            <div class="card-header">
                                <h4 class="card-title">Pathways Bot Settings</h4>
                                <small> Update speech text answers against each option. If bot is enabled then it will respond when user will select options. You can use following keywords in your answers. <br><b>{name},{email},{mobile},{address}</b> </small>

                                <div class="col-12 text-right">
                                <div class="custom-control custom-switch">
                                    <input type="checkbox" class="custom-control-input" name="enable_pathway_bot" id="enable_pathway_bot" {{(!empty($path_settings['ENABLE_BOT']) && $path_settings['ENABLE_BOT'] == 'on') ? 'checked' : ''}}>
                                    <label class="custom-control-label form-control-label" for="enable_pathway_bot">{{__('Enable Pathway Bot')}}</label>
                                </div>
                            </div>
                            </div>
                            <div class="card-body">

                                 @csrf
              <div class="row">
                            <div class="col-6 py-2">
                                <h5 class="h5">{{__('Default Greatings Message')}}</h5>
                            </div>

                            <div class="col-md-12">
                                <div class="form-group">
                                    {{ Form::label('', __('Message'),['class' => 'form-control-label']) }}
                                    <input type="text" name="data[greeting_message]" class="form-control"  data-toggle ="tags"  placeholder="Enter bot speech text"  value="{{$path_settings['greeting_message']??""}}" />
                                </div>
                            </div>
                        </div>
                                 <hr>

                        <div class="row">
                            <div class="col-6 py-2">
                                <h5 class="h5">{{__('I am a')}}</h5>
                            </div>
                            <div class="col-md-12">
                                <div class="form-group">
                                    {{ Form::label('', __('Student'),['class' => 'form-control-label']) }}
                                    <input type="text" name="data[mentor_type_student]" class="form-control" data-toggle ="tags"  placeholder="Enter bot speech text"  value="{{$path_settings['mentor_type_student']??""}}" />

                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="form-group">
                                    {{ Form::label('', __('Employee'),['class' => 'form-control-label']) }}
                                    <input type="text" name="data[mentor_type_employee]" class="form-control" data-toggle ="tags"  placeholder="Enter bot speech text"  value="{{$path_settings['mentor_type_employee']??""}}" />

                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="form-group">
                                    {{ Form::label('', __('Volunteer'),['class' => 'form-control-label']) }}
                                    <input type="text" name="data[mentor_type_volunteer]" class="form-control" data-toggle ="tags"  placeholder="Enter bot speech text"  value="{{$path_settings['mentor_type_volunteer']??""}}" />

                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="form-group">
                                    {{ Form::label('', __('Justice Involved'),['class' => 'form-control-label']) }}
                                    <input type="text" name="data[mentor_type_justice]" class="form-control" data-toggle ="tags"  placeholder="Enter bot speech text"  value="{{$path_settings['mentor_type_justice']??""}}" />

                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="form-group">
                                    {{ Form::label('', __('Veteran'),['class' => 'form-control-label']) }}
                                    <input type="text" name="data[mentor_type_veteran]" class="form-control" data-toggle ="tags"  placeholder="Enter bot speech text"  value="{{$path_settings['mentor_type_veteran']??""}}" />

                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="form-group">
                                    {{ Form::label('', __('Non Profit Org'),['class' => 'form-control-label']) }}
                                    <input type="text" name="data[mentor_type_non_profit_org]" class="form-control" data-toggle ="tags"  placeholder="Enter bot speech text"  value="{{$path_settings['mentor_type_non_profit_org']??""}}" />

                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="form-group">
                                    {{ Form::label('', __('Small Business'),['class' => 'form-control-label']) }}
                                    <input type="text" name="data[mentor_type_small_business]" class="form-control" data-toggle ="tags"  placeholder="Enter bot speech text"  value="{{$path_settings['mentor_type_small_business']??""}}" />

                                </div>
                            </div>

                        </div>
                                 <hr>
                        <div class="row">
                            <div class="col-12">
                                <div class="text-right">
                                    {{ Form::hidden('from','pathwaybot') }}
                                    <button type="submit" class="btn btn-sm btn-primary rounded-pill">{{__('Save changes')}}</button>
                                </div>
                            </div>
                        </div>
                                 <hr>
                        <div class="row">
                            <div class="col-6 py-2">
                                <h5 class="h5">{{__('Level')}}</h5>
                            </div>
                            <div class="col-md-12">
                                <div class="form-group">
                                    {{ Form::label('', __('Grade Level K-12'),['class' => 'form-control-label']) }}
                                    <input type="text" name="data[level_K-12]" class="form-control" data-toggle ="tags"  placeholder="Enter bot speech text"  value="{{$path_settings['level_K-12']??""}}" />

                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="form-group">
                                    {{ Form::label('', __('Military'),['class' => 'form-control-label']) }}
                                    <input type="text" name="data[level_military]" class="form-control" data-toggle ="tags"  placeholder="Enter bot speech text"  value="{{$path_settings['level_military']??""}}" />

                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="form-group">
                                    {{ Form::label('', __('Vocational'),['class' => 'form-control-label']) }}
                                    <input type="text" name="data[level_vocational]" class="form-control" data-toggle ="tags"  placeholder="Enter bot speech text"  value="{{$path_settings['level_vocational']??""}}" />

                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="form-group">
                                    {{ Form::label('', __('College'),['class' => 'form-control-label']) }}
                                    <input type="text" name="data[level_college]" class="form-control" data-toggle ="tags"  placeholder="Enter bot speech text"  value="{{$path_settings['level_college']??""}}" />

                                </div>
                            </div>



                        </div>
                                 <hr>
                        <div class="row">
                            <div class="col-6 py-2">
                                <h5 class="h5">{{__('Branch')}}</h5>
                            </div>

                            <div class="col-md-12">
                                <div class="form-group">
                                    {{ Form::label('', __('Army'),['class' => 'form-control-label']) }}
                                    <input type="text" name="data[branch_army]" class="form-control" data-toggle ="tags"  placeholder="Enter bot speech text"  value="{{$path_settings['branch_army']??""}}" />

                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="form-group">
                                    {{ Form::label('', __('Navy'),['class' => 'form-control-label']) }}
                                    <input type="text" name="data[branch_navy]" class="form-control" data-toggle ="tags"  placeholder="Enter bot speech text"  value="{{$path_settings['branch_navy']??""}}" />

                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="form-group">
                                    {{ Form::label('', __('Airforce'),['class' => 'form-control-label']) }}
                                    <input type="text" name="data[branch_airforce]" class="form-control" data-toggle ="tags"  placeholder="Enter bot speech text"  value="{{$path_settings['branch_airforce']??""}}" />

                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="form-group">
                                    {{ Form::label('', __('Coast Guard'),['class' => 'form-control-label']) }}
                                    <input type="text" name="data[branch_coastguard]" class="form-control" data-toggle ="tags"  placeholder="Enter bot speech text"  value="{{$path_settings['branch_coastguard']??""}}" />

                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="form-group">
                                    {{ Form::label('', __('Marine corps'),['class' => 'form-control-label']) }}
                                    <input type="text" name="data[branch_marinecorps]" class="form-control" data-toggle ="tags"  placeholder="Enter bot speech text"  value="{{$path_settings['branch_marinecorps']??""}}" />

                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="form-group">
                                    {{ Form::label('', __('Space Force'),['class' => 'form-control-label']) }}
                                    <input type="text" name="data[branch_spaceforce]" class="form-control" data-toggle ="tags"  placeholder="Enter bot speech text"  value="{{$path_settings['branch_spaceforce']??""}}" />

                                </div>
                            </div>




                        </div>
                                 <hr>
                        <div class="row">
                            <div class="col-12">
                                <div class="text-right">
                                    {{ Form::hidden('from','pathwaybot') }}
                                    <button type="submit" class="btn btn-sm btn-primary rounded-pill">{{__('Save changes')}}</button>
                                </div>
                            </div>
                        </div>
                                 <hr>
                        <div class="row">
                            <div class="col-6 py-2">
                                <h5 class="h5">{{__('Do you have home wifi?')}}</h5>
                            </div>

                            <div class="col-md-12">
                                <div class="form-group">
                                    {{ Form::label('', __('Yes'),['class' => 'form-control-label']) }}
                                    <input type="text" name="data[wifi_yes]" class="form-control" data-toggle ="tags"  placeholder="Enter bot speech text"  value="{{$path_settings['wifi_yes']??""}}" />

                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="form-group">
                                    {{ Form::label('', __('No'),['class' => 'form-control-label']) }}
                                    <input type="text" name="data[wifi_no]" class="form-control" data-toggle ="tags"  placeholder="Enter bot speech text"  value="{{$path_settings['wifi_no']??""}}" />

                                </div>
                            </div>
                        </div>
                                 <hr>
                        <div class="row">
                            <div class="col-6 py-2">
                                <h5 class="h5">{{__('Do you have a tablet or home PC?')}}</h5>
                            </div>

                            <div class="col-md-12">
                                <div class="form-group">
                                    {{ Form::label('', __('Yes'),['class' => 'form-control-label']) }}
                                    <input type="text" name="data[home_pc_yes]" class="form-control" data-toggle ="tags"  placeholder="Enter bot speech text"  value="{{$path_settings['home_pc_yes']??""}}" />

                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="form-group">
                                    {{ Form::label('', __('No'),['class' => 'form-control-label']) }}
                                    <input type="text" name="data[home_pc_no]" class="form-control" data-toggle ="tags"  placeholder="Enter bot speech text"  value="{{$path_settings['home_pc_no']??""}}" />

                                </div>
                            </div>
                        </div>
                                 <hr>
                        <div class="row">
                            <div class="col-12">
                                <div class="text-right">
                                    {{ Form::hidden('from','pathwaybot') }}
                                    <button type="submit" class="btn btn-sm btn-primary rounded-pill">{{__('Save changes')}}</button>
                                </div>
                            </div>
                        </div>
                                 <hr>
                        <div class="row">
                            <div class="col-6 py-2">
                                <h5 class="h5">{{__('Would you like to join one of the following science, arts, or reading clubs?')}}</h5>
                            </div>

                            <div class="col-md-12">
                                <div class="form-group">
                                    {{ Form::label('', __('STEM'),['class' => 'form-control-label']) }}
                                    <input type="text" name="data[reading_club_STEM]" class="form-control" data-toggle ="tags"  placeholder="Enter bot speech text"  value="{{$path_settings['reading_club_STEM']??""}}" />

                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="form-group">
                                    {{ Form::label('', __('STEAM'),['class' => 'form-control-label']) }}
                                    <input type="text" name="data[reading_club_STEAM]" class="form-control" data-toggle ="tags"  placeholder="Enter bot speech text"  value="{{$path_settings['reading_club_STEAM']??""}}" />

                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="form-group">
                                    {{ Form::label('', __('STREAM'),['class' => 'form-control-label']) }}
                                    <input type="text" name="data[reading_club_STREAM]" class="form-control" data-toggle ="tags"  placeholder="Enter bot speech text"  value="{{$path_settings['reading_club_STREAM']??""}}" />

                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="form-group">
                                    {{ Form::label('', __('No'),['class' => 'form-control-label']) }}
                                    <input type="text" name="data[reading_club_No]" class="form-control" data-toggle ="tags"  placeholder="Enter bot speech text"  value="{{$path_settings['reading_club_No']??""}}" />

                                </div>
                            </div>

                        </div>
                                 <hr>
                                 <div class="row">
                            <div class="col-6 py-2">
                                <h5 class="h5">{{__('Do you live in a PHA Community?')}}</h5>
                            </div>

                            <div class="col-md-12">
                                <div class="form-group">
                                    {{ Form::label('', __('Yes'),['class' => 'form-control-label']) }}
                                    <input type="text" name="data[pha_community_yes]" class="form-control" data-toggle ="tags"  placeholder="Enter bot speech text"  value="{{$path_settings['pha_community_yes']??""}}" />

                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="form-group">
                                    {{ Form::label('', __('No'),['class' => 'form-control-label']) }}
                                    <input type="text" name="data[pha_community_no]" class="form-control" data-toggle ="tags"  placeholder="Enter bot speech text"  value="{{$path_settings['pha_community_no']??""}}" />

                                </div>
                            </div>
                        </div>
                                 <hr>
                        <div class="row">
                            <div class="col-12">
                                <div class="text-right">
                                    {{ Form::hidden('from','pathwaybot') }}
                                    <button type="submit" class="btn btn-sm btn-primary rounded-pill">{{__('Save changes')}}</button>
                                </div>
                            </div>
                        </div>
                                 <hr>
                                 <div class="row">
                            <div class="col-6 py-2">
                                <h5 class="h5">{{__('Are you Tax Exempt? ')}}</h5>
                            </div>

                            <div class="col-md-12">
                                <div class="form-group">
                                    {{ Form::label('', __('Yes'),['class' => 'form-control-label']) }}
                                    <input type="text" name="data[tax_exempted_yes]" class="form-control" data-toggle ="tags"  placeholder="Enter bot speech text"  value="{{$path_settings['tax_exempted_yes']??""}}" />

                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="form-group">
                                    {{ Form::label('', __('No'),['class' => 'form-control-label']) }}
                                    <input type="text" name="data[tax_exempted_no]" class="form-control" data-toggle ="tags"  placeholder="Enter bot speech text"  value="{{$path_settings['tax_exempted_no']??""}}" />

                                </div>
                            </div>
                        </div>
                                 <hr>
                                 <div class="row">
                            <div class="col-6 py-2">
                                <h5 class="h5">{{__('Have you been in business, 2 years or more? ')}}</h5>
                            </div>

                            <div class="col-md-12">
                                <div class="form-group">
                                    {{ Form::label('', __('Yes'),['class' => 'form-control-label']) }}
                                    <input type="text" name="data[business_year_Yes]" class="form-control" data-toggle ="tags"  placeholder="Enter bot speech text"  value="{{$path_settings['business_year_Yes']??""}}" />

                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="form-group">
                                    {{ Form::label('', __('No'),['class' => 'form-control-label']) }}
                                    <input type="text" name="data[business_year_No]" class="form-control" data-toggle ="tags"  placeholder="Enter bot speech text"  value="{{$path_settings['business_year_No']??""}}" />

                                </div>
                            </div>
                        </div>
                                 <hr>
                                 <div class="row">
                            <div class="col-6 py-2">
                                <h5 class="h5">{{__('I am interested in  RFI, RFP,  Grant opportunities')}}</h5>
                            </div>

                            <div class="col-md-12">
                                <div class="form-group">
                                    {{ Form::label('', __('Yes'),['class' => 'form-control-label']) }}
                                    <input type="text" name="data[grant_opportunity_Yes]" class="form-control" data-toggle ="tags"  placeholder="Enter bot speech text"  value="{{$path_settings['grant_opportunity_Yes']??""}}" />

                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="form-group">
                                    {{ Form::label('', __('No'),['class' => 'form-control-label']) }}
                                    <input type="text" name="data[grant_opportunity_No]" class="form-control" data-toggle ="tags"  placeholder="Enter bot speech text"  value="{{$path_settings['grant_opportunity_No']??""}}" />

                                </div>
                            </div>
                        </div>
                                 <hr>
                        <div class="row">
                            <div class="col-12">
                                <div class="text-right">
                                    {{ Form::hidden('from','pathwaybot') }}
                                    <button type="submit" class="btn btn-sm btn-primary rounded-pill">{{__('Save changes')}}</button>
                                </div>
                            </div>
                        </div>
                                 <hr>
                                 <div class="row">
                            <div class="col-6 py-2">
                                <h5 class="h5">{{__('Are you on Probation, Parole?')}}</h5>
                            </div>

                            <div class="col-md-12">
                                <div class="form-group">
                                    {{ Form::label('', __('Yes'),['class' => 'form-control-label']) }}
                                    <input type="text" name="data[probation_parole_yes]" class="form-control" data-toggle ="tags"  placeholder="Enter bot speech text"  value="{{$path_settings['probation_parole_yes']??""}}" />

                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="form-group">
                                    {{ Form::label('', __('No'),['class' => 'form-control-label']) }}
                                    <input type="text" name="data[probation_parole_no]" class="form-control" data-toggle ="tags"  placeholder="Enter bot speech text"  value="{{$path_settings['probation_parole_no']??""}}" />

                                </div>
                            </div>
                        </div>
                                 <hr>
                                 <div class="row">
                            <div class="col-6 py-2">
                                <h5 class="h5">{{__('Are your a registered sex offender?')}}</h5>
                            </div>

                            <div class="col-md-12">
                                <div class="form-group">
                                    {{ Form::label('', __('Yes'),['class' => 'form-control-label']) }}
                                    <input type="text" name="data[sex_offender_yes]" class="form-control" data-toggle ="tags"  placeholder="Enter bot speech text"  value="{{$path_settings['sex_offender_yes']??""}}" />

                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="form-group">
                                    {{ Form::label('', __('No'),['class' => 'form-control-label']) }}
                                    <input type="text" name="data[sex_offender_no]" class="form-control" data-toggle ="tags"  placeholder="Enter bot speech text"  value="{{$path_settings['sex_offender_no']??""}}" />

                                </div>
                            </div>
                        </div>
                                 <hr>
                        <div class="row">
                            <div class="col-12">
                                <div class="text-right">
                                    {{ Form::hidden('from','pathwaybot') }}
                                    <button type="submit" class="btn btn-sm btn-primary rounded-pill">{{__('Save changes')}}</button>
                                </div>
                            </div>
                        </div>
                                 <hr>
                                 <div class="row">
                            <div class="col-6 py-2">
                                <h5 class="h5">{{__('Is the crime you were convicted of eligible for expungement?')}}</h5>
                            </div>

                            <div class="col-md-12">
                                <div class="form-group">
                                    {{ Form::label('', __('Yes'),['class' => 'form-control-label']) }}
                                    <input type="text" name="data[expungement_yes]" class="form-control" data-toggle ="tags"  placeholder="Enter bot speech text"  value="{{$path_settings['expungement_yes']??""}}" />

                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="form-group">
                                    {{ Form::label('', __('No'),['class' => 'form-control-label']) }}
                                    <input type="text" name="data[expungement_no]" class="form-control" data-toggle ="tags"  placeholder="Enter bot speech text"  value="{{$path_settings['expungement_no']??""}}" />

                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="form-group">
                                    {{ Form::label('', __('Unsure'),['class' => 'form-control-label']) }}
                                    <input type="text" name="data[expungement_Unsure]" class="form-control" data-toggle ="tags"  placeholder="Enter bot speech text"  value="{{$path_settings['expungement_Unsure']??""}}" />

                                </div>
                            </div>
                        </div>
                                 <hr>
                                 <div class="row">
                            <div class="col-6 py-2">
                                <h5 class="h5">{{__('Type')}}</h5>
                            </div>

                            <div class="col-md-12">
                                <div class="form-group">
                                    {{ Form::label('', __('Career'),['class' => 'form-control-label']) }}
                                    <input type="text" name="data[type_career]" class="form-control" data-toggle ="tags"  placeholder="Enter bot speech text"  value="{{$path_settings['type_career']??""}}" />

                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="form-group">
                                    {{ Form::label('', __('Business'),['class' => 'form-control-label']) }}
                                    <input type="text" name="data[type_business]" class="form-control" data-toggle ="tags"  placeholder="Enter bot speech text"  value="{{$path_settings['type_business']??""}}" />

                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="form-group">
                                    {{ Form::label('', __('Life'),['class' => 'form-control-label']) }}
                                    <input type="text" name="data[type_life]" class="form-control" data-toggle ="tags"  placeholder="Enter bot speech text"  value="{{$path_settings['type_life']??""}}" />

                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="form-group">
                                    {{ Form::label('', __('Family'),['class' => 'form-control-label']) }}
                                    <input type="text" name="data[type_family]" class="form-control" data-toggle ="tags"  placeholder="Enter bot speech text"  value="{{$path_settings['type_family']??""}}" />

                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="form-group">
                                    {{ Form::label('', __('Health'),['class' => 'form-control-label']) }}
                                    <input type="text" name="data[type_health]" class="form-control" data-toggle ="tags"  placeholder="Enter bot speech text"  value="{{$path_settings['type_health']??""}}" />

                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="form-group">
                                    {{ Form::label('', __('Relationship'),['class' => 'form-control-label']) }}
                                    <input type="text" name="data[type_relationship]" class="form-control" data-toggle ="tags"  placeholder="Enter bot speech text"  value="{{$path_settings['type_relationship']??""}}" />

                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="form-group">
                                    {{ Form::label('', __('Community'),['class' => 'form-control-label']) }}
                                    <input type="text" name="data[type_community]" class="form-control" data-toggle ="tags"  placeholder="Enter bot speech text"  value="{{$path_settings['type_community']??""}}" />

                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="form-group">
                                    {{ Form::label('', __('Finance'),['class' => 'form-control-label']) }}
                                    <input type="text" name="data[type_finance]" class="form-control" data-toggle ="tags"  placeholder="Enter bot speech text"  value="{{$path_settings['type_finance']??""}}" />

                                </div>
                            </div>
                        </div>
                                 <hr>
                        <div class="row">
                            <div class="col-12">
                                <div class="text-right">
                                    {{ Form::hidden('from','pathwaybot') }}
                                    <button type="submit" class="btn btn-sm btn-primary rounded-pill">{{__('Save changes')}}</button>
                                </div>
                            </div>
                        </div>
                                 <hr>
                                 <div class="row">
                            <div class="col-6 py-2">
                                <h5 class="h5">{{__('Would you like to schedule a series of reminders to keep you on track')}}</h5>
                            </div>

                            <div class="col-md-12">
                                <div class="form-group">
                                    {{ Form::label('', __('Yes'),['class' => 'form-control-label']) }}
                                    <input type="text" name="data[send_reminder_Yes]" class="form-control" data-toggle ="tags"  placeholder="Enter bot speech text"  value="{{$path_settings['send_reminder_Yes']??""}}" />

                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="form-group">
                                    {{ Form::label('', __('No'),['class' => 'form-control-label']) }}
                                    <input type="text" name="data[send_reminder_No]" class="form-control" data-toggle ="tags"  placeholder="Enter bot speech text"  value="{{$path_settings['send_reminder_No']??""}}" />

                                </div>
                            </div>
                        </div>
                                 <hr>
                                 <div class="row">
                            <div class="col-6 py-2">
                                <h5 class="h5">{{__('Reminder Type')}}</h5>
                            </div>

                            <div class="col-md-12">
                                <div class="form-group">
                                    {{ Form::label('', __('Daily'),['class' => 'form-control-label']) }}
                                    <input type="text" name="data[reminder_type_Daily]" class="form-control" data-toggle ="tags"  placeholder="Enter bot speech text"  value="{{$path_settings['reminder_type_Daily']??""}}" />

                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="form-group">
                                    {{ Form::label('', __('Weekly'),['class' => 'form-control-label']) }}
                                    <input type="text" name="data[reminder_type_Weekly]" class="form-control" data-toggle ="tags"  placeholder="Enter bot speech text"  value="{{$path_settings['reminder_type_Weekly']??""}}" />

                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="form-group">
                                    {{ Form::label('', __('Monthly'),['class' => 'form-control-label']) }}
                                    <input type="text" name="data[reminder_type_Monthly]" class="form-control" data-toggle ="tags"  placeholder="Enter bot speech text"  value="{{$path_settings['reminder_type_Monthly']??""}}" />

                                </div>
                            </div>
                        </div>
                                 <hr>
                        <div class="row">
                            <div class="col-12">
                                <div class="text-right">
                                    {{ Form::hidden('from','pathwaybot') }}
                                    <button type="submit" class="btn btn-sm btn-primary rounded-pill">{{__('Save changes')}}</button>
                                </div>
                            </div>
                        </div>

                            </div>
                        </div>
                    {{ Form::close() }}
                    </div>
                </div>
            </div>
            <div role="tabpanel" id="pathwaysettings" class="tab-pane fade show">


                <div class="row">
                    <div class="col-12">
                         {{ Form::open(['route' => ['site.settings.store'],'id' => 'update_setting']) }}
                                            @php
                                 $path_dollar_settings=\App\SiteSettings::getValByName('pathways_dollar_value');

                                 @endphp
                        <div class="card">
                            <div class="card-header">
                                <h4 class="card-title">Pathways Dollar Value Settings</h4>
                                <div class="col-12 text-right">
                                <div class="custom-control custom-switch">
                                    <input type="checkbox" class="custom-control-input" name="enable_pathway_dollar_value" id="enable_pathway_dollar_value" {{(!empty($path_dollar_settings['ENABLE_DOLLAR_VALUE']) && $path_dollar_settings['ENABLE_DOLLAR_VALUE'] == 'on') ? 'checked' : ''}}>
                                    <label class="custom-control-label form-control-label" for="enable_pathway_dollar_value">{{__('Enable Pathway Dollar Value')}}</label>
                                </div>
                            </div>
                            </div>
                            <div class="card-body">

                                 @csrf
                                 <hr>

                        <div class="row">
                            <div class="col-12 py-2">
                                <h5 class="h5">{{__('Questions With Dollar Value ($)')}}</h5>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    {{ Form::label('', __('I am a'),['class' => 'form-control-label']) }}
                                    <input type="number" min="0" step=".00001" name="data[mentor_type]" class="form-control"  placeholder="Dollar Value ($)"  value="{{$path_dollar_settings['mentor_type']??""}}" />

                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    {{ Form::label('', __('Level'),['class' => 'form-control-label']) }}
                                    <input type="number" min="0" step=".00001" name="data[level]" class="form-control"  placeholder="Dollar Value ($)"  value="{{$path_dollar_settings['level']??""}}" />

                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    {{ Form::label('', __('Were you honorably discharged?'),['class' => 'form-control-label']) }}
                                    <input type="number" min="0" step=".00001" name="data[discharged]" class="form-control"  placeholder="Dollar Value ($)"  value="{{$path_dollar_settings['discharged']??""}}" />

                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    {{ Form::label('', __('Branch'),['class' => 'form-control-label']) }}
                                    <input type="number" min="0" step=".00001" name="data[branch]" class="form-control"  placeholder="Dollar Value ($)"  value="{{$path_dollar_settings['branch']??""}}" />

                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    {{ Form::label('', __('College'),['class' => 'form-control-label']) }}
                                    <input type="number" min="0" step=".00001" name="data[college]" class="form-control"  placeholder="Dollar Value ($)"  value="{{$path_dollar_settings['college']??""}}" />

                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    {{ Form::label('', __('Grade Level'),['class' => 'form-control-label']) }}
                                    <input type="number" min="0" step=".00001" name="data[gradeLevel]" class="form-control"  placeholder="Dollar Value ($)"  value="{{$path_dollar_settings['gradeLevel']??""}}" />

                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    {{ Form::label('', __('What is the name of your Trade or Vocational School? '),['class' => 'form-control-label']) }}
                                    <input type="number" min="0" step=".00001" name="data[school]" class="form-control"  placeholder="Dollar Value ($)"  value="{{$path_dollar_settings['school']??""}}" />

                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    {{ Form::label('', __('Trade Category'),['class' => 'form-control-label']) }}
                                    <input type="number" min="0" step=".00001" name="data[trade_category]" class="form-control"  placeholder="Dollar Value ($)"  value="{{$path_dollar_settings['trade_category']??""}}" />

                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    {{ Form::label('', __('Employer'),['class' => 'form-control-label']) }}
                                    <input type="number" min="0" step=".00001" name="data[employee]" class="form-control"  placeholder="Dollar Value ($)"  value="{{$path_dollar_settings['employee']??""}}" />

                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    {{ Form::label('', __('Certification'),['class' => 'form-control-label']) }}
                                    <input type="number" min="0" step=".00001" name="data[catalog]" class="form-control"  placeholder="Dollar Value ($)"  value="{{$path_dollar_settings['catalog']??""}}" />

                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    {{ Form::label('', __('Do you have home wifi?'),['class' => 'form-control-label']) }}
                                    <input type="number" min="0" step=".00001" name="data[wifi]" class="form-control"  placeholder="Dollar Value ($)"  value="{{$path_dollar_settings['wifi']??""}}" />

                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    {{ Form::label('', __('Where is your closest library?'),['class' => 'form-control-label']) }}
                                    <input type="number" min="0" step=".00001" name="data[library]" class="form-control"  placeholder="Dollar Value ($)"  value="{{$path_dollar_settings['library']??""}}" />

                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    {{ Form::label('', __('Do you have a tablet or home PC?'),['class' => 'form-control-label']) }}
                                    <input type="number" min="0" step=".00001" name="data[home_pc]" class="form-control"  placeholder="Dollar Value ($)"  value="{{$path_dollar_settings['home_pc']??""}}" />

                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    {{ Form::label('', __('Which STEM Industry would you like to work in?'),['class' => 'form-control-label']) }}
                                    <input type="number" min="0" step=".00001" name="data[stem_industry]" class="form-control"  placeholder="Dollar Value ($)"  value="{{$path_dollar_settings['stem_industry']??""}}" />

                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    {{ Form::label('', __('Would you like to join one of the following science, arts, or reading clubs?'),['class' => 'form-control-label']) }}
                                    <input type="number" min="0" step=".00001" name="data[reading_club]" class="form-control"  placeholder="Dollar Value ($)"  value="{{$path_dollar_settings['reading_club']??""}}" />

                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    {{ Form::label('', __('Do you live in a PHA Community?'),['class' => 'form-control-label']) }}
                                    <input type="number" min="0" step=".00001" name="data[pha_community]" class="form-control"  placeholder="Dollar Value ($)"  value="{{$path_dollar_settings['pha_community']??""}}" />

                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    {{ Form::label('', __('Please select PHA Community'),['class' => 'form-control-label']) }}
                                    <input type="number" min="0" step=".00001" name="data[pha_community_id]" class="form-control"  placeholder="Dollar Value ($)"  value="{{$path_dollar_settings['pha_community_id']??""}}" />

                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    {{ Form::label('', __('What Year will you Graduate High School?'),['class' => 'form-control-label']) }}
                                    <input type="number" min="0" step=".00001" name="data[graduation_year]" class="form-control"  placeholder="Dollar Value ($)"  value="{{$path_dollar_settings['graduation_year']??""}}" />

                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    {{ Form::label('', __('Company'),['class' => 'form-control-label']) }}
                                    <input type="number" min="0" step=".00001" name="data[company]" class="form-control"  placeholder="Dollar Value ($)"  value="{{$path_dollar_settings['company']??""}}" />

                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    {{ Form::label('', __('Are you Tax Exempt? '),['class' => 'form-control-label']) }}
                                    <input type="number" min="0" step=".00001" name="data[tax_exempted]" class="form-control"  placeholder="Dollar Value ($)"  value="{{$path_dollar_settings['tax_exempted']??""}}" />

                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    {{ Form::label('', __('Upload tax certificate'),['class' => 'form-control-label']) }}
                                    <input type="number" min="0" step=".00001" name="data[tax_certificate]" class="form-control"  placeholder="Dollar Value ($)"  value="{{$path_dollar_settings['tax_certificate']??""}}" />

                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    {{ Form::label('', __('Have you been in business, 2 years or more?'),['class' => 'form-control-label']) }}
                                    <input type="number" min="0" step=".00001" name="data[business_year]" class="form-control"  placeholder="Dollar Value ($)"  value="{{$path_dollar_settings['business_year']??""}}" />

                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    {{ Form::label('', __('I am interested in  RFI, RFP,  Grant opportunities'),['class' => 'form-control-label']) }}
                                    <input type="number" min="0" step=".00001" name="data[grant_opportunity]" class="form-control"  placeholder="Dollar Value ($)"  value="{{$path_dollar_settings['grant_opportunity']??""}}" />

                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    {{ Form::label('', __('Who is the Mayor in your city or town?'),['class' => 'form-control-label']) }}
                                    <input type="number" min="0" step=".00001" name="data[mayor]" class="form-control"  placeholder="Dollar Value ($)"  value="{{$path_dollar_settings['mayor']??""}}" />

                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    {{ Form::label('', __('Military Base were you assigned to?'),['class' => 'form-control-label']) }}
                                    <input type="number" min="0" step=".00001" name="data[military_base]" class="form-control"  placeholder="Dollar Value ($)"  value="{{$path_dollar_settings['military_base']??""}}" />

                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    {{ Form::label('', __('Are you on Probation, Parole?'),['class' => 'form-control-label']) }}
                                    <input type="number" min="0" step=".00001" name="data[probation_parole]" class="form-control"  placeholder="Dollar Value ($)"  value="{{$path_dollar_settings['probation_parole']??""}}" />

                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    {{ Form::label('', __('Choose Officer'),['class' => 'form-control-label']) }}
                                    <input type="number" min="0" step=".00001" name="data[justice_officer]" class="form-control"  placeholder="Dollar Value ($)"  value="{{$path_dollar_settings['justice_officer']??""}}" />

                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    {{ Form::label('', __('Are your a registered sex offender?'),['class' => 'form-control-label']) }}
                                    <input type="number" min="0" step=".00001" name="data[sex_offender]" class="form-control"  placeholder="Dollar Value ($)"  value="{{$path_dollar_settings['sex_offender']??""}}" />

                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    {{ Form::label('', __('Is the crime you were convicted of eligible for expungement?'),['class' => 'form-control-label']) }}
                                    <input type="number" min="0" step=".00001" name="data[expungement]" class="form-control"  placeholder="Dollar Value ($)"  value="{{$path_dollar_settings['expungement']??""}}" />

                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    {{ Form::label('', __('Type'),['class' => 'form-control-label']) }}
                                    <input type="number" min="0" step=".00001" name="data[type]" class="form-control"  placeholder="Dollar Value ($)"  value="{{$path_dollar_settings['type']??""}}" />

                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    {{ Form::label('', __('Timeline'),['class' => 'form-control-label']) }}
                                    <input type="number" min="0" step=".00001" name="data[timeline]" class="form-control"  placeholder="Dollar Value ($)"  value="{{$path_dollar_settings['timeline']??""}}" />

                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    {{ Form::label('', __('Would you like to schedule a series of reminders to keep you on track'),['class' => 'form-control-label']) }}
                                    <input type="number" min="0" step=".00001" name="data[send_reminder]" class="form-control"  placeholder="Dollar Value ($)"  value="{{$path_dollar_settings['send_reminder']??""}}" />

                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    {{ Form::label('', __('Reminder Type'),['class' => 'form-control-label']) }}
                                    <input type="number" min="0" step=".00001" name="data[reminder_type]" class="form-control"  placeholder="Dollar Value ($)"  value="{{$path_dollar_settings['reminder_type']??""}}" />

                                </div>
                            </div>



                        </div>
                                 <hr>
                        <div class="row">
                            <div class="col-12">
                                <div class="text-right">
                                    {{ Form::hidden('from','pathwaysettings') }}
                                    <button type="submit" class="btn btn-sm btn-primary rounded-pill">{{__('Save changes')}}</button>
                                </div>
                            </div>
                        </div>


                            </div>
                        </div>
                    {{ Form::close() }}
                    </div>
                </div>
            </div>
            <!-- /Bot -->
			  <!-- Bot -->
            <div role="tabpanel" id="bot" class="tab-pane fade show">

                <!-- Page Header -->
                <div class="page-header">
                    <div class="row">
                        <div class="col-sm-12">
                            <h3 class="page-title">Bot Settings</h3>
                            <ul class="breadcrumb">
                                <li class="breadcrumb-item"><a href="{{route('dashboard')}}">Dashboard</a></li>
                                <li class="breadcrumb-item"><a href="javascript:(0)">Settings</a></li>
                                <li class="breadcrumb-item active">Bot Settings</li>
                            </ul>
                        </div>
                    </div>
                </div>
                <!-- /Page Header -->

                <div class="row">
                    <div class="col-12">
                        <div class="card">

                            <div class="card-body">
                            {{ Form::open(['route' => ['site.settings.store'], 'id' => 'update_setting', 'enctype' => 'multipart/form-data']) }}

                        <div class="row">
                            <div class="col-md-12" style="display: inline-flex;">


                                <div class="col-md-6">
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <div class="col-6 py-2" style="display: inline-flex; ">
                                                    <span class="form-control-label">Wikipedia</span>
                                                    <div class="custom-control custom-switch" style="margin-left: 12px;">
                                                        <input type="checkbox" class="custom-control-input" value="1" name="wiki_search" id="wiki_search" {{(isset($wiki_search->value) && $wiki_search->value == 1) ? 'checked' : ''}}>
                                                        <label class="custom-control-label form-control-label" for="wiki_search">{{__('Yes')}}</label>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                            </div>
                        </div>

                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    {{ Form::label('bot_name', __('Bot Name'),['class' => 'form-control-label']) }}
                                    {{ Form::text('bot_name', ($bot_name->value ?? ''), ['class' => 'form-control','required' => 'required']) }}
                                </div>
                            </div>

                            <div class="col-md-12">
                                <div class="form-group">
                                    {{ Form::label('speech_voice', __('Bot Voice'),['class' => 'form-control-label']) }}
                                   <select class="form-control" name="speech_voice" required>
                                    <option @if(!empty($speech_voice) && $speech_voice->value == 'en-US-JennyNeural') {{ 'selected' }} @endif value="en-US-JennyNeural">Jenny (Neural)</option>
                                    <option @if(!empty($speech_voice) && $speech_voice->value == 'en-US-GuyNeural') {{ 'selected' }} @endif value="en-US-GuyNeural">Guy (Neural)</option>
                                    <option @if(!empty($speech_voice) && $speech_voice->value == 'en-US-AriaNeural') {{ 'selected' }} @endif value="en-US-AriaNeural">Aria (Neural)</option>
                                    <option @if(!empty($speech_voice) && $speech_voice->value == 'en-US-AriaRUS') {{ 'selected' }} @endif value="en-US-AriaRUS">Aria</option>
                                    <option @if(!empty($speech_voice) && $speech_voice->value == 'en-US-BenjaminRUS') {{ 'selected' }} @endif value="en-US-BenjaminRUS">Benjamin</option>
                                    <option @if(!empty($speech_voice) && $speech_voice->value == 'en-US-GuyRUS') {{ 'selected' }} @endif value="en-US-GuyRUS">Guy</option>
                                    <option @if(!empty($speech_voice) && $speech_voice->value == 'en-US-ZiraRUS') {{ 'selected' }} @endif value="en-US-ZiraRUS">Zira</option>
                                   </select>
                                </div>
                            </div>

                            <div class="col-md-12">
                                <div class="form-group">
                                    {{ Form::label('bot_twilio_voice', __('Bot Twilio Voice'),['class' => 'form-control-label']) }}
                                    <select class="form-control" name="bot_twilio_voice" required>
                                    <option @if(isset($bot_twilio_voice->value) && $bot_twilio_voice->value == 'man') {{ 'selected' }} @endif value="man">Man</option>
                                    <option @if(isset($bot_twilio_voice->value) && $bot_twilio_voice->value == 'woman') {{ 'selected' }} @endif value="woman">Woman</option>
                                    <option @if(isset($bot_twilio_voice->value) && $bot_twilio_voice->value == 'alice') {{ 'selected' }} @endif value="alice">Alice</option>

                                   </select>
                                </div>
                            </div>


                            <div class="col-md-12">
                                <div class="form-group">
                                    {{ Form::label('robot_img', __('Default Image'),['class' => 'form-control-label']) }}
                                    @if(!empty($robot_img->value))
                                        <input type="file" name="robot_img" id="robot_img" class="custom-input-file croppie" default="{{asset('public')}}/img/{{ $robot_img->value }}" crop-width="326" crop-height="250"  accept="image/*">
                                    @else
                                        <input type="file" name="robot_img" id="robot_img" class="custom-input-file croppie" crop-width="326" crop-height="250"  accept="image/*" >
                                    @endif
                                    @error('robot_img')
                                    <span class="robot_img" role="alert">
                                        <small class="text-danger">{{ $message }}</small>
                                    </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-md-12">
                                <div class="form-group">
                                    {{ Form::label('default_answer', __('Default Answer'),['class' => 'form-control-label']) }}

                                    {{ Form::text('default_answer', ($default_answer->value ?? ''), ['class' => 'form-control','data-toggle' => 'tags','placeholder' => __('Type here...'),]) }}
                                </div>
                            </div>

                            <div class="col-md-12">
                                <div class="form-group">
                                    {{ Form::label('greetings', __('Greetings'),['class' => 'form-control-label']) }}

                                    {{ Form::text('greetings', ($greetings->value ?? ''), ['class' => 'form-control','data-toggle' => 'tags','placeholder' => __('Type here...'),]) }}
                                </div>
                            </div>

                            <div class="col-md-12">
                                <div class="form-group">
                                    {{ Form::label('wake_word', __('Wake Word'),['class' => 'form-control-label']) }}
                                    {{ Form::text('wake_word', ($wake_word->value ?? ''), ['class' => 'form-control','required' => 'required']) }}
                                </div>
                            </div>


                            <hr/>
                            <div class="text-right">
                                {{ Form::hidden('from','bot') }}
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
            <!-- /Bot -->



			<!-- Speech -->
            <div role="tabpanel" id="speech" class="tab-pane fade show">

                <!-- Page Header -->
                <div class="page-header">
                    <div class="row">
                        <div class="col-sm-12">
                            <h3 class="page-title">Speech Settings</h3>
                            <ul class="breadcrumb">
                                <li class="breadcrumb-item"><a href="{{route('dashboard')}}">Dashboard</a></li>
                                <li class="breadcrumb-item"><a href="javascript:(0)">Settings</a></li>
                                <li class="breadcrumb-item active">Speech Settings</li>
                            </ul>
                        </div>
                    </div>
                </div>
                <!-- /Page Header -->

                <div class="row">
                    <div class="col-12">
                        <div class="card">

                            <div class="card-body">
                           {{ Form::open(['route' => ['site.settings.store'],'id' => 'update_setting']) }}

                        {{-- <p style="color: red;">Note : Your free credit expires in {{ $speech_key_expiration_date }}</p> --}}
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    {{ Form::label('speech_key', __('Speech Key'),['class' => 'form-control-label']) }}
                                     <input name="speech_key" value="{{$speech_key->value??''}}"   id="password-field6" type="password" class="form-control" >
              <span toggle="#password-field6" class="fa fa-fw fa-eye field-icon toggle-password"></span>
                                </div>
                            </div>

                            <div class="col-md-12">
                                <div class="form-group">
                                    {{ Form::label('speech_region', __('Speech Region (e.g. westus/eastus)'),['class' => 'form-control-label']) }}
                                    {{ Form::text('speech_region', ($speech_region->value ?? ''), ['class' => 'form-control','required' => 'required']) }}
                                </div>
                            </div>

                            <div class="text-right">
                                {{ Form::hidden('from','bingspeech') }}
                                <button  type="submit" class="btn btn-sm btn-primary rounded-pill">{{__('Save changes')}}</button>
                            </div>

                        </div>
                        {{ Form::close() }}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- /Speech -->


				<!-- Wikipedia Setting -->
            <div role="tabpanel" id="wikipedia" class="tab-pane fade show">

                <!-- Page Header -->
                <div class="page-header">
                    <div class="row">
                        <div class="col-sm-12">
                            <h3 class="page-title">Wikipedia Settings</h3>
                            <ul class="breadcrumb">
                                <li class="breadcrumb-item"><a href="{{route('dashboard')}}">Dashboard</a></li>
                                <li class="breadcrumb-item"><a href="javascript:(0)">Settings</a></li>
                                <li class="breadcrumb-item active">Wikipedia Settings</li>
                            </ul>
                        </div>
                    </div>
                </div>
                <!-- /Page Header -->

                <div class="row">
                    <div class="col-12">
                        <div class="card">

                            <div class="card-body">
                           {{ Form::open(['route' => ['site.settings.store'],'id' => 'update_setting']) }}
                        {{-- <p style="color: rgb(180, 132, 132);">Note : Your free credit expires in {{ $wiki_key_expiration_date }}</p> --}}

                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    {{ Form::label('wiki_key', __('Wikipedia Key'),['class' => 'form-control-label']) }}
                                    <input name="wiki_key" value="{{$wiki_key->value??''}}" required  id="password-field7" type="password" class="form-control" >
              <span toggle="#password-field7" class="fa fa-fw fa-eye field-icon toggle-password"></span>
                                </div>
                            </div>

                            <div class="text-right">
                                {{ Form::hidden('from','bingwiki') }}
                                <button  type="submit" class="btn btn-sm btn-primary rounded-pill">{{__('Save changes')}}</button>
                            </div>
                        </div>
                        {{ Form::close() }}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- /Wikipedia Setting -->
        </div>
        <!-- /Tab Content -->

    </div>
</div>

 <div id="stripeModal" class="modal fade" role="dialog">
        <div class="modal-dialog">
            <!-- Modal content-->
            <div class="modal-content">
                <div class="modal-body">
                    <h5 class="modal-title text-center">Connect Stripe!</h5>
                    <div class="pop-up">
                        <i class="fas fa-exclamation-triangle text-danger"></i>
                    </div>
                    <p class="text-center stripe-text">Please connect your Stripe account to Enable commission.</p>
                    <br>
                    <div class="syndicate_button text-center">
                        <a href="javascript:void(0);" id="stripeUrl">
                            <button type="button" class="btn btn-sm btn-primary ">OKAY</button>
                        </a>
                    </div>
                </div>
                <div class="">
                </div>
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
<!-- /Page Wrapper -->
@endsection
@push('script')

   <link rel="stylesheet" type="text/css" href="{{ asset('assets/css/simcify.min.css') }}">
<link rel="stylesheet" type="text/css" href="{{ asset('assets/libs/dropify/css/dropify.min.css') }}">



    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-tagsinput/0.8.0/bootstrap-tagsinput.css">




<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-tagsinput/0.8.0/bootstrap-tagsinput.min.js"></script>

<script src="https://trymyceo.com/assets/libs/bootstrap-tagsinput/dist/bootstrap-tagsinput.min.js"></script>

<script src="https://trymyceo.com/assets/js/site.js"></script>


<script src="{{ asset('assets/js/simcify.min.js') }}"></script>
<script src="{{ asset('assets/libs/dropify/js/dropify.min.js') }}"></script>

   <script type="text/javascript">
      $(document).on("keydown", '.default_answer', function (e) {
            if (e.keyCode == 188 || e.keyCode == 110) { // KeyCode For comma is 188
                e.preventDefault();
            }
        }).on('change input', function() {
            var self = $(this);
            self.html( self.html().replace(new RegExp(',', 'g'),'') ); // Remove all commas.
        });

        // For Sidebar Tabs
        $(document).ready(function () {
            $('input[name=default_answer]').tagsinput();

            var i =0;
            $(".add-btn").click(function(){
                i++;
                $('#dynamic_field').append(' <div class="row" id="row'+i+'"><div class="col-md-10"><div class="form-group"><label for="default_answer" class="form-control-label">Default Answer</label><input class="form-control default_answer" required="required" name="default_answer[]" type="text" ></div></div><div class="col-md-2"> <button data-toggle="tooltip" title="Remove" type="button" id="'+i+'" class="btn btn-danger remove-default-btn"><i class="fas fa-trash"></i></button>  </div></div>');
            });


            $(document).on('click', '.remove-default-btn', function(){
                var button_id = $(this).attr("id");
                $('#row'+button_id+'').remove();
            });


            $('.list-group-item').on('click', function () {
                var href = $(this).attr('data-href');
                $('.tabs-card').addClass('d-none');
                $(href).removeClass('d-none');
                $('#tabs .list-group-item').removeClass('text-primary');
                $(this).addClass('text-primary');
            });
        });


    // For Test Email Send
        $(document).on("click", '.send_email', function (e) {
            e.preventDefault();
            var title = $(this).attr('data-title');
            var size = 'md';
            var url = $(this).attr('data-url');
            if (typeof url != 'undefined') {
                $("#commonModal .modal-title").html(title);
                $("#commonModal .modal-dialog").addClass('modal-' + size);
                $("#commonModal").modal('show');
                $.post(url, {
                    mail_driver: $("#mail_driver").val(),
                    mail_host: $("#mail_host").val(),
                    mail_port: $("#mail_port").val(),
                    mail_username: $("#mail_username").val(),
                    mail_from_address: $("#mail_from_address").val(),
                    mail_from_name: $("#mail_from_name").val(),
                    mail_password: $("#mail_password").val(),
                    mail_encryption: $("#mail_encryption").val(),
                    "_token": "{{ csrf_token() }}",
                }, function (data) {
                    $('#commonModal .modal-body').html(data);
                });
            }
        });
        $(document).on('submit', '#test_email', function (e) {
            e.preventDefault();
            $("#email_sanding").show();
            var post = $(this).serialize();
            var url = $(this).attr('action');
            $.ajax({
                type: "post",
                url: url,
                data: post,
                cache: false,
                success: function (data) {
                    if (data.is_success) {
                        show_toastr('Success', data.message, 'success');
                    } else {
                        show_toastr('Error', data.message, 'error');
                    }
                    $("#email_sanding").hide();
                }
            });
        });
    </script>
    <script>

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


$(document).ready(function () {
    $('.list-group-item').on('click', function () {
        var href = $(this).attr('data-href');
        $('.tabs-card').addClass('d-none');
        $(href).removeClass('d-none');
        $('#tabs .list-group-item').removeClass('text-primary');
        $(this).addClass('text-primary');
    });
});
$.fn.extend({
    treed: function (o) {

      var openedClass = 'fa-plus';
      var closedClass = 'fa-minus';

      if (typeof o != 'undefined'){
        if (typeof o.openedClass != 'undefined'){
        openedClass = o.openedClass;
        }
        if (typeof o.closedClass != 'undefined'){
        closedClass = o.closedClass;
        }
      };

        /* initialize each of the top levels */
        var tree = $(this);
        tree.addClass("tree");
        tree.find('li').has("ul").each(function () {
            var branch = $(this);
            branch.prepend("");
            branch.addClass('branch');
            branch.on('click', function (e) {
                if (this == e.target) {
                    var icon = $(this).children('.spantag>i:first');
                    icon.toggleClass(openedClass + " " + closedClass);
                   //$(this).children().children().toggle();
                 }
            })
            //branch.children().children().toggle();
        });

    }
});
/* Initialization of treeviews */
$('#tree1').treed();




	    $(document).on("change", ".customSwitchesSyndicate", function () {
            if ($(this).find('.Oncommission').is(':checked')) {
                var id = $(this).find('.Oncommission').val();
                $.ajax({
                    url: "{{url('')}}/certify/syndicate/stripe?certifyId=" + id,
                    success: function (data) {
                        if (data.dataType == 'stripe') {
                            $("#stripeUrl").attr('href', '');
                            $("#stripeUrl").attr('href', data.data);
                            $('#stripeModal').modal('show');
                        } else if (data.dataType == 'data') {
                            show_toastr('Success', '{{__('certify syndicated successfully.')}}', 'success');
                        }
                    }
                });
            }
        });
</script>
<script type="text/javascript">

var t = false

$('#admin_com').focus(function () {

var $this = $(this)



t = setInterval(

function () {
    if (($this.val() < 1 || $this.val() > 100) && $this.val().length != 0) {
        if ($this.val() < 1) {
            $this.val(1)
        }

        if ($this.val() > 100) {
            $this.val(100)
        }

    }
}, 50)
})
$('#admin_pro').focus(function () {

var $this = $(this)



t = setInterval(

function () {
    if (($this.val() < 1 || $this.val() > 100) && $this.val().length != 0) {
        if ($this.val() < 1) {
            $this.val(1)
        }

        if ($this.val() > 100) {
            $this.val(100)
        }

    }
}, 50)
})
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
  margin-top: -31px;
  position: relative;
  z-index: 2;
}
      </style>
@endpush
