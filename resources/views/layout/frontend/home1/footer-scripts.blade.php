<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.0/jquery.min.js">
</script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"></script>
<script type="text/javascript" src="{{ asset('assets/home1/js/slick.min.js')}}"></script>
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/owl-carousel/1.3.3/owl.carousel.min.js"></script>
<script type="text/javascript" src="{{ asset('assets/home1/js/custom_script.js')}}"></script>
<script type="text/javascript">
$(document).ready(function(){
    $("#testimonial-slisder").owlCarousel({
        items:2,
        itemsDesktop:[1199,2],
        itemsDesktopSmall:[979,1],
        itemsTablet:[768,1],
        itemsMobile:[600,1],
        pagination:true,
        navigation:false,
        navigationText:["",""],
        slideSpeed:1000,
        autoPlay:true
    });
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
