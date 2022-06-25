{{ Form::open(array('route' => 'send.email','method' =>'post')) }}
<div class="row">
    
    <div class="form-group col-md-12">
        {{Form::label('name',__('Subject'))}}
        {{Form::hidden('id',$id,array('class'=>'form-control font-style','required'=>'required'))}}
        {{Form::text('subject',null,array('class'=>'form-control font-style','required'=>'required'))}}
    </div>

   
    <div class="col-12">
                                        <div class="form-group">
                                            {{Form::label('content',__('Email Message Body'))}}
                                            {{Form::textarea('content',null,array('class'=>'form-control','id'=>'summary-ckeditor','required'=>'required'))}}
                                        </div>
                                    </div>
     <div class="form-group col-md-12 ">
        {{Form::submit(__('Send'),array('class'=>'btn btn-lg btn-primary  pull-right rounded-pill'))}}
    </div>
</div>
{{ Form::close() }}
<script src="{{ asset('public/ckeditor/ckeditor.js') }}"></script>
<script type="text/javascript">
    
CKEDITOR.replace('summary-ckeditor');
    $(function () {    
    
    
  });

</script>