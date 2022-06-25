@extends('layouts.admin')
@section('title')
    {{" Learn "}}
@endsection

@push('css')
    <link rel="stylesheet" href="{{ asset('css/switchery/switchery.min.css') }}">
@endpush

@push('theme-script')
    <script src="{{ asset('assets/libs/dragula/dist/dragula.min.js') }}"></script>
@endpush

@section('action-button')
    <a href="{{ url('certify') }}" class="btn btn-sm btn-white btn-icon-only rounded-circle ml-2">
        <span class="btn-inner--icon"><i class="fas fa-reply"></i></span>
    </a>
@endsection

@section('content')
    <div class="row min-750" id="learn_view"></div>
@endsection

@push('script')
    <script src="{{ asset('assets/libs/autosize/dist/autosize.min.js') }}"></script>
    <script src="{{ asset('assets/js/colorPick.js') }}"></script>
    <script src="{{ asset('assets/js/custom.js') }}"></script>
    <script src="{{ asset('js/jquery-ui/jquery-ui.min.js') }}"></script>

    <script>
        $.ajax({
            url: "featchDatalearnview?certify={{$id}}",
            success: function (data) {
                $('#learn_view').html(data.html);
            }
        });
    </script>
@endpush
