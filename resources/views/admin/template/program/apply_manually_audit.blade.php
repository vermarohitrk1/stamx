<form method="post" action="{{route('auditreport.update')}}" autocomplete="off" enctype="multipart/form-data" class="bv-form">
     @csrf
     <input class="form-control" type="hidden" value="{{ $id }}" name="id">
<!--    <div class="form-group">
        <label class="form-control-label">City</label>
        <input class="form-control" type="text" value="" name="city" id="city" required >
   </div>-->
   <div class="form-group">
                <label class="form-control-label">State</label>
                <select class="form-control states"  name="state" >
                  
                        
                  <option value="Alabama">Alabama</option>
                  <option value="Alaska">Alaska</option>
                  <option value="Arizona">Arizona</option>
                  <option value="Arkansas">Arkansas</option>
                  <option value="California">California</option>
                  <option value="Colorado">Colorado</option>
                  <option value="Connecticut">Connecticut</option>
                  <option value="Delaware">Delaware</option>
                  <option value="District Of Columbia">District Of Columbia</option>
                  <option value="Florida">Florida</option>
                  <option value="Georgia">Georgia</option>
                  <option value="Hawaii">Hawaii</option>
                  <option value="Idaho">Idaho</option>
                  <option value="Illinois">Illinois</option>
                  <option value="Indiana">Indiana</option>
                  <option value="Iowa">Iowa</option>
                  <option value="Kansas">Kansas</option>
                  <option value="Kentucky">Kentucky</option>
                  <option value="Louisiana">Louisiana</option>
                  <option value="Maine">Maine</option>
                  <option value="Maryland">Maryland</option>
                  <option value="Massachusetts">Massachusetts</option>
                  <option value="Michigan">Michigan</option>
                  <option value="Minnesota">Minnesota</option>
                  <option value="Mississippi">Mississippi</option>
                  <option value="Missouri">Missouri</option>
                  <option value="Montana">Montana</option>
                  <option value="Nebraska">Nebraska</option>
                  <option value="Nevada">Nevada</option>
                  <option value="New Hampshire">New Hampshire</option>
                  <option value="New Jersey">New Jersey</option>
                  <option value="New Mexico">New Mexico</option>
                  <option value="New York">New York</option>
                  <option value="North Carolina">North Carolina</option>
                  <option value="North Dakota">North Dakota</option>
                  <option value="Ohio">Ohio</option>
                  <option value="Oklahoma">Oklahoma</option>
                  <option value="Oregon">Oregon</option>
                  <option value="Pennsylvania">Pennsylvania</option>
                  <option value="Rhode Island">Rhode Island</option>
                  <option value="South Carolina">South Carolina</option>
                  <option value="South Dakota">South Dakota</option>
                  <option value="Tennessee">Tennessee</option>
                  <option value="Texas">Texas</option>
                  <option value="Utah">Utah</option>
                  <option value="Vermont">Vermont</option>
                  <option value="Virginia">Virginia</option>
                  <option value="Washington">Washington</option>
                  <option value="West Virginia">West Virginia</option>
                  <option value="Wisconsin">Wisconsin</option>
                  <option value="Wyoming">Wyoming</option>
         </select>
    </div>
    <div class="form-group">
                <label class="form-control-label">Male Participants</label>
                <input required class="form-control" type="number" value="" min="0" step="1" name="male_participant" >
    </div>
    <div class="form-group">
                <label class="form-control-label">Female Participants</label>
                <input required class="form-control" type="number" value="" min="0" step="1" name="female_participant" >
    </div>
    <div class="form-group">
                <label class="form-control-label">Other Participants</label>
                <input required class="form-control" type="number" value="" min="0" step="1" name="other_participant" >
    </div>
    <div class="form-group">
                <label class="form-control-label">Cost Per Participant</label>
                <input required class="form-control" type="number" value="" min="0" name="participant_cost" id="participant_cost" >
    </div>
    <div class="form-group">
                <label class="form-control-label">Date</label>
                <input required class="form-control" type="date" value="" name="date" id="date" >
    </div>
    <div class="form-group">
                <label class="form-control-label">Method</label>
                <select class="form-control "  name="method" id="method"  required="">
                  
                        
                  <option value="">Please select</option>
                  <option value="online">Online</option>
                  <option value="onsite">Onsite</option>
                     </select>
                <!--<input required class="form-control" type="text" value="" name="method" id="method" >-->
    </div>
<!--    <div class="form-group">
                <label class="form-control-label">Framework</label>
                <input required class="form-control" type="text" value="" name="framework" id="framework" >
    </div>-->
    

    <div class="mt-4 ">
        <button class="btn btn-primary" name="form_submit" value="submit" type="submit">Update</button>
        <button type="button" class="btn btn-danger" data-dismiss="modal">Cancel</button>
    </div>
</form>
