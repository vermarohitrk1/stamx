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
                        <span class="comment-author">{{$user_data->name}}</span>
                        <span class="comment-date">Reviewed {{time_elapsed($review->created_at)}}</span>
                        <div class="review-count rating pull-right">
                            @for($i=1; $i<=5;$i++) 
                            <i class="fas fa-star @if(!empty((int) $review->rating) && $i<= (int) $review->rating) filled @endif">
                                </i>
                                @endfor

                        </div>
                    </div>
                    <!-- <p class="recommended"><i class="far fa-thumbs-up"></i> I recommend the consectetur</p> -->

                    <p class="comment-content">
                        {{$review->comment}}
                    </p>


                    <div class="comment-reply">
                    <a class="comment-btn" data-comment="{{ $review->id }}" href="javascript:void(0)">
                                    <i class="fas fa-reply"></i> Reply
                                    </a>
                            </div>



                </div>
            </div>
            <ul class=" comments-reply">

            @if(!$review->reply->isEmpty())
                     @foreach($review->reply as $key => $reply)
                        <li>
                           <div class="comment">
                              <img class="avatar rounded-circle" alt="User Image" src="{{ App\User::find($reply->user_id)->getAvatarUrl() }}">
                              <div class="comment-body">
                                 <div class="meta-data">
                                    <span class="comment-author">{{ App\User::find($reply->user_id)->name }}</span>
                                    <span class="comment-date">{{ Carbon\Carbon::parse($reply->created_at)->diffForHumans()}}</span>
                                 </div>
                                 <p class="comment-content">
                                 {{ $reply->comment }} </p>
                                 <div class="comment-reply">
                                    <a class="comment-btn" data-comment="{{ $review->id }}" href="javascript:void(0)">
                                    <i class="fas fa-reply"></i> Reply
                                    </a>
                                 </div>
                              </div>
                           </div>
                        </li>
                        @endforeach
                        @endif

                </ul>
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
    <p class="text-muted font-italic p-3 bg-light text-center rounded">Not rated yet</p>
</div>
@endif
<script type="text/javascript">
   $('.comment-btn').click(function(){
      var commentId =  $(this).data('comment');
     // alert(commentId);
    if ($(this).parent().find('.newreply').length) {
  //alert($(this).parent().find('.newreply').length);
}
else{
$(this).parent().append('<div  class="col-md-12 newreply"><div class="form-group "><textarea id="review" placeholder="Your Comment" rows="3" name="review" class="form-control pl-5" required=""></textarea><input type="hidden" class="commentId" name="commentid" value="'+ commentId +'"></div><div><button type="submit"  class="g-recaptcha btn btn-primary btn-block submitreview" data-sitekey="6LcGnBwcAAAAAHY2J4EwqpoYLAODaUnKioLdxmrz" data-callback="onSubmit" data-commentId="'+ commentId +'" data-action="submit">Submit Review</button></div></div>');
}
   })                         
   $(document).on("click",".submitreview",function(e) {
    var comment = $(this).parent().siblings().find('#review').val();
    //alert(comment);
    e.preventDefault();
               $.ajaxSetup({
                  headers: {
                      'X-CSRF-TOKEN': '<?php echo csrf_token() ?>',
                  }
              });
              jQuery.ajax({
                  url: "{{ url('/reviews/update') }}",
                  method: 'post',
                  data: {
                     id: $(this).data('commentid'),
                     comment: comment,
                   
                  },
                  success: function(result){
                 location.reload();
                  }});
});                                            
</script>
