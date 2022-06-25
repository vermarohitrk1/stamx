@if($data->count() > 0)

<div class="row">
    <!--<div class="row justify-content-center">-->
    @foreach($data as $row)
    <div class="col-lg-3 col-md-6 col-sm-12 d-flex flex-wrap">
        <div class="popular-course">
            <div class="courses-head">
                <div class="courses-img-main">
                     @if(file_exists( storage_path().'/certify/'.$row->image)  && !empty($row->image))
                        <img src="{{asset('storage')}}/certify/{{ $row->image }}" alt="" class="img-fluid w-100">
                    @else
                    <img src="{{asset('assets/img/course/c8.jpg')}}" alt="" class="img-fluid w-100">
                    @endif

                </div>
                @php
                $instructor_id=explode(',',$row->instructor);
                $instructor=\App\Instructor::getInstructordata($instructor_id[0]);
                @endphp
                <div class="courses-aut-img">
                    <img src="{{$instructor->avatar}}" alt="">
                </div>
            </div>
            <div class="courses-body">
                <div class="courses-ratings">
                    <ul class="mb-1">
                        @for($i=1;$i<=5;$i++)
                        <li>	<i class="fas fa-star @if($i<=$instructor->average_rating) checked @else not-checked @endif "></i>
                        </li>
                        @endfor

                    </ul>
                    <p class="mb-1"><a href="{{route('profile',['id'=>encrypted_key($instructor->id,'encrypt')])}}">{{$instructor->name}}</a></p>
                    <h4 class="mb-0"><a href="{{route('course.details',['id'=>encrypted_key($row->id,'encrypt')])}}">{!! html_entity_decode(ucfirst(substr($row->name,0,14)), ENT_QUOTES, 'UTF-8') !!}..</a></h4>
                </div>
            </div>
            <div class="courses-border"></div>
            <div class="courses-footer d-flex align-items-center">
                <div class="courses-count">
                    <ul class="mb-0">
                        <li><i class="fas fa-briefcase mr-1"></i> {{substr((!empty($row->category) && !empty(getCategoryName($row->category)) ? getCategoryName($row->category) :'No category'),0,4)}}..</li>
                    </ul>
                </div>
                <div class="courses-amt ml-auto">
                    <h3 class="mb-0 text-sm">
                        @if(!empty($row->sale_price))
                ${{$row->sale_price}} / <strike>${{$row->price}}</strike>
                @elseif(!empty($row->price))
                ${{$row->price}}
                @else
                Free
                @endif
                    </h3>
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
    <h3>No Data Found</h3>
</div>
@endif

