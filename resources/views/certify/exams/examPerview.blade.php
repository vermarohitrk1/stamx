<?php $page = "exam"; ?>
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
                        <li class="breadcrumb-item active" aria-current="page">Exam Preview</li>
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
		


            </div>
			
			<div class="card-body">
                    <center>
                        <div  style="display: none;color: red;" class="text-danger answerErrorEdit">
                            <span class="form-control-label text-danger">One  Answer Must be Required from each Question</span>
                        </div>
                    </center>
                    @if ( $takes > 0 )
                    <div class="exam-complete">
                        <i class="fa fa-checkbox-multiple-marked-circle complete-icon"></i>
                        <h3>You sat this exam and scored <span class="text-success">{{ $lastTake->score }}%</span></h3>
                        @if ( $takes <= $exam->retakes || $user->type == "admin" ||  $user->type == "owner" )
                        {{ Form::button(__('Retake Exam'), ['type' => 'submit','class' => 'btn btn-sm btn-primary rounded-pill retake-exam']) }}
                        @endif
                    </div>
                    @endif

                    @if ( $takes > 0 )
                    <div class="exam-question-section" style="display: none;">
                        @else
                        <div class="exam-question-section">
                            @endif

                            <span class="text-muted text-xs">Questions with (<span class="text-danger">*</span>) are required.</span>
                            <p>{{ $exam->description }}</p>
                            {{ Form::open(['route' => 'certify.exam.perview.save','id' => 'examPerview_save','enctype' => 'multipart/form-data']) }}
                            <input type="hidden" name="examid" value="{{ $exam->id }}">
                            <input type="hidden" name="questionCount" value="{{ count($questions) }}">
                            @if (!empty($questions))
                            @foreach ($questions as $index => $question)
                            <div class="form-group answerCheckbox">
                                <div class="row">
                                    <div class="col-md-12">
                                        <label>{{ $index + 1 }}.) {{ $question->question }}
                                            @if( $question->required == "yes" )
                                            <span class="text-danger">*</span>
                                            @endif
                                        </label>
                                        <input type="hidden" name="question[]" value="{{ $question->id }}">
                                        @foreach ($question->answers as $key => $answer)
                                        <div>
                                            <input type="checkbox" class="correct-answer" name="answer[{{ $question->id }}][]" value="{{$answer}}">
                                            <label>{{ $answer }}</label>
                                        </div>
                                        @endforeach
                                    </div>
                                </div>
                            </div>
                            @endforeach
                            <div class="form-group">
                                <div class="row">
                                    <div class="col-md-12">
                                        {{ Form::button(__('Submit for marking'), ['type' => 'submit','class' => 'btn btn-sm btn-primary rounded-pill submit-answer']) }}
                                        <!--<button type="submit" class="btn btn-primary btn-icon"><i class="fa fa-check-all"></i> Submit for marking</button>-->
                                    </div>
                                </div>
                            </div>
                            @else
                            <div class="empty-section">
                                <i class="fa fa-clipboard-text"></i>
                                <h5>No questions set for this exam!</h5>
                            </div>
                            @endif

                            {{ Form::close() }}

                        </div>
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

@endsection

@push('script')
<script src="{{ asset('js/jquery-ui/jquery-ui.min.js') }}"></script> 
<script>
    $( ".retake-exam" ).click(function() {
        $('.exam-question-section').show();
        $('.exam-complete').hide();
    });
    
    $(document).on("click", ".correct-answer", function () {
        if ($(this).is(':checked')) {
            $(this).addClass('clickEdit');
        } else {
            $(this).removeClass('clickEdit');
        }
    });
    
    $(".submit-answer").click(function (event) {
    $('html, body').animate({
        scrollTop: $("#back").offset().top
    }, 700);
    $('.answerCheckbox').each(function (i, obj) {
        var selected = $(this).find('.clickEdit').length;
        if (selected == 0) {
            event.preventDefault();
            $('.answerErrorEdit').show();
            $(".answerErrorEdit").fadeOut(6000, function () {
            });
        }

    });
});
</script>
@endpush
