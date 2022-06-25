<?php $page = "exam"; ?>
@extends('layout.dashboardlayout')
@section('content')	
<link href="https://gitcdn.github.io/bootstrap-toggle/2.2.2/css/bootstrap-toggle.min.css" rel="stylesheet">

<link rel="stylesheet" href="{{ asset('css/switchery/switchery.min.css') }}">
<script>
 
</script>

<style>
.em_sec {
    width: 100%;
}
.exam_sts {
    display: flex;
    justify-content: right;
    float: right;
    align-items: center;
}
.modal-open .main-wrapper {
 
    filter: inherit;
}
    .panel.panel-default.chapter {
        border: 1px solid #ddd;
        padding-top: 8px;
        padding-left: 11px;
        margin: 4px;
        background-color: whitesmoke;
        border-radius: 4px;
    }

    .panel.panel-default.lecture {
        border: 1px solid #ddd;
        padding-top: 8px;
        padding-left: 11px;
        margin: 4px;
        background-color: whitesmoke;
        border-radius: 4px;
    }
    .collS{   width: 100%;
              display: inline-block;
              height: 100%;
              margin-top: 5px;
    }
    .collS1{   width: 100%;
               display: inline-block;
               height: 100%;
               margin-top: 5px;
    }
    span.panel-label {
        font-weight: lighter;
        color: #777;
        font-size: 18px;
    }
    .fas.fa-arrows-alt
    {
        cursor: all-scroll;
    }
    .col-md-6.single-answer {
        max-width: 49%;
    }
    input.form-control.chapter-title {
        max-width: 98%;
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
 


                     </div>
   
<!-- Breadcrumb -->
<div class="breadcrumb-bar mt-3">
    <div class="container-fluid">
        <div class="row align-items-center">
            <div class="col-md-12 col-12">
                <h2 class="breadcrumb-title">   @if(!empty($Certify))
    {{$Certify->name}}
    @endif</h2>
                <nav aria-label="breadcrumb" class="page-breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{route('dashboard')}}">Home</a></li>
                        <li class="breadcrumb-item"><a href="{{route('certify.index')}}">Courses</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Exam Edit</li>
                    </ol>
                </nav>
            </div>              
        </div>            
    </div>
</div>
<!-- /Breadcrumb -->


 <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header">
		
  <h5 class=" h6 mb-0">{{__('Exam Details')}}</h5>
 <div class="exam_sts">
 {{ Form::open(['route' => 'certify.exam.status','id' => 'status_exam','enctype' => 'multipart/form-data']) }}
 
<input type="hidden" name="examId" value="{{$exam->id}}">
<input type="hidden" name="status" value="{{$exam->status}}">
<div class="custom-control custom-switch">
    <input type="checkbox" class="custom-control-input" id="customSwitches" @if( $exam->status == "Published" ) checked @endif >
    <label class="custom-control-label" for="customSwitches"></label>
</div>
{{ Form::close() }}
<span class="text-black">Published</span>
            </div>
            </div>
			
			
			  <div class="card-body">
                    {{ Form::open(['url' => 'certify/exam/update','id' => 'edit_exam','enctype' => 'multipart/form-data']) }}
                    <div class="form-group">
                        <div class="row">
                            <div class="col-md-6">
                                <label>Exam Name</label>
                                <input type="text" class="form-control class-name" name="name" placeholder="Exam Name" value="{{ $exam->name }}" required>
                                <input type="hidden" name="examid" value="{{ $exam->id }}">
                            </div>
                            <div class="col-md-6">
                                <label>Exam maximum retakes</label>
                                <input type="number" class="form-control just-number" name="retakes" min="0" placeholder="Exam maximum retakes" value="{{ $exam->retakes }}" required>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="row">
                            <div class="col-md-12">
                                <label>Exam Description</label>
                                <textarea class="form-control" name="description" placeholder="Exam Description" rows="4" required>{{ $exam->description }}</textarea>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="row">
                            <div class="col-md-12">
                                {{ Form::button(__('Save'), ['type' => 'submit','class' => 'btn btn-sm btn-primary rounded-pill']) }}
                                <a href="javascript:void(0)" data-id="{{ $exam->id }}" class="btn btn-sm btn-danger rounded-pill mr-2 m-0 destroyExam" >
                                    <span class="btn-inner--text text-white">{{__('Delete Exam')}}</span>
                                </a>
                            </div>
                        </div>
                    </div>
                    {{ Form::close() }}
                </div>
            </div>
            </div>
			
			
			
			<div class="em_sec">
    <div class="col-md-12">
        <div class="card">
            <div class="card-header">
                <center><span style="color: red;display: none;" id="requiredError">!All Fields are Required Check Fields Some Fields are Empty<br>One Choice or Answer Must be Required from each Question</span></center>
                <center>
                    <div id="choiceErrorEdit" style="display: none;color: red;" class="text-danger">
                        <span class="form-control-label text-danger">One Choice or Answer Must be Required from each Question</span>
                    </div>
                </center>
                <h4>Question</h4>
                <p class="text-muted mb-0">A Exam can contain multiple Question, a Question could be single or multiple choice</p>
            </div>
            <div class="card-body">
                {{ Form::open(['route' => 'certify.exam.question.update','id' => 'update_question','enctype' => 'multipart/form-data']) }}
                <input type="hidden" name="exam" value="{{ $exam->id }}">
                <div class="online-classes-list">
                    <div class="panel-group chapter-holder" id="accordion">
                        @if (count($questions) > 0 )
                        @foreach ($questions as $index => $question)
                        <div class="panel panel-default chapter validate{{$index}} " >
                            <div class="panel-heading">
                                <h4 class="panel-title">
                                    <div class="row">
                                        <div class="col-11">
                                            <a class=" text-dark collS collapsed" data-toggle="collapse" data-parent="#accordion" href="#question{{ $question->id }}">
                                                <div class="chapter-drag"></div>
                                                <i class="fas fa-arrows-alt"></i>&nbsp;
                                                <span class="indexing">{{ $index + 1 }}.)</span>  <span class="panel-label text-dark">{{ $question->question }}</span> 
                                            </a>
                                        </div>
                                        <div class="col-1">
                                            <a href=" " style="float:right;outline: auto;margin-right: 6px;" class="btn text-danger btn-default btn-sm pull-right manage-class delete-item destroyQuestion" data-id="{{ $question->id }}" data-type="querstion" title="Delete chapter"><i class="fas fa-trash-alt"></i></a>
                                        </div>
                                    </div>
                                </h4>
                            </div>
                            <div id="question{{ $question->id }}" class="panel-collapse collapse chapter-body">
                                <div class="panel-body">
                                    <div class="form-group">
                                        <div class="row">
                                            <div class="col-md-12"> 
                                                <label class="text-dark">Enter the question</label>
                                                <input type="text" class="form-control chapter-title" name="question[]" placeholder="Enter the question" value="{{ $question->question }}" required>
                                                <input type="hidden" class="question-indexing" name="indexing[]" value="{{ $question->indexing }}"> 
                                                <input type="hidden" name="questionid[]" value="{{ $question->id }}">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <div class="row">
                                            <div class="col-md-6">
                                                <label class="text-dark">Question type</label> 
                                                <select class="form-control answerType"  style="max-width: 96%;" name="type[]" original-name="type">
                                                    <option value="multiple" @if( !empty( $question->type == "multiple" ) ) selected @endif>Multiple Answers</option>
                                                    <option value="single" @if( !empty( $question->type == "single" ) ) selected @endif>Single Answer</option>
                                                </select>
                                            </div>
                                            <div class="col-md-6">
                                                <label class="text-dark">Required Question</label> 
                                                <select class="form-control" style="max-width: 96%;" name="required[]" original-name="required">
                                                    <option value="yes" @if( !empty( $question->required == "yes" ) ) selected @endif>Yes</option>
                                                    <option value="no" @if( !empty( $question->required == "no" ) ) selected @endif>No</option>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="divider"></div>
                                    <p class="text-dark">Below are question choices</p>
                                    <center>
                                        <div  style="display: none;color: red;" class="text-danger choiceErrorEdit">
                                            <span class="form-control-label text-danger">One Choice or Answer Must be Required</span>
                                        </div>
                                    </center>
                                    <div class="choices-holder row">
                                        @foreach ($question->answers as $key => $answer)
                                        <div class="col-md-6 single-answer "> 
                                            <a style="float: right;" href="javascript:void(0)"  class="delete-choice1 text-danger" title="Delete Choice">
                                                <i class="fas fa-trash-alt"></i>
                                            </a>
                                            <label class="form-control-label text-dark editChoiseIndexing"> Choice {{$key+1}}<span class="indexing"></span></label>
                                            <input type="text" class="form-control option-choice" name="answer[{{ $question->id }}][]" value="{{$answer}}"  placeholder="Choice" required="">
                                            <div class="correct-answer-box"> 
                                                <!--<input type="checkbox" class="hidden" name="correct[]" original-name="correct" checked="" value="0">-->
                                                @php $corrects = collect($question->correct)->toArray() @endphp
                                                <input type="checkbox" class="checkAnswerType correct-answer @if(in_array($answer, $corrects)) clickEdit  @endif "  name="correct[{{ $question->id }}][]" original-name="correct" @if(in_array($answer, $corrects)) checked="" value="{{$answer}}" @else value="0" @endif > 
                                                <label  class="text-xs text-dark form-control-label">This is the correct answer</label>
                                            </div>
                                        </div>

                                        @endforeach
                                    </div>
                                    <br>
                                    <br>
                                    <button type="button" class="btn btn-sm btn-primary rounded-pill addNewChoice" data-id="{{ $question->id }}" >Add Another Choice</button>
                                    <br><br><br>
                                </div>
                            </div>
                        </div>
                        <!--new content-->
                        @endforeach
                        @else
                        <div class="empty-section">
                            <i class="fa fa-clipboard-text"></i>
                            <h5>No questions here, add a new one below!</h5>
                        </div>
                        @endif
                    </div>
                    <br>
                    <br>
                    <div class="form-group">
                        <div class="row">
                            <div class="col-md-12 mt-15">
                                <button class="btn btn-sm btn-primary rounded-pill" type="submit" id="saveQuestions"><i class=" fa fa-content-save"></i> Save Changes</button>
                                <a href="#" data-url="{{ route('certify.exam.question.create', ['id' => $exam->id]) }}" data-ajax-popup="true" data-size="lg" data-title="{{__('Create Exam Question')}}" class="btn btn-primary btn-sm rounded-pill">
                                    <span class="btn-inner--text text-white"><i class="fa fa-airplay"></i> {{__(' Add Question ')}}</span>
                                </a>
                                <!--<button class="btn btn-primary btn-sm rounded-pill add-question" type="button"><i class=" fa fa-plus-circle-outline"></i> Add Question</button>-->
                            </div>
                        </div>
                    </div>
                </div>
                {{ Form::close() }}
            </div>
        </div>
        <!--end questions-->
    </div>
</div>
            </div>
        </div>

    </div>

</div>		
<!-- /Page Content -->

@endsection
@push('script')
<!-- Modal -->
<div id="destroyQuestion" class="modal fade" role="dialog">
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
                {{ Form::open(['route' => 'certify.exam.question.distroy','id' => 'destroy_question','enctype' => 'multipart/form-data']) }}
                <input type="hidden" name="questionDeleteId" id="questionDeleteId"  value="">

                <button type="submit" class="btn btn-sm btn-danger rounded-pill" id="">Yes</button>
                {{ Form::close() }}
                <button type="button" class="btn btn-sm btn-secondary rounded-pill" id="" data-dismiss="modal" aria-label="Close">Cancel</button>
            </div>
        </div>
    </div>
</div>
<!-- Modal -->
<div id="destroyExam" class="modal fade" role="dialog">
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
                {{ Form::open(['url' => 'certify/exam/destroy','id' => 'destroy_exam','enctype' => 'multipart/form-data']) }}
                <input type="hidden" name="examId" id="examId"  value="">

                <button type="submit" class="btn btn-sm btn-danger rounded-pill" id="">Yes</button>
                {{ Form::close() }}
                <button type="button" class="btn btn-sm btn-secondary rounded-pill" id="" data-dismiss="modal" aria-label="Close">Cancel</button>
            </div>
        </div>
    </div>
</div>

<!--append data-->

<div style="display: none;" id="appendChoise1">
    <div class="col-md-6 single-answer"> 
        <a style="float: right;" href="javascript:void(0)"  class="delete-choice1 text-danger" title="Delete Choice">
            <i class="fas fa-trash-alt"></i>
        </a>
        <label class="form-control-label editChoiseIndexing"> Choice #<span class="indexing"></span></label>
        <input type="text" class="form-control option-choice" name="answer[][]"  placeholder="Choice" required="">
        <div class="correct-answer-box"> 
            <input type="checkbox" class="checkAnswerType correct-answer"  name="correct[][]" original-name="correct" value="0"> 
            <label  class="text-xs form-control-label">This is the correct answer</label>
        </div>
    </div>
</div>



<script src="{{ asset('assets/libs/apexcharts/dist/apexcharts.min.js') }}"></script>
<script src="{{ asset('js/jquery-ui/jquery-ui.min.js') }}"></script>
<script src="https://gitcdn.github.io/bootstrap-toggle/2.2.2/js/bootstrap-toggle.min.js"></script>
<!--<script src="{{ asset('js/exam.js') }}"></script>--> 
<script src="{{ asset('js/builder.js') }}"></script> 
<script>
   $(function () {
        $('#toggle-two').bootstrapToggle({
            on: 'Enabled',
            off: 'Disabled'
        });
    })

    $(document).on("click", ".destroyExam", function () {
        var id = $(this).attr('data-id');
        $("#examId").val(id);
        $('#destroyExam').modal('show');

    });
    $(document).on("click", ".destroyQuestion", function () {
        var id = $(this).attr('data-id');
        $("#questionDeleteId").val(id);
        $('#destroyQuestion').modal('show');

    });
    $(document).on("click", ".addNewChoice", function () {
        var id = $(this).attr('data-id');
        $('#appendChoise1').find('.option-choice').attr('name', '');
        $('#appendChoise1').find('.option-choice').attr('name', 'answer[' + id + '][]');
        $('#appendChoise1').find('.correct-answer').attr('name', '');
        $('#appendChoise1').find('.correct-answer').attr('name', 'correct[' + id + '][]');
        var html = $('#appendChoise1').html();
//  alert(html);
        $(this).closest('.panel-body').find('.choices-holder').append(html);
        var choiseIndexing = $(".editChoiseIndexing").length;
        changeChoiseIndexing(choiseIndexing);

    });

    $("#saveQuestions").click(function (event) {
        $('html, body').animate({
            scrollTop: $(".destroyExam").offset().top
        }, 700);
        $('.chapter').each(function (i, obj) {
            var selected = $(this).find('.clickEdit').length;
            if (selected == 0) {
                event.preventDefault();
                $('#choiceErrorEdit').show();
                $("#choiceErrorEdit").fadeOut(6000, function () {
                });
            } else {
                setTimeout(function () {
                    $("#requiredError").show();

                }, 2000);
            }

        });
    });

</script>
<script>
    $(".addChoice").click(function () {
        var html = $("#appendChoise1").html();
        $("#choiceHolder").append(html);
    });

    $(document).on("click", ".delete-choice1", function () {
        var choiceLength = $(this).closest('.choices-holder').find('.delete-choice1').length;
        if (choiceLength > 1) {
            $(this).closest('div .single-answer').remove();
        } else {
            $('.choiceErrorEdit').show();
            $(".choiceErrorEdit").fadeOut(6000, function () {
            });
        }
        var choiseIndexing = $(".editChoiseIndexing").length;
        changeChoiseIndexing(choiseIndexing);
    });
    $(document).on("click", ".correct-answer", function () {
        var checkedLength = $(this).closest('.chapter-body').find('.checkAnswerType:checked').length;
        var questionType = $(this).closest('.chapter-body').find('.answerType').val();
        if (questionType == 'single') {
            if ($(this).is(':checked')) {
                if (checkedLength == 1) {
                var answer = $(this).closest('.single-answer').find('.option-choice').val();
                $(this).val(answer);
                if ($(this).is(':checked')) {
                    $(this).addClass('clickEdit');
                } else {
                    $(this).removeClass('clickEdit');
                }
            } else {
                event.preventDefault();
                show_toastr('Error', '{{__('Single choice question must have only one answer.')}}', 'error');
            }
            }else{
                var answer = $(this).closest('.single-answer').find('.option-choice').val();
                $(this).val(answer);
                if ($(this).is(':checked')) {
                    $(this).addClass('clickEdit');
                } else {
                    $(this).removeClass('clickEdit');
                }
            }
            
        } else if (questionType == 'multiple') {
            var answer = $(this).closest('.single-answer').find('.option-choice').val();
            $(this).val(answer);
            if ($(this).is(':checked')) {
                $(this).addClass('clickEdit');
            } else {
                $(this).removeClass('clickEdit');
            }
        }
    });
    $(document).on("keyup", ".option-choice", function () {
        var data = $(this).val();
        $(this).closest('.single-answer').find('.correct-answer').val(data);
    });
    $(".answerType").change(function (event) {
        var checkedLength = $(this).closest('.chapter-body').find('.checkAnswerType:checked').length;
        var questionType = $(this).closest('.chapter-body').find('.answerType').val();
        if(checkedLength > 1){
            if(questionType == 'single'){
                $(this).val("multiple").change();
                event.preventDefault();
                show_toastr('Error', '{{__('If you need to change single answers question type then select only one answer.')}}', 'error');
            }
        }
    });
    function changeChoiseIndexing(choiseIndexing) {
        choiseIndexing = choiseIndexing - 1;
        for (var i = 0; choiseIndexing > i; i++) {
            $(".editChoiseIndexing").eq(i).html('Choice ' + parseInt(i + 1));

        }
    }
</script>
<script>
    $(document).on("click", "#customSwitches", function () {
        $('#status_exam').submit();
    });

</script>
@endpush

