<div>
    @if(!empty($attachment))
        <div class="card border-0 shadow mt-3 p-5">
            <p class="mb-0 text-muted">
                <a href="{{ asset($attachment->getJobResume($attachment->value)) }}" target="_blank">
                    @if($extension == "pdf")
                        <img src="{{ asset('public/img/pdf-2.png')}}"/>{{ __('Resume') }}
                    @else
                        <img src="{{ asset('public/img/google-docs--v1.png')}}"/>{{ __('Resume') }}
                    @endif
                </a>
                <a href="{{ asset($attachment->getJobResume($attachment->value)) }}" id="download-icon" class="download-icon float-right" title="download" download>
                    <img src="{{ asset('public/img/download--v2.png')}}"/>
                </a>
            </p>
        </div>
    @endif
</div>
