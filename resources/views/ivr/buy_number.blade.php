@php $page = "Get a new number"; @endphp
@extends('layout.dashboardlayout')
@section('content')	

<style type="text/css">
.hide{
        display:none;
    }
    

    .modal-backdrop{display:none !important; }
    .buy-dialog{widows: 600px !important; color: white;}
    .modal-title {text-align: center !important;  color: white;}
    .modal-body {
        color: white;
    }
    .p-r{float: right !important;}
    .modal-content{background: #2B3A4A !important;}
    .disflex, .disflex1, .disflex2{
        display: inline-flex !important;
    }
    .onclass, .onclass1, .onclass2{
        margin-right: 5px !important;
    }
    .offclass, .offclass1, .offclass2{
        margin-left: 30px !important;
        margin-right: 5px !important;
    }
    .modal .modal-header .close{
        background: transparent !important;
    }
    .greetings_mp3, .cancelbtn, .voicemail_mp3, .ivr_mp3, .mp3_btn{
        width:55%;
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
                   <a href="{{ route('ivrsetting.twilio_numbers') }}" class="btn btn-sm btn-primary float-right btn-icon-only rounded-circle " >
                        <span class="btn-inner--icon"><i class="fas fa-reply"></i></span>
                    </a>
            </div>
   
            <!-- Breadcrumb -->
            <div class="breadcrumb-bar mt-3">
                <div class="container-fluid">
                    <div class="row align-items-center">
                        <div class="col-md-12 col-12">
                            <h2 class="breadcrumb-title">Get a new number</h2>
                            <nav aria-label="breadcrumb" class="page-breadcrumb">
                                <ol class="breadcrumb">
                                    <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Home</a></li>
                                    <li class="breadcrumb-item"><a href="{{ route('pathway.get') }}">IVR</a></li>
                                    <li class="breadcrumb-item active" aria-current="page">Get A Ner Number</li>
                                </ol>
                            </nav>
                        </div>              
                    </div>            
                </div>
            </div>
            <!-- /Breadcrumb -->





<div class="row mt-3" id="blog_view">
     <div class="col-12">
        <div class="card">
            <div class="card-body">
                <div class="form-group">
                    <div class="row">
                    <!-- mentor type -->
                        <div class="col-md-8 show">
                        <div class="form-group">
                                <div class="row">
                                    <div class="col-md-12">
                                        <label class="form-control-label">Type</label>
                                        <div class="form-check">
                                            <input type="radio" name="add_number" value="1" checked class="form-check-input" id="exampleRadios1" ><label class="form-check-label" for="exampleRadios1">  Get New Number</label>
                                        </div>
                                        <div class="form-check">
                                            <input type="radio"  name="add_number" value="2" class="form-check-input" id="exampleRadios2" ><label class="form-check-label" for="exampleRadios2">  Add Number with SID</label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="buynumber">
                    {{ Form::open(['route' =>'ivrsetting.buy_ivr_number','method'=>'get','enctype' => 'multipart/form-data']) }}
                            <div class="form-group">
                                <div class="row">
                                    <div class="col-md-6">
                                        <label>Search By Areacode</label>
                                        <input type="text" class="form-control" id="buynumber"  name="area_code" value="{{(request()->get('area_code') ?? '')}}"  />
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="row">
                                    <div class="col-md-6">
                                        <label>Search By type</label>
                                        <select class="form-control" name="type" id="type" required="">
                                            <option @if(request()->get('type') =='local')  selected  @endif value="local">Local</option>
                                            <option @if(request()->get('type') =='tollFree')  selected  @endif value="tollFree">Tollfree</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
    

                            <div class="col-md-6">
                                <div class="text-right">
                                    {{ Form::button(__('search'), ['type' => 'submit','class' => 'btn btn-sm btn-primary rounded-pill']) }}
                                </div>
                            </div>
                    {{ Form::close() }}
                </div>
                <div class="migrate" style="display:none;">
                    {{ Form::open(['route' =>'ivrsetting.migrate','method'=>'post','enctype' => 'multipart/form-data']) }}
                    <div class="form-group">
                        <div class="row">
                            <div class="col-md-6">
                                <label>SID</label>
                                <input type="text" class="form-control" id="migrate" name="sid" value="{{(request()->get('migrate') ?? '')}}"  />
                            </div>
                        </div>
                    </div>
                            <div class="col-md-6">
                                <div class="text-right">
                                    {{ Form::button(__('Submit'), ['type' => 'submit','class' => 'btn btn-sm btn-primary rounded-pill']) }}
                                </div>
                            </div>
                    {{ Form::close() }}
                </div>






            </div>
        </div>
    </div>
</div>

<div class="row" id="blog_view">
    <div class="col-12">
       <div class="card">
           <div class="card-body ">
               <div class="table-md-responsive">
                   <table class="table table-hover table-center mb-0" id="example">
                       <thead class="thead-light">
                       <tr>
                           <th class="mb-0 h6 text-sm"> {{__('Number')}}</th>
                           <th class="mb-0 h6 text-sm"> {{__('Address')}}</th>
                           <th class="text-right name mb-0 h6 text-sm"> {{__('Action')}}</th>
                       </tr>
                       </thead> 
                       <tbody>
                  
                            {!!$html!!}
                           
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


<div id="buyModal" class="modal fade" aria-hidden="true" role="dialog"  >
    <div class="modal-dialog modal-dialog-centered" role="document" >
        <div class="modal-content buy-content">
            <div class="modal-header">
                <h5 class="modal-title buy-title"  style="color:white;">Buy This Number?</h5>
            </div>

            <form method="POST" class="spacing" action="{{route('ivrsetting.post_buy_number')}}">
                {!! Form::token() !!}
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-6 buynum"></div>
                        <div class="col-md-6 p-r buyprice" style="text-align: right !important;"></div>
                    </div>
                    <div class="row" style="border: 1px solid gray;padding: 5px;margin-top: 5px;">
                        <h4 style="color:white; border-bottom:1px solid gray; padding-bottom: 10px;" >Number Capabilities</h4>
                        <div class="cap">
                        </div>
                    </div>

                    <div class="row">
                        <h4 style="color:white;">About Regulatory Requirements</h4>
                        <p style="color:white;">The regulatory requirements for this number may differ from the information being requested above. As a user of the number, it is your responsibility to collect the required documentation, listed <a style="color: #45c7f9;" href="https://www.twilio.com/docs/phone-numbers/regulatory/phone-numbers-regulatory-requirements-customers" target="_blank">here</a>. We are working to add functionality to upload all compliance documents and will ask you to retroactively provide these in due course.</p>


                        <input type="hidden" id="buynymbertwilio" name="num">
                    </div>
                </div>

                <div class="modal-footer buy-footer">
                    <button class="btn btn-success" class="close" data-dismiss="modal">close</button>
                    <button class="btn btn-success" type="submit">Submit</button>
                </div>

            </form>
        </div>
    </div>
</div>
<!-- /Page Content -->
@endsection
@push('script')
<script>
$('input[type=radio][name=add_number]').change(function() {
    if (this.value == '1') {//webphone
        $('.migrate').css('display','none');
        $('.buynumber').css('display','block');
        $("#migrate").attr("required", false);
        $("#buynumber").attr("required", true);
    }
    else if (this.value == '2') { //ivr
        $('.migrate').css('display','block');
        $('.buynumber').css('display','none');
        $("#migrate").attr("required", true);
        $("#buynumber").attr("required", false);
    }
});

function buyNumber(num,voice,sms,mms,fax,for_bot){
           
           $('.cap').html('');
           if(voice == 1){
               $('.cap').append('<div class="col-md-1"><i class="fa fa-phone"></i></div><div class="col-md-11"><b>Voice</b><p>This number can receive incoming calls and make outgoing calls.</p></div>');
           }
           if(sms == 1){
               $('.cap').append('<div class="col-md-1"><i class="fa fa-commenting"></i></div><div class="col-md-11"><b>SMS</b><p>This number can send and receive text messages to and from mobile numbers.</p></div>');
           }
           if(mms == 1){
               $('.cap').append('<div class="col-md-1"><i class="fa fa-picture-o"></i></div><div class="col-md-11"><b>MMS</b><p>This number can send and receive multi media messages to and from mobile numbers.</p></div>');
           }

           $('.buynum').html('<h3 style="color:white;"><b>+'+num+'</h3>');
           $('#buynymbertwilio').val(num);
           $('.for_bot').val(for_bot);
           $('#buyModal').modal('show');
       }
</script>



@endpush