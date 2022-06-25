<?php $page = "Tuition Assistance Requests"; ?>
@extends('layout.dashboardlayout')
@section('content')	

<style>
.media {
    margin-top: 0px !important;
}
.main-wrapper {

    height: auto!important;
}
.custom-control-input:checked~.custom-control-label::before {
    color: #fff;
    border-color: #009da6;
    background-color: #009da6;
}
.modal-open .main-wrapper {
    -webkit-filter: blur(1px);
    -moz-filter: blur(1px);
    -o-filter: blur(1px);
    -ms-filter: blur(1px);
    filter: inherit;
}

.modal {
    padding-top: 5rem !important;
}
  .middle h1 {
            color: #212529;
            font-size: 23px;
        }

        .middle input[type="radio"] {
            display: none;
        }

        .middle input[type="radio"]:checked + .box {
            background-color: #2954b1;
        }

        .middle input[type="radio"]:checked + .box span {
            color: white;
            transform: translateY(70px);
        }

        .middle input[type="radio"]:checked + .box span:before {
            transform: translateY(0px);
            opacity: 1;
        }

        .middle .box {
            width: 135px;
            height: 42px;
            background-color: #fff;
            transition: all 250ms ease;
            will-change: transition;
            display: inline-block;
            text-align: center;
            cursor: pointer;
            position: relative;
            box-shadow: 0 4px 8px 0 rgba(0, 0, 0, 0.2);
            font-weight: 600;
        }

        .middle .box:active {
            transform: translateY(10px);
        }

        input.btn.btn-info.btn-md.log:hover {
            box-shadow: 0 4px 8px 0 rgba(0, 0, 0, 0.2);
        }

        .middle .box span {
            position: absolute;
            transform: translate(0, 69px);
            left: 0;
            right: 0;
            transition: all 300ms ease;
            font-size: 18px;
            user-select: none;
            color: #2954b1;
            bottom: 76px;
            font-family: 'Rajdhani', sans-serif;
        }

        .middle .box span:before {
            font-size: 1.2em;
            font-family: FontAwesome;
            display: block;
            transform: translateY(-80px);
            opacity: 0;
            transition: all 300ms ease-in-out;
            font-weight: normal;
            color: white;
        }

        .middle .front-end span:before {

        }

        .middle .back-end span:before {

        }

        .middle p {
            color: #fff;
            font-weight: 400;
        }

        .middle p span:after {
            content: '\f0e7';
            font-family: FontAwesome;
            color: yellow;
        }

        .middle label {
            margin-top: 15px !important;
        }

        .middle {
            transform: translateY(0%) !important;
        }
</style>
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
                <div class=" col-md-12 ">
				<a href="{{ route('certify.index') }}" id="back" class="btn btn-sm btn-primary float-right ml-2">
				<span class="btn-inner--icon"><i class="fas fa-reply"></i></span>
				</a>
				
				</div>
   
<!-- Breadcrumb -->
<div class="breadcrumb-bar mt-3">
    <div class="container-fluid">
        <div class="row align-items-center">
            <div class="col-md-12 col-12">
                <h2 class="breadcrumb-title">Tuition Assistance Requests</h2>
                <nav aria-label="breadcrumb" class="page-breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{route('dashboard')}}">Home</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Tuition Assistance Requests</li>
                    </ol>
                </nav>
            </div>              
        </div>            
    </div>
</div>
<!-- /Breadcrumb -->



<div class="row" id="certifyView">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                     <div class="table-md-responsive">                    
                    <table class="table  table-hover table-center mb-0" id="yajra-datatable">
                        <thead class="thead-light ">
                            
                   
                            <tr>
                               <th class="name mb-0 h6 text-sm"> {{__('Corporate Name')}}</th>
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


            </div>
        </div>

    </div>

</div>		
<!-- /Page Content -->

@endsection

@push('script')
    <script type="text/javascript">
        $(document).on("click", ".destroyblog", function(){
    var id = $(this).attr('data-id');
    console.log(id);
    $("#blog_id").val(id);
    $('#destroyblog').modal('show');

});


   
	
	        $(function () {
    var table = $('#yajra-datatable').DataTable({
        responsive: true,
        processing: true,
        serverSide: true,
                      ajax: "{{ route('wallet.clienttutionrequest') }}",
                columns: [
                     {data: 'user_name', name: 'user_name', orderable: false, searchable: false},
                    {data: 'certify', name: 'certify', orderable: false},
                    {data: 'type', name: 'type', orderable: false},
                    {data: 'price', name: 'price', orderable: false},
                    {data: 'status', name: 'status', orderable: false},
                   
        ]
    });

  });

     </script>
	 @endpush
