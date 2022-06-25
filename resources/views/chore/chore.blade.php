<?php $page = "Chore"; ?>
@section('title')
    {{$page}}
@endsection
@extends('layout.dashboardlayout')
@section('content')	

     @php
        $user=Auth::user();
        $permissions=permissions();
        @endphp
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
                  
     
       
        <a href="{{ route('chore.mydashboard')}}" class="btn btn-sm btn btn-primary float-right mr-2 m-0">
        <span class="btn-inner--text ">{{__('My Dashboard')}}</span>
    </a>
      
      
      
                   
                     </div>
                
   <!-- Breadcrumb -->
                <div class="breadcrumb-bar mb-3">
                    <div class="container-fluid">
                        <div class="row align-items-center">
                            <div class="col-md-12 col-12">
                                <h2 class="breadcrumb-title">Chore</h2>
                                <nav aria-label="breadcrumb" class="page-breadcrumb">
                                    <ol class="breadcrumb">
                                        <li class="breadcrumb-item"><a href="{{route('dashboard')}}">Dashboard</a></li>
                                        <li class="breadcrumb-item active" aria-current="page">Chore</li>
                                    </ol>
                                </nav>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- /Breadcrumb -->
         
<div class="row mt-3" id="blog_category_view">
  <div class="col-lg-4 order-lg-2">
          <h5 class="mt-3">{{__("Your To-Dos")}}</h5>
                                    <div class="row todo-wrapper shadow p-3 mt-3 bg-white">
                                        <div class="col-12 todo p-0">
                                            <div class="todo-add">
                                                <div class="input-group mb-2">
                                                    <input class="form-control py-2 mr-1 pr-5 todo_content" type="text" placeholder="Add a to-do">
                                                    <span class="input-group-append">
                                                        <button class="btn rounded-pill border-0 ml-n5 addToDo" type="button">
                                                            <i class="fa fa-plus" aria-hidden="true"></i>
                                                        </button>
                                                    </span>
                                                </div>
                                                <hr width="100%">
                                            </div>
                                            <div class="todo-items">
                                                {!! $toDoHtml !!}
                                            </div>
                                        </div>
                                    </div>
      </div>
  <div class="col-lg-4 order-lg-3">
    <div id="page_sidebar_tabs1">
        <div class="card">
        <div class="list-group list-group-flush" id="tabs">
            
<!--            <div data-href="#form_edit1" class="list-group-item text-primary">
                <div class="media">
                    <i class="fas fa-comments pt-1"></i>
                    <div class="media-body ml-3">
                        <a href="#" data-url="{{route('chore.comments',$data->id)}}" data-ajax-popup-right="true" class="stretched-link h6 mb-1">{{__('Chore Comments')}}</a>
                     
                <p class="mb-0 text-sm">{{__('Household members discussion..')}} <div class="actions d-inline-block float-right">
                                                                                                                    <div class="action-item mr-2"><i class="fas fa-paperclip mr-2"></i>{{$files??''}}</div> <div class="action-item mr-2"><i class="fas fa-comment-alt mr-2"></i>{{$comments}}</div></div></p>
              
                    </div>
                </div>
            </div>-->
            @if(!empty($assigned) && $data->status=="Active")
            <div data-href="#form_edit12" class="list-group-item text-primary bg-primary-light active">
                <div class="media">
                    <i class="fas fa-link pt-1"></i>
                    <div class="media-body ml-3">
                        @if(empty($assigned->is_completed))
                        <a href="{{url('chore/status/complete',$assigned->id)}}"  class="stretched-link h6 mb-1">{{__('Mark Complete')}}</a>
                     <p class="mb-0 text-sm">{{__('Task is pending click to mark complete..')}} </p>
              @else
              <a href="{{url('chore/status/pending',$assigned->id)}}"  class="stretched-link h6 mb-1">{{__('Mark Pending')}}</a>
                     <p class="mb-0 text-sm">{{__('Task is completed click to mark pending..')}} </p>
              @endif
                    </div>
                </div>
            </div>
            @endif
            </div>
            </div>
    </div>
      
</div>
    
    
    {{--Main Part--}}
    <div class="col-lg-8 order-lg-1">
        <div id="tabs-1" class="tabs-card">
            <div class="card">
                    <div class="card-header">
               <span class="float-right badge badge-sm {{$data->status=="Active"?'badge-success':'badge-warning'}}">{{ $data->status}}</span>
               <span class="float-left badge badge-sm badge-primary">{{ \App\ChoreCategory::category_name($data->category_id)}}</span>
               <br>    
                    <h3>{{$data->title}} </h3>
                <!--<p class=" mb-1"><b>Price:</b> {{ format_price($data->price, 2) }}</p>-->
               
                <div data-href="#form_edit" class="list-group-item text-primary">
                <div class="media">
                    <!--<i class="fas fa-clock pt-1"></i>-->
                    <div class="media-body ml-3">
                        <p class="stretched-link h6 mb-1">{{__('Schedule/Members')}}</p>
                        @if(!empty($data->day))
                <p class=" mb-0 text-sm"><b>Days:</b> {{  implode(', ',json_decode($data->day)) }}</p>
                @endif
                @if(!empty($data->start_date))
                <p class="mb-0 text-sm"><b>{{ $data->typeOnChoice }}:</b> Due Date {{ \App\Utility::getDateFormated($data->start_date) }} {{ !empty($data->end_date) ? " To ".\App\Utility::getDateFormated($data->end_date) :'' }}</p>
                <p class="mb-0 text-sm"><b>Time:</b> {{ $data->start_time." - ".$data->end_time }}</p>
                
                @endif
                    </div>
                </div>
            </div>
                <div class="list-group-item text-primary">
                <div class="media">
                    <!--<i class="fas fa-clock pt-1"></i>-->
                    <div class="media-body ml-3">
                        <!--<p class="stretched-link h6 mb-1">{{__('Members')}}</p>-->
                        <div class="empty-section">
                    <div class="row justify-content-center align-items-center ">
                    @if(!empty($members)  && count($members)>0)
                        @foreach ($members as $user)
                    @if(Auth::user()->id != $user->id)
                                <a data-toggle="modal" data-target="#myChat" href="javascript:void(0);" class="SingleuserChatButton userDataMessage "
               data-id="{{$user->id}}">
                    @else
                        <a href="#">
                            @endif
                    <div class="col-md-12 text-center centered align-items-center">
                                <img src="{{Auth::user()->getAvatarUrl($user->id)}}"  class="img-circle mt-0 img-responsive avatar avatar-sm rounded-circle ">
                                 <div class="inbox-preview-name">
                                     <h6 class="name mb-2 mt-1 h6 text-sm"> {{!empty($user->name) ? $user->name."" :""}} 
                                        
                                    </h6>
                                </div>
                            </div>
                                </a>
                   @endforeach
                    @endif
                                </div>
                </p>
                    </div>
                    </div>
                </div>
            </div>
               
               
                
                </div>
                <div class="card-body">                   

                    
               <p class="text-muted ">{{ ucfirst($data->description) }}</p>
                  
                </div>
                <div class="card-body">                   

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
   
                  <!-- /Mentor Details Tab -->
   <div class="comments-area">
   <h4 class="widget-title">Comments</h4>
            <hr>
                            <div class="comment-list">
            
<div class="doc-review review-listing">

<ul class="comments-list">
     
  @if( $data->comments->isEmpty() )
 
  @else
 @foreach($data->comments as $key => $comments)
 
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
                           <input type="hidden" name="id" id="commentId" value="{{ $data->id }}">
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
            </div>

        </div>
    </div>
    <!-- list view -->
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
            
            
            
            
            $(document).ready(function () {
            $(document).on("click", '.addToDo', function () {
                let todoContent = $(".todo_content").val();
                if(todoContent!=""){
                    $.ajax({
                        url: "{{ route('chore.todo.type') }}",
                        type: "POST",
                        data: {
                            "_token": "{{ csrf_token() }}",
                            "type": "save",
                            "to_do_data": {
                                'name': todoContent,
                            },
                        },
                        showLoader: true,
                        success: function (response) {
                            if(response.success==true){
                                $(".todo_content").val("");
                                show_toastr("Success", response.message, "success");
                                if(response.to_do_html!=""){
                                    $(".todo-items").html(response.to_do_html);
                                }
                            }
                            else{
                                show_toastr("Error", response.message, "error");
                            }
                        }
                    });
                }
            });
            $(document).on("click", '.todo_delete', function () {
                var toDoId = $(this).data("id");
                if(toDoId!=""){
                    $.ajax({
                        url: "{{ route('chore.todo.type') }}",
                        type: "POST",
                        data: {
                            "_token": "{{ csrf_token() }}",
                            "type": "delete",
                            "id": toDoId,
                        },
                        showLoader: true,
                        success: function (response) {
                            if(response.success==true){
                                $(".todo_content").val("");
                                show_toastr("Success", response.message, "success");
                                if(response.to_do_html!=""){
                                    $(".todo-items").html(response.to_do_html);
                                }
                            }
                            else{
                                show_toastr("Error", response.message, "error");
                            }
                        }
                    });
                }
            });
            $(document).on("click", '.clear_todo', function () {
                $.ajax({
                    url: "{{ route('chore.todo.type') }}",
                    type: "POST",
                    data: {
                        "_token": "{{ csrf_token() }}",
                        "type": "clear",
                    },
                    showLoader: true,
                    success: function (response) {
                        if(response.success==true){
                            $(".todo_content").val("");
                            show_toastr("Success", response.message, "success");
                            if(response.to_do_html!=""){
                                $(".todo-items").html(response.to_do_html);
                            }
                        }
                        else{
                            show_toastr("Error", response.message, "error");
                        }
                    }
                });
            });
            $(document).on("click", '.show_completed', function () {
                $(".complete_todo_wraper").toggle();
            });

            $(document).on("change", '.pending_todo_wraper input:checkbox', function () {
                if(this.checked){
                    $.ajax({
                        url: "{{ route('chore.todo.type') }}",
                        type: "POST",
                        data: {
                            "_token": "{{ csrf_token() }}",
                            "type": "completed",
                            "id": this.value
                        },
                        showLoader: true,
                        success: function (response) {
                            if(response.success==true){
                                show_toastr("Success", response.message, "success");
                                if(response.to_do_html!=""){
                                    $(".todo-items").html(response.to_do_html);
                                }
                            }
                            else{
                                show_toastr("Error", response.message, "error");
                            }
                        }
                    });
                }
            });
            $(document).on("change", '.complete_todo_wraper input:checkbox', function () {
                if(!this.checked){
                    $.ajax({
                        url: "{{ route('chore.todo.type') }}",
                        type: "POST",
                        data: {
                            "_token": "{{ csrf_token() }}",
                            "type": "pending",
                            "id": this.value
                        },
                        showLoader: true,
                        success: function (response) {
                            if(response.success==true){
                                show_toastr("Success", response.message, "success");
                                if(response.to_do_html!=""){
                                    $(".todo-items").html(response.to_do_html);
                                }
                            }
                            else{
                                show_toastr("Error", response.message, "error");
                            }
                        }
                    });
                }
            });
            });
</script>


@endpush


