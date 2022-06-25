@if($data->count() > 0)
<div class="doc-review review-listing">

    <!-- Review Listing -->
    <ul class="comments-list">
        @foreach($data as $review)
        @php
        $user_data=\App\User::find($review->user_id);
        @endphp
        <!-- Comment List -->
        <li> 
            <div class="comment">
                <img class="avatar rounded-circle" alt="User Image" src="{{ $user_data->getAvatarUrl()}}">
                <div class="comment-body" style="width: 100%">
                    <div class="meta-data">
                        <span class="comment-author">{{$review->display=="Yes" ? $user_data->name:"Anonymous"}}</span>
                        <span class="comment-date float-right pull-right"> {{time_elapsed($review->created_at)}}</span>
                    
                    </div>
                    <!-- <p class="recommended"><i class="far fa-thumbs-up"></i> I recommend the consectetur</p> -->

                    <p class="comment-content">
                        {{$review->comment}}
                    </p>

                </div>
            </div>
            
        </li>
        <!-- /Comment List -->

        @endforeach


    </ul>
    <!-- /Comment List -->

</div>
<div class=" col-md-12 d-flex justify-content-center paginationCss">
    {{ $data->appends(request()->except('page'))->links() }}

</div>




@else
<div class="mt-3">
    <p class="text-muted font-italic p-3 bg-light text-center rounded">No Comment Exist</p>
</div>
@endif

