<script src="{{ asset('assets/home18/js/all.js')}}"></script>
<script src="{{ asset('assets/home18/js/custom.js')}}"></script>
<script src="{{ asset('assets/home18/js/slider.js')}}"></script>
<script>
(function($) {
    "use strict";
    $('#superslides').superslides({
      animation: 'fade'
    });
})(jQuery);
</script>
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
