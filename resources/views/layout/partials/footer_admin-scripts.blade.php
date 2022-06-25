<!-- jQuery -->
<script src="{{ asset('public/assets_admin/js/jquery-3.2.1.min.js') }}"></script>

<!-- Bootstrap Core JS -->
<script src="{{ asset('public/assets_admin/js/popper.min.js') }}"></script>
<script src="{{ asset('public/assets_admin/js/bootstrap.min.js') }}"></script>

<!-- Slimscroll JS -->
<script src="{{ asset('public/assets_admin/plugins/slimscroll/jquery.slimscroll.min.js') }}"></script>
<!-- Form Validation JS -->
<script src="{{ asset('public/assets_admin/js/form-validation.js') }}"></script>

<!-- Mask JS -->
<script src="{{ asset('public/assets_admin/js/jquery.maskedinput.min.js') }}"></script>
<script src="{{ asset('public/assets_admin/js/mask.js') }}"></script>

<!-- Select2 JS -->
<script src="{{ asset('public/assets_admin/plugins/select2/js/select2.min.js') }}"></script>
@if(Route::is(['page']))
<script src="{{ asset('public/assets_admin/plugins/raphael/raphael.min.js') }}"></script>    
<script src="{{ asset('public/assets_admin/plugins/morris/morris.min.js') }}"></script>  
<!-- Chart JS -->
<script src="{{ asset('public/assets_admin/plugins/apexchart/apexcharts.min.js') }}"></script>
<script src="{{ asset('public/assets_admin/plugins/apexchart/dsh-apaxcharts.js') }}"></script>
@endif
<!-- Datatables JS -->
<script src="{{ asset('public/assets_admin/plugins/datatables/jquery.dataTables.min.js') }}"></script>
<script src="{{ asset('public/assets_admin/plugins/datatables/datatables.min.js') }}"></script>
<!-- Custom JS -->
<script  src="{{ asset('public/assets_admin/js/script.js') }}"></script>

<!-- Datetimepicker JS -->
<script src="{{ asset('assets/js/moment.min.js') }}"></script>
<script src="{{ asset('assets/js/bootstrap-datetimepicker.min.js') }}"></script>
<script src="{{ asset('assets/plugins/daterangepicker/daterangepicker.js') }}"></script>

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
   $(document).on("click", ".delete_record_model", function(){
$("#common_delete_form").attr('action',$(this).attr('data-url'));
$('#common_delete_model').modal('show');
});
   $(document).on("click", ".cancelPlanOverview", function(){
	   $('#destroyCancelPlan').modal('show');
$("#common_delete_form").attr('action',$(this).attr('data-url'));

});

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
