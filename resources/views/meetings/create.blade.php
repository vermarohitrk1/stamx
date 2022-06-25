{{ Form::open(['route' =>'meeting.schedule.store','id' => 'create_contact','enctype' => 'multipart/form-data']) }}

<div class="form-group">
        <div class="row">
            <div class="col-md-12">
                <label class="form-control-label">Title</label>
                <input type="text" class="form-control" name="title" placeholder="Title" required>
                <input type="hidden" name="csrf-token" value="<?=csrf_token();?>" />
            </div>
        </div>
    </div>

<div class="form-group">
        <div class="row">
            <div class="col-md-12">
                <label class="form-control-label">Service Type</label>
                <select class="form-control" id="service_type_id" name="service_type_id">
                    @foreach($type as $i=>$row)
                        <option value="{{$i}}"  >{{$row}}</option>
                    @endforeach
                </select>
            </div>
        </div>
    </div>
<div class="form-group" id="service_id_div">
        <div class="row">
            <div class="col-md-12">
                <label class="form-control-label">Select Course</label>
                <select class="form-control" id="service_id" name="service_id" >
                    <option value=""  >Please select</option>
                    @foreach($courses as $row)
                        <option value="{{$row->id}}"  >{{$row->name}}</option>
                    @endforeach
                </select>
            </div>
        </div>
    </div>
<div class="form-group">
        <div class="row">
            <div class="col-md-12">
                <label class="form-control-label">Write Service Description</label>
                <textarea class="form-control" id="summary-ckeditor" name="description" placeholder="Please describe your meeting service" rows="5" required></textarea>
            </div>
        </div>
    </div>
    
    <div class="form-group">
        <div class="row">
            <div class="col-md-12">
                <label class="form-control-label">How much price($) will you charge?</label>
                <input type="number" class="form-control" name="price" min="0" step="any" placeholder="$0.00" >
            </div>
        </div>
    </div>
    <div class="form-group">
        <div class="row">
            <div class="col-md-12">
                <label class="form-control-label">Please explain your charges. (Optional)</label>
                <textarea class="form-control" id="summary-ckeditor1" name="price_description" placeholder="Video call charges $50 included." rows="3" ></textarea>
            </div>
        </div>
    </div>
    <div class="form-group">
        <div class="row">
            <div class="col-md-12">
                <label class="form-control-label">Status</label>
                <select class="form-control" name="status">
                    <option value="Active">Active</option>
                    <option value="InActive">InActive</option>
                </select>
            </div>
        </div>
    </div>
    



<div class="text-right">
    {{ Form::button(__('Save'), ['type' => 'submit','class' => 'btn btn-sm btn-primary rounded-pill']) }}
    <button type="button" class="btn btn-sm btn-secondary rounded-pill" data-dismiss="modal">{{__('Cancel')}}</button>
</div>
{{ Form::close() }}



<script src="{{ asset('public/ckeditor/ckeditor.js') }}"></script>
<script>
CKEDITOR.replace('summary-ckeditor');
CKEDITOR.replace('summary-ckeditor1');
$('#service_id_div').hide();
    
    $(document).on("change","#service_type_id",function() {
         var value = this.value;
        if(value==2){
            
            $('#service_id_div').show();
            $('#service_id').attr("required", true);
           
        }else{
             $('#service_id_div').hide();
            $('#service_id').attr("required", false);
            $('#service_id').val('');
        }
    });
</script>






