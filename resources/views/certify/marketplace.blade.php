@extends('layouts.admin')
@section('title')
    {{"Marketplace"}}
@endsection

@push('css')
    <style type="text/css">
        i.fas.fa-check-circle {
            color: green;
            font-size: 25px;
        }

        .paginationCss {
            width: 100%;
            display: flex;
            justify-content: center;
        }
    </style>
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
    <div class="row" id="syndicate_view">
        <div class="col-12">
            <div class="card">
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="display responsive nowrap" width="100%" id="yajra-datatable">
                            <thead class="thead-light">
                            <tr>
                                <th class="name mb-0 h6 text-sm"> {{__('Course Name')}}</th>
                                <th class="name mb-0 h6 text-sm"> {{__('Type')}}</th>
                                <th class="name mb-0 h6 text-sm"> {{__('Price')}}</th>
                                <th class="name mb-0 h6 text-sm"> {{__('Status')}}</th>
                            </tr>
                            </thead>
                            <tbody>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <style type="text/css">
        p.text-center.stripe-text {
            font-size: 19px;
            margin-bottom: 0px;
        }

        .pop-up {
            font-size: 100px;
            text-align: center;
        }

        div#stripeModal {
            padding-right: 0px;
        }
    </style>
@endsection
@push('script')
    <script src="{{ asset('assets/libs/autosize/dist/autosize.min.js') }}"></script>
    <script src="{{ asset('assets/js/colorPick.js') }}"></script>
    <script src="{{ asset('assets/js/custom.js') }}"></script>
    <script type="text/javascript">
        $(document).ready(function () {
            $('#myTable').DataTable();
        });
        $(document).on('click', '.swicherClass', function () {
            var action = '';
            if ($(this).is(':checked')) {
                action = 'add';
                certifyId = $(this).val();
                changes(action, certifyId);
            } else {
                action = 'delete';
                certifyId = $(this).val();
                changes(action, certifyId);
            }
        });

        function changes(action, certifyId) {
            $.post(
                "{{route('certify.marketplace.adddata')}}",
                {_token: "{{ csrf_token() }}", action: action, certifyId: certifyId},
                function (data) {
                    show_toastr('Success', '{{__('marketplace Status has been changed.')}}', 'success');
                }
            );
        }

        $(function () {
            var table = $('#yajra-datatable').DataTable({
                 responsive: true,
                processing: true,
                serverSide: true,
                ajax: "{{ route('certify.marketplace') }}",
                columns: [
                    {data: 'name', name: 'name', orderable: false, searchable: true},
                    {data: 'type', name: 'type', orderable: false, searchable: false},
                    {data: 'price', name: 'price', orderable: false, searchable: false},
                    {data: 'action', name: 'action', orderable: false, searchable: false},
                ]
            });

        });
    </script>
@endpush
