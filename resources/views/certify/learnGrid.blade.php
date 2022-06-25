<div class="col-md-4">
    <div class="card hover-shadow-lg">
         <div class="card-header mt-2 mb-1">
        <!--<h4>Contents</h4>-->
        <div class="progress w-100 height-2"></div>
         </div>
        <div class="pl-3 mt-3">
            @php
            $i=0;
            @endphp
            @if (count($Chapters) > 0)
            @foreach ($Chapters as $chapterindex => $chapter)
                <!-- single chapter -->
                <div class="chapters-list">
                    
                    <h6><span class="text-xs text-thin text-uppercase text-primary">Chapter {{ $chapterindex + 1 }}:</span> <strong class="">{{ $chapter->title }}</strong></h6>
                    <ul>
                        @if (count($chapter->lectures) > 0)
                            @foreach ($chapter->lectures as $key => $lecture)
                                @if ( $lecture->type == "link" )
                                    <div class="chapter-class-type text-xs" >
                                        <a href="javascript:void(0)" id="{{ $i }}" style="display: list-item;" class="text-dark1" data-id="{{ $lecture->id }}"><i class="fas fa-link"></i>&nbsp;{{ $lecture->title }}
                                            <i class="fas fa-check-circle @if(getLearnStudentStatus($lecture->id) == true) lectureTrue @endif" id="indexLecture{{ $lecture->id }}" style="float:right;margin-right: 35px;"></i>
                                        </a>
                                    </div>
                                @elseif ( $lecture->type == "text" )
                                    <div class="chapter-class-type text-xs" >
                                        <a href="javascript:void(0)" id="{{ $i }}" style="display: list-item;" class="text-dark1" data-id="{{ $lecture->id }}"><i class="far fa-file-alt"></i>&nbsp;{{ $lecture->title }}
                                            <i class="fas fa-check-circle @if(getLearnStudentStatus($lecture->id) == true) lectureTrue @endif" id="indexLecture{{ $lecture->id }}" style="float:right;margin-right: 35px;margin-top: 3px;" ></i>
                                        </a>
                                    </div>
                                @elseif ( $lecture->type == "downloads" )
                                    <div class="chapter-class-type text-xs">
                                        <a href="javascript:void(0)" id="{{ $i }}"  style="display: list-item;" class="text-dark1" data-id="{{ $lecture->id }}"><i class="fas fa-cloud-upload-alt"></i>&nbsp;{{ $lecture->title }}
                                            <i class="fas fa-check-circle @if(getLearnStudentStatus($lecture->id) == true) lectureTrue @endif" id="indexLecture{{ $lecture->id }}" style="float:right;margin-right: 35px;margin-top: 3px;"></i>
                                        </a>
                                    </div>
                                @elseif ( $lecture->type == "pdf" )
                                    <div class="chapter-class-type text-xs" >
                                        <a href="javascript:void(0)" id="{{ $i }}" style="display: list-item;" class="text-dark1" data-id="{{ $lecture->id }}"><i class="fas fa-file-pdf"></i>&nbsp;{{ $lecture->title }}
                                            <i class="fas fa-check-circle @if(getLearnStudentStatus($lecture->id) == true) lectureTrue @endif" id="indexLecture{{ $lecture->id }}" style="float:right;margin-right: 35px;margin-top: 3px;"></i>
                                        </a>
                                    </div>
                                @elseif ( $lecture->type == "video" )
                                    <div class="chapter-class-type text-xs" >
                                        <a href="javascript:void(0)" id="{{ $i }}" style="display: list-item;" class="text-dark1" data-id="{{ $lecture->id }}"><i class="fa fa-play-circle"></i>&nbsp;{{ $lecture->title }}
                                            <i class="fas fa-check-circle @if(getLearnStudentStatus($lecture->id) == true) lectureTrue @endif" id="indexLecture{{ $lecture->id }}" style="float:right;margin-right: 35px;margin-top: 3px;"></i>
                                        </a>
                                    </div>
                                @elseif ( $lecture->type == "scorm" )
                                    <div class="chapter-class-type text-xs" >
                                        <a href="javascript:void(0)" id="{{ $i }}" style="display: list-item;" class="text-dark1" data-id="{{ $lecture->id }}" data-type="scorm"><i class="fa fa-file"></i>&nbsp;{{ $lecture->title }}
                                            <i class="fas fa-check-circle @if(getLearnStudentStatus($lecture->id) == true) lectureTrue @endif" id="indexLecture{{ $lecture->id }}" style="float:right;margin-right: 35px;margin-top: 3px;"></i>
                                        </a>
                                    </div>
                                @endif
                                @php $i++; @endphp
                            @endforeach
                        @else
                            <i class="fas fa-sticky-note">&nbsp;This chapter has no lectures!</i>
                        @endif
                    </ul>
                </div>
            @endforeach
            @else
                <div class="empty-section empty-chapter"><i class="fa fa-clipboard-text"></i><h5>No chapters here yet!</h5></div>
            @endif
        </div>
    </div>
</div>
<div class="col-md-8" >
    <div class="card">
        <div class="certify-list">
            <div class="card-header">
                <a class="btn btn-default pull-right next-lecture"  href="javascript:void(0)" >Next <i class=" fa fa-arrow-right"></i></a>
                <a class="btn btn-default pull-right previous-lecture"  href="javascript:void(0)" style=""><i class=" fa fa-arrow-left"></i> Previous</a>
                <h4>Learn</h4>
            </div>
            <div class="card-body p-0 player-canvas">
                <h1>{{ $Certify->name }}</h1>
                <p>{{ strip_tags($Certify->description) }}</p>
                <button type="button" class="btn btn-sm btn-primary rounded-pill start-class"><i class=" fa fa-play-circle-outline"></i> Start Class</button>
            </div>
        </div>
    </div>
</div>
<style type="text/css">
    .card-header .btn{padding:7px 16px!important;margin-top:-14px}.next-lecture,.previous-lecture{padding:7px 27px!important;margin-top:-14px;border:2px solid transparent}.btn-default{color:#484848;background-color:#f8f8f8;border-color:#eaeced}a.btn.btn-default{float:right;margin-top:-2px}.btn{border:2px solid transparent}.card-body.p-0.player-canvas{margin-left:15px}.next-lecture{display:none}.previous-lecture{display:none}a.text-dark1:hover{color:#306eff!important}a#0{float:right;margin-right:35px;margin-top:3px;color:#a3adc5d1}.lectureTrue{color:green}#scorm_view_modal .modal-dialog{max-width:1024px}
</style>
<link rel="stylesheet" href="{{ asset('css/switchery/switchery.min.css') }}">

<!-- Modal -->
<div id="examAlertNotComplete" class="modal fade" role="dialog">
    <div class="modal-dialog">
        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
            </div>
            <div class="modal-body " style="text-align: center;">
                <i class="fas fa-times-circle" style="color: red;font-size: 110px;"></i>
                <h2>The end!</h2>
                <p style="display: block;">You have reached the end but there are some lectures you have not completed.</p>
                <div class="sa-confirm-button-container">
                    <button type="button" data-dismiss="modal" class="btn btn-sm btn-primary rounded-pill">Okay</button>
                    <div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- Modal -->
<div id="examAlert" class="modal fade" role="dialog">
    <div class="modal-dialog">
        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
            </div>
            <div class="modal-body " style="text-align: center;">
                <i class="fas fa-check-circle" style="color: #49b336;font-size: 110px;"></i>
                <h2>Hooray!</h2>
                <p style="display: block;">You have successfully completed this class, you are now ready for exams.</p>
                <div class="sa-confirm-button-container">
                    <button type="button" data-dismiss="modal" class="btn btn-sm btn-primary rounded-pill">Great!</button>
                    <div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- Scorm View -->
<div id="scorm_view_modal" class="modal fade" role="dialog">
    <div class="modal-dialog">
        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close scorm_view_modal" data-dismiss="modal" aria-label="Close" style="color: black;">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body scorm_view_modal_content" style="text-align: center;">

            </div>
        </div>
    </div>
</div>

<script src="{{ asset('js/jquery-ui/jquery-ui.min.js') }}"></script>
<script type="text/javascript">
    var active = '';
    var classlength = '';
    var selectedId = '';
    var lectureTrueLength = $(".lectureTrue").length;
    $(".text-dark1").click(function () {
        active = $(this).index('.text-dark1');
        $('.text-dark1').removeClass('active');
        $(this).addClass('active');
        classlength = $(".text-dark1").length;
        classlength = classlength - 1;
        selectedId = $(this).attr("id");
        if (active == classlength) {
            $(".text-dark1").eq(classlength).addClass('lastLecture');
            $(".next-lecture").show();
            $(".previous-lecture").show();
        } else if (active == 0) {
            $(".next-lecture").show();
            $(".previous-lecture").show();
        } else {
            $(".next-lecture").show();
            $(".previous-lecture").show();
        }
        //$(".fa-check-circle").css('color', 'black');
        $(this).closest('div').find('.fa-check-circle').css('color', 'green');
        var lectureId = $(this).attr('data-id');
        var lectureType = $(this).attr('data-type');
        $.ajax({
            url: "lernLecturedata?id=" + lectureId,
            success: function (data){
                if(lectureType=='scorm'){
                    $('.scorm_view_modal_content').html('');
                    $('.scorm_view_modal_content').html(data.html);
                    $('#scorm_view_modal').modal('show');
                }
                else{
                    $('.player-canvas').html('');
                    $('.player-canvas').html(data.html);
                }
            }
        });
    });
    $(".start-class").click(function () {
	
        $(".next-lecture").show();
        $(".text-dark1").first().click();
    });
    var clickAct = '';
    $(".next-lecture").click(function (e) {
        var lectureTrueLength = $(".lectureTrue").length;
        lectureTrueLength = lectureTrueLength - 1;
        var lastId = $(".text-dark1.active").attr('id');
        var c = parseInt(selectedId) + parseInt(1);
        $("#" + c).click();
        classlength = $(".text-dark1").length;
        classlength = classlength - 1;
        lectureTruelength = $(".text-dark1").length;
        lectureTruelength = lectureTruelength - 1;
        if (lastId == classlength) {
            if ($(".lastLecture").length) {
                if (lectureTrueLength == classlength) {
                    $.ajax({
                        url: "updateCompletedDate?certify={{$Certify->id}}",
                        success: function (data){
                            if (data) {
                                e.preventDefault();
                                $('#examAlert').modal({backdrop: 'static', keyboard: false});
                            }
                        }
                    });
                } else {
                    $('#examAlertNotComplete').modal({backdrop: 'static', keyboard: false});
                }
            } else {
                $(".text-dark1").eq(classlength).addClass('lastLecture');
            }
        }
    });
    $(".previous-lecture").click(function () {
        var c = parseInt(selectedId) - parseInt(1);
        $("#" + c).click()
    });
    $(".text-dark1").click(function () {
        var activeIndex = $(this).index();
        var lectureId = $(this).attr('data-id');
            $.ajax({
            url: "student/learn/status?lectureId=" + lectureId,
            success: function (data)
            {
                $("#indexLecture"+lectureId).addClass('lectureTrue');
            }
        });
    });
</script>
