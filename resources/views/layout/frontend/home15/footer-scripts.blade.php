    <!-- Main jQuery -->
    <script src="{{ asset('assets/home14/vendors/jquery/jquery.js')}}"></script>
    <!-- Bootstrap 4.5 -->
    <script src="{{ asset('assets/home14/vendors/bootstrap/bootstrap.js')}}"></script>
    <!-- Counterup -->
    <script src="{{ asset('assets/home14/vendors/counterup/waypoint.js')}}"></script>
    <script src="{{ asset('assets/home14/vendors/counterup/jquery.counterup.min.js')}}"></script>
    <script src="{{ asset('assets/home14/vendors/jquery.isotope.js')}}"></script>
    <script src="{{ asset('assets/home14/vendors/imagesloaded.js')}}"></script>
    <script src="{{ asset('assets/home14/vendors/owl/owl.carousel.min.js')}}"></script>
    <script src="{{ asset('assets/home14/vendors/google-map/map.js')}}"></script>
    <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyAkeLMlsiwzp6b3Gnaxd86lvakimwGA6UA&callback=initMap"></script>
    <script src="{{ asset('assets/home14/js/script.js')}}"></script>
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
