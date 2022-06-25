@php $page = "Voicemail History"; @endphp
@extends('layout.dashboardlayout')
@section('content')


<!-- Page Content -->
<div class="content">
    <div class="container-fluid">

        <div class="row">
            <div class="col-md-5 col-lg-4 col-xl-3 theiaStickySidebar">

                <!-- Sidebar -->
                      @include('layout.partials.userSideMenu')
                <!-- /Sidebar -->

            </div>

            <div class="col-md-7 col-lg-8 col-xl-9">


<!-- Breadcrumb -->
<div class="breadcrumb-bar mt-3">
    <div class="container-fluid">
        <div class="row align-items-center">
            <div class="col-md-12 col-12">
                <h2 class="breadcrumb-title">Voicemail History</h2>
                <nav aria-label="breadcrumb" class="page-breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{route('dashboard')}}">Home</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Voicemail History</li>
                    </ol>
                </nav>
            </div>
        </div>
    </div>
</div>
<!-- /Breadcrumb -->





<div class="row" id="blog_view">
     <div class="col-12">
        <div class="card">
            <div class="card-body ">
                <div class="table-md-responsive">
                    <table class="table table-hover table-center mb-0" id="example">
                        <thead class="thead-light">
                        <tr>
                            <th class=" mb-0 h6 text-sm"> {{__('From')}}</th>
                            <th class=" mb-0 h6 text-sm"> {{__('Department')}}</th>
                            <th class=" mb-0 h6 text-sm"> {{__('To')}}</th>
                            <th class=" mb-0 h6 text-sm"> {{__('Direction')}}</th>
                            <th class=" mb-0 h6 text-sm"> {{__('Status')}}</th>
                            <th class=" mb-0 h6 text-sm"> {{__('Duration (sec)')}}</th>
                            <th class=" mb-0 h6 text-sm" > {{__('Audio')}}</th>
                            <th class="text-right name mb-0 h6 text-sm"> {{__('Start At ')}}</th>
                            <th class="text-right name mb-0 h6 text-sm"> {{__('End At ')}}</th>
                        </tr>
                        </thead>
                    </table>
                </div>
            </div>
        </div>
    </div>


</div>


            </div>
        </div>

    </div>

</div>
<!-- /Page Content -->
@endsection
@push('script')

<!--<script type="text/javascript" src="{{ asset('datatables/datatables.min.js') }}"></script>-->



<script type="text/javascript">


$(function () {
    var table = $('#example').DataTable({
         responsive: true,
        processing: true,
        serverSide: true,
        ajax: "{{ route('ivr.voice_mail_logs') }}",
        columns: [
            {data: 'pfrom', name: 'pfrom'},
            {data: 'dept_id', name: 'dept_id'},
            {data: 'phone', name: 'phone'},
            {data: 'direction', name: 'direction'},
            {data: 'statusin', name: 'statusin'},
            {data: 'dialcallduration', name: 'dialcallduration'},
            {data: 'recordingurl', name: 'recordingurl'},
            {data: 'startat', name: 'startat'},
            {
                data: 'endat',
                name: 'endat',
                orderable: false,
                searchable: false
            },
        ]
    });

  });
</script>

@endpush
