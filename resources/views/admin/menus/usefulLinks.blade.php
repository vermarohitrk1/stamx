<form action="{{ route('admin.storeMenu') }}" method="POST">
    @csrf
    <input type="hidden" name="slug" value="footer_widget_2">
    <input type="hidden" name="title" value="Useful Links">
    @php
	
		if(!empty($footerWidget2)){
        $menusLabels = array_key_exists("label",$footerWidget2) ? (array) $footerWidget2['label'] : [];
        $menusLinks = array_key_exists("link",$footerWidget2) ? (array) $footerWidget2['link'] : [];
		}
		else{
			
			  $menusLabels=array();
		    $menusLinks = array();
		}
			
    @endphp
    @for ($i = 1; $i < 6; $i++)
        <div class="row">
            <div class="col-6">
                <div class="form-group position-relative">
                    <label>Menu {{$i}} Link</label>
                   
					 <input name="menus[link][{{$i}}]" class="form-control" value="{{ array_key_exists($i,$menusLinks) ? $menusLinks[$i] : ''}}">
                </div> 
            </div>
            <div class="col-6">
                <div class="form-group position-relative">
                    <label>Menu {{$i}} Label </label>
                    <input name="menus[label][{{$i}}]" class="form-control" value="{{ array_key_exists($i,$menusLabels) ? $menusLabels[$i] : ''}}">
                </div>
            </div>
        </div> 
    @endfor
    <input type="submit" class="btn btn-primary" value="Submit">
</form>