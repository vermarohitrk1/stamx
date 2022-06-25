<!-- JS FILES -->
<script src="{{ asset('assets/home7/js/jquery.min.js')}}"></script>
<script src="{{ asset('assets/home7/js/bootstrap.min.js')}}"></script>
<script src="{{ asset('assets/home7/js/gsap.min.js')}}"></script>
<script src="{{ asset('assets/home7/js/locomotive-scroll.min.js')}}"></script>
<script src="{{ asset('assets/home7/js/ScrollTrigger.min.js')}}"></script>
<script src="{{ asset('assets/home7/js/kinetic-slider.js')}}"></script>
<script src="{{ asset('assets/home7/js/fancybox.min.js')}}"></script>
<script src="{{ asset('assets/home7/js/odometer.min.js')}}"></script>
<script src="{{ asset('assets/home7/js/swiper.min.js')}}"></script>
<script src="{{ asset('assets/home7/js/scripts.js')}}"></script>
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

