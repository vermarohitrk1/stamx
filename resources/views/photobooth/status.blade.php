<form method="post" action="{{route('photobooth.store')}}" autocomplete="off" enctype="multipart/form-data" class="bv-form">
     @csrf
     <input class="form-control" type="hidden" value="{{!empty($data->id) ? encrypted_key($data->id, "encrypt"):''}}" name="id">

   <div class="form-group">
                <label class="form-control-label">Status</label>
                <select id="status" class="form-control" name="status">
                    <option value="Active" @if($data->status == 'Active' ) selected @endif> Active</option>
                    <option value="Inactive" @if($data->status == 'Inactive' ) selected @endif> Inactive</option>
             </select>
            </div>
     </div>
</div>
</div>
    

    <div class="mt-4 ">
        <button class="btn btn-primary" name="form_submit" value="submit" type="submit">Save Changes</button>
        <button type="button" class="btn btn-danger" data-dismiss="modal">Cancel</button>
    </div>
</form>
<script>

    $("#permissions").select2();
    </script>
