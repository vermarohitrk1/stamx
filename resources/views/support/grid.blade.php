<div class="col-md-12">
        <div class="card">

            <!--<input class="form-control search-tickets" name="search" placeholder="Search Tickets">-->
            <div class="divider"></div>
            
            <div class="card-body inbox pagify-parent">
                @if(!empty($data) && count($data) > 0)
                @foreach($data as $row)
                <!--message preview card start-->
                <a href="{{route('support.preview',encrypted_key($row->id,'encrypt'))}}" >
                      <div class="inbox-preview mb-0">
                        <div class="row" >
                            <div class="col-md-2 text-center">
                                <img  {{ Auth::user()->getUserAvatar($row->user_id) }} class="img-circle mt-0 img-responsive avatar avatar-sm rounded-circle ">
                                 <div class="inbox-preview-name">
                                     <h6 class="name mb-2 mt-1 h6 text-sm"> {{ $row->user->name??'' }}                                         
                                    </h6>
                                     
                                </div>
                            </div>
                            <div class="col-md-6 "> 
                                <div class="inbox-preview-message mt-1">
                                    <span class="name mb-0 h6 ">{{ $row->subject }} </span> 
                                    <span class="text-xs text-right text-muted p-1">
                                        @if($row->status == "Support Reply")
                                        <span class="badge badge-pill badge-primary">Support Reply</span>
                                        @elseif($row->status == "New" || $row->status == "Customer Reply")
                                        <span class="badge badge-pill badge-danger">{{ $row->status }}</span>
                                        @else
                                        <span class="badge badge-pill badge-success">Closed</span>
                                        @endif
                                     </span>
                                    <br>
                                    
                                </div>
                                <small class="text-muted pt-1">{{ substr($row->lastmessage ,0,50) }}...</small>
                                   <br>
                                   <span class="text-xs text-primary text-bold">[{{ $row->category->name }}] 
                                       </span> 
                            </div>
                            <div class="col-md-4">
                                <div class="inbox-preview-time pull-right">                                   
                                    <p class="pull-right text-right">
                                        <span class="badge badge-xs badge-pill badge-{{($row->submitted_to_id==Auth::user()->id)?'warning':'info'}}">{{($row->submitted_to_id==Auth::user()->id)?'Received':'Sent'}}</span> {{ time_elapsed($row->created_at) }}
                                    </p>
                                </div>
                            </div>
                        </div>
                        </div>
                </a>
                <hr>
                <!--message preview card end-->
                @endforeach
               
                @else
                <!--message preview card start-->
                <div class="">
                    <div class="row">
                        <div class="col-md-12 text-center">
                            <p>No tickets here!</p>
                        </div>
                    </div>
                </div>
                <!--message preview card end-->
                @endif
            </div>
        </div>
      <div class=" col-md-12 d-flex justify-content-center paginationCss">
    {{ $data->appends(request()->except('page'))->links() }}
    
    </div>
    </div>