<?php $page = "plan"; ?>
@extends('layout.dashboardlayout')
@section('content')
<style>
.card {
    box-shadow: 0 10px 30px 0 rgb(24 28 33 / 26%) ;
}
.nav-pills .nav-link.active, .nav-pills .show>.nav-link {
    color: #fff;
    background-color: #009da6;
}
.nav-pills .nav-link {

    background: #f6f6f6;
    color: #009da6;
}
ul.nav.nav-pills.nav-fill.navtop {
    width: 40%;
    margin: auto;
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
               <a href="{{ route('plans.create') }}" class="btn btn-sm btn btn-primary float-right "  data-title="{{__('Add Plan')}}">
        <span class="btn-inner--icon"><i class="fas fa-plus"></i></span>
    </a>


		    <a href="{{ route('plans.addons') }}" class="btn btn-sm btn btn-primary float-right mr-2 m-0">
        <span class="btn-inner--text ">{{__('Add-ons')}}</span>
    </a>

	      <a  href="{{ route('url.identifiers.index') }}"
           class="btn btn-sm btn btn-primary float-right mr-2 m-0">
            <span class="btn-inner--text">{{__('Url Identifiers')}}</span>
        </a>


                     </div>

<!-- Breadcrumb -->
<div class="breadcrumb-bar mt-3">
    <div class="container-fluid">
        <div class="row align-items-center">
            <div class="col-md-12 col-12">
                <h2 class="breadcrumb-title">Plans</h2>
                <nav aria-label="breadcrumb" class="page-breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="index">Home</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Plans</li>
                    </ol>
                </nav>
            </div>
        </div>
    </div>
</div>
<!-- /Breadcrumb -->



<br>


<div class="row" id="">


<div class="container">
	<ul class="nav nav-pills nav-fill navtop">
        <li class="nav-item">
            <a class="nav-link " href="#Weekly" data-toggle="tab">Weekly</a>
        </li>
        <li class="nav-item">
            <a class="nav-link active" href="#Monthly" data-toggle="tab">Monthly</a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="#Yearly" data-toggle="tab">Yearly</a>
        </li>
    </ul>
    <div class="tab-content ">
        <div class="tab-pane " role="tabpanel" id="Weekly">

           	<div class="row">
		   @foreach ($plans as $key => $plan)

            <div class="col-12 col-md-3">
                <div class="card card-pricing popular text-center px-3 mb-5 mb-lg-0">
                    <span
                        class="h6 w-60 mx-auto px-4 py-1 rounded-bottom bg-primary text-white">{{ $plan->name }}</span>

					     <a href="{{route('plans.edit',$plan->id)}}" class="dropdown-item" data-toggle="tooltip" data-original-title="{{__('Edit')}}">{{__('Edit')}}</a>
                    <a href="javascript::void(0);" class="action-item text-danger px-2 destroyCertify delete_record_model"
                       data-id="{{$plan->id}}" data-url="{{ route('plans.destroy',$plan->id)}}" data-toggle="tooltip" data-original-title="{{__('Delete')}}">
                        Delete
                    </a>

                <br>
                    @if(\Auth::user()->type == 'admin')
                        <a href="#" class="dropdown-item" data-ajax-popup="true" data-size="lg"
                           data-title="{{__('Add Modules')}}" data-url="{{route('plans.addmodules',$plan->id)}}"><i
                                class="mdi mdi-pencil mr-1"></i>{{__('Modules')}}</a>
                    @endif
                    @if(\Auth::user()->type == 'admin')

                    @endif
                    <div class="card-header py-5 border-0">
                        <div class="h1 text-primary text-center mb-0" data-pricing-value="{{ $plan->price }}"
                             style="display: flex;align-items: baseline;justify-content: center;">
                            {{(env('CURRENCY') ? env('CURRENCY') : '$')}}
                            <span class="price">

                                    {{ $plan->weekly_price }}

                            </span>
                            <span class="h6 ml-2">/ Week</span>
                        </div>
                        <div>
                            + {{(env('CURRENCY') ? env('CURRENCY') : '$')}}{{ $plan->setup_fee }} {{__('Setup Fee')}}</div>
                    </div>
                    <div class="card-body delimiter-top">
                        <ul class="list-unstyled mb-4">

                            <li>
                                @if($plan->description)
                                    <small>{{$plan->description}}</small>
                                @endif
                            </li>
                        </ul>
                        <ul class="list-unstyled mb-4">


                        </ul>
                    </div>

                </div>
            </div>


        @endforeach

		</div>
		</div>
        <div class="tab-pane active" role="tabpanel" id="Monthly">
		<div class="row">
		   @foreach ($plans as $key => $plan)


            <div class="col-12 col-md-3">
                <div class="card card-pricing popular text-center px-3 mb-5 mb-lg-0">
                    <span
                        class="h6 w-60 mx-auto px-4 py-1 rounded-bottom bg-primary text-white">{{ $plan->name }}</span>

					     <a href="{{route('plans.edit',$plan->id)}}" class="dropdown-item" data-toggle="tooltip" data-original-title="{{__('Edit')}}">{{__('Edit')}}</a>
                         <a href="javascript::void(0);" class="action-item text-danger px-2 destroyCertify delete_record_model"
                       data-id="{{$plan->id}}" data-url="{{ route('plans.destroy',$plan->id)}}" data-toggle="tooltip" data-original-title="{{__('Delete')}}">
                        Delete
                    </a>
                <br>
                    @if(\Auth::user()->type == 'admin')
                        <a href="#" class="dropdown-item" data-ajax-popup="true" data-size="lg"
                           data-title="{{__('Add Modules')}}" data-url="{{route('plans.addmodules',$plan->id)}}"><i
                                class="mdi mdi-pencil mr-1"></i>{{__('Modules')}}</a>
                    @endif
                    @if(\Auth::user()->type == 'admin')

                    @endif
                    <div class="card-header py-5 border-0">
                        <div class="h1 text-primary text-center mb-0" data-pricing-value="{{ $plan->price }}"
                             style="display: flex;align-items: baseline;justify-content: center;">
                            {{(env('CURRENCY') ? env('CURRENCY') : '$')}}
                            <span class="price">

                                    {{ $plan->monthly_price }}

                            </span>
                            <span class="h6 ml-2">/ Month</span>
                        </div>
                        <div>
                            + {{(env('CURRENCY') ? env('CURRENCY') : '$')}}{{ $plan->setup_fee }} {{__('Setup Fee')}}</div>
                    </div>
                    <div class="card-body delimiter-top">
                        <ul class="list-unstyled mb-4">

                            <li>
                                @if($plan->description)
                                    <small>{{$plan->description}}</small>
                                @endif
                            </li>
                        </ul>
                        <ul class="list-unstyled mb-4">


                        </ul>
                    </div>

                </div>
            </div>


        @endforeach
 </div>

		</div>
        <div class="tab-pane" role="tabpanel" id="Yearly">

			<div class="row">
		    @foreach ($plans as $key => $plan)

            <div class="col-12 col-md-3">
                <div class="card card-pricing popular text-center px-3 mb-5 mb-lg-0">
                    <span
                        class="h6 w-60 mx-auto px-4 py-1 rounded-bottom bg-primary text-white">{{ $plan->name }}</span>

					     <a href="{{route('plans.edit',$plan->id)}}" class="dropdown-item" data-toggle="tooltip" data-original-title="{{__('Edit')}}">{{__('Edit')}}</a>
                         <a href="javascript::void(0);" class="action-item text-danger px-2 destroyCertify delete_record_model"
                            data-id="{{$plan->id}}" data-url="{{ route('plans.destroy',$plan->id)}}" data-toggle="tooltip" data-original-title="{{__('Delete')}}">
                                Delete
                            </a>
                <br>
                    @if(\Auth::user()->type == 'admin')
                        <a href="#" class="dropdown-item" data-ajax-popup="true" data-size="lg"
                           data-title="{{__('Add Modules')}}" data-url="{{route('plans.addmodules',$plan->id)}}"><i
                                class="mdi mdi-pencil mr-1"></i>{{__('Modules')}}</a>
                    @endif
                    @if(\Auth::user()->type == 'admin')
                        <!--<a href="#" class="dropdown-item" data-ajax-popup="true" data-size="lg"
                           data-title="{{__('Manage')}}" data-url="{{route('plans.modules.manager',$plan->id)}}"><i
                                class="fa fa-bars"></i> {{__(' Manage')}}</a>-->
                    @endif
                    <div class="card-header py-5 border-0">
                        <div class="h1 text-primary text-center mb-0" data-pricing-value="{{ $plan->price }}"
                             style="display: flex;align-items: baseline;justify-content: center;">
                            {{(env('CURRENCY') ? env('CURRENCY') : '$')}}
                            <span class="price">
                                    {{ $plan->annually_price }}

                            </span>
                            <span class="h6 ml-2">/ Year</span>
                        </div>
                        <div>
                            + {{(env('CURRENCY') ? env('CURRENCY') : '$')}}{{ $plan->setup_fee }} {{__('Setup Fee')}}</div>
                    </div>
                    <div class="card-body delimiter-top">
                        <ul class="list-unstyled mb-4">

                            <li>
                                @if($plan->description)
                                    <small>{{$plan->description}}</small>
                                @endif
                            </li>
                        </ul>
                        <ul class="list-unstyled mb-4">


                        </ul>
                    </div>

                </div>
            </div>


        @endforeach
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
        ajax: "{{ url('/book') }}",
        columns: [
            //{data: 'DT_RowIndex', name: 'DT_RowIndex'},
            {data: 'image', name: 'image',orderable: false,searchable: false},
            {data: 'title', name: 'title'},
            {data: 'category', name: 'category'},
            {data: 'status', name: 'status'},
            {
                data: 'action',
                name: 'action',
                orderable: false,
                searchable: false
            },
        ]
    });

  });
</script>

@endpush
