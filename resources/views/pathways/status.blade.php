<form method="post" action="{{route('pathway.updatestatus')}}" autocomplete="off" enctype="multipart/form-data" class="bv-form">
     @csrf
     <input class="form-control" type="hidden" value="{{ $id }}" name="id">
   
   <div class="form-group" >
                <label class="form-control-label">Status</label>
                <select id="mentor" class="form-control mentors" name="status">
                   
                   <option value="0" disabled>Pending</option>
                   <option value="1">Accepted</option>
                   <option value="2">Rejected</option>
                   

                </select>
            </div>
     
    

    <div class="mt-4 ">
        <button class="btn btn-primary" name="form_submit" value="submit" type="submit">Save Changes</button>
        <button type="button" class="btn btn-danger" data-dismiss="modal">Cancel</button>
    </div>
</form>

<script>

   // $('.mentors').select2();

</script>
