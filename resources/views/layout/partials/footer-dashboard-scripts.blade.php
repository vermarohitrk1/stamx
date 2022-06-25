<!-- jQuery -->
<input id="speech_bot_voice" type="hidden" value="{{ App\Http\Controllers\UserController::getBotVoiceName() }}">
<input type="hidden" id="clientid" name="clientid" value="{{ str_replace(' ', '', Auth::user()->name) }}"/>
<input id="bot_wake_word" type="hidden" value="{{ App\Http\Controllers\UserController::getWakeWord() }}">
<script>


</script>

<script src="{{ asset('public/assets_admin/js/jquery-3.2.1.min.js') }}"></script>

<!-- Bootstrap Core JS -->
<script src="{{ asset('assets/js/popper.min.js') }}"></script>
<script src="{{ asset('assets/js/bootstrap.min.js') }}"></script>
<!-- Select2 JS -->
<script src="{{ asset('assets/plugins/select2/js/select2.min.js') }}"></script>
<!-- Datetimepicker JS -->
<script src="{{ asset('assets/js/moment.min.js') }}"></script>
<script src="{{ asset('assets/js/bootstrap-datetimepicker.min.js') }}"></script>
<script src="{{ asset('assets/plugins/daterangepicker/daterangepicker.js') }}"></script>
	
<!-- Sticky Sidebar JS -->
<script src="{{ asset('assets/plugins/theia-sticky-sidebar/ResizeSensor.js') }}"></script>
<script src="{{ asset('assets/plugins/theia-sticky-sidebar/theia-sticky-sidebar.js') }}"></script>
<!-- Circle Progress JS -->

<!-- Datatables JS -->
<script src="{{ asset('public/assets_admin/plugins/datatables/jquery.dataTables.min.js') }}"></script>
<script src="{{ asset('public/assets_admin/plugins/datatables/datatables.min.js') }}"></script>

<script src="https://cdn.datatables.net/responsive/2.2.9/js/dataTables.responsive.min.js"></script>

<script src="https://cdnjs.cloudflare.com/ajax/libs/timepicker/1.3.5/jquery.timepicker.min.js"></script>  
<script src="https://bank.trymyceo.com/public/ckeditor/ckeditor.js"></script>
<script src="https://bank.trymyceo.com/public/frontend/js/audioplayer.js"></script>
<script src="https://bank.trymyceo.com/public/frontend/js/custom-audio-player.js"></script>

@stack('js-cdn')
<!-- Custom JS -->
<script src="{{ asset('assets/js/script.js') }}"></script>



<!--toastr for notification-->
<script src="{{ asset('assets/libs/bootstrap-notify/bootstrap-notify.min.js') }}"></script>
<script>
 $( document ).ready(function() {
      //  alert("gf");
        $('#mobile_btn').click(function(){ 
            if ($(".theiaStickySidebar").hasClass("col-md-5")) {
                $(".theiaStickySidebar").toggleClass('show');
                } 
            });
     });
// $( document ).ready(function() {
//     $('.submenu').click(function(){
//         $(this).toggleClass('active');
// // $(this).children('ul').toggle('slow');
// $(this).children('ul').slideToggle(500);
// })
// });

jQuery(document).ready(function($) {
  var accordion_head  = $('.sidebar-dropdown');

  accordion_head.on('click', function(event) {
    event.preventDefault();
     //$(this).parent('li').toggleClass('active');
    if($(this).hasClass('active')){
      $(this).next('.nav__dropdown').find('.active').next('.nav__dropdown').slideUp('normal');
    }
    $(this).parent('li').siblings('li').find('.active').next('.nav__dropdown').slideUp('normal');
    $(this).stop().next('.nav__dropdown').stop().slideToggle('normal');
  });
 // $.each(accordion_head,function(i){
    //   if($(this).next('ul:visible').length == 0){
    //     $(this).find('span').removeClass('active')
    //   }else{
    //     $(this).find('span').addClass('active')
    //   }
    // });
});

  $(function() {
    $('.custom-model-class').on('show.bs.modal', function (e) {
  $('.modal-open').removeClass('modal-open');
})
})

    
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
                placement: {from: "bottom", align: "right"},
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
   $(document).on("click", ".confirm_record_model", function(){
$("#common_confirm_form").attr('action',$(this).attr('data-url'));
$('#common_confirm_model').modal('show');
});


   $(document).on("click", ".cancelPlanOverview", function(){
	  
$("#CancelPlan").attr('action',$(this).attr('data-url'));
$('#destroyCancelPlan').modal('show');
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

@if(Request::is('chat'))  
  @else
 <!-- Scripts -->
    <!--<script src="{{ asset('js/app.js') }}" defer></script>-->
    <!--<script src="https://cdn.agora.io/sdk/release/AgoraRTCSDK-3.3.1.js"></script>-->
  @endif

  <script type="text/javascript">
$(function () {
    dashboardblockdata();   
    });
    
     $(document).on("click", ".datafilterbtn", function(){
         $(".datafilterbtn").removeClass('active');
         $(this).addClass('active');
    dashboardblockdata();
   
        });
        
        function dashboardblockdata() {
            var blockElements= $(".blockWithFilter" ).find( "h3[data-id]" );
    if(blockElements !=''){
        if($('.blockfilterbar').length < 1){
        $(".blockWithFilter" ).prepend('<div class="col-md-12 mb-3 blockfilterbar"><div class="btn-group btn-group-sm btn-group-justified btn-group-lg float-right pull-right"><a href="javascript:void(0)" data-id="-1"  class="btn btn-primary active datafilterbtn">1M</a><a href="javascript:void(0)" data-id="-3" class="btn btn-primary datafilterbtn">3M</a><a href="javascript:void(0)" data-id="-6" class="btn btn-primary datafilterbtn">6M</a><a href="javascript:void(0)" data-id="-12" class="btn btn-primary datafilterbtn">1Y</a><a href="javascript:void(0)" data-id="" class="btn btn-primary datafilterbtn">All Duration</a></div></div>');
    }
        var blockElementsData=[];
        $.each( blockElements, function( key, elm ) {
            blockElementsData.push(elm.getAttribute('data-id'));
        });
        
        var data = {
            blockElementsData: blockElementsData,
            duration: $('.datafilterbtn.active').data('id'),
            _token: "{{ csrf_token() }}",
    }
    $.get(
            window.location.href,
            data,
            function (data) {
                setTimeout(function() { 
         $.each( jQuery.parseJSON(data), function( id, val ) {
              $(".blockWithFilter").find("h3[data-id='" + id + "']").html(val);
            });
    }, 1000);
               

            
            }
    );
   
    }
    
    }

</script>