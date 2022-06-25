<!DOCTYPE html>
<html lang="en">
<script src="https://media.twiliocdn.com/sdk/js/video/v1/twilio-video.min.js"></script>
  <div id="video_call_div">
        		
        </div>
  <head>
    @include('layout.partials.head_admin')
    @stack('css')
  </head>
  @if(Route::is(['error-404','error-500']))
  <body class="error-page">
  @endif
  <body>
 	
  @if(!Route::is(['login','register','forgot-password','lock-screen','error-404','error-500']))
  @include('layout.partials.header_admin')
 @include('layout.partials.nav_admin')
 @endif
 @yield('content')
 @include('layout.partials.footer_admin-scripts')
 
 @stack('script')
  <script src="https://js.pusher.com/7.0/pusher.min.js"></script>
        <script>
function placeVideoCall(user,caller,type='') { 
    $("#videocalllingoptions").hide();
    $.post(
            "{{route('place.video.call')}}",
            {
    user: user,caller:caller,type:type, _token: "{{ csrf_token() }}",
    },
            function (data) {
            $("#video_call_div").html(data);
            }
    );
    }
function cancelVideoCall() { 
    $("#videocalllingoptions").hide();    
    }
 // Enable pusher logging - don't include this in production
    Pusher.logToConsole = true;
    var pusher = new Pusher('{{env("PUSHER_APP_KEY")}}', {
      cluster: 'ap2'
    });
    var channel = pusher.subscribe('my-channel');
    channel.bind('my-event', function(data) {
//        alert(JSON.stringify(data));
        if(data.data.room=='videoRoomNo{{Auth::user()->id}}'){
            $("#videocalllingoptions").show();
            $("#incomingcaller_id").html(data.data.caller);
            $("#callplacebtn").attr('onClick','placeVideoCall({{Auth::user()->id}},'+data.data.caller_id+',"rec")');
        }        
    
    });
</script>
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
<!-- Delete Model -->

 <div id="videocalllingoptions" class="container my-5" style=" margin: unset;
             padding: unset;
             margin-top: 0px !important;
             margin-bottom: 0px !important;
             padding: 0px !important;display: none">

            <!-- Incoming Call  -->
            <div class="row my-5"  style="    position: fixed;
                 top: 33%;
                 left: 50%;
                 -webkit-transform: translate(-50%, -50%);
                 transform: translate(-50%, -50%);
                 z-index: 99999 !important;">


                <div class="col-md-12  dash-board-list yellow">
                    <div class="dash-widget">
                        <div class="col-12 centered align-content-center">
                            <p>
                                Incoming Call From <strong id="incomingcaller_id">...</strong>
                            </p>
                            <div class="btn-group mt-2" role="group">
                                <button
                                    type="button"
                                    class="btn btn-danger"
                                    data-dismiss="modal"
                                    onclick="cancelVideoCall()"
                                    >
                                    Decline
                                </button>
                                <button
                                    type="button"
                                    class="btn btn-success ml-5"
                                    id="callplacebtn"
                                    >
                                    Accept
                                </button>

                            </div>
                        </div>
                    </div>
                </div>

            </div>
            <!-- End of Incoming Call  -->
        </div>
  </body>
</html>
