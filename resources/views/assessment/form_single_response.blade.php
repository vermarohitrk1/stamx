
    {{--Main Part--}}
  
                    
                    @if(!empty(json_decode($response->response, true)))
                    @foreach(json_decode($response->response, true) as $i => $row)
                    <div class="form-group">
                        <div class="row">
                            <div class="col-md-12">
                                <label class="form-control-label text-muted">{{ $row['question'] }} (Points:{{ $row['points'] }})</label>
                                <p class="form-control-label"><b>{{__('Answer:')}}</b> {{ $row['answer'] }} </p>
                               
                            </div>
                        </div>
                    </div>
                    @endforeach
                    
                    <h5 class="text-center text-primary">Form Filled By: <b>{{ucwords($response_by_user)}}</b></h5>
                    @else
                    <div class="empty-section">
                        <i class="fa fa-clipboard-text"></i>
                        <h6 class="text-danger">No response recorded </h6>
                    </div> 
                    
                    @endif
               