<?php $page = "Pathway Entity"; ?>
@section('title')
    {{$page??''}}
@endsection

@extends('layout.dashboardlayout')
@section('content')	


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
                   <a href="{{ URL::previous() }}" class="btn btn-sm btn-primary float-right btn-icon-only rounded-circle " >
        <span class="btn-inner--icon"><i class="fas fa-reply"></i></span>
    </a>
                     </div>
   
<!-- Breadcrumb -->
<div class="breadcrumb-bar mt-3">
    <div class="container-fluid">
        <div class="row align-items-center">
            <div class="col-md-12 col-12">
                <h2 class="breadcrumb-title">Pathway Entity</h2>
                <nav aria-label="breadcrumb" class="page-breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Home</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('pathway.entities') }}">Pathway</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Pathway Entity</li>
                    </ol>
                </nav>
            </div>              
        </div>            
    </div>
</div>
<!-- /Breadcrumb -->





<div class="row mt-3" id="blog_view">
     <div class="col-12">
        <div class="card">
            <div class="card-body p-0">
                <form method="post" action="{{route('institution.post')}}" autocomplete="off" enctype="multipart/form-data" class="bv-form">
     @csrf
 <input class="form-control" type="hidden" value="{{!empty($institution->id) ? encrypted_key($institution->id, "encrypt"):''}}" name="id">
    <div class="form-group">
        <label>Entity Title</label>
        <input class="form-control" type="text" value="{{ $institution->institution??'' }}" name="institution" id="Institution" required="">
   </div>   
   
    <div class="form-group">
                <label class="form-control-label">Entity Type</label>
                <select id="type" class="form-control" name="type" @if(!empty($institution->type) && empty($institution->id)) readonly @endif>
                  
                    <option @if(!empty($institution->type) && $institution->type ==  "School") selected @endif value="School" > School</option>
                    <option  @if(!empty($institution->type) && $institution->type ==  "College") selected @endif value="College"> College</option>
                    <option @if(!empty($institution->type) && $institution->type ==  "Library") selected @endif value="Library"> Library</option>
                    <option @if(!empty($institution->type) && $institution->type ==  "Company") selected @endif value="Company"> Company</option>
                    <option @if(!empty($institution->type) && $institution->type ==  "PHA Community") selected @endif value="PHA Community"> PHA Community</option>
                    <option @if(!empty($institution->type) && $institution->type ==  "Mayor") selected @endif value="Mayor"> Mayor</option>
                    <option @if(!empty($institution->type) && $institution->type ==  "Justice Involved Officer") selected @endif value="Justice Involved Officer"> Justice Involved Officer</option>
                    <option @if(!empty($institution->type) && $institution->type ==  "Military Base") selected @endif value="Military Base"> Military Base</option>
             </select>
            </div>
    
                                             <div class="form-group">
                                                <label>Address (Search to fill address fields)</label>
                                                <input type="text" id="address" name="address" maxlength="250" class="form-control" value="{{ $institution->address??'' }}" required="" >
                                             </div>
                                       
                                          <!-- <div class="col-12 col-md-6">
                                             <div class="form-group">
                                                 <label>Address Line 2</label>
                                                 <input type="text" name="address2" maxlength="250" class="form-control" value="">
                                             </div>
                                             </div> -->
                                          <div class="row">
                                          <div class="col-12 col-md-6">
                                             <div class="form-group">
                                                <label>City</label>
                                                <input type="text" readonly="" id="address_city" name="city" maxlength="40"  class="form-control" value="{{ $institution->city??'' }}">
                                             </div>
                                          </div>
                                          <div class="col-12 col-md-6">
                                             <div class="form-group">
                                                <label>State</label>
                                                <input type="text" readonly="" name="state" id="address_state" maxlength="40"  class="form-control" value="{{ $institution->state??'' }}">
                                             </div>
                                          </div>
                                          <div class="col-12 col-md-6">
                                             <div class="form-group">
                                                <label>Zip Code</label>
                                                <input type="number" readonly="" id="address_zip_code" class="form-control" step="1" min="0" name="postal_code" value="{{ $institution->zip??'' }}">
                                             </div>
                                          </div>
                                          <div class="col-12 col-md-6">
                                             <div class="form-group">
                                                <label>Country</label>
                                                <input type="text" class="form-control" id="country" maxlength="40"  name="country" value="{{ $institution->country??'' }}" readonly="">
                                             </div>
                                          </div>
                                          <div class="col-12 col-md-6">
                                             <div class="form-group">
                                                <label>Address Lat</label>
                                                <input type="text" class="form-control" id="address_lat" maxlength="40"  name="address_lat" value="{{ $institution->lat??'' }}" readonly="">
                                             </div>
                                          </div>
                                          <div class="col-12 col-md-6">
                                             <div class="form-group">
                                                <label>Address Long</label>
                                                <input type="text" class="form-control" id="address_long" maxlength="40"  name="address_long" value="{{ $institution->long??'' }}" readonly="">
                                             </div>
                                          </div>
                                          </div>
                                          @if(Auth::user()->type=="admin")
           <div class="form-group">
                <label class="form-control-label">Status</label>
                <select id="status" class="form-control" name="status">
                    <option  value="0" @if(!empty($institution->id) && $institution->status == null ) selected @endif> Pending</option>
                    <option value="1" @if(!empty($institution->id) &&  $institution->status == 1 ) selected @endif> Accepted</option>
                    <option value="2" @if(!empty($institution->id) &&  $institution->status == 2 ) selected @endif> Rejected</option>
             </select>
            </div>
                                          @endif

    <div class="mt-4 float-right">
        <button class="btn btn-primary" name="form_submit" value="submit" type="submit">Add</button>
    </div>
</form>
            </div>
        </div>
    </div>





            </div>
        </div>

    </div>

</div>		
<!-- /Page Content -->
@endsection
@push('script')
<script
   src="https://maps.googleapis.com/maps/api/js?key=AIzaSyCRm6AkA1BWf6Scex-ZqIHMptuN3A4_loQ&callback=initAutocomplete&libraries=places"
   async
   ></script>

<script type="text/javascript">
   let autocomplete;
   let address1Field;
   let address2Field;
   let address11Field;
   let address22Field;

   let corporateautocomplete;
   let corporateaddress1Field;
   let corporateaddress2Field;
   let corporateaddress11Field;
   let corporateaddress22Field;

   function initAutocomplete() {
     address1Field = document.querySelector("#address");
     address2Field = document.querySelector("#address_street");



     // Create the autocomplete object, restricting the search predictions to
     // addresses in the US and Canada.
     autocomplete = new google.maps.places.Autocomplete(address1Field, {
       componentRestrictions: { country: ["us"] },
       fields: ["address_components", "geometry"],
       types: ["address"],
     });
    address1Field.focus();

  

     // When the user selects an address from the drop-down, populate the
     // address fields in the form.
     autocomplete.addListener("place_changed", fillInAddress);
   }

   function fillInAddress() {
     // Get the place details from the autocomplete object.

     document.querySelector("#address_lat").value =autocomplete.getPlace().geometry.location.lat();
     document.querySelector("#address_long").value =autocomplete.getPlace().geometry.location.lng();
     const place = autocomplete.getPlace();
     let address1 = "";
     let address11 = "";

     for (const component of place.address_components) {
       const componentType = component.types[0];

       switch (componentType) {
         case "street_number": {
           address1 = `${component.long_name} ${address1}`;
           break;
         }
         case "route": {
           address1 += component.short_name;
           break;
         }
         case "locality":
           document.querySelector("#address_city").value = component.long_name;
           break;
         case "administrative_area_level_1": {
           document.querySelector("#address_state").value = component.long_name;
           break;

         }
         case "postal_code": {
           document.querySelector("#address_zip_code").value = component.short_name;
           break;
       }
         case "country": {
           document.querySelector("#country").value = component.short_name;
           break;
         }
       }
     }
    // address2Field.value = address1;
   }
   

</script>
@endpush