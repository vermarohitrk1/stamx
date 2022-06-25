@extends('layout.commonlayout')
@section('content')		
<style>
.col-sm-8.col-lg-4.maianc {
    margin: 150px auto;
}

.h3 {
    font-size: 2.5rem !important;
}
</style>
<script type="text/javascript">
$( "#moreInfoSubmit" ).submit(function( event ) {
    if(!("#moreinfo").val())
        event.preventDefault();
        show_toastr('Error', '{{__('required.')}}', 'error');
});
</script>

@php
    $mainMenu = \App\Menu::get_menus();
 $logo =  \App\SiteSettings::logoSetting();

        if(!empty($logo)){
           $logo_favicon = json_decode($logo->value,true);
        }else{
            $logo_favicon = array();
        }
       $logoTxt=\App\SiteSettings::logotext();
@endphp
<div class="row main_">
<div class="col-sm-8 col-lg-4 maianc">
    <div class="text-center pb-4">
      
    </div>
    <div class="card shadow zindex-100 mb-0">
        <div class="card-body px-md-5 py-5">
            <div class="mb-4">
                <h6 class="h3">{{__('More Info')}}</h6>
                <p class="text-muted mb-0">@if(!empty($pagedetail->overview)) {{$pagedetail->overview}} @endif</p>
            </div>
            <span class="clearfix"></span>
            <form method="POST" action="{{ route('moreinfopost') }}" id="moreInfoSubmit"  enctype="multipart/form-data">
                @csrf
                <div class="form-group">
                    <div class="row">
                        <div class="col-md-12">
                            <label class="form-control-label">Please share your more info.</label>
                            <textarea class="form-control " name="moreinfo" id="moreinfo"  rows="5" placeholder="message" required>
                            </textarea>
                            <input type="hidden" name="sender" value="{{$pagedetail->sender}}">
                            <input type="hidden" name="type" value="moreinfo">
                            <input type="hidden" name="reciver" value="{{$pagedetail->reciver}}">
                        </div>
                    </div>
                </div>
                <div class="form-group mb-0">
                    <div class="mt-4">
                        <button type="submit" class="btn btn-lg btn-primary ">
                            <span class="btn-inner--text">{{__('Upload')}}</span>
                            <span class="btn-inner--icon"><i class="fas fa-long-arrow-alt-right"></i></span>
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
</div>
@endsection
