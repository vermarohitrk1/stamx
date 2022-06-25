
    {{--Main Part--}}
  
                    
                    @if(!empty(json_decode($response->response, true)))
                    @foreach(json_decode($response->response, true) as $i => $row)
                    <div class="form-group">
                        <div class="row">
                            <div class="col-md-12">
                                <label class="form-control-label text-muted">{{ $row['question'] }} </label>
                                <p class="form-control-label"><b>{{__('Answer:')}}</b> {{ $row['answer'] }}</p>
                                @php
                                $question=\App\CrmCustomFormQuestions::find($row['question_id']);
                                if(!empty($question->type) && $question->type=="selectwith" && !empty($question->resource_url) && $row['answer']=="Yes" ){
                                @endphp
                                <p class="form-control-label"><b>{{__('Resource:')}}</b> <a target="_blank" href="{{$question->resource_url}}">Visit Details</a></p>
                                @php
                                }
                                @endphp
                            </div>
                        </div>
                    </div>
                    @endforeach
                    
                    <h5 class="text-center text-primary">Supporter: <b>{{ucwords($response_by_user)}}</b></h5>
                    @else
                    <div class="empty-section">
                        <i class="fa fa-clipboard-text"></i>
                        <h6 class="text-danger">No response recorded </h6>
                    </div> 
                    
                    @endif
               