@if($data->count() > 0)
<!--<div class="row blog-grid-row">-->
    <!--<div class="row justify-content-center">-->
    @foreach($data as $row)
    
     <div class="col-md-6 col-sm-12">

                        <!-- Blog Post -->
                        <div class="blog grid-blog">
                            <div class="blog-image">
                                <a href="{{route('blog.details',encrypted_key($row->id,"encrypt"))}}">
                                          @if(file_exists( storage_path().'/blog/'.$row->image ) && !empty($row->image))
                                        <img src="{{asset('storage')}}/blog/{{ $row->image }}" height="800px" width="1200px" class=" " alt="...">
                                        @else
                                        <img class="img-fluid" src="{{ asset('assets/img/blog/blog-02.jpg') }}" alt="">
                                        @endif
                                        
                                    </a>
                                
                            </div>
                            <div class="blog-content">
                                <ul class="entry-meta meta-item">
                                    <li>
                                        <div class="post-author">
                                            <a href="{{route('profile',["id"=>encrypted_key($row->user_id,"encrypt")])}}">
                                                 @if(file_exists( storage_path().'/app/'.$row->user->avatar ) && !empty($row->user->avatar))
                                                 <img src="{{asset('storage')}}/app/{{ $row->user->avatar }}" height="30px" width="30px"   class=" " alt="...">
                                        @else
                                        <img src="{{ asset('assets/img/user/user2.jpg') }}" alt="Author"> 
                                        @endif
                                                
                                                
                                                <span>{{ $row->user->name??'' }}</span></a>
                                        </div>
                                    </li>
                                    <li><i class="far fa-clock"></i> <small>{{date('M d, Y', strtotime($row->created_at))}}</small></li>
                                </ul>
                                <h3 class="blog-title"><a href="{{route('blog.details',encrypted_key($row->id,"encrypt"))}}">{{substr($row->title,0,30)}} -{{$row->getcategory($row->category)}}</a></h3>
                                <p class="mb-0">{!! html_entity_decode(ucfirst(substr($row->article,0,60)), ENT_QUOTES, 'UTF-8') !!}</p>
                            </div>
                        </div>
                        <!-- /Blog Post -->

                    </div>

    @endforeach
<!--</div>-->

<!-- Blog Pagination -->
                
                <!-- /Blog Pagination -->


<div class=" col-md-12 d-flex justify-content-center paginationCss">
    {{ $data->appends(request()->except('page'))->links() }}

</div>

 

@else
<div class="text-center errorSection">
    <h3>No Data Found</h3>
</div>
@endif

