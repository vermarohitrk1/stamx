<?php $page = "Help Desk Categories"; ?>
@extends('layout.dashboardlayout')
@section('content')	
 @if(Auth::user()->id ==$data->submitted_to_id) <?php $support_user=1; ?>  @endif
 
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
                                <h2 class="breadcrumb-title">Ticket#{{$data->ticket??''}}</h2>
                                <nav aria-label="breadcrumb" class="page-breadcrumb">
                                    <ol class="breadcrumb">
                                        <li class="breadcrumb-item"><a href="{{route('dashboard')}}">Dashboard</a></li>
                                        <li class="breadcrumb-item active" aria-current="page">Ticket View</li>
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
          <div class="row">
    <div class="col-lg-4 order-lg-2">
        <div class="card hover-shadow-lg">
            <div class="card-header border-0 px-3">
                <div class="text-right mt-2">
                    <span class="badge badge-xs badge-info badge-pill">{{$data->user->type??''}}</span>
                </div>
            </div>
            <div class="card-body text-center">
                <div class="avatar-parent-child avatar rounded-circle avatar-lg">
                    <img  src="{{ Auth::user()->getAvatarUrl($data->user_id) }}" class="avatar rounded-circle avatar-lg">
                </div>
                <h5 class="h6 mt-4 mb-0">
                    <a href="#">{{ $data->user->name??'' }}</a>
                </h5>
                <p class="d-block text-sm text-muted mb-3">{{ $data->subject }}</p>
                   @if(!empty($data->entity_type) && $data->entity_type=="Shop Order")
                                @php
                                if(!empty($data->entity_id)){
                                $entity_id=$data->entity_id;
                                }
                                $order=\App\ProductOrder::find($entity_id);
                                $payment= \App\UserPayment::where('order_id',$order->cart_id)->first();
                                @endphp
                                <p class="form-control-label">Support ticket for shop order# <a class="text-info" href="{{route('payment.invoice',encrypted_key($payment->id,'encrypt'))}}">{{$payment->order_id}}</a></p>
                                @endif
            </div>

            <div class="card-footer">
                <div class="actions d-flex justify-content-between">
                    <a href="#"   data-size="md" title="{{ __("Ticket Status")}}" class="action-item">
                       <span class="text-xs text-right text-muted">
                                        @if($data->status == "Support Reply")
                                        <span class="badge badge-primary">Support Reply</span>
                                        @elseif($data->status == "New" || $data->status == "Customer Reply")
                                        <span class="badge badge-danger">{{ $data->status }}</span>
                                        @else
                                        <span class="badge badge-success">Closed</span>
                                        @endif</span>
                    </a>
                    <a href="#"  data-size="md" data-title="{{__("Created At")}}" class="action-item">
                        <p title="Last update on" class="pull-right text-right text-primary">{{ time_elapsed($data->updated_at) }}</p>
                    </a>
                </div>
            </div>
        </div>
    </div>
   <div class="col-lg-8 order-lg-1">
        @if(!empty($messages))
        <div id="tabs-1" class="tabs-card">
            <div class="card">
                <div class="card-header">
                    <h5 class=" h6 mb-0">{{__('')}}</h5>
                    <div class="card-body">

                        <div class="row">
                            <div class="col-md-12 mt-3">
                                <h6><span class="badge badge-pill badge-sm badge-primary mb-3" title="Category">{!! $data->category->name??'' !!}</span></h6>
                             
                                {!! html_entity_decode($data->subject, ENT_QUOTES, 'UTF-8') !!}

                            </div>
                          
                           
                         

                            <div class="col-md-12">
                                <div class="actions d-flex justify-content-between px-4">
                                    <span class="text-left badge badge-sm text-success ">

                                </div>
                            </div>
                            @if(!empty($messages))                                    
                            @foreach($messages as $row)
                            <div class="col-md-12">
                                <div class="card hover-shadow-lg">        
                                    <div class="card-footer">                                        
                                         
                                        <div class="actions d-flex justify-content-between">
                                                <p   data-size="md" class="action-item">
                                                    <span class="avatar rounded-circle avatar-lg">
                                                        <img src="{{ Auth::user()->getAvatarUrl($row->user_id) }}"  class="avatar rounded-circle avatar-lg ">
                                                    </span>
                                                    <span class="btn-inner--icon text-primary"><b>{{$row->user->name??''}}</b></span> 
                                                </p>
                                            <p   data-size="md" class="action-item pull-right">
                                                 <span class="badge badge-pill badge-info">{{ucfirst($row->user->type??'')}}</span> 
                                                </p>
                                           
                                        </div>    
                                         <div class="card-footer">
                                        <div class="actions d-flex justify-content-between">
                                               <span class="d-block text-sm text-muted ">{{ $row->message }}</span>
                                        </div>
                                             @if(!empty($row->file))
                                                  <div class="card mb-12 border shadow-none ">
                                                    <div class="px-3 py-3">
                                                        <div class="row align-items-center">
                                                            <div class="col-auto">
                                                                <!--<img src="{{asset('assets/img/icons/files')}}/{{ explode('.',$row->file)[1]}}.png" class="img-fluid" style="width: 40px;">-->
                                                            </div>
                                                            <div class="col ml-n2">
                                                               <h6 class="text-sm mb-0">
                                                                   {{$row->file}}
                                                                </h6>
                                                            </div>
                                                            <div class="col-auto actions">
                                                                <a href="{{asset(Storage::url('ticketfiles'))}}/{{$row->file}}" download class="action-item" role="button">
                                                                    <i class="fas fa-download"></i>
                                                                </a>
                                
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                              @endif
                                    </div>
                                      <p  data-size="md" class="action-item pull-right">
                                                 <span class="badge badge-pill badge-{{$row->sender_type=="Customer" ? "danger" :"success"}}">{{$row->sender_type}}</span> <span class="text-mute text-right pull-right">{{ time_elapsed($row->updated_at) }}</span>
                                                </p>
                                  
                                    </div>
                                </div>
                            </div>
                            @endforeach
                            @endif    
                            
                             @if( $data->status !="Closed")
                             
                             
                            <div class="col-md-12">
                                
                                <div class="card">
                <div class="card-header">
                    <h5 class=" h6 mb-0">{{__('Reply')}}</h5>
                </div>
                <div class="card-body">
                    {{ Form::open(['route' => 'support.replystore','enctype' => 'multipart/form-data']) }}
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
                                <label class="form-control-label">Leave a reply on <span title="Ticket Type" class="badge badge-xs badge-pill badge-{{($data->submitted_to_id==Auth::user()->id)?'warning':'info'}}">{{($data->submitted_to_id==Auth::user()->id)?'Received':'Sent'}}</span> ticket:</label>
                                <textarea class="form-control"  name="message" placeholder="Message..." rows="10" minlength="50" maxlength="500" required></textarea>
                                <input type="hidden" name="ticket_id" value="{{ $data->id }}" />
                                <input type="hidden" name="sender_type" value="{{ !empty($support_user) ? "Support" : "Customer"}}" />
                                <input type="hidden" name="csrf-token" value="<?= csrf_token(); ?>" />
                            </div>
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
                        {{ Form::button(__('Send Reply'), ['type' => 'submit','class' => 'btn btn-sm btn-primary rounded-pill']) }}
                        
                        @if($data->status !="Closed")
                       <a href="javascript::void(0);" class=" btn btn-sm  btn-danger rounded-pill confirm_record_model" data-url="{{route('support.close',encrypted_key($data->id,'encrypt'))}}" data-toggle="tooltip" >
                                        {{__("Close Ticket")}}
                                    </a>
                        @endif
                    </div>
                    {{ Form::close() }}
                </div>
            </div>
                            </div>
 @endif   
  @if( $data->status =="Closed")
                     <div class="col-md-12 text-right">
                         <a href="{{route('support.reopen',encrypted_key($data->id, 'encrypt'))}}" class="btn btn-secondary btn-sm text-right pull-right"> {{__("Reopen Ticket")}}</a>
                </div>
   @endif   
                        </div>

                    </div>
                </div>
            </div>
        </div>
        @else
        <div class="empty-section">
            <i class="mdi mdi-clipboard-text"></i>
            <h5>It's empty here!</h5>
        </div>
        @endif

    </div>

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


@endpush
