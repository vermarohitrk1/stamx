<!-- Jquery Slim JS -->
<script src="{{ asset('assets/home12/js/jquery.min.js')}}"></script>
<!-- Bootstrap Bundle JS -->
<script src="{{ asset('assets/home12/js/bootstrap.bundle.min.js')}}"></script>
<!-- Meanmenu JS -->
<script src="{{ asset('assets/home12/js/jquery.meanmenu.js')}}"></script>
<!-- Owl Carousel JS -->
<script src="{{ asset('assets/home12/js/owl.carousel.min.js')}}"></script>
<!-- Jquery Appear JS -->
<script src="{{ asset('assets/home12/js/jquery.appear.js')}}"></script>
<!-- Odometer JS -->
<script src="{{ asset('assets/home12/js/odometer.min.js')}}"></script>
<!-- Nice Select JS -->
<script src="{{ asset('assets/home12/js/nice-select.min.js')}}"></script>
<!-- Magnific Popup JS -->
<script src="{{ asset('assets/home12/js/jquery.magnific-popup.min.js')}}"></script>
<!-- Ajaxchimp JS -->
<script src="{{ asset('assets/home12/js/jquery.ajaxchimp.min.js')}}"></script>
<!-- Form Validator JS -->
<script src="{{ asset('assets/home12/js/form-validator.min.js')}}"></script>
<!-- Contact JS -->
<script src="{{ asset('assets/home12/js/contact-form-script.js')}}"></script>
<!-- Wow JS -->
<script src="{{ asset('assets/home12/js/wow.min.js')}}"></script>
<!-- Custom JS -->
<script src="{{ asset('assets/home12/js/main.js')}}"></script>
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
