<form method="post" action="{{route('chore.updateinvitation')}}" autocomplete="off" enctype="multipart/form-data" class="bv-form">
     @csrf
     <input class="form-control" type="hidden" value="{{!empty($chore->id) ? encrypted_key($chore->id, "encrypt"):''}}" name="id">
   
   <div class="form-group" >
                <label class="form-control-label">Assigned To</label>
                <select id="mentor" class="select2 form-control" style="width: 100%" name="mentor_id[]" multiple>
                   
                    @foreach($mentor as $key => $user)
                    <option @if(in_array($user->id,$users)) selected @endif value="{{  $user->id }}">{{  $user->name }} - {{  $user->email }}</option>
                    @endforeach

                </select>
            </div>
     
    

    <div class="mt-4 ">
        <button class="btn btn-primary" name="form_submit" value="submit" type="submit">Add</button>
        <button type="button" class="btn btn-danger" data-dismiss="modal">Cancel</button>
    </div>
</form>

<script>
    $("#mentor").select2();
    </script>
