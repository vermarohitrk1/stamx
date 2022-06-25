<?php $page = "book"; ?>
@extends('layout.dashboardlayout')
@section('content')	
<style>

   .bg-success, .badge-success {
   background-color: #d62757 !important;
   }
   .comment-body {
   width: 100%;
   }
</style>
<!-- Page Content -->
<div class="content">
   <div class="container-fluid">
      <div class="row">
         <div class="col-md-5 col-lg-4 col-xl-3 theiaStickySidebar">
            <!-- Sidebar -->
            @include('layout.partials.userSideMenu')
            <!-- /Sidebar -->
         </div>
            

         <div class="col-md-7 col-lg-8 col-xl-9">
            <!-- Breadcrumb -->
<div class="breadcrumb-bar mt-3">
    <div class="container-fluid">
        <div class="row align-items-center">
            <div class="col-md-12 col-12">
                <h2 class="breadcrumb-title">Booking Reviews</h2>
                <nav aria-label="breadcrumb" class="page-breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="index">Home</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Reviews</li>
                    </ol>
                </nav>
            </div>              
        </div>            
    </div>
</div>
<!-- /Breadcrumb -->
            <div class="doc-review review-listing">
               <ul class="comments-list">
                  @if(empty($data))
                  <span>No comment  yet</span>
                  @endif
                  @foreach($data as $key => $comment)
                  <li>
                     <div class="comment">
                        <img class="avatar rounded-circle" alt="User Image" src="{{ App\User::find($comment->user_id)->getAvatarUrl() }}">
                        <div class="comment-body">
                           <div class="meta-data">
                              <span class="comment-author">{{ App\User::find($comment->user_id)->name }}</span>
                              <span class="comment-date">{{ Carbon\Carbon::parse($comment->created_at)->diffForHumans()}}</span>
                              <div class="review-count rating">
                                 @php for($i = 1; $i <= 5 ; $i++){  @endphp
                                 @if($i <= $comment->rating )
                                 <i class="fas fa-star filled"></i>
                                 @else 
                                 <i class="fas fa-star"></i>
                                 @endif
                                 @php } @endphp
                              </div>
                           </div>
                           <!-- <p class="recommended"><i class="far fa-thumbs-up"></i> I recommend the consectetur</p> -->
                           <p class="comment-content">
                              {{ $comment->comment }}
                           </p>
                           <div class="comment-reply">
                              <a class="comment-btn" data-comment="{{ $comment->id }}" href="javascript:void(0)">
                              <i class="fas fa-reply"></i> Reply
                              </a>
                              <a class="delete-btn deletereview" data-comment="{{ $comment->id }}" href="javascript:void(0)">
                                    <i class="fa fa-trash" aria-hidden="true"></i> 
                                    </a>
                           </div>
                        </div>
                     </div>
                     <ul class="comments-reply">
                        @if(!$comment->reply->isEmpty())
                        @foreach($comment->reply as $key => $reply)
                        <li>
                           <div class="comment">
                              <img class="avatar rounded-circle" alt="User Image" src="{{ App\User::find($reply->user_id)->getAvatarUrl() }}">
                              <div class="comment-body">
                                 <div class="meta-data">
                                    <span class="comment-author">{{ App\User::find($reply->user_id)->name }}</span>
                                    <span class="comment-date">{{ Carbon\Carbon::parse($reply->created_at)->diffForHumans()}}</span>
                                 </div>
                                 <p class="comment-content">
                                    {{ $reply->comment }} 
                                 </p>
                                 <div class="comment-reply">
                                    <a class="comment-btn" data-comment="{{ $comment->id }}" href="javascript:void(0)">
                                    <i class="fas fa-reply"></i> Reply
                                    </a>
                                    <a class="delete-btn deletereview" data-comment="{{ $comment->id }}"  data-reply="{{ $reply->id }}" href="javascript:void(0)">
                                    <i class="fa fa-trash" aria-hidden="true"></i> 
                                    </a>
                                 </div>
                              </div>
                           </div>
                        </li>
                        @endforeach
                        @endif
                     </ul>
                  </li>
                  @endforeach
               </ul>
            </div>
         </div>
      </div>
   </div>
</div>
<!-- /Page Content -->
@endsection
@push('script')
<!--<script type="text/javascript" src="{{ asset('datatables/datatables.min.js') }}"></script>-->
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
                  url: "{{ url('/reviews/post') }}",
                  method: 'post',
                  data: {
                     id: $(this).data('commentid'),
                     comment: comment,
                   
                  },
                  success: function(result){
                 location.reload();
                  }});
   });  
   $(document).on("click",".deletereview",function(e) {
    var commentId = $(this).data('comment');
    var replyId = $(this).data('reply');
    
   
    e.preventDefault();
               $.ajaxSetup({
                  headers: {
                      'X-CSRF-TOKEN': '<?php echo csrf_token() ?>',
                  }
              });
              jQuery.ajax({
                  url: "{{ url('/reviews/destroy') }}",
                  method: 'post',
                  data: {
                     commentId: commentId,
                     replyId: replyId,
                   
                  },
                  success: function(result){
                 location.reload();
                  }});
   });                                          
</script>
@endpush