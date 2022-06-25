<form method="post" action="{{route('approval_listing.store')}}" autocomplete="off" enctype="multipart/form-data" class="bv-form">
     @csrf
     <input class="form-control" type="hidden" value="{{!empty($data->user_id) ? encrypted_key($data->user_id, "encrypt"):''}}" name="id">

   <div class="form-group">
                <label class="form-control-label">Status</label>
                <select id="status" class="form-control" name="status">
                    <option disabled value="0" @if($data->status == 0 ) selected @endif> Pending</option>
                    <option value="1" @if($data->status == 1 ) selected @endif> Accetped</option>
                    <option value="2" @if($data->status == 2 ) selected @endif> Rejected</option>
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
