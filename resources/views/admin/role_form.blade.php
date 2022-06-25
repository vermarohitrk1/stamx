<form method="post" action="{{route('role.post')}}" autocomplete="off" enctype="multipart/form-data" class="bv-form">
     @csrf
     <input class="form-control" type="hidden" value="{{!empty($data->id) ? encrypted_key($data->id, 'encrypt'):''}}" name="id">
    <div class="form-group">
        <label>Role Name</label>
        <input class="form-control" type="text" value="{{!empty($data->role) ? $data->role:''}}" name="role" id="role" >
   </div>
    <div class="form-group">
        <label>Status</label>
        <select name="status" class="form-control">
            <option @if(!empty($data->status) && $data->status=="Active") selected @endif value="Active">Active</option>
            <option @if(!empty($data->status) && $data->status=="InActive") selected @endif value="InActive">InActive</option>
        </select>
   </div>
   
    @if ($data->role != "corporate" || $data->role != "mentor") 
    <div class="form-group">
        <label>Permissions</label>       
        <select name="permissions[]" id="permissions" class="select2 form-control" style="width: 100%" multiple="">
            @php
            $role_permissions=!empty($data->permissions) ? json_decode($data->permissions) : array();
            @endphp
            @foreach(system_permissions() as $permission)
            <option @if(!empty($role_permissions) && in_array($permission,$role_permissions)) selected @endif value="{{$permission}}">{{ucwords(str_replace("_"," ",$permission))}}</option>
            @endforeach
        </select>
   </div>
	@endif
    <div class="mt-4 ">
        <button class="btn btn-primary" name="form_submit" value="submit" type="submit">Save Changes</button>
        <button type="button" class="btn btn-danger" data-dismiss="modal">Cancel</button>
    </div>
</form>
<script>
    $("#permissions").select2();
    </script>