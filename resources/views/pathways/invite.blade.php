<form method="post" action="{{route('pathway.updateinvitation')}}" autocomplete="off" enctype="multipart/form-data" class="bv-form">
     @csrf
     <input class="form-control" type="hidden" value="{{!empty($pathway->id) ? encrypted_key($pathway->id, "encrypt"):''}}" name="id">
   
   <div class="form-group" >
                <label class="form-control-label">Mentor</label>
                <select id="mentor" class="form-control mentors" name="mentor_id[]" multiple style="width: 100% !important">
                   
                    @foreach($mentor as $key => $user)
                    <option value="{{  $user->id }}">
                       {{  $user->name }} ({{  $user->type }} ) - {{  !empty($user->city)?$user->city.',':'' }} {{  !empty($user->state)?$user->state.',':'' }}  {{  !empty($user->postal_code)?$user->postal_code.',':'' }} {{  !empty($user->country)?$user->country.',':'' }}
                                           
                        </option>
                    @endforeach

                </select>
            </div>
     
    

    <div class="mt-4 ">
        <button class="btn btn-primary" name="form_submit" value="submit" type="submit">Add</button>
        <button type="button" class="btn btn-danger" data-dismiss="modal">Cancel</button>
    </div>
</form>

<script>

    $('.mentors').select2();

</script>
