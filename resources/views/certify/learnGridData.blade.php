<div class="lecture-box mt-15">
    <h4>{{$lecture->title}}</h4>
    <p>{{ strip_tags($lecture->description) }} </p>
    <div class="divider">
    	<h2>Lecture Content</h2>
    	<div class="content">
	    	@if($lecture->type == 'text')
	    		{{ strip_tags($lecture->content) }}
	   	 	@elseif($lecture->type == 'link')
	   	 		<a href="{{ $lecture->content }}">{{ $lecture->content }}</a>
	   	 	@elseif($lecture->type == 'downloads')
	   	 		<video width="500" controls="">
		      		<source src="{{asset('storage')}}/app/{{ $lecture->content }}" type="video/mp4">
      				Your browser does not support HTML5 video.
		    	</video>
	   	 	@elseif($lecture->type == 'video')
	   	 		<video width="500" controls="">
		      		<source src="{{asset('storage')}}/app/{{ $lecture->content }}" type="video/mp4">
                    Your browser does not support HTML5 video.
		    	</video>
	   	 	@elseif($lecture->type == 'pdf')
	   	 		<h1>PDF FILE</h1>
    			<p><a href="{{asset('storage')}}/app/{{ $lecture->content }}">Open a PDF file.</a></p>
            @elseif($lecture->type == 'scorm')
                <h1>Scorm File</h1>
                <p>
                    <iframe id="scorm_iframe" frameBorder="0" style="min-height: 500px;" src="{{$lecture->getScormUrl()}}" width="100%" title="Scorm course"></iframe>
                </p>
	   	 	@endif
	    </div>
    </div>
</div>
