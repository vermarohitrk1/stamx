{{ Form::open(['url' => 'certify/store','id' => 'create_masterclass','enctype' => 'multipart/form-data']) }}
<div class="form-group">
    <div class="row">
        <div class="col-md-12">
            <label class="form-control-label">Course Name</label>
            <input type="text" name="name" class="form-control" placeholder="Course Name" required="">
            <input type="hidden" name="type" value="Masterclass">
        </div>
    </div>
</div>

<div class="form-group">
    <div class="row">
        <div class="col-md-12">
            <label class="form-control-label">Industry</label>
            <select name="bls_industry" class="form-control" required="">
            @foreach($bls_industries as $k => $v)
            <option value="{{ $v->id }}">{{ $v->name }}</option>
            @endforeach 
        </div>
    </div>
</div>

<div class="form-group">
    <div class="row">
        <div class="col-md-12" style="display: inline-flex;">
            <input type="checkbox" name="pennfoster" value="1" class="" />
            &nbsp;&nbsp;&nbsp;&nbsp;<label  class="form-control-label">Penn Foster</label>
        </div>
    </div>
</div>


<div class="form-group">
    <div class="row">
        <div class="col-md-12">
            <label class="form-control-label">Status</label>
            <select class="form-control" name="status">
                <option value="Published">Published</option>
                <option value="Unpublished">Unpublished</option>
            </select>
        </div>
    </div>
</div>


<div class="form-group">
    <div class="row">
        <div class="col-md-12">
            <label class="form-control-label">Syndicate</label>
            <select class="form-control" name="syndicate">
                <option value="Enabled">Enabled</option>
                <option value="Disabled">Disabled</option>
            </select>
        </div>
    </div>
</div>

<div class="form-group">
    <div class="row">
        <div class="col-md-6">
            <label class="form-control-label">Price ($)</label>
            <input type="number" class="form-control" name="price" placeholder="Price ($)" required>
        </div>
        <div class="col-md-6">
            <label class="form-control-label">Sale Price ($)</label>
            <input type="number" class="form-control" name="sale_price" placeholder="Sale Price ($)">
        </div>
    </div>
</div>

<div class="form-group">
    <div class="row">
        <div class="col-md-4">
            <label class="form-control-label">Duration</label>
            <input type="number" name="duration" step="1" class="form-control just-number" placeholder="Duration"
                   required="">
        </div>
        <div class="col-md-4">
            <label class="form-control-label">Period</label>
            <select name="period" class="form-control" required="">
                <option value="Days">Days</option>
                <option value="Weeks">Weeks</option>
                <option value="Months">Months</option>
            </select>
        </div>
        <div class="col-md-4">
            <label class="form-control-label">Category</label>
            <select class="form-control" name="category">
                @if($countCertify_categories > 1)
                    @foreach($Certify_categories as $Certify_category)
                    @if($Certify_category->id == '0')
                    <option value="{{$Certify_category->id}}" disabled="disabled" >{{$Certify_category->name}}</option>
                    @else
                    <option value="{{$Certify_category->id}}">{{$Certify_category->name}}</option>
                    @endif
                    @endforeach
                @else
                    @foreach($Certify_categories as $Certify_category)
                    <option value="{{$Certify_category->id}}">{{$Certify_category->name}}</option>
                    @endforeach
                @endif
            </select>
        </div>
    </div>
</div>
<div class="form-group">
    <div class="row">
        <div class="col-md-12">
            <label class="form-control-label">Taught By</label>
            <input type="text" name="instructor" class="form-control" placeholder="Taught By">
            <p class="text-muted text-xs">If empty, your name will be shown.</p>
        </div>
    </div>
</div>  
<div class="form-group">
    <div class="row">
        <div class="col-md-12">
            <label class="form-control-label">Cover Image</label>
            <input type="file" name="image" class="custom-input-file croppie" crop-width="1000" crop-height="400"  accept="image/*" required="" >
        </div>
    </div>
</div>

<div class="form-group uploadvideo" id="videolink">
    <div class="row">
        <div class="col-md-12">
            <label class="form-control-label">Preview Video</label>
              <input type="file" class="form-control dropify" placeholder="Upload video File" name="videofile"  accept="video/mp4" >
        </div>
    </div>
</div>


<div class="form-group">
    <div class="row">
        <div class="col-md-12">
            <label class="form-control-label">Course Description</label>
            <textarea class="form-control" id="summary-ckeditor" name="description" placeholder="Course Description" rows="5" required></textarea>
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
CKEDITOR.replace( 'summary-ckeditor' );
</script>
<script>
    $(function () {
        $('input[name="prerequisites"]').hide();
        $('.responsefield').hide();
        //show it when the checkbox is clicked
        $('input[name="boardcertified"]').on('click', function () {
            if ($(this).prop('checked')) {
                $('input[name="prerequisites"]').fadeIn();
                $('.responsefield').fadeIn();
            } else {
                $('input[name="prerequisites"]').hide();
                $('.responsefield').hide();
            }
        });
    });
</script> 
<script>
    $(function () {
        $('input[name="addlogos"]').hide();
        $('.alllogofield').hide();
        //show it when the checkbox is clicked
        $('input[name="authoritylabel"]').on('click', function () {
            if ($(this).prop('checked')) {
                $('input[name="addlogos"]').fadeIn();
                $('.alllogofield').fadeIn();
            } else {
                $('input[name="addlogos"]').hide();
                $('.alllogofield').hide();
            }
        });
    });
</script> 

<script>
    $('#youtubelink').hide();
    $('#videotype').on('change', function () {

        if (this.value == "youtubelink") {
            $('#youtubelink').show();
            $('#videolink').hide();
        } else {
            $('#videolink').show();
            $('#youtubelink').hide();
        }
    });

</script>
<script>
function showModal() {
    $('body').loadingModal({text: 'loading...'});
    var delay = function(ms){ return new Promise(function(r) { setTimeout(r, ms) }) };
    var time = 1000000;
    delay(time)
            .then(function() { $('body').loadingModal('animation', 'circle').loadingModal('backgroundColor', 'black'); return delay(time);})
            .then(function() { $('body').loadingModal('destroy') ;} );
}
$( "#create_masterclass" ).submit(function( event ) {
  showModal();
});
</script>