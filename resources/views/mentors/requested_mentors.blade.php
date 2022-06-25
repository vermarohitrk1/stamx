@extends('layouts.admin') 
@section('title')
    {{__('Requested Mentors')}}
@endsection

@push('css')
<link rel="stylesheet" href="{{asset('assets/css/croppie.css')}}"/>
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
    
</style>
@endpush

@push('theme-script')
<script src="{{ asset('assets/libs/apexcharts/dist/apexcharts.min.js') }}"></script>
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
                                    <th class=" mb-0 h6 text-sm"> {{__('Action')}}</th>
                                </tr>
                            </thead>
                            <tbody class="list">
                                @if(!empty($users))
                                @foreach($users as $user)
                                <tr>
                                    <td><div class="mentor_name" data-id="{{$user->user_id}}">
                                        <a href="javascript:void(0);"  class="text-black"  style="color: black;">
                                         {{ $user->name }}
                                        </a>
                                        </div>
                                    </td>
                                    <td>{{ $user->email }}</td>
                                    <td>{{ $user->mentor_skills }}</td>
                                    <td>
                                        <a data-id="{{ $user->user_id }}" class="text-success accpet_mentor" data-toggle="tooltip" title="Accept" href="javascript:void(0);">
                                            <i class="fas fa-check"></i>
                                        </a>&nbsp;&nbsp;&nbsp;
                                        <a data-id="{{ $user->user_id }}" class="text-danger reject_mentor" data-toggle="tooltip" title="Reject" href="javascript:void(0);">
                                            <i class="fas fa-times"></i>
                                        </a> 
                                    </td>
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

<div id="accpet_mentor" class="modal fade" role="dialog">
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
            {{ Form::open(['url' => 'mentor/acceptInvitation','enctype' => 'multipart/form-data']) }}
            <input type="hidden" name="id" id="mentor_Id"  value=""> 
            <input type="hidden" name="status" id="status"  value="">            
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

    $(document).on("click", ".mentor_name", function(){
        var user_id = $(this).attr('data-id');
        $(".mentorBio").html('');
        $.post(
            "{{route('mentor.bio')}}",
            {_token: "{{ csrf_token() }}", user_id: user_id},
            function (response) {
                var data = JSON.parse(response);
                if (data.result == true) {
                    var html = data.html;
                } else {
                    var html = "<h5>No record found.</h5>";
                }
                $(".mentorBio").html(html);
                $('#mentorBio').modal('show'); 
        });       
    })

    $(document).on("click", ".accpet_mentor", function(){
        var id = $(this).attr('data-id');
        $("#mentor_Id").val(id);
        $("#status").val('1');
        $('#accpet_mentor').modal('show');    
    });

    $(document).on("click", ".reject_mentor", function(){
        var id = $(this).attr('data-id');
        $("#mentor_Id").val(id);
        $("#status").val('2');
        $('#accpet_mentor').modal('show');    
    });

    $(document).ready(function() {
        $('#myTable').DataTable();
    } );
</script>


@endpush






