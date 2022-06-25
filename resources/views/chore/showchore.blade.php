<?php $page = "hore"; ?>
@section('title')
    {{$page}}
@endsection
@extends('layout.dashboardlayout')
@section('content')	
<style>
 li.row.mycomment {
    background-color: #d1d4d4!important;
}
   .profile-custom-list > li {
       width: 50%!important;
   }
   .single-comment.justify-content-between.d-flex.left {
       float: left;
       width: 100%;
   }
   .single-comment.justify-content-between.d-flex.right {
       float: right;
     
   }
   p.comment {
       margin-left: 20px;
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
                <div class=" col-md-12 ">
                   <a href="{{ route('chore.index') }}" class="btn btn-sm btn-primary float-right btn-icon-only rounded-circle " >
        <span class="btn-inner--icon"><i class="fas fa-reply"></i></span>
    </a>
                     </div>
   
<!-- Breadcrumb -->
<div class="breadcrumb-bar mt-3">
    <div class="container-fluid">
        <div class="row align-items-center">
            <div class="col-md-12 col-12">
                <h2 class="breadcrumb-title">Chore Detail</h2>
                <nav aria-label="breadcrumb" class="page-breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Home</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('chore.index') }}">Chore</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Detail</li>
                    </ol>
                </nav>
            </div>              
        </div>            
    </div>
</div>
<!-- /Breadcrumb -->





<div class="row mt-3" id="blog_view">
     <div class="col-12">
        <div class="card">
            <div class="card-body">
       
<div class="col-xl-12">
   <div class="card">
      <div class="card-body  custom-border-card">
         <!-- Location Details -->
         <div class="widget awards-widget m-0">
            <h4 class="widget-title">Detail</h4>
            <hr>
            <div class="experience-box">
               <ul class="experience-list profile-custom-list">
                  <li>
                     <div class="experience-content">
                        <div class="timeline-content">
                           <span>Name</span>
                           <div class="row-result">{{ $chore->name}}</div>
                        </div>
                     </div>
                  </li>
                  <li>
                     <div class="experience-content">
                        <div class="timeline-content">
                           <span>Category</span> 
                           <div class="row-result">@if($chore->category != null){{ $chore->category->name}} @else not available  @endif</div>
                        </div>
                     </div>
                  </li>
                  <li>
                     <div class="experience-content">
                        <div class="timeline-content">
                           <span>Created by</span>
                           <div class="row-result">{{   \App\User::find($chore->user_id)->name}}</div>
                        </div>
                     </div>
                  </li>
                  <li>
                     <div class="experience-content">
                        <div class="timeline-content">
                           <span>Due date</span>
                           <div class="row-result">{{ $chore->due_date}}</div>
                        </div>
                     </div>
                  </li>
                  <hr>
                     <div class="experience-content">
                        <div class="timeline-content">
                           <span>Description</span>
                           <div class="row-result">@php echo $chore->description @endphp</div>
                          
                        </div>
                     </div>
                     <hr>
                     <div class="experience-content">
                        <div class="timeline-content">
                          <span>Attachment</span>
                          <div class="attachmentDiv"  style="width:100%;height:100%;">
                          @if($chore->image != null)
                          <a href="{{asset('storage')}}/chore/{{ $chore->image }}" download>
                            <img  src="{{asset('storage')}}/chore/{{ $chore->image }}" class="avatar attachment "  style="width:10%;height:10%;">
                         </a>
                        @endif
                        @if($chore->attachment != null)
                         <a href="{{asset('storage')}}/{{ $chore->attachment }}" download>
                           
                            <embed src="{{asset('storage')}}/{{ $chore->attachment }}" width="20px" height="20px" />

                           </a>
                         @endif
                        </div>
                        </div>
                     </div>
                  </li>
               </ul>
            </div>
         </div>
         <!-- /Location Details -->
         
         <div class="table-md-responsive">
         <div class="accordion" id="accordionExample">

<div class="card">
  <div class="card-header" id="headingTwo">
    <h2 class="mb-0">
      <button class="btn btn-link btn-block text-left" type="button" data-toggle="collapse" data-target="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">
        Chore Members
      </button>
    </h2>
  </div>
  <div id="collapseTwo" class="collapse " aria-labelledby="headingTwo" data-parent="#accordionExample">
         <div class="card-body">
             
             @if(empty($members))
                          {{__('Nothing to found')}}
                    @else
            <table class="table table-hover table-center mb-0" id="example">
                      <thead class="thead-light">
                      <tr>
                          <th class=" mb-0 h6 text-sm"> {{__('Name')}}</th>
                          <th class=" mb-0 h6 text-sm"> {{__('Email')}}</th>
                      </tr>
                      </thead> 
                      <tbody>
                          @foreach($members as $row)
                          @php
                          $user=\App\User::find($row->user_id);
                          @endphp
                            @if( $user->name !='' )
                             <tr>
                              <td><h2 class="table-avatar">
                                                <a href="{{route('profile', ['id' => encrypted_key($user->id, 'encrypt')]) }}" class="avatar avatar-sm mr-2"><img class="avatar-img rounded-circle" src="{{$user->getAvatarUrl() }}" alt="Image"></a>
                                                <a href="{{route('profile', ['id' => encrypted_key($user->id, 'encrypt')]) }}">{{ $user->name }}</a>
                                            </h2></td>
                               <td>{{ $user->email }}</td>
                           </tr>
                            @endif
                          @endforeach
                      </tbody>
             </table>
             @endif
         </div>
    </div>
  </div>

 </div>    

 </div>
      </div>
   </div>
   <!-- /Mentor Details Tab -->
   <div class="comments-area">
   <h4 class="widget-title">Comments</h4>
            <hr>
                            <div class="comment-list">
            
<div class="doc-review review-listing">

<ul class="comments-list">
     
  @if( $chore->comments->isEmpty() )
  No comments yet
  @else
 @foreach($chore->comments as $key => $comments)
 
<li class="row @if(auth()->user()->id == $comments->created_by) mycomment  @else right @endif">
<div class="col-md-10">
<div class="comment">
<img class="avatar rounded-circle" alt="User Image" {{ getUserAvatarUrl($comments->created_by)}}>
<div class="comment-body">
<div class="meta-data">
<span class="comment-author">@if(\App\User::find($comments->created_by ))  {{ \App\User::find($comments->created_by )->name  }} @endif</span>
<span class="comment-date">{{ Carbon\Carbon::parse($comments->created_at)->diffForHumans()}}</span>

</div>

 <p class="comment-content updatescomment_{{$comments->id}}">
    {{$comments->comment}}
</p>


</div>
</div>
<div id="upcomment_{{$comments->id}}" class="card-body" style="display:none;">
                
                     
                     <div class="col-md-12">
                        <div class="form-group ">
                          
                           <i data-feather="message-circle" class="fea icon-sm icons"></i>
                           <textarea placeholder="Your Comment" rows="3" name="comment" class="updatecommenttext form-control pl-5" required=""> {{$comments->comment}}</textarea>
                           <input type="hidden" name="id" class="commentupdateId" value="{{$comments->id}}">
                        </div>
                        <div class="send">
                           <button  type="submit" class="updatecommentbtn btn btn-primary btn-block">update comment</button>
                        </div>
                     </div>
                     <!--end col-->
           
               </div>
</div>
<div class="col-md-2">
@if(auth()->user()->id == $comments->created_by)
<a class="btn btn-sm bg-success-light editbtn" data-id="{{$comments->id}}" href="javascript:void(0)">
                                                    <i class="fas fa-pencil-alt"></i>
                                               </a>
  <a data-url="{{ route('chore.comment.destroy', encrypted_key($comments->id, 'encrypt')) }}" href="#" class="btn btn-sm bg-danger-light delete_record_model">
       <i class="far fa-trash-alt"></i> 
  </a>
      @endif
      </div>
</li>

@endforeach
@endif


</ul>
</div>
                        </div>
                        </div>
   <div class="card">
      <div class="card-body  custom-border-card">
         <!-- Location Details -->
         <div class="widget awards-widget m-0">
           
            <div class="experience-box">
               <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12 ">
               </div>
               <div class="card-body">
                
                     
                     <div class="col-md-12">
                        <div class="form-group ">
                          
                           <i data-feather="message-circle" class="fea icon-sm icons"></i>
                           <textarea id="comment" placeholder="Your Comment" rows="3" name="comment" class="form-control pl-5" required=""></textarea>
                           <input type="hidden" name="id" id="commentId" value="{{ $chore->id }}">
                        </div>
                        <div class="send">
                           <button id="addcomment" type="submit" class="btn btn-primary btn-block">Submit comment</button>
                        </div>
                     </div>
                     <!--end col-->
           
               </div>
            </div>
         </div>
      </div>
      <!-- /Location Details -->
   </div>
</div>
<!-- /Mentor Details Tab -->
</div>



            </div>
        </div>
    </div>





            </div>
        </div>

    </div>

</div>		
<!-- /Page Content -->
@endsection

@push('script')

<link rel="stylesheet" type="text/css" href="{{ asset('assets/css/simcify.min.css') }}">
<script src="{{ asset('assets/js/simcify.min.js') }}"></script>

<link rel="stylesheet" type="text/css" href="{{ asset('assets/libs/dropify/css/dropify.min.css') }}">
<script src="{{ asset('assets/libs/dropify/js/dropify.min.js') }}"></script>


<script src="{{ asset('public/ckeditor/ckeditor.js') }}"></script>
<script>
         jQuery(document).ready(function(){
           
            jQuery('#addcomment').click(function(e){
               e.preventDefault();
               $.ajaxSetup({
                  headers: {
                      'X-CSRF-TOKEN': '<?php echo csrf_token() ?>',
                  }
              });
              jQuery.ajax({
                  url: "{{ route('chore.comment.post') }}",
                  method: 'post',
                  data: {
                     id: jQuery('#commentId').val(),
                     comment: jQuery('#comment').val(),
                   
                  },
                  success: function(result){
                   var avatar=  result["avatar"];
                   var id =result["id"];
                   var e_id = '{{URL::to("/") }}/chore/comment/destroy/'+result["e_id"];
                   
                     $('.comments-list').append('<li class=" mycomment row "><div class="col-md-10"><div class="comment"><img class="avatar rounded-circle" alt="User Image" src="'+avatar+'"><div class="comment-body"><div class="meta-data"><span class="comment-author">  '+result["name"]+' </span><span class="comment-date">'+result["time"]+'</span></div><p class="comment-content updatescomment_'+id+'">'+result["comment"]+'</p></div></div><div id="upcomment_'+id+'" class="card-body" style="display:none;"><div class="col-md-12"><div class="form-group "><i data-feather="message-circle" class="fea icon-sm icons"></i><textarea placeholder="Your Comment" rows="3" name="comment" class="updatecommenttext form-control pl-5" required=""> '+result["comment"]+'</textarea><input type="hidden" name="id" class="commentupdateId" value="'+id+'"></div> <div class="send"><button type="submit" class="updatecommentbtn btn btn-primary btn-block">update comment</button></div> </div> </div></div><div class="col-md-2"><a class="btn btn-sm bg-success-light  editbtn" data-id="'+id+'" href="javascript:void(0)"><i class="fas fa-pencil-alt"></i></a><a data-url="'+e_id+'" href="#" class="btn btn-sm bg-danger-light delete_record_model"><i class="far fa-trash-alt"></i></a></div></li>')
                     $("#comment").val('')
                  }});
               });
            });

     
            $(document).on("click",".editbtn",function() {
 
            var id = $(this).data('id');
         //   alert('#upcomment_'+id);
            $('#upcomment_'+id).toggle('show');
            }); 

            $(document).on("click",".updatecommentbtn",function() {
                 var comment = $(this).parent().siblings().children('.updatecommenttext').val();
                 var id = $(this).parent().siblings().children('.commentupdateId').val();
                 $.ajaxSetup({
                  headers: {
                      'X-CSRF-TOKEN': '<?php echo csrf_token() ?>',
                  }
              });
              jQuery.ajax({
                  url: "{{ url('/chores/comment/update') }}",
                  method: 'post',
                  data: {
                     id: id,
                     comment: comment,
                   
                  },
                  success: function(result){
                    // alert(result['name']);
                    $('.updatescomment_'+id).html(result['comment'])
                    $('#upcomment_'+id).toggle('show');
                  }});
            });
</script>


@endpush