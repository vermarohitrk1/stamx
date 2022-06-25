@extends('layouts.admin') 
@section('title')
    {{__('My Mentors')}}
@endsection

@push('css')

<style>
    .avatar2{
        height: 4.2rem !important;
        width: 5.2rem !important;
        background: rgba(114, 105, 239, .25) !important;
        color: #7269ef !important;
        position: relative;
        color: #fff;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        vertical-align: middle;
        font-size: 1rem;
        font-weight: 600;
    }
    .avatar2.rounded-circle img {
        border-radius: 50%;
    }
    .avatar2 img{
        width: 100%;
    }
    .online-badge {       
        display: inline-block;
        height: 6px;
        width: 6px;
        background-color: #36b37e;
        border-radius: 50%;
    }
    #myTable_filter{
        display: inline-flex;
    }
    
    </style>
@endpush

@section('content')
    
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table mb-0" id="myTable">
                            
                            <thead class="thead-light">
                                <tr>
                                    <th class=" mb-0 h6 text-sm"> {{__('Name')}}</th>
                                    <th class=" mb-0 h6 text-sm"> {{__('Email')}}</th>
                                    <th class=" mb-0 h6 text-sm"> {{__('Skills')}}</th>
                                </tr>
                            </thead>
                            <tbody class="list">
                                @if(!empty($users))
                               
                                @foreach($users as $user)
                                <tr>
                                    <td><div class="mentor_name" data-id="{{$user->mentor_id}}">
                                        <a href="javascript:void(0);"  class="text-black"  style="color: black;">
                                            @if($user->is_active == 1)
                                            <span class="online-badge" data-toggle="tooltip" title="Online"></span>
                                            @endif
                                            <span>{{ $user->name }}</span>                                            
                                        </a>
                                        </div>
                                    </td>
                                    <td>{{ $user->email }}</td>
                                    <td>{{ $user->mentor_skills }}</td>
                                </tr>
                                @endforeach    
                                @else
                                <tr>
                                    <th scope="col" colspan="10"><h6 class="text-center">{{__('No record found')}}</h6></th>
                                </tr>
                                @endif
    
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
</div>

<div id="mentorBio" class="modal fade" role="dialog">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-body mentorBio"> 
             
        </div>
      </div>
    </div>
</div>

<div id="destroyCertify" class="modal fade" role="dialog">
    <div class="modal-dialog">
      <div class="modal-content">
         <div class="modal-header">
                  <h5 class="modal-title">Are You Sure?</h5>
                  <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                      <span aria-hidden="true">×</span>
                  </button> 
          </div> 
        <div class="modal-body">  
            This action can not be undone. Do you want to continue?
        </div>  
        <div class="modal-footer">
            {{ Form::open(['url' => 'mentor/sendInvitation','enctype' => 'multipart/form-data']) }}
            <input type="hidden" name="id" id="mentor_Id"  value="">             
            <button type="submit" class="btn btn-sm btn-danger rounded-pill" id="">Yes</button>
            {{ Form::close() }}
            <button type="button" class="btn btn-sm btn-secondary rounded-pill" id="" data-dismiss="modal" aria-label="Close">Cancel</button>
        </div>
      </div>
    </div>
  </div>




@endsection

@push('script')


<script type="text/javascript">
      
    /** mentor chat **/   
    $(document).ready(function() { 
        $('#myTable').DataTable( {
            "order": [[ 1, "asc" ]],
            'fnDrawCallback': function (oSettings) {
                $('.dataTables_filter').each(function () {
                    $(this).append('<a href="#" data-toggle="modal" class="myMentorChat nav-link nav-link-icon mr-xs pull-right" ><i class="far fa-comment-alt" data-placement="right" title="Mentors Chat" data-toggle="tooltip" ></i></a>');
                });
            }   
        });      
    });   
    /** mentor chat **/

</script>


@endpush

