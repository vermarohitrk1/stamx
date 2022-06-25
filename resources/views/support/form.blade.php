<?php $page = "Help Desk Categories"; ?>
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
                  
             
                     <a href="{{ route('support.index') }}" class="btn btn-sm btn btn-primary float-right mr-1" >
        <span class="btn-inner--icon"><i class="fas fa-reply"></i></span>
    </a>
              
                     </div>
                
   <!-- Breadcrumb -->
                <div class="breadcrumb-bar mb-3">
                    <div class="container-fluid">
                        <div class="row align-items-center">
                            <div class="col-md-12 col-12">
                                <h2 class="breadcrumb-title">Raise a ticket</h2>
                                <nav aria-label="breadcrumb" class="page-breadcrumb">
                                    <ol class="breadcrumb">
                                        <li class="breadcrumb-item"><a href="{{route('dashboard')}}">Dashboard</a></li>
                                        <li class="breadcrumb-item active" aria-current="page">Help Desk Create Ticket</li>
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
           {{ Form::open(['route' => 'support.store','id' => 'new_input_form', 'name' => 'new_input_form','enctype' => 'multipart/form-data']) }}
                <div class="card-header">
                  @if((!empty($entity_type) && $entity_type=="Shop Order" && !empty($entity_id)) || (!empty($data) && $data->entity_type=="Shop Order"))
                     <input type="hidden" name="entity_type" value="{{$entity_type??''}}" />
                     <input type="hidden" name="entity_id" value="{{$entity_id??''}}" />
                     <input type="hidden" name="entity_for" value="{{$entity_for??''}}" />
                     
                    <div class="form-group">
                        <div class="row">
                            <div class="col-md-12">
                                @php
                                if(!empty($data->entity_id)){
                                $entity_id=$data->entity_id;
                                }
                                $order=\App\ProductOrder::find($entity_id);
                                $payment= \App\UserPayment::where('order_id',$order->cart_id)->first();
                                @endphp
                                <label class="form-control-label">Support ticket for shop order# <a class="text-info" href="{{route('payment.invoice',encrypted_key($payment->id,'encrypt'))}}">{{$payment->order_id}}</a></label>
                                
                            </div>
                        </div>
                    </div> 
                    @endif
                    
                </div>
                <div class="card-body">

                   
                    <input type="hidden" name="id" value="{{!empty($data->id) ? encrypted_key($data->id,'encrypt') :0}}" />
                    <input type="hidden" name="csrf-token" value="<?= csrf_token(); ?>" />
                    @if ($errors->any())
                    <div class="alert alert-danger">
                        <ul>
                            @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                    @endif

                    
                    <div class="form-group">
                        <div class="row">
                            <div class="col-md-12">
                                <label class="form-control-label">Choose a category:</label>
                                <select class="form-control" name="category">
                                    @if(!empty($categories))
                                    @foreach($categories as $category)
                                    <option {{!empty($data->category_id) && $data->category_id==$category->id  ? 'selected' :''}} value="{{ $category->id }}">{{ $category->name }}</option>
                                    @endforeach
                                    @endif
                                </select>
                                <small class="text-muted mb-0">{{__('Compose your message in details with relevent category.')}}</small>
                            </div>            
                        </div>
                    </div>
                    
                    <div class="form-group">
                        <div class="row">
                            <div class="col-md-12">
                                <label class="form-control-label">Subject</label>
                                <input id="get_matching_faqs" type="text" class="form-control " name="subject" value="{{ !empty($data->subject) ? $data->subject : ""}}" minlength="20" maxlength="200" placeholder="Enter subject of your ticket.." required>
                            </div>
                        </div>
                    </div> 
                    <div class="form-group">
                        <div class="row">
                            <div class="col-md-12" id="matching_faqs">
                                
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="row">
                            <div class="col-md-12">
                                <label class="form-control-label">Message</label>
                                <textarea id="summary-ckeditor"  class="form-control"  name="message" placeholder="Your detailed message.." rows="10" minlength="50" maxlength="500" required=""  >{{!empty($data->message) ? $data->message :''}}</textarea>
                            </div>
                        </div>
                    </div>
                   
                    <div class="form-group">
                        <div class="row">
                            <div class="col-md-12">
                                {{ Form::label('image', __('Attach File (optional)'),['class' => 'form-control-label']) }}
                                <input type="file" name="file" id="file" class="custom-input-file" accept="pdf,txt,.doc,.docx,application/msword,application/vnd.openxmlformats-officedocument.wordprocessingml.document,image/*"/>
                                <label for="file">
                                    <i class="fa fa-upload"></i>
                                    <span>{{__('Choose a file max 2MB size…')}}</span>
                                </label>
                            </div>
                        </div>
                    </div>
                    <div class="text-right">
                        {{ Form::button(__('Create'), ['type' => 'submit','class' => 'btn btn-sm btn-primary rounded-pill']) }}
                    
                    </div>
                  

                </div>
             {{ Form::close() }}
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


<script>
   $(document).on("focusout", "#get_matching_faqs", function(event){
          var sub = $(this).val();
       
          if (sub != '') {
              var data = {
        subject:sub,
            _token: "{{ csrf_token() }}",
    }
    $.post(
            "{{route('support.matching.faqs')}}",
            data,
            function (data) {
           $('#matching_faqs').html(data);

            }
    );
              
              
           
          }

         });
</script>
<style>
    .bs-example{
        margin: 20px;
    }
    .accordion .fa{
        margin-right: 0.5rem;
      	font-size: 24px;
      	font-weight: bold;
        position: relative;
    	top: 1px;
    }
</style>

<script>
    $(document).ready(function(){
        // Add down arrow icon for collapse element which is open by default
        $(".collapse.show").each(function(){
        	$(this).prev(".card-header").find(".fa").addClass("fa-angle-down").removeClass("fa-angle-right");
        });
        
        // Toggle right and down arrow icon on show hide of collapse element
        $(".collapse").on('show.bs.collapse', function(){
        	$(this).prev(".card-header").find(".fa").removeClass("fa-angle-right").addClass("fa-angle-down");
        }).on('hide.bs.collapse', function(){
        	$(this).prev(".card-header").find(".fa").removeClass("fa-angle-down").addClass("fa-angle-right");
        });
    });
</script>
@endpush
