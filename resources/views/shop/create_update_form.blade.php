<?php $page = "Shop"; ?>
@section('title')
    {{$page??''}}
@endsection
@extends('layout.dashboardlayout')
@section('content')	

     @php
        $user=Auth::user();
        $permissions=permissions();
        @endphp
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
               
       <a  class="btn btn-sm btn btn-primary float-right ml-2 " href="{{ route('shop.index')}}"  >
        <span class="btn-inner--icon"><i class="fa fa-reply"></i></span> 
    </a>
                   
                     </div>
                
   <!-- Breadcrumb -->
                <div class="breadcrumb-bar mb-3">
                    <div class="container-fluid">
                        <div class="row align-items-center">
                            <div class="col-md-12 col-12">
                                <h2 class="breadcrumb-title">Shop Product</h2>
                                <nav aria-label="breadcrumb" class="page-breadcrumb">
                                    <ol class="breadcrumb">
                                        <li class="breadcrumb-item"><a href="{{route('dashboard')}}">Dashboard</a></li>
                                        <li class="breadcrumb-item"><a href="{{route('shop.dashboard')}}">Shop Dashboard</a></li>
                                        <li class="breadcrumb-item active" aria-current="page">Shop Product</li>
                                    </ol>
                                </nav>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- /Breadcrumb -->
                
   

   
<div class="row mt-3" id="blog_category_view"  >
     
    
  <!-- list view -->
  <div class="col-12">
      <div class="card">
                <div class="card-header">

                    <h3>{{ !empty($product->title) ? $product->title : ""}}</h3>
                    <p class="text-muted mb-0">{{!empty($product->description) ? strip_tags($product->description) :''}}</p>
                </div>
                <div class="card-body">
                    {{ Form::open(['route' => 'shop.store','name' => 'new_input_form','id' => 'new_input_form','enctype' => 'multipart/form-data']) }}
                    <input type="hidden" name="id" value="{{!empty($product->id) ? encrypted_key($product->id,'encrypt') :0}}" />
                    <input type="hidden" name="csrf-token" value="<?= csrf_token(); ?>" />
                    @if ($errors->any())
                    <div class="alert alert-danger">
                        <ul>
                            @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                    @endif
                    <div class="form-group">
        <div class="row">
            <div class="col-md-12">
                <label>Product title</label>
                <input type="text" class="form-control" name="title" value="{{!empty($product->title) ? $product->title :''}}"  placeholder="Product title" required>
            </div>
        </div>
    </div>
    <div class="form-group">
        <div class="row">
            <div class="col-md-12">
                <label>SKU</label>
                <input type="text" class="form-control" name="sku" value="{{!empty($product->sku) ? $product->sku :''}}" placeholder="SKU" required>
            </div>
        </div>
    </div>
    <div class="form-group">
        <div class="row">
            <div class="col-md-6">
                <label>Type</label>
                <select class="form-control" name="type">
                    <option value="Book" @if(!empty($product->type ) && $product->type == "Book") selected @endif>Book</option>
                    <option value="Online Program" @if(!empty($product->type ) && $product->type == "Online Program") selected @endif>Online Program</option>
                    <option value="Kit" @if(!empty($product->type ) && $product->type == "Kit") selected @endif>Kit</option>
                    <option value="Other" @if(!empty($product->type ) && $product->type == "Other") selected @endif>Other</option>
                </select>
            </div>
            <div class="col-md-6">
                <label>Status</label>
                <select class="form-control" name="status">
                    <option value="Published" @if(!empty($product->status ) && $product->status == "Published") selected @endif>Published</option>
                    <option value="Unpublished" @if(!empty($product->status ) && $product->status == "Unpublished") selected @endif>Unpublished</option>
                </select>
            </div>
        </div>
    </div>
    <div class="form-group">
        <div class="row">
            <div class="col-md-6">
                <label>Price ($)</label>
                <input type="number" class="form-control" min="0.00" step="0.01" data-parsley-pattern="^[0-9]*\.[0-9]{2}$" name="price" value="{{!empty($product->price) ? $product->price :''}}"   placeholder="Price ($)" required>
            </div>
            <div class="col-md-6">
                <label>Special Price ($)</label>
                <input type="number" class="form-control" min="0.00" step="0.01" data-parsley-pattern="^[0-9]*\.[0-9]{2}$" name="special_price"  value="{{!empty($product->special_price) ? $product->special_price :''}}"  placeholder="Price  ($)" required="">
                <small>Note: Must be less then actual price to attract customers</small>
            </div>
        </div>
    </div>
      
<!--    <div class="form-group">
        <div class="row">
            <div class="col-md-12">
                <label>Commision Points</label>
                <input type="number" class="form-control" min="1"  data-parsley-pattern="^[0-9]*\.[0-9]{2}$" name="commision_points" value="{{!empty($product->commision_points) ? $product->commision_points :''}}"   placeholder="points" required>
            </div>
        </div>
    </div>-->
    
    <div class="form-group">
        <div class="row">
            <div class="col-md-6">
                <label>Quantity</label>
                <input type="number" class="form-control"  name="quantity" value="{{!empty($product->quantity) ? $product->quantity :''}}" min="0"   placeholder="Quantity" required>
            </div>
            <div class="col-md-6">
                <label>Stock status</label>
                <select class="form-control" name="stock_status">
                    <option value="">Please Select </option>
                    <option value="1" @if(!empty($product->stock_status ) && $product->stock_status == '1') selected @endif > In Stock </option>
                    <option value="2" @if(!empty($product->stock_status ) && $product->stock_status == '2') selected @endif > Out Stock </option>
                </select>                                    
            </div>
        </div>
    </div>
    <div class="form-group">
        <div class="row">
            <div class="col-md-12">
                <label>Tags</label>
                <input type="text" class="form-control" name="tags" value="{{!empty($product->tags) ? $product->tags :''}}" placeholder="Tags" required>
                <small>Comma separated values.</small>
            </div>
        </div>
    </div>
                    
                    
                    
                    <div class="form-group">
        <div class="row">
            <div class="col-md-12">
                <label>Category</label>
                <select class="form-control" name="category">
                    <option value="0">Please Select Category</option>
                    @if(!empty($categories))
                    @foreach($categories as $category)
                    <option value="{{ $category->id }}" @if(!empty($productcategories) && in_array($category->id, $productcategories)) selected @endif>{{ $category->name }}</option>
                    @endforeach
                    @endif
                </select>
            </div>
        </div>
    </div>
                    <div class="form-group">
        <div class="row">
            <div class="col-md-12">
                <label> Image</label>
                <input type="file" name="image" class="form-control croppie" crop-width="600" crop-height="600"   accept="image/*" >
            </div>
        </div>
    </div>
                   
                    
    
                    
@if(!empty($img_collection))
<div class="newImage">

    </div>
<!--    <div class="form-group">
        <div class="row">
            <div class="col-md-12">
                <input class="btn btn-primary addImage" type="button"  name="addImages" value="Add More Image">
            </div>
        </div>
    </div>-->
    <table>
        <tr>
            @foreach($img_collection as $index => $images)
            <td id="tr{{ $images->id }}" >
                <img src="{{asset('storage/shop')}}/{{ $images->img_url }}" width="100" height="100" class="img-responsive table-image" id="imageSizeFix">

                <a href="javascript:void(0)" class="text-danger" onclick="callme({{ $images->id }});" ><i class="fa fa-trash-alt" id="iconimageSizeFix"></i></a>
            </td>
            <td> &nbsp;&nbsp;</td>
            @endforeach
        </tr>
    </table>
@endif
                    <div class="form-group">
        <div class="row">
            <div class="col-md-12">
                <label>Product Description</label>
                <textarea class="form-control summernote" id="description" name="description" placeholder="Product Description" rows="8" required>{{!empty($product->description) ? $product->description :''}}</textarea>
            </div>
        </div>
    </div>

    <!--edit value-->
    <div class="form-group">
        <div class="row">
            <div class="col-md-12">
                <label>Vendor Description</label>
                <textarea type="text" class="form-control summernote" name="vendor" placeholder="Vendor Description" rows="5" required>{{!empty($product->vendor) ? $product->vendor :''}}</textarea>
            </div>
        </div>
    </div>

                    <h5>Specification</h5>
     @if(!empty($specification))
    @foreach($specification as $_specification)
    <div class="form-group main_inputs">
        <div class="row">
            <div class="col-md-5">
                <label>Add your field</label>
                <input type="text" name="fieldtitle[]" class="form-control" value="{{$_specification->title}}" placeholder="Title">
            </div>
            <div class="col-md-5">
                <label>Add your value</label>
                <input type="text" name="value[]" class="form-control" value="{{$_specification->value}}" placeholder="value">
            </div>
            <div class="col-md-2" style="position: relative;top: 50px;">
                
                    <a href="javascript:void(0)" class="add_input text-danger "><i class="fa fa-trash-alt"></i>
                    </a>
                
            </div>
        </div>
    </div>
    @endforeach
    @else
    <div class="form-group main_inputs">
        <div class="row">
            <div class="col-md-5">
                <label>Add your field</label>
                <input type="text" name="fieldtitle[]" class="form-control" value="" placeholder="Title">
            </div>
            <div class="col-md-5">
                <label>Add your value</label>
                <input type="text" name="value[]" class="form-control" value="" placeholder="value">
            </div>
            <div class="col-md-2" style="position: relative;top: 50px;">
                
                    <a href="javascript:void(0)" class="add_input text-danger "><i class="fa fa-trash-alt"></i>
                    </a>
                
            </div>
        </div>
    </div>
    @endif

    <div class="add_field">

    </div>
    <div class="form-group">
        <div class="row">
            <div class="col-md-6">
                <button type="button" class="btn btn-primary addfield" >Add Fields</button>
            </div>
        </div>
    </div>

<!--                    <div class="form-group">
        <div class="row">
            <div class="col-md-12">
                <label>Products Attributes</label>
                @if(!empty($product->id))
                @foreach(\App\ProductAttribute::get_product_attribute(!empty($product->id) ? $product->id :'') as $productAttributesList)
                <label>{{ $productAttributesList->title }}</label>
                <select class="form-control select2-dynamic" name="productAttributes[{{$productAttributesList->id}}][]" multiple>
                    @foreach(get_product_attribute_options($productAttributesList->id) as $product_attribute_options)
                    <option value="{{ $product_attribute_options->id }}" @if(!empty($attributesIds) && in_array($product_attribute_options->id, $attributesIds)) selected @endif>{{ $product_attribute_options->title }}</option>
                    @endforeach
                </select>
                @endforeach
                @else
                
                @endif
            </div>
        </div>
    </div>-->
        <div class="form-group">
        <div class="row">
            <div class="col-md-12">
                <label>Brand</label>
                <select class="form-control" name="brand">
                    <option value="0">Please Select  Brand</option>
                    @foreach(\App\ProductBrand::get_brand(!empty($product->id) ? $product->id :'') as $brand)
                    <option value="{{ $brand->id }}" @if(!empty($product->brand) && $brand->id==$product->brand) selected @endif>{{ $brand->title }}</option>
                    @endforeach
                </select>
            </div>
        </div>
    </div>
    <!--edit value-->
    <div class="form-group">
        <div class="row">
            <div class="col-md-12">
                <label>Shipping Options</label>
                <select class="form-control select2" name="shipping_options[]" multiple>
                    <option value="Fedex" @if(!empty($shipping_options) && in_array('Fedex', $shipping_options)) selected @endif>Fedex</option>
                    <option value="UPS" @if(!empty($shipping_options) && in_array('UPS', $shipping_options)) selected @endif>UPS</option>
                    <option value="USPS" @if(!empty($shipping_options) && in_array('USPS', $shipping_options)) selected @endif>USPS</option>
                    <option value="DHL" @if(!empty($shipping_options) && in_array('DHL', $shipping_options)) selected @endif>DHL</option>
                </select>
            </div>
        </div>
    </div>
    <div class="form-group">
        <div class="row">
            <div class="col-md-12">
                <label>Refund disclaimer</label>
                <textarea class="form-control" name="refund_disclaimer" placeholder="Refund disclaimer" maxlength="1000" rows="3" required>{{ !empty($product->refund_disclaimer) ? $product->refund_disclaimer :'' }}</textarea>
            </div>
        </div>
    </div>
         <div class="form-group">
        <div class="row">
            <div class="col-md-12">
                <label>FAQs</label>
                <textarea class="form-control summernote" id="faqs" name="faqs" placeholder="Please enter FAQs" rows="8" required>{{!empty($product->faqs) ? $product->faqs :''}}</textarea>
            </div>
        </div>
    </div>     

                <div class="text-right">
                    {{ Form::button(__('Save Product'), ['type' => 'submit','class' => 'btn btn-sm btn-primary rounded-pill']) }}
                    <a href="{{ route('shop.index') }}">
                        <button type="button" class="btn btn-sm btn-secondary rounded-pill">{{__('Back')}}</button>
                    </a>
                </div>

                {{ Form::close() }}

            </div>
        </div>
  </div> 
    <!-- list view -->
</div>
    

            </div>
        </div>

    </div>
</div>		
<!-- /Page Content -->
@endsection
@push('script')
<script src="{{ asset('assets/libs/dragula/dist/dragula.min.js') }}"></script>
  

    <script type="text/javascript" src="{{ asset('assets/js/jquery-ui.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('assets/js/repeater.js') }}"></script>

   
    
    
<link rel="stylesheet" type="text/css" href="{{ asset('assets/css/simcify.min.css') }}">
<script src="{{ asset('assets/js/simcify.min.js') }}"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.1/jquery.validate.min.js" ></script>

<script src="{{ asset('public/ckeditor/ckeditor.js') }}"></script>

 <script>
        CKEDITOR.replace('description');
        CKEDITOR.replace('vendor');
        CKEDITOR.replace('faqs');
    </script>
<script>
 $(document).on('click','body .addImage',function(){
        var html='<div class="form-group"><div class="row"><div class="col-md-11"><label>Section Image</label><input type="file" name="image" class="form-control croppie upload-result" crop-width="600" crop-height="600"   accept="image/*" required=""></div><div class="col-md-1 divbutton"><a href="javascript:void(0)"  class="add action-item text-danger ml-auto px-2 mt-3"  ><i class="fas fa-trash-alt"></i></a></div></div></div>';
        $(".newImage").append(html);
    });
    
    $(document).on('click','body #addImagesUpdate',function(){
        var html='<div class="form-group"><div class="row"><div class="col-md-6"><label>Section Image</label><input type="file" name="image[]" class="form-control "  accept="image/*" ><a href="javascript:void(0)"  class="add action-item text-danger ml-auto px-2 mt-3" ><i class="fas fa-trash-alt"></i></a></div></div></div>';
        $("#newImageUpdate").append(html);
    });
    // add feild section
    $(document).on('click','body .addfield',function(){
        var htmlfeild = '<div class="form-group main_inputs"><div class="row"><div class="col-md-5"><label>Add your field</label><input type="text" name="fieldtitle[]" class="form-control" placeholder="Title"></div><div class="col-md-5"><label>Add your value</label><input type="text" name="value[]" class="form-control" placeholder="value"></div><div class="col-md-2" style="position: relative;top: 32px;"><a href="javascript:void(0)" class="add_input add action-item text-danger ml-auto px-2 mt-3"><i class="fas fa-trash-alt"></i></a></div></div></div>';
        $('.add_field').append(htmlfeild);
    });
     $(document).on('click', ".add_input", function() {
        $(this).closest('div.main_inputs').remove();
    });
     $(document).on('click', "a.add", function() {
    $(this).closest('div.form-group').remove();
    //   $(".form-group").remove();
    // alert('hi');        
    });
    
    
    function callme(id) {
        var url="{{ route('shop.productdeleteimg') }}";
        $.ajax({
            "type"        : 'POST', 
            "url"         :  url, 
            "data"        : {'id':id}, 
            "dataType"    : 'json', 
            "encode"      : true
        })
        .done(function(data) {
            if(data=='1'){
                $("#tr"+id).remove();
            }
        });

    }
    
$(function () {

    // Initialize form validation on the form.
    $("form[name='new_input_form']").validate({
        // Specify validation rules
        rules: {
            title: {
                required: true,
                minlength: 5,
                maxlength: 255

            },
            amount: {
                required: true,
                number: true,
                min: 1
            }
        },
        // Specify validation error messages
        messages: {
            title: {
                required: "*Required",
                maxlength: "It should be 5-255 character alphanumeric including spaces, numbers, as well as hyphens(-) and single quote character(')",
                minlength: "It should be 5-255 character alphanumeric including spaces, numbers, as well as hyphens(-) and single quote character(')"
            },
            amount: {
                required: "*Required",
                number: "Please enter currency amount i.e $5.00",
                min: "Minimum amount $1.00 required"
            }
        },
        // Make sure the form is submitted to the destination defined
        // in the "action" attribute of the form when valid
        submitHandler: function (form) {
            form.submit();
        }
    });
});
</script>
<style>
    .addImage {
        position: relative;
        min-height: 24px;
    }
    .addImage input{
        position: absolute;
        right: 14px;
    }
    .mdi-window-close{
        color:red;
    }
    .inputWidth{
        width: 550px;
    }
    .divbutton{
        position: relative;
        top: 32px;
    }

    </style>
    
@endpush
