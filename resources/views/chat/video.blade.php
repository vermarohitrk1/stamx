<?php $page = "Video chat"; ?>
@extends('layout.dashboardlayout')
@section('content')	
<style>
table#example {
    width: 100% !important;
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
<!--               <a href="{{ route('chat.group.create') }}" class="btn btn-sm btn btn-primary float-right "  data-title="{{__('Add Group')}}">
        <span class="btn-inner--icon"><i class="fas fa-plus"></i></span>
    </a>-->
                
                     </div>
   
<!-- Breadcrumb -->
<div class="breadcrumb-bar mt-3">
    <div class="container-fluid">
        <div class="row align-items-center">
            <div class="col-md-12 col-12">
                <h2 class="breadcrumb-title">Video Chat</h2>
                <nav aria-label="breadcrumb" class="page-breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{route('dashboard')}}">Home</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Video Chat</li>
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
                 {!! Form::open(['route' => 'video.chat.create.room']) !!}
       {!! Form::label('roomName', 'Create or Join a Video Chat Room') !!}
       {!! Form::text('roomName') !!}
       {!! Form::submit('Go') !!}
   {!! Form::close() !!}

   @if($rooms)
   @foreach ($rooms as $room)
       <a href="{{ url('/room/join/'.$room) }}">{{ $room }}</a>
   @endforeach
   @endif
                
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



@endpush