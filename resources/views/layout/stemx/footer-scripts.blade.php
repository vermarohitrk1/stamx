<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.0/jquery.min.js">
</script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"></script>
<script type="text/javascript" src="{{ asset('assets/main/js/slick.min.js')}}"></script>
<script type="text/javascript" src="{{ asset('assets/main/js/custom_script.js')}}"></script>
<!--toastr for notification-->
<script src="{{ asset('assets/libs/bootstrap-notify/bootstrap-notify.min.js') }}"></script>
<script>
  

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
               // delay: 2500,
               // timer: 2000,
                url_target: "_blank",
                mouse_over: !1,
                animate: {enter: o, exit: i},
                template:
                        '<div style="font-size:16px !important" data-notify="container" class="text-xl col-xs-11 col-sm-3 alert alert-{0}" role="alert">' +
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
