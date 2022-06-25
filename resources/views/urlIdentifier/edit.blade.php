<?php $page = "url Identifier"; ?>
@extends('layout.dashboardlayout')
@section('content')	


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
          
                    
                     <a href="{{ route('url.identifiers.index') }}" class="btn btn-sm btn-primary float-right btn-icon-only rounded-circle " >
        <span class="btn-inner--icon"><i class="fas fa-reply"></i></span>
    </a>
                     </div>
   
<!-- Breadcrumb -->
<div class="breadcrumb-bar mt-3">
    <div class="container-fluid">
        <div class="row align-items-center">
            <div class="col-md-12 col-12">
                <h2 class="breadcrumb-title">Url Identifiers Edit</h2>
                <nav aria-label="breadcrumb" class="page-breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{url('home')}}">Home</a></li>
                        <li class="breadcrumb-item"><a href="{{route('url.identifiers.index')}}">Url Identifiers</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Edit</li>
                    </ol>
                </nav>
            </div>              
        </div>            
    </div>
</div>
<!-- /Breadcrumb -->

<div class="row mt-3" id="blog_category_view">
  
  <!-- list view -->
  <div class="col-12">
      <div class="card">
                <div class="card-body">
                 {{ Form::open(['route' => 'url.identifiers.update','id' => 'url_identifiers_update','enctype' => 'multipart/form-data']) }}
                    <input type="hidden" name="urlidentifierId" id="urlidentifierId" value="{{$UrlIdentifier->id}}">
                    <!-- <div class="form-group">
                        <div class="row">
                            <div class="col-md-12">
                                <label>Choose Table Name</label>
                                <select class="form-control" name="table_name" id="tableName" required="">
                                    <option value="">Select Table Name</option>
                                    @foreach($tableList as $tableName)
                                    <option value="{{$tableName->TABLE_NAME}}" @if($UrlIdentifier->table_name == $tableName->TABLE_NAME) selected @endif>{{$tableName->TABLE_NAME}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>
                    <div id="forError" class="" style="display: none;"></div> -->
                    <div class="form-group">
                        <div class="row">
                            <div class="col-md-12">
                                <label>Status</label>
                                <select class="form-control" name="status" id="status" required="">
                                    <option value="Published" @if($UrlIdentifier->status == 'Published') selected @endif>Published</option>
                                    <option value="Unpublished" @if($UrlIdentifier->status == 'Unpublished') selected @endif>Unpublished</option>
                                </select>
                            </div>
                        </div>
                    </div>
                    <!-- <div class="form-group">
                        <div class="row">
                            <div class="col-md-12">
                                <label class="form-control-label">Table Unique Identity</label>
                                <input type="text" name="uniqueId" id="uniqueId" class="form-control" placeholder="Table Unique Identity" disabled="" required=""  value="{{$UrlIdentifier->table_unique_identity}}">
                                <input type="hidden" name="table_unique_identity" id="TableUniqueIdentity" value="{{$UrlIdentifier->table_unique_identity}}">
                            </div>
                        </div>
                    </div> -->
                    <div class="text-right">
                        {{ Form::button(__('Update'), ['type' => 'submit','class' => 'btn btn-sm btn-primary rounded-pill saveSkuCheck']) }}
                    </div>
                    {{ Form::close() }}
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

<script>
$("#url_identifiers_store").submit(function (event) {
    var TableUniqueIdentity = $('#TableUniqueIdentity').val();
    if (TableUniqueIdentity == '') {
        event.preventDefault();
    }
});
$("#tableName").change(function () {
    var selected = $("#tableName").val();
    var selectedid = $("#urlidentifierId").val();
    $.ajax({
        url: "{{route('url.identifiers.checkTableName')}}?tablename=" + selected ,
        success: function (getData)
        {
            if (getData.status == true) {
                $("#forError").attr('class', 'text-success');
                $("#forError").html(getData.message);
                $("#uniqueId").val(getData.data);
                $("#TableUniqueIdentity").val(getData.data);
                $("#forError").show();
            } else {
                if(getData.data.id == selectedid){
                    $("#uniqueId").val(getData.data.table_unique_identity);
                    $("#TableUniqueIdentity").val(getData.data.table_unique_identity);
                    $("#forError").hide();
                }else{
                    $("#forError").attr('class', 'text-danger');
                    $("#forError").html(getData.message);
                    $("#forError").show();
                }
                
            }
        }
    });
});
</script>
@endsection
