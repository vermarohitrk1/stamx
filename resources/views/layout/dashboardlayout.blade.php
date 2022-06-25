<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    
<script src="https://media.twiliocdn.com/sdk/js/video/v1/twilio-video.min.js"></script>

    <head>
        @include('layout.partials.head_dashboard') 
        @stack('css')

        <style>
            div#myChat,div#myMentorChat {
                overflow-y: hidden;
            }

            div#myChat input#userMessage, div#myMentorChat input#mentorMessage  {
                background: #e6ebf5 !important;
                height: calc(1.5em + 1rem + 6px);
                padding: .5rem 1rem;
                font-size: .875rem;
                line-height: 1.5;
                border-radius: .4rem;
                width: 70%;
            }
            #myChat .modal-content, #myMentorChat .modal-content {
                background-color: #f5f7fb !important;
            }
            div#myChat input#userMessage, div#myMentorChat input#mentorMessage {
                background: #e6ebf5 !important;
            }
        </style>
    </head>

    @if(Route::is(['chat-mentee','chat']))
    <body class="chat-page">
        @endif
        @if(Route::is(['voice-call','video-call']))
    <body class="call-page">
        @endif
        <div id="video_call_div">
        		
        </div>		

        @if(Request::is('chat') || Request::is('agora-chat'))  
        @else
        <div id="videochatstatus">

        </div>
        @endif

        @include('layout.partials.header_dashboard')

        @yield('content')
        @if(!Route::is(['chat','chat-mentee','voice-call','video-call','login','register','forgot-password']))
        @include('layout.partials.footer_dashboard')
        @endif
        @include('layout.partials.footer-dashboard-scripts')
        @stack('theme-cdn')
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
//    Pusher.logToConsole = true;

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
        <!-- Delete Model -->
        <div class="modal fade" id="common_confirm_model" role="dialog" style="display: none;" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content">
                    <div class="modal-body">
                        <div class="form-content p-2 text-center">
                            <h4 class="modal-title">Confirm</h4>
                            <p class="mb-4">Are you sure want to take this action?</p>
                            <form id="common_confirm_form" enctype="multipart/form-data">     
                                <div class="form-group btn-group text-center">
                                    <button type="submit" class="btn btn-danger  form-control">Confirm </button>
                                    <button type="button" class="btn btn-primary form-control" data-dismiss="modal">Close</button>
                                </div>
                            </form>

                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- Delete Model -->
        <!-- Confirm Model -->
        <div class="modal fade" id="destroyCancelPlan" role="dialog" style="display: none;" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content">
                    <div class="modal-body">
                        <div class="form-content p-2 text-center">
                            <h4 class="modal-title">Confirm</h4>
                            <p class="mb-4">Are you sure want to cancel plan?</p>
                            <form id="CancelPlan" enctype="multipart/form-data">     
                                <div class="form-group btn-group text-center">
                                    <button type="submit" class="btn btn-danger  form-control">Confirm</button>
                                    <button type="button" class="btn btn-primary form-control" data-dismiss="modal">Close</button>
                                </div>
                            </form>

                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- Confirm Model -->
        <!-- upload employer -->
        <div id="import_divEmployer" class="modal fade" role="dialog">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title">Add CSV</h4>
                    </div>
                    {{ Form::open(['url' => 'admin/employer/import_csv','enctype' => 'multipart/form-data']) }}
                    <div class="modal-body">
                        <div class="form-group">
                            Choose your file<br>
                            <input type="file" name="csv_file" accept=".xls,.xlsx,.csv">
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Upload</button>
                    </div>
                    {{ Form::close() }}
                </div>
            </div>
        </div>
        <!-- upload institution -->
        <div id="import_divInstitute" class="modal fade" role="dialog">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title">Add CSV</h4>
                    </div>
                    {{ Form::open(['url' => 'admin/institutions/import_csv','enctype' => 'multipart/form-data']) }}
                    <div class="modal-body">
                        <div class="form-group">
                            Choose your file<br>
                            <input type="file" name="csv_file" accept=".xls,.xlsx,.csv">
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Upload</button>
                    </div>
                    {{ Form::close() }}
                </div>
            </div>
        </div>
        <!-- upload quotes -->
        <div id="import_div1" class="modal fade" role="dialog">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title">Add CSV</h4>
                    </div>
                    {{ Form::open(['url' => 'admin/quotes/import_csv','enctype' => 'multipart/form-data']) }}
                    <div class="modal-body">
                        <div class="form-group">
                            Choose your file<br>
                            <input type="file" name="csv_file" accept=".xls,.xlsx,.csv">
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Upload</button>
                    </div>
                    {{ Form::close() }}
                </div>
            </div>
        </div>
        <!-- upload audit -->
        <div id="import_divaudit" class="modal fade" role="dialog">
            <div class="modal-dialog">

                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title">Add CSV</h4>
                    </div>
                    {{ Form::open(['url' => 'audit/import_csv','enctype' => 'multipart/form-data']) }}
                    <div class="modal-body">
                        <input type="hidden" name="id" value="" id="programIds">
                        <div class="form-group">
                            Choose your file<br>
                            <input type="file" name="csv_file" accept=".xls,.xlsx,.csv">
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Upload</button>
                    </div>
                    {{ Form::close() }}
                </div>
            </div>
        </div>

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