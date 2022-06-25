@extends('layout.commonlayout')
@section('content')		
<!-- Breadcrumb -->
<div class="breadcrumb-bar">
    <div class="container-fluid">
        <div class="row align-items-center">
            <div class="col-md-12 col-12">
                <h2 class="breadcrumb-title">Schedule A Meeting</h2>
                <nav aria-label="breadcrumb" class="page-breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{url('/')}}">Home</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Booking</li>
                    </ol>
                </nav>
            </div>
        </div>
    </div>
</div>
<!-- /Breadcrumb -->

<!-- Page Content -->
<div class="content">
    <div class="container-fluid">

        <div class="row">
            <div class="col-12">

                <div class="card">
                    <div class="card-body">
                        <div class="booking-user-info">
                            <a href="{{route('profile',['id'=>encrypted_key($user->id,"encrypt")])}}" class="booking-user-img">
                                <img src="{{ $user->getAvatarUrl()}}" alt="User Image">
                            </a>
                            <div class="booking-info">
                                <h4><a href="{{route('profile',['id'=>encrypted_key($user->id,"encrypt")])}}">{{$user->name}}</a></h4>
                                <div class="rating">
                                    @for($i=1; $i<=5;$i++)
                                    <i class="fas fa-star @if(!empty((int) $user->average_rating) && $i<= (int) $user->average_rating) filled @endif"></i>
                                    @endfor
                                    <span class="d-inline-block average-rating"> ({{ $user->getProfilefeebackCount()}})</span>
                                </div>
                                <p class="text-muted mb-0"><i class="fas fa-map-marker-alt"></i> {{$user->state}}, {{$user->country}}</p>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-12 col-sm-4 col-md-6">
                        <h4 class="mb-1">{{date('d F Y')}}</h4>
                        <p class="text-muted">{{date('l')}} </p>
                    </div>
                    <div class="col-12 col-sm-8 col-md-6 text-sm-right float-right">
                        <div class=" col-6 float-right btn btn-white btn-sm mb-3 input-group">
                            <input type='text' class="form-control" id='weeklyDatePicker' placeholder="Select Week" />
                             <div class="input-group-append">
                                 <button class="btn btn-primary" id="weekclearinput" type="button">X</button>
    </div>
                        </div>
       
                        
                        
                    </div>
                </div>
                <!-- Schedule Widget -->
                <div class="card booking-schedule schedule-widget" id="data-holder">

                    

                </div>
                <!-- /Schedule Widget -->

               

            </div>
        </div>
    </div>
<!-- Delete Model -->
<!--<div class="modal fade" id="proceed_payment_model" role="dialog" style="display: none;" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-body">
                <div class="form-content p-2 text-center">
                    <di id="slot_model_title"></di>
                    <p class="mb-4" >Total Price: <span id="slot_price"></span></p>
                    <form id="common_proceed_form" action="{{route('booking.checkout')}}" method="post" enctype="multipart/form-data">     
                        @csrf
                        <div class="form-group btn-group text-center">
                            <input type="hidden" name="selected_slots" id="selected_slots" />
                            <input type="hidden" name="uid" value="{{$user->id}}" />
                    <button type="button" class="btn btn-danger form-control" data-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-success  form-control">Continue</button>
                        </div>
                    </form>
                    
                </div>
            </div>
        </div>
    </div>
</div>-->
<!-- Delete Model -->
<div class="modal fade" id="proceed_payment_model" role="dialog" style="display: none;" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-body">
                <div class="form-content p-2 text-center">
                    <h4 class="modal-title" id="slot_model_title">Schedule Slot Booking</h4>
                    <p class="mb-4" >Slot Price: <span id="slot_price"></span></p>
                    <form id="common_proceed_form" enctype="multipart/form-data">   
                     @csrf
                      <input type="hidden" name="selected_slots" id="selected_slots_input" />
                            <input type="hidden" name="uid" value="{{$user->id}}" />
                        <div class="form-group btn-group text-center">
                        <button type="submit" class="btn btn-success  form-control">Checkout</button>
                    <button type="button" class="btn btn-danger form-control" data-dismiss="modal">Close</button>
                        </div>
                    </form>
                    
                </div>
            </div>
        </div>
    </div>
</div>
</div>		
<!-- /Page Content -->
@endsection

@push('script')
<script>
    $(document).ready(function(){
    moment.locale('en', {
      week: { dow: 1 } // Monday is the first day of the week
    });

  //Initialize the datePicker(I have taken format as mm-dd-yyyy, you can     //have your owh)
  $("#weeklyDatePicker").datetimepicker({
      format: 'DD-MM-YYYY'
  });
  

   //Get the value of Start and End of Week
  $('#weeklyDatePicker').on('dp.change', function (e) {
      var value = $("#weeklyDatePicker").val();
      var firstDate = moment(value, "DD-MM-YYYY").day(1).format("DD-MM-YYYY");
      var lastDate =  moment(value, "DD-MM-YYYY").day(7).format("DD-MM-YYYY");
      $("#weeklyDatePicker").val(firstDate + " - " + lastDate);
      
      filter(firstDate);
  });
  $('#weekclearinput').on('click', function (e) {
 filter();
     $("#weeklyDatePicker").val('');
  });
});
    
    
     $(document).on("click", ".checkout_click_btn", function(){
          var selectedSlots = [];
     $.each($("input[name='selected_slots_checkbox']:checked"), function(){
                  selectedSlots.push($(this).val());
            });    
            if(selectedSlots.length > 0){
$("#checkout_button").html("Checkout ("+selectedSlots.length+")");
$("#checkout_button").show();
            }else{
                $("#checkout_button").hide();
            }

});
//     $(document).on("click", ".proceed_payment_model", function(){
//         var price=0;
//         var i=1;
//         var selectedSlots = [];
//         $("#slot_model_title").html('');
//         $.each($("input[name='selected_slots_checkbox']:checked"), function(){
//$("#slot_model_title").append(' <h3 class="modal-title">'+i+"- "+$(this).attr('data-title')+' ($'+$(this).attr('data-price')+'.00)</h3>');
//price =parseInt(price) + parseInt($(this).attr('data-price'));
//selectedSlots.push($(this).val());
//i++;
//  });  
//$("#slot_price").html('$'+price+'.00');
//$("#selected_slots").val(selectedSlots);
//$('#proceed_payment_model').modal('show');
//
//});

  $(document).on("click", ".proceed_payment_model", function(){
$("#common_proceed_form").attr('action',$(this).attr('data-url'));
$("#slot_model_title").html($(this).attr('data-title'));
$("#slot_price").html($(this).attr('data-price'));
$("#selected_slots_input").val($(this).attr('data-id'));
$('#proceed_payment_model').modal('show');
});

    $(function () {
    filter();
    });
   
    $(".gender_type").click(function () {        
    filter();
    });
   

    function filter(start_date = '') {
    var search = $("#s").val();
    var sortby = $("#sortby-fliter").val();
    var roleFilter = [];
     $.each($("input[name='checkbox_role']:checked"), function(){
                  roleFilter.push($(this).val());
            });
  
   
            
    var data = {
    id: {{$user->id}},
            start_date: start_date,
            sortby: sortby,
            _token: "{{ csrf_token() }}",
    }
    $.post(
            "{{route('profile.booking.filter')}}",
            data,
            function (data) {
            $("#data-holder").html(data);
            }
    );
    }
</script>
@endpush