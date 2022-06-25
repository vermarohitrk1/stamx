<script src="{{ asset('assets/home13/js/jquery.min.js')}}"></script>
<script src="{{ asset('assets/home13/js/bootstrap.min.js')}}"></script>
<script src="{{ asset('assets/home13/js/owl.carousel.min.js')}}"></script>
<script src="{{ asset('assets/home13/js/modernizr-2.8.3.min.js')}}"></script>
<script src="{{ asset('assets/home13/js/jquery.inview.min.js')}}"></script>
<script src="{{ asset('assets/home13/js/isotope.pkgd.min.js')}}"></script>
<script src="{{ asset('assets/home13/js/animated-headline.js')}}"></script>
<script src="{{ asset('assets/home13/js/lightbox.min.js')}}"></script>
<script src="{{ asset('assets/home13/js/SmoothScroll.js')}}"></script>
<script src="{{ asset('assets/home13/js/form-contact.js')}}"></script>
<script src="{{ asset('assets/home13/js/jquery.hoverdir.js')}}"></script>
<script src="{{ asset('assets/home13/js/scrolltopcontrol.js')}}"></script>
<script src="{{ asset('assets/home13/js/wow.min.js')}}"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>

<script src="{{ asset('assets/home13/js/main.js')}}"></script>
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
