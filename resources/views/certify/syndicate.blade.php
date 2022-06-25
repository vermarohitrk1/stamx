<?php $page = "Syndicate"; ?>
@extends('layout.dashboardlayout')
@section('content')	

<style>
.custom-control-input:checked~.custom-control-label::before {
    color: #fff;
    border-color: #009da6;
    background-color: #009da6;
}
 p.text-center.stripe-text {
            font-size: 19px;
            margin-bottom: 0px;
        }

        .pop-up {
            font-size: 100px;
            text-align: center;
        }

.modal-open .main-wrapper {
    -webkit-filter: blur(1px);
    -moz-filter: blur(1px);
    -o-filter: blur(1px);
    -ms-filter: blur(1px);
    filter: inherit;
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
                    @php
                    $permissions=permissions();
                    @endphp
                     <a href="{{ route('certify.index') }}" id="back" class="btn btn-sm btn-primary float-right ml-2">
        <span class="btn-inner--icon"><i class="fas fa-reply"></i></span>
    </a>
                
       
		 <a href="{{ route('certify.syndicate.pending.list')}}" class="btn btn-sm btn btn-primary float-right mr-2 m-0">
                 <span class="btn-inner--text ">{{__('Pending Syndicate')}}</span>
               </a>	
	

                     </div>
   
<!-- Breadcrumb -->
<div class="breadcrumb-bar mt-3">
    <div class="container-fluid">
        <div class="row align-items-center">
            <div class="col-md-12 col-12">
                <h2 class="breadcrumb-title">Courses</h2>
                <nav aria-label="breadcrumb" class="page-breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{route('dashboard')}}">Home</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Approved Syndicate</li>
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
                               <th class="name mb-0 h6 text-sm"> {{__('Course Name')}}</th>
                                <th class="name mb-0 h6 text-sm"> {{__('Type')}}</th>
                                <th class="name mb-0 h6 text-sm"> {{__('Price')}}</th>
								 @if ($authuser->type == 'admin') 
									   <th class="name mb-0 h6 text-sm"> {{__('Approve')}}</th>
								@else
							<th class="name mb-0 h6 text-sm"> {{__('Show on Frontend')}}</th>
								@endif			
                              
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
<!-- Modal -->
    <div id="notDestroy" class="modal fade" role="dialog">
        <div class="modal-dialog">
            <!-- Modal content-->
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Alert <i class="fas fa-exclamation-circle"></i></h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <div class="modal-body">
                    This certify cannot be deleted because it has been already purchased by somebody.
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-sm btn-secondary rounded-pill" id="" data-dismiss="modal"
                            aria-label="Close">Cancel
                    </button>
                </div>
            </div>
        </div>
    </div>
    <!-- Modal -->
    <div id="destroyCertify" class="modal fade" role="dialog">
        <div class="modal-dialog">
            <!-- Modal content-->
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Are You Sure?</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <div class="modal-body">
                    This action can not be undone. Do you want to continue?
                </div>
                <div class="modal-footer">
                    {{ Form::open(['url' => 'certify/destroy','id' => 'destroy_certify','enctype' => 'multipart/form-data']) }}
                    <input type="hidden" name="certify_Id" id="certify_Id" value="">

                    <button type="submit" class="btn btn-sm btn-danger rounded-pill" id="">Yes</button>
                    {{ Form::close() }}
                    <button type="button" class="btn btn-sm btn-secondary rounded-pill" id="" data-dismiss="modal"
                            aria-label="Close">Cancel
                    </button>
                </div>
            </div>
        </div>
    </div>
    
   
 <div id="stripeModal" class="modal fade" role="dialog">
        <div class="modal-dialog">
            <!-- Modal content-->
            <div class="modal-content">
                <div class="modal-body">
                    <h5 class="modal-title text-center">Connect Stripe!</h5>
                    <div class="pop-up">
                        <i class="fas fa-exclamation-triangle text-danger"></i>
                    </div>
                    <p class="text-center stripe-text">Please connect your Stripe account to promote syndicate
                        courses</p>
                    <br>
                    <div class="syndicate_button text-center">
                        <a href="javascript:void(0);" id="stripeUrl">
                            <button type="button" class="btn btn-sm btn-primary ">OKAY</button>
                        </a>
                    </div>
                </div>
                <div class="">
                </div>
            </div>
        </div>
    </div>
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
        ajax: "{{ route('certify.syndicate') }}",
        columns: [
        
                    {data: 'name', name: 'name', orderable: true},
                    {data: 'type', name: 'type', orderable: false},
                    {data: 'price', name: 'price', orderable: false},
                    {
                        data: 'status',
                        name: 'status',
                        orderable: false,
                        searchable: false,
                    },
                ]
    });

  });
       $(document).ready(function () {
           // $('#myTable').DataTable();
        })
    </script>
    <!--<script src="{{ asset('assets/libs/dragula/dist/dragula.min.js') }}"></script>-->
    <!--<script src="{{ asset('public/ckeditor/ckeditor.js') }}"></script>-->
<!--    <script src="{{ asset('assets/js/custom.js') }}"></script>
    <script type="text/javascript" src="{{ asset('assets/js/repeater.js') }}"></script>-->
     <script type="text/javascript">
	 
	 
	 
	 
	    $(document).on("change", ".customSwitchesSyndicate", function () {
            if ($(this).find('.custom-control-input').is(':checked')) {
                var id = $(this).find('.custom-control-input').val();
                $.ajax({
                    url: "syndicate/stripe?certifyId=" + id,
                    success: function (data) {
                        if (data.dataType == 'stripe') {
                            $("#stripeUrl").attr('href', '');
                            $("#stripeUrl").attr('href', data.data);
                            $('#stripeModal').modal('show');
                        } else if (data.dataType == 'data') {
                            show_toastr('Success', '{{__('certify syndicated successfully.')}}', 'success');
                        }
                    }
                });
            } else {
                var id = $(this).find('.custom-control-input').val();
                $.ajax({
                    url: "syndicate/disable?certifyId=" + id,
                    success: function (data) {
                        if (data) {
                            show_toastr('Success', '{{__('certify syndicated disable successfully.')}}', 'success');
                        }
                    }
                });
            }
        });
		
		
        $(document).on("change", ".customSwitches", function () {
            if ($(this).find('.custom-control-input').is(':checked')) {
				
			
                var id = $(this).find('.custom-control-input').val();
                $.ajax({
                    url: "syndicate/approve?certifyId=" + id,
                    success: function (data) {
                        if (data) {
                            show_toastr('Success', '{{__('Course syndicated successfully.')}}', 'success');
                        } else {
                            show_toastr('Error', '{{__('Course not syndicated.')}}', 'error');
                        }
                    }
                });
            } else {
								
                var id = $(this).find('.custom-control-input').val();
                $.ajax({
                    url: "syndicate/pending?certifyId=" + id,
                    success: function (data) {
                        if (data) {
                            show_toastr('Success', '{{__('Course Un syndicated successfully.')}}', 'success');
                        } else {
                            show_toastr('Error', '{{__('Course not Un syndicated.')}}', 'error');
                        }
                    }
                });
            }
        });
		
		
		     $(document).on("change", ".customSwitchesFrontend", function () {
            if ($(this).find('.custom-control-input').is(':checked')) {
				
			
                var id = $(this).find('.custom-control-input').val();
                $.ajax({
                    url: "syndicate/frontendview?certifyId=" + id,
                    success: function (data) {
                        if (data) {
                            show_toastr('Success', '{{__('Course Enbled.')}}', 'success');
                        } else {
                            show_toastr('Error', '{{__('Course not syndicated.')}}', 'error');
                        }
                    }
                });
            } else {
								
                var id = $(this).find('.custom-control-input').val();
                $.ajax({
                    url: "syndicate/deletefrontendview?certifyId=" + id,
                    success: function (data) {
                        if (data) {
                            show_toastr('Success', '{{__('Course Disabled.')}}', 'success');
                        } else {
                            show_toastr('Error', '{{__('Course not Un syndicated.')}}', 'error');
                        }
                    }
                });
            }
        });
    </script>
@endpush
