{{ Form::open(['route' => 'url.identifiers.store','id' => 'url_identifiers_store','enctype' => 'multipart/form-data']) }}
<div class="form-group">
    <div class="row">
        <div class="col-md-12">
            <label>Choose Table Name</label>
            <select class="form-control" name="table_name" id="tableName" required="">
                <option value="">Select Table Name</option>
                @foreach($tableList as $tableName)
                <option value="{{$tableName->TABLE_NAME}}" >{{$tableName->TABLE_NAME}}</option>
                @endforeach
            </select>
        </div>
    </div>
</div>
<div id="forError" class="" style="display: none;"></div>
<div class="form-group">
    <div class="row">
        <div class="col-md-12">
            <label>Status</label>
            <select class="form-control" name="status" id="status" required="">
                <option value="Published">Published</option>
                <option value="Unpublished">Unpublished</option>
            </select>
        </div>
    </div>
</div>
<div class="form-group">
    <div class="row">
        <div class="col-md-12">
            <label class="form-control-label">Table Unique Identity</label>
            <input type="text" name="uniqueId" id="uniqueId" class="form-control" placeholder="Table Unique Identity" disabled="" required="">
            <input type="hidden" name="table_unique_identity" id="TableUniqueIdentity" value="">
        </div>
    </div>
</div>
<div class="text-right">
    {{ Form::button(__('Save'), ['type' => 'submit','class' => 'btn btn-sm btn-primary rounded-pill saveSkuCheck']) }}
    <button type="button" class="btn btn-sm btn-secondary rounded-pill" data-dismiss="modal">{{__('Cancel')}}</button>
</div>
{{ Form::close() }}

<style>
    .modal-content {
    margin: 75px;
    width: 76%;
    }
  
</style>

<script>
    $("#url_identifiers_store").submit(function (event) {
        var TableUniqueIdentity = $('#TableUniqueIdentity').val();
        if (TableUniqueIdentity == '') {
            event.preventDefault();
        }

    });

    $("#tableName").change(function () {
        var selected = $("#tableName").val();
        $.ajax({
            url: "{{route('url.identifiers.checkTableName')}}?tablename="+selected,
            success: function (getData)
            {
                if (getData.status == true) {
                    $("#forError").attr('class', 'text-success');
                    $("#forError").html(getData.message);
                    $("#uniqueId").val(getData.data);
                    $("#TableUniqueIdentity").val(getData.data);
                    $("#forError").show();
                } else {
                    $("#forError").attr('class', 'text-danger');
                    $("#forError").html(getData.message);
                    $("#forError").show();
                }
            }
        });
    });
</script>






