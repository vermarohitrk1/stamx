<script src="{{ asset('assets/home20/js/plugins/jquery1.11.0.min.js')}}"></script>
<script src="{{ asset('assets/home20/js/plugins/bootstrap.min.js')}}"></script>
<script src="{{ asset('assets/home20/js/plugins/jquery.easing.1.3.min.js')}}"></script>
<script src="{{ asset('assets/home20/js/plugins/custom.js')}}"></script>
<script src="{{ asset('assets/home20/js/plugins/plugins.min.js')}}"></script>
<script src="{{ asset('assets/home20/js/plugins/twitter/tweetie.min.js')}}"></script>
<!-- Custom Script -->
<script src="{{ asset('assets/home20/js/custom.js')}}"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
@if(Session::has('success'))
<script>
    toastr.success('{{__('Success')}}', "{!! session('success') !!}");
</script>
{{ Session::forget('success') }}
@endif
@if(Session::has('error'))
<script>
    toastr.success('{{__('Error')}}', "{!! session('error') !!}");
</script>
{{ Session::forget('error') }}
@endif
