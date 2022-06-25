<?php $page = "Tuition Assistance Requests"; ?>
@extends('layout.dashboardlayout')
@section('content')	

<style>
.media {
    margin-top: 0px !important;
}
.main-wrapper {

    height: auto!important;
}
.custom-control-input:checked~.custom-control-label::before {
    color: #fff;
    border-color: #009da6;
    background-color: #009da6;
}
.modal-open .main-wrapper {
    -webkit-filter: blur(1px);
    -moz-filter: blur(1px);
    -o-filter: blur(1px);
    -ms-filter: blur(1px);
    filter: inherit;
}

.modal {
    padding-top: 5rem !important;
}
  .middle h1 {
            color: #212529;
            font-size: 23px;
        }

        .middle input[type="radio"] {
            display: none;
        }

        .middle input[type="radio"]:checked + .box {
            background-color: #2954b1;
        }

        .middle input[type="radio"]:checked + .box span {
            color: white;
            transform: translateY(70px);
        }

        .middle input[type="radio"]:checked + .box span:before {
            transform: translateY(0px);
            opacity: 1;
        }

        .middle .box {
            width: 135px;
            height: 42px;
            background-color: #fff;
            transition: all 250ms ease;
            will-change: transition;
            display: inline-block;
            text-align: center;
            cursor: pointer;
            position: relative;
            box-shadow: 0 4px 8px 0 rgba(0, 0, 0, 0.2);
            font-weight: 600;
        }

        .middle .box:active {
            transform: translateY(10px);
        }

        input.btn.btn-info.btn-md.log:hover {
            box-shadow: 0 4px 8px 0 rgba(0, 0, 0, 0.2);
        }

        .middle .box span {
            position: absolute;
            transform: translate(0, 69px);
            left: 0;
            right: 0;
            transition: all 300ms ease;
            font-size: 18px;
            user-select: none;
            color: #2954b1;
            bottom: 76px;
            font-family: 'Rajdhani', sans-serif;
        }

        .middle .box span:before {
            font-size: 1.2em;
            font-family: FontAwesome;
            display: block;
            transform: translateY(-80px);
            opacity: 0;
            transition: all 300ms ease-in-out;
            font-weight: normal;
            color: white;
        }

        .middle .front-end span:before {

        }

        .middle .back-end span:before {

        }

        .middle p {
            color: #fff;
            font-weight: 400;
        }

        .middle p span:after {
            content: '\f0e7';
            font-family: FontAwesome;
            color: yellow;
        }

        .middle label {
            margin-top: 15px !important;
        }

        .middle {
            transform: translateY(0%) !important;
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
				
				<a href="{{ route('certify.index') }}" id="back" class="btn btn-sm btn-primary float-right ml-2">
				<span class="btn-inner--icon"><i class="fas fa-reply"></i></span>
				</a>
				
				  <a href="{{ route('tution.coupon.history') }}" class="btn btn-sm btn btn-primary float-right mr-2 m-0">
                 <span class="btn-inner--text ">{{__('Coupon History')}}</span>
               </a>
			   
				
				
				
				</div>
   
<!-- Breadcrumb -->
<div class="breadcrumb-bar mt-3">
    <div class="container-fluid">
        <div class="row align-items-center">
            <div class="col-md-12 col-12">
                <h2 class="breadcrumb-title">Tuition Assistance Requests</h2>
                <nav aria-label="breadcrumb" class="page-breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{route('dashboard')}}">Home</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Tuition Assistance Requests</li>
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
                               <th class="name mb-0 h6 text-sm"> {{__('Student Name')}}</th>
                                <th class="name mb-0 h6 text-sm"> {{__('Type')}}</th>
                                <th class="name mb-0 h6 text-sm"> {{__('Price')}}</th>
                                <th class="name mb-0 h6 text-sm"> {{__('Status')}}</th>
                                <th class="name mb-0 h6 text-sm"> {{__('Action')}}</th>
                              
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


   <div class="modal fade" id="requestInfo" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
         aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Request for more information</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    {{ Form::open(['url' => 'tution/request/send/request','id' => 'tution_request_send_request','enctype' => 'multipart/form-data']) }}
                    <input type="hidden" id="hiddenidnew" name="id" value="">
                    <section class="text-center">
                        <div class="middle">
                            <label>
                                <input type="radio" name="optionType" class="optionType " value="requestFile"/>
                                <div class="front-end box">
                                    <span>Request File</span>
                                </div>
                            </label>

                            <label>
                                <input type="radio" name="optionType" class="optionType" value="moreInfo"/>
                                <div class="back-end box">
                                    <span>More Info</span>
                                </div>
                            </label>
                        </div>
                    </section>
                    <div class="form-group">
                        <label for="exampleFormControlTextarea1">Overview :</label>
                        <textarea class="form-control" id="exampleFormControlTextarea1" rows="3"
                                  name="comment" required></textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Send</button>
                </div>
                {{ Form::close() }}
            </div>
        </div>
    </div>
    </div>
    <!-- Modal -->
    <div class="modal fade" id="approveModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
         aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Approve Request</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    {{ Form::open(['url' => 'tution/request/status/approve','id' => 'change_approve_request','enctype' => 'multipart/form-data']) }}
                    <div id="priceDiv" class="text-center" style="display:none;">
                    </div>
                    <input type="hidden" id="hiddenPrice" name="hiddenPrice" value="">
                    <input type="hidden" id="hiddenid" name="id" value="">
                    <input type="hidden" id="hiddenofferPrice" name="newprice" value="">
				
                    <section class="text-center">
                        <div class="middle">
                            <label>
                                <input type="radio" name="priceType" class="priceType " value="free"/>
                                <div class="front-end box">
                                    <span>Free</span>
                                </div>
                            </label>
                            <label>
                                <input type="radio" name="priceType" class="priceType" value="partial"/>
                                <div class="back-end box">
                                    <span>Partial</span>
                                </div>
                            </label>
                        </div>
                        <div class="appendedDivPriceType" style="display:none;">
                        </div>
                    </section>
                    <div class="form-group">
                        <label for="exampleFormControlTextarea1">Comment :</label>
                        <textarea class="form-control" id="exampleFormControlTextarea1" rows="3"
                                  name="comment"></textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Approve</button>
                </div>
                {{ Form::close() }}
            </div>
        </div>
    </div>
    
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
                    {{ Form::open(['url' => 'tution/request/delete','id' => 'destroy_certify_request','enctype' => 'multipart/form-data']) }}
                    <input type="hidden" name="id" id="delete_id" value="">

                    <button type="submit" class="btn btn-sm btn-danger rounded-pill" id="">Yes</button>
                    {{ Form::close() }}
                    <button type="button" class="btn btn-sm btn-secondary rounded-pill" id="" data-dismiss="modal"
                            aria-label="Close">Cancel
                    </button>
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
         ajax: "{{ url('/tution/request') }}",
        columns: [
         {data: 'certify', name: 'certify', orderable: true, searchable: true},
                     {data: 'user_name', name: 'user_name', orderable: false},
                   
                    {data: 'type', name: 'type', orderable: false},
                    {data: 'price', name: 'price', orderable: true},
                    {data: 'status', name: 'status', orderable: false},
                    {
                       data: 'action',
                        name: 'action',
                        orderable: false,
                        searchable: false
                    },
                ]
    });

  });
        //employment graph
  
        $(document).on('click', '.close_state', function () {        
            $('#go_state').css('display','none');
            $("#tsum-tabs").css('display','block');            
        })
        
        
      
        //impact graph
    
        var hiddenPrice = '';
        $(document).ready(function () {
            $('#myTable').DataTable();
        });
        $(document).on("click", ".destroyCertify", function () {
            var id = $(this).attr('data-id');
            $("#delete_id").val(id);
            $('#destroyCertify').modal('show');
        });
   $(document).ready(function () {
        $(document).on("click", ".requestInfo", function (event) {

            var hiddenid = $(this).attr('data-id');
            $("#hiddenidnew").val(hiddenid);
            $("#requestInfo").modal('show');
        });
		
		
		
        $(document).on("click", ".approveReq", function (event) {
            event.preventDefault();
            $('#change_approve_request').trigger("reset");
            var certifyPrice = $(this).attr('data-certify');
            var dataId = $(this).attr('data-id');
            $("#hiddenid").val(dataId);
            $.post(
                "{{route('get.certfy.price')}}",
                {_token: "{{ csrf_token() }}", id: certifyPrice},
                function (data) {
                    $("#hiddenPrice").val(data);
                    $("#priceDiv").html('<h2>Course price : ' + '$' + Math.round(data) + '</h2>');
                    $("#priceDiv").show();
                    $('#approveModal').modal('show');
                }
            );
        });
        $(document).on("click", ".priceType", function (event) {
            var priceType = $(this).val();
            if (priceType == 'partial') {
                $(".appendedDivPriceType").html('<div class="form-group"><label for="usr">Price:</label><div class="input-group-prepend"><span class="input-group-text">$</span><input type="text" class="form-control" id="offerPrice" name="price"></div></div>');
                $(".appendedDivPriceType").show();
            } else if (priceType == 'free') {
                $(".appendedDivPriceType").hide();
                var checkPrice = $("#hiddenPrice").val();
                var dataId = $("#hiddenid").val();
                $("#hiddenofferPrice").val(checkPrice);
                // $("#hiddenid").val(dataId);
                var offerPrice = $("#hiddenPrice").val();
                var hiddenofferPrice = $("#hiddenofferPrice").val(offerPrice);
                $.post(
                    "{{route('check.wallet.price')}}",
                    {_token: "{{ csrf_token() }}", price: checkPrice, id: dataId},
                    function (data) {
                        if (data == true) {
                            show_toastr('Success', '{{__('free certify available.')}}', 'success');
                        } else if (data == false) {
                            show_toastr('Error', '{{__('unsuficent balance in wallet.')}}', 'error');
                        }
                    }
                );
            }
        });
        $(document).on("focusout", "#offerPrice", function (event) {
            var price = $(this).val();
            var checkPrice = $("#hiddenPrice").val();
            var dataId = $("#hiddenid").val();
            var hiddenofferPrice = $("#hiddenofferPrice").val(checkPrice);
            if (Math.round(price) > Math.round(checkPrice)) {
                show_toastr('Error', '{{__('balance must be less or equal of course price.')}}', 'error');
                $(this).val('');
            } else {
                $.post(
                    "{{route('check.wallet.price')}}",
                    {_token: "{{ csrf_token() }}", price: price, id: dataId},
                    function (data) {
                        if (data == true) {
                            show_toastr('Success', '{{__('offer available.')}}', 'success');
                        } else if (data == false) {
                            show_toastr('Error', '{{__('unsuficent balance in wallet.')}}', 'error');
                        }
                    }
                );
            }
        });
        $("#change_approve_request").submit(function (event) {
            var hiddenid = $("#hiddenidnew").val();
            var hiddenPrice = $("#hiddenPrice").val();
            var offerPrice = $("#offerPrice").val();
            var hiddenofferPrice = $("#hiddenofferPrice").val(offerPrice);
            var pr = $("#hiddenofferPrice").val();
            if (hiddenPrice == '') {
                event.preventDefault();
                show_toastr('Error', '{{__('complete All step first.')}}', 'error');
            }
        });
        $("#tution_request_send_request").submit(function (event) {
            if (!$('.optionType').is(":checked")) {
                event.preventDefault();
                show_toastr('Error', '{{__('complete All step first.')}}', 'error');
            }
        });
		 });
        // teknomines code

        $(document).on("click", ".certify_approve", function (event) {
         
            var user_id = $("#tution_user_id").val();
            var cid = $(this).data("id");
            $.post(
                "{{route('tution.assistance.certify_approve')}}",
                {_token: "{{ csrf_token() }}", user_id: user_id, id: cid, status: 'approve'},
                function (response) {
                    var data = JSON.parse(response);
                    var html = data.html;
                    $("#content1").html(html);
                }
            );
        });

        $(document).on("click", ".certify_reject", function (event) {
            var user_id = $("#tution_user_id").val();
            var cid = $(this).data("id");
            $.post(
                "{{route('tution.assistance.certify_approve')}}",
                {_token: "{{ csrf_token() }}", user_id: user_id, id: cid, status: 'reject'},
                function (response) {
                    var data = JSON.parse(response);
                    var html = data.html;
                    $("#content1").html(html);
                }
            );
        });


        $(document).on("click", ".cls_history", function (event) {
            var user_id = $("#tution_user_id").val();
            $.post(
                "{{route('tution.assistance.history')}}",
                {_token: "{{ csrf_token() }}", user_id: user_id},
                function (response) {
                    var data = JSON.parse(response);
                    var html = data.html;
                    $("#content1").html(html);
                }
            );
        });

        $(document).on("click", ".back_history", function (event) {
            var user_id = $("#tution_user_id").val();
            $.post(
                "{{route('tution.assistance.opportunity')}}",
                {_token: "{{ csrf_token() }}", user_id: user_id},
                function (response) {
                    var data = JSON.parse(response);
                    var html = data.html;
                    $("#content1").html(html);
                }
            );
        });

        $('#tsum-tabs #tab1').on('change', function () {
            var user_id = $("#tution_user_id").val();
            $.post(
                "{{route('tution.assistance.opportunity')}}",
                {_token: "{{ csrf_token() }}", user_id: user_id},
                function (response) {
                    var data = JSON.parse(response);
                    var html = data.html;
                    $("#content1").html(html);
                }
            );
        });

        $('#tsum-tabs #tab2').on('change', function () {
            var user_id = $("#tution_user_id").val();
            $.post(
                "{{route('tution.assistance.pathways')}}",
                {_token: "{{ csrf_token() }}", user_id: user_id},
                function (response) {
                    var data = JSON.parse(response);
                    if (data.result == true) {
                        var html = data.html;
                    } else {
                        var html = "<h5>No pathways found.</h5>";
                    }
                    $("#content2").html(html);
                }
            );
        });

        $('#tsum-tabs #tab3').on('change', function () {
            var user_id = $("#tution_user_id").val();
            $.post(
                "{{route('tution.assistance.readiness')}}",
                {_token: "{{ csrf_token() }}", user_id: user_id},
                function (response) {
                    var data = JSON.parse(response);
                    if (data.result == true) {
                        var html = data.html;
                    } else {
                        var html = "<h5>No record found.</h5>";
                    }
                    $("#content3").html(html);
                }
            );
        });

        $('#tsum-tabs #tab4').on('change', function () {
            var user_id = $("#tution_user_id").val();
            $.post(
                "{{route('tution.assistance.mymentors')}}",
                {_token: "{{ csrf_token() }}", user_id: user_id},
                function (response) {
                    var data = JSON.parse(response);
                    if (data.result == true) {
                        var html = data.html;
                    } else {
                        var html = "<h5>No record found.</h5>";
                    }
                    $("#content4").html(html);
                }
            );
        });

        $('#tsum-tabs #tab5').on('change', function () {
            $('#gender').val("")
            var user_id = $("#tution_user_id").val();

            $.post(
                "{{route('tution.assistance.impact')}}",
                {_token: "{{ csrf_token() }}", user_id: user_id},
                function (response) {
                    var data = JSON.parse(response);

                    var myConfig = {
                        "type": "line",
                        "utc": true,
                        "plotarea": {
                            "margin": "dynamic 45 60 dynamic",
                        },
                        "legend": {
                            "layout": "float",
                            "background-color": "none",
                            "border-width": 0,
                            "shadow": 0,
                            "align": "center",
                            "adjust-layout": true,
                            "toggle-action": "remove",
                            "item": {
                                "padding": 13,
                                "marginRight": 10,
                                "marginLeft": 5,
                                "cursor": "hand"
                            }
                        },
                        "scale-x": {
                            "label": {
                                "text": "Year",
                            },
                            "labels": data.html.label,
                            "shadow": 0,

                            "label": {
                                "visible": true
                            },
                            "minor-ticks": 0
                        },
                        "scale-y": {
                            "line-color": "#f6f7f8",
                            "shadow": 0,
                            "guide": {
                                "line-style": "dashed"
                            },
                            "label": {
                                "text": "Course Count",
                            },
                            "minor-ticks": 0,
                            "thousands-separator": ","
                        },
                        "crosshair-x": {
                            "line-color": "#efefef",
                            "plot-label": {
                                "border-radius": "5px",
                                "border-width": "1px",
                                "border-color": "#f6f7f8",
                                "padding": "10px",
                                "font-weight": "bold"
                            },
                            "scale-label": {
                                "font-color": "#000",
                                "background-color": "#f6f7f8",
                                "border-radius": "5px"
                            }
                        },
                        "tooltip": {
                            "visible": false
                        },
                        "plot": {
                            "highlight": true,
                            "tooltip-text": "%t count: %v<br>%k",
                            "shadow": 0,
                            "line-width": "2px",
                            "marker": {
                                "type": "circle",
                                "size": 1
                            },
                            "highlight-state": {
                                "line-width": 1
                            },
                            "animation": {
                                "effect": 1,
                                "sequence": 2,
                                "speed": 100,
                            }
                        },
                        "series": data.html.series
                    };
                    render(myConfig);
                    $('#state_drpdwn').html(data.html.select);
                });
        });
        $('#tsum-tabs #tab6').on('change', function () {
            var user_id = $("#tution_user_id").val();
            $.post(
                "{{route('tution.assistance.linkedin')}}",
                {_token: "{{ csrf_token() }}", user_id: user_id},
                function (response) {
                    var data = JSON.parse(response);
                    if (data.result == true) {
                        var html = data.html;
                    } else {
                        var html = "<h5>No record found.</h5>";
                    }
                    $("#content6").html(html);
                }
            );
        });
        //teknomines code

        $(document).on('change', '#gender', function () {
            var select = $( ".state_drpdwn option:selected" ).val();
            var user_id = $("#tution_user_id").val();
            $.post(
                "{{route('tution.assistance.impact')}}",
                {_token: "{{ csrf_token() }}", user_id: user_id,select:select, select2: this.value},
                function (response) {
                    var data = JSON.parse(response);

                    var myConfig = {
                        "type": "line",
                        "utc": true,
                        "plotarea": {
                            "margin": "dynamic 45 60 dynamic",
                        },
                        "legend": {
                            "layout": "float",
                            "background-color": "none",
                            "border-width": 0,
                            "shadow": 0,
                            "align": "center",
                            "adjust-layout": true,
                            "toggle-action": "remove",
                            "item": {
                                "padding": 7,
                                "marginRight": 1,
                                "cursor": "hand"
                            }
                        },
                        "scale-x": {
                            "label": {
                                "text": "Year",
                            },
                            "labels": data.html.label,
                            "shadow": 0,

                            "label": {
                                "visible": true
                            },
                            "minor-ticks": 0
                        },
                        "scale-y": {
                            "line-color": "#f6f7f8",
                            "shadow": 0,
                            "guide": {
                                "line-style": "dashed"
                            },
                            "label": {
                                "text": "Course Count",
                            },
                            "minor-ticks": 0,
                            "thousands-separator": ","
                        },
                        "crosshair-x": {
                            "line-color": "#efefef",
                            "plot-label": {
                                "border-radius": "5px",
                                "border-width": "1px",
                                "border-color": "#f6f7f8",
                                "padding": "10px",
                                "font-weight": "bold"
                            },
                            "scale-label": {
                                "font-color": "#000",
                                "background-color": "#f6f7f8",
                                "border-radius": "5px"
                            }
                        },
                        "tooltip": {
                            "visible": false
                        },
                        "plot": {
                            "highlight": true,
                            "tooltip-text": "%t count: %v<br>%k",
                            "shadow": 0,
                            "line-width": "2px",
                            "marker": {
                                "type": "circle",
                                "size": 1
                            },
                            "highlight-state": {
                                "line-width": 1
                            },
                            "animation": {
                                "effect": 1,
                                "sequence": 2,
                                "speed": 100,
                            }
                        },
                        "series": data.html.series
                    };
                    render(myConfig);
                });
            })

        $(document).on('change', '.state_drpdwn', function () {
            var select2 = $( "#gender option:selected" ).val();
            var user_id = $("#tution_user_id").val();
            $.post(
                "{{route('tution.assistance.impact')}}",
                {_token: "{{ csrf_token() }}", user_id: user_id, select: this.value, select2: select2},
                function (response) {
                    var data = JSON.parse(response);

                    var myConfig = {
                        "type": "line",
                        "utc": true,
                        "plotarea": {
                            "margin": "dynamic 45 60 dynamic",
                        },
                        "legend": {
                            "layout": "float",
                            "background-color": "none",
                            "border-width": 0,
                            "shadow": 0,
                            "align": "center",
                            "adjust-layout": true,
                            "toggle-action": "remove",
                            "item": {
                                "padding": 7,
                                "marginRight": 1,
                                "cursor": "hand"
                            }
                        },
                        "scale-x": {
                            "label": {
                                "text": "Year",
                            },
                            "labels": data.html.label,
                            "shadow": 0,

                            "label": {
                                "visible": true
                            },
                            "minor-ticks": 0
                        },
                        "scale-y": {
                            "line-color": "#f6f7f8",
                            "shadow": 0,
                            "guide": {
                                "line-style": "dashed"
                            },
                            "label": {
                                "text": "Course Count",
                            },
                            "minor-ticks": 0,
                            "thousands-separator": ","
                        },
                        "crosshair-x": {
                            "line-color": "#efefef",
                            "plot-label": {
                                "border-radius": "5px",
                                "border-width": "1px",
                                "border-color": "#f6f7f8",
                                "padding": "10px",
                                "font-weight": "bold"
                            },
                            "scale-label": {
                                "font-color": "#000",
                                "background-color": "#f6f7f8",
                                "border-radius": "5px"
                            }
                        },
                        "tooltip": {
                            "visible": false
                        },
                        "plot": {
                            "highlight": true,
                            "tooltip-text": "%t count: %v<br>%k",
                            "shadow": 0,
                            "line-width": "2px",
                            "marker": {
                                "type": "circle",
                                "size": 1
                            },
                            "highlight-state": {
                                "line-width": 1
                            },
                            "animation": {
                                "effect": 1,
                                "sequence": 2,
                                "speed": 100,
                            }
                        },
                        "series": data.html.series
                    };
                    render(myConfig);
                });
        })
    </script>
@endpush
