<script src="{{ asset('assets/home8/js/jquery.min.js')}}"></script>
<script src="{{ asset('assets/home8/js/popper.min.js')}}"></script>
<script src="{{ asset('assets/home8/js/bootstrap.min.js')}}"></script>
<!-- Meanmenu JS -->
<script src="{{ asset('assets/home8/js/meanmenu.min.js')}}"></script>
<!-- Magnific Popup JS -->
<script src="{{ asset('assets/home8/js/jquery.magnific-popup.min.js')}}"></script>
<!-- Owl Carousel JS -->
<script src="{{ asset('assets/home8/js/owl.carousel.min.js')}}"></script>
<!-- Odometer JS -->
<script src="{{ asset('assets/home8/js/odometer.min.js')}}"></script>
<!-- Jquery Appear JS -->
<script src="{{ asset('assets/home8/js/jquery.appear.js')}}"></script>
<!-- Form Validator JS -->
<script src="{{ asset('assets/home8/js/form-validator.min.js')}}"></script>
<!-- Contact JS -->
<script src="{{ asset('assets/home8/js/contact-form-script.js')}}"></script>
<!-- Ajaxchimp JS -->
<script src="{{ asset('assets/home8/js/jquery.ajaxchimp.min.js')}}"></script>
<!-- Custom JS -->
<script src="{{ asset('assets/home8/js/custom.js')}}"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
@if(Session::has('success'))
<script>
    toastr.success('{{__('Success')}}', "{!! session('success') !!}");
</script>
{{ Session::forget('success') }}
@endif
@if(Session::has('error'))
<script>
    toastr.success(('{{__('Error')}}', "{!! session('error') !!}");
</script>
{{ Session::forget('error') }}
@endif
