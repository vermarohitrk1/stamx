@extends('layout.mainlayout')
@section('content')	
<!-- Page Content -->
<div class="bg-pattern-style">
    <div class="content">

        <!-- Login Tab Content -->
        <div class="account-content">
            <div class="account-box">
                <div class="login-right">
                    <div class="login-header">
                        <h3>Enter <span>Verification code</span></h3>
                        <p class="text-muted">Access to our dashboard</p>
                    </div>
                    <form method="POST" action="{{ url('/signup/auth_code/verify') }}">
                          @csrf
                            <div class="form-group">
                                <label class="form-control-label">{{__('verification code sent to your mobile number.')}}</label>
                                <div class="input-group input-group-merge">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text"><i class="fas fa-key"></i></span>
                                    </div>
                                    <input id="code" type="text" class="form-control" name="code" value="{{ old('code') }}" placeholder='Enter 4-Digit Code' required autofocus>
                                    @if ($errors->has('code'))
                                        <span class="help-block">
                                        <strong>{{ $errors->first('code') }}</strong>
                                    </span>
                                    @endif
                                    </div>
                                </div>

                            <div class="form-group">
                                <div class="col-md-8 col-md-offset-4">
                                    <button type="submit" class="btn btn-primary">
                                        Submit
                                    </button>
                                </div>
                            </div>
                        
                    </form>
                </div>
            </div>
        </div>
        <!-- /Login Tab Content -->

    </div>

</div>		
<!-- /Page Content -->	
@endsection