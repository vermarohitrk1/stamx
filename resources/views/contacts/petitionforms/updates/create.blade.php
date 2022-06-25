{{ Form::open(['route' =>'petitionupdate.store','id' => 'create_folder','enctype' => 'multipart/form-data']) }}

<div class="form-group">
        <div class="row">
            <div class="col-md-12">
                <label class="form-control-label">Update</label>
                <input type="text" class="form-control" name="name" placeholder="Update" value="{{$update->updates??''}}" required>
                <input type="hidden" class="form-control" name="id" placeholder="Name" value="{{$update->id??0}}" required>
                <input type="hidden" name="csrf-token" value="<?=csrf_token();?>" />
            </div>
        </div>
    </div>
<div class="form-group">
        <div class="row">
            <div class="col-md-12">
                <label class="form-control-label">Date</label>
                <input type="date" class="form-control" name="date" value="{{$update->date??''}}" required>
            </div>
        </div>
    </div>


                       <div class="form-group">
        <div class="row">
            <div class="col-md-12">
                          <label for="filter_status" class="sr-only">Petition</label>
                          <select id='petition' name="petition" class="form-control" style="width: 100%" required="">
                              @if(!empty($petitions) && count($petitions)>0)
                                 @foreach($petitions as $key => $val)
                                <option @if(!empty($update->petition_id) && $update->petition_id=$val->id) selected @endif value="{{ $val->id }}">{{__($val->title)}}</option>
                                @endforeach
                                  @endif
                            </select>
                          </div>
        </div>
    </div>
                          

</div>
<div class="text-right">
    {{ Form::button(__('Save'), ['type' => 'submit','class' => 'btn btn-sm btn-primary rounded-pill']) }}
    <button type="button" class="btn btn-sm btn-secondary rounded-pill" data-dismiss="modal">{{__('Cancel')}}</button>
</div>
{{ Form::close() }}


<link rel="stylesheet" type="text/css" href="{{ asset('assets/css/simcify.min.css') }}">
<script src="{{ asset('assets/js/simcify.min.js') }}"></script>


<script src="{{ asset('public/ckeditor/ckeditor.js') }}"></script>

<script>
</script>









