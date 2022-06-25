<!DOCTYPE html>
<html lang="en">
  <head>
    @include('layout.partials.head')
     @stack('css')
  </head>
  @if(Route::is(['map-grid']))
  <body class="map-page">
  @endif
  @if(Route::is(['mentor-register','login','register','mentee-register','forgot-password','reset']))
  <body class="account-page">
  @endif
  @if(Route::is(['chat-mentee','chat']))
  <body class="chat-page">
  @endif
  @if(Route::is(['voice-call','video-call']))
  <body class="call-page">
  @endif
  @if(!Route::is(['login','register','forgot-password']))
  {{-- @include('layout.partials.header') --}}
@endif
@yield('content')
@if(!Route::is(['chat','chat-mentee','voice-call','video-call','login','register','forgot-password']))
{{-- @include('layout.partials.footer') --}}
@endif
@include('layout.partials.footer-scripts')
 @stack('script')
{{--Common Modal--}}
    <div class="modal fade" aria-hidden="true" role="dialog" id="commonModal" style="padding-right: 0px !important; ">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content" style="margin-top: inherit !important;">
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

<div class="modal fade" id="destroyCancelPlan" role="dialog" style="display: none;" aria-hidden="true">
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
<!-- Delete Model -->
  </body>
</html>