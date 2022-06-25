 <!--<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.0/jquery.min.js"></script>-->

<!--<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>-->
<!--<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"></script>-->

<!-- jQuery -->
<script src="{{ asset('assets/js/jquery.min.js') }}"></script>
<script type="text/javascript" src="{{ asset('assets/main/js/slick.min.js')}}"></script>
<script type="text/javascript" src="{{ asset('assets/main/js/custom_script.js')}}"></script>
<!-- Bootstrap Core JS -->
<script src="{{ asset('assets/js/popper.min.js') }}"></script>
<script src="{{ asset('assets/js/bootstrap.min.js') }}"></script>
<!-- Select2 JS -->
<script src="{{ asset('assets/plugins/select2/js/select2.min.js') }}"></script>
<!-- Datetimepicker JS -->
<script src="{{ asset('assets/js/moment.min.js') }}"></script>
<script src="{{ asset('assets/js/bootstrap-datetimepicker.min.js') }}"></script>
<script src="{{ asset('assets/plugins/daterangepicker/daterangepicker.js') }}"></script>
<!-- Owl Carousel -->
<script src="{{ asset('assets/js/owl.carousel.min.js') }}"></script>		
<!-- Sticky Sidebar JS -->
<script src="{{ asset('assets/plugins/theia-sticky-sidebar/ResizeSensor.js') }}"></script>
<script src="{{ asset('assets/plugins/theia-sticky-sidebar/theia-sticky-sidebar.js') }}"></script>
<!-- Circle Progress JS -->
<!-- <script src="{{ asset('assets/js/circle-progress.min.js') }}"></script> -->
<!-- Datatables JS -->
<script src="{{ asset('public/assets_admin/plugins/datatables/jquery.dataTables.min.js') }}"></script>
<script src="{{ asset('public/assets_admin/plugins/datatables/datatables.min.js') }}"></script>
<!-- Custom JS -->
<script src="{{ asset('assets/js/script.js') }}"></script>
@if(Route::is(['map-grid','map-list']))
<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyD6adZVdzTvBpE2yBRK8cDfsss8QXChK0I"></script>
<script src="{{ asset('assets/js/map.js') }}"></script>
@endif


<!--toastr for notification-->
<script src="{{ asset('assets/libs/bootstrap-notify/bootstrap-notify.min.js') }}"></script>

<script>
// Common Modal
$(document).on(
        "click",
        'a[data-ajax-popup="true"], button[data-ajax-popup="true"], div[data-ajax-popup="true"], span[data-ajax-popup="true"]',
        function (e) {
            var title = $(this).data("title");
            var size = $(this).data("size") == "" ? "md" : $(this).data("size");
            var url = $(this).data("url");

            $("#commonModal .modal-title").html(title);
            $("#commonModal .modal-dialog").addClass("modal-" + size);

            $.ajax({
                url: url,
                cache: false,
                success: function (data) {
                    $("#commonModal .modal-body").html(data);
                    $("#commonModal").modal("show");
//                commonLoader();
                },
                error: function (data) {
                    data = data.responseJSON;
                    show_toastr("Error", data.error, "error");
                },
            });
            e.stopImmediatePropagation();
            return false;
        }
);

function show_toastr(title, message, type) {
    var o, i;
    var icon = "";
    var cls = "";

    if (type == "success") {
        icon = "fas fa-check-circle";
        cls = "success";
    } else {
        icon = "fas fa-times-circle";
        cls = "danger";
    }

    $.notify(
            {icon: icon, title: " " + title, message: message, url: ""},
            {
                element: "body",
                type: cls,
                allow_dismiss: !0,
                showProgressbar: false,
                animate: {
                    enter: 'animated fadeInDown',
                    exit: 'animated fadeOutUp'
                },
                placement: {from: "top", align: "right"},
                offset: {x: 15, y: 15},
                spacing: 10,
                z_index: 1080,
                delay: 2500,
                timer: 2000,
                url_target: "_blank",
                mouse_over: !1,
                animate: {enter: o, exit: i},
                template:
                        '<div data-notify="container" class="col-xs-11 col-sm-3 alert alert-{0}" role="alert">' +
                        '<button type="button" aria-hidden="true" class="close" data-notify="dismiss">×</button>' +
                        '<span data-notify="icon"></span> ' +
                        '<span data-notify="title">{1}</span> ' +
                        '<span data-notify="message">{2}</span>' +
                        '<div class="progress progress progress-xs" data-notify="progressbar">' +
                        '<div class="progress-bar progress-bar w-75 progress-bar-{0}" role="progressbar" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100" style="width: 0%;"></div>' +
                        '</div>' +
                        '<a href="{3}" target="{4}" data-notify="url"></a>' +
                        '</div>',
            }
    );
}
function list_gif_loader(p){
        if(p == 'open'){
            $("#data-holder").html(" <div class='card'><div class='card-body'><img src='{{asset('/public/img/9zqj8ab4s1a5joa9umsu.gif')}}' style='height: 300px;width:100%;'></div></div> <div class='card'><div class='card-body'><img src='{{asset('/public/img/9zqj8ab4s1a5joa9umsu.gif')}}' style='height: 300px;width:100%;'></div></div> <div class='card'><div class='card-body'><img src='{{asset('/public/img/9zqj8ab4s1a5joa9umsu.gif')}}' style='height: 300px;width:100%;'></div></div> <div class='card'><div class='card-body'><img src='{{asset('/public/img/9zqj8ab4s1a5joa9umsu.gif')}}' style='height: 300px;width:100%;'></div></div> <div class='card'><div class='card-body'><img src='{{asset('/public/img/9zqj8ab4s1a5joa9umsu.gif')}}' style='height: 200px;width:100%;'></div></div>");
        }else if('close'){
            $("#data-holder").html("");
        }
    }
</script>

@if(Session::has('success'))
<script>
    show_toastr('{{__('Success')}}', "{!! session('success') !!}", 'success');
</script>
{{ Session::forget('success') }}
@endif
@if(Session::has('error'))
<script>
    show_toastr('{{__('Error')}}', "{!! session('error') !!}", 'error');
</script>
{{ Session::forget('error') }}
@endif
