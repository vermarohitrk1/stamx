

<div class="login-header">
                        <h3>Send OTP</h3>
                        <p class="text-muted">Select any method to recieve otp.</p>
                        @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif
                    </div>

                    <!-- Forgot Password Form -->
                    <form method="post" action="{{ route('password.sendotp') }}">
                        @csrf
                        <input type="hidden" name="email" value="{{ $user->email }}">
                        </br>
                        <div class="form-check">
                        <input class="form-check-input" type="radio" value='email' name="type" id="email" checked>
                        <label class="form-check-label" for="email">
                        <span>Email: {{$user->email}}</span>
                        </label>
</div>
                        <div class="form-check">
                        <input class="form-check-input" type="radio" name="type" value='mobile' id="mobile">
                        <label class="form-check-label" for="mobile">
                        <span>SMS: {{ substr($user->mobile, 0, 3) . "****" . substr($user->mobile, 7, 3)}}</span>
                        </label></div>
                        <div class="text-right">
                            <a class="forgot-link" href="{{route('login')}}">Remember your password?</a>
                        </div>
                        <button class="btn btn-primary login-btn" type="submit">Send OTP</button>
                        <!-- <p>{{ __('Send Password Reset Link') }}</p> -->
                    </form>
                    <!-- /Forgot Password Form -->