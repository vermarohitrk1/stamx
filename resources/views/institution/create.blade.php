<form method="post" action="{{route('institutions.store')}}" autocomplete="off" enctype="multipart/form-data" class="bv-form">
     @csrf
     <input class="form-control" type="hidden" value="{{!empty($institution->id) ? encrypted_key($institution->id, "encrypt"):''}}" name="id">
     <div class="form-group">
        <label>Institution</label>
        <input class="form-control" type="text"  name="institution" id="Institution" value="{{ $institution->institution }}" >
   </div>
   <div class="form-group">
                <label class="form-control-label">Address</label>
               <textarea name="address" class="form-control" id="address" rows="3" value=""> {{ $institution->address }}</textarea>
    </div>
    <div class="form-group">
                <label class="form-control-label">City</label>
                <input class="form-control" type="text"  name="city" id="city" value="{{ $institution->city }}" >
    </div>
    <div class="form-group">
                <label class="form-control-label">State</label>
                <select class="form-control states"  name="state" >
                  
                        
                            <option value="Alabama" @if($institution->state ==  "Alabama") selected @endif>Alabama</option>
                            <option value="Alaska" @if($institution->state ==  "Alaska") selected @endif>Alaska</option>
                            <option value="Arizona" @if($institution->state ==  "Arizona") selected @endif>Arizona</option>
                            <option value="Arkansas" @if($institution->state ==  "Arkansas") selected @endif>Arkansas</option>
                            <option value="California" @if($institution->state ==  "California") selected @endif>California</option>
                            <option value="Colorado" @if($institution->state ==  "Colorado") selected @endif>Colorado</option>
                            <option value="Connecticut" @if($institution->state ==  "Connecticut") selected @endif>Connecticut</option>
                            <option value="Delaware" @if($institution->state ==  "Delaware") selected @endif>Delaware</option>
                            <option value="District Of Columbia" @if($institution->state ==  "District Of Columbia") selected @endif>District Of Columbia</option>
                            <option value="Florida" @if($institution->state ==  "Florida") selected @endif>Florida</option>
                            <option value="Georgia" @if($institution->state ==  "Georgia") selected @endif>Georgia</option>
                            <option value="Hawaii" @if($institution->state ==  "Hawaii") selected @endif>Hawaii</option>
                            <option value="Idaho" @if($institution->state ==  "Idaho") selected @endif>Idaho</option>
                            <option value="Illinois" @if($institution->state ==  "Illinois") selected @endif>Illinois</option>
                            <option value="Indiana" @if($institution->state ==  "Alabama") selected @endif>Indiana</option>
                            <option value="Iowa" @if($institution->state ==  "Iowa") selected @endif>Iowa</option>
                            <option value="Kansas" @if($institution->state ==  "Kansas") selected @endif>Kansas</option>
                            <option value="Kentucky" @if($institution->state ==  "Kentucky") selected @endif>Kentucky</option>
                            <option value="Louisiana" @if($institution->state ==  "Louisiana") selected @endif>Louisiana</option>
                            <option value="Maine" @if($institution->state ==  "Maine") selected @endif>Maine</option>
                            <option value="Maryland" @if($institution->state ==  "Maryland") selected @endif>Maryland</option>
                            <option value="Massachusetts" @if($institution->state ==  "Massachusetts") selected @endif>Massachusetts</option>
                            <option value="Michigan" @if($institution->state ==  "Michigan") selected @endif>Michigan</option>
                            <option value="Minnesota" @if($institution->state ==  "Minnesota") selected @endif>Minnesota</option>
                            <option value="Mississippi" @if($institution->state ==  "Mississippi") selected @endif>Mississippi</option>
                            <option value="Missouri" @if($institution->state ==  "Missouri") selected @endif>Missouri</option>
                            <option value="Montana" @if($institution->state ==  "Montana") selected @endif>Montana</option>
                            <option value="Nebraska" @if($institution->state ==  "Nebraska") selected @endif>Nebraska</option>
                            <option value="Nevada" @if($institution->state ==  "Nevada") selected @endif>Nevada</option>
                            <option value="New Hampshire" @if($institution->state ==  "New Hampshire") selected @endif>New Hampshire</option>
                            <option value="New Jersey" @if($institution->state ==  "New Jersey") selected @endif>New Jersey</option>
                            <option value="New Mexico" @if($institution->state ==  "New Mexico") selected @endif>New Mexico</option>
                            <option value="New York" @if($institution->state ==  "New York") selected @endif>New York</option>
                            <option value="North Carolina" @if($institution->state ==  "Alabama") selected @endif>North Carolina</option>
                            <option value="North Dakota" @if($institution->state ==  "North Dakota") selected @endif>North Dakota</option>
                            <option value="Ohio" @if($institution->state ==  "Ohio") selected @endif>Ohio</option>
                            <option value="Oklahoma" @if($institution->state ==  "Oklahoma") selected @endif>Oklahoma</option>
                            <option value="Oregon" @if($institution->state ==  "Oregon") selected @endif>Oregon</option>
                            <option value="Pennsylvania" @if($institution->state ==  "Pennsylvania") selected @endif>Pennsylvania</option>
                            <option value="Rhode Island" @if($institution->state ==  "Rhode Island") selected @endif>Rhode Island</option>
                            <option value="South Carolina" @if($institution->state ==  "South Carolina") selected @endif>South Carolina</option>
                            <option value="South Dakota" @if($institution->state ==  "South Dakota") selected @endif>South Dakota</option>
                            <option value="Tennessee" @if($institution->state ==  "Tennessee") selected @endif>Tennessee</option>
                            <option value="Texas" @if($institution->state ==  "Texas") selected @endif>Texas</option>
                            <option value="Utah" @if($institution->state ==  "Utah") selected @endif>Utah</option>
                            <option value="Vermont" @if($institution->state ==  "Vermont") selected @endif>Vermont</option>
                            <option value="Virginia" @if($institution->state ==  "Virginia") selected @endif>Virginia</option>
                            <option value="Washington" @if($institution->state ==  "Washington") selected @endif>Washington</option>
                            <option value="West Virginia" @if($institution->state ==  "West Virginia") selected @endif>West Virginia</option>
                            <option value="Wisconsin" @if($institution->state ==  "Wisconsin") selected @endif>Wisconsin</option>
                            <option value="Wyoming" @if($institution->state ==  "Wyoming") selected @endif>Wyoming</option>
                   </select>
    </div>
   
    <div class="form-group">
                <label class="form-control-label">Type</label>
                <select id="type" class="form-control" name="type">
                  
                    <option value="school" @if($institution->type ==  "school") selected @endif > School</option>
                    <option value="college" @if($institution->type ==  "college") selected @endif> College</option>
             </select>
            </div>
   <div class="form-group">
                <label class="form-control-label">Status</label>
                <select id="status" class="form-control" name="status">
                    <option disabled value="0" @if($institution->status == null ) selected @endif> Pending</option>
                    <option value="1" @if($institution->status == 1 ) selected @endif> Accepted</option>
                    <option value="2" @if($institution->status == 2 ) selected @endif> Rejected</option>
             </select>
            </div>
   

    <div class="mt-4 ">
        <button class="btn btn-primary" name="form_submit" value="submit" type="submit">Save Changes</button>
        <button type="button" class="btn btn-danger" data-dismiss="modal">Cancel</button>
    </div>
</form>
