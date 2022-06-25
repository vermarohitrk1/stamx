
<?php $page = "virtualbooth"; ?>

@extends('layout.dashboardlayout')
@section('content')	
<style>
	li.splide__slide {
    width: 80px;
    float: left;
}
div#commonModal {
    z-index: 99999;
}
.dz-success-mark {
    display: none;
}
.dz-error-mark {
    display: none;
}
.dz-preview.dz-complete.dz-image-preview {
    display: inline-block;
}
.imageframe.lib-item.splide__slide__container {
    width: 100px;
    float: left;
}
</style>
<link rel="stylesheet" href="{{ asset('css/photobooth.css') }}">
<link rel="stylesheet" href="{{ asset('css/splide.css') }}">


<!-- Page Content -->
<div class="content">
    <div class="container-fluid">

        <div class="row">
            <div class="col-md-5 col-lg-4 col-xl-3 theiaStickySidebar">

                <!-- Sidebar -->
                      @include('layout.partials.userSideMenu')
                <!-- /Sidebar -->

            </div>

            <div class="col-md-7 col-lg-8 col-xl-9">
                <div class=" col-md-12 ">
                
                    <a href="#" class="btn btn-sm btn btn-primary float-right " data-url="{{ route('virtualboothEvents.create') }}" data-ajax-popup="true" data-size="lg" data-title="{{__('Upload Photobooth Template')}}">
            <span class="btn-inner--icon"><i class="fas fa-plus"></i></span>
        </a>
                </div>
   
<!-- Breadcrumb -->
<div class="breadcrumb-bar mt-3">
    <div class="container-fluid">
        <div class="row align-items-center">
            <div class="col-md-12 col-12">
                <h2 class="breadcrumb-title">Events</h2>
                <nav aria-label="breadcrumb" class="page-breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="index">Home</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Events</li>
                    </ol>
                </nav>
            </div>              
        </div>            
    </div>
</div>
<!-- /Breadcrumb -->



<br>

<div class="row" id="blog_view">
     <div class="col-12">
        <div class="card">
            <div class="card-body">
                <div class="table-md-responsive">
                    <table class="table table-hover table-center mb-0" id="myTable">
                        <thead class="thead-light">
                        <tr>
                            <th class=" mb-0 h6 text-sm"> {{__('Name')}}</th>
                            <th class=" mb-0 h6 text-sm"> {{__('Photos')}}</th>
                            <th class=" mb-0 h6 text-sm"> {{__('Email')}}</th>
                            <th class=" mb-0 h6 text-sm"> {{__('Facebook')}}</th>
                            <th class=" mb-0 h6 text-sm"> {{__('Twitter')}}</th>

                            <th class="text-right name mb-0 h6 text-sm"> {{__('Actions')}}</th>
                        </tr>
                        </thead> 
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>



</div>
</div>
</div>
</div>
@endsection

@push('script')
<script type="text/javascript" src="{{ asset('js/interact.js') }}"></script>


<script type="text/javascript" src="{{ asset('js/dropzone.js') }}"></script>

<script type="text/javascript" src="{{ asset('js/photobooth.js') }}"></script>
<script type="text/javascript" src="{{ asset('public/ckeditor/ckeditor.js') }}"></script>
<script type="text/javascript" src="https://cdn.jsdelivr.net/npm/lozad/dist/lozad.min.js"></script>
<script type="text/javascript" src="{{ asset('js/splide.js') }}"></script>


<!--<script src="{{asset('assets/js/croppie.js')}}"></script>-->
<script>
CKEDITOR.replace('summary-ckeditor');
</script>

<script type="text/javascript">
    
    

    $(function () {   
		
		
	
    var table = $('#myTable').DataTable({
         responsive: true,
        processing: true,
        serverSide: true,
        ajax: "{{ route('virtualbooth.events') }}",
        columns: [
            //{data: 'DT_RowIndex', name: 'DT_RowIndex'},
            {data: 'event_name', name: 'event_name'},
            {data: 'photos', name: 'imaphotosge',orderable: false,searchable: false},
            {data: 'emails', name: 'emails'},
            {data: 'facebook', name: 'facebook'},
            {data: 'twitter', name: 'twitter'},
            {
                data: 'action', 
                name: 'action', 
                orderable: true, 
                searchable: true
            },
        ]
    });

  
    $(document).on("click",".useTemplate",function() {
        alert("click bound to document listening for #test-element");
    });
  });
</script>
<script>
$(document).on('change','#dz-bgImage',function(e){
//alert($(this).val());
$('#event_image').val(this.files && this.files.length ? this.files[0].name : '');


          
    });
	$(document).on('click','.imageframe',function(e){
	var src =	$(this).data('src');
	var img =	$(this).data('img');
	var clas =	$(this).data('id');

	$('#templ_img').val(src);
	$('#templ_img2').val(img);
	$('#templ_img3').val(clas);

    $('#imgae_coll').append('<input type="hidden" name="frames[]" class="getimage '+ clas +'"  value="'+ img +'" /><input type="hidden" class="setimage '+ clas +'" value="'+ src +'" />');
$('.needsclick').hide();



	$('.screens-menu').toggle();
    });
	$(document).on('click','.dz-remove',function(e){
		$(this).parent('.dz-preview').remove();
		$('.'+ $(this).data('id')).remove();
		var arr1 = [];
		var arr2 = [];
	$('.getimage').each(function(i, obj) {
   console.log(obj.value);
   arr1.push(obj.value)

});
	$('.getsticker').each(function(i, obj) {
   console.log(obj.value);
   arr2.push(obj.value)
 
});

//$(this).parent().sibling('.dropzone-desc').show();
$('#stickers').val(arr2.toString());

$('#frames').val(arr1.toString());
	});
	$(document).on('click','.imagetypes',function(e){
//alert($(this).data('type'));
if($(this).data('type') == 'frames'){
var img = $('#templ_img').val();
var src = $('#templ_img').val();
var clas = $('#templ_img3').val();

		$('#dz-frames').append('<div class="dz-preview dz-complete dz-image-preview"><div class="dz-image"><img style="width:100px;"  data-dz-thumbnail="" alt="'+ img +'" src="'+ img +'"></div><div class="dz-details"><div class="dz-size" data-dz-size=""><strong>12.3</strong> KB</div><div class="dz-filename"><span data-dz-name="">'+ img +'</span></div></div><div class="dz-progress"><span class="dz-upload" data-dz-uploadprogress=""></span></div><div class="dz-error-message"><span data-dz-errormessage=""></span></div><div class="dz-success-mark"><svg width="54px" height="54px" viewBox="0 0 54 54" version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" xmlns:sketch="http://www.bohemiancoding.com/sketch/ns"><title>Check</title><g id="Page-1" stroke="none" stroke-width="1" fill="none" fill-rule="evenodd" sketch:type="MSPage"><path d="M23.5,31.8431458 L17.5852419,25.9283877 C16.0248253,24.3679711 13.4910294,24.366835 11.9289322,25.9289322 C10.3700136,27.4878508 10.3665912,30.0234455 11.9283877,31.5852419 L20.4147581,40.0716123 C20.5133999,40.1702541 20.6159315,40.2626649 20.7218615,40.3488435 C22.2835669,41.8725651 24.794234,41.8626202 26.3461564,40.3106978 L43.3106978,23.3461564 C44.8771021,21.7797521 44.8758057,19.2483887 43.3137085,17.6862915 C41.7547899,16.1273729 39.2176035,16.1255422 37.6538436,17.6893022 L23.5,31.8431458 Z M27,53 C41.3594035,53 53,41.3594035 53,27 C53,12.6405965 41.3594035,1 27,1 C12.6405965,1 1,12.6405965 1,27 C1,41.3594035 12.6405965,53 27,53 Z" id="Oval-2" stroke-opacity="0.198794158" stroke="#747474" fill-opacity="0.816519475" fill="#FFFFFF" sketch:type="MSShapeGroup"></path></g></svg></div><div class="dz-error-mark"><svg width="54px" height="54px" viewBox="0 0 54 54" version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" xmlns:sketch="http://www.bohemiancoding.com/sketch/ns"><title>error</title><g id="Page-1" stroke="none" stroke-width="1" fill="none" fill-rule="evenodd" sketch:type="MSPage"><g id="Check-+-Oval-2" sketch:type="MSLayerGroup" stroke="#747474" stroke-opacity="0.198794158" fill="#FFFFFF" fill-opacity="0.816519475"><path d="M32.6568542,29 L38.3106978,23.3461564 C39.8771021,21.7797521 39.8758057,19.2483887 38.3137085,17.6862915 C36.7547899,16.1273729 34.2176035,16.1255422 32.6538436,17.6893022 L27,23.3431458 L21.3461564,17.6893022 C19.7823965,16.1255422 17.2452101,16.1273729 15.6862915,17.6862915 C14.1241943,19.2483887 14.1228979,21.7797521 15.6893022,23.3461564 L21.3431458,29 L15.6893022,34.6538436 C14.1228979,36.2202479 14.1241943,38.7516113 15.6862915,40.3137085 C17.2452101,41.8726271 19.7823965,41.8744578 21.3461564,40.3106978 L27,34.6568542 L32.6538436,40.3106978 C34.2176035,41.8744578 36.7547899,41.8726271 38.3137085,40.3137085 C39.8758057,38.7516113 39.8771021,36.2202479 38.3106978,34.6538436 L32.6568542,29 Z M27,53 C41.3594035,53 53,41.3594035 53,27 C53,12.6405965 41.3594035,1 27,1 C12.6405965,1 1,12.6405965 1,27 C1,41.3594035 12.6405965,53 27,53 Z" id="Oval-2" sketch:type="MSShapeGroup"></path></g></g></svg></div><div style="display:none;" class="dz-edit"><a class="dz-edit-btn" href="#" data-path="'+ src +'" data-uid="P65o9qdO"><i class="fa fa-edit"></i></a></div><div style="display:none;" class="dz-download"><a class="dz-download-btn" href="'+ src +'" data-path="'+ src +'" download=""><i class="fa fa-download"></i></a></div><a class="dz-remove" data-id="'+clas+'" href="javascript:undefined;" data-dz-remove=""><i class="fa fa-times"></i></a></div>')
	var arr1 = [];
	$('.getimage').each(function(i, obj) {
   console.log(obj.value);
   arr1.push(obj.value)
   console.log(arr1);
});
$('#frames').val(arr1.toString());
}
if($(this).data('type') == 'backgrounds'){
var img = $('#templ_img').val();
var src = $('#templ_img2').val();

		$('#bgg_img').html('<div  class="dz-previewss dz-complete dz-image-preview"><div class="dz-image"><img style="width:100px;"  data-dz-thumbnail="" alt="'+ img +'" src="'+ img +'"></div><div class="dz-details"><div class="dz-size" data-dz-size=""><strong>12.3</strong> KB</div><div class="dz-filename"><span data-dz-name="">'+ img +'</span></div></div><div class="dz-progress"><span class="dz-upload" data-dz-uploadprogress=""></span></div><div class="dz-error-message"><span data-dz-errormessage=""></span></div><div class="dz-success-mark"><svg width="54px" height="54px" viewBox="0 0 54 54" version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" xmlns:sketch="http://www.bohemiancoding.com/sketch/ns"><title>Check</title><g id="Page-1" stroke="none" stroke-width="1" fill="none" fill-rule="evenodd" sketch:type="MSPage"><path d="M23.5,31.8431458 L17.5852419,25.9283877 C16.0248253,24.3679711 13.4910294,24.366835 11.9289322,25.9289322 C10.3700136,27.4878508 10.3665912,30.0234455 11.9283877,31.5852419 L20.4147581,40.0716123 C20.5133999,40.1702541 20.6159315,40.2626649 20.7218615,40.3488435 C22.2835669,41.8725651 24.794234,41.8626202 26.3461564,40.3106978 L43.3106978,23.3461564 C44.8771021,21.7797521 44.8758057,19.2483887 43.3137085,17.6862915 C41.7547899,16.1273729 39.2176035,16.1255422 37.6538436,17.6893022 L23.5,31.8431458 Z M27,53 C41.3594035,53 53,41.3594035 53,27 C53,12.6405965 41.3594035,1 27,1 C12.6405965,1 1,12.6405965 1,27 C1,41.3594035 12.6405965,53 27,53 Z" id="Oval-2" stroke-opacity="0.198794158" stroke="#747474" fill-opacity="0.816519475" fill="#FFFFFF" sketch:type="MSShapeGroup"></path></g></svg></div><div class="dz-error-mark"><svg width="54px" height="54px" viewBox="0 0 54 54" version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" xmlns:sketch="http://www.bohemiancoding.com/sketch/ns"><title>error</title><g id="Page-1" stroke="none" stroke-width="1" fill="none" fill-rule="evenodd" sketch:type="MSPage"><g id="Check-+-Oval-2" sketch:type="MSLayerGroup" stroke="#747474" stroke-opacity="0.198794158" fill="#FFFFFF" fill-opacity="0.816519475"><path d="M32.6568542,29 L38.3106978,23.3461564 C39.8771021,21.7797521 39.8758057,19.2483887 38.3137085,17.6862915 C36.7547899,16.1273729 34.2176035,16.1255422 32.6538436,17.6893022 L27,23.3431458 L21.3461564,17.6893022 C19.7823965,16.1255422 17.2452101,16.1273729 15.6862915,17.6862915 C14.1241943,19.2483887 14.1228979,21.7797521 15.6893022,23.3461564 L21.3431458,29 L15.6893022,34.6538436 C14.1228979,36.2202479 14.1241943,38.7516113 15.6862915,40.3137085 C17.2452101,41.8726271 19.7823965,41.8744578 21.3461564,40.3106978 L27,34.6568542 L32.6538436,40.3106978 C34.2176035,41.8744578 36.7547899,41.8726271 38.3137085,40.3137085 C39.8758057,38.7516113 39.8771021,36.2202479 38.3106978,34.6538436 L32.6568542,29 Z M27,53 C41.3594035,53 53,41.3594035 53,27 C53,12.6405965 41.3594035,1 27,1 C12.6405965,1 1,12.6405965 1,27 C1,41.3594035 12.6405965,53 27,53 Z" id="Oval-2" sketch:type="MSShapeGroup"></path></g></g></svg></div><div class="dz-edit"><a class="dz-edit-btn" href="#" data-path="'+ src +'" data-uid="P65o9qdO"><i class="fa fa-edit"></i></a></div><div class="dz-download"><a class="dz-download-btn" href="'+ src +'" data-path="'+ src +'" download=""><i class="fa fa-download"></i></a></div><a class="dz-remove" href="javascript:undefined;" data-dz-remove=""><i class="fa fa-times"></i></a></div>')
		$('#bgg_img').find('.dropzone-desc').hide();
$('#event_image').val(src);
}
if($(this).data('type') == 'splash'){
var img = $('#templ_img').val();
var src = $('#templ_img2').val();

		$('#splash').html('<div  class="dz-previewss dz-complete dz-image-preview"><div class="dz-image"><img style="width:100px;"  data-dz-thumbnail="" alt="'+ img +'" src="'+ img +'"></div><div class="dz-details"><div class="dz-size" data-dz-size=""><strong>12.3</strong> KB</div><div class="dz-filename"><span data-dz-name="">'+ img +'</span></div></div><div class="dz-progress"><span class="dz-upload" data-dz-uploadprogress=""></span></div><div class="dz-error-message"><span data-dz-errormessage=""></span></div><div class="dz-success-mark"><svg width="54px" height="54px" viewBox="0 0 54 54" version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" xmlns:sketch="http://www.bohemiancoding.com/sketch/ns"><title>Check</title><g id="Page-1" stroke="none" stroke-width="1" fill="none" fill-rule="evenodd" sketch:type="MSPage"><path d="M23.5,31.8431458 L17.5852419,25.9283877 C16.0248253,24.3679711 13.4910294,24.366835 11.9289322,25.9289322 C10.3700136,27.4878508 10.3665912,30.0234455 11.9283877,31.5852419 L20.4147581,40.0716123 C20.5133999,40.1702541 20.6159315,40.2626649 20.7218615,40.3488435 C22.2835669,41.8725651 24.794234,41.8626202 26.3461564,40.3106978 L43.3106978,23.3461564 C44.8771021,21.7797521 44.8758057,19.2483887 43.3137085,17.6862915 C41.7547899,16.1273729 39.2176035,16.1255422 37.6538436,17.6893022 L23.5,31.8431458 Z M27,53 C41.3594035,53 53,41.3594035 53,27 C53,12.6405965 41.3594035,1 27,1 C12.6405965,1 1,12.6405965 1,27 C1,41.3594035 12.6405965,53 27,53 Z" id="Oval-2" stroke-opacity="0.198794158" stroke="#747474" fill-opacity="0.816519475" fill="#FFFFFF" sketch:type="MSShapeGroup"></path></g></svg></div><div class="dz-error-mark"><svg width="54px" height="54px" viewBox="0 0 54 54" version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" xmlns:sketch="http://www.bohemiancoding.com/sketch/ns"><title>error</title><g id="Page-1" stroke="none" stroke-width="1" fill="none" fill-rule="evenodd" sketch:type="MSPage"><g id="Check-+-Oval-2" sketch:type="MSLayerGroup" stroke="#747474" stroke-opacity="0.198794158" fill="#FFFFFF" fill-opacity="0.816519475"><path d="M32.6568542,29 L38.3106978,23.3461564 C39.8771021,21.7797521 39.8758057,19.2483887 38.3137085,17.6862915 C36.7547899,16.1273729 34.2176035,16.1255422 32.6538436,17.6893022 L27,23.3431458 L21.3461564,17.6893022 C19.7823965,16.1255422 17.2452101,16.1273729 15.6862915,17.6862915 C14.1241943,19.2483887 14.1228979,21.7797521 15.6893022,23.3461564 L21.3431458,29 L15.6893022,34.6538436 C14.1228979,36.2202479 14.1241943,38.7516113 15.6862915,40.3137085 C17.2452101,41.8726271 19.7823965,41.8744578 21.3461564,40.3106978 L27,34.6568542 L32.6538436,40.3106978 C34.2176035,41.8744578 36.7547899,41.8726271 38.3137085,40.3137085 C39.8758057,38.7516113 39.8771021,36.2202479 38.3106978,34.6538436 L32.6568542,29 Z M27,53 C41.3594035,53 53,41.3594035 53,27 C53,12.6405965 41.3594035,1 27,1 C12.6405965,1 1,12.6405965 1,27 C1,41.3594035 12.6405965,53 27,53 Z" id="Oval-2" sketch:type="MSShapeGroup"></path></g></g></svg></div><div class="dz-edit"><a class="dz-edit-btn" href="#" data-path="'+ src +'" data-uid="P65o9qdO"><i class="fa fa-edit"></i></a></div><div class="dz-download"><a class="dz-download-btn" href="'+ src +'" data-path="'+ src +'" download=""><i class="fa fa-download"></i></a></div><a class="dz-remove" href="javascript:undefined;" data-dz-remove=""><i class="fa fa-times"></i></a></div>')
		$('#splash').find('.dropzone-desc').hide()
$('#startImage').val(src);
}


});
$(document).on('click','.imagesticker',function(e){
//alert($(this).data('type'));

var src =	$(this).data('src');
	var img =	$(this).data('img');
	//var class =	$(this).data('id');

$('#dz-stickers').children('.needsclick').hide();
		$('#dz-stickers').append('<div class="dz-preview dz-complete dz-image-preview"><input type="hidden"  class="getsticker" value="'+ img +'" /><input type="hidden" class="setsticker" value="'+ src +'" /><div class="dz-image"><img style="width:100px;"  data-dz-thumbnail="" alt="'+ img +'" src="'+ src +'"></div><div class="dz-details"><div class="dz-size" data-dz-size=""><strong>12.3</strong> KB</div><div class="dz-filename"><span data-dz-name="">'+ img +'</span></div></div><div class="dz-progress"><span class="dz-upload" data-dz-uploadprogress=""></span></div><div class="dz-error-message"><span data-dz-errormessage=""></span></div><div class="dz-success-mark"><svg width="54px" height="54px" viewBox="0 0 54 54" version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" xmlns:sketch="http://www.bohemiancoding.com/sketch/ns"><title>Check</title><g id="Page-1" stroke="none" stroke-width="1" fill="none" fill-rule="evenodd" sketch:type="MSPage"><path d="M23.5,31.8431458 L17.5852419,25.9283877 C16.0248253,24.3679711 13.4910294,24.366835 11.9289322,25.9289322 C10.3700136,27.4878508 10.3665912,30.0234455 11.9283877,31.5852419 L20.4147581,40.0716123 C20.5133999,40.1702541 20.6159315,40.2626649 20.7218615,40.3488435 C22.2835669,41.8725651 24.794234,41.8626202 26.3461564,40.3106978 L43.3106978,23.3461564 C44.8771021,21.7797521 44.8758057,19.2483887 43.3137085,17.6862915 C41.7547899,16.1273729 39.2176035,16.1255422 37.6538436,17.6893022 L23.5,31.8431458 Z M27,53 C41.3594035,53 53,41.3594035 53,27 C53,12.6405965 41.3594035,1 27,1 C12.6405965,1 1,12.6405965 1,27 C1,41.3594035 12.6405965,53 27,53 Z" id="Oval-2" stroke-opacity="0.198794158" stroke="#747474" fill-opacity="0.816519475" fill="#FFFFFF" sketch:type="MSShapeGroup"></path></g></svg></div><div class="dz-error-mark"><svg width="54px" height="54px" viewBox="0 0 54 54" version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" xmlns:sketch="http://www.bohemiancoding.com/sketch/ns"><title>error</title><g id="Page-1" stroke="none" stroke-width="1" fill="none" fill-rule="evenodd" sketch:type="MSPage"><g id="Check-+-Oval-2" sketch:type="MSLayerGroup" stroke="#747474" stroke-opacity="0.198794158" fill="#FFFFFF" fill-opacity="0.816519475"><path d="M32.6568542,29 L38.3106978,23.3461564 C39.8771021,21.7797521 39.8758057,19.2483887 38.3137085,17.6862915 C36.7547899,16.1273729 34.2176035,16.1255422 32.6538436,17.6893022 L27,23.3431458 L21.3461564,17.6893022 C19.7823965,16.1255422 17.2452101,16.1273729 15.6862915,17.6862915 C14.1241943,19.2483887 14.1228979,21.7797521 15.6893022,23.3461564 L21.3431458,29 L15.6893022,34.6538436 C14.1228979,36.2202479 14.1241943,38.7516113 15.6862915,40.3137085 C17.2452101,41.8726271 19.7823965,41.8744578 21.3461564,40.3106978 L27,34.6568542 L32.6538436,40.3106978 C34.2176035,41.8744578 36.7547899,41.8726271 38.3137085,40.3137085 C39.8758057,38.7516113 39.8771021,36.2202479 38.3106978,34.6538436 L32.6568542,29 Z M27,53 C41.3594035,53 53,41.3594035 53,27 C53,12.6405965 41.3594035,1 27,1 C12.6405965,1 1,12.6405965 1,27 C1,41.3594035 12.6405965,53 27,53 Z" id="Oval-2" sketch:type="MSShapeGroup"></path></g></g></svg></div><div class="dz-edit"><a class="dz-edit-btn" href="#" data-path="'+ src +'" data-uid="P65o9qdO"><i class="fa fa-edit"></i></a></div><div class="dz-download"><a class="dz-download-btn" href="'+ src +'" data-path="'+ src +'" download=""><i class="fa fa-download"></i></a></div><a class="dz-remove" href="javascript:undefined;" data-dz-remove=""><i class="fa fa-times"></i></a></div>')
	var arr1 = [];
	$('.getsticker').each(function(i, obj) {
   console.log(obj.value);
   arr1.push(obj.value)
   console.log(arr1);
});
$('#stickers').val(arr1.toString());




});
//Save
$(document).on('click','#newEventSave',function(e){

//$('#newEventSave').on('click', function(e) {
		var form=$('#newEventForm'); 
		if (form[0].checkValidity() === false) {
			form.addClass('was-validated');
		  e.preventDefault();
		  e.stopPropagation();
		}
		else{
			 Dropzone.instances.forEach(function(item,index){
				var myID=$($(item)[0].element).attr('id').trim();
				if (myID=="dz-frames"){
					var files=$(item)[0].files;
					tFrames="";
					files.forEach(function(file,findex){
						if (file.href){
							tFrames+=file.href+"|";
						}
						else{
							tFrames+=file.previewElement.href+"|";
						}
					});
					tFrames = tFrames.substring(0, tFrames.length - 1);
					$('#frames').val(tFrames);
				}
				if (myID=="dz-backgrounds"){
					var files=$(item)[0].files;
					tBackgrounds="";
					files.forEach(function(file,findex){
						if (file.href){
							tBackgrounds+=file.href+"|";
						}
						else{
							tBackgrounds+=file.previewElement.href+"|";
						}
					});
					tBackgrounds = tBackgrounds.substring(0, tBackgrounds.length - 1);
					$('#backgrounds').val(tBackgrounds);
				}
				if (myID=="dz-stickers"){
					var files=$(item)[0].files;
					tStickers="";
					files.forEach(function(file,findex){
						if (file.href){
							tStickers+=file.href+"|";
						}
						else{
							tStickers+=file.previewElement.href+"|";
						}
					});
					tStickers = tStickers.substring(0, tStickers.length - 1);
					$('#stickers').val(tStickers);
				}
			});

			if ($(':radio[name="whitelabelurl"]:checked').val()=='default'){
				var whitelabelurl=$('#whitelabel-brand').val()+'.vbooth.me';
			}
			else if ($(':radio[name="whitelabelurl"]:checked').val()=='custom'){
				var whitelabelurl=$('#whitelabel-subdomain').val()+'.'+$('#whitelabel-domain').val();
			}
			else{
				var whitelabelurl="";
			}
			if ($(':radio[name="whitelabelemail"]:checked').val()=='default'){
				var whitelabelemail=$('#whitelabel-defaultemail').val()+'@vbooth.me';
			}
			else if($(':radio[name="whitelabelemail"]:checked').val()=='custom'){
				var whitelabelemail=$('#whitelabel-customemail').val();
			}
			else{
				var whitelabelemail="";
			}
			
			var data = form.serializeArray();
			data.push({name: 'whitelabelURL', value: whitelabelurl});
			data.push({name: 'whitelabelEmail', value: whitelabelemail});
			
			//str=$('#splashMessage')[0]['data-froala.editor'].html.get();
            str = "<p>virtual event</p>";
		data.push({name: 'splashMessage', value: str});
			//str=$('#thanksMessage')[0]['data-froala.editor'].html.get();
            str = "<p>virtual event</p>";
		data.push({name: 'thanksMessage', value: str});
			
			 
			 
			
			e.preventDefault();
			$.ajax({
				type: "POST",
				url: "{{ route('virtualboothEvents.store') }}",
				data: {
        "_token": "{{ csrf_token() }}",
        "data": data
        },
				success: function(response)
				{
					window.location.reload();

					// var jsonData = JSON.parse(response);
					// if (jsonData.success == 1 || isDuplicate==1){
					// 	var boothURL='/booth/' + jsonData.url;

					// 	$("#event-table tbody").append('<tr class="bg-light"><td><span class="eventName" data-url="' + jsonData.url + '">' + jsonData.name + ' </span><span class="pausedBadge"><span class="badge badge-pill badge-secondary">Paused</span></span></td><td class="text-center mobile-hide">0 <a href="#" class="gallery" data-tooltip="tooltip" data-placement="top" title="Gallery" data-url="' + jsonData.url + '"><i class="far far fa-images px-1"></i></a></td><td class="text-center mobile-hide">0 <a href="#" class="emails" data-tooltip="tooltip" data-placement="top" title="Download Emails" data-url="' + jsonData.url + '"><i class="far fa-envelope px-1"></i></a></td><td class="text-center mobile-hide">0</td><td class="text-center mobile-hide">0</td><td class="text-center mobile-sm"><a style="width:28.6px;"  href="#" data-toggle="modal" data-target="#startBooth" class="start"  data-url="' + jsonData.url + '" data-name="' + jsonData.name + '" data-whiteLabelURL="' + jsonData.whiteLabelURL + '" data-whiteLabelEmail="' + jsonData.whiteLabelEmail + '" data-tooltip="tooltip" data-placement="top" data-offset="-10, 0" title="Launch Booth"><i style="width:28.6px;" class="far fa-share-square " ></i></a><a style="width:28.6px;"  href="#" class="edit" data-tooltip="tooltip" data-placement="top" data-offset="-10, 0" title="Edit Event" data-toggle="modal" data-target="#newEvent" data-url="' + jsonData.url + '"><i style="width:28.6px;" class="far fa-edit " ></i></a><a href="#" class="duplicate edit" data-tooltip="tooltip" data-placement="top" data-offset="-10, 0" title="Duplicate Event" data-url="' + jsonData.url + '"><i class="far fa-clone "></i></a><a href="#" class="activate start" data-tooltip="tooltip" data-placement="top" data-offset="-10, 0" title="Start Event" data-url="' + jsonData.url + '"><i class="far fa-play-circle "></i></a><a style="width:28.6px;"  href="#" class="delete" data-tooltip="tooltip" data-placement="top" data-offset="-10, 0" title="Delete Event" data-url="' + jsonData.url + '"><i style="width:28.6px;" class="far fa-trash-alt px-1"></i></a></td></tr>');
					// 	$('[data-dismiss="modal"]').trigger('click');
					// 	$('#no-events').hide();
					// 	$('#event-table').show();

					// 	$('[data-tooltip="tooltip"]').tooltip({trigger : 'hover'});
					// 	Swal.fire({
					// 		  title:'Event Created!',
					// 		  html:'Click on the <i class="far fa-play-circle px-1" ></i> button to start your event.',
					// 		  icon: 'success'
					// 	})
					// }
					// else if (jsonData.success == 2){
					
					// 	$('.eventName[data-url="'+jsonData.url+'"]').html(jsonData.name);
					// 	var elem = $('[data-url="'+jsonData.url+'"]');
					// 	 $(elem).each(function(e,v){
					// 	 if($(this).data('target')=="#startBooth"){
					// 		$(this).attr('data-whiteLabelURL',jsonData.whiteLabelURL);
					// 	 }
						
					// 	$('[data-dismiss="modal"]').trigger('click');
					// 	})
					// }
					// else{
					// 	alert('Error');
					// }
					// isDuplicate=0;
					// $("#no-events").hide();
					// $("#event-table").show();
					
				},
				error: function() {
					alert('Error');
				//	isDuplicate=0;
				}
				
			});
		}
		 
		return false;
	});

var splide = new Splide( '#splide', {
  type   : 'loop',
  drag   : 'free',
  perPage: 3,
} );

splide.mount();
						</script>
@endpush

