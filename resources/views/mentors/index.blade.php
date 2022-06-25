@extends('layouts.admin') 
@section('title')
    {{__('Mentors')}}
@endsection

@push('css')
<link rel="stylesheet" href="{{asset('assets/css/croppie.css')}}"/>
<link href="{{ asset('assets/libs/datatable.css') }}" rel="stylesheet" />
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
  
<div class="row" id="blog_view">

    <div class="col-12">
        <div class="card">
            <div class="card-body">
                <div class="table-responsive">
                        <table class="table mb-0" id="data-table">
                            <thead class="thead-light">
                                <tr>
                                    <th class=" mb-0 h6 text-sm"> {{__('Name')}}</th>
                                    <th class=" mb-0 h6 text-sm"> {{__('Email')}}</th>
                                    <th class=" mb-0 h6 text-sm"> {{__('Skills')}}</th>
                                    <th class=" mb-0 h6 text-sm"> {{__('Action')}}</th>
                                </tr>
                            </thead>
                           
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
            Do you want to invite this user?
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

    $(document).on("click", ".destroyCertify", function(){
        var id = $(this).attr('data-id');
        $("#mentor_Id").val(id);
        $('#destroyCertify').modal('show');    
    });

 
    $(function () {
        
    
    var table = $('#data-table').DataTable({
         responsive: true,
        processing: true,
        serverSide: true,
        ajax:"{{route('mentors')}}",
        columns: [
            {data: 'name', name: 'name'},
            {data: 'email', name: 'email'},
            {data: 'mentor_skills', name: 'mentor_skills'},
            {data: 'action', name: 'action', orderable: false, searchable: false},
        ]
    });
    
  });
</script>


@endpush






