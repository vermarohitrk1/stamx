<div class="min-height-250">
    <!---->
    <div class="timeline">
        @if(!empty($candidateTimeline))
            @foreach($candidateTimeline as $timeline)
            <div class="timeline-step">
                <div class="number"></div>
                <div class="timeline-info">
                    <p class="time">
                        {{ date('d-m-Y g:i A', strtotime($timeline->created_at)) }}
                    </p>
                    <p class="description">{!!  $timeline->message !!}</p>
                </div>
            </div>
            @endforeach
        @endif
    </div>
    <!---->
</div>
