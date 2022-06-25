  <!-- all plugins here -->
  <script src="{{ asset('assets/home16/js/vendor.js')}}"></script>
  <script src="{{ asset('assets/home16/js/counter.js')}}"></script>
  <!-- main js  -->
  <script src="{{ asset('assets/home16/js/main.js')}}"></script>

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

