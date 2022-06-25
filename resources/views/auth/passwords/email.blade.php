@extends('layout.mainlayout')
@section('content')		
<!-- Page Content -->
<div class="bg-pattern-style">
    <div class="content">

        <!-- Account Content -->
        <div class="account-content">
            <div class="account-box">
                <div id='data-holder' class="login-right">
                    <div class="login-header">
                        <h3>Forgot Password?</h3> <a href="{{ route('login') }}" id="back" class="btn btn-sm btn-primary float-right ml-2">
        <span class="btn-inner--icon"><i class="fas fa-reply"></i></span>
    </a>
                        <p class="text-muted">Enter your email to get a password reset link</p>
                        @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif
                    </div>

                    <!-- Forgot Password Form -->
                      <form method="POST" id='verify_email' action="{{ route('password.email') }}">
                        @csrf
                        
                        <div class="form-group">
                            <label class="form-control-label">Email Address</label>
                            <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email" autofocus>

                                @error('email')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                        </div>
                        <div class="text-right">
                            <a class="forgot-link" href="{{route('login')}}">Remember your password?</a>
                        </div>
                        <button class="btn btn-primary login-btn" type="submit">Confirm</button>
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
@push('script')
<script>
      $(document).on("submit","#verify_email",function(e) {
    e.preventDefault();
    var action = $(this).attr('action');
    var data = $(this).serialize();
           $.ajax({
               type: 'post',
          url: action,
          data: data,
          success: function (data) {
        $('#data-holder').html(data);
               
          },error: function (data) {
                    data = data.responseJSON;
                    show_toastr("Error:", data.errors.email, "error");
                },
            });
            
            });

</script>
@endpush