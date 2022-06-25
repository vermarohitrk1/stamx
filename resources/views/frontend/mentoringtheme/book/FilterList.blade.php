@if($data->count() > 0)
@foreach($data as $book)
<div class="card">
<div class="card-body">
 <div class="mentor-widget mb-5">
                            <div class="user-info-left">
                                <div class="mentor-img">
								  @if(file_exists( storage_path().'/books/'.$book->image)  && !empty($book->image))
								
                                    <a href="{{ url('books/details/'.encrypted_key($book->id,'encrypt'))}}">
                                        <img src="{{asset('storage')}}/books/{{ $book->image }}" class="img-fluid" alt="Book Image">
                                    </a>
									
								@else
									   <a href="{{ url('books/details/'.encrypted_key($book->id,'encrypt'))}}">
                                        <img src="{{ asset('assets/img/user/user.jpg') }}" class="img-fluid" alt="Book Image">
                                    </a>
								  @endif	
									
                                </div>
                                <div class="user-info-cont">
                                    <h4 class="usr-name"><a href="{{ url('books/details/'.encrypted_key($book->id,'encrypt'))}}">{{ substr($book->title,0,20)}}</a></h4>
                                    <p class="mentor-type"> {{!empty($book->category) && !empty($book->getcategory($book->category)) ? 'Best Quality Content For '.$book->getcategory($book->category) :'General'}}</p>
                                    <div class="rating">
                                        
                                    </div>
                                    <div class="mentor-details">
                                        <!-- <p class="user-location"><i class="fas fa-clock"></i> {{time_elapsed($book->created_at)}}</p> -->
                                        <p class="user-locations"><i class="fas fa-dollar-sign"></i>@if($book->price != null) {{ $book->price }} @else not available  @endif</p>
                                        <p class="user-locations"><i class="fa fa-user" aria-hidden="true"></i>@if($book->author != null)  {{ $book->author }} @else not available  @endif</p>
                                        <p class="user-locations"><i class="fa fa-map-marker" aria-hidden="true"></i> @if($book->marketplace != null)  {{ $book->marketplace }} @else not available  @endif</p>

                                       

                                    </div>
                                </div>
                            </div>
                            <div class="user-info-right">
                                <div class="user-infos">
                                    <ul>
                                        <li><i class="fa fa-tags"></i> {{!empty($book->category) && !empty($book->getcategory($book->category)) ? $book->getcategory($book->category) :'General'}}</li>
                                      
                                    </ul>
                                </div>
                                <div class="mentor-booking">
                                    <a class="apt-btn" href="{{ url('books/details/'.encrypted_key($book->id,'encrypt'))}}">Details</a>
                                </div>
                            </div>
                        </div>
            </div></div>
@endforeach
<div class=" col-md-12 d-flex justify-content-center paginationCss">
        {{ $data->appends(request()->except('page'))->links() }}

    </div>

@else
<div class="text-center errorSection">
    <span>No Data Found</span>
</div>
@endif

