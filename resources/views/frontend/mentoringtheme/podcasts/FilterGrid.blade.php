@if($data->count() > 0)
<div class="row">
    <style>.podcat_sec {
    display: flex;
    flex-direction: column;
}

.podcat_sec .user-info-left {
    flex-direction: column;
    text-align: center;
}

.podcat_sec  .user-info-right {
    margin-left: 0;
    flex: 0 0 0;
    max-width: 100%;
}

.podcat_sec  .mentor-img {


    width: 145px;
    margin: auto;
    padding-bottom: 20px;
}</style>
    <!--<div class="row justify-content-center">-->
    @foreach($data as $row)
    <div class="col-12 col-md-6 podcat_sec mentor-widget mb-5 pagify-child">
    <div class="card">
<div class="card-body">
                            <div class="user-info-left">
                                <div class="mentor-img">	
                                  @if(file_exists( storage_path().'/podcasts/'.$row->image)  && !empty($row->image))
                                    <a href="{{ route('podcast_detail',['id'=>encrypted_key($row->id,'encrypt')]) }}">  
                                        <img src="{{asset('storage')}}/podcasts/{{ $row->image }}" class="img-fluid" alt="Podcast Image"> </a>
                                    @else
                                    <img src="{{ asset('public')}}/demo23/image/patterns/globe-pattern.png" class="img-fluid" alt="Podcast Image">
                                    @endif
                                </div>
                                <div class="user-info-cont">
                                    <h4 class="usr-name"><a class="font-size-6 heading-default-color" href="{{ route('podcast_detail',['id'=>encrypted_key($row->id,'encrypt')]) }}">{{$row->title}}</a></h4>
                                    <p class="mentor-type"><a href="{{ route('podcast_detail',['id'=>encrypted_key($row->id,'encrypt')]) }}" class="font-size-3 text-default-color line-height-2">
                                        @if(!empty($row->episode)) Episode-{{ $row->episode }}: @endif

                                    </a></p>
                                    <div class="mentor-details">
                                        <p class="user-location"><i class="fas fa-clock"></i>  {{time_elapsed($row->created_at)}}</p>
                                    </div>
                                    <p>{{ \Illuminate\Support\Str::limit($row->description, 150, $end='...') }}</p>
                                </div>
                            </div>
                            <div class="user-info-right">
                                <div class="user-infos">
                                <ul> <li>
                                    <a class="bg-regent-opacity-15 min-width-px-96 mt-5 mr-3 text-center rounded-3 px-6 py-1 font-size-3 text-black-2 mt-2" href="#">
                                    @if(!empty($row->file))    
                                        <audio preload="auto" controls style="width: 300px !important">
                                            <source src="{{$row->file}}" />
                                        </audio>
                                        @endif
                                    </a>
                                </li></ul>
                                </div>
                                <div class="mentor-booking">
                                <a class="apt-btn" href="{{ route('podcast_detail',['id'=>encrypted_key($row->id,'encrypt')]) }}">  Details</a>
                                </div>
                          
                            </div>
                        </div>
                        </div>
                        </div>
    @endforeach
</div>
<div class=" col-md-12 d-flex justify-content-center paginationCss">
    {{ $data->appends(request()->except('page'))->links() }}

</div>

@else
<div class="text-center errorSection">
    <span>No Data Found</span>
</div>
@endif
<!-- <div class="col-md-12">
<div class="row blog-grid-row">
<div class="col-md-6 col-sm-12">

<div class="blog grid-blog">
<div class="blog-image">
<a href="blog-details"><img class="img-fluid" src="assets/img/blog/blog-09.jpg" alt="Post Image"></a>
</div>
<div class="blog-content">
<ul class="entry-meta meta-item">
<li>
<div class="post-author">
<a href="profile"><img src="assets/img/user/user9.jpg" alt="Post Author"> <span>John Gibbs</span></a>
</div>
</li>
 <li><i class="far fa-clock"></i> 24 Nov 2019</li>
</ul>
<h3 class="blog-title"><a href="blog-details">packages and web page editors now use Lorem</a></h3>
<p class="mb-0">Lorem ipsum dolor sit amet, consectetur em adipiscing elit, sed do eiusmod tempor.</p>
</div>
</div>

</div>

</div>


</div> -->
<script>

    $(function ()
    {
        $('audio').audioPlayer();
    });
</script>