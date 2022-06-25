<?php $page = "Courses"; ?>
@section('title')
    {{$page}}
@endsection
@extends('layout.dashboardlayout')
@section('content')	

<style>
.modal-open .main-wrapper {
    -webkit-filter: blur(1px);
    -moz-filter: blur(1px);
    -o-filter: blur(1px);
    -ms-filter: blur(1px);
    filter: inherit;
}
p#CourName {
    display: contents;
}
.modal {
    z-index: 9999;
	margin-top: 1rem;
}
.modal {
    padding-top: 5rem !important;
}
.modal-bodyc.text-center {
    padding: 20px;
} 


</style>
<link rel="stylesheet" href="http://demo.itsolutionstuff.com/plugin/bootstrap-3.min.css">
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/1.1.3/sweetalert.min.css" />
	<script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/1.1.3/sweetalert.min.js"></script>

@include('sweet::alert')
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
                    @if(Auth::user()->type=="corporate")
						 <a href="javascript:void(0);" data-toggle="modal"
                                       data-target="#verifyCertCorrporate"
                                       class="btn btn-sm btn btn-primary float-right mr-2 m-0 {{ request()->is('cert') ? 'active' : '' }}">
                                       
                                       {{__('Verify Cert')}}
                                    </a>
					@endif
				   @if(Auth::user()->type=="mentee")
					     <a href="{{ route('certify.payments') }}" class="btn btn-sm btn btn-primary float-right mr-2 m-0">
                 <span class="btn-inner--text ">{{__('Payments')}}</span>
               </a>
			    <a href="{{ route('wallet.clienttutionrequest') }}" id="" class="btn btn-sm btn btn-primary float-right mr-2 m-0">
				Tuition Assistance 
				</a> 
				   @endif
				   
                    @if(Auth::user()->type=="admin")
                <a href="{{ route('certify.categories') }}" class="btn btn-sm btn btn-primary float-right mr-2 m-0">
                 <span class="btn-inner--text ">{{__('Manage Categories')}}</span>
               </a>
			   
			   <a href="{{ route('certify.syndicate') }}" class="btn btn-sm btn btn-primary float-right mr-2 m-0">
                 <span class="btn-inner--text ">{{__('Syndicate')}}</span>
               </a>
			   <a href="{{ route('certify.syndicate.revenue') }}" class="btn btn-sm btn btn-primary float-right mr-2 m-0">
                 <span class="btn-inner--text ">{{__('Syndicate Revenue')}}</span>
               </a>
			   
			   @elseif(Auth::user()->type=="mentor" && 	  checkPlanModule("syndicatepayments") )
			   	   <a href="{{ route('certify.syndicate') }}" class="btn btn-sm btn btn-primary float-right mr-2 m-0">
                 <span class="btn-inner--text ">{{__('Syndicate')}}</span>
				 
               </a>
			    <a href="{{ route('certify.syndicate.revenue') }}" class="btn btn-sm btn btn-primary float-right mr-2 m-0">
                 <span class="btn-inner--text ">{{__('Syndicate Revenue')}}</span>
               </a>
                    @endif
                 
                       @if(Auth::user()->type!="corporate")
                     @if(in_array('course_manage_certificates',$permissions) || Auth::user()->type=="admin")
                <a href="{{ route('certificate.addcertificate') }}" class="btn btn-sm btn btn-primary float-right mr-2 m-0">
        <span class="btn-inner--text ">{{__('Manage Certificate')}}</span>
    </a>
	
		 <a href="{{ url('certify/student/list') }}" id="back" class="btn btn-sm btn-primary float-right  mr-2 m-0 ">
        <span class="btn-inner--icon"> {{__('Students Enrolled')}}</span>
    </a>
                     @endif
                     
                   
                       @if(in_array('course_manage_instructors',$permissions) || Auth::user()->type=="admin")
                <a href="{{ route('instructor.index') }}" class="btn btn-sm btn btn-primary float-right mr-2 m-0">
        <span class="btn-inner--text ">{{__('Instructor')}}</span>
    </a>
                       @endif
                       
                        @if(in_array('course_corporate_payments',$permissions))
                <a href="{{ route('certify.payments') }}" class="btn btn-sm btn btn-primary float-right mr-2 m-0">
        <span class="btn-inner--text ">{{__('Payments')}}</span>
    </a>
                        @endif
                    
                    
   @if(in_array('course_create_regular',$permissions) && in_array('course_create_master_class',$permissions))
        @if($type == 'Masterclass')
        
        
              <a href="{{ route('certify.index','type=Regular') }}" class="btn btn-sm btn btn-primary float-right mr-2 m-0">
        <span class="btn-inner--text ">{{__('Regular')}}</span>
    </a>
       
        
        @else
           <a href="{{ route('certify.index','type=Masterclass') }}" class="btn btn-sm btn btn-primary float-right mr-2 m-0">
        <span class="btn-inner--text ">{{__('Masterclass')}}</span>
    </a>
          
        @endif
    @endif
    @endif
	
	
        @if($authuser->type == 'admin' || $authuser->type == 'mentor' )
    <div class="btn-group float-right mr-2">
        <button data-title="{{__('Manage Certify')}}" type="button" class="btn btn-primary dropdown-toggle btn btn-sm" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><span class="btn-inner--icon"><i class="fas fa-plus"></i></span></button>
        <div class="dropdown-menu">
            @if(in_array('course_create_regular',$permissions) || Auth::user()->type=="admin")
            <a class="dropdown-item" href="{{ route('certify.create') }}">{{__('Regular Course')}}</a>
            @endif
             @if(in_array('course_create_master_class',$permissions))
            <a class="dropdown-item" href="{{ route('certify.masterclass.create') }}">{{__('Masterclass')}}</a>
            @endif
            @if(in_array('course_marketplace',$permissions))
            <!--<a class="dropdown-item" href="{{ route('certify.marketplace') }}">{{__('Marketplace')}}</a>-->
            @endif
             @if(in_array('course_syndicate',$permissions))
            <div class="dropdown-divider"></div>
            <a class="dropdown-item" data-val="created_at-asc" href="{{ url('certify/syndicate') }}">{{__('Syndicate')}}</a>
            <a class="dropdown-item"  href="{{ route('certify.syndicate.revenue') }}">{{__('Syndicate Revenue')}}</a>
            @endif
        </div>
    </div>
	  
       
    @endif
    
    
    
                     </div>
   
<!-- Breadcrumb -->
<div class="breadcrumb-bar mt-3">
    <div class="container-fluid">
        <div class="row align-items-center">
            <div class="col-md-12 col-12">
                <h2 class="breadcrumb-title">Courses<sup><small>({{date('F')}})</small></sup></h2>
                <nav aria-label="breadcrumb" class="page-breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{route('dashboard')}}">Home</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Courses</li>
                    </ol>
                </nav>
            </div>              
        </div>            
    </div>
</div>
<!-- /Breadcrumb -->

    @if($authuser->type == 'admin' ||$authuser->type == 'mentor')
<div class="row mt-3">
                    <div class="col-md-12 col-lg-4 dash-board-list blue">
                        <div class="dash-widget">
                            <div class="circle-bar">
                                <div class="icon-col">
                                    <i class="fas fa-calendar-check"></i>
                                </div>
                            </div>
                            <div class="dash-widget-info">
                                <h3>{{$CertifiesCount}}</h3>
                                <h6>{{__('Courses')}}</h6>															
                            </div>
                        </div>
                    </div>

                    

                    <div class="col-md-12 col-lg-4 dash-board-list pink">
                        <div class="dash-widget">
                            <div class="circle-bar">
                                <div class="icon-col">
                                    <i class="fas fa-users"></i>
                                </div>
                            </div>
                            <div class="dash-widget-info">
                                <h3>{{$student}}</h3>
                                <h6>{{__('Students')}}</h6>															
                            </div>
                        </div>
                    </div>
                    <div class="col-md-12 col-lg-4 dash-board-list yellow">
                        <div class="dash-widget">
                            <div class="circle-bar">
                                <div class="icon-col">
                                    <i class="fas fa-money-bill-alt "></i>
                                </div>
                            </div>
                            <div class="dash-widget-info">
                                <h3>${{number_format((float)$income, 2, '.', '')}}</h3>
                                <h6>{{__('Income')}}</h6>															
                            </div>
                        </div>
                    </div>
                </div>
				
				@endif

<br>


<div class="row" id="certifyView">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                     <div class="table-md-responsive">                    
                    <table class="table  table-hover table-center mb-0" id="yajra-datatable">
                        <thead class="thead-light ">
                            
                   
                            <tr>
                                <th> {{__('Name')}}</th>
                                <th> {{__('Price')}}</th>
                                <th> {{__('Duration')}}</th>
                                <th> {{__('Status')}}</th>
				                <th> {{__('Category')}}</th>
                                <th> {{__('Action')}}</th>
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
    <!-- Modal -->
        <div class="modal fade custom-model-class" id="addCertify" role="dialog" style="display: none;" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Are You Sure?</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <div class="modal-body">
                    Add <p id="CourName"></p> in MyCourses.<br>
                    This action can not be undone. Do you want to continue?
                </div>
                <div class="modal-footer">
                    {{ Form::open(['url' => 'certify/corpurate/add/certify','id' => 'addCertifyCorpurate','enctype' => 'multipart/form-data']) }}
                    <input type="hidden" name="corpurate_certify" id="corpurate_certify" value="">

                    <button type="submit" class="btn btn-sm btn-danger rounded-pill" id="">Yes</button>
                    {{ Form::close() }}
                    <button type="button" class="btn btn-sm btn-secondary rounded-pill" id="" data-dismiss="modal"
                            aria-label="Close">Cancel
                    </button>
                </div>
            </div>
        </div>
    </div>
    <!-- Modal -->
    <div id="addedCertify" class="modal fade" role="dialog">
        <div class="modal-dialog">
            <!-- Modal content-->
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Alert !</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <div class="modal-body">
                    you already added this course.
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
<div class="modal fade" id="verifyCertCorrporate" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
     aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">{{__('Verify Cert')}}</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-bodyc text-center">
                <p class="text-muted mb-0">{{__('Verify a certificate by entering the 6 digit Cert Code on the certificate. Or call ')}}
                    <strong class="text-primary">{{mobileNumberFormat(env('CERTIFICATE_TWILIO_NUMBER'))}}</strong></p>
                <form method="POST" action="{{ route('verify.cert.post') }}">
                    @csrf
                    <div class="row text-center">
                        <div class="form-group" style="margin: auto;width: 50%;">
                            <label class="form-control-label">{{__('Certificate Code')}}</label>
                            <input type="number" class="form-control" minlength="6" maxlength="6" size="10"
                                   name="cert_code" value="" required
                                   autofocus>
                        </div>
                    </div>
                    <div class="mt-4">
                        <button type="submit" class="btn btn-sm btn-primary">
                            <span class="btn-inner--text">{{__('Verify Now')}}</span>
                            <span class="btn-inner--icon"></span>
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<!-- Modal -->
<!-- Modal -->
<div id="destroyblog" class="modal fade" role="dialog">
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
          {{ Form::open(['url' => 'certify/destroy','id' => 'destroy_blog','enctype' => 'multipart/form-data']) }}
          <input type="hidden" name="certify_Id" id="blog_id"  value="">

        <button type="submit" class="btn btn-sm btn-danger rounded-pill" id="">Yes</button>
        {{ Form::close() }}
        <button type="button" class="btn btn-sm btn-secondary rounded-pill" id="" data-dismiss="modal" aria-label="Close">Cancel</button>
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
        ajax: "{{ route('corporate.certify.index') }}",
        columns: [
            //{data: 'DT_RowIndex', name: 'DT_RowIndex'},
            {data: 'name', name: 'name',orderable: true,searchable: true},
            {data: 'price', name: 'price',orderable: true},
            {data: 'duration', name: 'duration',orderable: false},
			{data: 'status', name: 'status',orderable: false},
			{data: 'exp_date', name: 'exp_date',orderable: false},
            
            {
                data: 'action',
                name: 'action',
                orderable: false,
                searchable: false
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
    <script>
//        CKEDITOR.replace('summary-ckeditor');

        $(document).on("click", ".addCertify", function () {
            var id = $(this).attr('data-id');
            var title = $(this).attr('data-title');
            $("#corpurate_certify").val(id);
          
			$("#CourName").html('<b>'  + title + '</b>');
            $('#addCertify').modal('show');
            $('.modal-open').removeClass('modal-open');

        });
        $(document).on("click", ".destroyCertify", function () {
            var id = $(this).attr('data-id');
            $("#certify_Id").val(id);
            $('#destroyCertify').modal('show');

        });
        $(document).on("click", ".notDestroy", function () {
            $('#notDestroy').modal('show');
        });
        $(document).on("click", ".addedCertify", function () {
            $('#addedCertify').modal('show');
        });
    </script>
    <script>
        function showModal() {
            $('body').loadingModal({text: 'loading...'});
            var delay = function (ms) {
                return new Promise(function (r) {
                    setTimeout(r, ms)
                })
            };
            var time = 1000000;
            delay(time)
                .then(function () {
                    $('body').loadingModal('animation', 'circle').loadingModal('backgroundColor', 'black');
                    return delay(time);
                })
                .then(function () {
                    $('body').loadingModal('destroy');
                });
        }

        $("#create_certify").submit(function (event) {
            alert('hi');
            showModal();
        });

    </script>
@endpush
