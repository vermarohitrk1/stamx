@extends('layout.mainlayout')
@section('content')		
<!-- Page Content -->
<div class="bg-pattern-style">
    <div class="content">

        <!-- Account Content -->
        <div class="account-content">
            <div class="account-box">
                <div class="login-right">
                    <div class="login-header">
                        <h3>Verify OTP</h3>
                        <p class="text-muted">Enter OTP to account verification.</p>
                        @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif
                    </div>

                    <!-- Forgot Password Form -->
                      <form method="post" action="{{ route('password.reset_byotp') }}">
                        @csrf
                        <div class="form-group">
                            <label class="form-control-label">Enter OTP</label>
                            <input id="otp" type="text" class="form-control @error('otp') is-invalid @enderror" name="code" value="{{ old('otp') }}" required>

                                @error('otp')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                        </div>
                        <div class="text-right">
                            <a class="forgot-link" href="{{route('login')}}">Remember your password?</a>
                        </div>
                        <button class="btn btn-primary login-btn" type="submit">Verify</button>
                        <!-- <p>{{ __('Send Password Reset Link') }}</p> -->
                    </form>
                    <!-- /Forgot Password Form -->

                </div>
            </div>
        </div>
        <!-- /Account Content -->
    </div>
</div>		
<!-- /Page Content -->
@endsection