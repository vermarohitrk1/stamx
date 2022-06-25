@include('layout.partials.head_dashboard')
@include('layout.partials.footer-dashboard-scripts')

{{ Form::open(['url' => '','id' => 'create_page','enctype' => 'multipart/form-data','method'=>'post']) }}
@if(isset($page))
<input type="hidden" name="page_id" value=" {{ $page->id}}">
@endif
<div class="row">
    <div class="col-12 col-md-12">
        
        <div class="form-group">
            <label for="page_name" class="form-control-label">Page name</label>
            <input class="form-control" required="required" name="page_name" type="text" id="page_name" value="@if(isset($page)) {{ $page->page_name}} @endif">
        </div>
    </div>
</div>
<div class="form-group">
    <div class="row">
        <div class="col-md-12">
            <label class="form-control-label">Status</label>
            <select class="form-control" name="status">
                <option value="Published" @if(isset($page) && $page->status =='Published' ) selected @endif>Published</option>
                <option value="Unpublished" @if(isset($page) && $page->status =='Unpublished' ) selected @endif>Unpublished</option>
            </select>
        </div>
    </div>
</div>
 <div class="form-group">
	<div class="row">
		<div class="col-md-12">
			<label class="form-control-label">Banner Image</label>
            @if(isset($page) && !empty($page->image))
										<input type="file" name="image" class="custom-input-file croppie" default="{{asset('storage')}}/pages/{{ $page->image }}" crop-width="800" crop-height="350"  accept="image/*">
                                        <div class="form-check">
                                            <input type="checkbox" class="form-check-input" name="image_delete"  id="exampleCheck1">
                                            <label class="form-check-label" for="exampleCheck1">Delete Image ?</label>
                                        </div>
						            @else

										<input type="file" name="image" class="custom-input-file croppie" crop-width="800" crop-height="350"  accept="image/*"  >
						            @endif
        </div>
	</div>
</div>
<div class="form-group">
	<div class="row">
		<div class="col-md-12">
			<label class="form-control-label">Header Text Color</label>
            <!-- <input id="color-picker" value="@if(isset($page)) {{ $page->color}} @endif" class="form-control" name="color"/> -->
            <input type="color" id="favcolor" name="color" value="@if(isset($page)) {{ $page->color}} @endif">
        </div>
	</div>
</div>
<div class="form-group">
    <div class="row">
        <div class="col-md-12">
            <label class="form-control-label">Title</label>
            <input  type="text"  class="form-control" name="title" value="@if(isset($page)) {{ $page->title}} @endif"/>
        </div>
    </div>
</div>
<div class="form-group">
    <div class="row">
        <div class="col-md-12">
            <label class="form-control-label">Subtitle</label>
            <input  type="text"  class="form-control" name="subtitle" value="@if(isset($page)) {{ $page->subtitle}} @endif"/>
        </div>
    </div>
</div>
<div class="form-group">
    <div class="row">
        <div class="col-md-12">
            <label class="form-control-label">Page Data</label>
            <textarea class="form-control" id="summary-ckeditor" name="page_data"  placeholder="Book Description" rows="10" required>@if(isset($page)) {{ $page->page_data}} @endif</textarea>
        </div>
    </div>
</div>
<div class="text-right">
    {{ Form::button(__('Save'), ['type' => 'submit','class' => 'btn btn-sm btn-primary rounded-pill']) }}
</div>
{{ Form::close() }}
<style>
.croppie-container {
    zoom: 37% !important;
}
    .modal-content {
        margin: 75px;
        width: 76%;
    }
    form#create_page {
    padding: 15px;
}

button.btn.btn-sm.btn-primary.rounded-pill {
    width: 100%;
    padding: 10px;
    border-radius: 10px!important;
    background: #2d2b2b!important;
    border: none;
}
</style>
<link rel="stylesheet" type="text/css" href="{{ asset('assets/css/simcify.min.css') }}">
<script src="{{ asset('assets/js/simcify.min.js') }}"></script>
<script src="{{ asset('public/ckeditor/ckeditor.js') }}"></script>

<script type="text/javascript">
CKEDITOR.replace('summary-ckeditor');

    // $( document ).ready(function() {
    //     $('#color-picker').spectrum({
    //         type: "component"
    //     });
    // });

    function updateAllMessageForms()
{
    for (instance in CKEDITOR.instances) {
            CKEDITOR.instances[instance].updateElement();
    }
}
   $('form#create_page').on('submit',function(e){
    e.preventDefault();
    updateAllMessageForms();
    const $data = $(this).serialize();
    $.ajax({
            type:"POST",
            url:"{{url('api/appuser/page/store')}}",
            data:$data,
            success: function(response){
                console.log(response);  
            }
        });

   });
</script>
