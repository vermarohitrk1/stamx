<div>
    @if(!empty($candidateQuestionData))
        @foreach($candidateQuestionData as $question)
            <div class="card border-0 shadow mt-3 p-2">
                <p class="mb-2">Ques : {{__((isset($question->label)?$question->label:''))}}</p>
                <p class="mb-0 text-muted"><strong>Ans. : </strong>{{__((isset($question->value)?$question->value:''))}}</p>
            </div>
        @endforeach
    @endif
</div>
