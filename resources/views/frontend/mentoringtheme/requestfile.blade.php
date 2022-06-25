@extends('layout.commonlayout')
	
<style>
.col-sm-8.col-lg-4.maianc {
    margin: 150px auto;
}

.h3 {
    font-size: 2.5rem !important;
}
</style>
@section('content')
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
                <h6 class="h3">{{__('Request File')}}</h6>
                <p class="text-muted mb-0">@if(!empty($pagedetail->overview)) {{$pagedetail->overview}} @endif</p>
            </div>
            <span class="clearfix"></span>
            <form method="POST" action="{{ route('requestfilepost') }}" enctype="multipart/form-data">
                @csrf
                <div class="form-group">
                    <div class="row">
                        <div class="col-md-12">
                            <label class="form-control-label">Upload Document</label>
                            <input type="file" class="form-control dropify" name="doc" accept=".xlsx,.xls,.doc,.docx,.pdf" required>
                            <p class="text-muted text-xs">PDF, EXCEL & WORD files only</p>
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
