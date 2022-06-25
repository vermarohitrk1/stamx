<form method="post" action="{{route('quotes.store')}}" autocomplete="off" enctype="multipart/form-data" class="bv-form">
     @csrf
     <input class="form-control" type="hidden" value="{{!empty($quote->id) ? encrypted_key($quote->id, "encrypt"):''}}" name="id">
    <div class="form-group">
        <label>Quote</label>
        <input class="form-control" type="text" value="{{!empty($quote->name) ? $quote->name:''}}" name="name" id="name" >
   </div>
  
      </div>
</div>
            </div>

    <div class="mt-4 ">
        <button class="btn btn-primary" name="form_submit" value="submit" type="submit">Save Changes</button>
        <button type="button" class="btn btn-danger" data-dismiss="modal">Cancel</button>
    </div>
</form>
