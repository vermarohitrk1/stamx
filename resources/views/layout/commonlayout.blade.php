<!DOCTYPE html>
<html lang="en">
  <head>
    @include('layout.common.head')
     @stack('css')
  </head>
  @if(Route::is(['map-grid']))
  <body class="map-page">
  @endif
  @if(Route::is(['mentor-register','login','register','mentee-register']))
  <body class="account-page">
  @endif
  @if(Route::is(['chat-mentee','chat']))
  <body class="chat-page">
  @endif
  @if(Route::is(['voice-call','video-call']))
  <body class="call-page">
  @endif

  @if(!Route::is(['login','register','forgot-password']))
@include('layout.common.header')
@endif
@yield('content')
@if(!Route::is(['chat','chat-mentee','voice-call','video-call','login','register','forgot-password']))
  @if(!Request::is('program') && !Request::is('program/details*') && !Route::is(['petitionshared.form']))
 @include('layout.partials.footer_dashboard')
@endif

 @if(Request::is('program/details*'))
 @include('layout.partials.footer_dashboard')
@endif

@endif
@include('layout.common.footer-scripts')
 @stack('script')
{{--Common Modal--}}
    <div class="modal fade" aria-hidden="true" role="dialog" id="commonModal">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title"></h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body"></div>
            </div>
        </div>
    </div>
    {{--End Common Modal--}}
    <!-- Delete Model -->
<div class="modal fade" id="common_delete_model" role="dialog" style="display: none;" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-body">
                <div class="form-content p-2 text-center">
                    <h4 class="modal-title">Delete</h4>
                    <p class="mb-4">Are you sure want to delete?</p>
                    <form id="common_delete_form" enctype="multipart/form-data">     
                        <div class="form-group btn-group text-center">
                        <button type="submit" class="btn btn-danger  form-control">Delete </button>
                    <button type="button" class="btn btn-primary form-control" data-dismiss="modal">Close</button>
                        </div>
                    </form>
                    
                </div>
            </div>
        </div>
    </div>
</div>

<!-- register modal -->
<div id="registerClientModal" class="modal fade" role="dialog">
    <div class="modal-dialog">

        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <h3 class="modal_title_cl text-center">Create an account!
                    Enter your information below to Access our dashboard.</h3>
                       
					     <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
            </div>
			 <form method="POST" action="{{route('register.client')}}" id="registerClient">
                        @csrf
            <div class="modal-body">
             
				
				 
                        <div class="form-group">
                            <label class="form-control-label">Name</label>
                             <input id="name" type="text" class="form-control @error('name') is-invalid @enderror" name="name" value="{{ old('name') }}" required autocomplete="name" autofocus>

                                @error('name')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                        </div>
                        <div class="form-group">
                            <label class="form-control-label">Email Address</label>
                            <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email">

                                @error('email')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                        </div>
                        
                        <div class="row">
                            <div class="col-lg-6 pl-0 pr-1">
                                <div class="form-group">
                                    <label class="form-control-label">Password</label>
                                     <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="new-password">

                                @error('password')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                                </div>
                            </div>
                            <div class="col-lg-6 pr-0 pl-1">
                                <div class="form-group">
                                    <label class="form-control-label">Confirm Password</label>
                                    <input id="password-confirm" type="password" class="form-control" name="password_confirmation">
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                         
                           
						      <input type="hidden" name="userType" value="mentee">
                         

                        </div>
                    
                    
                   
				
            </div>
            <div class="modal-footer">
			 <button type="submit" class="btn btn-primary ">Register</button>
                <!-- <button type="button" class="btn btn-default" data-dismiss="modal">Close</button> -->
            </div>
			 </form>
        </div>

    </div>
</div>


<link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">
 <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
<script>
        @if (Session::has('message'))
    var type = "{{ Session::get('alert-type', 'info') }}";
    switch (type) {
        case 'info':
            toastr.info("{{ Session::get('message') }}");
            break;

        case 'warning':
            toastr.warning("{{ Session::get('message') }}");
            break;

        case 'success':
            toastr.success("{{ Session::get('message') }}");
            break;

        case 'error':
            toastr.error("{{ Session::get('message') }}");
            break;
    }
    @endif
</script>
<!-- Delete Model -->
  </body>
</html>