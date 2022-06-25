@if($data->count() > 0)
@foreach($data as $row)
<div class="card">
<div class="card-body">
 <div class="mentor-widget mb-5">
                            <div class="user-info-left">
                                <div class="mentor-img">	
                                  @if(file_exists( storage_path().'/podcasts/'.$row->image)  && !empty($row->image))
                                    <a href="{{ route('podcast_detail',['id'=>encrypted_key($row->id,'encrypt')]) }}">  
                                        <img src="{{asset('storage')}}/podcasts/{{ $row->image }}" class="img-fluid" alt="Podcasts Image"> </a>
                                    @else
                                    <img src="{{ asset('public')}}/image/patterns/globe-pattern.png" class="img-fluid" alt="Podcasts Image">
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
                                    <div class="user-infos">
                                    <a class="bg-regent-opacity-15 min-width-px-96 mt-5 mr-3 text-center rounded-3 px-6 py-1 font-size-3 text-black-2 mt-2" href="#">
                                       @if(!empty($row->file))
                                        <audio preload="auto" controls style="width: 300px !important">
                                            <source src="{{$row->file}}" />
                                        </audio>
                                        @endif
                                    </a>
                                    </div>
                                </div>
                                
                            </div>
                            <div class="user-info-right px-5">
                                
                                <div class="mentor-booking">
                                <a class="apt-btn" href="{{ route('podcast_detail',['id'=>encrypted_key($row->id,'encrypt')]) }}">  Details</a>
                                </div>
                          
                            </div>
                        </div>
                        </div>
                        </div>
@endforeach
<div class=" col-md-12 d-flex justify-content-center paginationCss">
        {{ $data->appends(request()->except('page'))->links() }}

    </div>

@else
<div class="text-center errorSection">
    <span>No Data Found</span>
</div>
@endif

<script>
    $(function ()
    {
        $('audio').audioPlayer();
    });
</script>
