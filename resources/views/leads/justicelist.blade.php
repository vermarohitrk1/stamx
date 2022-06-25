<?php $page = "book"; ?>
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
            <div class="col-md-12 col-lg-12 col-xl-12">
              <a href="{{ url()->previous() }}" id="back" class="btn btn-sm btn-primary float-right ml-2">
                  <span class="btn-inner--icon"><i class="fas fa-reply"></i></span>
             </a>
          </div>
   
                <!-- Breadcrumb -->
                <div class="breadcrumb-bar mt-3">
                    <div class="container-fluid">
                        <div class="row align-items-center">
                            <div class="col-md-12 col-12">
                                <h2 class="breadcrumb-title">Justice involved</h2>
                                <nav aria-label="breadcrumb" class="page-breadcrumb">
                                    <ol class="breadcrumb">
                                        <li class="breadcrumb-item"><a href="index">Home</a></li>
                                        <li class="breadcrumb-item active" aria-current="page">Justice</li>
                                    </ol>
                                </nav>
                            </div>              
                        </div>            
                    </div>
                </div>
                <!-- /Breadcrumb -->



            <div class="col-md-12 col-lg-12 col-xl-12 no_padding">
       
                     <div class="card">
                            <div class="card-body">
                                <div class="table-md-responsive">
                                <!-- data -->
                                <table  style="width:100%;" class="table table-hover table-center mb-0" id="example">
                        <thead class="thead-light">
                        <tr>
                            <th class=" mb-0 h6 text-sm"> {{__('Name')}}</th>
                            <th class="text-left name mb-0 h6 text-sm"> {{__('Action')}}</th>
                        </tr>
                        </thead> 
                        <tbody>
       
                        @foreach($data as $key => $course)
                        <tr>
                   
                   
                                 <td class=" mb-0 h6 text-sm"> {{ $course->name }}</td>
                               <td class="text-left name mb-0 h6 text-sm"><div class="status-toggle">
                                       <input  type="checkbox" data-sid="0" id="status_{{ $key }}" data-type="justice" data-corporate="{{ $course->id }}"  data-value="{{ $course->id }}" class="check checklead"
                                       @if(!$lead->isEmpty())
@foreach($lead as $data)
@if($data->corporate_id == $course->id)
checked data-sid="{{ $data->id }}"
@endif
@endforeach
@endif
                                       value="1"   >
                                       <label for="status_{{ $key }}" class="checktoggle">checkbox</label>
                                      </div>
                                 </td>
             
                        </tr>
                        @endforeach
                      
                        </tbody>
                        
                    </table>
                                <!-- data -->
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


  $(document).on("click",".checklead",function() {
    
    var type = $(this).data('type');
    var corporateid = $(this).data('corporate');
    var sid = $(this).data('sid');
    if(sid == undefined){
        sid =0;
    }
   // alert(sid);
        if ($(this).is(":checked")) {
         var status = $(this).val();
          }
        else{
        var status = 0;
        
        }
       
        var data = {
                        status: status,
                        corporateid: corporateid,
                       type: type,
                       sid:sid
                        
                    }
                 $.ajax({
                url: '{{ route('lead.change.status') }}',
                data: data,
                success: function (data) {
                    location.reload();
                     
                }
            });
    
});
  </script>
  
@endpush