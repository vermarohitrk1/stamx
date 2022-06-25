<?php $page = "Edit"; ?>
@section('title')
    {{$page??''}}
@endsection
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
                <div class=" col-md-12 ">
         
                    
                     <a href="{{ route('meeting.schedules.index') }}" class="btn btn-sm btn-primary float-right btn-icon-only rounded-circle " >
        <span class="btn-inner--icon"><i class="fas fa-reply"></i></span>
    </a>
                     </div>
   
<!-- Breadcrumb -->
<div class="breadcrumb-bar mt-3">
    <div class="container-fluid">
        <div class="row align-items-center">
            <div class="col-md-12 col-12">
                <h2 class="breadcrumb-title">Edit Meeting Schedule</h2>
                <nav aria-label="breadcrumb" class="page-breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{route('dashboard')}}">Home</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('meeting.schedules.index') }}">Meeting Schedules</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Edit Meeting Schedule</li>
                    </ol>
                </nav>
            </div>              
        </div>            
    </div>
</div>
<!-- /Breadcrumb -->

<div class="row mt-3" id="blog_category_view">
  
  <!-- list view -->
  <div class="col-12">
      <div class="card">
          <div class="card-body">
              {{ Form::open(['route' =>'meeting.schedule.update','id' => 'create_contact','enctype' => 'multipart/form-data']) }}

<div class="form-group">
        <div class="row">
            <div class="col-md-12">
                <label class="form-control-label">Title</label>
                <input type="text" class="form-control" name="title" value="{{$data->title}}" placeholder="Title" required>
                <input type="hidden" class="form-control" value="{{$data->id}}" name="id"  required>
                <input type="hidden" name="csrf-token" value="<?=csrf_token();?>" />
            </div>
        </div>
    </div>

<div class="form-group">
        <div class="row">
            <div class="col-md-12">
                <label class="form-control-label">Service Type</label>
                <select class="form-control" id="service_type_id" name="service_type_id">
                    @foreach($type as $i=>$row)
                        <option @if($data->service_type_id==$i) selected @endif value="{{$i}}"  >{{$row}}</option>
                    @endforeach
                </select>
            </div>
        </div>
    </div>
<div class="form-group" id="service_id_div">
        <div class="row">
            <div class="col-md-12">
                <label class="form-control-label">Select Course</label>
                <select class="form-control" id="service_id" name="service_id" >
                    <option value=""  >Please select</option>
                    @foreach($courses as $row)
                        <option @if($data->service_id==$row->id) selected @endif value="{{$row->id}}"  >{{$row->name}}</option>
                    @endforeach
                </select>
            </div>
        </div>
    </div>
<div class="form-group">
        <div class="row">
            <div class="col-md-12">
                <label class="form-control-label">Write Service Description</label>
                <textarea class="form-control" id="summary-ckeditor" name="description" placeholder="Please describe your meeting service" rows="5" required>{{$data->description}}</textarea>
            </div>
        </div>
    </div>
    
    <div class="form-group">
        <div class="row">
            <div class="col-md-12">
                <label class="form-control-label">How much price($) will you charge?</label>
                <input type="number" class="form-control" value="{{$data->price}}" name="price" min="0" step="any" placeholder="$0.00" >
            </div>
        </div>
    </div>
    <div class="form-group">
        <div class="row">
            <div class="col-md-12">
                <label class="form-control-label">Please explain your charges. (Optional)</label>
                <textarea class="form-control" id="summary-ckeditor1" name="price_description" placeholder="Video call charges $50 included." rows="3" >{{$data->price_description}}</textarea>
            </div>
        </div>
    </div>
    <div class="form-group">
        <div class="row">
            <div class="col-md-12">
                <label class="form-control-label">Status</label>
                <select class="form-control" name="status">
                    <option @if($data->status=="Active") selected @endif value="Active">Active</option>
                    <option @if($data->status=="InActive") selected @endif value="InActive">InActive</option>
                </select>
            </div>
        </div>
    </div>
    



<div class="text-right">
    {{ Form::button(__('Save'), ['type' => 'submit','class' => 'btn btn-sm btn-primary rounded-pill']) }}
    <a href="{{ route('meeting.schedules.index') }}" class="btn btn-sm btn-secondary rounded-pill" >{{__('Cancel')}}</a>
</div>
{{ Form::close() }}


          </div> 	
      </div>
  </div> 
    <!-- list view -->
</div>
    

            </div>
        </div>

    </div>

</div>		
<!-- /Page Content -->
@endsection

@push('script')

<script src="{{ asset('public/ckeditor/ckeditor.js') }}"></script>
<script>
CKEDITOR.replace('summary-ckeditor');
CKEDITOR.replace('summary-ckeditor1');
$('#service_id_div').hide();
    
    $(document).on("change","#service_type_id",function() {
         var value = this.value;
        if(value==2){
            
            $('#service_id_div').show();
            $('#service_id').attr("required", true);
           
        }else{
             $('#service_id_div').hide();
            $('#service_id').attr("required", false);
            $('#service_id').val('');
        }
    });
</script>



@endpush