<form method="post" action="{{route('employer.store')}}" autocomplete="off" enctype="multipart/form-data" class="bv-form">
     @csrf
     <input class="form-control" type="hidden" value="{{!empty($employer->id) ? encrypted_key($employer->id, "encrypt"):''}}" name="id">
     <div class="form-group">
        <label>Company</label>
        <input class="form-control" type="text" value="{{ $employer->company }}" name="company" id="employer" >
   </div>
   <div class="form-group">
                <label class="form-control-label">Address</label>
               <textarea name="address" class="form-control" id="address" rows="3">{{ $employer->address }}</textarea>
    </div>
    <div class="form-group">
                <label class="form-control-label">City</label>
                <input class="form-control" type="text" value="{{ $employer->city }}" name="city" id="city" >
    </div>
    <div class="form-group">
                <label class="form-control-label">State</label>
                <select class="form-control states"  name="state" >
                  
                        
                  <option value="Alabama" @if($employer->state ==  "Alabama") selected @endif>Alabama</option>
                  <option value="Alaska" @if($employer->state ==  "Alaska") selected @endif>Alaska</option>
                  <option value="Arizona" @if($employer->state ==  "Arizona") selected @endif>Arizona</option>
                  <option value="Arkansas" @if($employer->state ==  "Arkansas") selected @endif>Arkansas</option>
                  <option value="California" @if($employer->state ==  "California") selected @endif>California</option>
                  <option value="Colorado" @if($employer->state ==  "Colorado") selected @endif>Colorado</option>
                  <option value="Connecticut" @if($employer->state ==  "Connecticut") selected @endif>Connecticut</option>
                  <option value="Delaware" @if($employer->state ==  "Delaware") selected @endif>Delaware</option>
                  <option value="District Of Columbia" @if($employer->state ==  "District Of Columbia") selected @endif>District Of Columbia</option>
                  <option value="Florida" @if($employer->state ==  "Florida") selected @endif>Florida</option>
                  <option value="Georgia" @if($employer->state ==  "Georgia") selected @endif>Georgia</option>
                  <option value="Hawaii" @if($employer->state ==  "Hawaii") selected @endif>Hawaii</option>
                  <option value="Idaho" @if($employer->state ==  "Idaho") selected @endif>Idaho</option>
                  <option value="Illinois" @if($employer->state ==  "Illinois") selected @endif>Illinois</option>
                  <option value="Indiana" @if($employer->state ==  "Alabama") selected @endif>Indiana</option>
                  <option value="Iowa" @if($employer->state ==  "Iowa") selected @endif>Iowa</option>
                  <option value="Kansas" @if($employer->state ==  "Kansas") selected @endif>Kansas</option>
                  <option value="Kentucky" @if($employer->state ==  "Kentucky") selected @endif>Kentucky</option>
                  <option value="Louisiana" @if($employer->state ==  "Louisiana") selected @endif>Louisiana</option>
                  <option value="Maine" @if($employer->state ==  "Maine") selected @endif>Maine</option>
                  <option value="Maryland" @if($employer->state ==  "Maryland") selected @endif>Maryland</option>
                  <option value="Massachusetts" @if($employer->state ==  "Massachusetts") selected @endif>Massachusetts</option>
                  <option value="Michigan" @if($employer->state ==  "Michigan") selected @endif>Michigan</option>
                  <option value="Minnesota" @if($employer->state ==  "Minnesota") selected @endif>Minnesota</option>
                  <option value="Mississippi" @if($employer->state ==  "Mississippi") selected @endif>Mississippi</option>
                  <option value="Missouri" @if($employer->state ==  "Missouri") selected @endif>Missouri</option>
                  <option value="Montana" @if($employer->state ==  "Montana") selected @endif>Montana</option>
                  <option value="Nebraska" @if($employer->state ==  "Nebraska") selected @endif>Nebraska</option>
                  <option value="Nevada" @if($employer->state ==  "Nevada") selected @endif>Nevada</option>
                  <option value="New Hampshire" @if($employer->state ==  "New Hampshire") selected @endif>New Hampshire</option>
                  <option value="New Jersey" @if($employer->state ==  "New Jersey") selected @endif>New Jersey</option>
                  <option value="New Mexico" @if($employer->state ==  "New Mexico") selected @endif>New Mexico</option>
                  <option value="New York" @if($employer->state ==  "New York") selected @endif>New York</option>
                  <option value="North Carolina" @if($employer->state ==  "Alabama") selected @endif>North Carolina</option>
                  <option value="North Dakota" @if($employer->state ==  "North Dakota") selected @endif>North Dakota</option>
                  <option value="Ohio" @if($employer->state ==  "Ohio") selected @endif>Ohio</option>
                  <option value="Oklahoma" @if($employer->state ==  "Oklahoma") selected @endif>Oklahoma</option>
                  <option value="Oregon" @if($employer->state ==  "Oregon") selected @endif>Oregon</option>
                  <option value="Pennsylvania" @if($employer->state ==  "Pennsylvania") selected @endif>Pennsylvania</option>
                  <option value="Rhode Island" @if($employer->state ==  "Rhode Island") selected @endif>Rhode Island</option>
                  <option value="South Carolina" @if($employer->state ==  "South Carolina") selected @endif>South Carolina</option>
                  <option value="South Dakota" @if($employer->state ==  "South Dakota") selected @endif>South Dakota</option>
                  <option value="Tennessee" @if($employer->state ==  "Tennessee") selected @endif>Tennessee</option>
                  <option value="Texas" @if($employer->state ==  "Texas") selected @endif>Texas</option>
                  <option value="Utah" @if($employer->state ==  "Utah") selected @endif>Utah</option>
                  <option value="Vermont" @if($employer->state ==  "Vermont") selected @endif>Vermont</option>
                  <option value="Virginia" @if($employer->state ==  "Virginia") selected @endif>Virginia</option>
                  <option value="Washington" @if($employer->state ==  "Washington") selected @endif>Washington</option>
                  <option value="West Virginia" @if($employer->state ==  "West Virginia") selected @endif>West Virginia</option>
                  <option value="Wisconsin" @if($employer->state ==  "Wisconsin") selected @endif>Wisconsin</option>
                  <option value="Wyoming" @if($employer->state ==  "Wyoming") selected @endif>Wyoming</option>
         </select>
    </div>
   <div class="form-group">
                <label class="form-control-label">Status</label>
                <select id="status" class="form-control" name="status">
                    <option disabled value="0" @if($employer->status == null ) selected @endif> Pending</option>
                    <option value="1" @if($employer->status == 1 ) selected @endif> Accepted</option>
                    <option value="2" @if($employer->status == 2 ) selected @endif> Rejected</option>
             </select>
            </div>
   

    <div class="mt-4 ">
        <button class="btn btn-primary" name="form_submit" value="submit" type="submit">Save Changes</button>
        <button type="button" class="btn btn-danger" data-dismiss="modal">Cancel</button>
    </div>
</form>
