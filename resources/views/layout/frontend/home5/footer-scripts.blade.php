
    <!-- Jquery Slim JS -->
    <script src="{{ asset('assets/home5/js/jquery.min.js')}}"></script>
    <!-- Bootstrap Bundle JS -->
    <script src="{{ asset('assets/home5/js/bootstrap.bundle.min.js')}}"></script>
    <!-- Meanmenu JS -->
    <script src="{{ asset('assets/home5/js/jquery.meanmenu.js')}}"></script>
    <!-- Owl Carousel JS -->
    <script src="{{ asset('assets/home5/js/owl.carousel.min.js')}}"></script>
    <!-- Jquery Appear JS -->
    <script src="{{ asset('assets/home5/js/jquery.appear.js')}}"></script>
    <!-- Odometer JS -->
    <script src="{{ asset('assets/home5/js/odometer.min.js')}}"></script>
    <!-- Slick JS -->
    <script src="{{ asset('assets/home5/js/slick.min.js')}}"></script>
    <!-- Magnific Popup JS -->
    <script src="{{ asset('assets/home5/js/jquery.magnific-popup.min.js')}}"></script>
    <!-- Ajaxchimp JS -->
    <script src="{{ asset('assets/home5/js/jquery.ajaxchimp.min.js')}}"></script>
    <!-- Form Validator JS -->
    <script src="{{ asset('assets/home5/js/form-validator.min.js')}}"></script>
    <!-- Contact JS -->
    <script src="{{ asset('assets/home5/js/contact-form-script.js')}}"></script>
    <!-- Wow JS -->
    <script src="{{ asset('assets/home5/js/wow.min.js')}}"></script>
    <!-- Custom JS -->
    <script src="{{ asset('assets/home5/js/main.js')}}"></script>
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
