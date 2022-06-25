
{{ Form::open(['route' => 'certify.exam.question.store','id' => 'create_question','enctype' => 'multipart/form-data']) }}
<input type="hidden" name="examId" id="examId" value="{{$examId}}">
<div class="form-group">
    <div class="row">
        <div class="col-md-12"> 
            <label class="form-control-label">Enter the question</label> 
            <input type="text" class="form-control chapter-title" name="question" placeholder="Enter the question" required="">
        </div>
    </div>
</div>
<div class="form-group">
    <div class="row">
        <div class="col-md-6">
            <label class="form-control-label">Question type</label> 
            <select class="form-control" name="type" id="questionType">
                <option value="multiple">Multiple Answers</option>
                <option value="single">Single Answer</option>
            </select>
        </div>
        <div class="col-md-6"> 
            <label class="form-control-label">Required Question</label>
            <select class="form-control" name="required">
                <option value="yes">Yes</option>
                <option value="no">No</option> 
            </select>
        </div>
    </div>
</div>
<div class="divider"></div>
<p class="form-control-label">Below are question choices</p>
<center>
    <div id="choiceError" style="display: none;color: red;" class="text-danger">
        <span class="form-control-label text-danger">One Choice or Answer Must be Required</span>
    </div>
</center>
<div class="choices-holder row" id="choiceHolder">

    <div class="col-md-6 single-answer create"> 
        <a style="float: right;" href="javascript:void(0)"  class="delete-choice text-danger" title="Delete Choice">
            <i class="fas fa-trash-alt"></i>
        </a>
        <label class="form-control-label choiseIndexing"> Choice 1<span class="indexing"></span></label>
        <input type="text" class="form-control option-choice" name="answer[]"  placeholder="Choice" required="">
        <div class="correct-answer-box"> 
            <!--<input type="checkbox" class="hidden" name="correct[]" original-name="correct" checked="" value="0">--> 
            <input type="checkbox" class="correct-answer checkCheckbox"  name="correct[]" original-name="correct" value="0"> 
            <label  class="text-xs form-control-label">This is the correct answer</label>
        </div>
    </div>
    <div class="col-md-6 single-answer create"> 
        <a style="float: right;" href="javascript:void(0)"  class="delete-choice text-danger" title="Delete Choice">
            <i class="fas fa-trash-alt"></i>
        </a>
        <label class="form-control-label choiseIndexing"> Choice 2<span class="indexing"></span></label>
        <input type="text" class="form-control option-choice" name="answer[]"  placeholder="Choice" required="">
        <div class="correct-answer-box"> 
            <!--<input type="checkbox" class="hidden" name="correct[]" original-name="correct" checked="" value="0">--> 
            <input type="checkbox" class="correct-answer checkCheckbox"  name="correct[]" original-name="correct" value="0"> 
            <label  class="text-xs form-control-label">This is the correct answer</label>
        </div>
    </div>
    <div class="col-md-6 single-answer create"> 
        <a style="float: right;" href="javascript:void(0)"  class="delete-choice text-danger" title="Delete Choice">
            <i class="fas fa-trash-alt"></i>
        </a>
        <label class="form-control-label choiseIndexing"> Choice 3<span class="indexing"></span></label>
        <input type="text" class="form-control option-choice" name="answer[]"  placeholder="Choice" required="">
        <div class="correct-answer-box"> 
            <!--<input type="checkbox" class="hidden" name="correct[]" original-name="correct" checked="" value="0">--> 
            <input type="checkbox" class="correct-answer checkCheckbox" name="correct[]" original-name="correct" value="0"> 
            <label  class="text-xs form-control-label">This is the correct answer</label>
        </div>
    </div>
    <div class="col-md-6 single-answer create"> 
        <a style="float: right;" href="javascript:void(0)"  class="delete-choice text-danger" title="Delete Choice">
            <i class="fas fa-trash-alt"></i>
        </a>
        <label class="form-control-label choiseIndexing"> Choice 4<span class="indexing"></span></label>
        <input type="text" class="form-control option-choice" name="answer[]"  placeholder="Choice" required="">
        <div class="correct-answer-box"> 
            <!--<input type="checkbox" class="hidden" name="correct[]" original-name="correct" checked="" value="0">--> 
            <input type="checkbox" class="correct-answer checkCheckbox"  name="correct[]" original-name="correct" value="0"> 
            <label  class="text-xs form-control-label">This is the correct answer</label>
        </div>
    </div>
</div>
<br>
<br>
<div class="lecture-buttons-holder">
    {{ Form::button(__('Add Another Choice'), ['type' => 'button','class' => 'btn btn-sm btn-primary rounded-pill addChoice']) }}
    <!--    <button class="btn btn-primary rounded-pill" type="button">
            <i class="fas fa-plus-circle form-control-label"></i> Add another Choice</button>-->
</div>
<br>
<br>




<div class="text-right" style="float:left;">
    {{ Form::button(__('Save'), ['type' => 'submit','class' => 'btn btn-sm btn-primary rounded-pill saveQuestion']) }}
    <button type="button" class="btn btn-sm btn-secondary rounded-pill" data-dismiss="modal">{{__('Cancel')}}</button>
</div>
{{ Form::close() }}

<!--append data-->

<div style="display: none;" id="appendChoise">
    <div class="col-md-6 single-answer create"> 
        <a style="float: right;" href="javascript:void(0)"  class="delete-choice text-danger" title="Delete Choice">
            <i class="fas fa-trash-alt"></i>
        </a>
        <label class="form-control-label choiseIndexing"> choice #<span class="indexing"></span></label>
        <input type="text" class="form-control option-choice" name="answer[]"  placeholder="Choice" required="">
        <div class="correct-answer-box"> 
            <!--<input type="checkbox" class="hidden" name="correct[]" original-name="correct" checked="" value="0">--> 
            <input type="checkbox" class="correct-answer checkCheckbox"  name="correct[]" original-name="correct" value="0"> 
            <label  class="text-xs form-control-label">This is the correct answer</label>
        </div>
    </div>
</div>

<script>
    $(".addChoice").click(function () {
        var html = $("#appendChoise").html();
        $("#choiceHolder").append(html);
        var choiseIndexing = $(".choiseIndexing").length;
        changeChoiseIndexing(choiseIndexing);
    });
    $(document).on("click", ".delete-choice", function () {
        var choiseIndexing = $(".choiseIndexing").length;
        var choiceLength = $('.single-answer.create').length;
//        alert(choiceLength);
        if (choiceLength > 2) {
            $(this).closest('div .single-answer.create').remove();
        } else {
            $('#choiceError').show();
            $("#choiceError").fadeOut(6000, function () {

            });
        }
        var $checkboxes = $('#choiceHolder single-answer input[type="checkbox"]');
        var countCheckedCheckboxes = $checkboxes.filter(':checked').length;
        changeChoiseIndexing(choiseIndexing);
    });
    $(document).on("click", ".correct-answer", function (event) {
        var checkedLength = $(".checkCheckbox:checked").length;
        var questionType = $("#questionType").val();
        if (questionType == 'single') {
//            alert($(this).is(':checked'));
            if ($(this).is(':checked')) {
                if (checkedLength == 1) {
                    var answer = $(this).closest('.single-answer').find('.option-choice').val();
                    $(this).val(answer);
                        if ($(this).is(':checked')) {
                            $(this).addClass('clickAdd');
                        } else {
                            $(this).removeClass('clickAdd');
                        }
                    } else {
                        event.preventDefault();
                        show_toastr('Error', '{{__('Single choice question must have only one answer.')}}', 'error');
                    }
                
            } else {
                var answer = $(this).closest('.single-answer').find('.option-choice').val();
                    $(this).val(answer);
                        if ($(this).is(':checked')) {
                            $(this).addClass('clickAdd');
                        } else {
                            $(this).removeClass('clickAdd');
                        }
            }
            
        } else if (questionType == 'multiple') {
            var answer = $(this).closest('.single-answer').find('.option-choice').val();
            $(this).val(answer);
            if ($(this).is(':checked')) {
                $(this).addClass('clickAdd');
            } else {
                $(this).removeClass('clickAdd');
            }
        }

//        alert(checkedLength);
    });
    $(document).on("click", ".saveQuestion", function (event) {
        var clickAdd = $('.clickAdd').length;
        if (clickAdd == 0) {
            event.preventDefault();
            $('#choiceError').show();
            $("#choiceError").fadeOut(6000, function () {

            });
        }
    });

    $(".option-choice").keyup(function () {
        var data = $(this).val();
        $(this).closest('.single-answer').find('.correct-answer').val(data);
    });

    $("#questionType").change(function (event) {
        var questionType = $("#questionType").val();
        var checkedLength = $(".checkCheckbox:checked").length;
        if(checkedLength > 1){
            if(questionType == 'single'){
                $("#questionType").val("multiple").change();
                event.preventDefault();
                show_toastr('Error', '{{__('If you need to change single answers question type then select only one answer.')}}', 'error');
            }
        }
    });
    function changeChoiseIndexing(choiseIndexing) {
        choiseIndexing = choiseIndexing - 1;
        for (var i = 0; choiseIndexing > i; i++) {
            $(".choiseIndexing").eq(i).html('Choice ' + parseInt(i + 1));

        }
    }
</script>