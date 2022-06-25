<form method="post" action="{{ route('auditprice.create') }}" autocomplete="off" enctype="multipart/form-data" class="bv-form">
     @csrf
     <input class="form-control pricefield" type="hidden" value="{{!empty($data->id) ? encrypted_key($data->id, "encrypt"):''}}" name="id">

   <div class="form-group">
                <label class="form-control-label">Price</label>
               <input type="number" class="form-control" value="{{ $data->price }}" name="price" disabled>
            </div>
     </div>
</div>
</div>
    
<div class="mt-4 editprice" >
        <button class="btn btn-primary" name="form_submit" value="submit" type="submit">Edit</button>
        
    </div>
    <div class="mt-4 savprice" style="display:none;">
        <button class="btn btn-primary" name="form_submit" value="submit" type="submit">Save Changes</button>
        <button type="button" class="btn btn-danger" data-dismiss="modal">Cancel</button>
    </div>
</form>
<script>

    $("#permissions").select2();
    $('.editprice').click(function(e){
        e.preventDefault();
     $(this).hide(); 
     $('.savprice').show();  
     $('input').removeAttr("disabled");
    })
    </script>
