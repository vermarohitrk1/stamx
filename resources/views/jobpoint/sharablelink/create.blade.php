{{ Form::open(['controller' => 'JobpointDashboardController@sharableLlink', 'method' => 'POST']) }}
<p class="text-secondary">Use this link to share this job with someone outside of application. Anyone with this link can apply to this job.</p>
<div class="text-right">
    <div class="form-control d-flex align-items-center">
        <span>{{ $url }}</span>
        <button type="button" class="btn btn-primary text-white width-90 ml-auto" onclick="copyToClipboard('{{ $url }}')">
            <span>Copy</span>
        </button>
    </div>
</div>
{{ Form::close() }}
<script type="text/javascript">
    function copyToClipboard(value) {
        var $temp = $("<input>");
        $("body").append($temp);
        $temp.val(value).select();
        document.execCommand("copy");
        $temp.remove();
        show_toastr('Success', "Text Copied Succcessfully", 'success');
    }
</script>
<link rel="stylesheet" type="text/css" href="{{ asset('assets/css/simcify.min.css') }}">
<script src="{{ asset('assets/js/simcify.min.js') }}"></script>

